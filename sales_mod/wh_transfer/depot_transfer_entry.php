<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='FINISH GOODS TRANSFER ENTRY';



do_calander('#pi_date','-60','0');

do_calander('#old_production_date');

$page = 'depot_transfer_entry.php';

if($_POST['line_id']>0) 

$line_id = $_SESSION['line_id']=$_POST['line_id'];

elseif($_SESSION['line_id']>0) 

$line_id = $_POST['line_id']=$_SESSION['line_id'];





$table_master='warehouse_transfer_master';

$unique_master='pi_no';



$table_detail='warehouse_transfer_detail';

$unique_detail='id';







if($_SESSION[$unique_master]>0)

$$unique_master=$_SESSION[$unique_master];

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

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['entry_by']=$_SESSION['user']['id'];
		
		$_POST['status']='MANUAL';

		if($_POST['flag']<1){

		$$unique_master=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Product Issued. (PI No-'.$$unique_master.')';

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
		
		
		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['status']='SEND';

		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[2];

		$_POST['unit_price']=$_POST['unit_price'];
		//$_POST['total_amt']= ($_POST['total_unit'] * $_POST['unit_price']);



		$xid = $crud->insert();

		





}

}

else

{

	$type=0;

	$msg='Data Re-Submit Error!';

}



if(isset($_GET['del']) && ($_GET['del']>0) )

{	
		$del=$_GET['del'];
		$crud   = new crud($table_detail);

		$condition=$unique_detail."=".$del;		

		$crud->delete_all($condition);

		$sql = "delete from journal_item where tr_from = 'Transit' and tr_no = '".$del."'";

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



auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','1','item_id');?>



<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}

function recal() {

document.getElementById('total_unit').value = (((document.getElementById('total_pkt').value)*1)*((document.getElementById('pkt_size').value)*1))+((document.getElementById('total_pcs').value)*1);

}

function total_amtt() {

var pkt_size=(document.getElementById('pkt_size').value)*1;
var crt_price=(document.getElementById('crt_price').value)*1;
var rate=(document.getElementById('unit_price').value)=(crt_price/pkt_size);

var pkt_unit=(document.getElementById('pkt_unit').value)*1;
var total_unit=(document.getElementById('total_unit').value)=(pkt_size*pkt_unit);


document.getElementById('total_amt').value=(rate*total_unit);
document.getElementById('crt_amt').value=(crt_price*pkt_unit);


//document.getElementById('total_unit').value = (((document.getElementById('pack_size').value)*1)*((document.getElementById('pack_unit').value)*1));

}

</script>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style2 {color: #FFFFFF}
-->
</style>


<div class="form-container_large">
  <form action="<?=$page?>" method="post" name="codz2" id="codz2">
    <table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="100%" align="center"><fieldset style="width:100%;">
          <div>
            <label style="width:120px;">TR No : </label>
            <input style="width:200px;"  name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>
			
			<input type="hidden" name="group_for" id="group_for" value="<?=$_SESSION['user']['group'];?>" style="width:200px;" />
          </div>
          
          
		  
		  <div>
            <label style="width:120px;"><span style="width:75px;">TR</span> Date : </label>
            <input style="width:200px;"  name="pi_date" type="text" id="pi_date" value="<?=($pi_date!='')?$pi_date:date('Y-m-d')?>"  required/>
          </div>
		  
		  
		  <div>
            <label style="width:120px;">From: </label>
			<input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$line_id?>" />
            <input name="warehouse_from3" readonly="" type="text" id="warehouse_from3" style="width:200px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" />
          </div>
          <div>
            <label style="width:120px;">To: </label>

			
			<? if($warehouse_to<1) { ?>
		
        <select id="warehouse_to" name="warehouse_to" required  style="width:200px;" >
        <option></option>
        	<?
			  foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_to'],'warehouse_id!="'.$line_id.'" ');
			  ?>
        </select>
		
		<? }?>
			
			
			<? if($warehouse_to>0) { ?>
			<input  name="warehouse_to2" type="text" id="warehouse_to2"  readonly="" style="width:200px;" 
			value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_to)?>" required/>
			
			<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>" required/>
		
		<? }?>
          </div>
		  
		  
          </fieldset></td>
        
      </tr>
      <tr>
        <td width="100%" align="center"><div class="buttonrow" >
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
    <? if($$unique_master>0){?>
  <table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>
    </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created By:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
    <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="print_view_receive.php?pi_no=<?=$pi_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created On:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=$entry_at?></td>
    </tr>
</table>
<? }?>
  
  <form action="<?=$page?>" method="post" name="codz2" id="codz2">
    <? if($$unique_master>0){?>
	
	
    <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:2px solid #fff;" cellpadding="2" cellspacing="2">
      <tr>
        <td width="38%" align="center" bgcolor="#215470"><span class="style1">Item Name</span></td>
        <td align="center" bgcolor="#215470">
		  <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:2px solid #fff;" >
		  	<tr>
					<td width="25%"><span class="style1">Stock Pcs</span></td>
					<td width="25%"><span class="style1">Stock Ctn</span></td>
					<td width="25%"><span class="style1">CTN Price </span></td>
					<td width="25%"><span class="style1">CTN Size </span></td>
			</tr>
		  </table>
		
		</td>
        <td width="14%" align="center" bgcolor="#215470"><span class="style2"><strong>No. of CTN </strong></span></td>
        <td width="10%" align="center" bgcolor="#215470"><span class="style2"><strong>No. of Units</strong></span></td>
        <td width="4%"  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
            <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update" onclick="recal();"/>
        </div></td>
      </tr>
      
      <tr>
        <td align="center" bgcolor="#CCCCCC"><div align="center">
            <input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
			<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>"/>
            <input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>
            <input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
            <input  name="pi_date" type="hidden" id="pr_date" value="<?=$pi_date?>"/>
            <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:350px; " required onblur="getData2('depot_transfer_ajax.php', 'pr', this.value, document.getElementById('warehouse_from').value);"/>
            <input name="remarks" type="hidden" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" />
          </div></td>
        <td align="center" bgcolor="#CCCCCC"><div align="center"><span id="pr">
			<table>
			<tr>
			
			<td width="25%">
			
            <input name="stockpcs" type="text" class="input3" id="stockpcs"  maxlength="100" style="width:70px;"/>			</td>
			<td width="25%">
			
            <input name="stockcrt" type="text" class="input3" id="stockcrt"  maxlength="100" style="width:70px;"/>			</td>
			<td width="25%">
            <input name="crt_price" type="text" class="input3" id="crt_price"  maxlength="100" style="width:70px;"/>			</td>
			<td width="25%">
            <input name="pack_size" type="text" class="input3" id="pack_size"  maxlength="100" style="width:70px;"/>			</td>
			</tr>
			</table>
            </span> </div></td>
        <td align="center" bgcolor="#CCCCCC">
          <input name="pkt_unit" type="text" class="input3" id="pkt_unit"  style="width:90px; " required  onkeyup="total_amtt()"/></td>
        <td align="center" bgcolor="#CCCCCC"><input name="total_unit" type="text" class="input3" id="total_unit"  style="width:110px; " required="required"/>
		<input name="total_amt" type="hidden" class="input3" id="total_amt"  style="width:110px; " required="required"/>
		<input name="crt_amt" type="hidden" class="input3" id="crt_amt"  style="width:110px; " required="required"/></td>
      </tr>
    </table>
    <br />
    <br />
    <br />
    <br />
    <? 



//$res='select a.id,b.finish_goods_code as code,b.item_name,b.unit_name,FLOOR(a.total_unit/b.pack_size) as total_qty,a.total_unit%b.pack_size as pcs_qty,"X" from warehouse_transfer_detail a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';


$res='select a.id,b.item_name as Product_name,b.unit_name as unit, a.pkt_size as Units_in_CTN, a.pkt_unit as CTN_unit, a.total_unit as total_unit, a.crt_price as CTN_Price, a.crt_amt as Amount, "X" from warehouse_transfer_detail a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';

?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="tabledesign2">
            <? 

echo link_report_add_del_auto($res,1,5,8);

		?>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
  </form>
  <br />
  <form action="select_depot.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    <table width="100%" border="0">
      <tr>
        <td align="center"><input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/></td>
        <td align="right" style="text-align:right">
		<input name="delete" type="submit" class="btn1" value="DELETE" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090; float:left" />
		
		<input name="confirm" type="submit" class="btn1" value="CONFIRM " style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />
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
