<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
include "../common/check.php";
require "../common/db_connect.php";
require "../classes/db.php";
require_once ('../../common/class.numbertoword.php');
$proj_id	= $_SESSION['proj_id'];
$vtype		= $_REQUEST['v_type'];
$vdate		= $_REQUEST['vdate'];
$v_no 		= $_REQUEST['v_no'];
$no 		= $vtype."_no";
$in		= $_REQUEST['in'];




if($in=='Purchase'||$in=='Return') {$receiver='Vendor'; $i_no='p_inv_id';}
else {$receiver='Customer';$i_no='s_inv_id';}
	$sql_new="SELECT proj_address FROM project_info limit 1";
	//echo $sql_new;
	$sql1_new=db_query($sql_new);
	if($data_new=mysqli_fetch_row($sql1_new))
	{
		$address	= $data_new[0];
	}
	if(isset($_REQUEST['view']) && $_REQUEST['view']=='Show')
{
if($in=='Purchase')
$sql1="select a.cr_amt,b.ledger_name,a.jv_date,a.user_id,a.tr_id,a.req_no from journal a, accounts_ledger b where a.tr_no='$v_no' and a.ledger_id=b.ledger_id and a.cr_amt>0 limit 1";
else
{}
$data1=mysqli_fetch_row(db_query($sql1));
$req_no=$data1[5];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cash Memo :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<div class="header_title">
				<?
				if($vtype=='purchase_invoice') echo 'PURCHASE INVOICE';
elseif($vtype=='sales_invoice') echo 'SALES INVOICE';
elseif($vtype=='issue_invoice') echo 'ISSUE INVOICE';
else echo 'RETURN INVOICE';
				?>
				</div></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="bottom" width="23%"><? $path='../../logo/'.$_SESSION['proj_id'].'.jpg';
			if(is_file($path)) echo '<img src="'.$path.'" height="80" width="180" />';?></td>
			<td valign="bottom">
	<table class="debit_box" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td width="325"><div align="center"><?=$_SESSION['proj_name']?></div></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
			<td>
			<div class="address">
			<p><?=$address?></p>
			</div> </td>
		  </tr>
		</table>		</td>
	  </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  <tr>
    <td><div class="line"></div></td>
  </tr>
  <tr>
    <td><div class="header2">
      <div class="header2_left">To,<br><?php $ve=find_all_field('vendor','','vendor_id='.$data1[4]); echo $ve->vendor_name; ?><br />
      <?=$ve->address; ?>
      </div>
	  
      <div class="header2_right">
	  <p>Invoice No.: <?php echo $v_no;?><BR />
      Date: <?php echo $vdate;?><BR />
      <? if($req_no>0){?>Requisition  No: <?php echo $req_no;}?></p>	  
	  </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="pr">
<div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="8%"><strong>SL/No</strong></td>
        <td width="54%"><div align="center"><strong>Description of the Goods </strong></div></td>
        <td width="9%"><strong>Qty.</strong></td>
        <td width="15%"><strong>Unit Price </strong></td>
        <td width="14%"><strong>Total Price </strong></td>
      </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select a.*,b.sub_ledger from sub_ledger b, $vtype a where a.item=b.sub_ledger_id and a.".$i_no."='$v_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$amount[]=$info->qty*$info->rate;
$total=$total+($info->qty*$info->rate);
$sl[]=$pi;
$item[]=$info->sub_ledger;
$qty[]=$info->qty;
$rate[]=$info->rate;

}?>
      <tr>
        <td height="350" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$sl[$i]?></p><? }?></td>
        <td align="left" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$item[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$qty[$i]?></p><? }?></td>
        <td align="right" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=number_format($rate[$i],2)?></p><? }?></td>
        <td align="right" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=number_format($amount[$i],2)?></p><? }?></td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td align="right">Total:</td>
        <td align="right"><strong><?php echo number_format($total,2);?></strong></td>
      </tr>
    </table>
      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
		<td>In Word: Taka <?=convertNumberMhafuz($final_amt)?> Only</td>
          <td align="right">Discount:</td>
          <td align="right"><strong><?=number_format(($total-$final_amt),2)?></strong></td>
        </tr>
        <tr>
		<td align="right">&nbsp;</td>
          <td align="right">Tax/Vat(15%):</td>
          <td align="right"><strong>0.00</strong></td>
        </tr>
        <tr>
		<td align="right">&nbsp;</td>
          <td align="right">Grand Total:</td>
          <td align="right"><strong><?=number_format($final_amt,2);?></strong></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center">
	<div class="footer1">
	  <div style="float:left">
	  <p style="text-align:center">--------------------------<br />Authorized Person</p>
	  </div>	  
	  <div class="footer_right">
      <p style="text-align:center">--------------------------<br />Received By</p> </div>
	</div>
	<div class="footer1">
      <p style="float:left; font-weight:bold;">Prepared By: <?=find_a_field('user_activity_management','username','user_id='.$data1[3])?></p>
	</div></td>
  </tr>
</table>
</body>
</html>
