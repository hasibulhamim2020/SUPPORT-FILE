<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Challan Details';
do_calander('#fdate');
do_calander('#tdate');


$challan= $_REQUEST['v_no'];
$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

$invoice_edit_per=find_a_field('user_roll_activity','edit','page_id=431 and user_id="'.$_SESSION['user']['id'].'"');
$sql='select m.do_no,m.vat,m.vat_amt_tk

from sale_do_master m,sale_do_chalan c

where m.do_no=c.do_no and c.chalan_no="'.$challan.'" ';

$query=db_query($sql);
$data5=mysqli_fetch_object($query);

 $sql1='SELECT s.chalan_no,s.dealer_code,s.chalan_date,d.dealer_name_e,d.dealer_code,d.address_e,d.email,d.contact_no,d.contact_person_name,d.contact_person_designation,s.do_no,m.po_no,m.po_date from sale_do_chalan s,dealer_info d,sale_do_master m where s.do_no=m.do_no and s.chalan_no="'.$challan.'" and s.dealer_code=d.dealer_code limit 1 ';
	  
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
	 <title>Invoice</title>

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
document.getElementById('pr12').style.display='none';

window.print();
}

function print_pad(){
document.getElementById('pr').style.display='none';
document.getElementById('pr1').style.display='none';
document.getElementById('pr12').style.display='none';
document.getElementById('header3').style.display='none';
document.getElementById("top_margin").style.marginTop = "80px";
window.print();
}



</script>
  </head>
  <body>
    
	<div class="container-fluid">
	
	  <div class="row justify-content-center">
          <div class="col-12" id="header3">
             <div class="company-title">
              <div class="d-flex justify-content-around">
                <div class="d-flex align-items-center">
					<h4> <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png"/></h4>
                </div>
                <div class="company-header">
                  <h2 class="text-uppercase text-center" style="font-family:Tahoma;font-size: 20px;font-weight: bold;"><?=$group_data->group_name?></h2>
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
              <button class="btn btn-default outline border rounded-pill border border-dark  text-black"><h4>Invoice</h4></button>
            </div>
			    
				 
				 <div class="row">
			     <div class="col-6"> <button type="button" class="btn btn-success" id="pr"  onClick="print_cus()">Print</button> 
				 <button type="button" class="btn btn-success" id="pr1"  onClick="print_pad()"> Pad Print</button>
				 <?php 
				 if($invoice_edit_per>0){
				 ?>
				  <a href="invoice_edit.php?v_no=<?=$data->chalan_no;?>"><button type="button" class="btn btn-success" id="pr12"> Edit Invoice</button></a>
				  <?php } ?>
				  <span id="pr12" ></span>
				 </div>
				 <div class="col-6"><p style="float:right">Reporting Time: <?=date("h:i A d-m-Y")?></p></div>
				 </div>
	
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



			<!--<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO NO</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$data->po_no;?>">
			</div>-->


<!--			<div class="input-group mb-3 input-group-sm">-->
<!--			  <div class="input-group-prepend">-->
<!--				<span class="input-group-text" style="font-weight:bold;">Customer ID</span>-->
<!--			  </div>-->
<!--			  <input type="text" class="form-control" readonly="readonly"  value="--><?//=$data->dealer_code?><!--">-->
<!--			</div>-->


			
				

			
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">E-Mail</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->email?>" >
			</div>
			
			
		  </div>
		  
		  
			<div class="col-6">

				<div class="input-group mb-3 input-group-sm">
					<div class="input-group-prepend">
						<span class="input-group-text"  style="font-weight:bold;">Invoice NO</span>
					</div>
					<input type="text" class="form-control" readonly="readonly" value="<?=$data->chalan_no;?>">
				</div>

			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Invoice Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php 
			  echo  $newDate = date("d-m-Y", strtotime($data->chalan_date));
			 ?> ">
			</div>
				<div class="input-group mb-3 input-group-sm" style="display:none;">
					<div class="input-group-prepend">
						<span class="input-group-text"  style="font-weight:bold;">SO NO</span>
					</div>
					<input type="text" class="form-control" readonly="readonly"  value="<?=$data->do_no?>" >
				</div>

			<!--<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php 
			  if( $data->po_date> 1){
			  	 // echo  $newDate2 = date("d-m-Y", strtotime($data->po_date));
				  }
			  ?> ">
			</div>-->

			<div class="input-group mb-3 input-group-sm" style="display:none;">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">SO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?php $do_date=find_a_field('sale_do_master','do_date','do_no="'.$data->do_no.'"');
			   echo  $newDate3 = date("d-m-Y", strtotime($do_date));
			  ?>" >
			</div>

			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO NO.</span>
			  </div>

			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->po_no;?>" >
			</div>


			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO Date.</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?php echo  $newDate4 = date("d-m-Y", strtotime($data->po_date));?>" >
			</div>




			<!--<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Due Maturity Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?php $bill_maturity_date=$data->bill_maturity_date;
			     $newDate33 = date("d-m-Y", strtotime($bill_maturity_date));
				 if($bill_maturity_date>0){
				 echo $newDate33;
				 }
				 else{
				 echo "0000-00-00";
				 }
			  ?>" >
			</div>-->

			
<!--			<div class="input-group mb-3 input-group-sm">-->
<!--			  <div class="input-group-prepend">-->
<!--				<span class="input-group-text"  style="font-weight:bold;">Contact Person Designation</span>-->
<!--			  </div>-->
<!--			  <input type="text" class="form-control" readonly="readonly"  value="--><?//=$data->contact_person_designation?><!--" >-->
<!--			</div>-->


			
			<!--<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">VAT Chalan NO</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"   value="<?=$data->vat_challan?>" >
			</div>-->
			
			
				
			
			</div>
  </div>
 
<!--<div class="info">
      <div class="left">
            <div class="name fw-bold">
            Invoice NO <br>
			SO NO<br>
            Date <br><br>
           Customer Id<br>
            Customer Name <br>
            Address <br>
            Contact Person<br>
			PO NO<br>
			PO Date<br>
            Design & Department <br>
            Cell NO <br>
            E-Mail
            </div>
 <?php 
    $sql='SELECT  s.chalan_no,s.dealer_code,s.chalan_date,d.dealer_name_e,d.address_e,d.mobile_no,d.contact_person,d.email
	
	from sale_do_chalan s,dealer_info d
	
	where s.chalan_no="'.$challan.'" and s.dealer_code=d.dealer_code limit 1 ';     
            $query=db_query($sql);

while($data = mysqli_fetch_object($query)){
            ?>
          <div class="dta ">
          : <?=$data->chalan_no;?> <br>
		  : <br>
          : <?=$data->chalan_date;?> <br><br>
          : <?=$data->dealer_code;?> <br>
          : <?=$data->dealer_name_e;?> <br>
          : <?=$data->address_e;?> <br>
          : <?=$data->contact_person;?> <br>
		  : <br>
		  : <br>
          : MIS<br>
          : <?=$data->mobile_no;?> <br>
          : <?=$data->email;?>
          </div>
		  </div><?php } ?>
		  <div class="right">
           <!-- <div class="name  fw-bold"><br><br><br><br>
            PO Ref<br>
            P.O Date:<br>
            <br>
            MB No <br>
            MB Date
            </div>
            <div class="data"><br><br><br><br>
            : 12352353245345 <br>
            : 03-05-21 <br><br>
            : 234234 <br>
            : 04-04-21
            </div>
      </div>
      </div>-->
      



<!--<h4 class="text-center"><u>Invoice</u></h4>-->




  <div class="row" style="margin:0 auto;">
  	<table class="table table-bordered table-sm">
  <thead>
    <tr style="text-align:center;">
      <th >Challan Date</th>
      <th >Challan NO</th>
   <!--   <th>Product Code</th>-->
      <th>Description of Product</th>
		<th>UOM</th>
    
      <th>Qty</th>
      <th>Unit Price</th>
      <th>Amount(BDT)</th>
      <th>Remarks</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $sql='SELECT s.chalan_no,s.item_id,s.dealer_code,s.unit_price,s.total_unit,s.total_amt,s.chalan_date,s.dealer_code,i.item_name,i.unit_name,i.pack_size,i.secondary_unit_quantity,i.secondary_unit_name,s.do_no 
from sale_do_chalan s,item_info i
where s.chalan_no="'.$challan.'" and s.item_id=i.item_id
';
$query=db_query($sql);

while($data = mysqli_fetch_object($query)){

?>
    <tr class="text-center">
      <td style="text-align:left;"><?= $data->chalan_date; ?></td>
      <td style="text-align:left;"><?=$data->chalan_no; ?></td>
    <!--  <td style="text-align:left;"><?=find_a_field('item_info','finish_goods_code','item_id='.$data->item_id); ?></td>-->
      <td style="text-align:left;"><?=$data->item_name;?></td>
		<td style="text-align:right;"><?=$data->unit_name;?></td>
       

      <td style="text-align:right;">

		  <?
		 
		  $total_weight_Qty = $data->total_unit;
		  ?>
		  <?=number_format($total_weight_Qty,2);?>

	  </td>


      <td style="text-align:right;"><?=$data->unit_price;?></td>
      <td style="text-align:right"><?=$total=$data->total_amt;?></td>
      <td></td>
    </tr>
   <? $total1 =$total1+$total; 
   $tot_qty+=$data->total_unit;
  $cost=$data->transport_cost;
  $vat_amt=$data->vat_amount;
  $cash_discount=$data->cash_discount;
 $vat=find_a_field('sale_do_master','vat','do_no="'.$data->do_no.'"');
    // $vat=$data->vat_amount;
	$grand_total_weight= $grand_total_weight + $total_weight_Qty;
   ?> 
    <?php } ?>
<tr class="text-center">
<td colspan="3" style="text-align:left;font-weight:bold;">Sub Total</td>
<td></td>
<td style="text-align:right;font-weight:bold;"><?=number_format($tot_qty,2);?></td>
 


<td></td>
<td style="text-align:right;font-weight:bold;"><?php echo number_format($total1,2); ?></td>
<td></td>
</tr>
<?php 
if($vat>0){
?>
<tr class="text-center">
<td colspan="3" style="font-weight:bold;text-align:left;">VAT Amount <b>(<? if( $vat>0){ echo number_format($vat,0);echo '%'; }?>)</b></td>
<!--<td colspan="4" style="font-weight:bold;text-align:left;">VAT Amount </td>-->
</td><td></td><td></td><td></td>
<td style="text-align:right;font-weight:bold;"><?php
if( $vat>0){
$vat_amt=($total1*$vat)/100;
echo  number_format( $vat_amt,2);
}



 ?></td>
<td></td>
</tr>
<?php } else if($vat_amt>0){?>
<tr class="text-center">
<!--<td colspan="4" style="font-weight:bold;text-align:left;">VAT Amount <b>(<? if( $vat>0){ echo number_format($vat,0);echo '%'; }?>)</b></td>-->
<td colspan="3" style="font-weight:bold;text-align:left;">VAT Amount </td>
</td><td></td><td></td><td></td>
<td style="text-align:right;font-weight:bold;"><?php
if( $vat_amt>0){
//$vat_amt=($total1*$vat)/100;
echo  number_format( $vat_amt,2);
}



 ?></td>
<td></td>
</tr>
<?php 
}
if($cost>0){
?>
<tr class="text-center">
<td colspan="3" style="text-align:left;font-weight:bold;" >Transportation Expences</td></td><td></td><td></td><td></td>
<td style="text-align:right;font-weight:bold;"><?php echo number_format($cost,2); ?></td>
<td></td>
</tr>
<?php } ?>
<?php 
if($cash_discount>0){
?>
<tr class="text-center">
<td colspan="3" style="text-align:left;font-weight:bold;"> Cash Discount </td></td><td></td><td></td><td></td>
<td style="text-align:right;font-weight:bold;"><?php echo $cash_discount; ?></td>
<td></td>
</tr>
<?php } ?>
<tr class="text-center">
<td colspan="3" style="text-align:left;font-weight:bold;">Gross Total</td></td><td></td><td></td><td></td>
<td style="font-weight:bold;text-align:right"><?php echo number_format($all_amt=($vat_amt+$total1+$cost)-$cash_discount,2); ?></td>
<td></td>
</tr>
   
  </tbody>
</table> 
</div>

<br>
  <b>In Word: </b>  <span class="text-capitalize">		  
		<?php $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

                 echo $f->format($all_amt);?> Taka Only.
</span>
<br><br><br>





<?php
if(isset($_POST['check'])){
$val='yes';
$up_sql="update sale_do_chalan set invoice_check='".$val."',check_inv_by='".$_SESSION['user']['id']."' where 	chalan_no='".$challan."' ";
db_query($up_sql);
}
if(isset($_POST['approve'])){
$val='yes';
$up_sql="update sale_do_chalan set approve_status='".$val."',check_appr_by='".$_SESSION['user']['id']."' where 	chalan_no='".$challan."'";
db_query($up_sql);

$sec_hit_check=find_a_field('secondary_journal','count(id)','tr_no="'.$challan.'" and tr_from="Sales" '); 
if($sec_hit_check<1){
auto_insert_sales_chalan_secoundary($challan);
}

}
 ?>
<form action="" method="post">
<div class="row">
	<div class="col-4"></div>

	<div class="col-4">
	<?php 
	$all_appro=find_all_field('sale_do_chalan','','chalan_no="'.$challan.'"');
	$check_sta=find_a_field('sale_do_chalan','invoice_check','chalan_no="'.$challan.'"');
	$appro_sta=find_a_field('sale_do_chalan','approve_status','chalan_no="'.$challan.'"');

				if($check_sta!='yes'){
					
					if($_SESSION['user']['id']==10095 || $_SESSION['user']['id']==10115 || $_SESSION['user']['id']==1 || $_SESSION['user']['id']==2 || $_SESSION['user']['id']==10115 || $_SESSION['user']['id']==10102 || $_SESSION['user']['id']==10101 || $_SESSION['user']['id']==10044){
				?>
				<input class="btn btn-info" style="color:white;"  type="submit" name="check" value="Check">
				<?php } } 
				else{
				if($appro_sta!='yes'){
				if($_SESSION['user']['id']==10100 || $_SESSION['user']['id']==10140 || $_SESSION['user']['id']==1 || $_SESSION['user']['id']==2 || $_SESSION['user']['id']==10134 || $_SESSION['user']['id']==10096){
				?>
				<input class="btn btn-Primary" style="color:white;" type="submit" name="approve" value="Approve">
				<?php } }} ?>
	</div>
		<div class="col-4"></div>
</div>
</form>

<div class="row">
              <!--<div class="col-1"></div>
              <div class="col-3 text-center">
                <br>
				<b>&nbsp;</b>
               <p style="border-top:1px solid">  Received By  </p>
                
              </div>
			 

			  
			  <div class="col-1"></div>
              <div class="col-3 text-center">
               
                <br>
				<b><?php echo find_a_field('user_activity_management','fname','user_id='.$all_appro->check_inv_by); ?></b>
                 <p style="border-top:1px solid">Checked By  </p>
                
              </div>
			  
			  
              <div class="col-1"></div>
              <div class="col-3 text-center">
               
               <br>
			   <b><?php echo find_a_field('user_activity_management','fname','user_id='.$all_appro->check_appr_by); ?></b>
                <p style="border-top:1px solid">Approved By  </p>
               
             </div>-->
			  
			  
			  
			  
			  <table width="100%" >

      <tr style="border:0px solid;">

   

		<td align="center" valign="bottom"  style="border:0px solid; width: 15%;"><div style="border-bottom:1px solid black;width:90%;"><b><?php  find_a_field('user_activity_management','fname','user_id='.$all_appro->check_inv_by); ?></b></div></td>
<td style="border:0px solid; width: 18%;"></td>

        <td align="center" valign="bottom"  style="border:0px solid; width: 15%;"><div style="border-bottom:1px solid black;width:90%;"><b><?php echo find_a_field('user_activity_management','fname','user_id='.$all_appro->check_inv_by); ?></b></div></td>
		<td style="border:0px solid; width: 18%;"></td>

		<td align="center" valign="bottom"  style="border:0px solid; width: 15%;"><div style="border-bottom:1px solid black;width:90%;"><b>
		<?php /*?><?php echo find_a_field('user_activity_management','fname','user_id='.$all_appro->check_appr_by); ?><?php */?></b>
		<img src="md_sign.PNG" width="150px" height="100px" >
		</div></td>

      </tr>

      <tr  style="border:0px solid;">

	     


        <td  style="border:0px solid; width: 15%;"><div align="center">Received By</div></td>
<td style="border:0px solid; width: 18%;"></td>


        <td style="border:0px solid; width: 15%;"><div align="center">Checked By</div></td>
		<td style="border:0px solid; width: 18%;"></td>

		<td style="border:0px solid; width: 15%;"><div align="center">Approved By</div></td>

      </tr>

    </table>
			  
          </div>

<div>
<!--<p>This is Computer generated invoice no signature required</p>-->

</div>

</div>


  </body>
</html>

</div>