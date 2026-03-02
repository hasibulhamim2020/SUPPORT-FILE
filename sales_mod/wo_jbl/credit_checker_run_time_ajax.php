<?php
session_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$str = $_POST['data'];
$data=explode('##',$str);
$today = date('Y-m-d');

$dealer_code=$data[0];
$dealer = find_all_field('dealer_info','','dealer_code="'.$dealer_code.'"');
$dealer_checker = find_a_field('credit_limit_config','dealer_code','dealer_code="'.$dealer_code.'" and effective_start_date<="'.$today.'" and effective_end_date>="'.$today.'"');

if($dealer_checker>0){
$con = ' and c.dealer_code="'.$dealer_checker.'"';
}else{
$con = ' and c.dealer_type="'.$dealer->dealer_type.'"';
}


$sql = 'select c.* from credit_limit_config c where c.effective_start_date<="'.$today.'" and c.effective_end_date>="'.$today.'" '.$con.' ';
$qry = db_query($sql);
$config=mysqli_fetch_object($qry);
if($config->id>0){
//dealerAgeDays
$dealer_created = date('Y-m-d',strtotime($dealer->entry_at));
$date1 = new DateTime($dealer_created);
$date2 = new DateTime($today);
$interval = $date1->diff($date2);
$dealerAgeDays=$interval->format('%a')+1;
//end

//delaerAgeCalanderMonth
$date1 = $dealer_created;
$date2 = $today;
$mon = 0;
$dealerAgeCalanderMonth=0;
for($i=$date1;$i<=$date2;$i = date('Y-m-d', strtotime( $i . " +1 days"))){
$old_mon = date('m',strtotime($i));
if($mon!=$old_mon){
$mon = $old_mon;
$dealerAgeCalanderMonth++;
}
}

$current_date = $today;
if($config->timeLine=='Initial'){
$transaction_start_date = $dealer_created;
$transaction_end_date = $config->effective_end_date;

}elseif($config->timeLine=='Last Month'){
$previous_month_date = date('Y-m-d',strtotime($current_date.'-31 days'));
$transaction_start_date = date('Y-m-01',strtotime($previous_month_date));
$mdays = date('t',strtotime($previous_month_date));
$transaction_end_date = date('Y-m-'.$mdays,strtotime($previous_month_date));

}elseif($config->timeLine=='Last 7 Days'){
$transaction_start_date = date('Y-m-d',strtotime($current_date.'-7 days'));
$transaction_end_date = date('Y-m-d',strtotime($current_date.'-1 days'));

}elseif($config->timeLine=='Last 15 Days'){
$transaction_start_date = date('Y-m-d',strtotime($current_date.'-15 days'));
$transaction_end_date = date('Y-m-d',strtotime($current_date.'-1 days'));

}elseif($config->timeLine=='Date Range'){
$transaction_start_date = $config->c_start_date;
$transaction_end_date = $config->c_end_date;

}else{
$transaction_start_date = '';
$transaction_end_date = '';
}

$applicable = 'no';
//Dealer Age(days) and calander month calculation start
$requiredDealerAgeCalander = (int)$config->conditionalEffectiveMon;
$dealerAge = explode("-",$config->dealerAge);

if($config->dealerAge!='All' && $config->conditionalEffectiveMon=='All'){
 if($dealerAgeDays>=$dealerAge[0] && $dealerAgeDays<=$dealerAge[1]){
    $applicable = 'yes';
}

}elseif($config->dealerAge=='All' && $config->conditionalEffectiveMon!='All'){
if($dealerAgeCalanderMonth>12){
 $config->conditionalEffectiveMon = $dealerAgeCalanderMonth;
 }
  if($dealerAgeCalanderMonth==$requiredDealerAgeCalander){
     $applicable = 'yes';
}
}elseif($config->dealerAge=='All' && $config->conditionalEffectiveMon='All'){
$applicable = 'yes';
}

//Dealer Age(days) and calander month calculation end




if($dealer_code>0 && $applicable=='yes'){
$total_amt = 0;
$creditAmt = 0;
if($config->rules=='Payment'){
$dealer_ledger = $dealer->account_code;
$payment_sql = 'select sum(cr_amt) as payment from journal where tr_from="Receipt" and ledger_id="'.$dealer_ledger.'" and jv_date between "'.$transaction_start_date.'" and "'.  $transaction_end_date.'"';
$qry = db_query($payment_sql);
$pay_data = mysqli_fetch_object($qry);
 
 //Figure
 if($config->critaria=='Total'){
 $total_amt = $pay_data->payment;
 }elseif($config->critaria=='Average'){
  $total_amt = $pay_data->payment/$config->totalMonth;
 }
 
 //Minimum Limit Check
 if($pay_data->payment>$config->minimumLimit){
  $creditAmt = $total_amt *$config->totalTimes;
 }
 
 //Maximum Limit Check
 if($config->maxLimit>0 && $creditAmt>$config->maxLimit){
   $creditAmt = $config->maxLimit;
 }
 
 
}elseif($config->rules=='Sales'){
$payment_sql = 'select sum(total_amt) as salesAmount from sale_do_chalan where dealer_code="'.$dealer_code.'" and chalan_date between "'.$transaction_start_date.'" and "'. $transaction_end_date.'"';
 $qry = db_query($payment_sql);
 $pay_data = mysqli_fetch_object($qry);
 
 //Figure
 if($config->critaria=='Total'){
 $total_amt = $pay_data->salesAmount;
 }elseif($config->critaria=='Average'){
 $total_amt = $pay_data->salesAmount;
 }
 
 //Minimum Limit Check
 if($pay_data->salesAmount>$config->minimumLimit){
  $creditAmt = $total_amt *$config->totalTimes;
 }else{
  $creditAmt = 0;
 }
 
 //Maximum Limit Check
 if($config->maxLimit>0 && $creditAmt>$config->maxLimit){
    $creditAmt = $config->maxLimit;
 }
 
}elseif($config->rules=='Manual'){
$creditAmt = $config->manual_limit;
}

}

}
?>

<input  name="credit_limit" type="text" id="credit_limit" value="<?=$creditAmt?>" readonly />





