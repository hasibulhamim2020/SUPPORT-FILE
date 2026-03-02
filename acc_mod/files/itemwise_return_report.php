<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Item Wise Return Report';
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
<?php $led=db_query("SELECT group_id, inventory_type FROM item_group GROUP BY inventory_type");
if(mysqli_num_rows($led) > 0)
{
	$data = '[';
	while($ledg = mysqli_fetch_row($led)){
	  $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
	}
	$data = substr($data, 0, -1);
	$data .= ']';
}
else
{
	$data = '[{ name: "empty", id: "" }]';
}


$led1 = db_query("SELECT group_id, group_name FROM `item_group`");
if(mysqli_num_rows($led1) > 0)
{
	$data1 = '[';
	while($ledg = mysqli_fetch_row($led1)){
		$data1 .= '{ name: "'.addslashes($ledg[1]).'", id: "'.$ledg[0].'" },';
	}
	$data1 = substr($data1, 0, -1);
	$data1 .= ']';
}
else
{
	$data1 = '[{ name: "empty", id: "" }]';
}

$led2 = db_query("select * from item_info");
if(mysqli_num_rows($led2) > 0)
{
	$data2 = '[';
	while($ledg = mysqli_fetch_row($led2)){
		$data2 .= '{ name: "'.addslashes($ledg[1]).'", id: "'.$ledg[0].'" },';
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

    function formatItem(row) {
		//return row[0] + " " + row[1] + " ";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

    var data = <?php echo $data; ?>;
    $("#inv_type").autocomplete(data, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name;
		},
		formatResult: function(row) {
			return row.name;
		}
	});


    var data1 = <?php echo $data1; ?>;
    $("#item_cat").autocomplete(data1, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name;
		},
		formatResult: function(row) {
			return row.name;
		}
	});
    
	var data2 = <?php echo $data2; ?>;
    $("#item_name").autocomplete(data2, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
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
                                        <td width="22%" align="right">
		    Period :                                       </td>
                                        <td align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Inventory Type :</td>
                                        <td align="left"><input type="text" name="inv_type" id="inv_type" value="<?php echo $_REQUEST['inv_type'];?>" size="50" /></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Category : </td>
                                        <td align="left"><input type="text" name="item_cat" id="item_cat" value="<?php echo $_REQUEST['item_cat'];?>" size="50" /></td>
                                      </tr>
                                      <tr>
                                      
                                      <tr>
                                        <td align="right">Item Name :</td>
                                        <td align="left"><input type="text" name="item_name" id="item_name" value="<?php echo $_REQUEST['item_name'];?>" size="50" /></td>
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
    <th width="20%" height="20" align="center">Item Name</th>
    <th width="12%" height="20" align="center">Issue Invoice </th>
    <th width="27%" align="center">Customer/Employee Name </th>
    <th width="11%" height="20" align="center">Issue Date</th>
    <th width="8%" height="20" align="center">Issue Qty </th>
    <th width="7%" align="center">Due Date</th>
	<th width="7%" align="center">Return Qty</th>
	<th width="8%" align="center">Return Date </th>
  </tr>
  <?php  
  if(isset($_REQUEST['show']))
  {
	  $sql = "SELECT DISTINCT 
				  item.item_name,
				  j.jv_no,
				  c.customer_name,  
				  j.jv_date,
				  iv.qty,
				  iv.due_date,
				  iv.return_qty,
				  iv.return_date
				FROM
				  item_info item,
				  journal j,
				  customer c,
				  return_invoice ri,
				  issue_invoice iv,
				  item_group ig
				WHERE
				  ri.ref_no = iv.id AND
				  ig.group_id = item.group_id AND 
				  iv.s_inv_id = j.jv_no AND 
				  iv.item = item.item_id AND 
				  iv.customer = c.customer_id";
		
		if(!empty($_REQUEST['inv_type']))
		{
			$sql .= ' AND ig.inventory_type = "'.$_REQUEST['inv_type'].'"';
		}
		if(!empty($_REQUEST['item_cat']))
		{
			$sql .= ' AND ig.group_name = "'.$_REQUEST['item_cat'].'"';
		}
		if(!empty($_REQUEST['item_name']))
		{
			$sql .= ' AND item.item_name = "'.$_REQUEST['item_name'].'"';
		}
		if(!empty($_REQUEST['fdate']) && !empty($_REQUEST['tdate']))
		{
			$sql .= ' AND j.jv_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"';
		}
  //echo $sql;
  $query = db_query($sql);
  while($row = mysqli_fetch_row($query))
  {
  ?>
  <tr>   
    <td><?php echo $row[0]; ?></td>
    <td align="center"><?php echo $row[1]; ?></td>
    <td align="left"><?php echo $row[2]; ?></td>
    <td align="center"><?php echo $issdt = (!empty($row[3])) ? date("d-m-Y", $row[3]) : '--'; ?></td>
    <td align="center"><?php echo $row[4]; ?></td>
	<td align="center"><?php echo $issdt = (!empty($row[5])) ? date("d-m-Y", $row[5]) : '--'; ?></td>
	 <td align="center"><?php echo $row[6]; ?></td>
	 <td align="center"><?php echo $rtdt = (!empty($row[7])) ? date("d-m-Y", $row[7]) : '--'; ?></td>
  </tr>
  <?php 
  }
  ?>
</table> </div>
<?php 
}
?>
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