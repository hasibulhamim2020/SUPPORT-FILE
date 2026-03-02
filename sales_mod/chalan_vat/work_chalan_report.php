<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Delivery Chalan Advance Reports';



do_calander("#f_date");

do_calander("#t_date");

auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');

auto_complete_from_db('item_info','item_name','item_id','1','item_id');

?>



<form action="master_report_chalan.php" method="post" name="form1" target="_blank" id="form1">

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

                                <td width="6%"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>

                                <td width="94%"><div align="left">Delivery Chalan Brief Report</div></td>

                              </tr>

                              

                              

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="3" /></td>

                                <td><div align="left">Delivered Chalan Report (Chalan Wise)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="4" /></td>

                                <td><div align="left">Chalan Report(Chalan Date Wise)</div></td>

                              </tr>

                              

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="6" /></td>

                                <td><div align="left">View Chalan Report (Single)</div></td>

                              </tr>

                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="111" /></td>

                                <td><div align="left">Corporate Chalan Summary Brief</div></td>

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

                    <td>Product Sales Group :</td>

                    <td><span class="oe_form_group_cell">

                      <select name="product_team" id="product_team">

                      <option></option>

                        <? foreign_relation('teams','team_name','team_name',$product_team);?>

                      </select>

                    </span></td>

                  </tr>

                  <tr>

                    <td>Product Brand : </td>

                    <td><select name="item_brand" id="item_brand">

                                          <option></option>

                                         <!-- <option value="NA">NA</option>

                                          <option value="Tang">Tang</option>

                                          <option value="Bourn Vita">Bourn Vita</option>

                                          <option value="Oreo">Oreo</option>

                                          <option value="Shezan">Shezan</option>

                                          <option value="Promotional">Promotional</option>

                                          <option value="Top">Top</option>

                                          <option value="Kolson">Kolson</option>

                                          <option value="Nocilla">Nocilla</option>

                                          <option value="Sajeeb">Sajeeb</option>-->

                                        </select></td>

                  </tr>

                  <tr>

                    <td>Product Name : </td>

                    <td><input  name="item_id" type="text" id="item_id" style="width:250px;"/></td>

                  </tr>

                  <tr>

                    <td>From : </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

                  <tr>

                    <td>To : </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				  <tr>

                    <td>Dealer Name :</td>

                    <td><input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/></td>

                  </tr>

					

				  <tr>

				    <td>Dealer Type :</td>

				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

				      <select name="dealer_type" id="dealer_type" style="width:150px;">

                        <option value="Distributor" >Distributor</option>
						
						<option value="SuperShop">SuperShop</option>

                        <option value="Corporate">Corporate</option>

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

                    <td>Chalan No: </td>

                    <td><input  name="chalan_no" type="text" id="chalan_no" value=""/></td>

                  </tr>

                  <tr>

                    <td>Area Name :</td>

                    <td><select name="area_id" id="area_id">

                    <option></option>

                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>

                    </select></td>

                  </tr>

                  <tr>

                    <td>Zone Name :</td>

                    <td><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                    <option></option>

                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');?>

                    </select></td>

                  </tr>

                  <tr>

                    <td>Region Name :</td>

                    <td><span class="oe_form_group_cell">

                      <select name="region_id" id="region_id" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">

                      <option></option>

                        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');?>

                      </select>

                    </span></td>

                  </tr>

                  <tr>

                    <td>Depot Name :</td>

                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                      <select name="depot_id" id="depot_id" style="width:150px;">
					  <option></option>

                      <option value="<?=$_SESSION['user']['depot']?>"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?></option>

                      </select>

                    </span></td>

                  </tr>

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