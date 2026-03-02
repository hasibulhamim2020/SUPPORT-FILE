<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
session_start();
ob_start();
// require "../../support/inc.all.php";
$title='Stock Position Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../blend_sheet/stock_position_report.php';

if($_REQUEST[$unique]>0)
{
$_SESSION[$unique] = $_REQUEST[$unique];
header('location:'.$target_url);
}

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>
<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table  style="width:80%; border:0; margin:0 auto; text-align:center;">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="background-color:#FF9966; text-align:right;"><strong>Warehouse : </strong></td>
        <td colspan="3" style="background-color:#FF9966;"><strong>
          <select name="line_id" id="line_id" style="width:220px;" required="required">

            <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['line_id'],'warehouse_id="5" order by warehouse_name');?>
          </select>
        </strong></td>
        <td style="background-color:#FF9966;">&nbsp;</td>
      </tr>
      <tr>
        <td  style="background-color:#FF9966; text-align:right;"><strong>Date Interval :</strong></td>
        <td  style=" background-color:#FF9966;"><strong>
          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />
        </strong></td>
        <td  style="background-color:#FF9966; text-align:center;"><strong> -to- </strong></td>
        <td style="background-color:#FF9966;"><strong>
          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td style="background-color:#FF9966;"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!=''){
$con .= ' and a.issue_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

if($_POST['line_id']!=''){
$con .= ' and c.warehouse_id = "'.$_POST['line_id'].'" ';}

  $res='select  a.issue_no, a.issue_no as TR_NO, DATE_FORMAT(a.issue_date, "%d-%m-%Y") as stock_Date, c.warehouse_name as warehouse_name,  u.fname as entry_by, a.entry_at
from black_tea_consumption a, warehouse c, user_activity_management u
where a.warehouse_id=c.warehouse_id and a.entry_by=u.user_id '.$con.' group by a.issue_no order by a.issue_date asc';


echo link_report($res,'sales_view_acc.php');

}
?>
</div></td>
</tr>
</table>
</div>

<?
// $main_content=ob_get_contents();
// ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>