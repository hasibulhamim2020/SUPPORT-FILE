<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Invoice View';

$proj_id 	= $_SESSION['proj_id'];
$vtype 		= $_REQUEST['v_type'];


if(isset($_REQUEST['show']))
{
	$fdate=$_REQUEST["fdate"];
	$tdate=$_REQUEST['tdate'];
	$vou_no=$_REQUEST['vou_no'];
	if($fdate!=''&&$fdate!='')
	{
	$j=0;
	for($i=0;$i<strlen($fdate);$i++)
	{
		if(is_numeric($fdate[$i]))
		$time1[$j]=$time1[$j].$fdate[$i];
		
		else $j++;
	}	
	$fdate=mktime(0,0,0,$time1[1],$time1[0],$time1[2]);
	
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

}
if(isset($_REQUEST['show'])||isset($_REQUEST['view']))
{
if($vtype=='Purchase'){ $table='purchase_invoice';
		$sql="SELECT DISTINCT 
				  journal.tr_no,
				  journal.cr_amt,
				  journal.jv_date,
				  journal.jv_no,
				  accounts_ledger.ledger_name
				FROM
				  journal,
				  accounts_ledger
				WHERE
				  tr_from = '$vtype' AND 
				  tr_no like '%$vou_no%' AND 
				  cr_amt>0 AND
				  jv_date BETWEEN '$fdate' AND '$tdate' AND 
				  journal.ledger_id = accounts_ledger.ledger_id
				ORDER BY
				  journal.tr_no	LIMIT 500";}
if($vtype=='Sales'){ $table='sales_invoice';
		$sql="SELECT DISTINCT 
				  journal.tr_no,
				  journal.dr_amt,
				  journal.jv_date,
				  journal.jv_no,
				  accounts_ledger.ledger_name
				FROM
				  journal,
				  accounts_ledger
				WHERE
				  tr_from = '$vtype' AND 
				  tr_no like '%$vou_no%' AND 
				  dr_amt>0 AND
				  jv_date BETWEEN '$fdate' AND '$tdate' AND 
				  journal.ledger_id = accounts_ledger.ledger_id
				ORDER BY
				  journal.tr_no	LIMIT 500";}
if($vtype=='Issue'){ $table='issue_invoice';
		$sql="SELECT DISTINCT 
				  journal.tr_no,
				  journal.dr_amt,
				  journal.jv_date,
				  journal.jv_no,
				  accounts_ledger.ledger_name
				FROM
				  journal,
				  accounts_ledger
				WHERE
				  tr_from = '$vtype' AND 
				  tr_no like '%$vou_no%' AND 
				  dr_amt>0 AND
				  jv_date BETWEEN '$fdate' AND '$tdate' AND 
				  journal.ledger_id = accounts_ledger.ledger_id
				ORDER BY
				  journal.tr_no	LIMIT 500";}
if($vtype=='Return'){ $table='return_invoice';
		$sql="SELECT DISTINCT 
				  journal.tr_no,
				  journal.cr_amt,
				  journal.jv_date,
				  journal.jv_no,
				  accounts_ledger.ledger_name
				FROM
				  journal,
				  accounts_ledger
				WHERE
				  tr_from = '$vtype' AND 
				  tr_no like '%$vou_no%' AND 
				  cr_amt>0 AND
				  jv_date BETWEEN '$fdate' AND '$tdate' AND 
				  journal.ledger_id = accounts_ledger.ledger_id
				ORDER BY
				  journal.tr_no	LIMIT 500";}

}
if(isset($_REQUEST['view']))
{
	$v_no=$_REQUEST['v_no'];
}
////
?>
<script type="text/javascript">
	$(function() {
		$("#fdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
		$("#tdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
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

function loadinparent(url)
{
	self.opener.location = url;
	self.blur(); 
}
</script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-size: 10px;
}
.style2 {color: #FF0000}
-->
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td valign="top"><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="40%" align="right">
		    Invoice Type<span class="style2">*</span> : </td>
                                        <td width="60%" align="left">
										<select name="v_type" id="v_type" class="input1">
				  <option value="Purchase"<?php if($vtype=='Purchase') echo "selected"?>>Purchase Invoice</option>
				  <option value="Sales"<?php if($vtype=='Sales') echo "selected"?>>Sales Invoice</option>
				  <option value="Issue"<?php if($vtype=='Issue') echo "selected"?>>Issue Invoice</option>
				  <option value="Return"<?php if($vtype=='Return') echo "selected"?>>Return Invoice</option>
                                        </select> </td>
                                      </tr>
                                      <tr>
                                        <td align="right">Invoice Date<span class="style2">*</span> : </td>
                                        <td align="left"><table width="100" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><input name="fdate" type="text" id="fdate" size="10" <?php if($fdate!='') echo "value=\"".date("d-m-Y",$fdate)."\"" ?> /></td>
                                            <td align="center">--</td>
                                            <td><input name="tdate" type="text" id="tdate" size="10" <?php if($tdate!='') echo "value=\"".date("d-m-Y",$tdate)."\"" ?> /></td>
                                          </tr>
                                        </table>		  </td>
                                      </tr>
                                      
                                      <tr>
                                        <td align="right">Invoice No : </td>
                                        <td align="left"><input name="vou_no" type="text" id="vou_no" value="<?=$vou_no?>" size="10" /></td>
                                      </tr>
                                      <tr>
                                        <td align="center"><span class="style1">* means mandetory </span></td>
                                        <td align="left"><input class="btn1" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                      
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td style="height:3px;"> </td>
								  </tr>
								  <tr>
									<td>	  <?php if(isset($_REQUEST['view'])||isset($_REQUEST['show']))
	  {	  
	  ?>
									<table align="center" cellspacing="0" class="tabledesign" id="grp">
							  <tr>
								<th>Invoice No</th>
								<th>Invoice Date</th>
								<th>Transection Head</th>
								<th>Amount</th>
							  </tr>
        <?php
		$query=db_query($sql);		  
		while($vno=mysqli_fetch_row($query))
		{
			$v_type = $_REQUEST['v_type'];$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo 'v_type='.$table.'&vdate='.date("Y-m-d",$vno[2]).'&v_no='.$vno[0].'&view=Show&in='.$vtype;?>');">
								<td><?php echo $vno[0] ?></td>
								<td><?php echo date("d-m-Y",$vno[2]) ?></td>
								<td><?php echo $vno[4] ?></td>
								<td><?php echo $vno[1] ?></td>
							  </tr>
	<?php }?>
							</table>	<?php
    }
    ?>								</td>
								  </tr>
		</table>

							</div></td>
    
  </tr>
</table>10
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