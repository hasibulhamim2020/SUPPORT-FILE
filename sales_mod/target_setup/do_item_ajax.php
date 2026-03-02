<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

 

echo $ex='select item_id,qty from sales_target where sales_person="'.$_POST['sales_person'].'" and to_date="'.$_POST['to_date'].'" and from_date="'.$_POST['from_date'].'" group by item_id';

$querys=db_query($ex);

while($ff=mysqli_fetch_object($querys)){


$itarget[$ff->item_id]=$ff->qty;

}


 
 echo $sql='select i.item_id,i.item_name,i.unit_name,i.d_price from item_info i,item_sub_group s where i.sub_group_id=s.sub_group_id and s.group_id='. $_POST['group'];
  $query=db_query($sql);
  
  $i=1;
  while($data=mysqli_fetch_object($query)){


?>
<tr>

<input name="forLoopss[]" type="hidden" value="<?=$data->item_id?>"/>


<td><?=$i++?></td>

<td><input type="text" name="item_id_<?=$data->item_id?>" id="item_id_<?=$data->item_id?>" value="<?=$data->item_id?>" readonly /></td>

<td><input type="text" name="item_name_<?=$data->item_id?>" id="item_name_<?=$data->item_id?>" value="<?=$data->item_name?>" class="scrollable-input" readonly /></td>

<td><input type="text" name="unit_name_<?=$data->item_id?>" id="unit_name_<?=$data->item_id?>" value="<?=$data->unit_name?>" class="scrollable-input" readonly /></td>

<td><input type="text" id="d_price_val_<?=$data->item_id?>" value="<?=($data->d_price>0)?$data->d_price: '' ?>"  /></td>
 
<td><input type="number" name="qty_<?=$data->item_id?>" id="qty_<?=$data->item_id?>" value="<?=$gq=$itarget[$data->item_id]?>" class="scrollable-input form-control" onkeyup="val_change(<?=$data->item_id?>)"  /></td>
<td><input type="text" name="d_price_amt_<?=$data->item_id?>" id="d_price_amt_<?=$data->item_id?>" value="<?php if($itarget[$data->item_id]>0){
echo $gi=($itarget[$data->item_id]*$data->d_price>0);
}
 

 ?>" class="scrollable-input" readonly /></td>
 



</tr>


<?  $agq+=$gq;

	$agi+=$gi;
 
 }?>
<tr>
<td colspan="5">Total</td>
<td><input type="text" id="total_qty" value="<?=$agq?>" readonly/></td>
<td><input type="text" id="total_ip" value="<?=$agi;?>" readonly/></td>
 
</tr>

<script>

 function total_change(){
 
 var total_qty = 0;
 
  var total_ips = 0;
  
  var total_tps = 0;

<?


$sql='select i.item_id from item_info i,item_sub_group s where i.sub_group_id=s.sub_group_id and s.group_id='. $_POST['group'];

$query = db_query($sql);

while($data=mysqli_fetch_object($query)){

?>

total_qty = total_qty + document.getElementById('qty_<?=$data->item_id?>').value*1;

total_ips = total_ips + document.getElementById('ip_<?=$data->item_id?>').value*1;

 

<?


}

?>

document.getElementById('total_qty').value = total_qty;

document.getElementById('total_ip').value = total_ips;

 

}
 



  function val_change(items){

  var ip=$('#d_price_val_'+items).val();
  var qty2=$('#qty_'+items).val();
  
  var qty=qty2*1;;
  
  $('#d_price_amt_'+items).val(ip*qty);
  

  
  total_change();
  }


</script>