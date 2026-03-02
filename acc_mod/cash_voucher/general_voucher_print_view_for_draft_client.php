<?php
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
session_start();

require_once "../../../controllers/routing/print_view.top.php";

//require_once "../../../controllers/core/class.numbertoword.php";

$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));
$jv_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$sub_ledger=url_decode(str_replace(' ', '+', $_REQUEST['sub_ledger']));



//$jv_no=url_decode(str_replace(' ', '+', $_REQUEST['jv_no']));
//$sub_ledger=url_decode(str_replace(' ', '+', $_REQUEST['sub_ledger']));



$jv_all=find_all_field('secondary_journal','','jv_no='.$jv_no);

$group_data = find_all_field('user_group','*','id='.$jv_all->group_for);



if($jv_all->tr_from=='Receipt'){$voucher_name='RECEIPT VOUCHER';$vtypes='Receipt';}

elseif($jv_all->tr_from=='Payment'){$voucher_name='PAYMENT VOUCHER';$vtypes='Payment';}

elseif($jv_all->tr_from=='Journal'){$voucher_name='JOURNAL VOUCHER';$vtypes='Journal';}

elseif($jv_all->tr_from=='Contra'){$voucher_name='CONTRA VOUCHER';$vtype='contra';$vtypes='Contra';}

elseif($jv_all->tr_from=='Sales'){$voucher_name='SALES secondary_journal';$vtypes='Sales';}

elseif($jv_all->tr_from=='Purchase'){$voucher_name='PURCHASE secondary_journal';$vtypes='Purchase';}


else{$vtype=='secondary_journal';$voucher_name='secondary_journal VOUCHER';$vtypes='secondary_journal';}



$bill_no=$_REQUEST['bill_no'];
$bill_date=$_REQUEST['bill_date'];

if($_POST['check']=='CHECK')
{
$time_now = date('Y-m-d H:i:s');
$voucher_date = $_POST['voucher_date'];
$cc_code = $_POST['cc_code'];


//$po_no = find_a_field('secondary_journal','tr_no','tr_from = "Purchase" and jv_no='.$jv_no);
//$po = find_all_field('purchase_master','po_no','po_no='.$po_no);

	//$ssql='update purchase_invoice set bill_no="'.$bill_no.'", bill_date="'.$bill_date.'" where po_no="'.$prold->po_no.'"';
	//db_query($ssql);
	
	
    //$narration = 'Sale#'.$po->sale_no.'/ PO#'.$po->po_no.' (Bill#'.$bill_no.'/ Dt:'.$bill_date.')';
	
	$ssql='update secondary_journal set  secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where tr_from = "'.$jv_all->tr_from.'" and jv_no="'.$jv_no.'"';
	db_query($ssql);

$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$jv_all->tr_from.'"');

if($jv_config=="Yes"){

sec_journal_journal($jv_no,$jv_no,$jv_all->tr_from);

$time_now = date('Y-m-d H:i:s');

$up2='update secondary_journal set checked="YES", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$jv_all->tr_from.'"';

db_query($up2);

$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$jv_all->tr_from.'"';
db_query($sa_up2);


}


}


if($_POST['check']=='RE-CHECK')
{
$time_now = date('Y-m-d H:i:s');
$voucher_date = strtotime($_POST['voucher_date']);
$cc_code = $_POST['cc_code'];


$jvold = find_a_field('secondary_journal','tr_id','tr_from = "Purchase" and jv_no='.$jv_no);
$prold = find_all_field('purchase_invoice','po_no','id='.$jvold);

	$ssql='update purchase_invoice set bill_no="'.$bill_no.'", bill_date="'.$bill_date.'" where po_no="'.$prold->po_no.'"';
	db_query($ssql);
	
	$narration = 'GR#'.$prold->id.'/'.$prold->po_no.'(PO#'.$prold->po_no.')(Bill#'.$bill_no.'/Dt:'.$bill_date.')';
	$ssql='update secondary_journal set narration="'.$narration.'",jv_date="'.$voucher_date.'", cc_code="'.
	$cc_code.'", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'", checked="YES" , 	final_jv_no="'.$jv.'" where tr_from = "Purchase" and jv_no="'.$jv_no.'"';
	db_query($ssql);
	$sssql = 'delete from secondary_journal where group_for="'.$_SESSION['user']['group'].'" and tr_from ="Purchase" and tr_no="'.$prold->po_no.'"';
	db_query($sssql);
	$jv=next_secondary_journal_voucher_id();
	sec_secondary_journal_secondary_journal($jv_no,$jv,'Purchase');
}

$address=find_a_field('project_info','proj_address',"1");
$jv = find_all_field('secondary_journal','jv_date','jv_no='.$jv_no);

$cccode = $jv->cc_code;


	$req_bar_no = $jv->tr_no;
	$barcode_content = $req_bar_no;
	$barcodeText = $barcode_content;
    $barcodeType='code128';
	$barcodeDisplay='horizontal';
    $barcodeSize=40;
    $printText='';

	$tr_type="Show";


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
    //document.getElementById("pr").style.display="none";
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


<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php"); ?>

<?php if($cid == 'golden' || $cid == 'demo-golden' ||  $cid == 'visionfin' ){?>
<style>
	.footer1{
		position: relative;
		width: 100%;
	}
	
	@media print {
		.footer1 {
			margin-top:50px;
/*			position: fixed;
			bottom: 0;
			width: 100%;*/
			page-break-after:avoid;
			position: relative;
			width: 100%;
		}
	}
	
</style>

 <? } else{?>
 
  <? } ?>


	

<? do_calander('#voucher_date');?>
<? do_calander('#bill_date');?>
</head>
<body>



<form action="" method="post">

<div class="body">
	<div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> 
				<?php
						echo $group_data -> group_name;
						?>
				</h2>
				<p class="text"><?=$address?></p>
<!--				<p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?></p>-->

		</td>
		
		
		<?php /*?><td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?php echo $jv->tr_no?></p>
		</td><?php */?>
		
		<td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($jv_no); 
			  $sub_ledger = url_encode($sub_ledger);
              $print_url = "https://saaserp.ezzy-erp.com/app/views/acc_mod/cash_voucher/general_voucher_print_view_for_draft_client.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data) . "&sub_ledger=" .rawurlencode($sub_ledger);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>
		
		</tr>
		 
		</table>
	</div>
	
	<div class="header-one">
	<hr class="hr">
		<h5 class="report-titel"><span><?=$voucher_name?></span></h5>
	<br>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			<p class="left-text mt-1 mb-1">Voucher Date : <span><?php echo date('d-m-Y',strtotime($jv->jv_date));?> </span></p>
			

		</div>

		<div class="col-md-6 col-sm-6 col-lg-6 right">
			<p class="right-text mt-1 mb-1">Voucher No : <span> <?=$jv_no?> </span></p>
			
			
		</div>
	</div>


</div>


<div class="main-content pt-3">
	
	
	<div id="pr">
        <div align="left">
         	 <p> <input name="button" type="button" onclick="hide();window.print();" value="Print"> </p>    
		</div>
		
		<div align="left">
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#00CC00">
			  <tr>
				<td width="51" bgcolor="#82D8CF">
			<!--        <input name="button" type="button" onclick="hide();window.print();" value="Print" />-->
				</td>
				<td width="670" align="right" bgcolor="#82D8CF">
					</td>
				<td width="22" bgcolor="#82D8CF">
			
			<input name="jv_no" type="hidden" value="<?=$jv_no?>" />
			<input name="voucher_date" type="hidden" id="voucher_date" value="<?=$jv->jv_date;?>" />
			<!--<input type="button" name="Submit" value="EDIT VOUCHER"  onclick="DoNav('<?php echo '&v_no='.$jv_no.'&view=Show' ?>');" />--></td>
				<td width="85" bgcolor="#82D8CF"><input name="check" type="hidden" id="check" value="RE-CHECK" />
					<input type="hidden" name="req_no" id="req_no" value="<?=$jv->jv_on?>" /></td>
			  </tr>
			</table>
			<br><br />
			<a target="_blank" href="chalan_view2.php?v_no=<?=$pr->po_no?>"></a></div><?php /*?><?}?><?php */?>
	</div>
	
	  
	<table class="table1">
		<thead>
			<tr>
	
				<th>Sub Ledger</th>
				<th>Narration</th>
				<th>Taka</th>
			</tr>
		</thead>
       
		<tbody>

<?
$sub_ledger=url_decode(str_replace(' ', '+', $_REQUEST['sub_ledger']));

 $sql2="SELECT a.ledger_id,a.ledger_name,sum(cr_amt) as cr_amt,sum(dr_amt) as dr_amt, a.ledger_group_id, b.narration, b.reference_id,b.sub_ledger, b.cc_code FROM accounts_ledger a, secondary_journal b where b.jv_no='$jv_no' and  b.sub_ledger='$sub_ledger' and a.ledger_id=b.ledger_id and jv_no=$jv_no group by b.id 
 order by cr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){		  
	  ?>
      <tr>
        
				<td align="left"><?=find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id='.$info->sub_ledger);?></td>
        <td align="left"><?=$info->narration?></td>
		
		
		<? if ($info->cr_amt>0) { ?>
					<td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
			<? } else { ?>
					<td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
			<? } ?>
		
		
        </tr>
<?php }?>


			  <tr>
				<td align="right" colspan="2" style="text-align:right;"><strong>Total:</strong></td>
				
					<? if ($jv_all->tr_from=='Receipt') { ?>
					<td align="right" style="text-align:right;"><strong><?=number_format($ttc,2)?></strong></td>
			<? } else { ?>
					<td align="right" style="text-align:right;"><strong><?=number_format($ttd,2)?></strong></td>
			<? } ?>
		
				
				
				
				
			  </tr>
			  
		
			</tbody>
		
    </table>
	

	<p class="p bold">In Words : <? echo convertNumberMhafuz($ttc)?>.	

		</p>

</div>





<div class="footer1"  id="footer">
	<table class="footer-table">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
	
          <td class="text-center w-20">
		  <p style="font-weight:600; margin: 0;">
			  
			  
			  <?php 
			$sign_data = find_a_field('user_activity_management','sign','user_id='.$jv->entry_by);

			if($sign_data != ''){
			?>
    		<img src="<?= SERVER_UPLOAD ?>user_signature/<?php echo $_SESSION['proj_id'].'/'.$sign_data; ?>" style="width:80px;" />
			<?php } ?>
			<br>
			  
			  <?=find_a_field('user_activity_management','fname','user_id='.$jv->entry_by);?>
		  </p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$jv->entry_by);?>) <br/> <?=$jv->entry_at?></p>
		  </td>
          <td class="text-center w-20">
		  <p style="font-weight:600; margin: 0;"> </p>
		 
		  </td>
          <td class="text-center w-20"></td>
          <td class="text-center w-20"></td>
        </tr>
        <tr>
		  <td class="text-center">----------------</td>
          <td class="text-center">----------------</td>
          <td class="text-center">----------------</td>
          <td class="text-center">----------------</td>
        </tr>
        <tr>
		 <td class="text-center"><strong>Received By</strong></td>
          <td class="text-center"><strong>Cashier</strong></td>
          <td class="text-center"><strong>Accountant</strong></td>
          <td class="text-center"><strong>Authorised Sign.</strong></td>
        </tr>
	
	
	
	
	</table>

	  </div>
	  
	  
	  
</div>
</form>

</body>
</html>

<?
$page_name="General Voucher";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>