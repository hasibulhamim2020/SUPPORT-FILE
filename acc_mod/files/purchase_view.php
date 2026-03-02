<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Purchase View';

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
$vo_type=$vtype;
	if($_SESSION['user']['group']>1) $group_s='AND journal.group_for='.$_SESSION['user']['group'];
		$sql="SELECT DISTINCT 
				  journal.jv_no,
				  sum(1),
				  sum(journal.cr_amt),
				  journal.jv_date,
				  journal.jv_no,
				  accounts_ledger.ledger_name
				FROM
				  journal,
				  accounts_ledger
				WHERE
				  tr_from = 'Purchase' AND 
				  jv_date BETWEEN '$fdate' AND '$tdate' AND 
				  journal.ledger_id = accounts_ledger.ledger_id ".$group_s."
				group by  journal.jv_no";

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
	var URL = 'voucher_view_popup.php?'+theUrl;
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
                                        <td width="40%" align="right">Purchase Date<span class="style2">*</span> : </td>
                                        <td width="60%" align="left"><table width="100" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><input name="fdate" type="text" id="fdate" size="10" value="<?php if($fdate!='') echo date("01-m-Y",$fdate); else echo date("01-m-Y"); ?>" /></td>
                                            <td align="center">--</td>
                                            <td><input name="tdate" type="text" id="tdate" size="10" value="<?php if($tdate!='') echo date("d-m-Y",$tdate); else echo date("d-m-Y"); ?>" /></td>
                                          </tr>
                                        </table>		  </td>
                                      </tr>
                                      
                                      <tr>
                                        <td align="center">&nbsp;</td>
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
								<th>Voucher No</th>
								<th>Voucher Date</th>
								<th>Vendor Name </th>
								<th>Item</th>
								<th>Receive Amount</th>
								<th>&nbsp;</th>
								</tr>
        <?php
		$query=db_query($sql);		  
		while($vno=mysqli_fetch_row($query))
		{
			$v_type = $_REQUEST['v_type'];$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?>>
								<td><?=$vno[0] ?></td>
								<td><?=date("d-m-Y",$vno[3]);?></td>
								<td><?=$vno[5] ?></td>
								<td><?=($vno[1]/2).' item received' ?></td>
								<td><?=$vno[2] ?></td>
								<td><a target="_blank" href="purchase_print_view.php?jv_no=<?=$vno[0] ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
								</tr>
	<?php }?>
							</table>
										<?php
    }
    ?>								</td>
								  </tr>
		</table>

							</div></td>
    
  </tr>
</table>100
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