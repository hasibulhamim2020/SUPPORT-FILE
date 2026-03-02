<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$item_id=$_REQUEST['item_id'];
$dealer_code=$_REQUEST['dealer_code'];
//$discount=$_REQUEST['discount'];
$set_price=$_REQUEST['discount'];
$flag = $_REQUEST['flag'];
if($flag==0)
{
 $sql = 'INSERT INTO `sales_corporate_price` 
(`dealer_code`, `item_id`, `set_price`,`entry_by`, `entry_at`) VALUES 
("'.$dealer_code.'", "'.$item_id.'", "'.$set_price.'", "'.$_SESSION['user']['id'].'", "'.date('Y-m-d H:s:i').'")';
}
else
{
 $sql = 'UPDATE `sales_corporate_price` SET  `set_price` = "'.$set_price.'",`edit_by` = "'.$_SESSION['user']['id'].'", `edit_at` = "'.date('Y-m-d H:s:i').'" WHERE `dealer_code` = "'.$dealer_code.'" and `item_id` = "'.$item_id.'"';
}
db_query($sql);
echo 'Success!';
?>