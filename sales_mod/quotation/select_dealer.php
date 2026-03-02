<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Sales Quotation Create';
$table_master='sale_requisition_master';

$unique_master='do_no';







$table_detail='sale_requisition_details';



$unique_detail='id';







$table_chalan='sale_do_chalan';



$unique_chalan='id';







$$unique_master=$_POST[$unique_master];


$tr_type="Show";






if(isset($_POST['delete']))



{



		$crud   = new crud($table_master);



		$condition=$unique_master."=".$$unique_master;		



		$crud->delete($condition);



		$crud   = new crud($table_detail);



		$crud->delete_all($condition);



		$crud   = new crud($table_chalan);



		$crud->delete_all($condition);



		unset($$unique_master);



		unset($_POST[$unique_master]);



		$type=1;

		$tr_type="Delete";

		$msg='Successfully Deleted.';



}



if(isset($_POST['confirm']))



{



		unset($_POST);



		$_POST[$unique_master]=$$unique_master;



		$_POST['entry_at']=date('Y-m-d H:s:i');



		$_POST['status']='CHECKED';



		



		



		$crud   = new crud($table_master);

		

		$crud->update($unique_master);



		$crud   = new crud($table_detail);



		$crud->update($unique_master);



		unset($$unique_master);



		unset($_POST[$unique_master]);



		$type=1;



		$msg='Successfully Instructed to Depot.';

		
//$_POST[$unique_master]
		$tr_type="Confirmed";
		$tr_no=$_POST['do_no'];

		header("location:../quotation/quotation_status.php");



}





auto_complete_from_db('dealer_info','concat(dealer_name_e)','concat(dealer_code,"##",dealer_name_e)','1','dealer');


?>



<script language="javascript">



window.onload = function() {document.getElementById("dealer").focus();}



</script>

















	<!--1 INPUT TABLE-->

	<div class="form-container_large">

		<form action="quotation_create.php" method="post" name="codz" id="codz">



			<div class="container-fluid bg-form-titel">

				<div class="row">

					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">

						<div class="form-group row m-0">

							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Active Dealer List :</label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

								<input name="dealer" type="text" id="dealer"/>

							</div>

						</div>



					</div>





					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

						<input type="submit" name="submitit" id="submitit" value="Create Quotation" class="btn1 btn1-submit-input"/>

					</div>



				</div>

			</div>



		</form>

	</div>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>