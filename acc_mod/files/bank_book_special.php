<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../common/class.numbertoword.php');
jv_double_check();
$title='Bank Book (Special)';
$proj_id=$_SESSION['proj_id'];
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
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);
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
			dateFormat: 'dd-mm-y'
		});
	});
		$(function() {
		$("#tdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-y'
		});
	});

});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="22%" align="right">
		    Period :                                       </td>
                                        <td align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Cost Center : </td>
                                        <td align="left"><input type="text" name="cc_code" id="cc_code" value="<?php echo $_REQUEST['cc_code'];?>" size="50" /></td>
                                      </tr><tr>
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
								<th>S/N</th>
                                <th>Voucher No</th>
                                <th>Type</th>
                                <th>Head Of A/C</th>
                                <th>Narration</th>
								<th>Debit(TK)</th>
								<th>Credit(TK)</th>
								<th>User</th>
								</tr>
<?php
	if(isset($_REQUEST['show']))
  {
	$cc_code = (int) $_REQUEST['cc_code'];
	
	$psql		= "select distinct a.jv_no from journal a, accounts_ledger l where l.ledger_id=a.ledger_id and l.ledger_type='Bank' and jv_date between '$fdate' and '$tdate' and tr_from!='Collection' order by a.jv_date,a.tr_no";
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


		$op		= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date<'$fdate' and 1 AND cc_code=$cc_code and group_for=".$_SESSION['user']['group'];
		
		$open	= mysqli_fetch_row(db_query($op));
		$cur	= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date between '$fdate' and '$tdate' and 1 AND cc_code=$cc_code and group_for=".$_SESSION['user']['group'];

		$current = mysqli_fetch_row(db_query($cur));
		$close	= $open[0]+$current[0];

	  $p		= "select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_no,a.narration,a.tr_from,u.fname,a.cheq_no,a.cheq_date from journal a,accounts_ledger b,user_activity_management u where u.user_id = a.user_id and a.ledger_id=b.ledger_id AND a.cc_code=$cc_code and jv_no in (".$jvs.") order by a.jv_no,a.dr_amt desc";
	}
	else
	{


		$op		= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date<'$fdate' and group_for=".$_SESSION['user']['group'];
		$open	= mysqli_fetch_row(db_query($op));
		$cur	= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date between '$fdate' and '$tdate' and group_for=".$_SESSION['user']['group'];
		
		
		$current = mysqli_fetch_row(db_query($cur));
		$close	= $open[0]+$current[0];
		$p		= "select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_no,a.narration,a.tr_from,a.jv_no,u.fname,a.cheq_no,a.cheq_date from journal a,accounts_ledger b,user_activity_management u where u.user_id = a.user_id and a.ledger_id=b.ledger_id and jv_no in (".$jvs.") order by a.jv_no,a.dr_amt desc";

	}
$i=0;
	$report = db_query($p);
	$old_jv = 1;
	while($rp=mysqli_fetch_row($report)){ 
	if($old_jv != $rp[7]) $i++; else echo '&nbsp;';
	if($i%2==0)$cls=' class="alt"'; else $cls='';
	
	$cr_total=$cr_total+$rp[3];
  	$dr_total=$dr_total+$rp[2];
	
	$old_tp = $rp[6];
	
	?>
							  <tr<?=$cls?>>
										<td><? if($old_jv != $rp[7]) echo $i;?></td>
										<td><? 
										
		
										if($old_jv != $rp[7]) 
										{
										if($rp[6]=='Receipt'||$rp[6]=='Payment'||$rp[6]=='Journal_info'||$rp[6]=='Contra'){
										$link="voucher_print.php?v_type=".$rp[6]."&v_date=".$ro[0]."&view=1&vo_no=".$rp[7];
										echo "<a href='$link' target='_blank'>".$rp[4]."</a>";
										}else
										{
										echo $rp[4];
										}
										}?></td>
                                        <td><? if($old_jv != $rp[7]) echo $rp[6];?></td>
										<td><?=$rp[1];?></td>
										<td><?=$rp[5];?><?=(($rp[9]!='')?'-Cq#'.$rp[9]:'');?><?=(($rp[10]>943898400)?'-Cq-Date#'.date('d-m-Y',$rp[10]):'');?></td>								
										<td><?=$rp[2];?></td>
										<td><?=$rp[3];?></td>
										<td><? if($old_jv != $rp[7]) echo $rp[8];?></td>
									  </tr>
	<?php $old_jv = $rp[7];  }
	?>
							 <tr>
								<th colspan="5" align="right">Total : </th>
								<th><?=number_format($dr_total,2);?></th>
								<th><?=number_format($cr_total,2);?></th>
								<th>&nbsp;</th>
								</tr>
                              
                              
                              
	<?
	}?>
							</table> 
									</div>
									</div>                            
							</td>
						  </tr>
						</table>

							</div></td>
    
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>