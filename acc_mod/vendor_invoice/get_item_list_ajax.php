<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$str = $_POST['data'];
$data=explode('##',$str);
$item=$data[0];
 
$group_id = $data[0];


//auto_complete_from_db('item_info i, item_sub_group s','concat(i.item_id,"-> ",i.item_name)','i.item_id',' i.product_nature in ("Salable","Both") and i.status="Active" and i.sub_group_id=s.sub_group_id and s.group_id="'.$group_id.'"','i.item_id');
?>


<input name="item_id" type="text" value="" id="item_id" onblur="getData2('item_info_ajax.php', 'bill', this.value, document.getElementById('warehouse_id').value);" list="itemList" autocomplete="off"/>
<datalist id="itemList">
<? foreign_relation('item_info i,item_sub_group s','concat(i.item_name,"-> ",i.finish_goods_code,"->",i.item_id)','""',$item_id,'i.status="Active" and i.sub_group_id=s.sub_group_id and s.group_id="'.$group_id.'" group by i.item_id')?>
</datalist>
