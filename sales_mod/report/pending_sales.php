<?php

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>PENDING SALES</title>
	<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>
  </head>
  <body>
  
  <div class="d-flex justify-content-between">
  
  <div style="padding-right: 126px;">
&nbsp;&nbsp;&nbsp;&nbsp;
  
  </div>
<div>
  <p id="pr" class="text-center"><input name="button" type="button" onClick="hide();window.print();" value="Print" /></p>
 
 <h4 style="text-align:center">STOCK POSITION</h4></div>


<div>&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp</div>

</div>

<div align="right" class="date"><strong>Reporting Time: <?=date("h:i A d-m-Y")?></strong></div>



<?

  $sql='select d.item_id,sum(d.dist_unit) as unit ,i.pack_size,s.sub_group_name,i.item_name,i.unit_name
   
from sale_do_master m, sale_do_details d,item_info i,item_sub_group s
   
where m.do_no=d.do_no and m.status="CHECKED" and d.item_id=i.item_id and i.sub_group_id=s.sub_group_id group by d.item_id';
$query=db_query($sql);
$i=0;
while($row=mysqli_fetch_object($query)){
	
	$pending[$row->item_id]=$row->unit;
}
 
?>




<?

 $sql2='select  sum(j.item_in-j.item_ex) as stock,i.item_id,i.pack_size from journal_item j ,item_info i where i.item_id=j.item_id group by i.item_id';
$query2=db_query($sql2);
while($row2=mysqli_fetch_object($query2)){
	$t_stock[$row2->item_id]=$row2->stock;
}
	?>
	
<table style="border-color:#000000" class="table table-bordered table-hover table-sm text-center mt-5">
<thead>
<tr>
<th>SL </th>

<th>Item Name </th>
<th>Unit </th>
<th>Main Stock </th>
<th>Pending Stock</th>
<th>Present Stock</th>

</tr>
</thead>
<tbody>
	
		<? 
		
		$sql3 = "select i.* from item_info i,item_sub_group s where s.sub_group_id=i.sub_group_id and s.sub_group_id=100030000  group by i.item_id";
		$query3=db_query($sql3);
		
		while($row3=mysqli_fetch_object($query3)){
			
			$t_pending=$pending[$row3->item_id] - $al_ch_qty=find_a_field('sale_do_master m,sale_do_chalan c','sum(c.dist_unit)','m.do_no=c.do_no and m.status="CHECKED" and c.item_id="'.$row3->item_id.'" group by c.item_id');
			if($t_pending > 0  || $t_stock[$row3->item_id]>0 ){
				$i++;
				
				?>
	<tr>
		<td><?=$i;?></td>
		<td><?=$row3->item_name?></td>
		
		<td><?=$row3->unit_name?></td>
		<td><?=$t_stock[$row3->item_id]; $g_stock_total +=$t_stock[$row3->item_id]; ?></td>
		
		<td><?=$t_pending; $g_pending +=$t_pending; ?></td>
		
		<td><?=$p_stock=$t_stock[$row3->item_id]-$t_pending; $g_p_stock +=$p_stock; ?></td>
		
	</tr>					
				<?
			}
			
		}
		
		
		
		
		?>
	<tr>
		<td colspan="3"><strong>Total</strong></td>
		<td><strong><?=$g_stock_total;?></strong></td>
		<td><strong><?=$g_pending;?></strong></td>
		<td><strong><?=$g_p_stock;?></strong></td>
	</tr>

</tbody>

  </body>
</html>
