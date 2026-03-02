<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Visitor Status';
$page    = 'visitor_status.php';

do_datatable('table_head');
do_calander('#f_date');

if(isset($_GET['msg'])) nibirToast($_GET['msg']);

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];

// -- Filter conditions -------------------------------------------------------
$con = '';
if(isset($_POST['submitit'])){
    if(!empty($_POST['f_date']))   $con .= " AND v.visit_date='".addslashes($_POST['f_date'])."'";
    if(!empty($_POST['f_name']))   $con .= " AND v.visitor_name LIKE '%".addslashes($_POST['f_name'])."%'";
    if(!empty($_POST['f_status'])) $con .= " AND v.approval_status='".addslashes($_POST['f_status'])."'";
}

// -- Summary counts ----------------------------------------------------------
$cnt_total      = find_a_field('vms_visitor_master','COUNT(id)',"group_for='".$grp."'");
$cnt_approved   = find_a_field('vms_visitor_master','COUNT(id)',"approval_status='Approved'   AND group_for='".$grp."'");
$cnt_checkedin  = find_a_field('vms_visitor_master','COUNT(id)',"approval_status='CheckedIn'  AND group_for='".$grp."'");
$cnt_checkedout = find_a_field('vms_visitor_master','COUNT(id)',"approval_status='CheckedOut' AND group_for='".$grp."'");

// -- Main query --------------------------------------------------------------
$sql = "SELECT v.*,
               u.fname  AS host_name,
               z.zone_name
        FROM vms_visitor_master v
        LEFT JOIN user_activity_management u ON u.user_id = v.host_pbi_id
        LEFT JOIN vms_access_zone z           ON z.id      = v.zone_id
        WHERE v.group_for='".$grp."' ".$con."
        ORDER BY v.id DESC";
$query = db_query($sql);
?>

<div class="form-container_large">
<form action="<?=$page?>" method="post" name="codz" id="codz">

<!-- -- Filter Bar -- -->
<div class="container-fluid bg-form-titel">
<div class="row">

    <div class="col-sm-2 pt-1 pb-1">
        <div class="form-group row m-0">
            <label class="col-sm-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date</label>
            <div class="col-sm-8 p-0 pr-2">
                <input type="text" name="f_date" id="f_date" class="form-control" autocomplete="off"
                       value="<?=isset($_POST['f_date'])?htmlspecialchars($_POST['f_date']):''?>">
            </div>
        </div>
    </div>

    <div class="col-sm-3 pt-1 pb-1">
        <div class="form-group row m-0">
            <label class="col-sm-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Name</label>
            <div class="col-sm-8 p-0 pr-2">
                <input type="text" name="f_name" class="form-control" autocomplete="off"
                       value="<?=isset($_POST['f_name'])?htmlspecialchars($_POST['f_name']):''?>">
            </div>
        </div>
    </div>

    <div class="col-sm-3 pt-1 pb-1">
        <div class="form-group row m-0">
            <label class="col-sm-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Status</label>
            <div class="col-sm-8 p-0 pr-2">
                <select name="f_status" id="f_status" class="form-control">
                    <option value="">-- All --</option>
                    <option value="Approved"   <?=(isset($_POST['f_status'])&&$_POST['f_status']=='Approved')  ?'selected':''?>>Approved</option>
                    <option value="CheckedIn"  <?=(isset($_POST['f_status'])&&$_POST['f_status']=='CheckedIn') ?'selected':''?>>Checked In</option>
                    <option value="CheckedOut" <?=(isset($_POST['f_status'])&&$_POST['f_status']=='CheckedOut')?'selected':''?>>Checked Out</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-2 pt-1 pb-1 d-flex align-items-center">
        <input type="submit" name="submitit" value="Search" class="btn1 btn1-submit-input w-100">
    </div>

</div>
</div>

<!-- -- Summary Boxes -- -->
<div class="container-fluid py-2 px-1">
<div class="row">
    <div class="col-sm-3 p-1">
        <div style="background:#343a40;color:#fff;border-radius:6px;padding:10px 14px;display:flex;align-items:center;gap:12px;">
            <i class="fa-solid fa-users" style="font-size:24px;opacity:.7;"></i>
            <div><div style="font-size:24px;font-weight:700;"><?=$cnt_total?></div><div style="font-size:11px;">Total Visitors</div></div>
        </div>
    </div>
    <div class="col-sm-3 p-1">
        <div style="background:#28a745;color:#fff;border-radius:6px;padding:10px 14px;display:flex;align-items:center;gap:12px;">
            <i class="fa-solid fa-circle-check" style="font-size:24px;opacity:.7;"></i>
            <div><div style="font-size:24px;font-weight:700;"><?=$cnt_approved?></div><div style="font-size:11px;">Approved</div></div>
        </div>
    </div>
    <div class="col-sm-3 p-1">
        <div style="background:#17a2b8;color:#fff;border-radius:6px;padding:10px 14px;display:flex;align-items:center;gap:12px;">
            <i class="fa-solid fa-right-to-bracket" style="font-size:24px;opacity:.7;"></i>
            <div><div style="font-size:24px;font-weight:700;"><?=$cnt_checkedin?></div><div style="font-size:11px;">Checked In</div></div>
        </div>
    </div>
    <div class="col-sm-3 p-1">
        <div style="background:#6c757d;color:#fff;border-radius:6px;padding:10px 14px;display:flex;align-items:center;gap:12px;">
            <i class="fa-solid fa-right-from-bracket" style="font-size:24px;opacity:.7;"></i>
            <div><div style="font-size:24px;font-weight:700;"><?=$cnt_checkedout?></div><div style="font-size:11px;">Checked Out</div></div>
        </div>
    </div>
</div>
</div>

<!-- -- Main Table -- -->
<div class="container-fluid pt-1 p-0">
<table id="table_head" class="table1 table-striped table-bordered table-hover table-sm" cellspacing="0">
    <thead class="thead1">
    <tr class="bgc-info">
        <th>#</th>
        <th>Visitor No</th>
        <th>Visitor Name</th>
        <th>Mobile</th>
        <th>Company</th>
        <th>Host</th>
        <th>Zone</th>
        <th>Visit Date</th>
        <th>Check-In Time</th>
        <th>Check-Out Time</th>
        <th>Card</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody class="tbody1">
    <?php
    $bc = [
        'Approved'   => '#28a745',
        'CheckedIn'  => '#17a2b8',
        'CheckedOut' => '#6c757d',
        'Pending'    => '#f0ad4e',
        'Rejected'   => '#dc3545',
    ];
    $sl = 1;
    if($query) while($row = mysqli_fetch_object($query)){
        $bg = isset($bc[$row->approval_status]) ? $bc[$row->approval_status] : '#6c757d';
    ?>
    <tr>
        <td><?=$sl++?></td>
        <td style="font-weight:600;"><?=htmlspecialchars($row->visitor_no)?></td>
        <td style="text-align:left;font-weight:600;"><?=htmlspecialchars($row->visitor_name)?></td>
        <td><?=htmlspecialchars($row->visitor_mobile ?: '-')?></td>
        <td style="text-align:left;"><?=htmlspecialchars($row->visitor_company ?: '-')?></td>
        <td style="text-align:left;"><?=!empty($row->host_name)  ? htmlspecialchars($row->host_name)  : '-'?></td>
        <td><?=!empty($row->zone_name) ? htmlspecialchars($row->zone_name) : '-'?></td>
        <td style="white-space:nowrap;"><?=htmlspecialchars($row->visit_date ?: '-')?></td>
        <td style="white-space:nowrap;"><?=!empty($row->check_in_time)  ? htmlspecialchars($row->check_in_time)  : '-'?></td>
        <td style="white-space:nowrap;"><?=!empty($row->check_out_time) ? htmlspecialchars($row->check_out_time) : '-'?></td>
        <td>
            <?php if(!empty($row->card_no)){ ?>
            <span style="background:#17a2b8;color:#fff;padding:2px 8px;border-radius:3px;font-size:11px;font-weight:600;">
                <?=htmlspecialchars($row->card_no)?>
            </span>
            <?php } else { echo '-'; } ?>
        </td>
        <td>
            <span style="background:<?=$bg?>;color:#fff;padding:2px 8px;border-radius:3px;font-size:11px;font-weight:600;">
                <?=htmlspecialchars($row->approval_status)?>
            </span>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
</div>

</form>
</div>

<?php
selected_two('#f_status');
require_once SERVER_CORE."routing/layout.bottom.php";
?>