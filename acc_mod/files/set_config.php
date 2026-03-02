<?php
session_start();
ob_start();
require_once "../support/inc.all.php";
$title='Set Configaration';
if(isset($_REQUEST['proj_id'])||isset($_REQUEST['vat_percentage']))
{
		$proj_id				= mysqli_real_escape_string($_SESSION['proj_id']);
		//common part.............
		$vat_percentage			= mysqli_real_escape_string($_REQUEST['vat_percentage']);
		$voucher_format			= mysqli_real_escape_string($_REQUEST['voucher_format']);
		$extended_module_no		= mysqli_real_escape_string($_REQUEST['extended_module_no']);
		$under_group_calculation= mysqli_real_escape_string($_REQUEST['under_group_calculation']);
		$inventory_module		= mysqli_real_escape_string($_REQUEST['inventory_module']);
		$payroll_module			= mysqli_real_escape_string($_REQUEST['payroll_module']);
		$budget_module			= mysqli_real_escape_string($_REQUEST['budget_module']);
		$advance_reporting_module= mysqli_real_escape_string($_REQUEST['advance_reporting_module']);
		$invoice_auto_voucher	= mysqli_real_escape_string($_REQUEST['invoice_auto_voucher']);

	
	//for Modify..................................
	
	if(isset($_REQUEST['mgroup']))
	{
	
		$sql="UPDATE `config` SET 
			 `vat_percentage` = '$vat_percentage',
			 `voucher_format` = '$voucher_format',
			 `extended_module_no` = '$extended_module_no',
			 `under_group_calculation` = '$under_group_calculation',
			 `inventory_module` = '$inventory_module',
			 `payroll_module` = '$payroll_module',
			 `budget_module` = '$budget_module',
			 `advance_reporting_module` = '$advance_reporting_module',
			 `invoice_auto_voucher` = '$invoice_auto_voucher'
			 WHERE `proj_id` = '$proj_id' LIMIT 1";
		$qry=db_query($sql);
		$type=1;
		$msg='Successfully Updated.';
	}
$data=mysqli_fetch_row(db_query("select * from config where 1"));
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td><div class="right"><form action="set_config.php?proj_id=<?php echo $data[0];?>" method="post" enctype="multipart/form-data" name="form2" id="form2">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td colspan="2"><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>VAT Percentage:</td>
                                        <td><input name="vat_percentage" type="text" id="vat_percentage" value="<?php echo $data[1];?>" size="25" maxlength="50" class="required" minlength="2" /></td>
									  </tr>

                                      <tr>
                                        <td>Voucher Format:</td>
                                        <td><label>
                                          <select name="voucher_format" id="voucher_format">
										  <option <? if($data[2]=='1') echo 'selected';?> value="1">Format 1</option>
										  <option <? if($data[2]=='2') echo 'selected';?> value="2">Format 2</option>
                                        </select>
                                        </label></td>
									  </tr>
                                      <tr>
                                        <td>Extended Module no:</td>
                                        <td><select name="extended_module_no" id="extended_module_no">
										  <option <? if($data[3]=='') echo 'selected';?> value="">No Extended Module</option>
                                          <option <? if($data[3]=='1') echo 'selected';?> value="1">Extended Module 1</option>
										  <option <? if($data[3]=='2') echo 'selected';?> value="2">Extended Module 2</option>
                                          </select></td>
									  </tr>
                                      <tr>
                                        <td>Under Group:</td>
                                        <td><select name="under_group_calculation" id="under_group_calculation">
                                            <option <? if($data[4]=='YES') echo 'selected';?> value="YES">Activate</option>
                                            <option <? if($data[4]=='NO') echo 'selected';?> value="NO">Inactivate</option>
                                          </select></td>
                                      </tr>
                                      <tr>
                                        <td>Inventory Module:</td>
                                        <td><select name="inventory_module" id="inventory_module">
                                            <option <? if($data[5]=='YES') echo 'selected';?>>YES</option>
                                            <option <? if($data[5]=='NO') echo 'selected';?>>NO</option>
                                          </select></td>
                                      </tr>
                                      <tr>
                                        <td>Payroll Module:</td>
                                        <td><select name="payroll_module" id="payroll_module">
                                            <option <? if($data[6]=='YES') echo 'selected';?>>YES</option>
                                            <option <? if($data[6]=='NO') echo 'selected';?>>NO</option>
                                          </select></td>
                                      </tr>
                                      <tr>
                                        <td>Budget Module:</td>
                                        <td><select name="budget_module" id="budget_module">
                                            <option <? if($data[7]=='YES') echo 'selected';?>>YES</option>
                                            <option <? if($data[7]=='NO') echo 'selected';?>>NO</option>
                                          </select></td>
                                      </tr>
                                      <tr>
                                        <td>Advance Reporting:</td>
                                        <td><select name="advance_reporting_module" id="advance_reporting_module">
                                            <option <? if($data[8]=='YES') echo 'selected';?>>YES</option>
                                            <option <? if($data[8]=='NO') echo 'selected';?>>NO</option>
                                          </select></td>
                                      </tr>
                                      <tr>
                                        <td>Invoice Auto Voucher:</td>
                                        <td><select name="invoice_auto_voucher" id="invoice_auto_voucher">
                                            <option <? if($data[9]=='YES') echo 'selected';?>>YES</option>
                                            <option <? if($data[9]=='NO') echo 'selected';?>>NO</option>
                                          </select></td>
                                      </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td colspan="2">
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="65%"><input name="mgroup" type="submit" id="mgroup" value="Modify" class="btn"/></td>
                                      <td width="35%">&nbsp;</td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>