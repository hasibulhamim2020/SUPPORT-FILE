<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


 $title="Upload Target Ratio";
$today 			= date('Y-m-d');
$company_id     = $_SESSION['user']['group_for'];
$ledger_group   =3;
$menu 			= 'target_manage';
$sub_menu 		= 'upload_target';
$entry_by       = $_SESSION['user']['username'];
$entry_at       = date('Y-m-d H:i:s');


$table='ss_target_ratio';
$unique='id';

if($_POST['target_month']!=''){
$target_month=$_POST['target_month'];}
else{
$target_month=date('n');
}

if($_POST['target_year']!=''){
$target_year=$_POST['target_year'];}
else{
$target_year=date('Y');
}




if(isset($_POST["upload"])){

$product_group 		= $_POST['product_group'];    
$target_year 		= $_POST['target_year'];
$target_month 		= sprintf('%02d', $_POST['target_month']);
$now = date('Y-m-d H:i:s');


// delete old upload if exists
$del = "DELETE FROM ss_target_ratio WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' 
and product_group='".$_POST['product_group']."'
";
db_query($del); 
// end delete


$filename=$_FILES["upload_file"]["tmp_name"];
	if($_FILES["upload_file"]["tmp_name"]!=""){
	//echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");

while (($excelData = fgetcsv($file, 50000, ",")) !== FALSE){
    

if($excelData[1]>0){
        $sql = "INSERT IGNORE INTO ss_target_ratio (target_year,target_month, product_group,emp_code,emp_name,dealer_code,dealer_name, target_con, entry_by, entry_at)
        VALUES ('".$_POST['target_year']."', '".$_POST['target_month']."','".$_POST['product_group']."', '".$excelData[1]."', '".$excelData[2]."', '".$excelData[3]."','".$excelData[4]."'
		,'".$excelData[5]."','".$entry_by."', '".$entry_at."'   )";	
        
        db_query($sql);
}		


} // end while loop
} // end upload file
fclose($file);
$msg =  "Target Ratio Upload Complete";

} // END Upload File





if(isset($_POST["replace"])){

$product_group 		= $_POST['product_group'];    
$target_year 		= $_POST['target_year'];
$target_month 		= sprintf('%02d', $_POST['target_month']);
$now = date('Y-m-d H:i:s');



$filename=$_FILES["upload_file"]["tmp_name"];


	if($_FILES["upload_file"]["tmp_name"]!=""){
	//echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");
fgetcsv($file, 50000, ",");
while (($excelData = fgetcsv($file, 50000, ",")) !== FALSE){
  
  
// delete single file if exist
$del = "DELETE FROM ss_target_ratio WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' 
and product_group='".$_POST['product_group']."' and emp_code='".$excelData[1]."'
";
db_query($del); 
// end delete
    

if($excelData[1]>0){
        $sql = "INSERT IGNORE INTO ss_target_ratio (target_year,target_month, product_group,emp_code,emp_name,dealer_code,dealer_name, target_con, entry_by, entry_at)
        VALUES ('".$_POST['target_year']."', '".$_POST['target_month']."','".$_POST['product_group']."', '".$excelData[1]."', '".$excelData[2]."', '".$excelData[3]."','".$excelData[4]."'
		,'".$excelData[5]."','".$entry_by."', '".$entry_at."'   )";	
        
       db_query($sql);
}		


} // end while loop
} // end upload file
fclose($file);
$msg =  "Target Ratio Added Ok";

} // END Replce File



// copy this month to next month
if(isset($_POST["setnew"])){

$product_group 		= $_POST['product_group'];    
$target_year 		= $_POST['target_year'];
$target_month 		= $_POST['target_month'];
$now = date('Y-m-d H:i:s');

if($target_month==12){
$new_month=1;
$new_year=$target_year+1;
}else{
$new_month=$target_month+1;
$new_year=$target_year;
}

// delete old upload if exists
$del = "DELETE FROM ss_target_ratio WHERE target_year='".$new_year."' and target_month='".$new_month."' 
and product_group='".$_POST['product_group']."'
";
db_query($del); 
// end delete


$sql="select * from ss_target_ratio where target_year='".$target_year ."' and target_month='".$target_month."' and product_group='".$product_group."'";
$query=db_query($sql);
while($data=mysqli_fetch_object($query)){

$ss="insert ignore into ss_target_ratio(target_year,target_month,product_group,emp_code,emp_name,dealer_code,dealer_name,target_con,entry_by,entry_at)
values
('".$new_year."','".$new_month."','".$product_group."','".$data->emp_code."','".$data->emp_name."','".$data->dealer_code."','".$data->dealer_name."','".$data->target_con."','".$entry_by."','".$entry_at."')
";
db_query($ss);		

} // end while
$msg =  "New Month contribution file make Complete";
} // end next month


?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        

<section class="content-main">
<div class="content-header">



<?php if(isset($msg)){  ?><div class="alert alert-primary" role="alert"><?php echo @$msg; ?></div><?php } ?>
<?php if(isset($emsg)){  ?><div class="alert alert-danger" role="alert"><?php echo @$emsg; ?></div><?php } ?>
</div>

<div class="card mb-4">
<div class="card-body">
<!--BODY Start	-->
				
<div class="row">
<div class="col-md-12 col-xs-12">

<form action=""  method="post" enctype="multipart/form-data">
        <div class="oe_view_manager_body">
<div  class="oe_view_manager_view_list"></div>
<div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">


<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">
          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
            
            
     
  <div class="container mt-4">

    <!-- Header -->
    <div class="card border-success mb-4">
      <div class="card-header bg-success text-white text-center">
       <h2 class="text-center mb-4 font-weight-bold" style="color:#blue;">
  <i class="fas fa-upload mr-2"></i>Target Ratio File Upload
</h2>
      </div>
      <div class="card-body">

        <!-- Year -->
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="target_year">Year</label>
            <select class="form-control" id="target_year" name="target_year" required>
              <option <?=($target_year=='2024')?'selected':''?>>2024</option>
              <option <?=($target_year=='2025')?'selected':''?>>2025</option>
              <option <?=($target_year=='2026')?'selected':''?>>2026</option>
            </select>
          </div>
		  <div class="form-group col-md-3">
            <label for="target_month">Month</label>
            <select class="form-control" id="target_month" name="target_month" required>
              <?php
              $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
              for ($i = 1; $i <= 12; $i++) {
                $selected = ($target_month == $i) ? 'selected' : '';
                echo "<option value=\"$i\" $selected>{$months[$i-1]}</option>";
              }
              ?>
            </select>
          </div>
		  <div class="form-group col-md-4">
            <button type="submit" name="setnew" id="setnew" class="btn btn-warning">
              Copy to New Month
            </button>
            <small class="form-text text-muted">
              Note: This button helps create next month's contribution file.
            </small>
          </div>
        </div>

 
<!-- Group Selection & File Upload -->
<div class="form-row align-items-end">
    <div class="form-group col-md-3">
        <label for="product_group">Group</label>
        <select class="form-control" name="product_group" id="product_group" required>
            <option value="A" <?=($product_group=='A')?'selected':''?>>A</option>
            <option value="B" <?=($product_group=='B')?'selected':''?>>B</option>
            <option value="C" <?=($product_group=='C')?'selected':''?>>C</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="upload_file">Upload File</label>
        <input type="file" class="form-control" id="upload_file" name="upload_file" required>
    </div>
</div>

<!-- Action Buttons -->
<div class="form-row mt-3">
    <div class="form-group col-md-4">
        <button type="submit" name="upload" id="upload" class="btn btn-danger btn-block">
            Upload File (Delete Old FI)
        </button>
        <small class="form-text text-muted">
            Note: All group data will be deleted before inserting this file.
        </small>
    </div>
    <div class="form-group col-md-4">
        <button type="submit" name="replace" id="replace" class="btn btn-info btn-block">
            Upload File (Replace DATA)
        </button>
        <small class="form-text text-muted">
            Note: Use this button to add/replace additional data.
        </small>
    </div>
</div>

    <!-- CSV Example -->
    <div class="card mt-3">
      <div class="card-header text-center">
        CSV File Example
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered table-sm mb-0">
            <thead class="thead-light">
              <tr>
                <th>SL</th>
                <th>SO Code</th>
                <th>SO Name</th>
                <th>Dealer Code</th>
                <th>Dealer Name</th>
                <th>Target Ratio</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>26194</td>
                <td>Karim</td>
                <td>17458</td>
                <td>Ma Enterprise</td>
                <td>48</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div> <!-- container -->
 

 

<!-- Show selected file name -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var fileInput = document.querySelector('.custom-file-input');
    if (fileInput) {
      fileInput.addEventListener('change', function (e) {
        var fileName = e.target.files[0]?.name || "Choose file";
        e.target.nextElementSibling.innerText = fileName;
      });
    }
  });
</script>

			
	<div class="container">

 <div><a href="so_ratio.csv" style="text-decoration:underline;">Download csv format</a></div>

</div>	

            <br />
			
<div class="row">
Note: Some dealer point present multi Field Officer. 
<br>Thats why we have to manage them to provide individual target setup.
<br>So use this target contribution for that.
</div>			
			
          </div>
          </div>

          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
</div>
 </form>



</div> <!--end first column-->
</div>				

				

<!-- Body end -->
	

        
		
		
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>