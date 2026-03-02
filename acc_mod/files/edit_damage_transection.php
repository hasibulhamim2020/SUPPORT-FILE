<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

    $sql=db_query("select distinct sj.tr_no

from 

secondary_journal sj  

where 

sj.checked = 'NO' and 
sj.tr_from ='DamageReturn'");
	while($data = mysqli_fetch_object($sql)){
	
$res = 'select d.id,d.qty,s.set_price from  sales_corporate_price s, warehouse_damage_receive_detail d where d.vendor_id=s.dealer_code and d.item_id=s.item_id and d.or_no='.$data->tr_no;
	$query = db_query($res);
	$count = mysqli_num_rows($query);
		if($count>0)
		{
			while($info = mysqli_fetch_object($query))
			{
				$rate = $info->set_price;
				$qty = $info->qty;
				$amount = ($rate*$qty);
				$update_sql = 'update warehouse_damage_receive_detail set qty="'.$qty.'",amount="'.$amount.'" where id='.$info->id;
				echo $update_sql.'<br>';
			}
			reinsert_damage_return_secoundary($data->tr_no);
		}
	}

?>




