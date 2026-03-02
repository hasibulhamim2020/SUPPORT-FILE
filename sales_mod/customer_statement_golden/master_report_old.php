<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Customer Statement';
$proj_id=$_SESSION['proj_id'];
$active='transdetrep';
 
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  
<div class="container">
<?php 
$dealer_name=find_a_field('dealer_info','dealer_name_e','account_code="'.$_POST['dealer_acc_code'].'"');
?>
<h1 style="text-align:center;font-weight:bold;"><?php echo $dealer_name;?></h1>
     <table class="table table-bordered table-sm">
	 	<thead>
			<tr>
				<th>Job No</th>
				<th>Invoice No</th>
				<th>Invoice Date</th>
				<th>Amount</th>
				<th>Paid Amount</th>
				<th>Due Amount</th>
				<td>Payment Details</td>
			</tr>
		</thead>
		<tbody>
		<?php 
		
		 $account_code_con=" and d.account_code=".$_POST['dealer_acc_code'];
		 
		 		 $sql = "select sum(cr_amt) as receipt_amt, ledger_id, tr_id  from journal where tr_from='Receipt' and jv_date between '".$_POST['fdate']."' and '".$_POST['tdate']."' group by tr_id ";
					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){
					$receipt_amt[$data->ledger_id][$data->tr_id]=$data->receipt_amt;
					
					}
					  
					  
					  
					 $sql = "select sum(cr_amt) as return_amt, ledger_id, tr_id  from journal where tr_from='Sales Return' and jv_date between '".$_POST['fdate']."' and '".$_POST['tdate']."'  group by tr_id";
					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){
					$return_amt[$data->ledger_id][$data->tr_id]=$data->return_amt;	
					}
		 
		  $sql = "SELECT d.account_code, d.dealer_name_e, j.tr_no, j.jv_date, sum(j.dr_amt) as invoice_amt, j.tr_id FROM journal j, dealer_info d WHERE j.ledger_id=d.account_code and j.tr_from in ('Sales') and j.jv_date between '".$_POST['fdate']."' and '".$_POST['tdate']."'  ".$account_code_con."  group by j.tr_no";
		$query=db_query($sql);
		while($row=mysqli_fetch_object($query)){
		?>
			<tr>
				<td><a href="../../../sales_mod/pages/wo_golden/sales_order_print_view.php?v_no=<?=$row->tr_id?>" target="_blank"><span class="style13" >
						  <?=find_a_field('sale_do_master','job_no','do_no='.$row->tr_id);?>
						</span></a></td>
				<td><a href="../../../sales_mod/pages/challan_list/invoice.php?v_no=<?=$row->tr_no?>" target="_blank"><span class="style13" >
						  <?=$row->tr_no?>
						</span></a><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo_golden/work_order_print_view.php?v_no=<?=$row->do_no?>"></a></td>
				<td><?php echo $row->jv_date;?></td>
				<td><?php 
				$inv_amount=$row->invoice_amt;
				echo number_format($row->invoice_amt,2);?></td>
				<td> <?php 
				$paid_amount=$receipt_amt[$row->account_code][$row->tr_no]+$return_amt[$row->account_code][$row->tr_no];
				echo number_format($receipt_amt[$row->account_code][$row->tr_no]+$return_amt[$row->account_code][$row->tr_no],2);?></td>
				<td><?php 
				 
				 echo number_format($due_amt=$row->invoice_amt-$receipt_amt[$row->account_code][$row->tr_no]+$return_amt[$row->account_code][$row->tr_no],2);?></td>
				<td>
				<table class="table table-bordered table-sm">
					<thead>
						<tr>
							<th>Payment Method</th>
							<th>Payment Form</th>
							<th>Details</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$details_sql='select * from receipt_from_customer where chalan_no="'.$row->tr_no.'" and receipt_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" ';
					$details_query=db_query($details_sql);
					while($data=mysqli_fetch_object($details_query)){
					?>
						<tr>
							<td><?php echo $data->payment_method;?></td>
							<td><?php echo find_a_field('accounts_ledger','ledger_name','ledger_id="'.$data->dr_ledger_id.'"')." Taka- ".$data->payment_amt;?></td>
							<td><?php echo "<span style='font-weight:bold;'>Check No: </span>".$data->cheque_no."<span style='font-weight:bold;'>  Check Date  </span>".$data->cheque_date."<span style='font-weight:bold;'>  Party Bank: </span>".$data->of_bank;?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</td>
			</tr>
			<?php 
			$inv_amount_sum+=$inv_amount;
			$paid_amount_sum+=$paid_amount;
			$due_amount_sum+=$due_amt;
			
			} ?>
			<tr>
				<th colspan="3" style="text-align:right;">Total</th>
				<th><?php echo number_format($inv_amount_sum,2);?></th>
				<th><?php echo number_format($paid_amount_sum,2);?></th>
				<th><?php echo number_format($due_amount_sum,2);?></th>
				<th></th>
			</tr>
		</tbody>
	 </table>  
	 
	 
	    
</div>


<div class="jumbotron">
	<div class="col-md-12">
		<table class="table table-bordered">
		<?php 
		$opening_balance_placed_by_golden=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$_POST['dealer_acc_code'].'" and tr_from="Opening"');
		$opening_balance_before_date=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$_POST['dealer_acc_code'].'" and jv_date <"'.$_POST['fdate'].'" ');
		if($opening_balance_before_date>0){
		$opening_balance=$opening_balance_before_date;
		}
		else{
		$opening_balance=$opening_balance_placed_by_golden;
		}
		$advance_receive_without_invoice=find_a_field('journal','sum(cr_amt)','ledger_id="'.$_POST['dealer_acc_code'].'" and jv_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" and tr_no not in(select receipt_no from receipt_from_customer where receipt_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'") and tr_from!="Opening"');
		//echo 'select sum(dr_amt) from journal where ledger_id="'.$_POST['dealer_acc_code'].'" and jv_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" and tr_no not in(select tr_no from receipt_from_customer where receipt_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'")';
		?>
		
			<thead>
				<tr>
					<th>Opening Balance=<?php echo $opening_balance;?></th>
					<th>Total Advance Receive(Without Invoice)=<?php echo $advance_receive_without_invoice;?></th>
					<th>Total Invoice Wise Receive=<?php echo $paid_amount_sum;?></th>
					<th style="color:red;">Total Balance=<?php echo $total_sum= (($opening_balance+$inv_amount_sum)-($advance_receive_without_invoice+$paid_amount_sum));
					if($total_sum>0){echo "(Dr)";}else{echo "(Cr)";}
					?></th>
				</tr>
			</thead>
		</table>
	</div>
</div>

</body>
</html>

 