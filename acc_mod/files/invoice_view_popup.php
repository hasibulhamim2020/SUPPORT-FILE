<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
include "../common/check.php";
require "../common/db_connect.php";
$proj_id	= $_SESSION['proj_id'];
$vtype		= $_REQUEST['v_type'];
$vdate		= $_REQUEST['vdate'];
$v_no 		= $_REQUEST['v_no'];
$no 		= $vtype."_no";
$in			= $_REQUEST['in'];
$now		= time();
if($in=='Purchase'||$in=='Return') 
{$receiver='Vendor'; $i_no='p_inv_id';}
else 
{$receiver='Customer';$i_no='s_inv_id';}
if(isset($_REQUEST['delete']))
{	

	$sqlDel1 = "DELETE FROM $vtype WHERE ".$i_no."='$v_no'";
	$sqlDel2 = "DELETE FROM journal WHERE tr_no='$v_no' AND tr_from='$in'";
	if(db_query($sqlDel1)){}
	if(db_query($sqlDel2)){}
	echo "<script>self.opener.location = 'voucher_view.php'; self.blur(); </script>";
}

if(isset($_POST['change']))
{
	$vdate = $_POST["vdate"];
	$j=0;
	for($i=0;$i<strlen($vdate);$i++)
	{
		if(is_numeric($vdate[$i]))
		$time1[$j]=$time1[$j].$vdate[$i];
		
		else $j++;
	}	
	$v_date=mktime(0,0,0,$time1[1],$time1[0],$time1[2]);
	$sqldate2 = "UPDATE journal SET jv_date='$v_date' WHERE tr_no='$v_no' AND tr_from='$in'";
	db_query($sqldate2) or die(mysqli_error());
}

if(isset($_POST['paid']))
{
	$sql4="select a.narration,b.ledger_name,a.jv_date from journal a, accounts_ledger b where a.tr_no='$v_no' and a.ledger_id=b.ledger_id limit 1";
	$data4=mysqli_fetch_row(db_query($sql4));
	if($in=='Purchase')
	{
	
	}
	if($in=='Salses')
	{
	$jv=next_journal_voucher_id();
	pay_invoice_amount($proj_id, $jv, $date, $ledger,'100018', $narration, $f_paid, 'Sales', $jv);
	}
	$sqldate2 = "UPDATE journal SET jv_date='$v_date' WHERE tr_no='$v_no' AND tr_from='$in'";
	db_query($sqldate2) or die(mysqli_error());
}

if(isset($_REQUEST['view']) && $_REQUEST['view']=='Show')
{
$sql1="select a.narration,b.ledger_name,a.jv_date from journal a, accounts_ledger b where a.tr_no='$v_no' and a.ledger_id=b.ledger_id limit 1";
	$data1=mysqli_fetch_row(db_query($sql1));
?>
<link href="common/menu.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="common/screen.css" media="all" />
<link href="assets/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="assets/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(function() {
		$("#vdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
	});
});
</script>
<style>
.vlink {
    background: none repeat scroll 0 0 #CCCCCC;
    border: 1px solid #999999;
    margin: 2px 5px;
    padding: 2px 5px;
}</style>
	  <form action="" method="post" name="form2">
      <table width="99%" border="1" align="center" bordercolor="#000066" id="vbig">
        <tr>
          <td width="50%" height="50">

		  <table width="100%" border="0" align="center" bordercolor="#0099FF" bgcolor="#D9EFFF" cellspacing="0">
              <tr>
                <td width="12%" height="20" align="right" nowrap><strong><?=$receiver.' Name:'?></strong></td>
                <td width="22%" align="left"><?php echo $data1[1];?>&nbsp;</td>
                <td align="right" nowrap><strong>Invoice Date: </strong></td>
                <td align="left"><input name="vdate" id="vdate" type="text" value="<?php echo $vdate;?>" /></td>
              </tr>
              <tr>
                <td height="20" align="right" nowrap><strong>Invoice Date: </strong></td>
                <td height="20" align="left"><?php echo $vdate;?>&nbsp;</td>
                <td width="12%" align="right" nowrap><strong>Invoice  No: </strong></td>
                <td width="17%" align="left"><?php echo $v_no;?>&nbsp;</td>
              </tr>
          </table>
		  </td>
        </tr>
        <tr>
          <td valign="top"><table width='100%' border="1" bordercolor="#333333" bgcolor="#FFFFFF" style="border-collapse:collapse">
              <tr align="center">
                <td width="11%"><strong>S/L</strong></td>
                <td width="40%"><strong>Description of the Goods </strong></td>
                <td width="14%"><strong>Qty.</strong></td>
                <td width="18%"><strong>Unit Price </strong></td>
                <td width="17%"><strong>Total Price </strong></td>
              </tr>
<?php
$pi=0;
$total=0;
$sql2="select a.*,b.sub_ledger from sub_ledger b, $vtype a where a.item=b.sub_ledger_id and a.".$i_no."='$v_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ $pi++;
$total=$total+$info->amount;
$paid_amount=$info->paid_amount;
?>
              <tr align="center" class="sect">
                <td><?php echo $pi;?>&nbsp;</td>
                <td><?php echo $info->sub_ledger;?>&nbsp;</td>
                <td><?php echo $info->qty;?>&nbsp;</td>
                <td align="right"><?php echo $info->rate;?>&nbsp;</td>
                <td align="right"><?php echo $info->amount;?>&nbsp;</td>
              </tr>
			   <?php }?>
			  <tr align="center">
                <td colspan="4" align="right"><strong>Total Amount : </strong>&nbsp;</td>
                <td align="right"><?php echo number_format($total,2);?>&nbsp;</td>
              </tr>
               <tr align="center">
                 <td colspan="4" align="right"><strong>Total Paid : </strong>&nbsp;</td>
                 <td align="right"><?php echo number_format($paid_amount,2);?>&nbsp;</td>
               </tr>
			   <? if($total>$paid_amount){?>
			   <tr align="center">
                 <td colspan="4" align="right"><strong>Pay Amount : </strong>&nbsp;</td>
                 <td align="right"><input name="paid_amount" type="text" id="paid_amount" size="15" /></td>
               </tr>
			   <? }?>
          </table></td>
        </tr>
      </table>
<br />
<div align="center" style="margin-top:10px;">
	<span class="vlink"><a href="invoice_print_new.php?<?php echo 'v_type='.$vtype.'&vdate='.$vdate.'&v_no='.$v_no.'&view=Show&in='.$in.'&tid='.$i_in;?>" target="_blank">Print This Invoice</a></span>
    <span class="vlink"><a href="javascript:loadinparent('<?php echo $page;?>', true);">Re-Entry This Invoice</a></span>
<input class="vlink" style="background:#FFC;" name="change" type="submit" value="Change Date" onmouseover="this.style.cursor='pointer';" />
<input class="vlink" style="background:#F55;" name="paid" type="submit" value="Pay Amount" onmouseover="this.style.cursor='pointer';" onclick="return confirm('Are you sure to pay this amount?');" />
<input class="vlink" style="background:#F66;" name="delete" type="submit" value="Delete Invoice" onmouseover="this.style.cursor='pointer';" onclick="return confirm('Are you sure to delete this Invoice?');" />

</div>
<?php
}
?>
<script type="application/javascript">
function loadinparent(url)
{
	self.opener.location = url;
	self.blur(); 
}
</script>
</form>