<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Undelivered Demand Order';

$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$$unique_master=$_SESSION[$unique_master];


if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='PROCESSING';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("do").focus();
}
</script>
<div class="form-container_large">
<form action="do_chalan.php" method="post" name="codz" id="codz">
<table style="width:70%; border:0; margin:0 auto; text-align:center;">
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
    <td  style="background-color:#FF9966; text-align:right;"><strong>Active Dealer List: </strong></td>
    <td  style="background-color:#FF9966;"><strong>


      <select name="do" id="do">
      <option></option>
        <?
$query = "select a.do_no,b.dealer_code,b.dealer_name_e from sale_do_master a,dealer_info b where b.dealer_code=a.dealer_code and a.status ='PROCESSING'  order by a.do_no";
$que=db_query($query);
while($data=mysqli_fetch_object($que)){
echo '<option value="'.$data->do_no.'">'.$data->do_no.'-'.$data->dealer_name_e.'</option>';
}
	  ?>    
      </select>
    </strong></td>
    <td  style="background-color:#FF9966;"><strong>
      <input type="submit" name="submitit" id="submitit" value="Chalan DO" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>