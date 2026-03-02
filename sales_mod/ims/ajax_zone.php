<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);

?>
<select name="PBI_ZONE" id="PBI_ZONE" onchange="getData2('ajax_area.php', 'area',this.value,this.value);">
<? foreign_relation('zon','ZONE_CODE','ZONE_NAME','',"REGION_ID='".$data[0]."'");?>
</select>