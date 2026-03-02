<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Work Order Create';
do_calander('#wo_date');
$table='lc_workorder';
$unique='id';

unset($_SESSION['wo_id']);
?><div class="form-container_large">
<form action="workorder_edit.php" method="post" name="codz" id="codz">
<table width="70%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong> Work Order No: </strong></td>
    <td bgcolor="#FF9966"><strong>
<?
$query = "select a.do_no,b.dealer_code,b.dealer_name_e from sale_do_master a,dealer_info b where b.dealer_code=a.dealer_code and a.status ='PROCESSING'  and a.do_date='".date('Y-m-d')."'  order by a.do_no";
?>
      <select name="wo_id" id="wo_id">
      <option></option>
        <?

$que=db_query($query);
while($data=mysqli_fetch_object($que)){
echo '<option value="'.$data->do_no.'">'.$data->do_no.'-'.$data->dealer_name_e.'</option>';
}
	  ?>    
      </select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="go" id="go" value="VIEW WORK ORDER" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>