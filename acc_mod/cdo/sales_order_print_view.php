<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$do_no 		= $_REQUEST['do_no'];

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
			<p class="qrl-text"><?php echo $master->do_no;?></p>
		</td>
		
		</tr>
		 
		</table>
	</div>
	
	<div class="header-one">
	<hr class="hr">
		<h5 class="report-titel">SALES ORDER</h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			<p class="left-text mt-1 mb-1"> SO No: <span> <?php echo $master->do_no?> </span></p>
			
			<p class="left-text mt-1 mb-1">Customer: <span><?=$dealer->dealer_name_e;?> </span></p>
							
			<p class="left-text mt-1 mb-1">VAT No: <span> <?php echo $dealer->vat_no?></span></p>
			<p class="left-text mt-1 mb-1">C.R No: <span> <?php echo $dealer->cr_no?></span></p>
		</div>

		<div class="col-md-6 col-sm-6 col-lg-6 right">

			<p class="right-text mt-1 mb-1">SO Date: <span> <?=date("j-M-Y",strtotime($master->do_date));?> </span></p>
			<p class="right-text mt-1 mb-1">JOB  No: <span><?php echo $master->job_no?></span></p>
			<p class="right-text mt-1 mb-1">Contact No: <span><?php echo $dealer->contact_no?> </span></p>
			<p class="right-text mt-1 mb-1">Address: <span><?php echo $dealer->address_e?> </span></p>
			
		</div>
	</div>


<!--	<p class="p-text">
		Dear Sir/Madam,
			<br>
		We are pleased to issue Purchase Order for the following goods/services as per below mentioned terms &amp; conditions:
			<br>
	</p>-->	

</div>


<div class="main-content">
	<br/>
	
	<div id="pr">
        <div align="left">
         	 <p> <input name="button" type="button" onClick="hide();window.print();" value="Print"> </p>    
		</div>
     </div>
	  
	  
	  
	<table class="table1">
		<thead>
			<tr>
				<th>SL</th>
				<th class="w-8">Item Code</th>
				<th>Item Name</th>
				<th>Unit</th>
				<th>Unit Price</th>
				<th>Quantity</th>
				<th>Net Amt</th>
			</tr>
		</thead>
       
		<tbody>
        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, a.*
   from sale_do_details a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.do_no='.$do_no.' order by a.id ';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>

<td><?=$data->item_id?></td>
<td><?=$data->item_name?></td>
<td  align="center"><?=$data->unit_name?></td>
<td align="right"><?=$data->unit_price?></td>
<td  align="right"><?=$data->dist_unit?></td>
<td  align="right"><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></td>
</tr>
        
        <?  } ?>
        <tr>
			<td colspan="6"  align="right" style="text-align:right;"><strong>  Sub Total</strong></td>
			<td  align="right" style="text-align:right;"><strong> <?=number_format($tot_total_amt,2);?></strong></td>
		</tr>

<tr >
          <td colspan="6"  align="right" style="text-align:right;"><strong> Discount (<?=$master->discount;?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  
		  <strong>
 <?=number_format($discount_amt= ($tot_total_amt*$master->discount)/100,2); ?>
 
 <? $tot_amt_after_discount = $tot_total_amt-$discount_amt; ?>
</strong>
		  </td>
        </tr>

        <tr >
          <td colspan="6"  align="right" style="text-align:right;"><strong> VAT (<?=$master->vat?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  	<strong>
			 <?=number_format($vat_amt= ($tot_amt_after_discount*$master->vat)/100,2); ?>
			</strong>
		  </td>
        </tr>

        <tr >
          <td colspan="6"  align="right" style="text-align:right;"><strong> Invoice Amount </strong></td>
          <td  align="right" style="text-align:right;">
		  <strong>
 <?=number_format($invoice_amt= ($tot_amt_after_discount+$vat_amt),2); ?>
</strong>		  </td>
        </tr>
		
			  
		
			</tbody>
		
    </table>
	

	<p class="p bold">In Words : 
		<? $scs =  $invoice_amt;
					$credit_amt = explode('.',$scs);
	
		 if($credit_amt[0]>0){
		  echo convertNumberToWordsForIndia($credit_amt[0]);}
	
			 if($credit_amt[1]>0){
			 if($credit_amt[1]<10) { $credit_amt[1] = $credit_amt[1]*10;
			 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';
								 }
		  echo ' Only.'; }
		  
		?> 
		
		</p>
	
	
	
	

<!--<p class="p-text"> The Vendor has agreed to provide the above goods/services to ERP COM BD agreed to accept the merchandise from the Vendor in the quantities, at the prices, at the time and subject to the terms, provisions and conditions stated below: </p>-->

<!--
	<table class="terms-table">
			<tr>
			  <td colspan="4" class="terms-titel">Terms &amp; Condition : </td>
			</tr>
			
			 <? 		
			$sql = 'select * from terms_condition_setup where type="PO" group by id order by sl_no';
				$tc_query=db_query($sql);
				while($tc_data= mysqli_fetch_object($tc_query)){
				?>		
			<tr style="letter-spacing:.3px; line-height: 16px;">
			  <td class="text-center w-5" ><?=++$id;?>.</td>
			  <td class="text-left w-95"><?=$tc_data->terms_condition;?></td>
			  </tr> 
			 <? }?>
	</table>
	
	<p class="p-text">	For <?=$group_data->group_name?>. </p>
	-->
	
</div>





<div class="footer"  id="footer">
	<table class="footer-table">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
          <td class="text-center w-25"> <?php $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>
		   
<?php /*?>		  <p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?> </p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$master->entry_by);?>) <br/> <?=$master->entry_at?></p><?php */?>
		  </td>
          <td class="text-center w-25">&nbsp;</td>
          <td class="text-center w-25">&nbsp;</td>
          <td class="text-center w-25">&nbsp;</td>
        </tr>
        <tr>
          <td class="text-center">-------------------------------</td>
          <td class="text-center"></td>
          <td class="text-center"></td>
          <td class="text-center">-------------------------------</td>
        </tr>
        <tr>
          <td class="text-center"><strong>Sales Officer</strong></td>
          <td class="text-center"><strong></strong></td>
          <td class="text-center"><strong></strong></td>
          <td class="text-center"><strong>Received By</strong></td>
        </tr>
	
	
	
		<tr>
		  <td colspan="4">  	
				<hr style="color:black;border:1px solid black;" />
				<table width="100%" cellspacing="0" cellpadding="0">
						<tr style=" font-size: 12px; font-weight: 500;">
							<td class="text-left w-33">Printed by: <?=find_a_field('user_activity_management','user_id','user_id='.$_SESSION['user']['id'])?></td>
							<td class="text-center w-33"><?=date("h:i A")?></td>
							<td class="text-right w-33"><?=date("d-m-Y")?></td>
						</tr>
						<tr>
						<td colspan="4" style="text-align: center;font-size: 11px;color: #444;"> This is an ERP generated report. That is Powered By www.erp.com.bd</td>
						</tr>
				</table>
		  </td>
		  </tr>
	</table>

	  </div>
</div>

</body>
</html>
