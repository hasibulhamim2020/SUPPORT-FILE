<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Dealer for Demand Order';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique_master='do_no';
$page_id=11;
$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';
$tr_type="show";
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

$target_url = '../do/do_check.php';

$tr_from="Sales";
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
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=$fdate?>" class="form-control" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" class="form-control" value="<?=$tdate?>"  class="form-control"/>
        </strong></td>
        <td rowspan="2" bgcolor="#FF9966" align="center"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090" class="form-control"/>
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966">Product Group : </td>
        <td colspan="3" bgcolor="#FF9966"><label>
          <select name="product_group" class="form-control" style="width:107px;">
		  <option><?=$_POST['product_group']?></option>
		  <option>A</option>
		  <option>B</option>
		  <option>C</option>
		  <option>D</option>
		  <option>M</option>
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
<tr><th>Do No</th><th>Do Date</th><th>Dealer Name</th><th>Area</th><th>DP Total</th><th>Payment Details</th>
<th>RCV AMT</th>
  <th>MONEY RCV NO </th>
  <th>&nbsp;</th>
  </tr>


<? 



if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


if($_POST['product_group']=='ABCD') $con .= ' and d.product_group != "M"';
elseif($_POST['product_group']!='') $con .= ' and d.product_group = "'.$_POST['product_group'].'"';

//$res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e,'(',team_name,')') as dealer_name, a.AREA_NAME, concat(m.payment_by) as Payment_Details,m.rcv_amt, m.mr_no from 
//sale_do_master m,dealer_info d, area a
//where m.status in ('PROCESSING') and d.area_code=a.AREA_CODE  and m.dealer_code=d.dealer_code ".$con." and d.dealer_type='Distributor' order by m.do_date,d.dealer_name_e";




 $res="select m.do_no,m.do_date,d.dealer_name_e as dealer_name,  concat(m.payment_by) as Payment_Details,m.rcv_amt, m.mr_no from 
sale_do_master m,dealer_info d
where m.status in ('PROCESSING')  and m.dealer_code=d.dealer_code ".$con." order by m.do_date,d.dealer_name_e";
$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_date;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->AREA_NAME;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->DP_Total;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->Payment_Details;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->rcv_amt;?></td>
<td>&nbsp;
    <?=$data->mr_no;?></td>
<td><? if($data->RCV_AMT>0&$data->do_date==date('Y-m-d')){?>
<form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
      <input  name="do_no" type="hidden" id="do_no" value="<?=$data->do_no;?>"/>
      <input name="confirm" type="submit" value="SEND" style="width:40px; font-weight:bold; font-size:10px; height:30px; color:#090; float:right" />
</form><? }?>
</td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
}

?>
<tr class="alt"><td colspan="6"><span style="text-align:right;"> Total: </span></td><td colspan="0"><?=number_format($total_send_amt,2);?></td>
  <td colspan="1"><?=number_format($total_rcv_amt,2);?></td>
  <td>&nbsp;</td>
  </tr>

</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>