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
		 
				<th>Item Name</th>
					<th>Item Unit</th>
						 
							<th>Item Qty</th>
								<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	
<?php
///////////item data//////////
$itsql='select * from item_info';
$iquery=db_query($itsql);
while($irow=mysqli_fetch_object($iquery)){
$item_name[$irow->item_id]=$irow->item_name;
$unit_name[$irow->item_id]=$irow->unit_name;
 
}


	  $sql='select d.oi_no,d.item_id,sum(d.qty) as tot_qty,sum(d.amount) as tot_amount,m.oi_no,m.status,m.issue_type,m.oi_date from warehouse_other_issue_detail d, warehouse_other_issue m where d.oi_no=m.oi_no and m.status="CHECKED" and m.issue_type="Local Sales" and m.oi_date between "'.$fdate.'" and "'.$tdate.'" group by d.item_id';
	$query=db_query($sql);
	while($srow=mysqli_fetch_object($query)){
	 ?>
		<tr>
			<td><?php echo ++$i;?></td>
		 
			<td><?php echo $item_name[$srow->item_id];?></td>
			<td><?php echo $unit_name[$srow->item_id];?></td>
			 
			<td><?php echo $srow->tot_qty;?></td>
			<td><?php echo $srow->tot_amount;?></td>
			
		</tr>
<?php 
$gr_tot_qty+=$srow->tot_qty;
$gr_tot_amount+=$srow->tot_amount;
} ?>

<tr>
	<th colspan="3">Total</th>
	<th><?php echo $gr_tot_qty;?></th>
	<th><?php echo $gr_tot_amount;?></th>
</tr>
	</tbody>
</table>




<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>