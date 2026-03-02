<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../common/class.numbertoword.php');

$jv_no=$_REQUEST['jv_no'];

$address=find_a_field('project_info','proj_address',"1");

$jv_no=$_REQUEST['jv_no'];
$sql1="select * from journal where jv_no=$jv_no limit 1";
$jv = find_all_field('journal','jv_date','jv_no='.$jv_no);
$pr = find_all_field('production_issue_master','pi_no','pi_no='.$jv->tr_no);



if($_GET['update']=='Update')
{
	$req_status = $_GET['req_status'];
	$ssql='update requisition_master set status="'.$_GET['req_status'].'" where req_no="'.$req_no.'"';
	db_query($ssql);
}
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
{
    document.getElementById("pr").style.display="none";
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
    </tr>
</table>
</form>
<a target="_blank" href="../../warehouse_mod/pages/do/chalan_bill_view.php?v_no=<?=$jv->tr_no?>">CHALAN-<?=$jv->tr_no?></a></div>
</div></td>
        </tr>
      <tr>
        <td width="50%" class="tabledesign_text">Voucher Date :
          <?=date('d-m-Y',$jv->jv_date);?></td>
        <td class="tabledesign_text">&nbsp;</td>
      </tr>
      <tr>
        <td class="tabledesign_text"> Voucher No  : <?=$jv_no?></td>
        <td class="tabledesign_text">&nbsp;</td>
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
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign" style="font-size:12px">
      <tr>
        <td align="center"><div align="center">SL</div></td>
        <td align="center">A/C Code </td>
        <td align="center">Particulars</td>
        <td>Debit</td>
        <td>Credit</td>
      </tr>
      
	  <?
$sql2="SELECT a.ledger_name,b.* FROM accounts_ledger a, journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no=$jv_no and dr_amt>0 order by jv_no desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){		  
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;
		  $item_info = '';
		  if($info->dr_amt>0){
		 $sqld="select i.item_name,r.pkt_unit as ctn,r.dist_unit as pcs,i.pack_unit,i.unit_name from item_info i, sale_do_chalan r where r.item_id=i.item_id and r.id='".$info->tr_id."'";
		  $pur = find_all_field_sql($sqld);
		  $item_info = '';
		  if($pur->ctn>0||$pur->pcs>0)
		  $item_info .= '> '.$pur->item_name.' (';
		  if($pur->ctn>0)
		  $item_info .= (int)$pur->ctn.' '.$pur->pack_unit;
		  if($pur->ctn>0&$pur->pcs>0)
		  $item_info .= ' & ';
		  if($pur->pcs>0)
		  $item_info .= (int)$pur->pcs.' '.$pur->unit_name;
		  if($pur->ctn>0||$pur->pcs>0)
		  $item_info .= ')';}
		  ?>
        </div></td>
        <td align="left"><?=$info->ledger_id;?></td>
        <td align="left"><?=$info->ledger_name.$item_info;?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>
	  <?
$sql2="SELECT a.ledger_id,a.ledger_name,sum(cr_amt) as cr_amt FROM accounts_ledger a, journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no=$jv_no and cr_amt>0 group by b.jv_no desc";
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
    <td class="tabledesign"><div align="left">Amount in Word : 
     (<? echo convertNumberMhafuz($ttc)?>)	 </div></td>
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
