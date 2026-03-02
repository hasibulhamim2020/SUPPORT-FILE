<?php 
session_start();
ob_start();


require_once "../../engine/configure/check_login.php";

if(isset($_POST['ibssignin']))
{
	$passward 	= $_POST['pass'];
	$uid  		= $_POST['uid'];
	$cid  		= $_POST['cid'];
if(check_for_login($cid,$uid,$passward,0)){
if($_SESSION['user']['level']==5||$_SESSION['user']['level']==6)
header("Location:home.php");}
}else session_destroy();

if(isset($_POST['ibssignin']))
{
$msg="Invalid Login Information!!!";
$type=0;
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
							  <div class="form"><form method="POST" action="">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
                                    <td>Company ID: </td>
								    <td><input name="cid" type="text" class="input" id="cid" size="15" maxlength="25" /></td>
							    </tr>
								  <tr>
								    <td>&nbsp;</td>
								    <td>&nbsp;</td>
							    </tr>
								  <tr>
									<td>Email: </td>
									<td><input name="uid" type="text" class="input" id="uid" size="15" maxlength="25" /></td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>Password:</td>
									<td><input name="pass" type="password" class="input" id="pass" size="15" maxlength="25" /></td>
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
								     <td colspan="2">Forgot password?</td>
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