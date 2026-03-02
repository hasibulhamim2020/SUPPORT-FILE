<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Account Configuration';			// Page Name and Page 

$data=db_fetch_object('acc_config',1);

foreach ($data as $key => $value)

{ $$key=$value;}

//do_datatable('table_head');
$crud=new crud('acc_config');

if(isset($_POST['submit'])){
$crud->insert();
header('location:ac_config.php');
}
if(isset($_POST['update'])){
  $_POST['id']=1;
  $crud->update('id');
header('location:ac_config.php');
  
  }
?>

<center><h2>Account Configuration</h2></center>
<form action="" method="post">
<datalist id="ac_ledger">
  <? foreign_relation('accounts_ledger','ledger_id','ledger_name','','1')?>
</datalist>
<div class="container">
<div class="row">
  <div class="col-6">
  <div class="form-group">
    <label for="retained">Retained Earning</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$retained?>" name="retained">
  </div>
  <div class="form-group">
    <label for="depreciation">Depreciation Expense</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$depreciation?>" name="depreciation">
  </div>
  <div class="form-group">
    <label for="salary_exp">Salary Expense Acc</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$salary_exp?>" name="salary_exp">
  </div>
  <div class="form-group">
    <label for="accu_depreciation">Accumulated Depreciation</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$accu_depreciation?>" name="accu_depreciation">
  </div>
  <div class="form-group">
    <label for="payroll_pay_acc">Payroll Payable Account</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$payroll_pay_acc?>" name="payroll_pay_acc">
  </div>
  <div class="form-group">
    <label for="payroll_ref">Payroll Ref Payable</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$payroll_ref?>" name="payroll_ref">
  </div>
  <div class="form-group">
    <label for="unearned_int">Unearned Int. Income</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$unearned_int?>" name="unearned_int">
  </div>
  <div class="form-group">
    <label for="loan_sh">Loan From SH</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$loan_sh?>" name="loan_sh">
  </div>
  <div class="form-group">
    <label for="loan_shareholder">Loan To Shareholder</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$loan_shareholder?>" name="loan_shareholder">
  </div>
  <div class="form-group">
    <label for="discount">Discount</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$discount?>" name="discount">
  </div>
  <div class="form-group">
    <label for="promo_dis">Promotional Discount Gain</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$promo_dis?>" name="promo_dis">
  </div>
  <div class="form-group">
    <label for="discount_gain">Discount Gain</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$discount_gain?>" name="discount_gain">
  </div>
  <div class="form-group">
    <label for="capital">Capital</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$capital?>" name="capital">
  </div>
  <div class="form-group">
    <label for="recon_dis">Reconcilation Discrepancies</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$recon_dis?>" name="recon_dis">
  </div>
  <div class="form-group">
    <label for="wip">Work In Process</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$wip?>" name="wip">
  </div>
  <div class="form-group">
    <label for="vat">VAT</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$vat?>" name="vat">
  </div>
  <div class="form-group">
    <label for="vat_pay">VAT Payable</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$vat_pay?>" name="vat_pay">
  </div>
  <div class="form-group">
    <label for="vat_rect">VAT Recevable</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$vat_rect?>" name="vat_rect">
  </div>
  <div class="form-group">
    <label for="vat_deposit">VAT Deposit</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$vat_deposit?>" name="vat_deposit">
  </div>
  <div class="form-group">
    <label for="ait">AIT</label>
    <input list="ac_ledger" type="text" class="form-control"  value="<?=$ait?>" name="ait">
  </div>

  
  </div>

  <div class="col-6">
  <div class="form-group">
    <label for="account_rec">Account Receivable</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$account_rec?>" name="account_rec">
  </div>
  <div class="form-group">
    <label for="account_pay">Account Paybale</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$account_pay?>" name="account_pay">
  </div>
  <div class="form-group">
    <label for="cogs_acc">COGS Account</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$cogs_acc?>" name="cogs_acc">
  </div>
  <div class="form-group">
    <label for="cos_acc">COS Account</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$cos_acc?>" name="cos_acc">
  </div>
  <div class="form-group">
    <label for="income_acc">Income Account</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$income_acc?>" name="income_acc">
  </div>
  <div class="form-group">
    <label for="int_income_acc">Int. Income Account</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$int_income_acc?>" name="int_income_acc">
  </div>
  <div class="form-group">
    <label for="contra_rev">Contra Revenue</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$contra_rev?>" name="contra_rev">
  </div>
  <div class="form-group">
    <label for="expense_acc">Expense Account</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$expense_acc?>" name="expense_acc">
  </div>
  <div class="form-group">
    <label for="acc_cash">Account Cash</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$acc_cash?>" name="acc_cash">
  </div>
  <div class="form-group">
    <label for="inventory">Invntory</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$inventory?>" name="inventory">
  </div>
  <div class="form-group">
    <label for="dis_debit">Disposal Debit</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$dis_debit?>" name="dis_debit">
  </div>
  <div class="form-group">
    <label for="reconcile">Reconcile</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$reconcile?>" name="reconcile">
  </div>
  <div class="form-group">
    <label for="gods_recv">Goods Receivable</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$gods_recv?>" name="gods_recv">
  </div>
  <div class="form-group">
    <label for="tax_pay">TAX Payable</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$tax_pay?>" name="tax_pay">
  </div>
  <div class="form-group">
    <label for="tax_exp">TAX Expense</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$tax_exp?>" name="tax_exp">
  </div>
  <div class="form-group">
    <label for="asset_exp">Asset Expense</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$asset_exp?>" name="asset_exp">
  </div>
  <div class="form-group">
    <label for="asset_income">Asset Income</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$asset_income?>" name="asset_income">
  </div>
  <div class="form-group">
    <label for="currency_exp">Currency Expense</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$currency_exp?>" name="currency_exp">
  </div>
  <div class="form-group">
    <label for="production_exp">Production Expense</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$production_exp?>" name="production_exp">
  </div>
  <div class="form-group">
    <label for="lc_margin">LC Margin</label>
    <input list="ac_ledger" type="text" class="form-control" value="<?=$lc_margin?>" name="lc_margin">
  </div>

  </div>
</div>
<center>
<? if($id!=''){?>  
<button type="submit"   name="update" class="btn btn-success">Update</button>
<? }else{?>
  <button type="submit"   name="submit" class="btn btn-success">Save</button>
  <? }?>
</center>
</form>


</div>
<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>