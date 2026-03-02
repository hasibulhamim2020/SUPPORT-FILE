<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no 		= $_REQUEST['v_no'];


$destination_count= find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$referance_count= find_a_field('sale_do_chalan','COUNT(referance)','chalan_no="'.$chalan_no.'" and referance!=""');
$sku_no_count= find_a_field('sale_do_chalan','COUNT(sku_no)','chalan_no="'.$chalan_no.'" and sku_no!=""');
$pack_type_count= find_a_field('sale_do_chalan','COUNT(pack_type)','chalan_no="'.$chalan_no.'" and pack_type!=""');
$color_count= find_a_field('sale_do_chalan','COUNT(color)','chalan_no="'.$chalan_no.'" and color!=""');
$size_count= find_a_field('sale_do_chalan','COUNT(size)','chalan_no="'.$chalan_no.'" and size!=""');

$do_no= find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);

$master= find_all_field('sale_do_master','','do_no='.$do_no);


$ch_data= find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);



  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.*,b.do_date, b.group_for, b.via_customer from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;



$dealer = find_all_field_sql($ssql);
$entry_time=$dealer->do_date;


$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;



$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 



$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$master->job_no;?> - CH<?=$chalan_no;?></title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>
<style type="text/css">



<!--
.header table tr td table tr td table tr td table tr td {
	color: #000;
}

/*@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   color: white;
   text-align: center;
}
}*/
-->


div.page_brack
{
    page-break-after:always;   
}



</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$master->group_for?>.png" width="100%" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">First Copy For Goods Out</h4></td>
					  
					  </tr>
                      
					  
					  <tr>
					  
					  <td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  
					  </tr>
					  
					  <tr>
					  
					  <td><span style="font-size:14px; padding: 3px 0 0 10px; letter-spacing:7px;"><?=$chalan_no?></span></td>
					  
					  </tr>
					  </table>
							
						</td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            
          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td valign="top"></td>
  	  <td  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">
	  GATE PASS</span> </td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr>
		<td width="25%" valign="top"></td>
			<td width="50%" valign="middle" align="center"><strong>FSC CERTIFICATE CODE: SCS-COC-007014 </strong></td>
		<td width="25%" valign="right" align="right"><?php /*?><strong>Challan Date: <?=date("d M, Y",strtotime($ch_data->chalan_date))?><?php */?></strong></td>
	</tr>
	
	
	
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="10%" align="left" valign="middle">Customer Name</td>
		          <td width="31%">:	&nbsp;
                    <?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td width="7%">PO No </td>
	              <td width="9%">: &nbsp;<?=$master->customer_po_no;?></td>
	              <td width="9%">Challan No </td>
	              <td width="12%">: &nbsp;<?=$ch_data->chalan_no;?></td>
	              <td width="8%">Vehicle No </td>
	              <td width="14%">: &nbsp;<?=$ch_data->vehicle_no;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Place</td>
		          <td>:	&nbsp;
                    <?= find_a_field('delivery_place_info','delivery_place','id="'.$ch_data->delivery_place.'"');?></td>
	              <td>Job No </td>
	              <td>: &nbsp;<?=$master->job_no;?></td>
	              <td>Challan Date </td>
	              <td>: &nbsp;<?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Driver Name </td>
	              <td>: &nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Address </td>
		          <td>:	&nbsp;
                    <?= find_a_field('delivery_place_info','address_e','id="'.$ch_data->delivery_place.'"');?></td>
	              <td>Buyer</td>
	              <td>: &nbsp;<?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
	              <td>Gate Pass No </td>
	              <td>: &nbsp;<?=$ch_data->gate_pass;?></td>
	              <td>Driver Contact </td>
	              <td>: &nbsp;<?=$ch_data->driver_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">&nbsp;</td>
		          <td>&nbsp;</td>
	              <td><? if ($master->fsc_claim!=5) {?>FSC Status <? }?></td>
	              <td><? if ($master->fsc_claim!=5) {?>: &nbsp;<?= find_a_field('fsc_claim_type','fsc_claim','id="'.$master->fsc_claim.'"');?> <? }?></td>
	              <td>Gate Pass Date </td>
	              <td>: &nbsp;<?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>: &nbsp;<?= find_a_field('delivery_man','delivery_man','id="'.$ch_data->delivery_man.'"');?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">&nbsp;</td>
		          <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>Mobile No </td>
	              <td>: &nbsp;<?=$ch_data->delivery_man_mobile;?></td>
		        </tr>
				
				
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td colspan="7">&nbsp;</td>
		          </tr>
		        </table>		      </td>


			
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td><div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
          </p>
          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>	    </div>
      </div>
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:10px">
        
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO No </strong></td>
		  <? if ($destination_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Destination </strong></td><? }?>
		   <? if ($referance_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Referance</strong></td><? }?>
		  <? if ($sku_no_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SKU No</strong></td><? }?>
		  <? if ($pack_type_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pack Type</strong></td><? }?>
		  <? if ($color_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Color</strong></td><? }?>
		    <? if ($size_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Size</strong></td><? }?>
          <td width="14%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Measurement</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Ply</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>UOM</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Order Qty </strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Qty </strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Remarks</strong></td>
        </tr>
        
        <?    $sqlc = 'select c.order_no, c.item_name as ch_item_name, c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit,
		 c.total_unit as bundle_size, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.referance, c.style_no, c.po_no, c.destination,
		 c.sku_no,c.color,c.pack_type,c.size, c.paper_combination, c.L_cm, c.W_cm, c.H_cm, 
		 (c.pcs_1*c.bundle_1) as qty_1, c.pcs_1, c.bundle_1,  (c.pcs_2*c.bundle_2) as qty_2, c.pcs_2, c.bundle_2,  (c.pcs_3*c.bundle_3) as qty_3, c.pcs_3, c.bundle_3
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' group by c.id, c.total_unit order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:10px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
          <td align="left" valign="top">
		  <? 
		  if ($datac->style_no!="") {
		  echo $datac->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
          <td align="left" valign="top">
		   <? 
		  if ($datac->po_no!="") {
		  echo $datac->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
		   <? if ($destination_count>0) {?>
          <td align="left" valign="top"><?=$datac->destination;?></td><? }?>
		  <? if ($referance_count>0) {?>
          <td align="left" valign="top"><?=$datac->referance;?></td><? }?>
		  <? if ($sku_no_count>0) {?>
          <td align="left" valign="top"><?=$datac->sku_no;?></td><? }?>
		  <? if ($pack_type_count>0) {?>
          <td align="left" valign="top"><?=$datac->pack_type;?></td><? }?>
		  <? if ($color_count>0) {?>
          <td align="left" valign="top"><?=$datac->color;?></td><? }?>
		  <? if ($size_count>0) {?>
          <td align="left" valign="top"><?=$datac->size;?></td><? }?>
          <td align="center" valign="top"><? if($datac->L_cm>0) {?><?=$datac->L_cm?><? }?><? if($datac->W_cm>0) {?>X<?=$datac->W_cm?><? }?><? if($datac->H_cm>0) {?>X<?=$datac->H_cm?><? }?> <?=$datac->measurement_unit?></td>
          <td align="center" valign="top"><?=$datac->ply;?></td>
          <td align="center" valign="top"><?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?= find_a_field('sale_do_details','total_unit','id="'.$datac->order_no.'"');?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $grand_tot_unit1 +=$datac->total_unit; ?></td>
          <td align="center" valign="top">
		  (<? if($datac->qty_1>0) {?><?=$datac->pcs_1?>Pcs<strong>X</strong><?=$datac->bundle_1?>Bndl<? }?><? if($datac->qty_2>0) {?><strong>+</strong><?=$datac->pcs_2?>Pcs<strong>X</strong><?=$datac->bundle_2?>Bndl<? }?><? if($datac->qty_3>0) {?><strong>+</strong><?=$datac->pcs_3?>Pcs<strong>X</strong><?=$datac->bundle_3?>Bndl<? }?>) </td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:10px;">
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
		 <? if ($destination_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($referance_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($sku_no_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($pack_type_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		 <? if ($color_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($size_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit1,2) ;?></strong></td>
        <td align="center" valign="middle">&nbsp;</td>
        </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  

  
  
  <tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4" width="50%"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="4" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Summary</strong></td>
          </tr>
        <tr>
          <td width="5%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="46%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="20%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Bundle </strong></td>
          <td width="29%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Pcs </strong></td>
          </tr>
        
        <?  $sqlc = 'select s.sub_group_name, c.delivery_date, c.item_name as ch_item_name, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm,
		sum(c.bundle_1+c.bundle_2+c.bundle_3) as tot_bundle
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' group by c.item_id order by s.sub_group_id ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="center" valign="top"><?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
          <td align="center" valign="top"><?=number_format($datac->tot_bundle,2);  $tot_bundle_sum1 +=$datac->tot_bundle;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $tot_unit_sum1 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_bundle_sum1,2);?></strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum1,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">&nbsp;
		  	
		  </td>
        </tr>
		
		</table>
		
		</td>
</tr>
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center" >Prepared By</td>
		  <td align="center">Checked By</td>
		  <td align="center">Authorized By</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="left">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong><?= find_a_field('prepared_by','prepared_by','id='.$ch_data->prepared_by);?> </strong></td>
		    <td  align="center" width="25%"><strong>Security Guard</strong></td>
		    <td  align="center" width="25%"><strong>
		      <?= find_a_field('authorized_by','authorized_by','id='.$ch_data->authorized_by);?>
		    </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center"><?= find_a_field('prepared_by','designation','id='.$ch_data->prepared_by);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center"><?= find_a_field('authorized_by','designation','id='.$ch_data->authorized_by);?></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="3" align="center" style="font-size:12px">This is an ERP generated report </td>
		    </tr>
	
	<tr>
            <td colspan="3">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>
</div>


<div class="page_brack" >
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$master->group_for?>.png" width="100%" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Second Copy For Store</h4></td>
					  
					  </tr>
                      
					  
					  <tr>
					  
					  <td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  
					  </tr>
					  
					  <tr>
					  
					  <td><span style="font-size:14px; padding: 3px 0 0 10px; letter-spacing:7px;"><?=$chalan_no?></span></td>
					  
					  </tr>
					  </table>
							
						</td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            
          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td valign="top"></td>
  	  <td  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">
	  GATE PASS</span> </td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr>
		<td width="25%" valign="top"></td>
			<td width="50%" valign="middle" align="center"><strong>FSC CERTIFICATE CODE: SCS-COC-007014 </strong></td>
		<td width="25%" valign="right" align="right"><?php /*?><strong>Challan Date: <?=date("d M, Y",strtotime($ch_data->chalan_date))?><?php */?></strong></td>
	</tr>
	
	
	
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="10%" align="left" valign="middle">Customer Name</td>
		          <td width="31%">:	&nbsp;
                    <?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td width="7%">PO No </td>
	              <td width="9%">: &nbsp;<?=$master->customer_po_no;?></td>
	              <td width="9%">Challan No </td>
	              <td width="12%">: &nbsp;<?=$ch_data->chalan_no;?></td>
	              <td width="8%">Vehicle No </td>
	              <td width="14%">: &nbsp;<?=$ch_data->vehicle_no;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Place</td>
		          <td>:	&nbsp;
                    <?= find_a_field('delivery_place_info','delivery_place','id="'.$ch_data->delivery_place.'"');?></td>
	              <td>Job No </td>
	              <td>: &nbsp;<?=$master->job_no;?></td>
	              <td>Challan Date </td>
	              <td>: &nbsp;<?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Driver Name </td>
	              <td>: &nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Address </td>
		          <td>:	&nbsp;
                    <?= find_a_field('delivery_place_info','address_e','id="'.$ch_data->delivery_place.'"');?></td>
	              <td>Buyer</td>
	              <td>: &nbsp;<?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
	              <td>Gate Pass No </td>
	              <td>: &nbsp;<?=$ch_data->gate_pass;?></td>
	              <td>Driver Contact </td>
	              <td>: &nbsp;<?=$ch_data->driver_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">&nbsp;</td>
		          <td>&nbsp;</td>
	              <td><? if ($master->fsc_claim!=5) {?>FSC Status <? }?></td>
	              <td><? if ($master->fsc_claim!=5) {?>: &nbsp;<?= find_a_field('fsc_claim_type','fsc_claim','id="'.$master->fsc_claim.'"');?> <? }?></td>
	              <td>Gate Pass Date </td>
	              <td>: &nbsp;<?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>: &nbsp;<?= find_a_field('delivery_man','delivery_man','id="'.$ch_data->delivery_man.'"');?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">&nbsp;</td>
		          <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>Mobile No </td>
	              <td>: &nbsp;<?=$ch_data->delivery_man_mobile;?></td>
		        </tr>
				
				
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td colspan="7">&nbsp;</td>
		          </tr>
		        </table>		      </td>


			
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td>
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:10px">
        
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO No </strong></td>
		  <? if ($destination_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Destination </strong></td><? }?>
		   <? if ($referance_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Referance</strong></td><? }?>
		  <? if ($sku_no_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SKU No</strong></td><? }?>
		  <? if ($pack_type_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pack Type</strong></td><? }?>
		  <? if ($color_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Color</strong></td><? }?>
		    <? if ($size_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Size</strong></td><? }?>
          <td width="14%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Measurement</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Ply</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>UOM</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Order Qty </strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Qty </strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Remarks</strong></td>
        </tr>
        
        <?    $sqlc = 'select c.order_no,  c.item_name as ch_item_name, c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit,
		 c.total_unit as bundle_size, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.referance, c.style_no, c.po_no, c.destination,
		 c.sku_no,c.color,c.pack_type,c.size, c.paper_combination, c.L_cm, c.W_cm, c.H_cm, 
		 (c.pcs_1*c.bundle_1) as qty_1, c.pcs_1, c.bundle_1,  (c.pcs_2*c.bundle_2) as qty_2, c.pcs_2, c.bundle_2,  (c.pcs_3*c.bundle_3) as qty_3, c.pcs_3, c.bundle_3
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' group by c.id, c.total_unit order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:10px;">
          <td align="center" valign="top"><?=++$kk2;?></td>
          <td align="left" valign="top"><?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
          <td align="left" valign="top">
		  <? 
		  if ($datac->style_no!="") {
		  echo $datac->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
          <td align="left" valign="top">
		   <? 
		  if ($datac->po_no!="") {
		  echo $datac->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
		   <? if ($destination_count>0) {?>
          <td align="left" valign="top"><?=$datac->destination;?></td><? }?>
		  <? if ($referance_count>0) {?>
          <td align="left" valign="top"><?=$datac->referance;?></td><? }?>
		  <? if ($sku_no_count>0) {?>
          <td align="left" valign="top"><?=$datac->sku_no;?></td><? }?>
		  <? if ($pack_type_count>0) {?>
          <td align="left" valign="top"><?=$datac->pack_type;?></td><? }?>
		  <? if ($color_count>0) {?>
          <td align="left" valign="top"><?=$datac->color;?></td><? }?>
		  <? if ($size_count>0) {?>
          <td align="left" valign="top"><?=$datac->size;?></td><? }?>
          <td align="center" valign="top"><? if($datac->L_cm>0) {?><?=$datac->L_cm?><? }?><? if($datac->W_cm>0) {?>X<?=$datac->W_cm?><? }?><? if($datac->H_cm>0) {?>X<?=$datac->H_cm?><? }?> <?=$datac->measurement_unit?></td>
          <td align="center" valign="top"><?=$datac->ply;?></td>
          <td align="center" valign="top"><?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?= find_a_field('sale_do_details','total_unit','id="'.$datac->order_no.'"');?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $grand_tot_unit2 +=$datac->total_unit; ?></td>
          <td align="center" valign="top">
		  (<? if($datac->qty_1>0) {?><?=$datac->pcs_1?>Pcs<strong>X</strong><?=$datac->bundle_1?>Bndl<? }?><? if($datac->qty_2>0) {?><strong>+</strong><?=$datac->pcs_2?>Pcs<strong>X</strong><?=$datac->bundle_2?>Bndl<? }?><? if($datac->qty_3>0) {?><strong>+</strong><?=$datac->pcs_3?>Pcs<strong>X</strong><?=$datac->bundle_3?>Bndl<? }?>) </td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:10px;">
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
		 <? if ($destination_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($referance_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($sku_no_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($pack_type_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		 <? if ($color_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($size_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit2,2) ;?></strong></td>
        <td align="center" valign="middle">&nbsp;</td>
        </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  

  
  
  <tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4" width="50%"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="4" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Summary</strong></td>
          </tr>
        <tr>
          <td width="5%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="46%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="20%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Bundle </strong></td>
          <td width="29%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Pcs </strong></td>
          </tr>
        
        <?  $sqlc = 'select s.sub_group_name, c.delivery_date,  c.item_name as ch_item_name, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm,
		sum(c.bundle_1+c.bundle_2+c.bundle_3) as tot_bundle
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' group by c.item_id order by s.sub_group_id ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm2;?></td>
          <td align="center" valign="top"><?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
          <td align="center" valign="top"><?=number_format($datac->tot_bundle,2);  $tot_bundle_sum2 +=$datac->tot_bundle;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $tot_unit_sum2 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_bundle_sum2,2);?></strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum2,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">&nbsp;
		  	
		  </td>
        </tr>
		
		</table>
		
		</td>
</tr>
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center" >Prepared By</td>
		  <td align="center">Checked By</td>
		  <td align="center">Authorized By</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="left">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong><?= find_a_field('prepared_by','prepared_by','id='.$ch_data->prepared_by);?> </strong></td>
		    <td  align="center" width="25%"><strong>Security Guard</strong></td>
		    <td  align="center" width="25%"><strong>
		      <?= find_a_field('authorized_by','authorized_by','id='.$ch_data->authorized_by);?>
		    </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center"><?= find_a_field('prepared_by','designation','id='.$ch_data->prepared_by);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center"><?= find_a_field('authorized_by','designation','id='.$ch_data->authorized_by);?></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="3" align="center" style="font-size:12px">This is an ERP generated report </td>
		    </tr>
	
	<tr>
            <td colspan="3">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>
</div>

</body>
</html>
