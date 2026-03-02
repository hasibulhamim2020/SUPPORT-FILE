<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Production Line Issue';

do_calander('#pi_date');
do_calander('#pi_date','-10','0');
$page = 'production_issue.php';
if($_POST['line_id']>0) 
$line_id = $_SESSION['line_id']=$_POST['line_id'];
elseif($_SESSION['line_id']>0) 
$line_id = $_POST['line_id']=$_SESSION['line_id'];


$table_master='production_issue_master';
$unique_master='pi_no';

$table_detail='production_issue_detail';
$unique_detail='id';

if($_REQUEST['old_pi_no']>0)
$$unique_master=$_REQUEST['old_pi_no'];
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
		$msg='Product Issued. (PI No-'.$$unique_master.')';
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		}
}

if(isset($_POST['confirm'])&&($_POST[$unique_master]>0))
{
		$sql = 'select i.* from item_info i,production_line_raw r where i.item_id =r.fg_item_id and r.line_id='.$line_id;
		$query = db_query($sql);
		while($data = mysqli_fetch_object($query)){
if($_POST['total_unit_'.$data->item_id]>0){	
		$total_amt = $_POST['total_unit_'.$data->item_id]*$data->cost_price;
	
$do = "INSERT INTO production_issue_detail 
(pi_no, pi_date, item_id, warehouse_from, warehouse_to, total_unit, unit_price, total_amt) VALUES 
('".$_POST['pi_no']."', '".$_POST['pi_date']."', '".$data->item_id."',  '".$_SESSION['user']['depot']."','".$line_id."', '".$_POST['total_unit_'.$data->item_id]."', '".$data->cost_price."', '".$total_amt."')";
db_query($do);

$xid = db_insert_id();
//journal_item_control($data->item_id ,$line_id,$_POST['pi_date'],'0',$_POST['total_unit_'.$data->item_id],'Consumption',$xid,'0','0',$_POST['pi_no']);

journal_item_control($data->item_id ,$_SESSION['user']['depot'],$_POST['pi_date'],0,$_POST['total_unit'],'Issue',$xid,'',$_SESSION['line_id'],$_POST['remarks']);
journal_item_control($data->item_id ,$_SESSION['line_id'],$_POST['pi_date'],$_POST['total_unit'],'0','Issue',$xid,'',$_SESSION['user']['depot'],$_POST['remarks']);

		}}
echo '<script type="text/javascript">parent.parent.document.location.href = "select_production_line.php?sucess=1";</script>';
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
    <td><fieldset style="width:240px;">
    <div>
      <label style="width:75px;">PI No : </label>

      <input style="width:155px;"  name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
    </div>
    <div>
      <label style="width:75px;">Carried by : </label>
      <label>
      <input name="carried_by" type="text" id="carried_by" value="<?=$carried_by?>"  style="width:155px;"/>
      </label>
</div>
    </fieldset></td>
    <td>
			<fieldset style="width:220px;">
			  <div>
			    <label style="width:105px;">Issue Date : </label>
			    <input style="width:105px;"  name="pi_date" type="text" id="pi_date" value="<?=($pi_date=='')?'':$pi_date;?>" required/>
		      </div>
			  <div>
			    <label style="width:105px;">SR NO: </label>
			    <input name="remarks" type="text" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" required />
	        </div>
		</fieldset>	</td>
    <td><fieldset style="width:240px;">
      <div>
        <label style="width:75px;">Issue from : </label>
        <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$_SESSION['user']['depot']?>" />
        <input name="warehouse_from3" type="text" id="warehouse_from3" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" />
      </div>
      
            <div>
        <label style="width:75px;">Issued To : </label>
        <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$line_id?>" style="width:155px;" />
        <input name="warehouse_to2" type="text" id="warehouse_to2"  value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" style="width:155px;" />
      </div>
    </fieldset></td>
  </tr>
  <tr>
    <td colspan="3"><div class="buttonrow" style="margin-left:240px;">
    <? if($$unique_master>0) {?>
<input name="new" type="submit" class="btn1" value="Update Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="1" />
<? }else{?>
<input name="new" type="submit" class="btn1" value="Initiate Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="0" />
<? }?>
    </div></td>
    </tr>
</table>
</form>
<? $warehouse_to = $line_id;?>
<form action="select_production_line.php?sucess=1" method="post" name="codz2" id="codz2" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
<input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>
<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
<input  name="pi_date" type="hidden" id="pi_date" value="<?=$pi_date?>"/><input  name="line_id" type="hidden" id="line_id" value="<?=$line_id?>"/><input  name="remarks" type="hidden" id="remarks" value="<?=$remarks?>"/>

<? if($$unique_master>0){?>
<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" bgcolor="#33CCFF"><strong>RAW MATERIAL</strong></td>
    <td width="10%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold">Unit</span></td>
    <td width="10%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold">Stock</span></td>
    <td width="10%" align="center" bgcolor="#33CCFF"><strong> Qty</strong></td>
    </tr>
<? 

$sql = 'select i.* from item_info i,production_line_raw r where  i.item_id =r.fg_item_id and (i.sub_group_id=1096000300020000 or i.sub_group_id=1096000300040000) and r.line_id="'.$line_id.'" order by item_name';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
?>
  <tr>
    <td  bgcolor="#CCCCCC"><div align="left">
      <?=$data->item_id.'-'.$data->item_name?></div></td>
    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>
    <td align="center" bgcolor="#CCCCCC"><? echo number_format(warehouse_product_stock($data->item_id ,$_SESSION['user']['depot']),2);?></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit_<?=$data->item_id?>" type="text" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" required="required" value="0"/></td>
    </tr>
<? }?>
</table>
<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" bgcolor="#FF9999"><strong>CHEMICAL MATERIAL</strong></td>
    <td width="10%" align="center" bgcolor="#FF9999"><span style="font-weight: bold">Unit</span></td>
    <td width="10%" align="center" bgcolor="#FF9999"><span style="font-weight: bold">Stock</span></td>
    <td width="10%" align="center" bgcolor="#FF9999"><strong> Qty</strong></td>
  </tr>
  <? 
$sql = 'select i.* from item_info i,production_line_raw r where  i.item_id =r.fg_item_id and (i.sub_group_id=1096000300010000) and r.line_id="'.$line_id.'" order by item_name';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
?>
  <tr>
    <td  bgcolor="#CCCCCC"><div align="left">
      <?=$data->item_id.'-'.$data->item_name?>
    </div></td>
    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>
    <td align="center" bgcolor="#CCCCCC"><? echo number_format(warehouse_product_stock($data->item_id ,$_SESSION['user']['depot']),2);?></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit_<?=$data->item_id?>" type="text" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" required="required" value="0"/></td>
  </tr>
  <? }?>
</table>
<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" bgcolor="#999999"><strong>PACKING MATERIAL </strong></td>
    <td width="10%" align="center" bgcolor="#999999"><span style="font-weight: bold">Unit</span></td>
    <td width="10%" align="center" bgcolor="#999999"><span style="font-weight: bold">Stock</span></td>
    <td width="10%" align="center" bgcolor="#999999"><strong> Qty</strong></td>
  </tr>
  <? 
$sql = 'select i.* from item_info i,production_line_raw r where  i.item_id =r.fg_item_id and (i.sub_group_id=1096000300030000 or i.sub_group_id=1096000300050000 or sub_group_id=1096000300060000 or sub_group_id=1096000300070000) and r.line_id="'.$line_id.'" order by item_name';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
?>
  <tr>
    <td  bgcolor="#CCCCCC"><div align="left">
      <?=$data->item_id.'-'.$data->item_name?>
    </div></td>
    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>
    <td align="center" bgcolor="#CCCCCC"><? echo number_format(warehouse_product_stock($data->item_id ,$_SESSION['user']['depot']),2);?></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit_<?=$data->item_id?>" type="text" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" required="required" value="0"/></td>
  </tr>
  <? }?>
</table>
<br />
	<br />

<? 

$res='select a.id,b.item_id as item_code,b.item_name,b.unit_name,a.total_unit,"X" from production_floor_issue_detail a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';
?>


<table width="100%" border="0">
  <tr>
      <td align="center"><input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">
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