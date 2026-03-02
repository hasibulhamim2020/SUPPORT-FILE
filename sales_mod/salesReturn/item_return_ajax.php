<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
 $data=explode('##',$str);
$info=explode('#$#',$data[0]);
$item=explode('#>',$info[0]);

$vendor=$info[1];
$item_all= find_all_field('item_info','','item_id="'.$item[1].'"');
$warehouse_id = $data[1];
$stock = (int)(warehouse_product_stock($item[1] ,$warehouse_id));
$v_type = find_a_field('dealer_info','dealer_type','dealer_code='.$vendor);
if($v_type=='Corporate')
{ $rate = find_a_field('sales_corporate_price','set_price','item_id="'.$item_all->item_id.'" and dealer_code="'.$vendor.'"');}
else $rate = $item_all->d_price;
?>

<table width="100%" cellpadding="0" cellspacing="0" border="1">
   <tr>
      <td width="50%"><input name="unit_name" type="text" class="input3" id="unit_name" style="width:100%;" value="<?=$item_all->unit_name?>" readonly required onfocus="focuson('rate')"/></td>
      <td width="50%"><input name="rate" type="text" class="input3" id="rate"  maxlength="100" style="width:100%;" onchange="count()" value="<?=$rate?>"    required/></td>
   </tr>
</table>

