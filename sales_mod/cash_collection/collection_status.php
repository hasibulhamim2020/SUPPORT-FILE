<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Cash Collection Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';

 $master_id = find_a_field('user_activity_management','master_user','user_id='.$_SESSION['user']['id']);
 
$target_url = '../cash_collection/cash_collection_report.php';

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
    <table style="width:80%; border:0; text-align:center; margin:0 auto;">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" style="background-color:#FF9966;"><strong>Warehouse: </strong></td>
        <td colspan="3" style="background-color:#FF9966;"><strong>
          <? if($master_id==1){?>	
                      <select name="warehouse_id" id="warehouse_id" style=" float:left; width:90%;">
					  
					  <option></option>

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');?>
 
                      </select>
					  
				<? }?>
					  
					  <? if($master_id==0){?>	
			
					  <select name="warehouse_id" id="warehouse_id" style=" float:left; width:90%;">
				

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
 
                      </select>
					
				 <? }?>	 
        </strong></td>
        <td style="background-color:#FF9966;">&nbsp;</td>
      </tr>
      <tr>
        <td style="background-color:#FF9966; text-align:right;"><strong>Date Interval:</strong></td>
        <td style="background-color:#FF9966; width:50%;"><strong>
          <input type="text" name="fdate" id="fdate" style="width:110px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />
        </strong></td>
        <td style="background-color:#FF9966; text-align:center; padding:0 5px;"><strong> -to- </strong></td>
        <td  style="background-color:#FF9966; width:50%;"><strong>
          <input type="text" name="tdate" id="tdate" style="width:110px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td style="background-color:#FF9966;"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table  style="width:100%; border:0; border-collapse:collapse; padding:0;">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!=''){
$con .= ' and a.collection_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
}
if($_POST['warehouse_id']!=''){
$con .= ' and a.warehouse_id = "'.$_POST['warehouse_id'].'" ';
}


   $res='select  a.collection_no, a.collection_no, DATE_FORMAT(a.collection_date, "%d-%m-%Y") as collection_date, w.warehouse_name,  u.fname as entry_by, a.entry_at
from collection_from_customer a, warehouse w, user_activity_management u
where a.warehouse_id=w.warehouse_id and a.entry_by=u.user_id '.$con.' group by a.collection_no order by a.collection_date,a.warehouse_id asc';


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