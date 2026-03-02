<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Vendor Category';
$page="vendor_category.php";

$table='vendor_category';
$unique='id';
$shown='category_name';







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
if(!isset($$unique)){ $$unique=db_last_insert_id($table,$unique); }
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
    <td valign="top"><div class="left">
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
    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" style=" margin-top:60px;">

      <table style="width:100%; border:0; border-collapse:collapse; padding:0;">
                            <tr>
                              <td>                                   
							    <table style="width:100%; border:0; border-collapse:collapse; padding:0;">
								  <tr>
									<td>
									<fieldset>
                                        <legend><?=$title?> Details</legend>
                                        
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label>Catagory ID:</label>
                                          <input name="id" type="text" id="id" value="<?=$id?>">
                                        </div>
									<div>
                                          <label>Catagory Name:</label>
                                          <input name="category_name" type="text" id="category_name" value="<?=$category_name?>" />
									</div>
                                    <div>
                                      <label>Catagory Status:</label> 
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

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>
