<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Return Report';

do_calander("#f_date");
do_calander("#t_date");
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
                                <td width="6%"><input name="report" type="radio" class="radio" value="1100" /></td>
                                <td width="94%"><div align="left">Sales Return Report</div></td>
                              </tr>
                              
                             <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="2" /></td>
                                <td><div align="left">Purchase Receive Report(PO Wise)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Purchase Receive Report(Date Wise)</div></td>
                              </tr>-->
                            <!--  <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Purchase History Report</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">Purchase Receive Report</div></td>
                              </tr>-->
                       <!--       <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">View Purchase Order(Single)</div></td>
                              </tr>-->
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
                  <?php /*?><tr>
                    <td>Prepared By:</td>
                    <td><select name="by" id="by" class="form-control">
					  <option></option>
<? 
$sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";
advance_foreign_relation($sql,$by);	  
?>
</select></td>
                  </tr><?php */?>
                  <tr>
                    <td>Dealer Name: </td>
                    <td><select name="dealer_code" id="dealer_code" class="form-control">
					  <option></option>
				<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$data->dealer_code);?>
			</select></td>
                  </tr>
                  <tr>
                    <td>Product Name: </td>
                    <td><select name="item_id" id="item_id" class="form-control">
                        <option></option>
                      
						<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>From: </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control"></td>
                  </tr>
                  <tr>
                    <td>To: </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control"></td>
                  </tr>
				 <?php /*?> <tr>
                    <td>Vendor Name: </td>
                    <td><select name="vendor_id" id="vendor_id" class="form-control">
                        <option></option>
                        <? 
						$sql = "select v.vendor_id,concat(v.vendor_name,'-',g.group_name) from vendor v,user_group g where v.group_for=g.id order by v.vendor_name";
						foreign_relation_sql($sql);?>
                    </select></td>
                  </tr><?php */?>
					
				  <?php /*?><tr><td>Status: </td>
				          <td><select name="status" id="status" class="form-control">
					  <option></option>
<? 
$sql="SELECT a.or_no,a.status FROM `warehouse_other_receive` a WHERE status='checked' or status='unchecked' or status='manual' group by status";
advance_foreign_relation($sql,$status);	  
?>
</select></td><?php */?>
			      </tr>
				  <!--<tr>
                    <td>Purchase Order No: </td>
                    <td><input  name="wo_id" type="text" id="wo_id" value=""/></td>
                  </tr>-->
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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