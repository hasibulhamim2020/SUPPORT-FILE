<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
$item_id = $item[2];
if($item_id>0){
$stock = warehouse_product_stock($item_id ,$data[1]);
$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');}
?>
  
<input name="pack_size" type="hidden" class="input3" id="pack_size" style="width:40px;" value="<?=$item_all->pack_size?>" onfocus="focuson('qty_ctn')" readonly/>  
<input name="unit_name" type="text" class="input3" id="unit_name" style="width:100px;" value="<?=$item_all->unit_name?>" onfocus="focuson('qty_ctn')" readonly/>