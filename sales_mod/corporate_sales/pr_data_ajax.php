<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $barcode_id=$data[0];

   $barcode_data=find_all_field('production_receive_detail','',"id=".$barcode_id);


?>

<table  width="100%" border="1" align="left"  cellpadding="2" cellspacing="2">
		<tr>
			<td><input name="total_unit" type="text" class="input3" readonly="" id="total_unit"  value="<?=$barcode_data->total_unit;?>"  style="width:80px;height:30px; font-size:18px;" required="required" onKeyUp="count()" />
			
			
			<input name="pr_no" type="hidden" class="input3" readonly="" id="pr_no"  value="<?=$barcode_data->pr_no;?>"  style="width:80px;height:30px; font-size:18px;" />
			<input name="pr_order_no" type="hidden" class="input3" readonly="" id="pr_order_no"  value="<?=$barcode_id;?>"  style="width:80px;height:30px; font-size:18px;"  />
			<input name="barcode" type="hidden" class="input3" readonly="" id="barcode"  value="<?=$barcode_data->barcode;?>"  style="width:80px;height:30px; font-size:18px;" />
			<input name="depot_id" type="hidden" class="input3" readonly="" id="depot_id"  value="<?=$barcode_data->warehouse_id;?>"  style="width:80px;height:30px; font-size:18px;" />
			</td>
			<td><input name="bag_size" type="text" class="input3" readonly="" value="<?=$barcode_data->bag_size;?>" id="bag_size"  style="width:70px;height:30px; font-size:18px;" required="required" onKeyUp="count()" />
			<input name="bag_unit" type="hidden" class="input3" readonly="" id="bag_unit"  value="<?=$barcode_data->bag_unit;?>"  style="width:80px;height:30px; font-size:18px;" />
			</td>
		</tr>
	</table>






