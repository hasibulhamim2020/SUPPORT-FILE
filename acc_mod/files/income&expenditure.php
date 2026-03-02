<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Income Statement';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')
$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"]);
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
		    Period :                                       </td>
                                        <td align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
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
								<th width="18%" height="20" align="center">&nbsp;</th>
								<th width="47%" height="20" align="center">Head of Account </th>
								<th width="17%" align="center">Amount (Tk.) </th>
								<th width="18%" height="20" align="center">Amount (Tk.) </th>
								</tr>
								  <tr>
								<td colspan="4" align="left">REVENUE INCOME:</td>
								</tr>
  <?php
	if(isset($_REQUEST['show']))
	{
		$cc_code = (int) $_REQUEST['cc_code'];
		if($cc_code > 0)
		{
			$total = mysqli_fetch_row(db_query("select sum(dr_amt),sum(cr_amt) from journal where jv_date>'$fdate' and jv_date<'$tdate' and ledger_id like '$ledger_id' and 1 AND cc_code=$cc_code"));
			$p = "SELECT a.group_name,sum(dr_amt),sum(cr_amt) from ledger_group a, accounts_ledger b, journal c where a.group_class='200' and a.group_id=b.ledger_group_id and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1 AND c.cc_code=$cc_code group by a.group_name";
		
		}
		else
		{
			$total=mysqli_fetch_row(db_query("select sum(dr_amt),sum(cr_amt) from journal where jv_date>'$fdate' and jv_date<'$tdate' and ledger_id like '$ledger_id' and 1"));
			$p="SELECT a.group_name,sum(dr_amt),sum(cr_amt) from ledger_group a, accounts_ledger b, journal c where a.group_class='200' and a.group_id=b.ledger_group_id and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1 group by a.group_name";
			
		}
  //echo $p;
	$pi=0;
	$ti=0;
	$sql=db_query($p);
	while($data=mysqli_fetch_row($sql))
	{
		$pi++;
		$amt=($data[2]-$data[1]);
		$ti=$ti+$amt;
  ?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="center">&nbsp;</td>
    <td align="left"><?php echo $data[0];?></td>
    <td align="right"><?php echo $amt;?></td>
    <td align="center"></td>
    </tr><?php }?>  <?php }?>
  <tr>
    <th colspan="3" align="right">Total Income : </th>
    <th align="right"><?php echo $ti;?>&nbsp;</th>
  </tr>
  <tr>
    <td colspan="4" align="left">REVENUE EXPENDITURE:</td>
    </tr>
  <?php
	if(isset($_REQUEST['show']))
	{
		$cc_code = (int) $_REQUEST['cc_code'];
		if($cc_code > 0)
		{
			$total = mysqli_fetch_row(db_query("select sum(dr_amt),sum(cr_amt) from journal where jv_date>'$fdate' and jv_date<'$tdate' and ledger_id like '$ledger_id' and 1 AND cc_code=$cc_code"));
			$p = "SELECT a.group_name,sum(dr_amt),sum(cr_amt) from ledger_group a, accounts_ledger b, journal c where a.group_class='300' and a.group_id=b.ledger_group_id and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1 AND cc_code=$cc_code group by a.group_name";
			
		}
		else
		{
						$total=mysqli_fetch_row(db_query("select sum(dr_amt),sum(cr_amt) from journal where jv_date>'$fdate' and jv_date<'$tdate' and ledger_id like '$ledger_id' and 1"));
			$p="SELECT a.group_name,sum(dr_amt),sum(cr_amt) from ledger_group a, accounts_ledger b, journal c where a.group_class='300' and a.group_id=b.ledger_group_id and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1 group by a.group_name";

		}
		//echo $p;
	$pi=0;
	$te=0;
	$sql=db_query($p);
	while($data=mysqli_fetch_row($sql))
	{
		$pi++;
		$amt2=($data[1]-$data[2]);
		$te=$te+$amt2;
  ?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="center">&nbsp;</th>
    <td align="left"><?php echo $data[0];?></td>
    <td align="right"><?php echo $amt2;?></td>
    <td align="center"></td>
  </tr>
  <?php }?>  
  <?php }?>
  <tr>
  <tr>
    <th colspan="3" align="right">Total Expenditure : </th>
    <th align="right"><?php echo $te;?>&nbsp;</th>
  </tr>
  <tr>
    <th colspan="3" align="right">Net Profit/(Loss) : </th>
    <th align="right"><?php if(($ti-$te)<0) echo "(".($te-$ti).")"; else echo $ti-$te;?>&nbsp;</th>
  </tr>
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