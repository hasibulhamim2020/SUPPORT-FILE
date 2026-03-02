<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$pos_id = $_REQUEST['pos_id'];
$table_master = "sale_pos_master";
$table_details = "sale_pos_details";
$main_sql = "select item_info.item_name,`$table_details`.id,`$table_details`.qty, `$table_details`.rate, `$table_details`.total_amt, `$table_details`.discount, (sum(journal_item.item_in-journal_item.item_ex)-`$table_details`.qty) as stock from `$table_details` left join item_info on item_info.item_id = `$table_details`.item_id left join journal_item on journal_item.item_id = item_info.item_id where `$table_details`.pos_id='$pos_id' group by sale_pos_details.id";
$main_query = db_query($main_sql);
$datas['total_item'] = mysqli_num_rows($main_query);
$i = 0;
while($data = mysqli_fetch_assoc($main_query)){
extract($data);
$datas['item_details'][$i]['id'] = $id;
$datas['item_details'][$i]['item_name'] = $item_name;
$datas['item_details'][$i]['qty'] = number_format($qty, 2, '.', '');
$datas['item_details'][$i]['rate'] = number_format($rate, 2, '.', '');
$datas['item_details'][$i]['total_amt'] = number_format($total_amt, 2, '.', '');
$datas['item_details'][$i]['discount'] = number_format($discount, 2, '.', '');
$datas['item_details'][$i]['stock'] = number_format($stock, 2, '.', '');
$i++;
}
echo json_encode($datas);
?>