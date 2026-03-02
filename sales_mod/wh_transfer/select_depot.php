<?php
session_start();



ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Select Warehouse for Transfer';



$table_master='warehouse_transfer_master';

$unique_master='pi_no';



$table_detail='warehouse_transfer_detail';

$unique_detail='id';



$$unique_master=$_POST[$unique_master];



if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d H:s:i');

		//$_POST['status']='RECEIVED';
		
		
		$received_by = $_SESSION['user']['id'];
		$received_at = date('Y-m-d H:i:s');
		
		
		$req_no=find_a_field('warehouse_transfer_master','req_no','pi_no='.$$unique_master);

		$pi = find_all_field('warehouse_transfer_master','pi_no','pi_no='.$$unique_master);

	
		
		
		$sql = 'select * from warehouse_transfer_detail where pi_no='.$$unique_master;
		
		$query = mysqli_query ($sql);
		
		while($data=mysqli_fetch_object($query)){
		
journal_item_control($data->item_id ,$pi->warehouse_from, $data->pi_date ,0,$data->total_unit ,'Transit',$data->id,$data->unit_price,$pi->warehouse_to,$$unique_master);



}




 $sql = 'update warehouse_transfer_master set status="SEND"
		  where pi_no = '.$$unique_master;
		db_query($sql);




		$crud   = new crud($table_master);

		$crud->update($unique_master);

		$crud   = new crud($table_detail);

		$crud->update($unique_master);

		

		unset($$unique_master);

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Send.';

}



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

}





?>

<script language="javascript">

window.onload = function() {document.getElementById("dealer").focus();}

</script>

<div class="form-container_large">

<form action="depot_transfer_entry.php" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

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

    <td align="right" bgcolor="#FF9966"><strong>From Warehouse: </strong></td>

    <td bgcolor="#FF9966"><strong>

      	  <select name="line_id" id="line_id" style="width:270px;" required>

		 <option></option>

	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1 order by warehouse_id');?>



	  </select>

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Warehouse Transfer" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>

</form>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>