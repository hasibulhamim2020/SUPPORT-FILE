<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";



$title='Bill Create';


  create_combobox('do_no');

do_calander('#invoice_date');
//do_calander('#ldbc_no_date');
do_calander('#bill_date');

if($_POST['dealer_code']>0){
$_SESSION['new_biller'] = $_POST['dealer_code'];
}

if($_REQUEST['new']>0){
unset($_SESSION['new_biller']);
}

if ($data_found==0) {
 create_combobox('dealer_code');
  }





if(isset($_REQUEST['confirmit']))

{
$jv_no=next_journal_sec_voucher_id();
$proj_id = 'clouderp'; 
$cc_code = '1';
$group_for =  $_SESSION['user']['group'];
$config_ledger = find_all_field('config_group_class','','group_for="'.$group_for.'"');
$tr_from = 'BillSubmit';

$sql = "select b.bill_no, d.dealer_name_e, b.bill_date, b.manual_bill_no, b.amount, b.status,b.customer from bill_info b, dealer_info d where b.customer=d.dealer_code and b.status='PENDING' and b.customer='".$_SESSION['new_biller']."'";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

if($_POST['check'.$data->bill_no]=='checked'){
 
 
        
        $jv_date = $data->bill_date;
        $tr_no = $data->bill_no;
        $customer_ledger = find_all_field('dealer_info','account_code','dealer_code="'.$data->customer.'"');
		$narration = 'Bill For #'.$customer_ledger->dealer_name_e.', Bill No.'.$data->manual_bill_no;
		
		
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $customer_ledger->account_code, $narration, $data->amount,'0', $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->service_charge, $narration, '0', $data->amount, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		
		
		
 $update = 'update bill_info set status="BILL SUBMITTED" where bill_no="'.$data->bill_no.'"';
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
$check = find_a_field('bill_info','bill_no','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and customer="'.$_POST['customer'].'"');
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






<!--<style>


div.form-container_large input {
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}



</style>-->






<!--Accout verify back-->
<form action="create_bill.php" method="post" name="codz" id="codz">
	<div class="form-container_large">
	
		<? if ($_SESSION['new_biller']==0) { ?>
		<div class="container-fluid bg-form-titel">
			<div class="row">
				<!--left form-->
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="container n-form2">

						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Client Name :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<select name="dealer_code" id="dealer_code" >
										  <option></option>
										  <?
									
									foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');
									
									?>
										</select>
							</div>
						</div>

					</div>
				</div>

				<!--Right form-->
				<!--<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">


						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan Depot </label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								input
							</div>
						</div>






					</div>
				</div>-->

			</div>


			<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input type="submit" name="submit" id="submit" value="View Invoice" class="btn1 btn1-submit-input" />
				</div>

			</div>




		</div>
		<? }?>
		
		<? if($_SESSION['new_biller']>0){ ?>
		<div class="container-fluid bg-form-titel">
			<div class="row">
				<!--left form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">

						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">DATE :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input  name="bill_date" type="text" id="bill_date"  value="<?=($bill_date!='')?$bill_date:date('Y-m-d')?>"   required />	
							</div>
						</div>
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">VENDOR :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="customer" type="hidden" id="customer"  readonly=""  value="<?=$_SESSION['new_biller'];?>"  required tabindex="105" />
									
									<? $dealer_data = find_all_field('dealer_info','','dealer_code='.$_SESSION['new_biller']); 
									?>
									
									<input name="dealer_name" type="text" id="dealer_name"  readonly=""  value="<?=$dealer_data->dealer_name_e;?>"  required tabindex="105" />
							</div>
						</div>
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Remarks :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input  name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>"    />
							</div>
						</div>




					</div>
				</div>

				<!--Right form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">


						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Billing Amount :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="amount" type="text" id="amount" required value="<?=$dealer_data->service_charge?>" autocomplete="off" value="0"/>
							</div>
						</div>
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice No :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input  name="manual_bill_no" type="text" id="manual_bill_no"  value="<?=$_POST['manual_bill_no']?>"    />
							</div>
						</div>






					</div>
				</div>

			</div>


			<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input type="submit" name="bill_create" id="bill_create" value="Create Bill" class="btn1 btn1-submit-input" />
				</div>

			</div>




		</div>
		<? }?>






		<div class="container-fluid pt-5 p-0 ">


			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">


				<tr class="bgc-info">

					<th>CHECK</th>
					<th>BILL NO</th>
					<th>BILL DATE</th>
					<th>AMOUNT</th>
					<th>BILL SUBMIT</th>
					<th>SHOW INVOICE</th>

				</tr>
				</thead>

				<tbody class="tbody1">
				<?
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
 if($_POST['dealer_code']!='')
  $dealer_code_con=" and d.ledger_id=".$_POST['dealer_code'];
  
 if($_POST['do_no']!='')
  $do_no_con=" and j.tr_id=".$_POST['do_no'];
  

    $sql = "select b.bill_no,d.dealer_name_e, b.bill_date, b.manual_bill_no, b.amount, b.status from bill_info b, dealer_info d where b.customer=d.dealer_code and b.status='PENDING' and b.customer='".$_SESSION['new_biller']."'";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>
				<tr <?=($i%2)?'#E8F3FF':'#fff';?>>
					<td><input type="checkbox" name="check<?=$data->bill_no?>" id="check<?=$data->bill_no?>" value="checked" /></td>
					<td><?=$data->manual_bill_no?></td>
					<td><?=$data->bill_date?></td>
					<td><?=$data->amount?></td>
					<td><?=$data->status?></td>
					<td><a href="invoice_print_view.php?bill_no=<?=$data->bill_no?>" target="_blank">View Invoice</a></td>
				</tr>
				<? }?>
				
				<tr>

<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>

<td align="center">
<?
if($_SESSION['new_biller']>0){
?>
<input name="confirmit" type="submit" class="btn1 btn1-submit-input" value="BILL SUBMIT" />
<? } ?>
</td>
<td align="center">&nbsp;</td>
<td align="center">&nbsp;</td>

</tr>

				</tbody>
			</table>





		</div>



	</div>

</form>





<?php /*?><div class="form-container_large">

<form action="create_bill.php" method="post" name="codz" id="codz">

<? if ($_SESSION['new_biller']==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>Client Name : </strong></td>



    <td ><select name="dealer_code" id="dealer_code" style="width:220px;">
      <option></option>
      <?

foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');

?>
    </select></td>



    <td rowspan="4" ><strong>

      <input type="submit" name="submit" id="submit" value="View Invoice" class="btn1 btn1-submit-input" />

    </strong></td>
    </tr>
								  
								  
  
								  
								  
								  
								  
								  
								</table>

    </div>

<? }?>


<? if($_SESSION['new_biller']>0){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

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
				<td><input name="amount" type="text" id="amount" required style="width:120px; height:32px;" value="<?=$dealer_data->service_charge?>" autocomplete="off" value="0"/>				</td>
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
								  
								  
								  
								</table>

    </div>
	
	<? }?>





<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="12%">Check </th>
	<th width="12%">Bill No </th>
    <th width="15%">Bill Date </th>
    <th width="19%">Amount </th>
    <th width="12%">Bill Submit </th>
	<th width="12%">Show Invoice</th>
  </tr>
  

  <?
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
 if($_POST['dealer_code']!='')
  $dealer_code_con=" and d.ledger_id=".$_POST['dealer_code'];
  
 if($_POST['do_no']!='')
  $do_no_con=" and j.tr_id=".$_POST['do_no'];
  

    $sql = "select b.bill_no,d.dealer_name_e, b.bill_date, b.manual_bill_no, b.amount, b.status from bill_info b, dealer_info d where b.customer=d.dealer_code and b.status='PENDING' and b.customer='".$_SESSION['new_biller']."'";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>





  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><input type="checkbox" name="check<?=$data->bill_no?>" id="check<?=$data->bill_no?>" value="checked" /></td>
    <td><?=$data->manual_bill_no?></td>
	<td><?=$data->bill_date?></td>
	<td><?=$data->amount?></td>
	<td><?=$data->status?></td>
	<td><a href="invoice_print_view.php?bill_no=<?=$data->bill_no?>" target="_blank">View Invoice</a></td>
  </tr>

  <? }?>
</table>



</div>
<br /><br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
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

</div><?php */?>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>