<?php



session_start();



ob_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Select Dealer for Demand Order';



$now = date('Y-m-d H:s:i');



$table_master='sale_do_master';



$unique_master='do_no';







$table_detail='sale_do_details';



$unique_detail='id';







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
		
		// $sql = "delete from journal_item where tr_from = 'Cash Sale' and sr_no = '".$$unique_master."'";

		//db_query($sql);



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

$request_by=$_SESSION['user']['id'];
$request_at=date('Y-m-d H:s:i');


//$prevent_multi=find_a_field('sale_do_chalan','chalan_no','do_no='.$or_no);

//if ($prevent_multi<1) {
		
		//$master = find_all_field_sql("select * from sale_do_master m, dealer_info d where d.dealer_code = m.dealer_code and m.do_no = '".$or_no."'");
		

		  $sql3 = 'update sale_do_details set edit_request=1, `request_by` = "'.$request_by.'", `request_at` = "'.$request_at.'" where do_no = '.$or_no;
		db_query($sql3);


?>

<?
//	}	
?>
<script language="javascript">
window.location.href = "select_do_for_edit_request.php";
</script>
<?



}

















//auto_complete_from_db('dealer_info','concat(dealer_name_e)','dealer_code','dealer_type="Distributor" or dealer_type="Personal"  and canceled="Yes"','dealers');



?>



<script language="javascript">



window.onload = function() {document.getElementById("dealer").focus();}



</script>



<div class="form-container_large">



<form action="do.php" method="post" name="codz" id="codz">



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



    <td align="right" bgcolor="#FF9966"><strong>Active Dealer List: </strong></td>



    <td bgcolor="#FF9966"><strong>



<select id="dealer" name="dealer" required style="width:245px;height:26px;" >
<option></option>
            <? foreign_relation('dealer_info','dealer_code','dealer_name_e',dealer,' dealer_type="Regular" order by dealer_name_e');?>
          </select>

    </strong></td>



    <td bgcolor="#FF9966"><strong>



      <input type="submit" name="submitit" id="submitit" value="Create DO" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>



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