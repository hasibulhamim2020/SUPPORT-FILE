u<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Challan Details';
do_calander('#fdate');
do_calander('#tdate');

 $challan= $_REQUEST['v_no'];
 if(isset($_POST['update'])){
 $vat=$_POST['vat'];
  $transport=$_POST['transport'];
  $discount=$_POST['discount'];
 
////journal delete//
$journal_sql='delete from journal where tr_no="'.$_GET['v_no'].'" and tr_from="Sales"';
db_query($journal_sql);

///secondary journal delete///
$sec_jour_del='delete from secondary_journal where tr_no="'.$_GET['v_no'].'" and tr_from="Sales"';
db_query($sec_jour_del);
///journal Item  delete///
$jour_item_del='delete from journal_item where sr_no="'.$_GET['v_no'].'" and tr_from="Sales"';
db_query($jour_item_del);

$do_no=find_a_field('sale_do_chalan','do_no','where chalan_no="'.$_GET['v_no'].'"');




///update Do///
$sql='select * from sale_do_details where do_no="'.$do_no.'"';
$query=db_query($sql);
while($row=mysqli_fetch_object($query)){
$item_id=$_POST['item_id_'.$row->id];
$unit_price=$_POST['unit_price_'.$row->id];
$tot_amt= $unit_price*$row->total_unit;
$update_dosql='update sale_do_details set unit_price="'.$unit_price.'",total_amt="'.$tot_amt.'" where item_id="'.$item_id.'" and do_no="'.$do_no.'"';
db_query($update_dosql);
}



///update chalan///

$sqlc='select * from sale_do_chalan where chalan_no="'.$_GET['v_no'].'"';
$queryc=db_query($sqlc);
while($row2=mysqli_fetch_object($queryc)){
$item_idc=$_POST['item_id_'.$row2->id];
$unit_pricec=$_POST['unit_price_'.$row2->id];
$tot_amtc=$_POST['tot_amt_id_'.$row2->id];
$update_chsql='update sale_do_chalan set unit_price="'.$unit_pricec.'",total_amt="'.$tot_amtc.'",vat_amount="'.$vat.'",transport_cost="'.$transport.'",cash_discount="'.$discount.'" where item_id="'.$item_idc.'" and chalan_no="'.$row2->chalan_no.'"';
db_query($update_chsql);
///update journal item.//
journal_item_control($row2->item_id,$_SESSION['user']['depot'],$row2->chalan_date,0,$row2->total_unit,'Sales',$row2->id,$unit_pricec,'',$row2->chalan_no,'',$row2->location,'');
}



///rehit secondary journal///
 
		auto_insert_sales_chalan_secoundary($_GET['v_no']);
		//header("Location: invoice_edit.php?v_norr='".$_GET['v_no']."'&edit=2 ");
 
 echo '<h2 style="color:white;text-align:center;font-weight:bold;background-color:green;">Update Successfully</h2>';

}





$sql='select m.do_no,m.vat,m.vat_amt_tk

from sale_do_master m,sale_do_chalan c

where m.do_no=c.do_no and c.chalan_no="'.$challan.'" ';

$query=db_query($sql);
$data5=mysqli_fetch_object($query);

$sql1='SELECT  s.chalan_no,s.dealer_code,s.chalan_date,d.dealer_name_e,d.dealer_code,d.address_e,d.mobile_no,d.contact_person,d.email,s.do_no,m.po_no,m.po_date,s.vat_challan,d.contact_person_inv,d.designation2,s.transport_cost,s.chalan_no_another
	
	from sale_do_chalan s,dealer_info d,sale_do_master m
	
	where s.do_no=m.do_no and s.chalan_no="'.$challan.'" and s.dealer_code=d.dealer_code limit 1 ';   
	  
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

window.print();
}
function print_pad(){
document.getElementById('pr').style.display='none';
document.getElementById('pr1').style.display='none';
document.getElementById('header3').style.display='none';
document.getElementById("top_margin").style.marginTop = "80px";
window.print();
}

function edit_count(id){
	var unt_pri=(document.getElementById('unit_price_'+id).value)*1;
	var unit_qty=(document.getElementById('unit_'+id).value)*1;
	var tot_amt=unit_qty*unt_pri;

	document.getElementById('tot_amt_id_'+id).value=tot_amt;
}
</script>
  </head>
  <body>
    
	<div class="container">
	<?php if($_GET['edit']>0){
	
	echo "<h2 style='text-align:center;color:white;background-color:green;font-weight:bold'>Successfully Updated</h2>";
	}
	
	 ?>
	  <div class="row justify-content-center">
          <div class="col-12" id="header3">
             <div class="company-title">
              <div class="d-flex justify-content-around">
                <div class="d-flex align-items-center">
                  <h4><img style="width:60px;height:55px" src="habib.png"></h4>
                </div>
                <div class="company-header">
                  <h1 class="text-uppercase text-center" style="font-family:Tahoma;"><?php echo find_a_field('project_info','proj_name','1')?></h1>
                  <h5 style="letter-spacing: 2px;" class=" text-black text-capitalize text-center p-1">Quality product at affordable cost</h5>
                  <p class="text-center"><?php echo find_a_field('project_info','proj_address','1')?></p>
  <p class="text-center">Cell: <?php echo "01958 611022";?>. Email: <?php echo find_a_field('project_info','proj_email','1')?><br>www.habibindustries.net</p>
                </div>
                <div class="d-flex align-items-center">
                  
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
				 <button type="button" class="btn btn-success" id="pr1"  onClick="print_pad()"> Pad Print</button></div>
				 <div class="col-6"><p style="float:right">Reporting Time: <?=date("h:i A d-m-Y")?></p></div>
				 </div>
	
<div class="row">

		  <div class="col-6">
		    
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Invoice NO</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$data->chalan_no;?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO NO</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?=$data->po_no;?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">SO NO</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->do_no?>" >
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text" style="font-weight:bold;">Customer ID</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->dealer_code?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text" style="font-weight:bold;">Customer Name</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->dealer_name_e?>">
			</div>
			
				
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Contact Person</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->contact_person_inv?>" >
			</div>
			
			
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
				<span class="input-group-text"  style="font-weight:bold;">Invoice Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php 
			  echo  $newDate = date("d-m-Y", strtotime($data->chalan_date));
			 ?> ">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php 
			  if( $data->po_date> 1){
			  	  echo  $newDate2 = date("d-m-Y", strtotime($data->po_date));
				  }
			  ?> ">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">SO Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?php $do_date=find_a_field('sale_do_master','do_date','do_no="'.$data->do_no.'"');
			   echo  $newDate3 = date("d-m-Y", strtotime($do_date));
			  ?>" >
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
				<span class="input-group-text"  style="font-weight:bold;">Cell NO</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->mobile_no?>" >
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Contact Person Designation</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"  value="<?=$data->designation2?>" >
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">VAT Chalan NO</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly"   value="<?=$data->vat_challan?>" >
			</div>
			
			
				
			
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

<form action="" method="post">


  <div class="row" style="margin:0 auto;">
  	<table class="table table-bordered table-sm">
  <thead>
    <tr style="text-align:center;">
      <th >Challan Date</th>
      <th >Challan NO</th>
      <th>Product Code</th>
      <th>Description of Product</th>
      <th>Quantity</th>
      <th>UOM</th>
      <th>Unit Price</th>
      <th>Amount(BDT)</th>
      <th>Remarks</th>
    </tr>
  </thead>
  <tbody>
  <?php
 $sql='SELECT s.id,s.chalan_no,s.item_id,s.dealer_code,s.unit_price,s.total_unit,s.total_amt,s.chalan_date,s.dealer_code,i.item_name,i.unit_name,s.transport_cost,s.chalan_no_another,s.vat_amount,s.cash_discount 
from sale_do_chalan s,item_info i
where s.chalan_no="'.$challan.'" and s.item_id=i.item_id
';
$query=db_query($sql);

while($data = mysqli_fetch_object($query)){

?>
    <tr class="text-center">
      <td style="text-align:left;"><?= $data->chalan_date; ?></td>
      <td style="text-align:left;"><?=$data->chalan_no_another; ?></td>
      <td style="text-align:left;"><?=find_a_field('item_info','finish_goods_code','item_id='.$data->item_id); ?></td>
      <td style="text-align:left;"><?=$data->item_name;?></td>
      <td style="text-align:right;"><?=number_format($data->total_unit,0);?>
	  <input type="hidden" name="item_id_<?=$data->id?>" id="item_id_<?=$data->id?>" value="<?=$data->item_id;?>"  >
	  <input type="hidden" name="unit_<?=$data->id?>" id="unit_<?=$data->id?>" value="<?=$data->total_unit;?>"  >
	  </td>
      <td style="text-align:right;"><?=$data->unit_name;?></td>
      <td style="text-align:right;"><input type="text" name="unit_price_<?=$data->id?>" id="unit_price_<?=$data->id?>" value="<?=$data->unit_price;?>" onKeyUp="edit_count(<?=$data->id?>)" ></td>
      <td style="text-align:right"> 
	  
	  <input type="text" name="tot_amt_id_<?=$data->id?>" id="tot_amt_id_<?=$data->id?>" value="<?=$total=$data->total_amt;?>">
	  </td>
      <td></td>
    </tr>
   <? $total1 =$total1+$total; 
   $tot_qty+=$data->total_unit;
  $cost=$data->transport_cost;
   $vatamt=$data->vat_amount;
   $discountamt=$data->cash_discount;
   ?> 
    <?php } ?>
	
	<tr>
		<td colspan="7">VAT</td>
		<td><input type="text" name="vat" id="vat" value="<?php echo $vatamt;?>"> </td>
		<td></td>
	</tr>
	<tr>
		<td colspan="7">Transport</td>
		<td><input type="text" name="transport" id="transport" value="<?php echo $cost;?>"> </td>
		<td></td>
	</tr>
	
	<tr>
		<td colspan="7">Discount</td>
		<td><input type="text" name="discount" id="discount" value="<?php echo $discount;?>"> </td>
		<td></td>
	</tr>
	
<!--<tr class="text-center">
<td colspan="4" style="text-align:left;font-weight:bold;">Sub Total</td>
<td style="text-align:right;font-weight:bold;"><?=number_format($tot_qty,0);?></td>
<td></td>
<td></td>
<td style="text-align:right;font-weight:bold;"><?php echo number_format($total1,2); ?></td>
<td></td>
</tr>-->
<?php 
if($data5->vat>0){
?>
<!--<tr class="text-center">
<td colspan="4" style="font-weight:bold;text-align:left;">VAT Amount <b>(<? if( $data5->vat>0){ echo number_format($data5->vat,0);echo '%'; }?>)</b></td>
</td><td></td><td></td><td></td>
<td style="text-align:right;font-weight:bold;">--><?php
if( $data5->vat>0){
echo number_format( $vat=($total1*$data5->vat)/100,2);
}else{
echo  number_format( $vat=($data5->vat_amt_tk),2);
}



 ?><!--</td>
<td></td>
</tr>-->
<?php } ?>
<?php 
if($cost>0){
?>
<!--<tr class="text-center">
<td colspan="4" style="text-align:left;font-weight:bold;" >Transportation Expences</td></td><td></td><td></td><td></td>
<td style="text-align:right"><?php echo number_format($cost,2); ?></td>
<td></td>
</tr>-->
<?php } ?>
<?php 
if($other_charge>0){
?>
<!--<tr class="text-center">
<td colspan="4" style="text-align:left;font-weight:bold;">Other Charge/(Discount)</td></td><td></td><td></td><td></td>
<td style="text-align:right"><?php echo $other_charge; ?></td>
<td></td>
</tr>-->
<?php } ?>
<!--<tr class="text-center">
<td colspan="4" style="text-align:left;font-weight:bold;">Gross Total</td></td><td></td><td></td><td></td>
<td style="font-weight:bold;text-align:right"><?php echo number_format($all_amt=$vat+$total1+$cost,2); ?></td>
<td></td>
</tr>
   -->
  </tbody>
</table> 
</div>

<br>
  <b>In Word: </b>  <span class="text-capitalize">		  
		<?php $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

                 echo $f->format($all_amt);  ?>Taka Only.
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
}
 ?>
		<?php 
		 $sec_hit_check=find_a_field('secondary_journal','count(id)','tr_no="'.$challan.'" and tr_from="Sales" ');   
			if($sec_hit_check>0){
			echo '<h2 style="color:red;font-weight:bold;">"This invoice is already Approved By Accounts.You can not modify this invoice.Please Contact Admin for modification"</h2>';
			}else{
			?>
<div class="row">
	<div class="col-4"></div>

	<div class="col-4">
	<?php 
	$all_appro=find_all_field('sale_do_chalan','','chalan_no="'.$challan.'"');
	$check_sta=find_a_field('sale_do_chalan','invoice_check','chalan_no="'.$challan.'"');
	$appro_sta=find_a_field('sale_do_chalan','approve_status','chalan_no="'.$challan.'"');
				
			?> 
	
			
				<input class="btn btn-info" style="color:white;"  type="submit" name="update" value="Update">
		
	</div>
		<div class="col-4"></div>
</div>
<?php } ?>
</form>
<div class="row">
              <div class="col-4 text-center">
               
                <br>
				<b>&nbsp;</b>
               <p style="border-top:1px solid">  Received By  </p>
                
              </div>
			 
			 <!-- <div class="col-1"></div>
			  <div class="col-2 text-center">
               
                <br>
				<b><?php  echo find_a_field('user_activity_management','fname','user_id='.$all_appro->entry_by); ?></b>
                 <p style="border-top:1px solid">Prepared By  </p>
                
              </div>-->
			  
			  
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
               
             </div>
			  
            </div>



</div>

  </body>
</html>

</div>	<br>







