<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Requisition Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'requisition_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = '../mr/mr_print_view.php';

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
      <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>"  autocomplete="off"/>
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>"  autocomplete="off"/>
    </strong></td>
    <td rowspan="2" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
<select name="status" id="status" style="width:200px;">
<option><?=$_POST['status']?></option>
<option>UNCHECKED-BOWQ</option>
<option>UNCHECKED</option>
<option>CHECKED</option>
<option>PENDING</option>
<option>COMPLETE</option>
<option>STOPPED</option>
<option>ALL</option>
<option></option>
<option></option>
</select>
    </strong></td>
    </tr>
</table>

</form>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit']))
{if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

 $res='select a.req_no,a.req_no, a.req_date, a.req_for, b.warehouse_name as warehouse, a.req_note as note, a.need_by, c.fname as entry_by, a.entry_at,a.status 
from requisition_master a,warehouse b,user_activity_management c 
where  a.warehouse_id='.$_SESSION['user']['depot'].' and a.warehouse_id=b.warehouse_id 
and a.entry_by=c.user_id 
'.$con.' 
and a.status not in ("MANUAL","") 
order by a.req_no desc';

echo link_report($res,'mr_print_view.php');
}
?>
</div></td>
</tr>
</table>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>