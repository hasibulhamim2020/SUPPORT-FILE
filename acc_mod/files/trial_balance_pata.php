<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Trial Balance Statement (Detail)';
$proj_id=$_SESSION['proj_id'];


if(isset($_REQUEST['show']))
{
$t_date=$_REQUEST['tdate'];
//fdate-------------------
$f_date='01-01-1970';
$ledger_id=$_REQUEST["ledger_id"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Report date Till: '.$_REQUEST['tdate'];
if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
$report_detail.='<br>CC Code : '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);


$j=0;
for($i=0;$i<strlen($f_date);$i++)
{
if(is_numeric($f_date[$i]))
$time1[$j]=$time1[$j].$f_date[$i];

else $j++;
}

$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);

//tdate-------------------


$j=0;
for($i=0;$i<strlen($t_date);$i++)
{
if(is_numeric($t_date[$i]))
$time[$j]=$time[$j].$t_date[$i];
else $j++;
}
$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);


}
?>
<?php $led1=db_query("SELECT id, center_name FROM cost_center WHERE 1 ORDER BY center_name");
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
		
	var data = <?php echo $data1; ?>;
    $("#cc_code").autocomplete(data, {
		matchContains: true,
		minChars: 0,        
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>ID: " + row.id + "</span>";
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
function DoNav(a,b,c)

{

	document.location.href = 'transaction_list.php?fdate='+a+'&tdate='+b+'&ledger_id='+c+'&show=Show';

}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="22%" align="right">
		    As On :                                       </td>
                                        <td align="left"><input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>" /> 
                                         </td>
                                      </tr>
                                      
                                      
                                      <tr>
                                        <td align="right">Cost Center : </td>
                                        <td align="left"><input type="text" name="cc_code" id="cc_code" value="<?php echo $_REQUEST['cc_code'];?>" size="50" /></td>
                                      </tr>
                                      
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
									<td><div id="reporting">
									<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th width="17%" height="20" align="center">S/N</th>
								<th width="45%" height="20" align="center">Head Of Accounts </th>
								<th width="19%" align="center">Debit Amount </th>
								<th width="19%" height="20" align="center">Credit Amount </th>
								</tr>
  <?php
  if(isset($_REQUEST['show']))
  {
	$total_dr=0;
  	$total_cr=0;
	
	$cc_code = (int) $_REQUEST['cc_code'];
	if($cc_code > 0)
	{
		$g="select DISTINCT c.group_name,SUM(dr_amt),SUM(cr_amt),c.group_id from accounts_ledger a, journal b,ledger_group c where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date <= '$tdate' and 1 AND b.cc_code=$cc_code and c.group_for=".$_SESSION['user']['group']." group by c.group_name";
	}
	else
	{
		$g="select DISTINCT c.group_name,SUM(dr_amt),SUM(cr_amt),c.group_id from accounts_ledger a, journal b,ledger_group c where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date <= '$tdate' and c.group_for=".$_SESSION['user']['group']." group by c.group_name";
	}

  $gsql=db_query($g);
  while($g=mysqli_fetch_row($gsql))
  {
  $total_dr=0;
  $total_cr=0;
?>
  <tr>
    <th colspan="4" align="left"><?php echo $g[0];?></th>
    </tr>

<?php
	$cc_code = (int) $_REQUEST['cc_code'];
	if($cc_code > 0)
	{
		$p="select DISTINCT a.ledger_name,SUM(dr_amt),SUM(cr_amt) from accounts_ledger a, journal b where a.ledger_id=b.ledger_id and b.jv_date<= '$tdate' and a.ledger_group_id='$g[3]' and 1 AND b.cc_code=$cc_code group by ledger_name order by a.ledger_name";
		
	}
	else
	{
		$p="select DISTINCT a.ledger_name,SUM(dr_amt),SUM(cr_amt),a.ledger_id from accounts_ledger a, journal b where a.ledger_id=b.ledger_id and b.jv_date<= '$tdate' and a.ledger_group_id='$g[3]' and 1 group by ledger_name order by a.ledger_name";

	}
  //echo $p;
$pi=0;
  $sql=db_query($p);
  while($p=mysqli_fetch_row($sql)){

  $pi++;
//  if($p[2]>$p[1])
//  {
//  $dr=0;
// $cr=$p[2]-$p[1];
//  }
//  else
//  {
//  $dr=$p[1]-$p[2];
//  $cr=0;
//  }

$dr=$p[1];
$cr=$p[2];
  ?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?> onclick="DoNav('<?php echo $f_date;?>','<?php echo $t_date;?>','<?php echo $p[3];?>');">
    <td align="center"><?php echo $pi;?></td>
    <td align="left"><?php echo $p[0];?></td>
    <td align="right"><?php echo number_format($dr,2);?></td>
    <td align="right"><?php echo number_format($cr,2);?></td>
    </tr>
  <?php
  $total_dr=$total_dr+$dr;
  $total_cr=$total_cr+$cr;
  $t_dr=$t_dr+$dr;
  $t_cr=$t_cr+$cr;
  }?>
  <tr>
    <th colspan="2" align="right">Total : (<?=number_format(($total_dr-$total_cr),2);?>)</th>
    <th align="right"><strong><?php echo number_format($total_dr,2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total_cr,2)?></strong></th>
  </tr>
  <?php }?>
<tr>
    <th colspan="2" align="right">Total Balance : (<?=number_format(($t_dr-$t_cr),2);?>)</th>
    <th align="right"><?php echo number_format($t_dr,2);?></th>
    <th align="right"><?php echo number_format($t_cr,2)?></th>
  </tr>

<?php }?>
</table> </div>
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