<?php
session_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title = 'Add Customer'; // Page Name and Page Title
$page = "department_type.php"; // PHP File Name
$input_page = "customer_input.php";
$root = 'setup';

$table = 'dealer_info'; // Database Table Name Mainly related to this page
$unique = 'dealer_code'; // Primary Key of this Database table
$shown = 'DEPT_DESC'; // For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud = new crud($table);

$$unique = $_GET[$unique];


if(isset($_POST['insert'])){

	



//if ($_POST['dealer_found']==0) {}

	



$proj_id			= $_SESSION['proj_id'];



$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d h:i:s');



//$wh_data = find_all_field('warehouse','','warehouse_id='.$_POST['depot']); 



$_POST['ledger_group_id']=$_POST['ledger_group'];



$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%04d", $cy_id);

$_POST['account_code'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$_POST['ledger_name'] = $_POST['dealer_name_e'];

$crud->insert();

$ledger_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);


if ($ledger_gl_found==0) {

   $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class,opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)

  
  VALUES("'.$_POST['account_code'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$_POST['group_for'].'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';


db_query($acc_ins_led);

}

		

		

	

		

$type=1;



$msg='New Entry Successfully Inserted.';



unset($_POST);



unset($$unique);


}
if (isset($_POST[$shown])) {
	$$unique = $_POST[$unique];

	if (isset($_POST['insert']) || isset($_POST['insertn'])) {
		$now = time();
		$_POST['DEPT_SHORT_NAME'] = $_POST['DEPT_SHORT_NAME'];
		$crud->insert();
		$type = 1;
		$msg = 'New Entry Successfully Inserted.';

		if (isset($_POST['insert'])) {
			echo '<script type="text/javascript">
parent.parent.document.location.href = "../' . $root . '/' . $page . '";
</script>';
		}
		unset($_POST);
		unset($$unique);


	}


	//for Modify..................................

	if (isset($_POST['update'])) {
		$_POST['DEPT_SHORT_NAME'] = $_POST['DEPT_SHORT_NAME'];
		$crud->update($unique);
		$type = 1;
		$msg = 'Successfully Updated.';
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../' . $root . '/' . $page . '";
</script>';
	}
	//for Delete..................................

	if (isset($_POST['delete'])) {
		$condition = $unique . "=" . $$unique;
		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../' . $root . '/' . $page . '";
</script>';
		$type = 1;
		$msg = 'Successfully Deleted.';
	}
}

if (isset($$unique)) {
	$condition = $unique . "=" . $$unique;
	$data = db_fetch_object($table, $condition);
	while (list($key, $value) = each($data)) {
		$$key = $value;
	}
}
if (!isset($$unique))
	$$unique = db_last_insert_id($table, $unique);
?>
<html style="height: 100%;">

<head>
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	<meta content="text/html; charset=UTF-8" http-equiv="content-type">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
	<link href="../../css/css.css" rel="stylesheet">
</head>

<body>
	<!--[if lte IE 8]>
		<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
		<script>CFInstall.check({mode: "overlay"});</script>
		<![endif]-->
	<form action="" method="post">


		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp"
			style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 1200px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;"
			tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
			<? include('../../common/title_bar_popup.php'); ?>
			<div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;"
				class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

				<div style="width:100%" class="oe_popup_form">
					<div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
						<div class="oe_form_buttons"></div>
						<div class="oe_form_sidebar" style="display: none;"></div>
						<div class="oe_form_container">
							<div class="oe_form">
								<div class="">
									<? include('../../common/input_bar.php'); ?>
									<div class="oe_form_sheetbg">
										<div class="oe_form_sheet oe_form_sheet_width">
											<h1><label for="oe-field-input-27" title=""
													class=" oe_form_label oe_align_right">

												</label>
											</h1>
											<table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
												<tbody>
													<form action="" method="post" enctype="multipart/form-data"
														name="form1" id="form1" onSubmit="return check()">



								<div class="container-fluid bg-form-titel">
										<div class="row">

											<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

												<div class="form-group row m-0">

													<label class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">Customer Name:</label>

									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



																			<input name="<?= $unique ?>" id="<?= $unique ?>"
																				value="<?=$$unique ?>" type="hidden" />



																			<input name="group_for" required
																				type="hidden" id="group_for"
																				tabindex="1"
																				value="<?= $_SESSION['user']['group']; ?>">



																			<input name="dealer_name_e" required
																				type="text" id="dealer_name_e"
																				tabindex="1"
																				value="<?= $dealer_name_e ?>">

																		</div>

																	</div>
																</div>
																<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Propritor
																			Name:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<input name="propritor_name_e" type="text"
																				id="propritor_name_e" tabindex="2"
																				value="<?= $propritor_name_e ?>" />

																		</div>

																	</div>

																</div>



																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">Customer
																			Type :</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<select name="dealer_type" required
																				id="dealer_type" tabindex="3">

																				<option></option>

																				<? foreign_relation('dealer_type', 'id', 'dealer_type', $dealer_type, '1'); ?>

																			</select>



																		</div>

																	</div>

																</div>



																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Mobile:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<input name="contact_no" type="text"
																				id="contact_no" tabindex="4"
																				value="<?= $contact_no ?>" />

																		</div>

																	</div>

																</div>

																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Email:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<input name="email" type="text" id="email"
																				tabindex="7" value="<?= $email ?>" />

																		</div>

																	</div>

																</div>

																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">A/C
																			Configuration:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



																			<? if ($account_code == 0) { ?>

																				<select name="ledger_group"
																					required="required" id="ledger_group"
																					style="width:95%; font-size:12px;"
																					tabindex="9">

																					<option></option>

																					<?php /*?><? foreign_relation('ledger_group','group_id','group_name',$ledger_group,'acc_class=1 and group_id in("10306","10307")');?><?php */?>

																					<? foreign_relation('ledger_group', 'group_id', 'group_name', $ledger_group, '1'); ?>

																				</select>

																			<? } ?>



																			<? if ($account_code > 0) { ?>

																				<input name="account_code" type="text"
																					id="account_code" tabindex="9"
																					value="<?= $account_code ?>"
																					style="width:95%; font-size:12px;" />

																			<? } ?>



																		</div>

																	</div>

																</div>





																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 d-flex vendor_label_text justify-content-end align-items-center pr-1 bg-form-titel-text">Region:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<select name="region_code" id="region_code"
																				tabindex="9"
																				onchange="getData2('dealer_zone_ajax.php', 'dealer_zone_find', this.value,  document.getElementById('region_code').value);">



																				<option></option>

																				<? foreign_relation('branch', 'BRANCH_ID', 'BRANCH_NAME', $region_code, '1'); ?>

																			</select>

																		</div>

																	</div>

																</div>





																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 d-flex vendor_label_text justify-content-end align-items-center pr-1 bg-form-titel-text">Zone:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<span id="dealer_zone_find">

																				<select name="zone_code" id="zone_code"
																					tabindex="9"
																					onchange="getData2('dealer_area_ajax.php', 'dealer_area_find', this.value,  document.getElementById('zone_code').value);">



																					<option></option>

																					<? foreign_relation('zon', 'ZONE_CODE', 'ZONE_NAME', $zone_code, 'REGION_ID="' . $region_code . '"'); ?>

																				</select>

																			</span>

																		</div>

																	</div>

																</div>



																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 d-flex vendor_label_text justify-content-end align-items-center pr-1 bg-form-titel-text">Area:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<span id="dealer_area_find">

																				<select name="area_code" id="area_code"
																					tabindex="9">



																					<option></option>

																					<? foreign_relation('area', 'AREA_CODE', 'AREA_NAME', $area_code, 'ZONE_ID="' . $zone_code . '"'); ?>

																				</select>

																			</span>

																		</div>

																	</div>

																</div>





																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">Address:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<input name="address_e" type="text"
																				id="address_e" tabindex="14"
																				value="<?= $address_e ?>" />

																		</div>

																	</div>

																</div>





																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Credit
																			Limit:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<input name="credit_limit" type="text"
																				id="credit_limit" tabindex="14"
																				value="<?= $credit_limit ?>" />

																		</div>

																	</div>

																</div>





																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">Depot:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<select name="depot" required="required"
																				id="depot" tabindex="9">

																				<option></option>

																				<? foreign_relation('warehouse', 'warehouse_id', 'warehouse_name', $depot, '1'); ?>

																			</select>

																		</div>

																	</div>

																</div>





																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Contact
																			Person:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<input name="contact_person_name"
																				type="text" id="contact_person_name"
																				tabindex="16"
																				value="<?= $contact_person_name ?>" />

																		</div>

																	</div>

																</div>





																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job
																			Title:</label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<input name="contact_person_designation"
																				type="text"
																				id="contact_person_designation"
																				tabindex="17"
																				value="<?= $contact_person_designation ?>" />

																		</div>

																	</div>

																</div>





																<div
																	class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">

																	<div class="form-group row m-0">

																		<label
																			class="col-2 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Contact
																			Person Phone: </label>

																		<div
																			class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

																			<input name="contact_person_mobile"
																				type="text" id="contact_person_mobile"
																				tabindex="18"
																				value="<?= $contact_person_mobile ?>" />



																		</div>

																	</div>

																</div>



															</div>





															<hr>

															<div class="n-form-btn-class">



																	<input name="insert" type="submit" id="insert"
																		value="SAVE"
																		class="btn1 btn1-bg-submit" />

														

															</div>





														</div>

													</form>

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ui-resizable-handle ui-resizable-n" style="z-index: 1000;"></div>
			<div class="ui-resizable-handle ui-resizable-e" style="z-index: 1000;"></div>
			<div class="ui-resizable-handle ui-resizable-s" style="z-index: 1000;"></div>
			<div class="ui-resizable-handle ui-resizable-w" style="z-index: 1000;"></div>
			<div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se"
				style="z-index: 1000;"></div>
			<div class="ui-resizable-handle ui-resizable-sw" style="z-index: 1000;"></div>
			<div class="ui-resizable-handle ui-resizable-ne" style="z-index: 1000;"></div>
			<div class="ui-resizable-handle ui-resizable-nw" style="z-index: 1000;"></div>
			<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">

			</div>
		</div>
	</form>
</body>

</html>