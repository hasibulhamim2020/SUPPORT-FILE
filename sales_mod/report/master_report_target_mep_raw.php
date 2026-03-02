<?

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

date_default_timezone_set('Asia/Dhaka');


if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
		$t_date=$_POST['t_date'];
		$f_date=$_POST['f_date'];
	}
	
	
	
if($_POST['product_group']!='') $product_group=$_POST['product_group'];
if($_POST['item_brand']!='') 	$item_brand=$_POST['item_brand'];
if($_POST['item_id']>0) 		$item_id=$_POST['item_id'];
if($_POST['dealer_code']>0) 	$dealer_code=$_POST['dealer_code'];
if($_POST['dealer_type']!='') 	$dealer_type=$_POST['dealer_type'];

if($_POST['status']!='') 		$status=$_POST['status'];
if($_POST['do_no']!='') 		$do_no=$_POST['do_no'];
if($_POST['area_id']!='') 		$area_id=$_POST['area_id'];
if($_POST['zone_id']!='') 		$zone_id=$_POST['zone_id'];
if($_POST['region_id']>0) 		$region_id=$_POST['region_id'];
if($_POST['depot_id']!='') 		$depot_id=$_POST['depot_id'];

$item_con='';

if(isset($item_id))			        {$item_con.=' and i.item_id='.$item_id;}
if(isset($item_brand)) 		        {$item_con.=' and i.item_brand="'.$item_brand.'"';} 
if($_POST['group_for']>0) 	        {$item_con.=' and i.group_for="'.$_POST['group_for'].'"';}
if($_POST['item_group']>0) 	        {$item_con.=' and i.item_group="'.$_POST['item_group'].'"';}
if($_POST['category_id']>0) 	    { $category_id=$_POST['category_id']; $item_con.=' and i.category_id="'.$category_id.'"';}
if($_POST['subcategory_id']>0) 	    { $subcategory_id=$_POST['subcategory_id']; $item_con.=' and i.subcategory_id="'.$subcategory_id.'"';}


if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{

if($product_group=='ABCDE')
$pg_con=' and d.product_group!="M" and d.product_group!=""';
else
$pg_con=' and d.product_group="'.$product_group.'"';
} } 




if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($dealer_type)) 		{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';}

 
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 

	if($_POST['region_id']!='') 				$region_id=$_POST['region_id'];
	if($_POST['zone_id']!='') 				    $zone_id=$_POST['zone_id'];
	if($_POST['area_id']!='') 				    $area_id=$_POST['area_id'];

$location='';
if(isset($region_id)) 			{$location.=' and d.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$location.=' and d.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$location.=' and d.area_code="'.$area_id.'"';}

$locationt='';
if(isset($region_id)) 			{$locationt.=' and t.region_id="'.$region_id.'"';}
if(isset($zone_id)) 			{$locationt.=' and t.zone_id="'.$zone_id.'"';}
if(isset($area_id)) 			{$locationt.=' and t.area_id="'.$area_id.'"';}


if($_POST['year']>0) {
    $date_con=' and target_year="'.$_POST['year'].'" and target_month="'.$_POST['month'].'"';
}






switch ($_POST['report']) {


case 1:
$report='Territory Wise Target Report';
report_log('Sales', 'master_report_target', 1, $report);
    
break;    


case 2:
$report='Dealer Wise Target Ratio';
report_log('Sales', 'master_report_target', 2, $report);

if(isset($dealer_code)) { $dealer_con=' and t.dealer_code="'.$dealer_code.'"';}
    
$sql="select t.target_year,t.target_month,a.AREA_CODE,a.AREA_NAME,t.dealer_code,t.dealer_name,t.dealer_ratio,t.policy_no
    from sale_target_dealer_ratio t, area a
    where a.AREA_CODE=t.area_id 
    ".$date_con.$locationt.$dealer_con."
    order by a.ZONE_ID,a.AREA_CODE,t.dealer_code
";    
break; 





case 3:
$report='Dealer Wise Target Qty';
report_log('Sales', 'master_report_target', 3, $report);
    
break; 



case 4:
$report='FO Wise Target Ratio';
report_log('Sales', 'master_report_target', 4, $report);

    
$sql="select t.target_year,t.target_month,t.dealer_code,t.so_code,t.policy_no,t.so_ratio,t.so_com_id,t.so_group_list
    from sale_target_so_per t
    where 1
    ".$date_con."
    order by t.dealer_code,t.so_code
    ";    
break; 


case 5:
$report='FO Wise Target Qty';
report_log('Sales', 'master_report_target', 5, $report);


if($_POST['so_code']){ $so_con=' and t.so_code="'.$_POST['so_code'].'"'; }
    
break; 


case 6:
$report='Product Wise Target';
report_log('Sales', 'master_report_target', 6, $report);

if($_POST['so_code']){ $so_con=' and t.so_code="'.$_POST['so_code'].'"'; }
    
break; 


case 15:
$report='Check Target Qty';
report_log('Sales', 'master_report_target', 15, $report);

if($_POST['so_code']){ $so_con=' and t.so_code="'.$_POST['so_code'].'"'; }
    
break;


case 16:
$report='Dealer vs FO qty Check';
report_log('Sales', 'master_report_target', 16, $report);

break;



}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../../assets/css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
    <style type="text/css" media="print">
      div.page
      {
        page-break-after: always;
        page-break-inside: avoid;
      }
    </style>
	<style type="text/css">
.vertical-text {
	transform: rotate(270deg);
	transform-origin: left top 1;
	float:left;
	width:2px;
	padding:1px;
	font-size:14px;
	font-family:Arial, Helvetica, sans-serif;
}
th {
vertical-align:bottom;
text-align:center;
}
.style1 {color: #FFFFFF}
    </style>
</head>
<body>
<!--<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>-->




<div class="main">
<?
		$str 	.= '<div class="header">';
		//if(isset($_SESSION['company_name'])) $str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($item_id)) 
		$str 	.= '<h2>'.find_a_field('item_info','item_name','item_id='.$item_id).'</h2>';
		if(isset($dealer_code)) 
		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';
		if(isset($to_date)) $str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
		
		if(isset($_POST['year'])) $str 	.= '<h2>Year : '.$_POST['year'].' Month: '.$_POST['month'].'</h2>';
		
		if($_POST['cut_date']!='') 
		$str 	.= '<h2>Cut Off Date : '.$_POST['cut_date'].'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
		if(isset($dealer_type)) 
		$str 	.= '<h2>Dealer Type : '.$dealer_type.'</h2>';
		$str 	.= '</div>';
		$str 	.= '<div class="left" style="width:100%">';

//		if(isset($allotment_no)) 
//		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
//		$str 	.= '</div><div class="right">';
//		if(isset($client_name)) 
//		$str 	.= '<p>Dealer Name: '.$dealer_name.'</p>';
//		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';




if($_REQUEST['report']==1) { 
 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
?>

<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div>
<div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?>.</div></td>
</tr>

<tr>
  <th>SL</th>
  <th>Target Year</th>
  <th>Target Month</th>
  <th>Territory ID</th>
  <th>Territory Name</th>
  <th>Item ID</th>
  <th>Item Name</th>
  <th>Target Qty</th>
</tr>
</thead><tbody>
<? 
$sql="select t.target_year,t.target_month,a.AREA_CODE,a.AREA_NAME,t.item_id,i.finish_goods_code,i.item_name,t.target_qty
from sale_target_area t,area a, item_info i
where a.AREA_CODE=t.area_id and i.item_id=t.item_id
".$date_con.$locationt."
order by a.ZONE_ID,a.AREA_NAME,i.group_for,i.item_id
"; 
$query = mysql_query($sql);
$sl=1;
while($data = mysql_fetch_object($query)){    
?> 
<tr>
    <td><?=$sl++?></td>
    <td><?=$data->target_year;?></td>
    <td><?=$data->target_month;?></td>
    <td><?=$data->AREA_CODE;?></td>
    <td><?=$data->AREA_NAME;?></td>
    <td><?=$data->finish_goods_code;?></td>
    <td><?=$data->item_name;?></td>
    <td><?=$data->target_qty; $gqty+=$data->target_qty;?></td>
</tr>    
<? } ?>
   <tr>
       <td colspan="7" style="text-align: right;"><strong>Total</strong></td>
       <td><strong><?=$gqty;?></strong></td>
   </tr> 
    
<? }



elseif($_REQUEST['report']==3) {
    
if($_POST['region_id']==''){ die("Please select Zone");}
 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($dealer_code)) { $dealer_con=' and d.dealer_code="'.$dealer_code.'"';}

?>

<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div>
<div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?>.</div></td>
</tr>

<tr>
  <th>SL</th>
  <th>Target Year</th><th>Target Month</th>
  <th>Zone ID</th><th>Division ID</th><th>Territory ID</th>
  <th>Dealer ID</th><th>Dealer Code</th><th>Dealer Name</th>
  <th>Item ID</th><th>Item Name</th>
  <th>Target Qty</th>
</tr>
</thead><tbody>
<? 
$sql="select t.target_year,t.target_month,t.region_id,t.zone_id,t.area_id,t.dealer_code,d.dealer_code2,d.dealer_name_e as dealer_name,t.item_id,i.finish_goods_code,i.item_name,t.target_ctn as target_qty
    from sale_target_upload t, item_info i, dealer_info d
    where d.dealer_code=t.dealer_code and i.item_id=t.item_id and t.region_id='".$_POST['region_id']."'
    ".$date_con.$dealer_con.$locationt.$item_con."
    order by t.region_id,t.zone_id,t.area_id,t.dealer_code,i.group_for,i.item_id
    "; 
$query = mysql_query($sql);
$sl=1;
while($data = mysql_fetch_object($query)){    
?> 
<tr>
    <td><?=$sl++?></td>
    <td><?=$data->target_year;?></td>
    <td><?=$data->target_month;?></td>
    <td><?=$data->region_id;?></td>
    <td><?=$data->zone_id;?></td>
    <td><?=$data->area_id;?></td>
    <td><?=$data->dealer_code;?></td><td><?=$data->dealer_code2;?></td>
    <td><?=$data->dealer_name;?></td>
    <td><?=$data->finish_goods_code;?></td>
    <td><?=$data->item_name;?></td>
    <td><?=$data->target_qty; $gqty+=$data->target_qty;?></td>
</tr>    
<? } ?>
   <tr>
       <td colspan="11" style="text-align: right;"><strong>Total</strong></td>
       <td><strong><?=$gqty;?></strong></td>
   </tr> 
    
<? }




elseif($_REQUEST['report']==5) {
    
 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($dealer_code)) { $dealer_con=' and d.dealer_code="'.$dealer_code.'"';}
?>

<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div>
<div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?>.</div></td>
</tr>

<tr>
  <th>SL</th>
  <th>Target Year</th>
  <th>Target Month</th>
  <th>Dealer Code</th>
  <th>FO Code</th>
  <th>Item ID</th>
  <th>Item Name</th>
  <th>Target Qty</th>
</tr>
</thead><tbody>
<? 
$sql="select t.target_year,t.target_month,t.dealer_code,t.so_code as fo_code,t.item_id,i.finish_goods_code,i.item_name,t.target_qty
    from sale_target_so t, item_info i, dealer_info d
    where d.dealer_code=t.dealer_code and i.item_id=t.item_id 
    ".$date_con.$dealer_con.$so_con.$item_con."
    order by t.dealer_code,t.so_code,i.group_for,i.item_id
    "; 
$query = mysql_query($sql);
$sl=1;
while($data = mysql_fetch_object($query)){    
?> 
<tr>
    <td><?=$sl++?></td>
    <td><?=$data->target_year;?></td>
    <td><?=$data->target_month;?></td>
    <td><?=$data->dealer_code;?></td>
    <td><?=$data->fo_code;?></td>
    <td><?=$data->finish_goods_code;?></td>
    <td><?=$data->item_name;?></td>
    <td><?=$data->target_qty; $gqty+=$data->target_qty;?></td>
</tr>    
<? } ?>
   <tr>
       <td colspan="7" style="text-align: right;"><strong>Total</strong></td>
       <td><strong><?=$gqty;?></strong></td>
   </tr> 
    
<? }


elseif($_REQUEST['report']==6) {
    
 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($dealer_code)) { $dealer_con=' and d.dealer_code="'.$dealer_code.'"';}
?>

<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div>
<div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?>.</div></td>
</tr>

<tr>
  <th>SL</th>
  <th>Target Year</th>
  <th>Target Month</th>
  <th>FG Code</th>
  <th>Item ID</th>
  <th>Item Name</th>
  <th>Target Qty</th>
  <th>Target Amount</th>
</tr>
</thead><tbody>
<? 
$sql="select t.target_year,t.target_month,t.item_id,i.finish_goods_code,i.item_name,sum(t.target_qty) as target_qty,sum(t.target_amt) as amount
    from sale_target_so t, item_info i, dealer_info d
    where d.dealer_code=t.dealer_code and i.item_id=t.item_id 
    ".$date_con.$dealer_con.$so_con."
    group by t.item_id order by i.group_for,i.item_id
    "; 
$query = mysql_query($sql);
$sl=1;
while($data = mysql_fetch_object($query)){    
?> 
<tr>
    <td><?=$sl++?></td>
    <td><?=$data->target_year;?></td>
    <td><?=$data->target_month;?></td>
    <td><?=$data->finish_goods_code;?></td>
    <td><?=$data->item_id;?></td>
    <td><?=$data->item_name;?></td>
    <td><?=$data->target_qty; $gqty+=$data->target_qty;?></td>
    <td><?=$data->amount; $gamt+=$data->amount;?></td>
</tr>    
<? } ?>
   <tr>
       <td colspan="6" style="text-align: right;"><strong>Total</strong></td>
       <td><strong><?=$gqty;?></strong></td>
       <td><strong><?=$gamt;?></strong></td>
   </tr> 
    
<? }


elseif($_REQUEST['report']==15) {
    
 
if(isset($t_date)) {
    $to_date=$t_date; $fr_date=$f_date; 
    $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';
}
?>

<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div>
<div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?>.</div></td>
</tr>

<tr>
  <th>Target Year</th>
  <th>Target Month</th>
  <th>Territory Qty</th>
  <th>Dealer Qty</th>
  <th>FO Qty</th>
</tr>
</thead><tbody>
<tr>
    <td><?=$_POST['year'];?></td>
    <td><?=$_POST['month'];?></td>
<td>
<? 
echo find1("select sum(t.target_qty) from sale_target_area t, item_info i 
where i.item_id=t.item_id 
".$date_con."
"); 
?>     
</td>

<td>
<? 
echo find1("select sum(t.target_ctn)
from sale_target_upload t, item_info i 
where i.item_id=t.item_id 
".$date_con."
"); 
?>     
</td>

<td>
<? 
echo find1("select sum(t.target_qty)
from sale_target_so t, item_info i 
where i.item_id=t.item_id 
".$date_con."
"); 
?>     
</td>

</tr>    

<? }




elseif($_REQUEST['report']==16) {
    
if(isset($dealer_code)) { $dealer_con=' and d.dealer_code="'.$dealer_code.'"';}

// fo target qty dealer wise
$sql2="SELECT dealer_code,sum(target_qty) as qty , sum(target_amt) as amt
FROM sale_target_so
WHERE target_year='".$_POST['year']."' and target_month='".$_POST['month']."' group by dealer_code";
$query2=mysql_query($sql2);
while($info=mysql_fetch_object($query2)){
    $so_qty[$info->dealer_code]=$info->qty;
    $so_amt[$info->dealer_code]=$info->amt;
}


?>

<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr>
<td style="border:0px;" colspan="12"><?=$str?><div class="left"></div>
<div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?>.</div></td>
</tr>

<tr>
  <th>SL</th>
  <th>Target Year</th>
  <th>Target Month</th>
  <th>Dealer Code</th>
  <th>Dealer Target Qty</th><th>Dealer Target Amt</th>
  <th>FO Target Qty</th><th>FO Target Amt</th>
  <th>Gap Qty</th><th>Gap Amt</th>
</tr>
</thead><tbody>
<? 
$sql="SELECT target_year,target_month,dealer_code,sum(target_ctn) as dealer_qty , sum(target_amount) as target_amount 
FROM sale_target_upload 
WHERE 1
".$date_con.$dealer_con."
group by dealer_code
";
$query = mysql_query($sql);
$sl=1;
while($data = mysql_fetch_object($query)){    
?> 
<tr>
    <td><?=$sl++?></td>
    <td><?=$data->target_year;?></td>
    <td><?=$data->target_month;?></td>
    <td><?=$data->dealer_code;?></td>
    <td><?=$data->dealer_qty; $gd+=$data->dealer_qty;?></td>
    <td><?=$data->target_amount; $gdm+=$data->target_amount;?></td>
    <td><?=$so_qty[$data->dealer_code]; $gs+=$so_qty[$data->dealer_code];?></td>
    <td><?=$so_amt[$data->dealer_code]; $gsm+=$so_amt[$data->dealer_code];?></td>
    <td><?=$gap=($data->dealer_qty-$so_qty[$data->dealer_code]); $tgap+=$gap;?></td>
    <td><?=(int)$gapt=($data->target_amount-$so_amt[$data->dealer_code]); $tgapt+=$gapt;?></td>
</tr>    
<? } ?>
   <tr>
       <td colspan="4" style="text-align: right;"><strong>Total</strong></td>
       <td><strong><?=$gd;?></strong></td><td><strong><?=$gdm;?></strong></td>
       <td><strong><?=$gs;?></strong></td><td><strong><?=$gsm;?></strong></td>
       <td><strong><?=$tgap;?></strong></td>
       <td><strong><?=$tgapt;?></strong></td>
   </tr> 
    
<? }




elseif($_REQUEST['report']==7031) { 

if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) {$depot_con=' and w.warehouse_id="'.$depot_id.'"';} 


$sql='
SELECT a.item_id,a.tr_from,
sum(a.item_ex-a.item_in) as qty,
sum((a.item_ex-a.item_in)*a.item_price) as amount

FROM  journal_item a,item_info i , warehouse w
where
a.warehouse_id=w.warehouse_id
and a.item_id=i.item_id
and i.finish_goods_code >99
and i.finish_goods_code not between 2000 and 2010
and w.group_for=2
and a.tr_from in ("Bulk Sales","Staff Sales","Other Sales","Gift Issue","Entertainment Issue","Sample Issue","Other Issue")
'.$date_con.''.$depot_con.'
group by a.item_id,a.tr_from ';


$query = mysql_query($sql);
while($info = mysql_fetch_object($query)){
$all_sales_amt[$info->item_id][$info->tr_from] = $info->amount;
$all_sales_pcs[$info->item_id][$info->tr_from] = $info->qty;
}
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) {$depot_con1=' and depot_id="'.$depot_id.'"';} 
$mi = 0;
$sql='select distinct chalan_no ch from sale_do_chalan 
where 1 '.$depot_con1.' and chalan_date between "'.$fr_date.'" and "'.$to_date.'" ';
// chalan_type = "Delivery" and

$query = mysql_query($sql);
while($info = mysql_fetch_object($query)){
if($mi==0)
$ch = '"'.$info->ch.'"';
else
$ch .= ',"'.$info->ch.'"'; $mi++;
}

$sql='
SELECT a.item_id,
sum(a.item_ex-a.item_in) as qty,
sum((a.item_ex-a.item_in)*a.item_price) as amount
FROM  journal_item a,item_info i , warehouse w
where
a.sr_no in ('.$ch.')
and a.warehouse_id=w.warehouse_id
and a.item_id=i.item_id
and i.finish_goods_code >99
and i.finish_goods_code not between 2000 and 2010
and w.group_for=2
and a.tr_from in ("Sales","SalesReturn")
'.$depot_con.'
group by a.item_id ';

$query = mysql_query($sql);
while($info = mysql_fetch_object($query)){
$all_chalan_amt[$info->item_id] = $info->amount;
$all_chalan_pcs[$info->item_id] = $info->qty;
}

//if(isset($product_group)) 		{$pg_con=' and i.sales_item_type like "%'.$product_group.'%"';}

$sql = 'select 
i.finish_goods_code as code, i.item_id, 
i.item_name, i.item_brand,i.pack_size,i.sales_item_type
from item_info i
where 
i.finish_goods_code >99
and i.finish_goods_code not between 2000 and 2010 '.$item_con.'
group by i.finish_goods_code';
?>
<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">
<thead>
<tr>
<td colspan="34" style="border:0px;"><?=$str?>
<br>
<?php if(isset($depot_id)){ 
echo $warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['depot_id']);
} else {
echo "";
} 
?>
<br>
<?php //echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>'; ?></td></tr>
<tr>
	<th height="20" rowspan="2">S/Ls</th>
	<th rowspan="2">Item Id</th>
	<th rowspan="2">Code</th>
	<th rowspan="2">Item Name</th>
	<th rowspan="2">Brand</th>
	<th rowspan="2">Group</th>
	<th colspan="3">Sales</th>
	<th colspan="3">Bulk Sales</th>
	<th colspan="3">Staff Sales</th>
	<th colspan="3">Other Sales</th>
	<th colspan="3">Gift Issue</th>
	<th colspan="3">Entertainment Issue</th>
	<th colspan="3">Sample Issue</th>
	<th colspan="3">Sales</th>
	<th colspan="3">Sales</th>
	<th colspan="3">Total Sales </th>
	</tr>
<tr>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
  <th>CTN</th>
  <th>Pcs</th>
  <th>Amt</th>
</tr>
</thead>
<tbody>

<?
$query = mysql_query($sql);
while($info = mysql_fetch_object($query)){

// only sales chalan summation
//$total_amt = $all_chalan_amt[$info->item_id];
//$total_qty = $all_chalan_pcs[$info->item_id];


// this is without other sales amount
//$total_amt = $all_sales_amt[$info->item_id];
//$total_qty = $all_sales_pcs[$info->item_id];


// this is whole sales summation
//$total_amt = $all_sales_amt[$info->item_id] + $all_chalan_amt[$info->item_id];
//$total_qty = $all_sales_pcs[$info->item_id] + $all_chalan_pcs[$info->item_id];


//$total_qty_pcs = floor($total_qty/$info->pack_size);
//$total_qty_ctn = floor($total_qty%$info->pack_size);
//
//$t_total_qty_pcs = $t_total_qty_pcs + $total_qty_pcs;
//$t_total_qty_ctn = $t_total_qty_ctn + $total_qty_ctn;
//$t_total_amt = $t_total_amt + $total_amt;
//if($total_qty>0){
?>

<tr>
    <td><?=++$i;?></td>
    <td><?=$info->item_id;?></td>
    <td><?=$info->code;?></td>
    <td><?=$info->item_name;?></td>
	<td><?=$info->item_brand;?></td>
	<td><span style="text-align:right"><?=$total_qty_pcs?></span></td>
	<? 
	$total_item_sales_amt = 0;
	$total_item_sales_pcs = 0;
	$tr_from = '"Dealer Sales","Sales Return"';
$total_item_sales_amt = $total_item_sales_amt + $all_chalan_amt[$info->item_id];
$total_item_sales_pcs = $total_item_sales_pcs + $all_chalan_pcs[$info->item_id];
	
$sales_pcs1 = $sales_pcs1 +floor($all_chalan_pcs[$info->item_id]/$info->pack_size);
$sales_ctn1 = $sales_ctn1 +floor($all_chalan_pcs[$info->item_id]%$info->pack_size);
$sales_amt1 = $sales_amt1 +$all_chalan_amt[$info->item_id];
	?>

	<td style="text-align:right"><?=floor($all_chalan_pcs[$info->item_id]/$info->pack_size);?></td>
	<td style="text-align:right"><?=floor($all_chalan_pcs[$info->item_id]%$info->pack_size);?></td>
	<td style="text-align:right"><?=number_format($all_chalan_amt[$info->item_id],0)?></td>
	<? $tr_from = 'Bulk Sales';
	$total_item_sales_amt = $total_item_sales_amt + $all_sales_amt[$info->item_id][$tr_from];
	$total_item_sales_pcs = $total_item_sales_pcs + $all_sales_pcs[$info->item_id][$tr_from];
	
$sales_pcs2 = $sales_pcs2 +floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);
$sales_ctn2 = $sales_ctn2 +floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);
$sales_amt2 = $sales_amt2 +$all_sales_amt[$info->item_id][$tr_from];
	?>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);?></td>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);?></td>
	<td style="text-align:right"><?=number_format($all_sales_amt[$info->item_id][$tr_from],0)?></td>
	<? $tr_from = 'Staff Sales';
	$total_item_sales_amt = $total_item_sales_amt + $all_sales_amt[$info->item_id][$tr_from];
	$total_item_sales_pcs = $total_item_sales_pcs + $all_sales_pcs[$info->item_id][$tr_from];
	
$sales_pcs3 = $sales_pcs3 +floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);
$sales_ctn3 = $sales_ctn3 +floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);
$sales_amt3 = $sales_amt3 +$all_sales_amt[$info->item_id][$tr_from];
	?>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);?></td>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);?></td>
	<td style="text-align:right"><?=number_format($all_sales_amt[$info->item_id][$tr_from],0)?></td>
	<? $tr_from = 'Other Sales';
	$total_item_sales_amt = $total_item_sales_amt + $all_sales_amt[$info->item_id][$tr_from];
	$total_item_sales_pcs = $total_item_sales_pcs + $all_sales_pcs[$info->item_id][$tr_from];
	
$sales_pcs4 = $sales_pcs4 +floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);
$sales_ctn4 = $sales_ctn4 +floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);
$sales_amt4 = $sales_amt4 +$all_sales_amt[$info->item_id][$tr_from];
	?>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);?></td>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);?></td>
	<td style="text-align:right"><?=number_format($all_sales_amt[$info->item_id][$tr_from],0)?></td>
	<? $tr_from = 'Gift Issue';
	$total_item_sales_amt = $total_item_sales_amt + $all_sales_amt[$info->item_id][$tr_from];
	$total_item_sales_pcs = $total_item_sales_pcs + $all_sales_pcs[$info->item_id][$tr_from];
	
$sales_pcs5 = $sales_pcs5 +floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);
$sales_ctn5 = $sales_ctn5 +floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);
$sales_amt5 = $sales_amt5 +$all_sales_amt[$info->item_id][$tr_from];
	?>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);?></td>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);?></td>
	<td style="text-align:right"><?=number_format($all_sales_amt[$info->item_id][$tr_from],0)?></td>
	<? $tr_from = 'Entertainment Issue';
	$total_item_sales_amt = $total_item_sales_amt + $all_sales_amt[$info->item_id][$tr_from];
	$total_item_sales_pcs = $total_item_sales_pcs + $all_sales_pcs[$info->item_id][$tr_from];
	
$sales_pcs6 = $sales_pcs6 +floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);
$sales_ctn6 = $sales_ctn6 +floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);
$sales_amt6 = $sales_amt6 +$all_sales_amt[$info->item_id][$tr_from];
	?>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);?></td>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);?></td>
	<td style="text-align:right"><?=number_format($all_sales_amt[$info->item_id][$tr_from],0)?></td>
	
	<? $tr_from = 'Sample Issue';
	$total_item_sales_amt = $total_item_sales_amt + $all_sales_amt[$info->item_id][$tr_from];
	$total_item_sales_pcs = $total_item_sales_pcs + $all_sales_pcs[$info->item_id][$tr_from];
	
$sales_pcs7 = $sales_pcs7 +floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);
$sales_ctn7 = $sales_ctn7 +floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);
$sales_amt7 = $sales_amt7 +$all_sales_amt[$info->item_id][$tr_from];
	?>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]/$info->pack_size);?></td>
	<td style="text-align:right"><?=floor($all_sales_pcs[$info->item_id][$tr_from]%$info->pack_size);?></td>
	<td style="text-align:right"><?=number_format($all_sales_amt[$info->item_id][$tr_from],0)?></td>
	
	<td style="text-align:right">&nbsp;</td>
	<td style="text-align:right">&nbsp;</td>
	<td style="text-align:right">&nbsp;</td>
	<td style="text-align:right">&nbsp;</td>
	<td style="text-align:right">&nbsp;</td>
	<td style="text-align:right">&nbsp;</td>

<?
$sales_pcs00 = $sales_pcs00 + floor($total_item_sales_pcs /$info->pack_size);
$sales_ctn00 = $sales_ctn00 + floor($total_item_sales_pcs %$info->pack_size);
$sales_amt00 = $sales_amt00 + $total_item_sales_amt;
?>
	
	<td style="text-align:right"><?=floor($total_item_sales_pcs /$info->pack_size);?></td>
	<td style="text-align:right"><?=floor($total_item_sales_pcs %$info->pack_size);?></td>
	<td style="text-align:right"><?=number_format($total_item_sales_amt,0)?></td>
</tr>
<?
//}
}
?>
<tr>
    <td>Total</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>

    <td style="text-align:right"><?=$sales_pcs1?></td>
    <td style="text-align:right"><?=$sales_ctn1?></td>
    <td style="text-align:right"><?=number_format($sales_amt1,0)?></td>
    <td style="text-align:right"><?=$sales_pcs2?></td>
    <td style="text-align:right"><?=$sales_ctn2?></td>
    <td style="text-align:right"><?=number_format($sales_amt2,0)?></td>
    <td style="text-align:right"><?=$sales_pcs3?></td>
    <td style="text-align:right"><?=$sales_ctn3?></td>
    <td style="text-align:right"><?=number_format($sales_amt3,0)?></td>
    <td style="text-align:right"><?=$sales_pcs4?></td>
    <td style="text-align:right"><?=$sales_ctn4?></td>
    <td style="text-align:right"><?=number_format($sales_amt4,0)?></td>
    <td style="text-align:right"><?=$sales_pcs5?></td>
    <td style="text-align:right"><?=$sales_ctn5?></td>
    <td style="text-align:right"><?=number_format($sales_amt5,0)?></td>
    <td style="text-align:right"><?=$sales_pcs6?></td>
    <td style="text-align:right"><?=$sales_ctn6?></td>
    <td style="text-align:right"><?=number_format($sales_amt6,0)?></td>
    <td style="text-align:right"><?=$sales_pcs7?></td>
    <td style="text-align:right"><?=$sales_ctn7?></td>
    <td style="text-align:right"><?=number_format($sales_amt7,0)?></td>
    <td style="text-align:right">&nbsp;</td>
    <td style="text-align:right">&nbsp;</td>
    <td style="text-align:right">&nbsp;</td>
    <td style="text-align:right">&nbsp;</td>
    <td style="text-align:right">&nbsp;</td>
    <td style="text-align:right">&nbsp;</td>
    <td style="text-align:right"><?=$sales_pcs00?></td>
    <td style="text-align:right"><?=$sales_ctn00?></td>
    <td style="text-align:right"><?=number_format($sales_amt00,0)?></td></tr>
</tbody></table>
<?
//$str = '';


}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?></div>
</body>
</html>