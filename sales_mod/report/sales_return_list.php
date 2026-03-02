<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sales Return Report';

$php_ip=substr($_SESSION['php_ip'],0,11);
if($php_ip=='115.127.35.' || $php_ip=='192.168.191'){ 
do_calander('#f_date'/*,'-1800','0'*/);
do_calander('#t_date'/*,'-1800','30'*/);
} else {
	do_calander('#f_date'/*,'-365','0'*/);
	do_calander('#t_date'/*,'-365','0'*/);		
}


auto_complete_from_db('item_info','item_name','item_id','1 and product_nature="Salable"','item_id');
//auto_insert_sales_return_secoundary('8677');
?>

<form action="master_report2.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td width="6%"><input name="report" type="radio" class="radio" value="51" checked="checked" /></td>
                                <td width="94%"><div align="left">Sales Return Report(Details)(51)</div></td>
                              </tr>
							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="54" /></td>
                                <td width="94%"><div align="left">Chalan wise Sales Return Report(54)</div></td>
                              </tr>

                                <!--	<tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="52" /></td>
                                <td width="94%"><div align="left"> Sales Return Report(Details)(52)</div></td>
                                </tr>-->
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="53" /></td>
                                <td><div align="left"> Sales Return Report(Party Brief)(53)(Beta)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2001" /></td>
                                <td align="left"><div align="left">Item Wise Sales Return Report(At A Glance)(2001)</div></td>
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
                     <td>Product  Group :</td>
				     <td><span class="oe_form_group_cell">
                       <select name="product_group" id="product_group">
                         <option></option>
                         <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>
                         <option>ABCD</option>
                       </select>
                     </span></td>
			      </tr>
                  <tr>
                    <td>Item Name:</td>
                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>
                  </tr>
                  <tr>
                    <td>Item Brand : </td>
                    <td><select name="item_brand" id="item_brand">
                                          <option></option>
							<? foreign_relation('item_brand','brand_name','brand_name',$item_brand,'1 order by brand_name');?>

                                        </select></td>
                  </tr>
                  <tr>
                    <td>From:</td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>
                  </tr>
                  <tr>
                    <td>To:</td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>
				  <tr>
                    <td>Dealer Type :</td>
				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select name="dealer_type" id="dealer_type" style="width:150px;">
                        <option></option>
                        <option value="Distributor">Distributor</option>
                        <option value="Corporate">Corporate</option>
                        <option value="SuperShop">SuperShop</option>
                        <option value="TradeFair">TradeFair</option>
						<option value="BulkBuyer">BulkBuyer</option>
                        <option value="MordernTrade">SuperShop+Corporate+M-Group</option>
                      </select>
                    </span></td>
			      </tr>
                  <tr>
                    <td>Invantory Name: </td>
                    <td><select name="warehouse_id" id="warehouse_id">
					<option></option>
					  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_SESSION['user']['depot'],'use_type="SD"');?>
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
              <td><input name="submit" type="submit" class="btn" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>>