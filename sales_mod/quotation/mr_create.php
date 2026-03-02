<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Spare Parts Requisition';


do_calander('#req_date');
do_calander('#need_by','"'.$req_date =date('Y-m-d').'"','60');

$table_master='spare_parts_requisition_master';
$table_details='spare_parts_requisition_order';
$unique='req_no';

if($_GET['mhafuz']>0)
unset($_SESSION[$unique]);

if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		
		if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Requisition No Created. (Req No :-'.$_SESSION[$unique].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
}

$$unique=$_SESSION[$unique];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Deleted.';
}

if($_GET['del']>0)
{
		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirmm']))
{
		unset($_POST);
		
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded for Approval.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$_POST['qty']=$_POST['qty_ctn'];
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[2];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:s:i');
		$crud->insert();
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update Requisition Information'; else $btn_name='Initiate Requisition Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
auto_complete_from_db('item_info','item_id','concat(item_name,"#>",item_description,"#>",item_id)','product_nature="Salable"','item_id');
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





function update_edit(id)

{
var qty = (document.getElementById("qty#"+id).value);
//var unit_price   = (document.getElementById("unit_price#"+id).value);
//var amount = (document.getElementById("amount#"+id).value)*1;
//var unit_price  = (document.getElementById("unit_price#"+id).value);
//var amount = (document.getElementById("amount#"+id).value)*1;
//var info = qty+"<@>"+unit_price+"<@>"+amount;
var info = qty;
getData2('req_edit_ajax.php', 'ppp',id,info);
}

</script>




<style>

.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}


</style>



<div class="form-container_large">
<form action="mr_create.php" method="post" name="codz" id="codz" >
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset>
    <? $field='req_no';?>
      <div>
        <label for="<?=$field?>">Requisition No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
		 
		<input name="store_req_no" type="hidden" id="store_req_no" 
		value="<? if($store_req_no>0) echo $store_req_no; else echo (find_a_field($table_master,'max(store_req_no)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"')+1);?>" readonly/>
		
      </div>
    <? $field='req_date'; if($req_date=='') $req_date =date('Y-m-d');?>
      <div>
        <label for="<?=$field?>">Requisition  Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly=""/>
      </div>
	  
	  
	  <? $field='req_note'; ?>
      <div>
        <label for="<?=$field?>">Remarks:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
		<input  name="group_for_to" type="hidden" id="group_for_to" value="1" required/>
      </div>
    
	  
	  
	  
	  
    </fieldset></td>
    <td>
			<fieldset>
			

	  
	  
	  
	  
	     <? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>
	  
      <div> 
        <label for="<?=$field?>">Company Name:</label>
		
		<? if($group_for<1) { ?>
		
		

<select  name="group_for" id="group_for" required>

		
      <? foreign_relation('user_group','id','group_name',$group_for,'1 order by id');?>
		 </select>


		
		
		<? }?>
		
		
		<? if($group_for>0) { ?>
			<input  name="group_for2" type="text" id="group_for2"  readonly=""
			value="<?=find_a_field('user_group','group_name','id='.$group_for)?>" required/>
			
			<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required/>
		
		<? }?>
	  
	  
   </div>
   
   
	  
	  
	  
	  
	  
	  
	  
	  
	     <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
	  
      <div> 
        <label for="<?=$field?>"> Warehouse:</label>
		
		<? if($warehouse_id<1) { ?>
		
		

<select  name="warehouse_id" id="warehouse_id" required>


	
		
      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1 order by warehouse_id');?>
		 </select>


		
		
		<? }?>
		
		
		<? if($warehouse_id>0) { ?>
			<input  name="warehouse_id2" type="text" id="warehouse_id2"  readonly=""
			value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id)?>" required/>
			
			<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required/>
		
		<? }?>
	  
	  
   </div>
   
   
   

	  
      <div> 
        <label for="<?=$field?>">Dealer:</label>

		
		

<select  name="dealer_code" id="dealer_code" required>

	
		
      <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'1 order by dealer_group,dealer_code');?>
		 </select>
 
   </div>
	  
	
	      
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin-left:300px;">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>
<? if($_SESSION[$unique]>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td width="50%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                            <td width="10%" align="center" bgcolor="#0099FF"><strong>Unit Name </strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Machine</strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Quantity</strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Remarks</strong></td>
                          <td width="5%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="req_date" type="hidden" id="req_date" value="<?=$req_date?>"/>
<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>"/>



<? create_combobox('item_id'); ?>

	<select name="item_id" id="item_id" style="width:250px;" required onblur="getData2('mr_ajax.php', 'mr', this.value, document.getElementById('warehouse_id').value);">
		<option></option>
        <? foreign_relation('item_info','item_id','item_name',$item_id,' product_nature="Salable" order by item_id'); ?>
    </select> 


</td>
                        <td align="center" bgcolor="#CCCCCC">
						<span id="mr">
						
						<table>
							<tr>
								<td>

<input name="unit_name" type="text" class="input3" id="unit_name"  style="width:80px; height:20px;" onfocus="focuson('qty_ctn')" readonly="readonly"/>								</td>
							</tr>
						</table>
</span></td>
                        <td align="center" bgcolor="#CCCCCC">
							<select  name="machine_id" id="machine_id"  style="width:90px; height:25px;">
						<option></option>
     					 <? foreign_relation('machine_info','machine_id','machine_short_name',$machine_id,
						 'group_for="'.$group_for.'"');?>
					 </select>						</td>
                        <td align="center" bgcolor="#CCCCCC"><input name="qty_ctn" type="text" class="input3" id="qty_ctn"  maxlength="100" style="width:80px;height:20px;" required/></td>
                        <td align="center" bgcolor="#CCCCCC"><input name="remarks" type="text" class="input3" id="remarks"  maxlength="100" style="width:120px;height:20px;" /></td>
      </tr>
    </table>
<br /><br />
  
  
  
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">&nbsp;
      <tr>
	  <br />
   
        <td><div class="tabledesign2">
          <table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody>
            
			
            <tr>
			<th width="7%">SL</th>
			<th width="33%">Item Name</th>
			<th width="6%">Unit</th>
			<th width="9%">Machine</th>
			<th width="14%">Quantity</th>
			<th width="14%">Remarks</th>
			<th width="8%">Action</th>
      		<th width="9%">Delete</th>
			</tr>
            
            

<?
$s=0;
  $res='select a.id,   concat(b.item_name) as item_name,  a.machine_id, b.unit_name,  a.qty as qty , a.remarks,"x" from spare_parts_requisition_order a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;

$query=db_query($res);

while($data=mysqli_fetch_object($query)){
?>
<tr>
<td style="text-align:center;"><?=++$s?></td>
<td>&nbsp;<?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td>&nbsp;<?=find_a_field('machine_info','machine_short_name','machine_id='.$data->machine_id)?></td>
<td><input type="text" name="<?='qty#'.$data->id?>" id="<?='qty#'.$data->id?>" value="<?=$data->qty?>" style="width:80px; height:25px;" onchange="TRcalculation(<?=$data->id?>)" /></td>

<td><?=$data->remarks?></td>
<td><span id="ppp"><input name="<?='edit#'.$data->id?>" type="button" id="Edit" value="Edit" style="width:60px; height:30px; color:#000; font-weight:700 " onclick="update_edit(<?=$data->id?>);" /></span></td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$data->id?>">&nbsp;X&nbsp;</a></td>
</tr>
<? }?>







</table>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
</form>
<br />

<form action="" method="post" name="cz" id="cz" >
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD" style="width:300px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" />

      </td>
    </tr>
  </table>
</form>
<? }?>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>