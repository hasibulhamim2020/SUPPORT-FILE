<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#quotation_date');
$title='Purchase Invoice';
$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
$cash_and_bank_balance=find_a_field('config_group_class','cash_and_bank_balance',"1");
$payable=find_a_field('config_group_class','payable',"1");
//Journal Voucher Number Create
$jv=next_value('p_inv_id','purchase_invoice');

if($_POST['invoice_varify'])
{
$date=$_REQUEST["date"];
$j=0;
for($i=0;$i<strlen($date);$i++)
{
if(is_numeric($date[$i]))
$time[$j] = $time[$j].$date[$i];
else $j++;
}
	$date		= mktime(0,0,0,$time[1],$time[0],$time[2]);
	$d_inv_amt	= $_REQUEST["d_inv_amt"];
	$f_inv_amt	= $_REQUEST["f_inv_amt"];
	$f_paid		= $_REQUEST["f_paid"];
	$vendor		= $_REQUEST["vendor"];
	//$r_from		= $_REQUEST['r_from'];
	$c_no		= $_REQUEST['c_no'];
	$c_date		= $_REQUEST['date'];
	$c_id		= $_REQUEST['c_id'];
	$req_no		= $_REQUEST['req_no'];
	$delivery_within		= $_REQUEST['delivery_within'];
	$quotation_no= $_REQUEST['quotation_no'];
	$quotation_date= $_REQUEST['quotation_date'];
		
$c = $_SESSION['count'];
$narration = ($c/6)." Item purchased with ".$d_inv_amt." Discount.";
for($i=0;$i<($c/6);$i++)
{
	$item	= $_SESSION['data'.(($i*6)+1)];
	$rate	= $_SESSION['data'.(($i*6)+2)];
	$qty	= $_SESSION['data'.(($i*6)+3)];
	$disc	= $_SESSION['data'.(($i*6)+4)];
	$amount	= $_SESSION['data'.(($i*6)+5)];
	$warehouse= $_SESSION['data'.(($i*6)+6)];
	
$ledgers = explode('::',$item);
$search=array( ":"," ", "[", "]", $separater);
$ledger1=str_replace($search,'',$ledgers[0]);
$ledger2=str_replace($search,'',$ledgers[1]);

if(is_numeric($ledger1))
$item = $ledger1;
else
$item = $ledger2;
	

	$recept="INSERT INTO `purchase_invoice` (
	`p_inv_id` ,
	`vendor`,
	`item` ,
	`rate` ,
	`qty` ,
	`disc` ,
	`amount`,
	`paid_amount`,
	warehouse_id,
	purchase_date,
	entry_by,
	entry_at,
	req_no,
	total_disc,
	total_amt,
	quotation_no,
	quotation_date,
	delivery_within
	 )
	VALUES ('$jv', '$vendor', '$item', '$rate', '$qty', '$disc', '$amount','$f_paid','$warehouse','$c_date','".$_SESSION['user']['id']."','".time()."','$req_no','$d_inv_amt','$f_inv_amt','$quotation_no','$quotation_date','$delivery_within')";
	$query_coutra=db_query($recept);
	
	//purchase_stock_manage($item,$warehouse,$qty);
}
}
$jv=next_value('p_inv_id','purchase_invoice');
// SESSION FLUSH FOR MULTIPLE ROW INFO REMOVE
include 'session_flush_n_register.php';
// =========================================
?>
<script src="../common/purchase_invoice.js" language="javascript"></script>
<?php
	
    $led2=db_query("select item_id, item_name from item_info order by item_name");
	if(mysqli_num_rows($led2) > 0)
	{
      $data2 = '[';
	  while($ledg2 = mysqli_fetch_row($led2)){
          $data2 .= '{ name: "'.addslashes($ledg2[1]).'", id: "'.$ledg2[0].'" },';
	  }
      $data2 = substr($data2, 0, -1);
      $data2 .= ']';
	}
	else
	{
		$data2 = '[{ name: "empty", id: "" }]';
	}
?>
<script type="text/javascript">

$(document).ready(function(){
	
	$("#date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
			$("#c_date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'Y-mm-dd'
		});
	
	

    function formatItem(row) {}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
    var data2 = <?php echo $data2; ?>;
	<?
	echo '
	$("#item").autocomplete(data2, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
		//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style="font-size: 80%;">ID: " + row.id + "</span>"; 
			';
			
            echo 'return row.name + " [" + row.id + "]";';
			
		echo '},
		formatResult: function(row) {
			return  row.id + "::" + row.name;
		}
	});';
	?>
});
function DoNav(theUrl)
{
	var URL = 'invoice_view_popup.php?'+theUrl;
	popUp(URL);
}
function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="report">
  <div align="left">
    <form id="form1" name="form1" method="post" action="purchase_invoice.php" onsubmit="return checking()">
      <table width="600" border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
        <tr>
          <td>
		  <table width="100%" border="0" cellspacing="2" cellpadding="2">
					  <tr>
						<td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                          <tr>
                            <td><div align="right">Invoice No : </div></td>
<td><input name="invoice_no" type="text" id="invoice_no" size="13" style="width:100px" value="<?php echo $jv;?>" readonly/></td>
                          <td>Date :</td>
                          <td><input name="date" value="<?php echo date("Y-m-d",time());?>" type="text" id="date" size="10" tabindex="1" style="width:80px;" /></td>
                          </tr>
                          <tr>
                            <td align="right">Req No :</td>
                            <td colspan="3"><input type="text" name="req_no" id="req_no" style="width:200px;" /></td>
                          </tr>
                          <tr>
                            <td><div align="right">Vendor : </div></td>
                            <td colspan="3"><select name="vendor" style="text-align:left; width:220px; float:left;" tabindex="2">
                              <?
    $led1=db_query("select vendor_id,vendor_name from vendor where 1 order by vendor_name");
	if(mysqli_num_rows($led1) > 0)
	{
	  while($ledg1 = mysqli_fetch_row($led1)){
		  echo '<option value="'.$ledg1[0].'">'.$ledg1[1].'</option>';
	  }
	}
?>
                            </select></td>
                          </tr>
                          <tr>
                            <td align="right">Warehouse :</td>
                            <td colspan="3"><select name="warehouse" id="warehouse" style="width:220px; float:left;" tabindex="8">
                              <?
	$led11=db_query("select warehouse_id, warehouse_name FROM warehouse WHERE warehouse_type!='Sale' ORDER BY warehouse_id ASC");
	if(mysqli_num_rows($led11) > 0)
	{
	  while($ledg11 = mysqli_fetch_row($led11)){
		  echo '<option value="'.$ledg11[0].'">'.$ledg11[1].'</option>';
	  }
	}
				?>
                            </select></td>
                          </tr>
                          <tr>
                            <td align="right">Quotation Ref No:</td>
                            <td><input type="text" name="quotation_no" id="quotation_no" style="width:100px;" /></td>
                            <td>Quo Date:</td>
                            <td><input name="quotation_date" value="" type="text" id="quotation_date" size="10" tabindex="1" style="width:80px;" /></td>
                          </tr>
                          <tr>
                            <td align="right">Delivery within</td>
                            <td><input name="delivery_within" value="" type="text" id="delivery_within" size="10" tabindex="1" style="width:80px;" /> </td>
                            <td>Days</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
						<td align="left" valign="top"><div class="box2">
						  <table  class="tabledesign" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <th colspan="1">Inv No </th>
                              <th colspan="1">Vendor</th>
                              <th colspan="3">Amount</th>
                            </tr>
<? 
$sql2="select p_inv_id, sum(a.amount), b.vendor_name,a.purchase_date  from purchase_invoice a, vendor b where  a.vendor=b.vendor_id group by   p_inv_id order by a.p_inv_id desc limit 5";
$data2=db_query($sql2);
if(mysqli_num_rows($data2)>0){
while($dataa=mysqli_fetch_row($data2))
{
					?>
<tr class="alt">
<td><?=$dataa[0]?></td>
<td><?=$dataa[2]?></td>
<td><?=$dataa[1]?></td>
<td width="1" onclick="DoNav('<?php echo 'v_type=purchase_invoice&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[0].'&view=Show&in=Purchase';?>');"><span style="padding:1px;"><!--<img src="../images/copy_hover.png" width="16" height="16" border="0" />--></span></td>
<td width="1"><a href="invoice_print_new_new.php?<?php echo 'v_type=purchase_invoice&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[0].'&view=Show&in=Purchase&tid=p_inv_id'?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" /></a></td>
		</tr>
                            <? }}?>
                          </table>
						</div></td>
					  </tr>
					 
					</table>

		  </td>
        </tr>
        <tr>
          <td>
		   <table border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
            <tr>
              <td align="center">Item Description</td>
              <td width="11%" align="center">Cost Price </td>
              <td width="11%" align="center">Qty</td>
              <td width="11%" align="center">Amount</td>
              <td width="6%" rowspan="2" align="center">
                    <input name="add" type="button" id="add" class="btn1" value="ADD" onclick="checkhead('purchase_invoice_item');" tabindex="7"/>              </td>
            </tr>
            <tr>
                <td align="center">
                  <input type="text" name="item" id="item" class="input1" style="width:350px; " onBlur="cost_price(this.value);" tabindex="7" />
                </td>
                <td align="center"><span id="cur"><?php
                $a2="select cost_price from item_info order by item_name limit 1";
                $a=mysqli_fetch_row(db_query($a2));
                ?><input name="rate" type="text" id="rate" value="<?php echo $a[0];?>" size="12" readonly="true" onchange="t_rate(this.value);" tabindex="9" />
                </span></td>
                <td align="center"><input name="qty" type="text" id="qty" value="0" onchange="t_qty(this.value);" tabindex="10" /></td>
                <td align="center"><input name="d_amt" type="hidden" id="d_amt" value="0" onchange="t_d_amt(this.value);"  tabindex="11" /><input name="t_amt" type="text" id="t_amt" value="0" readonly  tabindex="12" /></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="110" valign="top">
		  <span id="tbl"></span>
		  </td>
        </tr>
        <tr>
          <td height="20">
            <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">
            <tr>
              <td width="33%" rowspan="3" align="right"><input name="invoice_varify" type="submit" class="btn" id="invoice_varify" value="Invoice Varified" />              </td>
              <td width="21%" rowspan="3" align="right">&nbsp;</td>
              <td align="right">Total Amount :
                <input name="t_inv_amt" type="text" id="t_inv_amt" value="0" size="20" readonly="readonly"/>              </td>
              </tr>
            <tr>
              <td align="right">Disc Amount(%) :
                <input name="d_inv_amt" type="text" id="d_inv_amt" onchange="d_inv(this.value);" value="0" size="20"/>              </td>
              </tr>
            <tr>
              <td align="right">Total Amount :
                <input name="f_inv_amt" type="text" id="f_inv_amt" value="0" size="20" readonly="readonly"/>              </td>
            </tr>
            </table></td>
        </tr>
      </table>
    </form>
  </div>
</div></td>
</tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>