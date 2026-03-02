<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Receipt & Payment Statement Combined';


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

/////////////opening Balance Cash////////////
$op_sql='select sum(j.dr_amt-j.cr_amt) as opening,j.ledger_id from accounts_ledger a,journal j where j.ledger_id=a.ledger_id and a.ledger_group_id=127001 and  j.jv_date<"'.$fdate.'" group by a.ledger_id';
$op_query=db_query($op_sql);
while($orow=mysqli_fetch_object($op_query)){
$total_opening[$orow->ledger_id]=$orow->opening;
}

/////////////opening Balance Bank////////////
$op_sqlbank='select sum(j.dr_amt-j.cr_amt) as opening,j.ledger_id,a.ledger_group_id from accounts_ledger a,journal j where j.ledger_id=a.ledger_id and a.ledger_group_id=127002 and  j.jv_date<"'.$fdate.'"  ';
$op_query_bank=db_query($op_sqlbank);
while($orow_bank=mysqli_fetch_object($op_query_bank)){
$total_opening_bank =$orow_bank->opening;
}

/////////////////////

///////////// Receipt ////////////
    $rec_sql='select sum(j.cr_amt) as receipt,j.ledger_id,jv_no from journal j  where   j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.cr_amt>0 and jv_no in(select jv_no from journal where ledger_id=86 and jv_date between "'.$fdate.'" and "'.$tdate.'" and dr_amt>0 group by jv_no ) group by j.ledger_id,j.jv_no  ';
$rec_query=db_query($rec_sql);
while($rec_row=mysqli_fetch_object($rec_query)){
  $total_receipt_cashho[$rec_row->jv_no][$rec_row->ledger_id] =$rec_row->receipt;
}

    $rec_sql2='select sum(j.cr_amt) as receipt,j.ledger_id,jv_no from journal j  where   j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.cr_amt>0 and jv_no in(select jv_no from journal where ledger_id=87 and jv_date between "'.$fdate.'" and "'.$tdate.'" and dr_amt>0 group by jv_no) group by j.ledger_id,j.jv_no  ';
$rec_query2=db_query($rec_sql2);
while($rec_row2=mysqli_fetch_object($rec_query2)){
  $total_receipt_cashfactory[$rec_row2->jv_no][$rec_row2->ledger_id] =$rec_row2->receipt;
}

    $rec_sql3='select sum(j.cr_amt) as receipt,j.ledger_id,jv_no from journal j  where   j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.cr_amt>0 and jv_no in(select jv_no from journal where ledger_id=821 and jv_date between "'.$fdate.'" and "'.$tdate.'" and dr_amt>0 group by jv_no) group by j.ledger_id,j.jv_no  ';
$rec_query3=db_query($rec_sql3);
while($rec_row3=mysqli_fetch_object($rec_query3)){
  $total_receipt_cashctg[$rec_row3->jv_no][$rec_row3->ledger_id] =$rec_row3->receipt;
}


//$sqlbank='select sum(j.dr_amt) as receipt,j.ledger_id,a.ledger_group_id from accounts_ledger a,journal j where j.ledger_id=a.ledger_id and a.ledger_group_id=127002 and  j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.dr_amt>0 group by j.ledger_id,j.jv_no  ';

    $sqlbank='select sum(j.cr_amt) as receipt,j.ledger_id,jv_no from journal j  where   j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.cr_amt>0 and jv_no in(select j.jv_no from journal j,accounts_ledger a where j.ledger_id=a.ledger_id and jv_date between "'.$fdate.'" and "'.$tdate.'" and a.ledger_group_id=127002 and dr_amt>0 group by jv_no) group by j.ledger_id,j.jv_no  ';
$query_bank=db_query($sqlbank);
while($rec_row_bank=mysqli_fetch_object($query_bank)){
$total_rec_bank[$rec_row_bank->jv_no][$rec_row_bank->ledger_id] =$rec_row_bank->receipt;
}


///////////// Payment...................... ////////////
    $pay_sql='select sum(j.dr_amt) as payment,j.ledger_id,jv_no from journal j  where   j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.dr_amt>0 and jv_no in(select jv_no from journal where ledger_id=86 and jv_date between "'.$fdate.'" and "'.$tdate.'" and cr_amt>0 group by jv_no ) group by j.ledger_id,j.jv_no  ';
$pay_query=db_query($pay_sql);
while($pay_row=mysqli_fetch_object($pay_query)){
  $total_payment_cashho[$pay_row->jv_no][$pay_row->ledger_id] =$pay_row->payment;
}

    $pay_sql2='select sum(j.dr_amt) as payment,j.ledger_id,jv_no from journal j  where   j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.dr_amt>0 and jv_no in(select jv_no from journal where ledger_id=87 and jv_date between "'.$fdate.'" and "'.$tdate.'" and cr_amt>0 group by jv_no) group by j.ledger_id,j.jv_no  ';
$pay_query2=db_query($pay_sql2);
while($pay_row2=mysqli_fetch_object($pay_query2)){
  $total_payment_cashfactory[$pay_row2->jv_no][$pay_row2->ledger_id] =$pay_row2->payment;
}

    $pay_sql3='select sum(j.dr_amt) as payment,j.ledger_id,jv_no from journal j  where   j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.dr_amt>0 and jv_no in(select jv_no from journal where ledger_id=821 and jv_date between "'.$fdate.'" and "'.$tdate.'" and cr_amt>0 group by jv_no) group by j.ledger_id,j.jv_no  ';
$pay_query3=db_query($pay_sql3);
while($pay_row3=mysqli_fetch_object($pay_query3)){
  $total_payment_cashctg[$pay_row3->jv_no][$pay_row3->ledger_id] =$pay_row3->payment;
}


//$sqlbank='select sum(j.dr_amt) as receipt,j.ledger_id,a.ledger_group_id from accounts_ledger a,journal j where j.ledger_id=a.ledger_id and a.ledger_group_id=127002 and  j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.dr_amt>0 group by j.ledger_id,j.jv_no  ';

    $sqlbank_pay='select sum(j.dr_amt) as payment,j.ledger_id,jv_no from journal j  where   j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.dr_amt>0 and jv_no in(select j.jv_no from journal j,accounts_ledger a where j.ledger_id=a.ledger_id and jv_date between "'.$fdate.'" and "'.$tdate.'" and a.ledger_group_id=127002 and cr_amt>0 group by jv_no) group by j.ledger_id,j.jv_no  ';
$query_bank_pay=db_query($sqlbank_pay);
while($pay_row_bank=mysqli_fetch_object($query_bank_pay)){
$total_pay_bank[$pay_row_bank->jv_no][$pay_row_bank->ledger_id] =$pay_row_bank->payment;
}


?>									<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>
											<tr>
												<th>Date</th>
												<th>Particular</th>
												<th>Voucher No</th>
												<th> Cash in Hand H/O</th>
												<th>Cash at Factory</th>
												<th> Cash in Hand (CTG)</th>
												<th>Total Bank</th>
												 
											</tr>
											
										
										 
										</thead>
										<tbody>
										<tr>
											<th colspan="7">Receipt</th>
										</tr>
											<tr>
												<th colspan="3">Opening Balance</th>
												<th><?php echo $cash_opening_headoffice=$total_opening[86];?></th>
												<th><?php echo $cash_opening_factory=$total_opening[87];?></th>
												<th><?php echo $cash_opening_ctg=$total_opening[821];?></th>
												<th><?php echo $total_opening_bank;?></th>
											</tr>
											
												<?php 
												
												$sql='select j.*,a.ledger_name from journal j,accounts_ledger a where j.ledger_id=a.ledger_id and jv_no in(select j.jv_no from journal j,accounts_ledger a where j.ledger_id=a.ledger_id and a.ledger_group_id in(127001,127002) and  j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.dr_amt>0 group by j.jv_no ) and cr_amt>0 group by ledger_id';
												
						 
$query=db_query($sql);
while($row=mysqli_fetch_object($query)){
 
										
										?>
										 	<tr>
												<td><?php echo $row->jv_date;?></td>
												<td><?php echo $row->ledger_name;?></td>
												<td><a href="../files/general_voucher_print_view_from_journal.php?jv_no=<?php echo $row->jv_no;?>"><?php echo $row->jv_no;?></a></td>
												<td><?php echo $tot_cash_rec_ho=$total_receipt_cashho[$row->jv_no][$row->ledger_id];?></td>
												<td><?php echo $tot_cash_rec_factory=$total_receipt_cashfactory[$row->jv_no][$row->ledger_id];?></td>
												<td><?php echo $tot_cash_rec_ctg=$total_receipt_cashctg[$row->jv_no][$row->ledger_id];?></td>
												<td><?php echo $tot_bank_rec=$total_rec_bank[$row->jv_no][$row->ledger_id];?></td>
												<td></td>
											</tr>
											<?php 
											$gr_tot_cash_ho_rec+=$tot_cash_rec_ho;
											$gr_tot_cash_fac_rec+=$tot_cash_rec_factory;
											$gr_tot_cash_ctg_rec+=$tot_cash_rec_ctg;
											$gr_tot_bank_rec+=$tot_bank_rec;
											} ?>
											<tr>
												<th colspan="3">Total Receipt</th>
												<th><?php echo $gr_tot_cash_ho_rec;?></th>
												<th><?php echo $gr_tot_cash_fac_rec;?></th>
												<th><?php echo $gr_tot_cash_ctg_rec;?></th>
												<th><?php echo $gr_tot_bank_rec;?></th>
											</tr>
											
													<tr>
												<th colspan="3">Total Available Balance</th>
												<th><?php echo $tot_avail_rec_ho=$cash_opening_headoffice+$gr_tot_cash_ho_rec;?></th>
												<th><?php echo $tot_avail_rec_fac=$cash_opening_factory+$gr_tot_cash_fac_rec;?></th>
												<th><?php echo $tot_avail_rec_ctg=$cash_opening_ctg+$gr_tot_cash_ctg_rec;?></th>
												<th><?php echo $tot_avail_rec_bank=$total_opening_bank+$gr_tot_bank_rec;?></th>
											</tr>
											
											<tr>
											<th colspan="7">Payment</th>
										</tr>
											
											<?php 
												
												$sqlp='select j.*,a.ledger_name from journal j,accounts_ledger a where j.ledger_id=a.ledger_id and jv_no in(select j.jv_no from journal j,accounts_ledger a where j.ledger_id=a.ledger_id and a.ledger_group_id in(127001,127002) and  j.jv_date between "'.$fdate.'" and "'.$tdate.'" and j.cr_amt>0 group by j.jv_no ) and dr_amt>0 group by ledger_id';
												
						 
$queryp=db_query($sqlp);
while($rowp=mysqli_fetch_object($queryp)){
 
										
										?>
										 	<tr>
												<td><?php echo $rowp->jv_date;?></td>
												<td><?php echo $rowp->ledger_name;?></td>
												<td><a href="../files/general_voucher_print_view_from_journal.php?jv_no=<?php echo $rowp->jv_no;?>"><?php echo $rowp->jv_no;?></a></td>
												<td><?php echo $tot_cash_pay_ho=$total_payment_cashho[$rowp->jv_no][$rowp->ledger_id];?></td>
												<td><?php echo $tot_cash_pay_factory=$total_payment_cashfactory[$rowp->jv_no][$rowp->ledger_id];?></td>
												<td><?php echo $tot_cash_pay_ctg=$total_payment_cashctg[$rowp->jv_no][$rowp->ledger_id];?></td>
												<td><?php echo $tot_bank_pay=$total_pay_bank[$rowp->jv_no][$rowp->ledger_id];?></td>
												<td></td>
											</tr>
											<?php 
											$gr_tot_cash_ho_pay+=$tot_cash_pay_ho;
											$gr_tot_cash_fac_pay+=$tot_cash_pay_factory;
											$gr_tot_cash_ctg_pay+=$tot_cash_pay_ctg;
											$gr_tot_bank_pay+=$tot_bank_pay;
											} ?>
													<tr>
												<th colspan="3">Total Payment</th>
												<th><?php echo $gr_tot_cash_ho_pay;?></th>
												<th><?php echo $gr_tot_cash_fac_pay;?></th>
												<th><?php echo $gr_tot_cash_ctg_pay;?></th>
												<th><?php echo $gr_tot_bank_pay;?></th>
											</tr>
											
												<tr>
												<th colspan="3">Total Closing Balance</th>
												<th><?php echo $tot_closing_bal_ho=$tot_avail_rec_ho-$gr_tot_cash_ho_pay;?></th>
												<th><?php echo $tot_closing_bal_fac=$tot_avail_rec_fac-$gr_tot_cash_fac_pay;?></th>
												<th><?php echo $tot_closing_bal_ctg=$tot_avail_rec_ctg-$gr_tot_cash_ctg_pay;?></th>
												<th><?php echo $tot_closing_bal_bank=$tot_avail_rec_bank-$gr_tot_bank_pay;?></th>
											</tr>
										</tbody>

 
</table>



<?

}

require_once SERVER_CORE."routing/layout.bottom.php";




?>