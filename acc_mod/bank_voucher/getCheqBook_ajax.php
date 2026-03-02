<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$bankSubLedger=$_POST['bank'];
$group_for = $_POST['group_for'];
$check = find_a_field('cheque_book_master','cheq_no','bank='.$bankSubLedger.'');
if($check>0){

echo '<div id="check_no_check" class="form-group row m-0 pb-1">';
echo '<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cheque Book:</label>';
echo '<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">';

echo '<select name="cheqBookNo" id="cheqBookNo" style="float:left" tabindex="2" onChange="getCheqPage(this.value)" class="form-control">';
echo '<option value="0"></option>';
echo foreign_relation(
            'cheque_book_master',
            'cheq_no',
            'cheque_no_manual',
            $cheqBook_no,
            "bank=".$bankSubLedger." and group_for=".$group_for." and status='Active' order by cheq_no"
        );
echo '</select>';

echo '</div>';
echo '</div>';
                        
	
	
}


 ?>