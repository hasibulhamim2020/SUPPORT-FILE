<?

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


do_calander('#jv_date');
do_calander('#c_date');



$title='Journal Voucher';



$proj_id=$_SESSION['proj_id'];



$user_id=$_SESSION['user']['id'];



$tr_from = 'Journal';

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


$jv_val=find_a_field('journal','count(id)',"tr_no='".$_SESSION['tr_no']."' and tr_from='Journal'");

//else

//{

//    $jv_no = $_SESSION['jv_no'] = next_journal_sec_voucher_id($tr_from);

//	$tr_no = $_SESSION['tr_no'] = next_tr_no($tr_from);

//

//}



$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020'");







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

$bi_id		= explode('##>>',$_REQUEST['b_id']);

$b_id		= $bi_id[1];

$t_amount	= $_REQUEST['t_amount'];











if(($c_id!='')) $receive_ledger=$c_id;

else			$receive_ledger=$b_id;















$ledgers = explode('::',$receive_ledger);















$search=array( ":"," ", "[", "]", $separater);

$ledger1=str_replace($search,'',$ledgers[0]);

$ledger2=str_replace($search,'',$ledgers[1]);

	

if(is_numeric($ledger1))

$receive_ledger = $ledger1;

else

$receive_ledger = $ledger2;







	//voucher date decode







	

	//////////////////////

	//check cdate decode








	//////////////////////////

			$ledger_id=$_REQUEST['ledger_id'];

			$ledgers = explode('::',$ledger_id);

			$ledger_id = $ledgers[0];

			$detail_status = $_REQUEST['detail'];		

			$cur_bal= $_REQUEST['cur_bal'];

			$detail = $_REQUEST['detail'];
            
			$jv_date = $_REQUEST['jv_date'];

			$cc_code = $_REQUEST['cc_code'];
			
			
			$remarks = $_REQUEST['remarks'];


			$reference_id = $_REQUEST['reference_id'];
			
			
			$type = $_REQUEST['t_type'];
			
			if($type=='Debit'){
			$amount = $_REQUEST['d_amount'];
			}else{
			$amount = $_REQUEST['c_amount'];
			}

			if($bank=='')

			$dnarr=$detail;



			else

			//$dnarr=$detail.':: Cheq# '.$c_no.':: Date= '.date("d.m.Y",$c_date);
			  $dnarr=$detail;





$checked = 'UNFINISHED';

	

if($_SESSION['jv_no']==0){

 $jv_no = $_SESSION['jv_no'] = next_journal_sec_voucher_id($tr_from,'Journal');

 $tr_no = $_SESSION['tr_no'] = next_tr_no($tr_from);

}

	else{

		

$jv_no = $_SESSION['jv_no'];

$tr_no = $_SESSION['tr_no'];

	}
	
	
if($jv_val>0){
 $del_jv = "delete from journal where tr_from='Journal' and tr_no = '".$_SESSION['tr_no']."'";
 db_query($del_jv);
}
	
	
	
	if($type=='Debit'){

add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, $amount, '0', $tr_from, $tr_no,'','',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$$receive_ledger,$checked,$type,$employee,$remarks,$reference_id);

}else{
 
 add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, '0', $amount, $tr_from, $tr_no,'','',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$$receive_ledger,$checked,$type,$employee,$remarks,$reference_id);


}
}















//print code











if(isset($_POST['limmit'])){

    

	  if($_SESSION['tr_no']>0){
	  
	  if($jv_val>0){
 $del_jv = "delete from journal where tr_from='Journal' and tr_no = '".$_SESSION['tr_no']."'";
 db_query($del_jv);
}

		  

			$j_data = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');

			$detail = 'Received from '.$j_data->received_from;



			//add_to_sec_journal($proj_id, $_SESSION['jv_no'], $j_data->jv_date, $j_data->relavent_cash_head,  $detail, '0',$_POST['t_amount'], $tr_from, $_SESSION['tr_no'],'','',$j_data->cc_code,'',$_SESSION['user']['id'],'',$j_data->received_from,$j_data->bank,$j_data->cheq_no,$j_data->cheq_date,$j_data->relavent_cash_head,$checked);



			$up = 'update secondary_journal set checked="NO" where jv_no="'.$_SESSION['jv_no'].'"';

			db_query($up);





			$_SESSION['jv_no']     = '';

			$_SESSION['receipt_no'] = '';

	

  }else{

  

    $msg = '<span style="color:red">Data Re-Submit Not Allowed..!</span>';

	$_SESSION['receipt_no'] = '';

  }







$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');

$time_now = date('Y-m-d H:i:s');

if($sa_config=="Yes"){

$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');


if($jv_config=="Yes"){

sec_journal_journal($j_data->jv_no,$j_data->jv_no,$tr_from);

$time_now = date('Y-m-d H:i:s');

$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);

$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';
db_query($sa_up2);


}


} else {

$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

}







//$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');
//
//if($jv_config=="Yes"){
//
//sec_journal_journal($j_data->jv_no,$j_data->jv_no,$tr_from);
//
//$time_now = date('Y-m-d H:i:s');
//
//$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';
//
//db_query($up2);
//
//}
  

  

}





if($_GET['del']>0)
{
		//$crud   = new crud($table_details);
		//$condition="id=".$_GET['del'];		
		//$crud->delete_all($condition);
		 $del_jv = "delete from secondary_journal where tr_from='Journal' and id = '".$_GET['del']."'";
		db_query($del_jv);
		
		
		if($jv_val>0){
 $del_jv = "delete from journal where tr_from='Journal' and tr_no = '".$_SESSION['tr_no']."'";
 db_query($del_jv);
}
		
		$type=1;
		$msg='Successfully Deleted.';
}





$jv = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');

if($_SESSION['jv_no']==0){

	

	$jv_no = next_journal_sec_voucher_id($tr_from,'Journal');

	$tr_no = next_tr_no($tr_from);

}

else{

	$jv_no = $_SESSION['jv_no'];

	$tr_no = $_SESSION['tr_no'];

}



js_ledger_subledger_autocomplete_new('journal',$proj_id,$voucher_type,$_SESSION['user']['group']); 



?>







<script type="text/javascript">

function DoNav(theUrl)

{

	var URL = 'voucher_view_popup.php?'+theUrl;

	popUp(URL);

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


function mytype()

{
  

  var type = document.getElementById('t_type').value;
  
    if(type=='Credit'){
	   
	   document.getElementById('d_amount').setAttribute('readonly','readonly'); 
	  
	}else{
	   document.getElementById('d_amount').removeAttribute('readonly','readonly');
	}
	
	if(type=='Debit'){
	   
	   document.getElementById('c_amount').setAttribute('readonly','readonly'); 
	}else{
	   document.getElementById('c_amount').removeAttribute('readonly','readonly');
	}
	
	
}

window.onload=mytype;

</script>







<?

//auto_complete_start_from_db('accounts_ledger',"concat(ledger_name,'##>>',ledger_id)","concat(ledger_name,'##>>',ledger_id)","ledger_name not like '%cash%' and ledger_group_id='1011' and parent=0 order by ledger_id","b_id");

?>









<script type="text/javascript" src="../../common/js/check_balance.js"></script>

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


</script>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>




<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #E5EFCD  ">



  <tr>

    <td><div>



							<table class="fontc" width="100%" border="0" cellspacing="0" cellpadding="0">







								  <tr>







									<td>







									<div align="left">







    <form id="form1" name="form1" method="post" action="?" onsubmit="return checking()">







      <table border="2" style="border:1px solid #C1DAD7; border-collapse:collapse; width:100%" >







        <tr>







          <td >







		  <table width="100%" border="0" cellspacing="0" cellpadding="0">







				  <tr>







				    <td valign="top" style="text-align:left;" ><table width="95%" border="0" cellspacing="2" cellpadding="2" style="margin-right:15px;">









                      <tr>







                      <td width="25%"><div align="right">Voucher No:</div></td>







                        <td width="26%"><? 







$receiptno=next_invoice('tr_no','secondary_journal');















if($v_d>10000)







$v_d=date("d-m-y",$v_d);























if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; } 







elseif($old_voucher_mode==1){$v_no_show='value="'.$receiptno.'" readonly'; } 







else $v_no_show='';







?>







<input name="receipt_no" type="text" id="receipt_no" size="15" value="<?=$tr_no?>" />





















<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

</td>







                        <td width="19%" align="right"><div align="right">Voucher Date:</div></td>







                        <td width="30%"><input name="jv_date" type="text" id="jv_date" 
value="<?php if($jv->jv_date==""){
echo $today=date('Y-m-d');
}else{
echo $jv->jv_date;
} ?>" size="10" <?php /*?><? if($jv->tr_no>0) echo 'disabled'?><?php */?>  tabindex="1"required />
						
						
						
						<input name="r_from" type="hidden" id="r_from" value="<?php echo $jv->received_from?>" class="input1"  tabindex="1" required <? if($jv->tr_no>0) echo 'readonly'?>/></td>

                      </tr>




                      


                      
                      <?php /*?><tr>







                        <td><div align="right"><span>Cheque No:</span></div></td>







                        <td colspan="3"><input name="c_no" type="text" id="c_no" value="<?php echo $jv->cheq_no?>" size="20" maxlength="25" tabindex="4" <? if($jv->tr_no>0) echo 'readonly'?> /></td>

                      </tr>





                      <tr><td><div align="right"><span>Cheque</span> Date:</div></td>







                        <td colspan="3"><input name="c_date" type="text" id="c_date" value="<?php echo $jv->cheq_date?>" size="12" maxlength="15" tabindex="5" <? if($jv->tr_no>0) echo 'readonly'?> /></td>

                      </tr>







                      <tr>







                        <td align="left"><div align="right">of Bank:</div></td>







                        <td colspan="3" align="left"><input name="bank" type="text" id="bank" value="<?php echo $jv->bank?>" class="input1"   tabindex="6" <? if($jv->tr_no>0) echo 'readonly'?>/></td>

                      </tr>

<?php */?>





                      <tr>

<td align="right"><span class="style3"></span>Remarks:</td>

<td colspan="3">
<input name="remarks" type="text" id="remarks" value="<?php echo $jv->remarks?>" class="input1"   <? if($jv->tr_no>0) echo 'readonly'?> />

</td>

</tr>







                    </table></td>







				    <td align="right" valign="top"><div class="box">







				      <table  class="table table-striped table-bordered"  border="0" cellspacing="0" cellpadding="0">







                    <tr>







                      <th bgcolor="#45777B" ><span class="style3">Vou No </span></th>







                      <th bgcolor="#45777B" ><span class="style3">Amount</span></th>







                     <th bgcolor="#45777B" ><span class="style3">Date</span></th>
					 
					 <th bgcolor="#45777B" ><span class="style3">Status</span></th>



<th bgcolor="#45777B">&nbsp;</th>
                      </tr>







					<? 







 $sql2="select a.tr_no, a.dr_amt, a.narration,a.jv_date , a.jv_no,a.checked







from  secondary_journal a where a.tr_from='Journal'  and SUBSTRING(a.tr_no,5,1)='0' and  a.dr_amt>0 and a.checked in ('NO','YES') group by a.tr_no order by a.tr_no desc limit 5";























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







					  







                      <td  style="padding:1px;" ><a href="general_voucher_print_view_for_draft.php?jv_no=<?php echo $dataa[4];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0"></a></td>
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



              <td width="5%" align="center" bgcolor="#45777B"><span class="style3">Type</span></td>



              <td width="8%" align="center" bgcolor="#45777B"><span class="style3">GL Code </span></td>
              <td width="31%" align="center" bgcolor="#45777B"><span class="style3">GL Name </span></td>







              <td width="10%" align="center" bgcolor="#45777B"><span class="style3">Reference</span></td>
              <td width="12%" align="center" bgcolor="#45777B"><span class="style3">Cost Center</span></td>







              <td width="10%" align="center" bgcolor="#45777B"><span class="style3">Narration</span></td>







              <td width="7%" align="center" bgcolor="#45777B"><span class="style3">Debit</span></td>
			  
			  <td width="7%" align="center" bgcolor="#45777B"><span class="style3">Credit</span></td>







              <td width="6%" bgcolor="#45777B"rowspan="2" align="center">







                <input name="add_new" class="btn" type="submit" id="add_new" value="Add New" />

				<input name="add" type="hidden" />            </tr>

            <tr>




              <td><select name="t_type" id="t_type" onchange="mytype()" style="width:60px;"><option>Debit</option><option>Credit</option></select></td>


              <td><input type="text" class="input1" id="ledger_id" name="ledger_id" onblur="getData2('acc_reference_ajax.php', 'acc_reference', this.value, 
document.getElementById('ledger_id').value);" tabindex="1" style="width:100px;" /></td>
              <td colspan="2" align="center">			 

<span id="acc_reference">
<table width="100%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #C1DAD7;" cellpadding="2" cellspacing="2">
	<tr> 
		<td width="51%"><input type="text" class="input1" id="ledger_name" name="ledger_id" style="width:250px;" /></td>
		<td width="49%"><select name="reference_id" id="reference_id"  tabindex="2"  style="width:120px;">
    <option></option>
    <? foreign_relation('acc_reference','id','reference_name',$_POST['reference_id'],"1");?>
  </select></td>
	</tr>
</table>
  </span>            </td>







              <td align="center"><span id="cur">







                <select name="cc_code" id="cc_code"  style="width:100px;"  tabindex="3">
  <option></option>
  <? foreign_relation('cost_center','id','center_name',$_POST['cc_code'],"1");?>
</select>







              </span> </td>







              <td align="center">







              	<input name="detail" type="text" id="detail" class="input1"  tabindex="10" style="width:100px;"/>              </td>







              <td align="center"><input name="d_amount" type="text" id="d_amount" size="10" style="width:80px;" tabindex="11"/></td>




              <td align="center"><input name="c_amount" type="text" id="c_amount" size="10" style="width:80px;" tabindex="11"/></td>
              </tr>
          </table></td>







        </tr>







        <tr>







          <td height="138" valign="top">

                <table width="100%" align="center" border="1">

<tr style="background: cornflowerblue; color:#FFFFFF;">

<td width="10%" align="center" bgcolor="#45777B"><span class="style3">GL Code </span></td>

<td width="25%" align="center" bgcolor="#45777B"><span class="style3">GL Name </span></td>
<td width="13%" align="center" bgcolor="#45777B"><span class="style3">Reference</span></td>

<td width="13%" align="center" bgcolor="#45777B"><span class="style3">Cost Center</span></td>
<td width="11%" align="center" bgcolor="#45777B"><strong>Narration</strong></td>
<td width="10%" align="center" bgcolor="#45777B"><span class="style3">Debit</span></td>

<td width="12%" align="center" bgcolor="#45777B"><span class="style3">Credit</span></td>
<td width="6%" align="center" bgcolor="#45777B"><strong>Action</strong></td>
</tr>

<?

$sql2="select a.id, a.ledger_id, a.tr_no,l.ledger_name, a.dr_amt, a.cr_amt, a.narration,a.jv_date , a.jv_no, a.cc_code, a.reference_id

from  secondary_journal a, accounts_ledger l where a.ledger_id=l.ledger_id and a.jv_no='".$_SESSION['jv_no']."' and a.tr_from='Journal' ";

$qr = db_query($sql2);

while($data=mysqli_fetch_object($qr)){

$total_amt = $total_amt+$data->dr_amt;

?>

<tr align="center" style="padding:5px;">

<td><?=$data->ledger_id?></td>

<td align="left"><?=$data->ledger_name?></td>
<td><?=find_a_field('acc_reference','reference_name','id='.$data->reference_id);?></td>

<td><?=find_a_field('cost_center','center_name','id='.$data->cc_code);?></td>
<td><?=$data->narration?></td>
<td><?=$data->dr_amt?></td>

<td><?=$data->cr_amt?></td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$data->id?>">&nbsp;<img src="del.png" width="25" height="auto" />&nbsp;</a></td>
</tr>

<? } ?>
</table>

          </td>







        </tr>

		 </table>

		 </form>

		<form method="post">

  

   

<table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">



        <tr>



              <td width="19%" style="text-align:right;">
	<? $deffr = find_a_field('secondary_journal','sum(dr_amt-cr_amt)','tr_from="Journal" and jv_no='.$_SESSION['jv_no']);
	   
	?>  
			  <input name="receipt_varify" class="btn" type="button" id="receipt_varify" <? if($deffr==0){ echo 'hi';}else{?>style="visibility:hidden"<? }?> value="Journal Verified" onclick="this.form.submit()" /> <input name="limmit" type="hidden" value="" />  
			             </td>







              <td style="text-align:right;" valign="middle"><label></label>







                <span>Difference: </span></td>







              <td width="22%"><input name="t_amount" type="text" id="t_amount" size="15" readonly  style="width:130px;" value="<?php echo $deffr;?>"/></td>







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







$main_content=ob_get_contents();







ob_end_clean();







require_once SERVER_CORE."routing/layout.bottom.php";







?>