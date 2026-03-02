<?


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



do_calander('#jv_date');
do_calander('#c_date');

$title='Payment Request';



$proj_id=$_SESSION['proj_id'];



$user_id=$_SESSION['user']['id'];



$tr_from = 'Payment';

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

$employee_id		= $_REQUEST['employee_id'];

$employees = explode('#>',$employee_id);

$employee = $employees[1];

$vendor		= $_REQUEST['vendor_id'];

$vendors = explode('#>',$vendor);

$vendor_id = $vendors[1];


$purpose		= $_REQUEST['purpose'];

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

 $jv_no = $_SESSION['jv_no'] = next_journal_sec_voucher_id($tr_from);

 $tr_no = $_SESSION['tr_no'] = next_tr_no($tr_from);

}

	else{

		

echo $jv_no = $_SESSION['jv_no'];

$tr_no = $_SESSION['tr_no'];

	}
	echo $receive_ledger;

add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, $amount, '0', $tr_from, $tr_no,'','',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$receive_ledger,$checked,$type,$employee,$purpose,$vendor_id);

}















//print code











if(isset($_POST['limmit'])){

    

	  if($_SESSION['tr_no']>0){

		  

			$j_data = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');

			$detail = 'Received from '.$j_data->received_from;



			add_to_sec_journal($proj_id, $_SESSION['jv_no'], $j_data->jv_date, $j_data->relavent_cash_head,  $detail, '0',$_POST['t_amount'], $tr_from, $_SESSION['tr_no'],'','',$j_data->cc_code,'',$_SESSION['user']['id'],'',$j_data->received_from,$j_data->bank,$j_data->cheq_no,$j_data->cheq_date,$j_data->relavent_cash_head,$checked,$j_data->type,$j_data->employee_id,$j_data->purpose);



			$up = 'update secondary_journal set checked="NO" where jv_no="'.$_SESSION['jv_no'].'"';

			db_query($up);





			$_SESSION['jv_no']     = '';

			$_SESSION['receipt_no'] = '';

	

  }else{

  

    $msg = '<span style="color:red">Data Re-Submit Not Allowed..!</span>';

	$_SESSION['receipt_no'] = '';

  }

  

  

}



$jv = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');

if($_SESSION['jv_no']==0){

	

	$jv_no = next_journal_sec_voucher_id($tr_from);

	$tr_no = next_tr_no($tr_from);

}

else{

	$jv_no = $_SESSION['jv_no'];

	$tr_no = $_SESSION['tr_no'];

}



js_ledger_subledger_autocomplete_new('receipt',$proj_id,$voucher_type,$_SESSION['user']['group']); 



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







<?

auto_complete_start_from_db('accounts_ledger',"concat(ledger_name,'##>>',ledger_id)","concat(ledger_name,'##>>',ledger_id)","ledger_name not like '%cash%' and ledger_group_id='1086' and parent=0 order by ledger_id","b_id");

auto_complete_from_db('personnel_basic_info','PBI_ID','concat(PBI_NAME,"#>",PBI_ID)',' 1 and PBI_JOB_STATUS="In Service" ','employee_id');

auto_complete_from_db('vendor','vendor_id','concat(vendor_name,"#>",vendor_id)','1 and status="ACTIVE"','vendor_id');


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

function check_type()

{
  

  var check_type = document.getElementById('type').value;
  
    if(check_type=='CASH'){
	   document.getElementById('cash_check').style.display='';
	   document.getElementById('bank_check').style.display='none';
	   document.getElementById('check_no_check').style.display='none';
	   document.getElementById('check_date_check').style.display='none';
	   document.getElementById('of_bank_check').style.display='none';
	  
	}
	if(check_type=='BANK')
	
	{
	   
	   document.getElementById('cash_check').style.display='none';
	   document.getElementById('bank_check').style.display='';
	   document.getElementById('check_no_check').style.display='none';
	   document.getElementById('check_date_check').style.display='none';
	   document.getElementById('of_bank_check').style.display='none';
	  
	  
	}
	
	
	 if(check_type=='CHEQUE'){
	   
	   document.getElementById('cash_check').style.display='none';
	   document.getElementById('bank_check').style.display='';
	   document.getElementById('check_no_check').style.display='';
	   document.getElementById('check_date_check').style.display='';
	   document.getElementById('of_bank_check').style.display='';
	   
	  
	  
	}
	
	
}

window.onload=check_type;


</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>




<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">



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







<input name="receipt_no" type="text" id="receipt_no" size="15" value="<?=$tr_no?>" <? if($jv->tr_no>0) echo 'disabled'?> />





















<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/></td>







                        <td width="19%" align="right"><div align="right">Request Date:</div></td>







                        <td width="30%"><input name="jv_date" type="text" id="jv_date" value="<?php echo $jv->jv_date?>" size="10" <? if($jv->tr_no>0) echo 'disabled'?>  tabindex="1"required />                          </td>
                      </tr>







                      







                      <tr>







                        <td><div align="right"><span class="style3 style1">*</span>Subject:</div></td>







                        <td><input name="r_from" type="text" id="r_from" value="<?php echo $jv->received_from?>" class="input1"  tabindex="1" required <? if($jv->tr_no>0) echo 'readonly'?> /></td>
						
						

                        <td align="right">Type:</td>

                        <td><? if($jv->tr_no>0){ ?><input type="text" name="type" id="type" value="<?=$jv->type?>" readonly="readonly"  class="form-control" /><? }else{?><select name="type" id="type" class="form-control" required onChange="check_type()" >

							<option value="0"></option>

							<option value="CASH" <?=($jv->type=='CASH')?'Selected':'';?> >CASH</option>

							<option value="BANK" <?=($jv->type=='BANK')?'Selected':'';?> >BANK</option>
							
							<option value="CHEQUE" <?=($jv->type=='CHEQUE')?'Selected':'';?> >CHEQUE</option>

                        </select><? } ?></td>
                      </tr>
					  
					  <tr id=""><td><div align="right"><span>Employee</span> :</div></td>







                        <td colspan="3"><input name="employee_id" type="text" id="employee_id" value="<?php if($jv->employee_id>0){ echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$jv->employee_id.'"').'#>'.$jv->employee_id;} ?>" class="input1"  tabindex="1" required <? if($jv->tr_no>0) echo 'readonly'?> /></td>
                      </tr>
					  
					  <tr id=""><td><div align="right"><span>Purpose</span> :</div></td>
                   <td colspan="3"><input name="purpose" type="text" id="purpose" value="<?php echo $jv->purpose?>" class="input1"  tabindex="1" required <? if($jv->tr_no>0) echo 'readonly'?> /></td>
                      </tr>



 
                  <tr id="cash_check">
                        <td><div align="right">Cash A/C:</div></td>

                   <td colspan="3" style="text-align:left">
                   <div align="left"><? if($jv->tr_no>0){ ?><input type="text" name="c_id_name" id="cash_disable_id" class="form-control" readonly value="<?=find_a_field('accounts_ledger','ledger_name','ledger_id="'.$jv->relavent_cash_head.'"');?>" style="float:left" tabindex="2"/><input type="hidden" name="c_id" value="<?=$jv->relavent_cash_head?>" /> <? } else{?><select name="c_id" id="cash_disable_id" class="form-control" style="float:left" tabindex="2"  >
                                        <option value="0"></option>
                        <?

foreign_relation('accounts_ledger','ledger_id','ledger_name',$c_id,"ledger_name like '%cash%' and parent=0 and ledger_id like '".$cash_and_bank_balance."%' order by ledger_id");

						?>

                        </select><? } ?>
							</div>                        </td>
                      </tr>
					  
					  
                      <tr id="bank_check">

                     <td><div align="right"><span class="style3">*</span>Bank A/c Debit:</div></td>
                      <td colspan="3"><? if($jv->tr_no>0){ ?><input type="text" name="b_id_name" id="bank_disable_id" class="form-control" style="float:left" tabindex="2" value="<?=find_a_field('accounts_ledger',                        'ledger_name','ledger_id="'.$jv->relavent_cash_head.'"');?>" readonly="readonly" /><input type="hidden" name="b_id" value="<?=$jv->relavent_cash_head?>" /><? }else{?>
					  <select name="b_id" id="bank_disable_id" class="form-control" style="float:left" tabindex="2" <? if($jv->tr_no>0) echo 'readonly'?> >
                                     <option value="0"></option>
                          <?

foreign_relation('accounts_ledger','ledger_id','ledger_name',$b_id,"ledger_name not like '%cash%' and parent=0 and ledger_id like '".$cash_and_bank_balance."%'  order by ledger_id");

						?>

                         

                        </select><? } ?></td>
                      </tr>
					  
                      <tr id="check_no_check">







                        <td><div align="right"><span>Cheque No:</span></div></td>







                        <td colspan="3"><input name="c_no" type="text" id="c_no" value="<?php echo $jv->cheq_no?>" size="20" maxlength="25" tabindex="4" <? if($jv->tr_no>0) echo 'readonly'?> /></td>
                      </tr>





                      <tr id="check_date_check"><td><div align="right"><span>Cheque</span> Date:</div></td>







                        <td colspan="3"><input name="c_date" type="text" id="c_date" value="<?=$jv->cheq_date?>" size="12" maxlength="15" tabindex="5" <? if($jv->tr_no>0) echo 'disabled'?> /></td>
                      </tr>







                      <tr id="of_bank_check">







                        <td align="left"><div align="right">of Bank:</div></td>







                        <td colspan="3" align="left"><input name="bank" type="text" id="bank" value="<?php echo $jv->bank?>" class="input1"   tabindex="6" <? if($jv->tr_no>0) echo 'readonly'?> /></td>
                      </tr>


       




                      <tr>







                        <td align="right"><span class="style3">*</span>Cost Center :</td>







                        <td colspan="3">

							<? if($jv->tr_no>0){ ?><input type="text"  name="cost_name" id="cost_name" value="<?=find_a_field('cost_center','center_name','id="'.$jv->cc_code.'"');?>" readonly="readonly"/><input type="hidden" name="cc_code" value="<?=$jv->cc_code?>" /><? }else{?><select name="cc_code" id="cc_code" <? if($jv->tr_no>0) echo 'readonly'?>>

								<option></option>

						  <? foreign_relation('cost_center cc, cost_category c','cc.id','cc.center_name',$cc_code,"cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC");?>

								</select><? } ?>						  </td>
                      </tr>


<tr id=""><td><div align="right"><span>Vendor</span> :</div></td>







                        <td colspan="3"><input name="vendor_id" type="text" id="vendor_id" value="<?php if($jv->vendor_id>0){ echo find_a_field('vendor','vendor_name','vendor_id="'.$jv->vendor_id.'"').'#>'.$jv->vendor_id; }?>" class="input1"  tabindex="1"  <? if($jv->tr_no>0) echo 'readonly'?> /></td>
                      </tr>




                    </table></td>







				    <td align="right" valign="top"><div class="box">







				      <table  class="tabledesign table-bordered" border="0" cellspacing="0" cellpadding="0">


                    <tr>

                      <th >Vou No </th>


                      <th >Amount</th>


                     <th >Date</th>
					 
					 <th >Status</th>
					 
					 <th>&nbsp;</th>
                  </tr>

					<? 







 $sql2="select a.tr_no, a.dr_amt, a.narration,a.jv_date , a.jv_no,a.checked







from  secondary_journal a where a.tr_from='Payment' and a.group_for='".$_SESSION['user']['group']."' and SUBSTRING(a.tr_no,5,1)='0' and  a.dr_amt>0 order by a.tr_no desc limit 10";





$data2=db_query($sql2);







if(mysqli_num_rows($data2)>0){







while($dataa=mysqli_fetch_row($data2))







{$dataa[2]=substr($dataa[2],0,20).'...';







					?>







                    <tr>







                      <td><?=$dataa[0]?></td>







                      <td><?=$dataa[1]?></td>







                     <td><?=$dataa[3]?></td>
					 
					 
					 <td><?=$dataa[5]?></td>







					  







                      <!--<td width="24" style="padding:1px;" onclick="DoNav('<?php echo 'v_type=receipt&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[4].'&view=Show&in=Journal_info' ?>');"><img src="../images/copy_hover.png" width="16" height="16" border="0"></td>-->







					  







                      <td  style="padding:1px;" ><a href="voucher_print_view_receipt_awn.php?v_type=receipt&vo_no=<?php echo $dataa[4];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0"></a></td>







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







              <td width="33%" align="center">A/C Head </td>







              <td width="20%" align="center">Cur Bal </td>







              <td width="29%" align="center">Narration</td>







              <td width="12%" align="center">Amount</td>







              <td width="6%" rowspan="2" align="center">







                <input name="add_new" class="btn" type="submit" id="add_new" value="Add New" />

				<input name="add" type="hidden" />













            </tr>







            <tr>







              <td align="center">			 






             <?
			   $cash_bank = find_a_field('secondary_journal','type','jv_no="'.$_SESSION['jv_no'].'"');
			   if($cash_bank=='CASH'){
			 ?>
                <input type="text" class="input1" id="ledger_id" name="ledger_id" onBlur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" tabindex="8" style="width:438px;"   />                </td>
              <?
			    }elseif($cash_bank=='BANK'){
				$ledger_ex = find_a_field('secondary_journal','ledger_id','jv_no="'.$_SESSION['jv_no'].'"');
			  ?>
               <input type="text" class="input1" id="ledger_id" name="ledger_id" onBlur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" value="<?=$ledger_ex.'::'.find_a_field('accounts_ledger','ledger_name','ledger_id="'.$ledger_ex.'"');?>" tabindex="8" style="width:438px;"   />  
		<? }else{ ?>
		<input type="text" class="input1" id="ledger_id" name="ledger_id" onBlur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" tabindex="8" style="width:438px;"   />
		<? } ?>





              <td align="center"><span id="cur">







                <input name="cur_bal" type="text" id="cur_bal" maxlength="100" readonly="readonly"/>







              </span> </td>







              <td align="center">







              	<input name="detail" type="text" id="detail" class="input1" onfocus="getBalance('../../common/cur_bal.php', 'cur', document.getElementById('ledger_id').value);" tabindex="10" style="width:160px;"/>              </td>







              <td align="center"><input name="amount" type="text" id="amount" size="10" style="width:100px;" tabindex="11"/></td>







              </tr>







          </table></td>







        </tr>







        <tr>







          <td height="138" valign="top">

                <table width="100%" align="center" border="1">

				   <tr style="background: cornflowerblue; color:#FFFFFF;">

				      <td align="center">Ledger Name</td>

					  <td align="center">Current Balance</td>

					  <td align="center">Narration</td>

					  <td align="center">Amount</td>

					  <td align="center">Action</td>

				   </tr>

				   <?

				     $sql2="select a.tr_no,l.ledger_name, a.dr_amt, a.narration,a.jv_date , a.jv_no







from  secondary_journal a, accounts_ledger l where a.ledger_id=l.ledger_id and a.jv_no='".$_SESSION['jv_no']."' and tr_from='Payment'";

       $qr = db_query($sql2);

	   while($data=mysqli_fetch_object($qr)){

	           

			      $total_amt = $total_amt+$data->dr_amt;

				   ?>

				   <tr align="center">

				      <td><?=$data->ledger_name?></td>

					  <td></td>

					  <td><?=$data->narration?></td>

					  <td><?=$data->dr_amt?></td>

					  <td>X</td>

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



              <td width="19%" style="text-align:right;"><input name="receipt_varify" class="btn" type="button" id="receipt_varify" value="Request Verified" onclick="this.form.submit()" /> <input name="limmit" type="hidden" value="" />             </td>







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







$main_content=ob_get_contents();







ob_end_clean();







require_once SERVER_CORE."routing/layout.bottom.php";







?>