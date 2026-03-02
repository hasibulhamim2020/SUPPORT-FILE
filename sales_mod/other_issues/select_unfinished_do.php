<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Unfinished Entry';

do_calander('#fdate');

do_calander('#tdate');

$table_master='sale_other_master';

$unique_master='do_no';



$table_detail='sale_other_details';

$unique_detail='id';



//$table_chalan='sale_do_chalan';
//
//$unique_chalan='id';



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





$table='sale_other_master';

$show='dealer_code';

$id='do_no';

$con='status="MANUAL"';



?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

}

</script>

<div class="form-container_large">

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
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090" class="form-control"/>
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

<th width="10%" class="text-center">SO No</th>
<th width="23%" class="text-center">SO Date</th>
<th width="23%" class="text-center">Warehouse</th>
<th width="34%" class="text-center">Action</th>
 </tr>


<? 
if($_POST['fdate']!='') {$con=' and a.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}else{$con=' and a.do_date between "'.date('Y-m-o1').'" 
and "'.date('Y-m-d').'"';}

    $res ='select a.do_no,a.entry_by,a.do_date,d.warehouse_name,u.fname
 
  from sale_other_master a, warehouse d,user_activity_management u
  
  where a.depot_id=d.warehouse_id and a.entry_by=u.user_id and a.depot_id="'.$_SESSION['user']['depot'].'" and a.status="MANUAL" '.$con.' order by a.do_no desc';
 
// $res= 'select p.po_no,p.entry_by,p.po_date,u.fname
// 
// from purchase_master p,vendor v,user_activity_management u
// 
// where p.vendor_id=v.vendor_id and p.status="MANUAL" and v.vendor_category=1 and p.entry_by=u.user_id and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$query = db_query($res);
while($data = mysqli_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=$data->do_no?></td>
<td class="text-center"><?php echo date('d-m-Y',strtotime($data->do_date));?></td>
<td class="text-left"><?=$data->warehouse_name?></td>
<td class="text-center"><a href="do.php?old_do_no=<?=$data->do_no?>"><button class="btn btn-success btn-sm">Complete SO</button></a></td>
</tr>
<?php } ?>
</tbody></table>
</div></td>
</tr>
</table>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>