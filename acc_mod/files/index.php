<?php 
session_start();
ob_start();

require_once "../../../assets/support/inc.login.php";
$_GET['module_id']=1;

 $module_name="Accounts Management Solution";


if(isset($_POST['ibssignin']))
{
	$passward 	= $_POST['pass'];
	$uid  		= $_POST['uid'];
	$cid  		= $_POST['cid'];
if(check_for_login($cid,$uid,$passward,1)){
//header("Location:home.php");
	header("Location:../../../login/pages/main/home.php");
}
}else session_destroy();



if(isset($_POST['ibssignin']))
{
$msg="Invalid Login Information!!!";
$type=0;
}

?>
<?php 

include '../../../assets/template/login_interface.php';
?>