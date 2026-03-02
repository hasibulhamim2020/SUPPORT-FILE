<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Challan Details';
do_calander('#fdate');
do_calander('#tdate');

$challan= $_REQUEST['v_no'];
$do = $_REQUEST['do_no'];
$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

$sql='select * from sale_do_master

where do_no="'.$do.'"';

$query=db_query($sql);
$data5=mysqli_fetch_object($query);

    $sql1='SELECT  s.chalan_no,s.do_no,s.dealer_code,s.chalan_date,d.dealer_name_e,d.dealer_code,d.address_e,d.email,d.contact_no,d.contact_person_name,d.contact_person_designation
	
	from sale_do_chalan s,dealer_info d
	
	where s.chalan_no="'.$challan.'" and s.dealer_code=d.dealer_code limit 1 ';     
$query=db_query($sql1);
$data = mysqli_fetch_object($query);


?>


<!doctype html>
<html lang="en">
  <head>
    
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	 <title>Master Invoice</title>

    <style>
	.mb-3{
margin-bottom:4px!important;
}
.input-group-text{
font-size:12px;
}
      * {
    margin: 0;
    padding: 0;
	font-size:13px;
  }
  p {
    margin: 0;
    padding: 0;
  }
  h1,
  h2,
  h3,
  h4,
  h5,
  h6
   {
    margin: 0 !important;
    padding: 0 !important;
  }
  
  th,tr,th,td{
  border:1px solid;
  }
label{

}

    </style>
    <script>
function print_cus(){
document.getElementById('pr').style.display='none';
document.getElementById('pr1').style.display='none';
document.getElementById('ch_list').style.display='none';
window.print();
}
function print_pad(){
document.getElementById('pr').style.display='none';
document.getElementById('pr1').style.display='none';
document.getElementById('header3').style.display='none';
document.getElementById("top_margin").style.marginTop = "50px";
window.print();
}

</script>
  </head>
  <body> <br>
    
	<div class="container">
	 <div class="row justify-content-center">
          <div class="col-12" id="header3">
             <div class="company-title">
              <div class="d-flex justify-content-around">
                <div class="d-flex align-items-center">
                  <h4> <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png"/></h4>
                </div>
                <div class="company-header">
                  <h2 class="text-uppercase text-center"><?=$group_data->group_name?></h2>
                  <p class="text-center"><?=$group_data->address?></p>
                    <p class="text-center" style="font-size:12px; font-weight:300; color:#000000; margin:0; padding:0;">Phon No. : <?=$group_data->mobile?>,  Email : <?=$group_data->email?></p>
                </div>
                <div class="d-flex align-items-center" style=" width: 200px;">
                  
                </div>
              </div>
            </div><br>
            
			</div>
			</div>
			<div class="text-center" id="top_margin">
              <button class="btn btn-default outline border rounded-pill border border-dark  text-black"><h4>Master Invoice</h4></button>
            </div>
			     <button type="button" class="btn btn-success" id="pr"  onClick="print_cus()">Print</button> 
				 <button type="button" class="btn btn-success" id="pr1"  onClick="print_pad()"> Pad Print</button><br>

 
<div class="row">

		  <div class="col-6">

              <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                      <span class="input-group-text" style="font-weight:bold;">Customer Name</span>
                  </div>
                  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->dealer_name_e?>">
              </div>


              <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                      <span class="input-group-text"  style="font-weight:bold;">Address</span>
                  </div>
                  <!--	  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->address_e;?>"  >-->
                  <textarea  class="form-control"  ><?=$data->address_e;?></textarea>
              </div>


              <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                      <span class="input-group-text"  style="font-weight:bold;">Contact Person</span>
                  </div>
                  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->contact_person_name?>" >
              </div>



              <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                      <span class="input-group-text"  style="font-weight:bold;">Customer Cell NO</span>
                  </div>
                  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->contact_no?>" >
              </div>

              <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                      <span class="input-group-text"  style="font-weight:bold;">E-Mail</span>
                  </div>
                  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->email?>" >
              </div>



			<!--<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text" style="font-weight:bold;">Customer ID</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->dealer_code?>">
			</div>-->

			
				

			
		  </div>
		  
		  
			<div class="col-6">

                <div class="input-group mb-3 input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text"  style="font-weight:bold;">Invoice NO</span>
                    </div>
                    <input type="text" class="form-control" readonly="readonly" value="<?=$data->chalan_no;?>">
                </div>
                <!--<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO NO</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$data->po_no;?>">
			</div>-->

			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Invoice Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php echo  $newDate4 = date("d-m-Y", strtotime($data->chalan_date));?> ">
			</div>
			<!--<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$data->po_date;?> ">
			</div>-->
                <div class="input-group mb-3 input-group-sm" style="display:none;">
                    <div class="input-group-prepend">
                        <span class="input-group-text"  style="font-weight:bold;">SO NO</span>
                    </div>
                    <input type="text" class="form-control" readonly="readonly"  value="<?=$data->do_no?>" >
                </div>

			<div class="input-group mb-3 input-group-sm" style="display:none;">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">SO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?php  $do_date=find_a_field('sale_do_master','do_date','do_no="'.$data->do_no.'"');
              echo  $newDate3 = date("d-m-Y", strtotime($do_date)); ?>">

			</div>


			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO NO.</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data5->po_no?>" >
			</div>

                <div class="input-group mb-3 input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text"  style="font-weight:bold;">PO Date.</span>
                    </div>
                    <input type="text" class="form-control" readonly="readonly"  value="<?php echo  $newDate4 = date("d-m-Y", strtotime($data5->po_date));?> ">
                </div>
			
			
			
			
				
			
			</div>
  </div>
      
	<br>


 <span id="ch_list" style="font-size:12px!important;font-weight:bold;">Invoice No: <?php
 $sql='SELECT s.do_no,s.chalan_no
from sale_do_chalan s,item_info i
where s.do_no="'.$do.'" group by s.chalan_no
';
$query=db_query($sql);

while($data1 = mysqli_fetch_object($query)){
  
?>
<span ><a href="invoice.php?v_no=<?=$data1->chalan_no ?>"><?=$data1->chalan_no?></a>,</span>
<?php
}?>

</span> 

<table class="table table-bordered">
  <thead>
    <tr style="text-align:center;">
	</a>
      <th scope="col">Challan Date</th>
      <th scope="col">Challan NO</th>
      <th scope="col">Product Code</th>
      <th scope="col">Description of Product</th>
      <th scope="col">UOM</th>
      <th scope="col">Quantity</th>


      <th scope="col">Unit Price</th>
	  
      <th scope="col">Amount(Tk)</th>
      <th scope="col">Remarks</th>
    </tr>
  </thead>
  <tbody>
  <?php
 $sql='SELECT s.do_no,s.chalan_no,s.item_id,s.dealer_code,s.unit_price,sum(s.total_unit) as total_unit,sum(s.total_amt) as total_amt,s.chalan_date,s.dealer_code,i.item_name,i.unit_name,i.pack_size,i.secondary_unit_quantity,i.secondary_unit_name
from sale_do_chalan s,item_info i
where s.do_no="'.$do.'" and s.item_id=i.item_id group by s.chalan_no
';
$query=db_query($sql);

while($data = mysqli_fetch_object($query)){

?>
    <tr class="text-center">
      <th scope="row"><?= $data->chalan_date; ?></th>
      <td><?=$data->chalan_no; ?></td>
      <td><?=find_a_field('item_info','finish_goods_code','item_id='.$data->item_id); ?></td>
      <td><?=$data->item_name;?></td>
        <td><?=$data->unit_name;?></td>
     	   <td><?=$final_unit=round($data->total_unit,0);?></td>
	 

      <td><?=number_format($data->unit_price,2);?> </td>

      <td><?=$total=$data->total_amt;?></td>
      <td></td>
    </tr>
   <? $total1 =$total1+$total;
   	$total2 =  $total2+$final_unit;
     $cost=$data->transport_cost;

    $grand_total_weight= $grand_total_weight + $total_weight_Qty;
   ?> 
    <?php } ?>
<tr class="text-center">
<td colspan="4"><div align="center">SubTotal</div></td>
<td></td>
<td><?=$total2?></td>
<td></td>

<td><?=number_format($total1,2);?> </td>
<!--<td>--><?php //echo $total1; ?><!--</td>-->

<td></td>
</tr>
<?php 
if($data5->vat>0){
?>
<tr class="text-center">
<td colspan="4"><center>VAT Amount <b>(<? if( $data5->vat>0){ echo $data5->vat;echo '%'; }?>)</b></center></td>
<td></td>

<td><?php 
if( $data5->vat>0){
echo $vat= ($total1*$data5->vat)/100;
}else{
echo $vat= ($data5->vat_amt_tk);
}



 ?> </td>

<td></td>
</tr>
<?php } ?>
<?php 
if($cost>0){
?>
<tr class="text-center">
<td colspan="4"><center>Transportation Expences</center></td>
</td><td></td>
<td><?php echo number_format($cost,2); ?></td>
<td></td>
</tr>
<?php } ?>
<?php 
if($other_charge>0){
?>
<tr class="text-center">
<td colspan="6"><center>Other Charge/(Discount)</center></td>

<td></td>
<td><?php echo $other_charge; ?></td>
<td></td>
</tr>
<?php } ?>
<tr class="text-center">
<td colspan="4"><center>Gross Total</center></td>
    <td></td>
    <td></td>    <td></td>



<td style="font-weight:bold"><?php echo number_format($all_amt=$vat+$total1+$cost,2); ?></td>
<td></td>
</tr>
   
  </tbody>
</table>
<?php 
$all_appro=find_all_field('sale_do_chalan','','chalan_no="'.$challan.'"');
	$check_sta=find_a_field('sale_do_chalan','invoice_check','chalan_no="'.$challan.'"');
	$appro_sta=find_a_field('sale_do_chalan','approve_status','chalan_no="'.$challan.'"');
?>
 <br>
  <b>Amount In Word: </b>  <span class="text-capitalize">		  
		Taka <?php $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

                 echo $f->format($all_amt);  ?> Only.
</span>
<br><br><br>
<div class="row">
              <div class="col-3 text-center">
               
                <br>
               <p style="border-top:1px solid">  Received By  </p>
                
              </div>
			  <div class="col-1"></div>
              <div class="col-2 text-center">
                <b><?php  echo find_a_field('user_activity_management','fname','user_id='.$all_appro->entry_by); ?></b>
                <br>
               <p style="border-top:1px solid"> Prepared By  </p>
                
              </div>
			  <div class="col-1"></div>
              <div class="col-2 text-center">
               
                <br>
             	<b><?php echo find_a_field('user_activity_management','fname','user_id='.$all_appro->check_inv_by); ?></b>
                 <p style="border-top:1px solid">Checked By  </p>
                
              </div>
              <div class="col-1"></div>
              <div class="col-2 text-center">
               
               <br>
               <b><?php echo find_a_field('user_activity_management','fname','user_id='.$all_appro->check_appr_by); ?></b>
                <p style="border-top:1px solid">Approved By  </p>
               
             </div>
			  
            </div>




</div>
</div>
</div>



  </body>
</html>









