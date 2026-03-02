<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Hotel Service Group';			// Page Name and Page Title
$page="service_group.php";		// PHP File Name

$table='hms_service_group';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='service_group';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
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


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

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
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
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
									<td>&nbsp;</td>
								  </tr>
								  <tr>
                                    <td>
									<div class="tabledesign">
                                        <? 	$res='select '.$unique.','.$unique.','.$shown.',service_charge as service,vat from '.$table.' order by id';
											echo $crud->link_report($res,$link);?>
                                    </div> </td>
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
                                        <legend><?=$title?></legend>
                                        
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label>Service group :</label>
                                          <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                          <input name="service_group" type="text" id="service_group" value="<?=$service_group?>">
                                        </div>
									<div>
                                          <label>Description:</label>
                                          <input name="description" type="text" id="description" value="<?=$description?>" />
									</div>
									<div>
                                          <label>Service Charge(%):</label>
                                          <input name="service_charge" type="text" id="service_charge" value="<?=$service_charge?>" />
									</div>
									<div>
                                          <label>Vat(%):</label>
                                          <input name="vat" type="text" id="vat" value="<?=$vat?>" />
									</div>
									<div>
                                          <label>Access ID:</label>
                                          <input name="username" type="text" id="username" value="<?=$username?>" />
									</div>
									<div>
                                          <label>Access Password:</label>
                                          <input name="password" type="text" id="password" value="<?=$password?>" />
									</div>
									</fieldset>									</td>
								  </tr>
								  
								</table></td>
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
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>