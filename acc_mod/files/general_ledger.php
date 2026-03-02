<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='General Ledger';

do_calander("#f_date");
do_calander("#t_date");
do_calander("#cut_date");
create_combobox('do_no');

//auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');
//auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');

//auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and finish_goods_code>0','item_id');
?>



<style>

.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}


div.form-container_large input {
    width: 250px;
    height: 40px;
	float:left;
    border-radius: 0px !important;
}



</style>
<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
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
                              <td width="3%"><input name="report" type="radio" class="radio" value="1206202101"  checked="checked" /></td>
                              <td width="97%"><div align="left">General Ledger Report</div></td>
                            </tr>
						
							
							
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
              <td valign="top"><?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">



                  <tr>
                    <td>From: </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" style="width:250px; float:left;"/></td>
                  </tr>

                  <tr>
                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" style="width:250px; float:left;"/></td>
                  </tr>


				<tr>
                    <td>Customer Name:</td>
                    <td><span class="oe_form_group_cell">
                      <input list="dealer_name_e" name="customer_name" id="customer_name"  style="width:250px; float:left;"  onchange="getData2('buyer_ajax.php', 'buyer_filter', this.value, 
document.getElementById('customer_name').value);"  autocomplete="off" >
  <datalist id="dealer_name_e">
   
     <? foreign_relation('dealer_info','CONCAT(dealer_code, "->", dealer_name_e)','dealer_name_e',$dealer_code,'1');?>
  </datalist>
                      </span></td>
                  </tr>  
				  
				  
				
				  <tr>
                    <td>Buyer Name:</td>
                    <td><span class="oe_form_group_cell">
                     <span id="buyer_filter">

	
		 <input list="buyer_name" name="buyer" id="buyer"  style="width:250px; float:left;"   autocomplete="off" >
  <datalist id="buyer_name">
	 
	 <? foreign_relation('buyer_info','CONCAT(buyer_code, "->", buyer_name)','buyer_name',$buyer,'dealer_code="'.$dealer_code.'" order by buyer_name');?>
  </datalist>
		 </span>
                      </span></td>
                  </tr>
				  
				  
				  
				  <tr>
                    <td>Merchandiser Name:</td>
                    <td><span class="oe_form_group_cell">
                     <span id="merchandizer_filter">

	
		 <input list="merchandizer_name" name="merchandizer" id="merchandizer"  style="width:250px; float:left;"   autocomplete="off" >
  <datalist id="merchandizer_name">
	 
	<? foreign_relation('merchandizer_info','CONCAT(merchandizer_code, "->", merchandizer_name)','merchandizer_name',$merchandizer,'buyer_code="'.$buyer_code.'" order by merchandizer_name');?>
  </datalist>
		 </span>
                      </span></td>
                  </tr>
				  
				 
				  <tr>
                    <td>Job No: </td>
                    <td> 
					
					<select name="do_no" id="do_no" style="width:250px; " >
		
		<option></option>

        <?
		
		foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'1');

		?>
    </select></td>
                  </tr>
                  
                  
              </table><?php */?></td>
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