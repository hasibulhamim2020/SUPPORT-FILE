<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


do_datatable('table_head');
// ::::: Edit This Section ::::: 
$title='Cheque Book Settings' ; 	// Page Name and Page Title
$page="cheque_book_settings.php";		// PHP File Name
$unique = 'chq_print_id';
$target_url = 'cheque_book_settings_entry.php';
?>


<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
}
</script>


<div class="container-fluid">
            <div class="container n-form1 mt-3">
			<center><a href="cheque_book_settings_entry.php"><button type="button" class="btn2 btn1-bg-submit">Create New Settings</button></a></center>
			<table id="table_head" class="table1 table-striped table-bordered table-hover table-sm dataTable no-footer" role="grid" aria-describedby="table_head_info" style=" ZOOM: 95%; ">
				<thead class="thead1">
					<tr class="bgc-info" role="row">
						<th>Sl No </th>
						<th>Bank Name</th>
						<th>Action</th>

					</tr>
				</thead>

				<tbody class="tbody1">
				<?  $data = "SELECT * FROM chq_print_setup WHERE 1"; 
					$query = db_query($data);
					$i=1;
					while($row=mysqli_fetch_object($query)){
				?>
					<tr>
					    <td><?=$i++;?></td>
						<td><? $bank_id = find_a_field('chq_setup','bank_name','bank_name="'.$row->chq_id.'"');
						echo find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id='.$bank_id);?>
						</td>
						<td><button type="button" onclick="custom('<?=$row->chq_print_id;?>');" class="btn2 btn1-bg-update">Edit Settings</button></td>
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