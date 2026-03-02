<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='New Despatch Order Create';


do_calander('#need_by');

$table_master='requisition_fg_master';
$table_details='requisition_fg_order';
$unique='req_no';

if($_GET['mhafuz']>0)
unset($_SESSION[$unique]);

if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		
		if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Requisition No Created. (Req No :-'.$_SESSION[$unique].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
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
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded for Approval.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$_POST['qty']=($_POST['qty_ctn']*$_POST['pack_size'])+$_POST['qty_pcs'];
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[2];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$crud->insert();
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update Requsition Information'; else $btn_name='Initiate Requsition Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
auto_complete_from_db('item_info','concat(item_name,"#>",item_description,"#>",item_id)','concat(item_name,"#>",item_description,"#>",item_id)','product_nature="Salable"','item_id');
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
<form action="mr_create.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset>
    <? $field='req_no';?>
      <div>
        <label for="<?=$field?>">Requisition No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
    <? $field='req_date'; if($req_date=='') $req_date =date('Y-m-d');?>
      <div>
        <label for="<?=$field?>">Requisition Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly=""/>
      </div>
    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
      <div>
        <label for="<?=$field?>">Requization From:</label>
		<input name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>" />
		<input name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" readonly="" />
      </div>
    </fieldset></td>
    <td>
			<fieldset>
			
<? $field='warehouse_to'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
      <div>
        <label for="<?=$field?>">Requization to:</label>
		<input name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$_POST['warehouse_to']?>" />
		<input name="warehouse_to2" type="text" id="warehouse_to2" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_to'])?>" readonly="" />
      </div>
    <? $field='need_by';?>
      <div>
        <label for="<?=$field?>">Need By(Date):</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
	  
	  <? $field='req_note';?>
      <div>
        <label for="<?=$field?>">Transport Info :</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
	  
	  
    <? $field='sub_depot';?>
      <div>
        <label for="<?=$sub_depot?>">Despatch Depot :</label>
		<select  name="sub_depot" id="sub_depot">
		<option></option>
         <? foreign_relation('warehouse','warehouse_id','warehouse_name',$sub_depot,' sub_depot="Yes" ');?>
		 </select>
      </div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
  </tr>
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
      <div align="center"></div>
    </div></td>
    </tr>
</table>
</form>
<? if($_SESSION[$unique]>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                            <td align="center" bgcolor="#0099FF"><strong>Unit Name </strong></td>
                            <td align="center" bgcolor="#0099FF"><strong>Quantity</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="sub_depot" type="hidden" id="sub_depot" value="<?=$sub_depot?>"/>
<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
<input  name="req_date" type="hidden" id="req_date" value="<?=$req_date?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:350px;background-color:white;" required="required" onblur="getData2('mr_ajax.php', 'mr', this.value, document.getElementById('warehouse_id').value);"/></td>
                        <td align="center" bgcolor="#CCCCCC"><span id="mr">

<input name="unit_name" type="text" class="input3" id="unit_name"  style="width:100px;" onfocus="focuson('qty_ctn')" readonly="readonly"/>

</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty_ctn" type="text" class="input3" id="qty_ctn"  maxlength="100" style="width:120px;background-color:white;" required/></td>
      </tr>
    </table>
<br /><br /><br /><br />
<? 
$res='select a.id,  b.finish_goods_code as FG_code, concat(b.item_name) as item_name,a.qty DIV b.pack_size as Quantity,"x" from requisition_fg_order a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';
echo link_report_del($res);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
</form>
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL REQUSITION" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD REQUSITION" style="width:300px; font-weight:bold; font-size:12px; height:30px; color:#090" />

      </td>
    </tr>
  </table>
</form>
<? }?>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>