<?php
session_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$order_id=$data[0];
$info = $data[1];
$in = explode('<@>',$info);


$L = $in[0];
$W = $in[1];
$H = $in[2];
$WL = $in[3];
$WW = $in[4];
$ply = $in[5];
$fr = $in[6];
$sqm_rate = $in[7];
$additional_charge = $in[8];
$sqm = $in[9];
$final_price = $in[10];
$unit_price = $in[11];
$total_unit = $in[12];
$total_amt = $in[13];

$style_no = $in[14];
$po_no = $in[15];
$destination = $in[16];
$referance = $in[17];
$sku_no = $in[18];
$pack_type = $in[19];
$color = $in[20];
$size = $in[21];
$delivery_date = $in[22];

$printing_info = $in[23];
$delivery_place = $in[24];

$edit_by=$_SESSION['user']['id'];
$edit_at=date('Y-m-d H:s:i');


			 $new_sql="UPDATE `sale_do_details` SET 
			
			`L_cm` = '".$L."',
			`W_cm` = '".$W."',
			`H_cm` = '".$H."',
			`WL` = '".$WL."', 
			`WW` = '".$WW."', 
			`ply` = '".$ply."', 
			`formula_id` = '".$fr."', 
			`sqm_rate` = '".$sqm_rate."', 
			`additional_charge` = '".$additional_charge."', 
			`sqm` = '".$sqm."', 
			`final_price` = '".$final_price."', 
			`unit_price` = '".$unit_price."', 
			`total_unit` = '".$total_unit."', 
			`total_amt` = '".$total_amt."',
			
			
			`style_no` = '".$style_no."',
			`po_no` = '".$po_no."',
			`destination` = '".$destination."',
			`referance` = '".$referance."',
			`sku_no` = '".$sku_no."',
			`pack_type` = '".$pack_type."',
			`color` = '".$color."',
			`size` = '".$size."',
			`delivery_date` = '".$delivery_date."',
			
			`printing_info` = '".$printing_info."',
			`delivery_place` = '".$delivery_place."',
			
			edit_request = 0,
	
			
			`edit_by` = '".$edit_by."',	
			`edit_at` = '".$edit_at."'
			
			 WHERE `id` = '".$order_id."'";
			
			db_query($new_sql);
			
			
		
?>

<strong>Done</strong>