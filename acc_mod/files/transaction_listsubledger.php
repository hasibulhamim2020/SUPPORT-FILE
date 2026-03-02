<?php

 
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Transaction Statement (Concise)';
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                      <td width="22%" align="right">
		    From Date : </td>
                                        <td align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
                                      <tr>
                                        <td align="right">A/C Ledger:</td>
                                        <td align="left"> <select name="ledger_id" id="ledger_id" onchange="sub_ledger(this.value)">
                                        <option value="">Select A Ledger</option>
                                      <?php
                                      $ll="select distinct(a.ledger_id),a.ledger_name from accounts_ledger a, sub_ledger b where a.ledger_id=b.ledger_id and 1 order by ledger_name";
                                      $led=db_query($ll);
                                      while($ledg=mysqli_fetch_row($led)){
                                      if($ledger_id==$ledg[0]) echo "<option value=\"$ledg[0]\" selected>$ledg[0]: $ledg[1]</option>";
                                      else echo "<option value=\"$ledg[0]\">$ledg[0]: $ledg[1]</option>";
                                      }
                                      ?>
                                    </select>
                                        
                                        </td>
                                      </tr>
                                      
                                      
                                      <tr>
                                        <td align="right">Sub Ledger:</td>
                                        <td align="left">
										<?php
										if(isset($ledger_id))
										{
										$s1="select sub_ledger_id,sub_ledger from sub_ledger where ledger_id='$ledger_id'";
										echo "<select name='sub_ledger_id' id='sub_ledger_id'>";
										$ss=db_query($s1);
										while($ledg=mysqli_fetch_row($ss)){
										if($ledg[0]==$sub_ledger)
										echo "<option value=\"$ledg[0]\" selected>$ledg[0]: $ledg[1]</option>";
										else
										echo "<option value=\"$ledg[0]\">$ledg[0]: $ledg[1]</option>";
										}
										echo "</select>";
										}
										else
										{
										echo "<select name='sub_ledger_id' id='sub_ledger_id'>";
										echo "<option value=''></option>";
										echo "</select>";
										}
										?>
                                        
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
							<td>
							<div id="reporting">
							<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							<tr>
                            <th width="12%" height="20" align="center">S/N</th>
                            <th width="13%" height="20" align="center">Tr Date</th>
                            <th width="30%" align="center">Particulars</th>
                            <th width="14%" align="center">Source</th>
                            <th width="15%" height="20" align="center">Debit Amt </th>
                            <th width="16%" height="20" align="center">Credit Amt </th>
                          </tr>
                          <?php
                          if(isset($_REQUEST['show'])){
                          $tt="select sum(dr_amt),sum(cr_amt) from journal where jv_date<'$tdate' and sub_ledger ='$sub_ledger'";
                          $total=mysqli_fetch_row(db_query($tt));
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
						//echo "select sum(dr_amt),sum(cr_amt) from journal where jv_date<'$fdate' and sub_ledger ='$sub_ledger' and 1";
						  $p=mysqli_fetch_row(db_query("select sum(dr_amt),sum(cr_amt) from journal where jv_date<'$fdate' and sub_ledger ='$sub_ledger'"));
						  //echo $p;
						$pi=1;
						if($p[0]>$p[1])
						$debit=$p[0]-$p[1];
						else $credit=$p[1]-$p[0];
						  ?>
						  <tr>
							<td align="center"><?php echo $pi;?></td>
							<td align="center"><?php echo $_REQUEST["fdate"];?></td>
							<td align="left"><?php echo "Opening Balance";?></td>
							<td align="center"><?php echo "Journal";?></td>
							<td align="right"><?php if($debit==''||$debit<1) echo "0.00"; else echo number_format($debit,2);?></td>
							<td align="right"><?php if($credit==''||$credit<1) echo "0.00"; else echo number_format($credit,2);?></td>
						  </tr><?php
			////////////////////////////////////
		
								$p="select a.jv_date,b.sub_ledger,a.dr_amt,a.cr_amt,a.tr_from,a.narration from journal a,sub_ledger b where a.sub_ledger=b.sub_ledger_id and a.jv_date between '$fdate' and '$tdate' and a.sub_ledger='$sub_ledger'";
							  //echo $p;
							  $sql=db_query($p);
							  while($data=mysqli_fetch_row($sql)){
							  $pi++;
							  ?>
							  <tr>
								<td align="center"><?php echo $pi;?></td>
								<td align="center"><?php echo date("d.m.y",$data[0]);?></td>
								<td align="left"><?php echo $data[5];?></td>
								<td align="center"><?php echo $data[4];?></td>
								<td align="right"><?php echo number_format($data[2],2);?></td>
								<td align="right"><?php echo number_format($data[3],2);?></td>
							  </tr><?php }?>
							  <tr>
								<th colspan="3" align="center">Closing Balance : <?php echo number_format($t_total,2)." ".$t_type?> </th>
								<th align="right"><strong>Total : </strong></th>
								<th align="right"><strong><?php echo number_format($total[0],2);?></strong></th>
								<th align="right"><strong><?php echo number_format($total[1],2);?></strong></th>
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