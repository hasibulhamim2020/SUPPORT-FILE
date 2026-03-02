<?

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$item_id=$_REQUEST['item_id'];

$dealer_code=$_REQUEST['dealer_code'];

$discount=$_REQUEST['discount'];

$set_price=$_REQUEST['set_price'];

$flag = $_REQUEST['flag'];
$now = date('Y-m-d H:i:s');

if($flag==0)

{ //sales_corporate_price , sales_price_dealer_type

$sql = 'INSERT INTO `sales_price_dealer` 

(`dealer_code`, `item_id`, `set_price`,`discount`, `entry_by`, `entry_at`) VALUES 

("'.$dealer_code.'", "'.$item_id.'", "'.$set_price.'","'.$discount.'", "'.$_SESSION['user']['id'].'", "'.$now.'")';

}

else

{

$sql = 'UPDATE `sales_price_dealer` SET  `set_price` = "'.$set_price.'",`discount` = "'.$discount.'", `edit_by` = "'.$_SESSION['user']['id'].'", `edit_at` = "'.$now.'" WHERE `dealer_code` = "'.$dealer_code.'" and `item_id` = "'.$item_id.'"';

}

db_query($sql);

echo 'Success!';

?>