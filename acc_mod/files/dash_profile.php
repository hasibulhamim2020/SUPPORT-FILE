<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Profile Dashboard';
$proj_id=$_SESSION['proj_id'];
$now=time();
?>
<link rel="stylesheet" type="text/css" href="../css/dash_board_pe.css"/>
<link rel="stylesheet" type="text/css" href="../css/table_dashboard.css"/>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	 <div class="dashboard_left"><br />
				<table style="width:60%" border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td width="36%"><a href="../pages/project_info.php?proj_id=<?=$_SESSION['proj_id']?>" class="dashboard-module"><img src="../dash_images/dash1.gif" width="23" height="30" /><span>Company</span></a></td>
						<td width="23%"><div class="bar1"></div></td>
						<td width="41%"><a href="../pages/dash_profile.php" class="dashboard-module"><img src="../dash_images/dash2.gif" width="23" height="30" /><span>Profile </span></a></td>
					  </tr>
					  <tr>
						<td><div class="bar2"></div></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="3">
						  <div class="bar"></div></td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td><a href="../pages/ledger_group.php" class="dashboard-module"><img src="../dash_images/dash3.gif" width="23" height="30" /><span>Ledger Group</span></a></td>
						<td><div class="bar1"></div></td>
						<td><a href="../pages/account_ledger.php" class="dashboard-module"><img src="../dash_images/dash4.gif" width="23" height="30" /><span>Ledger Accounts </span></a></td>
					  </tr>
					  <tr>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					    <td><div class="bar2"></div></td>
			      </tr>
					  <tr>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					    <td><a href="../pages/account_sub_ledger.php" class="dashboard-module"><img src="../dash_images/dash5.gif" width="23" height="30" /><span>Sub Ledger  </span></a></td>
			      </tr>
					  <tr>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
			      </tr>
					   <tr>
						<td colspan="3">
						  <div class="bar"></div></td>
					  </tr>
					   <tr>
					     <td>&nbsp;</td>
					     <td>&nbsp;</td>
					     <td>&nbsp;</td>
			      </tr>
					   <tr>
 <td><a href="../pages/cost_category.php" class="dashboard-module"><img src="../dash_images/dash6.gif" width="23" height="30" /><span>Cost 
Category</span></a></td>
 <td><div class="bar1"></div></td>
 <td><a href="../pages/cost_center.php" class="dashboard-module"><img src="../dash_images/dash7.gif" width="23" height="30" /><span>Cost Center </span></a></td>
			      </tr>
					   <tr>
					     <td>&nbsp;</td>
					     <td>&nbsp;</td>
					     <td>&nbsp;</td>
			      </tr>
				      <tr>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
			      </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					</table>

</div>
		  <div class="dashboard_right">
		  <h1>Chart of Accounts</h1>
		  <table class="table_dashboard" cellspacing="0">									
							  <tr>
								<th>Ledger Id</th>
								<th>Ledger Name</th>
								<th>Under Ledger</th>
								<th>Balance</th>
							  </tr>
<?
$sql="SELECT DISTINCT 
				  a.ledger_id,
				  a.ledger_name,
				  SUM(dr_amt) AS DR_FIELD,
				  SUM(cr_amt) AS CR_FIELD,
				  c.group_name
				FROM
				  accounts_ledger a,
				  journal b,
				  ledger_group c
				WHERE
				  a.ledger_id = b.ledger_id and
				  c.group_id = a.ledger_group_id
				  
				GROUP BY
				  a.ledger_name,
				  a.balance_type,
				  a.ledger_id limit 15";
				  $query=db_query($sql);
$i=0;
while($data=mysqli_fetch_row($query))
{
$i++;
$ledger_id[]=$data[0];
$ledger_name[]=$data[1];
$dr_amt[]=$data[2];
$cr_amt[]=$data[3];
$group_name[]=$data[4];
}
for($j=0;$j<$i;$j++)
{
$cal=($dr_amt[$j]-$cr_amt[$j]);
if($cal<0)
$cal='<font color="#FF0000">'.($cal*(-1)).'</font>';
if($j%2==0) $class='class="alt"'; else $class='';
?>
							<tr <?=$class?>>
								<td><?=$ledger_id[$j]?></td>
								<td><?=$ledger_name[$j]?></td>
								<td><?=$group_name[$j]?></td>
								<td><?=$cal?></td>
		    				</tr>
<?
}
?>
			</table>
		  </div></td>
  </tr>
</table>
		  
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>
