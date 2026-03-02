<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='PROFIT & LOSS APPROPRIATION ACCOUNT';





$tdate=$_REQUEST['tdate'];

//fdate-------------------

$fdate=$_REQUEST["fdate"];



$j=0;

for($i=0;$i<strlen($fdate);$i++)

{

if(is_numeric($fdate[$i]))

$time1[$j]=$time1[$j].$fdate[$i];



else $j++;

}



$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);



//tdate-------------------





$j=0;

for($i=0;$i<strlen($tdate);$i++)

{

if(is_numeric($tdate[$i]))

$time[$j]=$time[$j].$tdate[$i];

else $j++;

}

$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);



if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')

$report_detail.='<br>Reporting Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'].'';



?>

<script type="text/javascript">

$(document).ready(function(){

	

	$(function() {

		$("#fdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'dd-mm-y'

		});

	});

		$(function() {

		$("#tdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'dd-mm-y'

		});

	});



});

function DoNav(a,b,c)



{



	document.location.href = 'transaction_list.php?fdate='+a+'&tdate='+b+'&ledger_id='+c+'&show=Show';



}

</script>





<style type="text/css">

<!--

.style1 {font-weight: bold}
.style2 {font-weight: bold}

-->

</style>











<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">

									<table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="22%" align="right">

		    Period :                                       </td>

                                        <td align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 

                                          ---  

                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>

                                      </tr>

                                      

                                      

                                      <tr>

                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td>

									<? if(isset($_REQUEST['show'])){?>

									<div id="reporting" style="overflow:hidden"><div id="grp">



<table width="98%" cellspacing="0" cellpadding="2" border="0" class="tabledesign">

<thead>

				 <tr>

					<th width="57%"><span class="style1">PARTICULARS</span></th>

					 <th width="13%">NOTE</th>

					 <th width="30%">AMOUNT</th>
				 </tr>
				    </thead>

				 <tr>

				   <td bgcolor="#99CCFF"><strong>APPROPRIATION ACCOUNT</strong></td>
				   <td bgcolor="#99CCFF">&nbsp;</td>
				   <td bgcolor="#99CCFF">
				   
				     <!--Sales Calculation-->
				   
				   <input type="hidden" name="abc" value="<? $com_id = 10; $amount1 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
				   echo number_format(($amount1*(-1)),2);?>" />
				   
				   <input type="hidden" name="abc" value="<? $com_id = 15; $amount2 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
				   echo number_format($amount2,2);?>" />
				   
				   <input type="hidden" name="abc" value="<?= number_format($total_net_sate = (($amount1*(-1))-$amount2),2); ?>" />
				   <!--/Sales Calculation-->
				   
				    <!--Closing Stock Calculation-->
					
					 <input type="hidden" name="closing" value=" <? $openingCTG = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=1093 and j.jv_date<'.$fdate); echo  number_format($openingCTG,2);?>" />
				   
				   <input type="hidden" name="closing" value=" <? $openingFCT = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=25 and j.jv_date<'.$fdate); echo  number_format($openingFCT,2);?>" />
				   
				   <input type="hidden" name="closing" value=" <? $openingPKT = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=1110 and j.jv_date<'.$fdate); echo  number_format($openingPKT,2); ?>" />
				   
				   <input type="hidden" name="closing" value=" <? $openingFGFCT = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=26 and j.jv_date<'.$fdate); echo  number_format($openingFGFCT,2);?>" />
				   
				   <input type="hidden" name="closing" value=" <? $openingFGSYLHET = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=27 and j.jv_date<'.$fdate); echo  number_format($openingFGSYLHET,2);?>" />
				   
				   <input type="hidden" name="closing" value=" <? $openingFGDHK = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=28 and j.jv_date<'.$fdate); echo  number_format($openingFGDHK,2);?>" />
				   
				   <input type="hidden" name="closing" value=" <? $openingFGCTG = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=29 and j.jv_date<'.$fdate); echo  number_format($openingFGCTG,2); ?>" />	
				   
				   
				   
				   <input type="hidden" name="abc" value="<? $com_id = 1093; $amount10 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
				   echo number_format(($amt_ctg=($amount10+$openingCTG)),2);?>	" />
				   
				   
				   <input type="hidden" name="abc" value="<? $com_id = 25; $amount11 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
				   echo number_format(($amt_fct=($amount11+$openingFCT)),2);?>	" />
				   
				    <input type="hidden" name="abc" value=" <? $com_id = 1110; $amount12 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
				   echo number_format(($amt_pkt_fct=($amount12+$openingPKT)),2);?>" />
				   
				    <input type="hidden" name="abc" value="<? $com_id = 26; $amount13 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
					echo number_format(($amt_fgfct=($amount13+$openingFGFCT)),2);?>" />
					
					<input type="hidden" name="abc" value="<? $com_id = 27; $amount14 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
					echo number_format(($amt_fgsylhet=($amount14+$openingFGSYLHET)),2);?>" />
					
					<input type="hidden" name="abc" value=" <? $com_id = 28; $amount15 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount;
					 echo number_format(($amt_fgdhk=($amount15+$openingFGDHK)),2);?>" />
					  
					<input type="hidden" name="abc" value="<? $com_id = 29; $amount16 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
					echo number_format(($amt_fgctg=($amount16+$openingFGCTG)),2);?>" />
					
					<input type="hidden" name="abc" value="<?= number_format($closing_tot = ($amt_ctg+$amt_fct+$amt_pkt_fct+$amt_fgfct+$amt_fgsylhet+$amt_fgdhk+$amt_fgctg),2);?>" />
					  
	
					
					 <!--Closing Stock Calculation-->
					 
					 <!--Indirect Income-->
					 
					 <input type="hidden" name="abc" value="<? $com_id = 3024; $indirect_income = sum_com2($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo number_format($indirect_income,2);?>" />
					

					 <!--/Indirect Income-->
					 
					 
					 <!--Total D=(A+B+C)-->
					 
					 <input type="hidden" name="abc" value="<?= number_format($total_Stock_sale = ($total_net_sate+$closing_tot+$indirect_income),2);?>" />
					 
					 <!--/Total D=(A+B+C)-->
					 
					 <!--Opening Stock -->
					 
					 <input type="hidden" name="abc" value="<? $openingCTG = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=1093 and j.jv_date<'.$fdate); echo  number_format($openingCTG,2); ?>" />
					 
					 
					 <input type="hidden" name="abc" value="<? $openingFCT = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=25 and j.jv_date<'.$fdate); echo  number_format($openingFCT,2); ?>" />
					 
					 <input type="hidden" name="abc" value=" <? $openingPKT = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=1110 and j.jv_date<'.$fdate); echo  number_format($openingPKT,2); ?>" />
					 
					  <input type="hidden" name="abc" value=" <? $openingFGFCT = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=26 and j.jv_date<'.$fdate); echo  number_format($openingFGFCT,2); ?>" />
					  
					  <input type="hidden" name="abc" value=" <?  $openingFGSYLHET = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=27 and j.jv_date<'.$fdate); echo  number_format($openingFGSYLHET,2);?>" />
					  
					   <input type="hidden" name="abc" value=" <? $openingFGDHK = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=28 and j.jv_date<'.$fdate); echo  number_format($openingFGDHK,2);?>" />
					   
					    <input type="hidden" name="abc" value="<? $openingFGCTG = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=29 and j.jv_date<'.$fdate); echo  number_format($openingFGCTG,2);?>" />
						
						<input type="hidden" name="abc" value="<?= number_format($opening_tot = ($openingCTG+$openingFCT+$openingPKT+$openingFGFCT+$openingFGSYLHET+$openingFGDHK+$openingFGCTG),2); ?>" />
					  
					 
					 <!--/Opening Stock -->
					 
					 <!--Purchase on Auction -->
					 
					  
					 
					 <input type="hidden" name="abc" value="<? $com_id = 22; $purchase_auction = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
					  echo number_format($purchase_auction,2);?>" />
					 
					 <!--/Purchase on Auction -->
					 
					 <!--Factory Overhead Charge-->
					 
					 <input type="hidden" name="abc" value="<? $com_id = 23; $factory_overhead = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount5; $total1 = $total1 + $amount5; 
					  echo number_format($factory_overhead,2);?>" />
					 
					 
					<!--/Factory Overhead Charge-->
				   
				   
				   <!-- Administrative Expenses-->
				   
				    <input type="hidden" name="abc" value="<? $com_id = 18; $indirect_exp = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; 
					echo number_format($indirect_exp,2);?>" />
					
					<input type="hidden" name="abc" value="<? $com_id = 19; $marketing_exp = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo number_format($marketing_exp,2);?>" />
		
					
					<input type="hidden" name="abc" value="<? $com_id = 17; $vat_paid = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo number_format($vat_paid,2);?>" />
					
					<input type="hidden" name="abc" value="<?= number_format($tot_administrative_exp = ($indirect_exp+$marketing_exp+$vat_paid),2); ?>" />
		
				   <!--/Administrative Expensive-->
				   
				   <!--Financial Expenses-->
		
				   <input type="hidden" name="abc" value="<? $com_id = 20; $financial_exp = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo number_format($financial_exp,2);?>" />
				   
				   <!--/Financial Expenses-->
				   
				   <!-- Depreciation-->
				   
				   <input type="hidden" name="abc" value="<? $com_id = 5656; $depreciation_exp = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo number_format($depreciation_exp,2);?>" />

				   <!--/Depreciation-->
				   
				   
				   <!--Total K=(E+F+G+H+I+J)-->
				   
				   <input type="hidden" name="abc" value="<?= number_format($gross_tot_exp = ($opening_tot+$purchase_auction+$factory_overhead+$tot_administrative_exp+$financial_exp+$depreciation_exp),2); ?>" />
				   
				   <!--/Total K=(E+F+G+H+I+J)-->				   </td>
				 </tr>
				 <tr>

				   <td height="23">Net Profit (Transferred from Profit &amp; Loss   A/C) </td>

				   <td><div align="center">a</div></td>

				   <td align="right"><strong>
				     <?= number_format($gross_gross_profit = (($total_Stock_sale)-$gross_tot_exp),2); ?>
				   </strong></td>
				   </tr>

				 <tr style="background-color:#FFFFFF">
				   <td>Less: Paioryears Adjustment A/C </td>
				   <td><div align="center">b</div></td>
				   <td align="right">
				   <input type="hidden" name="abc" value=" <? $com_id = '1,4,7,6,5,2032,66,2069'; $closing_all_dr_cr = sum_com($com_id,'2000-01-01',$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo number_format($closing_all_dr_cr,2);?>" />
				   
				   <input type="hidden" name="abc" value="<? $all_opening_dr = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id in (1093,1110,25,26,27,28,29 ) and j.jv_date<'.$fdate); echo  number_format($all_opening_dr,2); ?>" />
				   
				   <input type="hidden" name="abc" value=" <? $com_id = '17,15,22,1112,20,19,23,18'; $during_year_all_dr_cr = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo number_format($during_year_all_dr_cr,2);?>" />
				   
				   <input type="hidden" name="abc" value=" <? $com_id = '8,100,1070,1091,2065,2067'; $closing_all_cr_dr = sum_com2($com_id,'2000-01-01',$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo number_format($closing_all_cr_dr,2);?>" />
				   
				   
				   <input type="hidden" name="abc" value=" <? $com_id = '10,3024'; $during_year_all_cr_dr = sum_com2($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo number_format($during_year_all_cr_dr,2);?>" />
				   
				   

				   
					
					<strong><?= number_format($Paioryears_Adjustment = ($closing_all_cr_dr+$during_year_all_cr_dr)-($closing_all_dr_cr+$all_opening_dr+$during_year_all_dr_cr),2); ?>	</strong>			   </td>
				   </tr>
				 <tr>

				   <td>Less: Incometax Paid </td>

				   <td><div align="center">c</div></td>

				   <td align="right"><span class="style2">
				     <? $com_id = 1112; $ait_paid = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($ait_paid,2).'</a>';?>
				   </span></td>
				   </tr>

				 <tr>

				   <td bgcolor="#CCCCFF"><strong>Balance Transferred to Balance Sheet</strong></td>

				   <td bgcolor="#CCCCFF"><div align="center"><strong>(a-b+c)</strong></div></td>
				   <td align="right" bgcolor="#CCCCFF"><strong><?= number_format($balance_transfer = ($gross_gross_profit-($Paioryears_Adjustment+$ait_paid)),2); ?></strong></td>
				   </tr>

				 

				 <tr>

				   <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
				   </tr>
</table>



</div>

</div>

<? }?>

		</td>

		</tr>

		</table>

		</div></td>    

  </tr>

</table>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>