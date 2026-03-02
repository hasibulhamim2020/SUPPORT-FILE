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
<title><?=$master->job_no;?></title>
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


/*@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   
   text-align: center;
}
}*/

@media print {
  .brack {page-break-after: always;}
}


		#pr input[type="button"] {
			width: 70px;
			height: 25px;
			background-color: #ebfffa;
			color: #333;
			font-weight: bolder;
			border-radius: 5px;
			border: 1px solid #333;
			cursor: pointer;
		}
	</style>


</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >

	<div id="pr">
		<h2 align="center">	<input name="button" type="button" onclick="hide();window.print();" value="Print"/></h2>
	</div>

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">

  
  <thead>
  <tr>
    <td><div class="header" style="margin-top:0; padding: 5px 10px;  border-radius: 5px;  ">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20%">
						<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png"   style=" width:100%;"/>
						
						</td>
						
                        <td width="60%" align="center">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									  <td style="padding-bottom:3px;"><h2 style="margin: 0px; text-align:center;"><?=$group_data->group_name?></h2></td>
							  </tr>
							  
							  
									
									
									<tr>
									  <td style="font-size:14px; line-height:24px; text-align:center;"><strong>Address:</strong> <?=$group_data->address?></td>
									</tr>
									
									<tr>
										<td style="font-size:14px; line-height:24px; text-align:center;"><strong>Phone:</strong> <?=$group_data->mobile;?>, <strong>Email:</strong> <?=$group_data->email;?></td>
									</tr>
									
									
									
							  
							  <tr>
								  <td style=" font-size:14px; line-height:24px; text-align:center;"><?=$group_data->vat_reg?></td>
							  </tr>
						  </table>
						  
						  
						  </td>
                        
                        <td width="20%"> 
							<table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									<td>&nbsp;
						  	          </td>
							</tr>
							</table>
							
						</td>
					  </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
       </div></td>
  </tr>
  
  

 <tr>
	 <td> <hr/> </td>
 </tr>


 
  
  
  <tr>
	  <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  <tr><td>&nbsp;</td></tr>
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; ">
	  <span style="color:#FFF; font-size:18px;  padding:8px 30px; color:#000000; font-weight:bold; border: 2px solid #000000; border-radius: 5px; ">
	  SALES ORDER</span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>

	  <tr><td>&nbsp;</td></tr>

  </table>
  </td>
  </tr>
  
  
  
 
	  
	  
	   
  
  
  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  
			  
			  
			  
			  
			  
			  
			  <tr>
				  
				  <td width="40%">
				  <table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" class="style8"> SO No: <?php echo $master->do_no?> &nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td width="20%"></td>

		          <td width="40%"><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold; float: left;" class="style8"> SO Date:
                            <?=date("j-M-Y",strtotime($master->do_date));?>
                      &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td width="40%"><span style="font-size:14px;" class="style8">
		               <strong>Customer:</strong>  <?=$dealer->dealer_name_e;?>
		              &nbsp;</span></td>
		              </tr>

		            </table></td>
					<td width="20%"></td>

		          <td width="40%"><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span class="style8" style="font-size:14px; font-weight:bold;">JOB  No: <?php echo $master->job_no?> &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td width="40%"><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8"><strong>VAT No:</strong> <?php echo $dealer->vat_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					<td width="20%"></td>
					
					<td width="40%"><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8"><strong>Contact No:</strong> <?php echo $dealer->contact_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td width="40%"><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8"><strong>C.R No:</strong> <?php echo $dealer->cr_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td width="20%"></td>
					
					<td width="40%"><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8"><strong>Address:</strong> <?php echo $dealer->address_e?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  
		        </table>		      
				</td>
				
				

			

		  </tr>

		</table></td>

	  </tr>
  
  <tr><td>&nbsp;</td></tr>
  
 
  <tr>
  	<td>
		<div id="pr">
        <div align="left">
<!--          <p>-->
<!--            <input name="button" type="button" onclick="hide();window.print();" value="Print" />-->
<!--          </p>-->

          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>

		  <nobr>
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>
		</div>
      </div>
	</td>
  
  </tr>
  
  
   </thead>
  
 
  <tbody >
 
  <tr >
    <td valign="top">
      
      <table width="100%" class="tabledesign" border="1" cellspacing="0" cellpadding="5"  style="font-size:12px"  >
       
       
<tr>

<th width="4%">SL</th>

<th width="14%">Code</th>
<th width="33%">Item Description</th>
<th width="12%">Unit</th>
<th width="13%">Unit Price </th>
<th width="12%">Quantity</th>
<th width="12%"><span role="presentation" dir="ltr">Net Amt  </span></th>
</tr>


        
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
<td><?=$data->unit_name?></td>
<td><?=$data->unit_price?></td>
<td><?=$data->dist_unit?></td>
<td><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></td>
</tr>
        
        <?  } ?>
        <tr>
			<td colspan="6"><div align="right"><strong>  Sub Total:</strong></div></td>
			<td><strong> <?=number_format($tot_total_amt,2);?></strong></td>
		</tr>

<tr >
          <td colspan="6"><div align="right"><strong> Discount (<?=$master->discount;?>%): </strong></div></td>
          <td>
		  
		  <strong>
 <?=number_format($discount_amt= ($tot_total_amt*$master->discount)/100,2); ?>
 
 <? $tot_amt_after_discount = $tot_total_amt-$discount_amt; ?>
</strong>
		  </td>
        </tr>

        <tr >
          <td colspan="6"><div align="right"><strong> VAT (<?=$master->vat?>%):</strong></div></td>
          <td>
		  	<strong>
			 <?=number_format($vat_amt= ($tot_amt_after_discount*$master->vat)/100,2); ?>
			</strong>
		  </td>
        </tr>

        <tr >
          <td colspan="6"><div align="right"><strong> Invoice Amount :</strong></div></td>
          <td>
		  <strong>
 <?=number_format($invoice_amt= ($tot_amt_after_discount+$vat_amt),2); ?>
</strong>		  </td>
        </tr>
        <tr>
          <td colspan="7">
		  
		  
		  
		  <span class="style8" style="font-size:14px; font-weight:500; letter-spacing:.3px;">
		  
		  <strong>In Word:</strong>
             <?

		

		$scs =  $invoice_amt;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}

	 echo ' Only.';

		?></span></td>
          </tr>
      </table>      </td>
  </tr>
  
  
  
  
  
  
  
  
  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  

		</table></td>

	  </tr>
  
  
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
		  
		  <?php $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
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
		    <td  align="center" width="25%"><strong>Received By </strong></td>
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
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" ><strong>Address:</strong> <?=$group_data->address?></td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" ><strong>Phone:</strong> <?=$group_data->mobile;?>, <strong>Email:</strong> <?=$group_data->email;?></td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" ><strong>Web:</strong>  <?=$group_data->website;?></td>
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
