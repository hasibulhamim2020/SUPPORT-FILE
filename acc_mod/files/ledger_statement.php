<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Ledger Book';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];
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
<?php $led=db_query("select ledger_id,ledger_name from accounts_ledger where 1 order by ledger_name");
      $data = '[';
      $data .= '{ name: "All", id: "%" },';
	  while($ledg = mysqli_fetch_row($led)){
          $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
	  }
      $data = substr($data, 0, -1);
      $data .= ']';
//echo $data;
	
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
                                        <td align="right">Ledger Head :</td>
                                        <td align="left"><input type="text" name="ledger_id" id="ledger_id" value="<?php echo $_REQUEST['ledger_id'];?>" size="50" /></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Cost Center : </td>
                                        <td align="left"><input type="text" name="cc_code" id="cc_code" value="<?php echo $_REQUEST['cc_code'];?>" size="50" /></td>
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
									<td><div id="reporting">
								<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
								 <tr>
								<th width="5%" align="center">S/N</th>
								<th width="30%" align="center">Ledger Head </th>
								<th width="15%" align="center">Opening Amt </th>
								<th width="15%" align="center">Debit Amt </th>
								<th width="15%" align="center">Credit Amt </th>
								<th colspan="2" align="center">Balance</th>
								</tr>
  <?php
if(isset($_REQUEST['show']))
{
	$cc_code = (int) $_REQUEST['cc_code'];
	if($cc_code > 0)
	{
		$p="SELECT DISTINCT 
				  a.ledger_name,
				  SUM(dr_amt) AS FIELD_1,
				  SUM(cr_amt) AS FIELD_2,
				  (SELECT SUM(dr_amt) - SUM(cr_amt) AS FIELD_1 FROM journal j WHERE j.jv_date < '$fdate' AND j.ledger_id = a.ledger_id AND j.cc_code = $cc_code) AS opening,
				  a.balance_type,
				  (SELECT SUM(dr_amt) - SUM(cr_amt) AS FIELD_1 FROM journal j WHERE j.jv_date < '$tdate' AND j.ledger_id = a.ledger_id AND j.cc_code = $cc_code) AS balance,
				  a.ledger_id
				FROM
				  accounts_ledger a,
				  journal b
				WHERE
				  b.jv_date BETWEEN '$fdate' AND '$tdate' AND 
				  a.ledger_id = b.ledger_id AND 
				  b.ledger_id LIKE '$ledger_id' AND 
				  1 AND 
				  b.cc_code = $cc_code
				GROUP BY
				  a.ledger_name,
				  a.balance_type,
				  a.ledger_id";		
	}
	else
	{
		$p="SELECT DISTINCT 
				  a.ledger_name,
				  SUM(dr_amt) AS FIELD_1,
				  SUM(cr_amt) AS FIELD_2,
				  (SELECT SUM(dr_amt) - SUM(cr_amt) AS FIELD_1 FROM journal j WHERE j.jv_date < '$fdate' AND j.ledger_id = a.ledger_id) AS opening,
				  a.balance_type,
				  (SELECT SUM(dr_amt) - SUM(cr_amt) AS FIELD_1 FROM journal j WHERE j.jv_date < '$tdate' AND j.ledger_id = a.ledger_id) AS balance,
				  a.ledger_id
				FROM
				  accounts_ledger a,
				  journal b
				WHERE
				  b.jv_date BETWEEN '$fdate' AND '$tdate' AND 
				  a.ledger_id = b.ledger_id AND 
				  b.ledger_id LIKE '$ledger_id' AND 
				  1
				GROUP BY
				  a.ledger_name,
				  a.balance_type,
				  a.ledger_id";	
	}
  	//echo $p;
	$pi=0;
	$sql=db_query($p);
	while($data=mysqli_fetch_row($sql)){
	$pi++;
  ?>
  <tr class="report_font1">
    <th align="center"><?php echo $pi;?></th>
    <td align="left"><?php if(($data[0])<0) echo "(".($data[0]*(-1)).")"; else echo $data[0];?></td>
    <td align="right"><?php if(($data[3])<0) echo "(".($data[3]*(-1)).")"; else echo $data[3];?></td>
    <td align="right"><?php if(($data[1])<0) echo "(".($data[1]*(-1)).")"; else echo $data[1];?></td>
    <td align="right"><?php if(($data[2])<0) echo "(".($data[2]*(-1)).")"; else echo $data[2];?></td>
    <td width="15%" align="right"><?php if(($data[5])<0) echo "(".($data[5]*(-1)).")"; else echo $data[5];?></td>
    <td width="5%" align="right"><?php echo $data[4];?></td>
    </tr>
	<?php if($data[1]!=0){?>
  <tr>
    <th colspan="7" align="right">
	<table width="75%" id="tbl3">
	<?php
	 $cc_code = (int) $_REQUEST['cc_code'];
	if($cc_code > 0)
	{
		$sss="SELECT jv_date,narration,(select SUM(dr_amt)-SUM(cr_amt) from journal where jv_date<'$fdate'),SUM(dr_amt),SUM(cr_amt) from journal where jv_date between '$fdate' and '$tdate' and ledger_id='$data[6]' and 1 AND cc_code=$cc_code group by jv_date";
	}
	else
	{
		$sss="select jv_date,narration,(select SUM(dr_amt)-SUM(cr_amt) from journal where jv_date<'$fdate'),SUM(dr_amt),SUM(cr_amt) from journal where jv_date between '$fdate' and '$tdate' and ledger_id='$data[6]' and 1 group by jv_date";
	}
	//echo $sss;
	$sss2=db_query($sss);
	while($ss=mysqli_fetch_row($sss2))
	{
	?>
  <tr>
    <td width="19%"><?php echo date("d-m-y",$ss[0]);?></td>
    <td width="14%">&nbsp;</td>
    <td width="20%"><?php echo $ss[3];?></td>
    <td width="21%"><?php echo $ss[4];?></td>
    <td width="26%"><?php if(($ss[4]-$ss[3])<0) echo "(".($ss[3]-$ss[4]).")"; else echo $ss[4]-$ss[3];?>&nbsp;</td>
    </tr><?php }?>
</table>
</th>
    </tr>
  <?php }}}?>
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