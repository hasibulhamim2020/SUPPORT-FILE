<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Ledger Account by Ledger Group';
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
$gid=$_GET['g_id'];
$group=mysqli_fetch_row(db_query("select group_name from ledger_group where group_id='$gid' limit 1"));
$group_name=$group[0];
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="alt">
    <td>Group Name: <?=$group_name;?></td>
  </tr>
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>
									<table id="grp" class="tabledesign" cellspacing="0">
							  <tr>
								<th>S/N</th>
								<th>Ledger Account</th>
								<th>Account Type</th>
								<th>Opening Balance</th>
								<th>Created On</th>
							  </tr>
<?php

	$rrr = "select * from accounts_ledger where ledger_group_id='$gid' and 1";
	//echo $rrr;
	$report = db_query($rrr);
	$i=0;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?>>
								<td><?php echo $i;?></td>
								<td><?=$rp[1];?></td>
								<td><?=$rp[4];?></td>
								<td><?=$rp[3];?></td>
								<td><?=date("d.m.y",$rp[7]);?></td>
							  </tr>
	<?php }?>
							</table>									</td>
								  </tr>
		</table>

							</div></td>
  </tr>
</table>9
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