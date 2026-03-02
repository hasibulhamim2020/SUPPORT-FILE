<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Pre-Registration View';
$table   = 'vms_pre_registration';
$unique  = 'id';
$page    = 'visitor_pre_reg_view.php';

if(isset($_GET['msg'])) nibirToast($_GET['msg']);

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];
$id  = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

if($id < 1){
    echo "<div class='alert alert-warning m-3'>No record selected. <a href='visitor_pre_registration.php'>Go back</a></div>";
    require_once SERVER_CORE."routing/layout.bottom.php"; exit;
}

if(prevent_multi_submit()){

    if(isset($_POST['approve'])){
        $now = date('Y-m-d H:i:s');
        $pre = mysqli_fetch_object(db_query("SELECT * FROM ".$table." WHERE id=".$id." AND group_for='".$grp."' LIMIT 1"));

        db_query("UPDATE ".$table." SET status='Approved', approved_by=".$uid.", approved_at='".$now."' WHERE id=".$id." AND group_for='".$grp."'");

        $chk = find_a_field('vms_visitor_master','id','pre_reg_id='.$id);
        if(!$chk){
            $seq        = mysqli_fetch_row(db_query("SELECT COUNT(id) FROM vms_visitor_master WHERE 1"));
            $visitor_no = 'VIS-'.date('Y').'-'.str_pad(($seq[0]+1), 5, '0', STR_PAD_LEFT);

            $sql = "INSERT INTO vms_visitor_master (
                visitor_no, pre_reg_id, pre_reg_no, company_id, group_for,
                visitor_name, visitor_mobile, visitor_email, visitor_company,
                visitor_id_type, visitor_id_no,
                visitor_in_image, visitor_id_doc_img, visitor_id_up_doc_img,
                visitor_type_id, visit_purpose,
                visit_date, visit_time_from, visit_time_to,
                host_pbi_id, host_designation, host_department,
                host_mobile, host_email, zone_id,
                approval_status, approved_by, approved_at, remarks,
                card_id, card_no,
                check_in_date, check_in_time, expected_out_time,
                visitor_outing_remark, visitor_status,
                notification_sent, entry_by, entry_at
            ) VALUES (
                '".addslashes($visitor_no)."', ".$id.", '".addslashes($pre->pre_reg_no)."',
                ".$pre->company_id.", ".$pre->group_for.",
                '".addslashes($pre->visitor_name)."', '".addslashes($pre->visitor_mobile)."',
                '".addslashes($pre->visitor_email)."', '".addslashes($pre->visitor_company)."',
                '".addslashes($pre->visitor_id_type)."', '".addslashes($pre->visitor_id_number)."',
                '', '', '',
                ".$pre->visitor_type_id.", '".addslashes($pre->visit_purpose)."',
                '".$pre->visit_date."', '".$pre->visit_time_from."', '".$pre->visit_time_to."',
                ".$pre->host_pbi_id.", '".addslashes($pre->host_designation)."', '".addslashes($pre->host_department)."',
                '".addslashes($pre->host_mobile)."', '".addslashes($pre->host_email)."', ".$pre->zone_id.",
                'Pending', ".$uid.", '".$now."', '".addslashes($pre->remarks)."',
                0, '',
                '".$pre->visit_date."', '".$pre->visit_date." ".$pre->visit_time_from."', '".$pre->visit_date." ".$pre->visit_time_to."',
                '', '', 'No', ".$uid.", '".$now."'
            )";
            db_query($sql);
        }
        header("Location: visitor_unapproved_view.php"); exit;
    }

    if(isset($_POST['reject'])){
        db_query("UPDATE ".$table." SET status='Rejected', approved_by=".$uid.", approved_at='".date('Y-m-d H:i:s')."' WHERE id=".$id." AND group_for='".$grp."'");
        header("Location: visitor_unapproved_view.php"); exit;
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
$entry_user = find_all_field('user_activity_management', '', 'user_id='.(int)$d->entry_by);
$appr_user  = $d->approved_by ? find_all_field('user_activity_management', '', 'user_id='.(int)$d->approved_by) : null;
$vtype_name = find_a_field('vms_visitor_type', 'visitor_type_name', 'id='.(int)$d->visitor_type_id);
$zone_name  = find_a_field('vms_access_zone',  'zone_name',         'id='.(int)$d->zone_id);

$badge_map = ['Pending'=>'warning','Approved'=>'success','Rejected'=>'danger','CheckedIn'=>'info','Expired'=>'secondary'];
$badge     = isset($badge_map[$d->status]) ? $badge_map[$d->status] : 'secondary';
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
@media print {
    .pv-btn-bar { display:none !important; }
    .pv-header  { -webkit-print-color-adjust:exact; print-color-adjust:exact; border-radius:0; }
    body        { background:#fff !important; }
}
</style>

<div class="form-container_large">
<form action="<?=$page?>" method="post" name="codz" id="codz">
<input type="hidden" name="id" value="<?=$id?>">

<div style="margin:14px;">
    <div class="pv-header">
        <div>
            <div class="pv-header-title"><i class="fa-solid fa-id-card-clip mr-2"></i>Visitor Pre-Registration</div>
            <div class="pv-header-sub">Ref: <?=htmlspecialchars($d->pre_reg_no)?> &nbsp;·&nbsp; Submitted: <?=date('d M Y', strtotime($d->entry_at))?></div>
        </div>
        <div class="col-sm-6 text-right pv-btn-bar">
            <? if($d->status == 'Pending'){ ?>
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
            <?=strtoupper($d->status)?>
        </span>
    </div>

    <div class="pv-body">
        <div class="row">

            <div class="col-sm-4 pr-1 mb-2">
            <div class="pv-col">
                <div class="pv-col-head"><i class="fa-solid fa-user fa-xs mr-1"></i> Visitor Information</div>
                <div class="pv-col-body">
                    <div class="pv-row"><div class="pv-lbl">Full Name</div><div class="pv-val"><strong><?=htmlspecialchars($d->visitor_name)?></strong></div></div>
                    <div class="pv-row"><div class="pv-lbl">Visitor Type</div><div class="pv-val"><?=htmlspecialchars($vtype_name ?: '-')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Mobile</div><div class="pv-val"><?=htmlspecialchars($d->visitor_mobile ?: '-')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Email</div><div class="pv-val" style="font-size:12px;"><?=htmlspecialchars($d->visitor_email ?: '-')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Organisation</div><div class="pv-val"><?=htmlspecialchars($d->visitor_company ?: '-')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">ID Type</div><div class="pv-val"><?=htmlspecialchars($d->visitor_id_type ?: '-')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">ID Number</div><div class="pv-val"><?=htmlspecialchars($d->visitor_id_number ?: '-')?></div></div>
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
                        <div class="pv-purpose"><?=nl2br(htmlspecialchars($d->visit_purpose ?: '-'))?></div>
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
                    <div class="pv-row"><div class="pv-lbl">Host Name</div><div class="pv-val"><strong><?=htmlspecialchars($host ? $host->PBI_NAME : '-')?></strong></div></div>
                    <div class="pv-row"><div class="pv-lbl">Designation</div><div class="pv-val"><?=htmlspecialchars($d->host_designation ?: '-')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Department</div><div class="pv-val"><?=htmlspecialchars($department ?: '-')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Mobile</div><div class="pv-val"><?=htmlspecialchars($d->host_mobile ?: '-')?></div></div>
                    <div class="pv-row"><div class="pv-lbl">Email</div><div class="pv-val" style="font-size:12px;"><?=htmlspecialchars($d->host_email ?: '-')?></div></div>
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
            <?=$d->status?> by <strong><?=htmlspecialchars($appr_user->fname)?></strong>
            on <?=date('d M Y, H:i', strtotime($d->approved_at))?>
            <? } ?>
        </div>

    </div>
</div>

</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>