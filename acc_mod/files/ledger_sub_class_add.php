<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Ledger Sub Class';
$proj_id=$_SESSION['proj_id'];
$active='subclass';
$button="yes";
$unique='sub_class_id';
$$unique = $_GET[$unique];
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

if(isset($_POST['modify']))
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
	document.location.href = 'ledger_sub_class.php?sub_class_id='+theUrl;
}
</script>

							  <table class="table table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="40%">Sub Class  Name :</td>
                                        <td width="60%" ><input name="sub_class_name" type="text" style="max-width:250px;" id="sub_class_name" value="<?php echo $data[1];?>" class="required" /></td>
									  </tr>
                                      <tr>
                                        <td>Sub Class Type:</td>
                                        <td>
                                        <select class="form-control" style="max-width:250px;" name="sub_class_type_id" id="sub_class_type_id">
                                        <option></option>
                                        <?	$sql="select * from acc_sub_class_type order by class_id,priority";
											$query=db_query($sql);
											while($datas=mysqli_fetch_object($query)){
										?>
 <option <? if($datas->id==$data[2]) echo 'selected';?> value="<?=$datas->id?>"><?=$datas->sub_class_type?></option>
                                        <? } ?>
                                        </select></td>
									  </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>12
<script type="text/javascript">
	document.onkeypress=function(e){
	var e=window.event || e
	var keyunicode=e.charCode || e.keyCode
	if (keyunicode==13)
	{
		return false;
	}
}
</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>