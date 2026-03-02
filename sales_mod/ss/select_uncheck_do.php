<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Dealer for Demand Order';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_other_master';
$unique_master='do_no';

$table_detail='sale_other_details';
$unique_detail='id';

$table_chalan='sale_other_chalan';
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
		$_POST['entry_at']=date('Y-m-d h:s:i');
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


$table='sale_other_master';
$show='dealer_code';
$id='do_no';
$text_field_id='old_do_no';

$target_url = '../ss/do_check.php';


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
          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=$fdate?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=$tdate?>" />
        </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr><th>Do No</th><th>Do Date</th><th>Dealer Name</th><th>Area</th><th>DP Total</th><th>Payment Details</th><th>SEND AMT</th>
  <th>RCV AMT</th>
  <th>&nbsp;</th>
  </tr>


<? 



if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



$res="select m.do_no,m.do_date,concat(d.PBI_ID,'- ',d.PBI_NAME) as dealer_name,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details,m.rcv_amt as SEND_AMT,m.received_amt as RCV_AMT from 
sale_other_master m,personnel_basic_info d
where m.issue_type='StaffSales' and m.status in ('PROCESSING')  and m.dealer_code=d.PBI_ID ".$con." order by m.do_date,d.PBI_NAME";
$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_date;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->area;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->DP_Total;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->Payment_Details;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->SEND_AMT;?></td>
<td>&nbsp;
    <?=$data->RCV_AMT;?></td>
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
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>