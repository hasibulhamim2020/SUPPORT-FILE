<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../common/class.numbertoword.php');


$tr_no=$_REQUEST['system_invoice_no'];


$jv_all=find_all_field('secondary_journal','','tr_from="is_invoice_receive" and tr_no='.$tr_no);




if($_POST['check']=='CHECK')
{
$time_now = date('Y-m-d H:i:s');
$voucher_date = $_POST['voucher_date'];
$cc_code = $_POST['cc_code'];

$ssql='update secondary_journal set  checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'", checked="YES" where tr_from = "'.$jv_all->tr_from.'" and jv_no="'.$jv_all->jv_no.'"';
	db_query($ssql);
	//$jv=next_journal_voucher_id();
	//sec_journal_journal($jv_no,$jv_no,$jv_all->tr_from);
}


$address=find_a_field('project_info','proj_address',"1");



$jv = find_all_field('secondary_journal','jv_date','jv_no='.$jv_all->jv_no);




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../../../assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>

<link href="../../css_js/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../../css_js/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css_js/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../css_js/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../css_js/js/jquery-ui-1.8.2.custom.min.js"></script>

<script type="text/javascript" src="../../css_js/js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../css_js/js/jquery.validate.js"></script>
<script type="text/javascript" src="../../css_js/js/paging.js"></script>
<script type="text/javascript" src="../../css_js/js/ddaccordion.js"></script>
<script type="text/javascript" src="../../css_js/js/js.js"></script>
<script type="text/javascript" src="../../css_js/js/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
function DoNav(theUrl)
{
	var URL = 'unchecked_voucher_view_popup_purchase.php?'+theUrl;
	popUp(URL);
}

function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>
<? do_calander('#voucher_date');?><? do_calander('#bill_date');?>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {color: #FFFFFF; font-weight: bold; font-size: 12px; }
-->
</style>
</head>
<body><form action="" method="post">
<table width="820" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="1%">
			</td>
            <td width="83%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" class="title">

				<?
if($_SESSION['user']['group']>1)
echo find_a_field('user_group','group_name',"id=".$jv->group_for);
else
echo $_SESSION['proj_name'];
				?>                </td>
              </tr>
              <!--<tr>-->
              <!--  <td align="center"><?=$address?></td>-->
              <!--</tr>-->
              <tr>
                <td align="center"><table  class="debit_box" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td width="325"><div align="center">Vendor Invoice Receive</div></td>
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

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td width="45"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
    <td width="162" align="right">
	<? if($jv->tr_from=='Sales'){?>
	<a target="_blank" href="../../../sales_mod/pages/direct_sales/sales_invoice_new.php?v_no=<?=$jv->tr_no;?>">Invoice# <?=$jv->tr_no;?> </a>	
	<? }?>
	</td>
    <td width="160" align="right"></td>
    <td width="342"></td>
    <td width="111"></td>
  </tr>
</table>

<a target="_blank" href="chalan_view2.php?v_no=<?=$pr->po_no?>"></a></div>
</div></td>
        </tr>
      <tr>
        <td class="tabledesign_text">Voucher Date :
          <?php echo date('d-m-Y',strtotime($jv->jv_date));?></td>
        <td class="tabledesign_text">
          TR From:
          <?=$jv_all->tr_from;?></td>
      </tr>
      <tr>
        <td class="tabledesign_text">Voucher No  :
          <?=$jv_all->jv_no?></td>
        <td class="tabledesign_text">Entry By :
          <? echo find_a_field('user_activity_management','fname','user_id='.$jv_all->entry_by);?></td>
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
        <td align="center">Control Head</td>
        <td align="center">A/C Ledger Head</td>
        <td align="center">Sub Ledger</td>
        <td align="center">Particulars</td>
        <td>Debit</td>
        <td>Credit</td>
      </tr>
      
	  <?
 $sql2="SELECT a.ledger_id,a.ledger_name,b.sub_ledger,sum(dr_amt) as dr_amt, a.ledger_group_id, b.narration FROM accounts_ledger a, secondary_journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no=$jv_no and dr_amt>0 group by b.ledger_id order by dr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){	
 $sub_ledger = find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$info->sub_ledger.'"');	  
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;
		  ?>
        </div></td>
        <td align="left"><?

       $grp_name=find_a_field('ledger_group','group_name','group_id='.$info->ledger_group_id);

		//$ggrp = explode('>',$grp_name );

		//echo $ggrp[1];

		?>		</td>
        <td align="left"><?=$info->ledger_name?></td>
        <td align="left"><?=$sub_ledger?></td>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>
<?
$sql2="SELECT a.ledger_id,a.ledger_name,b.dr_amt,b.cr_amt, a.ledger_group_id,b.sub_ledger, b.narration FROM accounts_ledger a, secondary_journal b where b.jv_no='".$jv_all->jv_no."' and a.ledger_id=b.ledger_id order by b.dr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){	
$sub_ledger = find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$info->sub_ledger.'"');		  
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;?>
        </div></td>
        <td align="left"><?

       echo $grp_name=find_a_field('ledger_group','group_name','group_id='.$info->ledger_group_id);

		//$ggrp = explode('>',$grp_name );

		//echo $ggrp[1];

		?></td>
        <td align="left"><?=$info->ledger_name?></td>
        <td align="left"><?=$sub_ledger?></td>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>





      <tr>
        <td colspan="5" align="right">Total : </td>
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
</table></form>
</body>
</html>
