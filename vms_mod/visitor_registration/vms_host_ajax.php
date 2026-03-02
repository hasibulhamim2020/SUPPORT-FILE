<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';

$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

$out = ['department_id' => '', 'designation_name' => '', 'email' => '', 'mobile' => ''];

if($user_id > 0){

    $user = find_all_field('user_activity_management', '', 'user_id='.$user_id);

    if($user && $user->PBI_ID > 0){

        $pbi = find_all_field('personnel_basic_info', '', 'PBI_ID='.(int)$user->PBI_ID);

        if($pbi){
            $out['email']            = $pbi->PBI_EMAIL       ?: '';
            $out['mobile']           = $pbi->PBI_MOBILE      ?: '';
            $out['department_id']    = $pbi->DEPT_ID         ?: '';
            $out['designation_name'] = $pbi->PBI_DESIGNATION ?: '';
        }
    }
}

echo json_encode($out);
?>