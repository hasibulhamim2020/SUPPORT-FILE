<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Monthly Notice Board';
$proj_id=$_SESSION['proj_id'];
$now=time();
?>
<link rel="stylesheet" type="text/css" href="../css/dash_board.css"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>   <div class="dashboard">
		    <!-- Dashboard icons -->
            <div class="grid_7">
            	<a href="../../nasim/pages/main/home.php" class="dashboard-module"><img src="../dash_images/11.gif" width="40" height="40" /><span>Main Page</span></a>
                
                <a href="../../nasim/pages/transaction/flat_allotment.php" class="dashboard-module"><img src="../dash_images/11.gif" width="40" height="40" /><span>Allotment Status</span></a>
                
                <a href="../../nasim/pages/transaction/money_receipt.php" class="dashboard-module"><img src="../dash_images/11.gif" width="40" height="40" /><span>Money Receipt</span></a>
                
                <a href="../../nasim/pages/report/report_selection.php" class="dashboard-module"><img src="../dash_images/11.gif" width="40" height="40" /><span>Reports</span></a>
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
