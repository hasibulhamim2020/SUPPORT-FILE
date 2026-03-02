<?php
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";

$title='Cost of Goods Sold';

do_calander('#fdate');

do_calander('#tdate');
$mon = $_POST['mon'];
$year = $_POST['year'];
$fdate = $year.'-'.$mon.'-01';
$mdays = date('t',strtotime($fdate));
$tdate = $year.'-'.$mon.'-'.$mdays;

if($fdate!='') {

$report_detail.='<br>Reporting Period: '.$fdate.' to '.$tdate.'';}

if(isset($_POST['process'])){
$jv_no = next_journal_sec_voucher_id($tr_from, 'Inventory_adjustment');
$jv_date = $_POST['jv_date'];
$proj_id = 'saas';
$inv_diff_balance = $_POST['diff_balance'];
$cogs_diff = $_POST['cogs_diff'];
$dnarr = 'Inventory adjustment';

$cogs_ledger = 168;
$inventory_adjustment_expense = 275;
$inventory_adjustment_income = 276;
$cogs_adjustment_increase = 277;
$cogs_adjustment_decrease = 278;
$mon = $_POST['mon'];
$year = $_POST['year'];


if($cogs_diff>0){

add_to_sec_journal($proj_id, $jv_no, $jv_date, $cogs_ledger, $dnarr, $cogs_diff, '0', $tr_from, $tr_no, $sub_ledger, '', $cc_code, '', $user_id, '', $r_from, $bank, $c_no, $cheq_date, $receive_ledger, $checked, $type, $employee, $remarks, $uploaded_file, $reference_id);

add_to_sec_journal($proj_id, $jv_no, $jv_date, $cogs_adjustment_increase, $dnarr, '0', $cogs_diff, $tr_from, $tr_no, $sub_ledger, '', $cc_code, '', $user_id, '', $r_from, $bank, $c_no, $cheq_date, $receive_ledger, $checked, $type, $employee, $remarks, $uploaded_file, $reference_id);

}elseif($cogs_diff<0){
$cogs_diff = $cogs_diff*(-1);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $cogs_adjustment_decrease, $dnarr, $cogs_diff, '0', $tr_from, $tr_no, $sub_ledger, '', $cc_code, '', $user_id, '', $r_from, $bank, $c_no, $cheq_date, $receive_ledger, $checked, $type, $employee, $remarks, $uploaded_file, $reference_id);

add_to_sec_journal($proj_id, $jv_no, $jv_date, $cogs_ledger, $dnarr, '0', $cogs_diff, $tr_from, $tr_no, $sub_ledger, '', $cc_code, '', $user_id, '', $r_from, $bank, $c_no, $cheq_date, $receive_ledger, $checked, $type, $employee, $remarks, $uploaded_file, $reference_id);

}



$sql="select l.ledger_id, l.ledger_name from item_sub_group c, accounts_ledger l where c.item_ledger=l.ledger_id order by l.ledger_name asc";
$query=db_query($sql);
while($data=mysqli_fetch_object($query)){
$inv_diff_balance = $_POST['ldiff_balance'.$data->ledger_id];
$total_in = $_POST['dr_amt'.$data->ledger_id];
$total_out = $_POST['cr_amt'.$data->ledger_id];

if($inv_diff_balance>0){

add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->ledger_id, $dnarr, $inv_diff_balance, '0', $tr_from, $tr_no, $sub_ledger, '', $cc_code, '', $user_id, '', $r_from, $bank, $c_no, $cheq_date, $receive_ledger, $checked, $type, $employee, $remarks, $uploaded_file, $reference_id);

add_to_sec_journal($proj_id, $jv_no, $jv_date, $inventory_adjustment_income, $dnarr, '0', $inv_diff_balance, $tr_from, $tr_no, $sub_ledger, '', $cc_code, '', $user_id, '', $r_from, $bank, $c_no, $cheq_date, $receive_ledger, $checked, $type, $employee, $remarks, $uploaded_file, $reference_id);

}elseif($inv_diff_balance<0){
$inv_diff_balance = $inv_diff_balance*(-1);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $inventory_adjustment_expense, $dnarr, $inv_diff_balance, '0', $tr_from, $tr_no, $sub_ledger, '', $cc_code, '', $user_id, '', $r_from, $bank, $c_no, $cheq_date, $receive_ledger, $checked, $type, $employee, $remarks, $uploaded_file, $reference_id);

add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->ledger_id, $dnarr, '0', $inv_diff_balance, $tr_from, $tr_no, $sub_ledger, '', $cc_code, '', $user_id, '', $r_from, $bank, $c_no, $cheq_date, $receive_ledger, $checked, $type, $employee, $remarks, $uploaded_file, $reference_id);

}


}

$insert = 'insert into month_closing set mon="'.$mon.'", year="'.$year.'",mon_date="'.$jv_date.'",entry_by="'.$_SESSION['user']['id'].'",entry_at="'.date('Y-m-d H:i:s').'"';
db_query($insert);

sec_journal_journal($jv_no,$jv_no,$tr_from);
$tr_type="Completed";

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



                                        <td width="20%" align="right">



		    Month :                                       </td>



                                        <td width="25%" align="left"> <div align="right">

                                          <select name="mon" id="mon">
                                           <option></option>
										   <? foreign_relation('months','month_id','month_name',$_POST['mon'],'1');?>

                                          </select>
                                        </div></td>



                                        <td width="20%" align="left"> <div align="center">Year: </div></td>

                                        <td width="25%" align="left"><select name="year" id="year">
                                           <option></option>
										   <option <?=($_POST['year']==2024)?'selected':''?> value="2024">2024</option>
										   <option <?=($_POST['year']==2025)?'selected':''?> value="2025">2025</option>
										   <option <?=($_POST['year']==2026)?'selected':''?> value="2026">2026</option>
										   <option <?=($_POST['year']==2027)?'selected':''?> value="2027">2027</option>
										   <option <?=($_POST['year']==2028)?'selected':''?> value="2028">2028</option>
										  

                                          </select></td>

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


<form action="" method="post">
									<div id="reporting" style="overflow:hidden">

									
<?php
if(isset($_REQUEST['show']))
{
	$tr_type="Search";
?>									<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>
                                         <tr>
											<th rowspan="2" width="53%" bgcolor="#82D8CF">&nbsp; Particular</th>
											<th colspan="2" width="23%" bgcolor="#82D8CF"><div align="center">Accounts</div></th>
											<th colspan="2" width="23%" bgcolor="#82D8CF"><div align="center">Inventory</th>    
										</tr>
										<tr>
											<th width="23%" bgcolor="#82D8CF"><div align="center">DR</div></th>
										    <th width="24%" bgcolor="#82D8CF"><div align="center">CR</div></th>
											<th width="23%" bgcolor="#82D8CF"><div align="center">DR</div></th>
										    <th width="24%" bgcolor="#82D8CF"><div align="center">CR</div></th>
										</tr>
										</thead>

										

										
										
<?


$sql = "select a.ledger_name,a.ledger_id, sum(j.dr_amt-j.cr_amt) as opening_rm from ledger_group l, accounts_ledger a, journal j where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<'".$fdate."' group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_rm[$data->ledger_id]=$data->opening_rm;
}

$sql = "select a.ledger_name,a.ledger_id, sum(j.dr_amt) as total_dr,sum(j.cr_amt) as total_cr,sum(j.dr_amt-j.cr_amt) as acc_diff from ledger_group l, accounts_ledger a, journal j where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$acc_dr[$data->ledger_id]=$data->total_dr;
$acc_cr[$data->ledger_id]=$data->total_cr;
$acc_diff[$data->ledger_id]=$data->acc_diff;
}

$sql = "select a.ledger_name,a.ledger_id, sum(j.dr_amt-j.cr_amt) as total_cogs from ledger_group l, accounts_ledger a, journal j where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date between '".$fdate."' and '".$tdate."' and a.ledger_id in (4110010002) group by a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$cogs[$data->ledger_id]=$data->total_cogs;
}


$sql = "select s.item_ledger,sum(j.item_in*j.item_price) as total_in, sum(j.item_ex*j.item_price) as total_out,sum(j.item_in) as item_in, sum(j.item_ex) as item_ex, sum(j.item_in-j.item_ex) as stock from journal_item j, item_info i, item_sub_group s where j.item_id=i.item_id and s.sub_group_id=i.sub_group_id and j.ji_date between '".$fdate."' and '".$tdate."' group by s.item_ledger";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$inv_dr[$data->item_ledger] = $data->total_in;
$inv_cr[$data->item_ledger] = $data->total_out;
$inv_diff[$data->item_ledger] = $data->total_in-$data->total_out;
}


	   
	   ?>
									
	<tr>
									  <td bgcolor="#E0FFFF"><span style="font-size:15px; font-weight:bold;">Accounts & Inventory Difference</span></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td colspan="2" bgcolor="#E0FFFF">&nbsp;</td>
	</tr>								  
									  

<?php


$sql="select l.ledger_id, l.ledger_name from item_sub_group c, accounts_ledger l where c.item_ledger=l.ledger_id order by l.ledger_name asc";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){

?>
								 	  <tr>
									  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->ledger_name;?><input type="hidden" name="ldiff_balance<?=$data->ledger_id?>" id="ldiff_balance<?=$data->ledger_id?>" value="<?=$inv_diff[$data->ledger_id]-$acc_diff[$data->ledger_id]?>" /></td>
                                      <td align="right"><?=number_format($acc_dr[$data->ledger_id],2); $total_acc_dr +=$acc_dr[$data->ledger_id];?>&nbsp;</td>
									  <td align="right"><?=number_format($acc_cr[$data->ledger_id],2); $total_acc_cr +=$acc_cr[$data->ledger_id];?>&nbsp;</td>
									  <td align="right"><?=number_format($inv_dr[$data->ledger_id],2); $total_inv_dr +=$inv_dr[$data->ledger_id];?>&nbsp;</td>
									  <td align="right"><?=number_format($inv_cr[$data->ledger_id],2); $total_inv_cr +=$inv_cr[$data->ledger_id];?>&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	



		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Total </strong></td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_acc_dr,2); ?></strong>&nbsp;</td>
				                      <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_acc_cr,2); ?></strong>&nbsp;</td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_inv_dr,2); ?></strong>&nbsp;</td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_inv_cr,2); $acc_closing =$total_acc_dr - $total_acc_cr; $inv_closing = $total_inv_dr-$total_inv_cr;  ?></strong>&nbsp;</td>
		</tr>				
                                      <tr>

										  <td><span style="font-size:15px; font-weight:bold;">Total Accounts Closing Balance</span></td>
                                          <td colspan="4" align="right" <span style="font-size:14px; font-weight:bold;"><? if($acc_closing>0){ echo number_format($acc_closing,2).' (DR)';}else{
										  echo number_format($acc_closing,2).' (CR)';
										  };?>&nbsp;</td>
									      
									  </tr>
									  
									  <tr>

										  <td><span style="font-size:15px; font-weight:bold;">Total Inventory Closing Balance</span></td>
                                          <td colspan="4" align="right" <span style="font-size:14px; font-weight:bold;"><? if($inv_closing>0){ echo number_format($inv_closing,2).' (DR)';}else{
										  echo number_format($inv_closing,2).' (CR)';
										  }; $inv_diff = $inv_closing-$acc_closing; ?>&nbsp;</td>
									      
									  </tr>
									  
									   <tr>

										  <td><span style="font-size:15px; font-weight:bold;">Accounts & Inventory Difference</span></td>
                                          <td colspan="4" align="right"> <span style="font-size:14px; font-weight:bold;"><? if($inv_diff>0){ echo number_format($inv_diff,2).' (DR)';}else{
										  echo number_format($inv_diff*(-1),2).' (CR)';
										  };?>&nbsp;<input type="hidden" name="diff_balance" id="diff_balance" value="<?=$inv_diff?>" /></td>
									      
									  </tr>
									   <?
									   $cogs_diff = $inv_closing - $cogs['4110010002'];
									   ?>
									  <tr>
                                        
										  <td><span style="font-size:15px; font-weight:bold;">Accounts & Inventory Cogs Difference</span></td>
                                          <td colspan="4" align="right"><span style="font-size:14px; font-weight:bold;"><? if($cogs_diff>0){ echo number_format($cogs_diff,2).' (DR)';}else{
										  echo number_format($cogs_diff*(-1),2).' (CR)';
										  };?>&nbsp;<input type="hidden" name="cogs_diff" id="cogs_diff" value="<?=$cogs_diff?>" /></td>
									      
									  </tr>
									  
									   <tr>
                                             <input type="hidden" name="mon" id="mon" value="<?=$mon?>" />
											 <input type="hidden" name="year" id="year" value="<?=$year?>" />
											 <input type="hidden" name="jv_date" id="jv_date" value="<?=$tdate?>" />
										  <td colspan="3"><input type="submit" name="process" id="process" value="Save" class="btn btn-primary" /></td>
                                          
									      
									  </tr>
					
									
									
					
					
					
									
									
									</table>

									

									  
									  
									  



									</div>

</form>





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