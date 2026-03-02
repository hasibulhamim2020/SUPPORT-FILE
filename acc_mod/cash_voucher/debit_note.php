<?
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
session_start();

ob_start();
$c_id = $_SESSION['proj_id'];

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];


do_calander('#jv_date');
do_calander('#c_date');

$title='Payment Voucher';

$target_url = '../cash_voucher/general_voucher_print_view_for_draft.php';

$proj_id=$_SESSION['proj_id'];



$user_id=$_SESSION['user']['id'];



$tr_from = 'Payment';





if($_GET['new']>0){

	unset($_SESSION['jv_no']['Payment_cash']);

	unset($_SESSION['tr_no']['Payment_cash']);

}
if($_GET['jv_no']>0){
  $_SESSION['jv_no']['Payment_cash']=$_GET['jv_no']['Payment'];
}

if($_GET['tr_no']['Payment']>0){
  $_SESSION['tr_no']['Payment_cash']=$_GET['tr_no']['Payment'];
}






$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' ");







///////////////////









if(isset($_POST['add']) && $_SESSION['csrf_token']===$_POST['csrf_token'])

{   

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$v_date		= $_SESSION['old_v_date']=$_REQUEST["date"];

$ledger_id	= $_REQUEST["ledger_id"];

$bank		= $_REQUEST["bank"];

$r_from		= $_REQUEST['r_from'];

$c_no		= $_REQUEST['c_no'];

 

 

$cheq_date	= $_REQUEST['c_date'];

$c_id		= $_REQUEST['c_id'];

$jv_date	= $_REQUEST['jv_date'];

$type		= $_REQUEST['type'];



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

	

if(is_numeric($ledger1)) {

$receive_ledger = $ledger1;}

else {

$receive_ledger = $ledger2;}




	//////////////////////////

			$ledger_id=$_REQUEST['ledger_id'];

			$ledgers = explode('::',$ledger_id);

			 $ledger_id = $ledgers[0];

			$detail_status = $_REQUEST['detail'];		

			$cur_bal= $_REQUEST['cur_bal'];

			$detail = $_REQUEST['detail'];

			$amount = $_REQUEST['amount'];

			$cc_code = $_REQUEST['cc_code'];


			$remarks = $_REQUEST['remarks'];
			$manual_voucher_no = $_REQUEST['manual_voucher_no'];


			$reference_id = $_REQUEST['reference_id'];
			$sub_ledger = $_REQUEST['sub_ledger'];

			$group_for = $_REQUEST['group_for'];


			

			if($bank=='') {

			$dnarr=$detail;}



			else {

			$dnarr=$detail.'  Cheq# '.$c_no.':: Date= '.$cheq_date;}





$checked = 'UNFINISHED';

	

if($_SESSION['jv_no']['Payment_cash']==0){

 $jv_no = $_SESSION['jv_no']['Payment_cash'] = next_journal_sec_voucher_id($tr_from,'Payment',$group_for,$_SESSION['user']['id']);

 $tr_no = $_SESSION['tr_no']['Payment_cash'] = next_tr_no($tr_from);

}

	else{

		

 $jv_no = $_SESSION['jv_no']['Payment_cash'];

$tr_no = $_SESSION['tr_no']['Payment_cash'];

	}

	$folder = 'PaymentVoucher';
	$field = 'file_upload';
	$file_name = $field . '-' . $_SESSION['jv_no']['Payment_cash'];
	if ($_FILES['file_upload']['tmp_name'] != '') {
		$uploaded_file = upload_file($folder, $field, $file_name);
	}


	if($receive_ledger>0){
if($jv_no>0){	
	 $receive_ledger;

	add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, $amount, '0', $tr_from, $tr_no,$sub_ledger,'',$cc_code,$group_for,$user_id,'',$r_from, $bank,$c_no,$cheq_date,$receive_ledger,$checked,$type,$employee,$remarks,$uploaded_file,$reference_id);

	$up = 'update secondary_journal set   manual_voucher_no="'.$manual_voucher_no.'" where jv_no="'.$_SESSION['jv_no']['Payment_cash'].'"';
	db_query($up);
	

}
}
else{
echo "<h1 style='text-align:center;color:red;font-weight:bold;'>Please select Cash or Bank head first</h1>";
}
}



//print code



if(isset($_POST['limmit']) && $_SESSION['csrf_token']===$_POST['csrf_token']){

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

	  if($_SESSION['tr_no']['Payment_cash']>0){
		if($_SESSION['jv_no']['Payment_cash']>0){
		  

			$j_data = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no']['Payment_cash'].'"');

			$detail = 'Paid Through : '.$j_data->received_from;

			$sub_led = find_all_field('general_sub_ledger','','sub_ledger_id="'.$j_data->relavent_cash_head.'"');

			add_to_sec_journal($proj_id, $_SESSION['jv_no']['Payment_cash'], $j_data->jv_date, $sub_led->ledger_id,  $detail, '0',$_POST['t_amount'], $tr_from,$j_data->tr_no,$j_data->relavent_cash_head,'',0,$j_data->group_for,$_SESSION['user']['id'],'',$j_data->received_from,$j_data->bank,$j_data->cheq_no,$j_data->cheq_date,$j_data->relavent_cash_head,$checked,
			$j_data->type,$j_data->employee_id, $j_data->remarks , '0' );


    $reconsilation_type = find_a_field('general_configuration','cash_bank_reconsilation','group_for="'.$group_for.'"');
	if($reconsilation_type == 'No'){
	$reconsilation_note = 'Reconsilation Pending';
	}else{
	$reconsilation_note = '';
	}
			$up = 'update secondary_journal set checked="NO", manual_voucher_no="'.$j_data->manual_voucher_no.'", reconsilation_status="'.$reconsilation_type.'",reconsilation_note="'.$reconsilation_note.'" where jv_no="' . $_SESSION['jv_no']['Payment_cash']. '" and tr_from="'.$tr_from.'"';
			db_query($up);

			
			



			$_SESSION['jv_no']['Payment_cash']     = '';

			$_SESSION['receipt_no']['Payment'] = '';
			
		}	
	

  }else{

  

    $msg = '<span style="color:red">Data Re-Submit Not Allowed..!</span>';

	$_SESSION['receipt_no']['Payment'] = '';

  }





$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');

$time_now = date('Y-m-d H:i:s');

if($sa_config=="Yes"){

$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');


if($jv_config=="Yes"){



$time_now = date('Y-m-d H:i:s');

$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);



sec_journal_journal($j_data->jv_no,$j_data->jv_no,$tr_from);
}


} else {

$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

}




  
  
  	unset($_SESSION['jv_no']['Payment_cash']);

	unset($_SESSION['tr_no']['Payment_cash']);

  

}



if($_GET['del']>0)
{
	
		 $del_jv = "delete from secondary_journal where tr_from='Payment' and id = '".$_GET['del']."'";
		db_query($del_jv);
		
		$type=1;
		$msg='Successfully Deleted.';
}














$jv = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no']['Payment_cash'].'"');

if($_SESSION['jv_no']['Payment_cash']==0){

	

	$jv_no = next_journal_sec_voucher_id($tr_from,'Payment',$_SESSION['user']['group'],$_SESSION['user']['id']);

	$tr_no = next_tr_no($tr_from);

}

else{

	$jv_no = $_SESSION['jv_no']['Payment_cash'];

	$tr_no = $_SESSION['tr_no']['Payment_cash'];

}



if($jv->tr_no==0){ 

create_combobox('cash_disable_id');
}


js_ledger_subledger_autocomplete_new('receipt',$proj_id,$voucher_type,$_SESSION['user']['group']); 



?>








<script type="text/javascript">

function custom(theUrl,c_id)
{
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
}

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




function FetchList(id){
	

	var type = document.getElementById('type').value;
	var group_for = document.getElementById('group_for').value*1;
	

    $.ajax({
      type:'post',
      url: 'ledger_data_ajax.php',
      data : { group_for : group_for, type:type},
      success : function(data){
	  
	  	if(type=='CASH'){
		
         	$('#type_cash').html(data);
			
		 }else{
		 	console.log(data);
			$('#type_bank').html(data);
		 }
		 
      }

    })
  }

function FetchList2(){
	

	
	var group_for = document.getElementById('group_for').value*1;
	

    $.ajax({
      type:'post',
      url: 'SubLedger_data_ajax.php',
      data : { group_for : group_for, },
      success : function(data){
	  
	  	
		$('#fetch_sub_ledger').html(data);
		 
		 
      }

    })
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
	<form id="form1" name="form1" method="post" action="?" enctype="multipart/form-data" onsubmit="return checking()">
		<!--        top form start hear-->
		<div class="container-fluid bg-form-titel">
			<div class="row">
				<!--left form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">

						<div class="row pb-1">
							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12">Voucher No:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<?

										$receiptno=next_invoice('tr_no','secondary_journal');


										if($v_d>10000) {


											$v_d=date("d-m-y",$v_d); }



										if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; }


										elseif($old_voucher_mode==1){$v_no_show='value="'.$receiptno.'" readonly'; }


										else {$v_no_show='';}

										?>

										<input name="receipt_no" type="text" id="receipt_no" size="15" tabindex="1" value="<?=$tr_no?>" <? if($jv->tr_no>0) { echo 'disabled';} ?> class="form-control"/>

										<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

										<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

									</div>
								</div>
							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pl-0">
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12">Voucher Date:</label>
									<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0 pr-2 ">

										<input name="jv_date" type="text" id="jv_date" value="<?php if($jv->jv_date==""){echo $today=date('Y-m-d');}else{ echo $jv->jv_date; } ?>" size="10" <?php /*?><? if($jv->tr_no>0) echo 'disabled'?><?php */?>  tabindex="2"required class="form-control" />

									</div>
								</div>
							</div>
						</div>


						<div class="row pb-1">
							

							
							
							
							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12 ">Paid To:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

										<input name="r_from" type="text" id="r_from" value="<?php echo $jv->received_from?>" class="form-control"  tabindex="3" <? if($jv->tr_no>0) { echo 'readonly';} ?> />


									</div>
								</div>
							</div>
							
							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pl-0">
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text  font-size12">Payment Mode:</label>
									<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0 pr-2 ">

										<? if($jv->tr_no>0){ ?><input type="text" name="type" id="type" value="<?=$jv->type?>" readonly="readonly" tabindex="4" class="form-control" /><? }else{?><select name="type" id="type" required onChange="check_type()" tabindex="4" class="form-control">

											<option value="CASH" <?=($jv->type=='CASH')?'Selected':'';?> >CASH</option>

											

											</select><? } ?>



									</div>
								</div>
							</div>
							
							
						</div>

	<?php 
							$proj_all=find_all_field('project_info','*','1');
							$gr_all=find_all_field('config_group_class','*','group_for='.$_SESSION['user']['group']); //update_by jobaraj date :02/11/2023
							if($proj_all=='nal_new'){
							$cash_ledg_group_id=127001;
							$bank_ledg_group_id=127002;
							}
							else{
							$cash_ledg_group_id=$gr_all->cash_group;
							$bank_ledg_group_id=$gr_all->bank_group;
							}
							?>
						<div class="form-group row m-0 pb-1">
								<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Company : </label>
													<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2 ">
						 <? if($_POST['group_for']>0) {?>
									   <input type="hidden" name="group_for" id="group_for" value="<?=$_POST['group_for'];?>" class="m-0" readonly/>
								<input type="text" name="group_for_show" id="group_for_show" value="<?=find_a_field('user_group','group_name','id='.$_POST['group_for']);?>" readonly=""/>
						
									   <? } else { ?>
									  <select name="group_for" id="group_for"  onchange="FetchList();FetchList2()"  required>
						
										<option></option>
										<? user_company_access($group_for); ?>
									  </select>
									  <? } ?>
						
													</div>
												</div>
						<div id="cash_check" class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cash A/C: </label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2 ">
								<span id="type_cash" >
								<? if($jv->tr_no>0){ ?><input type="text" name="c_id_name" id="cash_disable_id" readonly value="<?=find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$jv->relavent_cash_head.'"');?>" style="float:left" tabindex="5"/>
								<input type="hidden" name="c_id" value="<?=$jv->relavent_cash_head?>" />
								<? } else{?>
									<select name="c_id" id="cash_disable_id"  tabindex="5"  >

									<option value="0"></option>

									<?

									foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$c_id,"ledger_id=".$gr_all->cash_ledger." order by ledger_id");

									?>

									</select><? } ?>
								</span>

							</div>
						</div>



						<div class="form-group row m-0 pb-1">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Remarks:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input name="remarks" type="text" id="remarks" tabindex="10" value="<?php echo $jv->remarks?>" class="form-control"   <? if($jv->tr_no>0) { echo 'readonly';} ?> />

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
								<th>Print</th>
							</tr>
							</thead>

							<tbody class="tbody1">

 
							<?


							$sql2="select a.tr_no, a.cr_amt, a.narration,a.jv_date , a.jv_no,a.checked from  secondary_journal a where a.tr_from='Payment' and  SUBSTRING(a.tr_no,5,1)='0' and  a.cr_amt>0 and a.type='CASH' and  a.group_for in (" .user_company_access_list(). ") group by a.tr_no order by a.id desc limit 5";


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
									
										<? if($cid == 'mamun'){?>
										<td><a href="" onclick="custom('<?=url_encode($dataa[4]);?>','<?=url_encode($c_id);?>');"><img src="../images/print.png" width="16" height="16" border="0"></a></td>
										<? } else {?>
											<td><a href="" onclick="custom('<?=url_encode($dataa[4]);?>','<?=url_encode($c_id);?>');"><img src="../images/print.png" width="16" height="16" border="0"></a> <?
										
										 $sec_journal=find_a_field('secondary_journal','ledger_id','cr_amt!=0 and jv_no='.$dataa[4]);
										 if($gr_all->bank_ledger==$sec_journal){ ?>
										<a href="" onclick="custom('<?=url_encode($dataa[4]);?>','<?=url_encode($c_id);?>');"><button type="button" class="btn2 btn1-bg-help"><i class="fa-solid fa-print"></i></button></a>
										
										<? } ?> </td>
										<? }?>
										
									</tr>
								<? }}?>
							</tbody>

						</table>


					</div>



				</div>


			</div>


		</div>





		<!--Table input one design-->
		<div class="container-fluid pt-4 p-0 ">



			<table class="table1  table-striped table-bordered table-hover table-sm">


				

				<thead class="thead1">
				<tr class="bgc-info">
					<th>GL Code</th>
					<th>GL Name</th>
					<th>Sub Ledger</th>
					<th>Cost Center</th>
					<th>Narration</th>
					<td>Amount</td>
					<td></td>
				</tr>

				</thead>
				<tbody class="tbody1">

				<tr>

					<td>
						<input type="text" class="form-control" id="ledger_id" name="ledger_id" onblur="getData2('acc_reference_ajax.php', 'acc_reference', this.value,
						document.getElementById('ledger_id').value);" tabindex="11"  value="<?=$jv_data->ledger_id?>"  />
						
						<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
						
					</td>

					<td>
							<span id="acc_reference">
								<table width="100%" border="1" align="center" cellpadding="2" cellspacing="2">
									<tr>
										<td class="p-0">
											<input type="text" id="ledger_name" name="ledger_id" class="form-control" tabindex="12" value="<?=$jv_data->ledger_name?>" />

											<input type="hidden" class="form-control"id="reference_id" name="reference_id"  value="<?=$jv_data->reference_id?>"/>

											
										</td>
									</tr>
								</table>
							</span>
					</td>
					<td align="center">

					<span id="fetch_sub_ledger">
<input list="sub_ledgers"  name="sub_ledger" id="sub_ledger" value="<?=$sub_ledger?>" autocomplete="off" class="form-control"/>
<datalist id="sub_ledgers">
  <option></option>
  <? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$sub_ledger,"1");?>
</datalist>
					</span>
</td>

					<td><select name="cc_code" id="cc_code"  class="form-control"  tabindex="13">
							<option></option>
							<? foreign_relation('cost_center','id','center_name',$jv_data->cc_code,"group_for='".$_SESSION['user']['group']."'");?>
						</select>
						
						</td>
					<td>
						<input name="detail" type="text" id="detail" class="form-control"  tabindex="14"/>
					</td>

					<td><input name="amount" type="text" id="amount" size="5" class="form-control" tabindex="15"/></td>

					<td>
						<input name="add_new" class="btn1 btn1-bg-submit" type="submit" id="add_new" value="Add New" tabindex="16" />
						<input name="add" type="hidden" />
					</td>
				</tr>

				</tbody>
			</table>

		</div>


		<!--Data multi Table design start-->
		<div class="container-fluid pt-4 p-0 ">

			<table class="table1  table-striped table-bordered table-hover table-sm" width="100%" align="center" border="1">

				<thead class="thead1">
				<tr class="bgc-info">
					<th>GL Code</th>
					<th>GL Name</th>
					<th>Sub Ledger</th>
					<th>Cost Center</th>
					<th><strong>Narration</strong></th>
					<th><strong>Amount</strong></th>
					<td><strong>Action</strong></td>
				</tr>

				</thead>


				<tbody class="tbody1">


				<?

				$sql2="select a.id, a.ledger_id, a.tr_no,l.ledger_name, a.dr_amt, a.narration,a.jv_date , a.jv_no, a.cc_code, a.reference_id,a.sub_ledger

from  secondary_journal a, accounts_ledger l where a.ledger_id=l.ledger_id and a.jv_no='".$_SESSION['jv_no']['Payment_cash']."' and tr_from='Payment'";

				$qr = db_query($sql2);

				while($data=mysqli_fetch_object($qr)){

					$total_amt = $total_amt+$data->dr_amt;

					?>

					<tr>

						<td><?=$data->ledger_id?></td>

						<td align="left"><?=$data->ledger_name?></td>
						<td><?=find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id='.$data->sub_ledger);?></td>
						<td><?=find_a_field('cost_center','center_name','id='.$data->cc_code);?></td>
						<td><?=$data->narration?></td>
						<td><?=$data->dr_amt?></td>

						<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$data->id?>">&nbsp;<img src="del.png" width="25" height="auto" />&nbsp;</a></td>
					</tr>

				<? } ?>


	</form>

	<form method="post">
		<tr>
			<td colspan="4">
				<input name="receipt_varify" class="btn1 btn1-bg-submit" type="button" id="receipt_varify" value="Payment Verified" onclick="this.form.submit()" />
				<input name="limmit" type="hidden" value="" />
				<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
			</td>

			<td colspan="3">
				<div class="form-group row m-0 pb-1">
					<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Total Amount:</label>
					<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
						<input name="t_amount" type="text" id="t_amount" size="15" readonly  value="<?php echo $total_amt;?>"/>
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

require_once SERVER_CORE."routing/layout.bottom.php";
?>
