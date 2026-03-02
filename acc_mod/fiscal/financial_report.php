<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


$title='Financial Report';

do_calander("#f_date");
do_calander("#t_date");

$tr_type="Show";
?>



<div class="d-flex justify-content-center">
    <form class="n-form1 fo-width pt-4" action="master_report_new.php" autocomplete="off" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left"></div>
				
				
				<fieldset class="scheduler-border">
   					 <legend class="scheduler-border">Comparative Report</legend>

		
						<div class="form-check">
							<input name="report" type="radio" class="radio1" id="report1-btn" value="C1001" checked="checked" tabindex="1"/>
							<label class="form-check-label p-0" for="report1-btn">
							   Profit & Loss
							</label>
						</div>
						
						<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="C1002"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                       Financial Statement
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="C1003"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                       Equity Statement
                    </label>
                </div>
				
				
				
				</fieldset>
				
				<fieldset class="scheduler-border">
   					 <legend class="scheduler-border">Non-comparative Report</legend>

		
						<div class="form-check">
							<input name="report" type="radio" class="radio1" id="report1-btn" value="NC1001" checked="checked" tabindex="1"/>
							<label class="form-check-label p-0" for="report1-btn">
							   Profit & Loss
							</label>
						</div>
						
						<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="NC1002"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                       Financial Statement
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="NC1003"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                       Cash Flow Statement
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="NC1004"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                       Equity Statement
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="NC1005"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                       Receipt & Payment Statement
                    </label>
                </div>
				
				</fieldset>
				
				
				
				
				
				
            </div>

            <div class="col-sm-7">
			
			<fieldset class="scheduler-border">
   					 <legend class="scheduler-border">Actual Timeline</legend>
					 
					 <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Company</label>
                    <div class="col-sm-8 p-0">
                      <select name="group_for_actual" id="group_for_actual" class="form-control" required>
										  <option></option>
										  <? foreign_relation('user_group','id','group_name',$_POST['group_for_actual'],'status=1')?>
										  </select>
                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Fiscal Year</label>
                    <div class="col-sm-8 p-0">
                      <select name="fiscal_year" id="fiscal_year" class="form-control" required>
										  <option></option>
										  <? foreign_relation('fiscal_year','id','fiscal_year',$_POST['fiscal_year'],'status="Active"')?>
										  </select>
                    </div>
                </div>
				
				
				</fieldset>
				
				<fieldset class="scheduler-border">
   					 <legend class="scheduler-border">Comparative Timeline</legend>
					 
				 <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Company</label>
                    <div class="col-sm-8 p-0">
                      <select name="group_for_com" id="group_for_com" class="form-control">
										  <option></option>
										  <? foreign_relation('user_group','id','group_name',$_POST['group_for_com'],'status=1')?>
										  </select>
                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Fiscal Year</label>
                    <div class="col-sm-8 p-0">
                      <select name="fiscal_year2" id="fiscal_year2" class="form-control">
										  <option></option>
										  <? foreign_relation('fiscal_year','id','fiscal_year',$_POST['fiscal_year2'],'status="Active"')?>
										  </select>
                    </div>
                </div>
				</fieldset>
				

                <!--<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date</label>
                    <div class="col-sm-8 p-0">
                     <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control">
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                     <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control">
                      </span>

                    </div>
                </div>-->

            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" />
        </div>
    </form>
</div>




<!--<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td width="6%"><input name="report" type="radio" class="radio" value="1" /></td>
                                <td width="94%"><div align="left">Purchase Order Summary</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1005" /></td>
                                <td><div align="left">Present Stock Summary</div></td>
                              </tr>-->
                              
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
                                <td><div align="left">Purchase Receive Report (PO Wise)</div></td>
                              </tr>-->
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">Purchase Receive Report</div></td>
                              </tr>-->
                       <!--       <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">View Purchase Order(Single)</div></td>
                              </tr>-->
                   <!--       </table></td>
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
                    <td>Prepared By:</td>
                    <td><select name="by" id="by" class="form-control">
					  <option></option>-->
<?php /*?><? 
$sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";
advance_foreign_relation($sql,$by);	  
?>
</select></td>
                  </tr>
                  <tr>
                    <td>Product Sub Category: </td>
                    <td><select name="sub_group_id" id="sub_group_id" class="form-control">
					  <option></option>
				<? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$data->sub_group_id);?>
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
				  <tr>
                    <td>Vendor Name: </td>
                    <td><select name="vendor_id" id="vendor_id" class="form-control">
                        <option></option>
                        <? 
						$sql = "select v.vendor_id,concat(v.vendor_name,'-',g.group_name) from vendor v,user_group g where v.group_for=g.id order by v.vendor_name";
						foreign_relation_sql($sql);?>
                    </select></td>
                  </tr>
					
				  <tr>
				    <td>Purchase Order Status:</td>
				    <td><select name="status" id="status" class="form-control">
					    <option value="">All</option>
                        <option value="CHECKED">CHECKED</option>
                        <option value="UNCHECKED">UNCHECKED</option>
					    <option value="DONE">DONE</option>
			        </select></td>
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
              <td><input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form><?php */?>
<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>