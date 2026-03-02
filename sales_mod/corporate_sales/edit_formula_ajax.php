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


$L_ajx = $in[0];
$W_ajx = $in[1];
$H_ajx = $in[2];
$WL_ajx = $in[3];
$WW_ajx = $in[4];
$fr = $in[5];

$measurement_unit = $in[7];
//$sqm_rate = $in[6];

if ($measurement_unit=="inch") {

$L = $L_ajx*2.54;
$W = $W_ajx*2.54;
$H = $H_ajx*2.54;
$WL = $WL_ajx;
$WW = $WW_ajx;

}elseif ($measurement_unit=="mm") {

$L = $L_ajx/10;
$W = $W_ajx/10;
$H = $H_ajx/10;
$WL = $WL_ajx;
$WW = $WW_ajx;

} else {

$L = $L_ajx;
$W = $W_ajx;
$H = $H_ajx;
$WL = $WL_ajx;
$WW = $WW_ajx;

}




$formula =find_a_field('item_formula','item_formula','id='.$fr);




eval("\$res = \"$formula\";");
//echo $res;
//echo '<br>';
eval( '$result = (' . $res . ');' );
//echo $result;





			
			
?>


<input type="text" name="<?='sqm#'.$order_id?>" id="<?='sqm#'.$order_id?>"  value="<?=$result?>" onkeyup="TRcalculation(<?=$order_id?>)"  style="width:60px; height:25px;"/>