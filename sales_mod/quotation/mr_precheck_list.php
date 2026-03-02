<?php
session_start();
ob_start();
require "../../support/inc.all.php";

$title='Unapproved Requisition Entry';

do_calander('#fdate');
do_calander('#tdate');

$table = 'spare_parts_requisition_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = '../mrsp/mr_checking.php';

@session_destroy($_SESSION['req_no']);

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl,false);
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=$_POST['fdate']?>" />
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=$_POST['tdate']?>" />
    </strong></td>
    <td rowspan="2" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Warehouse Name: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><select name="warehouse_id" id="warehouse_id">
      <option selected="selected"></option>
      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],' 1 and use_type="WH"');?>
    </select></td>
    </tr>
</table>

</form>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 

$con .= ' and a.status="UNCHECKED"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['warehouse_id']!='')
$con .= 'and b.warehouse_id = "'.$_POST['warehouse_id'].'"';

 $res='select  	a.req_no,a.req_no as Requisition_no, DATE_FORMAT(a.req_date, "%d-%m-%Y") as Requisition_date,  b.warehouse_name as Warehouse_name,  c.fname as entry_by, a.entry_at,a.status from spare_parts_requisition_master a,warehouse b,user_activity_management c where a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id '.$con.'  order by a.req_no';
echo link_report($res,'mr_print_view.php');
?>
</div></td>
</tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>