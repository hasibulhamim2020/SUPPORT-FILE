<?php

session_start();

ob_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sales Return Entry';

do_calander('#do_date');
do_calander('#delivery_date');

do_calander('#customer_po_date');

create_combobox('dealer_code_combo');

$now = date('Y-m-d H:s:i');

if($_GET['cbm_no']>0)
$cbm_no =$_SESSION['cbm_no'] = $_GET['cbm_no'];

$cdm_data = find_all_field('raw_input_sheet','','cbm_no='.$cbm_no);

do_calander('#est_date');

$page = 'do.php';

$table_master='sale_return_master';

$unique_master='do_no';

$table_detail='sale_return_details';

$unique_detail='id';


//$table_chalan='sale_do_chalan';
//
//$unique_chalan='id';


if($_REQUEST['old_do_no']>0)

$$unique_master=$_REQUEST['old_do_no'];

elseif(isset($_GET['del']))

{$$unique_master=find_a_field('sale_return_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}

else

$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){





if(isset($_POST['new']))



{

		
		
		
		
		if($_POST['dealer_code_combo']>0) {
		$_POST['dealer_code'] = $_POST['dealer_code_combo'];
		}
	
		$job_date = $_POST['do_date'];
		
		$YR = date('Y',strtotime($job_date));
  
  		$yer = date('y',strtotime($job_date));
  		$month = date('m',strtotime($job_date));

  		$job_cy_id = find_a_field('sale_return_master','max(job_id)','year="'.$YR.'"')+1;
		
   		$cy_id = sprintf("%06d", $job_cy_id);
	
   		$job_no_generate='SO'.$yer.''.$month.''.$cy_id;

		$_POST['job_no'] = $job_no_generate;
		$_POST['job_id'] = $job_cy_id;
		$_POST['year'] = $YR;

		

		$crud   = new crud($table_master);



		$_POST['entry_at']=date('Y-m-d H:i:s');



		$_POST['entry_by']=$_SESSION['user']['id'];
		
		//$merchandizer_exp=explode('->',$_POST['merchandizer']);
		
		//$_POST['merchandizer_code']=$merchandizer_exp[0];


		if($_POST['flag']<1){



		$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;



		$$unique_master=$crud->insert();



		



		$type=1;



		$msg='Sales Return Initialized. (Sales Return No-'.$$unique_master.')';



		}



		else {
		
		
		unset($_POST['job_no']);
		unset($_POST['job_id']);
		unset($_POST['year']);



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

 $_POST['remarks']=$_POST['remarks11'];
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

 $gunny_sql = "INSERT INTO `sale_return_details` 
(`do_no`,  `do_date`, dealer_code,  via_customer, `item_id`, depot_id,`unit_price`, `bag_unit`, dist_unit, total_unit, `total_amt`,   entry_by, entry_at, remarks) VALUES
('".$do_no."',  '".$_POST['do_date']."', '".$_POST['dealer_code']."',  '".$_POST['via_customer']."',  '".$item_gunny."', 
 '".$_POST['depot_id']."', '".$gunny_price."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."',
  '".$_REQUEST['total_amt']."', '".$_SESSION['user']['id']."', '".$now."', '".$_POST['remarks']."')";

db_query($gunny_sql);

			}
			
			
if($item_poly>0){
$poly_price=find_a_field('item_info','d_price',' item_id='.$item_poly);

$_REQUEST['total_amt'] = $poly_price*$_REQUEST['bag_unit'];

 $gunny_sql = "INSERT INTO `sale_return_details` 
(`do_no`,  `do_date`, dealer_code,  via_customer,  `item_id`, depot_id, `unit_price`, `bag_unit`, dist_unit, total_unit, `total_amt`,   entry_by, entry_at, remarks) VALUES
('".$do_no."',  '".$_POST['do_date']."', '".$_POST['dealer_code']."',  '".$_POST['via_customer']."',  '".$item_poly."',  
 '".$_POST['depot_id']."',  '".$poly_price."', '".$_REQUEST['bag_unit']."',  '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."', 
 '".$_REQUEST['total_amt']."',   '".$_SESSION['user']['id']."', '".$now."', '".$_POST['remarks']."')";

db_query($gunny_sql);



}
}

//if($_POST['group_for']==5){
//
//$gunny =find_all_field('item_info','',' item_id="900120001" ');
//
//$_REQUEST['init_total_amt'] = $gunny->d_price*$_REQUEST['init_bag_unit'];
//
//  $gunny_sql = "INSERT INTO `sale_return_details` 
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


 $sql1 = "delete from journal_item where tr_from = 'SalesReturn' and tr_no = '".$del."'";


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
function count()
{


if(document.getElementById('unit_price').value!=''){

var vat = ((document.getElementById('vat').value)*1);
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var unit_price = ((document.getElementById('unit_price').value)*1);
var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
var dist_unit = ((document.getElementById('dist_unit').value)*1);

var total_unit = (document.getElementById('total_unit').value)=(pkt_unit*pkt_size)+dist_unit;

var total_amt = (document.getElementById('total_amt').value) = unit_price*total_unit;

var discount = ((document.getElementById('discount').value)*1);

var amt_after_discount = (document.getElementById('amt_after_discount').value) = total_amt-discount;

var vat_amt = (document.getElementById('vat_amt').value) = (amt_after_discount*vat)/100;

//document.getElementById('total_unit').value=dist_unit;

var total_amt_with_vat = (document.getElementById('total_amt_with_vat').value) = amt_after_discount+vat_amt ;


document.getElementById('total_amt_with_vat').value  = total_amt_with_vat.toFixed(2);




}



}



</script>



<script language="javascript">




//function TRcalculation(){
//    
//var unit_name = document.getElementById('unit_name').value;
//var unit_price = document.getElementById('unit_price').value*1;
//var total_unit = document.getElementById('total_unit').value*1;
//var qty_kg = document.getElementById('qty_kg').value*1;
//
//
//if(unit_name=="Pcs"){
//var total_amt = document.getElementById('total_amt').value= (unit_price*total_unit);}
//
//else {
//    var total_amt = document.getElementById('total_amt').value= (unit_price*qty_kg);
//}
//
//
// if(unit_price<final_price)
//  {
//alert('You can`t reduce the price');
//document.getElementById('unit_price').value='';
//  } 
//  
//  
//}






</script>
<style type="text/css">



/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 250px;
    height: 37px;
    border-radius: 0px !important;
}




.onhover:focus{
background-color:#66CBEA;

}


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

<td>

<div>

<label style="width:220px;">Order No: </label>

<input style="width:250px;"  name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

<input name="group_for" type="hidden" id="group_for" required readonly="" style="width:250px;" value="<?=$_SESSION['user']['group']?>" tabindex="105" />
 <input name="vat" type="hidden" class="form-control" readonly="" id="vat"  value="15" tabindex="101" />
</div>

</td>



</tr>



<tr>

<td>




<div>
<label style="width:220px;">Order Date: </label>
<input style="width:250px;"  name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"  required/>

<input style="width:250px;"  name="do_date2" type="text" id="do_date2" value="<?=$do_date;?>" readonly="" required/>
</div>


</td>



</tr>

<tr>

<td>

<div>

<label style="width:220px;">warehouse: </label>

<select  id="depot_id" name="depot_id" class="form-control"  style="width:250px;" >
      
           
			  
			   <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
			  
          
            </select>
</div>

</td>



</tr>

<tr>

<td>
<div>

<label style="width:220px;">Customer: </label>
<? if ($dealer_code<1) {?>
<select  name="dealer_code_combo" id="dealer_code_combo"  style="width:250px;" required>

<option></option>

	
      <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code_combo,'depot="'.$_SESSION['user']['depot'].'"');?>
		 </select>
		 
<? }?>


<? if ($dealer_code>0) {?>
<select  id="dealer_code" name="dealer_code" class="form-control"  required style="width:250px;" >
	  
	 <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'dealer_code="'.$dealer_code.'"');?>

</select>

<? }?>

</div>
</td>



</tr>

<tr>

<td>

<div>

<label style="width:220px;">Return Type: </label>

<select name="sales_type" required id="sales_type"   style="width:250px;" class="form-control"  >

                      <? foreign_relation('sales_return_type','id','sales_return_type',$sales_type,'1');?>
                    </select>
</div>


</td>



</tr>

<tr>

<td>

<div>

<label style="width:220px;">Remarks: </label>

<input style="width:250px;"  name="remarks" type="text" id="remarks" value="<?=$remarks;?>" />
</div>


</td>



</tr>


<td>



	



		<!--<div class="buttonrow">



		<? if($$unique_master>0) {?>



		<input name="new" type="submit" class="btn1" value="Update Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="1" />



		<? }else{?>



		<input name="new" type="submit" class="btn1" value="Initiate Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="0" />



		<? }?>



		</div>-->



</td>



</table>


</form>

<? if($$unique_master>0) {?>

<form action="<?=$page?>" method="post" name="codz2" id="codz2">





<? if($$unique_master>0){?>

<br />

<? 

  $res='select s.*,i.item_name,i.unit_name from sale_return_details s left join item_info i on i.item_id=s.item_id where s.do_no="'.$$unique_master.'"';

?>

<div  class="tabledesign2">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

<tr>

<th width="2%">SL</th>
<th width="28%">Item Description</th>
<th width="7%">Unit</th>
<th width="7%">Qty</th>
<th width="7%">Rate</th>
<th width="7%">Amount</th>
<th width="7%">X</th>
</tr>


<?

$i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){ ?>

<tr>

<td><?=$i++?></td>

<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td><?=$data->total_unit?></td>
<td><?=$data->unit_price?></td>
<td><?=$data->total_amt?></td>
<td><a href="?del=<?=$data->id?>">X</a></td>

</tr>

<?
 $total_pcs +=$data->total_unit;
 $total_amt +=$data->total_amt;
 } ?>

<tr>

<td colspan="2"><div align="right"><strong>  Total:</strong></div></td>

<td>&nbsp;</td>
<td align="right"><?=number_format($total_pcs,2);?></td>
<td>&nbsp;</td>
<td align="right"><?=number_format($total_amt,2);?></td>
<td>&nbsp;</td>

</tr>







<? }?>
</table>

</div>

</form>

<br />


<form action="unapproved_return.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">
	   <input name="return"  type="submit" class="btn btn-warning" value="RETURN TO USER" onclick="return_function()" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" />
	   <input  name="do_no" type="hidden" id="do_no" value="<?=$do_no?>"/><input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>"/><input  name="do_date" type="hidden" id="do_date" value="<?=$do_date?>"/><input type="hidden" name="return_remarks" id="return_remarks">
      </td>
	  
	  <td align="center">
	   <input name="cancel"  type="submit" class="btn btn-danger" value="CANCEL" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" />
      </td>
	  <td><input type="button" class="btn btn-primary" value="CLOSE" style="width:240px; font-weight:bold; font-size:12px;color:white; height:30px" onclick="window.location.href='unapproved_return.php'" /></td>

      <td align="center">
	  <input name="confirm" type="submit" class="btn btn-info" value="CONFIRM SALES RETURN" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white;" />
	  </td>

    </tr>

  </table>

<? } ?>
</form>

</div>

<!--<script>$("#cz").validate();$("#cloud").validate();</script>-->
<script language="javascript">
function count()
{


if(document.getElementById('unit_price').value!=''){

var vat = ((document.getElementById('vat').value)*1);

var unit_price = ((document.getElementById('unit_price').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);

var total_unit = (document.getElementById('total_unit').value)=dist_unit;



var total_amt = (document.getElementById('total_amt').value) = total_unit*unit_price;


}



}



</script>

<script>
function return_function() {
  var notes = prompt("Why Return This DO?","");
  if (notes!=null) {
    document.getElementById("return_remarks").value =notes;
	document.getElementById("cz").submit();
  }
  return false;
}
</script>
<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";




?>