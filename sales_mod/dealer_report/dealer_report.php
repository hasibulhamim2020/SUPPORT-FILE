<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Dealer Accounts Statement Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');

$tr_type="Show";

$tr_from="Sales";
?>


<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked">
                    <label class="form-check-label p-0" for="report1-btn">
                       Dealer Account
                    </label>
                </div>
                

            </div>

            <div class="col-sm-7">
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Dealer Code:</label>
                    <div class="col-sm-8 p-0">
                        <input name="dealer_code" type="text" id="dealer_code" />
                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                        <input  name="f_date" type="text" id="f_date"  value="<?=date('Y-m-01')?>"/>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">
                    	 <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>

                    </div>
                </div>

                



            </div>

        </div>
        <div class="n-form-btn-class">
			
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6">
        </div>
    </form>
</div>


<?php /*?><form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
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
                              <tr>
							  <td width="6%"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td width="94%"><div align="left">Dealer Account </div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				  <tr>
                    <td>Dealer Code :</td>
                    <td>
                    <input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/></td>
                  </tr>
				  <tr>
                    <td>From Date :</td>
                    <td>
                    <input  name="f_date" type="text" id="f_date"  value="<?=date('Y-m-01')?>"/></td>
                  </tr>
				  <tr>
                    <td>To Date :</td>
                    <td>
                    <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
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