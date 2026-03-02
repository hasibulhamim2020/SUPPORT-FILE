<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Bundle Card Create';



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

		$_POST['status']='MANUAL';

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

		$bc_date=$_POST['so_date'];
		
		$remarks=$_POST['remarks'];

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		

		
		
		$bc_no = next_transection_no($group_for,$bc_date,'sale_do_bundle_card','bc_no');

		
		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);

		 $sql = 'select * from sale_do_details where  do_no = '.$do_no;

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysqli_fetch_object($query))

		{
	

			if($_POST['chalan_'.$data->id]>0 || $_POST['issue_'.$data->id]>0)

			{
			
				$bundle_issue=$_POST['issue_'.$data->id];

				$qty=$_POST['chalan_'.$data->id];

				$rate=$_POST['rate_'.$data->id];

				$item_id =$_POST['item_id_'.$data->id];

				
				$amount = ($qty*$rate); 
				
				
				
				$full_pack_no = (int)($bundle_issue/$qty);
				for($i=1;$i<=$full_pack_no;$i++)
				{
				//echo $i.' - '.$bundle_size;
				
				
				 


  $so_invoice = "INSERT INTO `sale_do_bundle_card` ( `bundle_no`, `bc_no`, `bc_date`, `order_no`, `bundle_issue`, `do_no`, `do_date`, `job_no`,
 
 
  `delivery_date`, `cbm_no`, `group_for`, `dealer_code`, `buyer_code`, `merchandizer_code`, `destination`, `delivery_place`, `customer_po_no`, `unit_name`, `measurement_unit`,
  
  
   `ply`, `paper_combination_id`, `paper_combination`, `L_cm`, `W_cm`, `H_cm`, `WL`, `WW`, `item_id`, `formula_id`, `formula_cal`, `sqm_rate`, `sqm`, `additional_info`, 
   
   
   `additional_charge`, `final_price`, `unit_price`, `total_unit`, `total_amt`, `style_no`, `po_no`, `referance`, `sku_no`, `printing_info`, `color`, `pack_type`, `size`, `depot_id`, `status`, `entry_by`, `entry_at`, `remarks`)
  
  VALUES('".$i."', '".$bc_no."',  '".$bc_date."', '".$data->id."', '".$bundle_issue."', '".$data->do_no."', '".$data->do_date."', '".$data->job_no."', 
  
  
  
   '".$data->delivery_date."', '".$data->cbm_no."', '".$data->group_for."' , '".$data->dealer_code."',  '".$data->buyer_code."',  '".$data->merchandizer_code."',
    '".$data->destination."', '".$data->delivery_place."', '".$data->customer_po_no."',  '".$data->unit_name."',
    '".$data->measurement_unit."',
	
	
	  '".$data->ply."', '".$data->paper_combination_id."', '".$data->paper_combination."', 
     
  '".$data->L_cm."','".$data->W_cm."','".$data->H_cm."','".$data->WL."',  '".$data->WW."', 
   '".$item_id."', '".$data->formula_id."', '".$data->formula_cal."', '".$data->sqm_rate."', '".$data->sqm."', '".$data->additional_info."', 
   
   
   '".$data->additional_charge."', 
   '".$data->final_price."', '".$rate."', '".$qty."','".$amount."', 
   '".$data->style_no."', '".$data->po_no."', '".$data->referance."', '".$data->sku_no."', '".$data->printing_info."', '".$data->color."', '".$data->pack_type."', 
   '".$data->size."',  '".$data->depot_id."', 'CHECKED','".$entry_by."', '".$entry_at."', '".$remarks."'   )";

db_query($so_invoice);


}



				$last_pack_size = ($bundle_issue%$qty);
				//echo $i.' - '.$last_pack_size;
				
				$amount2 = ($last_pack_size*$rate); 
				
			if ($last_pack_size>0) {	
				
	$so_invoice2 = "INSERT INTO `sale_do_bundle_card` ( `bundle_no`, `bc_no`, `bc_date`, `order_no`, `bundle_issue`, `do_no`, `do_date`, `job_no`,
 
 
  `delivery_date`, `cbm_no`, `group_for`, `dealer_code`, `buyer_code`, `merchandizer_code`, `destination`, `delivery_place`, `customer_po_no`, `unit_name`, `measurement_unit`,
  
  
   `ply`, `paper_combination_id`, `paper_combination`, `L_cm`, `W_cm`, `H_cm`, `WL`, `WW`, `item_id`, `formula_id`, `formula_cal`, `sqm_rate`, `sqm`, `additional_info`, 
   
   
   `additional_charge`, `final_price`, `unit_price`, `total_unit`, `total_amt`, `style_no`, `po_no`, `referance`, `sku_no`, `printing_info`, `color`, `pack_type`, `size`, `depot_id`, `status`, `entry_by`, `entry_at`, `remarks`)
  
  VALUES('".$i."', '".$bc_no."',  '".$bc_date."', '".$data->id."', '".$bundle_issue."', '".$data->do_no."', '".$data->do_date."', '".$data->job_no."', 
  
  
  
   '".$data->delivery_date."', '".$data->cbm_no."', '".$data->group_for."' , '".$data->dealer_code."',  '".$data->buyer_code."',  '".$data->merchandizer_code."',
    '".$data->destination."', '".$data->delivery_place."', '".$data->customer_po_no."',  '".$data->unit_name."',
    '".$data->measurement_unit."',
	
	
	  '".$data->ply."', '".$data->paper_combination_id."', '".$data->paper_combination."', 
     
  '".$data->L_cm."','".$data->W_cm."','".$data->H_cm."','".$data->WL."',  '".$data->WW."', 
   '".$item_id."', '".$data->formula_id."', '".$data->formula_cal."', '".$data->sqm_rate."', '".$data->sqm."', '".$data->additional_info."', 
   
   
   '".$data->additional_charge."', 
   '".$data->final_price."', '".$rate."', '".$last_pack_size."','".$amount2."', 
   '".$data->style_no."', '".$data->po_no."', '".$data->referance."', '".$data->sku_no."', '".$data->printing_info."', '".$data->color."', '".$data->pack_type."', 
   '".$data->size."',  '".$data->depot_id."', 'CHECKED','".$entry_by."', '".$entry_at."', '".$remarks."'   )";

db_query($so_invoice2);


}


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

function calculation(id){

var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);
var bc_qty=((document.getElementById('issue_'+id).value)*1);



 if(bc_qty>pending_qty)
  {
alert('Can not issue more than pending quantity.');
document.getElementById('issue_'+id).value='';
document.getElementById('chalan_'+id).value='';


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

        <td colspan="3" align="center" bgcolor="#CCFF99"><strong> Entry Information</strong></td>

      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        

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

      <tr>

        <td width="21%" align="right" bgcolor="#9999FF"><strong> Date:</strong></td>

        <td width="15%" bgcolor="#9999FF"><strong>

          <input style="width:120px; height:25px;"  name="so_date" type="text" id="so_date" value="" required="required"/>

         
        </strong></td>

        <td width="17%" bgcolor="#9999FF"><div align="right"><strong>Remarks:</strong></div></td>
        <td width="47%" bgcolor="#9999FF">
			<input style="width:250px; height:25px;"  name="remarks" type="text" id="remarks" value=""/>		</td>
      </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){

  $sql='select a.id,  a.item_id,  a.unit_price,  b.item_name,  b.unit_name, a.ply, a.paper_combination, a.L_cm, a.W_cm, a.H_cm,  a.total_unit as qty, a.measurement_unit from sale_do_details a,item_info b where b.item_id=a.item_id and  a.do_no='.$$unique;

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th width="3%">SL</th>

            <th width="22%">Item Name </th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th bgcolor="#FFFFFF">Ply</th>
            <th bgcolor="#FFFFFF">Paper Combination</th>
            <th bgcolor="#FFFFFF">Measurement</th>
            <th bgcolor="#FF99FF">WO Qty </th>

            <th bgcolor="#009900">Bundle Qty  </th>

            <th bgcolor="#FFFF00">Pending </th>

            <th bgcolor="#0099CC">Bundle Issue </th>
            <th bgcolor="#0099CC">Bundle Size </th>
          </tr>
          

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>

              <td width="3%" align="center"><?=$row->unit_name?>                </td>

              <td width="2%" align="center"><?=$row->ply?></td>
              <td width="27%" align="center"><?=$row->paper_combination?></td>
              <td width="15%" align="center"><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?> </td>
              <td width="8%" align="center"><?=number_format($row->qty,2);?></td>

              <td width="9%" align="center"><? echo number_format($so_qty = (find_a_field('sale_do_bundle_card','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>

              <td width="5%" align="center"><? echo number_format($unso_qty=($row->qty-$so_qty),2);?>

                <input type="hidden" name="unso_qty_<?=$row->id?>" id="unso_qty_<?=$row->id?>" value="<?=$unso_qty?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>

              <td width="6%" align="center" bgcolor="#6699FF" style="text-align:center">
			  <? if($unso_qty>0){$cow++;?>

                <input name="issue_<?=$row->id?>" type="text" id="issue_<?=$row->id?>" value=""  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

                <? } else echo 'Done';?>
			  
			  </td>
              <td width="6%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($unso_qty>0){$cow++;?>

                <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value=""  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

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

<? 

		 $wo_qty = find_a_field('sale_do_details','sum(total_unit)','do_no='.$$unique);
		 $issue_qty = find_a_field('sale_do_bundle_card','sum(total_unit)','do_no='.$$unique);


if($issue_qty>=$wo_qty){

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  WORK ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="submit" class="btn1" value="CANCEL WO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn1" value="CONFIRM BUNDLE CARD" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

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