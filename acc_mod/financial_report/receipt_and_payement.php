<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Receipt & Payment Statement';


do_calander('#fdate');

do_calander('#tdate');



$fdate=$_REQUEST["fdate"];

$tdate=$_REQUEST['tdate'];

do_calander('#cfdate');

do_calander('#ctdate');


$cfdate=$_REQUEST["cfdate"];

$ctdate=$_REQUEST['ctdate'];


if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!=''){


$fdate=$_REQUEST['fdate'];
$tdate=$_REQUEST['tdate'];
$report_detail.='<br>Reporting Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'].'';

}

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

/////////////opening Balance////////////
$op_sql='select sum(j.dr_amt-j.cr_amt) as opening from accounts_ledger a,journal j where j.ledger_id=a.ledger_id and a.ledger_group_id=127002 and  j.jv_date<"'.$fdate.'"';
$op_query=db_query($op_sql);
while($orow=mysqli_fetch_object($op_query)){
$total_opening=$orow->opening;
}

?>									<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>
											<th rowspan="2">Date</th>
											<th rowspan="2">Particular</th>
											<th colspan="2">Bank</th>
											<th rowspan="2">Cheque No</th>
											<th colspan="3">Unclear Cheque</th>
											<th rowspan="2">Voucher No</th>
											<th rowspan="2">Amount in Taka</th>
											<th rowspan="2">Remarks</th>	 					 
										</tr>
										<tr>
										  <th>Name</th>
										  <th>Accounts Number</th>
										  <th>Clearing </th>
										  <th>Amount In Taka </th>
										  <th>Status: Honor or Dishonor </th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<th colspan="10" style="text-align:center;">Opening Balance</th>
											<th><?php echo $total_opening;?></th>
										</tr>
											<tr>
											<th colspan="11" style="text-align:center;">Receipt</th>
											 
										</tr>
										<?php 
										  $sql='select sum(j.dr_amt) as receipt,j.jv_date,a.ledger_name,a.ledger_id,j.cheq_no,j.jv_no from accounts_ledger a,journal j where j.ledger_id=a.ledger_id and a.ledger_group_id=127002 and  j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.dr_amt>0 group by j.jv_no order by ledger_id asc';
$query=db_query($sql);
while($row=mysqli_fetch_object($query)){
										
										?>
											<tr>
												<td><?php echo $row->jv_date;?></td>
												<td></td>
												<td><?php echo $row->ledger_name;?></td>
												<td></td>
												<td><?php echo $row->cheq_no;?></td>
												<td></td>
												<td></td>
												<td></td>
												<td><a href="../files/general_voucher_print_view_from_journal.php?jv_no=<?php echo $row->jv_no;?>"><?php echo $row->jv_no;?></a></td>
												<td><?php echo $row->receipt;?></td>
												<td></td>
											</tr>
											<?php 
											$gr_tot_bank+=$row->receipt;
											} ?>
											<tr>
												<th colspan="10">Total Bank Receipt</th>
												<th><?php echo $gr_tot_bank;?></th>
											</tr>
												<tr>
												<th colspan="10">Total Available Bank Balance</th>
												<th><?php echo $tot_available_bank=$total_opening+$gr_tot_bank;?></th>
											</tr>
											
												</tr>
											<tr>
											<th colspan="11" style="text-align:center;">Payment</th>
											 
										</tr>
											<?php 
										  $sqlp='select sum(j.cr_amt) as payment,j.jv_date,a.ledger_name,a.ledger_id,j.cheq_no,j.jv_no from accounts_ledger a,journal j where j.ledger_id=a.ledger_id and a.ledger_group_id=127002 and  j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.cr_amt>0 group by j.jv_no order by ledger_id asc';
$queryp=db_query($sqlp);
while($rowp=mysqli_fetch_object($queryp)){
										
										?>
											<tr>
												<td><?php echo $rowp->jv_date;?></td>
												<td></td>
												<td><?php echo $rowp->ledger_name;?></td>
												<td></td>
												<td><?php echo $rowp->cheq_no;?></td>
												<td></td>
												<td></td>
												<td></td>
												<td><a href="../files/general_voucher_print_view_from_journal.php?jv_no=<?php echo $rowp->jv_no;?>"><?php echo $rowp->jv_no;?></a></td>
												<td><?php echo $rowp->payment;?></td>
												<td></td>
											</tr>
											<?php 
											$gr_tot_bank_payment+=$rowp->payment;
											} ?>
											<tr>
												<th colspan="10">Total Bank Payment</th>
												<th><?php echo $gr_tot_bank_payment;?></th>
											</tr>
												<tr>
												<th colspan="10">Closing Balance Of All Bank</th>
												<th><?php echo $closing_bank=$tot_available_bank-$gr_tot_bank_payment;?></th>
											</tr>
										</tbody>

										
 
										
										
								
										
 
		

		
									 



</table>



<?

}
require_once SERVER_CORE."routing/layout.bottom.php";



?>