<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
$warehouse=$data[0];
 $item_name = $data[1];


$item=explode("-",$item_name);

 $item_id =  $item[0];




//$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');


$in_stock_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$warehouse.'"');

 $in_stock =(int) ($in_stock_pcs);



?>



<input name="stock" type="text" class="input3" id="stock"  style="width:70px; height:30px;"  onkeyup="count()" value="<?=$in_stock?>" readonly required/>



<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input name="in_stock" type="text" class="input3" id="in_stock"  style="width:70px; height:30px" value="<?=$in_stock?>" readonly="readonly" onfocus="focuson('pkt_unit')" tabindex="1"  />
      <input name="item_id" type="hidden" class="input3" id="item_id"  style="width:width:80px; height:30px"  value="<?=$item_all->item_id?>" readonly="readonly"/></td>
    <td>
	
	  <? if ($do_type=="REGULAR") {?>
	  <input name="unit_price" type="hidden" class="input3" id="unit_price"  style="width:70px; height:30px" value="<?=$item_all->d_price?>"/>
      <input name="unit_price2" type="text" class="input3" id="unit_price2"  style="width:70px; height:30px" value="<?=($item_all->d_price)?>"/>
	  <? }?>
	  
	  <? if ($do_type=="ADVANCE") {?>
	  <input name="unit_price" type="hidden" class="input3" id="unit_price"  style="width:70px; height:30px" value="<?=$item_all->a_price?>"/>
      <input name="unit_price2" type="text" class="input3" id="unit_price2"  style="width:70px; height:30px" value="<?=$item_all->a_price?>"/>
	  <? }?>
	  
	   <? if ($do_type=="MAT") {?>
	  <input name="unit_price" type="hidden" class="input3" id="unit_price"  style="width:70px; height:30px" value="<?=$item_all->d_price?>"/>
      <input name="unit_price2" type="text" class="input3" id="unit_price2"  style="width:70px; height:30px" value="<?=($item_all->d_price)?>"/>
	  <? }?>
	  
	   <? if ($do_type=="CASH SALE") {?>
	  <input name="unit_price" type="text" class="input3" id="unit_price"  style="width:70px; height:30px" value="<?=$item_all->d_price?>"/>
	  <? }?>
	  
	  <? if ($do_type=="WASTAGE") {?>
	  <input name="unit_price" type="text" class="input3" id="unit_price"  style="width:70px; height:30px" value="<?=$item_all->d_price?>"/>
	  <? }?>
      <input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:80px; height:30px"  value="<?=$item_all->pack_size?>" readonly="readonly"/>
      <input  name="bag_size" type="hidden" id="bag_size" value="<?=$item_all->bag_size?>" readonly="readonly" tabindex="1"/></td>
  </tr>
</table><?php */?>
