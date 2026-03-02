<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


$title='Receipt &amp; Payment Statement';


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

                                          <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />

                                        </div></td>



                                        <td width="8%" align="left"> <div align="center">To Date: </div></td>

                                        <td width="50%" align="left"><input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>"  /></td>

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
	$tr_type="Search";
?>									<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="70%" bgcolor="#82D8CF">&nbsp; Particulars</th>

											<th width="30%" bgcolor="#82D8CF"><div align="right">Amount</div></th>
										</tr>
										</thead>

										

										
										
<?


$sql = "select a.ledger_id, sum(j.dr_amt-j.cr_amt) as opening_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$fdate."' group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_amt[$data->ledger_id]=$data->opening_amt;
}

$sql = "select a.ledger_id, sum(j.dr_amt-j.cr_amt) as closing_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$closing_amt[$data->ledger_id]=$data->closing_amt;
}



?>

<tr>
									  <td bgcolor="#d2b4de"><strong>&nbsp; Receipts</strong></td>
									  <td bgcolor="#d2b4de">&nbsp;</td>
				  </tr>

<?

	   
 $sql_sub="select group_id, group_name from ledger_group where acc_sub_sub_class=127 group by group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql="select a.ledger_id, a.ledger_name from accounts_ledger a where a.ledger_group_id='".$info_sub->group_id."'  order by a.ledger_name";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->ledger_name;?></td>
<td align="right"><?=number_format($opening_amt[$data->ledger_id],2); $tot_opening_amt+=$opening_amt[$data->ledger_id];?></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
									<tr>

										  <td align="left"><strong>&nbsp; Opening Balance </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_opening_amt,2);?>
										  </strong></td>
									  </tr>
										
	
									
									
									
									<tr>
									  <td align="left">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									
<?
	   
  $sql_sub="select group_id, group_name from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and j.tr_from='Receipt' and j.cr_amt>0
 and l.acc_sub_sub_class!=127 group by l.group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql="select a.ledger_id, a.ledger_name, sum(j.cr_amt) as receipt_amt from ledger_group l, accounts_ledger a, journal j 
where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and a.ledger_group_id='".$info_sub->group_id."' and j.jv_date between '".$fdate."' and '".$tdate."'
and j.tr_from='Receipt' and j.cr_amt>0 group by a.ledger_id order by a.ledger_name";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->ledger_name;?></td>
<td align="right"><?=number_format($data->receipt_amt,2); $tot_receipt_amt+=$data->receipt_amt;?></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
									<tr>

										  <td align="left"><strong>&nbsp; Receipts in Period </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_receipt_amt,2);?>
										  </strong></td>
									  </tr>
										

									
									<tr>

										  <td align="left"><strong>&nbsp; Total  Amt </strong></td>

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
	   
  $sql_sub="select group_id, group_name from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and j.tr_from='Payment' and j.dr_amt>0
 and l.acc_sub_sub_class!=127 group by l.group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql="select a.ledger_id, a.ledger_name, sum(j.dr_amt) as payment_amt from ledger_group l, accounts_ledger a, journal j 
where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and a.ledger_group_id='".$info_sub->group_id."' and j.jv_date between '".$fdate."' and '".$tdate."'
and j.tr_from='Payment' and j.dr_amt>0 group by a.ledger_id order by a.ledger_name";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->ledger_name;?></td>
<td align="right"><?=number_format($data->payment_amt,2); $tot_payment_amt+=$data->payment_amt;?></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
		
		
									<tr>

										  <td align="left"><strong>&nbsp; Payments in Period </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_payment_amt,2);?>
										  </strong></td>
									  </tr>
									  
									  <tr>
									  <td align="left">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  <?

	   
 $sql_sub="select group_id, group_name from ledger_group where acc_sub_sub_class=127 group by group_id";
$query_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($query_sub)){ 
	   
	   
	   ?>
									
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub->group_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql="select a.ledger_id, a.ledger_name from accounts_ledger a where a.ledger_group_id='".$info_sub->group_id."'  order by a.ledger_name";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->ledger_name;?></td>
<td align="right"><?=number_format($closing_amt[$data->ledger_id],2); $tot_closing_amt+=$closing_amt[$data->ledger_id];?></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
									<tr>

										  <td align="left"><strong>&nbsp; Closing Balance </strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_closing_amt,2);?>
										  </strong></td>
									  </tr>
										

									
									<tr>

										  <td align="left"><strong>&nbsp; Total  Amt </strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_payment_balance=($tot_closing_amt+$tot_payment_amt),2);?>
										  </strong></td>
				  </tr>
									  
								
									
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