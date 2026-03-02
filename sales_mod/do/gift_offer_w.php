<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Promotional Offer';

do_calander('#start_date');
do_calander('#end_date');

do_calander('#p_start_date');
do_calander('#p_end_date');
$tr_type="show";

$table_master='sale_gift_offer_slab';
$unique_master='id';
$page = $target_url = 'gift_offer_w.php';
if($_GET[$unique_master]>0) $$unique_master = $_GET[$unique_master];
if(isset($_POST['new']))
{if(prevent_multi_submit()){
		$crud   = new crud($table_master);
		$item=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$item[1];
		
		$g=explode('#>',$_POST['gift_id']);
		$_POST['gift_id']=$g[1];
		
		
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['dealer_type'] = find_a_field('dealer_type','dealer_type','id="'.$_POST['dealer_type_id'].'"');
		if($_POST['flag']<1){
		$$unique_master=$crud->insert();
		unset($$unique_master);
		$type=1;
		$msg='Work Order Initialized. (ID -'.$$unique_master.')';
		$tr_type="Add";
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		$tr_type="Add";
		}
}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}
}

if(isset($_POST['clear'])){
unset($_POST);
unset($$unique_master);
header('location:gift_offer_w.php');
}

if($_GET[$unique_master]>0) $$unique_master = $_GET[$unique_master];
if($$unique_master>0)
{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}

if($_GET['del']>0)
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
}

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','product_nature in ("Salable","Both")','item_id');

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','product_nature in ("Salable","Both")','gift_id');

$tr_from="Sales";
?>
<script language="javascript">
function count()
{
if(document.getElementById('pkt_unit').value!=''){
var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
var dist_unit = ((document.getElementById('dist_unit').value)*1);
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var total_unit = (pkt_unit*pkt_size)+dist_unit;
var unit_price = ((document.getElementById('unit_price').value)*1);
var total_amt  = (total_unit*unit_price);
document.getElementById('total_unit').value=total_unit;
document.getElementById('total_amt').value	= total_amt .toFixed(2);
}
else
document.getElementById('pkt_unit').focus();
}
</script>

<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique_master?>='+theUrl);
}
</script>
<script language="javascript">
function grp_check(id)
{
if(document.getElementById("item").value!=''){
var myCars=new Array();
myCars[0]="01815224424";
<?
$item_i = 1;
$sql_i='select finish_goods_code from item_info where sales_item_type="'.$dealer->product_group.'" and product_nature="Salable"';
$query_i=db_query($sql_i);
while($is=mysqli_fetch_object($query_i))
{
	echo 'myCars['.$item_i.']="'.$is->finish_goods_code.'";';
	$item_i++;
}
?>
var item_check=id;
var f=myCars.indexOf(item_check);
if(f>0)
getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$dealer->depot;?>');
else
{
alert('Item is not Accessable');
document.getElementById("item").value='';
document.getElementById("item").focus();
}}
}
</script>




<!--Mr create 2 form with table-->
<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                 <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Offer ID:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="id" type="text" id="id" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Promotional Offer Name:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="offer_name" type="text" id="offer_name" value="<?=$offer_name?>"/>
                            </div>
                        </div>

                
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-stat align-items-center pr-1 bg-form-titel-text">Product Type: </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select  name="sub_group_id" type="text" id="sub_group_id" value="">
									<option></option>
									<?=foreign_relation('item_sub_group','sub_group_id','sub_group_name',$sub_group_id,'1')?>
								</select>

                            </div>
                        </div>
						
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-stat align-items-center pr-1 bg-form-titel-text">Product Item Name :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="item_id" type="text" id="item_id" value="<?=find_a_field('item_info','concat(item_name,"#>",item_id)','item_id="'.$item_id.'"')?>"/>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Bill Amount Over:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="bill_amount_over" type="text" id="bill_amount_over" value="<?=$bill_amount_over?>"/>
                            </div>
                        </div>
						
						
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-stat align-items-center pr-1 bg-form-titel-text">Bill Period: </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select  name="bill_period" type="text" id="bill_period" value="">
									<option>Periodical Days</option>
									<option>Special Date Range</option>
									<option>Calendar Month</option>
									<option>All</option>
								</select>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Period Days:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="period_days" type="text" id="period_days" value="<?=$period_days?>"/>
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Start Date :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="p_start_date" type="text" id="p_start_date" value="<?=$p_start_date;?>" autocomplete="off"/>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">End Date :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="p_end_date" type="text" id="p_end_date" value="<?=$p_end_date;?>" autocomplete="off"/>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-stat align-items-center pr-1 bg-form-titel-text">Condition Check: </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select  name="condition_check" type="text" id="condition_check" value="">
									<option>Invoice Value</option>
									<option>Price Value</option>
								</select>

                            </div>
                        </div>
						
                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-stat align-items-center pr-1 bg-form-titel-text">Discount on: </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select  name="discount_on" type="text" id="discount_on" value="">
									<option>Invoice Value</option>
									<option>Price Value</option>
								</select>

                            </div>
                        </div>
						
						
						<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-stat align-items-center pr-1 bg-form-titel-text">Discount level: </label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
										<select  name="discount_level" type="text" id="discount_level" value="">
											<option>Line Level</option>
											<option>Category Total</option>
											<option>Total</option>
										</select>
									</div>
								</div>
								
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Base Discount:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input  name="base_discount" type="text" id="base_discount" value="<?=$base_discount?>"/>
									</div>
								</div>
								
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Additional Discount:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input  name="additional_discount" type="text" id="additional_discount" value="<?=$additional_discount?>"/>
									</div>
								</div>
								
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Additional Discount amount (BDT):</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input  name="additional_discount_amt" type="text" id="additional_discount_amt" value="<?=$additional_discount_amt?>"/>
									</div>
								</div>
								
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Additional Discount Apply from:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									   <select  name="additional_discount_from" type="text" id="additional_discount_from" value="">
									        <option></option>
											<option>All Bill Amount in Period</option>
											<option>After Specific Amount</option>
										</select>
									</div>
								</div>
								
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Additional Discount Apply from Amount:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input  name="additional_discount_apply_from_amt" type="text" id="additional_discount_apply_from_amt" value="<?=$additional_discount_apply_from_amt?>"/>
									</div>
								</div>		
						
						
						
				<div class="form-group row m-0 pb-1">
                  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Dealer Type:</label>
                            
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								<select id="dealer_type_id" name="dealer_type_id" required>
									<option></option>
									<? foreign_relation('dealer_type','id','dealer_type',$dealer_type_id,'1 order by dealer_type');?>
								</select>
					</div>
					 </div>
								
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Start Date :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="start_date" type="text" id="start_date" value="<?=$start_date;?>" autocomplete="off"/>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">End Date :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="end_date" type="text" id="end_date" value="<?=$end_date;?>" autocomplete="off"/>

                            </div>
                        </div>

						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Party Name :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select  name="dealer_code" id="dealer_code"  >
									<option></option>
									<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'1 order by dealer_name_e')?>
								</select>
                            </div>
                        </div>

                    </div>



                </div>


            </div>

            <div class="n-form-btn-class">
                 <? if($$unique_master>0) {?>
					<input name="new" type="submit" class="btn1 btn1-bg-update" value="Update" tabindex="12" />
					<input name="flag" id="flag" type="hidden" value="1" />
					<input name="clear" id="clear" type="submit" value="CLEAR"  class="btn1 btn1-bg-cancel" />
					<? }else{?>
					<input name="new" type="submit" class="btn1 btn1-bg-submit" value="Save"  tabindex="12" />
					<input name="flag" id="flag" type="hidden" value="0" />
					<? }?>
            </div>
        </div>

        <!--return Table design start-->
        <div class="container-fluid pt-5 p-0 " style="overflow-x:auto;">
            <table class="table1  table-striped table-bordered table-hover table-sm ">
                <thead class="thead1">
                <tr class="bgc-info">
						<th>ID</th>
						<th>Offer Name</th>
						<th>Product Type</th>
						<th>Item Name</th>
						<th>Bill amount over</th>
						
						<th>Bill Period</th>
						<th>Period Days</th>
						<th>Start Date</th>
						<th>End Date</th>
						
						<th>Condition check</th>
						<th>Discount on</th>
						<th>Discount Level</th>
						<th>Base Discount</th>
						
						<th>Additional Discount Rate</th>
						<th>Additional Discount amount (BDT)</th>
						<th>Addional Discount Apply from</th>
						<th>Addional Discount Apply from amount</th>
						
						<th>Start Date</th>
						<th>End Date</th>
						<th>Party Type</th>
						<th>Party Name</th>
						
						<th>Action</th>
                </tr>
                </thead>

                <tbody class="tbody1">
				
				<? 
					$sql='select * from sale_gift_offer_slab where 1';
					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){
				?>

               <tr>
					<td><?=$data->id?></td>
					<td style="text-align:left"><?=$data->offer_name?></td>
					<td><?=$data->sub_group_id?></td>
					<td style="text-align:left"><?=find_a_field('item_info','item_name','item_id='.$data->item_id);?></td>
					<td><?=$data->bill_amount_over?></td>
					<td><?=$data->bill_period?></td>
					
					
					<td><?=$data->period_days?></td>
					<td style="text-align:left"><?=$data->p_start_date?></td>
					<td><?=$data->p_end_date?></td>
					<td><?=$data->condition_check?></td>
					
					<td><?=$data->discount_on?></td>
					<td><?=$data->discount_level?></td>
					<td><?=$data->base_discount?></td>
					<td><?=$data->additional_discount?></td>
					
					<td><?=$data->additional_discount_amt?></td>
					<td><?=$data->additional_discount_from?></td>
					
					<td><?=$data->additional_discount_apply_from_amt?></td>
					<td><?=$data->start_date?></td>
					<td><?=$data->end_date?></td>
					<td><?=$data->dealer_type?></td>
					<td><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code)?></td>
					<td><a href="?id=<?=$data->id?>" class="btn1 btn1-bg-update">Update</a></td>
					
				</tr>




					<? }?>
                </tbody>
            </table>

        </div>
    </form>

    

</div>




<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>