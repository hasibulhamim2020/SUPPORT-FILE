<?
session_start();

//====================== EOF ===================


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

 
 $do_no= $_GET['do_no'];
 $company_name=find_a_field('project_info','proj_name','1');
 $all_details=find_all_field('sale_do_master','*','do_no="'.$do_no.'"');
 $discount=$all_details->discount;
 $vat=$all_details->vat;
?>





<link rel="stylesheet" href="style.css" media="all" />

<link rel="stylesheet" href="custom.css" media="all" />





<link href="bootstrap/font-awesome.min.css" rel="stylesheet">



<link href="bootstrap/bootstrap.min.css" rel="stylesheet">



<div class="container bootstrap snippets bootdeys">







<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Sales Order</title>



</head>

<body>

<div class="wrapper">

  <!-- Main content -->

    <!-- title row -->

    <div class="row">
	
		   <div class="col-md-6" align="left">

					<h4 class="text-left"><?php echo $company_name; ?></h4>

				</div>


		<div class="col-md-6" align="right">

						<h3 class="marginright"><b>Sales Order</b></h3>
						

			    </div>

    </div>
	<hr>

    <!-- info row -->

    <div class="row invoice-info">

      <div class="col-md-4 invoice-col" align="justify"><br>



      </div>

      <!-- /.col -->

      <div class="col-md-4 invoice-col" align="center">

      

      </div>

      <!-- /.col -->

      <div class="col-md-4 invoice-col" align="right">

         <b>DO NO:  </b><?=$all_details->do_no;?><br>

		 <b>Wo date: </b><?=$all_details->do_date?><br>

        <b>Department: </b> Sales Team<br>

        <b>Party Name: </b><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$all_details->dealer_code);?>

      </div>

      <!-- /.col -->

    </div>

   <br>

    <!-- Table row -->

    <div class="row">

      <div class="col-12 table-responsive">

        <table class="table table-bordered table-sm">

          <thead>

          <tr class="table-primary">
		
			<th>Item Name</th>
				<th>Item Price</th>
				<th>Quantity</th>
				<th>Conversion Rate </th>
				<th>USD Amount </th>
				<th>BDT Amount</th>
			</tr>
          </thead>

          <tbody>

		<?php 
		 $sql="select * from sale_do_details where do_no='".$do_no."'";
		$query=db_query($sql);
		$vat_amt_tk=find_a_field('sale_do_master','vat_amt_tk','do_no="'.$do_no.'"');
		while($data=mysqli_fetch_object($query)){
		$fg_v_code=find_a_field('item_info','volt_code','item_id='.$data->item_id);
		?>
			<tr>

			<td><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"');?></td>
				<td><?=$data->unit_price;?></td>
				<td><?=$data->total_unit?></td>
				<td><?=$conversion_rate=find_a_field('sale_do_master','conversion_rate','do_no="'.$do_no.'"');?></td>
				<td><? $usd_amt=($data->total_amt/$conversion_rate); echo '$'.number_format($usd_amt,2); $total_usd+=$usd_amt;?></td>
				<td><?=$data->total_amt?></td>
			</tr>
		  

<?php 
			$total_qty+=$data->total_unit;
			$total_amt+=$data->total_amt;
			 } ?>
			<tr>
				<td colspan="2"><strong>Total</strong></td>
				<td style="font-weight:bold;"> <?=$total_qty?></td>
				<td style="font-weight:bold;">&nbsp;</td>
				<td style="font-weight:bold;"><? echo '$'.number_format($total_usd,2);?></td>
				<td style="font-weight:bold;"> <?=$total_amt?></td>
			</tr>
				<tr>
				<td colspan="3"><strong>Discount</strong></td>
		
				<td style="font-weight:bold;">&nbsp;</td>
				<td style="font-weight:bold;">&nbsp;</td>
				<td style="font-weight:bold;"> <?=$disc_amt=(($total_amt*$discount)/100)."  (".$discount."%  )";?></td>
			</tr>
				<tr>
				<td colspan="3"><strong>VAT</strong></td>
		
				<td style="font-weight:bold;">&nbsp;</td>
				<td style="font-weight:bold;">&nbsp;</td>
				<td style="font-weight:bold;"> <? if($vat>0) { echo $vat_amt=(($total_amt*$vat)/100)."  (".$vat."%)";} else{ echo $vat_amt= $vat_amt_tk."  (taka)";}
				
				?></td>
			</tr>
				<tr>
				<td colspan="3"><strong> Total Payable</strong></td>
		
				<td style="font-weight:bold;">&nbsp;</td>
				<td style="font-weight:bold;">&nbsp;</td>
				<td style="font-weight:bold;"> <?=($total_amt+$vat_amt)-$disc_amt?></td>
			</tr>
          </tbody>
        </table>

		

		<!--<p class="lead">Amount Due 2/22/2014</p>-->

		

		

      </div>

      <!-- /.col -->

    </div>

    <!-- /.row -->

	

	</br>

	

	

	<div class="row">

      <!-- accepted payments column -->

      <div class="col-12">

  <div class="card-body">



<!--    <p class="card-text">1. All Goods are received in a good condition as per work order & LC Terms</p>

    <p class="card-text">2. Claims for short receive, damage not approved quality goods delivery must be advised in writing with in three (3) days after delivery</p>-->

  </div>

</div>



</div>







</div>





	 <br>

 

 



<div class="row">

 <div class="col">

 <span>&nbsp;&nbsp;&nbsp;<?=$prepared_by?></span><br><span>..............................................</span><br><span> <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepared by</b></span>

<!-- <dl>

  <dt>Name:</dt>

  <dt>Designation</dt>

  <dt>Cell No:</dt>

</dl>-->

 

 </div>

 

 

 



 <div class="col" align="right">  

 <span>..........................</span><br><span><b> &nbsp;&nbsp;&nbsp;Approved By </b></span>

<!--  <dl>

  <dt>Name:</dt>

  <dt>Designation</dt>

  <dt>Cell No:</dt>

</dl>-->

 </div>

 



</div>

	

	

	<br><br><br>

	

	     <div class="col-12">

 <div class="card bg-light mb-3" style="max-width: 45rem;">

  <div class="card-header">Other comments or special instructions as per approval sample must be attached</div>



</div>



</div>

		 

		 

		 

	<br><br>

	





	

	



    <!--<div class="row">-->

      <!-- accepted payments column -->

      <!--<div class="col-6">

 <div class="card text-white bg-info mb-6" style="max-width: 42rem;">

  <div class="card-header">Other Comments or Special Instructions</div>

  <div class="card-body">

    <h5 class="card-title">1.All Goods are received in a good condition as per work order & lc terms</h5>

    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>

  </div>

</div>



      </div>-->

      <!-- /.col -->

      <!--<div class="col-6">

	  

        <p class="lead">Amount Due 2/22/2014</p>



        <div class="table-responsive">

          <table class="table">

            <tr>

              <th style="width:50%">Subtotal:</th>

              <td>$250.30</td>

            </tr>

            <tr>

              <th>Tax (9.3%)</th>

              <td>$10.34</td>

            </tr>

            <tr>

              <th>Shipping:</th>

              <td>$5.80</td>

            </tr>

            <tr>

              <th>Total:</th>

              <td>$265.24</td>

            </tr>

          </table>

        </div>

      </div>-->

      <!-- /.col -->

    <!--</div>-->

    <!-- /.row -->

  <!-- /.content -->

</div>

<!-- ./wrapper -->



</div>



<!--<script type="text/javascript"> 

  window.addEventListener("load", window.print());

</script>-->

</body>

</html>

