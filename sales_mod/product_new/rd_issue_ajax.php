<?php
session_start();
require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$d_price= $data[5];
$item_id = $data[2];

echo $sql = 'update item_info set d_price="'.$d_price.'" where item_id='.$item_id;
db_query($sql);
echo 'Updated!';
?>