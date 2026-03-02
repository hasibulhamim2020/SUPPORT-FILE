<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Party Balance Report';



do_calander("#f_date");

do_calander("#t_date");



//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>










    <div class="d-flex justify-content-center">
        <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
            <div class="row m-0 p-0 fo-width">
                <div class="col-sm-5">
                    <div align="left">Select Report </div>
                    <div class="form-check">
                        <input name="report" type="radio" class="radio1" id="report1-btn" value="210617002"  checked="checked" />
                        <label class="form-check-label p-0" for="report1-btn">
                            Party Balance Report 
                        </label>
                    </div>
                    <div class="form-check">
                        <input name="report" type="radio" class="radio1" id="report2-btn" value="210617003"  />
                        <label class="form-check-label p-0" for="report2-btn">
                            Party Closing Losing Balance
                        </label>
                    </div>

                </div>

                <div class="col-sm-7">
                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Ledger Group :	</label>
                        <div class="col-sm-8 p-0">
                            <select name="ledger_group" id="ledger_group"  onblur="getData2('acc_gl_ajax.php', 'acc_gl_ledger', this.value,
document.getElementById('ledger_group').value);" class="form-control" >

                                <option></option>
                                <option>test</option>


                                <? foreign_relation('ledger_group','group_id','group_name',$ledger_group,'group_id in (10203) order by group_id');?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">GL Name :</label>
                        <div class="col-sm-8 p-0">
                                                <span id="acc_gl_ledger">
                            <select name="ledger_id" id="ledger_id"  class="form-control" >

                                <option></option>



                                <? foreign_relation('accounts_ledger','ledger_id','concat(ledger_id," - ",ledger_name)',$ledger_id,'ledger_group_id in (220301,120201) order by ledger_id');?>

                            </select>
                                                </span>
                        </div>
                    </div>


                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date :</label>
                        <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" class="form-control"/>
                      </span>

                        </div>
                    </div>

                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date :</label>
                        <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" class="form-control"/>

                        </span>


                        </div>
                    </div>



                </div>

            </div>
            <div class="n-form-btn-class">
                <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" />
            </div>
        </form>
    </div>









<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>