<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$entry_at = date('Y-m-d H:i:s');
if($_REQUEST['item_id']>0){
$sqql="delete from journal where tr_from='Opening' and ledger_id='".$_REQUEST['item_id']."'"; 
db_query($sqql);
$ledger = find_all_field('accounts_ledger','','ledger_id='.$_REQUEST['item_id']);
$jv=next_journal_voucher_id();
if($_REQUEST['cr']>0)
{
$amount=$_REQUEST['cr'];

$journal="INSERT INTO `journal` (
								`jv_no` ,
								`jv_date` ,
								`ledger_id` ,
								`narration` ,
								`dr_amt` ,
								`cr_amt` ,
								`tr_from` ,
								`tr_no`,
								`sub_ledger`,
								`cc_code`,
								entry_by,
								group_for,
								entry_at
								)
VALUES ('$jv', '".strtotime($_REQUEST['opdate'])."', '".$ledger->ledger_id."', 'Opening Balance of ".$_REQUEST['opdate']."', '0', '$amount', 'Opening', '','','','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."','".$entry_at."')";
db_query($journal);
}
if($_REQUEST['dr']>0)
{
$amount=$_REQUEST['dr'];
$journal="INSERT INTO `journal` (
								`jv_no` ,
								`jv_date` ,
								`ledger_id` ,
								`narration` ,
								`dr_amt` ,
								`cr_amt` ,
								`tr_from` ,
								`tr_no`,
								`sub_ledger`,
								`cc_code`,
								entry_by,
								group_for,
								entry_at
								)
VALUES ('$jv', '".strtotime($_REQUEST['opdate'])."', '".$ledger->ledger_id."', 'Opening Balance of ".$_REQUEST['opdate']."',  '$amount','0', 'Opening', '','','','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."','".$entry_at."')";
db_query($journal);
}echo 'Success!';}
?>