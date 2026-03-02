<?php

session_start();

ob_start();

require "../../support/inc.all.php";

$title='Warehouse Transfer';



do_calander('#pi_date','-15','0');

do_calander('#old_production_date');

$page = 'depot_transfer_checking.php';

//if($_POST['line_id']>0) 
//
//$line_id = $_SESSION['line_id']=$_POST['line_id'];
//
//elseif($_SESSION['line_id']>0) 
//
//$line_id = $_POST['line_id']=$_SESSION['line_id'];





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

		if($_POST['flag']<1){

		$$unique_master=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Product Issued. (PI No-'.$$unique_master.')';

		}

		else {
		
			 $sql1 = 'update warehouse_transfer_master set receive_date="'.$_POST['pi_date'].'" , warehouse_from="'.$_POST['warehouse_from'].'",  
			 warehouse_to="'.$_POST['warehouse_to'].'" where pi_no = '.$$unique_master;
		 db_query($sql1);
		 
		  $sql2 = 'update warehouse_transfer_detail set pi_date="'.$_POST['pi_date'].'", warehouse_from="'.$_POST['warehouse_from'].'",  
			 warehouse_to="'.$_POST['warehouse_to'].'" where pi_no = '.$$unique_master;
		 db_query($sql2);
		 
		  $sql3 = 'update journal_item set ji_date="'.$_POST['pi_date'].'", warehouse_id="'.$_POST['warehouse_from'].'", relevant_warehouse="'.$_POST['warehouse_to'].'" where tr_from="Transfered" and item_ex>0 and sr_no = '.$$unique_master;
		 db_query($sql3);
		 
		 $sql4 = 'update journal_item set ji_date="'.$_POST['pi_date'].'", warehouse_id="'.$_POST['warehouse_to'].'", relevant_warehouse="'.$_POST['warehouse_from'].'" where tr_from="Transfered" and item_in>0 and sr_no = '.$$unique_master;
		 db_query($sql4);
		

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

		$sql = "delete from journal_item where tr_from = 'Transfered' and tr_no = '".$del."'";

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



auto_complete_from_db('item_info','item_short_name','concat(item_name,"#>",item_description,"#>",item_id)','1 ','item_id');?>





<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}



function TRcalculation(id){
var pkt_size = document.getElementById('pkt_size#'+id).value*1;
var crt_price = document.getElementById('crt_price#'+id).value*1;
var unit_price = document.getElementById('unit_price#'+id).value= (crt_price/pkt_size);
var pkt_unit = document.getElementById('pkt_unit#'+id).value*1;
var total_unit = document.getElementById('total_unit#'+id).value= (pkt_size*pkt_unit);
var crt_amt = document.getElementById('crt_amt#'+id).value= (crt_price*pkt_unit);
var total_amt = document.getElementById('total_amt#'+id).value= (unit_price*total_unit);

}


function update_edit(id)

{
var pkt_size = (document.getElementById("pkt_size#"+id).value);
var crt_price = (document.getElementById("crt_price#"+id).value);
var unit_price = (document.getElementById("unit_price#"+id).value)= (crt_price/pkt_size);
var pkt_unit = (document.getElementById("pkt_unit#"+id).value);
var total_unit  = (document.getElementById("total_unit#"+id).value)= (pkt_size*pkt_unit);
var crt_amt  = (document.getElementById("crt_amt#"+id).value)= (crt_price*pkt_unit);
var total_amt  = (document.getElementById("total_amt#"+id).value)= (unit_price*total_unit);

var info = pkt_size+"<@>"+crt_price+"<@>"+unit_price+"<@>"+pkt_unit+"<@>"+total_unit+"<@>"+crt_amt+"<@>"+total_amt;
getData2('tr_edit_ajax.php', 'ppp',id,info);
}


function recal() {

document.getElementById('total_unit').value = (((document.getElementById('total_pkt').value)*1)*((document.getElementById('pkt_size').value)*1))+((document.getElementById('total_pcs').value)*1);

}


function total_amtt() {

document.getElementById('total_amt').value = (((document.getElementById('unit_price').value)*1)*((document.getElementById('total_pcs').value)*1));

}




function submitButtonStyle(_this) {
  _this.style.backgroundColor = "red";
}



</script>

<div class="form-container_large">

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><fieldset style="width:320px;">

    <div>

      <label style="width:75px;">TR No : </label>



      <input style="width:155px;"  name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

    </div>

    
	  
	  
	  
	  <div>

      <label style="width:75px;">Invoice : </label>



          <label>

          <input type="text" name="invoice_no" id="invoice_no" value="<?=$invoice_no?>" style="width:155px;" />

          </label>

      </div>

    </fieldset></td>

    <td>

			<fieldset style="width:260px;">

			  <div>

			    <label style="width:105px;"><span style="width:75px;">TR</span> Date : </label>

			    <input style="width:135px;"  name="pi_date" type="text" id="pi_date" value="<?=$pi_date?>" required/>

	        </div>

			  <div>
             <label style="width:105px;">Company: </label>

			
			<? if($group_for<1) { ?>
		
        <select id="group_for" name="group_for"   style="width:140px;"  required>
        <option></option>
        	<?
			  foreign_relation('user_group','id','group_name',$_POST['group_for'],'1 ');
			  ?>
             
        </select>
		
		<? }?>
			
			
			<? if($group_for>0) { ?>
			<input  name="group_for2" type="text" id="group_for2"  readonly="" style="width:140px;" 
			value="<?=find_a_field('user_group','group_name','id='.$group_for)?>" required/>
			
			<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required/>
		
		<? }?>
		  
		  
          </div>

		</fieldset>	</td>

    <td><fieldset style="width:320px;">

      <div>

        <label style="width:75px;">From: </label>

   
		
		
		<select id="warehouse_from" name="warehouse_from" required  style="width:200px;" >
  
        	<?
			  foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_from,'1 ');
			  ?>
             
        </select>

      </div>

      

            <div>

        <label style="width:75px;">To: </label>

        
		
		
		<select id="warehouse_to" name="warehouse_to" required  style="width:200px;" >
  
        	<?
			  foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_to,'1 ');
			  ?>
             
        </select>

      </div>

    </fieldset></td>

  </tr>



  <tr>

    <td colspan="3"><div class="buttonrow" style="margin-left:400px;">

    <? if($$unique_master>0) {?>

<input name="new" type="submit" class="btn1" value="Update Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />

<input name="flag" id="flag" type="hidden" value="1" />

<? }else{?>

<input name="new" type="submit" class="btn1" value="Initiate Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />

<input name="flag" id="flag" type="hidden" value="0" />

<? }?>

    </div></td>

    </tr>

	  <tr>

    <td colspan="3">&nbsp;</td>

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
<?php /*?><table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
      <tr>
        <td width="44%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
        <td width="10%" align="center" bgcolor="#0099FF"><span style="font-weight: bold">Unit</span></td>
        <td width="10%" align="center" bgcolor="#0099FF"><strong>Rate</strong></td>
        <td width="12%" align="center" bgcolor="#0099FF"><strong>Quantity</strong></td>
        <td width="18%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
        <td width="6%"  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
            <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update" onclick="recal();"/>
          </div></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#CCCCCC"><div align="center">
            <input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
            <input  name="warehouse_from2" type="hidden" id="warehouse_from2" value="<?=$warehouse_from?>"/>
            <input  name="warehouse_to2" type="hidden" id="warehouse_to2" value="<?=$warehouse_to?>"/>
            <input  name="pi_date" type="hidden" id="pr_date" value="<?=$pi_date?>"/>
            <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:350px; height:20px" required onblur="getData2('depot_transfer_ajax.php', 'pr', this.value, document.getElementById('warehouse_from').value);"/>
            <input name="remarks" type="hidden" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" />
          </div></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><div align="center"><span id="pr">
            <input name="total_unit2" type="text" class="input3" id="total_unit2"  maxlength="100" style="width:80px; height:20px" required/>
            <input name="old_production_date" type="hidden" class="input3" id="stock2"  maxlength="100" style="width:60px;"/>
            <input name="unit_price" type="text" class="input3" id="unit_price"  maxlength="100" style="width:80px; height:20px"/>
            </span> </div></td>
        <td align="center" bgcolor="#CCCCCC"><input name="total_unit" type="hidden" class="input3" id="total_unit" style="width:40px;" required/>
          <input name="total_pkt" type="hidden" class="input3" id="total_pkt"  style="width:40px;" required/>
          <input name="total_pcs" type="text" class="input3" id="total_pcs"  style="width:90px; height:20px" required  onkeyup="total_amtt()"/></td>
        <td align="center" bgcolor="#CCCCCC"><input name="total_amt" type="text" class="input3" id="total_amt"  style="width:110px; height:20px" required="required"/></td>
      </tr>
    </table><?php */?>





  
  
  
  
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">&nbsp;
      <tr>
	  <br />
   
        <td><div class="tabledesign2">
          <table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody>
            
			
            <tr>
			<th width="8%" rowspan="2">S/L</th>
			<th width="31%" rowspan="2">Item Name</th>
			<th width="7%" rowspan="2">Unit  </th>
			<th width="7%" rowspan="2">CTN Price </th>
			<th width="7%" rowspan="2">CTN Size </th>
			<th colspan="2" ><center>
			  Transfer Unit 
			</center> </th>
			<th width="7%" rowspan="2">Action</th>
      		<th width="8%" rowspan="2">Delete</th>
			</tr>
            <tr>
              <th width="13%">CTN</th>
              <th width="14%">Quantity</th>
              </tr>
            

<?
$s=0;
 $res='select a.id, b.item_name,b.unit_name, a.pkt_size, a.pkt_unit, a.total_unit, a.crt_price, a.crt_amt,  a.unit_price, a.total_amt, "X" from warehouse_transfer_detail a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';

$query=db_query($res);

while($tr_item=mysqli_fetch_object($query)){
?>
<tr>
<td style="text-align:center;"><?=++$s?></td>
<td>&nbsp;<?=$tr_item->item_name?></td>
<td>&nbsp;<?=$tr_item->unit_name?></td>
<td><input type="text" name="<?='crt_price#'.$wo_item->id?>" id="<?='crt_price#'.$tr_item->id?>" value="<?=$tr_item->crt_price?>"  onchange="TRcalculation(<?=$tr_item->id?>)"  style="width:80px; height:30px;"/>
<input type="hidden" name="<?='unit_price#'.$wo_item->id?>" id="<?='unit_price#'.$tr_item->id?>" value="<?=$tr_item->unit_price?>"  onchange="TRcalculation(<?=$tr_item->id?>)"  style="width:80px; height:30px;"/></td>
<td><input type="text" name="<?='pkt_size#'.$wo_item->id?>" id="<?='pkt_size#'.$tr_item->id?>" value="<?=$tr_item->pkt_size?>"  onchange="TRcalculation(<?=$tr_item->id?>)"  style="width:80px; height:30px;"/></td>
<td><input type="text" name="<?='pkt_unit#'.$wo_item->id?>" id="<?='pkt_unit#'.$tr_item->id?>" value="<?=$tr_item->pkt_unit?>"  onchange="TRcalculation(<?=$tr_item->id?>)"  style="width:80px; height:30px;"/></td>
<td><input type="text" name="<?='total_unit#'.$tr_item->id?>" id="<?='total_unit#'.$tr_item->id?>" value="<?=$tr_item->total_unit?>" style="width:100px; ;" />
<input type="hidden" name="<?='crt_amt#'.$tr_item->id?>" id="<?='crt_amt#'.$tr_item->id?>" value="<?=$tr_item->crt_amt?>" style="width:100px; ;" />
<input type="hidden" name="<?='total_amt#'.$tr_item->id?>" id="<?='total_amt#'.$tr_item->id?>" value="<?=$tr_item->total_amt?>" style="width:100px; ;" /></td>

<td><span id="ppp"><input name="<?='edit#'.$tr_item->id?>" type="button" id="Edit" value="Edit" style="width:60px; color:#000; font-weight:700 " 
onclick="update_edit(<?=$tr_item->id?>);submitButtonStyle(this);" /></span></td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$tr_item->id?>">&nbsp;X&nbsp;</a></td>
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

<br/>
<form action="select_unapproved_depot_transfer.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="100%" border="0">

  <tr>

      <td align="center"><input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">
	  <input name="delete" type="submit" class="btn1" value="DELETE " style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:left" />

     <!-- <input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND " style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />-->

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