<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";


$title = "Sales Management Dashboard";
$tr_type="Show";
$cur = '&#x9f3;';


function getMonthlySales($month, $year) {
    // Get the start and end dates of the specified month
    $start_date = date("$year-$month-01");
    $end_date = date("$year-$month-t"); // 't' gives the last day of the month

    // Query to get the sales total for the month, excluding certain statuses
    return find_a_field(
        'sale_do_details',
        'sum(total_amt)',
        'do_date BETWEEN "'.$start_date.'" AND "'.$end_date.'" AND status NOT IN ("MANUAL", "CANCELED")'
    );
}

function getYearlySales($year) {
    $salesData = [];
    
    // Loop through each month
    for ($month = 1; $month <= 12; $month++) {
        // Format month as two digits (e.g., "01" for January)
        $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
        
        // Get sales for the month
        $salesData[$formattedMonth] = getMonthlySales($formattedMonth, $year);
    }
    
    return $salesData;
}





/* 
 
 $new_local_purchase_order=find_a_field('warehouse_other_receive','count(*)','1 and YEAR(or_date) ="'.$current_year.'" and status="UNCHECKED" and entry_by="'.$_SESSION['user']['id'].'"');
 $receive_order=find_a_field('purchase_receive pr, purchase_master pm','count(pm.po_no)','1 and pm.po_no=pr.po_no and YEAR(rec_date) ="'.$current_year.'" and pm.entry_by="'.$_SESSION['user']['id'].'" group by pm.po_no');
 $purchase_return=find_a_field('purchase_return_master','count(*)','1 and YEAR(pr_date) ="'.$current_year.'"  and entry_by="'.$_SESSION['user']['id'].'"');
 $approved_po=find_a_field('purchase_master ','count(*)','1 and YEAR(po_date) ="'.$current_year.'" and status="CHECKED" and entry_by="'.$_SESSION['user']['id'].'"');



echo '<pre>';
echo 'ddddddddddddd';
echo $purchase_return;
echo 'zzzzzzzzzzzzzzzzzzzzz';
echo '</pre>';*/


//_____________ CALCULATION DASHBOARD LOGIC __________////////
$tr_from="Sales";
$today = date('Y-m-d');
//current year
$current_year = date('Y');
$lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
$user_id = $_SESSION['user']['id'];
$today = date('Y-m-d');
$depot = $_SESSION['user']['depot'];

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


$Sat=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$saturday.'" and    status not in ("MANUAL","CANCELED")');
$Sun=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$sunday.'" and status not in ("MANUAL","CANCELED")');
$Mon=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$monday.'" and   status not in ("MANUAL","CANCELED")');
$Tue=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$tuesday.'"   and status not in ("MANUAL","CANCELED")');
$Wed=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$wednesday.'"  and status not in ("MANUAL","CANCELED")');
$Thu=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$thursday.'"  and status not in ("MANUAL","CANCELED")');
$Fri=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$friday.'"  and status not in ("MANUAL","CANCELED")');


$return_sat = find_a_field('sale_return_details', 'sum(total_amt)', 'do_date="'.$saturday.'" and status not in ("MANUAL","CANCELED")');
$return_sun = find_a_field('sale_return_details', 'sum(total_amt)', 'do_date="'.$sunday.'" and status not in ("MANUAL","CANCELED")');
$return_mon = find_a_field('sale_return_details', 'sum(total_amt)', 'do_date="'.$monday.'" and status not in ("MANUAL","CANCELED")');
$return_tue = find_a_field('sale_return_details', 'sum(total_amt)', 'do_date="'.$tuesday.'" and status not in ("MANUAL","CANCELED")');
$return_wed = find_a_field('sale_return_details', 'sum(total_amt)', 'do_date="'.$wednesday.'" and status not in ("MANUAL","CANCELED")');
$return_thu = find_a_field('sale_return_details', 'sum(total_amt)', 'do_date="'.$thursday.'" and status not in ("MANUAL","CANCELED")');
$return_fri = find_a_field('sale_return_details', 'sum(total_amt)', 'do_date="'.$friday.'" and status not in ("MANUAL","CANCELED")');


// Usage example for the current year
$yearlySales = getYearlySales(date('Y'));

// Access sales data for each month
$salesJan = $yearlySales['01'];
$salesFeb = $yearlySales['02'];
$salesMar=$yearlySales['03'];
$salesApr=$yearlySales['04'];
$salesMay=$yearlySales['05'];
$salesJun=$yearlySales['06'];
$salesJul=$yearlySales['07'];
$salesAug=$yearlySales['08'];
$salesSep= $yearlySales['09'];
$salesOct= $yearlySales['10'];
$salesNov= $yearlySales['11'];
$salesDec= $yearlySales['12'];

$srJan=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$jan_start.'" and "'.$jan_end.'" and status not in ("MANUAL","CANCELED")');
$srFeb=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$feb_start.'" and "'.$feb_end.'" and status not in ("MANUAL","CANCELED")');
$srMar=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$mar_start.'" and "'.$mar_end.'" and status not in ("MANUAL","CANCELED")');
$srApr=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$apr_start.'" and "'.$apr_end.'" and status not in ("MANUAL","CANCELED")');
$srMay=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$may_start.'" and "'.$may_end.'" and status not in ("MANUAL","CANCELED")');
$srJun=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$jun_start.'" and "'.$jun_end.'" and status not in ("MANUAL","CANCELED")');
$srJul=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$jul_start.'" and "'.$jul_end.'" and status not in ("MANUAL","CANCELED")');
$srAug=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$aug_start.'" and "'.$aug_end.'" and status not in ("MANUAL","CANCELED")');
$srSep=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$sep_start.'" and "'.$sep_end.'" and status not in ("MANUAL","CANCELED")');
$srOct=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$oct_start.'" and "'.$oct_end.'" and status not in ("MANUAL","CANCELED")');
$srNov=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$nov_start.'" and "'.$nov_end.'" and status not in ("MANUAL","CANCELED")');
$srDec=find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$dec_start.'" and "'.$dec_end.'" and status not in ("MANUAL","CANCELED")');



/*$totalSales = $Sat+$Sun+$Mon+$Tue+$Wed+$Thu+$Fri;
$hSat=($Sat*100)/$totalSales;
$hSun=($Sun*100)/$totalSales;
$hMon=($Mon*100)/$totalSales;
$hTue=($Tue*100)/$totalSales;
$hWed=($Wed*100)/$totalSales;
$hThu=($Thu*100)/$totalSales;
$hFri=($Fri*100)/$totalSales;*/


$thisYear = date('Y');
$lastYear = date('Y')-1;
$previousYear = date('Y')-2;
$previousLastYear = date('Y')-3;

$thisYearSdate = $thisYear.'-01-01';
$thisYearEdate = $thisYear.'-12-31';
$thisYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'" and status not in ("MANUAL","CANCELED")');

$thisYearSalesReturn = find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'"');

$lastYearSdate = $lastYear.'-01-01';
$lastYearEdate = $lastYear.'-12-31';
$lastYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'"  and status not in ("MANUAL","CANCELED")');

$lastYearSalesReturn = find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'"');

$preYearSdate = $previousYear.'-01-01';
$preYearEdate = $previousYear.'-12-31';
$preYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$preYearSdate.'" and "'.$preYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL","CANCELED")');

$preYearSalesReturn = find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$preYearSdate.'" and "'.$preYearEdate.'"');



$preLastYearSdate = $previousLastYear.'-01-01';
$preLastYearEdate = $previousLastYear.'-12-31';
$preLastYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$preLastYearSdate.'" and "'.$preLastYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL","CANCELED")');

$preLastSalesReturn = find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$preLastYearSdate.'" and "'.$preLastYearEdate.'"');




/*___________ 7 DAYS Sales report____________*/


$sales7days = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$lastdays.'" and "'.$today.'" and depot_id="'.$_SESSION['user']['depot'].'" 
and status not in ("MANUAL","CANCELED")');



$YearlyPosSales = find_a_field('warehouse_other_issue m, warehouse_other_issue_detail s','sum(amount)','m.oi_date between "' . $current_year . '-01-01" 
and "'.$today.'"  and m.status not in ("MANUAL","CANCELED") and m.issue_type="DirectSales" and m.oi_no=s.oi_no');
		 

$CountPosSales = find_a_field('warehouse_other_issue m, warehouse_other_issue_detail s','COUNT(m.oi_no)','m.oi_date between "' . $current_year . '-01-01" 
and "'.$today.'"  and m.status not in ("MANUAL","CANCELED") and m.issue_type="DirectSales" and m.oi_no=s.oi_no');
		 
		 
$YearlyLocalSales = find_a_field('warehouse_other_issue m, warehouse_other_issue_detail s','sum(amount)','m.oi_date between "' . $current_year . '-01-01" 
and "'.$today.'"  and m.status not in ("MANUAL","CANCELED") and m.issue_type="Local Sales" and m.oi_no=s.oi_no');

$CountYearlyLocalSales = find_a_field('warehouse_other_issue m, warehouse_other_issue_detail s','COUNT(m.oi_no)','m.oi_date between "' . $current_year . '-01-01" 
and "'.$today.'"  and m.status not in ("MANUAL","CANCELED") and m.issue_type="Local Sales" and m.oi_no=s.oi_no');


$sales_return_value = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "' . $current_year . '-01-01"  AND "'.$thisYearEdate.'" AND m.status = "CHECKED"'
);


$count_return_value = find_a_field('sale_return_master','COUNT(sr_no)','sr_date between "' . $current_year . '-01-01"  and "'.$today.'" and 
 status = "CHECKED"');



 
/*$YearlySales = find_a_field('sale_do_details','sum(total_amt)','1 YEAR(do_date) ="'.$current_year.'" and depot_id="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL","CANCELED")');*/



/* $new_purchase_order=find_a_field('purchase_master ','count(*)','1 and YEAR(po_date) ="'.$current_year.'" and status="UNCHECKED" 
 and entry_by="'.$_SESSION['user']['id'].'"');*/
 

// Query to check if there�s an entry with a matching ID
$has_entry = find_a_field('sale_do_details', 'COUNT(*)', 'entry_by = "' . $user_id . '"');

if ($has_entry > 0) {

        $YearlySales = find_all_field_sql("select COUNT(DISTINCT do_no)as do_no,SUM(total_amt) as sales_amt from sale_do_details 
		where 1 and do_date>='".$current_year.'-01-01'."' and entry_by  = '".$user_id."' and status not in ('MANUAL','CANCELED')");

      /*  $YearlyPosSales = find_a_field('sale_pos_details s, sale_pos_master m','SUM(s.total_amt)','s.pos_date BETWEEN "' . $current_year . '-01-01" AND "'
		 . $today . '" AND s.entry_by = "' . $user_id . '" AND m.status NOT IN ("MANUAL", "CANCELED") AND m.pos_id = s.pos_id');*/
  
     
} else {

        $YearlySales = find_all_field_sql("select COUNT(DISTINCT do_no)as do_no,SUM(total_amt)as sales_amt from sale_do_details 
		where 1 and do_date>='".$current_year.'-01-01'."' and status not in ('MANUAL','CANCELED')");

       }





?>

  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  
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
						<h5 class="card-title bold">TOTAL SALES <span> || Year 2024</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary"><?=$YearlySales->do_no;?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp;</p>-->
							<p class="p-sub1">  <span> <?=number_format($YearlySales->sales_amt,2);?> <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						<a href="../wo/do.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-primary button-cs"> <i class="fas fa-check-circle"></i> New Order</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">DIRECT SALES<span> || Year 2024</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon success"><?= !empty($CountPosSales) ? $CountPosSales : 0 ?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp;</p>-->
							<p class="p-sub1">  <span><?= !empty($YearlyPosSales) ? $YearlyPosSales : 0 ?> <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
						<a href="../direct_sales/direct_sales.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-success button-cs"> <i class="fas fa-check-circle"></i> New Order</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">LOCAL SALES<span> || Y-2024</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><?= !empty($CountYearlyLocalSales) ? $CountYearlyLocalSales : 0 ?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp;</p>-->
							<p class="p-sub1"> <span> <?= !empty($YearlyLocalSales) ? $YearlyLocalSales : 0 ?>  <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
						<a href="../report/work_chalan_report.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-danger button-cs"> <i class="fas fa-check-circle"></i> Check Order</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">SALES RETURN<span> || Y-2024</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon info"><?= !empty($count_return_value) ? $count_return_value : 0 ?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp;</p>-->
							<p class="p-sub1">  <span> <?= !empty($sales_return_value) ? $sales_return_value : 0 ?> <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
						<a href="../report/work_chalan_report.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-info button-cs"> <i class="fas fa-check-circle"></i> Check Return</button>
						</a>
					  </div>
					</div>
				</div>


		


			</div>

		
			<div class="row m-0 p-0 mt-4">
			
  <div class="col-12 new">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title bold"> Quick Shortcuts    <span> || Year-<?php echo date("Y"); ?></span></h5>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon primary" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Sales Quotation Create</span>
          </div>
		  
		  <a href="../quotation/select_dealer.php?new=2">
		  <div class="d-flex align-items-center"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span>		</a>
          </div>
        </div>
		

		
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon warning" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Create Sales Order</span>
          </div>
          <div class="d-flex align-items-center">
          <a href="../wo/do.php?new=2"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span>		</a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon success" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Direct Sales Entry</span>
          </div>
          <div class="d-flex align-items-center">
           
            <a href="../direct_sales/direct_sales.php?new=2"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon info" style="width: 15px; height: 15px; border-radius: 50%;"></div>
           <span class="ml-2">Delivery Sales Order Report</span>
          </div>
          <div class="d-flex align-items-center">
           
             <a href="../report/sales_report.php"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon danger" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Delivery Challan Reports</span>
          </div>
          <div class="d-flex align-items-center">
          
            <a href="../report/sales_report.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
      </div>
    </div>
	
	<br />
	
  </div>
</div>


   
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>