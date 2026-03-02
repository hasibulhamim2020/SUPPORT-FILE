<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);

  $region_code=$data[0];
   


?>

 
					
					
			
									<select name="zone_code" required="required" id="zone_code" style="width:95%; font-size:12px;" tabindex="9"
									onchange="getData2('dealer_area_vision_ajax.php', 'dealer_area_find', this.value,  document.getElementById('zone_code').value);">
	
											  <option></option>
                                              <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_code,'REGION_ID="'.$region_code.'"');?>
                                            </select>

  					
					
					
					
					
					