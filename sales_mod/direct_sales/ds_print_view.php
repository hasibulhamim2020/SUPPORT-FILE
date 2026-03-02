<?php

require_once "../../../controllers/routing/print_view.top.php";




$oi_no 		= url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

  		  $barcode_content = $oi_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';

$datas=find_all_field('warehouse_other_issue','s','oi_no='.$oi_no);
$group = find_all_field('user_group','','id='.$datas->group_for);


$sql111="select b.* from warehouse_other_issue b where b.oi_no = '".$oi_no."'";
$data111=db_query($sql111);

$data=mysqli_fetch_object($data111);
$rec_frm=$data->vendor_name;
$requisition_from=$data->requisition_from;
$oi_date=$data->oi_date;
$entry_by = find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');


$sql1="select b.* from warehouse_other_issue_detail b where b.oi_no = '".$oi_no."'";
$data1=db_query($sql1);

$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;

$order_no[]=$info->order_no;
$qc_by=$info->qc_by;

$item_id[] = $info->item_id;
$rate[] = $info->rate;
$amount[] = $info->amount;

$unit_qty[] = $info->qty;
$unit_name[] = $info->unit_name;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>.: Local Sales :.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
</head>

<style>

.report-titel {
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); 
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    padding: 4px 25px;
    margin: 15px auto; 
    display: inline-block; 
    border-radius: 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); 
    letter-spacing: 1px;
    text-transform: uppercase;
	margin-left: 495px !important;
}


@media print {
    .report-titel {
       margin-left: 400px !important;
    }
}

.footer1{
	padding-top: 100px !important;
}
</style>

<body>
<div class="body">
	<div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> <?=$group->group_name?> </h2>			
				<p class="text"><?=$group->address?></p>
				<p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group_data->vat_reg?></p>
		</td>
		
		
		<?php /*?><td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?php echo $oi_no;?></p>
		</td><?php */?>
		
		
		<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($oi_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/sales_mod/direct_sales/ds_print_view.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
	
		
		</tr>
		 
		</table>
	</div>
	
	<div class="header-one">
	<hr class="hr">
		<h5 class="report-titel">DIRECT SALES</h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			<p class="p bold mt-1 mb-1"> LS No :	<span> <?php echo $oi_no;?></span></p>
			<p class="p bold mt-1 mb-1"> LS Date :	<span> <?=date("d M, Y",strtotime($oi_date))?></span></p>
			<p class="p bold mt-1 mb-1"> Customer Name : <span> <?php echo $rec_frm;?></span></p>
			<p class="p bold mt-1 mb-1"> Note : <span> <?php if (!empty($data->oi_subject)) {echo $data->oi_subject;} else {echo "N/A";}?> </span></p>
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
				<th>Net Amount</th>
			</tr>
		</thead>
       
		<tbody>
		       
<? for($i=0;$i<$pi;$i++){?>
      
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=$item_id[$i]?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="center" valign="top"><?=$unit_name[$i]?></td>
        <td align="right" valign="top"><?=$rate[$i]?></td>
        <td align="right" valign="top"><?=$unit_qty[$i]?></td>
        <td align="right" valign="top"><?=$amount[$i]; $t_amount = $t_amount + $amount[$i];?></td>
        </tr>
<? }?>

		<tr>
		    <td colspan="6" class="bold" align="right">Total Amount:</td>
			<td class="bold" align="right"><?=$t_amount?></td>
		</tr>
	
		</tbody>
		
    </table>
	

	<p class="p bold" style="margin-top: 5px !important;">In Words : 
		<? $scs =  $t_amount;
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
	
	
	
	

<!--<p class="p-text"> All goods are received in a good condition as per Terms </p>-->

	
</div>





<div class="footer1">
	<table class="footer-table">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <table style="width:100%; table-layout: fixed; border-collapse: collapse; margin-top:40px;">
  <tr>
    <td class="text-center">
	<? $sign_data = find_a_field('user_activity_management','sign','user_id='.$data->entry_by);
				
				if($sign_data != ''){
				?>
				<img src="<?=SERVER_UPLOAD?>user_signature/<?=$_SESSION['proj_id']?>/<?=$sign_data;?>" style="width:80px;" />
				<? }?>
      <p style="font-weight:600; margin: 0;"><?=$entry_by?></p>
      <p style="font-size:11px; margin: 0;"></p>
    </td>
    <td class="text-center">&nbsp;</td>
    <td class="text-center">&nbsp;</td>
  </tr>
  <tr>
    <td class="text-center">-------------------------------</td>
    <td class="text-center">-------------------------------</td>
    <td class="text-center">-------------------------------</td>
  </tr>
  <tr>
    <td class="text-center"><strong>Prepared By</strong></td>
    <td class="text-center"><strong>Reviewed By</strong></td>
    <td class="text-center"><strong>Approved By</strong></td>
  </tr>
</table>

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
