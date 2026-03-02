<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Trading Sales Details';


$fdate=$_GET["fdate"];

$tdate=$_GET['tdate'];





?>



<table class="table table-bordered table-sm">
	<thead>
	
	
		<tr>
			<th>SL</th>
			<th>LC No</th>
			<th>Export LC No</th>
			<th>LC Date</th>
				<th>LDBC Date</th>
					<th>LC Value</th>
						 
		</tr>
	</thead>
	<tbody>
	
<?php



	  $sql='select * from lc_master where ldbc_date between "'.$fdate.'" and "'.$tdate.'" and up_no>0';
	$query=db_query($sql);
	while($srow=mysqli_fetch_object($query)){
	 ?>
		<tr>
			<td><?php echo ++$i;?></td>
			<td><?php echo $srow->lc_no_view;?></td>
			<td><?php echo $srow->export_lc_no;?></td>
			<td><?php echo $srow->lc_date;?></td>
			<td><?php echo $srow->ldbc_date;?></td>
			<td><?php echo $srow->valueccc;?></td>
			 
			
		</tr>
<?php 
 
$gr_tot_amount+=$srow->valueccc;
} ?>

<tr>
	<th colspan="5">Total</th>
	 
	<th><?php echo $gr_tot_amount;?></th>
</tr>
	</tbody>
</table>




<?



require_once SERVER_CORE."routing/layout.bottom.php";




?>