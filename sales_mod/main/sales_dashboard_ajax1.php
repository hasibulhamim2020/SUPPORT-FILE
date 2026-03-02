<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');
$thisMonthFirstDate = date('Y-m-01');
$today = date('Y-m-d'); 
$thismonth = date('m',strtotime($thisMonthFirstDate));

$last_month = date("Y-m-d", strtotime("-1 days", strtotime($thisMonthFirstDate)));
$lastMonthDays = date('t',strtotime($lastMonthFirstDay));
$lastMonthFirstDay = date("Y-m-01", strtotime($last_month));
$lastMonthLastDay = date("Y-m-".$lastMonthDays, strtotime($last_month));

$pbmonth = date('m',strtotime($lastMonthFirstDay));
$pbyear = date('Y',strtotime($lastMonthFirstDay));

$last30days = date("Y-m-d", strtotime("-31 days", strtotime($today)));

$year = find_a_field('party_wise_sale_target','year','1');
$month = find_a_field('party_wise_sale_target','month','1');

$t=$year.'-'.$month.'-01';
$mdays = date('t',strtotime($t)); 
$s=$year.'-'.$month.'-'.$mdays;

$sunday=date('Y-m-d',strtotime('last sunday'));
$monday=date('Y-m-d',strtotime('last monday'));
$tuesday=date('Y-m-d',strtotime('last tuesday'));
$wednesday=date('Y-m-d',strtotime('last wednesday'));
$thursday=date('Y-m-d',strtotime('last thursday'));
$friday=date('Y-m-d',strtotime('last friday'));
$saturday=date('Y-m-d',strtotime('last saturday'));

$jan_start = date('Y-01-01');
$jan_end = date('Y-01-31');
$jan = date('m',strtotime($jan_start));

$feb_start = date('Y-02-01');
$feb_end = date('Y-02-28');
$feb = date('m',strtotime($feb_start));

$mar_start = date('Y-03-01');
$mar_end = date('Y-03-31');
$mar = date('m',strtotime($mar_start));

$apr_start = date('Y-04-01');
$apr_end = date('Y-04-30');
$apr = date('m',strtotime($apr_start));

$may_start = date('Y-05-01');
$may_end = date('Y-05-31');
$may = date('m',strtotime($may_start));

$jun_start = date('Y-06-01');
$jun_end = date('Y-06-30');
$jun = date('m',strtotime($jun_start));

$jul_start = date('Y-07-01');
$jul_end = date('Y-07-31');
$jul = date('m',strtotime($jul_start));

$aug_start = date('Y-08-01');
$aug_end = date('Y-08-31');
$aug = date('m',strtotime($aug_start));

$sep_start = date('Y-09-01');
$sep_end = date('Y-9-30');
$sep = date('m',strtotime($sep_start));

$oct_start = date('Y-10-01');
$oct_end = date('Y-10-31');
$oct = date('m',strtotime($oct_start));

$nov_start = date('Y-11-01');
$nov_end = date('Y-11-30');
$nov = date('m',strtotime($nov_start));

$dec_start = date('Y-12-01');
$dec_end = date('Y-12-31');
$dec = date('m',strtotime($dec_start));

$in_qty = find_a_field('journal_item','sum(item_in)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"');
$in_price = find_a_field('journal_item','avg(item_price)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"');
$ex_qty = find_a_field('journal_item','sum(item_ex)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"');
$ex_price = find_a_field('journal_item','avg(item_price)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"');
$total_in_price = $in_price*$in_qty;
$total_ex_price = $ex_price*$ex_qty;
$presentStock = $in_qty - $ex_qty;
$stock_value = $total_in_price-$total_ex_price;


$sales30days = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$lastMonthFirstDay.'" and "'.$lastMonthLastDay.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$sale30target = find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$pbmonth.'"');

$thismonthsales = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$thisMonthFirstDate.'" and "'.$today.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$thismonthtarget = find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$thismonth.'"');


//chart code start
$tSalesChart = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$lastMonthFirstDay.'" and "'.$lastMonthLastDay.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$trSalesChart = find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$pbmonth.'"');


//this month
$thismonthsales = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$thisMonthFirstDate.'" and "'.$today.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$thismonthtarget = find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$thismonth.'"');




$localsales7days = find_a_field('warehouse_other_issue m, warehouse_other_issue_detail s','sum(amount)','m.oi_date between "'.$lastdays.'" and "'.$today.'" and m.warehouse_id="'.$_SESSION['user']['depot'].'" and m.status not in ("MANUAL","CANCELED") and m.issue_type="Local Sales" and m.oi_no=s.oi_no');

$sales_return_value = find_a_field('sale_return_details','sum(total_amt)','do_date between "'.$lastdays.'" and "'.$today.'" and depot_id="'.$_SESSION['user']['depot'].'"');

$total_transaction=$sales7days+$possales7days+$localsales7days+$sales_return_value;
$salesChart = ($sales7days*100)/$total_transaction;
$posSalesChart = ($possales7days*100)/$total_transaction;
$localSalesChart = ($localsales7days*100)/$total_transaction;
$alesReturnChart = ($sales_return_value*100)/$total_transaction;

$Sat=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$saturday.'" and depot_id="'.$_SESSION['user']['depot'].'"  and status not in ("MANUAL","CANCELED")');
$Sun=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$sunday.'" and depot_id="'.$_SESSION['user']['depot'].'"  and status not in ("MANUAL","CANCELED")');
$Mon=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$monday.'" and depot_id="'.$_SESSION['user']['depot'].'"  and status not in ("MANUAL","CANCELED")');
$Tue=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$tuesday.'" and depot_id="'.$_SESSION['user']['depot'].'"  and status not in ("MANUAL","CANCELED")');
$Wed=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$wednesday.'" and depot_id="'.$_SESSION['user']['depot'].'"  and status not in ("MANUAL","CANCELED")');
$Thu=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$thursday.'" and depot_id="'.$_SESSION['user']['depot'].'"  and status not in ("MANUAL","CANCELED")');
$Fri=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$friday.'" and depot_id="'.$_SESSION['user']['depot'].'"  and status not in ("MANUAL","CANCELED")');
$totalSales = $Sat+$Sun+$Mon+$Tue+$Wed+$Thu+$Fri;
$hSat=($Sat*100)/$totalSales;
$hSun=($Sun*100)/$totalSales;
$hMon=($Mon*100)/$totalSales;
$hTue=($Tue*100)/$totalSales;
$hWed=($Wed*100)/$totalSales;
$hThu=($Thu*100)/$totalSales;
$hFri=($Fri*100)/$totalSales;




$salesJan=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$jan_start.'" and "'.$jan_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesFeb=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$feb_start.'" and "'.$feb_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesMar=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$mar_start.'" and "'.$mar_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesApr=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$apr_start.'" and "'.$apr_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesMay=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$may_start.'" and "'.$may_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesJun=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$jun_start.'" and "'.$jun_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesJul=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$jul_start.'" and "'.$jul_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesAug=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$aug_start.'" and "'.$aug_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesSep=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$sep_start.'" and "'.$sep_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesOct=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$oct_start.'" and "'.$oct_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesNov=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$nov_start.'" and "'.$nov_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$salesDec=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$dec_start.'" and "'.$dec_end.'" and depot_id="'.$_SESSION['user']['depot'].'"');


$srJan=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$jan.'"');
$srFeb=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$feb.'"');
$srMar=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$mar.'"');
$srApr=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$apr.'"');
$srMay=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$may.'"');
$srJun=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$jun.'"');
$srJul=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$jul.'"');
$srAug=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$aug.'"');
$srSep=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$sep.'"');
$srOct=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$oct.'"');
$srNov=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$nov.'"');
$srDec=find_a_field('party_wise_sale_target','sum(target_amt)','month ="'.$dec.'"');


$res = 'select dealer_code,dealer_code as Client_id,dealer_name_e as dealer_name, contact_no, propritor_name_e as company from dealer_info where 1 order by dealer_code desc limit 5';


$thisYear = date('Y');
$lastYear = date('Y')-1;
$previousYear = date('Y')-2;

$thisYearSdate = $thisYear.'-01-01';
$thisYearEdate = $thisYear.'-12-31';
$thisYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL","CANCELED")');

$lastYearSdate = $lastYear.'-01-01';
$lastYearEdate = $lastYear.'-12-31';
$lastYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL","CANCELED")');

$preYearSdate = $previousYear.'-01-01';
$preYearEdate = $previousYear.'-12-31';
$preYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$preYearSdate.'" and "'.$preYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL","CANCELED")');

$cyear = 10;
$oyear = 25;
$ooyear = 20;





//$all_dealer[]=number_format($sales7days,2);
$all_dealer[]=number_format($sales30days,2);
//$all_dealer[]=number_format($possales7days,2);
$all_dealer[]=number_format($sale30target,2);
$all_dealer[]=number_format($thismonthsales,2);

//$all_dealer[]=number_format($localsales7days,2);
$all_dealer[]=number_format($thismonthtarget,2);
//$all_dealer[]=number_format($sales_return_value,2);

$all_dealer[]=$tSalesChart;
$all_dealer[]=$trSalesChart;


$all_dealer[]=$localSalesChart;
$all_dealer[]=$alesReturnChart;

$all_dealer[]=$hSat;
$all_dealer[]=$hSun;
$all_dealer[]=$hMon;
$all_dealer[]=$hTue;
$all_dealer[]=$hWed;
$all_dealer[]=$hThu;
$all_dealer[]=$hFri;




$all_dealer[]=$salesJan;
$all_dealer[]=$salesFeb;
$all_dealer[]=$salesMar;
$all_dealer[]=$salesApr;
$all_dealer[]=$salesMay;
$all_dealer[]=$salesJun;
$all_dealer[]=$salesJul;
$all_dealer[]=$salesAug;
$all_dealer[]=$salesSep;
$all_dealer[]=$salesOct;
$all_dealer[]=$salesNov;
$all_dealer[]=$salesDec;

$all_dealer[]=$srJan;
$all_dealer[]=$srFeb;
$all_dealer[]=$srMar;
$all_dealer[]=$srApr;
$all_dealer[]=$srMay;
$all_dealer[]=$srJun;
$all_dealer[]=$srJul;
$all_dealer[]=$srAug;
$all_dealer[]=$srSep;
$all_dealer[]=$srOct;
$all_dealer[]=$srNov;
$all_dealer[]=$srDec;

$all_dealer[]=$thisYearSales;
$all_dealer[]=$lastYearSales;
$all_dealer[]=$preYearSales;



$all_dealer[]=link_report($res);
$all_dealer[]=number_format($sales_return_value,2);
$all_dealer[]=number_format($purchase_return_value,2);
$all_dealer[]=number_format($trasfer_value,2);
$all_dealer[]=number_format($trasfer_receive_value,2);
$all_dealer[]=number_format($localSales,2);
$all_dealer[]=number_format($localPurchase,2);









echo json_encode($all_dealer);

?>



