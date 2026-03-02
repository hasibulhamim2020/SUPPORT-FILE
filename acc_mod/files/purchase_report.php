<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Purchase Report';

$proj_id 	= $_SESSION['proj_id'];
$vtype 		= $_REQUEST['v_type'];



	$fdate=$_REQUEST["fdate"];
	$tdate=$_REQUEST['tdate'];





////
?>
<script type="text/javascript">
	$(function() {
		$("#fdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
		$("#tdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});
function DoNav(theUrl)
{
	var URL = 'invoice_print_new_new.php?'+theUrl;
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
                                        <td width="40%" align="right">PO  Date<span class="style2">*</span> : </td>
                                        <td width="60%" align="left"><table width="100" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><input name="fdate" type="text" id="fdate" size="13" value="<?=$fdate?>" style="width:90px;" /></td>
                                            <td align="center">--</td>
                                            <td><input name="tdate" type="text" id="tdate" size="13" value="<?=$tdate?>" style="width:90px;" /></td>
                                          </tr>
                                        </table>		  </td>
                                      </tr>
                                      <tr>
                                        <td align="center"><span class="style1">* means mandetory </span></td>
                                        <td align="left"><input class="btn1" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                      
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td>	  
      
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
      
<div id="reporting">
<table align="center" cellspacing="0" class="tabledesign" id="grp" width="100%">
							  <tr>
								<th>ID</th>
								<th>Req No.</th>
								<th>Date</th>
								<th>Vendor Name</th>
								<th>Amount</th>
								<th>Delevery In(Days)</th>
								<th>Status</th>
							  </tr>
        <?php
		if(isset($_REQUEST['show'])||isset($_REQUEST['view']))
{

	 $sql="select a.p_inv_id,a.purchase_date,a.vendor,a.item,a.rate, a.qty,a.total_amt, a.delivery_within,a.req_no,a.pur_status from  purchase_invoice a where a.purchase_date  BETWEEN '$fdate' AND '$tdate' order by id desc limit 500";

		$query=db_query($sql);		  
		while($vno=mysqli_fetch_row($query))
		{
			$v_type = $_REQUEST['v_type'];$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo 'v_no='.$vno[0] ?>');">
								<td><?php echo $vno[0] ?></td>
								<td><?php echo $vno[8] ?></td>
								<td><?php echo $vno[1] ?></td>
								<td><?php echo find_a_field('vendor','vendor_name','vendor_id='.$vno[2]); ?></td>
                                <td><?php echo $vno[6] ?></td>
                                <td><?php echo $vno[7] ?></td>
                                <td><?php echo $vno[9] ?></td>
							  </tr>
	<?php }?>
								
							<?php
    }
    ?>								
		</table>

							</div>
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