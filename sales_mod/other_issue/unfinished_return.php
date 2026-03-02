<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Draft Other Issue';

do_calander('#fdate');

do_calander('#tdate');

$table_master='purchase_return_master';

$unique_master='pr_no';



$table_detail='purchase_return_details';

$unique_detail='id';



$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_SESSION[$unique_master];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		$crud   = new crud($table_chalan);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='PROCESSING';

		$crud   = new crud($table_master);

		$crud->update($unique_master);

		$crud   = new crud($table_detail);

		$crud->update($unique_master);

		$crud   = new crud($table_chalan);

		$crud->update($unique_master);

		unset($$unique_master);

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Instructed to Depot.';

}





$table='purchase_return_master';

$show='vendor_ide';

$id='pr_no';

$con='status="MANUAL"';



?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

}

</script>








  <div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">

      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input type="text" name="fdate" id="fdate" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" class="form-control"/>
              </div>
            </div>

          </div>
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input type="text" name="tdate" id="tdate" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>"  class="form-control"/>

              </div>
            </div>
          </div>

          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL"  class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>







      <div class="container-fluid pt-5 p-0 ">



        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
          <tr class="bgc-info">
            <th>Issue No</th>
            <th>Issue Date</th>
            <th>Issue To</th>
			<th>Approved By</th>
			<th>Action</th>
          </tr>
          </thead>

          <tbody class="tbody1">

          <?
          if($_POST['fdate']!='') {$con=' and a.oi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}else{$con=' and a.oi_date between "'.date('Y-m-o1').'"
and "'.date('Y-m-d').'"';}

          $res ='select a.oi_no,a.oi_date,a.entry_by,a.issued_to,a.approved_by,a.oi_date,u.fname

  from warehouse_other_issue a, user_activity_management u

  where a.entry_by=u.user_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" and a.status="MANUAL" '.$con.' order by a.oi_no desc';

          // $res= 'select p.po_no,p.entry_by,p.po_date,u.fname
          //
          // from purchase_master p,vendor v,user_activity_management u
          //
          // where p.vendor_id=v.vendor_id and p.status="MANUAL" and v.vendor_category=1 and p.entry_by=u.user_id and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
          $query = db_query($res);
          while($data = mysqli_fetch_object($query)){
            ?>
            <tr>
              <td class="text-center"><?=$data->oi_no?></td>
              <td class="text-center"><?php echo date('d-m-Y',strtotime($data->oi_date));?></td>
			  <td class="text-center"><?=$data->issued_to?></td>
			  <td class="text-center"><?=$data->approved_by?></td>
             
              <td class="text-center">
                <a href="new_return.php?old_oi_no=<?=$data->oi_no?>">
                  <input type="button"  value="Complete IS"  class="btn1 btn1-bg-submit"/>
                </a>
              </td>
            </tr>
          <?php } ?>


          </tbody>
        </table>





      </div>
    </form>
  </div>































<?php /*?><div class="form-container_large">

<form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:110px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" class="form-control"/>
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:110px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>"  class="form-control"/>
        </strong></td>
        <td rowspan="2" bgcolor="#FF9966" align="center"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL"  class="btn1 btn1-submit-input"/>
        </strong></td>
      </tr>
  
    </table>
  </form>
  
  
  <table style="cursor:pointer" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<tbody>
<tr>
  <th width="10%" class="text-center">PR No</th>
  <th width="23%" class="text-center">PR Date</th>
  <th width="23%" class="text-center">Vendor</th>
  <th width="34%" class="text-center">Action</th>
 </tr>


<? 
if($_POST['fdate']!='') {$con=' and a.pr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}else{$con=' and a.pr_date between "'.date('Y-m-o1').'" 
and "'.date('Y-m-d').'"';}

    $res ='select a.pr_no,a.entry_by,a.pr_date,a.vendor_id,d.vendor_name,u.fname
 
  from purchase_return_master a,vendor d,user_activity_management u
  
  where a.vendor_id=d.vendor_id and a.entry_by=u.user_id and a.depot_id="'.$_SESSION['user']['depot'].'" and a.status="MANUAL" '.$con.' order by a.pr_no desc';
 
// $res= 'select p.po_no,p.entry_by,p.po_date,u.fname
// 
// from purchase_master p,vendor v,user_activity_management u
// 
// where p.vendor_id=v.vendor_id and p.status="MANUAL" and v.vendor_category=1 and p.entry_by=u.user_id and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$query = db_query($res);
while($data = mysqli_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=$data->pr_no?></td>
<td class="text-center"><?php echo date('d-m-Y',strtotime($data->pr_date));?></td>
<td class="text-left"><?=$data->vendor_name?></td>
<td class="text-center"><a href="new_return.php?old_pr_no=<?=$data->pr_no?>"><button class="btn btn-success btn-sm">Complete SR</button></a></td>
</tr>
<?php } ?>


</tbody>
</table>
</div>
</td>
</tr>
</table>

</div><?php */?>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>