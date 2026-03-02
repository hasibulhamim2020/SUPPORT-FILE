<?php
session_start();

//var_dump($_SESSION);

require_once "../../../controllers/routing/print_view.top.php";
// require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));




$destination_count= find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$referance_count= find_a_field('sale_do_chalan','COUNT(referance)','chalan_no="'.$chalan_no.'" and referance!=""');
$sku_no_count= find_a_field('sale_do_chalan','COUNT(sku_no)','chalan_no="'.$chalan_no.'" and sku_no!=""');
$pack_type_count= find_a_field('sale_do_chalan','COUNT(pack_type)','chalan_no="'.$chalan_no.'" and pack_type!=""');
$color_count= find_a_field('sale_do_chalan','COUNT(color)','chalan_no="'.$chalan_no.'" and color!=""');
$size_count= find_a_field('sale_do_chalan','COUNT(size)','chalan_no="'.$chalan_no.'" and size!=""');

$do_no= find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);

$master= find_all_field('sale_do_master','','do_no='.$do_no);

$group_data = find_all_field('user_group','group_name','id='.$master->group_for);

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
<?php /*?>div.page_brack
{
    page-break-after:always;
}<?php */?>



@font-face {
  font-family: 'MYRIADPRO-REGULAR';
  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */

}

@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}


@font-face {
  font-family: 'Humaira demo';
  src: url('Humaira demo.otf'); /* IE9 Compat Modes */

}

@media print {
  .brack {page-break-after: always;}
}


#pr input[type="button"] {
    width: 70px;
    height: 25px;
    background-color: #6cff36;
    color: #333;
    font-weight: bolder;
    border-radius: 5px;
    border: 1px solid #333;
    cursor: pointer;
}

@page {
		
		@bottom-center {
		  content: "Page " counter(page) " of " counter(pages);
		}
  }


</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" style="width:100%;" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:18px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>
								<p style="font-size:12px; font-weight:300; color:#000000; margin:0; padding:0;">Phon No. : <?=$group_data->mobile?>,  Email : <?=$group_data->email?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					  <tr>
					  
					  <?php /*?><td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  </tr>
					  
					  <tr>
					  
					  <td><span style="font-size:14px; padding: 3px 0 0 10px; letter-spacing:7px;"><?=$chalan_no?></span></td><?php */?>
					  <td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($chalan_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/acc_mod/sales_invoice/invoice_print_view.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
					  
					  
					  
					  </tr>
					  </table>						</td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">INVOICE SUBMISSION </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="13%" align="left" valign="middle" style="font-size:12px; font-weight:700;">Customer Name</td>
		          <td width="30%" style="font-size:12px; font-weight:700;">:	&nbsp;
		            <?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td width="10%">Job No </td>
	              <td width="18%">: &nbsp;<?=$ch_data->job_no;?></td>
	              <td width="16%">Driver Name </td>
	              <td width="13%">: &nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Address</td>
		          <td>:	&nbsp;
		            <?= find_a_field('dealer_info','address_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>Challan No </td>
	              <td>: 
	                &nbsp;<?=$ch_data->chalan_no;?></td>
	              <td>Driver Contact </td>
	              <td>: &nbsp;<?=$ch_data->driver_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Contact Person</td>
		          <td>:	&nbsp;
                    <?= find_a_field('dealer_info','contact_person','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>Challan Date </td>
	              <td>: &nbsp;<?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>: &nbsp;<?=$ch_data->delivery_man;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Mobile No </td>
		          <td>:	&nbsp;
	              <?= find_a_field('dealer_info','mobile_no','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>Gate Pass </td>
	              <td>: &nbsp;<?php echo $ch_data->chalan_no;?></td>
	              <td>Delivery Man Mobile </td>
	              <td>: &nbsp;<?=$ch_data->delivery_man_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Point</td>
		           <td>: &nbsp;
	                <?=$ch_data->delivery_point;?></td>
	              <td>Vehicle No </td>
	              <td>: &nbsp;<?=$ch_data->vehicle_no;?></td>
	              <td>Receiver Name </td>
	              <td>: &nbsp;<?=$ch_data->rec_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>Receiver Mobile </td>
		          <td>: &nbsp;<?=$ch_data->rec_mob;?></td>
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
      
      <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000" class="tabledesign"  style="font-size:12px">
        <tr>
          <th width="4%" bgcolor="#CCCCCC">SL</th>
          <th width="9%" bgcolor="#CCCCCC">Item Code </th>
          <th width="37%" bgcolor="#CCCCCC">Item Description </th>
          <th width="9%" bgcolor="#CCCCCC">Unit</th>
          <th width="10%" bgcolor="#CCCCCC">Quantity</th>
          <th width="10%" bgcolor="#CCCCCC">U-Price</th>
          <th width="21%" bgcolor="#CCCCCC">Amount</th>
        </tr>
        <? 

   
 $res='select  s.item_id,i.item_name,s.unit_price, sum(s.total_unit) as total_unit,sum(s.total_amt) as total_amt

 from sale_do_chalan s,item_info i
 
 WHERE s.item_id=i.item_id and s.chalan_no='.$chalan_no.' group by s.id';
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>
          <td><?=$i++?></td>
          <td><?=$data->item_id?></td>
          <td><?=$data->item_name?></td>
          <td style="text-align:Center"><?=find_a_field('item_info','unit_name','item_id="'.$data->item_id.'"')?></td>
          <td  style="text-align:right"><?=$data->total_unit?></td>
          <td style="text-align:right"><?=$data->unit_price?></td>
          <td style="text-align:right"><?=$data->total_amt?></td>
        </tr>
        <?
		
$total_quantity = $total_quantity + $data->total_unit;
$total_bag_size = $total_bag_size + $data->bag_size;

$total_amount = $total_amount + $data->total_amt;

		 }
		
		?>
        <tr>
          <td colspan="3"><div align="right"><strong>Total:</strong></div></td>
          <td>&nbsp;</td>
          <td  style="text-align:right"><strong>
            <?=number_format($total_quantity,0);?>
          </strong></td>
          <td></td>
          <td style="text-align:right"><strong>
              <?=number_format($total_amount,3);?></td>
        </tr>
        <?php if($master->discount>0){ ?>
        <tr>
          <td colspan="6"><div align="right"><strong>Discount(
            <?=$master->discount?>
            %):</strong></div></td>
          <td><strong>
            <?=number_format($nit_discount=$master->discount/100*$total_amount,2);?>
            <? $tot_amt_after_discount = $total_amount-$nit_discount; ?>
          </strong></td>
        </tr>
		<?php } ?>
		<?php if($master->vat>0){ ?>
        <tr>
          <td colspan="6"><div align="right"><strong>VAT(
                  <?=$master->vat?>
            %):</strong></div></td>
          <td style="text-align:right"><strong>
            <?=number_format($nit_vat=$master->vat/100*$total_amount,2);?>
          </strong></td>
        </tr>
        <?php } ?>
        <?php if($ch_data->transport_cost>0){ ?>
        <tr>
          <td colspan="6"><div align="right"><strong>Transport Cost:</strong></div></td>
          <td><strong>
            <?=number_format($trans_cost=$ch_data->transport_cost,2);?>
          </strong></td>
        </tr>
        <?php } ?>
        <?php

$grand_total=($total_amount-$nit_discount)+$nit_vat+$ch_data->transport_cost;
?>
        <tr>
          <td colspan="6"><div align="right"><strong> Grand Total:</strong></div></td>
          <td style="text-align:right"><strong>
            <?=number_format($grand_total,2);?>
          </strong></td>
        </tr>
        <?php /*?><tr>
          <td colspan="6"><div align="right"><strong>Last Closing Balance:</strong></div></td>
          <?
$dealer_codes=find_a_field('dealer_info','account_code','dealer_code="'.$master->dealer_code.'"');


$jv_id=find_a_field('journal','jv_no','tr_no="'.$ch_data->chalan_no.'" and tr_from="Sales"');

$c_b=find_a_field('journal','sum(dr_amt-cr_amt)','jv_no < "'.$jv_id.'" and ledger_id="'.$dealer_codes.'"'); //jjv_date < "'.$ch_data->chalan_date.'" and change by kamrul 18-01-22



 $total_pay=$grand_total+$c_b;
		
		?>
          <td><strong>
            <? if($c_b > 0 ) { echo number_format($c_b,2)." Dr"; } elseif ($c_b < 0 ) { echo number_format(($c_b * (-1)),2)." Cr";  } else echo"0.00";  ?>
          </strong></td>
        </tr>
        <tr>
          <td colspan="6"><div align="right"><strong>Receivable Amount:</strong></div></td>
          <td><strong>
            <? if($total_pay > 0 ) { echo number_format($total_pay,2)." Dr"; } else { echo number_format(($total_pay * (-1)),2)." Cr";  }  ?>
          </strong></td>
        </tr><?php */?>
        <tr style="font-size:16px; font-weight:500; letter-spacing:.3px;">
          <td colspan="7">In Word:
            <?

		

		$scs =  $grand_total;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}

	 echo ' Only';

		?>. </td>
        </tr>
      </table></td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  </tr>
  

  
  
  
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	<form method="post">
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
		  <td colspan="4"><div align="center"><input type="submit" name="invoice_submit" id="invoice_submit" value="Invoice Submit" /></div></td>
		  </tr>
	
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  
			<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
			
				<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
	
	
	</table></form>
	

	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
  </tbody>
</table>


</div>
<div class="brack">&nbsp;</div>




</body>
</html>
