<?php
require("db_connect.php");
$id=$_REQUEST['id'];
if($id<100000)
$a2="select cost_price,sale_price,rcvqty-saleqty+returnqty-issueqty from item_info where item_id='$id'";
$a1=mysqli_fetch_row(db_query($a2));
/*
echo "<input name='trate' type='text' id='trate' value='$a1[0]' size='10' readonly/>
&nbsp;&nbsp;&nbsp;
<input name='rate' type='text' id='rate' value='$a1[1]' size='10' onchange='t_price(this.value);' />
&nbsp;&nbsp;&nbsp;
<input name='qoh' type='text' id='qoh' value='$a1[2]' size='8' onchange='t_price(this.value);'/>";
*/
?>
<td align="center"><input name="trate" type="text" id="trate" value="<?php echo $a1[0]; ?>" size="10" readonly/></td>
<td align="center"><input name="rate" type="text" id="rate" value="<?php echo $a1[1]; ?>" size="10" readonly/></td>
<td align="center"><input name="qoh" type="text" id="qoh" value="<?php echo $a1[2]; ?>" size="8" readonly/></td>                
