<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Weight Lost Challan';
do_calander('#fdate');
do_calander('#tdate');
do_datatable('grp');

$unique='chalan_no';  		// Primary Key of this Database table
$page="weight_lost_golden.php";		// PHP File Name
$table='sale_do_chalan';		// Database Table Name Mainly related to this page

$crud      = new crud($table);
$$unique = $_GET[$unique];


					
//for update..................................
//  $data = 'SELECT * FROM sale_do_chalan WHERE 1';
//					$query = db_query($data);
//					$i=1;
//					while($row =mysqli_fetch_object($query)){
//									
//						if(isset($_POST['update'])){
//							 $lost_weight = $_POST['weight_lost_'.$row->id];
//
//							
//						}
//					}


if(isset($_POST['update'])){
  echo $data = 'SELECT * FROM sale_do_chalan WHERE chalan_no="'.$_POST['get_chalan_no'].'"';
					$query = db_query($data);
					while($row =mysqli_fetch_object($query)){
					
					  	if($_POST['weight_lost_'.$row->id]>0){
						  $lost_weight = $_POST['weight_lost_'.$row->id];
						  $weight_lost_amt = $_POST['weight_lost_amount_'.$row->id];
						 
						  echo $sql_data = "UPDATE sale_do_chalan SET weight_lost='".$lost_weight."', weight_lost_amt='".$weight_lost_amt."' WHERE id='".$row->id."'" ;
							db_query($sql_data);
						}
					}
auto_insert_sales_chalan_secoundary($chalan_no);
}

if(isset($_POST['submitit']))
{	
header("Location: weight_lost_golden.php?chalan_no=".$_POST['chalan_no']);	
	//echo $_GET['chalan_no'];
}

	
if(isset($$unique))
{
$condition=$unique."=".$$unique;	
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}

}		

?>

<script type="text/javascript">

//function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}

</script>
<style>
.form-container_large{
    zoom: 95% !important;
}
</style>


<div class="form-container_large">
  	<form action="" method="post" name="codz" id="codz">
	
      <div class="container-fluid bg-form-titel">
        <div class="row">
		  <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
               <!--<input type="text" name="fdate" id="fdate"  class="form-control" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>"/>-->
			   <input type="text" name="fdate" id="fdate"  class="form-control" value="<?=$_POST['fdate']?>" autocomplete="off"/>
              </div>
            </div>

          </div>
          <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
			  <!--<input type="text" name="tdate" id="tdate" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />-->
                 <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" autocomplete="off"/>

              </div>
            </div>
          </div>
		  		  
          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Challan No</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">	
			  
			   <input type="text" list="so_do_no" name="chalan_no" id="chalan_no"  class="form-control" value="<?=$_POST['chalan_no']?>" autocomplete="off"/>
				<datalist id="so_do_no">
					<? foreign_relation('sale_do_chalan','chalan_no','chalan_no',$_POST['chalan_no'],'1');?>
				</datalist>
				
              </div>
            </div>

          </div>

          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
		  <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>
	  
    </form>

  	<form action="" method="post" name="codz" id="codz">

      <div class="container-fluid pt-5 p-0 ">

        <table class="table1  table-striped table-bordered table-hover table-sm" >
          <thead class="thead1">
          <tr class="bgc-info">
				<th>SL No</th>
				<th>SO No</th>
				<th>Challan No</th>
				<th>Challan Date</th>
				<th>Invoice No</th>
<!--				<th>Customer Code</th>-->
				<th>Customer Name</th>
				<th>Product Name</th>
				<th>Unit Price</th>
				<th>Total Unit</th>
				<th>Weight Lost</th>
				<!--<th>Entry By</th>-->
				<th>Total Weight</th>
				<th>Total Weight lost Amount</th>
				<!--<th>Action</th>-->
          </tr>
          </thead>

          <tbody class="tbody1">
		  	  
	  	 <script>
		  function weight_lost(id){
		 	 var total_weight=(document.getElementById("total_weight_"+id).value)*1;
			var weight_lost=(document.getElementById("weight_lost_"+id).value)*1;
			var totel= total_weight - weight_lost;
			document.getElementById("totel_cost_"+id).value=totel.toFixed(2);
			
			var weight_lost_amt=(document.getElementById("weight_lost_"+id).value)*1;
			var weight_lost_price=(document.getElementById("total_unit_weight_"+id).value)*1;
			
			var totel_weight_lost_price = weight_lost_price * weight_lost_amt;
			
			document.getElementById("weight_lost_amount_"+id).value=totel_weight_lost_price.toFixed(2);
		  }
	  	</script>
		  <?php
//$con_date= 'and s.chalan_date between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"';
if($_POST['fdate']!=''&&$_POST['tdate']!=''){
	$con_date= 'and s.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
}
							
 
//  $sql="SELECT s.chalan_no,s.do_no,s.item_id,s.dealer_code,s.unit_price,sum(s.total_unit) as total_unit,s.total_amt,s.chalan_date,s.dealer_code,i.item_name,i.unit_name,d.dealer_code,d.dealer_name_e,(select fname from user_activity_management where user_id=s.entry_by) as entry_by
//from sale_do_chalan s,item_info i,dealer_info d 
//where s.item_id=i.item_id and s.dealer_code=d.dealer_code ".$con_date."  group by s.chalan_no order by s.chalan_no DESC";

$new_data ="SELECT s.id,s.chalan_no,s.do_no,s.item_id,s.dealer_code,s.unit_price,s.weight_lost_amt, s.total_unit,s.total_amt,s.chalan_date,s.dealer_code,s.weight_lost,i.item_name,i.unit_name,d.dealer_code,d.dealer_name_e,(select fname from user_activity_management where user_id=s.entry_by) as entry_by

FROM sale_do_chalan s, item_info i,dealer_info d  WHERE s.item_id=i.item_id and s.chalan_no='".$_GET['chalan_no']."' and s.dealer_code=d.dealer_code ".$con_date." order by s.chalan_no DESC";

$query=db_query($new_data);
while($data = mysqli_fetch_object($query)){
$totel = $data->total_unit - $data->weight_lost;
?>
<tr>
<td class="text-left"><?=++$i?></td>
<td class="text-left"><?=$data->do_no?></td>
<td class="text-left"><?=$data->chalan_no?></td>
<td class="text-left"><?=$data->chalan_date?></td>
<td class="text-left"><?=$data->chalan_no?></td>
<!--<td class="text-right"><?=$data->dealer_code?></td>-->
<td class="text-left"><?=$data->dealer_name_e?></td>
<td  class="text-left"><?=$data->item_name?> </td>
<td class="text-right"><input type="text" id="total_unit_weight_<?=$data->id?>" name="total_unit_weight_<?=$data->id?>" value="<?=$data->unit_price?>" readonly/></td>
<td class="text-right"><input type="text" id="total_weight_<?=$data->id?>" name="total_weight_<?=$data->id?>" value="<?=$data->total_unit?>" readonly/></td>

<td class="text-right">
	 <input type="text" id="weight_lost_<?=$data->id?>" name="weight_lost_<?=$data->id?>" value="<?=$data->weight_lost?>"  onchange="weight_lost(<?=$data->id?>)"/>
</td>

<!--<td class="text-right"><?=$data->entry_by?></td>-->

<td class="text-right"> <input type="text" id="totel_cost_<?=$data->id?>" name="totel_cost_<?=$data->id?>" value="<?=$totel?>" readonly/></td>

<td class="text-right">
	 <input type="text" id="weight_lost_amount_<?=$data->id?>" name="weight_lost_amount_<?=$data->id?>" value="<?=$data->weight_lost_amt?>" />
</td>

<!--<td class="text-center">
<? if($data->weight_lost>0){?>
	<p>Completed</p>
<? } else{?>
	<input type="submit" name="update_<?=$data->id?>" id="update_<?=$data->id?>" value="update" class="btn1 btn1-bg-update"/>
<? } ?>
</td> -->

</tr>

<?php } ?>
<input type="hidden" id="get_chalan_no" name="get_chalan_no" value="<?=$_GET['chalan_no']?>" readonly/>
            </tbody>
        </table>
		
		<center>
			<input type="submit" name="update" id="update" value="update" class="btn1 btn1-bg-update"/>
		</center>

      </div>
    </form>
  </div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>