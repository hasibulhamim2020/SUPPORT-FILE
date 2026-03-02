<table width='100%' border="2" bordercolor="#333333" style="background-color:#FFFFFF;" style="border-collapse:collapse" class="style2">
	<tr align="left">
		<td colspan="4" align="center">
			<font style="color:#FF0000; font-weight:bold;">Could not find the ledger head!! Plz insert the one you want to.</font>
		</td>
              <td width="33%"><?php echo $ledger; ?></td>
              <td width="11%"><?php echo $_SESSION['data'.($j*5+3)]; ?></td>
              <td width="38%"><?php echo $_SESSION['data'.($j*5+4)]; ?></td>
              <td width="18%"><?php echo number_format($_SESSION['data'.($j*5+5)],2); ?></td>
    </tr>