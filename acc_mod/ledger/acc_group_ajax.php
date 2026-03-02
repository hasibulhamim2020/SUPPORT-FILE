<?php


session_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $data_id=$data[0];

//and group_for="'.$_SESSION['user']['group'].'"
?>


<select name="ledger_group_id" required id="ledger_group_id"  tabindex="2" style="width:220px;">
			<option></option>
            <? foreign_relation('ledger_group','group_id','CONCAT(group_id, ": ", group_name)',$ledger_group_id,'acc_sub_sub_class="'.$data_id.'" ');?>
</select>
