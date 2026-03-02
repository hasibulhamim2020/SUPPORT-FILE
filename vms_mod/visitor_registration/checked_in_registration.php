<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Visitor Check-In Registration';
$table   = 'vms_visitor_master';
$unique  = 'id';
$page    = 'checked_in_registration.php';

do_calander('#visit_date');
if(isset($_GET['msg'])) nibirToast($_GET['msg']);

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];

$id                    = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$visitor_no            = '';
$pre_reg_id            = 0;
$pre_reg_no            = '';
$visitor_name          = '';
$visitor_mobile        = '';
$visitor_email         = '';
$visitor_company       = '';
$visitor_id_type       = '';
$visitor_id_no         = '';
$visit_purpose         = '';
$remarks               = '';
$visit_date            = date('Y-m-d');
$visit_time_from       = '09:00';
$visit_time_to         = '17:00';
$host_pbi_id           = 0;
$host_department       = '';
$host_department_id    = '';
$host_designation      = '';
$host_email            = '';
$host_mobile           = '';
$visitor_type_id       = 0;
$zone_id               = 0;
$approval_status       = '';
$visitor_status        = '';
$card_id               = 0;
$card_no               = '';
$visitor_in_image      = '';
$visitor_id_doc_img    = '';
$visitor_id_up_doc_img = '';

function save_b64_image($b64_data, $prefix, $visitor_no_val, $folder = 'visitors'){
    if(empty($b64_data)) return '';
    $b64  = preg_replace('/^data:image\/\w+;base64,/', '', $b64_data);
    $dir  = '../images/'.$folder.'/';
    if(!is_dir($dir)) mkdir($dir, 0755, true);
    $fname = $prefix.'_'.$visitor_no_val.'_'.time().'.jpg';
    file_put_contents($dir.$fname, base64_decode($b64));
    return $fname;
}
function save_upload_file($file_input_name, $prefix, $visitor_no_val){
    if(!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['error'] != 0) return '';
    $ext   = strtolower(pathinfo($_FILES[$file_input_name]['name'], PATHINFO_EXTENSION));
    $dir   = '../images/documents/';
    if(!is_dir($dir)) mkdir($dir, 0755, true);
    $fname = $prefix.'_'.$visitor_no_val.'_'.time().'.'.$ext;
    move_uploaded_file($_FILES[$file_input_name]['tmp_name'], $dir.$fname);
    return $fname;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $b64_photo = $_POST['visitor_in_image_b64'] ?? '';
    $b64_doc   = $_POST['visitor_id_doc_b64']   ?? '';
    unset($_POST['visitor_in_image_b64'], $_POST['visitor_id_doc_b64']);

    if(isset($_POST['insert'])){
        $cy_id = (int)find_a_field($table, 'MAX(id)', '1') + 1;
        $vno   = 'VMS'.date('ym').sprintf('%05d', $cy_id);

        $_POST['visitor_no']           = $vno;
        $_POST['approval_status']      = '';
        $_POST['check_in_date']        = date('Y-m-d');
        $_POST['check_in_time']        = date('Y-m-d H:i:s');
        $_POST['group_for']            = $grp;
        $_POST['company_id']           = $grp;
        $_POST['entry_by']             = $uid;
        $_POST['entry_at']             = date('Y-m-d H:i:s');
        $_POST['visitor_in_image']     = save_b64_image($b64_photo, 'VIS', $vno, 'visitors');
        $_POST['visitor_id_doc_img']   = save_b64_image($b64_doc,   'DOC', $vno, 'documents');
        $_POST['visitor_id_up_doc_img']= save_upload_file('doc_upload_file', 'UDOC', $vno);

        (new crud($table))->insert();
        header("Location: checked_in_unapproved_view.php?msg=Visitor+Checked+In+Successfully"); exit;
    }

    if(isset($_POST['update']) && $id > 0){
        $ex  = db_query("SELECT visitor_in_image, visitor_id_doc_img, visitor_id_up_doc_img, visitor_no FROM $table WHERE id=$id AND group_for='".$grp."' LIMIT 1");
        $exd = $ex ? mysqli_fetch_object($ex) : null;
        $vno = $exd ? $exd->visitor_no : 'VMS'.$id;

        $_POST['visitor_in_image']     = !empty($b64_photo) ? save_b64_image($b64_photo, 'VIS', $vno, 'visitors')   : ($exd ? $exd->visitor_in_image     : '');
        $_POST['visitor_id_doc_img']   = !empty($b64_doc)   ? save_b64_image($b64_doc,   'DOC', $vno, 'documents')  : ($exd ? $exd->visitor_id_doc_img   : '');
        $new_upload = save_upload_file('doc_upload_file', 'UDOC', $vno);
        $_POST['visitor_id_up_doc_img']= $new_upload        ? $new_upload                                            : ($exd ? $exd->visitor_id_up_doc_img : '');

        $_POST['id']          = $id;
        $_POST['updated_by']  = $uid;
        $_POST['updated_at']  = date('Y-m-d H:i:s');

        if((int)$_POST['pre_reg_id'] > 0) $_POST['approval_status'] = 'Approved';

        (new crud($table))->update($unique);
        header("Location: checked_in_unapproved_view.php?msg=Updated+Successfully"); exit;
    }
}

if($id > 0){
    $res  = db_query("SELECT * FROM ".$table." WHERE id=".$id." AND group_for='".$grp."' LIMIT 1");
    $data = mysqli_fetch_object($res);
    if($data){ foreach($data as $k => $v) $$k = $v; }
}

$pre_id = isset($_GET['pre_reg_id']) ? (int)$_GET['pre_reg_id'] : 0;
if($pre_id > 0 && $id == 0){
    $pr = db_query("SELECT * FROM vms_pre_registration WHERE id=".$pre_id." AND group_for='".$grp."' LIMIT 1");
    $pd = $pr ? mysqli_fetch_object($pr) : null;
    if($pd){
        $pre_reg_id      = $pd->id;
        $pre_reg_no      = $pd->pre_reg_no;
        $visitor_name    = $pd->visitor_name;
        $visitor_mobile  = $pd->visitor_mobile;
        $visitor_email   = $pd->visitor_email;
        $visitor_company = $pd->visitor_company;
        $visitor_id_type = $pd->visitor_id_type;
        $visitor_id_no   = $pd->visitor_id_number;
        $visit_purpose   = $pd->visit_purpose;
        $visit_date      = $pd->visit_date;
        $visit_time_from = $pd->visit_time_from;
        $visit_time_to   = $pd->visit_time_to;
        $host_pbi_id     = $pd->host_pbi_id;
        $host_department = $pd->host_department;
        $host_mobile     = $pd->host_mobile;
        $host_email      = $pd->host_email;
        $visitor_type_id = $pd->visitor_type_id;
        $zone_id         = $pd->zone_id;
    }
}

$photo_url     = $visitor_in_image      ? '../images/visitors/'.htmlspecialchars($visitor_in_image)       : '';
$doc_cam_url   = $visitor_id_doc_img    ? '../images/documents/'.htmlspecialchars($visitor_id_doc_img)    : '';
$doc_up_url    = $visitor_id_up_doc_img ? '../images/documents/'.htmlspecialchars($visitor_id_up_doc_img) : '';
$doc_up_is_pdf = strtolower(pathinfo($visitor_id_up_doc_img, PATHINFO_EXTENSION)) === 'pdf';

$badge_map = ['Pending'=>'warning','Approved'=>'success','Rejected'=>'danger','CheckedIn'=>'info','Expired'=>'secondary'];
$badge     = isset($badge_map[$approval_status]) ? $badge_map[$approval_status] : 'secondary';
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
.vms-btn-bar              { border-top:2px solid #e8edf2; padding-top:16px; margin-top:4px; }

.cam-wrap                 { position:relative; width:100%; height:185px; background:#0f172a; border-radius:8px; overflow:hidden; display:flex; align-items:center; justify-content:center; }
.cam-idle                 { color:#475569; text-align:center; font-size:12px; line-height:1.8; display:flex; flex-direction:column; align-items:center; }
.cam-idle i               { font-size:30px; color:#334155; display:block; margin-bottom:4px; }
.up-wrap                  { background:#f1f5f9; border:2px dashed #cbd5e1; cursor:pointer; color:#64748b; font-size:12px; text-align:center; flex-direction:column; transition:.2s; }
.up-wrap:hover,
.up-wrap.up-hover         { border-color:#7c3aed; background:#faf5ff; color:#7c3aed; }
.up-wrap > i              { font-size:30px; margin-bottom:6px; }
.cam-btns                 { display:flex; gap:6px; flex-wrap:wrap; margin-top:6px; }
.cbtn                     { font-size:11px; font-weight:600; padding:4px 11px; border:none; border-radius:5px; cursor:pointer; }
.cbtn-blue                { background:#2563eb; color:#fff; }
.cbtn-green               { background:#10b981; color:#fff; }
.cbtn-amber               { background:#f59e0b; color:#fff; }
.cbtn-purple              { background:#7c3aed; color:#fff; }
.cbtn-gray                { background:#6b7280; color:#fff; }
.cam-status               { font-size:10.5px; margin-top:4px; min-height:15px; }
.existing-img-box         { position:relative; width:100%; height:185px; border-radius:8px; overflow:hidden; background:#0f172a; }
.existing-img-box img     { width:100%; height:100%; object-fit:cover; border-radius:7px; }
.existing-img-overlay     { position:absolute; top:4px; right:4px; z-index:5; }
</style>

<div class="container-fluid px-3 py-2">
<div class="card border-0 vms-card">

    <div class="card-body px-4 py-3">
    <form action="<?=$page?>?id=<?=$id?>" method="post" name="codz" id="codz" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="id"                 value="<?=$id?>">
        <input type="hidden" name="pre_reg_id"         value="<?=$pre_reg_id?>">
        <input type="hidden" name="pre_reg_no"         value="<?=htmlspecialchars($pre_reg_no)?>">
        <input type="hidden" name="group_for"          value="<?=$grp?>">
        <input type="hidden" name="company_id"         value="<?=$grp?>">
        <input type="hidden" name="host_department_id" id="h_deptid" value="<?=htmlspecialchars($host_department_id)?>">

        <? if($pre_reg_no || ($id > 0 && $approval_status)){ ?>
        <div class="d-flex align-items-center gap-3 mb-3 pb-2" style="border-bottom:2px solid #e2e8f0;">
            <? if($pre_reg_no){ ?>
            <span style="font-size:12px; font-weight:700; background:#eef2ff; color:#3730a3; border:1.5px solid #c7d2fe; border-radius:7px; padding:4px 12px; display:inline-flex; align-items:center; gap:5px;">
                <i class="fa-solid fa-link fa-xs"></i> Pre-Reg: <?=htmlspecialchars($pre_reg_no)?>
            </span>
            <? } ?>
            <? if($id > 0 && $approval_status){ ?>
            <span class="badge bg-<?=$badge?>" style="font-size:12px; padding:5px 12px;"><?=htmlspecialchars($approval_status)?></span>
            <? } ?>
        </div>
        <? } ?>

        <div class="vms-section-label">
            <span class="vms-section-icon bg-dark text-white"><i class="fa-solid fa-camera fa-xs"></i></span>
            Visitor Photo &amp; Document Scan
            <? if($id > 0) echo "<span style='font-size:10px;font-weight:400;color:#94a3b8;margin-left:6px;'>(leave boxes unchanged to keep existing images)</span>"; ?>
        </div>

        <div class="row mb-3">

            <div class="col-sm-4 mb-2">
                <div class="vms-field-label"><i class="fa-solid fa-user-circle fa-xs me-1"></i> Visitor Photo</div>
                <? if($photo_url && $id > 0){ ?>
                <div class="existing-img-box" id="photo_existing_box">
                    <img src="<?=$photo_url?>" alt="Visitor Photo">
                    <div class="existing-img-overlay">
                        <button type="button" class="cbtn cbtn-amber" onclick="phReplace()"><i class="fa-solid fa-camera"></i> Retake</button>
                    </div>
                </div>
                <? } ?>
                <div class="cam-wrap" id="photo_wrap" <?= ($photo_url && $id>0) ? 'style="display:none;"' : '' ?>>
                    <div class="cam-idle" id="photo_idle"><i class="fa-solid fa-camera"></i><br>Camera not started</div>
                    <video id="photo_video" autoplay playsinline style="display:none;width:100%;height:100%;object-fit:cover;border-radius:7px;"></video>
                    <img id="photo_captured" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:7px;" alt="">
                    <canvas id="photo_canvas" style="display:none;"></canvas>
                </div>
                <input type="hidden" name="visitor_in_image_b64" id="visitor_in_image_b64" value="">
                <div class="cam-btns" id="photo_btns" <?= ($photo_url && $id>0) ? 'style="display:none;"' : '' ?>>
                    <button type="button" class="cbtn cbtn-blue"  id="ph_start"  onclick="phStart()"><i class="fa-solid fa-video"></i> Start</button>
                    <button type="button" class="cbtn cbtn-green" id="ph_snap"   onclick="phSnap()"   style="display:none;"><i class="fa-solid fa-camera"></i> Capture</button>
                    <button type="button" class="cbtn cbtn-amber" id="ph_retake" onclick="phRetake()" style="display:none;"><i class="fa-solid fa-rotate-left"></i> Retake</button>
                </div>
                <div class="cam-status" id="photo_status"></div>
            </div>

            <div class="col-sm-4 mb-2">
                <div class="vms-field-label"><i class="fa-solid fa-id-card fa-xs me-1"></i> ID Document — Webcam</div>
                <? if($doc_cam_url && $id > 0){ ?>
                <div class="existing-img-box" id="doccam_existing_box">
                    <img src="<?=$doc_cam_url?>" alt="ID Document">
                    <div class="existing-img-overlay">
                        <button type="button" class="cbtn cbtn-amber" onclick="dcReplace()"><i class="fa-solid fa-camera"></i> Rescan</button>
                    </div>
                </div>
                <? } ?>
                <div class="cam-wrap" id="doc_wrap" <?= ($doc_cam_url && $id>0) ? 'style="display:none;"' : '' ?>>
                    <div class="cam-idle" id="doc_idle"><i class="fa-solid fa-id-card"></i><br>Camera not started</div>
                    <video id="doc_video" autoplay playsinline style="display:none;width:100%;height:100%;object-fit:cover;border-radius:7px;"></video>
                    <img id="doc_captured" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:7px;" alt="">
                    <canvas id="doc_canvas" style="display:none;"></canvas>
                </div>
                <input type="hidden" name="visitor_id_doc_b64" id="visitor_id_doc_b64" value="">
                <div class="cam-btns" id="doccam_btns" <?= ($doc_cam_url && $id>0) ? 'style="display:none;"' : '' ?>>
                    <button type="button" class="cbtn cbtn-purple" id="dc_start"  onclick="dcStart()"><i class="fa-solid fa-video"></i> Start</button>
                    <button type="button" class="cbtn cbtn-green"  id="dc_snap"   onclick="dcSnap()"   style="display:none;"><i class="fa-solid fa-camera"></i> Capture</button>
                    <button type="button" class="cbtn cbtn-amber"  id="dc_retake" onclick="dcRetake()" style="display:none;"><i class="fa-solid fa-rotate-left"></i> Retake</button>
                </div>
                <div class="cam-status" id="doc_status"></div>
            </div>

            <div class="col-sm-4 mb-2">
                <div class="vms-field-label"><i class="fa-solid fa-upload fa-xs me-1"></i> ID Document — Upload</div>
                <? if($doc_up_url && $id > 0){ ?>
                <div class="existing-img-box" id="up_existing_box">
                    <? if($doc_up_is_pdf){ ?>
                    <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#fee2e2;color:#991b1b;font-size:12px;text-align:center;border-radius:7px;">
                        <i class="fa-solid fa-file-pdf" style="font-size:34px;margin-bottom:6px;display:block;"></i>
                        <?=htmlspecialchars(basename($visitor_id_up_doc_img))?>
                    </div>
                    <? } else { ?>
                    <img src="<?=$doc_up_url?>" alt="Uploaded Document" style="object-fit:contain;">
                    <? } ?>
                    <div class="existing-img-overlay">
                        <button type="button" class="cbtn cbtn-amber" onclick="upReplace()"><i class="fa-solid fa-upload"></i> Replace</button>
                    </div>
                </div>
                <? } ?>
                <div class="cam-wrap up-wrap" id="up_dropzone"
                     <?= ($doc_up_url && $id>0) ? 'style="display:none;"' : '' ?>
                     onclick="document.getElementById('up_file').click()"
                     ondragover="event.preventDefault();this.classList.add('up-hover')"
                     ondragleave="this.classList.remove('up-hover')"
                     ondrop="upDrop(event)">
                    <i class="fa-solid fa-cloud-arrow-up" style="font-size:30px;margin-bottom:6px;"></i>
                    Click or drag &amp; drop<br>
                    <span style="font-size:10px;opacity:.6;">JPG · PNG · PDF — max 5MB</span>
                </div>
                <div id="up_preview_wrap" style="display:none;position:relative;width:100%;height:185px;background:#0f172a;border-radius:8px;overflow:hidden;">
                    <img id="up_img_preview" style="display:none;width:100%;height:100%;object-fit:contain;border-radius:7px;" alt="">
                    <div id="up_pdf_box" style="display:none;position:absolute;inset:0;background:#fee2e2;border-radius:7px;flex-direction:column;align-items:center;justify-content:center;font-size:12px;color:#991b1b;padding:10px;text-align:center;">
                        <i class="fa-solid fa-file-pdf" style="font-size:34px;margin-bottom:6px;display:block;"></i>
                        <span id="up_pdf_name" style="word-break:break-all;"></span>
                    </div>
                </div>
                <input type="file" id="up_file" name="doc_upload_file" accept="image/jpeg,image/png,application/pdf" style="display:none;" onchange="upPick(this)">
                <div class="cam-btns">
                    <button type="button" class="cbtn cbtn-gray" id="up_clear" onclick="upClear()" style="display:none;"><i class="fa-solid fa-trash"></i> Clear</button>
                </div>
                <div class="cam-status" id="up_status"></div>
            </div>

        </div>

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
                    $vt = db_query("SELECT id, visitor_type_name FROM vms_visitor_type WHERE status='Active' ORDER BY visitor_type_name");
                    while($r = mysqli_fetch_object($vt)){
                        echo "<option value='".$r->id."'".($visitor_type_id==$r->id?' selected':'').">".htmlspecialchars($r->visitor_type_name)."</option>";
                    }?>
                </select>
            </div>
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Full Name <span class="req">*</span></div>
                <input type="text" name="visitor_name" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_name)?>" placeholder="Visitor's full name">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Email</div>
                <input type="text" name="visitor_email" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_email)?>" placeholder="email@example.com">
            </div>
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Phone <span class="req">*</span></div>
                <input type="text" name="visitor_mobile" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_mobile)?>" placeholder="01XXXXXXXXX">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Company / Organisation</div>
                <input type="text" name="visitor_company" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_company)?>" placeholder="Company name">
            </div>
            <div class="col-sm-3 mb-2">
                <div class="vms-field-label">ID Type</div>
                <select name="visitor_id_type" class="form-select form-select-sm">
                    <option value="">— Type —</option>
                    <option value="NID"             <?=$visitor_id_type=='NID'             ?'selected':''?>>NID</option>
                    <option value="Passport"        <?=$visitor_id_type=='Passport'        ?'selected':''?>>Passport</option>
                    <option value="Driving License" <?=$visitor_id_type=='Driving License' ?'selected':''?>>Driving License</option>
                    <option value="Other"           <?=$visitor_id_type=='Other'           ?'selected':''?>>Other</option>
                </select>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="vms-field-label">ID Number</div>
                <input type="text" name="visitor_id_no" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($visitor_id_no)?>" placeholder="ID number">
            </div>
        </div>

        <div class="vms-section-label mt-3">
            <span class="vms-section-icon bg-success text-white"><i class="fa-solid fa-calendar-days fa-xs"></i></span>
            Visit Schedule
        </div>

        <div class="row mb-2">
            <div class="col-sm-4 mb-2">
                <div class="vms-field-label">Visit Date <span class="req">*</span></div>
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
                <div class="vms-field-label">Host Person <span class="req">*</span></div>
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
                       value="<?=htmlspecialchars($host_mobile)?>" placeholder="Auto-filled on host selection">
            </div>
            <div class="col-sm-6 mb-2">
                <div class="vms-field-label">Host Email</div>
                <input type="text" name="host_email" id="host_email" class="form-control form-control-sm"
                       value="<?=htmlspecialchars($host_email)?>" placeholder="Auto-filled on host selection">
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
                    <option value="0">— General Access —</option>
                    <?
                    $zq = db_query("SELECT id, zone_name FROM vms_access_zone WHERE status='Active' ORDER BY zone_name");
                    while($z = mysqli_fetch_object($zq)){
                        echo "<option value='".$z->id."'".($zone_id==$z->id?' selected':'').">".htmlspecialchars($z->zone_name)."</option>";
                    }?>
                </select>
            </div>
            <div class="col-sm-8 mb-2">
                <div class="vms-field-label">Purpose of Visit</div>
                <textarea name="visit_purpose" class="form-control form-control-sm" rows="3"
                          placeholder="Reason for this visit…"><?=htmlspecialchars($visit_purpose)?></textarea>
            </div>
        </div>

        <div class="vms-btn-bar d-flex flex-wrap gap-2">
            <? if($id == 0){ ?>
            <button name="insert" type="submit" class="btn btn-success btn-sm px-4">
                <i class="fa-solid fa-right-to-bracket me-1"></i> Check In Visitor
            </button>
            <? } else { ?>
            <button name="update" type="submit" class="btn btn-primary btn-sm px-4">
                <i class="fa-solid fa-pen-to-square me-1"></i> Update
            </button>
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
    if(!user_id){ $('#host_department,#host_mobile,#host_email').val(''); $('#h_deptid').val(''); return; }
    $.post('vms_host_ajax.php', { user_id: user_id }, function(r){
        try{
            var d = (typeof r === 'object') ? r : JSON.parse(r);
            $('#host_mobile').val(d.mobile         || '');
            $('#host_email').val(d.email           || '');
            $('#host_department').val(d.department_id || '').trigger('change');
            $('#h_deptid').val(d.department_id     || '');
        }catch(e){}
    });
}

var phStream = null;
var dcStream = null;

function phStart(){
    navigator.mediaDevices.getUserMedia({video:true,audio:false}).then(function(s){
        phStream = s;
        var v = document.getElementById('photo_video');
        v.srcObject = s; v.style.display = 'block';
        document.getElementById('photo_idle').style.display     = 'none';
        document.getElementById('photo_captured').style.display = 'none';
        document.getElementById('ph_start').style.display       = 'none';
        document.getElementById('ph_snap').style.display        = 'inline-block';
        document.getElementById('ph_retake').style.display      = 'none';
        document.getElementById('photo_status').innerHTML       = '<span style="color:#10b981;">&#9679; Live</span>';
    }).catch(function(e){ alert('Camera error: '+e.message); });
}
function phSnap(){
    var v=document.getElementById('photo_video'), cnv=document.getElementById('photo_canvas');
    cnv.width=v.videoWidth||640; cnv.height=v.videoHeight||480;
    cnv.getContext('2d').drawImage(v,0,0);
    var b64=cnv.toDataURL('image/jpeg',0.88);
    document.getElementById('visitor_in_image_b64').value = b64;
    v.style.display='none';
    if(phStream) phStream.getTracks().forEach(function(t){t.stop();});
    var img=document.getElementById('photo_captured'); img.src=b64; img.style.display='block';
    document.getElementById('ph_snap').style.display   = 'none';
    document.getElementById('ph_retake').style.display = 'inline-block';
    document.getElementById('photo_status').innerHTML  = '<span style="color:#10b981;">&#10003; Captured</span>';
}
function phRetake(){
    document.getElementById('photo_captured').style.display='none';
    document.getElementById('photo_captured').src='';
    document.getElementById('visitor_in_image_b64').value='';
    document.getElementById('ph_retake').style.display='none';
    document.getElementById('photo_idle').style.display='flex';
    document.getElementById('ph_start').style.display='inline-block';
    document.getElementById('photo_status').innerHTML='';
    phStart();
}
function phReplace(){
    var eb=document.getElementById('photo_existing_box');
    if(eb) eb.style.display='none';
    document.getElementById('photo_wrap').style.display='flex';
    document.getElementById('photo_btns').style.display='flex';
    phStart();
}

function dcStart(){
    navigator.mediaDevices.getUserMedia({video:true,audio:false}).then(function(s){
        dcStream = s;
        var v=document.getElementById('doc_video');
        v.srcObject=s; v.style.display='block';
        document.getElementById('doc_idle').style.display     = 'none';
        document.getElementById('doc_captured').style.display = 'none';
        document.getElementById('dc_start').style.display     = 'none';
        document.getElementById('dc_snap').style.display      = 'inline-block';
        document.getElementById('dc_retake').style.display    = 'none';
        document.getElementById('doc_status').innerHTML       = '<span style="color:#10b981;">&#9679; Live</span>';
    }).catch(function(e){ alert('Camera error: '+e.message); });
}
function dcSnap(){
    var v=document.getElementById('doc_video'), cnv=document.getElementById('doc_canvas');
    cnv.width=v.videoWidth||640; cnv.height=v.videoHeight||480;
    cnv.getContext('2d').drawImage(v,0,0);
    var b64=cnv.toDataURL('image/jpeg',0.88);
    document.getElementById('visitor_id_doc_b64').value=b64;
    v.style.display='none';
    if(dcStream) dcStream.getTracks().forEach(function(t){t.stop();});
    var img=document.getElementById('doc_captured'); img.src=b64; img.style.display='block';
    document.getElementById('dc_snap').style.display   = 'none';
    document.getElementById('dc_retake').style.display = 'inline-block';
    document.getElementById('doc_status').innerHTML    = '<span style="color:#10b981;">&#10003; Captured</span>';
}
function dcRetake(){
    document.getElementById('doc_captured').style.display='none';
    document.getElementById('doc_captured').src='';
    document.getElementById('visitor_id_doc_b64').value='';
    document.getElementById('dc_retake').style.display='none';
    document.getElementById('doc_idle').style.display='flex';
    document.getElementById('dc_start').style.display='inline-block';
    document.getElementById('doc_status').innerHTML='';
    dcStart();
}
function dcReplace(){
    var eb=document.getElementById('doccam_existing_box');
    if(eb) eb.style.display='none';
    document.getElementById('doc_wrap').style.display   = 'flex';
    document.getElementById('doccam_btns').style.display= 'flex';
    dcStart();
}

function upPick(input){
    if(!input.files||!input.files[0]) return;
    var file=input.files[0];
    if(file.size>5*1024*1024){ alert('Max 5MB allowed.'); input.value=''; return; }
    var reader=new FileReader();
    reader.onload=function(e){
        document.getElementById('up_dropzone').style.display    ='none';
        document.getElementById('up_preview_wrap').style.display='block';
        if(file.type==='application/pdf'){
            document.getElementById('up_img_preview').style.display='none';
            document.getElementById('up_pdf_name').innerText=file.name;
            document.getElementById('up_pdf_box').style.display='flex';
        } else {
            document.getElementById('up_pdf_box').style.display='none';
            var img=document.getElementById('up_img_preview'); img.src=e.target.result; img.style.display='block';
        }
        document.getElementById('up_clear').style.display='inline-block';
        document.getElementById('up_status').innerHTML='<span style="color:#10b981;">&#10003; '+file.name+'</span>';
    };
    reader.readAsDataURL(file);
}
function upDrop(e){
    e.preventDefault();
    document.getElementById('up_dropzone').classList.remove('up-hover');
    if(e.dataTransfer.files.length){ var inp=document.getElementById('up_file'); inp.files=e.dataTransfer.files; upPick(inp); }
}
function upClear(){
    document.getElementById('up_file').value='';
    document.getElementById('up_preview_wrap').style.display='none';
    document.getElementById('up_img_preview').style.display='none';
    document.getElementById('up_img_preview').src='';
    document.getElementById('up_pdf_box').style.display='none';
    document.getElementById('up_dropzone').style.display='flex';
    document.getElementById('up_clear').style.display='none';
    document.getElementById('up_status').innerHTML='';
}
function upReplace(){
    var eb=document.getElementById('up_existing_box');
    if(eb) eb.style.display='none';
    document.getElementById('up_dropzone').style.display='flex';
}
</script>

<?
selected_two('#host_pbi_id');
selected_two('#visitor_type_id');
selected_two('#host_department');
selected_two('#zone_id');
require_once SERVER_CORE."routing/layout.bottom.php";
?>