<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Journal Book (Group)';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];
$cc_code = (int) $_REQUEST['cc_code'];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')
$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"].' and group_for='.$_SESSION['user']['group']);if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
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
<?php $led=db_query("select group_id,group_name from ledger_group where group_for=".$_SESSION['user']['group']." order by group_id");
      if(mysqli_num_rows($led) > 0)
	  {	
		  $data = '[';
		  while($ledg = mysqli_fetch_row($led)){
			  $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
		  }
		  $data = substr($data, 0, -1);
		  $data .= ']';
	  }
	  else
	  {
		$data = '[{ name: "empty", id: "" }]';
	  }
//echo $data;
	$led1sql="SELECT id, center_name FROM cost_center WHERE 1 ORDER BY center_name";
	$led1=db_query($led1sql);
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
			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>ID: " + row.id + "</span>";
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
                                        <td align="right">Ledger Group :</td>
                                        <td align="left"><input type="text" name="ledger_id" id="ledger_id" value="<?php echo $_REQUEST['ledger_id'];?>" size="50" /></td>
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
							<table class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0" id="grp">
							 <tr>
								<th width="5%" height="20" align="center">S/N</th>
								<th width="15%" align="center">Voucher</th>
								<th width="10%" height="20" align="center">Tr Date</th>
								<th width="35%" align="center">Particulars</th>
								<th width="15%" align="center">Source</th>
								<th width="10%" height="20" align="center">Debit Amt </th>
								<th width="10%" height="20" align="center">Credit Amt </th>
							  </tr>
  <?php
  if(isset($_REQUEST['show']))
  {
		
		if($cc_code > 0)
		{
		  $total=mysqli_fetch_row(db_query("select sum(j.dr_amt),sum(j.cr_amt) from journal j, accounts_ledger a, ledger_group l where j.ledger_id=a.ledger_id and a.ledger_group_id=l.group_id and j.jv_date between '$fdate' AND '$tdate' and l.group_id = $ledger_id AND j.cc_code=$cc_code and l.group_for=".$_SESSION['user']['group']));
		
		  $tt = "select sum(j.dr_amt),sum(j.cr_amt) from journal j, accounts_ledger a, ledger_group l where j.ledger_id=a.ledger_id and a.ledger_group_id=l.group_id and j.jv_date between '$fdate' AND '$tdate' and l.group_id = $ledger_id and j.1 AND j.cc_code=$cc_code and l.group_for=".$_SESSION['user']['group'];
		  
		  
		  $p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,b.ledger_name,a.jv_no,a.tr_no from journal a,accounts_ledger b, ledger_group l where a.ledger_id=b.ledger_id and b.ledger_group_id=l.group_id and a.jv_date between '$fdate' AND '$tdate' and l.group_id= '$ledger_id' and 1 AND a.cc_code=$cc_code and l.group_for=".$_SESSION['user']['group'];
		
		}
		else
		{
		   $total=mysqli_fetch_row(db_query("select sum(j.dr_amt),sum(j.cr_amt) from journal j, accounts_ledger a, ledger_group l where j.ledger_id=a.ledger_id and a.ledger_group_id=l.group_id and j.jv_date between '$fdate' AND '$tdate' and l.group_id = $ledger_id and l.group_for=".$_SESSION['user']['group']));
		
		  $tt = "select sum(j.dr_amt),sum(j.cr_amt) from journal j, accounts_ledger a, ledger_group l where j.ledger_id=a.ledger_id and a.ledger_group_id=l.group_id and j.jv_date between '$fdate' AND '$tdate' and l.group_id = $ledger_id and l.group_for=".$_SESSION['user']['group'];
		  
		  
		  $p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,b.ledger_name,a.jv_no,a.tr_no FROM journal a,accounts_ledger b, ledger_group l WHERE a.ledger_id=b.ledger_id and b.ledger_group_id=l.group_id and a.jv_date between '$fdate' AND '$tdate' and l.group_id= '$ledger_id' and l.group_for=".$_SESSION['user']['group'];
		 
		}
	  //echo $p;
	  //echo $tt;
		if($total[0]>$total[1])
		{
			$t_type="(Dr)";
			$t_total=$total[0]-$total[1];
		}
		else
		{
			$t_type="(Cr)";
			$t_total=$total[1]-$total[0];
		}
		//////////////////////////////////
		//opening balance
			
		$sql=db_query($tt);
		$data = mysqli_fetch_row($sql);
		
		if($data[0] > $data[1])
		{
			$debit = $data[0]-$data[1];
		}
		else 
		{
			$credit = $data[1]-$data[0];
		}
	$pi=1;
  ?>
				<tr style="font-weight:bold">
				<td align="center"><?php echo $pi;?></td>
				<td align="center">&nbsp;</td>
				<td align="center"><?php echo $_REQUEST["fdate"];?></td>
				<td align="left"><?php echo "Opening Balance";?></td>
				<td align="center"><?php echo "Journal";?></td>
				<td align="right"><?php if($debit==''||$debit<1) echo "0.00"; else echo number_format($debit,2);?></td>
				<td align="right"><?php if($credit==''||$credit<1) echo "0.00"; else echo number_format($credit,2);?></td>
				</tr>
<?php
////////////////////////////////////
  
  //echo $p;
  $sql=db_query($p);

  while($data=mysqli_fetch_row($sql)){
  $pi++;

  ?>
  <tr>
    <td align="center"><?php echo $pi;?></td>
    <td align="center"><?php if($data[4]=='Receipt'||$data[4]=='Payment'||$data[4]=='Journal_info'||$data[4]=='Contra') {
	$link="voucher_print.php?v_type=".$data[4]."&v_date=".$data[0]."&view=1&vo_no=".$data[7];
	echo "<a target=\"_blank\" href='$link'>".$data[7]."</a>";}

	else echo $data[6];?></td>
    <td align="center"><?php echo date("d.m.y",$data[0]);?></td>
    <td align="left"><?php echo $data[5];?></td>
    <td align="center"><?php echo $data[4];?></td>
    <td align="right"><?php echo number_format($data[2],2);?></td>
    <td align="right"><?php echo number_format($data[3],2);?></td>
  </tr><?php }?>
  <tr>
    <th colspan="4" align="center">Closing Balance : <?php echo number_format($t_total,2)." ".$t_type?> </th>
    <th align="right"><strong>Total : </strong></th>
    <th align="right"><strong><?php echo number_format($total[0],2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total[1],2);?></strong></th>
  </tr>
  <?php
		}

	?>
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