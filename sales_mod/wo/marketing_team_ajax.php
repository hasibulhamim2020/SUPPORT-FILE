<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $team_code=$data[0];




?>

<select name="marketing_person" id="marketing_person"  style="width:250px" required    >

                        <option></option>

               <? foreign_relation('marketing_person','person_code','marketing_person_name',$_POST['marketing_person'],'team_code="'.$team_code.'" order by person_code');?>
			

                      </select>





