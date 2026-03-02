<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Create Sales Order';

do_calander('#do_date');
do_calander('#delivery_date');

do_calander('#customer_po_date');
$tr_type="Show";
//create_combobox('dealer_code_combo');

$now = date('Y-m-d H:s:i');

if($_GET['cbm_no']>0)
$cbm_no =$_SESSION['cbm_no'] = $_GET['cbm_no'];

$cdm_data = find_all_field('raw_input_sheet','','cbm_no='.$cbm_no);

do_calander('#est_date');

$page = 'do_w.php';

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



		


        $tr_type="Initiate";
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



$table		=$table_detail;

if($_POST['sub_group_id']!=0){
$_SESSION['sub_group'] = $_POST['sub_group_id'];
$_SESSION['dealer_code'] = $_POST['dealer_code'];
$_SESSION['group_for'] = $_POST['group_for'];
}

$crud      	= new crud($table);

$_POST['remarks']=$_POST['remarks11'];
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];


if($_REQUEST['init_bag_unit']<1){

$_POST['init_bag_unit'] = $_REQUEST['bag_unit'];
$_POST['init_dist_unit'] = $_REQUEST['total_unit'];
$_POST['init_total_unit'] = $_REQUEST['total_unit'];
$_POST['init_total_amt'] = $_REQUEST['total_amt'];

}


   $tr_type="Add";

$xid = $crud->insert();

//////////////////////////////////////////////////////////////////////////////////////////
$item_id = $_POST['item_id'];
$item = find_all_field('item_info','item_id','item_id='.$item_id);
 
 $gift_flag=0;
 
$sql = 'select * from sale_gift_offer_slab where 1';
$query = db_query($sql);
while($res = mysqli_fetch_object($query)){

	if($res->bill_period=='Special Date Range'){
		$con = ' and do_date<="'.$res->p_start_date.'" and do_date>="'.$p_end_date.'"';
	  }elseif($res->bill_period=='Calendar Month'){
		$con = ' and month(do_date)=month("'.$do_date.'")';
	  }elseif($res->bill_period=='Periodical Days' && $res->period_days>0){
		$period_days = $res->period_days;
		$endDate = $do_date; $startDate = date('Y-m-d', strtotime('-'.$period_days.' days', strtotime($endDate)));
		$con = ' and do_date between "'.$startDate.'" and "'.$endDate.'"';
	  }

	  if($res->discount_level=='Category Total'){
		$con.=' and i.sub_group_id='.$item->sub_group_id.' ';
	  }

	  if($res->dealer_code>0){
		$con.=' and d.dealer_code='.$res->dealer_code.' ';
	  }
	  if($res->dealer_type_id != ''){
		$con.=' and de.dealer_type="'.$res->dealer_type_id.'" ';
	  }
	  if($res->item_id > 0){
		$con.=' and d.item_id='.$res->item_id.' ';
	  }

	  if($res->sub_group_id > 0){
		$con.=' and i.sub_group_id='.$res->sub_group_id.' ';
	  }

	  //echo $con;
	
 $subGroupTotalCalendarMonth = find_a_field('sale_do_details d, item_info i, dealer_info de','sum(d.total_amt)','d.item_id=i.item_id and de.dealer_code=d.dealer_code   '.$con.'');
 $subGroupPriceCalendarMonth = find_a_field('sale_do_details d, item_info i, dealer_info de','sum(d.total_unit*i.m_price)','d.item_id=i.item_id and de.dealer_code=d.dealer_code   '.$con.'');
	  if($res->discount_on=='Invoice Value'){
		$discountOnAmt = $subGroupTotalCalendarMonth-$res->additional_discount_apply_from_amt;
	  }elseif($res->discount_on=='Price Value'){
		$discountOnAmt = $subGroupPriceCalendarMonth-$res->additional_discount_apply_from_amt;
	  }	



   if($res->item_id>0){
   	  	
   }
	if($res->sub_group_id > 0){  // sub group check individual
	
		if($res->sub_group_id == $item->sub_group_id){ // check sub group match
   	  		if($res->item_id>0){ // check item individual
				if($res->item_id==$item_id){
					if($res->bill_amount_over>0){ // check bill amount condition
						
					}else{
						if($res->base_discount>0){
							$discount_per = $res->base_discount;	
						}elseif($res->additional_discount>0){
							$discount_per = $res->additional_discount;	
						}elseif($res->additional_discount_amt>0){
							$discount_amt = $res->additional_discount_amt;	
						}

					}	
				}
			}else{

				if($res->bill_amount_over>0){ // check bill amount condition
						
				}else{
					if($res->base_discount>0){
						$discount_per = $res->base_discount;	
					}elseif($res->additional_discount>0){
						$discount_per = $res->additional_discount;	
					}elseif($res->additional_discount_amt>0){
						$discount_amt = $res->additional_discount_amt;	
					}
				}	

			}
   		}
		
	}
    if($res->discount_level=='Line Level'){
		if($res->bill_amount_over>0){ // check bill amount condition
			if($discountOnAmt>=$res->bill_amount_over){
				if($res->base_discount>0){
					$discount_per = $res->base_discount;	
				}elseif($res->additional_discount>0){
					$discount_per = $res->additional_discount;	
				}elseif($res->additional_discount_amt>0){
					$discount_amt = $res->additional_discount_amt;	
				}
			}
		} 
		if($discount_per>0){
			if($res->discount_on=='Invoice Value'){
				$discount_amt = ($_POST['total_amt']*$discount_per)/100;
			}elseif($res->discount_on=='Price Value'){
				$discount_amt = (($_POST['total_unit']*$item->m_price)*$discount_per)/100;
			}

		$insQ = "INSERT INTO `sale_do_discount`( `do_no`, `d_id`, `item_id`, `total_unit`, `unit_price`, 
		`mrp_rate`, `total_amt`, `discount_per`, `discount_amt`, `discount_id`, `entry_at`, `entry_by`) 
		VALUES ( '".$_POST['do_no']."', '".$xid."', '".$item_id."', '".$_POST['total_unit']."', '".$_POST['unit_price']."',
		'".$item->mrp_price."', '".$_POST['total_amt']."', '".$discount_per."', '".$discount_amt."', '".$res->id."', '".$now."', '".$_SESSION['user']['id']."')"; 
		db_query($insQ);	

		$upql = db_query("update sale_do_details set discount_per='".$discount_per."',discount_amt='".$discount_amt."', total_amt = '".($_POST['total_amt']-$discount_amt)."' where id='".$xid."'");	
				
		}	
	}	
}


echo 'dicountAmt'.$discount_amt;

//////////////////////////////////////////////////////////////////////////////////////////


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

$tr_type="Remove";
$main_del = find_a_field($table_detail,'gift_on_order','id = '.$del);

$crud   = new crud($table_detail);

if($del>0)

{
$tr_type="Remove";
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

$sql1 = "delete from sale_do_discount where  d_id = '".$del."'";
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
$tr_from="Sales";
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



/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


/*div.form-container_large input {*/
    /*width: 250px;*/
    /*height: 37px;*/
    /*border-radius: 0px !important;*/
/*}*/




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
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">Customer</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<? if ($dealer_code<1) {?>
										<select  name="dealer_code_combo" id="dealer_code_combo" onchange="getData2('credit_checker_ajax.php','cr',this.value)"  required>

											<option></option>


<? foreign_relation('dealer_info d,dealer_type t','d.dealer_code','concat(d.dealer_name_e,". #",t.dealer_type)',$dealer_code_combo,'d.dealer_type=t.id and d.status="ACTIVE"');?>
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

							<!--- <div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Discount (%)</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input  name="discount" type="text" id="discount" value="<?=$discount;?>"   />
								</div>
							</div> -->
							
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Credit Limit</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2" id="cr">
									<input  name="credit_limit" type="text" id="credit_limit" value="<?=$credit_limit;?>" readonly />
								</div>
							</div>

							<?php
							if($dealer_code>0){
								$dealer_ledger = find_a_field('dealer_info','account_code','dealer_code="'.$dealer_code.'"');
								$available = find_a_field('journal','sum(cr_amt-dr_amt)','ledger_id="'.$dealer_ledger.'"');
							}
								
							?>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Available Amount</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2" id="cr">
									<input  name="available" type="text" id="available" value="<?=$available;?>" readonly />
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
			<div class="container-fluid pt-5 p-0 ">
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
		<form action="<?=$page?>" method="post" name="codz2" id="codz2">
			<!--Table input one design-->
			<div class="container-fluid pt-5 p-0 ">


				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>Item Code</th>
						<th>Item Description</th>
						<th>Unit</th>

						<th>Stock</th>
						<th>Unit-Price</th>
						<th>Quantity</th>

						<th>Amount</th>
						<th>Action</th>
					</tr>
					</thead>

					<tbody class="tbody1">

					<tr>
						<td id="sub">

							<?

							auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id',' product_nature in ("Salable","Both") and status="Active"','item_id');

							//$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and do_no=".$do_no." order by id desc limit 1";
							//$do_data = find_all_field_sql($do_details);

							?>


							<input name="item_id" type="text" value="" id="item_id" onblur="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);"/>


							<!--<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);">

									<option></option>

								  <? foreign_relation('item_info','item_id','item_name',$item_id,'1');?>
							 </select>-->



							<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />
							<input type="hidden" id="do_date" name="do_date" value="<?=$do_date?>"  />
							<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
							<input type="hidden" id="depot_id" name="depot_id" value="<?=$depot_id?>"  />
							<input type="hidden" id="dealer_code" name="dealer_code" value="<?=$dealer_code?>"  />
							<input name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"/>
							<input name="job_no" type="hidden" id="job_no" value="<?=$job_no;?>"/>

						</td>

						 <td id="so_data_found" colspan="4">

							<table  width="100%" border="1" align="left" cellpadding="0" cellspacing="2">
							<tr>
								 <td width="40%"><input name="item_name" type="text" readonly=""  autocomplete="off"  value="" id="item_name" /> </td>
								 <td width="20%"><input name="pcs_stock" type="text" readonly=""  autocomplete="off"  value="" id="pcs_stock" /></td>
								 <td width="20%"><input name="ctn_price" type="text" id="ctn_price" readonly="" required  value="<?=$do_data->ctn_price;?>" /></td>
								 <td width="20%"><input name="pcs_price" type="text" id="pcs_price" readonly="" required="required"  value="<?=$do_data->pcs_price;?>"  /></td>
							</tr>
							</table>

						 </td>

						<td>
							<input  name="dist_unit" type="text" class="input3" id="dist_unit" value=""  onkeyup="count()" />
 						</td>

						<td>
							<input name="total_unit" type="hidden" id="total_unit" readonly/>
							<input name="total_amt" type="text" id="total_amt" readonly/>
						</td>

						<td><input name="add" type="submit" id="add" value="ADD" class="btn1 btn1-bg-submit" /></td>

					</tr>

					</tbody>
				</table>





			</div>

		<? if($$unique_master>0){?>
			
			<div class="container-fluid pt-5 p-0 ">
			<?
			  $sq = "select i.sub_group_id from sale_do_details d,item_info i where d.item_id=i.item_id and d.do_no=".$$unique_master." group by i.sub_group_id";
			  $q = db_query($sq);
			  while($r=mysqli_fetch_object($q)){
				// sum of this calender month 
				//echo 'd.item_id=i.item_id and d.do_no='.$$unique_master.' and i.sub_group_id='.$r->sub_group_id.' d.do_date month(do_date)=month("'.$do_date.'")';
			 
			  $gift_flag=0;
 
			  $sql = 'select * from sale_gift_offer_slab where 1';
			  $query = db_query($sql);
			  $discount_pers = 0;
			  $additional_disc_amt = 0;
			  $flag=0;
			  while($res = mysqli_fetch_object($query)){  
			  	$flag = find_a_field('sale_do_discount s, sale_do_details d','count(s.id)','s.do_no=d.do_no and s.discount_id='.$res->id.' and d.dealer_code='.$dealer_code);

				if($res->bill_period=='Special Date Range'){
					$con = ' and do_date<="'.$res->p_start_date.'" and do_date>="'.$p_end_date.'"';
				  }elseif($res->bill_period=='Calendar Month'){
					$con = ' and month(do_date)=month("'.$do_date.'")';
				  }elseif($res->bill_period=='Periodical Days' && $res->period_days>0){
					$period_days = $res->period_days;
					$endDate = $do_date; $startDate = date('Y-m-d', strtotime('-'.$period_days.' days', strtotime($endDate)));
					$con = ' and do_date between "'.$startDate.'" and "'.$endDate.'"';
				  }

				  if($res->discount_level=='Category Total'){
					$con.=' and i.sub_group_id='.$r->sub_group_id.' ';
				  }

				  if($res->dealer_code>0){
					$con.=' and d.dealer_code='.$res->dealer_code.' ';
				  }
				  if($res->dealer_type_id!=''){
					$con.=' and de.dealer_type="'.$res->dealer_type_id.'" ';
				  }
				  if($res->item_id > 0){
					$con.=' and d.item_id='.$res->item_id.' ';
				  }

				  if($res->sub_group_id > 0){
					$con.=' and i.sub_group_id='.$res->sub_group_id.' ';
				  }

				  //echo $con;
                
			$subGroupTotalCalendarMonth = find_a_field('sale_do_details d, item_info i, dealer_info de','sum(d.total_amt)','d.item_id=i.item_id and de.dealer_code=d.dealer_code   '.$con.' and d.dealer_code='.$dealer_code.' ');
			$subGroupPriceCalendarMonth = find_a_field('sale_do_details d, item_info i, dealer_info de','sum(d.total_unit*i.m_price)','d.item_id=i.item_id and de.dealer_code=d.dealer_code   '.$con.' and d.dealer_code='.$dealer_code.' ');
			
			$slabDiscount = find_a_field('sale_do_discount','sum(discount_amt)','dealer_code='.$dealer_code.' and tr_type like "slab" ');
			
			
			$curInv = find_a_field('sale_do_details d, item_info i, dealer_info de','sum(d.total_amt)','d.item_id=i.item_id and de.dealer_code=d.dealer_code   '.$con.' and d.do_no='.$do_no.'');
			$curPrice = find_a_field('sale_do_details d, item_info i, dealer_info de','sum(d.total_unit*i.m_price)','d.item_id=i.item_id and de.dealer_code=d.dealer_code   '.$con.' and d.do_no='.$do_no.' ');
			
			
				  if($res->discount_on=='Invoice Value'){
					$discountOnAmt = $subGroupTotalCalendarMonth-$res->additional_discount_apply_from_amt;
					$discountCurAmt = ($curInv-$slabDiscount);
				  }elseif($res->discount_on=='Price Value'){
					$discountOnAmt = $subGroupPriceCalendarMonth-$res->additional_discount_apply_from_amt;
					$discountCurAmt = ($curPrice-$slabDiscount);
				  }	

				  if($res->sub_group_id > 0){   // sub group check individual
				  
					  if($res->sub_group_id == $r->sub_group_id){  // check sub group match
							

							  if($res->bill_amount_over>0){  // check bill amount condition
									  if($res->bill_amount_over <= $subGroupTotalCalendarMonth){
										  if($res->additional_discount>0){ 
										  if($flag>0){
										  		$discount_pers += $res->additional_discount;
												$additional_disc_amt += $res->additional_discount_amt;	
												$discount_amts += ($discountCurAmt)*$res->additional_discount/100;
												if($discount_id != ''){
													$discount_id .= ','.$res->id;
												}else{
													$discount_id = $res->id;
												}
										  		
										   }else{
											$discount_pers += $res->additional_discount;
											$additional_disc_amt += $res->additional_discount_amt;	
											$discount_amts += ($discountOnAmt)*$res->additional_discount/100;
											if($discount_id != ''){
												$discount_id .= ','.$res->id;
											}else{
												$discount_id = $res->id;
											}
										   }
										   
										  }elseif($res->additional_discount_amt>0){
										    if($flag>0){
												$discount_amts += $res->additional_discount_amt;
											
											 }else{
											  	$discount_amts += $res->additional_discount_amt;	
											  }
										  }
									  }
							  }else{
								  if($res->base_discount>0){
									  $discount_per = $res->base_discount;	
								  }elseif($res->additional_discount>0){
									  $discount_per = $res->additional_discount;	
								  }elseif($res->additional_discount_amt>0){
									  $discount_amt = $res->additional_discount_amt;	
								  }
							  }	
			  
						  
						 }

						
					  
				  }else{
					  if($res->bill_amount_over>0){  // check bill amount condition
						  if($res->bill_amount_over <= $subGroupTotalCalendarMonth){
							  if($res->additional_discount>0){ 
							    if($flag>0){
								
									$discount_pers += $res->additional_discount;
									$additional_disc_amt += $res->additional_discount_amt;	
									$discount_amts += ($discountCurAmt)*$res->additional_discount/100;
								
								 }else{
									$discount_pers += $res->additional_discount;
									$additional_disc_amt += $res->additional_discount_amt;	
									$discount_amts += ($discountOnAmt)*$res->additional_discount/100;
								 }	
							  }
							  if($res->additional_discount_amt>0){
							  	if($flag>0){
									$discount_amts += $res->additional_discount_amt;	
								 }else{
								  $discount_amts += $res->additional_discount_amt;	
								  }
							  }
							  
							  

							  if($discount_id != ''){
								$discount_id .= ','.$res->id;
								}else{
									$discount_id = $res->id;
								}
								
							  
						  }
					  }  
				  }
				$flag = 0;
			  }

			  $discount_amount = $discount_amts;
			  $sub_group_id = $r->sub_group_id;
				
			  $res='select a.id,b.item_name,a.item_id,a.unit_name, a.unit_price, a.total_unit, a.total_amt as Net_sale, a.discount, a.vat_amt, a.total_amt_with_vat, b.m_price from
			   sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' and b.sub_group_id='.$r->sub_group_id.' order by a.id desc';
			?>

				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>SL</th>
						<th>Item Code</th>
						<th>Item Description</th>

						<th>Unit</th>
						<th>Unit-Price</th>
						<th>Quantity</th>
						
						<th>MRP</th>
						<th>Discount Per </th>
						<th>Discount</th>
						<th>Amount</th>
						<th>Action</th>
					</tr>
					</thead>

					<tbody class="tbody1">

					<?

					$i=1;

					$query = db_query($res);

					while($data=mysqli_fetch_object($query)){ ?>

					<tr>

						<td><?=$i++?></td>

						<td><?=$data->item_id?></td>
						<td style="text-align:left"><?=$data->item_name?></td>

						<td><?=$data->unit_name?></td>
						<td><?=$data->unit_price; ?></td>
						<td><?=$data->total_unit; $tot_pcs +=$data->total_unit;?></td>
						<td><?=($data->total_unit*$data->m_price)?></td>
						<td><?=find_a_field('sale_do_details','discount_per','id='.$data->id);?></td>
						<td><?=find_a_field('sale_do_details','discount_amt','id='.$data->id);?></td>
						<td><?=$data->Net_sale; $tot_Net_sale +=$data->Net_sale;?>

						<? $data->vat_amt; $tot_vat_amt +=$data->vat_amt;?>
						<? $data->total_amt_with_vat; $tot_total_amt_with_vat +=$data->total_amt_with_vat;?></td>
						<td><a href="?del=<?=$data->id?>">X</a></td>
					</tr>

					<? } ?>

					<tr>
						<td colspan="4"><strong>Discount:</strong></td>
						<td><?=$discount_pers;?> %</td>
						<td><strong></strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td><strong>Amount: <?=number_format($discount_amount,2);?></strong></td>
						<td>&nbsp;</td>
					</tr>

					<? } ?>

					<tr>
						<td colspan="4"><strong>Total:</strong></td>
						<td>&nbsp;</td>
						<td><strong><?=number_format($tot_pcs,2);?></strong></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><strong><?=number_format(($net = $tot_Net_sale-$discount_amount),2);?></strong></td>
						<td>&nbsp;</td>
					</tr>
					</tbody>
				</table>

			</div>
		<? }?>
		</form>


		<!--button design start-->
		<form action="select_dealer_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
			<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input name="delete"  type="submit" class="btn1 btn1-bg-cancel" value="DELETE SO" />
					<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
					<input  name="do_date" type="hidden" id="do_date" value="<?=$do_date?>"/>
					<input  name="sub_group_id" type="hidden" id="sub_group_id" value="<?=$sub_group_id?>"/>
					<input  name="inv_amt" type="hidden" id="inv_amt" value="<?=$subGroupTotalCalendarMonth?>"/>
					<input  name="mrp_amt" type="hidden" id="mrp_amt" value="<?=$subGroupPriceCalendarMonth?>"/>
					<input  name="discount_id" type="hidden" id="discount_id" value="<?=$discount_id?>"/>
					<input  name="sub_group_id" type="hidden" id="sub_group_id" value="<?=$sub_group_id?>"/>
					<input  name="discount_per" type="hidden" id="discount_per" value="<?=$discount_pers?>"/>
					<input  name="category_discount" type="hidden" id="do_date" value="<?=$discount_amount?>"/>
					<?php if($net>($credit_limit+$available)){ ?>
						<span class="text-danger">Credit Limit Exceed</span>
					<?php }else{ ?>	
						<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM SO" />
					<?php } ?>
				</div>

			</div>
		</form>

		<? }?>
	</div>






<!--<script>$("#cz").validate();$("#cloud").validate();</script>-->

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>