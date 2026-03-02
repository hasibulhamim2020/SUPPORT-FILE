<?php
session_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$dealer_code = $_POST['dealer_code'];

$ss="select * from dealer_info where dealer_code='".$dealer_code."'";
$info = findall($ss);


$arr = array('customer_name' => $info->dealer_name_e, 'customer_mobile' => $info->contact_no, 'customer_address' => $info->address_e);

echo json_encode($arr);

?>