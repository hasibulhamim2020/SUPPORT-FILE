<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$item=$data[0];

$finish_goods_code = $item;


$data2= $data[1];
$data_ex = explode('<#>',$data2);
 $depot_id = $data_ex[0];
$dealer_code = $data[2];


$item_all= find_all_field('item_info','','item_id="'.$finish_goods_code.'"');
$in_stock_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" ');

$price_data = find_all_field('sales_price_warehouse','','item_id="'.$item_id->item_id.'" and warehouse_id="'.$depot_id.'" ');



 $price_sql='SELECT  * FROM sales_price_warehouse WHERE item_id="'.$finish_goods_code.'" and warehouse_id="'.$depot_id.'" ';
$price_data = find_all_field_sql($price_sql);


//$ordered_qty = find_a_field('sale_do_details','sum(total_unit)','item_id="'.$item_all->item_id.'" and depot_id="'.$depot_id.'" and status in ("UNCHECKED","CHECKED","PROCESSING")');

//$del_qty = find_a_field('sale_do_chalan','sum(total_unit)','item_id="'.$item_all->item_id.'" and depot_id="'.$depot_id.'" and status in ("UNCHECKED","CHECKED","PROCESSING")');



$in_stock = ($in_stock_pcs / $item_all->pack_size);

?>

<script language="javascript">
if(document.getElementById("item").value>0 && document.getElementById("item").value=='<?php echo $finish_goods_code?>'){
alert('You Have Chosen Same Item Twice');
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

<td style="width:45%"><input name="item2" type="text" class="input3" id="item2"  style="width:98%;" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('pkt_unit')"/></td>

<td width=""><input name="in_stock" pattern="[1-9]" type="text" class="input3" id="in_stock"  style="width:98%;"  value="<?=$in_stock?>" readonly="readonly" onfocus="focuson('pkt_unit')"/>

<input name="item_id" type="hidden" class="input3" id="item_id"  style="width:98%;"   value="<?=$item_all->item_id?>" readonly="readonly"/></td>

<td width="">
<input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:98%;"   value="<?=$item_all->pack_size?>" readonly="readonly"/>
<input name="unit_price" type="text" class="input3" id="unit_price"  readonly="" style="width:98%;"  value="<?=$price_data->unit_price?>"/>

<input name="crt_price" type="hidden" class="input3" id="crt_price"  readonly="" style="width:98%;"  value="<?=$price_data->crt_price?>"/>

</td>



  </table>

