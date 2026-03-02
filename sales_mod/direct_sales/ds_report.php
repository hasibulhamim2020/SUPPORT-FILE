<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Direct Sales Report';

do_calander("#f_date");
do_calander("#t_date");
do_calander("#cut_date");
//create_combobox('dealer_code');
//auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');
//auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');
$tr_type="Show";
auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and finish_goods_code>0','item_id');

?>




<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="ds_master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" />
                    <label class="form-check-label p-0" for="report1-btn">
                       Direct Sales Report(1)
                    </label>
                </div>
                

            </div>

            <div class="col-sm-7">
                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Name:</label>
                    <div class="col-sm-8 p-0">
						<input type="text" list="item" name="item_id" id="item_id" class="form-control" />
                        <datalist id="item">
                       		 <option></option>
                      
							<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                   		 </datalist>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" class="form-control" />
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                           <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control">

                        </span>


                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Client Name:</label>
                    <div class="col-sm-8 p-0">

                       <input type="text" list="dealer" name="dealer_code" id="dealer_code" />
                           <datalist id="dealer">
                                <option></option>
                                <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>
                            </datalist>



                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Depot Name:</label>
                    <div class="col-sm-8 p-0">

                       
                          <select name="warehouse_id" id="warehouse_id" >
			 							<option></option>
                  						<? foreign_relation('warehouse w, warehouse_define d','w.warehouse_id','w.warehouse_name',$warehouse_id,					 'w.warehouse_id=d.warehouse_id and w.use_type="WH" and d.user_id="'.$_SESSION['user']['id'].'" and d.status="Active"');?>
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