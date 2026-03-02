<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Statement of Cash Flow';


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



		    From Date :                                       </td>



                                        <td width="23%" align="left"> <div align="right">

                                          <input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off"/>

                                        </div></td>



                                        <td width="8%" align="left"> <div align="center">To Date: </div></td>

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



								

									
<?php
if(isset($_REQUEST['show']))
{
?>									<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="70%" bgcolor="#82D8CF">&nbsp; Particulars</th>

											<th width="30%" bgcolor="#82D8CF"><div align="right">Amount</div></th>
										</tr>
										</thead>

										

										
										
<?


$sql = "select a.ledger_id, a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as opening_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$fdate."' group by a.ledger_group_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_amt[$data->ledger_group_id]=$data->opening_amt;
}

$sql = "select a.ledger_id, a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as closing_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' group by a.ledger_group_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$closing_amt[$data->ledger_group_id]=$data->closing_amt;
}



?>
<tr>
									  <td bgcolor="#d2b4de"><strong>&nbsp; Receipts</strong></td>
									  <td bgcolor="#d2b4de">&nbsp;</td>
				  </tr>


<?

	   
 $sql_sub="select id, sub_sub_class_name from acc_sub_sub_class where id=127 group by id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong>Opening <?=$info_sub->sub_sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


 $sql="select a.group_id, a.group_name from ledger_group a where a.acc_sub_sub_class='".$info_sub->id."'  order by a.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right"><?=number_format($opening_amt[$data->group_id],2); $tot_opening_amt+=$opening_amt[$data->group_id];?></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
									<?php /*?><tr>

										  <td align="left"><strong>&nbsp; Opening Balance </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_opening_amt,2);?>
										  </strong></td>
									  </tr><?php */?>
										
	
									
									
									
									<tr>
									  <td align="left">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									
<?
	   
  $sql_sub="select l.group_id, l.group_name,  sum(j.cr_amt) as receipt_amt from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and j.tr_from='Receipt' and j.cr_amt>0
 and l.acc_sub_sub_class!=127 group by l.group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									<tr>

										  <td >&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td align="right"><?=number_format($info_sub->receipt_amt,2); $tot_receipt_amt+=$info_sub->receipt_amt;?></td>
									  </tr>


							  
		<? }?>
		
		
									<?php /*?><tr>

										  <td align="left"><strong>&nbsp; Receipts in Period </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_receipt_amt,2);?>
										  </strong></td>
									  </tr><?php */?>
										

									
									<tr>

										  <td align="left"><strong>&nbsp; Total Receipts Amt (A) </strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_receipt_balance=($tot_opening_amt+$tot_receipt_amt),2);?>
										  </strong></td>
				  </tr>  
				  
				  
				  
				  
		<tr>
									  <td align="left">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>		  
				  
<tr>
									  <td bgcolor="#d2b4de"><strong>&nbsp; Payments</strong></td>
									  <td bgcolor="#d2b4de">&nbsp;</td>
				  </tr>


										
	
									
									
									
									
									  
									  
									
<?
	   
  $sql_sub="select l.group_id, l.group_name, sum(j.dr_amt) as payment_amt from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and j.tr_from='Payment' and j.dr_amt>0
 and l.acc_sub_sub_class!=127 group by l.group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									<tr>

										  <td >&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td align="right"><?=number_format($info_sub->payment_amt,2); $tot_payment_amt+=$info_sub->payment_amt;?></td>
									  </tr>
									  
									  





							  
		<? }?>
		
		
		
		
									<tr>

										  <td align="left"><strong>&nbsp; Payments in Period (B) </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_payment_amt,2);?>
										  </strong></td>
									  </tr>
									  
									  <tr>
									  <td align="left">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  <tr>
									    <td align="left"><strong>&nbsp; Closing Balance (A-B) </strong></td>
									    <td align="right"><?=number_format($balance_cash=$total_receipt_balance-$tot_payment_amt,2);?></td>
			    </tr>
									  <tr>
									    <td align="left">&nbsp;</td>
									    <td align="right">&nbsp;</td>
			    </tr>
									  
									  
									 <?

	   
 $sql_sub="select id, sub_sub_class_name from acc_sub_sub_class where id=127 group by id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong>Closing <?=$info_sub->sub_sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


 $sql="select a.group_id, a.group_name from ledger_group a where a.acc_sub_sub_class='".$info_sub->id."'  order by a.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right"><?=number_format($closing_amt[$data->group_id],2); $tot_closing_amt+=$closing_amt[$data->group_id];?></td>
									  </tr>
									  
									  
									  
<? }?>	
										

		<? }?>							
									
									  
								
									
									</table>

	


								





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