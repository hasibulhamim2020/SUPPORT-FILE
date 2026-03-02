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

  $warehouse_id = $data[1];

$item_all= find_all_field('item_info','','item_id="'.$item[2].'"');

$in_stock_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$warehouse_id.'" ');
 $in_stock= (int)($in_stock_pcs );
 
 $in_stock_crt = number_format(($in_stock_pcs/$item_all->pack_size),2);
?>


<table>
			<tr>
			

<td width="25%">

        <input name="stockpcs" type="text" class="input3" id="stockpcs"  maxlength="100" style="width:70px;" value="<?=$in_stock?>"/>
		</td>
		
		<td width="25%">

        <input name="stockcrt" type="text" class="input3" id="stockcrt"  maxlength="100" style="width:70px;" value="<?=$in_stock_crt?>"/>
		</td>
		<td width="25%">
        <input name="unit_price" type="hidden" class="input3" id="unit_price"  maxlength="100" style="width:70px;" onkeyup="total_amtt()" value="<?php /*?><?=$item_all->sale_price?><?php */?>"/>
		
		<input name="crt_price" type="text" class="input3" id="crt_price"  maxlength="100" style="width:70px;" onkeyup="total_amtt()" value="<?=$item_all->sale_crt_price?>"/>
		
		</td>
		<td width="25%">
        
		
		<input name="pkt_size" id="pkt_size" type="text" value="<?=$item_all->pack_size?>" onkeyup="total_amtt()"  style="width:70px;"/>
		</td>
			</tr>
			</table>