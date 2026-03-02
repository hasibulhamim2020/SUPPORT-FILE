<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Select Dealer for Demand Order';



$table_master='sale_do_master';

$unique_master='do_no';



$table_detail='sale_do_details';

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

}

if(isset($_POST['confirm']))

{

 $or_no = $_REQUEST['do_no'];
 
$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d h:i:s');


$chalan_no = date('ym').sprintf('%06d', $or_no);

$prevent_multi=find_a_field('sale_do_chalan','chalan_no','do_no='.$or_no);

if ($prevent_multi<1) {





$do_sql = "select a.*, m.do_no, m.do_date from sale_do_master m, sale_do_details a, item_info b where m.do_no=a.do_no and  b.item_id=a.item_id  and a.do_no='".$or_no."' order by a.id ";

$do_query = db_query($do_sql);	

		while($do_data=mysqli_fetch_object($do_query))

		{

		
$ins_ch_sql = 'INSERT INTO sale_do_chalan 
 (chalan_no, chalan_date, order_no, do_no, do_date, item_id, dealer_code, crt_price, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt, discount, amt_after_discount, vat_amt, 
 total_amt_with_vat, crt_amt, dist_amt, depot_id, group_for, entry_by, entry_at, status, chalan_type) VALUES
("'.$chalan_no.'", "'.$do_data->do_date.'", "'.$do_data->id.'", "'.$do_data->do_no.'", "'.$do_data->do_date.'", "'.$do_data->item_id.'", "'.$do_data->dealer_code.'", "'.$do_data->crt_price.'", "'.$do_data->unit_price.'", "'.$do_data->pkt_size.'", "'.$do_data->pkt_unit.'", "'.$do_data->dist_unit.'", "'.$do_data->total_unit.'", "'.$do_data->total_amt.'", "'.$do_data->discount.'", "'.$do_data->amt_after_discount.'", "'.$do_data->vat_amt.'", "'.$do_data->total_amt_with_vat.'", "'.$do_data->crt_amt.'", "'.$do_data->dist_amt.'", "'.$do_data->depot_id.'", "'.$do_data->group_for.'",
 "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'", "MANUAL", "Delivery")';

db_query($ins_ch_sql);


		}




		
		
//Company Transport



		 $sql = 'update sale_do_chalan set status="INVOICE" where do_no = '.$or_no;
		db_query($sql);

		$sql2 = 'update sale_do_details set status="INVOICE" where do_no = '.$or_no;
		db_query($sql2);
		
		  $sql3 = 'update sale_do_master set status="INVOICE" where do_no = '.$or_no;
		db_query($sql3);

	//auto_insert_sales_chalan_secoundary($chalan_no)

?>

<?
	}	
?>
<script language="javascript">
window.location.href = "select_dealer_do.php";
</script>
<?



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