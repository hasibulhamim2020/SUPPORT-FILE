<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../common/class.numbertoword.php');

$jv_no=$_REQUEST['jv_no'];


if($_GET['voucher_date']!='')
{
	$voucher_date = strtotime($_GET['voucher_date']);
	$cc_code = $_GET['cc_code'];
	$jv=next_journal_voucher_id();
	
	add_to_journal($proj_id, $jv_no, $jv_date, $ledger_id, $narration, $dr_amt, $cr_amt, $tr_from, $jv,$sub_ledger='');
	
	
	
	$ssql='update journal set jv_date="'.$voucher_date.'", cc_code="'.$cc_code.'" where jv_no="'.$jv_no.'"';
	db_query($ssql);
	$xid = db_insert_id();
}


$address=find_a_field('project_info','proj_address',"1");



$sql1="select * from journal where jv_no=$jv_no and tr_no='Purchase' limit 1";
$jv = find_all_field('journal','jv_date','jv_no='.$jv_no." and tr_from='Purchase'");




if($jv->tr_id>0)
$pr = find_all_field('purchase_receive','pr_no','pr_no='.$jv->tr_no);
else
$pr = find_all_field('purchase_receive','pr_no','id='.$jv->tr_no);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../../../assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>

<link href="../../warehouse_mod/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../../warehouse_mod/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../warehouse_mod/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../warehouse_mod/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../warehouse_mod/js/jquery-ui-1.8.2.custom.min.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../warehouse_mod/js/jquery.validate.js"></script>
<script type="text/javascript" src="../../warehouse_mod/js/paging.js"></script>
<script type="text/javascript" src="../../warehouse_mod/js/ddaccordion.js"></script>
<script type="text/javascript" src="../../warehouse_mod/js/js.js"></script>
<script type="text/javascript" src="../../warehouse_mod/js/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
function hide()
{ document.getElementById("pr").style.display="none";
}
</script>
<? do_calander('#voucher_date');?></head>
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
				?>                </td>
              </tr>
              <tr>
                <td align="center"><?=$address?></td>
              </tr>
              <tr>
                <td align="center"><table  class="debit_box" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td width="325"><div align="center">JOURNAL VOUCHER</div></td>
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

<form action="" method="get">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
    <td width="80" align="right"><a target="_blank" href="../../warehouse_mod/pages/pr/chalan_view2.php?v_no=<?=$pr->pr_no?>">GR-
        <?=$pr->pr_no?>
    </a></td>
    <td width="150" align="right">Voucher Date :</td>
    <td width="0">

<input name="jv_no" type="hidden" value="<?=$jv_no?>" />
<input name="voucher_date" type="text" id="voucher_date" value="<?=date('Y-m-d',$jv->jv_date);?>" />    </td>
    <td><? if($jv->user_id<1){?><input name="check" type="submit" id="check" value="Update" /><? }?>
        <input type="hidden" name="req_no" id="req_no" value="<?=$jv->jv_on?>" /></td>
  </tr>
</table>
</form>
<a target="_blank" href="../../warehouse_mod/pages/pr/chalan_view2.php?v_no=<?=$pr->pr_no?>"></a></div>
</div></td>
        </tr>
      <tr>
        <td width="50%" class="tabledesign_text">Voucher Date :
          <?=date('d-m-Y',$jv->jv_date);?></td>
        <td class="tabledesign_text">
          GR Date :
          <?=date('d-m-Y',strtotime($pr->rec_date));  ?></td>
      </tr>
      <tr>
        <td class="tabledesign_text"> Voucher No  : <?=$jv_no?></td>
        <td class="tabledesign_text">Checked By :
          <? if($jv->user_id>0) echo find_a_field('user_activity_management','username','user_id='.$jv->user_id); else echo 'Not Checked';?></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><? if($cccode>0){?>CC CODE/PROJECT NAME: <? echo find_a_field('cost_center','center_name',"id='$cccode'")?><? }?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign">
      <tr>
        <td align="center"><div align="center">SL</div></td>
        <td align="center">A/C Code </td>
        <td align="center">A/C Ledger Head</td>
        <td>Debit</td>
        <td>Credit</td>
      </tr>
      
	  <?
$sql2="SELECT a.ledger_name,b.* FROM accounts_ledger a, journal b where b.tr_from = 'Purchase' and  b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no=$jv_no and dr_amt>0 order by jv_no desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;
		  if($jv->tr_id>0)
		  $sqld="select i.item_name,r.qty,r.unit_name from item_info i, purchase_receive r where r.item_id=i.item_id and r.id='".$info->tr_id."'";
		  else
		  $sqld="select i.item_name,r.qty,r.unit_name from item_info i, purchase_receive r where r.item_id=i.item_id and r.id='".$info->tr_no."'";
		  $pur = find_all_field_sql($sqld);
		  ?>
        </div></td>
        <td align="left"><?=$info->ledger_id?></td>
        <td align="left"><?=$info->ledger_name.'> '.$pur->item_name.'('.(int)$pur->qty.' '.$pur->unit_name.')';?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>
<?
$sql2="SELECT a.ledger_id,a.ledger_name,sum(cr_amt) as cr_amt FROM accounts_ledger a, journal b where b.tr_from = 'Purchase' and b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no=$jv_no and cr_amt>0 group by b.jv_no desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){		  
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;?>
        </div></td>
        <td align="left"><?=$info->ledger_id?></td>
        <td align="left"><?=$info->ledger_name?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>

      <tr>
        <td colspan="3" align="right">Total Taka: </td>
        <td align="right"><?=number_format($ttd,2)?></td>
        <td align="right"><?=number_format($ttc,2)?></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Amount in Word : 

	 (<? echo convertNumberMhafuz($ttc)?>)	 </td>
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
        <td align="center" valign="bottom">................................</td>
        <td align="center" valign="bottom">................................</td>
        <td align="center" valign="bottom">................................</td>
        <td align="center" valign="bottom">................................</td>
      </tr>
      <tr>
        <td width="33%"><div align="center">Received by </div></td>
        <td width="33%"><div align="center">Prepared by </div></td>
        <td width="33%"><div align="center">Head of Accounts </div></td>
        <td width="34%"><div align="center">Approved By </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
