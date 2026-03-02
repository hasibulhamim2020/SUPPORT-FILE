<?php
require("db_connect.php");
$item_id=$_REQUEST['item_id'];
$warehouse_id=$_REQUEST['warehouse_id'];
$a2="select (b.purchase_amt-b.sale_amt+b.receive_amt-b.issue_amt) from inventory_stock b where b.item_id='$item_id' and  b.warehouse_id='$warehouse_id' limit 1";
$a1=mysqli_fetch_row(db_query($a2));
?>              
<input name="available_stock" type="text" id="available_stock" style="width:80px;float:left" size="15" maxlength="15" value="<?php echo $a1[0];?>" readonly/>