<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


date_default_timezone_set('Asia/Dhaka');

$tr_type="Show";

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
include  "../../../controllers/core/inc.exporttable.php";
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


if($_REQUEST['report']=='NC1001') 

{

		$report="Profit & Loss";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $fdate=$fiscal_info->start_date;
        $tdate=$fiscal_info->end_date;
		if($_POST['group_for_actual']>0){
		$group_name = find_a_field('user_group','group_name','id="'.$_POST['group_for_actual'].'"');
		}
		
		?>
		
		<table width="100%" border="0">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$group_name;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Fiscal Year : <?=$fiscal_info->fiscal_year;?></strong></td>	
				</tr>
 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Date: <?php echo date('d-m-Y',strtotime($fdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($tdate));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $fdate;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($tdate)));

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

										<tr>

											<th width="70%" bgcolor="#82D8CF">&nbsp; Particular</th>

											<th width="30%" bgcolor="#82D8CF">&nbsp; Amount</th>
										</tr>
										</thead>

										

										
										
<?

 $sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as sales_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt[$data->acc_sub_sub_class]=$data->sales_amt;
}

$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as expenses_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expenses_amt[$data->acc_sub_sub_class]=$data->expenses_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_opening 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_opening=$data->rm_opening;
}

$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and l.acc_sub_sub_class in (411,412)";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt=$data->expense_amt;
}

$material_cost=($rm_opening+$purchase_amt)-$rm_closing;
$total_cogs_amt=$material_cost+$expense_amt;



$sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=3 and s.id=31
group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub1->id."' and ss.id not in (315,314)  order by ss.id";


$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank">
<?=number_format($sales_amt[$data1->id],2); $tot_sales_amt +=$sales_amt[$data1->id];?></a></td>
									  </tr>
									  
									  
									  
<? }?>	


<tr>
										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cost of Goods Sold
										  
									
										  
										  
										  </td>

										  <td align="right">
										  
		 <a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=411&&report=CD1001" target="_blank"><?
		 $total_cogs_amt=$sales_amt['411']*(-1);
		 echo '-'.number_format($total_cogs_amt,2);
		 
		 ?>	</a></td>
									  </tr>
 						


							  
		<? }?>
		
		
									<tr>

										  <td align="center"><strong>Gross Profit</strong></td>

										  <td align="right"><strong>
									      <?=number_format($gross_profit_amt=$tot_sales_amt-$total_cogs_amt,2);?>
										  </strong></td>
									  </tr>
										

										
										
								
										
<?
	   
   $sql_sub2="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=4 and s.id!=41
group by s.id";
$query_sub2=db_query($sql_sub2);

while($info_sub2=mysqli_fetch_object($query_sub2)){ 
	   
	   
	   ?>

										<tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub2->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									      
									  </tr>
									  
									  

<?php


 $sql2="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub2->id."'  order by ss.id";

$query2=db_query($sql2);

while($data2=mysqli_fetch_object($query2)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data2->sub_sub_class_name;?></td>

										  <td align="right">
										  
		 <a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data2->id?>&&report=CD1001" target="_blank">
		 <?=number_format($expenses_amt[$data2->id],2); $tot_expenses_amt +=$expenses_amt[$data2->id];?></a></td>
									      
									  </tr>
									  
									  
									  
<? }?>	

 						


							  
		<? }?>
		

		
									<tr>

										  <td align="center"><strong> Total Operating Expenses</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_expenses_amt,2);?>
										  </strong></td>
									      
									</tr>
									
									
									<tr>

										  <td align="center"><strong> Profit from Operation</strong></td>

										  <td align="right"><strong>
									      <?=number_format($profit_from_operation=($gross_profit_amt-$tot_expenses_amt),2);?>
										  </strong></td>
									      
									</tr>
										

										
							<tr>

										  <td align="center"><strong>Profit Before Other Income</strong></td>

										  <td align="right"><strong>
									      <?=number_format($profit_before_tax=($profit_from_operation+$tot_finance_income)-$tot_finance_exp,2);?>
										  </strong></td>
									      
							</tr>
							
							
							
							
<?php


$sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where  ss.acc_sub_class=31 and ss.id in (315) order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank">
<?=number_format($sales_amt[$data1->id],2); $tot_other_income +=$sales_amt[$data1->id];?></a></td>
									  
									  </tr>
									  
									  
									  
<? }?>	



								<tr>

										  <td align="center"><strong>Net Profit/(Loss) Before Tax</strong></td>

										  <td align="right"><strong>
									      <?=number_format($net_profit_before_tax=($profit_before_tax+$tot_other_income),2);?>
										  </strong></td>
									     
							</tr>

									  
									  
									  <tr>


										  <td align="left">&nbsp; <strong>lncome Tax Expenses</strong></td>

										  <td align="right">&nbsp;</td>
									      
									  </tr>
									  
									  <tr>

										  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Current Tax Expenses/ (Income)</td>

										  <td align="right">0.00</td>
									      
									  </tr>
									  
									  <tr>

										  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deferred Tax Expenses/ (Income), Net</td>

										  <td align="right">0.00</td>
									      
									  </tr>
									
									
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  
									</tr>
									<tr>
									  <td align="center"><strong>Net Profit After Tax</strong></td>
									  <td align="right"><strong>
									  <?=number_format($net_profit_loss = ($net_profit_before_tax-$income_tax_exp),2);?> </strong></td>
									  
									</tr>
									
									<tr>

										  <td align="center"><strong>Other Comprehensive Income/(Loss)</strong></td>

										  <td align="right"><strong>
									      <?=number_format($other_comprehensive_income_loss=0,2);?>
										  </strong></td>
									     
									  </tr>
									
									
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									 
									</tr>
									
									<tr>
									  <td align="center"><strong>Total Comprehensive Income/(Loss)</strong></td>
									  <td align="right"><strong>
									  <?=number_format($total_comprehensive_income_loss = ($net_profit_loss+$other_comprehensive_income_loss),2);?> </strong></td>
									  
									</tr>
									
									</table>

<?

}

elseif($_REQUEST['report']=='NC1002') 

{

		$report="Financial Statement";		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $fdate=$fiscal_info->start_date;
        $tdate=$fiscal_info->end_date;
		if($_POST['group_for_actual']>0){
		$group_name = find_a_field('user_group','group_name','id="'.$_POST['group_for_actual'].'"');
		}
		
		?>
		
		<table width="100%" border="0">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$group_name;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Fiscal Year : <?=$fiscal_info->fiscal_year;?></strong></td>	
				</tr>
 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Date: <?php echo date('d-m-Y',strtotime($fdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($tdate));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $fdate;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($tdate)));

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

										<tr>

											<th width="70%" bgcolor="#82D8CF">&nbsp; Particular</th>

											<th width="30%" bgcolor="#82D8CF" align="center"><div align="center">Amount</div></th>
										</tr>
										</thead>

		<tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>ASSETS</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				  </tr>								

										
										
<?

 $sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as asset_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$asset_amt[$data->acc_sub_sub_class]=$data->asset_amt;

}


$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as liability_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$liability_amt[$data->acc_sub_sub_class]=$data->liability_amt;

}



	   
 $sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=1
group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub1->id."'  order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><a href="financial_transaction_group_closing.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data1->id?>" target="_blank">
<?=number_format($asset_amt[$data1->id],2); $tot_asset_amt +=$asset_amt[$data1->id];?></a></td>
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_asset_amt,2); $net_tot_asset_amt +=$tot_asset_amt;?>
										  </strong></td>
									  </tr>


							  
		<? 
		$tot_asset_amt=0;
		}?>
		
		
									<tr>

										  <td align="center"><strong>Total Assets:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($net_tot_asset_amt,2);?>
										  </strong></td>
									  </tr>
									  
									  <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
										

			<tr>
										  <td bgcolor="#D8BFD8">&nbsp;<strong>EQUITY & LIABILITIES</strong></td>
										  <td bgcolor="#D8BFD8">&nbsp;</td>
				  </tr>	
				  
				  							
										
								
										
<?






$sql = "select a.ledger_group_id, sum(j.cr_amt-j.dr_amt) as sales_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and l.acc_class=3";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt=$data->sales_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and l.acc_class=4";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt=$data->expense_amt;
}

$material_cost=$purchase_amt-$rm_closing;

$total_cogs_amt=$material_cost+$expense_amt;
if($fdate<='2023-10-31'){
   $ret_opening=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=1590 and tr_from="Opening"');
}
else{
    
   $ret_opening=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=1590 and jv_date<"'.$fdate.'"'); 
}
$net_retained_earnings=($sales_amt-$total_cogs_amt)-$ret_opening;







	   
    $sql_sub2="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=2 and s.id=21   
group by s.id";
$query_sub2=db_query($sql_sub2);

while($info_sub2=mysqli_fetch_object($query_sub2)){ 
	   
	   
	   ?>

									
										<tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub2->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									  </tr>
									  
									  

<?php


  $sql2="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub2->id."' and ss.id!=215   order by ss.id";

$query2=db_query($sql2);

while($data2=mysqli_fetch_object($query2)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data2->sub_sub_class_name;?></td>

										  <td align="right">
										  
		 <a href="financial_transaction_group_closing.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data2->id?>" target="_blank">
		 <?=number_format($liability_amt[$data2->id],2); $equity_amt +=$liability_amt[$data2->id];?></a></td>
									  </tr>
									  
									  
									  
									  
									  
									  
<? }?>	<tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retained Earnings</td>

										  <td align="right">
										  
		 <a href="financial_changes_equity.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>" target="_blank"><?=number_format($net_retained_earnings,2);?>	</a></td>
									  </tr>

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_equity_amt=$equity_amt+$net_retained_earnings,2);?>
										  </strong></td>
 						</tr>


							  
		<? }?>
		
		
		<?
	   
  $sql_sub3="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=2 and s.id!=21
group by s.id";
$query_sub3=db_query($sql_sub3);

while($info_sub3=mysqli_fetch_object($query_sub3)){ 
	   
	   
	   ?>

									
										<tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub3->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql3="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub3->id."'  order by ss.id";

$query3=db_query($sql3);

while($data3=mysqli_fetch_object($query3)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data3->sub_sub_class_name;?></td>

										  <td align="right">
										  
		 <a href="financial_transaction_group_closing.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data3->id?>" target="_blank">
		 <?=number_format($liability_amt[$data3->id],2); $tot_liability_amt +=$liability_amt[$data3->id];?></a></td>
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_liability_amt,2); $net_tot_liability_amt +=$tot_liability_amt;?>
										  </strong></td>
 						</tr>
<? 
		$tot_liability_amt=0;
		}?>
		
									<tr>

										  <td align="center"><strong> Total Equity & Liabilities:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_equity_liabilities=$tot_equity_amt+$net_tot_liability_amt,2);?>
										  </strong></td>
									</tr>
		
		
									
									
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									
									
									</table>

<?

}

elseif($_REQUEST['report']=='NC1003') 

{

		$report="Cash Flows Statement";		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $fdate=$fiscal_info->start_date;
        $tdate=$fiscal_info->end_date;
		if($_POST['group_for_actual']>0){
		$group_name = find_a_field('user_group','group_name','id="'.$_POST['group_for_actual'].'"');
		}
		
		?>
		
		<table width="100%" border="0">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$group_name;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Fiscal Year : <?=$fiscal_info->fiscal_year;?></strong></td>	
				</tr>
 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Date: <?php echo date('d-m-Y',strtotime($fdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($tdate));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $fdate;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($tdate)));

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
       </table>								
										
<?



$sql = "select a.ledger_group_id, sum(j.cr_amt-j.dr_amt) as sales_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and l.acc_class=3";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt=$data->sales_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_opening 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_opening=$data->rm_opening;
}


$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and l.acc_sub_class!=42 and l.acc_class=4";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt=$data->expense_amt;
}

$material_cost=($rm_opening+$purchase_amt)-$rm_closing;
$total_cogs_amt=$material_cost+$expense_amt;

$net_profit_loss=$sales_amt-$total_cogs_amt;




//Comparative Data


$sql = "select a.ledger_group_id, sum(j.cr_amt-j.dr_amt) as sales_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$cfdate."' and '".$ctdate."' and l.acc_class=3";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt_cm=$data->sales_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_opening 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$cfdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_opening_cm=$data->rm_opening;
}


$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$cfdate."' and '".$ctdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt_cm=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing_cm=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$cfdate."' and '".$ctdate."' and l.acc_sub_class!=42 and l.acc_class=4";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt_cm=$data->expense_amt;
}

$material_cost_cm=($rm_opening_cm+$purchase_amt_cm)-$rm_closing_cm;
$total_cogs_amt_cm=$material_cost_cm+$expense_amt_cm;

$net_profit_loss_cm=$sales_amt_cm-$total_cogs_amt_cm;





 $sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as asset_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$asset_amt[$data->acc_sub_sub_class]=$data->asset_amt;

}


$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as liability_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$liability_amt[$data->acc_sub_sub_class]=$data->liability_amt;

}



//Comparative Data

$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as asset_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$asset_amt_cm[$data->acc_sub_sub_class]=$data->asset_amt;

}

$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as liability_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$liability_amt_cm[$data->acc_sub_sub_class]=$data->liability_amt;

}




//Cash Bank Balance


 $sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as cash_opening from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.id=127 ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$cash_opening=$data->cash_opening;

}

	   
	   ?>

	

							<table id="grp" width="100%" border="1" cellspacing="0" cellpadding="0">

										<thead >

										<tr>

											<th width="53%" rowspan="2" bgcolor="#82D8CF" style="color:#000000;">&nbsp; Particular</th>

											<th width="23%" bgcolor="#82D8CF" align="center" style="color:#000000;"><div align="center"><?=$fiscal_info->fiscal_year?></div></th>
									      </tr>
										<tr>
										  <th bgcolor="#82D8CF" align="center" style="color:#000000;"><div align="center">Amount</div></th>
										  </tr>
										</thead>
										
			<tr>
									  <td bgcolor="#E0FFFF" style="color:#000000;">&nbsp; <strong>Cash Flows from Operating Activities:</strong></td>
									  <td bgcolor="#E0FFFF" style="color:#000000;">&nbsp;</td>
		                      </tr>
					
					
					<tr>

							 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Net Profit/ (loss) After Tax</td>

										  <td align="right">
										  
		 <a href="financial_profit_loss.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>" target="_blank"><?=number_format($net_profit_loss,2);?>	</a></td>
						      </tr>	


<tr>

							 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depreciation Charged</td>

										  <td align="right"><?=number_format($depreciation_amt=0,2);?>	</td>
						      </tr>	


<tr>

										  <td align="left">&nbsp; <strong>Cash flow from operating activities before working capital changes:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($operating_activities_before_working_capital=$net_profit_loss+$depreciation_amt,2);?>
										  </strong></td>
						      </tr>			
										
										

										

										
	
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong>(Increase)/ Decrease in working Capital:</strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
							        </tr>
									  
									  

<?php


 $sql1="select ss.id, ss.sub_sub_class_name from cashflow_configuration c, acc_sub_sub_class ss 
where  ss.id=c.acc_sub_sub_class and c.type='Working Capital' group by c.acc_sub_sub_class order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Increase)/ Decrease in <?=$data1->sub_sub_class_name;?></td>
<td align="right"><?=number_format($working_capital=$asset_amt_cm[$data1->id]-$asset_amt[$data1->id],2); $total_working_capital +=$working_capital;?></td>
									  </tr>
									  
									  
									  
<? }?>	

						<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>A. Net Cashflows From Operating Activities</strong></td>

										  <td align="right"><strong>
									      <?=number_format($net_operating_activities=($operating_activities_before_working_capital+$total_working_capital),2); ?>
										  </strong></td>
						      </tr>


		
		
									
									  
									  <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
										

				<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong>Cash Flows From Investing Activities:</strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
							        </tr>
									  
									  

<?php


 $sql1="select ss.id, ss.sub_sub_class_name from cashflow_configuration c, acc_sub_sub_class ss 
where  ss.id=c.acc_sub_sub_class and c.type='Investing Activities' group by c.acc_sub_sub_class order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><?=number_format($investing_activities=$asset_amt_cm[$data1->id]-$asset_amt[$data1->id],2); $total_investing_activities +=$investing_activities;?></td>
									  </tr>
									  
									  
									  
<? }?>	



<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>B. Net Cash Flows From Investing Activities:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_investing_activities,2); ?>
										  </strong></td>
						      </tr>
							  
							  
							  
							  
							  
							  
							
							
									
									  
									  <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
										

				<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong>Cash Flows From Financing Activities:</strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
							        </tr>
									  
									  

<?php


 $sql1="select ss.id, ss.sub_sub_class_name from cashflow_configuration c, acc_sub_sub_class ss 
where  ss.id=c.acc_sub_sub_class and c.type='Financing Activities' group by c.acc_sub_sub_class order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><?=number_format($financing_activities=$asset_amt_cm[$data1->id]-$asset_amt[$data1->id],2); $total_financing_activities +=$financing_activities;?></td>
									  </tr>
									  
									  
									  
<? }?>	



						<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>C. Net Cash Flows From Financing Activities:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_financing_activities,2); ?>
										  </strong></td>
						 </tr>
						 
						 
						 <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>D. Net Increase in Cash & Cash Equivalents (A+ B + C):</strong></td>

										  <td align="right"><strong>
 <?=number_format($net_increase_cash_equivalents=($net_operating_activities+$total_investing_activities+$total_financing_activities),2); ?>
										  </strong></td>
						 </tr>
							  
							  
							    
							 <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>E. Cash & Cash Equivalents at Beginning of the Year:</strong></td>

										  <td align="right"><strong>
 										<?=number_format($cash_opening,2); ?>
										  </strong></td>
						 </tr> 
							  
							  
							  
							  <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>F. Cash & Cash Equivalents at End of the Year (D+E):</strong></td>

										  <td align="right"><strong>
 										<?=number_format($cash_equivalents_closing=($net_increase_cash_equivalents+$cash_opening),2); ?>
										  </strong></td>
						 </tr> 
							  
							  
							  
							  
							  
							  
									</table>

									

									  
									  
									  



									</div>







									</td>



								</tr>



						</table>

<? 

}

elseif($_REQUEST['report']=='NC1004') 

{

		$report="Equity Statement";		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $fdate=$fiscal_info->start_date;
        $tdate=$fiscal_info->end_date;
		if($_POST['group_for_actual']>0){
		$group_name = find_a_field('user_group','group_name','id="'.$_POST['group_for_actual'].'"');
		}
		
		?>
		
		<table width="100%" border="0">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$group_name;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Fiscal Year : <?=$fiscal_info->fiscal_year;?></strong></td>	
				</tr>
 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Date: <?php echo date('d-m-Y',strtotime($fdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($tdate));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $fdate;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($tdate)));

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
       </table>								
<table id="grp"  width="100%" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="46%" bgcolor="#82D8CF">&nbsp; Particulars</th>

											<th width="18%" bgcolor="#82D8CF" align="center"><div align="center">Share Capital</div></th>
											<th width="19%" bgcolor="#82D8CF" align="center"><div align="center">Retained Earnings</div></th>
											<th width="17%" bgcolor="#82D8CF" align="center"><div align="center">Total</div></th>
										</tr>
										</thead>

										

										
										
<?


$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as opening_ret_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 and s.id=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_ret_amt[$data->acc_sub_class]=$data->opening_ret_amt;
}



 $sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as opening_sc_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 and s.id!=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_sc_amt[$data->acc_sub_class]=$data->opening_sc_amt;
}


 $sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_ope_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and a.acc_class=3 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_ope_amt[$data->acc_class]=$data->sales_ope_amt;
}

   $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_ope_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and a.acc_class=4 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$exp_ope_amt[$data->acc_class]=$data->exp_ope_amt;
}






$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as ret_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and s.acc_sub_class=21 and s.id=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$ret_amt[$data->acc_sub_class]=$data->ret_amt;
}

$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as sc_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and s.acc_sub_class=21 and s.id!=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sc_amt[$data->acc_sub_class]=$data->sc_amt;
}


 $sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and a.acc_class=3 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt[$data->acc_class]=$data->sales_amt;
}


   $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and a.acc_class=4 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$exp_amt[$data->acc_class]=$data->exp_amt;
}


//$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as expenses_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
// where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by l.acc_sub_sub_class";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$expenses_amt[$data->acc_sub_sub_class]=$data->expenses_amt;
//
//}


 //$opening_sc="SELECT sum(j.cr_amt-j.dr_amt) as opening_sc_amt
// FROM acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j  
// WHERE s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 group by s.acc_sub_class";
//$opening_sc_amt = find_a_field_sql($opening_sc);

$net_opening_sc_amt=$opening_sc_amt[21];
$net_sales_ope_amt=$sales_ope_amt[3];
$net_exp_ope_amt=$exp_ope_amt[4];
$retained_earnings_ope=($sales_ope_amt[3]+$opening_ret_amt[21])-$exp_ope_amt[4];
$net_retained_earnings_ope=$retained_earnings_ope;
$total_equity_ope=$opening_sc_amt[21]+$retained_earnings_ope;
$net_total_equity_ope=$total_equity_ope;


$net_sc_amt=$sc_amt[21];
$retained_earnings=($sales_amt[3]+$ret_amt[21])-$exp_amt[4];
$net_retained_earnings=$retained_earnings;
$total_equity=$sc_amt[21]+$retained_earnings;
$net_total_equity=$total_equity;


$grand_sc_amt=$opening_sc_amt[21]+$sc_amt[21];
$grand_retained_earnings=$retained_earnings_ope+$retained_earnings;
$grand_total_equity=$total_equity_ope+$total_equity;

   
	   ?>
			<tr>
					  <td bgcolor="#E0FFFF">&nbsp; Balance as on <strong><?=date("d M, Y",strtotime($fdate))?></strong></td>

										  <td bgcolor="#E0FFFF" align="right">  
	<?=($net_opening_sc_amt>0)?number_format($net_opening_sc_amt,2):'('.number_format($net_opening_sc_amt*(-1),2).')';?>										  </td>
										  <td bgcolor="#E0FFFF" align="right">
    <?=($net_retained_earnings_ope>0)?number_format($net_retained_earnings_ope,2):'('.number_format($net_retained_earnings_ope*(-1),2).')';?>										  </td>
										  <td bgcolor="#E0FFFF" align="right">
	 <?=($net_total_equity_ope>0)?number_format($net_total_equity_ope,2):'('.number_format($net_total_equity_ope*(-1),2).')';?>										  </td>
									  </tr>
									  
									  
							  
									  
									  <tr>

										  <td>&nbsp;Comprehensive Income/Loss For The Year</td>
                                          <td align="right">
	<?=($net_sc_amt>0)?number_format($net_sc_amt,2):'('.number_format($net_sc_amt*(-1),2).')';?>										  </td>
                                          <td align="right">
	 <?=($net_retained_earnings>0)?number_format($net_retained_earnings,2):'('.number_format($net_retained_earnings*(-1),2).')';?>										  </td>
                                        <td align="right">
    <?=($net_total_equity>0)?number_format($net_total_equity,2):'('.number_format($net_total_equity*(-1),2).')';?></td>
									  </tr>
									  
									  
	

 						<tr>

										  <td align="left">&nbsp;<strong>Balance as on <?=date("d M, Y",strtotime($tdate))?></strong></td>

										  <td align="right"><strong>
			<?=($grand_sc_amt>0)?number_format($grand_sc_amt,2):'('.number_format($grand_sc_amt*(-1),2).')';?>	</strong>										  </td>
										  <td align="right"><strong>
			 <?=($grand_retained_earnings>0)?number_format($grand_retained_earnings,2):'('.number_format($grand_retained_earnings*(-1),2).')';?></strong>										  </td>
										  <td align="right"><strong>
			<?=($grand_total_equity>0)?number_format($grand_total_equity,2):'('.number_format($grand_total_equity*(-1),2).')';?></strong>										  </td>
									  </tr>


		
									
										

										
										
								
			
										
									  
									  
						</table>

<? 

}

elseif($_REQUEST['report']=='NC1005') 

{

		$report="Receipt & Payment Statement";		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $fdate=$fiscal_info->start_date;
        $tdate=$fiscal_info->end_date;
		if($_POST['group_for_actual']>0){
		$group_name = find_a_field('user_group','group_name','id="'.$_POST['group_for_actual'].'"');
		}
		
		?>
		
		<table width="100%" border="0">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$group_name;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Fiscal Year : <?=$fiscal_info->fiscal_year;?></strong></td>	
				</tr>
 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Date: <?php echo date('d-m-Y',strtotime($fdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($tdate));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $fdate;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($tdate)));

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
       </table>								

<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="70%" bgcolor="#82D8CF">&nbsp; Particulars</th>

											<th width="30%" bgcolor="#82D8CF"><div align="right">Amount</div></th>
										</tr>
										</thead>

										

										
										
<?


$sql = "select a.ledger_id, sum(j.dr_amt-j.cr_amt) as opening_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$fdate."' group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_amt[$data->ledger_id]=$data->opening_amt;
}

$sql = "select a.ledger_id, sum(j.dr_amt-j.cr_amt) as closing_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$closing_amt[$data->ledger_id]=$data->closing_amt;
}



?>

<tr>
									  <td bgcolor="#d2b4de"><strong>&nbsp; Receipts</strong></td>
									  <td bgcolor="#d2b4de">&nbsp;</td>
				  </tr>

<?

	   
 $sql_sub="select group_id, group_name from ledger_group where acc_sub_sub_class=127 group by group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql="select a.ledger_id, a.ledger_name from accounts_ledger a where a.ledger_group_id='".$info_sub->group_id."'  order by a.ledger_name";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->ledger_name;?></td>
<td align="right"><?=number_format($opening_amt[$data->ledger_id],2); $tot_opening_amt+=$opening_amt[$data->ledger_id];?></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
									<tr>

										  <td align="left"><strong>&nbsp; Opening Balance </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_opening_amt,2);?>
										  </strong></td>
									  </tr>
										
	
									
									
									
									<tr>
									  <td align="left">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									
<?
	   
  $sql_sub="select group_id, group_name from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and j.tr_from='Receipt' and j.cr_amt>0
 and l.acc_sub_sub_class!=127 group by l.group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql="select a.ledger_id, a.ledger_name, sum(j.cr_amt) as receipt_amt from ledger_group l, accounts_ledger a, journal j 
where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and a.ledger_group_id='".$info_sub->group_id."' and j.jv_date between '".$fdate."' and '".$tdate."'
and j.tr_from='Receipt' and j.cr_amt>0 group by a.ledger_id order by a.ledger_name";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->ledger_name;?></td>
<td align="right"><?=number_format($data->receipt_amt,2); $tot_receipt_amt+=$data->receipt_amt;?></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
									<tr>

										  <td align="left"><strong>&nbsp; Receipts in Period </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_receipt_amt,2);?>
										  </strong></td>
									  </tr>
										

									
									<tr>

										  <td align="left"><strong>&nbsp; Total  Amt </strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_receipt_balance=($tot_opening_amt+$tot_receipt_amt),2);?>
										  </strong></td>
				  </tr>  
				  
				  
				  
				  
		<tr>
									  <td align="left">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>		  
				  
<tr>
									  <td bgcolor="#d2b4de"><strong>&nbsp; Payments</strong></td>
									  <td bgcolor="#d2b4de">&nbsp;</td>
				  </tr>


										
	
									
									
									
									
									  
									  
									
<?
	   
  $sql_sub="select group_id, group_name from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and j.tr_from='Payment' and j.dr_amt>0
 and l.acc_sub_sub_class!=127 group by l.group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql="select a.ledger_id, a.ledger_name, sum(j.dr_amt) as payment_amt from ledger_group l, accounts_ledger a, journal j 
where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and a.ledger_group_id='".$info_sub->group_id."' and j.jv_date between '".$fdate."' and '".$tdate."'
and j.tr_from='Payment' and j.dr_amt>0 group by a.ledger_id order by a.ledger_name";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->ledger_name;?></td>
<td align="right"><?=number_format($data->payment_amt,2); $tot_payment_amt+=$data->payment_amt;?></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
		
		
									<tr>

										  <td align="left"><strong>&nbsp; Payments in Period </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_payment_amt,2);?>
										  </strong></td>
									  </tr>
									  
									  <tr>
									  <td align="left">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  <?

	   
 $sql_sub="select group_id, group_name from ledger_group where acc_sub_sub_class=127 group by group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql="select a.ledger_id, a.ledger_name from accounts_ledger a where a.ledger_group_id='".$info_sub->group_id."'  order by a.ledger_name";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->ledger_name;?></td>
<td align="right"><?=number_format($closing_amt[$data->ledger_id],2); $tot_closing_amt+=$closing_amt[$data->ledger_id];?></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
									<tr>

										  <td align="left"><strong>&nbsp; Closing Balance </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_closing_amt,2);?>
										  </strong></td>
									  </tr>
										


									
									<tr>

										  <td align="left"><strong>&nbsp; Total  Amt </strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_payment_balance=($tot_closing_amt+$tot_payment_amt),2);?>
										  </strong></td>
				  </tr>
									  
								
									
									</table>
<? 

}

elseif($_REQUEST['report']=='C1001') 

{

		$report="Profit & Loss";		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $fdate=$fiscal_info->start_date;
        $tdate=$fiscal_info->end_date;
		if($_POST['group_for_actual']>0){
		$group_name = find_a_field('user_group','group_name','id="'.$_POST['group_for_actual'].'"');
		}
		
		if($_POST['group_for_com']>0){
		$group_name2 = find_a_field('user_group','group_name','id="'.$_POST['group_for_com'].'"');
		}
		
		if($_POST['fiscal_year2']>0){
		$fiscal_info2 = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year2'].'"');
        $cfdate=$fiscal_info2->start_date;
        $ctdate=$fiscal_info2->end_date;
		}
		
function daysCount($fdate,$tdate){
$f_dt = $fdate;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($tdate)));

$from_date = strtotime($f_dt);
$to_date = strtotime($t_dt);
$datediff = $to_date - $from_date;
$count_days = round($datediff / (60 * 60 * 24));
return 	$count_days.' Days';
}
		
		
		
		?>
		
		<table width="100%" border="0">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Fiscal Year : <?=$fiscal_info->fiscal_year;?> & <?=$fiscal_info2->fiscal_year;?></strong></td>	
				</tr>
 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong><?=$fiscal_info->fiscal_year?>:</strong> <?php echo date('d-m-Y',strtotime($fdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($tdate));?>
		   
		  (Duration <?=daysCount($fdate,$tdate);?> Days)
		   </td>
         </tr>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong><?=$fiscal_info2->fiscal_year?>:</strong> <?php echo date('d-m-Y',strtotime($cfdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($ctdate));?>
		   
		  (Duration <?=daysCount($cfdate,$ctdate);?> Days)
		   </td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		</tr>
       </table>								

<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>
										    <th width="53%" rowspan="3" bgcolor="#82D8CF"  style="color:#000000;">&nbsp; Particular</th>
											<th width="25%" bgcolor="#82D8CF"  style="color:#000000;"><div align="center"><?=$group_name?></div></th>
									        <th width="22%" bgcolor="#82D8CF" style="color:#000000;"><div align="center"><?=$group_name2?></div></th>
										</tr>
										
										<tr>
										    

									
									
									<th width="25%" bgcolor="#82D8CF"  style="color:#000000;"><div align="center"><?=date("d M, Y",strtotime($tdate))?></div></th>
									<th width="22%" bgcolor="#82D8CF"  style="color:#000000;"><div align="center"><?=date("d M, Y",strtotime($ctdate))?></div></th>
										</tr>
										
										
										<tr>
										  <th bgcolor="#82D8CF"  style="color:#000000;"><div align="center">Amount</div></th>
										  <th width="22%" bgcolor="#82D8CF"  style="color:#000000;"><div align="center">Amount</div></th>
										</tr>
										</thead>

										

										
										
<?

$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as sales_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt[$data->acc_sub_sub_class]=$data->sales_amt;
}

$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as expenses_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expenses_amt[$data->acc_sub_sub_class]=$data->expenses_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_opening 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_opening=$data->rm_opening;
}

$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and l.acc_sub_sub_class in (411,412)";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt=$data->expense_amt;
}

$material_cost=($rm_opening+$purchase_amt)-$rm_closing;
//$total_cogs_amt=$material_cost+$expense_amt;
$total_cogs_amt=$sales_amt['411']*(-1);



// Comparative 

$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as sales_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$cfdate."' and '".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt_cm[$data->acc_sub_sub_class]=$data->sales_amt;
}

$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as expenses_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$cfdate."' and '".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expenses_amt_cm[$data->acc_sub_sub_class]=$data->expenses_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_opening 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$cfdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_opening_cm=$data->rm_opening;
}

$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$cfdate."' and '".$ctdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt_cm=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing_cm=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$cfdate."' and '".$ctdate."' and l.acc_sub_sub_class in (315,4110)";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt_cm=$data->expense_amt;
}

$material_cost_cm=($rm_opening_cm+$purchase_amt_cm)-$rm_closing_cm;
//$total_cogs_amt_cm=$material_cost_cm+$expense_amt_cm;
$total_cogs_amt_cm = $sales_amt_cm['411']*(-1);

$sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.id=31
group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_class_name;?>.</strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									      <td bgcolor="#E0FFFF">&nbsp;</td>
									</tr>
									  
									  

<?php


$sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub1->id."' and ss.id not in (315,314)  order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank">
<?=number_format($sales_amt[$data1->id],2); $tot_sales_amt +=$sales_amt[$data1->id];?></a></td>
									  <td align="right"><a href="master_report_new.php?show=show&amp;fdate=<?=$cfdate?>&amp;tdate=<?=$ctdate?>&amp;acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank">
                                        <?=number_format($sales_amt_cm[$data1->id],2); $tot_sales_amt_cm +=$sales_amt_cm[$data1->id];?>
									    </a></td>
									  </tr>
									  
									  
									  
<? }?>	


<tr>
										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cost of Goods Sold..</td>

										  <td align="right">
										  
		<a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=411&&report=CD1001" target="_blank"><?=number_format($sales_amt['411'],2);?>	</a></td>
									      <td align="right"><a href="master_report_new.php?show=show&amp;fdate=<?=$cfdate?>&amp;tdate=<?=$ctdate?>&acc_sub_sub_class=411&&report=CD1001" target="_blank">
									        <?=number_format($sales_amt_cm['411'],2);?>
                                          </a></td>
</tr>
 						


							  
		<? }?>
		
		
									<tr>

										  <td align="center"><strong>Gross Profit</strong></td>

										  <td align="right"><strong>
									      <?=number_format($gross_profit_amt=$tot_sales_amt-$total_cogs_amt,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($gross_profit_amt_cm=$tot_sales_amt_cm-$total_cogs_amt_cm,2);?>
                                          </strong></td>
									</tr>
										

										
										
								
										
<?
	   
   $sql_sub2="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=4 and s.id!=41
group by s.id";
$query_sub2=db_query($sql_sub2);

while($info_sub2=mysqli_fetch_object($query_sub2)){ 
	   
	   
	   ?>

										<tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub2->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									      <td bgcolor="#D8BFD8">&nbsp;</td>
									  </tr>
									  
									  

<?php


 $sql2="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub2->id."'  order by ss.id";

$query2=db_query($sql2);

while($data2=mysqli_fetch_object($query2)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data2->sub_sub_class_name;?></td>

										  <td align="right">
										  
		 <a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data2->id?>&&report=CD1001" target="_blank">
		 <?=number_format($expenses_amt[$data2->id],2); $tot_expenses_amt +=$expenses_amt[$data2->id];?></a></td>
									      <td align="right"><a href="master_report_new.php?show=show&fdate=<?=$cfdate?>&tdate=<?=$ctdate?>&acc_sub_sub_class=<?=$data2->id?>&&report=CD1001" target="_blank">
                                            <?=number_format($expenses_amt_cm[$data2->id],2); $tot_expenses_amt_cm +=$expenses_amt_cm[$data2->id];?>
									        </a></td>
									  </tr>
									  
									  
									  
<? }?>	

 						


							  
		<? }?>
		

		
									<tr>

										  <td align="center"><strong> Total Operating Expenses</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_expenses_amt,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($tot_expenses_amt_cm,2);?>
                                          </strong></td>
									</tr>
									
									
									<tr>

										  <td align="center"><strong> Profit from Operation</strong></td>

										  <td align="right"><strong>
									      <?=number_format($profit_from_operation=($gross_profit_amt-$tot_expenses_amt),2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($profit_from_operation_cm=($gross_profit_amt_cm-$tot_expenses_amt_cm),2);?>
                                          </strong></td>
									</tr>
										

										
							<tr>

										  <td align="center"><strong>Profit Before Other Income</strong></td>

										  <td align="right"><strong>
									      <?=number_format($profit_before_tax=($profit_from_operation+$tot_finance_income)-$tot_finance_exp,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($profit_before_tax_cm=($profit_from_operation_cm+$tot_finance_income_cm)-$tot_finance_exp_cm,2);?>
                                          </strong></td>
							</tr>
							
							
							
							
<?php


$sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where  ss.acc_sub_class=31 and ss.id in (315) order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank">
<?=number_format($sales_amt[$data1->id],2); $tot_other_income +=$sales_amt[$data1->id];?></a></td>
									  <td align="right"><a href="master_report_new.php?show=show&fdate=<?=$cfdate?>&tdate=<?=$ctdate?>&acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank">
                                        <?=number_format($sales_amt_cm[$data1->id],2); $tot_other_income_cm +=$sales_amt_cm[$data1->id];?>
									    </a></td>
									  </tr>
									  
									  
									  
<? }?>	



								<tr>

										  <td align="center"><strong>Net Profit/(Loss) Before Tax</strong></td>

										  <td align="right"><strong>
									      <?=number_format($net_profit_before_tax=($profit_before_tax+$tot_other_income),2);?>
										  </strong></td>
									      <td align="right"><strong>
                                           <?=number_format($net_profit_before_tax_cm=($profit_before_tax_cm+$tot_other_income_cm),2);?>
                                          </strong></td>
							</tr>

									  
									  
									  <tr>


										  <td align="left">&nbsp; <strong>lncome Tax Expenses</strong></td>

										  <td align="right">&nbsp;</td>
									      <td align="right">&nbsp;</td>
									  </tr>
									  
									  <tr>

										  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Current Tax Expenses/ (Income)</td>

										  <td align="right">0.00</td>
									      <td align="right">0.00</td>
									  </tr>
									  
									  <tr>

										  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deferred Tax Expenses/ (Income), Net</td>

										  <td align="right">0.00</td>
									      <td align="right">0.00</td>
									  </tr>
									
									
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									</tr>
									<tr>
									  <td align="center"><strong>Net Profit After Tax</strong></td>
									  <td align="right"><strong>
									  <?=number_format($net_profit_loss = ($net_profit_before_tax-$income_tax_exp),2);?> </strong></td>
									  <td align="right" ><strong>
                                        <?=number_format($net_profit_loss_cm = ($net_profit_before_tax_cm-$income_tax_exp_cm),2);?></strong></td>
									</tr>
									
									<tr>

										  <td align="center"><strong>Other Comprehensive Income/(Loss)</strong></td>

										  <td align="right"><strong>
									      <?=number_format($other_comprehensive_income_loss=0,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                           <?=number_format($other_comprehensive_income_loss_cm=0,2);?>
                                          </strong></td>
									  </tr>
									
									
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									</tr>
									
									<tr>
									  <td align="center"><strong>Total Comprehensive Income/(Loss)</strong></td>
									  <td align="right"><strong>
									  <?=number_format($total_comprehensive_income_loss = ($net_profit_loss+$other_comprehensive_income_loss),2);?> </strong></td>
									  <td align="right" ><strong>
                                        <?=number_format($total_comprehensive_income_loss_cm = ($net_profit_loss_cm+$other_comprehensive_income_loss_cm),2);?></strong></td>
									</tr>
									
									</table>
<? 

}

elseif($_REQUEST['report']=='C1002') 

{

		$report="Financial Statement";		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $fdate=$fiscal_info->start_date;
        $tdate=$fiscal_info->end_date;
		if($_POST['group_for_actual']>0){
		$group_name = find_a_field('user_group','group_name','id="'.$_POST['group_for_actual'].'"');
		}
		
		if($_POST['group_for_com']>0){
		$group_name2 = find_a_field('user_group','group_name','id="'.$_POST['group_for_com'].'"');
		}
		
		if($_POST['fiscal_year2']>0){
		$fiscal_info2 = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year2'].'"');
        $cfdate=$fiscal_info2->start_date;
        $ctdate=$fiscal_info2->end_date;
		}
		
function daysCount($fdate,$tdate){
$f_dt = $fdate;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($tdate)));

$from_date = strtotime($f_dt);
$to_date = strtotime($t_dt);
$datediff = $to_date - $from_date;
$count_days = round($datediff / (60 * 60 * 24));
return 	$count_days.' Days';
}
		
		
		
		?>
		
		<table width="100%" border="0">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Fiscal Year : <?=$fiscal_info->fiscal_year;?> & <?=$fiscal_info2->fiscal_year;?></strong></td>	
				</tr>
 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong><?=$fiscal_info->fiscal_year?>:</strong> <?php echo date('d-m-Y',strtotime($fdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($tdate));?>
		   
		  (Duration <?=daysCount($fdate,$tdate);?> Days)
		   </td>
         </tr>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong><?=$fiscal_info2->fiscal_year?>:</strong> <?php echo date('d-m-Y',strtotime($cfdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($ctdate));?>
		   
		  (Duration <?=daysCount($cfdate,$ctdate);?> Days)
		   </td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		</tr>
       </table>								

<table id="grp" width="100%" border="1" cellspacing="0" cellpadding="0">

										<thead>
										
										<tr>
										    <th width="53%" rowspan="3" bgcolor="#82D8CF"  style="color:#000000;">&nbsp; Particular</th>
											<th width="25%" bgcolor="#82D8CF"  style="color:#000000;"><div align="center"><?=$group_name?></div></th>
									<th width="22%" bgcolor="#82D8CF"  style="color:#000000;"><div align="center"><?=$group_name2?></div></th>

									
										</tr>

										<tr>

										

											<th width="23%" bgcolor="#82D8CF" align="center" style="color:#000000;"><div align="center"><?=date("d M, Y",strtotime($tdate))?></div></th>
										    <th width="24%" align="center" bgcolor="#82D8CF" style="color:#000000;"><div align="center"><?=date("d M, Y",strtotime($ctdate))?></div></th>
										</tr>
										<tr>
										  <th bgcolor="#82D8CF" align="center" style="color:#000000;"><div align="center">Amount</div></th>
										  <th width="24%" align="center" bgcolor="#82D8CF" style="color:#000000;"><div align="center">Amount</div></th>
										</tr>
										</thead>

		<tr>
									  <td bgcolor="#E0FFFF" style="color:#000000;">&nbsp; <strong>ASSETS</strong></td>
									  <td bgcolor="#E0FFFF" style="color:#000000;">&nbsp;</td>
				                      <td bgcolor="#E0FFFF" style="color:#000000;">&nbsp;</td>
		</tr>								

										
										
<?

 $sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as asset_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$asset_amt[$data->acc_sub_sub_class]=$data->asset_amt;

}


$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as liability_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$liability_amt[$data->acc_sub_sub_class]=$data->liability_amt;

}



//Comparative Data

$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as asset_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$asset_amt_cm[$data->acc_sub_sub_class]=$data->asset_amt;

}

$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as liability_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$liability_amt_cm[$data->acc_sub_sub_class]=$data->liability_amt;

}



	   
 $sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=1
group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									      <td bgcolor="#E0FFFF">&nbsp;</td>
									</tr>
									  
									  

<?php


$sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub1->id."'  order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank">
<?=number_format($asset_amt[$data1->id],2); $tot_asset_amt +=$asset_amt[$data1->id];?></a></td>

									  <td align="right"><a href="master_report_new.php?show=show&fdate=<?=$cfdate?>&tdate=<?=$ctdate?>&acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank">
                                        <?=number_format($asset_amt_cm[$data1->id],2); $tot_asset_amt_cm +=$asset_amt_cm[$data1->id];?>
									    </a></td>
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_asset_amt,2); $net_tot_asset_amt +=$tot_asset_amt;?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($tot_asset_amt_cm,2); $net_tot_asset_amt_cm +=$tot_asset_amt_cm;?>
                                          </strong></td>
 						</tr>


							  
		<? 
		$tot_asset_amt=0;
		$tot_asset_amt_cm=0;
		}?>
		
		
									<tr>

										  <td align="center"><strong>Total Assets:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($net_tot_asset_amt,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($net_tot_asset_amt_cm,2);?>
                                          </strong></td>
									</tr>
									  
									  <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
										

			<tr>
										  <td bgcolor="#D8BFD8">&nbsp;<strong>EQUITY & LIABILITIES</strong></td>
										  <td bgcolor="#D8BFD8">&nbsp;</td>
				                          <td bgcolor="#D8BFD8">&nbsp;</td>
			</tr>	
				  
				  							
										
								
										
<?


 //$sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_amt 
// from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
// where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$tdate."' and a.acc_class=3 group by a.acc_class";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$sales_amt[$data->acc_class]=$data->sales_amt;
//}
//
// $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_amt 
//from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
// where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$tdate."' and a.acc_class=4 group by a.acc_class";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$exp_amt[$data->acc_class]=$data->exp_amt;
//}
//
//
//$retained_earnings=$sales_amt[3]-$exp_amt[4];
//$net_retained_earnings=$retained_earnings;




$sql = "select a.ledger_group_id, sum(j.cr_amt-j.dr_amt) as sales_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and l.acc_class=3";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt=$data->sales_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and l.acc_class=4";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt=$data->expense_amt;
}
if($fdate=='2023-10-31'){
   $ret_opening=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=1590 and tr_from="Opening"');
}
else{
    
   $ret_opening=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=1590 and jv_date<"'.$fdate.'"'); 
}
$material_cost=$purchase_amt-$rm_closing;

$total_cogs_amt=$material_cost+$expense_amt;

$net_retained_earnings=($sales_amt-$total_cogs_amt)-$ret_opening;




//Comparative Data


$sql = "select a.ledger_group_id, sum(j.cr_amt-j.dr_amt) as sales_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' and l.acc_class=3";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt_cm=$data->sales_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt_cm=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing_cm=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' and l.acc_class=4";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt_cm=$data->expense_amt;
}
if($cfdate=='2023-10-31'){
   $ret_opening_c=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=1590 and tr_from="Opening"');
}
else{
    
   $ret_opening_c=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=1590 and jv_date<"'.$cfdate.'"'); 
}
$material_cost_cm=$purchase_amt_cm-$rm_closing_cm;

$total_cogs_amt_cm=$material_cost_cm+$expense_amt_cm;

$net_retained_earnings_cm=($sales_amt_cm-$total_cogs_amt_cm)-$ret_opening_c;







	   
  $sql_sub2="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=2 and s.id=21
group by s.id";
$query_sub2=db_query($sql_sub2);

while($info_sub2=mysqli_fetch_object($query_sub2)){ 
	   
	   
	   ?>

									
										<tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub2->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									      <td bgcolor="#D8BFD8">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql2="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub2->id."' and ss.id!=215  order by ss.id";

$query2=db_query($sql2);

while($data2=mysqli_fetch_object($query2)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data2->sub_sub_class_name;?></td>

										  <td align="right">
										  
		 <a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data2->id?>&&report=CD1001" target="_blank">
		 <?=number_format($liability_amt[$data2->id],2); $equity_amt +=$liability_amt[$data2->id];?></a></td>
									      <td align="right"><a href="master_report_new.php?show=show&fdate=<?=$cfdate?>&tdate=<?=$ctdate?>&acc_sub_sub_class=<?=$data2->id?>&&report=CD1001" target="_blank">
                                            <?=number_format($liability_amt_cm[$data2->id],2); $equity_amt_cm +=$liability_amt_cm[$data2->id];?>
									        </a></td>
									  </tr>
									  
									  
									  
									  
									  
									  
<? }?>	<tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retained Earnings</td>

										  <td align="right">
										  
		 <a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank"><?=number_format($net_retained_earnings,2);?>	</a></td>
									      <td align="right"><a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data1->id?>&&report=CD1001" target="_blank">
									        <?=number_format($net_retained_earnings_cm,2);?>
                                          </a></td>
</tr>

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_equity_amt=$equity_amt+$net_retained_earnings,2);?>
										  </strong></td>
 						                  <td align="right"><strong>
                                            <?=number_format($tot_equity_amt_cm=$equity_amt_cm+$net_retained_earnings_cm,2);?>
                                          </strong></td>
 						</tr>


							  
		<? }?>
		
		
		<?
	   
  $sql_sub3="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=2 and s.id!=21
group by s.id";
$query_sub3=db_query($sql_sub3);

while($info_sub3=mysqli_fetch_object($query_sub3)){ 
	   
	   
	   ?>

									
										<tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub3->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									      <td bgcolor="#D8BFD8">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql3="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub3->id."'  order by ss.id";

$query3=db_query($sql3);

while($data3=mysqli_fetch_object($query3)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data3->sub_sub_class_name;?></td>

										  <td align="right">
										  
		 <a href="master_report_new.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=<?=$data3->id?>&&report=CD1001" target="_blank">
		 <?=number_format($liability_amt[$data3->id],2); $tot_liability_amt +=$liability_amt[$data3->id];?></a></td>
									      <td align="right"><a href="master_report_new.php?show=show&fdate=<?=$cfdate?>&tdate=<?=$ctdate?>&acc_sub_sub_class=<?=$data3->id?>&&report=CD1001" target="_blank">
                                            <?=number_format($liability_amt_cm[$data3->id],2); $tot_liability_amt_cm +=$liability_amt_cm[$data3->id];?>
									        </a></td>
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_liability_amt,2); $net_tot_liability_amt +=$tot_liability_amt;?>
										  </strong></td>
 						                  <td align="right"><strong>
                                            <?=number_format($tot_liability_amt_cm,2); $net_tot_liability_amt_cm +=$tot_liability_amt_cm;?>
                                          </strong></td>
 						</tr>


							  
		<? 
		$tot_liability_amt=0;
		$tot_liability_amt_cm=0;
		}?>
		
		
									<tr>

										  <td align="center"><strong> Total Equity & Liabilities:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_equity_liabilities=$tot_equity_amt+$net_tot_liability_amt,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($total_equity_liabilities_cm=$tot_equity_amt_cm+$net_tot_liability_amt_cm,2);?>
                                          </strong></td>
									</tr>
		
		
									
									
									
									
									
									</table>
<? 

}

elseif($_REQUEST['report']=='C1003') 

{


		$report="Financial Statement";		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $fdate=$fiscal_info->start_date;
        $tdate=$fiscal_info->end_date;
		if($_POST['group_for_actual']>0){
		$group_name = find_a_field('user_group','group_name','id="'.$_POST['group_for_actual'].'"');
		}
		
		if($_POST['group_for_com']>0){
		$group_name2 = find_a_field('user_group','group_name','id="'.$_POST['group_for_com'].'"');
		}
		
		if($_POST['fiscal_year2']>0){
		$fiscal_info2 = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year2'].'"');
        $cfdate=$fiscal_info2->start_date;
        $ctdate=$fiscal_info2->end_date;
		}
		
function daysCount($fdate,$tdate){
$f_dt = $fdate;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($tdate)));

$from_date = strtotime($f_dt);
$to_date = strtotime($t_dt);
$datediff = $to_date - $from_date;
$count_days = round($datediff / (60 * 60 * 24));
return 	$count_days.' Days';
}
		
		
		
		?>
		
		<table width="100%" border="0">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong>Fiscal Year : <?=$fiscal_info->fiscal_year;?> & <?=$fiscal_info2->fiscal_year;?></strong></td>	
				</tr>
 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong><?=$fiscal_info->fiscal_year?>:</strong> <?php echo date('d-m-Y',strtotime($fdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($tdate));?>
		   
		  (Duration <?=daysCount($fdate,$tdate);?> Days)
		   </td>
         </tr>
		 
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong><?=$fiscal_info2->fiscal_year?>:</strong> <?php echo date('d-m-Y',strtotime($cfdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($ctdate));?>
		   
		  (Duration <?=daysCount($cfdate,$ctdate);?> Days)
		   </td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/fg-logo.png" style="width:100px;"><?php */?>
		</td>
		</tr>
       </table>								
<table id="grp"  width="100%" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>
										  
											<th width="18%" colspan="4" bgcolor="#82D8CF" align="center"><div align="center"><?=$group_name?></div></th>
											<th width="19%" colspan="4" bgcolor="#82D8CF" align="center"><div align="center"><?=$group_name2?></div></th>
											
										</tr>
										
										<tr>
										   
											<th width="18%" colspan="4" bgcolor="#82D8CF" align="center"><div align="center"><?=$fiscal_info->fiscal_year?></div></th>
											<th width="19%" colspan="4" bgcolor="#82D8CF" align="center"><div align="center"><?=$fiscal_info2->fiscal_year?></div></th>
											
										</tr>
										
										<tr>
										    <th width="46%"  bgcolor="#82D8CF">&nbsp; Particulars</th>
											<th width="18%" bgcolor="#82D8CF" align="center"><div align="center">Share Capital</div></th>
											<th width="19%" bgcolor="#82D8CF" align="center"><div align="center">Retained Earnings</div></th>
											<th width="17%" bgcolor="#82D8CF" align="center"><div align="center">Total</div></th>
											
											 <th width="46%"  bgcolor="#82D8CF">&nbsp; Particulars</th>
											<th width="18%" bgcolor="#82D8CF" align="center"><div align="center">Share Capital</div></th>
											<th width="19%" bgcolor="#82D8CF" align="center"><div align="center">Retained Earnings</div></th>
											<th width="17%" bgcolor="#82D8CF" align="center"><div align="center">Total</div></th>
										</tr>
										
										</thead>

										

										
										
<?


$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as opening_ret_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 and s.id=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_ret_amt[$data->acc_sub_class]=$data->opening_ret_amt;
}



 $sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as opening_sc_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 and s.id!=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_sc_amt[$data->acc_sub_class]=$data->opening_sc_amt;
}

$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as opening_sc_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$cfdate."' and s.acc_sub_class=21 and s.id!=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_sc_amt2[$data->acc_sub_class]=$data->opening_sc_amt;
}


 $sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_ope_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and a.acc_class=3 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_ope_amt[$data->acc_class]=$data->sales_ope_amt;
}

   $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_ope_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j

 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and a.acc_class=4 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$exp_ope_amt[$data->acc_class]=$data->exp_ope_amt;
}






$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as ret_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and s.acc_sub_class=21 and s.id=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$ret_amt[$data->acc_sub_class]=$data->ret_amt;
}

$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as sc_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and s.acc_sub_class=21 and s.id!=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sc_amt[$data->acc_sub_class]=$data->sc_amt;
}


 $sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and a.acc_class=3 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt[$data->acc_class]=$data->sales_amt;
}


   $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and a.acc_class=4 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$exp_amt[$data->acc_class]=$data->exp_amt;
}


//$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as expenses_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
// where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by l.acc_sub_sub_class";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$expenses_amt[$data->acc_sub_sub_class]=$data->expenses_amt;
//
//}


 //$opening_sc="SELECT sum(j.cr_amt-j.dr_amt) as opening_sc_amt
// FROM acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j  
// WHERE s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 group by s.acc_sub_class";
//$opening_sc_amt = find_a_field_sql($opening_sc);

$net_opening_sc_amt=$opening_sc_amt[21];
$net_opening_sc_amt2=$opening_sc_amt2[21];
$net_sales_ope_amt=$sales_ope_amt[3];
$net_exp_ope_amt=$exp_ope_amt[4];
$retained_earnings_ope=($sales_ope_amt[3]+$opening_ret_amt[21])-$exp_ope_amt[4];
$net_retained_earnings_ope=$retained_earnings_ope;
$total_equity_ope=$opening_sc_amt[21]+$retained_earnings_ope;
$net_total_equity_ope=$total_equity_ope;


$net_sc_amt=$sc_amt[21];
$retained_earnings=($sales_amt[3]+$ret_amt[21])-$exp_amt[4];
$net_retained_earnings=$retained_earnings;
$total_equity=$sc_amt[21]+$retained_earnings;
$net_total_equity=$total_equity;


$grand_sc_amt=$opening_sc_amt[21]+$sc_amt[21];
$grand_retained_earnings=$retained_earnings_ope+$retained_earnings;
$grand_total_equity=$total_equity_ope+$total_equity;

   
	   ?>
			<tr>
					  <td bgcolor="#E0FFFF">&nbsp; Balance as on <strong><?=date("d M, Y",strtotime($fdate))?></strong></td>

										  <td bgcolor="#E0FFFF" align="right">  
	<?=($net_opening_sc_amt>0)?number_format($net_opening_sc_amt,2):'('.number_format($net_opening_sc_amt*(-1),2).')';?></td>
										  <td bgcolor="#E0FFFF" align="right">
    <?=($net_retained_earnings_ope>0)?number_format($net_retained_earnings_ope,2):'('.number_format($net_retained_earnings_ope*(-1),2).')';?>										  </td>
										  <td bgcolor="#E0FFFF" align="right">
	 <?=($net_total_equity_ope>0)?number_format($net_total_equity_ope,2):'('.number_format($net_total_equity_ope*(-1),2).')';?>										  </td>
	 
	 
	 
	 <td bgcolor="#E0FFFF">&nbsp; Balance as on <strong><?=date("d M, Y",strtotime($cfdate))?></strong></td>
	 <td bgcolor="#E0FFFF" align="right">  
	<?=($net_opening_sc_amt2>0)?number_format($net_opening_sc_amt2,2):'('.number_format($net_opening_sc_amt2*(-1),2).')';?></td>
	 <td bgcolor="#E0FFFF" align="right">
    <?=($net_retained_earnings_ope2>0)?number_format($net_retained_earnings_ope2,2):'('.number_format($net_retained_earnings_ope2*(-1),2).')';?>										     </td>
	 <td bgcolor="#E0FFFF" align="right">
	 <?=($net_total_equity_ope2>0)?number_format($net_total_equity_ope2,2):'('.number_format($net_total_equity_ope2*(-1),2).')';?>										     </td>
	 </tr>
									  
									  
							  
									  
									  <tr>

										  <td>&nbsp;Comprehensive Income/Loss For The Year</td>
                                          <td align="right"><?=($net_sc_amt>0)?number_format($net_sc_amt,2):'('.number_format($net_sc_amt*(-1),2).')';?></td>
                                          <td align="right"><?=($net_retained_earnings>0)?number_format($net_retained_earnings,2):'('.number_format($net_retained_earnings*(-1),2).')';?></td>
                                        <td align="right"><?=($net_total_equity>0)?number_format($net_total_equity,2):'('.number_format($net_total_equity*(-1),2).')';?></td>
	
	
	
	<td>&nbsp;Comprehensive Income/Loss For The Year</td>
	 <td align="right"><?=($net_sc_amt2>0)?number_format($net_sc_amt2,2):'('.number_format($net_sc_amt2*(-1),2).')';?></td>
	 <td align="right"><?=($net_retained_earnings2>0)?number_format($net_retained_earnings2,2):'('.number_format($net_retained_earnings2*(-1),2).')';?></td>
	 <td align="right"><?=($net_total_equity2>0)?number_format($net_total_equity2,2):'('.number_format($net_total_equity2*(-1),2).')';?></td>
									  </tr>
									  
									  
	

 						<tr>

										  <td align="left">&nbsp;<strong>Balance as on <?=date("d M, Y",strtotime($tdate))?></strong></td>

										  <td align="right"><strong><?=($grand_sc_amt>0)?number_format($grand_sc_amt,2):'('.number_format($grand_sc_amt*(-1),2).')';?>	</strong></td>
										  <td align="right"><strong><?=($grand_retained_earnings>0)?number_format($grand_retained_earnings,2):'('.number_format($grand_retained_earnings*(-1),2).')';?></strong></td>
										  <td align="right"><strong><?=($grand_total_equity>0)?number_format($grand_total_equity,2):'('.number_format($grand_total_equity*(-1),2).')';?></strong></td>
			
			
			
			
			<td align="left">&nbsp;<strong>Balance as on <?=date("d M, Y",strtotime($ctdate))?></strong></td>
	 <td align="right"><strong><?=($grand_sc_amt2>0)?number_format($grand_sc_amt2,2):'('.number_format($grand_sc_amt2*(-1),2).')';?>	</strong></td>
	 <td align="right"><strong><?=($grand_retained_earnings2>0)?number_format($grand_retained_earnings2,2):'('.number_format($grand_retained_earnings2*(-1),2).')';?></strong></td>
	 <td align="right"><strong><?=($grand_total_equity2>0)?number_format($grand_total_equity2,2):'('.number_format($grand_total_equity2*(-1),2).')';?></strong></td>
									  </tr>


		
									
										

										
										
								
			
										
									  
									  
						</table>

<? 


}

elseif($_POST['report']==230910001)
{
		$report="TRIAL BALANCE REPORT";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $f_date=$fiscal_info->start_date;
        $t_date=$fiscal_info->end_date;
		
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
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($f_date));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($t_date));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $f_date;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($t_date)));

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
}

elseif($_REQUEST['report']=='CD1001')
{
		$report="TRIAL BALANCE REPORT";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $f_date=$fiscal_info->start_date;
        $t_date=$fiscal_info->end_date;
		if($_REQUEST['fdate']!=''){
		 $fdate = $_REQUEST['fdate'];
		 $tdate = $_REQUEST['tdate'];
		}
		
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
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($fdate));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($tdate));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $fdate;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($tdate)));

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
		
 		$sql = "select ledger_id, sum(dr_amt-cr_amt) as opening_amt from journal where jv_date <'".$fdate."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $opening_amt[$info->ledger_id]=$info->opening_amt;
		}
		
		
		
		$sql = "select ledger_id, sum(dr_amt) as dr_amt from journal where jv_date between '".$fdate."' and '".$t_date."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $dr_amt[$info->ledger_id]=$info->dr_amt;
		}
		
		$sql = "select ledger_id, sum(cr_amt) as cr_amt from journal where jv_date between '".$fdate."' and '".$tdate."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cr_amt[$info->ledger_id]=$info->cr_amt;
		}
		
		
		$sql = "select ledger_id, sum(dr_amt-cr_amt) as closing_amt from journal where jv_date <='".$tdate."' group by ledger_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $closing_amt[$info->ledger_id]=$info->closing_amt;
		}

		
         if($_REQUEST['acc_sub_sub_class']>0){
		  $con = ' and g.acc_sub_sub_class="'.$_REQUEST['acc_sub_sub_class'].'"';
		 }
		
		  $sql_sub="select g.group_id, g.group_name from ledger_group g, accounts_ledger a where g.group_id=a.ledger_group_id ".$con." group by a.ledger_group_id order by g.group_id";
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
		<td><a href="../files/transaction_listledger.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&ledger_id=<?=$row->ledger_id?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:14px;">
		<?=$row->ledger_name?></a></td>
		
		<td><div align="right">
		<?php $opening_balance=$opening_amt[$row->ledger_id];  $sub_total_opening_amt +=$opening_amt[$row->ledger_id];
		if($opening_balance>0) echo number_format($opening_balance,2).' (Dr)'; elseif($opening_balance<0) echo number_format(((-1)*$opening_balance),2).' (Cr)';else echo "0.00"; ?></div></td>
		  
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
}

elseif($_POST['report']==230910002)
{
		$report="TRIAL BALANCE REPORT (NET BALANCE)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		$fiscal_info = find_all_field('fiscal_year','','id="'.$_POST['fiscal_year'].'"');
        $f_date=$fiscal_info->start_date;
        $t_date=$fiscal_info->end_date;
		
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
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($f_date));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($t_date));?>
		   
		  (Duration <?
		
//echo $tomorrow =  date('Y-m-d', strtotime('+1 day', strtotime($_POST['t_date'])));
	
$f_dt = $f_date;		   
$t_dt =  date('Y-m-d', strtotime('+1 day', strtotime($t_date)));

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

<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>