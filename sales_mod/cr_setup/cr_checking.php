<?php
 
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 

$page_name="Party Credit Configuration";

$title='PARTY CREDIT CONFIGURATION';			// Page Name and Page Title

$page="credit_limit_setup.php";		// PHP File Name

do_calander("#c_start_date");
do_calander("#c_end_date");
do_calander("#effective_start_date");
do_calander("#effective_end_date");

$table='credit_limit_config';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='dealer_type';				// For a New or Edit Data a must have data field
$this_month = date('Y-m-15');

$crud      =new crud($table);


$config = find_all_field('credit_limit_config','*','id="'.$_GET['id'].'"');
$current_date = $config->effective_start_date;

if($config->timeLine=='Initial'){
$transaction_start_date = '2020-01-01';
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



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');

$parameters = $_POST['parameters'];
$i=0;

/*foreach($parameters as $res){
if($i>0){
$parameter .= ",";
}
$parameter .= $res;
$i++;
}*/

$crud->insert();





$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{
$today = $config->effective_start_date;
if($_POST['dealer_code']>0){
$sql = 'select c.*,d.dealer_name_e as dealer_name,d.dealer_code as ddealer_code,d.dealer_name_e,d.entry_at as dealer_created_date from credit_limit_config c, dealer_info d where c.dealer_code=d.dealer_code and d.dealer_code="'.$_POST['dealer_code'].'"';
}else{
$sql = 'select c.*,d.dealer_name_e as dealer_name,d.dealer_code as ddealer_code,d.dealer_name_e,d.entry_at as dealer_created_date from dealer_info d,credit_limit_config c where c.dealer_type=d.dealer_type and d.dealer_type="'.$_POST['dealer_type'].'"';
}
$qry = db_query($sql);
while($data=mysqli_fetch_object($qry)){
$dealer_created = date('Y-m-d',strtotime($data->dealer_created_date));
//Find last number of month

if($config->critaria=='Average'){
$effective_start_date = date('Y-m-01',strtotime($config->effective_start_date));
$transaction_start_date = date('Y-m-d',strtotime($effective_start_date.'-'.$config->totalMonth.' months'));
$transaction_end_date = date('Y-m-d',strtotime($effective_start_date.'-1 days'));

if($dealer_created>$transaction_start_date){
$transaction_start_date = $dealer_created;
}
//echo $transaction_start_date.'-'.$transaction_end_date;
$partyAgeEffectiveMonth = 0;
for($j=$transaction_start_date;$j<=$transaction_end_date;$j = date('Y-m-d', strtotime( $j . " +1 days"))){
$old_month = date('m',strtotime($j));
if($month!=$old_month){
$month = $old_month;
$partyAgeEffectiveMonth++;
}
}
//echo '<br>'.$partyAgeEffectiveMonth;
}

//dealerAgeDays
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


//end


//Dealer Age(days) and calander month calculation start
$requiredDealerAgeCalander = (int)$data->conditionalEffectiveMon;
$dealerAge = explode("-",$data->dealerAge);

if($data->dealerAge!='All' && $data->conditionalEffectiveMon=='All'){
 if($dealerAgeDays>=$dealerAge[0] && $dealerAgeDays<=$dealerAge[1]){
    $dealer[$data->ddealer_code] = $data->ddealer_code;
	
	
}

}elseif($data->dealerAge=='All' && $data->conditionalEffectiveMon!='All'){
if($dealerAgeCalanderMonth>12){
 $data->conditionalEffectiveMon = $dealerAgeCalanderMonth;
 }
  if($dealerAgeCalanderMonth==$requiredDealerAgeCalander){
     $dealer[$data->ddealer_code] = $data->ddealer_code;
}
}elseif($data->dealerAge=='All' && $data->conditionalEffectiveMon='All'){
$dealer[$data->ddealer_code] = $data->ddealer_code;
}
//Dealer Age(days) and calander month calculation end

}


foreach($dealer as $dt){
if($dt>0){
$total_amt = 0;
$creditAmt = 0;
if($config->rules=='Payment'){
 $dealer_ledger = find_a_field('dealer_info','account_code','dealer_code="'.$dt.'"');
 $payment_sql = 'select sum(cr_amt) as payment from journal where tr_from="Receipt" and ledger_id="'.$dealer_ledger.'" and jv_date between "'.$transaction_start_date.'" and "'.  $transaction_end_date.'"';
 $qry = db_query($payment_sql);
 $pay_data = mysqli_fetch_object($qry);
 
 //Figure
 if($config->critaria=='Total'){
 $total_amt = $pay_data->payment;
 }elseif($config->critaria=='Average'){
  $total_amt = $pay_data->payment/$partyAgeEffectiveMonth;
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
$payment_sql = 'select sum(total_amt) as salesAmount from sale_do_chalan where dealer_code="'.$dt.'" and chalan_date between "'.$transaction_start_date.'" and "'. $transaction_end_date.'"';
 $qry = db_query($payment_sql);
 $pay_data = mysqli_fetch_object($qry);
 
 //Figure
// if($config->critaria=='Total'){
// $total_amt = $pay_data->salesAmount;
// }elseif($config->critaria=='Average'){
// $total_amt = $pay_data->salesAmount/$partyAgeEffectiveMonth;
// }
 
 if ($config->criteria == 'Total') {
    $total_amt = $pay_data->salesAmount;
} elseif ($config->criteria == 'Average') {
    // Check if $partyAgeEffectiveMonth is not zero to avoid division by zero
    if ($partyAgeEffectiveMonth != 0) {
        $total_amt = $pay_data->salesAmount / $partyAgeEffectiveMonth;
    } else {
        // Handle the case where $partyAgeEffectiveMonth is zero
        // For example, set $total_amt to a default value or handle it in another appropriate way
        // Here, I'm setting $total_amt to zero
        $total_amt = 0;
    }
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

//Insert credit Limit
if($creditAmt>0){
$insert = 'insert into dealer_credit_info set dealer_type="'.$config->dealer_type.'",dealer_code="'.$dt.'",start_date="'.$config->effective_start_date.'",end_date="'.$config->effective_end_date.'",mon="'.date('m',strtotime($config->effective_start_date)).'",year="'.date('Y',strtotime($config->effective_start_date)).'",credit_limit="'.$creditAmt.'",entry_by="'.$_SESSION['user']['id'].'",entry_at="'.date('Y-m-d H:i:s').'",rules="'.$config->rules.'",critaria="'.$config->critaria.'",timeLine="'.$config->timeLine.'",totalMonth="'.$config->totalMonth.'",minimumLimit="'.$config->minimumLimit.'",maxLimit="'.$config->maxLimit.'",totalTimes="'.$config->totalTimes.'"';
db_query($insert);
}
}
}

$_POST['status'] = 'CHECKED';
$_POST['edit_by'] = $_SESSION['user']['id'];
$_POST['edit_at'] = date('Y-m-d H:i:s');
//$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

}
//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="../custom_css/example-styles.css">
<link rel="stylesheet" type="text/css" href="../custom_css/demo-styles.css">-->
<script>
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
});

$(".chosen-selectAnother").chosen({
  no_results_text: "Oops, nothing found!"
});


</script>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<style>
.pr-3{ 
 padding:3px;
}
</style>


<div class="container-fluid">
    


        <div class="col-sm-12">
            
            <form id="form1" name="form1" class="n-form" method="post" action="" enctype="multipart/form-data">
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Based On</label>
                    <div class="col-sm-9 p-0">
                         <select id="rules" name="rules">
						 <option></option>
						<option <?=($rules=='Sales')?'selected':''?>>Sales</option>
                        <option <?=($rules=='Payment')?'selected':''?>>Payment</option>
						<option <?=($rules=='Manual')?'selected':''?>>Manual</option> 
					    </select>
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Figure</label>
                    <div class="col-sm-9 p-0">
                         <select id="critaria" name="critaria">
						 <option></option>
						<option <?=($critaria=='Average')?'selected':''?>>Average</option>
                        <option <?=($critaria=='Total')?'selected':''?>>Total</option>
						
					    </select>
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Time Line</label>
                    <div class="col-sm-9 p-0">
                         <select id="timeLine" name="timeLine">
						 <option></option>
						<option <?=($timeLine=='Initial')?'selected':''?>>Initial</option>
                        <option <?=($timeLine=='Last 7 Days')?'selected':''?>>Last 7 Days</option>
						<option <?=($timeLine=='Last 15 Days')?'selected':''?>>Last 15 Days</option>
						<option <?=($timeLine=='Last Month')?'selected':''?>>Last Month</option>
						<option <?=($timeLine=='Date Range')?'selected':''?>>Date Range</option>
						
					    </select>
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Number of Month</label>
                    <div class="col-sm-9 p-0">
                         <input type="text" id="totalMonth" name="totalMonth" value="<?=$totalMonth?>">
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Period Start Date</label>
                    <div class="col-sm-9 p-0">
                         <input type="text" id="c_start_date" name="c_start_date" value="<?=$c_start_date?>">
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Period End Date</label>
                    <div class="col-sm-9 p-0">
                         <input type="text" id="c_end_date" name="c_end_date" value="<?=$c_end_date?>">
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Credit Condition Balance less then</label>
                    <div class="col-sm-9 p-0">
                         <input type="text" id="minimumLimit" name="minimumLimit" value="<?=$minimumLimit?>">
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Dealer Type</label>
                    <div class="col-sm-9 p-0">
                         <select id="dealer_type" name="dealer_type">
						<option></option>
                         <?php foreign_relation('dealer_type', 'id', 'dealer_type', $dealer_type); ?>
					    </select>
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Dealer Name</label>
                    <div class="col-sm-9 p-0">
                         <select id="dealer_code" name="dealer_code">
						<option></option>
                         <?php foreign_relation('dealer_info', 'dealer_code', 'dealer_name_e', $dealer_code,'1'); ?>
					    </select>
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Times</label>
                    <div class="col-sm-9 p-0">
                         <input type="text" id="totalTimes" name="totalTimes" value="<?=$totalTimes?>">
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Maximum Limit</label>
                    <div class="col-sm-9 p-0">
                         <input type="text" id="maxLimit" name="maxLimit" value="<?=$maxLimit?>">
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Party Age (Days)</label>
                    <div class="col-sm-9 p-0">
                         <select id="dealerAge" name="dealerAge">
						<option <?=($dealerAge=='0')?'selected':''?> value="0">All</option>
                        <option <?=($dealerAge=='0-30')?'selected':''?> value="0-30">0-30 Days</option>
                        <option <?=($dealerAge=='31-90')?'selected':''?> value="31-90">31-90 Days</option>
						<option <?=($dealerAge=='91-180')?'selected':''?> value="91-180">91-180 Days</option>
						<option <?=($dealerAge=='181-365')?'selected':''?> value="181-365">181-365 Days</option>
						<option <?=($dealerAge=='366-100000')?'selected':''?> value="366-100000">Above 365 Days</option>
					    </select>
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Conditional Effective date (Age of the Party) Calander Month</label>
                    <div class="col-sm-9 p-0">
                          <select id="conditionalEffectiveMon" name="conditionalEffectiveMon">
						<option value="All">All</option>
                        <option <?=($conditionalEffectiveMon=='1st Month')?'selected':''?> value="1st Month">1st Month</option>
						<option <?=($conditionalEffectiveMon=='2nd Month')?'selected':''?> value="2nd Month">2nd Month</option>
                        <option <?=($conditionalEffectiveMon=='3rd Month')?'selected':''?> value="3rd Month">3rd Month</option>
						<option <?=($conditionalEffectiveMon=='4th Month')?'selected':''?> value="4th Month">4th Month</option>
						<option <?=($conditionalEffectiveMon=='5th Month')?'selected':''?> value="5th Month">5th Month</option>
						<option <?=($conditionalEffectiveMon=='6th Month')?'selected':''?> value="6th Month">6th Month</option>
						<option <?=($conditionalEffectiveMon=='7th Month')?'selected':''?> value="7th Month">7th Month</option>
						<option <?=($conditionalEffectiveMon=='8th Month')?'selected':''?> value="8th Month">8th Month</option>
						<option <?=($conditionalEffectiveMon=='9th Month')?'selected':''?> value="9th Month">9th Month</option>
						<option <?=($conditionalEffectiveMon=='10th Month')?'selected':''?> value="10th Month">10th Month</option>
						<option <?=($conditionalEffectiveMon=='11th Month')?'selected':''?> value="11th Month">11th Month</option>
						<option <?=($conditionalEffectiveMon=='12th Month')?'selected':''?> value="12th Month">12th Month</option>
						<option <?=($conditionalEffectiveMon=='Above 12 Month')?'selected':''?> value="Above 12 Month">Above 12 Month</option>
					    </select>
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Effective Start Date</label>
                    <div class="col-sm-9 p-0">
                         <input type="text" id="effective_start_date" name="effective_start_date" value="<?=$effective_start_date?>">
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Effective End Date</label>
                    <div class="col-sm-9 p-0">
                         <input type="text" id="effective_end_date" name="effective_end_date" value="<?=$effective_end_date?>">
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Manual Limit Amount</label>
                    <div class="col-sm-9 p-0">
                         <input type="text" id="manual_limit" name="manual_limit" value="<?=$manual_limit?>">
					</div>
                </div>
				

                <!--<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Month </label>
                    <div class="col-sm-9 p-0">
                         <select id="mon" name="mon">
						
                         <?php foreign_relation('months', 'month_id', 'month_short_name',$mon,'1'); ?>
					    </select>

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Year </label>
                    <div class="col-sm-9 p-0">

                        <select id="year" name="year">
						<option <?=($year==2023)?'selected':''?>>2023</option>
                        <option <?=($year==2024)?'selected':''?>>2024</option>
						<option <?=($year==2025)?'selected':''?>>2025</option>
					    </select>

                    </div>
                </div>
				
				 <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Parameters </label>
                    <div class="col-sm-9 p-0">

                        <select  name="parameters[]" id="parameters" class="form-control chosen-select" multiple />
             <option><?=$parameters?></option>
             <? foreign_relation('credit_parameter','parameter_name','parameter_name',$parameters,'1');?>
              </select>

                    </div>
                </div>-->

                <div class="n-form-btn-class">
                     
                        <? if(isset($_GET[$unique])){?>
                        <input name="update" type="submit" id="update" value="Confirm" class="btn1 btn1-bg-update" />
                        <? }?>
                     
                   
                        <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Return" onclick="parent.location='<?=$page?>'" />
                      

                </div>


            </form>

        </div>

    </div>




</div>


<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<script>
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})

</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
