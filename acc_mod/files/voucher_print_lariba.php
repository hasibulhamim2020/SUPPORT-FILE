<?php
session_start();
require "../common/db_connect.php";
require_once ('../../common/class.numbertoword.php');
//var_dump($_SESSION);

$proj_id=$_SESSION['proj_id'];
$vtype=$_REQUEST['v_type'];
	$sql_new="SELECT proj_address FROM project_info limit 1";
	//echo $sql_new;
	$sql1_new=db_query($sql_new);
	if($data_new=mysqli_fetch_row($sql1_new))
	{
		$address	= $data_new[0];
	}


$pi=0;
$t_amt=0;
if($vtype=='receipt')
{
	$v='Debit';
	$vv='Credit';
	$amt='cr_amt';
}
if($vtype=='payment')
{
	$v='Credit';
	$vv='Debit';
	$amt='dr_amt';
}

if($vtype=='coutra')
{
	$vv='Credit';
	$v='Debit';
	$amt='dr_amt';
}

if($vtype=='journal_info')
{
	$vv='Credit';
	$v='Debit';
	$amt='dr_amt';
}
//$vtype='receipt';
//echo $_REQUEST['vo_no'];
//var_dump($_REQUEST);
$no=$vtype."_no";
$vdate=$vtype."_date";

if(isset($_REQUEST['vo_no']))
{
$vo_no=$_REQUEST['vo_no'];
if($vtype=='coutra')
$sql1="select narration,received_from,cheq_date,cheq_no,$no,$vdate from $vtype where 1 and $no='$vo_no' limit 1";
else
$sql1="select narration,received_from,cheq_date,cheq_no,$no,$vdate,bank from $vtype where 1 and $no='$vo_no' limit 1";
}
else
{
if($vtype=='coutra')
$sql1="select narration,received_from,cheq_date,cheq_no,$no,$vdate from $vtype where 1 order by $no desc limit 1";
else
$sql1="select narration,received_from,cheq_date,cheq_no,$no,$vdate,bank from $vtype where 1 order by $no desc limit 1";
}
$data1=mysqli_fetch_row(db_query($sql1));
//echo $sql1."<br>";
//echo $data1[5];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Programmer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />
<link href="common/menu.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="common/screen.css" media="all" />
<title>Account Solution</title>
<style type="text/css">
<!--
.style3 {
	font-size: 18px;
	font-weight: bold;
}
.style5 {font-size: 12px; font-weight: bold; }
-->
</style>
<script type="text/javascript">
function hide()
{
    document.getElementById('pr').style.display="none";
}
</script>
</head>
<body>
<div id="reportprint">
  <div align="center">
    <div>

    </div>
    <div id="pr">
        <div align="left">
          <input name="button" type="button" onclick="hide();window.print();" value="Print" />
        </div>
    </div>
      
      <table width="100%">
        <tr>
          <td colspan="2" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="14%">
			  <?php 
			  if(($proj_id=='lndw')||($proj_id=='limcs'))
			  echo '<img src="img/lariba_new.jpg" width="91" height="99" />';
			  else
			  echo '<img src="img/lariba.jpg" width="91" height="99" />';
			  ?>
			  </td>
              <td width="86%" align="center"><span class="money1" ><?php echo $_SESSION['proj_name'];?></span>        <br />
              <?php echo $address;?></td>
            </tr>
          </table>	<span class='money1'><?php 
	if($vtype=='coutra') echo 'Contra Voucher'; 
	else 
	{
		if($vtype=='journal_info') echo 'Journal Voucher';
		else echo ucwords($vv.' Voucher');
	}
	//echo "<br>Print Date: ".date("d-m-y h:i a");
	?>&nbsp;</span></td>
        </tr>
        <tr>
          <td width="60%">Cheque No.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data1[3];?></td>
          <td width="40%">Voucher No.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data1[4];?></td>
        </tr>
        <tr>
          <td>Bank.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data1[6];?></td>
          <td>Voucher Date.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("d.m.Y",$data1[5]);?></td>
        </tr>
      </table>

    <form id="form1" name="form1" method="post" action="voucher_print.php">
<table width="100%" border="1" align="left" bordercolor="#000066" id="vbig">
        
        <tr>
          <td width="50%" valign="top"><table width='100%' border="1" cellpadding="2" cellspacing="2" bordercolor="#333333" bgcolor="#FFFFFF" style="border-collapse:collapse">
              <tr align="center">
                <td width="5%" bgcolor="#E0E0E0"><span class="style5">S/L</span></td>
                <td width="19%" align="left" bgcolor="#E0E0E0"><span class="style5">
                  <?=$v?>
                </span></td>
                <td width="26%" align="left" bgcolor="#E0E0E0"><span class="style5">
                  <?=$vv?>
                </span></td>
                <td width="14%" align="left" bgcolor="#E0E0E0" class="style5">Folio</td>
                <td width="22%" align="left" bgcolor="#E0E0E0"><span class="style5">Narrations</span></td>
                <td width="14%" align="right" bgcolor="#E0E0E0"><span class="style5">Amount</span></td>
              </tr>
			  <?php 
$pi=0;
$t_amt=0;
if($vtype=='receipt')
{
$v='Debit';
$vv='Credit';
$amt='cr_amt';
$sql2="select a.ledger_name,(select c.ledger_name from accounts_ledger c, $vtype d where d.$no='$data1[4]' and 1 and c.ledger_id=d.ledger_id and d.type='$v'),b.narration,b.$amt,b.cheq_no,b.cheq_date,b.bank from accounts_ledger a, $vtype b where b.$no='$data1[4]' and a.ledger_id=b.ledger_id and b.type='$vv'";
}

if($vtype=='payment')
{
$vv='Debit';
$v='Credit';
$amt='dr_amt';
$sql2="select a.ledger_name,(select c.ledger_name from accounts_ledger c, $vtype d where d.$no='$data1[4]' and 1 and c.ledger_id=d.ledger_id and d.type='$v'),b.narration,b.$amt,b.cheq_no,b.cheq_date,b.bank from accounts_ledger a, $vtype b where b.$no='$data1[4]' and a.ledger_id=b.ledger_id and b.type='$vv'";
}

if($vtype=='coutra')
{
$vv='Debit';
$v='Credit';
$amt='dr_amt';
$sql2="select a.ledger_name,(select c.ledger_name from accounts_ledger c, $vtype d where d.$no='$data1[4]' and 1 and c.ledger_id=d.ledger_id and d.type='$v'),b.narration,b.$amt,b.cheq_no,b.cheq_date from accounts_ledger a, $vtype b where b.$no='$data1[4]' and a.ledger_id=b.ledger_id and b.type='$vv'";

//echo $sql2;

}

if($vtype=='journal_info')
{
$vv='Debit';
$v='Credit';
$amt='dr_amt';
$sql2="select a.ledger_name,(select c.ledger_name from accounts_ledger c, $vtype d where d.$no='$data1[4]' and 1 and c.ledger_id=d.ledger_id and d.type='$v'),b.narration,b.$amt,b.cheq_no,b.cheq_date,b.bank from accounts_ledger a, $vtype b where b.$no='$data1[4]' and a.ledger_id=b.ledger_id and b.type='$vv'";
}

//$sql2="select a.ledger_name,(select c.ledger_name from accounts_ledger c, $vtype d where d.$no='$data1[4]' and 1 and c.ledger_id=d.ledger_id and d.type='$v'),b.narration,b.$amt,b.cheq_no,b.cheq_date,b.bank from accounts_ledger a, $vtype b where b.$no='$data1[4]' and a.ledger_id=b.ledger_id and b.type='$vv'";
//echo $sql2;
$data2=db_query($sql2);
			  while($info=mysqli_fetch_row($data2)){ $pi++;
			  $t_amt=$t_amt+$info[3];

			  if($info[6]=='')
			  $narrr=$info[2];
			  else
			  $narrr=$info[2].':: Cheq # '.$info[4].'; dt= '.date("d.m.Y",$info[5]).'; Bank # '.$info[6];
			  ?>
              <tr align="center" class="sect">
                <td><span class="report_font1 report_font1"><?php echo $pi;?></span></td>
                <td align="left"><span class="report_font1 report_font1"><?php echo $info[0];?></span></td>
                <td align="left"><span class="report_font1 report_font1"><?php echo $info[1];?></span></td>
                <td align="left">&nbsp;</td>
                <td align="left"><span class="report_font1 report_font1"><?php echo $narrr;?></span></td>
                <td align="right"><span class="report_font1 report_font1"><?php echo $info[3];?></span></td>
              </tr>
			   <?php }?>
              <tr align="center">
                <td colspan="5" align="right"><strong>Total Amount : </strong></td>
                <td align="right"><?php echo $t_amt;?></td>
              </tr>
          </table><br /><br />
		    <table width="100%">
		      <tr>
		        <td width="17%" align="right" valign="bottom"><strong>Taka In Word:</strong></td>
		        <td width="83%" colspan="4" align="left" valign="bottom"><?=CLASS_Numbertoword::convert($t_amt,'en')?>&nbsp;Taka Only</td>
	          </tr>
	        </table>
		    <br  />

		  <table width="100%">
  <tr>
    <td align="center" valign="bottom">&nbsp;</td>
    <td align="center" valign="bottom">&nbsp;</td>
    <td align="center" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="bottom">&nbsp;</td>
    <td align="center" valign="bottom">&nbsp;</td>
    <td align="center" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="bottom"><strong>----------------------------------</strong></td>
    <td align="center" valign="bottom"><strong>----------------------------------</strong></td>
    <td align="center" valign="bottom"><strong>----------------------------------</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>PREPARED BY</strong></td>
    <td align="center"><strong>CHECKED BY</strong></td>
    <td align="center"><strong>APPROVED BY</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  </tr>
    <tr>
      <td align="center" valign="bottom"><strong>&nbsp;</strong></td>
      <td align="center" valign="bottom">&nbsp;</td>
      <td align="center" valign="bottom">&nbsp;</td>
    </tr
   >
</table>

		  </td>
        </tr>
      </table>

    </form>
   </div>
</div>
</body>
</html>
