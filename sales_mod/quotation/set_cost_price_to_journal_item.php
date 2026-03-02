<?php
session_start();
require_once "../../support/inc.all.php";
$x = 1;
$sql = 'select item_id,tran_pr from item_info where tran_pr>0 and tran_no=1 and sub_group_id!=1096000100010000';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
$sql2 = 'update journal_item set item_price = "'.$data->tran_pr.'" where warehouse_id=5 and ji_date between "2014-12-31" and "2015-05-31" and item_ex>0 and item_id="'.$data->item_id.'"';
$query2 = db_query($sql2);

$sql2 = 'update journal_item j, warehouse w set j.item_price = "'.$data->tran_pr.'" where w.warehouse_id=j.warehouse_id and w.master_warehouse_id>0 and j.ji_date between "2014-12-31" and "2015-05-31" and j.item_id="'.$data->item_id.'"';
$query2 = db_query($sql2);
}
?>