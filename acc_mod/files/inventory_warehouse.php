<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='warehouse Information';
$proj_id=$_SESSION['proj_id'];
$table='production_line';
$crud      =new crud($table);

$warehouse_id=$_REQUEST['warehouse_id'];

$warehouse_name=$_POST['warehouse_name'];
$warehouse_name		= str_replace("'","",$warehouse_name);
$warehouse_name		= str_replace("&","",$warehouse_name);
$warehouse_name		= str_replace('"','',$warehouse_name);
$warehouse_company=$_POST['warehouse_company'];
$address=$_POST['address'];
$contact=$_POST['contact'];
$warehouse_type=$_POST['warehouse_type'];
$use_type=$_POST['use_type'];
$ap_name=$_POST['ap_name'];
$ap_designation=$_POST['ap_designation'];
$ledger_id=$_POST['ledger_id'];
$return_ledger_id=$_POST['return_ledger_id'];
$group_for=$_POST['group_for'];
$now=time();
//end 

if(isset($_POST['nwarehouse']))
{
$check="select warehouse_id from warehouse where warehouse_name='$warehouse_name' limit 1";
if(mysqli_num_rows(db_query($check))>0)
{
	$aaa=mysqli_num_rows(db_query($check));
	$warehouse_id=$aaa[0];
	$type=0;
	$msg='Given Name('.$warehouse_name.') is already exists.';
}
else
{
	
		$sql="INSERT INTO `warehouse` (
		`warehouse_name` ,
		`warehouse_company` ,
		`address` ,
		`proj_id` ,
		`contact_no` ,
		`ap_name` ,
		`ap_designation` ,
		`warehouse_type`,
		ledger_id,
		use_type,group_for,return_ledger_id
		) VALUES ('$warehouse_name', '$warehouse_company', '$address', '$proj_id', '$contact', '$ap_name', '$ap_designation', '$warehouse_type', '$ledger_id','$use_type',$group_for,$return_ledger_id)";
		
		$query=db_query($sql);
		$sign = db_insert_id();
		$id=$_POST['id']=$sign;
		$line_name=$_POST['line_name']=$warehouse_name;
		$crud->insert();
		$type=1;
if($_FILES['logo']['size']>0)
{
$root='../../signature/'.$sign.'.jpg';
move_uploaded_file($_FILES['logo']['tmp_name'],$root);
}
		$msg='New Entry Successfully Inserted.';

}

}

//for Modify..................................

if(isset($_POST['mwarehouse']))
{
$line_name=$_POST['line_name']=$warehouse_name;
$sql="UPDATE `warehouse` SET 
`warehouse_name` = '$warehouse_name',
`warehouse_company` = '$warehouse_company',
`address` = '$address',
`contact_no` = '$contact',
`ap_name` = '$ap_name',
`ap_designation` = '$ap_designation',
`ledger_id`='$ledger_id',
`return_ledger_id`='$return_ledger_id',
`use_type`='$use_type',
`warehouse_type` = '$warehouse_type',
group_for = '$group_for'
 WHERE `warehouse_id` = $warehouse_id LIMIT 1";

$qry=db_query($sql);
if($_FILES['logo']['size']>0)
{
$root='../../signature/'.$warehouse_id.'.jpg';
move_uploaded_file($_FILES['logo']['tmp_name'],$root);
}
		$type=1;
		$msg='Successfully Updated.';
}

if(isset($_POST['dwarehouse']))
{
$sql="delete from `warehouse` where `warehouse_id`='$warehouse_id' limit 1";
$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}

if(isset($_REQUEST['warehouse_id']))
{
$ddd="select * from warehouse where warehouse_id='$warehouse_id' and 1";
$data=mysqli_fetch_row(db_query($ddd));
}

?><script type="text/javascript">

$(document).ready(function(){

	

	$("#form2").validate();	

});	

function DoNav(theUrl)

{

	document.location.href = 'inventory_warehouse.php?warehouse_id='+theUrl;

}



</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="40%" align="right">

		    Warehouse Name : </td>

                               <td width="60%" align="right"><input type="text" name="cus_name" id="cus_name" value="<?php echo $_REQUEST['cus_name']; ?>" /></td>

                                      </tr>

                                      <tr>

                                        <td align="right">Incharge :                                         </td>

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

									<table id="" class="table table-bordered" cellspacing="0">

							  <tr>

								<th>Name</th>

								<th>Incharge</th>

								<th> Type</th>

							  </tr>

	<?php

		

	$rrr = "select warehouse_id, warehouse_name, warehouse_company, warehouse_type from warehouse where 1"; 
	if(isset($_REQUEST['search']))
	{
		$cus_name	= mysqli_real_escape_string($_REQUEST['cus_name']);
		$cus_company	= mysqli_real_escape_string($_REQUEST['cus_company']);
		$cus_type	= mysqli_real_escape_string($_REQUEST['cus_type']);
		
		$rrr .= " AND warehouse_name LIKE '%$cus_name%'";
		$rrr .= " AND warehouse_company LIKE '%$cus_company%'";
		$rrr .= " AND warehouse_type LIKE '%$cus_type%'";

				

	} 

	$rrr .= " order by warehouse_name";

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



							</div></td>    <td valign="top" width="34%" >
	<div class="rights">  <form action="?warehouse_id=<?php echo $warehouse_id;?>" method="post" enctype="multipart/form-data" name="form2" id="form2" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr>

                                  <td valign="top"><div class="box">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      <tr>

                                        <td>Warehouse  Name:</td>

              <td><input name="warehouse_name" type="text" id="warehouse_name" value="<?php echo $data[1];?>" size="30" maxlength="100" class="required" minlength="4" /></td>
									  </tr>



                                      <tr>
                                        <td>Concern Company: </td>
                                        <td><select name="group_for" id="group_for">
                                          <option></option>
                                          <? 	$sql="select * from user_group where status!=1 order by group_name";
												$query=db_query($sql);
												while($datas=mysqli_fetch_object($query)){?>
<option <? if($datas->id==$data[12]) echo 'Selected ';?> value="<?=$datas->id?>"><?=$datas->group_name?></option>
                                          <? }?>
                                        </select></td>
                                      </tr>
                                      <tr>

                                        <td>Incharge Person: </td>

                                        <td><input name="warehouse_company" type="text" id="warehouse_company" value="<?php echo $data[2];?>" size="30" maxlength="100" class="required" /></td>
									  </tr>

                                      <tr>

                                        <td> Address   : </td>

                                        <td><textarea name="address" cols="30" id="address" class="required"><?php echo $data[3];?></textarea></td>
                                      </tr>

                                      <tr>

                                        <td>Contact No:</td>

                                        <td><input name="contact" type="text" id="contact" size="15" maxlength="15" value="<?php echo $data[5];?>" class="required" /></td>
                                      </tr>

                                      <tr>
                                        <td>Able to:</td>
                                        <td><select name="warehouse_type">
                                          <option <?php echo $sel=($data[6]=='Purchase')?'Selected':'';?> value="Purchase">Only Purchase</option>
                                          <option <?php echo $sel=($data[6]=='Sale')?'Selected':'';?> value="Sale">Only Sale</option>
                                          <option <?php echo $sel=($data[6]=='Both')?'Selected':'';?> value="Both">Both Purchase &amp; Sale</option>
                                        </select></td>
                                      </tr>
                                      <tr>
                                        <td>Warehouse Type:</td>
                                        <td><select name="use_type">
                                          <option <?php echo $sel=($data[7]=='WH')?'Selected':'';?> value="WH">Store Inventory</option>
                                          <option <?php echo $sel=($data[7]=='SD')?'Selected':'';?> value="SD">Sales Depot</option>
                                          <option <?php echo $sel=($data[7]=='PL')?'Selected':'';?> value="PL">Production Line</option>
										  <option <?php echo $sel=($data[7]=='DM')?'Selected':'';?> value="DM">Damage Warehouse</option>
                                        </select></td>
                                      </tr>
                                      <tr>
                                        <td>Authorise P Name:</td>
                                        <td><input name="ap_name" type="text" id="ap_name" value="<?php echo $data[8];?>" size="30" maxlength="100" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Authorise P Designation:</td>
                                        <td><input name="ap_designation" type="text" id="ap_designation" value="<?php echo $data[9];?>" size="30" maxlength="100" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Authorise P Signature:</td>
                                        <td><input type="file" name="logo" id="logo" /></td>
                                      </tr>
                                      <tr>
                                        <td>Ledger ID:</td>
                                        <td><input name="ledger_id" type="text" id="ledger_id" value="<?php echo $data[10];?>" size="30" maxlength="100" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Sales Return Ledger  ID:</td>
                                        <td><input name="return_ledger_id" type="text" id="return_ledger_id" value="<?php echo $data[15];?>" size="30" maxlength="100" class="required" /></td>
                                      </tr>
                                    </table>

                                  </div></td>

                                </tr>

                                

                                

                                <tr>

                                  <td align="center"><img src="../../signature/<?=$data[0]?>.jpg" width="123" height="47" /></td>

                                </tr>

                                <tr>

                                  <td>

								  <div class="box1">

								  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                    <tr>

                                      <td><input name="nwarehouse" type="submit" id="nwarehouse" value="Record" class="btn"/></td>

                                      <td><input name="mwarehouse" type="submit" id="mwarehouse" value="Modify" class="btn"/></td>

                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='inventory_warehouse.php'"/></td>

                                      <td>&nbsp;</td>
                                    </tr>

                                  </table>

								  </div>								  </td>

                                </tr>

                              </table>

</form>

							</div></td>

  </tr>

</table>1000

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