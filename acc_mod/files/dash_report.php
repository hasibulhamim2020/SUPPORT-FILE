<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Report Dashboard';
$proj_id=$_SESSION['proj_id'];
$now=time();
?>
<link rel="stylesheet" type="text/css" href="../css/dash_board.css"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>    <div class="dashboard">
		    <!-- Dashboard icons -->
            <div class="grid_7">
            	<a href="../pages/tree_report.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Chart of Accounts</span></a>
                
                <a href="../pages/ledger_account1_report.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Ledger Group Name</span></a>
                
                <a href="../pages/transaction_list.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Journal Book (Detail)</span></a>
                
                <a href="../pages/transaction_listgroup.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Journal Book (Group)</span></a>
                
                <a href="../pages/transaction_listledger.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Transaction Statement (Ledger)</span></a>
                
                <a href="../pages/transaction_listsubledger.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span> Transaction Statement (Concise)</span></a>
                
                <a href="../pages/receipt_statement.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Receipt Statement</span></a>
				
				<a href="../pages/payment_statement.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Payment Statement</span></a>

				<a href="../pages/contra_statement.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Contra Statement</span></a>
				
				<a href="../pages/purchase_statement.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Purchase Statement</span></a>
				
				<a href="../pages/purchase_invoice_report.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Purchase Statement(2)</span></a>
				
				<a href="../pages/sales_statement.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Sales Statement</span></a>
				
				<a href="../pages/sales_invoice_report.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Sales Statement(2)</span></a>
                
                <a href="../pages/item_balance.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Stock Ledger</span></a>
				
				<a href="../pages/income&amp;expenditure.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Inome Statement</span></a>

				<a href="../pages/receipt&amp;paymant.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Receipt & Payment Statement</span></a>  
				
				<a href="../pages/trial_balance.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Trial Balance</span></a>
				
				<a href="../pages/trial_balance_periodical.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Trial Balance Periodical (Detail)</span></a>
				
				<a href="../pages/trial_balance_summary.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Trial Balance(At a Glance)</span></a>
				
				<a href="../pages/ledger_statement.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Ledger Book</span></a>
				
				<a href="../pages/ledger_summary.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Account Ledger (Summary)</span></a>
				
				<a href="../pages/cash_book.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Cash Book</span></a>
				
				<a href="../pages/bank_book.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Bank Book</span></a>
				
				<a href="../pages/balance_sheet.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Balance Sheet</span></a>
				
				<a href="../pages/budget_statement.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Financial Performance Report</span></a>
				
				<a href="../pages/balance_sheet_yearly_new.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Balance Sheet (Concise)</span></a>
				
				<a href="../pages/yearlyincome&amp;expenditure.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Income &amp; Expenditure (Concise)</span></a>
				
				<a href="../pages/yearlyreceipt&amp;paymant.php" class="dashboard-module"><img src="../dash_images/2.gif" width="40" height="40" /><span>Receipt &amp; Payment (Concise)</span></a>
				<div style="clear: both"></div>
</div> <!-- End .grid_7 -->
		</div>
		</td></tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>
