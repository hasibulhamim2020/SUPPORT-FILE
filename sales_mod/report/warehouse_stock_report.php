<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Warehouse Advance Report';



do_calander("#f_date");

do_calander("#t_date");

auto_complete_from_db('item_info','item_name','item_id','1','item_id');

auto_complete_from_db('tea_garden','garden_name','garden_id','1','garden_id');

?>



<form action="stock_master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

      <td><div class="box4" style="width:900px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                              <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>

                             <!-- <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>

                                <td width="94%"><div align="left">Warehouse  Transection Report</div></td>
                              </tr>-->
							  
							

							  <!--<tr>

							    <td><input name="report" type="radio" class="radio" value="1008" /></td>

							    <td><div align="left">Warehouse  Purchase  Report</div></td>

						      </tr>-->
							  
							   <!--<tr>

							    <td><input name="report" type="radio" class="radio" value="10" /></td>

							    <td><div align="left">Black Tea  Purchased Report</div></td>
						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="15" /></td>

							    <td><div align="left">Black Tea  Purchased Report (Pkgs Wise)</div></td>
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

							    <td><input name="report" type="radio" class="radio" value="20190910" /></td>

							    <td><div align="left">Factory Warehouse Stock (Black Tea)</div></td>
						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="112" /></td>

							    <td><div align="left">Chittagong Warehouse Stock PKGS Wise</div></td>
						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="14" /></td>

							    <td><div align="left">Black Tea Issue Report (Blend Sheet)</div></td>
						      </tr>
-->
							  <!--<tr>

							    <td><input name="report" type="radio" class="radio" value="8" /></td>

							    <td><div align="left">Warehouse  Transection Report (Entry Wise) </div></td>
						      </tr>-->

							 <!-- <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>

                                <td width="94%"><div align="left">Warehouse Present Stock</div></td>

                              </tr>-->
							  
							<!--  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="22" /></td>

                                <td width="94%"><div align="left">Warehouse Present Stock (Packing Materials)</div></td>
                              </tr>
-->
							<!--  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="4" /></td>

                                <td width="94%"><div align="left">Warehouse Present Stock (Finish Goods)</div></td>
                              </tr>
                              <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="99" /></td>

                                <td width="94%"><div align="left">Warehouse Present Stock (Finish Goods)For Khan Shaheb</div></td>
                              </tr>
							  
							  
							  
							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="444" /></td>

                                <td width="94%"><div align="left">Stock In vs Stock Out Comparison Report</div></td>

                              </tr>-->

							  

							  <!-- <tr>

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

							  
							<!--  
							  <tr>


							    <td><input name="report" type="radio" class="radio" value="2005" /></td>

							    <td><div align="left">Daily Production Report </div></td>
						      </tr>-->
							  
							  <!--<tr>

							    <td><input name="report" type="radio" class="radio" value="2006" /></td>

							    <td><div align="left">Product Movement Report</div></td>
						      </tr>-->
							  
							  
							 <!-- <tr>

							    <td><input name="report" type="radio" class="radio" value="20060201" /></td>

							    <td><div align="left">Product Wise Delivery Report</div></td>
						      </tr>-->
							  
							  
							  <!--<tr>

							    <td><input name="report" type="radio" class="radio" value="20060202" /></td>

							    <td><div align="left">Inventory Analysis (All Transaction Type)</div></td>
						      </tr>-->
							  
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="2006020211" checked="checked" /></td>

							    <td><div align="left">FG Stock Movement Report</div></td>
						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="2006020233"  /></td>

							    <td><div align="left">Stock Transfers Report</div></td>
						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="2006020234"  /></td>

							    <td><div align="left">Warehouse Present Stock Report</div></td>
						      </tr>
							  
							  
							  
							  <!--<tr>

							    <td><input name="report" type="radio" class="radio" value="2006020212" /></td>

							    <td><div align="left">Warehouse Transection Report</div></td>
						      </tr>-->
							  
							  


							<!-- <tr>

							    <td><input name="report" type="radio" class="radio" value="20060203" /></td>

							    <td><div align="left">Damage Inventory Report</div></td>
						      </tr>
							  
							   <tr>

							    <td><input name="report" type="radio" class="radio" value="2006020301" /></td>

							    <td><div align="left">Cumulative Damage Report</div></td>
						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="20060204" /></td>

							    <td><div align="left">Invoice Wise Product Damage Report</div></td>
						      </tr>
							  
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="20060205" /></td>

							    <td><div align="left">Invoice Wise Product Short Report</div></td>
						      </tr>
							  
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="20060206" /></td>

							    <td><div align="left">Invoice Wise Product Excess Report</div></td>
						      </tr>
							  
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="20060207" /></td>

							    <td><div align="left">GDN Wise Product Delivery Report (Sales)</div></td>
						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="20060208" /></td>

							    <td><div align="left">GDN Wise Product Delivery Report (FOC)</div></td>
						      </tr>
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="20060209" /></td>

							    <td><div align="left">GDN Wise Product Delivery Report (SCHEME)</div></td>
						      </tr>-->
							  
							 <!-- <tr>

							    <td><input name="report" type="radio" class="radio" value="130000" /></td>

							    <td><div align="left">Other Received Report (Rec. Date Wise)</div></td>

						      </tr>-->

							  

							 <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="1003" /></td>

							    <td><div align="left">Material Consumption  Report </div></td>

						      </tr>-->

							  <!--<tr>
							    <td><input name="report" type="radio" class="radio" value="1006" /></td>
							    <td><div align="left">Product Movement Detail Report (FG) </div></td>
						      </tr>-->
							  

							  

							 <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="1007" /></td>

							    <td><div align="left">Product Movement Summary Report (FG) </div></td>

						      </tr>
-->
							  

							   <!--<tr>

                                 <td><input name="report" type="radio" class="radio" value="1009" /></td>

							     <td><div align="left">Daily Chalan Issue Report</div></td>

						      </tr>-->

                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
                  </tr>

                 <!-- <tr>

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
                  <!--<tr>
                    <td>Item Name:</td>
                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>
                  </tr>-->
				  
				  
				  
				  <tr>

                    <td>Product Group:</td>

                    <td><span class="oe_form_group_cell">

                      <select name="group_id" id="group_id"  tabindex="3" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value, 

document.getElementById('group_id').value);">

                        <option></option>

                        <? foreign_relation('item_group','group_id','group_name',$group_id,'1');?>

                      </select>

                      </span></td>

                  </tr>
				  
				  
				  
				  

                  <tr>

                    <td>Product Sub Group:</td>

                    <td><span class="oe_form_group_cell">
					
					<span id="item_sub_group">

                      <select name="sub_group_id" id="sub_group_id" tabindex="4"  >

                        <option></option>

                        <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$sub_group_id, '1');?>

                      </select>

                      </span></span></td>

                  </tr>
				  
				  
				  <tr>

                    <td>Price Type:</td>

                    <td><span class="oe_form_group_cell">

                      <select name="price_type" id="price_type" tabindex="4"  >

                        <option></option>

                        <? foreign_relation('stock_price_type','id','price_type',$price_type, '1');?>

                      </select>

                     </span></td>

                  </tr>
				  
				  
				  

                  <!--<tr>

                    <td>Product Group: </td>

                    <td><select name="sales_item_type" id="sales_item_type">

                      <option></option>

                      <option>A</option>

					  <option>B</option>

					  <option>C</option>

                      <option>D</option>

                    </select></td>
                  </tr>-->

                  <tr>

                    <td>From:</td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>"/></td>
                  </tr>

                  <tr>

                    <td>To:</td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"/></td>
                  </tr>

				  <?php /*?><tr>

                    <td>Issue Status: </td>

                    <td><select name="issue_status" id="issue_status">

<option value=""></option>

<option value='Sales'>Sales</option>

<option value='Issue'>Issue</option>

<option value='Sample Issue'>Sample Issue</option>

<option value='Gift Issue'>Gift Issue</option>

<option value='Entertainment Issue'>Entertainment Issue</option>


<option value='Other Issue'>Other Issue</option>

<option value='Staff Sales'>Staff Sales</option>

<option value='Export'>Export Sales</option>

<option value='Other Sales'>Other Sales</option>

<option value='Consumption'>Consumption</option>

                    </select></td>
                  </tr><?php */?>

					

				  <?php /*?><tr>

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
<!--
<option value='Sample Receive'>Sample Receive</option>

<option value='Import'>Import</option>

<option value='Production'>Production</option>-->
			        </select></td>
			      </tr><?php */?>
				  
				  
				  
				  
				  
				   <!--<tr>

                    <td>Transection Type: </td>

                    <td><select name="tr_from" id="tr_from">

<option value=""></option>

<option value='Opening'>Opening</option>

<option value='Receive'>Production Receive</option>

<option value='Transfered'>Warehouse Transfered</option>

<option value='Sales'>Sales</option>

<option value='Sales Return'>Sales Return</option>


                    </select></td>
                  </tr>-->
				  
				  
				  
				  
				  <tr>

                    <td>Company: </td>

                    <td><select name="group_for" id="group_for" >
					
					<option></option>

                      

					  <? foreign_relation('user_group','id','group_name',$group_for,'1 ');?>

                    </select></td>
                  </tr>
				  
				  

                  <tr>

                    <td>Warehouse Name: </td>

                    <td><select name="warehouse_id" id="warehouse_id" >
					
					<option></option>

                      

					  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1 ');?>

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

              <td><input name="submit" type="submit" class="btn" value="Report" /></td>

            </tr>

          </table>

      </div></td>

    </tr>

  </table>

</form>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>