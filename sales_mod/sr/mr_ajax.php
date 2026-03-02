<?php



session_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



@ini_set('error_reporting', E_ALL);



@ini_set('display_errors', 'Off');







 $str = $_POST['data'];



$data=explode('##',$str);



$item=explode('#>',$data[0]);



$item_id = $item[2];



if($item_id>0){



$stock = (int)warehouse_product_stock($item_id ,$data[1]);



$last_p = find_all_field('purchase_invoice','','item_id="'.$item_id.'" order by id desc');



$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');}



?>

<table style="width:100%;" border="1">

						 <tr>

<td width="33%"><input name="qoh" type="text" class="input3" id="qoh" style="width:98%;" value="<?=$stock?>"  readonly/>  </td>



<td width="23%"><input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:98%;" value="<?=$item_all->unit_name?>" onfocus="focuson('qty')" /></td>

</tr></table>