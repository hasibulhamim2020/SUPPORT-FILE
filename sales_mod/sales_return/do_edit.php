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

$page = 'do_edit.php';

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







function comm_cal() {

var init_total_amt=(document.getElementById('init_total_amt').value*1);

var comm_amount=(document.getElementById('commission2').value*1);

var ctn=(document.getElementById('init_pkt_unit').value*1);

document.getElementById('commission').value=(ctn*comm_amount);

var tot_comm=(document.getElementById('commission').value*1);

document.getElementById('net_amount').value=(init_total_amt-tot_comm);

}

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




function TRcalculation(id){

var measurement_unit = document.getElementById('measurement_unit#'+id).value;

var L = document.getElementById('L_cm#'+id).value*1;
var W = document.getElementById('W_cm#'+id).value*1;
var H = document.getElementById('H_cm#'+id).value*1;
var WL = document.getElementById('WL#'+id).value*1;
var WW = document.getElementById('WW#'+id).value*1;

var ply = document.getElementById('ply#'+id).value*1;

var fr = document.getElementById('fr#'+id).value*1;
var sqm_rate = document.getElementById('sqm_rate#'+id).value*1;
var additional_charge = document.getElementById('additional_charge#'+id).value*1;

//alert(id);

var info = L+"<@>"+W+"<@>"+H+"<@>"+WL+"<@>"+WW+"<@>"+fr+"<@>"+sqm_rate+"<@>"+measurement_unit;
getData2('edit_formula_ajax.php','ppp'+id,id,info);

var sqm = document.getElementById('sqm#'+id).value*1;
var final_price = (document.getElementById('final_price#'+id).value)= (sqm_rate*sqm)+additional_charge;
var unit_price = (document.getElementById('unit_price#'+id).value)=final_price;
var total_unit = document.getElementById('total_unit#'+id).value*1;
var total_amt = document.getElementById('total_amt#'+id).value= (unit_price*total_unit);



}



function TRcalculation_2(id){

var final_price = document.getElementById('final_price#'+id).value*1;
var unit_price = document.getElementById('unit_price#'+id).value*1;
var total_unit = document.getElementById('total_unit#'+id).value*1;
var total_amt = document.getElementById('total_amt#'+id).value= (unit_price*total_unit);



// if(unit_price<final_price)
//  {
//alert('You can`t reduce the price');
//document.getElementById('unit_price#'+id).value='';
//  } 

}






function update_edit(id)
{
var L = (document.getElementById('L_cm#'+id).value);
var W = (document.getElementById('W_cm#'+id).value);
var H = (document.getElementById('H_cm#'+id).value);
var WL = (document.getElementById('WL#'+id).value);
var WW = (document.getElementById('WW#'+id).value);
var ply = (document.getElementById('ply#'+id).value);
var fr = (document.getElementById('fr#'+id).value);
var sqm_rate = (document.getElementById('sqm_rate#'+id).value);
var additional_charge = (document.getElementById('additional_charge#'+id).value);
var sqm = (document.getElementById('sqm#'+id).value);
var final_price = (document.getElementById('final_price#'+id).value);
var unit_price = (document.getElementById('unit_price#'+id).value);
var total_unit = (document.getElementById('total_unit#'+id).value);
var total_amt = (document.getElementById('total_amt#'+id).value);


var style_no = (document.getElementById('style_no#'+id).value);
var po_no = (document.getElementById('po_no#'+id).value);
var destination = (document.getElementById('destination#'+id).value);
var referance = (document.getElementById('referance#'+id).value);
var sku_no = (document.getElementById('sku_no#'+id).value);
var pack_type = (document.getElementById('pack_type#'+id).value);
var color = (document.getElementById('color#'+id).value);
var size = (document.getElementById('size#'+id).value);
var delivery_date = (document.getElementById('delivery_date#'+id).value);



var printing_info = (document.getElementById('printing_info#'+id).value);
var delivery_place = (document.getElementById('delivery_place#'+id).value);



var info = L+"<@>"+W+"<@>"+H+"<@>"+WL+"<@>"+WW+"<@>"+ply+"<@>"+fr+"<@>"+sqm_rate+"<@>"+additional_charge+"<@>"+sqm+"<@>"+final_price+"<@>"+unit_price+"<@>"+total_unit
+"<@>"+total_amt
+"<@>"+style_no+"<@>"+po_no+"<@>"+destination+"<@>"+referance+"<@>"+sku_no+"<@>"+pack_type+"<@>"+color+"<@>"+size+"<@>"+delivery_date+"<@>"+printing_info+"<@>"+delivery_place;
getData2('do_edit_request_edit_ajax.php', 'trrr'+id,id,info);
}








</script>

<script language="javascript">



function count_formula(){


var measurement_unit=document.getElementById('measurement_unit').value;

var L=(document.getElementById('L_cm').value)*1;
var W=(document.getElementById('W_cm').value)*1; 
var H=(document.getElementById('H_cm').value)*1;
var WL=(document.getElementById('WL').value)*1; 
var WW=(document.getElementById('WW').value)*1;

var fr=(document.getElementById('formula_id').value)*1;
var sqm_rate=(document.getElementById('sqm_rate').value)*1;
var additional_charge=(document.getElementById('additional_charge').value)*1;
//alert(measurement_unit);


var info = L+"<@>"+W+"<@>"+H+"<@>"+WL+"<@>"+WW+"<@>"+fr+"<@>"+sqm_rate+"<@>"+measurement_unit;
getData2('formula_ajax.php', 'ppp',1,info);

var sqm=(document.getElementById('sqm').value)*1;

var nom_digit=(document.getElementById('number_format').value)*1;

var unit_price=(document.getElementById('unit_price').value)=Number((sqm_rate*sqm)+additional_charge).toFixed(nom_digit);
var final_price=(document.getElementById('final_price').value)=unit_price;
var total_unit=(document.getElementById('total_unit').value)*1; 
document.getElementById('total_amt').value=(unit_price*total_unit);

//alert(sqm_rate);

//alert(sqm);

}



function negotiate_price(){

var final_price = document.getElementById('final_price').value*1;
var unit_price = document.getElementById('unit_price').value*1;
var total_unit = document.getElementById('total_unit').value*1;
var total_amt = document.getElementById('total_amt').value= (unit_price*total_unit);


 if(unit_price<final_price)
  {
alert('You can`t reduce the price');
document.getElementById('unit_price').value='';
  } 


}






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


<input list="dealer_name_e" name="customer_name" id="customer_name"  style="width:250px;"  onchange="getData2('buyer_ajax.php', 'buyer_filter', this.value, 
document.getElementById('customer_name').value);"  autocomplete="off" required>
  <datalist id="dealer_name_e">
   
     <? foreign_relation('dealer_info','CONCAT(dealer_code, "->", dealer_name_e)','dealer_name_e',$dealer_code,'status="Active"');?>
  </datalist>

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








<? if($buyer_code<1) {?>

<span id="buyer_filter">
<div>

<label style="width:220px;">Buyer: </label>


		 
		 
		 
		 <input list="buyer_name" name="buyer" id="buyer"  style="width:250px;"  onchange="getData2('merchandizer_ajax.php', 'merchandizer_filter', this.value, 
document.getElementById('buyer').value);"  autocomplete="off" required>
  <datalist id="buyer_name">
	 
	 <? foreign_relation('buyer_info','CONCAT(buyer_code, "->", buyer_name)','buyer_name',$buyer,'dealer_code="'.$dealer_code.'" order by buyer_name');?>

  </datalist>


		

</div>


 </span>

<? }?>

<? if($buyer_code>0) {?>
<div>

<label style="width:220px;">Buyer: </label>

		 <input name="group_for2" type="text" id="group_for2" required readonly="" style="width:250px;" 
		 value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer_code);?>" tabindex="105" />

 
		 <input name="buyer_code" type="hidden" id="buyer_code" required readonly="" style="width:250px;" value="<?=$buyer_code?>" tabindex="105" />

</div>
<? }?>





<? if($merchandizer_code<1) {?>
<div>

<label style="width:220px;">Merchandiser: </label>

<span id="merchandizer_filter">
<input list="merchandizer_name" name="merchandizer" id="merchandizer"  style="width:250px;"    autocomplete="off" required>
  <datalist id="merchandizer_name">

	  <? foreign_relation('merchandizer_info','CONCAT(merchandizer_code, "->", merchandizer_name)','merchandizer_name',$merchandizer,'buyer_code="'.$buyer_code.'" order by merchandizer_name');?>
	  
  </datalist>
		 </span>
		 
		<span id="merchandizer_code_filter">
		
		
		
		</span> 

</div>

<? }?>

<? if($merchandizer_code>0) {?>
<div>

<label style="width:220px;">Merchandiser: </label>

		 <input name="group_for2" type="text" id="group_for2" required readonly="" style="width:250px;" 
		 value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer_code);?>" tabindex="105" />

 
		 <input name="merchandizer_code" type="hidden" id="merchandizer_code" required readonly="" style="width:250px;" value="<?=$merchandizer_code?>" tabindex="105" />

</div>
<? }?>






<?php /*?>
<? if($marketing_team<1) {?>
<div>

<label style="width:220px;">Marketing Team: </label>

<select  name="marketing_team" id="marketing_team"  style="width:250px;" required onchange="getData2('marketing_team_ajax.php', 'marketing_team_filter', this.value, 

document.getElementById('marketing_team').value);">

<option></option>

	
      <? foreign_relation('marketing_team','team_code','team_name',$marketing_team,'1');?>
		 </select>

</div>

<? }?>

<?php */?>



<? if($marketing_team>0) {?>
<div>

<label style="width:220px;">Marketing Team: </label>

		 <input name="group_for2" type="text" id="group_for2" required readonly="" style="width:250px;" 
		 value="<?=find_a_field('marketing_team','team_name','team_code='.$marketing_team);?>" tabindex="105" />

 
		 <input name="marketing_team" type="hidden" id="marketing_team" required readonly="" style="width:250px;" value="<?=$marketing_team?>" tabindex="105" />

</div>
<? }?>









<?php /*?><? if($marketing_person<1) {?>
<div>

<label style="width:220px;">Marketing Person: </label>

<span id="marketing_team_filter">

<select  name="marketing_person" id="marketing_person"  style="width:250px;" required>

<option></option>

	
      <? foreign_relation('marketing_person','person_code','marketing_person_name',$marketing_person,'1');?>
		 </select>
		 
		 </span>

</div>

<? }?><?php */?>



<? if($marketing_person>0) {?>
<div>

<label style="width:220px;">Marketing Person: </label>

		 <input name="group_for2" type="text" id="group_for2" required readonly="" style="width:250px;" 
		 value="<?=find_a_field('marketing_person','marketing_person_name','person_code='.$marketing_person);?>" tabindex="105" />

 
		 <input name="marketing_person" type="hidden" id="marketing_person" required readonly="" style="width:250px;" value="<?=$marketing_person?>" tabindex="105" />

</div>
<? }?>



<div>

<label style="width:220px;">Remarks: </label>

<input name="remarks" type="text" id="remarks" style="width:250px;" value="<?=$remarks?>" tabindex="105"   autocomplete="off"  />
<input name="depot_id" type="hidden" id="depot_id" style="width:250px;" value="<?=$_SESSION['user']['depot']?>" tabindex="105" />

</div>













</div>




</fieldset></td>

<td width="50%"><fieldset style="width:550px;">


<? if($do_date=="") {?>
<div>

<label style="width:140px;">Order Date: </label>

<input style="width:220px;"  name="do_date" type="text" id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>"  required
onchange="getData2('job_no_ajax.php', 'job_no', this.value,document.getElementById('do_no').value);"/>

</div>
<? }?>


<? if($do_date!="") {?>
<div>
<label style="width:140px;">Order Date: </label>
<input style="width:220px;"  name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"  required/>

<input style="width:220px;"  name="do_date2" type="text" id="do_date2" value="<?=$do_date;?>" readonly="" required/>
</div>
<? }?>


<? if($job_no=="") {?>
<div>
<label style="width:140px;">Job No: </label>
<span id="job_no">
<?
	 $YR=date('Y');
 	 $year=date('y');
	 $month=date('m');
	 $job_id = find_a_field('sale_do_master','max(job_id)','year="'.$YR.'"')+1;
	 $cy_id = sprintf("%06d", $job_id);
	 $job_no_generate='NPL'.$year.''.$month.''.$cy_id;
	 
	 
?>
<input name="job_no" type="text" id="job_no" style="width:220px;" value="<?=$job_no_generate?>" readonly="" tabindex="105" />
<input name="job_id" type="hidden" id="job_id" style="width:220px;" value="<?=$job_id?>" readonly="" tabindex="105" />
<input name="year" type="hidden" id="year" style="width:220px;" value="<?=$YR?>" readonly="" tabindex="105" />
</span>

</div>

<? }?>


<? if($job_no!="") {?>
<div>
<label style="width:140px;">Job No: </label>
<input name="job_no" type="text" id="job_no" style="width:220px;" value="<?=$job_no?>" readonly="" tabindex="105" />
<input name="job_id" type="hidden" id="job_id" style="width:220px;" value="<?=$job_id?>" readonly="" tabindex="105" />
<input name="year" type="hidden" id="year" style="width:220px;" value="<?=$year?>" readonly="" tabindex="105" />
</div>

<? }?>








<div>

<label style="width:140px;">Customer's PO: </label>

 
		 <input name="customer_po_no" type="text" id="customer_po_no" required style="width:220px;" value="<?=$customer_po_no?>"   autocomplete="off"   tabindex="105" />

</div>


<div>

<label style="width:140px;">PO Date: </label>

 
		 <input name="customer_po_date" type="text" id="customer_po_date" required style="width:220px;" value="<?=$customer_po_date?>"  autocomplete="off"   tabindex="105" />

</div>






<? if($order_throw<1) {?>
<div>

<label style="width:140px;">Order Throw: </label>

<select  name="order_throw" id="order_throw"  style="width:220px;" required>

      <? foreign_relation('order_throw','id','order_throw',$order_throw,'1');?>
		 </select>

</div>

<? }?>

<? if($order_throw>0) {?>
<div>

<label style="width:140px;">Order Throw: </label>

		 <input name="debit_head2" type="text" id="debit_head2" required readonly="" style="width:220px;" 
		 value="<?=find_a_field('order_throw','order_throw','id='.$order_throw);?>" tabindex="105" />

 
		 <input name="order_throw" type="hidden" id="order_throw" required readonly="" style="width:220px;" value="<?=$order_throw?>" tabindex="105" />

</div>
<? }?>





<? if($order_type<1) {?>
<div>

<label style="width:140px;">Order Type: </label>

<select  name="order_type" id="order_type"  style="width:220px;" required>

      <? foreign_relation('order_type','id','order_type',$order_type,'1');?>
		 </select>

</div>

<? }?>

<? if($order_type>0) {?>
<div>

<label style="width:140px;">Order Type: </label>

		 <input name="debit_head2" type="text" id="debit_head2" required readonly="" style="width:220px;" 
		 value="<?=find_a_field('order_type','order_type','id='.$order_type);?>" tabindex="105" />

 
		 <input name="order_type" type="hidden" id="order_type" required readonly="" style="width:220px;" value="<?=$order_type?>" tabindex="105" />

</div>
<? }?>


<div>

<label style="width:140px;">FSC Type: </label>

<select  name="fsc_claim" id="fsc_claim"  style="width:220px;" required>


      <? foreign_relation('fsc_claim_type','id','fsc_claim',$fsc_claim,'1 order by fsc_claim desc');?>
		 </select>

</div>


<div>

<label style="width:140px;">FSC Logo: </label>

		 
	
	
	<select  name="fsc_logo" id="fsc_logo"  style="width:220px;" required>


      <? foreign_relation('yes_no','yes_no','yes_no',$fsc_logo,'1 order by id desc');?>
		 </select>

</div>






</fieldset></td>

</tr>

<td colspan="3">



	



		<div class="buttonrow" style="margin-left:320px;">



		<? if($$unique_master>0) {?>



		<input name="new" type="submit" class="btn1" value="Update Work Order" style="width:250px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="1" />
		
		<a target="_blank" href="work_order_draft_print_view.php?v_no=<?=$$unique_master?>"><img src="../../../images/print.png" alt="" width="30" height="30" /></a>
		
		
		



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







<tr ><td colspan="9">&nbsp;       </td>
<td   colspan="6" align="center" bgcolor="#FF0000"><div class="button">

<input name="add" type="submit" id="add" value="ADD" class="update" tabindex="5"/>

</div></td></tr>
<tr>
  <td colspan="13" align="center" bgcolor="#0073AA"><span class="style2">Technical Information</span></td>
  </tr>
<tr>

<td align="center" bgcolor="#0073AA"><span class="style2">Product Name </span></td>


  <td width="12%" align="center" bgcolor="#0073AA"><span class="style2">Style No </span><span class="style2"></span></td>
  <td width="4%" align="center" bgcolor="#0073AA"><span class="style2">PO No </span></td>




<td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Destination</span></td>

<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">Referance</span></td>
<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">SKU No </span><span class="style2"></span></td>
<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">Pack Type </span></td>
<td width="7%" align="center" bgcolor="#0073AA"><span class="style2">Color</span></td>
<td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Size</span></td>

<td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Printing Info </span></td>
<td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Addi. Info </span></td>
<td width="5%" align="center" bgcolor="#0073AA"><span class="style2">Addi. Chrg </span></td>
<td width="5%" align="center" bgcolor="#0073AA"><span class="style2">Unit</span></td>
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


<input type="text" id="itemin" name="itemin"  style="width:200px; height:30px;" value="<?= $do_data->item_id?>- <?= $do_data->item_name?>"  required onblur="grp_check(this.value)" />
<input type="hidden" id="item" name="item"  />
<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />
<input type="hidden" id="do_date" name="do_date" value="<?=$do_date?>"  />
<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
<input type="hidden" id="depot_id" name="depot_id" value="<?=$depot_id?>"  />
<input type="hidden" id="dealer_code" name="dealer_code" value="<?=$dealer_code?>"  />
<input type="hidden" id="buyer_code" name="buyer_code" value="<?=$buyer_code?>"  />
<input type="hidden" id="merchandizer_code" name="merchandizer_code" value="<?=$merchandizer_code?>"  />
<input type="hidden" id="customer_po_no" name="customer_po_no" value="<?=$customer_po_no?>"  />
<input type="hidden" id="job_no" name="job_no" value="<?=$job_no?>"  />
</span>




 </span></td>


  <td width="12%" align="center" >
  <span class="style2">
  
  <?
  $digit = find_a_field('decimal_numbers','number_format','dealer_code="'.$dealer_code.'" and buyer_code="'.$buyer_code.'" and approval="Yes"');
  
  if ($digit>0) {
	 $nom_digit = $digit;
	}else {
	 $nom_digit = 4;
	}
  
  ?>
 
  <input   name="number_format" type="hidden" class="input3" id="number_format" style="width:60px; height:30px;"  onkeyup="count_formula()"  value="<?=$nom_digit;?>"  autocomplete="off"  />
  <input   name="style_no" type="text" class="input3" id="style_no" style="width:60px; height:30px;" value="<?=$do_data->style_no;?>"  autocomplete="off"   tabindex="0"/>
  </span>  </td>
  <td width="4%" align="center" ><span class="style2">
  
 
  
  <input   name="po_no" type="text" class="input3" id="po_no" style="width:50px; height:30px;" value="<?=$do_data->po_no;?>"  autocomplete="off"   tabindex="0"/>
  
  </span>   </td>




<td width="8%" align="center" ><span class="style2">

		 
		 
		 <input  type="text" name="destination" id="destination" class="input3" style="width:80px;  height:30px;"  value="<?=$do_data->destination;?>"  autocomplete="off"   tabindex="0">
		 
		 
  

</span></td>

<td width="6%" align="center" ><span class="style2">
<input name="referance" type="text" class="input3" id="referance" style="width:60px; height:30px;" value="<?=$do_data->referance;?>" autocomplete="off"   tabindex="0"/>
</span></td>
<td width="6%" align="center"><span class="style2">
<input name="sku_no" type="text" class="input3" id="sku_no" style="width:60px; height:30px;"  value="<?=$do_data->sku_no;?>" autocomplete="off"    tabindex="0"/>
</span></td>
<td width="6%" align="center"><span class="style2">
<input name="pack_type" type="text" class="input3" id="pack_type" style="width:60px; height:30px;" value="<?=$do_data->pack_type;?>"  autocomplete="off" />
</span></td>
<td width="7%" align="center"><span class="style2">
<input  name="color" type="text" class="input3" id="color" style="width:60px; height:30px;" value="<?=$do_data->color;?>"  autocomplete="off"   tabindex="0"/>
</span></td>
<td width="8%" align="center" ><span class="style2"> 


<input  name="size" type="text" class="input3" id="size" style="width:60px; height:30px;"    value="<?=$do_data->size;?>" autocomplete="off"  tabindex="0"/>

</span></td>
<td width="8%" align="center"><span class="style2">

		<select  name="printing_info" id="printing_info"  style="width:80px; height:30px;" required>
  
 		 <option></option>

     	 <? foreign_relation('printing_information','id','printing_information',$do_data->printing_info,'1');?>
		 </select>

 </span></td>
<td width="8%" align="center">
<span class="style2"> 

  
   <select  name="additional_info" id="additional_info"  style="width:120px; height:30px;" onchange="getData2('additional_charge_ajax.php', 'additional_filter', this.value, document.getElementById('additional_info').value);" >
    <option></option>
    <? foreign_relation('additional_information','id','additional_information',$do_data->additional_info,'dealer_code="'.$dealer_code.'" and buyer_code="'.$buyer_code.'" 
	and approval="Yes"  order by additional_information');?>
  </select>
  
  
  
</span>
</td>
<td width="5%" align="center">

<span class="style2">
<span id="additional_filter">

<input  name="additional_charge" type="text" class="input3" id="additional_charge" onkeyup="count_formula()" value="<?=$do_data->additional_charge;?>" style="width:60px; height:30px;"   readonly="" />
</span> </span></td>
<td width="5%" align="center">
<span class="style2">
<select  name="measurement_unit" id="measurement_unit"  style="width:60px; height:30px;" required>
  
      <? foreign_relation('measurement_unit','unit_name','unit_name',$do_data->measurement_unit,'1');?>
		 </select>
</span></td>
</tr>
</table>




<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">

<tr>
  <td width="4%" align="center" bgcolor="#0073AA"><span class="style2">L</span></td>


  <td width="4%" align="center" bgcolor="#0073AA"><span class="style2">W</span></td>
  <td width="8%" align="center" bgcolor="#0073AA"><span class="style2">H</span></td>
  <td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Ply</span></td>

<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">WL</span></td>
<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">WW</span></td>
<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">Sqm</span></td>
<td width="7%" align="center" bgcolor="#0073AA"><span class="style2"> Paper Combination </span></td>
<td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Sqm Rate </span></td>

<td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Quantity</span></td>
<td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Pcs Price </span></td>
<td width="8%" align="center" bgcolor="#0073AA"><span class="style2"> Negotiate Price  </span></td>
<td width="8%" align="center" bgcolor="#0073AA"><span class="style2">Value</span></td>
<td width="5%" align="center" bgcolor="#0073AA"><span class="style2">Delivery Place </span></td>
<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">Delivery Date </span><span class="style2"></span></td>
</tr>

<tr bgcolor="#CCCCCC">
  <td width="4%" align="center"><span class="style2">
<input   name="L_cm" type="text" class="input3" id="L_cm" style="width:35px; height:30px;"  value="<?=$do_data->L_cm;?>"  autocomplete="off"  required="required"  onkeyup="count_formula()"   tabindex="0"/>
</span></td>


  <td width="4%" align="center">
  <span class="style2">
<input  name="W_cm" type="text" class="input3" id="W_cm" style="width:35px; height:30px;"  value="<?=$do_data->W_cm;?>"  autocomplete="off"  required="required"  onkeyup="count_formula()" tabindex="0"/>
</span>  </td>
  <td width="8%" align="center">
  <span class="style2">
<input name="H_cm" type="text" class="input3" id="H_cm" style="width:35px; height:30px;"  value="<?=$do_data->H_cm;?>"  autocomplete="off"  required="required" onkeyup="count_formula()" tabindex="0"/>
</span>  </td>
  <td width="8%" align="center" ><span class="style2">
<select  name="ply" id="ply"  style="width:50px; height:30px;" required onkeyup="count_formula()"  onchange="getData2('paper_combination_ajax.php', 'paper_comb_filter', this.value, document.getElementById('do_no').value);">
  
  <option></option>

      <? foreign_relation('paper_ply','ply','paper_ply',$do_data->ply,'1');?>
		 </select>
</span></td>



<td colspan="2" align="center" >

<span class="style2">
<span id="do">
<table width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
<tr bgcolor="#CCCCCC">
	<td> <input name="WL" type="text" class="input3" id="WL" style="width:40px; height:30px;" value="<?=$do_data->WL;?>" required="required" onkeyup="count_formula()" tabindex="0"/></td>
	<td>  <input name="WW" type="text" class="input3" id="WW" style="width:40px; height:30px;" value="<?=$do_data->WW;?>" required="required" onkeyup="count_formula()" tabindex="0"/>
	
	
	<input  name="item_id" type="hidden" class="input3" id="item_id" style="width:60px; height:30px;" value="<?=$do_data->item_id?>" required="required"  tabindex="0"/>
<input  name="unit_name" type="hidden" class="input3" id="unit_name" style="width:60px; height:30px;" value="<?=$do_data->unit_name?>" required="required"  tabindex="0"/>
<input  name="formula_id" type="hidden" class="input3" id="formula_id" style="width:60px; height:30px;" value="<?=$do_data->formula_id?>" onchange="count_formula()" required="required"  tabindex="0"/>
<input  name="formula_cal" type="hidden" class="input3" id="formula_cal" style="width:60px; height:30px;" value="<?=$do_data->formula_cal?>" required="required"  tabindex="0"/>
	
	
	
	</td>
</tr>
</table>
</span></span></td>

<td width="6%" align="center"><span class="style2">
<span id="ppp">
<input name="sqm" type="text" class="input3" id="sqm" style="width:60px; height:30px;"   value="<?=$do_data->sqm;?>" onkeyup="count_formula()" readonly/>
</span>
</span></td>
<td width="7%" align="center"><span class="style2">
 
		 <span id="paper_comb_filter">
		 
		 
		 <select  name="paper_combination_id" id="paper_combination_id"  style="width:200px; height:30px;" required="required" >
    <option></option>
    <? foreign_relation('paper_combination','id','paper_combination',$do_data->paper_combination_id,'dealer_code="'.$dealer_code.'" and buyer_code="'.$buyer_code.'"  order by paper_combination');?>
  </select>
		 
	
	</span>	 
</span></td>
<td width="8%" align="center" ><span class="style2"> 


<span id="sqm_filter">

<input  name="paper_combination" type="hidden" class="input3" id="paper_combination" style="width:60px; height:30px;"  readonly=""  value="<?=$do_data->paper_combination;?>"  />


<input  name="sqm_rate" type="text" class="input3" id="sqm_rate" style="width:55px; height:30px;" readonly="" onkeyup="count_formula()" value="<?=$do_data->sqm_rate;?>"  required="required"  tabindex="0"/>
</span>

</span></td>
<td width="8%" align="center"><span class="style2">

<input placeholder="Quantity" name="total_unit" type="text" class="input3" id="total_unit" style="width:70px; height:30px;"  value="<?=$do_data->total_unit;?>" required="required"  onkeyup="count_formula()" />


 </span></td>
<td width="8%" align="center"><span class="style2">
  <input name="final_price" type="text"  readonly="" required class="input3" id="final_price" style="width:60px; height:30px;" value="<?=$do_data->final_price;?>" autocomplete="off"  onkeyup="count_formula()" />
</span></td>
<td width="8%" align="center">
<span class="style2">
<input name="unit_price" type="text" class="input3" id="unit_price"  style="width:60px; height:30px;" required  value="<?=$do_data->unit_price;?>"  autocomplete="off"  onchange="negotiate_price()" />
 </span></td>
<td width="8%" align="center">
<span class="style2">  
<input placeholder="Total Amt" name="total_amt" type="text" class="input3" required utocomplete="off"  value="<?=$do_data->total_amt;?>" id="total_amt" style="width:70px; height:30px;" />
</span></td>
<td width="5%" align="center">

<span class="style2">
<select  name="delivery_place" id="delivery_place"  style="width:90px; height:30px;" required="required">
    <option></option>
    <? foreign_relation('delivery_place_info','id','delivery_place',$do_data->delivery_place,'dealer_code="'.$dealer_code.'"');?>
  </select> </span></td>
<td width="6%" align="center">
<span class="style2">
 <input  name="delivery_date" type="text" class="input3" id="delivery_date" style="width:90px; height:30px;" utocomplete="off" value="<?=$do_data->delivery_date;?>" />
</span></td>
</tr>






</table>


















<? if($$unique_master>0){?>

<br />

<? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select a.id, a.item_id, s.sub_group_name,  b.item_name, a.dealer_code, a.edit_request,
   a.style_no,a.po_no,a.destination,a.referance,a.sku_no,a.pack_type,a.color,a.size,a.printing_info,a.measurement_unit, a.additional_info, a.edit_request,  a.ply, a.paper_combination, a.L_cm, a.W_cm, a.H_cm,
  a.WL, a.WW, a.measurement_unit, a.sqm, a.sqm_rate, a.formula_id, a.additional_charge, a.final_price, a.unit_price, a.total_unit, a.total_amt,a.delivery_date,a.delivery_place
  
   from sale_do_details a, item_info b, item_sub_group s where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.do_no='.$$unique_master.' order by a.id desc';

?>

<div  class="tabledesign2">

<table width="102%" border="0" cellspacing="0" cellpadding="0">

<tr>

<th width="1%" rowspan="2">SL</th>

<th width="14%" rowspan="2">Item_Name</th>
<th width="14%" rowspan="2">Style No</th>
<th width="14%" rowspan="2">PO No </th>
<th width="14%" rowspan="2">Destination</th>
<th width="14%" rowspan="2">Referance</th>
<th width="14%" rowspan="2">SKU No</th>
<th width="14%" rowspan="2">Pack Type </th>
<th width="14%" rowspan="2">Color</th>
<th width="14%" rowspan="2">Size</th>
<th width="14%" rowspan="2">Printing Info</th>
<th width="15%" rowspan="2">Additional Info</th>
<th width="15%" rowspan="2">Addit Charge</th>
<th width="15%" rowspan="2">Unit</th>
<th width="16%" colspan="7"><div align="center">Measurement</div></th>
<th width="24%" rowspan="2" align="center">Paper Combination</th>
<th width="5%" rowspan="2">Sqm Price </th>
<th width="5%" rowspan="2">Quantity</th>
<th width="5%" rowspan="2">Pcs Price </th>
<th width="5%" rowspan="2"> Negotiated Price </th>
<th width="2%" rowspan="2">Amount</th>
<th width="2%" rowspan="2">Delivery Place</th>
<th width="2%" rowspan="2">Delivery Date</th>
<th width="2%" rowspan="2">Edit  </th>
<th width="1%" rowspan="2">X</th>
</tr>
<tr>
  <th>L</th>
  <th>W</th>
  <th>H</th>
  <th>Ply</th>
  <th>WL</th>
  <th>WW</th>
  <th>Sqm</th>
</tr>


<?

$i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){ ?>

<tr>

<td><?=$i++?></td>

<td><?=$data->item_name?></td>
<td><input type="text" name="<?='style_no#'.$data->id?>" id="<?='style_no#'.$data->id?>" value="<?=$data->style_no?>"    style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='po_no#'.$data->id?>" id="<?='po_no#'.$data->id?>" value="<?=$data->po_no?>"   style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='destination#'.$data->id?>" id="<?='destination#'.$data->id?>" value="<?=$data->destination?>"  style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='referance#'.$data->id?>" id="<?='referance#'.$data->id?>" value="<?=$data->referance?>" style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='sku_no#'.$data->id?>" id="<?='sku_no#'.$data->id?>" value="<?=$data->sku_no?>"   style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='pack_type#'.$data->id?>" id="<?='pack_type#'.$data->id?>" value="<?=$data->pack_type?>"  style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='color#'.$data->id?>" id="<?='color#'.$data->id?>" value="<?=$data->color?>"   style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='size#'.$data->id?>" id="<?='size#'.$data->id?>" value="<?=$data->size?>"   style="width:60px; height:25px;"/></td>
<td>

<select name="<?='printing_info#'.$data->id?>" id="<?='printing_info#'.$data->id?>" style="width:80px;"  >
		  
		  
	  <? foreign_relation('printing_information','id','printing_information',$data->printing_info,'1');?>
	  </select></td>
<td><?=find_a_field('additional_information','additional_information','id='.$data->additional_info);?></td>
<td><input type="text" name="<?='additional_charge#'.$data->id?>" id="<?='additional_charge#'.$data->id?>" value="<?=$data->additional_charge?>" onkeyup="TRcalculation(<?=$data->id?>)"   style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='measurement_unit#'.$data->id?>" id="<?='measurement_unit#'.$data->id?>" value="<?=$data->measurement_unit?>" readonly=""  style="width:40px; height:25px;"/></td>
<td><input type="text" name="<?='L_cm#'.$data->id?>" id="<?='L_cm#'.$data->id?>" value="<?=$data->L_cm?>" onkeyup="TRcalculation(<?=$data->id?>)"  style="width:30px; height:25px;"/></td>
<td><input type="text" name="<?='W_cm#'.$data->id?>" id="<?='W_cm#'.$data->id?>" value="<?=$data->W_cm?>"  onkeyup="TRcalculation(<?=$data->id?>)" style="width:30px; height:25px;"/></td>
<td><input type="text" name="<?='H_cm#'.$data->id?>" id="<?='H_cm#'.$data->id?>" value="<?=$data->H_cm?>"  onkeyup="TRcalculation(<?=$data->id?>)"  style="width:30px; height:25px;"/></td>
<td><input type="text" name="<?='ply#'.$data->id?>" id="<?='ply#'.$data->id?>" value="<?=$data->ply?>" onkeyup="TRcalculation(<?=$data->id?>)"  readonly="" style="width:30px; height:25px;"/></td>
<td><input type="text" name="<?='WL#'.$data->id?>" id="<?='WL#'.$data->id?>" value="<?=$data->WL?>"  onkeyup="TRcalculation(<?=$data->id?>)" style="width:30px; height:25px;"/></td>
<td><input type="text" name="<?='WW#'.$data->id?>" id="<?='WW#'.$data->id?>" value="<?=$data->WW?>" onkeyup="TRcalculation(<?=$data->id?>)"  style="width:30px; height:25px;"/></td>
<td><span id="ppp<?=$data->id?>"><input type="text" name="<?='sqm#'.$data->id?>" id="<?='sqm#'.$data->id?>" value="<?=$data->sqm?>" onkeyup="TRcalculation(<?=$data->id?>)"  style="width:60px; height:25px;"/></span>
<input type="hidden" name="<?='fr#'.$data->id?>" id="<?='fr#'.$data->id?>" value="<?=$data->formula_id?>" onkeyup="TRcalculation(<?=$data->id?>)"  style="width:60px; height:25px;"/></td>
<td><?=$data->paper_combination?></td>
<td><input type="text" name="<?='sqm_rate#'.$data->id?>" id="<?='sqm_rate#'.$data->id?>" value="<?=$data->sqm_rate?>" onkeyup="TRcalculation(<?=$data->id?>)"   style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='total_unit#'.$data->id?>" id="<?='total_unit#'.$data->id?>" value="<?=$data->total_unit?>" onkeyup="TRcalculation(<?=$data->id?>)"  style="width:60px; height:25px;"/></td>
<td><input type="text" name="<?='final_price#'.$data->id?>" id="<?='final_price#'.$data->id?>" value="<?=$data->final_price?>" onkeyup="TRcalculation(<?=$data->id?>)"  style="width:70px; height:25px;"/>  </td>
<td><input type="text" name="<?='unit_price#'.$data->id?>" id="<?='unit_price#'.$data->id?>" value="<?=$data->unit_price?>"
 onchange="TRcalculation_2(<?=$data->id?>)"  style="width:70px; height:25px;"/></td>
<td>
<input type="text" name="<?='total_amt#'.$data->id?>" id="<?='total_amt#'.$data->id?>" value="<?=$data->total_amt?>"   style="width:70px; height:25px;"/>

<input type="hidden" name="<?='edit_request#'.$data->id?>" id="<?='edit_request#'.$data->id?>" value="<?=$data->edit_request?>" readonly=""    style="width:80px; height:20px;"/></td>
<td>

<select name="<?='delivery_place#'.$data->id?>" id="<?='delivery_place#'.$data->id?>" style="width:80px;"  >
		  
		  
	  <? foreign_relation('delivery_place_info','id','delivery_place',$data->delivery_place,'dealer_code="'.$data->dealer_code.'"');?>
	  </select></td>
<td><input type="text" name="<?='delivery_date#'.$data->id?>" id="<?='delivery_date#'.$data->id?>" value="<?=$data->delivery_date?>"   style="width:100px; height:25px;"/></td>
<td align="center">
<span id="trrr<?=$data->id?>"><? if ($data->edit_request==2) {?><input name="<?='edit#'.$data->id?>" type="button" id="Edit" value="Edit" style="width:60px; height:30px; color:#000; font-weight:700" onclick="update_edit(<?=$data->id?>);start(this);"  /><? }?>
</span></td>
<td><a href="?del=<?=$data->id?>">X</a></td>
</tr>

<? 

$total_quantity = $total_quantity + $data->total_unit;

$total_amount = $total_amount + $data->total_amt;


} ?>

<tr>

<td colspan="21"><div align="right"><strong> Grand Total:</strong></div></td>

<td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong>
  <?=number_format($total_quantity,2);?>
</strong></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong><?=number_format($total_amount,2);?></strong></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
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

<input name="delete"  type="hidden" class="btn1" value="DELETE WO" style="width:100px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
<input  name="do_date" type="hidden" id="do_date" value="<?=$do_date?>"/></td><td align="right" style="text-align:right">

<input name="confirm" type="hidden" class="btn1" value="CONFIRM THIS WO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />

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