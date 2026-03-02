<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Raw Material Information';			// Page Name and Page Title
$page="raw_material_info.php";		// PHP File Name

$table='proc_raw_material';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='material_name';				// For a New or Edit Data a must have data field



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
                                        <? 	 $res='select '.$unique.','.$unique.','.$shown.' from '.$table;
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
                                        <legend>Raw Material Details</legend>
                                        
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label>Material ID:</label>
                                          
                                          <input name="id" type="text" id="id" value="<?=$id?>">
                                        </div>
									<div>
                                          <label>Material Name:</label>
                                          <input name="material_name" type="text" id="material_name" value="<?=$material_name?>" />
									</div>
										<div>
                                          <label>Description:</label>
                                          <input name="description" type="description" id="description" value="<?=$description?>" />
                                        </div>
										<div>
                                          <label>Catagory Name:</label>
                                          <select name="material_catagory_id" id="material_catagory_id">
                                          <? foreign_relation(' proc_raw_material_catagory','id','CONCAT(id,"-", catagory_name)',$material_catagory_id);?></select>
                                          
                                        </div>
                                        
                                                                                										<div>
                                          <label>Unit:</label>
                                          <input name="unit_type" type="unit_type" id="unit_type" value="<?=$unit_type?>" />
                                        </div>
                                        										<div>
                                          <label>Packing Unit:</label>
                                          <input name="packing_unit" type="packing_unit" id="packing_unit" value="<?=$packing_unit?>" />
                                        </div>
                                        										<div>
                                          <label>Purchase Price:</label>
                                          <input name="purchase_price" type="purchase_price" id="purchase_price" value="<?=$purchase_price?>" />
                                        </div>

                                                                 										<div>
                                          <label>Qty On Hand:</label>
                                          <input name="qoh" type="qoh" id="qoh" value="<?=$qoh?>" readonly />
                                        </div>
                                                                 										<div>
                                          <label>Qty on Production:</label>
                                          <input name="qop" type="qop" id="qop" value="<?=$qop?>" readonly />
                                        </div>
                                                                                                     										<div>
                                          <label>Qty on Transit:</label>
                                          <input name="qot" type="qot" id="qot" value="<?=$qot?>" readonly />
                                        </div>
                                                                 										<div>
                                          <label>Reorder Level:</label>
                                          <input name="rol" type="rol" id="rol" value="<?=$rol?>" />
                                        </div>
                                                                 										<div>
                                          <label>FSN Status:</label>
                                          <input name="fsn" type="fsn" id="fsn" value="<?=$fsn?>" />
                                        </div>
                                        
                                        
                                        
                                        										<div>
                                         
                                                                                    <label>Status:</label>
                                          
                                          <select name="status" id="status">
                                          <option><?=$status?></option>
                                          <option>Active</option>
                                                                                    <option>Not Active</option>
                                          </select>
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
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>