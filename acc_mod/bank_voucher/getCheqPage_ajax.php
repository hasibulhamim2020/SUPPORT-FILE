<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$cheq_no=$_POST['cheq'];
$group_for = $_POST['group_for'];
$check = find_a_field('cheque_book_details','page_no','cheq_no='.$cheq_no.'');
if($check>0){

echo '<select name="c_no" id="c_no" style="float:left" tabindex="2" class="form-control">';
echo '<option value="0"></option>';
echo foreign_relation(
            'cheque_book_details',
            'id',
            'page_no',
            $c_no,
            "cheq_no=".$cheq_no." and status='Pending'"
        );
echo '</select>';
	
}else{
	echo '<input type="text" name="c_no" id="c_no"/>';
	}


 ?>