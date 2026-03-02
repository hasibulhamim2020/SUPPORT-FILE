<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);

$con="select a.ZONE_CODE,a.ZONE_NAME,c.BRANCH_ID,c.BRANCH_NAME from zon a, branch c where a.ZONE_CODE='".$data[0]."' and a.REGION_ID=c.BRANCH_ID";
$zone_code=mysqli_fetch_row(db_query($con));
?>
<select name="PBI_BRANCH" id="PBI_BRANCH">
<? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$zone_code[2],' 1 order by BRANCH_NAME');?>
</select>