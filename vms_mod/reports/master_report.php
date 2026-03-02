<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();
$c_id = $_SESSION['proj_id'];
date_default_timezone_set('Asia/Dhaka');

$report_no       = isset($_REQUEST['report'])           ? intval($_REQUEST['report'])                                    : 0;
$f_date          = isset($_REQUEST['f_date'])           ? $_REQUEST['f_date']                                            : date('Y-m-01');
$t_date          = isset($_REQUEST['t_date'])           ? $_REQUEST['t_date']                                            : date('Y-m-d');
$visitor_type_id = isset($_REQUEST['visitor_type_id'])  ? intval($_REQUEST['visitor_type_id'])                           : 0;
$zone_id         = isset($_REQUEST['zone_id'])          ? intval($_REQUEST['zone_id'])                                   : 0;
$approval_status = isset($_REQUEST['approval_status'])  ? mysqli_real_escape_string($conn, $_REQUEST['approval_status']) : '';
$visitor_status  = isset($_REQUEST['visitor_status'])   ? mysqli_real_escape_string($conn, $_REQUEST['visitor_status'])  : '';
$card_status     = isset($_REQUEST['card_status'])      ? mysqli_real_escape_string($conn, $_REQUEST['card_status'])     : '';
$visitor_mobile  = isset($_REQUEST['visitor_mobile'])   ? mysqli_real_escape_string($conn, $_REQUEST['visitor_mobile'])  : '';

$con  = " AND v.visit_date BETWEEN '$f_date' AND '$t_date'";
$con .= $visitor_type_id ? " AND v.visitor_type_id = $visitor_type_id"         : '';
$con .= $zone_id         ? " AND v.zone_id = $zone_id"                         : '';
$con .= $approval_status ? " AND v.approval_status = '$approval_status'"       : '';
$con .= $visitor_status  ? " AND v.visitor_status = '$visitor_status'"         : '';
$con .= $card_status     ? " AND v.card_status = '$card_status'"               : '';
$con .= $visitor_mobile  ? " AND v.visitor_mobile LIKE '%$visitor_mobile%'"    : '';

$report_titles = [
    11 => 'Visitor Summary Report',
    22 => 'Access Log Report',
    33 => 'Card Usage Report',
];
$report_title   = $report_titles[$report_no] ?? 'VMS Report';
$company_name   = $_SESSION['company_name'] ?? '';
$reporting_time = date("h:i A d-m-Y");
$period_label   = "Period: $f_date To $t_date";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?= htmlspecialchars($report_title) ?></title>
<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />
<?php require_once "../../../controllers/core/inc.exporttable.php"; ?>
<style type="text/css" media="print">
  div.page { page-break-after:always; page-break-inside:avoid; }
  @page { margin:8mm; }
</style>
<style>
  body  { margin:0 !important; font-family:'Segoe UI',Arial,sans-serif; font-size:12px; }
  .rpt-header { text-align:center; margin-bottom:8px; border-bottom:2px solid #2c3e50; padding-bottom:6px; }
  .rpt-header h1 { font-size:16px; color:#2c3e50; margin:0; }
  .rpt-header h2 { font-size:13px; color:#34495e; margin:2px 0; font-weight:normal; }
  .rpt-header .rpt-meta { font-size:11px; color:#7f8c8d; margin-top:4px; }
  #ExportTable { width:100%; border-collapse:collapse; }
  #ExportTable thead tr th {
    background:#2c3e50; color:#fff; padding:6px 8px;
    text-align:center; font-size:11px; position:sticky; top:0; z-index:1;
    border:1px solid #243342;
  }
  #ExportTable tbody tr td { padding:5px 8px; border:1px solid #dce1e7; vertical-align:middle; }
  #ExportTable tbody tr:nth-child(even) { background:#f7f9fc; }
  #ExportTable tbody tr:hover { background:#eaf2ff; }
  .tfoot-row td { background:#ecf0f1; font-weight:bold; border-top:2px solid #2c3e50; }
  .badge        { display:inline-block; padding:2px 7px; border-radius:10px; font-size:10px; font-weight:600; }
  .badge-green  { background:#d4edda; color:#155724; }
  .badge-blue   { background:#cce5ff; color:#004085; }
  .badge-red    { background:#f8d7da; color:#721c24; }
  .badge-yellow { background:#fff3cd; color:#856404; }
  .badge-grey   { background:#e2e3e5; color:#383d41; }
  .badge-orange { background:#ffe5b4; color:#7d4e00; }
  .text-r { text-align:right; }
  .text-c { text-align:center; }
  .print-btn { text-align:center; margin:10px 0; }
  .print-btn button { padding:6px 20px; background:#2c3e50; color:#fff; border:none; border-radius:4px; cursor:pointer; font-size:13px; }
  @media print { .print-btn { display:none; } }
</style>
<script>
function hidePrint(){ document.getElementById('printBtn').style.display='none'; }
</script>
</head>
<body>

<?php
// ── Shared Report Header ───────────────────────────────────
echo '<div class="rpt-header">';
if ($company_name) echo "<h1>" . htmlspecialchars($company_name) . "</h1>";
echo "<h2>" . htmlspecialchars($report_title) . "</h2>";
echo "<div class='rpt-meta'>$period_label &nbsp;|&nbsp; Reporting Time: $reporting_time</div>";
echo '</div>';

if ($visitor_type_id) {
    $vt_name = find_a_field('vms_visitor_type','visitor_type_name',"id=$visitor_type_id");
    echo "<div style='text-align:center;font-size:11px;color:#555;margin-bottom:6px;'>Visitor Type: <strong>".htmlspecialchars($vt_name)."</strong></div>";
}
if ($zone_id) {
    $zn_name = find_a_field('vms_access_zone','zone_name',"id=$zone_id");
    echo "<div style='text-align:center;font-size:11px;color:#555;margin-bottom:6px;'>Zone: <strong>".htmlspecialchars($zn_name)."</strong></div>";
}
if ($approval_status) echo "<div style='text-align:center;font-size:11px;color:#555;margin-bottom:6px;'>Approval Status: <strong>$approval_status</strong></div>";
if ($visitor_status)  echo "<div style='text-align:center;font-size:11px;color:#555;margin-bottom:6px;'>Visitor Status: <strong>$visitor_status</strong></div>";
if ($card_status)     echo "<div style='text-align:center;font-size:11px;color:#555;margin-bottom:6px;'>Card Status: <strong>$card_status</strong></div>";

// ── Badge helper ───────────────────────────────────────────
function status_badge($val) {
    $map = [
        'Approved'     => 'badge-green',   'CheckedIn'    => 'badge-blue',
        'CheckedOut'   => 'badge-grey',    'Pending'      => 'badge-yellow',
        'Rejected'     => 'badge-red',     'Expired'      => 'badge-orange',
        'In'           => 'badge-blue',    'Out'          => 'badge-grey',
        'Overstay'     => 'badge-red',     'Assigned'     => 'badge-green',
        'Withdrawn'    => 'badge-grey',    'Not Assigned' => 'badge-yellow',
    ];
    $cls = $map[$val] ?? 'badge-grey';
    return "<span class='badge $cls'>" . htmlspecialchars($val) . "</span>";
}
?>


<?php
/* ══════════════════════════════════════════════════════════
   REPORT 11  –  VISITOR SUMMARY
   Columns: #, Visitor No, Name, Mobile, Type, Visit Date,
            Purpose, Host, Zone, Card No, Check-In,
            Check-Out, Approval, Status
   ══════════════════════════════════════════════════════════ */
if ($report_no == 11) :

$sql = "SELECT
            v.visitor_no,
            v.visitor_name,
            v.visitor_mobile,
            vt.visitor_type_name,
            v.visit_date,
            v.visit_purpose,
            pb.PBI_NAME  AS host_name,
            az.zone_name,
            v.card_no,
            v.check_in_date,
            v.check_in_time,
            v.check_out_date,
            v.check_out_time,
            v.approval_status,
            v.visitor_status
        FROM vms_visitor_master v
        LEFT JOIN vms_visitor_type          vt ON vt.id      = v.visitor_type_id
        LEFT JOIN vms_access_zone           az ON az.id      = v.zone_id
        LEFT JOIN user_activity_management  um ON um.user_id = v.host_pbi_id
        LEFT JOIN personnel_basic_info      pb ON pb.PBI_ID  = um.PBI_ID
        WHERE 1
        $con
        ORDER BY v.visit_date DESC, v.id DESC";

$query = db_query($sql);
$total = 0;
?>

<table id="ExportTable" cellspacing="0" cellpadding="0">
<thead>
<tr>
  <th>S/L</th>
  <th>Visitor No</th>
  <th>Visitor Name</th>
  <th>Mobile</th>
  <th>Visitor Type</th>
  <th>Visit Date</th>
  <th>Purpose</th>
  <th>Host Name</th>
  <th>Zone</th>
  <th>Card No</th>
  <th>Check-In</th>
  <th>Check-Out</th>
  <th>Approval Status</th>
  <th>Visitor Status</th>
</tr>
</thead>
<tbody>
<?php while($d = mysqli_fetch_object($query)) { $s++; $total++; ?>
<tr>
  <td class="text-c"><?= $s ?></td>
  <td class="text-c"><strong><?= htmlspecialchars($d->visitor_no) ?></strong></td>
  <td><?= htmlspecialchars($d->visitor_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->visitor_mobile) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->visitor_type_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->visit_date) ?></td>
  <td><?= htmlspecialchars($d->visit_purpose) ?></td>
  <td><?= htmlspecialchars($d->host_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->zone_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->card_no) ?: '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= $d->check_in_date  ? htmlspecialchars($d->check_in_date  . ' ' . $d->check_in_time)  : '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= $d->check_out_date ? htmlspecialchars($d->check_out_date . ' ' . $d->check_out_time) : '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= status_badge($d->approval_status) ?></td>
  <td class="text-c"><?= status_badge($d->visitor_status) ?></td>
</tr>
<?php } ?>
</tbody>
<tfoot>
<tr class="tfoot-row">
  <td colspan="13" class="text-r">Total Visitors:</td>
  <td class="text-c"><strong><?= $total ?></strong></td>
</tr>
</tfoot>
</table>

<?php
/* ══════════════════════════════════════════════════════════
   REPORT 22  –  ACCESS LOG
   Columns: #, Visitor No, Name, Type, Visit Date, Host,
            Zone, Card No, Check-In, Check-Out, Duration,
            Approval, Status
   ══════════════════════════════════════════════════════════ */
elseif ($report_no == 22) :

$sql = "SELECT
            v.visitor_no,
            v.visitor_name,
            vt.visitor_type_name,
            v.visit_date,
            pb.PBI_NAME  AS host_name,
            az.zone_name,
            v.card_no,
            v.check_in_date,
            v.check_in_time,
            v.check_out_date,
            v.check_out_time,
            CASE
                WHEN v.check_in_time IS NOT NULL AND v.check_out_time IS NOT NULL
                THEN TIMEDIFF(v.check_out_time, v.check_in_time)
                ELSE NULL
            END AS duration,
            v.approval_status,
            v.visitor_status
        FROM vms_visitor_master v
        LEFT JOIN vms_visitor_type          vt ON vt.id      = v.visitor_type_id
        LEFT JOIN vms_access_zone           az ON az.id      = v.zone_id
        LEFT JOIN user_activity_management  um ON um.user_id = v.host_pbi_id
        LEFT JOIN personnel_basic_info      pb ON pb.PBI_ID  = um.PBI_ID
        WHERE 1
        $con
        ORDER BY v.visit_date DESC, v.check_in_time DESC, v.id DESC";

$query = db_query($sql);
$total_in = $total_out = $total_overstay = 0;
?>

<table id="ExportTable" cellspacing="0" cellpadding="0">
<thead>
<tr>
  <th>S/L</th>
  <th>Visitor No</th>
  <th>Visitor Name</th>
  <th>Visitor Type</th>
  <th>Visit Date</th>
  <th>Host Name</th>
  <th>Zone</th>
  <th>Card No</th>
  <th>Check-In</th>
  <th>Check-Out</th>
  <th>Duration (HH:MM:SS)</th>
  <th>Approval Status</th>
  <th>Visitor Status</th>
</tr>
</thead>
<tbody>
<?php while($d = mysqli_fetch_object($query)) {
    $s++;
    if     ($d->visitor_status == 'In')       $total_in++;
    elseif ($d->visitor_status == 'Out')      $total_out++;
    elseif ($d->visitor_status == 'Overstay') $total_overstay++;
?>
<tr>
  <td class="text-c"><?= $s ?></td>
  <td class="text-c"><strong><?= htmlspecialchars($d->visitor_no) ?></strong></td>
  <td><?= htmlspecialchars($d->visitor_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->visitor_type_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->visit_date) ?></td>
  <td><?= htmlspecialchars($d->host_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->zone_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->card_no) ?: '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= $d->check_in_date  ? htmlspecialchars($d->check_in_date  . ' ' . $d->check_in_time)  : '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= $d->check_out_date ? htmlspecialchars($d->check_out_date . ' ' . $d->check_out_time) : '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= $d->duration ? htmlspecialchars($d->duration) : '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= status_badge($d->approval_status) ?></td>
  <td class="text-c"><?= status_badge($d->visitor_status) ?></td>
</tr>
<?php } ?>
</tbody>
<tfoot>
<tr class="tfoot-row">
  <td colspan="10" class="text-r">
    Currently In: <strong><?= $total_in ?></strong> &nbsp;|&nbsp;
    Out: <strong><?= $total_out ?></strong> &nbsp;|&nbsp;
    Overstay: <strong style="color:#c0392b"><?= $total_overstay ?></strong>
  </td>
  <td colspan="3" class="text-r">Total Records: <strong><?= $s ?></strong></td>
</tr>
</tfoot>
</table>

<?php
/* ══════════════════════════════════════════════════════════
   REPORT 33  –  CARD USAGE
   Columns: #, Card No, Card Type, Card Status, Visitor No,
            Name, Type, Visit Date, Host, Zone,
            Check-In, Check-Out, Duration, Status
   ══════════════════════════════════════════════════════════ */
elseif ($report_no == 33) :

$sql = "SELECT
            v.card_no,
            c.card_type,
            v.card_status,
            v.visitor_no,
            v.visitor_name,
            vt.visitor_type_name,
            v.visit_date,
            pb.PBI_NAME  AS host_name,
            az.zone_name,
            v.check_in_date,
            v.check_in_time,
            v.check_out_date,
            v.check_out_time,
            CASE
                WHEN v.check_in_time IS NOT NULL AND v.check_out_time IS NOT NULL
                THEN TIMEDIFF(v.check_out_time, v.check_in_time)
                ELSE NULL
            END AS duration,
            v.visitor_status
        FROM vms_visitor_master v
        LEFT JOIN vms_visitor_type          vt ON vt.id      = v.visitor_type_id
        LEFT JOIN vms_access_zone           az ON az.id      = v.zone_id
        LEFT JOIN user_activity_management  um ON um.user_id = v.host_pbi_id
        LEFT JOIN personnel_basic_info      pb ON pb.PBI_ID  = um.PBI_ID
        LEFT JOIN vms_card_pool             c  ON c.id       = v.card_id
        WHERE 1
        $con
        ORDER BY v.visit_date DESC, v.id DESC";

$query = db_query($sql);
$cnt_assigned = $cnt_withdrawn = $cnt_not_assigned = 0;
?>

<table id="ExportTable" cellspacing="0" cellpadding="0">
<thead>
<tr>
  <th>S/L</th>
  <th>Card No</th>
  <th>Card Type</th>
  <th>Card Status</th>
  <th>Visitor No</th>
  <th>Visitor Name</th>
  <th>Visitor Type</th>
  <th>Visit Date</th>
  <th>Host Name</th>
  <th>Zone</th>
  <th>Check-In</th>
  <th>Check-Out</th>
  <th>Duration (HH:MM:SS)</th>
  <th>Visitor Status</th>
</tr>
</thead>
<tbody>
<?php while($d = mysqli_fetch_object($query)) {
    $s++;
    if     ($d->card_status == 'Assigned')  $cnt_assigned++;
    elseif ($d->card_status == 'Withdrawn') $cnt_withdrawn++;
    else                                    $cnt_not_assigned++;
?>
<tr>
  <td class="text-c"><?= $s ?></td>
  <td class="text-c"><strong><?= htmlspecialchars($d->card_no) ?: '<span style="color:#bbb">—</span>' ?></strong></td>
  <td class="text-c"><?= htmlspecialchars($d->card_type) ?></td>
  <td class="text-c"><?= status_badge($d->card_status) ?></td>
  <td class="text-c"><strong><?= htmlspecialchars($d->visitor_no) ?></strong></td>
  <td><?= htmlspecialchars($d->visitor_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->visitor_type_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->visit_date) ?></td>
  <td><?= htmlspecialchars($d->host_name) ?></td>
  <td class="text-c"><?= htmlspecialchars($d->zone_name) ?></td>
  <td class="text-c"><?= $d->check_in_date  ? htmlspecialchars($d->check_in_date  . ' ' . $d->check_in_time)  : '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= $d->check_out_date ? htmlspecialchars($d->check_out_date . ' ' . $d->check_out_time) : '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= $d->duration ? htmlspecialchars($d->duration) : '<span style="color:#bbb">—</span>' ?></td>
  <td class="text-c"><?= status_badge($d->visitor_status) ?></td>
</tr>
<?php } ?>
</tbody>
<tfoot>
<tr class="tfoot-row">
  <td colspan="11" class="text-r">
    Assigned: <strong style="color:#155724"><?= $cnt_assigned ?></strong> &nbsp;|&nbsp;
    Withdrawn: <strong><?= $cnt_withdrawn ?></strong> &nbsp;|&nbsp;
    Not Assigned: <strong style="color:#856404"><?= $cnt_not_assigned ?></strong>
  </td>
  <td colspan="3" class="text-r">Total Records: <strong><?= $s ?></strong></td>
</tr>
</tfoot>
</table>

<?php
endif;
?>

</body>
</html>

<?php
$page_name = $_POST['report'] . $report_title . " (VMS Master Report)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>