<?

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


date_default_timezone_set('Asia/Dhaka');

if($_REQUEST['report']>0)
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
if($_REQUEST['do_no']!='') 			$do_no=$_REQUEST['do_no'];
if($_REQUEST['area_id']!='') 		$area_id=$_REQUEST['area_id'];
if($_REQUEST['zone_id']!='') 		$zone_id=$_REQUEST['zone_id'];
if($_REQUEST['region_id']>0) 		$region_id=$_REQUEST['region_id'];
if($_REQUEST['depot_id']!='') 		$depot_id=$_REQUEST['depot_id'];

if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
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
//if(isset($do_no)) 			{$do_no_con=' and a.do_no="'.$do_no.'"';} 
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $Damage_con=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

switch($_REQUEST['report']) {
case 1:
		$report="Item Wise Order Based Detail Report(DO DATE)";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;
		
case 6:
		$report="Secoundary Sales Party wise";
		break;

		
		case 2:
		$report="Item Wise Delivery Based Detail Report(DO DATE)";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;

		case 3:
		$report="Item Wise Delivery Based Detail Report(CH DATE)";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;
				case 4:
		$report="Free Item Review Report";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$region_name?> <?=$zone_name?> <?=$dealer_name?> <?=$report?></title>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{document.getElementById('pr').style.display='none';}
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
.style4 {font-weight: bold}
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
		if(isset($dealer_name)) 
		$str 	.= '<h2>Dealer Name : '.$dealer_name.'</h2>';
		if(isset($item_info->item_id)) 
		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
		
		if(isset($item_brand)) 
		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';
		
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



if($_REQUEST['report']==1) 
{
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<?

$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,i.item_name,sum(c.total_unit) total_unit,c.unit_price, 
i.finish_goods_code as fg_cdoe,
sum(c.total_amt) total_amt,w.warehouse_name as depot,a.AREA_NAME,z.ZONE_CODE ZONE_ID,z.ZONE_NAME,r.BRANCH_NAME,d.dealer_code,d.product_group,i.pack_size  
from 
sale_do_master m, sale_do_details c,dealer_info d  , warehouse w ,item_info i, area a, zon z, branch r

where 
d.area_code=a.AREA_CODE and a.ZONE_ID =z.ZONE_CODE and z.REGION_ID=r.BRANCH_ID and c.unit_price>0 and 
i.item_id=c.item_id and m.do_no=c.do_no and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot 
".$item_brand_con.$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con."   group by d.dealer_code,i.item_id order by z.ZONE_CODE,d.dealer_code desc";

$query = db_query($sql);

?>
<thead><tr><td style="border:0px;" colspan="8"><?=$str?></td></tr><tr><th>S/L-1</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Region </th>
<th>Zone Name</th>
<th>Code</th>
<th>Item Name Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>CTN</th>
<th>PCS</th>
<th>Total AMT</th>
</tr></thead><tbody>
<? 
$zone_total = 0;
$dealer_total = 0;
$region_total = 0;
while($data=mysqli_fetch_object($query))
{$s++;


if($old_dealer_code != $data->dealer_code&&$old_dealer_code != ''){
echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';
$dealer_total = 0;
}
if($old_zone_code != $data->ZONE_ID&&$old_zone_code != ''){
echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
$zone_total = 0;
}

// <?=($old_dealer_code!=$data->dealer_code)?$data->dealer_name.'-'.$data->AREA_NAME:'';

?>

<tr><td><?=$s?></td>
<td><?=$data->dealer_code?></td>
  <td><?=$data->dealer_name.'-'.$data->AREA_NAME;?></td>
  <td><?=$data->BRANCH_NAME?></td>
  <td><?=$data->ZONE_NAME?></td>
  <td><?=$data->fg_cdoe?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->product_group;?></td>

<td><?=$data->unit_price;?></td>
<td><?=(int)($data->total_unit/$data->pack_size);?></td>
<td><?=(int)($data->total_unit%$data->pack_size);?></td>
<td><?=number_format($data->total_amt,2)?></td>
</tr>
<?
$zone_total = $zone_total + $data->total_amt;
$dealer_total = $dealer_total + $data->total_amt;
$region_total = $region_total + $data->total_amt;

$old_dealer_code = $data->dealer_code;
$old_zone_code = $data->ZONE_ID;



}

echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';


echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';


?></tbody></table>
<?
}

elseif($_REQUEST['report']==2) 
{ 
if($dealer_type=='Distributor'){?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<?

$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,i.item_name,sum(c.total_unit) total_unit,c.unit_price,
sum(c.total_amt) total_amt,w.warehouse_name as depot,a.AREA_NAME,z.ZONE_CODE ZONE_ID,z.ZONE_NAME,r.BRANCH_NAME,d.dealer_code,d.product_group,i.pack_size 
from 
sale_do_master m, sale_do_chalan c,dealer_info d  , warehouse w ,item_info i, area a, zon z, branch r

where 
d.area_code=a.AREA_CODE and a.ZONE_ID =z.ZONE_CODE and z.REGION_ID=r.BRANCH_ID and c.unit_price>0 and 
i.item_id=c.item_id and m.do_no=c.do_no and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$item_brand_con.$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." group by d.dealer_code,i.item_id order by z.ZONE_CODE,d.dealer_code desc";

$query = db_query($sql);

?>
<thead><tr><td style="border:0px;" colspan="7"><?=$str?></td></tr><tr><th>S/L-2</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Region Name </th>
<th>Zone Name</th><th>Item Name Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>CTN</th>
<th>PCS</th>
<th>Total AMT</th>
</tr></thead><tbody>
<? 
$zone_total = 0;
$dealer_total = 0;
$region_total = 0;
while($data=mysqli_fetch_object($query)){$s++;




if($old_dealer_code != $data->dealer_code&&$old_dealer_code != ''){
echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';
$dealer_total = 0;
}
if($old_zone_code != $data->ZONE_ID&&$old_zone_code != ''){
echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
$zone_total = 0;
}
?>

<tr><td><?=$s?></td><td><?=$data->dealer_code;?></td>
  <td><?=$data->dealer_name.'-'.$data->AREA_NAME;?></td>
  <td><?=$data->BRANCH_NAME?></td>
  <td><?=$data->ZONE_NAME?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->product_group;?></td>

<td><?=$data->unit_price;?></td>
<td><?=(int)($data->total_unit/$data->pack_size);?></td>
<td><?=(int)($data->total_unit%$data->pack_size);?></td>
<td><?=number_format($data->total_amt,2)?></td>
</tr>
<?
$zone_total = $zone_total + $data->total_amt;
$dealer_total = $dealer_total + $data->total_amt;
$region_total = $region_total + $data->total_amt;

$old_dealer_code = $data->dealer_code;
$old_zone_code = $data->ZONE_ID;



}

echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';


echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';


?></tbody></table>
<? }
if($dealer_type!='Distributor'){?><table width="100%" cellspacing="0" cellpadding="2" border="0"><?

if($dealer_type=='MordernTrade')		{ $dealer_type_con = ' and( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}

/*$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,d.dealer_type,i.item_name,sum(c.total_unit) total_unit,c.unit_price,
sum(c.total_amt) total_amt,w.warehouse_name as depot,d.dealer_code,d.product_group,i.pack_size 
from 
sale_do_master m, sale_do_chalan c,dealer_info d, warehouse w ,item_info i
where 
c.unit_price>0 and i.item_id=c.item_id 
and m.do_no=c.do_no 
and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$item_brand_con.$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." group by d.dealer_code,i.item_id order by d.dealer_type,d.dealer_code desc";*/


$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,d.dealer_type,i.item_name,sum(c.total_unit) total_unit,c.unit_price,
sum(c.total_amt) total_amt,w.warehouse_name as depot,d.dealer_code,d.product_group,i.pack_size 
from 
sale_do_chalan c,dealer_info d, warehouse w ,item_info i
where 
c.unit_price>0 and i.item_id=c.item_id 

and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot 
".$item_brand_con.$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." 
group by d.dealer_code,i.item_id 
order by d.dealer_type,d.dealer_code desc";

$query = db_query($sql);
?>
<thead><tr><td style="border:0px;" colspan="6"><?=$str?></td></tr>
<tr><th>S/L-2</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Dealer Type</th>
<th>Item Name Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>CTN</th>
<th>PCS</th>
<th>Total AMT</th>
</tr></thead><tbody>
<? 
$zone_total = 0;
$dealer_total = 0;
$region_total = 0;
while($data=mysqli_fetch_object($query)){$s++; 

if($old_dealer_code != $data->dealer_code&&$old_dealer_code != ''){
echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';
$dealer_total = 0;
}
if($old_dealer_type != $data->dealer_type&&$old_dealer_type != ''){
echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> '.$old_dealer_type.' Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
$zone_total = 0;
}

?>

<tr><td><?=$s?></td><td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_code:'';?></td>
<td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_name:'';?></td>
<td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_type:'';?></td><td><?=$data->item_name?></td><td><?=$data->product_group;?></td>
<td><?=$data->unit_price;?></td>
<td><?=(int)($data->total_unit/$data->pack_size);?></td>
<td><?=(int)($data->total_unit%$data->pack_size);?></td>
<td><?=number_format($data->total_amt,2)?></td></tr>
<?
$zone_total = $zone_total + $data->total_amt;
$dealer_total = $dealer_total + $data->total_amt;
$region_total = $region_total + $data->total_amt;

$old_dealer_code = $data->dealer_code;
$old_dealer_type = $data->dealer_type;
}

echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';


echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> '.$old_dealer_type.' Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
?></tbody></table><? }
}


elseif($_REQUEST['report']==3) 
{
if($dealer_type=='Distributor'){?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<?

$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,i.item_name,sum(c.total_unit) total_unit,c.unit_price,
sum(c.total_amt) total_amt,w.warehouse_name as depot,a.AREA_NAME,z.ZONE_CODE ZONE_ID,z.ZONE_NAME,r.BRANCH_NAME,d.dealer_code,d.product_group,i.pack_size ,i.finish_goods_code 
from 
sale_do_master m, sale_do_chalan c,dealer_info d  , warehouse w ,item_info i, area a, zon z, branch r

where 
d.area_code=a.AREA_CODE and a.ZONE_ID =z.ZONE_CODE and z.REGION_ID=r.BRANCH_ID and c.unit_price>0 and 
i.item_id=c.item_id and m.do_no=c.do_no and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$item_brand_con.$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." group by d.dealer_code,i.item_id order by z.ZONE_CODE,d.dealer_code desc";

$query = db_query($sql);

?>
<thead><tr><td style="border:0px;" colspan="8"><?=$str?></td></tr>
<tr><th>S/L-3</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Region</th>
<th>Zone Name</th>
<th>FGC</th>
<th>Item Name Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>CTN</th>
<th>PCS</th>
<th>Total AMT</th>
</tr></thead><tbody>
<? 
$zone_total = 0;
$dealer_total = 0;
$region_total = 0;
while($data=mysqli_fetch_object($query)){$s++;


if($old_dealer_code != $data->dealer_code&&$old_dealer_code != ''){
echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';
$dealer_total = 0;
}
if($old_zone_code != $data->ZONE_ID&&$old_zone_code != ''){
echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
$zone_total = 0;
}
?>

<tr><td><?=$s?></td>

  <td><?=$data->dealer_code?></td>
  <td><?=$data->dealer_name.'-'.$data->AREA_NAME?></td>
  <td><?=$data->BRANCH_NAME?></td>
  <td><?='Zone-'.$data->ZONE_NAME;?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_name?></td><td><?=$data->product_group;?></td>


<td><?=$data->unit_price;?></td>
<td><?=(int)($data->total_unit/$data->pack_size);?></td>
<td><?=(int)($data->total_unit%$data->pack_size);?></td>
<td><?=number_format($data->total_amt,2)?></td>
</tr>
<?
$zone_total = $zone_total + $data->total_amt;
$dealer_total = $dealer_total + $data->total_amt;
$region_total = $region_total + $data->total_amt;

$old_dealer_code = $data->dealer_code;
$old_zone_code = $data->ZONE_ID;



}

echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';


echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Zone Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';


?></tbody></table>
<? }
if($dealer_type!='Distributor'){?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<?
if($dealer_type=='MordernTrade')		{ $dealer_type_con = ' and( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
$sql="select c.id,c.do_no, c.do_no,c.do_date,d.dealer_code,d.dealer_name_e dealer_name,i.finish_goods_code,i.item_name,sum(c.total_unit) total_unit,c.unit_price,d.dealer_type,
sum(c.total_amt) total_amt,w.warehouse_name as depot,d.dealer_code,d.product_group,i.pack_size 
from 
sale_do_master m, sale_do_chalan c,dealer_info d  , warehouse w ,item_info i

where 
c.unit_price>0 and 
i.item_id=c.item_id and m.do_no=c.do_no and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$item_brand_con.$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." group by d.dealer_code,i.item_id order by d.dealer_type,d.dealer_code desc";

$query = db_query($sql);

?>
<thead><tr><td style="border:0px;" colspan="6"><?=$str?></td></tr>
<tr><th>S/L-3</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Dealer Type</th>
<th>Code</th>
<th>Item Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>CTN</th>
<th>PCS</th>
<th>Total AMT</th>
</tr></thead><tbody>
<? 
$zone_total = 0;
$dealer_total = 0;
$region_total = 0;
while($data=mysqli_fetch_object($query)){$s++;


if($old_dealer_code != $data->dealer_code&&$old_dealer_code != ''){
echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';
$dealer_total = 0;
}
if($old_dealer_type != $data->dealer_type&&$old_dealer_type != ''){
echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> '.$old_dealer_type.' Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';
$zone_total = 0;
}
?>

<tr>
<td><?=$s?></td>
<td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_code:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_name.'-'.$data->AREA_NAME:'';?></td>
  <td><?=($old_dealer_code!=$data->dealer_code)?$data->dealer_type:'';?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->product_group;?></td>


<td><?=$data->unit_price;?></td>
<td><?=(int)($data->total_unit/$data->pack_size);?></td>
<td><?=(int)($data->total_unit%$data->pack_size);?></td>
<td><?=number_format($data->total_amt,2)?></td>
</tr>
<?
$zone_total = $zone_total + $data->total_amt;
$dealer_total = $dealer_total + $data->total_amt;
$region_total = $region_total + $data->total_amt;

$old_dealer_code = $data->dealer_code;
$old_dealer_type = $data->dealer_type;



}

echo '
<tr style="background-color:#FFFF99">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> Total Amount</td>
  <td>'.$dealer_total.'</td>
</tr>';


echo '
<tr style="background-color:#FFF000">
  <td colspan="6">&nbsp;</td>
  <td colspan="3"> '.$old_dealer_type.' Total Amount</td>
  <td>'.$zone_total.'</td>
</tr>';


?></tbody></table>
<? }
}

elseif($_REQUEST['report']==4) 
{ 
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<?

if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 $sql="select c.do_no, c.chalan_no, c.do_date, c.chalan_date, d.dealer_code, d.dealer_name_e dealer_name, w.warehouse_name as depot,d.dealer_code,d.product_group
from 
sale_do_master m, sale_do_chalan c, dealer_info d  , warehouse w

where 
m.do_no=c.do_no and c.dealer_code=d.dealer_code and w.warehouse_id=d.depot ".$item_con.$depot_con.$date_con.$pg_con.$con.$dealer_type_con.$damage_con." group by c.chalan_no order by d.dealer_code desc";

$query = db_query($sql);$s = 0 ;
while($data=mysqli_fetch_object($query)){$s++;
if($s==1) $chalans = $data->chalan_no;
else      $chalans = $chalans.', '.$data->chalan_no;

if($s==1) $dos = $data->do_no;
else      $dos = $dos.', '.$data->do_no;

$dealer[$data->chalan_no] = $data->dealer_name;
$dealer_code[$data->chalan_no] = $data->dealer_code;
$depot[$data->chalan_no] = $data->warehouse_name;
}

$sql="select 1,c.chalan_no,c.order_no,sum(c.total_unit) total_unit,sum(c.total_amt) total_amt
from 
sale_do_chalan c
where 
c.chalan_no in (".$chalans.") group by  order_no,chalan_no";

$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$total_unit[$data->order_no][$data->chalan_no] = $data->total_unit;
$total_amt[$data->order_no][$data->chalan_no] = $data->total_amt;

if($chalan_no[$data->order_no]>0)      $chalan_no1[$data->order_no] = $data->chalan_no;
elseif($chalan_no1[$data->order_no]>0) $chalan_no2[$data->order_no] = $data->chalan_no;
elseif($chalan_no2[$data->order_no]>0) $chalan_no3[$data->order_no] = $data->chalan_no;
elseif($chalan_no3[$data->order_no]>0) $chalan_no4[$data->order_no] = $data->chalan_no;
else
$chalan_no[$data->order_no] = $data->chalan_no;
}

$sql="select c.id,c.gift_on_order,c.do_no, c.do_no,c.do_date,i.item_name free_item_name,i2.item_name main_item_name,c.unit_price, g.item_qty,g.gift_qty
from 
sale_do_master m, sale_do_details c,item_info i,item_info i2,sale_gift_offer g

where 
c.unit_price=0 and c.do_no in (".$dos.") and c.gift_id=g.id and
i.item_id=c.item_id and i2.item_id=c.gift_on_item and m.do_no=c.do_no order by c.do_no desc";


$query = db_query($sql);

?>
<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr><tr><th>S/L</th>
<th>Dealer Code</th>
<th>Dealer Name-Area</th>
<th>Depot</th>
<th>DO NO</th>
<th>DO Date</th>
<th>Chalan No</th>
<th>Order No</th>
<th>Free Item  Name</th>
<th>Main Item  Name</th>
<th>Grp</th>
<th>Unit Price</th>
<th>S-QTY</th>
<th>S-AMT</th>
<th>P-QTY</th>
<th>C-QTY</th>
<th>D-QTY</th>
</tr></thead><tbody>
<? 
while($data=mysqli_fetch_object($query)){

?>

<tr>
        <td><?=++$s?></td><td><?=$dealer_code[$chalan_no[$data->id]];?></td>
        <td><?=$dealer[$chalan_no[$data->id]];?></td>
        <td><?=$depot[$chalan_no[$data->id]];?></td>
        <td><?=$data->do_no?></td>
        <td><?=$data->do_date?></td>
        <td><?=$chalan_no[$data->id]?><br /><? 
		if($chalan_no[$data->gift_on_order]>0&&$chalan_no[$data->gift_on_order]!=$chalan_no[$data->id]) echo '<br />'.$chalan_no[$data->gift_on_order]; 
		if($chalan_no1[$data->id]>0) {echo '<br />'.$chalan_no1[$data->id]; 
		if($chalan_no2[$data->id]>0) {echo '<br />'.$chalan_no2[$data->id]; 
		if($chalan_no3[$data->id]>0) {echo '<br />'.$chalan_no3[$data->id]; 
		if($chalan_no4[$data->id]>0) {echo '<br />'.$chalan_no4[$data->id]; 
		}}}}?></td>
        <td><?=$data->id?></td>
        <td><?=$data->free_item_name?></td>
        <td><?=$data->main_item_name?></td>
        <td><?=$data->product_group;?></td>
        <td><?=$data->unit_price;?></td>
        <td><? echo $main_pay = @array_sum($total_unit[$data->gift_on_order]); ?></td>
        <td><? echo $main_amt = @array_sum($total_amt[$data->gift_on_order]); ?></td>
        <td><? echo $pay = @(($main_pay*$data->gift_qty)/$data->item_qty);?></td>
        <td><? echo $paid =@array_sum($total_unit[$data->id]);?></td>
        <td><? if($paid<>$pay) echo '<div style="color:#FF0000; font-weight:bold">'.($paid-$pay).'</div>'; else echo '<div style="color:#009900; font-weight:bold">'.($paid-$pay).'</div>'; ?></td>
</tr>
<?

}



?></tbody></table>
<?
}


elseif($_POST['report']==6) {

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; 
	$date_con=' and c.sales_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';}  
if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 


echo $sqls="select d.dealer_code as code,c.sales_date,d.dealer_name_e as dealer_name,c.area_id as area,d.product_group as grp,c.rcv_amt as amount
from sec_sales_upload c,dealer_info d
where  c.dealer_code=d.dealer_code
".$date_con.$pg_con.$dealer_con." 
order by c.sales_date,code";

$query = db_query($sqls);

?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="12"><?=$str?></td></tr><tr>
<th>S/L</th>
<th>Chalan Date</th>
<th>Code</th>
<th>Dealer Name</th>
<th>Area</th>
<th>Grp</th>
<th>Sales Total</th>
</tr></thead><tbody>
<?
while($data=mysqli_fetch_object($query)){

$s++;
$tsales += $data->amount;
?>
<tr>

<td><?=$s?></td>
<td><?=$data->sales_date?></td>
<td><?=$data->code?></td>
<td><?=$data->dealer_name?></td>
<td><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$data->area.'"');?></td>
<td><?=$data->grp?></td>
<td><?=$data->amount?></td>
</tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>

  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
<td><?=number_format(($tsales),2)?></td>



</tr></tbody></table>
<?
}


elseif($_POST['report']==7) {

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; 
	$date_con=' and c.sales_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';}
if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';}  
if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 


$sqls="select d.dealer_code as code,d.dealer_name_e as dealer_name,
d.area_code as area,d.product_group as grp,sum(c.rcv_amt) as amount
from sec_sales_upload c,dealer_info d
where  c.dealer_code=d.dealer_code
".$date_con.$pg_con.$dealer_con." 
group by code
order by c.sales_date,code";

$query = db_query($sqls);


?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="12"><?=$str?></td></tr><tr>
<th>S/L</th>
<th>Code</th>
<th>Dealer Name</th>
<th>Area</th>
<th>Grp</th>
<th>Sales Total</th>
</tr></thead><tbody>
<?
while($data=mysqli_fetch_object($query)){

$s++;
$tsales += $data->amount;
?>
<tr>

<td><?=$s?></td>
<td><?=$data->code?></td>
<td><?=$data->dealer_name?></td>
<td><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$data->area.'"');?></td>
<td><?=$data->grp?></td>
<td><?=$data->amount?></td>
</tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>



<td><?=number_format(($tsales),2)?></td>



</tr></tbody></table>
<?
}


elseif($_POST['report']==5) 
{
			if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
			elseif(isset($item_id)) 			{$item_sub_con=' and i.item_id='.$item_id;} 
			
			if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 
			
			if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; $date_con=" and pi_date between '".$fr_date."' and '".$to_date."'";}
//	$w3[][] = oitem('3',$date_con);
//	$w6 = oitem('6',$date_con);
//	$w9 = oitem('9',$date_con);
//	$w7 = oitem('7',$date_con);
//	$w8 = oitem('8',$date_con);
//	$w10 = oitem('10',$date_con);
//	$w54 = oitem('54',$date_con);

	$sql="select sum(total_unit) as item_ex,item_id from production_issue_detail where 1 ".$date_con." and warehouse_from=".$_POST['depot_id']." and warehouse_to =3 group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w3[$row->item_id] = $row->item_ex;
		
	}
	$sql="select sum(total_unit) as item_ex,item_id from production_issue_detail where 1 ".$date_con." and warehouse_from=".$_POST['depot_id']." and warehouse_to ='10' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w10[$row->item_id] = $row->item_ex;
		
	}
	$sql="select sum(total_unit) as item_ex,item_id from production_issue_detail where 1 ".$date_con." and warehouse_from=".$_POST['depot_id']." and warehouse_to ='8' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w8[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(total_unit) as item_ex,item_id from production_issue_detail where 1 ".$date_con." and warehouse_from=".$_POST['depot_id']." and warehouse_to ='7' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w7[$row->item_id] = $row->item_ex;
		
	}
				$sql="select sum(total_unit) as item_ex,item_id from production_issue_detail where 1 ".$date_con." and warehouse_from=".$_POST['depot_id']." and warehouse_to ='54' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w54[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(total_unit) as item_ex,item_id from production_issue_detail where 1 ".$date_con." and warehouse_from=".$_POST['depot_id']." and warehouse_to ='6' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w6[$row->item_id] = $row->item_ex;
		
	}
		$sql="select sum(total_unit) as item_ex,item_id from production_issue_detail where 1 ".$date_con." and warehouse_from=".$_POST['depot_id']." and warehouse_to ='9' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w9[$row->item_id] = $row->item_ex;
		
	}
			$sql="select sum(total_unit) as item_ex,item_id from production_issue_detail where 1 ".$date_con." and warehouse_from=".$_POST['depot_id']." and warehouse_to ='89' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w89[$row->item_id] = $row->item_ex;
		
	}
			$sql="select sum(total_unit) as item_ex,item_id from production_issue_detail where 1 ".$date_con." and warehouse_from=".$_POST['depot_id']." and warehouse_to ='90' group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$w90[$row->item_id] = $row->item_ex;
		
	}
$sql='select distinct p.item_id,i.unit_name,i.brand_category_type,i.item_name,"Finished Goods",i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 
from item_info i, production_issue_detail p where i.item_id=p.item_id and i.finish_goods_code>0 and i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' order by i.brand_category_type,i.brand_category,i.item_brand';
		   
$query =db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="10"><div class="header"><h1>Jamuna Group</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date-<?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
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
	
	//echo $sql = 'select sum(total_unit) from journal_item where item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"';

?>
<tr>
	<td><?=++$j?></td>
	<td><?=$data->item_brand?></td>
	<td><?=$data->brand_category_type?></td>
	<td><?=$data->finish_goods_code?></td>
	<td><?=$data->item_name?></td>
	<td><?=$data->sales_item_type?></td>
	<td><?=$data->unit_name?></td>
	<td style="text-align:right"><?=($dhaka>0)? (int)$dhaka : ''?></td>
	<td style="text-align:right"><?=($gajipur>0)? (int)$gajipur : ''?></td>
	<td style="text-align:right"><?=($ctg>0)? (int)$ctg : ''?></td>
	<td style="text-align:right"><?=($borisal>0)? (int)$borisal : ''?></td>
	<td style="text-align:right"><?=($bogura>0)? (int)$bogura : ''?></td>
	<td style="text-align:right"><?=($sylhet>0)? (int)$sylhet : ''?></td>
	<td style="text-align:right"><?=($jessore>0)? (int)$jessore : ''?></td>
	<td style="text-align:right"><?=($rangpur>0)? (int)$rangpur : ''?></td>
	<td style="text-align:right"><?=($comilla>0)? (int)$comilla : ''?></td>
	<td style="text-align:right"><span class="style4">
	  <?=($total>0)? (int)$total : ''?>
	</span></td>
</tr>
<?
}
		
?>
</tbody></table>
<?
}


elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}}
?></div>
<!--<script type="text/javascript">
 
$("tr").not(':first').hover(
  function () {
    $(this).css("background","yellow");
  }, 
  function () {
    $(this).css("background","");
  }
);
 
</script>-->
</body>
</html>
