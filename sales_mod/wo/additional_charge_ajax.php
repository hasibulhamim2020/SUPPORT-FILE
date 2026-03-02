<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $additional=$data[0];
  
  // $additional_exp=explode('->',$additional);
   
  // $additional_id=$additional_exp[0];
  
  
  $addi=find_all_field('additional_information','',"id=".$additional);
  
  $additional_charge=$addi->additional_charge;


?>
<!--<input  name="additional_info" type="text" class="input3" id="additional_info" style="width:60px; height:30px;"  readonly="" value="<?=$additional_id?>" />-->

<input  name="additional_charge" type="text" class="input3" id="additional_charge" style="width:60px; height:30px;"  readonly="" value="<?=$additional_charge?>" 
onkeyup="count_formula()"/>






