<?
session_start();
require "../../../engine/tools/check.php";
require "../../../engine/configure/db_connect.php";
require "../../../engine/tools/my.php";
require "../../../engine/tools/report.class.php";

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

if($_POST['status']!='') 		$status=$_POST['status'];
if($_POST['or_no']!='') 		$or_no=$_POST['or_no'];
if($_POST['area_id']!='') 		$area_id=$_POST['area_id'];
if($_POST['zone_id']!='') 		$zone_id=$_POST['zone_id'];
if($_POST['region_id']>0) 		$region_id=$_POST['region_id'];
if($_POST['depot_id']!='') 		$depot_id=$_POST['depot_id'];

if($_POST['receive_type']!='') 		$receive_type=$_POST['receive_type'];

if(isset($receive_type)) 			{$receive_type_con=' and o.receive_type="'.$receive_type.'"';} 


if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 


if(isset($dealer_code)) 		{$dealer_con=' and m.vendor_id='.$dealer_code;} 
if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 

switch ($_POST['report']) {

	    case 1:
		$report="Damage Report Item Wise";

$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,i.item_brand,i.sales_item_type as `group`,
sum(o.qty) as pcs, 
sum(o.qty*i.f_price) as Cost_Price,
sum(o.amount)as Dealer_Price
from 
warehouse_damage_receive m,warehouse_damage_receive_detail o, item_info i,dealer_info d
where m.or_no=o.or_no and m.vendor_id=d.dealer_code and i.item_id=o.item_id   ".$date_con.$item_con.$item_brand_con.$depot_con.$receive_type_con.' group by i.finish_goods_code';
	break;
	
	case 2:
$report="Damage Report Dealer Wise";
	break;

		case 3:
		$report="Damage Report Summary ";
		
$sql="select m.or_no as dr_no,manual_or_no as serial_no,m.or_date as date,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,w.warehouse_name as Store,d.product_group as grp,(select sum(amount) from warehouse_damage_receive_detail where or_no=m.or_no) as amount from warehouse_damage_receive m,dealer_info d  , warehouse w
where  m.vendor_id=d.dealer_code and w.warehouse_id=d.depot".$date_con." order by m.entry_at";
		break;
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
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
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
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
if($_POST['report']==2) 
{
$sql2 	= "select distinct o.or_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,m.or_date,d.address_e,d.mobile_no,d.product_group from 
warehouse_damage_receive m,warehouse_damage_receive_detail o, item_info i,dealer_info d , warehouse w
where m.or_no=o.or_no and i.item_id=o.item_id and m.vendor_id=d.dealer_code  and w.warehouse_id=d.depot ".$receive_type_con.$date_con.$item_con.$depot_con.$dealer_con;
$query2 = db_query($sql2);

while($data=mysqli_fetch_object($query2)){
echo '<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid">';
	$dealer_code = $data->dealer_code;
	$dealer_name = $data->dealer_name_e;
	$warehouse_name = $data->warehouse_name;
	$or_date = $data->or_date;
	$or_no = $data->or_no;
		if($dealer_code>0) 
{
$str 	.= '<p style="width:100%">Dealer Name: '.$dealer_name.' - '.$dealer_code.'('.$data->product_group.')</p>';
$str 	.= '<p style="width:100%">DI NO: '.$or_no.' 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depot:'.$warehouse_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:'.$or_date.'</p>
<p style="width:100%">Destination:'.$data->address_e.'('.$data->mobile_no.')</p>';

$dealer_con = ' and m.vendor_id='.$dealer_code;
$do_con = ' and m.or_no='.$or_no;

$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,dd.damage_cause,o.qty as pcs,(i.f_price*o.qty) as Cost_price,o.amount as Dealer_Price from 
warehouse_damage_receive m,warehouse_damage_receive_detail o, item_info i,dealer_info d , warehouse w, damage_cause dd
where o.receive_type=dd.id and m.or_no=o.or_no and i.item_id=o.item_id and m.vendor_id=d.dealer_code  and w.warehouse_id=d.depot ".$receive_type_con.$date_con.$item_con.$depot_con.$do_con." order by m.or_date desc";
}

echo report_create($sql,1,$str);
		$str = '';
		echo '</div>';
}
}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?></div>
</body>
</html>