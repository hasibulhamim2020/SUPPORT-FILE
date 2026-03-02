<?php session_start();
$c=$_SESSION['count'];
$_SESSION['data'.($c+1)]=$_REQUEST['a'];
$_SESSION['data'.($c+2)]=$_REQUEST['b'];
$_SESSION['data'.($c+3)]=$_REQUEST['c'];
$_SESSION['data'.($c+4)]=$_REQUEST['d'];
$_SESSION['data'.($c+5)]=$_REQUEST['e'];
$_SESSION['data'.($c+6)]=$_REQUEST['f'];
$_SESSION['count']=$_SESSION['count']+6; 
?>
<table width='100%' border="2" bordercolor="#333333" bgcolor="#FFFFFF" style="border-collapse:collapse" class="style2">
<?php
for($j=0;$j<($c+6)/6;$j++){
?>
<tr align="center" height="25">
  <td width="23%">&nbsp;<?php echo $_SESSION['data'.($j*6+1)];?></td>
  <td width="11%">&nbsp;<?php echo $_SESSION['data'.($j*6+6)];?></td>
  <td width="10%">&nbsp;<?php echo $_SESSION['data'.($j*6+2)];?></td>
  <td width="9%">&nbsp;</td>
  <td width="10%">&nbsp;</td>
  <td width="10%">&nbsp;<?php echo $_SESSION['data'.($j*6+3)];?></td>
  <td width="11%">&nbsp;<?php echo $_SESSION['data'.($j*6+4)];?></td>
  <td width="16%">&nbsp;<?php echo $_SESSION['data'.($j*6+5)];?></td>
</tr>
<?php }?>
</table>