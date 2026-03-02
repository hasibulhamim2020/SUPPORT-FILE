<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$tc_no 		= $_REQUEST['v_no'];

$do_no= find_a_field('sale_do_travel_card','do_no','tc_no='.$tc_no);

$master= find_all_field('sale_do_master','','do_no='.$do_no);

$tc_data= find_all_field('sale_do_travel_card','','tc_no='.$tc_no);




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
<title>.: TRAVEL CARD :.</title>
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
.style1 {font-weight: bold}

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
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
<thead>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="17%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$master->group_for?>.png" width="100%" />
                        <td width="58%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">TRAVEL CARD </td>
      </tr>
                          </table>
                        <td width="25%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px; color: #F00;">
                            <tr>
                              <td align="right" valign="middle"> TC No : </td>
                              <td><table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="3">
                                  <tr>
                                    <td><strong><?php echo $tc_no;?></strong></td>
                                  </tr>
                                </table></td>
                            </tr>
							
                            <tr>
                              <td align="right" valign="middle">TC Date :  </td>
                              <td><table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="3">
                                  <tr>
                                    <td><strong><?php echo date('d-m-Y',strtotime($tc_data->tc_date));?></strong></td>
                                  </tr>
                                </table></td>
                            </tr>
                      </table>                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td>&nbsp;</td></tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
  
 </thead>
 
 
 
 
 
 
  <tbody>
 
  <tr> <td><hr /></td></tr>
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">


		        <tr>


		          <td width="40%" align="right" valign="middle">Customer Name: </td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


		            <tr>


		              <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
		              </tr>


		            </table></td>
	            </tr>


		        <tr>


		          <td align="right" valign="center"> Buyer Name:</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
                    </tr>


                  </table></td>
		        </tr>
				
				<tr>


		          <td align="right" valign="center"> Merchandiser Name:</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
                    </tr>


                  </table></td>
		        </tr>
				
				
				<tr>


		          <td align="right" valign="center"> Mobile No:</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><?= find_a_field('merchandizer_info','mobile_no','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
                    </tr>


                  </table></td>
		        </tr>
				
				
				<tr>


		          <td align="right" valign="center"> Delivery Place:</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><?= find_a_field('delivery_place_info','delivery_place','id="'.$master->delivery_place.'"');?></td>
                    </tr>


                  </table></td>
		        </tr>
				
				<tr>


		          <td align="right" valign="center"> Delivery Address:</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><?= find_a_field('delivery_place_info','address_e','id="'.$master->delivery_place.'"');?></td>
                    </tr>


                  </table></td>
		        </tr>
				
				
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
		        </table>		      </td>


			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			
			
			
			
			
			 <tr>


                <td width="44%" align="right" valign="middle"> WO No:</td>


			    <td width="56%"><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><strong><?php echo $master->do_no;?></strong></td>
                    </tr>


                </table></td> </tr>
				<tr>


				<td align="right" valign="middle">WO Date:</td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><strong><?php echo date('d-m-Y',strtotime($master->do_date));?></strong></td>
                    </tr>


                </table></td>
			    </tr>
			
			
			<tr>


                <td width="44%" align="right" valign="middle"> Job No:</td>


			    <td width="56%"><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><strong><?php echo $master->job_no;?></strong></td>
                    </tr>


                </table></td> </tr>
			


			  <tr>


                <td width="44%" align="right" valign="middle"> PO No:</td>


			    <td width="56%"><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><strong><?php echo $master->po_no;?></strong></td>
                    </tr>


                </table></td> </tr>
				<tr>


				<td align="right" valign="middle">Delivery Date:</td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><strong><?php echo date('d-m-Y',strtotime($master->delivery_date));?></strong></td>
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
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:14px">
        <tr>
          <td width="3%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="20%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="3%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Ply</strong></td>
          <td width="29%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Paper Combination</strong></td>
          <td width="15%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Measurement</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pcs Rate </strong></td>
          <td width="8%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Quantity</strong></td>
          <td width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Value</strong></td>
        </tr>
        
        <?  $sqlc = 'select c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_travel_card c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.tc_no='.$tc_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:14px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top"><?=$datac->item_name;?></td>
          <td align="left" valign="top"><?=$datac->ply;?></td>
          <td align="center" valign="top"><?=$datac->paper_combination;?></td>
          <td align="center" valign="top"><? if($datac->L_cm>0) {?><?=$datac->L_cm?><? }?><? if($datac->W_cm>0) {?>X<?=$datac->W_cm?><? }?><? if($datac->H_cm>0) {?>X<?=$datac->H_cm?><? }?> cm</td>
          <td align="center" valign="top"><?=$datac->unit_price;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $grand_tot_unit +=$datac->total_unit; ?></td>
          <td align="center" valign="top"><?=number_format($datac->total_amt,2); $grand_tot_amt1 +=$datac->total_amt;?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:14px;">
        <td colspan="5" align="right" valign="middle"><strong>Grand Total:</strong></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit,2) ;?></strong></td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_tot_amt1,2) ;?>
        </strong></td>
        </tr>
      </table>
        
	 
	  
	  
	  	    </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>
		
	</td>
  
  </tr>
  
  
  
  
  <tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4">Prepared By :
                <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?>,&nbsp; Prepared At :
                <?=$master->entry_at?></td>
        </tr>
        <tr>
		<td colspan="4">&nbsp;</td>
          </tr>
        <tr>
		<td colspan="4" align="right">&nbsp;</td>
          </tr>
		  
		  <tr>
		<td colspan="4" align="right">&nbsp;</td>
          </tr>
		  
		  <tr>
		<td colspan="4" align="right">&nbsp;</td>
          </tr>

        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><br></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">-------------------------------------</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">-------------------------------------</td>
        </tr>
        <tr style="font-size:12px">
          <td align="center" width="25%"><strong>Manager Production </strong></td>
          <td align="center" width="25%">&nbsp;</td>
          <td align="center" width="25%">&nbsp;</td>
          <td align="center" width="25%"><strong>Executive Director </strong></td>
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
	
	
	
<?php /*?><tfoot>
	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
          <hr />
	
          <tr>
            <td colspan="2" style="border:0px;border-color:#FFF; color: #000; font-size:16px; font-weight:700;" align="center" ><?=$_SESSION['company_name']?> </td>
		</tr>
		  <tr>
			 <td colspan="2" style="border:0px;border-color:#FFF; color: #000;  font-size:14px; " align="center" ><?=$_SESSION['company_address']?></td>
		</tr>
		  <tr>
			 <td colspan="2" style="border:0px;border-color:#FFF; color: #000; font-size:14px; " align="center" >Teliphone: 
			  <?=find_a_field('project_info','proj_phone','company_name="'.$_SESSION['company_name'].'"');?></td>
          </tr>
		  <tr>
			 <td colspan="2" style="border:0px;border-color:#FFF; color: #000; font-size:14px; " align="center" >E-mail: 
			  <?=find_a_field('project_info','proj_email','company_name="'.$_SESSION['company_name'].'"');?></td>
          </tr>
		
	</table>
	  </div>
	</td>
  </tr>
  
  </tfoot><?php */?>
</table>
</body>
</html>
