<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Receive from Sales Depot';

do_calander('#pr_date','-15','0');
$page = 'production_receive.php';
if($_POST['line_id']>0) 
$line_id = $_SESSION['line_id']=$_POST['line_id'];
elseif($_SESSION['line_id']>0) 
$line_id = $_POST['line_id']=$_SESSION['line_id'];


$table_master='production_receive_master';
$unique_master='pr_no';

$table_detail='production_receive_detail';
$unique_detail='id';



if($_REQUEST['old_pr_no']>0)
$$unique_master=$_REQUEST['old_pr_no'];
elseif(isset($_GET['del']))
{$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];}
else
$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){
if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		if($_POST['flag']<1){
		$$unique_master=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Product Received. (PI No-'.$$unique_master.')';
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
		$_POST['unit_price']= find_a_field('item_info','cost_price','item_id='.$_POST['item_id']);
		$_POST['total_amt']= ($_POST['total_unit'] * $_POST['unit_price']);
		$_POST['status'] = 'RECEIVED';
		$xid = $crud->insert();
		journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['pr_date'],$_POST['total_unit'],'0','Receive',$xid,'','',$_SESSION['line_id']);
		journal_item_control($_POST['item_id'] ,$_SESSION['line_id'],$_POST['pr_date'],'0',$_POST['total_unit'],'Receive',$xid,'','',$_SESSION['user']['depot']);
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

		$sql = "delete from journal_item where tr_from = 'Receive' and tr_no = '".$del."'";
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
		auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','product_nature="Salable"','item_id');
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
      <label style="width:75px;">Receive No: </label>

      <input style="width:155px;"  name="pr_no" type="text" id="pr_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>
    </div>
    <div>
      <label style="width:75px;">Received by:</label>
          <select style="width:155px;" id="carried_by" name="carried_by" readonly="readonly">
            <option value="<?=$dealer->depot;?>">
                <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$carried_by);?>
              </option>
          </select>
      </div>
    </fieldset></td>
    <td>
			<fieldset style="width:220px;">
			  <div>
			    <label style="width:105px;">Receive Date : </label>
			    <input style="width:105px;"  name="pr_date" type="text" id="pr_date" value="<?=$pr_date?>" readonly/>
		      </div>
			  <div>
			    <label style="width:105px;">Note: </label>
			    <input name="remarks" type="text" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" />
		      </div>
		</fieldset>	</td>
    <td><fieldset style="width:240px;">
      <div>
        <label style="width:75px;">To: </label>
        <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$_SESSION['user']['depot']?>" />
        <input name="warehouse_from3" type="text" id="warehouse_from3" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" />
      </div>
      
            <div>
        <label style="width:75px;">Depot: </label>
        <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$line_id?>" />
        <input name="warehouse_from4" type="text" id="warehouse_from4" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" />
      </div>
    </fieldset></td>
  </tr>
  <tr>
    <td colspan="3"><div class="buttonrow" style="margin-left:240px;">
    <? if($$unique_master>0) {?>
<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="1" />
<? }else{?>
<input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="0" />
<? }?>
    </div></td>
    </tr>
</table>
</form>
<form action="<?=$page?>" method="post" name="codz2" id="codz2">
<? if($$unique_master>0){?>
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
    <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">Unit</span></td>
    <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">Stk</span></td>
    <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">LIQ </span></td>
    <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">LID</span></td>
    <td align="center" bgcolor="#0099FF"><strong> Qty</strong></td>
    <td  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
      <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>
    </div></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC">
    <input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
    <input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>
    <input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
      <input  name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date?>"/>
      <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:300px;" required onblur="getData2('production_receive_ajax.php', 'pr', this.value, document.getElementById('warehouse_from').value);"/></td>
    <td colspan="4" align="center" bgcolor="#CCCCCC"><span id="pr">
    <input name="total_unit2" type="text" class="input3" id="total_unit2"  maxlength="100" style="width:77px;" required/>
    <input name="total_unit3" type="text" class="input3" id="total_unit3"  maxlength="100" style="width:67px;" required/>
    <input name="total_unit4" type="text" class="input3" id="total_unit4"  maxlength="100" style="width:67px;" required/>
    <input name="total_unit5" type="text" class="input3" id="total_unit5"  maxlength="100" style="width:67px;" required/>
    </span></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit" type="text" class="input3" id="total_unit"  maxlength="100" style="width:67px;" required/></td>
  </tr>
</table>
<br /><br /><br /><br />

<? 
$res='select a.id,b.item_id as item_code,b.item_name,b.unit_name,a.total_unit,"X" from production_receive_detail a,item_info b where b.item_id=a.item_id and a.pr_no='.$$unique_master.' order by a.id';
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
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
<form action="select_prodiction_line_r.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="100%" border="0">
  <tr>
      <td align="center"><input  name="pr_no" type="hidden" id="pr_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">
      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND PR" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />
      </td>
    </tr>
</table>


<? }?>
</form>
</div>
<script>$("#cz").validate();$("#cloud").validate();</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>