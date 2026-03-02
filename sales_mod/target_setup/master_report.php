<?php

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





date_default_timezone_set('Asia/Dhaka');

//echo $_REQUEST['report'];

if (isset($_REQUEST['submit']) && isset($_REQUEST['report']) && $_REQUEST['report'] > 0) {

	if ((strlen($_REQUEST['t_date']) == 10)) {

		$t_date = $_REQUEST['t_date'];

		$f_date = $_REQUEST['f_date'];
	}



	if ($_REQUEST['product_group'] != '')  $product_group = $_REQUEST['product_group'];

	if ($_REQUEST['item_brand'] != '') 	$item_brand = $_REQUEST['item_brand'];

	if ($_REQUEST['item_id'] > 0) 		    $item_id = $_REQUEST['item_id'];

	if ($_REQUEST['dealer_code'] > 0) 	    $dealer_code = $_REQUEST['dealer_code'];

	if ($_REQUEST['dealer_type'] != '') 	$dealer_type = $_REQUEST['dealer_type'];



	if ($_REQUEST['status'] != '') 		$status = $_REQUEST['status'];

	if ($_REQUEST['do_no'] != '') 		    $do_no = $_REQUEST['do_no'];

	if ($_REQUEST['area_id'] != '') 		$area_id = $_REQUEST['area_id'];

	if ($_REQUEST['zone_id'] != '') 		$zone_id = $_REQUEST['zone_id'];

	if ($_REQUEST['region_id'] > 0) 		$region_id = $_REQUEST['region_id'];

	if ($_REQUEST['depot_id'] != '') 		$depot_id = $_REQUEST['depot_id'];

	if ($_REQUEST['month_id'] != '') 		$month_id = $_REQUEST['month_id'];



	$item_info = find_all_field('item_info', '', 'item_id=' . $item_id);



	if (isset($item_brand)) {
		$item_brand_con = ' and i.item_brand="' . $item_brand . '"';
	}

	if (isset($dealer_code)) {
		$dealer_con = ' and a.dealer_code="' . $dealer_code . '"';
	}



	if (isset($t_date)) {
		$to_date = $t_date;
		$fr_date = $f_date;
		$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
	}



	if (isset($product_group)) {

		if ($product_group == 'ABCDE')

			$pg_con = ' and d.product_group!="M" and d.product_group!=""';

		else $pg_con = ' and d.product_group="' . $product_group . '"';
	}



	/*if(isset($product_group)) {			

	if($product_group=='ABCDE') 	{$pg_con=' and d.product_group!="M" and d.product_group!=""';}

	elseif($product_group=='ABD')	{$pg_con = ' and i.sales_item_type in ("A","B","D") ';}

	elseif($product_group=='CE') 	{$pg_con = ' and i.sales_item_type in ("C","E") ';}

	else 							{$pg_con=' and i.sales_item_type="'.$product_group.'"';}

}*/





	//if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dtype_con=' and d.dealer_type="Distributor"';} else {$dtype_con=' and d.dealer_type!="Distributor"';}}

	//if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';} else {$dealer_type_con=' and d.dealer_type!="Distributor"';}} 

	if ($dealer_type != '') {

		if ($dealer_type == 'MordernTrade') {
			$dtype_con = $dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';
		} else {
			$dtype_con = $dealer_type_con = ' and d.dealer_type="' . $dealer_type . '"';
		}
	}



	if (isset($dealer_code)) {
		$dealer_con = ' and m.dealer_code=' . $dealer_code;
	}

	if (isset($item_id)) {
		$item_con = ' and i.item_id=' . $item_id;
	}

	if (isset($depot_id)) {
		$depot_con = ' and d.depot="' . $depot_id . '"';
	}

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

			$report = "Sales Order Brief Report";

			break;

		case 1100:

			$report = "Sales Return Report";

			break;



		case 21:

			$report = "Over DO Report";



			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;

				$date_con .= ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}

			if (isset($dealer_code)) {
				$con .= ' and d.dealer_code="' . $dealer_code . '"';
			}

			if (isset($dealer_type)) {

				if ($dealer_type == 'MordernTrade') {
					$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';
				} else {
					$dealer_type_con = ' and d.dealer_type="' . $dealer_type . '"';
				}
			}



			$sql = 'select m.do_date, m.do_no, m.dealer_code, d.dealer_name_e as dealer_name, d.product_group,

m.rcv_amt as do_receive, m.payment_by, m.bank, m.branch,

m.received_amt as acc_receive, m.rec_date,m.checked_at, 

m.received_status,m.send_to_depot_at as do_approve_time,m.remarks,m.pb_amt as opening_balance, do_total as do_amount, m.over_do



from dealer_info d, sale_do_master m

where d.dealer_code=m.dealer_code

' . $date_con . $warehouse_con . $item_con . $dealer_type_con . $pg_con . ' 

and m.over_do>0 and m.status in ("CHECKED","COMPLETED")

group by m.do_no

order by do_approve_time';





			break;







		case 301:

			$report = "DO Pending Summary Brief";

			break;





		case 1999:

			$report = "DO Report for Scratch Card";

			$product_group = 'A';

			break;



		case 2001:

			$report = "Item Wise Chalan  Details Report (At A Glance)";



			break;











		case 2002:

			$report = "Last Year Vs This Year Item Wise Sales Report (Periodical)";

			break;



		case 2022:

			$report = "Last Month Vs This Month Item Wise Sales Report (Periodical)";

			break;





		case 3001:

			$report = "Last Year Vs This Year Zone/Item Wise Sales Report";

			break;





		case 2005:

			$report = "Yearly Distributor Sales Report";

			if (isset($t_date)) {

				$to_date = $t_date;

				$fr_date = $f_date;



				$yfr_date = (date(('Y'), strtotime($f_date)) - 1) . date(('-m-d'), strtotime($f_date));

				$yto_date = (date(('Y'), strtotime($t_date)) - 1) . date(('-m-d'), strtotime($t_date));



				$date_con = ' and a.chalan_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';

				$ydate_con = ' and a.chalan_date between \'' . $yfr_date . '\' and \'' . $yto_date . '\'';
			}

			if (isset($depot_id)) {
				$con .= ' and d.depot="' . $depot_id . '"';
			}

			if (isset($dealer_code)) {
				$con .= ' and d.dealer_code="' . $dealer_code . '"';
			}

			if (isset($dealer_type)) {
				$con .= ' and d.dealer_type="' . $dealer_type . '"';
			}

			if (isset($product_group)) {
				$pg_con = ' and i.sales_item_type like "%' . $product_group . '%"';
			}



			break;



		case 2004:

			$report = "Last Year Vs This Year Item Wise Sales Report(With National Target)";

			break;



		case 2008:

			$report = "National Sales Vs National Target(Year 2 Year Item wise)";



			break;



		case 2009:

			$report = "Modern Trade Sales Vs Target";

			break;



		case 201:

			$report = "Group wise sales Comparison Report";



			break;



		case 2006:

			$report = "Last Year Vs This Year Item Wise Sales Report(With Target)";

			break;



		case 2025:

			$report = "Item Wise Target Vs Primary DO Report";

			break;



		case 2007:

			$report = "Party wise Target Vs Sales";



			break;



		case 2003:

			$report = "Last Year Vs This Year Single Item Dealer Wise Sales Report (Periodical)";

			if (isset($t_date)) {

				$to_date = $t_date;
				$fr_date = $f_date;

				$yfr_date = (date(('Y'), strtotime($f_date)) - 1) . date(('-m-d'), strtotime($f_date));

				$yto_date = (date(('Y'), strtotime($f_date)) - 1) . date(('-m-d'), strtotime($t_date));



				$date_con = ' and a.chalan_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';

				$ydate_con = ' and a.chalan_date between \'' . $yfr_date . '\' and \'' . $yto_date . '\'';
			}

			if (isset($product_group)) {

				if ($product_group == 'ABD') {
					$pg_con = ' and i.sales_item_type in ("A","B","D") ';
				} elseif ($product_group == 'CE') {
					$pg_con = ' and i.sales_item_type in ("C","E") ';
				} else {
					$pg_con = ' and i.sales_item_type="' . $product_group . '"';
				}
			}





			if (isset($depot_id)) {
				$con .= ' and d.depot="' . $depot_id . '"';
			}

			if (isset($dealer_code)) {
				$con .= ' and d.dealer_code="' . $dealer_code . '"';
			}

			if (isset($dealer_type)) {
				$con .= ' and d.dealer_type="' . $dealer_type . '"';
			}

			if (isset($item_id)) {
				$con .= ' and a.item_id="' . $item_id . '"';
			}



			if (isset($area_id)) {
				$acon .= ' and a.AREA_CODE="' . $area_id . '"';
			}

			if (isset($zone_id)) {
				$acon .= ' and z.ZONE_CODE="' . $zone_id . '"';
			}

			if (isset($region_id)) {
				$acon .= ' and b.BRANCH_ID="' . $region_id . '"';
			}

			$sql = 'select 

		dealer_name_e dealer_name,

		dealer_code,

		AREA_NAME area_name,

		ZONE_NAME zone_name,

		BRANCH_NAME region_name

		from dealer_info d, area a, branch b, zon z where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=a.AREA_CODE  ' . $product_group_con . $acon . ' 

	    order by dealer_name_e';



			$sql2 = 'select 

		d.dealer_code,

		sum(a.total_unit) div i.pack_size as pkt,

		sum(a.total_unit) qty,		

		sum(a.total_unit*a.unit_price) as sale_price

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i where 

		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  

	a.unit_price>0 ' . $con . $date_con . $product_group_con . $item_con . ' 

	group by  d.dealer_code';

			$query2 = db_query($sql2);

			while ($data2 = mysqli_fetch_object($query2)) {

				$this_year_sale_amt[$data2->dealer_code] = $data2->sale_price;

				$this_year_sale_qty[$data2->dealer_code] = $data2->qty;

				$this_year_sale_pkt[$data2->dealer_code] = $data2->pkt;
			}





			/*$sql2='select 

		i.item_id,

		sum(a.total_unit) div i.pack_size as pkt,

		sum(a.total_unit) qty,		

		sum(a.total_unit*a.unit_price) as sale_price

		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i where 

		d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  

	a.unit_price>0  and a.item_id=i.item_id '.$con.$ydate_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 

	group by  a.item_id';*/





			// last year	

			$sql2 = 'select 

		d.dealer_code,

		sum(a.total_unit) div i.pack_size as pkt,

		sum(a.total_unit) qty,		

		sum(a.total_unit*a.unit_price) as sale_price

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i where 

		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  

	a.unit_price>0 ' . $con . $ydate_con . $product_group_con . $item_con . ' 

	group by  d.dealer_code';

			$query2 = db_query($sql2);

			while ($data2 = mysqli_fetch_object($query2)) {

				$last_year_sale_amt[$data2->dealer_code] = $data2->sale_price;

				$last_year_sale_qty[$data2->dealer_code] = $data2->qty;

				$last_year_sale_pkt[$data2->dealer_code] = $data2->pkt;
			}

			break;



		case 20031:

			$report = "Last Year Vs This Year Single Item Region Wise Sales Report (Periodical)";

			if (isset($t_date)) {

				$to_date = $t_date;
				$fr_date = $f_date;

				$yfr_date = (date(('Y'), strtotime($f_date)) - 1) . date(('-m-d'), strtotime($f_date));

				$yto_date = (date(('Y'), strtotime($f_date)) - 1) . date(('-m-d'), strtotime($t_date));



				$date_con = ' and a.chalan_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';

				$ydate_con = ' and a.chalan_date between \'' . $yfr_date . '\' and \'' . $yto_date . '\'';
			}

			if (isset($product_group)) {
				$product_group_con .= ' and d.product_group="' . $product_group . '"';
			}

			if (isset($depot_id)) {
				$con .= ' and d.depot="' . $depot_id . '"';
			}

			if (isset($dealer_code)) {
				$con .= ' and d.dealer_code="' . $dealer_code . '"';
			}

			if (isset($dealer_type)) {
				$con .= ' and d.dealer_type="' . $dealer_type . '"';
			}

			if (isset($item_id)) {
				$con .= ' and a.item_id="' . $item_id . '"';
			}



			if (isset($area_id)) {
				$acon .= ' and a.AREA_CODE="' . $area_id . '"';
			}

			if (isset($zone_id)) {
				$acon .= ' and z.ZONE_CODE="' . $zone_id . '"';
			}

			if (isset($region_id)) {
				$acon .= ' and b.BRANCH_ID="' . $region_id . '"';
			}



			$sql = 'select 

		BRANCH_NAME region_name,

		BRANCH_ID

		from dealer_info d, area a, branch b, zon z 

		where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=a.AREA_CODE  ' . $product_group_con . $acon . ' 

	    group by BRANCH_NAME';



			// this year

			$sql2 = 'select 

		BRANCH_ID,

		sum(a.total_unit) div i.pack_size as pkt,

		sum(a.total_unit) qty,		

		sum(a.total_unit*a.unit_price) as sale_price

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i, area ar, branch b, zon z 

		where 

		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  

		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 

	a.unit_price>0 ' . $con . $date_con . $product_group_con . $item_con . ' 

	group by BRANCH_NAME';

			$query2 = db_query($sql2);

			while ($data2 = mysqli_fetch_object($query2)) {

				$this_year_sale_amt[$data2->BRANCH_ID] = $data2->sale_price;

				$this_year_sale_qty[$data2->BRANCH_ID] = $data2->qty;

				$this_year_sale_pkt[$data2->BRANCH_ID] = $data2->pkt;
			}



			// last year

			$sql2 = 'select 

		BRANCH_ID,

		sum(a.total_unit) div i.pack_size as pkt,

		sum(a.total_unit) qty,		

		sum(a.total_unit*a.unit_price) as sale_price

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i , area ar, branch b, zon z  where 

		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  

		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 

	a.unit_price>0 ' . $con . $ydate_con . $product_group_con . $item_con . ' 

	group by  BRANCH_NAME';

			$query2 = db_query($sql2);

			while ($data2 = mysqli_fetch_object($query2)) {

				$last_year_sale_amt[$data2->BRANCH_ID] = $data2->sale_price;

				$last_year_sale_qty[$data2->BRANCH_ID] = $data2->qty;

				$last_year_sale_pkt[$data2->BRANCH_ID] = $data2->pkt;
			}

			break;



		case 20032:

			$report = "Last Year Vs This Year Single Item Zone Wise Sales Report (Periodical)";

			if (isset($t_date)) {

				$to_date = $t_date;
				$fr_date = $f_date;

				$yfr_date = (date(('Y'), strtotime($f_date)) - 1) . date(('-m-d'), strtotime($f_date));

				$yto_date = (date(('Y'), strtotime($f_date)) - 1) . date(('-m-d'), strtotime($t_date));



				$date_con = ' and a.chalan_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';

				$ydate_con = ' and a.chalan_date between \'' . $yfr_date . '\' and \'' . $yto_date . '\'';
			}

			if (isset($product_group)) {
				$product_group_con .= ' and d.product_group="' . $product_group . '"';
			}

			if (isset($depot_id)) {
				$con .= ' and d.depot="' . $depot_id . '"';
			}

			if (isset($dealer_code)) {
				$con .= ' and d.dealer_code="' . $dealer_code . '"';
			}

			if (isset($dealer_type)) {
				$con .= ' and d.dealer_type="' . $dealer_type . '"';
			}

			if (isset($item_id)) {
				$con .= ' and a.item_id="' . $item_id . '"';
			}



			if (isset($area_id)) {
				$acon .= ' and a.AREA_CODE="' . $area_id . '"';
			}

			if (isset($zone_id)) {
				$acon .= ' and z.ZONE_CODE="' . $zone_id . '"';
			}

			if (isset($region_id)) {
				$acon .= ' and b.BRANCH_ID="' . $region_id . '"';
			}



			$sql = 'select 

		ZONE_NAME zone_name,BRANCH_NAME region_name,

		ZONE_CODE

		from dealer_info d, area a, branch b, zon z 

		where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=a.AREA_CODE  ' . $product_group_con . $acon . ' 

	    group by ZONE_CODE';



			$sql2 = 'select 

		ZONE_CODE,

		sum(a.total_unit) div i.pack_size as pkt,

		sum(a.total_unit) qty,		

		sum(a.total_unit*a.unit_price) as sale_price

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i, area ar, branch b, zon z 

		where 

		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  

		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 

	a.unit_price>0 ' . $con . $date_con . $product_group_con . $item_con . ' 

	group by ZONE_CODE';

			$query2 = db_query($sql2);

			while ($data2 = mysqli_fetch_object($query2)) {

				$this_year_sale_amt[$data2->ZONE_CODE] = $data2->sale_price;

				$this_year_sale_qty[$data2->ZONE_CODE] = $data2->qty;

				$this_year_sale_pkt[$data2->ZONE_CODE] = $data2->pkt;
			}



			$sql2 = 'select 

		ZONE_CODE,

		sum(a.total_unit) div i.pack_size as pkt,

		sum(a.total_unit) qty,		

		sum(a.total_unit*a.unit_price) as sale_price

		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i , area ar, branch b, zon z  where 

		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  

		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 

	a.unit_price>0 ' . $con . $ydate_con . $product_group_con . $item_con . ' 

	group by  ZONE_CODE';

			$query2 = db_query($sql2);

			while ($data2 = mysqli_fetch_object($query2)) {

				$last_year_sale_amt[$data2->ZONE_CODE] = $data2->sale_price;

				$last_year_sale_qty[$data2->ZONE_CODE] = $data2->qty;

				$last_year_sale_pkt[$data2->ZONE_CODE] = $data2->pkt;
			}

			break;

		case 1991:



			$report = "Delivery Order Brief Report with Chalan Amount";

			break;

		case 191:

			$report = "Delivery Order  Report (At A Glance)";

			break;



		case 2:

			$report = "Undelivered Do Details Report";



			$sql = "select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,d.product_group as grp,w.warehouse_name as depot,concat(i.finish_goods_code,'- ',item_name) as item_name,o.pkt_unit as crt,o.dist_unit as pcs,o.total_amt,m.rcv_amt,m.payment_by as PB from 

sale_do_master m,sale_do_details o, item_info i,dealer_info d , warehouse w

where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=d.depot " . $date_con . $item_con . $depot_con . $dtype_con . $dealer_con . $item_brand_con;

			break;

		case 3:

			$report = "Undelivered Do Report Dealer Wise";

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}

			if (isset($dealer_code)) {
				$dealer_con = ' and m.dealer_code=' . $dealer_code;
			}

			if (isset($item_id)) {
				$item_con = ' and i.item_id=' . $item_id;
			}

			if (isset($depot_id)) {
				$depot_con = ' and d.depot="' . $depot_id . '"';
			}

			break;

		case 4:

			if ($_REQUEST['do_no'] > 0)

				header("Location:work_order_print.php?wo_id=" . $_REQUEST['wo_id']);

			break;

		case 5:

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			$report = "Delivery Order Brief Report (Region Wise)";

			break;

		case 6:

			if ($_REQUEST['do_no'] > 0)

				header("Location:../report/do_view.php?v_no=" . $_REQUEST['do_no']);

			break;



		case 7:

			$report = "Item wise DO Report";



			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			if (isset($depot_id)) {
				$depot_con = ' and d.depot="' . $depot_id . '"';
			}

			if (isset($area_id)) {
				$acon .= ' and d.area_code="' . $area_id . '"';
			}

			if (isset($zone_id)) {
				$acon .= ' and d.zone_id="' . $zone_id . '"';
			}

			if (isset($region_id)) {
				$acon .= ' and d.region_id="' . $region_id . '"';
			}



			if (isset($dealer_type)) {
				$acon .= ' and d.dealer_type="' . $dealer_type . '"';
			}



			$sql = "select 

		i.finish_goods_code as code, 

		i.item_name, i.item_brand, 

		i.sales_item_type as `group`, i.brand_category_type as item_category,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as dp_total

		from 

		sale_do_master m,sale_do_details o, item_info i, dealer_info d

		where  m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') 

" . $dtype_con . $date_con . $item_con . $item_brand_con . $pg_con . $depot_con . $acon . "  

and finish_goods_code not between 2000 and 2005

		group by i.finish_goods_code";



			break;



		case 2015:

			$report = "Item wise Secondary Sales Report";



			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			if (isset($depot_id)) {
				$depot_con = ' and d.depot="' . $depot_id . '"';
			}

			if (isset($area_id)) {
				$acon .= ' and d.area_code="' . $area_id . '"';
			}

			if (isset($zone_id)) {
				$acon .= ' and d.zone_id="' . $zone_id . '"';
			}

			if (isset($region_id)) {
				$acon .= ' and d.region_id="' . $region_id . '"';
			}



			if (isset($dealer_type)) {
				$acon .= ' and d.dealer_type="' . $dealer_type . '"';
			}



			$sql = "select 

		i.finish_goods_code as code, 

		i.item_name, i.item_brand, 

		i.sales_item_type as `group`, i.brand_category_type as item_category,

		floor(sum(o.total_unit)/i.pack_size) as crt,

		mod(sum(o.total_unit),i.pack_size) as pcs, 

		sum(o.total_amt)as dp_total

		from 

		ss_do_master m,ss_do_details o, item_info i, dealer_info d

		where  m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') 

" . $dtype_con . $date_con . $item_con . $item_brand_con . $pg_con . $depot_con . $acon . "  

and finish_goods_code not between 2000 and 2005

		group by i.finish_goods_code";



			break;



		case 15:

			$report = "Item wise DO Report(Modern Trade)";



			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			if (isset($depot_id)) {
				$depot_con = ' and d.depot="' . $depot_id . '"';
			}



			$sql = "select 

		i.finish_goods_code as code, 

		i.item_name, i.item_brand, 

		i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as amount

from sale_do_master m,sale_do_details o, item_info i, dealer_info d

where 

m.do_no=o.do_no 

and m.dealer_code=d.dealer_code 

and i.item_id=o.item_id

and ( d.dealer_type='Corporate' or d.dealer_type='SuperShop' or d.product_group='M') 

and m.status in ('CHECKED','COMPLETED') " . $dtype_con . $date_con . $item_con . $item_brand_con . $pg_con . $depot_con . $acon . '

group by code';



			break;



		case 701:

			$report = "Item wise Undelivered DO Report(With Gift)";

			break;



		case 704:

			$report = "Storewise Item Undelivered Report(Cash)";

			break;



		case 884:

			$report = "Storewise Item Undelivered Report(Cash)";

			break;



		case 705:

			$report = "Storewise Item Undelivered Report(Ctn)";

			break;







		case 8:

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			$report = "Dealer Performance Report";





		case 9:

			$report = "Item Report (Region + Zone)(Dealer Group)";

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}

			break;



		case 41:

			$report = "Item Report (Region + Zone)(Item Group)";

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}

			break;



		case 14:

			$report = "Item Report (Region)";

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			break;







		case 10:

			$report = "Daily Collection Summary";



			if ($dealer_type != '') {

				if ($dealer_type == 'MordernTrade') {

					$dtype_con = $dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';
				} elseif ($dealer_type == 'Distributor') {

					$dtype_con = $dealer_type_con = ' and d.dealer_type="Distributor" and  d.product_group!="M" ';
				} else {

					$dtype_con = $dealer_type_con = ' and d.dealer_type="' . $dealer_type . '"';
				}
			}





			$sql = "select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 

sale_do_master m, dealer_info d, warehouse w

where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot

" . $date_con . $pg_con . $dtype_con . "

order by m.entry_at";





			break;









		case 11:

			$report = "Daily Collection &amp; Order Summary";



			$sql = "select m.do_no, m.do_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from 

sale_do_master m,dealer_info d  , warehouse w 

where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot" . $date_con . $pg_con . " order by m.entry_at";

			break;







		case 13:

			$report = "Daily Collection Summary(EXT)";



			$sql = "select m.do_no,m.do_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 

sale_do_master m,dealer_info d  , warehouse w

where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot

" . $date_con . $pg_con . $dtype_con . " 

order by m.entry_at";



			break;





		case 99:

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			$report = "Dealer Performance Report";

			break;



		case 401:

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}

			$report = "Dealer Performance Report";

			break;



		case 991:

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			$report = "Dealer Performance Report(ALL)";

			break;

		case 100:

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			$report = "Dealer Performance Report";

			break;





		case 101:

			$report = "Four(4) Months Comparison Report(CRT)";

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}





			$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as dP,

		sum(o.total_unit*o.t_price)as tP

		from 



		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') " . $date_con . $item_con . $item_brand_con . $pg_con . ' group by i.finish_goods_code';

			break;

		case 102:

			$report = "Four(4) Months Comparison Report(TK)";

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}





			$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as dP,

		sum(o.total_unit*o.t_price)as tP

		from 

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') " . $date_con . $item_con . $item_brand_con . $pg_con . ' group by i.finish_goods_code';

			break;

		case 103:

			$report = "Four(4) Months Regioanl Report(CTR)";



			if ($_REQUEST['region_id'] != '') {
				$region_id = $_REQUEST['region_id'];
				$region_name = find_a_field('branch', 'BRANCH_NAME', 'BRANCH_ID=' . $region_id);
			}



			$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as dP,

		sum(o.total_unit*o.t_price)as tP

		from 

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') " . $date_con . $item_con . $item_brand_con . $pg_con . ' group by i.finish_goods_code';

			break;

		case 104:

			$report = "Four(4) Months Regional Report(TK)";



			if ($_REQUEST['region_id'] != '') {
				$region_id = $_REQUEST['region_id'];
				$region_name = find_a_field('branch', 'BRANCH_NAME', 'BRANCH_ID=' . $region_id);
			}



			$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as dP,

		sum(o.total_unit*o.t_price)as tP

		from 

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') " . $date_con . $item_con . $item_brand_con . $pg_con . ' group by i.finish_goods_code';

			break;
		case 105:

			$report = "Four(4) Months Zonal Report(CTR)";



			if ($_REQUEST['zone_id'] != '') {
				$zone_id = $_REQUEST['zone_id'];
				$zone_name = find_a_field('zon', 'ZONE_NAME', 'ZONE_CODE=' . $zone_id);
			}



			$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as dP,

		sum(o.total_unit*o.t_price)as tP

		from 

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') " . $date_con . $item_con . $item_brand_con . $pg_con . ' group by i.finish_goods_code';

			break;

		case 106:

			$report = "Four(4) Months Area Report(TK)";





			if ($_REQUEST['zone_id'] != '') {
				$zone_id = $_REQUEST['zone_id'];
				$zone_name = find_a_field('zon', 'ZONE_NAME', 'ZONE_CODE=' . $zone_id);
			}



			$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,

		floor(sum(o.total_unit)/o.pkt_size) as crt,

		mod(sum(o.total_unit),o.pkt_size) as pcs, 

		sum(o.total_amt)as dP,

		sum(o.total_unit*o.t_price)as tP

		from 

		sale_do_master m,sale_do_details o, item_info i,dealer_info d

		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') " . $date_con . $item_con . $item_brand_con . $pg_con . ' group by i.finish_goods_code';

			break;



		case 107:

			$report = "Yearly Regional Sales Report(TK)";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);



			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-15', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));

				${'f_mos' . $i} = date('Y-m-15', $t_stampq);

				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			$f_date = ${'f_mons' . $i};



			break;

		case 108:

			$report = "Yearly Regional Sales Report(Per Item)(CTN)";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);



			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;

		case 109:

			$report = "Yearly Regional Sales Report(Per Item)(TK)";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);



			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;







		case 110:

			$report = "Yearly Zone Wise Sales Report(Per Item)(Tk)";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);



			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;

		case 111:

			$report = "Yearly Zone Wise Sales Report(Per Item)(CTN)";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);



			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;

		case 112:

			$report = "Yearly Zone Wise Sales Report(Per Item)(Tk)";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);



			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;

		case 1130:

			$report = "Corporate Party Wise Sales Report YEARLY";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);

			$dealer_type = 'Corporate';

			unset($to_date);

			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;

		case 11301:

			$report = "SuperShop Party Wise Sales Report YEARLY";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);

			$dealer_type = 'SuperShop';

			unset($to_date);

			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;



		case 113:

			$report = "Yearly Dealer Wise Sales Report(Per Item)(Tk)";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);



			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;



		case 114:

			$report = "Yearly Dealer Wise Sales Report(Per Item)(CTN)";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);



			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;



		case 115:

			$report = "Yearly Dealer Wise Sales Report(Per Item)(Tk)";

			if ($t_date == '') $t_date = date('Y-m-d');

			$t_array = explode('-', $t_date);

			$t_stamp = strtotime($t_date);



			for ($i = 12; $i > 0; $i--) {

				$m = $t_array[1] - ($i - 1);

				$t_stampq = strtotime(date('Y-m-01', strtotime($t_date))) - (60 * 60 * 24 * 30 * ($i - 1));



				${'f_mons' . $i} = date('Y-m-01', $t_stampq);

				${'f_mone' . $i} = date('Y-m-' . date('t', $t_stampq), $t_stampq);
			}

			break;

		case 116:

			$report = "Single Item Sales Report(Zone Wise)";

			break;





		case 1992:

			$report = "Sales Statement(As Per DO)";

			break;





		case 1993:

			$report = "Party Collection Group Wise";

			break;



		case 2000:

			$report = "DO Summery Report Region Wise";

			break;



		case 2010:

			$report = "Secondary Sales Summery Report Region Wise";

			break;

		case 2011:

			$report = "Secondary Sales Summery Report Region Wise";

			break;

		case 2012:

			$report = "Secondary Sales Summery Report Dealer Wise";

			break;

		case 2013:

			$report = "Secondary Sales Report DO Wise";

			break;



		case 2014:

			$report = "Order Wise TSM,RSM Report";

			break;

		case 2016:

			$report = "TSM,RSM Wise Secondary Sales Report";

			break;
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<title><?= $report ?></title>

	<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

	<script language="javascript">
		function hide()

		{

			document.getElementById('pr').style.display = 'none';

		}
	</script>

	<style type="text/css" media="print">
		div.page {

			page-break-after: always;

			page-break-inside: avoid;

		}
	</style>

	<style type="text/css">
		<!--
		.style3 {
			color: #FFFFFF;
			font-weight: bold;
		}

		.style5 {
			color: #FFFFFF
		}
		-->

	</style>

	<?
 
	include  "../../../controllers/core/inc.exporttable.php";

	?>

</head>

<body>

	<!--<div align="center" id="pr">

<input type="button" value="Print" onclick="hide();window.print();"/>

</div>-->

	<div class="main">

		<?

		$str 	.= '<div class="header">';

		if (isset($_SESSION['company_name']))

			$str 	.= '<h1>' . $_SESSION['company_name'] . '</h1>';

		if (isset($report))

			$str 	.= '<h2>' . $report . '</h2>';

		if (isset($dealer_code))

			$str 	.= '<h2>Dealer Name : ' . $dealer_code . ' - ' . find_a_field('dealer_info', 'dealer_name_e', 'dealer_code=' . $dealer_code) . '</h2>';
			
		if ($_POST['sales_person']!='')
		
		
			$str 	.= '<h2>SR Name : ' . $_POST['sales_person'] . ' - ' . find_a_field('ss_user', 'fname', 'user_id=' . $_POST['sales_person']) . '</h2>';

		if (isset($depot_id))

			$str 	.= '<h2>Depot Name : ' . find_a_field('warehouse', 'warehouse_name', 'warehouse_id=' . $depot_id) . '</h2>';

		if (isset($item_brand))

			$str 	.= '<h2>Item Brand : ' . $item_brand . '</h2>';

		if (isset($item_info->item_id))

			$str 	.= '<h2>Item Name : ' . $item_info->item_name . '(' . $item_info->finish_goods_code . ')' . '(' . $item_info->sales_item_type . ')' . '(' . $item_info->item_brand . ')' . '</h2>';

		if (isset($to_date))

			$str 	.= '<h2>Date Interval : ' . $fr_date . ' To ' . $to_date . '</h2>';

		if (isset($product_group))

			$str 	.= '<h2>Product Group : ' . $product_group . '</h2>';

		if (isset($region_id))

			$str 	.= '<h2>Region Name : ' . find_a_field('branch', 'BRANCH_NAME', 'BRANCH_ID=' . $region_id) . '</h2>';

		if (isset($zone_id))

			$str 	.= '<h2>Zone Name: ' . find_a_field('zon', 'ZONE_NAME', 'ZONE_CODE=' . $zone_id) . '</h2>';

		if (isset($area_id))

			$str 	.= '<h3>Area Name: ' . find_a_field('area', 'AREA_NAME', 'AREA_CODE=' . $area_id) . '</h3>';

		if (isset($dealer_type))

			$str 	.= '<h2>Dealer Type : ' . $dealer_type . '</h2>';

		$str 	.= '</div>';

		$str 	.= '<div class="left" style="width:100%">';







		if ($_REQUEST['report'] == 1) { // do summery report modify jan 24 2018



			$sql = "select m.do_no,i.item_name,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,

w.warehouse_name as depot,s.unit_price,s.total_unit as qty 



from sale_do_master m,sale_do_details s,dealer_info d  , warehouse w, item_info i



where m.do_no=s.do_no and m.status in ('PROCESSING','CHECKED','COMPLETED','FACTORY_APPROVAL')  and m.dealer_code=d.dealer_code  and s.item_id=i.item_id

" . $depot_con . $date_con . $item_con . $dealer_con . $dtype_con . " group by s.item_id,s.do_no order by m.do_date,m.do_no";


			//and w.warehouse_id=d.depot


			$query = db_query($sql); ?>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

				<thead>
					<tr>
						<td style="border:0px;" colspan="11"><?= $str ?></td>
					</tr>

					<tr>

						<th>S/L</th>

						<th>So No</th>

						<th>So Date</th>

						<th>Customer Name</th>

						<th>Depot</th>

						<th>Item Name</th>

						<th>Qty</th>

						<th>Unit Price</th>

						<th>Total Amt</th>

					</tr>

				</thead>
				<tbody>



					<?

					while ($data = mysqli_fetch_object($query)) {
						$s++;



					?>

						<tr>

							<td><?= $s ?></td>

							<td><a href="../wo/sales_order_print_view.php?v_no=<?= $data->do_no ?>" target="_blank"><?= $data->do_no ?></a></td>

							<td><?= $data->do_date ?></td>

							<td><?= $data->dealer_name ?></td>

							<td><?= $data->depot ?></td>

							<td><?= $data->item_name ?></td>

							<td><?= $data->qty ?></td>

							<td><?= $data->unit_price ?></td>

							<td><?= $tot = $data->qty * $data->unit_price ?></td>

						</tr>

					<?
						$totQty += $data->qty;

						$gTot += $tot;
					} ?>

					<tr class="footer">

						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>

						<td style="text-align:right"><?= number_format($totQty, 2) ?></td>

						<td style="text-align:right"></td>



						<td><?= number_format($gTot, 2) ?></td>

					</tr>

				</tbody>

			</table>

		<? }elseif($_REQUEST['report']==404){
		 
		 
		 if($_POST['dealer_code']!=''){
		 $con.=' and t.dealer_code="'.$_POST['dealer_code'].'"';
		 
		 }
		 
		 if($_POST['sales_person']!=''){
		 
		 $con.=' and t.sales_person="'.$_POST['sales_person'].'"';
		 }
		 
		 	 if($_POST['f_date']!='' && $_POST['t_date']!=''){
		 
		 $con.=' and t.from_date="'.$_POST['f_date'].'" and t.to_date="'.$_POST['t_date'].'"';
		 }




			    $sql = "select t.*,d.dealer_name_e,d.dealer_code,s.fname as sr_name,s.user_id,u.fname as entry_by,t.entry_at,i.item_name,i.unit_name,i.d_price 
			
			from sales_target t,dealer_info d,ss_user s,item_info i,user_activity_management u
			
			 where t.dealer_code=d.dealer_code and t.sales_person=s.user_id and t.entry_by=u.user_id and t.item_id=i.item_id ".$con."  group by t.sales_person,t.to_date,t.from_date,t.item_id";


			//and w.warehouse_id=d.depot


			$query = db_query($sql); ?>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

				<thead>
					<tr>
						<td style="border:0px;" colspan="13"><?= $str ?></td>
						
						
					</tr>
					<tr>
					<td style="border:0px;" colspan="13"><center><h2><u>SR Target Report</u></h2></center></td>
					</tr>

					<tr>

						<th>S/L</th>
						
						<th>Dealer Code</th>

						<th>Dealer Name</th>
						
						<th>SR Code</th>

						<th>SR Name</th>
						
						<th>Date Range</th>

						<th>Item Name</th>

						<th>Unit Name</th>

						<th>Target Qty</th>
						
						<th>Target Amount(IP)</th>
						
						<th>Target Amount(TP)</th>

						<th>Entry By</th>

						<th>Entry At</th>

					</tr>

				</thead>
				<tbody>



					<?

					while ($data = mysqli_fetch_object($query)) {
						$s++;



					?>

						<tr>

							<td><?= $s ?></td>
							
							<td><?=$data->dealer_code?></td>

							<td><?=$data->dealer_name_e?></td>
							
							<td><?=$data->user_id?></td>

							<td><?=$data->sr_name ?></td>

							<td><?=date('d-M-Y', strtotime($data->from_date))." <b>To</b> ".date('d-M-Y', strtotime($data->to_date)) ?></td>
							
							<td><?=$data->item_name ?></td>
							
							<td><?=$data->unit_name ?></td>

							<td style="text-align:right"><?=$data->qty ?></td>
							
							<td style="text-align:right"><?=$data->target_amount_ip?></td>
							
							<td style="text-align:right"><?=$data->target_amount_tp?></td>

							<td><?=$data->entry_by ?></td>
							
							<td><?=$data->entry_at ?></td>

						</tr>

					<?
						$totQty += $data->qty;
						$totip+=$data->target_amount_ip;
						$tottp+=$data->target_amount_tp;
					} ?>

					<tr class="footer">

						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>

						<td style="text-align:right"><?= number_format($totQty, 2) ?></td>

						<td style="text-align:right"><?= number_format($totip, 2) ?></td>
						
						<td style="text-align:right"><?= number_format($tottp, 2) ?></td>



						<td></td>

					</tr>

				</tbody>

			</table>

		<? 
		
		
		
		
		}elseif ($_REQUEST['report'] == 505) {
		
		
		 
		 
		 if($_POST['dealer_code']!=''){
		 $con.=' and t.dealer_code="'.$_POST['dealer_code'].'"';
		 
		 }
		 
		 if($_POST['sales_person']!=''){
		 
		 $con.=' and t.sales_person="'.$_POST['sales_person'].'"';
		 }
		 
		 if($_POST['f_date']!='' && $_POST['t_date']!=''){
		 
		 $con.=' and t.from_date="'.$_POST['f_date'].'" and t.to_date="'.$_POST['t_date'].'"';
		 }




			  $dd='select s.user_id,s.item_id,sum(s.total_unit) as total_qty,sum(s.total_amt) as total_amount from ss_do_chalan s
			
			where s.chalan_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"  group by s.dealer_code, s.item_id';
			
			$vs=db_query($dd);
			
			while($cc=mysqli_fetch_object($vs)){
			
				$user_qty[$cc->user_id][$cc->item_id]=$cc->total_qty;
				
				$user_amt[$cc->user_id][$cc->item_id]=$cc->total_amount;
			}
			

			 $sql = "select t.*,d.dealer_name_e,d.dealer_code,s.fname as sr_name,s.user_id,u.fname as entry_by,t.entry_at,i.item_name,i.unit_name,i.item_id, i.d_price
			
			from sales_target t,dealer_info d,ss_user s,item_info i,user_activity_management u
			
			 where t.dealer_code=d.dealer_code and t.sales_person=s.user_id and t.entry_by=u.user_id and t.item_id=i.item_id ".$con."  group by t.sales_person,t.to_date,t.from_date,t.item_id";


			//and w.warehouse_id=d.depot


			$query = db_query($sql); ?>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

				<thead>
					<tr>
						<td style="border:0px;" colspan="13"><?= $str ?></td>
						
						
					</tr>
					<tr>
					<td style="border:0px;" colspan="13"><center><h2><u>SR Target Acheive Reports</u></h2></center></td>
					</tr>

					<tr>

						<th>S/L</th>

						<th>Dealer Code</th>

						<th>Dealer Name</th>
						
						<th>SR Code</th>

						<th>SR Name</th>
						
						<th>Date Range</th>

						<th>Item Name</th>

						<th>Unit Name</th>

						<th>Target Qty</th>
						
						<th>Target Amount(IP)</th>
						
						 
						
						<th>Achieve Qty</th>
						
						<th>Acheive Qty(%)</th>

					</tr>

				</thead>
				<tbody>



					<?

					while ($data = mysqli_fetch_object($query)) {
						$s++;



					?>

						<tr style="text-align:right">

							<td><?= $s ?></td>

							<td><?=$data->dealer_code?></td>

							<td><?=$data->dealer_name_e?></td>
							
							<td><?=$data->user_id?></td>

							<td><?=$data->sr_name ?></td>

							<td><?=date('d-M-Y', strtotime($data->from_date))." <b>To</b> ".date('d-M-Y', strtotime($data->to_date)) ?></td>
							
							<td><?=$data->item_name ?></td>
							
							<td><?=$data->unit_name ?></td>

							<td><?=$data->qty ?></td>
							
							<td><?=$data->target_amount_ip ?></td>
							
						 
							
							<td><?=$ff=$user_qty[$data->user_id][$data->item_id]?></td>
							
							<td><b><?=number_format(100*$user_qty[$data->user_id][$data->item_id]/$data->qty,2)?>%</b></td>

						</tr>

					<?
							$totQty += $data->qty;
						$totip+=$data->target_amount_ip;
						$tottp+=$data->target_amount_tp;
						$tot_ac+=$ff;
					} ?>

					<tr class="footer">

						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>

						<td style="text-align:right"><?= number_format($totQty, 2) ?></td>
						<td style="text-align:right"><?= number_format($totip, 2) ?></td>
				
						<td style="text-align:right"><?= number_format($tot_ac, 2) ?></td>



						<td></td>

					</tr>

				</tbody>

			</table>

		<? 
		
		
		
		
		
		
		
		
		} elseif ($_REQUEST['report'] == 606){
		
		
		
		
		 
		 
		 if($_POST['depot_id']!=''){
		 $con.=' and d.depot="'.$_POST['depot_id'].'"';
		 
		 }
		 
		 if($_POST['dealer_code']!=''){
		 $con.=' and t.dealer_code="'.$_POST['dealer_code'].'"';
		 
		 }
		 
		 if($_POST['sales_person']!=''){
		 
		 $con.=' and t.sales_person="'.$_POST['sales_person'].'"';
		 }
		 
		 if($_POST['f_date']!='' && $_POST['t_date']!=''){
		 
		 $con.=' and t.from_date="'.$_POST['f_date'].'" and t.to_date="'.$_POST['t_date'].'"';
		 }



			  $sql = "select t.dealer_code,t.to_date,t.from_date,sum(t.qty) as tot_qty,sum(t.target_amount_ip) as tot_amt,d.dealer_name_e,i.item_name,i.unit_name,i.d_price 
			
			from sales_target t,dealer_info d,item_info i
			
			 where t.dealer_code=d.dealer_code  and t.item_id=i.item_id ".$con."  group by t.dealer_code";


			//and w.warehouse_id=d.depot


			$query = db_query($sql); ?>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

				<thead>
					<tr>
						<td style="border:0px;" colspan="11"><?= $str ?></td>
						
						
					</tr>
					<tr>
					<td style="border:0px;" colspan="11"><center><h2><u>distributor Target Reports</u></h2></center></td>
					</tr>

					<tr>

						<th>S/L</th>

						<th>Distributor Name</th>
						
						<th>Date Range</th>

						<th>Target Qty</th>
						
						<th>Target Amount</th>
						
			

					</tr>

				</thead>
				<tbody>



					<?

					while ($data = mysqli_fetch_object($query)) {
						$s++;



					?>

						<tr>

							<td><?= $s ?></td>

							<td><?=$data->dealer_name_e?></td>

							<td><?=date('d-M-Y', strtotime($data->from_date))." <b>To</b> ".date('d-M-Y', strtotime($data->to_date)) ?></td>
							
							<td><?=$data->tot_qty?></td>
							
							<td><?=$data->tot_amt?></td>
							
					
							
							
							

						</tr>

					<?
						$totQty += $data->tot_qty;
							$totamt += $data->tot_amt;
					} ?>

					<tr class="footer">

						
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>

						<td style="text-align:right"><?= number_format($totQty, 2) ?></td>

						<td style="text-align:right"><?= number_format($totamt, 2) ?></td>



						<td></td>

					</tr>

				</tbody>

			</table>

		<? 
		
		
		
		
		
		
		
		
		
		
		} elseif  ($_REQUEST['report'] == 707){
		
		
		
		
		
		
		 
		 
		 if($_POST['depot_id']!=''){
		 $con.=' and d.depot="'.$_POST['depot_id'].'"';
		 
		 }
		 
		 if($_POST['dealer_code']!=''){
		 $con.=' and t.dealer_code="'.$_POST['dealer_code'].'"';
		 
		 }
		 
		 if($_POST['sales_person']!=''){
		 
		 $con.=' and t.sales_person="'.$_POST['sales_person'].'"';
		 }
		 
		 if($_POST['f_date']!='' && $_POST['t_date']!=''){
		 
		 $con.=' and t.from_date="'.$_POST['f_date'].'" and t.to_date="'.$_POST['t_date'].'"';
		 }



			 $dd='select u.dealer_code ,d.dealer_name_e,sum(s.total_unit) as total_qty,sum(s.total_amt) as total_amount 
			
			from ss_do_chalan s,ss_user u,dealer_info d
			
			where s.user_id=u.user_id and u.dealer_code=d.dealer_code and s.chalan_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"  group by u.dealer_code';
			
			$vs=db_query($dd);
			
			while($cc=mysqli_fetch_object($vs)){
			
				$user_qty[$cc->dealer_code]=$cc->total_qty;
				
				$user_amt[$cc->dealer_code]=$cc->total_amount;
			}
			
			
			

			 $sql = "select t.dealer_code,t.to_date,t.from_date,sum(t.qty) as tot_qty,sum(t.target_amount_ip) as tot_amt,d.dealer_name_e,d.dealer_code as del_id,i.item_name,i.unit_name
			
			from sales_target t,dealer_info d,item_info i
			
			 where t.dealer_code=d.dealer_code  and t.item_id=i.item_id ".$con."  group by t.dealer_code";


			//and w.warehouse_id=d.depot


			$query = db_query($sql); ?>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

				<thead>
					<tr>
						<td style="border:0px;" colspan="11"><?= $str ?></td>
						
						
					</tr>
					<tr>
					<td style="border:0px;" colspan="11"><center><h2><u>Distributor Wise Target Acheive Reports</u></h2></center></td>
					</tr>

					<tr>

						<th>S/L</th>

						<th>Distributor Name</th>
						
						<th>Date Range</th>

						<th>Target Qty</th>
						
						<th>Acheive Qty</th>
						
						<th>Target Amount</th>
						
						<th>Acheive Amount</th>
						
						<th>Acheive Qty (%)</th>

					</tr>

				</thead>
				<tbody>



					<?

					while ($data = mysqli_fetch_object($query)) {
						$s++;



					?>

						<tr>

							<td><?= $s ?></td>

							<td><?=$data->dealer_name_e?></td>

							<td><?=date('d-M-Y', strtotime($data->from_date))." <b>To</b> ".date('d-M-Y', strtotime($data->to_date)) ?></td>
							
							<td><?=$data->tot_qty?></td>
							
							<td><?=$user_qty[$data->del_id]?></td>
							
							<td></td>
							
							<td><?=$user_amt[$data->del_id]?></td>
							
							<td><?=round(100*$user_qty[$data->del_id]/$data->tot_qty)?>%</td>
							
							
							

						</tr>

					<?
						$totQty += $data->tot_qty;
						
						$totac+=$user_qty[$data->del_id];
						
						$tot_ac_amt+=$user_amt[$data->del_id];
					} ?>

					<tr class="footer">

						
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>

						<td style="text-align:right"><?= number_format($totQty, 2) ?></td>

						<td style="text-align:right"><?= number_format($totac, 2) ?></td>
						
						<td>&nbsp;</td>
						
						<td><?= number_format($tot_ac_amt, 2) ?></td>



						<td></td>

					</tr>

				</tbody>

			</table>

		<? 
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		}elseif ($_REQUEST['report'] == 1100) { // do summery report modify jan 24 2018



			$sql = "select m.do_no,i.item_name,m.do_date,d.dealer_name_e as dealer_name,

w.warehouse_name as depot,s.unit_price,s.total_unit,s.total_amt,m.status



from sale_return_master m,sale_return_details s,dealer_info d  , warehouse w, item_info i



where m.do_no=s.do_no and m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=s.item_id

" . $depot_con . $date_con . $item_con . $dealer_con . $dtype_con . " order by m.do_date,m.do_no";





			$query = db_query($sql); ?>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">



				<thead>
					<tr>
						<td style="border:0px;" colspan="11"><?= $str ?></td>
					</tr>



					<tr>

						<th>S/L</th>

						<th>SR No</th>

						<th>Item Name</th>

						<th>SR Date</th>

						<th>Dealer Name</th>

						<th>Depot</th>

						<th>Unit Price</th>

						<th>Total Unit</th>

						<th>Total Amount</th>

						<th>Status</th>

						<!--<th>Payment Details</th>

<th>Total Amt</th>-->

					</tr>

				</thead>
				<tbody>



					<?

					while ($data = mysqli_fetch_object($query)) {
						$s++;



					?>

						<tr>

							<td><?= $s ?></td>

							<td><?= $data->do_no ?></td>

							<td><?= $data->item_name ?></td>

							<td><?= $data->do_date ?></td>

							<td><?= $data->dealer_name ?></td>

							<td><?= $data->depot ?></td>

							<td><?= $data->unit_price ?></td>

							<td><?= $data->total_unit ?></td>

							<td style="text-align:right"><?= $data->total_amt;
															$total = $total + $data->total_amt ?></td>

							<td style="text-align:right"><?= $data->status ?></td>



						</tr>

					<? } ?>

					<tr class="footer">

						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>

						<td style="text-align:right">&nbsp;</td>

						<td style="text-align:right">&nbsp;</td>

						<td style="text-align:right;">Total Amount</td>

						<td style="text-align:right;"><?= number_format($total, 2) ?></td>

					</tr>

				</tbody>

			</table>

			<? } elseif ($_REQUEST['report'] == 301) {

			$sql = "select m.do_no,m.do_date,m.entry_time,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,(select AREA_NAME from area where AREA_CODE=d.area_code) as area,w.warehouse_name as depot, m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details 

from sale_do_master m,dealer_info d  , warehouse w

where m.status in ('PROCESSING')  

and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot" . $depot_con . $date_con . $pg_con . $dealer_con . $dtype_con . " 

order by m.do_date,m.do_no";



			$query = db_query($sql);

			echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

<thead><tr><td style="border:0px;" colspan="13">' . $str . '</td></tr><tr><th>S/L</th><th>Do No</th><th>Do Date</th><th>Confirm At</th><th>Entry At</th><th>Dealer Name</th><th>Area</th><th>Depot</th><th>Grp</th><th>Rcv Amt</th><th>Payment Details</th><th>DP Total</th><th>TP Total</th></tr></thead>

<tbody>';

			while ($data = mysqli_fetch_object($query)) {
				$s++;

				$sqld = 'select sum(CASE WHEN total_amt>0 THEN total_amt ELSE 0 END),sum(t_price*total_unit) from sale_do_details where do_no=' . $data->do_no;

				$info = mysql_fetch_row(db_query($sqld));

				$rcv_t = $rcv_t + $data->rcv_amt;

				$dp_t = $dp_t + $info[0];

				$tp_t = $tp_t + $info[1];

			?>

				<tr>
					<td><?= $s ?></td>
					<td><?= $data->do_no ?></td>
					<td><?= $data->do_date ?></td>
					<td><?= $data->entry_at ?></td>
					<td><?= $data->entry_time ?></td>
					<td><?= $data->dealer_name ?></td>
					<td><?= $data->area ?></td>
					<td><?= $data->depot ?></td>
					<td><?= $data->grp ?></td>
					<td style="text-align:right"><?= $data->rcv_amt ?></td>
					<td><?= $data->Payment_Details ?></td>
					<td><?= $info[0] ?></td>
					<td><?= $info[1] ?></td>
				</tr>

			<?

			}

			echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right">' . number_format($rcv_t, 2) . '</td><td>&nbsp;</td><td>' . number_format($dp_t, 2) . '</td><td>' . number_format($tp_t, 2) . '</td></tr></tbody></table>';
		} elseif ($_REQUEST['report'] == 2000) {

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';

				$cdate_con = ' and do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			if (isset($product_group)) {
				$pg_con = ' and i.sales_item_type="' . $product_group . '"';
			}

			if ($depot_id > 0) {
				$dpt_con = ' and d.depot="' . $depot_id . '"';
			}





			$sqlr = "select * from branch";

			$queryr = db_query($sqlr);

			while ($region = mysqli_fetch_object($queryr)) {

				$region_id = $region->BRANCH_ID;



				$sql = "select i.finish_goods_code as code, sum(o.total_unit) as total_unit

from sale_do_master m,sale_do_details o, item_info i,dealer_info d, area a, zon z

where o.unit_price>0 and m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') and d.area_code=a.AREA_CODE and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=" . $region_id . "

" . $dtype_con . $date_con . $item_con . $item_brand_con . $pg_con . $dpt_con . ' 

group by i.finish_goods_code';

				$query = db_query($sql);

				while ($info = mysqli_fetch_object($query)) {

					$do_qty[$info->code][$region_id] = $info->total_unit;
				}
			}



			if (isset($product_group)) {
				$pg_con = ' and i.sales_item_type like "%' . $product_group . '%"';
			}

			$sql = "select 

		i.finish_goods_code as code, 

		i.item_name, i.item_brand, i.brand_category_type,

		i.sales_item_type as `group`,i.pack_size,i.d_price

		from 

		item_info i

		where i.finish_goods_code>0 and i.finish_goods_code not between 5000 and 6000 and i.finish_goods_code not between 2000 and 3000 " . $item_con . $item_brand_con . $pg_con . ' 

		group by i.finish_goods_code';

			?>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
				<thead>

					<tr>
						<td style="border:0px;" colspan="16"><?= $str ?></td>
					</tr>
					<tr>

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

						<th><!--Barisal--> South Bengal</th>

						<th><!--Bogra--> North Bengal</th>

						<th>Total</th>

					</tr>
				</thead>

				<tbody>

					<?

					$query = db_query($sql);

					while ($info = mysqli_fetch_object($query)) {



						$total_item =

							(int)($do_qty[$info->code][13] / $info->pack_size) +

							(int)($do_qty[$info->code][12] / $info->pack_size) +

							(int)($do_qty[$info->code][3] / $info->pack_size) +

							(int)($do_qty[$info->code][4] / $info->pack_size) +

							(int)($do_qty[$info->code][5] / $info->pack_size) +

							(int)($do_qty[$info->code][9] / $info->pack_size) +

							(int)($do_qty[$info->code][10] / $info->pack_size) +

							(int)($do_qty[$info->code][8] / $info->pack_size);



						if ($total_item > 0) {

					?>

							<tr>
								<td><?= ++$i; ?></td>

								<td><?= $info->code; ?></td>

								<td><?= $info->item_name; ?></td>

								<td><?= $info->group ?></td>

								<td><?= $info->item_brand ?></td>

								<td style="text-align:center"><?= $info->brand_category_type ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][13] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][12] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][3] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][4] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][5] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][10] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][8] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= number_format($total_item, 0); ?></td>
							</tr>

					<?

						}
					}

					?>

				</tbody>
			</table>

		<?

			$str = '';
		}



		// modify jun 22

		elseif ($_REQUEST['report'] == 2010) {

			if (isset($t_date)) {
				$to_date = $t_date;
				$fr_date = $f_date;
				$date_con = ' and m.do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';

				$cdate_con = ' and do_date between \'' . $fr_date . '\' and \'' . $to_date . '\'';
			}



			if (isset($product_group)) {
				$pg_con = ' and i.sales_item_type="' . $product_group . '"';
			}

			if ($depot_id > 0) {
				$dpt_con = ' and d.depot="' . $depot_id . '"';
			}





			$sqlr = "select * from branch";

			$queryr = db_query($sqlr);

			while ($region = mysqli_fetch_object($queryr)) {

				$region_id = $region->BRANCH_ID;



				$sql = "select i.finish_goods_code as code, sum(o.total_unit) as total_unit

from ss_do_master m,ss_do_details o, item_info i,dealer_info d, area a, zon z

where o.unit_price>0 and m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') and d.area_code=a.AREA_CODE and a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=" . $region_id . "

" . $dtype_con . $date_con . $item_con . $item_brand_con . $pg_con . $dpt_con . ' 

group by i.finish_goods_code';

				$query = db_query($sql);

				while ($info = mysqli_fetch_object($query)) {

					$do_qty[$info->code][$region_id] = $info->total_unit;
				}
			}



			if (isset($product_group)) {
				$pg_con = ' and i.sales_item_type like "%' . $product_group . '%"';
			}

			$sql = "select 

		i.finish_goods_code as code, 

		i.item_name, i.item_brand, i.brand_category_type,

		i.sales_item_type as `group`,i.pack_size,i.d_price

		from 

		item_info i

		where i.finish_goods_code>0 and i.finish_goods_code not between 5000 and 6000 and i.finish_goods_code not between 2000 and 3000 " . $item_con . $item_brand_con . $pg_con . ' 

		group by i.finish_goods_code';

		?>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
				<thead>

					<tr>
						<td style="border:0px;" colspan="16"><?= $str ?></td>
					</tr>
					<tr>

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

						<th><!--Barisal--> South Bengal</th>

						<th><!--Bogra--> North Bengal</th>

						<th>Total</th>

					</tr>
				</thead>

				<tbody>

					<?

					$query = db_query($sql);

					while ($info = mysqli_fetch_object($query)) {



						$total_item =

							(int)($do_qty[$info->code][13] / $info->pack_size) +

							(int)($do_qty[$info->code][12] / $info->pack_size) +

							(int)($do_qty[$info->code][3] / $info->pack_size) +

							(int)($do_qty[$info->code][4] / $info->pack_size) +

							(int)($do_qty[$info->code][5] / $info->pack_size) +

							(int)($do_qty[$info->code][9] / $info->pack_size) +

							(int)($do_qty[$info->code][10] / $info->pack_size) +

							(int)($do_qty[$info->code][8] / $info->pack_size);



						if ($total_item > 0) {

					?>

							<tr>
								<td><?= ++$i; ?></td>

								<td><?= $info->code; ?></td>

								<td><?= $info->item_name; ?></td>

								<td><?= $info->group ?></td>

								<td><?= $info->item_brand ?></td>

								<td style="text-align:center"><?= $info->brand_category_type ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][13] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][12] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][3] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][4] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][5] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][10] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= (int)($do_qty[$info->code][8] / $info->pack_size) ?></td>

								<td style="text-align:right"><?= number_format($total_item, 0); ?></td>
							</tr>

					<?

						}
					}

					?>

				</tbody>
			</table>

			<?

			$str = '';
		} elseif ($_REQUEST['report'] == 2012) {

			if (isset($dealer_code))

				$sqlbranch 	= "select * from dealer_info where dealer_type like 'Distributor' and dealer_code = " . $dealer_code;

			else

				$sqlbranch 	= "select * from dealer_info where dealer_type like 'Distributor' ";

			$querybranch = db_query($sqlbranch);

			while ($branch = mysqli_fetch_object($querybranch)) {

				$rp = 0;

				echo '<div>';



				$op_sql = "select sum(item_in-item_ex) as stock , warehouse_id, item_id from journal_item where warehouse_id = " . $branch->dealer_depo . " group by item_id ";

				$op_query = db_query($op_sql);

				while ($opqr = mysqli_fetch_object($op_query)) {

					$depo_op[$opqr->warehouse_id][$opqr->item_id] = $opqr->stock;
				}



				$op_sql1 = "select sum(total_unit) as stock , dealer_code, item_id from sale_do_chalan where dealer_code = " . $branch->dealer_code . " and chalan_date<'" . $_POST['f_date'] . "' group by item_id ";

				$op_query1 = db_query($op_sql1);

				while ($opqr1 = mysqli_fetch_object($op_query1)) {

					$depo_chalan[$opqr1->dealer_code][$opqr1->item_id] = $opqr1->stock;
				}



				$op_sql2 = "select sum(total_unit) as stock , dealer_code, item_id from sale_do_chalan where dealer_code = " . $branch->dealer_code . " and chalan_date between '" . $_POST['f_date'] . "' and '" . $_POST['t_date'] . "' group by item_id ";

				$op_query2 = db_query($op_sql2);

				while ($opqr2 = mysqli_fetch_object($op_query2)) {

					$chalan[$opqr2->dealer_code][$opqr2->item_id] = $opqr2->stock;
				}

				//if(isset($zone_id)) 

				//$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;

				//else

				// $sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;

				//

				//	$queryzone = db_query($sqlzone);

				//	while($zone=mysqli_fetch_object($queryzone)){

				if ($area_id > 0)

					$area_con = "and a.AREA_CODE=" . $area_id;



				$sql = "select i.item_id,i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,

floor(sum(o.total_unit)/i.pack_size) as crt,

mod(sum(o.total_unit),i.pack_size) as pcs, 

sum(o.total_unit) as total_unit,

sum(o.total_amt) as DP,

sum(o.total_unit*o.t_price) as TP

from 

ss_do_master m,ss_do_details o, item_info i, warehouse w, dealer_info d, area a

where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=o.item_id and a.AREA_CODE=d.area_code 

and m.status in ('CHECKED','COMPLETED') and m.dealer_code=" . $branch->dealer_code . " and o.unit_price>0

" . $date_con . $item_con . $item_brand_con . $pg_con . $area_con . ' 

group by i.finish_goods_code';



				$sqlt = "select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total, sum(total_unit) as unit_total

from 

ss_do_master m,ss_do_details o, item_info i, warehouse w, dealer_info d, area a

where m.do_no=o.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot 

and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') 

and o.unit_price>0

and m.dealer_code=" . $branch->dealer_code . " " . $date_con . $item_con . $item_brand_con . $pg_con . $area_con . '';



				$queryt = db_query($sqlt);

				$t = mysqli_fetch_object($queryt);

				if ($t->dp_total > 0) {

					if ($rp == 0) {
						$reg_total = 0;
						$dp_total = 0;

						$str .= '<p style="width:100%"><strong>Dealer Name: ' . $branch->dealer_name_e . ' Dealer Code: ' . $branch->dealer_code . ' </strong></p>';
						$rp++;
					}

					$str .= '<p style="width:100%">Address: ' . $branch->address_e . ' <strong>Mobile: </strong>' . $branch->mobile_no . ' </p>';

			?>



					<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">

						<thead>

							<tr>

								<td colspan="10" style="border:0px;">
									<div class="header">

										<?= $str; ?>

								</td>

							</tr>

							<tr>

								<th>S/L</th>

								<th>Code</th>

								<th>Item Name</th>

								<th>Item Brand</th>

								<th>Group</th>

								<th>Opening Stock</th>

								<th>Chalan Qty</th>

								<th>Total Stock</th>

								<th>Sales Qty</th>

								<th>Present Stock</th>

								<th>DP</th>

								<th>TP</th>

							</tr>

						</thead>

						<tbody>

							<?



							$unit_total1 = 0;

							$reg_total1  = 0;

							$dp_total1   = 0;



							$squery = db_query($sql);

							$sl = 1;

							while ($res = mysqli_fetch_object($squery)) { ?>

								<tr>

									<td><?= $sl++; ?></td>

									<td align="center"><?= $res->code; ?></td>

									<td><?= $res->item_name; ?></td>

									<td><?= $res->item_brand; ?></td>

									<td><?= $res->group; ?></td>

									<td align="right"><?= $op_stock = ($depo_op[$branch->dealer_depo][$res->item_id] + $depo_chalan[$branch->dealer_code][$res->item_id]); ?></td>

									<td align="right"><?= $chalan1 = $chalan[$branch->dealer_code][$res->item_id]; ?></td>

									<td align="right"><?= $stock = ($op_stock + $chalan1); ?></td>

									<td align="right"><?= $res->total_unit; ?></td>

									<td align="right"><?= $present_stock = ($stock - $res->total_unit); ?></td>

									<td align="right"><?= $res->DP; ?></td>

									<td align="right"><?= $res->TP; ?></td>

								</tr>



						<?

							}

							//echo report_create($sql,1,$str);

							$str = '';



							$unit_total1 = $unit_total1 + $t->unit_total;

							$reg_total1  = $reg_total1 + $t->total;

							$dp_total1   = $dp_total1 + $t->dp_total;
						}



						//}

						?>

						<tr>

							<td></td>

							<td colspan="7" align="right">Total:</td>

							<td align="right"><strong><?= number_format($unit_total1, 2); ?></strong></td>

							<td align="right"></td>

							<td align="right"><strong><?= number_format($dp_total1, 2); ?></strong></td>

							<td align="right"><strong><?= number_format($reg_total1, 2); ?></strong></td>

						</tr>

						</tbody>

					</table>

			<?

			}
		} elseif (isset($sql) && $sql != '') {
			echo report_create($sql, 1, $str);
		}

			?>

	</div>

</body>

</html>