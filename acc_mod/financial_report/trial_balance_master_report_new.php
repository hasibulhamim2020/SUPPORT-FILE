<?

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



date_default_timezone_set('Asia/Dhaka');


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title><?=$report?></title>

<link href="../../../assets/css/report.css" type="text/css" rel="stylesheet" />

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

table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}

table  {
font-size:14px;

}


-->

    </style>

</head>

<body >

<?
require_once "../../../excel/inc.exporttable.php";
?>


<div align="center" id="pr">

<input type="hidden" value="Print" onclick="hide();window.print();"/>

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

}

elseif($_POST['report']==230910001)
{
		$report="TRIAL BALANCE REPORT";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$f_date=$_POST['f_date'];
		$t_date=$_POST['t_date'];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $_POST['f_date'];		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));

$from_date = strtotime($f_dt);
$to_date = strtotime($t_dt);
$datediff = $to_date - $from_date;
echo $count_days = round($datediff / (60 * 60 * 24));

		   ?> Days)
		   </td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" id="ExportTable" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="4%" bgcolor="#99CCFF">SL</th>
		<th width="42%" bgcolor="#99CCFF">LEDGER NAME </th>
		<th width="17%" bgcolor="#99CCFF" style="text-align:center">OPENING</th>
		<th width="11%" bgcolor="#99CCFF" style="text-align:center">DEBIT</th>
		<th width="12%" bgcolor="#99CCFF" style="text-align:center">CREDIT</th>
		<th width="14%" bgcolor="#99CCFF" style="text-align:center">BALANCE</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		

		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}




		
		
 		$sql = "select ledger_id, sum(dr_amt-cr_amt) as opening_amt from journal where jv_date <'".$f_date."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $opening_amt[$info->ledger_id]=$info->opening_amt;
		}
		
		
		
		$sql = "select ledger_id, sum(dr_amt) as dr_amt from journal where jv_date between '".$f_date."' and '".$t_date."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $dr_amt[$info->ledger_id]=$info->dr_amt;
		}
		
		$sql = "select ledger_id, sum(cr_amt) as cr_amt from journal where jv_date between '".$f_date."' and '".$t_date."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cr_amt[$info->ledger_id]=$info->cr_amt;
		}
		
		
		$sql = "select ledger_id, sum(dr_amt-cr_amt) as closing_amt from journal where jv_date <='".$t_date."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $closing_amt[$info->ledger_id]=$info->closing_amt;
		}

		

		
		  $sql_sub="select g.group_id, g.group_name from ledger_group g, accounts_ledger a where g.group_id=a.ledger_group_id and g.acc_class in (1,2) group by a.ledger_group_id order by g.group_id";
		  $data_sub=db_query($sql_sub);

		  while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
			
		<tr style=" font-size:14px;">
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->group_name; ?></strong></div></td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  </tr>
		
	
		<?

		
 	 $sql="select distinct ledger_id, ledger_name from accounts_ledger where ledger_group_id='".$info_sub->group_id."'  order by ledger_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
			
		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#f4f6f6"':'';$xx++;?> style="font-size:14px;">
		<td><?=$sl++;?></td>
		<td><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['f_date']?>&tdate=<?=$_REQUEST['t_date']?>&ledger_id=<?=$row->ledger_id?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:14px;">
		<?=$row->ledger_name?></a></td>
		<td><div align="right">
		<?php $opening_balance=$opening_amt[$row->ledger_id];  $sub_total_opening_amt +=$opening_amt[$row->ledger_id];
		if($opening_balance>0) echo number_format($opening_balance,2).' (Dr)'; elseif($opening_balance<0) echo number_format(((-1)*$opening_balance),2).' (Cr)';else echo "0.00"; ?>
		
		  </div></td>
		<td><div align="right">
		  <?=number_format($dr_amt[$row->ledger_id],2);  $sub_total_dr_amt +=$dr_amt[$row->ledger_id];?>
		  </div></td>
		<td><div align="right">
		  <?=number_format($cr_amt[$row->ledger_id],2); $sub_total_cr_amt +=$cr_amt[$row->ledger_id]; ?>
		  </div></td>
		<td><div align="right">
		 <?php $closing_balance=$closing_amt[$row->ledger_id]; $sub_total_closing_amt +=$closing_amt[$row->ledger_id]; 
		if($closing_balance>0) echo number_format($closing_balance,2).' (Dr)'; elseif($closing_balance<0) echo number_format(((-1)*$closing_balance),2).' (Cr)';else echo "0.00"; ?>
		  </div></td>
		</tr>
<? } ?>
		<tr  style="font-size:14px;">
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>SUB TOTAL:</strong></div></td>
		  <td><div align="right"><span class="style7">
		    <? number_format($sub_total_opening_balance=$sub_total_opening_amt,2); $total_sub_total_opening_amt +=$sub_total_opening_balance; 
			if($sub_total_opening_balance>0) echo number_format($sub_total_opening_balance,2).' (Dr)'; elseif($sub_total_opening_balance<0) echo number_format(((-1)*$sub_total_opening_balance),2).' (Cr)';else echo "0.00"; ?>
	      </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($sub_total_dr_amt,2); $total_sub_total_dr_amt +=$sub_total_dr_amt;?>
	      </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($sub_total_cr_amt,2); $total_sub_total_cr_amt +=$sub_total_cr_amt;?>
	      </span></div></td>
		  <td>
		    <div align="right"><span class="style7">
		      <? number_format($sub_total_closing_balance=$sub_total_closing_amt,2); $total_sub_total_closing_amt +=$sub_total_closing_balance;
			if($sub_total_closing_balance>0) echo number_format($sub_total_closing_balance,2).' (Dr)'; elseif($sub_total_closing_balance<0) echo number_format(((-1)*$sub_total_closing_balance),2).' (Cr)';else echo "0.00"; ?>
            </span> </div></td>
		  </tr>
		  
		  <? 
		  $sub_total_opening_amt = 0;
		  $sub_total_dr_amt = 0;
		  $sub_total_cr_amt = 0;
		  $sub_total_closing_amt = 0;
  
		   }?>
		
		
	
		  <?
		  
		  $sql_sub="select g.group_id, g.group_name from ledger_group g, accounts_ledger a where g.group_id=a.ledger_group_id and g.acc_class in (3,4) group by a.ledger_group_id order by g.group_id";
		  $data_sub=db_query($sql_sub);

		  while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
			
		<tr style=" font-size:14px;">
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->group_name; ?></strong></div></td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  </tr>
		
	
		<?

		
 	 $sql="select distinct ledger_id, ledger_name from accounts_ledger where ledger_group_id='".$info_sub->group_id."'  order by ledger_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
			
		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#f4f6f6"':'';$xx++;?> style="font-size:14px;">
		<td><?=$sl++;?></td>
		<td><a href="transaction_listledger_exp.php?show=show&fdate=<?=$_REQUEST['f_date']?>&tdate=<?=$_REQUEST['t_date']?>&ledger_id=<?=$row->ledger_id?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:14px;">
		<?=$row->ledger_name?></a></td>
		<td><div align="right">
	
		  </div></td>
		<td><div align="right">
		  <?=number_format($dr_amt[$row->ledger_id],2);  $sub_total_exp_dr_amt +=$dr_amt[$row->ledger_id];?>
		  </div></td>
		<td><div align="right">
		  <?=number_format($cr_amt[$row->ledger_id],2); $sub_total_exp_cr_amt +=$cr_amt[$row->ledger_id]; ?>
		  </div></td>
		<td><div align="right">&nbsp;</div></td>
		</tr>
<? } ?>
		<tr  style="font-size:14px;">
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>SUB TOTAL:</strong></div></td>
		  <td><div align="right"><span class="style7">&nbsp;</span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($sub_total_exp_dr_amt,2); $total_sub_total_exp_dr_amt +=$sub_total_exp_dr_amt;?>
	      </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($sub_total_exp_cr_amt,2); $total_sub_total_exp_cr_amt +=$sub_total_exp_cr_amt;?>
	      </span></div></td>
		  <td>
		    <div align="right">&nbsp; </div></td>
		  </tr>
		  
		  <? 
		 
		  $sub_total_exp_dr_amt = 0;
		  $sub_total_exp_cr_amt = 0;
		  $sub_total_closing_exp_amt = 0;
  
		   }?>
		
		
		<tr  style="font-size:14px;">
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>GRAND TOTAL</strong></div></td>
		  <td><div align="right"><span class="style7">
		  
		    <? number_format($total_sub_total_opening_balance=$total_sub_total_opening_amt,2);
			if ($total_sub_total_opening_balance>0) { echo  number_format($total_sub_total_opening_balance,2). " (DR)";  } else {echo number_format($total_sub_total_opening_balance*(-1),2). " (CR)";  }  
			?>
		  
		   </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($total_sub_total_dr_amt+$total_sub_total_exp_dr_amt,2);?>
	      </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($total_sub_total_cr_amt+$total_sub_total_exp_cr_amt,2);?>
	      </span></div></td>
		  <td>
		    <div align="right"><span class="style7"><? number_format($total_sub_total_closing_balance=$total_sub_total_closing_amt,2);
			if ($total_sub_total_closing_balance>0) { echo  number_format($total_sub_total_closing_balance,2). " (DR)"; } else {echo number_format($total_sub_total_closing_balance*(-1),2). " (CR)"; } 
			?></span> </div></td>
		  </tr>
		
		</tbody>
</table>
<?
}elseif($_POST['report']==230910002)
{
		$report="TRIAL BALANCE REPORT (NET BALANCE)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$f_date=$_POST['f_date'];
		$t_date=$_POST['t_date'];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $_POST['f_date'];		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));

$from_date = strtotime($f_dt);
$to_date = strtotime($t_dt);
$datediff = $to_date - $from_date;
echo $count_days = round($datediff / (60 * 60 * 24));

		   ?> Days)
		   </td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" id="ExportTable" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="3%" rowspan="2" bgcolor="#99CCFF">SL (NET)</th>
		<th width="32%" rowspan="2" bgcolor="#99CCFF">LEDGER NAME </th>
		<th colspan="2" bgcolor="#99CCFF" style="text-align:center">OPENING</th>
		<th width="9%" rowspan="2" bgcolor="#99CCFF" style="text-align:center">DEBIT</th>
		<th width="10%" rowspan="2" bgcolor="#99CCFF" style="text-align:center">CREDIT</th>
		<th colspan="2" bgcolor="#99CCFF" style="text-align:center">CLOSING</th>
		</tr>
		<tr height="30">
		  <th width="10%" bgcolor="#99CCFF" style="text-align:center">DEBIT</th>
		  <th width="11%" bgcolor="#99CCFF" style="text-align:center">CREDIT</th>
		  <th width="12%" bgcolor="#99CCFF" style="text-align:center">DEBIT</th>
		  <th width="13%" bgcolor="#99CCFF" style="text-align:center">CREDIT</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		

		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}




		
		
 		$sql = "select ledger_id, sum(dr_amt-cr_amt) as opening_amt from journal where jv_date <'".$f_date."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $opening_amt[$info->ledger_id]=$info->opening_amt;
		 
		 if($opening_amt[$info->ledger_id]>0) {
		 $opening_amt_dr[$info->ledger_id]=$opening_amt[$info->ledger_id];
		}else{
		 $opening_amt_cr[$info->ledger_id]=$opening_amt[$info->ledger_id];
		}
		}
		
		
		
		$sql = "select ledger_id, sum(dr_amt-cr_amt) as net_amt from journal where jv_date between '".$f_date."' and '".$t_date."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $net_amt[$info->ledger_id]=$info->net_amt;
		 
		 if($net_amt[$info->ledger_id]>0) {
		 $net_amt_dr[$info->ledger_id]=$net_amt[$info->ledger_id];
		}else{
		 $net_amt_cr[$info->ledger_id]=$net_amt[$info->ledger_id];
		}
		}
		
		
		
		
		$sql = "select ledger_id, sum(dr_amt-cr_amt) as closing_amt from journal where jv_date <='".$t_date."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $closing_amt[$info->ledger_id]=$info->closing_amt;
		 
		  if($closing_amt[$info->ledger_id]>0) {
		 $closing_amt_dr[$info->ledger_id]=$closing_amt[$info->ledger_id];
		}else{
		 $closing_amt_cr[$info->ledger_id]=$closing_amt[$info->ledger_id];
		}
		}

		

		
		  $sql_sub="select g.group_id, g.group_name from ledger_group g, accounts_ledger a where g.group_id=a.ledger_group_id and g.acc_class in (1,2) group by a.ledger_group_id order by g.group_id";
		  $data_sub=db_query($sql_sub);

		  while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
			
		<tr style=" font-size:14px;">
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->group_name; ?></strong></div></td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		</tr>
		
	
		<?

		
 	 $sql="select distinct ledger_id, ledger_name from accounts_ledger where ledger_group_id='".$info_sub->group_id."'  order by ledger_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
			
		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#f4f6f6"':'';$xx++;?> style="font-size:14px;">
		<td><?=$sl++;?></td>
		<td><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['f_date']?>&tdate=<?=$_REQUEST['t_date']?>&ledger_id=<?=$row->ledger_id?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:14px;">
		<?=$row->ledger_name?></a></td>
		<td><div align="right">
		<?=number_format($opening_amt_dr[$row->ledger_id],2); $sub_tot_opening_amt_dr+= $opening_amt_dr[$row->ledger_id];?>
		
		  </div></td>
		<td>
		<div align="right">
		<?=number_format($opening_amt_cr[$row->ledger_id],2); $sub_tot_opening_amt_cr+= $opening_amt_cr[$row->ledger_id]?>
		  </div>		</td>
		<td><div align="right">
		 <?=number_format($net_amt_dr[$row->ledger_id],2); $sub_tot_net_amt_dr+= $net_amt_dr[$row->ledger_id];?>
		  </div></td>
		<td><div align="right">
		 <?=number_format($net_amt_cr[$row->ledger_id],2); $sub_tot_net_amt_cr+= $net_amt_cr[$row->ledger_id];?>
		  </div></td>
		<td><div align="right">
		<?=number_format($closing_amt_dr[$row->ledger_id],2); $sub_tot_closing_amt_dr+=$closing_amt_dr[$row->ledger_id]; ?>
		  </div></td>
		<td><div align="right">
		<?=number_format($closing_amt_cr[$row->ledger_id],2); $sub_tot_closing_amt_cr+=$closing_amt_cr[$row->ledger_id]; ?>
		
		  </div></td>
		</tr>
<? } ?>
		<tr  style="font-size:14px;">
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>SUB TOTAL:</strong></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($sub_tot_opening_amt_dr,2); $total_sub_tot_opening_amt_dr +=$sub_tot_opening_amt_dr;?>
	      </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($sub_tot_opening_amt_cr,2); $total_sub_tot_opening_amt_cr+=$sub_tot_opening_amt_cr;?>
	      </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($sub_tot_net_amt_dr,2); $total_sub_tot_net_amt_dr+=$sub_tot_net_amt_dr;?>
	      </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($sub_tot_net_amt_cr,2); $total_sub_tot_net_amt_cr+=$sub_tot_net_amt_cr;?>
	      </span></div></td>
		  <td>
		    <div align="right"><span class="style7">
		    <?=number_format($sub_tot_closing_amt_dr,2); $total_sub_tot_closing_amt_dr+=$sub_tot_closing_amt_dr;?>
	      </span></div></td>
		  <td>
		  <div align="right"><span class="style7">
		    <?=number_format($sub_tot_closing_amt_cr,2); $total_sub_tot_closing_amt_cr+=$sub_tot_closing_amt_cr;?>
	      </span></div></td>
		</tr>
		  
		  <? 
		  $sub_tot_opening_amt_dr = 0;
		  $sub_tot_opening_amt_cr = 0;
		  $sub_tot_net_amt_dr = 0;
		  $sub_tot_net_amt_cr = 0;
		  $sub_tot_closing_amt_dr = 0;
		  $sub_tot_closing_amt_cr = 0;
  
		   }?>
		
		
	
		  <?
		  
		  $sql_sub="select g.group_id, g.group_name from ledger_group g, accounts_ledger a where g.group_id=a.ledger_group_id and g.acc_class in (3,4) group by a.ledger_group_id order by g.group_id";
		  $data_sub=db_query($sql_sub);

		  while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
			
		<tr style=" font-size:14px;">
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->group_name; ?></strong></div></td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		  <td bgcolor="#d6eaf8">&nbsp;</td>
		</tr>
		
	
		<?

		
 	 $sql="select distinct ledger_id, ledger_name from accounts_ledger where ledger_group_id='".$info_sub->group_id."'  order by ledger_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
			
		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#f4f6f6"':'';$xx++;?> style="font-size:14px;">
		<td><?=$sl++;?></td>
		<td><a href="transaction_listledger_exp.php?show=show&fdate=<?=$_REQUEST['f_date']?>&tdate=<?=$_REQUEST['t_date']?>&ledger_id=<?=$row->ledger_id?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:14px;">
		<?=$row->ledger_name?></a></td>
		<td><div align="right">
	
		  </div></td>
		<td>&nbsp;</td>
		<td><div align="right">
            <?=number_format($net_amt_dr[$row->ledger_id],2); $sub_tot_exp_net_amt_dr+= $net_amt_dr[$row->ledger_id];?>
        </div></td>
		<td><div align="right">
            <?=number_format($net_amt_cr[$row->ledger_id],2); $sub_tot_exp_net_amt_cr+= $net_amt_cr[$row->ledger_id];?>
        </div></td>
		<td><div align="right">&nbsp;</div></td>
		<td>&nbsp;</td>
		</tr>
<? } ?>
		<tr  style="font-size:14px;">
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>SUB TOTAL:</strong></div></td>
		  <td><div align="right"><span class="style7">&nbsp;</span></div></td>
		  <td>&nbsp;</td>
		  <td><div align="right"><span class="style7">
              <?=number_format($sub_tot_exp_net_amt_dr,2); $total_sub_tot_exp_net_amt_dr+=$sub_tot_exp_net_amt_dr; ?>
          </span></div></td>
		  <td><div align="right"><span class="style7">
              <?=number_format($sub_tot_exp_net_amt_cr,2); $total_sub_tot_exp_net_amt_cr+=$sub_tot_exp_net_amt_cr; ?>
          </span></div></td>
		  <td>
		    <div align="right">&nbsp; </div></td>
		  <td>&nbsp;</td>
		</tr>
		  
		  <? 
		 
		  $sub_tot_exp_net_amt_dr = 0;
		  $sub_tot_exp_net_amt_cr = 0;
		 
  
		   }?>
		
		
		<tr  style="font-size:14px;">
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>GRAND TOTAL</strong></div></td>
		  <td><div align="right"><span class="style7">
		  
		    <?=number_format($total_sub_tot_opening_amt_dr,2);?>
		  
		   </span></div></td>
		  <td><div align="right"><span class="style7">
            <?=number_format($total_sub_tot_opening_amt_cr,2);?>
          </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($total_sub_tot_net_amt_dr+$total_sub_tot_exp_net_amt_dr,2);?>
	      </span></div></td>
		  <td><div align="right"><span class="style7">
		    <?=number_format($total_sub_tot_net_amt_cr+$total_sub_tot_exp_net_amt_cr,2);?>
	      </span></div></td>
		  <td>
		    <div align="right"><span class="style7"> <?=number_format($total_sub_tot_closing_amt_dr,2);?></span> </div></td>
		  <td><div align="right"><span class="style7"> <?=number_format($total_sub_tot_closing_amt_cr,2);?></span> </div></td>
		</tr>
		
		</tbody>
</table>
<?
}elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}

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
<?php /*?><tr>
<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Sr Executive (S & D)</u></strong></td>

<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Asst. Manager (S &amp; D) </u></strong></td>

<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Manager (S & D)</u></strong></td>

<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Sr Manager (S & D) / AGM (M &amp; S)</u></strong></td>
</tr><?php */?>
<tr>
  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>
</tr>
</table>

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