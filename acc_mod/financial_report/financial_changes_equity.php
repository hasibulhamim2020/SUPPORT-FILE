<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";







$title='Statement of Changes in Equity	';





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
                                        <td width="22%" align="right">From Date: </td>



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



									<div id="reporting" style="overflow:hidden">

									
<?php
if(isset($_REQUEST['show']))
{
	$tr_type="Search";
?>									<table id="grp"  width="100%" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="46%" bgcolor="#82D8CF">&nbsp; Particulars</th>

											<th width="18%" bgcolor="#82D8CF" align="center"><div align="center">Share Capital</div></th>
											<th width="19%" bgcolor="#82D8CF" align="center"><div align="center">Retained Earnings</div></th>
											<th width="17%" bgcolor="#82D8CF" align="center"><div align="center">Total</div></th>
										</tr>
										</thead>

										

										
										
<?


$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as opening_ret_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 and s.id=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_ret_amt[$data->acc_sub_class]=$data->opening_ret_amt;
}



 $sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as opening_sc_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 and s.id!=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_sc_amt[$data->acc_sub_class]=$data->opening_sc_amt;
}


 $sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_ope_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and a.acc_class=3 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_ope_amt[$data->acc_class]=$data->sales_ope_amt;
}

   $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_ope_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and a.acc_class=4 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$exp_ope_amt[$data->acc_class]=$data->exp_ope_amt;
}






$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as ret_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and s.acc_sub_class=21 and s.id=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$ret_amt[$data->acc_sub_class]=$data->ret_amt;
}

$sql = "select s.acc_sub_class, sum(j.cr_amt-j.dr_amt) as sc_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and s.acc_sub_class=21 and s.id!=215 group by s.acc_sub_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sc_amt[$data->acc_sub_class]=$data->sc_amt;
}


 $sql = "select a.acc_class, sum(j.cr_amt-j.dr_amt) as sales_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j 
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and a.acc_class=3 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$sales_amt[$data->acc_class]=$data->sales_amt;
}


   $sql = "select a.acc_class, sum(j.dr_amt-j.cr_amt) as exp_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' and a.acc_class=4 group by a.acc_class";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$exp_amt[$data->acc_class]=$data->exp_amt;
}


//$sql = "select l.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as expenses_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
// where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by l.acc_sub_sub_class";
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query)){
//$expenses_amt[$data->acc_sub_sub_class]=$data->expenses_amt;
//
//}


 //$opening_sc="SELECT sum(j.cr_amt-j.dr_amt) as opening_sc_amt
// FROM acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j  
// WHERE s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' and s.acc_sub_class=21 group by s.acc_sub_class";
//$opening_sc_amt = find_a_field_sql($opening_sc);
$net_opening_sc_amt=$opening_sc_amt[21];
$net_sales_ope_amt=$sales_ope_amt[3];
$net_exp_ope_amt=$exp_ope_amt[4];
$retained_earnings_ope=($sales_ope_amt[3]+$opening_ret_amt[21])-$exp_ope_amt[4];
$net_retained_earnings_ope=$retained_earnings_ope;
$total_equity_ope=$opening_sc_amt[21]+$retained_earnings_ope;
$net_total_equity_ope=$total_equity_ope;


$net_sc_amt=$sc_amt[21];
$retained_earnings=($sales_amt[3]+$ret_amt[21])-$exp_amt[4];
$net_retained_earnings=$retained_earnings;
$total_equity=$sc_amt[21]+$retained_earnings;
$net_total_equity=$total_equity;


$grand_sc_amt=$opening_sc_amt[21]+$sc_amt[21];
$grand_retained_earnings=$retained_earnings_ope+$retained_earnings;
$grand_total_equity=$total_equity_ope+$total_equity;

   
	   ?>
			<tr>
					  <td bgcolor="#E0FFFF">&nbsp; Balance as on <strong><?=date("d M, Y",strtotime($fdate))?></strong></td>

										  <td bgcolor="#E0FFFF" align="right">  
	<?=($net_opening_sc_amt>0)?number_format($net_opening_sc_amt,2):'('.number_format($net_opening_sc_amt*(-1),2).')';?>										  </td>
										  <td bgcolor="#E0FFFF" align="right">
    <?=($net_retained_earnings_ope>0)?number_format($net_retained_earnings_ope,2):'('.number_format($net_retained_earnings_ope*(-1),2).')';?>										  </td>
										  <td bgcolor="#E0FFFF" align="right">
	 <?=($net_total_equity_ope>0)?number_format($net_total_equity_ope,2):'('.number_format($net_total_equity_ope*(-1),2).')';?>										  </td>
									  </tr>
									  
									  
							  
									  
									  <tr>

										  <td>&nbsp;Comprehensive Income/Loss For The Year</td>
                                          <td align="right">
	<?=($net_sc_amt>0)?number_format($net_sc_amt,2):'('.number_format($net_sc_amt*(-1),2).')';?>										  </td>
                                          <td align="right">
	 <?=($net_retained_earnings>0)?number_format($net_retained_earnings,2):'('.number_format($net_retained_earnings*(-1),2).')';?>										  </td>
                                        <td align="right">
    <?=($net_total_equity>0)?number_format($net_total_equity,2):'('.number_format($net_total_equity*(-1),2).')';?></td>
									  </tr>
									  
									  
	

 						<tr>

										  <td align="left">&nbsp;<strong>Balance as on <?=date("d M, Y",strtotime($tdate))?></strong></td>

										  <td align="right"><strong>
			<?=($grand_sc_amt>0)?number_format($grand_sc_amt,2):'('.number_format($grand_sc_amt*(-1),2).')';?>	</strong>										  </td>
										  <td align="right"><strong>
			 <?=($grand_retained_earnings>0)?number_format($grand_retained_earnings,2):'('.number_format($grand_retained_earnings*(-1),2).')';?></strong>										  </td>
										  <td align="right"><strong>
			<?=($grand_total_equity>0)?number_format($grand_total_equity,2):'('.number_format($grand_total_equity*(-1),2).')';?></strong>										  </td>
									  </tr>


		
									
										

										
										
								
			
										
									  
									  
						</table>

									

									  
				<? }?>					  
									  



									</div>







									</td>



								</tr>



						</table>


</table>



<?



require_once SERVER_CORE."routing/layout.bottom.php";


?>