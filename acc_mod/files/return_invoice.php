<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Return Invoice';
$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
$jv=next_journal_voucher_id();
	
if($_POST['invoice_varify'])
{
	$date=date_value($_REQUEST["date"]);
	$d_inv_amt	= $_REQUEST["d_inv_amt"];
	$f_inv_amt	= $_REQUEST["f_inv_amt"];
	$ledger		= $_REQUEST["vendor"];

	$c 			= $_SESSION['count'];
	$narration=($c/7)." Item Return with ".$d_inv_amt." Discount.";
	for($i=0;$i<($c/7);$i++)
	{
		$item	= $_SESSION['data'.(($i*7)+1)];
		$rate	= $_SESSION['data'.(($i*7)+2)];
		$qty	= $_SESSION['data'.(($i*7)+3)];
		$disc	= $_SESSION['data'.(($i*7)+4)];
		$amount	= $_SESSION['data'.(($i*7)+5)];
		$refno	= $_SESSION['data'.(($i*7)+6)];
		$cc_code= $_SESSION['data'.(($i*7)+7)];
		$lid = mysqli_fetch_row(db_query("select group_id from item_info where item_id='$item'"));
		
		$recept="INSERT INTO `return_invoice` (
		`p_inv_id` ,
		`customer`,
		`item` ,
		`rate` ,
		`qty` ,
		`disc` ,
		`amount`,
		`ref_no` )
		VALUES ('$jv', '$ledger', '$item', '$rate', '$qty', '$disc', '$amount', '$refno')";
		if(!db_query($recept))
		{
			echo mysqli_error();
			die();
		}
		
		$issueUpdate="update `issue_invoice` set `return_qty`= '$qty', return_date='".time()."' where `id`=$refno";
		if(!db_query($issueUpdate))
		{
			echo mysqli_error();
			die();
		}
		
		$UpItem="update `item_info` set `returnqty`= `returnqty`+'$qty' where `item_id`='$item'";
		if(!db_query($UpItem))
		{
			echo mysqli_error();
			die();
		}
		
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
	user_id
		)
		VALUES ('$proj_id', '$jv', '$date', '$lid[0]', '$narration', '$amount', 0, 'Return', '$jv','$item', '$cc_code','$user_id')";
		//echo $journal1;
		if(!db_query($journal1))
		{
			echo mysqli_error();
			die();
		}
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
	`tr_no`
	)VALUES ('$proj_id', '$jv', '$date', '$ledger', '$narration', 0, '$f_inv_amt', 'Return', '$jv')";
	$query_journal2=db_query($journal2);
}

// SESSION FLUSH FOR MULTIPLE ROW INFO REMOVE
include 'session_flush_n_register.php';
// =========================================

//echo $journal2;
?><script src="../common/return_invoice.js" language="javascript"></script>
<?php

    $led11=db_query("select id, center_name FROM cost_center WHERE 1 ORDER BY center_name ASC");
	if(mysqli_num_rows($led11) > 0)
	{
      $data11 = '[';
	  while($ledg11 = mysqli_fetch_row($led11)){
          $data11 .= '{ name: "'.$ledg11[1].'", id: "'.$ledg11[0].'" },';
	  }
      $data11 = substr($data11, 0, -1);
      $data11 .= ']';
	}
	else
	{
		$data11 = '[{name:"empty", id:""}]';
	}

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
		var data11 = <?php echo $data11; ?>;
    	$("#cc").autocomplete(data11, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name; // + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
	
	$("#date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-y'
		});
	
	document.getElementById("vendor").value=null;
	document.getElementById("vendor").focus();
	

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
<style type="text/css">
<!--
.style1 {font-size: 18px}
.style2 {font-size: 10px}
-->
</style>
<script type="text/javascript">

function DoNav()
{
	var URL = 'issue_invoice_list.php';
	popUp(URL);
}

function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}

function loadinparent(url)
{
	self.opener.location = url;
	self.blur(); 
}
</script>
<div id="report">
<div style="position:absolute; top:40px; left:650px;"><a href="inventory.php"></a></div>


  <div align="left">
    <form id="form1" name="form1" method="post" action="return_invoice.php" onsubmit="return checking()">
	
     <table width="600" border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
        <tr>
          <td>
		  <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><div align="right">Invoice No :</div></td>
        <td>  <input class="input1" name="invoice_no" type="text" id="invoice_no" size="15" value="<?php echo $jv;?>" readonly/></td>
      </tr>
      <tr>
        <td><div align="right">Customer :</div></td>
        <td><input type="text" name="vendor" id="vendor"  class="input1" tabindex="1" /></td>
      </tr>
      <tr>
        <td><div align="right">Return Date :</div></td>
        <td><input name="date" value="<?php echo date("d-m-y",time());?>" type="text" id="date" size="10" tabindex="1=2" /></td>
      </tr>
    </table></td>
    <td align="right" valign="top">
	<div class="box2">
	  <table  class="tabledesign" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th>Voucher No </th>
          <th>Amount</th>
          <th>Narration</th>
        </tr>
        <? 
$sql2="select tr_no, dr_amt, narration,jv_date from  journal  where dr_amt>0 and tr_from='Return' order by tr_no desc limit 5";
$data2=db_query($sql2);
if(mysqli_num_rows($data2)>0){
while($dataa=mysqli_fetch_row($data2))
{$dataa[2]=substr($dataa[2],0,15).'...';
					?>
        <tr class="alt" onclick="DoNav('<?php echo 'v_type=coutra&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[0].'&view=Show&in=Contra' ?>');">
          <td><?=$dataa[0]?></td>
          <td><?=$dataa[1]?></td>
          <td><?=$dataa[2]?></td>
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
          <td><table width="100%"  align="center" cellpadding="2" cellspacing="2" >
            <tr>
              <td align="center">Rf. No</td>
              <td width="57%" align="center">Item Description</td>
              <td align="center">Cost Center </td>
              <td align="center">Cost Price </td>
              <td align="center">Qty</td>
              <td align="center">Discount Amt </td>
              <td align="center">Amount</td>
              <td width="5%" rowspan="2" align="center">
<input name="add" type="button" class="btn1" id="add" value="ADD" onclick="checkhead('purchase_invoice_item');" tabindex="8"/>              </td>
            </tr>
            <tr>
              <td align="center"><input type="text" name="refno" id="refno" readonly="readonly" /></td>
                <td align="center"><input type="text" name="item" id="item" onBlur="cost_price(this.value);"  tabindex="3" readonly="readonly" />
                <input type="button" name="select_invoice" id="select_invoice" class="btn" value="Browse Issue Invoice" onclick="DoNav();" /></td>
                <td align="center"><input name="cc" type="text" id="cc" value=""  tabindex="4" /></td>
                <td align="center"><span id="cur"><?php
                $a2="select cost_price from item_info order by item_name limit 1";
                $a=mysqli_fetch_row(db_query($a2));
                ?><input name="rate" type="text" id="rate" value="<?php echo $a[0];?>"  readonly="true" onchange="t_rate(this.value);" tabindex="4" />
                </span></td>
                <td align="center"><input name="qty" type="text" id="qty" value="0"  onchange="t_qty(this.value);" tabindex="5" /></td>
                <td align="center"><input name="d_amt" type="text" id="d_amt"  value="0" onchange="t_d_amt(this.value);"  tabindex="6" /></td>
                <td align="center"><input name="t_amt" type="text" id="t_amt"  value="0" readonly  tabindex="7" /></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="138" valign="top">
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
            <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2" >
            <tr>
              <td width="33%" rowspan="3" align="right"><input name="invoice_varify" type="submit" class="btn" id="invoice_varify" value="Invoice Varified" />              </td>
              <td width="21%" rowspan="3" align="right">&nbsp;</td>
              <td align="right">Total Amount :
                <input name="t_inv_amt" type="text" id="t_inv_amt" value="0" size="20" readonly="readonly"/>              </td>
              </tr>
            <tr>
              <td align="right">Disc Amount :
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