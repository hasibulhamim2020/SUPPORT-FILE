<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$proj_id 	= $_SESSION['proj_id'];
$paid_amount=$_GET['paid_amount'];
$id=$_GET['id'];


echo $sql="UPDATE `sales_invoice` SET `paid_amount` = '$paid_amount' WHERE `s_inv_id` ='$id'";
db_query($sql);

echo '<font color="green">SUCCESS</font>';


?>
