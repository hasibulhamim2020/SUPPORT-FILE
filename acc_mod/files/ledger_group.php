<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_datatable('item_table');


$title='Ledger Group';
$input_page="ledger_group_input.php"; $add_button_bar = 'Mhafuz';
$proj_id=$_SESSION['proj_id'];

//echo $proj_id;

//var_dump($_SESSION);

if(isset($_REQUEST['group_name'])||isset($_REQUEST['group_id']))

{

//common part.............

$group_id		= mysqli_real_escape_string($_REQUEST['group_id']);

$group_name		= mysqli_real_escape_string(trim($_REQUEST['group_name']));

$group_name		= str_replace("'","",$group_name);

$group_name		= str_replace("&","",$group_name);

$group_name		= str_replace('"','',$group_name);

$group_class	= mysqli_real_escape_string($_REQUEST['group_class']);

$group_sub_class= mysqli_real_escape_string($_REQUEST['group_sub_class']);

$group_for	= mysqli_real_escape_string($_REQUEST['group_for']);

$manual_group_code	= mysqli_real_escape_string($_REQUEST['manual_group_code']);

$group_under	= mysqli_real_escape_string($_REQUEST['group_under']);

//end 

if(isset($_POST['ngroup']) && !empty($group_name))

{

	if(!group_redundancy($group_name,$manual_group_code))

	{

	$type=0;

	$msg='Given Group Name or Manual Group Code is already exists.';

	}

	else

	{	

			if(!ledger_redundancy($group_name))

				{

					$type=0;

					$msg='Given Name('.$group_name.') is already exists as Ledger.';

				}

			else

			{

					$group_id=next_group_id($group_class);

					$sql="INSERT INTO `ledger_group` (

					`group_id`,

					`group_name` ,

					`group_class` ,

					`group_sub_class` ,

					`group_under` ,

					`group_for` ,

					`proj_id` ,

					`com_id`,

					`manual_group_code`

					)

					VALUES ('$group_id','$group_name', '$group_class', '$group_sub_class', '$group_under ', '$group_for ', '$proj_id','$com_id','$manual_group_code')";

					//echo $sql;

					$query=db_query($sql);

//					$ledger_id=group_ledger_id($group_id);

//					ledger_create($ledger_id,$group_name,$group_id,'','Both','','', time(),$proj_id);

					$type=1;

					$msg='New Entry Successfully Inserted.';

						

			}

	}

}





//for Modify..................................



if(isset($_POST['mgroup']))

{



if(group_redundancy($group_name,$manual_group_code,$group_id))

{	

	$sql="UPDATE `ledger_group` SET 

		`group_name` = '$group_name',

		`group_sub_class` = '$group_sub_class',

		`group_for` = '$group_for',

		manual_group_code='$manual_group_code'

		WHERE `group_id` = $group_id LIMIT 1";

	$qry=db_query($sql);

		$type=1;

		$msg='Successfully Updated.';



	}

	else

	{

		$type=0;

		$msg='Given Group Name or Manual Group Code is already exists.';

	}

}

//for Delete..................................



if(isset($_POST['dgroup']))

{



		$sql="delete from `ledger_group` where `group_id`='$group_id' limit 1";

		$query=db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

}







		$ddd="select * from ledger_group where group_id='$group_id' and 1";

		$dddd=db_query($ddd);

		if(mysqli_num_rows($dddd)>0)

		$data = mysqli_fetch_row($dddd);

}

$sql='select * from config_group_class limit 1';

$query=db_query($sql);

if(mysqli_num_rows($query)>0)

{ 

$g_class=mysqli_fetch_object($query);

$asset=$g_class->asset_class;

$income=$g_class->income_class;

$expense=$g_class->expanse_class;

$liabilities=$g_class->liabilities_class;

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

	document.location.href = 'ledger_group_input.php?group_id='+theUrl;

}

</script>





							<table width="100%" border="0" cellspacing="0" cellpadding="0">

							

								  <tr>

									<td>&nbsp;</td>

								  </tr>

								  <tr>

									<td>

									<table id="item_table" class="table table-bordered" style="width:100%">
									<thead>

							  <tr>

								<th><span class="style1">ID</span></th>

								<th><span class="style1">Group Name</span></th>

								<th><span class="style1">Class</span></th>
							  </tr>
							  </thead>
							  <tbody>

<?php

//$rrr = "select group_id, group_name, group_class from ledger_group where 1";

	//if($_SESSION['user']['group']>1)

 $rrr = "select group_id, group_name, group_class from ledger_group where group_for= ".$_SESSION['user']['group'];





	if(isset($_REQUEST['search']))

	{

		$ladger_group	= mysqli_real_escape_string($_REQUEST['ladger_group']);

		$group_class	= mysqli_real_escape_string($_REQUEST['group_class']);

	

		$rrr .= " and group_name LIKE '%$ladger_group%'";

		$rrr .= " AND group_class LIKE '%$group_class%'";	

	} 

	$rrr .= " order by group_id";

	$report = db_query($rrr);

	$i=0;

	

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

								<td><?=$rp[0];?></td>

								<td><?=$rp[1];?></td>

								<td><? if($rp[2]==1000){ echo 'Asset'; }elseif($rp[2]==2000){ echo 'Liabilities'; } elseif($rp[2]==3000){ echo 'Income'; } else { echo 'Expense' ;} ?></td>
							  </tr>

	<?php }?>
						</tbody>	</table>

									</td>

								  </tr>

								</table>






<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>