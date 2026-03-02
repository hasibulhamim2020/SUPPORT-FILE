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
			if($rec_date!=date('Y-m-d'))
			$ex = '/Rec Date:'.$rec_date;
$narration_cr = 'DO#'.$do->do_no.'/'.find_a_field('accounts_ledger','ledger_name','ledger_id='.$ledger_dr).'/'.$do->payment_by.'/'.$do->branch.'/'.$acc_note.'/'.$do->remarks.$ex;
$narration_dr = 'DO#'.$do->do_no.'/'.find_a_field('accounts_ledger','ledger_name','ledger_id='.$ledger_cr).'/'.$do->payment_by.'/'.$do->branch.'/'.$acc_note.'/'.$do->remarks.$ex;
			$tr_from = 'Collection';
			$jv = 0;
		if($ledger_dr==0&&$do->payment_by!='Cash'){
		echo 'CASH ERROR!';
		}
		else
		{
		if($received_amt>0&&$do->payment_by!='Cash')
		{
			add_to_journal($proj_id, $jv_no, $jv_date, $ledger_cr, $narration_cr, '', $received_amt, $tr_from, $do_no);
			add_to_journal($proj_id, $jv_no, $jv_date, $ledger_dr, $narration_dr, $received_amt, '', $tr_from, $do_no);
		}
			$journal = "UPDATE `sale_do_master` SET `receive_acc_head` = '".$receive_acc_head."',`rec_date` = '".$rec_date."',`received_amt` = '".$received_amt."',`checked_at` = '".date('Y-m-d H:i:s')."',`checked_by` = '".$_SESSION['user']['id']."',`received_status` = 'received',final_jv_no='".$jv_no."',acc_note='".$acc_note."' WHERE `do_no` ='".$do_no."'";
			db_query($journal);
			echo 'Received!';
			}

}
?>