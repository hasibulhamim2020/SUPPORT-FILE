<?

session_start();


 

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

if($_REQUEST['item_id']!='') 		    $item_id=$_REQUEST['item_id'];

if($_REQUEST['dealer_code']>0) 	    $dealer_code=$_REQUEST['dealer_code'];

if($_REQUEST['item_mother_group']>0) 	$item_mother_group=$_REQUEST['item_mother_group'];

if($_REQUEST['item_group']>0) 		$item_group=$_REQUEST['item_group'];

if($_REQUEST['item_sub_group']>0) 	$item_sub_group=$_REQUEST['item_sub_group'];

if($_REQUEST['item_type']>0) 		$item_type=$_REQUEST['item_type'];

if($_REQUEST['sales_type']>0) 		$sales_type=$_REQUEST['sales_type'];

if($_REQUEST['status']!='') 		$status=$_REQUEST['status'];

if($_REQUEST['do_no']!='') 		    $do_no=$_REQUEST['do_no'];

if($_REQUEST['area_id']!='') 		$area_id=$_REQUEST['area_id'];

if($_REQUEST['zone_id']!='') 		$zone_id=$_REQUEST['zone_id'];

if($_REQUEST['region_id']>0) 		$region_id=$_REQUEST['region_id'];

if($_REQUEST['depot_id']!='') 		$depot_id=$_REQUEST['depot_id'];

if($_REQUEST['group_for']>0) 		$group_for=$_REQUEST['group_for'];



$item_info = find_all_field('item_info','','item_id='.$item_id);



if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 

if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 

 

if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		

{

if($product_group=='ABCD')

$pg_con=' and d.product_group!="M"';

else

$pg_con=' and d.product_group="'.$product_group.'"';

} 

if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dtype_con=' and d.dealer_type="Distributor"';} else {$dtype_con=' and d.dealer_type!="Distributor"';}}

if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';} else {$dealer_type_con=' and d.dealer_type!="Distributor"';}} 



if(isset($dealer_code)) 		{$dealer_con=' and m.dealer_code='.$dealer_code;} 

if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 

if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 

//if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 

//if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 

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

		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i, area ar, branch b, zon z where ar.ZONE_ID=z.ZONE_CODE and d.area_code=ar.AREA_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  

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

		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i, area ar, branch b, zon z where ar.ZONE_ID=z.ZONE_CODE and d.area_code=ar.AREA_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  

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

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i where 

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

		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i where 

		d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  

	a.unit_price>0  and a.item_id=i.item_id '.$con.$ydate_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 

	group by  a.item_id';

	$sql2='select 

		d.dealer_code,

		sum(a.total_unit) div i.pack_size as pkt,

		sum(a.total_unit) qty,		

		sum(a.total_unit*a.unit_price) as sale_price

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i where 

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

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i, area ar, branch b, zon z 

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

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i , area ar, branch b, zon z  where 

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

    case 1991:



$report="Delivery Order Brief Report with Chalan Amount";

	break;

case 191:

$report="Delivery Order  Report (At A Glance)";

break;

	

    case 2:

		$report="Undelivered Do Details Report";



$sql = "select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,d.product_group as grp,concat(i.finish_goods_code,'- ',item_name) as item_name,o.pkt_unit as crt,o.dist_unit as Kgs,o.total_amt,m.rcv_amt,m.payment_by as PB from 

sale_do_master m,sale_do_details o, item_info i,dealer_info d 

where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$depot_con.$dtype_con.$dealer_con.$item_brand_con;

	break;

	case 3:

$report="Delivered Do Report Dealer Wise";

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

if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 

$report="Delivery Order Brief Report (Region Wise)";

	break;

		case 6:

	if($_REQUEST['do_no']>0)

header("Location:../report/do_view.php?v_no=".$_REQUEST['do_no']);

	break;

	    case 7:

		$report="Item wise DO Report";

		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

		

		$sql = "select 

		i.finish_goods_code as code, 

		i.item_name, i.item_brand, 

		i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as Kgs,

		mod(sum(o.total_unit),o.pkt_size) as crt, 

		sum(o.total_amt)as Dealer_price,

		sum(o.total_unit*o.t_price)as trade_price

		from 

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') and  i.item_brand!='Promotional'  ".$date_con.$item_con.$item_brand_con.$pg_con.' 

		group by i.finish_goods_code';

		break;

		

		case 701:

		$report="Item wise Undelivered DO Report(With Gift)";

		break;

		

		case 7011:

		$report="Item wise Undelivered DO Report(Without Gift)";

		break;

		

		case 8:

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 

$report="Dealer Performance Report";

	    case 9:

		$report="Item Report (Region + Zone)";

if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

		break;

			    case 14:

		$report="Item Report (Region)";

if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

		break;

		

		case 10:

		$report="Daily Collection Summary";

		

$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 

sale_do_master m,dealer_info d 

where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code ".$date_con.$pg_con." order by m.entry_at";

		break;

		

		case 11:

		$report="Daily Collection &amp; Order Summary";

		

$sql="select m.do_no, m.do_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from 

sale_do_master m,dealer_info d  

where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code ".$date_con.$pg_con." order by m.entry_at";

		break;

				case 13:

		$report="Daily Collection Summary(EXT)";

		

$sql="select m.do_no,m.do_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 

sale_do_master m,dealer_info d  

where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code ".$date_con.$pg_con." order by m.entry_at";

		break;

		case 100:

		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 

		$report="Dealer Performance Report";

		break;

		case 101:

		$report="Four(4) Months Comparison Report(CRT)";

		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

		

		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as dP,

		sum(o.total_unit*o.t_price)as tP

		from 

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';

		break;

				case 102:

		$report="Four(4) Months Comparison Report(TK)";

		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

		

		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as dP,

		sum(o.total_unit*o.t_price)as tP

		from 

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

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

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

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

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

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

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

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

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

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
		
		
		
		case 1007:

		$report="MONTH ON MONTH PRODUCT QTY WISE SALES REPORT";

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
		
		
		
		
		case 1008:

		$report="MONTH ON MONTH PRODUCT VALUE WISE SALES REPORT";

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
		
		
		
		case 1009:

		$report="MONTH ON MONTH DISTRIBUTOR WISE SALES REPORT";

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
.style6 {font-weight: bold}
.style7 {font-weight: bold}

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

		if(isset($_SESSION['user']['group'])) 

		$str 	.= '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

		if(isset($report)) 

		$str 	.= '<h2>'.$report.'</h2>';

		if(isset($dealer_code)) 

		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';

		//if(isset($depot_id)) 

		//$str 	.= '<h2>Warehouse: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id).'</h2>';

		if(isset($item_brand)) 

		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';

		if(isset($item_info->item_id)) 

		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';
		
	
		//if(isset($to_date)) 
		

		//$str 	.= '<h2>Date Interval : '.date("d-m-Y",strtotime($fr_date)).' To '.date("d-m-Y",strtotime($to_date)).'</h2>';
		
	

		if(isset($product_group)) 

		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';

		if(isset($region_id)) 

		$str 	.= '<h2>Region Name : '.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id).'</h2>';

		if(isset($zone_id)) 

		$str 	.= '<h2>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id).'</h2>';
		
		if(isset($area_id)) 

		$str 	.= '<h2>Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE='.$area_id).'</h2>';

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

$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,(select AREA_NAME from area where AREA_CODE=d.area_code) as area,d.product_group as grp, m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details from 

sale_do_master m,dealer_info d  

where m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code ".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con." order by m.do_date,m.do_no";

$query = db_query($sql);

echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Do No</th><th>Do Date</th><th>Dealer Name</th><th>Area</th><th>Depot</th><th>Grp</th><th>Rcv Amt</th><th>Payment Details</th><th>DP Total</th><th>TP Total</th></tr></thead>

<tbody>';

while($data=mysqli_fetch_object($query)){$s++;

$sqld = 'select sum(total_amt),sum(t_price*total_unit) from sale_do_details where do_no='.$data->do_no;

$info = mysqli_fetch_row(db_query($sqld));

$rcv_t = $rcv_t+$data->rcv_amt;

$dp_t = $dp_t+$info[0];

$tp_t = $tp_t+$info[1];

?>

<tr><td><?=$s?></td><td><?=$data->do_no?></td><td><?=$data->do_date?></td><td><?=$data->dealer_name?></td><td><?=$data->area?></td><td><?=$data->depot?></td><td><?=$data->grp?></td><td style="text-align:right"><?=$data->rcv_amt?></td><td><?=$data->Payment_Details?></td><td><?=$info[0]?></td><td><?=$info[1]?></td></tr>

<?

}

echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right">'.number_format($rcv_t,2).'</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tp_t,2).'</td></tr></tbody></table>';

}

elseif($_REQUEST['report']==1999) 

{

if(isset($area_id)) 		{$acon.=' and a.AREA_CODE="'.$area_id.'"';}

if(isset($zone_id)) 		{$acon.=' and z.ZONE_CODE="'.$zone_id.'"';}

$sql="select concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,AREA_NAME as area,ZONE_NAME zone, sum(i.t_price*sd.total_unit) do_amt from 

sale_do_master m,dealer_info d  , area a,sale_do_details sd,item_info i, zon z

where a.ZONE_ID=z.ZONE_CODE and m.status in ('CHECKED','COMPLETED') and a.AREA_CODE=d.area_code and m.do_no=sd.do_no and sd.item_id=i.item_id and m.dealer_code=d.dealer_code and  i.finish_goods_code in (102 ,105 ,106 ,109 ,120 ,121 ,123 ,124 ,126 ,127 ,128 ,129 ,130 ,137 ,138 ,139 ,140 ,141 ,142 ,143)".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con.$acon." group by d.dealer_code order by d.dealer_name_e";

$query = db_query($sql);

echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

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



$sqld = 'select m.do_no, sum(c.total_amt) as ch_amt from sale_do_chalan c, sale_do_master m where c.unit_price>0 and m.do_no=c.do_no '.$date_con.$cut_date_con.' group by m.do_no';

$queryd = db_query($sqld);

while($info = mysqli_fetch_object($queryd)){

$do_ch_amt[$info->do_no] = $info->ch_amt;

}



$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,d.product_group as grp, sum(ds.total_amt) as do_amt,m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details from 

sale_do_master m,dealer_info d  , sale_do_details ds

where m.do_no=ds.do_no and m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code  and ds.total_amt>0 ".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con." group by m.do_no order by m.do_date,m.do_no";

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0">

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

$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,(select AREA_NAME from area where AREA_CODE=d.area_code) as area,d.product_group as grp, m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details,d.dealer_code,sum(dl.total_amt) as dp_t,sum(dl.t_price*dl.total_unit) as tp_t from 

sale_do_master m,dealer_info d  , sale_do_details dl

where dl.do_no=m.do_no and m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code ".$depot_con.$date_con.$pg_con.$dealer_con.$dtype_con." group by d.dealer_code order by d.dealer_name_e";

$query = db_query($sql);

echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

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

$sql2 	= "select distinct o.do_no, d.dealer_code,d.dealer_name_e,m.do_date,d.address_e,d.mobile_no,d.team_name from 

sale_do_master m,sale_do_details o, item_info i,dealer_info d

where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED')  ".$date_con.$item_con.$depot_con.$dtype_con.$pg_con.$dealer_con;

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

$str 	.= '<p style="width:100%">Dealer Name: '.$dealer_name.' - '.$dealer_code.'('.$data->team_name.')</p>';

$str 	.= '<p style="width:100%">DO NO: '.$do_no.' 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depot:'.$warehouse_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:'.$do_date.'</p>

<p style="width:100%">Destination:'.$data->address_e.'('.$data->mobile_no.')</p>';



$dealer_con = ' and m.dealer_code='.$dealer_code;

$do_con = ' and m.do_no='.$do_no;

$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,o.pkt_unit as crt,o.dist_unit as pcs,o.total_amt as DP_Total,(o.t_price*o.total_unit) as TP_Total from 

sale_do_master m,sale_do_details o, item_info i,dealer_info d 

where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED')  ".$date_con.$item_con.$depot_con.$dtype_con.$do_con." order by m.do_date desc";

}



	//echo report_create($sql,1,$str);

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead>

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

sale_do_master m,sale_do_details o, item_info i,dealer_info d

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

sale_do_master m, item_info i,dealer_info d,sale_do_chalan c

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

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 

		group by i.finish_goods_code';

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead>

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

sale_do_master m,sale_do_details o, item_info i,dealer_info d

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

sale_do_master m, item_info i,dealer_info d,sale_do_chalan c

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

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where i.finish_goods_code not between 5000 and 6000 and i.finish_goods_code not between 2000 and 3000 and   m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.$dpt_con.' 

		group by i.finish_goods_code';

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead>

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

$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 

sale_do_master m,dealer_info d  , area a

where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by do_no";

$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 

sale_do_master m,dealer_info d  , area a,sale_do_details s

where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and  a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con;



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

$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 

sale_do_master m,dealer_info d  , area a

where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by do_no";

$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 

sale_do_master m,dealer_info d  , area a,sale_do_details s

where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con;



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

sale_do_master m,sale_do_details o, item_info i,  dealer_info d, area a

where m.do_no=o.do_no and m.dealer_code=d.dealer_code  and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' group by i.finish_goods_code';



$sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total

from 

sale_do_master m,sale_do_details o, item_info i,  dealer_info d, area a

where m.do_no=o.do_no and m.dealer_code=d.dealer_code  and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.'';



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

sale_do_master m,sale_do_details o, item_info i, dealer_info d, area a, zon z

where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=".$region_id." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' group by i.finish_goods_code';



 $sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total from 

sale_do_master m,sale_do_details o, item_info i,  dealer_info d, area a, zon z

where m.do_no=o.do_no and m.dealer_code=d.dealer_code  and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=".$region_id." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.'';



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



}elseif($_REQUEST['report']==100) 

{

if(isset($to_date)) 
		
								$str 	.= '<h2>Date Interval : '.date("d-m-Y",strtotime($fr_date)).' To '.date("d-m-Y",strtotime($to_date)).'</h2>';

if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code='.$dealer_code;} 

if(isset($depot_id)) 			{$con=' and d.depot="'.$depot_id.'"';}



if(isset($region_id))			{$con .= " and z.REGION_ID=".$region_id;

								 $str .= '<p style="width:100%">Region Name: '.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id).' Region</p>';}

								 

if(isset($zone_id))				{$con .= " and a.ZONE_ID=".$zone_id;

								 $str .= '<p style="width:100%">Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id).' Zone</p>';}

								 

if(isset($area_id)) 			{$con .= " and a.AREA_CODE=".$area_id;

								 $str .= '<p style="width:100%">Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE='.$area_id).' Area</p>';}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2">

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

  <th>Actual Sales </th>

  </tr>

</thead>

<tbody>

<?

echo $sql="select d.dealer_code, d.dealer_name_e, w.warehouse_name, a.AREA_NAME as area,z.ZONE_NAME as zone,b.BRANCH_NAME as region from 

dealer_info d  , warehouse w,area a,zon z,branch b

where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code ".$pg_con.$con.$dealer_con." ";



$query = db_query($sql);

while($data= mysqli_fetch_object($query)){

$sql_o = 'select sum(o.total_amt) from sale_do_master m, sale_do_details o where m.dealer_code="'.$data->dealer_code.'" and m.do_no=o.do_no and m.status in ("COMPLETED","CHECKED") and m.do_date between "'.$fr_date.'" and "'.$to_date.'"';

$data_o = find_a_field_sql($sql_o);

$sql_d = 'select sum(o.total_amt) from sale_do_master m, sale_do_chalan o where m.dealer_code="'.$data->dealer_code.'" and m.do_no=o.do_no and m.status in ("COMPLETED","CHECKED") and m.do_date between "'.$fr_date.'" and "'.$to_date.'"';

$data_d = find_a_field_sql($sql_d);

$sql_c = 'select sum(o.total_amt) from sale_do_master m, sale_do_chalan o where m.dealer_code="'.$data->dealer_code.'" and m.do_no=o.do_no and m.status in ("COMPLETED","CHECKED") and o.chalan_date between "'.$fr_date.'" and "'.$to_date.'"';

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

  <td><div align="right"><? $diff = ($data_d-$data_sr);echo number_format(($data_d-$data_sr),2)?></div></td>

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

  <td style="text-align:right"><div align="right"><?=number_format($ddiff,2)?></div></td>

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td bgcolor="#333333"><span class="style3">S/L LLLL</span></td>

    <td bgcolor="#333333"><span class="style3">Item Code </span></td>

    <td bgcolor="#333333"><span class="style3">Item Name </span></td>

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

echo $sql = "select i.item_id, i.finish_goods_code as code,i.item_name

from item_info i

where  i.product_nature='Salable' and i.sub_group_id=100020000 ".$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';}

if(isset($depot_id)) 		{$depot_con=' and c.depot_id="'.$depot_id.'"';}

$query = db_query($sql);

while($item=mysqli_fetch_object($query)){



$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.total_unit), c.unit_price from sale_do_chalan c, dealer_info d, warehouse w where d.dealer_code=c.dealer_code and c.depot_id=w.warehouse_id  and c.unit_price>0 and c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.item_id=".$item->item_id.$pg_con.$depot_con));



$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.total_unit), c.unit_price from sale_do_chalan c, dealer_info d, warehouse w where d.dealer_code=c.dealer_code and c.depot_id=w.warehouse_id and c.unit_price>0 and c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.item_id=".$item->item_id.$pg_con.$depot_con));



$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.total_unit), c.unit_price from sale_do_chalan c, dealer_info d, warehouse w where d.dealer_code=c.dealer_code and c.depot_id=w.warehouse_id and  c.unit_price>0 and c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.item_id=".$item->item_id.$pg_con.$depot_con));



$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.total_unit), c.unit_price from sale_do_chalan c, dealer_info d, warehouse w where d.dealer_code=c.dealer_code  and c.depot_id=w.warehouse_id and c.unit_price>0 and c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.item_id=".$item->item_id.$pg_con.$depot_con));



$sqlmon = ((($sqlmon0[0])*date('t'))/$t_array[2]);

$diff = ($sqlmon-$sqlmon1[0]);





 ?>

  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">

    <td><?=++$i?></td>

    <td><?=$item->code?></td>

    <td><?=$item->item_name?></td>

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';}

	$query = db_query($sql);

	while($item=mysqli_fetch_object($query)){

$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.item_id=".$item->item_id.$pg_con));

$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.item_id=".$item->item_id.$pg_con));

$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.item_id=".$item->item_id.$pg_con));

$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c, dealer_info d where d.dealer_code=c.dealer_code and c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.item_id=".$item->item_id.$pg_con));



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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';}



echo "select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con;

$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));







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

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="9"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>



<tr><th rowspan="2">S/L</th><th rowspan="2">Fg</th><th rowspan="2">Item Name</th><th rowspan="2">Unit</th><th rowspan="2">Brand</th><th rowspan="2">Pack Size</th><th rowspan="2">GRP</th>

  <th colspan="3" bgcolor="#FFCCFF"><div align="center">Last Year </div></th>

  <th colspan="3" bgcolor="#FFFF99"><div align="center">This Year </div></th>

<th>Growth</th>

</tr>

<tr>

  <th>Sale Pkt</th>

  <th>Sale Qty </th>

  <th>Sale Amt </th>

  <th>Sale Pkt </th>

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

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="9"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>



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

  <th>in % </th>

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

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead>

    <tr><td style="border:0px;" colspan="6"><?=$str?><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr>

    <tr><th rowspan="2">S/L</th>

    <th rowspan="2">Code</th>

    <th rowspan="2">Region</th><th colspan="3" bgcolor="#FFCCFF"><div align="center">Last Year </div></th>

  <th colspan="3" bgcolor="#FFFF99"><div align="center">This Year </div></th>

<th>Growth</th>

</tr>

<tr>

  <th>Sale Ctnss</th>

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

  </strong></td><td bgcolor="#EAEAEA">&nbsp;</td>

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';}

	$query = db_query($sql);

	while($item=mysqli_fetch_object($query)){

 $zone_code = $item->ZONE_CODE;

$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c,dealer_info d, area a where c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.dealer_code=d.dealer_code and d.area_code=a.AREA_CODE and a.ZONE_ID='".$zone_code."' and c.item_id=".$item_info->item_id.$pg_con));







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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';}

	$query = db_query($sql);

	while($item=mysqli_fetch_object($query)){

 $zone_code = $item->ZONE_CODE;

$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));







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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';}

$query = db_query($sql);

while($item=mysqli_fetch_object($query)){



$zone_code = $item->ZONE_CODE;

$sqlmon0 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_mons0."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon1 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_mons1."' and '".$f_mone1."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon2 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_mons2."' and '".$f_mone2."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));



$sqlmon3 = mysqli_fetch_row(db_query("select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".$f_mons3."' and '".$f_mone3."' and c.dealer_code=d.dealer_code and d.dealer_code='".$item->dealer_code."' and c.item_id=".$item_info->item_id.$pg_con));







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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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



$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;







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





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;



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





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;

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






elseif($_REQUEST['report']==1007) 

{

echo $str;

$pd = date("ym",strtotime(${'f_mos1'}));
if(($pd-2000)>12)
$v = 12;
else $v = $pd-2000;

//$datee=date('m');
//
//if($datee==31){
//$v;
//}
//else if($datee==30){
//$v;
//}
//else{
//$v=$v-1;
//}
?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">


<thead>
<tr>
<th bgcolor="#333333"><span class="style3">S/L</span></th>
<th bgcolor="#333333"><span class="style3">ITEM NAME </span></th>
<th bgcolor="#333333"><span class="style3">SKU Code </span></th>
<?
for($i=$v;$i>0;$i--)
{
?>
<th bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mos'.$i}))?></span></div></th>
<?
}
?>
<th bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></th>
</tr>
</thead>
<?




if(isset($group_for)) 		{$group_for_con=' and group_for="'.$group_for.'"';}

//order by item_description,item_id
echo $sql = "select * from item_info where product_nature='Salable' and item_id NOT LIKE '9%' ".$group_for_con." order by sub_group_id,item_id" ;

if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
if(isset($depot_id)) 		{$con=' and c.depot_id="'.$depot_id.'"';}
if(isset($dealer_code)) 	{$con=' and c.dealer_code="'.$dealer_code.'"';}
if(isset($region_id)) 		{$con=' and r.BRANCH_ID="'.$region_id.'"';}
if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
if(isset($area_id)) 		{$con=' and d.area_code="'.$area_id.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){
$item_id = $item->item_id;

$category=$new_cat=$item->sub_group_id;


for($i=$v;$i>0;$i--)
{
$m = ($i-1);

 $sqql = "select sum(c.total_unit) from sale_do_chalan c, dealer_info d, zon z where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code 
and c.unit_price>0 and z.ZONE_CODE=d.zone_code and  c.item_id='".$item_id."'".$con;
${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'mon'.$i} = 'op_'.date("ym",strtotime(${'f_mons'.$i}));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];

${'totalr'.$item_id} = ${'totalr'.$item_id} + ${'sqlmon'.$i}[0];
}





if($old_cat!=$new_cat&&$old_cat!=''){
?>

<tr bgcolor="#<? echo 'eeeeee';?>">
<td colspan='3' style="text-align:right; text-transform:uppercase;">Total <?= find_a_field('item_sub_group','sub_group_name','sub_group_id='.$old_cat);?></td>
<?
for($i=$v;$i>0;$i--)
{
?>
    <td bgcolor="#eeeeee"><div align="right"><?=$cat_total[$old_cat][$i];?></div></td>
<?
$cat_total_r[$old_cat]=$cat_total_r[$old_cat]+$cat_total[$old_cat][$i];
}
?>

<td bgcolor="#eee"><div align="right"><strong><? $totalallr= $totalallr + ${'totalr'.$item_id};echo $cat_total_r[$old_cat];?></strong></div></td>
</tr>
<?   
}
 ?>



<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->item_name?></td>
	<td><?=$item->sku_code?></td>
	<?
for($i=$v;$i>0;$i--)
{
    if(${'sqlmon'.$i}[0]==0&&$item->{${'mon'.$i}}!=0) ${'sqlmon'.$i}[0] = $item->{${'mon'.$i}};
?>
<td bgcolor="#99CCFF"><div align="right"><?=(int)(${'sqlmon'.$i}[0]);?></div></td>
<?
$cat_total[$new_cat][$i] = $cat_total[$new_cat][$i] + ${'sqlmon'.$i}[0];
}
?>
<td bgcolor="#FFFF99"><div align="right"><strong><? $totalallr= $totalallr + ${'totalr'.$item_id};echo ${'totalr'.$item_id}?></strong></div></td>
</tr>
<? 
$old_cat = $new_cat;
}

?>
<tr bgcolor="#<? echo 'eeeeee';?>">
<td colspan='3' style="text-align:right;"><div align="right">Total 
  <?=$old_cat;?>
</div></td>
<?
for($i=$v;$i>0;$i--)
{
?>
    <td bgcolor="#eeeeee"><div align="right"><?=$cat_total[$old_cat][$i];?></div></td>
    
<?
$cat_total_r[$old_cat]=$cat_total_r[$old_cat]+$cat_total[$old_cat][$i];
}
?>
<td bgcolor="#eee"><div align="right"><strong><? $totalallr= $totalallr + ${'totalr'.$item_id};echo $cat_total_r[$old_cat];?></strong></div></td>
</tr>


    <tr bgcolor="#FFFF66">
<td><div align="right"></div></td>
<td><div align="right"></div></td>
<td><div align="right">Grand Total</div></td>
      <?
for($i=$v;$i>0;$i--)
    {
    ${'totald'} = ${'totald'} + ${'totalc'.$i};
    ?>
        <td bgcolor="#FFFF66"><div align="right"><span class="style6"><?=$totallm=number_format(${'totalc'.$i});?></span></div></td>
    <?
    }
?>
        <td bgcolor="#FF3333"><div align="right"><span class="style7"><?=number_format($totalallr,2);?></span></div></td>
    </tr>
</table>



<?



}



elseif($_POST['report']=='3333'){
			
		?>
       <table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>MONTHLY DEALER WISE SALES REPORT (PRODUCT VALUE)</strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   
	   
         
		 
		 
		 
       </table>
        <table width="100%" cellspacing="0" cellpadding="0" border="1" bordercolor="#000000" >
      <thead>
	  <?
	  
	  	if(isset($group_for)) 					{$group_for_con=' and b.group_for="'.$group_for.'"';}
		if(isset($zone_id)) 					{$zone_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
	  

	  $f_date = $_POST['f_date'];
	  $t_date = $_POST['t_date'];
	  $fs_date = strtotime($_POST['f_date']);
	  $ts_date = strtotime($_POST['t_date']);
	  $ets_date= strtotime(date('Y-m-t',$ts_date));
	  for($t = 1; $t<30;$t++)
	  {
	  if($t == 1){$period_name[$t] = date('F',$fs_date); $period[$t] = date('Ym',$fs_date);		$mm_date = strtotime(date('Y-m-15',$fs_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  else {$period_name[$t] = date('F',$mm_date);		$period[$t] = date('Ym',$mm_date); 		$mm_date = strtotime(date('Y-m-15',$mm_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  if($nm_date>$ets_date) break;
	  }
	  
	           $year_sql = 'select year(a.chalan_date) yr, month(a.chalan_date) mon, sum(a.total_amt) as total_amt,b.dealer_code,c.zone_code, z.ZONE_NAME from sale_do_chalan a, sale_do_master b, dealer_info c, zon z,  item_info i, item_sub_group s, item_group g where 
 i.item_id=a.item_id and s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id and a.do_no = b.do_no and b.dealer_code = c.dealer_code and c.zone_code=z.ZONE_CODE and
a.chalan_date BETWEEN  "'.$_POST['f_date'].'" AND "'.$_POST['t_date'].'" and g.product_type="Finish Goods"
'.$group_for_con.$zone_con.$item_sub_con.$item_group_con.$item_mother_group_con.$item_type_con.'  group by c.dealer_code, month(a.chalan_date), year(a.chalan_date) order by a.chalan_date';

	   	$year_query = db_query($year_sql );
		while($value = mysqli_fetch_object($year_query)){
		
		
			$value->mon = sprintf("%02d", $value->mon);
			 $pr = $value->yr.$value->mon;
			
		    $val[$value->dealer_code][$pr] = $value->total_amt;
			
		    $dealer_total[$value->dealer_code] = $dealer_total[$value->dealer_code] + $value->total_amt;
			
		    $mon_total[$pr] = $mon_total[$pr] + $value->total_amt;
			
		    $zone_total[$value->zone_code][$pr] = $zone_total[$value->zone_code][$pr] +  $value->total_amt;
			
			$zone_gtotal[$value->zone_code] = $zone_gtotal[$value->zone_code] +  $value->total_amt;
			$all_total = $all_total +  $value->total_amt;
			
		}
         
	  ?>
        <tr>
        <td bgcolor="#82D8CF"><strong>SL</strong></td>
        <td bgcolor="#82D8CF"><strong>Customer Name</strong></td>
        <? for($i=1;$i<=$t;$i++){ ?><td bgcolor="#82D8CF"><strong><?=$period_name[$i].'-'.substr($period[$i],2,2)?></strong></td> 
        <? }?> 
        <td bgcolor="#82D8CF"><strong>Total Amt</strong></td>
        </tr>
		
		

        </thead>
        <?
        
		$sql_101 = 'select d.dealer_code, d.dealer_name_e, z.ZONE_CODE zone_code, z.ZONE_NAME zone_name from dealer_info d, zon z where d.zone_code=z.ZONE_CODE '.$zone_con.' order by d.zone_code';
	   	$query_101 = db_query($sql_101 );
		$sl = 1 ;
		while($r = mysqli_fetch_object($query_101)){
		
		
		if(($old_zone_code != $r->zone_code)&&$old_zone_code >0)
		{
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2" style="text-transform:uppercase">Total <?=$old_zone_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($zone_total[$old_zone_code][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($zone_gtotal[$old_zone_code],2);?></strong></td>
        </tr>
		<?
		}
        ?>
        <tr>
          <td><?=$sl++?></td>
        <td><?=$r->dealer_name_e;?></td>
        <? for($i=1;$i<=$t;$i++){ 
		?><td><?=number_format($val[$r->dealer_code][$period[$i]],2);?></td> <? }?> 
        

        <td><?=number_format($dealer_total[$r->dealer_code],2);?></td>

        </tr>
        <?
		$old_zone_code = $r->zone_code;
		$old_zone_name = $r->zone_name;
	    }
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2"  style="text-transform:uppercase">Total <?=$old_zone_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($zone_total[$old_zone_code][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($zone_gtotal[$old_zone_code],2);?></strong></td>
        </tr>
		<tr>
        <td colspan="2" style="font-weight:700; font-size:10px;">GRAND TOTAL</td>
        <? for($i=1;$i<=$t;$i++){ ?><td><strong><?  echo number_format($mon_total[$period[$i]],2);?></strong></td> <? }?> 
		<td><strong><?=number_format($all_total,2);?></strong></td>
        </tr>

</table>
        <? 	}







elseif($_POST['report']=='333311'){
			
		?>
       <table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>MONTHLY DEALER WISE SALES REPORT (PRODUCT QUANTITY)</strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		
  <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   
        
       </table>
        <table width="100%" cellspacing="0" cellpadding="0" border="1" bordercolor="#000000" >
      <thead>
	  <?
	  
	  	if(isset($group_for)) 					{$group_for_con=' and b.group_for="'.$group_for.'"';}
		if(isset($zone_id)) 					{$zone_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}

	  

	  $f_date = $_POST['f_date'];
	  $t_date = $_POST['t_date'];
	  $fs_date = strtotime($_POST['f_date']);
	  $ts_date = strtotime($_POST['t_date']);
	  $ets_date= strtotime(date('Y-m-t',$ts_date));
	  for($t = 1; $t<30;$t++)
	  {
	  if($t == 1){$period_name[$t] = date('F',$fs_date); $period[$t] = date('Ym',$fs_date);		$mm_date = strtotime(date('Y-m-15',$fs_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  else {$period_name[$t] = date('F',$mm_date);		$period[$t] = date('Ym',$mm_date); 		$mm_date = strtotime(date('Y-m-15',$mm_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  if($nm_date>$ets_date) break;
	  }
	  
	           $year_sql = 'select year(a.chalan_date) yr, month(a.chalan_date) mon, sum(a.total_unit) as total_amt,b.dealer_code,c.zone_code from sale_do_chalan a, sale_do_master b, dealer_info c, zon z,  item_info i, item_sub_group s, item_group g  where 
 i.item_id=a.item_id and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and a.do_no = b.do_no and b.dealer_code = c.dealer_code and c.zone_code=z.ZONE_CODE and
a.chalan_date BETWEEN  "'.$_POST['f_date'].'" AND "'.$_POST['t_date'].'" and g.product_type="Finish Goods"
 '.$group_for_con.$zone_con.$item_sub_con.$item_group_con.$item_mother_group_con.$item_type_con.'  group by c.dealer_code, month(a.chalan_date), year(a.chalan_date) order by a.chalan_date';

	   	$year_query = db_query($year_sql );
		while($value = mysqli_fetch_object($year_query)){
		
		
			$value->mon = sprintf("%02d", $value->mon);
			 $pr = $value->yr.$value->mon;
			
		    $val[$value->dealer_code][$pr] = $value->total_amt;
			
		    $dealer_total[$value->dealer_code] = $dealer_total[$value->dealer_code] + $value->total_amt;
			
		    $mon_total[$pr] = $mon_total[$pr] + $value->total_amt;
			
		    $zone_total[$value->zone_code][$pr] = $zone_total[$value->zone_code][$pr] +  $value->total_amt;
			
			$zone_gtotal[$value->zone_code] = $zone_gtotal[$value->zone_code] +  $value->total_amt;
			$all_total = $all_total +  $value->total_amt;
			
		}
         
	  ?>
        <tr>
        <td bgcolor="#82D8CF"><strong>SL</strong></td>
        <td bgcolor="#82D8CF"><strong>Customer Name</strong></td>
        <? for($i=1;$i<=$t;$i++){ ?><td bgcolor="#82D8CF"><strong><?=$period_name[$i].'-'.substr($period[$i],2,2)?></strong></td> 
        <? }?> 
        <td bgcolor="#82D8CF"><strong>Total Qty</strong></td>
        </tr>

        </thead>
        <?
        
		$sql_101 = 'select d.dealer_code, d.dealer_name_e, z.ZONE_CODE zone_code, z.ZONE_NAME zone_name from dealer_info d, zon z where d.zone_code=z.ZONE_CODE '.$zone_con.' order by d.zone_code';
	   	$query_101 = db_query($sql_101 );
		$sl = 1 ;
		while($r = mysqli_fetch_object($query_101)){
		
		
		if(($old_zone_code != $r->zone_code)&&$old_zone_code >0)
		{
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2" style="text-transform:uppercase">Total <?=$old_zone_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($zone_total[$old_zone_code][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($zone_gtotal[$old_zone_code],2);?></strong></td>
        </tr>
		<?
		}
        ?>
        <tr>
          <td><?=$sl++?></td>
        <td><?=$r->dealer_name_e;?></td>
        <? for($i=1;$i<=$t;$i++){ 
		?><td><?=number_format($val[$r->dealer_code][$period[$i]],2);?></td> <? }?> 
        

        <td><?=number_format($dealer_total[$r->dealer_code],2);?></td>

        </tr>
        <?
		$old_zone_code = $r->zone_code;
		$old_zone_name = $r->zone_name;
	    }
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2"  style="text-transform:uppercase">Total <?=$old_zone_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($zone_total[$old_zone_code][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($zone_gtotal[$old_zone_code],2);?></strong></td>
        </tr>
		<tr>
        <td colspan="2" style="font-weight:700; font-size:10px;">GRAND TOTAL</td>
        <? for($i=1;$i<=$t;$i++){ ?><td><strong><?  echo number_format($mon_total[$period[$i]],2);?></strong></td> <? }?> 
		<td><strong><?=number_format($all_total,2);?></strong></td>
        </tr>

</table>
        <? 	}











elseif($_POST['report']=='333333'){


		$dealer_name = $_POST['dealer_code'];
 		$dealer=explode("-",$dealer_name);
 		$dealer[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con=" and b.dealer_code=".$dealer[0];
			
		?>
       <table width="100%">
	   <tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>MONTHLY PRODUCT VALUE WISE SALES REPORT</strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   
         
		 
		 
		 
       </table>
        <table width="100%" cellspacing="0" cellpadding="0" border="1" bordercolor="#000000" >
      <thead>
	  <?
	  
	  	if(isset($group_for)) 					{$group_for_con=' and b.group_for="'.$group_for.'"';}
		if(isset($zone_id)) 					{$zone_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	  

	  $f_date = $_POST['f_date'];
	  $t_date = $_POST['t_date'];
	  $fs_date = strtotime($_POST['f_date']);
	  $ts_date = strtotime($_POST['t_date']);
	  $ets_date= strtotime(date('Y-m-t',$ts_date));
	  for($t = 1; $t<30;$t++)
	  {
	  if($t == 1){$period_name[$t] = date('F',$fs_date); $period[$t] = date('Ym',$fs_date);		$mm_date = strtotime(date('Y-m-15',$fs_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  else {$period_name[$t] = date('F',$mm_date);		$period[$t] = date('Ym',$mm_date); 		$mm_date = strtotime(date('Y-m-15',$mm_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  if($nm_date>$ets_date) break;
	  }
	  
	           $year_sql = 'select year(a.chalan_date) yr, month(a.chalan_date) mon, sum(a.total_amt) as total_amt, i.item_id, s.sub_group_id from 
			   sale_do_chalan a, sale_do_master b, dealer_info c, zon z,  item_info i, item_sub_group s, item_group g where 
 i.item_id=a.item_id and a.do_no = b.do_no and b.dealer_code = c.dealer_code and c.zone_code=z.ZONE_CODE and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and
a.chalan_date BETWEEN  "'.$_POST['f_date'].'" AND "'.$_POST['t_date'].'"
'.$group_for_con.$zone_con.$item_sub_con.$dealer_con.$item_group_con.$item_mother_group_con.$item_type_con.'  group by a.item_id, month(a.chalan_date), year(a.chalan_date)';

	   	$year_query = db_query($year_sql );
		while($value = mysqli_fetch_object($year_query)){
		
		
			$value->mon = sprintf("%02d", $value->mon);
			 $pr = $value->yr.$value->mon;
			
		    $val[$value->item_id][$pr] = $value->total_amt;
			
		    $item_total[$value->item_id] = $item_total[$value->item_id] + $value->total_amt;
			
		    $mon_total[$pr] = $mon_total[$pr] + $value->total_amt;
			
		    $sub_group_total[$value->sub_group_id][$pr] = $sub_group_total[$value->sub_group_id][$pr] +  $value->total_amt;
			
			$sub_group_gtotal[$value->sub_group_id] = $sub_group_gtotal[$value->sub_group_id] +  $value->total_amt;
			$all_total = $all_total +  $value->total_amt;
			
		}
         
	  ?>
        <tr>
        <td bgcolor="#82D8CF"><strong>SL</strong></td>
        <td bgcolor="#82D8CF"><strong>Product Name</strong></td>
        <? for($i=1;$i<=$t;$i++){ ?><td bgcolor="#82D8CF"><strong><?=$period_name[$i].'-'.substr($period[$i],2,2)?></strong></td> 
        <? }?> 
        <td bgcolor="#82D8CF"><strong>Total Amt</strong></td>
        </tr>

        </thead>
        <?
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for="'.$group_for.'"';}
		}
		
		
        
		 $sql_101 = 'select i.item_id, i.item_name, s.sub_group_id, s.sub_group_name from item_info i, item_sub_group s, item_group g where i.sub_group_id=s.sub_group_id 
		and s.group_id=g.group_id '.$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con.' 
		order by  s.group_for, s.sub_group_id,  i.item_id, i.item_name ';
	   	$query_101 = db_query($sql_101 );
		$sl = 1 ;
		while($r = mysqli_fetch_object($query_101)){
		
		
		if(($old_sub_group_id != $r->sub_group_id)&&$old_sub_group_id >0)
		{
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2" style="text-transform:uppercase">Total <?=$old_sub_group_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($sub_group_total[$old_sub_group_id][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($sub_group_gtotal[$old_sub_group_id],2);?></strong></td>
        </tr>
		<?
		}
        ?>
        <tr>
          <td><?=$sl++?></td>
        <td><?=$r->item_name;?></td>
        <? for($i=1;$i<=$t;$i++){ 
		?><td><?=number_format($val[$r->item_id][$period[$i]],2);?></td> <? }?> 
        

        <td><?=number_format($item_total[$r->item_id],2);?></td>

        </tr>
        <?
		$old_sub_group_id = $r->sub_group_id;
		$old_sub_group_name = $r->sub_group_name;
	    }
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2"  style="text-transform:uppercase">Total <?=$old_sub_group_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($sub_group_total[$old_sub_group_id][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($sub_group_gtotal[$old_sub_group_id],2);?></strong></td>
        </tr>
		<tr>
        <td colspan="2" style="font-weight:700; font-size:10px;">GRAND TOTAL</td>
        <? for($i=1;$i<=$t;$i++){ ?><td><strong><?  echo number_format($mon_total[$period[$i]],2);?></strong></td> <? }?> 
		<td><strong><?=number_format($all_total,2);?></strong></td>
        </tr>

</table>
        <? 	}







elseif($_POST['report']=='33333311'){

		$dealer_name = $_POST['dealer_code'];
 		$dealer=explode("-",$dealer_name);
 		$dealer[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con=" and b.dealer_code=".$dealer[0];
			
		?>
       <table width="100%">
	   <tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>MONTHLY PRODUCT QTY WISE SALES REPORT</strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	   
     
       </table>
        <table width="100%" cellspacing="0" cellpadding="0" border="1" bordercolor="#000000" >
      <thead>
	  <?
	  
	  	if(isset($group_for)) 					{$group_for_con=' and b.group_for="'.$group_for.'"';}
		if(isset($zone_id)) 					{$zone_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
	
	  

	  $f_date = $_POST['f_date'];
	  $t_date = $_POST['t_date'];
	  $fs_date = strtotime($_POST['f_date']);
	  $ts_date = strtotime($_POST['t_date']);
	  $ets_date= strtotime(date('Y-m-t',$ts_date));
	  for($t = 1; $t<30;$t++)
	  {
	  if($t == 1){$period_name[$t] = date('F',$fs_date); $period[$t] = date('Ym',$fs_date);		$mm_date = strtotime(date('Y-m-15',$fs_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  else {$period_name[$t] = date('F',$mm_date);		$period[$t] = date('Ym',$mm_date); 		$mm_date = strtotime(date('Y-m-15',$mm_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  if($nm_date>$ets_date) break;
	  }
	  
	           $year_sql = 'select year(a.chalan_date) yr, month(a.chalan_date) mon, sum(a.total_unit) as total_amt, i.item_id, s.sub_group_id from 
			   sale_do_chalan a, sale_do_master b, dealer_info c, zon z,  item_info i, item_sub_group s, item_group g where 
 i.item_id=a.item_id and a.do_no = b.do_no and b.dealer_code = c.dealer_code and c.zone_code=z.ZONE_CODE and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and
a.chalan_date BETWEEN  "'.$_POST['f_date'].'" AND "'.$_POST['t_date'].'" and g.product_type="Finish Goods"
'.$group_for_con.$zone_con.$item_sub_con.$dealer_con.$item_group_con.$item_mother_group_con.$item_type_con.'  group by a.item_id, month(a.chalan_date), year(a.chalan_date) order by a.chalan_date';

	   	$year_query = db_query($year_sql );
		while($value = mysqli_fetch_object($year_query)){
		
		
			$value->mon = sprintf("%02d", $value->mon);
			 $pr = $value->yr.$value->mon;
			
		    $val[$value->item_id][$pr] = $value->total_amt;
			
		    $item_total[$value->item_id] = $item_total[$value->item_id] + $value->total_amt;
			
		    $mon_total[$pr] = $mon_total[$pr] + $value->total_amt;
			
		    $sub_group_total[$value->sub_group_id][$pr] = $sub_group_total[$value->sub_group_id][$pr] +  $value->total_amt;
			
			$sub_group_gtotal[$value->sub_group_id] = $sub_group_gtotal[$value->sub_group_id] +  $value->total_amt;
			$all_total = $all_total +  $value->total_amt;
			
		}
         
	  ?>
        <tr>
        <td bgcolor="#82D8CF"><strong>SL</strong></td>
        <td bgcolor="#82D8CF"><strong>Product Name</strong></td>
        <? for($i=1;$i<=$t;$i++){ ?><td bgcolor="#82D8CF"><strong><?=$period_name[$i].'-'.substr($period[$i],2,2)?></strong></td> 
        <? }?> 
        <td bgcolor="#82D8CF"><strong>Total Qty</strong></td>
        </tr>

        </thead>
        <?
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for="'.$group_for.'"';}
		}
		
		
        
		 $sql_101 = 'select i.item_id, i.item_name, s.sub_group_id, s.sub_group_name from item_info i, item_sub_group s , item_group g where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id
		 '.$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con.' and g.product_type="Finish Goods" order by  s.group_for, s.sub_group_sl, i.item_type, i.item_id, i.item_name ';
	   	$query_101 = db_query($sql_101 );
		$sl = 1 ;
		while($r = mysqli_fetch_object($query_101)){
		
		
		if(($old_sub_group_id != $r->sub_group_id)&&$old_sub_group_id >0)
		{
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2" style="text-transform:uppercase">Total <?=$old_sub_group_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($sub_group_total[$old_sub_group_id][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($sub_group_gtotal[$old_sub_group_id],2);?></strong></td>
        </tr>
		<?
		}
        ?>
        <tr>
          <td><?=$sl++?></td>
        <td><?=$r->item_name;?></td>
        <? for($i=1;$i<=$t;$i++){ 
		?><td><?=number_format($val[$r->item_id][$period[$i]],2);?></td> <? }?> 
        

        <td><?=number_format($item_total[$r->item_id],2);?></td>

        </tr>
        <?
		$old_sub_group_id = $r->sub_group_id;
		$old_sub_group_name = $r->sub_group_name;
	    }
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2"  style="text-transform:uppercase">Total <?=$old_sub_group_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($sub_group_total[$old_sub_group_id][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($sub_group_gtotal[$old_sub_group_id],2);?></strong></td>
        </tr>
		<tr>
        <td colspan="2" style="font-weight:700; font-size:10px;">GRAND TOTAL</td>
        <? for($i=1;$i<=$t;$i++){ ?><td><strong><?  echo number_format($mon_total[$period[$i]],2);?></strong></td> <? }?> 
		<td><strong><?=number_format($all_total,2);?></strong></td>
        </tr>

</table>
        <? 	}








elseif($_POST['report']=='33333322'){

		$dealer_name = $_POST['dealer_code'];
 		$dealer=explode("-",$dealer_name);
 		$dealer[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con=" and b.dealer_code=".$dealer[0];
			
		?>
       <table width="100%">
	   <tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>MONTHLY PRODUCT GROUP WISE SALES REPORT (PRODUCT VALUE)</strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		    <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		   <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	 
       </table>
        <table width="100%" cellspacing="0" cellpadding="0" border="1" bordercolor="#000000" >
      <thead>
	  <?
	  
	  	if(isset($group_for)) 					{$group_for_con=' and b.group_for="'.$group_for.'"';}
		if(isset($zone_id)) 					{$zone_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		
		if(isset($item_group)) 						{$item_group_con=' and s.group_id="'.$item_group.'"';}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
	  

	  $f_date = $_POST['f_date'];
	  $t_date = $_POST['t_date'];
	  $fs_date = strtotime($_POST['f_date']);
	  $ts_date = strtotime($_POST['t_date']);
	  $ets_date= strtotime(date('Y-m-t',$ts_date));
	  for($t = 1; $t<30;$t++)
	  {
	  if($t == 1){$period_name[$t] = date('F',$fs_date); $period[$t] = date('Ym',$fs_date);		$mm_date = strtotime(date('Y-m-15',$fs_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  else {$period_name[$t] = date('F',$mm_date);		$period[$t] = date('Ym',$mm_date); 		$mm_date = strtotime(date('Y-m-15',$mm_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  if($nm_date>$ets_date) break;
	  }
	  
	            $year_sql = 'select year(a.chalan_date) yr, month(a.chalan_date) mon, sum(a.total_amt) as total_amt, i.item_id, s.sub_group_id, g.group_id from 
			   sale_do_chalan a, sale_do_master b, dealer_info c, zon z,  item_info i, item_sub_group s, item_group g where 
 i.item_id=a.item_id and a.do_no = b.do_no and b.dealer_code = c.dealer_code and c.zone_code=z.ZONE_CODE and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and
a.chalan_date BETWEEN  "'.$_POST['f_date'].'" AND "'.$_POST['t_date'].'" and g.product_type="Finish Goods"
'.$group_for_con.$zone_con.$item_sub_con.$dealer_con.$item_group_con.$item_mother_group_con.$item_type_con.'  group by s.sub_group_id, month(a.chalan_date), year(a.chalan_date) order by s.sub_group_id';

	   	$year_query = db_query($year_sql );
		while($value = mysqli_fetch_object($year_query)){
		
		
			$value->mon = sprintf("%02d", $value->mon);
			 $pr = $value->yr.$value->mon;
			
		    $val[$value->sub_group_id][$pr] = $value->total_amt;
			
		    $item_total[$value->sub_group_id] = $item_total[$value->sub_group_id] + $value->total_amt;
			
		    $mon_total[$pr] = $mon_total[$pr] + $value->total_amt;
			
		    $sub_group_total[$value->group_id][$pr] = $sub_group_total[$value->group_id][$pr] +  $value->total_amt;
			
			$sub_group_gtotal[$value->group_id] = $sub_group_gtotal[$value->group_id] +  $value->total_amt;
			$all_total = $all_total +  $value->total_amt;
			
		}
         
	  ?>
        <tr>
        <td bgcolor="#82D8CF"><strong>SL</strong></td>
        <td bgcolor="#82D8CF"><strong>Product Group</strong></td>
        <? for($i=1;$i<=$t;$i++){ ?><td bgcolor="#82D8CF"><strong><?=$period_name[$i].'-'.substr($period[$i],2,2)?></strong></td> 
        <? }?> 
        <td bgcolor="#82D8CF"><strong>Total Amt</strong></td>
        </tr>

        </thead>
        <?
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and s.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and s.group_for="'.$group_for.'"';}
		}
		
		if(isset($item_group)) 						{$item_group_con=' and s.group_id="'.$item_group.'"';}
		
        
		  $sql_101 = 'select i.item_id, i.item_name, s.sub_group_id, s.sub_group_name, s.sub_group_sl, g.group_id, g.group_name from item_info i, item_sub_group s, item_group g 
		 where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id '.$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con.' and g.product_type="Finish Goods" 
		 group by s.sub_group_id,g.group_id order by  g.group_for, g.item_group_sl, s.group_for, s.sub_group_sl ';
	   	$query_101 = db_query($sql_101 );
		$sl = 1 ;
		while($r = mysqli_fetch_object($query_101)){
		
		
		if(($old_sub_group_id != $r->group_id)&&$old_sub_group_id >0)
		{
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2" style="text-transform:uppercase">Total <?=$old_sub_group_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($sub_group_total[$old_sub_group_id][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($sub_group_gtotal[$old_sub_group_id],2);?></strong></td>
        </tr>
		<?
		}
        ?>
        <tr>
          <td><?=$sl++?></td>
        <td><?=$r->sub_group_name;?></td>
        <? for($i=1;$i<=$t;$i++){ 
		?><td><?=number_format($val[$r->sub_group_id][$period[$i]],2);?></td> <? }?> 
        

        <td><?=number_format($item_total[$r->sub_group_id],2);?></td>

        </tr>
        <?
		$old_sub_group_id = $r->group_id;
		$old_sub_group_name = $r->group_name;
	    }
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2"  style="text-transform:uppercase">Total <?=$old_sub_group_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($sub_group_total[$old_sub_group_id][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($sub_group_gtotal[$old_sub_group_id],2);?></strong></td>
        </tr>
		<tr>
        <td colspan="2" style="font-weight:700; font-size:10px;">GRAND TOTAL</td>
        <? for($i=1;$i<=$t;$i++){ ?><td><strong><?  echo number_format($mon_total[$period[$i]],2);?></strong></td> <? }?> 
		<td><strong><?=number_format($all_total,2);?></strong></td>
        </tr>

</table>
        <? 	}










elseif($_POST['report']=='33333344'){

		$dealer_name = $_POST['dealer_code'];
 		$dealer=explode("-",$dealer_name);
 		$dealer[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con=" and b.dealer_code=".$dealer[0];
			
		?>
       <table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:18px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>MONTH BY MONTH PRODUCT VALUE WISE SALES REPORT</strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	 
		 
		 
       </table>
        <table width="100%" cellspacing="0" cellpadding="0" border="1" bordercolor="#000000" >
      <thead>
	  <?
	  
	  	if(isset($group_for)) 					{$group_for_con=' and b.group_for="'.$group_for.'"';}
		if(isset($zone_id)) 					{$zone_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 						{$item_group_con=' and s.group_id="'.$item_group.'"';}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
	  

	  $f_date = $_POST['f_date'];
	  $t_date = $_POST['t_date'];
	  $fs_date = strtotime($_POST['f_date']);
	  $ts_date = strtotime($_POST['t_date']);
	  $ets_date= strtotime(date('Y-m-t',$ts_date));
	  for($t = 1; $t<30;$t++)
	  {
	  if($t == 1){$period_name[$t] = date('F',$fs_date); $period[$t] = date('Ym',$fs_date);		$mm_date = strtotime(date('Y-m-15',$fs_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  else {$period_name[$t] = date('F',$mm_date);		$period[$t] = date('Ym',$mm_date); 		$mm_date = strtotime(date('Y-m-15',$mm_date))+(60*60*24*30);$nm_date = strtotime(date('Y-m-t',$mm_date));}
	  if($nm_date>$ets_date) break;
	  }
	  
	            $year_sql = 'select year(a.chalan_date) yr, month(a.chalan_date) mon, sum(a.total_unit) as total_amt, i.item_id, s.sub_group_id, g.group_id from 
			   sale_do_chalan a, sale_do_master b, dealer_info c, zon z,  item_info i, item_sub_group s, item_group g where 
 i.item_id=a.item_id and a.do_no = b.do_no and b.dealer_code = c.dealer_code and c.zone_code=z.ZONE_CODE and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and
a.chalan_date BETWEEN  "'.$_POST['f_date'].'" AND "'.$_POST['t_date'].'" and g.product_type="Finish Goods"
'.$group_for_con.$zone_con.$item_sub_con.$dealer_con.$item_group_con.$item_mother_group_con.$item_type_con.'  group by s.sub_group_id, month(a.chalan_date), year(a.chalan_date) order by s.sub_group_id';

	   	$year_query = db_query($year_sql );
		while($value = mysqli_fetch_object($year_query)){
		
		
			$value->mon = sprintf("%02d", $value->mon);
			 $pr = $value->yr.$value->mon;
			
		    $val[$value->sub_group_id][$pr] = $value->total_amt;
			
		    $item_total[$value->sub_group_id] = $item_total[$value->sub_group_id] + $value->total_amt;
			
		    $mon_total[$pr] = $mon_total[$pr] + $value->total_amt;
			
		    $sub_group_total[$value->group_id][$pr] = $sub_group_total[$value->group_id][$pr] +  $value->total_amt;
			
			$sub_group_gtotal[$value->group_id] = $sub_group_gtotal[$value->group_id] +  $value->total_amt;
			$all_total = $all_total +  $value->total_amt;
			
		}
         
	  ?>
        <tr>
        <td bgcolor="#82D8CF"><strong>SL</strong></td>
        <td bgcolor="#82D8CF"><strong>Product Group</strong></td>
        <? for($i=1;$i<=$t;$i++){ ?><td bgcolor="#82D8CF"><strong><?=$period_name[$i].'-'.substr($period[$i],2,2)?></strong></td> 
        <? }?> 
        <td bgcolor="#82D8CF"><strong>Total Qty</strong></td>
        </tr>

        </thead>
        <?
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and s.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and s.group_for="'.$group_for.'"';}
		}
		
		if(isset($item_group)) 						{$item_group_con=' and s.group_id="'.$item_group.'"';}
		
        
		 $sql_101 = 'select i.item_id, i.item_name, s.sub_group_id, s.sub_group_name, s.sub_group_sl, g.group_id, g.group_name from item_info i, item_sub_group s, item_group g 
		 where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id '.$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con.' and g.product_type="Finish Goods" 
		 group by s.sub_group_id,g.group_id order by  g.group_for, g.item_group_sl, s.group_for, s.sub_group_sl';
	   	$query_101 = db_query($sql_101 );
		$sl = 1 ;
		while($r = mysqli_fetch_object($query_101)){
		
		
		
		if(($old_sub_group_id != $r->group_id)&&$old_sub_group_id >0)
		{
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2" style="text-transform:uppercase">Total <?=$old_sub_group_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($sub_group_total[$old_sub_group_id][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($sub_group_gtotal[$old_sub_group_id],2);?></strong></td>
        </tr>
		<?
		}
        ?>
        <tr>
          <td><?=$sl++?></td>
        <td><?=$r->sub_group_name;?></td>
        <? for($i=1;$i<=$t;$i++){ 
		?><td><?=number_format($val[$r->sub_group_id][$period[$i]],2);?></td> <? }?> 
        

        <td><?=number_format($item_total[$r->sub_group_id],2);?></td>

        </tr>
        <?
		$old_sub_group_id = $r->group_id;
		$old_sub_group_name = $r->group_name;
	    }
		?>
		<tr bgcolor="#FFCCFF" style=" font-weight:700; font-size:10px;">
        <td colspan="2"  style="text-transform:uppercase">Total <?=$old_sub_group_name?></td>
        <? for($i=1;$i<=$t;$i++){ ?><td><?  echo  number_format($sub_group_total[$old_sub_group_id][$period[$i]],2);?></td> <? }?> 
		<td><strong><?  echo  number_format($sub_group_gtotal[$old_sub_group_id],2);?></strong></td>
        </tr>
		<tr>
        <td colspan="2" style="font-weight:700; font-size:10px;">GRAND TOTAL</td>
        <? for($i=1;$i<=$t;$i++){ ?><td><strong><?  echo number_format($mon_total[$period[$i]],2);?></strong></td> <? }?> 
		<td><strong><?=number_format($all_total,2);?></strong></td>
        </tr>

</table>
        <? 	}










elseif($_REQUEST['report']==1008) 

{

echo $str;

$pd = date("ym",strtotime(${'f_mos1'}));
if(($pd-2000)>12)
$v = 12;
else $v = $pd-2000;

//$datee=date('m');
//
//if($datee==31){
//$v;
//}
//else if($datee==30){
//$v;
//}
//else{
//$v=$v-1;
//}
?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">


<thead>
<tr>
<th bgcolor="#333333"><span class="style3">S/L</span></th>
<th bgcolor="#333333"><span class="style3">ITEM NAME </span></th>
<th bgcolor="#333333"><span class="style3">SKU Code </span></th>
<?
for($i=$v;$i>0;$i--)
{
?>
<th bgcolor="#333333"><div align="center"><span class="style3"><?=date('M\'y',strtotime(${'f_mos'.$i}))?></span></div></th>
<?
}
?>
<th bgcolor="#333333"><div align="center"><strong><span class="style5">Total</span></strong></div></th>
</tr>
</thead>
<?



$sql = "SELECT item_id, sum(item_in-item_ex) stock FROM `journal_item` WHERE warehouse_id=1 group by item_id";
$query = @db_query($sql);





while($data=@mysqli_fetch_object($query)){
 $p='SELECT sum(p.qty) as pur_qty FROM purchase_invoice p,purchase_master pm WHERE p.po_no=pm.po_no AND pm.status="checked" and p.item_id="'.$data->item_id.'" ';
$pt = db_query($p);
$pur_t=mysqli_fetch_object($pt);
    $stock[$data->item_id] = $data->stock+$pur_t->pur_qty;
	

}

	$p='SELECT sum(p.qty) as pur_qty FROM purchase_invoice p,purchase_master pm WHERE p.po_no=pm.po_no AND pm.status="checked" and p.item_id="'.$stock[$data->item_id].'" ';
$pt = db_query($p);
while($pur_t=mysqli_fetch_object($pt)){
$pur_t->pur_qty;
}


//order by item_description,item_id
$sql = "select * from item_info where product_nature='Salable' order by cat_serial,watt asc" ;

if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}
if(isset($depot_id)) 		{$con=' and c.depot_id="'.$depot_id.'"';}
if(isset($dealer_code)) 	{$con=' and c.dealer_code="'.$dealer_code.'"';}
if(isset($region_id)) 		{$con=' and r.BRANCH_ID="'.$region_id.'"';}
if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
if(isset($area_id)) 		{$con=' and d.area_code="'.$area_id.'"';}
$query = @db_query($sql);
while($item=@mysqli_fetch_object($query)){
$item_id = $item->item_id;
$sku_code=$item->sku_code;
$category=$new_cat=$item->item_description;


for($i=$v;$i>0;$i--)
{
$m = ($i-1);

 $sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z, branch r where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code 
and c.unit_price>0  and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and r.BRANCH_ID=z.REGION_ID and c.item_id='".$item_id."'".$con;
${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));

${'mon'.$i} = 'op_'.date("ym",strtotime(${'f_mons'.$i}));

${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];

${'totalr'.$item_id} = ${'totalr'.$item_id} + ${'sqlmon'.$i}[0];
}





if($old_cat!=$new_cat&&$old_cat!=''){
?>

<tr bgcolor="#<? echo 'eeeeee';?>">
<td colspan='3' style="text-align:right;">Total <?=$old_cat;?></td>
<?
for($i=$v;$i>0;$i--)
{
?>
    <td bgcolor="#eeeeee"><div align="right"><?=$cat_total[$old_cat][$i];?></div></td>
<?
$cat_total_r[$old_cat]=$cat_total_r[$old_cat]+$cat_total[$old_cat][$i];
}
?>

<td bgcolor="#eee"><div align="right"><strong><? $totalallr= $totalallr + ${'totalr'.$item_id};echo $cat_total_r[$old_cat];?></strong></div></td>
</tr>
<?   
}
 ?>



<tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">
    <td><?=++$j?></td>
    <td><?=$item->item_name?></td>
	<td><?=$item->sku_code?></td>
	<?
for($i=$v;$i>0;$i--)
{
    if(${'sqlmon'.$i}[0]==0&&$item->{${'mon'.$i}}!=0) ${'sqlmon'.$i}[0] = $item->{${'mon'.$i}};
?>
<td bgcolor="#99CCFF"><div align="right"><?=(int)(${'sqlmon'.$i}[0]);?></div></td>
<?
$cat_total[$new_cat][$i] = $cat_total[$new_cat][$i] + ${'sqlmon'.$i}[0];
}
?>
<td bgcolor="#FFFF99"><div align="right"><strong><? $totalallr= $totalallr + ${'totalr'.$item_id};echo ${'totalr'.$item_id}?></strong></div></td>
</tr>
<? 
$old_cat = $new_cat;
}

?>
<tr bgcolor="#<? echo 'eeeeee';?>">
<td colspan='3' style="text-align:right;"><div align="right">Total 
  <?=$old_cat;?>
</div></td>
<?
for($i=$v;$i>0;$i--)
{
?>
    <td bgcolor="#eeeeee"><div align="right"><?=$cat_total[$old_cat][$i];?></div></td>
    
<?
$cat_total_r[$old_cat]=$cat_total_r[$old_cat]+$cat_total[$old_cat][$i];
}
?>
<td bgcolor="#eee"><div align="right"><strong><? $totalallr= $totalallr + ${'totalr'.$item_id};echo $cat_total_r[$old_cat];?></strong></div></td>
</tr>


    <tr bgcolor="#FFFF66">
<td><div align="right"></div></td>
<td><div align="right"></div></td>
<td><div align="right">Grand Total</div></td>
      <?
for($i=$v;$i>0;$i--)
    {
    ${'totald'} = ${'totald'} + ${'totalc'.$i};
    ?>
        <td bgcolor="#FFFF66"><div align="right"><span class="style6"><?=$totallm=number_format(${'totalc'.$i});?></span></div></td>
    <?
    }
?>
        <td bgcolor="#FF3333"><div align="right"><span class="style7"><?=number_format($totalallr,2);?></span></div></td>
    </tr>
</table>



<?



}










elseif($_REQUEST['report']==1009) 

{

echo $str;

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td bgcolor="#333333"><span class="style3">S/L</span></td>

    <td bgcolor="#333333"><span class="style3">DEALER NAME </span></td>

    <td bgcolor="#333333"><span class="style3">DIVISION  </span></td>
    <td bgcolor="#333333"><span class="style3">ZONE </span></td>
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

if(isset($dealer_code)) 		{$con=' and d.dealer_code="'.$dealer_code.'"';}

if(isset($region_id)) 		{$con=' and r.BRANCH_ID="'.$region_id.'"';}

if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}

if(isset($area_id)) 		{$con=' and d.area_code="'.$area_id.'"';}

if(isset($depot_id)) 		{$depot_con=' and d.depot="'.$depot_id.'"';}

  $sql = "select d.dealer_code, d.dealer_name_e, r.BRANCH_NAME, z.ZONE_NAME, a.AREA_NAME from dealer_info d, area a, zon z, branch r where d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and r.BRANCH_ID=z.REGION_ID   ".$depot_con.$con." order by r.BRANCH_NAME,z.ZONE_NAME,d.dealer_name_e";

if(isset($item_id)) 		{$con=' and c.item_id="'.$item_id.'"';}





$query = @db_query($sql);

while($dealer=@mysqli_fetch_object($query)){



$dealer_code = $dealer->dealer_code;

for($i=12;$i>0;$i--)

{

$m = ($i-1);



 $sqql = "select sum(c.total_amt) from sale_do_chalan c, dealer_info d,area a, zon z, branch r where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code  and c.unit_price>0  and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and r.BRANCH_ID=z.REGION_ID and c.dealer_code='".$dealer_code."'";







${'sqlmon'.$i} = mysqli_fetch_row(db_query($sqql));



${'totalc'.$i} = ${'totalc'.$i} + ${'sqlmon'.$i}[0];

${'totalr'.$dealer_code} = ${'totalr'.$dealer_code} + ${'sqlmon'.$i}[0];

}







 ?>

  <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">

    <td><?=++$j?></td>

    <td><?=$dealer->dealer_name_e?></td>

    <td><?=$dealer->BRANCH_NAME?></td>
    <td><?=$dealer->ZONE_NAME?></td>
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





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;



${'sqlmonc'.$i} = mysqli_fetch_row(db_query($sqql));

${'totalco'.$i} = ${'totalco'.$i} + ${'sqlmonc'.$i}[0];

${'totalrc1'} = ${'totalrc1'} + ${'sqlmonc'.$i}[0];

}



  ?>

    <tr bgcolor="#<? echo (($i%2)==0)?'fff':'EBEBEB';?>">

      <td>&nbsp;</td>

      <td colspan="3" align="right"><strong> Total</strong></td>

<?

for($i=12;$i>0;$i--)

{

${'totald'} = ${'totald'} + ${'totalc'.$i};

?>

<td bgcolor="#FFFF66"><div align="right"><span class="style6">
  <?=number_format(${'totalc'.$i},2);?>
</span></div></td>

<?

}

?>



      <td bgcolor="#FF3333"><div align="right">

        <span class="style7">
        <?=number_format($totalallr,2);?>
        </span>
      </div></td>
    </tr>

    

	<?

	  for($i=12;$i>0;$i--)

{

$m = ($i-1);





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;

${'sqlmons'.$i} = mysqli_fetch_row(db_query($sqql));

${'totals'.$i} = ${'totals'.$i} + ${'sqlmons'.$i}[0];

${'totalrc'} = ${'totalrc'} + ${'sqlmons'.$i}[0];

}

	?>
</table>

<?

}








elseif($_POST['report']==20060201)
{
		$report="PRODUCT WISE SALES REPORT";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$dealer_name = $_POST['dealer_code'];
 		$dealer=explode("-",$dealer_name);
 		$dealer[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con=" and d.dealer_code=".$dealer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 	  <? if ($depot_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Warehouse Name: <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 

		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($sales_type>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Sales Type: <?=find_a_field('sales_type','sales_type','id='.$sales_type)?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
	
		<tr>
		<th width="2%" rowspan="2">SL</th>
		<th width="7%" rowspan="2">Item Code </th>
		<th width="29%" rowspan="2">Item Name </th>
		<th width="8%" rowspan="2"><span style="text-align:center">CTN</span> Size </th>
		<th colspan="3" bgcolor="#99FFFF" style="text-align:center">SALES  </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center">SALES RETURN</th>
		<th colspan="3" bgcolor="#FF0000" style="text-align:center">NET SALES </th>
		</tr>
		<tr>
		  <th width="6%" bgcolor="#99FFFF" style="text-align:center">CTN</th>
		  <th width="5%" bgcolor="#99FFFF" style="text-align:center">PCS</th>
		  <th width="7%" bgcolor="#99FFFF" style="text-align:center">AMOUNT</th>
		  <th width="6%" bgcolor="#33CCCC" style="text-align:center">CTN</th>
		  <th width="5%" bgcolor="#33CCCC" style="text-align:center">PCS</th>
		  <th width="7%" bgcolor="#33CCCC" style="text-align:center">AMOUNT</th>
		  <th width="4%" bgcolor="#FF0000" style="text-align:center">CTN</th>
		  <th width="5%" bgcolor="#FF0000" style="text-align:center">PCS</th>
		  <th width="9%" bgcolor="#FF0000" style="text-align:center">AMOUNT</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}

		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($depot_id)) 		{$depot_con=' and m.depot_id="'.$depot_id.'"';}
		
		if(isset($sales_type)) 		{$sales_type_con=' and m.sales_type="'.$sales_type.'"';}
		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}

		
		 $sql = "select c.item_id, sum(c.total_unit) as sales_qty , sum(c.total_amt) as sales_amt
		 from sale_do_master m, sale_do_chalan c, dealer_info d,  warehouse w
		 where c.dealer_code=d.dealer_code  and w.warehouse_id=d.depot and m.do_no=c.do_no and
		  c.chalan_date between '".$f_date."' and '".$t_date."' ".$con.$group_for_con.$dealer_con.$depot_con.$sales_type_con." group by c.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_qty[$info->item_id]=$info->sales_qty;
		 $sales_amt[$info->item_id]=$info->sales_amt;	 
		}
		
		
		  $sql = "select c.item_id, sum(c.total_unit) as return_qty, sum(c.total_amt) as return_amt
		  from sale_do_return_master m, sale_do_return_chalan c, dealer_info d,  warehouse w
		  where c.dealer_code=d.dealer_code  and w.warehouse_id=d.depot and m.do_no=c.do_no and
		  c.do_date between '".$f_date."' and '".$t_date."'  ".$con.$group_for_con.$dealer_con.$depot_con.$sales_type_con." group by c.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_qty[$info->item_id]=$info->return_qty;
		 $return_amt[$info->item_id]=$info->return_amt;
		
  		 
		}
		
		
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for="'.$group_for.'"';}
		}

		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}

		
		
	 $sql_sub="select i.sub_group_id, s.sub_group_name from item_info i, item_sub_group s, item_group g where  
		i.sub_group_id=s.sub_group_id and s.group_id=g.group_id
		 ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con." group by i.sub_group_id order by s.group_id, s.sub_group_id ";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		
		<tr>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->sub_group_name?>
		  </strong></div></td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  </tr>
		
		
		
		<?
		
		
		 $sql="select distinct i.item_id, i.item_name, i.pack_size, s.sub_group_name from item_info i, item_sub_group s, item_group g where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and i.sub_group_id='".$info_sub->sub_group_id."'
		 ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con." order by  i.item_id, i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_qty[$row->item_id]<>0 || $foc_qty[$row->item_id]<>0 ){}
		?>
		
		
		
		
		
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_id?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->pack_size?></td>
		<td><? if ($sales_qty[$row->item_id]>0) {?>
		  <?=number_format($sales_qty[$row->item_id]/$row->pack_size,2); $total_sales_qty_ctn +=$sales_qty[$row->item_id]/$row->pack_size; ?>
          <? }?></td>
		<td><? if ($sales_qty[$row->item_id]>0) {?><?=number_format($sales_qty[$row->item_id],2); $total_sales_qty +=$sales_qty[$row->item_id]; ?> <? }?></td>
		<td><? if ($sales_amt[$row->item_id]>0) {?>
		  <?=number_format($sales_amt[$row->item_id],2); $total_sales_amt +=$sales_amt[$row->item_id]; ?>
          <? }?></td>
		<td><? if ($return_qty[$row->item_id]>0) {?>
		  <?=number_format($return_qty[$row->item_id]/$row->pack_size,2); $total_return_qty_ctn +=$return_qty[$row->item_id]/$row->pack_size;?>
          <? }?></td>
		<td><? if ($return_qty[$row->item_id]>0) {?><?=number_format($return_qty[$row->item_id],2); $total_return_qty +=$return_qty[$row->item_id];?> <? }?></td>
		<td><? if ($return_amt[$row->item_id]>0) {?>
		  <?=number_format($return_amt[$row->item_id],2); $total_return_amt +=$return_amt[$row->item_id];?>
          <? }?></td>
		<td><? if ($net_sales_qty=($sales_qty[$row->item_id]-$return_qty[$row->item_id])>0) {?>
          <?=number_format($net_sales_qty=(($sales_qty[$row->item_id]-$return_qty[$row->item_id])/$row->pack_size),2); $total_net_sales_qty_ctn +=$net_sales_qty/$row->pack_size;?>
          <? }?></td>
		<td><? if ($net_sales_qty=($sales_qty[$row->item_id]-$return_qty[$row->item_id])>0) {?>
		<?=number_format($net_sales_qty=($sales_qty[$row->item_id]-$return_qty[$row->item_id]),2); $total_net_sales_qty +=$net_sales_qty;?><? }?></td>
		<td><? if ($net_sales_amt=($sales_amt[$row->item_id]-$return_amt[$row->item_id])>0) {?>
		  <?=number_format($net_sales_amt=($sales_amt[$row->item_id]-$return_amt[$row->item_id]),2); $total_net_sales_amt +=$net_sales_amt;?>
		  <? }?></td>
		</tr>
<? } ?>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Sub Total:</strong></div></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty_ctn,2); $total_total_sales_qty_ctn +=$total_sales_qty_ctn;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty,2); $total_total_sales_qty +=$total_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt,2); $total_total_sales_amt +=$total_sales_amt;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_qty_ctn,2); $total_total_return_qty_ctn +=$total_return_qty_ctn;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_qty,2); $total_total_return_qty +=$total_return_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_amt,2); $total_total_return_amt +=$total_return_amt;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_net_sales_qty_ctn,2); $total_total_net_sales_qty_ctn +=$total_net_sales_qty_ctn;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_net_sales_qty,2); $total_total_net_sales_qty +=$total_net_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_net_sales_amt,2); $total_total_net_sales_amt +=$total_net_sales_amt;?>
          </span></td>
		  </tr>
		  
		  <? 
		  $total_sales_qty_ctn = 0;
		  $total_sales_qty = 0;
		     $total_sales_amt = 0;
			 $total_return_qty_ctn = 0; 
			 $total_return_qty = 0; 
			 $total_return_amt = 0; 
			 $total_net_sales_qty_ctn = 0;
			 $total_net_sales_qty = 0;
			 $total_net_sales_amt = 0; }?>
 
 
 <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Grand Total:</strong></div></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_qty_ctn,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_return_qty_ctn,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_return_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_return_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_net_sales_qty_ctn,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_net_sales_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_net_sales_amt,2);?>
          </span></td>
		  </tr>
 
 
		
		
		</tbody>
</table>
		<?
}







elseif($_POST['report']==20060202)
{
		$report="PRODUCT GROUP WISE SALES REPORT";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$dealer_name = $_POST['dealer_code'];
 		$dealer=explode("-",$dealer_name);
 		$dealer[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con=" and d.dealer_code=".$dealer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
  <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
	
		<tr>
		<th width="2%" rowspan="2">SL</th>
		<th width="20%" rowspan="2">Item Group Name </th>
		<th colspan="2" bgcolor="#99FFFF" style="text-align:center">SALES  </th>
		<th colspan="2" bgcolor="#33CCCC" style="text-align:center">SALES RETURN</th>
		<th colspan="2" bgcolor="#FF0000" style="text-align:center">NET SALES </th>
		</tr>
		<tr>
		  <th width="8%" bgcolor="#99FFFF" style="text-align:center">QUANTITY</th>
		  <th width="9%" bgcolor="#99FFFF" style="text-align:center">AMOUNT</th>
		  <th width="9%" bgcolor="#33CCCC" style="text-align:center">QUANTITY</th>
		  <th width="11%" bgcolor="#33CCCC" style="text-align:center">AMOUNT</th>
		  <th width="9%" bgcolor="#FF0000" style="text-align:center">QUANTITY</th>
		  <th width="10%" bgcolor="#FF0000" style="text-align:center">AMOUNT</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}

		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_sub_group)) 		{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 			{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}


		
		 $sql = "select c.item_id, s.sub_group_id, sum(c.total_unit) as sales_qty , sum(c.total_amt) as sales_amt
		 from sale_do_master m, sale_do_chalan c, dealer_info d,  zon z, item_info i, item_sub_group s
		 where c.dealer_code=d.dealer_code  and z.ZONE_CODE=d.zone_code and m.do_no=c.do_no and i.sub_group_id=s.sub_group_id  and c.item_id=i.item_id and
		  c.chalan_date between '".$f_date."' and '".$t_date."' ".$con.$group_for_con.$dealer_con.$item_sub_con.$item_group_con.$item_type_con." group by s.sub_group_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_qty[$info->sub_group_id]=$info->sales_qty;
		 $sales_amt[$info->sub_group_id]=$info->sales_amt;	 
		}
		
		
		  $sql = "select c.item_id, s.sub_group_id, sum(c.total_unit) as return_qty, sum(c.return_amt) as return_amt
		  from sale_return_master m, sale_return_details c, dealer_info d, zon z, item_info i, item_sub_group s
		  where c.dealer_code=d.dealer_code and z.ZONE_CODE=d.zone_code  and m.do_no=c.do_no and i.sub_group_id=s.sub_group_id  and c.item_id=i.item_id and
		  c.do_date between '".$f_date."' and '".$t_date."'  ".$con.$group_for_con.$dealer_con.$item_sub_con.$item_group_con.$item_type_con." group by s.sub_group_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_qty[$info->sub_group_id]=$info->return_qty;
		 $return_amt[$info->sub_group_id]=$info->return_amt;
		
  		 
		}
		
		
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and g.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and g.group_for="'.$group_for.'"';}
		}


		
		
	  $sql_sub="select i.sub_group_id, s.sub_group_name, g.group_id, g.group_name from item_info i, item_sub_group s, item_group g  where  
		 s.group_id=g.group_id and i.sub_group_id=s.sub_group_id  and g.product_type='Finish Goods'
		 ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con." 
		 group by g.group_id order by g.group_for, g.item_group_sl";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		
		<tr>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->group_name?>
		  </strong></div></td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  </tr>
		
		
		
		<?
		
		
		 $sql="select distinct i.item_id, i.item_name, s.sub_group_id, s.sub_group_name from item_info i, item_sub_group s, item_group g  where 
		  s.group_id=g.group_id and i.sub_group_id=s.sub_group_id  and s.group_id='".$info_sub->group_id."'
		   ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con."
		 group by s.sub_group_id,g.group_id order by g.group_id, s.sub_group_sl";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_qty[$row->item_id]<>0 || $foc_qty[$row->item_id]<>0 ){}
		?>
		
		
		
		
		
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sub_group_name?></td>
		<td><? if ($sales_qty[$row->sub_group_id]>0) {?><?=number_format($sales_qty[$row->sub_group_id],2); $total_sales_qty +=$sales_qty[$row->sub_group_id]; ?> <? }?></td>
		<td><? if ($sales_amt[$row->sub_group_id]>0) {?>
		  <?=number_format($sales_amt[$row->sub_group_id],2); $total_sales_amt +=$sales_amt[$row->sub_group_id]; ?>
          <? }?></td>
		<td><? if ($return_qty[$row->sub_group_id]>0) {?><?=number_format($return_qty[$row->sub_group_id],2); $total_return_qty +=$return_qty[$row->sub_group_id];?> <? }?></td>
		<td><? if ($return_amt[$row->sub_group_id]>0) {?>
		  <?=number_format($return_amt[$row->sub_group_id],2); $total_return_amt +=$return_amt[$row->sub_group_id];?>
          <? }?></td>
		<td><? if ($net_sales_qty=($sales_qty[$row->sub_group_id]-$return_qty[$row->sub_group_id])>0) {?>
		<?=number_format($net_sales_qty=($sales_qty[$row->sub_group_id]-$return_qty[$row->sub_group_id]),2); $total_net_sales_qty +=$net_sales_qty;?><? }?></td>
		<td><? if ($net_sales_amt=($sales_amt[$row->sub_group_id]-$return_amt[$row->sub_group_id])>0) {?>
		  <?=number_format($net_sales_amt=($sales_amt[$row->sub_group_id]-$return_amt[$row->sub_group_id]),2); $total_net_sales_amt +=$net_sales_amt;?>
		  <? }?></td>
		</tr>
<? } ?>
		<tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Sub Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty,2); $total_total_sales_qty +=$total_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt,2); $total_total_sales_amt +=$total_sales_amt;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_qty,2); $total_total_return_qty +=$total_return_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_amt,2); $total_total_return_amt +=$total_return_amt;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_net_sales_qty,2); $total_total_net_sales_qty +=$total_net_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_net_sales_amt,2); $total_total_net_sales_amt +=$total_net_sales_amt;?>
          </span></td>
		  </tr>
		  
		  <? $total_sales_qty = 0;
		     $total_sales_amt = 0;
			 $total_return_qty = 0; 
			 $total_return_amt = 0; 
			 $total_net_sales_qty = 0;
			 $total_net_sales_amt = 0; }?>
 
 
 <tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Grand Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_return_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_return_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_net_sales_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_net_sales_amt,2);?>
          </span></td>
		  </tr>
 
 
		
		
		</tbody>
</table>
		<?
}






elseif($_POST['report']==2006020211)
{
		$report="YEARLY SALES COMMISSION REPORT";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$dealer_name = $_POST['dealer_code'];
 		$dealer=explode("-",$dealer_name);
 		$dealer[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con=" and d.dealer_code=".$dealer[0];
		
		
		if($_POST['commission_year']!=''){
			$yr_data = find_all_field('commission_year','','id='.$_POST['commission_year']);
			$f_date = $yr_data->start_date;
			$t_date = $yr_data->end_date;
		
		}
 		
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
  <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($f_date));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($t_date));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
	
		<tr>
		<th width="2%" rowspan="2">SL</th>
		<th width="20%" rowspan="2">Item Group Name </th>
		<th colspan="2" bgcolor="#99FFFF" style="text-align:center">Gradation </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Commission Per Unit </th>
		</tr>
		<tr>
		  <th width="8%" bgcolor="#99FFFF" style="text-align:center">Minimum</th>
		  <th width="9%" bgcolor="#99FFFF" style="text-align:center">Maximum</th>
		  </tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}

		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_sub_group)) 		{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 			{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		 $sql = "select c.item_id, s.sub_group_id, sum(c.total_unit) as sales_qty , sum(c.total_amt) as sales_amt
		 from sale_do_master m, sale_do_chalan c, dealer_info d,  zon z, item_info i, item_sub_group s
		 where c.dealer_code=d.dealer_code  and z.ZONE_CODE=d.zone_code and m.do_no=c.do_no and i.sub_group_id=s.sub_group_id  and c.item_id=i.item_id and
		  c.chalan_date between '".$f_date."' and '".$t_date."' ".$con.$group_for_con.$dealer_con.$item_sub_con.$item_group_con." group by s.sub_group_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_qty[$info->sub_group_id]=$info->sales_qty;
		 $sales_amt[$info->sub_group_id]=$info->sales_amt;	 
		}
		
		
		  $sql = "select c.item_id, s.sub_group_id, sum(c.total_unit) as return_qty, sum(c.return_amt) as return_amt
		  from sale_return_master m, sale_return_details c, dealer_info d, zon z, item_info i, item_sub_group s
		  where c.dealer_code=d.dealer_code and z.ZONE_CODE=d.zone_code  and m.do_no=c.do_no and i.sub_group_id=s.sub_group_id  and c.item_id=i.item_id and
		  c.do_date between '".$f_date."' and '".$t_date."'  ".$con.$group_for_con.$dealer_con.$item_sub_con.$item_group_con." group by s.sub_group_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_qty[$info->sub_group_id]=$info->return_qty;
		 $return_amt[$info->sub_group_id]=$info->return_amt;
		
  		 
		}
		
		
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and g.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and g.group_for="'.$group_for.'"';}
		}


		
		
	  $sql_sub="select  g.group_id, g.group_name from  item_group g, commission_rate r, commission_year y  where  
		 g.group_id=r.group_id and r.commission_year=y.id ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con." 
		 group by g.group_id order by g.group_for, g.item_group_sl";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		
		<tr>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->group_name?>
		  </strong></div></td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  </tr>
		
		
		
		<?
		
		
		 $sql="select   s.sub_group_id, s.sub_group_name, y.commission_year, r.sale_type, r.minimum_qty, r.maximum_qty, r.commission_rate from item_group g, item_sub_group s, commission_rate r, commission_year y   where 
		g.group_id=s.group_id and g.group_id=r.group_id and r.commission_year=y.id  and s.group_id='".$info_sub->group_id."'
		   ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con."
		  order by s.group_id, s.sub_group_sl, r.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_qty[$row->item_id]<>0 || $foc_qty[$row->item_id]<>0 ){}
		?>
		
		
		
		
		
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=number_format($row->minimum_qty,2); ?> </td>
		<td><?=number_format($row->maximum_qty,2); ?></td>
		<td><?=number_format($row->commission_rate,2); ?></td>
		</tr>
<? } ?>
		<tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Sub Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty,2); $total_total_sales_qty +=$total_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt,2); $total_total_sales_amt +=$total_sales_amt;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_qty,2); $total_total_return_qty +=$total_return_qty;?>
		  </span></td>
		  </tr>
		  
		  <? $total_sales_qty = 0;
		     $total_sales_amt = 0;
			 $total_return_qty = 0; 
			 $total_return_amt = 0; 
			 $total_net_sales_qty = 0;
			 $total_net_sales_amt = 0; }?>
 
 
 <tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Grand Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_return_qty,2);?>
		  </span></td>
		  </tr>
 
 
		
		
		</tbody>
</table>
		<?
}







elseif($_POST['report']==20060203)
{
		$report="CONSOLIDATED SALES REPORT CUSTOMER WISE";		
		
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		 <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		<?php /*?> <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code)?></strong></td>
         </tr>
		 <? }?><?php */?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr>
		<th width="2%" rowspan="2">SL</th>
		<th width="3%" rowspan="2">Code</th>
		<th width="22%" rowspan="2">Customer Name </th>
		<th colspan="4" bgcolor="#99FFFF" style="text-align:center">SALES</th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">SALES RETURN</th>
		<th width="9%" rowspan="2" bgcolor="#FFCCFF" style="text-align:center">COLLECTION</th>
		</tr>
		<tr>
		  <th width="9%" bgcolor="#99FFFF" style="text-align:center">SALES AMT </th>
		  <th width="8%" bgcolor="#99FFFF" style="text-align:center">DISCOUNT</th>
		  <th width="6%" bgcolor="#99FFFF" style="text-align:center">VAT</th>
		  <th width="10%" bgcolor="#99FFFF" style="text-align:center">INVOICE AMT </th>
		  </tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($depot_id)) 		{$depot_con=' and d.depot="'.$depot_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}



		

		
		  $sql = "select c.dealer_code, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_chalan c, dealer_info d, item_info i, item_sub_group s, item_group g, warehouse w
		 where m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and d.depot=w.warehouse_id and
		  c.chalan_date between '".$f_date."' and '".$t_date."' 
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con.$depot_con."  group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->dealer_code]=$info->sales_amt;
		 $sales_qty[$info->dealer_code]=$info->sales_qty;
		}
		
		
		$sql = "select m.dealer_code, sum(m.cash_discount) as discount_amt, sum(m.vat_amt) as vat_amt  
		 from sale_do_master m,  dealer_info d, warehouse w
		 where m.dealer_code=d.dealer_code  and d.depot=w.warehouse_id and
		  m.do_date between '".$f_date."' and '".$t_date."' ".$con.$group_for_con.$depot_con."  group by d.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $discount_amt[$info->dealer_code]=$info->discount_amt;
		 $vat_amt[$info->dealer_code]=$info->vat_amt;
		}

		
		  $sql = "select c.dealer_code, sum(c.total_amt) as return_amt
		  from sale_do_return_master m, sale_do_return_chalan c, dealer_info d,  warehouse w
		  where  m.do_no=c.do_no and c.dealer_code=d.dealer_code and d.depot=w.warehouse_id and
		  c.do_date between '".$f_date."' and '".$t_date."' 
		   ".$con.$group_for_con." group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_amt[$info->dealer_code]=$info->return_amt; 
		}
		
		

		$sql = "select m.dealer_code, sum(m.collection_amt) as collection_amt
		 from collection_from_customer m,  dealer_info d, warehouse w
		 where m.dealer_code=d.dealer_code  and d.depot=w.warehouse_id and
		  m.collection_date between '".$f_date."' and '".$t_date."' ".$con.$group_for_con.$depot_con."  group by d.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $collection_amt[$info->dealer_code]=$info->collection_amt;

		}

		
		
		
		
		?>
		
		
	
		
		
		<?
		

		
		 $sql="select distinct d.dealer_code, d.dealer_name_e, w.warehouse_name from dealer_info d, warehouse w
		 where  d.depot=w.warehouse_id   ".$depot_con." order by d.dealer_code";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->dealer_code?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><? if ($sales_amt[$row->dealer_code]>0) {?>
		  <?=number_format($sales_amt[$row->dealer_code],2); $total_sales_amt +=$sales_amt[$row->dealer_code]; ?>
		  <? }?></td>
		<td><? if ($discount_amt[$row->dealer_code]>0) {?>
		  <?=number_format($discount_amt[$row->dealer_code],2); $total_discount_amt +=$discount_amt[$row->dealer_code]; ?>
		  <? }?></td>
		<td><? if ($vat_amt[$row->dealer_code]>0) {?>
		  <?=number_format($vat_amt[$row->dealer_code],2); $total_vat_amt +=$vat_amt[$row->dealer_code]; ?>
		  <? }?></td>
		<td><? if ($net_sales_amt = ($sales_amt[$row->dealer_code]-$discount_amt[$row->dealer_code])+$vat_amt[$row->dealer_code]>0) {?>
	<?=number_format($net_sales_amt = ($sales_amt[$row->dealer_code]-$discount_amt[$row->dealer_code])+$vat_amt[$row->dealer_code],2); $total_net_sales_amt +=$net_sales_amt; ?>
		<? }?></td>
		<td><? if ($return_amt[$row->dealer_code]>0) {?><?=number_format($return_amt[$row->dealer_code],2); $total_return_amt +=$return_amt[$row->dealer_code];?><? }?></td>
		
		<td><? if ($collection_amt[$row->dealer_code]>0) {?>
          <?=number_format($collection_amt[$row->dealer_code],2); $total_collection_amt +=$collection_amt[$row->dealer_code]; ?>
          <? }?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>SUB TOTAL: </strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt,2); ?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_discount_amt,2); ?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_vat_amt,2); ?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_net_sales_amt,2); ?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_amt,2); ?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_collection_amt,2); ?>
          </span></td>
		  </tr>
	
		
		</tbody>
</table>
		<?
}







elseif($_POST['report']==201201)
{
		$report="Monthly Sales Report";		
		
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($depot_id>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Warehouse: <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:13px" height="25">
		<th width="2%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="8%" rowspan="2" bgcolor="#33CCCC">Date</th>
		<th colspan="3" bgcolor="#33CCCC"><div align="center">Sales Amt </div></th>
		<th width="8%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Collection</th>
		<th width="9%" colspan="2" bgcolor="#33CCCC" style="text-align:center">Discount</th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Return</th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Cash Amt </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Expense</th>
		<th width="12%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Balance</th>
		</tr>
		<tr style="font-size:13px" height="25">
		  <th width="8%" bgcolor="#33CCCC">Cash</th>
		  <th width="7%" bgcolor="#33CCCC"><span style="text-align:center">Credit</span></th>
		  <th width="9%" bgcolor="#33CCCC">Total</th>
		  <th width="4%" bgcolor="#33CCCC" style="text-align:center">Cash</th>
		  <th width="5%" bgcolor="#33CCCC" style="text-align:center">Credit</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($depot_id)) 		{$depot_con=' and c.depot_id="'.$depot_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}



		

		
		  $sql = "select c.chalan_date, sum(c.total_amt) as sales_amt 
		 from sale_do_master m, sale_do_chalan c 
		 where m.do_no=c.do_no  and c.chalan_date between '".$f_date."' and '".$t_date."' 
		   ".$depot_con."  group by c.chalan_date ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->chalan_date]=$info->sales_amt;
		
		}
		
		
		
		  $sql = "select jv_date, sum(cr_amt) as cr_amt 
		 from journal 
		 where  jv_date between '".$f_date."' and '".$t_date."' and tr_from='Collection' and cc_code='".$_POST['depot_id']."'  group by jv_date ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cr_amt[$info->jv_date]=$info->cr_amt;
		
		}
		
		
		
		  $sql = "select c.chalan_date, sum(c.total_amt) as cr_sales 
		 from sale_do_master m, sale_do_chalan c 
		 where m.do_no=c.do_no  and c.chalan_date between '".$f_date."' and '".$t_date."'  and m.sales_type=1  ".$depot_con."  group by c.chalan_date ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cr_sales[$info->chalan_date]=$info->cr_sales;
		 
		 $credit_sales[$info->chalan_date]=$info->cr_sales;
		
		}
		
		
		
		 $sql = "select c.chalan_date, sum(c.total_amt) as cash_sales 
		 from sale_do_master m, sale_do_chalan c 
		 where m.do_no=c.do_no  and c.chalan_date between '".$f_date."' and '".$t_date."'  and m.sales_type=2  ".$depot_con."  group by c.chalan_date ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cash_sales[$info->chalan_date]=$info->cash_sales;
		
		}
		
		
		 $sql = "select m.do_date, sum(m.cash_discount) as discount 
		 from sale_do_master m
		 where m.do_date between '".$f_date."' and '".$t_date."'  and m.sales_type=2 and m.depot_id='".$_POST['depot_id']."'  group by m.do_date ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $discount[$info->do_date]=$info->discount;
		
		}
		
		
		$sql = "select m.do_date, sum(m.cash_discount) as cr_discount 
		 from sale_do_master m
		 where m.do_date between '".$f_date."' and '".$t_date."'  and m.sales_type=1 and m.depot_id='".$_POST['depot_id']."'  group by m.do_date ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cr_discount[$info->do_date]=$info->cr_discount;
		
		}
		
		
		
		  $sql = "select jv_date, sum(dr_amt) as exp_amt 
		 from journal where  jv_date between '".$f_date."' and '".$t_date."' and tr_from='Expense' and cc_code='".$_POST['depot_id']."'  group by jv_date ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $exp_amt[$info->jv_date]=$info->exp_amt;
		
		}
		
		
		
		  $sql = "select c.chalan_date, sum(c.total_amt) as return_amt 
		 from sale_do_return_master m, sale_do_return_chalan c 
		 where m.do_no=c.do_no  and c.chalan_date between '".$f_date."' and '".$t_date."' 
		   ".$depot_con."  group by c.chalan_date ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_amt[$info->chalan_date]=$info->return_amt;
		
		}
		

		
		
		
		
		?>
		
		
	
		
		
		<?
		

		
		 $sql="select c.chalan_date from sale_do_chalan c
		 where c.chalan_date between '".$f_date."' and '".$t_date."' group by c.chalan_date order by c.chalan_date";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->chalan_date));?></td>
		<td><? if ($cash_sales[$row->chalan_date]>0) {?>
          <?=number_format($cash_sales[$row->chalan_date],2); $total_cash_sales +=$cash_sales[$row->chalan_date]; ?>
          <? }?></td>
		<td><? if ($credit_sales[$row->chalan_date]>0) {?>
          <?=number_format($credit_sales[$row->chalan_date],2); $total_credit_sales +=$credit_sales[$row->chalan_date]; ?>
          <? }?></td>
		<td>
		<? if ($sales_amt[$row->chalan_date]>0) {?>
		<?=number_format($sales_amt[$row->chalan_date],2);  $total_sales_amt +=$sales_amt[$row->chalan_date]?>
		<? }?>		</td>
		<td><? if ($cr_amt[$row->chalan_date]>0) {?><?=number_format($cr_amt[$row->chalan_date],2); $total_cr_amt +=$cr_amt[$row->chalan_date];?><? }?></td>
		
		<td>
		
		 <? number_format($cr_sales[$row->chalan_date],2); $total_cr_sales +=$cr_sales[$row->chalan_date]; ?>
		
		
		
		
		<? if ($discount[$row->chalan_date]>0) {?>
          <?=number_format($discount[$row->chalan_date],2); $total_discount +=$discount[$row->chalan_date]; ?>
          <? }?></td>
		<td>
		<? if ($cr_discount[$row->chalan_date]>0) {?>
          <?=number_format($cr_discount[$row->chalan_date],2); $total_cr_discount +=$cr_discount[$row->chalan_date]; ?>
          <? }?>
		</td>
		<td><? if ($return_amt[$row->chalan_date]>0) {?>
          <?=number_format($return_amt[$row->chalan_date],2); $total_return_amt +=$return_amt[$row->chalan_date]; ?>
          <? }?></td>
		<td><?= number_format($cash_amt = ($sales_amt[$row->chalan_date]+$cr_amt[$row->chalan_date])-
		($cr_sales[$row->chalan_date]+$discount[$row->chalan_date]+$return_amt[$row->chalan_date]),2); $total_cash_amt += $cash_amt;?></td>
		<td><? if ($exp_amt[$row->chalan_date]>0) {?>
          <?=number_format($exp_amt[$row->chalan_date],2); $total_exp_amt +=$exp_amt[$row->chalan_date]; ?>
          <? }?></td>
		<td><?=number_format($balance_amt = ($cash_amt-$exp_amt[$row->chalan_date]),2); $total_balance +=$balance_amt;?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td align="center"><span class="style7">
          Total:
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_cash_sales,2); ?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_credit_sales,2); ?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt,2); ?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_cr_amt,2); ?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_discount,2); ?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_cr_discount,2); ?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_amt,2); ?>
          </span></td>
		  <td>
		  <span class="style7">
		    <?=number_format($total_cash_amt,2); ?>
          </span>		  </td>
		  <td><span class="style7">
		    <?=number_format($total_exp_amt,2); ?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_balance,2); ?>
          </span></td>
		</tr>
	
		
		</tbody>
</table>
		<?
}











elseif($_POST['report']==2006020311)
{
		$report="DEALER WISE SALES REPORT DETAIL";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		<?php /*?> <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code)?></strong></td>
         </tr>
		 <? }?><?php */?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr>
		<th width="4%" rowspan="2" bgcolor="#FFFACD">SL</th>
		<th width="17%" rowspan="2" bgcolor="#FFFACD">DEALER NAME </th>
		<th colspan="2" bgcolor="#d6eaf8" style="text-align:center">REGULAR SALES</th>
		<th colspan="2" bgcolor="#99FFFF" style="text-align:center">ADVANCE SALES</th>
		<th colspan="2" bgcolor="#ebdef0" style="text-align:center">TOTAL SALES</th>
		<th colspan="2" bgcolor="#33CCCC" style="text-align:center">SALES RETURN </th>
		<th colspan="2" bgcolor="#FF0000" style="text-align:center">NET SALES </th>
		</tr>
		<tr>
		  <th width="8%" bgcolor="#d6eaf8" style="text-align:center">QUANTITY</th>
		  <th width="8%" bgcolor="#d6eaf8" style="text-align:center">AMOUNT</th>
		  <th width="8%" bgcolor="#99FFFF" style="text-align:center">QUANTITY</th>
		  <th width="9%" bgcolor="#99FFFF" style="text-align:center">AMOUNT</th>
		  <th width="7%" bgcolor="#ebdef0" style="text-align:center">QUANTITY</th>
		  <th width="8%" bgcolor="#ebdef0" style="text-align:center">AMOUNT</th>
		  <th width="7%" bgcolor="#33CCCC" style="text-align:center">QUANTITY</th>
		  <th width="8%" bgcolor="#33CCCC" style="text-align:center">AMOUNT</th>
		  <th width="7%" bgcolor="#FF0000" style="text-align:center">QUANTITY</th>
		  <th width="9%" bgcolor="#FF0000" style="text-align:center">AMOUNT</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}


		

		
		 $sql = "select c.dealer_code, sum(c.total_unit) as regular_qty , sum(c.total_amt) as regular_amt
		 from sale_do_master m, sale_do_chalan c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		 where m.do_no=c.do_no and  c.dealer_code=d.dealer_code and c.item_id=i.item_id and  s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id
 and  d.zone_code=z.ZONE_CODE and
		  c.chalan_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods' and m.do_type in ('REGULAR','MAT','CASH SALE','WASTAGE') ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $regular_qty[$info->dealer_code]=$info->regular_qty;
		 $regular_amt[$info->dealer_code]=$info->regular_amt;
		}
		
		
		  $sql = "select c.dealer_code, sum(c.total_unit) as advance_qty , sum(c.total_amt) as advance_amt
		 from sale_do_master m, sale_do_chalan c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		 where m.do_no=c.do_no and  c.dealer_code=d.dealer_code and c.item_id=i.item_id and  s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id and  d.zone_code=z.ZONE_CODE and
		  c.chalan_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods' and m.do_type='ADVANCE' 
		  ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $advance_qty[$info->dealer_code]=$info->advance_qty;
		 $advance_amt[$info->dealer_code]=$info->advance_amt;
		}
		
		
		  $sql = "select c.dealer_code,  sum(c.total_unit) as return_qty, sum(c.return_amt) as return_amt
		  from sale_return_master m, sale_return_details c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		  where  m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and  s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id and  d.zone_code=z.ZONE_CODE and
		  c.do_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods' and m.sr_invoice>0 
		  ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con." group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
		 $return_qty[$info->dealer_code]=$info->return_qty;
  		 $return_amt[$info->dealer_code]=$info->return_amt;
		}
		
		
		if(isset($zone_id)) 		{$zon_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		 $sql_sub="select z.ZONE_CODE, z.ZONE_NAME from dealer_info d, zon z where  
		 z.ZONE_CODE=d.zone_code ".$zon_con." group by z.ZONE_CODE";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		
		
		<tr>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->ZONE_NAME?></strong></div></td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		</tr>
		
		
		
		
		
		<?

		
		 $sql="select distinct d.dealer_code, d.dealer_name_e, z.ZONE_NAME from dealer_info d, zon z
		 where  z.ZONE_CODE=d.zone_code and d.zone_code='".$info_sub->ZONE_CODE."'  ".$con." order by z.ZONE_CODE,d.dealer_code";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><? if ($regular_qty[$row->dealer_code]>0) {?><?=number_format($regular_qty[$row->dealer_code],2); $total_regular_qty +=$regular_qty[$row->dealer_code]; ?><? }?></td>
		<td><? if ($regular_amt[$row->dealer_code]>0) {?>
		  <?=number_format($regular_amt[$row->dealer_code],2); $total_regular_amt +=$regular_amt[$row->dealer_code]; ?>
		  <? }?></td>
		<td><? if ($advance_qty[$row->dealer_code]>0) {?>
		  <?=number_format($advance_qty[$row->dealer_code],2); $total_advance_qty +=$advance_qty[$row->dealer_code]; ?>
		  <? }?></td>
		<td><? if ($advance_amt[$row->dealer_code]>0) {?>
		  <?=number_format($advance_amt[$row->dealer_code],2); $total_advance_amt +=$advance_amt[$row->dealer_code]; ?>
		  <? }?></td>
		<td>
		<? if ($total_sales_qty = ($regular_qty[$row->dealer_code]+$advance_qty[$row->dealer_code])>0) {?>
		<?= number_format($total_sales_qty = ($regular_qty[$row->dealer_code]+$advance_qty[$row->dealer_code]),2); $total_total_sales_qty +=$total_sales_qty;?>
		<? }?></td>
		<td>
		<? if ($total_sales_amt = ($regular_amt[$row->dealer_code]+$advance_amt[$row->dealer_code])>0) {?>
		<?= number_format($total_sales_amt = ($regular_amt[$row->dealer_code]+$advance_amt[$row->dealer_code]),2); $total_total_sales_amt +=$total_sales_amt;?>
		<? }?></td>
		<td><? if ($return_qty[$row->dealer_code]>0) {?><?=number_format($return_qty[$row->dealer_code],2); $total_return_qty +=$return_qty[$row->dealer_code];?><? }?></td>
		<td><? if ($return_amt[$row->dealer_code]>0) {?>
		  <?=number_format($return_amt[$row->dealer_code],2); $total_return_amt +=$return_amt[$row->dealer_code];?>
		  <? }?></td>
		<td><? if ($net_sales_qty=($total_sales_qty-$return_qty[$row->dealer_code])>0) {?>
		  <?=number_format($net_sales_qty=($total_sales_qty-$return_qty[$row->dealer_code]),2); $total_net_sales_qty +=$net_sales_qty;?>
		  <? }?></td>
		<td><? if ($net_sales_amt=($total_sales_amt-$return_amt[$row->dealer_code])>0) {?>
		  <?=number_format($net_sales_amt=($total_sales_amt-$return_amt[$row->dealer_code]),2); $total_net_sales_amt +=$net_sales_amt;?>
		  <? }?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>SUB TOTAL:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_regular_qty,2); $total_total_regular_qty +=$total_regular_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_regular_amt,2); $total_total_regular_amt +=$total_regular_amt;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_advance_qty,2); $total_total_advance_qty +=$total_advance_qty;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_advance_amt,2); $total_total_advance_amt +=$total_advance_amt;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_qty,2); $g_total_total_sales_qty +=$total_total_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_amt,2); $g_total_total_sales_amt +=$total_total_sales_amt;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_qty,2); $total_total_return_qty +=$total_return_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_amt,2); $total_total_return_amt +=$total_return_amt;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_net_sales_qty,2); $total_total_net_sales_qty +=$total_net_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_net_sales_amt,2); $total_total_net_sales_amt +=$total_net_sales_amt;?>
		  </span></td>
		</tr>
		  
		  <? 
		  $total_regular_qty = 0;
		  $total_regular_amt = 0;
		  $total_advance_qty = 0;
		  $total_advance_amt = 0;
		  $total_return_qty = 0;
		  $total_return_amt = 0;
		  $total_total_sales_qty = 0;
		  $total_total_sales_amt = 0;
		  $total_net_sales_qty = 0;
		  $total_net_sales_amt = 0;
		   }?>
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>GRAND TOTAL</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_total_regular_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_regular_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_advance_qty,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_advance_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($g_total_total_sales_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($g_total_total_sales_amt,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_return_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_return_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_net_sales_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_net_sales_amt,2);?>
		  </span></td>
		</tr>
		
		</tbody>
		</table>
		<?
}







elseif($_POST['report']==2006020322)
{
		$report="CUSTOMER TO CUSTOMER COMPARISON (PRODUCT WISE)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$dealer_name_d1 = $_POST['dealer_code'];
 		$dealer_d1=explode("-",$dealer_name_d1);
 		$dealer_d1[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con_d1=" and d.dealer_code=".$dealer_d1[0];
		
		
		$dealer_name_d2 = $_POST['dealer_code_to'];
 		$dealer_d2=explode("-",$dealer_name_d2);
 		$dealer_d2[0];
 		if($_POST['dealer_code_to']!='')
 		$dealer_con_d2=" and d.dealer_code=".$dealer_d2[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		<?php /*?> <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_d1[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>To Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_d2[0])?></strong></td>
         </tr>
		 <? }?>
		 <?php */?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>

		<tr>
		<th width="4%" rowspan="2">SL</th>
		<th width="21%" rowspan="2">Item Name </th>
		<th width="18%" colspan="2" bgcolor="#99FFFF" style="text-align:center"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_d1[0])?></th>
		<th width="18%" colspan="2" bgcolor="#33CCCC" style="text-align:center"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_d2[0])?></th>
		</tr>
		<tr>
		  <th bgcolor="#99FFFF" style="text-align:center">QUANTITY</th>
		  <th bgcolor="#99FFFF" style="text-align:center"> AMOUNT </th>
		  <th width="9%" bgcolor="#33CCCC" style="text-align:center">QUANTITY</th>
		  <th width="9%" bgcolor="#33CCCC" style="text-align:center">AMOUNT</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}

		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		

		
		 $sql = "select c.item_id, sum(c.total_amt) as sales_amt_d1 , sum(c.total_unit) as sales_qty_d1
		 from sale_do_master m, sale_do_chalan c, dealer_info d,  zon z
		 where c.dealer_code=d.dealer_code  and z.ZONE_CODE=d.zone_code and m.do_no=c.do_no and
		  c.chalan_date between '".$f_date."' and '".$t_date."' ".$con.$group_for_con.$dealer_con_d1." group by c.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt_d1[$info->item_id]=$info->sales_amt_d1;
		 $sales_qty_d1[$info->item_id]=$info->sales_qty_d1;
		
		}
		
		
		
		 $sql = "select c.item_id, sum(c.total_amt) as sales_amt_d2 , sum(c.total_unit) as sales_qty_d2
		 from sale_do_master m, sale_do_chalan c, dealer_info d,  zon z
		 where c.dealer_code=d.dealer_code  and z.ZONE_CODE=d.zone_code and m.do_no=c.do_no and
		  c.chalan_date between '".$f_date."' and '".$t_date."' ".$con.$group_for_con.$dealer_con_d2." group by c.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt_d2[$info->item_id]=$info->sales_amt_d2;
		 $sales_qty_d2[$info->item_id]=$info->sales_qty_d2;
		
		}
		
		
		
		
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for="'.$group_for.'"';}
		}
		
		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
	 $sql_sub="select i.sub_group_id, s.sub_group_name from item_info i, item_sub_group s, item_group g where  
		i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.product_type='Finish Goods'
		 ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con." group by i.sub_group_id order by  s.group_for, s.sub_group_sl";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		<tr>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->sub_group_name?>
		  </strong></div></td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		</tr>
		
		<?
		
		
		 $sql="select distinct i.item_id, i.item_name, s.sub_group_name from item_info i, item_sub_group s, item_group g where i.sub_group_id=s.sub_group_id and 
		   s.group_id=g.group_id  and g.product_type='Finish Goods'
		  and i.sub_group_id='".$info_sub->sub_group_id."' ".$item_sub_con.$group_for_item_con.$item_group_con.$item_type_con." order by i.item_type, i.item_id, i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_qty[$row->item_id]<>0 || $foc_qty[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_name?></td>
		<td><? if ($sales_qty_d1[$row->item_id]>0) {?><?=number_format($sales_qty_d1[$row->item_id],2); $total_sales_qty_d1 +=$sales_qty_d1[$row->item_id]; ?> <? }?></td>
		<td><? if ($sales_amt_d1[$row->item_id]>0) {?>
		  <?=number_format($sales_amt_d1[$row->item_id],2); $total_sales_amt_d1 +=$sales_amt_d1[$row->item_id]; ?>
          <? }?></td>
		<td><? if ($sales_qty_d2[$row->item_id]>0) {?><?=number_format($sales_qty_d2[$row->item_id],2); $total_sales_qty_d2 +=$sales_qty_d2[$row->item_id];?> <? }?></td>
		<td><? if ($sales_amt_d2[$row->item_id]>0) {?>
		  <?=number_format($sales_amt_d2[$row->item_id],2); $total_sales_amt_d2 +=$sales_amt_d2[$row->item_id];?>
          <? }?></td>
		</tr>
<? } ?>
		<tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong> Sub Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty_d1,2); $total_total_sales_qty_d1 +=$total_sales_qty_d1;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt_d1,2); $total_total_sales_amt_d1 +=$total_sales_amt_d1;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty_d2,2); $total_total_sales_qty_d2 +=$total_sales_qty_d2;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt_d2,2); $total_total_sales_amt_d2 +=$total_sales_amt_d2;?>
          </span></td>
		</tr>
		  
		  <? 
 $total_sales_qty_d1 = 0;
 $total_sales_amt_d1 = 0; 
 $total_sales_qty_d2 = 0;
 $total_sales_amt_d2 = 0;}?>
 
 
 <tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Grand Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_qty_d1,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_amt_d1,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_qty_d2,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_amt_d2,2);?>
          </span></td>
 </tr>
 
 
		
		
		</tbody>
		</table>
		<?
}





elseif($_POST['report']==2006020333)
{
		$report="CUSTOMER TO CUSTOMER COMPARISON (PRODUCT GROUP WISE)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$dealer_name_d1 = $_POST['dealer_code'];
 		$dealer_d1=explode("-",$dealer_name_d1);
 		$dealer_d1[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con_d1=" and d.dealer_code=".$dealer_d1[0];
		
		
		$dealer_name_d2 = $_POST['dealer_code_to'];
 		$dealer_d2=explode("-",$dealer_name_d2);
 		$dealer_d2[0];
 		if($_POST['dealer_code_to']!='')
 		$dealer_con_d2=" and d.dealer_code=".$dealer_d2[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 

  <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		<?php /*?> <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_d1[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>To Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_d2[0])?></strong></td>
         </tr>
		 <? }?>
		 <?php */?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>

		<tr>
		<th width="4%" rowspan="2">SL</th>
		<th width="21%" rowspan="2">Item Group Name </th>
		<th width="18%" colspan="2" bgcolor="#99FFFF" style="text-align:center"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_d1[0])?></th>
		<th width="18%" colspan="2" bgcolor="#33CCCC" style="text-align:center"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_d2[0])?></th>
		</tr>
		<tr>
		  <th bgcolor="#99FFFF" style="text-align:center">QUANTITY</th>
		  <th bgcolor="#99FFFF" style="text-align:center"> AMOUNT </th>
		  <th width="9%" bgcolor="#33CCCC" style="text-align:center">QUANTITY</th>
		  <th width="9%" bgcolor="#33CCCC" style="text-align:center">AMOUNT</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}

		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		
		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		

		
		 $sql = "select c.item_id, s.sub_group_id, sum(c.total_amt) as sales_amt_d1 , sum(c.total_unit) as sales_qty_d1
		 from sale_do_master m, sale_do_chalan c, dealer_info d,  zon z, item_info i, item_sub_group s, item_group g
		 where c.dealer_code=d.dealer_code  and z.ZONE_CODE=d.zone_code and m.do_no=c.do_no and c.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and 
		  c.chalan_date between '".$f_date."' and '".$t_date."' ".$con.$group_for_con.$dealer_con_d1.$item_sub_con.$item_group_con.$item_mother_group_con.$item_type_con." group by i.sub_group_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt_d1[$info->sub_group_id]=$info->sales_amt_d1;
		 $sales_qty_d1[$info->sub_group_id]=$info->sales_qty_d1;
		
		}
		
		
		
		 $sql = "select c.item_id, s.sub_group_id, sum(c.total_amt) as sales_amt_d2 , sum(c.total_unit) as sales_qty_d2
		 from sale_do_master m, sale_do_chalan c, dealer_info d,  zon z, item_info i, item_sub_group s, item_group g
		 where c.dealer_code=d.dealer_code  and z.ZONE_CODE=d.zone_code and m.do_no=c.do_no and c.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and 
		  c.chalan_date between '".$f_date."' and '".$t_date."' ".$con.$group_for_con.$dealer_con_d2.$item_sub_con.$item_group_con.$item_mother_group_con.$item_type_con." group by i.sub_group_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt_d2[$info->sub_group_id]=$info->sales_amt_d2;
		 $sales_qty_d2[$info->sub_group_id]=$info->sales_qty_d2;
		
		}
		
		
		
		
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and g.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and g.group_for="'.$group_for.'"';}
		}
		

		
		
	   $sql_sub="select i.sub_group_id, s.sub_group_name, g.group_id, g.group_name from item_info i, item_sub_group s, item_group g where  s.group_id=g.group_id and
		i.sub_group_id=s.sub_group_id and g.product_type='Finish Goods' ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con." 
		group by g.group_id order by g.group_for, g.item_group_sl";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		<tr>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->group_name?>
		  </strong></div></td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		</tr>
		
		<?
		
		
		 $sql="select distinct i.item_id, i.item_name, s.sub_group_id, s.sub_group_name from item_info i, item_sub_group s, item_group g where s.group_id=g.group_id and i.sub_group_id=s.sub_group_id and g.product_type='Finish Goods' and s.group_id='".$info_sub->group_id."' 
		 ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con." 
		 group by s.sub_group_id,g.group_id order by s.group_for, s.sub_group_sl";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_qty[$row->item_id]<>0 || $foc_qty[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sub_group_name?></td>
		<td><? if ($sales_qty_d1[$row->sub_group_id]>0) {?><?=number_format($sales_qty_d1[$row->sub_group_id],2); $total_sales_qty_d1 +=$sales_qty_d1[$row->sub_group_id]; ?> <? }?></td>
		<td><? if ($sales_amt_d1[$row->sub_group_id]>0) {?>
		  <?=number_format($sales_amt_d1[$row->sub_group_id],2); $total_sales_amt_d1 +=$sales_amt_d1[$row->sub_group_id]; ?>
          <? }?></td>
		<td><? if ($sales_qty_d2[$row->sub_group_id]>0) {?><?=number_format($sales_qty_d2[$row->sub_group_id],2); $total_sales_qty_d2 +=$sales_qty_d2[$row->sub_group_id];?> <? }?></td>
		<td><? if ($sales_amt_d2[$row->sub_group_id]>0) {?>
		  <?=number_format($sales_amt_d2[$row->sub_group_id],2); $total_sales_amt_d2 +=$sales_amt_d2[$row->sub_group_id];?>
          <? }?></td>
		</tr>
<? } ?>
		<tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong> Sub Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty_d1,2); $total_total_sales_qty_d1 +=$total_sales_qty_d1;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt_d1,2); $total_total_sales_amt_d1 +=$total_sales_amt_d1;?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty_d2,2); $total_total_sales_qty_d2 +=$total_sales_qty_d2;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt_d2,2); $total_total_sales_amt_d2 +=$total_sales_amt_d2;?>
          </span></td>
		</tr>
		  
		  <? 
 $total_sales_qty_d1 = 0;
 $total_sales_amt_d1 = 0; 
 $total_sales_qty_d2 = 0;
 $total_sales_amt_d2 = 0;}?>
 
 
 <tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Grand Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_qty_d1,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_amt_d1,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_qty_d2,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_amt_d2,2);?>
          </span></td>
 </tr>
 
 
		
		
		</tbody>
		</table>
		<?
}












elseif($_POST['report']==2006020344)
{
		$report="CUSTOMER TO CUSTOMER SALES REPORT (PRODUCT WISE)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$dealer_name = $_POST['dealer_code'];
 		$dealer=explode("-",$dealer_name);
 		$dealer[0];
 		if($_POST['dealer_code']!='')
 		$dealer_con=" and d.dealer_code=".$dealer[0];
		
		if($_POST['return_type']!='')
 		$return_type_con=" and m.return_type=".$_POST['return_type'];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
	
		 
		 
		 
  <? if ($item_mother_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Mother Group: <?=find_a_field('item_mother_group','mother_group_name','id='.$item_mother_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Group: <?=find_a_field('item_group','group_name','group_id='.$item_group)?></strong></td>
         </tr>
		 <? }?>
		 
		  <? if ($item_sub_group>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Product Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($zone_id>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Zone Name: <?=find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($dealer_code>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Dealer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer[0])?></strong></td>
         </tr>
		 <? }?>
		 
		 <? if ($_POST['return_type']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Return Type: <?=find_a_field('sale_return_type','return_type','id='.$_POST['return_type'])?></strong></td>
         </tr>
		 <? }?>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/fg-logo.png" style="width:100px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
	
		<tr>
		<th width="2%" rowspan="2">SL</th>
		<th width="20%" rowspan="2">Item Name </th>
		<th width="8%" rowspan="2" bgcolor="#99FFFF" style="text-align:center">QUANTITY</th>
		<th colspan="2" bgcolor="#33CCCC" style="text-align:center"> SALES AMOUNT </th>
		<th width="9%" rowspan="2" bgcolor="#FF0000" style="text-align:center">REDISTRIBUTION COST</th>
		</tr>
		<tr>
		  <th width="9%" bgcolor="#33CCCC" style="text-align:center">RETURN AMT </th>
		  <th width="11%" bgcolor="#33CCCC" style="text-align:center">SALES AMT </th>
		  </tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}

		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}


		  $sql = "select c.item_id, sum(c.total_unit) as quantity, sum(c.return_amt) as return_amt, sum(c.total_amt) as sales_amt
		  from sale_return_master m, sale_return_details c, dealer_info d, zon z
		  where c.dealer_code=d.dealer_code and z.ZONE_CODE=d.zone_code  and m.do_no=c.do_no and
		  c.do_date between '".$f_date."' and '".$t_date."'  ".$con.$group_for_con.$dealer_con.$return_type_con." group by c.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $quantity[$info->item_id]=$info->quantity;
		 $return_amt[$info->item_id]=$info->return_amt;
		 $sales_amt[$info->item_id]=$info->sales_amt;
		
  		 
		}
		
		
		
		if ($group_for==4) {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for=3';}
		}else {
			if(isset($group_for)) 					{$group_for_item_con=' and i.group_for="'.$group_for.'"';}
		}

		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}

		
		
	 $sql_sub="select i.sub_group_id, s.sub_group_name from sale_return_master m, sale_return_details d, item_info i, item_sub_group s, item_group g where  
		i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and g.product_type='Finish Goods' and  m.do_no=d.do_no and d.item_id=i.item_id 
		 ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con.$return_type_con." group by i.sub_group_id order by s.group_for, s.sub_group_sl ";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		
		<tr>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->sub_group_name?>
		  </strong></div></td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		  </tr>
		
		
		
		<?
		
		
		 $sql="select distinct i.item_id, i.item_name, s.sub_group_name from sale_return_master m, sale_return_details d, item_info i, item_sub_group s, item_group g where i.sub_group_id=s.sub_group_id and g.product_type='Finish Goods' and m.do_no=d.do_no and d.item_id=i.item_id and s.group_id=g.group_id and i.sub_group_id='".$info_sub->sub_group_id."'
		 ".$item_sub_con.$group_for_item_con.$item_group_con.$item_mother_group_con.$item_type_con.$return_type_con." order by i.item_type, i.item_id, i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_qty[$row->item_id]<>0 || $foc_qty[$row->item_id]<>0 ){}
		?>
		
		
		
		
		
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_name?></td>
		<td><? if ($quantity[$row->item_id]>0) {?><?=number_format($quantity[$row->item_id],2); $total_quantity +=$quantity[$row->item_id]; ?> <? }?></td>
		<td><? if ($return_amt[$row->item_id]>0) {?><?=number_format($return_amt[$row->item_id],2); $total_return_amt +=$return_amt[$row->item_id];?> <? }?></td>
		<td><? if ($sales_amt[$row->item_id]>0) {?>
		  <?=number_format($sales_amt[$row->item_id],2); $total_sales_amt +=$sales_amt[$row->item_id];?>
          <? }?></td>
		<td><? if ($redistribution_cost=($return_amt[$row->item_id]-$sales_amt[$row->item_id])>0) {?>
		<?=number_format($redistribution_cost=($return_amt[$row->item_id]-$sales_amt[$row->item_id]),2); $total_redistribution_cost +=$redistribution_cost;?><? }?></td>
		</tr>
<? } ?>
		<tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Sub Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_quantity,2); $total_total_quantity +=$total_quantity;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_return_amt,2); $total_total_return_amt +=$total_return_amt;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_amt,2); $total_total_sales_amt +=$total_sales_amt;?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_redistribution_cost,2); $total_total_redistribution_cost +=$total_redistribution_cost;?>
		  </span></td>
		  </tr>
		  
		  <? $total_quantity = 0;
		     $total_return_amt = 0;
			 $total_sales_amt = 0; 
			 $total_redistribution_cost = 0; 
			}?>
 
 
 <tr>
		  <td>&nbsp;</td>
		  <td><div align="right" style="text-transform:uppercase"><strong>Grand Total:</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_total_quantity,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_return_amt,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_sales_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_redistribution_cost,2);?>
		  </span></td>
		  </tr>
 
 
		
		
		</tbody>
</table>
		<?
}










elseif($_POST['report']==1113){?>
  <!--National Sales Statement (Item Wise)-->
  <table width="101%" cellspacing="0" cellpadding="2" border="0">
    <thead>
      <tr>
        <td style="border:0px;" colspan="17"><div class="header">
            <h1>M. Ahmed Tea & Lands Co. Ltd </h1>
            <h2>
              <?=$report?>
            </h2>
            <h2><b>National Sales Statement (Item Wise)</b></h2>
          </div>
          <div class="left"></div>
          <div class="right"></div>
          <div class="header">
            <!--<h2>DEPOT: <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id)?></h2>-->
            <h2 style="margin:0; padding:0;">Date Interval:
			
			
			
              <?=date("j-M-Y",strtotime($f_date));?> 
              <strong>to</strong> 
              <?=date("j-M-Y",strtotime($to_date));?>
            </h2>
          </div>
          <div class="date">Reporting Time:
            <?=date("h:i A d-m-Y")?>
        </div></td>
      </tr>
      <tr>
        <td style="border:0px;" colspan="17"></td>
      </tr>
      <?php
if($_POST['t_date']!=''){$to_mon=explode('-',$_POST['t_date']);}
 
$sqlw='select * from warehouse where warehouse_id in(1,2,3)';
$queryw=db_query($sqlw);
while($dataw=mysqli_fetch_object($queryw)){

?>
      <tr>
        <th colspan="17" bgcolor="#99FFFF" align="center"><div align="center">DEPOT: <?php echo $dataw->warehouse_name?></div></th>
      </tr>
      <tr>
        <th width="1%">S/L</th>
        <th width="10%">Month</th>
        <th width="5%">10GM</th>
        <th width="6%">50Gm</th>
        <th width="6%">100GM</th>
        <th width="6%">200GM</th>
        <th width="6%">500GM(A)</th>
        <th width="3%">500Gm(H) </th>
        <th width="3%">500Gm (TS) </th>
        <th width="6%">1Kg</th>
        <th width="6%">500GM(D) </th>
        <th width="6%">Tea Bag </th>
        <th width="6%">T B CTN </th>
        <th width="6%">Bag in Bag </th>
        <th width="6%">B n B CTN </th>
        <th width="8%">Total Kgs </th>
        <th width="9%">Amount</th>
      </tr>
    </thead>
    <tbody>
      <?

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';}




if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con_in=' and chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if(isset($depot_id)) 			{$depot_con_in=' and depot_id="'.$depot_id.'"';}
$tot_in_con=$date_con_in.$depot_con_in;

if($dataw->warehouse_id==2){
$depot_conn=' and depot_id in(2)';
}else{
$depot_conn=' and depot_id='.$dataw->warehouse_id;
}

$depot_conn.=' and unit_price>0';
/*$sqle='select distinct c.dealer_code, d.dealer_name_e, d.area_code, d.zone_name  from dealer_info d, sale_do_chalan c  where d.dealer_code=c.dealer_code'.$date_con.$depot_con." order by d.zone_name desc";
$query=db_query($sqle);
while($data=mysqli_fetch_object($query)){*/
$year = $to_mon[0];
for($i=1;$i<($to_mon[1]+1);$i++){

$mon=date('m',mktime(0,0,0,$i,1,date('Y')));


$from_date=date($year.'-'.$mon.'-01');
$to_date=date($year.'-'.$mon.'-31');

?>
      <tr>
        <td><?=++$j?></td>
        <td><?=date('F',mktime(0,0,0,$i,1,date('Y')))?></td>
        <td><? $gm_10=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010001 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id'); $tot_gm_10+=$gm_10; echo number_format($gm_10,2)?></td>
        <td><? $gm_50=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010002 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id'); $tot_gm_50+=$gm_50;  echo number_format($gm_50,2)?></td>
        <td style="text-align:left"><? $gm_100=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010003 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_100+=$gm_100;  echo number_format($gm_100,2)//echo 'sale_do_chalan','sum(total_unit)','item_id=1096000900010003 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id';?></td>
        <td style="text-align:left"><? $gm_200=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010004 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_200+=$gm_200; echo number_format($gm_200,2)?></td>
        <td style="text-align:left"><? $gm_500A=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010005 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_500A+=$gm_500A;  echo number_format($gm_500A,2)?></td>
        <td style="text-align:left"><? $gm_500H=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010008 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_500H+=$gm_500H; echo number_format($gm_500H,2)?></td>
        <td style="text-align:left"><? $gm_500ts=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010011 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_500ts+=$gm_500ts; echo number_format($gm_500ts,2)?></td>
        <td style="text-align:left"><? $gm_1000=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010006 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_1000+=$gm_1000; echo number_format($gm_1000,2)?></td>
        <td style="text-align:left"><? $gm_500D=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010007 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_500D+=$gm_500D; echo number_format($gm_500D,2)?></td>
        <td style="text-align:left"><? $tea_bag=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010009 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_tea_bag+=$tea_bag;  echo number_format($tea_bag,2)?></td>
        <td style="text-align:left"><?php echo number_format(($tea_bag/8),2); $t_ctn=($tea_bag/8); $tot_t_ctn+=$t_ctn;?></td>
        <td style="text-align:left"><? $bag_in_bag=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010010 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_bag_in_bag+=$bag_in_bag; echo number_format($bag_in_bag,2)?></td>
        <td style="text-align:right"><?php echo number_format(($bag_in_bag/8),2); $b_ctn=($bag_in_bag/8); $tot_b_ctn+=$b_ctn;?></td>
        <td style="text-align:right"><? $item_kg= find_a_field('sale_do_chalan','sum(total_unit)',' chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn);
	
	//echo ' chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id';  
	$tot_item_kg+=$item_kg;  echo number_format($item_kg,2);?></td>
        <td style="text-align:right"><? $amount=find_a_field('sale_do_chalan','sum(total_amt)',' chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn);  $tot_amount+=$amount; echo number_format($amount,2)?></td>
      </tr>
      <?
} ?>
      <tr>
        <td>&nbsp;</td>
        <td><b>Total = </b></td>
        <td><span style="text-align:right"><strong><?php echo number_format($tot_gm_10,2); $gtot_gm_10+=$tot_gm_10;?></strong></span></td>
        <td><span style="text-align:right"><strong><?php echo number_format($tot_gm_50,2); $gtot_gm_50+=$tot_gm_50; ?></strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_100,2); $gtot_gm_100+=$tot_gm_100;?></strong></span></td>
		
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_200,2); $gtot_gm_200+=$tot_gm_200; ?></strong></span></td>
		
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_500A,2); $gtot_gm_500A+=$tot_gm_500A; ?></strong></span></td>
		
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_500H,2); $gtot_gm_500H+=$tot_gm_500H; ?></strong></span></td>
		
        <td style="text-align:right"><strong><?php echo number_format($tot_gm_500ts,2); $gtot_gm_500ts+=$tot_gm_500ts; ?></strong></td>
		
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_1000,2); $gtot_gm_1000+=$tot_gm_1000;?></strong></span></td>
		
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_500D,2); $gtot_gm_500D+=$tot_gm_500D;?></strong></span></td>
		
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_tea_bag,2); $gtot_tea_bag+=$tot_tea_bag; ?></strong></span></td>
		
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_t_ctn,2); $gtot_t_ctn+=$tot_t_ctn; ?></strong></span></td>
		
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_bag_in_bag,2); $gtot_bag_in_bag+=$tot_bag_in_bag; ?></strong></span></td>
        <td style="text-align:right"><strong><?php echo number_format($tot_b_ctn,2); $gtot_b_ctn+=$tot_b_ctn; ?></strong></td>
        <td style="text-align:right"><strong><?php echo number_format($tot_item_kg,2); $gtot_item_kg+=$tot_item_kg; ?></strong></td>
        <td style="text-align:right"><strong><?php echo number_format($tot_amount,2); $gtot_amount+=$tot_amount; ?></strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><strong>Total(%)</strong> </td>
        <td><span style="text-align:right"><strong><?php echo number_format((($tot_gm_10/$tot_item_kg)*100),2); ?>% </strong></span></td>
        <td><span style="text-align:right"><strong><?php echo number_format((($tot_gm_50/$tot_item_kg)*100),2); ?>% </strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_100/$tot_item_kg)*100),2); ?>% </strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_200/$tot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_500A/$tot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_500H/$tot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:right"><strong><?php echo number_format((($tot_gm_500ts/$tot_item_kg)*100),2); ?>%</strong></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_1000/$tot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_500D/$tot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_tea_bag/$tot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left">&nbsp;</td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_bag_in_bag/$tot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:right">&nbsp;</td>
        <td style="text-align:right"><strong><?php echo number_format((($tot_item_kg/$tot_item_kg)*100),2);  ?>%</strong></td>
        <td style="text-align:right">&nbsp;</td>
      </tr>
      <? 
$tot_item_kg=0; $tot_gm_10=0; $tot_gm_50=0;  $tot_gm_100=0; $tot_gm_200=0; $tot_gm_500A=0; $tot_gm_500H=0;  $tot_gm_500ts=0;  $tot_gm_1000=0;  $tot_gm_500D=0; $tot_tea_bag=0; $tot_t_ctn=0; $tot_bag_in_bag=0; $tot_b_ctn=0; $tot_amount=0;
}
?>
      <tr>
        <td>&nbsp;</td>
        <td><b>Grand Total = </b></td>
        <td><span class="style1">
          <?=number_format($gtot_gm_10,2)?>
          </span> </td>
        <td><span class="style2">
          <?=number_format($gtot_gm_50,2)?>
          </span> </td>
        <td style="text-align:left"><span class="style3">
          <?=number_format($gtot_gm_100,2)?>
          </span> </td>
        <td style="text-align:left"><span class="style4">
          <?=number_format($gtot_gm_200,2)?>
          </span> </td>
        <td style="text-align:left"><span class="style5">
          <?=number_format($gtot_gm_500A,2)?>
          </span> </td>
        <td style="text-align:left"><span class="style6">
          <?=number_format($gtot_gm_500H,2)?>
          </span> </td>
        <td style="text-align:left"><span class="style24">
          <?=number_format($gtot_gm_500ts,2)?>
        </span></td>
        <td style="text-align:left"><span class="style7">
          <?=number_format($gtot_gm_1000,2)?>
          </span> </td>
        <td style="text-align:left"><span class="style8">
          <?=number_format($gtot_gm_500D,2)?>
          </span> </td>
        <td style="text-align:left"><span class="style9">
          <?=number_format($gtot_tea_bag,2)?>
          </span> </td>
        <td style="text-align:left"><span class="style10">
          <?=number_format($gtot_t_ctn,2)?>
          </span> </td>
        <td style="text-align:left"><span class="style13">
          <?=number_format($gtot_bag_in_bag,2)?>
          </span></td>
        <td style="text-align:right"><span class="style11">
          <?=number_format($gtot_b_ctn,2)?>
          </span> </td>
        <td style="text-align:right"><span class="style12">
          <?=number_format($gtot_item_kg,2)?>
          </span></td>
        <td style="text-align:right"><strong>
          <?=number_format($gtot_amount,2)?>
          </strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><b>Grand(%) </b></td>
        <td><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_10/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_50/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_100/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_200/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_500A/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_500H/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:right"><strong><?php echo number_format((($gtot_gm_500ts/$gtot_item_kg)*100),2); ?>%</strong></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_1000/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_500D/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_tea_bag/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:left">&nbsp;</td>
        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_bag_in_bag/$gtot_item_kg)*100),2); ?>%</strong></span></td>
        <td style="text-align:right">&nbsp;</td>
        <td style="text-align:right"><strong><?php echo number_format((($gtot_item_kg/$gtot_item_kg)*100),2);  ?>%</strong></td>
        <td style="text-align:right">&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <!--National Sales Statement (Item Wise)-->
  <? }












elseif($_REQUEST['report']==108) 

{

echo $str;

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

$sqql = "select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;

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

$sqql = "select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

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

$sqql = "select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;;

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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



$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a, zon z where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and z.ZONE_CODE=a.ZONE_ID and z.REGION_ID='".$BRANCH_ID."'".$con;







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





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;



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





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;

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













elseif($_REQUEST['report']==110) 

{echo $str;

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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



$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and a.ZONE_ID ='".$ZONE_CODE."'".$con;







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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

$sqql = "select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and a.ZONE_ID ='".$ZONE_CODE."'".$con;

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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



$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,area a where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.area_code=a.AREA_CODE and a.ZONE_ID ='".$ZONE_CODE."'".$con;







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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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



$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,item_info i where i.item_id=c.item_id and c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type = 'Corporate' and d.dealer_code='".$dealer_code."'".$item_brand_con.$item_con.$con;







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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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



$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d,item_info i where i.item_id=c.item_id and c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type = 'SuperShop' and d.dealer_code='".$dealer_code."'".$item_brand_con.$item_con.$con;







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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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



$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.dealer_code='".$dealer_code."'".$con;







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





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;



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





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

//if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';}

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

elseif($_REQUEST['report']==114) 

{echo $str;

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

$sqql = "select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.dealer_code='".$dealer_code."'".$con;

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

$sqql = "select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;

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

$sqql = "select sum(c.pkt_unit) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;;

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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



$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Distributor' and d.dealer_code='".$dealer_code."'".$con;







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





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='Corporate'".$con;



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





$sqql = "select sum(c.total_amt) from sale_do_chalan c,dealer_info d where c.chalan_date between '".${'f_mons'.$i}."' and '".${'f_mone'.$i}."' and c.dealer_code=d.dealer_code and d.dealer_type='SuperShop'".$con;

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

$sql = "select sum(c.total_amt) as total_amt,c.do_date from sale_do_details c,dealer_info d where c.do_date between '".$f_date."' and '".$t_date."' and c.dealer_code=d.dealer_code and d.dealer_type!='Distributor' and c.total_amt>0 group by c.do_date";

$query = db_query($sql);

while($data=mysqli_fetch_object($query)){${'X'.$data->do_date} = $data->total_amt;}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}

?>


<table width="100%" border="0" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" style="border:0px;border-color:#FFF;" >
<tr>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
<tr>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
<tr>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
<tr>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
<tr>
<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Sr Executive</u></strong></td>

<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Asst. Manager</u></strong></td>

<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Manager</u></strong></td>

<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Sr Manager</u></strong></td>
</tr>
<tr>
  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
</table>


<!--<table width="100%" cellspacing="0" cellpadding="0"  style="border:1px solid #000; color: #000;" >
          

          <tr>
            <td colspan="2" style="border:0px;border-color:#FFF; color: #000; font-size:18px; font-weight:700;" align="center" ><?=$_SESSION['company_name']?> </td>
		</tr>
		  <tr>
			 <td colspan="2" style="border:0px;border-color:#FFF; color: #000;  font-size:14px; " align="center" ><?=$_SESSION['company_address']?></td>
		</tr>
		  <tr>
			 <td colspan="2" style="border:0px;border-color:#FFF; color: #000; font-size:14px; " align="center" >Teliphone: 
			  <?=find_a_field('project_info','proj_phone','company_name="'.$_SESSION['company_name'].'"');?></td>
          </tr>
		  <tr>
			 <td colspan="2" style="border:0px;border-color:#FFF; color: #000; font-size:14px; " align="center" >E-mail: 
			  <?=find_a_field('project_info','proj_email','company_name="'.$_SESSION['company_name'].'"');?></td>
          </tr>
</table>-->
		
		
<table width="100%" border="0" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" style="border:0px;border-color:#FFF;" >
<tr>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
</table>

</div>

</body>

</html>