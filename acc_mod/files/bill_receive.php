<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";



$title='Bill Receive';


  create_combobox('do_no');

do_calander('#invoice_date');
//do_calander('#ldbc_no_date');
do_calander('#bill_date');

do_calander('#f_date');
do_calander('#t_date');

/*if($_POST['dealer_code']>0){
$_SESSION['new_biller'] = $_POST['dealer_code'];
}*/

if($_REQUEST['new']>0){
unset($_SESSION['new_biller']);
}

if ($data_found==0) {
 create_combobox('dealer_code');
  }





if(isset($_REQUEST['received']))

{

if($_POST['f_date']!=''&&$_POST['t_date']!='') $con = ' and b.bill_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
if($_POST['dealer_code']!='')
$con .=" and b.customer=".$_POST['dealer_code'];
  
  
$jv_no=next_journal_sec_voucher_id();
$proj_id = 'clouderp'; 
$cc_code = '1';
$group_for =  $_SESSION['user']['group'];
$config_ledger = find_all_field('config_group_class','','group_for="'.$group_for.'"');
$tr_from = 'BillReceive';


$sql = "select b.bill_no,d.dealer_name_e, b.bill_date, b.manual_bill_no, b.amount, b.status,b.customer from bill_info b, dealer_info d where b.customer=d.dealer_code and b.status='BILL SUBMITTED' ".$con."";
 
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

if($_POST['check'.$data->bill_no]=='checked'){
 $bank_ledger = $_POST['bank'.$data->bill_no];
 $cheque_no = $_POST['cheque_no'.$data->bill_no];
 $cheque_date = $_POST['cheque_date'.$data->bill_no];
 $jv_date = $_POST['receive_date'.$data->bill_no];
 
 if($_FILES['receive_att'.$data->bill_no]['tmp_name']!=''){
		               
						$file_name= $_FILES['receive_att'.$data->bill_no]['name'];
			
						$file_tmp= $_FILES['receive_att'.$data->bill_no]['tmp_name'];
			
						$ext=end(explode('.',$file_name));
			
						$path='../../../../resource/newerp/bill/';
						$rand = rand();
						$uploaded_file = $path.$rand.'.'.$ext;
						
						$file_name = $rand.'.'.$ext;
						unlink($uploaded_file);
						db_query('delete from document_upload where master_id="'.$rand.'" and tr_from="BillReceive"');
						move_uploaded_file($file_tmp, $uploaded_file);
						
						$file_insert = 'insert into document_upload (`master_id`,`tr_from`,`file_name`,`entry_at`,`entry_by`) value("'.$data->bill_no.'","BillReceive","'.$uploaded_file.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
						db_query($file_insert);
		
					}
 
        
        
        $tr_no = $data->bill_no;
        $customer_ledger = find_all_field('dealer_info','account_code','dealer_code="'.$data->customer.'"');
		$narration = 'Bill Receive #'.$customer_ledger->dealer_name_e.', Bill No.'.$data->manual_bill_no;
		
		
		
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $bank_ledger, $narration, $data->amount, '0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $customer_ledger->account_code, $narration,'0', $data->amount, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		
		
		
$update = 'update bill_info set status="BILL RECEIVED",bank="'.$bank_ledger.'",cheque_no="'.$cheque_no.'",checkq_date="'.$cheque_date.'",receive_date="'.$jv_date.'",bill_received_by="'.$_SESSION['user']['id'].'",bill_received_at="'.date('Y-m-d H:i:s').'" where bill_no="'.$data->bill_no.'"';
 db_query($update);
}
sec_journal_journal($jv_no,$jv_no,$tr_from);

		
}

}

if(isset($_POST['bill_create'])){

$crud      =new crud('bill_info');

$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['mon'] = date('m',strtotime($_POST['bill_date']));
$_POST['year'] = date('Y',strtotime($_POST['bill_date']));
$check = find_a_field('bill_info','bill_no','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'"');
if($check>0){
echo '<span style="color:red; font-weight:bold;">Already Bill Created For This Month!</span>';
}else{
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}
}




?>

<script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }



	function update_value(pi_id)



	{



var pi_id=pi_id; // Rent


var lc_no=(document.getElementById('lc_no').value);


var flag=(document.getElementById('flag_'+pi_id).value); 

var strURL="lc_update_ajax.php?pi_id="+pi_id+"&lc_no="+lc_no+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+pi_id).style.display='inline';

						document.getElementById('divi_'+pi_id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}


function sum_sum(id){
var tot_due_amt = (document.getElementById('tot_due_amt_'+id).value)*1;

document.getElementById('payment_amt_'+id).value = tot_due_amt;

}







</script>






<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


/*div.form-container_large input {*/
    /*width: 200px;*/
    /*height: 38px;*/
    /*border-radius: 0px !important;*/
/*}*/



</style>
















	<form action="bill_receive.php" method="post" name="codz" id="codz" enctype="multipart/form-data">
		<div class="form-container_large">

			<? if ($_SESSION['new_biller']==0) { ?>
				<div class="d-flex  justify-content-center">

					<div class="n-form1 fo-short pt-2">
						<div class="container">
							<div class="form-group row  m-0 mb-1 pl-3 pr-3">
								<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Client Name :</label>
								<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

									<select name="dealer_code" id="dealer_code" >
										<option></option>
										<?

										foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');

										?>
									</select>


								</div>
							</div>

							<div class="form-group row  m-0 mb-1 pl-3 pr-3">
								<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date :</label>
								<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
									<input type="text" name="f_date" id="f_date" value="<? if($_POST['f_date']!='') echo $_POST['f_date']; else echo date('Y-m-01');?>" />
								</div>
							</div>

							<div class="form-group row  m-0 mb-1 pl-3 pr-3">
								<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">-To- :</label>
								<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
									<input type="text" name="t_date" id="t_date" value="<? if($_POST['t_date']!='') echo $_POST['t_date']; else echo date('Y-m-d');?>" />
								</div>
							</div>

						</div>

						<div class="n-form-btn-class">

							<input type="submit" name="submit" id="submit" value="View Bill" class="btn1 btn1-submit-input" />


						</div>

					</div>

				</div>
			<? }?>


			<? if($_SESSION['new_biller']>0){ ?>
				<div class="box" style="width:100%;">

					<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="7%">DATE:</td>

									<td width="24%">

			<input style="width:220px; height:32px;"  name="bill_date" type="text" id="bill_date"  value="<?=($bill_date!='')?$bill_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">VENDOR :</td>
									<td width="21%">

									<input name="customer" type="hidden" id="customer"  readonly="" style="width:220px; height:32px;" value="<?=$_SESSION['new_biller'];?>"  required tabindex="105" />

									<? $dealer_data = find_all_field('dealer_info','','dealer_code='.$_SESSION['new_biller']);
					?>



									<input name="dealer_name" type="text" id="dealer_name"  readonly="" style="width:220px; height:32px;" value="<?=$dealer_data->dealer_name_e;?>"  required tabindex="105" />										</td>
									<td width="14%">Billing Amount :</td>
									<td width="20%">

									<table>
		  	<tr>
				<td><input name="amount" type="text" id="amount" required style="width:120px; height:32px; " autocomplete="off" value="0"/>				</td>
				<td></td>
			</tr>
		  </table>
									</td>
								  </tr>




								  <tr>
								    <td>Remarks:</td>
								    <td colspan="3">
									<input style="width:220px; height:32px;"  name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>"    />					</td>

									<td>Invoice No.</td>
									<td>
									<input style="width:220px; height:32px;"  name="manual_bill_no" type="text" id="manual_bill_no"  value="<?=$_POST['manual_bill_no']?>"    />					</td>
									<td>


							      </tr>

								  <tr>

									<td colspan="6" align="center">
									   <input type="submit" name="bill_create" id="bill_create" value="Create Bill" class="btn1 btn1-submit-input" />
									</td>

							      </tr>



								</table>-->

				</div>
			<? }?>




			<div class="container-fluid pt-5 p-0 ">

				<?
				if(isset($_POST['submit'])){
					?>
					<table class="table1  table-striped table-bordered table-hover table-sm">
						<thead class="thead1">


						<tr class="bgc-info">

							<th >Check </th>
							<th >Client</th>
							<th >Bill No</th>
							<th >Bill Date</th>
							<th >Amount</th>
							<th >Receive Date</th>
							<th >Bank</th>
							<th >Cheque No.</th>
							<th >Cheque Date</th>
							<th >Document</th>

						</tr>
						</thead>

						<tbody class="tbody1">


						<?


						if($_POST['f_date']!=''&&$_POST['t_date']!='') $con = ' and b.bill_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



						if($_POST['dealer_code']!='')
							$con .=" and b.customer=".$_POST['dealer_code'];



						$sql = "select b.bill_no,d.dealer_name_e, b.bill_date, b.manual_bill_no, b.amount, b.status from bill_info b, dealer_info d where b.customer=d.dealer_code and b.status='BILL SUBMITTED' ".$con."";



						$query = db_query($sql);



						while($data=mysqli_fetch_object($query)){$i++;


							?>





							<tr style="background-color: <?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>;">
								<td><input type="checkbox" name="check<?=$data->bill_no?>" id="check<?=$data->bill_no?>" value="checked" /></td>
								<td><?=$data->dealer_name_e?></td>
								<td><?=$data->manual_bill_no?></td>
								<td><?=$data->bill_date?></td>
								<td><?=$data->amount?></td>
								<td><input type="date" name="receive_date<?=$data->bill_no?>" id="receive_date<?=$data->bill_no?>" /></td>
								<td><select name="bank<?=$data->bill_no?>" id="bank<?=$data->bill_no?>"><option></option><? foreign_relation('accounts_ledger','ledger_id','ledger_name','','ledger_name like "%bank%"');?></select></td>
								<td><input type="text" name="cheque_no<?=$data->bill_no?>" id="cheque_no<?=$data->bill_no?>" /></td>
								<td><input type="date" name="cheque_date<?=$data->bill_no?>" id="cheque_date<?=$data->bill_no?>"/></td>
								<td><input type="file" name="receive_att<?=$data->bill_no?>" id="receive_att<?=$data->bill_no?>" /></td>
							</tr>

						<? }?>

						<tr>
							<td colspan="10" align="center"><div align="center"><input type="submit" name="received" id="received" value="Bill Receive" class="btn1 btn1-submit-input"/></div></td>
						</tr>

						</tbody>
					</table>
				<? }?>



				<?
				if($_SESSION['new_biller']>0){
					?>
					<div class="n-form-btn-class">
						<input name="confirmit" type="submit" class="btn1 btn1-submit-input" value="BILL SUBMIT" />
					</div>
				<? } ?>
			</div>



		</div>

	</form>








<?/*>
	<br>
<br>
<br>
<br>
<br>
<div class="form-container_large">

<form action="bill_receive.php" method="post" name="codz" id="codz" enctype="multipart/form-data">

<? if ($_SESSION['new_biller']==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>Client Name : </strong></td>



    <td >
		<select name="dealer_code" id="dealer_code" style="width:220px;">
      <option></option>
      <?

foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');

?>
    </select>

	</td>
	
	<td><input type="text" name="f_date" id="f_date" value="<? if($_POST['f_date']!='') echo $_POST['f_date']; else echo date('Y-m-01');?>" /></td>
	<td><input type="text" name="t_date" id="t_date" value="<? if($_POST['t_date']!='') echo $_POST['t_date']; else echo date('Y-m-d');?>" /></td>



    <td rowspan="2" ><strong>

      <input type="submit" name="submit" id="submit" value="View Bill" class="btn1 btn1-submit-input" />

    </strong></td>
    </tr>
  </table>

    </div>

<? }?>


<? if($_SESSION['new_biller']>0){ ?>


<div class="box" style="width:100%;">

								<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="7%">DATE:</td>

									<td width="24%">
									
			<input style="width:220px; height:32px;"  name="bill_date" type="text" id="bill_date"  value="<?=($bill_date!='')?$bill_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">VENDOR :</td>
									<td width="21%">
									
									<input name="customer" type="hidden" id="customer"  readonly="" style="width:220px; height:32px;" value="<?=$_SESSION['new_biller'];?>"  required tabindex="105" />
									
									<? $dealer_data = find_all_field('dealer_info','','dealer_code='.$_SESSION['new_biller']); 
									?>
									
										
									
									<input name="dealer_name" type="text" id="dealer_name"  readonly="" style="width:220px; height:32px;" value="<?=$dealer_data->dealer_name_e;?>"  required tabindex="105" />										</td>
									<td width="14%">Billing Amount :</td>
									<td width="20%">
									
									<table>
		  	<tr>
				<td><input name="amount" type="text" id="amount" required style="width:120px; height:32px; " autocomplete="off" value="0"/>				</td>
				<td></td>
			</tr>
		  </table>
									</td>
								  </tr>
								  
								  
  
								  
								  <tr>
								    <td>Remarks:</td>
								    <td colspan="3">
									<input style="width:220px; height:32px;"  name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>"    />					</td>                               
									
									<td>Invoice No.</td>
									<td>
									<input style="width:220px; height:32px;"  name="manual_bill_no" type="text" id="manual_bill_no"  value="<?=$_POST['manual_bill_no']?>"    />					</td>                               
									<td>
									
								
							      </tr>
								  
								  <tr>
								    
									<td colspan="6" align="center">
									   <input type="submit" name="bill_create" id="bill_create" value="Create Bill" class="btn1 btn1-submit-input" />
									</td>
								
							      </tr>
								  
								  
								  
								</table>-->

    </div>
	
	<? }?>



<?
 if(isset($_POST['submit'])){
?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="5%">Check </th>
	<th width="12%">Client</th>
	<th width="12%">Bill No</th>
    <th width="8%">Bill Date</th>
    <th width="10%">Amount</th>
	<th width="10%">Receive Date</th>
    <th width="12%">Bank</th>
	<th width="12%">Cheque No.</th>
	<th width="8%">Cheque Date</th>
	<th width="15%">Document</th>
  </tr>
  

  <?
  
  
  if($_POST['f_date']!=''&&$_POST['t_date']!='') $con = ' and b.bill_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
  
  
	
 if($_POST['dealer_code']!='')
  $con .=" and b.customer=".$_POST['dealer_code'];
  
 
   
    $sql = "select b.bill_no,d.dealer_name_e, b.bill_date, b.manual_bill_no, b.amount, b.status from bill_info b, dealer_info d where b.customer=d.dealer_code and b.status='BILL SUBMITTED' ".$con."";



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){$i++;


  ?>





  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><input type="checkbox" name="check<?=$data->bill_no?>" id="check<?=$data->bill_no?>" value="checked" style="width:50px;" /></td>
	<td><?=$data->dealer_name_e?></td>
    <td><?=$data->manual_bill_no?></td>
	<td><?=$data->bill_date?></td>
	<td><?=$data->amount?></td>
	<td><input type="date" name="receive_date<?=$data->bill_no?>" id="receive_date<?=$data->bill_no?>" style="width:90px;" /></td>
	<td><select name="bank<?=$data->bill_no?>" id="bank<?=$data->bill_no?>"><option></option><? foreign_relation('accounts_ledger','ledger_id','ledger_name','','ledger_name like "%bank%"');?></select></td>
	<td><input type="text" name="cheque_no<?=$data->bill_no?>" id="cheque_no<?=$data->bill_no?>" /></td>
	<td><input type="date" name="cheque_date<?=$data->bill_no?>" id="cheque_date<?=$data->bill_no?>" style="width:90px;" /></td>
	<td><input type="file" name="receive_att<?=$data->bill_no?>" id="receive_att<?=$data->bill_no?>" style="width:100px;" /></td>
  </tr>

  <? }?>
  
  <tr>
    <td colspan="10" align="center"><div align="center"><input type="submit" name="received" id="received" value="Bill Receive" class="btn1 btn1-submit-input"/></div></td>
  </tr>
</table>

<? } ?>

</div>
<br /><br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<?
if($_SESSION['new_biller']>0){
?>
<input name="confirmit" type="submit" class="btn1 btn1-submit-input" value="BILL SUBMIT" />
<? } ?>
</td>

</tr>



</table>









<p>&nbsp;</p>

</form>

</div>





	<*/?>





<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>