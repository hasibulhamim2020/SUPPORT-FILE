<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Draft Work Order';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

create_combobox('old_do_no');

$table_details='sale_do_details';
//$unique_chalan='id';

$$unique=$_POST[$unique];

//if(isset($_POST['delete']))
//{
//		$crud   = new crud($table_master);
//		$condition=$unique_master."=".$$unique_master;		
//		$crud->delete($condition);
//		$crud   = new crud($table_detail);
//		$crud->delete_all($condition);
//		$crud   = new crud($table_chalan);
//		$crud->delete_all($condition);
//		unset($$unique_master);
//		unset($_SESSION[$unique_master]);
//		$type=1;
//		$msg='Successfully Deleted.';
//}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='COMPLETED';
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
$do_no='do_no';
$text_field_id='do_no';

$target_url = '../wo/do_draft.php';


?>

<style>

.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}


div.form-container_large input {
    width: 250px;
    height: 40px;
    border-radius: 0px !important;
}



</style>



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
</script><div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td width="153">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td width="141">&nbsp;</td>
      </tr>
      <tr>
        
        <td rowspan="3" bgcolor="#FF9966">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Job No: </strong></td>
        <td bgcolor="#FF9966">
		<select name="old_do_no" id="old_do_no" style="width:250px;">
		
		<option></option>

        <?
		
		foreign_relation('sale_do_master','do_no','job_no',$_POST['old_do_no'],'status="MANUAL"');

		?>
    </select>		</td>
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
<tr>
  <th width="14%">WO No </th>
  <th width="18%">WO Date </th>
  <th width="23%">Job No </th>
  <th width="45%">Customer Nam </th>
  </tr>


<? 

if(isset($_POST['submitit'])){

}

//if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 
$con .= ' and m.dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['old_do_no']!='') 
$con .= ' and m.do_no in ('.$_POST['old_do_no'].') ';



  $res="select m.do_no as old_do_no, m.do_no, m.job_no, m.dealer_code, m.do_date,   m.buyer_code, m.merchandizer_code, m.status from sale_do_master m, sale_do_details d where m.do_no=d.do_no and m.status='MANUAL'  ".$con." group by m.do_no order by m.do_date, m.do_no ";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
  <td onClick="custom(<?=$data->old_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->do_no;?></td>
<td onClick="custom(<?=$data->old_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?php echo date('d-m-Y',strtotime($data->do_date));?></td>
<td onClick="custom(<?=$data->old_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->job_no;?></td>
<td onClick="custom(<?=$data->old_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$data->dealer_code.'"');?></td>
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
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>