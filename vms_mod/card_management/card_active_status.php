<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Card Status';
$page    = 'card_active_status.php';

do_datatable('table_head');

if(isset($_GET['msg'])) nibirToast($_GET['msg']);

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];

$con = '';
if(isset($_POST['submitit'])){
    if(!empty($_POST['f_card_no']))     $con .= " AND c.card_no LIKE '%".addslashes($_POST['f_card_no'])."%'";
    if(!empty($_POST['f_card_type']))   $con .= " AND c.card_type='".addslashes($_POST['f_card_type'])."'";
    if(!empty($_POST['f_card_status'])) $con .= " AND c.card_status='".addslashes($_POST['f_card_status'])."'";
}

$total     = find_a_field('vms_card_pool','COUNT(id)',"group_for='".$grp."'");
$assigned  = find_a_field('vms_card_pool','COUNT(id)',"card_status='Assigned'  AND group_for='".$grp."'");
$available = find_a_field('vms_card_pool','COUNT(id)',"card_status='Available' AND group_for='".$grp."'");
$damaged   = find_a_field('vms_card_pool','COUNT(id)',"card_status IN ('Lost','Damaged') AND group_for='".$grp."'");

$sql = "SELECT
            c.id AS card_id, c.card_no, c.card_type, c.card_status,
            v.visitor_no, v.visitor_name, v.visitor_mobile, v.check_in_date, v.approval_status,
            u.fname AS host_name,
            z.zone_name
        FROM vms_card_pool c
        LEFT JOIN vms_visitor_master v       ON v.card_id  = c.id AND v.approval_status = 'CheckedIn'
        LEFT JOIN user_activity_management u ON u.user_id  = v.host_pbi_id
        LEFT JOIN vms_access_zone z          ON z.id       = v.zone_id
        WHERE c.group_for='".$grp."' ".$con."
        ORDER BY c.card_no ASC";
$query = db_query($sql);

$badge_cls = [
    'Available' => 'vms-cb-available',
    'Assigned'  => 'vms-cb-assigned',
    'Lost'      => 'vms-cb-lost',
    'Damaged'   => 'vms-cb-damaged',
];
?>

<style>
.vms-stat           { border-radius:6px; padding:10px 14px; color:#fff; display:flex; align-items:center; gap:12px; }
.vms-stat-dark      { background:#343a40; }
.vms-stat-info      { background:#17a2b8; }
.vms-stat-success   { background:#28a745; }
.vms-stat-danger    { background:#dc3545; }
.vms-stat-icon      { font-size:24px; opacity:.7; }
.vms-stat-num       { font-size:24px; font-weight:700; line-height:1; }
.vms-stat-label     { font-size:11px; margin-top:2px; }
.vms-cb             { display:inline-block; padding:2px 8px; border-radius:3px; font-size:11px; font-weight:600; color:#fff; }
.vms-cb-available   { background:#28a745; }
.vms-cb-assigned    { background:#17a2b8; }
.vms-cb-lost        { background:#dc3545; }
.vms-cb-damaged     { background:#f0ad4e; }
.vms-cb-default     { background:#6c757d; }
.fw-600             { font-weight:600; }
</style>

<div class="form-container_large">
<form action="<?=$page?>" method="post" name="codz" id="codz">

<div class="container-fluid bg-form-titel">
<div class="row">

    <div class="col-sm-3 pt-1 pb-1">
        <div class="form-group row m-0">
            <label class="col-sm-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Card No</label>
            <div class="col-sm-8 p-0 pr-2">
                <input type="text" name="f_card_no" class="form-control" autocomplete="off"
                       value="<?=isset($_POST['f_card_no'])?htmlspecialchars($_POST['f_card_no']):''?>">
            </div>
        </div>
    </div>

    <div class="col-sm-3 pt-1 pb-1">
        <div class="form-group row m-0">
            <label class="col-sm-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Card Type</label>
            <div class="col-sm-8 p-0 pr-2">
                <select name="f_card_type" id="f_card_type" class="form-control">
                    <option value="">-- All --</option>
                    <option value="RFID"    <?=(isset($_POST['f_card_type'])&&$_POST['f_card_type']=='RFID')   ?'selected':''?>>RFID</option>
                    <option value="QR"      <?=(isset($_POST['f_card_type'])&&$_POST['f_card_type']=='QR')     ?'selected':''?>>QR</option>
                    <option value="Barcode" <?=(isset($_POST['f_card_type'])&&$_POST['f_card_type']=='Barcode')?'selected':''?>>Barcode</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-3 pt-1 pb-1">
        <div class="form-group row m-0">
            <label class="col-sm-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Status</label>
            <div class="col-sm-8 p-0 pr-2">
                <select name="f_card_status" id="f_card_status" class="form-control">
                    <option value="">-- All --</option>
                    <option value="Available" <?=(isset($_POST['f_card_status'])&&$_POST['f_card_status']=='Available')?'selected':''?>>Available</option>
                    <option value="Assigned"  <?=(isset($_POST['f_card_status'])&&$_POST['f_card_status']=='Assigned') ?'selected':''?>>Assigned</option>
                    <option value="Lost"      <?=(isset($_POST['f_card_status'])&&$_POST['f_card_status']=='Lost')     ?'selected':''?>>Lost</option>
                    <option value="Damaged"   <?=(isset($_POST['f_card_status'])&&$_POST['f_card_status']=='Damaged')  ?'selected':''?>>Damaged</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-2 pt-1 pb-1 d-flex align-items-center">
        <input type="submit" name="submitit" value="Search" class="btn1 btn1-submit-input w-100">
    </div>

</div>
</div>

<div class="container-fluid py-2 px-1">
<div class="row">
    <div class="col-sm-3 p-1">
        <div class="vms-stat vms-stat-dark">
            <i class="fa-solid fa-layer-group vms-stat-icon"></i>
            <div><div class="vms-stat-num"><?=$total?></div><div class="vms-stat-label">Total Cards</div></div>
        </div>
    </div>
    <div class="col-sm-3 p-1">
        <div class="vms-stat vms-stat-info">
            <i class="fa-solid fa-id-card vms-stat-icon"></i>
            <div><div class="vms-stat-num"><?=$assigned?></div><div class="vms-stat-label">Assigned</div></div>
        </div>
    </div>
    <div class="col-sm-3 p-1">
        <div class="vms-stat vms-stat-success">
            <i class="fa-solid fa-circle-check vms-stat-icon"></i>
            <div><div class="vms-stat-num"><?=$available?></div><div class="vms-stat-label">Available</div></div>
        </div>
    </div>
    <div class="col-sm-3 p-1">
        <div class="vms-stat vms-stat-danger">
            <i class="fa-solid fa-triangle-exclamation vms-stat-icon"></i>
            <div><div class="vms-stat-num"><?=$damaged?></div><div class="vms-stat-label">Lost / Damaged</div></div>
        </div>
    </div>
</div>
</div>

<div class="container-fluid pt-1 p-0">
<table id="table_head" class="table1 table-striped table-bordered table-hover table-sm" cellspacing="0">
    <thead class="thead1">
    <tr class="bgc-info">
        <th>#</th>
        <th>Card No</th>
        <th>Card Type</th>
        <th>Card Status</th>
        <th>Visitor No</th>
        <th>Visitor Name</th>
        <th>Mobile</th>
        <th>Host</th>
        <th>Access Zone</th>
        <th>Check-In Date</th>
    </tr>
    </thead>
    <tbody class="tbody1">
    <?
    $sl = 1;
    if($query) while($row = mysqli_fetch_object($query)){
        $bc = isset($badge_cls[$row->card_status]) ? $badge_cls[$row->card_status] : 'vms-cb-default';
    ?>
    <tr>
        <td><?=$sl++?></td>
        <td class="fw-600"><?=htmlspecialchars($row->card_no)?></td>
        <td><?=htmlspecialchars($row->card_type)?></td>
        <td><span class="vms-cb <?=$bc?>"><?=$row->card_status?></span></td>
        <td><?=!empty($row->visitor_no)     ? htmlspecialchars($row->visitor_no)     : '-'?></td>
        <td><?=!empty($row->visitor_name)   ? htmlspecialchars($row->visitor_name)   : '-'?></td>
        <td><?=!empty($row->visitor_mobile) ? htmlspecialchars($row->visitor_mobile) : '-'?></td>
        <td><?=!empty($row->host_name)      ? htmlspecialchars($row->host_name)      : '-'?></td>
        <td><?=!empty($row->zone_name)      ? htmlspecialchars($row->zone_name)      : '-'?></td>
        <td><?=!empty($row->check_in_date)  ? htmlspecialchars($row->check_in_date)  : '-'?></td>
    </tr>
    <? } ?>
    </tbody>
</table>
</div>

</form>
</div>

<?
selected_two('#f_card_type');
selected_two('#f_card_status');
require_once SERVER_CORE."routing/layout.bottom.php";
?>