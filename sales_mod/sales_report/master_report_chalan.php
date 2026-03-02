<?
session_start();

 

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
if($_POST['sales_type']>0) 		$sales_type=$_POST['sales_type'];
if($_POST['sales_return_type']>0) 		$sales_return_type=$_POST['sales_return_type'];
if($_POST['dealer_type']!='') 	$dealer_type=$_POST['dealer_type'];

if($_POST['status']!='') 		$status=$_POST['status'];
if($_POST['do_no']!='') 		$do_no=$_POST['do_no'];
if($_POST['area_id']!='') 		$area_id=$_POST['area_id'];
if($_POST['zone_id']!='') 		$zone_id=$_POST['zone_id'];
if($_POST['region_id']>0) 		$region_id=$_POST['region_id'];
if($_POST['depot_id']!='') 		$depot_id=$_POST['depot_id'];
if($_POST['group_for']!='') 		$group_for=$_POST['group_for'];

if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($dealer_type)) 		{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 
//if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
//if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
//if(isset($zone_id)) 			{$zone_con=' and a.buyer_id='.$zone_id;}
//if(isset($region_id)) 		{$region_con=' and d.id='.$region_id;}
//if(isset($item_id)) 			{$item_con=' and b.item_id='.$item_id;} 
//if(isset($status)) 			{$status_con=' and a.status="'.$status.'"';} 
//if(isset($do_no)) 			{$do_no_con=' and a.do_no="'.$do_no.'"';} 
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $chalan_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

switch ($_POST['report']) {
    
	
	case 1:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
 if($_POST['company_id']!='')
	    $company_name = find_a_field('company_info','company_name','id="'.$_POST['company_id'].'"');
		$report= $company_name."Sales Invoice  Brief Report";
	break;
	
	
	case 1111:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
 if($_POST['company_id']!='')
	    $company_name = find_a_field('company_info','company_name','id="'.$_POST['company_id'].'"');
		$report= $company_name."Sales Return  Brief Report";
	break;
	
	
	case 200512:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.sr_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
 if($_POST['company_id']!='')
	    $company_name = find_a_field('company_info','company_name','id="'.$_POST['company_id'].'"');
		$report= $company_name."Sales Return Summary Report";
	break;
	
	
case 701:
	
	
$report="Gate Pass Print List";
	break;
    
	
	
	case 2:
		$report="Item Wise Chalan Summary Report";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql='select 
		
		i.finish_goods_code as fg,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.sales_item_type as item_group,
		sum(a.pkt_unit) as pkt,
		sum(a.dist_unit) as pcs,
		
		sum(a.total_unit) as total_pcs
		from dealer_info d, sale_do_master m,sale_do_chalan a, item_info i, user_activity_management c  where d.dealer_code=m.dealer_code and m.do_no=a.do_no and d.depot='.$_SESSION['user']['depot'].' and i.item_brand!="" and
		 c.user_id=a.entry_by and a.item_id=i.item_id'.$pg_con.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
	break;
	case 7:
		$report="Item Wise Chalan Details Report";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql='select 
		
		a.chalan_no,
		a.do_no,
		a.driver_name as serial_no,
		i.finish_goods_code as fg,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.sales_item_type as item_group,
		a.pkt_unit as pkt,
		a.dist_unit as pcs,
		
		a.total_unit as total_pcs
		from dealer_info d, sale_do_master m,sale_do_chalan a, item_info i, user_activity_management c  where d.dealer_code=m.dealer_code and m.do_no=a.do_no and d.depot='.$_SESSION['user']['depot'].' and i.item_brand!="" and
		 c.user_id=a.entry_by and a.item_id=i.item_id'.$pg_con.$date_con.$warehouse_con.$item_con.$item_brand_con.' order by i.finish_goods_code';
	break;
	case 3:
$report="Delivered Chalan Report (Chalan Wise)";
if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($dealer_code)) {$dealer_con=' and m.dealer_code='.$dealer_code;} 
if(isset($item_id)){$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) {$depot_con=' and d.depot="'.$depot_id.'"';} 
	break;
	case 6:
	if($_REQUEST['chalan_no']>0)
header("Location:sales_invoice_new.php?v_no=".$_REQUEST['chalan_no']);
	break;
	case 5:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
$report="Delivery Order Brief Report (Region Wise)";
	break;
	    case 7:
		$report="Item wise DO Report";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

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
if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 
$report="Dealer Performance Report";
	    case 9:
		$report="Item Report (Region Wise)";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 
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
}
}
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
</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?
		$str 	.= '<div class="header">';
		if(isset($_SESSION['user']['group'])) 
		$str 	.= '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(($item_id>0)) 
		$str 	.= '<h2>Item Name: '.find_a_field('item_info','item_name','item_id='.$item_id).'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
		$str 	.= '</div>';
		$str 	.= '<div class="left" style="width:100%">';

//		if(isset($allotment_no)) 
//		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
//		$str 	.= '</div><div class="right">';
//		if(isset($client_name)) 
//		$str 	.= '<p>Dealer Name: '.$dealer_name.'</p>';
//		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

if($_POST['report']==1) 
{
if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';} 

if(isset($group_for)) 			{$group_for_con=' and m.group_for="'.$group_for.'"';} 
if(isset($sales_type)) 			{$sales_type_con=' and m.sales_type="'.$sales_type.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 

  $sqlr="select distinct c.chalan_no,c.chalan_date, m.do_no, m.invoice_no, m.cash_discount, m.sales_type, m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp,c.driver_name,
 sum(c.total_amt) as total_amt, sum(c.discount) as discount, sum(c.amt_after_discount) as amt_after_discount, sum(c.vat_amt) as vat_amt,  sum(c.total_amt_with_vat) as total_amt_with_vat, m.group_for, u.group_name, m.vat

from sale_do_master m,sale_do_chalan c,dealer_info d, warehouse w, user_group u

where m.status in ('CHECKED','COMPLETED', 'INVOICE') 
and m.do_no=c.do_no 

and m.dealer_code=d.dealer_code and m.group_for=u.id
and w.warehouse_id=c.depot_id 
".$depot_con.$date_con.$group_for_con.$dealer_con.$dtype_con.$sales_type_con."  group by c.chalan_no 
order by c.chalan_date,m.do_no ";

$query = db_query($sqlr);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="12"><?=$str?></td></tr>
<tr style="font-size:12px; background:#82D8CF" height="28"><th width="2%">S/L </th>
  <th width="7%">Invoice View </th>
  <th width="7%">Invoice Date</th>
  <th width="6%">SO No</th>
<th width="20%">Customer Name</th>
<th width="7%">Sales Type </th>
<th width="14%">Warehouse</th>
<th width="7%"> Net Sales </th>
<th width="6%">Discount</th>
<th width="10%">Total Taxable Amount</th>
<th width="7%">VAT Amt </th>
<th width="7%">Receivable Amt </th>
</tr>
</thead>

<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;

?>
<tr>
<td><?=$s?></td>

<td><a href="../wo/sales_invoice_print_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
<td><?php echo date("d-m-Y",strtotime($data->chalan_date)); ?></td>
<td><?=$data->do_no?></td>
<td><?=$data->dealer_name?></td>
<td><?= find_a_field('sales_type',' sales_type','id="'.$data->sales_type.'"')?></td>
<td><?=$data->depot?></td>
<td><?=$data->total_amt; $total_total_amt +=$data->total_amt;?></td>
<td><?=$data->discount; $total_discount +=$data->discount;?></td>
<td><?=$data->amt_after_discount; $total_amt_after_discount +=$data->amt_after_discount;?></td>
<td><?=$data->vat_amt; $total_vat_amt +=$data->vat_amt;?></td>
<td><?=$data->total_amt_with_vat; $total_total_amt_with_vat +=$data->total_amt_with_vat;?></td>
</tr>
<?
}
?><tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  <td><strong>Total:</strong></td><td><?=number_format($total_total_amt,2)?></td>
  <td><?=number_format($total_discount,2)?></td>
  <td><?=number_format($total_amt_after_discount,2)?></td>
  <td><?=number_format($total_vat_amt,2)?></td>
  <td><?=number_format($total_total_amt_with_vat,2)?></td>
</tr></tbody></table>
<?
}




elseif($_POST['report']==1111) 
{
if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';} 

if(isset($group_for)) 			{$group_for_con=' and m.group_for="'.$group_for.'"';} 
if(isset($sales_return_type)) 			{$sales_return_type_con=' and m.return_type="'.$sales_return_type.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 

   $sqlr="select distinct c.chalan_no, c.chalan_date, m.do_no, m.invoice_no, m.cash_discount, m.return_type, m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp,c.driver_name,
 sum(total_amt) total_amt, m.group_for, u.group_name, m.vat

from sale_do_return_master m,sale_do_return_chalan c,dealer_info d, warehouse w, user_group u

where m.status in ('CHECKED','COMPLETED', 'INVOICE') 
and m.do_no=c.do_no 

and m.dealer_code=d.dealer_code and m.group_for=u.id
and w.warehouse_id=c.depot_id 
".$depot_con.$date_con.$group_for_con.$dealer_con.$dtype_con.$sales_return_type_con."  group by c.chalan_no 
order by c.chalan_date,m.do_no ";

$query = db_query($sqlr);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9"><?=$str?></td></tr>
<tr style="font-size:12px; background:#82D8CF" height="28"><th width="3%">S/L </th>
  <th width="8%">Invoice View </th>
  <th width="9%">Invoice Date</th>
  <th width="5%">SR No</th>
<th width="7%"> Invoice No </th>
<th width="19%">Customer Name</th>
<th width="9%">Return Type </th>
<th width="10%">Warehouse</th>
<th width="8%"> Return Amt </th>
</tr>
</thead>

<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;
$dp_t = $dp_t+$data->total_amt;
?>
<tr>
<td><?=$s?></td>

<td><a href="../sales_return/sales_invoice_new.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
<td><?php echo date("d-m-Y",strtotime($data->chalan_date)); ?></td>
<td><?=$data->do_no?></td>
<td><?=$data->invoice_no?></td>
<td><?=$data->dealer_name?></td>
<td><?= find_a_field('sales_return_type','sales_return_type','id="'.$data->return_type.'"')?></td>
<td><?=$data->depot?></td>
<td><?=$data->total_amt?></td>
</tr>
<?
}
?><tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  <td><strong>Total:</strong></td><td><?=number_format($dp_t,2)?></td>
  </tr></tbody></table>
<?
}




if($_POST['report']==200512) 
{
if(isset($depot_id)) 			{$depot_con=' and m.depot_id="'.$depot_id.'"';} 

if(isset($group_for)) 			{$group_for_con=' and m.group_for="'.$group_for.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 

  $sqlr="select distinct m.sr_no, m.sr_date, m.do_no, m.chalan_no, concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name, w.warehouse_name as depot,
 sum(c.total_amt) total_amt, m.group_for, u.group_name, m.vat

from sale_return_master m, sale_return_details c,dealer_info d, warehouse w, user_group u

where m.status in ('CHECKED','COMPLETED', 'INVOICE') 
and m.sr_no=c.sr_no 

and m.dealer_code=d.dealer_code and m.group_for=u.id
and w.warehouse_id=m.depot_id 
".$depot_con.$date_con.$group_for_con.$dealer_con.$dtype_con."  group by c.sr_no 
order by m.sr_no ";

$query = db_query($sqlr);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>
<tr><th>S/L</th>
  <th>SR NO </th>
  <th>SR Date </th>
  <th>Invoice View </th>
  <th>SO NO</th>
<th>Customer Name</th>
<th>Company Name</th>
<th>Warehouse</th>
<th>Return Amt</th>
<th>VAT</th>
<th>Adjusted Amt </th>
</tr>
</thead>

<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;
$dp_t = $dp_t+$data->total_amt;
?>
<tr>
<td><?=$s?></td>


<td><a href="sales_return_print_view.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></a></td>
<td><?php echo date('d-m-Y',strtotime($data->sr_date));?></td>
<td><a href="sales_invoice_new.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
<td><?=$data->do_no?></td>
<td><?=$data->dealer_name?></td>
<td><?=$data->group_name?></td>
<td><?=$data->depot?></td>
<td><?=$data->total_amt?></td>
<td><?=number_format($vat_amt=($data->total_amt*$data->vat)/100,2); $tot_vat +=$vat_amt=($data->total_amt*$data->vat)/100; ?></td>
<td><?=number_format($invoice_amount=($data->total_amt+$vat_amt),2); $total_invoice +=$invoice_amount;?></td>
</tr>
<?
}
?><tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  <td><strong>Total:</strong></td><td><?=number_format($dp_t,2)?></td>
  <td><?=number_format($tot_vat,2)?></td>
  <td><?=number_format($total_invoice,2)?></td>
</tr></tbody></table>
<?
}







if($_POST['report']==701) { // gate pass print report

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 	{$depot_con=' and depot_id="'.$depot_id.'"';} 

$sql="SELECT gate_pass_no,vehicle_no,driver_name_real as driver,chalan_date,driver_name as mserial_no,chalan_no,entry_at
FROM sale_do_chalan
where 1
".$depot_con.$date_con." 
and gate_pass_no>0 and chalan_date > '2018-01-01'
group by gate_pass_no";

$query = db_query($sql);

echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr>

<tr><th>S/L</th>
<th>Gate Pass No</th>
<th>Vehicle</th>
<th>Driver</th>
<th>Delivery Date</th>
<th>Chalan No</th>
<th>Manual Serial No</th>
<th>Entry Time</th>
</tr>
</thead>

<tbody>';
$s=1;
while($data=mysqli_fetch_object($query)){
?>
<tr>
<td><?=$s++?></td>
<td><a href="gate_pass_view.php?gp_no=<?=$data->gate_pass_no?>" target="_blank"><?=$data->gate_pass_no?></a></td>
<td><?=$data->vehicle_no?></td>
<td><?=$data->driver?></td>
<td><?=$data->chalan_date?></td>
<td><?=$data->chalan_no?> and more</td>
<td><?=$data->mserial_no?> and more</td>
<td><?=$data->entry_at?></td>
</tr>
<?
}}


elseif($_POST['report']==111) 
{
$sql="select c.chalan_no, m.do_no,m.do_date,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,c.driver_name as serial_no from 
sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w
where m.status in ('CHECKED','COMPLETED') and m.do_no=c.do_no  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and d.dealer_type != 'Distributor'".$depot_con.$date_con.$pg_con.$dealer_con." group by c.chalan_no";
$query = db_query($sql);
echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Chalan No</th><th>Chalan Date</th><th>Do No</th><th>Do Date</th><th>Serial No</th><th>Dealer Name</th><th>Depot</th><th>Total</th><th>SP.Dis.</th><th>Net Total</th></tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;
$sqld = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no;
$info = mysqli_fetch_row(db_query($sqld));
$dp_t = $dp_t+$info[0];
$dis = find_a_field('sale_do_master','sp_discount','do_no="'.$data->do_no.'"');
$tod = ($info[0]*$dis)/100;
$tot = $info[0]-($info[0]*$dis)/100;
$tod_t = $tod_t + $tod;
$tot_t = $tot_t + $tot;
?>
<tr><td><?=$s?></td><td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td><td><?=$data->chalan_date?></td><td><?=$data->do_no?></td><td><?=$data->do_date?></td><td><?=$data->serial_no?></td><td><?=$data->dealer_name?></td><td><?=$data->depot?></td><td><?=$info[0]?></td><td><?=$tod?></td><td><?=$tot?></td></tr>
<?
}
echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tod_t,2).'</td><td>'.number_format($tot_t,2).'</td></tr></tbody></table>';

}
elseif($_POST['report']==3) 
{
$sql2 	= "select distinct o.do_no,c.chalan_no as chalan_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,m.do_date,d.address_e,d.mobile_no,d.product_group from 
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
$str 	.= '<p style="width:100%">Chalan NO: '.$chalan_no.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DO NO: '.$do_no.' 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depot:'.$warehouse_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:'.$do_date.'</p>
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
<table width="100%" cellspacing="0" cellpadding="2" border="0">
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
<table width="100%" cellspacing="0" cellpadding="2" border="0">
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
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;"></td></tr></thead>
<tbody>
  <tr class="footer">
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}



}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?></div>
</body>
</html>