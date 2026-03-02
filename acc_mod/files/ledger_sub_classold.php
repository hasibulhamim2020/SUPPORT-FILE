<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Ledger Sub Class';
$proj_id=$_SESSION['proj_id'];
$page="ledger_sub_class_add.php";
$active='subclass';
//echo $proj_id;
//var_dump($_SESSION);
if(isset($_REQUEST['sub_class_name'])||isset($_REQUEST['sub_class_id']))
{
//common part.............
$sub_class_name			= mysqli_real_escape_string($_REQUEST['sub_class_name']);
$sub_class_type_id		= mysqli_real_escape_string($_REQUEST['sub_class_type_id']);
$sub_class_id			= mysqli_real_escape_string($_REQUEST['sub_class_id']);
//end 
if(isset($_POST['ngroup']) && !empty($sub_class_name))
{
					$sql="INSERT INTO `acc_sub_class` (
					`sub_class_name`,
					`sub_class_type_id` ,
					`status`
					)
					VALUES ('$sub_class_name','$sub_class_type_id', '1')";

					$query=db_query($sql);
					$type=1;
					$msg='New Entry Successfully Inserted.';
}


//for Modify..................................

if(isset($_POST['mgroup']))
{
	$sql="UPDATE `acc_sub_class` SET 
		`sub_class_name` = '$sub_class_name',
		`sub_class_type_id` ='$sub_class_type_id'
		WHERE `id` = $sub_class_id LIMIT 1";
	$qry=db_query($sql);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['dgroup']))
{

	$sql="UPDATE `acc_sub_class` SET 
		`status` = '0'
		WHERE `id` = $sub_class_id LIMIT 1";
		$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}



		$ddd="select * from acc_sub_class where id='$sub_class_id' and 1";
		$dddd=db_query($ddd);
		if(mysqli_num_rows($dddd)>0)
		$data = mysqli_fetch_row($dddd);
}
?>
<script type="text/javascript">

function checkUserName()
{	
	var e = document.getElementById('group_name');
	if(e.value=='')
	{
		alert("Invalid Group Name!!!");
		e.focus();
		return false;
	}
	else
	{
		$.ajax({
		  url: 'common/check_entry.php',
		  data: "query_item="+$('#group_name').val()+"&pageid=ledger_group",
		  success: function(data) 
		  	{			
			  if(data=='')
			  	return true;
			  else	
			  	{
				alert(data);
				e.value='';
				e.focus();
				return false;
				}
			}
		});
	}
}
function DoNav(theUrl)
{
	document.location.href = 'ledger_sub_class_add.php?sub_class_id='+theUrl;
}
</script>

  
							
									<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
									<thead>
							  <tr>
								<th>ID</th>
								<th>Sub Class</th>
								<th>Type</th>
								<th>Class</th>
							  </tr>
							  </thead>
							  <tbody>
<?php
	$rrr = "SELECT a.id, a.sub_class_name, b.sub_class_type, c.class_name FROM `acc_sub_class` a,acc_sub_class_type b,acc_class c WHERE c.id=b.class_id and b.id=a.sub_class_type_id ";
	$report = db_query($rrr);
	$i=0;
	
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>
								<td><?=$rp[2];?></td>
								<td><?=$rp[3];?></td>
							  </tr>
	<?php }?>
							</tbody>
							</table>
															
								 

	
   

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout2.php");
?>