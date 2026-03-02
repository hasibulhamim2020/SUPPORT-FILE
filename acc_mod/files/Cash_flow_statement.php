<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Cash Flow Statement';




				   



$tdate=$_REQUEST['tdate'];

//fdate-------------------

$fdate=$_REQUEST["fdate"];



$j=0;

for($i=0;$i<strlen($fdate);$i++)

{

if(is_numeric($fdate[$i])) {

$time1[$j]=$time1[$j].$fdate[$i];}



else { $j++;}

}



$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);



//tdate-------------------





$j=0;

for($i=0;$i<strlen($tdate);$i++)

{

if(is_numeric($tdate[$i])) {

$time[$j]=$time[$j].$tdate[$i];}

else { $j++;}

}

$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);



if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='') {

$report_detail.='<br>Reporting Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'].'';}

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

		    Currrent Period as On:      </td>

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

									<? if(isset($_POST['show'])){?>

									<div id="reporting" style="overflow:hidden"><div id="grp">



<table width="98%" cellspacing="0" cellpadding="2" border="0" class="tabledesign">

<thead>

				 <tr>

					<th width="57%"><span class="style1">PARTICULARS</span></th>

					 <th width="13%"><div align="center">NOTE</div></th>

					 <th width="30%"><div align="center">AMOUNT(BDT)</div></th>
				 </tr>
				    </thead>

				 <tr>
				   <td colspan="3" bgcolor="#99CCFF"><strong>Cash at Beginning of Year</strong></td>
				   </tr>
				 <tr>
				 <tr>
				   <td>Cash at Beginning of Year</td>
				   <td>&nbsp;</td>
				   <td align="right"> <?
		
					 $Cash_Beginning = find_a_field('journal j, accounts_ledger a, ledger_group g','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.com_id=7 and j.jv_date<'.$fdate); echo  number_format($Cash_Beginning,2);
					 
					 ?></td>
				   </tr>
				   
				   
				   <tr>

				   <td bgcolor="#FFCCFF"><strong>Net Cash at Beginning of Year:</strong></td>

				   <td bgcolor="#FFCCFF"><div align="center">A</div></td>
				   <td bgcolor="#FFCCFF"><div align="right"><strong><? echo number_format($Cash_Beginning,2);?></strong></div></td>
				 </tr>

				 <tr>

				   <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
				   </tr>

				   
				   
				   

				   <td colspan="3" bgcolor="#99CCFF"><strong>Cash Flow from Operating Activities: </strong></td>
				   </tr>
				 <tr>
				   <td>Cash Received  from Customers</td>
				   <td>&nbsp;</td>
				   <td align="right"><? $com_id = 7; $cash_receive = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($cash_receive,2).'</a>';?></td>
				   </tr>
				 <tr>
				   <td>Paid to Suppliers </td>
				   <td>&nbsp;</td>
				   <td align="right">(<? $com_id = '8,100'; $Suppliers = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($Suppliers,2).'</a>';?>)</td>
				   </tr>
				 <tr>
				   <td>Indirect Expenses</td>
				   <td>&nbsp;</td>
				   <td align="right">(<? $com_id = 18; $indirect_exp = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($indirect_exp,2).'</a>';?>)</td>
				   </tr>
				 <tr>
				   <td>Marketing Expenses</td>
				   <td>&nbsp;</td>
				   <td align="right">(<? $com_id = 19; $marketing_exp = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($marketing_exp,2).'</a>';?>)</td>
				   </tr>
				 <tr>
				   <td>Factory Overhead Expenses </td>
				   <td>&nbsp;</td>
				   <td align="right">(<? $com_id = '23'; $Factory_Overhead = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($Factory_Overhead,2).'</a>';?>)</td>
				   </tr>
				 <tr>
				   <td>Payement for VAT, AIT & SD </td>
				   <td>&nbsp;</td>
				   <td align="right">(<? $com_id = '17,1112'; $vat_paid = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($vat_paid,2).'</a>';?>)</td>
				   </tr>

				 

				 <tr>

				   <td bgcolor="#FFCCFF"><strong>Net Cash Flow from Operating Activities: <?= $Net_Operating_Activities=($cash_receive - ($Suppliers+$indirect_exp+$marketing_exp+$Factory_Overhead+$vat_paid)); ?></strong></td>

				   <td bgcolor="#FFCCFF"><div align="center">B</div></td>
				   <td bgcolor="#FFCCFF"><div align="right"><strong><? echo number_format($Net_Operating_Activities,2);?></strong></div></td>
				 </tr>

				 <tr>

				   <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
				   </tr>

				 <tr>

				   <td colspan="3" bgcolor="#99CCFF"><strong>Cash Flow from Investing Activities: </strong></td>
				   </tr>

				 <tr>

				   <td>Purchase of Property &amp; Equipment</td>

				   <td>&nbsp;</td>

				   <td align="right">&nbsp;(<? $com_id = '1'; $Equipment = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($Equipment,2).'</a>';?>)</td>
				 </tr>

				 <tr>

				   <td bgcolor="#FFFFFF">Advance, Deposit and Prepayment</td>

				   <td bgcolor="#FFFFFF">&nbsp;</td>

				   <td align="right" bgcolor="#FFFFFF">(<? $com_id = '6,66,2069'; $Advance = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($Advance,2).'</a>';?>)&nbsp;</td>
				 </tr>

				 <tr>

				   <td>Investment in Inter Company</td>

				   <td>&nbsp;</td>

				   <td align="right">(<? $com_id = '2067,2065,1091'; $Inter_Company = sum_com1($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($Inter_Company,2).'</a>';?>)</td>
				 </tr>

				 

				 <tr>

                   <td bgcolor="#FFCCFF"><strong>Net Cash Flow from Investing Activities: 
                     <?= $Net_Investing_Activities=($Equipment+$Advance+$Inter_Company); ?>
                   </strong></td>

				   <td bgcolor="#FFCCFF"><div align="center">C</div></td>
				   <td bgcolor="#FFCCFF"><div align="right"><strong>(<? echo number_format($Net_Investing_Activities,2);?>)</strong></div></td>
				   </tr>

				 
				 
				 
				 
				 
				  
				 <tr>

				   <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
				   </tr>

				 <tr>

                   <td colspan="3" bgcolor="#99CCFF"><strong>Cash Flow from Financing Activities: </strong></td>
				   </tr>

				 <tr>

                   <td bgcolor="#FFFFFF">Bank Charges and Commission</td>

				   <td bgcolor="#FFFFFF"><div align="center"></div></td>

				   <td align="right" bgcolor="#FFFFFF">&nbsp;(<? $com_id = 20; $financial_exp = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($financial_exp,2).'</a>';?>)</td>
				 </tr>
				   <tr>

                   <td bgcolor="#FFCCFF"><strong>Net Cash Flow from Financing Activities:</strong></td>

				   <td bgcolor="#FFCCFF"><div align="center">D</div></td>
				   <td bgcolor="#FFCCFF"><div align="right"><strong>(<? echo number_format($financial_exp,2);?>)</strong></div></td>
				   </tr>
				   
				    
				   
				 <tr>
				   <td bgcolor="#FFFFFF">&nbsp;</td>
				   <td bgcolor="#FFFFFF">&nbsp;</td>
				   <td bgcolor="#FFFFFF">&nbsp;</td>
				   </tr>
				 <tr>

                   <td bgcolor="#99CC99"><strong>Net Increase/(Decrease) in Cash : <?= $Net_Increase_Decrease=(($Cash_Beginning+$Net_Operating_Activities) - ($Net_Investing_Activities+$financial_exp)); ?></strong></td>

				   <td bgcolor="#99CC99">&nbsp;</td>
				   <td bgcolor="#99CC99"><div align="right"><strong><?= number_format($Net_Increase_Decrease,2)?></strong></div></td>
				 </tr>

				 

				 <!--<tr>

				   <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
				   </tr>

				 <tr>

				   <td bgcolor="#66FFFF"><strong>TOTAL CAPITAL AND LIABILITIES </strong></td>

				   <td bgcolor="#66FFFF">&nbsp;</td>
				   <td align="right" bgcolor="#66FFFF"><div align="right"><strong><? echo number_format($total,2);?></strong></div></td>
				   </tr>-->
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