<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$rand_number = rand(0,4);
$rand_number2 = rand(0,4);

if($rand_number==0){
$class = "success";
$class2 = "danger";
}else if($rand_number==1){
$class = "info";    
$class2 = "success";
}else if($rand_number==2){
$class = "primary";        
$class2 = "info";
}else if($rand_number==3){
$class = "danger";
$class2 = "warning";
}else if($rand_number==4){
$class = "warning";
$class2 = "primary";
}

?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="js/jquery-3.4.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>AWN POS</title>
    <style>
        .required {
            color: red;
        }

        input[type="date"].form-control,
        input[type="time"].form-control,
        input[type="datetime-local"].form-control,
        input[type="month"].form-control {line-height: 21px;
            
        }

        body {
            background-image: linear-gradient(to bottom, #b3f0ff, #e6faff);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 1200px;
        }

        .panel {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        #logo {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .table-shadow{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        #automove{
            overflow:auto;
        }
          .ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }
  @media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <br>
            <div class="col-sm-2 col-xs-2">
            <img src="http://awn-erp.com/CloudERP/awnerp/logo/awn.png" alt="" class="img-responsive" id="logo" style="width:100px;height:auto;">
            <h3>AWN POS</h3>
            
            </div>
           <div class="col-sm-offset-8 col-sm-2 col-xs-offset-8 col-xs-2">
		   
		   
		   <img  src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" alt="" class="img-responsive" id="logo" style="width:100px;height:auto;background-color:white;">
		   
           <h3 ><a href="../../pages/main/logout.php" >Log Out</a></h3>

		  
		   </div>
            
            <div class="col-sm-12 col-xs-12"><br>
            <form name="new_fomr" id="new_form" class="new_form" method="POST">
            <div class="panel panel-<?=$class?>">
                <div class="panel-heading"><button class="btn btn-success" type="button">New Invoice POS</button></div>
                <div class="panel-body">
                    
                        <div class="form-group col-sm-12">
                            <label for="item_id">Barcode <span class="required">*</span> :</label>
                            <input type="text" class="form-control" id="item_id" name="item_id" placeholder="Click your mouse here and scan barcode with machine to get code">
                       <input type="text" name="wr_id" id="wr_id" value="<?=$_SESSION['user']['depot']?>">
					   
					   <input type="text" name="group_for" id="group_for" value="<?=$_SESSION['user']['group']?>">

                        </div>
                        <div class="form-group col-sm-12">
                            <label for="date">Date<span class="required">*</span> :</label>
                            <input class="form-control" id="date" name="date" type="date" value="<?=date('Y-m-d')?>" require>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="customer_name">Customer Name :</label>
                            <input class="form-control" name="customer_name" type="text" id="customer_name" value="3557::Cash Sale Customer">
                        </div>
                        <!--<div class="form-group col-sm-6">
                            <br>
                            <button class="btn btn-sm btn-<?=$class2?> btn-block" id="add_new_cus" type="button"
                                 data-toggle="collapse" data-target="#collapseExample">Add New Customer</button>
                        </div>-->
                        <div class="form-group col-sm-12 collapse" id="collapseExample">
                            <label for="customer_name">Customer Address :</label>
                            <textarea class="form-control" name="customer_address" type="text" id="customer_address"
                                placeholder="Write Customer Address Here"></textarea>
                        </div>
                        <div class="col-sm-12">
                            
                            
                        </div>
                        
                        <div class="col-sm-12 col-xs-12" id="automove">
                        <br>
                            <table class="table table-bordered table-responsive table-striped table-shadow">
                            <thead>
                            <tr>
                                    <th>Item name</th>
                                    <th>Available Qty</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                    
                              </tr>
                              </thead>    
                                <tbody>
                                    <tr>
                                      <td colspan="4" class="text-right">Total Item Amount:</td>
                                      <td><input type="text" class="form-control" name="total_item_amount" id="total_item_amount" readonly></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Vat :</td><td>
                                            
                                             <div class="input-group">
      
      <input id="vat_percent" type="text" class="form-control" name="vat_percent" placeholder="Write only number please" value="5.00" onChange="vat_cal()">
      <span class="input-group-addon">%</span>
    </div>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                      <td colspan="4" class="text-right">Vat Amount :</td>
                                      <td><input type="text" name="vat_amount" id="vat_amount" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Total Discount :</td><td><input type="text" name='total_discount' id='total_discount' onChange="discount_cal()" class="form-control" value="0.00"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Grand Total :</td><td><input type="text" name='grand_total' id='grand_total' class="form-control" value="0.00" readonly></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Paid Amount :</td><td><input type="text" name='paid_amount' id='paid_amount' class="form-control" onChange="paid_cal()" value="0.00"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Due :</td><td><input type="text" name='due' id='due' class="form-control" value="0.00" readonly></td>
                                    </tr>
                                </tbody> 
                            </table>
                        </div>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-warning" type="button" id="save_invoice">Save Invoice</button>
                    <button class="btn btn-success" type="button" id="full_paid">Full Paid</button>
                    <button class="btn btn-danger" type="button" id="reset">Reset</button>
                    <!--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#print_modal">Test modal</button>-->
                </div>
            </div>
            </form>
          </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="print_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Invoice Single View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<!--<table class="table table-striped">
        <tr>
        <td colspan="4" class="text-center"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group']);?></td>
        </tr>
        <tr>
        <th colspan="4" class="text-center">Receipt</th>
        </tr>
        <tr>
        <th colspan="2">Date:</th><td colspan="2"><span id="modal_date"></span></td>
        </tr>
        <tr>
        <th colspan="2">Customer Name:</th><td colspan="2"><span id="modal_cus_name"></span></td>
        </tr>
         <tr>
        <th>Item Name</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Amount</th>
        </tr>
        <tbody id="modal_item_details">
        </tbody>
        <tr>
        <td colspan="2">Total Item Amount:</td><td colspan="2" id="modal_total_item_amt"></td>
        </tr>
        <tr>
        <td colspan="2">Vat:</td><td colspan="2" id="modal_vat"></td>
        </tr>
        <tr>
        <td colspan="2">Vat Amount:</td><td colspan="2" id="modal_vat_amount"></td>
        </tr>
         <tr>
        <td colspan="2">Total Discount:</td><td colspan="2" id="modal_tot_discount"></td>
        </tr>
        <tr>
        <td colspan="2">Grand Total:</td><td colspan="2" id="modal_grand_total"></td>
        </tr>
        <tr>
        <td colspan="2">Paid Amount:</td><td colspan="2" id="modal_paid_amount"></td>
        </tr>
        <tr>
        <td colspan="2">Due:</td><td colspan="2" id="modal_due"></td>
        </tr>
        </table>-->
		<span id="pos_print_report"></span> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="window.print();">Print</button>
      </div>
    </div>
  </div>
</div>
    <script src='./js/custom.js'></script>
</body>

</html>