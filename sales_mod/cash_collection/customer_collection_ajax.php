<?

session_start();




 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$p_date = $_REQUEST['p_date'];

$warehouse_id = $_REQUEST['warehouse_id'];

$salesman = $_REQUEST['salesman'];

$dr_ledger_id = $_REQUEST['dr_ledger_id'];

$dealer_code = $_REQUEST['dealer_code'];

$ledger_id = $_REQUEST['ledger_id'];

$collection_amt = $_REQUEST['collection_amt'];

$flag = $_REQUEST['flag'];

$entry_by = $_REQUEST['entry_by']=$_SESSION['user']['id'];

$entry_at = $_REQUEST['entry_at']=date('Y-m-d H:i:s');

$collection_no = (date('ymd',strtotime($p_date))*10000)+$warehouse_id;

//$tr_count = (find_a_field('collection_from_customer','count('.$dealer_code.')','collection_date="'.$p_date.'" and dealer_code="'.$dealer_code.'"')+1);

// $tr_no = (date('ymd',strtotime($p_date))).$dealer_code.$tr_count;

$tr_no = next_transection_no($warehouse_id,$p_date,'collection_from_customer','tr_no');


if($_REQUEST['flag']!=0)

{

//Delete

 $delete_sql = "DELETE from black_tea_consumption where issue_no='".$issue_no."' and issue_date = '".$p_date."' and blend_type = '".$blend_type."' and order_no='".$order_no."' ";

db_query($delete_sql);

}




  $sql = "INSERT INTO collection_from_customer (`tr_no`, `collection_no`, `collection_date`, salesman, `warehouse_id`, `dealer_code`, `ledger_id`, `dr_ledger_id`, `collection_amt`,  `entry_at`, `entry_by`) VALUES

('".$tr_no."','".$collection_no."','".$p_date."', '".$salesman."', '".$warehouse_id."', '".$dealer_code."', '".$ledger_id."', '".$dr_ledger_id."', '".$collection_amt."', 
'".$entry_at."',  '".$entry_by."')";




if(db_query($sql))

{

echo 'Success!';

auto_insert_customer_collection_secoundary_journal($tr_no);

}



?>