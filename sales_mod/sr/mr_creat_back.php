<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='New Material Requisition Create (Factory Indent)';


do_calander('#need_by');

$table_master='requisition_master';

$table_details='requisition_order';

$unique='req_no';



if($_GET['mhafuz']>0)

unset($_SESSION[$unique]);



if(isset($_POST['new']))

{

		$crud   = new crud($table_master);

		if($_SESSION[$unique] < 1) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');
		$_POST['status'] ="MANUAL";

		 
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

//auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','1 and sub_group_id!="1096000900010000"','item_id');

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_name,"#>",item_id)','1 and sub_group_id!="1096000900010000"','item_id');


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


<script>

/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////

function insert_item(){
var item1 = $("#item_id");
var dist_unit = $("#qty");


if(item1.val()=="" || dist_unit.val()==""){
	 alert('Please check Item ID,Qty');
	  return false;
	}


	
$.ajax({
url:"mr_input_ajax.php",
method:"POST",
dataType:"JSON",

data:$("#codz").serialize(),

success: function(result, msg){
var res = result;

$("#codzList").html(res[0]);	
$("#t_amount").val(res[1]);


$("#item_id").val('');
$("#qty").val('');
$("#remarks").val('');
$("#qoh").val('');

}
});	

//}else{ alert('Please Enter Debit Ledger'); }
//}else{ alert('Please check Ledger,amount and Date'); }

  }
/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////


</script>

<style>
label{
	color: black;
}
</style>
<div class="form-container_large">

<form action="mr_create.php" method="post" name="codz2" id="codz2" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

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

        <label for="<?=$field?>">Warehouse:</label>

		<input name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>" />

		<input name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" readonly=""/>
      </div>

    </fieldset></td>

    <td>

			<fieldset>

			

   

      <div>

        <label for="<?=$field?>">Depot:</label>

        <!--<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>-->
		
				<select name="depot" id="depot">
                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'use_type!="PL"');?>
             </select>
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
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>

    <td colspan="2"><div class="buttonrow text-center" ><span class="buttonrow" >

      <? if($$unique_master>0) {?>
         <!-- <input name="new" type="submit" class="btn1" value="Update Sales Return" style="width:200px; font-weight:bold; font-size:12px; tabindex="12>-->
		  <button type="submit" name="new" id="new" class="btn btn-success">Update Requsition Information</button>
          <input name="flag2" id="flag2" type="hidden" value="1" />
          <? }else{?>
          <!--<input name="new" type="submit" class="btn1" value="Initiate Sales Return" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />-->
		  <button type="submit" name="new" id="new" class="btn btn-primary">Initiate  Requsition Information</button>
          <input name="flag2" id="flag2" type="hidden" value="0" />
          <? }?>
        </span></div>
		
		</td>

    </tr>
  <tr>

    <td colspan="2"><div class="buttonrow" >

      <div align="center"></div>
    </div></td>
    </tr>
</table>

</form>

<? if($_SESSION[$unique]>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="codz" id="codz">

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="25%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>

                        <td width="10%" align="center" bgcolor="#0099FF"><strong>Stk Qty</strong></td>

                        <td width="10%" align="center" bgcolor="#0099FF"><strong>LPQ</strong></td>

                        <td width="10%" align="center" bgcolor="#0099FF"><strong>LPD</strong></td>

                        <td width="10%" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>

                        <td width="10%" align="center" bgcolor="#0099FF"><strong>Req Qty</strong></td>

                          <td width="10%" align="center" bgcolor="#0099FF"><strong>Remarks</strong></td>
                          <td width="10%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="button" id="add" value="ADD" onclick="insert_item()"  tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>

                      <tr>

                        <td align="center" bgcolor="#CCCCCC"><input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

                            <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

                            <input  name="req_date" type="hidden" id="req_date" value="<?=$req_date?>"/>

                            <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:98%;background-color:white;" required="required" onblur="getData2('mr_ajax.php', 'mr', this.value, document.getElementById('warehouse_id').value);"/></td>

                        <td colspan="4" align="center" bgcolor="#CCCCCC">
						<div align="right"><span id="mr">
						<table style="width:100%;" border="1">
						 <tr>
						
                        <td width="25%"><input name="qoh" type="text" class="input3" id="qoh" style="width:98%;" onfocus="focuson('qty')" /></td>
                        
                        <td width="25%"><input name="last_p_qty" type="text" class="input3" id="last_p_qty" style="width:98%;" onfocus="focuson('qty')" /></td>
                        
                        <td width="25%"><input name="last_p_date" type="text" class="input3" id=" 	last_p_date"  style="width:98%;" onfocus="focuson('qty')" /></td>
                          
                        <td width="25%"><input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:98%;" onfocus="focuson('qty')" /></td>
                          
						</tr>	
						</table>
						</span></div>	
						</td>

                   
                     
                        <td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width: 98%;background-color:white;" required/></td>
      <td align="center" bgcolor="#CCCCCC">
	  	<select name="remarks" id="remarks" style="width:98%;">
          <option></option>
          <option>Urgent</option>
        </select>	  </td>
      </tr>
    </table>

<br /><br /><br /><br />

<? 

//$res='select a.id,concat(b.item_name," :: ",b.item_description) as item_name,a.qoh as stock_qty,a.last_p_qty as last_pur_qty,a.last_p_date as last_pur_date,a.qty,"x" from requisition_order a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;


 $res='select a.id,concat(b.item_name) as item_name,a.qoh as stock_qty,a.last_p_qty as last_pur_qty,a.last_p_date as last_pur_date,a.qty, a.remarks,"x" from requisition_order a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;



?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td><div class="tabledesign2">
            <span id="codzList">
        <? 

//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';

echo link_report_del($res);

		?>
       </span>
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

      <td align="center"><div class="buttonrow" >



      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL REQUSITION"  />



      </div></td>

      <td align="center"><div class="buttonrow" >



      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD REQUSITION" />



      </div></td>

    </tr>

  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>