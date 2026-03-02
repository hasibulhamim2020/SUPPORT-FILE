<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







$title='Transaction Details';





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

                                          <input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" />

                                        </div></td>



                                        <td width="8%" align="left"> <div align="center">--- </div></td>

                                        <td width="50%" align="left"><input name="tdate" type="text" id="tdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['tdate'];?>"/></td>

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

									

									<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="48%" bgcolor="#82D8CF">&nbsp; Particular</th>

											<th width="14%" bgcolor="#82D8CF"><div align="center">Opening</div></th>
											<th width="14%" bgcolor="#82D8CF"><div align="center">DR Amt </div></th>
										    <th width="11%" bgcolor="#82D8CF"><div align="center">CR Amt </div></th>
										    <th width="13%" bgcolor="#82D8CF"><div align="center">Balance</div></th>
										</tr>
										</thead>

										

										
										
<?

$sql = "select a.ledger_id, sum(j.dr_amt-j.cr_amt) as opening_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<'".$fdate."' group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_amt[$data->ledger_id]=$data->opening_amt;
}


 $sql = "select a.ledger_id, sum(j.dr_amt) as dr_amt, sum(j.cr_amt) as cr_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$dr_amt[$data->ledger_id]=$data->dr_amt;
$cr_amt[$data->ledger_id]=$data->cr_amt;
}

$sql = "select a.ledger_id, sum(j.dr_amt-j.cr_amt) as closing_amt from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and  j.jv_date<='".$tdate."' group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$closing_amt[$data->ledger_id]=$data->closing_amt;
}




	   
 $sql_sub1="select l.group_id, l.group_name from ledger_group l where l.group_id='".$_REQUEST['group_id']."' group by l.group_id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->group_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
										  <td bgcolor="#E0FFFF">&nbsp;</td>
									      <td bgcolor="#E0FFFF">&nbsp;</td>
									      <td bgcolor="#E0FFFF">&nbsp;</td>
									</tr>
									  
									  

<?php


 $sql1="select a.ledger_id, a.ledger_name from accounts_ledger a where a.ledger_group_id='".$_REQUEST['group_id']."' 
group by a.ledger_id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>

<?php /*?><a href="../files/transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$data1->ledger_id?>" target="_blank" style="color:#000000;">
<?=$data1->ledger_name;?></a><?php */?>
<?php /*?><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<? if ($data1->ledger_id==189 || $data1->ledger_id==64) {?>
<a href="../files/transaction_subledger_summary.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$data1->ledger_id?>" target="_blank" style="color:#000000;">
<?=$data1->ledger_name;?></a>


<? } else { ?>
<a href="../files/transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$data1->ledger_id?>" target="_blank" style="color:#000000;">
<?=$data1->ledger_name;?></a>
<? } ?>
</td><?php */?>

<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<a href="../files/transaction_subledger_summary.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$data1->ledger_id?>" target="_blank" style="color:#000000;">
<?=$data1->ledger_name;?></a>

</td>
										<td align="right">
										<? $opening_amt[$data1->ledger_id]; $tot_opening_amt +=$opening_amt[$data1->ledger_id];
			if ($opening_amt[$data1->ledger_id]>0) { echo  number_format($opening_amt[$data1->ledger_id],2). " (DR)"; } else { echo number_format($opening_amt[$data1->ledger_id]*(-1),2). " (CR)"; }
										?>
										</td>
										<td align="right">
										<?=number_format($dr_amt[$data1->ledger_id],2); $tot_dr_amt +=$dr_amt[$data1->ledger_id];?>										</td>
									  <td align="right">
                                        <?=number_format($cr_amt[$data1->ledger_id],2); $tot_cr_amt +=$cr_amt[$data1->ledger_id];?>									    </td>
									  <td align="right">
									  <? $closing_amt[$data1->ledger_id]; $tot_closing_amt +=$closing_amt[$data1->ledger_id];
			if ($closing_amt[$data1->ledger_id]>0) { echo  number_format($closing_amt[$data1->ledger_id],2). " (DR)"; } else { echo number_format($closing_amt[$data1->ledger_id]*(-1),2). " (CR)"; }
										?>
									                                       </td>
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Total Amt:</strong></td>

										  <td align="right"> <strong><? if ($tot_opening_amt>0) { echo  number_format($tot_opening_amt,2). " (DR)"; } else { echo number_format($tot_opening_amt*(-1),2). " (CR)"; } ?></strong></td>
										  <td align="right"><strong>
									      <?=number_format($tot_dr_amt,2); ?>
										  </strong></td>
									      <td align="right"><strong>
                                            <?=number_format($tot_cr_amt,2); ?>
                                          </strong></td>
 						                  <td align="right"><strong>
                                            <? if ($tot_closing_amt>0) { echo  number_format($tot_closing_amt,2). " (DR)"; } else { echo number_format($tot_closing_amt*(-1),2). " (CR)"; } ?>
                                          </strong></td>
 						</tr>


							  
		<? }?>
									</table>

									

									  
									  
									  



									</div>







									</td>



								</tr>



						</table>



		</div></td>    



  </tr>



</table>



<?



require_once SERVER_CORE."routing/layout.bottom.php";




?>