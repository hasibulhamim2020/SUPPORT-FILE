<?php

session_start();

require "../../support/inc.all.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');





$str = $_POST['data'];

$data=explode('##',$str);

$item_id = $data[0];



$d_price=$data[1];







 $sql = 'update item_info set d_price="'.$d_price.'" where item_id='.$item_id;

db_query($sql);

echo 'Updated!';

?>