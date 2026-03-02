<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
$pos_id = $_REQUEST['pos_id'];
$item_id = $_REQUEST['item_id'];
$register_mod = $_REQUEST['register_mode'];
$group_id = $_SESSION['user']['group'];
$dealer_id = $_REQUEST['customer_name'];
$pos_date = date("Y-m-d");
$warehouse_id = $_SESSION['user']['depot'];
$main_status = "MANUAL";
$entry_by = $_SESSION['user']['id'];

$con.=" and item_info.finish_goods_code like '".$item_id."'";
$cus_sql = "select item_info.*, sum(journal_item.item_in-journal_item.item_ex) as stock from item_info left join journal_item on journal_item.item_id = item_info.item_id and journal_item.warehouse_id='".$_SESSION['user']['depot']."' where 1 ".$con;

$cus_query = db_query($cus_sql);
$data = mysqli_fetch_assoc($cus_query);
extract($data);
//if($stock>0){ 
$total_amt = 1*$d_price;
$checking_pos_id = find_a_field('sale_pos_master', 'pos_id', 'post_id='.$pos_id);
if($checking_pos_id=="" || $checking_pos_id==0){
$isql = "INSERT INTO `sale_pos_master`(`pos_id`, `pos_date`, `group_for`, `dealer_id`,`warehouse_id`, `register_mode`, `status`, `entry_by`) VALUES ('$pos_id','$pos_date','$group_id','$dealer_id','$warehouse_id','$register_mod','$main_status','$entry_by')";
db_query($isql);
}    
$iisql = "INSERT INTO `sale_pos_details`(`pos_id`, `pos_date`, `group_for`, `item_id`, `dealer_id`, `qty`, `rate`, `total_amt`, `warehouse_id`) VALUES ('$pos_id','$pos_date','$group_id','$item_id','$dealer_id','1','$d_price','$total_amt','$warehouse_id')";
db_query($iisql);
$all_dealer[] ="Data Inserted";
//}else{
//$all_dealer[] ="No Stock Found";
//}
echo json_encode($all_dealer);
?>