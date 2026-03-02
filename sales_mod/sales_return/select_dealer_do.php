<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Select Dealer for Return Sales Order';



$table_master='sale_return_master';

$unique_master='do_no';



$table_detail='sale_return_details';

$unique_detail='id';

if($_GET['mhafuz']){
unset($_SESSION['do_no']);
}

$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_POST[$unique_master];



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

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

?>
<script language="javascript">
window.location.href = "do.php";
</script>
<?
}

if(isset($_POST['confirm']))

{

 $or_no = $_REQUEST['do_no'];
 
$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d h:i:s');

$sql2 = 'update sale_return_details set status="UNCHECKED" where do_no = '.$or_no;
db_query($sql2);
$sql3 = 'update sale_return_master set status="UNCHECKED", invoice_no="'.$chalan_no.'" where do_no = '.$or_no;
db_query($sql3);
}	

auto_complete_from_db('dealer_info','concat(dealer_name_e)','dealer_code','depot="'.$_SESSION['user']['depot'].'"','dealer');

?>

<script language="javascript">

window.onload = function() {document.getElementById("dealer").focus();}

</script>

<div class="form-container_large">

<form action="do.php" method="post" name="codz" id="codz">

<table width="70%" border="0" align="center">

  <tr>

    <td></td>

    <td>&nbsp;</td>

    <td></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Active Dealer List: </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input name="dealer" type="text" id="dealer" style="background-color:white;" class="form-control"/>

    </strong></td>

    <td bgcolor="#FF9966" style="text-align:center"><strong>

      <input type="submit" name="submitit" id="submitit" value="Create DO" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:DodgerBlue"/>

    </strong></td>

  </tr>

</table>



</form>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>