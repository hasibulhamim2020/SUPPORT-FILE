<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Delivery Order Advance Reports';

do_calander("#f_date");
do_calander("#t_date");
do_calander("#cut_date");
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');
//auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and finish_goods_code>0','item_id');
?>
<form action="do_master.php" method="post" name="form1" target="_blank" id="form1">

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
                                <td><input name="report" type="radio" class="radio" value="1" /></td>
                                <td><div align="left">Delivery Order Brief Report</div></td>
                              </tr>
                              

<!--
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Delivered Do Details Report</div></td>
                              </tr>

  <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                          <td><div align="left">Delivered Do Report Dealer Wise</div></td>
                          </tr>
		     <tr>
                <td><input name="report" type="radio" class="radio" value="4" /></td>
                <td><div align="left">Chalan Report(Chalan Date Wise)</div></td>
                   </tr>

           <tr>-->
							  <!--<tr>

                           <td><input name="report" type="radio" class="radio" value="2001" /></td>
                           <td><div align="left">Aksid Staff Commission Report</div></td>
                            
						   </tr>-->
						  <!-- <tr>
                           <td><input name="report" type="radio" class="radio" value="200222" /></td>
                           <td><div align="left">Aksid Staff Commission Report New</div></td>
                            
						   </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="701" /></td>
                                <td><div align="left">Item Wise Undelivered DO Report(With Sample)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="7011" /></td>
                                <td><div align="left">Item Wise Undelivered DO Report(Without Sample)</div></td>
                              </tr>
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">View DO  (Single)</div></td>
                              </tr>-->
                              <!--
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1992" /></td>
                                <td><div align="left">Sales Statement(As Per DO)</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Delivery Order Brief Report (Region Wise)</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="14" /></td>
                                <td><div align="left">Item DO Report (Region)</div></td>
                              </tr>

                              <tr>
                                <td><input name="report" type="radio" class="radio" value="9" /></td>

                                <td><div align="left">Item DO Report (Region+Zone)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="8" /></td>

                                <td><div align="left">Dealer Performance Report</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="10" /></td>
                                <td><div align="left">Daily Collection Summary</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="13" /></td>
                                <td><div align="left">Daily Collection Summary (Ext)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="11" /></td>
                                <td><div align="left">Daily Collection &amp; Order Summary</div></td>
                              </tr>
                              <tr>

                                <td><input name="report" type="radio" class="radio" value="1999" /></td>

                                <td><div align="left">DO Report for Scratch Card</div></td>

                              </tr>-->







                          </table></td>







                        </tr>







                    </table></td>







                  </tr>







              </table></td>







              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">







                  <tr>







                    <td>Product Sales Group :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="product_group" id="product_group" style="margin-left:4px" class="form-control" >
                      <option></option>
                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>
						<option>ABCD</option>
                      </select>
                    </span></td>
                  </tr>


                  <tr>
                    <td>Product Brand : </td>
                    <td><select name="item_brand" id="item_brand" style="margin-left:4px" class="form-control">
                                          <option></option>
                                        </select></td>
                  </tr>


                  <tr>
                    <td>Product Name : </td>
                    <td><input type="text" name="item_id" id="item_id" style="margin-left:4px" class="form-control" /></td>
                  </tr>

				   <tr>
                    <td>Marketing Person : </td>
                    <td><select name="marketing_person" style="margin-left:4px" class="form-control" >
					 <option></option>
					  <option value="31502">Md Saud Sadrul Anam - Managing Director</option>

					<?
					  $sql = db_query('select PBI_ID,PBI_NAME from personnel_basic_info where PBI_DEPARTMENT=2 and PBI_JOB_STATUS="In Service"');
					  while($marketing = mysqli_fetch_object($sql)){
					?>
					<option value="<?=$marketing->PBI_ID?>"><?=$marketing->PBI_NAME?></option>
					<? } ?>
					</select>
					</td>

                  </tr>

                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-d')?>" class="form-control" /></td>
                  </tr>

                  <tr>
                    <td>To : </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" class="form-control" /></td>
                  </tr>


				  <tr>

                    <td>Client Name :</td>
                    <td>
                    <input  name="dealer_code" type="text" id="dealer_code" class="form-control" class="form-control" />                    </td>
                  </tr>

				  <tr>
				    <td>Client Type :</td>
				    <td><span class="oe_form_group_cell" >
				      <select name="dealer_type" id="dealer_type" style="margin-left:4px" class="form-control" >
					  <option></option>
				        <option >Distributor</option>
				        <option value="Corporate">Corporate+SuperShop</option>
			          </select>
				    </span></td>
			      </tr>
				  <tr>
				    <td>DO Status :</td>
				    <td><select name="status" id="status" style="margin-left:4px" class="form-control" >
					    <option value="ALL">All</option>
                        <option value="CHECKED">PROCESSION</option>
                        <option value="UNCHECKED">UNCHECKED</option>
					    <option value="COMPLETED">COMPLETED</option>
						  <option value="CANCELED">CANCELED</option>
			        </select></td>
			      </tr>

				  <tr>
                    <td>DO No: </td>
                    <td><input  name="do_no" type="text" id="do_no" value="" class="form-control" /></td>
                  </tr>
                  <!--<tr>
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
                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)" style="margin-left:4px">
                      <option></option>
                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');?>
                    </select></span></td>

                  </tr>
                  <tr>
                    <td>Area Name :</td>
                    <td><span id="area"><select name="area_id" id="area_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)" style="margin-left:4px">
                    <option></option>

                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                    </select></span></td>
                  </tr>
                  <tr>

                    <td>Chalan Cut off Date  : </td>
                    <td><input  name="cut_date" type="text" id="cut_date" value=""/></td>
                  </tr>-->
                  <tr>
                    <td>Depot Name :</td>
                    <td><span class="oe_form_group_cell" >

                      <select name="depot_id" id="depot_id" style="margin-left:4px" class="form-control" >
                      <option></option>
                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>
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
              <td><input name="submit" type="submit" class="btn btn-success" value="Report" /></td>
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