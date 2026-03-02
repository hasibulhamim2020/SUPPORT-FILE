<?
require_once "../../../assets/template/layout.top.php";


$rcv_ledger=$_REQUEST['rcv_ledger']; 
$cus_ledger=$_REQUEST['cus_ledger']; 
$rec_amt=$_REQUEST['rec_amt']; 
$do_no=$_REQUEST['do_no']; 
$fr_date=$_REQUEST['fr_date']; 
$tr_date=$_REQUEST['tr_date']; 
$rec_date=$_REQUEST['rec_date']; 
 


 
$jv_no=next_journal_sec_voucher_id();
$user_id=$_SESSION['user']['id'];
$sql = "INSERT INTO `secondary_journal` ( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `received_from`, `sub_ledger`, `cc_code`, `tr_id`, `do_no`, `group_for`, `entry_by`,  `checked`) VALUES ('BTC', '$jv_no', '$rec_date', '$rcv_ledger', 'SALES_CASH_RECEIPT', '$rec_amt', '0', 'Receipt', '$do_no', '', '','', '$do_no', '$do_no', '2', '$user_id',  'NO')";
mysql_query($sql);

$sql2 = "INSERT INTO `secondary_journal` ( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `received_from`, `sub_ledger`, `cc_code`, `tr_id`, `do_no`, `group_for`, `entry_by`,  `checked`) VALUES ('BTC', '$jv_no', '$rec_date', '$cus_ledger', 'SALES_CASH_RECEIPT', '0', '$rec_amt', 'Receipt', '$do_no', '', '','', '$do_no', '$do_no', '2', '$user_id',  'NO')";
mysql_query($sql2);
$jv_id=next_journal_voucher_id();
sec_journal_journal($jv_no,$jv_id,'Receipt');
//$up_sql='update sale_pos_master set cash_collec="YES",cash_collec_amount="'.$rec_amt.'" where pos_id="'.$pos_no.'"';
//mysql_query($up_sql);

echo '<input type="button" class="btn btn-danger btn-sm" style="color: #fff;background-color: #dc3545;border-color: #dc3545;"  value="Cash Collected" " />';
?>