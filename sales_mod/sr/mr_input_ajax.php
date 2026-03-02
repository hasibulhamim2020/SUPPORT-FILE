<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

//--========Table information==========-----------//
$table_master='requisition_master';

$table_details='requisition_order';

$unique='req_no';

$unique_detail='id';

//--========Table information==========-----------//

$unique = $_POST[$unique];

$crud   = new crud($table_details);

		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[2];

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$crud->insert();

$res='select a.id,concat(b.item_name) as item_name,a.qoh as stock_qty,a.last_p_qty as last_pur_qty,a.last_p_date as last_pur_date,a.qty, a.remarks,"x" from requisition_order a,item_info b where b.item_id=a.item_id and a.req_no='.$unique;


$all_dealer[]=link_report_del($res);
echo json_encode($all_dealer);

?>



