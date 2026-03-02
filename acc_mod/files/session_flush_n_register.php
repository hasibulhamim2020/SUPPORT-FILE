<?php
session_start();

$a1=$_SESSION['proj_id'];
$a2=$_SESSION['proj_name'];
$a3=$_SESSION['db_name'];
$a4=$_SESSION['db_user'];
$a5=$_SESSION['db_pass'];
$a6=$_SESSION['user']['level'];
$a7=$_SESSION['user']['id']; 
$a8=$_SESSION['user']['fname'];
$a9=$_SESSION['separator'];
$a10=$_SESSION['mhafuz'];
$a11=$_SESSION['voucher_type'];
$a12=$_SESSION['company_name'];
$a13=$_SESSION['company_address'];
$a14=$_SESSION['company_logo'];


session_destroy();
session_start();

$_SESSION['proj_id']	= $a1;
$_SESSION['proj_name']	= $a2;
$_SESSION['db_name']	= $a3;
$_SESSION['db_user']	= $a4;
$_SESSION['db_pass']	= $a5;
$_SESSION['user']['level']	= $a6;
$_SESSION['user']['id'] = $a7; 
$_SESSION['user']['fname']	= $a8;
$_SESSION['separator']= $a9;
$_SESSION['mhafuz']= $a10;
$_SESSION['voucher_type']= $a11;
$_SESSION['company_name']= $a12;
$_SESSION['company_address']= $a13;
$_SESSION['company_logo']= $a14;

?>