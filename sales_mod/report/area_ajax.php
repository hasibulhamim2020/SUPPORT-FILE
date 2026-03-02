<?php


session_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $data_id=$data[0];




?>


<select name="area"  id="area"  tabindex="2" style="width:220px;">

	<option></option>
	  <? foreign_relation('area','AREA_CODE','CONCAT(AREA_CODE, ": ", AREA_NAME)',$AREA_NAME,'ZONE_ID="'.$data_id.'"');?>
</select>

