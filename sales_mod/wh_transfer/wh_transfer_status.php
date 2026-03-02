<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Warehouse Transfer Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'pi_no';
$status = 'UNCHECKED';
$target_url = '../wh_transfer/print_view_receive.php';

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
      <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" />
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" />
    </strong></td>
    <td rowspan="4" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966">From Warehouse : </td>
    <td colspan="3" bgcolor="#FF9966"><strong>
      <select name="warehouse_from" id="warehouse_from" style="width:200px;">
        <option value="">ALL</option>
		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_from'],'1 ');?>
      </select>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966">To Warehouse : </td>
    <td colspan="3" bgcolor="#FF9966"><strong>
      <select name="warehouse_to" id="warehouse_to" style="width:200px;">
        <option value="">ALL</option>
		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_to'],'1 ');?>
      </select>
    </strong></td>
  </tr>
  <!--<tr>
    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
<select name="status" id="status" style="width:200px;">
<option><?=$_POST['status']?></option>
<option>UNCHECKED</option>
<option>CHECKED</option>
<option>ALL</option>
</select>
    </strong></td>
    </tr>-->
</table>

</form>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){
if($_POST['status']!=''&&$_POST['status']!='ALL')
$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['group_for']!='')
$con .= 'and a.group_for = "'.$_POST['group_for'].'"';

if($_POST['warehouse_from']!='')
$con .= 'and a.warehouse_from = "'.$_POST['warehouse_from'].'"';

if($_POST['warehouse_to']!='')
$con .= 'and a.warehouse_to = "'.$_POST['warehouse_to'].'"';


  $res='select  a.pi_no,a.pi_no as TR_No, DATE_FORMAT(a.pi_date, "%d-%m-%Y") as TR_date, u.group_name as Company_name, b.warehouse_name as From_warehouse,  
 (select warehouse_name from warehouse where warehouse_id=a.warehouse_to) as To_warehouse, c.fname as "entry_by", a.entry_at,a.status from warehouse_transfer_master a,warehouse b,user_activity_management c, user_group u where a.warehouse_from=b.warehouse_id and a.entry_by=c.user_id and a.group_for=u.id '.$con.' order by a.pi_no desc';
echo link_report($res,'po_print_view.php');

}
?>
</div></td>
</tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>