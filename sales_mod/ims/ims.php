<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Secondary Sales';

do_calander('#order_date');
do_calander('#pi_date','-10','0');
$page = 'ims.php';
if($_POST['line_id']>0) 
$line_id = $_SESSION['line_id']=$_POST['line_id'];
elseif($_SESSION['line_id']>0) 
$line_id = $_POST['line_id']=$_SESSION['line_id'];


$table_master='ims_master';
$unique_master='ims_no';
$table_detail='ims_details';
$unique_detail='ims_no';


if($_REQUEST['old_ims_no']>0)
$$unique_master=$_REQUEST['old_ims_no'];
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

if(isset($_POST['confirm'])&&($_POST[$unique_master]>0))
{
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
echo '<script type="text/javascript">parent.parent.document.location.href = "ims.php?sucess=1";</script>';
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


<div class="form-container_large">
<form action="<?=$page?>" method="post" name="codz2" id="codz2">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset style="width:400px;">
    <div>
      <label style="width:100px;">IMS No : </label>

      <input style="width:155px;"  name="ims_no" type="text" id="ims_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>
    </div>
    
    <div>
      <label style="width:100px;"><span style="width:105px;">ZONE</span> : </label>
      <label>
      <select style="width:145px;" id="zone_id" name="zone_id" onchange="getData2('ajax_area.php','area_code',this.value,this.value);">

        <?php foreign_relation('zon', 'ZONE_CODE', 'ZONE_NAME', $zone_id); ?>
		</select>
      </label>
</div>
    
    
    <div>
      <label style="width:100px;"><span style="width:105px;">AREA</span> : </label>
      <label>
     <span id="area_code"><select style="width:145px;" id="area_id" name="area_id" onchange="getData2('ajax_market.php','market',this.value,this.value);">

        <?php if($zone_id>0) {foreign_relation('area', 'AREA_CODE', 'AREA_NAME', $area_id,'ZONE_ID='.$zone_id); }?>
		</select></span>
      </label>
</div>

<div>
        <label style="width:100px;">BASE MARKET  : </label>
        
		
		<span id="market"><select style="width:145px;" id="base_market" name="base_market">

        <?php if($area_id>0) {foreign_relation('base_market', 'BASE_MARKET_CODE', 'BASE_MARKET_NAME', $base_market,'AREA_ID='.$area_id); }?>
		</select></span>
        
      </div>
	  
	  <div>
			    <label style="width:105px;"> Order Date : </label>
			    <input style="width:105px;"  name="order_date" type="text" id="order_date" value="<?=$order_date;?>" required/>
	      </div>
			  
	  <div>
        <label style="width:100px;">Number of Memos  : </label>
        <input name="memo" type="text" id="memo"  value="<?=$memo?>" />
        
      </div>
	  
	   
	  
    </fieldset></td>
    
  </tr>
  <tr>
    <td colspan="3"><div class="buttonrow" style="margin-left:240px;">
    <? if($$unique_master>0) {?>
<input name="new" type="submit" class="btn1" value="Update IMS" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="1" />
<? }else{?>
<input name="new" type="submit" class="btn1" value="Initiate IMS" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="0" />
<? }?>
    </div></td>
    </tr>
</table>
</form>
<? $warehouse_to = $line_id;?>
<form action="ims.php?sucess=1" method="post" name="codz2" id="codz2" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
<input  name="area_id" type="hidden" id="area_id" value="<?=$_POST['area_id']?>"/>
<input  name="memo" type="hidden" id="memo" value="<?=$_POST['memo']?>"/>
<input  name="order_date" type="hidden" id="order_date" value="<?=$_POST['order_date']?>"/>

<? if($$unique_master>0){?>
<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
  <td width="15%" align="center" bgcolor="#33CCFF"><strong>FG Code</strong></td>
    <td width="45%" align="center" bgcolor="#33CCFF"><strong>Item Name</strong></td>
    <td width="20%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold">Order Qty (Today)</span></td>
    <td width="20%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold">IMS (Yesterday)</span></td>
    </tr>
<? 

$sql = 'select * from item_info where product_nature="Salable" order by finish_goods_code';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
?>
  
	
	<tr>
	<input  name="item_id" type="hidden" id="item_id" value="<?=$data->item_id?>"/>
  <td width="15%" align="center" bgcolor="#33CCFF"><strong><?=$data->finish_goods_code?></strong></td>
    <td width="45%" align="center" bgcolor="#33CCFF"><strong><?=$data->item_name?></strong></td>
    <td width="20%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold"><input name="total_unit_today<?=$data->item_id?>" type="text" class="input3" id="total_unit_today<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="0"/></span></td>
    <td width="20%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold"><input name="total_unit_ims<?=$data->item_id?>" type="text" class="input3" id="total_unit_ims<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="0"/></span></td>
    </tr>
<? }?>
</table>





<table width="100%" border="0">
  <tr>
      <td align="center"><input  name="ims_no" type="hidden" id="ims_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">
      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND ISSUE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />
      </td>
      
    </tr>
</table>


<? }?>
</form>
</div>
<script>$("#cz").validate();$("#cloud").validate();</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>