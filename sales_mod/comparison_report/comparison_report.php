<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Comparison Sales Reports';



do_calander("#f_date");

do_calander("#t_date");



//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

//auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');


auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');?>



<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>


      <td><div class="box4" style="width:950px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>

                          
																					 
																					 <!--<tr>

							  															  <td><input name="report" type="radio" class="radio" value="3333" checked="checked" /></td>

																							<td><div align="left">MONTHLY DEALER WISE SALES REPORT (VALUE) </div></td>
																					 </tr>
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="333311" /></td>

																							<td><div align="left">MONTHLY DEALER WISE SALES REPORT (QUANTITY) </div></td>
																					 </tr>-->
																					 
																					 <!--<tr>

							  															  <td><input name="report" type="radio" class="radio" value="333333" /></td>

																							<td><div align="left">MONTHLY PRODUCT VALUE WISE SALES REPORT</div></td>
																					 </tr>
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="33333311" /></td>

																							<td><div align="left">MONTHLY PRODUCT QTY WISE SALES REPORT</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="33333322" /></td>

																							<td><div align="left">MONTHLY PRODUCT GROUP WISE SALES REPORT (VALUE)</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="33333344" /></td>

																							<td><div align="left">MONTHLY PRODUCT GROUP WISE SALES REPORT (QUANTITY)</div></td>
																					 </tr>-->
																					 
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20060201" checked="checked" /></td>

																							<td><div align="left">PRODUCT WISE SALES REPORT</div></td>
																					 </tr>
																					 
																					 <!--<tr>

							  															  <td><input name="report" type="radio" class="radio" value="20060202" /></td>

																							<td><div align="left">PRODUCT GROUP WISE SALES REPORT</div></td>
																					 </tr>-->
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20060203" /></td>

																							<td><div align="left">CONSOLIDATED SALES REPORT CUSTOMER WISE</div></td>
																					 </tr>
																					 
																					 
																					  <tr>
							  															  <td><input name="report" type="radio" class="radio" value="201201" /></td>

																							<td><div align="left">Monthly Sales Report</div></td>
																					 </tr>
																					
																					 
																					 
																					 <!--<tr>

							  															  <td><input name="report" type="radio" class="radio" value="2006020311" /></td>

																							<td><div align="left">DEALER WISE SALES REPORT DETAIL</div></td>
																					 </tr>-->
																					 
																					 
																					<!-- <tr>

							  															  <td><input name="report" type="radio" class="radio" value="2006020322" /></td>

																							<td><div align="left">CUSTOMER TO CUSTOMER COMPARISON (PRODUCT WISE)</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="2006020333" /></td>

																							<td><div align="left">CUSTOMER TO CUSTOMER COMPARISON (PRODUCT GROUP WISE) </div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="2006020344" /></td>

																							<td><div align="left">CUSTOMER TO CUSTOMER SALES REPORT (PRODUCT WISE)</div></td>
																					 </tr>-->
																					 
																				



                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                 

                  <!--<tr>

                    <td>Product Name : </td>

                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>

                  </tr>-->
				  
				 <!-- <tr>

                    <td>Item Mother Group:</td>

                    <td><span class="oe_form_group_cell">

                      <select name="item_mother_group" id="item_mother_group"  onchange="getData2('item_mother_group_ajax.php', 'mother_group', this.value, 
document.getElementById('item_mother_group').value);">

                      <option></option>

                        <? foreign_relation('item_mother_group','id','mother_group_name',$item_mother_group);?>

                      </select>

                    </span></td>

                  </tr>-->
				  
				  <tr>

                    <td>Item Group: </td>

                    <td>
					<span id="mother_group">
					<select name="item_group" id="item_group"  onchange="getData2('item_sub_group_ajax.php', 'sub_group', this.value, 
document.getElementById('item_group').value);">

                      <option></option>
                      <? foreign_relation('item_group','group_id','group_name',$item_group, '1');?>

                    </select>
					</span></td>
                  </tr>
				  
				  
				  
				  <tr>

                    <td>Item Sub Group: </td>

                    <td>
					<span id="sub_group">
					<select name="item_sub_group" id="item_sub_group">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, "1");?>

                    </select></span></td>
                  </tr>
				  
				  <tr>

                    <td>Sales Type:</td>

                    <td><select name="sales_type" id="sales_type"  >

                      <option></option>

                      <? foreign_relation('sales_type','id','sales_type',$sales_type,' 1 order by sales_type');?>

                    </select></td>

                  </tr>
				  
				  

				  

                  <tr>

                    <td>From: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				  <tr>

                    <td>Customer Name:</td>

                    <td>

                    <input  name="dealer_code" type="text" id="dealer_code"/>

                    </td>

                  </tr>
				  
				  
				  
				  

					

				 

                 <!-- <tr>

                    <td>Zone Name:</td>

                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                      <option></option>

                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_id,' 1 order by ZONE_NAME');?>

                    </select></span></td>

                  </tr>-->

                  <!--<tr>

                    <td>Area Name:</td>

                    <td><span id="area"><select name="area_id" id="area_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                    <option></option>

                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$area_id,' 1 order by AREA_NAME');?>

                    </select></span></td>

                  </tr>-->

                  <tr>

                    <td>Warehouse Name:</td>

                    <td>

                      <select name="depot_id" id="depot_id" >
					  
					  <option></option>


                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'1');?>

                      </select>

                    </td>

                  </tr>
				  
				  
				  <!--<tr>
                    <td>Company:</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select class="form-control" name="group_for" id="group_for" >
                        <option></option>
                        <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                      </select>
                      </span></td>
                  </tr>-->

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