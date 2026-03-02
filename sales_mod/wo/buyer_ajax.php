<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $customer=$data[0];
   
   $dealer=explode('->',$customer);
   
   $dealer_code=$dealer[0];
   
   $dealer_all = find_all_field('dealer_info','',"dealer_code=".$dealer_code);

?>

  
  
  
  



 
  <div>

<label style="width:220px;">Marketing Team: </label>


		 
		<input name="marketing_team" type="hidden" id="marketing_team" required readonly="" style="width:250px;" value="<?=$dealer_all->marketing_team?>" tabindex="105" />
		
		<input name="marketing_team2" type="text" id="marketing_team2" required readonly="" style="width:250px;"
		 value="<?=find_a_field('marketing_team','team_name',"team_code=".$dealer_all->marketing_team);?>" tabindex="105" />


		
</div>


<div>

<label style="width:220px;">Marketing Person: </label>


		 
		<input name="marketing_person" type="hidden" id="marketing_person" required readonly="" style="width:250px;" value="<?=$dealer_all->marketing_person?>" tabindex="105" />
		
		<input name="marketing_person2" type="text" id="marketing_person2" required readonly="" style="width:250px;"
		 value="<?=find_a_field('marketing_person','marketing_person_name',"person_code=".$dealer_all->marketing_person);?>" tabindex="105" />


		
</div>





<div>

<label style="width:220px;">Buyer: </label>


		 
		 
		 
		<input name="dealer_code" type="hidden" id="dealer_code" required readonly="" style="width:250px;" value="<?=$dealer_code?>" tabindex="105" />

		  
<input list="buyer_name" name="buyer" id="buyer"  style="width:250px;"  onchange="getData2('merchandizer_ajax.php', 'merchandizer_filter', this.value, 
document.getElementById('buyer').value);"  autocomplete="off" required>
  <datalist id="buyer_name">
	 
	 <? foreign_relation('buyer_info','CONCAT(buyer_code, "->", buyer_name)','buyer_name',$buyer,'dealer_code="'.$dealer_code.'" order by buyer_name');?>
  </datalist>


		

</div>




