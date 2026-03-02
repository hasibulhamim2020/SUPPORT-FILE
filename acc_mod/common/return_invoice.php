<?php session_start();
$c=$_SESSION['count'];
$_SESSION['data'.($c+1)]=$_REQUEST['a'];
$_SESSION['data'.($c+2)]=$_REQUEST['b'];
$_SESSION['data'.($c+3)]=$_REQUEST['c'];
$_SESSION['data'.($c+4)]=$_REQUEST['d'];
$_SESSION['data'.($c+5)]=$_REQUEST['e'];
$_SESSION['data'.($c+6)]=$_REQUEST['f'];
$_SESSION['data'.($c+7)]=$_REQUEST['g'];

$_SESSION['count']=$_SESSION['count']+7; 
?>
<table width='100%' border="2" bordercolor="#333333" bgcolor="#FFFFFF" style="border-collapse:collapse" class="style2">
<?php
for($j=0; $j<($c+7)/7; $j++){
?>
<tr align="center">
    <td width="5%" ><?php echo $_SESSION['data'.($j*7+6)];?></td>
    <td width="40%"><?php echo $_SESSION['data'.($j*7+1)];?></td>
    <td width="11%"><?php echo $_SESSION['data'.($j*7+7)];?></td>
    <td width="11%"><?php echo $_SESSION['data'.($j*7+2)];?></td>
    <td width="11%"><?php echo $_SESSION['data'.($j*7+3)];?></td>
    <td width="11%"><?php echo $_SESSION['data'.($j*7+4)];?></td>
    <td width="16%"><?php echo $_SESSION['data'.($j*7+5)];?></td>
</tr>
<?php }?>