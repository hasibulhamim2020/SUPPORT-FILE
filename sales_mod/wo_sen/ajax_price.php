<?php
session_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$item_id =$_POST['id'];

$info = findall("select * from item_info where item_id='".$item_id."'");

$price = $info->m_price;
$unit = $info->unit_name;

$arr = array('price' => $price, 'unit' => $unit, 'direct_per' => $info->direct_per, 'item_name' => $info->item_name);

echo json_encode($arr);

?>