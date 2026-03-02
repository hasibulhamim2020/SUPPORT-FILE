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

	

	if($_POST['by']>0) 			$by=$_POST['by'];

	if($_POST['vendor_id']>0) 	$vendor_id=$_POST['vendor_id'];

	if($_POST['cat_id']>0) 		$cat_id=$_POST['cat_id'];

	if($_POST['item_id']>0) 	$item_id=$_POST['item_id'];

	if($_POST['sub_group_id']>0)$sub_group_id=$_POST['sub_group_id'];

	if($_POST['status']!='') 	$status=$_POST['status'];



switch ($_POST['report']) {

    case 1:

		$report="Purchase Order Report";

		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}

		

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		   $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as entry_by, a.entry_at,a.po_no as po_no,b.id as order_id,d.sub_group_name,e.item_name,b.qty,b.rate,b.amount 

		   

		   from purchase_master a, purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f 

		   where a.po_no=b.po_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and f.user_id=a.entry_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.' order by a.po_no,b.id';

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



		

  $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,

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

	if($_REQUEST['po_no']>0)

header("Location:work_order_print.php?po_no=".$_REQUEST['po_no']);

	break;

	case 55:

		$report="Purchase History Report";

		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 

		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 

		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 

		if(isset($vendor_id)) 	{$vendor_con=' and v.vendor_id='.$vendor_id;} 

		$status_con=' and a.tr_from = "Purchase" ';

		

		if(isset($t_date)) 

		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

	 echo $sql='select ji_date as GR_Date,a.sr_no as GR_no,pm.po_date,pm.po_no,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `RQ`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,v.vendor_name,a.entry_at,c.fname as User 

		   

		   from journal_item a, item_info i, user_activity_management c , item_sub_group s , purchase_receive pr,purchase_master pm,vendor v

		   where pm.vendor_id=v.vendor_id and c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id and a.warehouse_id="5" and a.tr_no=pr.id and pr.po_no=pm.po_no '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.' order by a.id';

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

		if(isset($to_date)) 

		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';

		$str 	.= '</div>';

		if(isset($_SESSION['company_logo'])) 

		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';

		$str 	.= '<div class="left">';

		if(isset($project_name)) 

		$str 	.= '<p>Project Name: '.$project_name.'</p>';

		if(isset($allotment_no)) 

		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';

		$str 	.= '</div><div class="right">';

		if(isset($client_name)) 

		$str 	.= '<p>Client Name: '.$client_name.'</p>';

		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

if($_POST['report']==6)

{

$report="Purchase Receive Report";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0">

		

		<thead>

		<tr><td colspan="19" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

<tbody>



	<tr>

		<th>Po No</th>

		<th>Po Date</th>

		<th>Vendor Name</th>

		<th>Item Name </th>

		<th>Rate</th>

		<th>OQ</th>

		<th>RQ</th>

		<th>DQ</th>

	    <th>Amt</th>

	</tr>

<? 





if($_POST['f_date']!=''&&$_POST['t_date']!='')

$con .= 'and a.po_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

if($_POST['vendor_id']>0)

$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';



$res='select  a.po_no, a.po_date, v.vendor_name,u.fname as entry_by

from 

purchase_master a,warehouse b, vendor v,user_activity_management u where u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id and  a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' order by a.po_no desc';



$query = db_query($res);

while($data=mysqli_fetch_object($query))

{



?>



	<tr>

      <td valign="top"><?=$data->po_no;?></td>

	  <td valign="top"><?=$data->po_date;?></td>

	  <td valign="top"><?=$data->vendor_name;?></td>

	  <td colspan="6">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px; border:0;">

<? 

$sql = 'select a.*,b.item_name from purchase_invoice a,item_info b where a.item_id=b.item_id and a.po_no="'.$data->po_no.'"';

$sqlq = db_query($sql);

while($info=mysqli_fetch_object($sqlq)){

?>

	<tr>

	  <td width="32%"><?=$info->item_name.'('.$info->unit_name.')';?></td>

	  <td width="17%"><?=number_format($info->rate,2)?></td>

	  <td width="12%"><?=number_format($info->qty,0)?></td>

	  <td width="12%"><? $rq = find_a_field('purchase_receive','sum(qty)','order_no="'.$info->id.'"'); echo number_format($rq,0);?></td>

	  <td width="12%"><? $dq = $info->qty - $rq; if($dq>0) echo number_format($dq,0); $tot = $rq*$info->rate; $total = $total + $tot;?></td>

	  <td width="15%"><?=number_format(($tot),2);?></td>

	</tr>

<? }?>

</table>	  </td>

	</tr>

<? }?>

	<tr>

	  <td colspan="8" valign="top"><div align="right"><strong>Total:</strong></div></td>

	  <td><div align="right">

	    <?=number_format(($total),2);?></div></td>

	</tr>

</tbody></table>

<?

}


elseif($_POST['report']==304)



{



$report="Sales Requisition Report";



?>



	<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">



		



		<thead>



		<tr><td colspan="24" style="border:0px;">



		<?



		echo $str;



		?>



		</td></tr>

<tbody>







	<tr>



		<th><div align="left">S/L</div></th>



		<th><div align="left">MR No</div></th>

		<th><div align="left">MR Date</div></th>

		<th><div align="left">Warehouse Name</div></th>

		<th><div align="left">Sub Group Name</div></th>

		<th><div align="left">Item Name</div></th>

		<th><div align="left">Total Quantity</div></th>

		<th><div align="left">Entry By </div></th>

		<th><div align="left">Entry At</div></th>

		

	</tr>



    <div align="left">

      <? 











if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= ' and a.req_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['warehouse_id']>0)



$con .= ' and a.warehouse_id="'.$_POST['warehouse_id'].'"';



if(isset($item_id)) 	{$item_con=' and i.item_id='.$item_id;}

if(isset($sub_group_id)){$sub_group_con=' and i.sub_group_id='.$sub_group_id;}



if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}



if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}







  $res='select a.req_no as req_no, a.req_date, a.entry_by, a.entry_at, b.qty as qty, i.item_name as item_name,a.warehouse_id,b.item_id,i.sub_group_id,g.sub_group_name,g.sub_group_id from requisition_master_vision a, requisition_order_vision b, item_info i,item_sub_group g where a.req_no=b.req_no and i.item_id=b.item_id and i.sub_group_id=g.sub_group_id '.$con.$item_con.$sub_group_con.' order by a.req_no';







$query = db_query($res);



while($data=mysqli_fetch_object($query))



{





$j++;





?>

      

      

      



    <tr>



      <td valign="top"><?=$j?></td>



	  <td valign="top"><div align="left">

	    <?=$data->req_no;?>

      </div></td>

	  

	  

	  <td valign="top"><div align="left">

	    <?=date("d-m-Y",strtotime($data->req_date));?>

      </div></td>

	   <td valign="top"><div align="left"><?php  echo find_a_field('warehouse','warehouse_name','warehouse_id='.$data->warehouse_id);?></div></td>

	  	   <td valign="top"><div align="left"> <?php 

	    

	  echo $data->sub_group_name;?></div></td>

	  	  <td valign="top"><div align="left"><?=$data->item_name;?></div></td>

	

	 <td><div align="left"><?=$data->qty;?></div></td>

	  

	  

	  

	  <td valign="top"><div align="left">

	   <?= find_a_field('user_activity_management','username','user_id='.$data->entry_by); ?>

      </div></td>

	  <td valign="top"><div align="left">

	    <?=$data->entry_at;?>

      </div></td>

	  

	  <?php /*?><td valign="top"><div align="left">

	    <?=$data->lot_no;?>

      </div></td>



	  <td valign="top"><div align="left">

	    <?=$data->garden_name;?>

      </div></td>

	  <td valign="top"><div align="left">

	    <?=$data->inv_no;?>

      </div></td>

	  <td><div align="left">

	    <?=$data->item_grade;?>

      </div></td>

	  <td><div align="left">

	    <?=$data->mark;?>

      </div></td>

	  <td><div align="left">

	    <?=$data->pkgs; $tot_pkgs+=$data->pkgs;?>

      </div></td>

	  <td><div align="left">

	    <?=number_format(($data->qty-$data->pending_kgs),3); $tot_pending_kg+=($data->qty-$data->pending_kgs);?>

      </div></td>

	  <td><div align="left">

	    <?=$data->rate;?>

      </div></td>

	  <td><div align="left">

	    <?=$data->amount; $tot_amount+=$data->amount;?>

      </div></td><?php */?>

	</tr>



          <? 

		  

		  $total=$total+$data->qty;

		  }?>

      

    </div>

    <tr>



	 

	  <td valign="top" style="border:none; font-weight:bold; text-align:right;" colspan="6">Total Quantity</td>

	  <td valign="top" style="border:none; font-weight:bold;"><?php echo $total; ?></td>

	  <td valign="top" style="border:none;">&nbsp;</td>

	  <td valign="top" style="border:none;">&nbsp;</td>

	  </tr>

	  

	 <?php /*?> <tr>

	  <td valign="top"><div align="left"><strong>Total:</strong></div></td>

	  <td valign="top">&nbsp;</td>

	  <td valign="top">&nbsp;</td>

	  <td valign="top">&nbsp;</td>

	  <td valign="top"><div align="left"><span class="style2">

	    <?=number_format(($tot_pkgs),2);?>

      </span></div></td>

	  <td valign="top"><div align="left"><span class="style1">

	    <?=number_format(($tot_pending_kg),3);?>

      </span></div></td>

	  <td valign="top">&nbsp;</td>

	  <td>



	    <div align="left"><span class="style3">

	      <?=number_format(($tot_amount),2);?>

        </span></div></td>

	</tr><?php */?>

</tbody></table>



<?



}


elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);

?>

<?php 

if($_POST['report']==5){



?>

<div style="text-align:center;">

<h2 style="font-weight:bold;">Material Requisition Report</h2>

<p style="text-align:center;font-weight:bold;">Date From <?=$f_date?>  to <?=$t_date?></p>

</div>

<table width="100%" border="0" cellpadding="2" cellspacing="0">

	<thead>

		<tr>

			<th>SL</th>

			<th>MR No</th>

			<th>MR Date</th>

			<th>Total Qty</th>

			<th>Entry By</th>

			<th>Entry At</th>

		</tr>

	</thead>

	

	<tbody>

	<?php

	 $sql2="select * from requisition_master where req_date between '".$f_date."' and '".$t_date."' ";

	$query2=db_query($sql2);

	while($row=mysqli_fetch_object($query2)){

	 ?>

		<tr>

			<td><?=++$i?></td>

			<td><?=$row->req_no?></td>

			<td><?=$row->req_date?></td>

			<td><?php echo $qty=find_a_field('requisition_order','sum(qty)','req_no='.$row->req_no);?></td>

			<td><?=find_a_field('user_activity_management','fname','user_id='.$row->entry_by);?></td>

			<td><?=$row->entry_at?></td>

		</tr>

		<?php 

		

		$tot_qty+=$qty;

		} ?>

		

		<tr style="font-weight:bold;">

		<td colspan="3" style="text-align:right;">Total</td>

		<td><?=$tot_qty?></td>

		<td></td>

		<td></td>

		</tr>

	</tbody>

</table>

<?php } ?>



</div>

</body>

</html>