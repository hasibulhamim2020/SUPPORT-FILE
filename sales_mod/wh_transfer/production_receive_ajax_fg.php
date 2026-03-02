<?php

session_start();

require "../../support/inc.all.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$item=explode('#>',$data[0]);

$item_id=$item[2];



$item_all= find_all_field('item_info','','item_id="'.$item[2].'"');
$in_stock_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" ');
$in_stock = (int)($in_stock_pcs / $item_all->pack_size);
?>

<input name="total_unit2" type="text" class="input3" style="width:50px;" onfocus="focuson('total_pkt')" value="<?=$item_all->unit_name?>"/>    

<input name="pkt_size" id="pkt_size" type="hidden" value="<?=$item_all->pack_size?>"/>

        <input name="old_production_date" type="text" class="input3" id="stock2"  maxlength="100" style="width:60px;" value="<?=$in_stock?>"/>
        <input name="old_production_date2" type="text" class="input3" id="rate2"  maxlength="100" style="width:60px;" value="<?=$item_all->d_price?>"/>