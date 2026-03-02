<?php


// $tst = 'omar';

session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $str = $_POST['data'];


$data=explode('##',$str);


   $item_id=$data[0];
   $do_no=$data[1];
  
  
 $item_all= find_all_field('item_info','','item_id="'.$item_id.'"');
 

 $do_sql='SELECT  * FROM sale_do_master WHERE do_no="'.$do_no.'" ';
 $do_data = find_all_field_sql($do_sql);
 $dealer_type = find_a_field('dealer_info','dealer_type','dealer_code="'.$do_data->dealer_code.'"');
 
 $dealer_price = find_a_field('sales_price_dealer','set_price','item_id="'.$item_id.'" and dealer_code="'.$do_data->dealer_code.'"');
 $dealer_type_price = find_a_field('sales_price_dealer_type','set_price','item_id="'.$item_id.'" and dealer_type="'.$dealer_type.'"');
 
 if($dealer_price>0){
 $item_sales_price = $dealer_price;
 }elseif($dealer_type_price>0){
 $item_sales_price = $dealer_type_price;
 }else{
 $item_sales_price=$item_all->d_price;
 }
 
 $stock_in_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ');
  $stock_in_ctn = $stock_in_pcs/$item_all->pack_size;
 
//$price_sql='SELECT  * FROM sales_price_warehouse WHERE item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ';
//$price_data = find_all_field_sql($price_sql);

?>


<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
<tr bgcolor="#CCCCCC">
	 <td width="42%">
	 <input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:98%;"   value="<?=$item_all->pack_size?>" readonly="readonly"/>
	 
	 <input name="item_name" type="text" class="input3"  value="<?=$item_all->item_name;?>" id="item_name" style="width:90%; height:30px;"  readonly="" /> </td>
	 
	 
	 <td width="20%"><input name="unit_name" type="text" class="input3"  value="<?=$item_all->unit_name;?>" id="unit_name" style="width:90%; height:30px;" /></td>

								 
	 <td width="20%"><input name="pcs_stock" type="text" class="input3"  value="<?=(int)$stock_in_pcs;?>" id="pcs_stock" style="width:90%; height:30px;" /></td>
	 <td width="20%"><input name="unit_price" type="text" class="input3" id="unit_price" onkeyup="count()"  style="width:90%; height:30px;" required="required"  value="<?=$item_sales_price?>"   /></td>
</tr>
</table>






