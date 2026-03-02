<?php

session_start();

ob_start();

require "../../support/inc.all.php";



$title='Product Receive Status';



do_calander('#fdate');

do_calander('#tdate');



$table = 'requisition_master';

$unique = 'req_no';

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

      <input type="text" name="fdate" id="fdate" style="width:120px;" value="<? if($_POST['fdate']=='') echo date('Y-m-01'); else echo $_POST['fdate'];?>" />

    </strong></td>

    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" style="width:120px;" value="<? if($_POST['tdate']=='') echo date('Y-m-d'); else echo $_POST['tdate'];?>" />

    </strong></td>

    <td rowspan="3" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Transfer Status : </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="status" id="status" style="width:200px;">

		<option <? if($_POST['status']==''||$_POST['status']=='IN TRANSIT') echo 'Selected';?>>IN TRANSIT</option>

		<option <? if($_POST['status']=='TRANSFERED') echo 'Selected';?>>TRANSFERED</option>

		<option <? if($_POST['status']=='ALL SEND') echo 'Selected';?>>ALL SEND</option>

      </select>

    </strong></td>

    </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Sending Inventory: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="depot" id="depot" style="width:200px;">

<option></option>



<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot'],'1 and use_type="WH" order by warehouse_name');?>

</select>

    </strong></td>

    </tr>

</table>



</form>

</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2"><? 



if($_POST['depot']!=''&&$_POST['depot']!='ALL')

$con .= 'and a.warehouse_from="'.$_POST['depot'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['status']==''||$_POST['status']=='IN TRANSIT')

$con .=  'and a.status="SEND"';

elseif($_POST['status']==''||$_POST['status']=='TRANSFERED')

$con .=  'and a.status!="SEND"';

else

{$do = 'nothing';}



$res='select  	a.pi_no as transfer_id,a.pi_no as transfer_id, a.pi_date as date, ug.group_name as company, b.warehouse_name as Warehouse_from, a.status, u.fname as entry_by, a.entry_at from user_activity_management u, warehouse_transfer_master a, warehouse b, user_group ug where a.group_for=ug.id and  a.entry_by=u.user_id and a.warehouse_from=b.warehouse_id and a.warehouse_to="'.$_SESSION['user']['depot'].'" and b.use_type!="PL" '.$con.' order by a.pi_no desc';

echo link_report($res,'print_view.php');

?></div></td>

</tr>

</table>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>