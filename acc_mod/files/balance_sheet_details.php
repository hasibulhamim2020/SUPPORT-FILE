<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Balance Sheet';

$proj_id=$_SESSION['proj_id'];





$tdate=$_REQUEST['tdate'];

//fdate-------------------



$ledger_id=$_REQUEST["ledger_id"];





if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')

$report_detail.='<br>Report date Till: '.$_REQUEST['tdate'];





$j=0;

for($i=0;$i<strlen($fdate);$i++)

{

if(is_numeric($fdate[$i]))

$time1[$j]=$time1[$j].$fdate[$i];



else $j++;

}



$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);



//tdate-------------------





$j=0;

for($i=0;$i<strlen($tdate);$i++)

{

if(is_numeric($tdate[$i]))

$time[$j]=$time[$j].$tdate[$i];

else $j++;

}

$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);







?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2 class="text-center">Transection Details</h2>
          
  <table class="table table-condensed table-bordered">
    <thead>
      <tr>
	  <th>S/L</th>
        <th>Ledger Name</th>
        <th>Date</th>
        <th>Debit</th>
		 <th>Credit</th>
		  <th>Tr From</th>
		   <th>Entry By</th>
		    <th>Entry At</th>
      </tr>
    </thead>
    <tbody>
   <?php 
   $ledger_id=$_GET['ledger_id'];
   $to_date=$_GET['to_date'];
    $sql="select * from journal where ledger_id='".$ledger_id."' and jv_date<='".$to_date."'";
   $query=db_query($sql);
   while($data=mysqli_fetch_object($query)){
   ?>
      <tr>
	  <td><?=++$i?></td>
       <td><?=$data->ledger_id?></td>
	   <td><?=$data->jv_date?></td>
	   <td><?=$data->dr_amt?></td>
	   <td><?=$data->cr_amt?></td>
	   <td><?php 
	   if($data->tr_from=="AUTO"){
	   echo "Sales";
	   }
	   elseif($data->tr_from=="Ledger"){
	   echo "Opening";
	   }
	   else{
	  echo  $data->tr_from;
	   }
	   ?></td>
	   <td><?=$data->user_id?></td>
	   <td><?=$data->entry_at?></td>
      </tr>
 <?php 
 $debit_tot+=$data->dr_amt;
 $credit_tot+=$data->cr_amt;
 }
 ?>
 <tr>
 	<td colspan="3" style="font-weight:bold;" >Total</td>
	<td style="font-weight:bold;"><?php echo $debit_tot;?></td>
	<td style="font-weight:bold;" ><?php echo $credit_tot;?></td>
	<td colspan="3"></td>
 </tr>
<!--  <tr>
 	<td colspan="3" style="font-weight:bold;" >Difference</td>
	<td style="font-weight:bold;"><?php echo $debit_tot;?></td>
	
	<td colspan="3"></td>
 </tr>-->

 
    </tbody>
  </table>
</div>

</body>
</html>

