<?

$L = 60;
$W = 40;
$H = 30;
$WL= 6;
$WW= 4;


$formula = "($L+$W+$WL)*($H+$W+$WW)*2/10000";


eval("\$res = \"$formula\";");
//echo $res;

//echo '<br>';

eval( '$result = (' . $res . ');' );
echo $result;
?>