<?php
session_start();
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');


$str = $_POST['data'];
$data=explode('##',$str);
$warehouse_id = $data[0];
$val = $data[1];
$data=explode('#',$val);
$assign_warehouse=$data[0];




   $sql = 'update warehouse set assign_warehouse="'.$assign_warehouse.'" where warehouse_id='.$warehouse_id;
db_query($sql);
echo 'Updated!';
?>