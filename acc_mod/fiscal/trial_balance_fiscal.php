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



<form action="master_report_new.php" method="post" name="form1" target="_blank" id="form1">

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

                    <td>Fiscal Year: </td>

                    <td><select name="fiscal_year" id="fiscal_year" required>
										  <option></option>
										  <? foreign_relation('fiscal_year','id','fiscal_year',$_POST['fiscal_year'],'status="Active"')?>
										  </select></td>

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
        <td>
            <input name="submit" type="submit" class="btn" value="Report" style="background-color:#0099FF; color:#fff;" />
        </td>
    </tr>
</table>

      </div></td>

    </tr>

  </table>

</form>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>