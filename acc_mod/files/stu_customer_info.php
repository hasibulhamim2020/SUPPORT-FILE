<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Student Information';
$proj_id=$_SESSION['proj_id'];

//echo $proj_id;

$customer_id		= $_REQUEST['customer_id'];
$customer_name		= $_REQUEST['customer_name'];

$customer_name		= str_replace("'","",$customer_name);
$customer_name		= str_replace("&","",$customer_name);
$customer_name		= str_replace('"','',$customer_name);

$customer_company	= $_REQUEST['customer_company'];
$address			= $_REQUEST['address'];
$ledger_group		= $_REQUEST['under_ledger'];
$contact			= $_REQUEST['contact'];
$customer_type		= $_REQUEST['customer_type'];

$reg_no				= $_REQUEST['reg_no'];
$roll_no			= $_REQUEST['roll_no'];
$father_name		= $_REQUEST['father_name'];
$mother_name		= $_REQUEST['mother_name'];
$dob				= $_REQUEST['dob'];
$blood_group		= $_REQUEST['blood_group'];
$district			= $_REQUEST['district'];
$thana				= $_REQUEST['thana'];
$phone				= $_REQUEST['phone'];
$mobile				= $_REQUEST['mobile'];
$email				= $_REQUEST['email'];
$last_qua			= $_REQUEST['last_qua'];
$last_qua_ins		= $_REQUEST['last_qua_ins'];
$last_qua_board		= $_REQUEST['last_qua_board'];
$last_qua_gpa		= $_REQUEST['last_qua_gpa'];
$last_qua_year		= $_REQUEST['last_qua_year'];
$now				= time();

//end 

if(isset($_POST['ncustomer']))
	{
	$check="select ledger_id from accounts_ledger where ledger_name='$customer_name' limit 1";
	//echo $check;
	if(mysqli_num_rows(db_query($check))>0)
	{
		$aaa=mysqli_num_rows(db_query($check));
		$customer_id=$aaa[0];
		$type=0;
		$msg='Given Name('.$customer_name.') is already exists.';
	}
	else
	{
	$ledger=under_ledger_id($ledger_group);		
	if(($id%1000)==0)
	ledger_create($ledger,$customer_name,$ledger_group,'0.00','Both',$depreciation_rate,'', $now,$proj_id,'NO');
	else
	{
	ledger_create($ledger,$customer_name,$ledger_group,'0.00','Both',$depreciation_rate,'', $now,$proj_id,'NO');
	sub_ledger_create($ledger,$customer_name, $ledger_group, '0.00', $now, $proj_id);
	}
 if($_FILES['pic']['size']>0)
{
//echo 'ttt';
$pic='../emp_pic/'.$customer_id.'.jpg';
move_uploaded_file($_FILES['pic']['tmp_name'],$pic);
}
	$sql="INSERT INTO 
`stu_student_info` 
( `customer_name`, `customer_company`, 
`address`, `proj_id`, `contact_no`, `customer_type`, 
`reg_no`, `roll_no`, `father_name`, `mother_name`, 
`dob`, `blood_group`, `district`, `thana`, `phone`, 
`mobile`, `email`, `last_qua`, `last_qua_ins`, 
`last_qua_board`, `last_qua_gpa`, `last_qua_year`,`pic`)
 VALUES 
( '$customer_name', '$customer_company', 
'$address', '$proj_id', '$contact_no', '$customer_type', 
'$reg_no', '$roll_no', '$father_name', '$mother_name', 
'$dob', '$blood_group', '$district', '$thana', '$phone', 
'$mobile', '$email', '$last_qua', '$last_qua_ins', 
'$last_qua_board', '$last_qua_gpa', '$last_qua_year','$pic')";
	
	
			$query=db_query($sql);
			$type=1;
			$msg='New Entry Successfully Inserted.';
	
	}
}





//for Modify..................................



if(isset($_POST['mcustomer']))

{

$search_sql="select 1 from accounts_ledger where `ledger_id`!='$customer_id' and `ledger_name` = '$customer_name' limit 1";

if(mysqli_num_rows(db_query($search_sql))==0)

{

$sql="UPDATE `stu_student_info` SET 
`customer_name` = '$customer_name',
`customer_company` = '$customer_company',
`address` = '$address',
`contact_no` = '$contact',
reg_no= '$reg_no',
roll_no= '$roll_no',
father_name= '$father_name',
mother_name= '$mother_name',
dob= '$dob',
blood_group= '$blood_group',
district= '$district',
thana= '$thana',
phone= '$phone',
mobile= '$mobile',
email= '$email',
last_qua= '$last_qua',
last_qua_ins= '$last_qua_ins',
last_qua_board= '$last_qua_board',
last_qua_gpa= '$last_qua_gpa',
last_qua_year= '$last_qua_year',
`customer_type` = '$customer_type'
 WHERE `customer_id` = $customer_id LIMIT 1";

$qry=db_query($sql);

$sql="UPDATE `accounts_ledger` SET 
		`ledger_name` 		= '$customer_name'
		WHERE `ledger_id` 		='$customer_id' LIMIT 1";

	$qry=db_query($sql);
	$type=1;
	$msg='Successfully Updated.';
}
	else
	{
	$type=0;
	$msg='Given Name('.$customer_name.') is already exists.';
	}
}

if(isset($_POST['dcustomer']))
{
$sql="delete from `customer` where `customer_id`='$customer_id' limit 1";
$query=db_query($sql);
$sql="delete from `accounts_ledger` where `ledger_id`='$customer_id' limit 1";
$query=db_query($sql);

		$type=1;
		$msg='Successfully Deleted.';

}

if(isset($_REQUEST['customer_id']))
{
$ddd="select * from stu_student_info where customer_id='$customer_id' and 1";
$data=mysqli_fetch_row(db_query($ddd));
}


?>
<script type="text/javascript">
$(document).ready(function(){
$("#form2").validate();	
});	
function Do_Nav()
{
	var URL = 'pop_ledger_selecting_list.php';
	popUp(URL);
}
function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
function DoNav(theUrl)

{

	document.location.href = 'stu_customer_info.php?customer_id='+theUrl;

}



</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>    <td width="66%" style="padding-right:5%">
	<div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box"><form id="form2" name="form2" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="40%" align="right">

		    Student Name:                                       </td>

                                        <td width="60%" align="right"><input type="text" name="cus_name" id="cus_name" value="<?php echo $_REQUEST['cus_name']; ?>" /></td>

                                      </tr>

                                      <tr>

                                        <td align="right">Student ID:                                         </td>

                                        <td align="right"><input name="cus_company" type="text" id="cus_company" value="<?php echo $_REQUEST['cus_company']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td colspan="2"><input class="btn" name="search" type="submit" id="search" value="Show" /></td>

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

								<th>Student Name</th>

								<th>Student ID </th>

								<th>Dept.</th>

							  </tr>

	<?php
	$rrr = "select customer_id, customer_name, customer_company, customer_type from stu_student_info where 1"; 
	if(isset($_REQUEST['search']))
	{
		$cus_name	= mysqli_real_escape_string($_REQUEST['cus_name']);
		$cus_company	= mysqli_real_escape_string($_REQUEST['cus_company']);
		$cus_type	= mysqli_real_escape_string($_REQUEST['cus_type']);

		$rrr .= " AND customer_name LIKE '%$cus_name%'";
		$rrr .= " AND customer_company LIKE '%$cus_company%'";
		$rrr .= " AND customer_type LIKE '%$cus_type%'";
	} 
	$rrr .= " order by customer_name";

	//print($rrr );

	$report=db_query($rrr);

	 while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[1];?></td>
								<td><?=$rp[2];?></td>
								<td><?=$rp[3];?></td>
							  </tr>

	<?php }?>

							</table></td>

								  </tr>

								</table>



							</div></td>

    <td><div class="right">  <form action="stu_customer_info.php?customer_id=<?php echo $customer_id;?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr>

                                  <td><div class="box">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      <tr>

                                        <td>Student  Name:</td>

                                        <td><input name="customer_name" type="text" id="customer_name" value="<?php echo $data[1];?>" size="30" maxlength="100" class="required" minlength="4" /></td>
									  </tr>



                                      <tr>

                                        <td>Student ID:</td>

                                        <td><input name="customer_company" type="text" id="customer_company" value="<?php echo $data[2];?>" size="30" maxlength="100" class="required" /></td>
									  </tr>

                                      <tr>
                                        <td>Under Ledger:</td>
                                        <td><input type="button" name="Button" value="Go" class="go" onclick="Do_Nav()" />
                                            <input style="width:155px" name="under_ledger" type="text" id="under_ledger" />
                                            <input name="hiddenField" type="hidden" value="<?=$ledger_group_id?>" /></td>
                                      </tr>
                                      <tr>
                                        <td>Dept:</td>
                                        <td><select name="customer_type">
                                            <option <?php echo $sel=($data[6]=='A')?'Selected':'';?> value="A">A</option>
                                            <option <?php echo $sel=($data[6]=='B')?'Selected':'';?> value="B">B</option>
                                            <option <?php echo $sel=($data[6]=='C')?'Selected':'';?> value="C">C</option>
                                            <option <?php echo $sel=($data[6]=='D')?'Selected':'';?> value="D">D</option>
                                            <option <?php echo $sel=($data[6]=='E')?'Selected':'';?> value="E">E</option>
                                          </select>                                        </td>
                                      </tr>
                                      <tr>
                                        <td>Reg No:</td>
                                        <td><input name="reg_no" type="text" id="reg_no" size="15" maxlength="15" value="<?php echo $data[7];?>" /></td>
                                      </tr>
                                      <tr>
                  <td>Roll No: </td>
                  <td><input name="roll_no" type="text" id="roll_no" size="15" maxlength="15" value="<?php echo $data[8];?>" /></td>
                                      </tr>
                                      <tr>

                                        <td>Address:</td>

                                        <td><textarea name="address" cols="30" id="address"><?php echo $data[3];?></textarea></td>
                                      </tr>

                                      <tr>
                                        <td>Father Name:</td>
                                        <td><input name="father_name" type="text" id="father_name" size="15" maxlength="15" value="<?php echo $data[9];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Mother Name: </td>
                                        <td><input name="mother_name" type="text" id="mother_name" size="15" maxlength="15" value="<?php echo $data[10];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>DOB:</td>
                                        <td><input name="dob" type="text" id="dob" size="15" maxlength="15" value="<?php echo $data[11];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Blood Group: </td>
                                        <td><input name="blood_group" type="text" id="blood_group" size="15" maxlength="15" value="<?php echo $data[12];?>"></td>
                                      </tr>
                                      <tr>

                                        <td>District:</td>

                                        <td><input name="district" type="text" id="district" size="15" maxlength="15" value="<?php echo $data[13];?>"  /></td>
                                      </tr>

                                      <tr>
                                        <td>Thana:</td>
                                        <td><input name="thana" type="text" id="thana" size="15" maxlength="15" value="<?php echo $data[14];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Phone:</td>
                                        <td><input name="phone" type="text" id="phone" size="15" maxlength="15" value="<?php echo $data[15];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Mobile:</td>
                                        <td><input name="mobile" type="text" id="mobile" size="15" maxlength="15" value="<?php echo $data[16];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Email:</td>
                                        <td><input name="email" type="text" id="email" size="15" maxlength="15" value="<?php echo $data[17];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Last Qua.:</td>
                                        <td><input name="last_qua" type="text" id="last_qua" size="15" maxlength="15" value="<?php echo $data[18];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Qua. Ins:</td>
                                        <td><input name="last_qua_ins" type="text" id="last_qua_ins" size="15" maxlength="15" value="<?php echo $data[19];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Qua. Board:</td>
                                        <td><input name="last_qua_board" type="text" id="last_qua_board" size="15" maxlength="15" value="<?php echo $data[20];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Qua. GPA:</td>
                                        <td><input name="last_qua_gpa" type="text" id="last_qua_gpa" size="15" maxlength="15" value="<?php echo $data[21];?>"></td>
                                      </tr>
                                      <tr>
                                        <td>Qua. Year:</td>
                                        <td><input name="last_qua_year" type="text" id="last_qua_year" size="15" maxlength="15" value="<?php echo $data[22];?>" /></td>
                                      </tr>
                                      <tr>
                                        <td>Student Pic: </td>
                                        <td><input type="file" name="file" /></td>
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

                                      <td><input name="ncustomer" type="submit" id="ncustomer" value="Record" class="btn"/></td>

                                      <td><input name="mcustomer" type="submit" id="mcustomer" value="Modify" class="btn"/></td>

                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='stu_customer_info.php'"/></td>

                                      <td><input class="btn" name="dcustomer" type="submit" id="dcustomer" value="Delete"/></td>

                                    </tr>

                                  </table>

								  </div>								  </td>

                                </tr>

                              </table>

    </form>

							</div></td>

  </tr>

</table>9

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>