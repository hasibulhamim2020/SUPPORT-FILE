<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Income &amp; Expenditure(Concise)';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
//fdate-------------------
$fdate=$_REQUEST["tdate"];
$j=0;
for($i=0;$i<strlen($fdate);$i++)
{
if(is_numeric($fdate[$i]))
$time1[$j]=$time1[$j].$fdate[$i];

else $j++;
}

$date=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);
$t_date=date("Y",$date);
//date-------------------
//hour,min,sec,mon,day,year)
$fdate=mktime(0,0,0,1,1,$t_date);
$tdate=mktime(0,0,-1,1,1,($t_date+1));

//lastyear date-------------------
$lastfdate=mktime(0,0,0,1,1,($t_date-1));
$lasttdate=mktime(0,0,-1,1,1,$t_date);
echo $tdatel;
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
		       Till Period :                              </td>
                                        <td align="left">
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
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
								<th height="20" rowspan="2" align="center">Class</th>
								<th height="20" rowspan="2" align="center">S/L</th>
								<th width="47%" height="20" rowspan="2" align="center">Particulars</th>
								<th height="8" colspan="2" align="center">Amount in Taka </th>
								</tr>
								<tr>
								<th width="17%" align="center"><?php echo $t_date;?> </th>
								<th width="18%" height="10" align="center"><?php echo ($t_date-1);?></th>
								</tr>
								<tr>
								<td colspan="5" align="left">REVENUE INCOME:</td>
								</tr>
  <?php
  if(isset($_REQUEST['show'])){
$newp="select distinct group_name,group_id from ledger_group where group_class='Income' order by group_name";
$sql=db_query($newp);
//echo $p."<br />----------------------<br />";
$pi=0;
$te=0;
$tel=0;

while($data=mysqli_fetch_row($sql)){
$pi++;
$p="SELECT sum(cr_amt),sum(dr_amt) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$date' and 1";
$newdata=mysqli_fetch_row(db_query($p));
$amt2=$newdata[0]-$newdata[1];
$te=$te+$amt2;

$lp="SELECT sum(cr_amt),sum(dr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[0]-$lastdata[1];
$tel=$tel+$amt2l;
?>
  <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td width="14%" align="center">&nbsp;</td>
    <td width="4%" align="center"><?php echo $pi;?>&nbsp;</td>
    <td align="left"><?php echo $data[0];?></td>
	<td align="right"><?php if(($amt2)<0) echo "(".($amt2*(-1)).")"; else echo $amt2;?></td>
    <td align="right"><?php if(($amt2l)<0) echo "(".($amt2l*(-1)).")"; else echo $amt2l;?></td>
    </tr><?php }?>
  <tr>
    <th align="right">&nbsp;</th>
    <th align="center"><?php $pi++; echo $pi;?>&nbsp;</th>
    <th align="right">Total Revenue Income :</th>
    <th align="right"><?php if(($te)<0) echo "(".($te*(-1)).")"; else echo $te;?></th>
    <th align="right"><?php if(($tel)<0) echo "(".($tel*(-1)).")"; else echo $tel;?></th>
  </tr>
  <tr>
    <td colspan="5" align="left">REVENUE EXPENDITURE:</td>
    </tr><?php }
  if(isset($_REQUEST['show'])){
$newp="select distinct group_name,group_id from ledger_group where group_class='Expense' order by group_name";
$sql=db_query($newp);
  //echo $p;
$ti=0;
$til=0;
while($data=mysqli_fetch_row($sql)){
$pi++;
$p="SELECT sum(cr_amt),sum(dr_amt) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$date' and 1";
$newdata=mysqli_fetch_row(db_query($p));
$amt=($newdata[1]-$newdata[0]);
$ti=$ti+$amt;

$lp="SELECT sum(cr_amt),sum(dr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[0]-$lastdata[1];
$til=$til+$amt2l;
  ?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="center">&nbsp;</td>
    <td align="center"><?php echo $pi;?>&nbsp;</td>
    <td align="left"><?php echo $data[0];?></td>
    <td align="right"><?php if(($amt)<0) echo "(".($amt*(-1)).")"; else echo $amt;?></td>
    <td align="right"><?php if(($amt2l)<0) echo "(".($amt2l*(-1)).")"; else echo $amt2l;?></td>
    </tr><?php } }?>
    <tr>
      <th align="right">&nbsp;</th>
      <th align="center"><?php $pi++; echo $pi;?>&nbsp;</th>
      <th align="right">Total Revenue Expense :</th>
      <th align="right"><?php if(($ti)<0) echo "(".($ti*(-1)).")"; else echo $ti;?></th>
      <th align="right"><?php if(($til)<0) echo "(".($til*(-1)).")"; else echo $til;?></th>
    </tr>
    <tr>
    <th colspan="3" align="right">Excess of Income over Expenditure :</th>
    <th align="right"><?php if(($te-$ti)<0) echo "(".($ti-$te).")"; else echo $te-$ti;?>&nbsp;</th>
    <th align="right"><?php if(($tel-$til)<0) echo "(".($til-$tel).")"; else echo $tel-$til;?>&nbsp;</th>
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