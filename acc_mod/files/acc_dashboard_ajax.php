<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

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


$payment = find_a_field('journal','sum(cr_amt)','jv_date between "'.$last30days.'" and "'.$today.'" and tr_from="Payment"');
$receipt = find_a_field('journal','sum(dr_amt)','jv_date between "'.$last30days.'" and "'.$today.'" and tr_from="Receipt"');
$payable = find_a_field('journal','sum(cr_amt)','jv_date between "'.$last30days.'" and "'.$today.'" and tr_from in ("Purchase","Import")');
$receivable = find_a_field('journal','sum(dr_amt)','jv_date between "'.$last30days.'" and "'.$today.'" and tr_from in ("Sales")');

$asset_value = find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.ledger_id=a.ledger_id and a.acc_class=1');


$revenue_value = find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.ledger_id=a.ledger_id and a.acc_class=4');

$liability_value = find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.ledger_id=a.ledger_id and a.acc_class=3');

$expense_value = find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.ledger_id=a.ledger_id and a.acc_class=5');

$total_transaction=$asset_value+$revenue_value+$liability_value+$expense_value;
$salesChart = ($asset_value*100)/$total_transaction;
$posSalesChart = ($revenue_value*100)/$total_transaction;
$localSalesChart = ($liability_value*100)/$total_transaction;
$alesReturnChart = ($expense_value*100)/$total_transaction;

$payables = find_a_field('journal j','sum(j.cr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.tr_from in ("Purchase")');
$receivables = find_a_field('journal j','sum(j.dr_amt)','j.jv_date between "'.$last30days.'" and "'.$today.'" and j.tr_from in ("Sales")');

$sales_return_value = find_a_field('sale_return_details s, sale_return_master m','sum(s.total_amt)','m.do_date between "'.$last30days.'" and "'.$today.'" and m.depot_id="'.$_SESSION['user']['depot'].'" and m.status not in ("MANUAL","CANCELED") and s.do_no=m.do_no');

$damage = 0;

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





$transactionList = 'select tr_from as type,tr_from as type, sum(dr_amt) as amount from journal where 1 group by tr_from order by id desc limit 5';

$Sat=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$saturday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Sun=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$sunday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Mon=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$monday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Tue=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$tuesday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Wed=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$wednesday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Thu=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$thursday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Fri=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$friday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$totalSales = $Sat+$Sun+$Mon+$Tue+$Wed+$Thu+$Fri;

$hSat=($Sat*100)/$totalSales;
$hSun=($Sun*100)/$totalSales;
$hMon=($Mon*100)/$totalSales;
$hTue=($Tue*100)/$totalSales;
$hWed=($Wed*100)/$totalSales;
$hThu=($Thu*100)/$totalSales;
$hFri=($Fri*100)/$totalSales;


$thisYear = date('Y');
$lastYear = date('Y')-1;
$previousYear = date('Y')-2;

$thisYearSdate = $thisYear.'-01-01';
$thisYearEdate = $thisYear.'-12-31';
$thisYearSales = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'"');

$lastYearSdate = $lastYear.'-01-01';
$lastYearEdate = $lastYear.'-12-31';
$lastYearSales = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'"');

$preYearSdate = $previousYear.'-01-01';
$preYearEdate = $previousYear.'-12-31';
$preYearSales = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$preYearSdate.'" and "'.$preYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'"');

$cyear = 10;
$oyear = 25;
$ooyear = 20;


$total_transaction=$total_grn_value+$total_invoice_value+$total_production_value;
$oilChartValue1 = ($total_invoice_value*100)/$total_transaction;
$oilChartValue2 = ($total_grn_value*100)/$total_transaction;
$oilChartValue3 = ($total_production_value*100)/$total_transaction;


$all_dealer[]=number_format($payment,2);
$all_dealer[]=number_format($receipt,2);
$all_dealer[]=number_format($payable,2);
$all_dealer[]=number_format($receivable,2);

$all_dealer[]=$salesChart;
$all_dealer[]=$posSalesChart;
$all_dealer[]=$localSalesChart;
$all_dealer[]=$alesReturnChart;

$all_dealer[]=number_format($receivables,2);
$all_dealer[]=number_format($payables,2);

$all_dealer[]=number_format($sales_return_value,2);
$all_dealer[]=number_format($damage,2);


$all_dealer[]=$rJan;
$all_dealer[]=$rFeb;
$all_dealer[]=$rMar;
$all_dealer[]=$rApr;
$all_dealer[]=$rMay;
$all_dealer[]=$rjun;
$all_dealer[]=$rJul;
$all_dealer[]=$rAug;
$all_dealer[]=$rSept;
$all_dealer[]=$rOct;
$all_dealer[]=$rNov;
$all_dealer[]=$rDec;

$all_dealer[]=$pJan;
$all_dealer[]=$pFeb;
$all_dealer[]=$pMar;
$all_dealer[]=$pApr;
$all_dealer[]=$pMay;
$all_dealer[]=$pjun;
$all_dealer[]=$pJul;
$all_dealer[]=$pAug;
$all_dealer[]=$pSept;
$all_dealer[]=$pOct;
$all_dealer[]=$pNov;
$all_dealer[]=$pDec;

$all_dealer[]=link_report($transactionList);
$all_dealer[]=number_format($sales_return_value,2);
$all_dealer[]=number_format($purchase_return_value,2);
$all_dealer[]=number_format($trasfer_value,2);
$all_dealer[]=number_format($trasfer_receive_value,2);
$all_dealer[]=number_format($localSales,2);
$all_dealer[]=number_format($localPurchase,2);

$all_dealer[]=$hSat;
$all_dealer[]=$hSun;
$all_dealer[]=$hMon;
$all_dealer[]=$hTue;
$all_dealer[]=$hWed;
$all_dealer[]=$hThu;
$all_dealer[]=$hFri;

$all_dealer[]=$thisYearSales;
$all_dealer[]=$lastYearSales;
$all_dealer[]=$preYearSales;




echo json_encode($all_dealer);

?>



