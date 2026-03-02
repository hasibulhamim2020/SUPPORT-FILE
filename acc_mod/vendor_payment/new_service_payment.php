<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Service Payment';

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
 
 
$advance_to_vendor_dr = 1022400004;
$credit_sub_ledger = end(explode("#",$_POST['receive_sub_ledger']));
$credit_ledger = find_a_field('general_sub_ledger','ledger_id','sub_ledger_id="'.$credit_sub_ledger.'"');
$vendor_sub_ledger = $_POST['sub_ledger_id'];

$tr_from = 'Vendor_advance_payment';
$entry_by = $_SESSION['user']['id'];
$entry_at = date('Y-m-d H:i:s');
$jv_no=next_journal_sec_voucher_id();		
$proj_id = 'MEP';
$jv_date = date('Y-m-d');
$tr_no = $_POST['po_no'];

$total_amount = $_POST['advance_amount'];
$cheq_no = $_POST['cheq_no'];
$cheq_date = $_POST['cheq_date'];

$narration = "Advance to Vendor. PO No.".$_POST['po_no']."";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $advance_to_vendor_dr, $narration, $total_amount, 0, $tr_from, $tr_no,$vendor_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $advance_to_vendor_dr, $narration, $total_amount, 0, $tr_from, $tr_no,$vendor_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);

$narration = 'Advance Payment. Cheque No. "'.$cheq_no.'", Cheque Date : "'.$cheq_date.'"';
add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration,  0, $total_amount, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration,  0, $total_amount, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);

$_SESSION['success'] = 'Payment Success.';
header('location:advance_payment.php');

//sec_journal_journal2($jv_no,$jv_no,$tr_from);
 
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
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO Date From: </label>
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

            if(isset($_REQUEST['po_no'])){

            
                
                $con = 'and m.po_no="'.$_REQUEST['po_no'].'"';
				

$res='select m.po_no,m.po_date,sum(d.amount) as amount,v.vendor_name,v.sub_ledger_id,m.entry_at,u.fname from purchase_master m, purchase_invoice d, vendor v, user_activity_management u where m.po_no=d.po_no and m.vendor_id=v.vendor_id and m.entry_by=u.user_id and m.status="CHECKED" '.$con.' group by m.po_no';

            $query = db_query($res);

            //echo link_report($res,'po_print_view.php');
            ?>


                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					
                    <tr class="bgc-info">
                        <th>SL</th>
                        <th>PO NO.</th>
                        <th>PO Date</th>
						<th>Vendor</th>
                        <th>PO Value</th>
                        <th>Paid</th>
						<th>Payable</th>
						<th>Bank/Cash</th>
						<th>Ref. No.</th>
						<th>Payment Date</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
					$advance_to_vendor_dr = 1022400004;
                    while($row = mysqli_fetch_object($query)){
					
					//$amount_with_vat = $row->amount+$vat_amount;
					
				    $paid_amount = find_a_field('journal','sum(dr_amt)','ledger_id="'.$advance_to_vendor_dr.'" and sub_ledger="'.$row->sub_ledger_id.'" and tr_no="'.$row->po_no.'" and tr_from="Vendor_advance_payment"');
					//$sql = 'select sum(dr_amt) from journal where ledger_id="'.$advance_to_vendor_dr.'" and sub_ledger="'.$row->sub_ledger_id.'" and tr_no="'.$row->po_no.'" and tr_from="Vendor_advance_payment"';
					//$unpaid_amount = $amount_with_vat-$paid_amount;
                        ?>

                        <tr>
<td>
<input type="hidden" name="sub_ledger_id" id="sub_ledger_id" value="<?=$row->sub_ledger_id?>" />
<input type="checkbox" name="system_invoice_no<?=$row->system_invoice_no?>" class="form-control" id="system_invoice_no<?=$row->system_invoice_no?>" onclick="count(<?=$row->system_invoice_no?>)" /></td>
							<td><?=++$i?></td>
                            <td><?=$row->po_date?></td>
                            <td><?=$row->vendor_name?></td>
                            
                            <td><?=number_format($row->amount,2)?></td>
							<td><?=number_format($paid_amount,2)?></td>
                            <td><input type="text" name="advance_amount" id="advance_amount" value="<?=$row->amount-$paid_amount?>" />
							<input type="hidden" name="sub_ledger_id" id="sub_ledger_id" value="<?=$row->sub_ledger_id?>" />
							<input type="hidden" name="po_no" id="po_no" value="<?=$row->po_no?>" />
							</td>
							<td><input type="text" id="receive_sub_ledger" name="receive_sub_ledger" list="cash_bank"/>
					 <datalist id="cash_bank">
							  <? foreign_relation('general_sub_ledger','concat(sub_ledger_name,"#",sub_ledger_id)','""',$receive_ledger,'tr_from="custom" and type="Bank"')?>
							</datalist>
							</td>
					 
					 <td><input type="text" id="cheq_no" name="cheq_no"/></td>
					 <td><input type="date" id="cheq_date" name="cheq_date"/></td>
                        </tr>

                    <? } ?>
					
					<tr>
					  
					  <td colspan="10"><input type="submit" name="confirm_payment" id="confirm_payment" value="Confirm Payment" /></td>
					</tr>
                    </tbody>
                </table>

                <? } ?>


        </div>
    </form>
</div>


<script>
 function count(invoice_no){
 var checked_invoice = $("#system_invoice_no"+invoice_no);
 //alert(invoice_no);
 if(document.getElementById("system_invoice_no"+invoice_no).checked == true){
  document.getElementById('invoice_count').value  = $('input:checkbox:checked').length;
  
  var total_amt = document.getElementById("net_amount"+invoice_no).value*1;
  var actual_payable = document.getElementById("actual_payable"+invoice_no).value*1;
  var tds_amt = document.getElementById("tds_amount"+invoice_no).value*1;
  var vds_amt = document.getElementById("vds_amount"+invoice_no).value*1;
  
  var pre_total_amt = document.getElementById("total_amount").value*1;
  var pre_tds = document.getElementById("total_tds_amount").value*1;
  var pre_vds = document.getElementById("total_vds_amount").value*1;
  var pre_net_payable = document.getElementById("net_payable").value*1;
  
  var total_payable = actual_payable+pre_total_amt;
  var grand_total_tds = tds_amt+pre_tds;
  var grand_total_vds = vds_amt+pre_vds;
  var grand_total_payable = (total_payable)-(grand_total_tds+grand_total_vds);
  
  document.getElementById('total_amount').value = total_payable;
  document.getElementById('total_tds_amount').value = grand_total_tds;
  document.getElementById('total_vds_amount').value = grand_total_vds;
  document.getElementById('net_payable').value = grand_total_payable;
  
  }else{
  
  document.getElementById('invoice_count').value  = $('input:checkbox:checked').length;
  
  var total_amt = document.getElementById("net_amount"+invoice_no).value*1;
  var actual_payable = document.getElementById("actual_payable"+invoice_no).value*1;
  var tds_amt = document.getElementById("tds_amount"+invoice_no).value*1;
  var vds_amt = document.getElementById("vds_amount"+invoice_no).value*1;
  
  var pre_total_amt = document.getElementById("total_amount").value*1;
  var pre_tds = document.getElementById("total_tds_amount").value*1;
  var pre_vds = document.getElementById("total_vds_amount").value*1;
  var pre_net_payable = document.getElementById("net_payable").value*1;
  
  var total_payable = pre_total_amt-actual_payable;
  var grand_total_tds = pre_tds-tds_amt;
  var grand_total_vds = pre_vds-vds_amt;
  var grand_total_payable = (total_payable)-(grand_total_tds+grand_total_vds);
  
  document.getElementById('total_amount').value = total_payable;
  document.getElementById('total_tds_amount').value = grand_total_tds;
  document.getElementById('total_vds_amount').value = grand_total_vds;
  document.getElementById('net_payable').value = grand_total_payable;
  
  }
 }
</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>