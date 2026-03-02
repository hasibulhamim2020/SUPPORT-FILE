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

if($_POST['issue_type']!='') 	$issue_type=$_POST['issue_type'];

if($_POST['status']!='') 		$status=$_POST['status'];
if($_POST['do_no']!='') 		$do_no=$_POST['do_no'];
if($_POST['area_id']!='') 		$area_id=$_POST['area_id'];
if($_POST['zone_id']!='') 		$zone_id=$_POST['zone_id'];
if($_POST['region_id']>0) 		$region_id=$_POST['region_id'];
if($_POST['depot_id']!='') 		$depot_id=$_POST['depot_id'];

if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($product_group)) 		{
if($product_group=='ABCD')
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
case 1:
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$report="Other Chalan Summary Brief";
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
		$report="Other Order wise Chalan Summary Brief";
		break;
case 19921:
$report="Sales Statement(As Per CH)";

break;
case 201:
		$report="Item Wise Chalan Details Report(HFML)";
		
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql = 'select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.item_ex) div i.pack_size as pkt,
		sum(a.item_ex) mod i.pack_size as pcs,
		sum(a.item_ex) qty,
		sum(a.item_ex*a.item_price) as sale_amt
		
		from journal_item a, item_info i 
		where a.tr_from != "Reprocess Issue" and a.item_ex>0 and i.finish_goods_code>0 and a.warehouse_id="68" and a.item_id=i.item_id '.$date_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
		$sql2 = 'select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.item_ex) div i.pack_size as pkt,
		sum(a.item_ex) mod i.pack_size as pcs,
		sum(a.item_ex) qty,
		sum(a.item_ex*a.item_price) as amt
		
		from journal_item a, item_info i 
		where a.tr_from in ("Sample Issue","Gift Issue") and a.item_ex>0 and i.finish_goods_code>0 and a.warehouse_id="68" and a.item_id=i.item_id '.$date_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$sg_pkt[$data2->item_id] = $data2->pkt;
	$sg_pcs[$data2->item_id] = $data2->pcs;
	$sg_qty[$data2->item_id] = $data2->qty;
	$sg_amt[$data2->item_id] = $data2->amt;
	}
	
		$sql2 = 'select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.item_ex) div i.pack_size as pkt,
		sum(a.item_ex) mod i.pack_size as pcs,
		sum(a.item_ex) qty,
		sum(a.item_ex*a.item_price) as amt
		
		from journal_item a, item_info i 
		where a.item_ex>0 and i.finish_goods_code>0 and a.warehouse_id="68" and (a.relevant_warehouse in (3,6,7,8,9,10,11,54,89,90)) and a.item_id=i.item_id '.$date_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$sc_pkt[$data2->item_id] = $data2->pkt;
	$sc_pcs[$data2->item_id] = $data2->pcs;
	$sc_qty[$data2->item_id] = $data2->qty;
	$sc_amt[$data2->item_id] = $data2->amt;
	}
		
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
$sql2='select 
		i.finish_goods_code as fg,
		m.item_id as item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*a.unit_price) as amt,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_other_details m,sale_other_chalan a, item_info i 
		
		where d.dealer_code!="30019" and d.dealer_code!="30005" and d.dealer_code=m.dealer_code and m.id=a.order_no  and  d.group_for="'.$_SESSION['user']['group'].'"  and m.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
	group by  m.item_id order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$trade_pcs[$data2->item_id] = $data2->pcs;
	$trade_pkt[$data2->item_id] = $data2->pkt;
	$trade_qty[$data2->item_id] = $data2->qty;
	$trade_amt[$data2->item_id] = $data2->amt;
	}
	$sql2='select 
		i.finish_goods_code as fg,
		m.item_id as item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*a.unit_price) as amt,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_other_details m,sale_other_chalan a, item_info i 
		
		where (d.dealer_code="30019" or d.dealer_code="30005") and d.dealer_code=m.dealer_code and m.id=a.order_no  and  d.group_for="'.$_SESSION['user']['group'].'"  and m.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
	group by  m.item_id order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$sss_pcs[$data2->item_id] = $data2->pcs;
	$sss_pkt[$data2->item_id] = $data2->pkt;
	$sss_qty[$data2->item_id] = $data2->qty;
	$sss_amt[$data2->item_id] = $data2->amt;
	}

	
	break;
	
case 2:
		$report="Item Wise Chalan Brief Report";
	
	break;
	
	
case 401:
		$report="Item Wise Chalan Brief Report(Main Product)";
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}

$sql = 'select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*a.unit_price) as actual_price
		
from dealer_info d, sale_other_details m,sale_other_chalan a, item_info i 
where d.dealer_code=m.dealer_code and m.id=a.order_no 
and  d.group_for="'.$_SESSION['user']['group'].'" 
and a.item_id=i.item_id and i.flour_item_type=1
'.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
group by  a.item_id order by i.finish_goods_code';
	
break;	


case 402:
		$report="Item Wise Chalan Brief Report(By Product)";
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}

$sql = 'select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*a.unit_price) as actual_price
		
from dealer_info d, sale_other_details m,sale_other_chalan a, item_info i 
where d.dealer_code=m.dealer_code and m.id=a.order_no 
and  d.group_for="'.$_SESSION['user']['group'].'" 
and a.item_id=i.item_id and i.flour_item_type=3
'.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
group by  a.item_id order by i.finish_goods_code';
	
break;
	
case 2001:
		$report="Item Wise Chalan  Details Report (At A Glance)";
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		if(isset($depot_id)) 			{$con.=' and a.depot_id="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
		 
		$sql='select 
		i.finish_goods_code as fg,
		i.item_id,
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
		from dealer_info d, sale_other_details m,sale_other_chalan a, item_info i where d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  
	a.unit_price>0  and a.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.$pg_con.' 
	group by  a.item_id order by i.finish_goods_code';
	
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
		from dealer_info d, sale_other_details m,sale_other_chalan a, item_info i 
		
		where d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   
	a.item_id = 1096000100010312 and m.gift_on_item=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.$pg_con.' 
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
		i.finish_goods_code as fg,
		m.gift_on_item as item_id,
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
		from dealer_info d, sale_other_details m,sale_other_chalan a, item_info i 
		
		where m.gift_on_item=i.item_id and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   
	a.unit_price = 0 and m.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.$pg_con.' 
	group by  m.gift_on_item order by i.finish_goods_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$ditem[$data2->item_id] = $data2->d_price*$data2->qty;
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
		if(i.d_price>0,i.d_price,i.f_price) price,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_unit*i.d_price) as DP,
		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,
		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,
		
		sum(a.total_unit*a.unit_price) as actual_price
		from dealer_info d, sale_other_details m,sale_other_chalan a, item_info i 
		
		where m.gift_on_item!=i.item_id and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   
	a.unit_price = 0 and m.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.$pg_con.' 
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
header("Location:chalan_view.php?v_no=".$_REQUEST['chalan_no']);
	break;
	case 5:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 
$report="Other Order Brief Report (Region Wise)";
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
sale_other_master m,sale_other_details o, item_info i,dealer_info d
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
sale_other_master m,dealer_info d  , warehouse w
where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
		
		case 11:
		$report="Daily Collection &amp; Order Summary";
		
$sql="select m.do_no, m.do_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_other_details where do_no=m.do_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from 
sale_other_master m,dealer_info d  , warehouse w 
where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
				case 13:
		$report="Daily Collection Summary(EXT)";
		
$sql="select m.do_no,m.do_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 
sale_other_master m,dealer_info d  , warehouse w
where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
    case 111:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$report="Corporate Chalan Summary Brief";
	break;
	    case 112:
	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
$report="SuperShop Chalan Summary Brief";
	break;
	
	    case 1004:
		$report="Warehouse Stock Position Report(Closing)";
		break;
		
		case 1006:
		$report="Warehouse Stock Position Report(Promotion)";
		break;
		case 1005:
		$report="Finish Goods Demand vs Receive Report";
		break;
		case 191:
$report="Party Wise Delivery Chalan  Report (At A Glance)";
break;
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
if($_POST['report']==1004) 
{
			if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
			elseif(isset($item_id)) 			{$item_sub_con=' and i.item_id='.$item_id;} 
			
			if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 
			
			if(isset($t_date)) 
			{$to_date=$t_date; $fr_date=$f_date; $date_con=' and ji_date <="'.$to_date.'"';}
//	$w3[][] = oitem('3',$date_con);
//	$w6 = oitem('6',$date_con);
//	$w9 = oitem('9',$date_con);
//	$w7 = oitem('7',$date_con);
//	$w8 = oitem('8',$date_con);
//	$w10 = oitem('10',$date_con);
//	$w54 = oitem('54',$date_con);

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
$sql='select distinct i.item_id,i.unit_name,i.brand_category_type,i.item_name,"Finished Goods",i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 
from item_info i where i.finish_goods_code!=2000 and i.finish_goods_code!=2001 and i.finish_goods_code!=2002 and i.finish_goods_code>0 and i.finish_goods_code not between 5000 and 6000 and i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' and i.item_brand != "" and i.status="Active" order by i.brand_category_type,i.brand_category,i.item_brand';
		   
$query =db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="10"><div class="header"><h1>Sajeeb Group</h1><h2><?=$report?></h2>
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
	$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore + $gajipur;	   
	
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
	<td style="text-align:right"><?=(int)$total?>&nbsp;</td>
</tr>
<?
}
		
?>
</tbody></table>
<?
}

elseif($_REQUEST['report']==191) 
{
if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and dl.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

$sql="select m.do_no,m.do_date,d.dealer_code,d.dealer_name_e as dealer_name,w.warehouse_name as depot,d.product_group as grp, m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details,d.dealer_code,sum(dl.total_amt) as dp_t from 
sale_other_master m,dealer_info d  , warehouse w, sale_other_chalan dl
where w.group_for='".$_SESSION['user']['group']."' and dl.do_no=m.do_no and m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con." group by d.dealer_code order by d.dealer_name_e";
$query = db_query($sql);

echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr>
<th>S/L</th>
<th>Dealer Code</th>
<th>Dealer Name</th>
<th>Depot</th>
<th>Rcv Amt</th>
<th>Sales Total</th>
</tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;

$dp_t = $dp_t+$data->dp_t;
$rcv_t += $data->rcv_amt;
?>
<tr>
<td><?=$s?></td>
<td><?=$data->dealer_code?></td>
<td><?=$data->dealer_name?></td>
<td><?=$data->depot?></td>
<td style="text-align:right"><?=$data->rcv_amt?></td>
<td><?=number_format($data->dp_t,2)?></td></tr>
<?
}
echo '<tr class="footer">
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td style="text-align:right">'.number_format($rcv_t,2).'</td>
<td>'.number_format($dp_t,2).'</td>
</tr></tbody></table>';
}



elseif($_POST['report']==10041004) 
{
db_query('delete from journal_stock where 1');
$stock_date = date('Y-m-d');
$date_con=' and ji_date <="'.$stock_date.'"';

	$sql="select sum(item_in-item_ex) as item_ex,item_id from journal_item where 1 ".$date_con." and warehouse_id ='3' and item_id like '109600010001%'  group by item_id";
	$res	 = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{$w3[$row->item_id] = $row->item_ex;}
	
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


	
	$dhaka = 	(int)($w3[$data->item_id]/$data->pack_size);
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
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="13"><div class="header"><h1>Sajeeb Group</h1><h2><?=$report?></h2>
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
elseif($_POST['report']==2){

if(isset($issue_type)) 	{$issue_type_con=' and a.issue_type="'.$issue_type.'"';} 
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
if($_SESSION['user']['depot']!=5){ $wcon=' and w.warehouse_id not in(5)';}

?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="9"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>
<tr>
<th>S/L</th>
<th>Fg</th>
<th>Item Name</th>
<th>Unit</th>
<th>Brand</th>
<th>Pack Size</th>
<th>Pkt</th>
<th>Pcs</th>
<th>Qty</th>
<th>Sale Amt</th>
</tr>
</thead><tbody>
<?
$sql = 'select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.item_brand as brand,
		i.pack_size,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,
		sum(a.total_amt) as amount
		
from sale_other_chalan a, item_info i, warehouse w

where a.item_id=i.item_id and a.depot_id=w.warehouse_id and w.group_for="'.$_SESSION['user']['group'].'" 
and a.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.$issue_type_con.$wcon.' 
group by  a.item_id order by i.finish_goods_code';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$gamount += $data->amount;
?>
<tr><td><?=++$s?></td>
<td><?=$data->fg?></td>
<td><?=$data->item_name?></td>
<td><?=$data->unit?></td>
<td><?=$data->brand?></td>
<td><?=$data->pack_size?></td>
<td><?=$data->pkt?></td>
<td><?=$data->pcs?></td>
<td><?=$data->qty?></td>
<td style="text-align:right"><?=number_format($data->amount,2)?></td>
<?
}
?>
<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td style="text-align:right"><?=number_format($gamount,2)?></td>
</tr></tbody></table>
<?
}





elseif($_POST['report']==201) 
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="6"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>

<tr><th rowspan="2">S/L</th><th rowspan="2">Fg</th>
<th rowspan="2">Item Name</th><th rowspan="2">Unit</th>
<th rowspan="2">Brand</th>
  <th rowspan="2">PS</th><th colspan="4">Trade Sales</th>
  <th colspan="4">Sister Concern</th>
  <th colspan="4">Sample/Gift</th>
  <th colspan="3">Total Sales</th>
</tr>
<tr>
  <th>Bag</th>
  <th>Pcs</th>
  <th>AvR</th>
  <th>Amt</th>
  <th>Bag</th>
  <th>Pcs</th>
  <th>AvR</th>
  <th>Amt</th>
  <th>Bag</th>
  <th>Pcs</th>
  <th>AvR</th>
  <th>Amt</th>
  <th>Bag</th>
  <th>Pcs</th>
  <th>Amt</th>
</tr>

</thead><tbody>
<?
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$trade_total = $trade_total + $trade_amt[$data->item_id];
$sc_total = $sc_total + ($sc_amt[$data->item_id] + $sss_amt[$data->item_id]);
?>
<tr><td><?=++$s?></td><td><?=$data->fg?></td><td><?=$data->item_name?></td><td><?=$data->unit?></td><td><?=$data->brand?></td><td><?=$data->pack_size?></td>
  <td style="text-align:right"><?=$trade_pkt[$data->item_id]?></td>
  <td style="text-align:right"><?=$trade_pcs[$data->item_id]?></td>
  <td style="text-align:right"><?=number_format(@($trade_amt[$data->item_id]/$trade_qty[$data->item_id]),2)?></td>
  <td style="text-align:right"><?=number_format($trade_amt[$data->item_id],2)?></td>
  <td style="text-align:right"><?=($sc_pkt[$data->item_id]+$sss_pkt[$data->item_id])?></td>
  <td style="text-align:right"><?=($sc_pcs[$data->item_id]+$sss_pcs[$data->item_id])?></td>
  <td style="text-align:right"><?=number_format(@(($sc_amt[$data->item_id] + $sss_amt[$data->item_id])/($sc_qty[$data->item_id] + $sss_qty[$data->item_id])),2)?></td>
  <td style="text-align:right"><?=number_format(($sc_amt[$data->item_id] + $sss_amt[$data->item_id]),2)?></td>
  <td style="text-align:right"><?=($sg_pkt[$data->item_id])?></td>
  <td style="text-align:right"><?=($sg_pcs[$data->item_id])?></td>
  <td style="text-align:right"><?=number_format(@($sg_amt[$data->item_id]/$sg_qty[$data->item_id]),2);?></td>
  <td style="text-align:right"><?=number_format($sg_amt[$data->item_id],2);?></td>
  <td style="text-align:right"><? $total_bag = $trade_pkt[$data->item_id]+($sc_pkt[$data->item_id]+$sss_pkt[$data->item_id]) + $sg_pkt[$data->item_id]; ?><?=$total_bag?></td>
  <td style="text-align:right"><?=($trade_pcs[$data->item_id]+($sc_pcs[$data->item_id]+$sss_pcs[$data->item_id]));?></td>
  
  <td style="text-align:right"><? $total_amt = $trade_amt[$data->item_id]+ $sc_amt[$data->item_id] + $sss_amt[$data->item_id] + $sg_amt[$data->item_id]; ?><?=number_format($total_amt,2);?></td>
</tr> 
<?
$total_ts_bag = $total_ts_bag +  $trade_pkt[$data->item_id];
$total_sc_bag = $total_sc_bag + ($sc_pkt[$data->item_id]+$sss_pkt[$data->item_id]);
$total_sg_bag = $total_sg_bag + ($sg_pkt[$data->item_id]);
$total_sg_total = $total_sg_total + $sg_amt[$data->item_id];

$total_total_amt = $total_total_amt + $total_amt;
$total_total_bag = $total_total_bag + $total_bag;
}
?>
<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right"><?=number_format($total_ts_bag,2);?></td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right"><?=number_format($trade_total,2);?></td>
  <td><div align="right"><span style="text-align:right"><?=number_format($total_sc_bag,0)?></span></div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><span style="text-align:right"><?=number_format($sc_total,2)?></span></td>
  <td style="text-align:right"><?=number_format($total_sg_bag,0)?></td>
    
    <td style="text-align:right">&nbsp;</td>
  <td style="text-align:right">&nbsp;</td>

  <td style="text-align:right"><?=number_format($total_sg_total,2)?></td>

<td style="text-align:right"><?=number_format($total_total_bag,0)?></td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right"><?=number_format($total_total_amt,2)?></td>
</tr></tbody></table>
<?
}
elseif($_POST['report']==2001) 
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="7"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?>222</div></td></tr>

<tr><th rowspan="2">S/L</th>
<th rowspan="2">CODE</th>
<th rowspan="2">Product Name</th>
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
<tr><td><?=++$s?></td><td><?=$data->fg?></td><td><?=$data->item_name?></td><td><?=$data->pkt?></td><td><?=$data->pcs?></td><td><span style="text-align:right">
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
<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="5" style="text-align:right"><?=number_format((($total_actual_price)),2)?></td><td><span style="text-align:right">
  <?=number_format((($free_actual_price)),2)?>
</span></td>
  <td><span style="text-align:right"><?=number_format((($distount_actual_price)),2)?></span></td>
  <td><span style="text-align:right"><?=number_format((($cp_actual_price)),2)?></span></td>
  <td><span style="text-align:right"><?=number_format((($total_trade_amount)),2)?></span></td>
  <td style="text-align:right"><?=number_format((@($total_trade_amount/$total_actual_price)*100),2)?></td></tr></tbody></table>
<?
}
elseif($_POST['report']==101){

 
$sqld="select c.chalan_no,m.do_no,m.do_date,c.driver_name as serial_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,
w.warehouse_name as depot,d.product_group as grp,sum(total_amt) as total_amt 

from sale_other_master m,sale_other_chalan c,dealer_info d, warehouse w
where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot 
and d.depot=".$_SESSION['user']['depot']."
".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." 
group by chalan_no order by c.chalan_no";
$query = db_query($sqld);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="8"><?=$str?></td></tr><tr><th>S/L</th><th>Do Date</th>
  <th>Do No</th>
  <th>Chalan Date</th><th>Chalan No</th><th>Serial No</th><th>Dealer Name</th><th>Depot</th><th>Grp</th><th>DP Total</th><th>Discount</th><th>Sale Total</th></tr></thead>
<tbody>
<? 

while($data=mysqli_fetch_object($query)){$s++;
//$sqld = 'select sum(total_amt) from sale_other_chalan  where chalan_no='.$data->chalan_no;
//$info = mysqli_fetch_row(db_query($sqld));
//$sqld1 = 'select sum(total_amt) from sale_other_chalan  where chalan_no='.$data->chalan_no.' and total_amt>0';

$sqld1 = 'select sum(total_amt) from sale_other_chalan  where chalan_no='.$data->chalan_no.' and unit_price<0';
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
<td><a href="chalan_view2.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
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

if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';} 
if(isset($dealer_code)) 		{$dealer_con=' and m.dealer_code="'.$dealer_code.'"';} 
if(isset($issue_type)) 			{$issue_type_con=' and m.issue_type="'.$issue_type.'"';} 

$sqld1 = "select sum(total_amt) as total_amt,chalan_no 
from sale_other_master m,sale_other_chalan c,warehouse w
where  m.do_no=c.do_no 
and w.warehouse_id=c.depot_id 
and c.unit_price<0 and  w.group_for='".$_SESSION['user']['group']."' 
".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con.$issue_type_con." 
group by chalan_no order by c.chalan_no";

$query1 = db_query($sqld1);
while($info1 = mysqli_fetch_row($query1)){
$discount[$info1[1]] = $info1[0];
}


$sqls="select c.chalan_no,m.do_no,m.issue_type as type,m.do_date,c.driver_name as serial_no,c.chalan_date,
m.dealer_code as code,m.remarks as note,m.delivery_address,w.warehouse_name as depot,sum(c.total_amt) as total_amt 

from sale_other_master m, sale_other_chalan c, warehouse w

where m.do_no=c.do_no 
and w.warehouse_id=c.depot_id 
and w.group_for='".$_SESSION['user']['group']."'
".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con.$issue_type_con." 
group by chalan_no order by c.chalan_no";

$query = db_query($sqls);
?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr>
<td style="border:0px;" colspan="9"><?=$str?></td>
</tr>

<tr>
<th>S/L-1</th>
<th>Chalan No</th>
<th>Do No</th>
<th>Do Date</th>
<th>Serial No</th>
<th>Chalan Date</th>
<th>Type</th>
<th>Code</th>
<th>Dealer/Staff Name</th>
<th>Staff Company </th>
<th>Note</th>
<th>Depot</th>
<th>Sales Total</th>
<th>Dis</th>
</tr>
</thead>
<tbody>
<?
while($data=mysqli_fetch_object($query)){$s++;
//$sqld = 'select sum(total_amt) from sale_other_chalan  where chalan_no='.$data->chalan_no;
//$info = mysqli_fetch_row(db_query($sqld));

$dis = $discount[$data->chalan_no];
$sales = $data->total_amt;
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t + $dis;
$tp_t = $tp_t + ($sales-$dis);
?>
<tr>
<td><?=$s?></td>
<td>
<?php
if($data->type==''){
?>
<a href="../../../warehouse_mod/pages/bs/chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a>
<? } else { ?>
<a href="../../../warehouse_mod/pages/os/chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a>
<? } ?></td>
<td><?=$data->do_no?></td>
<td><?=$data->do_date?></td>
<td><?=$data->serial_no?></td>
<td><?=$data->chalan_date?></td>
<td><?=$data->type?></td>
<td><?=$data->code?></td>
<td><? 
$dealer_name=find_a_field_sql('select dealer_name_e as dealer_name from dealer_info where dealer_code="'.$data->code.'"');
$staff=find_all_field_sql('select * from personnel_basic_info where PBI_ID="'.$data->code.'"');
if($data->type!=='StaffSales'){echo $dealer_name;}elseif($data->type=='StaffSales'){ echo $staff->PBI_NAME;}?></td>

<td><? if($data->type=='StaffSales'){ echo find_a_field_sql('select c.group_name from user_group c,personnel_basic_info p where c.id=p.PBI_ORG 
and p.PBI_ID="'.$data->code.'"');}?></td>
<td><?=$data->delivery_address?> # <?=$data->note?></td>
<td><?=$data->depot?></td>
<td><?=number_format(($sales-$dis),2);?></td>
<td><?=number_format(($dis*(-1)),2);?></td>
</tr>
<?
}
?><tr class="footer">
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><?=number_format(($tp_t),2)?></td>
<td><?=number_format(((-1)*$dp_t),2)?></td>

</tr></tbody></table>
<?
}

elseif($_POST['report']==10001) 
{
if(isset($depot_id)) 	{$depot_con=' and c.depot_id="'.$depot_id.'"';} 
$sqls="select c.chalan_no,m.do_no,m.do_date,c.driver_name as serial_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp,total_unit,total_unit*i.d_price as total_amt, total_amt as sales_amt, i.pack_size from 
sale_other_master m,sale_other_chalan c,dealer_info d  , warehouse w, item_info i
where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and c.item_id=i.item_id and c.item_id='".$item_id."' ".$depot_con.$date_con.$dealer_con.$dealer_type_con." order by c.chalan_no";

$query = db_query($sqls);
?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="8"><?=$str?></td></tr><tr><th>S/Lsss</th><th>Chalan No</th>
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
elseif($_POST['report']==10002) 
{
if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';} 
$sqls="select c.chalan_no,m.do_no,m.do_date,c.driver_name as serial_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp,total_unit,total_unit*i.d_price as total_amt, total_amt as sales_amt, i.pack_size from 
sale_other_master m,sale_other_chalan c,dealer_info d  , warehouse w, item_info i
where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and c.item_id=i.item_id and c.item_id='".$item_id."' ".$depot_con.$date_con.$dealer_con.$dealer_type_con." order by c.chalan_no";

$query = db_query($sqls);
?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="8"><?=$str?></td></tr><tr><th>S/Lsss</th><th>Chalan No</th>
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
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="9"><div class="header"><h1>Sajeeb Group</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date-<?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
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

	$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore + $gajipur;	      
	
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
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_other_details c,dealer_info d,sale_other_chalan ch where ch.order_no=c.id and c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
${'A'.$data->do_date} = $data->total_amt;
}
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_other_details c,dealer_info d,sale_other_chalan ch where ch.order_no=c.id and  c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
${'B'.$data->do_date} = $data->total_amt;
}
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_other_details c,dealer_info d ,sale_other_chalan ch where ch.order_no=c.id and  c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
${'C'.$data->do_date} = $data->total_amt;
}
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_other_details c,dealer_info d ,sale_other_chalan ch where ch.order_no=c.id and  c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){${'D'.$data->do_date} = $data->total_amt;}
$sql = "select sum(ch.total_amt) as total_amt,c.do_date from sale_other_details c,dealer_info d ,sale_other_chalan ch where ch.order_no=c.id and  c.do_date between '".$f_date."' and '".$t_date."' and ch.chalan_date<='".$cut_date."' and c.dealer_code=d.dealer_code and (d.dealer_type='Corporate' or d.dealer_type='SuperShop' or (d.dealer_type='Distributor' AND product_group='M')) and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){${'X'.$data->do_date} = $data->total_amt;}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">Date</span></td>
    <td bgcolor="#333333"><span class="style3">Group-A</span></td>
    <td bgcolor="#333333"><span class="style3">Group-B</span></td>
    <td bgcolor="#333333"><span class="style3">Group-C</span></td>
    <td bgcolor="#333333"><span class="style3">Group-D</span></td>
    <td width="1" bgcolor="#333333"><div align="right"><strong><span class="style5">Total Sales<br />
      (A+B+C+D)</span></strong></div></td>
    <td width="1" bgcolor="#333333"><span class="style3">Mordern Trade</span></td>
    <td width="1" bgcolor="#333333"><span class="style3">ALL Sales</span></td>
  </tr>
<? foreach ( $period as $dt ){ $today_date = $dt->format("Y-m-d");
$day_total = ${'A'.$today_date} + ${'B'.$today_date} + ${'C'.$today_date} + ${'D'.$today_date};
$do_all = ${'A'.$today_date} + ${'B'.$today_date} + ${'C'.$today_date} + ${'D'.$today_date} + ${'X'.$today_date};
$do_total = $do_total + $do_all;
$mon_total = $mon_total + ${'A'.$today_date} + ${'B'.$today_date} + ${'C'.$today_date} + ${'D'.$today_date};
$A_total = $A_total + ${'A'.$today_date};
$B_total = $B_total + ${'B'.$today_date};
$C_total = $C_total + ${'C'.$today_date};
$D_total = $D_total + ${'D'.$today_date};
$X_total = $X_total + ${'X'.$today_date};
?>
  <tr bgcolor="#<?=(($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$today_date;?></td>
    <td><div align="right"><?=number_format(${'A'.$today_date},2);?></div></td>
    <td><div align="right"><?=number_format(${'B'.$today_date},2);?></div></td>
    <td><div align="right"><?=number_format(${'C'.$today_date},2);?></div></td>
    <td><div align="right"><?=number_format(${'D'.$today_date},2);?></div></td>
    <td bgcolor="#FFFF99"><div align="right"><?=number_format($day_total,2);?></div></td>
    <td><div align="right"><?=number_format(${'X'.$today_date},2);?></div></td>
    <td bgcolor="#FFFF99"><div align="right"><?=number_format($do_all,2);?></div></td>
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
elseif($_POST['report']==111) 
{
$sql="select distinct c.chalan_no , m.do_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot from 
sale_other_master m,sale_other_chalan c,dealer_info d  , warehouse w
where m.status in ('CHECKED','COMPLETED') and m.do_no=c.do_no  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and d.dealer_type = 'Corporate'".$depot_con.$date_con.$pg_con.$dealer_con." order by m.do_date,m.do_no";
$query = db_query($sql);
echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Chalan No</th><th>Do No</th><th>Chalan Date</th><th>Dealer Name</th><th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th></tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;
$sqld = 'select sum(total_amt) from sale_other_chalan  where chalan_no='.$data->chalan_no;
$info = mysqli_fetch_row(db_query($sqld));
$dp_t = $dp_t+$info[0];
$dis = find_a_field('sale_other_master','sp_discount','do_no="'.$data->do_no.'"');
$tod = ($info[0]*$dis)/100;
$tot = $info[0]-($info[0]*$dis)/100;
$tod_t = $tod_t + $tod;
$tot_t = $tot_t + $tot;
?>
<tr><td><?=$s?></td><td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td><td><?=$data->do_no?></td><td><?=$data->chalan_date?></td><td><?=$data->dealer_name?></td><td><?=$data->depot?></td><td><?=$info[0]?></td><td><?=$tod?></td><td><?=$tot?></td></tr>
<?
}
echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tod_t,2).'</td><td>'.number_format($tot_t,2).'</td></tr></tbody></table>';

}
elseif($_POST['report']==112) 
{
$sql="select c.chalan_no , m.do_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,sum(total_amt) as total_amt from 
sale_other_master m,sale_other_chalan c,dealer_info d  , warehouse w
where m.status in ('CHECKED','COMPLETED') and m.do_no=c.do_no  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and d.dealer_type = 'SuperShop'".$depot_con.$date_con.$pg_con.$dealer_con." group by chalan_no order by chalan_no";
$query = db_query($sql);
echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Chalan No</th><th>Do No</th><th>Chalan Date</th><th>Dealer Name</th><th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th></tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;
$sqld1 = 'select sum(total_amt) from sale_other_chalan  where chalan_no='.$data->chalan_no.' and total_amt>0';
$info1 = mysqli_fetch_row(db_query($sqld1));
$info[0] = $data->total_amt;

$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$info[0];
$tp_t = $tp_t+$info1[0];
?>
<tr><td><?=$s?></td><td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td><td><?=$data->do_no?></td><td><?=$data->chalan_date?></td><td><?=$data->dealer_name?></td><td><?=$data->depot?></td><td><?=number_format(($info1[0]),2)?></td><td><?=number_format(($info[0]-$info1[0]),2)?></td><td><?=number_format($info[0],2)?></td></tr>
<?
}
?><tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?=number_format(($tp_t),2)?></td><td><?=number_format(($dp_t-$tp_t),2)?></td><td><?=number_format($dp_t,2)?></td></tr></tbody></table><? 

}
elseif($_POST['report']==3) 
{
$sql2 	= "select distinct o.do_no,c.chalan_no as chalan_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,c.chalan_date as do_date,d.address_e,d.mobile_no,d.product_group from 
sale_other_master m,sale_other_details o,sale_other_chalan c, item_info i,dealer_info d , warehouse w
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
sale_other_master m,sale_other_details o,sale_other_chalan c, item_info i,dealer_info d , warehouse w
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
$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_other_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_other_details where do_no=m.do_no)  as TP_Total from 
sale_other_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_other_master m,dealer_info d  , warehouse w,area a,sale_other_details s
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
sale_other_master m,sale_other_details o, item_info i, warehouse w, dealer_info d, area a
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' group by i.finish_goods_code';

$sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total
from 
sale_other_master m,sale_other_details o, item_info i, warehouse w, dealer_info d, area a
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
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_other_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_other_details where do_no=m.do_no)  as TP_Total from 
sale_other_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." and a.AREA_CODE=".$area_id." ".$date_con.$pg_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_other_master m,dealer_info d  , warehouse w,area a,sale_other_details s
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.AREA_CODE=".$area_id." and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;
}
else
{
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_other_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_other_details where do_no=m.do_no)  as TP_Total from 
sale_other_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_other_master m,dealer_info d  , warehouse w,area a,sale_other_details s
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
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?></div>
</body>
</html>