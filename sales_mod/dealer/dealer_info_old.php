<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";

$tr_type = "Show";

// ::::: Edit This Section ::::: 



$title = 'Customer Information Add';			// Page Name and Page Title

do_datatable('vendor_table');

$page = "dealer_info.php";		// PHP File Name



$table = 'dealer_info';		// Database Table Name Mainly related to this page

$unique = 'dealer_code';			// Primary Key of this Database table

$shown = 'dealer_name_e';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

$tr_type = "show";

$user_group_define = find_a_field('company_define ', 'GROUP_CONCAT(company_id ORDER BY company_id ASC)', 'user_id="' . $_SESSION['user']['id'] . '" and status="Active"');
//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
function createSubLedger($code, $name, $tr_from, $tr_id, $ledger_id, $type, $group_for)
{

	$insert = 'insert into general_sub_ledger set sub_ledger_id="' . $code . '",sub_ledger_name="' . $name . '",tr_from="' . $tr_from . '",tr_id="' . $tr_id . '",ledger_id="' . $ledger_id . '",type="' . $type . '",entry_at="' . date('Y-m-d H:i:s') . '",entry_by="' . $_SESSION['user']['id'] . '",group_for="' . $group_for . '"';
	db_query($insert);
	return db_insert_id();

}
/*

function createSubLedger($code,$name,$tr_from,$tr_id,$ledger_id,$type){

$insert = 'insert into general_sub_ledger set sub_ledger_id="'.$code.'",sub_ledger_name="'.$name.'",tr_from="'.$tr_from.'",tr_id="'.$tr_id.'",ledger_id="'.$ledger_id.'",type="'.$type.'",entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$_SESSION['user']['id'].'",group_for="'.$_SESSION['user']['group'].'"';
db_query($insert);
return db_insert_id();

}*/


$crud = new crud($table);

$$unique = $_GET[$unique];

if (isset($_POST[$shown])) {

	$$unique = $_POST[$unique];



	//for Insert..................................

	if (isset($_POST['insert']) && $_SESSION['csrf_token'] === $_POST['csrf_token']) {

		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));


		//if ($_POST['dealer_found']==0) {}

		$proj_id = $_SESSION['proj_id'];

		$expire_date = $_POST['expire_date'];

		$_POST['entry_by'] = $_SESSION['user']['id'];

		$_POST['entry_at'] = date('Y-m-d h:i:s');


		/*tin*/


		$folder = 'customer';
		$field = 'tin';
		$file_name = $field . '-' . $_POST['dealer_code'];
		if ($_FILES['tin']['tmp_name'] != '') {
			$_POST['tin'] = upload_file($folder, $field, $file_name);
			$tr_type = "Add";
		}



		//////////trade////////////////


		//$_POST['pic']=image_upload($path,$_FILES['pic']);




		$field = 'trade';
		$file_name = $field . '-' . $_POST['dealer_code'];
		if ($_FILES['trade']['tmp_name'] != '') {
			$_POST['trade'] = upload_file($folder, $field, $file_name);
			$tr_type = "Add";
		}



		//////////BIN////////////////



		$field = 'bin';
		$file_name = $field . '-' . $_POST['dealer_code'];
		if ($_FILES['bin']['tmp_name'] != '') {
			$_POST['bin'] = upload_file($folder, $field, $file_name);
			$tr_type = "Add";
		}


		//////////cheque////////////////



		$field = 'cheque';
		$file_name = $field . '-' . $_POST['dealer_code'];
		if ($_FILES['cheque']['tmp_name'] != '') {
			$_POST['cheque'] = upload_file($folder, $field, $file_name);
			$tr_type = "Add";
		}



		//$wh_data = find_all_field('warehouse','','warehouse_id='.$_POST['depot']); 



		//$_POST['ledger_group_id']=$_POST['ledger_group'];



		$custome_codes = find_a_field('dealer_info', 'max(sub_ledger_id)', '1');
		if ($custome_codes > 0) {
			$custome_code = $custome_codes + 1;
		} else {
			$custome_code = 10000001;
		}
		$_POST['account_code'] = $_POST['ledger_id'];
		$_POST['sub_ledger_id'] = $custome_code;
		$_POST['ledger_name'] = $_POST['dealer_name_e'];

		$tr_type = "Add";
		$ledger_gl_found = find_a_field('general_sub_ledger', 'sub_ledger_id', 'sub_ledger_name=' . $_POST['ledger_name']);

		if ($ledger_gl_found == 0) {
			createSubLedger($custome_code, $_POST['dealer_name_e'], 'dealer', $_POST[$unique], $_POST['account_code'], $_POST['dealer_type'], $_POST['group_for']);
		}

		$crud->insert();

		$type = 1;

		$msg = 'New Entry Successfully Inserted.';

		unset($_POST);

		unset($$unique);
		header("Location: dealer_info.php");
	}



	//for Modify..................................



	if (isset($_POST['update'])) {

		$folder = 'customer';
		$field = 'tin';
		$file_name = $field . '-' . $_POST['dealer_code'];
		if ($_FILES['tin']['tmp_name'] != '') {
			$_POST['tin'] = upload_file($folder, $field, $file_name);
			$tr_type = "Add";
		}


		$expire_date = $_POST['expire_date'];

		$field = 'trade';
		$file_name = $field . '-' . $_POST['dealer_code'];

		if ($_FILES['trade']['tmp_name'] != '') {
			$_POST['trade'] = upload_file($folder, $field, $file_name);
		}

		$field = 'bin';
		$file_name = $field . '-' . $_POST['dealer_code'];


		if ($_FILES['bin']['tmp_name'] != '') {

			$_POST['bin'] = upload_file($folder, $field, $file_name);


		}
		$field = 'cheque';
		$file_name = $field . '-' . $_POST['dealer_code'];

		if ($_FILES['cheque']['tmp_name'] != '') {

			$_POST['cheque'] = upload_file($folder, $field, $file_name);


		}
		$_POST['edit_at'] = date('Y-m-d H:i:s');
		$_POST['edit_by'] = $_SESSION['user']['id'];


		$crud->update($unique);



		$dealer_code = $_POST['dealer_code'];

		$account_code = $_POST['account_code'];
		$sub_ledger_id = $_POST['sub_ledger_id'];


		$sql1 = 'update  general_sub_ledger set sub_ledger_name="' . $_POST['dealer_name_e'] . '",group_for="' . $_POST['group_for'] . '" ,edit_at="' . $_POST['edit_at'] . '",
	  edit_by="' . $_POST['edit_by'] . '" 

	  where sub_ledger_id  = ' . $sub_ledger_id;



		db_query($sql1);



		$type = 1;

		$msg = 'Successfully Updated.';



		$tr_type = "Add";

	}

	//for Delete..................................



	if (isset($_POST['delete'])) {

		$condition = $unique . "=" . $$unique;

		$crud->delete($condition);

		unset($$unique);

		$type = 1;

		$msg = 'Successfully Deleted.';

	}



}



if (isset($$unique)) {

	$condition = $unique . "=" . $$unique;

	$data = db_fetch_object($table, $condition);

	foreach ($data as $key => $value) {
		$$key = $value;
	}



}

if (!isset($$unique))
	$$unique = db_last_insert_id($table, $unique);





?>



<script type="text/javascript">







	$(function () {







		$("#fdate").datepicker({







			changeMonth: true,







			changeYear: true,







			dateFormat: 'yy-mm-dd'







		});







	});







	function Do_Nav() {







		var URL = 'pop_ledger_selecting_list.php';







		popUp(URL);







	}















	function DoNav(theUrl) {







		document.location.href = '<?= $page ?>?<?= $unique ?>=' + theUrl;







	}







	function popUp(URL) {







		day = new Date();







		id = day.getTime();







		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");







	}







</script>







<style type="text/css">
	.style1 {
		color: #FF0000
	}



	.style2 {



		font-weight: bold;



		color: #000000;



		font-size: 14px;



	}



	.style3 {
		color: #FFFFFF
	}
</style>























<!--dealer info-->



<div class="form-container_large">







	<h4 class="text-center bg-titel bold pt-2 pb-2 text-uppercase"> <?= $title ?> </h4>







	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">







		<div class="container-fluid bg-form-titel">







			<div class="row">



				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



					<div class="form-group row m-0">



						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Customer
							Name:</label>



						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">







							<input name="<?= $unique ?>" id="<?= $unique ?>" value="<?= $$unique ?>" type="hidden" />



							<input name="csrf_token" type="hidden" id="csrf_token"
								value="<?= $_SESSION['csrf_token'] ?>" />







							<input name="group_for" required type="hidden" id="group_for" tabindex="1"
								value="<?= $_SESSION['user']['group']; ?>">







							<input name="dealer_name_e" required type="text" id="dealer_name_e" tabindex="1"
								value="<?= $dealer_name_e ?>">















						</div>



					</div>







				</div>







				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



					<div class="form-group row m-0">



						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Propritor
							Name:</label>



						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



							<input name="propritor_name_e" type="text" id="propritor_name_e" tabindex="2"
								value="<?= $propritor_name_e ?>" />



						</div>



					</div>



				</div>







				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



					<div class="form-group row m-0">



						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Customer
							Type :</label>



						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



							<select name="dealer_type" required id="dealer_type" tabindex="3">



								<option></option>
								<?
								//and d.group_for="'.$_SESSION['user']['group'].'"
								foreign_relation('dealer_type d', 'd.id', 'd.dealer_type', $dealer_type, 'd.status="ACTIVE" ');

								?>



							</select>







						</div>



					</div>



				</div>







				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



					<div class="form-group row m-0">



						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Mobile:</label>



						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



							<input name="contact_no" type="text" id="contact_no" tabindex="4"
								value="<?= $contact_no ?>" />



						</div>



					</div>



				</div>







				<!--<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SMS Phone:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="sms_mobile_no" type="text" id="sms_mobile_no" tabindex="5" value="<?= $sms_mobile_no ?>" />



							</div>



						</div>



					</div>-->











				<!--<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Fax No:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="fax_no" type="text" id="fax_no" tabindex="6" value="<?= $fax_no ?>" />



							</div>



						</div>



					</div>-->







				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



					<div class="form-group row m-0">



						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Email:</label>



						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



							<input name="email" type="text" id="email" tabindex="7" value="<?= $email ?>" />



						</div>



					</div>



				</div>





				<?php
				$proj_all = find_all_field('project_info', '*', '1');
				$gr_all = find_all_field('config_group_class', '*', 'group_for=' . $_SESSION['user']['group']);

				$dealer_ledg_group_id = $gr_all->receivable;

				?>

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



					<div class="form-group row m-0">



						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">A/C
							Configuration:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

							<? if ($account_code == 0) { ?>
								<select name="ledger_id" required="required" id="ledger_id"
									style="width:95%; font-size:12px;" tabindex="9">
									<option></option>
									<? // and group_for="'.$_SESSION['user']['group'].'"
										foreign_relation('accounts_ledger', 'ledger_id', 'ledger_name', $ledger_id, 'ledger_group_id="' . $dealer_ledg_group_id . '"');
										?>
								</select>

							<? } ?>
							<? if ($account_code > 0) { ?>
								<input name="account_code" type="text" id="account_code" tabindex="9"
									value="<?= $account_code ?>" style="width:95%; font-size:12px;" />
								<input name="sub_ledger_id" type="hidden" id="sub_ledger_id" tabindex="9"
									value="<?= $sub_ledger_id ?>" style="width:95%; font-size:12px;" />

							<? } ?>
						</div>

					</div>

				</div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-start align-items-center pr-1 bg-form-titel-text">Region:</label>

						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

							<select name="region_code" id="region_code" tabindex="9"
								onchange="getData2('dealer_zone_ajax.php', 'dealer_zone_find', this.value,  document.getElementById('region_code').value);">
								<option></option>
								<? foreign_relation('branch', 'BRANCH_ID', 'BRANCH_NAME', $region_code, '1'); ?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-start align-items-center pr-1 bg-form-titel-text">Zone:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<span id="dealer_zone_find">
								<select name="zone_code" id="zone_code" tabindex="9"
									onchange="getData2('dealer_area_ajax.php', 'dealer_area_find', this.value,  document.getElementById('zone_code').value);">
									<option></option>
									<? foreign_relation('zon', 'ZONE_CODE', 'ZONE_NAME', $zone_code, 'REGION_ID="' . $region_code . '"'); ?>
								</select>
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-start align-items-center pr-1 bg-form-titel-text">Area:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<span id="dealer_area_find">
								<select name="area_code" id="area_code" tabindex="9">
									<option></option>
									<? foreign_relation('area', 'AREA_CODE', 'AREA_NAME', $area_code, 'ZONE_ID="' . $zone_code . '"'); ?>
								</select>
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Address:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<input name="address_e" type="text" id="address_e" tabindex="14"
								value="<?= $address_e ?>" />
						</div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Credit
							Limit Applicable</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<select name="credit_limit_appli" id="credit_limit_appli">
								<? if ($credit_limit_appli != '') { ?>
									<option value="<?= $credit_limit_appli ?>"><?= $credit_limit_appli ?></option>
									<option value="YES">YES</option>
									<option value="NO">NO</option>
								<? } else { ?>
									<option value="NO">NO</option>
									<option value="YES">YES</option>
								<? } ?>
							</select>
						</div>
					</div>

				</div>

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Credit
							Limit:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<input name="credit_limit" type="text" id="credit_limit" tabindex="14"
								value="<?= $credit_limit ?>" />
						</div>
					</div>

				</div>





				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Acc
							Verification </label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<select name="bank_reconsila" id="bank_reconsila">
								<? if ($bank_reconsila != '') { ?>
									<option value="<?= $bank_reconsila ?>"><?= $bank_reconsila ?></option>
									<option value="YES">YES</option>
									<option value="NO">NO</option>
								<? } else { ?>
									<option value="NO">NO</option>
									<option value="YES">YES</option>
								<? } ?>
							</select>
						</div>
					</div>

				</div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Depot:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

							<select name="depot" required="required" id="depot" tabindex="9">
								<option></option>
								<? foreign_relation('warehouse', 'warehouse_id', 'warehouse_name', $depot, '1 and group_for="' . $_SESSION['user']['group'] . '" and use_type="WH"'); ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact
							Person:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<input name="contact_person_name" type="text" id="contact_person_name" tabindex="16"
								value="<?= $contact_person_name ?>" />
						</div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

					<div class="form-group row m-0">

						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Job
							Title:</label>

						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

							<input name="contact_person_designation" type="text" id="contact_person_designation"
								tabindex="17" value="<?= $contact_person_designation ?>" />

						</div>

					</div>



				</div>







				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact
							Person Phone: </label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<input name="contact_person_mobile" type="text" id="contact_person_mobile" tabindex="18"
								value="<?= $contact_person_mobile ?>" />
						</div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Status:
						</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<select name="status" id="status" required="required">
								<? if ($status != '') { ?>
									<option value="<?= $status ?>"><?= $status ?></option>
									<option value="ACTIVE">ACTIVE</option>
									<option value="INACTIVE">INACTIVE</option>
								<? } else { ?>
									<option value="ACTIVE">ACTIVE</option>
									<option value="INACTIVE">INACTIVE</option>
								<? } ?>
							</select>
						</div>
					</div>



				</div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">User
							Name: </label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<input name="dealer_code2" type="text" id="dealer_code2" tabindex="18"
								value="<?= $dealer_code2 ?>" />
						</div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Password:
						</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<input name="password" type="text" id="password" tabindex="18" value="<?= $password ?>" />
						</div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Company
							:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<select id="group_for" name="group_for" class="form-control" required>
								<? user_company_access($group_for); ?>
							</select>
						</div>
					</div>





					<?php /*?>					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

<div class="form-group row m-0">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">User Account: </label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

<select name="user_account" type="text" id="user_account" tabindex="18" >

<option> </option>

<? foreign_relation('user_activity_management','user_id','fname',$user_account,'1') ?>

</select>



</div>

</div>

</div><?php */ ?>



				</div>

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
					<div class="form-group row m-0">
						<label
							class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Expire
							Date: </label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<input name="expire_date" type="date" id="expire_date" tabindex="18"
								value="<?= $expire_date ?>" />
						</div>
					</div>
				</div>







				<div class="form-container_large">

					<h4 class="text-center bg-titel bold pt-2 pb-2">
						CUSTOMER FILE UPLOAD
					</h4>


					<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"
						onsubmit="return check()">



						<!--4 input table  for-->
						<div class="container-fluid bg-form-titel">
							<div class="row">
								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
									<div class="form-group row m-0">
										<label
											class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">TIN
											Certificate :</label>
										<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
											<input type="file" name="tin" id="tin" class="pt-1 pb-1 pl-1" />
										</div>
									</div>

								</div>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
									<div class="form-group row m-0">
										<label
											class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Trade
											License :</label>
										<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

											<input type="file" name="trade" id="trade" class="pt-1 pb-1 pl-1" />

										</div>
									</div>
								</div>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
									<div class="form-group row m-0">
										<label
											class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">BIN
											Certificate :</label>
										<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
											<input name="bin" type="file" id="bin" class="pt-1 pb-1 pl-1" />

										</div>
									</div>
								</div>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
									<div class="form-group row m-0">
										<label
											class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Blank
											Cheque :</label>
										<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
											<input name="cheque" type="file" id="cheque" class="pt-1 pb-1 pl-1" />


										</div>
									</div>
								</div>

							</div>
						</div>

						<br>


						<div class="container-fluid n-form1">
							<div class="row">

								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
									<label class="container bg-form-titel-text">TIN Certificate:</label>
									<div class="container vendor_info_img">

										<?php /*?>	<?php
$imageUrl = SERVER_CORE . "core/upload_view.php?name=$tin&folder=customer&proj_id=" . $_SESSION['proj_id'];
$defaultImage = SERVER_CORE . "core/default.png";
?>




<a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=customer_tin&&name=<?=$tin;?>" target="_blank">
<img src="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=customer_tin&&name=<?=$tin;?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" />
</a>
<?php */ ?>




										<a href="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $tin ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>&v=<?= time() ?>"
											target="_blank">
											<img
												src="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $tin ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>&v=<?= time() ?>" />
										</a>




										</a>
									</div>
								</div>



								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
									<label class="container bg-form-titel-text">Trade License:</label>
									<div class="container vendor_info_img">

										<?php /*?><?php
$imageUrl = SERVER_CORE . "core/upload_view.php?name=$trade&folder=customer&proj_id=" . $_SESSION['proj_id'];
$defaultImage = SERVER_CORE . "core/default.png";
?>


<a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=customer_trade&&name=<?=$trade;?>" target="_blank">
<img src="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=customer_trade&&name=<?=$trade;?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" />
</a><?php */ ?>



										<a href="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $trade ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>&v=<?= time() ?>"
											target="_blank"><img
												src="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $trade ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>&v=<?= time() ?>" /></a>
									</div>
								</div>


								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
									<label class="container bg-form-titel-text">BIN Certificate:</label>
									<div class="container vendor_info_img">

										<?php /*?><?php
$imageUrl = SERVER_CORE . "core/upload_view.php?name=$bin&folder=customer&proj_id=" . $_SESSION['proj_id'];
$defaultImage = SERVER_CORE . "core/default.png";
?>


<a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=customer_bin&&name=<?=$bin;?>" target="_blank">
<img src="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=customer_bin&&name=<?=$bin;?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" />
</a><?php */ ?>




										<a href="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $bin ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>&v=<?= time() ?>"
											target="_blank"><img
												src="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $bin ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>&v=<?= time() ?>" /></a>
									</div>
								</div>

								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
									<label class="container bg-form-titel-text">Blank Cheque:</label>
									<div class="container vendor_info_img">

										<?php /*?><?php
$imageUrl = SERVER_CORE . "core/upload_view.php?name=$cheque&folder=customer&proj_id=" . $_SESSION['proj_id'];
$defaultImage = SERVER_CORE . "core/default.png";
?>


<a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=customer_cheque&&name=<?=$cheque;?>" target="_blank">
<img src="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=customer_cheque&&name=<?=$cheque;?>" onerror="this.onerror=null; this.src='<?= $defaultImage ?>';" alt="Image" />
</a><?php */ ?>



										<a href="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $cheque ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>&v=<?= time() ?>"
											target="_blank"><img
												src="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $cheque ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>&v=<?= time() ?>" /></a>
									</div>
								</div>

							</div>
						</div>







						<hr>



						<div class="n-form-btn-class">







							<? if (!isset($_GET[$unique])) { ?>



								<input name="insert" type="submit" id="insert" value="SAVE &amp; NEW"
									class="btn1 btn1-bg-submit" />



							<? } ?>







							<? if (isset($_GET[$unique])) { ?>



								<input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />



							<? } ?>







							<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET"
								onclick="parent.location='<?= $page ?>'" />











						</div>







				</div>



	</form>



	<?







	//if(isset($_POST['search'])){
	






	?>




	<div class="container-fluid pt-5 p-0 ">
		<table id="vendor_table" class="table1  table-striped table-bordered table-hover table-sm">



			<thead class="thead1">



				<tr class="bgc-info">



					<th>ID</th>



					<th>Customer Name</th>



					<th>GL Code</th>



					<th>Address</th>



					<th>Created At</th>



					<th>Action</th>



				</tr>



			</thead>



			<tbody class="tbody1">







				<?php







				if ($_POST['group_for'] != "")







					$con .= 'and a.group_for="' . $_POST['group_for'] . '"';







				if ($_POST['depot'] != "")







					$con .= 'and a.depot="' . $_POST['depot'] . '"';



















				$td = 'select a.' . $unique . ',  a.' . $shown . ',   a.address_e, a.account_code, a.entry_at from ' . $table . ' a, user_group u



				where   a.group_for=u.id  and a.group_for in (' . $user_group_define . ')   ' . $con . ' order by a.dealer_code ';







				$report = db_query($td);







				while ($rp = mysqli_fetch_row($report)) {
					$i++;
					if ($i % 2 == 0)
						$cls = ' class="alt"';
					else
						$cls = ''; ?>







					<tr<?= $cls ?> onclick="DoNav('<?php echo $rp[0]; ?>');"
						bgcolor="<?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>">



						<td><?= $rp[0]; ?></td>







						<td style="text-align:left"><?= $rp[1]; ?></td>







						<td><?= $rp[3]; ?></td>



						<td style="text-align:left"><?= $rp[2]; ?></td>





						<td style="text-align:left"><?= $rp[4]; ?></td>



						<td> <button type="button" onclick="DoNav('<?php echo $rp[0]; ?>');" class="btn2 btn1-bg-update"><i
									class="fa-solid fa-pen-to-square"></i></button>



							<!--<input type="button" class="btn1 btn1-bg-update" value="Edit">-->



						</td>



						</tr>







					<?php } ?>



			</tbody>



		</table>







	</div>







	<? //} ?>



</div>



































<script type="text/javascript"><!--







var pager = new Pager('grp', 10000);







pager.init();







pager.showPageNav('pager', 'pageNavPosition');







pager.showPage(1);







//-->







	document.onkeypress = function (e) {







		var e = window.event || e







		var keyunicode = e.charCode || e.keyCode







		if (keyunicode == 13) {







			return false;







		}







	}







</script>















<script>







	function duplicate() {







		var dealer_code_2 = ((document.getElementById('dealer_code_2').value) * 1);







		var customer_id = ((document.getElementById('customer_id').value) * 1);











		if (dealer_code_2 > 0) {







			alert('This customer code already exists.');



			document.getElementById('customer_id').value = '';







			document.getElementById('customer_id').focus();







		}











	}







</script>







<?
require_once SERVER_CORE . "routing/layout.bottom.php";
?>