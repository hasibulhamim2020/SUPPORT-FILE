<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
$dealer_code = end(explode("#",$_POST['dealer']));

$dealer = find_all_field('dealer_info','','dealer_code="'.$dealer_code.'"');


$c_balance=find_a_field('journal','sum(dr_amt-cr_amt)','sub_ledger="'.$dealer->sub_ledger_id.'"');
$p_chalan=find_a_field('secondary_journal','sum(dr_amt)','checked ="" and sub_ledger='.$dealer->sub_ledger_id);

if($c_balance<0){
    $c_balance=$c_balance*-1;
}

$do_value = find_a_field('sale_do_master m,sale_do_details d','sum(d.total_amt)','d.do_no=m.do_no and m.status in ("CHECKED","PROCESSING","UNCHECKED")  and m.dealer_code='.$dealer_code.'');

$chalan_amt = find_a_field('sale_do_chalan d, sale_do_master m','sum(d.total_amt)','m.status in ("PROCESSING","CHECKED","COMPLETE") and m.do_no=d.do_no and d.unit_price > 0 and m.dealer_code='.$dealer_code.' ');



$pending_amt=$do_value-$chalan_amt;



if($dealer){
    $all['bank_reconsila'] = $dealer->bank_reconsila;
    $all['credit_limit_appli'] = $dealer->credit_limit_appli;
    $all['credit_limit'] = $dealer->credit_limit;
    $all['balance'] = find_a_field('journal','sum(dr_amt-cr_amt)','sub_ledger="'.$dealer->sub_ledger_id.'"');
    $all['pending_amt'] = $c_balance-$pending_amt-$p_chalan;
    $all['p_chalan'] = $p_chalan;
    $all['do_value'] = $do_value;
    $all['chalan_amt'] = $chalan_amt;
}
echo json_encode($all);

?>



