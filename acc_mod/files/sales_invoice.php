<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Invoice';
$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
//echo $proj_id;
$jv=next_journal_voucher_id();

$cash_and_bank_balance=find_a_field('config_group_class','cash_and_bank_balance',"1");
$receivable=find_a_field('config_group_class','receivable',"1");
if($_POST['invoice_varify'])
{
$date=date_value($_REQUEST["date"]);
$d_inv_amt=$_REQUEST["d_inv_amt"];
$f_inv_amt=$_REQUEST["f_inv_amt"];
$f_paid=$_REQUEST["f_paid"];
$vendor=$_REQUEST["vendor"];
		//$r_from		= $_REQUEST['r_from'];
		$c_no		= $_REQUEST['c_no'];
		$c_date		= $_REQUEST['c_date'];
		$c_id		= $_REQUEST['c_id'];
$c= $_SESSION['count'];
$narration=($c/6)." Item sales with ".$d_inv_amt." Discount.";
$profit=0;
for($i=0;$i<($c/6);$i++)
{
    $item=$_SESSION['data'.(($i*6)+1)];
    $rate=$_SESSION['data'.(($i*6)+2)];
    $qty=$_SESSION['data'.(($i*6)+3)];
    $disc=$_SESSION['data'.(($i*6)+4)];
    $amount=$_SESSION['data'.(($i*6)+5)];
	$warehouse=$_SESSION['data'.(($i*6)+6)];

$ledgers = explode('::',$item);
$search=array( ":"," ", "[", "]", $separater);
$ledger1=str_replace($search,'',$ledgers[0]);
$ledger2=str_replace($search,'',$ledgers[1]);

if(is_numeric($ledger1))
$item = $ledger1;
else
$item = $ledger2;

    $ppp="select a.group_id,a.cost_price,b.profit_ledger from item_info a,item_group b where a.item_id='$item' and a.group_id=b.group_id";
    $lid=mysqli_fetch_row(db_query($ppp));
	
    
    $recept="INSERT INTO `sales_invoice` (
    `s_inv_id` ,
	`customer` ,
    `item` ,
    `rate` ,
    `qty` ,
    `disc` ,
    `amount` ,
	`paid_amount`)
    VALUES ('$jv', '$vendor', '$item', '$rate', '$qty', '$disc', '$amount','$f_paid')";
    
    $query_coutra = db_query($recept);

    sale_stock_manage($item,$warehouse,$qty);

    $journal1="INSERT INTO `journal` (
    `proj_id` ,
    `jv_no` ,
    `jv_date` ,
    `ledger_id` ,
    `narration` ,
    `dr_amt` ,
    `cr_amt` ,
    `tr_from` ,
    `tr_no` ,
    `sub_ledger`,
	`cc_code`,
	user_id,
	`tr_id`
    )VALUES ('$proj_id', '$jv', '$date', '$lid[0]', '$narration', '0', '$amount', 'Sales', '$jv','$item', '','$user_id','$vendor')";
    //echo $journal1;
    $query_journal1=db_query($journal1);
}

$journal2="INSERT INTO `journal` (
`proj_id` ,
`jv_no` ,
`jv_date` ,
`ledger_id` ,
`narration` ,
`dr_amt` ,
`cr_amt` ,
`tr_from` ,
`tr_no` ,
	`user_id`,
	`tr_id`
)VALUES ('$proj_id', '$jv', '$date', '$receivable', '$narration',  '$f_inv_amt',0, 'Sales', '$jv','$user_id','$vendor')";
$query_journal2=db_query($journal2);
	if($f_paid>0)
	{
	$jv=next_journal_voucher_id();
	pay_invoice_amount($proj_id, $jv, $date, $receivable,$c_id, 'Receive with Invoice', $f_paid, 'AutoSales', $jv,$vendor,$user_id);
	
	//pay_invoice_amount($proj_id, $jv_no, $jv_date, $cr_ledger_id,$dr_ledger_id, $narration, $amount, $tr_from, $jv)
	}

}

// SESSION FLUSH FOR MULTIPLE ROW INFO REMOVE
include 'session_flush_n_register.php';
// =========================================

//echo $ppp;
?>
<script src="../common/sales_invoice.js" language="javascript"></script>
<?php
    

    $led2=db_query("select a.item_id, a.item_name from item_info a,item_group b where b.inventory_type='Sales' and a.group_id=b.group_id order by item_name");
      $data2 = '[';
	  while($ledg2 = mysqli_fetch_row($led2)){
          $data2 .= '{ name: "'.addslashes($ledg2[1]).'", id: "'.$ledg2[0].'" },';
	  }
      $data2 = substr($data2, 0, -1);
      $data2 .= ']';
?>
<script type="text/javascript">

$(document).ready(function(){

    function formatItem(row) {
		//return row[0] + " " + row[1] + " ";
	}
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
<div id="report">
  <div align="right">
    <form id="form1" name="form1" method="post" action="sales_invoice.php" onsubmit="return checking()">
	
      <table width="600" border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
        <tr>
          <td>
		  <table width="100%" border="0" cellspacing="2" cellpadding="2">
				  <tr>
					<td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td><div align="right">Invoice No :</div></td>
                        <td><input name="invoice_no" type="text" id="invoice_no" class="input1" value="<?php echo $jv;?>" style="width:100px" readonly/></td>
                        <td>Date:</td>
                        <td><input name="date" value="<?php echo date("d-m-y",time());?>" type="text" id="date" /></td>
                      </tr>
                      <tr>
                        <td><div align="right">Customer : </div></td>
                        <td colspan="3"><select name="vendor" style="text-align:left; width:200px; float:left;"    tabindex="1">
                          <?
    $led1=db_query("select customer_id,customer_name from customer where 1 order by customer_name");
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
                        <td><div align="right">Pay Receive Mode:</div></td>
                        <td colspan="3"><select name="c_id" style="text-align:left; width:200px; float:left;"    tabindex="2">
							<?
$led2=db_query("select ledger_id, ledger_name from accounts_ledger where ledger_group_id='$cash_and_bank_balance' and 1 order by ledger_name");
    
	if(mysqli_num_rows($led2) > 0)
	{
	  while($ledg2 = mysqli_fetch_row($led2)){
		  echo '<option value="'.$ledg2[0].'">'.$ledg2[1].'</option>';
	  }
	}
							?>
							</select>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><div align="right">Bank:</div></td>
                        <td colspan="3"><input name="bank" type="text" id="bank" value="" class="input1"   tabindex="3"/></td>
                      </tr>
                      <tr>
                        <td><div align="right"><span>Cheque No:</span></div></td>
                        <td colspan="3"><input name="c_no" type="text" id="c_no" value="" size="20" maxlength="25" tabindex="4"/></td>
                      </tr>
                      <tr>
                        <td><div align="right"><span>Cheque</span> Date:</div></td>
                        <td colspan="3"><input name="c_date" type="text" id="c_date" value="<?php echo date("d-m-y",time());?>" size="12" maxlength="15" tabindex="5"/></td>
                      </tr>
                      
                    </table></td>
					<td align="right" valign="top">
					<div class="box2">
						  <table  class="tabledesign" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <th>Inv No </th>
                              <th>Amount</th>
                              <th colspan="3">Narration</th>
                            </tr>
                            <? 
$sql2="select tr_no, dr_amt, narration,jv_date from  journal  where dr_amt>0 and tr_from='Sales' order by tr_no desc limit 5";
$data2=db_query($sql2);
if(mysqli_num_rows($data2)>0){
while($dataa=mysqli_fetch_row($data2))
{$dataa[2]=substr($dataa[2],0,12).'...';
					?>
<tr class="alt">
<td><?=$dataa[0]?></td>
<td><?=$dataa[1]?></td>
<td><?=$dataa[2]?></td>
<td width="1" onclick="DoNav('<?php echo 'v_type=sales_invoice&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[0].'&view=Show&in=Sales';?>');"><img src="../images/copy_hover.png" width="16" height="16" border="0" /></td>
<td width="1"><a href="invoice_print_new.php?<?php echo 'v_type=sales_invoice&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[0].'&view=Show&in=Sales&tid=s_inv_id'?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" /></a></td>
		</tr>
                            <? }}?>
                          </table>
					</div>
					</td>
				  </tr>				 
			</table>

		  </td>
        </tr>
        <tr>
          <td height="35">
           <table border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
            <tr>
              <td align="center">Item Description</td>
              <td align="center">Warehouse</td>
              <td align="center" width="66">Cost Price </td>
              <td align="center" width="66">Sale Price</td>
              <td align="center" width="67">QOH</td>
              <td align="center">Qty</td>
              <td align="center">Discount Amt </td>
              <td align="center">Amount</td>
              <td width="6%" rowspan="2" align="center"><input name="add" type="button" class="btn1" id="add" value="ADD" onclick="counting(); set();"   tabindex="11"/></td>
            </tr>
            <tr>
                <td align="center">
                <input type="text" name="item" id="item" class="input1" onblur="cost_price(this.value);"    tabindex="6"/>                </td> 
                <td align="center"><select name="warehouse" id="warehouse" style="width:80px"  onblur="cost_price();"    tabindex="7" >
                  <?
	$led11=db_query("select warehouse_id, warehouse_name FROM warehouse WHERE warehouse_type!='Purchase' ORDER BY warehouse_id ASC");
	if(mysqli_num_rows($led11) > 0)
	{
	  while($ledg11 = mysqli_fetch_row($led11)){
		  echo '<option value="'.$ledg11[0].'">'.$ledg11[1].'</option>';
	  }
	}
				?>
                </select>                  &nbsp;</td>
                <td colspan="3">
                <span id="cur"><nobr>
                <input name="trate" type="text" id="trate" value="0" readonly/> 
                <input name="rate" type="text" id="rate" value="0" readonly/> 
                <input name="qoh" type="text" id="qoh" value="0" readonly/>
				</nobr>
                </span>                </td>             
                <td align="center"><input name="qty" type="text" id="qty" value="0" onchange="t_qty(this.value);"  tabindex="9"/></td>
                <td align="center"><input name="d_amt" type="text" id="d_amt" value="0" onchange="t_d_amt(this.value);"   tabindex="10"/></td>
                <td align="center"><input name="t_amt" type="text" id="t_amt"  value="0" readonly/></td>            	
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="138" valign="top">
		  <span id="tbl">
            <!--<table width="100%" border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
            <tr align="center">
              <td width="5%">&nbsp;</td>
              <td width="40%">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="16%">&nbsp;</td>
            </tr>
          </table>-->
		  </span>
		  </td>
        </tr>
        <tr>
          <td height="20">
            <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">
            <tr>
              <td width="33%" rowspan="4" align="right"><input name="invoice_varify" type="submit"  class="btn" id="invoice_varify" value="Invoice Varified" />              </td>
              <td width="21%" rowspan="4" align="right">&nbsp;</td>
              <td align="right">Total Amount :                
                <input name="t_inv_amt" type="text" id="t_inv_amt" value="0" size="20" readonly="readonly"/>              </td>
              </tr>
            <tr>
              <td align="right">Discount Amount :
                <input name="d_inv_amt" type="text" id="d_inv_amt" onchange="d_inv(this.value);" value="0" size="20"/>              </td>
              </tr>
            <tr>
              <td align="right">Total Amount :
                <input name="f_inv_amt" type="text" id="f_inv_amt" value="0" size="20" readonly="readonly"/>              </td>
              </tr>
			   <tr>
			   <td align="right">Total Paid :
                <input name="f_paid" type="text" id="f_paid" value="0" size="20"/>							  </td>
              </tr>
          </table>
		  </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>