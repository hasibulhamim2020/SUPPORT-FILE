<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Report';

 $master_id = find_a_field('user_activity_management','master_user','user_id='.$_SESSION['user']['id']);

do_calander("#f_date");
do_calander("#t_date");

auto_complete_from_db('item_info','item_name','item_id','1','item_id');
auto_complete_from_db('dealer_info','concat(dealer_name_e,"#>",dealer_code)','dealer_code','canceled="Yes" and depot="'.$_SESSION['user']['depot'].'"','dealer_code');

?>

<form action="master_report_chalan.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
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
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td width="94%"><div align="left">Sales Invoice  Brief Report</div></td>
                              </tr>
							  
							  
							   <!--<tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="1111" /></td>
                                <td width="94%"><div align="left">Sales Return  Brief Report</div></td>
                              </tr>-->
							  
							  <!--<tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="200512"  /></td>
                                <td width="94%"><div align="left">Sales Return Brief Report</div></td>
                              </tr>-->
                              
                              
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Delivered Chalan Report (Chalan Wise)(3)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">Chalan Report(Chalan Date Wise)(4)</div></td>
                              </tr>
                              -->
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">View Invoice Report (Single)</div></td>
                              </tr>-->
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="701" /></td>
                                <td><div align="left">Gate Pass Print(701)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="111" /></td>
                                <td><div align="left">Corporate Chalan Summary Brief(111)</div></td>
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
                    <td>Company:</td>
                    <td><span class="oe_form_group_cell">
					<? if($master_id==1){?>	
                     <select name="group_for" id="group_for" style=" float:left; width:250px">
                     <option></option>
                        <? foreign_relation('user_group','id','group_name',$group_for,'1 order by group_name');?>
						
                      </select>
					  <? }?>
					  
					  <? if($master_id==0){?>	
                     <select name="group_for" id="group_for" style=" float:left; width:250px">
                     
                        <? foreign_relation('user_group','id','group_name',$group_for,'id="'.$_SESSION['user']['group'].'" order by group_name');?>
						
                      </select>
					  <? }?>
                    </span></td>
                  </tr>
                
                  <!--<tr>
                    <td>Product Name : </td>
                    <td><input  name="item_id" type="text" id="item_id" style="width:250px;"/></td>
                  </tr>-->
                  <tr>
                    <td>From: </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" style="width:150px"/></td>
                  </tr>
                  <tr>
                    <td>To: </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" style="width:150px"/></td>
                  </tr>
				  <tr>
                    <td>Customer Name:</td>
                    <td><input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/></td>
                  </tr>
				  
				  
				  <tr>
                    <td>Sales Type:</td>
                    <td>
						<select name="sales_type" id="sales_type" style=" float:left; width:250px;">
					  
					  <option></option>

				 <? foreign_relation('sales_type','id','sales_type',$sales_type,'1');?>
 
                      </select>
					</td>
                  </tr>
				  
				  
				  <?php /*?><tr>
                    <td>Sales Return Type:</td>
                    <td>
						<select name="sales_return_type" id="sales_return_type" style=" float:left; width:250px;">
					  
					  <option></option>

				 <? foreign_relation('sales_return_type','id','sales_return_type',$sales_return_type,'1');?>
 
                      </select>
					</td>
                  </tr><?php */?>
					
				  <!--<tr>
				    <td>Dealer Type :</td>
				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
				      <select name="dealer_type" id="dealer_type" style="width:150px;">
                        <option value="" ></option>
                        <option value="Corporate">Corporate</option>
						 <option value="Distributor" >Distributor</option>
                      </select>
				    </span></td>
			      </tr>-->
				  <!--<tr>
				    <td>DO Status :</td>
				    <td> <select name="status" id="status" style="width:250px">
					    <option value=""></option>
						 <option value="MANUAL">MANUAL</option>
						  <option value="PROCESSING">PROCESSION</option>
                        <option value="CHECKED">CHECKED</option>
                        <option value="UNCHECKED">UNCHECKED</option>
					    <option value="COMPLETED">DONE</option>
			        </select></td>
			      </tr>-->
				  <!--<tr>
                    <td>Invoice No: </td>
                    <td><input  name="chalan_no" type="text" id="chalan_no" value=""/></td>
                  </tr>-->
                 <!-- <tr>
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
                  <tr>-->
				  
				  
                        <td>Warehouse:</td>
                          <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
						
				<? if($master_id==1){?>	
                      <select name="depot_id" id="depot_id" style=" float:left; width:250px;">
					  
					  <option></option>

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'1');?>
 
                      </select>
					  
				<? }?>
					  
					  <? if($master_id==0){?>	
			
					  <select name="depot_id" id="depot_id" style=" float:left; width:250px;">
				

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
 
                      </select>
					
				 <? }?>	  
					  
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
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>