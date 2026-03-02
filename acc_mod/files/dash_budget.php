<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Budget Dashboard';
$proj_id=$_SESSION['proj_id'];
$now=time();
?>
<link rel="stylesheet" type="text/css" href="../css/dash_board.css"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>   <div class="dashboard">
		    <!-- Dashboard icons -->
            <div class="grid_7">
            	<a href="../pages/budget_create.php" class="dashboard-module"><img src="../dash_images/5.gif" width="40" height="40" /><span>Budget Format </span></a>
                
                <a href="../pages/budget_monthly.php" class="dashboard-module"><img src="../dash_images/5.gif" width="40" height="40" /><span>Assign Budget  </span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/5.gif" width="40" height="40" /><span>Fiscal Year Assign  </span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/5.gif" width="40" height="40" /><span>Fiscal Year Generate </span></a>
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
