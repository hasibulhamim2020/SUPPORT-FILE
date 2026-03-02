<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Other Order Reports';
$tr_type="Show";
$php_ip=substr($_SESSION['php_ip'],0,11);
if($php_ip=='115.127.35.' || $php_ip=='192.168.191'){ 
do_calander('#f_date'/*,'-1800','0'*/);
do_calander('#t_date'/*,'-1800','30'*/);
} else {
	do_calander('#f_date'/*,'-60','0'*/);
	do_calander('#t_date'/*,'-60','0'*/);		
}


do_calander("#cut_date");
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','group_for="'.$_SESSION['user']['group'].'" and canceled="Yes"','dealer_code');
auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<6000','item_id');

$tr_from="Sales";
?>



<div class="d-flex justify-content-center">
    <form class="n-form1 fo-width pt-4" action="other_master_report_order.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-6">
                <div align="left">Select Report </div>
				
				
              <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" />
                    
					<label class="form-check-label p-0" for="report1-btn">Other Order Brief Report(1)</label>
					</div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn1" value="1991" />
                    <label class="form-check-label p-0" for="report1-btn1">Other Order Brief Report with Chalan Amount(1991)</label>
				</div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn2" value="1992"  />
                  <label class="form-check-label p-0" for="report1-btn2">Sales Statement(As Per DO)(1992)</label>
			  </div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn3" value="191" />
                  <label class="form-check-label p-0" for="report1-btn3">Other Order  Report (At A Glance)(191)</label>
			  </div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn4" value="2" />
					<label class="form-check-label p-0" for="report1-btn4">Delivered Do Details Report(2)</label>
                    </div>
			
				
				
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn5" value="3" />
                    <label class="form-check-label p-0" for="report1-btn5">Delivered Do Report Dealer Wise(3)</label>
                </div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn6" value="4" />
                  <label class="form-check-label p-0" for="report1-btn6">Chalan Report(Chalan Date Wise)(4)</label>
			  </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn7" value="5" />
                    <label class="form-check-label p-0" for="report1-btn7">Other Order Brief Report (Region Wise)(5)</label>
				</div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn8" value="7" />
                    <label class="form-check-label p-0" for="report1-btn8">Item Wise DO Report(7)</label>
				</div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn9" value="702" />
					<label class="form-check-label p-0" for="report1-btn9" style="color:#FF6633">Party Wise Undelivered DO Report(Bulk)(702)</label>
                    </div>
					
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn10" value="701" />
					<label class="form-check-label p-0" for="report1-btn10">Item Wise Undelivered DO Report(With Gift)(701) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn11" value="7011" />
					<label class="form-check-label p-0" for="report1-btn11">Item Wise Undelivered DO Report(Without Gift)(7011) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn12" value="14" />
					<label class="form-check-label p-0" for="report1-btn12">Item DO Report (Region)(14) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn13" value="9" />
					<label class="form-check-label p-0" for="report1-btn13">Item DO Report (Region+Zone)(9) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn14" value="6" />
					<label class="form-check-label p-0" for="report1-btn14">View DO  (Single)(6) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn15" value="8" />
					<label class="form-check-label p-0" for="report1-btn15">Dealer Performance Report(8) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn16" value="10" />
					<label class="form-check-label p-0" for="report1-btn16">Daily Collection Summary(10) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn17" value="13" />
					<label class="form-check-label p-0" for="report1-btn17">Daily Collection Summary(Ext)(13) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn18" value="11" />
					<label class="form-check-label p-0" for="report1-btn18">Daily Collection &amp; Order Summary(11) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn19" value="1999" />
					<label class="form-check-label p-0" for="report1-btn19">DO Report for Scratch Card(1999) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn20" value="2000" />
					<label class="form-check-label p-0" for="report1-btn20">DO Summery Report Region Wise(2000) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn21" value="2001" />
					<label class="form-check-label p-0" for="report1-btn21">Item Wise Chalan Details Report (DO Entry Date)(2001) </label>
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
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Do No:</label>
                    <div class="col-sm-8 p-0">
  
                       <input  name="do_no" type="text" id="do_no" value=""/>


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
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Chalan Cut off Date:</label>
                    <div class="col-sm-8 p-0">

                     <input  name="cut_date" type="text" id="cut_date" value=""/>



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



<?php /*?><form action="other_master_report_order.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
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
                                <td colspan="2" class="title1"><div align="left">Select Report -<?=$_SESSION['ip'];?> </div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td><div align="left">Other Order Brief Report(1)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1991" /></td>
                                <td><div align="left">Other Order Brief Report with Chalan Amount(1991)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1992" /></td>
                                <td><div align="left">Sales Statement(As Per DO)(1992)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="191" /></td>
                                <td><div align="left">Other Order  Report (At A Glance)(191)</div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Delivered Do Details Report(2)</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Delivered Do Report Dealer Wise(3)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">Chalan Report(Chalan Date Wise)(4)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Other Order Brief Report (Region Wise)(5)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="7" /></td>
                                <td><div align="left">Item Wise DO Report(7)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="702" /></td>
                                <td><div align="left" style="color:#FF6633">Party Wise Undelivered DO Report(Bulk)(702)</div></td>
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
                                <td><input name="report" type="radio" class="radio" value="14" /></td>
                                <td><div align="left">Item DO Report (Region)(14)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="9" /></td>
                                <td><div align="left">Item DO Report (Region+Zone)(9)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">View DO  (Single)(6)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="8" /></td>
                                <td><div align="left">Dealer Performance Report(8)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="10" /></td>
                                <td><div align="left">Daily Collection Summary(10)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="13" /></td>
                                <td><div align="left">Daily Collection Summary(Ext)(13)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="11" /></td>
                                <td><div align="left">Daily Collection &amp; Order Summary(11)</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1999" /></td>
                                <td><div align="left">DO Report for Scratch Card(1999)</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2000" /></td>
                                <td><div align="left">DO Summery Report Region Wise(2000)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2001" /></td>
                                <td>Item Wise Chalan Details Report (DO Entry Date)(2001)</td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>Product Sales Group :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="product_group" id="product_group">
                      <option></option>
                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP,'1 order by group_name');?>
						<option>ABCD</option>
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
                    <td>Dealer Name :</td>
                    <td>
                    <input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/>                    </td>
                  </tr>
					
				  <tr>
				    <td>Dealer Type :</td>
				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
				      <select name="dealer_type" id="dealer_type" style="width:150px;">
                      <option></option>
				        <option value="Distributor">Distributor</option>
				        <option value="Corporate">Corporate</option>
                        <option value="SuperShop">SuperShop</option>
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