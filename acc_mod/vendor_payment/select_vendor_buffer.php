<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Material Vendor Payment';

do_calander('#fdate');

do_calander('#tdate');

do_calander('#cheq_date');

$table = 'purchase_receive';

$unique = 'grn_no';

$status = 'CHECKED';

$target_url = '../vendor_invoice/new_bill_create.php';


if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}

$doc_vendor = 3022600017;
$tds_payable = 3021000132;
$vds_payable = 3021000133;
$advance_to_vendor_dr = 1022400004;
if(isset($_POST['confirm_payment'])){
 
 
$tr_from = 'Vendor_payment';
$entry_by = $_SESSION['user']['id'];
$entry_at = date('Y-m-d H:i:s');
$jv_no=next_journal_sec_voucher_id('',$tr_from,$_SESSION['user']['group']);		
$proj_id = 'MEP';

$jv_date = $_POST['cheq_date'];


$vendor = explode("#",$_POST['vendor_id']);
$con = 'and m.vendor_id="'.$vendor[1].'"';

$res='select m.invoice_no,m.system_invoice_no,m.invoice_date,m.po_no,m.grn_no,sum(d.amount) as amount,m.tds_percent,v.vendor_name,v.sub_ledger_id,v.sub_ledger_id,m.entry_at,u.fname,m.group_for,v.ledger_id as accounts_payable from vendor_invoice_master m, vendor_invoice_details d, vendor v, user_activity_management u where m.system_invoice_no=d.system_invoice_no and m.vendor_id=v.vendor_id and m.entry_by=u.user_id and m.status="PENDING" and m.po_type in (0,1) '.$con.' group by m.system_invoice_no';

$query = db_query($res);
while($data=mysqli_fetch_object($query)){

$checked = $_POST['system_invoice_no'.$data->system_invoice_no];
if($checked){

$total_amount = $_POST['actual_payable'.$data->system_invoice_no];
$advance_amt = $_POST['advance_deductable'.$data->system_invoice_no];
$net_payable = $_POST['net_payable']; 
$cheq_no = $_POST['cheq_no'];
$cheq_date = $_POST['cheq_date'];
$invoice_value = $data->amount;
$credit_sub_ledger = end(explode("#",$_POST['receive_sub_ledger']));
$credit_ledger = find_a_field('general_sub_ledger','ledger_id','sub_ledger_id="'.$credit_sub_ledger.'"');
$group = $data->group_for;

/*$tds_amount = ($data->amount*$data->tds_percent)/100;
$po_info = find_all_field('purchase_master','','po_no="'.$data->po_no.'"');
if($po_info->deductible=='Yes'){
$vds_amount = ($data->amount*$po_info->vat)/100;
}else{
$vds_amount = 0;
}*/


$narration = 'Invoice No.'.$invoice_no;

$tr_no = $data->system_invoice_no;


$narration = "Vendor Payable. Invoice No.".$data->invoice_no."";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->accounts_payable, $narration, $total_amount, 0, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//add_to_journal($proj_id, $jv_no, $jv_date, $data->accounts_payable, $narration, $total_amount, 0, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);


if($advance_amt>0){
$narration = "Advance Adjustment. Invoice No.".$data->invoice_no."";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $advance_to_vendor_dr, $narration, 0, $advance_amt,$tr_from, $data->po_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//add_to_journal($proj_id, $jv_no, $jv_date, $advance_to_vendor_dr, $narration, 0, $advance_amt,$tr_from, $data->po_no,$data->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}


$paid_amount = find_a_field('journal','sum(dr_amt)','ledger_id="'.$doc_vendor.'" and sub_ledger="'.$data->sub_ledger_id.'" and tr_no="'.$data->system_invoice_no.'" and tr_from="Vendor_payment"');
if($invoice_value==$paid_amount){
$invoice_update = 'update vendor_invoice_master set status="PAID" where system_invoice_no="'.$data->system_invoice_no.'"';
db_query($invoice_update);
}
$all_invoice .= $data->invoice_no.', ';
}

}


if(($net_payable>0) || (($credit_ledger>0) && ($credit_sub_ledger>0))){


	$narration = "Referance No.".$cheq_no.", Payment Date ".$cheq_date." Invoice No.".$data->invoice_no."";
	add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, 0, $net_payable, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);
	//add_to_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration, 0, $net_payable, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);
	//sec_journal_journal2($jv_no,$jv_no,$tr_from);

}else{

	echo '<script>alert("Please Selecr Cr. Ledger Properly...")</script>';
	
	$delete_query ="delete from secondary_journal where tr_from='Vendor_payment' and jv_no =".$jv_no." ";
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
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Select Vendor: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="vendor_id" id="vendor_id" value="<?=$_POST['vendor_id']?>" list="vendor" />
							<datalist id="vendor">
							  <? foreign_relation('vendor','concat(vendor_name,"#",vendor_id)','""',$vendor_id,'vendor_category=2')?>
							</datalist>
                        </div>
                    </div>

                </div>
                
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="group_for" id="group_for">
                            <option></option>
                            <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'1')?>
                            </select>

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

            
                $vendor = explode("#",$_POST['vendor_id']);
                $con = 'and m.vendor_id="'.$vendor[1].'"';
				
				if($_POST['group_for']>0)
				 $con .=' and m.group_for="'.$_POST['group_for'].'"';
				 
				 
				 
				 				 
				 
				 

            ?>


                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					<tr class="bgc-info">
					 <th>Invoice Count<input type="text" id="invoice_count" name="invoice_count" readonly /></th>
					 <th>Billing Amount<input type="text" id="biling_amt" name="biling_amt" readonly /></th>
                     <th>Total Payable<input type="text" id="total_amount" name="total_amount" readonly /></th>
					 <th>Net Advance<input type="text" id="total_advance" name="total_advance" readonly /></th>
					
					 
					 <th>Net Payable<input type="text" id="net_payable" name="net_payable" readonly /></th>
					 <th colspan="4">Cash/Bank<input type="text" id="receive_sub_ledger" name="receive_sub_ledger" list="cash_bank" required />
					 <datalist id="cash_bank">
							  <? foreign_relation('general_sub_ledger','concat(sub_ledger_name,"#",sub_ledger_id)','""',$receive_ledger,'tr_from="custom" and type in("Cash at Bank","Cash In Hand")')?>
							</datalist>					 </th>
					 
					 <th>Ref. No.<input type="text" id="cheq_no" name="cheq_no"/></th>
					 <th>Payment Date<input type="text" id="cheq_date" name="cheq_date"/></th>
					 
					</tr>
                    <tr class="bgc-info">
                        <th>SL</th>
                        <th>Invoice No.</th>
                        <th>Invoice Date</th>
						<th>PO No.</th>
                       
                        <th>Actual Payable</th>
                        <th>Unpaid Amount</th>
                        <th>Advance Amount</th>
                        <th>Advance Deductable</th>
						<th>Payable</th>
						<th>TDS Amount</th>
						<th>VDS Amount</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
					
					$advance_to_vendor_dr = 1022400004;
					 $res='select m.invoice_no,m.system_invoice_no,m.invoice_date,m.po_no,m.grn_no,sum(d.amount) as amount,m.tds_percent,v.vendor_name,v.sub_ledger_id,v.ledger_id,m.entry_at,u.fname,m.tds_amount,m.deductible from vendor_invoice_master m, vendor_invoice_details d, vendor v, user_activity_management u where m.system_invoice_no=d.system_invoice_no and m.vendor_id=v.vendor_id and m.entry_by=u.user_id and m.status="PENDING" and m.po_type in (0,1) '.$con.' group by m.system_invoice_no';
					$query = db_query($res);
                    while($row = mysqli_fetch_object($query)){
					if($row->tds_amount>0){
					$tds_amount = $row->tds_amount;
					}else{
					$tds_amount=($row->amount*$row->tds_percent)/100;
					}
					$po_info = find_all_field('purchase_master','','po_no="'.$row->po_no.'"');
					$vat_amount = ($row->amount*$po_info->vat)/100;
					$amount_with_vat = $row->amount+$vat_amount;
					
					if($row->deductible=='Yes'){
					$vds_amount = $vat_amount;
					}else{
					$vds_amount = 0;
					}
					
					$doc_vendor = $row->ledger_id;
					
				    $paid_amount = find_a_field('journal','sum(dr_amt)','ledger_id="'.$doc_vendor.'" and sub_ledger="'.$row->sub_ledger_id.'" and tr_no="'.$row->system_invoice_no.'" and tr_from="Vendor_payment"');
					
					
					/*$advance_amt = find_a_field('journal','sum(dr_amt)','ledger_id="'.$advance_to_vendor_dr.'" and sub_ledger="'.$row->sub_ledger_id.'" and tr_no="'.$row->po_no.'" and tr_from="Vendor_advance_payment"');*/
					
					$advance_amt = find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$advance_to_vendor_dr.'" and sub_ledger="'.$row->sub_ledger_id.'" and group_for='.$_POST['group_for'].'');
					
					
					if($advance_amt>=1){
					$rest_advance_amt = $advance_amt;//$advance_amt-$advance_amt_adjusted;
					}else{
						$rest_advance_amt =0;
					}
					$unpaid_amount = number_format($amount_with_vat-($paid_amount+$vds_amount+$tds_amount),2,'.','');
					$doc_payable = $amount_with_vat-($vds_amount+$tds_amount);
					if($unpaid_amount>0){
						if($rest_advance_amt>$unpaid_amount){
							$advance_deductable = $unpaid_amount;
							}else{
								$advance_deductable = $rest_advance_amt;
								
								}
								//echo $row->system_invoice_no;
                        ?>

                        <tr>
<td>
<input type="hidden" name="sub_ledger_id" id="sub_ledger_id" value="<?=$row->sub_ledger_id?>" />
<input type="checkbox" name="system_invoice_no<?=$row->system_invoice_no?>" class="form-control" id="system_invoice_no<?=$row->system_invoice_no?>" onclick="payment_cal(<?=$row->system_invoice_no?>)" /></td>
							<td><?=$row->invoice_no?></td>
                            <td><?=$row->invoice_date?></td>
                            <td><?=$row->po_no?></td>
                            
                            <td><?=number_format($doc_payable,2)?></td>
                            
                            <td><?=number_format($unpaid_amount,2)?><input type="hidden" name="net_amount<?=$row->system_invoice_no?>" id="net_amount<?=$row->system_invoice_no?>" value="<?=$unpaid_amount?>" /></td>
                            
                            <td><?=number_format($rest_advance_amt,2)?><input type="hidden" name="actual_advance<?=$row->system_invoice_no?>" id="actual_advance<?=$row->system_invoice_no?>" value="<?=$rest_advance_amt?>" /></td>
                            
                            <td><input type="text" name="advance_deductable<?=$row->system_invoice_no?>" id="advance_deductable<?=$row->system_invoice_no?>" value="<?=$advance_deductable?>" onChange="advance_cal(<?=$row->system_invoice_no?>)" />
                            <input type="hidden" name="advance_deductable_old<?=$row->system_invoice_no?>" id="advance_deductable_old<?=$row->system_invoice_no?>" value="<?=$advance_deductable?>" />
                            </td>
                            
                          <td><input type="text" name="actual_payable<?=$row->system_invoice_no?>" id="actual_payable<?=$row->system_invoice_no?>" value="<?=$unpaid_amount?>" onChange="advance_cal(<?=$row->system_invoice_no?>)" /><input type="hidden" name="actual_payable_old<?=$row->system_invoice_no?>" id="actual_payable_old<?=$row->system_invoice_no?>" value="<?=$unpaid_amount?>" /></td>
                          
<td><?=$tds_amount?></td>

<td><?=$vds_amount?></td>
                        </tr>
						
						
						<? $g_tot+=$unpaid_amount; ?>

                    <? } } ?>
					
					<tr>
						<td colspan="8">Total</td>
						<td><?=number_format($g_tot,2);?></td>
						<td colspan="2"></td>
					
					</tr>
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
	
	 
	 
	 var advance_amt = document.getElementById("advance_deductable"+invoice_no).value*1;
	 var advance_amt_old = document.getElementById("advance_deductable_old"+invoice_no).value*1;
	 var payable = document.getElementById("actual_payable"+invoice_no).value*1;
	 var payable_old = document.getElementById("actual_payable_old"+invoice_no).value*1;
	 if(advance_amt>payable){
	  alert("Payable Should Be Gretter Or Equal Advance Amount");
	 document.getElementById('advance_deductable'+invoice_no).value = advance_amt_old;
	 document.getElementById('actual_payable'+invoice_no).value = payable_old;
	 }
	 
	 if(payable>payable_old){
	  alert("Overflow!");
	 document.getElementById('actual_payable'+invoice_no).value = payable_old;
	 }
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
  
  var total_amt = document.getElementById("net_amount"+invoice_no).value*1;
  var actual_payable = document.getElementById("actual_payable"+invoice_no).value*1;
  var advance = document.getElementById("advance_deductable"+invoice_no).value*1;
 
  
  var pre_total_amt = document.getElementById("biling_amt").value*1;
  var pre_advance = document.getElementById("total_advance").value*1;
  var pre_net_payable = document.getElementById("net_payable").value*1;
  var pre_actual_payable = document.getElementById("total_amount").value*1;
  
  
  var total_payable = total_amt+pre_total_amt;
  var grand_total_advance = advance+pre_advance;
  var grand_total_actual = actual_payable+pre_actual_payable;
  var grand_total_payable = (grand_total_actual)-(grand_total_advance);
  
  document.getElementById('biling_amt').value = total_payable;
  document.getElementById('total_amount').value = grand_total_actual;
  document.getElementById('total_advance').value = grand_total_advance;
  document.getElementById('net_payable').value = grand_total_payable;
  
  
  
  }else{
  
  document.getElementById('invoice_count').value  = $('input:checkbox:checked').length;
  
  var total_amt = document.getElementById("net_amount"+invoice_no).value*1;
  var actual_payable = document.getElementById("actual_payable"+invoice_no).value*1;
  var advance = document.getElementById("advance_deductable"+invoice_no).value*1;
 
  
  var pre_total_amt = document.getElementById("biling_amt").value*1;
  var pre_advance = document.getElementById("total_advance").value*1;
  var pre_net_payable = document.getElementById("net_payable").value*1;
  var pre_actual_payable = document.getElementById("total_amount").value*1;
  
  
  var total_payable = pre_total_amt-total_amt;
  var grand_total_advance = pre_advance-advance;
  var grand_total_actual = pre_actual_payable-actual_payable;
  var grand_total_payable = (grand_total_actual)-(grand_total_advance);
  
  document.getElementById('biling_amt').value = total_payable;
  document.getElementById('total_amount').value = grand_total_actual;
  document.getElementById('total_advance').value = grand_total_advance;
  document.getElementById('net_payable').value = grand_total_payable;
  
  }
 
 
 }
</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>