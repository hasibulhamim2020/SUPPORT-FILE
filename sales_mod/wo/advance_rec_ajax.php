<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

   $str = $_POST['data'];


$data=explode('##',$str);
 

   $customer=$data[0];
   
   $dealer=explode('->',$customer);
   
   $dealer_code=$dealer[0];
   
   $dealer_all = find_all_field('dealer_info','',"dealer_code=".$dealer_code);
 if($dealer_all->bank_reconsila=="YES"){
?>

  
<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive Ledger</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
							 
									<select name="rec_ledger" id="rec_ledger">
										<option value=""></option>
									<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$rec_ledger,'1 and ledger_group_id in(127001,127002)');?>
									</select>

								</div>
							</div>
							 
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Advance Receipt</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input  name="received_amt" type="text" id="received_amt" value="<?=$received_amt;?>" />

								</div>
							</div>
 

 <?php } ?>
		 
