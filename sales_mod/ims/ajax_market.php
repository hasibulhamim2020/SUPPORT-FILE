<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
?>
<select name="base_market" id="base_market" >
<?php foreign_relation('base_market', 'BASE_MARKET_CODE', 'BASE_MARKET_NAME', '',"AREA_ID='".$data[0]."'"); ?>
</select>