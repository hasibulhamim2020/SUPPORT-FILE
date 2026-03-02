<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$details_id = $_REQUEST['details_id'];
$table_master = "sale_pos_master";
$table_details = "sale_pos_details";
$dsql = "delete from `$table_details` where id = '$details_id'";
$verify = db_query($dsql);
echo json_encode("yes")	;

?>