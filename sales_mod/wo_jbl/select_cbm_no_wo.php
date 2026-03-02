<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Work Order Entry';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

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

$target_url = '../wo/do.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?cbm_no='+theUrl);
}
</script><div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td width="420">&nbsp;</td>
        <td width="466">&nbsp;</td>
        <td width="141">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
        <td bgcolor="#FF9966">
		<select name="dealer_code" id="dealer_code" style="width:250px;">
		
		<option></option>

        <?
		
		foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');

		?>
    </select>
		
		</td>
        <td rowspan="2" bgcolor="#FF9966"><strong>
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
  <th>CBM No </th>
  <th>Customer Name </th>
  <th>Buyer Name </th>
  <th>Merchandiser Name</th>
  </tr>


<? 

if(isset($_POST['submitit'])){

}

//if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 
$con .= ' and r.dealer_code in ('.$_POST['dealer_code'].') ';



   $res="select r.cbm_no, r.cbm_no, d.dealer_name_e, b.buyer_name, m.merchandizer_name from raw_input_sheet r, dealer_info d, buyer_info b, merchandizer_info m where r.dealer_code=d.dealer_code and r.buyer_code=b.buyer_code and r.merchandizer_code=m.merchandizer_code  ".$con." group by r.cbm_no order by r.cbm_no ";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
  <td onClick="custom(<?=$data->cbm_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->cbm_no;?></td>
<td onClick="custom(<?=$data->cbm_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= $data->dealer_name_e;?></td>
<td onClick="custom(<?=$data->cbm_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->buyer_name;?></td>
<td onClick="custom(<?=$data->cbm_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->merchandizer_name;?></td>
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