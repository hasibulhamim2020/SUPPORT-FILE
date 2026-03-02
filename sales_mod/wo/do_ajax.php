<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
$item=$data[0];
 
$do_no = $data[1];

$item_all = find_all_field('item_info','','item_id="'.$item.'"');




$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and a.do_no=".$do_no." order by a.id desc limit 1";
$do_data = find_all_field_sql($do_details);




?>



<input  name="item_id" type="hidden" class="input3" id="item_id" style="width:60px; height:30px;" value="<?=$item_all->item_id?>" required="required"  tabindex="0"/>
<!--<input  name="unit_name" type="hidden" class="input3" id="unit_name" style="width:60px; height:30px;" value="<?=$item_all->unit_name?>" required="required"  tabindex="0"/>-->




