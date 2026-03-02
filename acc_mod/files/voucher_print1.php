<?php
session_start();
require "../common/db_connect.php";
require_once ('../../common/class.numbertoword.php');
$proj_id=$_SESSION['proj_id'];
$vtype=$_REQUEST['v_type'];
$no=$vtype."_no";
$vdate=$vtype."_date";

if(isset($_REQUEST['vo_no']))
{
$vo_no=$_REQUEST['vo_no'];
$sql1="select $no,$vdate from $vtype where $no=$vo_no limit 1";
$data1=mysqli_fetch_row(db_query($sql1));
$vo_no=$data1[0];
$vo_date=$data1[1];
}
else
{
$sql1="select $no,$vdate from $vtype order by $no desc limit 1";
$data1=mysqli_fetch_row(db_query($sql1));
$vo_no=$data1[0];
$vo_date=$data1[1];
}
$pi=0;
$cr_amt=0;
$dr_amt=0;
$sql2="SELECT a.ledger_name,b.* 
FROM accounts_ledger a, $vtype b where b.$no='$vo_no' and a.ledger_id=b.ledger_id";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../../../assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script></head>
<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="1%">
			<? $path='../logo/'.$_SESSION['proj_id'].'.jpg';
			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?>
			
			</td>
            <td width="83%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" class="title"><?=$_SESSION['proj_name']?></td>
              </tr>
              <tr>
                <td align="center" style="padding-left:25px;">1-B/1-13, Kalwalapara Mirpur-1 (Main Road), Phone: 8032454 </td>
              </tr>
              <tr>
                <td align="center" style="padding-left:25px;"><table  class="debit_box" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="../images/bg_01.jpg" width="36" height="32" /></td>
                      <td width="325" bgcolor="#000000"><div align="center" bgcolor="#000000">DEBIT VOUCHER</div></td>
                      <td><img src="../images/bg_03.jpg" width="35" height="32" /></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	  </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  
  <tr>

    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" class="tabledesign_text">

<div id="pr">
<div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div>
</div></td>
        </tr>
      <tr>
        <td class="tabledesign_text"> Voucher No  : <?=$vo_no?></td>
        <td class="tabledesign_text">Voucher Date : <?=date('d-m-Y',$vo_date)?></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" class="tabledesign" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10%" rowspan="2">Folio No.</td>
        <td width="32%" rowspan="2" align="left">A/C Ledger Head</td>
        <td width="43%" rowspan="2" align="left">Particulars</td>
        <td colspan="2">Amount (Taka) </td>
      </tr>
      <tr>
        <td width="13%">Debit </td>
        <td width="12%">Credit</td>
      </tr>
	  <?

$data2=db_query($sql2);
			  while($info=mysqli_fetch_object($data2)){ $pi++;
			  $cr_amt=$cr_amt+$info->cr_amt;
			  $dr_amt=$dr_amt+$info->dr_amt;
			  if($info->cheq_no=='')
			  $narration=$info->narration;
			  else
			  $narration=$info->narration.':: Cheq # '.$info->cheq_no.'; dt= '.date("d.m.Y",$info->cheq_date).'; Bank # '.$info->bank;
			  
	  ?>
      <tr>
        <td>&nbsp;</td>
        <td align="left"><?=$info->ledger_name?></td>
        <td align="left"><?=$narration?></td>
        <td><?=$info->dr_amt?></td>
        <td><?=$info->cr_amt?></td>
      </tr>
<?php }?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">Total Taka: </td>
        <td><?=$dr_amt?></td>
        <td><?=$cr_amt?></td>
      </tr>
      <tr>
        <td colspan="5"><table class="tabledesign1" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="75%" valign="top"><div align="left">Being The Amount </div></td>
            <td width="25%" valign="bottom"><table  cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>........................................<br />
                Receiver Singnature </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Amount in Word : (Taka <?=CLASS_Numbertoword::convert($cr_amt,'en')?> Only) </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabledesign_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="bottom">..........................................</td>
        <td align="center" valign="bottom">..........................................</td>
        <td align="center" valign="bottom">..........................................</td>
      </tr>
      <tr>
        <td width="33%"><div align="center">Prepared by </div></td>
        <td width="33%"><div align="center">Accountant</div></td>
        <td width="34%"><div align="center">Authorised Singnature </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
