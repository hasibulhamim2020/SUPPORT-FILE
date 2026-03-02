<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);

 $vehicle_type=$data[0];
   


?>

 
					
					
					<div>

        <label style="width:200px;" >Vehicle: </label>
			
					<select name="vehicle_id" required id="vehicle_id"  style="width:220px;"
					 onchange="getData2('vehicle_driver_ajax.php', 'vehicle_driver_filter', this.value,  document.getElementById('vehicle_id').value);">
					
					<option></option>
				
                      <? foreign_relation('vehicle_registration','vehicle_id','vehicle_name',$vehicle_id,'vehicle_type="'.$vehicle_type.'"');?>
                    </select>		

      </div>
					
					
					