<?
session_start();
require "../../../engine/tools/check.php";
require "../../../engine/configure/db_connect.php";
require "../../../engine/tools/my.php";
require "../../../engine/tools/report.class.php";

date_default_timezone_set('Asia/Dhaka');
if($_REQUEST['report']>0)
{
	if((strlen($_REQUEST['t_date'])==10))
	{
		$t_date=$_REQUEST['t_date'];
		$f_date=$_REQUEST['f_date'];
	}
	
if($_REQUEST['product_group']!='') $product_group=$_REQUEST['product_group'];
if($_REQUEST['item_brand']!='') 	$item_brand=$_REQUEST['item_brand'];
if($_REQUEST['item_id']>0) 		$item_id=$_REQUEST['item_id'];
if($_REQUEST['dealer']>0) 	$dealer_code=$_REQUEST['dealer'];
if($_REQUEST['dealer_type']!='') 	$dealer_type=$_REQUEST['dealer_type'];

if($_REQUEST['status']!='') 		$status=$_REQUEST['status'];
if($_REQUEST['do_no']!='') 			$do_no=$_REQUEST['do_no'];
if($_REQUEST['area_id']!='') 		$area_id=$_REQUEST['area_id'];
if($_REQUEST['zone_id']!='') 		$zone_id=$_REQUEST['zone_id'];
if($_REQUEST['region_id']>0) 		$region_id=$_REQUEST['region_id'];
if($_REQUEST['depot_id']!='') 		$depot_id=$_REQUEST['depot_id'];

$item_info = find_all_field('item_info','','item_id='.$item_id);

if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		
{
if($product_group=='ABC')
$pg_con=' and d.product_group!="M"';
else
$pg_con=' and d.product_group="'.$product_group.'"';
} 
if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dtype_con=' and d.dealer_type="Distributor"';} else {$dtype_con=' and d.dealer_type!="Distributor"';}}
if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';} else {$dealer_type_con=' and d.dealer_type!="Distributor"';}} 

if(isset($dealer_code)) 		{$dealer_con=' and m.dealer_code='.$dealer_code;} 
if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 

switch ($_REQUEST['report']) {
case 1:
$report="Super Shop Price Report";

$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,i.unit_name,i.pack_size,i.d_price as DP,i.t_price as TP,i.m_price as MRP,concat(s.discount,'%') as discount, s.set_price,(s.set_price*i.pack_size) as CTN_Price from item_info i,sales_corporate_price s where i.item_id=s.item_id and s.dealer_code='".$_REQUEST['dealer']."' and i.sub_group_id=1096000100010000 order by i.finish_goods_code";
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
    <style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
.style5 {color: #FFFFFF}
-->
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
		if(isset($dealer_code)) 
		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';
		if(isset($item_info->item_id)) 
		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
		if(isset($region_id)) 
		$str 	.= '<h2>Region Name : '.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id).'</h2>';
		if(isset($zone_id)) 
		$str 	.= '<h2>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id).'</h2>';
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

echo report_create($sql,1,$str);
?>
</div>
</body>
</html>