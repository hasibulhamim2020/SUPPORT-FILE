<?php


session_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);

 $payment_method=$data[0];
   


?>

 
					
					<? if ($payment_method=="CASH") { ?>
			
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['dr_ledger_id'],'ledger_group_id in (10201)');?>
									</select>	

  					<? }?>
					
					
					<? if ($payment_method=="BANK" || $payment_method=="CHEQUE") { ?>
			
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['dr_ledger_id'],'ledger_group_id in (10202)');?>
									</select>	

  					<? }?>
					
					
					