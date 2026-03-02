<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Staff Sales Order Create';

//do_calander('#est_date');

do_calander('#do_date');
$page = 'do.php';
if($_POST['dealer']>0) 
$dealer_code = $_POST['dealer'];
$dealer = find_all_field('personnel_basic_info','','PBI_ID='.$dealer_code);

$table_master='sale_other_master';
$unique_master='do_no';

$table_detail='sale_other_details';
$unique_detail='id';



if($_REQUEST['old_do_no']>0)
$$unique_master=$_REQUEST['old_do_no'];
elseif(isset($_GET['del']))
{$$unique_master=find_a_field('sale_other_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}
else
$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){
if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		if($_POST['flag']<1){
		$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;
		$$unique_master=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
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

		$_POST['total_unit'] = ($_POST['pkt_unit'] * $_POST['pkt_size']) + $_POST['dist_unit'];
		if($_POST['unit_price2']==0) $_POST['unit_price'] = 0;
		$_POST['total_amt'] = ($_POST['total_unit'] * $_POST['unit_price']);
		$_POST['t_price'] = find_a_field('item_info','t_price','item_id ='.$_POST['item_id']);
		$_POST['gift_on_order'] = $crud->insert();
		$do_date = date('Y-m-d');
		$_POST['gift_on_item'] = $_POST['item_id'];


}
}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}

if($del>0)
{	

		$main_del = find_a_field($table_detail,'gift_on_order','id = '.$del);
		$crud   = new crud($table_detail);
		if($del>0)
		{
			$condition=$unique_detail."=".$del;		
			$crud->delete_all($condition);
			
			$condition="gift_on_order=".$del;		
			$crud->delete_all($condition);
			
			if($main_del>0){
			$condition=$unique_detail."=".$main_del;		
			$crud->delete_all($condition);
			$condition="gift_on_order=".$main_del;		
			$crud->delete_all($condition);}
		}
		$type=1;
		$msg='Successfully Deleted.';
}


if($$unique_master>0)
{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=@each($data))
		{ $$key=$value;}
		
}
		$dealer = find_all_field('personnel_basic_info','','PBI_ID='.$dealer_code);
		if($dealer->product_group!='M') $dgp = $dealer->product_group;
auto_complete_start_from_db('item_info','concat(finish_goods_code,"#>",item_name)','finish_goods_code','product_nature="Salable" and sales_item_type like "%'.$dgp.'%" order by finish_goods_code','item');
?>
<script language="javascript">
function count()
{
if(document.getElementById('pkt_unit').value!=''){
var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
var dist_unit = ((document.getElementById('dist_unit').value)*1);
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var unit_price2 = ((document.getElementById('unit_price2').value)*1);
var total_unit = (pkt_unit*pkt_size)+dist_unit;
if(unit_price2==0)
var unit_price =0;
else
var unit_price = ((document.getElementById('unit_price').value)*1);
var total_amt  = (total_unit*unit_price);
document.getElementById('total_unit').value=total_unit;
document.getElementById('total_amt').value	= total_amt.toFixed(2);
var do_total = ((document.getElementById('do_total').value)*1);
var do_ordering	= total_amt+do_total;
document.getElementById('do_ordering').value =do_ordering.toFixed(2);
}
else
document.getElementById('pkt_unit').focus();
}
</script>

<script language="javascript">
function focuson(id) {
  if(document.getElementById('item').value=='')
  document.getElementById('item').focus();
  else
  document.getElementById(id).focus();
}

window.onload = function() {
if(document.getElementById("flag").value=='0')
  document.getElementById("rcv_amt").focus();
  else
  document.getElementById("item").focus();
}
</script>
<script language="javascript">
function grp_check(id)
{
getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$dealer->depot;?>');
}
</script>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>

<div class="form-container_large">
<form action="<?=$page?>" method="post" name="codz2" id="codz2">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset style="width:350px;">
    <div>
      <label style="width:120px;">Order No : </label>

      <input style="width:155px;"  name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
    </div>
    <div>
			    <label style="width:120px;">Order Date : </label>
			    <input style="width:105px;"  name="do_date" type="text" id="do_date" value="<?=($do_date==''?date('Y-m-d'):$do_date)?>" required />
		      </div>
    <div>
      <label style="width:120px;">Emp Name : </label>
        <select style="width:145px;" id="dealer_code" name="dealer_code" readonly="readonly">
        <option value="<?=$dealer->PBI_ID;?>"><?=$dealer->PBI_ID.'-'.$dealer->PBI_NAME;?></option>
        </select><input style="width:10px;"  name="issue_type" type="hidden" id="issue_type" value="StaffSales"/>
    </div>



        <div>
          <label style="width:120px;">Depot : </label>
          <select style="width:155px;" id="depot_id" name="depot_id" required>
            
                <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,' group_for=1');?>
          </select>
        </div>
    </fieldset></td>
    <td><fieldset style="width:350px;">
    <div>
        <label style="width:120px;">Rcv Amt: </label>
        <input name="rcv_amt" type="text" id="rcv_amt" style="width:155px;" value="<?=$rcv_amt?>" tabindex="101" />
      </div>
            <div>
        <label style="width:120px;">Payment By: </label>
        <select style="width:155px;" id="payment_by" name="payment_by" tabindex="102">
			<option value="Salary Adjustment" <?=($payment_by=='Salary Adjustment')?'selected':''?>>Salary Adjustment</option>
			<option value="Cash Reveive" <?=($payment_by=='Cash Reveive')?'selected':''?>>Cash Reveive</option>
        </select>
      </div>
          
            
      
      <div>
        <label style="width:120px;">Approved By: </label>
        <input name="remarks" type="text" id="remarks" style="width:155px;" value="<?=$remarks?>" tabindex="105" />
      </div>
            <div>
        <label style="width:120px;">Note: </label>
        <input name="delivery_address" type="text" id="delivery_address" style="width:155px;" value="<?=$delivery_address?>" tabindex="105" />
      </div>
    </fieldset></td>
  </tr>
  <tr>
    <td colspan="3">
	<div class="buttonrow" style="margin-left:240px;">
		<? if($$unique_master>0) {?>
		<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
		<input name="flag" id="flag" type="hidden" value="1" />
		<? }else{?>
		<input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
		<input name="flag" id="flag" type="hidden" value="0" />
		<? }?>
		</div>	</td>
    </tr>
</table>
</form>
<form action="<?=$page?>" method="post" name="codz2" id="codz2">
<? if($$unique_master>0){?>
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
                      <tr>
                            <td colspan="3" align="right" bgcolor="#009966" style="text-align:right"><strong>Total Ordering: 
                            </strong>
<?
$total_do = find_a_field($table_detail,'sum(total_amt)',$unique_master.'='.$$unique_master);
?>
					  <input type="text" name="do_ordering" id="do_ordering" value="<?=$total_do?>" style="float:right; width:100px;" disabled="disabled" readonly="readonly" />
					  <input type="hidden" name="do_total" id="do_total" value="<?=$total_do?>" />&nbsp;</td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Code</strong></td>
                        <td align="center" bgcolor="#0099FF"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                          <tr>
<td align="center" bgcolor="#0099FF" width="42%"><strong>Item Name</strong></td>
<td align="center" bgcolor="#0099FF" width="10%"><strong>In Stk</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>UnDel</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Price</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Crt Qty</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Pcs</strong></td>
<td align="center" bgcolor="#0099FF" width="12%"><strong>Total</strong></td>
                          </tr>
                        </table></td>
                        <td  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
                          <input name="add" type="submit" id="add" value="ADD" onclick="count()" class="update" tabindex="5"/>
                        </div></td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<span id="inst_no">
<input name="item" type="text" class="input3" id="item"  style="width:80px;" required onblur="grp_check(this.value);" tabindex="1"/>
<input name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>" readonly="readonly"/>
<input name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly="readonly"/>
<input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
<input name="depot_id" type="hidden" id="depot_id" value="<?=$dealer->depot;?>"/>
<input name="flag" id="flag" type="hidden" value="1" />
</span>
<input style="width:10px;"  name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly="readonly"/>
<input style="width:10px;"  name="issue_type" type="hidden" id="issue_type" value="StaffSales"/></td>

<td bgcolor="#CCCCCC">
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#CCCCCC"><span id="do"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td><input name="item2" type="text" class="input3" id="item2"  style="width:260px;" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('pkt_unit')"/></td>
  <td><input name="in_stock" type="text" class="input3" id="in_stock"  style="width:55px;" value="<?=$in_stock?>" readonly="readonly" onfocus="focuson('pkt_unit')"/>
  <input name="item_id" type="hidden" class="input3" id="item_id"  style="width:55px;"  value="<?=$item_all->item_id?>" readonly="readonly"/></td>
  <td><input name="undel" type="text" class="input3" id="undel"  style="width:55px;" readonly="readonly"  value="<?=($ordered_qty+$del_qty)?>"/></td>
  <td><input name="unit_price" type="text" class="input3" id="unit_price"  style="width:55px;" value="<?=$item_all->d_price?>" readonly="readonly"/>
  <input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:55px;"  value="<?=$item_all->pack_size?>" readonly="readonly"/></td>
  </tr>
      </table></span></td>
  <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><input name="pkt_unit" type="text" class="input3" id="pkt_unit" style="width:55px;" onkeyup="count()" required="required"  tabindex="4"/></td>
      <td><input name="dist_unit" type="text" class="input3" id="dist_unit" style="width:55px;" onkeydown="count()"/></td>
      <td><input name="total_unit" type="hidden" class="input3" id="total_unit"  style="width:55px;" readonly="readonly"/>
        <input name="total_amt" type="text" class="input3" id="total_amt" style="width:70px;" readonly="readonly"/></td>
      </tr>
  </table></td>
  </tr>
  </table>
  
</td>
</tr>
    </table>
					  
					  <br /><br /><br /><br />

<? 
$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price as dPrice,a.pkt_unit as crt_qty,a.dist_unit as pcs ,a.total_amt,"X" from sale_other_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
echo link_report_add_del_auto($res,'',5);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>

</form>
<form action="select_dealer_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="100%" border="0">
  <tr>
      <td align="center">
      <input name="delete"  type="submit" class="btn1" value="DELETE DO" style="width:100px; font-weight:bold; font-size:12px;color:#F00; height:30px" />
      <input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">
      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND WORK ORDER" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />
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