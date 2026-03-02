<?php


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
 
 $stock_in_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ');
  $stock_in_ctn = $stock_in_pcs/$item_all->pack_size;
 
$price_sql='SELECT  * FROM sales_price_warehouse WHERE item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ';
$price_data = find_all_field_sql($price_sql);

?>


<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
<tr bgcolor="#CCCCCC">
	 <td width="50%">
	 <input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:98%;"   value="<?=$item_all->pack_size?>" readonly="readonly"/>
	 
	 <input name="ctn_stock" type="text" class="input3"  value="<?=number_format($stock_in_ctn,2);?>" id="ctn_stock" style="width:90%; height:30px;"  readonly="" /> </td>
	 <td width="50%"><input name="pcs_stock" type="text" class="input3"  value="<?=(int)$stock_in_pcs;?>" id="pcs_stock" style="width:90%; height:30px;" />
	 <input name="crt_price" type="hidden" class="input3" id="crt_price"  style="width:90%; height:30px;"  required="required"  value="<?=$price_data->crt_price;?>" readonly=""   />
	 <input name="unit_price" type="hidden" class="input3" id="unit_price"  style="width:90%; height:30px;" required="required"  value="<?=$price_data->unit_price;?>" readonly=""   />	 </td>
  </tr>
</table>






