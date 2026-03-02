<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Delivery Challan Create';

$tr_type="Show";

do_calander('#so_date');

do_calander('#chalan_date');

$table_master='requisition_master_vision';

$table_details='requisition_order_vision';

$unique='req_no';

if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];

if($_REQUEST[$unique]>0){

$$unique=$_REQUEST[$unique];

$_SESSION[$unique]=$$unique;}

else

$$unique = $_SESSION[$unique];

if(isset($_POST['confirmm']))

{

unset($_POST);

$_POST[$unique]=$$unique;

$_POST['edit_by']=$_SESSION['user']['id'];

$_POST['edit_at']=date('Y-m-d h:i:s');

$_POST['status']='PROCESSING';

$crud   = new crud($table_master);

$crud->update($unique);

unset($$unique);

unset($_SESSION[$unique]);

$type=1;

$msg='Successfully Completed All Purchase Order.';

echo '<script>window.location.replace("select_unfinished_do.php")</script>';

$tr_type="Complete";

}

if(isset($_POST['return']))

{

$remarks = $_POST['return_remarks'];

unset($_POST);

$_POST[$unique]=$$unique;

$_POST['status']='MANUAL';

$_POST['checked_at'] = date('Y-m-d H:i:s');

$_POST['checked_by'] = $_SESSION['user']['id'];

$crud   = new crud($table_master);

$crud->update($unique);

$note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique.'","CHALAN","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';

db_query($note_sql);

unset($$unique);

unset($_SESSION[$unique]);

$type=1;

echo $msg='<span style="color:green;">Successfully Returned</span>';

echo '<script>window.location.replace("select_wo_for_challan.php")</script>';

}

if(isset($_POST['delete']))

{

unset($_POST);

$_POST[$unique]=$$unique;

$_POST['edit_by']=$_SESSION['user']['id'];

$_POST['edit_at']=date('Y-m-d H:i:s');

$_POST['status']='CHECKED';

$crud   = new crud($table_master);

$crud->update($unique);

unset($$unique);

unset($_SESSION[$unique]);

$type=1;

$msg='Order Returned.';

}

if(prevent_multi_submit()){

if(isset($_POST['confirm'])){

$ch_date=$_POST['chalan_date'];

$rec_name=$_POST['rec_name'];

$rec_mob=$_POST['rec_mob'];

$vehicle_no=$_POST['vehicle_no'];

$driver_name=$_POST['driver_name'];

$driver_mobile=$_POST['driver_mobile'];

$delivery_point=$_POST['delivery_point'];

$delivery_man=$_POST['delivery_man'];

$delivery_man_mobile=$_POST['delivery_man_mobile'];

$entry_by= $_SESSION['user']['id'];

$entry_at = date('Y-m-d H:i:s');

$YR = date('Y',strtotime($ch_date));

$yer = date('y',strtotime($ch_date));

$month = date('m',strtotime($ch_date));

$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;

$cy_id = sprintf("%07d", $ch_cy_id);

$chalan_no=''.$yer.''.$month.''.$cy_id;

//$chalan_no = next_transection_no($group_for,$ch_date,'sale_do_chalan','chalan_no');

//$gate_pass = next_transection_no('0',$ch_date,'sale_do_chalan','gate_pass');

$ms_data = find_all_field('requisition_master_vision','','req_no='.$req_no);

$sql = 'select d.* from requisition_order_vision d, item_info i where  d.item_id=i.item_id and d.req_no = '.$req_no;

$query = db_query($sql);

//$pr_no = next_pr_no($warehouse_id,$rec_date);

while($data=mysqli_fetch_object($query))

{

if($_POST['chalan_'.$data->id]>0)

{

$qty=$_POST['chalan_'.$data->id];

$rate=$_POST['rate1_'.$data->id];

$item_id =$_POST['item_id_'.$data->id];

$amount = ($qty*$rate); 

$cost_price=find_a_field('journal_item','final_price','item_id="'.$item_id.'" and tr_from in ("Purchase","Opening","Production Receive","Receive","fg_transfer") order by id desc ');

$cost_amt = ($qty*$cost_price); 

$so_invoice = 'INSERT INTO sale_do_chalan (year, ch_id, chalan_no, chalan_date, order_no, do_no,req_no, job_no, do_date, item_id, dealer_code, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt, discount, depot_id, group_for, rec_name, rec_mob, vehicle_no, driver_name, driver_mobile, delivery_point, delivery_man, delivery_man_mobile, entry_by, entry_at, status, cost_price, cost_amt)

VALUES("'.$YR.'","'.$ch_cy_id.'","'.$chalan_no.'","'.$ch_date.'","'.$data->id.'","'.$data->do_no.'","'.$data->req_no.'","'.$data->job_no.'","'.$data->req_date.'","'.$item_id.'","'.$ms_data->dealer_code.'","'.$rate.'","'.$pkt_size.'","'.$pkt_unit.'","'.$qty.'","'.$qty.'","'.$amount.'","'.$discount.'","'.$ms_data->warehouse_id.'","'.$ms_data->group_for.'","'.$rec_name.'","'.$rec_mob.'","'.$vehicle_no.'","'.$driver_name.'","'.$driver_mobile.'","'.$delivery_point.'","'.$delivery_man.'","'.$delivery_man_mobile.'","'.$entry_by.'","'.$entry_at.'","CHECKED", "'.$cost_price.'", "'.$cost_amt.'")';

db_query($so_invoice);

journal_item_control($item_id, $ms_data->warehouse_id, $ch_date,  0, $qty, 'Sales', $data->id, $rate, '', $chalan_no, '', '',$ms_data->group_for, $rate->unit_price, '' );

$tr_no=$chalan_no;

$tr_id=$data->id;

$tr_type="Add";

}

}

if($chalan_no>0)

{

//auto_insert_sales_chalan_secoundary($chalan_no);

}

}

}

else

{

$type=0;

$msg='Data Re-Submit Warning!';

}

if($$unique>0)

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table_master,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

//if($delivery_within>0)

//{

//	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);

//}

$tr_from="Warehouse";

?>

<script>

function calculation(id){

var chalan=((document.getElementById('chalan_'+id).value)*1);

var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);

var stock_qty=((document.getElementById('stk_qty_'+id).value)*1);

if(chalan>stock_qty)

{

alert('Can not issue more than Stock quantity');

document.getElementById('chalan_'+id).value='';

document.getElementById('rate1_'+id).value='';

}

if(chalan>pending_qty)

{

alert('Can not issue more than pending quantity.');

document.getElementById('chalan_'+id).value='';

} 

}


function cal_id(id){


var rate=$('#rate1_'+id).val();

var qty=$('#chalan_'+id).val();

$('#total_'+id).val(rate*qty);

}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<!--        top form start hear-->

<div class="container-fluid bg-form-titel">

<div class="row">

<!--left form-->

<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

<div class="container n-form2">

<div class="form-group row m-0 pb-1">

<? $field='req_no';?>

<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">REQ NO </label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>

</div>

</div>

<div class="form-group row m-0 pb-1">

<? $field='req_date';?>

<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">REQ Date</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>

</div>

</div>


</div>

</div>

<!--Right form-->

<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

<div class="container n-form2">

<div class="form-group row m-0 pb-1">

<? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company </label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

<input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field('user_group','group_name','id='.$group_for)?>" readonly="readonly" />

<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" readonly="readonly"/>


</div>

</div>

<div class="form-group row m-0 pb-1">

<? $field='req_no'; $table='purchase_master';$get_field='req_no';$show_field='req_no';?>

<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

<input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" readonly="readonly"/>

<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>" readonly="readonly"/>

</div>

</div>

<div class="form-group row m-0 pb-1">

<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Remarks</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

<input  name="remarks" type="text" id="remarks" value="<?=$remarks?>"  readonly="readonly"/>

</div>

</div>

</div>

</div>

<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

<div class="d-flex justify-content-center pt-2 pb-2">

<div class="n-form1 fo-white pt-0 p-0">

<div class="container p-0">

<table class="table1  table-striped table-bordered table-hover table-sm">

<thead>

<tr class="bgc-yellow">

<td><strong>Date</strong></td>

<td><strong>Chalan No</strong></td>

</tr>

</thead>

<?

$sql='select distinct chalan_no, chalan_date from sale_do_chalan where req_no='.$$unique.' order by id desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>

<tr>

<td><?php echo date('d-m-Y',strtotime($aaa->chalan_date));?></td>

<td ><a target="_blank" href="delivery_challan_print_view.php?v_no=<?=$aaa->chalan_no?>"><?=$aaa->chalan_no?></a></td>

</tr>

<?

}

?>			  

</table>

</div>

</div>

</div>

</div>

</div>

</div>

<div class="d-flex justify-content-center pt-5 pb-2">

<div class="n-form1 fo-white pt-0 p-0">

<div class="container p-0">

<table class="table1  table-striped table-bordered table-hover table-sm">

<tr>

<td colspan="3" align="center"><strong>Entry Information</strong></td>

</tr>

<tr>

<td align="right" >Created By:</td>

<td align="left" >&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

<?php /*?><td rowspan="2" align="center" ><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/sales_order_print_view.php?v_no=<?=$$unique?>" ><img src="../../../images/print.png" alt="" width="30" height="30" /></a></td><?php */?>

</tr>

<tr>

<td align="right" >Created On:</td>

<td align="left">&nbsp;&nbsp;<?=$req_date?></td>

</tr>

</table>

</div>

</div>

</div>

<div class="container-fluid bg-form-titel">

<div class="row">

<!--left form-->

<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

<div class="container n-form2">

<div class="form-group row m-0 pb-1">

<? $ch_data = find_all_field('sale_do_chalan','','chalan_no='.$_SESSION['chalan_no']);?>

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan Date </label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

<input name="chalan_date" type="text" id="chalan_date" required="required" value="<?=($ch_data->chalan_date!='')?$ch_data->chalan_date:date('Y-m-d')?>"/>

</div>

</div>

<div class="form-group row m-0 pb-1">

<label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vehicle No</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

<input name="vehicle_no" type="text" id="vehicle_no" value="<?=$ch_data->vehicle_no;?>" />

</div>

</div>

<div class="form-group row m-0 pb-1">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Point</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

<input  name="delivery_point" type="text" id="delivery_point" value="<?=$ch_data->delivery_point;?>" />

</div>

</div>

</div>

</div>

<!--Right form-->

<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

<div class="container n-form2">

<div class="form-group row m-0 pb-1">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receiver Name</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

<input  name="rec_name" type="text" value="<?=$ch_data->rec_name;?>" id="rec_name" />

</div>

</div>

<div class="form-group row m-0 pb-1">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Driver Name</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

<input name="driver_name" type="text" id="driver_name" value="<?=$ch_data->driver_name;?>"  />

</div>

</div>

<div class="form-group row m-0 pb-1">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Man</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

<input  name="delivery_man" type="text" id="delivery_man" value="<?=$ch_data->delivery_man;?>"  />

</div>

</div>

</div>

</div>

<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

<div class="container n-form2">

<div class="form-group row m-0 pb-1">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receiver Mobile </label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

<input   name="rec_mob" value="<?=$ch_data->rec_mob;?>"  type="text" id="rec_mob" />

</div>

</div>

<div class="form-group row m-0 pb-1">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Driver Mobile</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

<input  name="driver_mobile"  type="text" id="driver_mobile" value="<?=$ch_data->driver_mobile;?>" />

</div>

</div>

<div class="form-group row m-0 pb-1">

<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Man Mobile</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

<input  name="delivery_man_mobile" type="text" id="delivery_man_mobile" value="<?=$ch_data->delivery_man_mobile;?>"  />

</div>

</div>

</div>

</div>

</div>

</div>

<!--return Table design start-->

<div class="container-fluid pt-5 p-0 ">

<? if($$unique>0){

 $sql='select a.id,  a.item_id, b.item_name,  b.unit_name,  a.qty 

from requisition_order_vision a,item_info b, item_sub_group s where b.item_id=a.item_id 

and b.sub_group_id=s.sub_group_id and  a.req_no='.$$unique;

$res=db_query($sql);

?>

<table class="table1  table-striped table-bordered table-hover table-sm">

<thead class="thead1">

<tr class="bgc-info">

<th>SL</th>

<th>Item Name </th>

<th>Unit Name</th>

<th>Stock Qty</th>

<th>SO Qty </th>

<th>Delivered</th>

<th>Pending </th>


<th>Rate </th>

<th>Challan Qty </th>

<th>Total</th>

</tr>

</thead>

<tbody class="tbody1">

<? while($row=mysqli_fetch_object($res)){$bg++?>

<tr>

<td><?=++$ss;?></td>

<td style="text-align:left"><?=$row->item_name?>

<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	

<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>

<td align="center"><?=$row->unit_name?> </td>

<td align="center">
<? echo number_format($stock_qty=find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$row->item_id.'" and warehouse_id=1'),2);?>

<input type="hidden" name="stk_qty_<?=$row->id?>" id="stk_qty_<?=$row->id?>" value="<?=$stock_qty?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>

<td align="center"><?=number_format($row->qty,2);?></td>

<td align="center"><? echo number_format($so_qty = (find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>

<td align="center"><? 

echo number_format($unso_qty=($row->qty-$so_qty),2);?>

<input type="hidden" name="unso_qty_<?=$row->id?>" id="unso_qty_<?=$row->id?>" value="<?=$unso_qty?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>





<td align="center"><input name="rate1_<?=$row->id?>" type="text" id="rate1_<?=$row->id?>" onKeyUp="calculation(<?=$row->id?>);cal_id(<?=$row->id?>)" /> </td>

<td align="center"><input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" onKeyUp="calculation(<?=$row->id?>);cal_id(<?=$row->id?>)" /> </td>

<td>
<? if($unso_qty>0){$cow++;?>
<input name="total_<?=$row->id?>" type="text" id="total_<?=$row->id?>" value="" readonly  />

 <? } else echo 'Done';?>
</td>
		  
		  
		 	

</tr>

<? }?>

</tbody>

</table>

</div>

<!--button design start-->

<div class="container-fluid p-0 ">

<div class="n-form-btn-class">

<? if($cow<1){

$vars['status']='COMPLETED';

db_update($table_master, $req_no, $vars, 'req_no');

?>

<div class="alert alert-success p-2" role="alert">

THIS  CHALLAN IS COMPLETE

</div>

<? }else{

$chalaned = find_a_field('sale_do_chalan','sum(dist_unit)','do_no="'.$do_no.'"');

if($chalaned>0){

?>

<input name="confirm" type="submit" class="btn1 btn1-submit-input" value="CONFIRM CHALLAN" /></td>

<? } else{?>

<input name="return" type="submit" class="btn1 btn1-bg-cancel" value="RETURN" onclick="return_function()" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/><input type="hidden" name="return_remarks" id="return_remarks"></td>

<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM CHALLAN"  />

<? } }?>

</div>

</div>

<? } ?>

</form>

</div>


</tr>

<tr>

<td colspan="5" valign="top">


<script>$("#codz").validate();$("#cloud").validate();</script>

<script>

function count()

{

if(document.getElementById('unit_price').value!=''){

var unit_price = ((document.getElementById('unit_price').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);

var total_unit = (document.getElementById('total_unit').value)=dist_unit;

var total_amt = (document.getElementById('total_amt').value) = total_unit*unit_price;

var pcs_stock = ((document.getElementById('pcs_stock').value)*1);

if(dist_unit>pcs_stock){

alert("Stock Overflow");

document.getElementById('dist_unit').value=0;

}else{

var total_amt = (document.getElementById('total_amt').value) = dist_unit*unit_price;

}

}

}

function return_function() {

var notes = prompt("Why Return This?","");

if (notes!=null) {

document.getElementById("return_remarks").value =notes;

document.getElementById("cz").submit();

}

return false;

}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";









?>