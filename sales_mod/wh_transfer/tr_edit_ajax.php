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



$pkt_size = $in[0];
$crt_price = $in[1];
$unit_price = $in[2];
$pkt_unit = $in[3];
$total_unit = $in[4];
$crt_amt = $in[5];
$total_amt = $in[6];

$edit_by=$_SESSION['user']['id'];
$edit_at=date('Y-m-d H:s:i');


			  $new_sql="UPDATE `warehouse_transfer_detail` SET 
			
			`pkt_size` = '".$pkt_size."',
			`crt_price` = '".$crt_price."', 
			
			`unit_price` = '".$unit_price."',
			`pkt_unit` = '".$pkt_unit."', 
			
			`total_unit` = '".$total_unit."',
			`crt_amt` = '".$crt_amt."',
			`total_amt` = '".$total_amt."', 
			
			`edit_by` = '".$edit_by."',
			
			`edit_at` = '".$edit_at."'
			
			 WHERE `id` ='".$order_id."'";
			
			db_query($new_sql);
			
			
			 $jex_sql="UPDATE `journal_item` SET 
			
			`item_ex` = '".$total_unit."',
			
			`entry_by` = '".$edit_by."',
			
			`entry_at` = '".$edit_at."'
			
			 WHERE item_ex>0 and `tr_no` ='".$order_id."' and tr_from in ('Transit','Transfered')";
			
			db_query($jex_sql);
			
			
			
			 $jin_sql="UPDATE `journal_item` SET 
			
			
			`item_in` = '".$total_unit."',
			
			`entry_by` = '".$edit_by."',
			
			`entry_at` = '".$edit_at."'
			
			 WHERE  item_in>0 and `tr_no` ='".$order_id."' and tr_from in ('Transit','Transfered')";
			
			db_query($jin_sql);
			
			
			
?>
<input name="<?='edit#'.$order_id?>" type="button" id="<?='edit#'.$order_id?>" value="Edit" style="width:60px; height:30px; color:#000; font-weight:700;" onclick="update_edit(<?=$order_id?>)" />