<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Inventory Report';
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
<?php $led=db_query("SELECT DISTINCT
					  customer.customer_id,
					  customer.customer_name
					FROM
					  customer,
					  issue_invoice
					WHERE
					  customer.customer_id = issue_invoice.customer 
					  AND 1 order by customer_name");

    if(mysqli_num_rows($led) > 0)
	{
	  $data = '[';
      $data .= '{ name: "All", id: "%" },';
	  while($ledg = mysqli_fetch_row($led)){
          $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
	  }
      $data = substr($data, 0, -1);
      $data .= ']';
	}
	else
	{
		$data = '[{ name: "All", id: "%" }]';
	}
//echo $data;
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
    $("#cus_name").autocomplete(data, {
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
  
  function checkDate()
  {
	  var fdate = document.getElementById('fdate').value
	  var tdate = document.getElementById('tdate').value
	  if(fdate=='' || tdate=='')
	  {
		  alert("Input date range");
		  return false;
	  }
	  return true;
  }
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
                                        <td align="right">Customer Type :</td>
                                        <td align="left">
        							<select name="cus_type" style="text-align:left; width:250px">
                                    
                                    <option value="%">All</option>
                                    <option value="Corporate Client" <?php echo ($_REQUEST['cus_type']=='Corporate Client')? 'Selected':''?>>Corporate Client</option>
                                    <option value="Dealer" <?php echo ($_REQUEST['cus_type']=='Dealer')? 'Selected':''?>>Dealer</option>
                                    <option value="Employee" <?php echo ($_REQUEST['cus_type']=='Employee')? 'Selected':''?>>Employee</option>
                                   <option value="Individual Client" <?php echo ($_REQUEST['cus_type']=='Individual Client')? 'Selected':''?>>Individual Client</option>
                                    <option value="Vip Client" <?php echo ($_REQUEST['cus_type']=='Vip Client')? 'Selected':''?>>Vip Client</option>
                               
                                   </select>
	                                   
                                        </td>
                                      </tr>
                                      
                                     <tr>
                                        <td align="right">Customer Name:</td>
                                        <td align="left"><input type="text" name="cus_name" id="cus_name" value="<?php echo $_REQUEST['cus_name'];?>" size="50" /></td>
                                      </tr> 
                                      
                                      
                                      
                                      <tr>
                                        <td width="22%" align="right">
		    Period :                                       </td>
                                        <td align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
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
							<!-- <table width="89%" border="1" align="center" id="grp">-->
  <tr bgcolor="#FFCCCC">
    <th width="13%" height="20" align="center">Name</th>
    <th width="17%">Customer Type</th>
    <th width="11%">Date</th>
    <th width="23%">Item name</th>
    <th width="10%">Issue</th>
    <th width="12%">Return</th>
    <th width="14%">Balance</th>
  </tr>
  <?php
if(isset($_REQUEST['show']))
{
	$cusname = (!empty($_REQUEST['cus_name']))?$_REQUEST['cus_name']:'%';
	$filterQryb = 'SELECT DISTINCT customer.customer_id FROM customer, issue_invoice WHERE';
	$filterQryb .= ' customer.customer_id = issue_invoice.customer';
	$filterQryb .= ' AND customer.`customer_type` LIKE "'.$_REQUEST['cus_type'].'"';
	$filterQryb .= ' AND customer.`customer_id` LIKE "'.$cusname.'"';
  //echo $filterQryb;
	$cusQry = db_query($filterQryb);
		
    while($cus = mysqli_fetch_row($cusQry))
    {		  
		$sQuery = 'SELECT 
					  issue_invoice.item,
					  issue_invoice.customer
					FROM
					  issue_invoice,
					  customer
					WHERE
					  issue_invoice.customer = customer.customer_id AND 
					  customer.customer_id = '.$cus[0].'
					GROUP BY
					  issue_invoice.item';
		
		//echo $sQuery;
		$sql = db_query($sQuery);
		  while($dt = mysqli_fetch_row($sql))
		  {
		  
			$p=db_query('(SELECT DISTINCT 
						  i.qty,
						  c.customer_name,
						  j.jv_date,
						  item.item_name,
						  c.customer_type,
						  j.tr_from
						FROM
						  issue_invoice i,
						  customer c,
						  journal j,
						  item_info item
						WHERE
						  i.item = '.$dt[0].' AND
						  i.s_inv_id = j.jv_no AND 
						  i.customer = c.customer_id AND 
						  c.customer_id ='.$dt[1].' AND
						  j.jv_date BETWEEN '.$fdate.' AND  '.$tdate.' AND 
						  i.item = item.item_id
						ORDER BY
						  customer_name,
						  item_name,
						  jv_date ASC)
						
						UNION
						
						(SELECT DISTINCT 
						  rt.qty,
						  c.customer_name,
						  j.jv_date,
						  item.item_name,
						  c.customer_type,
						  j.tr_from
						FROM
						  return_invoice rt,
						  customer c,
						  journal j,
						  item_info item
						WHERE
						  rt.item = '.$dt[0].' AND
						  rt.p_inv_id = j.jv_no AND 
						  rt.customer = c.customer_id AND 
						  c.customer_id ='.$dt[1].' AND 
						  j.jv_date BETWEEN '.$fdate.' AND  '.$tdate.' AND 
						  rt.item = item.item_id
						ORDER BY
						  customer_name,
						  item_name,
						  jv_date DESC)
						  
						  ORDER BY 
						  customer_name,
						  item_name,
						  jv_date ASC
		');
	  
		$pi=0;
		$tqty = 0;
		$var=0;
		$issue = 0;
		$return= 0;
		$rowspan = 0;
	  if(mysqli_num_rows($p) > 0)
	  {
		  while($data = mysqli_fetch_assoc($p))
		  {
		  $pi++;
		  ?>
		  <tr <?php if($pi%2==0) echo "bgcolor=\"#E8FFFF\""; else echo "bgcolor=\"#F0F0FF\"";?>>
			<th align="center"><?php echo $data['customer_name'];?></th>
			<td align="center"><?php echo $data['customer_type'];?></td>
			<td align="center"><?php echo date("Y-m-d",$data['jv_date']);?></td>
			<td align="left"><?php echo $itemname = $data['item_name'];?></td>
			<td align="center">
			<?php 
			if($data['tr_from']=='Issue')
			{
				$issue += $data['qty'];
				echo $data['qty'];
			}
			?>
			</td>
			<td align="center">
			<?php 
			if($data['tr_from']=='Return')
			{
				$return += $data['qty'];
				echo $data['qty'];
			}
			?>
			</td>
			<td align="center" style="background:#F0F0FF""></td>
		  </tr>
		  <?php  
		  $rowspan++ ;
		  } 
		  ?>
		  <tr>
			<th colspan="4" align="right" bgcolor="#FFCCCC"><strong>Total : </strong></th>
			<td align="center" bgcolor="#FFCCCC"><strong><?php echo $issue; ?></strong></td>
			<td align="center" bgcolor="#FFCCCC"><strong><?php echo $return; ?></strong></td>
			<td align="center" bgcolor="#FFCCCC"><strong><?php echo $tqty = $issue - $return ?></strong></td>
		  </tr>
	  <?php 
		  }
	   }
	}
  }
  ?>
</table> </div>	
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