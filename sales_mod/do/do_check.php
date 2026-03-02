<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$depot=$_SESSION['user']['depot'];



$title='Sales Quotation Approved';



do_calander('#est_date');



do_calander('#do_date');



$page = 'do.php';



$depot_id = $_POST['depot_id'];

$tr_type="show";

if($_POST['dealer']>0) 



$dealer_code = $_POST['dealer'];



$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);



$table_master='sale_do_master';



$unique_master='do_no';



$table_detail='sale_do_details';



$unique_detail='id';

if($_GET['mhafuz']==2)
unset($_SESSION['do_no']);

if($_GET['old_do_no']>0)
$$unique_master=$_GET['old_do_no'];

elseif($_GET['do_no']>0)
$$unique_master=$_GET['do_no'];


elseif($_GET['del']>0&&$_SESSION['do_no']>0)
{$$unique_master=$_SESSION['do_no']; $del = $_GET['del'];}

elseif($_SESSION['do_no']>0)
$$unique_master=$_SESSION['do_no'];



if(prevent_multi_submit()){



if(isset($_POST['new']))



{

    $crud   = new crud($table_master);



    $_POST['entry_at']=date('Y-m-d H:i:s');



    $_POST['entry_by']=$_SESSION['user']['id'];



    if($_POST['flag']<1){



    $_POST['do_no'] =$_SESSION['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;



    $$unique_master=$crud->insert();



    unset($$unique);



    $type=1;



    $msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';


	$tr_type="Initiate";

    }







    else {







    $crud->update($unique_master);







    $type=1;







    $msg='Successfully Updated.';







    }







}











if(isset($_POST['add'])&&($_POST[$unique_master]>0))
{

$details_insert = new crud($table_detail) ;

$_POST['unit_price']=$_POST['unit_price2'] ;

$details_insert->insert();

unset($$unique);

$type=1;

$msg='Item Entry Succesfull';
$tr_type="Add";

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

    $type=1;
    $msg='Successfully Deleted.';
	$tr_type="Delete";
}























if($$unique_master>0)

{

    $condition=$unique_master."=".$$unique_master;

    $data=db_fetch_object($table_master,$condition);

    foreach($data as $key=>$value)

    { $$key=$value;}

}







$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

auto_complete_start_from_db('item_info','concat(finish_goods_code,"#>",item_name)','finish_goods_code','product_nature="Salable" order by finish_goods_code ASC','item');




$tr_from="Sales";


?>
<script language="javascript">







function count()







{







if(document.getElementById('pkt_unit').value!=''){



var pkt_unit = ((document.getElementById('pkt_unit').value)*1);



var dist_unit = ((document.getElementById('dist_unit').value)*1);



var pkt_size = 1;



var unit_price2 = ((document.getElementById('unit_price2').value)*1);







var total_unit = (pkt_unit*1)+dist_unit;







if(unit_price2==0)



var unit_price =0;



else



var unit_price = ((document.getElementById('unit_price2').value)*1);



var total_amt  = (total_unit*unit_price);







document.getElementById('total_unit').value=total_unit;







document.getElementById('total_amt').value  = total_amt.toFixed(2);







var do_total = ((document.getElementById('do_total').value)*1);







var do_ordering = total_amt+do_total;







document.getElementById('do_ordering').value =do_ordering.toFixed(2);







}







else







document.getElementById('dist_unit').focus();







}







</script>
<script language="javascript">







function focuson(id) {

  if(document.getElementById('item').value=='')

  document.getElementById('item').focus();

  else

  document.getElementById(id).focus();

}















window.onload = function() {



if(document.getElementById("flag").value=='0')

  document.getElementById("rcv_amt").focus();

  else

  document.getElementById("item").focus();

}







</script>
<script>



/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////



function insert_item(){

var item1 = $("#item");

var dist_unit = $("#dist_unit");





if(item1.val()=="" || dist_unit.val()==""){
alert('Please check Item ID,Qty');
return false;
}



  

$.ajax({

url:"do_input_ajax.php",
method:"POST",
dataType:"JSON",
data:$("#codz").serialize(),

success: function(result, msg){


var res = result;


$("#codzList").html(res[0]);  

$("#item").val('');
$("#item2").val('');
$("#dist_unit").val('');
$("#total_amt").val('');
}
}); 
}






function grp_check(id)

{

if(document.getElementById("item").value!=''){

var myCars=new Array();

myCars[0]="01815224424";

getData2('do_ajax_s.php', 'do',document.getElementById("item").value,'<?=$depot_id;?>');

}







}







</script>


<!--<style type="text/css">


.style1 {

  color: #FFFFFF;

  font-weight: bold;


}












.ac_results{

width:inherit !important;

}

.ac_results > ul{

height:250px;

}

</style>-->


<div class="form-container_large">
    <form action="<?=$page?>" method="post" name="codz2" id="codz2">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input   name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1)        ;?>    " class="form-control" readonly/>
    
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delaer name :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                               <select  id="dealer_code" class="form-control" name="dealer_code" readonly="readonly">
								  <option value="<?=$dealer->dealer_code;?>">
								  <?=$dealer->dealer_code.'-'.$dealer->dealer_name_e;?>
								  </option>
								</select>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Area :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="wo_detail2" id="wo_detail2" class="form-control">
								<option value="<?=$dealer->area_code?>"><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$dealer->area_code.'"');?></option>
							
								</select>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Zone :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input   name="wo_detail" class="form-control"  type="text" id="wo_detail" value="<?=$dealer->zone_name?>" readonly/>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Region :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="wo_detail" id="wo_detail" class="form-control">
									<option value="<?=$dealer->region_code?>"><?=find_a_field(' branch','BRANCH_NAME','BRANCH_ID="'.$dealer->region_code.'"');?></option>
								
									</select>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depot :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select  id="depot_id" name="depot_id" class="form-control"  readonly="readonly">
              <option value="<?=$dealer->depot;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
            </select>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Rcv Amt:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note:
</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" class="form-control"  required/>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order Date :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input   name="do_date" type="text" class="form-control"  id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>" />

                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Undel Amt :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <? echo 'select sum(total_amt) from sale_do_details where   dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"';
                                $av_amt=(find_a_field_sql('select sum(total_amt) from sale_do_details where   dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"'));
                                 $av_amt2=(find_a_field_sql('select sum(total_amt) from sale_do_chalan where    dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"'));
								 ?>
								<input   name="wo_subject" type="text" class="form-control"  id="wo_subject" value="<? $av_amt - $av_amt2 ?>" readonly/>
                            </div>
                        </div>
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Credit Limit :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="wo_subject" type="text" id="wo_subject" class="form-control"  value="<?=$dealer->credit_limit?>" readonly/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Available Amt :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="thickness" type="text" id="thickness" class="form-control"  value="<? echo $av_amt=find_a_field_sql('select sum(dr_amt)-sum(cr_amt) from journal where            ledger_id='.$dealer->account_code)?>" readonly/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order Limit :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input   name="thickness" class="form-control"  type="text" id="thickness" value="" readonly/>

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Address:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="delivery_address" type="text" class="form-control"  id="delivery_address"  value="<? if($delivery_address!='') echo $delivery_address; else echo $dealer->         address_e?>" />

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Money Rcv No:
</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="mr_no" type="text" id="mr_no" class="form-control"  value="<?=$mr_no?>" tabindex="101" />

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Commission:
</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input   name="cash_discount" type="text" class="form-control"  id="cash_discount" value="<? if($cash_discount>0) echo $cash_discount; else echo $dealer->commission;?>"            />

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Conversion Rate:
</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input   name="conversion_rate" type="text" class="form-control"  id="conversion_rate" value="<?  echo $conversion_rate;?>"   />

                            </div>
                        </div>
                    </div>

                </div>

            </div>
			
			</div>
			
			
			<? if($dealer->canceled=='Yes'){?>
			<div class="n-form-btn-class">
            <? if($$unique_master>0) {?>
            <input name="new" type="submit" class="btn1 btn1-bg-update" value="Update Quotation" >
            <input name="flag" id="flag" type="hidden" value="1" />
            <? }else{?>
            <input name="new" type="submit" class="btn1 btn1-bg-submit" value="Initiate Quotation"  tabindex="12" />
            <input name="flag" id="flag" type="hidden" value="0" />
            <? }?>
            </div>
			<? }elseif($dealer->canceled=='No'){?>
<div class="alert alert-danger row justify-content-center" role="alert">DEALER IS BLOCKED</div>

          <? }else{?>
<div class="alert alert-danger row justify-content-center" role="alert">DEALER NOT FOUND</div>
          <? }?>
			
			
			
		</form>

         <? if($$unique_master>0){?>
		 <form action="<?=$page?>" method="post" name="codz" id="codz">
    
			<!--Table input one design-->
			<div class="container-fluid pt-5 p-0 ">


				<table class="table1  table-striped table-bordered table-hover table-sm">
				<tr>
       
					<td colspan="10" align="right" bgcolor="#009966" >
					
					<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex 
							justify-content-end align-items-center pr-1 bg-form-titel-text">Total Ordering:  </label>
                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2">
                                					
					  <?
			$total_do = find_a_field($table_detail,'sum(total_amt)',$unique_master.'='.$$unique_master);
			
			?>
					  <input type="text" name="do_ordering" id="do_ordering" value="<?=$total_do-($total_do*$dealer->commission/100)?>"  disabled="disabled" readonly />
					  <input type="hidden" name="do_total" id="do_total" value="<?=$total_do?>" />

                            </div>
						<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0 pr-2">
						
						</div>
							
                        </div>
				
					  
					  </td>
				  </tr>
					<thead class="thead1">
					<tr class="bgc-info">
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Item Stk</th>

						<th>UnDel</th>
						<th>Unit-Price</th>
						<th>Crt Qty</th>

						<th>Unit</th>
						<th>Qty</th>
						<th>Total Amt</th>
						<th>Action</th>
					</tr>
					</thead>

					<tbody class="tbody1">

					<tr>
						<td id="sub"><span id="inst_no">
          <input name="item" type="text" class="form-control" id="item"  required onblur="grp_check(this.value);" tabindex="1"/>
          
          <input name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>" readonly/>
          <input name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly/>
          <input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
          <input name="depot_id" type="hidden" id="depot_id" value="<?=$depot_id;?>"/>
          <input name="flag" id="flag" type="hidden" value="1" />
          </span>
          <input style="width:10px;"  name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly/>

						</td>

						 
						<td colspan="4">
							<div align="right">
								  <span id="do">
						<table style="width:100%;" border="1">
							<tr>

								<td width="20%"><input name="item2" type="text" id="item2" class="form-control" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('dist_unit')"/></td>

								<td width="20%"><input name="in_stock"  type="text" class="form-control" id="in_stock"  value="<?=$in_stock?>" readonly onfocus="focuson('dist_unit')"/>
                <input name="item_id" type="hidden" class="form-control" id="item_id"  value="<?=$item_all->item_id?>" readonly/></td>

								<td width="20%"><input name="undel" type="text" class="form-control" id="undel" readonly  value="<?=($ordered_qty+$del_qty)?>"/></td>

								<td width="20%"><input name="unit_price" type="text" class="form-control" id="unit_price"  onchange="count()" value="<?=$item_all->d_price?>" />
                <input name="unit_price2" type="hidden" class="form-control" id="unit_price2"  onchange="count()" value="<?=$item_all->d_price?>" />
                <input name="pkt_size" type="hidden" id="pkt_size" class="form-control"  value="<?=$item_all->pack_size?>" readonly/></td>
							</tr>
						</table>
						</span>
							</div>
						</td>


						<td><input name="pkt_unit" type="text" value="0" readonly  id="pkt_unit" class="form-control" onkeyup="count()" required="required"  tabindex="4"/></td>
						
						<td><input name="pkt_unit" type="text" value="Pcs" readonly  id="pkt_unit" class="form-control" onkeyup="count()" required="required"  tabindex="4"/></td>
						
						<td><input name="dist_unit" type="text" id="dist_unit" class="form-control" onkeyup="count()" /></td>

						<td><input name="total_unit" type="hidden" class="form-control" id="total_unit" readonly/>
          <input name="total_amt" type="text" class="form-control" id="total_amt" readonly/></td>

						<td><input name="add" type="button" id="add" value="ADD" onclick="count();insert_item()" class="btn1 btn1-bg-submit" tabindex="5"/></td>
						

					</tr>

					</tbody>
				</table>





			</div>

		<? if($$unique_master>0){?>
			<!--Data multi Table design start-->
			<div class="container-fluid pt-5 p-0 ">
			<? 
$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price as price,a.dist_unit as qty ,a.total_amt,"X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';
//echo link_report_add_del_auto($res,'',6);
    ?>

				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>SL</th>
						<th>Item Code</th>
						<th>Item Name</th>

						<th>Unit-Price</th>
						<th>Qty</th>
						<th>Total Amt</th>
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

						<td><?=$data->code?></td>
						<td><?=$data->item_name?></td>

						<td><?=$data->price?></td>
						<td><?=$data->qty; ?></td>
						<td><?=$data->total_amt;?></td>
						<td><a href="?del=<?=$data->id?>">X</a></td>
					</tr>
					
					<tr>

<td colspan="4"><div align="right"><strong>  Total:</strong></div></td>


<td><?=number_format($data->qty,2);?></td>
<td><?=number_format($data->total_amt,2);?></td>
<td>&nbsp;</td>
</tr>

					<? } ?>


					</tbody>
				</table>
				<? } ?>

			</div>
		
	</form>  
	
	<form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
				<input name="delete"  type="submit" class="btn1 btn1-bg-cancel" value="DELETE Quotation"  />
          		<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
				
				<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND SEND FOR WORK ORDER"  />
            </div>

        </div>
    </form>
	<? }?>
	 

</div>





<?php /*?><div class="form-container_large">

  <form action="<?=$page?>" method="post" name="codz2" id="codz2" class="font-weight-bold">
  
         <div class="row ">
    
	
	     <div class="col-md-3 form-group">
            <label for="do_no" >Order No : </label>
          <input   name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1)        ;?>    " class="form-control" readonly/>
          </div>
		  
		  <div class="col-md-3 form-group">
            <label for="dealer_code">Dealer : </label>
            <select  id="dealer_code" class="form-control" name="dealer_code" readonly="readonly">
              <option value="<?=$dealer->dealer_code;?>">
              <?=$dealer->dealer_code.'-'.$dealer->dealer_name_e;?>
              </option>
            </select>
          </div>
		  
		  
		 <div class="col-md-3 form-group">
            <label for="wo_detail2">Area : </label>
			<select name="wo_detail2" id="wo_detail2" class="form-control">
			<option value="<?=$dealer->area_code?>"><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$dealer->area_code.'"');?></option>
		
			</select>
            
          </div>
		  
		  
		   <div class="col-md-3 form-group">
            <label for="wo_detail">Zone : </label>
             <input   name="wo_detail" class="form-control"  type="text" id="wo_detail" value="<?=$dealer->zone_name?>" readonly/>
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
            <label for="wo_detail">Region : </label>
			<select name="wo_detail" id="wo_detail" class="form-control">
			<option value="<?=$dealer->region_code?>"><?=find_a_field(' branch','BRANCH_NAME','BRANCH_ID="'.$dealer->region_code.'"');?></option>
		
			</select>
          
          </div>
		  
		  
          <div class="col-md-3 form-group">
            <label for="depot_id">Depot : </label>
            <select  id="depot_id" name="depot_id" class="form-control"  readonly="readonly">
              <option value="<?=$dealer->depot;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
            </select>
            
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="rcv_amt">Rcv Amt: </label>
            <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
        <div class="col-md-3 form-group">
            <label for="remarks">Note: </label>
            <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" class="form-control"  required/>
          </div>
		  
		  
		  
		  
		   <div class="col-md-3 form-group">
            <label for="do_date">Order Date : </label>
            <input   name="do_date" type="text" class="form-control"  id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>" />
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="wo_subject">Undel Amt : </label>
            <?
             ?>
            <input   name="wo_subject" type="text" class="form-control"  id="wo_subject" value="<? echo $av_amt=(find_a_field_sql('select sum(total_amt) from sale_do_details where   dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"')-find_a_field_sql('select sum(total_amt) from sale_do_chalan where    dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"'))?>" readonly/>
          </div>
		  
		  
         <div class="col-md-3 form-group">
            <label for="wo_subject">Credit Limit : </label>
            <input  name="wo_subject" type="text" id="wo_subject" class="form-control"  value="<?=$dealer->credit_limit?>" readonly/>
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="thickness">Available Amt : </label>
            <input name="thickness" type="text" id="thickness" class="form-control"  value="<? echo $av_amt=find_a_field_sql('select sum(dr_amt)-sum(cr_amt) from journal where            ledger_id='.$dealer->account_code)?>" readonly/>
          </div>
		  
		  
		  <div class="col-md-3 form-group">
            <label for="thickness">Order Limit : </label>
            <input   name="thickness" class="form-control"  type="text" id="thickness" value="" readonly/>
          </div>
		  
         <div class="col-md-3 form-group">
            <label for="delivery_address">Address: </label>
            <input name="delivery_address" type="text" class="form-control"  id="delivery_address"  value="<? if($delivery_address!='') echo $delivery_address; else echo $dealer->         address_e?>" />
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="mr_no">Money Rcv No: </label>
            <input name="mr_no" type="text" id="mr_no" class="form-control"  value="<?=$mr_no?>" tabindex="101" />
          </div>
		  
         <div class="col-md-3 form-group">
            <label for="cash_discount">Commission: </label>
            <input   name="cash_discount" type="text" class="form-control"  id="cash_discount" value="<? if($cash_discount>0) echo $cash_discount; else echo $dealer->commission;?>"            />
          </div>
		  
		  <div class="col-md-3 form-group">
            <label for="cash_discount">Conversion Rate: </label>
            <input   name="conversion_rate" type="text" class="form-control"  id="conversion_rate" value="<?  echo $conversion_rate;?>"   />
          </div>
		  
		  
		  
		  
		  
   </div>  
   
   
   
   <? if($dealer->canceled=='Yes'){?>
          <div class="row justify-content-center">
            <? if($$unique_master>0) {?>
            <input name="new" type="submit" class="btn btn-warning" value="Update Demand Order" >
            <input name="flag" id="flag" type="hidden" value="1" />
            <? }else{?>
            <input name="new" type="submit" class="btn btn-success" value="Initiate Demand Order"  tabindex="12" />
            <input name="flag" id="flag" type="hidden" value="0" />
            <? }?>
            </div>
          <? }elseif($dealer->canceled=='No'){?>
<div class="alert alert-danger row justify-content-center" role="alert">DEALER IS BLOCKED</div>

          <? }else{?>
<div class="alert alert-danger row justify-content-center" role="alert">DEALER NOT FOUND</div>
          <? }?>

  </form>

  <form action="<?=$page?>" method="post" name="codz" id="codz">
    <? if($$unique_master>0){?>
    <table  class="table_input">
      <tr>
       
        <td colspan="10" align="right" bgcolor="#009966" style="text-align:right"><strong>Total Ordering: </strong>
          <?
$total_do = find_a_field($table_detail,'sum(total_amt)',$unique_master.'='.$$unique_master);

?>
          <input type="text" name="do_ordering" id="do_ordering" value="<?=$total_do-($total_do*$dealer->commission/100)?>" style="float:right; width:100px;" disabled="disabled" readonly />
          <input type="hidden" name="do_total" id="do_total" value="<?=$total_do?>" />
          &nbsp;</td>
      </tr>
      <tr>
        <td align="center" width="10%" bgcolor="#0099FF"><strong>Item Code</strong></td>
        <td align="center" bgcolor="#0099FF" width="20%"><strong>Item Name</strong></td>
        <td align="center" bgcolor="#0099FF" width="8%"><strong>In Stk</strong></td>
        <td align="center" bgcolor="#0099FF" width="8%"><strong>UnDel</strong></td>
        <td align="center" bgcolor="#0099FF" width="8%"><strong>Price</strong></td>
        <td align="center" bgcolor="#0099FF" width="8%"><strong>Crt Qty</strong></td>
        <td align="center" bgcolor="#0099FF" width="8%"><strong>Unit</strong></td>
        <td align="center" bgcolor="#0099FF" width="8%"><strong>Qty</strong></td>
        <td align="center" bgcolor="#0099FF" width="8%"><strong>Total</strong></td>
        <td width="8%"  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
            <input name="add" type="button" id="add" value="ADD" onclick="count();insert_item()" class="update" tabindex="5"/>
          </div></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#CCCCCC" width="10%"><span id="inst_no">
          <input name="item" type="text" class="form-control" id="item"  required onblur="grp_check(this.value);" tabindex="1"/>
          </span>
          <input name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>" readonly/>
          <input name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly/>
          <input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
          <input name="depot_id" type="hidden" id="depot_id" value="<?=$depot_id;?>"/>
          <input name="flag" id="flag" type="hidden" value="1" />
          </span>
          <input style="width:10px;"  name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly/></td>
        <td bgcolor="#CCCCCC" colspan="4"><span id="do">
          <table width="100%" border="1" cellspacing="0" cellpadding="0">
           
                <tr>
                <td  bgcolor="#CCCCCC" width="45%"><input name="item2" type="text" id="item2" class="form-control" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('dist_unit')"/></td>
                <td  bgcolor="#CCCCCC" width="18%"><input name="in_stock"  type="text" class="form-control" id="in_stock"  value="<?=$in_stock?>" readonly onfocus="focuson('dist_unit')"/>
                <input name="item_id" type="hidden" class="form-control" id="item_id"  value="<?=$item_all->item_id?>" readonly/></td>
                <td  bgcolor="#CCCCCC" width="18%"><input name="undel" type="text" class="form-control" id="undel" readonly  value="<?=($ordered_qty+$del_qty)?>"/></td>
                <td  bgcolor="#CCCCCC" width="18%"><input name="unit_price" type="text" class="form-control" id="unit_price"  onchange="count()" value="<?=$item_all->d_price?>" />
                <input name="unit_price2" type="hidden" class="form-control" id="unit_price2"  onchange="count()" value="<?=$item_all->d_price?>" />
                <input name="pkt_size" type="hidden" id="pkt_size" class="form-control"  value="<?=$item_all->pack_size?>" readonly/></td>
                </tr>
          </table>
          </span></td>
        <td  bgcolor="#CCCCCC"><input name="pkt_unit" type="text" value="0" readonly  id="pkt_unit" class="form-control" onkeyup="count()" required="required"  tabindex="4"/></td>
        <td  bgcolor="#CCCCCC"><input name="pkt_unit" type="text" value="Pcs" readonly  id="pkt_unit" class="form-control" onkeyup="count()" required="required"  tabindex="4"/></td>
        <td  bgcolor="#CCCCCC"><input name="dist_unit" type="text" id="dist_unit" class="form-control" onkeyup="count()" /></td>
        <td  bgcolor="#CCCCCC"><input name="total_unit" type="hidden" class="form-control" id="total_unit" readonly/>
          <input name="total_amt" type="text" class="form-control" id="total_amt" readonly/></td>
      </tr>
    </table>
    <br />
    <br />
    <br />
    <br />
<div class="tabledesign2"><span id="codzList">
    <? 
$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price as price,a.dist_unit as qty ,a.total_amt,"X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';
echo link_report_add_del_auto($res,'',6);
    ?>
</span></div>
  </form>
  <form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    <table width="100%" border="0">
      <tr>
        <td align="center"><input name="delete"  type="submit" class="btn btn-danger" value="DELETE DO" style="width:100px; font-weight:bold; font-size:12px;color:white; height:38px" />
          <input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/></td>
        <td align="right" style="text-align:right"><input name="confirm" type="submit" class="btn btn-info" value="CONFIRM AND SEND WORK ORDER" style="width:270px; font-weight:bold; font-size:12px; height:38px; color:white; float:right" />
        </td>
      </tr>
    </table>
    <? }?>
  </form>
</div><?php */?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
