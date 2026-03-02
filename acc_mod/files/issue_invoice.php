<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Issue Register';
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
	$invoice_no=mysqli_fetch_row(db_query("select MAX(jv_no) from journal"));
	$xxx= date("Ymd")."0000";
	if($invoice_no[0]>$xxx)
	$jv=$invoice_no[0]+1;
	else
	$jv=$xxx+1;
if($_POST['invoice_varify'])
{
$date=$_REQUEST["fdate"];
$j=0;
for($i=0;$i<strlen($date);$i++)
{
if(is_numeric($date[$i]))
$time[$j]=$time[$j].$date[$i];
else $j++;
}
$date=mktime(0,0,0,$time[1],$time[0],$time[2]);
$d_inv_amt=$_REQUEST["d_inv_amt"];
$f_inv_amt=$_REQUEST["f_inv_amt"];
$ledger=$_REQUEST["vendor"];

$c= $_SESSION['count'];
$narration=($c/5)." Item Issue with ".$d_inv_amt." Discount.";
$profit=0;
for($i=0;$i<($c/5);$i++)
{
    $item=$_SESSION['data'.(($i*5)+1)];
    $rate=$_SESSION['data'.(($i*5)+2)];
    //echo $ledger_id;
    $qty=$_SESSION['data'.(($i*5)+3)];
    $disc=$_SESSION['data'.(($i*5)+4)];
    $amount=$_SESSION['data'.(($i*5)+5)];
    $ppp="select a.group_id,a.cost_price,b.profit_ledger from item_info a,item_group b where a.item_id='$item' and a.group_id=b.group_id";
    $lid=mysqli_fetch_row(db_query($ppp));
    $item_profit=$amount-($lid[1]*$qty);
    $profit=$profit+$item_profit;
    $cost_price=$amount-$item_profit;
    
    $recept="INSERT INTO `issue_invoice` (
    `s_inv_id` ,
	`customer` ,
    `item` ,
    `rate` ,
    `qty` ,
    `disc` ,
    `amount` )
    VALUES ('$jv', '$ledger', '$item', '$lid[1]', '$qty', '$disc', '$cost_price')";
    
    $query_coutra = db_query($recept);

    $UpItem="update `item_info` set `issueqty`= `issueqty`+'$qty' where `item_id`='$item'";
    $query_UpItem=db_query($UpItem);

//    $journal1="INSERT INTO `journal` (
//    `proj_id` ,
//    `jv_no` ,
//    `jv_date` ,
//    `ledger_id` ,
//    `narration` ,
//    `dr_amt` ,
//    `cr_amt` ,
//    `tr_from` ,
//    `tr_no` ,
//    `sub_ledger`
//    )VALUES ('$proj_id', '$jv', '$date', '$lid[2]', '$narration', '0', '$cost_price', 'Issue', '$jv','$item')";
//    //echo $journal1;
//    $query_journal1=db_query($journal1);
}
////////////////////profit in journal///////////////////
/*
$journal2="INSERT INTO `journal` (
`proj_id` ,
`jv_no` ,
`jv_date` ,
`ledger_id` ,
`narration` ,
`dr_amt` ,
`cr_amt` ,
`tr_from` ,
`tr_no` 
)VALUES ('$proj_id', '$jv', '$date', '$lid[0]', '$narration',  0,'$profit', 'Issue', '$jv')";
$query_journal2=db_query($journal2);
/////////////final customer ledger input///////////////////////////
$journal2="INSERT INTO `journal` (
`proj_id` ,
`jv_no` ,
`jv_date` ,
`ledger_id` ,
`narration` ,
`dr_amt` ,
`cr_amt` ,
`tr_from` ,
`tr_no` 
)VALUES ('$proj_id', '$jv', '$date', '$ledger', '$narration',  '$f_inv_amt',0, 'Issue', '$jv')";
$query_journal2=db_query($journal2);																	
*/
}

// SESSION FLUSH FOR MULTIPLE ROW INFO REMOVE
include 'session_flush_n_register.php';
// =========================================

//echo $ppp;
?><script src="../common/sales_invoice.js" language="javascript"></script>
<?php
    $led1=db_query("select customer_id,customer_name from customer where 1 order by customer_name");
      $data1 = '[';      
	  while($ledg1 = mysqli_fetch_row($led1)){
          $data1 .= '{ name: "'.addslashes($ledg1[1]).'", id: "'.$ledg1[0].'" },';
	  }
      $data1 = substr($data1, 0, -1);
      $data1 .= ']';

    $led2=db_query("select item_id, item_name from item_info order by item_name");
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

    var data1 = <?php echo $data1; ?>;
    $("#vendor").autocomplete(data1, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>ID: " + row.id + "</span>";
            return row.name + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});

    var data2 = <?php echo $data2; ?>;
    $("#item").autocomplete(data2, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>ID: " + row.id + "</span>";
            return row.name + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
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
  <div align="left">
    <form id="form1" name="form1" method="post" action="issue_invoice.php" onsubmit="return checking()" o>
	
       <table width="600" border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
        <tr>
          <td>
		  <table width="100%" border="0" cellspacing="2" cellpadding="2">
				  <tr>
					<td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td><div align="right">Invoice No : </div></td>
                        <td><input name="invoice_no" type="text" id="invoice_no" class="input1" value="<?php echo $jv;?>" readonly/></td>
                      </tr>
                      <tr>
                        <td><div align="right">Customer :</div></td>
                        <td><input type="text" name="vendor" id="vendor" class="input1" /></td>
                      </tr>
                      <tr>
                        <td><div align="right">Invoice Date :</div></td>
                        <td><input name="fdate" value="<?php echo date("d-m-y",time());?>" type="text" id="fdate" size="10" /></td>
                      </tr>
                    </table></td>
					<td align="right" valign="top"><div class="box2">
					  <table  class="tabledesign" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <th>Voucher No </th>
                          <th>Amount</th>
                          <th>Narration</th>
                        </tr>
                        <? 
$sql2="select tr_no, dr_amt, narration,jv_date from  journal  where dr_amt>0 and tr_from='Issue' order by tr_no desc limit 5";
$data2=db_query($sql2);
if(mysqli_num_rows($data2)>0){
while($dataa=mysqli_fetch_row($data2))
{$dataa[2]=substr($dataa[2],0,13).'...';
					?>
                        <tr class="alt" onclick="DoNav('<?php echo 'v_type=coutra&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[0].'&view=Show&in=Contra' ?>');">
                          <td><?=$dataa[0]?></td>
                          <td><?=$dataa[1]?></td>
                          <td><?=$dataa[2]?></td>
                        </tr>
                        <? }}?>
                      </table>
					</div></td>
				  </tr>
				 
				</table>

		  </td>
        </tr>
        <tr>
          <td height="35">
         <table width="100%"  align="center" cellpadding="2" cellspacing="2" >
            <tr>
              <td align="center">Item Description</td>
              <td align="center">Cost Price </td>
              <td align="center">Sale Price</td>
              <td align="center">QOH</td>
              <td align="center">Qty</td>
              <td align="center">Discount Amt </td>
              <td align="center">Amount</td>
              <td width="6%" rowspan="2" align="center">
                <input name="add" type="button" id="add" value="ADD" class="btn1" onclick="counting(); set();"/>
              </td>
            </tr>
            <tr>
                <td align="center">
                    <input type="text" class="input1" name="item" id="item" onblur="cost_price(this.value);" size="25" />
                </td> 
                <td colspan="3">
                <span id="cur">
                <input name="trate" type="text" id="trate" value="0" size="10" readonly/> 
                <input name="rate" type="text" id="rate" value="0" size="10" readonly/> 
                <input name="qoh" type="text" id="qoh" value="0" size="8" readonly/>
                </span>  
                </td>             
                <td align="center"><input name="qty" type="text" id="qty" value="0" size="12" onchange="t_qty(this.value);"/></td>
                <td align="center"><input name="d_amt" type="text" id="d_amt" size="12" value="0" onchange="t_d_amt(this.value);"/></td>
                <td align="center"><input name="t_amt" type="text" id="t_amt" size="12" value="0" readonly/></td>            	
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="110" valign="top">
		  <span id="tbl">
            <table width="100%" border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
            <tr align="center">
              <td width="5%">&nbsp;</td>
              <td width="40%">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="16%">&nbsp;</td>
            </tr>
          </table>
		  </span>
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
              <td align="right">Discount Amount :
                <input name="d_inv_amt" type="text" id="d_inv_amt" onchange="d_inv(this.value);" value="0" size="20"/>
              </td>
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
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>