<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $sub_group_id=$data[0];
  $do_no=$data[1];





?>

<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);">

		<option></option>

      <? foreign_relation('item_info','item_id','item_name',$item_id,'sub_group_id="'.$sub_group_id.'"');?>
 </select>





