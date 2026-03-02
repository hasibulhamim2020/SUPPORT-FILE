<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Advance Reports';
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



$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Build the full URL
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


$trimmed_path = str_replace("https://saaserp.ezzy-erp.com/app/views/", "", $url);
$parts = explode('/', $trimmed_path);

 $mod_name = $parts[0]; 
 $folder_name = $parts[1];
 $page_name = $parts[2]; 


	 $res2 ='SELECT  r.folder_name, r.report_no, r.feature_id,r.page_id, p.id AS page_id, f.id AS feature_id, f.feature_name,  m.id AS module_id,  m.module_name
			FROM  user_page_manage p JOIN  user_feature_manage f ON p.feature_id = f.id JOIN  user_module_manage m ON f.module_id = m.id, report_manage r
			WHERE  m.module_file="'.$mod_name.'" and p.folder_name="'.$folder_name.'" and p.page_link="'.$page_name .'" and r.folder_name="'.$folder_name.'" and r.feature_id=f.id and r.page_id=p.id';

								$query=db_query($res2);
								
								While($row=mysqli_fetch_object($query)){
									$page_file[$row->page_no] = $row->page_id;
								}



?>



<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report_chalan.php" method="post" name="form1" target="_blank" id="form1" style="width:90%">
        <div class="row m-0 p-0">
            <div class="col-sm-6">
                <div align="left">Select Report </div>
				
				<?
					
							 //$res ='select report_name,page_id,report_no,status from report_manage where page_id="'.$page_file[$row->page_id].'" and status="Yes"';
							 
							 $res ='select r.id,r.report_name,r.page_id,r.report_no,r.status,u.user_id,a.user_id,a.report_id 
							 from report_manage r, user_activity_management u,user_report_access a 
							 where r.page_id="'.$page_file[$row->page_id].'" and a.report_id=r.id and a.user_id=u.user_id and u.user_id="'.$_SESSION['user']['id'].'" and a.access="1" and r.status="Yes"';
									
									$query=db_query($res);
								While($row=mysqli_fetch_object($query)){
								
								?>
               
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn1" value="<?=$row->report_no?>" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn1">
                         <?=$row->report_name?> (<?=$row->report_no?>)
                    </label>
                </div>
<? } ?>
              		

            </div>
			
			
			
			
			
			
			
			
			
			
			
			<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" />
                    <label class="form-check-label p-0" for="report1-btn">Delivery Chalan Summary Report (1)</label>
                    </div>-->
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="15" />
                    <label class="form-check-label p-0" for="report1-btn">Delivery Chalan Brief Report</label>
				</div>-->
			 <!-- <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="102"  />
                  <label class="form-check-label p-0" for="report1-btn">Chalan Detials  Report (102)</label>
                </div>
				
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="2" />
                    <label class="form-check-label p-0" for="report1-btn">Item Wise Chalan Report (2)</label>
				</div>
				
        <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="15427" />
                    <label class="form-check-label p-0" for="report1-btn">Sales vs consumption Report (15427)</label>
        </div>
		
		<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="72" />
                    <label class="form-check-label p-0" for="report1-btn">Customer Due Report (72)</label>
				</div>
				
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="73" />
                    <label class="form-check-label p-0" for="report1-btn">Collection Report (73)</label>
				</div>
				
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="2024211" />
                    <label class="form-check-label p-0" for="report1-btn">Product Wise Sales Analysis Report (2024211)</label>
				</div>
				
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="402" />
                    <label class="form-check-label p-0" for="report1-btn">Actual Party Ledger Report (402)</label>
				</div>
				
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="404" />
                    <label class="form-check-label p-0" for="report1-btn">Party Receivable Report (404)</label>
				</div>
				
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="15051" />
                    <label class="form-check-label p-0" for="report1-btn">Product Wise Monthly Sales Report(Amount only) (15051)</label>
				</div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="150519" />
                    <label class="form-check-label p-0" for="report1-btn">Product Category Wise Sales(Amount) (150519)</label>
				</div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1505191" />
                    <label class="form-check-label p-0" for="report1-btn">Product Category Wise Sales(Pcs) (1505191)</label>
				</div>
				
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="15051911" />
                    <label class="form-check-label p-0" for="report1-btn">Product Category Wise Sales(Ctn) (15051911)</label>
				</div>-->

			

            <div class="col-sm-6">
                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name:</label>
                    <div class="col-sm-8 p-0">
						<input type="text" list="item" name="item_id" id="item_id" class="form-control" />
                        <datalist id="item">
                       		 <option></option>
                      
							<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                   		 </datalist>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Dealer Name:</label>
                    <div class="col-sm-8 p-0">
					<input type="text" list="dealer" name="dealer_code" id="dealer_code" class="form-control" />
                        <datalist id="dealer">
						  <option></option>
						  <? foreign_relation('dealer_info','dealer_code','dealer_name_e','1');?>
						</datalist>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Category:</label>
                    <div class="col-sm-8 p-0">
						<input type="text" list="brand" name="item_brand" id="item_brand" class="form-control" />
                        <datalist id="brand">
						  <option></option>
						  <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>
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

                        <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>


                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Inventory Name:</label>
                    <div class="col-sm-8 p-0">
                            
                            <select name="depot_id" id="depot_id">
							<option></option>
							  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1 and use_type="WH"');?>
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
                                <td colspan="2" class="title1"><div align="left">Select Report -<?=$_SESSION['ip'];?>-<?=$_SESSION['php_ip']?></div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td><div align="left">Delivery Chalan Brief Report(1)</div></td>
                              </tr>
                                                            <tr>
                                                              <td><input name="report" type="radio" class="radio" value="15" /></td>
                                                              <td><div align="left">Delivery Chalan Brief Report Only Summation(15)</div></td>
                                                            </tr>
                                                            <tr>
                                                              <td><input name="report" type="radio" class="radio" value="102" /></td>
                                                              <td><div align="left">Chalan Detials  Report(102)</div></td>
                                                            </tr>
                                                            <tr>
                                                              <td>&nbsp;</td>
                                                              <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                <td><input name="report" type="radio" class="radio" value="10101" /></td>
                                <td><div align="left">Delivery Chalan Adjustment Brief Report(10101)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="101" /></td>
                                <td><div align="left">Delivery Order wise Chalan Brief Report(101)</div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Item Wise Chalan  Details Report(2)</div></td>
                              </tr>
                              
<!--                              <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Delivered Chalan Report (Chalan Wise)(3)</div></td>
                              </tr>-->
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">Chalan Report(Chalan Date Wise)(4)</div></td>
                              </tr>
<!--                     <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Delivery Order Brief Report (Region Wise)(5)</div></td>
                              </tr>-->
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
<!--                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1004" /></td>
                                <td><div align="left">Warehouse Stock Position Report(Closing)(1004)</div></td>
                              </tr>-->
							                                <tr>
                                                              <td><input name="report" type="radio" class="radio" value="1007" /></td>
							                                  <td><div align="left">Warehouse Stock + Transit (Closing)(1007)</div></td>
                              </tr>
							                                <tr>
                                <td><input name="report" type="radio" class="radio" value="1006" /></td>
                                <td><div align="left">Warehouse Stock Position Report(Promotion)(1006)</div></td>
                              </tr>
							  
				                                            <tr>
				                                              <td>&nbsp;</td>
				                                              <td>&nbsp;</td>
                              </tr>
                              <tr>
				  <td><input name="report" type="radio" class="radio" value="901" /></td>
				  <td><div align="left">Warehouse Stock Movement Report(Select Warehouse)(901)</div></td>
				</tr>
				              <tr>
                                <td><input name="report" type="radio" class="radio" value="40" /></td>
				                <td><div align="left">Head Office Stock Report(40)</div></td>
			                  </tr>
				              <tr>
				  <td><input name="report" type="radio" class="radio" value="7031" /></td>
				  <td><div align="left">Sales Report- Type Wise(7031)</div></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">View Chalan Report(Single)(6)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1005" /></td>
                                <td><div align="left">Finish Goods Demand vs Receive Report(1005)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="19921" /></td>
                                <td><div align="left">DO Entry wise Sales Statement(19921)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="10001" /></td>
                                <td><div align="left">Item Wise Chalan  Details Report(Chalan Date Wise)(Select A Item)(10001)</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="116" /></td>
                                <td><div align="left">Single Item Sales Report(Zone Wise)(116)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="10002" /></td>
                                <td><div align="left">Item Wise Chalan  Details Report(DO Date Wise)(Select A Item)(10002)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2001" /></td>
                                <td align="left"><div align="left">Item Wise Chalan Details Report(With Gift)(At A Glance)(2001)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="201" /></td>
                                <td align="left"><div align="left">Item Wise Chalan Details Report (At A Glance)(201)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="left">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="left">&nbsp;</td>
                              </tr>


<? if($_SESSION['user']['level']==5){?>
<tr>
<td><input name="report" type="radio" class="radio" value="601" /></td>
<td align="left"><div align="left">Check Free Goods Vs Accounts(601)</div></td>
</tr>
<tr>
<td><input name="report" type="radio" class="radio" value="602" /></td>
<td align="left"><div align="left">Check CP Vs Accounts(602)</div></td>
</tr>
<tr>
<td><input name="report" type="radio" class="radio" value="603" /></td>
<td align="left"><div align="left">Check Cas Dis Vs Accounts(603)</div></td>
</tr><? } ?>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="left">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="left">&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2000" /></td>
                                <td align="left"><div align="left"> Sales Report Region Wise (2000)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2002" /></td>
                                <td align="left"><div align="left">Party Sales Report(Region Wise)(Big Report)(2002)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="111" /></td>
                                <td><div align="left">Corporate Chalan Summary Brief(111)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="112" /></td>
                                <td><div align="left">SuperShop Chalan Summary Brief(112)</div></td>
                              </tr>

<? if(
$_SESSION['user']['username']=='faysal' || $_SESSION['user']['username']=='hfl' ||
$_SESSION['user']['username']=='3'
){ ?>							  
<tr>
<td><input name="report" type="radio" class="radio" value="47" /></td>
<td><div align="left">SuperShop Closing Report(47)</div></td>
</tr>
<tr>
<td><input name="report" type="radio" class="radio" value="48" /></td>
<td><div align="left">Corporate Closing Report(48)</div></td>
</tr>
<? } ?>

							  
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
                        <option value="ABCDE">ABCDE</option>
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
                    <td><select  name="dealer_code" id="dealer_code" style="width:250px;"><option></option><? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?></select></td>
                  </tr>
					
				  <tr>
				    <td>Dealer Type :</td>
				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
				      <select name="dealer_type" id="dealer_type" style="width:150px;">
                      <option></option>
                        <option value="Distributor" >Distributor</option>
						<option value="Corporate" >Corporate</option>
						<option value="SuperShop" >SuperShop</option>
                        <option value="TradeFair" >TradeFair</option>
						<option value="Super_Mgroup" >SuperShop+M-Group</option>
                        <option value="MordernTrade" >SuperShop+Corporate+M-Group</option>
                      </select>
				    </span></td>
			      </tr>
				  <tr>
				    <td>Super Shop List : </td>
				    <td><strong>
				      <select name="dealer" id="dealer">
                        <option></option>
						<? foreign_relation('dealer_info','distinct dealer_outlet_name','dealer_outlet_name',$_POST['dealer'],'1 order by dealer_outlet_name');?>
                      </select>
				    </strong></td>
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
                    <td>Warehosue:</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select name="depot_id" id="depot_id" style="width:150px;">
                      <option></option>
                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' group_for = "'.$_SESSION['user']['group'].'" ');?>
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