<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Cost Center';
$center_id=$_REQUEST['center_id'];
$proj_id=$_SESSION['proj_id'];
$page="cost_center_add.php";
//echo $proj_id;
if(isset($_REQUEST['cost_center']) && !empty($_REQUEST['cost_center']))
{
	//common part.............
	$cost_center 	= mysqli_real_escape_string($_REQUEST['cost_center']);
	$category_id 	= mysqli_real_escape_string($_REQUEST['category_id']);

	if(isset($_POST['ncenter']))
	{
		$check="select id from cost_center where center_name='$cost_center'";
		//echo $check;
		if(mysqli_num_rows(db_query($check))>0)
		{
				$type=0;
				$msg='Given Name('.$cost_center.') is already exists.';
		}
		else
		{
			$sql="INSERT INTO `cost_center` (
			`center_name`, `category_id`, `proj_id`)
			VALUES ('$cost_center', '$category_id', '$proj_id')";
			$query=db_query($sql);
		$type=1;
		$msg='New Entry Successfully Inserted.';
		}
	}
	
	//for Modify..................................
	
	if(isset($_POST['mcenter']))
	{
		$sql="UPDATE `cost_center` SET `center_name` = '$cost_center', category_id = '$category_id'
		 WHERE `id` = '$center_id' LIMIT 1";
		$qry=db_query($sql);
				$type=1;
		$msg='Successfully Updated.';
	}
		if(isset($_POST['dcenter']))
	{
		$sql="delete from cost_center
		 WHERE `id` = '$center_id' LIMIT 1";
		$qry=db_query($sql);
				$type=1;
		$msg='Successfully Deleted.';
	}
}
if(isset($_REQUEST['center_id']))
{
	$c_id=$_REQUEST['center_id'];
	$ddd="SELECT cen.id, cen.center_name, cat.category_name FROM cost_center cen, cost_category cat WHERE cen.category_id = cat.id AND cen.id='$c_id'";
	$data=mysqli_fetch_row(db_query($ddd));
	//echo $ddd;
}?>
<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'cost_center_add.php?center_id='+theUrl;
}
</script>

							
								<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
								<thead>
							  <tr>
								<th>ID</th>
								<th>Cost Center</th>
								<th>Category</th>
							  </tr>
							  </thead>
							  <tbody>
<?php
	$rrr = "SELECT 
					  cen.id,
					  cen.center_name,
					  cat.category_name
					FROM
					  cost_center cen,
					  cost_category cat
					WHERE
					  cen.category_id = cat.id";
	

	$report = db_query($rrr);
	$i=0;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>
								<td><?=$rp[2];?></td>
							  </tr>
	<?php }?>
							</tbody>
								</table>

	

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout2.php");
?>