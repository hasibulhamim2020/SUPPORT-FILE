<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$c_id = $_SESSION['proj_id'];

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


$title='Sales Invoice Wise Receipt Voucher';

do_calander("#cheque_date");
 //create_combobox('do_no');

do_calander('#invoice_date');
//do_calander('#ldbc_no_date');
do_calander('#realization_date');

 $data_found = $_POST['account_code'];

if ($data_found==0) {
 create_combobox('account_code');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']) && $_SESSION['csrf_token']===$_POST['csrf_token'])
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
{


		$receipt_date=$_POST['invoice_date'];
		$sub_ledger_id =$_POST['dr_ledger_id'];
		$dr_ledger_id=find_a_field('general_sub_ledger','ledger_id','sub_ledger_id='.$sub_ledger_id);
		
		
 if($_POST['account_code']!='')
  $account_code_con=" and d.sub_ledger_id=".$_POST['account_code'];
  
 if($_POST['do_no']!='')
  $do_no_con=" and j.tr_id=".$_POST['do_no'];
  


		$group_for= $_SESSION['user']['group'];

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		
		$receipt_no = next_transection_no($group_for,$receipt_date,'receipt_from_customer','receipt_no');


		 $sql = "SELECT d.dealer_code, d.account_code, d.dealer_name_e, j.jv_no, j.tr_no, j.jv_date, sum(j.dr_amt) as invoice_amt, j.tr_id FROM journal j, dealer_info d WHERE j.ledger_id=d.account_code and j.tr_from in ('Sales') ".$account_code_con.$do_no_con."  group by j.tr_no";

		$query = db_query($sql);

	


		while($data=mysqli_fetch_object($query))

		{
	

			if($_POST['receipt_amt_'.$data->tr_no]>0)

			{
			
	

				$receipt_amt=$_POST['receipt_amt_'.$data->tr_no];
				$account_code=$_POST['account_code_'.$data->tr_no];
				$sub_ledger_code = $_POST['sub_ledger_code_'.$data->tr_no];
				$tr_no=$_POST['tr_no_'.$data->tr_no];



   $so_invoice = 'INSERT INTO receipt_from_customer (receipt_no, receipt_date, do_no, chalan_no, dealer_code, ledger_id, sub_ledger_code,dr_ledger_id,sub_ledger_id,receipt_amt, status, entry_at, entry_by, chalan_date, sales_jv_no)
  
  VALUES("'.$receipt_no.'", "'.$receipt_date.'", "'.$data->tr_id.'", "'.$tr_no.'", "'.$data->dealer_code.'", "'.$account_code.'","'.$sub_ledger_code.'","'.$dr_ledger_id.'","'.$sub_ledger_id.'","'.$receipt_amt.'", "COMPLETE", "'.$entry_at.'", "'.$entry_by.'", "'.$data->jv_date.'", "'.$data->jv_no.'")';

db_query($so_invoice);


}

}


if($receipt_no>0 )
{
auto_insert_sales_receipt_secoundary($receipt_no);

}

$receipt_no=0;

?>

<script language="javascript">
//window.location.href = "invoice_wise_receipt_update.php";
</script>

<?	

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

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

document.getElementById('receipt_amt_'+id).value = tot_due_amt;

}

function checkAmt(trNo){
var amount =$("#tot_due_amt_"+trNo).val()*1;
console.log(amount);
var inputAmount=$("#receipt_amt_"+trNo).val()*1;
console.log(inputAmount);
if(inputAmount>amount){
alert("Amount Overflow");
$("#receipt_amt_"+trNo).val(amount);
}
}







</script>






<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}



.custom-combobox-toggle
 {
    position: absolute;
    height: calc(1.5em + .75rem + 1.5px);
    padding: 1.1rem .2rem;
    font-size: 1rem;
}



</style>






	<!--DO create 2 form with table-->
	<div class="form-container_large">
	
<form action="" method="post" name="codz" id="codz">

<? if ($data_found==0) { ?>
		<div class="container-fluid bg-form-titel">
            <div class="row">
                
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <div class="form-group row m-0">
                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                           <select name="account_code" id="account_code">
								  <option></option>
								  <?
							
							foreign_relation('dealer_info','sub_ledger_id','dealer_name_e',$_POST['account_code'],'1');
							
							?>
								</select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    
                    <input type="submit" name="submit" id="submit"  class="btn1 btn1-submit-input"value="View Invoice"/>
                </div>

            </div>
        </div>
		<? } ?>
	
	
	
		<? if(isset($_POST['submit'])){ ?>
			<!--        top form start hear-->
			<div class="container-fluid bg-form-titel">
				<div class="row">
					<!--left form-->
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<input name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />
								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job No</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="do_no" id="do_no">
	
										<option></option>
									
											<? foreign_relation('sale_do_master m, dealer_info d','m.do_no,m.dealer_code, d.dealer_code, d.sub_ledger_id','m.job_no',$_POST['do_no'],'m.dealer_code=d.dealer_code and d.sub_ledger_id="'.$_POST['account_code'].'" and m.status!="MANUAL"'); ?>
									
										</select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cheque No.</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input  name="cheque_no" type="text" id="cheque_no"  value="<?=$_POST['cheque_no']?>"    />

								</div>
							</div>

						</div>



					</div>

					<!--Right form-->
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Rec From</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<input name="account_code" type="hidden" id="account_code"  readonly="" value="<?=$_POST['account_code'];?>"  required tabindex="105" />
									
									<? $dealer_data = find_all_field('dealer_info','','sub_ledger_id='.$_POST['account_code']); 
									$dealer_closing = find_a_field_sql("select sum(dr_amt-cr_amt) from journal where ledger_id = '".$dealer_data->account_code."' and sub_ledger=".$dealer_data->sub_ledger_id."");
	
									$closing_balance=$dealer_closing;
									?>
																		
         <input name="received_from" type="text" id="received_from"  readonly=""  value="<?=$dealer_data->dealer_name_e;?>"  required tabindex="105" />
								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PMT Method</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="payment_method" id="payment_method" required onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter',        this.value,  document.getElementById('payment_method').value);">
									<option></option>
	
								
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
									</select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cheque Date</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input  name="cheque_date" type="text" id="cheque_date"  value="<?=$_POST['cheque_date']?>"    />

								</div>
							</div>

						</div>



					</div>
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cus Balance</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<input name="custemer_balance" type="text" id="custemer_balance" required readonly="" autocomplete="off"  
				 value="<? if ($dealer_closing>0) { echo  number_format($closing_balance,2). ""; } else { echo number_format($closing_balance*(-1),2). ""; }?>"/>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cash/Bank</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="dr_ledger_id" id="dr_ledger_id" required="required">
									  <option></option>
									  <?php /*?><? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['dr_ledger_id'],'ledger_group_id in (10201,10202)');?><?php */?>
	<? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$receive_acc_head,' type in ("Cash In Hand","Cash at Bank") order by sub_ledger_id');?>

									</select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Name of Bank</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input  name="of_bank" type="text" id="of_bank"  value="<?=$_POST['of_bank']?>"    />

								</div>
							</div>

						</div>



					</div>


				</div>

				

			</div>
			
			<? } ?>

		
			<? if(isset($_POST['submit'])){ ?>
			
			<div class="container-fluid pt-5 p-0 ">

				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>JOb No </th>

						<th>Invoice No </th>
					
						<th>Invoice Date </th>
						<th>Invoice Amt </th>
						<th>Total Pay  Amt </th>
						<th>Due Amt </th>
						<th>Receipt Amt </th>
						<th>Action</th>
					</tr>
					</thead>

					<tbody class="tbody1">
					
					<?
  
  
					  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
					  
					  
						
					 if($_POST['account_code']!='')
					  $account_code_con=" and d.sub_ledger_id=".$_POST['account_code'];
					  
					 if($_POST['do_no']!='')
					  $do_no_con=" and j.tr_id=".$_POST['do_no'];
					  
					
					
					
					
					  
					 $sql = "select sum(cr_amt) as receipt_amt, ledger_id,sub_ledger, tr_no  from journal where tr_from='Receipt' and cr_amt>0 group by tr_no ";
					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){
					$receipt_amt[$data->ledger_id][$data->sub_ledger][$data->tr_no]=$data->receipt_amt;
					
					}
					  
					  
					  
					 $sql = "select sum(cr_amt) as return_amt, ledger_id,sub_ledger, tr_no  from journal where tr_from='Sales Return'  group by tr_no";
					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){
					$return_amt[$data->ledger_id][$data->sub_ledger][$data->tr_no]=$data->return_amt;
					
					}
					 
					  
					
					
					   
						 $sql = "SELECT d.account_code,d.sub_ledger_id,d.dealer_name_e, j.tr_no, j.jv_date, sum(j.dr_amt) as invoice_amt, j.tr_id FROM journal j, dealer_info d WHERE j.sub_ledger=d.sub_ledger_id and j.tr_from in ('Sales')  ".$account_code_con.$do_no_con."  group by j.tr_no";
					
					
					
					  $query = db_query($sql);
					
					
					
					  while($data=mysqli_fetch_object($query)){$i++;
					
					
					  ?>
					
					
					
					<?
					
					echo $receipt_amt[$data->account_code][$data->sub_ledger_id][$data->tr_no];
					
					 if ($due_amt=$data->invoice_amt-$receipt_amt[$data->account_code][$data->sub_ledger_id][$data->tr_no]+$return_amt[$data->account_code][$data->sub_ledger_id][$data->tr_no]>0) {?>
					
					  <tr>
						<td><span class="style13" >
						  <?=find_a_field('sale_do_master','job_no','do_no='.$data->tr_id);?>
						</span></td>
					
						<?php /*?><td><a href="../../warehouse_mod/wo/sales_invoice_print_view.php?v_no='<?=url_encode($data->tr_no);?>'" target="_blank"><span class="style13" >
						  <?=$data->tr_no?><?php */?>
						  
						  <td><a href="../../warehouse_mod/wo/sales_invoice_print_view.php?c='<?=url_encode($c_id);?>&v=<?=url_encode($data->tr_no);?>'" target="_blank"><span class="style13" >
						  <?=$data->tr_no?>
						  
						  
						</span></a><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=rawurlencode(url_encode($data->do_no))?>"></a></td>
					
						<td><?php echo $data->jv_date;?></td>
						<td><strong>
						  <?=number_format($data->invoice_amt,2);?>
						</strong></td>
						<td><strong>
						  <?=number_format($receipt_amt[$data->account_code][$data->sub_ledger_id][$data->tr_no]+$return_amt[$data->account_code][$data->sub_ledger_id][$data->tr_no],2);?>
						</strong></td>
						<td><strong><?  $due_amt=$data->invoice_amt-$receipt_amt[$data->account_code][$data->sub_ledger_id][$data->tr_no]+$return_amt[$data->account_code][$data->sub_ledger_id][$data->tr_no]; echo number_format($due_amt,2);?></strong>
						<input name="tot_due_amt_<?=$data->tr_no?>" id="tot_due_amt_<?=$data->tr_no?>" type="hidden"  value="<?=$due_amt?>" />
						</td>
						<td>
						<input name="account_code_<?=$data->tr_no?>" id="account_code_<?=$data->tr_no?>" type="hidden"  value="<?=$data->account_code?>" style="width:80px;" />
						<input name="sub_ledger_code_<?=$data->tr_no?>" id="sub_ledger_code_<?=$data->tr_no?>" type="hidden"  value="<?=$data->sub_ledger_id?>" style="width:80px;" />
					 <input name="tr_no_<?=$data->tr_no?>" id="tr_no_<?=$data->tr_no?>" type="hidden"  value="<?=$data->tr_no?>"  />
					 
					 <input onkeyup="checkAmt(<?=$data->tr_no?>)" name="receipt_amt_<?=$data->tr_no?>" id="receipt_amt_<?=$data->tr_no?>" type="text"  value=""  />	</td>
						<td align="center"><center><button onclick="sum_sum(<?=$data->tr_no ?>)" type="button" class="btn1 btn1-bg-submit" >Full</button></center></td>
					  </tr>
					
					  <? } }?>
					
					</tbody>
				</table>

			</div>
			
			
	

		<!--button design start-->
		
			<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input name="confirmit" type="submit" class="btn1 btn1-submit-input" value="SAVE & NEW"  />
					<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
				</div>

			</div>
		
		
		<? } ?>
			</form>
	</div>






<br /><br />




<?


require_once SERVER_CORE."routing/layout.bottom.php";

?>