<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Vendor VDS Payment';



do_calander('#fdate');



do_calander('#tdate');



$table = 'purchase_receive';



$unique = 'grn_no';



$status = 'CHECKED';



$target_url = '../vendor_invoice/new_bill_create.php';





if($_REQUEST[$unique]>0)



{



$_SESSION[$unique] = $_REQUEST[$unique];



header('location:'.$target_url);



}





if(isset($_POST['confirm_payment'])){

 

$doc_vendor = 3021100143;

$tds_payable = 3021000132;

$vds_ledger = 3021000133;

$advance_to_vendor_dr = 1022400004;

$cheq_no = $_POST['cheq_no'];

$cheq_date = $_POST['cheq_date'];

$credit_sub_ledger = end(explode("#",$_POST['receive_sub_ledger']));

$credit_ledger = find_a_field('general_sub_ledger','ledger_id','sub_ledger_id="'.$credit_sub_ledger.'"');

$tr_from = 'is_vds_payment';

$entry_by = $_SESSION['user']['id'];

$entry_at = date('Y-m-d H:i:s');

$jv_no=next_journal_sec_voucher_id('',$tr_from,$_SESSION['user']['group']);			

$proj_id = 'MEP';



$jv_date =  $_POST['cheq_date'];



$res='select sum(j.cr_amt-j.dr_amt) as vds_amt,j.tr_no as system_invoice_no,j.sub_ledger,s.sub_ledger_name,v.invoice_no,invoice_date from journal j left join general_sub_ledger s on s.sub_ledger_id=j.sub_ledger left join is_invoice_master v on v.system_invoice_no=j.tr_no where j.ledger_id="'.$vds_ledger.'" and j.jv_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" and j.tr_from in ("is_invoice_receive") group by j.tr_no,j.sub_ledger';



$query = db_query($res);

while($data=mysqli_fetch_object($query)){



$checked = $_POST['system_invoice_no'.$data->system_invoice_no];

if($checked){

$vds_amt = $_POST['actual_payable'.$data->system_invoice_no];

$narration = 'Inter Sale VDS Payment. Invoice No.'.$data->invoice_no;

$tr_no = $data->system_invoice_no;



$group = $data->group_for;



if($vds_amt>0){

$total_vds +=$vds_amt;

$narration = "Inter Sale VDS Payable. Invoice No.".$data->invoice_no."";

add_to_sec_journal($proj_id, $jv_no, $jv_date, $vds_ledger, $narration, $vds_amt, 0, $tr_from, $tr_no,$data->sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);

//add_to_journal($proj_id, $jv_no, $jv_date, $vds_ledger, $narration, $vds_amt, 0, $tr_from, $tr_no,$data->sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);

}

$all_invoice .= $data->invoice_no.', ';

//$all_tr_no .= $data->system_invoice_no.', ';

}



}



if(($total_vds>0) && ($credit_ledger>0) && ($credit_sub_ledger>0)){

$narration = "Cheque No.".$cheq_no.", Cheque Date ".$cheq_date." Invoice No.".$all_invoice."";

add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, 0, $total_vds, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);

//add_to_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, 0, $total_vds, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);

}else{

	echo '<script>alert("Please Selecr Cr. Ledger Properly...")</script>';
	
	$delete_query ="delete from secondary_journal where tr_from='is_vds_payment' and jv_no =".$jv_no." ";
	db_query($delete_query);

}

 sec_journal_journal2($jv_no,$jv_no,$tr_from);


}







?>



<script language="javascript">



function custom(theUrl)



{



	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);

	//window.location.href = "<?=$target_url?>?<?=$unique?>="+theUrl;



}



</script>







<div style="text-align:center;"><?=$_SESSION['inv_msg']; unset($_SESSION['inv_msg']);?></div>

<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">

            

        <div class="container-fluid bg-form-titel">

            <div class="row">
			
			<div class="form-group row m-0">

                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company: </label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                            <select type="text" name="group_for" id="group_for" style="width:;">
							<option selected="selected"><?=$_POST['group_for'];?></option>
							
							<? foreign_relation('user_group','id','company_short_code',$group_for,'1 order by id')?>
							
							
							</select>

							

                        </div>

                    </div>

                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

                

                    <div class="form-group row m-0">

                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Invoice Date From: </label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                            <input type="text" name="fdate" id="fdate" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" />

							

                        </div>

                    </div>

					</div>

					

					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

                

                    <div class="form-group row m-0">

                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To: </label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                            <input type="text" name="tdate" id="tdate" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" />

                        </div>

                    </div>

					</div>

                



                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

                   

                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>

                </div>



            </div>

        </div>











        <div class="container-fluid pt-5 p-0 ">



            <?



            if(isset($_POST['submitit'])){



            

                

				

             



            //echo link_report($res,'po_print_view.php');

            ?>





                <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

					<tr class="bgc-info">

					 <th>Invoice Count<input type="text" id="invoice_count" name="invoice_count" readonly /></th>

					 

					 <th>Total VDS Amount<input type="text" id="total_vds_amount" name="total_vds_amount" readonly /></th>

					 <th colspan="3">Cash/Bank<input type="text" id="receive_sub_ledger" name="receive_sub_ledger" list="cash_bank" required/>

					 <datalist id="cash_bank">

							  <? foreign_relation('general_sub_ledger','concat(sub_ledger_name,"#",sub_ledger_id)','""',$receive_ledger,'tr_from="custom" and type in("Cash at Bank","Cash In Hand")')?>

							</datalist>					 </th>

					 

					 <th>Ref. No.<input type="text" id="cheq_no" name="cheq_no"/></th>

					 <th>Payment Date<input type="date" id="cheq_date" name="cheq_date" required/></th>

					 

					</tr>

                    <tr class="bgc-info">

                        <th>SL</th>

						<th>System Invoice No.</th>

                        <th>Invoice No.</th>

						<th>Invoice Date</th>

						<th>Vendor Name</th>

                        <th>VDS Amount </th>

						<th>Payable</th>

						

                    </tr>

                    </thead>



                    <tbody class="tbody1">



                    <?
					
					if($_POST['group_for']!='') {
					
					$comcon.=' and j.group_for='.$_POST['group_for'].'';
					
					}

					$doc_vendor = 3021100143;

					$advance_to_vendor_dr = 1022400004;

					   

				$vds_ledger = 3021000133;

$res='select sum(j.cr_amt-j.dr_amt) as vds_amt,j.tr_no,j.sub_ledger,s.sub_ledger_name,v.invoice_no,invoice_date,s.sub_ledger_id from journal j left join general_sub_ledger s on s.sub_ledger_id=j.sub_ledger left join is_invoice_master v on v.system_invoice_no=j.tr_no where j.ledger_id="'.$vds_ledger.'" and j.jv_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" and j.tr_from in ("is_invoice_receive") and j.checked="NO" '.$comcon.' group by j.tr_no,j.sub_ledger';



            $query = db_query($res);

                    while($row = mysqli_fetch_object($query)){

					

					

				    $paid_amount = find_a_field('journal','sum(dr_amt)','ledger_id="'.$vds_ledger.'" and sub_ledger="'.$row->sub_ledger_id.'" and tr_no="'.$row->tr_no.'" and tr_from="is_vds_payment"');
					
					
					 $unpaid_amount = number_format(($row->vds_amt-$paid_amount),2,'.','');

					 if($unpaid_amount>0) {

                        ?>



                        <tr>

<td>

<input type="hidden" name="sub_ledger_id" id="sub_ledger_id" value="<?=$row->sub_ledger_id?>" />

<input type="checkbox" name="system_invoice_no<?=$row->tr_no?>" class="form-control" id="system_invoice_no<?=$row->tr_no?>" onclick="payment_cal(<?=$row->tr_no?>)" /></td>

							<td><?=$row->tr_no?></td>

							<td><?=$row->invoice_no?></td>

							<td><?=$row->invoice_date?></td>

                            <td><?=$row->sub_ledger_name?></td>

                            <td><?=number_format($unpaid_amount,2)?></td>

							

                          <td><input type="text" name="actual_payable<?=$row->tr_no?>" id="actual_payable<?=$row->tr_no?>" value="<?=$unpaid_amount?>" /></td>



                        </tr>



                    <? } } ?>

					

					<tr>

					  

					  <td colspan="11"><input type="submit" name="confirm_payment" id="confirm_payment" value="Confirm Payment" /></td>

					</tr>

                    </tbody>

                </table>



                <? } ?>





        </div>

    </form>

</div>





<script>



function advance_cal(invoice_no){

	

	 var actual_amt = document.getElementById("net_amount"+invoice_no).value*1;

	 //alert(actual_amt);

	 var advance_amt = document.getElementById("advance_amt"+invoice_no).value*1;

	 var actual = actual_amt-advance_amt;

	 document.getElementById('actual_payable'+invoice_no).value = actual;

	}



 function payment_cal(invoice_no){



/*alert('test');

$.ajax({

url:"payment_ajax.php",

method:"POST",

dataType:"JSON",

data:{ 

       year:year,

       mon:mon,

	 },

success: function(result, msg){

var res = result;

//setTimeout(view_data, 5000);

//$("#presentStock").html(res[0]);

$("#invoice_count").val('10');*/

	 

	 

	 

	 

	

 var checked_invoice = $("#system_invoice_no"+invoice_no);

 //alert(invoice_no);

 if(document.getElementById("system_invoice_no"+invoice_no).checked == true){

 

  document.getElementById('invoice_count').value  = $('input:checkbox:checked').length;

  var vds_amount = document.getElementById("actual_payable"+invoice_no).value*1;

  var pre_tds = document.getElementById("total_vds_amount").value*1;

  var grand_tds = vds_amount+pre_tds;

  var grand_total_payable = grand_tds;

  document.getElementById('total_vds_amount').value = grand_total_payable;

  

  }else{

  

  document.getElementById('invoice_count').value  = $('input:checkbox:checked').length;

  var vds_amount = document.getElementById("actual_payable"+invoice_no).value*1;

  var pre_tds = document.getElementById("total_vds_amount").value*1;

  var grand_tds = pre_tds-vds_amount;

  var grand_total_payable = grand_tds;

  document.getElementById('total_vds_amount').value = grand_total_payable;

  

  }

 

 

 }

</script>



<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>