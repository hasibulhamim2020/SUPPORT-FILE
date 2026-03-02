<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Stock Position Report';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];
$j=0;
for($i=0;$i<strlen($fdate);$i++)
{
if(is_numeric($fdate[$i]))
$time1[$j]=$time1[$j].$fdate[$i];

else $j++;
}

$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);

//tdate-------------------


$j=0;
for($i=0;$i<strlen($tdate);$i++)
{
if(is_numeric($tdate[$i]))
$time[$j]=$time[$j].$tdate[$i];
else $j++;
}
$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);


}
?>
<?php 

$led1 = db_query("SELECT group_id, group_name FROM `item_group`");
if(mysqli_num_rows($led1) > 0)
{
	$data1 = '[';
	$data1 .= '{ name: "All", id: "%" },';
	while($ledg = mysqli_fetch_row($led1)){
		$data1 .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
	}
	$data1 = substr($data1, 0, -1);
	$data1 .= ']';
}
else
{
	$data1 = '[{ name: "empty", id: "" }]';
}

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
    $("#item_cat").autocomplete(data1, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>ID: " + row.id + "</span>";
            return row.name;
		},
		formatResult: function(row) {
			return row.name;
		}
	});
	
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	
	$(function() {
		$("#fdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-y'
		});
	});
		$(function() {
		$("#tdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-y'
		});
	});

});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      
                                      <tr>
                                        <td width="22%" align="right">Ware House:</td>
                                        <td align="left"><select name="warehouse" id="warehouse" style="width:180px;float:left" onblur="avail_stock()"  >
                                          <?
	$led11=db_query("select warehouse_id, warehouse_name FROM warehouse ORDER BY warehouse_id ASC");
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
                                      <tr>
                                        <td align="right">Item Group :</td>
                                        <td align="left"><input type="text" name="item_cat" id="item_cat" value="<?php echo $_REQUEST['item_cat'];?>" size="50" /></td>
                                      </tr>
                                      
                                      
                                      <tr>
                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td> <div id="reporting">
	<table id="grp" class="tabledesign" cellspacing="0">
							   <tr bgcolor="#FFCCCC">
    <th height="20" align="center">Item Group </th>
    <th align="center">Item Name </th>
    <th align="center">Cost Price</th>
    <th height="20" align="center">Warehouse Name</th>
    <th height="20" align="center">Purchase Qty</th>
    <th align="center">Sale Qty</th>
	<th align="center">Receive Qty</th>
	<th align="center">Issue Qty</th>
	<th align="center">Balance Qty</th>
	<th align="center">Stock Price</th>
  </tr>
<?php
if(isset($_REQUEST['show']))
{
$item_group = (!empty($_REQUEST['item_cat'])) ? $_REQUEST['item_cat'] : '%';
$item_group = ($item_group=='All') ? '%' : $item_group;
$warehouse = $_REQUEST['warehouse'];
$sql = 'select g.group_name,i.item_name,w.warehouse_name,s.purchase_amt,s.sale_amt,s.receive_amt,s.issue_amt,i.cost_price from inventory_stock s,item_info i,item_group g,warehouse w where i.item_id=s.item_id and i.group_id=g.group_id and s.warehouse_id=w.warehouse_id and w.warehouse_id="'.$warehouse.'" AND g.group_id like "%'.$item_group.'%"  order by i.item_id';
//echo $sql;
$query=db_query($sql);
  while($row = mysqli_fetch_row($query))
  {
	  
	  $balance_qty=(($row[3]+$row[5])-($row[4]+$row[6]));
	  $cost_price=$row[7];
	  $item_balance_amt=$balance_qty*$cost_price;
	  $total_balance_qty=$total_balance_qty+$balance_qty;
	  $total_item_balance_amt=$total_item_balance_amt+$item_balance_amt;
?>
    <tr>
        <td align="center">
		<?php echo '<span style="color:#009900;font-weight:bold;">'.$row[0].'</span>';
		?>        </td>
        <td align="left"><?php echo $row[1]?></td>
        <td align="left"><?php echo $row[7]?></td>
        <td align="left"><?php echo $row[2]?></td>
		<td align="left"><?php echo $row[3]?></td>
		<td align="left"><?php echo $row[4]?></td>
        <td align="center"><?php echo $row[5]?></td>
    	<td align="center"><?php echo $row[6]?></td>
    	<th align="right"> <?php 
			echo '<span style="color:#009900;font-weight:bold;">'.$balance_qty.'</span>';
			?></th>
    	<th align="right">
    	  <?php 
			echo '<span style="color:#009900;font-weight:bold;">'.number_format($item_balance_amt,2).'</span>';
			?>        </th>
    </tr>
<?php
  }
}
?>  
    <tr>
        <td colspan="8" align="right">Total :</td>
        <th align="right"> <?php 
			echo '<span style="color:#009900;font-weight:bold;">'.$total_balance_qty.'</span>';
			?></th>
    	<th align="right">
    	  <?php 
			echo '<span style="color:#009900;font-weight:bold;">'.number_format($total_item_balance_amt,2).'</span>';
			?>        </th>
    </tr>
</table> 
									</div>
																		</td>
								  </tr>
		</table>

							</div></td>
    
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>