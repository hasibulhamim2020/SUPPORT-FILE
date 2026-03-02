<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Statement of Financial Position';

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
?>									<table id="grp" width="100%" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="70%" bgcolor="#82D8CF">&nbsp; Particular</th>

											<th width="30%" bgcolor="#82D8CF" align="center"><div align="center">Amount</div></th>
										</tr>
										</thead>

		<tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>ASSETS</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				  </tr>								

										
										
<?

 $sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as asset_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and j.group_for='".$_POST['group_for']."'
 group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$asset_amt[$data->acc_sub_sub_class]=$data->asset_amt;

}


$sql = "select l.acc_sub_sub_class, sum(j.cr_amt-j.dr_amt) as liability_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and l.acc_sub_sub_class not in (213)  and  j.jv_date<='".$tdate."' 
 and j.group_for='".$_POST['group_for']."' group by l.acc_sub_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$liability_amt[$data->acc_sub_sub_class]=$data->liability_amt;

}



	   
 $sql_sub1="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=1
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
<td align="right">
<a href="financial_transaction_group_closing_primitek.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data1->id?>&group_for=<?=$_POST['group_for']?>" target="_blank">
<?=number_format($asset_amt[$data1->id],2); $tot_asset_amt +=$asset_amt[$data1->id];?></a></td>
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_asset_amt,2); $net_tot_asset_amt +=$tot_asset_amt;?>
										  </strong></td>
									  </tr>


							  
		<? 
		$tot_asset_amt=0;
		}
		?>
		
		
									<tr>

										  <td align="center"><strong>Total Assets:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($net_tot_asset_amt,2);?>
										  </strong></td>
									  </tr>
									  
									  <tr>
									  <td align="center">&nbsp;</td>
									  <td align="right">&nbsp;</td>
									  </tr>
										

			<tr>
										  <td bgcolor="#D8BFD8">&nbsp;<strong>EQUITY & LIABILITIES</strong></td>
										  <td bgcolor="#D8BFD8">&nbsp;</td>
				  </tr>	
				  
				  							
										
								
										
<?
//opening data
$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as opening_ret_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 and s.id=215 
 and j.group_for='".$_POST['group_for']."' group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_ret_amt[$data->acc_sub_class]=$data->opening_ret_amt;
}



 $sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as opening_sc_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 and s.id!=215 
 and j.group_for='".$_POST['group_for']."' group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_sc_amt[$data->acc_sub_class]=$data->opening_sc_amt;
}


 $sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_ope_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and a.acc_class=3 
 and j.group_for='".$_POST['group_for']."' group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_ope_amt[$data->acc_class]=$data->sales_ope_amt;
}

   $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_ope_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and a.acc_class=4 
 and j.group_for='".$_POST['group_for']."' group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$exp_ope_amt[$data->acc_class]=$data->exp_ope_amt;
}
//opening data


 //$sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_amt 
// from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
// where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$tdate."' and a.acc_class=3 group by a.acc_class";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$sales_amt[$data->acc_class]=$data->sales_amt;
//}
//
// $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_amt 
//from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
// where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$tdate."' and a.acc_class=4 group by a.acc_class";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$exp_amt[$data->acc_class]=$data->exp_amt;
//}
//
//
//$retained_earnings=$sales_amt[3]-$exp_amt[4];
//$net_retained_earnings=$retained_earnings;

//transaction during the period
$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as ret_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and s.acc_sub_class=21 and s.id=215 and j.group_for='".$_POST['group_for']."' group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$ret_amt[$data->acc_sub_class]=$data->ret_amt;
}

$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as sc_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and s.acc_sub_class=21 and s.id!=215 and j.group_for='".$_POST['group_for']."' group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sc_amt[$data->acc_sub_class]=$data->sc_amt;
}


 $sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and a.acc_class=3 
 and j.group_for='".$_POST['group_for']."' group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt[$data->acc_class]=$data->sales_amt;
}


   $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and a.acc_class=4 
 and j.group_for='".$_POST['group_for']."' group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$exp_amt[$data->acc_class]=$data->exp_amt;
}
//transaction during the period

$retained_earning_ledger_value_opening=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=97 and jv_date<="'.$fdate.'" and group_for="'.$_POST['group_for'].'"');
$retained_earning_ledger_value_during=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=97 and jv_date between "'.$fdate.'" and "'.$tdate.'" and group_for="'.$_POST['group_for'].'"');

if($retained_earning_ledger_value_opening>0){$pos_retained_earning_ledger_value_opening=$retained_earning_ledger_value_opening;}
else{$pos_retained_earning_ledger_value_opening=($retained_earning_ledger_value_opening*(-1));}

$retained_earnings_ope=(($sales_ope_amt[3]+$opening_ret_amt[21])-$exp_ope_amt[4])+$pos_retained_earning_ledger_value_opening;
$net_retained_earnings_ope=$retained_earnings_ope;
if($net_retained_earnings_ope>0){$pos_net_reatined_earnings_ope=$net_retained_earnings_ope;}else{$pos_net_reatined_earnings_ope=($net_retained_earnings_ope*(-1));}

$retained_earnings=(($sales_amt[3]+$ret_amt[21])-$exp_amt[4])+$retained_earning_ledger_value_during;
$net_retained_earnings=$retained_earnings;

$grand_retained_earnings=$pos_net_reatined_earnings_ope+$retained_earnings;

if($grand_retained_earnings>0){$pos_grand_retained_earnings=$grand_retained_earnings;}else{$pos_grand_retained_earnings=($grand_retained_earnings*(-1));}

//$net_retained_earnings=((($sales_amt[3]+$ret_amt[21])-$exp_amt[4])+$retained_earning_ledger_value_during)*(-1);
/*
$sql = "select a.ledger_group_id, sum(j.cr_amt-j.dr_amt) as sales_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and l.acc_class=3";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt=$data->sales_amt;
}

$sql = "select a.acc_class, sum(j.dr_amt) as purchase_amt 
 from cogs_configuration c, ledger_group l, accounts_ledger a, journal j 
 where c.group_id=l.group_id and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and c.type in ('RM')";
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
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<='".$tdate."' and l.acc_class=4";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt=$data->expense_amt;
}

$material_cost=$purchase_amt-$rm_closing;

$total_cogs_amt=$material_cost+$expense_amt;
if($fdate<='2023-10-31'){
   $ret_opening=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=1590 and tr_from="Opening"');
}
else{
    
   $ret_opening=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=1590 and jv_date<"'.$fdate.'"'); 
}
$net_retained_earnings=($sales_amt-$total_cogs_amt)-$ret_opening;

*/

	   
    $sql_sub2="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=2 and s.id=21 group by s.id";
    $query_sub2=db_query($sql_sub2);

    while($info_sub2=mysqli_fetch_object($query_sub2)){ 
	   
	   
	   ?>

									
									  <tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub2->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql2="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub2->id."' and ss.id not in (213,215)   order by ss.id";

$query2=db_query($sql2);

while($data2=mysqli_fetch_object($query2)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data2->sub_sub_class_name;?></td>

										  <td align="right">
										  
		 <a href="financial_transaction_group_closing_primitek.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data2->id?>&group_for=<?=$_POST['group_for']?>" target="_blank">
		 <?=number_format($liability_amt[$data2->id],2); $equity_amt +=$liability_amt[$data2->id];?></a></td>
									  </tr>
									  
									  
<? }?>	
<tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retained Earnings</td>

										  <td align="right">
										  
		 <a href="financial_changes_equity_primitek.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>" target="_blank"><?=number_format($pos_grand_retained_earnings,2);?>	</a></td>
									  </tr>

 						<tr>
  <?php /*?> <?=number_format($tot_equity_amt=$equity_amt+$net_retained_earnings,2);?><?php */?>
										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_equity_amt=$equity_amt+$pos_grand_retained_earnings,2);?>
										  </strong></td>
 						</tr>


							  
		<? }?>
		
		
		<?
	   
  $sql_sub3="select s.id, s.sub_class_name from acc_sub_class s where s.acc_class=2 and s.id!=21
group by s.id";
$query_sub3=db_query($sql_sub3);

while($info_sub3=mysqli_fetch_object($query_sub3)){ 
	   
	   
	   ?>

									
										<tr>

										  <td bgcolor="#D8BFD8">&nbsp; <strong><?=$info_sub3->sub_class_name;?></strong></td>

										  <td bgcolor="#D8BFD8">&nbsp;</td>
									  </tr>
									  
									  

<?php


$sql3="select ss.id, ss.sub_sub_class_name from acc_sub_sub_class ss where ss.acc_sub_class='".$info_sub3->id."'  order by ss.id";

$query3=db_query($sql3);

while($data3=mysqli_fetch_object($query3)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data3->sub_sub_class_name;?></td>

										  <td align="right">
										  
		 <a href="financial_transaction_group_closing_primitek.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&acc_sub_sub_class=<?=$data3->id?>&group_for=<?=$_POST['group_for']?>" target="_blank">
		 <?=number_format($liability_amt[$data3->id],2); $tot_liability_amt +=$liability_amt[$data3->id];?></a></td>
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Sub Total:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($tot_liability_amt,2); $net_tot_liability_amt +=$tot_liability_amt;?>
										  </strong></td>
 						</tr>


							  
		<? 
		$tot_liability_amt=0;
		}?>
		
		
									<tr>

										  <td align="center"><strong> Total Equity & Liabilities:</strong></td>

										  <td align="right"><strong>
									      <?=number_format($total_equity_liabilities=$tot_equity_amt+$net_tot_liability_amt,2);?>
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