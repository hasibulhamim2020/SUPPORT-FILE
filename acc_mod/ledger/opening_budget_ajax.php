<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$entry_at = date('Y-m-d H:i:s');
if($_REQUEST['item_id']>0){
$sqql2="delete from budget_balance where ledger_id='".$_REQUEST['item_id']."' and fiscal_year='".$_REQUEST['fiscal_year']."'"; 
db_query($sqql2);
$ledger = find_all_field('accounts_ledger','','ledger_id='.$_REQUEST['item_id']);
$cc_code = find_a_field('dealer_info','depot','account_code='.$ledger->ledger_id);


$fiscal_info = find_all_field('fiscal_year','','id="'.$_REQUEST['fiscal_year'].'"');
$fdate=$fiscal_info->start_date;
$tdate=$fiscal_info->end_date;

$project = "clouderp";
$jv=next_journal_voucher_id('','Opening',$_SESSION['user']['depot']);
$narration = $_REQUEST['narration'];


if($_REQUEST['dr']>0)
{
$amount=$_REQUEST['dr'];
 $sec_journal="INSERT INTO `budget_balance` (
								`proj_id` ,
								`jv_no` ,
								`start_date` ,
								`end_date` ,
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
								entry_at,
								fiscal_year
								)
VALUES ('$project','$jv', '".$fdate."','".$tdate."', '".$ledger->ledger_id."', '".$narration."',  '$amount','0', 'Budget', '','','".$cc_code."','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."','".$entry_at."','".$_REQUEST['fiscal_year']."')";
db_query($sec_journal);


}echo 'Success!';}
?>