<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='New Purchase Order Create';

do_calander('#po_date');
do_calander('#quotation_date');

$table_master='purchase_master';
$table_details='purchase_invoice';
$unique='po_no';


if(isset($_POST['new']))
{
		$crud   = new crud($table_master);

		if($_SESSION[$unique] < 1) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Purchase Order No Created. (PO No :-'.$_SESSION[$unique].')';
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
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[1];
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
if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','product_nature!="Salable"','item_id','1');

?>
<script language="javascript">
function count()
{
var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
document.getElementById('amount').value = num.toFixed(2);	
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="100%" class="table table-bordered" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top"><fieldset>
    <? $field='po_no';?>
      <div>
        <label for="<?=$field?>">PO  No: </label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
    <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>
      <div>
        <label for="<?=$field?>">PO Date:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    <? $field='req_no';?>
      <div>
        <label for="<?=$field?>">Req No:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
      <div>
        <label for="<?=$field?>">Warehouse:</label>
        <select class="form-control" id="<?=$field?>" name="<?=$field?>" required >
        <option></option>
        <? foreign_relation($table,$get_field,$show_field,$$field,'use_type!="PL"');?>
        </select>
      </div>
<div>
      <p>
        <? $field='tax';?>
        <label for="<?=$field?>">Vat/Tax:</label>
  <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </p>
	  </div>
	  <div>
      <p>
        <? $field='payment_details';?>
        <label for="<?=$field?>">Payment:</label>
        <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </p></div>
    </fieldset></td>
    <td>
			<fieldset>
			

	        <? $field='po_details';?>
      <div>
        <label for="<?=$field?>">Note:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
      </div>
      <div></div>
      <? $field='vendor_id'; $table='vendor'; $get_field='vendor_id'; $show_field='vendor_name'; ?>
      <div>
        <label for="<?=$field?>">Vendor:</label>
		<span id="vendor_space">
<select class="form-control" id="vendor_id" name="vendor_id" required>
<? foreign_relation($table,$get_field,$show_field,$$field,"1 order by vendor_name");?>
</select>
		</span> 
      </div>
      <div>
        <? $field='quotation_no';?>
        <div>
          <label for="<?=$field?>">Quotation No:</label>
          <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
        <? $field='quotation_date';?>
        <div>
          <label for="<?=$field?>">Quotation Date:</label>
          <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
        <? $field='delivery_within';?>
        <div>
          <label for="<?=$field?>">Delivery Within:</label>
          <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
		        <? $field='payment_terms';?>
        <div>
          <label for="<?=$field?>">Payment Terms:</label>
          <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
        </div>
      </div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin-left:350px;">
      <input class="form-control" name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>
<? if($_SESSION[$unique]>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<? 
$group_for = find_a_field('warehouse','group_for','warehouse_id='.$warehouse_id.' ');
if(($vendor->ledger_id==0)&&($group_for==2||$group_for==3)){ ?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
<tr><td bgcolor="#FF3333"><div align="center" class="style1">VERDOR IS BLOCKED. NO ACCOUNT CODE FOUND</div></td></tr>
</table>

<? }else{?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Price</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<input class="form-control"  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input class="form-control"  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input class="form-control" name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>
<input class="form-control"  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
<input name="item_id" type="text" id="item_id" value="<?=$item_id?>" class="form-control" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>
<td colspan="3" align="center" bgcolor="#CCCCCC">
<span id="po">
<input name="stk" type="text" class="input3" id="stk" class="form-control" readonly/>
<input name="unit" type="text" class="input3" id="unit" class="form-control" readonly/>
<input name="price" type="text" class="input3" id="price" class="form-control"  readonly="readonly"/>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:60px;" onchange="count()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:90px;" readonly required/></td>
      </tr>
    </table>
<? }?>				  
<br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
<div class="tabledesign2">
<? 
$res='select a.id,concat(b.item_name," :: ",b.item_description) as item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;
echo link_report_add_del_auto($res,'',6,0);
?>
</div>
</td>
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

      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL PO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD PO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

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