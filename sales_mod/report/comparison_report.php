<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Delivery Order Advence Reports';

$php_ip=substr($_SESSION['php_ip'],0,11);
if($php_ip=='115.127.35.' || $php_ip=='192.168.191'){ 
do_calander('#f_date','-1800','0');
do_calander('#t_date','-1800','30');
} else {
	do_calander('#f_date','-365','0');
	do_calander('#t_date','-365','0');		
}

auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');
auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature in ("Salable", "Both") and finish_goods_code>0 and finish_goods_code<5000','item_id');?>

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
                                <td colspan="2" class="title1"><div align="left">Select Report <?=$_SESSION['ip']?></div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="99" /></td>
                                <td><div align="left">Dealer Perfromance Report(DO-Chalan)(99)</div></td>
                              </tr>
							  
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="401" /></td>
                                <td><div align="left">Dealer DO VS Chalan (Single Item)(401)</div></td>
                              </tr>							  
							  
<!--                              <tr>
                                <td><input name="report" type="radio" class="radio" value="991" /></td>
                                <td><div align="left">Dealer Perfromance Report(DO-Chalan)(991)(All)</div></td>
                              </tr>
							  
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="100" /></td>
                                <td><div align="left">Dealer Perfromance Report(100)</div></td>
                              </tr>-->
							                                <tr>
                            <!--    <td><input name="report" type="radio" class="radio" value="501" /></td>
                                <td><div align="left">Dealer Sales Report(Brand Wise)(501)</div></td>
                              </tr>-->
                             
							 
							 <!-- <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="101" /></td>
                                <td width="94%"><div align="left">Four(4) Months Comparison Report(CTR)(101) </div></td>
                              </tr>
							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="102" /></td>
                                <td width="94%"><div align="left">Four(4) Months Comparison Report(TK)(102)</div></td>
                              </tr>
							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="103" /></td>
                                <td width="94%"><div align="left">Four(4) Months Regional Report(CTR)(103)</div></td>
                              </tr>
							  							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="104" /></td>
                                <td width="94%"><div align="left">Four(4) Months Regional Report(TK)(104)</div></td>
                              </tr>
							  							  							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="105" /></td>
                                <td width="94%"><div align="left">Four(4) Months Area Report(CTR)(105)</div></td>
</tr>
			  
			  <tr>
				<td><input name="report" type="radio" class="radio" value="106" /></td>
				<td><div align="left">Four(4) Months Area Report(TK)(106)</div></td>
</tr>-->



			  <tr>
				<td><input name="report" type="radio" class="radio" value="116" /></td>
				<td><div align="left">Single Item Sales Report(Zone Wise)(116)</div></td>
</tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
</tr>
			  <tr>
				<td><input name="report" type="radio" class="radio" value="2005" /></td>
				<td><div align="left">2018-2020 Item Wise  National Sales-Ctn(2005) </div></td>
</tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
</tr>
			  <tr>
				<td><input name="report" type="radio" class="radio" value="2002" /></td>
				<td><div align="left">Y2Y Item Wise Sales (Periodical)(2002)</div></td>
			  </tr>
			  <tr>
				<td><input name="report" type="radio" class="radio" value="2022" /></td>
				<td><div align="left">M2M Item Wise Sales (Periodical)(2022)</div></td>
			  </tr>
			  <tr>
				<td><input name="report" type="radio" class="radio" value="2003" /></td>
				<td><div align="left">2018 Vs 2019 Party Wise Sales Report(Select Item)(2003)</div></td>
</tr>
<tr>
						<td><input name="report" type="radio" class="radio" value="2004" /></td>
						<td><div align="left">Last Year Vs This Year Item Wise Sales Report(With National Target)(2004)</div></td>
</tr>
				<!--  <tr>
                    <td><input name="report" type="radio" class="radio" value="2008" /></td>
				    <td><div align="left">National Sales Vs National Target(Year 2 Year Item wise)(2008)</div></td>
				    </tr>-->
</tr>
			  <tr>
				<td><input name="report" type="radio" class="radio" value="3001" /></td>
				<td><div align="left">Y2Y Zone/Item wise Sales(3001)</div></td>
</tr>										
				  
				  
				  
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
</tr>
				  <tr>
					<td><input name="report" type="radio" class="radio" value="2006" /></td>
					<td><div align="left">Year 2 Year Item Wise Sales Report(With Target)(2006)</div></td>
</tr>
				  <tr>
                    <td><input name="report" type="radio" class="radio" value="2007" /></td>
				    <td><div align="left">Party wise Target Vs Sales(2007)</div></td>
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
					<td><input name="report" type="radio" class="radio" value="20031" /></td>
					<td><div align="left">2018 Vs 2019 Region Wise Sales Report(Select Item)(20031)</div></td>
</tr>
			  <tr>
					<td><input name="report" type="radio" class="radio" value="20032" /></td>
					<td><div align="left">2018 Vs 2019 Zone Wise Sales Report(Select Item)(20032)</div></td>
</tr>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
</tr>
				  <tr>
					<td><input name="report" type="radio" class="radio" value="107" /></td>
					<td><div align="left">Yearly Regional Sales Report(TK)(107)</div></td>
</tr>
				  <tr>
					<td><input name="report" type="radio" class="radio" value="108" /></td>
					<td><div align="left">Yearly Regional Sales Report(Per Item)(CTN)(108)</div></td>
</tr>
<tr>
	<td><input name="report" type="radio" class="radio" value="109" /></td>
	<td><div align="left">Yearly Regional Sales Report(Per Item)(TK)(109)</div></td>
</tr>

<tr>
	<td><input name="report" type="radio" class="radio" value="110" /></td>
	<td><div align="left">Yearly Zone Wise Sales Report(TK)(Select Region)(110)</div></td>
</tr>

<tr>
	<td><input name="report" type="radio" class="radio" value="111" /></td>
	<td><div align="left">Yearly Zone Wise Sales Report(Per Item)(CTN)(Select Region)(111)</div></td>
</tr>

<tr>
	<td><input name="report" type="radio" class="radio" value="112" /></td>
	<td><div align="left">Yearly Zone Wise Sales Report(Per Item)(TK)(Select Region)(112)</div></td>
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
  <td><input name="report" type="radio" class="radio" value="1130" /></td>
  <td><div align="left">Corporate Party Wise Sales Report YEARLY(1130)</div></td>
</tr>
<tr>
	<td><input name="report" type="radio" class="radio" value="11301" /></td>
	<td><div align="left">Super Shop Party Wise Sales Report YEARLY(11301)</div></td>
</tr>

<tr>
  <td><input name="report" type="radio" class="radio" value="2009" /></td>
  <td><div align="left">Modern Trade Sales Vs Target (2009)</div></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
	<td><input name="report" type="radio" class="radio" value="113" /></td>
	<td><div align="left">Yearly Dealer Wise Sales Report(TK)(Select Zone)(113)</div></td>
</tr>

<tr>
	<td><input name="report" type="radio" class="radio" value="114" /></td>
	<td><div align="left">Yearly Dealer Wise Sales Report(Per Item)(CTN)(Select Zone)(114)</div></td>
</tr>

<tr>
  <td><input name="report" type="radio" class="radio" value="115" /></td>
  <td><div align="left">Yearly Dealer Wise Sales Report(Per Item)(TK)(Select Zone)(115)</div></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input name="report" type="radio" class="radio" value="201" /></td>
  <td><div align="left">Group wise Sales Comparison Report (201)</div></td>
</tr>

                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="104%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td width="44%">  Group:</td>
                    <td width="56%"><span class="oe_form_group_cell">
                      <select name="product_group" id="product_group">
                      <option></option>
                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP,'1 order by group_name');?>
						<option>ABD</option>
						<option>CE</option>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Brand : </td>
                    <td><select name="item_brand" id="item_brand">
                                          <option></option>
							<? foreign_relation('item_brand','brand_name','brand_name',$item_brand,'1 order by brand_name');?>

                                        </select></td>
                  </tr>
                  <tr>
                    <td>Name : </td>
                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>
                  </tr>
                  <tr>
                    <td>To : </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>
				  <tr>
				    <td>Month List : </td>
				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
				      <select name="month_id" id="month_id" style="width:150px;">
                        <option></option>
                        <option value="1">January</option>
						<option value="2">February</option>
						<option value="3">March</option>
						<option value="4">April</option>
						<option value="5">May</option>
						<option value="6">June</option>
						<option value="7">July</option>
						<option value="8">August</option>
						<option value="9">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
                      </select>
				    </span></td>
			      </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
                    <td>Dealer  :</td>
                    <td>
                    <input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/>                    </td>
                  </tr>
					
				  <tr>
				    <td>Dealer Type :</td>
				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
				      <select name="dealer_type" id="dealer_type" style="width:150px;">
                        <option></option>
                        <option value="Distributor" >Distributor</option>
                        <option value="Corporate" >Corporate</option>
                        <option value="SuperShop" >SuperShop</option>
                        <option value="TradeFair" >TradeFair</option>
                        <option value="MordernTrade" >SuperShop+Corporate+M-Group</option>
						
                      </select>
				    </span></td>
			      </tr>
				  <tr>
				    <td>DO Status :</td>
				    <td><select name="status" id="status">
					    <option value="">All</option>
                        <option value="CHECKED">PROCESSION</option>
                        <option value="UNCHECKED">UNCHECKED</option>
					    <option value="DONE">DONE</option>
			        </select></td>
			      </tr>
				  <tr>
                    <td>DO No: </td>
                    <td><input  name="do_no" type="text" id="do_no" value=""/></td>
                  </tr>
                  <tr>
                    <td>Region Name :</td>
                    <td><span id="branch" class="oe_form_group_cell">
                      <select name="region_id" id="region_id" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                        <option></option>
                        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Zone Name :</td>
                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                      <option></option>
                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');?>
                    </select></span></td>
                  </tr>
                  <tr>
                    <td>Area Name :</td>
                    <td><span id="area"><select name="area_id" id="area_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                    <option></option>
                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                    </select></span></td>
                  </tr>
                  <tr>
                    <td>Depot Name :</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select name="depot_id" id="depot_id" style="width:150px;">
                        <option></option>
                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' group_for = "'.$_SESSION['user']['group'].'" ');?>
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