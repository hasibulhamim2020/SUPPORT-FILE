<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no 		= $_REQUEST['v_no'];

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="UTF-8">
<title><?=$chalan_no;?></title>
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


.style5 {font-weight: bold}
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header" style="margin-top:0;">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="40%">
                       		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:18px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name?></span></td>
							  </tr>
							  
							  
									<tr><td style="font-size:14px; line-height:24px;"><?=$group_data->description?></td>
									</tr>
									
									<tr>
									  <td style="font-size:14px; line-height:24px;"><?=$group_data->address?></td>
									</tr>
									<tr><td style="font-size:14px; line-height:24px;"><?=$group_data->cr_no?></td>
									</tr>
									
							  
							  <tr><td style=" font-size:14px; line-height:24px;"><?=$group_data->vat_reg?></td>
							  </tr>
						  </table>					    </td>
						  
						  <td width="20%">&nbsp; </td>
                        
                        <td width="40%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:22px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name_arabic;?>
									  </span></td>
							  </tr>
							  
							  
									<tr><td style="font-size:18px; line-height:24px;"><?=$group_data->description_arabic?></td>
									</tr>
									
									<tr>
									  <td style="font-size:18px; line-height:24px;"><?=$group_data->address_arabic?></td>
									</tr>
									<tr><td style="font-size:18px; line-height:24px;"><?=$group_data->cr_no_arabic?></td>
									</tr>
									
							  
							  <tr><td style=" font-size:18px; line-height:24px;"><?=$group_data->vat_reg_arabic?></td>
							  </tr>
						  </table>						  </td>                    </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
       </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  <tr><td>&nbsp;</td></tr>
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; "><span style="color:#FFF; font-size:18px; padding:8px 20px; color:#000000; font-weight:bold; border: 2px solid #000000; border-radius: 5px; ">
	  <?=$group_data->invoice_type?></span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
	  
	  <tr><td>&nbsp;</td></tr>
	 
  </table>
  
  </td></tr>
  
  
  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

		        

                  <tr>

		          <td width="40%" align="right" valign="middle"><span style="font-size:12px; font-weight:700;">Customer Name</span>: </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><span style="font-size:16px; font-weight:bold;" class="style8"><span style="font-size:12px; font-weight:700;">
		                <?=$dealer->dealer_name_e;?>
		              </span>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td align="right" valign="top"> Address:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td height="60" valign="top"><span style="font-size:16px; " class="style8"><?php echo $dealer->address_e?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

		        <tr>

                  <td align="right" valign="middle">VAT No:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                      <tr>

                        
						  <td><span style="font-size:16px; font-weight:bold;" class="style8"><span class="style8" style="font-size:16px; "><?php echo $dealer->vat_no?></span>&nbsp;</span></td>
                      </tr>

                  </table></td>
		          </tr>

                  <tr>
                    <td align="right" valign="middle">Mobile:</td>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                        <tr>
                          <td><span style="font-size:16px; font-weight:bold;" class="style8"><?php echo $dealer->mobile_no;?>&nbsp;</span></td>
                        </tr>
                    </table></td>
                  </tr>
                  
		        </table>		      </td>

			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			
			
			

			<tr>

			    <td align="right" valign="middle">Invoice Number :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><strong><?php echo $master->do_no?></strong>&nbsp;</td>
			        </tr>

			      </table></td>
			    </tr>
			

			  <tr>

			    <td align="right" valign="middle">Invoice Issue Date :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><span class="style5">
			          <?=date("j-M-Y",strtotime($master->do_date));?>
			        </span>&nbsp;</td>
			        </tr>

			      </table></td>
			    </tr>
				
				<tr>

			    <td align="right" valign="middle">Date of Supply :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><span class="style5">
			          <?=date("j-M-Y",strtotime($ch_data->chalan_date));?>
			        </span>&nbsp;</td>
			        </tr>

			      </table></td>
			    </tr>
				
				
				
			

			  <tr>

			    <td align="right" valign="middle">Sales Type :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><strong><?php echo find_a_field('sales_type','sales_type','id='.$master->sales_type);?></strong>&nbsp;</td>
			        </tr>

			      </table></td>
			    </tr>
				
				

			

			  

			  </table></td>

		  </tr>

		</table></td>

	  </tr>
  
  
  
 
  
  
 
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
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
       
       
<tr>

<th width="4%" rowspan="2" bgcolor="#CCCCCC">SL</th>

<th width="28%" rowspan="2" bgcolor="#CCCCCC">Item Description</th>
<th width="7%" rowspan="2" bgcolor="#CCCCCC">Ctn Size </th>
<th width="8%" rowspan="2" bgcolor="#CCCCCC">Ctn Price </th>
<th colspan="2" bgcolor="#CCCCCC">Sales Qty </th>
<th width="6%" rowspan="2" bgcolor="#CCCCCC"><span role="presentation" dir="ltr">Taxable Amount</span></th>
<th width="7%" rowspan="2" bgcolor="#CCCCCC"><span role="presentation" dir="ltr">Discount</span></th>
<th width="7%" rowspan="2" bgcolor="#CCCCCC"><span role="presentation" dir="ltr">Tax Rate</span></th>
<th width="12%" rowspan="2" bgcolor="#CCCCCC"><span role="presentation" dir="ltr"> Amount </span><span role="presentation" dir="ltr">Including VAT</span></th>
</tr>
<tr>
  <th width="6%" bgcolor="#CCCCCC">Ctn</th>
  <th width="7%" bgcolor="#CCCCCC">Pcs</th>
</tr>

        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, a.*
   from sale_do_chalan a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.chalan_no='.$chalan_no.' order by a.id ';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>

<td><?=$data->item_name?></td>
<td><?=$data->pkt_size?></td>
<td><?=$data->crt_price?></td>
<td><?=$data->pkt_unit?></td>
<td><?=$data->dist_unit?></td>
<td><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></td>
<td><? if($data->discount>0) {?><?=$data->discount;  $tot_discount +=$data->discount;?><? }?> <? $data->amt_after_discount;  $tot_amt_after_discount +=$data->amt_after_discount;?></td>
<td><?php echo $master->vat?>%</td>
<td><? $data->vat_amt; $tot_vat_amt +=$data->vat_amt;?>  <?=$data->total_amt_with_vat; $tot_total_amt_with_vat +=$data->total_amt_with_vat;?></td>
</tr>
        
        <?  } ?>
        <tr>

<td colspan="6"><div align="right"><strong> Grand Total:</strong></div></td>

<td><strong>
  <?=number_format($tot_total_amt,2);?>
</strong></td>
<td><strong>
  <?=number_format($tot_discount,2);?> <? number_format($tot_amt_after_discount,2);?>
</strong></td>
<td>&nbsp;</td>
<td><strong>
  <? number_format($tot_vat_amt,2);?>
  <?=number_format($tot_total_amt_with_vat,0);?></strong></td>
</tr>
        <?php /*?><tr style="font-size:16px; font-weight:500; letter-spacing:.3px;">
          <td colspan="10">In Word: SAR
            <?

		$scs =  $tot_total_amt_with_vat;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Halala ';}

	 echo ' Only';

		?>. </td>
          </tr><?php */?>
      </table>      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  </tr>
  
  
  <tr>
  
  	<td>
	 <table width="100%" class="tabledesign" border="0" >
	 
	 	<tr>
			<td width="40%">&nbsp;</td>
			<td width="60%">
				<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:14px">
       
       
<tr>

<th width="30%" bgcolor="#CCCCCC"> Description</th>
<th width="11%" bgcolor="#CCCCCC"><span role="presentation" dir="ltr">Total Amount</span><span role="presentation" dir="ltr"></span></th>
</tr>

    
        <tr>

<td>Total (Excluding VAT)</td>
<td><strong>
  <?=number_format($tot_total_amt,2);?>
SAR</strong></td>
</tr>
        <tr>
          <td><span role="presentation" dir="ltr">Discount</span></td>
          <td><strong>
            <?=number_format($tot_discount,2);?>
          SAR</strong></td>
        </tr>
        <tr>
          <td><span role="presentation" dir="ltr">Total Taxable Amount</span></td>
          <td><strong>
            <?= number_format($tot_amt_after_discount,2);?>
          SAR</strong></td>
        </tr>
        <tr>
          <td><span role="presentation" dir="ltr">Total VAT</span></td>
          <td><strong>
            <?=number_format($tot_vat_amt,2);?>
          SAR</strong></td>
        </tr>
        <tr>
          <td><span role="presentation" dir="ltr">Total Amount Including VAT </span></td>
          <td><strong>
            <?=number_format($tot_total_amt_with_vat,0);?>
          SAR</strong></td>
        </tr>
        
      </table>
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
		  <td colspan="4">&nbsp;</td>
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
		  <td align="center"  style=" font-size:12px;">
		  
		  <?php $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?></td>
		  <td align="center">		  </td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr>
		  <td align="center" >---------------------------------</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">---------------------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong>Sales Officer </strong></td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%"><strong>Received By </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<?php /*?><tr>
            <td colspan="3" style="font-size:12px">
                Note: No claims for shortage will be entertained after five days from the delivered date.  </td>
		    <td>This is an ERP generated report </td>
		    </tr><?php */?>
			
	
			
			
				
	
	<?php /*?><tr>
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
          </tr><?php */?>
	</table>
	
</td>
	  </tr>
	
	
	
  </tbody>
</table>


</div>
<div class="brack">&nbsp;</div>

<!--<div class="page_brack" >

</div>-->


</body>
</html>
