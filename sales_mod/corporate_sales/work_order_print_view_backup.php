<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$do_no 		= $_REQUEST['v_no'];


$master= find_all_field('sale_do_master','','do_no='.$do_no);




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
<title>.: Work Order :.</title>
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

@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   color: white;
   text-align: center;
}
}
-->




</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">
<?
require_once "../../../controllers/core/inc.exporttable.php";
?>

<table width="800" id="ExportTable" border="0" cellspacing="0" cellpadding="0" align="center">
<thead>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20%">
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
  
 </thead>
 
 
 
 
 
 
  <tbody>
 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td valign="top"></td>
  	  <td  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">WORK ORDER</span> </td>
  	  <td valign="right" align="right">&nbsp;</td>
	  </tr>
  	<tr>
		<td width="25%" valign="top"></td>
			<td width="50%" valign="middle" align="center"><strong>FSC CERTIFICATE CODE: SCS-COC-007014 </strong></td>
		<td width="25%" valign="right" align="right"><strong>Order Date: <?=date("d M, Y",strtotime($master->do_date))?></strong></td>
	</tr>
	
	<tr>
		<td width="25%" valign="top"><strong>Attn: All Concern </strong></td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr>
	<tr>
	  <td colspan="3" valign="top" style="font-size:12px; padding: 5px 0px 0px 0px; " >We are pleased to inform you that a PO is received and below is the details :</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">


		      <table width="96%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="30%" align="left" valign="middle"><strong>Job No: </strong></td>
		          <td width="70%"><strong><?php echo $master->job_no;?></strong></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Customer Name: </strong></td>
		          <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong> Buyer Name:</strong></td>
		          <td><?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Customer's PO: </strong></td>
		          <td><?php echo $master->customer_po_no;?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong> Merchandiser Name:</strong></td>
		          <td><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong> Mobile No:</strong></td>
		          <td><?= find_a_field('merchandizer_info','mobile_no','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Marketing Officer: </strong></td>
		          <td><?= find_a_field('marketing_person','marketing_person_name','person_code="'.$master->marketing_person.'"');?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong> Mobile No:</strong></td>
		          <td><?= find_a_field('marketing_person','mobile_no','person_code="'.$master->marketing_person.'"');?></td>
	            </tr>
				
				
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
		        </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">
			
			
			
			<tr>


                <td width="66%" align="right" valign="middle"><strong> FSC CLAIM 100% </strong></td>


			    <td width="34%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="20">


                      <td>&nbsp;<? if($master->fsc_claim==1) {?> <img src="tick.png" width="30"  style="padding:2px 0 0 0;"/> <? }?></td>
                    </tr>


                </table></td> </tr>




			  <tr>


                <td width="66%" align="right" valign="middle"><strong> FSC CLAIM MIX </strong></td>


			    <td width="34%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <? if($master->fsc_claim==2) {?><img src="tick.png" width="30"  style="padding:2px 0 0 0;"/> <? }?></td>
                  </tr>
                </table></td> </tr>
				
				
				<tr>

				<td align="right" valign="middle"><strong> FSC CLAIM RECYCLED </strong></td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp;<? if($master->fsc_claim==3) {?> <img src="tick.png" width="30"  style="padding:2px 0 0 0;"/> <? }?></td>
                  </tr>
                </table></td>
			    </tr>
				
				
				<tr>

				<td align="right" valign="middle"><strong> FSC MIX CREDIT </strong></td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <? if($master->fsc_claim==4) {?><img src="tick.png" width="30"  style="padding:2px 0 0 0;"/> <? }?></td>
                  </tr>
                </table></td>
			    </tr>
				
				
				<tr>


				<td align="right" valign="middle"><strong> NON FSC</strong></td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <? if($master->fsc_claim==5) {?><img src="tick.png" width="30"  style="padding:2px 0 0 0;"/> <? }?></td>
                  </tr>
                </table></td>
			    </tr>
				
				
				<tr>


				<td align="right" valign="middle"><strong> FSC Logo</strong></td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <strong><?= $master->fsc_logo?> </strong></td>
                  </tr>
                </table></td>
			    </tr>


			  


			  


		    </table></td>
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
      
      <table width="100%" class="tabledesign"   border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        <tr>
          <td colspan="9" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Technical Information</strong></td>
          </tr>
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO No </strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Additional Info</strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Paper Combination</strong></td>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Ply</strong></td>
          <td width="14%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Measurement</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Quantity</strong></td>
          </tr>
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
          <td align="left" valign="top"><?=$datac->style_no;?></td>
          <td align="left" valign="top"><?=$datac->po_no;?></td>
          <td align="left" valign="top"><?=find_a_field('additional_information','additional_information','id='.$datac->additional_info);?></td>
          <td align="left" valign="top"><?=$datac->paper_combination;?></td>
          <td align="left" valign="top"><?=$datac->ply;?></td>
          <td align="center" valign="top"><? if($datac->L_cm>0) {?><?=$datac->L_cm?><? }?><? if($datac->W_cm>0) {?>X<?=$datac->W_cm?><? }?><? if($datac->H_cm>0) {?>X<?=$datac->H_cm?><? }?> <?=$datac->measurement_unit?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $grand_tot_unit1 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="8" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit1,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 <tr>
          <td colspan="9" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>General Information</strong></td>
          </tr>
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Printing Info </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Date </strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Place </strong></td>
          <td colspan="3" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Address</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Quantity</strong></td>
          </tr>
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kks;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
          <td align="left" valign="top"><?=find_a_field('printing_information','printing_information','id='.$datac->printing_info);?></td>
          <td align="left" valign="top"><?php echo date('d-m-Y',strtotime($datac->delivery_date));?></td>
          <td align="left" valign="top"><?= find_a_field('delivery_place_info','delivery_place','id="'.$datac->delivery_place.'"');?></td>
          <td colspan="3" align="left" valign="top"><?= find_a_field('delivery_place_info','address_e','id="'.$datac->delivery_place.'"');?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $grand_tot_unit2 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="8" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit2,2) ;?></strong></td>
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
          <td colspan="3" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Summary</strong></td>
          </tr>
        <tr>
          <td width="7%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="65%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Measurement</strong></td>
          <td width="28%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Quantity</strong></td>
          </tr>
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.L_cm, c.W_cm, c.H_cm, c.measurement_unit order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="center" valign="top"><? if($datac->L_cm>0) {?><?=$datac->L_cm?><? }?><? if($datac->W_cm>0) {?>X<?=$datac->W_cm?><? }?><? if($datac->H_cm>0) {?>X<?=$datac->H_cm?><? }?> <?=$datac->measurement_unit?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $tot_unit_sum +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">
		  	<table width="100%" border="1" style="font-size:12px" class="tabledesign1">
			<tr>
				<td width="61%"><div align="right"><strong>Total Order Quantity: </strong></div></td>
				<td width="39%" align="center"><strong>
				  <?=number_format($grand_tot_unit1,2) ;?>
				</strong></td>
			</tr>
			
		
			
			<tr>
				<td width="61%"><div align="right"><strong>Total Order Value: </strong></div></td>
				<td width="39%" align="center"><strong>
				  
				  $ <?=number_format($grand_tot_amt=find_a_field('sale_do_details','sum(total_amt)','do_no='.$master->do_no),2);?>
				</strong></td>
			</tr>
	  </table>
		  </td>
        </tr>
		
		</table>
		
		</td>
</tr>
	
  
  
  
  
  <tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        
        
        
		  
		  <tr>
		<td colspan="2" align="right">&nbsp;</td>
          <td colspan="2" width="43%" align="right">
		  
		  
		  </td>
          </tr>
		  
		  <tr>
		<td colspan="4" align="left">&nbsp;</td>
          </tr>

        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
		
		<tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
		
		<tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
		
		<tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        
        
        
        
        
        <?php /*?><tr>
          <td align="left" style="font-size:10px">
          <ul>
            <li>The Copy of Work Order must be shown at the factory premises during the delivery.</li>
            <li>Company protects the right to reconsider or cancel the Work-Order every nowby any administrational dictation.</li>
            <li>Any inefficiency in maintanence must be informed(Officially) before the execution to avoid the compensation.</li>
        </ul></td>
        </tr><?php */?>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
      </table>	</td>
  </tr>
	
	</tbody>
	
	
	<tfoot>
	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td align="center"  width="25%">&nbsp;</td>
		</tr>
		
		<tr>
            <td colspan="2">Prepared By :
                <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?>,&nbsp; Prepared At :
                <?=$master->entry_at?>  </td>
		    <td colspan="2">This is an ERP generated report </td>
		    </tr>
		<tr>
		  <td colspan="2">Approved By :
            <?=find_a_field('user_activity_management','fname','user_id='.$master->checked_by);?>
            ,&nbsp; Approved At :
            <?=$master->checked_at?></td>
		  <td colspan="2">&nbsp;</td>
		  </tr>
	
	<tr>
            <td colspan="4">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr>
	</table>
	  </div>
	</td>
  </tr>
  
  </tfoot>
</table>
</body>
</html>
