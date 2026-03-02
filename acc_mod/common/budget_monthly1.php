<?php
session_start();
session_start();
include "check.php";
require("../config/db_connect.php");
$proj_id=$_SESSION['proj_id'];
$id=$_REQUEST['id'];
$a=$_REQUEST['a'];
$b=$_REQUEST['b'];
$c=$_REQUEST['c'];
$d=$_REQUEST['d'];
$e=$_REQUEST['e'];
$f=$_REQUEST['f'];
$g=$_REQUEST['g'];
$h=$_REQUEST['h'];
$i=$_REQUEST['i'];
$j=$_REQUEST['j'];
$k=$_REQUEST['k'];
$l=$_REQUEST['l'];
$m=$_REQUEST['m'];
$b_type=$_REQUEST['b_type'];
$f_year=$_REQUEST['f_year'];

$sql="UPDATE `monthly_budget` SET 
`jan` = '$a',
`feb` = '$b',
`mar` = '$c',
`apr` = '$d',
`may` = '$e',
`jun` = '$f',
`jul` = '$g',
`aug` = '$h',
`sep` = '$i',
`oct` = '$j',
`nov` = '$k',
`dec` = '$l',
`total_amt` = '$m' 
WHERE `f_year` ='$f_year' AND `ledger_id` ='$id' AND `b_type` ='$b_type' AND `proj_id`='$proj_id' LIMIT 1";
$query=db_query($sql);
//echo $sql;
echo "<div align=\"center\">Data Updated.</div";
?>