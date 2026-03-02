<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Delivery Challan Create';



do_calander('#so_date');



$table_master='sale_do_master';

$table_details='sale_do_details';

 $unique='do_no';






if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];



if($_REQUEST[$unique]>0){

$$unique=$_REQUEST[$unique];

$_SESSION[$unique]=$$unique;}

else

 $$unique = $_SESSION[$unique];







if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:i:s');

		$_POST['status']='PROCESSING';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';
		
		echo '<script>window.location.replace("select_unfinished_do.php")</script>';

}



if(isset($_POST['delete']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['status']='CHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);



		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Order Returned.';

}



if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

	
		
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
		
		
		$YR = date('Y',strtotime($ch_date));
  		$yer = date('y',strtotime($ch_date));
  		$month = date('m',strtotime($ch_date));

  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
   		$cy_id = sprintf("%07d", $ch_cy_id);
   		$chalan_no=''.$yer.''.$month.''.$cy_id;

		//$_POST['job_no'] = $job_no_generate;
		//$_POST['job_id'] = $job_cy_id;
		//$_POST['year'] = $YR;
		

		
		//$chalan_no = next_transection_no($group_for,$ch_date,'sale_do_chalan','chalan_no');
		//$chalan_no = next_transection_no('0',$ch_date,'sale_do_chalan','chalan_no');
		//$gate_pass = next_transection_no('0',$ch_date,'sale_do_chalan','gate_pass');

		
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
 


  $so_invoice = "INSERT INTO `sale_do_chalan` (year, ch_id,  `chalan_no`,  gate_pass,  `chalan_date`, `order_no`, item_name, `bundle_issue`, `do_no`, `do_date`, `job_no`,
 
 
  `delivery_date`, `cbm_no`, `group_for`, `dealer_code`, `buyer_code`, `merchandizer_code`, `destination`, `delivery_place`, `customer_po_no`, `unit_name`, `measurement_unit`,
  
  
   `ply`, `paper_combination_id`, `paper_combination`, `L_cm`, `W_cm`, `H_cm`, `WL`, `WW`, `item_id`, `formula_id`, `formula_cal`, `sqm_rate`, `sqm`, `additional_info`, 
   
   
   `additional_charge`, `final_price`, `unit_price`, pcs_1,bundle_1,pcs_2,bundle_2,pcs_3,bundle_3, `total_unit`, `total_amt`, `style_no`, `po_no`, `referance`, `sku_no`, `printing_info`, `color`, `pack_type`, `size`, `depot_id`, `status`, `entry_by`, `entry_at`, `remarks`, 
   vehicle_type,vehicle_id,vehicle_no,driver_name,driver_mobile,delivery_man,delivery_man_mobile,prepared_by,authorized_by)
  
  VALUES('".$YR."', '".$ch_cy_id."', '".$chalan_no."', '".$chalan_no."',  '".$ch_date."', '".$data->id."', '".$item_name."', '".$bundle_issue."', '".$data->do_no."', '".$data->do_date."', 
  '".$data->job_no."', 
  
  
  
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

    <td width="40%" valign="top"><fieldset style="width:100%;">

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
	  
	  
	   <? $field='customer_po_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">PO/Style No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>

    

  
	  
	  
	   


     

    </fieldset></td>

    <td width="9%">			</td>

    <td width="40%"><fieldset style="width:100%;">
	
	
	
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
	
	


      <div>

        <label style="width:120px;" for="<?=$field?>"> Buyer:</label>

         <input  name="buyer_info2" type="text" id="buyer_info2" value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer_code);?>" required="required"/>

		<input  name="buyer_code" type="hidden" id="buyer_code" value="<?=$buyer_code?>" required="required"/>

      </div>

      <div></div>
 

      <div>

        <label style="width:120px;" for="<?=$field?>">Merchandiser:</label>

        <input  name="merchandizer_code2" type="text" id="merchandizer_code2" value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer_code);?>" required="required"/>

		<input  name="merchandizer_code" type="hidden" id="merchandizer_code" value="<?=$merchandizer_code?>" required="required"/>

      </div>

              

      <div>


      

      </div>

		</fieldset></td>

    <td width="2%">&nbsp;</td>

    <?php /*?><td width="16%" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">

	          

        <tr>

          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>

          <td align="left" bgcolor="#9999CC"><strong>PR</strong></td>

        </tr>

<?

$sql='select distinct pr_no,rec_date from purchase_receive where po_no='.$po_no.' order by id desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99"><?=$aaa->rec_date?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="../pr_fg/chalan_view.php?v_no=<?=$aaa->pr_no?>"><img src="../../images/print.png" width="15" height="15" /></a></td>

        </tr>

<?

}

?>



      </table></td><?php */?>

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

<?php /*?>	<? if($ex<time()){?>

	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">

      <tr>

        <td align="right" bgcolor="#FF0000"><div align="center" style="text-decoration:blink"><strong>THIS PURCHASE ORDER IS EXPIRED</strong></div></td>

        </tr>

    </table>

    <? }?><?php */?>

	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	
	
	<tr  bgcolor="#9999FF">

        <td width="50%" align="right" bgcolor="#9999FF">		</td>
		</tr>
	
	
	

      <tr  bgcolor="#9999FF">

        <td width="50%" align="right" bgcolor="#9999FF">
		
		
		
		<div>

        <label style="width:200px;" >Date:</label>

        <input style="width:220px; height:32px;"  name="so_date" type="text" id="so_date" value="<?=($so_date!='')?$so_date:date('Y-m-d')?>" required="required"/>
      </div>
	  
	  
	  <div>

        <label style="width:200px;" >Vehicle Type:</label>

        <select name="vehicle_type" required id="vehicle_type"  tabindex="7" style="width:220px;" onchange="getData2('vehicle_ajax.php', 'vehicle_filter', this.value,  document.getElementById('vehicle_type').value);">
					
                     <option></option>
                      <? foreign_relation('vehicle_type','id','vehicle_type',$vehicle_type,'1');?>
                    </select>
      </div>
		
		
		
	  
	  
	  <span id="vehicle_filter">
	  
	  <div>

        <label style="width:200px;" >Vehicle:</label>
				
		<select name="vehicle_id" required id="vehicle_id"  tabindex="7" style="width:220px;">
					<option></option>
                      <? foreign_relation('vehicle_registration','vehicle_id','vehicle_name',$vehicle_id,'1');?>
                    </select>
      </div>
		</span>
		
		
		  <span id="vehicle_driver_filter">
		  
		  
		  <div>

        <label style="width:200px;" >Vehicle No: </label>
			
					<input style="width:220px; height:32px;"  name="vehicle_no" type="text" id="vehicle_no" value="<?=$vehicle->registration_no?>" />	
      </div>
	  
	  <div>

        <label style="width:200px;" >Driver Name: </label>
			
					<input style="width:220px; height:32px;"  name="driver_name" type="text" id="driver_name" value="<?=$vehicle->driver_name?>" />	
      </div>
	  
	  <div>

        <label style="width:200px;" >Driver Mobile: </label>
			
					<input style="width:220px; height:32px;"  name="driver_mobile" type="text" id="driver_mobile" value="<?=$vehicle->driver_mobile?>" />	
      </div>
		  </span>		</td>

        <td width="50%" bgcolor="#9999FF">
		
		<div>

        <label style="width:200px;" >Remarks:</label>

        <input style="width:220px; height:32px;"  name="remarks" type="text" id="remarks" value="" />
      </div>
		
		
		<div>

        <label style="width:200px;" >Delivery Man:</label>

        <select name="delivery_man" required id="delivery_man"  tabindex="7" style="width:220px;"
					onchange="getData2('delivery_man_ajax.php', 'delivery_man_filter', this.value,  document.getElementById('delivery_man').value);">
					<option></option>
                      <? foreign_relation('delivery_man','id','delivery_man',$delivery_man,'1');?>
                    </select>
      </div>
		
		
		<div>

        <label style="width:200px;" >Mobile No:</label>

       <span id="delivery_man_filter">
					<input style="width:220px; height:32px;"  name="delivery_man_mobile" type="text" id="delivery_man_mobile" value="" />
					</span>      </div>
		
		
		<div>

        <label style="width:200px;" >Prepared By:</label>

        <select name="prepared_by" required id="prepared_by"  tabindex="7" style="width:220px;">
					
                      <? foreign_relation('prepared_by','id','prepared_by',$prepared_by,'status="Active"');?>
                    </select>
      </div>
		
		
		<div>

        <label style="width:200px;" >Authorized By:</label>

        <select name="authorized_by" required id="authorized_by"  tabindex="7" style="width:220px;">
					
                      <? foreign_relation('authorized_by','id','authorized_by',$authorized_by,'status="Active"');?>
                    </select>
      </div>
	  
	  <div>

        <label style="width:200px;" >Delivery Place:</label>
		
		<select name="delivery_place" required id="delivery_place"  tabindex="7" style="width:220px;">
		<option></option>
          <? foreign_relation('delivery_place_info','id','delivery_place',$delivery_place,'dealer_code="'.$dealer_code.'"');?>
        </select>
		
		
	    <?php /*?><select name="delivery_place" required id="delivery_place"  tabindex="7" style="width:220px;">
          <? foreign_relation('delivery_place_info a, sale_do_details b','b.delivery_place','a.delivery_place',$delivery_place,'a.id=b.delivery_place and a.dealer_code="'.$dealer_code.'" and b.do_no="'.$do_no.'" group by b.delivery_place');?>
        </select><?php */?>
	  </div>		</td>
        </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){

  $sql='select a.id,  a.item_id,  a.unit_price, s.sub_category,  b.item_name,  b.unit_name, a.ply, a.paper_combination, a.L_cm, a.W_cm, a.H_cm, a.measurement_unit,  a.total_unit as qty ,
  a.delivery_place, a.delivery_date, a.style_no, a.po_no, a.destination, a.referance, a.sku_no, a.pack_type, a.color, a.size, b.pack_size from sale_do_details a,item_info b, item_sub_group s where b.item_id=a.item_id 
  and b.sub_group_id=s.sub_group_id and  a.do_no='.$$unique;

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="1%" rowspan="2">SL</th>

            <th width="15%" rowspan="2">Item_Name </th>

            <th width="10%" rowspan="2">Ch_Item_Name</th>
            <th width="3%" rowspan="2"><strong>Style No</strong></th>
            <th width="2%" rowspan="2"><strong>PO No</strong></th>
            <th width="2%" rowspan="2">Destination</th>
            <th width="2%" rowspan="2">Referance</th>
            <th width="2%" rowspan="2"><strong>SKU</strong></th>
            <th width="2%" rowspan="2">Pack Type </th>
            <th width="2%" rowspan="2"><strong>Color</strong></th>
            <th width="2%" rowspan="2"><strong>Size</strong></th>
            <th rowspan="2" bgcolor="#FFFFFF">UOM</th>

            <th rowspan="2" bgcolor="#FFFFFF">Ply</th>
            <th rowspan="2" bgcolor="#FFFFFF">Measurement</th>
            <th rowspan="2" bgcolor="#FFFFFF">Delivery Date </th>
            <th rowspan="2" bgcolor="#FFFFFF">Delivery Place </th>
            <th rowspan="2" bgcolor="#FF99FF">WO Qty </th>

            <th rowspan="2" bgcolor="#009900">Production Qty </th>
            <th rowspan="2" bgcolor="#009900">Challan Qty  </th>

            <th rowspan="2" bgcolor="#FFFF00">Pending </th>

            <th rowspan="2" bgcolor="#F57E22">Challan Issue </th>
            <th colspan="2" bgcolor="#D78AF2">Challan 1 </th>
            <th colspan="2" bgcolor="#BBDFC3">Challan 2 </th>
            <th colspan="2" bgcolor="#6699FF">Challan 3 </th>
            </tr>
          <tr>
            <th bgcolor="#D78AF2">Pcs/Per Bundle </th>
            <th bgcolor="#D78AF2">Qty/ Bundle </th>
            <th bgcolor="#BBDFC3">Pcs/Per Bundle </th>
            <th bgcolor="#BBDFC3">Qty/ Bundle </th>
            <th bgcolor="#6699FF">Pcs/Per Bundle  </th>
            <th bgcolor="#6699FF">Qty/ Bundle </th>
            </tr>
          

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>

              <td><input name="item_name_<?=$row->id?>" type="text" id="item_name_<?=$row->id?>" 
			  value="<?=find_a_field('item_sub_category','item_sub_category','id='.$row->sub_category);?>"  style="width:150px; height:25px; float:none" /></td>
              <td>
			  
		<? 
		  if ($row->style_no!="") {
		  echo $row->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  <? 
		  if ($row->po_no!="") {
		  echo $row->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td><? 
		  if ($row->destination!="") {
		  echo $row->destination;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->referance!="") {
		  echo $row->referance;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td>
			  <? 
		  if ($row->sku_no!="") {
		  echo $row->sku_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td><? 
		  if ($row->pack_type!="") {
		  echo $row->pack_type;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td>
			  
			  <? 
		  if ($row->color!="") {
		  echo $row->color;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  
			   <? 
		  if ($row->size!="") {
		  echo $row->size;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td width="2%" align="center"><?=$row->unit_name?>                </td>

              <td width="1%" align="center"><?=$row->ply?></td>
              <td width="6%" align="center">
			  
			  <? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?>			  </td>
              <td width="4%" align="center"><?php echo date('d-m-Y',strtotime($row->delivery_date));?></td>
              <td width="4%" align="center"><?= find_a_field('delivery_place_info','delivery_place','id='.$row->delivery_place);?></td>
			  
              <td width="2%" align="center"><?=number_format($row->qty,2);?></td>

              <td width="4%" align="center"><? echo number_format($production_qty = (find_a_field('sale_do_production_issue','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>
              <td width="4%" align="center"><? echo number_format($so_qty = (find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>

              <td width="4%" align="center"><? 
			  
			   $pr_ch_pending = $production_qty-$so_qty;
			  
			  echo number_format($unso_qty=($row->qty-$so_qty),2);?>

                <input type="hidden" name="unso_qty_<?=$row->id?>" id="unso_qty_<?=$row->id?>" value="<?=$pr_ch_pending?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>

              <td width="6%" align="center" bgcolor="#F57E22">
			   <? if($unso_qty>0){$cow++;?>

          <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value=""  style="width:80px; height:25px; float:none"  onKeyUp="calculation_1(<?=$row->id?>)" />
		  <input name="pack_size_<?=$row->id?>" type="hidden" id="pack_size_<?=$row->id?>" value="<?=$row->pack_size;?>"  style="width:80px; height:25px; float:none"  />
		  
		  <input name="sum_chalan_<?=$row->id?>" type="hidden" id="sum_chalan_<?=$row->id?>" value=""  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

                <? } else echo 'Done';?>			  </td>
              <td width="5%" align="center" bgcolor="#D78AF2">
			  <? if($unso_qty>0){$cow++;?>

                <input name="pcs_1_<?=$row->id?>" type="text" id="pcs_1_<?=$row->id?>" value=""  style="width:60px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

                <? } else echo 'Done';?>			  </td>
              <td width="5%" align="center" bgcolor="#D78AF2">
			    <? if($unso_qty>0){$cow++;?>

                <input name="bundle_1_<?=$row->id?>" type="text" id="bundle_1_<?=$row->id?>" value=""  style="width:60px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

                <? } else echo 'Done';?>			  </td>
              <td width="5%" align="center" bgcolor="#BBDFC3">
			  
			   <? if($unso_qty>0){$cow++;?>

                <input name="pcs_2_<?=$row->id?>" type="text" id="pcs_2_<?=$row->id?>" value=""  style="width:60px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

                <? } else echo 'Done';?>			  </td>
              <td width="5%" align="center" bgcolor="#BBDFC3">
			   <? if($unso_qty>0){$cow++;?>

                <input name="bundle_2_<?=$row->id?>" type="text" id="bundle_2_<?=$row->id?>" value=""  style="width:60px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

                <? } else echo 'Done';?>			  </td>
              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center">
			  <? if($unso_qty>0){$cow++;?>

                <input name="pcs_3_<?=$row->id?>" type="text" id="pcs_3_<?=$row->id?>" value=""  style="width:60px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

                <? } else echo 'Done';?>			  </td>
              <td width="9%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($unso_qty>0){$cow++;?>

                <input name="bundle_3_<?=$row->id?>" type="text" id="bundle_3_<?=$row->id?>" value=""  style="width:60px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

                <? } else echo 'Done';?></td>
              </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /> <br />
  

  
  
  
  
	
	<br />
  

<table width="100%" border="0">

<? if($cow<1){

$vars['status']='COMPLETED';

db_update($table_master, $do_no, $vars, 'do_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  WORK ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="submit" class="btn1" value="CANCEL WO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn1" value="CONFIRM CHALLAN" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";


?>