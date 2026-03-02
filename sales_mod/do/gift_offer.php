<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="show";


$title='Promotional Offer';

do_calander('#start_date');
do_calander('#end_date');


$table_master='sale_gift_offer';
$unique_master='id';
$page = $target_url = 'gift_offer.php';
if($_GET[$unique_master]>0) $$unique_master = $_GET[$unique_master];
if(isset($_POST['new']))
{if(prevent_multi_submit()){
		$crud   = new crud($table_master);
		$item=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$item[1];
		
		$g=explode('#>',$_POST['gift_id']);
		$_POST['gift_id']=$g[1];
		
		if($g[1]==2000)
		$_POST['gift_qty']=find_a_field('item_info','d_price','item_id='.$item[1])*$_POST['gift_qty'];

	// Dump Min Max Calculation
		$pack_size = find_a_field('item_info','pack_size','item_id='.$item[1]);
		$_POST['min_qty']= $_POST['min_qty']*$pack_size;
		$_POST['max_qty']= $_POST['max_qty']*$pack_size;
		if($_POST['min_qty']>0) { $_POST['item_qty'] = $_POST['min_qty']; }
	// End // Dump Min Max Calculation	
		
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['dealer_type'] = find_a_field('dealer_type','dealer_type','id="'.$_POST['dealer_type_id'].'"');
		if($_POST['flag']<1){
		$$unique_master=$crud->insert();
		unset($$unique_master);
		$type=1;
		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
		$tr_type="Initiate";
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		$tr_type="Edit";
        
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
header('location:gift_offer.php');
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
//$sql_i='select finish_goods_code from item_info where sales_item_type="'.$dealer->product_group.'" and product_nature="Salable"';
//$query_i=db_query($sql_i);
//foreach($query_i as $is)
//while($is=mysqli_fetch_object($query_i))
//{
//	echo 'myCars['.$item_i.']="'.$is->finish_goods_code.'";';
//	$item_i++;
//}
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
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-stat align-items-center pr-1 bg-form-titel-text">Product Item Name :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="item_id" type="text" id="item_id" value="<?=find_a_field('item_info','item_name','item_id="'.$item_id.'"').'#>'.$item_id?>"/>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">On Unit Qty (Pcs):</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="item_qty" type="text" id="item_qty" value="<?=$item_qty?>"/>
                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        
							<!--<strong>Dump Range Qty Setup: </strong>-->
                        <!--<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Min Qty (Ctn):</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                               <input  name="min_qty" type="text" id="min_qty" value="<?=$min_qty?>"/>
                            </div>
                        </div>-->

                        <!--<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Max Qty (Ctn):</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="max_qty" type="text" id="max_qty" value="<?=$max_qty?>"/>

                            </div>
                        </div>-->
						
						<h4 class="text-center bold">End Dump Range Qty Setup:</h4>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Gift Item Name :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                               <input  name="gift_id" type="text" id="gift_id" value="<?=find_a_field('item_info','item_name','item_id="'.$gift_id.'"').'#>'.$gift_id?>"/>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Gift Unit Qty (Pcs):</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="gift_qty" type="text" id="gift_qty" value="<?=$gift_qty?>"/>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Gift Type :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select id="gift_type" name="gift_type">
								<option value="Non-Cash" <?=($gift_type=='Non-Cash')?'selected':''?>>Non-Cash</option>
								<option value="Cash" <?=($gift_type=='Cash')?'selected':''?>>Cash</option>
								</select>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Status :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select id="status" name="status">
		
								<option value="Active" <?=($status=='Active')?'selected':''?>>Active</option>
								<option value="Inactive" <?=($status=='Inactive')?'selected':''?>>Inactive</option>
								
								</select>

                            </div>
                        </div>

                    </div>



                </div>


            </div>

            <div class="n-form-btn-class">
                 <? if($$unique_master>0) {?>
					<input name="new" type="submit" class="btn1 btn1-bg-update" value="Update Demand Order" tabindex="12" />
					<input name="flag" id="flag" type="hidden" value="1" />
					<input name="clear" id="clear" type="submit" value="CLEAR"  class="btn1 btn1-bg-cancel" />
					<? }else{?>
					<input name="new" type="submit" class="btn1 btn1-bg-submit" value="Initiate Demand Order"  tabindex="12" />
					<input name="flag" id="flag" type="hidden" value="0" />
					<? }?>
            </div>
        </div>

        <!--return Table design start-->
        <div class="container-fluid pt-5 p-0 ">
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
						<th>ID</th>
						<th>Offer</th>
						<th>Duration</th>
						<th>Item Name/Gift Item</th>
						<th>Item/Gift Qty</th>
						
						<th>Action</th>
                </tr>
                </thead>

                <tbody class="tbody1">
				
				<? 
					$sql='select a.id,b.pack_size,a.offer_name as offer,a.start_date as Start,a.end_date as End,
					b.finish_goods_code as code,b.item_name,a.item_qty, c.finish_goods_code as g_code, a.gift_qty, c.item_name as gift_name, 
					(a.min_qty/c.pack_size) as min_ctn, (a.max_qty/c.pack_size) as max_ctn
					
					from sale_gift_offer a,item_info b,item_info c 
					where b.item_id=a.item_id and c.item_id=a.gift_id and a.end_date>="'.date('Y-m-d').'"
					order by id desc';
					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){
				?>

               <tr>
					<td><?=$data->id?></td>
					<td style="text-align:left"><?=$data->offer?></td>
					<td><?=date('d-M', strtotime($data->Start));?><br><?=date('d-M', strtotime($data->End));?></td>
					
					<td style="text-align:left"><strong><?=$data->code?>-<?=$data->item_name?></strong><br><span><?=$data->g_code?>-<?=$data->gift_name?></span></td>
					<td><strong><?=$data->item_qty/$data->pack_size?> Ctn</strong><br><span><?=$data->gift_qty?> Pcs</span></td>
					
					<td class=""><a href="?id=<?=$data->id?>" class="btn1 btn1-bg-update">Update</a><!--<br /><a href="?del=<?=$data->id?>">X</a>--></td>
					
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