<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Comparative Income Statement';


do_calander('#fdate');

do_calander('#tdate');



$fdate=$_REQUEST["fdate"];

$tdate=$_REQUEST['tdate'];

do_calander('#cfdate');

do_calander('#ctdate');


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



                                        <td width="22%" align="right">



		    From Date :                                       </td>



                                        <td width="23%" align="left"> <div align="right">

                                          <input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off"/>

                                        </div></td>



                                        <td width="8%" align="left"> <div align="center">To Date: </div></td>

                                        <td width="50%" align="left"><input name="tdate" type="text" id="tdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['tdate'];?>" autocomplete="off"/></td>
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

                                        <td align="center">&nbsp;</td>
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
?>									<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="53%" rowspan="2" bgcolor="#82D8CF"  style="color:#000000;">&nbsp; Particular</th>

											<th width="25%" bgcolor="#82D8CF"  style="color:#000000;">
										      <div align="center">
										        <?=date("d M, Y",strtotime($_REQUEST['tdate']))?>
								            </div></th>
										    <th width="22%" bgcolor="#82D8CF"  style="color:#000000;"><div align="center">
										      <?=date("d M, Y",strtotime($_REQUEST['ctdate']))?>
										    </div>
									        </th>
										</tr>
										<tr>
										  <th bgcolor="#82D8CF"  style="color:#000000;"><div align="center">Amount</div></th>
										  <th width="22%" bgcolor="#82D8CF"  style="color:#000000;"><div align="center">Amount</div></th>
										</tr>
										</thead>

										

										
										
<?

$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as sales_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt[$data->acc_sub_sub_class]=$data->sales_amt;
}

$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as expenses_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expenses_amt[$data->acc_sub_sub_class]=$data->expenses_amt;
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
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and l.acc_sub_sub_class=315";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt=$data->expense_amt;
}

$material_cost=($rm_opening+$purchase_amt)-$rm_closing;
$total_cogs_amt=$material_cost+$expense_amt;




// Comparative 

$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as sales_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$cfdate."' and '".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt_cm[$data->acc_sub_sub_class]=$data->sales_amt;
}

$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as expenses_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$cfdate."' and '".$ctdate."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expenses_amt_cm[$data->acc_sub_sub_class]=$data->expenses_amt;
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
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$cfdate."' and '".$ctdate."' and l.acc_sub_sub_class=315";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt_cm=$data->expense_amt;
}

$material_cost_cm=($rm_opening_cm+$purchase_amt_cm)-$rm_closing_cm;
$total_cogs_amt_cm=$material_cost_cm+$expense_amt_cm;







	   
 $sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=3 and s.id=31
group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									      <td bgcolor="#E0FFFF">&nbsp;</td>
									</tr>
									  
									  

<?php


$sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub1->id."'  order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><a href="financial_transaction_group.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data1->id?>" target="_blank">
<?=number_format($sales_amt[$data1->id],2); $tot_sales_amt +=$sales_amt[$data1->id];?></a></td>
									  <td align="right"><a href="financial_transaction_group.php?show=show&amp;fdate=<?=$_REQUEST['cfdate']?>&amp;tdate=<?=$_REQUEST['ctdate']?>&amp;acc_sub_sub_class=<?=$data1->id?>" target="_blank">
                                        <?=number_format($sales_amt_cm[$data1->id],2); $tot_sales_amt_cm +=$sales_amt_cm[$data1->id];?>
									    </a></td>
									  </tr>
									  
									  
									  
<? }?>	


<tr>
										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cost of Goods Sold										  </td>

										  <td align="right">
										  
		 <a href="financial_cogs_cal.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>" target="_blank"><?=number_format($total_cogs_amt,2);?>	</a></td>
									      <td align="right"><a href="financial_cogs_cal.php?show=show&amp;fdate=<?=$_REQUEST['cfdate']?>&amp;tdate=<?=$_REQUEST['ctdate']?>" target="_blank">
									        <?=number_format($total_cogs_amt_cm,2);?>
                                          </a></td>
</tr>
 						


							  
		<? }?>
		
		
									<tr>

										  <td align="center"><strong>Gross Profit</strong></td>

										  <td align="right"><strong>
									      <?=number_format($gross_profit_amt=$tot_sales_amt-$total_cogs_amt,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($gross_profit_amt_cm=$tot_sales_amt_cm-$total_cogs_amt_cm,2);?>
                                          </strong></td>
									</tr>
										

										
										
								
										
<?
	   
  $sql_sub2="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=4
group by s.id";
$query_sub2=db_query($sql_sub2);

while($info_sub2=mysqli_fetch_object($query_sub2)){ 
	   
	   
	   ?>

										<tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub2->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									      <td bgcolor="#D8BFD8">&nbsp;</td>
									  </tr>
									  
									  

<?php


echo $sql2="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub2->id."'  and ss.id not in (315,4110,418) order by ss.id";

$query2=db_query($sql2);

while($data2=mysqli_fetch_object($query2)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data2->sub_sub_class_name;?></td>

										  <td align="right">
										  
		 <a href="financial_transaction_group.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data2->id?>" target="_blank">
		 <?=number_format($expenses_amt[$data2->id],2); $tot_expenses_amt +=$expenses_amt[$data2->id];?></a></td>
									      <td align="right"><a href="financial_transaction_group.php?show=show&amp;fdate=<?=$_REQUEST['cfdate']?>&amp;tdate=<?=$_REQUEST['ctdate']?>&amp;acc_sub_sub_class=<?=$data2->id?>" target="_blank">
                                            <?=number_format($expenses_amt_cm[$data2->id],2); $tot_expenses_amt_cm +=$expenses_amt_cm[$data2->id];?>
									        </a></td>
									  </tr>
									  
									  
									  
<? }?>	

 						


							  
		<? }?>
		

		
									<tr>

										  <td align="center"><strong> Total Operating Expenses</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_expenses_amt,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($tot_expenses_amt_cm,2);?>
                                          </strong></td>
									</tr>
									
									
									<tr>

										  <td align="center"><strong> Profit from Operation</strong></td>

										  <td align="right"><strong>
									      <?=number_format($profit_from_operation=($gross_profit_amt-$tot_expenses_amt),2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($profit_from_operation_cm=($gross_profit_amt_cm-$tot_expenses_amt_cm),2);?>
                                          </strong></td>
									</tr>
									
									
									
		<?						
	   
 $sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=3 and s.id!=31
group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									      <td bgcolor="#E0FFFF">&nbsp;</td>
									</tr>
									  
									  

<?php


$sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub1->id."'  order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><a href="financial_transaction_group.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data1->id?>" target="_blank">
<?=number_format($sales_amt[$data1->id],2); $tot_other_income +=$sales_amt[$data1->id];?></a></td>
									  <td align="right"><a href="financial_transaction_group.php?show=show&amp;fdate=<?=$_REQUEST['cfdate']?>&amp;tdate=<?=$_REQUEST['ctdate']?>&amp;acc_sub_sub_class=<?=$data1->id?>" target="_blank">
                                        <?=number_format($sales_amt_cm[$data1->id],2); $tot_other_income_cm +=$sales_amt_cm[$data1->id];?>
									    </a></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
									<tr>

										  <td align="center"><strong>Total Non-Operating Income</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_other_income,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($tot_other_income_cm,2);?>
                                          </strong></td>
									</tr>
										

										
							<tr>

										  <td align="center"><strong>Profit before Income Tax</strong></td>

										  <td align="right"><strong>
									      <?=number_format($profit_before_tax=$profit_from_operation+$tot_other_income,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($profit_before_tax_cm=$profit_from_operation_cm+$tot_other_income_cm,2);?>
                                          </strong></td>
							</tr>
									  
									  
									  <tr>

										  <td align="center"><strong>lncome Tax Expenses</strong></td>

										  <td align="right"><strong>
									      <?=number_format($income_tax_exp=0,2);?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($income_tax_exp_cm=0,2);?>
                                          </strong></td>
									  </tr>
									
									
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									</tr>
									<tr>
									  <td align="center" bgcolor="#FF6347"><strong>Net Profit After Tax</strong></td>
									  <td align="right" bgcolor="#FF6347"><strong>
									  <? $net_profit_loss = ($profit_before_tax-$income_tax_exp);?>
									  
									  
	 <?=($net_profit_loss>0)?number_format($net_profit_loss,2):'('.number_format($net_profit_loss*(-1),2).')';?>
									  </strong></td>
									  <td align="right" bgcolor="#FF6347"><strong>
                                        <? $net_profit_loss_cm = ($profit_before_tax_cm-$income_tax_exp_cm);?>
                                        <?=($net_profit_loss_cm>0)?number_format($net_profit_loss_cm,2):'('.number_format($net_profit_loss_cm*(-1),2).')';?>
                                      </strong></td>
									</tr>
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  <td align="right">&nbsp;</td>
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