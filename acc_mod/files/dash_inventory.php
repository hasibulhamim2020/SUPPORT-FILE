<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Inventory Dashboard';
$proj_id=$_SESSION['proj_id'];
$now=time();
?>
<link rel="stylesheet" type="text/css" href="../css/dash_board_pe.css"/>
<link rel="stylesheet" type="text/css" href="../css/table_dashboard.css"/>
   <div class="dashboard_left" style="padding-right:20px;">
     <table  style="width:80%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="23%"><a href="../pages/customer_info.php" class="dashboard-module"><img src="../dash_images/dash16.gif" width="23" height="30" /><span>Customer (Debitor)</span></a></td>
         <td width="14%">&nbsp;</td>
         <td width="24%"><a href="../pages/item_group.php" class="dashboard-module"><img src="../dash_images/dash17.gif" width="23" height="30" /><span>Item Group </span></a></td>
         <td width="14%">&nbsp;</td>
         <td width="25%"><a href="../pages/vendor_info.php" class="dashboard-module"><img src="../dash_images/dash18.gif" width="23" height="30" /><span>Vendor (Creditor)</span></a></td>
       </tr>
       <tr>
         <td><div class="bar5"></div></td>
         <td></td>
         <td><div class="bar5"></div></td>
         <td></td>
         <td><div class="bar5"></div></td>
       </tr>
       <tr>
         <td colspan="5"><div class="bar3" style="width:300px;"></div></td>
       </tr>
       <tr>
         <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td><div class="bar5"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash19.gif" width="23" height="30" /><span>Quotation Proposal </span></a></td>
             </tr>
             <tr>
               <td><div class="bar5"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash21.gif" width="23" height="30" /><span>Sales Invoice</span></a></td>
             </tr>
             <tr>
               <td><div class="bar5"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash24.gif" width="23" height="30" /><span>Recieve Voucher</span></a></td>
             </tr>
             <tr>
               <td><div class="bar5"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash28.gif" width="23" height="30" /><span>Bank Deposit </span></a></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
         </table></td>
         <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td><div class="bar1" style="width:30px;"></div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
         </table></td>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash22.gif" width="23" height="30" /><span>Inventory or Stock</span></a></td>
             </tr>
             <tr>
               <td><div class="bar5"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash26.gif" width="23" height="30" /><span>Return Stock </span></a></td>
             </tr>
             <tr>
               <td><div class="bar6"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash29.gif" width="23" height="30" /><span>Adjust Stock </span></a></td>
             </tr>
             <tr>
               <td><div class="bar6"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash31.gif" width="23" height="30" /><span>Reports</span></a></td>
             </tr>
         </table></td>
         <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td><div class="bar1" style="width:30px;"></div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
         </table></td>
         <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td><div class="bar5"></div></td>
             </tr>
             <tr>
               <td><a href="../pages/item_requisition_report.php" class="dashboard-module"><img src="../dash_images/dash20.gif" width="23" height="30" /><span>Purchase Requisition</span></a></td>
             </tr>
             <tr>
               <td><div class="bar5"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash23.gif" width="23" height="30" /><span>Purchase Invoice</span></a></td>
             </tr>
             <tr>
               <td><div class="bar5"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash27.gif" width="23" height="30" /><span>Payment Voucher</span></a></td>
             </tr>
             <tr>
               <td><div class="bar5"></div></td>
             </tr>
             <tr>
               <td><a href="#" class="dashboard-module"><img src="../dash_images/dash30.gif" width="23" height="30" /><span>Bank Withdraw </span></a></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
         </table></td>
       </tr>
     </table>
   </div>
		  <div class="dashboard_right">
      <h1>Item Information</h1>
      <div class="dashboard_box1">
        <table class="table_dashboard" cellspacing="0">
          <tr>
            <th>Ledger Id</th>
            <th>Item Name</th>
            <th>Sale Price</th>
            <th>Stock</th>
          </tr>
<?
unset($col1);
unset($col2);
unset($col3);
unset($col4);
$sql="select item_id, item_name, cost_price,(rcvqty+returnqty-saleqty-issueqty) as qty from  item_info order by qty desc limit 7";
$query=db_query($sql);
$i=0;
while($data=mysqli_fetch_row($query))
{
$i++;
$col1[]=$data[0];
$col2[]=$data[1];
$col3[]=$data[2];
$col4[]=$data[3];
}
for($j=0;$j<8;$j++)
{
if($j%2==0) $class='class="alt"'; else $class='';
?>
							<tr <?=$class?>>
								<td><?=$col1[$j]?></td>
								<td><?=$col2[$j]?></td>
								<td><?=$col3[$j]?></td>
								<td><?=$col4[$j]?></td>
		    				</tr>
<? }?>

        </table>
      </div>
		  <h1>Vendor (Creditor) List</h1>
		  <div class="dashboard_box1">
        <table class="table_dashboard" cellspacing="0">
          <tr>
            <th>Ledger Id</th>
            <th>Vendor Name</th>
            <th>Contact</th>
            <th>Balance</th>
          </tr>
<?
unset($col1);
unset($col2);
unset($col3);
unset($col4);
$sql="select a.ledger_id,b.vendor_name,b.contact_no,sum(a.cr_amt) as cr from  journal a, vendor b where a.tr_from='Purchase' and b.vendor_id=a.ledger_id group by ledger_id order by cr desc limit 7";
$query=db_query($sql);
$i=0;
while($data=mysqli_fetch_row($query))
{
$i++;
$col1[]=$data[0];
$col2[]=$data[1];
$col3[]=$data[2];
$col4[]=$data[3];
}
for($j=0;$j<8;$j++)
{
if($j%2==0) $class='class="alt"'; else $class='';
?>
							<tr <?=$class?>>
								<td><?=$col1[$j]?></td>
								<td><?=$col2[$j]?></td>
								<td><?=$col3[$j]?></td>
								<td><?=$col4[$j]?></td>
		    				</tr>
<? }?>

        </table>
      </div>
		  <h1>Customer (Detor) List</h1>
	<div class="dashboard_box1">
	    <table class="table_dashboard" cellspacing="0">
          <tr>
            <th>Ledger Id</th>
            <th>Customer Name</th>
            <th>Contact</th>
            <th>Balance</th>
          </tr>
<?
unset($col1);
unset($col2);
unset($col3);
unset($col4);
$sql="select a.ledger_id,b.customer_name,b.contact_no,sum(a.dr_amt) as dr from  journal a, customer b where a.tr_from='Sales' and b.customer_id=a.ledger_id group by ledger_id order by dr desc limit 7";
$query=db_query($sql);
$i=0;
while($data=mysqli_fetch_row($query))
{
$i++;
$col1[]=$data[0];
$col2[]=$data[1];
$col3[]=$data[2];
$col4[]=$data[3];
}
for($j=0;$j<8;$j++)
{
if($j%2==0) $class='class="alt"'; else $class='';
?>
							<tr <?=$class?>>
								<td><?=$col1[$j]?></td>
								<td><?=$col2[$j]?></td>
								<td><?=$col3[$j]?></td>
								<td><?=$col4[$j]?></td>
		    				</tr>
<? }?>

        </table>
	</div>	
						
		  </div>
		  
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>
