<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Delivery Order Advence Reports';



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

                                <td><input name="report" type="radio" class="radio" value="1" /></td>

                                <td><div align="left">Product List Summary</div></td>

                              </tr>-->

<!--                              <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>

                                <td width="94%"><div align="left">Product List Details</div></td>

                              </tr>
-->
                              <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="3" /></td>

                                <td width="94%"><div align="left">Product List Details</div></td>

                              </tr>

                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                 <!-- <tr>

                    <td width="10%">Sales Group :</td>

                    <td width="80%"><span class="oe_form_group_cell">

                      <select name="product_group" id="product_group">

                      <option></option>

                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>

                      </select>

                    </span></td>

                  </tr>-->

                   <!-- <tr>

                  <td width="10%">Product Brand : </td>

                    <td width="80%"><select name="item_brand" id="item_brand">

                                          <option></option>

                                          <option value="Tang">Tang</option>

                                          <option value="Bourn Vita">Bourn Vita</option>

                                          <option value="Oreo">Oreo</option>

                                          <option value="Shezan">Shezan</option>

                                          <option value="Promotional">Promotional</option>

										  <option value="Memo">Memo</option>

                                          <option value="Top">Top</option>

                                          <option value="Kolson">Kolson</option>

                                          <option value="Nocilla">Nocilla</option>

                                          <option value="Sajeeb">Sajeeb</option>

                                        </select></td>

                  </tr>
-->
                  <tr>

                    <td width="55%">Product Nature :</td>

                    <td width="45%"><span id="branch" class="oe_form_group_cell">

                      <select name="product_nature" id="product_nature">

                        <option></option>

<option value="Salable">Salable</option>

<option value="Purchasable">Purchasable</option>

<option value="Both">Both</option>

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