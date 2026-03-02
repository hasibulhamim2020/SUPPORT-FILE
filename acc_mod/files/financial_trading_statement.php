<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Trading Account';





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

				   <td colspan="3" bgcolor="#99CCFF"><strong>SALES PROFIT </strong></td>

				   </tr>

				 <tr>

				   <td>Revenue from Sales </td>

				   <td><div align="center">10</div></td>

				   <td align="right"><? $com_id = 10; $amount1 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format(($amount1*(-1)),2).'</a>';?></td>

				   </tr>

				 <tr style="background-color:#FFFFFF">

				   <td>Less: VAT on Local Sales </td>

				   <td><div align="center">17</div></td>

				   <td align="right"><? $com_id = 17; $amount3 = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 + $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($amount3,2).'</a>';?></td>

				   </tr>

				 <tr>

				   <td colspan="2">&nbsp;</td>

				   <td align="right">&nbsp;</td>

				   </tr>

				 <tr>

				   <td colspan="2" bgcolor="#00FFCC"><strong>NET SALES AFTER VAT </strong></td>

				   <td align="right" bgcolor="#00FFCC"><strong><?= $total_net_sate = (($amount1*(-1))-$amount3); ?></strong></td>

				   </tr>

				 <tr>

				   <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>

				   </tr>

				 <tr>

				   <td bgcolor="#FFCCFF"><strong>Less: COST OF GOODS SOLD</strong></td>

				   <td bgcolor="#FFCCFF"><div align="center">14</div></td>

				   <td align="right" bgcolor="#FFCCFF"><? $com_id = 14; $amount = sum_com($com_id,$fdate,$tdate); $total = $total - $amount; $total1 = $total1 - $amount; echo '<a href="trial_balance_periodical_group.php?fdate='.$_REQUEST["fdate"].'&tdate='.$_REQUEST["tdate"].'&cc_code=&show=Show&com_id='.$com_id.'">'.number_format($amount,2).'</a>';?></td>

				   </tr>

				 

				 <tr>

				   <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>

				   </tr>

				 <tr>

				   <td colspan="2" bgcolor="#00FFCC"><strong>GROSS PROFIT </strong></td>

				   <td align="right" bgcolor="#00FFCC"><strong><?= $total_net_sate = (($amount1*(-1))-$amount3); ?></strong></td>

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