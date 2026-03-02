<?php
session_start();
require "../../damage_mod/support/inc.all.acc.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%"><div align="right">Ledger A/C Head : </div></td>
    <td align="left">
<select name="ledger_id" id="ledger_id"  onchange="getData2('layer_sub_ledger_id_ajax.php', 'sub_ledger_id', this.value,  this.value)">
<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_REQUEST['sub_ledger_id'],"ledger_id like '%00000000' and ledger_group_id='".$data[0]."' and group_for=".$_SESSION['user']['group']);?>
</select>
	</td>
  </tr>
</table>