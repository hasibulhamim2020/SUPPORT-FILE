<?php /*?><?php


session_start();


require "../../support/inc.all.php";



@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


echo $customer_code=$data[0];


$dealer_code=find_a_field('dealer_info','dealer_code','customer_id="'.$customer_code.'" ');



?>

<input name="dealer_code_2" required type="hidden" id="dealer_code_2" tabindex="2" onblur="duplicate()"  value="<?=$dealer_code?>">

<?php */?>


<?php
session_start();
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

 $str = $_POST['data'];
$data=explode('##',$str);

 $customer_code=$data[0];


 if($customer_code!=''){
	 $sql1 = 'select 1 from dealer_info where customer_id="'.$customer_code.'"';
	 $query1 = db_query($sql1 );
	 $check1 = mysqli_num_rows($query1);
	 
	 }
	 
	 if($check1 >0){
		 echo "<span style='color:red;'> This customer code already exists.</span>";
		 } else{
			 
		 echo "<span style='color:green;'> New Customer</span>";
			 }
 
?>


