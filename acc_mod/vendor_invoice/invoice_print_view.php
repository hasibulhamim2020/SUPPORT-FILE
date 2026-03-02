<?php

session_start();


require_once "../../../controllers/routing/print_view.top.php";


$tr_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));


$jv_all=find_all_field('secondary_journal','','tr_from in ("vendor_invoice_receive", "service_bill") and tr_no='.$tr_no);

$master_all=find_all_field('vendor_invoice_master','','system_invoice_no='.$tr_no);



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


$tr_type="Show";


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../../../../public/assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>

<link href="../../../../public/assets/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../../../../public/assets/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../../../public/assets/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />




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
@page {
		@bottom-center {
		  content: "Page " counter(page) " of " counter(pages);
		}
  }

</style>
</head>
<body><form action="" method="post">
<table width="820" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="17%" align="left">
              <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" style="width:153px;" alt="Logo" />
            </td>

            <td width="66%" align="center">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" class="title">
                    <?php 
                    //if ($_SESSION['user']['group'] > 0)
					if ($master_all->group_for > 0)
                      echo find_a_field('user_group','group_name',"id=".$master_all->group_for);
                    else
                      echo $_SESSION['proj_name'];
                    ?>
                  </td>
                </tr>

                <tr>
                  <td align="center">
                    <div class="debit_box" style="font-weight:bold;">
                      Vendor Invoice Receive
                    </div>
                  </td>
                </tr>
              </table>
            </td>

            <td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($tr_no); // Change variable as needed
              $print_url = "https://saaserp.ezzy-erp.com/app/views/acc_mod/vendor_invoice/invoice_print_view.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
</td>
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
    <td width="342">View Attachment</td>
    <td width="111"><?php if ($master_all->file_upload!=''){?>


<a href="../../../controllers/uploader/upload_view.php?proj_id=saaserp&&folder=accounts&&name=<?=$master_all->file_upload;?>" target="_blank">
Chalan 1 </a>
<?php } ?>


</td>
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
$sql2="SELECT a.ledger_id,a.ledger_name,b.sub_ledger,sum(dr_amt) as dr_amt, a.ledger_group_id, b.narration FROM accounts_ledger a, secondary_journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no='$jv_all->jv_no' and b.tr_from='$jv_all->tr_from' and dr_amt>0 group by b.ledger_id order by dr_amt desc";
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
$sql2="SELECT a.ledger_id,a.ledger_name,b.dr_amt,b.cr_amt, a.ledger_group_id,b.sub_ledger, b.narration FROM accounts_ledger a, secondary_journal b where b.jv_no='".$jv_all->jv_no."' and a.ledger_id=b.ledger_id and b.tr_from='$jv_all->tr_from' order by b.dr_amt desc";
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

<?
$page_name="Vendor Invoice Receive";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>