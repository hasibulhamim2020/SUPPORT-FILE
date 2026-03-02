<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Make Master Invoice List';
do_calander('#fdate');
do_calander('#tdate');
do_datatable('grp');
?>
<style>
input[type="checkbox"] {
    width: 100%;
    box-sizing: border-box;
    padding: 0;
    height: 20px;
}
</style>



<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Form Date</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <!--<input type="text" name="fdate" id="fdate"  class="form-control" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" autocomplete="off"/>-->
				<input type="text" name="fdate" id="fdate"  class="form-control" value="" autocomplete="off"/>
              </div>
            </div>

          </div>
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
               <!-- <input type="text" name="tdate" id="tdate" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" autocomplete="off"/>-->
				<input type="text" name="tdate" id="tdate" value="" autocomplete="off"/>


              </div>
            </div>
          </div>

          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
		   	<input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>
    </form>

    <form action="master_invoice_cus.php" method="post" target="_blank">
      <div class="container-fluid pt-5 p-0 ">

        <table class="table1  table-striped table-bordered table-hover table-sm" id="grp">
          <thead class="thead1">
          <tr class="bgc-info">
						<th width="10%">Select</th>
						<th >SL No</th>
						<th >SO No</th>
						<th >Challan No</th>
						<th >Challan Date</th>
						<th >Invoice No</th>
						<th >Customer Code</th>
						<th >Customer Name</th>
						<th >Total Unit</th>
						<th >Entry By</th>
				<!--	<th >Action</th>-->
          </tr>
          </thead>

          <tbody class="tbody1">
<?php

$con_date= 'and s.chalan_date between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"';
if($_POST['fdate']!=''&&$_POST['tdate']!=''){

$con_date= 'and s.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

}


   $sql="SELECT s.chalan_no,s.do_no,s.item_id,s.dealer_code,s.unit_price,sum(s.total_unit) as total_unit,s.total_amt,s.chalan_date,s.dealer_code,i.item_name,i.unit_name,d.dealer_code,d.dealer_name_e,(select fname from user_activity_management where user_id=s.entry_by) as entry_by,s.master_invoice_no

from sale_do_chalan s,item_info i,dealer_info d 

where s.item_id=i.item_id and s.dealer_code=d.dealer_code ".$con_date."  group by s.chalan_no order by s.chalan_no DESC";

$query=db_query($sql);

while($data = mysqli_fetch_object($query)){



?>
<tr>
<td align="center"><?php if($data->master_invoice_no>0){echo "<span style='color:red;'>Master Invoice Done</span>";}else{?><input type="checkbox" name="check_inv[]" id="check_inv[]" value="<?=$data->chalan_no?>" style="accent-color: #4c9f31;"/><?php } ?></td>

<td class="text-left"><?=++$i?></td>
<td class="text-left"><?=$data->do_no?></td>
<td class="text-left"><?=$data->chalan_no?></td>
<td class="text-left"><?=$data->chalan_date?></td>
<td class="text-left"><?=$data->chalan_no?></td>
<td class="text-right"><?=$data->dealer_code?></td>
<td class="text-left"><?=$data->dealer_name_e?></td>
<td class="text-right"><?=$data->total_unit?></td>
<td class="text-right"><?=$data->entry_by?></td>



<?php /*?><td class="text-center">
<!--<a target="_blank" href="chalan_bill_corporate1.php?v_no=<?=$data->chalan_no ?>" style="color:#FFFFFF;"><button  class="btn btn-info btn-sm active">Challan</button></a> -->

<a target="_blank" href="invoice.php?v_no=<?=$data->chalan_no ?>" style="color:#FFFFFF;"><button class="btn btn-success btn-sm">Invoice</button></a>

<!--<a target="_blank"href="gatepass.php?v_no=<?=$data->chalan_no ?>" style="color:#FFFFFF;"><button class="btn btn-warning btn-sm ">Gate Pass</button></a>-->
</td> 
<?php */?>
</tr>

<?php } ?>




            </tbody>
        </table>
		
		<div class="row">
			<div class="col-md-12 text-center">
				<input type="submit" name="initiate_invoice" class="btn btn-success" id="initiate_invoice" value="Initiate" />
			</div>
		</div>

      </div>
    </form>

  </div>










<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>