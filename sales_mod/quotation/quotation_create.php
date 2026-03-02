<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
$tr_type = "Show";
$page_name="Quotation Create";

$depot = $_SESSION['user']['depot'];

$title = 'Sales Quotation Create';

do_calander('#est_date');

do_calander('#do_date');

$page = 'quotation_create.php';




$depot_id = $_POST['depot_id'];





if ($_POST['dealer'] > 0)





    $dealer_code = $_POST['dealer'];





$dealer = find_all_field('dealer_info', '', 'dealer_code=' . $dealer_code);





//$depot_id = find_a_field('warehouse','warehouse_name','warehouse_id='.$dealer->depot);





$table_master = 'sale_requisition_master';





$unique_master = 'do_no';





$table_detail = 'sale_requisition_details';





$unique_detail = 'id';





if ($_REQUEST['old_do_no'] > 0)





    $$unique_master = $_REQUEST['old_do_no'];
elseif (isset($_GET['del'])) {
    $$unique_master = find_a_field('sale_requisition_details', 'do_no', 'id=' . $_GET['del']);
    $del = $_GET['del'];
} else





    $$unique_master = $_REQUEST[$unique_master];





if (prevent_multi_submit()) {





    if (isset($_POST['new'])) {


        $tr_type = "Initiate";

        $crud = new crud($table_master);





        $_POST['entry_at'] = date('Y-m-d H:i:s');





        $_POST['entry_by'] = $_SESSION['user']['id'];





        if ($_POST['flag'] < 1) {





            $_POST['do_no'] = find_a_field($table_master, 'max(do_no)', '1') + 1;





            $$unique_master = $crud->insert();





            unset($$unique);





            $type = 1;





            $msg = 'Work Order Initialized. (Demand Order No-' . $$unique_master . ')';


            $tr_type = "Initiate";


        } else {





            $crud->update($unique_master);





            $sql = "update sale_requisition_details set dealer_code=" . $_POST['dealer_code'] . " where do_no=" . $$unique_master . "";





            db_query($sql);





            $type = 1;
            $tr_type = "Edit";





            $msg = 'Successfully Updated.';





        }





    }





    if (isset($_POST['add']) && ($_POST[$unique_master] > 0) && $_SESSION['csrf_token'] === $_POST['csrf_token']) {

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));



        $details_insert = new crud($table_detail);





        //$_POST['unit_price']=$_POST['unit_price2'] ;





        $details_insert->insert();





        unset($$unique);





        $type = 1;





        $msg = 'Item Entry Succesfull';


        $tr_type = "Add";


    }





} else {





    $type = 0;





    $msg = 'Data Re-Submit Error!';





}





if ($del > 0) {





    $main_del = find_a_field($table_detail, 'gift_on_order', 'id = ' . $del);





    $crud = new crud($table_detail);





    if ($del > 0) {


        


        $condition = $unique_detail . "=" . $del;





        $crud->delete_all($condition);





        $condition = "gift_on_order=" . $del;





        $crud->delete_all($condition);





        if ($main_del > 0) {





            $condition = $unique_detail . "=" . $main_del;





            $crud->delete_all($condition);





            $condition = "gift_on_order=" . $main_del;





            $crud->delete_all($condition);
        }





    }





    $type = 1;
    $tr_type = "Delete";





    $msg = 'Successfully Deleted.';





}





if ($$unique_master > 0) {





    $condition = $unique_master . "=" . $$unique_master;





    $data = db_fetch_object($table_master, $condition);





    foreach ($data as $key => $value) {
        $$key = $value;
    }





}





$dealer = find_all_field('dealer_info', '', 'dealer_code=' . $dealer_code);





if ($dealer->product_group != 'M')
    $dgp = $dealer->product_group;





auto_complete_start_from_db('item_info', 'item_id', 'item_name', '1', 'item3');





?>





<script language="javascript">





    function count() {





        var unit_price = ((document.getElementById('unit_price').value) * 1);





        var dist_unit = ((document.getElementById('dist_unit').value) * 1);





        var total_unit = dist_unit;





        var total_amt = (total_unit * unit_price);





        document.getElementById('total_unit').value = total_unit;





        document.getElementById('total_amt').value = total_amt.toFixed(2);





        var do_total = ((document.getElementById('do_total').value) * 1);





        var do_ordering = total_amt + do_total;





        document.getElementById('do_ordering').value = do_ordering.toFixed(2);





    }





</script>





<script language="javascript">





    function focuson(id) {





        if (document.getElementById('item').value == '')





            document.getElementById('item').focus();





        else





            document.getElementById(id).focus();





    }





</script>





<script>





    /////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////





    function insert_item() {





        var item1 = $("#item");





        var dist_unit = $("#dist_unit");





        if (item1.val() == "" || dist_unit.val() == "") {





            alert('Please check Item ID,Qty');





            return false;





        }





        $.ajax({





            url: "do_input_ajax.php",





            method: "POST",





            dataType: "JSON",





            data: $("#codz").serialize(),





            cache: false,





            success: function (result, msg) {





                var res = result;





                $("#codzList").html(res);





                $("#t_amount").val(res[1]);





                $("#item").val('');





                $("#item2").val('');





                $("#dist_unit").val('');





                $("#total_amt").val('');





                $("#delivery").val('Ex-Stock');





                $("#dist_unit").val('1');





            }





        });





    }





</script>





<script language="javascript">





    function grp_check(id) {





        if (document.getElementById("item").value != '') {





            var myCars = new Array();





            myCars[0] = "01815224424";





            <?





            //$item_i = 1;
            




            //$sql_i='select finish_goods_code from item_info where product_nature="Salable"';
            




            //$query_i=db_query($sql_i);
            




            //while($is=mysqli_fetch_object($query_i))
            




            //{
            




            //echo 'myCars['.$item_i.']="'.$is->finish_goods_code.'";';
            




            //$item_i++;
            




            //}
            




            ?>





            //var item_check=id;





            //var f=myCars.indexOf(item_check);





            //if(f>0)





            getData2('do_ajax_s.php', 'do', document.getElementById("item").value, '<?= $depot_id . '#' . $dealer_code; ?>',);





            //else





            //{





            //alert('Item is not Accessable');





            //document.getElementById("item").value='';





            //document.getElementById("item").focus();





            //}





        }





    }





</script>





<script language="javascript">





    function type_check() {





        var type = document.getElementById('vat_type').value;





        if (type == 1) {





            var vat = document.getElementById('vat_div');





            vat.style.display = 'block';





        }





        else if (type == 2) {





            var ait = document.getElementById('ait_div');





            ait.style.display = 'block';





        }





        else if (type == 3) {





            var vat_ait = document.getElementById('vat_ait_div');





            vat_ait.style.display = 'block';





        }





    }





    function vat_fnc() {





        // Get the checkbox





        var checkBox = document.getElementById("vat_box");





        if (checkBox.checked == true) {





            var vat = document.getElementById('vat_div');





            vat.style.display = 'block';





        } else {





            vat.style.display = 'hidden';





        }





    }





    function ait_fnc() {





        // Get the checkbox





        var checkBox = document.getElementById("ait_box");





        if (checkBox.checked == true) {





            var vat = document.getElementById('ait_div');





            vat.style.display = 'block';





        } else {





            vat.style.display = 'hidden';





        }





    }





    function vat_ait_fnc() {





        // Get the checkbox





        var checkBox = document.getElementById("vat_ait_box");





        if (checkBox.checked == true) {





            var vat = document.getElementById('vat_ait_div');





            vat.style.display = 'block';





        } else {





            vat.style.display = 'hidden';





        }





    }





</script>





<style type="text/css">
    <!--
    .style1 {





        color: #FFFFFF;





        font-weight: bold;





    }
    -->
    .ac_results
    {
    width:inherit
    !important;
    }
    .ac_results
    >
    ul
    {
    height:250px;
    }





</style>





<!--DO create 2 form with table-->





<div class="form-container_large">





    <form action="<?= $page ?>" method="post" name="codz2" id="codz2">





        <!--        top form start hear-->





        <div class="container-fluid bg-form-titel">





            <div class="row">





                <!--left form-->





                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">





                    <div class="container n-form2">





                        <div class="form-group row m-0 pb-1">





                            <label
                                class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quo.
                                No :</label>





                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">





                                <input name="do_no" type="hidden" id="do_no" value="<? if ($$unique_master > 0)
                                    echo $$unique_master;
                                else
                                    echo (find_a_field($table_master, 'max(' . $unique_master . ')', '1') + 1); ?>"
                                    readonly />





                                <input name="do_no1" type="text" id="do_no1" value="Q-000<? if ($$unique_master > 0)
                                    echo $$unique_master;
                                else
                                    echo (find_a_field($table_master, 'max(' . $unique_master . ')', '1') + 1); ?>"
                                    readonly />





                            </div>





                        </div>





                        <div class="form-group row m-0 pb-1">





                            <label
                                class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Dealer
                                :</label>





                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                                <select id="dealer_code" name="dealer_code" readonly="readonly">





                                    <? foreign_relation('dealer_info', 'dealer_code', 'dealer_name_e', $dealer->dealer_code, '1'); ?>





                                </select>





                            </div>





                        </div>





                        <!--<div class="form-group row m-0 pb-1">





<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Unit :</label>





<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





<input type="text" id="unit" name="unit" value="<?= $unit ?>">





</div>





</div>-->





                        <!--<div class="form-group row m-0 pb-1">





<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Attn :</label>





<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





<input type="text" id="attn" name="attn" value="<? if ($attn == '')
    echo $dealer->propritor_name_e;
else
    echo $attn; ?>">





</div>





</div>-->





                        <div class="form-group row m-0 pb-1">





                            <label
                                class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Address
                                :</label>





                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                                <input type="text" id="delivery_address" name="delivery_address" value="<? if ($delivery_address == '')
                                    echo $dealer->address_e;
                                else
                                    echo $delivery_address; ?>">





                            </div>





                        </div>





                        <!--<div class="form-group row m-0 pb-1">





<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req No :</label>





<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





<input type="text" id="ref_no" name="ref_no" value="<?= $ref_no ?>">





</div>





</div>-->





                        <div class="form-group row m-0 pb-1">





                            <label
                                class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse:</label>





                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                                <select id="depot_id" name="depot_id" required>





                                    <? foreign_relation('warehouse', 'warehouse_id', 'warehouse_name', $_POST['depot_id'], '1 and warehouse_id="' . $_SESSION['user']['depot'] . '"') ?>





                                </select>





                            </div>





                        </div>





                        <div class="form-group row m-0 pb-1">





                            <label
                                class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sale
                                Type :</label>





                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                                <select id="sale_type" name="sale_type" readonly="readonly">





                                    <option value="Regular">Receivable





                                    </option>





                                </select>





                            </div>





                        </div>





                        <div class="form-group row m-0 pb-1">





                            <label
                                class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quo.
                                By:</label>





                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                                <input type="text" id="quo_by" name="quo_by" value="<?= $quo_by ?>">





                            </div>





                        </div>





                        <div class="form-group row m-0 pb-1">





                            <label
                                class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req.
                                Date :</label>





                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                                <input name="do_date" type="text" id="do_date"
                                    value="<?= ($do_date != '') ? $do_date : date('Y-m-d') ?>" />





                            </div>





                        </div>





                    </div>





                </div>





                <!--Right form-->





                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">


                    <div class="form-check">
                        <input type="hidden" name="vat_box" value="0" />
                        <input type="checkbox" id="vat_box" name="vat_box" value="1" <?php if ($vat_box == 1)
                            echo "checked='checked'"; ?> onclick="vat_fnc()">
                        <label class="form-check-label p-0 pr-1 pt-1" for="vat_box">VAT : </label>
                    </div>

                    <div id="vat_div" class="form-group row m-0 pb-1" style="display:<?php if ($vat > 0)
                        echo "block";
                    else
                        echo "none"; ?>">
                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">VAT
                            (%):</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                            <input name="vat" type="text" id="vat" value="<?= $vat; ?>" />
                        </div>
                    </div>













                    <div class="form-check">
                        <input type="hidden" name="ait_box" value="0" />
                        <input type="checkbox" id="ait_box" name="ait_box" value="1" <? if ($ait_box == 1)
                            echo "checked='checked'"; ?> onclick="ait_fnc()">
                        <label class="form-check-label p-0 pr-1 pt-1" for="ait_box">Ait : </label>
                    </div>
                    <div id="ait_div" class="form-group row m-0 pb-1" style="display:<? if ($ait > 0)
                        echo "block";
                    else
                        echo "none"; ?>">
                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">AIT
                            (%):</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                            <input name="ait" type="text" id="ait" value="<?= $ait; ?>" />
                        </div>
                    </div>





                    <div class="form-check">





                        <input type="hidden" name="is_included" value="0">





                        <input type="checkbox" name="is_included" id="is_included" value="1" <? if ($is_included == 1)
                            echo "checked='checked'"; ?>>





                        <label class="form-check-label p-0 pr-1 pt-1" for="is_included">Is Included : </label>





                    </div>





                    <div class="form-check">





                        <input type="hidden" name="origin" value="0">





                        <input type="checkbox" name="origin" id="origin" value="1" <? if ($origin == 1)
                            echo "checked='checked'"; ?>>





                        <label class="form-check-label p-0 pr-1 pt-1" for="origin">Origin : </label>





                    </div>





                    <div class="form-check">





                        <input type="hidden" name="vat_ait_box" value="0" />





                        <input type="checkbox" id="vat_ait_box" name="vat_ait_box" value="1" <? if ($vat_ait_box == '')
                            echo "checked='checked'"; ?> <? if ($vat_ait_box == 1) {
                                   echo "checked='checked'";
                               } ?>
                            onclick="vat_ait_fnc()">





                        <label class="form-check-label p-0 pr-1 pt-1" for="vat_ait_box">VAT & AIT: </label>





                    </div>





                    <div id="vat_ait_div" style="display:<? if ($vat_ait > 0)
                        echo "block";
                    else
                        echo "none"; ?>" class="form-group row m-0 pb-1">





                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">VAT
                            & AIT (%):</label>





                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                            <input name="vat_ait" type="text" id="vat_ait" value="<?= $vat_ait; ?>" />





                        </div>





                    </div>





                    <div class="form-group row m-0 pb-1">
                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Discount
                            (%):</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                            <input name="discount" type="text" id="discount" value="<?= $discount; ?>" />
                        </div>
                    </div>





                    <div class="form-group row m-0 pb-1">





                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Rate
                            Type :</label>





                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                            <select id="rate" name="rate">





                                <option value="<?= $rate ?>"><?= $rate ?></option>





                                <option value="BDT">BDT</option>





                                <option value="USD">USD</option>





                            </select>





                        </div>





                    </div>





                    <div class="form-group row m-0 pb-1">





                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Concern
                            :</label>





                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                            <select id="group_for" name="group_for" readonly="readonly">





                                <? foreign_relation('user_group', 'id', 'group_name', $id, '1'); ?>





                                </option>





                            </select>





                        </div>





                    </div>





                    <div class="form-group row m-0 pb-1">





                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Deduct
                            :</label>





                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                            <input name="cash_discount" type="text" id="cash_discount" value="<?= $cash_discount; ?>" />





                        </div>





                    </div>





                    <div class="form-group row m-0 pb-1">





                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Transport
                            Cost :</label>





                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                            <input name="transport_cost" type="text" id="transport_cost"
                                value="<?= $transport_cost; ?>" />





                        </div>





                    </div>





                    <div class="form-group row m-0 pb-1">





                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note
                            :</label>





                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                            <textarea name="remarks" id="remarks"><?= $remarks ?></textarea>





                        </div>





                    </div>





                    <div class="form-group row m-0 pb-1">





                        <label
                            class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Payment
                            terms :</label>





                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">





                            <textarea name="payment_terms"
                                id="payment_terms">30 days from the date of receipt of materials at your hand</textarea>





                        </div>





                    </div>





                </div>





            </div>





        </div>





        <div class="n-form-btn-class">





            <? if ($$unique_master > 0) { ?>





                <input name="new" type="submit" class="btn1 btn1-bg-update" value="Update Demand Order" tabindex="12>





<input name=" flag" id="flag" type="hidden" value="1" />





            <? } else { ?>





                <input name="new" type="submit" class="btn1 btn1-bg-submit" value="Initiate New Order" tabindex="12" />





                <input name="flag" id="flag" type="hidden" value="0" />





            <? } ?>





        </div>





</div>





</form>





<? if ($$unique_master > 0) { ?>





    <form action="<?= $page ?>" method="post" name="codz2" id="codz2">





        <!--Table input one design-->





        <div class="container-fluid pt-5 p-0 ">





            <table class="table1  table-striped table-bordered table-hover table-sm">





                <thead class="thead1">





                    <tr class="bgc-info">





                        <th>Item Code</th>





                        <th width="27%">Item Description</th>





                        <th>Unit</th>





                        <th>Stock</th>





                        <th>Unit-Price</th>





                        <th>Quantity</th>





                        <th>Amount</th>





                        <th>Action</th>





                    </tr>





                </thead>





                <tbody class="tbody1">





                    <tr>





                        <td id="sub" align="center">





                            <?





                            auto_complete_from_db('item_info', 'concat(item_id,"-> ",item_name)', 'item_id', ' product_nature="Salable"', 'item_id');





                            //$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and do_no=".$do_no." order by id desc limit 1";
                        




                            //$do_data = find_all_field_sql($do_details);
                        




                            ?>


                            <input name="csrf_token" type="hidden" id="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" />


                            <input name="item_id" type="text" value="" id="item_id"
                                onblur="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);" />





                            <!--<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);">





<option></option>





<? foreign_relation('item_info', 'item_id', 'item_name', $item_id, '1'); ?>





</select>-->





                            <input type="hidden" id="<?= $unique_master ?>" name="<?= $unique_master ?>"
                                value="<?= $$unique_master ?>" />





                            <input type="hidden" id="do_date" name="do_date" value="<?= $do_date ?>" />





                            <input type="hidden" id="group_for" name="group_for" value="<?= $group_for ?>" />





                            <input type="hidden" id="depot_id" name="depot_id" value="<?= $depot_id ?>" />





                            <input type="hidden" id="dealer_code" name="dealer_code" value="<?= $dealer_code ?>" />





                            <input name="do_date" type="hidden" id="do_date" value="<?= $do_date; ?>" />





                            <input name="job_no" type="hidden" id="job_no" value="<?= $job_no; ?>" />





                        </td>





                        <td id="so_data_found" colspan="4" align="center">





                            <table border="1" align="left" cellpadding="0" cellspacing="2">





                                <tr>





                                    <td width="44%"><input name="item_name" type="text" readonly="" autocomplete="off"
                                            value="" id="item_name" /> </td>





                                    <td width="14%"><input name="pcs_stock" type="text" readonly="" autocomplete="off"
                                            value="" id="pcs_stock" /></td>





                                    <td width="17%"><input name="ctn_price" type="text" id="ctn_price" readonly="" required
                                            value="<?= $do_data->ctn_price; ?>" /></td>





                                    <td width="20%"><input name="pcs_price" type="text" id="pcs_price" readonly=""
                                            required="required" value="<?= $do_data->pcs_price; ?>" /></td>





                                </tr>





                            </table>





                        </td>





                        <td>





                            <input name="dist_unit" type="text" id="dist_unit" value="" onkeyup="count()" />





                        </td>





                        <td>





                            <input name="total_unit" type="hidden" class="form-control" id="total_unit" readonly />





                            <input name="total_amt" type="text" id="total_amt" readonly />





                        </td>





                        <td>





                            <input name="add" type="submit" id="add" value="ADD" class="btn1 btn1-bg-submit" />





                        </td>





                    </tr>





                </tbody>





            </table>





        </div>





        <? if ($$unique_master > 0) { ?>





            <!--Data multi Table design start-->





            <div class="container-fluid pt-5 p-0 ">





                <?





                $res = 'select a.id,b.item_name,a.item_id,a.unit_name, a.unit_price, a.total_unit, a.total_amt as Net_sale from





sale_requisition_details a,item_info b where b.item_id=a.item_id and a.do_no=' . $$unique_master . ' order by a.id';





                ?>





                <table class="table1  table-striped table-bordered table-hover table-sm">





                    <thead class="thead1">





                        <tr class="bgc-info">





                            <th>SL</th>





                            <th>Item Code</th>





                            <th>Item Description</th>





                            <th>Unit</th>





                            <th>Unit-Price</th>





                            <th>Quantity</th>





                            <th>Amount</th>





                            <th>Action</th>





                        </tr>





                    </thead>





                    <tbody class="tbody1">





                        <?





                        $i = 1;





                        $query = db_query($res);





                        while ($data = mysqli_fetch_object($query)) { ?>





                            <tr>





                                <td><?= $i++ ?></td>





                                <td><?= $data->item_id ?></td>





                                <td style="text-align: left;"><?= $data->item_name ?></td>





                                <td><?= $data->unit_name ?></td>





                                <td><?= $data->unit_price; ?></td>





                                <td><?= $data->total_unit;
                                $tot_pcs += $data->total_unit; ?></td>





                                <td><?= $data->Net_sale;
                                $tot_Net_sale += $data->Net_sale; ?>





                                    <? $data->vat_amt;
                                    $tot_vat_amt += $data->vat_amt; ?>





                                    <? $data->total_amt_with_vat;
                                    $tot_total_amt_with_vat += $data->total_amt_with_vat; ?>
                                </td>





                                <td><a href="?del=<?= $data->id ?>">X</a></td>





                            </tr>





                        <? } ?>





                        <tr>





                            <td colspan="4">
                                <div align="right"><strong> Total:</strong></div>
                            </td>





                            <td>&nbsp;</td>





                            <td><?= number_format($tot_pcs, 2); ?></td>





                            <td><?= number_format($tot_Net_sale, 2); ?></td>





                            <td>&nbsp;</td>





                        </tr>





                    </tbody>





                </table>





            <? } ?>





        </div>





    </form>





    <!--button design start-->





    <form action="select_dealer.php" method="post" name="cz" id="cz"
        onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">





        <div class="container-fluid p-0 ">





            <div class="n-form-btn-class">





                <?php /*?>





<?php if($order_create=='Yes') {?>





<? } ?><?php */ ?>





                <input name="delete" type="submit" class="btn1 btn1-bg-cancel" value="DELETE SO" />





                <input name="do_no" type="hidden" id="do_no" value="<?= $$unique_master ?>" />





                <input name="do_date" type="hidden" id="do_date" value="<?= $do_date ?>" />





                <input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM SO" />





            </div>





        </div>





    </form>





<? } ?>





</div>





<?/*>





<div class="form-container_large">





<form action="<?=$page?>" method="post" name="codz2" id="codz2">





<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">





<tr>





<td width="33%"><fieldset >





<div>





<label style="width:81px;">Quo. No : </label>





<input   name="do_no" type="hidden" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>





<input   name="do_no1" type="text" id="do_no1" value="Q-000<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>





</div>





<div>





<label style="width:81px;">Dealer : </label>





<select  id="dealer_code" name="dealer_code" readonly="readonly">





<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer->dealer_code,'1');?>





</select>





</div>





<div>





<label style="width:81px;">Unit : </label>





<input type="text" id="unit" name="unit" value="<?=$unit?>">





</div>





<div>





<label style="width:81px;">Attn : </label>





<input type="text" id="attn" name="attn" value="<? if($attn=='') echo $dealer->propritor_name_e; else echo $attn;?>">





</div>





<div>





<label style="width:81px;">Address : </label>





<input type="text" id="delivery_address" name="delivery_address" value="<? if($delivery_address=='') echo $dealer->address_e; else echo $delivery_address;?>">





</div>





<div>





<label style="width:81px;">Req No : </label>





<input type="text" id="ref_no" name="ref_no" value="<?=$ref_no?>">





</div>





<div>





<label style="width:81px;">Warehouse:</label>





<select  id="depot_id" name="depot_id" required>





<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot_id'],'1 and warehouse_id="'.$_SESSION['user']['depot'].'"')?>





</select>





</div>





<div>





<label style="width:81px;">Sale Type : </label>





<select  id="sale_type" name="sale_type" readonly="readonly">





<option value="Regular">Receivable





</option>





</select>





</div>





<div>





<label style="width:81px;">Quo. By: </label>





<input type="text" id="quo_by" name="quo_by" value="<?=$quo_by?>">





</div>





</fieldset>





</td>





<td width="33%">





<fieldset >





<div>





<label style="width:113px;">Req. Date : </label>





<input   name="do_date" type="text" id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>" />





</div>





<div>





<label style="width:120px;">Vat: </label>





<input type="hidden"  name="vat_box" value="0" />





<input  type="checkbox" id="vat_box" name="vat_box" value="1" <? if($vat_box==1) echo "checked='checked'"; ?> onclick="vat_fnc()">





</div>





<div id="vat_div" style="display:<? if( $vat >0 ) echo "block"; else echo "none"; ?>">





<label style="width:113px;">VAT (%): </label>





<input name="vat" type="text" id="vat"  value="<?=$vat;?>" />





</div>





<div>





<label style="width:120px;">Ait: </label>





<input type="hidden"  name="ait_box" value="0" />





<input  type="checkbox" id="ait_box" name="ait_box" value="1" <? if($ait_box==1) echo "checked='checked'"; ?> onclick="ait_fnc()" >





</div>





<div id="ait_div" style="display:<? if( $ait >0 ) echo "block"; else echo "none"; ?>">





<label style="width:113px;">AIT (%): </label>





<input name="ait" type="text" id="ait"  value="<?=$ait;?>" />





</div>





<div>





<label style="width:120px;">VAT & AIT: </label>





<input type="hidden"  name="vat_ait_box" value="0" />





<input  type="checkbox" id="vat_ait_box" name="vat_ait_box"  value="1" <? if($vat_ait_box=='') echo "checked='checked'";  ?>  <? if($vat_ait_box==1) { echo "checked='checked'"; } ?>  onclick="vat_ait_fnc()" >





</div>		





<div id="vat_ait_div" style="display:<? if( $vat_ait >0 ) echo "block"; else echo "none"; ?>">





<label style="width:113px;">VAT & AIT (%): </label>





<input name="vat_ait" type="text" id="vat_ait"  value="<?=$vat_ait;?>" />





</div>





<div>





<label style="width:113px;">Discount (%): </label>





<input name="discount" type="text" id="discount"  value="<?=$discount;?>" />





</div>





<div>





<label style="width:81px;"> Rate Type : </label>





<select  id="rate" name="rate">





<option value="<?=$rate?>"><?=$rate?></option>





<option value="BDT">BDT</option>





<option value="USD">USD</option>





</select>





</div>





</fieldset>	</td>





<td width="33%"><fieldset>





<div>





<label style="width:120px;">Concern: </label>





<select  id="group_for" name="group_for" readonly="readonly">





<? foreign_relation('user_group','id','group_name',$id,'1');?>





</option>





</select>





</div>





<div>





<label style="width:120px;">Deduct: </label>





<input name="cash_discount" type="text" id="cash_discount"  value="<?=$cash_discount;?>" />





</div>





<div>





<label style="width:120px;">Transport Cost: </label>





<input name="transport_cost" type="text" id="transport_cost"  value="<?=$transport_cost;?>" />





</div>





<div>





<label style="width:120px;">Note: </label>





<textarea name="remarks" id="remarks"><?=$remarks?></textarea>





</div>





<div>





<label style="width:120px;">Is Included: </label>





<input type="hidden" name="is_included"  value="0" >





<input type="checkbox" name="is_included" id="is_included" value="1" <? if($is_included==1) echo "checked='checked'"; ?> >





</div>





<div>





<label style="width:120px;">Origin: </label>





<input type="hidden" name="origin"  value="0" >





<input type="checkbox" name="origin" id="origin" value="1" <? if($origin==1) echo "checked='checked'"; ?> >





</div>





<div>





<label style="width:120px;">Payment terms: </label>





<textarea name="payment_terms" id="payment_terms">30 days from the date of receipt of materials at your hand</textarea>





</div>





</fieldset>  </td>





</tr>





<tr>





<td colspan="3">





<div class="buttonrow" style="margin-left:240px;">





<span class="buttonrow" style="margin-left:240px;">





<? if($$unique_master>0) {?>





<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px; tabindex="12>





<input name="flag" id="flag" type="hidden" value="1" />





<? }else{?>





<input name="new" type="submit" class="btn1" value="Initiate New Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />





<input name="flag" id="flag" type="hidden" value="0" />





<? }?>





</span>





</div>





</td>





</tr>





</table>





</form>





<form action="<?=$page?>" method="post" name="codz" id="codz">





<? if($$unique_master>0) {?>





<form action="<?=$page?>" method="post" name="codz2" id="codz2">





<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">





<tr>





<td colspan="6" width="70%">&nbsp;       </td>





<td width="20%"><div class="button">





<input name="add" type="submit" id="add" value="ADD" class="update" style="background: #339933; font-size:14px; font-weight:700;"/>





</div></td>





</tr>





<tr>





<td width="10%" align="center" bgcolor="#0073AA"><span class="style2">Item Code </span></td>





<td width="60%"colspan="4" align="center" bgcolor="#0073AA">





<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">





<tr>





<td width="55%"><span class="style2">Item Description</span></td>





<td width="15%"><span class="style2">Unit</span></td>





<td width="15%"><span class="style2">Stock</span></td>





<td width="15%"><span class="style2">Unit-Price</span></td>





</tr>





</table></td>





<td width="15%" align="center" bgcolor="#0073AA"><span class="style2">Quantity</span></td>





<td width="15%" align="center" bgcolor="#0073AA"><span class="style2">Value</span></td>





</tr>





<tr bgcolor="#CCCCCC">





<td align="center"><span class="style2">





<span id="sub">





<?





auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id',' product_nature="Salable"','item_id');





//$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and do_no=".$do_no." order by id desc limit 1";





//$do_data = find_all_field_sql($do_details);





?>





<input name="item_id" type="text" class="input3"  value="" id="item_id" style="width:90%; height:30px;" onblur="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);"/>





<!--<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);">





<option></option>





<? foreign_relation('item_info','item_id','item_name',$item_id,'1');?>





</select>-->





<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />





<input type="hidden" id="do_date" name="do_date" value="<?=$do_date?>"  />





<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />





<input type="hidden" id="depot_id" name="depot_id" value="<?=$depot_id?>"  />





<input type="hidden" id="dealer_code" name="dealer_code" value="<?=$dealer_code?>"  />





<input name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"/>





<input name="job_no" type="hidden" id="job_no" value="<?=$job_no;?>"/>





</span>





</span></td>





<td colspan="4" align="center">





<span id="so_data_found">





<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">





<tr bgcolor="#CCCCCC">





<td width="55%"><input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name" style="width:90%; height:30px;" /> </td>





<td width="15%"><input name="pcs_stock" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="pcs_stock" style="width:90%; height:30px;" /></td>





<td width="15%"><input name="ctn_price" type="text" class="input3" id="ctn_price" readonly=""   style="width:90%; height:30px;" required  value="<?=$do_data->ctn_price;?>"   /></td>





<td width="15%"><input name="pcs_price" type="text" class="input3" id="pcs_price" readonly=""   style="width:90%; height:30px;" required="required"  value="<?=$do_data->pcs_price;?>"  /></td>





</tr>





</table>





</span></td>





<td width="10%" align="center">





<span class="style2">





<input  name="dist_unit" type="text" class="input3" id="dist_unit"value="" style="width:90%; height:30px;"   onkeyup="count()"   />





</span></td>





<td width="10%" align="center">





<span class="style2">





<input name="total_unit" type="hidden" class="form-control"  style="width:64px" id="total_unit" readonly/>		





<input name="total_amt" type="text" class="form-control" id="total_amt"  style="width:90%; height:30px;"   readonly/>





</span></td>





</tr>





</table>





<? if($$unique_master>0){?>





<br /><br /><br /><br />





<? 





$res='select a.id,b.item_name,a.item_id,a.unit_name, a.unit_price, a.total_unit, a.total_amt as Net_sale from 





sale_requisition_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';





?>





<div  class="tabledesign2">





<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">





<tr>





<th width="2%">SL</th>





<th width="7%">Item Code </th>





<th width="28%">Item Description</th>





<th width="14%"><strong>Unit</strong></th>





<th width="14%"><strong>Unit Price </strong></th>





<th width="14%">Quantity</th>





<th width="14%">Value</th>





<th width="7%">X</th>





</tr>





<?





$i=1;





$query = db_query($res);





while($data=mysqli_fetch_object($query)){ ?>





<tr>





<td><?=$i++?></td>





<td><?=$data->item_id?></td>





<td><?=$data->item_name?></td>





<td><?=$data->unit_name?></td>





<td>





<?=$data->unit_price; ?></td>





<td><?=$data->total_unit; $tot_pcs +=$data->total_unit;?></td>





<td><?=$data->Net_sale; $tot_Net_sale +=$data->Net_sale;?>





<? $data->vat_amt; $tot_vat_amt +=$data->vat_amt;?>





<? $data->total_amt_with_vat; $tot_total_amt_with_vat +=$data->total_amt_with_vat;?></td>





<td><a href="?del=<?=$data->id?>">X</a></td>





</tr>





<? } ?>





<tr>





<td colspan="4"><div align="right"><strong>  Total:</strong></div></td>





<td>&nbsp;</td>





<td><?=number_format($tot_pcs,2);?></td>





<td><?=number_format($tot_Net_sale,2);?></td>





<td>&nbsp;</td>





</tr>





<? }?>





</table>





</div>





</form>





<br />





<form action="select_dealer.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">





<table width="100%" border="0">





//<?php if($order_create=='Yes') {?>





//





//<? } ?>





<tr>





<td align="center" width="50%">





<input name="delete"  type="submit" class="btn1" value="DELETE SO" style="width:60%; font-weight:bold; background:#0073AA; font-size:12px;color:#F00; height:30px" />





<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>





<input  name="do_date" type="hidden" id="do_date" value="<?=$do_date?>"/></td>





<td align="right" style="text-align:right" width="50%">





<input name="confirm" type="submit" class="btn1" value="CONFIRM SO" style="width:60%; background:#0073AA; font-weight:bold; font-size:12px; height:30px; color: #FFFFFF; float:right" />





</td>





</tr>





</table>





<? }?>





</form>





</div>





<*/ ?>





<?





require_once SERVER_CORE . "routing/layout.bottom.php";



?>