<?php
session_start();
session_destroy();
ob_start();

include('../../engine/configure/db_connect_scb_main.php');
if(isset($_POST['ibssignin1']))
{
	//echo "testing.....";
	$pass = $_POST['pass'];
	$uid  = $_POST['uid'];
	$sql="SELECT proj_name, proj_id,db_name,db_user,db_pass,user_group,user_id FROM scb_login WHERE user_name='$uid' and pass='$pass'";
	//echo $sql;
	$sql1=db_query($sql);
	if($data=mysqli_fetch_row($sql1))
	{
		session_register("project");
		$_SESSION['proj_id']	= $data[1];
		$_SESSION['proj_name']	= $data[0];
		$_SESSION['db_name']	= $data[2];
		$_SESSION['db_user']	= $data[3];
		$_SESSION['db_pass']	= $data[4];
		$_SESSION['user_group']	= $data[5];
		$_SESSION['user_id']	= $data[6];

		header("location:index1.php");
		//$_SESSION['com_id']=$data[2];
		$_SESSION['com_id']="500001";
		//$_SESSION['company_name']=$data[3];
		$_SESSION['company_name']="Copyright © 2008-2009 www.CloudCodz.com";
		//$_SESSION['voucher_mode']=$data[4];
		//$_SESSION['db_name']=$data[5];
	}
		else
	{
		echo"<script>alert('Account Is Disabled\\nPlease Contract With System Administrator');location.href=\"index.php\";</script>"; 
		header("location:index.php");
	}

}
		else
	{
		echo"<script>alert('Account Is Disabled\\nPlease Contract With System Administrator');location.href=\"index.php\";</script>"; 
		header("location:index.php");
	}
?>
<div class="login_box">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><img src="../images/login_box_01.jpg" width="7" height="9" /></td>
                            <td><img src="../images/login_box_02.jpg" width="332" height="9" /></td>
                            <td><img src="../images/login_box_03.jpg" width="13" height="9" /></td>
                          </tr>
                          <tr>
                            <td><img src="../images/login_box_04.jpg" width="7" height="240" /></td>
                            <td class="login_box_body">
							  <div class="form"><form method="POST" action="#">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>User name : </td>
									<td><input name="uid" type="text" class="input" id="uid" size="15" /></td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>Password:</td>
									<td><input name="pass" type="password" class="input" id="pass" size="15" /></td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td><input name="ibssignin"  type="submit" class="btn" id="ibssignin" value="Login" /></td>
								  </tr>
								   <tr>
								     <td>&nbsp;</td>
								     <td>&nbsp;</td>
						        </tr>
								   <tr>
								     <td colspan="2">Forgot passwod? Change password.</td>
						        </tr>
								   <tr>
								     <td>&nbsp;</td>
								     <td>&nbsp;</td>
						        </tr>
								   <tr>
									<td colspan="2">New User? Register now</td>
								   </tr>
								</table>
								</form></div>							</td>
                            <td><img src="../images/login_box_06.jpg" width="13" height="240" /></td>
                          </tr>
                          <tr>
                            <td><img src="../images/login_box_07.jpg" width="7" height="17" /></td>
                            <td><img src="../images/login_box_08.jpg" width="332" height="17" /></td>
                            <td><img src="../images/login_box_09.jpg" width="13" height="17" /></td>
                          </tr>
                        </table>
                      </div>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>