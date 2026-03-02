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
<td width="40%"><div align="right">Ledger Sub A/C Head :</div></td>
<td align="left">
	<select name="sub_ledger_id" id="sub_ledger_id">
	<option></option>
		<? foreign_relation('sub_ledger','sub_ledger_id','sub_ledger',$_REQUEST['sub_ledger_id']," ledger_id='".$data[0]."' and group_for=".$_SESSION['user']['group']);?>
	</select>
</td>
</tr>
</table>