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

$dealer_data= find_all_field('dealer_info','','dealer_code='.$master->dealer_code);




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





</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 12px;">
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">

  <tbody>

  <tr>



    <td align="center"><div class="header" style="margin-top:0;">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="63%">
                       		<table  width="88%" border="0" cellspacing="0" cellpadding="0"  style="font-size:15px">
								<tr>
					    <td width="57%" align="left" style="padding-bottom:0px;"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['depot']?>.png"  width="62%" /></td>
					    <td width="43%" align="left">&nbsp;</td>
							  </tr>
						
						<tr>
					    <td align="left" width="57%">&nbsp;</td>
					    <td align="left" width="43%">&nbsp;</td>
						</tr>
						  </table>					    </td>
                        
                        <td width="37%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:14px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name?>.
									  </span></td>
							  </tr>
							  
							  
									<tr><td style="font-size:12px; line-height:20px;"><?=$group_data->address?></td>
									</tr>
									
									<tr>
									  <td style="font-size:12px; line-height:20px;">Phone No. : <?=$group_data->mobile?></td>
									</tr>
									<tr><td style="font-size:12px; line-height:20px;">Email: <?=$group_data->email?></td>
									</tr>
									
							  
							  <tr><td style=" font-size:12px; line-height:20px;">BIN/VAT Reg. No. : <?=$group_data->vat_reg?></td>
							  </tr>
						  </table>						  </td>                    </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
       </div></td>
  </tr>
  

 
 
 
 
<tr>
    <td colspan="0" align="center"><hr /></td>
  </tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><h4 style="font-size:18px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline; text-transform:uppercase;">Work Order</h4> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">


		      <table width="96%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="29%" align="left" valign="middle"><strong>Customer Code</strong></td>
		          <td width="1%" align="left" valign="middle">:</td>
		          <td width="70%"><strong><?php echo $dealer_data->customer_code;?></strong></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Customer Name</strong></td>
		          <td align="left" valign="middle">:</td>
		          <td><?php echo $dealer_data->dealer_name_e;?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Contact Person </strong></td>
		          <td align="left" valign="middle">:</td>
		          <td><?php echo $dealer_data->contact_person;?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Mobile No </strong></td>
		          <td align="left" valign="middle">:</td>
		          <td><?php echo $dealer_data->mobile_no;?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong> Address </strong></td>
		          <td align="left" valign="middle">:</td>
		          <td><?php echo $dealer_data->address_e;?></td>
	            </tr>
		        </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">
			
			
			
			<tr>


                <td width="61%" align="right" valign="middle"><strong> Job No: </strong></td>


			    <td width="39%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="25">


                      <td>&nbsp;<?php echo $master->job_no;?></td>
                    </tr>


                </table></td> </tr>




			  <tr>


                <td width="61%" align="right" valign="middle"><strong>Order Date </strong></td>


			    <td width="39%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="25">
                    <td>
                      &nbsp;<?=date("d M, Y",strtotime($master->do_date))?>                    </td>
                  </tr>
                </table></td> </tr>

                <tr>


                <td width="61%" align="right" valign="middle"><strong>Reamrks </strong></td>


			    <td width="39%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="">
                    <td>
                      &nbsp;<?=$master->remarks?>                    </td>
                  </tr>
                </table></td> </tr>
			  


			  


		    </table></td>
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td>&nbsp;</td>
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

<th width="3%" rowspan="2" bgcolor="#CCCCCC">SL</th>

<th width="5%" rowspan="2" bgcolor="#CCCCCC">Item</th>


<th width="5%" rowspan="2" bgcolor="#CCCCCC">Unit</th>
<th width="11%" rowspan="2" bgcolor="#CCCCCC">Size</th>
<th width="4%" rowspan="2" bgcolor="#CCCCCC">GSM</th>
<th colspan="8" bgcolor="#CCCCCC"><div align="center">Colour</div></th>
<th width="9%" rowspan="2" bgcolor="#CCCCCC">Print Name </th>
<th width="9%" rowspan="2" bgcolor="#CCCCCC">Remarks </th>
<th width="6%" rowspan="2" bgcolor="#CCCCCC">U-Price</th>

<th width="6%" rowspan="2" bgcolor="#CCCCCC">Qty (Kg)</th>
<th width="6%" rowspan="2" bgcolor="#CCCCCC">Qty (Pcs)</th>
<th width="7%" rowspan="2" bgcolor="#CCCCCC">Amount</th>
</tr>
<tr>
  <th width="6%" bgcolor="#CCCCCC">Body</th>
  <th width="7%" bgcolor="#CCCCCC">Handle</th>
  <th width="7%" bgcolor="#CCCCCC">Gadget</th>
  <th width="6%" bgcolor="#CCCCCC">Pipene</th>
  <th width="6%" bgcolor="#CCCCCC">Print-1</th>
  <th width="6%" bgcolor="#CCCCCC">Print-2</th>
  <th width="5%" bgcolor="#CCCCCC">Print-3</th>
  <th width="6%" bgcolor="#CCCCCC">Print-4</th>
</tr>
        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, a.*
   from sale_do_details a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.do_no='.$do_no.' order by a.id desc';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>

<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td><? if($data->s_w>0) {?><?=$data->s_w?><? }?><? if($data->s_h>0) {?>X<?=$data->s_h?><? }?><? if($data->s_g>0) {?>X<?=$data->s_g?><? }?></td>

<td><?=$data->gsm?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_b.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_h.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_g.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_pp.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_pra.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_prb.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_prc.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_prd.'"');?></td>
<td><?=find_a_field('dealer_print_name','print_name','id="'.$data->print_name.'"');?></td>

<td><?=$data->remarks?></td>
<td><?=$data->unit_price?></td>

<td><?=$data->qty_kg?></td>
<td><?=$data->total_unit?></td>
<td><?=$data->total_amt?></td>
</tr>
        
        <?

$total_kg = $total_kg + $data->qty_kg;
$total_quantity = $total_quantity + $data->total_unit;

$total_amount = $total_amount + $data->total_amt;

		 }
		
		?>
        <tr>

<td colspan="5"><div align="right"><strong> Grand Total:</strong></div></td>

<td colspan="9">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>

<td><strong><?=number_format($total_kg,2);?></strong></td>
<td><strong><?=number_format($total_quantity,2);?></strong></td>
<td><strong><?=number_format($total_amount,2);?></strong></td>
</tr>
      </table>      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  </tr>
  
  
  
	
  
  
  
  
  <tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        
        
      
		  
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
	
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
		
		    <tr>
          <td width="25%" align="center"><?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?><br><?=$master->entry_at?></td>
          <td  width="25%" align="center"><?=find_a_field('user_activity_management','fname','user_id='.$master->checked_by);?><br><?=$master->checked_at?></td>
          <td width="25%" align="center">&nbsp;</td>
          <td width="25%" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
        </tr>
        <tr>
          <td align="center"><strong>Prepared By</strong></td>
          <td align="center"><strong>Checked By</strong></td>
          <td align="center"><strong>General Manager</strong></td>
          <td align="center"><strong>Authorized By</strong></td>
        </tr>
	</table>
	  </div>	</td>
  </tr>
  </tbody>
</table>
</body>
</html>
