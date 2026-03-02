<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Dealer for Demand Order';

$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details_temp';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$table_detail2='sale_do_details';
$unique_detail2='id';




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
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='PROCESSING';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
		$sql = 'insert into '.$table_detail2.' select * from '.$table_detail.' where '.$unique_master.'="'.$$unique_master.'"';
		db_query($sql);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}

auto_complete_from_db('dealer_info','dealer_name_e','dealer_code','account_code>0','dealer');
?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<div class="form-container_large">
<form action="do.php" method="post" name="codz" id="codz">
<table width="70%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#00bfff"><strong>Active Dealer List: </strong></td>
    <td bgcolor="#00bfff"><strong>
      <input name="dealer" type="text" class="from-control" id="dealer" />
    </strong></td>
    <td bgcolor="#00bfff"><strong>
      <input type="submit" name="submitit" id="submitit" value="Create DO" style="width:170px; font-weight:bold; font-size:15px; height:30px; color:black"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>