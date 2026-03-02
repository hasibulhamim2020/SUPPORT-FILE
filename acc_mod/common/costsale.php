<?php
require("db_connect.php");
$item_id=$_REQUEST['item_id'];

$ledgers = explode('::',$item_id);
$search=array( ":"," ", "[", "]", $separater);
$ledger1=str_replace($search,'',$ledgers[0]);
$ledger2=str_replace($search,'',$ledgers[1]);

if(is_numeric($ledger1))
$item_id = $ledger1;
else
$item_id = $ledger2;

$warehouse_id=$_REQUEST['warehouse_id'];
$a2="select a.cost_price,a.sale_price,(select (b.purchase_amt-b.sale_amt+b.receive_amt-b.issue_amt) from inventory_stock b where  b.item_id='$item_id' and b.warehouse_id='$warehouse_id') from item_info a where a.item_id='$item_id' ";
$a1=mysqli_fetch_row(db_query($a2));
?><nobr>               
<input name="trate" type="text" id="trate" value="<?php echo $a1[0]; ?>" readonly/> 
<input name="rate" type="text" id="rate" value="<?php echo $a1[1]; ?>" /> 
<input name="qoh" type="text" id="qoh" value="<?php echo (int)($a1[2]); ?>" readonly/></nobr>