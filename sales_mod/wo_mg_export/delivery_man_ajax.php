<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);

  $delivery_man=$data[0];
 
 $delivery_man_mobile = find_a_field('delivery_man','mobile','id='.$delivery_man);
   


?>


		 <input style="width:220px; height:32px;"  name="delivery_man_mobile" type="text" id="delivery_man_mobile" value="<?=$delivery_man_mobile;?>" />			
					
					