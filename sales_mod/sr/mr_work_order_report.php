<?php




 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Material Requisition Report';

$ip=$_SESSION['user']['ip'];



$php_ip=substr($_SESSION['php_ip'],0,11);



if($php_ip=='115.127.35.' || $php_ip=='115.127.24.' || $php_ip=='192.168.191'){ 

	do_calander('#f_date','-1900','0');

	do_calander('#t_date','-1900','30');

} else {

	do_calander('#f_date','-60','0');

	do_calander('#t_date','-60','30');		

}

$tr_type="Show";

auto_complete_from_db('item_info','item_name','item_id','1','item_id');



$tr_from="Warehouse";

?>







<div class="d-flex justify-content-center">

    <form class="n-form1 fo-width1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">

        <div class="row m-0 p-0">

            <div class="col-sm-5">

                <div align="left">Select Report </div>

                <div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="304" checked="checked" />

                    <label class="form-check-label p-0" for="report1-btn">

                       MR Details Report(304)

                    </label>

                </div>

                



            </div>



            <div class="col-sm-7">

                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item name:</label>

                    <div class="col-sm-8 p-0">

					<select name="item_id" id="item_id">

					<option>All</option>

					 <? foreign_relation('item_info','item_id','item_name');?>

					</select>

                       

                    </div>

                </div>



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Sub Group:</label>

                    <div class="col-sm-8 p-0">

                        <select name="item_sub_group" id="item_sub_group">

						  	<option>All</option>

						 	 <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>

                   		 </select>

                    </div>

                </div>





                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>

                    <div class="col-sm-8 p-0">

                      <span class="oe_form_group_cell">

                        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>" readonly="readonly"/>

                      </span>



                    </div>

                </div>



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>

                    <div class="col-sm-8 p-0">



                        <span class="oe_form_group_cell">

                           <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"  readonly="readonly"/>



                        </span>





                    </div>

                </div>





                









            </div>



        </div>

        <div class="n-form-btn-class">

			

            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />

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

                              <td colspan="2" class="title1"><div align="left">Select Report- <?=$ip;?> </div></td>

                              </tr>

                              



							  <tr>

							    <td width="6%">&nbsp;</td>

							    <td width="94%">&nbsp;</td>

						      </tr>

							  

							  

							  <tr>

							    <td>&nbsp;</td>

							    <td>&nbsp;</td>

						      </tr>

							  

							  <tr>

							    <td>&nbsp;</td>

							    <td>&nbsp;</td>

						      </tr>

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="304" /></td>

							    <td><div align="left">MR Details Report(304)</div></td>

						      </tr>

							  

							  <tr>

							    <td>&nbsp;</td>

							    <td>&nbsp;</td>

						      </tr>

							  

							  

							  

							  

							  



<? if( $_SESSION['user']['group']=='3'){ ?>



<? } ?>





<? if( $_SESSION['user']['group']!='3'){ ?>

<? } ?>





<? if( $_SESSION['user']['depot']=='128'){ ?>



<?php } ?>







<!--<tr>

<td><input name="report" type="radio" class="radio" value="100911" /></td>

<td><div align="left">Stock Movement Report (100911)slow</div></td>

</tr>

<tr>-->

						        

							  <!-- <tr>

                                 <td><input name="report" type="radio" class="radio" value="10011" /></td>

							     <td><div align="left">Stock Valuation Report (HFL) </div></td>

						      </tr>-->

							  <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="1004" /></td>

							    <td><div align="left">RM Consumtion Report</div></td>

						      </tr>-->

							  

							 <!-- <tr>

							    <td><input name="report" type="radio" class="radio" value="1005" /></td>

							    <td><div align="left">FG Production Report(1005)</div></td>

						      </tr>

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="1001" /></td>

							    <td><div align="left">Stock Valuation Report </div></td>

						      </tr>-->

							  

							 <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="1003" /></td>

							    <td><div align="left">Material Consumption  Report </div></td>

						      </tr>-->

<!--							  <tr>

                                <td><input name="report" type="radio" class="radio" value="1006" /></td>

							    <td><div align="left">Product Movement Detail Report(FG)(1006)</div></td>

						      </tr>

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="1007" /></td>

							    <td><div align="left">Product Movement Summary Report(FG)(1007)</div></td>

						      </tr>-->

							  





<? if($_SESSION['user']['group']=='3'){?>



<? } ?>



<? if($_SESSION['user']['group']=='10'){?>

<? } ?>





<tr>

  <td>&nbsp;</td>

  <td>&nbsp;</td>

</tr>



                               

                               

                               <tr>

                                 <td>&nbsp;</td>

                                 <td>&nbsp;</td>

                               </tr>

                               

                               <tr>

                                 <td>&nbsp;</td>

                                 <td>&nbsp;</td>

                               </tr>

                              



							  

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

                    <td>Item Name:</td>

                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>

                  </tr>

                  <tr>

                    <td>Item Sub Group:</td>

                    <td><select name="item_sub_group" id="item_sub_group">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>

                    </select></td>

                  </tr>

                  <tr>

                    <td>From:</td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>" readonly="readonly"/></td>

                  </tr>

                  <tr>

                    <td>To:</td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"  readonly="readonly"/></td>

                  </tr>

                  <tr>

                    <td>Inventory Name: </td>

                    <td><select name="warehouse_id" id="warehouse_id">

                      <option selected="selected"></option>

                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',

$_POST['warehouse_id'],'group_for="'.$_SESSION['user']['group'].'" and status="Active" order by warehouse_name');?>

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

              <td><input name="submit" type="submit" class="btn bg-success" value="Report" /></td>

            </tr>

          </table>

      </div></td>

    </tr>

  </table>

</form><?php */?>

<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>