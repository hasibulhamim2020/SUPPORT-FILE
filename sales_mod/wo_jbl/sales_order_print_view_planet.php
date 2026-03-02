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
	<style>
	.header-one .row .center{
    width: 50%;
    float: right;
    padding-right: 0px;
    padding-left: 10%;
}

	.center .center-text {
    font-weight: bold;
    border: 1px solid black;
    margin: 0px;
    padding: 2px;
}
	</style>
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
		<h5 class="report-titel">Invoice /DO</h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			<p class="left-text mt-1 mb-1">&nbsp; <span></span></p>
			<p class="left-text mt-1 mb-1">Customer ID: <span> <?=$dealer->id;?>  </span></p>
			<p class="left-text mt-1 mb-1">Customer Name: <span><?=$dealer->dealer_name_e;?> </span></p>
			<p class="left-text mt-1 mb-1">Address: <span><?php echo $dealer->address_e?> </span></p>
			<p class="left-text mt-1 mb-1">Mobile Number: <span><?php echo $dealer->contact_no?> </span></p>
<!--			<p class="left-text mt-1 mb-1">VAT No: <span> <?php echo $dealer->vat_no?></span></p>
			<p class="left-text mt-1 mb-1">C.R No: <span> <?php echo $dealer->cr_no?></span></p>-->
		</div>


		<div class="col-md-6 col-sm-6 col-lg-6 right">

			<p class="right-text mt-1 mb-1">SO Date: <span> <?=date("j-M-Y",strtotime($master->do_date));?> </span></p>
			<p class="right-text mt-1 mb-1"> Invoice No: <span> <?php echo $master->do_no?> </span></p>
			<!--<p class="right-text mt-1 mb-1">JOB  No: <span><?php echo $master->job_no?></span></p>-->
			<p class="right-text mt-1 mb-1">Warehouse Name: <span> name</span></p>
			<p class="right-text mt-1 mb-1">FO Name: <span> name</span></p>
			<p class="right-text mt-1 mb-1">FO Mobile Number: <span> 000000000000</span></p>
			
			
			
		</div>
	</div>
	
		<div class="row">

		<div class="col-md-4 col-sm-4 col-lg-4 left">
			<p class="left-text mt-1 mb-1" align="center">Limit (TK)- <span>100000000</span></p>
		</div>

		<div class="col-md-4 col-sm-4 col-lg-4 center">
			<p class="center-text mt-1 mb-1"  align="center">Customer Target QTY (kg)- <span>1000</span></p>		
		</div>
		
		<div class="col-md-4 col-sm-4 col-lg-4 right">
			<p class="right-text mt-1 mb-1"  align="center">Sales Type - <span>Cash / Credit</span></p>		
		</div>
	</div>

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
				<th>MRP Price</th>
				<th>Quantity</th>
				<th>Gross Price</th>
				<th>Commission % </th>
				<th>Discount</th>
				<th>Sub Total</th>
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

<td><?=$i++?></td>

<td><?=$data->item_id?></td>
<td><?=$data->item_name?></td>
<td  align="center"><?=$data->unit_name?></td>
<td align="right"><?=$data->unit_price?></td>
<td  align="right"><?=$data->dist_unit?></td>
<td align="right"><?=($data->total_unit*$data->m_price)?></td>
<td align="right"><?=(int)find_a_field('sale_do_details','discount_per','id='.$data->id);?> %</td>
<td align="right"><?=find_a_field('sale_do_details','discount_amt','id='.$data->id);?></td>
<td  align="right"><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></td>
</tr>
        
        <?  } ?>
        <tr>
			<td colspan="9"  align="right" style="text-align:right;"><strong>  Total Gross Amount</strong></td>
			<td  align="right" style="text-align:right;"><strong> <?=number_format($tot_total_amt,2);?></strong></td>
		</tr>

<tr >
          <td colspan="9"  align="right" style="text-align:right;"><strong> Commission (<?=$master->discount;?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  
		  <strong>
 <?
 $disc_check = find_a_field('sale_do_discount','discount_amt','tr_type = "slab" and do_no='.$do_no);
 if($disc_check >0){
	echo number_format($discount_amt=$disc_check,2);
 }else{
	echo number_format($discount_amt= ($tot_total_amt*$master->discount)/100,2);
 }
  ?>
 
 <? $tot_amt_after_discount = $tot_total_amt-$discount_amt; ?>
</strong>		  </td>
        </tr>

        <tr>
			<td colspan="9"  align="right" style="text-align:right;"><strong> Sub Total</strong></td>
			<td  align="right" style="text-align:right;"><strong> 000.00</strong></td>
		</tr>
		<tr>
			<td colspan="9"  align="right" style="text-align:right;"><strong>  Transport</strong></td>
			<td  align="right" style="text-align:right;"><strong> 0.00</strong></td>
		</tr>
		
		<tr>
			<td colspan="9"  align="right" style="text-align:right;"><strong>  Special Discount (1)</strong></td>
			<td  align="right" style="text-align:right;"><strong> 0.00</strong></td>
		</tr>
		
		<tr>
			<td colspan="9"  align="right" style="text-align:right;"><strong>  Special Discount (2)</strong></td>
			<td  align="right" style="text-align:right;"><strong> 0.00</strong></td>
		</tr>

        <tr >
          <td colspan="9"  align="right" style="text-align:right;"><strong> VAT (<?=$master->vat?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  	<strong>
			 <?=number_format($vat_amt= ($tot_amt_after_discount*$master->vat)/100,2); ?>
			</strong>		  </td>
        </tr>

        <tr >
          <td colspan="9"  align="right" style="text-align:right;"><strong> Invoice Amount </strong></td>
          <td  align="right" style="text-align:right;">
			  <strong> <?=number_format($invoice_amt= ($tot_amt_after_discount+$vat_amt),2); ?></strong>
		  </td>
        </tr>
		
		<tr>
			<td colspan="9"  align="right" style="text-align:right;"><strong>  Total QTY(Kg)</strong></td>
			<td  align="right" style="text-align:right;"><strong> 0.00</strong></td>
		</tr>
		
			</tbody>
    </table>
	

	<p class="p bold">In Words : 
		<? $scs =  $invoice_amt;
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
	
	<br>
		<p class="p" align="center" style=" border: 1px solid #333; "><strong>Remarks : </strong> Sales of feed 150 kg deposit 1000 Taka Nagad, 500 Taka Ibbl	</p><br>
	<div class="row">

		<div class="col-md-4 col-sm-4 col-lg-4 left" >
			<table width="100%" style=" border: 1px solid #333; ">
				<tr>
					<td width="70%">Opening Balance</td>
					<td width="30%">: 000.000</td>
				</tr>
				<tr>
					<td width="70%">Add: invoice Amount</td>
					<td width="30%">: 000.000</td>
				</tr>
				
				<tr style=" border: 1px solid #000; ">
					<td width="70%"><strong>Total -</strong></td>
					<td width="30%"><strong>: 000.000</strong></td>
				</tr>
				<tr>
					<td width="70%">Less Collection-</td>
					<td width="30%">: 000.000</td>
				</tr>
				<tr>
					<td width="70%">Opening Balance</td>
					<td width="30%">: 000.000</td>
				</tr>
				
			</table>

		</div>

		<div class="col-md-4 col-sm-4 col-lg-4 center">
			<table width="100%" style=" border: 1px solid #333; ">
				<tr>
					<td width="50%" style=" border: 1px solid #333; ">Payment</td>
					<td width="50%" style=" border: 1px solid #333; ">Amount</td>
				</tr>
				<tr>
					<td width="50%" style=" border: 1px solid #333; ">Ibbl</td>
					<td width="50%" style=" border: 1px solid #333; ">5000</td>
				</tr>
				
				<tr>
					<td width="50%" style=" border: 1px solid #333; ">Nagad</td>
					<td width="50%" style=" border: 1px solid #333; ">1000</td>
				</tr>
				<tr>
					<td width="50%" style=" border: 1px solid #333; ">DBBL</td>
					<td width="50%" style=" border: 1px solid #333; ">200</td>
				</tr>
				
				<tr>
					<td width="50%" style=" border: 1px solid #333; ">&nbsp;</td>
					<td width="50%" style=" border: 1px solid #333; ">&nbsp;</td>
				</tr>
				
			</table>		
		</div>
		
		<div class="col-md-4 col-sm-4 col-lg-4 right">
						<table width="100%" style=" border: 1px solid #333; ">
				<tr>
					<td width="70%">Current Month Sale QTY (kg)</td>
					<td width="30%">: 000.000</td>
				</tr>
				<tr>
					<td width="70%">Current Month Collection</td>
					<td width="30%">: 000.000</td>
				</tr>
				
				<tr style=" border: 1px solid #000; border-left:none; ">
					<td width="70%">&nbsp;</td>
					<td width="30%">&nbsp;</td>
				</tr>
				<tr>
					<td width="70%">Previoud Month Sales QTY</td>
					<td width="30%">: 000.000</td>
				</tr>
				<tr>
					<td width="70%">Previous Month Collection</td>
					<td width="30%">: 000.000</td>
				</tr>
				
			</table>	
		</div>
	</div>
	

	
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
		<tr>
			<td colspan="4"><?php include("../../../assets/template/report_print_buttom_content.php");?></td>
		</tr>
		  <!--<td colspan="4">  	
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
		  </td>-->
		  </tr>
	</table>

	  </div>
</div>

</body>
</html>
