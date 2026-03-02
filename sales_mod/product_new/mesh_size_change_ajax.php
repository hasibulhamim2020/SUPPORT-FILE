<?php
session_start();
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');


  $str = $_POST['data'];
$data=explode('##',$str);
$item_id = $data[0];
$val = $data[1];
$data=explode('#',$val);
$d_price=$data[0];
$mesh_size=$data[1];
$mesh_inch=$data[2];
$mesh_hend=$data[3];
$mesh_mm=$data[4];
$log_sheet=$data[5];



  echo $sql = 'update item_info set d_price="'.$d_price.'", mesh_size="'.$mesh_size.'", mesh_inch="'.$mesh_inch.'", mesh_hend="'.$mesh_hend.'", log_sheet="'.$log_sheet.'", mesh_mm="'.$mesh_mm.'" where item_id='.$item_id;
db_query($sql);
echo 'Updated!';
?>