<?php


session_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Product Advance Reports';





do_calander("#f_date");


do_calander("#t_date");


auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');


?>

<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
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
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1" tabindex="1"/></td>
                                <td><div align="left">Finish Good Product List</div></td>
                              </tr>-->
							  
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="888" tabindex="2"/></td>
                                <td><div align="left">Product Information (Rate Changable)</div></td>
                              </tr>-->
							  
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="8888" checked="checked" tabindex="2"/></td>
                                <td><div align="left">Product Information </div></td>
                              </tr>
							  
							  
							  
							  
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="888898" tabindex="2"/></td>
                                <td><div align="left">Warehouse Report</div></td>
                              </tr>-->
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="8889" tabindex="2"/></td>
                                <td><div align="left">Product Rate Change Information</div></td>
                              </tr>-->
							  
							  
							  
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="8890" tabindex="2"/></td>
                                <td><div align="left">Area and Transport Changes Information</div></td>
                              </tr>-->
							  
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="889" tabindex="2"/></td>
                                <td><div align="left">Product Mesh Size Information </div></td>
                              </tr>-->
							  
		              
							  
							  <!--<tr>


                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>


                                <td width="94%"><div align="left">Product List Details</div></td>


                              </tr>


                              <tr>


                                <td width="6%"><input name="report" type="radio" class="radio" value="3" /></td>


                                <td width="94%"><div align="left">Price List Details</div></td>


                              </tr>-->
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  
                  <!--<tr>
                    <td>Product Nature :</td>
                    <td><span id="branch" class="oe_form_group_cell">
                      <select name="product_nature" id="product_nature">
                        <option></option>
                        <option value="Salable">Salable</option>
                        <option value="Purchasable">Purchasable</option>
                        <option value="Both">Both</option>
                      </select>
                      </span></td>
                  </tr>-->
				  
				  <tr>
                    <td>From :</td>
                    <td><span class="oe_form_group_cell">
                      <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/>
                      </span></td>
                  </tr>
				  
				  <tr>
                    <td>To :</td>
                    <td><span class="oe_form_group_cell">
                      <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>
                      </span></td>
                  </tr>
				  
				  
				  
				   <tr>
                    <td>Item Name :</td>
                    <td><span class="oe_form_group_cell">
                      <input  name="item_name" type="text" id="item_name" value=""/>
                      </span></td>
                  </tr>
				  
				  
				  <tr>

                    <td>Product Group :</td>

                    <td><span class="oe_form_group_cell">

                      <select name="group_id" id="group_id"  style="width:150px;" tabindex="3" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value, 

document.getElementById('group_id').value);">

                        <option></option>

                        <? foreign_relation('item_group','group_id','group_name',$group_id,'');?>

                      </select>

                      </span></td>

                  </tr>
				  
				  
				  <tr>

                    <td>Product Sub Group :</td>

                    <td><span class="oe_form_group_cell">
					
					<span id="item_sub_group">

                      <select name="item_sub_group" id="item_sub_group" tabindex="4"  style="width:150px;">

                        <option></option>

                        <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, '1');?>

                      </select>

                      </span></span></td>

                  </tr>
				  
				  <tr>
                    <td>Concern Name :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="group_for" id="group_for" tabindex="5">
                        <option></option>
                        <? foreign_relation('user_group','id','group_name',$group_for);?>
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
              <td><input name="submit" type="submit" class="btn" value="Report" tabindex="6" /></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
