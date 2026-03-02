<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Delivery Challan Create';



do_calander('#chalan_date');



$table_master='sale_do_master';

$table_details='sale_do_details';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

 $unique='do_no';



//if($_REQUEST['do_no']>0)
//$$unique=$_REQUEST['do_no'];
//elseif(isset($_GET['del']))
//{$$unique=find_a_field($table_chalan,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];}
//else
//$$unique=$_REQUEST[$unique];



if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];



if($_REQUEST[$unique]>0){

$$unique=$_REQUEST[$unique];

$_SESSION[$unique]=$$unique;}

else

 $$unique = $_SESSION[$unique];


if($_GET['mhafuz']>0)
unset($_SESSION['chalan_no']);




if(isset($_POST['confirm']))

{

		unset($_POST);
		unset($_SESSION['chalan_no']);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='UNCHECKED';

		$crud   = new crud($table_chalan);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';
		
		echo '<script>window.location.replace("select_wo_for_challan.php")</script>';

}



if(isset($_POST['delete']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['status']='MANUAL';

		$crud   = new crud($table_master);

		$crud->update($unique);



		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Order Returned.';

}





if(isset($_POST['add'])&&($_POST[$unique]>0))


{



		$_POST['entry_at']=date('Y-m-d H:i:s');


		$_POST['entry_by']=$_SESSION['user']['id'];
		
		
		$group_for = $_SESSION['user']['group'];
		
		if($_POST['unit_name']=="Pcs"){
		$_POST['total_amt']=$_POST['unit_price']*$_POST['total_unit'];
		}else {
		    $_POST['total_amt']=$_POST['unit_price']*$_POST['bag_size'];
		}
if($_SESSION['chalan_no']>0)
$_POST['chalan_no'] = $_SESSION['chalan_no'];
else
$_SESSION['chalan_no'] = $_POST['chalan_no'] = next_transection_no($group_for,$_POST['chalan_date'],'sale_do_chalan','chalan_no');

		$table		=$table_chalan;


		$crud      	=new crud($table);

		$_POST['status'] = 'MANUAL';
		
$pr_found_id = $_POST['pr_order_no'];

 $found = find_a_field('sale_do_chalan','pr_order_no','pr_order_no='.$pr_found_id);
 
 if ($found==0) {

		$xid = $crud->insert();
		
		
		 $ins_id = db_insert_id();
		 
		 
		 if($ins_id>0)

		{

		
			journal_item_control($_POST['item_id'], $_POST['depot_id'], $_POST['chalan_date'],  0, $_POST['total_unit'], 'Sales', $ins_id, $_POST['unit_price'], $_POST['depot_id'], $_POST['chalan_no'],
			 $_POST['bag_size'], $_POST['bag_unit'],$_POST['group_for'], $_POST['final_avg_price'], $_POST['barcode']);
		
		}
		
		
		
		 $upr_sql = 'update production_receive_detail set status="SOLD OUT" where id = '.$pr_found_id;
		 db_query($upr_sql);
		

		

}

}

else

{


	$type=0;


	$msg='Data Re-Submit Error!';


}





if($_GET['del']>0)

{	
		$del=$_GET['del'];
		
		$pr_order_no = find_a_field('sale_do_chalan','pr_order_no','id='.$del);
		
		 $upr_sql = 'update production_receive_detail set status="RECEIVED" where id = '.$pr_order_no;
		 db_query($upr_sql);

 		$del_ch_sql = "delete from sale_do_chalan where id = '".$del."'";
		db_query($del_ch_sql);

		 $del_ji_sql = "delete from journal_item where tr_from = 'Sales' and tr_no = '".$del."'";
		db_query($del_ji_sql);

		$type=1;

		$msg='Successfully Deleted.';

}









if(prevent_multi_submit()){



if(isset($_POST['confirmmmmm'])){

	
		
		$group_for = $_POST['group_for'];

		$ch_date=$_POST['so_date'];
		
		$remarks=$_POST['remarks'];
		$delivery_place=$_POST['delivery_place'];
		
		$vehicle_type=$_POST['vehicle_type'];
		$vehicle_id=$_POST['vehicle_id'];
		
		$vehicle_no=$_POST['vehicle_no'];
		$driver_name=$_POST['driver_name'];
		
		$driver_mobile=$_POST['driver_mobile'];


		$delivery_man=$_POST['delivery_man'];
		$delivery_man_mobile=$_POST['delivery_man_mobile'];
		
		$prepared_by=$_POST['prepared_by'];
		$authorized_by=$_POST['authorized_by'];


		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		

		
		
		//$chalan_no = next_transection_no($group_for,$ch_date,'sale_do_chalan','chalan_no');
		
		$chalan_no = next_transection_no('0',$ch_date,'sale_do_chalan','chalan_no');
		
		$gate_pass = next_transection_no('0',$ch_date,'sale_do_chalan','gate_pass');

		
		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);

		 $sql = 'select * from sale_do_details where  do_no = '.$do_no;

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysqli_fetch_object($query))

		{
	

			if($_POST['chalan_'.$data->id]>0)

			{
			
				$pcs_1=$_POST['pcs_1_'.$data->id];
				$bundle_1=$_POST['bundle_1_'.$data->id];
				
				$pcs_2=$_POST['pcs_2_'.$data->id];
				$bundle_2=$_POST['bundle_2_'.$data->id];

				$pcs_3=$_POST['pcs_3_'.$data->id];
				$bundle_3=$_POST['bundle_3_'.$data->id];

				$qty=$_POST['chalan_'.$data->id];

				$rate=$_POST['rate_'.$data->id];

				$item_id =$_POST['item_id_'.$data->id];
				
				$item_name =$_POST['item_name_'.$data->id];

				
				$amount = ($qty*$rate); 
 


  $so_invoice = "INSERT INTO `sale_do_chalan` (  `chalan_no`, gate_pass,  `chalan_date`, `order_no`, item_name, `bundle_issue`, `do_no`, `do_date`, `job_no`,
 
 
  `delivery_date`, `cbm_no`, `group_for`, `dealer_code`, `buyer_code`, `merchandizer_code`, `destination`, `delivery_place`, `customer_po_no`, `unit_name`, `measurement_unit`,
  
  
   `ply`, `paper_combination_id`, `paper_combination`, `L_cm`, `W_cm`, `H_cm`, `WL`, `WW`, `item_id`, `formula_id`, `formula_cal`, `sqm_rate`, `sqm`, `additional_info`, 
   
   
   `additional_charge`, `final_price`, `unit_price`, pcs_1,bundle_1,pcs_2,bundle_2,pcs_3,bundle_3, `total_unit`, `total_amt`, `style_no`, `po_no`, `referance`, `sku_no`, `printing_info`, `color`, `pack_type`, `size`, `depot_id`, `status`, `entry_by`, `entry_at`, `remarks`, 
   vehicle_type,vehicle_id,vehicle_no,driver_name,driver_mobile,delivery_man,delivery_man_mobile,prepared_by,authorized_by)
  
  VALUES( '".$chalan_no."', '".$gate_pass."',  '".$ch_date."', '".$data->id."', '".$item_name."', '".$bundle_issue."', '".$data->do_no."', '".$data->do_date."', '".$data->job_no."', 
  
  
  
   '".$data->delivery_date."', '".$data->cbm_no."', '".$data->group_for."' , '".$data->dealer_code."',  '".$data->buyer_code."',  '".$data->merchandizer_code."',
    '".$data->destination."', '".$delivery_place."', '".$data->customer_po_no."',  '".$data->unit_name."',
    '".$data->measurement_unit."',
	
	
	  '".$data->ply."', '".$data->paper_combination_id."', '".$data->paper_combination."', 
     
  '".$data->L_cm."','".$data->W_cm."','".$data->H_cm."','".$data->WL."',  '".$data->WW."', 
   '".$item_id."', '".$data->formula_id."', '".$data->formula_cal."', '".$data->sqm_rate."', '".$data->sqm."', '".$data->additional_info."', 
   
   
   '".$data->additional_charge."', 
   '".$data->final_price."', '".$rate."', '".$pcs_1."', '".$bundle_1."', '".$pcs_2."', '".$bundle_2."', '".$pcs_3."', '".$bundle_3."', '".$qty."', '".$amount."', 
   '".$data->style_no."', '".$data->po_no."', '".$data->referance."', '".$data->sku_no."', '".$data->printing_info."', '".$data->color."', '".$data->pack_type."', 
   '".$data->size."',  '".$data->depot_id."', 'UNCHECKED','".$entry_by."', '".$entry_at."', '".$remarks."' ,
    '".$vehicle_type."', '".$vehicle_id."', '".$vehicle_no."', '".$driver_name."', '".$driver_mobile."', '".$delivery_man."', '".$delivery_man_mobile."', '".$prepared_by."', '".$authorized_by."'  )";

db_query($so_invoice);






}

}



		//if($ch_no>0)
//		{
//		auto_insert_sales_chalan_secoundary($ch_no);
//		}


//$ji_sql = "select a.id, a.so_no, a.so_date, a.item_id, a.group_for, a.group_for_to, a.warehouse_id, a.warehouse_to, w.pl_id, a.unit_price as unit_price, a.qty, a.unit_name, a.total_amt from spare_parts_sale_order a, item_info b, warehouse w where b.item_id=a.item_id and a.warehouse_to=w.warehouse_id and a.so_no='".$so_no."' ORDER by a.id ";
//
//$ji_query = db_query($ji_sql);	
//
//		while($data_ji=mysqli_fetch_object($ji_query))
//
//		{
//
//journal_item_control($data_ji->item_id,$data_ji->warehouse_id, $data_ji->so_date, 0, $data_ji->qty, 'Store Sales', $data_ji->id, $data_ji->unit_price, $data_ji->warehouse_to, $so_no, '','', '', '','',$data_ji->group_for,'');
//
//
//journal_item_control($data_ji->item_id,$data_ji->warehouse_to, $data_ji->so_date,  $data_ji->qty,  0,'Store Sales', $data_ji->id, $data_ji->unit_price, $data_ji->warehouse_id, $so_no, '','', '', '','',$data_ji->group_for,'');
//		
//		
//
//
//journal_item_control($data_ji->item_id,$data_ji->warehouse_to, $data_ji->so_date,  0, $data_ji->qty,'Consumption', $data_ji->id, $data_ji->unit_price, $data_ji->pl_id, $so_no, '','', '', '','',$data_ji->group_for_to,'');
//		
//		
//journal_item_control($data_ji->item_id,$data_ji->pl_id, $data_ji->so_date, $data_ji->qty, 0,  'Consumption', $data_ji->id, $data_ji->unit_price, $data_ji->warehouse_to, $so_no, '','', '', '','',$data_ji->group_for_to,'');
//
//		
//		}
//		
//		
//	

	

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

//if($delivery_within>0)
//{
//	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);
//}







?>


<script>



function calculation_1(id){

var unso_qty=((document.getElementById('unso_qty_'+id).value)*1);

var chalan=((document.getElementById('chalan_'+id).value)*1);
var pack_size=((document.getElementById('pack_size_'+id).value)*1);

if (chalan>=pack_size)  {

var pcs_1=(document.getElementById('pcs_1_'+id).value)=pack_size;
var bundle_1=(document.getElementById('bundle_1_'+id).value)=parseInt(chalan/pack_size);

var pcs_2=(document.getElementById('pcs_2_'+id).value)= chalan - (pcs_1*bundle_1);


var bundle_2_cal=pcs_2;

if (bundle_2_cal < 1) {
  bundle_2_qty = 0;
} else {
  bundle_2_qty = 1;
}

var bundle_2=(document.getElementById('bundle_2_'+id).value)=bundle_2_qty;

}


if (chalan<pack_size)  {
var pcs_1=(document.getElementById('pcs_1_'+id).value)=chalan;
var bundle_1=(document.getElementById('bundle_1_'+id).value)=1;

var pcs_2=(document.getElementById('pcs_2_'+id).value)=0;
var bundle_2=(document.getElementById('bundle_2_'+id).value)=0;


}

//alert(bundle_2);


 if(chalan>unso_qty)
  {
alert('Can not issue more than pending quantity.');
document.getElementById('chalan_'+id).value='';
document.getElementById('pcs_1_'+id).value='';
document.getElementById('bundle_1_'+id).value='';

document.getElementById('pcs_2_'+id).value='';
document.getElementById('bundle_2_'+id).value='';

document.getElementById('pcs_3_'+id).value='';
document.getElementById('bundle_3_'+id).value='';

document.getElementById('sum_chalan_'+id).value='';

  } 



}




function calculation(id){

var chalan=((document.getElementById('chalan_'+id).value)*1);
var pcs_1=((document.getElementById('pcs_1_'+id).value)*1);
var bundle_1=((document.getElementById('bundle_1_'+id).value)*1);
var pcs_2=((document.getElementById('pcs_2_'+id).value)*1);
var bundle_2=((document.getElementById('bundle_2_'+id).value)*1);
var pcs_3=((document.getElementById('pcs_3_'+id).value)*1);
var bundle_3=((document.getElementById('bundle_3_'+id).value)*1);

var sum_chalan=(document.getElementById('sum_chalan_'+id).value)=(pcs_1*bundle_1)+(pcs_2*bundle_2)+(pcs_3*bundle_3);

var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);




 if(sum_chalan>chalan)
  {
alert('Can not issue more than pending quantity.');
document.getElementById('pcs_1_'+id).value='';
document.getElementById('bundle_1_'+id).value='';

document.getElementById('pcs_2_'+id).value='';
document.getElementById('bundle_2_'+id).value='';

document.getElementById('pcs_3_'+id).value='';
document.getElementById('bundle_3_'+id).value='';

document.getElementById('sum_chalan_'+id).value='';

  } 



//if (pp_bag >0) {
//	var pp_qty= document.getElementById('pp_qty_'+id).value= (bag_size*pp_bag);
//	var hdpe_bag= document.getElementById('hdpe_bag_'+id).value= (pp_bag/3);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (pp_bag+hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (pp_qty+hdpe_qty);
//} else if((pp_bag ==0)) {
//	var hdpe_bag=((document.getElementById('hdpe_bag_'+id).value)*1);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (hdpe_qty);
//}
//
//var wastage_starting=((document.getElementById('wastage_starting_'+id).value)*1);
//var wastage_on_process=((document.getElementById('wastage_on_process_'+id).value)*1);
//var total_wastage= document.getElementById('total_wastage_'+id).value= (wastage_starting+wastage_on_process);
//var net_total_qty= document.getElementById('net_total_qty_'+id).value= (total_qty-total_wastage);


}

</script>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td width="37%" valign="top"><fieldset style="width:100%;">

    <? $field='do_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">WO  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      </div>

    <? $field='do_date';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">WO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>
	  
	  
	  
	 
	  
	   <? $field='job_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">Job No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>
	  
	
    

  
	  
	  
	   


     

    </fieldset></td>

    <td width="8%">			</td>

    <td width="35%"><fieldset style="width:100%;">
	
	
	
	<? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Company:</label>

        <input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" style="width:200px;" />

		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required="required"/>

      </div>
	  
	  
	  <div>

        <label style="width:120px;" for="<?=$field?>"> Customer:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" required="required"/>

		<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>" required="required"/>

      </div>
	
	


      

      <div></div>
 

      

              

		</fieldset></td>

    <td width="0%">&nbsp;</td>

    <td width="20%" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; font-weight:700;">

	          

        <tr>

          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>

          <td align="left" bgcolor="#9999CC"><strong>Challan No </strong></td>

        </tr>

<?
 
$sql='select distinct chalan_no, chalan_date from sale_do_chalan where do_no='.$$unique.' order by id desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99" style="font-size:12px; font-weight:700; color:#000000" ><?php echo date('d-m-Y',strtotime($aaa->chalan_date));?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" style="font-size:12px; font-weight:700; color:#000000" href="sales_invoice_print_view.php?v_no=<?=$aaa->chalan_no?>"><?=$aaa->chalan_no?></a></td>

        </tr>

<?

}

?>



      </table></td>

  </tr>

  <tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="4" align="center" bgcolor="#CCFF99"><strong> Entry Information</strong></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        

        <td rowspan="2" align="left" bgcolor="#CCFF99"><a title="WO Preview" target="_blank" href="work_order_print_view.php?v_no=<?=$$unique?>" ><img src="../../../images/print.png" alt="" width="30" height="30" /></a></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created On:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=$entry_at?></td>
        </tr>

    </table></td>

  </tr>

  <tr>

    <td colspan="5" valign="top">



	</td>

    </tr>

</table>

</form>



<? if($$unique>0){


?>

<form action="" method="post" name="codz" id="codz" >
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">


<tr>
	<td>
	
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	
	
	
	

      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right" bgcolor="#9966FF"><strong>Chalan Date:
			  <? $ch_data = find_all_field('sale_do_chalan','','chalan_no='.$_SESSION['chalan_no']);?>
			  </strong></td>
              <td align="left" bgcolor="#9966FF"><strong>
                <input style="width:140px;"  name="chalan_date" type="text" id="chalan_date" required="required" value="<?=($ch_data->chalan_date!='')?$ch_data->chalan_date:date('Y-m-d')?>"/>
              </strong></td>
              <td align="right" bgcolor="#9966FF"><strong>Delivery Man:</strong></td>
              <td align="left" bgcolor="#9966FF"><strong>
                <input style="width:140px;"  name="delivery_man" type="text" value="<?=$ch_data->delivery_man;?>" id="delivery_man" />
              </strong></td>
              <td bgcolor="#9966FF" align="right"><strong>Delivery Man Mobile:</strong></td>
              <td bgcolor="#9966FF"><strong>
                <input style="width:140px;"  name="delivery_man_mobile" value="<?=$ch_data->delivery_man_mobile;?>"  type="text" id="delivery_man_mobile" />
              </strong></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#9999FF"><strong>Vehicale No:</strong></td>
              <td bgcolor="#9999FF"><strong>
                <input style="width:140px;"  name="vehicle_no" type="text" id="vehicle_no" value="<?=$ch_data->vehicle_no;?>" />
                </strong></td>
              <td align="right" bgcolor="#9999FF"><strong>Driver Name: </strong></td>
              <td bgcolor="#9999FF"><strong>
                <input style="width:140px;"  name="driver_name" type="text" id="driver_name" value="<?=$ch_data->driver_name;?>"  />
                </strong></td>
              <td align="right" bgcolor="#9999FF"><strong>Driver mobile:</strong> </td>
              <td bgcolor="#9999FF"><strong>
                <input style="width:140px;"  name="driver_mobile"  type="text" id="driver_mobile" value="<?=$ch_data->driver_mobile;?>" />
              </strong></td>
            <td>&nbsp;</td>
            </tr>
           
          </table></td>
      </tr>
    </table>
	</td>

</tr>



    <tr>

      <td><div class="tabledesign2">

      <table  width="96%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">


    <tr>
      <td width="16%" align="right" bgcolor="#0099FF"><div align="left"><strong>Item Name</strong></div></td>
      
      <td width="52%" align="right" bgcolor="#0099FF">
	  <table  width="100%" border="1" align="left"  cellpadding="2" cellspacing="2">
		<tr>
		    <td align="right" bgcolor="#0099FF">Unit</td>
			<td width="19%"><strong>Size</strong></td>
			<td width="9%"><strong>GSM</strong></td>
			<td width="12%"><strong>Colour</strong></td>
			<td width="17%"><strong>Print Name</strong></td>
			<td width="12%"><strong>Order Qty</strong></td>
			<td width="11%"><strong>Pending</strong></td>
		    <td width="20%"><strong>Barcode</strong></td>
		</tr>
	</table>	  </td>
      <td width="20%" align="center" bgcolor="#0099FF">
	  
	  <table  width="100%" border="1" align="left"  cellpadding="2" cellspacing="2">
		<tr>
			<td width="50%"><strong>Qty in Pcs</strong></td>
			<td width="50%"><strong>Qty in KG</strong></td>
			
		</tr>
	</table>
	  
	  </td>
      <td width="12%"  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
        
        
        <input name="add" type="submit" id="add" value="ADD" tabindex="12" style="width:80px" class="update"/>
        
        
      </div></td>
    </tr>
    
    


  <tr>


    <td align="center" bgcolor="#CCCCCC">


    <input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>


    <input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>


    <input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
	
	 <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
	
	 <input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>"/>


      <input  name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date?>"/>
	  
	    <input  name="barcode_type" type="hidden" id="barcode_type" value="<?=$barcode_type?>"/>


     <?php /*?> <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:500px; height:40px; font-size:18px;" required="required" onblur="getData2('production_receive_ajax.php', 'pr', this.value, document.getElementById('pr_no').value+'=>'+document.getElementById('bag_type').value);"/><?php */?>
	  
	  
	  <select id="order_no" name="order_no" required  style="width:200px;" onchange="getData2('wo_data_ajax.php', 'wo_data_filter', this.value);" >
	  <option></option>
	  
	 <? 
	 
	 
	  $sql = 'select order_no, sum(total_unit) as total_unit,sum(bag_size) as bag_size  from sale_do_chalan
		  where  do_no="'.$$unique.'" group by order_no ';
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $total_unit[$info->order_no]=$info->total_unit;
		}
		

    $itm_sql='select s.id,s.unit_name,s.unit_name,concat(i.item_name," - [Order ID: ",s.id, "]") as order_item, s.total_unit as order_qty, s.qty_kg as qty_kg
   from item_info i, sale_do_details s
   where i.item_id=s.item_id and s.do_no="'.$$unique.'"';
   
	$itm_query = db_query($itm_sql);
	while($itm_dt=mysqli_fetch_object($itm_query)){ 
	
	
	if($itm_dt->unit_name=="Pcs"){
	if ($itm_dt->order_qty>$total_unit[$itm_dt->id]) {
	?>
	<option value="<?=$itm_dt->id;?>"><?=$itm_dt->order_item;?></option>  
	  
	<?  }  ?>
		  
		 <? } else { ?> 
		  <option value="<?=$itm_dt->id;?>"><?=$itm_dt->order_item;?></option>  
<? } } ?>
        </select>	   </td>
        
        
        


    <td align="center" bgcolor="#CCCCCC">
	<span id="wo_data_filter">
	
	<table  width="100%" border="1" align="left"  cellpadding="2" cellspacing="2">
		<tr>
		    
		    <td align="center" bgcolor="#CCCCCC">
           <input  name="unit_name" type="text" id="unit_name" value="<?=$unit_name?>" style="width:30px;height:30px; font-size:14px;" /> 
        </td>
			<td><input  name="size" type="text" id="size" value="<?=$size?>" style="width:130px;height:30px; font-size:14px;" /></td>
			<td><input  name="gsm" type="text" id="gsm" value="<?=$gsm?>" style="width:60px;height:30px; font-size:14px;" /></td>
			<td><input  name="colour" type="text" id="colour" value="<?=$colour?>" style="width:80px;height:30px; font-size:14px;" /></td>
			<td><input  name="print_name" type="text" id="print_name" value="<?=$print_name?>" style="width:120px;height:30px; font-size:14px;" /></td>
			<td><input  name="order_qty" type="text" id="order_qty" value="<?=$order_qty?>" style="width:80px;height:30px; font-size:14px;" /></td>
			<td><input  name="pending_qty" type="text" id="pending_qty" value="<?=$pending_qty?>" style="width:70px;height:30px; font-size:14px;" /></td>
		    <td>
			<select id="barcode_id" name="barcode_id" required  style="width:150px;" >
	  		<option></option>

        	<? foreign_relation('production_receive_detail','id','barcode',$barcode_id,'do_no="'.$$unique.'" and status in("RECEIVED","PURCHASE RECEIVED")'); ?>
        	</select>			</td>
		</tr>
	</table>
	</span></td>
    <td align="center" bgcolor="#CCCCCC">
	  <span id="pr_weight_filter">
	  
	  <table  width="100%" border="1" align="left"  cellpadding="2" cellspacing="2">
		<tr>
			<td width="50%"><input name="total_unit" type="text" class="input3" id="total_unit"   maxlength="100" style="width:80px;height:30px; font-size:18px;" required="required" onKeyUp="count()" onBlur="count()"/></td>
			<td width="50%"><input name="bag_size" type="text" class="input3" id="bag_size"   maxlength="100" style="width:70px;height:30px; font-size:18px;" required="required" onKeyUp="count()" onBlur="count()"/></td>
		</tr>
	</table>
	 </span>	 	</td>
    </tr>
</table>

      </div>

      </td>

    </tr>

  </table>
  

<br />

<? 

    $res='select  s.sub_group_name,  b.item_name, a.*
   from sale_do_chalan a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id  and a.chalan_no="'.$_SESSION['chalan_no'].'" order by a.id desc';
   

?>

<div  class="tabledesign2">

<table width="103%" border="0" cellspacing="0" cellpadding="0">

<tr>

<th width="1%" rowspan="2">SL</th>

<th width="14%" rowspan="2">Item Name</th>
<th width="2%" rowspan="2">Unit</th>

<th width="16%" rowspan="2">Size</th>
<th width="2%" rowspan="2">GSM</th>
<th width="24%" colspan="8"><div align="center">Colour</div></th>
<th width="5%" rowspan="2">Print Name </th>
<th width="5%" rowspan="2">U-Price</th>
<th width="4%" rowspan="2">Qty(kg)</th>
<th width="4%" rowspan="2">Qty(Pcs)</th>
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

<td><?=$data->unit_name?></td>

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
<td><?=$data->bag_size?></td>
<td><?=$data->total_unit?></td>
<td><?=$data->total_amt?></td>
<td><a href="?del=<?=$data->id?>&chalan_no=<?=$data->chalan_no?>&do_no=<?=$$unique?>">X</a></td>
</tr>

<? 

$total_quantity = $total_quantity + $data->total_unit;

$total_amount = $total_amount + $data->total_amt;


} ?>

<tr>

<td colspan="5"><div align="right"><strong> Grand Total:</strong></div></td>

<td colspan="9">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><strong><?=number_format($total_quantity,2);?></strong></td>
<td><strong><?=number_format($total_amount,2);?></strong></td>
<td>&nbsp;</td>
</tr>




</table>

</div>

  
  
  </form>
  
  <form action="?" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<br />
  

<table width="100%" border="0">

<? if($cow==1){

$vars['status']='COMPLETED';

db_update($table_master, $do_no, $vars, 'do_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  WORK ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>
	
	

<tr>

<td align="center"><!--<input name="delete" type="submit" class="btn1" value="CANCEL WO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />-->

<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn1" value="CONFIRM CHALLAN" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>



</table>

<? } }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";


?>