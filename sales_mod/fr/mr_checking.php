<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Approving Material Requisition';

do_calander('#req_date');
do_calander('#need_by');

$table_master='requisition_master';
$table_details='requisition_order';
$unique='req_no';


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
		$msg='Successfully Forwarded to Relevant Department.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
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

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','product_nature!="Salable"','item_id');
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
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset>
    <? $field='req_no';?>
      <div>
        <label for="<?=$field?>">Requisition No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
    <? $field='req_date';?>
      <div>
        <label for="<?=$field?>">Requisition Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
      <div>
        <label for="<?=$field?>">Warehouse:</label>
        <select id="<?=$field?>" name="<?=$field?>" required>
        <option></option>
        <? foreign_relation($table,$get_field,$show_field,$$field);?>
        </select>
      </div>
    </fieldset></td>
    <td>
			<fieldset>
			
    <? $field='req_for';?>
      <div>
        <label for="<?=$field?>">Requisition For:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    <? $field='need_by';?>
      <div>
        <label for="<?=$field?>">Need By(Date):</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
    <? $field='req_note';?>
      <div>
        <label for="<?=$field?>">Additional Note:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>


<? if($_SESSION[$unique]>0){?>
<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>
    </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created By:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
    <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="mr_print_view.php?req_no=<?=$req_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created On:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=$entry_at?></td>
    </tr>
</table>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Stock Qty</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>L P QTY</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>L P Date</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Req Qty</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>"i type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="req_date" type="hidden" id="req_date" value="<?=$req_date?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:280px;" required="required" onblur="getData2('mr_ajax.php', 'mr', this.value, document.getElementById('warehouse_id').value);"/></td>
<td colspan="4" align="center" bgcolor="#CCCCCC">
<span id="mr">
<input name="qoh" type="text" class="input3" id="qoh" style="width:90px;" readonly/>  
<input name="last_p_qty" type="text" class="input3" id="last_p_qty" style="width:75px;" readonly/>  
<input name="last_p_date" type="text" class="input3" id=" 	last_p_date"  style="width:80px;" readonly/>  
<input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:40px;" readonly/>
</span>
</td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:60px;"/></td>
      </tr>
    </table>
					  <br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
$res='select a.id,concat(b.item_name," :: ",b.item_description) as item_name,a.qoh as stock_qty,a.last_p_qty as last_pur_qty,a.last_p_date as last_pur_date,a.qty,"x" from requisition_order a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;
echo link_report_del($res);
?>
</div></td>
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

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD REQUSITION" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

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