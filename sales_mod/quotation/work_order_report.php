<?php





session_start();





ob_start();





require "../../support/inc.all.php";





$title='Material Requisition Report';











do_calander("#f_date");





do_calander("#t_date");





auto_complete_from_db('item_info','item_name','item_id','1','item_id');





?>











<form action="warehouse_master_report.php" method="post" name="form1" target="_blank" id="form1">





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

                                <td width="6%"><input name="report" type="radio" class="radio" value="200901"  checked="checked" /></td>

                                <td width="94%"><div align="left"> Purchase Requisition Breaf Report </div></td>
                              </tr>
							  
							  
							  <tr>

                          <td width="6%"><input name="report" type="radio" class="radio" value="200902" /></td>

                             <td width="94%"><div align="left"> Purchase Requisition Summary Report </div></td>
                              </tr>

                             
							  

							 <!-- <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="2006"  /></td>

                                <td width="94%"><div align="left">Daily Meal Report </div></td>
                              </tr>
							  
							  
							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="2008" /></td>

                                <td width="94%"><div align="left">Monthly Meal Report </div></td>
                              </tr>
							  
							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="200601"  /></td>

                                <td width="94%"><div align="left">Monthly Meal &amp; Mess Bill </div></td>
                              </tr>
							  
							  
							  
							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="2007"  /></td>

                                <td width="94%"><div align="left">Daily Meal Breaf Report </div></td>
                              </tr>
							  -->
							  
							 



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





                    <td>Concern: </td>





                    <td><select name="group_for" id="group_for">


                      <option></option>


                      <? foreign_relation('user_group','id','group_name','id!=7');?>



                    </select></td>

                  </tr>
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  





                



					
					<tr>





                    <td>Requisition ID:</td>


					<?
		
						auto_complete_from_db('personnel_basic_info','concat(EMP_CODE," - ",PBI_NAME)','concat(EMP_CODE)','','EMP_CODE');
		
					?>
	


                    <td><input  name="req_no" type="text" id="req_no" value="" autocomplete="off"/></td>

                  </tr>
					
					
					

                  

                  <tr>





                    <td>From:</td>





                    <td><input  name="f_date" type="text" id="f_date" value="<?= date('Y-m-d')?>"  autocomplete="off"/></td>

                  </tr>





                  <tr>





                    <td>To:</td>





                    <td><input  name="t_date" type="text" id="t_date" value="<?= date('Y-m-d')?>"  autocomplete="off"/></td>

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