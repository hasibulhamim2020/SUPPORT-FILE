<?

session_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$id = $_REQUEST['id'];
$edit_request = $_REQUEST['edit_request'];

$item_name = $_REQUEST['item_name'];

$total_unit = $_REQUEST['total_unit'];
$pcs_1 = $_REQUEST['pcs_1'];
$bundle_1 = $_REQUEST['bundle_1'];
$pcs_2 = $_REQUEST['pcs_2'];
$bundle_2 = $_REQUEST['bundle_2'];
$pcs_3 = $_REQUEST['pcs_3'];
$bundle_3 = $_REQUEST['bundle_3'];
$total_amt = $_REQUEST['total_amt'];

$flag = $_REQUEST['flag'];



$edit_by=$_SESSION['user']['id'];
$edit_at=date('Y-m-d H:i:s');


			 $new_sql="UPDATE `sale_do_chalan` SET 
			
			`edit_request` = '".$edit_request."',
			
			`item_name` = '".$item_name."',

			`edit_accept` = 0,
			
			`total_unit` = '".$total_unit."',
			`pcs_1` = '".$pcs_1."',
			`bundle_1` = '".$bundle_1."',
			`pcs_2` = '".$pcs_2."',
			`bundle_2` = '".$bundle_2."',
			`pcs_3` = '".$pcs_3."',
			`bundle_3` = '".$bundle_3."',
			`total_amt` = '".$total_amt."',

			`edit_by` = '".$edit_by."',
			
			`edit_at` = '".$edit_at."'
			
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