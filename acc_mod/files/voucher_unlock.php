<?php
session_start();
ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Account Ledger';
 if(isset($_POST['unlock'])){
 	/////////secondary Journal Delete/////
		
		$sec_delete='delete from secondary_journal where jv_no=0';
		db_query($sec_delete);
	///////Journal Delete//////
	$jour_delete='delete from journal where jv_no=0';
	db_query($jour_delete);
 }
 
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

   <form id="form1" name="form1" method="post" action="">
           <duv class="container">
		   		<div class="col-md-12 text-center">
					<input type="submit" class="btn btn-success" name="unlock" id="unlock" value="Unlock Voucher Page" />
				</div>
		   </div>    
	      </form>

 
 




<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>