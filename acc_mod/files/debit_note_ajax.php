
<?php
session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

$proj_id=$_SESSION['proj_id'];

$user_id=$_SESSION['user']['id'];

$tr_from = 'Payment';


$v_date		= $_SESSION['old_v_date']=$_REQUEST["date"];

$ledger_id	= $_REQUEST["ledger_id"];

$bank		= $_REQUEST["bank"];

$r_from		= $_REQUEST['r_from'];

$c_no		= $_REQUEST['c_no'];

$cheq_date		= $_REQUEST['c_date'];

$c_id		= $_REQUEST['c_id'];

$jv_date		= $_REQUEST['jv_date'];

$type		= $_REQUEST['type'];

//$bi_id		= explode('##>>',$_REQUEST['b_id']);

//$b_id		= $bi_id[1];

$b_id = $_REQUEST['b_id'];

$t_amount	= $_REQUEST['t_amount'];



if($type=='CASH'){
 $receive_ledger=$c_id;
 }else{
 $receive_ledger=$b_id;
 }

$ledgers = explode('::',$receive_ledger);



$search=array( ":"," ", "[", "]", $separater);

$ledger1=str_replace($search,'',$ledgers[0]);

$ledger2=str_replace($search,'',$ledgers[1]);

	

if(is_numeric($ledger1))

$receive_ledger = $ledger1;

else

$receive_ledger = $ledger2;

	//////////////////////////

			$ledger_id=$_REQUEST['ledger_id'];

			$ledgers = explode('::',$ledger_id);

			$ledger_id = $ledgers[0];

			$detail_status = $_REQUEST['detail'];		

			$cur_bal= $_REQUEST['cur_bal'];

			$detail = $_REQUEST['detail'];

			$amount = $_REQUEST['amount'];

			$cc_code = $_REQUEST['cc_code'];

			if($bank=='')

			$dnarr=$detail;

			else

			$dnarr=$detail.':: Cheq# '.$c_no.':: Date= '.$cheq_date;

$checked = 'UNFINISHED';

	

if($_SESSION['jv_no']==0){

 $jv_no = $_SESSION['jv_no'] = next_journal_sec_voucher_id($tr_from,'Payment');

 $tr_no = $_SESSION['tr_no'] = next_tr_no($tr_from);

}else{

		

$jv_no = $_SESSION['jv_no'];

$tr_no = $_SESSION['tr_no'];

	}
	 $receive_ledger;

add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, $amount, '0', $tr_from, $tr_no,'','',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$receive_ledger,$checked,$type,$employee);



 $sql2="select a.id, a.tr_no, a.jv_date,l.ledger_name,a.narration, a.dr_amt ,'Action'

from  secondary_journal a, accounts_ledger l where a.ledger_id=l.ledger_id and a.jv_no='".$_SESSION['jv_no']."' and tr_from='".$tr_from."' ";


$all_dealer[]=link_report_del($sql2);
$all_dealer[]=find_a_field('secondary_journal','sum(dr_amt)','tr_from = "'.$tr_from.'" and jv_no='.$_SESSION['jv_no']);
//echo link_report($all_dealer);
echo json_encode($all_dealer);

?>

