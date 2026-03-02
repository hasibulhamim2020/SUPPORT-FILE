<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Customer Information';
$proj_id=$_SESSION['proj_id'];

$customer_id=$_REQUEST['customer_id'];
$customer_name=$_REQUEST['customer_name'];
$customer_name		= str_replace("'","",$customer_name);
$customer_name		= str_replace("&","",$customer_name);
$customer_name		= str_replace('"','',$customer_name);
$customer_company=$_REQUEST['customer_company'];
$address=$_REQUEST['address'];
$contact=$_REQUEST['contact'];
$customer_type=$_REQUEST['customer_type'];
$now=time();

if(isset($_POST['ncustomer']))
{
$check="select customer_id from customer where customer_name='$customer_name' limit 1";

if(mysqli_num_rows(db_query($check))>0)
{

	$aaa=mysqli_num_rows(db_query($check));

	$customer_id=$aaa[0];

	$type=0;

	$msg='Given Name('.$customer_name.') is already exists.';

}

else

{

$sql="INSERT INTO `customer` (
`customer_name` ,
`customer_company` ,
`address` ,
`proj_id` ,
`contact_no` ,
`customer_type`
)
VALUES ('$customer_name', '$customer_company', '$address', '$proj_id','$contact','$customer_type')";

$query=db_query($sql);

		$type=1;

		$msg='New Entry Successfully Inserted.';

}

}





//for Modify..................................



if(isset($_POST['mcustomer']))

{

$search_sql="select 1 from accounts_ledger where `ledger_id`!='$customer_id' and `ledger_name` = '$customer_name' limit 1";

if(mysqli_num_rows(db_query($search_sql))==0)

{

$sql="UPDATE `customer` SET 

`customer_name` = '$customer_name',

`customer_company` = '$customer_company',

`address` = '$address',

`contact_no` = '$contact',

`customer_type` = '$customer_type'

 WHERE `customer_id` = $customer_id LIMIT 1";

$qry=db_query($sql);

$sql="UPDATE `accounts_ledger` SET 

		`ledger_name` 		= '$customer_name'

	WHERE `ledger_id` 		='$customer_id' LIMIT 1";

$qry=db_query($sql);

		$type=1;

		$msg='Successfully Updated.';

}

	else

	{

	$type=0;

	$msg='Given Name('.$customer_name.') is already exists.';

	}

}

if(isset($_POST['dcustomer']))

{



$sql="delete from `customer` where `customer_id`='$customer_id' limit 1";

$query=db_query($sql);

$sql="delete from `accounts_ledger` where `ledger_id`='$customer_id' limit 1";

$query=db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_REQUEST['customer_id']))

{

$ddd="select * from customer where customer_id='$customer_id' and 1";

$data=mysqli_fetch_row(db_query($ddd));

}

/*$report=db_query("select customer_id, customer_name, customer_company, customer_type from customer where 1 order by customer_name asc");*/

?><script type="text/javascript">

$(document).ready(function(){

	

	$("#form2").validate();	

});	

function DoNav(theUrl)

{

	document.location.href = 'customer_info.php?customer_id='+theUrl;

}



</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>    <td width="66%" style="padding-right:5%">
	<div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="40%" align="right">

		    Customer Name :                                       </td>

                                        <td width="60%" align="right"><input type="text" name="cus_name" id="cus_name" value="<?php echo $_REQUEST['cus_name']; ?>" /></td>

                                      </tr>

                                      <tr>

                                        <td align="right">Company Name :                                         </td>

                                        <td align="right"><input name="cus_company" type="text" id="cus_company" value="<?php echo $_REQUEST['cus_company']; ?>" size="20" /></td>

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

									<td>

									<table id="grp" class="tabledesign" cellspacing="0">

							  <tr>

								<th>Customer Name</th>

								<th>Company</th>

								<th> Type</th>

							  </tr>

	<?php

		

	$rrr = "select customer_id, customer_name, customer_company, customer_type from customer where 1"; 
	if(isset($_REQUEST['search']))
	{
		$cus_name	= mysqli_real_escape_string($_REQUEST['cus_name']);
		$cus_company	= mysqli_real_escape_string($_REQUEST['cus_company']);
		$cus_type	= mysqli_real_escape_string($_REQUEST['cus_type']);
		
		$rrr .= " AND customer_name LIKE '%$cus_name%'";
		$rrr .= " AND customer_company LIKE '%$cus_company%'";
		$rrr .= " AND customer_type LIKE '%$cus_type%'";

				

	} 

	$rrr .= " order by customer_name";

	//print($rrr );

	$report=db_query($rrr);

	 while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

								<td><?=$rp[1];?></td>

								<td><?=$rp[2];?></td>

								<td><?=$rp[3];?></td>

							  </tr>

	<?php }?>

							</table>									</td>

								  </tr>

								</table>



							</div></td>

    <td><div class="right">  <form id="form2" name="form2" method="post" action="customer_info.php?customer_id=<?php echo $customer_id;?>" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr>

                                  <td><div class="box">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      <tr>

                                        <td>Customer  Name:</td>

                                        <td><input name="customer_name" type="text" id="customer_name" value="<?php echo $data[1];?>" size="30" maxlength="100" class="required" minlength="4" /></td>

									  </tr>



                                      <tr>

                                        <td>Customer Company: </td>

                                        <td><input name="customer_company" type="text" id="customer_company" value="<?php echo $data[2];?>" size="30" maxlength="100" class="required" /></td>

									  </tr>

                                      <tr>

                                        <td>Customer Address   : </td>

                                        <td><textarea name="address" cols="30" id="address" class="required"><?php echo $data[3];?></textarea></td>

                                      </tr>

                                      <tr>

                                        <td>Contact No:</td>

                                        <td><input name="contact" type="text" id="contact" size="15" maxlength="15" value="<?php echo $data[5];?>" class="required" /></td>

                                      </tr>

                                      <tr>

                                        <td>Customer Type:</td>

                                        <td><select name="customer_type">

                                          <option <?php echo $sel=($data[6]=='Corporate Client')?'Selected':'';?> value="Corporate Client">Corporate Client</option>

                                          <option <?php echo $sel=($data[6]=='Dealer')?'Selected':'';?> value="Dealer">Dealer</option>

                                          <option <?php echo $sel=($data[6]=='Employee')?'Selected':'';?> value="Employee">Employee</option>

                                          <option <?php echo $sel=($data[6]=='Individual Client')?'Selected':'';?> value="Individual Client">Individual Client</option>

                                          <option <?php echo $sel=($data[6]=='Vip Client')?'Selected':'';?> value="Vip Client">Vip Client</option>

                                        </select></td>

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

                                      <td><input name="ncustomer" type="submit" id="ncustomer" value="Record" class="btn"/></td>

                                      <td><input name="mcustomer" type="submit" id="mcustomer" value="Modify" class="btn"/></td>

                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='customer_info.php'"/></td>

                                      <td><input class="btn" name="dcustomer" type="submit" id="dcustomer" value="Delete"/></td>

                                    </tr>

                                  </table>

								  </div>								  </td>

                                </tr>

                              </table>

    </form>

							</div></td>

  </tr>

</table>9

<script type="text/javascript">

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>