<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Other Challan Reports';
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
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','canceled="Yes" 
and group_for="'.$_SESSION['user']['group'].'" order by dealer_code','dealer_code');
auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');
$tr_from="Sales";
?>



<div class="d-flex justify-content-center">
    <form class="n-form1 fo-width pt-4" action="other_master_report_chalan.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-6">
                <div align="left">Select Report </div>
				
				
              <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" />
					<label class="form-check-label p-0" for="report1-btn">Other Chalan Brief Report(1) </label>
                    </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn1" value="101" />
                    <label class="form-check-label p-0" for="report1-btn1">Other Order wise Chalan Brief Report(101)</label>
				</div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn2" value="2"  />
                  <label class="form-check-label p-0" for="report1-btn2">Item Wise Chalan  Brief Report(2)</label>
			  </div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn3" value="401" />
                  <label class="form-check-label p-0" for="report1-btn3">Item Wise Chalan  Brief Report(Main Product)(401)</label>
			  </div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn4" value="402" />
					<label class="form-check-label p-0" for="report1-btn4">Item Wise Chalan  Brief Report(By Product)(402) </label>
                    </div>
			
				
				
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn5" value="201" />
                    <label class="form-check-label p-0" for="report1-btn5">Item Wise Chalan  Details Report(HFML)(201)</label>
                </div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn6" value="191" />
                  <label class="form-check-label p-0" for="report1-btn6">Party Wise Delivery Chalan  Report (At A Glance)(191)</label>
			  </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn7" value="3" />
                    <label class="form-check-label p-0" for="report1-btn7">Delivered Chalan Report (Chalan Wise)(3)</label>
				</div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn8" value="4" />
                    <label class="form-check-label p-0" for="report1-btn8">Chalan Report(Chalan Date Wise)(4)</label>
				</div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn9" value="1004" />
					<label class="form-check-label p-0" for="report1-btn9">Warehouse Stock Position Report(Closing)(1004) </label>
                    </div>
					
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn10" value="1006" />
					<label class="form-check-label p-0" for="report1-btn10">Warehouse Stock Position Report(Promotion)(1006) </label>
                    </div>
					<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn11" value="6" />
					<label class="form-check-label p-0" for="report1-btn11">View Chalan Report(Single)(6) </label>
                    </div>
					
				

            </div>

            <div class="col-sm-6">
                
				
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
                      
					  <input  name="dealer_code" type="text" id="dealer_code"/>

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
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Chalan NO:</label>
                    <div class="col-sm-8 p-0">

							<input  name="chalan_no" type="text" id="chalan_no" value=""/>
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

                      <select name="depot_id" id="depot_id" >
                      <option></option>
                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>
                      </select>



                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Issue Type:</label>
                    <div class="col-sm-8 p-0">

                      <select name="issue_type" id="issue_type">
                      
					  <option></option>
					  <option>Bulk Sales</option>
					  <option>Entertainment Issue</option>
					  <option>Gift Issue</option>
					  <option>Other Sales</option>
					  <option>Sample Issue</option>
					  <option>Staff Sales</option>
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






<?php /*?><form action="other_master_report_chalan.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td colspan="2" class="title1"><div align="left">Select Report -<?=$_SESSION['ip'];?></div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td><div align="left">Other Chalan Brief Report(1)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="101" /></td>
                                <td><div align="left">Other Order wise Chalan Brief Report(101)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Item Wise Chalan  Brief Report(2)</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="401" /></td>
                                <td><div align="left">Item Wise Chalan  Brief Report(Main Product)(401)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="402" /></td>
                                <td><div align="left">Item Wise Chalan  Brief Report(By Product)(402)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="201" /></td>
                                <td><div align="left">Item Wise Chalan  Details Report(HFML)(201)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="191" /></td>
                                <td><div align="left">Party Wise Delivery Chalan  Report (At A Glance)(191)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Delivered Chalan Report (Chalan Wise)(3)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">Chalan Report(Chalan Date Wise)(4)</div></td>
                              </tr>
<!--                              <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Other Order Brief Report (Region Wise)(5)</div></td>
                              </tr>-->
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1004" /></td>
                                <td><div align="left">Warehouse Stock Position Report(Closing)(1004)</div></td>
                              </tr>
							                                <tr>
                                <td><input name="report" type="radio" class="radio" value="1006" /></td>
                                <td><div align="left">Warehouse Stock Position Report(Promotion)(1006)</div></td>
                              </tr>
							  
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">View Chalan Report(Single)(6)</div></td>
                              </tr>
<? if($_SESSION['user']['group']==2)  {?>
<tr>
<td><input name="report" type="radio" class="radio" value="1005" /></td>
<td><div align="left">Finish Goods Demand vs Receive Report(1005)</div></td>
</tr>
<? } ?>
<!--                              <tr>
                                <td><input name="report" type="radio" class="radio" value="19921" /></td>
                                <td><div align="left">DO Entry wise Sales Statement(19921)</div></td>
                              </tr>-->
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                 
				 
				 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="10001" /></td>
                                <td><div align="left">Item Wise Chalan  Details Report(Chalan Date Wise)(Select A Item)(10001)</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="10002" /></td>
                                <td><div align="left">Item Wise Chalan  Details Report(DO Date Wise)(Select A Item)(10002)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2001" /></td>
                                <td>Item Wise Chalan Details Report (At A Glance)(2001)</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="111" /></td>
                                <td><div align="left">Corporate Chalan Summary Brief(111)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="112" /></td>
                                <td><div align="left">SuperShop Chalan Summary Brief(112)</div></td>
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
                  <tr>
                    <td>Product Sales Group :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="product_group" id="product_group">
                      <option></option>
                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP,'1 order by group_name');?>
                        <option value="ABCD">ABCD</option>
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
                    <td><input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/></td>
                  </tr>
					
				  <tr>
				    <td>Dealer Type :</td>
				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
				      <select name="dealer_type" id="dealer_type" style="width:150px;">
					  <option></option>
                        <option value="Distributor" >Distributor</option>
						<option value="Corporate" >Corporate</option>
						<option value="SuperShop" >SuperShop</option>
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
				  
                  <tr>
                    <td>Issue Type :</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select name="issue_type" id="issue_type" style="width:150px;">
                      
					  <option></option>
					  <option>Bulk Sales</option>
					  <option>Entertainment Issue</option>
					  <option>Gift Issue</option>
					  <option>Other Sales</option>
					  <option>Sample Issue</option>
					  <option>StaffSales</option>
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