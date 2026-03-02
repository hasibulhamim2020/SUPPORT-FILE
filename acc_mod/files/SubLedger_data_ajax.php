<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




$group_for = $_POST['group_for'];











echo 	'<input list="sub_ledgers" name="sub_ledger" id="sub_ledger" value="'.$sub_ledger .'"
								autocomplete="off" class="form-control"/>';
echo							'<datalist id="sub_ledgers">
								<option></option>';
			  foreign_relation('general_sub_ledger', 'sub_ledger_id', 'sub_ledger_name', $sub_ledger, " group_for=".$group_for."");
						echo 	'</datalist>';










 ?>