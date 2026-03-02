<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Issue Report';
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
							<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							<tr>
							<th width="8%" height="20" align="center">S/N</th>
							<th width="9%" align="center">Date</th>
							<th width="21%" height="20" align="center">Name</th>
							<th width="22%" align="center">Item Name </th>
							<th width="18%" height="20" align="center">Type</th>
							<th width="11%" align="center">Issue</th>
							<th width="11%" height="20" align="center">Balance</th>
							</tr>
  <?php
  if(isset($_REQUEST['show'])){
  
    $cus_type	=$_REQUEST['cus_type'];
	$cus_id		=$_REQUEST['cus_name'];
	
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
	 
    $q2= "SELECT DISTINCT ii.item,ii.customer FROM issue_invoice ii, customer c,journal j where c.customer_type like '%$cus_type%' and c.customer_id like '%$cus_id%' and c.customer_id=ii.customer and j.jv_date>'$fdate' and j.jv_date<'$tdate'";
    $pi=0;
    $sql=db_query($q2);
  echo $q2;
  die();
    while($d=mysqli_fetch_row($sql))
    {
  
    $p=db_query('SELECT DISTINCT j.jv_date, c.customer_name, it.item_name, c.customer_type, ii.qty
FROM issue_invoice ii, customer c, item_info it, journal j WHERE ii.item ='.$d[0].' AND ii.customer='.$d[1].' AND ii.s_inv_id = j.jv_no AND ii.customer = c.customer_id AND ii.item = it.item_id');

    $val = 0;
    while($data=mysqli_fetch_row($p))
    {
    $pi++;
  
    ?>
  <tr>
    <td align="center"><?php echo $pi;?></td>
    <td align="center"><?php echo date("d-m-y",$data[0]);?></td>
    <td align="center"><?php echo $data[1];?></td>
    <td align="center"><?php echo $data[2];?></td>
    <td align="center"><?php echo $data[3];?></td>
    <td align="center"><?php echo $data[4];?></td>
    <td align="center"><?php echo $val += $data[4];?></td>
  </tr>
  <?php } ?>
  <tr>
    <th colspan="7" align="right"><strong>Total : </strong><strong><?php echo $val;?></strong></th>
    </tr>
  <?php }}
        else {
		
    $q2= 'SELECT item FROM issue_invoice GROUP BY item';
  //echo $p;
    $pi=0;
    $sql=db_query($q2);

    while($d=mysqli_fetch_row($sql))
    {

    $p=db_query('SELECT DISTINCT j.jv_date, c.customer_name, it.item_name, c.customer_type, ii.qty
FROM issue_invoice ii, customer c, item_info it, journal j
WHERE ii.item ='.$d[0].'
AND ii.s_inv_id = j.jv_no
AND ii.customer = c.customer_id
AND ii.item = it.item_id');

    $val = 0;
    while($data=mysqli_fetch_row($p))
    {
    $pi++;

    ?>
  <tr>
    <td align="center"><?php echo $pi;?></td>
    <td align="center"><?php echo date("d-m-y",$data[0]);?></td>
    <td align="center"><?php echo $data[1];?></td>
    <td align="center"><?php echo $data[2];?></td>
    <td align="center"><?php echo $data[3];?></td>
    <td align="center"><?php echo $data[4];?></td>
    <td align="center"><?php echo $val += $data[4];?></td>
  </tr>
  <?php } ?>
  <tr>
    <th colspan="7" align="right"><strong>Total : </strong><strong><?php echo $val;?></strong></th>
    </tr>
   
  <?php }} ?>
</table> </div>
																		</td>
								  </tr>
		</table>

							</div></td>
    
  </tr>
</table>15
<script type="text/javascript">
	document.onkeypress=function(e){
	var e=window.event || e
	var keyunicode=e.charCode || e.keyCode
	if (keyunicode==13)
	{
		return false;
	}
}
</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>