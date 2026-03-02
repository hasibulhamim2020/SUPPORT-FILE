<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Buyer Details';			// Page Name and Page Title
$page="buyer_info.php";		// PHP File Name

$table='lc_buyer';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='buyer_name';				// For a New or Edit Data a must have data field



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
    <td style="vertical-align:top;"><div class="left">
							<table style="width:90%; border:0; border-collapse:collapse; padding:0;">

								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
                                    <td>
									<div class="tabledesign">
                                        <? 	 $res='select '.$unique.','.$unique.','.$shown.' as party_name from '.$table;
											echo $crud->link_report($res,$link);?>
                                    </div> </td>
						      </tr>
								</table>

							</div></td>
    <td style="vertical-align:top;"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

      <table style="width:100%; border:0; border-collapse:collapse; padding:0;">
                            <tr>
                              <td>                                   
							    <table style="width:100%; border:0; border-collapse:collapse; padding:0; margin-top:60px;">
								  <tr>
									<td>
									<fieldset>
                                        <legend>Party  Details</legend>
                                        
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label>Party  ID:</label>
                                          
                                          <input name="id" type="text" id="id" value="<?=$id?>">
                                        </div>
									<div>
                                          <label>Party Name:</label>
                                          <input name="buyer_name" type="text" id="buyer_name" value="<?=$buyer_name?>" />
									</div>
									<div>
                                  <label>Catagory Name:</label>
                                          <select name="buyer_category_id" id="buyer_category_id">
                                          <? foreign_relation('lc_buyer_category','id','category_name',$buyer_category_id);?></select>
                                          
                                        </div>
                                      <div>
                                         
                                  <label>Ledger ID(FROM ACC):</label>
                                  <input name="ledger_id" type="text" id="ledger_id" value="<?=$ledger_id?>" size="20" maxlength="9" />
                                      </div>
									<div>
                                         
                                  <label>Status:</label>
                                          
                                          <select name="status" id="status">
                                          <option><?=$status?></option>
                                          <option>ACTIVE</option>
                                           <option>INACTIVE</option>
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
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>