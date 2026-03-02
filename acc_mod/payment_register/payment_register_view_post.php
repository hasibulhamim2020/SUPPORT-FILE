<?php

session_start();

require_once "../../../assets/support/inc.all.php";

require_once ('../../common/class.numbertoword.php');

$tr_no = isset($_REQUEST['checked_tr_no']) ? $_REQUEST['checked_tr_no'] : [];
$new_tr = implode(",",$tr_no);

foreach($tr_no as $tr){
$approve_amt = $_POST['pay_'.$tr];
$payment_method = $_POST['payment_mode'.$tr];
$update = 'update payment_register set approved_amt="'.$approve_amt.'",payment_method="'.$payment_method.'",is_selected="Yes" where id="'.$tr.'"';
mysql_query($update);
}

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
<script type="text/javascript" src="https://erpengine.cloud/npm/plugins/ddaccordion/ddaccordion2026.js"></script>
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

//echo find_a_field('user_group','group_name',"id=".$_REQUEST['cid']);

				?>                </td>
              </tr>
              <!--<tr>-->
              <!--  <td align="center"><?=$address?></td>-->
              <!--</tr>-->
              <tr>
                <td align="center"><table  class="debit_box" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td width="325"><div align="center">Payment Register</div></td>
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
    <td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign">
                    <thead class="thead1">
                    <tr class="bgc-info" style="height:30px; background:#ccc;">
                        <th>SL<input type="hidden" name="tr_nos" id="tr_nos" value="<?=$new_tr?>" /></th>
						<th>Invoice No.</th>
						<th>Company</th>
						<th>Payee Name</th>
						<th>Payment Mode</th>
						<th>Cash/Bank</th>
                        <th>Amount</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
				
					//$res='select m.system_invoice_no,v.vendor_name,m.remarks,sum(d.amount) as amount,m.status,m.invoice_no,g.company_short_code from vendor v,vendor_invoice_details d, vendor_invoice_master m, user_group g where m.group_for=g.id and m.vendor_id=v.vendor_id and m.status in ("PENDING","PAID") and m.system_invoice_no=d.system_invoice_no and m.system_invoice_no in ('.$new_tr.') group by d.system_invoice_no order by m.system_invoice_no';
					
					$res = 'select p.*,s.sub_ledger_name,g.company_short_code from payment_register p, general_sub_ledger s, user_group g where p.payee_sub_ledger=s.sub_ledger_id and p.group_for=g.id and p.id in ('.$new_tr.')';

            $query = mysql_query($res);
                    while($row = mysql_fetch_object($query)){
					
					$amount = $_POST['pay_'.$row->id];
					$total_amt +=$amount;
                        ?>

                        <tr>
                            <td><?=++$sl;?>
							<input type="hidden" name="tr_no<?=$row->id?>" id="tr_no<?=$row->id?>" value="<?=$row->tr_no?>" />
							<input type="hidden" name="tr_from<?=$row->id?>" id="tr_from<?=$row->id?>" value="<?=$row->tr_from?>" />
							<input type="hidden" name="sub_ledger<?=$row->id?>" id="sub_ledger<?=$row->id?>" value="<?=$row->payee_sub_ledger?>" />
							<input type="hidden" name="ledger_id<?=$row->id?>" id="ledger_id<?=$row->id?>" value="<?=$row->cr_ledger?>" />
							<input type="hidden" name="payment_method<?=$row->id?>" id="payment_method<?=$row->id?>" value="<?=$_POST['payment_mode'.$row->id]?>" />
							<input type="hidden" name="amount<?=$row->id?>" id="amount<?=$row->id?>" value="<?=$amount?>" />
							</td>
							<td><div align="left"><?=$row->tr_no?></div></td>
							<td><div align="left"><?=$row->company_short_code?></div></td>
							<td><div align="left"><?=$row->sub_ledger_name?></div></td>
							<td><div align="left"><?=$_POST['payment_mode'.$row->id]?></div></td>
							<td><div align="left"><?=$_POST['cash_bank_info'.$row->id]?></div></td>
                            <td><div align="right"><?=number_format($amount,2)?></div></td>
                       
                        </tr>

                    <? } ?>
                    <tr style="height:30px; background:#ccc;">
					 <td colspan="6"><strong>Total</strong></td>
					 <td><div align="right"><strong><?=number_format($total_amt,2);?></strong></div></td>
					</tr>
                    </tbody>
                </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td align="center"><span id="show_msg"><br /><input type="button" name="save" id="save" value="Save Now" onclick="register_save()"  /></span></td>
  </tr>
  <tr>
    <td>Amount in Word : 

	 (<? echo convertNumberMhafuz($total_amt)?>)	 </td>
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
        <td align="center" valign="bottom"><?=find_a_field('user_activity_management','fname','user_id="'.$_SESSION['user']['id'].'"');?></td>
        <td align="center" valign="bottom"></td>
        <td align="center" valign="bottom"></td>
        <td align="center" valign="bottom"></td>
      </tr>
      <tr>
        <td align="center" valign="bottom">................................</td>
        <td align="center" valign="bottom"></td>
        <td align="center" valign="bottom"></td>
        <td align="center" valign="bottom">................................</td>
      </tr>
      <tr>
        <td width="33%"><div align="center">Prepared by </div></td>
        <td width="33%"><div align="center"></div></td>
        <td width="33%"><div align="center"></div></td>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

  function register_save() {
  
  var tr_nos = document.getElementById('tr_nos').value;
    $.ajax({
      url: 'archive_register_ajax.php',
      type: 'POST',
      data: {
        tr_no: tr_nos
		
      },
      success: function(response) {
      
        var res = JSON.parse(response);
		document.getElementById("show_msg").textContent = res['msg'];
		
      },
      error: function(xhr, status, error) {
        
        console.error(error);
      }
    });
  }
</script>