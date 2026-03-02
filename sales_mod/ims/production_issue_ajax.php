<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
$item_id=$item[2];
$warehouse_id = $_SESSION['user']['depot'];
$warehouse_to = $data[1];
$stock = warehouse_product_stock($item_id ,$warehouse_id);

$last_p = find_all_field('production_issue_detail','','item_id="'.$item[2].'" and warehouse_to = "'.$warehouse_to.'" order by id desc');
$item_all= find_all_field('item_info','','item_id="'.$item[2].'"');
?>
<input name="total_unit2" type="text" class="input3" style="width:77px;" onfocus="focuson('total_unit')" value="<?=$item_all->unit_name?>"/>      
<input name="total_unit3" type="text" class="input3" style="width:67px;" onfocus="focuson('total_unit')" value="<?=$stock?>"/>       
<input name="total_unit4" type="text" class="input3" style="width:67px;" onfocus="focuson('total_unit')" value="<?=$last_p->total_unit?>"/>      
<input name="total_unit5" type="text" class="input3" style="width:67px;" onfocus="focuson('total_unit')" value="<?=$last_p->pi_date?>"/> 