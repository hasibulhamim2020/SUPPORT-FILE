<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$con= "";




if(isset($_REQUEST['item_id']) && $_REQUEST['item_id']!=""){
	if(strpos($_REQUEST['item_id'], "::")==true){
	$oold_item_id = explode("::", $_REQUEST['item_id']);
	$item_id = $oold_item_id[1];
	}else{
	$item_id = $_REQUEST['item_id'];		
	}
   $con.=" and item_info.finish_goods_code like '".$item_id."'";
   
   $cus_sql = "select item_info.*, sum(journal_item.item_in-journal_item.item_ex) as stock from item_info left join journal_item on journal_item.item_id = item_info.item_id and journal_item.warehouse_id='".$_SESSION['user']['depot']."' where 1 ".$con;

$cus_query = db_query($cus_sql);


if($cus_query){
while($data = mysqli_fetch_assoc($cus_query)){
     
     extract($data);
     
     $all_dealer['item_name'] = $item_name;
     $all_dealer['stock'] = $stock; 
     $all_dealer['d_price'] = $d_price;
     $all_dealer['item_code'] = $item_id;
    
    }    
}else{
    $all_dealer[] ="";
}
echo json_encode($all_dealer);
}


?>