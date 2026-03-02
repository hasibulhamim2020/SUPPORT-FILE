<?php
session_start();
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$order_id=$data[0];
$info = $data[1];
$in = explode('<@>',$info);



$qty = $in[0];
//$unit_price = $in[1];
//$amount = $in[2];

$edit_by=$_SESSION['user']['id'];
$edit_at=date('Y-m-d H:i:s');


			 $new_sql="UPDATE `spare_parts_requisition_order` SET 
			
			`qty` = '".$qty."',

			`edit_by` = '".$edit_by."',
			
			`edit_at` = '".$edit_at."'
			
			 WHERE `id` ='".$order_id."'";
			
			db_query($new_sql);
			
			
			 
			
			
?>
<input name="<?='edit#'.$order_id?>" type="button" id="<?='edit#'.$order_id?>" value="Edit" style="width:60px; height:30px; color:#000; font-weight:700; background-color: #FF0000;" onclick="update_edit(<?=$order_id?>)" />