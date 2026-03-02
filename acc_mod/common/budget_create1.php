<?php
session_start();
$proj_id=$_SESSION['proj_id'];
require("db_connect.php");
$f_year=$_REQUEST['f_year'];
$sql="select a.ledger_name,b.group_name,a.ledger_id from accounts_ledger a, ledger_group b where a.ledger_group_id=b.group_id and a.ledger_id NOT IN (select ledger_id from monthly_budget where 1 and f_year='$f_year') and 1 order by a.ledger_name";
$query=db_query($sql);
echo "        <table width=\"70%\" border=\"1\" align=\"center\" bordercolor=\"#006699\" class=\"style2\">
          <tr>
            <td width=\"39%\" height=\"22\" align=\"center\"><span class=\"style5\">Ledger Group </span></td>
            <td width=\"48%\" align=\"center\"><span class=\"style5\">Ledger ID</span></td>
            <td width=\"13%\" align=\"center\"><span class=\"style5\">Select</span></td>
          </tr>";
while($data=mysqli_fetch_row($query)){
		  ?>
		  <tr>
            <td height="22" align="center" valign="top"><?php echo $data[0];?></td>
            <td align="center" valign="top"><?php echo $data[1];?></td>
            <td align="center" valign="top">              
			<input name="<?php echo $data[2];?>" type="checkbox" value="on" />
			</td>
          </tr>
		  <?php }?> 
		  </table>

