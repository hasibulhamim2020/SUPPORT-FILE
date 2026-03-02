<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Unapprove Other Issue';
do_calander('#fdate');
do_calander('#tdate');
$table_master='purchase_return_master';
$unique_master='pr_no';

 $master_id = find_a_field('user_activity_management','master_user','user_id='.$_SESSION['user']['id']);

//create_combobox('pr_no');
create_combobox('vendor_id');

$table_detail='purchase_return_detail';
$unique_detail='id';
auto_insert_sales_return_secoundary("11");
//$table_chalan='purchase_return_details';
//$unique_chalan='id';

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
if(isset($_POST['return_remarks']) && $_POST['return_remarks']!=""){
        
		
		$remarks = $_POST['return_remarks'];
        unset($_POST);

		$_POST[$unique_master]=$$unique_master;
        $_POST['status']='MANUAL';
		$_POST['checked_at'] = date('Y-m-d H:i:s');
		$_POST['checked_by'] = $_SESSION['user']['id'];
		$crud   = new crud($table_master);
		$crud->update($unique_master);

		
		
		$note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique_master.'","PurchaseReturn","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
		db_query($note_sql);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;
        
        echo $msg='<span style="color:green;">Successfully Returned</span>';
}

if(isset($_POST['cancel']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['status']='CANCELED';
		$_POST['checked_at'] = date('Y-m-d H:i:s');
		$_POST['checked_by'] = $_SESSION['user']['id'];
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		echo $msg='<span style="color:red;">Successfully Canceled</span>';
}

if(isset($_POST['confirmm']))

{
$or_no = $_REQUEST['pr_no'];
if($or_no>0){
$jv_no=next_journal_sec_voucher_id();
$jv_date = $_POST['pr_date'];
$proj_id = 'clouderp'; 
$group_for =  $_SESSION['user']['group'];
$cc_code = '1';
$tr_no = $or_no;
$tr_from = 'PurchaseReturn';
$narration = 'PurchaseReturn#'.$or_no;
$vendor_ledger = find_a_field('vendor','ledger_id','vendor_id="'.$_POST['vendor_id'].'"');

 
$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d h:i:s');

$do_master = find_all_field('purchase_return_master','pr_no','pr_no='.$or_no);



 $do_sql = "select a.*, m.pr_no,m.depot_id,m.return_type, m.pr_date,s.return_type,sub.ledger_id from purchase_return_master m, purchase_return_details a, item_info b, purchase_return_type s, item_sub_group sub where b.sub_group_id=sub.sub_group_id and  m.return_type=s.id and  m.pr_no=a.pr_no and  b.item_id=a.item_id  and a.pr_no='".$or_no."' order by a.id ";

$do_query = db_query($do_sql);	
        
		while($do_data=mysqli_fetch_object($do_query))

		{ $tr_id = $do_data->id;
		$avg_rate = find_a_field('journal_item', '(sum(item_in*final_price)-sum(item_ex*final_price))/(sum(item_in)-sum(item_ex))', 'item_id = "'.$do_data->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
	journal_item_control($do_data->item_id, $do_data->depot_id, $do_data->pr_date, 0,$do_data->total_unit,   $do_data->return_type, $do_data->id, $do_data->unit_price, $do_data->depot_id, $do_data->pr_no, '', '',$do_master->group_for, $avg_rate, '' );
	
	
add_to_sec_journal($proj_id, $jv_no, $jv_date, $do_data->ledger_id, $narration, '0', ($do_data->total_amt), $do_data->return_type, $tr_no,'',$tr_id,$cc_code,$group_for);
  $total_amt +=$do_data->total_amt;
  $return_type = $do_data->return_type;
		}
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vendor_ledger, $narration, $total_amt, '0', $return_type, $tr_no,'',$tr_id=0,$cc_code,$group_for);

		$sql2 = 'update purchase_return_details set status="CHECKED" where pr_no = '.$or_no;
		db_query($sql2);
		
		  $sql3 = 'update purchase_return_master set status="CHECKED", invoice_no="'.$chalan_no.'" where pr_no = '.$or_no;
		db_query($sql3);

	//auto_insert_sales_return_secoundary($chalan_no);

header('location:unapproved_pr.php');

//echo '<span style="color:green;">Purchase Return Approved</span>';
}
}


$table='purchase_return_master';
$show='vendor_id';
$id='pr_no';
$text_field_id='pr_no';

$target_url = 'return_checking.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?pr_no='+theUrl+'','_self');
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
    width: 90%;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="90%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Customer:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="vendor_id" id="vendor_id" style="width:280px;">
		
		<option></option>

        <? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'1 order by vendor_id');?>
    </select>		</td>
        <td rowspan="5" align="center" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
        </strong></td>
      </tr>
      
      <tr>
        <td align="right" width="20%" bgcolor="#FF9966"><strong>Date:</strong></td>
        <td    width="20%"  bgcolor="#FF9966"><strong>
		<!--<input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=($_POST[fdate]!='')?$_POST[fdate]:date('Y-m-1')?>" />-->
          <input type="text" name="fdate" id="fdate" style="width:100%;" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td align="center"  width="20%"  bgcolor="#FF9966"><strong> -to- </strong></td>
        <td   width="20%"  bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:100%;" value="<?=$_POST['tdate']?>" />
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Warehouse: </strong></td>
        <td colspan="3" bgcolor="#FF9966">
		
	
	
	<? if($master_id==1){?>	
                      <select name="warehouse_id" id="warehouse_id" style=" float:left; width:90%;">
					  
					  <option></option>

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');?>
 
                      </select>
					  
				<? }?>
					  
					  <? if($master_id==0){?>	
			
					  <select name="warehouse_id" id="warehouse_id" style=" float:left; width:90%;">
				

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
<table width="100%" cellspacing="0" cellpadding="0" id="grp" style="font-size:12px;"><tbody>
<tr>
  <th width="5%">OI No</th>
  <th width="10%">OI Date</th>
  <th width="26%">Customer Name</th>
  <th width="13%">Return Type </th>
  <th width="15%">Warehouse Name</th>
  <!--<th>Zone</th>-->
<th width="13%">Entry By </th>
  </tr>


<? 

if(isset($_POST['submitit'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.pr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


		
		
		if($_POST['vendor_id']!='')
 		$dealer_con=" and m.vendor_id='".$_POST['vendor_id']."'";
		
		if($_POST['warehouse_id']!='') 
		$con .= ' and m.depot_id in ('.$_POST['warehouse_id'].') ';




$res="select m.pr_no, m.pr_no, m.pr_date, m.vendor_id, m.return_type	, m.depot_id,  d.vendor_name, m.entry_by, m.status from 
purchase_return_master m, purchase_return_details c,  vendor d, user_group u 
where 
  m.group_for=u.id  and m.vendor_id=d.vendor_id and m.pr_no=c.pr_no and m.status='UNCHECKED' ".$group_for_con.$con.$dealer_con."  group by c.pr_no order by  m.pr_date, m.pr_no ";
$query = db_query($res);

//$two_weeks = time() - 14*24*60*60;
while($data = mysqli_fetch_object($query))
{

?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->pr_no;?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?php echo date('d-m-Y',strtotime($data->pr_date));?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->vendor_name;?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('purchase_return_type','return_type','id='.$data->return_type);?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('warehouse','warehouse_name','warehouse_id='.$data->depot_id);?></td>
<td onClick="custom(<?=$data->pr_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;
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