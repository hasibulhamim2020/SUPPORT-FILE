<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Select Production Line for Issue';

$table_master='production_issue_master';
$unique_master='pi_no';

$table_detail='production_issue_detail';
$unique_detail='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='SEND';
		$pi = find_all_field('production_issue_master','pi_no','pi_no='.$$unique_master);

		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
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
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}


?>
<script language="javascript">
window.onload = function() {document.getElementById("dealer").focus();}
</script>
<div class="form-container_large">
<form action="production_issue.php" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
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
    <td align="right" bgcolor="#FF9966"><strong>Select Depot: </strong></td>
    <td bgcolor="#FF9966"><strong>
      	  <select name="line_id" id="line_id" style="width:200px;" required>
		  <option></option>
	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="SD" order by warehouse_name');?>
<option value="51">Damage Section(Store Damage)</option>
	  </select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Create PI" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
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