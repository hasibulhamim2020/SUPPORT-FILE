<?
session_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$entry_at = date('Y-m-d H:i:s');
if($_REQUEST['ledgerID']>0){

	 $sql = "select ledger_id,cr_amt,dr_amt,narration from journal where tr_from='Opening' and ledger_id='".$_REQUEST['ledgerID']."' 
	and sub_ledger='".$_REQUEST['subLedgerID']."' and group_for ='".$_SESSION['user']['group']."' ";

	$query = db_query($sql);
	$count = mysqli_num_rows($query);

	if($count==0){
		$data['cr_amt'] = 0;
		$data['dr_amt'] = 0;
	}else{
		$res = mysqli_fetch_object($query);
		$data['cr_amt'] = $res->cr_amt;
		$data['dr_amt'] = $res->dr_amt;
	}

	echo json_encode($data);
}
?>