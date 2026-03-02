<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";
$title = "Accounts Management Dashboard";
 $tr_type="Show";
 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';

//current year
$current_year = date('Y');

 //dashboard Data
//and entry_by="'.$_SESSION['user']['id'].'";

 $total_voucherP = $total_voucherP = find_all_field_sql("SELECT COUNT(DISTINCT jv_no) AS n, SUM(dr_amt) AS m 
    FROM journal 
    WHERE jv_date >= '".$current_year."-01-01' 
    AND tr_from IN ('Payment', 'Vendor_payment','Vendor_advance_payment','vendor_tds_payment','vendor_vds_payment')");

 
 $total_voucherR = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from='Receipt'  ");
 
 $total_voucherJ = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from='journal'");
 
 $total_voucherC = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from='Contra'  ");
 
 
 $MRR_Approve = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from secondary_journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from in 
 ('LocalPurchase','Purchase') and checked='YES'");
 
  $Chalan_Approve = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from secondary_journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from in 
 ('Sales') and checked='YES'");
 
   $GR_Approve = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from secondary_journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from in 
 ('Goods Return') and checked='YES'");
 
 $PR_Approve = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from secondary_journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from in 
 ('Purchase Return') and checked='YES'");
 
 
 //$new_local_purchase_order=find_a_field('warehouse_other_receive','count(*)','1 and YEAR(or_date) ="'.$current_year.'" and status="UNCHECKED" and entry_by="'.$_SESSION['user']['id'].'"');
 
 //$receive_order=find_a_field('purchase_receive pr, purchase_master pm','count(pm.po_no)','1 and pm.po_no=pr.po_no and YEAR(rec_date) ="'.$current_year.'" and pm.entry_by="'.$_SESSION['user']['id'].'" group by pm.po_no');






$tr_from="Purchase";
?>




<?php

$today = new DateTime();
$startOfWeek = clone $today;
$startOfWeek->modify('last Saturday');
$endOfWeek = clone $startOfWeek;
$endOfWeek->modify('+6 days');

 "Week starts on: " . $startOfWeek->format('Y-m-d') . "\n";
"Week ends on: " . $endOfWeek->format('Y-m-d') . "\n";



 $res=
'SELECT 
    DAYNAME(m.po_date) as day_name,
    DATE(m.po_date) as day,
    SUM(i.amount) as amnt 
FROM 
    purchase_invoice i,
    purchase_master m 
WHERE 
    m.po_no = i.po_no 
    AND m.status != "manual" 
    AND m.po_date >= "'.$startOfWeek->format('Y-m-d').'" 
    AND m.po_date <= DATE_ADD("'.$startOfWeek->format('Y-m-d').'", INTERVAL 7 DAY)
GROUP BY 
    DATE(m.po_date)
ORDER BY 
    day';

$query = db_query($res);
				
				
				while($data = mysqli_fetch_object($query))
				{
				
				  $day_amount[$data->day_name]=$data->amnt;
				
				}





   $res=
'SELECT 
    DAYNAME(m.or_date) as day_name,
    DATE(m.or_date) as day,
    SUM(i.amount) as amnt 
FROM 
    warehouse_other_receive_detail i,
    warehouse_other_receive m 
WHERE 
    m.or_no = i.or_no 
    AND m.status not in ("MANUAL","CANCELED") and m.receive_type="Local Purchase"
    AND m.or_date >= "'.$startOfWeek->format('Y-m-d').'" 
    AND m.or_date <= DATE_ADD("'.$startOfWeek->format('Y-m-d').'", INTERVAL 7 DAY)
GROUP BY 
    DATE(m.or_date)
ORDER BY 
    day';

$query = db_query($res);
				
				
				while($datal = mysqli_fetch_object($query))
				{
				
				  $day_amountl[$datal->day_name]=$datal->amnt;
				
				}





?>






<!--// for year data ------------------------------------------------------------------start-->
<?php

$currentYear = date('Y'); // Get the current year

$res = '
SELECT 
    MONTH(m.po_date) as month_number,
    MONTHNAME(m.po_date) as month_name,
    SUM(i.amount) as amnt 
FROM 
    purchase_invoice i,
    purchase_master m 
WHERE 
    m.po_no = i.po_no 
    AND m.status != "manual" 
    AND m.po_date >= "'.$currentYear.'-01-01" 
    AND m.po_date <= "'.$currentYear.'-12-31"
GROUP BY 
    MONTH(m.po_date)
ORDER BY 
    MONTH(m.po_date)';
    
$query = db_query($res);

// Initialize an array to store the monthly amounts
$month_amount = [];

while ($data = mysqli_fetch_object($query)) {
    // Store the total amount for each month in the array
    $month_amount[$data->month_name] = $data->amnt;
}


//foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month) {
//    echo $month . ': ' . (isset($month_amount[$month]) ? $month_amount[$month] : 0) . "<br>";
//}





 $resl = '
SELECT 
    MONTH(m.or_date) as month_number,
    MONTHNAME(m.or_date) as month_name,
    SUM(i.amount) as amnt 
FROM 
    warehouse_other_receive_detail i,
    warehouse_other_receive m 
WHERE 
    m.or_no = i.or_no 
    AND m.status NOT IN ("MANUAL", "CANCELED") 
    AND m.receive_type = "Local Purchase"
    AND m.or_date >= "'.$currentYear.'-01-01" 
    AND m.or_date <= "'.$currentYear.'-12-31"
GROUP BY 
    MONTH(m.or_date)
ORDER BY 
    MONTH(m.or_date)';
	
$queryl = db_query($resl);

$month_amountl = [];

while ($datal = mysqli_fetch_object($queryl)) {
    $datal->month_name;
   
     $month_amountl[$datal->month_name] = $datal->amnt;
}

//foreach ($month_amount as $month => $amount) {
//    echo $month . ": " . $amount . "<br>";
//}


//______________________CHART _____________

$today = date('Y-m-d');
$lastdays = date("Y-m-d", strtotime("-7 days", strtotime($today)));
$last30days = date("Y-m-d", strtotime("-30 days", strtotime($today)));
$sunday=date('Y-m-d',strtotime('last sunday'));
$monday=date('Y-m-d',strtotime('last monday'));
$tuesday=date('Y-m-d',strtotime('last tuesday'));
$wednesday=date('Y-m-d',strtotime('last wednesday'));
$thursday=date('Y-m-d',strtotime('last thursday'));
$friday=date('Y-m-d',strtotime('last friday'));
$saturday=date('Y-m-d',strtotime('last saturday'));

$jan_start = date('Y-01-01');
$jan_end = date('Y-01-31');

$feb_start = date('Y-02-01');
$feb_end = date('Y-02-28');

$mar_start = date('Y-03-01');
$mar_end = date('Y-03-31');

$apr_start = date('Y-04-01');
$apr_end = date('Y-04-30');

$may_start = date('Y-05-01');
$may_end = date('Y-05-31');

$jun_start = date('Y-06-01');
$jun_end = date('Y-06-30');

$jul_start = date('Y-07-01');
$jul_end = date('Y-07-31');

$aug_start = date('Y-08-01');
$aug_end = date('Y-08-31');

$sep_start = date('Y-09-01');
$sep_end = date('Y-9-30');

$oct_start = date('Y-10-01');
$oct_end = date('Y-10-31');

$nov_start = date('Y-11-01');
$nov_end = date('Y-11-30');

$dec_start = date('Y-12-01');
$dec_end = date('Y-12-31');

$asset_value = find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.ledger_id=a.ledger_id and a.acc_class=1');


$revenue_value = find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.ledger_id=a.ledger_id and a.acc_class=4');

$liability_value = find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.ledger_id=a.ledger_id and a.acc_class=3');

$expense_value = find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.ledger_id=a.ledger_id and a.acc_class=5');




$rSa=find_a_field('journal','sum(dr_amt)','jv_date ="'.$saturday.'" and tr_from="Receipt"');
$rSu=find_a_field('journal','sum(dr_amt)','jv_date = "'.$sunday.'" and tr_from="Receipt"');
$rMo=find_a_field('journal','sum(dr_amt)','jv_date = "'.$monday.'" and tr_from="Receipt"');
$rTu=find_a_field('journal','sum(dr_amt)','jv_date = "'.$tuesday.'" and tr_from="Receipt"');
$rWe=find_a_field('journal','sum(dr_amt)','jv_date = "'.$wednesday.'" and tr_from="Receipt"');
$rTh=find_a_field('journal','sum(dr_amt)','jv_date = "'.$thursday.'" and tr_from="Receipt"');
$rFr=find_a_field('journal','sum(dr_amt)','jv_date = "'.$friday.'" and tr_from="Receipt"');


$pSa=find_a_field('journal','sum(cr_amt)','jv_date = "'.$saturday.'" and tr_from="Payment"');
$pSu=find_a_field('journal','sum(cr_amt)','jv_date = "'.$sunday.'" and tr_from="Payment"');
$pMo=find_a_field('journal','sum(cr_amt)','jv_date = "'.$monday.'" and tr_from="Payment"');
$pTu=find_a_field('journal','sum(cr_amt)','jv_date = "'.$tuesday.'" and tr_from="Payment"');
$pWe=find_a_field('journal','sum(cr_amt)','jv_date = "'.$wednesday.'" and tr_from="Payment"');
$pTh=find_a_field('journal','sum(cr_amt)','jv_date = "'.$thursday.'" and tr_from="Payment"');
$pFr=find_a_field('journal','sum(cr_amt)','jv_date = "'.$friday.'" and tr_from="Payment"');






$rJan=find_a_field('journal','sum(dr_amt)','jv_date between "'.$jan_start.'" and "'.$jan_end.'" and tr_from="Receipt"');
$rFeb=find_a_field('journal','sum(dr_amt)','jv_date between "'.$feb_start.'" and "'.$feb_end.'" and tr_from="Receipt"');
$rMar=find_a_field('journal','sum(dr_amt)','jv_date between "'.$mar_start.'" and "'.$mar_end.'" and tr_from="Receipt"');
$rApr=find_a_field('journal','sum(dr_amt)','jv_date between "'.$apr_start.'" and "'.$apr_end.'" and tr_from="Receipt"');
$rMay=find_a_field('journal','sum(dr_amt)','jv_date between "'.$may_start.'" and "'.$may_end.'" and tr_from="Receipt"');
$rjun=find_a_field('journal','sum(dr_amt)','jv_date between "'.$jun_start.'" and "'.$jun_end.'" and tr_from="Receipt"');
$rJul=find_a_field('journal','sum(dr_amt)','jv_date between "'.$jul_start.'" and "'.$jul_end.'" and tr_from="Receipt"');
$rAug=find_a_field('journal','sum(dr_amt)','jv_date between "'.$aug_start.'" and "'.$aug_end.'" and tr_from="Receipt"');
$rSept=find_a_field('journal','sum(dr_amt)','jv_date between "'.$sep_start.'" and "'.$sep_end.'" and tr_from="Receipt"');
$rOct=find_a_field('journal','sum(dr_amt)','jv_date between "'.$oct_start.'" and "'.$oct_end.'" and tr_from="Receipt"');
$rNov=find_a_field('journal','sum(dr_amt)','jv_date between "'.$not_start.'" and "'.$nov_end.'" and tr_from="Receipt"');
$rDec=find_a_field('journal','sum(dr_amt)','jv_date between "'.$dec_start.'" and "'.$dec_end.'" and tr_from="Receipt"');

$pJan=find_a_field('journal','sum(cr_amt)','jv_date between "'.$jan_start.'" and "'.$jan_end.'" and tr_from="Payment"');
$pFeb=find_a_field('journal','sum(cr_amt)','jv_date between "'.$feb_start.'" and "'.$feb_end.'" and tr_from="Payment"');
$pMar=find_a_field('journal','sum(cr_amt)','jv_date between "'.$mar_start.'" and "'.$mar_end.'" and tr_from="Payment"');
$pApr=find_a_field('journal','sum(cr_amt)','jv_date between "'.$apr_start.'" and "'.$apr_end.'" and tr_from="Payment"');
$pMay=find_a_field('journal','sum(cr_amt)','jv_date between "'.$may_start.'" and "'.$may_end.'" and tr_from="Payment"');
$pjun=find_a_field('journal','sum(cr_amt)','jv_date between "'.$jun_start.'" and "'.$jun_end.'" and tr_from="Payment"');
$pJul=find_a_field('journal','sum(cr_amt)','jv_date between "'.$jul_start.'" and "'.$jul_end.'" and tr_from="Payment"');
$pAug=find_a_field('journal','sum(cr_amt)','jv_date between "'.$aug_start.'" and "'.$aug_end.'" and tr_from="Payment"');
$pSept=find_a_field('journal','sum(cr_amt)','jv_date between "'.$sep_start.'" and "'.$sep_end.'" and tr_from="Payment"');
$pOct=find_a_field('journal','sum(cr_amt)','jv_date between "'.$oct_start.'" and "'.$oct_end.'" and tr_from="Payment"');
$pNov=find_a_field('journal','sum(cr_amt)','jv_date between "'.$not_start.'" and "'.$nov_end.'" and tr_from="Payment"');
$pDec=find_a_field('journal','sum(cr_amt)','jv_date between "'.$dec_start.'" and "'.$dec_end.'" and tr_from="Payment"');




?>
 <!--for year data ------------------------------------------------------------------end-->





















  
  <!-- CSS Files -->
  <link href="../../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
<style type="text/css">
	/*new Deshbord css start*/
	.sr-main-content .pt-4{
	padding:0px !important;
	}
 	.card-title{
		text-align:left;
		font-size: 14px;
		color:#004085;
		margin: 0px;
	}
	
	.card-title span{
		font-weight: normal;
		color:#605d5d;
	}
	
	.bold{
		font-weight:bold;
	}
	
	.button-cs{
		padding:2px !important;
		font-size: 12px !important;
	}
	
	.new{
	    padding-left: 8px;
    	padding-right: 8px;
	}
	
	.new-icon{
	    width: 50px;
		height: 50px;
		background: #dfe9f3;
		border-radius: 50%;
		color: #007bff;
		text-align: center;
		padding: 12px;
    	font-size: 18px;
		white-space: nowrap;
		overflow: hidden;
	}
	
	.primary{
	    background-color: whitesmoke !important;
    	color: #007bff !important;
	}
	
		
	.success{
	    background-color: #cfffcf !important;
    	color: #3cb514 !important;
	}
	
		
	.danger{
	    background-color: #ffe9eb !important;
    	color: #dc3545 !important;
	}
	
		
	.info{
	    background-color: #dbfaff !important;
    	color: #17a2b8 !important;
	}

	.warning{
		background-color: #fea2204f !important;
		color: #c8811f !important;
	}
	
	.bg-warning {
		background-color: #fb9006 !important;
	}
	
	button.bg-warning:hover{
		background-color: #fb9006 !important;	
	}
	
	.green-new{
		background-color: #008fa15c !important;
    	color: #17a2b8 !important;
	}
	
	.bg-green-new {
		background-color: #008fa1 !important;
	}
	button.bg-green-new:hover{
		background-color: #008fa1 !important;	
	}

	
	.purple-new{
		background-color: #5c31a45c !important;
    	color: #5c31a4 !important;
	}
	
	.bg-purple-new {
		background-color: #5c31a4 !important;
	}
	button.bg-purple-new:hover{
		background-color: #5c31a4 !important;	
	}
	
	.violet-new{
		background-color: #aa20ad4d  !important;
    	color: #aa20ad !important;
	}
	
	.bg-violet-new {
		background-color: #aa20ad !important;
	}
	button.bg-violet-new:hover{
		background-color: #aa20ad !important;	
	}

	.new-icon-text{
		padding-left: 10px;
		color: #333;
		font-size: 16px;
		padding-top: 3px;
	}
	
	.p-sub, .p-sub1{
	    margin: 0px;
	}
	
	.p-sub{
		color:#1a1972;
	}
	
	.p-sub1{
		font-size: 12px;
	}
	
	.p-sub1 span{
		font-weight:bold;
		color:#28a745;
	}
	
	.btn:hover, .a{
	color:#fff !important;
	}
	
	.new .card {
		margin: 15px 0px 0px 0px !important;
	}
	
	.card {
		margin: 0px !important;
	}
	
	/*new Deshbord css end*/

  #onemounth{
  	height: 268px;
  
  }
  
  @media(max-width: 1200px) {
	  #onemounth{
		    height: 212px;
	  }
   }
   
     @media(max-width: 1400px) {
	  #onemounth{
		    height: 212px;
	  }
   }
   
   @media(max-width: 1500px) {
	  #onemounth{
		    height: 357px;
	  }
   }
  @media (max-width: 768px) {
  .today-clock{
  display:none !important;  
  }
  }
</style>



<div class="container-fluid">
			<div class="row m-0 p-0">
			
						
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Payment <span> || Year-<?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary"><?=$total_voucherP->n?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp; </p>-->
							<p class="p-sub1"><span><i class="fa-solid fa-bangladeshi-taka-sign"></i> : <?=$total_voucherP->m?></span></p>
						 </div>
						
						</div>
						<a href="../cash_voucher/debit_note.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-primary button-cs"> <i class="fas fa-check-circle"></i> Cash Voucher</button>
						</a>
						<a href="../bank_voucher/debit_note.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-primary button-cs"> <i class="fas fa-check-circle"></i> Bank Voucher</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Receive  <span> || Year-<?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon success"><?=$total_voucherR->n?></div>
						<div class="new-icon-text">
						     <!--<p class="p-sub bold">&nbsp; </p>-->
							<p class="p-sub1"><span><i class="fa-solid fa-bangladeshi-taka-sign"></i> : <?=$total_voucherR->m?></span></p>
						 </div>
						
						</div>
						
						<a href="../cash_voucher/credit_note.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-success button-cs"> <i class="fas fa-check-circle"></i> Cash Voucher</button>
						</a>
						<a href="../bank_voucher/credit_note.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-success button-cs"> <i class="fas fa-check-circle"></i> Bank Voucher</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold"> Journal <span> || Year-<?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><?=$total_voucherJ->n ?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp; </p>-->
							<p class="p-sub1">  <span> <i class="fa-solid fa-bangladeshi-taka-sign"></i> : <?=$total_voucherJ->m?></span></p>
						 </div>
						
						</div>
						
						<a href="journal_note_new.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-danger button-cs"> <i class="fas fa-check-circle"></i> New Voucher</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Contra<span> || Year-<?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon info"><?=$total_voucherC->n?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp; </p>-->
							<p class="p-sub1"><span><i class="fa-solid fa-bangladeshi-taka-sign"></i> :  <?=$total_voucherC->m?></span></p>
						 </div>
						
						</div>
						
						<a href="coutra_note_new.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-info button-cs"> <i class="fas fa-check-circle"></i> New Voucher</button>
						</a>
					  </div>
					</div>
				</div>


			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Approve MRR <span> || Year-<?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon warning"><?= $MRR_Approve->n?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold"></p>-->
							<p class="p-sub1"><span> <i class="fa-solid fa-bangladeshi-taka-sign"></i> : <?=$MRR_Approve->m?></span></p>
						 </div>
						
						</div>
						
						<a href="purchased_verify_black_tea.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-warning button-cs"> <i class="fas fa-check-circle"></i> View Approval </button>
						</a>
					  </div>
					</div>
				</div>


			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Approve Chalan <span> || Year-<?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon green-new"><?= $Chalan_Approve ->n?></div>
						<div class="new-icon-text">
						<!-- <p class="p-sub bold"></p>-->
							<p class="p-sub1"><span> <i class="fa-solid fa-bangladeshi-taka-sign"></i> : <?= $Chalan_Approve->m?></span></p>
						 </div>
						
						</div>
						
						<a href="ch_received_amt.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-green-new button-cs"> <i class="fas fa-check-circle"></i> View Approval </button>
						</a>
					  </div>
					</div>
				</div>


			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Purchase Return<span> || Year-<?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon purple-new"><?=$PR_Approve->n?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold"></p>-->
							<p class="p-sub1"><span><i class="fa-solid fa-bangladeshi-taka-sign"></i> : <?=$PR_Approve->m?></span></p>
						 </div>
						
						</div>
						
						<a href="purchased_verify_black_tea.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-purple-new button-cs"> <i class="fas fa-check-circle"></i> View Approval</button>
						</a>
					  </div>
					</div>
				</div>



			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Sales Return<span> || Year-<?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon violet-new"><?=$GR_Approve->n?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold"></p>-->
							<p class="p-sub1">  <span><i class="fa-solid fa-bangladeshi-taka-sign"></i> : <?=$GR_Approve->m?></span></p>
						 </div>
						
						</div>
						
						<a href="sr_received_amt.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-violet-new button-cs"> <i class="fas fa-check-circle"></i> View Approval </button>
						</a>
					  </div>
					</div>
				</div>


			</div>
			
			
			
			
<div class="row m-0 p-0 mt-4">
  <div class="col-lg-6 col-md-3 col-sm-12 new">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title bold">Top 5 Advance Reports  <span> || Year-<?php echo date("Y"); ?></span></h5>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon primary" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Transaction Statement Report</span>
          </div>
		  
		  <a href="transaction_listledger.php">
		  <div class="d-flex align-items-center"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span>		</a>
          </div>
        </div>
		

		
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon warning" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Trial Balance</span>
          </div>
          <div class="d-flex align-items-center">
          <a href="trial_balance_detail_new.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span>		</a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon success" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Party Balance</span>
          </div>
          <div class="d-flex align-items-center">
           
            <a href="party_balance_report.php"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon info" style="width: 15px; height: 15px; border-radius: 50%;"></div>
           <span class="ml-2">Bank Book</span>
          </div>
          <div class="d-flex align-items-center">
           
             <a href="bank_book.php"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon danger" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Cash Book</span>
          </div>
          <div class="d-flex align-items-center">
          
            <a href="cash_book.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
      </div>
    </div>
	
	
	
  </div>
  
  
  
  
  <div class="col-lg-6 col-md-3 col-sm-12 new">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title bold">Top 5 Financial Reports  <span> || Year-<?php echo date("Y"); ?></span></h5>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon primary" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Comparative Financial Statements</span>
          </div>
          <div class="d-flex align-items-center">
          <a href="../financial_report/financial_statement_comparative.php"><span class="text-success"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon warning" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Comparative Income Statement</span>
          </div>
          <div class="d-flex align-items-center">
             <a href="../financial_report/financial_profit_loss_comparative.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon success" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Statement of Profit or Loss & Other Income</span>
          </div>
          <div class="d-flex align-items-center">
            <a href="../financial_report/financial_profit_loss.php"><span class="text-success"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon info" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Cost of Goods Sold</span>
          </div>
          <div class="d-flex align-items-center">
            <a href="../financial_report/financial_cogs_cal.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon danger" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Receipt & Payment Statement</span>
          </div>
          <div class="d-flex align-items-center">
          <a href="../financial_report/receipt_payment_statement.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
      </div>
    </div>
	
	
	
  </div>
  
  
  
  
  
</div>





</div>

<br />


<?php /*?><?
$sql="SELECT SUM(cr_amt)amount,tr_from FROM `secondary_journal` WHERE tr_from in ('Purchase','LocalPurchase','Purchase Return') GROUP BY tr_from";
$qr = db_query($sql);while ($data = mysqli_fetch_object($qr)) {$purchase[$data->tr_from]=$data->amount;}
?>
		
<?php */?>		



 <!--///////////////////////////////////////////chart start values ////////////////////////////////////////////////////////////////-->

<script type="text/javascript">



///////////// 1st chart//////////////////
var mSalesChart = <?php echo isset($asset_value) ? $asset_value : 0; ?>;
var pSalesChart = <?php echo isset($revenue_value) ? $revenue_value : 0; ?>;
var lSalesChart = <?php echo isset($liability_value) ? $liability_value : 0; ?>;
var salesReturnChart = <?php echo isset($expense_value) ? $expense_value : 0; ?>;
var oilCanvas = document.getElementById("oilChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Assets",
        "Revenue",
        "Liability",
        "Expense"
    ],
    datasets: [
        {
            data: [mSalesChart, pSalesChart, lSalesChart, salesReturnChart],
            backgroundColor: [
                "#008fa1",
                "#6491d1",
                "#5b995e",
                "#fb9006"
            ]
        }]

};

var pieChart = new Chart(oilCanvas, {
  type: 'pie',
  data: oilData
});



///////////// 2nd chart//////////////////
    // Set fixed data values for each label between 1000 and 7000


	
	
		
    var ReceiptData =  [<?=$rSa?>, <?=$rSu?>, <?=$rMo?>, <?=$rTu?>, <?=$rWe?>, <?=$rTh?>, <?=$rFr?>];
    var PaymentData = [<?=$pSa?>, <?=$pSu?>, <?=$pMo?>, <?=$pTu?>, <?=$pWe?>, <?=$pTh?>, <?=$pFr?>];
    
    var data = {
        labels: ["Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri"],
        datasets: [
            {
                label: "Receipt",
                backgroundColor: "#fb9006",  // Soft teal background
                borderColor: "#fb9006",         // Teal border
                borderWidth: 2,
                hoverBackgroundColor: "#fb9006", // Soft blue hover
                hoverBorderColor: "#fb9006",     // Blue hover border
                data: ReceiptData
            },
            {
                label: "Payment",
                backgroundColor: "#008fa1",   // Soft orange background
                borderColor: "#008fa1",          // Orange border
                borderWidth: 2,
                hoverBackgroundColor: "#008fa1", // Soft red hover
                hoverBorderColor: "#008fa1",     // Red hover border
                data: PaymentData
            }
        ]
    };

    var option = {
        scales: {
            yAxes: [{
                stacked: false,  // Set to false for separate bars
                gridLines: {
                    display: true,
                    color: "rgba(220, 220, 220, 0.3)"  // Light grey grid lines
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false
                }
            }]
        },
        legend: {
            display: true,
            labels: {
                fontColor: "#333",  // Dark grey for legend text
                fontSize: 14
            }
        }
    };
    // Set canvas size before initializing chart
    var canvas = document.getElementById("chart_0");
    canvas.width = 482;  // Set the width
    canvas.height = 321; // Set the height

    // Initialize the chart on the canvas element with id 'chart_0'
    var ctx = document.getElementById("chart_0").getContext("2d");
    new Chart(ctx, {
        type: 'bar',
        data: data,
        options: option
    });


///////////// 3rd chart//////////////////
    // Example data values between 1000 and 20000


      var ReceiptData = [<?=$rJan?>, <?=$rFeb?>, <?=$rMar?>, <?=$rApr?>, <?=$rMay?>, <?=$rJun?>, <?=$rJul?> ,<?=$rAug?>,<?=$rSep?>,
	<?=$rOct?>,<?=$rNov?>,<?=$rDec?>];
	
    var PaymentData = [<?=$pJan?>, <?=$pFeb?>, <?=$pMar?>, <?=$pApr?>, <?=$pMay?>, <?=$pJun?>, <?=$pJul?> ,<?=$pAug?>,<?=$pSep?>,
	<?=$pOct?>,<?=$pNov?>,<?=$pDec?>];

    var ctx = document.getElementById("onemounth").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [
                {
                    label: 'Receipt',
                    data: ReceiptData,
                    fill: false,
                    borderColor: '#fb9006',
                    backgroundColor: '#fb9006',
                    borderWidth: 2
                },
                {
                    label: 'Payment',
                    data: PaymentData,
                    fill: false,
                    borderColor: '#008fa1',
                    backgroundColor: '#008fa1',
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 10000  // Set a maximum Y-axis range slightly above your data range for better visualization
                }
            }
        }
    });


///////////// 4th chart//////////////////
    // Example data values between 3000 and 4000
    var cYearSales = 3700; // Current year Sales
    var oYearSales = 1400; // One year ago Sales
    var ooYearSales = 3100; // Two years ago Sales
    var oooYearSales = 3000; // Two years ago Sales 3

    var cYearSales3 = 3600; // Current year Sales 3
    var oYearSales3 = 2300; // One year ago Sales 3
    var ooYearSales3 = 3000; // Two years ago Sales 3
	var oooYearSales3 = 3000; // Two years ago Sales 3

    var chartColors = {
        yellow: '#008fa1',
        green: '#fb9006'
    };

    var data = {
        labels: ["2023", "2022", "2021", "2020"],
        datasets: [
            {
                label: 'Purchase',
                backgroundColor: [
                    chartColors.yellow,
                    chartColors.yellow,
                    chartColors.yellow,
                    chartColors.yellow
                ],
                data: [cYearSales, oYearSales, ooYearSales, oooYearSales]  // Sales data
            },
            {
                label: 'Local',
				backgroundColor: [
                    chartColors.green,
                    chartColors.green,
                    chartColors.green,
                    chartColors.green
                ],
                data: [cYearSales3, oYearSales3, ooYearSales3, oooYearSales3]  // Sales 3 data
            }
        ]
    };

    var myBar = new Chart(document.getElementById("oneweek"), {
        type: 'horizontalBar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            legend: {
                display: true,
                position: 'top'
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        suggestedMax: 4500  // Keeps the range appropriate for values between 3000 and 4000
                    }
                }]
            }
        }
    });

</script>


   
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>