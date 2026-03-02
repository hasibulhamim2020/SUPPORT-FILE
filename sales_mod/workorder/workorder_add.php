<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Work Order Create';

do_calander('#wo_date');

$table='lc_workorder';
$unique='id';


if(isset($_POST['new']))
{

		$crud   = new crud($table);
		$_POST['prepared_at']=date('Y-m-d H:i:s');
		if(!isset($_SESSION['wo_id'])){
		$wo_id=$_SESSION['wo_id']=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Work Order Initialized. (WORK ORDER ID-'.$wo_id.')';
		}
		else {
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
}

$wo_id=$_SESSION['wo_id'];

if(isset($_POST['delete']))
{

		$crud   = new crud('lc_workorder');
		$condition="id=".$wo_id;		
		$crud->delete($condition);
		$crud   = new crud('lc_workorder_details');
		$condition="wo_id=".$wo_id;		
		$crud->delete_all($condition);
		unset($wo_id);
		unset($_SESSION['wo_id']);
		$type=1;
		$msg='Successfully Deleted.';
}
if($_GET['del']>0)
{


		$crud   = new crud('lc_workorder_details');
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST['id']=$wo_id;
		$_POST['prepared_at']=date('Y-m-d H:i:s');
		$_POST['status']='UNCHECKED';
		$crud   = new crud('lc_workorder');
		$crud->update('id');
		unset($wo_id);
		unset($_SESSION['wo_id']);
		$type=1;
		$msg='Successfully Send to Factory.';
}

if($wo_id>0)
{
		$condition=$unique."=".$wo_id;
		$data=db_fetch_object($table,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}

if(isset($_POST['add'])&&($_POST['wo_id']>0))
{
		$table		='lc_workorder_details';
		$crud      	=new crud($table);
		$crud->insert();
}


?>
<script language="javascript">
function count()
{
var myCars=new Array();
myCars[0]="999";
<?
	$item_i=1;
	$sql_i='select * from  lc_product_item where billing_unit_id=3';
	$query_i=db_query($sql_i);
while($is=mysqli_fetch_object($query_i))
{
	echo 'myCars['.$item_i.']="'.$is->id.'";';
	$item_i++;
}
?>
var item_check=document.getElementById('item_id').value;
var f=myCars.indexOf(item_check);
if(f>0)
var num=(((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1))/12;
else
var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
document.getElementById('amount').value = num.toFixed(4);
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset>
    <div>
      <label>DO No: </label>
      
      <input  name="id" type="text" id="id" value="<? if($_SESSION['wo_id']>0) echo $_SESSION['wo_id']; else echo (find_a_field('lc_workorder','max(id)','1')+1);?>"/>
    </div>
<div>
  <label for="email">DO Date : </label>
  <input  name="wo_date" type="text" id="wo_date" value="<?=$wo_date?>"/>
        <input  name="prepared_by" type="hidden" id="prepared_by" value="<?=$_SESSION['user']['id']?>" readonly="readonly" />
    </div>
      <div>
        <label for="email">Dealer Name : </label>
        <select id="buyer_id" name="buyer_id">
        <option></option>
        <? foreign_relation('lc_buyer','id','buyer_name',$buyer_id);?>
        </select>
      </div>
      <div>
        <label for="email">DO Mode : </label>
        
        <select id="for" name="for">
        <option value="TT" <? if($for=='TT') echo 'selected'?>>TT</option>
        <option value="NAL" <? if($for=='NAL') echo 'selected'?>>NAL</option>
        </select>
    </div>
      <div>
        <label for="wo_detail">Remarks : </label>
        <input  name="wo_detail" type="text" id="wo_detail" value="<?=$thickness?>"/>
      </div>
    </fieldset></td>
    <td>
			<fieldset>
			<div>
			<label>Dealer Address: </label> 
			<input  name="wo_subject" type="text" id="wo_subject" value="<?=$wo_subject?>"/>
			</div>
			<div>
			<label>Dealer Zone: </label> 
			<input  name="wo_subject" type="text" id="wo_subject" value="<?=$wo_subject?>"/>
			</div>
			<div>
			  <label for="thickness">Crd Limit: </label>
            <input  name="thickness" type="text" id="thickness" value="<?=$thickness?>"/>
			</div>
            <div>
			  <label for="thickness">Balance: </label>
            <input  name="thickness" type="text" id="thickness" value="<?=$thickness?>"/>
			</div>
            <div>
			  <label for="thickness">UnDel. Amount: </label>
            <input  name="thickness" type="text" id="thickness" value="<?=$thickness?>"/>
			</div>
            
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
    <? if($wo_id>0) $btn_name='Update Basic Info'; else $btn_name='Initiate Work Order'; ?>
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:200px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>
<? if($wo_id>0){?>
<form action="?req_id=<?=$req_id?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Material Name </strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Style No</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Specfication</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Mesurement</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Rate</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC"><span id="inst_no">
  <select name="item_id" id="item_id">
  <option></option>
  <? 
foreign_relation('lc_product_item','id','item_name',$item_id);?>
  </select>
  <input  name="wo_id" type="hidden" id="wo_id" value="<?=$wo_id?>"/>
</span></td>
<td bgcolor="#CCCCCC"><input name="style_no" type="text" class="input3" id="style_no"  maxlength="400" style="width:100px;"/></td>
<td bgcolor="#CCCCCC"><input name="specification" type="text" class="input3" id="specification"  maxlength="400" style="width:110px;"/></td>
<td bgcolor="#CCCCCC"><input name="meassurment" type="text" class="input3" id="meassurment"  maxlength="400" style="width:110px;"/></td>
<td bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:40px;" onblur="count()"/></td>
<td bgcolor="#CCCCCC"><input name="rate" type="text" class="input3" id="rate"  maxlength="100" style="width:40px;" onblur="count()"/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount"  maxlength="100" style="width:60px;"/></td>
      </tr>
    </table>
					  <br /><br /><br /><br />

<? 
$res='select a.id,b.item_name,a.style_no,a.specification,a.meassurment,a.qty,a.rate,a.amount,"x" from lc_workorder_details a,lc_product_item b where b.id=a.item_id and a.wo_id='.$wo_id;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';
echo link_report_add_del($res);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
<table width="100%" border="0">
  <tr>
      <td align="center">
      <input name="delete" type="submit" class="btn1" value="DELETE AND CANCEL WORK ORDER" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />
      </td><td align="center">
      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND WORK ORDER" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />
      </td>
      
    </tr>
</table>
</form>
<? }?>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>