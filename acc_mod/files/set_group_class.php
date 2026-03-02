<?php
session_start();
ob_start();
require_once "../support/inc.all.php";
$title='Configuration Accounts Ledger';

$now=time();
$unique='group_for';
$shown='sales_ledger';
$table='config_group_class';
$page="set_group_class.php";
$crud      =new crud($table);
$$unique = $_SESSION['user']['group'];


if(isset($_POST['modify']))

{
		$_POST[$unique]=$$unique;
		$_POST['edit_at']=time();
		$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}

if(isset($$unique))

{

$condition=$unique."=".$$unique;	
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td><form action="" method="post" enctype="multipart/form-data" name="form2" id="form2">
						    <table width="700" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="4"><div class="box" style="width:500px;">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>Concern Company Name: </td>
                                      <td>
<input name="group_name" type="text" id="group_name" value="<?=$group_name;?>" size="25" class="required"/></td>
								    </tr>

                                    <tr>
                                      <td>&nbsp;</td>
                                      <td><label></label></td>
								    </tr>
                                    <tr>
                                      <td>Finish Goods Sales Ledger Account:</td>
                                      <td>
                                        <input name="sales_ledger" type="text" id="sales_ledger" value="<?=$sales_ledger?>" size="25" maxlength="50" class="required" required  pattern=".{16,16}"/></td>
								    </tr>
                                    <tr>
                                      <td>Sales Cash Discount: </td>
                                      <td><input name="sales_cash_discount" type="text" id="sales_cash_discount" size="25" maxlength="50" class="required"  required  pattern=".{16,16}" value="<?=$sales_cash_discount?>"/>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>Finish Goods Sales Return: </td>
                                      <td>
                                        <input name="liabilities_class" type="text" id="liabilities_class" size="25" maxlength="50" class="required"/></td>
                                    </tr>
                                    <tr>
                                      <td>Damage Receive (Party):</td>
                                      <td>
                                        <input name="damage_head" type="text" id="damage_head" size="25" maxlength="50" class="required" value="<?=$damage_head?>"/></td>
                                    </tr>
                                                  <tr>
                                        <td>Damage Re-Process: </td>
                                        <td>
                                          <input name="inventory" type="text" id="inventory" size="25" maxlength="50" class="required"/></td>
                                    </tr>
                                    <tr>
                                      <td>Damage Item Sale: </td>
                                      <td>
                                        <input name="payroll" type="text" id="payroll" size="25" maxlength="50" class="required"/></td>
                                    </tr>
                                    <tr>
                                      <td>Real Estate:</td>
                                      <td>
                                        <input name="real_estate" type="text" id="real_estate" size="25" maxlength="50" class="required"/></td>
                                    </tr>
								     <tr>
                                       <td>Fee:</td>
                                       <td>
                                        <input name="fee" type="text" id="fee" size="25" maxlength="50" class="required"/></td>
                                    </tr>
                                    <tr>
                                      <td>Receivable</td>
                                      <td>
                                        <input name="receivable" type="text" id="receivable" size="25" maxlength="50" class="required"/></td>
                                    </tr>
                                    <tr>
                                      <td>Payable:</td>
                                      <td>
                                        <input name="payable" type="text" id="payable" size="25" maxlength="50" class="required"/></td>
                                    </tr>
								    <tr>
                                      <td>Collection Bank Head:</td>
                                      <td>
                                        <input name="collection_bank_head" type="text" id="collection_bank_head" size="25" maxlength="50" class="required"/></td>
                                    </tr>
                                  </table>
                                </div></td>
                              </tr>
                                
                              <tr>
                                <td colspan="2">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="4">
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="65%"><input name="modify" type="submit" id="modify" value="Modify" class="btn"/></td>
                                      <td width="35%">&nbsp;</td>
                                    </tr>
                                  </table>
							    </div>								  </td>
                              </tr>
        </table>
    </form></td>
  </tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>