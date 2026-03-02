<?

session_start();


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

	
if ($_POST['by'] > 0) {
    $by = $_POST['by'];
}

if ($_POST['vendor_id'] > 0) {
    $vendor_id = $_POST['vendor_id'];
}

if ($_POST['cat_id'] > 0) {
    $cat_id = $_POST['cat_id'];
}

if ($_POST['item_id'] > 0) {
    $item_id = $_POST['item_id'];
}

if ($_POST['sub_group_id'] > 0) {
    $sub_group_id = $_POST['sub_group_id'];
}

if ($_POST['status'] != '') {
    $status = $_POST['status'];
}


switch ($_POST['report']) {
    case 1:
        $report = "Purchase Order Report";
        break;



		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

define('VENDOR_CONDITION', ' and a.vendor_id=');

if (isset($vendor_id)) {
    $vendor_con = VENDOR_CONDITION . $vendor_id;
}
define('CAT_CONDITION', ' and d.id=');

if (isset($cat_id)) {
    $cat_con = CAT_CONDITION . $cat_id;
}
define('ITEM_CONDITION', ' and b.item_id=');

if (isset($item_id)) {
    $item_con = ITEM_CONDITION . $item_id;
}
			if(isset($sub_group_id)) 				{$item_sub_con=' and d.sub_group_id='.$sub_group_id;} 

define('STATUS_CONDITION', ' and a.status="');

if (isset($status)) {
    $status_con = STATUS_CONDITION . $status . '"';
}
		

if(isset($t_date)) 

define('PO_DATE_BETWEEN', ' and a.po_date between \'');
define('AND_LITERAL', '\' and \'');

$to_date = $t_date;
$fr_date = $f_date;
$date_con = PO_DATE_BETWEEN . $fr_date . AND_LITERAL . $to_date . '\'';



		

		    $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as entry_by, a.entry_at,a.po_no as po_no,b.id as order_id,d.sub_group_name,e.item_name,b.qty,b.rate,b.amount 

		   

		   from purchase_master a, purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f 

		   where a.po_no=b.po_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and f.user_id=a.entry_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.' order by a.po_no,b.id';

	break;

    case 2:

		$report="Chalan Report (Purchase Order Wise)";

		if(isset($by)) 			{$by_con=' and a.prepared_by='.$by;} 

		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;} 

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;} 

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;} 

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';} 

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

echo  $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,

((select sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_qty, 

((select b.rate*sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_amt,



if((select count(qty) from purchase_master_chalan where b.id=specification_id)>0,((b.qty-(select sum(qty) from purchase_master_chalan where b.id=specification_id))*1.00),(b.qty*1.00)) as balance_qty

 from purchase_master a, 

purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f where a.id=b.po_no and c.id=a.vendor_id and d.id=e.product_category_id and b.item_id=e.id and f.user_id=a.prepared_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.' order by a.id,b.id';

	break;

	

	case 3:

		$report="Chalan Report (Chalan Date Wise)";

		if(isset($by)) 			{$by_con=' and a.prepared_by='.$by;} 

		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;} 

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;} 

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;} 

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';} 

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		   $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,

((select sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_qty, 

((select b.qty-sum(qty) from purchase_master_chalan where b.id=specification_id)) as balance_qty from purchase_master a, 

purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f where a.id=b.po_no and c.id=a.vendor_id and d.id=e.product_category_id and b.item_id=e.id and f.user_id=a.prepared_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.' order by a.id,b.id';

	break;

	case 4:

	if($_REQUEST['wo_id']>0){

header("Location:work_order_print.php?po_no=".$_REQUEST['wo_id']);}

	break;

	case 5:

		$report="Purchase History Report";

		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 

		define('SUB_GROUP_CONDITION', ' and i.sub_group_id=');

if (isset($sub_group_id)) {
    $item_sub_con = SUB_GROUP_CONDITION . $sub_group_id;
}

		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 

		if(isset($vendor_id)) 	{$vendor_con=' and v.vendor_id='.$vendor_id;} 

		$status_con=' and a.tr_from = "Purchase" ';

		

		if(isset($t_date)) 

		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		 $sql='select ji_date as GR_Date,a.sr_no as GR_no,pm.po_date,pm.po_no,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `RQ`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,v.vendor_name,a.entry_at,c.fname as User 

		   

		   from journal_item a, item_info i, user_activity_management c , item_sub_group s , purchase_receive pr,purchase_master pm,vendor v

		   where pm.vendor_id=v.vendor_id and c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id and a.warehouse_id="1" and a.tr_no=pr.id and pr.po_no=pm.po_no '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.' order by a.id';

	break;

}

}

$tr_type="Show";

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

</head>

<body>




<?require_once "../../../controllers/core/inc.exporttable.php";?>

<div class="main">

<?

		$str 	.= '<div class="header">';

if (isset($_SESSION['company_name'])) {
    $str .= '<h1>' . find_a_field('project_info','proj_name','1') . '</h1>';
}

if (isset($report)) {
    $str .= '<h2>' . $report . '</h2>';
}

if (isset($to_date)) {
    $str .= '<h2>' . $fr_date . ' To ' . $to_date . '</h2>';
}

$str .= '</div>';

if (isset($_SESSION['company_logo'])) {
    $str .= '<div class="left">';
}

if (isset($project_name)) {
    $str .= '<p>Project Name: ' . $project_name . '</p>';
}

if (isset($allotment_no)) {
    $str .= '<p>Allotment No.: ' . $allotment_no . '</p>';
}

$str .= '</div><div class="right">';

if (isset($client_name)) {
    $str .= '<p>Client Name: ' . $client_name . '</p>';
}


		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		

		

		

if($_POST['report']==220305003)

{

		$report="Soft Crab Receiving Register";	
		
		define('WAREHOUSE_CONDITION', ' and j.warehouse_id="');

if (isset($warehouse_id)) {
    $con .= WAREHOUSE_CONDITION . $warehouse_id . '"';
}

	

		

		?>

		

		


<table style="width:100%;">
    <thead>
        <tr>
            <th></th>

        </tr>
    </thead>
	   	<tr>

<td style="border:0px; border-color:white; text-align:center;">


		</td>

<td style="border:0px; border-color:white;">

<table style="width:100%;">
<tr style="text-align:center;">

					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	

				</tr>

<tr style="text-align:center;">

					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	

				</tr>

				

		 <? if ($group_for>0) {?>

        <tr>

     <td colspan="15" style="font-size:14px; border:0px; border-color:white; text-align:center;">
    <strong>Company: <?= find_a_field('user_group', 'group_name', 'id=' . $group_for) ?></strong>
</td>


         </tr>

		 <? }?>

	
		 <tr>

<td colspan="15" style="font-size:14px; border:0px; border-color:white; font-weight:700; text-align:center;">
    For Date of: <?php echo date('d-m-Y', strtotime($_POST['t_date'])); ?>
</td>


         </tr>

			</table>

		

		</td>

		

<td style="border:0px; border-color:white;">



		</td>

		</tr>

		

		<tr>

			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>

		</tr>

	 
       </table>

		

		

<table id="ExportTable" border="0">

		

		<thead>

		

		

		<? $sl=1;

		

		

		$_POST['f_date']=$_POST['t_date'];

		

		
define('PO_DATE_BETWEEN', ' and m.po_date between ');

if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
    $date_con .= PO_DATE_BETWEEN . '"' . $_POST['f_date'] . '" and "' . $_POST['t_date'] . '"';
}

if ($_POST['dealer_code_in'] != '') {
    $dealer_con_in .= " and d.dealer_code in (" . $_POST['dealer_code_in'] . ")";
}


		

		

if ($_POST['do_type'] != '') {
    $do_type_con .= ' and m.do_type = "' . $_POST['do_type'] . '" ';
}

if ($_POST['zone_id'] != '') {
    $zone_id_con .= ' and d.zone_code = "' . $_POST['zone_id'] . '" ';
}


			

if (!empty($_POST['item_sub_group_in'])) {
    foreach ($_POST['item_sub_group_in'] as $selectedOption) {
        if ($ix == 0) {
            $item_sub_group_in .= $selectedOption . ' ';
        } else {
            $item_sub_group_in .= ', ' . $selectedOption;
        }
        $ix++;
    }
}

if ($item_sub_group_in != '') {
    $item_sub_group_in_con .= " and i.sub_group_id in (" . $item_sub_group_in . ")";
}

		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

				

		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}

		

		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}

		

		if(isset($item_id)) 					{$item_id_con=' and i.item_id='.$item_id;}

		

		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}

		

		

		if ($_POST['item_id_in'] != '') {
    $item_id_in_con .= " and i.item_id in (" . $_POST['item_id_in'] . ")";
}



				 $sql  = 'select i.item_id, i.item_name

				from item_info i,  purchase_master m, purchase_invoice c,  item_sub_group s

				 where m.po_no=c.po_no and c.item_id=i.item_id and i.sub_group_id=s.sub_group_id and m.status="CHECKED" and s.sub_group_id=100010000 '.$item_id_in_con.$item_sub_group_in_con.$date_con.'

				 group by c.item_id order by i.item_id';

				$query = db_query($sql);

				$cols  = mysqli_num_rows($query);

				while($data=mysqli_fetch_object($query)){++$i;

				$item_id[$i] = $data->item_id;

		  		$item_name[$i] = $data->item_name;

		 		}

				

				

		

		 		 $sql  = 'select m.vendor_id, c.item_id, i.item_name, sum(c.qty) as total_unit, sum(c.amount) as total_amt,  i.sub_group_id, d.vendor_category

				 from purchase_master m, purchase_invoice c, vendor d, item_info i, item_sub_group s, item_group g 

				 where m.po_no=c.po_no and m.vendor_id=d.vendor_id and c.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id

				 and  s.sub_group_id=100010000 and m.status="CHECKED" 

				 '.$report_type_con.$zone_id_con.$do_type_con.$date_con.$dealer_con_in.$do_type_con.$item_mother_group_con.$item_group_con.$item_sub_con.$item_sub_group_in_con.$item_id_in_con.$item_type_con.' 

				 group by m.vendor_id , c.item_id ';

				$query = db_query($sql);	

				while($data=mysqli_fetch_object($query)){++$i;

				$vals[$data->vendor_id][$data->item_id] = $data->total_unit;

				$dealer_total[$data->vendor_id] = $dealer_total[$data->vendor_id] + $data->total_unit;

				$zone_code_total[$data->vendor_category][$data->item_id] = $zone_code_total[$data->vendor_category][$data->item_id] +  $data->total_unit;

				$zone_code_total_gtotal[$data->vendor_category] = $zone_code_total_gtotal[$data->vendor_category] +  $data->total_unit;

				$total_item[$data->item_id] = $total_item[$data->item_id] + $data->total_unit;

				$all_total = $all_total +  $data->total_unit;

				

				$dealer_total_amt[$data->vendor_id] = $dealer_total_amt[$data->vendor_id] + $data->total_amt;

				$zone_code_total_amt[$data->vendor_category][$data->item_id] = $zone_code_total_amt[$data->vendor_category][$data->item_id] +  $data->total_amt;

				$zone_code_total_gtotal_amt[$data->vendor_category] = $zone_code_total_gtotal_amt[$data->vendor_category] +  $data->total_amt;

				$total_item_amt[$data->item_id] = $total_item_amt[$data->item_id] + $data->total_amt;

				$all_total_amt = $all_total_amt +  $data->total_amt;

				

				

				

		 		}

				

		 

		

		  $sqlcl="select d.vendor_id, d.vendor_name, d.vendor_category, z.category_name 

		 from vendor d, vendor_category z

		 where  d.vendor_category=z.id ".$zone_id_con." group by d.vendor_id

		order by  d.vendor_category, d.vendor_id ";

		

		$rescl	 = db_query($sqlcl);



		

		

		

		?>

		

		

		

		<tr>

<th style="background-color: #FFFACD;">SL</th>

<th class="supplier-name">SUPPLIER NAME</th>


				  <?



for($i=1;$i<=$cols;$i++)

{

echo '<th style="background-color: #66CCCC;" ><strong>'.$item_name[$i].'</strong></th>';

}



?>



<th style="background-color: #66CCCC;">TOTAL</th>



<th style="background-color: #66CCCC;">TOTAL AMT</th>

		

		</tr>



		

		</thead>

		

		

		<?

		while($row=mysqli_fetch_object($rescl)){

		

		

		
if (($old_zone_code != $row->vendor_category) && $old_zone_code > 0 && $zone_code_total_gtotal[$old_zone_code] != 0) {
?>
    <tr style="background-color: #E1F4FA; font-weight:700;">
        <td colspan="2" style="text-transform:uppercase">TOTAL <?=$old_ZONE_NAME?></td>
        <?php for ($i = 1; $i <= $cols; $i++) { ?>
            <td><?= number_format($zone_code_total[$old_zone_code][$item_id[$i]], 3); ?></td>
        <?php } ?>
        <td><strong><?= number_format($zone_code_total_gtotal[$old_zone_code], 3); ?></strong></td>
        <td><strong><?= number_format($zone_code_total_gtotal_amt[$old_zone_code], 2); ?></strong></td>
    </tr>
<?
}

	

		if($dealer_total[$row->vendor_id]<>0) {

		?>

		

		<tbody>

		<tr <?=($xx%2==0)?' style="background-color: #F5F5F5;"':'';$xx++;?>>

		<td><?=$sl++;?></td>

		<td> <a href="po_print_view.php?show=show&po_date=<?=$_REQUEST['t_date']?>&vendor_id=<?=$row->vendor_id?>"

		 target="_blank" style=" font-size:14px; text-transform:uppercase; color:#000000;"><?=$row->vendor_name?></a></td>

		<?



for($i=1;$i<=$cols;$i++)

{

echo '<td>'.number_format($vals[$row->vendor_id][$item_id[$i]],3).'</td>';

} ?>



<td><?=number_format($dealer_total[$row->vendor_id],3);?></td>



<td><?=number_format($dealer_total_amt[$row->vendor_id],2);?></td>

		</tr>

<? 



}



		$old_zone_code = $row->vendor_category;

		$old_ZONE_NAME = $row->category_name;



 }

 

 

 if($zone_code_total[$old_zone_code]<>0)

{

 ?>







<tr style="background-color:#E1F4FA; font-weight:700;">

        <td colspan="2"  style="text-transform:uppercase">TOTAL <?=$old_ZONE_NAME?></td>

        <? for($i=1;$i<=$cols;$i++){ ?><td><?  echo  number_format($zone_code_total[$old_zone_code][$item_id[$i]],3);?></td> <? }?> 

		

		

		

<td><?  echo  number_format($zone_code_total_gtotal[$old_zone_code],3);?></td>



<td><?  echo  number_format($zone_code_total_gtotal_amt[$old_zone_code],2);?></td>



        </tr>

		

<? }?>


		<tr>

<td style="background-color:#ADD8E6;">&nbsp;</td>

<td style="background-color:#ADD8E6; text-align:right;">
    <strong>GRAND TOTAL:</strong>
</td>

		  <?



for($i=1;$i<=$cols;$i++)

{

echo '<td bgcolor="#ADD8E6"><strong>'.number_format($total_item[$item_id[$i]],3).'</strong></td>';



}



?>



<td style="background-color: #ADD8E6;"><strong><?=number_format($all_total,3);?></strong></td>



<td style="background-color: #ADD8E6;"><strong>&nbsp;</strong></td>

		  </tr>

		  

		  

		  

		  <tr>

		  <td style="background-color: #ADD8E6;">&nbsp;</td>

<td style="background-color: #ADD8E6; text-align:right;">
    <strong>GRAND TOTAL AMT:</strong>
</td>


		  <?



for($i=1;$i<=$cols;$i++)

{

echo '<td bgcolor="#ADD8E6"><strong>'.number_format($total_item_amt[$item_id[$i]],2).'</strong></td>';



}



?>



<td style="background-color: #ADD8E6;"><strong><?=number_format($all_total_amt,2);?></strong></td>



<td style="background-color: #ADD8E6;"><strong><?=number_format($all_total_amt,2);?></strong></td>

		  </tr>

		  

		  

		

		

		

		

		</tbody>

  </table>

<? }





elseif($_POST['report']==221021001)

{

		$report="Supplier Information ";		

		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}

		

		?>

		

		

		<table width="100%">


<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr>
            <th style="text-align:left;"></th>
            <th style="text-align:left;"></th>
            <th style="text-align:left;"></th>
        </tr>
    </thead>
	   	<tr>

<td style="width:25%; text-align:center; border:0; border-color:white;">
    Data
</td>


		<td style= width="50%" style="border:0px; border-color:white;">
		    
		    

			<table width="100%"  >

<tr style="text-align:center;">

					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	

				</tr>

<tr style="text-align:center;">

					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	

				</tr>

				

		 <? if ($group_for>0) {?>

        <tr>

<td colspan="15" style="font-size:14px; border:0; border-color:white; text-align:center;">
    <strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong>
</td>


         </tr>

		 <? }?>
			</table>

		

		</td>

		

<td style="width:25%; text-align:center; border:0; border-color:white;">


		</td>

		</tr>

		

		<tr>

			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>

		</tr>

       </table>

		

	<table id="ExportTable" style="width:100%; border-collapse:collapse; padding:2px; border:0;">

		<thead>

<tr style="text-transform:uppercase">
    <th style="background-color: #d6eaf8; width:2%;">SL</th>
    <th style="background-color: #d6eaf8; width:8%;">CODE NO</th>
    <th style="background-color: #d6eaf8; width:23%;">SUPPLIER NAME</th>
    <th style="background-color: #d6eaf8; width:19%; text-align:center;">Proprietor Name</th>
    <th style="background-color: #d6eaf8; width:20%; text-align:center;">Mobile No</th>
    <th style="background-color: #d6eaf8; width:28%; text-align:center;">Address</th>
</tr>

		</thead><tbody>

		<? $sl=1;

		

		

if ($_POST['vendor_category'] != '') {
    $vendor_con .= ' and v.vendor_category = "' . $_POST['vendor_category'] . '" ';
}

		

	

		

		 $sql_sub="select v.vendor_category, c.category_name from vendor v, vendor_category c where  

		 v.vendor_category=c.id ".$category_con.$vendor_con." group by v.vendor_category";

		$data_sub=db_query($sql_sub);



		while($info_sub=mysqli_fetch_object($data_sub)){ 

		



		?>

		

		

		

		

		<tr>

		  <td>&nbsp;</td>

		  <td>&nbsp;</td>

<td>
    <div style="text-align:left; text-transform:uppercase; font-size:14px; font-weight:700;">
        <strong><?=$info_sub->category_name?></strong>
    </div>
</td>


		  <td>&nbsp;</td>

		  <td>&nbsp;</td>

		  <td>&nbsp;</td>

		</tr>

		

		

		

		

		

		<?



		

		 $sql="select  v.vendor_id, v.vendor_name, v.contact_no, v.proprietor_name, v.address,  c.category_name from vendor v, vendor_category c

		 where   v.vendor_category=c.id and v.vendor_category='".$info_sub->vendor_category."'  ".$category_con.$vendor_con." order by v.vendor_category,v.vendor_id";

		

		$res	 = db_query($sql);

		while($row=mysqli_fetch_object($res))

		{



		

		?>

	<?
define('ROW_BG_COLOR', ' bgcolor="#F8F8FF"');

?>
<tr <?=($xx % 2 == 0) ? ROW_BG_COLOR : ''; $xx++;?>>
    <td><?=$sl++;?></td>
    <td>
        <a href="../vendor/vendor_profile_print_view.php?vendor_id=<?=$row->vendor_id?>" 
           target="_blank" 
           style="color:#000000; text-decoration:none; font-size:14px; text-transform:uppercase;">
           <?=$row->vendor_id;?>
        </a>
    </td>
    <td><?=$row->vendor_name;?></td>
    <td><?=$row->proprietor_name;?></td>
    <td><?=$row->contact_no;?></td>
    <td><?=$row->address;?></td>
</tr>
	


	
		<td>

		<a href="../vendor/vendor_profile_print_view.php?vendor_id=<?=$row->vendor_id?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:14px; text-transform:uppercase;"><?=$row->vendor_id;?></a>

		</td>

		<td><?=$row->vendor_name;?></td>

		<td>

		 <?=$row->proprietor_name;?>

		  </td>

		<td><?=$row->contact_no;?></td>

		<td><?=$row->address;?></td>

		</tr>

<?  } ?>

		

		  

		  <?    } ?>

		

		

		

		

		</tbody>

		</table>

		<?

}







		

elseif($_POST['report']==221025001)

{

		$report="Soft Crab Receiving Register";		

		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}

		

		?>

		

		

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="width: 25%; text-align: center; border: 0; border-color: white;">
            </th>
        </tr>
    </thead>
    
        <tr>
            <td style="width: 25%; text-align: center; border: 0; border-color: white;">
            </td>
        </tr>


<td style="border: 0; border-color: white; width: 50%;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: center;">
                <th style="font-size: 20px; border: 0; border-color: white;">
                    <strong><?= $_SESSION['company_name']; ?></strong>
                </th>
            </tr>
  </thead>
<tr style="text-align: center;">
    <td style="font-size: 14px; border: 0; border-color: white;">
        <strong><?= $report; ?></strong>
    </td>
</tr>


				

		 <? if ($group_for>0) {?>

        <tr>

<td colspan="15" style="font-size: 14px; border: 0; border-color: white; text-align: center;">
    <strong>Company: <?= find_a_field('user_group', 'group_name', 'id=' . $group_for) ?></strong>
</td>


         </tr>

		 <? }?>

	 

		 <tr>

<td colspan="15" style="font-size: 14px; border: 0; border-color: white; font-weight: 700; text-align: center;">
    For Date of: <?php echo date('d-m-Y', strtotime($_POST['t_date'])); ?>
</td>


         </tr>

			</table>

		

		</td>

		

<td style="width: 25%; text-align: center; border: 0; border-color: white;">

	
		</td>

		</tr>

		

		<tr>

			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>

		</tr>

	   	

	   	

	

		 

		 

       </table>

		

		
<table id="ExportTable" style="width: 100%; border-collapse: collapse; padding: 2px; border: 0;">


		

		<thead>

		

		

		<? $sl=1;

		

		

		$_POST['f_date']=$_POST['t_date'];

		

		

		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
    $date_con .= ' and m.po_date between "' . $_POST['f_date'] . '" and "' . $_POST['t_date'] . '"';
}

		

		if($_POST['dealer_code_in']!='')  {

		$dealer_con_in .= " and d.dealer_code in (".$_POST['dealer_code_in'].")";}



	if ($_POST['do_type'] != '') {
    $do_type_con .= ' and m.do_type = "' . $_POST['do_type'] . '" ';
}

		
if ($_POST['zone_id'] != '') {
    $zone_id_con .= ' and d.zone_code = "' . $_POST['zone_id'] . '" ';
}

			

			
if (!empty($_POST['item_sub_group_in'])) {
    foreach ($_POST['item_sub_group_in'] as $selectedOption) {
        if ($ix == 0) {
            $item_sub_group_in .= $selectedOption . ' ';
        } else {
            $item_sub_group_in .= ', ' . $selectedOption;
        }
        $ix++;
    }
}


if($item_sub_group_in!='')     {$item_sub_group_in_con .= " and i.sub_group_id in (".$item_sub_group_in.")";}


				

		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

				

		if(isset($item_group)) 					{$item_group_con=' and s.group_id='.$item_group;}

		

		if(isset($item_sub_group)) 				{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}

		

		if(isset($item_id)) 					{$item_id_con=' and i.item_id='.$item_id;}

		

		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}

		

		

		if ($_POST['item_id_in'] != '') {
    $item_id_in_con .= " and i.item_id in (" . $_POST['item_id_in'] . ")";
}




		

				

				

				 $sql  = 'select i.item_id, i.item_name

				from item_info i,  purchase_master m, purchase_invoice c,  item_sub_group s

				 where m.po_no=c.po_no and c.item_id=i.item_id and i.sub_group_id=s.sub_group_id and m.status="CHECKED" and s.sub_group_id=100010000 '.$item_id_in_con.$item_sub_group_in_con.$date_con.'

				 group by c.item_id order by i.item_id';

				$query = db_query($sql);

				$cols  = mysqli_num_rows($query);

				while($data=mysqli_fetch_object($query)){++$i;

				$item_id[$i] = $data->item_id;

		  		$item_name[$i] = $data->item_name;

		 		}

				

				

		

		 		 $sql  = 'select m.vendor_id, c.item_id, i.item_name, sum(c.qty) as total_unit, sum(c.amount) as total_amt,  i.sub_group_id, d.vendor_category

				 from purchase_master m, purchase_invoice c, vendor d, item_info i, item_sub_group s, item_group g 

				 where m.po_no=c.po_no and m.vendor_id=d.vendor_id and c.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id

				 and  s.sub_group_id=100010000 and m.status="CHECKED" 

				 '.$report_type_con.$zone_id_con.$do_type_con.$date_con.$dealer_con_in.$do_type_con.$item_mother_group_con.$item_group_con.$item_sub_con.$item_sub_group_in_con.$item_id_in_con.$item_type_con.' 

				 group by m.vendor_id , c.item_id ';

				$query = db_query($sql);	

				while($data=mysqli_fetch_object($query)){++$i;

				$vals[$data->vendor_id][$data->item_id] = $data->total_unit;

				$dealer_total[$data->vendor_id] = $dealer_total[$data->vendor_id] + $data->total_unit;

				$zone_code_total[$data->vendor_category][$data->item_id] = $zone_code_total[$data->vendor_category][$data->item_id] +  $data->total_unit;

				$zone_code_total_gtotal[$data->vendor_category] = $zone_code_total_gtotal[$data->vendor_category] +  $data->total_unit;

				$total_item[$data->item_id] = $total_item[$data->item_id] + $data->total_unit;

				$all_total = $all_total +  $data->total_unit;

				

				$dealer_total_amt[$data->vendor_id] = $dealer_total_amt[$data->vendor_id] + $data->total_amt;

				$zone_code_total_amt[$data->vendor_category][$data->item_id] = $zone_code_total_amt[$data->vendor_category][$data->item_id] +  $data->total_amt;

				$zone_code_total_gtotal_amt[$data->vendor_category] = $zone_code_total_gtotal_amt[$data->vendor_category] +  $data->total_amt;

				$total_item_amt[$data->item_id] = $total_item_amt[$data->item_id] + $data->total_amt;

				$all_total_amt = $all_total_amt +  $data->total_amt;

				

				

				

		 		}

				

		 

		

		  $sqlcl="select d.vendor_id, d.vendor_name, d.vendor_category, z.category_name 

		 from vendor d, vendor_category z

		 where  d.vendor_category=z.id ".$zone_id_con." group by d.vendor_id

		order by  d.vendor_category, d.vendor_id ";

		

		$rescl	 = db_query($sqlcl);



		

		

		

		?>

		

		

		

		<tr>

	<th style="background-color:#FFFACD;">SL</th>
<th style="background-color:#FFFACD;">SUPPLIER NAME</th>
<th style="background-color:#FFFACD;">Challan No</th>

<?php
for($i = 1; $i <= $cols; $i++) {
    echo '<th style="background-color:#66CCCC;"><strong>'.$item_name[$i].'</strong></th>';
}
?>

<th style="background-color:#66CCCC;">TOTAL</th>
<th style="background-color:#66CCCC;">TOTAL AMT</th>

		</tr>

		</thead>

		

		

		<?

		while($row=mysqli_fetch_object($rescl)){

		

		if(($old_zone_code != $row->vendor_category)&&$old_zone_code >0)

		{

		

		if($zone_code_total_gtotal[$old_zone_code]<>0)

		{

		?>



		<tr style="background-color:#E1F4FA;" style=" font-weight:700; ">

        <td colspan="3" style="text-transform:uppercase">TOTAL <?=$old_ZONE_NAME?></td>

        <? for($i=1;$i<=$cols;$i++){ ?><td><?  echo  number_format($zone_code_total[$old_zone_code][$item_id[$i]],3);?></td> <? }?> 

		

		

		<td><strong><?  echo  number_format($zone_code_total_gtotal[$old_zone_code],3);?></strong></td>

		<td style="width:12%;">
    <strong><?php echo number_format($zone_code_total_gtotal_amt[$old_zone_code], 2); ?></strong>
</td>

        </tr>

		<?

		}

		}

	

		if($dealer_total[$row->vendor_id]<>0) {

		?>

		

		<tbody>

		

		

	

		

		<tr <?=($xx%2==0)?' style="background-color:#F5F5F5;"':'';$xx++;?>>

		<td><?=$sl++;?></td>

		<td> <a href="po_print_view.php?show=show&po_date=<?=$_REQUEST['t_date']?>&vendor_id=<?=$row->vendor_id?>"

		 target="_blank" style=" font-size:14px; text-transform:uppercase; color:#000000;"><?=$row->vendor_name?></a></td>

		<td>

		

		 <?  

$o=0;

		$po_sql = 'SELECT po_no, invoice_no FROM purchase_master WHERE vendor_id="'.$row->vendor_id.'" and po_date="'.$_REQUEST['t_date'].'" and status="CHECKED" GROUP by po_no order by  invoice_no';

			$po_query=db_query($po_sql);

			while($po_data= mysqli_fetch_object($po_query)){

			$o++;

			if ($o>1) { echo ', ';}

echo $po_data->invoice_no;}?>

		

		

		</td>

		<?



for($i=1;$i<=$cols;$i++)

{

echo '<td>'.number_format($vals[$row->vendor_id][$item_id[$i]],3).'</td>';

} ?>



<td><?=number_format($dealer_total[$row->vendor_id],3);?></td>



<td><?=number_format($dealer_total_amt[$row->vendor_id],2);?></td>

		</tr>

<? 



}



		$old_zone_code = $row->vendor_category;

		$old_ZONE_NAME = $row->category_name;



 }

 

 

 if($zone_code_total[$old_zone_code]<>0)

{

 ?>







<tr style="background-color:#E1F4FA;" style=" font-weight:700; ">

        <td colspan="3"  style="text-transform:uppercase">TOTAL <?=$old_ZONE_NAME?></td>

        <? for($i=1;$i<=$cols;$i++){ ?><td><?  echo  number_format($zone_code_total[$old_zone_code][$item_id[$i]],3);?></td> <? }?> 

		

		

		

<td><?  echo  number_format($zone_code_total_gtotal[$old_zone_code],3);?></td>



<td><?  echo  number_format($zone_code_total_gtotal_amt[$old_zone_code],2);?></td>

        </tr>

		

<? }?>





		<tr>

		  <td style="background-color:#ADD8E6;">&nbsp;</td>

<td style="background-color:#ADD8E6; text-align:right;">
    <strong>GRAND TOTAL:</strong>
</td>
<td style="background-color:#ADD8E6;">&nbsp;</td>

		  <?



for($i=1;$i<=$cols;$i++)

{

echo '<td bgcolor="#ADD8E6"><strong>'.number_format($total_item[$item_id[$i]],3).'</strong></td>';



}



?>



<td style="background-color:#ADD8E6;"><strong><?=number_format($all_total,3);?></strong></td>



<td style="background-color:#ADD8E6;"><strong>&nbsp;</strong></td>

		  </tr>

		  

		  

		  

		  <tr>

		  <td style="background-color:#ADD8E6;">&nbsp;</td>

		  <td style="background-color:#ADD8E6; text-align:right;">
    <strong>GRAND TOTAL AMT:</strong>
</td>
<td style="background-color:#ADD8E6;">&nbsp;</td>
 <?



for($i=1;$i<=$cols;$i++)

{

echo '<td style="background-color:#ADD8E6;"><strong>'.number_format($total_item_amt[$item_id[$i]],2).'</strong></td>';



}



?>



<td style="background-color:#ADD8E6;"><strong><?=number_format($all_total_amt,2);?></strong></td>



<td style="background-color:#ADD8E6;"><strong><?=number_format($all_total_amt,2);?></strong></td>

		  </tr>

		</tbody>

		</table>

<? }





elseif($_POST['report']==251022001)

{

		$report="Chart of Accounts";		

		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}

		

		?>

		

		

<table style="width:100%;">
	   	<tr>

<td style="width:25%; text-align:center; border:0; border-color:white;">

		</td>

	<td style="width:50%; border:0; border-color:white;">
    <table style="width:100%;">
        <thead>
            <tr style="text-align:center;">
                <th style="font-size:20px; border:0; border-color:white;">Company Name</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align:center;">
                <td style="font-size:20px; border:0; border-color:white;">
                    <strong><?=$_SESSION['company_name'];?></strong>
                </td>
            </tr>
        </tbody>
    </table>
</td>


				</tr>

<tr style="text-align:center;">
    <td style="font-size:14px; border:0; border-color:white;">
        <strong><?=$report;?></strong>
    </td>
</tr>


				

		 <? if ($_POST['vendor_id']>0) {?>

        <tr>

        <?php
define('VENDOR_ID_LITERAL', 'vendor_id=');
define('VENDOR_CONCAT_LITERAL', 'concat(vendor_id," - ",vendor_name)');
?>

<td colspan="15" style="font-size:14px; border:0; border-color:white; text-align:center;">
    <strong>
        Supplier Name: <?= find_a_field('vendor', VENDOR_CONCAT_LITERAL, VENDOR_ID_LITERAL . $_POST['vendor_id']); ?>
    </strong>
</td>

         </tr>

		 <? }?>

		 

		  <? if ($_POST['vendor_area']>0) {?>

        <tr>

         <td colspan="15" style="font-size:14px; border:0; border-color:white; text-align:center;">
    <strong>
        <?=find_a_field('vendor_category','category_name','id='.$_POST['vendor_area'])?>
    </strong>
</td>

         </tr>

		 <? }?>

		 


			</table>

		

		</td>

		

<td style="width:25%; text-align:center; border:0; border-color:white;">

	
		</td>

		</tr>

		

		<tr>

			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>

		</tr>

	 

       </table>

		

		

	<table style="width:100%; border:0; padding:2px;" id="ExportTable">


		

		<thead>

		

		

		

		<tr style="text-transform:uppercase">

		<th style="background-color:#d6eaf8;">L-01</th>
<th style="background-color:#d6eaf8; text-align:center;">CLASS</th>
<th style="background-color:#d6eaf8; text-align:center;">L-02</th>
<th style="background-color:#d6eaf8; text-align:center;">SUB CLASS</th>
<th style="background-color:#d6eaf8; text-align:center;">L-03</th>
<th style="background-color:#d6eaf8; text-align:center;">SUB SUB CLASS</th>
<th style="background-color:#d6eaf8; text-align:center;">L-04</th>
<th style="background-color:#d6eaf8; text-align:center;">GL Group</th>
<th style="background-color:#d6eaf8; text-align:center;">L-05</th>
<th style="background-color:#d6eaf8; text-align:center;">Head OF ACCOUNTS</th>

		
		

		</tr>

		</thead><tbody>

		<? $sl=1;

		


		?>

		<?

		

		

		

	if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
    $date_con .= ' and m.po_date between "' . $_POST['f_date'] . '" and "' . $_POST['t_date'] . '"';
}

if ($_POST['acc_class'] != '') {
    $acc_con .= ' and a.acc_class = "' . $_POST['acc_class'] . '" ';
}

if ($_POST['acc_sub_class'] != '') {
    $acc_con .= ' and a.acc_sub_class = "' . $_POST['acc_sub_class'] . '" ';
}

if ($_POST['acc_sub_sub_class'] != '') {
    $acc_con .= ' and a.acc_sub_sub_class = "' . $_POST['acc_sub_sub_class'] . '" ';
}

if ($_POST['ledger_group_id'] != '') {
    $acc_con .= ' and a.ledger_group_id = "' . $_POST['ledger_group_id'] . '" ';
}

		

		

		

		

		 $sql = "select id, class_name from acc_class where 1";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $class_name[$info->id]=$info->class_name;

		}

		

		 $sql = "select id, sub_class_name from acc_sub_class where 1";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $sub_class_name[$info->id]=$info->sub_class_name;

		}

		

		 $sql = "select id, sub_sub_class_name from acc_sub_sub_class where 1";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $sub_sub_class_name[$info->id]=$info->sub_sub_class_name;

		}

		

		 $sql = "select group_id, group_name from ledger_group where 1";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $group_name[$info->group_id]=$info->group_name;

		}

		



		

		  $sql="select a.* from accounts_ledger a  where 1 ".$acc_con." ";

		

		$res	 = db_query($sql);

		while($row=mysqli_fetch_object($res))

		{



		

		?>

		

		<tr <?=($xx%2==0)?' bgcolor="#F8F8FF"':'';$xx++;?>>

		<td><?=$row->acc_class;?></td>

		<td><?=$class_name[$row->acc_class]?></td>

		<td><?=$row->acc_sub_class;?></td>

		<td ><?=$sub_class_name[$row->acc_sub_class]?></td>

		<td ><?=$row->acc_sub_sub_class;?></td>

		<td ><?=$sub_sub_class_name[$row->acc_sub_sub_class]?></td>

		<td ><?=$row->ledger_group_id;?></td>

		<td ><?=$group_name[$row->ledger_group_id]?></td>

		<td ><?=$row->ledger_id;?></td>

		<td ><?=$row->ledger_name;?></td>
		
		

		</tr>

<?  } ?>


		</tbody>

		</table>

		<?

}





elseif($_POST['report']==251022002)

{

		$report="Budget Comparison Report";		

		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}

		

		?>

		

		

		<table style="width:100%;">


	   	<tr>



<td style="width:50%; border:0; border-color:white;">

<table style="width:100%;">
    <thead>
        <tr style="text-align:center;">
            <th style="font-size:20px; border:0; border-color:white;">Company Name</th>
        </tr>
        <tr style="text-align:center;">
            <th style="font-size:14px; border:0; border-color:white;"><?=$report;?></th>
        </tr>
        <?php if ($_POST['vendor_id'] > 0) { ?>
        <tr style="text-align:center;">
            <th colspan="15" style="font-size:14px; border:0; border-color:white;">
                Supplier Name: <?=find_a_field('vendor','concat(vendor_id," - ",vendor_name)','vendor_id='.$_POST['vendor_id'])?>
            </th>
        </tr>
        <?php } ?>
        <?php if ($_POST['vendor_area'] > 0) { ?>
        <tr style="text-align:center;">
            <th colspan="15" style="font-size:14px; border:0; border-color:white;">
                <?=find_a_field('vendor_category','category_name','id='.$_POST['vendor_area'])?>
            </th>
        </tr>
        <?php } ?>
    </thead>
    <tbody>
        <tr>
            <td style="width:25%; text-align:center; border:0; border-color:white;"></td>
        </tr>
        <tr>
            <td colspan="15" style="font-size:14px; border:0; border-color:white;">&nbsp;</td>
        </tr>
    </tbody>
</table>

		

		

<table style="width:100%; border:0; padding:2px;" id="ExportTable">
    <thead>
        <tr style="text-transform:uppercase">
            <th style="background-color:#d6eaf8;">L-01</th>
            <th style="background-color:#d6eaf8; text-align:center;">CLASS</th>
            <th style="background-color:#d6eaf8; text-align:center;">SUB CLASS</th>
            <th style="background-color:#d6eaf8; text-align:center;">SUB SUB CLASS</th>
            <th style="background-color:#d6eaf8; text-align:center;">GL Group</th>
            <th style="background-color:#d6eaf8; text-align:center;">Head OF ACCOUNTS</th>
            <th style="background-color:#d6eaf8; text-align:center;">Budget Date</th>
            <th style="background-color:#d6eaf8; text-align:center;">Budget Amount</th>
            <th style="background-color:#d6eaf8; text-align:center;">Expense Amount</th>
            <th style="background-color:#d6eaf8; text-align:center;">Available Balance</th>
        </tr>


		</thead><tbody>

		<? $sl=1;

		?>

		<?

		

		

		
if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
    $date_con .= ' and m.po_date between "' . $_POST['f_date'] . '" and "' . $_POST['t_date'] . '"';
}

if ($_POST['acc_class'] != '') {
    $acc_con .= ' and a.acc_class = "' . $_POST['acc_class'] . '" ';
}

if ($_POST['acc_sub_class'] != '') {
    $acc_con .= ' and a.acc_sub_class = "' . $_POST['acc_sub_class'] . '" ';
}

if ($_POST['acc_sub_sub_class'] != '') {
    $acc_con .= ' and a.acc_sub_sub_class = "' . $_POST['acc_sub_sub_class'] . '" ';
}

if ($_POST['ledger_group_id'] != '') {
    $acc_con .= ' and a.ledger_group_id = "' . $_POST['ledger_group_id'] . '" ';
}

       
		$sql = "select id, class_name from acc_class where 1";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $class_name[$info->id]=$info->class_name;

		}

		

		$sql = "select id, sub_class_name from acc_sub_class where 1";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $sub_class_name[$info->id]=$info->sub_class_name;

		}

		

		$sql = "select id, sub_sub_class_name from acc_sub_sub_class where 1";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $sub_sub_class_name[$info->id]=$info->sub_sub_class_name;

		}

		

		$sql = "select group_id, group_name from ledger_group where 1";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $group_name[$info->group_id]=$info->group_name;

		}

		



		

		 $sql="select a.* from accounts_ledger a  where 1 ".$acc_con."";

		

		$res	 = db_query($sql);

		while($row=mysqli_fetch_object($res))

		{

		?>

		

		<tr <?=($xx%2==0)?' bgcolor="#F8F8FF"':'';$xx++;?>>

		<td><?=$row->acc_class;?></td>

		<td><?=$class_name[$row->acc_class]?></td>

		<td ><?=$sub_class_name[$row->acc_sub_class]?></td>

		<td ><?=$sub_sub_class_name[$row->acc_sub_sub_class]?></td>

		<td ><?=$group_name[$row->ledger_group_id]?></td>

		<td ><?=$row->ledger_name;?></td>

	<?php
define('LEDGER_ID_FIELD', 'ledger_id="');
?>

<td><?= find_a_field('budget_balance', 'entry_at', LEDGER_ID_FIELD . $row->ledger_id . '"'); ?></td>


		<td ><?=$b_amt=find_a_field('budget_balance','dr_amt','ledger_id="'.$row->ledger_id.'" and fiscal_year="'.$_POST['fiscal_year'].'"');?></td>

		<td >

			

			<?

				$e_amt=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$row->ledger_id.'"');

			if($e_amt<0){

			

			}else {

				echo $cost_amt=$e_amt;

			}

			?>

		

		</td>

		<td><?=$fg=number_format($b_amt-$e_amt,2)?></td>

		</tr>

<?
$gcost_amt+=$cost_amt;

$fgd+=$b_amt-$e_amt;
  } ?>

	<tr>
	<td colspan="8">Total</td>
	<td><?=$gcost_amt?></td>
	<td><?=$fgd?></td>
	
	</tr>	


		</tbody>

		</table>

		<?

}
elseif($_POST['report']==221023002)

{

		$report="Area Wise Purchase Summary Report";		

		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}

		

		?>

		

		

	<table style="width:100%;">
    <thead>
        <tr>
            <th style="border:0; border-color:white;"></th>
            <th style="border:0; border-color:white;"></th>
            <th style="border:0; border-color:white;"></th>
        </tr>
    </thead>
	   	<tr>

<td style="text-align:center; border:0; border-color:white;">

		</td>

<td style="width:50%; border:0; border-color:white;">

<table style="width:100%;">

				<tr align="center" >

					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	

				</tr>
				
				
<tr style="text-align:center;">
    <td style="font-size:14px; border:0; border-color:white;"><strong><?= $report; ?></strong></td>  
</tr>


				

		 <? if ($_POST['vendor_id']>0) {?>

        <tr>

         <td colspan="15" style="font-size:14px; border:0; border-color:white; text-align:center;">
    <strong>
        Supplier Name: <?= find_a_field('vendor','concat(vendor_id," - ",vendor_name)','vendor_id=' . $_POST['vendor_id']); ?>
    </strong>
</td>


         </tr>

		 <? }?>

		 

		  <? if ($_POST['vendor_area']>0) {?>

        <tr>

          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Supplier Area:

		   <?=find_a_field('vendor_category','category_name','id='.$_POST['vendor_area'])?></strong></td>

         </tr>

		 <? }?>

		 

		 

		 <tr>

<td colspan="15" style="font-size:14px; border:0; border-color:white; font-weight:700; text-align:center;">


		  For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>	<strong> To </strong><?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>

         </tr>

			</table>

		

		</td>

		

	<td style="width:25%; border:0; border-color:white; text-align:center;">



		</td>

		</tr>

		

		<tr>

			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>

		</tr>

		 

       </table>

		
	<table id="ExportTable" style="width:100%; padding:2px; border:0; border-spacing:0;">


		

		<thead>


	<tr style="text-transform:uppercase;">
    <th style="background-color:#d6eaf8;">SL</th>
    <th style="background-color:#d6eaf8;">Item Group</th>
    <th style="background-color:#d6eaf8; text-align:center;">Item Name</th>
    <th style="background-color:#d6eaf8; text-align:center;">Unit Name</th>
    <th style="background-color:#d6eaf8; text-align:center;">Quantity</th>
    <th style="background-color:#d6eaf8; text-align:center;">Rate</th>
    <th style="background-color:#d6eaf8; text-align:center;">Amount</th>
</tr>


		</thead><tbody>

		<? $sl=1;



		if ($_POST['f_date'] != '' && $_POST['t_date'] != '') {
    $date_con .= ' and m.po_date between "' . $_POST['f_date'] . '" and "' . $_POST['t_date'] . '"';
}


 		$sql_sub="select  m.vendor_area, c.category_name

		 from vendor_category c, purchase_master m, purchase_invoice p,  item_info i, item_sub_group s

		 where  c.id=m.vendor_area and m.po_no=p.po_no and p.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.sub_group_id=100010000 and m.status='CHECKED'

		  ".$vendor_area_con.$vendor_con.$date_con." group by m.vendor_area order by m.vendor_area";

		$data_sub=db_query($sql_sub);



		while($info_sub=mysqli_fetch_object($data_sub)){ 

		?>

		

		<tr >

		<td>&nbsp;</td>

		<td>&nbsp;</td>

		<td style="text-align:center;"><strong><?= $info_sub->category_name; ?></strong></td>

<td style="text-align:right;"><strong>&nbsp;</strong></td>

<td style="text-align:right;"><strong>&nbsp;</strong></td>

<td style="text-align:right;">&nbsp;</td>

<td style="text-align:right;"><strong>&nbsp;</strong></td>

		</tr>

		

		<?


	if ($_POST['vendor_area'] != '') {
    $vendor_area_con .= ' and m.vendor_area = "' . $_POST['vendor_area'] . '" ';
}

if ($_POST['vendor_id'] != '') {
    $vendor_con .= ' and m.vendor_id = "' . $_POST['vendor_id'] . '" ';
}



		

		 $sql="select  s.sub_group_name, i.item_name, i.unit_name,  sum(p.qty) as purchase_qty, sum(p.amount) as purchase_amt

		 from purchase_master m, purchase_invoice p,  item_info i, item_sub_group s

		 where   m.po_no=p.po_no and p.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.sub_group_id=100010000 and m.status='CHECKED' and

		  m.vendor_area='".$info_sub->vendor_area."' ".$vendor_area_con.$vendor_con.$date_con." group by m.vendor_area,p.item_id order by i.item_id";

		

		$res	 = db_query($sql);

		while($row=mysqli_fetch_object($res))

		{



		

		?>

		

		<tr <?=($xx%2==0)?' bgcolor="#F8F8FF"':'';$xx++;?>>

		<td><?=$sl++;?></td>

		<td><?=$row->sub_group_name;?></td>

		<td>

		 <?=$row->item_name;?>		  </td>

		<td><?=$row->unit_name;?></td>

<td style="text-align:right;">
    <?= number_format($row->purchase_qty, 3); $total_purchase_qty += $row->purchase_qty; ?>
</td>

<td style="text-align:right;">
    <?= number_format($unit_proce = ($row->purchase_amt / $row->purchase_qty), 3); ?>
</td>

<td style="text-align:right;">
    <?= number_format($row->purchase_amt, 2); $total_purchase_amt += $row->purchase_amt; ?>
</td>

		</tr>

<?  } ?>

		

		  <tr >

		<td>&nbsp;</td>

		<td>&nbsp;</td>

		<td>&nbsp; </td>

<td style="text-align:right;"><strong>SUB TOTAL:</strong></td>

<td style="text-align:right;">
    <strong>
        <?= number_format($total_purchase_qty, 3); $grand_total_purchase_qty += $total_purchase_qty; ?>
    </strong>
</td>

<td style="text-align:right;">&nbsp;</td>

<td style="text-align:right;">
    <strong>
        <?= number_format($total_purchase_amt, 2); $grand_total_purchase_amt += $total_purchase_amt; ?>
    </strong>
</td>

		</tr>

	

	<?

	$total_purchase_qty=0;

	$total_purchase_amt=0;

	  } ?>

		<tr >

		<td>&nbsp;</td>

		<td>&nbsp;</td>

		<td>&nbsp; </td>

	<td style="text-align:right;"><strong>GRAND TOTAL:</strong></td>

<td style="text-align:right;"><strong><?= number_format($grand_total_purchase_qty, 3); ?></strong></td>

<td style="text-align:right;">&nbsp;</td>

<td style="text-align:right;"><strong><?= number_format($grand_total_purchase_amt, 2); ?></strong></td>


		</tr>

		

		</tbody>

		</table>

		<?

}



elseif($_POST['report']==221023003)

{

		$report="Challan Wise Purchase Report";		

		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}

		

		?>

		

		
<table style="width:100%;">
    <thead>
        <tr>
            <th>SL</th>
            <th>PO No</th>
            <th>Challan No</th>
            <th>Supplier Name</th>
            <th>Quantity</th>
            <th>AVG Price</th>
            <th>Amount</th>
        </tr>
    </thead>

	   	<tr>

<td style="width:25%; border:0; border-color:white; text-align:center;">


		</td>

<td style="width:50%; border:0; border-color:white;">


		<table style="width:100%;">
    <thead>
        <tr>
            <th>SL</th>
            <th>PO No</th>
            <th>Challan No</th>
            <th>Supplier Name</th>
            <th>Quantity</th>
            <th>AVG Price</th>
            <th>Amount</th>
        </tr>
    </thead>
				<tr align="center" >

					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	

				</tr>

<tr style="text-align:center;">
    <td style="font-size:14px; border:0; border-color:white;"><strong><?= $report; ?></strong></td>  
</tr>


				

		 <? if ($_POST['vendor_id']>0) {?>

        <tr>

 <td colspan="15" style="font-size:14px; border:0; border-color:white; text-align:center;">
    <strong>Supplier Name: <?= find_a_field('vendor', 'concat(vendor_id," - ",vendor_name)', 'vendor_id=' . $_POST['vendor_id']) ?></strong>
</td>


         </tr>

		 <? }?>

		 

		  <? if ($_POST['vendor_area']>0) {?>

        <tr>

<td colspan="15" style="font-size:14px; border:0; border-color:white; text-align:center;"><strong>Supplier Area:

		   <?=find_a_field('vendor_category','category_name','id='.$_POST['vendor_area'])?></strong></td>

         </tr>

		 <? }?>

		 

		 <tr>

<td colspan="15" style="font-size:14px; border:0; border-color:white; font-weight:700; text-align:center;">


		  For the date of: <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>

         </tr>

	
			</table>

		

		</td>

		
<td style="border:0; border-color:white; width:25%; text-align:center;">



		</td>

		</tr>

		

		<tr>

			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>

		</tr>


       </table>

		

		
<table id="ExportTable" border="0" style="width:100%; border-spacing:0; padding:2px;">

		

		<thead>

<tr style="text-transform: uppercase;">
    <th style="background-color:#d6eaf8;">SL</th>
    <th style="background-color:#d6eaf8;">PO No</th>
    <th style="background-color:#d6eaf8; text-align:center;">Challan No</th>
    <th style="background-color:#d6eaf8; text-align:center;">Supplier Name</th>
    <th style="background-color:#d6eaf8; text-align:center;">Quantity</th>
    <th style="background-color:#d6eaf8; text-align:center;">AVG Price</th>
    <th style="background-color:#d6eaf8; text-align:center;">Amount</th>
</tr>

		</tr>

		</thead><tbody>

		<? $sl=1;



		?>

		<?

		$_POST['f_date']=$_POST['t_date'];

		

		if($_POST['f_date']!=''&&$_POST['t_date']!=''){



		$date_con .= ' and m.po_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';}

		

		

		if($_POST['vendor_area']!=''){

		$vendor_area_con .= ' and m.vendor_area = "'.$_POST['vendor_area'].'" ';}

		

		if($_POST['vendor_id']!=''){

		$vendor_con .= ' and m.vendor_id = "'.$_POST['vendor_id'].'" ';}



		

		  $sql="select  m.po_no, m.invoice_no, m.vendor_id, v.vendor_name,  sum(p.qty) as purchase_qty, sum(p.amount) as purchase_amt

		 from vendor v, purchase_master m, purchase_invoice p,  item_info i, item_sub_group s

		 where v.vendor_id=m.vendor_id and  m.po_no=p.po_no and p.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.sub_group_id=100010000 and m.status='CHECKED' ".$vendor_area_con.$vendor_con.$date_con." group by m.vendor_id order by m.invoice_no desc";

		

		$res	 = db_query($sql);

		while($row=mysqli_fetch_object($res))

		{



		

		?>

		

		<tr <?=($xx%2==0)?' bgcolor="#F8F8FF"':'';$xx++;?>>

		<td><?=$sl++;?></td>

		<td><?=$row->po_no;?></td>

		<td>

		 <?=$row->invoice_no;?>		  </td>

		<td><?=$row->vendor_id;?> - <?=$row->vendor_name;?></td>

		<td align="right"><?=number_format($row->purchase_qty,3); $total_purchase_qty +=$row->purchase_qty;?></td>

		<td align="right"><?=number_format($unit_proce = ($row->purchase_amt/$row->purchase_qty),3);?></td>

		<td align="right"><?=number_format($row->purchase_amt,2); $total_purchase_amt +=$row->purchase_amt;?></td>

		</tr>

<?  } ?>

		

		  <tr >

		<td>&nbsp;</td>

		<td>&nbsp;</td>

		<td>&nbsp; </td>

<td style="text-align: right;"><strong>TOTAL:</strong></td>

<td style="text-align: right;"><strong><?=number_format($total_purchase_qty, 3); ?></strong></td>

<td style="text-align: right;">&nbsp;</td>

<td style="text-align: right;"><strong><?=number_format($total_purchase_amt, 2); ?></strong></td>




		</tr>

	
		

		</tbody>

		</table>

		<?

}
?></div>

</body>

</html>

<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>