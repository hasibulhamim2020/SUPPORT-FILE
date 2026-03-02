<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $do_date=$data[0];
  $do_type=$data[1];
  
  //$date_exp=explode('-',$do_date);
  //$year=$date_exp[0];
  //$month=$date_exp[1];
  
  $YR = date('Y',strtotime($do_date));
  
  $year = date('y',strtotime($do_date));
  $month = date('m',strtotime($do_date));
  
  
  $job_id = find_a_field('sale_do_master','max(job_id)','year="'.$YR.'"')+1;
  
   $cy_id = sprintf("%06d", $job_id);

   $job_no_generate='NPL'.$year.''.$month.''.$cy_id;


?>

<input name="job_no" type="text" id="job_no" style="width:220px;" value="<?=$job_no_generate?>" readonly="" tabindex="105" />
<input name="job_id" type="hidden" id="job_id" style="width:220px;" value="<?=$job_id?>" readonly="" tabindex="105" />
<input name="year" type="hidden" id="year" style="width:220px;" value="<?=$YR?>" readonly="" tabindex="105" />





