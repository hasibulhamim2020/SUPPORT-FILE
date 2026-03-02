<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// require_once ('../../../acc_mod/common/class.numbertoword.php');

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
  <title>Invoice View</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
  <?php include("../../../../public/assets/css/theme_responsib_new_table_report1.php");?>
  <style>
  	
	body {
    width: 1186px;
    margin: 0 auto;
    font-size: 16px;
}
@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}
/*.footer-table{
	margin-bottom: 200px !important;
}*/
@media print {
	body{
		
		font-size: 18px !important;
		width: 100% !important;
	 }
}
	
  </style>
</head>
<body style="font-family: Poppins, serif; ">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td width="20%" class="logo"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/></td>
        <td width="60%" align="center">
				<p style="font-size:28px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';">  <?=$group_data->group_name?> </h2>			
				<p style="font-size:16px; font-weight:300; color:#000000; margin:0; padding:0;"><?=$group_data->address?></p>
				<p style="font-size:14px; font-weight:400; color:#000000; margin:0; padding:0;"><strong>Cell: </strong><?=$group_data->mobile?>. <strong>Email: </strong><i><?=$group_data->email?> </i><br> <strong><?=$group_data->vat_reg?></strong></p>
		</td>
        <td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode mt-4" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p style="font-size:14px; padding: 2px 0px 0px 183px; letter-spacing:7px;"><?php echo $master->do_no;?></p>
		</td>
		
      </tr>
	 
    </table>      </td>
  </tr>
   <tr><td><hr class="hr mt-1 mb-1"/></td></tr>
  </thead>
  <tbody>
  <tr>
    <td>
	<table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td>
		<h5 class="text-center font-weight-bold mt-0 ml-0 mb-2  ">SALES ORDER</h5>
		<!--<hr class="hr1 w-25">-->
		</td>
      </tr>
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="2" border="0" >
          <tr>
            <td width="35%">
				<table>
				<tr>
				
				<td width="32%"><strong>SO No </strong></td>
					<td width="68%"> : <strong><?php echo $master->do_no?></strong></td>
				</tr>
				<tr>
					<td width="32%">Customer </td>
					<td width="68%"> : <?=$dealer->dealer_name_e;?></td>
				</tr>
				<tr>
					<td>VAT No </td>
					<td> : <?php echo !empty($dealer->vat_no) ? $dealer->vat_no : 'N/A'; ?></td>
				</tr>
				<tr>
					<td>C.R No</td>
					<td>:  <?php echo !empty($dealer->cr_no) ? $dealer->cr_no : 'N/A';?></td>
				</tr>
				</table>
			
				
				
            <td width="30%"></td>
            <td width="35%" >
				<table width="100%" cellspacing="0" cellpadding="2" border="0">
				
				<tr>
					<td width="35%">SO Date</td>
					<td width="65%">: <?=date("j-M-Y",strtotime($master->do_date));?></td>
				</tr>
				<tr>
					<td >JOB  No</td>
					<td >: <?php echo $master->job_no?></td>
				</tr>
				<tr>
					<td >Contact No</td>
					<td>: <?php echo $dealer->contact_no?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td>: <?php echo $dealer->address_e?></td>
				</tr>
				
				</table>
			</td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onClick="hide();window.print();" value="Print" />
          </p>	    
		  </div>
      </div>
			<table class="table1">
		<thead>
			<tr>
				<th>SL</th>
				<th class="w-8">Item Code</th>
				<th class="text-left">Item Name</th>
				<th>Unit</th>
				<th>Unit Price</th>
				<th>QTY</th>
				<th>MRP</th>
				<th>Discount % </th>
				<th>Discount</th>
				<th>Net Amt</th>
			</tr>
		</thead>
       
		<tbody>
        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, a.*,b.m_price
   from sale_do_details a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.do_no='.$do_no.' order by a.id ';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td class="text-center"><?=$i++?></td>

<td class="w-10"><?=$data->item_id?></td>
<td class="w-20"><?=$data->item_name?>

		<?

		   $gsql = 'select g.offer_name,d.* from sale_gift_offer g, sale_do_details d where g.id=d.gift_id and d.item_id="'.$data->item_id.'" and d.do_no="'.$data->do_no.'"';
		$gquery = db_query($gsql);
		while($qdata=mysqli_fetch_object($gquery)){
		echo '<span style="color:green;"><b>[Offer-'.$qdata->offer_name.']</b></span>';
		}
		?>
</td>
<td  align="center"><?=$data->unit_name?></td>
<td align="right"><?=number_format($data->unit_price,5)?></td>
<td  align="right" class="text-center"><?=$data->total_unit?></td>
<td align="right" class="w-8"><?=($data->total_unit*$data->m_price)?></td>
<td align="right" class="w-9"><?=(int)find_a_field('sale_do_details','discount_per','id='.$data->id);?> %</td>
<td align="right" ><?=find_a_field('sale_do_details','discount_amt','id='.$data->id);?></td>
<td  align="right"><strong><?=find_a_field('currency_type','icon','currency_type="BDT"');?></strong><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></td>
</tr>
        
        <?  } ?>
        <tr>
			<td colspan="9"  align="right" style="text-align:right;"><strong>  Sub Total</strong></td>
			<td  align="right" style="text-align:right;"><strong> <?=find_a_field('currency_type','icon','currency_type="BDT"');?> <?=number_format($tot_total_amt,5);?></strong></td>
		</tr>

<tr >
          <td colspan="9"  align="right" style="text-align:right;"><strong> Discount (<?=$master->discount;?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  
		  <strong>
 <?=find_a_field('currency_type','icon','currency_type="BDT"');?><?
 $disc_check = find_a_field('sale_do_discount','discount_amt','tr_type = "slab" and do_no='.$do_no);
 if($disc_check >0){
	echo number_format($discount_amt=$disc_check,5);
 }else{
	echo number_format($discount_amt= ($tot_total_amt*$master->discount)/100,5);
 }
  ?>
 
 <? $tot_amt_after_discount = $tot_total_amt-$discount_amt;
    $vat_amt= ($tot_total_amt*$master->vat)/100;
	$ait_amt= ($tot_total_amt*$master->ait)/100;
  ?>
</strong>		  </td>
        </tr>

        <tr>
          <td colspan="9"  align="right" style="text-align:right;"><strong> VAT (<?=$master->vat?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  	<strong>
			<?=find_a_field('currency_type','icon','currency_type="BDT"');?> <?=number_format($vat_amt,5); ?>
			</strong>		  </td>
        </tr>
		
		<tr>
          <td colspan="9"  align="right" style="text-align:right;"><strong> AIT (<?=$master->ait?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  	<strong>
			 <?=find_a_field('currency_type','icon','currency_type="BDT"');?><?=number_format($ait_amt,5); ?>
			</strong>		  </td>
        </tr>

        <tr >
          <td colspan="9"  align="right" style="text-align:right;"><strong> Invoice Amount </strong></td>
          <td  align="right" style="text-align:right;">
		  <strong>
 <?=find_a_field('currency_type','icon','currency_type="BDT"');?><?=number_format($invoice_amt= ($tot_amt_after_discount+$vat_amt+$ait_amt),5); ?>
</strong>		  </td>
        </tr>
			</tbody>
    </table>
	</td>
      </tr>
      <tr>
        <td>
		<p class="p  mt-2 mb-2"><strong>In Words :</strong> 
		 
		<?php
$currency_type = 'taka'; // Set this to 'taka' or 'dollar' based on user input

$scs =  $invoice_amt;
$credit_amt = explode('.',$scs);

if($credit_amt[0]>0){
    echo convertNumberToWordsForIndia($credit_amt[0]);
    echo ' ' . ($currency_type == 'taka' ? 'Taka' : 'Dollars');
}

if($credit_amt[1]>0){
    if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
    echo ' & ' . convertNumberToWordsForIndia($credit_amt[1]);
    echo ' ' . ($currency_type == 'taka' ? 'Paisa' : 'Cents');
}

echo ' Only.';
?>
		
	</p>
	
		</td>
      </tr>
      <tr>
        <td >
		<table width="100%" cellspacing="0" cellpadding="7" border="1" class="mb-2">
			<tr>
				<td><p class=" mb-1 ml-1 mt-1"><strong>Remarks: </strong>Good Products</p>
				

			</tr>
		</table></td>
      </tr>
    
				</table>		  
			</td>
	   </tr>

    </table></td>
  </tr>
  <tr>
  <td><p class="p-text mt-2 mb-5">	Thanking You, </p></td>
  </tr>
 <? 
		$discSql = 'select * from sale_do_discount where 1 and do_no='.$do_no;
		$discQuery = db_query($discSql);
		if(mysqli_num_rows($discQuery)>0){
	?>
	<table class="table1  table-striped table-bordered table-hover table-sm ">
                <thead class="thead1">
                <tr class="bgc-info">
						<th>ID</th>
						<th>Offer Name</th>
						<th>Product Type</th>
						<th>Item Name</th>
						<th>Bill amount over</th>
						
						<th>Bill Period</th>
						<th>Period Days</th>
						<th>Start Date</th>
						<th>End Date</th>
						
						<th>Condition check</th>
						<th>Discount on</th>
						<th>Discount Level</th>
						<th>Base Discount</th>
						
						<th>Additional Discount Rate</th>
						<th>Additional Discount amount (BDT)</th>
						<th>Addional Discount Apply from</th>
						<th>Addional Discount Apply from amount</th>
						
						<th>Start Date</th>
						<th>End Date</th>
						<th>Party Type</th>
						<th>Party Name</th>
                </tr>
                </thead>

                <tbody class="tbody1">
				
				<?  
					while($discData=mysqli_fetch_object($discQuery)){
						$discIdIn[]=$discData->discount_id;
					}
					$discIdIn=implode(',',$discIdIn);
					$sql='select s.* from sale_gift_offer_slab s where s.id in ('.$discIdIn.')';

					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){
				?>

               <tr>
					<td><?=$data->id?></td>
					<td style="text-align:left"><?=$data->offer_name?></td>
					<td><?=$data->sub_group_id?></td>
					<td style="text-align:left"><?=$data->item_id?></td>
					<td><?=$data->bill_amount_over?></td>
					<td><?=$data->bill_period?></td>
					
					
					<td><?=$data->period_days?></td>
					<td style="text-align:left"><?=$data->p_start_date?></td>
					<td><?=$data->p_end_date?></td>
					<td><?=$data->condition_check?></td>
					
					<td><?=$data->discount_on?></td>
					<td><?=$data->discount_level?></td>
					<td><?=$data->base_discount?></td>
					<td><?=$data->additional_discount?></td>
					
					<td><?=$data->additional_discount_amt?></td>
					<td><?=$data->additional_discount_from?></td>
					
					<td><?=$data->additional_discount_apply_from_amt?></td>
					<td><?=$data->start_date?></td>
					<td><?=$data->end_date?></td>
					<td><?=$data->dealer_type?></td>
					<td><?=$data->dealer_code?></td>
					
				</tr>
					<? }?>
                </tbody>
            </table>				
       <? } ?>

	<table class="footer-table">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
          <td class="text-center w-25"> <?php $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>
		   
		  <p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?> </p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$master->entry_by);?>) <br/> <?=$master->entry_at?></p>
		  </td>
		  <td class="text-center w-25"> <?php $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>
		   
		  <p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?> </p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$master->entry_by);?>) <br/> <?=$master->entry_at?></p>
		  </td>
          
        </tr>
        <tr>
          <td class="text-center w-50">--------------------</td>
         
           <td class="text-center w-50">--------------------</td>
        </tr>
        <tr>
          <td class="text-center "><strong>Sales Officer</strong></td>
          
          <td class="text-center"><strong>Received By</strong></td>
        </tr>
	
	
	
		<tr>
		<tr>
			<td colspan="4"><?php //include("../../../../assets/template/report_print_buttom_content.php");?></td>
		</tr>
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
	<?php /*?>	  <?php include("../../../controllers/routing/report_print_buttom_content.php");?><?php */?>
</table>
    <script>
        // JavaScript for page number counting
        function updatePageNumber() {
            var pageNumberElement = document.getElementById('footer');
            var totalPages = document.querySelectorAll('.pagedjs_page').length;

            pageNumberElement.textContent = 'Page ' + window.pagedConfig.pageCount + ' of ' + totalPages;
        }

        // Call the updatePageNumber function when the page is loaded and after printing
        window.onload = updatePageNumber;
        window.onafterprint = updatePageNumber;
    </script>
</body>
</html>