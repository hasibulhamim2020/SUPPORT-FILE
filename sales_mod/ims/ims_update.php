<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Secondary Sales';

do_calander('#order_date');
do_calander('#pi_date','-10','0');
$page = 'ims_update.php';
if($_POST['line_id']>0) 
$line_id = $_SESSION['line_id']=$_POST['line_id'];
elseif($_SESSION['line_id']>0) 
$line_id = $_POST['line_id']=$_SESSION['line_id'];


$table_master='ims_master';
$unique_master='ims_no';
$table_detail='ims_details';
$unique_detail='id';


if($_REQUEST['v_no']>0)
$$unique_master=$_REQUEST['v_no'];
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
		$$unique_master = $_POST[$unique_master];
		$_POST['entry_at'] = date('Y-m-d H:i:s');
		$_POST['entry_by'] = $_SESSION['user']['id'];
		if($_POST['flag']<1){
		unset($_POST[$unique_master]);
		unset($$unique_master);
		$$unique_master = $crud->insert();
		//$$unique_master = find_a_field($table_master,'max('.$unique_master.')','1');
		$type=1;
		$msg='Product Issued. (IMS No-'.$$unique_master.')';
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		}
}


if(isset($_POST['delete']))
{
		
		$del_ims=db_query("delete from ims_details where ims_no=".$_POST[$unique_master]);
		$del_ims_m=db_query("delete from ims_master where ims_no=".$_POST[$unique_master]);
		echo '<script type="text/javascript">parent.parent.document.location.href = "ims.php?sucess=1";</script>';
		}
if(isset($_POST['confirm'])&&($_POST[$unique_master]>0))
{
		
		$del_ims=db_query("delete from ims_details where ims_no=".$_POST[$unique_master]);
		
		
		$sql = 'select * from item_info where product_nature="Salable"';
		$query = db_query($sql);
		while($data = mysqli_fetch_object($query)){
if($_POST['total_unit_today'.$data->item_id]>0 || $_POST['total_unit_ims'.$data->item_id]>0){	
		$total_amt = $_POST['total_unit_today'.$data->item_id]*$data->cost_price;
	
$do = "INSERT INTO ims_details 
(ims_no, item_id, total_unit_today, total_unit_ims, unit_price, area_id, memo, order_date) VALUES 
('".$_POST['ims_no']."', '".$data->item_id."', '".$_POST['total_unit_today'.$data->item_id]."',  '".$_POST['total_unit_ims'.$data->item_id]."', '".$data->d_price."', '".$_POST['area_id']."', '".$_POST['memo']."', '".$_POST['order_date']."')";
db_query($do);


		}}

}

}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}

if($del>0)
{	
		$crud   = new crud($table_detail);
		$condition=$unique_detail."=".$del;		
		$crud->delete_all($condition);
		$sql = "delete from journal_item where tr_from = 'Consumption' and tr_no = '".$del."'";
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
<div class="form-container_large">
<form action="<?=$page?>" method="post" name="codz2" id="codz2">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset style="width:400px;">
    <div>
      <label style="width:100px;">IMS No : </label>

      <input style="width:155px;"  name="ims_no" type="text" id="ims_no" value="<?= $_GET['v_no'] ?>" readonly="readonly"/>
    </div>
	<?php
	$ims_data=mysqli_fetch_object(db_query("select * from ims_master where ims_no=".$_GET['v_no']));
	?>
	
    <div>
      <label style="width:100px;"><span style="width:105px;">AREA</span> : </label>
      <label>
      <select style="width:145px;" id="area_id" name="area_id" readonly="readonly">

        <?php foreign_relation('area', 'AREA_CODE', 'AREA_NAME', $ims_data->area_id); ?>
		</select>
      </label>
</div>

<div>
        <label style="width:100px;">BASE MARKET  : </label>
        
		
		<select style="width:145px;" id="base_market" name="base_market">

        <?php foreign_relation('base_market', 'BASE_MARKET_CODE', 'BASE_MARKET_NAME', $ims_data->base_market,'AREA_ID='.$ims_data->area_id); ?>
		</select>
        
      </div>
	  
	  <div>
			    <label style="width:105px;"> Order Date : </label>
			    <input style="width:105px;"  name="order_date" type="text" id="order_date" value="<?=$ims_data->order_date;?>" required/>
	      </div>
			  
	  <div>
        <label style="width:100px;">Number of Memos  : </label>
        <input name="memo" type="text" id="memo"  value="<?=$ims_data->memo?>" />
        
      </div>
	  
	   
	  
    </fieldset></td>
    
  </tr>
  <tr>
    <td colspan="3"><div class="buttonrow" style="margin-left:240px;">
    <? if($_GET['v_no']>0) {?>

<input name="flag" id="flag" type="hidden" value="1" />

    </div></td>
    </tr>
</table>
</form>
<? $warehouse_to = $line_id;?>
<form action="ims_update.php?v_no=<?php echo $_GET['v_no'];?>" method="post" name="codz2" id="codz2" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$_GET['v_no']?>"/>
<input  name="area_id" type="hidden" id="area_id" value="<?=$ims_data->area_id?>"/>
<input  name="memo" type="hidden" id="memo" value="<?=$ims_data->memo?>"/>
<input  name="order_date" type="hidden" id="order_date" value="<?=$ims_data->order_date?>"/>

<? if($_GET['v_no']>0){?>
<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
  <td width="15%" align="center" bgcolor="#33CCFF"><strong>FG Code</strong></td>
    <td width="45%" align="center" bgcolor="#33CCFF"><strong>Item Name</strong></td>
    <td width="20%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold">Order Qty (Today)</span></td>
    <td width="20%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold">IMS (Yesterday)</span></td>
    </tr>
<? 

$sql = 'select d.total_unit_today, d.total_unit_ims, i.item_id, i.finish_goods_code, i.item_name from ims_details d, item_info i where i.product_nature="Salable" and d.item_id=i.item_id and d.ims_no="'.$_GET['v_no'].'" order by finish_goods_code';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
$total_unit_ims[$data->item_id] = $data->total_unit_ims;
$total_unit_today[$data->item_id] = $data->total_unit_today;
}
$sql = 'select * from item_info where product_nature="Salable" order by finish_goods_code';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
?>
  
	
	<tr>
	<input  name="item_id" type="hidden" id="item_id" value="<?=$data->item_id?>"/>
  <td width="15%" align="center" bgcolor="#33CCFF"><strong><?=$data->finish_goods_code?></strong></td>
    <td width="45%" align="center" bgcolor="#33CCFF"><strong><?=$data->item_name?></strong></td>
    <td width="20%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold"><input name="total_unit_today<?=$data->item_id?>" type="text" class="input3" id="total_unit_today<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$total_unit_today[$data->item_id]?>"/></span></td>
    <td width="20%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold"><input name="total_unit_ims<?=$data->item_id?>" type="text" class="input3" id="total_unit_ims<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$total_unit_ims[$data->item_id]?>"/></span></td>
    </tr>
<? }?>
</table>





<table width="100%" border="0">
  <tr>
      <td align="center"><input  name="ims_no" type="hidden" id="ims_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">
	  <input name="delete" type="submit" class="btn1" value="Delete IMS" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:left" />
      <input name="confirm" type="submit" class="btn1" value="Update IMS" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />
      </td>
      
    </tr>
</table>


<? }?>
</form>

<? } ?>
</div>
<script>$("#cz").validate();$("#cloud").validate();</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>