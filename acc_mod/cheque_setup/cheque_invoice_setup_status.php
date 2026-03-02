<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


do_datatable('table_head');
// ::::: Edit This Section ::::: 
$title='Cheque Setup' ; 	// Page Name and Page Title
$page="cheque_setup.php";		// PHP File Name
$unique = 'jv_no';
$target_url = 'cheque_print_jv.php';
$target_url1 = 'cheque_print_jv.php';
?>


<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
}

function custom1(theUrl)
{
	window.open('<?=$target_url1?>?<?=$unique?>='+theUrl);
}
</script>


<div class="container-fluid">
            <div class="container n-form1 mt-3">
			
			<table id="table_head" class="table1 table-striped table-bordered table-hover table-sm dataTable no-footer" role="grid" aria-describedby="table_head_info" style=" ZOOM: 95%; ">
				<thead class="thead1">
					<tr class="bgc-info" role="row">
						<th>Sl No </th>
						<th>Cheque Book Id</th>
						<th>Cheque Date</th>
						<th>Cheque/Page No.</th>
						<th>Amount </th>
						<th>Bank Name </th>
						<th>Payee Name </th>
						<th>Particulars</th>
						<th>Voucher Ref</th>
						<th>status</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody class="tbody1">
				
				<? 
					$debit="select sum(dr_amt) as debit,sub_ledger,jv_no from journal where tr_from in('Payment','Vendor_payment','Vendor_advance_payment') and dr_amt>0 group by jv_no";
					$db2=db_query($debit);
					while($row2=mysqli_fetch_object($db2))
					{
						$ledger_dr[$row2->jv_no]=$row2->sub_ledger;
					
					}
					
					  $credit="select sum(cr_amt) as credit,sub_ledger,jv_no from journal where tr_from in ('Payment','Vendor_payment','Vendor_advance_payment') and cr_amt>0 group by jv_no ";
					$db=db_query($credit);
					while($row3=mysqli_fetch_object($db))
					{
						$ledger_cr[$row3->jv_no]=$row3->sub_ledger;
					
					}
					
				  $data = "SELECT j.*  FROM journal j,accounts_ledger a WHERE a.ledger_id=j.ledger_id and a.ledger_group_id in (125002) and j.cheq_no!='' and 1 and j.tr_from='Payment' group by jv_no ORDER BY j.id DESC"; 
					$query = db_query($data);
					$i=1;
					while($row=mysqli_fetch_object($query)){
					$cheque = find_all_field('cheque_book_details','','id="'.$row->cheq_no.'"');
					if($cheque->id>0){
					$cheq_no_manual = find_a_field('cheque_book_master','cheque_no_manual','cheq_no="'.$cheque->cheq_no.'"');
				?>
					<tr>
					    <td><?=$i++;?></td>
						<td><?=$cheq_no_manual?></td>
						<td><?=$row->jv_date;?></td>
						<td><?=$cheque->page_no;?></td>
						<td><?=$row->dr_amt;?></td>
						<td><?=find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$ledger_cr[$row->jv_no].'" ');  ?></td>
						<td><?=find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$ledger_dr[$row->jv_no].'" ');?></td>
						<td><?=$row->narration;?></td>
						<td><?=$row->jv_no;?></td>
						<td></td>
						<td>
						<? if($row->status == 'check'){?>
						<button type="button" onclick="custom('<?=$row->jv_no;?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
						<? }else{ ?>
						<button type="button" onclick="custom1('<?=$row->jv_no;?>');" class="btn2 btn1-bg-help"><i class="fa-solid fa-print"></i></button>
						<? } ?>						</td>
					</tr>
					
					<?php
					} }	
					?>
				</tbody>
			</table>
				
				

            </div>




</div>



<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>