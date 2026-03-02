<?

session_start();



require "../../support/inc.all.php";




$p_date = $_REQUEST['p_date'];

$blend_type = $_REQUEST['blend_type'];

$item_id = $_REQUEST['item_id'];

$flag = $_REQUEST['flag'];

$warehouse_id = $_SESSION['user']['depot'];

$po_no = $_REQUEST['po_no'];

$pr_no = $_REQUEST['pr_no'];

$sale_no = $_REQUEST['sale_no'];

$order_no = $_REQUEST['order_no'];

$quality = $_REQUEST['quality'];

$vendor_id = $_REQUEST['vendor_id'];

$lot_no = $_REQUEST['lot_no'];

$garden_id = $_REQUEST['garden_id'];

$invoice_no = $_REQUEST['invoice_no'];

$pkgs = $_REQUEST['pkgs'];

$sam_qty = $_REQUEST['sam_qty'];

$qty = $_REQUEST['qty'];

$rate = $_REQUEST['rate'];

$amount = $_REQUEST['amount'];

$blend_issue = $_REQUEST['blend_issue'];

$closing_qty = $_REQUEST['closing_qty'];

 $entry_by = $_REQUEST['entry_by']=$_SESSION['user']['id'];

$entry_at = $_REQUEST['entry_at']=date('Y-m-d H:i:s');

$issue_no = (date('ymd',strtotime($p_date))*10000)+$blend_type;





if($_REQUEST['flag']!=0)

{

//Delete

 $delete_sql = "DELETE from black_tea_consumption where issue_no='".$issue_no."' and issue_date = '".$p_date."' and blend_type = '".$blend_type."' and order_no='".$order_no."' ";

db_query($delete_sql);

}


		$up_sql = "update purchase_receive set blend_issue='".$blend_issue."', closing_qty='".$closing_qty."' where id = ".$order_no;
		db_query($up_sql);


 $sql = "INSERT INTO black_tea_consumption (`issue_no`, `po_no`, `order_no`, `pr_no`, `issue_date`,  blend_type, `vendor_id`, `sale_no`, `item_id`, `warehouse_id`, `rate`, `qty`,  `amount`, `lot_no`, `garden_id`, `quality`, `invoice_no`, `pkgs`,  `status`, `sam_qty`, `entry_by`, `entry_at`) VALUES

('".$issue_no."','".$po_no."','".$order_no."', '".$pr_no."', '".$p_date."', '".$blend_type."', '".$vendor_id."', '".$sale_no."', '".$item_id."', '".$warehouse_id."','".$rate."', '".$qty."',  
'".$amount."','".$lot_no."','".$garden_id."','".$quality."','".$invoice_no."','".$pkgs."', 'MANUAL', '".$sam_qty."',  '".$entry_by."', '".$entry_at."')";



if(db_query($sql))

{

echo 'Success!';

}

?>