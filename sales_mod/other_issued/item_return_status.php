<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Purchase Return List';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../purchase_return/item_return_report.php';

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
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:110px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:110px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td bgcolor="#FF9966"><strong>
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


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and b.pr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

  $res='select  a.pr_no,a.pr_no as pr_no,v.vendor_name as vendor_name,sum(a.total_amt) as Total,b.pr_date as pr_date,b.remarks as remarks,a.status as status from purchase_return_details a,purchase_return_master b,vendor v where a.pr_no=b.pr_no and v.vendor_id=a.vendor_id '.$con.' group by a.pr_no order by a.pr_no desc';
//and a.warehouse_id = "'.$_SESSION['user']['depot'].'" change by kamrul dated 09-01-2022

echo link_report($res,'po_print_view.php');

}
?>
</div></td>
</tr>
</table>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>