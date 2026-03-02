<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$bank=$data[0];
$sql = "select BRANCH from bank where BANK_NAME='".$bank."' order by BRANCH ";
?>
<select style="width:155px;" id="branch" name="branch" tabindex="104">
<option></option>
<?
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
?>
<option><?=$data->BRANCH?></option>
<?
}
?>
</select>
