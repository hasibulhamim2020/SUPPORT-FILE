<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='PARTY BALANCE REPORT';



do_calander("#f_date");

do_calander("#t_date");



//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>



<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>


      <td><div class="box4" style="width:950px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td width="51%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>

                         
											 <!--<tr>

							  					  <td><input name="report" type="radio" class="radio" value="210617001" checked="checked" /></td>

													<td><div align="left">CUSTOMER BALANCE REPORT</div></td>
											 </tr>-->
											 
											 
											 
											 <tr>

							  					  <td><input name="report" type="radio" class="radio" value="210617002"  checked="checked" /></td>

													<td><div align="left">PARTY BALANCE REPORT</div></td>
											 </tr>
											 
											 
											 
											 
											 <tr>

							  					  <td><input name="report" type="radio" class="radio" value="210617003"  /></td>

													<td><div align="left">PARTY CLOSING BALANCE</div></td>
											 </tr>
											 
											 
											 <tr>

							  					  <td><input name="report" type="radio" class="radio" value="210617004"   /></td>

													<td><div align="left">CASH IN HAND</div></td>
											 </tr>
											 
											 
											 <tr>

							  					  <td><input name="report" type="radio" class="radio" value="210617005"   /></td>

													<td><div align="left">CASH AT BANK</div></td>
											 </tr>
											 
											 
											 <tr>

							  					  <td><input name="report" type="radio" class="radio" value="210617006"   /></td>

													<td><div align="left">PAYMENT DETAILS</div></td>
											 </tr>
																					 
																					 
																					
																					 
																					 
																					
																					 
																					


                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td width="49%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                 

                 
				  
				 <?php /*?> <tr>

                    <td>Item Mother Group:</td>

                    <td><span class="oe_form_group_cell">

                      <select name="item_mother_group" id="item_mother_group"  onchange="getData2('item_mother_group_ajax.php', 'mother_group', this.value, 
document.getElementById('item_mother_group').value);">

                      <option></option>

                        <? foreign_relation('item_mother_group','id','mother_group_name',$item_mother_group);?>

                      </select>

                    </span></td>

                  </tr>
				  
				  <tr>

                    <td>Item Group: </td>

                    <td>
					<span id="mother_group">
					<select name="item_group" id="item_group"  onchange="getData2('item_sub_group_ajax.php', 'sub_group', this.value, 
document.getElementById('item_group').value);">

                      <option></option>
                      <? foreign_relation('item_group','group_id','group_name',$item_group, 'product_type="Finish Goods"');?>

                    </select>
					</span></td>
                  </tr>
				  
				  
				  
				  <tr>

                    <td>Item Sub Group: </td>

                    <td>
					<span id="sub_group">
					<select name="item_sub_group" id="item_sub_group">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, "fg_sub_group='Yes'");?>

                    </select></span></td>
                  </tr><?php */?>
				  
				  <?php /*?><tr>

                    <td>Sales Type:</td>

                    <td><select name="sale_type" id="sale_type" required  >

                     

                      <? foreign_relation('sale_type','sale_type','sale_type',$sale_type,' id!=5 order by id');?>

                    </select></td>

                  </tr><?php */?>
				  
				  
				  <tr>

                    <td width="36%">Ledger Group:</td>

                    <td width="64%"><select name="ledger_group" id="ledger_group"  onblur="getData2('acc_gl_ajax.php', 'acc_gl_ledger', this.value, 
document.getElementById('ledger_group').value);"  style="width:320px;" >
					
					<option></option>

                     

                      <? foreign_relation('ledger_group','group_id','group_name',$ledger_group,'group_id in (220301,120201,120301) order by group_id');?>

                    </select></td>

                  </tr>
				  
				  
				  <tr>

                    <td>GL Name:</td>

                    <td><span id="acc_gl_ledger"><select name="ledger_id" id="ledger_id"  style="width:320px;" >
					
					<option></option>

                     

                      <? foreign_relation('accounts_ledger','ledger_id','concat(ledger_id," - ",ledger_name)',$ledger_id,'ledger_group_id in (220301,120201) order by ledger_id');?>

                    </select></span></td>

                  </tr>
				  
				  
				  <!--<tr>

                    <td>Return Type:</td>

                    <td><select name="return_type" id="return_type"  >

                      <option></option>

                      <? foreign_relation('sale_return_type','id','return_type',$return_type,' 1 order by return_type');?>

                    </select></td>

                  </tr>-->
				  

                  <tr>

                    <td>From: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" style="width:320px;"/></td>

                  </tr>

                  <tr>

                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" style="width:320px;"/></td>

                  </tr>

				  <?php /*?><tr>

                    <td>Dealer Name:</td>

                    <td>

                    <input  name="dealer_code" type="text" id="dealer_code" style="width:200px;"/>

                    </td>

                  </tr><?php */?>
				  
			 

                  

                  <?php /*?><tr>

                    <td>Zone Name:</td>

                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                      <option></option>

                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_id,' 1 order by ZONE_NAME');?>

                    </select></span></td>

                  </tr><?php */?>

               
                 
				  
				  
				  <?php /*?><tr>
                    <td>Company:</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select class="form-control" name="group_for" id="group_for" >
                        <option></option>
                        <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                      </select>
                      </span></td>
                  </tr><?php */?>

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