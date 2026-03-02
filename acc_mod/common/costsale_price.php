<?php
require("db_connect.php");
$id=$_REQUEST['id'];
if($id<100000)
$a2="select cost_price,sale_price from item_info where item_id='$id'";
$a1=mysqli_fetch_row(db_query($a2));
echo "<td align=\"center\"><input name=\"trate\" type=\"text\" id=\"trate\" value=\"$a1[0]\" size=\"12\" maxlength=\"15\" readonly/></td>
<td align=\"center\"><input name=\"rate\" type=\"text\" id=\"rate\" value=\"$a1[1]\" size=\"12\" onchange=\"t_rate(this.value);\"/></td>";

?> 
