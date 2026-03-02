<?php
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


do_calander("#f_date");

do_calander("#t_date");



//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>



<form action="trial_balance_master_report_new.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>


      <td><div class="box4" style="width:950px;">

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

							  					  <td><input name="report" type="radio" class="radio" value="230910001"  checked="checked" /></td>

													<td><div align="left">TRIAL BALANCE REPORT</div></td>
											 </tr>
											 
											 <tr>

							  					  <td><input name="report" type="radio" class="radio" value="230910002"  /></td>

													<td><div align="left">TRIAL BALANCE REPORT (NET BALANCE)</div></td>
											 </tr>
											 
											 
											  								 
																					 
																					
																					 
																					


                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                 

				  

                  <tr>

                    <td>From: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				 
               
                 
				  
				  
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>