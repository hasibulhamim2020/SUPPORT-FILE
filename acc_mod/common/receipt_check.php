<?php
session_start();
$proj_id=$_SESSION['proj_id'];
require("db_connect.php");
$type=$_REQUEST['type'];
exit();
$cash_and_bank_balance=find_a_field('config_group_class','cash_and_bank_balance',"1");
if($type=='Debit')
$a2="select ledger_id, ledger_name from accounts_ledger where ledger_group_id='$cash_and_bank_balance' and 1 order by ledger_name";
else
$a2="select ledger_id, ledger_name from accounts_ledger where balance_type IN ('$type') and 1 order by ledger_name";
$a1=db_query($a2);
echo "<select name=\"ledger_id\" id=\"ledger_id\" onchange=\"open_bal(this.value)\">";
while($a=mysqli_fetch_row($a1))
{
echo "<option value=\"".$a[0]." : ".$a[1]."\">".$a[1]."</option>";
}
echo "</select>";
?> 

