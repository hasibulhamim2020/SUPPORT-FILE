<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Visitor Pre-Registration';
$table   = 'vms_pre_registration';
$unique  = 'id';
$page    = 'visitor_pre_registration.php';

do_calander('#visit_date');
if(isset($_GET['msg'])) nibirToast($_GET['msg']);

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];

$id                = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$pre_reg_no        = '';
$visitor_name      = '';
$visitor_mobile    = '';
$visitor_email     = '';
$visitor_company   = '';
$visitor_id_type   = '';
$visitor_id_number = '';
$visit_purpose     = '';
$remarks           = '';
$visit_date        = date('Y-m-d');
$visit_time_from   = '09:00';
$visit_time_to     = '17:00';
$host_pbi_id       = 0;
$host_department   = '';
$host_designation  = '';
$host_email        = '';
$host_mobile       = '';
$visitor_type_id   = 0;
$zone_id           = 0;
$status            = 'Pending';
$send_email_notify = 0;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['insert'])){
        $cy_id               = (int)find_a_field($table, 'MAX(id)', '1') + 1;
        $_POST['pre_reg_no'] = 'PRE'.date('ym').sprintf('%05d', $cy_id);
        $_POST['status']     = 'Pending';
        $_POST['group_for']  = $grp;
        $_POST['company_id'] = $grp;
        $_POST['entry_by']   = $uid;
        $_POST['entry_at']   = date('Y-m-d H:i:s');
        (new crud($table))->insert();
        header("Location: visitor_unapproved_view.php?msg=Pre-Registration+Submitted");
        exit;
    }
    if(isset($_POST['update']) && $id > 0){
        $_POST['id']         = $id;
        $_POST['updated_by'] = $uid;
        $_POST['updated_at'] = date('Y-m-d H:i:s');
        (new crud($table))->update($unique);
        header("Location: visitor_unapproved_view.php?msg=Updated+Successfully");
        exit;
    }
}

if($id > 0){
    $res  = db_query("SELECT * FROM ".$table." WHERE id=".$id." AND group_for='".$grp."' LIMIT 1");
    $data = mysqli_fetch_object($res);
    if($data){ foreach($data as $k => $v) $$k = $v; }
}
$badge_map = ['Pending'=>'warning','Approved'=>'success','Rejected'=>'danger','CheckedIn'=>'info','Expired'=>'secondary'];
$badge     = isset($badge_map[$status]) ? $badge_map[$status] : 'secondary';
?>

<style>
.vms-card                 { margin:18px auto; border-radius:12px; box-shadow:0 4px 22px rgba(0,0,0,.11); }
.vms-section-label        { font-size:10.5px; font-weight:800; letter-spacing:.10em; text-transform:uppercase; color:#334155; margin-bottom:10px; margin-top:2px; display:flex; align-items:center; gap:7px; }
.vms-section-label::after { content:''; flex:1; height:2px; background:linear-gradient(90deg,#e2e8f0,transparent); }
.vms-section-icon         { width:24px; height:24px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:11px; flex-shrink:0; }
.vms-field-label          { font-size:11.5px; font-weight:700; color:#1e293b; margin-bottom:3px; }
.vms-field-label .req     { color:#dc2626; }
.form-control-sm,
.form-select-sm           { font-size:12.5px !important; border:1.5px solid #c8d3df !important; background:#f8fafc !important; color:#0f172a !important; border-radius:6px !important; }
.form-control-sm:focus,
.form-select-sm:focus     { border-color:#6366f1 !important; background:#fff !important; box-shadow:0 0 0 3px rgba(99,102,241,.13) !important; }
textarea.form-control-sm  { resize:vertical; }
.vms-prereg-badge         { font-size:12.5px; font-weight:700; letter-spacing:.04em; background:#eef2ff; color:#3730a3; border:1.5px solid #c7d2fe; border-radius:7px; padding:5px 14px; display:inline-flex; align-items:center; gap:5px; }
.vms-btn-bar              { border-top:2px solid #e8edf2; padding-top:16px; margin-top:4px; }
</style>

<div class="container-fluid px-3 py-2">
<div class="card border-0 vms-card">

    <div class="card-body px-4 py-3">
    <form action="<?=$page?>?id=<?=$id?>" method="post" name="codz" id="codz" autocomplete="off">
        <input type="hidden" name="id"               value="<?=$id?>">
        <input type="hidden" name="group_for"        value="<?=$grp?>">
        <input type="hidden" name="company_id"       value="<?=$grp?>">
        <input type="hidden" name="host_designation" id="h_deptid" value="<?=htmlspecialchars($host_designation)?>">

        <? if($id > 0){ ?>
        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="vms-field-label mb-1">Pre-Reg No</div>
                <span class="vms-prereg-badge">
                    <i class="fa-solid fa-hashtag fa-xs"></i> <?=htmlspecialchars($pre_reg_no)?>
                </span>
            </div>
        </div>
        <? } ?>

        <div class="vms-section-label">
            <span class="vms-section-icon bg-primary text-white"><i class="fa-solid fa-user fa-xs"></i></span>
            Visitor Information
        </div>

        <div class="row mb-2">
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Visitor Type</div>
                <select name="visitor_type_id" id="visitor_type_id" class="form-select form-select-sm">
                    <option value="">— Select Type —</option>
                    <?
                    $vt = db_query("SELECT id, visitor_type_name FROM vms_visitor_type WHERE status='Active' AND (group_for='0' OR group_for='".$grp."') ORDER BY visitor_type_name");
                    while($r = mysqli_fetch_object($vt)){
                        echo "<option value='".$r->id."'".($visitor_type_id==$r->id?' selected':'').">".htmlspecialchars($r->visitor_type_name)."</option>";
                    }?>
                </select>
            </div>
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Full Name </div>
                <input type="text" name="visitor_name" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_name)?>" placeholder="Name">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Email</div>
                <input type="email" name="visitor_email" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_email)?>" placeholder="mail@erp.com">
            </div>
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Phone </div>
                <input type="number" name="visitor_mobile" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_mobile)?>" placeholder="017..">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Company / Organisation</div>
                <input type="text" name="visitor_company" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_company)?>" placeholder="Company">
            </div>
            <div class="col-sm-3 mb-2">
                <div class="vms-field-label">ID Type</div>
                <select name="visitor_id_type" id="visitor_id_type" class="form-select form-select-sm">
                    <option value="">— Type —</option>
                    <option value="NID"      <?=$visitor_id_type=='NID'      ?'selected':''?>>NID</option>
                    <option value="Passport" <?=$visitor_id_type=='Passport' ?'selected':''?>>Passport</option>
                    <option value="License"  <?=$visitor_id_type=='License'  ?'selected':''?>>License</option>
                    <option value="Employee" <?=$visitor_id_type=='Employee' ?'selected':''?>>Employee ID</option>
                </select>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="vms-field-label">ID Number</div>
                <input type="text" name="visitor_id_number" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_id_number)?>" placeholder="ID ..">
            </div>
        </div>

        <div class="vms-section-label mt-3">
            <span class="vms-section-icon bg-success text-white"><i class="fa-solid fa-calendar-days fa-xs"></i></span>
            Visit Schedule
        </div>

        <div class="row mb-2">
            <div class="col-sm-4 mb-2">
                <div class="vms-field-label">Visit Date </div>
                <input type="text" name="visit_date" id="visit_date" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visit_date)?>" autocomplete="off">
            </div>
            <div class="col-sm-4 mb-2">
                <div class="vms-field-label">Time From</div>
                <input type="time" name="visit_time_from" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visit_time_from)?>">
            </div>
            <div class="col-sm-4 mb-2">
                <div class="vms-field-label">Time To</div>
                <input type="time" name="visit_time_to" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visit_time_to)?>">
            </div>
        </div>

        <div class="vms-section-label mt-3">
            <span class="vms-section-icon bg-warning text-white"><i class="fa-solid fa-user-tie fa-xs"></i></span>
            Host Information
        </div>

        <div class="row mb-2">
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Host Person </div>
                <select name="host_pbi_id" id="host_pbi_id" class="form-select form-select-sm"
                        onchange="get_host_info(this.value)">
                    <option value="">— Select Host —</option>
                    <?
                    $hq = db_query("SELECT user_id, fname, designation FROM user_activity_management WHERE 1 ORDER BY fname");
                    while($h = mysqli_fetch_object($hq)){
                        $lbl = htmlspecialchars($h->fname.($h->designation ? ' — '.$h->designation : ''));
                        echo "<option value='".$h->user_id."'".($host_pbi_id==$h->user_id?' selected':'').">".$lbl."</option>";
                    }?>
                </select>
            </div>
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Department</div>
                <select name="host_department" id="host_department" class="form-select form-select-sm">
                    <option value="">— Select Department —</option>
                    <?
                    $dq = db_query("SELECT DEPT_ID, DEPT_DESC FROM department ORDER BY DEPT_DESC");
                    while($dp = mysqli_fetch_object($dq)){
                        echo "<option value='".$dp->DEPT_ID."'".($host_department==$dp->DEPT_ID?' selected':'').">".htmlspecialchars($dp->DEPT_DESC)."</option>";
                    }?>
                </select>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Host Mobile</div>
                <input type="text" name="host_mobile" id="host_mobile" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($host_mobile)?>" placeholder="Auto-filled ..">
            </div>
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Host Email</div>
                <input type="email" name="host_email" id="host_email" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($host_email)?>" placeholder="Auto-filled ..">
            </div>
        </div>

        <div class="vms-section-label mt-3">
            <span class="vms-section-icon bg-info text-white"><i class="fa-solid fa-door-open fa-xs"></i></span>
            Access &amp; Purpose
        </div>

        <div class="row mb-2">
            <div class="col-sm-4 mb-2">
                <div class="vms-field-label">Access Zone</div>
                <select name="zone_id" id="zone_id" class="form-select form-select-sm">
                    <option value="">— Select Zone —</option>
                    <?
                    $zq = db_query("SELECT id, zone_name FROM vms_access_zone WHERE status='Active' AND (group_for='0' OR group_for='".$grp."') ORDER BY zone_name");
                    while($z = mysqli_fetch_object($zq)){
                        echo "<option value='".$z->id."'".($zone_id==$z->id?' selected':'').">".htmlspecialchars($z->zone_name)."</option>";
                    }?>
                </select>
            </div>
            <div class="col-sm-8 mb-2">
                <div class="vms-field-label">Purpose of Visit </div>
                <textarea name="visit_purpose" class="form-control form-control-sm" rows="3"
                          placeholder="Reason …"><?=htmlspecialchars($visit_purpose)?></textarea>
            </div>
        </div>

        <div class="vms-btn-bar d-flex flex-wrap gap-2">
            <? if($id == 0){ ?>
            <button name="insert" type="submit" class="btn btn-success btn-sm px-4">
                <i class="fa-solid fa-paper-plane me-1"></i> Submit for Approval
            </button>
            <? } ?>
            <? if($id > 0){ ?>
            <button name="update" type="submit" class="btn btn-primary btn-sm px-4">
                <i class="fa-solid fa-pen-to-square me-1"></i> Update
            </button>
            <a href="visitor_pre_reg_view.php?id=<?=$id?>" class="btn btn-info btn-sm px-4 text-white">
                <i class="fa-solid fa-eye me-1"></i> View Record
            </a>
            <? } ?>
            <button type="button" class="btn btn-secondary btn-sm px-4"
                    onclick="parent.location='<?=$page?>'">
                <i class="fa-solid fa-rotate-left me-1"></i> Reset
            </button>
        </div>

    </form>
    </div>
</div>
</div>

<script>
function get_host_info(user_id){
    if(!user_id || user_id == 0){
        $('#host_department').val('').trigger('change');
        $('#host_mobile').val('');
        $('#host_email').val('');
        $('#h_deptid').val('');
        return;
    }
    $.post('vms_host_ajax.php', { user_id: user_id }, function(r){
        try{
            var d = (typeof r === 'object') ? r : JSON.parse(r);
            $('#host_mobile').val(d.mobile         || '');
            $('#host_email').val(d.email           || '');
            $('#host_department').val(d.department_id || '').trigger('change');
            $('#h_deptid').val(d.designation_name  || '');
        } catch(e){}
    });
}
</script>

<?
selected_two('#host_pbi_id');
selected_two('#visitor_type_id');
selected_two('#host_department');
selected_two('#zone_id');
require_once SERVER_CORE."routing/layout.bottom.php";
?>