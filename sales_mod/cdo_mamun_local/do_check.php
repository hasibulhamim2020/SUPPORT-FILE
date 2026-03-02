<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Demand Order Create Corporate';

$tr_type="Show";

do_calander('#est_date');

$page = 'do.php';

if($_POST['dealer']>0) 

$dealer_code = $_POST['dealer'];

$do_no 		= $_REQUEST['do_no'];



$table_master='sale_do_master';

$unique_master='do_no';



$table_detail='sale_do_details';

$unique_detail='id';







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

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['entry_by']=$_SESSION['user']['id'];

		if($_POST['flag']<1){

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
		$tr_type="Add";
		}
		

}



if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{

		$table		=$table_detail;

		$crud      	=new crud($table);

		$_POST['gift_on_order'] = $crud->insert();

		$do_date = date('Y-m-d');

		$_POST['gift_on_item'] = $_POST['item_id'];





		$sss = "select * from sale_gift_offer where item_id='".$_POST['item_id']."' and start_date<='".$do_date."' and end_date>='".$do_date."' and group_for=''";

		$qqq = db_query($sss);

		while($gift=mysqli_fetch_object($qqq)){

		

		if($gift->dealer_code!='') 

		{

		$dealers = explode(',',$gift->dealer_code);

		if(!in_array($_POST['dealer_code'],$dealers))

		$not_found = 1;

		else

		$not_found = 0;

		}

		if($not_found==0){

		if($gift->item_qty>0)

		{

			$_POST['gift_id'] = $gift->id;

			$gift_item = find_all_field('item_info','','item_id="'.$gift->gift_id.'"');

			$_POST['item_id'] = $gift->gift_id;

			

			if($gift->gift_id== 1096000100010239)

			{

				$_POST['unit_price'] = (-1)*($gift->gift_qty);

				$_POST['total_amt']  = (((int)($_POST['total_unit']/$gift->item_qty))*($_POST['unit_price']));

				$_POST['total_unit'] = (((int)($_POST['total_unit']/$gift->item_qty)));

				

				$_POST['dist_unit'] = $_POST['total_unit'];

				$_POST['pkt_unit']  = '0.00';

				$_POST['pkt_size']  = '1.00';

				$_POST['t_price']   = '-1.00';

				$crud->insert();

			}

			elseif($gift->gift_id== 1096000100010312)

			{

				$_POST['unit_price'] = (-1)*($gift->gift_qty);

				$_POST['total_amt']  = (((int)($_POST['total_unit']/$gift->item_qty))*($_POST['unit_price']));

				$_POST['total_unit'] = (((int)($_POST['total_unit']/$gift->item_qty)));

				

				$_POST['dist_unit'] = $_POST['total_unit'];

				$_POST['pkt_unit']  = '0.00';

				$_POST['pkt_size']  = '1.00';

				$_POST['t_price']   = '-1.00';

				$crud->insert();

			}

			else

			{

			$_POST['unit_price'] = '0.00';

			$_POST['total_amt'] = '0.00';

			$_POST['total_unit'] = (((int)($_POST['total_unit']/$gift->item_qty))*($gift->gift_qty));

			

			$_POST['dist_unit'] = ($_POST['total_unit']%$gift_item->pack_size);

			$_POST['pkt_unit'] = (int)($_POST['total_unit']/$gift_item->pack_size);

			$_POST['pkt_size'] = $gift_item->pack_size;

			$_POST['t_price'] = '0.00';

			$crud->insert();

			}

		//unset($_POST['gift_id']);

		//unset($_POST['gift_on_order']);

		//unset($_POST['gift_on_item']);

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

		$next_del = find_a_field($table_detail,$unique_detail,'gift_on_order = '.$del);

		$crud   = new crud($table_detail);

		$condition=$unique_detail."=".$del;		

		$crud->delete_all($condition);

		if($next_del>0)

		{

			$condition=$unique_detail."=".$next_del;		

			$crud->delete_all($condition);

		}

		$type=1;

		$msg='Successfully Deleted.';

}



if($$unique_master>0)

{

		$condition=$unique_master."=".$$unique_master;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}







$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

		if($dealer->product_group!='M') $dgp = $dealer->product_group;



auto_complete_start_from_db('item_info','concat(finish_goods_code,"#>",item_name)','finish_goods_code','product_nature="Salable" order by finish_goods_code ASC','item');
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

  document.getElementById("remarks").focus();

  else

  document.getElementById("item").focus();

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

$sql_i='select finish_goods_code from item_info where sales_item_type like "%'.$dealer->product_group.'%" and product_nature="Salable"';

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

getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$dealer->depot.'<#>'.$dealer->dealer_code;?>');

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

                                <input  name="do_no" type="text" id="do_no" 

	  value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>

    

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">



                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delaer name</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                               <select id="dealer_code" name="dealer_code" readonly="readonly">

								<option value="<?=$dealer->dealer_code;?>"><?=$dealer->dealer_name_e.'-'.$dealer->dealer_code;?></option>

								</select>

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depot</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <select id="depot_id2" name="depot_id2"  class="from-control" readonly="readonly">

									<option value="<?=$dealer->depot;?>">

									  <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>

									  </option>

								  </select>



                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Address</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <textarea name="delivery_address" id="delivery_address" ><? if($delivery_address!='') echo $delivery_address; else echo $dealer->address_e?></textarea>



                            </div>

                        </div>



                    </div>







                </div>



                <!--Right form-->

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="container n-form2">

						<div class="form-group row m-0 pb-1">



                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order Date</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <input  name="do_date" type="text"  id="do_date" value="<?=date('Y-m-d')?>" readonly="readonly"/>

                            </div>

                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Ref PO NO</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input  name="ref_no" type="text"  id="ref_no"  value="<?=$ref_no?>"/>

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">



                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">CO Discount</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <input  name="sp_discount"  type="text" id="sp_discount" value="<?=$sp_discount?>"\/>

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <input name="remarks" type="text" id="remarks" value="<?=$remarks?>" tabindex="10" />



                            </div>

                        </div>



                    </div>







                </div>





            </div>



            <div class="n-form-btn-class">

                <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Update Requsition Information" tabindex="6">

            </div>

        </div>



        <!--return Table design start-->

		

		

		

        <div class="container-fluid pt-5 p-0 ">

		<? if($$unique_master>0){?>

            <div class="d-flex justify-content-center">

			

			

				<table border="1" align="center" cellpadding="0" cellspacing="0">

			

			  <tbody>

			  		<tr>

			

						<td colspan="3" align="center"><strong>Entry Information</strong></td>

			

					</tr>

			

			  <tr>

			

					<td align="right"> Entry By:</td>

				

					<td align="left">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

				<?
	  	$d_amount=find_a_field('sale_do_details','d_amount','do_no='.$do_no);
	   if($d_amount > 0) { ?>

					<td rowspan="2" align="center" class="p-2"><a href="sales_order_print_view_mamun_2.php?do_no=<?=$do_no?>" target="_blank"><i class="fas fa-print " style="color:black;"></i></td>
					
					<? } else { ?>
					
					<td rowspan="2" align="center" class="p-2"><a href="sales_order_print_view_mamun.php?do_no=<?=$do_no?>" target="_blank"><i class="fas fa-print " style="color:black;"></i></td>
					
					<? } ?>

			

			  </tr>

			

			  <tr>

			

					<td align="right">Entry On:</td>

				

					<td align="left">&nbsp;&nbsp;<?=$entry_at?></td>

			

			</tr>

			

			</tbody></table>

	

		</div>



        </div>

    </form>









    <form action="" method="post" name="cloud" id="cloud">

        <!--Table input one design-->

        <div class="container-fluid pt-5 p-0 ">





            <table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">

                    <th>S/L</th>

                    <th>Code</th>

                    <th>Item Name</th>



                    <th>Unit Price</th>

                    <th>Qty</th>



                    <th>Total Amount</th>

                    <th>Action</th>

                </tr>

                </thead>



                <tbody class="tbody1">



                	<? 

					$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price,a.sale_rate,a.sale_qty,a.pkt_unit as crt_qty,a.dist_unit as pcs ,a.total_amt,"X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';

					$i=1;

					$query=db_query($res);

					while($data=mysqli_fetch_object($query)){

					

					?>

                <tr>

                    <td><?=$i++?></td>

                    <td><?=$data->code?></td>

					<td style="text-align:left"><?=$data->item_name?></td>

					<td><?=$data->sale_rate?></td>

					<td><?=$data->sale_qty?></td>

					<td><?=$data->total_amt; $total_amount+=$data->total_amt;?></td>

                    <td><a href="?del=<?=$data->id?>"><button type="button" class="btn2 btn1-bg-cancel"><i class="fa-solid fa-trash"></i></button></a></td>



                </tr>

					<? } ?>

					

					 <tr>

                    <td align="center" colspan="3">Total</td>

                    

					<td align="center"><?=number_format($total_crt,2)?></td>

					<td></td>

					<td align="center"><?=number_format($total_amount,2)?></td>

					<td></td>

                    



                </tr>



                </tbody>

            </table>











        </div>





        <!--Data multi Table design start-->

        

    </form>



    <!--button design start-->

    <form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

        <div class="container-fluid p-0 ">



            <div class="n-form-btn-class">

							

				   <input name="return"  type="submit" class="btn1 btn1-bg-update" value="RETURN TO USER" onclick="return_function()" />

				   <input  name="do_no" type="hidden" id="do_no" value="<?=$do_no?>"/><input type="hidden" name="return_remarks" id="return_remarks">

				 

				   <input name="cancel"  type="submit" class="btn1 btn1-bg-cancel" value="CANCEL" />

				 

				 <input type="button" class="btn1 btn1-bg-cancel" value="CLOSE" onclick="window.location.href='select_uncheck_do.php'" /></td>

			

				  <input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD SO" />

	 

                

            </div>



        </div>

    </form>



<? } ?>



</div>



















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

require_once SERVER_CORE."routing/layout.bottom.php";

?>