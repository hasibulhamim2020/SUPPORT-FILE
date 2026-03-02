<?php

////////////// Get Month Period Function //////////////
function getmonth($dateString) {
    $date = new DateTime($dateString);
    $checkDate = clone $date;
    $day = (int)$checkDate->format('d');

    if ($day >= 26) {
        // Current salary month
        $startDate = new DateTime($checkDate->format('Y-m-26'));
        $endDate   = new DateTime($checkDate->modify('+1 month')->format('Y-m-25'));
    } else {
        // Previous salary month
        $startDate = new DateTime($checkDate->modify('-1 month')->format('Y-m-26'));
        $endDate   = new DateTime($date->format('Y-m-25'));
    }

    return [$startDate, $endDate];
}

////////////// Get amount Function //////////////
function formatBDAmount($amount, $decimals = 1) {
    if ($amount >= 10000000) { // Crore
        return number_format($amount / 10000000, $decimals) . ' Cr';
    } elseif ($amount >= 100000) { // Lakh
        return number_format($amount / 100000, $decimals) . ' L';
    } elseif ($amount >= 1000) { // Thousand
        return number_format($amount / 1000, $decimals) . ' K';
    } else {
        return number_format($amount);
    }
}

////////////// filter month year Function //////////////
function filtermonthyear($month, $year) {
    // Current month 25th
    $currentMonthDate = new DateTime("$year-$month-25");
    // Previous month 26th
    $previousMonthDate = new DateTime("$year-$month-01");
    $previousMonthDate->modify('-1 month');
    $previousMonthDate->setDate((int)$previousMonthDate->format('Y'), (int)$previousMonthDate->format('m'), 26);

    return [$previousMonthDate, $currentMonthDate];
}

// Example
//$month = 12;
//$year  = 2025;
//list($startday, $endday) = filtermonthyear($month, $year);
//$fday = $startday->format('Y-m-d'); // 2025-11-26
//$lday = $endday->format('Y-m-d');   // 2025-12-25




// previous Month day count function
function getDayCountWithoutFriday($startDate, $endDate) {

    $start = new DateTime($startDate);
    $end   = new DateTime($endDate);
    $end->modify('+1 day'); // include end date

    $interval = new DateInterval('P1D');
    $period   = new DatePeriod($start, $interval, $end);

    $totalDays = 0;
    $withoutFriday = 0;

    foreach ($period as $date) {
        $totalDays++;

        // Friday = 5 (Mon=1 ... Sun=7)
        if ($date->format('N') != 5) {
            $withoutFriday++;
        }
    }

    return [
        't_day'   => $totalDays,
        'wf_day'  => $withoutFriday
    ];
}

//$result = getDayCountWithoutFriday('2025-11-26', '2025-12-25');
//echo "Total Days: " . $result['t_day'] . "<br>";
//echo "Without Friday: " . $result['wf_day'];



///// main slaes function  Start///////
function sales_all($fday,$lday){
	///////////// Gift item
	$gift_sql="select m.ref_no,(m.total_unit/m.pkt_size) as ctn,m.total_unit as pcs,i.finish_goods_code as item_codes,i.item_name,((unit_price_gift_item/pkt_size)*total_unit) as gift_amt
	from sale_do_details m  join item_info i on i.item_id=m.item_id2
	where m.ref_no>0 AND m.do_date between '".$fday."' and '".$lday."'";
	$er=mysql_query($gift_sql);
	while($red=mysql_fetch_assoc($er)){
		$id_ctn[$red['ref_no']]=$red['ctn'];
		$id_pcs[$red['ref_no']]=$red['pcs'];
		$id_item_code[$red['ref_no']]=$red['item_codes'];
		$id_item_name[$red['ref_no']]=$red['item_name'];
		$id_gift_amt[$red['ref_no']]=$red['gift_amt'];
	}
	//////////// TSM
//	$tsmsql="select ti.id,ts.name,ti.name as tsm_name from territory ti,tsm ts where ti.tsm_id=ts.id group by ti.id";
//	$tsmquery=mysql_query($tsmsql);
//	while($tsmdata=mysql_fetch_array($tsmquery)){
//		$tsm_name[$tsmdata[0]]=$tsmdata[1];
//		 $tr_name[$tsmdata[0]]=$tsmdata[2];
//	}
	//////////////Head of sales
//	$dsmsql="select di.division_CODE,ds.name,di.division_name,hs.name as hos_name from sales_division di,dsm ds left join hos hs on ds.hos=hs.id where di.dsm=ds.id group by di.division_CODE";
//	$dsmquery=mysql_query($dsmsql);
//	while($dsmdata=mysql_fetch_array($dsmquery)){
//		 $dsm_name[$dsmdata[0]]=$dsmdata[1];
//		$divi_name[$dsmdata[0]]=$dsmdata[2];
//		 $hos_name[$dsmdata[0]]=$dsmdata[3];  
//	}
	///////////warehouse
//	$sec="select warehouse_id,warehouse_name from warehouse where use_type='SC'";
//	$sq=mysql_query($sec);
//	while($sedata=mysql_fetch_assoc($sq)){
//		$seca_name[$sedata['warehouse_id']]=$sedata['warehouse_name'];
//	}
	//////////challan
//	$sqlr="select m.do_no,m.chalan_date from sale_do_chalan m where 1 AND m.do_date between '".$fday."' and '".$lday."'";
//	$query=mysql_query($sqlr);
//	while($data=mysql_fetch_assoc($query)){
//		$c_date[$data['do_no']]=$data['chalan_date'];
//	}
	
	$sqll="SELECT m.do_no,i.item_name,m.do_date,m.depot_id,w.warehouse_name as depot_name,d.dealer_name_e,s.ref_no,s.id,i.item_id,i.item_section,i.sub_group_id,
		s.unit_price,s.total_unit AS pcs_qty,i.tp_price,(s.pkt_unit * i.tp_price) as tp_amt,s.pkt_unit,s.gift_on_item, 
		i.finish_goods_code,m.status,d.territory,d.division,i.pack_size,d.point,d.cust_category_name,d.dealer_code2,s.depot_stock,ig.group_name as item_group_name,
		dp.point as point_name
		FROM sale_do_details s 
		JOIN sale_do_master m ON m.do_no = s.do_no JOIN item_info i ON s.item_id2 = i.item_id JOIN item_sub_group sg on sg.sub_group_id=i.sub_group_id JOIN item_group ig on ig.group_id=sg.group_id JOIN dealer_info d ON m.dealer_code = d.dealer_code JOIN warehouse w ON w.warehouse_id=m.depot_id JOIN dealer_point dp on dp.id=d.point
		WHERE 
			m.status IN ('PROCESSING', 'CHECKED', 'COMPLETED', 'FACTORY_APPROVAL', 'ACC_APPROVAL', 'CHALLAN_APPROVAL')
			AND s.ref_no = 0 AND m.do_date between '".$fday."' and '".$lday."'  and m.dealer_code !=1810
		ORDER BY s.id, m.do_date, m.do_no ";
		
	$queryl = mysql_query($sqll);
	$previous_row = null; 
	$tp_amout = 0;
	$totQty = 0;
	$totCtn = 0;
	$tot_gift = 0;
	$gTot = 0;
	$g_vs = 0; 
	$g_id_pcs = 0;
	$g_id_amt = 0;
	while ($data = mysql_fetch_object($queryl)) {
		($data->gift_on_item > 0) ? $gftaa = ($data->pcs_qty / $data->pack_size) : $gftaa = $id_ctn[$data->id];
		
		switch ($data->cust_category_name) {
			case 1:
				$cdtype = 'Depot';
				break;
			case 2:
				$cdtype = 'Independent Distributor';
				break;
			default:
				$cdtype = 'Under Depot Distributor';
		}
		
//$data->do_no; //$data->do_date; //$cdtype; //$data->dealer_code2; //$data->dealer_name_e; //$hos_name[$data->division]; //$dsm_name[$data->division]; //$divi_name[$data->division]; //$tsm_name[$data->territory]; //$tr_name[$data->territory]; //$data->depot_name; //$data->point_name; //$data->item_group_name; //$seca_name[$data->item_section]; //$data->finish_goods_code; //$data->item_name; //$data->pkt_unit; //$data->pcs_qty; //number_format($gftaa,2); //$id_pcs[$data->id]; //$id_item_code[$data->id]; //$id_item_name[$data->id]; //$data->unit_price; //$data->depot_stock; //number_format($id_gift_amt[$data->id],2); //$data->status; // $c_date[$data->do_no];

		$tot_vs = $data->pkt_unit+$gftaa;
		$tot = $data->pkt_unit * $data->unit_price;
		
		///////////Total count //////////////
		$tp_amout += $data->tp_amt;
		$totQty += $data->pcs_qty;
		$totCtn += $data->pkt_unit;
		$tot_gift += $gftaa;
		$gTot += $tot; 
		$g_vs +=$tot_vs; 
		$g_id_pcs +=$id_pcs[$data->id]; 
		$g_id_amt +=$id_gift_amt[$data->id];
	}
	
	$tp_amout;
	$sales30days = $gTot; //Total Sales
	$sales30daysqty = $totCtn; //Total Quantity
	$sales30giftamt = $g_id_amt; //Total Gift Value
	
	return [
		'sales30days'     => $sales30days,
		'sales30daysqty'  => $sales30daysqty,
		'sales30giftamt'  => $sales30giftamt,
		'tp_amout'    	  => $tp_amout
	];
	
}


//$result = sales_all($fday, $lday);
//echo $result['sales30days'];
//echo $result['sales30daysqty'];
//echo $result['sales30giftamt'];
//echo $result['tp_amout'];
/////////Slaes End //////////////




////////////// Last 5 month date count ///////////////////////
function last5SalaryMonths($currentDate){
    $current = new DateTime($currentDate);
    $months = [];

    // Determine current salary cycle end (26 - 25)
    if ((int)$current->format('d') <= 25) {
        $currentEnd = new DateTime($current->format('Y-m-25'));
    } else {
        $currentEnd = clone $current;
        $currentEnd->modify('+1 month');
        $currentEnd->setDate(
            $current->format('Y'),
            $current->format('m') + 1,
            25
        );
    }

    // Collect last 5 salary months
    for ($i = 4; $i >= 0; $i--) {
        $end = clone $currentEnd;
        $end->modify("-$i month");

        $start = clone $end;
        $start->modify('-1 month');
        $start->setDate(
            $end->format('Y'),
            $end->format('m') - 1,
            26
        );

        $months[] = [
            'month_name'  => $end->format('F Y'), // Full month name
            'short_name'  => $end->format('M'),   // Short month name (Jan, Feb…)
            'start_date'  => $start->format('Y-m-d'),
            'end_date'    => $end->format('Y-m-d')
        ];
    }

    return $months;
}

// Example usage
//$currentDate = '2026-01-02';
//$result = last5SalaryMonthsWithShort($currentDate);
//// Display result
//foreach($result as $m){
//    echo "Month: " . $m['month_name'] . " (" . $m['short_name'] . ")\n";
//    echo "Start: " . $m['start_date'] . " | End: " . $m['end_date'] . "\n";
//    echo "--------------------------\n";
//}


//////////////////// HOS////////////////////////
function hos_f($hos,$fday,$lday) {
    // First query: get DSM IDs for this hos
   $sql = "SELECT * FROM dsm WHERE hos = $hos";
    $query = mysql_query($sql);

    $dsm_list = [];
    while ($row = mysql_fetch_object($query)) {
        $dsm_list[] = $row->id;
    }

    if (empty($dsm_list)) {
        return null; // no DSM found
    }

    // Convert array to comma-separated string for IN()
    $dsm_ids = implode(',', $dsm_list);

    // Second query: get division_CODEs
    $shsql = "SELECT * FROM sales_division WHERE dsm IN ($dsm_ids)";
    $query2 = mysql_query($shsql);

    $division_codes = [];
    while ($row1 = mysql_fetch_object($query2)) {
        $division_codes[] = $row1->division_CODE;
    }
	$division = implode(',', $division_codes);
    // Return all division codes as array
	
	///////////////////////////////////////////////////////////////////
	$sqll="SELECT m.do_no,i.item_name,m.do_date,m.depot_id,w.warehouse_name as depot_name,d.dealer_name_e,s.ref_no,s.id,i.item_id,i.item_section,i.sub_group_id,
		s.unit_price,s.total_unit AS pcs_qty,i.tp_price,(s.pkt_unit * i.tp_price) as tp_amt,s.pkt_unit,s.gift_on_item, 
		i.finish_goods_code,m.status,d.territory,d.division,i.pack_size,d.point,d.cust_category_name,d.dealer_code2,s.depot_stock,ig.group_name as item_group_name,
		dp.point as point_name
		FROM sale_do_details s 
		JOIN sale_do_master m ON m.do_no = s.do_no JOIN item_info i ON s.item_id2 = i.item_id JOIN item_sub_group sg on sg.sub_group_id=i.sub_group_id JOIN item_group ig on ig.group_id=sg.group_id JOIN dealer_info d ON m.dealer_code = d.dealer_code JOIN warehouse w ON w.warehouse_id=m.depot_id JOIN dealer_point dp on dp.id=d.point
		WHERE 
			m.status IN ('PROCESSING', 'CHECKED', 'COMPLETED', 'FACTORY_APPROVAL', 'ACC_APPROVAL', 'CHALLAN_APPROVAL')
			AND s.ref_no = 0 AND m.do_date between '".$fday."' and '".$lday."'  and m.dealer_code !=1810  and d.division in ($division)
		ORDER BY s.id, m.do_date, m.do_no;
		";
	$queryl = mysql_query($sqll);
	$previous_row = null; 
	$prgTot = 0;
	while ($data = mysql_fetch_object($queryl)) {
	$prtot = $data->pkt_unit * $data->unit_price;
	 $prgTot += $prtot;
	}
	$salesprevious = $prgTot; // month sales
	
    return $salesprevious;
}

///////////////// Customer Type ////////////////////////
function salescustomertype($ch_type,$fday,$lday) {
    // First query: get DSM IDs for this hos
   $sql = "SELECT * FROM dealer_info WHERE dealer_type = $ch_type";
    $query = mysql_query($sql);

    $dealer_list = [];
    while ($row = mysql_fetch_object($query)) {
        $dealer_list[] = $row->dealer_code;
    }

    if (empty($dealer_list)) {
        return null; // no DSM found
    }

    // Convert array to comma-separated string for IN()
    $dealer_list_ids = implode(',', $dealer_list);
	
	///////////////////////////////////////////////////////////////////
	$sqll="SELECT m.do_no,i.item_name,m.do_date,m.depot_id,w.warehouse_name as depot_name,d.dealer_name_e,s.ref_no,s.id,i.item_id,i.item_section,i.sub_group_id,
		s.unit_price,s.total_unit AS pcs_qty,i.tp_price,(s.pkt_unit * i.tp_price) as tp_amt,s.pkt_unit,s.gift_on_item, 
		i.finish_goods_code,m.status,d.territory,d.division,i.pack_size,d.point,d.cust_category_name,d.dealer_code2,s.depot_stock,ig.group_name as item_group_name,
		dp.point as point_name
		FROM sale_do_details s 
		JOIN sale_do_master m ON m.do_no = s.do_no JOIN item_info i ON s.item_id2 = i.item_id JOIN item_sub_group sg on sg.sub_group_id=i.sub_group_id JOIN item_group ig on ig.group_id=sg.group_id JOIN dealer_info d ON m.dealer_code = d.dealer_code JOIN warehouse w ON w.warehouse_id=m.depot_id JOIN dealer_point dp on dp.id=d.point
		WHERE 
			m.status IN ('PROCESSING', 'CHECKED', 'COMPLETED', 'FACTORY_APPROVAL', 'ACC_APPROVAL', 'CHALLAN_APPROVAL')
			AND s.ref_no = 0 AND m.do_date between '".$fday."' and '".$lday."'  and m.dealer_code in ($dealer_list_ids)
		ORDER BY s.id, m.do_date, m.do_no;
		";
	$queryl = mysql_query($sqll);
	$previous_row = null; 
	$prgTot = 0;
	while ($data = mysql_fetch_object($queryl)) {
		$prtot = $data->pkt_unit * $data->unit_price;
	 	$prgTot += $prtot;
	}
	$salesprevious = $prgTot; // month sales
	
    return $salesprevious;
}



////////////////////Target vs Achievement -HOS///////////////////////////////
function hostarget($todtp){
	 $sql="SELECT p.*, u.*,sum(p.qty) as total_unit,sum(p.target_inflow) as tt_flow,sum(p.target_amount_tp) as tp,sum(p.target_amount_ip) as ip,sum(p.target_amount_dp) as dp,d.dealer_code,d.depot,d.dealer_name_e, d.dealer_code2,d.cust_category_name FROM sales_target_pending p, ss_user u , dealer_info d WHERE d.dealer_code = p.dealer_code and p.sales_person=u.user_id and p.dealer_code=d.dealer_code and u.STATUS = 'Active' and p.to_date='".$todtp."' GROUP BY p.hos_id ORDER BY p.hos_id asc";
		$query=mysql_query($sql);
		while($r=mysql_fetch_object($query)){ 
			$t_flow[$r->hos_id] = $r->tt_flow; 
			$t_tp[$r->hos_id]   = $r->tp;
			$t_ip[$r->hos_id]   = $r->ip;
			$t_dp[$r->hos_id]   = $r->dp;
		}
	return $t_tp;
}

////////////////////////// top 5 brand //////////////////////////////////////
function topbrand($fday,$lday,$type){
	if($type ==1){
		$con .="ORDER BY total_amt DESC LIMIT 5 ";
	} else{
		$con .="ORDER BY total_amt ASC LIMIT 5 ";
	}
		$sql = "SELECT i.item_name, SUM((s.pkt_unit * s.unit_price)) as total_amt
				FROM sale_do_details s
				JOIN sale_do_master m ON m.do_no = s.do_no
				JOIN item_info i ON s.item_id2 = i.item_id
				WHERE m.status IN ('PROCESSING', 'CHECKED', 'COMPLETED', 'FACTORY_APPROVAL', 'ACC_APPROVAL', 'CHALLAN_APPROVAL')
				  AND s.ref_no = 0
				  AND m.do_date between '".$fday."' and '".$lday."'
				  AND m.dealer_code != 1810
				GROUP BY i.item_id ".$con."";
		
	$query = mysql_query($sql);
  	$data = [];
    while ($row = mysql_fetch_assoc($query)) {
        $data[] = [
            'item_name' => $row['item_name'],
            'total_amt' => $row['total_amt']
        ];
    }
    return $data;
}


////////////////////////// Section Contribution //////////////////////////////////////
function sectionsale($fday,$lday){
	//warehouse
	$sec="select warehouse_id,warehouse_name from warehouse where use_type='SC'";
	$sq=mysql_query($sec);
	while($sedata=mysql_fetch_assoc($sq)){
		$seca_name[$sedata['warehouse_id']]=$sedata['warehouse_name'];
	}

	$sql = "SELECT m.do_no,i.item_name,m.do_date,m.depot_id,w.warehouse_name as depot_name,d.dealer_name_e,s.ref_no,s.id,i.item_id,i.item_section,i.sub_group_id, s.unit_price,s.total_unit AS pcs_qty,i.tp_price,(s.pkt_unit * i.tp_price) as tp_amt,s.pkt_unit,SUM((s.pkt_unit * s.unit_price)) as total_amt,s.gift_on_item, i.finish_goods_code,m.status,d.territory,d.division,i.pack_size,d.point,d.cust_category_name,d.dealer_code2,s.depot_stock,ig.group_name as item_group_name, dp.point as point_name FROM sale_do_details s JOIN sale_do_master m ON m.do_no = s.do_no JOIN item_info i ON s.item_id2 = i.item_id JOIN item_sub_group sg on sg.sub_group_id=i.sub_group_id JOIN item_group ig on ig.group_id=sg.group_id JOIN dealer_info d ON m.dealer_code = d.dealer_code JOIN warehouse w ON w.warehouse_id=m.depot_id JOIN dealer_point dp on dp.id=d.point WHERE m.status IN ('PROCESSING', 'CHECKED', 'COMPLETED', 'FACTORY_APPROVAL', 'ACC_APPROVAL', 'CHALLAN_APPROVAL') AND s.ref_no = 0 AND m.do_date between '".$fday."' and '".$lday."' and m.dealer_code !=1810  GROUP BY i.item_section ORDER BY total_amt DESC ";
	
	$query = mysql_query($sql);
  	$data = [];
    while ($row = mysql_fetch_assoc($query)) {
        $data[] = [
            'section_name' => $seca_name[$row['item_section']] ,
            'total_amt' => $row['total_amt']
        ];
    }
    return $data;
}

////////////////////////// top 5 Gift item //////////////////////////////////////
function topgiftitem($fday,$lday){
		$sql = "SELECT 
			m.do_no,
			s.ref_no,
			i.item_name,
			s.gift_on_item,
			SUM(s.total_unit) AS pcs_qty,
			SUM(s.total_unit * s.pcs_price) AS gift_amount
		FROM sale_do_details s
		JOIN sale_do_master m ON m.do_no = s.do_no
		JOIN item_info i ON s.item_id2 = i.item_id
		JOIN item_sub_group sg ON sg.sub_group_id = i.sub_group_id
		JOIN item_group ig ON ig.group_id = sg.group_id
		JOIN dealer_info d ON m.dealer_code = d.dealer_code
		JOIN warehouse w ON w.warehouse_id = m.depot_id
		JOIN dealer_point dp ON dp.id = d.point
		WHERE 
			m.status IN ('PROCESSING','CHECKED','COMPLETED','FACTORY_APPROVAL','ACC_APPROVAL','CHALLAN_APPROVAL')
			AND s.ref_no != 0
			AND m.do_date BETWEEN '".$fday."' AND '".$lday."'
			AND m.dealer_code != 1810
		GROUP BY 
			s.gift_on_item
		ORDER BY 
			gift_amount  DESC LIMIT 5 ";
		
	$query = mysql_query($sql);
  	$data = [];
    while ($row = mysql_fetch_assoc($query)) {
        $data[] = [
            'item_name' => $row['item_name'] ,
			'item_qty' => $row['pcs_qty'] ,
            'item_amt' => $row['gift_amount']
        ];
    }
    return $data;
}



////////////// 5 Month Collection //////////////////
function approve_collection($fday,$lday){
        $res = "select p.* ,d.dealer_name_e,d.account_code,d.dealer_code2,d.cust_category_name,sd.division_name,t.name as territory,dp.point,a.ledger_name,c.dealer_code2 as customer_code,c.dealer_name_e as customer_name,g.sub_ledger_name
        from paymnet_req p left join dealer_info c on c.dealer_code=p.customer left join general_sub_ledger g on g.sub_ledger_id=p.ledger_sub_ledger, dealer_info d,sales_division sd,territory t,dealer_point dp,accounts_ledger a
         where p.depot_id=d.dealer_code  and d.division=sd.division_CODE 
         and d.territory=t.id and d.point=dp.id and p.ledger=a.ledger_id and p.payment_date between '".$fday."' and '".$lday."' and p.status='APPROVED' order by p.id asc";
        $query = mysql_query($res);
		$approve_amt = 0;
        while ($data = mysql_fetch_object($query)) {
			$approve_amt += $data->approve_amount; 
		}
		
	return $approve_amt;
}



///////////// Top 5 Division ///////////////////////////
function division($fday,$lday,$type){
	if($type ==1){
		$con .="ORDER BY total_amt DESC LIMIT 5 ";
	} else{
		$con .="ORDER BY total_amt ASC LIMIT 5 ";
	}
	//Head of sales
	$dsmsql="select di.division_CODE,ds.name,di.division_name,hs.name as hos_name from sales_division di,dsm ds left join hos hs on ds.hos=hs.id where di.dsm=ds.id group by di.division_CODE";
	$dsmquery=mysql_query($dsmsql);
	while($dsmdata=mysql_fetch_array($dsmquery)){
		 $dsm_name[$dsmdata[0]]=$dsmdata[1];
		$divi_name[$dsmdata[0]]=$dsmdata[2];
		 $hos_name[$dsmdata[0]]=$dsmdata[3];  
	}

	$sql = "SELECT m.do_no,i.item_name,m.do_date,m.depot_id,w.warehouse_name as depot_name,d.dealer_name_e,s.ref_no,s.id,i.item_id,i.item_section,i.sub_group_id, s.unit_price,s.total_unit AS pcs_qty,i.tp_price,(s.pkt_unit * i.tp_price) as tp_amt,s.pkt_unit,SUM((s.pkt_unit * s.unit_price)) as total_amt,s.gift_on_item, i.finish_goods_code,m.status,d.territory,d.division,i.pack_size,d.point,d.cust_category_name,d.dealer_code2,s.depot_stock,ig.group_name as item_group_name, dp.point as point_name FROM sale_do_details s JOIN sale_do_master m ON m.do_no = s.do_no JOIN item_info i ON s.item_id2 = i.item_id JOIN item_sub_group sg on sg.sub_group_id=i.sub_group_id JOIN item_group ig on ig.group_id=sg.group_id JOIN dealer_info d ON m.dealer_code = d.dealer_code JOIN warehouse w ON w.warehouse_id=m.depot_id JOIN dealer_point dp on dp.id=d.point WHERE m.status IN ('PROCESSING', 'CHECKED', 'COMPLETED', 'FACTORY_APPROVAL', 'ACC_APPROVAL', 'CHALLAN_APPROVAL') AND s.ref_no = 0 AND m.do_date between '".$fday."' and '".$lday."' and m.dealer_code !=1810 GROUP BY d.division  ".$con." ";
	
	$query = mysql_query($sql);
  	$data = [];
    while ($row = mysql_fetch_assoc($query)) {
        $data[] = [
            'division_name' => $divi_name[$row['division']] ,
            'total_amt' => $row['total_amt']
        ];
    }
    return $data;
}

