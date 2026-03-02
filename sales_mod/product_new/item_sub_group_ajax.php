<?php


session_start();


require "../../support/inc.all.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $group_id=$data[0];




?>

<select name="item_sub_group" id="item_sub_group" style="width:150px;">

<option></option>
          
                   <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group,'group_id="'.$group_id.'"  order by sub_group_name');?>
</select>





