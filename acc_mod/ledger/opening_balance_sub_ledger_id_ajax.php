<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$entry_at = date('Y-m-d H:i:s');
$ledger_id = end(explode("->",$_REQUEST['ledger_id']));
$group_for = $_REQUEST['group_for'];

if($_REQUEST['sub_ledger']>0 && $_REQUEST['group_for']>0){

$sqql="delete from journal where tr_from='Opening' and ledger_id='".$ledger_id."' 
and sub_ledger='".$_REQUEST['sub_ledger']."' and group_for='".$_REQUEST['group_for']."'"; 
db_query($sqql);

$sqql2="delete from secondary_journal where tr_from='Opening' and ledger_id='".$ledger_id."' 
and sub_ledger='".$_REQUEST['sub_ledger']."' and group_for='".$_REQUEST['group_for']."'"; 
db_query($sqql2);

$ledger = find_all_field('accounts_ledger','','group_for="'.$group_for.'" and ledger_id='.$ledger_id);

//$jv=next_journal_voucher_id();

$project = "saas";
$jv=next_journal_voucher_id('','Opening',$_SESSION['user']['depot']);
$narration = $_REQUEST['narration'];
$ledger_id = end(explode("->",$_REQUEST['ledger_id']));

if($_REQUEST['cr']>0)
{
$amount=$_REQUEST['cr'];
 $sec_journal="INSERT INTO `secondary_journal` (
								`proj_id` ,
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
VALUES ('$project','$jv', '".$_REQUEST['opdate']."', '".$ledger_id."', '".$narration."', '0', '$amount', 'Opening', '','".$_REQUEST['sub_ledger']."','".$cc_code."','".$_SESSION['user']['id']."','".$group_for."','".$entry_at."')";

db_query($sec_journal);

$tr_from = 'Opening';
sec_journal_journal($jv,$jv,$tr_from);

}
if($_REQUEST['dr']>0)
{
$amount=$_REQUEST['dr'];
 $sec_journal="INSERT INTO `secondary_journal` (
								`proj_id` ,
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
VALUES ('$project','$jv', '".$_REQUEST['opdate']."', '".$ledger_id."', '".$narration."',  '$amount','0', 'Opening', '','".$_REQUEST['sub_ledger']."','".$cc_code."','".$_SESSION['user']['id']."','".$group_for."','".$entry_at."')";
db_query($sec_journal);

$tr_from = 'Opening';
sec_journal_journal($jv,$jv,$tr_from);

}
echo 'Success!';
}
?>