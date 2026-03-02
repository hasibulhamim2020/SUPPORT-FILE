<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


do_datatable('table_head');
// ::::: Edit This Section ::::: 
$title='Cheque Setup' ; 	// Page Name and Page Title
$page="cheque_setup.php";		// PHP File Name
$unique = 'chq_id';
$target_url = 'cheque_setup_entry.php';
?>


<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
}
</script>


<div class="container-fluid">
            <div class="container n-form1 mt-3">
			
			<table id="table_head" class="table1 table-striped table-bordered table-hover table-sm dataTable no-footer" role="grid" aria-describedby="table_head_info" style=" ZOOM: 95%; ">
				<thead class="thead1">
					<tr class="bgc-info" role="row">
						<th>Sl No </th>
						<th>Account Name</th>
						<th>Bank</th>
						<th>Account Number  </th>
						<th>Chequebook ID </th>
						<th>Action</th>

					</tr>
				</thead>

				<tbody class="tbody1">
				<?  $data = "SELECT * FROM chq_setup WHERE 1"; 
					$query = db_query($data);
					$i=1;
					while($row=mysqli_fetch_object($query)){
				?>
					<tr>
					    <td><?=$i++;?></td>
						<td><?=$row->acct_name;?></td>
						<td><?=find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id='.$row->bank_name);?></td>
						<td><?=$row->acct_number;?></td>
						<td><?=$row->chq_book_id;?></td>
						<td><button type="button" onclick="custom('<?=$row->id;?>');" class="btn2 btn1-bg-update">Create Cheque</button></td>
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