<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Roll Management';			// Page Name and Page Title
$page="module_manage.php";		// PHP File Name
$input_page="module_manage_input.php";
$root='user_management';

$table='user_module_manage';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='module_name';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

if($_GET['user_id']>0){
	 $access = $_GET['user_id'];
	}
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']))
{		
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
<script type="text/javascript"> function DoNav(theUrl)
{
	window.open('roll_create.php?user_id='+theUrl,'_self',false);
}</script>

<form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
    <? //include('../../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <? //include('../../common/report_bar.php');?>
	
	<div class="container">
	
	<div class="row">
	<div class="col-sm-8"></div>
	<div class="col-sm-4 text-right" >
	<button type="submit" class="btn btn-primary" name="" ><a href="roll_create.php" style="list-style:none;text-decoration:none; color:white;">Add New User</a></button>
	

	
	</div>
	</div>
	
	</div>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	 $res='select user_id,user_id,username,fname,designation,level,status from user_activity_management';
		  
		echo $crud->link_report($res,$link);?>
          </div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>