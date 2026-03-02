<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Vendor Information';
do_datatable('vendor_table');
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
$payable=find_a_field('config_group_class','payable',"1");
$vendor_id		= $_REQUEST['vendor_id'];
$vendor_name	= $_REQUEST['vendor_name'];
$vendor_name	= str_replace("'","`",$vendor_name);
$vendor_name	= str_replace("&","and",$vendor_name);
$vendor_name	= str_replace('"','``',$vendor_name);
$vendor_company	= $_REQUEST['vendor_company'];
$vendor_bank		= $_REQUEST['vendor_bank'];
$vendor_bank_ac		= $_REQUEST['vendor_bank_ac'];
$branch_name	= $_REQUEST['branch_name'];
$iban_no	= $_REQUEST['iban_no'];
$swift_code	= $_REQUEST['swift_code'];
$group_for	= $_REQUEST['group_for'];
$ledger_id	= $_REQUEST['ledger_id'];
$vendor_category	= $_REQUEST['vendor_category'];
$country	= $_REQUEST['country'];
$contact_no	= $_REQUEST['contact_no'];
$fax_no	= $_REQUEST['fax_no'];
$email	= $_REQUEST['email'];
$address	= $_REQUEST['address'];
$status	= $_REQUEST['status'];
$now			= time();
//end 
if(isset($_POST['nvendor']))
{
	$check="select vendor_id from vendor where vendor_name='$vendor_name' limit 1";
	if(mysqli_num_rows(db_query($check))>0)
	{
		$aaa=mysqli_num_rows(db_query($check));
		$vendor_id=$aaa[0];
			$type=0;
			$msg='Given Name('.$vendor_name.') is already exists.';
	}
	else
	{
		$vendor_id=number_format(next_sub_ledger_id($payable), 0, '.', '');
		//sub_ledger_create($vendor_id,$vendor_name, $payable, '0.00', $now, $proj_id);
		//ledger_create($vendor_id,$vendor_name,$payable,'0.00','Both','','', time(),$proj_id,'NO');
		$sql="INSERT INTO `vendor` (	
vendor_name,
vendor_company,
vendor_bank,
vendor_bank_ac,
branch_name,
iban_no,
swift_code,
group_for,
ledger_id,
vendor_category,
country,
contact_no,
fax_no,
email,
address,
status
		)
		VALUES ('$vendor_name', '$vendor_company', '$vendor_bank', '$vendor_bank_ac', '$branch_name','$iban_no' ,'$swift_code' ,'$group_for' ,'$ledger_id' ,'$vendor_category' ,'$country' ,'$contact_no' ,'$fax_no' ,'$email' ,'$address' ,'$status' )";
		//echo $sql;
		$query=db_query($sql);
		$type=1;
		$msg='New Entry Successfully Inserted.';
	}
}


if(isset($_POST['mvendor']))
{
$search_sql="select 1 from vendor where `vendor_id`!='$vendor_id' and `vendor_name` = '$vendor_name' limit 1";
if(mysqli_num_rows(db_query($search_sql))==0)
	{
		$sql="UPDATE `vendor` SET
							`vendor_name`		= '$vendor_name', 
							`vendor_company` 	= '$vendor_company',
							`vendor_bank` 			= '$vendor_bank',
							`vendor_bank_ac` 		= '$vendor_bank_ac',
							`branch_name` 		= '$branch_name',
							`iban_no`='$iban_no',
							`swift_code`='$swift_code',
							`group_for`='$group_for',
							`ledger_id`='$ledger_id',
							`vendor_category`='$vendor_category',
							`country`='$country',
							`contact_no`='$contact_no',
							`fax_no`='$fax_no',
							`email`='$email',
							`address`='$address',
							`status`='$status'
							
							 WHERE 
							 `vendor_id` 		= $vendor_id LIMIT 1";
		$qry=db_query($sql);
//$sql2="UPDATE `accounts_ledger` SET 
//`ledger_name` 		= '$vendor_name'	
//WHERE `ledger_id` 		='$vendor_id' LIMIT 1";
//$sql="UPDATE `sub_ledger` SET
//`sub_ledger` = '$vendor_name'
//WHERE `sub_ledger_id` =$vendor_id LIMIT 1";
//$query=db_query($sql);
//$query=db_query($sql2);
		$type=1;
		$msg='Successfully Updated.';
	}
		else
	{
	$type=0;
	$msg='Given Name('.$vendor_name.') is already exists.';
	}
}
if(isset($_POST['dvendor']))
{

$sql="delete from `vendor` where `vendor_id`='$vendor_id' limit 1";
$query=db_query($sql);
//$sql="delete from `sub_ledger` where `sub_ledger_id`='$vendor_id' limit 1";
//$query=db_query($sql);
//$sql="delete from `accounts_ledger` where `ledger_id`='$vendor_id' limit 1";
//$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_REQUEST['vendor_id']))
{
	$vendor_id	= $_REQUEST['vendor_id'];
	$ddd		= "SELECT * FROM vendor WHERE vendor_id='$vendor_id' AND 1";
	$data		= mysqli_fetch_row(db_query($ddd));
}
?><script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'vendor_info.php?vendor_id='+theUrl;
}

</script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    <td width="66%" style="padding-right:5%">
	<div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="40%" align="right">Vendor Name</td>
                                        <td width="60%" align="right"><input name="vendor" type="text" id="vendor" value="<?php echo $_REQUEST['vendor']; ?>" size="20" /></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Company Name</td>
                                        <td align="right"><input name="com_name" type="text" id="com_name" value="<?php echo $_REQUEST['com_name']; ?>" size="20" /></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2"><input class="btn" name="search" type="submit" id="search" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td width="66%" style="padding-right:5%">
	<div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>
									<table id="vendor_table" class="table table-bordered" cellspacing="0">
									<thead>
							  <tr>
								<th width="83" bgcolor="#45777B"><span class="style1">Vendor ID</span></th>
								<th width="85" bgcolor="#45777B"><span class="style1">Vendor Name </span></th>
								<th width="62" bgcolor="#45777B"><span class="style1">Category</span></th>
							    <th width="51" bgcolor="#45777B"><span class="style1">Company</span></th>
							  </tr>
							  </thead>
							  
							  <tbody>
<?php
	 $rrr = "SELECT 
					  a.vendor_id,
					  a.vendor_name,
					  b.category_name,
					  c.group_name
					FROM
					  vendor a,
					  vendor_category b,
					  user_group c
					WHERE
			 a.vendor_category = b.id and a.group_for=c.id and a.group_for=".$_SESSION['user']['group']." order by  a.vendor_id";
	

	$report = db_query($rrr);
	$i=0;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>
								<td><?=$rp[2];?></td>
							    <td><?=$rp[3];?></td>
							   </tr>
							   
	<?php }?></tbody>
							</table>									</td>
							
							
								  </tr>
								</table>

							</div></td>
								  </tr>
								</table>

							</div></td>
    <td><div class="right">  <form id="form2" name="form2" method="post" action="vendor_info.php?vendor_id=<?php echo $vendor_id;?>" onsubmit="return check()">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
									
									
									  
									  <tr>
                                        <td>Vendor Name: </td>
                                        <td>
										<input name="vendor_id" type="hidden" id="vendor_id" value="<?php echo $data[0];?>" size="30" maxlength="100" />
										<input name="vendor_name" type="text" id="vendor_name" value="<?php echo $data[4];?>" size="30" maxlength="100" /></td>
									  </tr>
									
                                      <tr>
                                        <td>Beneficiary Name: </td>
                                        <td><input name="vendor_company" type="text" id="vendor_company" value="<?php echo $data[6];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Beneficiary Bank: </td>
                                        <td><input name="vendor_bank" type="text" id="vendor_bank" value="<?php echo $data[7];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Account No: </td>
                                        <td><input name="vendor_bank_ac" type="text" id="vendor_bank_ac" value="<?php echo $data[9];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Branch Name: </td>
                                        <td><input name="branch_name" type="text" id="branch_name" value="<?php echo $data[8];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>IBAN: </td>
                                        <td><input name="iban_no" type="text" id="iban_no" value="<?php echo $data[10];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Swift Code: </td>
                                        <td><input name="swift_code" type="text" id="swift_code" value="<?php echo $data[11];?>" size="30" maxlength="100" /></td>
									  </tr>

                                      <tr>
                                        <td>Company:</td>
                                        <td>
										
										<select name="group_for" id="group_for">
			<? 
			if($_SESSION['user']['group']>1)
			$sql="SELECT id ,group_name FROM user_group where id=".$_SESSION['user']['group']." order by id";
			else
			$sql="SELECT id ,group_name FROM user_group order by id";
			$led=db_query($sql);
			if(mysqli_num_rows($led) > 0)
			{
			while($ledg = mysqli_fetch_row($led)){?>
	<option value="<?=$ledg[0]?>" <?php if($data[2]==$ledg[0]) echo " Selected "?>><?=$ledg[0].':'.$ledg[1]?>
	</option>
			<? }}?>
			</select>
			<input name="ledger_id" type="hidden" id="ledger_id" value="2001000100000000" size="20" maxlength="16" />
										
										</td>
									  </tr>
									  
									  <tr>
                                        <td>Category:</td>
                                        <td>
										
										<select name="vendor_category" id="vendor_category">
			<? 
			
			$sql="SELECT id ,category_name FROM vendor_category where 1 order by id";
			
			$led=db_query($sql);
			if(mysqli_num_rows($led) > 0)
			{
			while($ledg = mysqli_fetch_row($led)){?>
	<option value="<?=$ledg[0]?>" <?php if($data[5]==$ledg[0]) echo " Selected "?>><?=$ledg[1]?>
	</option>
			<? }}?>
			</select>
			
										
										</td>
									  </tr>
									  
									  
									  <tr>
                                        <td>Country:</td>
                                        <td>
										
										<select name="country" id="country">
										<option></option>
			<? 
			
			$sql="SELECT id ,country_name FROM country where 1 order by country_name";
			
			$led=db_query($sql);
			if(mysqli_num_rows($led) > 0)
			{
			while($ledg = mysqli_fetch_row($led)){?>
			
	<option value="<?=$ledg[0]?>" <?php if($data[17]==$ledg[0]) echo " Selected "?>><?=$ledg[1]?>
	</option>
			<? }}?>
			</select>
			
										
										</td>
									  </tr>
									  
									  
									  <tr>
                                        <td>Contact No: </td>
                                        <td><input name="contact_no" type="text" id="contact_no" value="<?php echo $data[13];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Fax No: </td>
                                        <td><input name="fax_no" type="text" id="fax_no" value="<?php echo $data[15];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>E-mail: </td>
                                        <td><input name="email" type="text" id="email" value="<?php echo $data[16];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Address: </td>
                                        <td><input name="address" type="text" id="address" value="<?php echo $data[12];?>" size="30" maxlength="100" /></td>
									  </tr>
									  

                                      
                                       <tr>
                                        <td>Status: </td>
                                        <td><select name="status" id="status">
                                     <option value="ACTIVE"<?php if($data[21]=='ACTIVE') echo " Selected "?>>ACTIVE</option>
                                    <option value="INACTIVE"<?php if($data[21]=='INACTIVE') echo " Selected "?>>INACTIVE</option>
                                         
                                        </select>
										
										
										
										</td>
                                      </tr>
									  
									  
									  
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
									  <? if($data[0]==""){?>
									  <input name="nvendor" type="submit" id="nvendor" value="Record" class="btn"/><? }?></td>
                                      <td>
									   <? if($data[0]!=""){?>
									  <input name="mvendor" type="submit" id="mvendor" value="Modify" class="btn"/><? }?></td>
                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='vendor_info.php'"/></td>
                                      <td><input class="btn" name="dvendor" type="submit" id="dvendor" value="Delete"/></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>
<script type="text/javascript">

function DoNav(theUrl)



{



	document.location.href = 'vendor_info.php?vendor_id='+theUrl;



}



function popUp(URL) 



{



	day = new Date();



	id = day.getTime();



	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");



}



</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>