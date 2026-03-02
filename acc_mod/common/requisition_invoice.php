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
<table width='100%' border="2" bordercolor="#333333" style="background-color:#FFFFFF;" style="border-collapse:collapse" class="style2">
<?php
for($j=0;$j<($c+6)/6;$j++){
?>
<tr align="center" height="25">
  <td width="33%">&nbsp;<?php echo $_SESSION['data'.($j*6+1)];?></td>
  <td>&nbsp;<?php echo $_SESSION['data'.($j*6+6)];?>&nbsp;</td>
  <td>&nbsp;<?php echo $_SESSION['data'.($j*6+5)];?>&nbsp;&nbsp;</td>
  </tr>
<?php }?>
</table>