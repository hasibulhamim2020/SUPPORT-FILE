<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Local Purchase Verification';
$now=time();
do_calander('#do_date_fr');
do_calander('#do_date_to');
?>
 


 <table class="table table-bordered table-condensed">
 	<thead>
		<tr>
			<th>Sl</th>
			<th>Voucher No</th>
			<th>Ledger Name</th>
			<th>Type</th>
			<th>Debit Amount</th>
			<th>Credit Amount</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$sql='select * from secondary_journal where jv_no=0 or jv_date="0000-00-00"  or ledger_id=0';
	$query=db_query($sql);
	while($row=mysqli_fetch_object($query)){
	?>
		<tr style="background-color:red!important;">
			<td><?php echo ++$i;?></td>
			<td><?php echo $row->jv_no;?></td>
			<td><?php echo $row->ledger_id;?></td>
			<td><?php echo $row->tr_from;?></td>
			<td><?php echo  $row->dr_amt;?></td>
			<td><?php echo  $row->cr_amt;?></td>
			<td><a href="general_voucher_print_view_for_draft.php?jv_no=<?=$row->jv_no;?>" target="_blank">View</a></td>
		</tr>
		<?php } ?>
	</tbody>
 </table>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

