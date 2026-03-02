<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$pos_id = $_REQUEST['pos_id'];
$usql = "delete from sale_pos_master where pos_id = '$pos_id'";
db_query($usql);
$usql2 = "delete from sale_pos_details where pos_id = '$pos_id'";
db_query($usql2);
$usq3 = "delete from pos_payment where pos_id = '$pos_id'";
db_query($usq3);
$data['status'] = "ok";
echo json_encode($data);

?>