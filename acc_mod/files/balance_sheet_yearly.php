<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$proj_id=$_SESSION['proj_id'];
if(isset($_REQUEST['show']))
{
$t_date=$_REQUEST['tdate'];
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="common/menu.css" rel="stylesheet" type="text/css" />
<title>Account Solution</title>
<style type="text/css">
<!--
.style3 {color: #666666}
-->
</style>
</head>

<body>
<?php
include "common/header.php";
?>
<div id="report"><p align="center"><font size="+2"><?php echo $_SESSION['proj_name']."<br \>";?></font></p>
<p align="center" class="money1">Balance Sheet Yearly </p>
<form id="form1" name="form1" method="post" action="">
  <table width="30%" border="1" align="center" id="table1">
    <tr>
      <td align="center"><strong>Till Period : </strong>      </td>
      <td width="66%" align="center">
	  <select name="tdate">
	  <?php if(isset($_REQUEST['tdate'])) echo "<option>".$_REQUEST['tdate']."</option>";?>
	  <option value="2008">2008</option>
	  <option value="2009">2009</option>
	  <option value="2010">2010</option>
	  <option value="2011">2011</option>
	  <option value="2012">2012</option>
	  </select>
	  </td>
    </tr>
    
    <tr>
      <td colspan="2" align="center"><input name="show" type="submit" class="style3" id="show" value="VIEW" /></td>
    </tr>
  </table>
</form>
<table width="89%" border="1" align="center" id="grp">
  <tr style="background-color:#99CCCC;">
    <th width="18%" height="20" align="center">Class</th>
    <th width="47%" height="20" align="center">Head of Account </th>
    <th width="17%" align="center">Balance-<?php echo $_REQUEST['tdate'];?> </th>
    <th width="18%" height="20" align="center">Balance-<?php echo ($_REQUEST['tdate']-1);?></th>
    </tr>
	  <tr style="background-color:#99CCCC;">
    <th colspan="4" align="left">ASSET:</th>
    </tr>
  <?php 
  if(isset($_REQUEST['show'])){
$newp="select distinct group_name,group_id from ledger_group where group_class='Asset' order by group_under";
$sql=db_query($newp);
//echo $p."<br />----------------------<br />";
$pi=0;
$te=0;
$tel=0;

while($data=mysqli_fetch_row($sql)){
$pi++;
$p="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1";
$newdata=mysqli_fetch_row(db_query($p));
$amt2=$newdata[0]-$newdata[1];
$te=$te+$amt2;

$lp="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[0]-$lastdata[1];
$tel=$tel+$amt2l;
?>
  <tr <?php  if($pi%2==0) echo "bgcolor=\"#E8FFFF\""; else echo "bgcolor=\"#F0F0FF\"";?>>
    <th align="center">&nbsp;</th>
    <td align="left"><?php echo $data[0];?></td>
	<td align="right"><?php if(($amt2)<0) echo "(".($amt2*(-1)).")"; else echo $amt2;?></td>
    <td align="right"><?php if(($amt2l)<0) echo "(".($amt2l*(-1)).")"; else echo $amt2l;?></td>
    </tr><?php }?>  
  <tr>
    <th colspan="2" align="right" style="background-color:#FFCCCC;">Total Asset: </th>
    <th align="right" style="background-color:#FFCCCC;"><?php if(($te)<0) echo "(".($te*(-1)).")"; else echo $te;?></th>
    <th align="right" style="background-color:#FFCCCC;"><?php if(($tel)<0) echo "(".($tel*(-1)).")"; else echo $tel;?></th>
  </tr>
  <tr>
    <th colspan="4" align="left" style="background-color:#99CCCC;">LIABILITIES:</th>
    </tr><?php }
  if(isset($_REQUEST['show'])){
$newp="select distinct group_name,group_id from ledger_group where group_class='Liabilities' order by group_name";
$sql=db_query($newp);
  //echo $p;
$pi=0;
$ti=0;
$til=0;
while($data=mysqli_fetch_row($sql)){
$pi++;
$p="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and 1";
$newdata=mysqli_fetch_row(db_query($p));
$amt=($newdata[1]-$newdata[0]);
$ti=$ti+$amt;

$lp="SELECT sum(dr_amt),sum(cr_amt) from accounts_ledger b, fiscal_journal c where b.ledger_group_id='$data[1]' and b.ledger_id=c.ledger_id and c.jv_date between '$lastfdate' and '$lasttdate' and 1";
//echo $lp."<br><br>";
$lastdata=mysqli_fetch_row(db_query($lp));
$amt2l=$lastdata[0]-$lastdata[1];
$til=$til+$amt2l;
  ?>
  <tr <?php  if($pi%2==0) echo "bgcolor=\"#E8FFFF\""; else echo "bgcolor=\"#F0F0FF\"";?>>
    <th align="center">&nbsp;</th>
    <td align="left"><?php echo $data[0];?></td>
    <td align="right"><?php if(($amt)<0) echo "(".($amt*(-1)).")"; else echo $amt;?></td>
    <td align="right"><?php if(($amt2l)<0) echo "(".($amt2l*(-1)).")"; else echo $amt2l;?></td>
    </tr><?php }?>  <?php }?>
  <tr style="background-color:#D2FFFF;">
    <th align="right">&nbsp;</th>
    <th align="center">Add Income Over Expenditure :</th>
    <th align="right"><?php 
$p="SELECT sum(dr_amt),sum(cr_amt) from ledger_group a, accounts_ledger b, journal c where a.group_class IN ('Expense', 'Income') and a.group_id=b.ledger_group_id and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate'";
	  $iex=mysqli_fetch_row(db_query($p));
	  $inex=$iex[1]-$iex[0];
	  $ti=$ti+$inex;
	  if(($inex)<0) echo "(".($inex*(-1)).")"; else echo $inex;
	?>&nbsp;</th>
    <th align="right"><?php 
$pl="SELECT sum(dr_amt),sum(cr_amt) from ledger_group a, accounts_ledger b,fiscal_journal c where a.group_class IN ('Expense', 'Income') and a.group_id=b.ledger_group_id and b.ledger_id=c.ledger_id and c.jv_date between '$lastfdate' and '$lasttdate'";
	  $iexl=mysqli_fetch_row(db_query($pl));
	  $inexl=$iexl[1]-$iexl[0];
	  $til=$til+$inexl;
	  if(($inexl)<0) echo "(".($inexl*(-1)).")"; else echo $inexl;
	?>&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2"   align="right" style="background-color:#FFCCCC;">Total Liabilities : </th>
    <th align="right" style="background-color:#FFCCCC;"><?php if(($ti)<0) echo "(".($ti*(-1)).")"; else echo $ti;?></th>
    <th align="right" style="background-color:#FFCCCC;"><?php if(($til)<0) echo "(".($til*(-1)).")"; else echo $til;?></th>
  </tr>
</table>
</div>
</body>
</html>
