<?php
session_start();



ob_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Select Warehouse for Collection Entry';



$table_master='production_issue_master';

$unique_master='pi_no';



$table_detail='production_issue_detail';

$unique_detail='id';



$$unique_master=$_POST[$unique_master];



if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d H:s:i');

		$_POST['status']='MENUAL';

		$pi = find_all_field('production_issue_master','pi_no','pi_no='.$$unique_master);

		if($_SESSION['user']['depot']==5)

		{

		$ledger = 3002000100020000;

		$sales_ledger = 1079000400010001;

		auto_insert_sale_hfl($pi->pi_date,$ledger,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no);
		
		
		$sql = 'select * from production_issue_detail where pi_no='.$$unique_master;
		
		$query = mysqli_query ($sql);
		
		while($data=mysqli_fetch_object($query)){
		
		journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->pi_date ,0,$data->total_unit ,'Transit',$data->id,$data->unit_price,$pi->warehouse_to,$$unique_master);

}







		}

		else

		{

		$ledger = 1078000200010000;

		$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$_SESSION['user']['depot']);

		$sales_ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);	

		$narration = 'PI No-'.$pi_no.'||SendDt:'.$pi->pi_date;

		auto_insert_store_transfer_issue($pi->pi_date,$ledger,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);

		}

		

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

<form action="collection_from_customer.php" method="post" name="codz" id="codz">

<table  style="width:80%; margin:0 auto; border:0; text-align:center;">

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

    <td  style="text-align:right; background-color: #FF9966;"><strong>Select Warehouse : </strong></td>

    <td  style="background-color: #FF9966;"><strong>

      	  <select name="warehouse_id" id="warehouse_id" style="width:200px;" required>

		  <option></option>

	       <?

foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1 order by warehouse_id');

?>




	  </select>

    </strong></td>

    <td style="background-color: #FF9966;"><strong>

      <input type="submit" name="submitit" id="submitit" value="View Details" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>

</form>

</div>



<?

// $main_content=ob_get_contents();

// ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>