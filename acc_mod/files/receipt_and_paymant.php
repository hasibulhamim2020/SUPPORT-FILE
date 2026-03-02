<?php
/*session_start();
ob_start();
require "../support/inc.report.php";
require_once ('../common/class.numbertoword.php');*/

session_start();
ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../common/class.numbertoword.php');

$title='Receive and Payment Statement';
$proj_id=$_SESSION['proj_id'];
jv_double_check();
if($_SESSION['user']['group']>1)
$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' and group_for=".$_SESSION['user']['group']);

else

$cash_and_bank_balance=find_a_field('ledger_group','group_id','group_sub_class=1020');

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Report date : '.$_REQUEST['tdate'];
if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
$report_detail.='<br>CC Code : '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);


$j=0;
for($i=0;$i<strlen($fdate);$i++)
{
if(is_numeric($fdate[$i]))
$time1[$j]=$time1[$j].$fdate[$i];

else $j++;
}

$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);

//tdate-------------------


$j=0;
for($i=0;$i<strlen($tdate);$i++)
{
if(is_numeric($tdate[$i]))
$time[$j]=$time[$j].$tdate[$i];
else $j++;
}
$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);


}
?>
<?php  
	
	$led1=db_query("SELECT id, center_name FROM cost_center WHERE 1 ORDER BY center_name");
	  if(mysqli_num_rows($led1) > 0)
	  {	
		  $data1 = '[';
		  while($ledg1 = mysqli_fetch_row($led1)){
			  $data1 .= '{ name: "'.$ledg1[1].'", id: "'.$ledg1[0].'" },';
		  }
		  $data1 = substr($data1, 0, -1);
		  $data1 .= ']';
	  }
	  else
	  {
		$data1 = '[{ name: "empty", id: "" }]';
	  }
?>
<script type="text/javascript">

$(document).ready(function(){

    function formatItem(row) {
		//return row[0] + " " + row[1] + " ";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

    var data = <?php echo $data; ?>;
    $("#ledger_id").autocomplete(data, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
	
	var data = <?php echo $data1; ?>;
    $("#cc_code").autocomplete(data, {
		matchContains: true,
		minChars: 0,        
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name + " : [" + row.id + "]";
		},
		formatResult: function(row) {            
			return row.id;
		}
	});	
  });
	
</script>
<script type="text/javascript">
$(document).ready(function(){
	
	$(function() {
		$("#fdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
	});
		$(function() {
		$("#tdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
	});

});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form autocomplete="off" id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="22%" align="right">
		    Period :                                       </td>
                                        <td align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
                                      
                                      <tr>
                                        <td align="right">Ledger Head :</td>
                                        <td align="left"><?php
$led="select a.ledger_id,a.ledger_name from accounts_ledger a  where 1 and a.ledger_group_id in (1002,1004) and a.parent=0 and a.ledger_name like '%ash%'  order by a.ledger_id";
										  //echo $led;
                                    echo '<select name="ledger_id" id="ledger_id">';
                                          $led1=db_query($led);
                                          while($ledg=mysqli_fetch_row($led1)){
                                          if($ledger_id==$ledg[0]) echo "<option value=\"$ledg[0]\" selected>$ledg[0]: $ledg[1]</option>";
                                          else echo "<option value=\"$ledg[0]\">$ledg[0]: $ledg[1]</option>";}
                                          ?>
                                            </select>                                        </td>
                                      </tr>
									  
									  
									  <tr>
                                        <td align="right">Employee Name :</td>
                                        <td align="left"><select name="pbi_id" id="pbi_id" style="width:250px;">
                    <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['pbi_id'],'1 and PBI_JOB_STATUS="In Service" and PBI_DESIGNATION not in(2,5) order by PBI_ID');?>
                  </select> </td>
                                      </tr>
                                      

                                      <tr>
                                      <tr>
                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td><div id="reporting"><div id="grp">
						<table class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th width="6%">S/N</th>
                                <th width="17%">Voucher No</th>
                                <th width="10%">Date</th>
                                <th width="7%">Type</th>
                                <th width="18%">Head Of A/C</th>
                                <th width="11%">Employee Name </th>
                                <th width="11%">Narration</th>
								<th width="15%">Debit(TK)</th>
								<th width="16%">Credit(TK)</th>
							  </tr>
							  <tr>
							  	<th colspan="9" style="text-align:center"><strong>Receive</strong></th>
							  </tr>
<?php
	if(isset($_REQUEST['show']))
  {
	$cc_code = (int) $_REQUEST['cc_code'];
	
	$psql		= "select a.jv_no,a.cr_amt from journal a where  jv_date between '$fdate' and '$tdate'  and  a.ledger_id='$ledger_id' order by a.jv_date,a.tr_no";
	$pquery		= db_query($psql);
	$pcount     = mysqli_num_rows($pquery);
	if($pcount>0)
	{
	while($info=mysqli_fetch_object($pquery)){
	++$c;
	if($c==1){$jvs .= $info->jv_no;}
	else{$jvs .= ','.$info->jv_no;}
	}
	}
	//echo $jvs;
	if($cc_code > 0)
	{

		
	}
	else
	{


		$op		= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date<'$fdate' and group_for=".$_SESSION['user']['group'];
		$open	= mysqli_fetch_row(db_query($op));
		$cur	= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date between '$fdate' and '$tdate' and group_for=".$_SESSION['user']['group'];
		
		
		$current = mysqli_fetch_row(db_query($cur));
		$close	= $open[0]+$current[0];
		$p		= "select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_no,a.narration,a.tr_from,a.jv_no,a.cheq_no,a.cheq_date,a.PBI_ID from journal a,accounts_ledger b where a.ledger_id=b.ledger_id and jv_no in (".$jvs.")  and a.dr_amt>0 and a.ledger_id='$ledger_id' order by a.jv_date,a.tr_no";

	}
$i=0;
	$report = db_query($p);
	$old_jv = 1;
	while($rp=mysqli_fetch_row($report)){ 
	if($old_jv != $rp[4]) $i++; else echo '&nbsp;';
	if($i%2==0)$cls=' class="alt"'; else $cls='';
	
	$cr_total=$cr_total+$rp[3];
  	$dr_total=$dr_total+$rp[2];
	
	if($old_tp != $rp[6]) $i=1;$old_tp = $rp[6];
	
	?>
							  <tr<?=$cls?>>
										<td><? if($old_jv != $rp[4]) echo $i;?></td>
										<td><? 
										
		
										if($old_jv != $rp[4]) 
										{
										$link="voucher_print.php?v_type=".$rp[6]."&v_date=".$ro[0]."&view=1&vo_no=".$rp[7];
										echo "<a href='$link' target='_blank'>".$rp[4]."</a>";}?></td>
                                        <td><?=date('d-m-Y',$rp[0]);?></td>
                                        <td><? if($old_jv != $rp[4]) echo $rp[6];?></td>
										<td><?=$rp[1];?></td>
										<td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$rp[10]);?></td>
										<td><?=$rp[5];?><?=(($rp[8]!='')?'-Cq#'.$rp[8]:'');?><?=(($rp[9]>943898400)?'-Cq-Date#'.date('d-m-Y',$rp[9]):'');?></td>								
										<td style="text-align:right"><?=$rp[2];?></td>
										<td style="text-align:right"><?=$rp[3];?></td>
							 </tr>
	<?php $old_jv = $rp[4];  }
	?>
							 <tr>
								<th colspan="7" align="right">Total : </th>
								<th><?=number_format($dr_total,2);?></th>
								<th><?=number_format($cr_total,2);?></th>
							  </tr>
                              
                              
                              
	<? //}?>
	
	
	
	
	<!--------------------------------For payment Entry Report-------------------------------------------------------------------------->
							  <tr>
							  	<th colspan="9" style="text-align:center"><strong>Payment</strong></th>
							  </tr>
	<?php
	
	$cc_code = (int) $_REQUEST['cc_code'];
	
	$pbi_id = $_REQUEST['pbi_id'];
	
	if($pbi_id>0){ $con = " and a.PBI_ID = '$pbi_id' "; }
	
	$psql		= "select a.jv_no,a.cr_amt from journal a where  jv_date between '$fdate' and '$tdate'  and  a.ledger_id='$ledger_id' ".$con."  order by a.jv_date,a.tr_no";
	$pquery		= db_query($psql);
	$pcount     = mysqli_num_rows($pquery);
	if($pcount>0)
	{
	while($info=mysqli_fetch_object($pquery)){
	++$c;
	if($c==1){$jvs .= $info->jv_no;}
	else{$jvs .= ','.$info->jv_no;}
	}
	}
	//echo $jvs;
	if($cc_code > 0)
	{

		
	}
	else
	{

		
		$op		= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date<'$fdate' and group_for=".$_SESSION['user']['group'];
		$open	= mysqli_fetch_row(db_query($op));
		$cur	= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date between '$fdate' and '$tdate' and group_for=".$_SESSION['user']['group'];
		
		
		$current = mysqli_fetch_row(db_query($cur));
		$close	= $open[0]+$current[0];
		if($pbi_id>0){ $con = " and a.PBI_ID = '$pbi_id' "; }
		$p		= "select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_no,a.narration,a.tr_from,a.jv_no,a.cheq_no,a.cheq_date,a.PBI_ID from journal a,accounts_ledger b where a.ledger_id=b.ledger_id and jv_no in (".$jvs.")  and a.cr_amt>0 and a.ledger_id='$ledger_id' ".$con." order by a.jv_date,a.tr_no";

	}
$i=0;
	$report = db_query($p);
	$old_jv = 1;
	while($rp=mysqli_fetch_row($report)){ 
	if($old_jv != $rp[4]) $i++; else echo '&nbsp;';
	if($i%2==0)$cls=' class="alt"'; else $cls='';
	
	$cr_total=$cr_total+$rp[3];
  	$dr_total=$dr_total+$rp[2];
	
	if($old_tp != $rp[6]) $i=1;$old_tp = $rp[6];
	
	?>
							  <tr<?=$cls?>>
										<td><? if($old_jv != $rp[4]) echo $i;?></td>
										<td><? 
										
		
										if($old_jv != $rp[4]) 
										{
										$link="voucher_print.php?v_type=".$rp[6]."&v_date=".$ro[0]."&view=1&vo_no=".$rp[7];
										echo "<a href='$link' target='_blank'>".$rp[4]."</a>";}?></td>
                                        <td><?=date('d-m-Y',$rp[0]);?></td>
                                        <td><? if($old_jv != $rp[4]) echo $rp[6];?></td>
										<td><?=$rp[1];?></td>
										<td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$rp[10]);?></td>
										<td><? //echo $rp[5];?><?=(($rp[8]!='')?'-Cq#'.$rp[8]:'');?><?=(($rp[9]>943898400)?'-Cq-Date#'.date('d-m-Y',$rp[9]):'');?>
										<?=find_a_field('journal','narration',' jv_no='.$rp[7].' and tr_from like "'.$rp[6].'" and dr_amt>0 ');?></td>								
										<td style="text-align:right"><?=$rp[2];?></td>
										<td style="text-align:right"><?=$rp[3];?></td>
							 </tr>
	<?php $old_jv = $rp[4];  }
	?>
							 <tr>
								<th colspan="7" align="right">Total : </th>
								<th><?=number_format($dr_total,2);?></th>
								<th><?=number_format($cr_total,2);?></th>
							  </tr>
                              
                              
                              
	<?
	}?>
							</table> 
									<br /><br />     
									
									
							<table class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th width="6%">S/N</th>
                                <th width="10%">Date</th>
								<th width="10%">Payment Date</th>
								<th width="11%">Employee Name </th>
                                <th width="7%">Status</th>
								<th width="7%">Amount</th>
							  </tr>	
							  
							  <tr><td style="text-align:center" colspan="6"><strong>Conveyance Payment</strong></td></tr>
							  
					<?  $f_date=date('Y-m-d',strtotime($_POST['fdate']));  $t_date=date('Y-m-d',strtotime($_POST['tdate']));
					
					if($pbi_id>0){ $con2 = " and p.PBI_ID = '$pbi_id' "; }
					
					

	$i=1;
	 $sql="select m.task_id,m.task_id,m.task_date, m.payment_at , p.PBI_NAME as name  , m.status,sum(d.amount) as t_amount,d.amount 
	
	from daily_task_master m,personnel_basic_info p,daily_task_details d 
	
	where  m.task_id=d.task_id ".$checked_con." and m.entry_by=p.PBI_ID and m.status in ('PAID','RECEIVED') and m.payment_at between '".$f_date."' and '".$t_date."' ".$con2." ".$dealer_type_con."  group by m.entry_by";

	  $query=db_query($sql);
	  while($re = mysqli_fetch_object($query)){

		  ?>
		  
							  
							  <tr>
							  	<td><?=$i++;?></td>
								<td><?=$re->task_date;?></td>
								<td><?=date('Y-m-d',strtotime($re->payment_at));?></td>
								<td><?=$re->name;?></td>
								<td><?=$re->status;?></td>
								<td><?=$re->t_amount; $total_tamount+=$re->t_amount;?></td>
							  </tr>
	<? } ?>		
							  <tr>
							  		<td style="text-align:right" colspan="5"> <strong>Total :</strong> </td>
									<td><strong><?=number_format($total_tamount,2);?></strong></td>
							  </tr>				  
							</table>  	
									
									
									
									<br /> <br />    
									
							<table class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th width="6%">S/N</th>
                                <th width="10%">Date</th>
								<th width="10%">Payment Date</th>
								<th width="11%">Employee Name </th>
                                <th width="7%">Status</th>
								<th width="7%">Amount</th>
							  </tr>	
							  
							  <tr><td style="text-align:center" colspan="6"><strong>Vendor Payment</strong></td></tr>
							  
					<?  $f_date=date('Y-m-d',strtotime($_POST['fdate']));  $t_date=date('Y-m-d',strtotime($_POST['tdate']));

	$i=1;
	 $sql="select u.id, u.customer, u.date, u.payment_at, p.PBI_NAME as name  , u.status, sum(u.inst_amt) as t_amount
	
	from task_update u,personnel_basic_info p
	
	where   u.entry_by=p.PBI_ID and u.status in ('Paid','Received') and u.payment_at between '".$f_date."' and '".$t_date."' ".$con2."  group by u.entry_by";

	  $query=db_query($sql);
	  while($re = mysqli_fetch_object($query)){

		  ?>
		  
							  
							  <tr>
							  	<td><?=$i++;?></td>
								<td><?=$re->date;?></td>
								<td><?=date('Y-m-d',strtotime($re->payment_at));?></td>
								<td><?=$re->name;?></td>
								<td><?=$re->status;?></td>
								<td><?=$re->t_amount; $total_tamount1+=$re->t_amount;?></td>
							  </tr>
	<? } ?>		
							  <tr>
							  		<td style="text-align:right" colspan="5"> <strong>Total :</strong> </td>
									<td><strong><?=number_format($total_tamount1,2);?></strong></td>
							  </tr>				  
							</table>		
									
									
									
									<br /> <br />                  
                            <table class="tabledesign"   width="100%" cellspacing="0" cellpadding="2" border="0">
                              <tr>
                                <th width="70%">Opening Balance :</th>
                                <th width="30%" align="right"><?php if($open[0]==0) echo "0.00"; else echo number_format($open[0],2);?></th>
                              </tr>
                              <tr class="alt">
                                <th>Received in this Period :</th>
                                <th align="right"><?=number_format($dr_total,2);?></th>
                              </tr>
                              <tr class="alt">
                                <th>Total after Received :</th>
								<? $total_after_rcv=$open[0]+$dr_total; ?>
                                <th align="right"><?=number_format(($total_after_rcv),2);?></th>
                              </tr>
                              <tr class="alt">
                                <th>Payment in this Period :</th>
                                <th align="right"><?=number_format($cr_total,2);?></th>
                              </tr>
                              
                              <tr>
                                <th>Closing Balance :</th>
                                <th align="right"><?php echo number_format($total_after_rcv-$cr_total,2);?></th>
                              </tr>
                            </table>
                            <br />
                            <!--Amount Inwords:-->
                            <? // echo convertNumberMhafuz($close)?>
                            <br />
                            <br /><br /><br />
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#FFFFFF">
							  <tr style="border-bottom:#FFFFFF">
							  	<td align="center" valign="bottom" style="border-bottom:#FFFFFF;border-left:0px;;border-right:0px; border-bottom:0px;">
									<?=find_a_field('user_activity_management','fname','user_id='.$_SESSION['user']['id']);?><br />
									<? 
										$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
										
										echo $dt->format('F j, Y, g:i a');
									?>
                                </td>
							  </tr>
                              <tr style="border-bottom:#FFFFFF">

                                <td align="center" valign="bottom" style="border-bottom:#FFFFFF;border-left:0px;;border-right:0px; border-bottom:0px;">
                                
                               .........................................
                                </td>
                                <td align="center" valign="bottom" style="border-bottom:#FFFFFF; border-left:0px;border-right:0px; border-bottom:0px;">........................</td>
                                <td align="center" valign="bottom" style="border-bottom:#FFFFFF; border-left:0px;border-right:0px; border-bottom:0px;">................................</td>
                                <td align="center" valign="bottom" style="border-bottom:#FFFFFF; border-left:0px;border-right:0px; border-bottom:0px;">............................</td>
                                <td align="center" valign="bottom" style="border-bottom:#FFFFFF; border-left:0px;border-right:0px; border-bottom:0px;">................................</td>
                              </tr>
                              <tr>

                                <td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px; border-bottom:0px;"><div align="center">Prepared by </div></td>
                                <td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px; border-bottom:0px;"><div align="center">Checked by </div></td>
                                <td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px; border-bottom:0px;"><div align="center">Head of Accounts</div></td>
                                <td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px; border-bottom:0px;"><div align="center">Director/ED</div></td>
                                <td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px; border-bottom:0px;"><div align="center">DMD/MD/Proprietor</div></td>
                              </tr>
                            </table>
									</div></div>                            
							<div id="pageNavPosition"></div></td>
						  </tr>
						</table>
					</div></td>    
					</tr>
					</table>
					
				

<?
/*$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";*/

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>