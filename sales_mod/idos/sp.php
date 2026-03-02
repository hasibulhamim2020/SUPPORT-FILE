<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$x = 1;
$sql = 'select * from sales_corporate_price';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
	$sql2 = 'select m_price from item_info where item_id ="'.$data->item_id.'"';
	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	{	$sp = ($data2->m_price - ($data2->m_price*$data->discount)/100);
		$set_price = number_format($sp, 2, ',', ' ');
		if($data->discount>0){
		$dset_price = number_format($data->set_price, 2, ',', ' ');
		if($set_price!=$dset_price){
		$up_sql = "UPDATE `sales_corporate_price` SET `set_price` = '".$sp."' WHERE item_id ='".$data->item_id."' and dealer_code ='".$data->dealer_code."' limit 1";
		db_query($up_sql);
		echo '<br>'.$x++;
		}}
		
	}
}
?>