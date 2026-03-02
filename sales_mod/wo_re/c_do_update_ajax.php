<?php


// $tst = 'omar';

session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
$item_id=explode("#",$data[0]);
$com_id = find_a_field('item_info','com_id','finish_goods_code="'.$item_id[1].'"');
$company = find_a_field('company_info','company_name','com_id="'.$com_id.'"');

?>
<input type="text" name="company" id="company" value="<?=$company?>" readonly="readonly" />
<input type="hidden" name="com_id" id="com_id" value="<?=$com_id?>" readonly="readonly" />






