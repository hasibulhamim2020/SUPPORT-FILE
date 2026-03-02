<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Draft Order List';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		//$crud   = new crud($table_chalan);
		//$crud->delete_all($condition);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}

if(isset($_POST['unfinished']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='MANUAL';
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		
		//$crud   = new crud($table_chalan);
		//$crud->update($unique_master);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


if(isset($_POST['confirm']))
{
		$do = find_all_field($table_master,'',$unique_master.'='.$$unique_master);
		$do_total = $total_do = find_a_field($table_detail,'sum(total_amt)',$unique_master.'='.$$unique_master);
		$pb = find_all_field('report_party_acc_status','(todays_collection-final_balance)','code='.$do->dealer_code);
		$pb_amt = $pb->todays_collection - $pb->final_balance;
		
		
		if($pb_amt<$total_do)
		{
			if($do_date!=date('Y-m-d',strtotime($pb->entry_at))){
				$over_do = $pb_amt*(-1);
			} else{
				$over_do = $total_do - $pb_amt;
		} }
		else{ $over_do = 0;}
		

		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['send_to_depot_at']=date('Y-m-d H:i:s');
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='CHECKED';
		$_POST['over_do']=$over_do;
		$_POST['do_total']=$do_total;
		$_POST['pb_amt']=$pb_amt;
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		//$crud   = new crud($table_chalan);
		//$crud->update($unique_master);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='sale_do_master';
$show='dealer_code';
$id='do_no';
$text_field_id='old_do_no';

$target_url = '../cdo/do.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?do_no='+theUrl+'','_self');
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
        <td align="right" bgcolor="#00bfff"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#00bfff"><strong>
          <input type="text" name="fdate" id="fdate" class="from-control"   value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" autocomplete="off"/>
        </strong></td>
        <td align="center" bgcolor="#00bfff"><strong> -to- </strong></td>
        <td width="1" bgcolor="#00bfff"><strong>
          <input type="text" name="tdate" id="tdate" class="from-control" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" autocomplete="off"/>
        </strong></td>
        <td rowspan="2" bgcolor="#00bfff" ><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL"  style="width:120px; margin-left:100px; font-weight:bold; font-size:15px; height:30px;  color:#808080"/>
        </strong></td>
      </tr>
      <!--<tr>
        <td align="right" bgcolor="#00bfff"><strong>Product Group :</strong></td>
        <td colspan="3" bgcolor="#00bfff"><label>
          <select name="product_group">
		  <option><?=$_POST['product_group']?></option>
<? foreign_relation('product_group','group_name','group_name',$PBI_GROUP,'1 order by group_name');?>
		  <option>ABCDE</option>
          </select>
        </label></td>
      </tr>-->
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr><th>Do No</th><th>Do Date</th><th>Dealer Name</th><th>Warehouse</th><th>Created By</th><th>Created At</th>
  </tr>


<? 

if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}


if($_POST['product_group']=='ABCDE'){ $con .= ' and d.product_group != "M"';}
elseif($_POST['product_group']!=''){ $con .= ' and d.product_group = "'.$_POST['product_group'].'"';}

$res="select m.do_no,m.do_date,concat(d.dealer_code,'-',d.dealer_name_e) as dealer_name,m.entry_at,u.fname,w.warehouse_name
from sale_do_master m,dealer_info d, warehouse w, user_activity_management u
where m.status in ('MANUAL')  and m.dealer_code=d.dealer_code ".$con." 
and w.warehouse_id=m.depot_id and m.entry_by=u.user_id order by m.do_date,d.dealer_name_e";
$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_date;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->warehouse_name;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->fname;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->entry_at;?></td>


</tr>
<?
}

?>
</tbody></table>
</div></td>
</tr>
</table>
</div>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>