<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Select Dealer for Demand Order';



$table_master='sale_do_master';

$unique_master='do_no';



$table_detail='sale_do_details';

$unique_detail='id';



$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_SESSION[$unique_master];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		$crud   = new crud($table_chalan);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

}

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





$table='sale_do_master';

$show='dealer_code';

$id='do_no';

$con='status="MANUAL"';



?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

}

</script>

<div class="form-container_large">

<form action="item_return.php" method="post" name="codz" id="codz">

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

    <td align="right" bgcolor="#FF9966"><strong>Unfinished DO  List: </strong></td>

    <td bgcolor="#FF9966"><strong>
  <select name="or_no" id="or_no">
	<?
     foreign_relation('warehouse_other_receive','or_no','or_no',$or_no,'status="MANUAL"');
	  ?></select>

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Complete DO" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>



</form>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>