<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Balance Sheet(Concise)';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
//date-------------------
$tdate=$_REQUEST["tdate"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Report date Till: '.$_REQUEST['tdate'];

$j=0;
for($i=0;$i<strlen($tdate);$i++)
{
if(is_numeric($tdate[$i]))
$time1[$j]=$time1[$j].$tdate[$i];

else $j++;
}
if($time1[2]<100)
$t_date=2000+$time1[2];//year
else
$t_date=$time1[2];//year
//hour,min,sec,mon,day,year)
$fdate=mktime(0,0,0,1,1,$t_date);
$tdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);

//lastyear date-------------------
$lastfdate=mktime(0,0,0,1,1,($t_date-1));
$lasttdate=mktime(0,0,-1,1,1,$t_date);
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
		    As On :                                       </td>
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
									<td><div id="reporting">
									<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							   <tr>
								<th height="20" rowspan="2" align="center">Particulars</th>
								<th width="21%" rowspan="2" align="center">Note No. </th>
								<th height="8" colspan="2" align="center">Amount in Taka </th>
								</tr>
							  <tr>
								<th width="18%" align="center"><?php echo $t_date;?></th>
								<th width="17%" height="10" align="center"><?php echo $t_date-1;?></th>
							  </tr>

  <?php
  if(isset($_REQUEST['show'])){
  $pi=1;
  $total123=0;
  $total123l=0;
$newp="select distinct group_name,group_id from ledger_group where group_class='100' and group_under='' order by group_under";
$sql=db_query($newp);
//echo $p."<br />----------------------<br />";
while($data=mysqli_fetch_row($sql)){
$p="SELECT sum(dr_amt),sum(cr_amt),sum(depreciation_rate) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1";
$newdata=mysqli_fetch_row(db_query($p));
$amt2=$newdata[0]-$newdata[1];
//(($newdata[0]-$newdata[1])*$newdata[2]/100);
$total123=$total123+$amt2;
$lp="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[0]-$lastdata[1];
$total123l=$total123l+$amt2l;
?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="left"><?php echo $data[0];?></td>
    <td align="center"><?php echo $pi; $pi++;?></td>
    <td align="right"><?php if(($amt2)<0) echo "(".($amt2*(-1)).")"; else echo $amt2;?></td>
    <td align="right"><?php if(($amt2l)<0) echo "(".($amt2l*(-1)).")"; else echo $amt2l;?></td>
  </tr><?php }?>
  <tr class="report_font1">
    <th colspan="4" align="left">Current Assets (A):</th>
    </tr>
	<?php
	$curent_asset=0;
	$curent_assetl=0;
  $newp="select distinct group_name,group_id from ledger_group where group_class='100' and group_under='Current and Accrued Assets' order by group_under";
$sql=db_query($newp);
//echo $p."<br />----------------------<br />";
while($data=mysqli_fetch_row($sql)){
$p="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1";
$newdata=mysqli_fetch_row(db_query($p));
$amt2=$newdata[0]-$newdata[1];
$curent_asset=$curent_asset+$amt2;
$lp="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[0]-$lastdata[1];
$curent_assetl=$curent_assetl+$amt2l;
?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="left"><?php echo $data[0];?></td>
    <td align="center"><?php echo $pi; $pi++;?></td>
    <td align="right"><?php if(($amt2)<0) echo "(".($amt2*(-1)).")"; else echo $amt2;?></td>
    <td align="right"><?php if(($amt2l)<0) echo "(".($amt2l*(-1)).")"; else echo $amt2l;?></td>
  </tr><?php }?>
<tr>
    <th align="left"><strong>Sub Total</strong></th>
    <th align="center">--</th>
    <th align="right"><?php if(($curent_asset)<0) echo "(".($curent_asset*(-1)).")"; else echo $curent_asset;?></th>
    <th align="right"><?php if(($curent_assetl)<0) echo "(".($curent_assetl*(-1)).")"; else echo $curent_assetl;?></th>
    </tr>
    <tr class="report_font1">
      <th colspan="4" align="left">Current Liabilities (B):</th>
    </tr>
    <?php
$curent_liabilities=0;
$curent_liabilitiesl=0;
  $newp="select distinct group_name,group_id from ledger_group where group_class='400' and group_under='Current and Accrued Liabilities' order by group_under";
$sql=db_query($newp);
//echo $p."<br />----------------------<br />";
while($data=mysqli_fetch_row($sql)){
$p="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1";
$newdata=mysqli_fetch_row(db_query($p));
$amt2=$newdata[1]-$newdata[0];
$curent_liabilities=$curent_liabilities+$amt2;
$lp="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[1]-$lastdata[0];
$curent_liabilitiesl=$curent_liabilitiesl+$amt2l;
?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="left"><?php echo $data[0];?></td>
    <td align="center"><?php echo $pi; $pi++;?></td>
    <td align="right"><?php if(($amt2)<0) echo "(".($amt2*(-1)).")"; else echo $amt2;?></td>
    <td align="right"><?php if(($amt2l)<0) echo "(".($amt2l*(-1)).")"; else echo $amt2l;?></td>
  </tr><?php }?>
    <tr>
      <th align="left"><strong>Sub Total </strong></th>
    <th align="center">--</th>
    <th align="right"><?php if(($curent_liabilities)<0) echo "(".($curent_liabilities*(-1)).")"; else echo $curent_liabilities;?></th>
    <th align="right"><?php if(($curent_liabilitiesl)<0) echo "(".($curent_liabilitiesl*(-1)).")"; else echo $curent_liabilitiesl;?></th>
    </tr>
    <tr>
      <th align="left" class="report_font report_font1">Net Current Assets (A-B) </th>
      <th align="center">--</th>
      <th align="right">
	<?php
	$current_bal=$curent_asset-$curent_liabilities;
	$current_ball=$curent_assetl-$curent_liabilitiesl;
	if(($current_bal)<0) echo "(".($current_bal*(-1)).")"; else echo $current_bal;?></th>
	<th align="right"><?php if(($current_ball)<0) echo "(".($current_ball*(-1)).")"; else echo $current_ball;?></th>
    </tr>
    <tr>
      <th align="left" class="report_font report_font1">Total Net Asset </th>
      <th align="center" class="report_font1">--</th>
      <th align="right" class="report_font1">
	<?php
	$net_asset=$current_bal+$total123;
	$net_assetl=$current_ball+$total123l;
	if(($net_asset)<0) echo "(".($net_asset*(-1)).")"; else echo $net_asset;?></th>
	<th align="right" class="report_font1"><?php if(($net_assetl)<0) echo "(".($net_assetl*(-1)).")"; else echo $net_assetl;?></th>
    </tr>
    <tr>
      <td colspan="2" align="left">&nbsp;<span class="report_font1">Financed By:</span></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
 <?php
 $financed=0;
 $financedl=0;
  $newp="select distinct group_name,group_id from ledger_group where group_class='400' and group_under='Financed By(Liabilities)' order by group_under";
$sql=db_query($newp);
//echo $p."<br />----------------------<br />";
$inex="SELECT sum(dr_amt),sum(cr_amt) from ledger_group a, accounts_ledger b, journal c where a.group_class IN ('300', '200') and a.group_id=b.ledger_group_id and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and  1";
$inexd=mysqli_fetch_row(db_query($inex));
$inext=$inexd[1]-$inexd[0];
//$ti=$ti+$inex;
//if(($inex)<0) echo "(".($inex*(-1)).")"; else echo $inex;

while($data=mysqli_fetch_row($sql)){
$p="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1";
$newdata=mysqli_fetch_row(db_query($p));
$amt2=$newdata[1]-$newdata[0];
$financed=$financed+$amt2;
$lp="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
//else (if(($amt2)<0) echo ($amt2*(-1)); else echo $amt2;)
//echo $data[1];
//echo $inext;
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[1]-$lastdata[0];
$financedl=$financedl+$amt2l;
?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="left"><?php echo $data[0];?></td>
    <td align="center"><?php echo $pi; $pi++;?></td>
    <td align="right"><?php if(($data[1])==14) echo ($amt2+$inext); else echo ($amt2);?></td>
    <td align="right"><?php if(($amt2l)<0) echo ($amt2l*(-1)); else echo $amt2l;?></td>
  </tr><?php }}?>
    <tr>
      <th align="left" class="report_font1">Total</th>
      <th align="center" class="report_font1">--</th>
      <th align="right" class="report_head"><strong>
        <?php if(($financed)<0) echo ($financed*(-1)+$inext); else echo ($financed+$inext);?>
      </strong></th>
    <th align="right" class="report_head"><strong>
      <?php if(($financedl)<0) echo "(".($financedl*(-1)).")"; else echo $financedl;?>
    </strong></th>
    </tr>
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