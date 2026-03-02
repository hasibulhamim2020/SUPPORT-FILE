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
<title>.: Proforma Invoice :.</title>
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
		
		<tr><td style="text-align:center; color:#000; ">
		<p style="font-size:30px; color:#000000; margin:0; padding:0; font-weight:500; text-transform:uppercase">
		<?=find_a_field('user_group','group_name','id='.$master->group_for)?>
		</p>
		</td></tr>
		
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="60%">
                       		<table  width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:15px">
								
									<tr><td style="padding-bottom:3px;"><strong>Head Office:</strong></td></tr>
									<tr><td style="padding-bottom:3px;">238, Tejgaon Industrial Area</td></tr>
									<tr><td style="padding-bottom:3px;">Gulshan Link Road Dhaka - 1208.</td></tr>
									<tr><td style="padding-bottom:3px;">Tel: 028878543, Fax: 02-8878550</td></tr>
									<tr><td>Web: www.nassagroup.org</td></tr>
							</table>					    </td>
                        
                        <td width="40%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px">
								
									<tr><td style="padding-bottom:3px;"><strong>Factory:</strong></td></tr>
									<tr><td style="padding-bottom:3px;">107, 128 Nischintapur,</td></tr>
									<tr><td style="padding-bottom:3px;">Zerabo, Ashulia, Dhaka.</td></tr>
									<tr><td style="padding-bottom:3px;">Mobile: 0140-1140030, 0191-5693272.</td></tr>
									<tr><td>Email: npl@nassagroup.org</td></tr>
						  </table>						  </td>                    </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
 </thead>
 
 
 
 
 
 
  <tbody>
 
  <tr> <td><hr /></td></tr>
  <tr> <td>&nbsp;</td></tr>
  
  <tr> <td style="font-size:14px; float:right;">Date: <?php echo date('d-m-Y',strtotime($master->do_date));?></td></tr>
  
  
   <tr>
   <td>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:14px">
   <tr height="25">
   <td width="50%" ><strong>Proforma Invoice No: <?php echo $master->job_no;?></strong></td> 
   <td width="50%"><strong>FSC CERTIFICATE CODE: SCS-COC-007014</strong></td>
   </tr>
   
   <tr>
   <td width="50%"><strong>Bin No. 000073153-0403</strong></td> 
   <td width="50%">&nbsp;</td>
   </tr>
      </table>   </td>
</tr>


   <tr>
     <td style="text-align:center; color:#000; font-weight:bold;">&nbsp;</td>
   </tr>
   <tr><td style="text-align:center; color:#000; ">
		<p style="font-size:20px; color:#000000; font-weight:500;   text-decoration: underline; margin:0; padding:0; text-transform:uppercase">
		Proforma Invoice		</p>
		</td></tr>
		
		
		
		<tr>
   <td>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:14px">
   <tr height="22">
   <td width="50%" ><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td> 
   <td width="50%">&nbsp;</td>
   </tr>
   
   <tr height="22">
   <td width="50%" ><?= find_a_field('dealer_info','address_e','dealer_code="'.$master->dealer_code.'"');?></td> 
   <td width="50%">&nbsp;</td>
   </tr>
   
   
      </table>   </td>
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
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:14px">
        <tr>
          <td width="5%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="15%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td colspan="6" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Description of Goods </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty (Pcs) </strong></td>
          <td width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Rate (Pcs)$ </strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Amount US$ </strong></td>
        </tr>
        
        <?  $sqlc = 'select c.total_unit, c.unit_price, c.po_no, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:14px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="center" valign="top"><?=$datac->po_no;?></td>
          <td width="17%" align="left" valign="top"><?=$datac->item_name;?></td>
          <td width="5%" align="left" valign="top"><?=$datac->L_cm?></td>
          <td width="5%" align="left" valign="top"><?=$datac->W_cm?></td>
          <td width="5%" align="left" valign="top"><?=$datac->H_cm?></td>
          <td width="5%" align="left" valign="top">cm</td>
          <td width="8%" align="left" valign="top"><?=$datac->ply?> PLY</td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $grand_tot_unit +=$datac->total_unit; ?></td>
          <td align="center" valign="top"><?=$datac->unit_price;?></td>
          <td align="right" valign="top"><?=number_format($datac->total_amt,2); $grand_tot_amt1 +=$datac->total_amt;?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:14px;">
        <td colspan="8" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_tot_unit,2) ;?>
        </strong></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong>
          <?=number_format($grand_tot_amt1,2) ;?>
        </strong></td>
        </tr>
        <tr style="font-size:12px; font-weight:700">
          <td colspan="11" align="center" valign="middle">
		  
		  In Word:  <?

		

		$scs =  $grand_tot_amt1;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' cents ';}

	 echo ' Only';

		?>.
		  
		  
		  </td>
          </tr>
      </table>	  	    </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>	</td>
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
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">
		  <p style="font-size:16px; color:#000000; margin:0; padding:0; text-transform:uppercase">
		<?=find_a_field('user_group','group_name','id='.$master->group_for)?>
		</p>		  </td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><br></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr style="font-size:12px">
          <td align="center" width="25%">&nbsp;</td>
          <td align="center" width="25%">&nbsp;</td>
          <td align="center" width="25%">&nbsp;</td>
          <td align="center" width="25%"><strong>Authorized Signature </strong></td>
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
