<?
session_start();
require_once "../../../../engine/tools/check.php";
require_once "../../../../engine/configure/db_connect.php";
require_once "../../../../engine/tools/my.php";
require_once "../../../../engine/tools/report.class.php";
date_default_timezone_set('Asia/Dhaka');

?>

<? 
  $wo_id = $_REQUEST['wo_id'];
  //item details query //
 $sql1="select b.wo_id,a.vendor_id,date_format(a.deadline,'%d-%b-%y') as deadline_date,a.invoice_no,date_format(a.wo_date,'%d-%b-%y') as do_date,a.buyer_id,a.workorder_type,a.wo_subject,
 b.qty as d_qty,b.specification,b.meassurment,b.item_id,b.style_no,a.id,a.buyer,a.attention,b.brand,a.buyer_id_new,a.file_no,a.order_type,a.delivery_priority,date_format(a.delivery_req_date,'%d-%b-%y') as delivery_req_date,a.customer_order_no,a.prepared_by,a.customer_file_no,date_format(a.booking_date,'%d-%b-%y') as booking_date,a.quality,a.finishing_type,a.month,a.date,a.year,b.asrate
from 
lc_workorder a,
lc_workorder_details b
where b.wo_id=a.id and b.wo_id=".$wo_id." order by b.id asc";

$data1=db_query($sql1);
$pi=0;
$total=0;


while($info=mysqli_fetch_array($data1)){ 


$pi++;
$buyer_id = $info['buyer_id'];
$workorder_type=$info['workorder_type'];
$workorder_for=$info['wo_subject'];
$ch_date=$info[0];
$month=$info['month'];
$date=$info['date'];
$year=$info['year'];
$for=$info[1];
$quality=$info['quality'];
$rate[]=$info['asrate'];
$item_code[]=$info['item_id'];
$item_id[]=find_a_field('item_info','item_name','item_id='.$info['item_id']);
$measurements[]=$info['meassurment'];
$specification[]=$info['specification'];
$style_no[]=$info['style_no'];
$finishing_type=$info['finishing_type'];
$buyer=$info['buyer'];
$vendor=find_a_field('vendor','vendor_name','vendor_id='.$info['vendor_id']);
$vendor_address=find_a_field('vendor','address','vendor_id='.$info['vendor_id']);
$attention=$info['attention'];
$brand_name[]=$info['brand'];
$buyer_name=find_a_field('buyer_manage_new','buyer_Name_new','buyer_id_new='.$info['buyer_id_new']);
$customer_name=$info['buyer_id'];
$fm_file_no=$info['file_no'];
$order_type=$info['order_type'];
$delivery_priority=$info['delivery_priority'];
$delivery_req_date=$info['delivery_req_date'];
$customer_order_no=$info['customer_order_no'];
$do_date=$info['do_date'];
$prepared_by=find_a_field('user_activity_management','fname','user_id='.$info['prepared_by']);
$customer_file_ref_no=$info['customer_file_no'];
$file_rcv_date=$info['booking_date'];
$sl[]=$pi;
$tqty[]=$info[3];
$amount[]=$info[3];
$total=$total+($info[2]);
$totalt=$totalt+($info[3]);
$undelqty=$info[3]-$info[2];
$total_order_qty[]=$info['d_qty'];
$woid=$info[10];
$delivery_man = $info[11];
$delivery_place = $info[12];
$unit[]=find_a_field('item_info', 'unit_name','item_id='.$info[8]);
$ch_no=$_GET['v_no']-1;
$grand_total=$grand_total+($info['d_qty']);
$specid=$info[4];
$del_qty[] = find_a_field('lc_workorder_chalan', 'sum(qty)','specification_id="'.$info[4].'" and chalan_no < "'.$_GET['v_no'].'" group by specification_id ');
$balance=$tqty[$i]-($qty[$i]+$del_qty[$i]);
$totalbalance=$totalbalance+$balance;
$total_prev_qty=$total_prev_qty+find_a_field('lc_workorder_chalan', 'sum(qty)','specification_id="'.$info[4].'" and chalan_no < "'.$_GET['v_no'].'" group by specification_id ');
}







  



  



  



  



  



  



///information query//







?>









<!--<script src="bootstrap/bootstrap.min.js"></script>

<script src="bootstrap/jquery.min.js"></script>-->



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

  <title>Invoice Print</title>



</head>

<body>

<div class="wrapper">

  <!-- Main content -->

  <section class="invoice">

    <!-- title row -->

    <div class="row">

      

	

	  

	   <div class="col-md-4 top-left" id="logo">

					<img src="logo.png" class="rounded float-start" data-holder-rendered="true">

				</div>

		

		<div class="col-sm-2 top-right" id="logo">

					<img src="oke.png" class="rounded float-start" data-holder-rendered="true">

			    </div>

				

				<div class="col-sm-2 top-right" id="logo">

					<img src="logo2.png" class="rounded float-start" data-holder-rendered="true">

			    </div>

		

		<div class="col-md-4 top-right">

						<h3 class="marginright"><b>SPIL Work Order</b></h3>

						<small><b>Work Order Type :  <?=$workorder_type?></b></small>

						

			    </div>

      <!-- /.col -->

    </div>

    <!-- info row -->

    <div class="row invoice-info">

      <div class="col-md-4 invoice-col" align="justify"><br>

      <address>

	      Street Address: <small> Plot # 98 Road # 05 Block # D, Vhatulia, Kamarpara</small><br>

         City.ST.ZIP :  <small> Turag, Dhaka-1230, Bangladesh</small><br>

          Phone :  <small> +88-02-8981215, +8801707082301-10</small><br>

        Email Address :  <small> info@spilaccessories.com</small><br>

      Web Address :  <small> www.spilaccessories.com</small>

        </address>

      </div>

      <!-- /.col -->

      <div class="col-md-4 invoice-col" align="center">

      <address>

   <br><br><br>

          <b>Buyer: </b><?=find_a_field('lc_brand_buyer','brand_buyer_name','id='.$buyer);?><br> 

        </address>

      </div>

      <!-- /.col -->

      <div class="col-md-4 invoice-col top-right">


	    <small><b>Work Order For:</b> <?=$workorder_for?></small><br>

         <b>SPIL W.O.#:</b> <?=$wo_id?><br>

		 <b>Wo date:</b> <?=$do_date?><br>

        <b>Department:</b> Sales Team<br>

        <b>Customer ID: </b>  <!--89578957-->

      </div>

      <!-- /.col -->

    </div>

    <!-- /.row -->

	

	

	      <!--  <div class="row">

			<div class="col-md-6" style=" background-color:#563D7C; color:#FFFFFF">BILL TO</div>

			<div class="col-md-6 top-right" style=" background-color:#563D7C; color:#FFFFFF">SHIP TO</div>

			</div>-->

			

			

			

	<div class="row">

      <div class="col-12" style="background-color:#7952B3; color:#fff">

        <h5 class="page-header">SHIPPER/EXPORTER<span class="float-right">RECEIVER/BILL TO </span></h5>

      </div>

    

    </div>

	

 







			

			

			<div class="row">

			<div class="col-md-6">

			 <address>

			                          

                                         [ <strong> SPIL</strong>

                                          <br>Plot # 98 Road # 05 Block # D, Vhatulia, Kamarpara

                                          <br>Phone: +88-02-8981215, +8801707082301-10

                                          <br>Email: info@spilaccessories.com

                                     ] </address>

			

			</div>

			<div class="col-md-6 top-right">

			                             <address>

                                         [ <strong><?=find_a_field('lc_buyer','buyer_name','id='.$buyer_id);?></strong>

                                          <br><?=find_a_field('lc_buyer','address','id='.$buyer_id);?>

                                          <br>Phone: <?=find_a_field('lc_buyer','contact_person_cell','id='.$buyer_id);?> 

                                          <br>Email: <?=find_a_field('lc_buyer','contact_email','id='.$buyer_id);?> 

                                     ] </address>

                     

			

			</div>

			</div>



    <!-- Table row -->

    <div class="row">

      <div class="col-12 table-responsive">

        <table class="table table-bordered table-sm">

          <thead>

          <tr class="table-primary">

            <th>SL</th>

			<th>Item Name</th>

            <th>Brand</th>

            <th>Style/Po No</th>

			<th>Size</th>

            <th>Color</th>

            <th>Prod. Qty</th>

            <th>Order Qty</th>

            <th>Note</th>

          </tr>

          </thead>

          <tbody>

		  

		  

 <? for($i=0;$i<$pi;$i++){ ?>

          <tr>

            <td><?=$sl[$i];?></td>

            <td><?=$item_id[$i];?></td>

            <td><?=find_a_field('lc_brand','brand_name','id='.$brand_name[$i]);?></td>

            <td><?=$style_no[$i];?></td>

            <td><?=$specification[$i];?></td>

			<td><?=$measurements[$i];?></td>

            <td></td>

            <td><?=$total_order_qty[$i];?></td>

            <td></td>

          </tr>

		  

<? 



$TOTAL_ORDER +=$total_order_qty[$i];

//$grandtotaldz+=$totaldz;

//$grandordervalue+=$order_value;

//$total_material_quantity+=$material_quantity;

}



?>



	  

		   <tr>

        <td colspan="7"><div align="right"><strong>TOTAL QTY  : </strong></div></td>

		<td><?=number_format($TOTAL_ORDER);?></td>

		<td></td>

		

      

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

  </section>

  <!-- /.content -->

</div>

<!-- ./wrapper -->



</div>



<!--<script type="text/javascript"> 

  window.addEventListener("load", window.print());

</script>-->

</body>

</html>

