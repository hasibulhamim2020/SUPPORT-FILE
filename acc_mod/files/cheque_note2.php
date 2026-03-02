<?

 //ini_set('display_errors', '1');
 //ini_set('display_startup_errors', '1');
 //error_reporting(E_ALL);
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
session_start();

$tr_type="Show";


ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];


do_calander('#jv_date');
do_calander('#c_date');

$title='Cheque Issue Voucher';


$proj_id=$_SESSION['proj_id'];

create_combobox('issue_to_ac');




$user_id=$_SESSION['user']['id'];



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

//	$tr_no = $_SESSION['tr_no'] = find_a_field('cheque_secondary_journal','max(tr_no)','1')+1;

//

//}



$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' ");

///////////////////


if(isset($_POST['add']))

{   



$v_date		= $_SESSION['old_v_date']=$_REQUEST["date"];

$ledger_id	= $_REQUEST["ledger_id"];

$bank		= $_REQUEST["bank"];

$r_from		= $_REQUEST['r_from'];

$c_no		= $_REQUEST['c_no'];

$tr_mode	= $_REQUEST['tr_mode'];

$branch		= $_REQUEST['branch'];

$cheq_date	= $_REQUEST['c_date'];

$c_id		= $_REQUEST['c_id'];

$jv_date	= $_REQUEST['jv_date'];

$type		= $_REQUEST['type'];

$cheque		= $_REQUEST['cheque'];

//$bi_id	= explode('##>>',$_REQUEST['b_id']);

//$b_id		= $bi_id[1];

$b_id = $_REQUEST['b_id'];

$issue_to_ac = $_REQUEST['issue_to_ac'];

$issue_from_ac = $_REQUEST['issue_from_ac'];

$t_amount	= $_REQUEST['issue_amt'];



			$detail = $_REQUEST['detail'];

			$amount = $t_amount;

			$cc_code = $_REQUEST['cc_code'];


			$remarks = $_REQUEST['remarks'];
			$manual_voucher_no = $_REQUEST['manual_voucher_no'];
			$reference_id = $_REQUEST['reference_id'];

			$dnarr=$detail.' Cheq# '.$c_no.':: Date= '.$cheq_date;


$checked = 'UNFINISHED';



	

if($_SESSION['jv_no']==0){

 $jv_no = $_SESSION['jv_no'] = find_a_field('cheque_secondary_journal','max(jv_no)','1')+1;

 $tr_no = $_SESSION['tr_no'] = find_a_field('cheque_secondary_journal','max(tr_no)','1')+1;

}else{

$jv_no = $_SESSION['jv_no'];

$tr_no = $_SESSION['tr_no'];

	}
	
if($jv_no>0){	
	 $receive_ledger;

	//DR
	add_to_cheque_sec_journal($proj_id, $jv_no, $jv_date, $issue_to_ac, $dnarr, $amount, '0', $tr_from, $tr_no,'','',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$issue_from_ac,$checked,$type,$employee,$remarks,$reference_id);
	
	//CR
	add_to_cheque_sec_journal($proj_id, $jv_no, $jv_date, $issue_from_ac, $dnarr, '0', $amount, $tr_from, $tr_no,'','',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$issue_to_ac,$checked,$type,$employee,$remarks,$reference_id);
	
	
	$cheque_update = 'UPDATE cheque_reg SET cheque_status = "CHECKED" WHERE cheque_no = "'.$c_no.'"';
	db_query($cheque_update);
	
	$up = 'update cheque_secondary_journal set checked="NO" where jv_no="'.$_SESSION['jv_no'].'"';

		db_query($up);
		
		$_SESSION['jv_no']     = '';
		$_SESSION['receipt_no'] = '';


	}
	
	header('Location:cheque_note2.php?new=2');
}



//print code



if(isset($_POST['limmit'])){

    

	  if($_SESSION['tr_no']>0){
		if($_SESSION['jv_no']>0){
		  

			$j_data = find_all_field('cheque_secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');

			$detail = 'Paid Through : '.$j_data->received_from;



			add_to_cheque_sec_journal($proj_id, $_SESSION['jv_no'], $j_data->jv_date, $j_data->relavent_cash_head,  $detail, '0',$_POST['t_amount'], $tr_from, $_SESSION['tr_no'],'','',$j_data->cc_code,'',$_SESSION['user']['id'],'',$j_data->received_from,$j_data->bank,$j_data->cheq_no,$j_data->cheq_date,$j_data->relavent_cash_head,$checked,
			$j_data->type,$j_data->employee_id, $j_data->remarks , '0' );




			$up = 'update cheque_secondary_journal set checked="NO", tr_mode="'.$tr_mode.'", branch="'.$j_data->branch.'", manual_voucher_no="'.$j_data->manual_voucher_no.'" where jv_no="'.$_SESSION['jv_no'].'"';

			db_query($up);

			



			$_SESSION['jv_no']     = '';

			$_SESSION['receipt_no'] = '';
			
		}	
	

  }else{

  

    $msg = '<span style="color:red">Data Re-Submit Not Allowed..!</span>';

	$_SESSION['receipt_no'] = '';

  }





$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');

$time_now = date('Y-m-d H:i:s');

if($sa_config=="Yes"){

$sa_up='update cheque_secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');


if($jv_config=="Yes"){

//sec_journal_journal($j_data->jv_no,$j_data->jv_no,$tr_from);

$time_now = date('Y-m-d H:i:s');

$up2='update cheque_secondary_journal set checked="YES",checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);

$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';
db_query($sa_up2);


}


} else {

$sa_up='update cheque_secondary_journal set secondary_approval="No" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

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
//$up2='update cheque_secondary_journal set checked="YES",checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';
//
//db_query($up2);
//
//}
  

  unset($_SESSION['tr_no']);
  unset($_SESSION['jv_no']);
  
  header('Location:cheque_note.php?new=2');

}



if($_GET['del']>0)
{
		//$crud   = new crud($table_details);
		//$condition="id=".$_GET['del'];		
		//$crud->delete_all($condition);
		 $del_jv = "delete from cheque_secondary_journal where tr_from='Cheque Issue' and id = '".$_GET['del']."'";
		db_query($del_jv);
		
		$type=1;
		$msg='Successfully Deleted.';
}





//
//if(isset($_POST['cancel_jv'])){
//
//if($_SESSION['tr_no']>0){
//
//$j_data = find_all_field('cheque_secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');
//
//
//		$del_jv = "delete from cheque_secondary_journal where tr_from='Cheque Issue' and tr_no = '".$_SESSION['tr_no']."'";
//		db_query($del_jv);
//
//
//$_SESSION['jv_no']     = '';
//
//$_SESSION['receipt_no'] = '';
//
//}else{
//
//$msg = '<span style="color:red">Data Re-Submit Not Allowed..!</span>';
//
//$_SESSION['receipt_no'] = '';
//
//
//}
//
//
//
//
//}








$jv = find_all_field('cheque_secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');

if($_SESSION['jv_no']==0){

	

	$jv_no = find_a_field('cheque_secondary_journal','max(jv_no)','1')+1;

	$tr_no = find_a_field('cheque_secondary_journal','max(tr_no)','1')+1;

}

else{

	$jv_no = $_SESSION['jv_no'];

	$tr_no = $_SESSION['tr_no'];

}



if($jv->tr_no==0){ 
//create_combobox('bank_disable_id');
create_combobox('cash_disable_id');
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
	   
	   document.getElementById('bank_check').style.display='none';
	   document.getElementById('check_no_check').style.display='none';
	   document.getElementById('check_date_check').style.display='none';
	   document.getElementById('of_bank_check').style.display='none';
	  
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

window.onload=check_type;


</script>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>














<!--Debit_note-->
<div class="form-container_large">
	<form id="form1" name="form1" method="post" action="?">
		<!--        top form start hear-->
		<div class="container-fluid bg-form-titel">
			<div class="row">
				<!--left form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">

						<div class="row pb-1">
							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12">Serial No:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<?

										$receiptno=find_a_field('cheque_secondary_journal','max(tr_no)','1')+1;


										if($v_d>10000)


											$v_d=date("d-m-y",$v_d);



										if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; }


										elseif($old_voucher_mode==1){$v_no_show='value="'.$receiptno.'" readonly'; }


										else $v_no_show='';

										?>

										<input name="receipt_no" type="text" id="receipt_no" size="15" tabindex="1" value="<?=$tr_no?>" <? if($jv->tr_no>0) echo 'disabled'?> class="form-control"/>

										<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

										<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

									</div>
								</div>
							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pl-0">
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12">Issue Date:</label>
									<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0 pr-2 ">

										<input name="jv_date" type="text" id="jv_date" value="<?php if($jv->jv_date==""){echo $today=date('Y-m-d');}else{ echo $jv->jv_date; } ?>" size="10" <?php /*?><? if($jv->tr_no>0) echo 'disabled'?><?php */?>  tabindex="2"required class="form-control" />

									</div>
								</div>
							</div>
						</div>



						<div id="cash_check" class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cheque Amount: </label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2 ">
								<input name="issue_amt" id="issue_amt" value="<?=$jv->dr_amt?>"  class="form-control"/>
							</div>
						</div>


						<div id="bank_check" class="form-group row m-0 pb-1">

							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text ">Issue To A/C:</label>
							
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<select name="issue_to_ac" type="text" id="issue_to_ac" value="<?=$jv->issue_to_ac?>"  class="form-control"/>
								
							 <option></option>
									<?
									foreign_relation('accounts_ledger','ledger_id','concat(ledger_id,"  ",ledger_name)',$issue_to_ac,'1');?>
								</select>
								
							</div>
						</div>
						
						<? $ledger_group_id=124002; ?>
						
						<div id="check_no_check" class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Issue From A/C:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<select name="issue_from_ac"   type="text" id="issue_from_ac" value="<?=$jv->issue_from_ac?>" 
										onblur="getData2('cheque_ajax_nibir.php', 'cheque_reference', this.value, document.getElementById('issue_from_ac').value);" 
										class="form-control" />
								    <option></option>
									<? 
									
									foreign_relation('accounts_ledger','ledger_id','concat(ledger_id,"  ",ledger_name)',$issue_from_ac,'ledger_group_id="'.$ledger_group_id.'"');
									
									
									
									
									?>
								</select>

							</div>
						</div>
						
						
						<span id="cheque_reference">
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cheque No:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
							
							<select name="c_no"   type="text" id="c_no"  class="form-control" />
								    <option></option>
									
								</select>

							</div>
						</div>
						</span>
						
						
						<div id="check_no_check" class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cheque Type:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<? if($jv->tr_no>0){ ?><input type="text" name="type" id="type" value="<?=$jv->type?>" readonly="readonly" tabindex="4" class="form-control" /><? }else{?><select name="type" id="type" required tabindex="4" class="form-control" >

											<!--<option value="0"></option>-->
											<option ></option>

											<option value="pay" <?=($jv->type=='pay')?'Selected':'';?> >Account Pay</option>

											<option value="cash" <?=($jv->type=='cash')?'Selected':'';?> >Cash</option>

											</select><? } ?>
							</div>
						</div>
						
						
						
						
						
						

						<!--<div id="check_no_check" class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cheque No:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
							  <input name="c_no" type="text" id="c_no" value="<?php echo $jv->cheq_no?>" size="20" maxlength="25" tabindex="7" <? if($jv->tr_no>0) echo 'readonly'?> class="form-control"/>
							</div>
						</div>-->

						<div id="check_date_check" class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cheque Date:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input name="c_date" type="text" id="c_date" value="<?=$jv->cheq_date?>" size="12" maxlength="15" tabindex="8" <? if($jv->tr_no>0) echo 'disabled'?> class="form-control" autocomplete="off"/>

							</div>
						</div>
						
						
						<div id="check_date_check" class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cheque Name :</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input name="r_from" type="text" id="r_from" value="<?php echo $jv->received_from?>" class="form-control"  tabindex="3" <? if($jv->tr_no>0) echo 'readonly'?> />

							</div>
						</div>
						
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Remarks:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input name="remarks" type="text" id="remarks" tabindex="10" value="<?php echo $jv->remarks?>" class="form-control"   <? if($jv->tr_no>0) echo 'readonly'?> />

							</div>
						</div>

					</div>


				</div>

				<!--Right form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">
						<table  class="table1  table-striped table-bordered table-hover table-sm" border="0" cellspacing="0" cellpadding="0">

							<thead class="thead1">
							<tr class="bgc-info">
								<th>Vou No</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Status</th>
								<th></th>
								<th>Cheque Print </th>
							</tr>
							</thead>

							<tbody class="tbody1">


							<?


							 $sql2="select a.tr_no, a.cr_amt, a.narration,a.jv_date , a.jv_no,a.checked from  cheque_secondary_journal a where a.tr_from='Cheque Issue' and  SUBSTRING(a.tr_no,5,1)='0' and  a.cr_amt>0 and a.group_for=".$_SESSION['user']['group']." group by a.tr_no order by a.id desc limit 5";


							$data2=db_query($sql2);

							if(mysqli_num_rows($data2)>0){

								while($dataa=mysqli_fetch_row($data2))

								{$dataa[2]=substr($dataa[2],0,20).'...';

									?>
									<tr>
										<td><?=$dataa[0]?></td>
										<td><?=$dataa[1]?></td>
										<td><?= date('d-m-Y',strtotime($dataa[3]));?></td>
										<td><? if($dataa[5]=="YES"){ echo "Printed";} else { echo $dataa[5]; }?></td>
										<!--<td width="24" style="padding:1px;" onclick="DoNav('<?php //echo 'v_type=receipt&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[4].'&view=Show&in=Journal_info' ?>');"><img src="../images/copy_hover.png" width="16" height="16" border="0"></td>-->
										
				<td><a href="general_voucher_print_view_for_draft_cheque.php?jv_no=<?php echo $dataa[4];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0"></a></td>
				<td><a href="cheque_print.php?jv_no=<?php echo $dataa[4];?>" target="_blank"><img src="../images/cheque.jpg" width="16" height="16" border="0"></a></td>
										
									</tr>
								<? }}?>
							</tbody>

						</table>


					</div>



				</div>


			</div>


		</div>





		<!--Table input one design-->
		


		<!--Data multi Table design start-->
		<div class="container-fluid pt-4 p-0 ">

			<table class="table1  table-striped table-bordered table-hover table-sm" width="100%" align="center" border="1">
	
		<tr>
			<td colspan="2">
				<input name="add" class="btn1 btn1-bg-submit" type="submit" id="add" value="Submit"  />
				
			</td>

			<td colspan="4">
				<div class="form-group row m-0 pb-1">
					<!--<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Total Amount:</label>-->
					<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
						<input name="t_amount" type="hidden" id="t_amount" size="15" readonly  value="<?php echo $total_amt;?>"/>
					</div>
				</div>
				<input name="count" id="count" type="hidden" value="" />

			</td>

		</tr>
	</form>


	</tbody>

	</table>

</div>


</div>

<script>
	$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});


function bankData(data){

var ledgerId=data;

$.ajax({
        url: "bankAjax.php",
        type: "post",
		dataType: 'json',
        data: { ledgerId: ledgerId} ,
        success: function (data) {
		  console.log(data);
		  $("#r_from").val(data[0]);
        },
    });


}

</script>


<? 

function add_to_cheque_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $narration, $dr_amt, $cr_amt, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$cc_code='',$group='',$entry_by='',$entry_at='',$received_from='', $bank='', $cheq_no='',$cheq_date='',$relavent_cash_head='',$checked='',$type='',$employee='',$remarks='',$reference_id='',$note='',$pay_id='') 



{

	if($group>0) $group_id = $group; else $group_id = $_SESSION['user']['group'];

	if($entry_at=='') $entry_at = date('Y-m-d H:i:s');

	if($entry_by=='') $entry_by = $_SESSION['user']['id']; 

   $journal="INSERT INTO `cheque_secondary_journal` (

	proj_id ,

	jv_no,

	jv_date ,

	ledger_id ,

	narration ,

	dr_amt ,

	cr_amt ,

	tr_from ,

	received_from,

	tr_no ,

	sub_ledger,

	entry_by,

	entry_at,

	group_for,

	tr_id,

	cc_code,

	bank,

	cheq_no,

	cheq_date,

	relavent_cash_head,

	checked,

	type,

	employee_id,

	remarks,

	reference_id,

	note,

	pay_id

	

	)VALUES ('$proj_id', '$jv_no', '$jv_date', '$ledger_id', '$narration', '$dr_amt', '$cr_amt', '$tr_from', '$received_from', '$tr_no','$sub_ledger','$entry_by','$entry_at','$group_id','$tr_id','$cc_code'

	,'$bank','$cheq_no','$cheq_date','$relavent_cash_head','$checked','$type','$employee','$remarks','$reference_id','$note','$pay_id')";

	$query_journal=db_query($journal);

}

?>
<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>