<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$type=$_POST['type'];

$group_for = $_POST['group_for'];

$gr_all = find_all_field('config_group_class', '*', 'group_for=' . $group_for); // 
$cash_ledg_group_id = $gr_all->cash_ledger;
$bank_ledg_group_id = $gr_all->bank_ledger;


if($type=='CASH'){


echo '<select name="c_id" id="cash_disable_id" style="float:left" tabindex="2" class="form-control">';

	echo '<option value="0"></option>';


  	foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$c_id,"ledger_id=".$cash_ledg_group_id." and group_for=".$group_for." order by ledger_id");


echo '</select>';



}else{

	echo '<select name="b_id" id="bank_disable_id" style="float:left" tabindex="2" <? if($jv->tr_no>0) echo "readonly"?>  class="form-control"  required="required">';

	echo '<option value="0"></option>';

			foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$b_id,"ledger_id=189 and group_for=".$group_for." order by ledger_id");


	echo '</select>';


}






 ?>