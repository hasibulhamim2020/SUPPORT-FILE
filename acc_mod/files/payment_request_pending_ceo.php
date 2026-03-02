<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Pending Payment Request';

do_calander('#fdate');
do_calander('#tdate');

$table = 'secondary_journal';
$unique = 'vo_no';
$status = 'UNCHECKED';
$target_url = 'payment_request_print_view_ceo.php';

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
$con.= 'and s.jv_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



  $res='select  	s.jv_no, s.tr_no as Request_id, DATE_FORMAT(s.jv_date, "%d-%m-%Y") as date, 
  a.ledger_name as bank_name, sum(cr_amt) as Amount,   u.fname as entry_by,  s.entry_at from secondary_journal s, accounts_ledger a, user_activity_management u where 
s.ledger_id=a.ledger_id and s.entry_by=u.user_id and s.dr_amt<1 

and s.ca_checked>0 and s.fc_checked>0 and s.om_checked>0 and s.ceo_checked<1



'.$con.' and s.tr_from in ("Payment") group by s.jv_no order by s.jv_no desc';


echo link_report($res,'mr_print_view.php');



?>
</div></td>
</tr>
</table>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>