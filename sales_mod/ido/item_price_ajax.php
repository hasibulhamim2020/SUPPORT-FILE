<?

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$item_id=$_REQUEST['item_id'];

$warehouse_id=$_REQUEST['warehouse_id'];

$crt_price=$_REQUEST['crt_price'];
$unit_price=$_REQUEST['unit_price'];
$pack_size=$_REQUEST['pack_size'];
$set_price=$_REQUEST['set_price'];

$flag = $_REQUEST['flag'];
$now = date('Y-m-d H:i:s');

if($flag==0)

{ //sales_corporate_price , sales_price_dealer_type

$sql = 'INSERT INTO `sales_price_warehouse` 

(`warehouse_id`, `item_id`, `pack_size`,`crt_price`, unit_price, `entry_by`, `entry_at`) VALUES 

("'.$warehouse_id.'", "'.$item_id.'",  "'.$pack_size.'", "'.$crt_price.'","'.$unit_price.'", "'.$_SESSION['user']['id'].'", "'.$now.'")';

}

else

{

$sql = 'UPDATE `sales_price_warehouse` SET  `pack_size` = "'.$pack_size.'",`crt_price` = "'.$crt_price.'", `unit_price` = "'.$unit_price.'", `edit_by` = "'.$_SESSION['user']['id'].'", `edit_at` = "'.$now.'" WHERE `warehouse_id` = "'.$warehouse_id.'" and `item_id` = "'.$item_id.'"';

}

db_query($sql);

echo 'Success!';

?>