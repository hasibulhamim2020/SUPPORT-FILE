<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='ADD ZONE Information';			// Page Name and Page Title

$page="zone.php";		// PHP File Name



$table='zon';		// Database Table Name Mainly related to this page

$unique='ZONE_CODE';			// Primary Key of this Database table

$shown='ZONE_NAME';				// For a New or Edit Data a must have data field



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

$entry_by = $_SESSION['user'];



$crud->insert();

$id = $_POST['dealer_code'];
		
		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['np']['tmp_name']!=''){ 
		$file_temp = $_FILES['np']['tmp_name'];
		$folder = "../../np_pic/np/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['spp']['tmp_name']!=''){ 
		$file_temp = $_FILES['spp']['tmp_name'];
		$folder = "../../spp_pic/spp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['nsp']['tmp_name']!=''){ 
		$file_temp = $_FILES['nsp']['tmp_name'];
		$folder = "../../nsp_pic/nsp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

$id = $_POST['dealer_code'];
		
		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['np']['tmp_name']!=''){ 
		$file_temp = $_FILES['np']['tmp_name'];
		$folder = "../../np_pic/np/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['spp']['tmp_name']!=''){ 
		$file_temp = $_FILES['spp']['tmp_name'];
		$folder = "../../spp_pic/spp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['nsp']['tmp_name']!=''){ 
		$file_temp = $_FILES['nsp']['tmp_name'];
		$folder = "../../nsp_pic/nsp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}

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
              <td><div style="height:787px;width:638px;" class="tabledesign">
                  <? 	$res='select '.$unique.','.$unique.','.$shown.'  from '.$table;

											echo $crud->link_report($res,$link);?>
                </div>
                 </td>
            </tr>
          </table>
        </div></td>
      <td valign="top"><form action="" method="post"  enctype="multipart/form-data" >
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B"><div align="center">
                      <legend>
                      <?=$title?>
                      </legend>
                      <div class="buttonrow"></div>
                      <div>
                        <label> ZONE CODE:</label>
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text"  readonly/ class="form-control">
                      </div>
                      <div>
                        <label> ZONE NAME:</label>
                        <input name="ZONE_NAME" type="text" id="ZONE_NAME" tabindex="2" value="<?=$ZONE_NAME?>" class="form-control">
                      </div>
                      <div></div>
					  <div>
                        <label>Under Region</label>
						<select id="REGION_ID" name="REGION_ID" class="form-control">
						<option></option>
                         <?php foreign_relation('branch', 'BRANCH_ID', 'BRANCH_NAME', $REGION_ID); ?>
					    </select>
                      </div>
                      <!--<div>
                        <label>ZSM</label>
						<select id="area_asm_name" name="area_asm_name">
						<option></option>
                         <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'PBI_NAME', $area_asm_name,' PBI_DESIGNATION=5'); ?>
					    </select>
                      </div>-->
                      </div></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="button">
                        <? if(!isset($_GET[$unique])){?>
                        <input name="insert" type="submit" id="insert" value="Save" class="btn btn-primary" />
                        <? }?>
                      </div></td>
                    <td><div class="button">
                        <? if(isset($_GET[$unique])){?>
                        <input name="update" type="submit" id="update" value="Update" class="btn btn-danger" />
                        <? }?>
                      </div></td>
                    <td><div class="button">
                      <input name="reset" type="button" class="btn btn-success" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                    </div></td>
                    <td><!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->                    </td>
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
