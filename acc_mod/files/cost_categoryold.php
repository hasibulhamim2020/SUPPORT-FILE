<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Cost Category';
$proj_id=$_SESSION['proj_id'];
$now=time();
$page="cost_category_add.php";

$cat_id=$_REQUEST['cat_id'];
//echo $proj_id;
if(isset($_REQUEST['category_name']) && !empty($_REQUEST['category_name']))
{
	//common part.............
	$category_name = $_REQUEST['category_name'];
		$check="select id from cost_category where category_name='$category_name'";
		//echo $check;
		if(mysqli_num_rows(db_query($check))>0)
		{
			$aaa=mysqli_num_rows(db_query($check));
				$type=0;
				$msg='Given Name('.$category_name.') is already exists.';
		}
		else
		{
	if(isset($_POST['ncategory']))
	{
		$check="select id from cost_category where category_name='$category_name'";
		//echo $check;
		if(mysqli_num_rows(db_query($check))>0)
		{
			$aaa=mysqli_num_rows(db_query($check));
			$cat_id=$aaa[0];
		}
		else
		{
			$sql="INSERT INTO `cost_category` (
			`category_name`, `proj_id`)
			VALUES ('$category_name', '$proj_id')";
			//echo $sql;
			$query=db_query($sql);
		$type=1;
		$msg='New Entry Successfully Inserted.';
		}
	}
	
	//for Modify..................................
	
	if(isset($_POST['mcategory']))
	{ if(isset($_GET['cat_id'])){
		$sql="UPDATE `cost_category` SET `category_name` = '$category_name'
		 WHERE `id` = '$cat_id' LIMIT 1";
		$qry=db_query($sql);
				$type=1;
		$msg='Successfully Updated.';}

	}
	}
		if(isset($_POST['dcategory']))
	{
		$sql="delete from cost_category
		 WHERE `id` = '$cat_id' LIMIT 1";
		$qry=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
	}
}
$report=db_query("select id, category_name from cost_category");
if(isset($_REQUEST['cat_id']))
{
	$c_id=$_REQUEST['cat_id'];
	$ddd="select * from cost_category where id='$c_id'";
	$data=mysqli_fetch_row(db_query($ddd));
	//echo $ddd;
}?>
<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'cost_category_add.php?cat_id='+theUrl;
}
</script>

									<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
									<thead>
							  <tr>
								<th>ID</th>
								<th>Category Name</th>
								</tr>
								</thead>
								<tbody>
<?php
	
	$rrr = "select id,category_name from cost_category"; 

	$report=db_query($rrr);

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>
								</tr>
	<?php }?>
						</tbody>	</table>
								


<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout2.php");
?>