<?
session_start();
require "../support/inc.all.php";
$entry_at = date('Y-m-d H:i:s');

if($_REQUEST['item_id']>0){
$ledger_id =$_REQUEST['item_id'];
$sqql="delete from journal where tr_from='Opening' and ledger_id='".$ledger_id."'"; 
db_query($sqql);
 $rdate = strtotime($_REQUEST['opdate']);
//$reset_amt = find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<"'.$rdate.'" and ledger_id="'.$ledger_id.'"');

$jv=next_journal_voucher_id();
/*
if($reset_amt!=0)
{
 if($reset_amt>0)
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

								user_id,

								group_for,

								entry_at

								)

VALUES ('$jv', '".strtotime($_REQUEST['opdate'])."', '".$ledger_id."', 'Reset Balance of ".$_REQUEST['opdate']."', '0', '$reset_amt', 'Opening', '','','','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."','".$entry_at."')";
else
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

								user_id,

								group_for,

								entry_at

								)

VALUES ('$jv', '".strtotime($_REQUEST['opdate'])."', '".$ledger_id."', 'Reset Balance of ".$_REQUEST['opdate']."',  ($reset_amt*(-1)),'0', 'ResetOpening', '','','','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."','".$entry_at."')";
db_query($journal);
}*/

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

								user_id,

								group_for,

								entry_at

								)

VALUES ('$jv', '".strtotime($_REQUEST['opdate'])."', '".$ledger_id."', 'Reset Balance of ".$_REQUEST['opdate']."', '0', '$amount', 'Opening', '','','','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."','".$entry_at."')";

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

								user_id,

								group_for,

								entry_at

								)

VALUES ('$jv', '".strtotime($_REQUEST['opdate'])."', '".$ledger_id."', 'Opening Balance of ".$_REQUEST['opdate']."',  '$amount','0', 'Opening', '','','','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."','".$entry_at."')";

db_query($journal);

}echo 'Success!';}

?>