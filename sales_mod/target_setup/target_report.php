<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Target Reports';



$tr_type="Show";

$php_ip=substr($_SESSION['php_ip'],0,11);

if($php_ip=='115.127.35.' || $php_ip=='192.168.191'){ 

do_calander('#f_date'/*,'-1800','0'*/);

do_calander('#t_date'/*,'-1800','30'*/);

} else {

	do_calander('#f_date'/*,'-60','0'*/);

	do_calander('#t_date'/*,'-60','0'*/);		

}

//create_combobox("dealer_code");





do_calander("#cut_date");

//auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');
//
//auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<6000','item_id');


?>









<div class="d-flex justify-content-center">

    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">

        <div class="row m-0 p-0">

            <div class="col-sm-7">

                <div align="left">Select Report </div>

              <div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="404" checked="checked" />

                    <label class="form-check-label p-0" for="report1-btn">SR Wise Target Reports</label>

                    </div>

			  <div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="505"  />

                    <label class="form-check-label p-0" for="report1-btn">SR Wise Target Achieve Reports</label>

                    </div>
					
					<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="606"  />

                    <label class="form-check-label p-0" for="report1-btn">Distributor Wise Target Reports</label>

                    </div>
					
					<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="707"  />

                    <label class="form-check-label p-0" for="report1-btn">Distributor Wise Target Achieve Reports</label>

                    </div>

                



            </div>



            <div class="col-sm-5">

                

				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Depot Name:</label>

                    <div class="col-sm-8 p-0">

                        <input list="yyye" name="depot_id" id="depot_id" type="text" autocomplete="off">

						 <datalist id="yyye">
						  <? foreign_relation('dealer_info','dealer_code','dealer_name_e','','cust_category_name=1');?>

						</datalist>

                    </div>

                </div>

                

				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Distributor Name:</label>

                    <div class="col-sm-8 p-0">

                        <input list="yyy" name="dealer_code" id="dealer_code" type="text" autocomplete="off">

						 <datalist id="yyy">
						  <? foreign_relation('dealer_info','dealer_code','dealer_name_e','','cust_category_name in(2,3)');?>

						</datalist>

                    </div>

                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">SR Name:</label>

                    <div class="col-sm-8 p-0">

                        <input list="yy" name="sales_person" id="sales_person" type="text" autocomplete="off">

						 <datalist id="yy">
						  <? foreign_relation('ss_user','user_id','concat(fname,"##",point_id)','','1');?>

						</datalist>

                    </div>

                </div>

				





                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>

                    <div class="col-sm-8 p-0">

                      <span class="oe_form_group_cell">

                        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/>

                      </span>



                    </div>

                </div>



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>

                    <div class="col-sm-8 p-0">



                        <input  name="t_date" type="text" id="t_date" value=""/>





                    </div>

                </div>

            </div>



        </div>

        <div class="n-form-btn-class">

			

            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />

        </div>

    </form>

</div>









<?php /*?><form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="box4">

          <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top">

					<table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report -<?=$_SESSION['ip'];?>-<?=$_SESSION['php_ip']?></div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>

                                <td><div align="left">Sales Order Report(1)</div></td>

                              </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="301" /></td>

                                <td><div align="left">DO Pending Brief Report(301)</div></td>

								</tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="1991" /></td>

                                <td><div align="left">Delivery Order Brief Report with Chalan Amount(1991)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="1992" /></td>

                                <td><div align="left">Sales Statement(As Per DO)(1992)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="1993" /></td>

                                <td><div align="left">Party Collection Summery Group wise(1993)</div></td>

                              </tr>							  

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="191" /></td>

                                <td><div align="left">Delivery Order  Report (At A Glance)(191)</div></td>

                              </tr><?php */?>

                            <!--  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>

                                <td width="94%"><div align="left">Delivered Do Details Report(2)</div></td>

                              </tr>

                              

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="3" /></td>

                                <td><div align="left">Delivered Do Report Dealer Wise(3)</div></td>

                              </tr>

                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="4" /></td>

                                <td><div align="left">Chalan Report(Chalan Date Wise)(4)</div></td>

                              </tr>-->

                             <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="5" /></td>

                                <td><div align="left">Delivery Order Brief Report(Region Wise)(5)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="7" /></td>

                                <td><div align="left">Item Wise DO Report(7)</div></td>

                              </tr>

          <tr>

            <td><input name="report" type="radio" class="radio" value="15" /></td>

              <td><div align="left">Item Wise DO Report(Modern Trade)(15)</div></td>

               </tr>

                              

<tr>

<td>&nbsp;</td>

<td>&nbsp;</td>

</tr>

							  

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="707" /></td>

                                <td><div align="left">Party Wise Undelivered DO List(707)</div></td>

                              </tr>

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="702" /></td>

                                <td><div align="left">Party Wise Undelivered DO Report(ALL)(702)</div></td>

                              </tr>

							  

							 <tr>

                                <td><input name="report" type="radio" class="radio" value="707" /></td>

                                <td><div align="left">Party Wise Undelivered DO List(707)</div></td>

                              </tr>

							  

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="703" /></td>

                                <td><div align="left">Order  Wise Undelivered Report(703)</div></td>

                              </tr>

                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="701" /></td>

                                <td><div align="left">Item Wise Undelivered DO Report(With Gift)(701)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="7011" /></td>

                                <td><div align="left">Item Wise Undelivered DO Report(Without Gift)(7011)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="7012" /></td>

                                <td><div align="left">Item Wise Undelivered Supershop Report(7012)</div></td>

                              </tr>

                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="704" /></td>

                                <td><div align="left">Storewise Item Undelivered Report-Cash(704)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="705" /></td>

                                <td><div align="left">Storewise Item Undelivered Report-Ctn(without Gift)(705)</div></td>

                              </tr>

                              <tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="706" /></td>

                                <td><div align="left">Storewise Item Undelivered Short Report-Ctn(706)</div></td>

                              </tr>

                              <tr>

							  

						  

							  

							  

<td>&nbsp;</td>

<td>&nbsp;</td>

</tr>-->

                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="14" /></td>

                                <td><div align="left">Item DO Report (Region)(14)</div></td>

                              </tr>-->

                             <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="9" /></td>

                                <td><div align="left">Item DO Report (Region+Zone)(Dealer Group)(9)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="41" /></td>

                                <td><div align="left">Item DO Report (Region+Zone)(Item Group)(41)</div></td>

                              </tr>

                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>-->

                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="6" /></td>

                                <td><div align="left">View DO (Single)(6)</div></td>

                              </tr>-->

                             <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="8" /></td>

                                <td><div align="left">Dealer Performance Report(8)(Region + Zone)(Dealer Group)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="10" /></td>

                                <td><div align="left">Daily Collection Summary(10)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="13" /></td>

                                <td><div align="left">Daily Collection Summary(Ext)(13)</div></td>

                              </tr>-->

<!--                              <tr>

                                <td><input name="report" type="radio" class="radio" value="11" /></td>

                                <td><div align="left">Daily Collection and Order Summary(11)</div></td>

                              </tr>-->

                              

                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="21" /></td>

                                <td><div align="left">Over DO Report(21)</div></td>

                              </tr>-->

                              <!--<tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>-->

                           <!--   <tr>

                                <td><input name="report" type="radio" class="radio" value="1999" /></td>

                                <td><div align="left">DO Report for Scratch Card(1999)</div></td>

                              </tr>-->

                              

                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="2000" /></td>

                                <td><div align="left">DO Summery Report Region Wise(2000)</div></td>

                              </tr>

                              

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="2001" /></td>

                                <td><div align="left">Item Wise Chalan Details Report(DO Entry Date)(At A Glance)(2001)</div></td>

                              </tr>

                              

							                <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>



                              <tr>

                                <td><input name="report" type="radio" class="radio" value="2010" /></td>

                                <td><div align="left">Secondary Sales Summery Report Region Wise(2010)</div></td>

                              </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="2011" /></td>

                                <td><div align="left">Item Secondary DO Report (Region+Zone)(Dealer Group)(2011)</div></td>

                              </tr>

                               <tr>

                                <td><input name="report" type="radio" class="radio" value="2012" /></td>

                                <td><div align="left">Item Wise Secondary Stock Report (Dealer)(Item)(2012)</div></td>

                              </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="2013" /></td>

                                <td><div align="left">Dealer Wise Secondary DO Report (2013)</div></td>

                              </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="2014" /></td>

                                <td><div align="left">Order  Wise SO,TSM Report(2014)</div></td>

                              </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="2015" /></td>

                                <td><div align="left">Item Wise Secondary Sales Report(2015)</div></td>

                              </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="2016" /></td>

                                <td><div align="left">SO,TSM Wise Sales Report(2016)</div></td>

                              </tr>

							  

                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

							  

							                <tr>

                                <td><input name="report" type="radio" class="radio" value="10041" /></td>

                                <td><div align="left">Storewise DO Item Order Report(10041)</div></td>

                              </tr>-->

							  

							  

                          <?php /*?></table></td>

                        </tr>

                    </table>

					</td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><?php */?>

                  <?php /*?><tr>

                    <td>Product Sales Group :</td>

                    <td><span class="oe_form_group_cell">

                      <select name="product_group" id="product_group">

                      <option></option>

                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP,'1 order by group_name');?>

						<option>ABCDE</option>

                      </select>

                    </span></td>

                  </tr>

                  <tr>

                    <td>Product Brand : </td>

                    <td>                      <select name="item_brand" id="item_brand">

                      <option></option>

                        <? foreign_relation('item_brand','brand_name','brand_name',$item_brand,'1 order by brand_name');?>

                      </select></td>

                  </tr><?php */?>

                  <?php /*?><tr>

                    <td>Product Name : </td>

                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>

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

                    <td>Dealer Name:</td>

                    <td><select name="dealer_code" id="dealer_code">

                      <option></option>

                      <? foreign_relation('dealer_info','dealer_code','dealer_name_e');?>

                    </select></td>

                  </tr><?php */?>

				  <?php /*?><tr>

                    <td>Dealer Name :</td>

                    <td>

                       

					<select name="dealer_code" id="dealer_code">

					<option></option>

					<?=foreign_relation('dealer_info','dealer_code','dealer_name_e');?>

					

					</select>                </td>

                  </tr><?php */?>

					

				 <?php /*?> <tr>

				    <td>Dealer Type :</td>

				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

				      <select name="dealer_type" id="dealer_type" style="width:150px;">

                      <option></option>

				        <option value="Distributor">Distributor</option>

				        <option value="Corporate">Corporate</option>

                        <option value="SuperShop">SuperShop</option>

                        <option value="TradeFair">TradeFair</option>

                        <option value="MordernTrade">SuperShop+Corporate+M-Group</option>

			          </select>

				    </span></td>

			      </tr>

				  <tr>

				    <td>DO Status :</td>

				    <td><select name="status" id="status">

					    <option value="">All</option>

                        <option value="CHECKED">PROCESSION</option>

                        <option value="UNCHECKED">UNCHECKED</option>

					    <option value="DONE">DONE</option>

			        </select></td>

			      </tr>

				  <tr>

                    <td>DO No: </td>

                    <td><input  name="do_no" type="text" id="do_no" value=""/></td>

                  </tr>

                  <tr>

                    <td>Region Name :</td>

                    <td><span id="branch" class="oe_form_group_cell">

                      <select name="region_id" id="region_id" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">

                        <option></option>

                        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');?>

                      </select>

                    </span></td>

                  </tr>

                  <tr>

                    <td>Zone Name :</td>

                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                      <option></option>

                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');?>

                    </select></span></td>

                  </tr>

                  <tr>

                    <td>Area Name :</td>

                    <td><span id="area"><select name="area_id" id="area_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                    <option></option>

                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>

                    </select></span></td>

                  </tr>

                  <tr>

                    <td>Chalan Cut off Date  : </td>

                    <td><input  name="cut_date" type="text" id="cut_date" value=""/></td>

                  </tr>

                  <tr>

                    <td>Depot Name :</td>

                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                      <select name="depot_id" id="depot_id" style="width:150px;">

                      <option></option>

                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>

                      </select>

                    </span></td>

                  </tr>

         <?php */?>     </table></td>

            <?php /*?></tr>

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

              <td><input name="submit" type="submit" class="btn1 btn1-submit-input" value="Report" /></td>

            </tr>

          </table>

      </div></td>

    </tr>

  </table>

</form><?php */?>


<script>

var currentDate = new Date();

// Set the date to the first day of the next month and subtract one day
var lastDateOfCurrentMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

// Extract the year, month, and day components
var year = lastDateOfCurrentMonth.getFullYear();
var month = (lastDateOfCurrentMonth.getMonth() + 1).toString().padStart(2, '0'); // Month is zero-based
var day = lastDateOfCurrentMonth.getDate().toString().padStart(2, '0');

 //var day2 = firstDateOfCurrentMonth.getDate().toString().padStart(2, '0');

// Format the date as "YYYY-MM-DD"
var formattedDate = year + '-' + month + '-' + day;



document.getElementById('t_date').value = formattedDate;

//document.getElementById('f_date').value = formattedDate2;

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>