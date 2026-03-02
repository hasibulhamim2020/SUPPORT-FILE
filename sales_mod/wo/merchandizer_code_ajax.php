<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


    $merchandizer=$data[0];
   
   $merchandizer_exp=explode('->',$merchandizer);
   
   $merchandizer_code=$merchandizer_exp[0];

?>

<input name="merchandizer_code" type="hidden" id="merchandizer_code" required readonly="" style="width:250px;" value="<?=$merchandizer_code?>" tabindex="105" />











