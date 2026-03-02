<?php session_start();
session_destroy();
ob_start();


require_once "../../../engine/configure/default_values.php";
require_once('../../../engine/configure/db_connect_scb_main.php');

if(isset($_POST['ibssignin']))
{
	$passward = $_POST['pass'];
	$uid  = $_POST['uid'];
	$cid  = $_POST['cid'];

$sql="SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id FROM company_info a,database_info b WHERE a.cid='$cid' and a.id=b.company_id and a.status='ON' limit 1";
//echo $sql;
	$sql=@db_query($sql);
	if($proj=@mysqli_fetch_object($sql))
	{

					session_register("Mhafuz");
					$_SESSION['proj_id']	= $proj->cid;
					$_SESSION['db_name']	= $proj->db_name;
					$_SESSION['db_user']	= $proj->db_user;
					$_SESSION['db_pass']	= $proj->db_pass;
					
		include('../../../engine/configure/db_connect.php');
		
		$user_sql="select * from hms_service_group where  username='$uid' AND password = '$passward'";
				$user_query=db_query($user_sql);
				if(mysqli_num_rows($user_query)>0)
				{
					$info=mysqli_fetch_object($user_query);
					
					$_SESSION['user']['id']		= $info->id;
					$_SESSION['user']['name']	= $info->service_group;
					
					header("Location:home_service.php");
				}
	}
}
//$user_sql="select * from hms_service_group where  username='$uid' AND password = '$pass'";
?>

<div class="login_box">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left"></td>
      <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="3"><img src="../../images/index_green_login_01.jpg" width="346" height="22" /></td>
        </tr>
        <tr>
          <td><img src="../../images/index_green_login_02.jpg" width="33" height="197" /></td>
          <td class="login_box_body"><div class="form">
              <div class="form">
                <form method="post" action="">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Company ID  : </td>
                      <td><input name="cid" type="text" class="input" id="cid" size="15" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
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
                    </table>
                </form>
              </div>
          </div></td>
          <td><img src="../../images/index_green_login_04.jpg" width="29" height="197" /></td>
        </tr>
        <tr>
          <td colspan="3"><img src="../../images/index_green_login_05.jpg" /></td>
        </tr>
      </table></td>
	  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center"><a href="../main/index.php"><img src="../../images/images6.jpg" width="100" height="100" /></a></div></td>
        </tr>
        <tr>
          <td><div align="center"><a href="../main/index_owner.php"><img src="../../images/images5.jpg" width="100" height="100"  /> </a></div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout_index.php");
?>