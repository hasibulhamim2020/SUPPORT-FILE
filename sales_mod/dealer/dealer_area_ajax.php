<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);

  $zone_code=$data[0];
   


?>

 
					
					
			
									<select name="area_code" required="required" id="area_code" style="width:95%; font-size:12px;" tabindex="9">
	
											  <option></option>
                                              <? foreign_relation('area','AREA_CODE','AREA_NAME',$area_code,'ZONE_ID="'.$zone_code.'"');?>
                                            </select>

  					
					
					
					
					