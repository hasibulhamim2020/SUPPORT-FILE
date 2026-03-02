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

	

if($_REQUEST['product_group']!='')  {$product_group=$_REQUEST['product_group'];}

if ($_REQUEST['item_brand'] != '') {
    $item_brand = $_REQUEST['item_brand'];
}

if ($_REQUEST['item_id'] != '') {
    $item_id = $_REQUEST['item_id'];
}

if ($_REQUEST['dealer_code'] > 0) {
    $dealer_code = $_REQUEST['dealer_code'];
}

if ($_REQUEST['item_mother_group'] > 0) {
    $item_mother_group = $_REQUEST['item_mother_group'];
}

if ($_REQUEST['item_group'] > 0) {
    $item_group = $_REQUEST['item_group'];
}

if ($_REQUEST['item_sub_group'] > 0) {
    $item_sub_group = $_REQUEST['item_sub_group'];
}

if ($_REQUEST['item_type'] > 0) {
    $item_type = $_REQUEST['item_type'];
}

if ($_REQUEST['sale_type'] > 0) {
    $item_type = $_REQUEST['sale_type'];
}

if ($_REQUEST['status'] != '') {
    $status = $_REQUEST['status'];
}

if ($_REQUEST['do_no'] != '') {
    $do_no = $_REQUEST['do_no'];
}

if ($_REQUEST['area_id'] != '') {
    $area_id = $_REQUEST['area_id'];
}

if ($_REQUEST['zone_id'] != '') {
    $zone_id = $_REQUEST['zone_id'];
}

if ($_REQUEST['region_id'] > 0) {
    $region_id = $_REQUEST['region_id'];
}

if ($_REQUEST['depot_id'] != '') {
    $depot_id = $_REQUEST['depot_id'];
}

if ($_REQUEST['group_for'] > 0) {
    $group_for = $_REQUEST['group_for'];
}




$item_info = find_all_field('item_info','','item_id='.$item_id);



if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 

if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 

 

if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		

{

if($product_group=='ABCD'){

$pg_con=' and d.product_group!="M"';}

else

{
    $pg_con=' and d.product_group="'.$product_group.'"';

} 

if(isset($dealer_type)) 	
{if($dealer_type=='Distributor') {$dtype_con=' and d.dealer_type="Distributor"';} 
else {$dtype_con=' and d.dealer_type!="Distributor"';}}

if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';} else {$dealer_type_con=' and d.dealer_type!="Distributor"';}} 



if(isset($dealer_code)) 		{$dealer_con=' and m.dealer_code='.$dealer_code;} 

if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 

if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 


}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

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
.style8 {font-weight: bold}
.style9 {font-weight: bold}

-->

    </style>


	<?
	require_once "../../../controllers/core/inc.exporttable.php";
	?>

</head>

<body>



<div class="main">

<?

		$str 	.= '<div class="header">';

		if(isset($_SESSION['user']['group'])) 

		$str 	.= '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

		if(isset($report)) 

		$str 	.= '<h2>'.$report.'</h2>';

		if(isset($dealer_code)) 

		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';



		if(isset($item_brand)) 

		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';

		if(isset($item_info->item_id)) 

		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';
		

	

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



if($_REQUEST['report']==230226001)
{
	
	
		$report="CUSTOMER AGING REPORT";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		
		<table width="100%" >
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style=" height:70px; width:auto;" />

		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:18px; border:0px; border-color:white;"><strong><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>

			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	
       </table>
		
		
		<table width="100%" id="ExportTable" border="0" cellpadding="2" cellspacing="0" style=" font-size:14px; color:#000000;">
		
		<thead>
		<?
	$year = $_POST['year'];
	$isLeapYear = ((($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0));
	$quarter = $_POST['period'];
	$months = array(
		"Q1" => array(
			"January", "February", "March",
			"01-01", "02-01", "03-01", "01-31",
			 $isLeapYear ? "02-29" : "02-28", "03-31"
		),
		"Q2" => array(
			"April", "May", "June",
			"04-01", "05-01", "06-01", "04-30", "05-31", "06-30"
		),
		"Q3" => array(
			"July", "August", "September",
			"07-01", "08-01", "09-01", "07-31", "08-31", "09-30"
		),
		"Q4" => array(
			"October", "November", "December",
			"10-01", "11-01", "12-01", "10-31", "11-30", "12-31"
		),
	);
	
	list(
		$month1, $month2, $month3,
		$month1StartDate, $month2StartDate, $month3StartDate,
		$month1EndDate, $month2EndDate, $month3EndDate
	) = $months[$quarter];
	
		?>
		
		
		<tr height="30">
		<th width="2%" bgcolor="#FFFACD">SL</th>
		<th width="5%" bgcolor="#FFFACD">CODE</th>
		<th width="25%" bgcolor="#FFFACD">CUSTOMER NAME</th>
		<th width="14%" bgcolor="#d6eaf8" style="text-align:center"><?=$month1?></th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center"><?=$month2?></th>
		<th width="13%" bgcolor="#ebdef0" style="text-align:center"><?=$month3?></th>
		<th width="14%" bgcolor="#90EE90" style="text-align:center">Over 3 month</th>
		<th width="14%" bgcolor="#FFA07A" style="text-align:center">TOTAL</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
 		 $sql = "select ledger_id, sum(dr_amt) as first_dr from journal where jv_date between '".$year."-".$month1StartDate."' and '".$year."-".$month1EndDate."' group by ledger_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $first_dr[$info->ledger_id]=$info->first_dr;
		}
		
		 $sql = "select ledger_id, sum(receipt_amt) as first_cr from receipt_from_customer where chalan_date between '".$year."-".$month1StartDate."' and '".$year."-".$month1EndDate."' group by ledger_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $first_cr[$info->ledger_id]=$info->first_cr;
		}
		
		
		$sql = "select ledger_id, sum(dr_amt) as second_dr from journal where jv_date between '".$year."-".$month2StartDate."' and '".$year."-".$month2EndDate."' group by ledger_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $second_dr[$info->ledger_id]=$info->second_dr;
		}
		
		$sql = "select ledger_id, sum(dr_amt) as third_dr from journal where jv_date between '".$year."-".$month3StartDate."' and '".$year."-".$month3EndDate."' group by ledger_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $third_dr[$info->ledger_id]=$info->third_dr;
		}
		
		 $sql = "select ledger_id, sum(dr_amt) as last_dr from journal where jv_date >='".$year."-".$month3EndDate."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $last_dr[$info->ledger_id]=$info->last_dr;
		}
		
		
		

		
		
		
		if($_REQUEST['ledger_group']) 		{$ledger_group_con=' and a.ledger_group_id="'.$_REQUEST['ledger_group'].'"';}
		if($_REQUEST['ledger_id']) 		{$ledger_id_con=' and a.ledger_id="'.$_REQUEST['ledger_id'].'"';
		
		}
	
 		$sql="select dealer_code, account_code, dealer_name_e from dealer_info where 1 ".$con." and account_code!=0 order by dealer_name_e";
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
		?>
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?> >
		<td><?=$sl++;?></td>
		<td><?=$row->account_code?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$first_dr[$row->account_code]; $total_first_dr_amt+=$first_dr[$row->account_code]?></td>
		<td><?=$second_dr[$row->account_code]; $total_second_dr_amt+=$second_dr[$row->account_code]?></td>
		<td><?=$third_dr[$row->account_code]; $total_third_dr_amt+=$third_dr[$row->account_code]?></td>
		<td><?=$last_dr[$row->account_code]; $total_last_dr_amt+=$last_dr[$row->account_code]?></td>
		<td><?php  $ttal=$first_dr[$row->account_code]+$second_dr[$row->account_code]+$third_dr[$row->account_code]+$last_dr[$row->account_code] ;
		echo ($ttal>0)?  $ttal : ''; $fgtot+=$ttal?></td>
		</tr>
		<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
<td><div style="text-align:right;"><strong>TOTAL:</strong></div></td>
		  <td><span class="style7">
		    <?= number_format($total_first_dr_amt,2);  ?>
		  </span></td>
		  <td><span class="style7">
		    <?= number_format($total_second_dr_amt,2);  ?>
          </span></td>
		  <td><span class="style7">
		     <?= number_format($total_third_dr_amt,2);  ?>
		  </span></td>
		  <td>
		  <span class="style7">
		     <?= number_format($total_last_dr_amt,2);  ?>
		  </span>		  </td>
		  <td>
		  <span class="style7">
		     <?= number_format($fgtot,2);  ?>
		  </span>
		  </td>
		</tr>
		  
		 
		
		</tbody>
		</table>
		<?
}


elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}

?>


<table id="ExportTable" style="width:100%; border:0; border-collapse:collapse; border-color:#FFF;">
  <thead>
    <tr>
      <th style="border:0; border-color:#FFF;"></th>
      <th style="border:0; border-color:#FFF;"></th>
      <th style="border:0; border-color:#FFF;"></th>
      <th style="border:0; border-color:#FFF;"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
    </tr>
    <tr>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
    </tr>
    <tr>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
    </tr>
    <tr>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
    </tr>
    <tr>
      <td style="border:0; border-color:#FFF; text-align:center;">&nbsp;</td>
      <td style="border:0; border-color:#FFF; text-align:center;">&nbsp;</td>
      <td style="border:0; border-color:#FFF; text-align:center;">&nbsp;</td>
      <td style="border:0; border-color:#FFF; text-align:center;">&nbsp;</td>
    </tr>
  </tbody>
</table>

		
		
<table style="width:100%; border:0; border-collapse:collapse; border-color:#FFF;">
  <thead>
    <tr>
      <th style="border:0; border-color:#FFF;"></th>
      <th style="border:0; border-color:#FFF;"></th>
      <th style="border:0; border-color:#FFF;"></th>
      <th style="border:0; border-color:#FFF;"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
      <td style="border:0; border-color:#FFF;">&nbsp;</td>
    </tr>
  </tbody>
</table>


</div>

</body>

</html>