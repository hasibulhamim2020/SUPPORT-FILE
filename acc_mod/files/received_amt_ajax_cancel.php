<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

if($_REQUEST['item_id']>0)
{
	$do_no = $_REQUEST['item_id'];


			$do = find_all_field('sale_do_master','s','do_no='.$do_no);


			$received_amt=$_REQUEST['ra'];
			$receive_acc_head=$_REQUEST['receive_acc_head'];
			$rec_date=$_REQUEST['rec_date'];
			
			$tr_from = 'Collection';
$jv_no = $do->final_jv_no;
			

			$sql = 'delete from journal where jv_no = '.$jv_no;
			db_query($sql);

			$journal = "UPDATE `sale_do_master` SET `rec_date` = '0000-00-00',`received_amt` = '0',`checked_at` = '',`checked_by` = '',`received_status` = 'pending',final_jv_no='' WHERE `do_no` ='".$do_no."'";
			db_query($journal);
			echo 'Received!';

}
?>