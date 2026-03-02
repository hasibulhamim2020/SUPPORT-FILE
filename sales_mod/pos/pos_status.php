<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='POS Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'sale_pos_master';
$unique = 'pos_id';
$status = 'UNCHECKED';
$target_url = '../pos/pos_print_view.php';

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
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
      <input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=$_POST['fdate']?>" />
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:120px;" value="<?=$_POST['tdate']?>" />
    </strong></td>
    <td rowspan="2" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  
</table>

</form>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if($_POST['status']!=''&&$_POST['status']!='ALL')
$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.pos_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



  $res='select   a.pos_id,a.pos_id, DATE_FORMAT(a.pos_date, "%d-%m-%Y") as Sale_Date, b.warehouse_name as Warehouse_name, c.fname as entry_by, a.entry_at from  sale_pos_master a, warehouse b, user_activity_management c  where a.warehouse_id=b.warehouse_id and
a.warehouse_id='.$_SESSION['user']['depot'].'  and a.entry_by=c.user_id '.$con.'  group by a.pos_id order by a.pos_id desc';
echo link_report($res,'mr_print_view.php');



?>
</div></td>
</tr>
</table>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>