<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Receipt &amp; Payment (Concise)';
$proj_id=$_SESSION['proj_id'];
$cash_and_bank_balance=find_a_field('config_group_class','cash_and_bank_balance',"1");
if(isset($_REQUEST['show']))
{
//fdate-------------------
$fdate=$_REQUEST["tdate"];
if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Report date Till: '.$_REQUEST['tdate'];
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
									<td><div id="reporting">
									<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							 <tr>
								<th width="14%" height="20" rowspan="2" align="center">Class</th>
								<th width="4%" rowspan="2" align="center">S/L</th>
								<th width="47%" height="20" rowspan="2" align="center">Head of Account </th>
								<th height="8" colspan="2" align="center">Amount in Taka </th>
								</tr>
								<tr>
								<th width="17%" align="center"><?php echo $t_date;?> </th>
								<th width="18%" height="10" align="center"><?php echo ($t_date-1);?></th>
								</tr>
								<tr>
								<td colspan="5" align="left">RECEIPTS :</td>
								</tr>
								<tr>
								<td colspan="5" align="left">Opening Balance </td>
								</tr>
								<tr>
								<td align="left">&nbsp;</td>
								<td align="center">&nbsp;</td>
								<td align="left">Cash in Hand </td>
								<td align="right">
<?php

//opening balance Cash

$cash=mysqli_fetch_row(db_query("select ledger_id from accounts_ledger where ledger_group_id='$cash_and_bank_balance' and 1 and ledger_name like '%ash%'"));
$op_c1="select SUM(dr_amt)-SUM(cr_amt) from fiscal_journal where ledger_id ='$cash[0]' and jv_date<'$lastfdate' and 1";
$op_c=mysqli_fetch_row(db_query($op_c1));
$last_opening_c=$op_c[0];

//closing balance of cash
$cl_c1="select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$cash[0]' and jv_date<'$date' and 1";
//echo $cl_c1;
$cl_c=mysqli_fetch_row(db_query($cl_c1));
$closing_c=$cl_c[0];
$cl_c1="select SUM(dr_amt)-SUM(cr_amt) from fiscal_journal where ledger_id ='$cash[0]' and jv_date<'$lasttdate' and 1";
$cl_c=mysqli_fetch_row(db_query($cl_c1));
$last_closing_c=$cl_c[0];


//opening balance Bank
$op_b1="select SUM(dr_amt)-SUM(cr_amt) from fiscal_journal a,accounts_ledger b where b.ledger_group_id='$cash_and_bank_balance' and b.ledger_id=a.ledger_id and  1 and jv_date<'$fdate'";
$op_b=mysqli_fetch_row(db_query($op_b1));
$last_opening_b=$op_b[0]-$last_opening_c;

//closing balance Bank
$cl_b1="select SUM(dr_amt)-SUM(cr_amt) from journal a,accounts_ledger b where b.ledger_group_id='$cash_and_bank_balance' and b.ledger_id=a.ledger_id and jv_date<'$date' and 1";
$cl_b=mysqli_fetch_row(db_query($cl_b1));
$closing_b=$cl_b[0]-$closing_c;

$cl_b1="select SUM(dr_amt)-SUM(cr_amt) from fiscal_journal a,accounts_ledger b where b.ledger_group_id='$cash_and_bank_balance' and b.ledger_id=a.ledger_id and jv_date<'$lasttdate' and 1";
$cl_b=mysqli_fetch_row(db_query($cl_b1));
$last_closing_b=$cl_b[0]-$last_closing_c;

if($last_closing_c==0) echo "0.00";
else {if($last_closing_c<0) echo "(".number_format($last_closing_c*(-1),2).")"; else echo number_format($last_closing_c,2);}
?></td>
<td align="right">
<?php
if($last_opening_c==0) echo "0.00";
else {if($last_opening_c<0) echo "(".number_format($last_opening_c*(-1),2).")"; else echo number_format($last_opening_c,2);}
?></td>
    </tr>
	  <tr>
	    <td align="left">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="left">Cash in Bank </td>
        <td align="right"><?php
if($last_closing_b==0) echo "0.00";
else {if($last_closing_b<0) echo "(".number_format($last_closing_b*(-1),2).")"; else echo number_format($last_closing_b,2);}
?></td>
        <td align="right"><?php
if($last_opening_b==0) echo "0.00";
else {if($last_opening_b<0) echo "(".number_format($last_opening_b*(-1),2).")"; else echo number_format($last_opening_b,2);}
?></td>
    </tr>
	  <tr>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">Sub Total : </td>
    <td align="right">
<?php
$last_closing=$last_closing_b+$last_closing_c;
if($last_closing==0) echo "0.00";
else {if($last_closing<0) echo "(".number_format($last_closing*(-1),2).")"; else echo number_format($last_closing,2);}
?></td>
    <td align="right"><?php
$last_opening=$last_opening_b+$last_opening_c;
if($last_opening==0) echo "0.00";
else {if($last_opening<0) echo "(".number_format($last_opening*(-1),2).")"; else echo number_format($last_opening,2);}
?></td>
    </tr>
<?php
if(isset($_REQUEST['show'])){

$newp="select distinct group_name,group_id from ledger_group where group_class IN ('Income','Asset','Liabilities') and group_id<>'9' order by group_name";
$sql=db_query($newp);
//echo $p."<br />----------------------<br />";

$te=0;
$tel=0;

while($data=mysqli_fetch_row($sql)){
$pi++;
$p="SELECT sum(cr_amt) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.tr_from='Receipt' and c.jv_date between '$fdate' and '$date' and 1";
//$p="select DISTINCT(group_name),SUM(cr_amt) from journal a,accounts_ledger b,ledger_group c where a.ledger_id = b.ledger_id and b.ledger_group_id=c.group_id and a.jv_date>'$fdate' and a.jv_date<'$tdate' and b.ledger_group_id<>9 and a.tr_from='Receipt' and 1 GROUP BY group_name";

$newdata=mysqli_fetch_row(db_query($p));
$amt2=$newdata[0];
$te=$te+$amt2;

$lp="SELECT sum(cr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.tr_from='Receipt' and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[0];
$tel=$tel+$amt2l;
?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;<?php echo $data[1]//$pi;?></td>
    <td align="left"><?php echo $data[0];?></td>
	<td align="right"><?php if(($amt2)<0) echo "(".($amt2*(-1)).")"; else echo $amt2;?></td>
    <td align="right"><?php if(($amt2l)<0) echo "(".($amt2l*(-1)).")"; else echo $amt2l;?></td>
    </tr><?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">Sub Total : </td>
    <td align="right"><?php if(($te)<0) echo "(".($te*(-1)).")"; else echo $te;?></td>
    <td align="right"><?php if(($tel)<0) echo "(".($tel*(-1)).")"; else echo $tel;?></td>
  </tr>
  <tr>
    <th colspan="3" align="right">Grand Total   :</th>
    <th align="right"><?php if(($te+$last_closing)<0) echo "(".($te+$last_closing).")"; else echo $te+$last_closing;?></th>
    <th align="right"><?php if(($tel+$last_opening)<0) echo "(".($tel+$last_opening).")"; else echo $tel+$last_opening;?></th>
  </tr>
  </table> </div>
  <P CLASS="breakhere"></P>
<table class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0" id="grp">
  <tr>
    <th colspan="5" align="left">PAYMENTS :</th>
    </tr><?php }
  if(isset($_REQUEST['show'])){
//payment calculation
$newp="select distinct group_name,group_id from ledger_group where group_class IN ('Expense','Liabilities','Asset') and group_id<>'9' order by group_name";
$sql=db_query($newp);
//echo $p."<br />----------------------<br />";
$ti=0;
$til=0;

while($data=mysqli_fetch_row($sql)){
$pi++;
$p="SELECT sum(dr_amt) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.tr_from='Payment' and c.jv_date between '$fdate' and '$date' and 1";
$newdata=mysqli_fetch_row(db_query($p));
$amt2=$newdata[0];
$ti=$ti+$amt2;
//echo $p;
$lp="SELECT sum(dr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.tr_from='Payment' and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[0];
$til=$til+$amt2l;
?>
  <tr>
    <td width="77" align="center">&nbsp;</td>
    <td width="28" align="center"><?php echo $pi;?></td>
    <td width="290" align="left"><?php echo $data[0];?></td>
    <td width="99" align="right"><?php if(($amt2)<0) echo "(".($amt2*(-1)).")"; else echo $amt2;?></td>
    <td width="102" align="right"><?php if(($amt2l)<0) echo "(".($amt2l*(-1)).")"; else echo $amt2l;?></td>
    </tr><?php } }?>
    <tr>
      <th align="right">&nbsp;</th>
      <th align="center">&nbsp;</th>
      <th align="right">Total Receipt :</th>
      <th align="right"><?php if(($ti)<0) echo "(".($ti*(-1)).")"; else echo $ti;?></th>
      <th align="right"><?php if(($til)<0) echo "(".($til*(-1)).")"; else echo $til;?></th>
    </tr>
    <tr>
      <th colspan="5" align="left">Closing Balance </th>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="left">Cash in Hand </td>
      <td align="right"><?php
if($closing_c==0) echo "0.00";
else {if($closing_c<0) echo "(".number_format($closing_c*(-1),2).")"; else echo number_format($closing_c,2);}
?></td>
      <td align="right"><?php
if($last_closing_c==0) echo "0.00";
else {if($last_closing_c<0) echo "(".number_format($last_closing_c*(-1),2).")"; else echo number_format($last_closing_c,2);}
?></td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="left">Cash in Bank </td>
      <td align="right"><?php
if($closing_b==0) echo "0.00";
else {if($closing_b<0) echo "(".number_format($closing_b*(-1),2).")"; else echo number_format($closing_b,2);}
?></td>
      <td align="right"><?php
if($last_closing_b==0) echo "0.00";
else {if($last_closing_b<0) echo "(".number_format($last_closing_b*(-1),2).")"; else echo number_format($last_closing_b,2);}
?></td>
    </tr>
    <tr>
      <th align="left">&nbsp;</th>
      <th align="center">&nbsp;</th>
      <th align="right">Sub Total : </th>
      <th align="right"><?php
$closing=$closing_b+$closing_c;
if($closing==0) echo "0.00";
else {if($closing<0) echo "(".number_format($closing*(-1),2).")"; else echo number_format($closing,2);}
?></th>
      <th align="right"><?php
$last_closing=$last_closing_b+$last_closing_c;
if($last_closing==0) echo "0.00";
else {if($last_closing<0) echo "(".number_format($last_closing*(-1),2).")"; else echo number_format($last_closing,2);}
?></th>
    </tr>
    <tr>
    <th colspan="3" align="right">Grand Total   :</th>
    <th align="right"><?php if(($ti+$closing)<0) echo "(".($ti+$closing).")"; else echo $ti+$closing;?></th>
    <th align="right"><?php if(($til+$last_opening)<0) echo "(".($til+$last_opening).")"; else echo $til+$last_opening;?></th>
  </tr>
</table>
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