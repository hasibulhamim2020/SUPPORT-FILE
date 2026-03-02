<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$rcv_sub_ledger =$_REQUEST['rcv_ledger'];
$rcv_ledger = find_a_field('general_sub_ledger','ledger_id','sub_ledger_id="'.$rcv_sub_ledger.'"');
$cus_ledger=$_REQUEST['cus_ledger']; 
$rec_amt=$_REQUEST['rec_amt']; 
$do_no=$_REQUEST['do_no']; 
$fr_date=$_REQUEST['fr_date']; 
$tr_date=$_REQUEST['tr_date']; 
$rec_date=$_REQUEST['rec_date']; 
$group_for=$_REQUEST['group_for'];

$expense_amt = $_REQUEST['expense_amt'];
$expense_ledger = $_REQUEST['expense_ledger'];



 
$dealer = find_a_field('sale_do_master','dealer_code','do_no="'.$do_no.'"');
$dealer_sub_ledger = find_a_field('dealer_info','sub_ledger_id','dealer_code="'.$dealer.'"');

 
$jv_no=next_journal_sec_voucher_id();
$user_id=$_SESSION['user']['id'];


   $sql = "INSERT INTO `secondary_journal` ( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `received_from`, `sub_ledger`, `cc_code`, `tr_id`, `do_no`, `group_for`, `entry_by`,  `checked`) VALUES ('clouderp', '$jv_no', '$rec_date', '$rcv_ledger', 'SALES_CASH_RECEIPT', '$rec_amt', '0', 'Receipt', '$do_no', '', '$rcv_sub_ledger','', '$do_no', '$do_no', '$group_for', '$user_id',  'YES')";
db_query($sql);
if($expense_amt>0){
$sql3 = "INSERT INTO `secondary_journal` ( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `received_from`, `sub_ledger`, `cc_code`, `tr_id`, `do_no`, `group_for`, `entry_by`,  `checked`) VALUES ('clouderp', '$jv_no', '$rec_date', '$expense_ledger', 'SALES_CASH_RECEIPT', '$expense_amt', '0', 'Receipt', '$do_no', '', '$rcv_sub_ledger','', '$do_no', '$do_no', '$group_for', '$user_id',  'YES')";
db_query($sql3);
}
$sql2 = "INSERT INTO `secondary_journal` ( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `received_from`, `sub_ledger`, `cc_code`, `tr_id`, `do_no`, `group_for`, `entry_by`,  `checked`) VALUES ('clouderp', '$jv_no', '$rec_date', '$cus_ledger', 'SALES_CASH_RECEIPT', '0', ($rec_amt+$expense_amt), 'Receipt', '$do_no', '', '$dealer_sub_ledger','', '$do_no', '$do_no', '$group_for', '$user_id',  'YES')";
db_query($sql2);



$jv_id=next_journal_voucher_id();
sec_journal_journal($jv_no,$jv_id,'Receipt');
		$sql2qq = 'update sale_do_details set status="UNCHECKED" where do_no = '.$do_no;
		db_query($sql2qq);
		
		  $sql3 = 'update sale_do_master set status="UNCHECKED" where do_no = '.$do_no;
		db_query($sql3);
		
		
		$sql4qq = 'update sale_do_master set sa_approval="APPROVED" where do_no = '.$do_no;
		db_query($sql4qq);
		
		  $sql5 = 'update sale_do_master set sa_approved_by="'.$_SESSION['user']['id'].'" where do_no = '.$do_no;
		db_query($sql5);
		
		$sql6 = 'update sale_do_master set sa_approved_at="'.date('Y-m-d H:i:s').'" where do_no = '.$do_no;
		db_query($sql6);

echo '<input type="button" class="btn btn-danger btn-sm" style="color: #fff;background-color: #dc3545;border-color: #dc3545;"  value="Cash Collected" " />';
?>