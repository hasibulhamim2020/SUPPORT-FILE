<?php
 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type ="Show";


$current_page = 'Party Wise Sale Target';
$current_feature = 'Generation';
$title='Party Wise Sale Target';

// do_calander('#fdate');

// do_calander('#tdate');

$table = 'party_wise_sale_target';

$crud   = new crud($table);

if(isset($_POST['submitit'])){
    
  

		$filename=$_FILES["generation_file"]["tmp_name"];
		$ext=end(explode('.',$_FILES["generation_file"]["name"]));
		if($ext=='csv'){
     	if($_FILES["generation_file"]["size"] > 0){
		
		      $file = fopen($filename, "r");
			  $count = 0;
			  while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
			  { 
			  $count++; 
              if($count>1)
			  {

			  
$_POST['dealer_code'] = $getData[0];
$_POST['target_amt'] =$getData[1];
$_POST['month'] = $getData[2];
$_POST['year'] = $getData[3];

$_POST['entry_at']   = date('y-m-d H:i:s');
$_POST['entry_by']   = $_SESSION['user']['id'];


$insertedd = $crud->insert();



if($insertedd){
$message = '<span style="color:green; font-weight:bold">Successfully Uploaded. </span>';
}else{
$message = '<span style="color:red; font-weight:bold">Opps! Try again</span>';
}

} 
 }
 
 
 echo $message;
fclose($file);  
 }
 
 }else{
 echo $message = '<span style="color:red; font-weight:bold">Opps! Invalid Data. Please upload as per system format!</span>';
 }

}





?>

<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz" enctype="multipart/form-data">
  <div class="container-fluid bg-form-titel">
    <div class="row p-3">

      <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center">
			<a href="party_wise_sale_target.csv" download><button type="button" class="btn1 btn1-bg-submit" style=" font-size: 11px; ">Download Example File</button></a>

          </div>

        </div>
		</div>
		
      
      <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
	  <div class="row">
        <div class="form-group row m-0">
          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"><?=$title?> : </label>
          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
            
              <input type="file" name="generation_file" id="generation_file" class="form-control p-1" />
            
          </div>
        
		 
      </div>
      </div>
    </div>
    
   
	
  </div>
  <div class="row">

      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center">
	  <input type="submit" name="submitit" id="submitit" value="UPLOAD" class="btn1 btn1-submit-input"/>
	  </div>
	 </div>
  </form>
  </div>
  
<!--<form action="" method="post" name="codz2" id="codz2" enctype="multipart/form-data">
<table  id="example"  class="table1 table-striped table-bordered table-hover table-sm dataTable">
<thead class="thead1">
<tr class="bgc-info">
 <td>Start Date : <input type="date" name="sfdate" id="sfdate" class="form-control" value="<?=($_POST['sfdate']!='')?$_POST['sfdate']:date('Y-m-d')?>" /></td>
 <td>End Date : <input type="date" name="stdate" id="stdate" class="form-control" value="<?=($_POST['stdate']!='')?$_POST['stdate']:date('Y-m-d')?>" /></td>
 
 <td>ND : <select name="snd_id" id="snd_id">
							 
							<? 
							if($_SESSION['nd_code']==5){
							    echo '<option></option>';
							foreign_relation('national_dealer','nd_id','nd_name',$snd_id,'nd_id!=5');
							}else{
							foreign_relation('national_dealer','nd_id','nd_name',$snd_id,'nd_id="'.$_SESSION['nd_code'].'"');
							}?>
							</select></td>
 <td colspan="4" align="left"><br><input type="submit" name="view" id="view" class="btn2 btn1-bg-update" value="Search" /></td>
</tr>
<tr class="bgc-info">
<td>SL</td>
<td>Generation No.</td>
<td>ND</td>
<td>Supplier</td>
<td>Invoice No.</td>
<td>Invoice Date</td>
<td>Generation Amount</td>
<!--<td>Attachment</td>-->
</tr>
</thead>
<?
if(isset($_POST['view'])){
if($_POST['sfdate']!=''){
$con = ' and g.generation_date between "'.$_POST['sfdate'].'" and "'.$_POST['stdate'].'"';
}
if($_POST['snd_id']>0){
$con .=' and g.nd_id="'.$_POST['nd_id'].'"';
}
$sql = 'select g.*,d.nd_name from back_margin_generation g, national_dealer d where 1 and d.nd_id=g.nd_id '.$con.'';
$qry = db_query($sql);
while($data=mysqli_fetch_object($qry)){

$link = '../../../../media/generation_invoice_att/'.$data->invoice_no.'.pdf';
if(file_exists($link)){

}
?>
<tbody class="tbody1">
 <tr>
   <td><?=++$i?></td>
   <td><?=$data->cg_no?></td>
   <td><?=$data->nd_name?></td>
   <td><?=$data->supplier?></td>
   <td><?=$data->invoice_no?></td>
   <td><?=$data->invoice_date?></td>
   <td><?=number_format($data->total_generation,2)?></td>
   <!--<td><? if(file_exists($link)){?><a href="<?=$link?>" target="_blank">View Previous Doc.</a><? } ?><input type="file" name="invoice_file<?=$data->invoice_no?>" id="invoice_file<?=$data->invoice_no?>" /></td>-->
 </tr>
 <? } } ?>
 <tr>
   <!--<td colspan="7"><input type="submit" name="invoice_file_upload" id="invoice_file_upload" value="Upload" class="btn2 btn1-submit-input" /></td>-->
 </tr>
</tbody>

</table>
</form>-->
<script>

function get_id(id){
document.getElementById('system_invoice_no').value = id;
}

</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
