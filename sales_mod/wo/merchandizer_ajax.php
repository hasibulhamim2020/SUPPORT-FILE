<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $buyer=$data[0];
   
   $buyer_exp=explode('->',$buyer);
   
	$buyer_code=$buyer_exp[0];

	$dealer_code = find_a_field('buyer_info','dealer_code',"buyer_code=".$buyer_code);
	
	


?>

<input name="buyer_code" type="hidden" id="buyer_code" required readonly="" style="width:250px;" value="<?=$buyer_code?>" tabindex="105" />

			  
<input list="merchandizer_name" name="merchandizer" id="merchandizer"  style="width:250px;"  onchange="getData2('merchandizer_code_ajax.php', 'merchandizer_code_filter', this.value, document.getElementById('merchandizer').value);"  autocomplete="off"   required>
  <datalist id="merchandizer_name">

	  <? foreign_relation('merchandizer_info','CONCAT(merchandizer_code, "->", merchandizer_name)','merchandizer_name',$merchandizer,'buyer_code="'.$buyer_code.'"
	  and dealer_code="'.$dealer_code.'" order by merchandizer_name');?>
	  
  </datalist>





