<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Select Employee for Staff Sales Order';
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
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['status']='PROCESSING';
		
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}

auto_complete_from_db('personnel_basic_info','concat(PBI_ID," -:- ",PBI_NAME)','PBI_ID','PBI_JOB_STATUS="In Service"','dealer');
?>
<script language="javascript">
window.onload = function() {document.getElementById("dealer").focus();}
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
    <td align="right" bgcolor="#FF9966"><strong>Select Employee: </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input name="dealer" type="text" id="dealer" />
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Create DO" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>