<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Draft Quotation';



$table_master='sale_requisition_master';

$unique_master='do_no';



$table_detail='sale_requisition_details';

$unique_detail='id';



$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_SESSION[$unique_master];

if(isset($_POST['send'])){


	header("location:quotation_create.php?old_do_no=".$_POST['old_do_no']);

}

if(isset($_POST['delete']))

{

		$sql="delete from sale_requisition_master where do_no=".$_POST['old_do_no'];
		
		db_query($sql);
		$sql2="delete from sale_requisition_details where do_no=".$_POST['old_do_no'];
		
		db_query($sql2);

}

if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d h:s:i');

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





$table='sale_requisition_master';

$show='dealer_code';

$id='do_no';

$con='status="MANUAL"';

 $res='select  	a.do_no,concat("Q-000",a.do_no) as Quotation_no, DATE_FORMAT(a.do_date, "%d-%m-%Y") as Qutation_date, a.status,concat(d.dealer_code,"-",d.dealer_name_e) as dealer_name,  a.entry_at,u.fname from sale_requisition_master a,dealer_info d, user_activity_management u where 
  a.dealer_code=d.dealer_code and u.user_id=a.entry_by and a.status in ("MANUAL") group by a.do_no order by a.do_no desc';
  
  $query = db_query($res);
  

?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

}

</script>

<div class="form-container_large">


<div class="tabledesign2">
<table id="grp" cellspacing="0" cellpadding="0" width="100%">

		

		<tr>

		<th >Quo No</th>

		<th >Qutation_date</th>

		<th >Status</th>

		<th >Customer Name</th>



		<th>Entry Info</th>
		<th>Action</th>
		</tr>

<?
 	while($data = mysqli_fetch_object($query)){
	
?>
	<tr>
			<td><?=$data->Quotation_no;?></td>

			<td><?=$data->Qutation_date;?></td>

			<td><?=$data->status;?></td>

			<td><?=$data->dealer_name;?></td>

			<td><?=$data->fname;?><br><?=$data->entry_at;?></td>
			<td>
				


<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
      <input  name="old_do_no" type="hidden" id="old_do_no" value="<?=$data->do_no;?>"/>

      <input name="send" type="submit" value="Complete Quo." style="font-weight:bold; font-size:12px; color:red;" />
	
	<? if(($_SESSION['user']['id']==1) || ($_SESSION['user']['id']==10087) ) { ?>
      <input name="delete" type="submit" value="Delete Quo." style="font-weight:bold;font-size:12px;color:red;" />
<? } ?>
	</form>

			</td>
			
	
	</tr>
<? } ?>

</div>

</div>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>