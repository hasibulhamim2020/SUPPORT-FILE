<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Requizition Order';
$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
$entry_at= time();
//echo $proj_id;
$jv=next_value('id','requisition_order');

do_calander('#need_by');
do_calander('#date');

if($_POST['invoice_varify'])
{
$date=$_REQUEST["date"];
$req_from=$_REQUEST["req_from"];
$req_no=$_REQUEST["req_no"];
$need_by=$_REQUEST["need_by"];

$c= $_SESSION['count'];
$narration=$_REQUEST["narration"];
$profit=0;
for($i=0;$i<($c/6);$i++)
{
    $item=$_SESSION['data'.(($i*6)+1)];
    $last_p_qty=$_SESSION['data'.(($i*6)+2)];
    $last_p_date=$_SESSION['data'.(($i*6)+3)];
    $qoh=$_SESSION['data'.(($i*6)+4)];
    $qty=$_SESSION['data'.(($i*6)+5)];
	$warehouse=$_SESSION['data'.(($i*6)+6)];
		
$ledgers = explode('::',$item);
$search=array( ":"," ", "[", "]", $separater);
$ledger1=str_replace($search,'',$ledgers[0]);
$ledger2=str_replace($search,'',$ledgers[1]);

if(is_numeric($ledger1))
$item = $ledger1;
else
$item = $ledger2;

  
    $req="INSERT INTO `requisition_order` 
	(`id`, `req_no`, `date`, `req_from`, `narration`, `warehouse_id`, `item_id`, `qoh`, `qty`, `user_id`, `entry_at`,need_by,last_p_qty,last_p_date) VALUES 
	('$jv', '$req_no', '$date', '$req_from', '$narration', '$warehouse', '$item', '$qoh',  '$qty', '$user_id', '$entry_at','$need_by','$last_p_qty', '$last_p_date')";
    
    $query_coutra = db_query($req);
}
}

// SESSION FLUSH FOR MULTIPLE ROW INFO REMOVE
include 'session_flush_n_register.php';
// =========================================

$jv=next_value('id','requisition_order');
?>
<script src="../common/requisition_invoice.js" language="javascript"></script>
<?php
    

		$led2=db_query("select a.item_id, a.item_name from item_info a,item_sub_group b where a.product_nature!='Salable' and a.	sub_group_id =b.	sub_group_id  order by item_name");
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
    <form id="form1" name="form1" method="post" action="" onsubmit="return checking()">
	
      <table width="600" border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
        <tr>
          <td>
		  <table width="100%" border="0" cellspacing="2" cellpadding="2">
				  <tr>
					<td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td><div align="right">Req ID :</div></td>
                        <td><input name="invoice_no" type="text" id="invoice_no" class="input1" value="<?php echo $jv;?>" style="width:100px" readonly/></td>
                        <td>Date:</td>
                        <td><input name="date" value="<?php echo date("Y-m-d",time());?>" type="text" id="date" style="width:80px;" /></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">Req No :</td>
                        <td><input name="req_no" type="text" id="req_no" class="input1" value="" style="width:100px"/></td>
                        <td>Need By:</td>
                        <td><input name="need_by" value="" type="text" id="need_by" style="width:80px;" /></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right">Req For : </div></td>
                        <td colspan="3"><textarea name="req_from" cols="40" id="req_from" style="float:left; height:50px; width:200px;"></textarea></td>
                      </tr>
                      
                      <tr>
                        <td align="right" valign="top">Warehouse :</td>
                        <td colspan="3"><select name="warehouse" id="warehouse" style="width:220px; text-align:left; float:left;"  onblur="cost_price();"    tabindex="7" >
                          <?
	$led11=db_query("select warehouse_id, warehouse_name FROM warehouse WHERE warehouse_type!='Purchase' ORDER BY warehouse_id ASC");
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
                        <td valign="top"><div align="right">Note :</div></td>
                        <td colspan="3"><textarea name="narration" cols="40" id="narration" style="float:left; height:50px; width:200px;"></textarea></td>
                      </tr>
                      
                    </table></td>
					<td align="right" valign="top">
					<div class="box2">
						  <table  class="tabledesign" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <th>ID </th>
                              <th>Date</th>
                              <th colspan="3">Req No</th>
                            </tr>
                            <? 
$sql2="select distinct(id),`date`,req_no from  requisition_order order by id desc limit 5";
$data2=db_query($sql2);
if(mysqli_num_rows($data2)>0){
while($dataa=mysqli_fetch_row($data2))
{
					?>
<tr class="alt">
<td><?=$dataa[0]?></td>
<td><?=$dataa[1]?></td>
<td><?=$dataa[2]?></td>
<td width="1" onclick="DoNav('<?php echo 'v_type=sales_invoice&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[0].'&view=Show&in=Sales';?>');">
<!--<img src="../images/copy_hover.png" width="16" height="16" border="0" />--></td>
<td width="1"><a href="invoice_print_req.php?<?php echo 'v_no='.$dataa[0]?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" /></a></td>
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
              <td align="center" width="66">Last P Qty</td>
              <td align="center" width="66">Last P Date</td>
              <td align="center" width="67">QOH</td>
              <td align="center">Qty</td>
              <td width="6%" rowspan="2" align="center"><input name="add" type="button" class="btn1" id="add" value="ADD" onclick="counting(); set();"   tabindex="11"/></td>
            </tr>
            <tr>
                <td align="center">
                <input type="text" name="item" id="item" class="input1" onblur="cost_price(this.value);" style="width:300px;"    tabindex="6"/>                </td> 
                <td colspan="3">
                  <span id="cur"><nobr>
                  <input name="trate" type="text" id="trate" value="0" readonly/> 
                  <input name="rate" type="text" id="rate" value="0" readonly/> 
                  <input name="qoh" type="text" id="qoh" value="0" readonly/>
                  </nobr>
                </span>                </td>             
                <td align="center"><input name="qty" type="text" id="qty" value="0"  tabindex="9"/></td>
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
              <td width="33%" align="center"><input name="invoice_varify" type="submit"  class="btn" id="invoice_varify" value="Order Varified" />              </td>
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