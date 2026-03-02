<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Material Requisition Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('item_info','item_name','item_id','1 and product_nature="Salable"','item_id');
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
                              <td colspan="2" class="title1"><div align="left">Issue  Report </div></td>
                            </tr>
                            <tr>
                              <td width="6%"><input name="report" type="radio" class="radio" value="5" checked="checked" /></td>
                              <td width="94%"><div align="left">Material Requisition Report</div></td>
                            </tr>
                            
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Item Name:</td>
                    <td><input type="text" name="item_id" id="item_id" style="width:250px" class="form-control" /></td>
                  </tr>
                  <tr>
                    <td>Item Brand: </td>
                    <td><select name="item_brand" id="item_brand" style="width:250px" class="form-control" >
                      <option></option>
                      <? foreign_relation('item_sub_group','item_brand','item_brand');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>From:</td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" style="width:250px" class="form-control" /></td>
                  </tr>
                  <tr>
                    <td>To:</td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" style="width:250px" class="form-control" /></td>
                  </tr>
                  <tr>
                    <td>To Warehouse: </td>
                    <td><select name="warehouse_id" id="warehouse_id" style="width:250px" class="form-control" >
                      <option></option>
					  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="SD"');?>
                    </select></td>
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
              <td><input name="submit" type="submit" class="btn btn-success" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>