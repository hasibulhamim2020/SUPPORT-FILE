<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_datatable('item_table');


$title='Ledger Group';

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

$sub_class= mysqli_real_escape_string($_REQUEST['sub_class']);

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

				echo	$sql="INSERT INTO `ledger_group` (

					`group_id`,

					`group_name` ,

					`group_class` ,
					
					`sub_class` ,

					`group_sub_class` ,

					`group_under` ,

					`group_for` ,

					`proj_id` ,

					`com_id`,

					`manual_group_code`

					)

					VALUES ('$group_id','$group_name', '$group_class', '$sub_class', '$group_sub_class', '$group_under ', '$group_for ', '$proj_id','$com_id','$manual_group_code')";

					//echo $sql;

					$query=db_query($sql);

//					$ledger_id=group_ledger_id($group_id);

//					ledger_create($ledger_id,$group_name,$group_id,'','Both','','', time(),$proj_id);

					$type=1;  
					
					

					$msg='<div class="alert alert-success" role="alert">New Entry Successfully Inserted.</div>';

						

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
		
        `sub_class` = '$sub_class',
		`group_sub_class` = '$group_sub_class',

		`group_for` = '$group_for',

		manual_group_code='$manual_group_code'

		WHERE `group_id` = $group_id LIMIT 1";

	$qry=db_query($sql);

		$type=1;

 echo $msg='<div class="alert alert-success" role="alert">Successfully Updated.</div>';



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

	document.location.href = 'ledger_group.php?group_id='+theUrl;

}

</script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>



	<form id="form2" name="form2" method="post" action="ledger_group_input.php?group_id=<?php echo $group_id;?>">	
	<div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Group  Name:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="group_name" type="text" id="group_name" value="<?php echo $data[1];?>" class="required" />
      </div>
    </div>
  </div>	
  
  
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Class:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<select name="group_class" id="group_class">

<option <? if(substr($data[2],0,1)==substr($asset,0,1)) echo 'Selected ';?>value="<?=$asset?>">Asset</option>

<option <? if(substr($data[2],0,1)==substr($income,0,1)) echo 'Selected ';?>value="<?=$income?>">Income</option>

<option <? if(substr($data[2],0,1)==substr($expense,0,1)) echo 'Selected ';?>value="<?=$expense?>">Expense</option>

<option <? if(substr($data[2],0,1)==substr($liabilities,0,1)) echo 'Selected ';?>value="<?=$liabilities?>">Liabilities</option>

</select>
      </div>
    </div>
  </div>
  
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Sub Class:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0"><?php 
										$gr_id=$_GET['group_id'];
										$group_class=find_a_field('ledger_group','sub_class','group_id='.$gr_id);
										$sub_class_name=find_a_field('sub_class','sub_class_name','id='.$group_class);
										
										?>
										 <select id="sub_class" name="sub_class">
<option value="<?php echo $group_class; ?>"><?php echo $sub_class_name; ?></option>
        <? foreign_relation('sub_class','id','sub_class_name',$sub_class);?>

        </select>
      </div>
    </div>
  </div>
  
  
   <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Concern Group:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
 <select name="group_for" id="group_for">
 <?	$sql="select * from user_group order by id";
    $query=db_query($sql);
     while($datas=mysqli_fetch_object($query))
               {

					?>

 <option <? if($datas->id==$data[9]) echo 'Selected ';?> value="<?=$datas->id?>"><?=$datas->group_name?></option>

                                        <? } ?>

                                        </select>
      </div>
    </div>
  </div>
  
  
  
    <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <? if($data[0]==""){?>
        <input name="ngroup" type="submit" id="ngroup" value="Record" onclick="return checkUserName()" class="btn" />
        <? }?>
        <? if($data[0]!=""){?>
        <input name="mgroup" type="submit" id="mgroup" value="Modify" class="btn" /><? }?>
        <input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='ledger_group.php'"/>
        <? if($_SESSION['user']['level']==10){?><input class="btn" name="dgroup" type="submit" id="dgroup" value="Delete"/><? }?>
        
      </div></div>
  </div>

                                      

                                      

                                      <?php /*?><tr>

                                        <td>Sub Class  :</td>

                                        <td>

                                        <select name="group_sub_class" id="group_sub_class">

                                        <option></option>

                                        <?	$sql="select * from acc_sub_class order by sub_class_name";

											$query=db_query($sql);

											while($datas=mysqli_fetch_object($query))

										{

										?>

 <option <? if($datas->id==$data[10]) echo 'Selected ';?> value="<?=$datas->id?>"><?=$datas->sub_class_name?></option>

                                        <? } ?>

                                        </select></td>

									  </tr><?php */?>

                           

    </form>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>