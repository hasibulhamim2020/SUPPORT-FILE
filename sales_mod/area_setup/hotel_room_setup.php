<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Hotel Room Setup';
$page="hotel_room_setup.php";

$table='hms_hotel_room';
$unique='id';
$shown='room_name';

$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']))
{		
$proj_id			= $_SESSION['proj_id'];
$now				= time();


$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}




if(isset($_POST['update']))
{

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
<table  style="width:100%; border:0; border-collapse:collapse: padding:0;">
  <tr>
    <td valign="top"><div class="left">
							<table  style="width:90%; border:0; border-collapse:collapse: padding:0;">

								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
                                    <td>
									<div class="tabledesign">
                                        <? 	$res='select '.$unique.','.$unique.',room_no,'.$shown.' from '.$table;
											echo $crud->link_report($res,$link);?>
                                    </div> </td>
						      </tr>
								</table>

							</div></td>
    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

      <table  style="width:100%; border:0; border-collapse:collapse: padding:0;">
                            <tr>
                              <td>                                   
							    <table  style="width:100%; border:0; border-collapse:collapse: padding:0; margin-top:60px;">
								  <tr>
									<td>
									<fieldset>
                                        <legend><?=$title?></legend>
                                        
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label>Room Name :</label>
                                          <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                          <input name="room_name" type="text" id="room_name" value="<?=$room_name?>">
                                        </div>
									<div>
                                          <label>Room No :</label>
                                          <input name="room_no" type="text" id="room_no" value="<?=$room_no?>" />
									</div>
										<div>
                                          <label>Floor Name :</label>
                                          <select name="floor_id" id="floor_id">
                                          <? foreign_relation('hms_hotel_floor','id','floor_name',$floor_id);?></select>
                                        </div>
										<div>
                                          <label>Room Type :</label>
                                          <select name="room_type_id" id="room_type_id">
                                          <? foreign_relation('hms_room_type','id','room_type',$room_type_id);?></select>
                                        </div>
										<div>
                                          <label>Room Status :</label>
                                          <select name="status" id="status">
                                          <option value="0" <? if($status==0){ echo 'selected';}?>>Out Of Order</option>
										  <option value="1" <? if($status==1){ echo 'selected';}?>>Ready</option>
										  </select>
                                        </div>
										<div>
                                          <label>Status Details :</label>
                                          <input name="status_detail" type="text" id="status_detail" value="<?=$status_detail?>">
                                        </div>
									</fieldset>									</td>
								  </tr>
								  
								</table></td>
							    </tr>
                                
                             
                            <tr>
                              <td>
							    <table  style="width:100%; border:0; border-collapse:collapse: padding:0;">
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
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>