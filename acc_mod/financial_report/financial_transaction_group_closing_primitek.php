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

										

                                        <td align="right">Company :</td>



                                        <td width="23%" align="left">
<input name="group_for" type="hidden" id="group_for" size="12" style="max-width:250px;" readonly value="<?php echo $_REQUEST['group_for'];?>"/> 
<input name="group_for_show" type="text" id="group_for_show" size="12" style="max-width:250px;" readonly value="<?php echo find_a_field('user_group','group_name','id='.$_REQUEST['group_for']);?>"/>                                         
                                        
</td>

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

									

									<table id="grp" width="100%" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="48%" bgcolor="#82D8CF">&nbsp; Particular</th>

											<th width="13%" bgcolor="#82D8CF"><div align="center">Opening</div></th>
											<th width="13%" bgcolor="#82D8CF"><div align="center">DR Amt </div></th>
										    <th width="12%" bgcolor="#82D8CF"><div align="center">CR Amt </div></th>
										    <th width="14%" bgcolor="#82D8CF"><div align="center">Balance</div></th>
										</tr>
										</thead>

										

										
										
<?

$sql = "select l.group_id, sum(j.dr_amt-j.cr_amt) as opening_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id 
and j.group_for='".$_REQUEST['group_for']."' and j.jv_date<'".$fdate."' group by l.group_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_amt[$data->group_id]=$data->opening_amt;

}

 $sql = "select l.group_id, sum(j.dr_amt) as dr_amt, sum(j.cr_amt) as cr_amt 
 from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
 where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id 
 and j.group_for='".$_REQUEST['group_for']."' and j.jv_date between '".$fdate."' and '".$tdate."' group by l.group_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$dr_amt[$data->group_id]=$data->dr_amt;
$cr_amt[$data->group_id]=$data->cr_amt;

}


$sql = "select l.group_id, sum(j.dr_amt-j.cr_amt) as closing_amt 
from acc_sub_sub_class s, ledger_group l, accounts_ledger a, journal j
where s.id=l.acc_sub_sub_class and l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id 
and j.group_for='".$_REQUEST['group_for']."' and j.jv_date<='".$tdate."' group by l.group_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$closing_amt[$data->group_id]=$data->closing_amt;

}




	   
 $sql_sub1="select s.id, s.sub_sub_class_name from acc_sub_sub_class s where s.id='".$_REQUEST['acc_sub_sub_class']."' group by s.id";
$query_sub1=db_query($sql_sub1);

while($info_sub1=mysqli_fetch_object($query_sub1)){ 
	   
	   
	   ?>
									<tr>

										  <td bgcolor="#E0FFFF">&nbsp; <strong><?=$info_sub1->sub_sub_class_name;?></strong></td>

										  <td bgcolor="#E0FFFF">&nbsp;</td>
										  <td bgcolor="#E0FFFF">&nbsp;</td>
									      <td bgcolor="#E0FFFF">&nbsp;</td>
									      <td bgcolor="#E0FFFF">&nbsp;</td>
									</tr>
									  
									  

<?php


 $sql1="select l.group_id, l.group_name from ledger_group l where l.acc_sub_sub_class='".$_REQUEST['acc_sub_sub_class']."' 
group by l.group_id";

$query1=db_query($sql1);

while($data1=mysqli_fetch_object($query1)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="financial_transaction_ledger_closing.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&group_id=<?=$data1->group_id?>&group_for=<?=$_REQUEST['group_for']?>" target="_blank" style="color:#000000;">
	 <?=$data1->group_name;?></a></td>
										<td align="right"><? $opening_amt[$data1->group_id]; $tot_opening_amt +=$opening_amt[$data1->group_id];
			if ($opening_amt[$data1->group_id]>0) { echo  number_format($opening_amt[$data1->group_id],2). " (DR)"; } else { echo number_format($opening_amt[$data1->group_id]*(-1),2). " (CR)"; }
										?></td>
										<td align="right">
										<?=number_format($dr_amt[$data1->group_id],2); $tot_dr_amt +=$dr_amt[$data1->group_id];?>										</td>
									  <td align="right">
                                        <?=number_format($cr_amt[$data1->group_id],2); $tot_cr_amt +=$cr_amt[$data1->group_id];?>									    </td>
									  <td align="right"><? $closing_amt[$data1->group_id]; $tot_closing_amt +=$closing_amt[$data1->group_id];
			if ($closing_amt[$data1->group_id]>0) { echo  number_format($closing_amt[$data1->group_id],2). " (DR)"; } else { echo number_format($closing_amt[$data1->group_id]*(-1),2). " (CR)"; }
										?>                                   </td>
									  </tr>
									  
									  
									  
<? }?>	

 						<tr>

										  <td align="center"><strong>Total Amt:</strong></td>

										  <td align="right"><strong>
										  <? if ($tot_opening_amt>0) { echo  number_format($tot_opening_amt,2). " (DR)"; } else { echo number_format($tot_opening_amt*(-1),2). " (CR)"; } ?>										  </strong></td>
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