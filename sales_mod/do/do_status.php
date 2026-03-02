<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Dealer for Demand Order';
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
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='CHECKED';
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


$table='sale_do_master';
$show='dealer_code';
$id='do_no';
$text_field_id='old_do_no';

$target_url = '../do/do_print_view.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?do_no='+theUrl);
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
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=$fdate?>" class="form-control"  />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=$tdate?>" class="form-control" />
        </strong></td>
        <td rowspan="2" bgcolor="#FF9966" align="center"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090" class="form-control"/>
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"> <strong>Product Status :</strong></td>
        <td colspan="3" bgcolor="#FF9966"><label>
          <select name="product_status" class="form-control">
		  <option><?=$_POST['product_status']?></option>
		  <option>All</option>
		  <option>Unfinished</option>
		  <option>Unchaked</option>
		  <option>Chaked</option>
		  <option>ABCD</option>
          </select>
        </label></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr><th>Do No</th><th>Do Date</th><th>Dealer Name</th><th>Dealer Status</th>

 
  
  </tr>


<? 



if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


if($_POST['product_group']=='ABCD') $con .= ' and d.product_group != "M"';
elseif($_POST['product_group']!='') $con .= ' and d.product_group = "'.$_POST['product_group'].'"';

//$res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e,'(',team_name,')') as dealer_name, a.AREA_NAME, concat(m.payment_by) as Payment_Details,m.rcv_amt, m.mr_no from 
//sale_do_master m,dealer_info d, area a
//where m.status in ('PROCESSING') and d.area_code=a.AREA_CODE  and m.dealer_code=d.dealer_code ".$con." and d.dealer_type='Distributor' order by m.do_date,d.dealer_name_e";




$res="select m.do_no,m.do_date,d.dealer_name_e as dealer_name, m.status, m.mr_no from 
sale_do_master m,dealer_info d
where m.dealer_code=d.dealer_code ".$con." order by m.do_no desc";
$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_date;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name;?></td>

<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->status;?></td>


</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
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