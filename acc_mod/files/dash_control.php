<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Control Dashboard';
$proj_id=$_SESSION['proj_id'];
$now=time();
?>
<link rel="stylesheet" type="text/css" href="../css/dash_board.css"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>   <div class="dashboard">
		    <!-- Dashboard icons -->
            <div class="grid_7">
            	<a href="../pages/set_config.php?proj_id=<?=$_SESSION['proj_id']?>" class="dashboard-module"><img src="../dash_images/9.gif" width="40" height="40" /><span>Set Configaration</span></a>
                
                <a href="../pages/pass_change.php" class="dashboard-module"><img src="../dash_images/9.gif" width="40" height="40" /><span>Change Password</span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/9.gif" width="40" height="40" /><span>Admin Control</span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/9.gif" width="40" height="40" /><span>User Access</span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/9.gif" width="40" height="40" /><span>Data Back Up</span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/9.gif" width="40" height="40" /><span>Voucher Error</span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/9.gif" width="40" height="40" /><span>Delete Record</span></a>
                <div style="clear: both"></div>
</div> <!-- End .grid_7 -->
		</div>
		</td></tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>
