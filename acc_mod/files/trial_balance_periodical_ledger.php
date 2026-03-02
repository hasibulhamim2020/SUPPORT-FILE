<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Trial Balance Periodical(Detail)';
$proj_id=$_SESSION['proj_id'];

if($_REQUEST['tdate']!='' )
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST["fdate"].' to '.$_REQUEST['tdate'];
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
</script>
<style type="text/css">
body {
    font-size: 10px;
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
                                        <td align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
									  
                                       <tr>
                                        <td align="right">Ledger Group : </td>
                                        <td align="left">
										<select name="group_id" id="group_id">
										<? foreign_relation('ledger_group','group_id','group_name',$_REQUEST['group_id'],"group_for=".$_SESSION['user']['group']);?>
										</select>
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
									<td> <div id="reporting">
									<table id="grp"  class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
    <th width="4%" height="20" align="center">S/N</th>
    <th width="42%" height="20" align="center">Ledger Group </th>
    <th width="15%" align="center">Opening</th>
    <th width="12%" align="center">Debit </th>
    <th width="12%" align="center">Credit </th>
    <th width="15%" height="20" align="center">Closing</th>
    </tr>
  <?php
if($_REQUEST['fdate']!='' )
{

if($_REQUEST['group_id']>0 )
$grp_con = " and  c.group_id='".$_REQUEST['group_id']."'";

	$total_dr=0;
	$total_cr=0;
	
	$cc_code = (int) $_REQUEST['cc_code'];
	if($cc_code > 0)
	{
		$g="select c.group_name,SUM(dr_amt),SUM(cr_amt),c.group_id FROM accounts_ledger a, journal b,ledger_group c where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date BETWEEN '$fdate' AND '$tdate' and c.group_for=".$_SESSION['user']['group']." ".$grp_con."  AND b.cc_code=$cc_code group by  c.group_id";
		
	}
	else
	{
		$g="select c.group_name,SUM(dr_amt),SUM(cr_amt),c.group_id FROM accounts_ledger a, journal b,ledger_group c where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date BETWEEN '$fdate' AND '$tdate' ".$grp_con." and c.group_for=".$_SESSION['user']['group']."  group by  c.group_id";

	}

  $gsql=db_query($g);
  while($g=mysqli_fetch_row($gsql))
  {
  $total_dr=0;
  $total_cr=0;
  ?>
  <tr>
    <th colspan="6" align="left"><?php echo $g[0];?></th>
    </tr>

<?php
	$cc_code = (int) $_REQUEST['cc_code'];
	if($cc_code > 0)
	{
		$p="select DISTINCT a.ledger_name,SUM(dr_amt),SUM(cr_amt),a.ledger_id from accounts_ledger a, journal b where a.ledger_id=b.ledger_id and b.jv_date BETWEEN '$fdate' AND '$tdate' and a.ledger_group_id='$g[3]' and 1 AND b.cc_code=$cc_code and a.group_for=".$_SESSION['user']['group']." group by ledger_name order by a.ledger_name";
		
	}
	else
	{
		$p="select DISTINCT a.ledger_name,SUM(dr_amt),SUM(cr_amt),a.ledger_id from accounts_ledger a, journal b where a.ledger_id=b.ledger_id and b.jv_date BETWEEN '$fdate' AND '$tdate' and a.ledger_group_id='$g[3]' and a.group_for=".$_SESSION['user']['group']." group by ledger_name order by a.ledger_name";

	}
//echo $p;
$pi=0;
  $sql=db_query($p);
  while($p=mysqli_fetch_row($sql))
  {

$query="select SUM(dr_amt),SUM(cr_amt) from journal where jv_date < '$fdate' and ledger_id='$p[3]' and group_for=".$_SESSION['user']['group'];
$ssql=db_query($query);
$open=mysqli_fetch_row($ssql);
$opening = $open[0]-$open[1];



  $pi++;
//  if($p[2]>$p[1])
//  {
//	  $dr=0; $cr=$p[2]-$p[1];
//  }
//  else
//  {
//	  $dr=$p[1]-$p[2];
//	  $cr=0;
//  }
$dr=$p[1];
$cr=$p[2];

  $closing = $opening + $dr - $cr;
if($opening>0)
{ $tag='(Dr)';}
elseif($opening<0)
{ $tag='(Cr)';$opening=$opening*(-1);}

if($closing>0)
{ $tagc='(Dr)';}
elseif($closing<0)
{ $tagc='(Cr)';$closing=$closing*(-1);}
  ?>
<tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="center"><?php echo $pi;?></td>
    <td align="left"><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$p[3]?>" target="_blank"><?php echo $p[0];?></a></td>
    <td align="right"><?=number_format($opening,2).' '.$tag;?></td>
    <td align="right"><?php echo number_format($dr,2);?></td>
    <td align="right"><?php echo number_format($cr,2);?></td>
    <td align="right"><?=number_format($closing,2).' '.$tagc;?></td>
</tr>
  <?php
  $total_dr=$total_dr+$dr;
  $total_cr=$total_cr+$cr;
  $t_dr=$t_dr+$dr;
  $t_cr=$t_cr+$cr;
  }?>
  
  <?php }?>
<tr>
    <th colspan="2" align="right">Total Balance : <?php echo number_format(($t_dr-$t_cr),2);?></th>
    <th align="right">&nbsp;</th>
   <th align="right"><strong><?php echo number_format($t_dr,2);?></strong></th>
    <th align="right"><strong><?php echo number_format($t_cr,2)?></strong></th>
    <th align="right">&nbsp;</th>
</tr>

<?php }?>
</table> 
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