<?


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#jv_date');

do_calander('#c_date');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$title='Receipt Voucher';

$proj_id=$_SESSION['proj_id'];

$user_id=$_SESSION['user']['id'];

$tr_from = 'Receipt';

//var_dump($_SESSION['jv_no']);

if($_GET['mhafuz']>0){

unset($_SESSION['jv_no']);

unset($_SESSION['tr_no']);

}

if($_GET['jv_no']>0){

$_SESSION['jv_no']=$_GET['jv_no'];

}

if($_GET['tr_no']>0){

$_SESSION['tr_no']=$_GET['tr_no'];

}

if($_GET['update']>0){
   $sql1 = 'update secondary_journal set checked = "UNFINISHED" where jv_no ='.$_SESSION['jv_no'].' and tr_from ="'.$_GET['v_type'].'"';
   $delDr = 'delete from secondary_journal where dr_amt>0 and jv_no ='.$_SESSION['jv_no'].' and tr_from ="'.$_GET['v_type'].'" ' ;
   $delSql = 'delete from journal where jv_no ='.$_SESSION['jv_no'].' and tr_from ="'.$_GET['v_type'].'" ' ;
   
   db_query($sql1);
   db_query($delDr);
   db_query($delSql);
   
   unset($_GET['update']);
}


//------------------------------Single row delete area------------------------------//

if($_GET['del']>0){
  $delsql='delete from secondary_journal where id ='.$_GET['del'];
  db_query($delsql);
  header('Location:credit_note.php');
}

//------------------------------Single row delete area End------------------------------//
//else

//{

//    $jv_no = $_SESSION['jv_no'] = next_journal_sec_voucher_id($tr_from);

//	$tr_no = $_SESSION['tr_no'] = next_tr_no($tr_from);

//

//}

$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' and group_for=".$_SESSION['user']['group']);

///////////////////

if(isset($_POST['add']))

{   

$v_date		= $_SESSION['old_v_date']=$_REQUEST["date"];

$ledger_id	= $_REQUEST["ledger_id"];

$bank		= $_REQUEST["bank"];

$r_from		= $_REQUEST['r_from'];

$c_no		= $_REQUEST['c_no'];

$cheq_date		= $_REQUEST['c_date'];

$c_id		= $_REQUEST['c_id'];

$jv_date		= $_REQUEST['jv_date'];

$type		= $_REQUEST['type'];

//$bi_id		= explode('##>>',$_REQUEST['b_id']);

//$b_id		= $bi_id[1];

$b_id = $_REQUEST['b_id'];

$t_amount	= $_REQUEST['t_amount'];

if($type=='CASH'){

$receive_ledger=$c_id;

}else{

$receive_ledger=$b_id;

}

$ledgers = explode('::',$receive_ledger);

$search=array( ":"," ", "[", "]", $separater);

$ledger1=str_replace($search,'',$ledgers[0]);

$ledger2=str_replace($search,'',$ledgers[1]);

if(is_numeric($ledger1))

$receive_ledger = $ledger1;

else

$receive_ledger = $ledger2;

//////////////////////////

$ledger_id=$_REQUEST['ledger_id'];

$ledgers = explode('::',$ledger_id);

$ledger_id = $ledgers[0];

$detail_status = $_REQUEST['detail'];		

$cur_bal= $_REQUEST['cur_bal'];

$detail = $_REQUEST['detail'];

$amount = $_REQUEST['amount'];

$cc_code = $_REQUEST['cc_code'];

if($bank=='')

$dnarr=$detail;

else

$dnarr=$detail.':: Cheq# '.$c_no.':: Date= '.$cheq_date;

$checked = 'UNFINISHED';

if($_SESSION['jv_no']==0){

$jv_no = $_SESSION['jv_no'] = next_journal_sec_voucher_id($tr_from,'Receipt');

$tr_no = $_SESSION['tr_no'] = next_tr_no($tr_from);

}

else{

$jv_no = $_SESSION['jv_no'];

$tr_no = $_SESSION['tr_no'];

}

//add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr,  '0', $amount, $tr_from, $tr_no,'','',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$receive_ledger,$checked,$type,$employee);

}

if(isset($_POST['limmit'])){

if($_SESSION['tr_no']>0){

///-------------- for unfinished Entry ------//
    $credit_check = find_a_field('secondary_journal','sum(dr_amt)','tr_from like "Receipt" and jv_no='.$_SESSION['jv_no']);
			
			if($credit_check>0){ 
			   $table='secondary_journal';
               $condition='dr_amt>0 and tr_from like "Receipt" and jv_no ='.$_SESSION['jv_no'];
               db_delete($table,$condition); 
			}
///-------------- for unfinished Entry ------//

$j_data = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');

$detail = 'Received from '.$j_data->received_from;

add_to_sec_journal($proj_id, $j_data->jv_no, $j_data->jv_date, $j_data->relavent_cash_head,  $detail,$_POST['t_amount'], '0', $tr_from, $j_data->tr_no,'','',$j_data->cc_code,'',$j_data->user_id,'',$j_data->received_from,$j_data->bank,$j_data->cheq_no,$j_data->cheq_date,$j_data->relavent_cash_head,$checked,$j_data->type,$j_data->employee_id);

$up = 'update secondary_journal set checked="NO" where jv_no="'.$_SESSION['jv_no'].'"';

db_query($up);

$_SESSION['jv_no']     = '';

$_SESSION['receipt_no'] = '';

}else{

$msg = '<span style="color:red">Data Re-Submit Not Allowed..!</span>';

$_SESSION['receipt_no'] = '';


}


$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');

if($jv_config=="Yes"){

			    $condition='DELETE FROM `journal` WHERE tr_from like "Receipt" and jv_no ='.$j_data->jv_no;
			    db_query($condition);

sec_journal_journal($j_data->jv_no,$j_data->jv_no,$tr_from);

$time_now = date('Y-m-d H:i:s');

$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);

}

}

$jv = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');

if($_SESSION['jv_no']==0){

$jv_no = next_journal_sec_voucher_id($tr_from,'Receipt');

$tr_no = next_tr_no($tr_from);

}

else{

$jv_no = $_SESSION['jv_no'];

$tr_no = $_SESSION['tr_no'];

}


 if($jv->tr_no==0){ 
create_combobox('bank_disable_id');
create_combobox('cash_disable_id');
}
js_ledger_subledger_autocomplete_new('receipt',$proj_id,$voucher_type,$_SESSION['user']['group']); 
//create_combobox('ledger_id');
?>

<script type="text/javascript">

function DoNav(theUrl)

{

var URL = 'voucher_view_popup.php?'+theUrl;

popUp(URL);

}

function cb_set(va)

{

if(va='BANK'){

$("#c_id").val("0");

$('#c_id').attr('disabled', 'disabled');

$('#b_id').removeAttr('disabled');

}

if(va='CASH'){

$("#b_id").val("0");

$('#b_id').attr('disabled', 'disabled');

$('#c_id').removeAttr('disabled');

}

}

function Do_Nav()

{

var URL = 'pop_invoice_paid.php';

popUp(URL);

}

function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<!--<script type="text/javascript" src="../../common/js/check_balance.js"></script>-->

<script type="text/javascript" src="../../common/receipt_check.js"></script>

<script language="javascript" type="text/javascript">

function goto_tab()

{

document.getElementById('ledger_id').focus()

}

function check_status(values){

if(values=="BANK"){

document.getElementById("cash_disable_id").disabled = true;

document.getElementById("bank_disable_id").disabled = false;

}else if(values=="CASH"){

document.getElementById("bank_disable_id").disabled = true;

document.getElementById("cash_disable_id").disabled = false;

}

}

function check_type()

{

var check_type = document.getElementById('type').value;

if(check_type=='CASH'){

document.getElementById('bank_check').style.display='none';

document.getElementById('check_no_check').style.display='none';

document.getElementById('check_date_check').style.display='none';

document.getElementById('of_bank_check').style.display='none';

var kamrul = <? find_a_field('secondary_journal','sum(dr_amt)','1');?> +'ds';
console.log(kamrul);

}else{

document.getElementById('bank_check').style.display='';

document.getElementById('check_no_check').style.display='';

document.getElementById('check_date_check').style.display='';

document.getElementById('of_bank_check').style.display='';

}

if(check_type=='BANK'){

document.getElementById('cash_check').style.display='none';

}else{

document.getElementById('cash_check').style.display='';

}

}



function insert_item(){
var ledger_id = $("#ledger_id");
var amount = $("#amount");
var jv_date = $("#jv_date");
var cash_ledger = $("#cash_disable_id");
var bank_ledger = $("#bank_disable_id");

if(ledger_id.val()=="" || amount.val()=="" || jv_date.val()=="" || jv_date.val()=="0000-00-00" ){
	 alert('Please check Ledger,amount and Date');
	  return false;
	}
	
if(cash_ledger.val()=="" || bank_ledger.val()==""){	
      alert('Please Enter Debit Ledger');
	  return false;
	 } 
	

$.ajax({
url:"credit_note_ajax.php",
method:"POST",
dataType:"JSON",

data:$("#codz").serialize(),

success: function(result, msg){
var res = result;

$("#codzList").html(res[0]);	
$("#t_amount").val(res[1]);

$("#ledger_id").val('');
$("#amount").val('');

$("#cash_disable_id").attr("disabled", true);
document.getElementById("receipt_varify").style.visibility = "";
}
});	

//}else{ alert('Please Enter Debit Ledger'); }
//}else{ alert('Please check Ledger,amount and Date'); }

  }



window.onload=check_type;

</script>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>


<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">

<tr>

<td><div>

<table class="fontc" width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td>

<div align="left">

<form id="codz" name="codz" method="post" action="?" onsubmit="return checking()">

<table border="2" style="border:1px solid #C1DAD7; border-collapse:collapse; width:100%" >

<tr>

<td >

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td valign="top" style="text-align:left;" ><table width="95%" border="0" cellspacing="2" cellpadding="2" style="margin-right:15px;">



<tr>

<td><div align="right">Voucher Date:</div></td>

<td>


<? 

$receiptno=next_invoice('tr_no','secondary_journal');

if($v_d>10000)

$v_d=date("d-m-y",$v_d);

if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; } 

elseif($old_voucher_mode==1){$v_no_show='value="'.$receiptno.'" readonly'; } 

else $v_no_show='';

 $_SESSION['jv_no'];

?>

<input name="receipt_no" type="hidden" id="receipt_no" size="15" value="<?=$tr_no?>" <? if($jv->tr_no>0) echo 'disabled'?> />

<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>


<input autocomplete="off" name="jv_date" type="text" id="jv_date" value="<?php echo $jv->jv_date?>" size="10" <?php /*?><? if($jv->tr_no>0) echo 'disabled'?><?php */?>  tabindex="1"required />



</td>

<td align="right">Type:</td>

<td><? if($jv->tr_no>0){ ?><input type="text" name="type" id="type" value="<?=$jv->type?>" readonly="readonly"  /><? }else{?><select name="type" id="type" required onChange="check_type()" >

<option value="0"></option>

<option value="CASH" <?=($jv->type=='CASH')?'Selected':'';?> >CASH</option>

<option value="BANK" <?=($jv->type=='BANK')?'Selected':'';?> >BANK</option>

</select><? } ?></td>
</tr>

<tr id="cash_check">

<td><div align="right">Cash A/C:</div></td>

<td colspan="3" style="text-align:left">

<div align="left">
  <? if($jv->tr_no>0){ ?><input type="text" name="c_id_name" id="cash_disable_id" readonly value="<?=find_a_field('accounts_ledger','ledger_name','ledger_id="'.$jv->relavent_cash_head.'"');?>" style="float:left" tabindex="2"/><input type="hidden" name="c_id" value="<?=$jv->relavent_cash_head?>" /> 
<? } else{?>
<select name="c_id" id="cash_disable_id" style="float:left" tabindex="2"  required>

<option value="0"></option>

<?

foreign_relation('accounts_ledger','ledger_id','ledger_name',$c_id,"sub_group_id=120703 order by ledger_id");

?>
</select>
<? } ?>
</div>                        </td>
</tr>

<tr id="bank_check">

<td><div align="right"><span class="style3">*</span>Bank A/c Debit:</div></td>

<td colspan="3"><? if($jv->tr_no>0){ ?><input type="text" name="b_id_name" id="bank_disable_id" style="float:left" tabindex="2" value="<?=find_a_field('accounts_ledger','ledger_name','ledger_id="'.$jv->relavent_cash_head.'"');?>" readonly="readonly" /><input type="hidden" name="b_id" value="<?=$jv->relavent_cash_head?>" /><? }else{?><select name="b_id" id="bank_disable_id" style="float:left" tabindex="2" <? if($jv->tr_no>0) echo 'readonly'?>  required>

<option value="0"></option>

<?

foreign_relation('accounts_ledger','ledger_id','ledger_name',$b_id,"sub_group_id=120702  order by ledger_id");

?>

</select><? } ?></td>
</tr>

<tr id="check_no_check">

<td><div align="right"><span>Cheque No:</span></div></td>

<td><input name="c_no" type="text" id="c_no" value="<?php echo $jv->cheq_no?>" size="20" maxlength="25" tabindex="4" <? if($jv->tr_no>0) echo 'readonly'?> /></td>

<td><span>Cheque</span> Date:</td>
<td><input autocomplete="off" name="c_date" type="text" id="c_date" value="<?=$jv->cheq_date?>" size="12" maxlength="15" tabindex="5" <? if($jv->tr_no>0) echo 'disabled'?> /></td>
</tr>





<tr>

<td align="right"><span class="style3">*</span>Cost Center :</td>

<td colspan="3">

<? if($jv->tr_no>0){ ?><input type="text"  name="cost_name" id="cost_name" value="<?=find_a_field('cost_center','center_name','id="'.$jv->cc_code.'"');?>" readonly="readonly"/><input type="hidden" name="cc_code" value="<?=$jv->cc_code?>" /><? }else{?><select name="cc_code" id="cc_code" <? if($jv->tr_no>0) echo 'readonly'?>>

<option></option>

<? foreign_relation('cost_center cc, cost_category c','cc.id','cc.center_name',$cc_code,"cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC");?>

</select><? } ?></td>
</tr>

</table></td>

<td align="right" valign="top"><div class="box">

<table  class="table table-striped table-bordered" border="0" cellspacing="0" cellpadding="0">

<tr>

<th bgcolor="#45777B" ><span class="style3">Vou No </span></th>

<th bgcolor="#45777B" ><span class="style3">Amount</span></th>

<th bgcolor="#45777B" ><span class="style3">Date</span></th>

<th bgcolor="#45777B" ><span class="style3">Status</span></th>

<th bgcolor="#45777B">&nbsp;</th>
</tr>

<? 

$sql2="select a.tr_no, a.dr_amt, a.narration,a.jv_date , a.jv_no,a.checked

from  secondary_journal a where a.tr_from='Receipt' and a.group_for='".$_SESSION['user']['group']."' and SUBSTRING(a.tr_no,5,1)='0' and  a.dr_amt>0 order by a.tr_no desc limit 6";

$data2=db_query($sql2);

if(mysqli_num_rows($data2)>0){

while($dataa=mysqli_fetch_row($data2))

{$dataa[2]=substr($dataa[2],0,20).'...';

?>

<tr>

<td><?=$dataa[0]?></td>

<td><?=$dataa[1]?></td>

<td><?= date('d-m-Y',strtotime($dataa[3]));?></td>

<td><?=$dataa[5]?></td>

<!--<td width="24" style="padding:1px;" onclick="DoNav('<?php echo 'v_type=receipt&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[4].'&view=Show&in=Journal_info' ?>');"><img src="../images/copy_hover.png" width="16" height="16" border="0"></td>-->

<td  style="padding:1px;" ><a href="voucher_print_receipt.php?v_type=receipt&vo_no=<?php echo $dataa[4];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0"></a></td>
</tr>

<? }}?>
</table>

</div></td>

</tr>

</table>

</td>

</tr>

<tr>

<td height="35">

<table width="100%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #C1DAD7;" cellpadding="2" cellspacing="2">

<tr>

<td width="33%" align="center" bgcolor="#45777B"><span class="style3">A/C Head </span></td>

<td width="29%" align="center" bgcolor="#45777B"><span class="style3">Narration</span></td>

<td width="12%" align="center" bgcolor="#45777B"><span class="style3">Amount</span></td>

<td width="6%" rowspan="2" bgcolor="#45777B" align="center">

<input name="add_new" class="btn" type="button" id="add_new" value="Add New" onclick="insert_item()" />

<input name="add" type="hidden"  /></tr>
<span id="mr"></span>
<tr>

<td align="center">			 

<input type="text" class="input1" id="ledger_id" name="ledger_id"  tabindex="8" style="width:438px;" /> 
<!--<select name="ledger_idww" id="ledger_idww" onchange = "getBalance('../../common/cur_bal.php', 'cur', this.value);">
<option></option> onBlur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" onfocus="getBalance('../../common/cur_bal.php', 'cur', document.getElementById('ledger_id').value);"
<?
//foreign_relation('accounts_ledger','concat(ledger_id,"::",ledger_name,">>>",ledger_name)','concat(ledger_id,"::",ledger_name,">>>",ledger_name)',''," parent=0 and group_for='".$_SESSION['user']['group']."' and  balance_type IN ('Credit','Both') and parent=0 and ledger_id not like '".$cash_and_bank_balance."%' order by ledger_id");
?>
</select>-->               </td>

<td align="center">

<input name="detail" type="text" id="detail" class="input1"  tabindex="10" style="width:160px;"/>              </td>

<td align="center"><input name="amount" type="text" id="amount" size="10" style="width:100px;" tabindex="11"/></td>
</tr>
</table></td>

</tr>

<tr>

<td height="138" valign="top">
<div class="tabledesign2">	

 <span id="codzList">
<?

$sql2="select a.id, a.tr_no, a.jv_date,l.ledger_name,a.narration, a.cr_amt ,'Action'

from  secondary_journal a, accounts_ledger l where a.ledger_id=l.ledger_id and a.jv_no='".$_SESSION['jv_no']."' and tr_from='Receipt'";

echo link_report_del($sql2);
?>
 </span>
 </div>
</td>

</tr>

</table>


<? $total_amt = find_a_field('secondary_journal','sum(cr_amt)','tr_from = "Receipt" and jv_no='.$_SESSION['jv_no']);?>

<table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">

<tr>

<td width="19%" style="text-align:right;"><input name="receipt_varify" class="btn" <? if($total_amt>0){}else{?>style="visibility:hidden"<? }?> type="button" id="receipt_varify" value="Receipt Verified" onclick="this.form.submit()" /> <input name="limmit" type="hidden" value="" />             </td>

<td style="text-align:right;" valign="middle"><label></label>

<span>Total Amount: </span></td>

<td width="22%"><input name="t_amount" type="text" id="t_amount" size="15" readonly  style="width:130px;" value="<?php echo $total_amt;?>"/></td>

</tr>

</table>

<input name="count" id="count" type="hidden" value="" />

</form>

</div>									</td>

</tr>

</table>

</div></td>

</tr>

</table>

<?

require_once SERVER_CORE."routing/layout.bottom.php";



?>