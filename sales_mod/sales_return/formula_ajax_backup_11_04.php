<?php
session_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$order_id=$data[0];
$info = $data[1];
$in = explode('<@>',$info);


$L = $in[0];
$W = $in[1];
$H = $in[2];
$WL = $in[3];
$WW = $in[4];
$fr = $in[5];
//$sqm_rate = $in[6];


$formula =find_a_field('item_formula','item_formula','id='.$fr);




eval("\$res = \"$formula\";");
//echo $res;
//echo '<br>';
eval( '$result = (' . $res . ');' );
//echo $result;





			
			
?>
<input name="sqm" type="text" class="input3" id="sqm" style="width:60px; height:30px;" value="<?=$result;?>" onchange="count_formula()" readonly/>