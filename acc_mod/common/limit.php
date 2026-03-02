<?php
session_start();
$proj_id=$_SESSION['proj_id'];
require("db_connect.php");
$id=$_REQUEST['id'];

$a2="select SUM(cr_amt)-SUM(dr_amt) from journal where ledger_id='$id' and 1";
$a1=mysqli_fetch_row(db_query($a2));
if($a1[0]<0)
$a1[0]=$a1[0]*(-1);
else
if(is_null($a1[0]))
$a1[0]=0;
?> 
<table width="100" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">Limit :</td>
    <td align="left"><? echo "<input name=\"limitt\" type=\"text\" id=\"limitt\" size=\"10\" maxlength=\"15\" value=\"$a1[0]\" readonly=\"readonly\"/>";?></td>
  </tr>
</table>
