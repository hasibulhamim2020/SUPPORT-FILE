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

$req_date = $data[2];	
// find 3 month back date
$back_date = date('Y-m-d', strtotime('-3 months', strtotime($req_date)));

$consumption = find_a_field('journal_item','sum(item_ex)','item_id="'.$item_id.'" and ji_date between "'.$back_date.'" and "'.$req_date.'" and warehouse_id="'.$data[1].'" ');
$ratio = $consumption/3;

if($item_id>0){
	$stock = (int)warehouse_product_stock($item_id ,$data[1]);
	$last_p = find_all_field('purchase_invoice','','item_id="'.$item_id.'" order by id desc');
	$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');
}

?>
<table style="width:100%;" border="1">
						 <tr>
<td width="20%"><input name="qoh" type="text" class="input3" id="qoh" style="width:98%;" value="<?=$stock?>"  readonly/>  </td>

<td width="20%"><input name="last_p_qty" type="text" class="input3" id="last_p_qty" style="width:98%;" value="<?=$last_p->qty?>" onfocus="focuson('qty')" />  </td>

<td width="20%"><input name="last_p_date" type="text" class="input3" id="last_p_date"  style="width:98%;" value="<?=$last_p->po_date?>" onfocus="focuson('qty')" />  </td>

<td width="20%"><input name="last_pur_rate" type="text" class="input3" id="last_pur_rate"  style="width:98%;" value="<?=$last_p->rate?>" onfocus="focuson('qty')" />  </td>
<td width="10%"><input name="ratio3m" type="text" class="input3" id="ratio3m"  style="width:98%;" value="<?=$ratio?>" onfocus="focuson('qty')" />  </td>

<td width="10%"><input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:98%;" value="<?=$item_all->unit_name?>" onfocus="focuson('qty')" /></td>
</tr></table>