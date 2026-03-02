<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);

 $vehicle_id=$data[0];
 
 $vehicle=find_all_field('vehicle_registration','','vehicle_id='.$vehicle_id);
   


?>

 
					
					
					<div>

        <label style="width:200px;" >Vehicle No: </label>
			
					<input style="width:220px; height:32px;"  name="vehicle_no" type="text" id="vehicle_no" value="<?=$vehicle->registration_no?>" />	

      </div>
	  
	  <div>

        <label style="width:200px;" >Driver Name: </label>
			
					<input style="width:220px; height:32px;"  name="driver_name" type="text" id="driver_name" value="<?=$vehicle->driver_name?>" />	

      </div>
	  
	  <div>

        <label style="width:200px;" >Driver Mobile: </label>
			
					<input style="width:220px; height:32px;"  name="driver_mobile" type="text" id="driver_mobile" value="<?=$vehicle->driver_mobile?>" />	

      </div>
					
					
					