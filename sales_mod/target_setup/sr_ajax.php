<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

 
?>




		<select name="sales_person" type="text" class="required " id="sales_person"  value="<?=$_POST['sales_person']?>"  required autocomplete="off">
		
	
		
		<? foreign_relation('ss_user','user_id','concat(fname,"##",point_id)',$sales_person,'dealer_code="'.$_POST['dealer_code'].'"');?>
		
		</select>