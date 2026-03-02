<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

 $do_no = $_REQUEST['v_no'];

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

//$do_no= find_a_field('sale_return_details','do_no','chalan_no='.$chalan_no);

$master = find_all_field('sale_return_master','','do_no='.$do_no);




  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.* from dealer_info a, sale_return_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$entry_time=$dealer->do_date;


$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;

$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_return_details','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_return_details','sum(dist_unit)','chalan_no='.$chalan_no); 



$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="UTF-8">
<title>.: Sales Ruturn :.</title>
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


@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   
   text-align: center;
}
}

@media print {
  .brack {page-break-after: always;}
}
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">

  
  <thead>
  <tr>
    <td><div class="header" style="margin-top:0; padding: 5px 10px; background:#CCCCCC;  border-radius: 5px;  ">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="38%">
                       		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:16px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name?></span></td>
							  </tr>
							  
							  
									
									
									<tr>
									  <td style="font-size:14px; line-height:24px;"><?=$group_data->address?></td>
									</tr>
									<tr><td style="font-size:14px; line-height:24px;"><?=$group_data->cr_no?></td>
									</tr>
									
							  
							  <tr><td style=" font-size:14px; line-height:24px;"><?=$group_data->vat_reg?></td>
							  </tr>
						  </table>					    </td>
						  
						  <td width="65%" align="center">
						  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									<td>
						  	          <div align="right"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png"  width="40%"  />
						  	            
					  	                        </div></td>
							</tr>
							</table>
						  </td>
                        
                        <td width="38%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<?php /*?><tr>
									  <td style="padding-bottom:3px;"><span style="font-size:22px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name_arabic;?></span></td>
							  </tr>
							  
							  
									
									
									<tr>
									  <td style="font-size:16px; line-height:24px;"><?=$group_data->address_arabic?></td>
									</tr>
									<tr><td style="font-size:16px; line-height:24px;"><?=$group_data->cr_no_arabic?></td>
									</tr>
									
							  
							  <tr><td style=" font-size:16px; line-height:24px;"><?=$group_data->vat_reg_arabic?></td>
							  </tr><?php */?>
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
  	  <td width="50%"  style="text-align:center; "><span style="color:#FFF; font-size:18px; background:#CCCCCC; padding:8px 40px; color:#000000; font-weight:bold; border: 2px solid #000000; border-radius: 5px; ">
	  SALES RUTURN</span> </td>
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
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" class="style8"> SR No: <?php echo $master->do_no?> &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold; float: left;" class="style8"> SR Date:
                            <?=date("j-M-Y",strtotime($master->do_date));?>
                     &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; " class="style8">
		               Customer:  <?=$dealer->dealer_name_e;?>
		              &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; " class="style8"> Type: <?php echo find_a_field('sales_return_type','sales_return_type','id='.$master->sales_type);?> &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">VAT No: <?php echo $dealer->vat_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Contact No: <?php echo $dealer->mobile_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">C.R No: <?php echo $dealer->cr_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Address: <?php echo $dealer->address_e?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  
		        </table>		      </td>

			<td width="30%"><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="font-size:13px">
			
			
	

			  <tr>

			    <td align="center" valign="middle"><img style="margin:0; padding:0;" src="https://chart.googleapis.com/chart?chs=140x140&cht=qr&chl=TAMIM HIJAZ COMPANY LIMITED&choe=UTF-8" title="TAMIM HIJAZ COMPANY LIMITED" /></td>
			    </tr>
				
				
				
				
				
			

			  

			  </table></td>

		  </tr>

		</table></td>

	  </tr>
  
  <tr><td>&nbsp;</td></tr>
  
 
  <tr>
  	<td>
		<div id="pr">
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
	</td>
  
  </tr>
  
  
   </thead>
  
 
  <tbody >
 
  <tr >
    <td valign="top">
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px"  >
       
       
<tr>

<th width="4%" bgcolor="#CCCCCC">SL</th>

<th width="6%" bgcolor="#CCCCCC">Code</th>
<th width="29%" bgcolor="#CCCCCC">Item Description</th>
<th width="7%" bgcolor="#CCCCCC">Ctn Size </th>
<th width="8%" bgcolor="#CCCCCC">Ctn Price </th>
<th width="6%" bgcolor="#CCCCCC">Ctn</th>
<th width="7%" bgcolor="#CCCCCC">Pcs</th>
<th width="7%" bgcolor="#CCCCCC"><span role="presentation" dir="ltr">Net  Amount</span></th>
</tr>


        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, a.*
   from sale_return_details a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.do_no='.$do_no.' order by a.id ';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>

<td><?=$data->item_id?></td>
<td><?=$data->item_name?></td>
<td><?=$data->pkt_size?></td>
<td><?=$data->crt_price?></td>
<td><?=$data->pkt_unit?></td>
<td><?=$data->dist_unit?></td>
<td><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></td>
</tr>
        
        <?  } ?>
        <tr>

<td colspan="7"><div align="right"><strong>   Total:</strong></div></td>

<td><strong>
  <?=number_format($tot_total_amt,2);?>
</strong></td>
</tr>
      </table>      </td>
  </tr>
  
  
  
  
  
  
  
  
  <?php /*?><tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

		        

                  <tr>

		          <td><table width="100%" height="70" border="1" cellpadding="3" cellspacing="0">

		            <tr>

		              <td valign="top"><span style="font-size:16px; font-weight:500; letter-spacing:.3px;" class="style8">
					  In Word: SAR
            <?

$taxable_amount =  $tot_total_amt-$master->cash_discount;
$tot_vat_amt = ($taxable_amount*$master->vat)/100;
$amount_including_vat = $taxable_amount+$tot_vat_amt;
			
			

		$scs =  number_format($amount_including_vat,2);

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Halala ';}

	 echo ' Only';

		?>.
					  
					  </span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td><table width="100%" height="70" border="1" cellpadding="3" cellspacing="0">

		            <tr>

		              <td valign="top"><span style="font-size:12px; font-weight:500; letter-spacing:.3px;" class="style8">
					  <strong>Declaration:</strong><br />
					  We declare that this invoice shows actual price of Those goods described and that all particulars are true and correct. <br />
					  N.B.: Software Generate Bill. Signatory Not Required. 
            
					  
					  </span></td>
		              </tr>

		            </table></td>
		          </tr>
		        </table>		      </td>

			<td width="40%">
			 
			    <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			      
			      
			      
			      <tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total (Excluding VAT) 
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?=number_format($tot_total_amt,2);?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Discount
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?=number_format($master->cash_discount,2);?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total Taxable Amount
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			             
						  
						  <?=$taxable_amount =  $tot_total_amt-$master->cash_discount;?>
						  
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total VAT
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?= $tot_vat_amt = ($taxable_amount*$master->vat)/100;?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total Amount Including VAT 
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?=number_format($amount_including_vat = $taxable_amount+$tot_vat_amt,2);?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
			      
			      
			      
			      </table>
		      </td>
		  </tr>

		</table></td>

	  </tr><?php */?>
  
  
  </tbody>
  
	
	
	<tfoot >

	<tr>
		<td>
	
	 <div class="footer"> 
	<table width="100%" cellspacing="0" cellpadding="0"   >
	
	

		  
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
		  <td align="center"  style=" font-size:12px;">
		  
		  <?php $uid=find_a_field('sale_return_master','entry_by','do_no="'.$do_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr>
		  <td align="center" >---------------------------------</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">---------------------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong>Sales Officer </strong></td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%"><strong>Customer</strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		
			
	
			
			
				
	
	<tr>
            <td colspan="3">  <hr /> </td>
		</tr>
		
		
		
		
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" ><?=$group_data->group_name?></td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Address: <?=$group_data->address?></td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: <?=$group_data->mobile;?>,  Email: <?=$group_data->email;?></td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web:  <?=$group_data->website;?></td>
          </tr>
	</table>
	
	</div>
	
</td>
	  </tr>
	
	</tfoot>
	
  
</table>


</div>



</body>
</html>
