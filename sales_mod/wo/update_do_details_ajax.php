<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$master_do_no=$_REQUEST['do_no'];
$do_details_id=$_REQUEST['details_id'];

$dist_unit=$_REQUEST['dist_unit'];

//$all_do_details=find_all_field('sale_do_details','','id="'.$do_details_id.'" and do_no="'.$master_do_no.'"');

$update_do_details="UPDATE sale_do_details 
SET dist_unit='".$dist_unit."',
edit_by='".$_SESSION['user']['id']."',edit_at='".date('Y-m-d H:i:s')."' 
WHERE do_no='".$master_do_no."' and id='".$do_details_id."'";

$do_details_update_query = db_query($update_do_details);
//$details_update_data=mysqli_fetch_object($do_details_update_query);

echo 'Success!';

?>
