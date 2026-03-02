<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";








$title='Statement of Profit or Loss & Other Comprehensive Income';





do_calander('#fdate');

do_calander('#tdate');



$fdate=$_REQUEST["fdate"];

$tdate=$_REQUEST['tdate'];



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



		    Period :                                       </td>



                                        <td width="23%" align="left"> <div align="right">

                                          <input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off"/>

                                        </div></td>



                                        <td width="8%" align="left"> <div align="center">--- </div></td>

                                        <td width="50%" align="left"><input name="tdate" type="text" id="tdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['tdate'];?>" autocomplete="off"/></td>

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
?>									<table width="100%" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="70%" bgcolor="#82D8CF">&nbsp; Particular</th>

											<th width="30%" bgcolor="#82D8CF">&nbsp; Amount</th>
										</tr>
										</thead>

										

										
										
<?

echo $sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as sales_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
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



	   
 $sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=3 
group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_class_name;?></strong></td>

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
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_sales_amt,2); $net_tot_sales_amt +=$tot_sales_amt;?>
										  </strong></td>
									  </tr>


							  
		<? 
		$tot_sales_amt=0;
		}?>
		
		
									<tr>

										  <td align="center"><strong>Total Sales [A]:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($net_tot_sales_amt,2);?>
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
									  </tr>
									  
									  

<?php


$sql2="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub2->id."'  order by ss.id";

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
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_expenses_amt,2); $net_tot_expenses_amt +=$tot_expenses_amt;?>
										  </strong></td>
 						</tr>


							  
		<? 
		$tot_expenses_amt=0;
		}?>
		
		
									<tr>

										  <td align="center"><strong> Total Expenses [B]:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($net_tot_expenses_amt,2);?>
										  </strong></td>
									</tr>
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									<tr>
									  <td align="center" bgcolor="#FF6347"><strong>Net Profit /(Loss) [A-B]:</strong></td>
									  <td align="right" bgcolor="#FF6347"><strong>
									  <? $net_profit = ($net_tot_sales_amt-$net_tot_expenses_amt);?>
									  
									  
	 <?=($net_profit>0)?number_format($net_profit,2):'('.number_format($net_profit*(-1),2).')';?>
									  </strong></td>
									  </tr>
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									<tr>
									  <td align="center" bgcolor="#FF6347"><strong>Total Comprehensive Income for The Year:</strong></td>
									  <td align="right" bgcolor="#FF6347"><strong>
									 
									  
									  
	 <?=($net_profit>0)?number_format($net_profit,2):'('.number_format($net_profit*(-1),2).')';?>
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