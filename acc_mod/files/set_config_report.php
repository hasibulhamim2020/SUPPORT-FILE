<?php
session_start();
ob_start();
require_once "../../support/inc.report.php";
$title='Set Report Configuration';

		$proj_id				= mysqli_real_escape_string($_SESSION['proj_id']);
		//common part.............
		$transaction_list		= mysqli_real_escape_string($_REQUEST['transaction_list']);
		$receipt_statement		= mysqli_real_escape_string($_REQUEST['receipt_statement']);
		$payment_statement		= mysqli_real_escape_string($_REQUEST['payment_statement']);
		$contra_statement		= mysqli_real_escape_string($_REQUEST['contra_statement']);
		$purchase_statement		= mysqli_real_escape_string($_REQUEST['purchase_statement']);
		$sales_statement		= mysqli_real_escape_string($_REQUEST['sales_statement']);
		$purchase_invoice_report= mysqli_real_escape_string($_REQUEST['purchase_invoice_report']);
		$invoice_report			= mysqli_real_escape_string($_REQUEST['invoice_report']);
		$receiptpaymant			= mysqli_real_escape_string($_REQUEST['receiptpaymant']);
		$incomeexpenditure		= mysqli_real_escape_string($_REQUEST['incomeexpenditure']);
		$trial_balance			= mysqli_real_escape_string($_REQUEST['trial_balance']);
		$book_statement			= mysqli_real_escape_string($_REQUEST['book_statement']);
		$balance_sheet			= mysqli_real_escape_string($_REQUEST['balance_sheet']);
		$budget_statement		= mysqli_real_escape_string($_REQUEST['budget_statement']);
		$yearly_report			= mysqli_real_escape_string($_REQUEST['yearly_report']);
	//for Modify..................................
	if(isset($_REQUEST['Submit']))
	{
	
		$sql="UPDATE `config_report` SET 
			 `transaction_list` = '$transaction_list',
			 `receipt_statement` = '$receipt_statement',
			 `payment_statement` = '$payment_statement',
			 `contra_statement` = '$contra_statement',
			 `purchase_statement` = '$purchase_statement',
			 `sales_statement` = '$sales_statement',
			 `purchase_invoice_report` = '$purchase_invoice_report',
			 `invoice_report` = '$invoice_report',
			 `receipt&paymant` = '$receiptpaymant',
			 `income&expenditure` = '$incomeexpenditure',
			 `book_statement` = '$book_statement',
			 `balance_sheet` = '$balance_sheet',
			 `budget_statement` = '$budget_statement',
			 `trial_balance` = '$trial_balance'
			 WHERE `proj_id` = '$proj_id' LIMIT 1";
		$qry=db_query($sql);
		$type=1;
		$msg='Successfully Updated.';
	}
$data=mysqli_fetch_row(db_query("select * from config_report where 1"));

?>
<link rel="stylesheet" type="text/css" href="../css/dash_board.css"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>    <div class="dashboard">
		    <!-- Dashboard icons -->
            <div class="grid_7">
			    <form>
            	<a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="transaction_list" value="YES" <? if($data[1]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
				
				<span>Transaction List</span></a> 
				
				<a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="receipt_statement" value="YES" <? if($data[2]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
                <span>Receipt Statement</span></a>
                
                <a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="payment_statement" value="YES" <? if($data[3]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
				
                <span>Payment Statement</span></a>
                
                <a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="contra_statement" value="YES" <? if($data[4]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
                <span>Contra Statement</span></a>
                
                <a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="purchase_statement" value="YES" <? if($data[5]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
                <span>Purchase Statement</span></a>
                
                <a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="sales_statement" value="YES" <? if($data[6]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
                <span>Sales Statement</span></a>
                
                <a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="purchase_invoice_report" value="YES" <? if($data[7]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
                <span>Purchase Invoice Report</span></a>
				
				<a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="invoice_report" value="YES" <? if($data[8]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
				<span>Invoice Report</span></a>

				<a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="receipt&paymant" value="YES" <? if($data[9]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
				<span>Receipt & Payment</span></a>
				
				<a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="income&expenditure" value="YES" <? if($data[10]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
				<span>Income & Expenditure</span></a>
				
				<a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="trial_balance" value="YES" <? if($data[11]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
				<span>Trial Balance</span></a>
				
				<a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="book_statement" value="YES" <? if($data[12]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
				<span>Book Statement</span></a>
				
				<a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="balance_sheet" value="YES" <? if($data[13]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
				<span>Balance Sheet</span></a>
                
                <a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top"><input type="checkbox" name="budget_statement" value="YES" <? if($data[14]=='YES') echo 'checked';?>/></td>
				  </tr>
				</table>
                <span>Budget Statement</span></a>
				<a href="#" class="dashboard-module">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td width="71%"><div align="right"><img src="../dash_images/1.gif" width="40" height="40" /></div></td>
					<td width="29%" valign="top">
					<input type="checkbox" name="yearly_report" value="YES" <? if($data[15]=='YES') echo 'checked';?>/>
					</td>
				  </tr>
				</table>
				<span>Yearly Report</span></a>
				
				<div style="clear: both">
				  <div align="center">
				    <input type="submit" name="Submit" value="Apply" />
				  </div>
				</div>
				</form>
</div> <!-- End .grid_7 -->
		</div>		</td></tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>