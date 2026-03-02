<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $str = $_POST['data'];


$data=explode('##',$str);


   $order_no=$data[0];
   $sales_type=$data[1];
   
  
  $order_data=find_all_field('sale_do_details','',"id=".$order_no);
  
  
  if($order_data->unit_name=="Pcs"){
  $produced_qty=find_a_field('sale_do_chalan','sum(total_unit)',"order_no=".$order_no);
  
  $pending_qty = $order_data->total_unit-$produced_qty;
}else {
    $produced_qty=find_a_field('sale_do_chalan','sum(bag_size)',"order_no=".$order_no);
  
  $pending_qty = $order_data->qty_kg-$produced_qty;
}


?>

<table  width="100%" border="1" align="left"  cellpadding="2" cellspacing="2">
		<tr>
		    	<td>	<input  name="unit_name" type="text" id="unit_name" value="<?=$order_data->unit_name?>" readonly="" style="width:30px;height:30px; font-size:14px;" /></td>
			<td><input  name="size" type="text" id="size" value="<? if($order_data->s_w>0) {?><?=$order_data->s_w?><? }?><? if($order_data->s_h>0) {?>X<?=$order_data->s_h?><? }?><? if($order_data->s_g>0) {?>X<?=$order_data->s_g?><? }?>" style="width:130px;height:30px; font-size:14px;" />
			
			<input  name="s_w" type="hidden" id="s_w" value="<?=$order_data->s_w?>" readonly="" style="width:60px;height:30px; font-size:14px;" />
			<input  name="s_h" type="hidden" id="s_h" value="<?=$order_data->s_h?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="s_g" type="hidden" id="s_g" value="<?=$order_data->s_g?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="item_id" type="hidden" id="item_id" value="<?=$order_data->item_id?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="unit_name" type="hidden" id="unit_name" value="<?=$order_data->unit_name?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="do_no" type="hidden" id="do_no" value="<?=$order_data->do_no?>"  readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="job_no" type="hidden" id="job_no" value="<?=$order_data->job_no?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="order_no" type="hidden" id="order_no" value="<?=$order_no;?>"  readonly="" style="width:60px;height:30px; font-size:14px;" />		
			
			<input  name="do_date" type="hidden" id="do_date" value="<?=$order_data->do_date?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$order_data->dealer_code?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="unit_price" type="hidden" id="unit_price" value="<?=$order_data->unit_price?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />

			
			<input  name="colour_h" type="hidden" id="colour_h" value="<?=$order_data->colour_h?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="colour_g" type="hidden" id="colour_g" value="<?=$order_data->colour_g?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="colour_pp" type="hidden" id="colour_pp" value="<?=$order_data->colour_pp?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="colour_pra" type="hidden" id="colour_pra" value="<?=$order_data->colour_pra?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="colour_prb" type="hidden" id="colour_prb" value="<?=$order_data->colour_prb?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="colour_prc" type="hidden" id="colour_prc" value="<?=$order_data->colour_prc?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
			<input  name="colour_prd" type="hidden" id="colour_prd" value="<?=$order_data->colour_prd?>" readonly=""  style="width:60px;height:30px; font-size:14px;" />
	
				</td>
				
		
			<td><input  name="gsm" type="text" id="gsm" value="<?=$order_data->gsm?>" readonly=""  style="width:60px;height:30px; font-size:14px;" /></td>
			<td><input  name="colour_view" type="text" id="colour_view" readonly=""  value="<?=find_a_field('colour','colour','id="'.$order_data->colour_b.'"');?>" style="width:80px;height:30px; font-size:14px;" />
			<input  name="colour_b" type="hidden" id="colour_b" readonly=""  value="<?=$order_data->colour_b?>" style="width:80px;height:30px; font-size:14px;" /></td>
			<td><input  name="print_name" type="hidden"  readonly="" id="print_name" value="<?=$order_data->print_name?>" style="width:120px;height:30px; font-size:14px;" />
			<input  name="print_name_view" type="text" readonly=""  id="print_name_view" value="<?=find_a_field('dealer_print_name','print_name','id="'.$order_data->print_name.'"');?>" style="width:120px;height:30px; font-size:14px;" /></td>
			<td><input  name="order_qty" type="text" readonly=""  id="order_qty" value="<?=($order_data->unit_name="Kg") ? $order_data->qty_kg : $order_data->total_unit ?>" style="width:80px;height:30px; font-size:14px;" /></td>
			<td><input  name="pending_qty" type="text" readonly=""  id="pending_qty" value="<?=$pending_qty?>" style="width:70px;height:30px; font-size:14px;" />
			
			<? if($pending_qty>0) {
			
			$cow++;
}  else { $cow=0; } ?>
			</td>
		    <td>
			
			<? if($order_data->sales_type==2) {?>
				
			<input list="barcode_ids" id="barcode_id" name="barcode_id" required  style="width:150px;"  onchange="getData2('pr_data_ajax.php', 'pr_weight_filter', this.value, document.getElementById('barcode_id').value);"  />
			<datalist id="barcode_ids"  >
	  		<option></option>
        	<? foreign_relation('production_receive_detail','id','barcode',$barcode_id,'order_no="'.$order_no.'" and status in("RECEIVED","PURCHASE RECEIVED")'); ?>
        	</datalist>
			<? }?>
			
			
			<? if($order_data->sales_type==1) {?>
			<input list="barcode_ids" id="barcode_id" name="barcode_id" required  style="width:150px;"  onchange="getData2('pr_data_ajax.php', 'pr_weight_filter', this.value, document.getElementById('barcode_id').value);"  />
			<datalist id="barcode_ids" >
	  		<option></option>
        	<? foreign_relation('production_receive_detail','id','barcode',$barcode_id,'item_id="'.$order_data->item_id.'" and colour="'.$order_data->colour_b.'" and gsm="'.$order_data->gsm.'"
			and s_w="'.$order_data->s_w.'" and s_h="'.$order_data->s_h.'" and s_g="'.$order_data->s_g.'" and status in("RECEIVED","PURCHASE RECEIVED") and warehouse_id='.$order_data->depot_id.''); ?>
        	</datalist>
			<? }?>
			
			
			</td>
		</tr>
	</table>






