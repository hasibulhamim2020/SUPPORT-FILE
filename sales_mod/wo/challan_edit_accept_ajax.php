<?

session_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$id = $_REQUEST['id'];
$edit_request = $_REQUEST['edit_request'];
$flag = $_REQUEST['flag'];



$accept_by=$_SESSION['user']['id'];
$accept_at=date('Y-m-d H:i:s');


			 $new_sql="UPDATE `sale_do_chalan` SET 
			
			`edit_request` = '".$edit_request."',
			
			`edit_accept` = 1,

			`accept_by` = '".$accept_by."',
			
			`accept_at` = '".$accept_at."'
			
			 WHERE `id` = '".$id."'";
			
			db_query($new_sql);





//if($_REQUEST['item_id']==0) {
//
//}else
//
//{
//
// $ji_delete = "DELETE from journal_item where item_id='".$item_id."' and warehouse_id='".$warehouse_id."' and group_for='".$group_for."' and tr_from='Opening' ";
//db_query($ji_delete);
//
// $jv_delete = "DELETE from secondary_journal where ledger_id='".$ledger_id."' and tr_no='".$warehouse_id."' and group_for='".$group_for."' and tr_from='Opening' ";
//db_query($jv_delete);
//
// $jv_delete = "DELETE from journal where ledger_id='".$ledger_id."' and tr_no='".$warehouse_id."' and group_for='".$group_for."' and tr_from='Opening' ";
//db_query($jv_delete);
//
//journal_item_control($item_id,$warehouse_id, $op_date, $item_in, 0,'Opening', '0', $item_price,'','0','','', '0','','',$group_for,$item_price);
//
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $narration, $opening_amt, '0.00', $tr_from, $warehouse_id, '', $warehouse_id, $cc_code, $group_for);
//
//sec_journal_journal($jv_no,$jv_no,$tr_from);
//
//}

echo 'Success!';

?>