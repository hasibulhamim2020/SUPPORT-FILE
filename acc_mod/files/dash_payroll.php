<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Payroll Dashboard';
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
            	<a href="../pages/payroll_department_info.php" class="dashboard-module"><img src="../dash_images/7.gif" width="40" height="40" /><span>Department Info</span></a>
                
                <a href="../pages/payroll_employee_info.php" class="dashboard-module"><img src="../dash_images/7.gif" width="40" height="40" /><span>Employee Info</span></a>
                
                <a href="../pages/payroll_salary_scale.php" class="dashboard-module"><img src="../dash_images/7.gif" width="40" height="40" /><span>Salary Scale</span></a>
                
                <a href="../pages/payroll_salary_issue.php" class="dashboard-module"><img src="../dash_images/7.gif" width="40" height="40" /><span>Monthly Salary</span></a>
                
                <a href="../pages/payroll_access_deny.php" class="dashboard-module"><img src="../dash_images/7.gif" width="40" height="40" /><span>Advance Salary</span></a>
                
                <a href="../pages/payroll_access_deny.php" class="dashboard-module"><img src="../dash_images/7.gif" width="40" height="40" /><span>Increment</span></a>
                
                <a href="../pages/payroll_access_deny.php" class="dashboard-module"><img src="../dash_images/7.gif" width="40" height="40" /><span>Probident Fund</span></a>
				
				<a href="../pages/payroll_access_deny.php" class="dashboard-module"><img src="../dash_images/7.gif" width="40" height="40" /><span>Income Tax</span></a>
				
				<a href="../pages/payroll_access_deny.php" class="dashboard-module"><img src="../dash_images/7.gif" width="40" height="40" /><span>Festival Bonus</span></a>
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
