<?php


session_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$ledgerId=$_POST['ledgerId'];

 $a2="select * from acc_bank_info where account_code='".$ledgerId."'";

$query=db_query($a2);

$data=mysqli_fetch_object($query);

$dt = 'Bank Name: '.$data->dealer_name_e.' , Branch: '.$data->propritor_name_e.' , Branch Code: '.$data->area_code.' , Routing No: '.$data->sms_mobile_no;

$res= array($dt);

echo json_encode($res);


?>



