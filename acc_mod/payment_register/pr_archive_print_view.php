<?php

session_start();

require_once "../../../assets/support/inc.all.php";

require_once ('../../common/class.numbertoword.php');


$archive_date = $_REQUEST['date'];


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
                      <td width="500"><div align="center">Payment Register<br /><?=date('D, M, Y',strtotime($archive_date))?></div></td>
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
                    <tr class="bgc-info" bgcolor="#CCCCCC">
                        <th>SL</th>
						<th>Company</th>
						<th>Register Date</th>
						<th>Tr No.</th>
						<th>Type</th>
						<th>Payee</th>
                        <th>Ledger</th>
						<th>Payment Mode</th>
                        <th>Amount</th>
						
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
				
					//$res='select m.system_invoice_no,v.vendor_name,m.remarks,sum(d.amount) as amount,m.status,m.invoice_no,g.company_short_code from vendor v,vendor_invoice_details d, vendor_invoice_master m, user_group g where m.group_for=g.id and m.vendor_id=v.vendor_id and m.status in ("PENDING","PAID") and m.system_invoice_no=d.system_invoice_no and m.system_invoice_no in ('.$new_tr.') group by d.system_invoice_no order by m.system_invoice_no';
					
					$res='select p.archive_date,p.tr_no,p.payment_mode,p.tr_from,g.sub_ledger_name,a.ledger_name,p.payment_mode,p.amount,u.company_short_code from payment_register_archive p, general_sub_ledger g, accounts_ledger a, user_group u where u.id=p.group_for and p.sub_ledger_id=g.sub_ledger_id and p.cash_bank_ledger=a.ledger_id and p.archive_date="'.$archive_date.'"';

            $query = mysql_query($res);
                    while($row = mysql_fetch_object($query)){
					
					
                        ?>

                       <tr>
                            <td><?=++$sl;?></td>
							<td><?=$row->company_short_code?></td>
							<td><?=$row->archive_date?></td>
							<td><?=$row->tr_no?></td>
                            <td><?=$row->tr_from?></td>
                            <td><?=$row->sub_ledger_name?></td>
                            <td><?=$row->ledger_name?></td>
							<td><?=$row->payment_mode?></td>
							<td><?=number_format($row->amount,2)?></td>
                            

                        </tr>

                    <? $total +=$row->amount; } ?>
                    <tr bgcolor="#CCCCCC">
					 <td colspan="8">&nbsp;</td>
					 <td><?=number_format($total,2);?></td>
					</tr>
                    </tbody>
                </table></td>
  </tr>
  <tr>
    <td></td>
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