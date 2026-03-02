<?php

session_start();

ob_start();

require "../../support/inc.all.php";

$title='Demand Order Create for Cash Sale';

do_calander('#do_date');

$now = date('Y-m-d H:s:i');

if($_GET['concern']>0)
$group_for =$_SESSION['concern'] = $_GET['concern'];

do_calander('#est_date');

$page = 'do_cash_sale.php';

$table_master='sale_do_master';

$unique_master='do_no';

$table_detail='sale_do_details';

$unique_detail='id';


$table_chalan='sale_do_chalan';

$unique_chalan='id';


if($_REQUEST['old_do_no']>0)

$$unique_master=$_REQUEST['old_do_no'];

elseif(isset($_GET['del']))

{$$unique_master=find_a_field('sale_do_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}

else

$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){





if(isset($_POST['new']))



{



		$crud   = new crud($table_master);



		$_POST['entry_at']=date('Y-m-d H:s:i');



		$_POST['entry_by']=$_SESSION['user']['id'];



		if($_POST['flag']<1){



		$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;



		$$unique_master=$crud->insert();



		unset($$unique);



		$type=1;



		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';



		}



		else {



		$crud->update($unique_master);



		$type=1;



		$msg='Successfully Updated.';



		}



}




if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{


//$crud   = new crud($table_master);
//
//$_POST['edit_at']=date('Y-m-d H:i:s');
//$_POST['edit_at']=$_SESSION['user']['id'];
//$dealer = explode('-',$_POST['dealer_code']);
//$dealer_code = $_POST['dealer_code'] = $dealer[0];
//
//
// $dealer_ledger =  find_a_field('dealer_info','account_code','dealer_code="'.$dealer_code.'"');
// $dealer_balance = find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$dealer_ledger.'"');
//
//
// if($dealer_balance<0) {
//  $closing_balance =  $dealer_balance*(-1); 
// }else {
//  $closing_balance = $dealer_balance;
// }
// 
// $dealer_total_sale = find_a_field('journal','sum(dr_amt)','ledger_id="'.$dealer_ledger.'"');
// 
//  $sales_percentage = ($closing_balance/$dealer_total_sale)*100;
// 		
	
 
 
// if($sales_percentage<20){
// 	$_POST['order_create'] = 'Yes';
// }else {
//  $_POST['order_create'] = 'No';
// }
 
 //
//  if($dealer_balance<0 ) {
//  	$_POST['order_create'] = 'Yes';
//	} elseif($dealer_balance==0) {
//	$_POST['order_create'] = 'Yes';
//	}elseif ($dealer_balance>0 & $sales_percentage<20 ) {
//	$_POST['sales_percentage'] = $sales_percentage;
//	$_POST['order_create'] = 'Yes';
//	}else {
//	$_POST['sales_percentage'] = $sales_percentage;
// 	$_POST['order_create'] = 'No';
// 	}
//	
//	


//
//$customer = explode('-',$_POST['via_customer']);
//$via_customer = $_POST['via_customer'] = $customer[0];
//
//if($_POST['flag']<1){
//$_POST['entry_at']=date('Y-m-d H:i:s');
//$_POST['entry_by']=$_SESSION['user']['id'];
//$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;
//$$unique_master=$crud->insert();
//unset($$unique);
//$type=1;
//$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
//}

$table		=$table_detail;

if($_POST['sub_group_id']!=0){
$_SESSION['sub_group'] = $_POST['sub_group_id'];
$_SESSION['dealer_code'] = $_POST['dealer_code'];
$_SESSION['group_for'] = $_POST['group_for'];
}

$crud      	=new crud($table);

$xid = $crud->insert();
if($_REQUEST['bag_unit']>0){
$item_id = $_POST['item_id'];
 $r_sql = "select i.item_id,g.gunny_bag as gunny,g.poly_bag as poly from item_info i,item_sub_group g where  i.sub_group_id=g.sub_group_id and i.item_id=".$item_id;
$r1=db_query($r_sql);
while($rs1=mysqli_fetch_object($r1))
{
			$item_id = $rs1->item_id;
			$item_gunny=$rs1->gunny;
			$item_poly=$rs1->poly;
if($item_gunny>0){
$gunny_price =find_a_field('item_info','d_price',' item_id='.$item_gunny);
$_REQUEST['total_amt'] = $gunny_price*$_REQUEST['bag_unit']; 

$gunny_sql = "INSERT INTO `sale_do_details` 
(`do_no`,  `do_date`, dealer_code,  via_customer, `item_id`, `unit_price`, `bag_unit`, dist_unit, total_unit, `total_amt`, depot_id,  entry_by, entry_at) VALUES
('".$do_no."',  '".$_POST['do_date']."', '".$dealer_code."', '".$via_customer."', '".$item_gunny."',  '".$gunny_price."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."',
  '".$_REQUEST['total_amt']."',  '".$_POST['depot_id']."', '".$_SESSION['user']['id']."', '".$now."')";

db_query($gunny_sql);




			}
			
if($item_poly>0){
$poly_price=find_a_field('item_info','d_price',' item_id='.$item_poly);

$_REQUEST['total_amt'] = $poly_price*$_REQUEST['bag_unit'];

$gunny_sql = "INSERT INTO `sale_do_details` 
(`do_no`,  `do_date`, dealer_code,  via_customer, `item_id`, `unit_price`, `bag_unit`, dist_unit, total_unit, `total_amt`, depot_id,  entry_by, entry_at) VALUES
('".$do_no."',  '".$_POST['do_date']."', '".$dealer_code."',  '".$via_customer."',  '".$item_poly."',  '".$poly_price."', '".$_REQUEST['bag_unit']."',  '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."', 
 '".$_REQUEST['total_amt']."',  '".$_POST['depot_id']."',  '".$_SESSION['user']['id']."', '".$now."')";

db_query($gunny_sql);



}
}

//if($_POST['group_for']==5){
//
//$gunny =find_all_field('item_info','',' item_id="900120001" ');
//
//$_REQUEST['init_total_amt'] = $gunny->d_price*$_REQUEST['init_bag_unit'];
//
//  $gunny_sql = "INSERT INTO `sale_do_details` 
//(`do_no`, `do_date`, dealer_code, `item_id`, `unit_price`, `init_bag_unit`,`init_total_amt`) VALUES
//('".$do_no."', '".$do_date."', '".$dealer_code."', '".$gunny->item_id."',  '".$gunny->d_price."', '".$_REQUEST['init_bag_unit']."',  '".$_REQUEST['init_total_amt']."')";
//
//db_query($gunny_sql);
//
//}



}



//$table_ch		=$table_chalan;


//$crud      	=new crud($table_ch);


//$cid = $crud->insert();

  //$challan_sql = "INSERT INTO `sale_do_chalan` 
// (`chalan_no`, `order_no`, do_no, `item_id`, `dealer_code`, `unit_price`,`pkt_unit`, bag_unit, dist_unit, total_unit, total_amt, chalan_date, depot_id, group_for, entry_by, entry_at) VALUES
//('".$_POST['chalan_no']."', '".$xid."', '".$_POST['do_no']."', '".$_POST['item_id']."',  '".$_POST['dealer_code']."', '".$_POST['unit_price']."',  '".$_POST['pkt_unit']."', '".$_POST['bag_unit']."', '".$_POST['dist_unit']."' , '".$_POST['total_unit']."' , '".$_POST['total_amt']."' , '".$_POST['do_date']."' ,'4', '".$_POST['group_for']."', '".$_SESSION['user']['id']."', '".$now."' )";
//
//db_query($challan_sql);


   










//$_POST['init_total_unit'] = $_POST['init_dist_unit'];

//$_POST['in_stock_kg']=$_POST['in_stock'];

//$_POST['init_total_amt'] = ($_POST['init_total_unit'] * $_POST['unit_price']);

//$_POST['t_price'] = 0;

//$_POST['gift_on_order'] = $crud->insert();

}

}

else

{

$type=0;

$msg='Data Re-Submit Error!';

}

if($del>0)

{	

$main_del = find_a_field($table_detail,'gift_on_order','id = '.$del);

$crud   = new crud($table_detail);

if($del>0)

{

$condition=$unique_detail."=".$del;		

$crud->delete_all($condition);

$condition="gift_on_order=".$del;		

$crud->delete_all($condition);

if($main_del>0){

$condition=$unique_detail."=".$main_del;		

$crud->delete_all($condition);

$condition="gift_on_order=".$main_del;		

$crud->delete_all($condition);}

}


 $sql1 = "delete from journal_item where tr_from = 'Sales' and tr_no = '".$del."'";


		db_query($sql1);




$type=1;

$msg='Successfully Deleted.';

}

if($$unique_master>0)

{

$condition=$unique_master."=".$$unique_master;

$data=db_fetch_object($table_master,$condition);

while (list($key, $value)=@each($data))

{ $$key=$value;}

}

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

auto_complete_from_db('dealer_info','item_name','concat(item_name,"#>",finish_goods_code)','','vai_cutomer');

auto_complete_from_db('area','area_name','area_code','','district');

auto_complete_from_db('customer_info','customer_name_e ','customer_code',' dealer_code='.$dealer_code,'via_customer1');

?>

<script language="javascript">

function count(){

var unit_price=(document.getElementById('unit_price').value)*1; 



var dist_unit=(document.getElementById('dist_unit').value)*1; 



document.getElementById('total_unit').value=(dist_unit*1);

document.getElementById('total_amt').value=(unit_price*dist_unit);

}



function comm_cal() {

var init_total_amt=(document.getElementById('init_total_amt').value*1);

var comm_amount=(document.getElementById('commission2').value*1);

var ctn=(document.getElementById('init_pkt_unit').value*1);

document.getElementById('commission').value=(ctn*comm_amount);

var tot_comm=(document.getElementById('commission').value*1);

document.getElementById('net_amount').value=(init_total_amt-tot_comm);

}



window.onload = function() {
  document.getElementById("itemin").focus();
};






</script>

<script language="javascript">

function focuson(id) {

if(document.getElementById('item').value=='')

document.getElementById('item').focus();

else

document.getElementById(id).focus();

}

function wait1sec() {
    setTimeout(function () {}, 1000);
}


window.onload = function() {
if(document.getElementById("flag").value=='0')
document.getElementById("dealer_code").focus();
else
document.getElementById("itemin").focus();
}


function avail_amount(){

var received_amt=(document.getElementById('received_amt').value*1);

var net_amount=(document.getElementById('net_amount').value*1);

var available_amt=received_amt-net_amount;

document.getElementById('received_amt2').value=available_amt.toFixed(2);

if(available_amt<0){

document.getElementById("add").disabled = true;

document.getElementById("confirm").disabled = true;

alert('You Can\'t make order more then received amount from this Dealer!');

}else{document.getElementById("add").disabled = false;

document.getElementById("confirm").disabled = false;

}

}

</script>

<script language="javascript">
$(document).ready(function(){ focuson('itemin');})
function grp_check(id)

{

if(document.getElementById("itemin").value!=''){

var itemin = document.getElementById("itemin").value;
var item_id = itemin.split('-',1);
document.getElementById("item").value = item_id;
getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$dealer->depot;?>');

}

}


</script>
<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>


<div class="form-container_large">

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

<tr>

<td width="58%">

<fieldset style="width:400px;">

<div>

<label style="width:100px;">Invoice No : </label>

<input style="width:290px;"  name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

</div>






<div>

<label style="width:100px;">Concern Name:</label>
<input   name="group_for" id="group_for" readonly  type="hidden" value="<?=$group_for?>"/>
<input  style="width:290px;" name="group_for2" id="group_for2" readonly  type="text" value="<?=find_a_field('cost_center','center_name','id='.$group_for)?>"/>
<input style="width:290px;"  name="dealer_code" type="hidden" id="dealer_code" value="1" required/>
</div>




<div>
  <label style="width:100px;">Customer : </label>
  <input style="width:290px;"  name="do_type" type="hidden" id="do_type" value="CASH SALE" />
  <input style="width:290px;"  name="customer_name" type="text" id="customer_name"  value="<?=$customer_name?>" />
</div>
</fieldset></td>

<td width="42%"><fieldset style="width:400px;">

<div>

<label style="width:150px;">Invoice Date : </label>

<input style="width:200px;"  name="do_date" type="text" id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>"  required/>

</div>


<div>
  <label style="width:150px;">Payment Method :</label>
  <select  style="width:200px; height:20px;" name="debit_head" id="debit_head" required="required" >
    <option></option>
    <? 

foreign_relation('payment_method', 'id', 'payment_type', $debit_head,'1');


?>
  </select>
</div>



<div>

<label style="width:150px;">Cash Discount : </label>

<input name="cash_discount" type="text" id="cash_discount" style="width:200px;" value="<?=$cash_discount?>" tabindex="105" />

</div>


</fieldset></td>

</tr>

<td colspan="3">



	



		<div class="buttonrow" style="margin-left:320px;">



		<? if($$unique_master>0) {?>



		<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:250px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="1" />



		<? }else{?>



		<input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:250px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="0" />



		<? }?>



		</div>



</td>

<tr>

<td colspan="3">

<!--<div class="buttonrow" style="margin-left:240px;">

<? if($$unique_master>0) {?>

<input name="flag" id="flag" type="hidden" value="1" />

<? }else{?>

<input name="flag" id="flag" type="hidden" value="0" />

<? }?>

</div>-->

<a target="_blank" href="../report/invoice_view.php?v_no=<?=$$unique_master?>"><img src="../../images/print.png" alt="" width="26" height="26" /></a></td>

</tr>

</table>


</form>

<? if($$unique_master>0) {?>

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
















<tr>

<td width="30%" align="center" bgcolor="#0073AA"><span class="style2">Product Name </span></td>

<td width="59%" align="center" bgcolor="#0073AA"><table width="100%" border="1" cellspacing="0" cellpadding="0">

<tr>

<td width="22%" rowspan="2" align="center" bgcolor="#0073AA"><span class="style2">Stock</span></td>

<!--<td align="center" bgcolor="#0099FF" width="13%"><strong>UnDel</strong></td>-->

<td width="25%" rowspan="2" align="center" bgcolor="#0073AA"><span class="style2">Price</span></td>

<td width="23%" align="center" bgcolor="#0073AA"><span class="style2">Order Qty</span></td>

<td width="30%" rowspan="2" align="center" bgcolor="#0073AA"><span class="style2">Amount</span></td>
</tr>

<tr>

<td align="center" bgcolor="#0073AA"><span class="style2"> Unit </span></td>
</tr>

</table></td>
</tr>

<tr>

<td align="center" bgcolor="#CCCCCC">

<span id="sub">
<?

if($group_for==4) {
auto_complete_from_db('item_info','item_short_name','concat(item_id,"- ",item_name)',' group_for =3 and product_nature="Salable"','itemin');
} else{
auto_complete_from_db('item_info','item_short_name','concat(item_id,"- ",item_name)',' group_for = "'.$group_for.'" and product_nature="Salable"','itemin');
}

?>
<input type="text" id="itemin" name="itemin"  style="width:350px; height:20px;"  required onblur="grp_check(this.value);focuson('init_bag_unit')" />
<input type="hidden" id="item" name="item"  />
<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />

<input type="hidden" id="depot_id" name="depot_id" value="2"  />
</span></td>

<td bgcolor="#CCCCCC">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td bgcolor="#CCCCCC"><span id="do"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><input name="in_stock" type="text" class="input3" id="in_stock"  style="width:110px; height:20px;" value="<?=$in_stock?>" readonly onFocus="focuson('init_bag_unit')"/>

<input name="item_id" type="hidden" class="input3" id="item_id"  style="width:80px; height:20px;"  value="<?=$item_all->item_id?>" readonly/>
<input name="via_customer" type="hidden" class="input3" id="via_customer"  style="width:80px; height:20px;" readonly/></td>

<!--<td><input name="undel" type="text" class="input3" id="undel"  style="width:55px;" readonly  value="<?=($ordered_qty+$del_qty)?>"/></td>-->

<td><input name="unit_price" type="text" class="input3" id="unit_price"  style="width:100px; height:20px;"  onkeyup="count()" value="<?=$item_all->d_price?>" readonly/>

<input name="init_bag_size" type="hidden" class="input3" id="init_bag_size"  style="width:80px; height:20px;"  value="<?=$item_all->pack_size?>" readonly/></td>
</tr>

</table></span></td>

<td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><input placeholder="Unit"  name="dist_unit" type="text" class="input3" id="dist_unit" style="width:100px; height:20px;" onKeyUp="count()" onBlur="count()" required="required"  tabindex="0"/>

<input placeholder="Bag"  name="bag_unit" type="hidden" class="input3" id="bag_unit" style="width:80px; height:20px;" onKeyUp="count()" onBlur="count()"  value="0"  tabindex="0"/></td>

<td></td>

<td>

<input  name="pkt_unit" type="hidden" class="input3" id="pkt_unit" style="width:80px; height:20px;" value="0" /></td>

<td><input name="total_unit" type="hidden" class="input3" id="total_unit"  style="width:80px; height:20px;"  onKeyUp="count()"  readonly/>

<input placeholder="Amount" name="total_amt" type="text" class="input3" id="total_amt" style="width:120px; height:20px;" onKeyUp="count()" readonly/></td>
</tr>

</table></td>
</tr>
</table></td>
</tr>

<tr><td></td>

<td width="59%"  align="center" bgcolor="#FF0000"><div class="button">

<input name="add" type="submit" id="add" value="ADD" onClick="count()" class="update" tabindex="5"/>

</div></td></tr>
</table>

<? if($$unique_master>0){?>

<br /><br /><br /><br />

<? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

 $res='select a.id, a.item_id, s.sub_group_name, b.item_name, a.unit_price,a.dist_unit, a.bag_unit,a.total_amt,a.in_stock_kg, w.warehouse_name  from sale_do_details a,item_info b, item_sub_group s, warehouse w where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and w.warehouse_id=a.depot_id and a.do_no='.$$unique_master.' order by a.id';

?>

<div  class="tabledesign2">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<th width="5%">SL</th>

<th width="13%">Sub Group </th>

<th width="22%">Product Name</th>

<th width="21%">Warehouse</th>

<th width="9%">Price</th>

<th width="9%">Unit</th>

<th width="15%">Amount</th>

<th width="3%">X</th>
</tr>

<?

$i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){ ?>

<tr>

<td><?=$i++?></td>

<td><?=$data->sub_group_name?></td>

<td><?=$data->item_name?></td>

<td><?=$data->warehouse_name?></td>

<td><?=$data->unit_price?></td>

<td><?=$data->dist_unit?></td>

<td><?=$data->total_amt?></td>

<td><a href="?del=<?=$data->id?>">X</a></td>
</tr>

<? 

$total_unit = $total_unit + $data->dist_unit;

$total_bag = $total_bag + $data->bag_unit;

$total_amt = $total_amt + $data->total_amt;

} ?>

<tr>

<td colspan="5">Total:</td>

<td><?=$total_unit?></td>

<td><?=number_format($total_amt,2);?>          <a href="?del=<?=$data->id?>"></a></td>

<td>&nbsp;</td>
</tr>
</table>

</div>

</form>


<? }?>

<form action="select_dealer_do_cash_sale.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="100%" border="0">
<?php /*?>
<?php if($order_create=='Yes') {?>

<? } ?><?php */?>

<tr>

<td align="center">

<input name="delete"  type="submit" class="btn1" value="DELETE DO" style="width:100px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
<input  name="do_date" type="hidden" id="do_date" value="<?=$do_date?>"/></td><td align="right" style="text-align:right">

<input name="confirm" type="submit" class="btn1" value="PRIMARILY SAVE THIS DO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />

</td>

</tr>




</table>

<? }?>

</form>

</div>

<script>$("#cz").validate();$("#cloud").validate();</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";




?>