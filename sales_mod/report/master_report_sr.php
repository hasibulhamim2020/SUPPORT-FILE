<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();
$tr_from="Sales";

$c_id = $_SESSION['proj_id'];
date_default_timezone_set('Asia/Dhaka');

if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)
{
	if((strlen($_REQUEST['t_date'])==10)){
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
	if($_REQUEST['month_id']!='') 		$month_id=$_REQUEST['month_id'];

	$item_info = find_all_field('item_info','','item_id='.$item_id);

	if(isset($item_brand)) 			{$item_brand_con=' and i.sub_group_id="'.$item_brand.'"';} 
	if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 
	
	if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

	if(isset($product_group)) {
	if($product_group=='ABCDE') 
	$pg_con=' and d.product_group!="M" and d.product_group!=""';
	else $pg_con=' and d.product_group="'.$product_group.'"';
	}

	if($dealer_type!=''){
	if($dealer_type=='MordernTrade')		{$dtype_con=$dealer_type_con = ' and ( d.dealer_type="Corporate" or  d.dealer_type="SuperShop" or  d.product_group="M") ';}
	else 									{$dtype_con=$dealer_type_con = ' and d.dealer_type="'.$dealer_type.'"';}}
			
	if(isset($dealer_code)) 		{$dealer_con=' and m.dealer_code='.$dealer_code;} 
	if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 
	if(isset($depot_id)) 			{$depot_con=' and w.warehouse_id="'.$depot_id.'"';} 

	switch ($_REQUEST['report']) {
		case 1:
			$report="Sales Order Brief Report";
		break;

		case 2:
			$report="Undelivered Do Details Report";

			$sql = "select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,d.product_group as grp,w.warehouse_name as depot,concat(i.finish_goods_code,'- ',item_name) as item_name,o.pkt_unit as crt,o.dist_unit as pcs,o.total_amt,m.rcv_amt,m.payment_by as PB from 
			sale_do_master m,sale_do_details o, item_info i,dealer_info d , warehouse w
			where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$dealer_con.$item_brand_con;
		break;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../../../public/assets/css/report_sr.css" type="text/css" rel="stylesheet" />
<script language="javascript">
	function hide(){
		document.getElementById('pr').style.display='none';
	}
</script>
<?
 	require_once "../../../controllers/core/inc.exporttable.php";
?>
</head>
<body>
<?
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
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
		if(isset($area_id)) 
		$str 	.= '<h3>Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE='.$area_id).'</h3>';		
		if(isset($dealer_type)) 
		$str 	.= '<h2>Dealer Type : '.$dealer_type.'</h2>';
		$str 	.= '</div>';



if($_REQUEST['report']==1) { // do summery report modify jan 24 2018

  $sql="select m.do_no,i.item_name,m.do_date,m.entry_at ,m.entry_time, m.status,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,m.depot_id, m.entry_by, wd.warehouse_id, wd.user_id, w.warehouse_name as depot, m.rcv_amt, m.received_amt as acc_amt, m.discount,m.vat,m.ait, s.total_amt, concat(m.payment_by,m.bank,m.remarks) as Payment_Details, d.region_code, d.zone_code,d.area_code
from sale_do_master m,sale_do_details s,dealer_info d  , warehouse w, item_info i, warehouse_define wd
where m.do_no=s.do_no and m.status in ('CHECKED','COMPLETED','UNCHECKED','PROCESSING')  and m.dealer_code=d.dealer_code and w.warehouse_id=m.depot_id and w.warehouse_id=wd.warehouse_id and m.entry_by=wd.user_id and  wd.status='Active' and i.item_id=s.item_id
".$depot_con.$date_con.$item_con.$dealer_con.$dtype_con.$item_brand_con." group by m.do_no order by m.do_date,m.do_no";
$query = db_query($sql); 
$group_data=find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');
?>

<table id="ExportTable">
	<thead>
		<tr>
			<td colspan="18">
				<div class="report_head">
					<div class="head_left">
							<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="report_logo"/>
					</div>
					<div class="head_center">
						<p class="company"><?=$group_data->group_name?></p>
						<p class="address"><?=$group_data->address?></p>
						<p class="other">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?></p>
						<p class="titel"><?=$report?></p>
						<p class="other"><?=$warehouse_name?></p>
						<p class="other"><?='For the Period of:- '.$f_date.' To '.$t_date.'';?></p>
					</div>
					<div class="head_right">&nbsp;</div>				
				</div>
				<div class="head_time">Reporting Time: <?=date("h:i A d-m-Y")?></div>
			</td>
		</tr>
		<tr>
			<th>S/L</th>
			<th>Do No</th>
			<th>Item Name</th>
			<th>Do Date</th>
			<th>Do Status</th>
			<th>Entry At</th>
			<th>Customer Name</th>
			<th>Region</th>
			<th>Zone</th>
			<th>Area</th>
			<th>Warehouse</th>
			<th>Rcv Amt</th>
			<th>Payment Details</th>
			<th>Sub Total</th>
			<th>Discount Amount</th>
			<th>Vat Amount</th>
			<th>AIT Amount</th>
			<th>Invoice Amount</th>
		</tr>
	</thead>
	<tbody>
	
		<?
		while($data=mysqli_fetch_object($query)){$s++;
		$sqld = 'select sum(total_amt),sum(t_price*total_unit) from sale_do_details where do_no='.$data->do_no;
		$info = mysqli_fetch_row(db_query($sqld));
		$rcv_t = $rcv_t+$data->rcv_amt;
		$acc_t = $acc_t+$data->acc_amt;
		$dp_t = $dp_t+$info[0];
		$tp_t = $tp_t+$info[1];
		?>
		<tr>
			<td><?=$s?></td>
			
			<td>
			  <a href="../wo/sales_order_print_view.php?c='<?=rawurlencode(url_encode($c_id));?>'&v='<?=rawurlencode(url_encode($data->do_no));?>'" target="_blank">
				<?=$data->do_no?>
			  </a>
			</td>
			
			
			<td><?=$data->item_name?></td>
			<td><?=$data->do_date?></td>
			<td><?=$data->status?></td>
			<td><?=$data->entry_at?></td>
			<td><?=$data->dealer_name?></td>
			<td><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$data->region_code.'"',);?></td>
			<td><?=find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$data->zone_code.'"',);?></td>
			<td><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$data->area_code.'"',);?></td>
			<td><?=$data->depot?></td>
			<td><?=number_format($data->acc_amt,2)?></td>
			<td><?=$data->Payment_Details?></td>
			<td><?=number_format($sub=$data->total_amt,2); $tot_sub+=$sub;?></td>
			<td><?=number_format($disc=$data->total_amt*($data->discount/100),2); $tot_disc+=$disc;?></td>
			<td><?=number_format($vat=$data->total_amt*($data->vat/100),2); $tot_vat+=$vat;?></td>
			<td><?=number_format($ait=$data->total_amt*($data->ait/100),2); $tot_ait+=$ait;?></td>
			<td><?=number_format($total_invoice_amt=($sub+$vat+$ait)-$disc,2); $tot_total+=$total_invoice_amt; ?></td>
		</tr>
		<? } ?>
		<tr>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
			<td><strong>Total</strong></td>
			<td><?=number_format($acc_t,2)?></td>
			<td>&nbsp;</td>
			<td><?=number_format($tot_sub,2)?></td>
			<td><?=number_format($tot_disc,2)?></td>
			<td><?=number_format($tot_vat,2)?></td>
			<td><?=number_format($tot_ait,2)?></td>
			<td><?=number_format($tot_total,2)?></td>
		</tr>
	</tbody>
</table>
<? }

elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?>

</body>
</html>

<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>