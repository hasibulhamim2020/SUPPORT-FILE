<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Retail Sales';

$page_for = 'Retail Sales';

$default_direct_sales_party=2;



//$din = find_a_field('menu_warehouse','local_purchase','id="'.$_SESSION['user']['group'].'"');

//if($din>0){$din=$din;}else{$din=60;}



do_calander('#do_date'/*,'-"'.$din.'"','0'*/);
do_calander('#delivery_date'/*,'-"'.$din.'"','0'*/);




$table_master='sale_do_master';

$table_details='sale_do_details';

$unique='do_no';



if($_REQUEST['pal']>0){ unset($_SESSION['do_no2']);}



if($_REQUEST['old_do_no']>0){

    $_SESSION['do_no2']=$_REQUEST['old_do_no'];

    $check_manual=find1("select status from sale_do_master where do_no='".$_REQUEST['old_do_no']."'");

    if($check_manual!='MANUAL') { redirect('do.php?pal=2');}

}

if($_GET['del']>0){

    $_SESSION['do_no2']=find_a_field('sale_do_details','do_no','id='.$_GET['del']); $del = $_GET['del'];

}







if(isset($_POST['new']))

{

		$crud   = new crud($table_master);



		if(!isset($_SESSION['do_no2'])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		

		$_POST['warehouse_id'] =  $_SESSION['user']['depot'];

		$_POST['issue_type'] =  'Direct Sales';

		$$unique=$_SESSION['do_no2']=$crud->insert();

		unset($$unique);

		$type=1;

		$msg=$title.'  No Created. (No :-'.$_SESSION['do_no2'].')';

		?><script>window.location.href = "do.php?old_do_no=<?=$_SESSION['do_no2']?>";</script><?

		    

		} else {

		    

		$_POST['issue_type'] =  'Direct Sales';

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['warehouse_id'] =  $_SESSION['user']['depot'];

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}



$$unique=$_SESSION['do_no2'];









if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		$crud   = new crud($table_details);

		$condition=$unique."=".$$unique;		

		$crud->delete_all($condition);

		unset($$unique);

		unset($_SESSION['do_no2']);

		$type=1;

		$msg='Successfully Deleted.';

		?><script>window.location.href = "do.php?pal=2";</script><?

		

}



if($_GET['del']>0){

		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

		?><script>window.location.href = "do.php?old_do_no=<?=$_SESSION['do_no2']?>";</script><?

}

if($_GET['c_del']>0){

		$crud   = new crud('sales_collection');

		$condition="id=".$_GET['c_del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

		?><script>window.location.href = "do.php?old_do_no=<?=$_SESSION['do_no2']?>";</script><?

}





if(isset($_POST['hold'])){

    

		unset($$unique);

		unset($_SESSION['do_no2']);

		$type=1;

		$msg='Successfully Forwarded.';

		redirect('do.php?pal=2');

		

}

if(isset($_POST['collection'])){
$ncrd= new crud('sales_collection');
$_POST['do_no']=$_GET['old_do_no'];
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d');

$ncrd->insert();
}





if(isset($_POST['confirmm'])){

        

	$do_no = $_POST['do_no'];

	$master_info=findall("select * from sale_do_master where do_no='".$do_no."'");



		$page_for       = 'Direct Sales';

		$jv_no          = next_journal_sec_voucher_id();

        $jv_date        = $_POST['do_date'];

        $proj_id        = 'mep'; 

        $_POST['warehouse_id'] =  $_SESSION['user']['depot'];

        $group_for      =  $_SESSION['user']['group'];

        $cc_code        = '1';

        $tr_no          = $do_no;

        $tr_from        = 'Direct Sales';

        $narration      = 'Direct Sales#'.$do_no.'.Party:'.$master_info->customer_name;

        $narration_coll = 'Direct Sales Collection#'.$do_no.'.Party:'.$master_info->customer_name;

        $narration2     = 'Collection From Direct Sales#'.$do_no.'. Party:'.$master_info->customer_name;



// BIN CARD		

$sql = 'select w.* from sale_do_details w, item_info i 

    where i.item_id=w.item_id and w.do_no="'.$do_no.'"';

	$qry = db_query($sql);

	

	while($data=mysqli_fetch_object($qry)){

		$tr_id = $data->id;

journal_item_control($data->item_id,$_SESSION['user']['depot'],$data->do_date,0,$data->qty,$page_for,$tr_id,'66','',$do_no, '', '','', '', '');
		


        $total_amt +=$data->amount;

	}







// ##################################### ACCOUNTS

// #####################################

// dr. head (PARTY HEAD)

$party_ledger_id = find1("select account_code from dealer_info where dealer_code='".$_POST['dealer_code']."'");



// dr. cash discount head

$discount_ledger = find_a_field('config_group_class','direct_sales_dis','group_for="'.$group_for.'"');

        

// cr. head (Direct Sales)

$dsLedger = find_a_field('config_group_class','directSales','group_for="'.$group_for.'"');



$product_total  =$_POST['product_total'];

$discount_amt   =$master_info->discount_amt;

$payable_amt    =$_POST['payable_amt'];

$collection     =find_a_field('sales_collection','sum(amount)','do_no="'.$do_no.'"');

//$collection     =$_POST['collection'];





$sql_upp="update sale_do_master set product_total='".$product_total."',discount_amt='".$discount_amt."',payable_amt='".$payable_amt."',collection='".$collection."'

where do_no='".$do_no."'";

db_query($sql_upp);

add_to_sec_journal2($proj_id, $jv_no, $jv_date, $party_ledger_id, $narration, $payable_amt,'0',  $tr_from, $tr_no,'',$tr_id,$cc_code,$group);

if($discount_amt>0) {

add_to_sec_journal2($proj_id, $jv_no, $jv_date, $discount_ledger, $narration, $discount_amt,'0',  $tr_from, $tr_no,'',$tr_id,$cc_code,$group);

}

add_to_sec_journal2($proj_id, $jv_no, $jv_date, $dsLedger,        $narration, '0',$product_total,  $tr_from, $tr_no,'',$tr_id,$cc_code,$group);



// #####################################  Collection journal  ##############################

// ##################################### 

  

// dr. head

$depot_ledger_id = find_a_field('warehouse','cash_ledger','warehouse_id="'.$_SESSION['user']['depot'].'"');

$cSql='select * from sales_collection where do_no="'.$do_no.'"';
$cQuery=db_query($cSql);
while($cRow=mysqli_fetch_object($cQuery)){
add_to_sec_journal2($proj_id, $jv_no, $jv_date, $cRow->ledger_id, $narration_coll, $cRow->amount,'0',  'ds_collection', $tr_no,'',$tr_id,$cc_code,$group);
}
// cr. head direct sales party

add_to_sec_journal2($proj_id, $jv_no, $jv_date, $party_ledger_id, $narration_coll, '0',$collection,  'ds_collection', $tr_no,'',$tr_id,$cc_code,$group); 

 









$check_auto_journal_verify=find1("select secondary_approval from voucher_config where voucher_type='Direct Sales'");

	if($check_auto_journal_verify=='Yes'){

	    sec_journal_journal2($jv_no,$jv_no,$tr_from);

	}



		unset($_POST);

		$_POST[$unique]         =$$unique;

		$_POST['entry_by']      =$_SESSION['user']['id'];

		$_POST['entry_at']      =date('Y-m-d H:i:s');

		$_POST['status']        ='CHECKED';

		

$bill_no=$_SESSION['do_no2'];		

		$crud = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION['do_no2']);

		$type=1;

		$msg='Successfully Forwarded.';



    redirect('direct_sales_status.php?bill_no='.$bill_no);

    

} // end confirm

if(isset($_POST['disAdd'])&&($_POST[$unique]>0)){


$crud   = new crud($table_master);
		$crud->update($unique);
		?><script>window.location.href = "do.php?old_do_no=<?=$_SESSION['do_no2']?>";</script><?
}







if(isset($_POST['add'])&&($_POST[$unique]>0)){

    

		$crud = new crud($table_details);

		$_POST['tp']=$_POST['unit_price'];
		
		if($_POST['discount']>0){

		$_POST['unit_price']= $_POST['unit_price']-(($_POST['discount']/100)*$_POST['unit_price']);

		}else{
		$_POST['unit_price']=$_POST['tp'];
		
		}
		
		

	
		$_POST['total_unit']=$_POST['total_unit'];

		$_POST['total_amt']=$_POST['total_amt'];
		
		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['warehouse_id'] =  $_SESSION['user']['depot'];

		$_POST['issue_type'] = 'Direct Sales';

		$xid = $crud->insert();

        ?><script>window.location.href = "do.php?old_do_no=<?=$_SESSION['do_no2']?>";</script><?

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update'; else $btn_name='Initiate';

if($_SESSION['do_no2']<1)

$$unique=db_last_insert_id($table_master,$unique);



?>

<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}

window.onload = function() {

if(document.getElementById("warehouse_id").value>0)

  document.getElementById("item_id").focus();

  else

  document.getElementById("req_date").focus();

}

</script>











<!--Mr create 2 form with table-->

<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">

<!--        top form start hear-->

        <div class="container-fluid">

            <div class="row">

                

                

            <!--left form-->

                <div class="col-md-4">

                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">

						<? $field='do_no';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">NO</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

								 <? $field='do_date'; if($do_date=='') $do_date =date('Y-m-d'); ?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

             

       						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly" required/>

	  

                            </div>

                        </div>

                        

                        

<!--<input type="hidden" class="form-control" name="dealer_code" id="dealer_code" required="required" value="<?=$default_direct_sales_party?>" autocomplete="off">                        -->

                       

                       

<div class="form-group row m-0 pb-1">

<? $field='dealer_code';?>

<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

<? if ($dealer_code<1) {?>

    <input class="form-control" list="party_list" name="dealer_code" id="dealer_code" required="required" autocomplete="off" onChange="getPartyinfo()">

    <datalist id="party_list">

    <option></option>

    <? 

    $sql_party='select dealer_code,concat(dealer_name_e," ",contact_no) from dealer_info where 1 and dealer_type=1 and account_code>0 '.$party_con;

    foreign_relation_sql($sql_party);

    ?>

    </datalist>



<? }else{?>

    

    <select class="form-control" name="dealer_code" class="form-control"  required  >

     <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'dealer_code="'.$dealer_code.'"');?>

    </select>

<? }?>
<div class="col-2  p-0 pr-2" >
	<a href="<?=$input_page?>" rel = "gb_page_center[1240, 600]"><button name="insert" accesskey="S" class="btn btn-primary" type="button">Add</button></a>
	</div>
</div>

</div>

                        





</div>

</div>



            <!--Center form-->

            <div class="col-md-4">

                

				<div class="form-group row m-0 pb-1">

					<? $field='customer_name';?>

                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Name</label>

                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

 						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>

                    </div>

                </div>  

                

				<div class="form-group row m-0 pb-1">

					<? $field='customer_mobile';?>

                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Party Mobile</label>

                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

 						 <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>

                    </div>

                </div>  

                

				<div class="form-group row m-0 pb-1">

					<? $field='customer_address';?>

                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Party Address</label>

                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

 						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>

                    </div>

                </div>     

 
                

            </div>  <!--end row-->       

               

               

            <!--Right form-->

            <div class="col-md-4">

                    <div class="container n-form2">


                        <div class="form-group row m-0 pb-1">

						<? $field='remarks';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

      

       						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      

                            </div>

                        </div>
						
						
						<div class="form-group row m-0 pb-1">

						<? $field='delivery_date';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Date</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

      

       						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      

                            </div>

                        </div>

                        

                        <!--<div class="form-group row m-0 pb-1">

						<? $field='customer_bin';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">BIN NO</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

      

       						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      

                            </div>

                        </div>

                        <div class="form-group row m-0 pb-1">

						<? $field='customer_nid';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">NID NO</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

      

       						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      

                            </div>

                        </div> -->                       

                        

                        

                        <!--<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <select  id="group_for" name="group_for" required>

			   						<? if($group_for>0){ foreign_relation('user_group','id','company_short_code',$group_for,'1 and id="'.$group_for.'"'); }

			   						else{ ?><option></option><? 

			   						    foreign_relation('user_group','id','company_short_code',$group_for,'1 and status=1');}

			   						?>

            					</select>

                            </div>

                        </div>-->                         

                        

                        

                        

                        

                        



                    </div>







                </div>

                







            </div>



            <div class="n-form-btn-class">

                <input name="new" type="submit" value="<?=$btn_name?>" class="btn1 btn1-bg-submit"  tabindex="6">

				

				

				

            </div>

        </div>



		

        

    </form>



<div class="row">

    <div class=""></div>

</div>





<? if($_SESSION['do_no2']>0){?>

	<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

        <!--Table input one design-->

        <div class="container-fluid">





            <table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">

                    <th>Item Code</th>

                    <th width="30%">Item Description</th>

                    <th>Unit</th>

                    <th>Rate</th><th>Dis%</th><th>Qty</th><th>Value</th><th>Action</th>

                </tr>

                </thead>



<tbody class="tbody1">



<tr>

<td>

<input list="items" name="item_id" type="text" class="input3"  value="" id="item_id" style="width:90%; height:30px;" onChange="getData()" autocomplete="off" autofocus/>

 <datalist id="items">

  <?php optionlist('select item_id,concat(finish_goods_code," # ",item_name) from item_info where 1 order by item_name');?>

 </datalist>



<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />

<input type="hidden" id="do_date" name="do_date" value="<?=$do_date?>"  />

<input type="hidden" id="dealer_code" name="dealer_code" value="<?=$dealer_code?>"  />

</td>





<td><input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name"  /></td>

<td><input  name="unit_name" type="text"  id="unit_name" value="" readonly="readonly"/></td>

<td><input  name="unit_price" type="text"  id="tp" value="" onkeyup="count()" required/></td>



<td><input type="number" min="0" max="0" step="0.01" name="discount" id="dis_per" value="" onkeyup="count()"/></td>



<td><input  name="total_unit" type="text"  id="qty" value="" onkeyup="count()" required/></td>



<td><input name="total_amt" type="text"  id="amount" readonly/></td>

<td><input name="add" type="submit" id="add" value="ADD" class="btn1 btn1-bg-submit" /></td>



</tr>



</tbody>

</table>



</div>



<!--Data multi Table design start-->

        <div class="container-fluid pt-5 p-0 ">



			<table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">

                    <th>S/L</th>

                    <th>Item Code</th>

                    <th>Item Name</th>

                    <th>TP</th>
					
					<th>Dis%</th>
					
					<th>Price</th>

                    <th>Qty</th>

                    <th>Unit Name</th>

					<th>Amount</th>

                    <th>X</th>

                </tr>

                </thead>

<tbody class="tbody1">

<? 

$res='select a.*,"x" , b.finish_goods_code

from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$do_no;

//echo link_report_add_del_auto($res,'2','5');



$qry = db_query($res);

$s=1;

while($data=mysqli_fetch_object($qry)){

?>

		<tr>

		    <td><?=$s++?></td>

            <td><?=$data->finish_goods_code?></td>

            <td><?=$data->item_name?></td>

            <td><?=$data->tp ?></td>
			
			<td><?=$data->discount?></td>
			
			<td><?=$data->unit_price?></td>

            <td><?=$data->total_unit; $gqty+=$data->total_unit;?></td>

			<td><?=$data->unit_name?></td>

            <td><?=$data->total_amt; $gtotal+=$data->total_amt;?></td>

            <td><a href="?del=<?=$data->id?>"> X </a></td>



        </tr>

<? } ?>

		<tr style="font-weight:bold;">

		    <td colspan="6" style="text-align:right;">Total</td>

		    

		    <td><?=$gqty?></td>

		    <td></td>

		    <td><?=$gtotal?></td>

		</tr>



                </tbody>

            </table>



        </div>

    </form>
	<hr />
	
	<div>
	<input class="form-control border border-success" name="product_total" type="hidden" id="product_total" value="<?=$gtotal;?>" readonly/>

<div class="form-group row mt-2">

    <label for="inputEmail3" class="col-sm-8 col-form-label"></label> 

    <label for="inputEmail3" class="col-sm-2 col-form-label">Special Discount</label>

    <div class="col-sm-2">

<form method="post">
	  <div class="input-group mb-2">
  <input name="discount" type="text" value="<?=$discount?>" id="discount_amt"class="form-control"  aria-label="Recipient's username" aria-describedby="basic-addon2" onkeyup="count_discount()">
  <input type="hidden" name="do_no" value="<?=$_GET['old_do_no']?>"/>
  <div class="input-group-append">
    <button class="btn btn-success" type="submit" name="disAdd">Add</button>
  </div>
</div>
</form>
    </div> 

</div> 

<div class="form-group row">

    <label for="inputEmail3" class="col-sm-8 col-form-label"></label> 

    <label for="inputEmail3" class="col-sm-2 col-form-label">Payable Amount</label>

    <div class="col-sm-2">

	  <input class="form-control border border-success" name="payable_amt" type="text" id="payable_amt" value="<?=$gtotal-$discount;?>" readonly/>

    </div> 

</div> 
	</div>
	
	<form method="post">
<table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">

                    <th>Collection Ledger</th>
					 <th>Narration</th>
                    <th>Amount</th>
                  <th>Action</th>

                </tr>

                </thead>



<tbody class="tbody1">




<tr>

<td>

<input list="lgr" name="ledger_id" type="text" class="input3"  value="" id="ledger_id" style="width:90%; height:30px;" required autocomplete="off" autofocus/>

 <datalist id="lgr">

  <?php optionlist('select ledger_id,concat(ledger_id," # ",ledger_name) from accounts_ledger where 1 order by ledger_id');?>

 </datalist>


</td>





<td><input name="narration" type="text" class="input3"  autocomplete="off" id="narration"  /></td>

<td><input  name="amount" type="text"  id="amounts" required onkeyup="valCal()"/></td>



<td><input name="collection" type="submit" id="add" value="ADD" class="btn1 btn1-bg-submit" /></td>



</tr>



</tbody>

</table>
</form>

	<hr />
	
	<div class="container-fluid pt-5 p-0 ">



			<table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">

                    <th>S/L</th>

                    <th>Ledger name</th>

                    <th>Narration</th>

					<th>Amount</th>

                    <th>X</th>

                </tr>

                </thead>

<tbody class="tbody1">

<? 

$res='select c.*,a.ledger_name from sales_collection c,accounts_ledger a where c.ledger_id=a.ledger_id and c.do_no='.$do_no;

//echo link_report_add_del_auto($res,'2','5');



$qry = db_query($res);

$s=1;

while($data=mysqli_fetch_object($qry)){

?>

		<tr>

		    <td><?=$s++?></td>
			
			<td><?=$data->ledger_name?></td>
			
			<td><?=$data->narration?></td>
			
			<td><?=$data->amount?></td>

            <td><a href="?c_del=<?=$data->id?>"> X </a></td>



        </tr>

<? $totA+=$data->amount; } ?>

		<tr style="font-weight:bold;">

		    <td colspan="3" style="text-align:right;">Total</td>

		    <td id="acTotal"><?=$totA?></td>

		</tr>



                </tbody>

            </table>



        </div>



<!--button design start-->

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">







<?php /*?><div class="form-group row">

    <label for="inputEmail3" class="col-sm-7 col-form-label"></label>

    <label for="inputEmail3" class="col-sm-3 col-form-label">Collection</label>

    <div class="col-sm-2">

	  <input class="form-control border border-info" name="collection" type="text" id="collection" value="" onkeyup="check_collection()" autocomplete="off" required/>

    </div> 

</div><?php */?> 

<? //} ?>        

        

        

        <div class="container-fluid p-0 ">



            <div class="n-form-btn-class">

				<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />

                <input type="hidden" id="do_date" name="do_date" value="<?=$do_date?>"  />

                <input type="hidden" id="dealer_code" name="dealer_code" value="<?=$dealer_code?>"  />

                <!--<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />-->

                

                <input name="delete" type="submit" class="btn1 btn-danger" value="DELETE" />

                <input name="hold" type="submit" class="btn1 btn-info" value="HOLD" /> 
				
				<? if($gtotal-$discount_amt>=$totA){?>

                <input name="confirmm" type="submit" id="confirm_button" class="btn1 btn1-bg-submit" value="CONFIRM" />
				
				<? }else{?>
			<div class="alert alert-danger mt-2" role="alert">
 				 Check Again your Amount
			</div>
				
				<? }?>

            </div>



        </div>

    </form>

<? }?>

</div>

















<script>$("#codz").validate();$("#cloud").validate();</script>



<script language="javascript">

function count(){



    if(document.getElementById('tp').value!=''){

    var rate = ((document.getElementById('tp').value)*1);

    var dis_per = ((document.getElementById('dis_per').value));

    var qty = ((document.getElementById('qty').value)*1);

        if(dis_per>0){

        var amount = (document.getElementById('amount').value) = qty*(((100-dis_per)/100)*rate);

        }else {

        var amount = (document.getElementById('amount').value) = qty*rate;   

        }

    }

}







function count_discount(){

    

    var product_total = document.getElementById("product_total").value;

    var discount_amt = document.getElementById("discount_amt").value;

    var payable_amt = (document.getElementById('payable_amt').value) = product_total-discount_amt;

    document.getElementById('collection').value='';

    //document.getElementById("confirm_button").style.display = "none";

    

}



//document.getElementById("confirm_button").style.display = "none";



function check_collection(){

    var payable_amt = document.getElementById("payable_amt").value;

    var collection = document.getElementById("collection").value;

    

    if(payable_amt==collection){

        //document.getElementById("confirm_button").style.display = "";

    }else{

        //document.getElementById("confirm_button").style.display = "none";

    }

    

    

}

</script>





<script>



function getPartyinfo(){



var dealer_code = document.getElementById("dealer_code").value;


		jQuery.ajax({

			url:'ajax_party_info.php',

			type:'post',

			data:'dealer_code='+dealer_code,

			success:function(result){

				var json_data=jQuery.parseJSON(result);



				jQuery('#customer_name').val(json_data.customer_name);

				jQuery('#customer_mobile').val(json_data.customer_mobile);

				jQuery('#customer_address').val(json_data.customer_address);



			}



		})   

    

}



function getData(){

    

var id = document.getElementById("item_id").value;



		jQuery.ajax({

			url:'ajax_price.php',

			type:'post',

			data:'id='+id,

			success:function(result){

				var json_data=jQuery.parseJSON(result);



				jQuery('#item_name').val(json_data.item_name);

				jQuery('#unit_name').val(json_data.unit);

				jQuery('#tp').val(json_data.price);

				jQuery('#dis_per').attr('max',json_data.direct_per);

				jQuery('#dis_per').val(json_data.direct_per);

				jQuery('#amount').val('');

				jQuery('#qty').val('');



			}



		})

	

}

function valCal(){

var totAmt=$('#acTotal').html()*1;

var now=$('#payable_amt').val();

var current=$('#amounts').val()*1;

var check= current+totAmt;

if(check>now){
alert('limit');

$('#amounts').val('');
}
}


</script>  


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>