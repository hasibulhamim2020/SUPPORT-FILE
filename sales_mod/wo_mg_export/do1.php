<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Create Sales Order';

do_calander('#do_date');
do_calander('#delivery_date');

do_calander('#customer_po_date');

//create_combobox('dealer_code_combo');

$now = date('Y-m-d H:s:i');

if($_GET['cbm_no']>0)
$cbm_no =$_SESSION['cbm_no'] = $_GET['cbm_no'];

$cdm_data = find_all_field('raw_input_sheet','','cbm_no='.$cbm_no);

do_calander('#est_date');

$page = 'do1.php';

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





if(isset($_POST['new'])){
		
		if($_POST['dealer_code_combo']>0) {
		$_POST['dealer_code'] = $_POST['dealer_code_combo'];
		}
	
		$job_date = $_POST['do_date'];
		
		$YR = date('Y',strtotime($job_date));
  
  		$yer = date('y',strtotime($job_date));
  		$month = date('m',strtotime($job_date));

  		$job_cy_id = find_a_field('sale_do_master','max(job_id)','year="'.$YR.'"')+1;
		
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
		}else {
		
		unset($_POST['job_no']);
		unset($_POST['job_id']);
		unset($_POST['year']);

		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		}
}


if(isset($_POST['confirm'])){
	$table	= $table_detail;
	
	foreach($_POST['checkb'] as $id){
		//echo $_POST['qty_'.$id].' ,';
		
		
		$crud  = new crud($table);

		$_POST['item_id'] = $id;
		$_POST['pkt_size'] = $_POST['pkt_size_'.$id];
		$_POST['unit_name'] = $_POST['unit_name_'.$id];
		$_POST['dist_unit'] = $_POST['qty_'.$id];
		$_POST['total_unit'] = $_POST['dist_unit'];

		$dealer_type = find_a_field('dealer_info','dealer_type','dealer_code="'.$_POST['dealer_code'].'"');
 
		$dealer_price = find_a_field('sales_price_dealer','set_price','item_id="'.$item_id.'" and dealer_code="'.$_POST['dealer_code'].'"');
		$dealer_type_price = find_a_field('sales_price_dealer_type','set_price','item_id="'.$item_id.'" and dealer_type="'.$_POST['dealer_code'].'"');
		
		if($dealer_price>0){
			$item_sales_price = $dealer_price;
		}elseif($dealer_type_price>0){
			$item_sales_price = $dealer_type_price;
		}else{
			$item_sales_price=$_POST['d_price_'.$id];
		}

		$_POST['unit_price'] = $item_sales_price;
		$_POST['total_amt'] = $_POST['unit_price']*$_POST['total_unit'];

		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];

		$xid = $crud->insert();
	}

		$or_no = $_POST['do_no'];
		
		$do_master = find_all_field('sale_do_master','do_no','do_no='.$or_no);

		$sql2 = 'update sale_do_details set status="PROCESSING" where do_no = '.$or_no;
		db_query($sql2);
		
		$sql3 = 'update sale_do_master set status="PROCESSING" where do_no = '.$or_no;
		db_query($sql3);

		echo '<script>window.location.href="do1.php"</script>';
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

$crud  = new crud($table);

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

 $gunny_sql = "INSERT INTO `sale_do_details` 
(`do_no`,  `do_date`, dealer_code,  via_customer, `item_id`, depot_id,`unit_price`, `bag_unit`, dist_unit, total_unit, `total_amt`,   entry_by, entry_at, remarks) VALUES
('".$do_no."',  '".$_POST['do_date']."', '".$_POST['dealer_code']."',  '".$_POST['via_customer']."',  '".$item_gunny."', 
 '".$_POST['depot_id']."', '".$gunny_price."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."',
  '".$_REQUEST['total_amt']."', '".$_SESSION['user']['id']."', '".$now."', '".$_POST['remarks']."')";

db_query($gunny_sql);
}
			
			
if($item_poly>0){
$poly_price=find_a_field('item_info','d_price',' item_id='.$item_poly);

$_REQUEST['total_amt'] = $poly_price*$_REQUEST['bag_unit'];

 $gunny_sql = "INSERT INTO `sale_do_details` 
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


//Gift Offer
$do_date = $_POST['do_date'];
$dealer_type = find_a_field('dealer_info','dealer_type','dealer_code="'.$_POST['dealer_code'].'"');
$dealer_type_id = find_a_field('dealer_info','dealer_type','dealer_code="'.$_POST['dealer_code'].'"');
$dealer_type = find_a_field('dealer_type','dealer_type','id="'.$dealer_type_id.'"');
$sss = "select * from sale_gift_offer where item_id='".$_POST['item_id']."' and start_date<='".$do_date."' and end_date>='".$do_date."' and dealer_type='".$dealer_type."' ";

// and (region_id=0 or region_id='".$dealer->region_id."') and (zone_id=0 or zone_id='".$dealer->zone_id."') and (area_id=0 or area_id='".$dealer->area_id."')
		$qqq = db_query($sss);

		while($gift=mysqli_fetch_object($qqq)){
		
		if($gift->item_qty>0)
		{ 
	    $gift_item = find_all_field('item_info','','item_id="'.$gift->gift_id.'"');
		$_POST['item_id'] = $gift->gift_id;
        $_POST['gift_id']=$gift->id;
		$_POST['dp_price'] = $gift_item->d_price;
		$_POST['fp_price'] = $gift_item->f_price;
		
		
		$_POST['unit_price'] = '0.00';
		$_POST['total_amt'] = '0.00';
		$_POST['dist_unit']=$_POST['total_unit'] = (((int)($_POST['dist_unit']/$gift->item_qty))*($gift->gift_qty));

		//$_POST['dist_unit'] = ($_POST['total_unit']%$gift_item->pack_size);
		$_POST['pkt_unit'] = (int)($_POST['total_unit']/$gift_item->pack_size);
		$_POST['pkt_size'] = $gift_item->pack_size;
		$_POST['t_price'] = '0.00';
		if($_POST['dist_unit']>0){
		$crud->insert();
		}
		


}
}
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
function count()
{


if(document.getElementById('unit_price').value!=''){

//var vat = ((document.getElementById('vat').value)*1);

var unit_price = ((document.getElementById('unit_price').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);

var total_unit = (document.getElementById('total_unit').value)=dist_unit;



var total_amt = (document.getElementById('total_amt').value) = total_unit*unit_price;


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



.onhover:focus{
background-color:#66CBEA;

}


<!--
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
.se-th input[type=text]{
display:none;
}

#example1_filter{
	display:none !important;
}
.body_box{
height: inherit !important;
    overflow-x: hidden;
}
</style>






	<!--DO create 2 form with table-->
	<div class="form-container_large">
		<form action="<?=$page?>" method="post" name="codz2" id="codz2">
			<!--        top form start hear-->
			<div class="container-fluid bg-form-titel">
				<div class="row">
					<!--left form-->
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order No</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

									<input name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

									<input name="group_for" type="hidden" id="group_for" required readonly="" value="<?=$_SESSION['user']['group']?>" tabindex="105" />

								</div>
							</div>

							<? if($do_date=="") {?>
								<div class="form-group row m-0 pb-1">

									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order Date</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
										<input name="do_date" type="text" id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>"  required />
									</div>
								</div>
							<? }?>


							<? if($do_date!="") {?>
								<div class="form-group row m-0 pb-1">

									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order Date</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
										<input name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"  required/>

										<input name="do_date2" type="text" id="do_date2" value="<?=$do_date;?>" readonly="" required/>

									</div>
								</div>
							<? }?>




							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select  id="depot_id" name="depot_id" class="form-control">



										<? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'warehouse_id="'.$_SESSION['user']['depot'].'"');?>


									</select>


								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Remarks</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input  name="remarks" type="text" id="remarks" value="<?=$remarks;?>" />

								</div>
							</div>

						</div>


					</div>

					<!--Right form-->
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">

							<? if($job_no!="") {?>
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job No</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input name="job_no_duplicate" type="text" id="job_no_duplicate" value="<?=$job_no?>" readonly="" tabindex="105" />
									</div>
								</div>
							<? }?>


							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<? if ($dealer_code<1) {?>
										<select  name="dealer_code_combo" id="dealer_code_combo"  required>

											<option></option>


<? foreign_relation('dealer_info d,dealer_type t','d.dealer_code','concat(d.dealer_name_e,". #",t.dealer_type)',$dealer_code_combo,'d.dealer_type=t.id');?>
										</select>

									<? }?>


									<? if ($dealer_code>0) {?>
										<select  id="dealer_code" name="dealer_code" class="form-control"  required >

											<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'dealer_code="'.$dealer_code.'"');?>

										</select>

									<? }?>

								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">VAT (%)</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input  name="vat" type="text" id="vat" value="<?=$vat;?>"   />
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Discount (%)</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input  name="discount" type="text" id="discount" value="<?=$discount;?>"   />
								</div>
							</div>

						</div>



					</div>


				</div>

				<div class="n-form-btn-class">

					<? if($$unique_master>0) {?>
						<input name="new" type="submit" class="btn1 btn1-bg-update" value="Update Sales Order"  tabindex="12" />
						<input name="flag" id="flag" type="hidden" value="1" />
					<? }

					else{?>

						<input name="new" type="submit" class="btn1 btn1-bg-submit" value="Initiate Sales Order" tabindex="12" />
						<input name="flag" id="flag" type="hidden" value="0" />

					<? }?>

				</div>

			</div>

			<?
			$sql = 'select a.*,u.fname from approver_notes a, user_activity_management u where a.entry_by=u.user_id and master_id="'.$$unique_master.'" and type in ("DO","CHALAN")';
			$row_check = mysqli_num_rows(db_query($sql));
			if($row_check>0){
			?>
			<!--return Table design start-->
			<div class="container-fluid pt-2 p-0 ">
				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>Returned By</th>
						<th>Returned At</th>
						<th>Remarks</th>
					</tr>
					</thead>

					<tbody class="tbody1">
					<?

					$qry = db_query($sql);
					while($return_note=mysqli_fetch_object($qry)){
						?>
						<tr>
							<td><?=$return_note->fname?></td>
							<td><?=$return_note->entry_at?></td>
							<td><?=$return_note->note?></td>
						</tr>
					<? } ?>

					</tbody>
				</table>

			</div>

			<? } ?>
		</form>



		<? if($$unique_master>0) {?>
		
		
			<form action="<?=$page?>" method="post" name="codz2" id="codz2" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

				<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />
				<input type="hidden" id="do_date" name="do_date" value="<?=$do_date?>"/>
				<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"/>
				<input type="hidden" id="depot_id" name="depot_id" value="<?=$depot_id?>"/>
				<input type="hidden" id="dealer_code" name="dealer_code" value="<?=$dealer_code?>"/>
				<input name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"/>
				<input name="job_no" type="hidden" id="job_no" value="<?=$job_no;?>"/>

			<!--Table input one design-->
			<div class="container-fluid pt-5 p-0 ">  
				<table id="example1" style="width:100%;" class="table1 table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th class="se-th" width="3%"><input  id="selectAll" type="checkbox"></th>
						<th width="8%">Code</th>
						<th>Product Name</th>
						<th>Catagory Name</th>

						<th class="se-th">Order</th>
						<th class="se-th">Add Extra Order</th>
						<th>Remark</th>

					</tr>
					</thead>

					<tbody class="tbody1">
					<?php
						$sql = "select i.item_id, i.finish_goods_code, i.item_name, i.unit_name, s.sub_group_name, i.pack_size, i.d_price
								from item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id and i.product_nature like 'Salable'";
						$query = db_query($sql);
						while($row = mysqli_fetch_object($query)){
					?>	
					<tr>
						<td><input type="checkbox" name="checkb[]" value="<?php echo $row->item_id;?>"></td>
						<td><?php echo $row->finish_goods_code?></td>
						<td><?php echo $row->item_name?></td>
						<td><?php echo $row->sub_group_name?></td>
						<td>
							<input type="text" class="form-control" name="qty_<?php echo $row->item_id;?>" />
							<input type="hidden" name="pkt_size_<?php echo $row->item_id;?>" value="<?php echo $row->pack_size?>" />
							<input type="hidden" name="unit_name_<?php echo $row->item_id;?>" value="<?php echo $row->unit_name?>" />
							<input type="hidden" name="d_price_<?php echo $row->item_id;?>" value="<?php echo $row->d_price?>" />

						</td>
						<td><button type="button" class="btn1 btn1-bg-help">Add Extra</button></td>
						<td><textarea name="remark_<?php echo $row->item_id;?>" id="remark"></textarea></td>
					</tr>
					<?php } ?>
					
					</tbody>
				</table>
			</div>
			<!-- </form> -->
		
		
		


		<!--button design start-->
		<!-- <form action="select_dealer_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}"> -->
			<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input name="delete"  type="submit" class="btn1 btn1-bg-cancel" value="DELETE SO" />
					<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
					<input  name="do_date" type="hidden" id="do_date" value="<?=$do_date?>"/>
					<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM SO" />
				</div>

			</div>
		</form>

		<? }?>
	</div>








<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>



<script type="text/javascript">

$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example1 thead tr').clone(true).appendTo( '#example1 thead' );
    $('#example1 thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

 
    var table = $('#example1').DataTable( {
	    paging: false,
        ordering: false,
        info: false,
	    dom: 'Bfrtip',
		lengthMenu: [],
        buttons: [],
        orderCellsTop: true,
        fixedHeader: true
		
    } );
	
} );

$("#selectAll").click(function(){
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));

});


</script>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>