<?php
session_start();
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');


$str = $_POST['data'];
$data=explode('##',$str);
$AREA_CODE = $data[0];
$val = $data[1];
$data=explode('#',$val);
$transport_cost=$data[0];



$now = date('Y-m-d H:i:s');
$entry_by=$_SESSION['user']['id'];

$change_date=date('Y-m-d');

$backup_data = find_all_field('area','','AREA_CODE='.$AREA_CODE);

  $backup_sql="INSERT INTO `area_update_backup` (

		AREA_CODE ,

		AREA_NAME,
		
		ZONE_ID,
		
		p_transport_cost,
		
		r_transport_cost,

		change_date,

		entry_at,
		entry_by

		)

VALUES ('".$backup_data->AREA_CODE."', '".$backup_data->AREA_NAME."', '".$backup_data->ZONE_ID."', '".$backup_data->transport_cost."', '".$transport_cost."', '".$change_date."', 
 '".$now."', '".$entry_by."')";
		
		
		
		db_query($backup_sql);





   $sql = 'update area set transport_cost="'.$transport_cost.'" where AREA_CODE='.$AREA_CODE;
db_query($sql);
echo 'Updated!';
?>