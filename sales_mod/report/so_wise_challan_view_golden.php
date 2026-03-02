<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../../acc_mod/common/class.numbertoword.php');

$do_no 		= $_REQUEST['v_no'];

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

$master= find_all_field('sale_do_master','','do_no='.$do_no);

  		  $barcode_content = $do_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$entry_time=$dealer->do_date;


$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;

$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 



$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$master->job_no;?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
</head>


<body>
<div class="body">
	<div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> <?=$group_data->group_name?> </h2>			
				<p class="text"><?=$group_data->address?></p>
				<p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?></p>
		</td>
		
		
		<td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text" style="padding-right: 18px !important;"><?php echo $master->do_no;?></p>
		</td>
		
		</tr>
		 
		</table>
	</div>
	
	<div class="header-one">
	<hr class="hr">
		<h5 class="report-titel">Sales Order Wise Challan List</h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			<p class="left-text mt-1 mb-1"> Customer PO No: <span> <?php echo $master->po_no?> </span></p>
			
			<p class="left-text mt-1 mb-1">Customer Name: <span><?=$dealer->dealer_name_e;?> </span></p>
			<p class="left-text mt-1 mb-1">Customer Address: <span><?php echo $dealer->address_e?> </span></p>
			
		</div>

		<div class="col-md-6 col-sm-6 col-lg-6 right">

			<p class="right-text mt-1 mb-1">SO No: <span><?php echo $master->do_no?> </span></p>
			<p class="right-text mt-1 mb-1">SO Date: <span> <?=date("j-M-Y",strtotime($master->do_date));?> </span></p>
			<p class="right-text mt-1 mb-1">JOB  No: <span><?php echo $master->job_no?></span></p>


			
		</div>
	</div>



</div>


<div class="main-content">
	<br/>
	
	<div id="pr">
        <div align="left">
		<p><b>SO STATUS:</b> <?=find_a_field('sale_do_master','status','do_no='.$do_no);?></p>
		
         	 <p> <input name="button" type="button" onClick="hide();window.print();" value="Print"> </p>    
		</div>
     </div>
	  
	  
	  
	<table class="table1">
		<thead>
			<tr>
				<th>SL</th>
				<th>Challan No</th>
				<th>Challan Date</th>
				<th>Item Code</th>
				<th>Item Description</th>
				<th>Unit</th>
				<th>Quantity(BAG)</th>
				<th>Total Weight</th>
<?php /*?>				<th>Unit Price</th>
				<th>Total Amt</th><?php */?>
			</tr>
		</thead>
       
		<tbody>

   <? 
 $res='SELECT c.chalan_no, c.chalan_date, c.item_id,c.unit_price,c.qty_bag,c.total_unit,c.total_amt,i.item_name,i.unit_name,i.secondary_unit_name FROM sale_do_chalan c,item_info i WHERE c.do_no = '.$do_no.' and c.item_id=i.item_id  group by c.chalan_no';
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>
<td><?=$data->chalan_no?></td>
<td><?=$data->chalan_date?></td>
<td><?=$data->item_id?></td>
<td><?=$data->item_name?></td>
<td align="center"><?=$data->unit_name?></td>
<td align="right">(<?=$data->secondary_unit_name?>) <?=$data->qty_bag; $tot_total_bag+=$data->qty_bag;?> </td>
<td align="right"><?=number_format($data->total_unit,2); $tot_total_unit+=$data->total_unit;?></td>
<?php /*?><td align="right"><?=number_format($data->unit_price,2);?></td>
<td align="right"><?=$data->total_amt; $tot_total_amt+=$data->total_amt;?></td><?php */?>

</tr>
        
        <?  } ?>
        <tr>
			<td colspan="6"  align="right" style="text-align:right;"><strong>  Sub Total</strong></td>
			<td  align="right" style="text-align:right;"><strong> <?=number_format($tot_total_bag,2);?></strong></td>
			<td  align="right" style="text-align:right;"><strong> <?=number_format($tot_total_unit,2);?></strong></td>
<?php /*?>			<td></td>
			<td  align="right" style="text-align:right;"><strong> <?=number_format($tot_total_amt,2);?></strong></td><?php */?>
		</tr>
		
<?php /*?>		<tr>
			<td colspan="6"  align="right" style="text-align:right;"><strong> Total Amt</strong></td>
			<td></td>
			<td></td>
			<td></td>
			<td  align="right" style="text-align:right;"><strong> <?=number_format($tot_total_amt,2);?></strong></td>
		</tr><?php */?>
			</tbody>
		
    </table>
	

	<p class="p bold">In Words : 
		<? $scs =  $tot_total_amt;
					$credit_amt = explode('.',$scs);
	
		 if($credit_amt[0]>0){
		  echo convertNumberToWordsForIndia($credit_amt[0]);}
	
			 if($credit_amt[1]>0){
			 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
			 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';
								 }
		  echo ' Only.';
		  
		?> 
		
		</p>
	
</div>






</div>

</body>
</html>
