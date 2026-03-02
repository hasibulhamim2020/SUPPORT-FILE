<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$tr_type="Show";

$title="Sync Sales Officer's Target";

$entry_by = $_SESSION['user']['username'];
$datetime 	= date('Y-m-d H:i:s');

if($_POST['mon']!=''){
$mon=$_POST['mon'];}
else{
$mon=date('n');
}

if($_POST['year']!=''){
$year=$_POST['year'];}
else{
$year=date('Y');
}

if(isset($_POST['submit'])){

 
$tr_type="Update";
$year=$_POST['year'];
$mon=$_POST['mon'];


$del = 'delete from ss_target_upload where target_year="'.$year.'" and target_month="'.$mon.'" ';
db_query($del);


// Dealer Target
$tt="select dealer_code as code,sum(target_amount) as amount from sale_target_upload where target_year='".$year."' and target_month='".$mon."' 
group by dealer_code";
$query1 = db_query($tt);
while($info1 = mysqli_fetch_object($query1)){
$dealer_target_amount[$info1->code]=$info1->amount;
}

// Target Contribution Data
$tc = "select emp_code,target_con from ss_target_ratio where target_year='".$year."' and target_month='".$mon."' group by emp_code";
$query2 = db_query($tc);
while($info2 = mysqli_fetch_object($query2)){
$contribution[$info2->emp_code]=$info2->target_con;
}





// USER LIST
  $sql='select emp_code,master_dealer_code from ss_shop where status="1" group by emp_code order by emp_code';
$query = db_query($sql);
while($info = mysqli_fetch_object($query)){


$target_con=$contribution[$info->emp_code]; if($target_con==''){ $target_con=100;}
//echo '<br>Target '.$info->emp_code.' ='.$target_con;
$dealer_target = $dealer_target_amount[$info->master_dealer_code];
$sales_target = ($dealer_target*$target_con)/100;


		// Insert data 
		if($sales_target>0){
		  $ss="INSERT INTO ss_target_upload ( target_year,target_month,so_code,dealer_code,target_amount,entry_by,entry_at
		) VALUES (
		'".$year."','".$mon."','".$info->emp_code."','".$info->master_dealer_code."','".$sales_target."','".$entry_by."','".$datetime."'
		)";
		db_query($ss);
		}
		
$target_con=0;
$dealer_target=0;
$sales_target=0;
			


}	// end while user list







?>
 

 
<div class="container mt-4">
  <div class="alert alert-success text-center font-weight-bold" role="alert">
    <i class="fas fa-check-circle mr-2"></i> SO TARGET UPDATE Complete
  </div>
</div>
<?php } ?>

<div class="container py-4">
  <h2 class="text-center text-success mb-4">
    <i class="fas fa-sync-alt mr-2"></i>Update SO Target from Head Office (Table: <code>ss_target_upload</code>)
  </h2>

  <form action="" method="post">
    <div class="card shadow rounded">
      <div class="card-body">
        <div class="form-row">
          <!-- Year -->
          <div class="form-group col-md-4">
            <label for="year"><strong>Year</strong></label>
            <select name="year" id="year" class="form-control" required>
              <option <?=($year=='2024')?'selected':''?>>2024</option>
              <option <?=($year=='2025')?'selected':''?>>2025</option>
              <option <?=($year=='2026')?'selected':''?>>2026</option>
            </select>
          </div>

          <!-- Month -->
          <div class="form-group col-md-4">
            <label for="mon"><strong>Month</strong></label>
            <select name="mon" id="mon" class="form-control" required>
              <option value="1"  <?=($mon=='1')?'selected':''?>>Jan</option>
              <option value="2"  <?=($mon=='2')?'selected':''?>>Feb</option>
              <option value="3"  <?=($mon=='3')?'selected':''?>>Mar</option>
              <option value="4"  <?=($mon=='4')?'selected':''?>>Apr</option>
              <option value="5"  <?=($mon=='5')?'selected':''?>>May</option>
              <option value="6"  <?=($mon=='6')?'selected':''?>>Jun</option>
              <option value="7"  <?=($mon=='7')?'selected':''?>>Jul</option>
              <option value="8"  <?=($mon=='8')?'selected':''?>>Aug</option>
              <option value="9"  <?=($mon=='9')?'selected':''?>>Sep</option>
              <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
              <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
              <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
            </select>
          </div>

          <!-- Submit -->
          <div class="form-group col-md-4 d-flex align-items-end">
            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">
              <i class="fas fa-arrow-up mr-1"></i> Update Target
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>