<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Return List';

do_calander('#fdate');
do_calander('#tdate');

$table = 'sale_return_master';
$unique = 'do_no';
$status = 'CHECKED';
$target_url = '../report/item_return_report.php';

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
$con .= 'and a.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

  $res='select  a.do_no,a.do_no as sr_no,a.do_date as sr_date,d.dealer_name_e as dealer,sum(a.total_amt) as Total,a.remarks as remarks, a.status as status from sale_return_details a,sale_return_master b,dealer_info d where a.do_no=b.do_no and d.dealer_code=a.dealer_code '.$con.' group by a.do_no order by a.do_no desc';
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