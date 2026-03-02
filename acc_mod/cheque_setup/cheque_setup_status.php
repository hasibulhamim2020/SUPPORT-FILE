<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


do_datatable('table_head');
// ::::: Edit This Section ::::: 
$title='Cheque Setup' ; 	// Page Name and Page Title
$page="cheque_setup.php";		// PHP File Name
$unique = 'id';
$target_url = 'cheque_setup_entry.php';
$target_url1 = 'cheque_print.php';
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
						<th>Cheque No</th>
						<th>Amount </th>
						<th>Payee Name </th>
						<th>Particulars</th>
						<th>Voucher Ref</th>
						<th>status</th>
						<th>Action</th>

					</tr>
				</thead>

				<tbody class="tbody1">
				<?  $data = "SELECT * FROM chq_setup_master WHERE 1"; 
					$query = db_query($data);
					$i=1;
					while($row=mysqli_fetch_object($query)){
				?>
					<tr>
					    <td><?=$i++;?></td>
						<td><?=$row->chq_book_id;?></td>
						<td><?=$row->chq_date;?></td>
						<td><?=$row->chq_no;?></td>
						<td><?=$row->amount;?></td>
						<td><?=$row->payee_name;?></td>
						<td><?=$row->particulars;?></td>
						<td><?=$row->voucher_ref;?></td>
						<td><?=$row->status;?></td>
						<td>
						<? if($row->status == 'check'){?>
						<button type="button" onclick="custom('<?=$row->id;?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
						<? }else{ ?>
						<button type="button" onclick="custom1('<?=$row->id;?>');" class="btn2 btn1-bg-help"><i class="fa-solid fa-print"></i></button>
						<? } ?>
						</td>
					
					</tr>
					
					<?php
					}	
					?>
				</tbody>
			</table>
				
				

            </div>




</div>



<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>