<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Employee Info';
$page_url='payroll_employee_info.php';
$proj_id=$_SESSION['proj_id'];
$now=time();

if(isset($_REQUEST['emp_name'])||isset($_REQUEST['id']))
{

	//common part.............
	$id=$_REQUEST['id'];
	$emp_id=$_REQUEST['emp_id'];
	$emp_name=mysqli_real_escape_string($_REQUEST['emp_name']);
	$emp_name= str_replace("'","",$emp_name);
	$emp_name= str_replace("&","",$emp_name);
	$emp_name= str_replace('"','',$emp_name);
	$designation=$_REQUEST['designation'];
	$emp_father=$_REQUEST['emp_father'];
	$emp_mother=$_REQUEST['emp_mother'];
	$emp_pre_add=$_REQUEST['emp_pre_add'];
	$emp_per_add=$_REQUEST['emp_per_add'];
	$dept_id =$_REQUEST['ledger_id'];
	$emp_per_add=$_REQUEST['emp_per_add'];
	$emp_pre_add=$_REQUEST['emp_pre_add'];
	$employee_type=$_REQUEST['employee_type'];
	$job_status=$_REQUEST['job_status'];
	$joining_date=$_REQUEST['joining_date'];
	$contact_no=$_REQUEST['contact_no'];
	$email_address=$_REQUEST['email_address'];
	$date_of_birth=$_REQUEST['date_of_birth'];
	$national_id=$_REQUEST['national_id'];
	$name=$emp_name.'-'.$emp_id;
	$now			= time();
 
 if($_FILES['pic']['size']>0)
{
//echo 'ttt';
$pic='../emp_pic/'.$emp_id.'.jpg';
move_uploaded_file($_FILES['pic']['tmp_name'],$pic);
}

	if(isset($_POST['nledger']))
	{
		$check="select emp_id from employee_info where emp_id='$emp_id'";
		//echo $check;
		$sql=db_query($check);
		$num_count=mysqli_num_rows($sql);
		if($num_count!=0)
		{
			$type=0;
			$msg='Given Employee Id ('.$emp_id.') is already exists.';
		}
		else
		{	
			$sql="INSERT INTO `employee_info` 
			(`id`,`emp_id`, `emp_name`, `designation`, `emp_father`, `emp_mother`, `emp_pre_add`, `emp_per_add`, `employee_type`, `joining_date`, `contact_no`, `email_address`, `date_of_birth`, `national_id`,`pic`,`dept_id`) 
			VALUES 
			('$id','$emp_id', '$emp_name', '$designation', '$emp_father', '$emp_mother', '$emp_pre_add', '$emp_per_add', '$employee_type', '$joining_date', '$contact_no', '$email_address', '$date_of_birth', '$national_id','$pic','$dept_id')";
			$query=db_query($sql);

		
		//echo $sql;
		$type=1;
		$msg='New Entry Successfully Inserted.';
		
		}
	}

//for Modify..................................

	if(isset($_POST['mledger']))
	{
$search_sql="select 1 from employee_info where emp_id='$emp_id' and id!='$id'";
$serch_count=mysqli_num_rows(db_query($search_sql));
if($serch_count==0)
{

		$sql="UPDATE `employee_info` SET 
 `emp_id` = '$emp_id',
 `emp_name` = '$emp_name',
 `designation` = '$designation',
 `emp_father` = '$emp_father',
 `emp_mother` = '$emp_mother',
 `emp_pre_add` = '$emp_pre_add',
 `emp_per_add` = '$emp_per_add',
 `dept_id` = '$dept_id',
 `sub_ledger_id` = '$sub_ledger_id',
 `employee_type` = '$employee_type',
 `joining_date` = '$joining_date',
 `contact_no` = '$contact_no',
 `email_address` = '$email_address',
 `date_of_birth` = '$date_of_birth',
 `national_id` = '$national_id',
 `pic` = '$pic' WHERE `id` = '$id'";
		$query=db_query($sql);
		$type=1;
		$msg='Successfully Updated.';

		//echo $sql;
	}
			else
	{
	$type=0;
	$msg='Given Employee ID ('.$emp_id.') is already exists.';
	}
	}

	if(isset($_POST['dledger']))
{

$sql="delete from `employee_info` where `id`='$id' limit 1";
$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}

	$ddd="select * from employee_info where id='$id'";
	$data=mysqli_fetch_row(db_query($ddd));
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    <td width="66%" style="padding-right:5%">
	<div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="40%" align="right">
		    Employee ID:</td>
                                        <td width="60%" align="right"><input name="src_emp_id" type="text" id="src_emp_id" value="<?php echo $_REQUEST['src_emp_id']; ?>" /></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Employee Name:</td>
                                        <td align="right"><input name="src_emp_name" type="text" id="src_emp_name" value="<?php echo $_REQUEST['src_emp_name']; ?>" /></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2"><input class="btn" name="search" type="submit" id="search" value="Filter" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
									<table id="grp" class="tabledesign" cellspacing="0">
							  <tr>
								<th>Emp ID</th>
								<th>Designation</th>
								<th>Name</th>
							  </tr>
	<?php 
	$rrr="select emp_id, designation,emp_name, id FROM employee_info ";
	if(isset($_REQUEST['search']))
	{
		$src_emp_name	= mysqli_real_escape_string($_REQUEST['src_emp_name']);
		$src_emp_id	= mysqli_real_escape_string($_REQUEST['src_emp_id']);

		$rrr .= " where emp_name LIKE '%$src_emp_name%'";
		$rrr .= " AND emp_id LIKE '%$src_emp_id%'";
	} 
	$rrr .= " order by emp_id desc";
	$report=db_query($rrr);
	//echo $rrr;
	while($rp=mysqli_fetch_row($report))
	{$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[3];?>','<?php echo $rp[3];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>
								<td><?=$rp[2];?></td>
							  </tr>
<?php }?>
							</table>									</td>
								  </tr>
								</table>

							</div></td>
<td><div class="right">
<form action="<?=$page_url?>?id=<?php echo $data[0];?>" method="post" enctype="multipart/form-data" name="form2" id="form2">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Employee ID: </td>
                                        <td><input name="emp_id" type="text" id="emp_id" value="<?php echo $data[1];?>" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Employee  Name:</td>
                                        <td><input name="emp_name" type="text" id="emp_name" value="<?php echo $data[2];?>" class="required" /></td>
									  </tr>

                                      <tr>
                                        <td>Dept. Name:</td>
                                        <td><input type="text" name="ledger_id" id="ledger_id" value="<?php echo $data[8];?>" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Designation:</td>
                                        <td><input type="text" name="designation" id="designation" value="<?php echo $data[3];?>" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Employee Status:</td>
                                        <td><select name="employee_type" id="employee_type">
		  <option <? if($data[10]=='Full Time') echo 'Selected';?> value="Full Time">Full Time</option>
		  <option <? if($data[10]=='Part Time') echo 'Selected';?> value="Part Time">Part Time</option>
		  <option <? if($data[10]=='Project Wise') echo 'Selected';?> value="Project Wise">Project Wise</option>
		  <option <? if($data[10]=='Others') echo 'Selected';?> value="Others">Others</option>
                                                                                    </select></td>
                                      </tr>
                                      <tr>
                                        <td>Job Status: </td>
                                        <td><select name="job_status" id="job_status">
		  <option <? if($data[17]=='Permanent') echo 'Selected';?> value="Permanent">Permanent</option>
		  <option <? if($data[17]=='Provision') echo 'Selected';?> value="Provision">Provision</option>
		  <option <? if($data[17]=='On Call') echo 'Selected';?> value="On Call">On Call</option>
		  <option <? if($data[17]=='Others') echo 'Selected';?> value="Others">Others</option>
                                          </select>                                        </td>
                                      </tr>
                                      <tr>
                                        <td>Joining Date:</td>
                                        <td><input type="text" name="joining_date" id="joining_date" value="<?php echo $data[11];?>" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Contact No:</td>
                                        <td><input type="text" name="contact_no" id="contact_no" value="<?php echo $data[12];?>" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Email Address:</td>
                                        <td><input type="text" name="email_address" id="email_address" value="<?php echo $data[13];?>" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Present Address:</td>
                                        <td><input type="text" name="emp_pre_add" id="emp_pre_add" value="<?php echo $data[6];?>" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Per. Address:</td>
                                        <td><input type="text" name="emp_per_add" id="emp_per_add" value="<?php echo $data[7];?>" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Date of Birth:</td>
                                        <td><input type="text" name="date_of_birth" id="date_of_birth" value="<?php echo $data[14];?>" class="required" /></td>
                                      </tr>
                                      
                                      <tr>
                                        <td>National ID:</td>
                                        <td><input type="text" name="national_id" id="national_id" value="<?php echo $data[15];?>" class="required" /></td>
                                      </tr>
                                      <tr>
                                        <td>Employee Pic: </td>
                                        <td><input name="pic" type="file" id="pic" /></td>
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
                                      <td><input name="nledger" type="submit" id="nledger" value="Record" class="btn" /></td>
                                      <td><input name="mledger" type="submit" id="mledger" value="Modify" class="btn" /></td>
                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='<?=$page_url?>'"/></td>
                                      <td><? if($_SESSION['user']['level']==5){?><input class="btn" name="dledger" type="submit" id="dledger" value="Delete"/><? }?></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>35
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