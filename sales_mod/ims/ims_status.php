<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Local Purchase List';

do_calander('#fdate');
do_calander('#tdate');

$table = 'ims_master';
$unique = 'ims_no';
$status = 'CHECKED';
$target_url = '../ims/ims_update.php';

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
          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=date('Y-m-01')?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=date('Y-m-d')?>" />
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
$con .= 'and i.order_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

 $res='select  i.ims_no,i.ims_no as ims_no,i.order_date as order_date, i.memo as memos, a.AREA_NAME as area_name from ims_master i, area a where i.area_id=a.AREA_CODE   '.$con;


//, base_market b
//, b.BASE_MARKET_NAME as base_market
//and i.base_market=b.BASE_MARKET_CODE
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