<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$tr_type="Show";
 



$title="Target Upload";
//do_calander('#start_date');
//do_calander('#end_date');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

$table='sale_target_upload';
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

function find1($sql){
	
	$res=db_query($sql);
	$count=mysqli_num_rows($res);
	if($count>0)
	{
	$data=mysqli_fetch_row($res);
	return $data[0];
	}
	else
	return NULL;
	}



if(isset($_POST["upload"])){
$target_year 		= $_POST['target_year'];
$target_month 		= sprintf('%02d', $_POST['target_month']);
$grp 				= $_POST['grp'];
$now = date('Y-m-d H:i:s');
$target_period = $target_year.$target_month;

// delete old upload if exists
$del = "DELETE FROM sale_target_upload WHERE grp='".$_POST['grp']."' and target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
db_query($del); 
// end delete


// 
$sql="SELECT * from item_info WHERE  1";
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$i_id[$row->item_id] = $row->item_id;
		$i_dp[$row->item_id] = $row->d_price;
		$i_ps[$row->item_id] = $row->pack_size;
	}




$sql="SELECT d.dealer_code,a.AREA_CODE,z.ZONE_CODE,z.REGION_ID
FROM  dealer_info d, area a,zon z
where
d.area_code=a.AREA_CODE
and a.ZONE_ID=z.ZONE_CODE
 
order by d.dealer_code";
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$ac[$row->dealer_code] = $row->AREA_CODE;
		$zc[$row->dealer_code] = $row->ZONE_CODE;
		$rc[$row->dealer_code] = $row->REGION_ID;
	}

$s =0;
$filename=$_FILES["upload_file"]["tmp_name"];
	if($_FILES["upload_file"]["tmp_name"]!=""){	
	//echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");

while (($excelData = fgetcsv($file, 50000, ",")) !== FALSE){

for($x=0;$x<100;$x++)
{

if($excelData[$x]!='')
$data[$s][$x] = $excelData[$x];
}

$s++;
} // end while loop
} // end upload file
fclose($file);
echo "Upload Complete";
} 

echo $data[0][0];

for($b=1;$b<=$s;$b++){


for($g=4;$g<=$x;$g++)
{
if($data[$b][$g]>0){

$data[$b][3] = str_replace("'","",$data[$b][3]);
$data[$b][3] = str_replace('"','',$data[$b][3]);
$data[$b][3] = trim($data[$b][3]);
			
$sql = "INSERT INTO sale_target_upload  (grp, fg_code,  area_name, dealer_code, target_period, target_month, target_year, target_ctn, entry_by, entry_at,
item_id,d_price,target_amount,region_id,zone_id,area_id) 	
VALUES									('".$grp."', '".$data[0][$g]."', '', '".$data[$b][1]."', '".$target_period."','".$target_month."', '".$target_year."', '".$data[$b][$g]."','".$_SESSION['user']['id']."','".$now."',
'".$data[0][$g]."','".($i_dp[$data[0][$g]])."','".($i_ps[$data[0][$g]]*$i_dp[$data[0][$g]]*$data[$b][$g])."','".$rc[$data[$b][1]]."','".$zc[$data[$b][1]]."','".$ac[$data[$b][1]]."'
  		)";	

db_query($sql);
}
} 


}
?>
<style type="text/css">
<!--
.style2 {
	font-size: 18px;
	font-weight: bold;
}
-->
</style>


<div class="oe_view_manager oe_view_manager_current">
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
            <!-- Bootstrap�4.1 CDN (remove if you already load it elsewhere) -->
 


  <div class="container mt-4">

    <!-- Card wrapper -->
    <div class="card border-success">
      <div class="card-header bg-success text-white text-center">
        <strong>Upload Target</strong>
      </div>
      <div class="card-body">

        <!-- Year & Group Row -->
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
            <label for="grp">Group For</label>
            <select class="form-control" id="grp" name="grp" required>
              <option value=""></option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
            </select>
          </div>
		  <div class="form-group col-md-3">
            <label for="target_month">Month</label>
            <select class="form-control" id="target_month" name="target_month" required>
              <option value="1"  <?=($target_month=='1') ?'selected':''?>>Jan</option>
              <option value="2"  <?=($target_month=='2') ?'selected':''?>>Feb</option>
              <option value="3"  <?=($target_month=='3') ?'selected':''?>>Mar</option>
              <option value="4"  <?=($target_month=='4') ?'selected':''?>>Apr</option>
              <option value="5"  <?=($target_month=='5') ?'selected':''?>>May</option>
              <option value="6"  <?=($target_month=='6') ?'selected':''?>>Jun</option>
              <option value="7"  <?=($target_month=='7') ?'selected':''?>>Jul</option>
              <option value="8"  <?=($target_month=='8') ?'selected':''?>>Aug</option>
              <option value="9"  <?=($target_month=='9') ?'selected':''?>>Sep</option>
              <option value="10" <?=($target_month=='10')?'selected':''?>>Oct</option>
              <option value="11" <?=($target_month=='11')?'selected':''?>>Nov</option>
              <option value="12" <?=($target_month=='12')?'selected':''?>>Dec</option>
            </select>
          </div>
        </div><!-- /form-row -->

<div class="form-row justify-left">
    <div class="form-group col-md-6 text-center">
        <label for="upload_file">Upload File</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="upload_file" name="upload_file" required>
            <label class="custom-file-label" for="upload_file">Choose CSV...</label>
        </div>
    </div>
</div>
        

        <!-- Submit button -->
        <button type="submit" name="upload" id="upload" class="btn btn-primary">
          Upload File
        </button>

      </div><!-- /card-body -->
    </div><!-- /card -->

    <!-- CSV example table -->
    <div class="card mt-4">
      <div class="card-header text-center">
        CSV File Example
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-sm table-bordered mb-0">
            <thead class="thead-light">
              <tr>
                <th>SL</th>
                <th>Party Code</th>
                <th>Party Name</th>
                <th>Area Name</th>
                <th class="text-center">102</th>
                <th class="text-center">103</th>
                <th class="text-center">104</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td><td>11245</td><td>S.M Enterprise</td><td>Babu Bazar</td>
                <td class="text-center">11</td><td class="text-center">20</td><td class="text-center">5</td>
              </tr>
              <tr>
                <td>2</td><td>12500</td><td>Mumu Enter</td><td>Karim Bradarz</td>
                <td class="text-center">10</td><td class="text-center">15</td><td class="text-center">9</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- /CSV example -->

  </div><!-- /container -->


 

<!-- Show chosen file name in the custom-file-label -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var fileInput = document.querySelector('.custom-file-input');
    if (fileInput) {
      fileInput.addEventListener('change', function (e) {
        var fileName = e.target.files[0].name;
        e.target.nextElementSibling.innerText = fileName;
      });
    }
  });
</script>

<div class="container">

 <div><a href="target_upload.csv" style="text-decoration:underline;">Download csv format</a></div>

</div>
            <br />
          </div>
          </div>

          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
</div>
 </form>   </div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>