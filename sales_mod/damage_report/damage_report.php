<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Damage Advence Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');
?>

<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
          <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>
                              <tr>
							  <td><input name="report" type="radio" class="radio" value="3" checked="checked" /></td>
                                <td><div align="left">Damage Report  Summary </div></td>
                                
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2" /></td>
                                <td><div align="left">Damage Report  Dealer Wise</div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="1" /></td>
                                <td width="94%"><div align="left">Item Wise Damage Report </div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>Product Sales Group :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="product_group" id="product_group">
                      <option></option>
                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Product Brand : </td>
                    <td><select name="item_brand" id="item_brand">
                                          <option></option>
                                          <option value="Tang">Tang</option>
                                          <option value="Bourn Vita">Bourn Vita</option>
                                          <option value="Oreo">Oreo</option>
                                          <option value="Shezan">Shezan</option>
                                          <option value="Promotional">Promotional</option>
                                          <option value="Top">Top</option>
                                          <option value="Kolson">Kolson</option>
                                          <option value="Nocilla">Nocilla</option>
                                          <option value="Sajeeb">Sajeeb</option>
                                        </select></td>
                  </tr>
                  <tr>
                    <td>Product Name : </td>
                    <td><select name="item_id" id="item_id">
                        <option></option>
                        <? foreign_relation('item_info','item_id','item_name',$data->item_id,'product_nature="Salable"');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>
                  </tr>
                  <tr>
                    <td>To : </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>
				  <tr>
                    <td>Dealer Name :</td>
                    <td>
                    <input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/>                    </td>
                  </tr>
                  <tr>
                    <td>Depot From :</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select name="depot_id" id="depot_id" style="width:150px;">
					  <option></option>
					  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$receive_type,' use_type="SD"');?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Damage Type :</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select name="receive_type" style="width:50px;">
<option></option>
<? foreign_relation('damage_cause','id','damage_cause',$receive_type);?>
</select>
                    </span></td>
                  </tr>
              </table></td>
            </tr>
          </table>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div class="box">
        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><input name="submit" type="submit" class="btn" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>