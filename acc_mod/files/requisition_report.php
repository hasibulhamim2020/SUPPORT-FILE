<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Requision View';

$proj_id 	= $_SESSION['proj_id'];
$vtype 		= $_REQUEST['v_type'];



	$fdate=$_REQUEST["fdate"];
	$tdate=$_REQUEST['tdate'];



if(isset($_REQUEST['show'])||isset($_REQUEST['view']))
{

	 $sql="select a.id,a.date,a.req_no,a.req_from,a.narration, b.item_name,c.warehouse_name, a.req_status from  requisition_order a,item_info b,warehouse c where a.item_id=b.item_id and a.warehouse_id=c.warehouse_id and a.date BETWEEN '$fdate' AND '$tdate' group by a.id order by id desc limit 500";
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
	var URL = 'invoice_print_req.php?'+theUrl;
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
                                        <td width="40%" align="right">Requisition Date<span class="style2">*</span> : </td>
                                        <td width="60%" align="left"><table width="100" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><input name="fdate" type="text" id="fdate" size="10" value="<?=$fdate?>" style="width:90px;" /></td>
                                            <td align="center">--</td>
                                            <td><input name="tdate" type="text" id="tdate" size="10" value="<?=$tdate?>" style="width:90px;" /></td>
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
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td>	  <?php if(isset($_REQUEST['view'])||isset($_REQUEST['show']))
	  {	  
	  ?>
									<table width="100%" align="center" cellspacing="0" class="tabledesign" id="grp">
							  <tr>
								<th>ID</th>
								<th>Req No</th>
								<th>Date</th>
								<th>Req For</th>
								<th>Note</th>
								<th>Warehouse</th>
								<th>Status</th>
							  </tr>
        <?php
		$query=db_query($sql);		  
		while($vno=mysqli_fetch_row($query))
		{
			$v_type = $_REQUEST['v_type'];$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo 'v_no='.$vno[0].'&view=Show' ?>');">
								<td><?php echo $vno[0] ?></td>
								<td><?php echo $vno[2] ?></td>
								<td><?php echo $vno[1] ?></td>
								<td><?php echo $vno[3] ?></td>
								<td><?php echo $vno[4] ?></td>
								<td><?php echo $vno[6] ?></td>
								<td><?php echo $vno[7] ?></td>
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