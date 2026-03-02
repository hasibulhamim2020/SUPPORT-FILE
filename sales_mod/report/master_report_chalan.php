<?



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$c_id = $_SESSION['proj_id'];

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

if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
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

if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 

//if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
// 
//if(isset($zone_id)) 			{$zone_con=' and a.buyer_id='.$zone_id;}
//if(isset($region_id)) 		{$region_con=' and d.id='.$region_id;}
//if(isset($item_id)) 			{$item_con=' and b.item_id='.$item_id;} 
//if(isset($status)) 			{$status_con=' and a.status="'.$status.'"';} 
//if(isset($do_no)) 			{$do_no_con=' and a.do_no="'.$do_no.'"';} 
//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $chalan_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

switch ($_POST['report']) {

case 7031: // 3.Item Wise Sales Report(SAJEEB)
$report="Item Wise Sales Report Details";


if(isset($tr_from)) {$tr_from_con=' and a.tr_from in ("'.$tr_from.'")';}
else {$tr_from_con= ' and a.tr_from in ("Sales","SalesReturn","Bulk Sales","Staff Sales","Other Sales","Gift Issue","Entertainment Issue","Sample Issue","Other Issue")';}

// "Sales","SalesReturn","Bulk Sales","Staff Sales","Other Sales","Gift Issue","Entertainment Issue","Sample Issue","Other Issue"

if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 		{$depot_id_con=' and a.warehouse_id="'.$depot_id.'"';}
break;


	case 40:
		$report="Head Office Shop Stock Report"; 
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		break;
		
		case 72:
		$report="Customer Due Report";	
break;


case 73:
		$report="Collection Report";	
break;



case 2024211:
		$report="Product Wise Sales Analysis Report";	
break;


case 402:

    $report="Party Ledger Report";

    //report_log('Sales', 'master_report_chalan', 402, $report);

break;

case 404:

    $report="Party Receivable Report";

    //report_log('Sales', 'master_report_chalan', 402, $report);

break;


case 15051:

    $report="Product Wise Monthly Sales Report(Amount only)";

break;

case 150519:

    $report="Product Wise Monthly Sales Report(Amount only)";

break;


case 1505191:

    $report="Product Category Wise Sales(Pcs)";

break;



case 15051911:

    $report="Product Category Wise Sales(Ctn))";

break;


case 116:
$report="Single Item Sales Report(Zone Wise)";


case 1:
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$report="Delivery Chalan Summary Report";
		break;
		

case 15:
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$report="Delivery Chalan Summary Brief";
		break;
		
case 10101:
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$report="Delivery Chalan Adjustment Summary Brief";
		break;
case 10001:
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$report="Item Wise Chalan  Details Report (Chalan Date Wise)";
		break;
case 10002:
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$report="Item Wise Chalan  Details Report (DO Date Wise)";
		break;
case 101:
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and  m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$report="Delivery Order wise Chalan Summary Brief";
		break;
case 19921:
$report="Sales Statement(As Per CH)";

break;
	
case 2000:
$report="Chalan Summery Report Region Wise";
break;	
	
	case 2002:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 
$report="Party Sales Report (Region Wise)";
	break;

case 601:
$report="Check Free Goods Vs Accounts";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; 
	$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

$sql = "SELECT c.chalan_no, sum(c.total_unit * d.dp_price) as sales_amount, j.dr_amt
FROM sale_do_chalan c, sale_do_details d, item_info i, journal j
WHERE c.unit_price =0 AND i.finish_goods_code not between 5000 and 6000
AND d.id = c.order_no
AND i.item_id = d.item_id
AND j.tr_from = 'Sales' and j.tr_no=c.chalan_no AND j.ledger_id='4014000800020000'
".$date_con."
GROUP BY c.chalan_no";

break;




case 602:
$report="Check CP Vs Accounts";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; 
	$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

$sql = "SELECT c.chalan_no, sum(c.total_unit * d.dp_price) as sales_amount, j.dr_amt
FROM sale_do_chalan c, sale_do_details d, item_info i, journal j
WHERE c.unit_price =0 
AND i.finish_goods_code between 5000 and 6000
AND d.id = c.order_no
AND i.item_id = d.item_id
AND j.tr_from = 'Sales' and j.tr_no=c.chalan_no 
AND j.ledger_id='4014000200010000'
".$date_con."
GROUP BY c.chalan_no";

break;


case 603:
$report="Check Cash Dis Vs Accounts";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; 
	$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

$sql = "SELECT c.chalan_no, sum(c.total_unit * c.unit_price*-1) as discount_amount, j.dr_amt
FROM sale_do_chalan c, item_info i, journal j
WHERE 
i.finish_goods_code between 2001 and 2003
AND j.tr_no=c.chalan_no 
AND i.item_id=c.item_id
AND j.tr_from = 'Sales' 
AND j.ledger_id='4014000800010000'

".$date_con."
GROUP BY c.chalan_no";

break;




case 2:
		$report="Item Wise Chalan Details Report";

	break;
	
case 201:
		$report="Item Wise Chalan  Details Report (At A Glance)";
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		if(isset($depot_id)) 			{$con.=' and a.depot_id="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		
		if(isset($dealer_type)){
		if($dealer_type=='MordernTrade'){
		$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';
		}elseif($dealer_type=='Super_Mgroup'){
		$dealer_type_con = ' and ( d.dealer_type="SuperShop" or  d.product_group="M") ';
		}else {$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}
		}
if(isset($region_id)) 	{$region_con=' and d.region_id='.$region_id;}
if(isset($zone_id)) 	{$zone_con=' and d.zone_id='.$zone_id;}		
		
$sql='select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,i.sales_item_type,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*m.dp_price) as DP,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*m.dp_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		where d.dealer_code=m.dealer_code and m.id=a.order_no  
		and a.unit_price>0
		and a.item_id!=1096000100010312
		and a.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$pg_con.$dealer_type_con.$region_con.$zone_con.' 
	group by a.item_id order by i.finish_goods_code';
	
$sql2='select 
		i.finish_goods_code as fg,
		m.gift_on_item as item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*m.dp_price) as DP,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*m.dp_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		
		where d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   
	a.item_id = 1096000100010312 and m.gift_on_item=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$pg_con.$dealer_type_con.$region_con.$zone_con.' 
	group by  m.gift_on_item order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$citem[$data2->item_id] = $data2->sale_price*$data2->qty;
	$citempkt[$data2->item_id] = $data2->pkt;
	$citempcs[$data2->item_id] = $data2->pcs;
	$citemqty[$data2->item_id] = $data2->qty;
	}
	$sql2='select 

		m.item_id as item_id,

		sum(a.total_unit*m.dp_price) as free,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*m.dp_price) as free,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		
		where m.item_id=m.gift_on_item and m.item_id=i.item_id and d.dealer_code=m.dealer_code and m.id=a.order_no  and   
	a.unit_price = 0  '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$pg_con.$dealer_type_con.$region_con.$zone_con.' 
	group by  m.gift_on_item order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$ditem[$data2->item_id] = $data2->free;
	$ditempkt[$data2->item_id] = $data2->pkt;
	$ditempcs[$data2->item_id] = $data2->pcs;
	$ditemqty[$data2->item_id] = $data2->qty;
	}
		$sql2='select 
		i.finish_goods_code as fg,
		m.gift_on_item as item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		if(m.dp_price>0,m.dp_price,m.fp_price) price,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*m.dp_price) as DP,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*m.dp_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		
		where m.gift_on_item!=i.item_id and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   
	a.unit_price = 0 and m.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$pg_con.$dealer_type_con.$region_con.$zone_con.' 
	group by  m.gift_on_item order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$pitem[$data2->item_id] = $data2->price*$data2->qty;
	$pitempkt[$data2->item_id] = $data2->pkt;
	$pitempcs[$data2->item_id] = $data2->pcs;
	$pitemqty[$data2->item_id] = $data2->qty;
	}
	break;


case 2001:
		$report="Item Wise Chalan  Details Report (At A Glance)";
		
	break;
	
	
	
	
	case 3:
$report="Delivered Chalan Report (Chalan Wise)";
if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($dealer_code)) {$dealer_con=' and m.dealer_code='.$dealer_code;} 
if(isset($item_id)){$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) {$depot_con=' and d.depot="'.$depot_id.'"';} 
	break;
	case 6:
	if($_REQUEST['chalan_no']>0)
header("Location:../../../warehouse_mod/pages/wo/delivery_challan_print_view.php?v_no=".$_REQUEST['chalan_no']);
	break;
	case 5:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 
$report="Delivery Order Brief Report (Region Wise)";
	break;
	    case 7:
		$report="Item wise DO Report";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 

$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,i.item_brand,i.sales_item_type as `group`,
floor(sum(o.total_unit)/o.pkt_size) as crt,
mod(sum(o.total_unit),o.pkt_size) as pcs, 
sum(o.total_amt)as dP,
sum(o.total_unit*o.t_price)as tP
from 
sale_do_master m,sale_do_details o, item_info i,dealer_info d
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';
	break;
		case 8:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 
$report="Dealer Performance Report";
	    case 9:
		$report="Item Report (Region Wise)";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 
		break;
		
		case 10:
		$report="Daily Collection Summary";
		
$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 
sale_do_master m,dealer_info d  , warehouse w
where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
		
		case 11:
		$report="Daily Collection &amp; Order Summary";
		
$sql="select m.do_no, m.do_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from 
sale_do_master m,dealer_info d  , warehouse w 
where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
				case 13:
		$report="Daily Collection Summary(EXT)";
		
$sql="select m.do_no,m.do_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 
sale_do_master m,dealer_info d  , warehouse w
where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
    
	
	case 111:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$report="Corporate Chalan Summary Brief";
	break;
	    
		
		
case 112:
$report="SuperShop Chalan Summary Brief";
break;
	
	    case 1004:
		$report="Warehouse Stock Position Report(Closing)";
		break;
		
case 1007:
		$report="Closing Stock Report";
		break;
		
		case 1006:
		$report="Warehouse Stock Position Report(Promotion)";
		break;
		case 1005:
		$report="Finish Goods Demand vs Receive Report";
		break;
}

$tr_type="Show";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />
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
	<?
	require_once "../../../controllers/core/inc.exporttable.php";
	?>
</head>
<body>
<!--<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>-->
<div class="main">
<?
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($item_id)) 
		$str 	.= '<h2>'.find_a_field('item_info','item_name','item_id='.$item_id).'</h2>';
		if(isset($dealer_code)) 
		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
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


if($_POST['report']==1004) {

			if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
			elseif(isset($item_id)) 			{$item_sub_con=' and i.item_id='.$item_id;} 
			
			if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 
			
			if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; 
			$date_con=' and ji_date <="'.$to_date.'"'; $pi_date_con=' and pi_date <="'.$to_date.'"';
			
			}


$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='3' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w3[$row->item_id] = $row->item_ex;
		
	}
	$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='10' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w10[$row->item_id] = $row->item_ex;
		
	}
	$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='8' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w8[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='7' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w7[$row->item_id] = $row->item_ex;
		
	}
				$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='54' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w54[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='6' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w6[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='9' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w9[$row->item_id] = $row->item_ex;
		
	}
			$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='89' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w89[$row->item_id] = $row->item_ex;
		
	}
			$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='90' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w90[$row->item_id] = $row->item_ex;
		
	}
	
	// -------------------------------- Now find out transit item
	

$sql="SELECT d.item_id,sum(d.total_unit) as item_ex 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =3
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2019-01-01' group by d.item_id";
	
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w3[$row->item_id] += $row->item_ex;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_ex 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =10
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2019-01-01' group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w10[$row->item_id] += $row->item_ex;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_ex 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =8
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2019-01-01' group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w8[$row->item_id] += $row->item_ex;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_ex 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =7
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2019-01-01' group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w7[$row->item_id] += $row->item_ex;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_ex 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =54
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2019-01-01' group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w54[$row->item_id] += $row->item_ex;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_ex 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =6
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2019-01-01' group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w6[$row->item_id] += $row->item_ex;
		
	}

$sql="SELECT d.item_id,sum(d.total_unit) as item_ex 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =9
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2019-01-01' group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w9[$row->item_id] += $row->item_ex;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_ex 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =89
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2019-01-01' group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w89[$row->item_id] += $row->item_ex;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_ex 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =90
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2019-01-01' group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w90[$row->item_id] += $row->item_ex;
		
	}
	
$sql='select distinct i.item_id,i.unit_name,i.brand_category_type,i.item_name,i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 
from item_info i 
where i.finish_goods_code not between 2000 and 2010 and i.finish_goods_code>0 
and i.finish_goods_code not between 5000 and 6000 and i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' 
and i.status="Active" 
order by i.finish_goods_code';
		   
$query =db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="10"><div class="header"><h1>Jamuna Industrial Agro Group</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date-<?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L-1004</th>
<th>Brand</th>
<th>Item Type </th>
<th>FG</th>
<th>Item Name</th>
<th>Group</th>
<th>Unit</th>
<th>Dhaka</th>
<th>Gazipur</th>
<th>Chittagong</th>
<th>Borisal</th>
<th>Bogura</th>
<th>Sylhet</th>
<th>Jessore</th>
<th>Rangpur</th>
<th>Comilla</th>
<th>Total</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
if($data->pack_size>50000){$data->pack_size=1;}

	
	$dhaka = 	(int)($w3[$data->item_id]/$data->pack_size);
	$ctg = 		(int)($w6[$data->item_id]/$data->pack_size);
	$sylhet =   (int)($w9[$data->item_id]/$data->pack_size);
	$bogura =   (int)($w7[$data->item_id]/$data->pack_size);
	$borisal =  (int)($w8[$data->item_id]/$data->pack_size);
	$jessore =  (int)($w10[$data->item_id]/$data->pack_size);
	$gajipur =  (int)($w54[$data->item_id]/$data->pack_size);
	$rangpur =  (int)($w89[$data->item_id]/$data->pack_size);
	$comilla =  (int)($w90[$data->item_id]/$data->pack_size);
	
	$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore + $gajipur+ $rangpur + $comilla;	   
	
	//echo $sql = 'select sum(item_in-item_ex) from journal_item where item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"';

?>
<tr>
	<td><?=++$j?></td>
	<td><?=$data->item_brand?></td>
	<td><?=$data->brand_category_type?></td>
	<td><?=$data->finish_goods_code?></td>
	<td><?=$data->item_name?></td>
	<td><?=$data->sales_item_type?></td>
	<td><?=$data->unit_name?></td>
	<td style="text-align:right"><?=(int)$dhaka?></td>
	<td style="text-align:right"><?=(int)$gajipur?></td>
	<td style="text-align:right"><?=(int)$ctg?></td>
	<td style="text-align:right"><?=(int)$borisal?></td>
	<td style="text-align:right"><?=(int)$bogura?></td>
	<td style="text-align:right"><?=(int)$sylhet?></td>
	<td style="text-align:right"><?=(int)$jessore?></td>
	<td style="text-align:right"><?=(int)$rangpur?></td>
	<td style="text-align:right"><?=(int)$comilla?></td>
	<td style="text-align:right"><?=(int)$total?></td>
</tr>
<?
}
		
?>
</tbody></table>
<?
}

elseif($_POST['report']==1007) {

			if(isset($sub_group_id)) {$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
			elseif(isset($item_id)) {
			$item_sub_con=' and i.item_id='.$item_id;
			$item_con1=' and item_id='.$item_id;
			$item_con2=' and d.item_id='.$item_id; 
			} 
			
			if(isset($product_group)) {$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 
			
			if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; 
			$date_con=' and ji_date <="'.$to_date.'"'; 
			$pi_date_con=' and pi_date <="'.$to_date.'"';
			
			}


// New stock findout
$sql="SELECT j.warehouse_id, j.item_id, SUM(j.item_in - j.item_ex ) AS qty FROM journal_item j, item_info i where i.item_id=j.item_id 
and i.finish_goods_code>0 ".$date_con.$item_con1." 
and j.warehouse_id in(3,6,7,8,9,10,54,130)
GROUP BY j.item_id,j.warehouse_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$stock[$row->warehouse_id][$row->item_id] = $row->qty;	
	}



/*$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_con1." and warehouse_id ='3' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w3[$row->item_id] = $row->item_ex;	
	}
	
	$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_con1." and warehouse_id ='10' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w10[$row->item_id] = $row->item_ex;
		
	}
	$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_con1." and warehouse_id ='8' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w8[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_con1." and warehouse_id ='7' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w7[$row->item_id] = $row->item_ex;
		
	}
				$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_con1." and warehouse_id ='54' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w54[$row->item_id] = $row->item_ex;
		
	}
	
	$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_con1." and warehouse_id ='6' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w6[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_sub_con." and warehouse_id ='9' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w9[$row->item_id] = $row->item_ex;
		
	}


// Modern Trade Dhaka Store
$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_con1." and warehouse_id ='130' group by item_id";
	$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w130[$row->item_id] = $row->item_ex;	
	}*/

	
	
/*	
$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_sub_con." and warehouse_id ='89' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w89[$row->item_id] = $row->item_ex;
		
	}
			$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con.$item_sub_con." and warehouse_id ='90' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w90[$row->item_id] = $row->item_ex;
		
	}*/
	


// ----------------- Now find out transit item
$sql="SELECT d.item_id,d.warehouse_to, sum(d.total_unit) as qty 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to in(3,6,7,8,9,10,54,130)
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2021-01-01' 
".$item_con2."
group by d.warehouse_to,d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$transit[$row->warehouse_to][$row->item_id] = $row->qty;	
	}	




/*$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =3
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' 
".$item_con2."
group by d.item_id";

	
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t3[$row->item_id] = $row->item_out;	
	}
	
	
	
$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =10
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' ".$item_con2." group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t10[$row->item_id] = $row->item_out;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =8
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' ".$item_con2." group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t8[$row->item_id] = $row->item_out;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =7
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' ".$item_con2." group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t7[$row->item_id] = $row->item_out;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =54
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' ".$item_con2." group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t54[$row->item_id] = $row->item_out;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =6
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' ".$item_con2." group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t6[$row->item_id] = $row->item_out;
		
	}

$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =9
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' ".$item_con2." group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t9[$row->item_id] = $row->item_out;
		
	}
	
	
// Modern Trade
$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =130
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' ".$item_con2." group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t130[$row->item_id] = $row->item_out;
		
	}*/	
	
	

/*
$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =89
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' ".$item_con2." group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t89[$row->item_id] = $row->item_out;
		
	}
$sql="SELECT d.item_id,sum(d.total_unit) as item_out 
FROM production_issue_detail d, production_issue_master m
WHERE d.pi_no = m.pi_no AND d.warehouse_to =90
and m.status != 'RECEIVED' and d.status != 'MANUAL' and d.pi_date <= '".$to_date."' and d.pi_date > '2020-01-01' ".$item_con2." group by d.item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$t90[$row->item_id] = $row->item_out;
		
	}*/
	
$sql='select distinct i.item_id,i.unit_name,i.brand_category_type,i.item_name,i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 
from item_info i 
where i.finish_goods_code not between 2000 and 2010 and i.finish_goods_code>0 
and i.finish_goods_code not between 5000 and 6000 and i.sub_group_id="1096000100010000" 
and i.finish_goods_code <9000
'.$item_sub_con.$product_group_con.' 
and i.status="Active" 
order by i.finish_goods_code';
		   
$query =db_query($sql);
?>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 3px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="14"><div class="header"><h1>Jamuna Industrial Agro Group</h1><h2>Closing Report</h2>
<h5>Closing Stock of Date-<?=$to_date?></h5></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>
<tr>
<th>S/L-1007</th>
<th>Brand</th>
<th>Item Type </th>
<th>FG</th>
<th>Item Name</th>
<th>Group</th>
<th>Unit</th>
<th>Dhaka</th>
<th>T</th>
<th>MT-Dhk</th>
<th>T</th>
<th>Gazipur</th>
<th>T</th>
<th>Chittagong</th>
<th>T</th>
<th>Sylhet</th>
<th>T</th>
<th>Barisal</th>
<th>T</th>
<th>Bogura</th>
<th>T</th>
<th>Jessore</th>
<th>T</th>
<th>Total</th>
<th>Total Tran</th>
<th>Grand</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
if($data->pack_size>50000){$data->pack_size=1;}
	
/*	$dhaka = 	(int)($w3[$data->item_id]/$data->pack_size);
	$ctg = 		(int)($w6[$data->item_id]/$data->pack_size);
	$sylhet =   (int)($w9[$data->item_id]/$data->pack_size);
	$bogura =   (int)($w7[$data->item_id]/$data->pack_size);
	$borisal =  (int)($w8[$data->item_id]/$data->pack_size);
	$jessore =  (int)($w10[$data->item_id]/$data->pack_size);
	$gajipur =  (int)($w54[$data->item_id]/$data->pack_size);
	$rangpur =  (int)($w89[$data->item_id]/$data->pack_size);
	$comilla =  (int)($w90[$data->item_id]/$data->pack_size);
	$mtdhk = 	(int)($w130[$data->item_id]/$data->pack_size);
	
	
	$t_dhaka 	= 	(int)($t3[$data->item_id]/$data->pack_size);
	$t_ctg 		= 	(int)($t6[$data->item_id]/$data->pack_size);
	$t_sylhet 	=   (int)($t9[$data->item_id]/$data->pack_size);
	$t_bogura 	=   (int)($t7[$data->item_id]/$data->pack_size);
	$t_borisal 	=  (int)($t8[$data->item_id]/$data->pack_size);
	$t_jessore 	=  (int)($t10[$data->item_id]/$data->pack_size);
	$t_gajipur 	=  (int)($t54[$data->item_id]/$data->pack_size);
	$t_rangpur =  (int)($t89[$data->item_id]/$data->pack_size);
	$t_comilla =  (int)($t90[$data->item_id]/$data->pack_size);
	$t_mtdhk 	=  (int)($t130[$data->item_id]/$data->pack_size);*/
		   

?>
<tr>
	<td><?=++$j?></td>
	<td><?=$data->item_brand?></td>
	<td><?=$data->brand_category_type?></td>
	<td><?=$data->finish_goods_code?></td>
	<td><?=$data->item_name?></td>
	<td><?=$data->sales_item_type?></td>
	<td></td>
	<td style="text-align:right"><? echo $dhaka =(int)($stock[3][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $t_dhaka =(int)($transit[3][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $mtdhk =(int)($stock[130][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $t_mtdhk =(int)($transit[130][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $gajipur =(int)($stock[54][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $t_gajipur =(int)($transit[54][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $ctg =(int)($stock[6][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $t_ctg =(int)($transit[6][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $sylhet =(int)($stock[9][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $t_sylhet =(int)($transit[9][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $borisal =(int)($stock[8][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $t_borisal =(int)($transit[8][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $bogura =(int)($stock[7][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $t_bogura =(int)($transit[7][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $jessore =(int)($stock[10][$data->item_id]/$data->pack_size)?></td>
	<td style="text-align:right"><? echo $t_jessore =(int)($transit[10][$data->item_id]/$data->pack_size)?></td>
<?	
$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore + $gajipur + $mtdhk;		

$t_total = 	$t_dhaka + $t_ctg  + $t_sylhet +  $t_bogura + $t_borisal + $t_jessore + $t_gajipur + $t_mtdhk;
?>	
	<td style="text-align:right"><?=(int)$total?></td>
	<td style="text-align:right"><?=(int)$t_total?></td>
	<td style="text-align:right"><?=(int)($total+$t_total)?></td>
</tr>
<?
}
		
?>
</tbody></table>
<?
}

elseif($_POST['report']==10041004) 
{
db_query('delete from journal_stock where 1');
$stock_date = date('Y-m-d');
$date_con=' and ji_date <="'.$stock_date.'"';

	echo $sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='3' and item_id like '109600010001%'  group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{ $w3[$row->item_id] = $row->item_ex;}
	
	$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='10' and item_id like '109600010001%'  group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{$w10[$row->item_id] = $row->item_ex;}
	
	$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='8' and item_id like '109600010001%'  group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w8[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='7' and item_id like '109600010001%'  group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w7[$row->item_id] = $row->item_ex;
		
	}
				$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='54' and item_id like '109600010001%' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w54[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='6' and item_id like '109600010001%'  group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w6[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='9' and item_id like '109600010001%'  group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w9[$row->item_id] = $row->item_ex;
		
	}
 $sql='select distinct i.item_id,i.unit_name,i.brand_category_type,i.item_name,"Finished Goods",i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 
from item_info i where i.finish_goods_code!=2000 and i.finish_goods_code!=2001 and i.finish_goods_code!=2002 and i.finish_goods_code>0 and i.finish_goods_code not between 5000 and 6000 and i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' and i.item_brand != "" and i.status="Active" order by i.brand_category_type,i.brand_category,i.item_brand';
		   
$query =db_query($sql);
while($data=mysqli_fetch_object($query)){


	
	echo $dhaka = 	(int)($w3[$data->item_id]/$data->pack_size);
	$ctg = 		(int)($w6[$data->item_id]/$data->pack_size);
	$sylhet =   (int)($w9[$data->item_id]/$data->pack_size);
	$bogura =   (int)($w7[$data->item_id]/$data->pack_size);
	$borisal =  (int)($w8[$data->item_id]/$data->pack_size);
	$jessore =  (int)($w10[$data->item_id]/$data->pack_size);
	$gajipur =  (int)($w54[$data->item_id]/$data->pack_size);
	$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore + $gajipur;	   
	
db_query("INSERT INTO journal_stock (stock_date, item_id, depot_id, stock_qty) VALUES ('".$stock_date."', '".$data->item_id."', '3', '".$dhaka."')");
db_query("INSERT INTO journal_stock (stock_date, item_id, depot_id, stock_qty) VALUES ('".$stock_date."', '".$data->item_id."', '6', '".$ctg."')");
db_query("INSERT INTO journal_stock (stock_date, item_id, depot_id, stock_qty) VALUES ('".$stock_date."', '".$data->item_id."', '9', '".$sylhet."')");
db_query("INSERT INTO journal_stock (stock_date, item_id, depot_id, stock_qty) VALUES ('".$stock_date."', '".$data->item_id."', '7', '".$bogura."')");
db_query("INSERT INTO journal_stock (stock_date, item_id, depot_id, stock_qty) VALUES ('".$stock_date."', '".$data->item_id."', '8', '".$borisal."')");
db_query("INSERT INTO journal_stock (stock_date, item_id, depot_id, stock_qty) VALUES ('".$stock_date."', '".$data->item_id."', '10', '".$jessore."')");
db_query("INSERT INTO journal_stock (stock_date, item_id, depot_id, stock_qty) VALUES ('".$stock_date."', '".$data->item_id."', '54', '".$gajipur."')");
}
		

}
elseif($_POST['report']==1005) 
{
			if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
			elseif(isset($item_id)) 			{$item_sub_con=' and i.item_id='.$item_id;} 
			
			if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 
			
						if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}
			if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; $date_conr=' and req_date between "'.$fr_date.'" and "'.$to_date.'"';}
		
		
$sql='select distinct i.item_id,i.unit_name,i.brand_category_type,i.item_name,"Finished Goods",i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 
from item_info i where i.finish_goods_code!=2000 and i.finish_goods_code!=2001 and i.finish_goods_code!=2002 and i.finish_goods_code>0 and i.finish_goods_code not between 5000 and 6000 and i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' and i.item_brand != "" and i.status="Active"
order by i.brand_category_type,i.brand_category,i.item_brand';
		   
$query =db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="13"><div class="header"><h1>Jamuna Industrial Agro Group</h1><h2><?=$report?></h2>
<h2>Date Range <?=$fr_date?> - <?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th rowspan="2">S/L</th>
<th rowspan="2">Brand</th>
<th rowspan="2">Item Type </th>
<th rowspan="2">FG</th>
<th rowspan="2">Item Name</th>
<th rowspan="2">Group</th>
<th rowspan="2">Unit</th>
<th colspan="2" bgcolor="#FFCC99">DK</th>
<th colspan="2">GA</th>
<th colspan="2" bgcolor="#FFCC99">CTG</th>
<th colspan="2">BOR</th>
<th colspan="2" bgcolor="#FFCC99">BOG</th>
<th colspan="2">SYL</th>
<th colspan="2" bgcolor="#FFCC99">JES</th>
<th colspan="2">TOTAL</th>
</tr>
<tr>
  <th style="height:70px;" bgcolor="#FFFFCC"><font class="vertical-text">Demand</font></th>
  <th><font class="vertical-text">Receive</font></th>
  <th bgcolor="#FFFFCC"><font class="vertical-text">Demand</font></th>
  <th><font class="vertical-text">Receive</font></th>
  <th bgcolor="#FFFFCC"><font class="vertical-text">Demand</font></th>
  <th><font class="vertical-text">Receive</font></th>
  <th bgcolor="#FFFFCC"><font class="vertical-text">Demand</font></th>
  <th><font class="vertical-text">Receive</font></th>
  <th bgcolor="#FFFFCC"><font class="vertical-text">Demand</font></th>
  <th><font class="vertical-text">Receive</font></th>
  <th bgcolor="#FFFFCC"><font class="vertical-text">Demand</font></th>
  <th><font class="vertical-text">Receive</font></th>
  <th bgcolor="#FFFFCC"><font class="vertical-text">Demand</font></th>
  <th><font class="vertical-text">Receive</font></th>
  <th bgcolor="#FFFFCC"><font class="vertical-text">Demand</font></th>
  <th><font class="vertical-text">Receive</font></th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){

$total = 0;
$stock[3] = 0;
$stock[54] = 0;
$stock[6] =0;
$stock[8] = 0;
$stock[7] = 0;
$stock[9] = 0;
$stock[10] =0;

$sqlq = 'select w.warehouse_id,sum(total_unit) as stock from production_issue_master m, production_issue_detail j, warehouse w where 
m.pi_no=j.pi_no and m.warehouse_to=w.warehouse_id and j.item_id="'.$data->item_id.'" '.$date_con.' and w.group_for=2 and w.return_ledger_id>0 and use_type = "SD" group by m.warehouse_to';
$queryq = db_query($sqlq);

while($info = mysqli_fetch_object($queryq))
{
	$stock[$info->warehouse_id] = $info->stock;
	$total = $total + $stock[$info->warehouse_id];
}


$totalr = 0;
$req[3] = 0;
$req[54] = 0;
$req[6] =0;
$req[8] = 0;
$req[7] = 0;
$req[9] = 0;
$req[10] =0;
$sqlp = 'select w.warehouse_id,sum(qty) as stock from requisition_fg_order j, warehouse w where j.warehouse_id=w.warehouse_id and item_id="'.$data->item_id.'" '.$date_conr.' and group_for=2 and return_ledger_id>0 and use_type = "SD" group by j.warehouse_id';
$queryp = db_query($sqlp);

while($infop = mysqli_fetch_object($queryp))
{
	$req[$infop->warehouse_id] = $infop->stock;
	$totalr = $totalr + $req[$infop->warehouse_id];
}
?>
<tr>
	<td><?=++$j?></td>
	<td><?=$data->item_brand?></td>
	<td><?=$data->brand_category_type?></td>
	<td><?=$data->finish_goods_code?></td>
	<td><?=$data->item_name?></td>
	<td><?=$data->sales_item_type?></td>
	<td><?=$data->unit_name?></td>
    <td bgcolor="#FFFFCC" style="text-align:right"><?=(int)($req[3]/$data->pack_size);?>/<?=(int)($req[3]%$data->pack_size);?></td>
    <td style="text-align:right"><?=(int)($stock[3]/$data->pack_size);?>/<?=(int)($stock[3]%$data->pack_size);?></td>
    
    <td bgcolor="#FFFFCC" style="text-align:right"><?=(int)($req[54]/$data->pack_size);?>/<?=(int)($req[54]%$data->pack_size);?></td>
	<td style="text-align:right"><?=(int)($stock[54]/$data->pack_size);?>/<?=(int)($stock[54]%$data->pack_size);?></td>

    <td bgcolor="#FFFFCC" style="text-align:right"><?=(int)($req[6]/$data->pack_size);?>/<?=(int)($req[6]%$data->pack_size);?></td>
	<td style="text-align:right"><?=(int)($stock[6]/$data->pack_size);?>/<?=(int)($stock[6]%$data->pack_size);?></td>

    <td bgcolor="#FFFFCC" style="text-align:right"><?=(int)($req[8]/$data->pack_size);?>/<?=(int)($req[8]%$data->pack_size);?></td>
	<td style="text-align:right"><?=(int)($stock[8]/$data->pack_size);?>/<?=(int)($stock[8]%$data->pack_size);?></td>

    <td bgcolor="#FFFFCC" style="text-align:right"><?=(int)($req[7]/$data->pack_size);?>/<?=(int)($req[7]%$data->pack_size);?></td>
	<td style="text-align:right"><?=(int)($stock[7]/$data->pack_size);?>/<?=(int)($stock[7]%$data->pack_size);?></td>

    <td bgcolor="#FFFFCC" style="text-align:right"><?=(int)($req[9]/$data->pack_size);?>/<?=(int)($req[9]%$data->pack_size);?></td>
	<td style="text-align:right"><?=(int)($stock[9]/$data->pack_size);?>/<?=(int)($stock[9]%$data->pack_size);?></td>

    <td bgcolor="#FFFFCC" style="text-align:right"><?=(int)($req[10]/$data->pack_size);?>/<?=(int)($req[10]%$data->pack_size);?></td>
	<td style="text-align:right"><?=(int)($stock[10]/$data->pack_size);?>/<?=(int)($stock[10]%$data->pack_size);?></td>
    
    
    <td bgcolor="#FFFFCC" style="text-align:right"><?=(int)($totalr/$data->pack_size);?>/<?=(int)($totalr%$data->pack_size);?></td>
	<td style="text-align:right"><?=(int)($total/$data->pack_size);?>/<?=(int)($total%$data->pack_size);?></td>
</tr>
<?
}
		
?>
</tbody></table>
<?
}



elseif($_POST['report']==2) {

		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		//if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}

if(isset($product_group)) 		{$pg_con.=' and d.product_group="'.$product_group.'"';}
if(isset($region_id)) 	{$region_con=' and d.region_id='.$region_id;}
if(isset($zone_id)) 	{$zone_con=' and d.zone_id='.$zone_id;}
		
	if(isset($dealer_type)){
		if($dealer_type=='MordernTrade'){
		$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';
		}elseif($dealer_type=='Super_Mgroup'){
		$dealer_type_con = ' and ( d.dealer_type="SuperShop" or  d.product_group="M") ';
		}else {$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}
	}

if($_POST['dealer']!='') {$super_con=' and d.dealer_outlet_name="'.$_POST['dealer'].'"';}




$sql2='select 
		i.finish_goods_code as fg,
		m.gift_on_item as item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*i.d_price) as DP,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		
		where d.dealer_code=m.dealer_code and m.id=a.order_no  and   
	a.item_id = 1096000100010312 and m.gift_on_item=i.item_id 
	'.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.$super_con.$region_con.$zone_con.' 
	group by  m.gift_on_item order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$citem[$data2->item_id] = $data2->sale_price*$data2->qty;
	}
	
	
$sql2='select 
		i.finish_goods_code as fg,
		m.item_id as item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		i.d_price,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*i.d_price) as DP,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		
		where d.dealer_code=m.dealer_code and m.id=a.order_no  and   
	a.unit_price = 0 and a.gift_id=1 and m.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.$super_con.$region_con.$zone_con.' 
	group by  m.item_id order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$ditem[$data2->item_id] = $data2->d_price*$data2->qty;
	}
?>

<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead>
<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>

<tr>
<th>S/L</th>
<th>Fg</th>
<th>Item Name</th>
<th>Unit</th>
<th>Category</th>
<th>Pack Size</th>
<th>Pkt</th>
<th>Pcs</th>
<th>Total Qty</th>
<th>Chalan Amt</th>
<th>Discount</th>
<th>After Dis </th>
<th>Free Item</th>
<th>Receivable Amt</th>
</tr>
</thead><tbody>
<?
$sql='select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		i.sub_group_id,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*i.d_price) as DP,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price

from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
where d.dealer_code=m.dealer_code and m.id=a.order_no and  
a.item_id=i.item_id '.$con.$pg_con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dealer_type_con.$super_con.$region_con.$zone_con.' 

group by  a.item_id order by i.finish_goods_code';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$payable = $data->actual_price - ((($citem[$data->item_id])*(-1)) + (($ditem[$data->item_id])));
$payable_total = $payable_total + $payable;
$dis_total = $dis_total + (($citem[$data->item_id])*(-1));
$dis_total2 = $dis_total2 + (($ditem[$data->item_id]));
$actual_total = $actual_total + $data->actual_price;
$ad_actual_total = $ad_actual_total + ($data->actual_price+$citem[$data->item_id]);
?>
<tr>
<td style="text-align:center"><?=++$s?></td>
<td style="text-align:center"><?=$data->fg?></td>
<td><?=$data->item_name?></td>
<td style="text-align:center"><?=$data->unit?></td>
<td><?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$data->sub_group_id.'"');?></td>
<td style="text-align:center"><?=$data->pack_size?></td>
<td style="text-align:right"><?=$data->pkt; $total_pkt+=$data->pkt;?></td>
<td style="text-align:right"><?=$data->pcs; $total_pcs+=$data->pcs;?></td>
<td style="text-align:right"><?=$data->qty; $total_qty+=$data->qty;?></td>
<td style="text-align:right"><?=number_format($data->actual_price,2)?></td>
<td style="text-align:right"><?=number_format((($citem[$data->item_id])*(-1)),2)?></td>
  <td style="text-align:right"><?=number_format(($data->actual_price+$citem[$data->item_id]),2)?></td>
  <td style="text-align:right"><?=number_format((($ditem[$data->item_id])),2)?></td>
  <td style="text-align:right"><?=number_format($payable,2)?></td></tr>
<?
}
?>
<tr ><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right"><strong>Total :</strong></td>
<td style="text-align:right"><?=number_format($total_pkt,2)?></td>
<td style="text-align:right"><?=number_format($total_pcs,2)?></td>
<td style="text-align:right"><?=number_format($total_qty,2)?></td>
<td style="text-align:right"><?=number_format($actual_total,2)?></td>
<td style="text-align:right"><?=number_format($dis_total,2)?></td>
  <td style="text-align:right"><?=number_format($ad_actual_total,2)?></td>
  <td style="text-align:right"><?=number_format($dis_total2,2)?></td>
<td style="text-align:right"><?=number_format($payable_total,2)?></td></tr></tbody></table>
<?
}



elseif($_POST['report']==40) {

if(isset($item_id)) {$item_cons=' and i.item_id='.$item_id;}

$sql='select distinct i.item_id,i.sales_item_type as product_group,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.f_price as item_price,i.d_price as d_price
from item_info i, item_sub_group s 
where i.product_nature = "Salable" '.$item_cons.' and i.sub_group_id=s.sub_group_id 
and i.finish_goods_code > 1
order by i.finish_goods_code,s.sub_group_name,i.item_name';
$query =db_query($sql);   

$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id=128');
		
$s='select sum(a.item_in-a.item_ex) as final_stock , i.item_id
from journal_item a, item_info i 
where i.product_nature = "Salable" and a.item_id=i.item_id  
'.$date_con.$item_con.$status_con.' 
and a.warehouse_id="128" and i.finish_goods_code > 1 group by i.item_id';
$q = db_query($s);
while($i=mysqli_fetch_object($q))
{
$final_stock[$i->item_id] = $i->final_stock;
}
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead>
  <tr>
    <td style="border:0px;" colspan="11"><div class="header">
        <h1>Jamuna Industrial Agro Group</h1>
        <h2><?=$report?></h2>
        <h2>Closing Stock of Date-<?=$to_date?></h2></div>
      <div class="left"></div>
      <div class="right"></div>
      <div class="date">Reporting Time:<?=date("h:i A d-m-Y")?></div></td>
  </tr>
  <tr>
    <th rowspan="2">S/L-40</th>
    <th rowspan="2">Item Code</th>
	<th rowspan="2">Group</th>
    <th rowspan="2">FG</th>
    <th rowspan="2">Item Name</th>
    <th rowspan="2">Pack Size</th>
    <th rowspan="2">Unit</th>
    <th colspan="2">Final Stock</th>
    <th rowspan="2">Total Pcs</th>
    <th rowspan="2">DP Rate</th>
    <th rowspan="2">DP Total</th>
  </tr>
  <tr>
    <th bgcolor="#CCFFFF">ctr</th>
    <th bgcolor="#FFCCFF">pcs</th>
  </tr>
</thead>
<tbody>
<?
while($data=mysqli_fetch_object($query)){
if($final_stock[$data->item_id]<>0){
$j++;
?>
  <tr>
    <td><?=$j?></td>
    <td>C-<?=$data->item_id?></td>
	<td><?=$data->product_group?></td>
    <td><?=$data->finish_goods_code?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->pack_size?></td>
    <td><?=$data->unit_name?></td>
    <td style="text-align:right; background-color:#CCFFFF;"><?=(int)($final_stock[$data->item_id]/$data->pack_size)?></td>
    <td style="text-align:right;background-color:#FFCCFF;"><?=($final_stock[$data->item_id]%$data->pack_size)?></td>
    <td style="text-align:right"><?=(int)$final_stock[$data->item_id];?></td>
    <td style="text-align:right"><?=@number_format(($data->d_price),2)?></td>
    <td style="text-align:right"><? $dsum =$data->d_price*$final_stock[$data->item_id]; echo number_format(($data->d_price*$final_stock[$data->item_id]),2);?></td>
  </tr>
<?
$dt_sum = $dt_sum + $dsum;
$t_sum = $t_sum + $sum;
} // end 0
}
?>
  <tr>
    <td></td><td></td><td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="text-align:right; background-color:#CCFFFF;"></td>
    <td style="text-align:right;background-color:#FFCCFF;"></td>
    <td style="text-align:right"></td>
    <td style="text-align:right"></td>
    <td style="text-align:right"><strong><?=number_format($dt_sum,2)?></strong></td>
  </tr>
  <?
} // end 40






elseif($_REQUEST['report']==116) 
{echo $str;


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">REGION NAME</span></td>
    <td bgcolor="#333333"><span class="style3">ZONE NAME </span></td>
    <td bgcolor="#333333"><span class="style3">CTN</span></td>
    <td bgcolor="#333333"><span class="style3">TAKA(DP)</span></td>
  </tr>
  <?
 
//$region_name = find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id);
if($region_id>0) $region_con = ' and REGION_ID="'.$region_id.'"';
$sql = "select z.*,b.BRANCH_NAME from zon z,branch b where 1 and BRANCH_ID=REGION_ID ".$region_con." order by BRANCH_NAME,ZONE_NAME";

	$query = db_query($sql);
	while($item=mysqli_fetch_object($query)){
 $zone_code = $item->ZONE_CODE;
$sqlmon = mysqli_fetch_row(db_query("select sum(c.total_amt),sum(c.total_unit),c.pkt_size from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_date."' and '".$t_date."' and d.dealer_type='Distributor' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_id));

//echo "select sum(c.total_amt),sum(c.total_unit),i.pack_size from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_date."' and '".$t_date."' and d.dealer_type='Distributor' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_id;
$totalq = $totalq + (int)@($sqlmon[1]/$sqlmon[2]);
$totalt = $totalt + $sqlmon[0];
 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$i?></td>
    <td><?=$item->BRANCH_NAME?></td>
    <td>
      <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_code)?>    </td>
    <td bgcolor="#99CCFF"><?=(int)@($sqlmon[1]/$sqlmon[2]);?></td>
    <td bgcolor="#66CC99"><?=number_format($sqlmon[0],2);?></td>
  </tr>
  <? }
  
  ?>  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td colspan="3">TOTAL :</td>
    <td><?=(int)@($totalq);?></td>
    <td><?=number_format($totalt,2);?></td>
    </tr>
</table>
<?
}

// new report date january 10 2018
elseif($_POST['report']==201) 
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="8"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>

<tr>
  <th rowspan="2">S/L</th>
  <th rowspan="2">CODE</th>
<th rowspan="2">Product Name</th>
<th rowspan="2">GRP</th>
<th colspan="2">SALES</th>
<th colspan="2">FREE/BONUS</th>
<th colspan="2">TOTAL GOODS</th>
<th colspan="2">CP</th>
  <th colspan="4">AMOUNT IN TAKA</th>
  <th>TOTAL TRADE</th>
  <th rowspan="2" valign="middle">%</th>
</tr>
<tr>
  <th>CTN</th>
  <th>PCS</th>
  <th>CTN</th>
  <th>PCS</th>
  <th>CTN</th>
  <th>PCS</th>
  <th>CTN</th>
  <th>PCS</th>
  <th>SALES</th>
  <th>FREE</th>
  <th>DISCOUNT</th>
  <th>CP</th>
  <th>TAKA</th>
  </tr>

</thead><tbody>
<?
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$payable = $data->actual_price - ((($citem[$data->item_id])*(-1)) + (($ditem[$data->item_id])));
$payable_total = $payable_total + $payable;
$dis_total = $dis_total + (($citem[$data->item_id])*(-1));
$dis_total2 = $dis_total2 + (($ditem[$data->item_id]));
$actual_total = $actual_total + $data->actual_price;
$total_qty = $ditemqty[$data->item_id] + $data->qty;

?>
<tr><td><?=++$s?></td><td><?=$data->fg?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->sales_item_type?></td><td><?=$data->pkt?></td><td><?=$data->pcs?></td><td><span style="text-align:right">
  <?=number_format((($ditempkt[$data->item_id])),0)?>
</span></td>
  <td><span style="text-align:right">
    <?=number_format((($ditempcs[$data->item_id])),0)?>
  </span></td>
  <td style="text-align:right"><?=(int)($total_qty/$data->pack_size)?></td>
  <td style="text-align:right"><?=(int)($total_qty%$data->pack_size)?></td>
  <td><span style="text-align:right">
    <?=number_format((($pitempkt[$data->item_id])),0)?>
  </span></td>
  <td><span style="text-align:right">
    <?=number_format((($pitempcs[$data->item_id])),0)?>
  </span></td>
  <td style="text-align:right"><?=number_format((($data->actual_price)),2)?></td>
  <td style="text-align:right"><?=number_format((($ditem[$data->item_id])),2)?></td>
  <td style="text-align:right"><?=number_format(($citem[$data->item_id])*(-1),2)?></td>
  <td style="text-align:right"><?=number_format((($pitem[$data->item_id])),2)?></td>
  <td style="text-align:right"><?=number_format((($ditem[$data->item_id]) + (($citem[$data->item_id])*(-1)) + (($pitem[$data->item_id]))),2)?></td>
  <td style="text-align:right"><?=number_format(@(@(@(($ditem[$data->item_id]) + (($citem[$data->item_id])*(-1)) + @(($pitem[$data->item_id])))*100)/($data->actual_price)),2)?></td></tr>
<?
$total_actual_price = $total_actual_price + $data->actual_price;
$free_actual_price = $free_actual_price + ($ditem[$data->item_id]);
$distount_actual_price = $distount_actual_price + (($citem[$data->item_id])*(-1));
$cp_actual_price = $cp_actual_price + (($pitem[$data->item_id]));
$total_trade_amount = $total_trade_amount + ($ditem[$data->item_id]) + (($citem[$data->item_id])*(-1)) + (($pitem[$data->item_id]));
}
?>
<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="5" style="text-align:right"><?=number_format((($total_actual_price)),2)?></td><td><span style="text-align:right">
  <?=number_format((($free_actual_price)),2)?>
</span></td>
  <td><span style="text-align:right"><?=number_format((($distount_actual_price)),2)?></span></td>
  <td><span style="text-align:right"><?=number_format((($cp_actual_price)),2)?></span></td>
  <td><span style="text-align:right"><?=number_format((($total_trade_amount)),2)?></span></td>
  <td style="text-align:right"><?=number_format((@($total_trade_amount/$total_actual_price)*100),2)?></td></tr></tbody></table>
<?
}


// -----------------------------------------------------------sajeeb warehouse stock report dec-30-2017
elseif($_POST['report']==901)
{
$report="Stock Statemennt Report";
if($_REQUEST['depot_id']>0){
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

if(isset($dealer_code)) {$dealer_con=' and d.dealer_code='.$dealer_code;} 
$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';

// opening
$sql="select j.item_id,i.finish_goods_code as code,i.pack_size,sum(j.item_in - j.item_ex) balance,
(sum(j.item_in - j.item_ex) DIV i.pack_size) as ctn, (sum(j.item_in - j.item_ex) MOD i.pack_size) as pcs
from journal_item j, item_info i 
where j.item_id=i.item_id and i.finish_goods_code > 0 and ji_date < '".$f_date."' and warehouse_id = '".$_REQUEST['depot_id']."' 
group by item_id";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$opening[$row->code] = $row->balance;
		$opening_ctn[$row->code] = $row->ctn;
		$opening_pcs[$row->code] = $row->pcs;
	}
	
// closing
$sql="select j.item_id,i.finish_goods_code as code,i.pack_size,sum(j.item_in - j.item_ex) balance,
(sum(j.item_in - j.item_ex) DIV i.pack_size) as ctn, (sum(j.item_in - j.item_ex) MOD i.pack_size) as pcs
from journal_item j, item_info i 
where j.item_id=i.item_id and i.finish_goods_code > 0 and ji_date <= '".$t_date."' and warehouse_id = '".$_REQUEST['depot_id']."' 
group by item_id";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$binclosing[$row->code] = $row->balance;
		$binclosing_ctn[$row->code] = $row->ctn;
		$binclosing_pcs[$row->code] = $row->pcs;
	}

// FG Purchase	
$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs
from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['depot_id']."'
AND (j.tr_from in('Purchase','Transfered','Transit','Import') OR j.relevant_warehouse in (5,15,17,68))
and j.relevant_warehouse not in(3,6,7,8,9,10,11,51,54,89,90)
AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'
group by code";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$purchase[$row->code] = $row->balance;
		$purchase_ctn[$row->code] = $row->ctn;
		$purchase_pcs[$row->code] = $row->pcs;
	}

//SalesReturn
$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs
from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['depot_id']."'
AND  j.tr_from in('Return','BulkReturn') and j.ji_date between '".$f_date."' and '".$t_date."'
group by code";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$sreturn[$row->code] = $row->balance;
		$sreturn_ctn[$row->code] = $row->ctn;
		$sreturn_pcs[$row->code] = $row->pcs;
	}



// store in	
$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs
from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['depot_id']."'
AND j.tr_from in('Transfered','Transit') and j.relevant_warehouse in(3,6,7,8,9,10,11,51,54,89,90)
AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'
group by code";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$storein[$row->code] = $row->balance;
		$storein_ctn[$row->code] = $row->ctn;
		$storein_pcs[$row->code] = $row->pcs;
	}

// other receive	
$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs
from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['depot_id']."'
AND j.tr_from in('Reprocess Receive','Adjust','Claim Item Receive','Other Receive') AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'
group by code";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$o_in[$row->code] = $row->balance;
		$o_in_ctn[$row->code] = $row->ctn;
		$o_in_pcs[$row->code] = $row->pcs;
	}
	


// sales = sales + bulk sales + staff sales	
$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex-j.item_in) balance,
(sum(j.item_ex-j.item_in) DIV i.pack_size) as ctn,(sum(j.item_ex-j.item_in) MOD i.pack_size) as pcs
from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['depot_id']."'
AND j.tr_from in('Sales','Bulk Sales','SalesReturn','Staff Sales')
AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'
group by code";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$sales[$row->code] = $row->balance;
		$sales_ctn[$row->code] = $row->ctn;
		$sales_pcs[$row->code] = $row->pcs;
	}

// store out	
$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs
from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['depot_id']."'
AND j.tr_from in('Transfered','Transit') and j.relevant_warehouse in(3,6,7,8,9,10,11,51,54,89,90) 
AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'
group by code";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$storeout[$row->code] = $row->balance;
		$storeout_ctn[$row->code] = $row->ctn;
		$storeout_pcs[$row->code] = $row->pcs;
	}

// purchase return	
$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs
from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['depot_id']."'
AND j.tr_from in('Transfered','Transit') and j.relevant_warehouse in(5,15,17,68) 
AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'
group by code";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$preturn[$row->code] = $row->balance;
		$preturn_ctn[$row->code] = $row->ctn;
		$preturn_pcs[$row->code] = $row->pcs;
	}

// other issue	
$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs
from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['depot_id']."'
AND  j.tr_from  in('Gift Issue','Other Sales','Reprocess Issue','Sample Issue','Adjust','Consumption','Claim Item Issue','Entertainment Issue','Other Issue') 
AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'
group by code";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$o_ex[$row->code] = $row->balance;
		$o_ex_ctn[$row->code] = $row->ctn;
		$o_ex_pcs[$row->code] = $row->pcs;
	}


?>
<center>
<h1><?=$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_REQUEST['depot_id']);?></h1>
<h2>Stock Statement Report</h2>
<h3>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="ExportTable">
<thead>
<tr>
	<th>S/L</th>
  <th>Code</th>
  <th>Item Name</th>
  <th>Size</th>
  <th colspan="2" bgcolor="#6666CC">Opening</th>
  <th colspan="2" bgcolor="#009999">Purchase</th>
  <th colspan="2" bgcolor="#009999">Sales Return</th>
  <th colspan="2" bgcolor="#009999">Store In  </th>
  <th colspan="2" bgcolor="#009999">Other </th>
  <th colspan="2" bgcolor="#009999">Total</th>
  <th colspan="2" bgcolor="#FF6699">Sales</th>
  <th colspan="2" bgcolor="#FF6699">Purchase Return</th>
  <th colspan="2" bgcolor="#FF6699">Store Out  </th>
  <th colspan="2" bgcolor="#FF6699">Other</th>
  <th colspan="2" bgcolor="#FF6699">Total</th>
  <th colspan="2" bgcolor="#6666CC">Closing</th>
  <th colspan="2" bgcolor="#6666CC">Bin Closing </th>
  <th colspan="2">Diff</th>
  <th>Remarks </th>
  </tr>
</thead>
<tbody>
<?

$sql="SELECT item_id,finish_goods_code as code,item_name,pack_size
FROM  item_info 
where finish_goods_code>0
and finish_goods_code not between 2000 and 2005
order by code";
// finish_goods_code in(278,814)
?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>Ctn</td>
  <td>Pcs</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?php
$query = db_query($sql);
while($data= mysqli_fetch_object($query)){ ?>
<tr><td><?=++$op;?></td>
  <td><?=$data->code?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->pack_size?></td>
  <td><?=$opening_ctn[$data->code]?></td>
  <td><?=(int)$opening_pcs[$data->code]?></td>
  <td><?=$purchase_ctn[$data->code]?></td>
  <td><?=(int)$purchase_pcs[$data->code]?></td>
  <td><?=$sreturn_ctn[$data->code]?></td>
  <td><?=(int)$sreturn_pcs[$data->code]?></td>
  <td><?=$storein_ctn[$data->code]?></td>
  <td><?=(int)$storein_pcs[$data->code]?></td>
  <td><?=$o_in_ctn[$data->code]?></td>
  <td><?=(int)$o_in_pcs[$data->code]?></td>

<?php $in_total[$data->code] = $opening[$data->code] + $purchase[$data->code] + $sreturn[$data->code] + $storein[$data->code] + $o_in[$data->code]; 
$in_pcs = fmod($in_total[$data->code],$data->pack_size);?>
  <td><?=(int)($in_total[$data->code]/$data->pack_size)?></td>
  <td><?=$in_pcs?></td>
  <td><?=$sales_ctn[$data->code]?></td>
  <td><?=(int)$sales_pcs[$data->code]?></td>
  <td><?=$preturn_ctn[$data->code]?></td>
  <td><?=(int)$preturn_pcs[$data->code]?></td>
  <td><?=$storeout_ctn[$data->code]?></td>
  <td><?=(int)$storeout_pcs[$data->code]?></td>
  <td><?=$o_ex_ctn[$data->code]?></td>
  <td><?=(int)$o_ex_pcs[$data->code]?></td>

<?php $out_total[$data->code] = $sales[$data->code] + $preturn[$data->code] + $storeout[$data->code] + $o_ex[$data->code]; 
$out_pcs = fmod($out_total[$data->code],$data->pack_size);?>
  
  <td><?=(int)($out_total[$data->code]/$data->pack_size)?></td>
  <td><?=$out_pcs?></td>

<?php $closing_total[$data->code] = $in_total[$data->code] - $out_total[$data->code]; 
$closing_pcs = fmod($closing_total[$data->code],$data->pack_size);?>  
  <td><?=(int)($closing_total[$data->code]/$data->pack_size)?></td>
  <td><?=$closing_pcs?></td>
    
  
  <td><?=$binclosing_ctn[$data->code]?></td>
  <td><?=(int)$binclosing_pcs[$data->code]?></td>
  <td><?=(int)(($closing_total[$data->code]/$data->pack_size)-$binclosing_ctn[$data->code]);?></td>
  <td><?=(int)($closing_pcs-$binclosing_pcs[$data->code]);?></td>
  <td>&nbsp;</td>
</tr>
<?
}
?>
</tbody></table>
<br>
<table width="100%" border="0" id="ExportTable">
  <tr>
    <td style="border:0px;" width="21%"><div align="center">______________</div></td>
    <td style="border:0px;" width="19%"><div align="center">_________</div></td>
    <td style="border:0px;"width="19%"><div align="center">________</div></td>
    <td style="border:0px;"width="15%"><div align="center">__________</div></td>
    <td style="border:0px;"width="12%"><div align="center">______</div></td>
    <td style="border:0px;"width="14%"><div align="center">_________</div></td>
  </tr>
  <tr>
    <td style="border:0px;"><div align="center">Dy. Manager(A/C) </div></td>
    <td style="border:0px;"><div align="center">DGM(A/C)</div></td>
    <td style="border:0px;"><div align="center">GM(Audit)</div></td>
    <td style="border:0px;"><div align="center">ED/Director</div></td>
    <td style="border:0px;"><div align="center">DMD</div></td>
    <td style="border:0px;"><div align="center">Chairman</div></td>
  </tr>
</table>

<?
}else{echo "Please Select Warehouse";}}
// end sajeeb warehosue stock report 901


elseif($_POST['report']==2001) 
{

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		if(isset($depot_id)) 			{$con.=' and a.depot_id="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		if(isset($dealer_type)){
		if($dealer_type=='MordernTrade')		{$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
		else 									{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}
		}
		
		if(isset($region_id)) 	{$region_con=' and d.region_id='.$region_id;}
		if(isset($zone_id)) 	{$zone_con=' and d.zone_id='.$zone_id;}		
		
	
$sql2='select 
		i.finish_goods_code as fg,
		m.gift_on_item as item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*i.d_price) as DP,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		
		where d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   
	(a.item_id = 1096000100010312 or a.item_id=1096000100010967) and m.gift_on_item=i.item_id 
	'.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$pg_con.$dealer_type_con.$region_con.$zone_con.' 
	group by  m.gift_on_item order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$citem[$data2->item_id] = $data2->sale_price*$data2->qty;
	$citempkt[$data2->item_id] = $data2->pkt;
	$citempcs[$data2->item_id] = $data2->pcs;
	$citemqty[$data2->item_id] = $data2->qty;
	}
	
	
	
	$sql2='select 
		i.item_id,
		sum(a.total_unit*m.dp_price) as free,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		where m.item_id=i.item_id and d.dealer_code=m.dealer_code and m.id=a.order_no and i.item_brand!="Promotional" and   
	a.unit_price = 0  '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$pg_con.$dealer_type_con.$region_con.$zone_con.' 
	group by  i.item_id ';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$ditem[$data2->item_id] = $data2->free;
	$ditempkt[$data2->item_id] = $data2->pkt;
	$ditempcs[$data2->item_id] = $data2->pcs;
	$ditemqty[$data2->item_id] = $data2->qty;
	}
	
	$sql2='select 
		m.item_id as item_id,

		sum(a.total_unit*m.fp_price) as free,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		
		where m.item_id=i.item_id and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand="Promotional" and   
	a.unit_price = 0 '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$pg_con.$dealer_type_con.$region_con.$zone_con.' 
	group by  m.item_id ';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$pitem[$data2->item_id] = $data2->free;
	$pitempkt[$data2->item_id] = $data2->pkt;
	$pitempcs[$data2->item_id] = $data2->pcs;
	$pitemqty[$data2->item_id] = $data2->qty;
	}



?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="8"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>

<tr>
	<th rowspan="2">S/L</th>
	<th rowspan="2">CODE</th>
	<th rowspan="2">Product Name</th>
	<th rowspan="2">GRP</th>
	<th colspan="2">SALES</th>
	<th colspan="2">FREE/BONUS</th>
	<th colspan="2">TOTAL GOODS</th>
	<th colspan="2">CP</th>
	<th colspan="4">AMT IN TAKA</th>
	<th>TOTAL TRADE</th>
	<th rowspan="2" valign="middle">%</th>
</tr>
<tr>
  <th>CTN</th>
  <th>PCS</th>
  <th>CTN</th>
  <th>PCS</th>
  <th>CTN</th>
  <th>PCS</th>
  <th>CTN</th>
  <th>PCS</th>
  <th>SALES</th>
  <th>FREE</th>
  <th>DISCOUNT</th>
  <th>CP</th>
  <th>TAKA</th>
  </tr>

</thead><tbody>
<?
$sql='select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,i.sales_item_type,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*i.d_price) as DP,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 
		where d.dealer_code=m.dealer_code and m.id=a.order_no  

		and (a.item_id != 1096000100010312 and a.item_id != 1096000100010967)
		and a.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$pg_con.$dealer_type_con.$region_con.$zone_con.' 
	group by a.item_id order by i.finish_goods_code';


$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$payable = $data->actual_price - ((($citem[$data->item_id])*(-1)) + (($ditem[$data->item_id])));
$payable_total = $payable_total + $payable;
$dis_total = $dis_total + (($citem[$data->item_id])*(-1));
$dis_total2 = $dis_total2 + (($ditem[$data->item_id]));
$actual_total = $actual_total + $data->actual_price;
$total_qty = $ditemqty[$data->item_id] + $data->qty;

?>
<tr><td><?=++$s?></td><td><?=$data->fg?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->sales_item_type?></td><td><?=$data->pkt?></td><td><?=$data->pcs?></td><td><span style="text-align:right">
  <?=number_format((($ditempkt[$data->item_id])),0)?>
</span></td>
  <td><span style="text-align:right">
    <?=number_format((($ditempcs[$data->item_id])),0)?>
  </span></td>
  <td style="text-align:right"><?=(int)($total_qty/$data->pack_size)?></td>
  <td style="text-align:right"><?=(int)($total_qty%$data->pack_size)?></td>
  <td><span style="text-align:right">
    <?=number_format((($pitempkt[$data->item_id])),0)?>
  </span></td>
  <td><span style="text-align:right">
    <?=number_format((($pitempcs[$data->item_id])),0)?>
  </span></td>
  <td style="text-align:right"><?=number_format((($data->actual_price)),2)?></td>
  <td style="text-align:right"><?=number_format((($ditem[$data->item_id])),2)?></td>
  <td style="text-align:right"><?=number_format(($citem[$data->item_id])*(-1),2)?></td>
  <td style="text-align:right"><?=number_format((($pitem[$data->item_id])),2)?></td>
  <td style="text-align:right"><?=number_format((($ditem[$data->item_id]) + (($citem[$data->item_id])*(-1)) + (($pitem[$data->item_id]))),2)?></td>
  <td style="text-align:right"><?=number_format(@(@(@(($ditem[$data->item_id]) + (($citem[$data->item_id])*(-1)) + @(($pitem[$data->item_id])))*100)/($data->actual_price)),2)?></td></tr>
<?
$total_actual_price = $total_actual_price + $data->actual_price;
$free_actual_price = $free_actual_price + ($ditem[$data->item_id]);
$distount_actual_price = $distount_actual_price + (($citem[$data->item_id])*(-1));
$cp_actual_price = $cp_actual_price + (($pitem[$data->item_id]));
$total_trade_amount = $total_trade_amount + ($ditem[$data->item_id]) + (($citem[$data->item_id])*(-1)) + (($pitem[$data->item_id]));
}
?>
<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="5" style="text-align:right"><?=number_format((($total_actual_price)),2)?></td><td><span style="text-align:right">
  <?=number_format((($free_actual_price)),2)?>
</span></td>
  <td><span style="text-align:right"><?=number_format((($distount_actual_price)),2)?></span></td>
  <td><span style="text-align:right"><?=number_format((($cp_actual_price)),2)?></span></td>
  <td><span style="text-align:right"><?=number_format((($total_trade_amount)),2)?></span></td>
  <td style="text-align:right"><?=number_format((@($total_trade_amount/$total_actual_price)*100),2)?></td></tr></tbody></table>
<?
}








elseif($_POST['report']==101)
{
 
$sqld="select c.chalan_no,m.do_no,m.do_date,c.driver_name as serial_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp,sum(total_amt) as total_amt from 
sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w
where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." group by chalan_no order by c.chalan_no";
$query = db_query($sqld);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="8"><?=$str?></td></tr><tr><th>S/L</th><th>Do Date</th>
  <th>Do No</th>
  <th>Chalan Date</th><th>Chalan No</th><th>Serial No</th><th>Dealer Name</th><th>Depot</th><th>Grp</th><th>DP Total</th><th>Discount</th><th>Sale Total</th></tr></thead>
<tbody>
<? 

while($data=mysqli_fetch_object($query)){$s++;
//$sqld = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no;
//$info = mysqli_fetch_row(db_query($sqld));

//$sqld1 = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no.' and total_amt>0';
$sqld1 = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no.' and unit_price<0';
$info1 = mysqli_fetch_row(db_query($sqld1));
$info[0] = $data->total_amt;
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$info[0];
$tp_t = $tp_t+$info1[0];
?>
	<tr>
<td><?=$s?></td><td><?=$data->do_date?></td>
<td><?=$data->do_no?></td>
<td><?=$data->chalan_date?></td>
<td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
<td><?=$data->serial_no?></td>
<td><?=$data->dealer_name?></td><td><?=$data->depot?></td><td><?=$data->grp?></td>
<td><?=number_format($info[0],2)?></td><td><?=($info1[0]<0)?number_format((($info1[0])*(-1)),2):'0';;?></td><td><?=number_format(($info[0]-$info1[0]),2);?></td>
  	</tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=number_format($dp_t,2)?></td><td><?=number_format(($tp_t),2)?></td><td><?=number_format(($dp_t-$tp_t),2)?></td></tr></tbody></table>

<?

}

elseif($_POST['report']==1) 
{
		if(isset($dealer_type)){
		if($dealer_type=='MordernTrade')		{$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
		else 	{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}
		}
if(isset($depot_id)) 	{$depot_con=' and c.depot_id="'.$depot_id.'"';} 
if(isset($region_id)) 	{$region_con=' and d.region_id='.$region_id;}
if(isset($zone_id)) 	{$zone_con=' and d.zone_id='.$zone_id;}
if(isset($dealer_code)) 	{$dealer_con=' and d.dealer_code='.$dealer_code;}



$sqld1 = "select sum(total_amt) as total_amt,chalan_no 
from sale_do_master m,sale_do_chalan c,dealer_info d , warehouse w
where m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and unit_price<0 
".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con.$region_con.$zone_con." 
group by chalan_no order by c.chalan_no";

$query1 = db_query($sqld1);
while($info1 = mysqli_fetch_row($query1))
{
$discount[$info1[1]] = $info1[0];
}


// Special Discount
$sqld1 = "select dr_amt as total_amt,tr_no 
from sale_do_master m,sale_do_chalan c,dealer_info d, journal j, warehouse w
where j.tr_from = 'Sales' and j.tr_no = c.chalan_no and  j.ledger_id='4014000800040000' and m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con.$region_con.$zone_con."  group by chalan_no order by c.chalan_no";
$query1 = db_query($sqld1);
while($info1 = mysqli_fetch_row($query1))
{
$sp_discount[$info1[1]] = $info1[0];
}
?>
<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>



<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
<tr>
<th>S/L</th>
<th>Chalan No</th>
<th>Do No</th>
<th>Do Date</th>

<th>Chalan Date</th>
<th>Dealer Code</th>
<th>Dealer Name</th>
<th>Delivery Address</th>
<th>Depot</th>

<th>Sales Total</th>
<th>Discount</th>

<th>Actual Sales </th>
</tr></thead><tbody>
<?
$sqls="select c.chalan_no,m.do_no,m.do_date,c.delivery_point,c.driver_name as serial_no,c.chalan_date,
d.dealer_code as code,d.dealer_name_e as dealer_name,
w.warehouse_name as depot,d.product_group as grp,sum(c.total_amt) as total_amt 
from sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w
where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id 
".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con.$region_con.$zone_con." 
group by chalan_no order by c.chalan_no";
$query = db_query($sqls);
while($data=mysqli_fetch_object($query)){
$s++;
//$sqld = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no;
//$info = mysqli_fetch_row(db_query($sqld));
$dis = $discount[$data->chalan_no];
$sp_dis = $sp_discount[$data->chalan_no];
$sales = $data->total_amt;
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t + $dis;
$sp_dp_t = $sp_dp_t + $sp_dis;
$tp_t = $tp_t + ($sales-$dis);

$actual_sales=($sales-$sp_dis);
$tas+=$actual_sales;
?>
<tr>

<td style="text-align:center"><?=$s?></td> 

<?php /*?><td style="text-align:center"><a href="../../../views/warehouse_mod/wo/delivery_challan_print_view.php?v_no='<?=rawurlencode(url_encode($data->chalan_no));?>'" target="_blank"><?=$data->chalan_no?></a></td><?php */?>

<td style="text-align:center"><a href="../../../views/warehouse_mod/wo/delivery_challan_print_view.php?c='<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($data->chalan_no));?>'" target="_blank"><?=$data->chalan_no?></a></td>

<?php /*?><td style="text-align:center"><a href="../wo/sales_order_print_view.php?v_no='<?=rawurlencode(url_encode($data->do_no));?>'" target="_blank"><?=$data->do_no?></td></td><?php */?>

<td style="text-align:center"><a href="../wo/sales_order_print_view.php?c='<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($data->do_no));?>'" target="_blank"><?=$data->do_no?></td></td>

<td style="text-align:center"><?=$data->do_date?></td>

<td style="text-align:center"><?=$data->chalan_date?></td>
<td style="text-align:center"><?=$data->code?></td>
<td><?=$data->dealer_name?></td>
<td><?=$data->delivery_point?></td>
<td><?=$data->depot?></td>


<td style="text-align:right"><?=number_format(($sales-$dis),2);?></td>
<td style="text-align:right"><?=number_format(($dis*(-1)),2);?></td>

<td style="text-align:right"><?=number_format($actual_sales,2);?></td>
</tr>
<?
}
?><tr ><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="text-align:right"><strong>Total :</strong></td>

<td style="text-align:right"><?=number_format(($tp_t),2)?></td>
<td style="text-align:right"><?=number_format(((-1)*$dp_t),2)?></td>

<td style="text-align:right"><?=number_format($tas,2);?></td>


</tr></tbody></table>
<?
}


elseif($_REQUEST['report']==47) { // supershop closing report nov-16

if(isset($dealer_type)) 		{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';}

if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; 
	$date_con=' and j.jv_date <= UNIX_TIMESTAMP("'.$to_date.'")';}
	else
	$date_con = '';

$dealer_code = $_REQUEST['dealer_code'];

// find out last transeciton details
/*echo $sql2 = "select a.ledger_id, max(j.jv_date) as jv_date, j.cr_amt
from accounts_ledger a, journal j 
where a.ledger_id=j.ledger_id 
".$date_con."
and a.ledger_id like '105100080001%' 
and j.tr_from = 'Receipt'
group by a.ledger_id
";*/


$sql2 = "select j.ledger_id, j.jv_date, j.cr_amt
from journal j 
where 1
".$date_con."
and j.ledger_id like '105100080001%' 
and j.tr_from = 'Receipt'
and j.jv_date in (select max(jv_date) from journal group by ledger_id)
";



	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$ltd[$data2->ledger_id] = $data2->jv_date;
	$ltm[$data2->ledger_id] = $data2->cr_amt;
	}


?>
<center>
<h1>Jamuna Industrial Agro Group</h1>
SuperShop Closing Report<br>
Report Time: <?=date('Y-m-d H:i A')?>
</center>
<p>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
  <tr>
    <td><span class="style9">SL-47</span></td>
    <td>Acc Code</td>
    <td>Party Name </td>
    <td>Closing Balance </td>
    <td>Last Collection Date</td>
	<td>Last Collection Amount </td>
    <td>Diff Days</td>
	<td>Remarks</td>
  </tr>
<?
// list of supershop party
$sql="select DISTINCT a.ledger_id as ledger_id, a.ledger_name, sum(j.dr_amt-j.cr_amt) as closing_amt 
from accounts_ledger a, journal j 
where a.ledger_id=j.ledger_id 
".$date_con."
and a.ledger_group_id='1051' and a.ledger_id like '105100080001%' group by a.ledger_id";
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
//$openings[$data->ledger_id] = $data->amt;

$diff = (int)((time() - $ltd[$data->ledger_id])/(60*60*24));
?>
  <tr>
    <td><?=++$sss?></td>
    <td>C-<?=$data->ledger_id?></td>
    <td><?=$data->ledger_name?></td>
    <td><?=$data->closing_amt?></td>	
	<td><? if($ltd[$data->ledger_id] < '1483228800'){echo ''; $diff='';}else{echo date('Y-m-d',$ltd[$data->ledger_id]);}?></td>
	<td><?=$ltm[$data->ledger_id];?></td>
    <td><?=$diff?></td>
	<td></td>
  </tr>
<? }?>
</table>

<? } 
// end 47 



elseif($_REQUEST['report']==102) { // dealer wise item chalan report

$report="Chalan Detials Report";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; 
	$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_POST['dealer_code']>0) $dealer_code_con= ' and d.dealer_code = "'.$_POST['dealer_code'].'"';
if($_POST['depot_id']!='') $depot_con= ' and c.depot_id = "'.$_POST['depot_id'].'"';

if(isset($region_id)) 	{$region_con=' and d.region_id='.$region_id;}
if(isset($zone_id)) 	{$zone_con=' and d.zone_id='.$zone_id;}


// region list
$sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}

// zone list
$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}

// area list
$sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;}
?>


<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>


<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead>
<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
    <th>SL</th>
    <th>Chalan No </th>
    <th>Chalan Date </th>
    <th>DO NO </th>
    <th>DO Date </th>
	<th>Warehouse Name </th>
	<th>Dealer Name </th>
	<th>Region</th>
	<th>Zone</th>
	<th>Area</th>
	<th>Group</th>
	<th>Category</th>
	<th>FG Code </th>
    <th>Item Name </th>
    <th>Unit</th>
    <th>Packsize</th>
    <th>Ctn</th>
    <th>Pcs</th>
    <th>Total Pcs</th>
    <th>Rate</th>
    <th>Total Amount </th>
  </tr>
</thead><tbody>
<?
$sql='select c.chalan_no,c.chalan_date,c.do_no,c.dealer_code,d.dealer_name_e,i.finish_goods_code as fg_code,
i.item_name,i.unit_name as unit,i.sub_group_id as sub_group,i.pack_size,
c.pkt_unit as ctn,c.dist_unit as pcs,c.total_unit as total_pcs,c.unit_price as rate,total_amt,
d.region_code as region,d.zone_code as zone,d.area_code,c.do_date,c.depot_id,w.warehouse_name

from dealer_info d, sale_do_chalan c, item_info i, warehouse w 
where d.dealer_code=c.dealer_code and c.item_id=i.item_id and w.warehouse_id=c.depot_id
'.$con.$date_con.$depot_con.$item_con.$item_brand_con.$dealer_type_con.$dealer_code_con.$region_con.$zone_con.' 

order by c.chalan_date,c.chalan_no,i.finish_goods_code';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
?>
  <tr>
    <td style="text-align:center"><?=++$sss?></td>
	
   <?php /*?> <td style="text-align:center"><a href="../../../views/warehouse_mod/wo/delivery_challan_print_view.php?v_no='<?=url_encode($data->chalan_no);?>'" target="_blank"><?=$data->chalan_no?></a></td><?php */?>
	
	<td style="text-align:center"><a href="../../../views/warehouse_mod/wo/delivery_challan_print_view.php?c='<?=url_encode($c_id);?>&v=<?=url_encode($data->chalan_no);?>'" target="_blank"><?=$data->chalan_no?></a></td>
	
	
    <td style="text-align:center"><?=$data->chalan_date?></td>
	
    <?php /*?><td style="text-align:center"><a href="../wo/sales_order_print_view.php?v_no='<?=url_encode($data->do_no);?>'" target="_blank"><?=$data->do_no?></td></td><?php */?>
	
	<td style="text-align:center"><a href="../wo/sales_order_print_view.php?c='<?=url_encode($c_id);?>&v=<?=url_encode($data->do_no);?>'" target="_blank"><?=$data->do_no?></td></td>	
	
	<td style="text-align:center"><?=$data->do_date?></td>
	<td><?=$data->warehouse_name?></td>
	<td><?=$data->dealer_name_e?></td>
	
	<td><?=$region_info[$data->region]?></td>
	<td><?=$zone_info[$data->zone]?></td>
	<td><?=$area_info[$data->area_code]?></td>	
	<td><? $subgroupname=find_a_field('item_sub_group','group_id','sub_group_id='.$data->sub_group);
	       echo find_a_field('item_group','group_name','group_id='.$subgroupname);
	?>
	</td>
	<td><?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$data->sub_group);?></td>
	<td style="text-align:center"><?=$data->fg_code?></td>
    <td><?=$data->item_name?></td>
	
    <td style="text-align:center"><?=$data->unit?></td>
    <td style="text-align:center"><?=$data->pack_size?></td>
	
    <td style="text-align:right"><?=number_format($data->ctn,2); $tot_ctn+=$data->ctn; ?></td>
    <td style="text-align:right"><?=number_format($data->pcs,2); $tot_pcs+=$data->pcs;?></td>
    <td style="text-align:right"><?=number_format($data->total_pcs,2); $sub_total_pcs+=$data->total_pcs;?></td>
    <td style="text-align:right"><?=number_format($data->rate,2)?></td>
    <td style="text-align:right"><?=number_format($data->total_amt,2); $tot_amt+=$data->total_amt;?></td>
  </tr>
  
<? }?>

<tr>
  <td style="text-align:right" colspan="16"><strong>Total : </strong></td>
  <td style="text-align:right"><?=number_format($tot_ctn,2);?></td>
  <td style="text-align:right"><?=number_format($tot_pcs,2);?></td>
  <td style="text-align:right"><?=number_format($sub_total_pcs,2);?></td>
  <td></td>
  <td style="text-align:right"><?=number_format($tot_amt,2);?></td>
  </tr>
</table>

<? } 
// end 102




elseif($_REQUEST['report']==72) {

if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code='.$dealer_code;} 

  $sale_sql = "SELECT sum(dr_amt-cr_amt) as total_sales,tr_no,ledger_id,sub_ledger FROM journal WHERE ledger_id = 69 AND tr_from LIKE 'Sales' GROUP BY tr_no";
$sale_query = db_query($sale_sql);
while($sale_data=mysqli_fetch_object($sale_query)){
	$sale_amt[$sale_data->tr_no] = $sale_data->total_sales;
}

 $receipt_sql = "SELECT receipt_no,chalan_no,SUM(receipt_amt) as receipt_amt FROM receipt_from_customer WHERE 1 GROUP BY chalan_no";
$receipt_query = db_query($receipt_sql);
while($receipt_data=mysqli_fetch_object($receipt_query)){
	$receipt_amt[$receipt_data->chalan_no] = $receipt_data->receipt_amt;
}


 $sql="SELECT c.chalan_no,c.chalan_date,m.do_no,m.do_date,d.dealer_code,d.dealer_name_e,DATEDIFF(CURDATE(),c.chalan_date) AS day_difference 
FROM sale_do_chalan c LEFT JOIN sale_do_master m ON m.do_no=c.do_no 
LEFT JOIN dealer_info d ON m.dealer_code=d.dealer_code
where 1 ".$dealer_con." and c.chalan_date between '".$f_date."' and '".$t_date."' GROUP BY c.chalan_no ";


$query = db_query($sql); ?>


<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>


<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead>
<tr>
<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
<tr>
<th>S/L</th>
<th>Chalan No</th>
<th>Chalan Date</th>
<th>Do No</th>
<th>Do Date</th>
<th>Dealer Name</th>
<th>Chalan Amount</th>
<th>Receipt Amount</th>
<th>Due Amount</th>

</tr>
</thead><tbody>

<?
while($data=mysqli_fetch_object($query)){$s++;
?>
<tr>
<td style="text-align:center"><?=$s?></td>
<?php /*?><td style="text-align:center"><a href="../../../views/warehouse_mod/wo/delivery_challan_print_view.php?v_no='<?=url_encode($data->chalan_no);?>'" target="_blank"><?=$data->chalan_no?></a></td><?php */?>

<td style="text-align:center"><a href="../../../views/warehouse_mod/wo/delivery_challan_print_view.php?c='<?=url_encode($c_id);?>&v=<?=url_encode($data->chalan_no);?>'" target="_blank"><?=$data->chalan_no?></a></td>

<td style="text-align:center"><?=$data->chalan_date;?></td>
<?php /*?><td style="text-align:center"><a href="../wo/sales_order_print_view.php?v_no='<?=url_encode($data->do_no);?>'" target="_blank"><?=$data->do_no?></td></td><?php */?>

<td style="text-align:center"><a href="../wo/sales_order_print_view.php?c='<?=url_encode($c_id);?>&v=<?=url_encode($data->do_no);?>'" target="_blank"><?=$data->do_no?></td></td>
<td style="text-align:center"><?=$data->do_date;?></td>
<td><?=$data->dealer_name_e;?></td>
<td style="text-align:right"><?=$total_sale_amt = $sale_amt[$data->chalan_no]; $tot_total_sale_amt += $total_sale_amt;?></td>
<td style="text-align:right"><?=$total_receipt_amt = $receipt_amt[$data->chalan_no]; $tot_total_receipt_amt += $total_receipt_amt;?></td>
<td style="text-align:right"><?=$total_due = $sale_amt[$data->chalan_no]-$receipt_amt[$data->chalan_no]; $tot_total_due += $total_due;?></td>


</tr>
<? } ?>
<tr>
<td colspan="6" align="right"><strong>total:</strong></td>
<td style="text-align:right"><?=$tot_total_sale_amt;?></td>
<td style="text-align:right"><?=$tot_total_receipt_amt;?></td>
<td style="text-align:right"><?=$tot_total_due;?></td>
</tr>

</tbody>
</table>
<br/><br/><br/><br/>


<? 




}



elseif($_REQUEST['report']==73) {


if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code='.$dealer_code;} 

$sql="SELECT j.jv_no,j.tr_no,j.jv_date,j.ledger_id,a.ledger_name,d.dealer_name_e,j.sub_ledger,j.narration,j.received_from,j.cr_amt,j.tr_from FROM journal j LEFT JOIN dealer_info d ON d.sub_ledger_id=j.sub_ledger LEFT JOIN accounts_ledger a ON a.ledger_id=j.ledger_id WHERE 1 and j.jv_date between '".$f_date."' and '".$t_date."' and j.tr_from IN ('Receipt') and j.cr_amt>0";

$query = db_query($sql); 

?>

<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>


<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead>
<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
<tr>
<th>S/L</th>
<th>JV No</th>
<th>Transaction No</th>
<th>JV Date</th>
<th>Ledger ID</th>
<th>Ledger Name</th>
<th>Dealer Name</th>
<th>Sub Ledger</th>
<th>Narration</th>
<th>Received From</th>
<th>Credit Amount</th>
<th>Transaction From</th>
</tr>
</thead><tbody>

<?
while($data=mysqli_fetch_object($query)){$s++;
?>
<tr>
<td style="text-align:center"><?=$s?></td>
<td style="text-align:center"><?=$data->jv_no;?></td>
<td style="text-align:center"><?=$data->tr_no;?></td>
<td style="text-align:center"><?=$data->jv_date;?></td>
<td style="text-align:center"><?=$data->ledger_id;?></td>
<td><?=$data->ledger_name;?></td>
<td><?=$data->dealer_name_e;?></td>
<td style="text-align:center"><?=$data->sub_ledger;?></td>
<td><?=$data->narration;?></td>
<td><?=$data->received_from;?></td>
<td style="text-align:right"><?=$data->cr_amt; $tot_cr += $data->cr_amt; ?></td>
<td><?=$data->tr_from;?></td>
</tr>
<? } ?>
<tr>
<td colspan="10" align="right">Total:</td>
<td style="text-align:right"><?=number_format($tot_cr,2);?></td>
<td></td>
</tr>

</tbody>
</table>
<br/><br/><br/><br/>


<? 

}



elseif($_POST['report']==2024211) {
?>

  <style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style> 
 
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead>
<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>

 <p style="text-align:center;">Category Name: <?php echo find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$item_brand.'"');?></p> 
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>

</td>
</tr>


<tr>
	<th>S/L</th>
	<th>Description</th>
	<th>Quantity</th>
	<th>Avg Rate</th>
	<th>Total Amount</th>
</tr>

</thead>
<tbody>
<?php 

			///////sales////////
		    $op_sql='select sum(total_unit) as tot_sales_qty,sum(total_amt) as tot_sales_amount,item_id,chalan_date,depot_id  from sale_do_chalan where chalan_date between "'.$f_date.'" and "'.$t_date.'" and gift_id<1     group by item_id';
		$op_query=db_query($op_sql);
		while($orow=mysqli_fetch_object($op_query)){
			  $sales_qty_get[$orow->item_id]=$orow->tot_sales_qty;
			   $sales_amount_get[$orow->item_id]=$orow->tot_sales_amount;
			   
		}
		
	  $sql='select * from item_info where sub_group_id in(100010000,100020000)  '.$item_sub_group_con.'';
	$query=db_query($sql);
	while($row=mysqli_fetch_object($query)){ 
	if($sales_qty_get[$row->item_id]>0){$s++;
?>
	<tr>
	<td style="text-align:center"><?=$s?></td>
		<td><?php echo $row->item_name;?></td>
		<td style="text-align:right"><a href="sale_day_wise.php?f_date=<?=$f_date?>&&t_date=<?=$t_date?>&&item_id=<?=$row->item_id?>" target="_blank"><?php echo number_format($sales_qty_get[$row->item_id],3);?></a></td>
		<td style="text-align:right"><?php echo number_format($sales_rate_get=($sales_amount_get[$row->item_id]/$sales_qty_get[$row->item_id]),3);?></td>
		<td style="text-align:right"><?php echo number_format($sales_amount_get[$row->item_id],3);?></td>
	</tr>
	<?php 
	$total_qty+=$sales_qty_get[$row->item_id];
	$total_amount+=$sales_amount_get[$row->item_id];
	} } ?>
	<tr>
		<td></td>
		<td style="text-align:right"><strong>Total :</strong></td>
		<td style="text-align:right"><?php echo number_format($total_qty,2);?></td>
		<td></td>
		<td style="text-align:right"><?php echo number_format($total_amount,2);?></td>
	</tr>
</tbody>
</table>
<?
}




elseif($_REQUEST['report']==402) {
if($_POST['dealer_code']<1){die("select party");}

if($_POST['dealer_code']>0){ $dealer_code=$_POST['dealer_code'];}



$party="select * from dealer_info where dealer_code='".$dealer_code."'";

$query=db_query($party);

while($party_info=mysqli_fetch_object($query)){





$ledger_id=$party_info->sub_ledger_id;



$final_code=$party_info->account_code;



if($_POST['group_for']>0){ $company_con=' and group_for="'.$_POST['group_for'].'"'; 

  $group_name = find_a_field('user_group','group_name','id="'.$_POST['group_for'].'"');

}else{$group_name='CloudERP SAAS';}

$op='';







// nsp chalan amt

//n_amt chilo



  $sql="SELECT chalan_no,sum(total_amt) as amount FROM sale_do_chalan 

WHERE 1 and dealer_code='".$dealer_code."'

group by chalan_no

order by chalan_no";

$query=db_query($sql);

while($row=mysqli_fetch_object($query)){

    $actual_ch_amt[$row->chalan_no]=$row->amount;

}



?>



<div class="row"> 

    

    <div class="col">

    </div>     

</div>

<div class="container mt-2">




<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>


<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

  <thead>
  
  <tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>



<div class="container mt-2">

    

    <div style="text-align:left">

        <span>Code: <?=$party_info->dealer_code2;?></span>
		
		
		<br>
		<span style="font-weight:700;">Sub Ledger: <?=$party_info->sub_ledger_id;?></span>

        <br>
		
		<span>Buyer Name: <?=$party_info->dealer_name_e;?></span><br><span>Address: <?=$party_info->address_e;?></span>

    </div>

    <div style="text-align:left">

        <span>Type: <?=find_a_field('dealer_type','dealer_type','id="'.$party_info->dealer_type.'"');?></span>

        <br><span>Mobile: <?=$party_info->mobile_no;?></span>

        <br><span>Opening Balance: <strong><?

        //$sql_op="select sum(dr_amt-cr_amt) from journal where ledger_id='".$final_code."' and sub_ledger='".$ledger_id."' ".$company_con." and jv_date<'".$_POST['f_date']."'";

        echo $op=(int)find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$final_code.'" and sub_ledger="'.$ledger_id.'" '.$company_con.' and jv_date<"'.$_POST['f_date'].'"');

        ?></strong></span>

    </div>

</div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>

    <tr>
	<th scope="col">S/L</th>

      <th scope="col">Date</th>

      <th scope="col">JV NO</th>

      <th scope="col">Particular</th>

      <th scope="col">Ref. No</th>

      <th scope="col">Company Name</th>

      <th scope="col">JV Type</th>

      <th scope="col">Debit</th>

      <th scope="col">Credit</th>

      <th scope="col">Balance</th>

    </tr>

  </thead>

  <tbody>

<?
 $sql="select * from journal where ledger_id='".$final_code."' and sub_ledger='".$ledger_id."' 
".$company_con." 
and jv_date between '".$_POST['f_date']."' and '".$_POST['t_date']."' order by jv_date";
$query=db_query($sql);
$se=0;
while($data=mysqli_fetch_object($query)){++$se;
?>

    <tr>
	
	<td style="text-align:center"><?=$se?></td>

      <td style="text-align:center"><?=$data->jv_date?></td>

      <td style="text-align:center"><?=$data->jv_no?></td>

      <td><?=$data->narration?></td>

      <td style="text-align:center"><?=$data->tr_no?></td>

      <td></td>

      <td><?=$data->tr_from?></td>

<td style="text-align:right"><? 

if($data->tr_from=='Sales'){

    echo number_format($dr=$actual_ch_amt[$data->tr_no],2); $gdr_amt+=$actual_ch_amt[$data->tr_no];

}else{
    echo number_format($dr=$data->dr_amt,2); $gdr_amt+=$data->dr_amt;
}
?>
</td>
      <td style="text-align:right"><?=number_format($data->cr_amt,2); $gcr_amt+=$data->cr_amt;?></td>
      <td style="text-align:right"><? echo $closing=number_format(($op+$dr-$data->cr_amt),2); 
      $op=$closing;
      ?></td>
    </tr>
<? 
$dr='';
} ?>
<tr class="font-weight-bold">
    <td colspan='7' style="text-align:right"><strong>Grand Total :</strong></td>
    <td style="text-align:right"><?=number_format($gdr_amt,2)?></td>
    <td style="text-align:right"><?=number_format($gcr_amt,2)?></td>
    <td style="text-align:right"><? if($se==0){ echo $op;}else{ echo $closing; }?></td>
</tr>
  </tbody>
</table>
</div>

<? 
}
} // end report



elseif($_POST['report']==404) {

    

$date_con =' and j.jv_date <= "'.$t_date.'" ';



if(isset($dealer_code)) {$dealer_con=' and d.dealer_code='.$dealer_code;}

if(isset($dealer_type)) {$dealer_type_con=' and d.dealer_type='.$dealer_type;}

if($_REQUEST['group_for']>0){ $group_for_con=' and j.group_for="'.$_REQUEST['group_for'].'"';}

if(isset($cor_team)) 	{$cor_team_con=' and d.cor_team="'.$cor_team.'"';} 



// accounts group ledger closing list

  $sql1="select j.ledger_id as code,sum(j.dr_amt-j.cr_amt) as amt,j.sub_ledger 

from journal j,accounts_ledger a

where j.ledger_id=a.ledger_id

".$date_con.$group_for_con."

group by j.ledger_id,j.sub_ledger

";

$query1 = db_query($sql1);

while($data1=mysqli_fetch_object($query1)){

  $balance[$data1->code][$data1->sub_ledger]=$data1->amt;
}



?>


<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>

<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>

<tr>

    <th>S/L</th>

    <th>Dealer Code</th>

    <th>Account Code</th>

    <th>Dealer Name</th>

    <th>Dealer Address</th>

    <th>Dealer Mobile</th>

    <th>Closing Balance</th>

</tr>

</thead><tbody>

<?

// dealer list

 $sqls="select d.dealer_code,d.dealer_code2,d.sub_ledger_id,d.account_code,d.dealer_name_e,d.address_e,d.contact_no

from dealer_info d

where 1

".$dealer_con.$dealer_type_con.$location.$cor_team_con." 

order by dealer_name_e";



$query = db_query($sqls);

while($data=mysqli_fetch_object($query)){

$s++;



?>

<tr>

<td style="text-align:center"><?=$s?></td>

<td style="text-align:center"><?=$data->dealer_code?></td>

<td style="text-align:center"><?=$data->sub_ledger_id?></td>

<td><?=$data->dealer_name_e?></td>

<td><?=$data->address_e?></td>

<td><?=$data->mobile_no?></td>

<td style="text-align:right"> <?=$balance[$data->account_code][$data->sub_ledger_id]; $gamt+=$balance[$data->account_code][$data->sub_ledger_id];?></td>



</tr>

<?

}

?>
<tr >

<td colspan="6" style="text-align:right"><strong>Total :</strong></td>

<td style="text-align:right"><?=number_format(($gamt),2)?></td>

</tr></tbody></table>

<?

}




else if($_REQUEST['report']==15051){ 


if($_POST['item_id'])				{$item_con=' and i.item_id='.$_POST['item_id'];} 

if($_REQUEST['dealer_code']>0) 			{$dealer_con=' and de.dealer_code="'.$_REQUEST['dealer_code'].'"';}


if($_GET['sub_group_id']!= '')		{$brand_category_con=' and i.sub_group_id="'.$_GET['sub_group_id'].'"';}

if($_REQUEST['t_date']!= '') 			{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 





 	 $sql="select i.item_id,i.item_name,i.unit_name,i.sub_group_id,  m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(d.total_amt) total_unit from item_info i, sale_do_details d , sale_do_master m, dealer_info de  where d.dealer_code=de.dealer_code and  d.do_no=m.do_no and m.status !='MANUAL' and d.unit_price > 0 ".$date_con.$item_con.$dealer_con.$brand_category_con." and m.status in ('COMPLETED','PROCESSING','CHECKED','UNCHECKED')  and  d.item_id=i.item_id GROUP by i.item_id,concat(date_format(m.do_date,'%Y%m')) order by i.item_id";


$query = db_query($sql);

while($datas=mysqli_fetch_object($query)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->item_id][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->sub_group_id;
			$unit[$datas->item_id]= $datas->unit_name;


}



?>

<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>
<table width="100%" cellspacing="0" cellpadding="2" border="0">



<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>



<tr>

<th rowspan="2"style="text-align:center !important;">S/L</th>
<th rowspan="2"style="text-align:center !important;">Item ID</th>

<th width="35%" rowspan="2"style="text-align:center !important;">Item Name</th>
<th rowspan="2"style="text-align:center !important;">Brand Category</th>

<th rowspan="2"style="text-align:center !important;">Unit</th>

<th colspan="<?=$c;?>" style="text-align:center !important;">Monthly sales History in Amount</th>

<th rowspan="2"style="text-align:center !important;">Total Amount</th>



</tr>

<tr>
<? for($p=1;$p<=$c;$p++){?><td><?=$period_name[$p]?></td><? } ?>
</tr>

<? 



  $sql2="select i.item_id,i.item_name,i.sub_group_id,  m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(d.total_unit) total_unit from item_info i, sale_do_details d , sale_do_master m, dealer_info de  where d.dealer_code=de.dealer_code and  d.do_no=m.do_no  and m.status !='MANUAL' and d.unit_price > 0  ".$date_con.$item_con.$dealer_con.$brand_category_con."  and m.status in ('COMPLETED','PROCESSING','CHECKED','UNCHECKED')  and  d.item_id=i.item_id GROUP by i.item_id order by i.item_id";



 

$query2 = db_query($sql2);

while($data=mysqli_fetch_object($query2))
{
$sl++;

 ?>
  
  <tr>
  	<td style="text-align:center"><?=$sl;?></td>
	<td style="text-align:center"><?=$data->item_id;?></td>
  	<td><?=$item_name[$data->item_id];?></td>
	<td><?=$brand[$data->item_id]?></td>
	<td style="text-align:center"><?=$unit[$data->item_id]?></td>
	
<? for($p=1;$p<=$c;$p++){?>
<td style="text-align:right"><?=$p_total[$p]=$item_qty[$data->item_id][$priod[$p]];

$y_total[$data->item_id]+=$p_total[$p];

?></td>


<? } ?>
<td style="text-align:right"><?=number_format($y_total[$data->item_id],8); $g_final_total +=$y_total[$data->item_id];?></td>

	
  </tr>
<? } ?>

<tbody>

<tr>

<td style="text-align:right" colspan="<?=5?>"><strong>Total :</strong></td>

<td colspan="<?=$c?>"></td>

<td style="text-align:right"><?=number_format($g_final_total,8)?></td>

</tr>

</tbody>

</table>


<?
}



else if($_REQUEST['report']==150519){ // Monthly do summery report modify may 15 2019


if($_POST['item_id'])				{$item_con=' and i.item_id='.$_POST['item_id'];} 

if($_REQUEST['dealer_id']>0) 			{$dealer_con=' and de.dealer_code="'.$_REQUEST['dealer_id'].'"';}
if($_REQUEST['t_date']!= '') 			{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

 


  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 



 
 	$sql="select i.item_id,i.item_name,i.unit_name,i.sub_group_id,  m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(d.total_amt) total_unit from item_info i, sale_do_details d , sale_do_master m, dealer_info de  where d.dealer_code=de.dealer_code and  d.do_no=m.do_no and m.status !='MANUAL' and d.unit_price > 0 ".$date_con.$item_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED','UNCHECKED')  and  d.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')), i.sub_group_id";

$query = db_query($sql);

while($datas=mysqli_fetch_object($query)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->brand_category][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->sub_group_id;
			$unit[$datas->item_id]= $datas->unit_name;


}



?>


<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>

<table width="100%" cellspacing="0" cellpadding="2" border="0">



<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>


<tr>

<th rowspan="2"style="text-align:center !important;">S/L</th>


<th rowspan="2"style="text-align:center !important;">Brand Category</th>


<th colspan="<?=$c;?>" style="text-align:center !important;">Monthly sales History in Amount</th>

<th rowspan="2"style="text-align:center !important;">Total Amount</th>



</tr>

<tr>
<? for($p=1;$p<=$c;$p++){?><td style="text-align:center"><?=$period_name[$p]?></td><? } ?>
</tr>

<? 




 $sql2="select i.item_id,i.item_name,i.sub_group_id,  m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(d.total_unit) total_unit from item_info i, sale_do_details d , sale_do_master m, dealer_info de  where d.dealer_code=de.dealer_code and  d.do_no=m.do_no  and m.status !='MANUAL' and d.unit_price > 0  ".$date_con.$item_con.$dealer_con."  and m.status in ('COMPLETED','PROCESSING','CHECKED','UNCHECKED')  and  d.item_id=i.item_id GROUP by i.sub_group_id";
	


$query2 = db_query($sql2);

while($data=mysqli_fetch_object($query2))
{
$sl++;

 ?>
  
  <tr>
  	<td style="text-align:center"><?=$sl;?></td>

	
	<?php /*?><td> <a href="master_report.php?report=15051&sub_group_id=<?=str_replace('&','zzz',$data->sub_group_id)?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>" target="_blank"><?=$data->sub_group_id?></a></td><?php */?>
	
	<td style="text-align:center"><?=$data->sub_group_id?></td>
	
<? for($p=1;$p<=$c;$p++){?>
<td style="text-align:right"><?=$p_total[$p]=$item_qty[$data->brand_category][$priod[$p]];

$y_total[$data->brand_category]+=$p_total[$p];

?></td>


<? } ?>
<td style="text-align:right"><?=number_format($y_total[$data->brand_category],8); $g_final_total +=$y_total[$data->brand_category];?></td>

	
  </tr>
<? } ?>

<tbody>


<tr>

<td colspan="<?=2?>" style="text-align:right"> <strong>Total :</strong></td>

<td colspan="<?=$c?>" style="text-align:right"></td>

<td style="text-align:right"><?=number_format($g_final_total,8)?></td>

</tr>

</tbody>

</table>


<?

}



else if($_REQUEST['report']==1505191){ // Monthly do summery report modify may 15 2019


if($_POST['item_id'])				{$item_con=' and i.item_id='.$_POST['item_id'];} 
if($_REQUEST['t_date']!= '') 			{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 



$sql="select i.item_id,i.item_name,i.unit_name,i.sub_group_id,  m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(d.total_unit) total_unit from item_info i, sale_do_details d , sale_do_master m, dealer_info de  where d.dealer_code=de.dealer_code and  d.do_no=m.do_no and  m.status!='MANUAL' and d.unit_price > 0 ".$date_con.$item_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED','UNCHECKED')  and  d.item_id=i.item_id GROUP by  concat(date_format(m.do_date,'%Y%m')),i.sub_group_id";


$query = db_query($sql);

while($datas=mysqli_fetch_object($query)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->brand_category][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->sub_group_id;
			$unit[$datas->item_id]= $datas->unit_name;


}



?>

<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>

<table width="100%" cellspacing="0" cellpadding="2" border="0">



<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>



<tr>

<th rowspan="2"style="text-align:center !important;">S/L</th>

<th rowspan="2"style="text-align:center !important;">Brand Category</th>

<th colspan="<?=$c;?>" style="text-align:center !important;">Monthly sales History in PCS</th>

<th rowspan="2"style="text-align:center !important;">Total Pcs</th>



</tr>

<tr style="text-align:center">
<? for($p=1;$p<=$c;$p++){?><td><?=$period_name[$p]?></td><? } ?>
</tr>

<? 

 
 
	
$sql2="select i.item_id,i.item_name,i.sub_group_id,  m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(d.total_unit) total_unit from item_info i, sale_do_details d , sale_do_master m, dealer_info de  where d.dealer_code=de.dealer_code and  d.do_no=m.do_no and m.status!='MANUAL' and d.unit_price > 0 ".$date_con.$item_con.$dealer_con."  and m.status in ('COMPLETED','PROCESSING','CHECKED','UNCHECKED')  and  d.item_id=i.item_id GROUP by  i.sub_group_id";

 

$query2 = db_query($sql2);

while($data=mysqli_fetch_object($query2))
{
$sl++;

 ?>
  
  <tr>
  	<td style="text-align:center"><?=$sl;?></td>
	<?php /*?><td> <a href="master_report.php?report=15051&sub_group_id=<?=urlencode($data->sub_group_id)?>&depot_type=<?=$depot_type?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>" target="_blank"><?=$data->sub_group_id?></a></td><?php */?>
	
<td style="text-align:center"><?=$data->sub_group_id?></td>	
<? for($p=1;$p<=$c;$p++){?>
<td style="text-align:right"><?=$p_total[$p]=$item_qty[$data->brand_category][$priod[$p]];

$y_total[$data->brand_category]+=$p_total[$p];

?></td>


<? } ?>
<td style="text-align:right"><?=number_format($y_total[$data->brand_category],2); $g_final_total +=$y_total[$data->brand_category];?></td>

	
  </tr>
<? } ?>

<tbody>

<tr>

<td colspan="<?=2?>" style="text-align:right"><strong>Total :</strong></td>

<td colspan="<?=$c?>" style="text-align:right"></td>

<td style="text-align:right"><?=number_format($g_final_total,2)?></td>

</tr>

</tbody>

</table>


<?
}


else if($_REQUEST['report']==15051911){ // Monthly do summery report modify may 15 2019


if($_POST['item_id'])				{$item_con=' and i.item_id='.$_POST['item_id'];} 



if($_REQUEST['t_date']!= '') 			{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 



	
   $sql="select i.item_id,i.item_name,i.unit_name,i.sub_group_id,  m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(d.total_unit / i.pack_size) total_unit ,i.pack_size from item_info i, sale_do_details d , sale_do_master m, dealer_info de  where d.dealer_code=de.dealer_code and  d.do_no=m.do_no  and m.status!='MANUAL' and d.unit_price > 0  ".$date_con.$item_con." and m.status in ('COMPLETED','PROCESSING','CHECKED','UNCHECKED')  and  d.item_id=i.item_id GROUP by  concat(date_format(m.do_date,'%Y%m')), i.sub_group_id";


$query = db_query($sql);

while($datas=mysqli_fetch_object($query)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			
			
			
			$item_qty[$datas->brand_category][$datas->month]=$datas->total_unit;
			
			$brand[$datas->item_id]= $datas->sub_group_id;
			$unit[$datas->item_id]= $datas->unit_name;


}



?>

<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>

<table width="100%" cellspacing="0" cellpadding="2" border="0">



<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>


<tr>

<th rowspan="2"style="text-align:center !important;">S/L</th>


<th rowspan="2"style="text-align:center !important;">Brand Category</th>


<th colspan="<?=$c;?>" style="text-align:center !important;">Monthly sales History in Ctn</th>

<th rowspan="2"style="text-align:center !important;">Total Pcs</th>



</tr>

<tr style="text-align:center">
<? for($p=1;$p<=$c;$p++){?><td><?=$period_name[$p]?></td><? } ?>
</tr>

<? 



	

$sql2="select i.item_id,i.item_name,i.sub_group_id,i.pack_size,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(d.total_unit / i.pack_size) total_unit from item_info i, sale_do_details d,sale_do_master m, dealer_info de  where d.dealer_code=de.dealer_code and  d.do_no=m.do_no and m.status!='MANUAL' ".$date_con.$item_con."  and m.status in ('COMPLETED','PROCESSING','CHECKED','UNCHECKED')  and  d.item_id=i.item_id GROUP by i.sub_group_id";
 

 
 

$query2 = db_query($sql2);

while($data=mysqli_fetch_object($query2))
{
$sl++;

 ?>
  
  <tr>
  	<td style="text-align:center"><?=$sl;?></td>

	<?php /*?><td> <a href="master_report.php?report=15051&sub_group_id=<?=$data->sub_group_id?>&depot_type=<?=$depot_type?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>" target="_blank"><?=$data->sub_group_id?></a></td><?php */?>
	
	<td style="text-align:center"><?=$data->sub_group_id?></td>

	
<? for($p=1;$p<=$c;$p++){?>
<td style="text-align:right"><?=$p_total[$p]=$item_qty[$data->brand_category][$priod[$p]];
$y_total[$data->brand_category]+=$p_total[$p];

?></td>


<? } ?>
<td style="text-align:right"><?=number_format($y_total[$data->brand_category],2); $g_final_total +=$y_total[$data->brand_category];?></td>

	
  </tr>
<? } ?>

<tbody>

<tr >

<td colspan="<?=2?>" style="text-align:right"><strong>Total :</strong></td>

<td colspan="<?=$c?>" style="text-align:right"></td>

<td style="text-align:right"><?=number_format($g_final_total,2)?></td>

</tr>

</tbody>

</table>


<?
}




elseif($_REQUEST['report']==15427) { // dealer wise item chalan report

	$report="Sales Vs  Consumption  Report";
	if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; 
		$date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		
	if($_POST['dealer_code']>0) $dealer_code_con= ' and d.dealer_code = "'.$_POST['dealer_code'].'"';
	if($_POST['depot_id']!='') $depot_con= ' and c.depot_id = "'.$_POST['depot_id'].'"';
	
	if(isset($region_id)) 	{$region_con=' and d.region_id='.$region_id;}
	if(isset($zone_id)) 	{$zone_con=' and d.zone_id='.$zone_id;}
	
	
	// region list
	$sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
	$query = db_query($sql);
	while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}
	
	// zone list
	$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
	$query = db_query($sql);
	while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}
	
	// area list
	$sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
	$query = db_query($sql);
	while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;}
	?>
	
	
	<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>
	
	
	<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
	<thead>
	<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
	<tr>
		<th>SL</th>
		<th>Chalan No </th>
		<th>Chalan Date </th>
		<th>DO NO </th>
		<th>DO Date </th>
		<th>Warehouse Name </th>
		<th>Dealer Name </th>
		<th>Region</th>
		<th>Zone</th>
		<th>Area</th>
		<th>Group</th>
		<th>Category</th>
		<th>FG Code </th>
		<th>Item Name </th>
		<th>Unit</th>
		<th>Packsize</th>
		<th>Ctn</th>
		<th>Pcs</th>
		<th>Total Pcs</th>
		<th>Rate</th>
		<th>Net Sales</th>
		<th>Cost Rate</th>
		<th>Cost Amount</th>
	  </tr>
	</thead><tbody>
	<?
	 $sql='select c.chalan_no,c.chalan_date,c.do_no,c.dealer_code,d.dealer_name_e,i.finish_goods_code as fg_code,
	i.item_name,i.unit_name as unit,i.sub_group_id as sub_group,i.pack_size,
	c.pkt_unit as ctn,c.dist_unit as pcs,c.total_unit as total_pcs,c.unit_price as rate,total_amt,c.cost_price,c.cost_amt,
	d.region_code as region,d.zone_code as zone,d.area_code,c.do_date,c.depot_id,w.warehouse_name
	
	from dealer_info d, sale_do_chalan c, item_info i, warehouse w 
	where d.dealer_code=c.dealer_code and c.item_id=i.item_id and w.warehouse_id=c.depot_id
	'.$con.$date_con.$depot_con.$item_con.$item_brand_con.$dealer_type_con.$dealer_code_con.$region_con.$zone_con.' 
	
	order by c.chalan_date,c.chalan_no,i.finish_goods_code';
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query)){
	?>
	  <tr>
		<td style="text-align:center"><?=++$sss?></td>
		
		<?php /*?><td style="text-align:center"><a href="../../../views/warehouse_mod/wo/delivery_challan_print_view.php?v_no='<?=url_encode($data->chalan_no);?>'" target="_blank"><?=$data->chalan_no?></a></td><?php */?>
		
		<td style="text-align:center"><a href="../../../views/warehouse_mod/wo/delivery_challan_print_view.php?c='<?=url_encode($c_id);?>&v=<?=url_encode($data->chalan_no);?>'" target="_blank"><?=$data->chalan_no?></a></td>
		
		<td style="text-align:center"><?=$data->chalan_date?></td>
<?php /*?>		<td style="text-align:center"><a href="../wo/sales_order_print_view.php?v_no='<?=url_encode($data->do_no);?>"' target="_blank"><?=$data->do_no?></td></td>	<?php */?>
		<td style="text-align:center"><a href="../wo/sales_order_print_view.php?c='<?=url_encode($c_id);?>&v=<?=url_encode($data->do_no);?>"' target="_blank"><?=$data->do_no?></td></td>	
		<td style="text-align:center"><?=$data->do_date?></td>
		<td><?=$data->warehouse_name?></td>
		<td><?=$data->dealer_name_e?></td>
		
		<td><?=$region_info[$data->region]?></td>
		<td><?=$zone_info[$data->zone]?></td>
		<td><?=$area_info[$data->area_code]?></td>	
		<td><? $subgroupname=find_a_field('item_sub_group','group_id','sub_group_id='.$data->sub_group);
			   echo find_a_field('item_group','group_name','group_id='.$subgroupname);
		?>
		</td>
		<td><?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$data->sub_group);?></td>
		<td style="text-align:center"><?=$data->fg_code?></td>
		<td><?=$data->item_name?></td>
		
		<td style="text-align:center"><?=$data->unit?></td>
		<td style="text-align:center"><?=$data->pack_size?></td>
		
		<td style="text-align:right"><?=number_format($data->ctn,2); $tot_ctn+=$data->ctn;?></td>
		<td style="text-align:right"><?=number_format($data->pcs,2); $tot_pcs+=$data->pcs;?></td>
		<td style="text-align:right"><?=number_format($data->total_pcs,2); $sub_tot_pcs+=$data->total_pcs;?></td>
		<td style="text-align:right"><?=number_format($data->rate,2)?></td>
		<td style="text-align:right"><?=number_format($data->total_amt,2); $tot_amt+=$data->total_amt;?></td>
		<td style="text-align:right"><?=number_format($data->cost_price,)?></td>
		<td style="text-align:right"><?=number_format($data->cost_amt,2); $tot_c_amt+=$data->cost_amt;?></td>
	  </tr>
	  
	<? }?>
	
	<tr>
	  <td style="text-align:right" colspan="16"><strong>Total :</strong></td>
	   <td style="text-align:right"> <?=number_format($tot_ctn,2);?></td>
	    <td style="text-align:right"><?=number_format($tot_pcs,2);?></td>
		 <td style="text-align:right"><?=number_format($sub_tot_pcs,2);?></td>
		  <td></td>
	  <td style="text-align:right"><?=number_format($tot_amt,2);?></td>
	  <td></td>
	  <td style="text-align:right"><?=number_format($tot_c_amt,2);?></td>
	  </tr>
	</table>
	
	<? } 
	// end 15427
	

elseif($_REQUEST['report']==48) { // corporate closing report nov-16

if(isset($dealer_type)) 		{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';}

if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; 
	$date_con=' and j.jv_date <= UNIX_TIMESTAMP("'.$to_date.'")';}
	else
	$date_con = '';

$dealer_code = $_REQUEST['dealer_code'];



$sql2 = "select j.ledger_id, j.jv_date, j.cr_amt
from journal j 
where 1
".$date_con."
and j.ledger_id like '105100080002%' 
and j.tr_from = 'Receipt'
and j.jv_date in (select max(jv_date) from journal group by ledger_id)
";



	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$ltd[$data2->ledger_id] = $data2->jv_date;
	$ltm[$data2->ledger_id] = $data2->cr_amt;
	}


?>
<center>
<h1>Jamuna Industrial Agro Group</h1>
Corporate Closing Report<br>
Report Time: <?=date('Y-m-d H:i A')?>
</center>
<p>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
  <tr>
    <td><span class="style9">SL-48</span></td>
    <td>Acc Code</td>
    <td>Party Name </td>
    <td>Closing Balance </td>
    <td>Last Collection Date</td>
	<td>Last Collection Amount </td>
    <td>Diff Days</td>
	<td>Remarks</td>
  </tr>
<?
// list of supershop party
$sql="select DISTINCT a.ledger_id as ledger_id, a.ledger_name, sum(j.dr_amt-j.cr_amt) as closing_amt 
from accounts_ledger a, journal j 
where a.ledger_id=j.ledger_id 
".$date_con."
and a.ledger_group_id='1051' and a.ledger_id like '105100080002%' group by a.ledger_id";
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
//$openings[$data->ledger_id] = $data->amt;

$diff = (int)((time() - $ltd[$data->ledger_id])/(60*60*24));
?>
  <tr>
    <td><?=++$sss?></td>
    <td>C-<?=$data->ledger_id?></td>
    <td><?=$data->ledger_name?></td>
    <td><?=$data->closing_amt?></td>	
	<td><? if($ltd[$data->ledger_id] < '1483228800'){echo ''; $diff='';}else{echo date('Y-m-d',$ltd[$data->ledger_id]);}?></td>
	<td><?=$ltm[$data->ledger_id];?></td>
    <td><?=$diff?></td>
	<td></td>
  </tr>
<? }?>
</table>

<? } 
// end 48



elseif($_POST['report']==15) {

		if(isset($dealer_type)){
		if($dealer_type=='MordernTrade')		{$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
		else 									{$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}
		}
if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';} 

$sqld1 = "select sum(total_amt) as total_amt,chalan_no 
from sale_do_master m,sale_do_chalan c,dealer_info d , warehouse w
where m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and unit_price<0 
".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." 
";
$query1 = db_query($sqld1);
while($info1 = mysqli_fetch_row($query1)){
$discount=$info1[0];
}

// Special Discount
$sqld1 = "select dr_amt as total_amt, tr_no 
from sale_do_master m,sale_do_chalan c,dealer_info d, journal j, warehouse w
where j.tr_from = 'Sales' and j.tr_no = c.chalan_no and  j.ledger_id='4014000800040000' and m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con."  group by chalan_no order by c.chalan_no";
$query1 = db_query($sqld1);
while($spd = mysqli_fetch_object($query1)){
$sp_diss[$spd->tr_no] = $spd->total_amt;
$sp_discount = $sp_discount + $sp_diss[$spd->tr_no];
}
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="10"><?=$str?></td></tr><tr>
<th>S/L-15</th>
<th>Sales Total</th>
<th>Dis</th>
<th>Sp. Dis</th>
<th>Actual Sales </th>
</tr></thead>
<tbody>
<?
$sqls="select sum(c.total_amt) as total_amt 
from sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w
where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id 
".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." 
";
$query = db_query($sqls);
while($data=mysqli_fetch_object($query)){

$s++;
$sales = $data->total_amt;
$dis = $discount;
$sp_dis = $sp_discount;
$actual_sales=($sales-$sp_dis);
?>
<tr>
<td><?=$s?></td>
<td><?=number_format(($sales-$dis),2);?></td>
<td><?=number_format(($dis*(-1)),2);?></td>
<td><?=number_format(($sp_dis),2);?></td>
<td><?=number_format($actual_sales,2);?></td>
</tr>
<? } ?>
</tbody></table>
<?
}
// end 15




elseif($_POST['report']==10101) 
{
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.entry_at between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';} 
$sqld1 = "select sum(total_amt) as total_amt,chalan_no from 
sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w
where c.chalan_type='Return' and m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and unit_price<0 ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." group by chalan_no order by c.chalan_no";
$query1 = db_query($sqld1);
while($info1 = mysqli_fetch_row($query1))
{
$discount[$info1[1]] = $info1[0];
}



$sqls="select c.chalan_no,m.do_no,m.do_date,c.driver_name as serial_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp,sum(total_amt) as total_amt,c.entry_at from 
sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w
where c.chalan_type='Return' and  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." group by chalan_no order by c.chalan_no";

$query = db_query($sqls);
?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="10"><?=$str?></td></tr><tr><th>S/L</th><th>Chalan No</th><th>Do No</th><th>Do Date</th><th>Serial No</th>
  <th>Adjust Date</th>
  <th>Chalan Date</th><th>Dealer Name</th><th>Area</th><th>Depot</th><th>Grp</th>
<th>Return Total</th>
</tr></thead>
<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;
//$sqld = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no;
//$info = mysqli_fetch_row(db_query($sqld));

$dis = $discount[$data->chalan_no];
$sales = $data->total_amt;
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t + $dis;
//$tp_t = $tp_t + ($sales-$dis);
$tp_t = $tp_t + $sales;
?>
<tr><td><?=$s?></td><td><?=$data->chalan_no?></td><td><?=$data->do_no?></td><td><?=$data->do_date?></td><td><?=$data->serial_no?></td>
  <td><?=date("Y-m-d",strtotime($data->entry_at))?></td>
  <td><?=$data->chalan_date?></td><td><?=$data->dealer_name?></td><td><?=$data->area?></td><td><?=$data->depot?></td><td><?=$data->grp?></td><td><?=number_format(($sales*(-1)),2);?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td>
<td><?=number_format(($tp_t)*(-1),2)?></td>
</tr></tbody></table>
<?
}





elseif($_POST['report']==10001) 
{
if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';}
if(isset($region_id)) 	{$region_con=' and d.region_id='.$region_id;}
if(isset($zone_id)) 	{$zone_con=' and d.zone_id='.$zone_id;} 

$sqls="select c.chalan_no,m.do_no,m.do_date,c.driver_name as serial_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp,total_unit,total_unit*i.d_price as total_amt, total_amt as sales_amt, i.pack_size,c.unit_price 

from sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w, item_info i
where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and c.item_id=i.item_id and c.item_id='".$item_id."' 
".$depot_con.$date_con.$dealer_con.$dealer_type_con.$region_con.$zone_con." order by c.chalan_no";

$query = db_query($sqls);
?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="8"><?=$str?></td></tr><tr><th>S/Lsss</th><th>Chalan No</th>
  <th>Chalan Date</th>
  <th>Do No</th><th>Serial No</th><th>Dealer Name</th><th>Area</th><th>Depot</th>
  <th>Rate</th>
  <th>Ctn</th>
  <th>Pcs</th>
  <th>Sales Amt</th>
  <th>Ctn(Free)</th>
  <th>Pcs(Free)</th>
  <th>Free Amt</th>
  <th>DP AMT</th>
</tr></thead>
<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;
$free = 0;$free_amt = 0;
$sales = 0;
$full_total_amt = $full_total_amt + $data->total_amt;
$full_sales_amt = $full_sales_amt + $data->sales_amt;

$pack_size = $data->pack_size;

if($data->unit_price==0){
$free_amt = $data->total_amt;
$free = $data->total_unit;
$sales = 0;
$full_free_unit = $full_free_unit + $data->total_unit;
$full_free_amt = $full_free_amt + $data->total_amt;
}
else
{
$full_total_unit = $full_total_unit + $data->total_unit;
$free = 0;
$sales = $data->total_unit;
}
?>
<tr><td><?=$s?></td><td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
  <td><?=$data->chalan_date?></td>
  <td><?=$data->do_no?></td><td><?=$data->serial_no?></td><td><?=$data->dealer_name?></td><td><?=$data->area?></td><td><?=$data->depot?></td>
  <td><?=($data->unit_price)?></td>
  <td><?=(int)($sales/$data->pack_size)?></td><td><?=(int)($sales%$data->pack_size)?></td>
  <td style="text-align:right"><?=number_format(($data->sales_amt),2);?></td>
  <td><?=(int)($free/$data->pack_size)?></td>
  <td><?=(int)($free%$data->pack_size)?></td>
  <td style="text-align:right"><?=number_format(($free_amt),2);?></td>
  <td style="text-align:right"><?=number_format(($data->total_amt),2);?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><?=(int)@($full_total_unit/$pack_size)?></td>
<td><?=(int)@($full_total_unit%$pack_size)?></td>

<td style="text-align:right"><?=number_format($full_sales_amt,2)?></td>
<td><?=(int)@($full_free_unit/$pack_size)?></td>
<td><?=(int)@($full_free_unit%$pack_size)?></td>
<td style="text-align:right"><?=number_format($full_free_amt,2)?></td>
<td style="text-align:right"><?=number_format($full_total_amt,2)?></td>
</tr></tbody></table>
<?
}




elseif($_POST['report']==10002) 
{
if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';} 
if(isset($region_id)) 	{$region_con=' and d.region_id='.$region_id;}
if(isset($zone_id)) 	{$zone_con=' and d.zone_id='.$zone_id;}


$sqls="select c.chalan_no,m.do_no,m.do_date,c.driver_name as serial_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp,total_unit,total_unit*i.d_price as total_amt, total_amt as sales_amt, i.pack_size from 
sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w, item_info i
where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and c.item_id=i.item_id and c.item_id='".$item_id."' 
".$depot_con.$date_con.$dealer_con.$dealer_type_con.$region_con.$zone_con." order by c.chalan_no";

$query = db_query($sqls);
?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="8"><?=$str?></td></tr><tr><th>S/L</th><th>Chalan No</th>
  <th>Chalan Date</th>
  <th>Do No</th><th>Serial No</th><th>Dealer Name</th><th>Area</th><th>Depot</th>
  <th>Ctn</th>
  <th>Pcs</th>
  <th>Sales Amt</th>
  <th>Ctn(Free)</th>
  <th>Pcs(Free)</th>
  <th>Free Amt</th>
  <th>DP AMT</th>
</tr></thead>
<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;
$free = 0;$free_amt = 0;
$sales = 0;
$full_total_amt = $full_total_amt + $data->total_amt;
$full_sales_amt = $full_sales_amt + $data->sales_amt;

$pack_size = $data->pack_size;

if($data->sales_amt<1&&$data->total_unit>0){
$free_amt = $data->total_amt;
$free = $data->total_unit;
$sales = 0;
$full_free_unit = $full_free_unit + $data->total_unit;
$full_free_amt = $full_free_amt + $data->total_amt;
}
else
{
$full_total_unit = $full_total_unit + $data->total_unit;
$free = 0;
$sales = $data->total_unit;
}
?>
<tr><td><?=$s?></td><td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
  <td><?=$data->chalan_date?></td>
  <td><?=$data->do_no?></td><td><?=$data->serial_no?></td><td><?=$data->dealer_name?></td><td><?=$data->area?></td><td><?=$data->depot?></td><td><?=(int)($sales/$data->pack_size)?></td><td><?=(int)($sales%$data->pack_size)?></td>
  <td style="text-align:right"><?=number_format(($data->sales_amt),2);?></td>
  <td><?=(int)($free/$data->pack_size)?></td>
  <td><?=(int)($free%$data->pack_size)?></td>
  <td style="text-align:right"><?=number_format(($free_amt),2);?></td>
  <td style="text-align:right"><?=number_format(($data->total_amt),2);?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=(int)@($full_total_unit/$pack_size)?></td>
<td><?=(int)@($full_total_unit%$pack_size)?></td>

<td style="text-align:right"><?=number_format($full_sales_amt,2)?></td>
<td><?=(int)@($full_free_unit/$pack_size)?></td>
<td><?=(int)@($full_free_unit%$pack_size)?></td>
<td style="text-align:right"><?=number_format($full_free_amt,2)?></td>
<td style="text-align:right"><?=number_format($full_total_amt,2)?></td>
</tr></tbody></table>
<?
}




elseif($_POST['report']==1006) 
{
			if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
			elseif(isset($item_id)) 			{$item_sub_con=' and i.item_id='.$item_id;} 
			
			if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 
			
			if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; $date_con=' and ji_date <= "'.$to_date.'"';}
			if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; $date_conr=' and req_date <= "'.$to_date.'"';}
		
		$sql='select distinct i.item_id,i.unit_name,i.item_name,"Finished Goods",i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 
		   from item_info i where i.finish_goods_code!=2000 and i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' and i.item_brand = "Promotional" order by i.sales_item_type';
		   
		$query =db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr>
<td style="border:0px;" colspan="9">
<div class="header"><h1>Jamuna Industrial Agro Group</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date-<?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>
<tr>
<th>S/L-1006</th>
<th>Brand</th>
<th>FG</th>
<th>Item Name</th>
<th>Group</th>
<th>Unit</th>
<th>Dhaka</th>
<th>Gazipur</th>
<th>Chittagong</th>
<th>Borisal</th>
<th>Bogura</th>
<th>Sylhet</th>
<th>Jessore</th>
<th>Rangpur</th>
<th>Comilla</th>
<th>Total</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){


	$dhaka = 	(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="3"'));
	$ctg = 		(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="6"'));
	$sylhet =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"'));
	$bogura =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="7"'));
	$borisal =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="8"'));
	$jessore =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="10"'));
	$gajipur =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="54"'));
	$rangpur =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="89"'));
	$comilla =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="90"'));
	$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore + $gajipur + $rangpur + $comilla;	      
	
	//echo $sql = 'select sum(item_in-item_ex) from journal_item where item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"';

?>
<tr>
	<td><?=++$j?></td>
	<td><?=$data->item_brand?></td>
	<td><?=$data->finish_goods_code?></td>
	<td><?=$data->item_name?></td>
	<td><?=$data->sales_item_type?></td>
	<td><?=$data->unit_name?></td>
	<td style="text-align:right"><?=(int)$dhaka?></td>
	<td style="text-align:right"><?=(int)$gajipur?></td>
	<td style="text-align:right"><?=(int)$ctg?></td>
	<td style="text-align:right"><?=(int)$borisal?></td>
	<td style="text-align:right"><?=(int)$bogura?></td>
	<td style="text-align:right"><?=(int)$sylhet?></td>
	<td style="text-align:right"><?=(int)$jessore?></td>
	<td style="text-align:right"><?=(int)$rangpur?></td>
	<td style="text-align:right"><?=(int)$comilla?></td>
	<td style="text-align:right"><?=(int)$total?>&nbsp;</td>
</tr>
<?
}
		
?>
</tbody></table>
<?

}

elseif($_REQUEST['report']==19921) 
{echo $str;
$t_date2 = date('Y-m-d',strtotime($t_date . "+1 days"));
$begin = new DateTime($f_date);
$end = new DateTime($t_date2);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
if($_POST['cut_date']!='') $cut_date = $_POST['cut_date']; else $cut_date = date('Y-m-d');
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d,sale_do_chalan ch where ch.order_no=c.id and c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
${'A'.$data->do_date} = $data->total_amt;
}
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d,sale_do_chalan ch where ch.order_no=c.id and  c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
${'B'.$data->do_date} = $data->total_amt;
}
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d ,sale_do_chalan ch where ch.order_no=c.id and  c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
${'C'.$data->do_date} = $data->total_amt;
}
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d ,sale_do_chalan ch where ch.order_no=c.id and  c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){${'D'.$data->do_date} = $data->total_amt;}
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d ,sale_do_chalan ch where ch.order_no=c.id and  c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='E' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){${'E'.$data->do_date} = $data->total_amt;}
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d ,sale_do_chalan ch where ch.order_no=c.id and  c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and (d.dealer_type='Corporate' or d.dealer_type='SuperShop' or (d.dealer_type='Distributor' AND product_group='M')) and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){${'X'.$data->do_date} = $data->total_amt;}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Date</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Group-A</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Group-B</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Group-C</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Group-D</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Group-E</span></td>
    <td bgcolor="#333333"><div align="right" class="style1"><strong><span class="style5">Total DO<br />
      (A+B+C+D+E)</span></strong></div></td>
    <td bgcolor="#333333"><span class="style3 style1">Mordern Trade</span></td>
    <td bgcolor="#333333"><span class="style3 style1">ALL DO</span></td>
  </tr>
<? foreach ( $period as $dt ){ $today_date = $dt->format("Y-m-d");
$day_total = ${'A'.$today_date} + ${'B'.$today_date} + ${'C'.$today_date} + ${'D'.$today_date} + ${'E'.$today_date};
$do_all = ${'A'.$today_date} + ${'B'.$today_date} + ${'C'.$today_date} + ${'D'.$today_date} + ${'E'.$today_date} + ${'X'.$today_date};
$do_total = $do_total + $do_all;
$mon_total = $mon_total + ${'A'.$today_date} + ${'B'.$today_date} + ${'C'.$today_date} + ${'D'.$today_date} + ${'E'.$today_date};
$A_total = $A_total + ${'A'.$today_date};
$B_total = $B_total + ${'B'.$today_date};
$C_total = $C_total + ${'C'.$today_date};
$D_total = $D_total + ${'D'.$today_date};
$E_total = $E_total + ${'E'.$today_date};
$X_total = $X_total + ${'X'.$today_date};
?>
  <tr bgcolor="#<?=(($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$today_date;?></td>
    <td><div align="right"><?=number_format(${'A'.$today_date},2);?></div></td>
    <td><div align="right"><?=number_format(${'B'.$today_date},2);?></div></td>
    <td><div align="right"><?=number_format(${'C'.$today_date},2);?></div></td>
    <td><div align="right">
      <?=number_format(${'D'.$today_date},2);?>
    </div></td>
    <td><div align="right"><?=number_format(${'E'.$today_date},2);?></div></td>
    <td width="1" bgcolor="#FFFF99"><div align="right"><?=number_format($day_total,2);?></div></td>
    <td width="1"><div align="right"><?=number_format(${'X'.$today_date},2);?></div></td>
    <td width="1" bgcolor="#FFFF99"><div align="right"><?=number_format($do_all,2);?></div></td>
  </tr>
<? }?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right">
      <?=number_format($A_total,2);?>
    </div></td>
    <td><div align="right">
      <?=number_format($B_total,2);?>
    </div></td>
    <td><div align="right">
      <?=number_format($C_total,2);?>
    </div></td>
    <td><div align="right">
        <?=number_format($D_total,2);?>
    </div></td>
    <td><div align="right">
      <?=number_format($E_total,2);?>
    </div></td>
    <td bgcolor="#FFFF99"><div align="right">
        <?=number_format($mon_total,2);?>
    </div></td>
    <td><div align="right">
      <?=number_format($X_total,2);?>
    </div></td>
    <td bgcolor="#FFFF99"><div align="right">
        <?=number_format($do_total,2);?>
    </div></td>
  </tr>
</table>
<?
}



// SuperShop Chalan Summary Brief
elseif($_POST['report']==112) {

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if($_POST['dealer']!=='') {$super_con=' and d.dealer_outlet_name="'.$_POST['dealer'].'"';}

$sqld1 = "select c.chalan_no,sum(total_amt) as net_amount 
from sale_do_chalan c, dealer_info d 
where c.dealer_code=d.dealer_code and d.dealer_type = 'SuperShop' 
and c.item_id in ('1096000100010312')
".$depot_con.$date_con.$super_con." group by c.chalan_no";

$res = db_query($sqld1);
	while($row=mysqli_fetch_object($res))
	{
		$discount[$row->chalan_no] = $row->net_amount;
	}


$sql="select c.chalan_no , m.do_no,c.chalan_date,d.dealer_outlet_name,d.dealer_code,d.dealer_name_e as dealer_name,w.warehouse_name as depot,
sum(total_amt) as total_amt,m.ref_no 
from sale_do_master m,sale_do_chalan c,dealer_info d, warehouse w
where m.status in ('CHECKED','COMPLETED') and m.do_no=c.do_no and m.dealer_code=d.dealer_code 
and c.item_id not in ('1096000100010312')
and w.warehouse_id=d.depot and d.dealer_type = 'SuperShop'
".$depot_con.$date_con.$super_con." group by chalan_no order by d.dealer_outlet_name,d.dealer_code,c.chalan_no";
$query = db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="10"><?=$str?></td></tr>
<tr><th>S/L</th><th>Chalan No</th>
  <th>Do No</th>
  <th>Ref No </th><th>Chalan Date</th><th>Party Type</th><th>Dealer Code</th><th>Dealer Name</th>
<th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th>
</tr></thead>
<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;

$total_amount = $data->total_amt;
$dis = $discount[$data->chalan_no];
$net_amount = $total_amount + $dis;

$g_total += $total_amount;
$d_total += $dis;
$n_total += $net_amount;
?>
<tr><td><?=$s?></td><td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
  <td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->do_no?>
  </a></td>
  <td><?=$data->ref_no?></td>
  <td><?=$data->chalan_date?></td><td><?=$data->dealer_outlet_name?></td>
<td><?=$data->dealer_code?></td><td><?=$data->dealer_name?></td>
<td><?=$data->depot?></td>
<td><?=number_format($total_amount,2)?></td>
<td><?=number_format($dis,2)?></td>
<td><?=number_format($net_amount,2)?></td></tr>
<? } ?>
<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td><?=number_format($g_total,2)?></td><td><?=number_format($d_total,2)?></td><td><?=number_format($n_total,2)?></td></tr></tbody></table>
<? 
}




// Corporate Chalan Summary Brief
elseif($_POST['report']==111) {

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if($_POST['dealer']!=='') {$super_con=' and d.dealer_outlet_name="'.$_POST['dealer'].'"';}

$sqld1 = "select c.chalan_no,sum(total_amt) as net_amount 
from sale_do_chalan c, dealer_info d 
where c.dealer_code=d.dealer_code and d.dealer_type = 'Corporate' 
and c.item_id in ('1096000100010312')
".$depot_con.$date_con.$super_con." group by c.chalan_no";

$res = db_query($sqld1);
	while($row=mysqli_fetch_object($res))
	{
		$discount[$row->chalan_no] = $row->net_amount;
	}


$sql="select c.chalan_no , m.do_no,c.chalan_date,d.dealer_outlet_name,d.dealer_code,d.dealer_name_e as dealer_name,w.warehouse_name as depot,
sum(total_amt) as total_amt 
from sale_do_master m,sale_do_chalan c,dealer_info d, warehouse w
where m.status in ('CHECKED','COMPLETED') and m.do_no=c.do_no and m.dealer_code=d.dealer_code 
and c.item_id not in ('1096000100010312')
and w.warehouse_id=d.depot and d.dealer_type = 'Corporate'
".$depot_con.$date_con.$super_con." group by chalan_no order by d.dealer_outlet_name,d.dealer_code,c.chalan_no";
$query = db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9"><?=$str?></td></tr>
<tr><th>S/L</th><th>Chalan No</th><th>Do No</th><th>Chalan Date</th><th>Party Type</th><th>Dealer Code</th><th>Dealer Name</th>
<th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th>
</tr></thead>
<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;

$total_amount = $data->total_amt;
$dis = $discount[$data->chalan_no];
$net_amount = $total_amount + $dis;

$g_total += $total_amount;
$d_total += $dis;
$n_total += $net_amount;
?>
<tr><td><?=$s?></td><td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
<td><?=$data->do_no?></td><td><?=$data->chalan_date?></td><td><?=$data->dealer_outlet_name?></td>
<td><?=$data->dealer_code?></td><td><?=$data->dealer_name?></td>
<td><?=$data->depot?></td>
<td><?=number_format($total_amount,2)?></td>
<td><?=number_format($dis,2)?></td>
<td><?=number_format($net_amount,2)?></td></tr>
<? } ?>
<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td><?=number_format($g_total,2)?></td><td><?=number_format($d_total,2)?></td><td><?=number_format($n_total,2)?></td></tr></tbody></table>
<? 
}



elseif($_POST['report']==3){

$sql2 	= "select distinct o.do_no,c.chalan_no as chalan_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,c.chalan_date as do_date,d.address_e,d.mobile_no,d.product_group from 
sale_do_master m,sale_do_details o,sale_do_chalan c, item_info i,dealer_info d , warehouse w
where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and c.order_no = o.id and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$pg_con.$dealer_con;
$query2 = db_query($sql2);

while($data=mysqli_fetch_object($query2)){
echo '<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid">';
	$dealer_code = $data->dealer_code;
	$chalan_no = $data->chalan_no;
	$dealer_name = $data->dealer_name_e;
	$warehouse_name = $data->warehouse_name;
	$do_date = $data->do_date;
	$do_no = $data->do_no;
		if($dealer_code>0) 
{
$str 	.= '<p style="width:100%">Dealer Name: '.$dealer_name.' - '.$dealer_code.'('.$data->product_group.')</p>';
$str 	.= '<p style="width:100%">Chalan NO: '.$chalan_no.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:'.$do_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DO NO: '.$do_no.' 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depot:'.$warehouse_name.'</p>
<p style="width:100%">Destination:'.$data->address_e.'('.$data->mobile_no.')</p>';

$dealer_con = ' and m.dealer_code='.$dealer_code;
$do_con = ' and m.do_no='.$do_no;
$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,c.pkt_unit as crt,c.dist_unit as pcs,c.total_amt as DP_Total,(o.t_price*c.total_unit) as TP_Total from 
sale_do_master m,sale_do_details o,sale_do_chalan c, item_info i,dealer_info d , warehouse w
where c.chalan_no='".$chalan_no."' and c.order_no = o.id and m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$do_con." order by m.do_date desc";
}

	echo report_create($sql,1,$str);
		$str = '';
		echo '</div>';
}
}
elseif($_POST['report']==5) 
{
if(isset($region_id)) 
$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;
else
$sqlbranch 	= "select * from branch";
$querybranch = db_query($sqlbranch);
while($branch=mysqli_fetch_object($querybranch)){
	$rp=0;
	echo '<div>';
if(isset($zone_id)) 
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;
else
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;

	$queryzone = db_query($sqlzone);
	while($zone=mysqli_fetch_object($queryzone)){
if($area_id>0) 
$area_con = "and a.AREA_CODE=".$area_id;
$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 
sale_do_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_do_master m,dealer_info d  , warehouse w,area a,sale_do_details s
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con;

		$queryt = db_query($sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; $str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}
			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$dp_total= $dp_total+$t->dp_total;
		}

	}
	
			if($rp>0){
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}



}
elseif($_POST['report']==9) 
{
if(isset($region_id)) 
$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;
else
$sqlbranch 	= "select * from branch";
$querybranch = db_query($sqlbranch);
while($branch=mysqli_fetch_object($querybranch)){
$rp=0;
echo '<div>';
if(isset($zone_id))
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;
else
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;

	$queryzone = db_query($sqlzone);
	while($zone=mysqli_fetch_object($queryzone)){
if($area_id>0) 
$area_con = "and a.AREA_CODE=".$area_id;

$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
floor(sum(o.total_unit)/o.pkt_size) as crt,
mod(sum(o.total_unit),o.pkt_size) as pcs, 
sum(o.total_amt) as DP,
sum(o.total_unit*o.t_price) as TP
from 
sale_do_master m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' group by i.finish_goods_code';

$sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total
from 
sale_do_master m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.'';

		$queryt = db_query($sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; 
			$str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}
			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$dp_total= $dp_total+$t->dp_total;
		}

	}
	
			if($rp>0){
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}



}
elseif($_POST['report']==8) 
{
if(isset($region_id)) 
$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;
else
$sqlbranch 	= "select * from branch";
$querybranch = db_query($sqlbranch);
while($branch=mysqli_fetch_object($querybranch)){
	$rp=0;
	echo '<div>';
if(isset($zone_id)) 
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;
else
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;

	$queryzone = db_query($sqlzone);
	while($zone=mysqli_fetch_object($queryzone)){
if(isset($area_id)) 
{
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 
sale_do_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." and a.AREA_CODE=".$area_id." ".$date_con.$pg_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_do_master m,dealer_info d  , warehouse w,area a,sale_do_details s
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.AREA_CODE=".$area_id." and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;
}
else
{
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 
sale_do_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_do_master m,dealer_info d  , warehouse w,area a,sale_do_details s
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;
}
		$queryt = db_query($sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; $str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}
			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$dp_total= $dp_total+$t->dp_total;
		}

	}
	
			if($rp>0){
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td>
  </tr>
</tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}
}



// Chalan Report Region wise
elseif($_REQUEST['report']==2000) {

if(isset($t_date)) 	
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and o.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$cdate_con=' and do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and i.sales_item_type="'.$product_group.'"';} 
if($depot_id>0) 				{$dpt_con=' and d.depot="'.$depot_id.'"';} 


$sqlr = "select * from branch";
$queryr = db_query($sqlr);
while($region = mysqli_fetch_object($queryr)){
$region_id = $region->BRANCH_ID;

$sql = "select i.finish_goods_code as code, sum(o.total_unit) as total_unit
from sale_do_chalan o, item_info i, dealer_info d
where o.unit_price>0 
and o.dealer_code=d.dealer_code 
and i.item_id=o.item_id
and d.region_id=".$region_id."
".$dtype_con.$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 
group by i.finish_goods_code';

$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$do_qty[$info->code][$region_id] = $info->total_unit;
}
}

if(isset($product_group)) {$pg_con=' and i.sales_item_type like "%'.$product_group.'%"';}
	$sql = "select 
		i.finish_goods_code as code, 
		i.item_name, i.item_brand, i.brand_category_type,
		i.sales_item_type as `group`,i.pack_size,i.d_price
		from item_info i
		where i.finish_goods_code>0 and i.finish_goods_code not between 5000 and 6000 and i.finish_goods_code not between 2000 and 3000 
		".$item_con.$item_brand_con.$pg_con." 
		group by i.finish_goods_code";
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead>
<tr><td style="border:0px;" colspan="16"><?=$str?></td></tr><tr>
<th height="20">S/L</th>
<th>Code</th>
<th>Item Name</th>
<th>Grp</th>
<th>Brand</th>
<th>Sub-Brand</th>
<th>DHK North</th>
<th>DHK South</th>
<th>Ctg</th>
<th>Comilla</th>
<th>Sylhet</th>
<th>Barisal</th>
<th>Bogra</th>
<th>Total</th>
</tr></thead>
<tbody>
<?
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){

$total_item = 
(int)($do_qty[$info->code][13]/$info->pack_size)+
(int)($do_qty[$info->code][12]/$info->pack_size)+
(int)($do_qty[$info->code][3]/$info->pack_size)+
(int)($do_qty[$info->code][4]/$info->pack_size)+
(int)($do_qty[$info->code][5]/$info->pack_size)+
(int)($do_qty[$info->code][9]/$info->pack_size)+
(int)($do_qty[$info->code][10]/$info->pack_size)+
(int)($do_qty[$info->code][8]/$info->pack_size);

if($total_item>0){
?>
<tr><td><?=++$i;?></td>
  <td><?=$info->code;?></td>
  <td><?=$info->item_name;?></td>
  <td><?=$info->group?></td>
  <td><?=$info->item_brand?></td>
  <td style="text-align:center"><?=$info->brand_category_type?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][13]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][12]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][3]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][4]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][5]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][10]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][8]/$info->pack_size)?></td>
  <td style="text-align:right"><?=number_format($total_item,0);?></td></tr>
<?
}}
?>
</tbody></table>
<?
		$str = '';

}









elseif($_REQUEST['report']==2002) 
{
if(isset($region_id)) 
$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;
else
$sqlbranch 	= "select * from branch";
$querybranch = db_query($sqlbranch);
while($branch=mysqli_fetch_object($querybranch)){
	$rp=0;
	echo '<div>';
if(isset($zone_id)) 
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;
else
$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;

	$queryzone = db_query($sqlzone);
	while($zone=mysqli_fetch_object($queryzone)){
if($area_id>0) 
$area_con = "and a.AREA_CODE=".$area_id;
$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 
sale_do_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_do_master m,dealer_info d  , warehouse w,area a,sale_do_details s
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con;

		$queryt = db_query($sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; $str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}
			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$dp_total= $dp_total+$t->dp_total;
		}

	}
	
			if($rp>0){
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}
}



elseif($_REQUEST['report']==7031) { // sales report type wise 15-Mar-18

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


$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
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

$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
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

$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
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
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
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
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){

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

<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>