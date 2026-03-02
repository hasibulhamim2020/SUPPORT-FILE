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


<select name="zon"  id="zon"  tabindex="2" style="width:220px;"
onchange="getData2('area_ajax.php', 'area', this.value, 
document.getElementById('zon').value);">
	<option></option>
      <? foreign_relation('zon','ZONE_CODE','CONCAT(ZONE_CODE, ": ", ZONE_NAME)',$zon,'REGION_ID="'.$data_id.'"');?>
</select>

