<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

//$all_dealer[]=link_report($res);

$all_data[]='bimol';




echo json_encode($all_data);

?>



