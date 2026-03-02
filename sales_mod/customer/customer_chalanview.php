<?php

session_start();

ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$customer_id = $_GET['sub_ledger'];

 $fdate = $_GET['fdate'];
 
 $tdate = $_GET['tdate'];



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
function print_cus(){
document.getElementById('pr').style.display='none';
window.print();
}
</script>
<title>.: Customer Chalan View:</title>

</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<br /><br /><br />
<center id="pr"><button onclick="print_cus()">Print</button></center>

<h2 style="text-align:center;">Customer Statement</h2>
<br /><br />



<table class="table table-hover table-striped" style="width:98%;margin-left:10px;">
<!--<tr b>-->
<!--<th>SI</th>-->
<!--<th style="width:250px;margin-left:100px;text-align:center">Invoice NO</th>-->
<!--<th style="width:250px;margin-left:100px;text-align:center">Work Order NO</th>-->
<!--<th style="width:250px;text-align:center">Customer Name</th>-->
<!--<th style="width:250px;text-align:center">Chalan Date</th>-->
<!--<th style="width:250px;text-align:center">Quantity</th>-->
<!--<th style="width:250px;text-align:center">Amount</th>-->
<!--</tr>-->

<th>SI</th>
<th style="width:250px;margin-left:100px;text-align:center">Customer Name</th>
<th style="width:250px;margin-left:100px;text-align:center">Date</th>
<th style="width:250px;text-align:center">Type</th>
<th style="width:250px;text-align:center">Amount</th>

<th style="width:250px;text-align:center">Entry By</th>
<th style="width:250px;text-align:center">Entry At</th>
<?php
$i=1;
// echo  $sql="select a.chalan_no,a.chalan_date,a.total_unit,sum(a.total_amt) as amount,a.do_no,b.dealer_code,b.dealer_name_e from sale_do_chalan a,dealer_info b where a.dealer_code=b.dealer_code and a.chalan_date BETWEEN '".$fdate."' and '".$tdate."' and b.dealer_code='".$customer_id."' group by a.chalan_no order by a.chalan_date asc";
  $sql="select * from journal where sub_ledger='".$customer_id."' and dr_amt!=0 and jv_date BETWEEN '".$fdate."' and '".$tdate."'";
$query=db_query($sql);

while($data=mysqli_fetch_object($query)){
$total_qty=$total_qty+$data->total_unit;
$total_amt=$total_amt+$data->dr_amt;
?>

<tr>
<td><?= ++$i?></td>
<td style="width:250px;text-align:center"><?=find_a_field('dealer_info','dealer_name_e','sub_ledger_id='.$data->sub_ledger); ?></td>
<td style="width:250px;text-align:center"><?=$data->jv_date; ?></td>
<td style="width:250px;text-align:center"><?=$data->tr_from;?></td>

<td style="width:250px;text-align:center"><?=$data->dr_amt; ?></td>
<td style="width:250px;text-align:center"><?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by); ?></td>
<td style="width:250px;text-align:center"><?=$data->entry_at; ?></td>
</tr>

<?php } ?>

<tr>
<td style="width:250px;text-align:center"></td>
<td style="width:250px;text-align:center"></td>
<td style="width:250px;text-align:center"></td>
<td style="width:250px;text-align:center"><b>Total=</b></td>
<td style="width:250px;text-align:center"><b><?=$total_amt?></b></td>
<td style="width:250px;text-align:center"></td>
<td style="width:250px;text-align:center"><b></b></td>

</tr>

</table>



</body>



</html>



