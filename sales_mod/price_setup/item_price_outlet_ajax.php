<?
session_start();
require "../../support/inc.all.php";

$item_id=$_REQUEST['item_id'];
$dealer_code=$_REQUEST['dealer_code'];
$discount=$_REQUEST['discount'];
$set_price=$_REQUEST['set_price'];
$flag = $_REQUEST['flag'];
$ssql = 'select dealer_code from dealer_info where dealer_outlet_name ="'.$dealer_code.'"';
$qqiery = db_query($ssql);
while($dealer = mysqli_fetch_object($qqiery)){
$find = find_a_field('sales_corporate_price','set_price','dealer_code = "'.$dealer->dealer_code.'" and `item_id` = "'.$item_id.'"');
	if($find==0)
	{
	$sql = 'INSERT INTO `sales_corporate_price` 
	(`dealer_code`, `item_id`, `set_price`,`discount`, `entry_by`, `entry_at`) VALUES 
	("'.$dealer->dealer_code.'", "'.$item_id.'", "'.$set_price.'","'.$discount.'", "'.$_SESSION['user']['id'].'", "'.date('Y-m-d H:s:i').'")';
	}
	else
	{
	$sql = 'UPDATE `sales_corporate_price` SET  `set_price` = "'.$set_price.'",`discount` = "'.$discount.'", `edit_by` = "'.$_SESSION['user']['id'].'", `edit_at` = "'.date('Y-m-d H:s:i').'" 
	WHERE `dealer_code` = "'.$dealer->dealer_code.'" and `item_id` = "'.$item_id.'"';
	}

	db_query($sql);
}
echo 'Success!';
?>