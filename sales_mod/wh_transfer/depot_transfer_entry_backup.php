<?php

session_start();

ob_start();

require "../../support/inc.all.php";

$title='Warehouse to warehouse Transfer';



do_calander('#pi_date','-15','0');

do_calander('#old_production_date');

$page = 'depot_transfer_entry.php';

if($_POST['line_id']>0) 

$line_id = $_SESSION['line_id']=$_POST['line_id'];

elseif($_SESSION['line_id']>0) 

$line_id = $_POST['line_id']=$_SESSION['line_id'];





$table_master='warehouse_transfer_master';

$unique_master='pi_no';



$table_detail='warehouse_transfer_detail';

$unique_detail='id';







if($_SESSION[$unique_master]>0)

$$unique_master=$_SESSION[$unique_master];

elseif(isset($_GET['del']))

{

$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];

}

else

$$unique_master=$_REQUEST[$unique_master];



if(prevent_multi_submit()){

if(isset($_POST['new']))

{

		$crud   = new crud($table_master);

		$_POST['entry_at']=date('Y-m-d H:i:s');

		 $_POST['entry_by']=$_SESSION['user']['id'];
		
		$_POST['status']='MANUAL';

		if($_POST['flag']<1){

		$$unique_master=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Product Issued. (PI No-'.$$unique_master.')';

		}

		else {

		$crud->update($unique_master);

		$type=1;

		$msg='Successfully Updated.';

		}

}



if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{

		$table		=$table_detail;

		$crud      	=new crud($table);



		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[2];

		$_POST['unit_price']=$_POST['unit_price'];
		//$_POST['total_amt']= ($_POST['total_unit'] * $_POST['unit_price']);



		$xid = $crud->insert();

		





}

}

else

{

	$type=0;

	$msg='Data Re-Submit Error!';

}






//if(prevent_multi_submit()){}



if(isset($_POST['confirm'])){
 
		$_POST['entry_at']=date('Y-m-d H:i:s');

		 $_POST['entry_by']=$_SESSION['user']['id'];

		 $now = date('Y-m-d H:i:s');
		 
		 $pi_date=$_POST['pi_date'];
		 
		 $group_for=$_POST['group_for'];
		 
		 $warehouse_from=$_POST['warehouse_from'];
		 
		 $warehouse_to=$_POST['warehouse_to'];

		$req_no=$_POST['req_no'];

		 $sql = 'select * from requisition_fg_order where req_no = '.$req_no;

		$query = db_query($sql);


		while($data=mysqli_fetch_object($query))

		{

			if(($_POST['chalan_'.$data->id]>0))

			{ 

			

				$qty=$_POST['chalan_'.$data->id];

				$rate=$_POST['rate_'.$data->id];

				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;

				$amount = ($qty*$rate);

				$total = $total + $amount;
				
				

 $q = "INSERT INTO `warehouse_transfer_detail` (`pi_no`, `pi_date`, `req_no`, `order_no`, `group_for`, `item_id`, `warehouse_from`, `warehouse_to`, `total_unit`, `unit_price`, `total_amt`, `status`, `entry_by`, `entry_at`) VALUES('".$$unique_master."', '".$pi_date."', '".$req_no."', '".$data->id."', '".$group_for."', ".$item_id.", 
'".$warehouse_from."', '".$warehouse_to."', '".$qty."', '".$rate."', '".$amount."',  'SEND', 
'".$_POST['entry_by']."','".$_POST['entry_at']."')";

db_query($q);



$xid = db_insert_id();

journal_item_control($item_id ,$warehouse_from,$pi_date,0,$qty,'Transit',$xid,$rate,$warehouse_to,$pi_no,'',$pi_no);






}


$vars['status']='SEND';
//db_update($table_chalan, $do_no, $vars, 'do_no');
//db_update($table_details, $do_no, $vars, 'do_no');
db_update($table_master, $pi_no, $vars, 'pi_no');



}

?>



<?




}














if(isset($_GET['del']) && ($_GET['del']>0) )

{	
		$del=$_GET['del'];
		$crud   = new crud($table_detail);

		$condition=$unique_detail."=".$del;		

		$crud->delete_all($condition);

		$sql = "delete from journal_item where tr_from = 'Transit' and tr_no = '".$del."'";

		db_query($sql);

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



auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','1 ','item_id');?>



<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}

function recal() {

document.getElementById('total_unit').value = (((document.getElementById('total_pkt').value)*1)*((document.getElementById('pkt_size').value)*1))+((document.getElementById('total_pcs').value)*1);

}

function total_amtt() {

document.getElementById('total_amt').value = (((document.getElementById('unit_price').value)*1)*((document.getElementById('total_pcs').value)*1));

}

</script>

<div class="form-container_large">
  <form action="<?=$page?>" method="post" name="codz2" id="codz2">
    <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td><fieldset style="width:320px;">
          <div>
            <label style="width:75px;">TR No : </label>
            <input style="width:155px;"  name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>
			
			<input name="group_for" type="hidden" id="group_for" style="width:105px;" value="5" tabindex="105" required />
          </div>
          
          <div>
            <label style="width:75px;">Req. No : </label>
            <label>
			
			<? if ($req_no<1) {?> 
			
			 <select id="req_no" name="req_no" style="width:140px;" required>
			 <option></option>
				<?
			  foreign_relation('requisition_fg_master','req_no','req_no',$_POST['req_no'],
			  'warehouse_id="'.$line_id.'" and  group_for="'.$_SESSION['user']['group'].'" and status="CHECKED"');
			  ?>
              </option>
          </select>
		  
		  <? }?>
		  
		  <? if ($req_no>0) {?> 
		  
		  <input name="req_no" type="text"  readonly="" id="req_no" style="width:155px;" value="<?=$req_no?>" tabindex="105" required />
		  
		   <? }?>
		  
			 
            </label>
          </div>
          </fieldset></td>
        <td><fieldset style="width:260px;">
          <div>
            <label style="width:105px;"><span style="width:75px;">TR</span> Date : </label>
            <input style="width:135px;"  name="pi_date" type="text" id="pi_date" value="<?=($pi_date!='')?$pi_date:date('Y-m-d')?>"  required/>
          </div>
		  
		  
          <div>
            <label style="width:105px;">Company : </label>
            <select id="group_for" name="group_for" style="width:140px;" required>
				<?
			  foreign_relation('user_group','id','group_name',$_POST['group_for'],'id="'.$_SESSION['user']['group'].'" ');
			  ?>
              </option>
          </select>
          </div>
          </fieldset></td>
        <td><fieldset style="width:320px;">
          <div>
            <label style="width:65px;">From: </label>
            <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$_SESSION['user']['depot']?>" />
            <input name="warehouse_from3" type="text" id="warehouse_from3" style="width:200px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" />
          </div>
          <div>
            <label style="width:65px;">To: </label>
			
			<? if ($warehouse_to<1){?>
            <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$line_id?>" />
            <input name="warehouse_from4" type="text" id="warehouse_from4" style="width:200px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" />
			<? }?>
			
			<? if ($warehouse_to>0){?>
            <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$warehouse_to?>" />
            <input name="warehouse_from4" type="text" id="warehouse_from4" style="width:200px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_to)?>" />
			<? }?>
			
          </div>
          </fieldset></td>
      </tr>
      <tr>
        <td colspan="3"><div class="buttonrow" style="margin-left:400px;">
            <? if($$unique_master>0) {?>
            <input name="new" type="submit" class="btn1" value="Update Transfer Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
            <input name="flag" id="flag" type="hidden" value="1" />
            <? }else{?>
            <input name="new" type="submit" class="btn1" value="Initiate Transfer Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
            <input name="flag" id="flag" type="hidden" value="0" />
            <? }?>
          </div></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
    </table>
  
  
 

	
	
	<? if($$unique_master>0){

 $sql='select a.id,a.item_id,b.item_name, b.finish_goods_code, b.d_price, b.unit_name,a.qty from requisition_fg_order  a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;

$res=db_query($sql);

?>
	
	
	
	
	
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th width="6%">SL</th>

            <th width="15%">Item Code</th>

            <th width="40%">Item Name</th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th bgcolor="#FF99FF">Req. Qty </th>

            <th bgcolor="#009900">Transfered </th>

            <th bgcolor="#FFFF00">Pending </th>

            <th bgcolor="#0099CC">Send Qty </th>

          </tr>

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->finish_goods_code?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

              <td><?=$row->item_name?>

                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->d_price?>" /></td>

              <td width="6%" align="center"><?=$row->unit_name?>

                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>

              <td width="10%" align="center"><?=$row->qty?></td>

              <td width="9%" align="center"><? echo $rec_qty = (find_a_field('warehouse_transfer_detail','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));?></td>

              <td width="5%" align="center"><? echo $unrec_qty=($row->qty-$rec_qty);?>

                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>

              <td width="9%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($unrec_qty>0){$cow++;?>

                <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:80px; float:none" value="" required="required" />

                <? } else echo 'Done';?></td>

              </tr>

          <? }?>

      </tbody>

      </table>

      </div>

      </td>

    </tr>

  </table>
	
	
	
	

    
	
	
	
	
	
	<table width="100%" border="0">

<? if($cow<1){

 $up_sql = 'UPDATE `requisition_fg_master` SET `status`="COMPLETED" WHERE `req_no`="'.$req_no.'"';

db_query($up_sql);

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS PRODUCT REQUISITION IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>
<td>&nbsp;</td>
</tr>

<tr>

<td align="center">

<input name="delete" type="hidden" class="btn1" value="DELETE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:left" />

<input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" /></td>

</tr>

<? }?>

</table>
	
	
	
	
	
	
	
  
	
	  </form>
	  
	    <? }?>
</div>
<script>$("#cz").validate();$("#cloud").validate();</script>
<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>
