<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$_REQUEST['oqty'] = ($_REQUEST['opkt']*$_REQUEST['opkt_sz'])+$_REQUEST['opic'];



db_delete('journal_item','warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$_REQUEST['item_id'].'" and tr_from = "Opening-2016" order by id desc');
journal_item_control($_REQUEST['item_id'] ,$_SESSION['user']['depot'],$_REQUEST['odate'],$_REQUEST['oqty'],0,'Opening-2016','0',$_REQUEST['orate']);

echo 'Success!';
?>