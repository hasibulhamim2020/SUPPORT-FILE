<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Hotel Information';
$page="hotel_info.php";

$table='hms_hotel_info';
$unique='id';
$shown='hotel_name';




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
<table style="width:100%; border:0; border-collapse:collapse; padding:0;">
  <tr>
    <td style="vertical-align:top"><div class="left">
							<table style="width:90%; border:0; border-collapse:collapse; padding:0;">

								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
                                    <td>
									<div class="tabledesign">
                                        <? 	$res='select '.$unique.','.$unique.','.$shown.' from '.$table;
											echo $crud->link_report($res,$link);?>
                                    </div> </td>
						      </tr>
								</table>

							</div></td>
    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

      <table style="width:100%; border:0; border-collapse:collapse; padding:0;">
                            <tr>
                              <td>                                   
							    <table style="width:100%; border:0; border-collapse:collapse; padding:0; margin-top:60px;">
								  <tr>
									<td>
									<fieldset>
                                        <legend><?=$title?></legend>
                                        
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label>Hotel Name :</label>
                                          <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                          <input name="hotel_name" type="text" id="hotel_name" value="<?=$hotel_name?>">
                                        </div>
									<div>
                                          <label>Address:</label>
                                          <input name="address" type="text" id="address" value="<?=$address?>" />
									</div>
										<div>
                                          <label>Contact No :</label>
                                          <input name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" />
                                        </div>
										<div>
                                          <label>Website Address :</label>
                                          <input name="website" type="text" id="website" value="<?=$website?>" />
                                        </div>
										<div>
                                          <label>Telephone No:</label>
                                          <input name="telephone" type="text" id="telephone" value="<?=$telephone?>" />
                                        </div>
										<div>
                                          <label>Email Address:</label>
                                          <input name="email" type="text" id="email" value="<?=$email?>" />
                                        </div>
									</fieldset>									</td>
								  </tr>
								  
								</table></td>
							    </tr>
                                
                             
                            <tr>
                              <td>
							    <table style="width:100%; border:0; border-collapse:collapse; padding:0;">
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