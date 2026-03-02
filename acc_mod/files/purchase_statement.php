<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Purchase Statement';
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
                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right">
									<? include('PrintFormat.php');?>
									</td>
								  </tr>
								  <tr>
									<td>
									<div id="reporting">
									<link href="../css/table.css" type="text/css" rel="stylesheet"/>
									<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th>S/N</th>
								<th>Date</th>
								<th>Voucher No</th>
								<th>Ledger head</th>
								<th>Narration</th>
								<th>Debit</th>
								<th>Credit</th>
							  </tr>
<?php
	if(isset($_REQUEST['show'])){
  $total=mysqli_fetch_row(db_query("select sum(dr_amt),sum(cr_amt) from journal where tr_from='Purchase' and jv_date>'$fdate' and jv_date<'$tdate' and ledger_id like '$ledger_id' and 1"));
  $p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_no,a.narration from journal a,accounts_ledger b where tr_from='Purchase' and a.ledger_id=b.ledger_id and a.jv_date>'$fdate' and a.jv_date<'$tdate' and a.ledger_id like '$ledger_id' and 1 order by a.tr_no";

	$report = db_query($p);
	$i=0;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';
	$cr_total=$cr_total+$rp[3];
  	$dr_total=$dr_total+$rp[2];
	?>
							   <tr<?=$cls?>>
								<td><?=$i;?></td>
								<td><?=date("d.m.y",$rp[0]);?></td>
								<td><?=$rp[4];?></td>
								<td><?=$rp[1];?></td>
								<td><?=$rp[5];?></td>
								<td><?=$rp[2];?></td>
								<td><?=$rp[3];?></td>
							  </tr>
	<?php }
	?>
								<tr class="total">
								<th colspan="5" align="right">Total :</th>
								<th><strong>
							    <?=number_format($dr_total,2);?>
								</strong></th>
								<th><strong>
							    <?=number_format($cr_total,2);?>
								</strong></th>
							  </tr>
	<?
	}?>
							</table></div>
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