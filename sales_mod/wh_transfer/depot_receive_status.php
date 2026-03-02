<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Warehouse Receive Status';



do_calander('#fdate');

do_calander('#tdate');



$table = 'warehouse_transfer_master';

$unique = 'pi_no';

$status = 'CHECKED';

$target_url = '../wh_transfer/depot_receive_print_view.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}



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

        <td align="right"  width="20%" bgcolor="#FF9966"><strong>Date:</strong></td>

        <td  width="25%"  bgcolor="#FF9966"><strong>

          <input type="text" name="fdate" id="fdate" style="width:95%;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />

        </strong></td>

        <td align="center"  width="10%"  bgcolor="#FF9966"><strong> -to- </strong></td>

        <td  width="25%" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:95%;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>

        <td rowspan="2"   width="20%"  bgcolor="#FF9966"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

        </strong></td>
      </tr>
      <tr>
        <td align="right" width="20%" bgcolor="#FF9966"><strong>Warehouse:</strong></td>
        <td colspan="3" width="60%" bgcolor="#FF9966"><select name="warehouse_id" id="warehouse_id" style="width:90%;">



<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'" order by warehouse_name');?>

</select></td>
      </tr>
    </table>

  </form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<? 

if(isset($_POST['submitit'])){

if($_POST['warehouse_id']!='')

$con .= 'and a.warehouse_to="'.$_POST['warehouse_id'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



 $res='select  a.pi_no,a.pi_no as TR_no, a.pi_date as TR_date,  w.warehouse_name as warehouse_name, a.status,  c.fname as entry_by
from warehouse_transfer_master a, warehouse_transfer_detail b, user_activity_management c, warehouse w
 where  a.pi_no=b.pi_no and a.entry_by=c.user_id  and w.warehouse_id=a.warehouse_to and a.warehouse_to = "'.$_SESSION['user']['depot'].'" '.$con.'  group by a.pi_no order by a.pi_no';

echo link_report($res,'po_print_view.php');


}

?>

</div></td>

</tr>

</table>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>