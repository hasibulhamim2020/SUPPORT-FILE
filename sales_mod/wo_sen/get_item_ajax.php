<?php


// $tst = 'omar';

session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $str = $_POST['data'];


$data=explode('##',$str);


   //$item_id=$data[0];
   $do_no=$data[1];
   $item_id = $item[1];
  
  
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

<input list="item_list" name="item_id" type="text" value="" id="item_id" onblur="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);"/>
							
							<datalist id="item_list">
								<?php 
								$sql='select * from item_info where 1 and sub_group_id="'.$item_id.'"';
								$query=db_query($sql);
								while($row=mysqli_fetch_object($query)){
								
								?> 
								  <option value="<?php echo $row->finish_goods_code."-".$row->item_name."#>".$row->item_id;?>">
								  <?php 
								  }
								  ?>
								 
								</datalist>






