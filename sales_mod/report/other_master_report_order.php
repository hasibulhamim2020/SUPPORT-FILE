<?

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

date_default_timezone_set('Asia/Dhaka');

if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)
{
	if((strlen($_REQUEST['t_date'])==10))
	{
		$t_date=$_REQUEST['t_date'];
		$f_date=$_REQUEST['f_date'];
	}
	
if($_REQUEST['product_group']!='')  $product_group=$_REQUEST['product_group'];
if($_REQUEST['item_brand']!='') 	$item_brand=$_REQUEST['item_brand'];
if($_REQUEST['item_id']>0) 		    $item_id=$_REQUEST['item_id'];
if($_REQUEST['dealer_code']>0) 	    $dealer_code=$_REQUEST['dealer_code'];
if($_REQUEST['dealer_type']!='') 	$dealer_type=$_REQUEST['dealer_type'];

if($_REQUEST['status']!='') 		$status=$_REQUEST['status'];
if($_REQUEST['do_no']!='') 		    $do_no=$_REQUEST['do_no'];
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
if($product_group=='ABCD')
$pg_con=' and d.product_group!="M" and d.product_group!=""';
else
$pg_con=' and d.product_group="'.$product_group.'"';
} 
if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dtype_con=' and d.dealer_type="Distributor"';} else {$dtype_con=' and d.dealer_type!="Distributor"';}}
if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';} else {$dealer_type_con=' and d.dealer_type!="Distributor"';}} 

if(isset($dealer_code)) 		{$dealer_con=' and m.dealer_code='.$dealer_code;} 
if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 
//if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
//if(isset($zone_id)) 			{$zone_con=' and a.buyer_id='.$zone_id;}
//if(isset($region_id)) 		{$region_con=' and d.id='.$region_id;}
//if(isset($item_id)) 			{$item_con=' and b.item_id='.$item_id;} 
//if(isset($status)) 			{$status_con=' and a.status="'.$status.'"';} 
//if(isset($do_no)) 			{$do_no_con=' and a.do_no="'.$do_no.'"';} 
//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $chalan_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

switch ($_REQUEST['report']) {
    case 1:
	$report="Delivery Order Summary Brief";
	break;
    case 1999:
	$report="DO Report for Scratch Card";
	$product_group = 'A';
	break;
	
case 2001:
		$report="Item Wise Chalan  Details Report (At A Glance)";
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con .= ' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		if($_POST['cut_date']!='') 								$date_con .= ' and  a.chalan_date<="'.$_POST['cut_date'].'"'; 
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
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
		from dealer_info d, sale_do_details m,sale_other_chalan a, item_info i where d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  
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
		from dealer_info d, sale_do_details m,sale_other_chalan a, item_info i 
		
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
		from dealer_info d, sale_do_details m,sale_other_chalan a, item_info i 
		
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
		from dealer_info d, sale_do_details m,sale_other_chalan a, item_info i 
		
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
	
case 2002:
		$report="Last Year Vs This Year Item Wise Sales Report (Periodical)";
		if(isset($t_date)) {
		$to_date=$t_date; $fr_date=$f_date; 
		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));
		$yto_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($t_date));
		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';
		}
		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}
		if(isset($product_group)) 		{$pg_con=' and i.sales_item_type like "%'.$product_group.'%"';}
		
		$sql='select 
		i.finish_goods_code as fg,
		i.item_id,
		i.item_name,
		i.unit_name as unit,
		i.sales_item_type ,
		i.item_brand as brand,
		i.pack_size pkt
		from item_info i where  i.finish_goods_code>0 and i.status="Active" and i.item_brand!="Promotional" and finish_goods_code!=2000 and finish_goods_code!=2001 and finish_goods_code!=2002 and i.item_brand!="Memo" and finish_goods_code not between 9000 and 10000 and i.item_brand!=""  '.$item_brand_con.$pg_con.' 
	 order by i.finish_goods_code';
if(isset($area_id)) 		{$acon.=' and a.AREA_CODE="'.$area_id.'"';}
if(isset($zone_id)) 		{$acon.=' and z.ZONE_CODE="'.$zone_id.'"';}
if(isset($region_id)) 		{$acon.=' and b.BRANCH_ID="'.$region_id.'"';}
 
		$sql2='select 
		i.item_id,
		i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m,sale_other_chalan a, item_info i, area ar, branch b, zon z where ar.ZONE_ID=z.ZONE_CODE and d.area_code=ar.AREA_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  
	a.unit_price>0 and a.item_id=i.item_id '.$acon.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
	group by  a.item_id';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$this_year_sale_amt[$data2->item_id] = $data2->sale_price;
	$this_year_sale_qty[$data2->item_id] = $data2->qty;
	}

	
			$sql2='select 
		i.item_id,
		i.pack_size as pkt,
		sum(a.total_unit) mod i.pack_size as pcs,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m,sale_other_chalan a, item_info i, area ar, branch b, zon z where ar.ZONE_ID=z.ZONE_CODE and d.area_code=ar.AREA_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  
	a.unit_price>0 and a.item_id=i.item_id '.$acon.$con.$ydate_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
	group by  a.item_id';
	
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$last_year_sale_amt[$data2->item_id] = $data2->sale_price;
	$last_year_sale_qty[$data2->item_id] = $data2->qty;
	}
	break;
	
		case 2003:
		$report="Last Year Vs This Year Single Item Dealer Wise Sales Report (Periodical)";
		if(isset($t_date)) {
		$to_date=$t_date; $fr_date=$f_date; 
		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));
		$yto_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($t_date));
		
		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';
		}
		if(isset($product_group)) 			{$product_group_con.=' and d.product_group="'.$product_group.'"';}
		if(isset($depot_id)) 				{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 			{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		if(isset($dealer_type)) 			{$con.=' and d.dealer_type="'.$dealer_type.'"';}
		if(isset($item_id))		 			{$con.=' and a.item_id="'.$item_id.'"';}
		
if(isset($area_id)) 		{$acon.=' and a.AREA_CODE="'.$area_id.'"';}
if(isset($zone_id)) 		{$acon.=' and z.ZONE_CODE="'.$zone_id.'"';}
if(isset($region_id)) 		{$acon.=' and b.BRANCH_ID="'.$region_id.'"';}
		$sql='select 
		dealer_name_e dealer_name,
		dealer_code,
		AREA_NAME area_name,
		ZONE_NAME zone_name,
		BRANCH_NAME region_name
		from dealer_info d, area a, branch b, zon z where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=a.AREA_CODE  '.$product_group_con.$acon.' 
	    order by dealer_name_e';

		$sql2='select 
		d.dealer_code,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m, sale_other_chalan a, item_info i where 
		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  
	a.unit_price>0 '.$con.$date_con.$product_group_con.$item_con.' 
	group by  d.dealer_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$this_year_sale_amt[$data2->dealer_code] = $data2->sale_price;
	$this_year_sale_qty[$data2->dealer_code] = $data2->qty;
	$this_year_sale_pkt[$data2->dealer_code] = $data2->pkt;
	}
	$sql2='select 
		i.item_id,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m,sale_other_chalan a, item_info i where 
		d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  
	a.unit_price>0  and a.item_id=i.item_id '.$con.$ydate_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 
	group by  a.item_id';
	$sql2='select 
		d.dealer_code,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m, sale_other_chalan a, item_info i where 
		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  
	a.unit_price>0 '.$con.$ydate_con.$product_group_con.$item_con.' 
	group by  d.dealer_code';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$last_year_sale_amt[$data2->dealer_code] = $data2->sale_price;
	$last_year_sale_qty[$data2->dealer_code] = $data2->qty;
	$last_year_sale_pkt[$data2->dealer_code] = $data2->pkt;
	}
	break;
	
		case 20031:
		$report="Last Year Vs This Year Single Item Region Wise Sales Report (Periodical)";
		if(isset($t_date)) 
		{
		$to_date=$t_date; $fr_date=$f_date; 
		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));
		$yto_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($t_date));
		
		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';
		}
		if(isset($product_group)) 			{$product_group_con.=' and d.product_group="'.$product_group.'"';}
		if(isset($depot_id)) 				{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 			{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		if(isset($dealer_type)) 			{$con.=' and d.dealer_type="'.$dealer_type.'"';}
		if(isset($item_id))		 			{$con.=' and a.item_id="'.$item_id.'"';}
		
if(isset($area_id)) 		{$acon.=' and a.AREA_CODE="'.$area_id.'"';}
if(isset($zone_id)) 		{$acon.=' and z.ZONE_CODE="'.$zone_id.'"';}
if(isset($region_id)) 		{$acon.=' and b.BRANCH_ID="'.$region_id.'"';}
		$sql='select 

		BRANCH_NAME region_name,
		BRANCH_ID
		from dealer_info d, area a, branch b, zon z 
		where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=a.AREA_CODE  '.$product_group_con.$acon.' 
	    group by BRANCH_NAME';

		$sql2='select 
		BRANCH_ID,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m, sale_other_chalan a, item_info i, area ar, branch b, zon z 
		where 
		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  
		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 
	a.unit_price>0 '.$con.$date_con.$product_group_con.$item_con.' 
	group by BRANCH_NAME';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$this_year_sale_amt[$data2->BRANCH_ID] = $data2->sale_price;
	$this_year_sale_qty[$data2->BRANCH_ID] = $data2->qty;
	$this_year_sale_pkt[$data2->BRANCH_ID] = $data2->pkt;
	}

	$sql2='select 
		BRANCH_ID,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m, sale_other_chalan a, item_info i , area ar, branch b, zon z  where 
		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  
		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 
	a.unit_price>0 '.$con.$ydate_con.$product_group_con.$item_con.' 
	group by  BRANCH_NAME';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$last_year_sale_amt[$data2->BRANCH_ID] = $data2->sale_price;
	$last_year_sale_qty[$data2->BRANCH_ID] = $data2->qty;
	$last_year_sale_pkt[$data2->BRANCH_ID] = $data2->pkt;
	}
	break;
	
		case 20032:
		$report="Last Year Vs This Year Single Item Zone Wise Sales Report (Periodical)";
		if(isset($t_date)) 
		{
		$to_date=$t_date; $fr_date=$f_date; 
		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));
		$yto_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($t_date));
		
		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';
		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';
		}
		if(isset($product_group)) 			{$product_group_con.=' and d.product_group="'.$product_group.'"';}
		if(isset($depot_id)) 				{$con.=' and d.depot="'.$depot_id.'"';}
		if(isset($dealer_code)) 			{$con.=' and d.dealer_code="'.$dealer_code.'"';} 
		if(isset($dealer_type)) 			{$con.=' and d.dealer_type="'.$dealer_type.'"';}
		if(isset($item_id))		 			{$con.=' and a.item_id="'.$item_id.'"';}
		
if(isset($area_id)) 		{$acon.=' and a.AREA_CODE="'.$area_id.'"';}
if(isset($zone_id)) 		{$acon.=' and z.ZONE_CODE="'.$zone_id.'"';}
if(isset($region_id)) 		{$acon.=' and b.BRANCH_ID="'.$region_id.'"';}
		$sql='select 

		ZONE_NAME zone_name,BRANCH_NAME region_name,
		ZONE_CODE
		from dealer_info d, area a, branch b, zon z 
		where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=a.AREA_CODE  '.$product_group_con.$acon.' 
	    group by ZONE_CODE';

		$sql2='select 
		ZONE_CODE,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m, sale_other_chalan a, item_info i, area ar, branch b, zon z 
		where 
		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  
		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 
	a.unit_price>0 '.$con.$date_con.$product_group_con.$item_con.' 
	group by ZONE_CODE';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$this_year_sale_amt[$data2->ZONE_CODE] = $data2->sale_price;
	$this_year_sale_qty[$data2->ZONE_CODE] = $data2->qty;
	$this_year_sale_pkt[$data2->ZONE_CODE] = $data2->pkt;
	}

	$sql2='select 
		ZONE_CODE,
		sum(a.total_unit) div i.pack_size as pkt,
		sum(a.total_unit) qty,		
		sum(a.total_unit*a.unit_price) as sale_price
		from dealer_info d, sale_do_details m, sale_other_chalan a, item_info i , area ar, branch b, zon z  where 
		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  
		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 
	a.unit_price>0 '.$con.$ydate_con.$product_group_con.$item_con.' 
	group by  ZONE_CODE';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{
	$last_year_sale_amt[$data2->ZONE_CODE] = $data2->sale_price;
	$last_year_sale_qty[$data2->ZONE_CODE] = $data2->qty;
	$last_year_sale_pkt[$data2->ZONE_CODE] = $data2->pkt;
	}
	break;
    case 1991:

$report="Delivery Order Brief Report with Chalan Amount";
	break;
case 191:
$report="Delivery Order  Report (At A Glance)";
break;
	
    case 2:
		$report="Undelivered Do Details Report";

$sql = "select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,d.product_group as grp,w.warehouse_name as depot,concat(i.finish_goods_code,'- ',item_name) as item_name,o.pkt_unit as crt,o.dist_unit as pcs,o.total_amt,m.rcv_amt,m.payment_by as PB from 
sale_other_master m,sale_do_details o, item_info i,dealer_info d , warehouse w
where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$dealer_con.$item_brand_con;
	break;
	case 3:
$report="Undelivered Do Report Dealer Wise";
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($dealer_code)) {$dealer_con=' and m.dealer_code='.$dealer_code;} 
if(isset($item_id)){$item_con=' and i.item_id='.$item_id;} 
if(isset($depot_id)) {$depot_con=' and d.depot="'.$depot_id.'"';} 
	break;
	case 4:
	if($_REQUEST['do_no']>0)
header("Location:work_order_print.php?wo_id=".$_REQUEST['wo_id']);
	break;
	case 5:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 
$report="Delivery Order Brief Report (Region Wise)";
	break;
		case 6:
	if($_REQUEST['do_no']>0)
header("Location:../report/do_view.php?v_no=".$_REQUEST['do_no']);
	break;
	    case 7:
		$report="Item wise DO Report";
		
		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		 
		if(isset($depot_id)) 	{$depot_con=' and d.depot="'.$depot_id.'"';}
		
	$sql = "select 
		i.finish_goods_code as code, 
		i.item_name, i.item_brand, 
		
		floor(sum(o.total_unit)/o.pkt_size) as crt,
		mod(sum(o.total_unit),o.pkt_size) as pcs, 
		sum(o.total_amt)as amount
		
		from sale_other_master m,sale_other_details o, item_info i,dealer_info d,warehouse w
		
		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id = m.depot_id and w.warehouse_id = d.depot
		and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED')
		".$date_con.$item_con.$item_brand_con.$pg_con.$depot_con.' 
		and w.group_for = '.$_SESSION['user']['group'].'
		group by i.finish_goods_code
		order by code';
		
		break;
		
		case 701:
		$report="Item wise Undelivered DO Report(With Gift)";
		break;
		case 702:
		$report="Party wise Undelivered DO Report";
		break;
		case 7011:
		$report="Item wise Undelivered DO Report(Without Gift)";
		break;
		
		case 8:
if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 
$report="Dealer Performance Report";
	    case 9:
		$report="Item Report (Region + Zone)";
if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
 
		break;
			    case 14:
		$report="Item Report (Region)";
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
		
$sql="select m.do_no, m.do_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from 
sale_other_master m,dealer_info d  , warehouse w 
where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
				case 13:
		$report="Daily Collection Summary(EXT)";
		
$sql="select m.do_no,m.do_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 
sale_other_master m,dealer_info d  , warehouse w
where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";
		break;
		case 100:
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		 
		$report="Dealer Performance Report";
		break;
		case 101:
		$report="Four(4) Months Comparison Report(CRT)";
		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		 
		
		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
		floor(sum(o.total_unit)/o.pkt_size) as crt,
		mod(sum(o.total_unit),o.pkt_size) as pcs, 
		sum(o.total_amt)as dP,
		sum(o.total_unit*o.t_price)as tP
		from 
		sale_other_master m,sale_do_details o, item_info i,dealer_info d
		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';
		break;
				case 102:
		$report="Four(4) Months Comparison Report(TK)";
		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		 
		
		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
		floor(sum(o.total_unit)/o.pkt_size) as crt,
		mod(sum(o.total_unit),o.pkt_size) as pcs, 
		sum(o.total_amt)as dP,
		sum(o.total_unit*o.t_price)as tP
		from 
		sale_other_master m,sale_do_details o, item_info i,dealer_info d
		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';
		break;
						case 103:
		$report="Four(4) Months Regioanl Report(CTR)";
		
		if($_REQUEST['region_id']!='') {$region_id = $_REQUEST['region_id'];$region_name = find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id);}

		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
		floor(sum(o.total_unit)/o.pkt_size) as crt,
		mod(sum(o.total_unit),o.pkt_size) as pcs, 
		sum(o.total_amt)as dP,
		sum(o.total_unit*o.t_price)as tP
		from 
		sale_other_master m,sale_do_details o, item_info i,dealer_info d
		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';
		break;
						case 104:
		$report="Four(4) Months Regional Report(TK)";

		if($_REQUEST['region_id']!='') {$region_id = $_REQUEST['region_id'];$region_name = find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id);}
		
		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
		floor(sum(o.total_unit)/o.pkt_size) as crt,
		mod(sum(o.total_unit),o.pkt_size) as pcs, 
		sum(o.total_amt)as dP,
		sum(o.total_unit*o.t_price)as tP
		from 
		sale_other_master m,sale_do_details o, item_info i,dealer_info d
		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';
		break;				case 105:
		$report="Four(4) Months Zonal Report(CTR)";

		if($_REQUEST['zone_id']!='') {$zone_id = $_REQUEST['zone_id'];$zone_name = find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id);}

		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
		floor(sum(o.total_unit)/o.pkt_size) as crt,
		mod(sum(o.total_unit),o.pkt_size) as pcs, 
		sum(o.total_amt)as dP,
		sum(o.total_unit*o.t_price)as tP
		from 
		sale_other_master m,sale_do_details o, item_info i,dealer_info d
		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';
		break;
						case 106:
		$report="Four(4) Months Area Report(TK)";

		
		if($_REQUEST['zone_id']!='') {$zone_id = $_REQUEST['zone_id'];$zone_name = find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id);}
				
		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
		floor(sum(o.total_unit)/o.pkt_size) as crt,
		mod(sum(o.total_unit),o.pkt_size) as pcs, 
		sum(o.total_amt)as dP,
		sum(o.total_unit*o.t_price)as tP
		from 
		sale_other_master m,sale_do_details o, item_info i,dealer_info d
		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';
		break;
		
								case 107:
		$report="Yearly Regional Sales Report(TK)";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

for($i=12;$i>0;$i--)
{
	$m = $t_array[1]-($i-1);
	$t_stampq = strtotime(date('Y-m-15',strtotime($t_date)))-(60*60*24*30*($i-1));
	${'f_mos'.$i} = date('Y-m-15',$t_stampq);
	${'f_mons'.$i} = date('Y-m-01',$t_stampq);
	${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
$f_date=${'f_mons'.$i};

		break;
case 108:
$report="Yearly Regional Sales Report(Per Item)(CTN)";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
		break;
case 109:
$report="Yearly Regional Sales Report(Per Item)(TK)";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
break;									



case 110:
$report="Yearly Zone Wise Sales Report(Per Item)(Tk)";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
break;
case 111:
$report="Yearly Zone Wise Sales Report(Per Item)(CTN)";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
break;
case 112:
$report="Yearly Zone Wise Sales Report(Per Item)(Tk)";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
break;
case 1130:
$report="Corporate Party Wise Sales Report YEARLY";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);
$dealer_type = 'Corporate';
unset($to_date);
for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
break;
case 11301:
$report="SuperShop Party Wise Sales Report YEARLY";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);
$dealer_type = 'SuperShop';
unset($to_date);
for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
break;

case 113:
$report="Yearly Dealer Wise Sales Report(Per Item)(Tk)";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
break;

case 114:
$report="Yearly Dealer Wise Sales Report(Per Item)(CTN)";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
break;

case 115:
$report="Yearly Dealer Wise Sales Report(Per Item)(Tk)";
if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

for($i=12;$i>0;$i--)
{
$m = $t_array[1]-($i-1);
$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));

${'f_mons'.$i} = date('Y-m-01',$t_stampq);
${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);
}
break;
case 116:
$report="Single Item Sales Report(Zone Wise)";

break;
case 1992:
$report="Sales Statement(As Per DO)";

break;

case 2000:
$report="DO Summery Report Region Wise";

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
    <style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
.style5 {color: #FFFFFF}
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
		if(isset($_SESSION['user']['group'])) 
		$str 	.= '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($dealer_code)) 
		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';
		if(isset($depot_id)) 
		$str 	.= '<h2>Depot Name : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id).'</h2>';
		if(isset($item_brand)) 
		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';
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



if($_REQUEST['report']==1) 
{
$con.=' and w.group_for="'.$_SESSION['user']['group'].'"';

$sql="select m.do_no,m.do_date,m.entry_at ,m.entry_time,m.remarks as dealer_name,w.warehouse_name as depot,
m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details ,m.issue_type

from sale_other_master m,warehouse w
where m.status in ('CHECKED','COMPLETED') 
and w.warehouse_id=m.depot_id
".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con.$con." 
order by m.issue_type,m.do_date";
$query = db_query($sql);
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr>
<td style="border:0px;" colspan="9"><?=$str?></td></tr>
<tr><th>S/L-45</th>
<th>Do No</th>
<th>Do Date</th><th>Confirm At</th>
<th>Entry At</th>
<th>Dealer Name</th>
<th>Type</th>
<th>Depot</th>
<th>Grp</th>
<th>Rcv Amt</th>
<th>Payment Details</th>
<th>DO Total</th></tr></thead>
<tbody>

<?
while($data=mysqli_fetch_object($query)){$s++;
$sqld = 'select sum(total_amt),sum(t_price*total_unit) from sale_other_details where do_no='.$data->do_no;
$info = mysqli_fetch_row(db_query($sqld));
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$info[0];
$tp_t = $tp_t+$info[1];
?>


<tr><td><?=$s?></td>
<td><?=$data->do_no?></td>
<td><?=$data->do_date?></td>
<td><?=$data->entry_at?></td>
<td><?=$data->entry_time?></td>
<td><?=$data->dealer_name?></td>
<td><?=$data->issue_type?></td>
<td><?=$data->depot?></td>
<td><?=$data->grp?></td>
<td style="text-align:right"><?=$data->rcv_amt?></td>
<td><?=$data->Payment_Details?></td>
<td><?=$info[0]?></td></tr>
<?
}
?>
<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right">'.number_format($rcv_t,2).'</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td></tr></tbody></table>

<?
}



elseif($_REQUEST['report']==1999) 
{
if(isset($area_id)) 		{$acon.=' and a.AREA_CODE="'.$area_id.'"';}
if(isset($zone_id)) 		{$acon.=' and z.ZONE_CODE="'.$zone_id.'"';}
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,AREA_NAME as area,ZONE_NAME zone,w.warehouse_name as depot, sum(i.t_price*sd.total_unit) do_amt from 
sale_other_master m,dealer_info d  , warehouse w,area a,sale_do_details sd,item_info i, zon z
where a.ZONE_ID=z.ZONE_CODE and m.status in ('CHECKED','COMPLETED') and a.AREA_CODE=d.area_code and m.do_no=sd.do_no and sd.item_id=i.item_id and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.finish_goods_code in (102 ,105 ,106 ,109 ,120 ,121 ,123 ,124 ,126 ,127 ,128 ,129 ,130 ,137 ,138 ,139 ,140 ,141 ,142 ,143)".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con.$acon." group by d.dealer_code order by d.dealer_name_e";
$query = db_query($sql);
echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Dealer Name</th><th>Zone</th><th>Area</th><th>Depot</th><th>TP Amt</th><th>80%-TP</th><th>SC QTY</th></tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;
//$sqld = 'select sum(total_amt),sum(t_price*total_unit) from sale_do_details where do_no='.$data->do_no;
//$info = mysqli_fetch_row(db_query($sqld));
$do_tot = $do_tot+$data->do_amt;
$do_80  = (int)($data->do_amt*.8);
$do_80t = $do_80t+$do_80;
$do_sc  = (int)($do_80*.001);
$do_sct = $do_sct+$do_sc;
?>
<tr><td><?=$s?></td><td><?=$data->dealer_name?></td><td><?=$data->zone?></td><td><?=$data->area?></td><td><?=$data->depot?></td><td style="text-align:right"><?=$data->do_amt?></td><td style="text-align:right"><?=$do_80?></td><td style="text-align:right"><?=$do_sc?></td></tr>
<?
}
echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right">'.number_format($do_tot,2).'</td><td style="text-align:right">'.number_format($do_80t,2).'</td><td style="text-align:right">'.number_format($do_sct,2).'</td></tr></tbody></table>';
}
elseif($_REQUEST['report']==1991) 
{
 	
if((strlen($_REQUEST['cut_date'])==10)) $cut_date=$_REQUEST['cut_date'];
if(isset($cut_date)) 					{$cut_date_con=' and c.chalan_date <="'.$cut_date.'"';}

$sqld = 'select m.do_no, sum(c.total_amt) as ch_amt from sale_other_chalan c, sale_other_master m where c.unit_price>0 and m.do_no=c.do_no '.$date_con.$cut_date_con.' group by m.do_no';
$queryd = db_query($sqld);
while($info = mysqli_fetch_object($queryd)){
$do_ch_amt[$info->do_no] = $info->ch_amt;
}

$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp, sum(ds.total_amt) as do_amt,m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details from 
sale_other_master m,dealer_info d  , warehouse w,sale_do_details ds
where m.do_no=ds.do_no and m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and ds.total_amt>0 ".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con." group by m.do_no order by m.do_date,m.do_no";
$query = db_query($sql);
?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9"><?=$str?></td></tr><tr><th>S/L</th><th>Do No</th><th>Do Date</th><th>Dealer Name</th><th>Area</th><th>Depot</th><th>Grp</th><th>Rcv Amt</th><th>Payment Details</th><th>DO Amt</th><th>Sale Amt</th><th>Due Amt</th></tr></thead>
<tbody><?
while($data=mysqli_fetch_object($query)){$s++;
$due_amt = ($data->do_amt-$do_ch_amt[$data->do_no]);
$rcv_t = $rcv_t+$data->rcv_amt;
$dp_t = $dp_t+$data->do_amt;
$tp_t = $tp_t+$do_ch_amt[$data->do_no];
$due_t = $due_t+$due_amt;
?>
<tr><td><?=$s?></td><td><?=$data->do_no?></td><td><?=$data->do_date?></td><td><?=$data->dealer_name?></td><td><?=$data->area?></td><td><?=$data->depot?></td><td><?=$data->grp?></td><td style="text-align:right"><?=$data->rcv_amt?></td><td><?=$data->Payment_Details?></td><td style="text-align:right"><?=number_format($data->do_amt,2);?></td><td><?=number_format($do_ch_amt[$data->do_no],2)?></td><td><?=number_format($due_amt,2);?></td></tr>
<?
}
echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right">'.number_format($rcv_t,2).'</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tp_t,2).'</td><td>'.number_format($due_t,2).'</td></tr></tbody></table>';
}
elseif($_REQUEST['report']==191) 
{
$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp, m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details,d.dealer_code,sum(dl.total_amt) as dp_t,sum(dl.t_price*dl.total_unit) as tp_t from 
sale_other_master m,dealer_info d  , warehouse w, sale_other_details dl
where w.group_for='".$_SESSION['user']['group']."' and dl.do_no=m.do_no and m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con." group by d.dealer_code order by d.dealer_name_e";
$query = db_query($sql);
echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Dealer Name</th><th>Area</th><th>Depot</th><th>Grp</th><th>Rcv Amt</th><th>DP Total</th><th>TP Total</th></tr></thead>
<tbody>';
while($data=mysqli_fetch_object($query)){$s++;

$dp_t = $dp_t+$data->dp_t;
$tp_t = $tp_t+$data->tp_t;
?>
<tr><td><?=$s?></td><td><?=$data->dealer_name?></td><td><?=$data->area?></td><td><?=$data->depot?></td><td><?=$data->grp?></td><td style="text-align:right"><?=$data->rcv_amt?></td><td><?=number_format($data->dp_t,2)?></td><td><?=number_format($data->tp_t,2)?></td></tr>
<?
}
echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right">'.number_format($rcv_t,2).'</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tp_t,2).'</td></tr></tbody></table>';
}
elseif($_REQUEST['report']==3) 
{
$sql2 	= "select distinct o.do_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,m.do_date,d.address_e,d.mobile_no,d.product_group from 
sale_other_master m,sale_do_details o, item_info i,dealer_info d , warehouse w
where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$pg_con.$dealer_con;
$query2 = db_query($sql2);

while($data=mysqli_fetch_object($query2)){
echo '<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid">';
	$dealer_code = $data->dealer_code;
	$dealer_name = $data->dealer_name_e;
	$warehouse_name = $data->warehouse_name;
	$do_date = $data->do_date;
	$do_no = $data->do_no;
		if($dealer_code>0) 
{
$str 	.= '<p style="width:100%">Dealer Name: '.$dealer_name.' - '.$dealer_code.'('.$data->product_group.')</p>';
$str 	.= '<p style="width:100%">DO NO: '.$do_no.' 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depot:'.$warehouse_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:'.$do_date.'</p>
<p style="width:100%">Destination:'.$data->address_e.'('.$data->mobile_no.')</p>';

$dealer_con = ' and m.dealer_code='.$dealer_code;
$do_con = ' and m.do_no='.$do_no;
$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,o.pkt_unit as crt,o.dist_unit as pcs,o.total_amt as DP_Total,(o.t_price*o.total_unit) as TP_Total from 
sale_other_master m,sale_do_details o, item_info i,dealer_info d , warehouse w
where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$do_con." order by m.do_date desc";
}

	//echo report_create($sql,1,$str);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead>
<tr><td style="border:0px;" colspan="8"><?=$str?></td></tr><tr>
<th>S/L</th><th>Item Name</th><th>Crt</th><th>Pcs</th>
<th>TP Total</th>
<th>DP Total</th>
<th>Discount</th>
<th>Actual Amt </th>
</tr></thead>
<tbody>
<?

$tp_t = 0;
$dp_t = 0;
$dis_t = 0;
$act_t = 0;$crt_t = 0;$pcs_t = 0;

$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$discount =0;
$actual_amt = $info->DP_Total;
if($info->DP_Total<0)
{$discount =$info->DP_Total*(-1); $info->DP_Total = 0; $info->TP_Total = 0;}
?>
<tr><td><?=++$i;?></td><td><?=$info->item_name;?></td><td style="text-align:right"><?=$info->crt;?></td><td style="text-align:right"><?=$info->pcs;?></td>
  <td style="text-align:right"><?=$info->TP_Total;?></td>
  <td style="text-align:right"><?=$info->DP_Total;?></td>
  <td style="text-align:right"><?=$discount;?></td>
  <td style="text-align:right"><?=$actual_amt;?></td></tr>
<?
$crt_t = $crt_t + $info->crt;
$pcs_t = $pcs_t + $info->pcs;

$tp_t = $tp_t + $info->TP_Total;
$dp_t = $dp_t + $info->DP_Total;
$dis_t = $dis_t + $discount;
$act_t = $act_t + $actual_amt;
}
?>
<tr class="footer"><td>&nbsp;</td><td><?=$tp_t?></td><td style="text-align:right"><?=$crt_t?></td><td style="text-align:right"><?=$pcs_t?></td><td style="text-align:right"><?=$tp_t?></td>
  <td style="text-align:right"><?=$dp_t?></td>
  <td style="text-align:right"><?=$dis_t?></td>
  <td style="text-align:right"><?=$act_t?></td></tr></tbody></table>
<?
		$str = '';
		echo '</div>';
}
}
elseif($_REQUEST['report']==701) 
{
if(isset($t_date)) 	
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';$cdate_con=' and do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and i.sales_item_type="'.$product_group.'"';} 
if($depot_id>0) {$dpt_con=' and d.depot="'.$depot_id.'"';} 

$sql = "select 
i.finish_goods_code as code,
sum(o.total_unit) as total_unit
from 
sale_other_master m,sale_do_details o, item_info i,dealer_info d
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 
group by i.finish_goods_code';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$do_qty[$info->code] = $info->total_unit;
}
$sql = "select 
i.finish_goods_code as code,
sum(c.total_unit) as total_unit
from 
sale_other_master m, item_info i,dealer_info d,sale_other_chalan c
where m.do_no=c.do_no and m.dealer_code=d.dealer_code and i.item_id=c.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 
group by i.finish_goods_code';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$ch_qty[$info->code] = $info->total_unit;
}
		$sql = "select 
		i.finish_goods_code as code, 
		i.item_name, i.item_brand, 
		i.sales_item_type as `group`,i.pack_size,i.d_price
		from 
		sale_other_master m,sale_do_details o, item_info i,dealer_info d
		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 
		group by i.finish_goods_code';
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead>
<tr><td style="border:0px;" colspan="11"><?=$str?></td></tr><tr>
<th>S/L</th>
<th>Code</th>
<th>Item Name</th>
<th>Grp</th>
<th>Brand</th>
<th>Pack Size </th>
<th>Price Rate </th>
<th>DO Qty</th>
<th>CH Qty</th>
<th>DUE Qty</th>
<th>DUE Amt </th>
</tr></thead>
<tbody>
<?

$tp_t = 0;
$dp_t = 0;
$dis_t = 0;
$act_t = 0;$crt_t = 0;$pcs_t = 0;

$query = db_query($sql);
while($info = mysqli_fetch_object($query)){

$discount =0;

$actual_amt = $info->DP_Total;
$crt = (int)($do_qty[$info->code]/$info->pack_size);
$pcs = (int)($do_qty[$info->code]%$info->pack_size);
$do_total = $do_total + $do_qty[$info->code];

$ccrt = (int)($ch_qty[$info->code]/$info->pack_size);
$cpcs = (int)($ch_qty[$info->code]%$info->pack_size);
$ch_total = $ch_total + $ch_qty[$info->code];

$due_qty[$info->code] = ($do_qty[$info->code] - $ch_qty[$info->code]);
$dcrt = (int)($due_qty[$info->code]/$info->pack_size);
$dpcs = (int)($due_qty[$info->code]%$info->pack_size);
$due_total = $due_total + $due_qty[$info->code];
$amt_total = $amt_total + (int)($info->d_price*$due_qty[$info->code]);
?>
<tr><td><?=++$i;?></td>
  <td><?=$info->code;?></td>
  <td><?=$info->item_name;?></td>
  <td><?=$info->group?></td>
  <td><?=$info->item_brand?></td>
  <td style="text-align:center"><?=$info->pack_size?></td>
  <td style="text-align:right"><?=number_format($info->d_price,2);?></td>
  <td style="text-align:right"><?=(($crt>0)?$crt:'0');?>/<?=$pcs?></td>
  <td style="text-align:right"><?=(($ccrt>0)?$ccrt:'0');?>/<?=$cpcs?></td>
  <td style="text-align:right"><?=(($dcrt>0)?$dcrt:'0');?>/<?=$dpcs?></td>
  <td style="text-align:right"><?=number_format((int)(($info->d_price*$due_qty[$info->code])),2);?></td></tr>
<?
}
?>
<tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right"><?=$do_total;?></td>
  <td style="text-align:right"><?=$ch_total?></td>
  <td style="text-align:right"><?=$due_total?></td>
  <td style="text-align:right"><?=number_format($amt_total,2)?></td></tr></tbody></table>
<?
		$str = '';
		echo '</div>';

}

elseif($_REQUEST['report']==702) 
{
if(isset($t_date)) 	
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';$cdate_con=' and do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and i.sales_item_type="'.$product_group.'"';} 
if($depot_id>0) {$dpt_con=' and d.depot="'.$depot_id.'"';} 

$sql = "select
o.id as code,
sum(o.total_unit) as total_unit
from 
sale_other_master m,sale_other_details o, item_info i,dealer_info d
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') and d.group_for='".$_SESSION['user']['group']."' ".$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.$dealer_con.' 
group by o.id';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$do_qty[$info->code] = $info->total_unit;
}
$sql = "select 
c.order_no as code,
sum(c.total_unit) as total_unit
from 
sale_other_master m, item_info i,dealer_info d,sale_other_chalan c
where m.do_no=c.do_no and m.dealer_code=d.dealer_code and i.item_id=c.item_id  and m.status in ('CHECKED','COMPLETED') and d.group_for='".$_SESSION['user']['group']."'  ".$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.$dealer_con.' 
group by c.order_no';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$ch_qty[$info->code] = $info->total_unit;
}
		$sql = "select 
		m.do_date,
		m.do_no,
		d.dealer_name_e dealer_name, d.dealer_code,
		d.product_group,
		o.id as code, 
		i.finish_goods_code as fg_code, 
		i.item_name, i.item_brand, 
		i.sales_item_type as `group`,i.pack_size,o.unit_price d_price 
		from 
		sale_other_master m,sale_other_details o, item_info i,dealer_info d
		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') and d.group_for='".$_SESSION['user']['group']."'  ".$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.$dealer_con.' 
		group by o.id';
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead>
<tr><td style="border:0px;" colspan="13"><?=$str?></td></tr><tr>
<th>S/L</th>
<th>DO Date</th>
<th>DO NO</th>
<th>Dealer Code</th>
<th>Dealer Name</th>
<th>FG Code</th>
<th>Item Name</th>
<th>Pack Size </th>
<th>Price Rate </th>
<th>DO Qty</th>
<th>CH Qty</th>
<th>DUE Qty</th>
<th>DUE Amt </th>
</tr></thead>
<tbody>
<?

$tp_t = 0;
$dp_t = 0;
$dis_t = 0;
$act_t = 0;$crt_t = 0;$pcs_t = 0;

$query = db_query($sql);
while($info = mysqli_fetch_object($query)){

$discount =0;
$due_qty[$info->code] = ($do_qty[$info->code] - $ch_qty[$info->code]);

if($due_qty[$info->code]>0){
$actual_amt = $info->DP_Total;
$crt = (int)($do_qty[$info->code]/$info->pack_size);
$pcs = (int)($do_qty[$info->code]%$info->pack_size);
$do_total = $do_total + $do_qty[$info->code];

$ccrt = (int)($ch_qty[$info->code]/$info->pack_size);
$cpcs = (int)($ch_qty[$info->code]%$info->pack_size);
$ch_total = $ch_total + $ch_qty[$info->code];


$dcrt = (int)($due_qty[$info->code]/$info->pack_size);
$dpcs = (int)($due_qty[$info->code]%$info->pack_size);
$due_total = $due_total + $due_qty[$info->code];
$amt_total = $amt_total + (int)($info->d_price*$due_qty[$info->code]);
?>
<tr><td><?=++$i;?></td>
  <td><?=$info->do_date?></td>
  <td><?=$info->do_no?></td>
  <td><?=$info->dealer_code?></td>
  <td><?=$info->dealer_name?></td>
  <td><?=$info->fg_code;?></td>
  <td><?=$info->item_name;?></td>
  <td style="text-align:center"><?=$info->pack_size?></td>
  <td style="text-align:right"><?=number_format($info->d_price,2);?></td>
  <td style="text-align:right"><?=(($crt>0)?$crt:'0');?>/<?=$pcs?></td>
  <td style="text-align:right"><?=(($ccrt>0)?$ccrt:'0');?>/<?=$cpcs?></td>
  <td style="text-align:right"><?=(($dcrt>0)?$dcrt:'0');?>/<?=$dpcs?></td>
  <td style="text-align:right"><?=number_format((int)(($info->d_price*$due_qty[$info->code])),2);?></td></tr>
<?
}}
?>
<tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right"><?=$do_total;?></td>
  <td style="text-align:right"><?=$ch_total?></td>
  <td style="text-align:right"><?=$due_total?></td>
  <td style="text-align:right"><?=number_format($amt_total,2)?></td></tr></tbody></table>
<?
		$str = '';
		echo '</div>';

}
elseif($_REQUEST['report']==7011) 
{
if(isset($t_date)) 	
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';$cdate_con=' and do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and i.sales_item_type="'.$product_group.'"';} 
if($depot_id>0) {$dpt_con=' and d.depot="'.$depot_id.'"';} 

$sql = "select 
i.finish_goods_code as code,
sum(o.total_unit) as total_unit
from 
sale_other_master m,sale_do_details o, item_info i,dealer_info d
where o.unit_price>0 and m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$dtype_con.$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 
group by i.finish_goods_code';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$do_qty[$info->code] = $info->total_unit;
}
$sql = "select 
i.finish_goods_code as code,
sum(c.total_unit) as total_unit
from 
sale_other_master m, item_info i,dealer_info d,sale_other_chalan c
where c.unit_price>0 and m.do_no=c.do_no and m.dealer_code=d.dealer_code and i.item_id=c.item_id  and m.status in ('CHECKED','COMPLETED') ".$dtype_con.$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 
group by i.finish_goods_code';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$ch_qty[$info->code] = $info->total_unit;
}
		$sql = "select 
		i.finish_goods_code as code, 
		i.item_name, i.item_brand, 
		i.sales_item_type as `group`,i.pack_size,i.d_price
		from 
		sale_other_master m,sale_do_details o, item_info i,dealer_info d
		where i.finish_goods_code not between 5000 and 6000 and i.finish_goods_code not between 2000 and 3000 and   m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 
		group by i.finish_goods_code';
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead>
<tr><td style="border:0px;" colspan="11"><?=$str?></td></tr><tr>
<th>S/L</th>
<th>Code</th>
<th>Item Name</th>
<th>Grp</th>
<th>Brand</th>
<th>Pack Size </th>
<th>Price Rate </th>
<th>DO Qty</th>
<th>CH Qty</th>
<th>DUE Qty</th>
<th>DUE Amt </th>
</tr></thead>
<tbody>
<?

$tp_t = 0;
$dp_t = 0;
$dis_t = 0;
$act_t = 0;$crt_t = 0;$pcs_t = 0;

$query = db_query($sql);
while($info = mysqli_fetch_object($query)){

$discount =0;

$actual_amt = $info->DP_Total;
$crt = (int)($do_qty[$info->code]/$info->pack_size);
$pcs = (int)($do_qty[$info->code]%$info->pack_size);
$do_total = $do_total + $do_qty[$info->code];


$ccrt = (int)($ch_qty[$info->code]/$info->pack_size);
$cpcs = (int)($ch_qty[$info->code]%$info->pack_size);
$ch_total = $ch_total + $ch_qty[$info->code];

$due_qty[$info->code] = ($do_qty[$info->code] - $ch_qty[$info->code]);
$dcrt = (int)($due_qty[$info->code]/$info->pack_size);
$dpcs = (int)($due_qty[$info->code]%$info->pack_size);
$due_total = $due_total + $due_qty[$info->code];
$amt_total = $amt_total + (int)($info->d_price*$due_qty[$info->code]);
?>
<tr><td><?=++$i;?></td>
  <td><?=$info->code;?></td>
  <td><?=$info->item_name;?></td>
  <td><?=$info->group?></td>
  <td><?=$info->item_brand?></td>
  <td style="text-align:center"><?=$info->pack_size?></td>
  <td style="text-align:right"><?=number_format($info->d_price,2);?></td>
  <td style="text-align:right"><?=(($crt>0)?$crt:'0');?>/<?=$pcs?></td>
  <td style="text-align:right"><?=(($ccrt>0)?$ccrt:'0');?>/<?=$cpcs?></td>
  <td style="text-align:right"><?=(($dcrt>0)?$dcrt:'0');?>/<?=$dpcs?></td>
  <td style="text-align:right"><?=number_format((int)(($info->d_price*$due_qty[$info->code])),2);?></td></tr>
<?
}
?>
<tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right"><?=$do_total;?></td>
  <td style="text-align:right"><?=$ch_total?></td>
  <td style="text-align:right"><?=$due_total?></td>
  <td style="text-align:right"><?=number_format($amt_total,2)?></td></tr></tbody></table>
<?
		$str = '';
		echo '</div>';

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
$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 
sale_other_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_other_master m,dealer_info d  , warehouse w,area a,sale_do_details s
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
?>

<?


}

elseif($_REQUEST['report']==501) 
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
sale_other_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_other_master m,dealer_info d  , warehouse w,area a,sale_do_details s
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
?>

<?


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
sale_other_master m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' group by i.finish_goods_code';

$sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total
from 
sale_other_master m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a
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
elseif($_REQUEST['report']==14) 
{
if(isset($region_id)) 
$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;
else $sqlbranch 	= "select * from branch";
$querybranch = db_query($sqlbranch);
while($branch=mysqli_fetch_object($querybranch)){
	$rp=0;
	echo '<div>';


$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,
floor(sum(o.total_unit)/o.pkt_size) as crt,
mod(sum(o.total_unit),o.pkt_size) as pcs, 
sum(o.total_amt) as DP,
sum(o.total_unit*o.t_price) as TP
from 
sale_other_master m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a, zon z
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=".$region_id." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' group by i.finish_goods_code';

 $sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total from 
sale_other_master m,sale_do_details o, item_info i, warehouse w, dealer_info d, area a, zon z
where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=".$region_id." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.'';

		$queryt = db_query($sqlt);
		$t= mysqli_fetch_object($queryt);
		if($t->total>0)
		{
			if($rp==0) {$reg_total=0;$dp_total=0; 
			$str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;
		}
			echo report_create($sql,1,$str);
			$str = '';
			
			$reg_total= $reg_total+$t->total;
			$dp_total= $dp_total+$t->dp_total;
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
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 
sale_other_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." and a.AREA_CODE=".$area_id." ".$date_con.$pg_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_other_master m,dealer_info d  , warehouse w,area a,sale_do_details s
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.AREA_CODE=".$area_id." and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;
}
else
{
$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,w.warehouse_name as depot,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 
sale_other_master m,dealer_info d  , warehouse w,area a
where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con." order by do_no";
$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 
sale_other_master m,dealer_info d  , warehouse w,area a,sale_do_details s
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
    <td align="right"><?=$branch->BRANCH_NAME?> Region  DP Total: <?=number_format($dp_total,2)?> ||| TP Total: <?=number_format($reg_total,2)?></td></tr></tbody>
</table><br /><br /><br />
<?  }
	echo '</div>';
}

}elseif($_REQUEST['report']==100) 
{
if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code='.$dealer_code;} 

if(isset($region_id))			{$con .= " and z.REGION_ID=".$region_id;
								 $str .= '<p style="width:100%">Region Name: '.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id).' Region</p>';}
								 
if(isset($zone_id))				{$con .= " and a.ZONE_ID=".$zone_id;
								 $str .= '<p style="width:100%">Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id).' Zone</p>';}
								 
if(isset($area_id)) 			{$con .= " and a.AREA_CODE=".$area_id;
								 $str .= '<p style="width:100%">Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE='.$area_id).' Area</p>';}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="ExportTable">
<thead>
<tr><td style="border:0px;" colspan="11"><?=$str;?></td></tr>
<tr><th>S/L</th>
  <th>CODE</th>
  <th>Dealer Name</th><th>Grp</th><th>Depot</th>
  <th>Region</th>
  <th>Zone</th>
  <th>Area</th>
  <th>Damage</th>
  <th>DO Total</th>
  <th>CH Delivery</th>
  <th>DO Delivery </th>
  <th>Sales Rtn </th>
  </tr>
</thead>
<tbody>
<?
$sql="select d.dealer_code, d.dealer_name_e, w.warehouse_name, a.AREA_NAME as area,z.ZONE_NAME as zone,b.BRANCH_NAME as region, d.product_group as grp from 
dealer_info d  , warehouse w,area a,zon z,branch b
where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code ".$pg_con.$con.$dealer_con." ";

$query = db_query($sql);
while($data= mysqli_fetch_object($query)){
$sql_o = 'select sum(o.total_amt) from sale_other_master m, sale_do_details o where m.dealer_code="'.$data->dealer_code.'" and m.do_no=o.do_no and m.status in ("COMPLETED","CHECKED") and m.do_date between "'.$fr_date.'" and "'.$to_date.'"';
$data_o = find_a_field_sql($sql_o);
$sql_d = 'select sum(o.total_amt) from sale_other_master m, sale_other_chalan o where m.dealer_code="'.$data->dealer_code.'" and m.do_no=o.do_no and m.status in ("COMPLETED","CHECKED") and m.do_date between "'.$fr_date.'" and "'.$to_date.'"';
$data_d = find_a_field_sql($sql_d);
$sql_c = 'select sum(o.total_amt) from sale_other_master m, sale_other_chalan o where m.dealer_code="'.$data->dealer_code.'" and m.do_no=o.do_no and m.status in ("COMPLETED","CHECKED") and o.chalan_date between "'.$fr_date.'" and "'.$to_date.'"';
$data_c = find_a_field_sql($sql_c);
$sql_sr = 'select sum(o.amount) from warehouse_other_receive_detail o where o.vendor_id="'.$data->dealer_code.'" and o.receive_type ="Return" and o.or_date between "'.$fr_date.'" and "'.$to_date.'"';
$data_sr = find_a_field_sql($sql_sr);

$sql_dr = 'select sum(o.amount) from warehouse_damage_receive_detail o,damage_cause d where o.vendor_id="'.$data->dealer_code.'" and o.receive_type =d.id and d.payable="Yes" and o.or_date between "'.$fr_date.'" and "'.$to_date.'"';
$data_dr = find_a_field_sql($sql_dr);

?>

<tr><td><?=++$op;?></td>
  <td><?=$data->dealer_code?></td>
  <td><?=$data->dealer_name_e?></td>
  <td><?=$data->grp?></td>
  <td><?=$data->warehouse_name?></td>
  <td><?=$data->region?></td>
  <td><?=$data->zone?></td>
  <td><?=$data->area?></td>
  <td><div align="right"><?=number_format($data_dr,2)?></div></td>
  <td><div align="right"><?=number_format($data_o,2)?></div></td>
  <td><div align="right"><?=number_format($data_c,2)?></div></td>
  <td><div align="right"><?=number_format($data_d,2)?></div></td>
  <td><div align="right"><?=number_format($data_sr,2)?></div></td>
  <?
$ct = $ct + $data_c;
$ot = $ot + $data_o;
$dt = $dt + $data_d;
$srt = $srt + $data_sr;
$drt = $drt + $data_dr;
$ddiff = $ddiff + $diff;
}
?>
</tr>
<tr class="footer"><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td style="text-align:right"><?=number_format($drt,2)?></td>
  <td style="text-align:right"><div align="right"><?=number_format($ot,2)?></div></td>
  <td style="text-align:right"><div align="right"><?=number_format($ct,2)?></div></td>
  <td style="text-align:right"><div align="right"><?=number_format($dt,2)?></div></td>
  <td style="text-align:right"><div align="right"><?=number_format($srt,2)?></div></td>
  </tr>
</tbody></table>
<?

}elseif($_REQUEST['report']==101) 
{
echo $str;
 if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

$f_mons0 = date('Y-m-01',$t_stamp);
$f_mone0 = date('Y-m-'.date('t',$t_stamp),$t_stamp);

$f_mons1 = date('Y-'.($t_array[1]-1).'-01',$t_stamp);
$f_mone1 = date('Y-'.($t_array[1]-1).'-'.date('t',strtotime($f_mons1)),strtotime($f_mons1));

$f_mons2 = date('Y-'.($t_array[1]-2).'-01',$t_stamp);
$f_mone2 = date('Y-'.($t_array[1]-2).'-'.date('t',strtotime($f_mons2)),strtotime($f_mons2));

$f_mons3 = date('Y-'.($t_array[1]-3).'-01',$t_stamp);
$f_mone3 = date('Y-'.($t_array[1]-3).'-'.date('t',strtotime($f_mons3)),strtotime($f_mons3));

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">Item Code </span></td>
    <td bgcolor="#333333"><span class="style3">Item Name </span></td>
    <td bgcolor="#333333"><span class="style3">Grp</span></td>
    <td bgcolor="#333333"><span class="style3">Brand</span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons3))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons2))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons1))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('jS-M\'y',strtotime($t_date))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons0))?>
      (Apx.)</span></td>
    <td bgcolor="#333333"><span class="style3">Growth</span></td>
  </tr>
 <?
if(isset($product_group)) 		{$pg_con=' and i.sales_item_type like "%'.$product_group.'%"';}
$sql = "select i.item_id, i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`
from item_info i
where i.item_brand!='Promotional' and i.sales_item_type!='' ".$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';

$query = db_query($sql);
while($item=mysqli_fetch_object($query)){

$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.item_id=".$item->item_id.$pg_con));

$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.item_id=".$item->item_id.$pg_con));

$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.item_id=".$item->item_id.$pg_con));

$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.item_id=".$item->item_id.$pg_con));

$sqlmon = ((($sqlmon0[0])*date('t'))/$t_array[2]);
$diff = ($sqlmon-$sqlmon1[0]);


 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$i?></td>
    <td><?=$item->code?></td>
    <td><?=$item->item_name?></td>
    <td><?=$item->group?></td>
    <td><?=$item->item_brand?></td>
    <td bgcolor="#99CCFF"><?=$sqlmon3[0]?></td>
    <td bgcolor="#66CC99"><?=$sqlmon2[0]?></td>
    <td bgcolor="#FFFF99"><?=$sqlmon1[0]?></td>
    <td><?=$sqlmon0[0]?></td>
    <td><?=$sqlmon?></td>
    <td style="color:<?=($diff>0)?'#009900;':'#FF0000;'?>"><?=$diff?></td>
  </tr>
  <? }?>
</table>
<?

}
elseif($_REQUEST['report']==102) 
{
echo $str;
 if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

$f_mons0 = date('Y-m-01',$t_stamp);
$f_mone0 = date('Y-m-'.date('t',$t_stamp),$t_stamp);

$f_mons1 = date('Y-'.($t_array[1]-1).'-01',$t_stamp);
$f_mone1 = date('Y-'.($t_array[1]-1).'-'.date('t',strtotime($f_mons1)),strtotime($f_mons1));

$f_mons2 = date('Y-'.($t_array[1]-2).'-01',$t_stamp);
$f_mone2 = date('Y-'.($t_array[1]-2).'-'.date('t',strtotime($f_mons2)),strtotime($f_mons2));

$f_mons3 = date('Y-'.($t_array[1]-3).'-01',$t_stamp);
$f_mone3 = date('Y-'.($t_array[1]-3).'-'.date('t',strtotime($f_mons3)),strtotime($f_mons3));

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">Item Code </span></td>
    <td bgcolor="#333333"><span class="style3">Item Name </span></td>
    <td bgcolor="#333333"><span class="style3">Grp</span></td>
    <td bgcolor="#333333"><span class="style3">Brand</span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons3))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons2))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons1))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('jS-M\'y',strtotime($t_date))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons0))?>
      (Apx.)</span></td>
    <td bgcolor="#333333"><span class="style3">Growth</span></td>
  </tr>
<?
if(isset($product_group)) 		{$pg_con=' and i.sales_item_type like "%'.$product_group.'%"';}
$sql = "select i.item_id, i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`
from item_info i
where i.item_brand!='Promotional' and i.sales_item_type!='' ".$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';

	$query = db_query($sql);
	while($item=mysqli_fetch_object($query)){
$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.item_id=".$item->item_id.$pg_con));
$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.item_id=".$item->item_id.$pg_con));
$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.item_id=".$item->item_id.$pg_con));
$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.item_id=".$item->item_id.$pg_con));

$sqlmon = ((($sqlmon0[0])*date('t'))/$t_array[2]);
$diff = ($sqlmon-$sqlmon1[0]);

$sqlmont3 = $sqlmont3 + $sqlmon3[0];
$sqlmont2 = $sqlmont2 + $sqlmon2[0];
$sqlmont1 = $sqlmont1 + $sqlmon1[0];

$sqlmont = $sqlmont + $sqlmon;
$sqlmont0 = $sqlmont0 + $sqlmon0[0];
 ?>

  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$i?></td>
    <td><?=$item->code?></td>
    <td><?=$item->item_name?></td>
    <td><?=$item->group?></td>
    <td><?=$item->item_brand?></td>
    <td bgcolor="#99CCFF"><?=number_format($sqlmon3[0],2);?></td>
    <td bgcolor="#66CC99"><?=number_format($sqlmon2[0],2);?></td>
    <td bgcolor="#FFFF99"><?=number_format($sqlmon1[0],2);?></td>
    <td><?=number_format($sqlmon0[0],2);?></td>
    <td><?=number_format($sqlmon,2);?></td>
    <td style="color:<?=($diff>0)?'#009900;':'#FF0000;'?>"><?=number_format($diff,2);?></td>
  </tr>
  <? }?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td colspan="5" bgcolor="#FFFFFF"><strong>Total</strong></td>
    <td bgcolor="#FFFFFF"><strong>&nbsp;
        <?=number_format($sqlmont3,2);?>
    </strong></td>
    <td bgcolor="#FFFFFF"><strong>&nbsp;
        <?=number_format($sqlmont2,2);?>
    </strong></td>
    <td bgcolor="#FFFFFF"><strong>&nbsp;
        <?=number_format($sqlmont1,2);?>
    </strong></td>
    <td bgcolor="#FFFFFF"><strong>
      <?=number_format($sqlmont0,2);?>
    </strong></td>
    <td bgcolor="#FFFFFF"><strong>
      <?=number_format($sqlmont,2);?>
    </strong></td>
    <td bgcolor="#FFFFFF" style="color:<?=($diff>0)?'#009900;':'#FF0000;'?>">&nbsp;</td>
  </tr>
</table>
<?

}

elseif($_REQUEST['report']==103) 
{
echo $str;
 if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

$f_mons0 = date('Y-m-01',$t_stamp);
$f_mone0 = date('Y-m-'.date('t',$t_stamp),$t_stamp);

$f_mons1 = date('Y-'.($t_array[1]-1).'-01',$t_stamp);
$f_mone1 = date('Y-'.($t_array[1]-1).'-'.date('t',strtotime($f_mons1)),strtotime($f_mons1));

$f_mons2 = date('Y-'.($t_array[1]-2).'-01',$t_stamp);
$f_mone2 = date('Y-'.($t_array[1]-2).'-'.date('t',strtotime($f_mons2)),strtotime($f_mons2));

$f_mons3 = date('Y-'.($t_array[1]-3).'-01',$t_stamp);
$f_mone3 = date('Y-'.($t_array[1]-3).'-'.date('t',strtotime($f_mons3)),strtotime($f_mons3));

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">ZONE NAME </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons3))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons2))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons1))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('jS-M\'y',strtotime($t_date))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons0))?>
      (Apx.)</span></td>
    <td bgcolor="#333333"><span class="style3">Growth</span></td>
  </tr>
 <?
 


$sql = "select * from zon where REGION_ID='".$region_id."' order by ZONE_NAME";
	$query = db_query($sql);
	while($item=mysqli_fetch_object($query)){
 $zone_code = $item->ZONE_CODE;


echo "select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con;
$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon = ((($sqlmon0[0])*date('t'))/$t_array[2]);
$diff = ($sqlmon-$sqlmon1[0]);

 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$i?></td>
    <td><a href="master_report.php?submit=105&report=105&item_id=<?=$_REQUEST['item_id']?>&zone_id=<?=$zone_code?>&t_date=<?=$_REQUEST['t_date']?>" target="_blank"><?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_code)?></a></td>
    <td bgcolor="#99CCFF"><?=number_format($sqlmon3[0],2);?></td>
    <td bgcolor="#66CC99"><?=number_format($sqlmon2[0],2);?></td>
    <td bgcolor="#FFFF99"><?=number_format($sqlmon1[0],2);?></td>
    <td><?=number_format($sqlmon0[0],2);?></td>
    <td><?=number_format($sqlmon,2);?></td>
    <td style="color:<?=($diff>0)?'#009900;':'#FF0000;'?>"><?=number_format($diff,2);?></td>
  </tr>
  <? }?>
</table>
<?

}

elseif($_POST['report']==2002) 
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="9"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>

<tr><th rowspan="2">S/L</th><th rowspan="2">Fg</th><th rowspan="2">Item Name</th><th rowspan="2">Unit</th><th rowspan="2">Brand</th><th rowspan="2">Pack Size</th><th rowspan="2">GRP</th>
  <th colspan="3" bgcolor="#FFCCFF"><div align="center">Last Year </div></th>
  <th colspan="3" bgcolor="#FFFF99"><div align="center">This Year </div></th>
<th>Growth</th>
</tr>
<tr>
  <th>Sale Ctn </th>
  <th>Sale Qty </th>
  <th>Sale Amt </th>
  <th>Sale Ctn </th>
  <th>Sale Qty </th>
  <th>Sale Amt </th>
  <th>in % </th>
</tr>

</thead><tbody>
<?
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

if($this_year_sale_qty[$data->item_id]>$last_year_sale_qty[$data->item_id])
{
$growth = @((($this_year_sale_qty[$data->item_id])/$last_year_sale_qty[$data->item_id]));
$bg = '; background-color:#99FFFF';
}else
{
$growth = @(($this_year_sale_qty[$data->item_id])/$last_year_sale_qty[$data->item_id]);
$bg = '; background-color:#FFCCCC';
}
$growth = ($growth*100)-100;
?>
<tr><td><?=++$s?></td><td><?=$data->fg?></td><td><?=$data->item_name?></td><td><?=$data->unit?></td><td><?=$data->brand?></td><td><?=$data->pkt?></td><td><?=$data->sales_item_type?></td>
  <td style="text-align:right"><?=(int)($last_year_sale_qty[$data->item_id]/$data->pkt)?></td>
  <td style="text-align:right"><?=number_format($last_year_sale_qty[$data->item_id],0,'',',')?></td>
  <td style="text-align:right"><?=number_format($last_year_sale_amt[$data->item_id],0,'',',')?></td>
  <td style="text-align:right"><?=(int)($this_year_sale_qty[$data->item_id]/$data->pkt)?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_qty[$data->item_id],0,'',',')?></td>
<td style="text-align:right"><?=number_format($this_year_sale_amt[$data->item_id],0,'',',')?></td>
  <td style="text-align:right<?=$bg?>"><? if($growth!=-100) echo number_format((($growth)),2)?></td>
</tr>
<?
}
?>
</tbody></table>
<?
}

elseif($_POST['report']==2003) 
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead><tr><td style="border:0px;" colspan="9"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>

<tr><th rowspan="2">S/L</th>
<th rowspan="2">Code</th>
<th rowspan="2">Dealer Name</th>
<th rowspan="2">Area</th>
<th rowspan="2">Zone</th>
<th rowspan="2">Region</th><th colspan="3" bgcolor="#FFCCFF"><div align="center">Last Year </div></th>
  <th colspan="3" bgcolor="#FFFF99"><div align="center">This Year </div></th>
<th>Growth</th>
</tr>
<tr>
  <th>Sale Ctn</th>
  <th>Sale Total Pcs</th>
  <th>Sale Amt </th>
  <th>Sale Ctn </th>
  <th>Sale Total Pcs</th>
  <th>Sale Amt </th>
  <th>in pcs% </th>
</tr>

</thead><tbody>
<?
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

if($this_year_sale_qty[$data->dealer_code]>$last_year_sale_qty[$data->dealer_code])
{
$growth = @((($this_year_sale_qty[$data->dealer_code])/$last_year_sale_qty[$data->dealer_code]));
$bg = '; background-color:#99FFFF';
}else
{
$growth = @(($this_year_sale_qty[$data->dealer_code])/$last_year_sale_qty[$data->dealer_code]);
$bg = '; background-color:#FFCCCC';
}
$growth = ($growth*100)-100;
$ytotal_sale_pkt = $ytotal_sale_pkt + (int)($last_year_sale_pkt[$data->dealer_code]);
$ytotal_sale_amt = $ytotal_sale_amt + (int)($last_year_sale_amt[$data->dealer_code]);
$ytotal_sale_qty = $ytotal_sale_qty + (int)($last_year_sale_qty[$data->dealer_code]);
$total_sale_pkt = $total_sale_pkt + (int)($this_year_sale_pkt[$data->dealer_code]);
$total_sale_amt = $total_sale_amt + (int)($this_year_sale_amt[$data->dealer_code]);
$total_sale_qty = $total_sale_qty + (int)($this_year_sale_qty[$data->dealer_code]);
?>
<tr><td><?=++$s?></td><td><?=$data->dealer_code?></td><td><?=$data->dealer_name?></td>
  <td><?=$data->area_name?></td>
  <td><?=$data->zone_name?></td>
  <td><?=$data->region_name?></td><td style="text-align:right"><?=(int)@($last_year_sale_pkt[$data->dealer_code])?></td>
  <td style="text-align:right"><?=number_format($last_year_sale_qty[$data->dealer_code],0,'',',')?></td>
  <td style="text-align:right"><?=number_format($last_year_sale_amt[$data->dealer_code],0,'',',')?></td>
  <td style="text-align:right"><?=(int)@($this_year_sale_pkt[$data->dealer_code])?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_qty[$data->dealer_code],0,'',',')?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_amt[$data->dealer_code],0,'',',')?></td>
  <td style="text-align:right<?=$bg?>"><? if($growth!=-100) echo number_format((($growth)),2)?></td>
</tr>
<?
}
?>
<tr><td colspan="6">&nbsp;</td>
  <td style="text-align:right"><?=(int)($ytotal_sale_pkt)?></td>
  <td style="text-align:right"><?=(int)($ytotal_sale_qty)?></td>
  <td style="text-align:right"><?=(int)($ytotal_sale_amt)?></td>
  <td style="text-align:right"><?=(int)($total_sale_pkt)?></td>
  <td style="text-align:right"><?=(int)($total_sale_qty)?></td>
  <td style="text-align:right"><?=(int)($total_sale_amt)?></td><td>&nbsp;</td>
</tr>
</tbody></table>
<?
}

elseif($_POST['report']==20031) 
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead>
    <tr><td style="border:0px;" colspan="6"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>
    <tr><th rowspan="2">S/L</th>
    <th rowspan="2">Code</th>
    <th rowspan="2">Region</th><th colspan="3" bgcolor="#FFCCFF"><div align="center">Last Year </div></th>
  <th colspan="3" bgcolor="#FFFF99"><div align="center">This Year </div></th>
<th>Growth</th>
</tr>
<tr>
  <th>Sale Ctn</th>
  <th>Sale Total Pcs</th>
  <th>Sale Amt </th>
  <th>Sale Ctn </th>
  <th>Sale Total Pcs</th>
  <th>Sale Amt </th>
  <th>in pcs%</th>
</tr>

</thead><tbody>
<?
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

if($this_year_sale_qty[$data->BRANCH_ID]>$last_year_sale_qty[$data->BRANCH_ID])
{
$growth = @((($this_year_sale_qty[$data->BRANCH_ID])/$last_year_sale_qty[$data->BRANCH_ID]));
$bg = '; background-color:#99FFFF';
}else
{
$growth = @(($this_year_sale_qty[$data->BRANCH_ID])/$last_year_sale_qty[$data->BRANCH_ID]);
$bg = '; background-color:#FFCCCC';
}
$growth = ($growth*100)-100;
$ytotal_sale_pkt = $ytotal_sale_pkt + (int)($last_year_sale_pkt[$data->BRANCH_ID]);
$ytotal_sale_amt = $ytotal_sale_amt + (int)($last_year_sale_amt[$data->BRANCH_ID]);
$ytotal_sale_qty = $ytotal_sale_qty + (int)($last_year_sale_qty[$data->BRANCH_ID]);
$total_sale_pkt = $total_sale_pkt + (int)($this_year_sale_pkt[$data->BRANCH_ID]);
$total_sale_amt = $total_sale_amt + (int)($this_year_sale_amt[$data->BRANCH_ID]);
$total_sale_qty = $total_sale_qty + (int)($this_year_sale_qty[$data->BRANCH_ID]);
?>
<tr><td><?=++$s?></td><td><?=$data->BRANCH_ID?></td><td><?=$data->region_name?></td><td style="text-align:right"><?=(int)@($last_year_sale_pkt[$data->BRANCH_ID])?></td>
  <td style="text-align:right"><?=number_format($last_year_sale_qty[$data->BRANCH_ID],0,'',',')?></td>
  <td style="text-align:right"><?=number_format($last_year_sale_amt[$data->BRANCH_ID],0,'',',')?></td>
  <td style="text-align:right"><?=(int)@($this_year_sale_pkt[$data->BRANCH_ID])?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_qty[$data->BRANCH_ID],0,'',',')?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_amt[$data->BRANCH_ID],0,'',',')?></td>
  <td style="text-align:right<?=$bg?>"><? if($growth!=-100) echo number_format((($growth)),2)?></td>
</tr>
<?
}
?>
<tr><td colspan="3" bgcolor="#EAEAEA">&nbsp;</td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($ytotal_sale_pkt)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($ytotal_sale_qty)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($ytotal_sale_amt)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($total_sale_pkt)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($total_sale_qty)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($total_sale_amt)?>
  </strong></td><td bgcolor="#EAEAEA" style="text-align:right; font-weight:bold"><?=@number_format((((-1)*(($ytotal_sale_qty-$total_sale_qty)/$ytotal_sale_qty))*100),2);?></td>
</tr>
</tbody></table>
<?
}
elseif($_POST['report']==20032) 
{
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead>
    <tr><td style="border:0px;" colspan="6"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>
    <tr><th rowspan="2">S/L</th>
    <th rowspan="2">Region</th>
    <th rowspan="2">Zone</th>
    <th colspan="3" bgcolor="#FFCCFF"><div align="center">Last Year </div></th>
  <th colspan="3" bgcolor="#FFFF99"><div align="center">This Year </div></th>
<th>Growth</th>
</tr>
<tr>
  <th>Sale Ctn</th>
  <th>Sale Total Pcs</th>
  <th>Sale Amt </th>
  <th>Sale Ctn </th>
  <th>Sale Total Pcs</th>
  <th>Sale Amt </th>
  <th>in % </th>
</tr>

</thead><tbody>
<?
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

if($this_year_sale_qty[$data->ZONE_CODE]>$last_year_sale_qty[$data->ZONE_CODE])
{
$growth = @((($this_year_sale_qty[$data->ZONE_CODE])/$last_year_sale_qty[$data->ZONE_CODE]));


$bg = '; background-color:#99FFFF';
}else
{
$growth = @(($this_year_sale_qty[$data->ZONE_CODE])/$last_year_sale_qty[$data->ZONE_CODE]);
$bg = '; background-color:#FFCCCC';
}
$growth = ($growth*100)-100;
$ytotal_sale_pkt = $ytotal_sale_pkt + (int)($last_year_sale_pkt[$data->ZONE_CODE]);
$ytotal_sale_amt = $ytotal_sale_amt + (int)($last_year_sale_amt[$data->ZONE_CODE]);
$ytotal_sale_qty = $ytotal_sale_qty + (int)($last_year_sale_qty[$data->ZONE_CODE]);
$total_sale_pkt = $total_sale_pkt + (int)($this_year_sale_pkt[$data->ZONE_CODE]);
$total_sale_amt = $total_sale_amt + (int)($this_year_sale_amt[$data->ZONE_CODE]);
$total_sale_qty = $total_sale_qty + (int)($this_year_sale_qty[$data->ZONE_CODE]);
?>
<tr><td><?=++$s?></td>
<td><?=$data->region_name?></td>
<td><?=$data->zone_name?></td>
<td style="text-align:right"><?=(int)@($last_year_sale_pkt[$data->ZONE_CODE])?></td>
  <td style="text-align:right"><?=number_format($last_year_sale_qty[$data->ZONE_CODE],0,'',',')?></td>
  <td style="text-align:right"><?=number_format($last_year_sale_amt[$data->ZONE_CODE],0,'',',')?></td>
  <td style="text-align:right"><?=(int)@($this_year_sale_pkt[$data->ZONE_CODE])?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_qty[$data->ZONE_CODE],0,'',',')?></td>
  <td style="text-align:right"><?=number_format($this_year_sale_amt[$data->ZONE_CODE],0,'',',')?></td>
  <td style="text-align:right<?=$bg?>"><? if($growth!=-100) echo number_format((($growth)),2)?></td>
</tr>
<?
}
?>
<tr><td colspan="3" bgcolor="#EAEAEA">&nbsp;</td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($ytotal_sale_pkt)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($ytotal_sale_qty)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($ytotal_sale_amt)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($total_sale_pkt)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($total_sale_qty)?>
  </strong></td>
  <td bgcolor="#EAEAEA" style="text-align:right"><strong>
    <?=(int)($total_sale_amt)?>
  </strong></td><td bgcolor="#EAEAEA" style="text-align:right; font-weight:bold"><?=@number_format((((-1)*(($ytotal_sale_qty-$total_sale_qty)/$ytotal_sale_qty))*100),2);?></td>
</tr>
</tbody></table>
<?
}
elseif($_REQUEST['report']==104) 
{
echo $str;
 if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

$f_mons0 = date('Y-m-01',$t_stamp);
$f_mone0 = date('Y-m-'.date('t',$t_stamp),$t_stamp);

$f_mons1 = date('Y-'.($t_array[1]-1).'-01',$t_stamp);
$f_mone1 = date('Y-'.($t_array[1]-1).'-'.date('t',strtotime($f_mons1)),strtotime($f_mons1));

$f_mons2 = date('Y-'.($t_array[1]-2).'-01',$t_stamp);
$f_mone2 = date('Y-'.($t_array[1]-2).'-'.date('t',strtotime($f_mons2)),strtotime($f_mons2));

$f_mons3 = date('Y-'.($t_array[1]-3).'-01',$t_stamp);
$f_mone3 = date('Y-'.($t_array[1]-3).'-'.date('t',strtotime($f_mons3)),strtotime($f_mons3));

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">ZONE NAME </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons3))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons2))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons1))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('jS-M\'y',strtotime($t_date))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons0))?>
      (Apx.)</span></td>
    <td bgcolor="#333333"><span class="style3">Growth</span></td>
  </tr>
 <?
 


$sql = "select * from zon where REGION_ID='".$region_id."' order by ZONE_NAME";

	$query = db_query($sql);
	while($item=mysqli_fetch_object($query)){
 $zone_code = $item->ZONE_CODE;
$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon = ((($sqlmon0[0])*date('t'))/$t_array[2]);
$diff = ($sqlmon-$sqlmon1[0]);

 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$i?></td>

	    <td><a href="master_report.php?submit=105&report=106&item_id=<?=$_REQUEST['item_id']?>&zone_id=<?=$zone_code?>&t_date=<?=$_REQUEST['t_date']?>" target="_blank" style="text-decoration:none"><?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_code)?></a></td>
    <td bgcolor="#99CCFF"><?=number_format($sqlmon3[0],2);?></td>
    <td bgcolor="#66CC99"><?=number_format($sqlmon2[0],2);?></td>
    <td bgcolor="#FFFF99"><?=number_format($sqlmon1[0],2);?></td>
    <td><?=number_format($sqlmon0[0],2);?></td>
    <td><?=number_format($sqlmon,2);?></td>
    <td style="color:<?=($diff>0)?'#009900;':'#FF0000;'?>"><?=number_format($diff,2);?></td>
  </tr>
  <? }?>
</table>
<?

}

elseif($_REQUEST['report']==105) 
{
echo $str;
 if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

$f_mons0 = date('Y-m-01',$t_stamp);
$f_mone0 = date('Y-m-'.date('t',$t_stamp),$t_stamp);

$f_mons1 = date('Y-'.($t_array[1]-1).'-01',$t_stamp);
$f_mone1 = date('Y-'.($t_array[1]-1).'-'.date('t',strtotime($f_mons1)),strtotime($f_mons1));

$f_mons2 = date('Y-'.($t_array[1]-2).'-01',$t_stamp);
$f_mone2 = date('Y-'.($t_array[1]-2).'-'.date('t',strtotime($f_mons2)),strtotime($f_mons2));

$f_mons3 = date('Y-'.($t_array[1]-3).'-01',$t_stamp);
$f_mone3 = date('Y-'.($t_array[1]-3).'-'.date('t',strtotime($f_mons3)),strtotime($f_mons3));

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">DEALER NAME </span></td>
    <td bgcolor="#333333"><span class="style3">AREA NAME </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons3))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons2))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons1))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('jS-M\'y',strtotime($t_date))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons0))?>
      (Apx.)</span></td>
    <td bgcolor="#333333"><span class="style3">Growth</span></td>
  </tr>
 <?
 


$sql = "select d.dealer_code, d.dealer_name_e, a.area_name from dealer_info d, area a where d.area_code=a.AREA_CODE and ZONE_ID='".$zone_id."' order by d.dealer_name_e";

	$query = db_query($sql);
	while($item=mysqli_fetch_object($query)){
 $zone_code = $item->ZONE_CODE;
$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d where c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d where c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d where c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon = ((($sqlmon0[0])*date('t'))/$t_array[2]);
$diff = ($sqlmon-$sqlmon1[0]);

 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$i?></td>
    <td><?=$item->dealer_name_e?></td>
    <td><?=$item->area_name?></td>
    <td bgcolor="#99CCFF"><?=number_format($sqlmon3[0],2);?></td>
    <td bgcolor="#66CC99"><?=number_format($sqlmon2[0],2);?></td>
    <td bgcolor="#FFFF99"><?=number_format($sqlmon1[0],2);?></td>
    <td><?=number_format($sqlmon0[0],2);?></td>
    <td><?=number_format($sqlmon,2);?></td>
    <td style="color:<?=($diff>0)?'#009900;':'#FF0000;'?>"><?=number_format($diff,2);?></td>
  </tr>
  <? }?>
</table>
<?

}

elseif($_REQUEST['report']==106) 
{
echo $str;
 if($t_date=='') $t_date = date('Y-m-d');
$t_array = explode('-',$t_date);
$t_stamp = strtotime($t_date);

$f_mons0 = date('Y-m-01',$t_stamp);
$f_mone0 = date('Y-m-'.date('t',$t_stamp),$t_stamp);

$f_mons1 = date('Y-'.($t_array[1]-1).'-01',$t_stamp);
$f_mone1 = date('Y-'.($t_array[1]-1).'-'.date('t',strtotime($f_mons1)),strtotime($f_mons1));

$f_mons2 = date('Y-'.($t_array[1]-2).'-01',$t_stamp);
$f_mone2 = date('Y-'.($t_array[1]-2).'-'.date('t',strtotime($f_mons2)),strtotime($f_mons2));

$f_mons3 = date('Y-'.($t_array[1]-3).'-01',$t_stamp);
$f_mone3 = date('Y-'.($t_array[1]-3).'-'.date('t',strtotime($f_mons3)),strtotime($f_mons3));

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">DEALER NAME </span></td>
    <td bgcolor="#333333"><span class="style3">AREA NAME </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons3))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons2))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons1))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('jS-M\'y',strtotime($t_date))?>
    </span></td>
    <td bgcolor="#333333"><span class="style3">
      <?=date('M\'y',strtotime($f_mons0))?>
      (Apx.)</span></td>
    <td bgcolor="#333333"><span class="style3">Growth</span></td>
  </tr>
 <?
 


$sql = "select d.dealer_code, d.dealer_name_e, a.area_name from dealer_info d, area a where d.area_code=a.AREA_CODE and ZONE_ID='".$zone_id."' order by d.dealer_name_e";

$query = db_query($sql);
while($item=mysqli_fetch_object($query)){

$zone_code = $item->ZONE_CODE;
$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));

$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon = (int)((($sqlmon0[0])*date('t'))/$t_array[2]);
$diff = ($sqlmon-$sqlmon1[0]);

 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$i?></td>
    <td><?=$item->dealer_name_e?></td>
    <td><?=$item->area_name?></td>
    <td bgcolor="#99CCFF"><?=number_format($sqlmon3[0],2);?></td>
    <td bgcolor="#66CC99"><?=number_format($sqlmon2[0],2);?></td>
    <td bgcolor="#FFFF99"><?=number_format($sqlmon1[0],2);?></td>
    <td><?=number_format($sqlmon0[0],2);?></td>
    <td><?=number_format($sqlmon,2);?></td>
    <td style="color:<?=($diff>0)?'#009900;':'#FF0000;'?>"><?=number_format($diff,2);?></td>
  </tr>
  <? }?>
</table>
<?
}
elseif($_REQUEST['report']==107) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">REGION NAME </span></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mos'.$i}))?></span></div></td>
<?
}
?>
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
 <?
 


$sql = "select BRANCH_ID,BRANCH_NAME from branch  order by BRANCH_NAME";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$BRANCH_ID = $item->BRANCH_ID;
for($i=12;$i>0;$i--)
{
$m = ($i-1);

$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;



${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$BRANCH_ID} = ${'totalr'.$BRANCH_ID} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->BRANCH_NAME?></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmon'.$i}[0],2);?></div></td>
<?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
        <? $totalallr= $totalallr + ${'totalr'.$BRANCH_ID};echo number_format(${'totalr'.$BRANCH_ID},2)?>
    </strong></div></td>
  </tr>
  <? }

for($i=12;$i>0;$i--)
{
$m = ($i-1);


$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

${'sqlmonc'.$i} = mysqli_fetch_row(db_query($sqql));
${'totalco'.$i} = ${'totalco'.$i} + ${'sqlmonc'.$i}[0];
${'totalrc1'} = ${'totalrc1'} + ${'sqlmonc'.$i}[0];
}

  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>D Total</strong></td>
<?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format(${'totalc'.$i},2);?></div></td>
<?
}
?>

      <td bgcolor="#FFFF99"><div align="right">
        <?=number_format($totalallr,2);?>
      </div></td>
    </tr>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td>Corporate</td>
	
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmonc'.$i}[0],2);?></div></td>
<?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
        <?=number_format($totalrc1,2)?>
    </strong></div></td>
    </tr>
	<?
	  for($i=12;$i>0;$i--)
{
$m = ($i-1);


$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmons'.$i} = mysqli_fetch_row(db_query($sqql));
${'totals'.$i} = ${'totals'.$i} + ${'sqlmons'.$i}[0];
${'totalrc'} = ${'totalrc'} + ${'sqlmons'.$i}[0];
}
	?>
	
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td>SuperShop</td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmons'.$i}[0],2);?></div></td>
<?
}
?>
<td bgcolor="#FFFF99"><div align="right"><strong>
  <?=number_format($totalrc,2)?>
</strong></div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
  <td>&nbsp;</td>
  <td><strong>Corporate+SuperShop</strong></td>
<?
for($i=12;$i>0;$i--)
{
${'totalall'} = ${'totalall'} + (${'totals'.$i}+${'totalco'.$i});
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totals'.$i}+${'totalco'.$i}),2)?></div></td>

<?
}
?><td bgcolor="#FFFF99"><div align="right"><strong><?=number_format(${'totalall'},2)?></strong></div></td>
  </tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>N Total</strong></td>
<?
for($i=12;$i>0;$i--)
{
${'totalallall'} = ${'totalallall'} + (${'totalc'.$i}+${'totals'.$i}+${'totalco'.$i});
?>
<td bgcolor="#FF9999"><div align="right"><?=number_format((${'totalc'.$i}+${'totals'.$i}+${'totalco'.$i}),2)?></div></td>
<?
}
?>
<td bgcolor="#FF3333"><div align="right"><strong>
  <?=number_format(${'totalallall'},2)?>
</strong></div></td>
</tr>
</table>
<?
}
elseif($_REQUEST['report']==108) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">REGION NAME </span></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mons'.$i}))?></span></div></td>
<?
}
?>
   
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
 <?
 


$sql = "select BRANCH_ID,BRANCH_NAME from branch  order by BRANCH_NAME";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$BRANCH_ID = $item->BRANCH_ID;
for($i=12;$i>0;$i--)
{
$m = ($i-1);
$sqql = "select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;
${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$BRANCH_ID} = ${'totalr'.$BRANCH_ID} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->BRANCH_NAME?></td>
	
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmon'.$i}[0],0);?></div></td>
<?
}
?>
	
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <?=number_format(${'totalr'.$BRANCH_ID},0)?>
    </strong></div></td>
  </tr>
  <? }
  
  for($i=12;$i>0;$i--)
{
$m = ($i-1);
$sqql = "select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;
${'sqlmonc'.$i} = mysqli_fetch_row(db_query($sqql));
${'totalco'.$i} = ${'totalco'.$i} + ${'sqlmonc'.$i}[0];
${'totalrc1'} = ${'totalrc1'} + ${'sqlmonc'.$i}[0];
}

  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>D Total</strong></td>
	  
<?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format(${'totalc'.$i},0);?></div></td>
<?
}
?>

	  
      <td bgcolor="#FFFF99"><div align="right"><?=number_format(${'totald'},0);?></div></td>
    </tr>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td>Corporate</td>
	
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmonc'.$i}[0],0);?></div></td>
<?
}
?>
	
    
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <?=number_format($totalrc1,0)?>
    </strong></div></td>
    </tr>
	<?
	  for($i=12;$i>0;$i--)
{
$m = ($i-1);
$sqql = "select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;;
${'sqlmons'.$i} = mysqli_fetch_row(db_query($sqql));
${'totals'.$i} = ${'totals'.$i} + ${'sqlmons'.$i}[0];
${'totalrc'} = ${'totalrc'} + ${'sqlmons'.$i}[0];
}
	?>
	
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td><?=++$j?></td>
<td>SuperShop</td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmons'.$i}[0],0);?></div></td>
<?
}
?>

<td bgcolor="#FFFF99"><div align="right"><strong><?=number_format($totalrc,0)?></strong></div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
  <td>&nbsp;</td>
  <td><strong>Corporate+SuperShop</strong></td>
<?
for($i=12;$i>0;$i--)
{
${'totalall'} = ${'totalall'} + (${'totals'.$i}+${'totalco'.$i});
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format((${'totals'.$i}+${'totalco'.$i}),0)?></div></td>
<?
}
?>
<td bgcolor="#FFFF99"><div align="right"><strong><?=number_format(${'totalall'},0)?></strong></div></td>
</tr>
<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
<td>&nbsp;</td>
<td><strong>N Total</strong></td>
<?
for($i=12;$i>0;$i--)
{
${'totalallall'} = ${'totalallall'} + (${'totalc'.$i}+${'totals'.$i}+${'totalco'.$i});
?>
<td bgcolor="#FF9999"><div align="right"><?=number_format((${'totalc'.$i}+${'totals'.$i}+${'totalco'.$i}),0)?></div></td>
<?
}
?>

<td bgcolor="#FF3333"><div align="right"><strong><?=number_format(${'totalallall'},0)?></strong></div></td>
</tr>
</table>
<?
}
elseif($_REQUEST['report']==109) 
{
echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">REGION NAME </span></td>
    <?
for($i=12;$i>0;$i--)
{
?>
    <td bgcolor="#333333"><div align="center"><span class="style3">
      <?=date('M\'y',strtotime(${'f_mons'.$i}))?>
    </span></div></td>
    <?
}
?>
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
  <?
 


$sql = "select BRANCH_ID,BRANCH_NAME from branch  order by BRANCH_NAME";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$BRANCH_ID = $item->BRANCH_ID;
for($i=12;$i>0;$i--)
{
$m = ($i-1);

$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;



${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$BRANCH_ID} = ${'totalr'.$BRANCH_ID} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->BRANCH_NAME?></td>
    <?
for($i=12;$i>0;$i--)
{
?>
    <td bgcolor="#99CCFF"><div align="right">
      <?=number_format(${'sqlmon'.$i}[0],2);?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <? 
$totalallr= $totalallr + ${'totalr'.$BRANCH_ID};
echo number_format(${'totalr'.$BRANCH_ID},2);
	  ?>
    </strong></div></td>
  </tr>
  <? }

for($i=12;$i>0;$i--)
{
$m = ($i-1);


$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

${'sqlmonc'.$i} = mysqli_fetch_row(db_query($sqql));
${'totalco'.$i} = ${'totalco'.$i} + ${'sqlmonc'.$i}[0];
${'totalrc1'} = ${'totalrc1'} + ${'sqlmonc'.$i}[0];
}

  ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td>&nbsp;</td>
    <td><strong>D Total</strong></td>
    <?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
    <td bgcolor="#FFFF66"><div align="right">
      <?=number_format(${'totalc'.$i},2);?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FFFF99"><div align="right">
      <?=number_format($totalallr,2);?>
    </div></td>
  </tr>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td>Corporate</td>
    <?
for($i=12;$i>0;$i--)
{
?>
    <td bgcolor="#99CCFF"><div align="right">
      <?=number_format(${'sqlmonc'.$i}[0],2);?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <?=number_format($totalrc1,2)?>
    </strong></div></td>
  </tr>
  <?
	  for($i=12;$i>0;$i--)
{
$m = ($i-1);


$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmons'.$i} = mysqli_fetch_row(db_query($sqql));
${'totals'.$i} = ${'totals'.$i} + ${'sqlmons'.$i}[0];
${'totalrc'} = ${'totalrc'} + ${'sqlmons'.$i}[0];
}
	?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td>SuperShop</td>
    <?
for($i=12;$i>0;$i--)
{
?>
    <td bgcolor="#99CCFF"><div align="right">
      <?=number_format(${'sqlmons'.$i}[0],2);?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <?=number_format($totalrc,2)?>
    </strong></div></td>
  </tr>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td>&nbsp;</td>
    <td><strong>Corporate+SuperShop</strong></td>
    <?
for($i=12;$i>0;$i--)
{
${'totalall'} = ${'totalall'} + (${'totals'.$i}+${'totalco'.$i});
?>
    <td bgcolor="#FFFF66"><div align="right">
      <?=number_format((${'totals'.$i}+${'totalco'.$i}),2)?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <?=number_format(${'totalall'},2)?>
    </strong></div></td>
  </tr>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td>&nbsp;</td>
    <td><strong>N Total</strong></td>
    <?
for($i=12;$i>0;$i--)
{
${'totalallall'} = ${'totalallall'} + (${'totalc'.$i}+${'totals'.$i}+${'totalco'.$i});
?>
    <td bgcolor="#FF9999"><div align="right">
      <?=number_format((${'totalc'.$i}+${'totals'.$i}+${'totalco'.$i}),2)?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FF3333"><div align="right"><strong>
      <?=number_format(${'totalallall'},2)?>
    </strong></div></td>
  </tr>
</table>
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




elseif($_REQUEST['report']==110) 
{echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">ZONE NAME</span></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mons'.$i}))?></span></div></td>
<?
}
?>
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
 <?
 


$sql = "select ZONE_CODE,ZONE_NAME from zon where REGION_ID=".$_REQUEST['region_id']." order by ZONE_NAME";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$ZONE_CODE = $item->ZONE_CODE;
for($i=12;$i>0;$i--)
{
$m = ($i-1);

$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d,area a where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and a.ZONE_ID ='".$ZONE_CODE."'".$con;



${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$ZONE_CODE} = ${'totalr'.$ZONE_CODE} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->ZONE_NAME?></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmon'.$i}[0],2);?></div></td>
<?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
        <? $totalallr= $totalallr + ${'totalr'.$ZONE_CODE};echo number_format(${'totalr'.$ZONE_CODE},2)?>
    </strong></div></td>
  </tr>
  <? }



  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>D Total</strong></td>
<?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format(${'totalc'.$i},2);?></div></td>
<?
}
?>

      <td bgcolor="#FFFF99"><div align="right">
        <?=number_format($totalallr,2);?>
      </div></td>
    </tr>

</table>
<?
}
elseif($_REQUEST['report']==111) 
{echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">ZONE NAME </span></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mons'.$i}))?></span></div></td>
<?
}
?>
   
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
 <?
 


$sql = "select ZONE_CODE,ZONE_NAME from zon where REGION_ID=".$_REQUEST['region_id']." order by ZONE_NAME";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$ZONE_CODE = $item->ZONE_CODE;
for($i=12;$i>0;$i--)
{
$m = ($i-1);
$sqql = "select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d,area a where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and a.ZONE_ID ='".$ZONE_CODE."'".$con;
${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$ZONE_CODE} = ${'totalr'.$ZONE_CODE} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->ZONE_NAME?></td>
	
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmon'.$i}[0],0);?></div></td>
<?
}
?>
	
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <?=number_format(${'totalr'.$ZONE_CODE},0)?>
    </strong></div></td>
  </tr>
  <? }
  


  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>D Total</strong></td>
	  
<?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format(${'totalc'.$i},0);?></div></td>
<?
}
?>

	  
      <td bgcolor="#FFFF99"><div align="right"><?=number_format(${'totald'},0);?></div></td>
    </tr>

</table>
<?
}
elseif($_REQUEST['report']==112) 
{echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">ZONE NAME </span></td>
    <?
for($i=12;$i>0;$i--)
{
?>
    <td bgcolor="#333333"><div align="center"><span class="style3">
      <?=date('M\'y',strtotime(${'f_mons'.$i}))?>
    </span></div></td>
    <?
}
?>
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
  <?
 


$sql = "select ZONE_CODE,ZONE_NAME from zon where REGION_ID=".$_REQUEST['region_id']." order by ZONE_NAME";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$ZONE_CODE = $item->ZONE_CODE;
for($i=12;$i>0;$i--)
{
$m = ($i-1);

$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d,area a where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and a.ZONE_ID ='".$ZONE_CODE."'".$con;



${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$ZONE_CODE} = ${'totalr'.$ZONE_CODE} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->ZONE_NAME?></td>
    <?
for($i=12;$i>0;$i--)
{
?>
    <td bgcolor="#99CCFF"><div align="right">
      <?=number_format(${'sqlmon'.$i}[0],2);?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <? 
$totalallr= $totalallr + ${'totalr'.$ZONE_CODE};
echo number_format(${'totalr'.$ZONE_CODE},2);
	  ?>
    </strong></div></td>
  </tr>
  <? }


  ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td>&nbsp;</td>
    <td><strong>D Total</strong></td>
    <?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
    <td bgcolor="#FFFF66"><div align="right">
      <?=number_format(${'totalc'.$i},2);?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FFFF99"><div align="right">
      <?=number_format($totalallr,2);?>
    </div></td>
  </tr>
</table>
<?
}

elseif($_REQUEST['report']==1130) 
{echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">CODE</span></td>
    <td bgcolor="#333333"><span class="style3">DEALER NAME </span></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mons'.$i}))?></span></div></td>
<?
}
?>
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
 <?
 


$sql = "select dealer_code,dealer_name_e as dealer_name from dealer_info m where dealer_type = 'Corporate' ".$dealer_con." order by dealer_name_e";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$dealer_code = $item->dealer_code;
for($i=12;$i>0;$i--)
{
$m = ($i-1);

$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d,item_info i where i.item_id=c.item_id and c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type = 'Corporate' and d.dealer_code='".$dealer_code."'".$item_brand_con.$item_con.$con;



${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->dealer_code?></td>
    <td><?=$item->dealer_name?></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmon'.$i}[0],2);?></div></td>
<?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
        <? $totalallr= $totalallr + ${'totalr'.$dealer_code};echo number_format(${'totalr'.$dealer_code},2)?>
    </strong></div></td>
  </tr>
  <? }


  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="2">&nbsp;</td>
      <td><strong>D Total</strong></td>
<?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format(${'totalc'.$i},2);?></div></td>
<?
}
?>

      <td bgcolor="#FFFF99"><div align="right">
        <?=number_format($totalallr,2);?>
      </div></td>
    </tr>
</table>
<?
}
elseif($_REQUEST['report']==11301) 
{echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">CODE</span></td>
    <td bgcolor="#333333"><span class="style3">DEALER NAME </span></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mons'.$i}))?></span></div></td>
<?
}
?>
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
 <?
 


$sql = "select dealer_code,dealer_name_e as dealer_name from dealer_info m where dealer_type = 'SuperShop' ".$dealer_con." order by dealer_name_e";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$dealer_code = $item->dealer_code;
for($i=12;$i>0;$i--)
{
$m = ($i-1);

$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d,item_info i where i.item_id=c.item_id and c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type = 'SuperShop' and d.dealer_code='".$dealer_code."'".$item_brand_con.$item_con.$con;



${'sqlmon'.$i} = @mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->dealer_code?></td>
    <td><?=$item->dealer_name?></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmon'.$i}[0],2);?></div></td>
<?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
        <? $totalallr= $totalallr + ${'totalr'.$dealer_code};echo number_format(${'totalr'.$dealer_code},2)?>
    </strong></div></td>
  </tr>
  <? }


  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="2">&nbsp;</td>
      <td><strong>D Total</strong></td>
<?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format(${'totalc'.$i},2);?></div></td>
<?
}
?>

      <td bgcolor="#FFFF99"><div align="right">
        <?=number_format($totalallr,2);?>
      </div></td>
    </tr>
</table>
<?
}
elseif($_REQUEST['report']==113) 
{echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">CODE</span></td>
    <td bgcolor="#333333"><span class="style3">DEALER NAME </span></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mons'.$i}))?></span></div></td>
<?
}
?>
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
 <?
 


$sql = "select dealer_code,dealer_name_e as dealer_name from dealer_info d, area a where d.area_code=a.AREA_CODE and a.ZONE_ID=".$_REQUEST['zone_id']."  order by dealer_name_e";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$dealer_code = $item->dealer_code;
for($i=12;$i>0;$i--)
{
$m = ($i-1);

$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.dealer_code='".$dealer_code."'".$con;



${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->dealer_code?></td>
    <td><?=$item->dealer_name?></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmon'.$i}[0],2);?></div></td>
<?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
        <? $totalallr= $totalallr + ${'totalr'.$dealer_code};echo number_format(${'totalr'.$dealer_code},2)?>
    </strong></div></td>
  </tr>
  <? }

for($i=12;$i>0;$i--)
{
$m = ($i-1);


$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

${'sqlmonc'.$i} = mysqli_fetch_row(db_query($sqql));
${'totalco'.$i} = ${'totalco'.$i} + ${'sqlmonc'.$i}[0];
${'totalrc1'} = ${'totalrc1'} + ${'sqlmonc'.$i}[0];
}

  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td colspan="2">&nbsp;</td>
      <td><strong>D Total</strong></td>
<?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format(${'totalc'.$i},2);?></div></td>
<?
}
?>

      <td bgcolor="#FFFF99"><div align="right">
        <?=number_format($totalallr,2);?>
      </div></td>
    </tr>
	<?
	  for($i=12;$i>0;$i--)
{
$m = ($i-1);


$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmons'.$i} = mysqli_fetch_row(db_query($sqql));
${'totals'.$i} = ${'totals'.$i} + ${'sqlmons'.$i}[0];
${'totalrc'} = ${'totalrc'} + ${'sqlmons'.$i}[0];
}
	?>
</table>
<?
}
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
$sqlmon = mysqli_fetch_row(db_query("select sum(c.total_amt),sum(c.total_unit),c.pkt_size from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_date."' and '".$t_date."' and d.dealer_type='Distributor' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_id));

//echo "select sum(c.total_amt),sum(c.total_unit),i.pack_size from sale_other_chalan c,dealer_info d, area a where c.chalan_date between '".$f_date."' and '".$t_date."' and d.dealer_type='Distributor' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_id;
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
elseif($_REQUEST['report']==114) 
{echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">DEALER NAME </span></td>
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mons'.$i}))?></span></div></td>
<?
}
?>
   
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
 <?
 


$sql = "select dealer_code,dealer_name_e as dealer_name from dealer_info d, area a where d.area_code=a.AREA_CODE and a.ZONE_ID=".$_REQUEST['zone_id']."  order by dealer_name_e";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$dealer_code = $item->dealer_code;
for($i=12;$i>0;$i--)
{
$m = ($i-1);
$sqql = "select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.dealer_code='".$dealer_code."'".$con;
${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->dealer_name?></td>
	
<?
for($i=12;$i>0;$i--)
{
?>
<td bgcolor="#99CCFF"><div align="right"><?=number_format(${'sqlmon'.$i}[0],0);?></div></td>
<?
}
?>
	
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <?=number_format(${'totalr'.$dealer_code},0)?>
    </strong></div></td>
  </tr>
  <? }
  
  for($i=12;$i>0;$i--)
{
$m = ($i-1);
$sqql = "select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;
${'sqlmonc'.$i} = mysqli_fetch_row(db_query($sqql));
${'totalco'.$i} = ${'totalco'.$i} + ${'sqlmonc'.$i}[0];
${'totalrc1'} = ${'totalrc1'} + ${'sqlmonc'.$i}[0];
}

  ?>
    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
      <td>&nbsp;</td>
      <td><strong>D Total</strong></td>
	  
<?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
<td bgcolor="#FFFF66"><div align="right"><?=number_format(${'totalc'.$i},0);?></div></td>
<?
}
?>

	  
      <td bgcolor="#FFFF99"><div align="right"><?=number_format(${'totald'},0);?></div></td>
    </tr>
	<?
	  for($i=12;$i>0;$i--)
{
$m = ($i-1);
$sqql = "select sum(c.pkt_unit) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;;
${'sqlmons'.$i} = mysqli_fetch_row(db_query($sqql));
${'totals'.$i} = ${'totals'.$i} + ${'sqlmons'.$i}[0];
${'totalrc'} = ${'totalrc'} + ${'sqlmons'.$i}[0];
}
	?>
</table>
<?
}
elseif($_REQUEST['report']==115) 
{echo $str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ExportTable">
  <tr>
    <td bgcolor="#333333"><span class="style3">S/L</span></td>
    <td bgcolor="#333333"><span class="style3">DEALER NAME </span></td>
    <?
for($i=12;$i>0;$i--)
{
?>
    <td bgcolor="#333333"><div align="center"><span class="style3">
      <?=date('M\'y',strtotime(${'f_mons'.$i}))?>
    </span></div></td>
    <?
}
?>
    <td bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></td>
  </tr>
  <?
 


$sql = "select dealer_code,dealer_name_e as dealer_name from dealer_info d, area a where d.area_code=a.AREA_CODE and a.ZONE_ID=".$_REQUEST['zone_id']."  order by dealer_name_e";
if(isset($product_group)) 		{$con=' and d.product_group="'.$product_group.'"';}
if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){

$dealer_code = $item->dealer_code;
for($i=12;$i>0;$i--)
{
$m = ($i-1);

$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.dealer_code='".$dealer_code."'".$con;



${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];
${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'sqlmon'.$i}[0];
}



 ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->dealer_name?></td>
    <?
for($i=12;$i>0;$i--)
{
?>
    <td bgcolor="#99CCFF"><div align="right">
      <?=number_format(${'sqlmon'.$i}[0],2);?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FFFF99"><div align="right"><strong>
      <? 
$totalallr= $totalallr + ${'totalr'.$dealer_code};
echo number_format(${'totalr'.$dealer_code},2);
	  ?>
    </strong></div></td>
  </tr>
  <? }

for($i=12;$i>0;$i--)
{
$m = ($i-1);


$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

${'sqlmonc'.$i} = mysqli_fetch_row(db_query($sqql));
${'totalco'.$i} = ${'totalco'.$i} + ${'sqlmonc'.$i}[0];
${'totalrc1'} = ${'totalrc1'} + ${'sqlmonc'.$i}[0];
}

  ?>
  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td>&nbsp;</td>
    <td><strong>D Total</strong></td>
    <?
for($i=12;$i>0;$i--)
{
${'totald'} = ${'totald'} + ${'totalc'.$i};
?>
    <td bgcolor="#FFFF66"><div align="right">
      <?=number_format(${'totalc'.$i},2);?>
    </div></td>
    <?
}
?>
    <td bgcolor="#FFFF99"><div align="right">
      <?=number_format($totalallr,2);?>
    </div></td>
  </tr>
  <?
	  for($i=12;$i>0;$i--)
{
$m = ($i-1);


$sqql = "select sum(c.total_amt) from sale_other_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;
${'sqlmons'.$i} = mysqli_fetch_row(db_query($sqql));
${'totals'.$i} = ${'totals'.$i} + ${'sqlmons'.$i}[0];
${'totalrc'} = ${'totalrc'} + ${'sqlmons'.$i}[0];
}
	?>
</table>
<?
}
elseif($_REQUEST['report']==1992) 
{echo $str;
$t_date2 = date('Y-m-d',strtotime($t_date . "+1 days"));
$begin = new DateTime($f_date);
$end = new DateTime($t_date2);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$sql = "select sum(c.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='A' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
${'A'.$data->do_date} = $data->total_amt;
}
$sql = "select sum(c.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='B' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
${'B'.$data->do_date} = $data->total_amt;
}
$sql = "select sum(c.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='C' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
${'C'.$data->do_date} = $data->total_amt;
}
$sql = "select sum(c.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.product_group='D' and c.total_amt>0 group by c.do_date";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){${'D'.$data->do_date} = $data->total_amt;}
$sql = "select sum(c.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and (d.dealer_type='Corporate' or d.dealer_type='SuperShop' or (d.dealer_type='Distributor' AND product_group='M')) and c.total_amt>0 group by c.do_date";
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
    <td width="1" bgcolor="#333333"><div align="right"><strong><span class="style5">Total DO<br />
      (A+B+C+D)</span></strong></div></td>
    <td width="1" bgcolor="#333333"><span class="style3">Mordern Trade</span></td>
    <td width="1" bgcolor="#333333"><span class="style3">ALL DO</span></td>
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

elseif($_REQUEST['report']==2000) 
{
if(isset($t_date)) 	
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';
$cdate_con=' and do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and i.sales_item_type="'.$product_group.'"';} 
if($depot_id>0) 				{$dpt_con=' and d.depot="'.$depot_id.'"';} 


$sqlr = "select * from branch";
$queryr = db_query($sqlr);
while($region = mysqli_fetch_object($queryr)){
$region_id = $region->BRANCH_ID;
$sql = "select 
i.finish_goods_code as code,
sum(o.total_unit) as total_unit
from 
sale_other_master m,sale_do_details o, item_info i,dealer_info d, area a, zon z
where o.unit_price>0 and m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') and d.area_code=a.AREA_CODE and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=".$region_id."
".$dtype_con.$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 
group by i.finish_goods_code';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$do_qty[$info->code][$region_id] = $info->total_unit;
}}

if(isset($product_group)) 		{$pg_con=' and i.sales_item_type like "%'.$product_group.'%"';}
		$sql = "select 
		i.finish_goods_code as code, 
		i.item_name, i.item_brand, i.brand_category_type,
		i.sales_item_type as `group`,i.pack_size,i.d_price
		from 
		item_info i
		where i.finish_goods_code>0 and i.finish_goods_code not between 5000 and 6000 and i.finish_goods_code not between 2000 and 3000 ".$item_con.$item_brand_con.$pg_con.' 
		group by i.finish_goods_code';
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable"><thead>
<tr><td style="border:0px;" colspan="15"><?=$str?></td></tr><tr>
<th height="20">S/L</th>
<th>Code</th>
<th>Item Name</th>
<th>Grp</th>
<th>Brand</th>
<th>Sub-Brand</th>
<th>Dhaka</th>
<th>Ctg</th>
<th>Comilla</th>
<th>Sylhet</th>
<th>Mysing</th>
<th>Jessore</th>
<th>Barisal</th>
<th>Bogra</th>
<th>Total</th>
</tr></thead>
<tbody>
<?
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){
$total_item = (int)($do_qty[$info->code][2]/$info->pack_size)+(int)($do_qty[$info->code][3]/$info->pack_size)+(int)($do_qty[$info->code][4]/$info->pack_size)+(int)($do_qty[$info->code][5]/$info->pack_size)+(int)($do_qty[$info->code][1]/$info->pack_size)+(int)($do_qty[$info->code][9]/$info->pack_size)+(int)($do_qty[$info->code][10]/$info->pack_size)+(int)($do_qty[$info->code][8]/$info->pack_size);
if($total_item>0){
?>
<tr><td><?=++$i;?></td>
  <td><?=$info->code;?></td>
  <td><?=$info->item_name;?></td>
  <td><?=$info->group?></td>
  <td><?=$info->item_brand?></td>
  <td style="text-align:center"><?=$info->brand_category_type?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][2]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][3]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][4]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][5]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][1]/$info->pack_size)?></td>
  <td style="text-align:right"><?=(int)($do_qty[$info->code][9]/$info->pack_size)?></td>
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
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?>
</div>
</body>
</html>