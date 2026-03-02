<?php
session_start();
include "check.php";
require_once('../../../engine/configure/db_connect.php');
$id=$_REQUEST['id'];

$ledgers = explode('::',$id);
$search=array( ":"," ", "[", "]", $separater);
$ledger1=str_replace($search,'',$ledgers[0]);
$ledger2=str_replace($search,'',$ledgers[1]);

if(is_numeric($ledger1))
$id = $ledger1;
else
$id = $ledger2;

$a2="select cost_price from item_info where item_id='$id'";
$a1=mysqli_fetch_row(db_query($a2));
echo "<input name=\"rate\" type=\"text\" id=\"trate\" value=\"$a1[0]\" size=\"12\" maxlength=\"15\" onchange=\"t_rate(this.value);\"/>";

?> 
