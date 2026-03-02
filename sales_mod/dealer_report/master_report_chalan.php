<?

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
date_default_timezone_set('Asia/Dhaka');

if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)
{
	if((strlen($_REQUEST['t_date'])==10)&&(strlen($_REQUEST['f_date'])==10))
	{
		$t_date=$_REQUEST['t_date'];
		$f_date=$_REQUEST['f_date'];
	}
	
if($_REQUEST['product_group']!='') 	$product_group=$_REQUEST['product_group'];
if($_REQUEST['item_brand']!='') 	$item_brand=$_REQUEST['item_brand'];
if($_REQUEST['item_id']>0) 			$item_id=$_REQUEST['item_id'];
if($_REQUEST['dealer_code']>0) 	 	$dealer_code=$_REQUEST['dealer_code'];
if($_REQUEST['dealer_type']!='') 	$dealer_type=$_REQUEST['dealer_type'];

if($_REQUEST['status']!='') 		$status=$_REQUEST['status'];
if($_REQUEST['or_no']!='') 			$or_no=$_REQUEST['or_no'];
if($_REQUEST['area_id']!='') 		$area_id=$_REQUEST['area_id'];
if($_REQUEST['zone_id']!='') 		$zone_id=$_REQUEST['zone_id'];
if($_REQUEST['region_id']>0) 		$region_id=$_REQUEST['region_id'];
if($_REQUEST['depot_id']!='') 		$depot_id=$_REQUEST['depot_id'];

if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($dealer_type)) 		{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';}

if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 

$item_info = find_all_field('item_info','','item_id='.$item_id);

//if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
//if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
//if(isset($zone_id)) 			{$zone_con=' and a.buyer_id='.$zone_id;}
//if(isset($region_id)) 		{$region_con=' and d.id='.$region_id;}
//if(isset($item_id)) 			{$item_con=' and b.item_id='.$item_id;} 
//if(isset($status)) 			{$status_con=' and a.status="'.$status.'"';} 
//if(isset($or_no)) 			{$or_no_con=' and a.or_no="'.$or_no.'"';} 
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $Damage_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

switch ($_REQUEST['report']) {
case 1:
	if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 
	$report="Delivery Damage Summary Brief";
	break;


case 22:
		$report="Item Wise Sales vs Damage Report";

	break;

case 2200:
		$report="Item Wise Sales vs Damage Report";
	break;
	
case 702:
		$report="Item Wise Sales vs Damage Report(Without Tang)";
	break;	


case 1111:
	if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 
	$report="Delivery Damage Summary Brief";
	break;
case 2:
		$report="Item Wise Damage Details Report";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;
		
case 20:
		$report="Item Wise Damage Details Report";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;		
		
		


case 2001:
$report="Party Wise Sales vs Damage Report";

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}

if(isset($dealer_code)) 		{$dealer_code_con =' and d.dealer_code in ('.$dealer_code.')';} 

if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

break;

	case 21:
	$report="Item wise Sales vs Damage Report";
	break;
	
	case 211:
	$report="Damage Cause wise Damage Report";
	break;
	case 212:
	$report="Damage Cause wise Damage Report Summary";
	break;
	case 3:
$report="Delivered Damage Report (Damage Wise)";
if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($dealer_code)) {$dealer_con=' and m.vendor_id='.$dealer_code;} 
if(isset($item_id)){$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) {$depot_con=' and d.depot="'.$depot_id.'"';} 
	break;
	
	case 6:
	if($_REQUEST['damage_no']>0)
header("Location:../damage_report/damage_view_print.php?req_no=".$_REQUEST['damage_no']);
	break;
	
	case 5:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
$report="Delivery Order Brief Report (Region Wise)";
	break;
	
		case 7:
		$report="Item wise DO Report";
		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 
		
		$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,i.item_brand,i.sales_item_type as `group`,
		floor(sum(o.total_unit)/o.pkt_size) as crt,
		mod(sum(o.total_unit),o.pkt_size) as pcs, 
		sum(o.total_amt)as dP,
		sum(o.total_unit*o.t_price)as tP
		from 
		warehouse_damage_receive m,sale_do_details o, item_info i,dealer_info d
		where m.or_no=o.or_no and m.vendor_id=d.dealer_code and i.item_id=o.item_id   ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';
		break;
		case 8:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
$report="Dealer Performance Report";
	    case 9:
		$report="Item Report (Region Wise)";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 
		break;
		
		case 10:
		$report="Daily Collection Summary";
		
$sql="select m.or_no,m.or_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 
warehouse_damage_receive m,dealer_info d  , warehouse w
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
		
		case 11:
		$report="Daily Collection &amp; Order Summary";
		
$sql="select m.or_no, m.or_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_do_details where or_no=m.or_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from 
warehouse_damage_receive m,dealer_info d  , warehouse w 
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
		case 13:
		$report="Daily Collection Summary(EXT)";
		
		$sql="select m.or_no,m.or_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 
		warehouse_damage_receive m,dealer_info d  , warehouse w
		where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
		case 111:
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$report="Corporate Damage Summary Brief";
		break;
	    case 112:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$report="SuperShop Damage Summary Brief";
	break;
	
	    case 1004:
		$report="Warehouse Stock Position Report(Closing)";

		break;
		case 107:
		$report="Regional Sales Vs Damage Report (TK)";

		break;
		
case 10777:
		$report="Regional Sales Vs Damage Report (TK)";

		break;
		
		case 705:
		$report="Regional Sales Vs Damage Report (TK)";

		break;
		
		
		case 108:
		$report="Zone Wise Sales Vs Damage Report (TK)";
		
		break;
		
				case 10888:
		$report="Zone Wise Sales Vs Damage Report (TK)";
		
	case 704:
		$report="Zone Wise Sales Vs Damage Report (TK)";
		
		break;
		case 109:
		$report="Party Wise  Sales Vs Damage Report (TK)";

		break;	
		
case 113:
$report="Party Wise Sales Vs Damage Report";
break;

case 11333:
$report="Party Wise Sales Vs Damage Report";
break;

case 701:
$report="Party Wise Sales Vs Damage Report(Without Tang)";
break;


case 703:
$report="Region/Zone/Party/Item Wise Sales Vs Damage Report";
break;

		
		
		case 110:
		$report="Sales Vs Damage Report(TK)(Corporate/SuperShop)";
		break;	
		
		
		case 117:
		$report="Regional Sales Vs Damage Report (TK)";
		break;
		
		case 118:
		$report="Zone Wise Sales Vs Damage Report (TK)";
		break;
		
		case 119:
		$report="Party Wise  Sales Vs Damage Report (TK)";
		break;	

		
		case 120:
		$report="Sales Vs Damage Report(TK)(Corporate/SuperShop)";

		break;									
}
}

		if(isset($region_id)) 	$region_name = find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id);
		if(isset($zone_id)) 	$zone_name 	= find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id);
		if(isset($area_id)) 	$area_name 	= find_a_field('area','AREA_NAME','AREA_CODE='.$area_id);
		if(isset($dealer_code)) $dealer_name 	= find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$region_name?> <?=$zone_name?> <?=$dealer_name?> <?=$report?></title>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
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
<!--
.style1 {color: #FFFFFF}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
.style3 {font-weight: bold}
-->
    </style>

	<?
	require_once "../../../controllers/core/inc.exporttable.php";
	?>

</head>
<body>
<!--<div align="center" id="pr">-->
<!--<input type="button" value="Print" onclick="hide();window.print();"/>-->
<!--</div>-->
<div class="main">

<?

		
		$str 	.= '<div class="header">';
/*		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';*/
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		
		if(isset($dealer_name)) 
		$str 	.= '<h2>Dealer Name : '.$dealer_code.'-'.$dealer_name.'</h2>';
		
		if(isset($item_info->item_id)) 
		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Group : '.$product_group.'</h2>';
		
		if(isset($item_brand)) 
		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';
		
		if($_POST['damage_cause']>0) 
		$str 	.= '<h2>Damage Cause : '.find_a_field('damage_cause','damage_cause','id='.$_POST['damage_cause']).'</h2>';
		if(isset($region_name)) $str .= '<h2>Region Name : '.$region_name.'</h2>';
		if(isset($zone_name)) $str 	.= '<h2>Zone Name: '.$zone_name.'</h2>';
		if(isset($area_name)) $str 	.= '<h2>Area Name: '.$area_name.'</h2>';
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
if($_REQUEST['report']==1004) 
{

			if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
			elseif(isset($item_id)) 			{$item_sub_con=' and i.item_id='.$item_id;} 
			
			if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 
			
			if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; $date_con=' and ji_date <="'.$to_date.'"';}
		
		
		$sql='select distinct i.item_id,i.unit_name,i.item_name,"Finished Goods",i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 
		   from item_info i where i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' order by i.item_brand,i.item_name';
		   
		$query =db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="8"><div class="header"><h1>Sajeeb Group</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date-<?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
<th>Item Brand</th>
<th>Group</th>
<th>FG</th>
<th>Item Name</th>
<th>Unit</th>
<th>Dhaka</th>
<th>Chittagong</th>
<th>Borisal</th>
<th>Bogura</th>
<th>Sylhet</th>
<th>Jessore</th>
<th>Total</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){


$dhaka = 	(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="3"')/$data->pack_size);
//$ctg = 		(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="6"')/$data->pack_size);
$ctg = '';
$sylhet =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"')/$data->pack_size);
$bogura =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="7"')/$data->pack_size);
$borisal =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="8"')/$data->pack_size);
$jessore =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="10"')/$data->pack_size);
$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore;	   

//echo $sql = 'select sum(item_in-item_ex) from journal_item where item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"';?>
<tr>
<td><?=++$j?></td>
<td><?=$data->item_brand?></td>
<td><?=$data->sales_item_type?></td>
<td><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right"><?=(int)$dhaka?></td>
<td style="text-align:right"><?=(int)$ctg?></td>
<td style="text-align:right"><?=(int)$borisal?></td>
<td style="text-align:right"><?=(int)$bogura?></td>
<td style="text-align:right"><?=(int)$sylhet?></td>
<td style="text-align:right"><?=(int)$jessore?></td>
<td style="text-align:right"><div align="right">
  <?=(int)$total?>
  &nbsp;</div></td>
</tr>
<?
}
		
?>
</tbody></table>
<?

}



elseif($_REQUEST['report']==20)  // item wise brief damage report
{
?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<?
if($_POST['damage_cause']>0) $damage_con = ' and dc.id="'.$_POST['damage_cause'].'"';


$sql="select c.id,i.finish_goods_code as code, i.item_name,i.sales_item_type as item_group,
sum(c.qty) as qty,sum(c.amount) as amount,
d.dealer_code
from 
warehouse_damage_receive m, warehouse_damage_receive_detail c,dealer_info d  , warehouse w ,item_info i, damage_cause dc
where dc.id=c.receive_type and i.item_id=c.item_id and m.or_no=c.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." 
group by i.finish_goods_code
order by m.manual_or_no desc";

$query = db_query($sql);
?>

<thead>
<tr><td style="border:0px;" colspan="9"><?=$str?></td></tr>
<tr><th>S/L</th>
<th>Code</th>
<th>Item Name Name</th>
<th>Depot</th>
<th>Grp</th>
<th></th>
<th>Qty</th>
<th>DM Total</th>
<th>Payable DM</th>
</tr></thead><tbody>

<?
while($data=mysqli_fetch_object($query)){$s++;
if($data->payable!='Yes'){
$payable_amount = 0;
$dm_amount = $data->amount;
}
else
{
$payable_amount = $data->amount;
$dm_amount = $data->amount;
}


//$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$dm_amount;
$tp_t = $tp_t+$payable_amount;
$qty_t = $qty_t+$data->qty;
?>
<tr>
<td><?=$s?></td>
<td><?=$data->code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->depot;?></td>
<td><?=$data->item_group;?></td>
<td></td>
<td><?=$data->qty;?></td>
<td><?=number_format($dm_amount,2)?></td>
<td></td>
</tr>
<? } ?>

<tr class="footer">
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td><?=$qty_t?></td>
<td><?=number_format($dp_t,2)?></td><td><?=number_format($tp_t,2)?></td></tr></tbody></table>
<?
}

// damage brief report
elseif($_REQUEST['report']==1) {

?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<?
if($_POST['damage_cause']>0) $damage_con = ' and dc.id="'.$_POST['damage_cause'].'"';

$sql="select c.id,m.or_no as Damage_No, m.or_no,m.manual_or_no ,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,
sum(c.qty) as qty,sum(c.amount) as amount,w.warehouse_name as depot,d.area_code as area_name,d.dealer_code,dc.payable ,dc.damage_cause
from
warehouse_damage_receive m, warehouse_damage_receive_detail c,dealer_info d  , warehouse w ,item_info i, damage_cause dc
where dc.id=c.receive_type and i.item_id=c.item_id and m.or_no=c.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." 
group by m.or_no
order by m.manual_or_no desc";

$query = db_query($sql);
?>

<thead><tr><td style="border:0px;" colspan="9"><?=$str?></td></tr>
<tr>
<th>S/L-1</th>
<th>Damage No</th>
<th>Serial No</th>
<th>Entry Date</th>
<th>Dealer Name</th>
<th>Cause</th>
<th>Depot</th>
<th>Grp</th>
<th>Qty</th>
<th>DM Total</th>
<th>Payable DM</th>
</tr></thead><tbody>


<?
while($data=mysqli_fetch_object($query)){$s++;
if($data->payable!='Yes'){
$payable_amount = 0;
$dm_amount = $data->amount;
}
else
{
$payable_amount = $data->amount;
$dm_amount = $data->amount;
}


//$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$dm_amount;
$tp_t = $tp_t+$payable_amount;
$qty_t = $qty_t+$data->qty;
?>
<tr><td><?=$s?></td>
<td><?=$data->or_no?></td>
<td><?=$data->manual_or_no?></td>
<td><?=$data->or_date?></td>
<td><?=$data->dealer_name?></td>
<td><?=$data->damage_cause?></td>
<td><?=$data->depot;?></td>
<td><?=find_a_field('dealer_info','product_group','dealer_code='.$data->dealer_code);?></td>
<td><?=$data->qty;?></td>
<td><?=number_format($dm_amount,2)?></td>
<td><?=number_format($payable_amount,2)?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=$qty_t?></td>
<td><?=number_format($dp_t,2)?></td><td><?=number_format($tp_t,2)?></td></tr></tbody></table>
<?
}
// end 1


elseif($_REQUEST['report']==2) 
{
?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<?
if($_POST['damage_cause']>0) $damage_con = ' and dc.id="'.$_POST['damage_cause'].'"';
$sql="select c.id,m.or_no as Damage_No, m.or_no,m.manual_or_no ,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,i.item_name,c.qty,c.rate,c.amount as amount,w.warehouse_name as depot,d.area_code as area_name,d.dealer_code,dc.payable ,dc.damage_cause
from 
warehouse_damage_receive m, warehouse_damage_receive_detail c,dealer_info d  , warehouse w ,item_info i, damage_cause dc
where dc.id=c.receive_type and i.item_id=c.item_id and m.or_no=c.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." order by m.manual_or_no desc";

$query = db_query($sql);

echo '
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Damage No</th><th>Serial No</th><th>Entry Date</th><th>Dealer Name</th><th>Item Name Name</th><th>Cause</th><th>Depot</th><th>Grp</th><th>Rate</th><th>Qty</th><th>DM Total</th><th>Payable DM</th></tr></thead><tbody>';

while($data=mysqli_fetch_object($query)){$s++;
if($data->payable!='Yes'){
$payable_amount = 0;
$dm_amount = $data->amount;
}
else
{
$payable_amount = $data->amount;
$dm_amount = $data->amount;
}


//$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$dm_amount;
$tp_t = $tp_t+$payable_amount;
$qty_t = $qty_t+$data->qty;
?>
<tr><td><?=$s?></td><td><a href="../damage_report/damage_view_print.php?req_no=<?=$data->or_no?>" target="_blank"><?=$data->or_no?></a></td><td><?=$data->manual_or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=$data->item_name?></td><td><?=$data->damage_cause?></td><td><?=$data->depot;?></td><td><?=find_a_field('dealer_info','product_group','dealer_code='.$data->dealer_code);?></td>


<td><?=$data->rate;?></td><td><?=$data->qty;?></td>

<td><?=number_format($dm_amount,2)?></td><td><?=number_format($payable_amount,2)?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=$qty_t?></td><td><?=number_format($dp_t,2)?></td><td><?=number_format($tp_t,2)?></td></tr></tbody></table>
<?
}
// end 2


elseif($_REQUEST['report']==2001){ // party wise sales vs damage report

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; 
$dated_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
//if(isset($_POST['dealer_code'])) { $dealer_code_con =' and c.dealer_code = "'.$_POST['dealer_code'].'"';}
// find out sales qty and amount
$sql_chalan='
select d.dealer_code,c.item_id,i.finish_goods_code as code,sum(c.total_unit) as sales_qty,sum(c.total_amt) as sales_amount
from sale_do_chalan c, dealer_info d, item_info i
where c.dealer_code=d.dealer_code and c.item_id = i.item_id
'.$dated_con.$dealer_code_con.'
group by d.dealer_code,c.item_id
';
$res1 = db_query($sql_chalan);
	while($row=mysqli_fetch_object($res1))
	{
		$chalan_amount[$row->dealer_code][$row->code] = $row->sales_amount;
		$chalan_qty[$row->dealer_code][$row->code] = $row->sales_qty;

	}


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9"><?=$str?>In This Report, Sales Amount Shows on Damage Related Item Only.</td></tr><tr>
<th>S/L-2001</th>
<th>Dealer Code</th>
<th>Dealer Name</th>
<th>Brand</th>
<th>FGCode</th>
<th>Item Name</th>
<th>Grp</th>
<th>Rate</th>
<th>Sales Qty</th>
<th>Sales Amt</th>
<th>DM Qty</th>
<th>Payable DM</th>
<th>Ratio%</th>
</tr></thead><tbody>
<?
if($_POST['damage_cause']>0) $damage_con = ' and dc.id="'.$_POST['damage_cause'].'"';

$sql="select c.id,m.or_no as Damage_No, m.or_no,m.manual_or_no ,c.or_date,d.dealer_name_e as dealer_name,i.item_name,sum(c.qty) qty,c.rate,sum(c.amount) as amount,d.area_code as area_name,d.dealer_code,dc.payable,i.item_brand,i.finish_goods_code as code,i.item_id
from 
warehouse_damage_receive m, warehouse_damage_receive_detail c,dealer_info d  , item_info i, damage_cause dc
where dc.payable='Yes' and dc.id=c.receive_type and i.item_id=c.item_id and m.or_no=c.or_no and m.vendor_id=d.dealer_code 
".$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con.$dealer_code_con." 
group by i.item_id,d.dealer_code order by m.manual_or_no desc";

$query = db_query($sql);

while($data=mysqli_fetch_object($query)){$s++;

	$payable_amount = $data->amount;


$dp_t = $dp_t+$payable_amount;
$tp_t = $tp_t+$payable_amount;
$qty_t = $qty_t+$data->qty;

$stp_t += $chalan_amount[$data->dealer_code][$data->code];
$sqty_t += $chalan_qty[$data->dealer_code][$data->code];

$ratio = (@($payable_amount/$chalan_amount[$data->dealer_code][$data->code]))*100;
if($ratio==0) $ratio = '100';

?>
<tr><td><?=$s?></td><td><?=$data->dealer_code?></td><td><?=$data->dealer_name?></td>
<td><?=$data->item_brand?></td><td><?=$data->code?></td><td><?=$data->item_name?></td>
<td><?=find_a_field('dealer_info','product_group','dealer_code='.$data->dealer_code);?></td>
<td><?=$data->rate;?></td>

<td><?=$chalan_qty[$data->dealer_code][$data->code];?></td>
<td><?=$chalan_amount[$data->dealer_code][$data->code];?></td>

<td><?=(int)$data->qty;?></td>
<td><?=number_format($payable_amount,2)?></td>
<td><? if($ratio>2){echo '<font color="#FF0000">'.number_format($ratio,2).'</font>';}else{ echo number_format($ratio,2);} ?></td>
</tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td><?=$sqty_t?></td><td><?=$stp_t?></td>
  <td><?=$qty_t?></td>
  <td><?=number_format($tp_t,2)?></td>
  <td><?=number_format((($tp_t/$stp_t)*100),2);?>%</td>
</tr></tbody></table>
<?
}


elseif($_REQUEST['report']==211) 
{
if($_REQUEST['damage_cause']>0) 		$damage_con = ' and dc.id="'.$_REQUEST['damage_cause'].'"';
if($_REQUEST['dealer_code']>0) 		$dealer_con1=' and d.dealer_code="'.$_REQUEST['dealer_code'].'"';

$sql="select concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,i.item_name,sum(c.qty) as qty,sum(c.amount) as amount,w.warehouse_name as depot,d.area_code as area_name,d.dealer_code,dc.payable ,dc.damage_cause
from 
warehouse_damage_receive m, warehouse_damage_receive_detail c,dealer_info d  , warehouse w ,item_info i, damage_cause dc
where dc.id=c.receive_type and i.item_id=c.item_id and m.or_no=c.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$delear_con.$date_con.$pg_con.$dealer_con1.$dealer_type_con.$damage_con." group by dc.damage_cause,d.dealer_code";

$query = db_query($sql);

echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Damage No</th><th>Serial No</th><th>Entry Date</th><th>Dealer Name</th><th>Item Name Name</th><th>Cause</th><th>Depot</th><th>Grp</th><th>Rate</th><th>Qty</th><th>DM Total</th><th>Payable DM</th></tr></thead>
<tbody>';

while($data=mysqli_fetch_object($query)){$s++;
if($data->payable!='Yes'){
$payable_amount = 0;
$dm_amount = $data->amount;
}
else
{
$payable_amount = $data->amount;
$dm_amount = $data->amount;
}


//$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$dm_amount;
$tp_t = $tp_t+$payable_amount;

?>
<tr><td><?=$s?></td><td><a href="../damage_report/damage_view_print.php?req_no=<?=$data->or_no?>" target="_blank"><?=$data->or_no?></a></td><td><?=$data->manual_or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=$data->item_name?></td><td><?=$data->damage_cause?></td><td><?=$data->depot;?></td><td><?=find_a_field('dealer_info','product_group','dealer_code='.$data->dealer_code);?></td>


<td><?=$data->rate;?></td><td><?=$data->qty;?></td>

<td><?=number_format($dm_amount,2)?></td><td><?=number_format($payable_amount,2)?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=number_format($dp_t,2)?></td><td><?=number_format($tp_t,2)?></td></tr></tbody></table>
<?
}




elseif($_REQUEST['report']==1111111) {

$sql="select distinct m.or_no as Damage_No, m.or_no,m.manual_or_no ,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.area_code as area_name,d.dealer_code from 
warehouse_damage_receive m,warehouse_damage_receive_detail c,dealer_info d  , warehouse w 
where m.or_no=c.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." order by m.or_no";

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9"><?=$str?></td></tr><tr><th>S/L</th><th>Damage No</th><th>Serial No</th><th>Entry Date</th><th>Dealer Name</th><th>Area</th><th>Depot</th><th>Grp</th><th>DM Total</th><th>Payable DM</th></tr></thead>
<tbody>
<?

while($data=mysqli_fetch_object($query)){$s++;

$sqld = 'select sum(amount) as total_amt from warehouse_damage_receive_detail   where or_no='.$data->or_no;
$info = mysqli_fetch_row(db_query($sqld));
$sqld = 'select sum(d.amount) as total_amt from warehouse_damage_receive_detail d, damage_cause c where c.id=d.receive_type and c.payable="Yes" and d.or_no='.$data->or_no;
$info2 = mysqli_fetch_row(db_query($sqld));
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$info[0];
$tp_t = $tp_t+$info2[0];

?>
<tr><td><?=$s?></td><td><a href="../damage_report/damage_view_print.php?req_no=<?=$data->or_no?>" target="_blank"><?=$data->or_no?></a></td><td><?=$data->manual_or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=find_a_field('area','AREA_NAME','AREA_CODE='.$data->area_name)?></td><td><?=$data->depot?></td><td><?=find_a_field('dealer_info','product_group','dealer_code='.$data->dealer_code)?></td><td><?=number_format($info[0],2)?></td><td><?=number_format($info2[0],2)?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=number_format($dp_t,2)?></td><td><?=number_format($tp_t,2)?></td></tr></tbody></table>
<?
}


elseif($_REQUEST['report']==1111) {

$sql="select distinct m.or_no as Damage_No, m.or_no,m.manual_or_no ,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.area_code as area_name,d.dealer_code from 
warehouse_damage_receive m,warehouse_damage_receive_detail c,dealer_info d  , warehouse w 
where m.or_no=c.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." order by m.manual_or_no desc";

$query = db_query($sql);

echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Damage No</th><th>Serial No</th><th>Entry Date</th><th>Dealer Name</th><th>Area</th><th>Depot</th><th>Grp</th><th>DM Total</th><th>Payable DM</th></tr></thead>
<tbody>';

while($data=mysqli_fetch_object($query)){$s++;

$sqld = 'select sum(amount) as total_amt from warehouse_damage_receive_detail   where or_no='.$data->or_no;
$info = mysqli_fetch_row(db_query($sqld));
$sqld = 'select sum(d.amount) as total_amt from warehouse_damage_receive_detail d, damage_cause c where c.id=d.receive_type and c.payable="Yes" and d.or_no='.$data->or_no;
$info2 = mysqli_fetch_row(db_query($sqld));
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$info[0];
$tp_t = $tp_t+$info2[0];

?>
<tr><td><?=$s?></td><td><a href="../damage_report/damage_view_print.php?req_no=<?=$data->or_no?>" target="_blank"><?=$data->or_no?></a></td><td><?=$data->manual_or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=find_a_field('area','AREA_NAME','AREA_CODE='.$data->area_name)?></td><td><?=$data->depot?></td><td><?=find_a_field('dealer_info','product_group','dealer_code='.$data->dealer_code)?></td><td><?=number_format($info[0],2)?></td><td><?=number_format($info2[0],2)?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=number_format($dp_t,2)?></td><td><?=number_format($tp_t,2)?></td></tr></tbody></table>
<?
}


elseif($_REQUEST['report']==21)  // item wise sales vs damage
{



?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="12"><?=$str?></td></tr>
  
  <tr>
    <th rowspan="2">S/L</th>
    <th rowspan="2">GRP</th>
    <th rowspan="2">Brand</th>
    <th rowspan="2">FG</th>
    <th rowspan="2">Product Name </th>
    <th colspan="2">Sales</th>
    <th colspan="2">Damage</th>
    <th rowspan="2">Sales (BDT) </th>
    <th rowspan="2">Payable Damage (BDT)</th>
    <th rowspan="2">Ratio</th>
  </tr>
  <tr>
<th>Ctn</th>
<th>Pcs</th>
<th>Ctn</th>
<th>Pcs</th>
</tr></thead>
<tbody>
<?
if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
if(isset($dealer_code)) 		{$dealer_con=' and a.vendor_id="'.$dealer_code.'"';}
if(isset($dealer_code)) 		{$dealer_con1=' and dealer_code="'.$dealer_code.'"';}
if(isset($product_group)) 		{$pg_con=' and i.sales_item_type="%'.$product_group.'%"';} 
if(isset($item_brand)) 			{$pg_con.=' and i.item_brand="'.$item_brand.'"';} 


$report="Item Wise Sales Vs Damage Comparison Report";
$sql="select i.* from item_info i where i.product_nature='Salable' 
and finish_goods_code>0 
and finish_goods_code<8000 ".$item_con.$pg_con." 
order by i.item_name";
$query = db_query($sql);

while($data=mysqli_fetch_object($query)){
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$sqld = 'select sum(total_unit) as total_unit,sum(total_amt) as total_amt from sale_do_chalan  where item_id='.$data->item_id.$date_con.$dealer_con1;
$sales = mysqli_fetch_object(db_query($sqld));
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$sqld = 'select sum(a.qty) as total_unit,sum(a.amount) as total_amt from warehouse_damage_receive_detail a,damage_cause d   where d.id=a.receive_type and d.payable="Yes" and a.item_id='.$data->item_id.$date_con.$dealer_con;
$damage = mysqli_fetch_object(db_query($sqld));
$pdm = (@($damage->total_amt/$sales->total_amt)*100);

if($pdm>5)
$color = 'color:red;';
elseif($pdm>2)
$color = 'color:brown;';
elseif($pdm>0)
$color = 'color:green;';
else
$color = 'color:black;';
if($damage->total_amt>0||$sales->total_amt>0){
?>
<tr>
	<td><?=++$s?></td>
	<td><?=$data->sales_item_type?>&nbsp;</td>
	<td><?=$data->item_brand?></td>
	<td>
<a target="_blank" href="?item_id=<?=$data->item_id?>&report=211&submit=1&f_date=<?=$f_date?>&t_date=<?=$t_date?>&dealer_code=<?=$dealer_code?>&product_group=<?=$product_group?>">
<?=$data->finish_goods_code?></a>    </td>
	<td><?=$data->item_name?></td>
	<td><div align="right">
	  <?=(int)($sales->total_unit/$data->pack_size);?>
	  </div></td>
	<td><div align="right">
	  <?=(int)($sales->total_unit%$data->pack_size);?>
	</div></td>
	<td><div align="right">
	  <?=(int)($damage->total_unit/$data->pack_size);?>
	  </div></td>
	<td><div align="right">
      <?=(int)($damage->total_unit%$data->pack_size);?>
    </div></td>
	<td><div align="right">
	  <?=number_format($sales->total_amt,2);$s_total = $s_total + $sales->total_amt;?>
	  </div></td>
	<td><div align="right">
	  <?=number_format($damage->total_amt,2);$d_total = $d_total + $damage->total_amt;?>
	  </div></td>
	<td style="font-weight:bold;<?=$color?>"><div align="right">
	  <?=number_format($pdm,2);?>%</div></td>
	</tr>
<?
}}
?><tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td><div align="right">
    <?=number_format($s_total,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($d_total,2)?>
  </div></td>
  <td></td></tr></tbody></table>
<?
}




elseif($_REQUEST['report']==211) 
{

?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="10"><?=$str?></td></tr>
  
  <tr>
    <th rowspan="2">S/L</th>
    <th rowspan="2">FG</th>
    <th rowspan="2">Product Name </th>
    <th colspan="2">Sales</th>
    <th colspan="2">Damage</th>
    <th rowspan="2">Sales (BDT) </th>
    <th rowspan="2">Payable Damage (BDT)</th>
    <th rowspan="2">Ratio</th>
  </tr>
  <tr>
<th>Ctn</th>
<th>Pcs</th>
<th>Ctn</th>
<th>Pcs</th>
</tr></thead>
<tbody>
<?
if(isset($dealer_code)) 		{$dealer_con=' and a.vendor_id="'.$dealer_code.'"';}
if(isset($dealer_code)) 		{$dealer_con1=' and dealer_code="'.$dealer_code.'"';}
$sql="select i.* from item_info i where i.product_nature='Salable' and finish_goods_code>0 and finish_goods_code<5000 order by i.item_name";
$query = db_query($sql);

while($data=mysqli_fetch_object($query)){$s++;
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$sqld = 'select sum(total_unit) as total_unit,sum(total_amt) as total_amt from sale_do_chalan  where item_id='.$data->item_id.$date_con.$dealer_con1;
$sales = mysqli_fetch_object(db_query($sqld));
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$sqld = 'select sum(a.qty) as total_unit,sum(a.amount) as total_amt from warehouse_damage_receive_detail a,damage_cause d   where d.id=a.receive_type and d.payable="Yes" and a.item_id='.$data->item_id.$date_con.$dealer_con;
$damage = mysqli_fetch_object(db_query($sqld));
$pdm = (@($damage->total_amt/$sales->total_amt)*100);

if($pdm>5)
$color = 'color:red;';
elseif($pdm>2)
$color = 'color:brown;';
elseif($pdm>0)
$color = 'color:green;';
else
$color = 'color:black;';
if($damage->total_amt>0||$sales->total_amt>0){
?>
<tr>
	<td><?=$s?></td>
	<td>
<a href="?item_id=<?=$data->item_name?>&report=211&submit=1&f_date=<?=$f_date?>&t_date=<?=$t_date?>&t_date=<?=$t_date?>&dealer_code=<?=$dealer_code?>">
<?=$data->finish_goods_code?></a>
    </td>
	<td><?=$data->item_name?></td>
	<td><div align="right">
	  <?=(int)($sales->total_unit/$data->pack_size);?>
	  </div></td>
	<td><div align="right">
	  <?=(int)($sales->total_unit%$data->pack_size);?>
	</div></td>
	<td><div align="right">
	  <?=(int)($damage->total_unit/$data->pack_size);?>
	  </div></td>
	<td><div align="right">
      <?=(int)($damage->total_unit%$data->pack_size);?>
    </div></td>
	<td><div align="right">
	  <?=number_format($sales->total_amt,2);$s_total = $s_total + $sales->total_amt;?>
	  </div></td>
	<td><div align="right">
	  <?=number_format($damage->total_amt,2);$d_total = $d_total + $damage->total_amt;?>
	  </div></td>
	<td style="font-weight:bold;<?=$color?>"><div align="right">
	  <?=number_format($pdm,2);?>%</div></td>
	</tr>
<?
}}
?><tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td><div align="right">
    <?=number_format($s_total,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($d_total,2)?>
  </div></td>
  <td></td></tr></tbody></table>
<?
}
elseif($_REQUEST['report']==212) 
{
if($_POST['damage_cause']>0) $damage_con = ' and dc.id="'.$_POST['damage_cause'].'"';

$sql="select i.item_id, i.item_name,sum(c.qty) as qty,c.rate,sum(c.qty*c.rate) as amount,dc.payable ,dc.damage_cause,i.sales_item_type as product_group,i.item_brand

from 

warehouse_damage_receive m, warehouse_damage_receive_detail c, item_info i, damage_cause dc where dc.id=c.receive_type and i.item_id=c.item_id and m.or_no=c.or_no ".$item_con.$date_con.$pg_con.$damage_con." group by i.item_id";

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="5"><?=$str?></td></tr><tr><th>S/L</th>
<th>Brand</th>
<th>Item Name Name</th><th>Cause</th><th>Grp</th><th>Rate</th><th>Qty</th><th>DM Total</th><th>Payable DM</th></tr></thead><tbody>
<?

while($data=mysqli_fetch_object($query)){$s++;
if($data->payable!='Yes'){
$payable_amount = 0;
$dm_amount = $data->amount;
}
else
{
$payable_amount = $data->amount;
$dm_amount = $data->amount;
}


//$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$dm_amount;
$tp_t = $tp_t+$payable_amount;
$qty_t = $qty_t+$data->qty;
?>
<tr><td><?=++$s?></td><td><?=$data->item_brand?></td><td><?=$data->item_name?></td><td><?=$data->damage_cause?></td><td><?=$data->product_group;?></td>
<td><?=$data->rate;?></td><td><?=$data->qty;?></td>

<td><?=number_format($dm_amount,2)?></td><td><?=number_format($payable_amount,2)?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=$qty_t?></td><td><?=number_format($dp_t,2)?></td><td><?=number_format($tp_t,2)?></td></tr></tbody></table>
<?

}
elseif($_REQUEST['report']==111) 
{
$sql="select distinct c.or_no , m.or_no,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot from 
warehouse_damage_receive m,warehouse_damage_receive_detail c,dealer_info d  , warehouse w
where  m.or_no=c.or_no  and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and d.dealer_type = 'Corporate'".$depot_con.$date_con.$pg_con.$dealer_con." order by m.or_date,m.or_no";
$query = db_query($sql);
echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Damage No</th><th>Do No</th><th>Damage Date</th><th>Dealer Name</th><th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th></tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;
$sqld = 'select sum(total_amt) from warehouse_damage_receive_detail  where Damage_no='.$data->Damage_no;
$info = mysqli_fetch_row(db_query($sqld));
$dp_t = $dp_t+$info[0];
$dis = find_a_field('warehouse_damage_receive','sp_discount','or_no="'.$data->or_no.'"');
$tod = ($info[0]*$dis)/100;
$tot = $info[0]-($info[0]*$dis)/100;
$tod_t = $tod_t + $tod;
$tot_t = $tot_t + $tot;
?>
<tr><td><?=$s?></td><td><a href="Damage_view.php?v_no=<?=$data->Damage_no?>" target="_blank"><?=$data->Damage_no?></a></td><td><?=$data->or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=$data->depot?></td><td><?=$info[0]?></td><td><?=$tod?></td><td><?=$tot?></td></tr>
<?
}
echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tod_t,2).'</td><td>'.number_format($tot_t,2).'</td></tr></tbody></table>';

}
elseif($_REQUEST['report']==112) 
{
$sql="select distinct c.or_no , m.or_no,c.or_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot from 
warehouse_damage_receive m,warehouse_damage_receive_detail c,dealer_info d  , warehouse w
where  m.or_no=c.or_no  and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and d.dealer_type = 'SuperShop'".$depot_con.$date_con.$pg_con.$dealer_con." order by m.or_date,m.or_no";
$query = db_query($sql);
echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Damage No</th><th>Do No</th><th>Damage Date</th><th>Dealer Name</th><th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th></tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;
$sqld = 'select sum(total_amt) from warehouse_damage_receive_detail  where Damage_no='.$data->Damage_no;
$info = mysqli_fetch_row(db_query($sqld));
$dp_t = $dp_t+$info[0];
$dis = find_a_field('warehouse_damage_receive','sp_discount','or_no="'.$data->or_no.'"');
$tod = ($info[0]*$dis)/100;
$tot = $info[0]-($info[0]*$dis)/100;
$tod_t = $tod_t + $tod;
$tot_t = $tot_t + $tot;
?>
<tr><td><?=$s?></td><td><a href="Damage_view.php?v_no=<?=$data->Damage_no?>" target="_blank"><?=$data->Damage_no?></a></td><td><?=$data->or_no?></td><td><?=$data->or_date?></td><td><?=$data->dealer_name?></td><td><?=$data->depot?></td><td><?=$info[0]?></td><td><?=$tod?></td><td><?=$tot?></td></tr>
<?
}
echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tod_t,2).'</td><td>'.number_format($tot_t,2).'</td></tr></tbody></table>';

}
elseif($_REQUEST['report']==3) 
{
$sql2 	= "select distinct m.or_no,m.or_no as Damage_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,m.or_date as or_date,d.address_e,d.mobile_no,d.product_group from 
warehouse_damage_receive m, dealer_info d , warehouse w
where m.vendor_id=d.dealer_code and w.warehouse_id=d.depot ".$date_con.$depot_con.$dtype_con.$pg_con.$dealer_con;
$query2 = db_query($sql2);

while($data=mysqli_fetch_object($query2)){
echo '<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid">';
	$dealer_code = $data->dealer_code;
	$Damage_no = $data->Damage_no;
	$dealer_name = $data->dealer_name_e;
	$warehouse_name = $data->warehouse_name;
	$or_date = $data->or_date;
	$or_no = $data->or_no;
		if($dealer_code>0) 
{
$str 	.= '<p style="width:100%">Dealer Name: '.$dealer_name.' - '.$dealer_code.'('.$data->product_group.')</p>';
$str 	.= '<p style="width:100%">Damage NO: '.$Damage_no.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:'.$or_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DO NO: '.$or_no.' 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depot:'.$warehouse_name.'</p>
<p style="width:100%">Destination:'.$data->address_e.'('.$data->mobile_no.')</p>';

$dealer_con = ' and m.vendor_id='.$dealer_code;
$do_con = ' and m.or_no='.$or_no;
$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,da.damage_cause,c.qty,c.rate,(c.rate*c.qty) as total_amt from 
warehouse_damage_receive m,warehouse_damage_receive_detail c, item_info i,dealer_info d , warehouse w,damage_cause da
where c.receive_type = da.id and c.or_no='".$or_no."' and  m.or_no=c.or_no and i.item_id=c.item_id and m.vendor_id=d.dealer_code  and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$do_con." order by m.or_date desc";
}

	echo report_create($sql,1,$str);
		$str = '';
		echo '</div>';
}
}
elseif($_REQUEST['report']==5) 
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
$sql="select m.or_no,m.or_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(qty*rate) from warehouse_damage_receive_detail where or_no=m.or_no) as DM_Total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by or_no";

$sqlt="select  sum(m.qty*m.rate) as DM_total from 
warehouse_damage_receive_detail m,dealer_info d  , warehouse w,area a
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con;

		$queryt = db_query($sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->DM_total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; $str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}
			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$DM_total= $DM_total+$t->DM_total;
		}

	}
	
			if($rp>0){
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region   DM Total: <?=number_format($DM_total,2);$DM_total=0;?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}



}
elseif($_REQUEST['report']==9) 
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
warehouse_damage_receive m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a
where m.or_no=o.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code   and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' group by i.finish_goods_code';

$sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total
from 
warehouse_damage_receive m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a
where m.or_no=o.or_no and m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code   and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.'';

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
elseif($_REQUEST['report']==8) 
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
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where or_no=m.or_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where or_no=m.or_no)  as TP_Total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." and a.AREA_CODE=".$area_id." ".$date_con.$pg_con." order by or_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a,sale_do_details s
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.or_no=m.or_no and a.AREA_CODE=".$area_id." and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;
}
else
{
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where or_no=m.or_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where or_no=m.or_no)  as TP_Total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con." order by or_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
warehouse_damage_receive m,dealer_info d  , warehouse w,area a,sale_do_details s
where   m.vendor_id=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.or_no=m.or_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;
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
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}
}

// Item Wise Sales Vs Damage Report
elseif($_REQUEST['report']==22) {

if($_REQUEST['dealer_code']>0) 	 	$dealer_code=$_REQUEST['dealer_code'];
if($_REQUEST['f_date']>0) 	 		$f_date=$_REQUEST['f_date'];
if($_REQUEST['t_date']>0) 	 		$t_date=$_REQUEST['t_date'];

			if(isset($t_date)) {
			$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
			}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		//if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
		
if($_REQUEST['dealer_code']!='')		$con .= ' and d.dealer_code="'.$_REQUEST['dealer_code'].'"';		


if(isset($product_group)) {			
	if($product_group=='ABD')		{$pg_con = ' and i.sales_item_type in ("A","B","D") ';}
	elseif($product_group=='CE') 	{$pg_con = ' and i.sales_item_type in ("C","E") ';}
	else 							{$pg_con = ' and i.sales_item_type="'.$product_group.'"';}
}
		
if($_REQUEST['region_id']!=''){ $con.= ' and d.region_id="'.$_REQUEST['region_id'].'"';	}	
if($_REQUEST['zone_id']!=''){ $con.= ' and d.zone_id="'.$_REQUEST['zone_id'].'"';	}
if($_REQUEST['area_id']!=''){ $con.= ' and d.area_code="'.$_REQUEST['area_id'].'"';	}		
		
// item list
		$sql='select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.sales_item_type ,
		i.item_brand as brand,
		i.pack_size pkt
		from item_info i where  i.finish_goods_code>0 
		and finish_goods_code not between 2000 and 2010 
		'.$item_brand_con.$pg_con.$item_con.' 
	 order by i.finish_goods_code';
	 

// sales 
$sql2='select 
		i.item_id,
		i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i
		where d.dealer_code=m.dealer_code and m.id=a.order_no and a.unit_price>0 
	 
and a.item_id=i.item_id '.$con.$date_con.$item_con.' 
group by i.item_id';
	
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$this_year_sale_amt[$data2->item_id] = $data2->sale_price;
	$this_year_sale_qty[$data2->item_id] = $data2->qty;
	}

// damage amount
$sql_damage="SELECT i.item_id,i.finish_goods_code as code,i.item_name,sum(dd.qty) as qty, sum(dd.qty*dd.rate) as sale_price 
FROM  warehouse_damage_receive_detail dd, dealer_info d, item_info i, damage_cause dc
where dd.vendor_id = d.dealer_code and dd.item_id = i.item_id and dd.receive_type = dc.id
and dc.payable='Yes' and dd.or_date between '".$f_date."' and '".$t_date."'
".$acon.$con.$warehouse_con.$item_con.$item_brand_con."
group by i.item_id order by code";

	$query2 = db_query($sql_damage);
	while($data2 = mysqli_fetch_object($query2))
	{
	$damage_amt[$data2->item_id] = $data2->sale_price;
	$damage_qty[$data2->item_id] = $data2->qty;
	}


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="9"><?=$str?><div class="left"></div>
<?php 
if($_REQUEST['dealer_code']!=''){ 
$dealer_info = find_all_field('dealer_info','','dealer_code="'.$_REQUEST['dealer_code'].'"');
$region = find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$dealer_info->region_id.'"');
$zone = find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$dealer_info->zone_id.'"');
$area = find_a_field('area','AREA_NAME','AREA_CODE="'.$dealer_info->area_code.'"');
echo "Region: ".$region.", Zone: ".$zone.", Area: ". $area;
}
?>


<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>

<tr><th rowspan="2">S/L-22</th><th rowspan="2">Fg</th>
<th rowspan="2">Item Name</th>
<th rowspan="2">Unit</th><th rowspan="2">Brand</th><th rowspan="2">Pack Size</th><th rowspan="2">GRP</th>
  <th colspan="3" bgcolor="#FFCCFF"><div align="center">Sales </div></th>
  <th colspan="3" bgcolor="#FFFF99"><div align="center">Damage </div></th>
<th>Damage % </th>
</tr>
<tr>
  <th> Ctn </th>
  <th> Qty </th>
  <th> Amount </th>
  <th> Ctn </th>
  <th> Qty </th>
  <th> Amount </th>
  <th>in % </th>
</tr>

</thead><tbody>
<?
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$damage_per = @(($damage_qty[$data->item_id]/$this_year_sale_qty[$data->item_id])*100);
if($damage_qty[$data->item_id]<>0 || $this_year_sale_qty[$data->item_id]<>0){
?>

<tr><td><?=++$s?></td><td><?=$data->fg?></td>
<td><?=$data->item_name?></td><td><?=$data->unit?></td><td><?=$data->brand?></td>
<td><?=$data->pkt?></td><td><?=$data->sales_item_type?></td>

  <td style="text-align:right"><?=(int)($this_year_sale_qty[$data->item_id]/$data->pkt)?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_qty[$data->item_id],0,'',',')?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_amt[$data->item_id],0,'',','); $total_sales +=$this_year_sale_amt[$data->item_id]; ?></td>
  <td style="text-align:right"><?=(int)($damage_qty[$data->item_id]/$data->pkt)?></td>
  <td style="text-align:right"><?=number_format($damage_qty[$data->item_id],0,'',',')?></td>
<td style="text-align:right"><?=number_format($damage_amt[$data->item_id],0,'',','); $total_damage +=$damage_amt[$data->item_id];?></td>
  <td style="text-align:right"><?=number_format(($damage_per),2)?>%</td>
</tr>
<?
} }
?>
<tr>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC"><strong>Total</strong></td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_sales);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_damage);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format((($total_damage/$total_sales)*100),2); ?>%</strong></td>
</tr>
</tbody></table>
<?
}



// Item Wise Sales Vs Damage Report.. without tang
elseif($_REQUEST['report']==706) {

if($_REQUEST['dealer_code']>0) 	 	$dealer_code=$_REQUEST['dealer_code'];
if($_REQUEST['f_date']>0) 	 		$f_date=$_REQUEST['f_date'];
if($_REQUEST['t_date']>0) 	 		$t_date=$_REQUEST['t_date'];

			if(isset($t_date)) {
			$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
			}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		//if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
		
if($_REQUEST['dealer_code']!='')		$con .= ' and d.dealer_code="'.$_REQUEST['dealer_code'].'"';		


if(isset($product_group)) {			
	if($product_group=='ABD')		{$pg_con = ' and i.sales_item_type in ("A","B","D") ';}
	elseif($product_group=='CE') 	{$pg_con = ' and i.sales_item_type in ("C","E") ';}
	else 							{$pg_con = ' and i.sales_item_type="'.$product_group.'"';}
}
		
		
		
// item list
		$sql='select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.sales_item_type ,
		i.item_brand as brand,
		i.pack_size pkt
		from item_info i where  i.finish_goods_code>0 
		and finish_goods_code not between 2000 and 2010 
		and i.item_brand not in("Tang","Bourn Vita","Oreo")
		'.$item_brand_con.$pg_con.$item_con.' 
	 order by i.finish_goods_code';
	 

// sales 
$sql2='select 
		i.item_id,
		i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i
		where d.dealer_code=m.dealer_code and m.id=a.order_no and a.unit_price>0 
	 and i.item_brand not in("Tang","Bourn Vita","Oreo")
and a.item_id=i.item_id '.$con.$date_con.$item_con.' 
group by i.item_id';
	
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$this_year_sale_amt[$data2->item_id] = $data2->sale_price;
	$this_year_sale_qty[$data2->item_id] = $data2->qty;
	}

// damage amount
$sql_damage="SELECT i.item_id,i.finish_goods_code as code,i.item_name,sum(dd.qty) as qty, sum(dd.qty*dd.rate) as sale_price 
FROM  warehouse_damage_receive_detail dd, dealer_info d, item_info i, damage_cause dc
where dd.vendor_id = d.dealer_code and dd.item_id = i.item_id and dd.receive_type = dc.id
and dc.payable='Yes' and dd.or_date between '".$f_date."' and '".$t_date."'
and i.item_brand not in('Tang','Bourn Vita','Oreo')
".$acon.$con.$warehouse_con.$item_con.$item_brand_con."
group by i.item_id order by code";

	$query2 = db_query($sql_damage);
	while($data2 = mysqli_fetch_object($query2))
	{
	$damage_amt[$data2->item_id] = $data2->sale_price;
	$damage_qty[$data2->item_id] = $data2->qty;
	}


?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="9"><?=$str?><div class="left"></div>
<?php 
if($_REQUEST['dealer_code']!=''){ 
$dealer_info = find_all_field('dealer_info','','dealer_code="'.$_REQUEST['dealer_code'].'"');
$region = find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$dealer_info->region_id.'"');
$zone = find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$dealer_info->zone_id.'"');
$area = find_a_field('area','AREA_NAME','AREA_CODE="'.$dealer_info->area_code.'"');
echo "Region: ".$region.", Zone: ".$zone.", Area: ". $area;
}
?>


<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>

<tr><th rowspan="2">S/L-706</th><th rowspan="2">Fg</th>
<th rowspan="2">Item Name</th>
<th rowspan="2">Unit</th><th rowspan="2">Brand</th><th rowspan="2">Pack Size</th><th rowspan="2">GRP</th>
  <th colspan="3" bgcolor="#FFCCFF"><div align="center">Sales </div></th>
  <th colspan="3" bgcolor="#FFFF99"><div align="center">Damage </div></th>
<th>Damage % </th>
</tr>
<tr>
  <th> Ctn </th>
  <th> Qty </th>
  <th> Amount </th>
  <th> Ctn </th>
  <th> Qty </th>
  <th> Amount </th>
  <th>in % </th>
</tr>

</thead><tbody>
<?
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$damage_per = @(($damage_qty[$data->item_id]/$this_year_sale_qty[$data->item_id])*100);
if($damage_qty[$data->item_id]<>0 || $this_year_sale_qty[$data->item_id]<>0){
?>

<tr><td><?=++$s?></td><td><?=$data->fg?></td>
<td><?=$data->item_name?></td><td><?=$data->unit?></td><td><?=$data->brand?></td>
<td><?=$data->pkt?></td><td><?=$data->sales_item_type?></td>

  <td style="text-align:right"><?=(int)($this_year_sale_qty[$data->item_id]/$data->pkt)?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_qty[$data->item_id],0,'',',')?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_amt[$data->item_id],0,'',','); $total_sales +=$this_year_sale_amt[$data->item_id]; ?></td>
  <td style="text-align:right"><?=(int)($damage_qty[$data->item_id]/$data->pkt)?></td>
  <td style="text-align:right"><?=number_format($damage_qty[$data->item_id],0,'',',')?></td>
<td style="text-align:right"><?=number_format($damage_amt[$data->item_id],0,'',','); $total_damage +=$damage_amt[$data->item_id];?></td>
  <td style="text-align:right"><?=number_format(($damage_per),2)?>%</td>
</tr>
<?
} }
?>
<tr>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC"><strong>Total</strong></td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_sales);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_damage);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format((($total_damage/$total_sales)*100),2); ?>%</strong></td>
</tr>
</tbody></table>
<?
} // end 706


// Item Wise Sales Vs Damage Report this year vs last year
elseif($_REQUEST['report']==2200) {

if($_REQUEST['dealer_code']>0) 	 	$dealer_code=$_REQUEST['dealer_code'];
if($_REQUEST['f_date']>0) 	 		$f_date=$_REQUEST['f_date'];
if($_REQUEST['t_date']>0) 	 		$t_date=$_REQUEST['t_date'];

			if(isset($t_date)) {
			$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
			}
			
$lf_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
$lt_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));
$ldate_con=' and a.chalan_date between \''.$lf_date.'\' and \''.$lt_date.'\''; 


/*if($_REQUEST['dealer_type']!=''){
$dealer_type=$_REQUEST['dealer_type'];
}*/
		
//if(isset($dealer_type)) {$con.=' and d.dealer_type="'.$dealer_type.'"';}
if($_REQUEST['dealer_type']!=''){
$dealer_type=$_REQUEST['dealer_type'];
		if($dealer_type=='MordernTrade'){
		$dealer_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';
		} else {
		$dealer_con = ' and d.dealer_type="'.$dealer_type.'"';
		}
}
		
if($_REQUEST['dealer_code']!='')		$con .= ' and d.dealer_code="'.$_REQUEST['dealer_code'].'"';	

 
/*else {
$con .= ' and d.dealer_type="Distributor"';
}*/	


if(isset($product_group)) {			
	if($product_group=='ABD')		{$pg_con = ' and i.sales_item_type in ("A","B","D") ';}
	elseif($product_group=='CE') 	{$pg_con = ' and i.sales_item_type in ("C","E") ';}
	else 							{$pg_con = ' and i.sales_item_type="'.$product_group.'"';}
}

if(isset($region_id)) { $con .= ' and d.region_id="'.$_REQUEST['region_id'].'"'; }
if(isset($zone_id)) { $con .= ' and d.zone_id="'.$_REQUEST['zone_id'].'"'; }
		

// sales 
$sql2='select 
		i.item_id,
		i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,		
		sum(a.total_amt) as sale_price
		from dealer_info d,sale_do_chalan a, item_info i
		where a.dealer_code=d.dealer_code and a.unit_price>0 	 
and a.item_id=i.item_id '.$con.$date_con.$item_con.$dealer_con.' 
group by i.item_id';
	
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$this_year_sale_amt[$data2->item_id] = $data2->sale_price;
	$this_year_sale_qty[$data2->item_id] = $data2->qty;
	}
	
// sales last year
$sql2='select 
		i.item_id,
		i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,		
		sum(a.total_amt) as sale_price
		from dealer_info d,sale_do_chalan a, item_info i
		where a.dealer_code=d.dealer_code and a.unit_price>0 	 
and a.item_id=i.item_id '.$con.$ldate_con.$item_con.$dealer_con.' 
group by i.item_id';
	
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$last_year_sale_amt[$data2->item_id] = $data2->sale_price;
	$last_year_sale_qty[$data2->item_id] = $data2->qty;
	}

// damage amount
$sql_damage="SELECT i.item_id,i.finish_goods_code as code,i.item_name,sum(dd.qty) as qty, sum(dd.qty*dd.rate) as sale_price 
FROM  warehouse_damage_receive_detail dd, dealer_info d, item_info i, damage_cause dc
where dd.vendor_id = d.dealer_code and dd.item_id = i.item_id and dd.receive_type = dc.id
and dc.payable='Yes' and dd.or_date between '".$f_date."' and '".$t_date."'
".$acon.$con.$warehouse_con.$item_con.$item_brand_con.$dealer_con."
group by i.item_id order by code";

	$query2 = db_query($sql_damage);
	while($data2 = mysqli_fetch_object($query2))
	{
	$damage_amt[$data2->item_id] = $data2->sale_price;
	$damage_qty[$data2->item_id] = $data2->qty;
	}

// damage amount last year
$sql_damage="SELECT i.item_id,i.finish_goods_code as code,i.item_name,sum(dd.qty) as qty, sum(dd.qty*dd.rate) as sale_price 
FROM  warehouse_damage_receive_detail dd, dealer_info d, item_info i, damage_cause dc
where dd.vendor_id = d.dealer_code and dd.item_id = i.item_id and dd.receive_type = dc.id
and dc.payable='Yes' and dd.or_date between '".$lf_date."' and '".$lt_date."'
".$acon.$con.$warehouse_con.$item_con.$item_brand_con.$dealer_con."
group by i.item_id order by code";

	$query2 = db_query($sql_damage);
	while($data2 = mysqli_fetch_object($query2))
	{
	$ldamage_amt[$data2->item_id] = $data2->sale_price;
	$ldamage_qty[$data2->item_id] = $data2->qty;
	}
	
// this year good condition
$sql_gc="SELECT item_id,sum(total_amt) as amount
FROM  production_issue_detail
WHERE warehouse_from =51
AND  warehouse_to =3
and pi_date between '".$f_date."' and '".$t_date."'
group by item_id
";

	$query2 = db_query($sql_gc);
	while($data2 = mysqli_fetch_object($query2))
	{
	$gc_amt[$data2->item_id] = $data2->amount;
	}
	
// Last year good condition
$sql_gc="SELECT item_id,sum(total_amt) as amount
FROM  production_issue_detail
WHERE warehouse_from =51
AND  warehouse_to =3
and pi_date between '".$lf_date."' and '".$lt_date."'
group by item_id
";

	$query2 = db_query($sql_gc);
	while($data2 = mysqli_fetch_object($query2))
	{
	$lgc_amt[$data2->item_id] = $data2->amount;
	}		
	

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="13"><?=$str?><div class="left"></div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>

<tr><th rowspan="2">S/L-2200</th>
  <th rowspan="2">GRP</th>
  <th rowspan="2">Brand</th>
  <th rowspan="2">Fg</th>
<th rowspan="2">Item Name</th>
<th rowspan="2">Pack Size</th>
<th rowspan="2">Unit</th>

<th rowspan="2">Sales(Ctn)</th>
<th rowspan="2">Damage(Ctn)</th>
  <th colspan="5" bgcolor="#FFCCFF"><div align="center">This Year </div></th>
  <th colspan="5" bgcolor="#FFFF99"><div align="center">Last Year  </div></th>
</tr>
<tr>
  <th> Sales </th>
  <th> Damage </th>
  <th>Good Condition </th>
  <th>Net Damage</th>
  <th>%</th>
  <th> Sales </th>
  <th> Damage </th>
  <th>Good Condition </th>
  <th>Net Damage</th>
  <th>%</th>
</tr>

</thead><tbody>
<?
// item list
$sql='select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.sales_item_type ,
		i.item_brand as brand,
		i.pack_size pkt
		from item_info i where i.finish_goods_code>0 
		and finish_goods_code not between 2000 and 2004 
		'.$item_brand_con.$pg_con.$item_con.' 
	 order by i.item_brand,i.finish_goods_code';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

//$damage_per = @(($damage_qty[$data->item_id]/$this_year_sale_qty[$data->item_id])*100);
//$ldamage_per = @(($ldamage_qty[$data->item_id]/$last_year_sale_qty[$data->item_id])*100);
if($damage_qty[$data->item_id]<>0 
|| $this_year_sale_qty[$data->item_id]<>0
|| $last_year_sale_qty[$data->item_id]<>0
|| $ldamage_qty[$data->item_id]<>0
){
?>

<tr>
<td><?=++$s?></td>
  <td><?=$data->sales_item_type?></td>
  <td><?=$data->brand?></td>
  <td><?=$data->fg?></td>
<td><?=$data->item_name?></td><td><?=$data->pkt?></td>
<td><?=$data->unit?></td>
<td><span style="text-align:right"><?=(int)($this_year_sale_qty[$data->item_id]/$data->pkt)?></span></td>
<td><span style="text-align:right"><?=(int)($damage_qty[$data->item_id]/$data->pkt)?></span></td>

  <td style="text-align:right"><?=number_format($this_year_sale_amt[$data->item_id],0,'',','); $total_sales +=$this_year_sale_amt[$data->item_id]; ?></td>
  <td style="text-align:right"><?=number_format($damage_amt[$data->item_id],0,'',','); $total_damage +=$damage_amt[$data->item_id];?></td>
  <td style="text-align:right"><?=number_format($gc_amt[$data->item_id],0,'',','); $total_gc +=$gc_amt[$data->item_id];?></td>
  <td style="text-align:right"><? echo $net_damage = ($damage_amt[$data->item_id]-$gc_amt[$data->item_id]); $total_nd +=$net_damage;?></td>
  <td style="text-align:right"><?=number_format((($net_damage/$this_year_sale_amt[$data->item_id])*100),2)?>%</td>
  
  
  <td style="text-align:right"><?=number_format($last_year_sale_amt[$data->item_id],0,'',','); $ltotal_sales +=$last_year_sale_amt[$data->item_id]; ?></td>
  <td style="text-align:right"><?=number_format($ldamage_amt[$data->item_id],0,'',','); $ltotal_damage +=$ldamage_amt[$data->item_id];?></td>
  <td style="text-align:right"><?=number_format($lgc_amt[$data->item_id],0,'',','); $ltotal_gc +=$lgc_amt[$data->item_id];?></td>
  <td style="text-align:right"><? echo $lnet_damage = ($ldamage_amt[$data->item_id]-$lgc_amt[$data->item_id]); $ltotal_nd +=$lnet_damage;?></td>
  <td style="text-align:right"><?=number_format((($lnet_damage/$last_year_sale_amt[$data->item_id])*100),2)?>%</td>
</tr>
<?
} }
?>
<tr>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC"><strong>Total</strong></td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_sales);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_damage);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_gc);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_nd);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format((($total_nd/$total_sales)*100),2); ?>%</strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($ltotal_sales);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($ltotal_damage);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($ltotal_gc);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($ltotal_nd);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format((($ltotal_nd/$ltotal_sales)*100),2); ?>%</strong></td>
</tr>
</tbody></table>
<?
}



// Item Wise Sales Vs Damage Report this year vs last year (Without Tang)
elseif($_REQUEST['report']==702) {

if($_REQUEST['dealer_code']>0) 	 	$dealer_code=$_REQUEST['dealer_code'];
if($_REQUEST['f_date']>0) 	 		$f_date=$_REQUEST['f_date'];
if($_REQUEST['t_date']>0) 	 		$t_date=$_REQUEST['t_date'];

if(isset($t_date)) { $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\''; }
			
$lf_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
$lt_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));
$ldate_con=' and a.chalan_date between \''.$lf_date.'\' and \''.$lt_date.'\''; 


if($_REQUEST['dealer_type']!=''){
$dealer_type=$_REQUEST['dealer_type'];
		if($dealer_type=='MordernTrade'){
		$dealer_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';
		} else {
		$dealer_con = ' and d.dealer_type="'.$dealer_type.'"';
		}
}
		
if($_REQUEST['dealer_code']!='') $con .= ' and d.dealer_code="'.$_REQUEST['dealer_code'].'"';	


if(isset($product_group)) {			
	if($product_group=='ABD')		{$pg_con = ' and i.sales_item_type in ("A","B","D") ';}
	elseif($product_group=='CE') 	{$pg_con = ' and i.sales_item_type in ("C","E") ';}
	
	else {$pg_con = ' and i.sales_item_type="'.$product_group.'"';}
}

if(isset($region_id)) { $con .= ' and d.region_id="'.$_REQUEST['region_id'].'"'; }
if(isset($zone_id))   { $con .= ' and d.zone_id="'.$_REQUEST['zone_id'].'"'; }
		

// sales 
$sql2='select 
		i.item_id,
		i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,		
		sum(a.total_amt) as sale_price
		from dealer_info d,sale_do_chalan a, item_info i
		where a.dealer_code=d.dealer_code and a.unit_price>0 	 
and a.item_id=i.item_id and i.item_brand not in("Tang","Bourn Vita","Oreo")
'.$con.$date_con.$item_con.$dealer_con.' 
group by i.item_id';
	
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$this_year_sale_amt[$data2->item_id] = $data2->sale_price;
	$this_year_sale_qty[$data2->item_id] = $data2->qty;
	}
	
// sales last year
$sql2='select 
		i.item_id,
		i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,		
		sum(a.total_amt) as sale_price
		from dealer_info d,sale_do_chalan a, item_info i
		where a.dealer_code=d.dealer_code and a.unit_price>0 	 
and a.item_id=i.item_id and i.item_brand not in("Tang","Bourn Vita","Oreo")
'.$con.$ldate_con.$item_con.$dealer_con.' 
group by i.item_id';
	
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$last_year_sale_amt[$data2->item_id] = $data2->sale_price;
	$last_year_sale_qty[$data2->item_id] = $data2->qty;
	}

// damage amount
$sql_damage="SELECT i.item_id,i.finish_goods_code as code,i.item_name,sum(dd.qty) as qty, sum(dd.qty*dd.rate) as sale_price 

FROM  warehouse_damage_receive_detail dd, dealer_info d, item_info i, damage_cause dc

where dd.vendor_id = d.dealer_code and dd.item_id = i.item_id and dd.receive_type = dc.id 
and i.item_brand not in('Tang','Bourn Vita','Oreo')
and dc.payable='Yes' and dd.or_date between '".$f_date."' and '".$t_date."'
".$acon.$con.$warehouse_con.$item_con.$item_brand_con.$dealer_con."
group by i.item_id order by code";

	$query2 = db_query($sql_damage);
	while($data2 = mysqli_fetch_object($query2))
	{
	$damage_amt[$data2->item_id] = $data2->sale_price;
	$damage_qty[$data2->item_id] = $data2->qty;
	}

// damage amount last year
$sql_damage="SELECT i.item_id,i.finish_goods_code as code,i.item_name,sum(dd.qty) as qty, sum(dd.qty*dd.rate) as sale_price 
FROM  warehouse_damage_receive_detail dd, dealer_info d, item_info i, damage_cause dc
where dd.vendor_id = d.dealer_code and dd.item_id = i.item_id and dd.receive_type = dc.id 
and i.item_brand not in('Tang','Bourn Vita','Oreo')
and dc.payable='Yes' and dd.or_date between '".$lf_date."' and '".$lt_date."'
".$acon.$con.$warehouse_con.$item_con.$item_brand_con.$dealer_con."
group by i.item_id order by code";

	$query2 = db_query($sql_damage);
	while($data2 = mysqli_fetch_object($query2))
	{
	$ldamage_amt[$data2->item_id] = $data2->sale_price;
	$ldamage_qty[$data2->item_id] = $data2->qty;
	}
	
// this year good condition
$sql_gc="SELECT item_id,sum(total_amt) as amount
FROM  production_issue_detail
WHERE warehouse_from =51
AND  warehouse_to =3
and pi_date between '".$f_date."' and '".$t_date."'
group by item_id
";

	$query2 = db_query($sql_gc);
	while($data2 = mysqli_fetch_object($query2))
	{
	$gc_amt[$data2->item_id] = $data2->amount;
	}
	
// Last year good condition
$sql_gc="SELECT item_id,sum(total_amt) as amount
FROM  production_issue_detail
WHERE warehouse_from =51
AND  warehouse_to =3
and pi_date between '".$lf_date."' and '".$lt_date."'
group by item_id
";

	$query2 = db_query($sql_gc);
	while($data2 = mysqli_fetch_object($query2))
	{
	$lgc_amt[$data2->item_id] = $data2->amount;
	}		
	

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="13"><?=$str?><div class="left"></div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>
<tr>
<th rowspan="2">S/L-702</th>
  <th rowspan="2">GRP</th>
  <th rowspan="2">Brand</th>
  <th rowspan="2">Fg</th>
<th rowspan="2">Item Name</th>
<th rowspan="2">Pack Size</th>
<th rowspan="2">Unit</th>

<th rowspan="2">Sales(Ctn)</th>
<th rowspan="2">Damage(Ctn)</th>
  <th colspan="5" bgcolor="#FFCCFF"><div align="center">This Year </div></th>
  <th colspan="5" bgcolor="#FFFF99"><div align="center">Last Year  </div></th>
</tr>
<tr>
  <th> Sales </th>
  <th> Damage </th>
  <th>Good Condition </th>
  <th>Net Damage</th>
  <th>%</th>
  <th> Sales </th>
  <th> Damage </th>
  <th>Good Condition </th>
  <th>Net Damage</th>
  <th>%</th>
</tr>
</thead><tbody>
<?
// item list
$sql='select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.sales_item_type ,
		i.item_brand as brand,
		i.pack_size pkt
		from item_info i 
		where i.finish_goods_code>0 
		and finish_goods_code not between 2000 and 2004 and i.item_brand not in("Tang","Bourn Vita","Oreo")
		'.$item_brand_con.$pg_con.$item_con.' 
	 order by i.item_brand,i.finish_goods_code';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

//$damage_per = @(($damage_qty[$data->item_id]/$this_year_sale_qty[$data->item_id])*100);
//$ldamage_per = @(($ldamage_qty[$data->item_id]/$last_year_sale_qty[$data->item_id])*100);
if($damage_qty[$data->item_id]<>0 
|| $this_year_sale_qty[$data->item_id]<>0
|| $last_year_sale_qty[$data->item_id]<>0
|| $ldamage_qty[$data->item_id]<>0
){
?>

<tr>
<td><?=++$s?></td>
  <td><?=$data->sales_item_type?></td>
  <td><?=$data->brand?></td>
  <td><?=$data->fg?></td>
<td><?=$data->item_name?></td><td><?=$data->pkt?></td>
<td><?=$data->unit?></td>
<td><span style="text-align:right"><?=(int)($this_year_sale_qty[$data->item_id]/$data->pkt)?></span></td>
<td><span style="text-align:right"><?=(int)($damage_qty[$data->item_id]/$data->pkt)?></span></td>

  <td style="text-align:right"><?=number_format($this_year_sale_amt[$data->item_id],0,'',','); $total_sales +=$this_year_sale_amt[$data->item_id]; ?></td>
  <td style="text-align:right"><?=number_format($damage_amt[$data->item_id],0,'',','); $total_damage +=$damage_amt[$data->item_id];?></td>
  <td style="text-align:right"><?=number_format($gc_amt[$data->item_id],0,'',','); $total_gc +=$gc_amt[$data->item_id];?></td>
  <td style="text-align:right"><? echo $net_damage = ($damage_amt[$data->item_id]-$gc_amt[$data->item_id]); $total_nd +=$net_damage;?></td>
  <td style="text-align:right"><?=number_format((($net_damage/$this_year_sale_amt[$data->item_id])*100),2)?>%</td>
  
  
  <td style="text-align:right"><?=number_format($last_year_sale_amt[$data->item_id],0,'',','); $ltotal_sales +=$last_year_sale_amt[$data->item_id]; ?></td>
  <td style="text-align:right"><?=number_format($ldamage_amt[$data->item_id],0,'',','); $ltotal_damage +=$ldamage_amt[$data->item_id];?></td>
  <td style="text-align:right"><?=number_format($lgc_amt[$data->item_id],0,'',','); $ltotal_gc +=$lgc_amt[$data->item_id];?></td>
  <td style="text-align:right"><? echo $lnet_damage = ($ldamage_amt[$data->item_id]-$lgc_amt[$data->item_id]); $ltotal_nd +=$lnet_damage;?></td>
  <td style="text-align:right"><?=number_format((($lnet_damage/$last_year_sale_amt[$data->item_id])*100),2)?>%</td>
</tr>
<?
} 
}
?>
<tr>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC"><strong>Total</strong></td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC">&nbsp;</td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_sales);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_damage);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_gc);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($total_nd);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format((($total_nd/$total_sales)*100),2); ?>%</strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($ltotal_sales);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($ltotal_damage);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($ltotal_gc);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format($ltotal_nd);?></strong></td>
  <td bgcolor="#00CCCC" style="text-align:right"><strong><?=number_format((($ltotal_nd/$ltotal_sales)*100),2); ?>%</strong></td>
</tr>
</tbody></table>
<?
} // end 702




elseif($_REQUEST['report']==107) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L-107</span></td>
    <td bgcolor="#333333"><span class="style3 style1">REGION NAME-107</span></td>

    <td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>E</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>E</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>E</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 

if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$sql = "select BRANCH_ID,BRANCH_NAME from branch  order by BRANCH_NAME";

$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$BRANCH_ID = $item->BRANCH_ID;
${'totalr'.$BRANCH_ID} = 0;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='E' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmone'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totald'} = ${'totald'} + ${'sqlmond'}[0];
${'totale'} = ${'totale'} + ${'sqlmone'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] +${'sqlmond'}[0] +${'sqlmone'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$BRANCH_ID} = ${'totalr'.$BRANCH_ID} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='E' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmone'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotald'} = ${'dtotald'} + ${'dsqlmond'}[0];
${'dtotale'} = ${'dtotale'} + ${'dsqlmone'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] +${'dsqlmond'}[0] +${'dsqlmone'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$BRANCH_ID} = ${'dtotalr'.$BRANCH_ID} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&report=108&region_id=<?=$BRANCH_ID?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$item->BRANCH_NAME?></a></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmone'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$BRANCH_ID};echo number_format(${'totalr'.$BRANCH_ID},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmone'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$BRANCH_ID};echo number_format(${'dtotalr'.$BRANCH_ID},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmond'}[0]/${'sqlmond'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmone'}[0]/${'sqlmone'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }




$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

${'sqlmonco'} = mysqli_fetch_row(db_query($sqql));
$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Corporate'".$con;

${'dsqlmonco'} = mysqli_fetch_row(db_query($sqql));
  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>D Total</strong></td>

<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalb'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totald'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totale'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotald'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'dtotale'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotald'}*100/${'totald'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotale'}*100/${'totale'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&report=110&dealer_type=Corporate&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>">Corporate</a></td>
	

<td colspan="6" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'sqlmonco'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'sqlmonco'}[0],2);?>
</strong></div></td>
<td colspan="6" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'dsqlmonco'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'dsqlmonco'}[0],2);?>
</strong></div></td>
<td colspan="6" bgcolor="#99CCFF"><div align="center">
  <?=@number_format(${'dsqlmonco'}[0]*100/${'sqlmonco'}[0],2);?>
  %</div></td>
    </tr>
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];



$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td><a target="_blank"  href="?submit=1&report=110&dealer_type=SuperShop&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>">SuperShop</a></td>

<td colspan="6" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'sqlmonsu'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'sqlmonsu'}[0],2);?>
</strong></div></td>
<td colspan="6" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'dsqlmonsu'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'dsqlmonsu'}[0],2);?>
</strong></div></td>
<td colspan="6" bgcolor="#99CCFF"><div align="center">
  <?=@number_format(${'dsqlmonsu'}[0]*100/${'sqlmonsu'}[0],2);?>
  %</div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
  <td>&nbsp;</td>
  <td><strong>Corporate+SuperShop</strong></td>


<td colspan="6" bgcolor="#FFFF66"><div align="center">
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?>
</div></td>

<td bgcolor="#FFFF99"><div align="right">
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?>
</div></td>
<td colspan="6" bgcolor="#FFFF66"><div align="center">
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?>
</div></td>
<td colspan="6" bgcolor="#FFFF66"><div align="center">
  <?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0])*100/($sqlmonsu[0]+$sqlmonco[0]),2);?>
  %</div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>N Total</strong>  <div align="center"></div></td>
<td colspan="6">&nbsp;</td>
<?

${'totalallall'} = ${'totalallall'} + (${'totalc'}+${'totals'}+${'totalco'});
?>
<td bgcolor="#FF3333"><div align="right"><strong>
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]+$totalall),2);?>
</strong></div></td>
<td colspan="6">&nbsp;</td>
<td bgcolor="#FF3333"><div align="right"><strong>
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$dtotalall),2);?>
</strong></div></td>
<td colspan="6" bgcolor="#FF9999"><div align="center"><strong>
  <?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$dtotalall)*100/($sqlmonsu[0]+$sqlmonco[0]+$totalall),2);?>
  %</strong></div></td>
</tr>
</table></td>
</tr>


</table>
<?
}


elseif($_REQUEST['report']==10777) 
{
echo $str;
$dated_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';

$sql_chalan='select d.region_id,d.product_group,sum(c.total_amt) as sales_amount 
from sale_do_chalan c,dealer_info d 
where 
c.unit_price>0 
and c.dealer_code=d.dealer_code 
and d.dealer_type="Distributor"
'.$dated_con.'
and d.product_group="'.$product_group.'"
group by d.region_id,d.product_group
';

$res1 = db_query($sql_chalan);
	while($row=mysqli_fetch_object($res1))
	{
		$chalan_amount[$row->region_id] = $row->sales_amount;
	}
	
// damage amount
$sqql = "select d.region_id,d.product_group,sum(c.amount) as damage_amount 
from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc 
where dc.payable='Yes' 
and dc.id=c.receive_type 
and c.or_date between '".$f_date."' and '".$t_date."' 
and c.vendor_id=d.dealer_code and 
d.dealer_type='Distributor' 
and d.product_group='".$product_group."'
group by d.region_id,d.product_group
";

$res1 = db_query($sqql);
	while($row=mysqli_fetch_object($res1))
	{
		$damage_amount[$row->region_id] = $row->damage_amount;
	}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L-10777</span></td>
    <td bgcolor="#333333"><span class="style3 style1">REGION NAME</span></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">Ratio</span></div></td>
  </tr>
	
<?
$sql = "select BRANCH_ID,BRANCH_NAME from branch order by BRANCH_NAME";
$query = @db_query($sql);
while($data=@mysqli_fetch_object($query)){
?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td><a target="_blank"  href="?submit=1&report=10888&region_id=<?=$data->BRANCH_ID?>&product_group=<?=$_REQUEST['product_group']?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$data->BRANCH_NAME?></a></td>

<td bgcolor="#99CCFF"><div align="right"><?=$chalan_amount[$data->BRANCH_ID];?></div></td>
<td bgcolor="#99CCFF"><div align="right"><?=$damage_amount[$data->BRANCH_ID];?></div></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(@(($damage_amount[$data->BRANCH_ID]/$chalan_amount[$data->BRANCH_ID])*100),2);?>%</div></td>
</tr>
<? 
$tsales_a += $chalan_amount[$data->BRANCH_ID];
$tdamage_a += $damage_amount[$data->BRANCH_ID];
}



$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

${'sqlmonco'} = mysqli_fetch_row(db_query($sqql));
$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Corporate'".$con;

${'dsqlmonco'} = mysqli_fetch_row(db_query($sqql));
  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>Distributor Total</strong></td>


<td bgcolor="#FFFF66"><div align="right"><?=number_format($tsales_a,2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format($tdamage_a,2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'tdamage_a'}*100/${'tsales_a'},2);?>%</div></td>
</tr>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td>Corporate</td>
	

<td bgcolor="#99CCFF"><div align="center"><?=number_format(${'sqlmonco'}[0],2);?></div></td>
<td bgcolor="#99CCFF"><div align="center"><?=number_format(${'dsqlmonco'}[0],2);?></div></td>
<td colspan="1" bgcolor="#99CCFF"><div align="center"><?=@number_format(${'dsqlmonco'}[0]*100/${'sqlmonco'}[0],2);?>%</div></td>
</tr>


<?
$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];


$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td>SuperShop</td>

<td colspan="1" bgcolor="#99CCFF"><div align="center"><?=number_format(${'sqlmonsu'}[0],2);?></div></td>
<td colspan="1" bgcolor="#99CCFF"><div align="center"><?=number_format(${'dsqlmonsu'}[0],2);?></div></td>
<td colspan="1" bgcolor="#99CCFF"><div align="center"><?=@number_format(${'dsqlmonsu'}[0]*100/${'sqlmonsu'}[0],2);?>%</div></td>
</tr>


<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>Corporate+SuperShop</strong></td>


<td colspan="1" bgcolor="#FFFF66"><div align="center"><?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?></div></td>
<td colspan="1" bgcolor="#FFFF66"><div align="center"><?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?></div></td>
<td colspan="1" bgcolor="#FFFF66"><div align="center"><?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0])*100/($sqlmonsu[0]+$sqlmonco[0]),2);?>%</div></td>
</tr>

<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>N Total</strong>  <div align="center"></div></td>
<td colspan="1"><strong>
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]+$tsales_a),2);?>
</strong></td>
<?

${'totalallall'} = ${'totalallall'} + (${'totalc'}+${'totals'}+${'totalco'});
?>
<td bgcolor="#FF3333"><div align="right"><strong><?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$tdamage_a),2);?></strong></div></td>
<td colspan="6" bgcolor="#FF9999"><div align="center"><strong><?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$tdamage_a)*100/($sqlmonsu[0]+$sqlmonco[0]+$tsales_a),2);?>%</strong></div></td>
</tr>
</table></td>
</tr>


</table>
<?
}


// region wise (without tang)
elseif($_REQUEST['report']==705) {

echo $str;
$dated_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';

// Sales amount
$sql_chalan='select d.region_id,d.product_group,sum(c.total_amt) as sales_amount 
from sale_do_chalan c,dealer_info d , item_info i
where 
c.unit_price>0 
and c.dealer_code=d.dealer_code and i.item_id =c.item_id
and i.item_brand not in("Tang","Bourn Vita","Oreo")
and d.dealer_type="Distributor"
'.$dated_con.'
and d.product_group="'.$product_group.'"
group by d.region_id,d.product_group
';

$res1 = db_query($sql_chalan);
	while($row=mysqli_fetch_object($res1))
	{
		$chalan_amount[$row->region_id] = $row->sales_amount;
	}
	
// damage amount
$sqql = "select d.region_id,d.product_group,sum(c.amount) as damage_amount 
from warehouse_damage_receive_detail c,dealer_info d, item_info i,damage_cause dc 
where dc.payable='Yes' and i.item_id=c.item_id and dc.id=c.receive_type 
and c.or_date between '".$f_date."' and '".$t_date."' 
and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' 
and i.item_brand not in('Tang','Bourn Vita','Oreo')
and d.product_group='".$product_group."'
group by d.region_id,d.product_group
";

$res1 = db_query($sqql);
	while($row=mysqli_fetch_object($res1))
	{
		$damage_amount[$row->region_id] = $row->damage_amount;
	}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L-705</span></td>
    <td bgcolor="#333333"><span class="style3 style1">REGION NAME</span></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">Ratio</span></div></td>
  </tr>
	
<?
$sql = "select BRANCH_ID,BRANCH_NAME from branch order by BRANCH_NAME";
$query = @db_query($sql);
while($data=@mysqli_fetch_object($query)){
?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td><a target="_blank"  href="?submit=1&report=704&region_id=<?=$data->BRANCH_ID?>&product_group=<?=$_REQUEST['product_group']?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$data->BRANCH_NAME?></a></td>

<td bgcolor="#99CCFF"><div align="right"><?=$chalan_amount[$data->BRANCH_ID];?></div></td>
<td bgcolor="#99CCFF"><div align="right"><?=$damage_amount[$data->BRANCH_ID];?></div></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(@(($damage_amount[$data->BRANCH_ID]/$chalan_amount[$data->BRANCH_ID])*100),2);?>%</div></td>
</tr>
<? 
$tsales_a += $chalan_amount[$data->BRANCH_ID];
$tdamage_a += $damage_amount[$data->BRANCH_ID];
}


// Sales corporate
$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d, item_info i
where c.chalan_date between '".$f_date."' and '".$t_date."' 
and i.item_brand not in('Tang','Bourn Vita','Oreo') 
and c.unit_price>0 and c.dealer_code=d.dealer_code and i.item_id =c.item_id and d.dealer_type='Corporate'".$con;

${'sqlmonco'} = mysqli_fetch_row(db_query($sqql));


// Damage corporate
$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc , item_info i
where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' 
and i.item_id=c.item_id and i.item_brand not in('Tang','Bourn Vita','Oreo')
and c.vendor_id=d.dealer_code and d.dealer_type='Corporate'".$con;

${'dsqlmonco'} = mysqli_fetch_row(db_query($sqql));
  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>Distributor Total</strong></td>


<td bgcolor="#FFFF66"><div align="right"><?=number_format($tsales_a,2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format($tdamage_a,2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'tdamage_a'}*100/${'tsales_a'},2);?>%</div></td>
</tr>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td>Corporate</td>
	

<td bgcolor="#99CCFF"><div align="center"><?=number_format(${'sqlmonco'}[0],2);?></div></td>
<td bgcolor="#99CCFF"><div align="center"><?=number_format(${'dsqlmonco'}[0],2);?></div></td>
<td colspan="1" bgcolor="#99CCFF"><div align="center"><?=@number_format(${'dsqlmonco'}[0]*100/${'sqlmonco'}[0],2);?>%</div></td>
</tr>


<?
// sales supershop
$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d , item_info i
where c.chalan_date between '".$f_date."' and '".$t_date."'  
and i.item_id =c.item_id and i.item_brand not in('Tang','Bourn Vita','Oreo')
and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];


// Damage supershop
$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc, item_info i 
where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' 
and i.item_id=c.item_id and i.item_brand not in('Tang','Bourn Vita','Oreo')
and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td>SuperShop</td>

<td colspan="1" bgcolor="#99CCFF"><div align="center"><?=number_format(${'sqlmonsu'}[0],2);?></div></td>
<td colspan="1" bgcolor="#99CCFF"><div align="center"><?=number_format(${'dsqlmonsu'}[0],2);?></div></td>
<td colspan="1" bgcolor="#99CCFF"><div align="center"><?=@number_format(${'dsqlmonsu'}[0]*100/${'sqlmonsu'}[0],2);?>%</div></td>
</tr>


<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>Corporate+SuperShop</strong></td>


<td colspan="1" bgcolor="#FFFF66"><div align="center"><?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?></div></td>
<td colspan="1" bgcolor="#FFFF66"><div align="center"><?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?></div></td>
<td colspan="1" bgcolor="#FFFF66"><div align="center"><?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0])*100/($sqlmonsu[0]+$sqlmonco[0]),2);?>%</div></td>
</tr>

<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>N Total</strong>  <div align="center"></div></td>
<td colspan="1"><strong>
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]+$tsales_a),2);?>
</strong></td>
<?

${'totalallall'} = ${'totalallall'} + (${'totalc'}+${'totals'}+${'totalco'});
?>
<td bgcolor="#FF3333"><div align="right"><strong><?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$tdamage_a),2);?></strong></div></td>
<td colspan="6" bgcolor="#FF9999"><div align="center"><strong><?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$tdamage_a)*100/($sqlmonsu[0]+$sqlmonco[0]+$tsales_a),2);?>%</strong></div></td>
</tr>
</table></td>
</tr>


</table>
<?
} // end 705


elseif($_REQUEST['report']==10888) 
{
echo $str;
$dated_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
if($_REQUEST['region_id']>0)
$xcon .= ' and d.region_id='.$_REQUEST['region_id'];

if($_REQUEST['region_id']>0)
$region_con = ' and REGION_ID="'.$_REQUEST['region_id'].'"';

if(isset($product_group)) {$pg_con=' and d.product_group="'.$product_group.'"';} 

$sql_chalan='select d.zone_id,sum(c.total_amt) as sales_amount 
from sale_do_chalan c, dealer_info d 
where 
c.unit_price>0 
and c.dealer_code=d.dealer_code 
and d.dealer_type="Distributor"
'.$dated_con.$pg_con.'
group by d.zone_id
';

$res1 = db_query($sql_chalan);
	while($row=mysqli_fetch_object($res1))
	{
		$chalan_amount[$row->zone_id] = $row->sales_amount;
	}
	
// damage amount
$sqql = "select d.zone_id,sum(c.amount) as damage_amount 
from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc 
where dc.payable='Yes' 
and dc.id=c.receive_type 
and c.or_date between '".$f_date."' and '".$t_date."' 
and c.vendor_id=d.dealer_code and 
d.dealer_type='Distributor' 
".$pg_con."
group by d.zone_id
";

$res1 = db_query($sqql);
	while($row=mysqli_fetch_object($res1))
	{
		$damage_amount[$row->zone_id] = $row->damage_amount;
	}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L-10888</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Region NAME</span></td>
    <td bgcolor="#333333"><span class="style3 style1">ZONE NAME</span></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">Ratio</span></div></td>
  </tr>
	
<?
$sql = "select b.BRANCH_NAME as region_name,z.ZONE_CODE,z.ZONE_NAME from zon z,branch b where z.REGION_ID=b.BRANCH_ID 
".$region_con."
order by z.REGION_ID,z.ZONE_NAME";
$query = @db_query($sql);
while($data=@mysqli_fetch_object($query)){
?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td><?=$data->region_name?></td>
<td><a target="_blank"  href="?submit=1&report=11333&zone_id=<?=$data->ZONE_CODE?>&product_group=<?=$_REQUEST['product_group']?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$data->ZONE_NAME?></a></td>

<td bgcolor="#99CCFF"><div align="right"><?=$chalan_amount[$data->ZONE_CODE];?></div></td>
<td bgcolor="#99CCFF"><div align="right"><?=$damage_amount[$data->ZONE_CODE];?></div></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(@(($damage_amount[$data->ZONE_CODE]/$chalan_amount[$data->ZONE_CODE])*100),2);?>%</div></td>
</tr>
<? 
$tsales_a += $chalan_amount[$data->ZONE_CODE];
$tdamage_a += $damage_amount[$data->ZONE_CODE];
}


  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong> Total</strong></td>


<td bgcolor="#FFFF66"><div align="right"><?=number_format($tsales_a,2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format($tdamage_a,2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'tdamage_a'}*100/${'tsales_a'},2);?>%</div></td>
</tr>

</table></td>
</tr>


</table>
<?
}


elseif($_REQUEST['report']==704){

echo $str;
$dated_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
if($_REQUEST['region_id']>0)
$xcon .= ' and d.region_id='.$_REQUEST['region_id'];

if($_REQUEST['region_id']>0)
$region_con = ' and REGION_ID="'.$_REQUEST['region_id'].'"';

if(isset($product_group)) {$pg_con=' and d.product_group="'.$product_group.'"';} 

$sql_chalan='select d.zone_id,sum(c.total_amt) as sales_amount 
from sale_do_chalan c, dealer_info d , item_info i
where 
c.unit_price>0 and c.item_id=i.item_id
and i.item_brand not in("Tang","Bourn Vita","Oreo")
and c.dealer_code=d.dealer_code 
and d.dealer_type="Distributor"
'.$dated_con.$pg_con.'
group by d.zone_id
';

$res1 = db_query($sql_chalan);
	while($row=mysqli_fetch_object($res1))
	{
		$chalan_amount[$row->zone_id] = $row->sales_amount;
	}
	
// damage amount
$sqql = "select d.zone_id,sum(c.amount) as damage_amount 
from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc , item_info i
where dc.payable='Yes' and i.item_id = c.item_id
and dc.id=c.receive_type 
and c.or_date between '".$f_date."' and '".$t_date."' 
and c.vendor_id=d.dealer_code and i.item_brand not in('Tang','Bourn Vita','Oreo')
and d.dealer_type='Distributor' 
".$pg_con."
group by d.zone_id
";

$res1 = db_query($sqql);
	while($row=mysqli_fetch_object($res1))
	{
		$damage_amount[$row->zone_id] = $row->damage_amount;
	}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L-704</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Region NAME</span></td>
    <td bgcolor="#333333"><span class="style3 style1">ZONE NAME</span></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td colspan="1" bgcolor="#333333"><div align="center" class="style1"><span class="style3">Ratio</span></div></td>
  </tr>
	
<?
$sql = "select b.BRANCH_NAME as region_name,z.ZONE_CODE,z.ZONE_NAME 
from zon z,branch b 
where z.REGION_ID=b.BRANCH_ID 
".$region_con."
order by z.REGION_ID,z.ZONE_NAME";
$query = @db_query($sql);
while($data=@mysqli_fetch_object($query)){
?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td><?=$data->region_name?></td>
<td><a target="_blank"  href="?submit=1&report=701&zone_id=<?=$data->ZONE_CODE?>&product_group=<?=$_REQUEST['product_group']?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$data->ZONE_NAME?></a></td>

<td bgcolor="#99CCFF"><div align="right"><?=$chalan_amount[$data->ZONE_CODE];?></div></td>
<td bgcolor="#99CCFF"><div align="right"><?=$damage_amount[$data->ZONE_CODE];?></div></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(@(($damage_amount[$data->ZONE_CODE]/$chalan_amount[$data->ZONE_CODE])*100),2);?>%</div></td>
</tr>
<? 
$tsales_a += $chalan_amount[$data->ZONE_CODE];
$tdamage_a += $damage_amount[$data->ZONE_CODE];
}


  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong> Total</strong></td>


<td bgcolor="#FFFF66"><div align="right"><?=number_format($tsales_a,2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format($tdamage_a,2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'tdamage_a'}*100/${'tsales_a'},2);?>%</div></td>
</tr>

</table></td>
</tr>


</table>
<?
} // end 704



elseif($_REQUEST['report']==108) 
{
echo $str;

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L-108</span></td>
    <td bgcolor="#333333"><span class="style3 style1">ZONE NAME </span></td>

<td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
    <td bgcolor="#0099CC">E</td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
    <td bgcolor="#0099CC">E</td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
    <td bgcolor="#0099CC">E</td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 

if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
if($_REQUEST['region_id']>0) 		{$rcon=' and REGION_ID="'.$_REQUEST['region_id'].'" ';}
$sql = "select ZONE_CODE,ZONE_NAME from zon where 1 ".$rcon." order by ZONE_NAME";

$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$ZONE_CODE = $item->ZONE_CODE;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='E' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmone'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totald'} = ${'totald'} + ${'sqlmond'}[0];
${'totale'} = ${'totale'} + ${'sqlmone'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] +  + ${'sqlmond'}[0] +${'sqlmone'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$ZONE_CODE} = ${'totalr'.$ZONE_CODE} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='E' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmone'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotald'} = ${'dtotald'} + ${'dsqlmond'}[0];
${'dtotale'} = ${'dtotale'} + ${'dsqlmone'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] +  ${'dsqlmond'}[0] +${'dsqlmone'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$ZONE_CODE} = ${'dtotalr'.$ZONE_CODE} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&report=113&zone_id=<?=$ZONE_CODE?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$item->ZONE_NAME?></a></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmone'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$ZONE_CODE};echo number_format(${'totalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmone'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$ZONE_CODE};echo number_format(${'dtotalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmond'}[0]/${'sqlmond'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmone'}[0]/${'sqlmone'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="2"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalb'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totald'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totale'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);$totalall=0;?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotald'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotale'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotald'}*100/${'totald'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotale'}*100/${'totale'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>

</table></td>
</tr>

</table>
<?
}


elseif($_REQUEST['report']==109) {

echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  
  <tr>
	<td bgcolor="#333333"><span class="style3 style1">S/L-109</span></td>
	<td bgcolor="#333333"><span class="style3 style1">DEALER NAME </span></td>
	<td bgcolor="#333333"><span class="style3 style1">Status</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Region</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Zone</span> </td>
	<td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
	<td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
	<td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
		<td bgcolor="#0099CC">E</td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
		<td bgcolor="#0099CC">E</td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
		<td bgcolor="#0099CC">E</td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
<?
if(isset($item_id)) {$con=' and c.item_id="'.$item_id.'"';}
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,a.AREA_NAME as area from area a,dealer_info d 
where d.area_code=a.AREA_CODE and a.ZONE_ID=".$_REQUEST['zone_id']." order by dealer_name_e";
if($_REQUEST['region_id']>0)
$xcon .= 'and z.REGION_ID='.$_REQUEST['region_id'];
elseif($_REQUEST['zone_id']>0)
$xcon .= 'and a.ZONE_ID='.$_REQUEST['zone_id'];
elseif($_REQUEST['area_id']>0)
$xcon .= 'and a.AREA_CODE='.$_REQUEST['area_id'];

if($_REQUEST['product_group']!='')
$xcon .= ' and d.product_group="'.$_REQUEST['product_group'].'"';

if(isset($dealer_code)) 	{$dealer_code_con=' and d.dealer_code="'.$dealer_code.'"';}

//if(isset($dealer_type)) 		{$dealer_typecon = ' and d.dealer_type="'.$dealer_type.'"';}

$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,d.canceled, a.AREA_NAME as area,z.ZONE_NAME zone,b.BRANCH_NAME branch 
from area a,branch b,zon z, dealer_info d where z.region_id=b.BRANCH_ID and 
 z.ZONE_CODE=a.ZONE_ID and d.area_code=a.AREA_CODE 
 and d.dealer_type='Distributor' ".$xcon.$dealer_code_con." order by dealer_name_e";
$query = @db_query($sql);
while($dealer=@mysqli_fetch_object($query)){

$dealer_code = $dealer->dealer_code;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='E' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmone'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totald'} = ${'totald'} + ${'sqlmond'}[0];
${'totale'} = ${'totale'} + ${'sqlmone'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] +  ${'sqlmond'}[0] + ${'sqlmone'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='E' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmone'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotald'} = ${'dtotald'} + ${'dsqlmond'}[0];
${'dtotale'} = ${'dtotale'} + ${'dsqlmone'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] +  ${'dsqlmond'}[0] + ${'dsqlmone'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$dealer_code} = ${'dtotalr'.$dealer_code} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&amp;report=22&amp;dealer_code=<?=$dealer_code?>&amp;f_date=<?=$_REQUEST['f_date']?>&amp;t_date=<?=$_REQUEST['t_date']?>">
      <?=$dealer_code.'-'.$dealer->dealer_name?>
    </a></td>
    <td><?=$dealer->canceled?></td>
    <td><?=$dealer->branch?></td>
    <td><?=$dealer->zone?></td>
    <td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmone'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$dealer_code};echo number_format(${'totalr'.$dealer_code},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmone'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$dealer_code};echo number_format(${'dtotalr'.$dealer_code},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmond'}[0]/${'sqlmond'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmone'}[0]/${'sqlmone'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="5"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalb'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totald'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totale'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotald'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotale'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotald'}*100/${'totald'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotale'}*100/${'totald'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>

</table>


<?
}



elseif($_REQUEST['report']==113) { // party wise sales vs damage

echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  
  <tr>
	<td bgcolor="#333333"><span class="style3 style1">S/L-113</span></td>
	<td bgcolor="#333333"><span class="style3 style1">DEALER NAME </span></td>
	<td bgcolor="#333333"><span class="style3 style1">Group</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Status</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Region</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Zone</span> </td>
	<td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
	<td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
	<td colspan="6" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
		<td bgcolor="#0099CC">E</td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
		<td bgcolor="#0099CC">E</td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
		<td bgcolor="#0099CC">E</td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
<?
if(isset($item_id)) {$con=' and c.item_id="'.$item_id.'"';}
if(isset($dealer_code)) 	{$dealer_code_con=' and d.dealer_code="'.$dealer_code.'"';}

if($_REQUEST['region_id']>0)
$xcon .= ' and d.region_id='.$_REQUEST['region_id'];
elseif($_REQUEST['zone_id']>0)
$xcon .= ' and d.zone_id='.$_REQUEST['zone_id'];
elseif($_REQUEST['area_id']>0)
$xcon .= ' and d.area_code='.$_REQUEST['area_id'];

if($_REQUEST['product_group']!='')
$xcon .= ' and d.product_group="'.$_REQUEST['product_group'].'"';

// Sales Group A
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' 
".$con.$xcon." group by c.dealer_code";
$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_a[$data->dealer_code] = $data->amount;
}


// Sales Group B
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' ".$con.$xcon." group by c.dealer_code";
$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_b[$data->dealer_code] = $data->amount;
}


// Sales Group C
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' ".$con.$xcon." group by c.dealer_code";
$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_c[$data->dealer_code] = $data->amount;
}


// Sales Group D
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' ".$con.$xcon." group by c.dealer_code";
$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_d[$data->dealer_code] = $data->amount;
}


// Sales Group E
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='E' ".$con.$xcon." group by c.dealer_code";
$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_e[$data->dealer_code] = $data->amount;
}


// Sales Group M
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' ".$con.$xcon." group by c.dealer_code";
$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_m[$data->dealer_code] = $data->amount;
}

// Damage A
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' ".$con.$xcon." group by c.vendor_id";
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_a[$data->dealer_code] = $data->amount;
}

// Damage B
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' ".$con.$xcon." group by c.vendor_id";
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_b[$data->dealer_code] = $data->amount;
}


// Damage C
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' ".$con.$xcon." group by c.vendor_id";
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_c[$data->dealer_code] = $data->amount;
}


// Damage D
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' ".$con.$xcon." group by c.vendor_id";
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_d[$data->dealer_code] = $data->amount;
}


// Damage E
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='E' ".$con.$xcon." group by c.vendor_id";
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_e[$data->dealer_code] = $data->amount;
}

// Damage M
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' ".$con.$xcon." group by c.vendor_id";
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_m[$data->dealer_code] = $data->amount;
}


// --------- Dealer List
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,d.canceled, a.AREA_NAME as area,z.ZONE_NAME zone,b.BRANCH_NAME branch,d.product_group as grp 
from area a,branch b,zon z, dealer_info d where z.region_id=b.BRANCH_ID and 
 z.ZONE_CODE=a.ZONE_ID and d.area_code=a.AREA_CODE 
 and d.dealer_type='Distributor' ".$xcon.$dealer_code_con.$xcon." order by d.product_group,d.dealer_code";
$query = db_query($sql);
while($dealer= mysqli_fetch_object($query)){
$dealer_code=$dealer->dealer_code;
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank" href="?submit=1&amp;report=22&amp;dealer_code=<?=$dealer_code?>&amp;f_date=<?=$_REQUEST['f_date']?>&amp;t_date=<?=$_REQUEST['t_date']?>">
      <?=$dealer_code.'-'.$dealer->dealer_name?>
    </a></td>
    <td><?=$dealer->grp?></td>
    <td><?=$dealer->canceled?></td>
    <td><?=$dealer->branch?></td>
    <td><?=$dealer->zone?></td>
    <td bgcolor="#99CCFF"><?=number_format($sales_a[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($sales_b[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($sales_c[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($sales_d[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($sales_e[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($sales_m[$dealer->dealer_code],0)?></td>
<?
$total_sales = $sales_a[$dealer->dealer_code]+$sales_b[$dealer->dealer_code]+$sales_c[$dealer->dealer_code]+$sales_d[$dealer->dealer_code]+$sales_e[$dealer->dealer_code]+$sales_m[$dealer->dealer_code];
?>
<td bgcolor="#FFFF99"><?=number_format($total_sales,0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($damage_a[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($damage_b[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($damage_c[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($damage_d[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($damage_e[$dealer->dealer_code],0)?></td>
    <td bgcolor="#99CCFF"><?=number_format($damage_m[$dealer->dealer_code],0)?></td>
    
<? 
$damage_total=$damage_a[$dealer->dealer_code]+$damage_b[$dealer->dealer_code]+$damage_c[$dealer->dealer_code]+$damage_d[$dealer->dealer_code]+$damage_e[$dealer->dealer_code]+$damage_m[$dealer->dealer_code];
?>	
<td bgcolor="#FFFF99"><?=number_format($damage_total,0)?></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format((($damage_a[$dealer->dealer_code]/$sales_a[$dealer->dealer_code])*100),2);?>%</div></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format((($damage_b[$dealer->dealer_code]/$sales_b[$dealer->dealer_code])*100),2);?>%</div></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format((($damage_c[$dealer->dealer_code]/$sales_c[$dealer->dealer_code])*100),2);?>%</div></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format((($damage_d[$dealer->dealer_code]/$sales_d[$dealer->dealer_code])*100),2);?>%</div></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format((($damage_e[$dealer->dealer_code]/$sales_e[$dealer->dealer_code])*100),2);?>%</div></td>
<td bgcolor="#99CCFF"><div align="right"><?=number_format((($damage_m[$dealer->dealer_code]/$sales_m[$dealer->dealer_code])*100),2);?>%</div></td>
  </tr>
<? 
$g_sales_a +=  $sales_a[$dealer->dealer_code];
$g_sales_b +=  $sales_b[$dealer->dealer_code];
$g_sales_c +=  $sales_c[$dealer->dealer_code];
$g_sales_d +=  $sales_d[$dealer->dealer_code];
$g_sales_e +=  $sales_e[$dealer->dealer_code];
$g_sales_m +=  $sales_m[$dealer->dealer_code];
$g_sales_tt +=  $total_sales; 
  
$g_damage_a +=  $damage_a[$dealer->dealer_code];
$g_damage_b +=  $damage_b[$dealer->dealer_code];
$g_damage_c +=  $damage_c[$dealer->dealer_code];
$g_damage_d +=  $damage_d[$dealer->dealer_code];
$g_damage_e +=  $damage_e[$dealer->dealer_code];
$g_damage_m +=  $damage_m[$dealer->dealer_code];
$g_damage_tt +=  $damage_total; 
  
  
}
?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td colspan="6"><strong>Total</strong></td>
<td bgcolor="#FFFF66"><?=number_format($g_sales_a,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_sales_b,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_sales_c,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_sales_d,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_sales_e,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_sales_m,0)?></td>
<td bgcolor="#FFFF99"><?=number_format($g_sales_tt,0)?></td>


<td bgcolor="#FFFF66"><?=number_format($g_damage_a,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_damage_b,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_damage_c,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_damage_d,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_damage_e,0)?></td>
<td bgcolor="#FFFF66"><?=number_format($g_damage_m,0)?></td>
<td bgcolor="#FFFF99"><div align="right"><?=number_format($g_damage_tt,2);?></div></td>


<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'g_damage_a'}*100/${'g_sales_a'},2);?>%</div></td>
<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'g_damage_b'}*100/${'g_sales_b'},2);?>%</div></td>
<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'g_damage_c'}*100/${'g_sales_c'},2);?>%</div></td>
<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'g_damage_d'}*100/${'g_sales_d'},2);?>%</div></td>
<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'g_damage_e'}*100/${'g_sales_e'},2);?>%</div></td>
<td bgcolor="#FFFF66"><div align="right"><?=@number_format(${'g_damage_m'}*100/${'g_sales_m'},2);?>%</div></td>
</tr>
</table>


<?
}


elseif($_REQUEST['report']==11333) { // party wise sales vs damage

echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  
  <tr>
	<td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Region</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Zone</span> </td>
	<td bgcolor="#333333"><span class="style3 style1">DEALER NAME </span></td>
	<td bgcolor="#333333"><span class="style3 style1">Group</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Status</span></td>
	<td colspan="3" bgcolor="#333333"><div align="center" class="style1">This Year </div></td>
	<td colspan="3" bgcolor="#99CC33"><div align="center" class="style1"><span class="style3">Last Year </span></div></td>
	</tr>
	<tr>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>Sales</strong></div></td>
		<td bgcolor="#0099CC">Damage</td>
		<td bgcolor="#0099CC">%</td>
		<td bgcolor="#0099CC"><div align="center"><strong>Sales</strong></div></td>
		<td bgcolor="#0099CC">Damage</td>
		<td bgcolor="#0099CC">%</td>
	</tr>
<?
if(isset($item_id)) {$con=' and c.item_id="'.$item_id.'"';}
if(isset($dealer_code)) 	{$dealer_code_con=' and d.dealer_code="'.$dealer_code.'"';}

if($_REQUEST['region_id']>0)
$xcon .= ' and d.region_id='.$_REQUEST['region_id'];
elseif($_REQUEST['zone_id']>0)
$xcon .= ' and d.zone_id='.$_REQUEST['zone_id'];
elseif($_REQUEST['area_id']>0)
$xcon .= ' and d.area_code='.$_REQUEST['area_id'];

if($_REQUEST['product_group']!='')
$xcon .= ' and d.product_group="'.$_REQUEST['product_group'].'"';


if($_REQUEST['dealer_type']!=''){
$xcon .= ' and d.dealer_type="'.$_REQUEST['dealer_type'].'"';
}else {
$xcon .= ' and d.dealer_type="Distributor"';
}

	$lf_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
	$lt_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));

// Sales this year 
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  
and c.unit_price>0 and c.dealer_code=d.dealer_code 
".$con.$xcon." 
group by c.dealer_code";

$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_a[$data->dealer_code] = $data->amount;
}

// Sales last year 
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d where c.chalan_date between '".$lf_date."' and '".$lt_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code 
".$con.$xcon." group by c.dealer_code";
$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_b[$data->dealer_code] = $data->amount;
}


// Damage
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code 

 ".$con.$xcon." group by c.vendor_id";
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_a[$data->dealer_code] = $data->amount;
}


// Damage last year
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$lf_date."' and '".$lt_date."' and c.vendor_id=d.dealer_code 

 ".$con.$xcon." group by c.vendor_id";
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_b[$data->dealer_code] = $data->amount;
}


// --------- Dealer List
if($_REQUEST['dealer_type']!=''){
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,d.canceled, d.area_code as area,d.zone_id zone,d.region_id branch,d.product_group as grp 
from dealer_info d 
where 1
".$xcon.$dealer_code_con." order by d.dealer_code";
 
}else{ 
 
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,d.canceled, a.AREA_NAME as area,z.ZONE_NAME zone,b.BRANCH_NAME branch,d.product_group as grp 
from area a,branch b,zon z, dealer_info d 
where z.region_id=b.BRANCH_ID and 
 z.ZONE_CODE=a.ZONE_ID and d.area_code=a.AREA_CODE 
 ".$xcon.$dealer_code_con." order by branch,zone,d.dealer_code"; 
}
 
$query = db_query($sql);
while($dealer= mysqli_fetch_object($query)){
$dealer_code=$dealer->dealer_code;
?>
  

  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$dealer->branch.'"');?></td>
    <td><?=find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$dealer->zone.'"');?></td>
    <td><a target="_blank" href="?submit=1&amp;report=22&amp;dealer_code=<?=$dealer_code?>&amp;f_date=<?=$_REQUEST['f_date']?>&amp;t_date=<?=$_REQUEST['t_date']?>">
      <?=$dealer_code.'-'.$dealer->dealer_name?>
    </a></td>
    <td><?=$dealer->grp?></td>
    <td><?=$dealer->canceled?></td>
    <td bgcolor="#99CCFF"><? echo number_format($sales_a[$dealer->dealer_code],0); $tsa +=$sales_a[$dealer->dealer_code];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($damage_a[$dealer->dealer_code],0); $tda +=$damage_a[$dealer->dealer_code];?></td>
    <td bgcolor="#99CCFF"><?=number_format((($damage_a[$dealer->dealer_code]/$sales_a[$dealer->dealer_code])*100),2);?>%</td>
	
    <td bgcolor="#99CCFF"><? echo number_format($sales_b[$dealer->dealer_code],0); $tsb +=$sales_b[$dealer->dealer_code];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($damage_b[$dealer->dealer_code],0); $tdb +=$damage_b[$dealer->dealer_code];?></td>
    <td bgcolor="#99CCFF"><?=number_format((($damage_b[$dealer->dealer_code]/$sales_b[$dealer->dealer_code])*100),2);?>%</td>
  </tr>
<? 
}
?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total</strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tsa?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tda?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong><?=number_format((($tda/$tsa)*100),2);?>%</strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tsb?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tdb?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong><?=number_format((($tdb/$tsb)*100),2);?>%</strong></td>
  </tr>
</table>

<?
}



elseif($_REQUEST['report']==703) { // Region/ZONE/PARTY/Item wise sales vs damage report

if($_REQUEST['product_group']==''){ die('Must be Select Product GROUP');}

echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  
  <tr>
	<td bgcolor="#333333"><span class="style3 style1">S/L-703</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Region</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Zone</span> </td>
	<td bgcolor="#333333"><span class="style3 style1">DEALER NAME </span></td>
	<td bgcolor="#333333"><span class="style3 style1">Status</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Code</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Name</span></td>
	<td colspan="5" bgcolor="#333333"><div align="center" class="style1">This Year </div></td>
	<td colspan="5" bgcolor="#99CC33"><div align="center" class="style1"><span class="style3">Last Year </span></div></td>
	</tr>
	<tr>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC">S Qty </td>
		<td bgcolor="#0099CC"><div align="center"><strong>Sales Amt</strong></div></td>
		<td bgcolor="#0099CC">D Qty </td>
		<td bgcolor="#0099CC">Damage Amt</td>
		<td bgcolor="#0099CC">%</td>
		<td bgcolor="#0099CC">S Qty </td>
		<td bgcolor="#0099CC"><div align="center"><strong>Sales</strong></div></td>
		<td bgcolor="#0099CC">D Qty </td>
		<td bgcolor="#0099CC">Damage</td>
		<td bgcolor="#0099CC">%</td>
	</tr>
<?
if(isset($item_id)) {$con=' and c.item_id="'.$item_id.'"';}
if(isset($dealer_code)) 	{$dealer_code_con=' and d.dealer_code="'.$dealer_code.'"';}

if($_REQUEST['region_id']>0)
$xcon .= ' and d.region_id='.$_REQUEST['region_id'];
if($_REQUEST['zone_id']>0)
$xcon .= ' and d.zone_id='.$_REQUEST['zone_id'];
if($_REQUEST['area_id']>0)
$xcon .= ' and d.area_code='.$_REQUEST['area_id'];

if($_REQUEST['product_group']!='')
$xcon .= ' and d.product_group="'.$_REQUEST['product_group'].'"';


if($_REQUEST['dealer_type']!=''){
$xcon .= ' and d.dealer_type="'.$_REQUEST['dealer_type'].'"';
}else {
$xcon .= ' and d.dealer_type="Distributor"';
}

	$lf_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
	$lt_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));

// Sales this year 
$sql = "select c.dealer_code,c.item_id,sum(c.total_amt) as amount, sum(c.total_unit) as qty
from sale_do_chalan c, dealer_info d 
where c.chalan_date between '".$f_date."' and '".$t_date."'  
and c.unit_price>0 and c.dealer_code=d.dealer_code 
".$con.$xcon." 
group by c.dealer_code,c.item_id";

$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_a[$data->dealer_code][$data->item_id] = $data->amount;
$sales_a_qty[$data->dealer_code][$data->item_id] = $data->qty;
}

// Sales last year 
$sql = "select c.dealer_code,c.item_id,sum(c.total_amt) as amount , sum(c.total_unit) as qty
from sale_do_chalan c,dealer_info d 
where c.chalan_date between '".$lf_date."' and '".$lt_date."'  
and c.unit_price>0 and c.dealer_code=d.dealer_code 
".$con.$xcon." 
group by c.dealer_code,c.item_id";

$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_b[$data->dealer_code][$data->item_id] = $data->amount;
$sales_b_qty[$data->dealer_code][$data->item_id] = $data->qty;
}


// Damage
$sqql = "select c.vendor_id as dealer_code, c.item_id, sum(c.amount) as amount , sum(c.qty) as qty
from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc 
where dc.payable='Yes' and dc.id=c.receive_type 
and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code 
".$con.$xcon." 
group by c.vendor_id,c.item_id";
 
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_a[$data->dealer_code][$data->item_id] = $data->amount;
$damage_a_qty[$data->dealer_code][$data->item_id] = $data->qty;
}


// Damage last year
$sqql = "select c.vendor_id as dealer_code, c.item_id, sum(c.amount) as amount , sum(c.qty) as qty
from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc 
where dc.payable='Yes' and dc.id=c.receive_type 
and c.or_date between '".$lf_date."' and '".$lt_date."' and c.vendor_id=d.dealer_code 
".$con.$xcon." 
group by c.vendor_id,c.item_id";

$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_b[$data->dealer_code][$data->item_id] = $data->amount;
$damage_b_qty[$data->dealer_code][$data->item_id] = $data->qty;
}


// --------- Dealer List
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,d.canceled, d.area_code as area,d.zone_id zone,d.region_id branch,i.item_id,i.item_name,i.finish_goods_code as fg_code
from dealer_info d , sale_do_chalan c, item_info i
where c.item_id=i.item_id and d.dealer_code=c.dealer_code
".$xcon.$dealer_code_con." 
and i.finish_goods_code not between 2000 and 2010
and i.finish_goods_code not between 5000 and 6000
group by d.dealer_code,i.item_id
order by branch,zone,area,d.dealer_code,i.finish_goods_code";

$query = db_query($sql);
while($dealer= mysqli_fetch_object($query)){
$dealer_code=$dealer->dealer_code;
$item_id = $dealer->item_id;


if(
$sales_a[$dealer->dealer_code][$dealer->item_id]<>0 
|| $damage_a[$dealer->dealer_code][$dealer->item_id]<>0 
|| $sales_b[$dealer->dealer_code][$dealer->item_id]<>0 
|| $damage_b[$dealer->dealer_code][$dealer->item_id]<>0 
){
?>

  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$dealer->branch.'"');?></td>
    <td><?=find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$dealer->zone.'"');?></td>
    <td><?=$dealer_code.'-'.$dealer->dealer_name?></td>
    <td><?=$dealer->canceled?></td>
    <td><?=$dealer->fg_code?></td>
    <td><?=$dealer->item_name?></td>
    <td bgcolor="#99CCFF"><? echo number_format($sales_a_qty[$dealer->dealer_code][$dealer->item_id],0); $tsa_qty +=$sales_a_qty[$dealer->dealer_code][$dealer->item_id];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($sales_a[$dealer->dealer_code][$dealer->item_id],0); $tsa +=$sales_a[$dealer->dealer_code][$dealer->item_id];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($damage_a_qty[$dealer->dealer_code][$dealer->item_id],0); $tda_qty +=$damage_a_qty[$dealer->dealer_code][$dealer->item_id];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($damage_a[$dealer->dealer_code][$dealer->item_id],0); $tda +=$damage_a[$dealer->dealer_code][$dealer->item_id];?></td>
    <td bgcolor="#99CCFF"><?=number_format((($damage_a[$dealer->dealer_code][$dealer->item_id]/$sales_a[$dealer->dealer_code][$dealer->item_id])*100),2);?>%</td>
	
    <td bgcolor="#99CCFF"><? echo number_format($sales_b_qty[$dealer->dealer_code][$dealer->item_id],0); $tsb_qty +=$sales_b_qty[$dealer->dealer_code][$dealer->item_id];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($sales_b[$dealer->dealer_code][$dealer->item_id],0); $tsb +=$sales_b[$dealer->dealer_code][$dealer->item_id];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($damage_b_qty[$dealer->dealer_code][$dealer->item_id],0); $tdb_qty +=$damage_b_qty[$dealer->dealer_code][$dealer->item_id];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($damage_b[$dealer->dealer_code][$dealer->item_id],0); $tdb +=$damage_b[$dealer->dealer_code][$dealer->item_id];?></td>
    <td bgcolor="#99CCFF"><?=number_format((($damage_b[$dealer->dealer_code][$dealer->item_id]/$sales_b[$dealer->dealer_code][$dealer->item_id])*100),2);?>%</td>
  </tr>
<? 
} }
?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total</strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tsa_qty?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tsa?>
    </strong></td>

    <td bgcolor="#99CCFF"><strong>
      <?=$tda_qty?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tda?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong><?=number_format((($tda/$tsa)*100),2);?>%</strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tsb_qty?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tsb?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tdb_qty?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tdb?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong><?=number_format((($tdb/$tsb)*100),2);?>%</strong></td>
  </tr>
</table>

<?
} // end 703



elseif($_REQUEST['report']==701) { // party wise sales vs damage without tang

echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  
  <tr>
	<td bgcolor="#333333"><span class="style3 style1">S/L-701</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Region</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Zone</span> </td>
	<td bgcolor="#333333"><span class="style3 style1">DEALER NAME </span></td>
	<td bgcolor="#333333"><span class="style3 style1">Group</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Status</span></td>
	<td colspan="3" bgcolor="#333333"><div align="center" class="style1">This Year </div></td>
	<td colspan="3" bgcolor="#99CC33"><div align="center" class="style1"><span class="style3">Last Year </span></div></td>
	</tr>
	<tr>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>Sales</strong></div></td>
		<td bgcolor="#0099CC">Damage</td>
		<td bgcolor="#0099CC">%</td>
		<td bgcolor="#0099CC"><div align="center"><strong>Sales</strong></div></td>
		<td bgcolor="#0099CC">Damage</td>
		<td bgcolor="#0099CC">%</td>
	</tr>
<?
if(isset($item_id)) {$con=' and c.item_id="'.$item_id.'"';}
if(isset($dealer_code)) 	{$dealer_code_con=' and d.dealer_code="'.$dealer_code.'"';}

if($_REQUEST['region_id']>0)
$xcon .= ' and d.region_id='.$_REQUEST['region_id'];
elseif($_REQUEST['zone_id']>0)
$xcon .= ' and d.zone_id='.$_REQUEST['zone_id'];
elseif($_REQUEST['area_id']>0)
$xcon .= ' and d.area_code='.$_REQUEST['area_id'];

if($_REQUEST['product_group']!='')
$xcon .= ' and d.product_group="'.$_REQUEST['product_group'].'"';


if($_REQUEST['dealer_type']!=''){
$xcon .= ' and d.dealer_type="'.$_REQUEST['dealer_type'].'"';
}else {
$xcon .= ' and d.dealer_type="Distributor"';
}

	$lf_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
	$lt_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));



// Sales this year 
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d, item_info i
where c.chalan_date between '".$f_date."' and '".$t_date."'  
and c.unit_price>0 and c.dealer_code = d.dealer_code and c.item_id=i.item_id 
and i.item_brand not in('Tang','Bourn Vita','Oreo')
".$con.$xcon." group by c.dealer_code";

$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_a[$data->dealer_code] = $data->amount;
}

// Sales last year 
$sql = "select c.dealer_code,sum(c.total_amt) as amount from sale_do_chalan c,dealer_info d , item_info i
where c.chalan_date between '".$lf_date."' and '".$lt_date."' 
and c.unit_price>0 and c.dealer_code=d.dealer_code and c.item_id=i.item_id 
and i.item_brand not in('Tang','Bourn Vita','Oreo')
".$con.$xcon." group by d.dealer_code";

$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sales_b[$data->dealer_code] = $data->amount;
}


// Damage this year
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount 
from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc, item_info i
where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' 
and c.vendor_id=d.dealer_code and c.item_id = i.item_id
and i.item_brand not in('Tang','Bourn Vita','Oreo')
 ".$con.$xcon." group by c.vendor_id";
 
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_a[$data->dealer_code] = $data->amount;
}


// Damage last year
$sqql = "select c.vendor_id as dealer_code, sum(c.amount) as amount 
from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc, item_info i
where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$lf_date."' and '".$lt_date."' 
and c.vendor_id=d.dealer_code and c.item_id = i.item_id
and i.item_brand not in('Tang','Bourn Vita','Oreo')
 ".$con.$xcon." group by c.vendor_id";
 
$query = db_query($sqql);
while($data= mysqli_fetch_object($query)){
$damage_b[$data->dealer_code] = $data->amount;
}


// --------- Dealer List
if($_REQUEST['dealer_type']!=''){
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,d.canceled, d.area_code as area,d.zone_id zone,d.region_id branch,d.product_group as grp 
from dealer_info d 
where 1
".$xcon.$dealer_code_con." order by branch,zone,d.dealer_code";
 
}else{ 
 
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,d.canceled, a.AREA_NAME as area,z.ZONE_NAME zone,b.BRANCH_NAME branch,d.product_group as grp 
from area a,branch b,zon z, dealer_info d 
where z.region_id=b.BRANCH_ID and 
 z.ZONE_CODE=a.ZONE_ID and d.area_code=a.AREA_CODE 
 ".$xcon.$dealer_code_con." order by branch,zone,d.dealer_code"; 
}
 
$query = db_query($sql);
while($dealer= mysqli_fetch_object($query)){
$dealer_code=$dealer->dealer_code;
?>
  

  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$dealer->branch.'"');?></td>
    <td><?=find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$dealer->zone.'"');?></td>
    <td><a target="_blank" href="?submit=1&amp;report=702&amp;dealer_code=<?=$dealer_code?>&amp;f_date=<?=$_REQUEST['f_date']?>&amp;t_date=<?=$_REQUEST['t_date']?>">
      <?=$dealer_code.'-'.$dealer->dealer_name?>
    </a></td>
    <td><?=$dealer->grp?></td>
    <td><?=$dealer->canceled?></td>
    <td bgcolor="#99CCFF"><? echo number_format($sales_a[$dealer->dealer_code],0); $tsa +=$sales_a[$dealer->dealer_code];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($damage_a[$dealer->dealer_code],0); $tda +=$damage_a[$dealer->dealer_code];?></td>
    <td bgcolor="#99CCFF"><?=number_format((($damage_a[$dealer->dealer_code]/$sales_a[$dealer->dealer_code])*100),2);?>%</td>
	
    <td bgcolor="#99CCFF"><? echo number_format($sales_b[$dealer->dealer_code],0); $tsb +=$sales_b[$dealer->dealer_code];?></td>
    <td bgcolor="#99CCFF"><? echo number_format($damage_b[$dealer->dealer_code],0); $tdb +=$damage_b[$dealer->dealer_code];?></td>
    <td bgcolor="#99CCFF"><?=number_format((($damage_b[$dealer->dealer_code]/$sales_b[$dealer->dealer_code])*100),2);?>%</td>
  </tr>
<? 
}
?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total</strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tsa?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tda?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong><?=number_format((($tda/$tsa)*100),2);?>%</strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tsb?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong>
      <?=$tdb?>
    </strong></td>
    <td bgcolor="#99CCFF"><strong><?=number_format((($tdb/$tsb)*100),2);?>%</strong></td>
  </tr>
</table>

<?
}
// end 701



elseif($_REQUEST['report']==110) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
	<td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
	<td bgcolor="#333333"><span class="style3 style1">DEALER NAME </span></td>
	<td bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><span class="style3">RATIO</span></div></td>
  </tr>
	<tr>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
		</tr>
<?
if(isset($item_id)) {$con=' and c.item_id="'.$item_id.'"';}
if(isset($dealer_type)) {$dcon=' and d.dealer_type="'.$dealer_type.'"';}
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name from dealer_info d where 1 ".$dcon." order by dealer_name_e";

$query = @db_query($sql);
while($dealer=@mysqli_fetch_object($query)){

$dealer_code = $dealer->dealer_code;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and   d.dealer_code='".$dealer_code."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));



${'totala'} = ${'totala'} + ${'sqlmona'}[0];


${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and   d.dealer_code='".$dealer_code."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];


${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$dealer_code} = ${'dtotalr'.$dealer_code} + ${'dtotal'};
if(${'totalr'.$dealer_code}>0||${'dtotalr'.$dealer_code}>0){
?>
  
  <tr >
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&report=21&dealer_code=<?=$dealer_code?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$dealer_code.'-'.$dealer->dealer_name?></a></td>

<td ><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td ><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td ><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
</tr>
  <? }}



  ?>
    <tr >
      <td colspan="2"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
</tr>
   

</table></td>
</tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

</table>
<?
}



elseif($_REQUEST['report']==117) {

echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L-117</span></td>
    <td bgcolor="#333333"><span class="style3 style1">REGION NAME </span></td>

<td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC">D</td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC">D</td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC">D</td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 

if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$sql = "select BRANCH_ID,BRANCH_NAME from branch  order by BRANCH_NAME";

$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$BRANCH_ID = $item->BRANCH_ID;
${'totalr'.$BRANCH_ID} = 0;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totald'} = ${'totald'} + ${'sqlmond'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] + ${'sqlmond'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$BRANCH_ID} = ${'totalr'.$BRANCH_ID} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a, zon z ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotald'} = ${'dtotald'} + ${'dsqlmond'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] + ${'dsqlmond'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$BRANCH_ID} = ${'dtotalr'.$BRANCH_ID} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&report=118&region_id=<?=$BRANCH_ID?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$item->BRANCH_NAME?></a></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$BRANCH_ID};echo number_format(${'totalr'.$BRANCH_ID},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$BRANCH_ID};echo number_format(${'dtotalr'.$BRANCH_ID},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmond'}[0]/${'sqlmond'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }




$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

${'sqlmonco'} = mysqli_fetch_row(db_query($sqql));
$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Corporate'".$con;

${'dsqlmonco'} = mysqli_fetch_row(db_query($sqql));
  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>D Total</strong></td>

<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalb'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totald'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotald'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotald'}*100/${'totald'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&report=110&dealer_type=Corporate&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>">Corporate</a></td>
	

<td colspan="5" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'sqlmonco'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'sqlmonco'}[0],2);?>
</strong></div></td>
<td colspan="5" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'dsqlmonco'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'dsqlmonco'}[0],2);?>
</strong></div></td>
<td colspan="5" bgcolor="#99CCFF"><div align="center">
  <?=@number_format(${'dsqlmonco'}[0]*100/${'sqlmonco'}[0],2);?>
  %</div></td>
    </tr>
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];



$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td><a target="_blank"  href="?submit=1&report=110&dealer_type=SuperShop&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>">SuperShop</a></td>

<td colspan="5" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'sqlmonsu'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'sqlmonsu'}[0],2);?>
</strong></div></td>
<td colspan="5" bgcolor="#99CCFF"><div align="center">
  <?=number_format(${'dsqlmonsu'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format(${'dsqlmonsu'}[0],2);?>
</strong></div></td>
<td colspan="5" bgcolor="#99CCFF"><div align="center">
  <?=@number_format(${'dsqlmonsu'}[0]*100/${'sqlmonsu'}[0],2);?>
  %</div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
  <td>&nbsp;</td>
  <td><strong>Corporate+SuperShop</strong></td>


<td colspan="5" bgcolor="#FFFF66"><div align="center">
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?>
</div></td>

<td bgcolor="#FFFF99"><div align="right">
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]),2);?>
</div></td>
<td colspan="5" bgcolor="#FFFF66"><div align="center">
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]),2);?>
</div></td>
<td colspan="5" bgcolor="#FFFF66"><div align="center">
  <?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0])*100/($sqlmonsu[0]+$sqlmonco[0]),2);?>
  %</div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>N Total</strong>  <div align="center"></div></td>
<td colspan="5">&nbsp;</td>
<?

${'totalallall'} = ${'totalallall'} + (${'totalc'}+${'totals'}+${'totalco'});
?>
<td bgcolor="#FF3333"><div align="right"><strong>
  <?=number_format(($sqlmonsu[0]+$sqlmonco[0]+$totalall),2);?>
</strong></div></td>
<td colspan="5">&nbsp;</td>
<td bgcolor="#FF3333"><div align="right"><strong>
  <?=number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$dtotalall),2);?>
</strong></div></td>
<td colspan="5" bgcolor="#FF9999"><div align="center"><strong>
  <?=@number_format(($dsqlmonsu[0]+$dsqlmonco[0]+$dtotalall)*100/($sqlmonsu[0]+$sqlmonco[0]+$totalall),2);?>
  %</strong></div></td>
</tr>
</table>

<?
}



elseif($_REQUEST['report']==118) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
    <td bgcolor="#333333"><span class="style3 style1">ZONE NAME </span></td>

<td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC">D</td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC">D</td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC">D</td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 

if(isset($item_id)) 				{$con=' and c.item_id="'.$item_id.'"';}
if($_REQUEST['region_id']>0) 		{$con_region=' and REGION_ID="'.$_REQUEST['region_id'].'"';}
$sql = "select ZONE_CODE,ZONE_NAME from zon where 1 ".$con_region." order by ZONE_NAME";

$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$ZONE_CODE = $item->ZONE_CODE;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totald'} = ${'totald'} + ${'sqlmond'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] +  ${'sqlmond'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$ZONE_CODE} = ${'totalr'.$ZONE_CODE} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotald'} = ${'dtotald'} + ${'dsqlmond'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] +  ${'dsqlmond'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$ZONE_CODE} = ${'dtotalr'.$ZONE_CODE} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&report=119&zone_id=<?=$ZONE_CODE?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$item->ZONE_NAME?></a></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$ZONE_CODE};echo number_format(${'totalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$ZONE_CODE};echo number_format(${'dtotalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmond'}[0]/${'sqlmond'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="2"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalb'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totald'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);$totalall=0;?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotald'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotald'}*100/${'totald'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>

</table></td>
</tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<?
	$f_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
	$t_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));
?>
  <tr>
    <td bgcolor="#99CCCC"><div align="center"><span class="style2">Last Year Same Time Position<br />Period: <?=$f_date?> to <?=$t_date?></span></div></td>
</tr>  <tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
<?
${'totala'} = 0;
${'totalb'} = 0;
${'totalc'} = 0;
${'totald'} = 0;
${'totalm'} = 0;

${'total'} = 0;
${'totalall'} = 0;

${'dtotala'} = 0;
${'dtotalb'} = 0;
${'dtotalc'} = 0;
${'dtotald'} = 0;
${'dtotalm'} = 0;

${'dtotalall'} = 0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
    <td bgcolor="#333333"><span class="style3 style1">ZONE NAME </span></td>

    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 ${'totalr'.$ZONE_CODE} = 0 ;
${'dtotalr'.$ZONE_CODE} = 0;
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}

if($_REQUEST['region_id']>0) 		{$con_region=' and REGION_ID="'.$_REQUEST['region_id'].'"';}
$sql = "select ZONE_CODE,ZONE_NAME from zon where 1 ".$con_region." order by ZONE_NAME";


$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$ZONE_CODE = $item->ZONE_CODE;
${'totalr'.$ZONE_CODE} = 0;

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totald'} = ${'totald'} + ${'sqlmond'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] +  ${'sqlmond'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};

${'totalr'.$ZONE_CODE} = ${'totalr'.$ZONE_CODE} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,area a ,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and d.area_code=a.AREA_CODE and a.ZONE_ID='".$ZONE_CODE."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotald'} = ${'dtotald'} + ${'dsqlmond'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] +  ${'dsqlmond'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};

${'dtotalr'.$ZONE_CODE} = ${'dtotalr'.$ZONE_CODE} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->ZONE_NAME?></td>

<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$ZONE_CODE};echo number_format(${'totalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$ZONE_CODE};echo number_format(${'dtotalr'.$ZONE_CODE},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmond'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td colspan="2"><strong>Total</strong></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totala'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totalb'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?></div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotald'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotald'}*100/${'totald'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
</table></td>
  </tr>
</table>
<?
}
elseif($_REQUEST['report']==119) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
	<td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
	<td bgcolor="#333333"><span class="style3 style1">DEALER NAME </span></td>
	<td bgcolor="#333333"><span class="style3 style1">Status</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Region</span></td>
	<td bgcolor="#333333"><span class="style3 style1">Zone</span> </td>
	<td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
	<td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
	<td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
		<td bgcolor="#333333">&nbsp;</td>
		<td colspan="4" bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><strong>D</strong></td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>D</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
		<td bgcolor="#0099CC"><strong>D</strong></td>
		<td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
<?
if(isset($item_id)) {$con .=' and c.item_id="'.$item_id.'"';}
if(isset($item_brand)) {$con .=' and i.item_brand="'.$item_brand.'"';}
if($_REQUEST['region_id']>0)
$xcon .= 'and z.REGION_ID='.$_REQUEST['region_id'];
elseif($_REQUEST['zone_id']>0)
$xcon .= 'and a.ZONE_ID='.$_REQUEST['zone_id'];
elseif($_REQUEST['area_id']>0)
$xcon .= 'and a.AREA_CODE='.$_REQUEST['area_id'];

if($_REQUEST['product_group']!='')
$xcon .= ' and d.product_group="'.$_REQUEST['product_group'].'"';

//if(isset($dealer_type)) 		{$dealer_typecon = ' and d.dealer_type="'.$dealer_type.'"';}

$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,d.canceled, a.AREA_NAME as area,z.ZONE_NAME zone,b.BRANCH_NAME branch from area a,branch b,zon z, dealer_info d where z.region_id=b.BRANCH_ID and 
 z.ZONE_CODE=a.ZONE_ID and d.area_code=a.AREA_CODE  and d.dealer_type='Distributor' ".$xcon." order by dealer_name_e";

$query = @db_query($sql);
while($dealer=@mysqli_fetch_object($query)){

$dealer_code = $dealer->dealer_code;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,item_info i where c.item_id=i.item_id and c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,item_info i where c.item_id=i.item_id and c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,item_info i where c.item_id=i.item_id and c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,item_info i where c.item_id=i.item_id and c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,item_info i where c.item_id=i.item_id and c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totald'} = ${'totald'} + ${'sqlmond'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] +  ${'sqlmond'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc ,item_info i where c.item_id=i.item_id and  dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc ,item_info i where c.item_id=i.item_id and  dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc ,item_info i where c.item_id=i.item_id and  dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc ,item_info i where c.item_id=i.item_id and  dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc ,item_info i where c.item_id=i.item_id and  dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotald'} = ${'dtotald'} + ${'dsqlmond'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] +  + ${'dsqlmond'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$dealer_code} = ${'dtotalr'.$dealer_code} + ${'dtotal'};
?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&report=21&dealer_code=<?=$dealer_code?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$dealer_code.'-'.$dealer->dealer_name?></a></td>

    <td><?=$dealer->canceled?></td>
    <td><?=$dealer->branch?></td>
    <td>
      <?=$dealer->zone?>    </td>
    <td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$dealer_code};echo number_format(${'totalr'.$dealer_code},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$dealer_code};echo number_format(${'dtotalr'.$dealer_code},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmond'}[0]/${'sqlmond'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="5"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totalb'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totald'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotald'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotald'}*100/${'totald'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    
	<?


//$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
//${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
//${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];
//
//$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
//${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
//${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>

</table></td>
</tr>
  

  
<? if(0){?>
<?
	$f_date = date((date('Y',strtotime($f_date))-1).'-m-d',strtotime($f_date));
	$t_date = date((date('Y',strtotime($t_date))-1).'-m-d',strtotime($t_date));
?>
<tr><td>&nbsp;</td></tr><tr>
    <td bgcolor="#99CCCC"><div align="center"><span class="style2">Last Year Same Time Position<br />Period: <?=$f_date?> to <?=$t_date?></span></div></td>
</tr><tr><td>&nbsp;</td></tr><tr>
    <td>
<?
${'totala'} = 0;
${'totalb'} = 0;
${'totalc'} = 0;
${'totald'} = 0;
${'totalm'} = 0;

${'total'} = 0;
${'totalall'} = 0;

${'dtotala'} = 0;
${'dtotalb'} = 0;
${'dtotalc'} = 0;
${'dtotald'} = 0;
${'dtotalm'} = 0;


${'dtotalall'} = 0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  
  <tr>
    <td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
    <td bgcolor="#333333"><span class="style3 style1">DEALER NAME </span></td>
    <td bgcolor="#333333"><span class="style3 style1">Status</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Region</span></td>
    <td bgcolor="#333333"><span class="style3 style1">Zone</span></td>
    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>

    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
    <td bgcolor="#333333"><div align="center" class="style1"><strong><span class="style5">Total</span></strong></div></td>
    <td colspan="5" bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES/DAMAGE RATIO</span></div></td>
  </tr>
	<tr>
    <td bgcolor="#333333">&nbsp;</td>
    <td colspan="4" bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><strong>D</strong></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><strong>D</strong></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#333333">&nbsp;</td>
    <td bgcolor="#0099CC"><div align="center"><strong>A</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>B</strong></div></td>
    <td bgcolor="#0099CC"><div align="center"><strong>C</strong></div></td>
    <td bgcolor="#0099CC"><strong>D</strong></td>
    <td bgcolor="#0099CC"><div align="center"><strong>M</strong></div></td>
	</tr>
 <?
 $j=0;
 ${'totalr'.$dealer_code} = 0 ;
${'dtotalr'.$dealer_code} = 0;
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
// $sql = "select d.dealer_code,d.dealer_name_e as dealer_name,a.AREA_NAME as area from area a,dealer_info d where d.area_code=a.AREA_CODE and a.ZONE_ID=".$_REQUEST['zone_id']." order by dealer_name_e";

$sql = "select d.dealer_code,d.dealer_name_e as dealer_name,d.canceled, a.AREA_NAME as area,z.ZONE_NAME zone,b.BRANCH_NAME branch from area a,branch b,zon z, dealer_info d where z.region_id=b.BRANCH_ID and 
 z.ZONE_CODE=a.ZONE_ID and d.area_code=a.AREA_CODE  and d.dealer_type='Distributor' ".$xcon." order by dealer_name_e";

$query = @db_query($sql);
while($dealer=@mysqli_fetch_object($query)){
${'totalr'.$dealer_code} = 0;
$dealer_code = $dealer->dealer_code;


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'sqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'totalb'} = ${'totalb'} + ${'sqlmonb'}[0];
${'totalc'} = ${'totalc'} + ${'sqlmonc'}[0];
${'totald'} = ${'totald'} + ${'sqlmond'}[0];
${'totalm'} = ${'totalm'} + ${'sqlmonm'}[0];

${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] +  + ${'sqlmond'}[0] + ${'sqlmonm'}[0];

${'totalall'} = ${'totalall'} + ${'total'};

${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonb'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonc'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmond'} = mysqli_fetch_row(db_query($sqql));

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='Distributor' and d.product_group='M' and  d.dealer_code='".$dealer_code."'".$con;
${'dsqlmonm'} = mysqli_fetch_row(db_query($sqql));


${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotalb'} = ${'dtotalb'} + ${'dsqlmonb'}[0];
${'dtotalc'} = ${'dtotalc'} + ${'dsqlmonc'}[0];
${'dtotald'} = ${'dtotald'} + ${'dsqlmond'}[0];
${'dtotalm'} = ${'dtotalm'} + ${'dsqlmonm'}[0];

${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] +  + ${'dsqlmond'}[0] + ${'dsqlmonm'}[0];

${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};

${'dtotalr'.$dealer_code} = ${'dtotalr'.$dealer_code} + ${'dtotal'};

?>
  
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&amp;report=21&amp;dealer_code=<?=$dealer_code?>&amp;f_date=<?=$_REQUEST['f_date']?>&amp;t_date=<?=$_REQUEST['t_date']?>">
      <?=$dealer_code.'-'.$dealer->dealer_name.'-'.$dealer->zone?>
    </a></td>
    <td><?=$dealer->canceled?></td>
    <td><?=$dealer->branch?></td>
    <td><?=$dealer->zone?></td>
    <td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'sqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $totalallr= $totalallr + ${'totalr'.$dealer_code}; echo number_format(${'total'},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonb'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonc'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmond'}[0],2);?>
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(${'dsqlmonm'}[0],2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <? $dtotalallr= $dtotalallr + ${'dtotalr'.$dealer_code};echo number_format(${'dtotalr'.$dealer_code},2)?>
</strong></div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonb'}[0]/${'sqlmonb'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonc'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmond'}[0]/${'sqlmonc'}[0])*100),2);?>
  %</div></td>
<td bgcolor="#99CCFF"><div align="right">
  <?=number_format(@((${'dsqlmonm'}[0]/${'sqlmonm'}[0])*100),2);?>
  %</div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="5"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totala'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totalb'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalc'}),2);?></div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totald'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right"> <?=number_format((${'totalm'}),2);?></div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($totalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalb'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalc'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotald'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotalm'},2);?>
</div></td>
<td bgcolor="#FFFF99"><div align="right">
  <?=number_format($dtotalall,2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalb'}*100/${'totalb'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalc'}*100/${'totalc'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotald'}*100/${'totald'},2);?>
  %</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotalm'}/${'totalm'},2);?>
  %</div></td>
    </tr>
    
	<?


$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'totalsu'} = ${'totalsu'} + ${'sqlmonsu'}[0];

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d where c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'dsqlmonsu'} = mysqli_fetch_row(db_query($sqql));
${'dtotalsu'} = ${'dtotalsu'} + ${'dsqlmonsu'}[0];

?>
</table></td>
  </tr><? }?>
</table>
<?
}
elseif($_REQUEST['report']==120) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
	<td bgcolor="#333333"><span class="style3 style1">S/L</span></td>
	<td bgcolor="#333333"><span class="style3 style1">DEALER NAME </span></td>
	<td bgcolor="#333333"><div align="center" class="style1"><span class="style3">SALES</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><span class="style3">DAMAGE</span></div></td>
	<td bgcolor="#333333"><div align="center" class="style1"><span class="style3">RATIO</span></div></td>
  </tr>
	<tr>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#333333">&nbsp;</td>
		<td bgcolor="#0099CC"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
		<td bgcolor="#0099CC"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
		</tr>
<?
if(isset($item_id)) {$con=' and c.item_id="'.$item_id.'"';}
if(isset($dealer_type)) {$dcon=' and d.dealer_type="'.$dealer_type.'"';}
$sql = "select d.dealer_code,d.dealer_name_e as dealer_name from dealer_info d where dealer_type!='Distributor' and 1 ".$dcon." order by dealer_name_e";

$query = @db_query($sql);
while($dealer=@mysqli_fetch_object($query)){

$dealer_code = $dealer->dealer_code;
$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."'  and c.unit_price>0 and c.dealer_code=d.dealer_code and   d.dealer_code='".$dealer_code."'".$con;
${'sqlmona'} = mysqli_fetch_row(db_query($sqql));

${'totala'} = ${'totala'} + ${'sqlmona'}[0];
${'total'} = ${'sqlmona'}[0] + ${'sqlmonb'}[0] + ${'sqlmonc'}[0] + ${'sqlmonm'}[0];
${'totalall'} = ${'totalall'} + ${'total'};
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'total'};

$sqql = "select sum(c.amount) from warehouse_damage_receive_detail c,dealer_info d,damage_cause dc where dc.payable='Yes' and dc.id=c.receive_type and c.or_date between '".$f_date."' and '".$t_date."' and c.vendor_id=d.dealer_code and   d.dealer_code='".$dealer_code."'".$con;
${'dsqlmona'} = mysqli_fetch_row(db_query($sqql));

${'dtotala'} = ${'dtotala'} + ${'dsqlmona'}[0];
${'dtotal'} = ${'dsqlmona'}[0] + ${'dsqlmonb'}[0] + ${'dsqlmonc'}[0] + ${'dsqlmonm'}[0];
${'dtotalall'} = ${'dtotalall'} + ${'dtotal'};
${'dtotalr'.$dealer_code} = ${'dtotalr'.$dealer_code} + ${'dtotal'};
if(${'totalr'.$dealer_code}>0||${'dtotalr'.$dealer_code}>0){
?>
  
  <tr >
    <td><?=++$j?></td>
    <td><a target="_blank"  href="?submit=1&report=21&dealer_code=<?=$dealer_code?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>"><?=$dealer_code.'-'.$dealer->dealer_name?></a></td>

<td ><div align="right">
  <?=number_format(${'sqlmona'}[0],2);?>
</div></td>
<td ><div align="right">
  <?=number_format(${'dsqlmona'}[0],2);?>
</div></td>
<td ><div align="right">
  <?=number_format(@((${'dsqlmona'}[0]/${'sqlmona'}[0])*100),2);?>%
</div></td>
</tr>
  <? }}



  ?>
    <tr >
      <td colspan="2"><strong>Total</strong></td>
      <td bgcolor="#FFFF66"><div align="right">
  <?=number_format((${'totala'}),2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=number_format(${'dtotala'},2);?>
</div></td>
<td bgcolor="#FFFF66"><div align="right">
  <?=@number_format(${'dtotala'}*100/${'totala'},2);?>
  %</div></td>
</tr>
   

</table></td>
</tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

</table>
<?
}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?></div>
<script type="text/javascript">
 
$("tr").not(':first').hover(
  function () {
    $(this).css("background","yellow");
  }, 
  function () {
    $(this).css("background","");
  }
);
 
</script>
</body>
</html>