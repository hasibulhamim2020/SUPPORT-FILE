<?


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$cid = explode('.', $_SERVER['HTTP_HOST'])[0];

do_calander('#jv_date');
do_calander('#c_date');

$c_id = $_SESSION['proj_id'];

$target_url = '../files/general_voucher_print_view_for_draft.php';

$title='Journal Voucher';



$proj_id=$_SESSION['proj_id'];



$user_id=$_SESSION['user']['id'];



$tr_from = 'Journal';

//var_dump($_SESSION['jv_no']);


if($_GET['mhafuz']>0){

	unset($_SESSION['jv_no']['Journal']);

	unset($_SESSION['tr_no']['Journal']);

}

if($_GET['jv_no']['Journal']>0){
  $_SESSION['jv_no']['Journal']=$_GET['jv_no']['Journal'];
}

if($_GET['tr_no']['Journal']>0){
  $_SESSION['tr_no']['Journal']=$_GET['tr_no']['Journal'];
}

//else

//{

//    $jv_no = $_SESSION['jv_no'] = next_journal_sec_voucher_id($tr_from);

//	$tr_no = $_SESSION['tr_no'] = next_tr_no($tr_from);

//

//}



$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020'");







///////////////////









if(isset($_POST['add']) && $_SESSION['csrf_token']===$_POST['csrf_token'])

{   

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

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
			
			$manual_voucher_no = $_REQUEST['manual_voucher_no'];


			$reference_id = $_REQUEST['reference_id'];
			$sub_ledger = $_REQUEST['sub_ledger'];

			
			
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

	

if($_SESSION['jv_no']['Journal']==0){

 $jv_no = $_SESSION['jv_no']['Journal'] = next_journal_sec_voucher_id($tr_from,'Journal',$_SESSION['user']['group'],$_SESSION['user']['id']);

 $tr_no = $_SESSION['tr_no']['Journal'] = next_tr_no($tr_from);

}

	else{

		

$jv_no = $_SESSION['jv_no']['Journal'];

$tr_no = $_SESSION['tr_no']['Journal'];

	}

	$folder = 'JournalVoucher';
	$field = 'file_upload';
	$file_name = $field . '-' . $_SESSION['jv_no']['Journal'];
	if ($_FILES['file_upload']['tmp_name'] != '') {
		$uploaded_file = upload_file($folder, $field, $file_name);
	}
	if($type=='Debit'){
	if($jv_no>0){	
	add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, $amount, '0', $tr_from, $tr_no,$sub_ledger,'',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$$receive_ledger,$checked,$type,$employee,$remarks,$uploaded_file,$reference_id);
	}
}else{
	 if($jv_no>0){	
	 add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, '0', $amount, $tr_from, $tr_no,$sub_ledger,'',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$$receive_ledger,$checked,$type,$employee,$remarks,$uploaded_file,$reference_id);
	}

		}
		
	$up = 'update secondary_journal set  manual_voucher_no="'.$manual_voucher_no.'" where jv_no="'.$_SESSION['jv_no']['Journal'].'"';
	db_query($up);
}




//print code



if(isset($_POST['limmit']) && $_SESSION['csrf_token']===$_POST['csrf_token']){

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

	  if($_SESSION['tr_no']['Journal']>0){
		if($_SESSION['jv_no']['Journal']>0){
		  

			$j_data = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no']['Journal'].'"');

			$detail = 'Received from '.$j_data->received_from;



			//add_to_sec_journal($proj_id, $_SESSION['jv_no'], $j_data->jv_date, $j_data->relavent_cash_head,  $detail, '0',$_POST['t_amount'], $tr_from, $_SESSION['tr_no'],'','',$j_data->cc_code,'',$_SESSION['user']['id'],'',$j_data->received_from,$j_data->bank,$j_data->cheq_no,$j_data->cheq_date,$j_data->relavent_cash_head,$checked);



			$up = 'update secondary_journal set checked="NO" where jv_no="'.$_SESSION['jv_no']['Journal'].'"';

			db_query($up);

			$_SESSION['jv_no']['Journal']    = '';

			$_SESSION['receipt_no']['Journal'] = '';

	}

  }else{

  

    $msg = '<span style="color:red">Data Re-Submit Not Allowed..!</span>';

	$_SESSION['receipt_no']['Journal'] = '';

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

 unset($_SESSION['jv_no']['Journal']);

	unset($_SESSION['tr_no']['Journal']);
  

}





if($_GET['del']>0)
{
		//$crud   = new crud($table_details);
		//$condition="id=".$_GET['del'];		
		//$crud->delete_all($condition);
		 $del_jv = "delete from secondary_journal where tr_from='Journal' and id = '".$_GET['del']."'";
		db_query($del_jv);
		
		$type=1;
		$msg='Successfully Deleted.';
}





$jv = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no']['Journal'].'"');

if($_SESSION['jv_no']['Journal']==0){

	

	$jv_no = next_journal_sec_voucher_id($tr_from,'Journal',$_SESSION['user']['group'],$_SESSION['user']['id']);

	$tr_no = next_tr_no($tr_from);

}

else{

	$jv_no = $_SESSION['jv_no']['Journal'];

	$tr_no = $_SESSION['tr_no']['Journal'];

}



js_ledger_subledger_autocomplete_new('journal',$proj_id,$voucher_type,$_SESSION['user']['group']); 



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

auto_complete_start_from_db('accounts_ledger',"concat(ledger_name,'##>>',ledger_id)","concat(ledger_name,'##>>',ledger_id)","ledger_name not like '%cash%' and ledger_group_id='1011' and parent=0 order by ledger_id","b_id");

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


















<!--Journal note new-->
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

										if($v_d>10000)

											$v_d=date("d-m-y",$v_d);

										if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; }

										elseif($old_voucher_mode==1){$v_no_show='value="'.$receiptno.'" readonly'; }

										else $v_no_show='';

										?>


										<input name="receipt_no" type="text" id="receipt_no" size="15" tabindex="1" value="<?=$tr_no?>" class="form-control" />
										<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>
										<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>


									</div>
								</div>
							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pl-0">
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12">Voucher Date:</label>
									<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0 pr-2 ">


										<input name="jv_date" type="text" id="jv_date"
											 tabindex="2"  value="<?php if($jv->jv_date==""){
												   echo $today=date('Y-m-d');
											   }else{
												   echo $jv->jv_date;
											   } ?>" size="10" <?php /*?><? if($jv->tr_no>0) echo 'disabled'?><?php */?> required class="form-control" />



										<input name="r_from" type="hidden" id="r_from" value="<?php echo $jv->received_from?>" class="input1" required <? if($jv->tr_no>0) echo 'readonly'?>/>


									</div>
								</div>
							</div>
						</div>


						<div class="form-group row m-0 pb-1">
							<label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Remarks:</label>
							<div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 p-0 pr-2">
								<input name="remarks" type="text" id="remarks" tabindex="3" value="<?php echo $jv->remarks?>" class="form-control"   <? if($jv->tr_no>0) echo 'readonly'?> />

							</div>
						</div>
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Manual Voucher No:</label>
							<div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 p-0 pr-2">
							<input name="manual_voucher_no" type="text" id="manual_voucher_no" value="<?php echo $jv->manual_voucher_no?>" tabindex="10" class="form-control"   <? if($jv->tr_no>0) echo 'readonly'?> />

							</div>
						</div>
						

						<?php /*?><div class="form-group row m-0 pb-1">
							<label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">File Attachement:</label>
							<div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 p-0 pr-2">
							<input name="file_upload" type="file" id="file_upload"
									tabindex="10" class="form-control" <? if ($jv->tr_no > 0) ?> />
								<?php $file_name = find_a_field('secondary_journal', 'file_upload', 'jv_no="' . $_SESSION['jv_no']['Journal'] . '" and file_upload!=""');
								if ($file_name != '') { ?>
									<a href="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $file_name ?>&folder=JournalVoucher&proj_id=<?= $_SESSION['proj_id'] ?>"
										target="_blank">View Attachment</a>
								<?php } ?>


							</div>
						</div><?php */?>


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
							</tr>
							</thead>

							<tbody class="tbody1">

							<?
							$sql2="select a.tr_no, a.dr_amt, a.narration,a.jv_date , a.jv_no,a.checked

from  secondary_journal a where a.tr_from='Journal'  and SUBSTRING(a.tr_no,5,1)='0' and  a.dr_amt>0 and a.checked in ('NO','YES') and a.group_for=".$_SESSION['user']['group']." group by a.tr_no order by a.tr_no desc limit 5";

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
										<td  style="padding:1px;" ><a href="" onclick="custom('<?=url_encode($dataa[4]);?>','<?=url_encode($c_id);?>');"><img src="../images/print.png" width="16" height="16" border="0"></a></td>
										<? } else {?>
										<td  style="padding:1px;" ><a href=""  onclick="custom('<?=url_encode($dataa[4]);?>','<?=url_encode($c_id);?>');"><img src="../images/print.png" width="16" height="16" border="0"></a></td>
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

				<?
				//$jv_details="SELECT a.*, b.ledger_name FROM secondary_journal a, accounts_ledger b WHERE  a.ledger_id=b.ledger_id and a.jv_no='".$_SESSION['jv_no']."' order by id desc limit 1";
				//$jv_data = find_all_field_sql($jv_details);
				?>

				<thead class="thead1">
				<tr class="bgc-info">

					<th>Type</th>
					<th>GL Code</th>
					<th>GL Name</th>
					<th>Sub Ledger</th>
					<th>Cost Center</th>
					<th>Narration</th>
					<td>Debit</td>
					<td>Credit </td>
					<td> </td>
				</tr>

				</thead>
				<tbody class="tbody1">

				<tr>

					<td>
						<select name="t_type" id="t_type" onchange="mytype()" tabindex="4" class="form-control">
							<option>Debit</option>
							<option>Credit</option>
						</select>
					</td>


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

											<?php /*?><select name="reference_id" id="reference_id"  tabindex="2"  style="width:120px;">
												<option></option>
												<? foreign_relation('acc_reference','id','reference_name',$jv_data->reference_id,"ledger_id='".$jv_data->ledger_id."'");?>
											  </select><?php */?>
										</td>
									</tr>
								</table>
							</span>
					</td>

					<td align="center"><input list="sub_ledgers"  name="sub_ledger" id="sub_ledger" value="<?=$sub_ledger?>" class="form-control"/>


<datalist id="sub_ledgers">


<option></option>


<? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$sub_ledger,"1");?>


</datalist></td>
					<td>
						<span id="cur">
							<select name="cc_code" id="cc_code"  class="form-control"  tabindex="7">
								<option></option>
								<? foreign_relation('cost_center','id','center_name',$jv_data->cc_code,"group_for='".$_SESSION['user']['group']."'");?>
							</select>
						</span>
					</td>


					<td><input name="detail" type="text" id="detail"  tabindex="8" class="form-control"/></td>

					<td><input name="d_amount" type="text" id="d_amount" size="10" class="form-control" tabindex="9"/></td>

					<td><input name="c_amount" type="text" id="c_amount" size="10" class="form-control" tabindex="10"/></td>

					<td>
						<input name="add_new" class="btn1 btn1-bg-submit" type="submit" id="add_new" value="Add New" tabindex="11" />
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
					<th>Narration</th>

					<th>Debit</th>
					<td>Credit</td>
					<td>Action</td>
				</tr>

				</thead>


				<tbody class="tbody1">




				<?

				$sql2="select a.id, a.ledger_id, a.tr_no,l.ledger_name, a.sub_ledger , a.dr_amt, a.cr_amt, a.narration,a.jv_date , a.jv_no, a.cc_code, a.reference_id

from  secondary_journal a, accounts_ledger l where a.ledger_id=l.ledger_id and a.jv_no='".$_SESSION['jv_no']['Journal']."' and a.tr_from='Journal' ";

				$qr = db_query($sql2);

				while($data=mysqli_fetch_object($qr)){

					$total_amt = $total_amt+$data->dr_amt;

					?>

					<tr align="center" style="padding:5px;">

						<td><?=$data->ledger_id?></td>

						<td align="left"><?=$data->ledger_name?></td>
						<td align="left"><?=find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id='.$data->sub_ledger);?></td>
						<td><?=find_a_field('cost_center','center_name','id='.$data->cc_code);?></td>
						<td><?=$data->narration?></td>
						<td><?=$data->dr_amt?></td>

						<td><?=$data->cr_amt?></td>
						<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$data->id?>">&nbsp;<img src="del.png" width="25" height="auto" />&nbsp;</a></td>
					</tr>

				<? } ?>



	</form>

	<form method="post">
		<tr>
			<td colspan="4">
				<? $deffr = find_a_field('secondary_journal','sum(dr_amt-cr_amt)','tr_from="Journal" and jv_no='.$_SESSION['jv_no']['Journal']);?>
				<input name="receipt_varify" class="btn1 btn1-bg-submit" type="button" id="receipt_varify" <? if($deffr==0){ echo 'hi';}else{?>style="visibility:hidden"<? }?> value="Journal Verified" onclick="this.form.submit()" /> <input name="limmit" type="hidden" value="" />
				<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>

			</td>

			<td colspan="3">
				<div class="form-group row m-0 pb-1">
					<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Difference: </label>
					<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
						<input name="t_amount" type="text" id="t_amount" size="15" readonly  style="width:130px;" value="<?php echo $deffr;?>"/>
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
</script>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>