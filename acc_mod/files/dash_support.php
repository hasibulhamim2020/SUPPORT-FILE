<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Support Dashboard';
$proj_id=$_SESSION['proj_id'];
$now=time();
?>
<link rel="stylesheet" type="text/css" href="../css/dash_board.css"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>     
	 <div class="dashboard">
		    <!-- Dashboard icons -->
            <div class="grid_7">
            	<a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/8.gif" width="40" height="40" /><span>Request for Support</span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/8.gif" width="40" height="40" /><span>Reply Againsts Client Request</span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/8.gif" width="40" height="40" /><span>Submit New Requirement</span></a>
                
                <a href="../pages/access_deny.php" class="dashboard-module"><img src="../dash_images/8.gif" width="40" height="40" /><span>Message Communication</span></a>
                <div style="clear: both"></div>
</div> <!-- End .grid_7 -->
		</div></td></tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>
