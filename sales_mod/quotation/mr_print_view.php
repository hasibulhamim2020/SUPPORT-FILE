<?php

require_once "../../../controllers/routing/print_view.top.php";

$tr_type="Show";

$req_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));


//$req_no 		= $_REQUEST['do_no'];


	//barcode code start
	$req_bar_no = $req_no;
	$barcode_content = $req_bar_no;
	$barcodeText = $barcode_content;
    $barcodeType='code128';
	$barcodeDisplay='horizontal';
    $barcodeSize=40;
    $printText='';
	//barcode code end
	
$sql="select * from sale_requisition_master where  do_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);
$group_data = find_all_field('user_group','group_name','id='.$all->group_for);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

  <title>Quotation</title>
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
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> <?=$group_data->group_name?> </h2>			
				<p class="text"><?=$group_data->address?></p>
				<p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?></p>
		</td>
		
		
		<td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($req_no); 
			  //$tr_from = url_encode($tr_from); 
              $print_url = "https://saaserp.ezzy-erp.com/app/views/sales_mod/quotation/mr_print_view.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data). "&tr_from=" . rawurlencode($tr_from);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>

		
		</tr>
		 
		</table>
	</div>
	
	
	<div class="header-one">
	<hr class="hr">
		<h5 class="report-titel"><u>Sales Quotation</u></h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
		
			<p class="p bold">Quotation No : <span> Q-<?=$all->do_no?></span></p>
			<p class="p bold">Date :  <span><?=date('D , j \ F Y ' ,strtotime($all->do_date))?></span></p>
			<br />
			
			<p class="p bold">Dealer Name : <span><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$all->dealer_code)?> </span></p>
			<p class="p bold">Address : <span> <?=find_a_field('dealer_info','address_e','dealer_code='.$all->dealer_code); if(!empty($address)) {echo $address;} else{echo "N/A";}?> </span></p>
			<p class="p bold">Unit : <span> <?php if(!empty($all->unit)) {echo $all->unit;} else{echo "N/A";}?></span></p>

<!--<p class="p bold">ATTN : <span> <?=$all->attn?></span></p>
<p class="p bold">Requisition No : <span> <?=$all->ref_no?></span></p>
-->
		</div>

	</div>


	<p class="p-text">
		Dear Sir/Madam,
			<br>
		We are pleased to issue Quotation for the following goods/services as per below mentioned terms &amp; conditions:
			<br>
	</p>	

</div>


<div class="main-content">
	
	
	<div id="pr">
        <div align="left">
         	 <p> <input name="button" type="button" onclick="hide();window.print();" value="Print"> </p>    
		</div>
     </div>
	  
	  
	  
	<table class="table1">
		<thead>
			<tr>
				<th>SL</th>
<!--				<th class="w-8">Item Code</th>-->
				<th>Item Name</th>
				<th>Category</th>
				<th>Rate</th>
				<th>Quantity</th>
				<th>Total</th>
			</tr>
		</thead>
       
		<tbody>
				
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
 $sql2="select a.* from sale_requisition_details a  where  do_no='$req_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){
$pi++;
$sl=$pi;
$item=find_all_field('item_info','','item_id='.$info->item_id);
$brand = find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item->sub_group_id);
$ord_qty=$info->qty;
//$ord_bag=$ord_qty/$item->pakg_ctn_size;

$in_stock=$info->in_stock;

$tot_ord_qty +=$ord_qty;
$tot_ord_bag +=$ord_bag;


?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$item->item_name?></td>
        <td align="center" valign="top"><?=$brand?></td>
		
        <td align="right" valign="top"> <?=$info->unit_price?></td>
        <td align="right" valign="top"><?=number_format($info->total_unit);?> Pcs</td>
        <td align="right" valign="top"><?=number_format($info->total_amt,2); $tot_amt +=$info->total_amt; ?></td>
		<!--<td ><?=$info->delivery;?></td>-->
      </tr>
	  
	  <? }?>
	  
	  <tr>
	  	<td colspan="5" style="text-align:right"><strong>Total &nbsp;</strong></td>
		<td style="text-align:right"><?=number_format($tot_amt,2);?></td>
		
	  </tr>
	  <? if($all->discount >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right">Discount (<?=$all->discount?> %) &nbsp;</td>
		<td style="text-align:right"><?=number_format($discount_amt=($tot_amt * $all->discount) / 100,2);?></td>
		
	  </tr>
	  <? } ?>	  
	   <? if($all->cash_discount >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right">Deduct &nbsp;</td>
		<td style="text-align:right"><?=number_format($deduct_amt=$all->cash_discount,2);?></td>
		
	  </tr>
	  <? } ?>
	  
	  <tr>
	  	<td colspan="5" style="text-align:right"><strong>Sub Total  &nbsp;</strong></td>
		<td style="text-align:right"><?=number_format($sub_total_amt=($tot_amt  - ($discount_amt+$deduct_amt)),2);?></td>
		
	  </tr>
	  
	   <? if($all->vat >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right"><strong>VAT (<?=$all->vat?> %) &nbsp;</strong></td>
		<td style="text-align:right"><?=number_format($vat_amt=($sub_total_amt * $all->vat) / 100,2);?></td>
		
	  </tr>
	  <? } ?>
	  
	   <? if($all->ait >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right">AIT( <?=$all->ait?>%) &nbsp;</td>
		<td style="text-align:right"><?=number_format($ait_amt=($sub_total_amt * $all->ait) /100,2);?></td>
		
	  </tr>
	  <? } ?>
	  
	   <? if($all->vat_ait >0){ ?>
	  <tr>
	  	<td colspan="5" style="text-align:right">VAT & AIT(<?=$all->vat_ait?>%) &nbsp;</td>
		<td style="text-align:right"><?=number_format($vat_ait_amt=($sub_total_amt * $all->vat_ait)/100,2);?></td>
		
	  </tr>
	  <? } ?>
	  <tr>
	  	<td colspan="5" style="text-align:right"><b>Grand Total &nbsp;</b></td>
		<td style="text-align:right"><b><?=number_format($grand_amt=($sub_total_amt + ( $vat_amt + $ait_amt + $vat_ait_amt)),2);?></b></td>
		
	  </tr>

				
			</tbody>
		
    </table>
	

	<p class="p bold">In Words : 
		
				<? $scs =  $grand_amt;
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
	
	
	
<br />
	<table class="terms-table" id="terms">
			<tr>
			  <td colspan="4" class="terms-titel">Terms &amp; Condition : </td>
			</tr>
			<tr>
			<td colspan="4">
			<ul>
            <li>Validity: The Offer will be valid for only 7 (seven) days from the date here of.</li>
            <li>Payement Term: <?=$all->payment_terms?></li>
			<li>Quoted delivery subject to prior sale.</li>
			<li>Quoted prices are quantity bound.</li>
			<li>All payment should be made by accounts payee cheque or through bank</li>
			<? if($all->remarks !='') { 
						
						 $all->remarks;
						$array=explode("#",$all->remarks);
						$flag=count($array);
			
			
			if($flag!=0)
			{
			
			for($i=1;$i<$flag;$i++){
				echo '<li>'.$array[$i].'</li>';
			}
			
			}  } ?>
			</ul>
			 </td>
			</tr>
			
	</table>
		
	
</div>


<div class="footer1"  id="footer">
	<table class="footer-table">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
          <td class=" w-25">
		  <p>Yours sincerely</p>
		  <p class="bold p-0 m-0">
<?php $uid=find_a_field('sale_requisition_master','entry_by','do_no="'.$req_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>
		   </p>
		   <p class="bold p-0 m-0"><?=$all->quo_by?></p>
		  </td>
          <td class="text-center w-25">&nbsp;</td>
          <td class="text-center w-25">&nbsp;</td>
          <td class="text-center w-25">&nbsp;</td>
        </tr>
        <tr>
          <td class="text-center"> </td>
          <td class="text-center"> </td>
          <td class="text-center"> </td>
          <td class="text-center"> </td>
        </tr>
        <tr>
          <td class="text-center"><strong></strong></td>
          <td class="text-center"><strong> </strong></td>
          <td class="text-center"><strong> </strong></td>
          <td class="text-center"><strong> </strong></td>
        </tr>
		
		<tr>
			<td colspan="4"><?php include("../../../assets/template/report_print_buttom_content.php");?></td>
		
		</tr>
	
	
		<!--<tr>
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
		  </tr>-->
	</table>

	  </div>	
	
	

</div>


</body>
</html>


<?
$page_name="Sales Quotation";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>