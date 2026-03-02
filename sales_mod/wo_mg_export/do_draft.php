<?php

session_start();

ob_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sales Order Entry';

do_calander('#do_date');
do_calander('#delivery_date');

do_calander('#customer_po_date');

//create_combobox('dealer_code');

$now = date('Y-m-d H:s:i');

if($_GET['cbm_no']>0)
$cbm_no =$_SESSION['cbm_no'] = $_GET['cbm_no'];

$cdm_data = find_all_field('raw_input_sheet','','cbm_no='.$cbm_no);

do_calander('#est_date');

$page = 'do_draft.php';

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
		
		//$merchandizer_exp=explode('->',$_POST['merchandizer']);
		
		//$_POST['merchandizer_code']=$merchandizer_exp[0];


		if($_POST['flag']<1){



		$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;



		$$unique_master=$crud->insert();



		unset($$unique);



		$type=1;



		$msg='Sales Return Initialized. (Sales Return No-'.$$unique_master.')';



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


$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];


if($_REQUEST['init_bag_unit']<1){

$_POST['init_bag_unit'] = $_REQUEST['bag_unit'];
$_POST['init_dist_unit'] = $_REQUEST['total_unit'];
$_POST['init_total_unit'] = $_REQUEST['total_unit'];
$_POST['init_total_amt'] = $_REQUEST['total_amt'];

}




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
(`do_no`,  `do_date`, dealer_code,  via_customer, `item_id`, depot_id,`unit_price`, `bag_unit`, dist_unit, total_unit, `total_amt`,   entry_by, entry_at) VALUES
('".$do_no."',  '".$_POST['do_date']."', '".$_POST['dealer_code']."',  '".$_POST['via_customer']."',  '".$item_gunny."', 
 '".$_POST['depot_id']."', '".$gunny_price."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."',
  '".$_REQUEST['total_amt']."', '".$_SESSION['user']['id']."', '".$now."')";

db_query($gunny_sql);

			}
			
			
if($item_poly>0){
$poly_price=find_a_field('item_info','d_price',' item_id='.$item_poly);

$_REQUEST['total_amt'] = $poly_price*$_REQUEST['bag_unit'];

$gunny_sql = "INSERT INTO `sale_do_details` 
(`do_no`,  `do_date`, dealer_code,  via_customer,  `item_id`, depot_id, `unit_price`, `bag_unit`, dist_unit, total_unit, `total_amt`,   entry_by, entry_at) VALUES
('".$do_no."',  '".$_POST['do_date']."', '".$_POST['dealer_code']."',  '".$_POST['via_customer']."',  '".$item_poly."',  
 '".$_POST['depot_id']."',  '".$poly_price."', '".$_REQUEST['bag_unit']."',  '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."', 
 '".$_REQUEST['total_amt']."',   '".$_SESSION['user']['id']."', '".$now."')";

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

//function count(){
//
//
//var L=(document.getElementById('L_cm').value)*1;
//var W=(document.getElementById('W_cm').value)*1; 
//var H=(document.getElementById('H_cm').value)*1;
//var WL=(document.getElementById('WL').value)*1; 
//var WW=(document.getElementById('WW').value)*1;
//
//var formula=(document.getElementById('formula_cal').value);
//
//
//var sqm_rate=(document.getElementById('sqm_rate').value)*1;
//
//var unit_price=(document.getElementById('unit_price').value)*1; 
//
//var total_unit=(document.getElementById('total_unit').value)*1; 
//
//document.getElementById('total_amt').value=(unit_price*total_unit);
//
//}





window.onload = function() {  document.getElementById("itemin").focus();};



</script>

<script language="javascript">



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



//
//function TRcalculation(id){
//
//var measurement_unit = document.getElementById('measurement_unit#'+id).value;
//
//var L = document.getElementById('L_cm#'+id).value*1;
//var W = document.getElementById('W_cm#'+id).value*1;
//var H = document.getElementById('H_cm#'+id).value*1;
//var WL = document.getElementById('WL#'+id).value*1;
//var WW = document.getElementById('WW#'+id).value*1;
//
//var ply = document.getElementById('ply#'+id).value*1;
//
//var fr = document.getElementById('fr#'+id).value*1;
//var sqm_rate = document.getElementById('sqm_rate#'+id).value*1;
//var additional_charge = document.getElementById('additional_charge#'+id).value*1;
//
////alert(id);
//
//var info = L+"<@>"+W+"<@>"+H+"<@>"+WL+"<@>"+WW+"<@>"+fr+"<@>"+sqm_rate+"<@>"+measurement_unit;
//getData2('edit_formula_ajax.php','ppp'+id,id,info);
//
//var sqm = document.getElementById('sqm#'+id).value*1;
//var final_price = (document.getElementById('final_price#'+id).value)= (sqm_rate*sqm)+additional_charge;
//var unit_price = (document.getElementById('unit_price#'+id).value)=final_price;
//var total_unit = document.getElementById('total_unit#'+id).value*1;
//var total_amt = document.getElementById('total_amt#'+id).value= (unit_price*total_unit);
//
//}


function TRcalculation(){

var unit_price = document.getElementById('unit_price').value*1;
var total_unit = document.getElementById('total_unit').value*1;

var total_amt = document.getElementById('total_amt').value= (unit_price*total_unit);


// if(unit_price<final_price)
//  {
//alert('You can`t reduce the price');
//document.getElementById('unit_price').value='';
//  } 
  
  
}





//
//function update_edit(id)
//{
//var L = (document.getElementById('L_cm#'+id).value);
//var W = (document.getElementById('W_cm#'+id).value);
//var H = (document.getElementById('H_cm#'+id).value);
//var WL = (document.getElementById('WL#'+id).value);
//var WW = (document.getElementById('WW#'+id).value);
//var ply = (document.getElementById('ply#'+id).value);
//var fr = (document.getElementById('fr#'+id).value);
//var sqm_rate = (document.getElementById('sqm_rate#'+id).value);
//var additional_charge = (document.getElementById('additional_charge#'+id).value);
//var sqm = (document.getElementById('sqm#'+id).value);
//var final_price = (document.getElementById('final_price#'+id).value);
//var unit_price = (document.getElementById('unit_price#'+id).value);
//var total_unit = (document.getElementById('total_unit#'+id).value);
//var total_amt = (document.getElementById('total_amt#'+id).value);
//
//
//var style_no = (document.getElementById('style_no#'+id).value);
//var po_no = (document.getElementById('po_no#'+id).value);
//var destination = (document.getElementById('destination#'+id).value);
//var referance = (document.getElementById('referance#'+id).value);
//var sku_no = (document.getElementById('sku_no#'+id).value);
//var pack_type = (document.getElementById('pack_type#'+id).value);
//var color = (document.getElementById('color#'+id).value);
//var size = (document.getElementById('size#'+id).value);
//var delivery_date = (document.getElementById('delivery_date#'+id).value);
//
//
//
//var printing_info = (document.getElementById('printing_info#'+id).value);
//var delivery_place = (document.getElementById('delivery_place#'+id).value);
//
//
//
//var info = L+"<@>"+W+"<@>"+H+"<@>"+WL+"<@>"+WW+"<@>"+ply+"<@>"+fr+"<@>"+sqm_rate+"<@>"+additional_charge+"<@>"+sqm+"<@>"+final_price+"<@>"+unit_price+"<@>"+total_unit
//+"<@>"+total_amt
//+"<@>"+style_no+"<@>"+po_no+"<@>"+destination+"<@>"+referance+"<@>"+sku_no+"<@>"+pack_type+"<@>"+color+"<@>"+size+"<@>"+delivery_date+"<@>"+printing_info+"<@>"+delivery_place;
//getData2('do_edit_ajax.php', 'trrr'+id,id,info);
//}








</script>

<script language="javascript">


//
//function count_formula(){
//
//
//var measurement_unit=document.getElementById('measurement_unit').value;
//
//var L=(document.getElementById('L_cm').value)*1;
//var W=(document.getElementById('W_cm').value)*1; 
//var H=(document.getElementById('H_cm').value)*1;
//var WL=(document.getElementById('WL').value)*1; 
//var WW=(document.getElementById('WW').value)*1;
//
//var fr=(document.getElementById('formula_id').value)*1;
//var sqm_rate=(document.getElementById('sqm_rate').value)*1;
//var additional_charge=(document.getElementById('additional_charge').value)*1;
////alert(measurement_unit);
//
//
//var info = L+"<@>"+W+"<@>"+H+"<@>"+WL+"<@>"+WW+"<@>"+fr+"<@>"+sqm_rate+"<@>"+measurement_unit;
//getData2('formula_ajax.php', 'ppp',1,info);
//
//var sqm=(document.getElementById('sqm').value)*1;
//
//var nom_digit=(document.getElementById('number_format').value)*1;
//
//var unit_price=(document.getElementById('unit_price').value)=Number((sqm_rate*sqm)+additional_charge).toFixed(nom_digit);
//var final_price=(document.getElementById('final_price').value)=unit_price;
//var total_unit=(document.getElementById('total_unit').value)*1; 
//document.getElementById('total_amt').value=(unit_price*total_unit);
//
////alert(sqm_rate);
//
////alert(sqm);
//
//}








function grp_check(id)

{

if(document.getElementById("itemin").value!=''){

var itemin = document.getElementById("itemin").value;
var item_id = itemin.split('-',1);
document.getElementById("item").value = item_id;
getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$do_no;?>');

//alert (1);

}

}


</script>
<style type="text/css">



.onhover:focus{
background-color:#66CBEA;

}


<!--
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {font-weight: bold}
.style4 {font-weight: bold}
-->
</style>


<div class="form-container_large">

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

<tr>

<td width="50%">

<fieldset style="width:550px;">

<div>
<div>

<label style="width:220px;">Order No: </label>

<input style="width:250px;"  name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

<? if($cbm_no<1) {?>
<input   name="cbm_no" id="cbm_no" readonly  type="hidden" value="<?=$cdm_data->cbm_no?>"/>

<? }?>

<? if($cbm_no>0) {?>
<input   name="cbm_no" id="cbm_no" readonly  type="hidden" value="<?=$cbm_no?>"/>
<? }?>

</div>







<? if($group_for<1) {?>
<div>

<label style="width:220px;">Concern: </label>

<select  name="group_for" id="group_for"  style="width:250px;" required>

	
      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
		 </select>

</div>

<? }?>

<? if($group_for>0) {?>
<div>

<label style="width:220px;">Concern: </label>

		 <input name="group_for2" type="text" id="group_for2" required readonly="" style="width:250px;" 
		 value="<?=find_a_field('user_group','group_name','id='.$group_for);?>" tabindex="105" />

 
		 <input name="group_for" type="hidden" id="group_for" required readonly="" style="width:250px;" value="<?=$group_for?>" tabindex="105" />

</div>
<? }?>









<? if($dealer_code<1) {?>
<div>

<label style="width:220px;">Customer: </label>

<select  name="dealer_code" id="dealer_code"  style="width:250px;" required>

	
      <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'1');?>
		 </select>
</div>



<? }?>

<? if($dealer_code>0) {?>
<div>

<label style="width:220px;">Customer: </label>

		 <input name="group_for2" type="text" id="group_for2" required readonly="" style="width:250px;" 
		 value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" tabindex="105" />

 
		 <input name="dealer_code" type="hidden" id="dealer_code" required readonly="" style="width:250px;" value="<?=$dealer_code?>" tabindex="105" />

</div>
<? }?>






<? if($sales_type<1) {?>
<div>

<label style="width:220px;">Order Type: </label>

<select  name="sales_type" id="sales_type"  style="width:250px;" required>

		<option></option>

      <? foreign_relation('sales_type','id','sales_type',$sales_type,'1');?>
		 </select>

</div>

<? }?>

<? if($sales_type>0) {?>
<div>

<label style="width:220px;">Order Type: </label>

		 <input name="sales_type2" type="text" id="sales_type2" required readonly="" style="width:250px;" 
		 value="<?=find_a_field('sales_type','sales_type','id='.$sales_type);?>" tabindex="105" />

 
		 <input name="sales_type" type="hidden" id="sales_type" required readonly="" style="width:250px;" value="<?=$sales_type?>" tabindex="105" />

</div>
<? }?>




















</div>




</fieldset></td>

<td width="50%"><fieldset style="width:550px;">


<? if($do_date=="") {?>
<div>

<label style="width:140px;">Order Date: </label>

<input style="width:220px;"  name="do_date" type="text" id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>"  required />

</div>
<? }?>


<? if($do_date!="") {?>
<div>
<label style="width:140px;">Order Date: </label>
<input style="width:220px;"  name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"  required/>

<input style="width:220px;"  name="do_date2" type="text" id="do_date2" value="<?=$do_date;?>" readonly="" required/>
</div>
<? }?>





<? if($job_no!="") {?>
<div>
<label style="width:140px;">Job No: </label>
<input name="job_no_duplicate" type="text" id="job_no_duplicate" style="width:220px;" value="<?=$job_no?>" readonly="" tabindex="105" />

</div>

<? }?>


<div>

<label style="width:140px;">Remarks: </label>

<input name="remarks" type="text" id="remarks" style="width:220px;" value="<?=$remarks?>" tabindex="105"   autocomplete="off"  />
<input name="depot_id" type="hidden" id="depot_id" style="width:220px;" value="<?=$_SESSION['user']['depot']?>" tabindex="105" />

</div>







</fieldset></td>

</tr>

<td colspan="3">



	



		<div class="buttonrow" style="margin-left:320px;">



		<? if($$unique_master>0) {?>



		<input name="new" type="submit" class="btn1" value="Update Work Order" style="width:250px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="1" />
		
		<a target="_blank" href="work_order_print_view.php?v_no=<?=$$unique_master?>"><img src="../../../images/print.png" alt="" width="30" height="30" /></a>
		
		
		



		<? }else{?>



		<input name="new" type="submit" class="btn1" value="Initiate Work Order" style="width:250px; font-weight:bold; font-size:12px;" tabindex="12" />



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

</td>

</tr>

</table>


</form>

<? if($$unique_master>0) {?>

<form action="<?=$page?>" method="post" name="codz2" id="codz2">





<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">







<tr ><td colspan="13">&nbsp;       </td>
<td   colspan="6" align="center" bgcolor="#FF0000"><div class="button">

<input name="add" type="submit" id="add" value="ADD" class="update" tabindex="5"/>

</div></td></tr>

<tr>

<td rowspan="2" align="center" bgcolor="#0073AA"><span class="style2">Product Name </span></td>

  <td width="6%" colspan="3" align="center" bgcolor="#0073AA"><span class="style2">Size</span></td>
<td width="6%" rowspan="2" align="center" bgcolor="#0073AA"><span class="style2">GSM</span></td>
<td width="8%" colspan="8" align="center" bgcolor="#0073AA"><span class="style2">Colour</span></td>

<td width="8%" rowspan="2" align="center" bgcolor="#0073AA"><span class="style2">Print Name </span></td>
<td width="5%" rowspan="2" align="center" bgcolor="#0073AA"><span class="style2">U-Price</span></td>
<td width="5%" rowspan="2" align="center" bgcolor="#0073AA"><span class="style2">Quantity</span></td>
<td width="5%" rowspan="2" align="center" bgcolor="#0073AA"><span class="style2">Amount</span></td>
</tr>
<tr>
  <td align="center" bgcolor="#0073AA"><span class="style2">Width</span></td>
  <td align="center" bgcolor="#0073AA"><span class="style2">Heidth</span></td>
  <td align="center" bgcolor="#0073AA"><span class="style2">Gadget</span></td>
  <td width="4%" align="center" bgcolor="#0073AA"><span class="style2">Body</span></td>
  <td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Handle</span></td>
  <td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Gadget</span></td>
  <td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Pipene</span></td>
  <td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Print-1</span></td>
  <td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Print-2</span></td>
  <td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Print-3</span></td>
  <td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Print-4</span></td>
</tr>

<tr bgcolor="#CCCCCC">


<td align="center"><span class="style2">




<span id="sub">
<?


auto_complete_from_db('item_info','concat(item_id,"- ",item_name)','concat(item_id,"- ",item_name)','group_for = "'.$group_for.'" and product_nature="Salable"','itemin');

//auto_complete_from_db('item_info i, raw_input_data r','concat(r.reference_no," # ",i.item_name)','concat(r.reference_no," # ",i.item_name)',
//' r.dealer_code = "'.$dealer_code.'" and r.buyer_code = "'.$buyer_code.'" and r.merchandizer_code = "'.$buyer_code.'" and i.item_id=r.item_id','itemin');



$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and do_no=".$do_no." order by id desc limit 1";
$do_data = find_all_field_sql($do_details);



?>


<input type="text" id="itemin" name="itemin"  style="width:150px; height:30px;" value="<?= $do_data->item_id?>- <?= $do_data->item_name?>"  required onblur="grp_check(this.value)" />
<input type="hidden" id="item" name="item"  />
<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />
<input type="hidden" id="do_date" name="do_date" value="<?=$do_date?>"  />
<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
<input type="hidden" id="depot_id" name="depot_id" value="<?=$depot_id?>"  />
<input type="hidden" id="dealer_code" name="dealer_code" value="<?=$dealer_code?>"  />

<input type="hidden" id="job_no" name="job_no" value="<?=$job_no?>"  />
</span>




 </span></td>

  <td width="2%" align="center" ><span class="style2">
<input name="s_w" type="text" class="input3" id="s_w"   maxlength="100" style="width:50px;height:30px; font-size:18px;" required="required"  onBlur="count()"/>
</span></td>
<td width="1%" align="center" >
<input name="s_h" type="text" class="input3" id="s_h"   maxlength="100" style="width:50px;height:30px; font-size:18px;"   onBlur="count()"/></td>
<td width="3%" align="center" >
<input name="s_g" type="text" class="input3" id="s_g"   maxlength="100" style="width:50px;height:30px; font-size:18px;"   onBlur="count()"/></td>
<td width="6%" align="center"><span class="style2">
  <select name="gsm" id="gsm" required style="width:60px;">
    <option></option>
    <? foreign_relation('gsm','gsm','gsm',$_POST['gsm'],'1 order by id');?>
  </select>
  
  <span id="do">
  
  </span>
</span></td>
<td width="0%" align="center" >


<select name="colour_b" id="colour_b"  style="width:80px;">
<option></option>
	
		<? foreign_relation('colour','id','colour',$_POST['colour_b'],'1 order by colour');?>
	</select></td>
<td width="0%" align="center" >
<select name="colour_h" id="colour_h"  style="width:80px;">
	<option></option>
		<? foreign_relation('colour','id','colour',$_POST['colour_h'],'1 order by colour');?>
	</select></td>
<td width="0%" align="center" ><select name="colour_g" id="colour_g"  style="width:80px;">
<option></option>
	
		<? foreign_relation('colour','id','colour',$_POST['colour_g'],'1 order by colour');?>
	</select></td>
<td width="0%" align="center" >
<select name="colour_pp" id="colour_pp"  style="width:80px;">
<option></option>
	
		<? foreign_relation('colour','id','colour',$_POST['colour_pp'],'1 order by colour');?>
	</select></td>
<td width="0%" align="center" >
<select name="colour_pra" id="colour_pra"  style="width:80px;">
<option></option>
	
		<? foreign_relation('colour','id','colour',$_POST['colour_pra'],'1 order by colour');?>
	</select></td>
<td width="0%" align="center" >
<select name="colour_prb" id="colour_prb"  style="width:80px;">
<option></option>
	
		<? foreign_relation('colour','id','colour',$_POST['colour_prb'],'1 order by colour');?>
	</select></td>
<td width="0%" align="center" >
<select name="colour_prc" id="colour_prc"  style="width:80px;">
<option></option>
	
		<? foreign_relation('colour','id','colour',$_POST['colour_prc'],'1 order by colour');?>
	</select></td>
<td width="8%" align="center" >
<select name="colour_prd" id="colour_prd"  style="width:80px;">
<option></option>
	
		<? foreign_relation('colour','id','colour',$_POST['colour_prd'],'1 order by colour');?>
	</select></td>
<td width="8%" align="center"><span class="style2">

<select  name="print_name" id="print_name"  style="width:120px; height:30px;"  >
    <option></option>
    <? foreign_relation('dealer_print_name','id','print_name',$print_name,'dealer_code="'.$dealer_code.'"  order by print_name');?>
  </select>

 </span></td>
<td width="5%" align="center"><input name="unit_price" type="text" class="input3" id="unit_price"  style="width:60px; height:30px;" required  value="<?=$do_data->unit_price;?>"  autocomplete="off"  onkeyup="TRcalculation()" /></td>
<td width="5%" align="center">

<span class="style2">

<input  name="total_unit" type="text" class="input3" id="total_unit" onkeyup="TRcalculation()" value="<?=$do_data->total_unit;?>" style="width:60px; height:30px;"   />
 </span></td>
<td width="5%" align="center">
<span class="style2">  
<input placeholder="Total Amt" name="total_amt" type="text" class="input3" required utocomplete="off"  value="<?=$do_data->total_amt;?>" id="total_amt" style="width:100px; height:30px;" />
</span></td>
</tr>
</table>














<? if($$unique_master>0){?>

<br /><br /><br /><br />

<? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, a.*
   from sale_do_details a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.do_no='.$$unique_master.' order by a.id desc';

?>

<div  class="tabledesign2">

<table width="103%" border="0" cellspacing="0" cellpadding="0">

<tr>

<th width="1%" rowspan="2">SL</th>

<th width="14%" rowspan="2">Item Name</th>
<th width="16%" rowspan="2">Size</th>
<th width="2%" rowspan="2">GSM</th>
<th width="24%" colspan="8"><div align="center">Colour</div></th>
<th width="5%" rowspan="2">Print Name </th>
<th width="5%" rowspan="2">U-Price</th>
<th width="4%" rowspan="2">Quantity</th>
<th width="4%" rowspan="2">Amount</th>
<th width="1%" rowspan="2">X</th>
</tr>
<tr>
  <th>Body</th>
  <th>Handle</th>
  <th>Gadget</th>
  <th>Pipene</th>
  <th>Print-1</th>
  <th>Print-2</th>
  <th>Print-3</th>
  <th>Print-4</th>
</tr>


<?

$i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){ ?>

<tr>

<td><?=$i++?></td>

<td><?=$data->item_name?></td>
<td><? if($data->s_w>0) {?><?=$data->s_w?><? }?><? if($data->s_h>0) {?>X<?=$data->s_h?><? }?><? if($data->s_g>0) {?>X<?=$data->s_g?><? }?></td>

<td><?=$data->gsm?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_b.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_h.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_g.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_pp.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_pra.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_prb.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_prc.'"');?></td>
<td><?=find_a_field('colour','colour','id="'.$data->colour_prd.'"');?></td>
<td><?=find_a_field('dealer_print_name','print_name','id="'.$data->print_name.'"');?></td>
<td><?=$data->unit_price?></td>
<td><?=$data->total_unit?></td>
<td><?=$data->total_amt?></td>
<td><a href="?del=<?=$data->id?>">X</a></td>
</tr>

<? 

$total_quantity = $total_quantity + $data->total_unit;

$total_amount = $total_amount + $data->total_amt;


} ?>

<tr>

<td colspan="4"><div align="right"><strong> Grand Total:</strong></div></td>

<td colspan="8">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong><?=number_format($total_quantity,2);?></strong></td>
<td><strong><?=number_format($total_amount,2);?></strong></td>
<td>&nbsp;</td>
</tr>





<? }?>
</table>

</div>

</form>

<br />


<form action="select_dealer_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="100%" border="0">
<?php /*?>
<?php if($order_create=='Yes') {?>

<? } ?><?php */?>

<tr>

<td align="center">

<input name="delete"  type="submit" class="btn1" value="DELETE WO" style="width:100px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
<input  name="do_date" type="hidden" id="do_date" value="<?=$do_date?>"/></td><td align="right" style="text-align:right">

<input name="confirm" type="submit" class="btn1" value="CONFIRM THIS WO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />

</td>

</tr>




</table>

<? }?>

</form>

</div>

<!--<script>$("#cz").validate();$("#cloud").validate();</script>-->

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";




?>