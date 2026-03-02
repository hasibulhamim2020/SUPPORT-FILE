<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$pos_id = $_REQUEST['pos_id'];
//master info
$sqlm = "select sale_pos_master.*, dealer_info.dealer_name_e from sale_pos_master left join dealer_info on dealer_info.dealer_code = sale_pos_master.dealer_id where pos_id = '$pos_id'";
$querym = db_query($sqlm);
$datas['master_info'] = mysqli_fetch_assoc($querym);

// deatils info
$sqli = "select sale_pos_details.*, item_info.item_name from sale_pos_details left join item_info on item_info.item_id = sale_pos_details.item_id where pos_id = '$pos_id'";
$qi = db_query($sqli);
$i = 0;
while($datass = mysqli_fetch_assoc($qi)){
    extract($datass);
    $datas['details_info'][$i]['item_name'] = $item_name;
    $datas['details_info'][$i]['qty'] = number_format($qty, 2, '.', '');
    $datas['details_info'][$i]['rate'] = number_format($rate, 2, '.', '');
    $datas['details_info'][$i]['discount'] = number_format($discount, 2, '.', '');
    $datas['details_info'][$i]['total_amt'] = number_format($total_amt, 2, '.', '');
    $i++;
}

// payment history
$psql = "select * from pos_payment where pos_id = '$pos_id'";
$rr = db_query($psql);
$j  = 0;
while($datasss = mysqli_fetch_assoc($rr)){
    extract($datasss);   
    $datas['payment_history'][$j]['total_item'] = number_format($total_item, '2', '.', '');
    $datas['payment_history'][$j]['total_amt'] = number_format($total_amt, '2', '.', '');
    $datas['payment_history'][$j]['paid_amt'] = number_format($paid_amt, '2', '.', '');
    $datas['payment_history'][$j]['left_amt'] = number_format($left_amt, '2', '.', '');
    $datas['payment_history'][$j]['payment_method'] = $payment_method;
    $datas['payment_history'][$j]['status'] = $status;
    $j++;
}

echo json_encode($datas);
?>