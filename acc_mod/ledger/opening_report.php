<?php


session_start();


ob_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Ledger Opening Report';


//create_combobox("ledger_id");
//create_combobox("group_id");


do_calander("#f_date");


do_calander("#t_date");


auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');


?>


    <form  action="opening_master_report.php" method="post" name="form1" target="_blank" id="form1">
<div class="d-flex justify-content-center">

	<div class="n-form1 fo-width1 pt-4">
	<div class="container-fluid">
	
	<div class="row  m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="11" checked="checked" tabindex="1">
                    <label class="form-check-label p-0" for="report1-btn">
                        Ledger Opening Report
                    </label>
                </div>
				

            </div>

            <div class="col-sm-7">
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Ledger Group:</label>
                    <div class="col-sm-8 p-0">
					
                       <input type="text" list="group_ids" name="group_id" id="group_id" >
					   <datalist id="group_ids">
					  	<option></option>
						<?=foreign_relation('ledger_group','group_id','group_name','1');?>
					  </datalist>
                    </div>
                </div>

      			<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Ledger</label>
                    <div class="col-sm-8 p-0">
                       	<input type="text" list="ledger_ids" name="ledger_id" id="ledger_id" >
						<datalist id="ledger_ids">
					  	<option></option>
						<?=foreign_relation('accounts_ledger','ledger_id','ledger_name','1');?>
					  </datalist>
					  
                    </div>
                </div>

            </div>
			

        </div>
		
			<div class="n-form-btn-class">
				<input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
			</div>
	
	
	
	
	</div>
	
	
	
	
	

	
	</div>
        


</div>
    </form>

<br /><br />

<!--<form action="opening_master_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">-->
                              
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1" tabindex="1"/></td>
                                <td><div align="left">Finish Good Product List</div></td>
                              </tr>-->
							  
							  
							<!--  <tr>
                                <td><input name="report" type="radio" class="radio" value="888" tabindex="2"/></td>
                                <td><div align="left">Product Information (Rate Changable)</div></td>
                              </tr>-->
							  
							  
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="11" checked="checked" tabindex="11"/></td>
                                <td><div align="left">Ledger Opening Report</div></td>
								
                              </tr>-->
							  <tr>
							  
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="118888"  tabindex="2"/></td>
                                <td><div align="left">Product Information (MINWAL)</div></td>
                              </tr>-->
							  
							  
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="888811" tabindex="2"/></td>
                                <td><div align="left">Turky Sajjada & Swadie Item</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="888822" tabindex="2"/></td>
                                <td><div align="left">Zadi Item Information</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="888833" tabindex="2"/></td>
                                <td><div align="left">Minwal Carpet Item List</div></td>
                              </tr>-->
							  
							  
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
                      <!--      </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">-->
                  
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
				  
				 
				 
				  
				<?php /*?>   <tr>
                    <td>Ledger Group :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="group_id" id="group_id"  style="width:250px;">
					  	<option></option>
						<?=foreign_relation('ledger_group','group_id','group_name','1');?>
					  </select>
                      </span></td>
                  </tr>
				  
				    <td>Ledger:</td>
                    <td><span class="oe_form_group_cell">
                      <select name="ledger_id" id="ledger_id"  style="width:250px;">
					  	<option></option>
						<?=foreign_relation('accounts_ledger','ledger_id','ledger_name','1');?>
					  </select>
                      </span></td>
                  </tr><?php */?>
				  
				  
				  
				  
				  
				  
				  
				  <!--<tr>
                    <td>Concern Name :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="group_for" id="group_for" tabindex="5">
                        <option></option>
                        <? foreign_relation('user_group','id','group_name',$group_for);?>
                      </select>
                      </span></td>
                  </tr>-->
          
				  
         <!--       </table></td>
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
              <td><input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" /></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>-->
<?


$main_content=ob_get_contents();


ob_end_clean();


require_once SERVER_CORE."routing/layout.bottom.php";


?>
