<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $paper_comb_id=$data[0];
  
  //$combination_exp=explode('->',$combination);
  
   
  
  
 // $sqm_rate=find_a_field('paper_combination','sqm_rate',"id=".$paper_comb_id);
  
 //echo $s = $sqm->sqm_rate;


 $sq="SELECT sqm_rate, paper_combination  FROM paper_combination WHERE  id=".$paper_comb_id." ";
$sq_data = find_all_field_sql($sq);

?>

<!--<input  name="paper_combination_id" type="hidden" class="input3" id="paper_combination_id" style="width:60px; height:30px;"  readonly="" value="<?=$paper_comb_id?>" />-->
<input  name="paper_combination" type="hidden" class="input3" id="paper_combination" style="width:60px; height:30px;"  readonly="" value="<?=$sq_data->paper_combination?>" />

<input  name="sqm_rate" type="text" class="input3" id="sqm_rate" style="width:60px; height:30px;" value="<?=$sq_data->sqm_rate?>" required="required"  readonly="" onkeyup="count_formula()"/>





