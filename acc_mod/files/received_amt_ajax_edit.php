<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

if($_REQUEST['item_id']>0)
{
	$do_no = $_REQUEST['item_id'];
	$jv=next_journal_voucher_id();

			$do = find_all_field('sale_do_master','s','do_no='.$do_no);
			$jv_no=next_journal_voucher_id();
			$jv_date = time();
			$received_amt=$_REQUEST['ra'];
			$acc_note=$_REQUEST['no'];
			$receive_acc_head=$_REQUEST['receive_acc_head'];
			$rec_date=$_REQUEST['rec_date'];
			$ledger_cr = find_a_field('dealer_info','account_code','dealer_code='.$do->dealer_code);
			$ledger_dr = $receive_acc_head;
$narration_cr = 'DO#'.$do->do_no.'/'.find_a_field('accounts_ledger','ledger_name','ledger_id='.$ledger_dr).'/'.$do->payment_by.'/'.$do->branch.'/'.$acc_note.'/'.$do->remarks;
$narration_dr = 'DO#'.$do->do_no.'/'.find_a_field('accounts_ledger','ledger_name','ledger_id='.$ledger_cr).'/'.$do->payment_by.'/'.$do->branch.'/'.$acc_note.'/'.$do->remarks;
			$tr_from = 'Collection';
			$jv_cr_id = find_a_field('journal','id','tr_from="Collection" and tr_no="'.$do_no.'" and cr_amt>0');
			$jv_dr_id = find_a_field('journal','id','tr_from="Collection" and tr_no="'.$do_no.'" and dr_amt>0');
		if($received_amt>0&&$do->payment_by!='Cash')
		{

$sql_cr = "UPDATE journal SET ledger_id='$ledger_cr',narration='$narration_cr',cr_amt='$received_amt' WHERE id = ".$jv_cr_id;
$sql_dr = "UPDATE journal SET ledger_id='$ledger_dr',narration='$narration_dr',dr_amt='$received_amt' WHERE id = ".$jv_dr_id;
db_query($sql_cr);
db_query($sql_dr);
		}
$journal = "UPDATE `sale_do_master` SET `receive_acc_head` = '".$receive_acc_head."',`rec_date` = '".$rec_date."',`received_amt` = '".$received_amt."',acc_note='".$acc_note."' WHERE `do_no` ='".$do_no."'";
db_query($journal);
echo 'Received!';

}
?>