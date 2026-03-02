<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tr_type="Show";


$title='Statement of Cash Flows';

do_calander('#fdate');

do_calander('#tdate');

do_calander('#cfdate');

do_calander('#ctdate');



$fdate=$_REQUEST["fdate"];

$tdate=$_REQUEST['tdate'];


$cfdate=$_REQUEST["cfdate"];

$ctdate=$_REQUEST['ctdate'];


if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')



$report_detail.='<br>Reporting Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'].'';



?>





<style>

a:hover {

 

  color: #FF0000;

}
</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>



    <td><div class="left_report">



							<table width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>



								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">



									<table width="100%" border="0" cellspacing="2" cellpadding="0">



                                      <tr>



                                        <td width="22%" align="right">From Date :  </td>

                                        <td width="23%" align="left"> <div align="right">

                                          <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />

                                        </div></td>



                                        <td width="8%" align="left"> <div align="center">To Date: </div></td>

                                        <td width="50%" align="left"><input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>"  /></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Comparative  Date : </td>
                                        <td align="left"><div align="right">
                                          <input name="cfdate" type="text" id="cfdate" size="12" maxlength="12" value="<?php echo $_REQUEST['cfdate'];?>" autocomplete="off"/>
                                        </div></td>
                                        <td align="left"><div align="center">To Date: </div></td>
                                        <td align="left"><input name="ctdate" type="text" id="ctdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['ctdate'];?>" autocomplete="off"/></td>
                                      </tr>

									  

									  

									  

									  

									<tr>

										

                                        <td align="right"> </td>



                                        <td colspan="3" align="left">

											<br />										</td>
                                      </tr>

                                      



                                      



                                      <tr>



                                        <td align="center">&nbsp;</td>

                                        <td align="center">&nbsp;</td>

                                        <td align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>



								    </form></div></td>



						      </tr>



								  <tr>



									<td align="right"><? include('PrintFormat.php');?></td>



								  </tr>



								  <tr>



									<td>



									<div id="reporting" style="overflow:hidden">

									
<?php
if(isset($_REQUEST['show']))
{
	$tr_type="Search";
?>		

									
								
										
<?



$sql = "select a.ledger_group_id, sum(j.cr_amt-j.dr_amt) as sales_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and l.acc_class=3";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt=$data->sales_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_opening 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_opening=$data->rm_opening;
}


$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and l.acc_sub_class!=42 and l.acc_class=4";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt=$data->expense_amt;
}

$material_cost=($rm_opening+$purchase_amt)-$rm_closing;
$total_cogs_amt=$material_cost+$expense_amt;

$net_profit_loss=$sales_amt-$total_cogs_amt;




//Comparative Data


$sql = "select a.ledger_group_id, sum(j.cr_amt-j.dr_amt) as sales_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$cfdate."' and '".$ctdate."' and l.acc_class=3";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt_cm=$data->sales_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_opening 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$cfdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_opening_cm=$data->rm_opening;
}


$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$cfdate."' and '".$ctdate."' and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt_cm=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing_cm=$data->rm_closing;
}

$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$cfdate."' and '".$ctdate."' and l.acc_sub_class!=42 and l.acc_class=4";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt_cm=$data->expense_amt;
}

$material_cost_cm=($rm_opening_cm+$purchase_amt_cm)-$rm_closing_cm;
$total_cogs_amt_cm=$material_cost_cm+$expense_amt_cm;

$net_profit_loss_cm=$sales_amt_cm-$total_cogs_amt_cm;





 $sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as asset_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$asset_amt[$data->acc_sub_sub_class]=$data->asset_amt;

}


$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as liability_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$liability_amt[$data->acc_sub_sub_class]=$data->liability_amt;

}



//Comparative Data

$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as asset_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$asset_amt_cm[$data->acc_sub_sub_class]=$data->asset_amt;

}

$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as liability_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$liability_amt_cm[$data->acc_sub_sub_class]=$data->liability_amt;

}




//Cash Bank Balance


 $sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as cash_opening from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.id=127 ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$cash_opening=$data->cash_opening;

}

	   
	   ?>

	

							<table id="grp" width="100%" border="1" cellspacing="0" cellpadding="0">

										<thead >

										<tr>

											<th width="53%" rowspan="2" bgcolor="#82D8CF" style="color:#000000;">&nbsp; Particular</th>

											<th width="23%" bgcolor="#82D8CF" align="center" style="color:#000000;"><div align="center"><?=date("d M, Y",strtotime($_REQUEST['tdate']))?></div></th>
									      </tr>
										<tr>
										  <th bgcolor="#82D8CF" align="center" style="color:#000000;"><div align="center">Amount</div></th>
										  </tr>
										</thead>
										
			<tr>
									  <td bgcolor="#E0FFFF" style="color:#000000;">&nbsp; <strong>Cash Flows from Operating Activities:</strong></td>
									  <td bgcolor="#E0FFFF" style="color:#000000;">&nbsp;</td>
		                      </tr>
					
					
					<tr>

							 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Net Profit/ (loss) After Tax</td>

										  <td align="right">
										  
		 <a href="financial_profit_loss.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>" target="_blank"><?=number_format($net_profit_loss,2);?>	</a></td>
						      </tr>	


<tr>

							 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depreciation Charged</td>

										  <td align="right"><?=number_format($depreciation_amt=0,2);?>	</td>
						      </tr>	


<tr>

										  <td align="left">&nbsp; <strong>Cash flow from operating activities before working capital changes:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($operating_activities_before_working_capital=$net_profit_loss+$depreciation_amt,2);?>
										  </strong></td>
						      </tr>			
										
										

										

										
	
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong>(Increase)/ Decrease in working Capital:</strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
							        </tr>
									  
									  

<?php


 $sql1="select ss.id, ss.sub_sub_class_name from cashflow_configuration c, acc_sub_sub_class ss 
where  ss.id=c.acc_sub_sub_class and c.type='Working Capital' group by c.acc_sub_sub_class order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Increase)/ Decrease in <?=$data1->sub_sub_class_name;?></td>
<td align="right"><?=number_format($working_capital=$asset_amt_cm[$data1->id]-$asset_amt[$data1->id],2); $total_working_capital +=$working_capital;?></td>
									  </tr>
									  
									  
									  
<? }?>	

						<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>A. Net Cashflows From Operating Activities</strong></td>

										  <td align="right"><strong>
									      <?=number_format($net_operating_activities=($operating_activities_before_working_capital+$total_working_capital),2); ?>
										  </strong></td>
						      </tr>


		
		
									
									  
									  <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
										

				<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong>Cash Flows From Investing Activities:</strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
							        </tr>
									  
									  

<?php


 $sql1="select ss.id, ss.sub_sub_class_name from cashflow_configuration c, acc_sub_sub_class ss 
where  ss.id=c.acc_sub_sub_class and c.type='Investing Activities' group by c.acc_sub_sub_class order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><?=number_format($investing_activities=$asset_amt_cm[$data1->id]-$asset_amt[$data1->id],2); $total_investing_activities +=$investing_activities;?></td>
									  </tr>
									  
									  
									  
<? }?>	



<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>B. Net Cash Flows From Investing Activities:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_investing_activities,2); ?>
										  </strong></td>
						      </tr>
							  
							  
							  
							  
							  
							  
							
							
									
									  
									  <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
										

				<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong>Cash Flows From Financing Activities:</strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
							        </tr>
									  
									  

<?php


 $sql1="select ss.id, ss.sub_sub_class_name from cashflow_configuration c, acc_sub_sub_class ss 
where  ss.id=c.acc_sub_sub_class and c.type='Financing Activities' group by c.acc_sub_sub_class order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><?=number_format($financing_activities=$asset_amt_cm[$data1->id]-$asset_amt[$data1->id],2); $total_financing_activities +=$financing_activities;?></td>
									  </tr>
									  
									  
									  
<? }?>	



						<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>C. Net Cash Flows From Financing Activities:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_financing_activities,2); ?>
										  </strong></td>
						 </tr>
						 
						 
						 <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>D. Net Increase in Cash & Cash Equivalents (A+ B + C):</strong></td>

										  <td align="right"><strong>
 <?=number_format($net_increase_cash_equivalents=($net_operating_activities+$total_investing_activities+$total_financing_activities),2); ?>
										  </strong></td>
						 </tr>
							  
							  
							    
							 <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>E. Cash & Cash Equivalents at Beginning of the Year:</strong></td>

										  <td align="right"><strong>
 										<?=number_format($cash_opening,2); ?>
										  </strong></td>
						 </tr> 
							  
							  
							  
							  <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>

 						<tr>

										  <td align="left">&nbsp; <strong>F. Cash & Cash Equivalents at End of the Year (D+E):</strong></td>

										  <td align="right"><strong>
 										<?=number_format($cash_equivalents_closing=($net_increase_cash_equivalents+$cash_opening),2); ?>
										  </strong></td>
						 </tr> 
							  
							  
							  
							  
							  
							  
									</table>

									

									  
									  
									  



									</div>







									</td>



								</tr>



						</table>

<? }?>

		</div></td>    



  </tr>



</table>



<?



require_once SERVER_CORE."routing/layout.bottom.php";


?>