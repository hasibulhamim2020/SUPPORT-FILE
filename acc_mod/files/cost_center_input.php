<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Cost Center';			// Page Name and Page Title

do_datatable('table_head');

$page="cost_center.php";		// PHP File Name



$table='cost_center';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='center_name';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];

//for Insert..................................

if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();

		$id = $_POST['dealer_code'];
		
		if($_FILES['cr_upload']['tmp_name']!=''){ 
		$file_temp = $_FILES['cr_upload']['tmp_name'];
		$folder = "../../images/cr_pic/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}


		
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


		$_POST['edit_by'] = $_SESSION['user']['id'];
		 
		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');


		$crud->update($unique);

		$id = $_POST['dealer_code'];



		if($_FILES['cr_upload']['tmp_name']!=''){ 
		$file_temp = $_FILES['cr_upload']['tmp_name'];
		$folder = "../../images/cr_pic/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}


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
		
        echo $msg='<div class="alert alert-success" role="alert">Successfully Updated.</div>';

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
<script type="text/javascript">

$(function() {

		$("#fdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'yy-mm-dd'

		});

});

function Do_Nav()

{

	var URL = 'pop_ledger_selecting_list.php';

	popUp(URL);

}




function DoNav(theUrl)

{

	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;

}

function popUp(URL) 

{

	day = new Date();

	id = day.getTime();

	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>
<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
	font-weight: bold;
	color: #000000;
	font-size: 14px;
}
.style3 {color: #FFFFFF}

-->

</style>
<form action="cost_center_input.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Cost Center :</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
        <input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
        <input name="center_name" required type="text" id="center_name" class="form-control" value="<?=$center_name?>" >
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Cost Category:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <select name="category_id" required id="category_id"  class="form-control">
          <? foreign_relation('cost_category','id','category_name',$category_id,'1');?>
        </select>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Company:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <select name="group_for" required id="group_for"  class="form-control">
          <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
        </select>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <? if(!isset($_GET[$unique])){?>
        <input name="insert" type="submit" id="insert" value="SAVE" class="btn btn-success" />
        <? }?>
        <? if(isset($_GET[$unique])){?>
        <input name="update" type="submit" id="update" value="UPDATE" class="btn btn-success" />
        <? }?>
        <input name="reset" type="button" class="btn btn-info" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
      </div>
    </div>
  </div>
  <!-- <tr>

                                        <td>Status:</td>

                                        <td><select name="status" id="status"  style="width:250px;">

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="Active">Active</option>

                                          <option value="Inactive">Inactive</option>


                                        </select></td>

                                      </tr>
             -->
</form>
<script type="text/javascript"><!--

    var pager = new Pager('grp', 10000);

    pager.init();

    pager.showPageNav('pager', 'pageNavPosition');

    pager.showPage(1);

//-->

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>
<script>


function duplicate(){

var dealer_code_2 = ((document.getElementById('dealer_code_2').value)*1);

var customer_id = ((document.getElementById('customer_id').value)*1);



   if(dealer_code_2>0)
  {
  
alert('This customer code already exists.');
document.getElementById('customer_id').value='';


document.getElementById('customer_id').focus();

  } 



}

</script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
