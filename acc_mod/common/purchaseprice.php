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
$a2="select a.qty,a.purchase_date from purchase_invoice a where a.item='$item_id' order by id desc limit 1";
$a1=mysqli_fetch_row(db_query($a2));
$a3="select (b.purchase_amt-b.sale_amt+b.receive_amt-b.issue_amt) from inventory_stock b where  b.item_id='$item_id' and b.warehouse_id='$warehouse_id'";
$a4=mysqli_fetch_row(db_query($a3));
?><nobr>               
<input name="lp_qty" type="text" id="lp_qty" value="<?php echo $a1[0]; ?>" readonly/> 
<input name="lp_date" type="text" id="lp_date" value="<?php echo $a1[1]; ?>" /> 
<input name="qoh" type="text" id="qoh" value="<?php echo number_format(($a4[0]),2); ?>" readonly/></nobr>