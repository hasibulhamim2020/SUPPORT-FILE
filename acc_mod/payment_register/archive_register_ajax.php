<?php
session_start();
require_once "../../../assets/template/layout.top.php";

$item_id   = $item[1];
$tr_nos = $_POST['tr_no'];
$today = date('Y-m-d');
$delete = 'delete from payment_register_archive where archive_date="'.$today.'"';
mysql_query($delete);

$res = 'select p.*,s.sub_ledger_name,g.company_short_code from payment_register p, general_sub_ledger s, user_group g where p.payee_sub_ledger=s.sub_ledger_id and p.group_for=g.id and p.id in ('.$tr_nos.')';
$query = mysql_query($res);
while($row = mysql_fetch_object($query)){

$insert = 'insert into payment_register_archive set archive_date="'.$today.'",tr_date="'.$row->tr_date.'",tr_no="'.$row->tr_no.'",tr_from="'.$row->tr_from.'",sub_ledger_id="'.$row->payee_sub_ledger.'",payment_mode="'.$row->payment_method.'",cash_bank_ledger="'.$row->cr_ledger.'",amount="'.$row->approved_amt.'",entry_by="'.$_SESSION['user']['id'].'",entry_at="'.date('Y-m-d H:i:s').'",group_for="'.$row->group_for.'"';
mysql_query($insert);					
}
$all['msg'] = 'Saved';

echo json_encode($all);

?>



