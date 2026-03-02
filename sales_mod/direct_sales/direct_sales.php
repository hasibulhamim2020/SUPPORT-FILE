<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
$title = 'Direct Sales Entry';
$page_for = 'DirectSales';
$page_name="Direct Sales Entry";

$din = find_a_field('menu_warehouse', 'local_purchase', 'id="' . $_SESSION['user']['group'] . '"');
if ($din > 0) {
	$din = $din;
} else {
	$din = 60;
}
do_calander('#oi_date', '-"' . $din . '"', '0');
do_calander('#quotation_date');
//create_combobox("vendor_id");
$tr_type = "Show";

$table_master = 'warehouse_other_issue';
$table_details = 'warehouse_other_issue_detail';
$unique = 'oi_no';


if ($_REQUEST['new'] > 0) {

	unset($_SESSION['oi_no']);

}


if ($_GET['oi_no'] > 0) {

	$$unique = $_SESSION['oi_no'] = $_GET['oi_no'];

}
if (isset($_POST['new'])) {
	$crud = new crud($table_master);

	if (!isset($_SESSION['oi_no'])) {

		$_POST['entry_by'] = $_SESSION['user']['id'];
		$_POST['entry_at'] = date('Y-m-d H:s:i');
		$_POST['edit_by'] = $_SESSION['user']['id'];
		$_POST['edit_at'] = date('Y-m-d H:s:i');
		$vendor = explode('#', $_POST['dealer_code']);
		$_POST['vendor_id'] = $vendor[1];
		$_POST['vendor_name'] = $vendor[0];
		$warehouse = explode('#', $_POST['warehouse_id']);
		$_POST['warehouse_id'] = $warehouse[0];
		$$unique = $_SESSION['oi_no'] = $crud->insert();
		//unset($$unique);
		$type = 1;
		$msg = $title . '  No Created. (No :-' . $_SESSION['oi_no'] . ')';
		$tr_type = "Initiate";
	} else {
		$vendor = explode('#', $_POST['dealer_code']);
		$_POST['vendor_id'] = $vendor[1];
		$_POST['vendor_name'] = $vendor[0];
		$warehouse = explode('#', $_POST['warehouse_id']);
		$_POST['warehouse_id'] = $warehouse[0];
		$_POST['edit_by'] = $_SESSION['user']['id'];
		$_POST['edit_at'] = date('Y-m-d H:s:i');


		$update = "update warehouse_other_issue_detail set oi_date='" . $_POST['oi_date'] . "',warehouse_id='" . $_POST['warehouse_id'] . "'  where oi_no=" . $_POST['oi_no'] . "";
		db_query($update);

		$crud->update($unique);
		$type = 1;
		$msg = 'Successfully Updated.';
		$tr_type = "Add";
	}
}

$$unique = $_SESSION['oi_no'];

if (isset($_POST['delete'])) {
	$crud = new crud($table_master);
	$condition = $unique . "=" . $$unique;
	$crud->delete($condition);
	$crud = new crud($table_details);
	$condition = $unique . "=" . $$unique;
	$crud->delete_all($condition);
	unset($$unique);
	unset($_SESSION['oi_no']);
	$type = 1;
	$msg = 'Successfully Deleted.';
	$tr_type = "Delete";
}

if ($_GET['del'] > 0) {
	$crud = new crud($table_details);
	$condition = "id=" . $_GET['del'];
	$crud->delete_all($condition);

	$sql = "delete from journal_item where tr_from = '" . $page_for . "' and tr_no = '" . $_GET['del'] . "'";
	db_query($sql);
	$type = 1;
	$msg = 'Successfully Deleted.';
	$tr_type = "Remove";

}
if (isset($_POST['confirmm'])) {
	$oi_no = $_POST['oi_no'];
	$sql = 'select w.*,s.item_ledger, s.sub_group_name,s.cogs_ledger,i.sub_ledger_id from warehouse_other_issue_detail w, item_info i, item_sub_group s where i.item_id=w.item_id and s.sub_group_id=i.sub_group_id and w.oi_no="' . $oi_no . '" and w.issue_type="DirectSales"';
	$qry = db_query($sql);
	$page_for = 'DirectSales';
	$jv_no = next_journal_sec_voucher_id();
	$jv_date = $_POST['oi_date'];
	$proj_id = 'clouderp';
	$group_for = $_SESSION['user']['group'];
	$cc_code = '1';
	$tr_no = $oi_no;
	//$tr_from = 'DirectSales';
	$narration = 'DirectSales#' . $oi_no;
	$ledgers = find_all_field('config_group_class', '', 'group_for="' . $group_for . '"');
	$customer_ledger = find_all_field('dealer_info', '*', 'dealer_code="' . $_POST['dealer_code'] . '"');
	while ($data = mysqli_fetch_object($qry)) {
		$tr_id = $data->id;

		/*$avg_rate = find_a_field('journal_item', '(sum(item_in*final_price)-sum(item_ex*final_price))/(sum(item_in)-sum(item_ex))', 'item_id = "'.$data->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');*/
		$avg_rate = get_cost_rate($data->item_id);
		$cogs_amt = $data->qty * $avg_rate;


		$update = "update warehouse_other_issue_detail set cost_price=" . $avg_rate . ",cost_amt =" . $cogs_amt . " where id=" . $data->id . " ";
		db_query($update);


		journal_item_control($data->item_id, $_POST['warehouse_id'], $data->oi_date, 0, $data->qty, $page_for, $tr_id, $avg_rate, '', $_SESSION['oi_no']);


		$narration = 'DirectSales#' . $data->sub_group_name . '#' . $oi_no;

		add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->item_ledger, $narration, '0', $cogs_amt, $tr_from, $tr_no, $data->sub_ledger_id, $tr_id, $cc_code, $group_for);
		$narration = 'DirectSales#Cogs#' . $oi_no;
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->cogs_ledger, $narration, $cogs_amt, '0', $tr_from, $tr_no, $data->sub_ledger_id, $tr_id, $cc_code, $group_for);
		$total_amt += $data->amount;
	}
	$narration = 'DirectSales#' . $oi_no;
	add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledgers->directSales, $narration, '0', $total_amt, $tr_from, $tr_no, $customer_ledger->sub_ledger_id, $tr_id = 0, $cc_code, $group_for);
	$narration = 'DirectSales#Customer#' . $oi_no;
	add_to_sec_journal($proj_id, $jv_no, $jv_date, $customer_ledger->account_code, $narration, $total_amt, '0', $tr_from, $tr_no, $customer_ledger->sub_ledger_id, $tr_id = 0, $cc_code, $group_for);
	unset($_POST);
	$_POST[$unique] = $$unique;
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date('Y-m-d h:s:i');
	$_POST['status'] = 'CHECKED';
	$crud = new crud($table_master);
	$crud->update($unique);
	unset($$unique);
	unset($_SESSION['oi_no']);
	$type = 1;
	$msg = 'Successfully Forwarded.';
	$tr_type = "Confirmed";
	$tr_from="DirectSales";
}

if (isset($_POST['add']) && ($_POST[$unique] > 0) && $_SESSION['csrf_token'] === $_POST['csrf_token']) {

	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));


	$crud = new crud($table_details);
	$iii = explode('#>', $_POST['item_id']);
	$_POST['item_id'] = $_POST['item_id'];
	$_POST['rate'] = $_POST['unit_price'];
	$_POST['qty'] = $_POST['dist_unit'];
	$_POST['amount'] = $_POST['total_amt'];
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date('Y-m-d h:s:i');
	$_POST['edit_by'] = $_SESSION['user']['id'];
	$_POST['edit_at'] = date('Y-m-d h:s:i');
	$xid = $crud->insert();

	$tr_type = "Item Add";

	// item info rate update
//$sql_update = "UPDATE  item_info SET cost_price ='".$_POST['rate']."' WHERE  item_id =".$_POST['item_id'];
//db_query($sql_update);

}

if ($$unique > 0) {
	$condition = $unique . "=" . $$unique;
	$data = db_fetch_object($table_master, $condition);
	foreach ($data as $key => $value) {
		$$key = $value;
	}

}
if ($$unique > 0)
	$btn_name = 'Update DS Information';
else
	$btn_name = 'Initiate DS Information';
if ($_SESSION['oi_no'] < 1)
	$$unique = db_last_insert_id($table_master, $unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
auto_complete_from_db('item_info', 'item_name', 'concat(item_name,"#>",item_id)', '1', 'item_id');

?>
<script language="javascript">
	function focuson(id) {
		if (document.getElementById('item_id').value == '')
			document.getElementById('item_id').focus();
		else
			document.getElementById(id).focus();
	}
	window.onload = function () {
		if (document.getElementById("warehouse_id").value > 0)
			document.getElementById("item_id").focus();
		else
			document.getElementById("req_date").focus();
	}
</script>
<script language="javascript">
	function count2() {
		var stock = document.getElementById('pcs_stock').value * 1;
		var qty = document.getElementById('qty').value)* 1;
		var rate = document.getElementById('rate').value)* 1;
		if (stock < qty) {
			alert('Stock Not Available!!!');
		} else {

			var num = qty * rate;
			document.getElementById('amount').value = num.toFixed(2);
			document.getElementById('qty').value = 0;
		}

	}
</script>









<!--DO create 2 form with table-->
<div class="form-container_large">
	<form action="" method="post" name="codz" id="codz"
		onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
		<!--        top form start hear-->
		<div class="container-fluid bg-form-titel">
			<div class="row">
				<!--left form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">
						<div class="form-group row m-0 pb-1">
							<? $field = 'oi_no'; ?>
							<label for="<?= $field ?>"
								class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Direct
								Sales No:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="<?= $field ?>" type="text" id="<?= $field ?>" value="<?= $$field ?>"
									readonly="readonly" />
							</div>
						</div>

						<div class="form-group row m-0 pb-1">
							<? $field = 'oi_date';
							if ($oi_date == '')
								$oi_date = date(''); ?>
							<label for="<?= $field ?>"
								class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Direct
								Sales Date:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								<input name="<?= $field ?>" type="text" id="<?= $field ?>" value="<?= $$field ?>"
									required />
							</div>
						</div>

						<input name="warehouse_id" type="hidden" id="warehouse_id" value="<?= $_POST['warehouse_id'] ?>"
							required />
						<input name="issue_type" type="hidden" id="issue_type" value="<?= $page_for ?>"
							required="required" />
					</div>

				</div>

				<!--Right form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">
						<div class="form-group row m-0 pb-1">
							<? $field = 'oi_subject'; ?>
							<label for="<?= $field ?>"
								class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								<input name="<?= $field ?>" type="text" id="<?= $field ?>" value="<?= $$field ?>" />
							</div>
						</div>

						<div class="form-group row m-0 pb-1">
							<? $field = 'vendor_id'; ?>
							<label for="<?= $field ?>"
								class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">Customer:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input type="text" list="dealerList" name="dealer_code" id="dealer_code"
									value="<?= find_a_field('dealer_info', 'concat(dealer_name_e,"#",dealer_code)', 'dealer_code="' . $vendor_id . '"'); ?>"
									required />
								<datalist id="dealerList">

									<option></option>
									<? foreign_relation('dealer_info', 'concat(dealer_name_e,"#",dealer_code)', '""', $_POST['vendor_id'], '1'); ?>
								</datalist>
							</div>
						</div>


						<div class="form-group row m-0 pb-1">
							<? $field = 'warehouse_id'; ?>
							<label for="<?= $field ?>"
								class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">Warehouse
								:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

								<select name="warehouse_id" id="warehouse_id" required>

									<option></option>
									<? user_warehouse_access($warehouse_id); ?>
								</select>

							</div>
						</div>


					</div>



				</div>


			</div>

			<div class="n-form-btn-class">
				<input name="new" type="submit" class="btn1 btn1-bg-submit" value="<?= $btn_name ?>" />
			</div>

		</div>

	</form>



	<? if ($_SESSION['oi_no'] > 0) { ?>
		<form action="?<?= $unique ?>=<?= $$unique ?>" method="post" name="cloud" id="cloud">
			<!--Table input one design-->
			<div class="container-fluid pt-5 p-0 ">


				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
						<tr class="bgc-info">
							<th>Item Code</th>
							<th width="30%">Item Description</th>
							<th>Unit</th>

							<th>Stock</th>
							<th>Unit-Price</th>
							<th>Quantity</th>

							<th>Value</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody class="tbody1">


						<tr>


							<td id="sub">

								<?

								auto_complete_from_db('item_info', 'concat(item_id,"-> ",item_name)', 'item_id', '1', 'item_id');

								//$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and pr_no=".$pr_no." order by id desc limit 1";
								//$do_data = find_all_field_sql($do_details);
							
								?>

								<input type="hidden" id="<?= $unique ?>" name="<?= $unique ?>" value="<?= $$unique ?>" />
								<input name="item_id" type="text" value="" id="item_id"
									onblur="getData2('direct_sales_ajax.php', 'so_data_found', this.value, document.getElementById('oi_no').value);" />


								<!--<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('pr_no').value);">

									<option></option>

								  <? foreign_relation('item_info', 'item_id', 'item_name', $item_id, '1'); ?>
							 </select>-->



								<input type="hidden" id="<?= $unique ?>" name="<?= $unique ?>" value="<?= $$unique ?>" />
								<input type="hidden" id="oi_date" name="oi_date" value="<?= $oi_date ?>" />
								<input type="hidden" id="group_for" name="group_for" value="<?= $group_for ?>" />

								<input type="hidden" id="issue_type" name="issue_type" value="DirectSales" />

								<input type="hidden" id="warehouse_id" name="warehouse_id" value="<?= $warehouse_id ?>" />
							</td>

							<td id="so_data_found" colspan="4">
								<table cellpadding="0" cellspacing="2">
									<tr>
										<td width="43%"><input name="item_name" type="text" readonly="" autocomplete="off"
												value="" id="item_name" /> </td>
										<td width="10%"><input name="pcs_stock" type="text" readonly="" autocomplete="off"
												value="" id="pcs_stock" /></td>
										<td width="14%"><input name="ctn_price" type="text" id="ctn_price" readonly=""
												required value="<?= $do_data->ctn_price; ?>" /></td>
										<td width="15%"><input name="pcs_price" type="text" id="pcs_price" readonly=""
												required="required" value="<?= $do_data->pcs_price; ?>" /></td>
									</tr>
								</table>
							</td>

							<td>

								<input name="dist_unit" type="text" class="input3" id="dist_unit" value="" required
									onkeyup="count()" />

							</td>

							<td>
								<input name="total_unit" type="hidden" id="total_unit" readonly />
								<input name="total_amt" type="text" id="total_amt" readonly />
							</td>

							<td>
								<input name="add" type="submit" id="add" value="ADD" class="btn1 btn1-bg-submit" />
							</td>

							<input name="csrf_token" type="hidden" id="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" />

						</tr>

					</tbody>

				</table>

			</div>


			<!--Data multi Table design start-->
			<div class="container-fluid pt-5 p-0 ">

				<table class="table1  table-striped table-bordered table-hover table-sm">
					<?
					$res = 'select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.oi_no=' . $oi_no;
					//echo link_report_add_del_auto($res,'2','5');
					?>
					<thead class="thead1">
						<tr class="bgc-info">
							<th>S/L</th>
							<th>Item Name</th>
							<th>Unit Name</th>
							<th>Unit Price</th>

							<th>Qty</th>

							<th>Amount</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody class="tbody1">

						<?
						$res = 'select a.id,b.item_name,a.rate,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.oi_no=' . $oi_no;
						//echo link_report_add_del_auto($res,'2','5');
						$i = 1;
						$qry = db_query($res);
						while ($data = mysqli_fetch_object($qry)) {
							?>

							<tr>
								<td><?= $i++ ?></td>
								<td style="text-align:left"><?= $data->item_name ?></td>
								<td><?= $data->unit_name ?></td>
								<td><?= $data->rate ?></td>

								<td><?= $data->qty ?></td>

								<td><?= $data->amount ?></td>

								<td><a href="?del=<?= $data->id ?>"> X </a></td>

							</tr>
							<?
							$t_amount += $data->amount;
						} ?>


						<tr bgcolor="yellow">
							<td colspan="5" align="center" valign="top">
								<div align="right"><strong>Total Amount: </strong></div>
							</td>
							<td align="center" valign="top">
								<span class="style1"> <?= $t_amount ?> </span>
							</td>
						</tr>

					</tbody>
				</table>

			</div>
		</form>

		<!--button design start-->
		<form action="" method="post" name="cz" id="cz"
			onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
			<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input type="hidden" id="<?= $unique ?>" name="<?= $unique ?>" value="<?= $$unique ?>" />
					<input type="hidden" id="oi_date" name="oi_date" value="<?= $oi_date ?>" />
					<input type="hidden" id="dealer_code" name="dealer_code" value="<?= $vendor_id ?>" />
					<input type="hidden" id="warehouse_id" name="warehouse_id" value="<?= $warehouse_id ?>" />

					<? if ($oi_date == date('Y-m-d')) { ?>

						<input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM DIRECT SALES" />
					<? } else {
						echo '<div class="alert alert-danger" role="alert">Date Must Be Current Date.</div>';
					} ?>
				</div>

			</div>
		</form>

	<? } ?>
</div>







<?php /*?>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td valign="top"><fieldset>
<? $field='oi_no';?>
<div>
<label for="<?=$field?>">Direct Sales  No: </label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>
</div>
<? $field='oi_date'; if($oi_date=='') $oi_date =date(''); ?>
<div>
<label for="<?=$field?>">DirectSales Date:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly" required/>
</div>


<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>

<input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
</fieldset>
</td>
<td>
<fieldset>

<? $field='oi_subject';?>
<div>
<label for="<?=$field?>">Note:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
</div>
<div></div>
<? $field='vendor_id'; ?>
<div>
<label for="<?=$field?>">Customer:</label>
<select name="vendor_id" id="vendor_id" required>
<option></option>
<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['vendor_id'],'1');?>
</select>
</div>

</div>
</fieldset>
</td>
</tr>
<tr>
<td colspan="2"><div class="buttonrow" style="margin-left:240px;">
<input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
</div></td>
</tr>
</table>
</form>


<? if($_SESSION['oi_no']>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">




<tr>
<td colspan="6" width="70%">&nbsp;       </td>
<td width="20%"><div class="button">

<input name="add" type="submit" id="add" value="ADD" class="update" style="background: #339933; font-size:14px; font-weight:700;"/>

</div></td>
</tr>

<tr>

<td width="10%" align="center" bgcolor="#0073AA"><span class="style2">Item Code </span></td>

<td width="60%"colspan="4" align="center" bgcolor="#0073AA">

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
<tr>
<td width="55%"><span class="style2">Item Description</span></td>
<td width="15%"><span class="style2">Unit</span></td>
<td width="15%"><span class="style2">Stock</span></td>
<td width="15%"><span class="style2">Unit-Price</span></td>
</tr>
</table></td>

<td width="15%" align="center" bgcolor="#0073AA"><span class="style2">Quantity</span></td>
<td width="15%" align="center" bgcolor="#0073AA"><span class="style2">Value</span></td>
</tr>


<tr bgcolor="#CCCCCC">


<td align="center"><span class="style2">




<span id="sub">
<?

auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id','1','item_id');

//$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and pr_no=".$pr_no." order by id desc limit 1";
//$do_data = find_all_field_sql($do_details);

?>

<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />
<input name="item_id" type="text" class="input3"  value="" id="item_id" style="width:90%; height:30px;" onblur="getData2('direct_sales_ajax.php', 'so_data_found', this.value, document.getElementById('oi_no').value);"/><?php */ ?>


<!--<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('pr_no').value);">

		<option></option>

	  <? foreign_relation('item_info', 'item_id', 'item_name', $item_id, '1'); ?>
 </select>-->


<?php /*?>
<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />
<input type="hidden" id="oi_date" name="oi_date" value="<?=$oi_date?>"  />
<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
<input type="hidden" id="warehouse_id" name="warehouse_id" value="<?=$warehouse_id?>"  />
<input type="hidden" id="issue_type" name="issue_type" value="DirectSales"  />
</span>




</span></td>
<td colspan="4" align="center">


<span id="so_data_found">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
<tr bgcolor="#CCCCCC">
<td width="55%"><input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name" style="width:90%; height:30px;" /> </td>
<td width="15%"><input name="pcs_stock" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="pcs_stock" style="width:90%; height:30px;" /></td>
<td width="15%"><input name="ctn_price" type="text" class="input3" id="ctn_price" readonly=""   style="width:90%; height:30px;" required  value="<?=$do_data->ctn_price;?>"   /></td>
<td width="15%"><input name="pcs_price" type="text" class="input3" id="pcs_price" readonly=""   style="width:90%; height:30px;" required="required"  value="<?=$do_data->pcs_price;?>"  /></td>
</tr>
</table>
</span>
</td>

<td width="10%" align="center">

<span class="style2">

<input  name="dist_unit" type="text" class="input3" id="dist_unit"value="" style="width:90%; height:30px;"   onkeyup="count()"   />
</span>
</td>
<td width="10%" align="center">

<span class="style2">



<input name="total_unit" type="hidden" class="form-control"  style="width:64px" id="total_unit" readonly/>		


<input name="total_amt" type="text" class="form-control" id="total_amt"  style="width:90%; height:30px;"   readonly/>

</span>
</td>
</tr>
</table>
<br />
<br />
<br />
<br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
<td><?php */ ?>
<?php /*?><div class="tabledesign2">
<? 
$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.oi_no='.$oi_no;
echo link_report_add_del_auto($res,'2','5');
?>
</div>
</td>
</tr>




<tr>
<td>

</td>
</tr>
</table>
</form>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="100%" border="0">
<tr>
<td align="center"><input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />
<input type="hidden" id="oi_date" name="oi_date" value="<?=$oi_date?>"  /><input type="hidden" id="dealer_code" name="dealer_code" value="<?=$vendor_id?>"  />&nbsp;</td>
<td align="center">

<input name="confirmm" type="submit" class="btn btn-primary" value="CONFIRM DIRECT SALES" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#fff" />

</td>
</tr>
</table>
</form>
<? }?>
</div><?php */ ?>






<script>$("#codz").validate(); $("#cloud").validate();</script>
<script language="javascript">
	function count() {

		var dist_unit = ((document.getElementById('dist_unit').value) * 1);
		var unit_price = ((document.getElementById('unit_price').value) * 1);
		var stock = document.getElementById('pcs_stock').value * 1;
		if (stock >= dist_unit) {
			if (unit_price != '') {
				var total_unit = (document.getElementById('total_unit').value) = dist_unit;

				var total_amt = (document.getElementById('total_amt').value) = total_unit * unit_price;

			} else {
				alert('Price Should Not Empty!!');
			}
		} else {
			alert('Stock Not Found!!');
			document.getElementById('dist_unit').value = '';
		}

	}

</script>
<?
require_once SERVER_CORE . "routing/layout.bottom.php";
?>