<?


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";



do_calander('#jv_date');
do_calander('#c_date');



$title='Bill Create';



$proj_id=$_SESSION['proj_id'];



$user_id=$_SESSION['user']['id'];



$tr_from = 'Bill';

//var_dump($_SESSION['jv_no']);


if($_GET['mhafuz']>0){

	unset($_SESSION['jv_no']);

	unset($_SESSION['tr_no']);

}


//------------------------------Single row delete area------------------------------//

if($_GET['del']>0){
  $delsql='delete from secondary_journal where id ='.$_GET['del'];
  db_query($delsql);
  header('Location:bill_create.php');
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

 $jv_no = $_SESSION['jv_no'] = next_journal_sec_voucher_id($tr_from);

 $tr_no = $_SESSION['tr_no'] = next_tr_no($tr_from);

}

	else{

		

$jv_no = $_SESSION['jv_no'];

$tr_no = $_SESSION['tr_no'];

	}
	
	if($type=='Debit'){

add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, $amount, '0', $tr_from, $tr_no,'','',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$$receive_ledger,$checked);

}else{
 
 add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, '0', $amount, $tr_from, $tr_no,'','',$cc_code,'',$user_id,'',$r_from, $bank,$c_no,$cheq_date,$$receive_ledger,$checked);


}
}







//print code



if(isset($_POST['limmit'])){

    

	  if($_SESSION['tr_no']>0){

		  

			$j_data = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');

			$detail = 'Received from '.$j_data->received_from;
            $jv_no = $_SESSION['jv_no'];
			$tr_from = 'Bill';


			//add_to_sec_journal($proj_id, $_SESSION['jv_no'], $j_data->jv_date, $j_data->relavent_cash_head,  $detail, '0',$_POST['t_amount'], $tr_from, $_SESSION['tr_no'],'','',$j_data->cc_code,'',$_SESSION['user']['id'],'',$j_data->received_from,$j_data->bank,$j_data->cheq_no,$j_data->cheq_date,$j_data->relavent_cash_head,$checked);



			 $jv_config = find_a_field('voucher_config','direct_journal','voucher_type="Bill"');
		   
		   if($jv_config=="Yes"){

$time_now = date('Y-m-d H:i:s');
$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$_SESSION['jv_no'].'" and tr_from="Bill"';

db_query($up2);

sec_journal_journal($jv_no,$jv_no,$tr_from);

}else{
$up2='update secondary_journal set checked="NO" where jv_no="'.$_SESSION['jv_no'].'" and tr_from="Bill"';

db_query($up2);
}

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


</script>














<!--invoice create-->
<div class="form-container_large">
	<form id="form1" name="form1" method="post" action="?" onsubmit="return checking()">
		<!-- top form start hear -->
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


										<input name="receipt_no" type="text" id="receipt_no" size="15" value="<?=$tr_no?>" class="form-control" />

										<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

										<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>


									</div>
								</div>
							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pl-0">
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12">Voucher Date:</label>
									<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0 pr-2 ">
										<input name="jv_date" type="text" id="jv_date" value="<?=$jv->jv_date?>" size="10" tabindex="1"required <? if($jv->tr_no>0) echo 'readonly'?>  class="form-control"/>
									</div>
								</div>
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
							</tr>
							</thead>

							<tbody class="tbody1">


							<?

							$sql2="select a.tr_no, sum(a.dr_amt) as total_dr, a.narration,a.jv_date , a.jv_no,a.checked



from  secondary_journal a where a.tr_from='Bill' and a.group_for='".$_SESSION['user']['group']."' and SUBSTRING(a.tr_no,5,1)='0' group by a.jv_no   order by a.tr_no desc limit 6";


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

										<td><a href="voucher_print_receipt.php?v_type=Bill&vo_no=<?php echo $dataa[4];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0"></a></td>

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

					<th>Type</th>
					<th>A/C Head</th>
					<th>Cur Bal</th>
					<th>Narration</th>
					<td>Debit</td>
					<td>Credit </td>
					<td> </td>
				</tr>


				</thead>
				<tbody class="tbody1">

				<tr>
					<td><select name="t_type" id="t_type" onchange="mytype()" class="form-control"><option>Debit</option><option>Credit</option></select></td>

					<td>
						<input type="text" id="ledger_id" name="ledger_id" onBlur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" tabindex="8"  class="form-control" />
					</td>

					<td>
						<span id="cur">
							<input name="cur_bal" type="text" id="cur_bal" maxlength="100" readonly="readonly"  class="form-control"/>
						  </span>
					</td>



					<td>
						<input name="detail" type="text" id="detail"  class="form-control" onfocus="getBalance('../../common/cur_bal.php', 'cur', document.getElementById('ledger_id').value);" tabindex="10" />
					</td>



					<td><input name="d_amount" type="text" id="d_amount" size="10"  tabindex="11"  class="form-control"/></td>




					<td><input name="c_amount" type="text" id="c_amount" size="10" tabindex="11"  class="form-control"/></td>


					<td>
						<input name="add_new" class="btn1 btn1-submit-input" type="submit" id="add_new" value="Add New" />
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
					<th>Ledger Name</th>
					<th>Current Balance</th>
					<th>Narration</th>

					<th>Debit</th>
					<td>Credit</td>
					<td>Action</td>
				</tr>

				</thead>


				<tbody class="tbody1">


				<?

				$sql2="select a.id, a.tr_no,l.ledger_name, a.dr_amt,a.cr_amt, a.narration,a.jv_date , a.jv_no



from  secondary_journal a, accounts_ledger l where a.ledger_id=l.ledger_id and a.jv_no='".$_SESSION['jv_no']."' and tr_from='Bill'";

				$qr = db_query($sql2);

				while($data=mysqli_fetch_object($qr)){



					$total_amt_dr = $total_amt_dr+$data->dr_amt;
					$total_amt_cr = $total_amt_cr+$data->cr_amt;



					?>

					<tr align="center">

						<td><?=$data->ledger_name?></td>

						<td></td>

						<td><?=$data->narration?></td>

						<td align="right"><?=($data->dr_amt>0)? $data->dr_amt : '0' ?></td>

						<td align="right"><?=($data->cr_amt>0)? $data->cr_amt : '0' ?></td>

						<td><a href="?del=<?=$data->id?>" >X</a></td>

					</tr>

				<? } ?>

				<tr>
					<td colspan="3" align="right">Total</td>
					<td align="right"><?=$total_amt_dr ?></td>
					<td align="right"><?=$total_amt_cr ?></td>
					<td>&nbsp;</td>
				</tr>



	</form>

	<form method="post">
		<tr>

			<? $deffr = find_a_field('secondary_journal','sum(dr_amt-cr_amt)','tr_from="Bill" and jv_no='.$_SESSION['jv_no']);
			if($deffr != 0){ echo ' <div class="alert alert-warning p-1" role="alert">Debit and Credit are not same.</div> ';}else{
				?>


				<td>
				<input name="receipt_varify" class="btn1 btn1-submit-input" type="button" id="receipt_varify" value="Bill Verified" onclick="this.form.submit()" /> <input name="limmit" type="hidden" value="" />
				</td>


			<? } ?>



			<td><span class="bold">Total Amount: </span></td>

			<td><input name="t_amount" type="text" id="t_amount" size="15" readonly  value="<?php echo $total_amt;?>"/></td>


		</tr>
		<input name="count" id="count" type="hidden" value="" />
	</form>



	</tbody>

	</table>

</div>


</div>



















<?/*>
<br>
<br>
<br>
<br>
<br>
<br>


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



                        <td width="26%">

							<?
$receiptno=next_invoice('tr_no','secondary_journal');

if($v_d>10000)

$v_d=date("d-m-y",$v_d);

if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; }

elseif($old_voucher_mode==1){$v_no_show='value="'.$receiptno.'" readonly'; } 


else $v_no_show='';

?>


<input name="receipt_no" type="text" id="receipt_no" size="15" value="<?=$tr_no?>" class="form-control" />

<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>

</td>


                        <td width="19%" align="right"><div align="right">Voucher Date:</div></td>

                        <td width="30%">
							<input name="jv_date" type="text" id="jv_date" value="<?=$jv->jv_date?>" size="10" tabindex="1"required <? if($jv->tr_no>0) echo 'readonly'?>  class="form-control"/>

						</td>

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



 $sql2="select a.tr_no, sum(a.dr_amt) as total_dr, a.narration,a.jv_date , a.jv_no,a.checked



from  secondary_journal a where a.tr_from='Bill' and a.group_for='".$_SESSION['user']['group']."' and SUBSTRING(a.tr_no,5,1)='0' group by a.jv_no   order by a.tr_no desc limit 6";







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



					  



                      <td  style="padding:1px;" ><a href="voucher_print_receipt.php?v_type=Bill&vo_no=<?php echo $dataa[4];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0"></a></td>



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



              <td width="15%" align="center">Type</td>



              <td width="33%" align="center">A/C Head </td>



              <td width="20%" align="center">Cur Bal </td>



              <td width="29%" align="center">Narration</td>



              <td width="6%" align="center">Debit</td>
			  
			  <td width="6%" align="center">Credit</td>



              <td width="6%" rowspan="2" align="center">



                <input name="add_new" class="btn1 btn1-submit-input" type="submit" id="add_new" value="Add New" />

				<input name="add" type="hidden" />


            </tr>

            <tr>




              <td><select name="t_type" id="t_type" onchange="mytype()"  class="form-control"><option>Debit</option><option>Credit</option></select></td>


              <td align="center">			 



                <input type="text" id="ledger_id" name="ledger_id" onBlur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" tabindex="8" style="width:438px;"  class="form-control" />                </td>



              <td align="center"><span id="cur">



                <input name="cur_bal" type="text" id="cur_bal" maxlength="100" readonly="readonly"  class="form-control"/>



              </span> </td>



              <td align="center">



              	<input name="detail" type="text" id="detail"  class="form-control" onfocus="getBalance('../../common/cur_bal.php', 'cur', document.getElementById('ledger_id').value);" tabindex="10" style="width:100%;"/>              </td>



              <td align="center"><input name="d_amount" type="text" id="d_amount" size="10" style="width:100px;" tabindex="11"  class="form-control"/></td>




              <td align="center"><input name="c_amount" type="text" id="c_amount" size="10" style="width:100px;" tabindex="11"  class="form-control"/></td>


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
					  
					  <td align="center">Debit</td>

					  <td align="center">Credit</td>

					  <td align="center">Action</td>

				   </tr>

				   <?

				     $sql2="select a.id, a.tr_no,l.ledger_name, a.dr_amt,a.cr_amt, a.narration,a.jv_date , a.jv_no



from  secondary_journal a, accounts_ledger l where a.ledger_id=l.ledger_id and a.jv_no='".$_SESSION['jv_no']."' and tr_from='Bill'";

       $qr = db_query($sql2);

	   while($data=mysqli_fetch_object($qr)){

	           

			      $total_amt_dr = $total_amt_dr+$data->dr_amt;
				  $total_amt_cr = $total_amt_cr+$data->cr_amt;
				  
				 

				   ?>

				   <tr align="center">

				      <td><?=$data->ledger_name?></td>

					  <td></td>

					  <td><?=$data->narration?></td>
                      
					   <td align="right"><?=($data->dr_amt>0)? $data->dr_amt : '0' ?></td>
					   
					  <td align="right"><?=($data->cr_amt>0)? $data->cr_amt : '0' ?></td>

					  <td><a href="?del=<?=$data->id?>" >X</a></td>

				   </tr>

				   <? } ?>
				   
				   <tr>
				       <td colspan="3">Total</td>
					    <td align="right"><?=$total_amt_dr ?></td>
						<td align="right"><?=$total_amt_cr ?></td>
						<td>&nbsp;</td>
				   </tr>

				</table>

          </td>



        </tr>

		 </table>

		 </form>

		<form method="post">

<table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">

        <tr>

    <? $deffr = find_a_field('secondary_journal','sum(dr_amt-cr_amt)','tr_from="Bill" and jv_no='.$_SESSION['jv_no']);
	   if($deffr != 0){ echo 'Debit and Credit are not same.';}else{
	?> 

              <td width="19%" style="text-align:right;"><input name="receipt_varify" class="btn1 btn1-submit-input" type="button" id="receipt_varify" value="Bill Verified" onclick="this.form.submit()" /> <input name="limmit" type="hidden" value="" />             </td>

    <? } ?>

              <td style="text-align:right;" valign="middle"><label></label>
                <span>Total Amount: </span></td>
              <td width="22%"><input name="t_amount" type="text" id="t_amount" size="15" readonly  style="width:130px;" value="<?php echo $total_amt;?>"/></td>
              </tr>
      </table>

      <input name="count" id="count" type="hidden" value="" />

    </form>

  </div></td>
</tr>

		</table>
</div></td>



  </tr>



</table>


<*/?>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>