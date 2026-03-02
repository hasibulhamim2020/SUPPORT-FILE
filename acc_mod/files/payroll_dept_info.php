<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Department Information';
$page_url='payroll_dept_info.php';
$proj_id=$_SESSION['proj_id'];
$now=time();

if(isset($_REQUEST['dept_name'])||isset($_REQUEST['dept_id']))
{
	//common part.............
	$dept_id		= mysqli_real_escape_string($_REQUEST['dept_id']);
	$dept_name 		= mysqli_real_escape_string($_REQUEST['dept_name']);
	$dept_name		= str_replace("'","",$dept_name);
	$dept_name		= str_replace("&","",$dept_name);
	$dept_name		= str_replace('"','',$dept_name);
	$now			= time();
	$balance_type	= 'Credit';
	//end 
	if(isset($_POST['nledger']))
	{
	$check="select 1 from depertment_info where dept_name='$dept_name' limit 1";
	if(mysqli_num_rows(db_query($check))>0)
	{
	$type=0;
	$msg='Given Name('.$dept_name.') is already exists.';
	}
	else
	{
		$dept="INSERT INTO `depertment_info` (`dept_name`) VALUES ('$dept_name')";
		db_query($dept);
		$type=1;
		$msg='New Entry Successfully Inserted.';
	}
}



//for Modify..................................

if(isset($_POST['mledger']))
{
$search_sql="select 1 from depertment_info where dept_name='$dept_name' limit 1";
if(mysqli_num_rows(db_query($search_sql))==0)
{
$dept="UPDATE `depertment_info` SET 
		`dept_name` = '$dept_name'
	WHERE `dept_id` =".$dept_id;
		if(db_query($dept))
		{
		$type=1;
		$msg='Successfully Updated.';
		}
	}
	else
	{
	$type=0;
	$msg='Given Name('.$dept_name.') is already exists.';
	}
}

//for Delete..................................

if(isset($_POST['dledger']))
{
$dept_id = $_REQUEST['dept_id'];

$dept="delete from `depertment_info` where `dept_id`='$dept_id' limit 1";
$query=db_query($dept);
		$type=1;
		$msg='Successfully Deleted.';
}




$ddd="select * from depertment_info where dept_id='$dept_id'";
$data = mysqli_fetch_row(db_query($ddd));
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>
									<table id="grp" class="tabledesign" cellspacing="0">
							  <tr>
								<th>ID</th>
								<th>Department Name</th>

							  </tr>
<?php
	
$rrr = "select l.dept_id, l.dept_name from depertment_info l order by dept_id"; 

	$report=db_query($rrr);

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>

							  </tr>
	<?php }?>
							</table>									</td>
								  </tr>
		</table>

	</div></td>
    <td><div class="right"><form id="form1" name="form1" method="post" action="<?=$page_url?>?dept_id=<?php echo $dept_id;?>">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Dept.  Name:</td>
                                        <td><input name="dept_name" type="text" id="dept_name" value="<?php echo $data[1];?>" class="required" /></td>
									  </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="nledger" type="submit" id="nledger" value="Record" onclick="return checkUserName()" class="btn" /></td>
                                      <td><input name="mledger" type="submit" id="mledger" value="Modify" class="btn" /></td>
                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='department_info.php'"/></td>
                                      <td><? if($_SESSION['user']['level']==5){?><input class="btn" name="dledger" type="submit" id="dledger" value="Delete"/><? }?></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>