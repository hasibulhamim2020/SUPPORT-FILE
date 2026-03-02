<?php


session_start();


ob_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Area Setup Reports';





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
                              </tr>
							  
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="888" tabindex="2"/></td>
                                <td><div align="left">Product Information (Rate Changable)</div></td>
                              </tr>-->
							  
							  
							<!--  <tr>
                                <td><input name="report" type="radio" class="radio" value="8888" tabindex="2"/></td>
                                <td><div align="left">Product Information (Rate Changable)</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="8889" tabindex="2"/></td>
                                <td><div align="left">Product Rate Change Information</div></td>
                              </tr>-->
							  
							  
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="8890" checked="checked" tabindex="2"/></td>
                                <td><div align="left">Area and Transport Charges Information</div></td>
                              </tr>
							  
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="8891"  tabindex="2"/></td>
                                <td><div align="left">Area Transport Charge Change Information</div></td>
                              </tr>
							  
							  
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
                    <td>Zone Name :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="zon_id" id="zon_id" tabindex="5">
                        <option></option>
                        <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zon_id, 'ZONE_CODE!=1');?>
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


$main_content=ob_get_contents();


ob_end_clean();


require_once SERVER_CORE."routing/layout.bottom.php";


?>
