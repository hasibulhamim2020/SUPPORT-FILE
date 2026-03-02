<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//add_user_activity_log($_SESSION['user']['id'],1,1,'LogOut Page','Successfully LogOut In SCB',$_SESSION['user']['level']);
session_destroy();
header("Location: ../../index.php");
?>
