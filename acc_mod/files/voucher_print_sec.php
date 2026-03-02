<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../common/class.numbertoword.php');
$proj_id=$_SESSION['proj_id'];



$vo_no = $_REQUEST['vo_no'];
$address=find_a_field('project_info','proj_address',"1");

if(isset($_REQUEST['vo_no']))
{

$sql1="select jv_date,cc_code,user_id from secondary_journal where jv_no=$vo_no  limit 1";
$data1=mysqli_fetch_row(db_query($sql1));
$user_name = find_a_field('user_activity_management','fname',"user_id=".$data1[2]);
$vo_date=$data1[0];
$cccode=$data1[1];
}

$pi=0;
$cr_amt=0;
$dr_amt=0;

if($_SESSION['user']['group']==3) $sql2="SELECT a.ledger_name,a.ledger_group_id,b.* FROM accounts_ledger a, secondary_journal b where b.jv_no='$vo_no' and a.ledger_id=b.ledger_id order by b.dr_amt desc,b.cr_amt desc";
else $sql2="SELECT a.ledger_name,a.ledger_group_id,b.* FROM accounts_ledger a, secondary_journal b where b.jv_no='$vo_no' and a.ledger_id=b.ledger_id order by b.dr_amt desc,b.id";
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
<table width="820" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="1%">
			<? $path='../logo/'.$_SESSION['proj_id'].'.jpg';
			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?>			</td>
            <td width="83%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" class="title">

				<?
if($_SESSION['user']['group']>1)
echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);
else
echo $_SESSION['proj_name'];
				?>
                </td>
              </tr>
              <tr>
                <td align="center"><?=$address?></td>
              </tr>
              <tr>
                <td align="center"><table  class="debit_box" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td width="325"><div align="center"><?=$voucher_name?></div></td>
                      <td>&nbsp;</td>
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
    <td><? if($cccode>0){?>CC CODE/PROJECT NAME: <? echo find_a_field('cost_center','center_name',"id='$cccode'")?><? }?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign">
      <tr>
        <td width="25%" rowspan="2" align="center">Control Head</td>
        <td width="30%" rowspan="2" align="center">A/C Ledger Head</td>
        <td width="30%" rowspan="2" align="center">Particulars</td>
        <td colspan="2">Amount (Taka) </td>
      </tr>
      <tr>
        <td width="9%">Debit </td>
        <td width="9%">Credit</td>
      </tr>
	  <?

$data2=db_query($sql2);
			  while($info=mysqli_fetch_object($data2)){ $pi++;
			  $cr_amt=$cr_amt+$info->cr_amt;
			  $dr_amt=$dr_amt+$info->dr_amt;
			  if($info->bank==''&&$info->cheq_no!='')
			  $narration=$info->narration.':: Cheq # '.$info->cheq_no.'; dt= '.date("d.m.Y",$info->cheq_date);
			  elseif($info->cheq_no=='')
			  $narration=$info->narration;
			  else
			  $narration=$info->narration.':: Cheq # '.$info->cheq_no.'; dt= '.date("d.m.Y",$info->cheq_date).'; Bank # '.$info->bank;
			  
	  ?>
      <tr>
        <td align="left"><?
        $grp_name=find_a_field('ledger_group','group_name','group_id='.$info->ledger_group_id);
		$ggrp = explode('>',$grp_name );
		echo $ggrp[1];
		?></td>
        <td align="left"><?=$info->ledger_name?> : <?=$info->ledger_id?></td>
        <td align="left"><?=$narration?></td>
        <td align="right"><?=number_format($info->dr_amt,2)?></td>
        <td align="right"><?=number_format($info->cr_amt,2)?></td>
      </tr>
<?php }?>
      <tr>
        <td colspan="3" align="right">Total Taka: </td>
        <td align="right"><?=number_format($dr_amt,2)?></td>
        <td align="right"><?=number_format($cr_amt,2)?></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Amount in Word : 	 (<?
	 echo convertNumberMhafuz($cr_amt);
	 ?>)
	 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabledesign_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <? if($vtype!='journal_info'){?><td align="center" valign="bottom">........................</td><? }?>
		<td align="center" valign="bottom"><u><?=$user_name?></u></td>
        <td align="center" valign="bottom">........................</td>
        <td align="center" valign="bottom">........................</td>
        <td align="center" valign="bottom">........................</td>
      </tr>
      <tr>
	    <? if($vtype!='journal_info'){?><td><div align="center">Received by </div></td><? }?>
        <td><div align="center">Prepared by </div></td>
        <td><div align="center">Checked by </div></td>
        <td><div align="center">Head of Accounts </div></td>
        <td><div align="center">Approved By </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
