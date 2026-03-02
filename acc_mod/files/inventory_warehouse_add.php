<?php



session_start();



ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='warehouse Information';



$proj_id=$_SESSION['proj_id'];



$table='production_line';

$button="yes";



$crud      =new crud($table);







$warehouse_id=$_REQUEST['warehouse_id'];



$warehouse_name=$_REQUEST['warehouse_name'];



$warehouse_name		= str_replace("'","",$warehouse_name);



$warehouse_name		= str_replace("&","",$warehouse_name);



$warehouse_name		= str_replace('"','',$warehouse_name);



$warehouse_company=$_REQUEST['warehouse_company'];



$address=$_REQUEST['address'];



$contact=$_REQUEST['contact'];



$warehouse_type=$_REQUEST['warehouse_type'];



$use_type=$_REQUEST['use_type'];



$ap_name=$_REQUEST['ap_name'];



$ap_designation=$_REQUEST['ap_designation'];



$ledger_id=$_REQUEST['ledger_id'];



$return_ledger_id=$_REQUEST['return_ledger_id'];



$group_for=$_REQUEST['group_for'];

$unique='warehouse_id';

$$unique=$_GET[$unique];



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



		)



VALUES ('$warehouse_name', '$warehouse_company', '$address', '$proj_id', '$contact', '$ap_name', '$ap_designation', '$warehouse_type', '$ledger_id','$use_type',$group_for,$return_ledger_id)";



		



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







if(isset($_POST['modify']))



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







                                  <td><div class="box">







                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">







                                      <tr>







                                        <td>Warehouse  Name:</td>







                                        <td><input name="warehouse_name" type="text" id="warehouse_name" value="<?php echo $data[1];?>" size="30" style="max-width:250px;" class="required" minlength="4" /></td>



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







                                        <td><input name="warehouse_company" type="text" id="warehouse_company" value="<?php echo $data[2];?>" size="30" style="max-width:250px;" class="required" /></td>



									  </tr>







                                      <tr>







                                        <td> Address   : </td>







                                        <td><textarea name="address" cols="30" style="max-width:250px;" id="address" class="required"><?php echo $data[3];?></textarea></td>



                                      </tr>







                                      <tr>







                                        <td>Contact No:</td>







                                        <td><input name="contact" style="max-width:250px;" type="text" id="contact" size="15" maxlength="15" value="<?php echo $data[5];?>" class="required" /></td>



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

										  

										  <option <?php echo $sel=($data[7]=='MAT')?'Selected':'';?> value="MAT">M.Ahmed Group</option>



                                        </select></td>



                                      </tr>

									  

									  <tr>



                                        <td>Owner Type:</td>



                                        <td><select name="owned_type">



                                          <option <?php echo ($data[18]=='1')?'Selected':'';?> value="1">Company Owned Depot</option>



                                          <option <?php echo ($data[18]=='2')?'Selected':'';?> value="2">Dealer Owned Depot</option>

										  

										  <option <?php echo ($data[18]=='3')?'Selected':'';?> value="3">Other</option>



                                          



                                        </select></td>



                                      </tr>



                                      <tr>



                                        <td>Authorise P Name:</td>



                                        <td><input name="ap_name" type="text" id="ap_name" value="<?php echo $data[8];?>" size="30" style="max-width:250px;" class="required" /></td>



                                      </tr>



                                      <tr>



                                        <td>Authorise P Designation:</td>



                                        <td><input name="ap_designation" type="text" id="ap_designation" value="<?php echo $data[9];?>" size="30" style="max-width:250px;" class="required" /></td>



                                      </tr>



                                      <tr>



                                        <td>Authorise P Signature:</td>



                                        <td><input type="file" style="max-width:250px;" name="logo" id="logo" /></td>



                                      </tr>



                                      <tr>



                                        <td>Ledger ID:</td>



                                        <td><input name="ledger_id" type="text" id="ledger_id" value="<?php echo $data[10];?>" size="30" style="max-width:250px;" class="required" /></td>



                                      </tr>



                                      <tr>



                                        <td>Sales Return Ledger  ID:</td>



                                        <td><input name="return_ledger_id" type="text" id="return_ledger_id" value="<?php echo $data[15];?>" size="30" style="max-width:250px;" class="required" /></td>



                                      </tr>



                                    </table>







                                  </div></td>







                                </tr>







                                







                                







                                <tr>







                                  <td align="center"><img src="../../signature/<?=$data[0]?>.jpg" width="123" height="47" /></td>







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







$main_content=ob_get_contents();







ob_end_clean();







require_once SERVER_CORE."routing/layout.bottom.php";







?>