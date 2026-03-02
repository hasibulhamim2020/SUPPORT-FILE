<?php

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$item=$data[0];

$finish_goods_code = $item;

$depot_id = $data[1];



$item_all= find_all_field('item_info','','finish_goods_code="'.$finish_goods_code.'"');

$in_stock_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" ');

//$ordered_qty = find_a_field('sale_do_details','sum(total_unit)','item_id="'.$item_all->item_id.'" and depot_id="'.$depot_id.'" and status in ("UNCHECKED","CHECKED","PROCESSING")');

//$del_qty = find_a_field('sale_do_chalan','sum(total_unit)','item_id="'.$item_all->item_id.'" and depot_id="'.$depot_id.'" and status in ("UNCHECKED","CHECKED","PROCESSING")');



$in_stock = (int)($in_stock_pcs / $item_all->pack_size);

?>

<script language="javascript">
if(document.getElementById("item").value>0 && document.getElementById("item").value=='<?php echo $finish_goods_code?>'){
alert('You Have Chosen Same Item Twice');
}
</script>

<table width="100%" border="1" cellspacing="0" cellpadding="0">

    <tr>

<td width="45%"><input name="item2" type="text" id="item2"  class="form-control" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('pkt_unit')"/></td>

<td width="18%"><input name="in_stock" pattern="[1-9]" type="text"  id="in_stock"  class="form-control" value="<?=$in_stock?>" readonly="readonly" onfocus="focuson('pkt_unit')"/>

<input name="item_id" type="hidden" id="item_id" class="form-control" value="<?=$item_all->item_id?>" readonly="readonly"/></td>

<td width="18%"><input name="undel" type="text" id="undel" class="form-control" readonly="readonly"  value="<?=(int)(($ordered_qty+$del_qty) / $item_all->pack_size)?>"/></td>




<td width="18%">

<input name="unit_price" type="hidden" id="unit_price" class="form-control" value="<?=$item_all->s_price?>"/>

<input name="unit_price2" type="text" id="unit_price2"  class="form-control" value="<?=($item_all->s_price*$item_all->pack_size)?>" onkeydown="count()"/>

<input name="pkt_size" type="hidden"  id="pkt_size" class="form-control"  value="<?=$item_all->pack_size?>" readonly="readonly"/>

<input  name="s_price" type="hidden" id="s_price" value="<?=$item_all->s_price?>" readonly="readonly"/></td>

    </tr>

  </table>

