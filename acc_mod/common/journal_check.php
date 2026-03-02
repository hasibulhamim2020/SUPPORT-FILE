<?php
session_start();
$proj_id=$_SESSION['proj_id'];
require("db_connect.php");
$type=$_REQUEST['type'];
$a2="select ledger_id, ledger_name from accounts_ledger where balance_type IN ('$type','Both') and 1 order by ledger_name";
$a1=db_query($a2);
echo "<select name=\"ledger_id\" id=\"ledger_id\" onchange=\"open_bal(this.value)\">";
while($a=mysqli_fetch_row($a1))
{
echo "<option value=\"".$a[0]." : ".$a[1]."\">".$a[1]."</option>";
}
echo "</select>";
?> 

