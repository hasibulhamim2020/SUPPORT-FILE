<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$tr_type="Show";

$title='Vendor Advance Payment';

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

$config_ledger = find_all_field('config_group_class','',"group_for=".$_SESSION['user']['group']);
if(isset($_POST['confirm_payment'])){
 


$advance_to_vendor_dr = $config_ledger->supplier_advance_control;
$credit_sub_ledger = end(explode("#",$_POST['receive_sub_ledger']));
$credit_ledger = find_a_field('general_sub_ledger','ledger_id','sub_ledger_id="'.$credit_sub_ledger.'"');
$vendor_sub_ledger = $_POST['sub_ledger_id'];

$entry_by = $_SESSION['user']['id'];
$entry_at = date('Y-m-d H:i:s');
//$jv_no=next_journal_sec_voucher_id();		
$proj_id = 'MEP';
$jv_date = date('Y-m-d');
$tr_no = $_POST['po_no'];
$group = $_POST['group_for'];
$jv_no =next_journal_sec_voucher_id('',$tr_from,$group);	
$total_amount = $_POST['advance_amount'];
$cheq_no = $_POST['cheq_no'];
$cheq_date = $_POST['cheq_date'];

$narration = "Advance to Vendor. PO No.".$_POST['po_no']."";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $advance_to_vendor_dr, $narration, $total_amount, 0, $tr_from, $tr_no,$vendor_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//add_to_journal($proj_id, $jv_no, $jv_date, $advance_to_vendor_dr, $narration, $total_amount, 0, $tr_from, $tr_no,$vendor_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);

$narration = 'Advance Payment. Cheque No. "'.$cheq_no.'", Cheque Date : "'.$cheq_date.'"';
add_to_sec_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration,  0, $total_amount, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//add_to_journal($proj_id, $jv_no, $jv_date, $credit_ledger, $narration,  0, $total_amount, $tr_from, $tr_no,$credit_sub_ledger,$tr_id,$cc_code,$group,$entry_by,$entry_at);


sec_journal_journal($jv_no,$jv_no,$tr_from);

unset($_POST);
$_SESSION['success'] = 'Payment Success.';
header('location:advance_payment.php');
$tr_type="Confirmed";

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

        <div class="container-fluid pt-5 p-0 ">

            <?

            if(isset($_REQUEST['po_no'])){

            
                
                $con = 'and m.po_no="'.$_REQUEST['po_no'].'"';
				

$res='select m.po_no,m.po_date,sum(d.amount) as amount,v.vendor_name,v.sub_ledger_id,m.entry_at,u.fname,m.group_for from purchase_master m, purchase_invoice d, vendor v, user_activity_management u where m.po_no=d.po_no and m.vendor_id=v.vendor_id and m.entry_by=u.user_id and m.status="CHECKED" '.$con.' group by m.po_no';

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
                        <th>Advance Paid</th>
						<th>Advance Payable</th>
						<th>Bank/Cash</th>
						<th>Ref No.</th>
						<th>Cheq. Date</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
					$advance_to_vendor_dr = $config_ledger->supplier_advance_control;
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
                            <input type="hidden" name="group_for" id="group_for" value="<?=$row->group_for?>" />
							</td>
							<td><input type="text" id="receive_sub_ledger" name="receive_sub_ledger" list="cash_bank" required/>
					 <datalist id="cash_bank">
							  <? foreign_relation('general_sub_ledger','concat(sub_ledger_name,"#",sub_ledger_id)','""',$receive_ledger,'tr_from="custom" and type="Cash at Bank"')?>
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
$page_name='Vendor Advance Payment';

require_once SERVER_CORE."routing/layout.bottom.php";

?>