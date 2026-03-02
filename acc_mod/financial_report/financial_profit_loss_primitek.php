<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Statement of Profit or Loss & Other Income';


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



									<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr>
    
    <td align="right" width="10%">From Date:</td>
    <td width="20%">
      <input name="fdate" type="text" id="fdate" maxlength="12" 
             value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off" style="width:120px;" required/>
    </td>

    
    <td align="right" width="10%">To Date:</td>
    <td width="20%">
      <input name="tdate" type="text" id="tdate" maxlength="12" 
             value="<?php echo $_REQUEST['tdate'];?>" autocomplete="off" style="width:120px;" required/>
    </td>

    
    <td align="right" width="10%">Company :</td>
    <td width="15%">
    <?php /*?> <? if($_POST['group_for']>0) { ?>
					<input type="hidden" name="group_for" id="group_for" value="<?=$_POST['group_for'];?>" readonly=""/>
	<input type="text" name="group_for_show" id="group_for_show" value="<?=find_a_field('user_group','group_name','id='.$_POST['group_for']);?>" readonly=""/>
							<? } else {?>
							<select  id="group_for" name="group_for" class="form-control" required>
										<? user_company_access($group_for); ?>
									</select>
									<? } ?><?php */?>
									
	<select  id="group_for" name="group_for" class="form-control" required>
	<option><?=find_a_field('user_group','group_name','id='.$_POST['group_for']);?></option>
										<? user_company_access($group_for); ?>
									</select>
    </td>
  </tr>

  
  <tr>
    <td colspan="6" align="center" style="padding-top:10px;">
      <input class="btn" name="show" type="submit" id="show" value="Show" style="padding:5px 15px;" />
    </td>
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

											<th width="70%" bgcolor="#82D8CF">&nbsp; Particular</th>

											<th width="30%" bgcolor="#82D8CF">&nbsp; Amount</th>
										</tr>
										</thead>

										

										
										
<?

 $sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as sales_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."'
 and j.group_for='".$_POST['group_for']."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt[$data->acc_sub_sub_class]=$data->sales_amt;

}


$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as expenses_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' 
 and l.group_id not in (411002) and a.ledger_id not in (140,182) and j.group_for='".$_POST['group_for']."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expenses_amt[$data->acc_sub_sub_class]=$data->expenses_amt;

}

$sql_ledger = "select a.ledger_id, sum(j.dr_amt-j.cr_amt) as total_amt 
from accounts_ledger a, journal j
where a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and j.group_for='".$_POST['group_for']."'
group by a.ledger_id";
$query_ledger = db_query($sql_ledger);
while($data_ledger=mysqli_fetch_object($query_ledger)){
$income_tax_exp[$data_ledger->ledger_id]=$data_ledger->total_amt;

}


$sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_opening 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.group_for='".$_POST['group_for']."'
 and  j.jv_date<'".$fdate."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_opening=$data->rm_opening;
}

$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and j.tr_from='Purchase' and a.ledger_id=j.ledger_id 
 and j.group_for='".$_POST['group_for']."' and j.jv_date between '".$fdate."' and '".$tdate."'  and c.type in ('RM')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$purchase_amt=$data->purchase_amt;
}

 $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as rm_closing 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."'
 and j.group_for='".$_POST['group_for']."' and c.type in ('RM','WIP','FG')";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$rm_closing=$data->rm_closing;
}

 $sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' 
 and l.acc_sub_sub_class in (411,413,416) and l.group_id not in (411001) and a.ledger_id not in (140) and j.group_for='".$_POST['group_for']."' ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt=$data->expense_amt;
}

$material_cost=($rm_opening+$purchase_amt)-$rm_closing;

$total_cogs_amt=$expense_amt;



	   
 $sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=3 and s.id=31
group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


 $sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub1->id."' and ss.id not in (315,316) order by ss.id";

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
										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cost of Goods Sold
										  
									
										  
										  
										  </td>

										  <td align="right">
										  
		 <a href="financial_cogs_cal_primitek.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>" target="_blank">
		 <?=number_format($total_cogs_amt,2);?>	</a></td>
									  </tr>
 						


							  
		<? }?>
		
		
									<tr>

										  <td align="center"><strong>Gross Profit</strong></td>

										  <td align="right"><strong>
									      <?=number_format($gross_profit_amt=$tot_sales_amt-$total_cogs_amt,2);?>
										  </strong></td>
									  </tr>
										

										
										
								
										
<?
	   
  $sql_sub2="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=4 and s.id!=42
group by s.id";
$query_sub2=db_query($sql_sub2);

while($info_sub2=mysqli_fetch_object($query_sub2)){ 
	   
	   
	   ?>

										<tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub2->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql2="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub2->id."'  and ss.id not in (315,413,416) order by ss.id";

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

 						


							  
		<? }?>
		

		
									<tr>

										  <td align="center"><strong> Total Operating Expenses</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_expenses_amt,2);?>
										  </strong></td>
									</tr>
									
									
									<tr>

										  <td align="center"><strong> Profit from Operation</strong></td>

										  <td align="right"><strong>
									      <?=number_format($profit_from_operation=($gross_profit_amt-$tot_expenses_amt),2);?>
										  </strong></td>
									</tr>
									
									
									
		<?						
	   
 $sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=3 and s.id=31 
group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql1="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub1->id."' and ss.id in (315,316) order by ss.id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->sub_sub_class_name;?></td>
<td align="right"><a href="financial_transaction_group.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data1->id?>" target="_blank">
<?=number_format($sales_amt[$data1->id],2); $tot_other_income +=$sales_amt[$data1->id];?></a></td>
									  </tr>
									  
									  
									  
<? }?>	



							  
		<? }?>
		
		
									<tr>

										  <td align="center"><strong>Total Non-Operating Income</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_other_income,2);?>
										  </strong></td>
									  </tr>
										

										
							<tr>

										  <td align="center"><strong>Profit before Income Tax</strong></td>

										  <td align="right"><strong>
									      <?=number_format($profit_before_tax=$profit_from_operation+$tot_other_income,2);?>
										  </strong></td>
									  </tr>
									  
									  
									  <tr>

										  <td align="center"><strong>lncome Tax Expenses</strong></td>

										  <td align="right"><strong>
									      <?
										  $income_tax_exp=$income_tax_exp[140];
										  echo number_format($income_tax_exp,2);
										  ?>
										  </strong></td>
									  </tr>
									
									
									<tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
									<tr>
									  <td align="center" bgcolor="#FF6347"><strong>Net Profit After Tax</strong></td>
									  <td align="right" bgcolor="#FF6347"><strong>
									  <? $net_profit_loss = ($profit_before_tax-$income_tax_exp);?>
									  
									  
	 <?=($net_profit_loss>0)?number_format($net_profit_loss,2):'('.number_format($net_profit_loss*(-1),2).')';?>
									  </strong></td>
									  </tr>
									<tr>
									  <td align="center">&nbsp;</td>
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