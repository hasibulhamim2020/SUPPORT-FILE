<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Chart of Accounts';

do_calander("#f_date");
do_calander("#t_date");

create_combobox('item_id');



auto_complete_from_db('item_info i, item_sub_group s','i.item_name','i.item_id','i.product_nature="Salable"  and i.sub_group_id=s.sub_group_id 
order by s.sub_group_id, i.item_name','item_search');

?>
<div class="d-flex justify-content-center">
<form class="n-form1 pt-4 fo-width" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div style="text-align: left;">Select Report</div>

                <div class="form-check">				
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="251022001" checked="checked"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        Chart of Accounts
                    </label>
                </div>

            </div>

            <div class="col-sm-7">
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Accounts Class: </label>
                    <div class="col-sm-8 p-0">
                        									<select name="acc_class" id="acc_class" style="width:220px;" 
    onchange="getData2('acc_sub_class_ajax.php', 'sub_class', this.value, 
    document.getElementById('acc_class').value);">
    <option></option>
    <?php foreign_relation(
        'acc_class',
        'id',
        'CONCAT(id, ": ", class_name)',
        $acc_class,
        '1'
    ); ?>
</select>

                    					
                    					
                    					
                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Acc. Sub Class: </label>
                    <div class="col-sm-8 p-0">
                        <span id="sub_class">
									
<select name="acc_sub_class" id="acc_sub_class" style="width:220px;">
    <option></option>
    <?php foreign_relation(
        'acc_sub_class',
        'id',
        'CONCAT(id, ": ", sub_class_name)',
        $acc_sub_class,
        'id="'.$acc_sub_class.'"'
    ); ?>
</select>


                    					
                    					</span>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Acc. Sub Sub Class: </label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        										<span id="sub_sub_class">
                        										    

<select name="acc_sub_sub_class" id="acc_sub_sub_class" style="width:220px;">
    <option></option>
    <?php foreign_relation(
        'acc_sub_sub_class',
        'id',
        'CONCAT(id, ": ", sub_sub_class_name)',
        $acc_sub_sub_class,
        'id="'.$acc_sub_sub_class.'"'
    ); ?>
</select>


                    					
                    					
                    					</span>
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">GL Group:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            										<span id="acc_group">
                            										   
<select name="ledger_group_id" id="ledger_group_id" style="width:220px;">
    <option></option>
    <?php foreign_relation(
        'ledger_group',
        'group_id',
        'CONCAT(group_id, ": ", group_name)',
        $ledger_group_id,
        'group_id="'.$ledger_group_id.'"'
    ); ?>
</select>

                    					</span>

                        </span>


                    </div>
                </div>


            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report"/>
        </div>
    </form>
</div>




<?



require_once SERVER_CORE."routing/layout.bottom.php";

?>