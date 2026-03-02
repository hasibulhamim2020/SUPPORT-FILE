<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







$title='Party information';

$page="vendor_info.php";



$table='vendor';

$unique='vendor_id';

$shown='vendor_name';


$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();



		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['entry_by']=$_SESSION['user']['id'];

$crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}









if(isset($_POST['update']))

{

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

}





if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

if(!isset($$unique)){ $$unique=db_last_insert_id($table,$unique);}

if($_POST['gf']==999) 

{unset($_SESSION['gf']);

unset($_POST['gf']);

}

?>



<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<div class="form-container_large">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>

									<td><form id="form2" name="form2" method="post" action="">

									  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                        <tr>

                                          <td>Concern Group: </td>

                                          <td><select name="gf" id="gf" style="width:150px;">

                                              <option value="999">All</option>

                                              <?	$sql="select * from user_group where status!=1 order by group_name";

											$query=db_query($sql);

											while($datas=mysqli_fetch_object($query))

										{

										?>

					  <option <? if($datas->id==$_POST['gf']){ echo 'Selected '; } ?> value="<?=$datas->id?>">

					  <?=$datas->group_name?>

					  </option>

                                              <? } ?>

                                          </select></td>

                                          <td><label>

                                            <input type="submit" name="show" value="GO" style="width:40px; height:20px;" />

                                            </label>

                                          </td>

                                        </tr>

                                      </table>

                                                                        </form>

									</td>

								  </tr>

								  <tr>

                                    <td>

									<div class="tabledesign">

                                        <? 	 

										if($_POST['gf']>0)

			{$_SESSION['gf'] = $_POST['gf'];

$res='select a.'.$unique.',a.'.$shown.' as party_name,b.category_name,c.group_name,a.ledger_id from '.$table.' a, vendor_category b, user_group c where a.group_for = c.id and  a.vendor_category=b.id and a.group_for='.$_POST['gf'].' order by a.vendor_name';}

		elseif($_SESSION['gf']>0)

{$res='select a.'.$unique.',a.'.$shown.' as party_name,b.category_name,c.group_name,a.ledger_id from '.$table.' a,vendor_category b, user_group c where a.group_for = c.id and  a.vendor_category=b.id and  a.group_for='.$_SESSION['gf'].' order by a.vendor_name';}

		else

{$res='select a.'.$unique.',a.'.$shown.' as party_name,b.category_name,c.group_name,a.ledger_id from '.$table.' a,vendor_category b, user_group c where a.group_for = c.id and  a.vendor_category=b.id order by a.vendor_name';}

											echo $crud->link_report($res,$link);?>

                                    </div><?=paging(5000);?></td>

						      </tr>

								</table>



							</div></td>

    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">



      <table width="100%" border="0" cellspacing="0" cellpadding="0">

                            <tr>

                              <td>                                   

							    <table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

									<td>

									<fieldset>

                                        <legend>Party  Details</legend>

                                        

                                        <div> </div>

                                        <div class="buttonrow"></div>

										

									

										

										<div>

                                          <label>Vendor  ID:</label>

                                          

                                          <input name="vendor_id" type="text" id="vendor_id" value="<?=$vendor_id?>">

                                        </div>

									<div>

                                          <label>Vendor Owner Name:</label>

                                          <input name="vendor_name" type="text" id="vendor_name" value="<?=$vendor_name?>" />

									</div>

									<div>

                                  <label>Catagory Name:</label>

                                          <select name="vendor_category" id="vendor_category">

                                          <? foreign_relation('vendor_category','id','category_name',$vendor_category);


										  ?>

                                          </select>

                                          

                                        </div>

									<div>

                                         

                                  <label>Concern Company:</label>

                                  <select name="group_for" id="group_for">

                                    <option></option>

                                    <?	$sql="select * from user_group where status!=1 order by group_name";

											$query=db_query($sql);

											while($datas=mysqli_fetch_object($query))

										{

										?>

                                    <option <? if($datas->id==$group_for){ echo 'Selected '; } ?> value="<?=$datas->id?>">

                                      <?=$datas->group_name?>

                                    </option>

                                    <? } ?>

                                  </select>

									</div>

                                      <div>

                                         

                                  <label>Ledger ID(FROM ACC):</label>

                                  <input name="ledger_id" type="text" id="ledger_id" value="<?=$ledger_id?>" size="20" maxlength="16" />

                                      </div>

									<div>

                                         

                                  <label>Status:</label>

                                          

                                          <select name="status" id="status">

                                          <option><?=$status?></option>

                                          <option>ACTIVE</option>

                                           <option>INACTIVE</option>

                                          </select>

                                        </div>

                                        

                                       <div>

                                          <label>Vendor Company:</label>

                                          <input name="vendor_company" type="text" id="vendor_company" value="<?=$vendor_company?>" />

									</div>

                                     <div>

                                          <label>Address:</label>

                                          <input name="address" type="text" id="address" value="<?=$address?>" />

									</div>

                                     <div>

                                          <label>Contact No:</label>

                                          <input name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" />

									</div>

                                     <div>

                                       <label>Vendor Type:</label>

                                       <select name="vendor_type" id="vendor_type">

                                       <? foreign_relation('vendor_type','id','vendor_type',$vendor_type);?>

                                       </select>

                                     </div>

                                     <div>

                                          <label>Fax No:</label>

                                          <input name="fax_no" type="text" id="fax_no" value="<?=$fax_no?>" />

									</div>

                                    <div>

                                          <label>Email Address:</label>

                                          <input name="email" type="text" id="email" value="<?=$email?>" />

									</div>

                                     <div>

                                          <label>Contact Person Name:</label>

                                          <input name="contact_person_name" type="text" id="contact_person_name" value="<?=$contact_person_name?>" />

									</div>

                                     <div>

                                          <label>Contact P Designation:</label>

                                          <input name="contact_person_designation" type="text" id="contact_person_designation" value="<?=$contact_person_designation?>" />

									</div>

                                     <div>

                                          <label>Contact Person Mobile:</label>

                                          <input name="contact_person_mobile" type="text" id="contact_person_mobile" value="<?=$contact_person_mobile?>" />

									</div>

									</fieldset>									</td>

								  </tr>

                             

 





                           </table>

                             

                             

                             <tr>

                               <td>&nbsp;</td>

                             </tr>

            

                            <tr>

                              <td>

							    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                    <tr>

                                      <td>

									  <div class="button">

										<? if(!isset($_GET[$unique])){?>

										<input name="insert" type="submit" id="insert" value="Save" class="btn" />

										<? }?>	

										</div>										</td>

										<td>

										<div class="button">

										<? if(isset($_GET[$unique])){?>

										<input name="update" type="submit" id="update" value="Update" class="btn" />

										<? }?>	

										</div>									</td>

                                      <td>

									  <div class="button">

									  <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />

									  </div>									  </td>

                                      <td>

									  <div class="button">

									  <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>

									  </div>									  </td>

                                    </tr>

                                </table></td>

                            </tr>

        </table>

    </form></td>

  </tr>

</table>

</div>

<?php

require_once SERVER_CORE."routing/layout.bottom.php";

?>