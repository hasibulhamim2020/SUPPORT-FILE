<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Invoice Status';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique_master='do_no';

 $master_id = find_a_field('user_activity_management','master_user','user_id='.$_SESSION['user']['id']);

create_combobox('do_no');
create_combobox('dealer_code');

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

$target_url = 'sales_invoice_print_view.php';


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


<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 280px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

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
		<select name="dealer_code" id="dealer_code" style="width:280px;">
		
		<option></option>

        <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'depot="'.$_SESSION['user']['depot'].'" order by dealer_code');?>
    </select>		</td>
        <td rowspan="5" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval:</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
		<!--<input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=($_POST[fdate]!='')?$_POST[fdate]:date('Y-m-1')?>" />-->
          <input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:120px;" value="<?=$_POST['tdate']?>" />
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Warehouse: </strong></td>
        <td colspan="3" bgcolor="#FF9966">
		
	
	
	<? if($master_id==1){?>	
                      <select name="warehouse_id" id="warehouse_id" style=" float:left; width:300px;">
					  
					  <option></option>

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');?>
 
                      </select>
					  
				<? }?>
					  
					  <? if($master_id==0){?>	
			
					  <select name="warehouse_id" id="warehouse_id" style=" float:left; width:300px;">
				

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
 
                      </select>
					
				 <? }?>	 
		
		</td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="5%">SO No</th>
  <th width="10%">SO Date</th>
  <th width="26%">Customer Name</th>
  <th width="13%">Sales Type </th>
  <th width="15%">Warehouse Name</th>
  <!--<th>Zone</th>-->
<th width="13%">Entry By </th>
  <th width="18%">Status</th>
</tr>


<? 

if(isset($_POST['submitit'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


		
		
		if($_POST['dealer_code']!='')
 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
		
		if($_POST['warehouse_id']!='') 
		$con .= ' and m.depot_id in ('.$_POST['warehouse_id'].') ';




    $res="select m.do_no, m.do_no, m.do_date, m.dealer_code, m.sales_type, m.depot_id, c.chalan_no, d.dealer_name_e, m.entry_by, m.status from 
sale_do_master m, sale_do_chalan c,  dealer_info d, user_group u 
where 
  m.group_for=u.id  and m.dealer_code=d.dealer_code and m.do_no=c.do_no ".$group_for_con.$con.$dealer_con."  group by c.do_no order by  m.do_date, m.do_no ";
$query = db_query($res);

//$two_weeks = time() - 14*24*60*60;
while($data = mysqli_fetch_object($query))
{

?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->chalan_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
<td onClick="custom(<?=$data->chalan_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?php echo date('d-m-Y',strtotime($data->do_date));?></td>
<td onClick="custom(<?=$data->chalan_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name_e;?></td>
<td onClick="custom(<?=$data->chalan_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('sales_type','sales_type','id='.$data->sales_type);?></td>
<td onClick="custom(<?=$data->chalan_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('warehouse','warehouse_name','warehouse_id='.$data->depot_id);?></td>
<td onClick="custom(<?=$data->chalan_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;
  <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
<td onClick="custom(<?=$data->chalan_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->status;?></td>
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