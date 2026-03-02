<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Voucher Dashboard';
$proj_id=$_SESSION['proj_id'];
$now=time();
?>
<link rel="stylesheet" type="text/css" href="../css/dash_board_pe.css"/>
<link rel="stylesheet" type="text/css" href="../css/table_dashboard.css"/>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<div class="dashboard_left"><br />
				<table style="width:40%" border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td width="38%"><a href="../pages/account_ledger.php" class="dashboard-module"><img src="../dash_images/dash8.gif" width="23" height="23" /><span>Ledger
Account 
</span></a></td>
						<td width="25%">&nbsp;</td>
						<td width="37%"><a href="../pages/account_sub_ledger.php" class="dashboard-module"><img src="../dash_images/dash9.gif" width="23" height="23" /><span>Sub Ledger </span></a></td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="3">
						  <div class="bar"></div></td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td><a href="../pages/credit_note.php" class="dashboard-module"><img src="../dash_images/dash10.gif" width="23" height="23" /><span>Credit Voucher</span></a></td>
						<td>&nbsp;</td>
						<td><a href="../pages/debit_note.php" class="dashboard-module"><img src="../dash_images/dash11.gif" width="23" height="23" /><span>Debit Voucher </span></a></td>
					  </tr>
					  <tr>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					  </tr>
					  <tr>
					    <td><a href="../pages/journal_note_new.php" class="dashboard-module"><img src="../dash_images/dash12.gif" width="23" height="23" /><span>Journal Voucher </span></a></td>
					    <td>&nbsp;</td>
					    <td><a href="../pages/coutra_note_new.php" class="dashboard-module"><img src="../dash_images/dash13.gif" width="23" height="23" /><span>Contra Voucher</span></a></td>
			      </tr>
					  <tr>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
			      </tr>
					   <tr>
						<td colspan="3">
						  <div class="bar"></div></td>
					  </tr>
					   <tr>
					     <td><div class="bar2"></div></td>
					     <td>&nbsp;</td>
					     <td><div class="bar2"></div></td>
			      </tr>
					   <tr>
					     <td><a href="../pages/voucher_view.php" class="dashboard-module"><img src="../dash_images/dash14.gif" width="23" height="23" /><span>View Voucher</span></a></td>
					     <td>&nbsp;</td>
					     <td><a href="../pages/transaction_listledger.php" class="dashboard-module"><img src="../dash_images/dash15.gif" width="23" height="23" /><span>Transaction List</span></a></td>
			      </tr>
					   <tr>
					     <td>&nbsp;</td>
					     <td>&nbsp;</td>
					     <td>&nbsp;</td>
			      </tr>
				      <tr>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
			      </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
		</table>
</div>
		  </td>
    <td><div class="dashboard_right">
      <h1>Recent Credit Voucher</h1>
      <div class="dashboard_box1">
        <table class="table_dashboard" cellspacing="0">
          <tr>
            <th>Voucher No</th>
            <th>Date</th>
            <th>Narration</th>
            <th>Amount</th>
          </tr>
<?
$sql="select receipt_no, dr_amt, narration,receipt_date from  receipt  where dr_amt>0 order by receipt_no desc limit 7";
$query=db_query($sql);
$i=0;
while($data=mysqli_fetch_row($query))
{
$i++;
$voucher_no[]=$data[0];
$date[]=$data[3];
$from[]=$data[2];
$amount[]=$data[1];
}
for($j=0;$j<8;$j++)
{
if($j%2==0) $class='class="alt"'; else $class='';
?>
							<tr <?=$class?>>
								<td><?=$voucher_no[$j]?></td>
								<td><? if($date[$j]!='') echo date("d-m-Y",$date[$j])?></td>
								<td><?=$from[$j]?></td>
								<td><?=$amount[$j]?></td>
		    				</tr>
<? }?>

        </table>
      </div>
      <h1>Recent Debit Voucher</h1>
      <div class="dashboard_box1">
        <table class="table_dashboard" cellspacing="0">
          <tr>
            <th>Voucher No</th>
            <th>Date</th>
            <th>Narration</th>
            <th>Amount</th>
          </tr>
<?
unset($voucher_no);
unset($date);
unset($from);
unset($amount);

$sql="select payment_no, cr_amt, narration,payment_date from  payment  where cr_amt>0 order by payment_no desc limit 7";
$query=db_query($sql);
$i=0;
while($data=mysqli_fetch_row($query))
{
$i++;
$voucher_no[]=$data[0];
$date[]=$data[3];
$from[]=$data[2];
$amount[]=$data[1];
}
for($j=0;$j<8;$j++)
{
if($j%2==0) $class='class="alt"'; else $class='';
?>
							<tr <?=$class?>>
								<td><?=$voucher_no[$j]?></td>
								<td><? if($date[$j]!='') echo date("d-m-Y",$date[$j])?></td>
								<td><?=$from[$j]?></td>
								<td><?=$amount[$j]?></td>
		    				</tr>
<? }?>

        </table>
      </div>
      <h1>Journal / Contra</h1>
      <div class="dashboard_box1">
        <table class="table_dashboard" cellspacing="0">
          <tr>
            <th>Voucher No</th>
            <th>Date</th>
            <th>Narration</th>
            <th>Amount</th>
          </tr>
<?
unset($voucher_no);
unset($date);
unset($from);
unset($amount);
$sql="select coutra_no, sum(cr_amt), narration,coutra_date from  coutra  group by coutra_no order by coutra_no desc limit 7";
$query=db_query($sql);
$i=0;
while($data=mysqli_fetch_row($query))
{
$i++;
$voucher_no[]=$data[0];
$date[]=$data[3];
$from[]=$data[2];
$amount[]=$data[1];
}
for($j=0;$j<8;$j++)
{
if($j%2==0) $class='class="alt"'; else $class='';
?>
							<tr <?=$class?>>
								<td><?=$voucher_no[$j]?></td>
								<td>&nbsp;<? if($date[$j]!='') echo date("d-m-Y",$date[$j])?></td>
								<td><?=$from[$j]?></td>
								<td><?=$amount[$j]?></td>
		    				</tr>
<? }?>

        </table>
      </div>
    </div></td>
  </tr>
</table>

		  
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>
