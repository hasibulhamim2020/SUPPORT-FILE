<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Requization Status Report';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'req_no';
$status = 'CHECKED';
$target_url = '../pr/chalan_view2.php';

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
        <td width="408">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td width="419">&nbsp;</td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#7fcbf4"><b>Requisition Form :</b></td>
        <td colspan="3" bgcolor="#7fcbf4"><select name="warehouse_id" id="warehouse_id">
                      <option selected="selected"></option>
					  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id']);?>
                    </select>&nbsp;</td>
        <td bgcolor="#7fcbf4">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#7fcbf4"><b>Item Sub Category :</b></td>
        <td colspan="3" bgcolor="#7fcbf4"><select name="sub_group_id" id="sub_group_id">
          <option></option>
          <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group_id']);?>
        </select></td>
        <td bgcolor="#7fcbf4">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#7fcbf4"><strong>Date Interval :</strong></td>
        <td width="80" bgcolor="#7fcbf4"><strong>
          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
        </strong></td>
        <td width="34" align="center" bgcolor="#7fcbf4"><strong> -to- </strong></td>
        <td width="91" bgcolor="#7fcbf4"><strong>
          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td bgcolor="#7fcbf4"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#000000"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<div class="tabledesign2">

<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<tbody>

	<tr>
		<th>Req No</th>
		<th>Req Date</th>
		<th>Req For</th>
		<th>RID-Item Name </th>
		<th>REQ</th>
		<th>POQ</th>
		<th>GRQ</th>
		<th>DUE</th>
	</tr>
<? 
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
if($_POST['warehouse_id']>0)
$con .= 'and b.warehouse_id="'.$_POST['warehouse_id'].'"';
if($_POST['sub_group_id']>0)
$con .= 'and i.sub_group_id="'.$_POST['sub_group_id'].'"';

echo $res='select  a.id,a.req_no, a.req_date,a.qty, b.warehouse_name req_for, u.fname as entry_by,i.item_name,i.unit_name
from 
requisition_order a,warehouse b, user_activity_management u, item_info i where i.item_id=a.item_id and u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' order by a.id desc';

$query = db_query($res);
while($data=mysqli_fetch_object($query))
{

?>
	<tr>
      <td valign="top"><?=$data->req_no;?></td>
	  <td valign="top"><?=$data->req_date;?></td>
	  <td valign="top"><?=$data->req_for;?></td>
	  <td><?=$data->id;?>
-
  <?=$data->item_name.'('.$data->unit_name.')';?></td>
	  <td><?=number_format($data->qty,0)?></td>
	  <td><? $odr = find_all_field_sql('select sum(qty) qty,a.id as order_no from purchase_invoice a where a.req_id="'.$data->id.'"'); echo number_format($odr->qty,0);?></td>
	  <td><? $rq =  find_a_field('purchase_receive','sum(qty)','order_no="'.$odr->order_no.'"'); echo number_format($rq,0);?></td>
	  <td><? $dq = $odr->qty - $rq; if($dq>0) echo number_format($dq,0);?></td>
	</tr>
<? }}?>
</tbody></table>
</div>
</td>
</tr>
</table>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>