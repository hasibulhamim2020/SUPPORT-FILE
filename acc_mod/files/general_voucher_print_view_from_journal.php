<?php

 
session_start();


require_once "../../../controllers/routing/print_view.top.php";

$jv_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));
//$jv_no=url_decode($_REQUEST['jv_no']);

$jv_all=find_all_field('journal','','jv_no='.$jv_no);




if($jv_all->tr_from=='Receipt'){$voucher_name='RECEIPT VOUCHER';$vtypes='Receipt';}

elseif($jv_all->tr_from=='Payment'){$voucher_name='PAYMENT VOUCHER';$vtypes='Payment';}

elseif($jv_all->tr_from=='Journal'){$voucher_name='JOURNAL VOUCHER';$vtypes='Journal';}

elseif($jv_all->tr_from=='Contra'){$voucher_name='CONTRA VOUCHER';$vtype='contra';$vtypes='Contra';}

elseif($jv_all->tr_from=='Sales'){$voucher_name='SALES JOURNAL';$vtypes='Sales';}

elseif($jv_all->tr_from=='Purchase'){$voucher_name='PURCHASE JOURNAL';$vtypes='Purchase';}


else{$vtype=='journal';$voucher_name='JOURNAL VOUCHER';$vtypes='journal';}



$bill_no=$_REQUEST['bill_no'];
$bill_date=$_REQUEST['bill_date'];

if($_POST['check']=='CHECK')
{
$time_now = date('Y-m-d H:i:s');
$voucher_date = $_POST['voucher_date'];
$cc_code = $_POST['cc_code'];


//$po_no = find_a_field('journal','tr_no','tr_from = "Purchase" and jv_no='.$jv_no);
//$po = find_all_field('purchase_master','po_no','po_no='.$po_no);

	//$ssql='update purchase_invoice set bill_no="'.$bill_no.'", bill_date="'.$bill_date.'" where po_no="'.$prold->po_no.'"';
	//db_query($ssql);
	
	
    //$narration = 'Sale#'.$po->sale_no.'/ PO#'.$po->po_no.' (Bill#'.$bill_no.'/ Dt:'.$bill_date.')';
	
	$ssql='update journal set  checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'", checked="YES" where tr_from = "'.$jv_all->tr_from.'" and jv_no="'.$jv_no.'"';
	db_query($ssql);
	//$jv=next_journal_voucher_id();
	sec_journal_journal($jv_no,$jv_no,$jv_all->tr_from);
}
if($_POST['check']=='RE-CHECK')
{
$time_now = date('Y-m-d H:i:s');
$voucher_date = strtotime($_POST['voucher_date']);
$cc_code = $_POST['cc_code'];


$jvold = find_a_field('journal','tr_id','tr_from = "Purchase" and jv_no='.$jv_no);
$prold = find_all_field('purchase_invoice','po_no','id='.$jvold);

	$ssql='update purchase_invoice set bill_no="'.$bill_no.'", bill_date="'.$bill_date.'" where po_no="'.$prold->po_no.'"';
	db_query($ssql);
	
	$narration = 'GR#'.$prold->id.'/'.$prold->po_no.'(PO#'.$prold->po_no.')(Bill#'.$bill_no.'/Dt:'.$bill_date.')';
	$ssql='update journal set narration="'.$narration.'",jv_date="'.$voucher_date.'", cc_code="'.
	$cc_code.'", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'", checked="YES" , 	final_jv_no="'.$jv.'" where tr_from = "Purchase" and jv_no="'.$jv_no.'"';
	db_query($ssql);
	$sssql = 'delete from journal where group_for="'.$_SESSION['user']['group'].'" and tr_from ="Purchase" and tr_no="'.$prold->po_no.'"';
	db_query($sssql);
	$jv=next_journal_voucher_id();
	sec_journal_journal($jv_no,$jv,'Purchase');
}

$address=find_a_field('project_info','proj_address',"1");

$jv = find_all_field('journal','jv_date','jv_no='.$jv_no);

$cccode = $jv->cc_code;

$tr_type="Show";


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../../../../public/assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>

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
<style>
@page {
		@bottom-center {
		  content: "Page " counter(page) " of " counter(pages);
		}
  }

<style>
.jvbutton {
    display: block;
	float:left;
    width: auto;
    height: 25px;
    background: #4E9CAF;
    padding: 5px 20px 5px 20px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    line-height: 25px;
	
	margin-right: 20px;
}


.jvbutton:hover {

    color: #000000;
    font-weight: bold;

}

#pr input[type="button"] {
	width: 70px;
	height: 25px;
	background-color: #6cff36;
	color: #333;
	font-weight: bolder;
	border-radius: 5px;
	border: 1px solid #333;
	cursor: pointer;
}

</style>

<? do_calander('#voucher_date');?><? do_calander('#bill_date');?>
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
                    if ($jv->group_for)
                      echo find_a_field('user_group','group_name',"id=".$jv->group_for);
                    else
                      echo $_SESSION['proj_name'];
                    ?>
                  </td>
                </tr>
                <tr>
                  <td align="center"><?=$address?></td>
                </tr>
                <tr>
                  <td align="center">
                    <div class="debit_box" style="font-weight:bold;">
                      <?=$voucher_name?>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
            <td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($jv_no);
              $print_url = "https://saaserp.ezzy-erp.com/app/views/acc_mod/files/general_voucher_print_view_from_journal.php?c=". rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data);
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
<? //if($jv->checked!='YES'){?>
<div align="left">

<?php /*?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td width="45"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
    <td width="162" align="right">
	<? if($jv->tr_from=='Sales'){?>
	<a target="_blank" href="../../../sales_mod/pages/direct_sales/sales_invoice_new.php?v_no=<?=$jv->tr_no;?>">Invoice# <?=$jv->tr_no;?> </a>	
	<? }?>
	</td>
    <td width="160" align="right">Voucher Date :</td>
    <td width="342">

<input name="jv_no" type="hidden" value="<?=$jv_no?>" />
<input name="voucher_date" type="text" id="voucher_date" value="<?=$jv->jv_date;?>" />
<!--<input type="button" name="Submit" value="EDIT VOUCHER"  onclick="DoNav('<?php echo '&v_no='.$jv_no.'&view=Show' ?>');" />--></td>
    <td width="111"><input name="check" type="submit" id="check" value="CHECK" />
        <input type="hidden" name="req_no" id="req_no" value="<?=$jv->jv_on?>" /></td>
  </tr>
</table><?php */?>

<a target="_blank" href="chalan_view2.php?v_no=<?=$pr->po_no?>"></a></div><? //}else{?>
<div align="left">

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#00CC00">
  <tr>
    <td width="51" bgcolor="#82D8CF"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
    <td width="670" align="right" bgcolor="#82D8CF">
	<? if($jv->tr_from=='Sales'){?>
	<a target="_blank" class="jvbutton" href="../../../warehouse_mod/pages/wo/sales_invoice_print_view.php?v_no=<?=$jv->tr_no;?>">Invoice View # <?=$jv->tr_no;?> </a>	
	<? }?>
	
	<? if($jv->tr_from=='Sales Return'){?>
	<a target="_blank" class="jvbutton" href="../../../sales_mod/pages/C2C/sales_return_print_view.php?v_no=<?=$jv->tr_id;?>">SR View # <?=$jv->tr_no;?> </a>	
	<? }?>
	
	<? if($jv->tr_from=='Purchase'){?>
	<a target="_blank" class="jvbutton" href="../../../views/warehouse_mod/po_receiving/chalan_view2.php?v_no=<?=rawurlencode(url_encode($jv->tr_no));?>">GRN View # <?=$jv->tr_no;?> </a>
	<? }?>
	
	
	

	
	<? if($jv->tr_from=='BillReceive' || $jv->tr_from=='BillSubmit'){?>
	<a target="_blank" class="jvbutton" href="../../../bill_mod/pages/bill/invoice_print_view.php?bill_no=<?=$jv->tr_no;?>">Invoice View # <?=$jv->tr_no;?> </a>	
	<? }?>	</td>
    <td width="22" bgcolor="#82D8CF">

<input name="jv_no" type="hidden" value="<?=$jv_no?>" />
<input name="voucher_date" type="hidden" id="voucher_date" value="<?=$jv->jv_date;?>" />
<!--<input type="button" name="Submit" value="EDIT VOUCHER"  onclick="DoNav('<?php echo '&v_no='.$jv_no.'&view=Show' ?>');" />--></td>
    <td width="85" bgcolor="#82D8CF"><input name="check" type="hidden" id="check" value="RE-CHECK" />
        <input type="hidden" name="req_no" id="req_no" value="<?=$jv->jv_on?>" /></td>
  </tr>
</table>

<a target="_blank" href="chalan_view2.php?v_no=<?=$pr->po_no?>"></a></div><? // }?>
</div></td>
        </tr>
      <tr>
        <td class="tabledesign_text"> <strong>Voucher Date :</strong>
          <?php echo date('d-m-Y',strtotime($jv->jv_date));?></td>
        <td class="tabledesign_text" align="right">
			<strong>TR From:</strong>
          <?=$jv->tr_from;?></td>
      </tr>
      <tr>
        <td class="tabledesign_text"> <strong> Voucher No  :</strong>
          <?=$jv_no?></td>
        <td class="tabledesign_text" align="right"> <strong>TR No  :</strong>
          <?=$jv->tr_no;?></td>
      </tr>
    </table></td>
  </tr>
 
  <tr style="font-size:14px">
    <td>&nbsp;</td>
  </tr>
  <tr style="font-size:14px">
    <td><strong>Remarks: </strong><?= $jv->remarks?></td>
  </tr>
  <?php /*?><tr style="font-size:14px">
    <td><? if($cccode>0){?>
      <strong>CC CODE:</strong> <? echo find_a_field('cost_center','center_name',"id='$cccode'")?><? }?></td>
  </tr><?php */?>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign">
      <tr>
        <td align="center" bgcolor="#82D8CF"><div align="center"><strong>SL</strong></div></td>
        <td align="center" bgcolor="#82D8CF"><strong>GL Code </strong></td>
        <td align="center" bgcolor="#82D8CF"><strong>GL Name </strong></td>
		 <td align="center" bgcolor="#82D8CF"><strong>Sub Ledger </strong></td>
        <td align="center" bgcolor="#82D8CF"><strong>Narration</strong></td>
        <td bgcolor="#82D8CF"><strong>Debit</strong></td>
        <td bgcolor="#82D8CF"><strong>Credit</strong></td>
      </tr>
      
	  <?
	      $ssql='select * from general_sub_ledger where 1 group by sub_ledger_id';
	  $squery=db_query($ssql);
	  while($srow=mysqli_fetch_object($squery)){
	  $sub_ledger_name_get[$srow->sub_ledger_id]=$srow->sub_ledger_name;
	  }
 $sql2="SELECT a.ledger_id,a.ledger_name,sum(dr_amt) as dr_amt, a.ledger_group_id, b.narration, b.reference_id, b.cc_code,b.sub_ledger FROM accounts_ledger a, journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no=$jv_no and dr_amt>0 group by b.id order by dr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){		  
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;
		  ?>
        </div></td>
        <td align="left"><?=$info->ledger_id?>		</td>
        <td align="left"><?=$info->ledger_name?></td>
		 <td align="left"><?php echo $sub_ledger_name_get[$info->sub_ledger];?></td>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>
<?


	  
	  
 $sql2="SELECT a.ledger_id,a.ledger_name,sum(cr_amt) as cr_amt, a.ledger_group_id, b.narration, b.reference_id, b.cc_code,b.sub_ledger FROM accounts_ledger a, journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no=$jv_no and cr_amt>0 group by b.id order by cr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){		  
	  ?>
      <tr>
        <td align="left"><div align="center">
          <?=++$s;?>
        </div></td>
        <td align="left"><?=$info->ledger_id?></td>
        <td align="left"><?=$info->ledger_name?></td>
		 <td align="left"><?php echo $sub_ledger_name_get[$info->sub_ledger];?></td>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>





      <tr bgcolor="#f5f5c1">
        <td colspan="5" align="right"><strong>Total : </strong></td>
        <td align="right"><strong>
          <?=number_format($ttd,2)?>
        </strong></td>
        <td align="right"><strong>
          <?=number_format($ttc,2)?>
        </strong></td>
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
        <td align="center" valign="bottom">&nbsp;</td>
        <td align="center" valign="bottom">&nbsp;</td>
        <td align="center" valign="bottom">&nbsp;</td>
        <td align="center" valign="bottom">&nbsp;</td>
      </tr>
	
      <tr>
        <td align="center" valign="bottom">................................</td>
        <td align="center" valign="bottom">................................</td>
        <td align="center" valign="bottom">................................</td>
        <td align="center" valign="bottom">................................</td>
      </tr>
      <tr>
        <td width="33%"><div align="center">Prepared By </div></td>
        <td width="33%"><div align="center">Checked By </div></td>
		<td width="34%"><div align="center">Approved By </div></td>
        <td width="33%"><div align="center">Authorized By</div></td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>

<?
$page_name="Journal Voucher";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>