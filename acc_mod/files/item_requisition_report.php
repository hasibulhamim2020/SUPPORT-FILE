<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Item Requisition Report';
$proj_id=$_SESSION['proj_id'];

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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                     
                                      <tr>
                                        <td align="right">Ware House Name:</td>
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
                                        <td align="right">Product Level: </td>
                                        <td align="left">
                                       <select name="product_level" id="product_level" size="1" onchange="report_type(this.value)">

<option <?php echo $sel=($_REQUEST['product_level']=='understock')?'selected':''; ?> value="understock">Under Stock Item</option>
<option <?php echo $sel=($_REQUEST['product_level']=='overstock')?'selected':''; ?> value="overstock">Over Stock Item</option>
                                    </select>
                                        
                                        </td>
                                      </tr>
                                      <tr>
                                      
                                      <tr>
                                        <td align="right">Product Group :</td>
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
									<td><div id="reporting">
	<table id="grp" class="tabledesign" cellspacing="0">
							   <tr bgcolor="#FFCCCC">
    <th width="9%" height="20" align="center">Product Group </th>
    <th width="14%" align="center">Product Name </th>
    <th width="20%" height="20" align="center"> Ware House </th>
    <th width="11%" height="20" align="center">Entry Date </th>
    <th width="10%" align="center">Reorder</th>
	<th width="10%" align="center">Balance</th>
  </tr>
<?php
if(isset($_REQUEST['show']))
{

$item_group = (!empty($_REQUEST['item_cat'])) ? $_REQUEST['item_cat'] : '%';
$warehouse = $_REQUEST['warehouse'];
$item_group = ($item_group=='All') ? '%' : $item_group;
if($_REQUEST['product_level']=='understock')
{
	$query='
	SELECT 
	i.item_id,
	i.item_name,
	i.`reorder`,
	g.group_name, 
	w.warehouse_name,
	(s.receive_amt + s.purchase_amt) - (s.sale_amt + s.issue_amt) as balance,
	i.entrydate
	FROM 
	item_group g,
	warehouse w,
	inventory_stock s,
	item_info i
	WHERE 
	i.group_id = g.group_id AND 
	i.item_id = s.item_id AND
	w.warehouse_id = "'.$warehouse.'" AND
	w.warehouse_id = s.warehouse_id AND
	g.group_name LIKE "%'.$item_group.'%" AND 
	i.`reorder` > (s.receive_amt + s.purchase_amt) - (s.sale_amt + s.issue_amt)';
	$sql = db_query($query);
}

if($_REQUEST['product_level']=='overstock')
{
	$query='
	SELECT 
	i.item_id,
	i.item_name,
	i.`reorder`,
	g.group_name, 
	w.warehouse_name,
	(s.receive_amt + s.purchase_amt) - (s.sale_amt + s.issue_amt) as balance,
	i.entrydate
	FROM 
	item_group g,
	warehouse w,
	inventory_stock s,
	item_info i
	WHERE 
	i.group_id = g.group_id AND 
	i.item_id = s.item_id AND
	w.warehouse_id = "'.$warehouse.'" AND
	w.warehouse_id = s.warehouse_id AND
	g.group_name LIKE "%'.$item_group.'%" AND 
	i.`reorder` < (s.receive_amt + s.purchase_amt) - (s.sale_amt + s.issue_amt)';
	$sql = db_query($query);
}


  $result = array();
  while($row = mysqli_fetch_row($sql))
  {
?>
    <tr>
        <td align="center">
		<?php 
		if($item_grp != $row[3])
		{
			echo '<span style="color:#009900;font-weight:bold;">'.$row[3].'</span>';
		}
		$item_grp = $row[3];
		?>        </td>
        <td align="left"><?php echo $row[1]?></td>
        <td align="left"><?php echo $row[4]?></td>
        <td align="center"><?php echo $row[6]?></td>
    	<td align="center"><?php echo $row[2]?></td>
        <th align="center">
		<?php 
			if($row[2] > $row[5])
			{
				echo '<span style="color:#FF0000;font-weight:bold;">'.$row[5].'</span>';
			}
			else
			{
				echo '<span style="color:#009900;font-weight:bold;">'.$row[5].'</span>';
			}
		?>        </th>
    </tr>
<?php
  }
}
?>  
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