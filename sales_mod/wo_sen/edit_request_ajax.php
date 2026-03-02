<?php
session_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$order_id=$data[0];
$info = $data[1];
$in = explode('<@>',$info);


$edit_request = $in[0];



$request_by=$_SESSION['user']['id'];
$request_at=date('Y-m-d H:s:i');


			 $new_sql="UPDATE `sale_do_details` SET 
			
			`edit_request` = 1,

			
			`request_by` = '".$request_by."',
			
			`request_at` = '".$request_at."'
			
			 WHERE `id` = '".$order_id."'";
			
			db_query($new_sql);
			
			

			
			
?>
<input name="<?='edit#'.$order_id?>" type="button" id="<?='edit#'.$order_id?>" value="Pending" style="width:100px; height:30px; background:#FF0000; color:#000; font-weight:700;" onclick="update_edit(<?=$order_id?>)" />