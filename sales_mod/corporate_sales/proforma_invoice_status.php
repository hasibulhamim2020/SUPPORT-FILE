<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Proforma Invoice Status';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sales_return_detail';
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
		$do_no=$_POST['do_no'];

		$_POST[$unique_master]=$$unique_master;
		$_POST['send_to_depot_at']=date('Y-m-d H:i:s');
		$_POST['do_date']=date('Y-m-d');
		$_POST['status']="CHECKED";
		
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
				unset($_POST);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='sale_do_master';
$show='dealer_code';
$id='do_no';
$text_field_id='do_no';

$target_url = 'proforma_invoice_print_view.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
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
        <td align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="dealer_code" id="dealer_code" style="width:250px;">
		
		<option></option>

        <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');?>
    </select>
		</td>
        <td rowspan="4" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval:</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=($_POST[fdate]!='')?$_POST[fdate]:date('Y-m-1')?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:120px;" value="<?=($_POST[tdate]!='')?$_POST[tdate]:date('Y-m-d')?>" />
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="9%">WO No</th>
  <th width="10%">WO Date</th>
  <th width="11%">Job No </th>
  <th width="19%">Customer Name</th>
  <th width="18%">Buyer  Name</th>
  <th width="20%">Merchandiser Name</th>
  <!--<th>Zone</th>-->
<th width="13%">Entry By </th>
  </tr>


<? 

if(isset($_POST['submitit'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


		
		
		if($_POST['dealer_code']!='')
 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";




    $res="select m.do_no, m.do_no, m.job_no,  m.do_date, m.dealer_code, m.buyer_code, m.merchandizer_code,  d.dealer_name_e, m.entry_by from 
sale_do_master m, sale_do_details c, dealer_info d, user_group u 
where 

m.status != 'MANUAL'  and m.group_for=u.id  and m.dealer_code=d.dealer_code and m.do_no=c.do_no ".$group_for_con.$con.$dealer_con."  group by c.do_no order by  m.do_date, m.do_no ";
$query = db_query($res);

$two_weeks = time() - 14*24*60*60;
while($data = mysqli_fetch_object($query))
{

?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?php echo date('d-m-Y',strtotime($data->do_date));?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->job_no;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name_e;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('buyer_info','buyer_name','buyer_code='.$data->buyer_code);?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$data->merchandizer_code);?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;
  <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
}
}
?>


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