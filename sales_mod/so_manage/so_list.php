<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


$title='Field Force Information';			// Page Name and Page Title


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Setup';
$sub_menu 		= 'so_list';

$table='user_activity_management';
$unique='user_id';

$$unique = $_GET[$unique];



if(isset($_POST['update'])){


	$crud =new crud($table);  
	$crud->update($unique);
	$msg= "Update successfully";
  $tr_type='Update';
}




if($_GET['user_id']){
$ss="select * from user_activity_management where user_id='".$_GET['user_id']."' ";
$show2 = find_all_field('user_activity_management','','user_id="'.$_GET['user_id'].'"');
//($ss);
}
?>











<div class="container-fluid p-0">
    <div class="row">
         <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">
            <div class="container n-form1 p-2">
            <table class="table1  table-striped table-bordered table-hover table-sm">
                  <thead class="thead1">
                    <tr class="bgc-info">
                      <th style="width: 10px">ID</th>
                      <th>Username</th>
                      <th>Full Name</th>
                      <th>Area</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="tbody1">
                      <?php 
                      // region list
                      $sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
                      $query = mysqli_query($conn,$sql);
                      while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}

                      // zone list
                      $sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
                      $query = mysqli_query($conn,$sql);
                      while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}

                      // area list
                      $sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
                      $query = mysqli_query($conn,$sql);
                      while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;}


                      $sql = "select * from user_activity_management where sfa_user='Yes' ";
                      $query=mysqli_query($conn, $sql);
                      while($data=mysqli_fetch_object($query)){
                      ?>                  	
                      <tr>
                        <td><?=$data->user_id?></td>
                        <td><?=$data->username?></td>
                        <td><?=$data->fname?></td>
                        <td>Dealer: <?=$data->dealer_code?><br><? echo $region_info[$data->region_id];?>-<? echo $zone_info[$data->zone_id];?>-<? echo $area_info[$data->area_id];?>
                        </td>
                        <td><a href="so_list.php?user_id=<?=$data->user_id;?>">Edit</a></td>
                      </tr>
                        <? } ?>                    
                  </tbody>
                </table>
            </div>
		</div>



    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-5 col-6  setup-right">
            
			
            <form class="n-form setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <?php $rand=rand(); $_SESSION['rand']=$rand; ?>
            <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
											<h4 align="center" class="n-form-titel1">Fill Up Below Information</h4>
						
                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Employee Code</label>
                  <div class="col-sm-9 p-0">
                    <input class="col-md-12" type="text" name="username" required="required" value="<?=$show2->username?>"
                    class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Full Name</label>
                  <div class="col-sm-9 p-0">
				  
                    <input type="text" name="fname" required="required" value="<?=$show2->fname?>" class="form-control col-md-12">
                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Joining Date</label>
                  <div class="col-sm-9 p-0">
                    <input type="date" name="DOJ" id="DOJ" required="required" value="<?=$show2->DOJ?>" class="form-control col-md-12">
                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Date of Birth</label>
                  <div class="col-sm-9 p-0">
                    <input type="date" name="dob" id="dob"  value="<?=$show2->dob?>" class="form-control col-md-12">
                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Mobile</label>
                  <div class="col-sm-9 p-0">
                    <input type="text" name="mobile" required="required" value="<?=$show2->mobile?>" class="form-control col-md-12">
                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Zone</label>
                  <div class="col-sm-9 p-0">
                      <select class="form-control col-md-12" name="region_id" required id="region" onchange="FetchZone(this.value)">
                            <option value="<?=$show2->region_id?>"><?=find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$show2->region_id.'"');?></option>
                        <? foreign_relation('branch', 'BRANCH_ID', 'BRANCH_NAME', $group_for, '1 order by BRANCH_NAME'); ?>
                        
                        
                      </select>
                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Territory</label>
                  <div class="col-sm-9 p-0">
                    <select class="form-control col-md-12" name="zone_id" required id="zone" onchange="FetchArea(this.value)">
                            <option value="<?=$show2->zone_id?>"><?=find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$show2->zone_id.'"');?></option>
                    </select>
                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Route Name</label>
                  <div class="col-sm-9 p-0">
                      <select class="form-control col-md-12" name="area_id" required id="area" onchange="Fetchroute(this.value)">
                          <option value="<?=$show2->area_id?>"><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$show2->area_id.'"');?></option>

                      </select>
                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Route Points</label>
                  <div class="col-sm-9 p-0">
                    <select class="form-control col-md-12" name="route_points" required id="route_id" >
                        <?php /*?><option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option><?php */?>
                        <option value="<?=$show2->area_id?>"><?=find_a_field('ss_route','route_name','area_id="'.$show2->area_id.'"');?></option>
                    </select>
                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                  <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Status</label>
                  <div class="col-sm-9 p-0">
                      <select class="form-control" name="status" required>
                          <option><?=$show2->status?$show2->status:'Active'?></option>
                          <option>Active</option>
                          <option>Inactive</option>
                      </select>
                  </div>
                </div>

                  <!--<div class="row mb-10 form-group">
                    <label class="control-label col-md-6 col-sm-6" for="first-name">Password<span class="required"></span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="password" required="required" value="<?=$show2->password?>" class="form-control col-md-12">
                    </div>
                  </div>-->	

                  <?php /*?><div class="row mb-10 form-group">
                    <label class="control-label col-md-6 col-sm-6" for="first-name">Incharge<span class="required"></span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="fname" required="required" value="<?=$show2->fname?>" class="form-control col-md-12">
                    </div>
                  </div><?php */?>
					  
                      <div class="n-form-btn-class">
                        <!--<button class="btn btn-primary" type="reset">Reset</button>-->
                        <button name="update" type="submit"  class="btn btn-success">Update</button>
                      </div>


            </form>

        </div>

    </div>
</div>


<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>  


<script type="text/javascript">
  function FetchZone(id){
    $('#zone').html('');
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { region_id : id},
      success : function(data){
         $('#zone').html(data);
      }

    })
  }

  function FetchArea(id){ 
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { zone_id : id},
      success : function(data){
         $('#area').html(data);
      }

    })
  }
   function Fetchroute(id){ 
    $('#route_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { area_id : id},
      success : function(data){
         $('#route_id').html(data);
      }

    })
  }
</script>