<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Warehouse Transfer Re-Check';

$table = 'warehouse_transfer_master';
$unique = 'pi_no';
$status = 'UNCHECKED';
$target_url = '../wh_transfer/depot_transfer_checking.php';

$table_master='warehouse_transfer_master';
$unique_master='pi_no';

$table_detail='warehouse_transfer_detail';
$unique_detail='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='SEND';
		$pi = find_all_field('warehouse_transfer_master','pi_no','pi_no='.$$unique_master);
		
//$sales_ledger = 1098000100000000;
//$ledger = find_a_field('warehouse','fg_ledger_id','warehouse_id='.$pi->warehouse_to);	
//$cc_code = find_a_field('warehouse','acc_code','warehouse_id='.$pi->warehouse_from);	
//$narration = 'PI No-'.$pi_no.'|| SendDt:'.$pi->pi_date;
//auto_insert_depot_sales_issue($pi->pi_date,$ledger,$sales_ledger,$pi_no,find_a_field('warehouse_transfer_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);


		$sql = 'select * from warehouse_transfer_detail where pi_no='.$$unique_master;
		
		$query = mysqli_query ($sql);
		
		while($data=mysqli_fetch_object($query)){
		
journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->pi_date ,0,$data->total_unit ,'Transit',$data->id,$data->unit_price,$pi->warehouse_to,$$unique_master);


}

		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Send.';
}

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		
		$sql = "delete from journal_item where tr_from = 'Transfered' and sr_no = '".$$unique_master."'";
		db_query($sql);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}

if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}

?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td width="44%">&nbsp;</td>
    <td width="34%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>
    <td bgcolor="#FF9966"><strong>
      <?php /*?><select name="<?=$unique?>" id="<?=$unique?>" style="width:340px; height:25px;">
	  <option></option>
                <? 
		echo $sql = "select b.pi_no, concat(w.warehouse_name,' :: TR No: ',b.pi_no) from warehouse_transfer_master b,warehouse w 
where b.warehouse_to=w.warehouse_id and b.status in ('SEND','RECEIVED')  ";
		foreign_relation_sql($sql);?>
      </select><?php */?>
	  
	  
	  <input type="text" name="<?=$unique?>" id="<?=$unique?>" value="" style="width:150px; height:30px;" />
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>