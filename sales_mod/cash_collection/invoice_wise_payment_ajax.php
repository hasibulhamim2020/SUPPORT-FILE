<?

session_start();



require "../../support/inc.all.php";

$po_no = $_REQUEST['po_no'];

$p_date = $_REQUEST['p_date'];

$cr_ledger_id = $_REQUEST['cr_ledger_id'];

$vendor_id = $_REQUEST['vendor_id'];

$po_date = $_REQUEST['po_date'];

$payment_amt = $_REQUEST['payment_amt'];

$flag = $_REQUEST['flag'];

$entry_by = $_REQUEST['entry_by']=$_SESSION['user']['id'];

$entry_at = $_REQUEST['entry_at']=date('Y-m-d H:i:s');

$payment_no = (date('ymd',strtotime($p_date))*10000)+$po_no;

$tr_count = (find_a_field('purchase_bill_payment','count('.$vendor_id.')','payment_date="'.$p_date.'" and vendor_id="'.$vendor_id.'"')+1);

 $tr_no = (date('ymd',strtotime($p_date))).$vendor_id.$tr_count;


if($_REQUEST['flag']!=0)

{

//Delete

 $delete_sql = "DELETE from black_tea_consumption where issue_no='".$issue_no."' and issue_date = '".$p_date."' and blend_type = '".$blend_type."' and order_no='".$order_no."' ";

db_query($delete_sql);

}




  $sql = "INSERT INTO purchase_bill_payment ( `po_no`, `po_date`, `invoice_no`, `payment_no`, `payment_date`, `group_for`, `vendor_id`, cr_ledger_id, `amount`, `entry_by`, `entry_at`) VALUES

('".$po_no."','".$po_date."', '".$invoice_no."', '".$payment_no."', '".$p_date."', '".$group_for."', '".$vendor_id."', '".$cr_ledger_id."', '".$payment_amt."', 
'".$entry_by."',  '".$entry_at."')";




if(db_query($sql))

{

echo 'Success!';

//auto_insert_customer_collection_secoundary_journal($tr_no);

}



?>