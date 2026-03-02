<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Product Management Report';



do_calander("#f_date");

do_calander("#t_date");

auto_complete_from_db('item_info','item_name','item_id','1','item_id');

auto_complete_from_db('tea_garden','garden_name','garden_id','1','garden_id');

?>



<form action="master_report_product.php" method="post" name="form1" target="_blank" id="form1">

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

                             <!-- <tr>

                              <td colspan="2" class="title1"><div align="left">Select Report </div></td>

                              </tr>

                              <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>

                                <td width="94%"><div align="left">Warehouse  Transection Report</div></td>

                              </tr>

							  <tr>

							    <td><input name="report" type="radio" class="radio" value="1008" /></td>

							    <td><div align="left">Warehouse  Purchase  Report</div></td>

						      </tr>
							  
							 <tr>

							    <td><input name="report" type="radio" class="radio" value="15" /></td>

							    <td><div align="left">Black Tea  Purchased Report (Pkgs Wise)</div></td>

						      </tr>-->
							  
							  <!-- <tr>

							    <td><input name="report" type="radio" class="radio" value="10" /></td>

							    <td><div align="left">Black Tea  Purchased Report</div></td>

						      </tr>
							  
							  
							  
							   <tr>

							    <td><input name="report" type="radio" class="radio" value="12" /></td>

							    <td><div align="left">Black Tea  Purchase Received Report (PO Wise)</div></td>

						      </tr>
							  
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="13" /></td>

							    <td><div align="left">Black Tea  Purchase Received Report (Rec. Date Wise)</div></td>

						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="11" /></td>

							    <td><div align="left">Chittagong Warehouse Stock (Black Tea)</div></td>

						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="14" /></td>

							    <td><div align="left">Black Tea Issue Report (Blend Sheet)</div></td>

						      </tr>

							  <tr>

							    <td><input name="report" type="radio" class="radio" value="8" /></td>

							    <td><div align="left">Warehouse  Transection Report (Entry Wise) </div></td>

						      </tr>

							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>

                                <td width="94%"><div align="left">Warehouse Present Stock</div></td>

                              </tr>

							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="4" /></td>

                                <td width="94%"><div align="left">Warehouse Present Stock (Finish Goods)</div></td>

                              </tr>

							  

							   <tr>

                                 <td><input name="report" type="radio" class="radio" value="10011" /></td>

							     <td><div align="left">Stock Valuation Report (HFL) </div></td>

						      </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="1004" /></td>

							    <td><div align="left">RM Consumtion Report</div></td>

						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="1005" /></td>

							    <td><div align="left">FG Production Report</div></td>

						      </tr>-->

							   <tr>

							    <td><input name="report" type="radio" class="radio" value="11" /></td>

							    <td><div align="left">Product Report</div></td>

						      </tr>
							  
							  <!--<tr>

							    <td><input name="report" type="radio" class="radio" value="2005" /></td>

							    <td><div align="left">Daily Production Report </div></td>

						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="2006" /></td>

							    <td><div align="left">FG Production &amp; Transferred Report</div></td>

						      </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="1001" /></td>

							    <td><div align="left">Stock Valuation Report </div></td>

						      </tr>

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="1003" /></td>

							    <td><div align="left">Material Consumption  Report </div></td>

						      </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="1006" /></td>

							    <td><div align="left">Product Movement Detail Report (FG) </div></td>

						      </tr>

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="1007" /></td>

							    <td><div align="left">Product Movement Summary Report (FG) </div></td>

						      </tr>-->

							  

							   <!--<tr>

                                 <td><input name="report" type="radio" class="radio" value="1009" /></td>

							     <td><div align="left">Daily Chalan Issue Report</div></td>

						      </tr>-->

                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" class="table table-bordered" cellspacing="0" cellpadding="0" align="center">

               

                  <!--<tr>

                    <td>Broker Name: </td>

                    <td><select name="vendor_id" id="vendor_id">
                      <option></option>
                      <? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'vendor_type=3');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Ctg Warehouse: </td>
                    <td><select name="ctg_warehouse" id="ctg_warehouse">
                      <option></option>
                      <? foreign_relation('tea_warehouse','warehouse_id','warehouse_name',$ctg_warehouse);?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Garden Name: </td>
                    <td><input type="text" name="garden_id" id="garden_id" style="width:250px" /></td>
                  </tr>-->
                  <tr>
                    <td>Item Name:</td>
                    <td><input type="text" name="item_id" id="item_id" class="form-control" /></td>
                  </tr>

                  <tr>

                    <td>Item Sub Group: </td>

                    <td><select name="item_sub_group" id="item_sub_group" class="form-control">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>

                    </select></td>
                  </tr>

                  

                 <!--<tr>

                    <td>From:</td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>"/></td>
                  </tr>

                  <tr>

                    <td>To:</td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"/></td>
                  </tr>-->

				  <!-- <tr>

                    <td>Issue Status: </td>

                    <td><select name="issue_status" id="issue_status">

<option value=""></option>

<option value='Sales'>Sales</option>

<option value='Issue'>Issue</option>

<option value='Sample Issue'>Sample Issue</option>

<option value='Gift Issue'>Gift Issue</option>

<option value='Entertainment Issue'>Entertainment Issue</option>

<option value='R & D Issue'>R & D Issue</option>

<option value='Other Issue'>Other Issue</option>

<option value='Staff Sales'>Staff Sales</option>

<option value='Export'>Export Sales</option>

<option value='Other Sales'>Other Sales</option>

<option value='Consumption'>Consumption</option>

                    </select></td>
                  </tr>

					

				  <tr>

				    <td>Receive Status: </td>

				    <td>

					<select name="receive_status" id="receive_status">

<option value=""></option>

<option value='All_Purchase'>All Purchase</option>

<option value='Purchase'>Purchase</option>

<option value='Transfered'>Transfered</option>

<option value='Transit'>Transit</option>

<option value='Receive'>Receive</option>

<option value='Return'>Return</option>

<option value='Opening'>Opening</option>

<option value='Other Receive'>Other Receive</option>

<option value='Local Purchase'>Local Purchase</option>

<option value='Sample Receive'>Sample Receive</option>

<option value='Import'>Import</option>

<option value='Production'>Production</option>
			        </select></td>
			      </tr>-->

                  <tr>

                    <td>Depot Name: </td>

                    <td><select name="warehouse_id" id="warehouse_id" class="form-control">

                      <option selected="selected"></option>

					  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'use_type="SD" or use_type="DM"');?>

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

      <td>

        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><input name="submit" type="submit" class="btn" value="Report" /></td>

            </tr>

          </table>

      </td>

    </tr>

  </table>

</form>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>