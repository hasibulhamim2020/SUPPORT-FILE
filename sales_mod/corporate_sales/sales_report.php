<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Corporate Sales Order Report';
$tr_type="Show";
if($_SESSION['ip']=='115.127.35.125'){ 
do_calander('#f_date'/*,'-360','0'*/);
do_calander('#t_date'/*,'-360','0'*/);
} else {

		if($_SESSION['user']['id']!=='10807'){
			do_calander('#f_date'/*,'-60','0'*/);
			do_calander('#t_date'/*,'-60','0'*/);
			} else {
			do_calander('#f_date'/*,'-60','0'*/);
			do_calander('#t_date'/*,'-60','0'*/);
			}
}
auto_complete_from_db('item_info','item_name','item_id','1 and product_nature="Salable"','item_id');
$tr_from="Sales";
?>


<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" />
                    <label class="form-check-label p-0" for="report1-btn">
                       Corporate Sales Order Report
                    </label>
                </div>
                

            </div>

            <div class="col-sm-7">
                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name:</label>
                    <div class="col-sm-8 p-0">
                        <select name="item_id" id="item_id" class="form-control">
                       		 <option></option>
                      
							<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                   		 </select>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Dealer Name:</label>
                    <div class="col-sm-8 p-0">
                        <select name="dealer_code" id="dealer_code">
						  <option></option>
						  <? foreign_relation('dealer_info','dealer_code','dealer_name_e');?>
						</select>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Brand:</label>
                    <div class="col-sm-8 p-0">
                        <select name="item_brand" id="item_brand">
						  <option></option>
						  <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>
						</select>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/>
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">

                        <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>


                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Client Name:</label>
                    <div class="col-sm-8 p-0">

                       
                           <select name="dealer_code" id="dealer_code">
                                <option></option>
                                <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>
                            </select>



                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Depot Name:</label>
                    <div class="col-sm-8 p-0">

                       
                           <select name="warehouse_id" id="warehouse_id">
							  <? foreign_relation('warehouse','warehouse_id','warehouse_name');?>
							</select>



                    </div>
                </div>


            </div>

        </div>
        <div class="n-form-btn-class">
			
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
        </div>
    </form>
</div>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>