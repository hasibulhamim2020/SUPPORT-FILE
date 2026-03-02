<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
if(isset($_POST['date'])){
    $pos_date = $_POST['date'];
    $customer_name = $_POST['customer_name'];
	if(strpos($customer_name, "::")==true){
	$new_item_id = explode("::", $customer_name)	;
	$dealer_id = find_a_field('dealer_info', 'dealer_code', 'customer_id = "'.$new_item_id[0].'"');
		}
	else{
	$dealer_id = find_a_field('dealer_info', 'dealer_code', ' (customer_id = "'.$customer_name.'" or dealer_name_e like "%'.$customer_name.'%" )');
	}
	
    $customer_address = $_POST['customer_address'];
    $total_discount = $_POST['total_discount'];
    $grand_total = $_POST['grand_total'];
    $paid_amount = $_POST['paid_amount'];
	$vat_percent = $_POST['vat_percent'];
	$warehouse_id = $_POST['wr_id'];
	$group_for = $_POST['group_for'];
    $due = $_POST['due'];
    $entry_by = $_SESSION['user']['id'];
	
	if(isset($date) || $pos_date!=""){
	$iquery = "INSERT INTO `sale_pos_master`(`pos_date`, `group_for`, `dealer_id`, `total_discount`, `vat_percent`, `grand_total`, `paid_amount`, `due`, `warehouse_id`, `entry_by`, `entry_at`) 
	VALUES ('$pos_date', '$group_for', 
	 '$dealer_id','$total_discount','$vat_percent','$grand_total','$paid_amount','$due','$warehouse_id','$entry_by','".date('Y-m-d H:i:s')."')";
	$done_i = db_query($iquery);
	
	$latest_pos_info = mysqli_fetch_object(db_query("select * from sale_pos_master where entry_by  = '".$entry_by."' order by pos_id desc limit 0, 1"));
	$sent_pos_id['pos_id'] = $latest_pos_info->pos_id;
	foreach($_POST['item_code'] as $key => $item_id){
		$item_ex = $_POST['qty'][$key];
		
		$rate=$_POST['rate'][$key];
    $dd_i = "INSERT INTO `sale_pos_details`(`pos_id`, `pos_date`,  `group_for`, `item_id`, `dealer_id`, `qty`, `rate`, `total_amt`, `warehouse_id`) VALUES ('".$latest_pos_info->pos_id."','$pos_date', '$group_for','$item_id','$dealer_id','".$_POST['qty'][$key]."','".$_POST['rate'][$key]."',".($_POST['qty'][$key]*$_POST['rate'][$key]).",'$warehouse_id')";
	db_query($dd_i);

    }
	$rr_sql  = "select * from sale_pos_details where pos_id = '".$latest_pos_info->pos_id."' order by id asc";
	$rr_query = db_query($rr_sql);
	while($data = mysqli_fetch_assoc($rr_query )){
		extract($data);
		$ji_date = $pos_date;
		$item_in = 0;
		$item_ex = $qty;
		$tr_from="POS Sale";
		$tr_no = $id;
		$sr_no = $pos_id;
		journal_item_control($item_id ,$warehouse_id,$ji_date,$item_in,$item_ex,$tr_from,$tr_no,$rate,$r_warehouse='',$sr_no,$c_price='',$lot_no='',$vendor_id='');
		}
	
		if($done_i){
		echo json_encode($sent_pos_id);	
			}else{
		echo 0;			
				}
	
		}
	
	
    
    
}

?>