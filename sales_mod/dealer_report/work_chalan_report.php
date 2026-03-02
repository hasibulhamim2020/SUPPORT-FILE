<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Damage Advance Reports';
$tr_type="Show";
$rsm_id = find_a_field('user_activity_management','region_id','user_id="'.$_SESSION['user']['id'].'"');
$zone_id = find_a_field('user_activity_management','zone_id','user_id="'.$_SESSION['user']['id'].'"');
if($rsm_id>0 || $zone_id>0){ $user_pg=find_a_field('user_activity_management','product_group','user_id="'.$_SESSION['user']['id'].'"');}


$php_ip=substr($_SESSION['php_ip'],0,11);
if($php_ip=='115.127.35.' || $php_ip=='192.168.192'){ 
do_calander('#f_date','-1800','0');
do_calander('#t_date','-1800','30');
} else {
	do_calander('#f_date','-365','0');
	do_calander('#t_date','-365','0');		
}

auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');
auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');

$tr_from="Sales";
?>



<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report_chalan.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-6">
                <div align="left">Select Report <span class="text-info bold">(Monthly Report)</span></div>
				
				
              <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="10777" checked="checked" />
					<label class="form-check-label p-0" for="report1-btn"> Regional Sales Vs Damage Report(10777)</label>
                    </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn1" value="10888" />
                    <label class="form-check-label p-0" for="report1-btn1">Zone Wise Sales Vs Damage Report(10888)</label>
				</div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn2" value="11333"  />
                  <label class="form-check-label p-0" for="report1-btn2">ALL Party Sales Vs Damage Report(11333)</label>
			  </div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn3" value="2200" />
                  <label class="form-check-label p-0" for="report1-btn3">Item Wise Sales Vs Damage(With Good Condition)</label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn4" value="22" />
					<label class="form-check-label p-0" for="report1-btn4">Item Wise Sales Vs Damage  Report(22) </label>
                     </div>
			
				
				
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn5" value="705" />
                    <label class="form-check-label p-0" for="report1-btn5">Regional Sales Vs Damage Report(705)</label>
                </div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn6" value="704" />
                  <label class="form-check-label p-0" for="report1-btn6">Zone Wise Sales Vs Damage Report(704)</label>
			  </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn7" value="701" />
                    <label class="form-check-label p-0" for="report1-btn7">ALL Party Sales Vs Damage Report(701)</label>
				</div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn8" value="702" />
                    <label class="form-check-label p-0" for="report1-btn8">Item Wise Sales Vs Damage(With Good Condition) </label>
				</div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn9" value="706" />
					<label class="form-check-label p-0" for="report1-btn9">Item Wise Sales Vs Damage Report(706)  </label>
                    </div>
				

            </div>

            <div class="col-sm-6">
                
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Damage Reason:</label>
                    <div class="col-sm-8 p-0">
                       <select name="damage_cause" id="damage_cause">
                        <option></option>
                        <? foreign_relation('damage_cause','id','damage_cause',$damage_cause);?>
                      </select>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Sales Group:</label>
                    <div class="col-sm-8 p-0">
                        <select name="product_group" id="product_group">
<?php if($rsm_id>0 || $zone_id>0){ ?>  <option value="<?=$user_pg?>"><?=$user_pg?></option><? } else {?>                     
					  <option></option>
                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP,'1 order by group_name');?>
						<option>ABCDE</option>
						<? } ?>
                      </select>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Brand:</label>
                    <div class="col-sm-8 p-0">
                        <select name="item_brand" id="item_brand">
						  <option></option>
						  <? foreign_relation('item_brand','brand_name','brand_name',$item_brand,'1 order by brand_name');?>
						</select>
                    </div>
                </div>
				
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name:</label>
                    <div class="col-sm-8 p-0">
                        <input type="text" name="item_id" id="item_id" />
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-01-01')?>"/>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">
                        <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Dealer Name:</label>
                    <div class="col-sm-8 p-0">
                      <input  name="dealer_code" type="text" id="dealer_code" />

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Dealer Type:</label>
                    <div class="col-sm-8 p-0">

                        <select name="dealer_type" id="dealer_type">
                        <option value="Distributor" >Distributor</option>
                        <option value="Corporate" >Corporate</option>
                        <option value="SuperShop" >SuperShop</option>
                        <option value="TradeFair" >TradeFair</option>
                        <option value="MordernTrade" >SuperShop+Corporate+M-Group</option>
						<option></option>
                      </select>


                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">DO Status:</label>
                    <div class="col-sm-8 p-0">

                      <select name="status" id="status">
					    <option value="">All</option>
                        <option value="CHECKED">PROCESSION</option>
                        <option value="UNCHECKED">UNCHECKED</option>
					    <option value="DONE">DONE</option>
			        </select>



                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Damange No:</label>
                    <div class="col-sm-8 p-0">
  
                       <input  name="damage_no" type="text" id="damage_no" value=""/>


                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Region Name:</label>
                    <div class="col-sm-8 p-0">

                       
                       <select name="region_id" id="region_id" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                        <? if($zone_id>0){ 
						foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 and BRANCH_ID="'.$rsm_id.'" order by BRANCH_NAME');
						}else{
						foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');
						}
						
						?>
                      </select>



                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Zone Name:</label>
                    <div class="col-sm-8 p-0">

                       <select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                      <? if($zone_id>0){ 
							foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 and ZONE_CODE="'.$zone_id.'" order by ZONE_NAME'); 
						}else{ ?>
                      <option></option>
                      <?	foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');
					  }
					  ?>
                    </select>



                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Area Name:</label>
                    <div class="col-sm-8 p-0">

                     <select name="area_id" id="area_id" >
                      <option></option>
                      <? if($zone_id>0){ 
					  foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 and ZONE_ID="'.$zone_id.'" order by AREA_NAME');
					  }else{
					  foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');
					  }
					  ?>
                    </select>



                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Depot Name:</label>
                    <div class="col-sm-8 p-0">

                      <select name="depot_id" id="depot_id" style="width:150px;">
                      <option></option>
                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>
                      </select>



                    </div>
                </div>


            </div>

        </div>
        <div class="n-form-btn-class">
			
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
        </div>
    </form>
</div>



<?php /*?><form action="master_report_chalan.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td colspan="2" class="title1"><div align="left"></div></td>
                              </tr>

								<tr>
                                <td width="6%">&nbsp;</td>
                                <td width="94%"><center><strong>Monthly Report</strong></center></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="10777" checked="checked" /></td>
                                <td><div align="left">Regional Sales Vs Damage Report(10777)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="10888" /></td>
                                <td><div align="left">Zone Wise Sales Vs Damage Report(10888)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="11333" /></td>
                                <td><div align="left">ALL Party Sales Vs Damage Report(11333)</div></td>
                              </tr>
 
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2200" /></td>
                                <td><div align="left">Item Wise Sales Vs Damage  (With Good Condition)(2200) </div></td>
                              </tr>
  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="22" /></td>
                                <td><div align="left">Item Wise Sales Vs Damage  Report(22) </div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td></td>
                              </tr>

                              
							  
							  
							  <tr>
                                <td>&nbsp;</td>
                                <td></td>
                              </tr>

								<tr>
                                <td>&nbsp;</td>
                                <td><center><strong>Report# Without Tang,Bourn Vita, Oreo</strong></center></td>
                              </tr>
							  
							 
							    <tr>
                                  <td><input name="report" type="radio" class="radio" value="705" /></td>
							      <td><div align="left">Regional Sales Vs Damage Report(705)</div></td>
						      </tr>
						      <tr>
                                <td><input name="report" type="radio" class="radio" value="704" /></td>
                                <td><div align="left">Zone Wise Sales Vs Damage Report(704)</div></td>
                              </tr>
							 
							 
							 <tr>
                                <td><input name="report" type="radio" class="radio" value="701" /></td>
                                <td><div align="left">ALL Party Sales Vs Damage Report(701)</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="702" /></td>
							    <td><div align="left">Item Wise Sales Vs Damage  (With Good Condition)(702) </div></td>
						      </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="706" /></td>
							    <td><div align="left">Item Wise Sales Vs Damage  Report(706) </div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="703" /></td>
                                <td><div align="left">Region/Zone/Party/Item wise Sales Vs Damage Report(703)</div></td>
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
                    <td>Damage Reason  :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="damage_cause" id="damage_cause">
                        <option></option>
                        <? foreign_relation('damage_cause','id','damage_cause',$damage_cause);?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Product Sales Group :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="product_group" id="product_group">
<?php if($rsm_id>0 || $zone_id>0){ ?>  <option value="<?=$user_pg?>"><?=$user_pg?></option><? } else {?>                     
					  <option></option>
                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP,'1 order by group_name');?>
						<option>ABCDE</option>
						<? } ?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Product Brand : </td>
                    <td><select name="item_brand" id="item_brand">
                      <option></option>
                      <? foreign_relation('item_brand','brand_name','brand_name',$item_brand,'1 order by brand_name');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Item Name : </td>
                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>
                  </tr>
                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-01-01')?>"/></td>
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
                        <option value="Corporate" >Corporate</option>
                        <option value="SuperShop" >SuperShop</option>
                        <option value="TradeFair" >TradeFair</option>
                        <option value="MordernTrade" >SuperShop+Corporate+M-Group</option>
						<option></option>
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
                    <td>Damage No: </td>
                    <td><input  name="damage_no" type="text" id="damage_no" value=""/></td>
                  </tr>

                  <tr>
                    <td>Region Name :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="region_id" id="region_id" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                        <? if($zone_id>0){ 
						foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 and BRANCH_ID="'.$rsm_id.'" order by BRANCH_NAME');
						}else{
						foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');
						}
						
						?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Zone Name :</td>
                    <td><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                      <? if($zone_id>0){ 
							foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 and ZONE_CODE="'.$zone_id.'" order by ZONE_NAME'); 
						}else{ ?>
                      <option></option>
                      <?	foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');
					  }
					  ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Area Name :</td>
                    <td><select name="area_id" id="area_id" >
                      <option></option>
                      <? if($zone_id>0){ 
					  foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 and ZONE_ID="'.$zone_id.'" order by AREA_NAME');
					  }else{
					  foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');
					  }
					  ?>
                    </select></td>
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
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
              <td><input name="submit" type="submit" class="btn1 btn1-submit-input" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form><?php */?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>