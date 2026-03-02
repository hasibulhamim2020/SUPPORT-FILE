<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Registration View';
$table   = 'vms_visitor_master';
$unique  = 'id';
$page    = 'checked_in_view.php';

if(isset($_GET['msg'])) nibirToast($_GET['msg']);

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];
$id  = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

if($id < 1){
    echo "<div class='alert alert-warning m-3'>No record selected. <a href='checked_in_unapproved_view.php'>Go back</a></div>";
    require_once SERVER_CORE."routing/layout.bottom.php"; exit;
}

if(prevent_multi_submit()){
    if(isset($_POST['approve'])){
        db_query("UPDATE ".$table." SET approval_status='Approved', approved_by=".$uid.", approved_at='".date('Y-m-d H:i:s')."' WHERE id=".$id." AND group_for='".$grp."'");
        header("Location: checked_in_unapproved_view.php"); exit;
    }
    if(isset($_POST['reject'])){
        db_query("UPDATE ".$table." SET approval_status='Rejected', approved_by=".$uid.", approved_at='".date('Y-m-d H:i:s')."' WHERE id=".$id." AND group_for='".$grp."'");
        header("Location: checked_in_unapproved_view.php"); exit;
    }
}

$res = db_query("SELECT * FROM ".$table." WHERE id=".$id." AND group_for='".$grp."' LIMIT 1");
$d   = mysqli_fetch_object($res);
if(!$d){
    echo "<div class='alert alert-danger m-3'>Record not found.</div>";
    require_once SERVER_CORE."routing/layout.bottom.php"; exit;
}
$pbi_id     = find_a_field('user_activity_management','PBI_ID', 'user_id='.(int)$d->host_pbi_id);
$department = find_a_field('department','DEPT_DESC', 'DEPT_ID='.(int)$d->host_department);
$host       = find_all_field('personnel_basic_info','', 'PBI_ID='.(int)$pbi_id);
$entry_user = find_all_field('user_activity_management','', 'user_id='.(int)$d->entry_by);
$appr_user  = $d->approved_by ? find_all_field('user_activity_management','', 'user_id='.(int)$d->approved_by) : null;
$vtype_name = find_a_field('vms_visitor_type', 'visitor_type_name', 'id='.(int)$d->visitor_type_id);
$zone_name  = find_a_field('vms_access_zone',  'zone_name',         'id='.(int)$d->zone_id);

$sb  = ['Pending'=>'warning','Approved'=>'success','Rejected'=>'danger','CheckedIn'=>'info','Expired'=>'secondary'];
$bc  = isset($sb[$d->approval_status]) ? $sb[$d->approval_status] : 'secondary';
?>

<style>
.pv-header          { background:#1e3a5f; color:#fff; padding:12px 18px; display:flex; align-items:center; justify-content:space-between; border-radius:6px 6px 0 0; }
.pv-header-title    { font-size:14px; font-weight:700; }
.pv-header-sub      { font-size:11px; opacity:.7; margin-top:2px; }
.pv-body            { border:1px solid #dee2e6; border-top:none; border-radius:0 0 6px 6px; padding:16px; background:#fff; }
.pv-col             { border:1px solid #e5e7eb; border-radius:6px; overflow:hidden; height:100%; }
.pv-col-head        { background:#f8f9fa; border-bottom:1px solid #e5e7eb; padding:7px 12px; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#374151; }
.pv-col-body        { padding:10px 12px; }
.pv-row             { padding:5px 0; border-bottom:1px dashed #f3f4f6; font-size:13px; }
.pv-row:last-child  { border-bottom:none; }
.pv-lbl             { font-size:10px; color:#9ca3af; font-weight:700; text-transform:uppercase; letter-spacing:.04em; margin-bottom:1px; }
.pv-val             { font-size:13px; color:#111827; font-weight:500; }
.pv-purpose         { background:#f0f7ff; border-left:3px solid #2563eb; padding:9px 12px; border-radius:0 4px 4px 0; font-size:13px; color:#1e3a5f; line-height:1.7; }
.pv-audit           { font-size:11px; color:#9ca3af; margin-top:12px; padding-top:10px; border-top:1px dashed #e5e7eb; }
.img-sec-head       { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6c757d; margin-bottom:10px; display:flex; align-items:center; gap:6px; }
.img-sec-head::after{ content:''; flex:1; height:1px; background:#e9ecef; }
.img-panel          { border:1px solid #e5e7eb; border-radius:7px; overflow:hidden; height:100%; }
.img-panel-head     { background:#f8f9fa; border-bottom:1px solid #e5e7eb; padding:6px 12px; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#374151; }
.img-panel-body     { background:#0f172a; padding:8px; text-align:center; min-height:165px; display:flex; align-items:center; justify-content:center; }
.img-thumb          { max-width:100%; max-height:165px; object-fit:contain; border-radius:5px; cursor:pointer; transition:opacity .18s; }
.img-thumb:hover    { opacity:.82; }
.img-fname          { font-size:9px; color:#9ca3af; padding:3px 8px; word-break:break-all; background:#f8f9fa; border-top:1px solid #e5e7eb; }
.img-empty          { min-height:165px; display:flex; flex-direction:column; align-items:center; justify-content:center; font-size:11px; color:#adb5bd; background:#f9fafb; padding:16px; }
.img-empty i        { font-size:26px; margin-bottom:6px; color:#dee2e6; }
.img-pdf-box        { background:#fff5f5; padding:20px 12px; text-align:center; font-size:12px; color:#991b1b; width:100%; }
.img-pdf-box i      { font-size:32px; display:block; margin-bottom:6px; }
#img-lb             { display:none; position:fixed; inset:0; background:rgba(0,0,0,.88); z-index:9999; align-items:center; justify-content:center; cursor:zoom-out; }
#img-lb.show        { display:flex; }
#img-lb img         { max-width:90vw; max-height:90vh; border-radius:8px; box-shadow:0 8px 40px rgba(0,0,0,.5); cursor:default; }
#img-lb .lb-x       { position:absolute; top:16px; right:22px; color:#fff; font-size:30px; line-height:1; cursor:pointer; }
@media print {
    .pv-btn-bar { display:none !important; }
    .pv-header  { -webkit-print-color-adjust:exact; print-color-adjust:exact; border-radius:0; }
    body        { background:#fff !important; }
    #img-lb     { display:none !important; }
}
</style>

<div class="form-container_large">
<form action="<?=$page?>" method="post" name="codz" id="codz">
<input type="hidden" name="id" value="<?=$id?>">

<div style="margin:14px;">
    <div class="pv-header">
        <div>
            <div class="pv-header-title"><i class="fa-solid fa-id-card-clip mr-2"></i>Visitor Registration</div>
            <div class="pv-header-sub">Ref: <?=htmlspecialchars($d->visitor_no)?> &nbsp;·&nbsp; Submitted: <?=date('d M Y', strtotime($d->entry_at))?></div>
        </div>
        <div class="col-sm-6 text-right pv-btn-bar">
            <? if($d->approval_status == 'Pending'){ ?>
            <button type="submit" name="approve" class="btn btn-success btn-sm" onclick="return confirm('Approve?')">
                <i class="fa-solid fa-circle-check"></i> Approve
            </button>
            <button type="submit" name="reject" class="btn btn-danger btn-sm" onclick="return confirm('Reject?')">
                <i class="fa-solid fa-circle-xmark"></i> Reject
            </button>
            <? } ?>
            <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">
                <i class="fa-solid fa-print"></i> Print
            </button>
        </div>
        <span style="background:rgba(255,255,255,.18);padding:4px 14px;border-radius:20px;font-size:12px;font-weight:700;letter-spacing:.04em;">
            <?=strtoupper($d->approval_status)?>
        </span>
    </div>

    <div class="pv-body">

        <div class="img-sec-head"><i class="fa-solid fa-images fa-xs"></i> Captured Images &amp; Documents</div>
        <div class="row mb-3">

            <div class="col-sm-4 mb-2">
                <div class="img-panel">
                    <div class="img-panel-head"><i class="fa-solid fa-user-circle fa-xs mr-1"></i> Visitor Photo</div>
                    <? if(!empty($d->visitor_in_image)){ ?>
                    <div class="img-panel-body">
                        <img src="../images/visitors/<?=htmlspecialchars($d->visitor_in_image)?>" class="img-thumb" alt="Visitor Photo" onclick="lbOpen(this.src)">
                    </div>
                    <div class="img-fname"><?=htmlspecialchars($d->visitor_in_image)?></div>
                    <? } else { ?>
                    <div class="img-empty"><i class="fa-solid fa-camera"></i>No photo captured</div>
                    <? } ?>
                </div>
            </div>

            <div class="col-sm-4 mb-2">
                <div class="img-panel">
                    <div class="img-panel-head"><i class="fa-solid fa-id-card fa-xs mr-1"></i> ID Document (Webcam)</div>
                    <? if(!empty($d->visitor_id_doc_img)){ ?>
                    <div class="img-panel-body">
                        <img src="../images/documents/<?=htmlspecialchars($d->visitor_id_doc_img)?>" class="img-thumb" alt="ID Document" onclick="lbOpen(this.src)">
                    </div>
                    <div class="img-fname"><?=htmlspecialchars($d->visitor_id_doc_img)?></div>
                    <? } else { ?>
                    <div class="img-empty"><i class="fa-solid fa-id-card"></i>No webcam scan</div>
                    <? } ?>
                </div>
            </div>

            <div class="col-sm-4 mb-2">
                <div class="img-panel">
                    <div class="img-panel-head"><i class="fa-solid fa-upload fa-xs mr-1"></i> ID Document (Uploaded)</div>
                    <? if(!empty($d->visitor_id_up_doc_img)){
                        $up_ext = strtolower(pathinfo($d->visitor_id_up_doc_img, PATHINFO_EXTENSION));
                        $up_src = '../images/documents/'.htmlspecialchars($d->visitor_id_up_doc_img);
                    ?>
                        <? if($up_ext === 'pdf'){ ?>
                        <div class="img-pdf-box">
                            <i class="fa-solid fa-file-pdf"></i>
                            <div style="font-size:11px;margin-top:4px;word-break:break-all;"><?=htmlspecialchars($d->visitor_id_up_doc_img)?></div>
                            <a href="<?=$up_src?>" target="_blank" class="btn btn-danger btn-sm mt-2" style="font-size:10px;"><i class="fa-solid fa-eye mr-1"></i>Open PDF</a>
                        </div>
                        <? } else { ?>
                        <div class="img-panel-body">
                            <img src="<?=$up_src?>" class="img-thumb" alt="Uploaded Document" onclick="lbOpen(this.src)">
                        </div>
                        <div class="img-fname"><?=htmlspecialchars($d->visitor_id_up_doc_img)?></div>
                        <? } ?>
                    <? } else { ?>
                    <div class="img-empty"><i class="fa-solid fa-upload"></i>No document uploaded</div>
                    <? } ?>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-sm-4 pr-1 mb-2">
            <div class="pv-col">
                <div class="pv-col-head"><i class="fa-solid fa-user fa-xs mr-1"></i> Visitor Information</div>
                <div class="pv-col-body">
                    <div class="pv-row"><div class="pv-lbl">Full Name</div><div class="pv-val"><strong><?=htmlspecialchars($d->visitor_name)?></strong></div></div>
                    <div class="pv-row"><div class="pv-lbl">Visitor Type</div><div class="pv-val"><?=htmlspecialchars($vtype_name ?: '—')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Mobile</div><div class="pv-val"><?=htmlspecialchars($d->visitor_mobile ?: '—')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Email</div><div class="pv-val" style="font-size:12px;"><?=htmlspecialchars($d->visitor_email ?: '—')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Organisation</div><div class="pv-val"><?=htmlspecialchars($d->visitor_company ?: '—')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">ID Type</div><div class="pv-val"><?=htmlspecialchars($d->visitor_id_type ?: '—')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">ID Number</div><div class="pv-val"><?=htmlspecialchars($d->visitor_id_number ?: '—')?></div></div>
                </div>
            </div>
            </div>

            <div class="col-sm-4 px-1 mb-2">
            <div class="pv-col">
                <div class="pv-col-head"><i class="fa-solid fa-calendar-days fa-xs mr-1"></i> Visit Schedule</div>
                <div class="pv-col-body">
                    <div class="pv-row"><div class="pv-lbl">Visit Date</div><div class="pv-val"><strong><?=date('d M Y (l)', strtotime($d->visit_date))?></strong></div></div>
                    <div class="pv-row"><div class="pv-lbl">Time From</div><div class="pv-val"><?=htmlspecialchars($d->visit_time_from)?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Time To</div><div class="pv-val"><?=htmlspecialchars($d->visit_time_to)?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Access Zone</div><div class="pv-val"><?=htmlspecialchars($zone_name ?: 'General Access')?></div></div>
                    <div style="margin-top:10px;">
                        <div class="pv-lbl mb-1">Purpose of Visit</div>
                        <div class="pv-purpose"><?=nl2br(htmlspecialchars($d->visit_purpose ?: '—'))?></div>
                    </div>
                    <? if($d->remarks){ ?>
                    <div style="margin-top:8px;font-size:12px;color:#6b7280;">
                        <strong>Remarks:</strong> <?=nl2br(htmlspecialchars($d->remarks))?>
                    </div>
                    <? } ?>
                </div>
            </div>
            </div>

            <div class="col-sm-4 pl-1 mb-2">
            <div class="pv-col">
                <div class="pv-col-head"><i class="fa-solid fa-user-tie fa-xs mr-1"></i> Host Details</div>
                <div class="pv-col-body">
                    <div class="pv-row"><div class="pv-lbl">Host Name</div><div class="pv-val"><strong><?=htmlspecialchars($host ? $host->PBI_NAME : '—')?></strong></div></div>
                    <div class="pv-row"><div class="pv-lbl">Designation</div><div class="pv-val"><?=htmlspecialchars($d->host_designation ?: '—')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Department</div><div class="pv-val"><?=htmlspecialchars($department ?: '—')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Mobile</div><div class="pv-val"><?=htmlspecialchars($d->host_mobile ?: '—')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Email</div><div class="pv-val" style="font-size:12px;"><?=htmlspecialchars($d->host_email ?: '—')?></div></div>
                </div>
            </div>
            </div>

        </div>

        <div class="pv-audit">
            <i class="fa-solid fa-clock-rotate-left mr-1"></i>
            Registered by <strong><?=htmlspecialchars($entry_user ? $entry_user->fname : '#'.$d->entry_by)?></strong>
            on <?=date('d M Y, H:i', strtotime($d->entry_at))?>
            <? if($appr_user && $d->approved_at){ ?>
            &nbsp;·&nbsp;
            <?=$d->approval_status?> by <strong><?=htmlspecialchars($appr_user->fname)?></strong>
            on <?=date('d M Y, H:i', strtotime($d->approved_at))?>
            <? } ?>
        </div>

    </div>
</div>

</form>
</div>

<div id="img-lb" onclick="lbClose()">
    <span class="lb-x" onclick="lbClose()">&times;</span>
    <img id="lb-img" src="" alt="" onclick="event.stopPropagation()">
</div>
<script>
function lbOpen(src){ document.getElementById('lb-img').src=src; document.getElementById('img-lb').classList.add('show'); }
function lbClose(){ document.getElementById('img-lb').classList.remove('show'); document.getElementById('lb-img').src=''; }
document.addEventListener('keydown',function(e){ if(e.key==='Escape') lbClose(); });
</script>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>