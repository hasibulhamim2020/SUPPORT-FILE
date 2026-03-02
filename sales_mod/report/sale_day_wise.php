<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Delivery Sales Order Report';
	$isql='select * from  item_info where 1 group by item_id';
		$iquery=db_query($isql);
		while($irow=mysqli_fetch_object($iquery)){
		$item_name_get[$irow->item_id]=$irow->item_name;
		$unit_name_get[$irow->item_id]=$irow->unit_name;
		}
		
			$isql='select * from  dealer_info where 1 group by dealer_code';
		$iquery=db_query($isql);
		while($irow=mysqli_fetch_object($iquery)){
		$dealer_name_get[$irow->dealer_code]=$irow->dealer_name_e;
		}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sales Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php 
$f_date=$_GET['f_date'];
$t_date=$_GET['t_date'];
$item_id=$_GET['item_id'];
?>
<div class="container">
<h2 style="text-align:center;">Sales Details</h2>
  <p style="text-align:center;">Date between <?php echo $f_date;?> and <?php echo $t_date;?></p>   
  <p style="text-align:center;">Item Name:<?php echo $item_name_get[$item_id];?></p>         
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>SL</th>
        <th>Challan Date</th>
        <th>Challan NO</th>
		<th>Order NO</th>
		<th>Order Date</th>
	 
		<th>Item Name</th>
		<th>Unit</th>
		<th>Unit Price</th>
		<th>Total Qty</th>
		<th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
	
	<?php
	  $csql='select sum(total_unit) as total_chalan_qty,sum(total_amt) as total_chalan_amt,item_id,chalan_date,gift_id,chalan_no,chalan_date,do_no,do_date from sale_do_chalan where chalan_date between "'.$f_date.'" and "'.$t_date.'" and item_id="'.$item_id.'" and gift_id<1 group by chalan_date asc';
	$query=db_query($csql);
	while($row=mysqli_fetch_object($query)){
	 
	?>
       <tr>
        <td><?php echo ++$i;?></td>
		<td><a href="sale_day_wise_customer.php?f_date=<?=$row->chalan_date?>&&t_date=<?=$row->chalan_date?>&&item_id=<?=$row->item_id?>" target="_blank"><?php echo $row->chalan_date;?></a></td>
		<td><?php echo $row->chalan_no;?></td>
		<td><?php echo $row->do_no;?></td>
		<td><?php echo $row->do_date;?></td>
	 
		<td><?php echo $item_name_get[$row->item_id];?></td>
		<td><?php echo $unit_name_get[$row->item_id];?></td>
		<td><?php echo $rate_get=($row->total_chalan_amt/$row->total_chalan_qty); 
		 
		?></td>
		<td><?php echo number_format($row->total_chalan_qty,3);?></td>
      <td><?php echo number_format($row->total_chalan_amt,3);?></td>
      </tr>
	  <?php 
	  $total_qty+=$row->total_chalan_qty;
	  $total_amount+=$row->total_chalan_amt;
	  } ?>
	  <tr>
	  	<td colspan="8">Total</td>
		<td><?php echo $total_qty;?></td>
		<td><?php echo $total_amount;?></td>
	  </tr>
    </tbody>
  </table>
</div>

</body>
</html>
