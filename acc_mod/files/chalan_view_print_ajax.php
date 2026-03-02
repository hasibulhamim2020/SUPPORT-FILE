<?php
session_start();
require "../../damage_mod/support/inc.all.acc.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$id = $data[0];
$rate = $data[1];

$damage = find_all_field('purchase_receive','','id="'.$id.'"');
$qty = $damage->qty;
$amount = $rate*$qty;
$s = 'update purchase_receive set amount = "'.$amount.'", rate = "'.$rate.'", qty = "'.$qty.'" where id = "'.$id.'"';
$sql = db_query($s);

reinsert_auto_insert_purchase_secoundary_update($damage->pr_no);
echo 'SET';
?>