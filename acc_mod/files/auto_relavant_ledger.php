<?php
session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


//$sql = db_query('select ledger_id,tr_no from journal where tr_from="Receipt" and relavent_cash_head=0 and dr_amt>0');
//while($data= mysqli_fetch_object($sql))
//{
//$update_sql = db_query('update journal set relavent_cash_head = "'.$data->ledger_id.'" where tr_no = "'.$data->tr_no.'" and tr_from="Receipt"');
//++$x;
//}
//echo $x.' complete ';


$sql = db_query('select ledger_id,tr_no from journal where tr_from="Payment" and relavent_cash_head=0 and cr_amt>0');
while($data= mysqli_fetch_object($sql))
{
$update_sql = db_query('update journal set relavent_cash_head = "'.$data->ledger_id.'" where tr_no = "'.$data->tr_no.'" and tr_from="Payment"');
++$x;
}
echo $x.' complete ';
?>