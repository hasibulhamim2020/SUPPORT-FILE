<?php
//$master_user = find_a_field('user_activity_management', 'master_user', '1');
?>


<h1 style="background: #3498DB; width: 100%; color: white; text-align:center; font-size:18px; margin:0px; margin-bottom:1px; padding: 10px 0px;">Accounts Module</h1>


<div class="menu_bg">



    <div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Product Management</a></div>

    <ul class="submenu">

      
      
        <li>   <a href="../pages/item_sub_group.php"<?php if($active=='productsub') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Sub Group</a> </li>
       <li>   <a href="../pages/item_info.php"<?php if($active=='item') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Info</a></li>
       <li>   <a href="../pages/unit_management.php"<?php if($active=='unit') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Unit Manage</a></li>
       <li>   <a href="../pages/item_report.php"<?php if($active=='search') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Search</a></li>
      

    </ul>


<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Admin Panel</a></div>

    <ul class="submenu">

        <li>   <a href="../pages/project_info.php"<?php if($active=='projin') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Project Info</a></li>
      
        <li>  <a href="../pages/user_manage.php"<?php if($active=='usmanag') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> User Manage</a></li>
        

    </ul>
    
    
    <div class="silverheader"><a href="../pages/dash_project.php"><i class="fa fa-cubes" aria-hidden="true"></i> Ledger Setup</a></div>

    <ul class="submenu">

        <li>   <a href="../pages/ledger_sub_class.php"<?php if($active=='subclass') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sub Class</a></li>
      
        <li>   <a href="../pages/ledger_group.php"<?php if($active=='lggroup') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Ledger Group</a></li>
        <li>   <a href="../pages/account_ledger.php"<?php if($active=='acledg') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> A/C Ledger</a></li>
        <li>   <a href="../pages/account_sub_ledger.php"<?php if($active=='acsubl') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sub Ledger</a></li>
		
 <li>   <a href="../pages/account_sub_sub_ledger.php"<?php if($active=='subsubl') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sub Sub Ledger</a></li>
 <li>   <a href="../pages/opening_balance.php"<?php if($active=='opbal') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Openning Balance</a></li>
 <li>   <a href="../pages/opening_balance_reset.php"<?php if($active=='opbalres') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Openning Balance Reset</a></li>
  <li>   <a href="../pages/opening_balance_manual.php"<?php if($active=='opbalman') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Openning Balance(Manual)</a></li>



    </ul>


 <div class="silverheader"><a href="../pages/dash_voucher.php"><i class="fa fa-cubes" aria-hidden="true"></i> Voucher</a></div>

    <ul class="submenu">

        <li>   <a href="../pages/credit_note.php"<?php if($active=='recvou') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Receipt Voucher</a></li>
		  <li>   <a href="../pages/debit_note.php"<?php if($active=='dabit') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Payment Voucher</a></li>
		    <li>   <a href="../pages/journal_note_new.php" <?php if($active=='jourvo') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Journal Voucher</a></li>
			  <li>   <a href="../pages/coutra_note_new.php" <?php if($active=='contravou') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Contra Voucher</a></li>
			    <li>   <a href="../pages/voucher_view.php"<?php if($active=='vouview') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Voucher View</a></li>
				  <li>   <a href="../pages/unchecked_voucher_view.php" <?php if($active=='unvou') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Unchecked Voucher View</a></li>
      
       
    </ul>
    
	
	
	
	
    <div class="silverheader"><a href="../pages/dash_inventory.php"><i class="fa fa-cubes" aria-hidden="true"></i> Inventory Setup</a></div>

    <ul class="submenu">

        <li>   <a href="../pages/cost_category.php" <?php if($active=='unvou') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Cost Category</a></li>
		      <li>   <a href="../pages/cost_center.php"<?php if($active=='unvou') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Cost Center</a></li>
			        <li>   <a href="../pages/inventory_warehouse.php"<?php if($active=='unvou') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>   Warehouse Info</a></li>
					     
       
    </ul>
	
	
    
    
    <div class="silverheader"><a href="../pages/dash_report.php"><i class="fa fa-cubes" aria-hidden="true"></i> Report</a></div>

    <ul class="submenu">

        <li>  <a href="../pages/tree_report.php" <?php if($active=='treere') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Chart of Accounts</a></li>
        <li>  <a href="../pages/ledger_account1_report.php"<?php if($active=='legna') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Ledger Group Name</a></li>
      <li>  <a href="../pages/transaction_listledger.php"<?php if($active=='transstle') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Transaction Statement (Ledger)</a></li>
      <li> <a href="../pages/sale_proceeds_received_and_deposited.php" <?php if($active=='saleproceeds') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sale Proceeds Received and Deposited Report</a></li>
	   <li> <a href="../pages/receipt&amp;paymant.php"<?php if($active=='recpay') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Receipt &amp; Payment Statement(Ledger)</a></li>
	    <li> <a href="../pages/receipt&amp;paymant_ledger.php"<?php if($active=='recpaymst') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Receipt &amp; Payment Statement</a></li>
      
       
    </ul>
    
	
	
     <div class="silverheader"><a href="../pages/dash_report.php"><i class="fa fa-cubes" aria-hidden="true"></i> Advanced Report</a></div>

    <ul class="submenu">

       
		   <li>  <a href="../pages/cash_book.php"<?php if($active=='cashbo') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Cash Book</a></li>
		      <li>  <a href="../pages/bank_book.php" <?php if($active=='bankbo') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Bank Book</a></li>
			     <li>  <a href="../pages/trial_balance_detail_new.php"<?php if($active=='transdetrep') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Transection Detail Report</a></li>
				 <li>  <a href="../pages/consolidated_trial_balance.php"<?php if($active=='consolidtrailbal') {  ?> style="color:white;"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i> Consolidated Trial Balance</a></li>
				 
      
       
    </ul>



 






    <div class="silverheader"><a href="#" ><i class="fas fa-sign-in-alt"></i> Exit Program</a></div>

    <ul class="submenu">
        <li>
            <a href="../pages/logout.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Log Out</a>
        </li>
    </ul>

</div>


<div class="copyright">
    <p class="copy_text"><b>ERP COM BD</b></p>
</div>





