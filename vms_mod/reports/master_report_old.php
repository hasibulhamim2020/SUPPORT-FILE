<?php


//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$_SESSION['execution_no'] = $_SESSION['user']['id'] . '0000' . time();
$tr_from = "VMS";

$c_id = $_SESSION['proj_id'];
date_default_timezone_set('Asia/Dhaka');

// ─────────────────────────────────────────────
// GUARD: Must have a valid report submission
// ─────────────────────────────────────────────
if (!isset($_REQUEST['submit']) || !isset($_REQUEST['report']) || (int)$_REQUEST['report'] <= 0) {
    echo '<div class="alert alert-warning m-3">No report selected.</div>';
    require_once SERVER_CORE."routing/layout.report.bottom.php";
    exit;
}

// ─────────────────────────────────────────────
// INPUT COLLECTION — match project pattern
// ENUMs/strings from <select>: strip_tags only
// Integers: cast with (int)
// Dates: validated by length check like existing master_report
// ─────────────────────────────────────────────
$report_no = (int)$_REQUEST['report'];

// Date — only accept if exactly 10 chars (YYYY-MM-DD), same as existing master_report.php
echo $f_date = (isset($_REQUEST['f_date']) && strlen($_REQUEST['f_date']) == 10)
            ? strip_tags($_REQUEST['f_date']) : date('Y-m-01');
$t_date = (isset($_REQUEST['t_date']) && strlen($_REQUEST['t_date']) == 10)
            ? strip_tags($_REQUEST['t_date']) : date('Y-m-d');

// Integer filters
echo $visitor_type_id = (isset($_REQUEST['visitor_type_id']) && (int)$_REQUEST['visitor_type_id'] > 0)
                    ? (int)$_REQUEST['visitor_type_id'] : 0;
echo $zone_id         = (isset($_REQUEST['zone_id']) && (int)$_REQUEST['zone_id'] > 0)
                    ? (int)$_REQUEST['zone_id'] : 0;

// ENUM filters — values come from controlled <select> dropdowns
// strip_tags is sufficient; whitelist check below adds safety
echo $approval_status = (isset($_REQUEST['approval_status']) && $_REQUEST['approval_status'] != '')
                    ? strip_tags($_REQUEST['approval_status']) : '';
echo $visitor_status  = (isset($_REQUEST['visitor_status'])  && $_REQUEST['visitor_status']  != '')
                    ? strip_tags($_REQUEST['visitor_status'])  : '';
echo $card_status     = (isset($_REQUEST['card_status'])     && $_REQUEST['card_status']     != '')
                    ? strip_tags($_REQUEST['card_status'])     : '';

// Whitelist ENUM values — reject anything not in the allowed list
$allowed_approval = ['Pending','Approved','Rejected','CheckedIn','CheckedOut','Expired'];
$allowed_visitor  = ['In','Out','Overstay'];
$allowed_card     = ['Not Assigned','Assigned','Withdrawn'];

if (!in_array($approval_status, $allowed_approval)) $approval_status = '';
if (!in_array($visitor_status,  $allowed_visitor))  $visitor_status  = '';
if (!in_array($card_status,     $allowed_card))     $card_status     = '';

// Mobile — numeric/short text field
$visitor_mobile = (isset($_REQUEST['visitor_mobile']) && $_REQUEST['visitor_mobile'] != '')
                    ? strip_tags(trim($_REQUEST['visitor_mobile'])) : '';

// ─────────────────────────────────────────────
// BUILD SHARED WHERE CONDITIONS
// ─────────────────────────────────────────────
echo $date_con            = " AND v.check_in_date BETWEEN '$f_date' AND '$t_date'";
echo $visitor_type_con    = ($visitor_type_id > 0)    ? " AND v.visitor_type_id = $visitor_type_id"       : '';
echo $zone_con            = ($zone_id > 0)            ? " AND v.zone_id = $zone_id"                       : '';
echo $approval_status_con = ($approval_status != '')  ? " AND v.approval_status = '$approval_status'"     : '';
echo $visitor_status_con  = ($visitor_status  != '')  ? " AND v.visitor_status = '$visitor_status'"       : '';
echo $card_status_con     = ($card_status     != '')  ? " AND v.card_status = '$card_status'"             : '';
echo $mobile_con          = ($visitor_mobile  != '')  ? " AND v.visitor_mobile LIKE '%$visitor_mobile%'"  : '';

$company_con = " AND v.company_id = $c_id";

$str    = '';
$report = '';
$sql    = '';

// ─────────────────────────────────────────────
// REPORT SWITCH
// ─────────────────────────────────────────────
switch ($report_no) {

    // ══════════════════════════════════════════
    // REPORT 11 — Visitor Summary
    // ══════════════════════════════════════════
    case 11:
	

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


        $report = "Visitor Summary Report";
        $str    = "Period: $f_date to $t_date";

        // Summary aggregation grouped by approval_status
        $sql_summary = "SELECT
                v.approval_status,
                COUNT(v.id)                                               AS total_visitors,
                COUNT(CASE WHEN v.pre_reg_id > 0  THEN 1 END)            AS pre_registered,
                COUNT(CASE WHEN v.pre_reg_id = 0  THEN 1 END)            AS walk_in,
                COUNT(CASE WHEN v.visitor_status = 'In'       THEN 1 END) AS currently_in,
                COUNT(CASE WHEN v.visitor_status = 'Out'      THEN 1 END) AS checked_out,
                COUNT(CASE WHEN v.visitor_status = 'Overstay' THEN 1 END) AS overstay
            FROM vms_visitor_master v
            WHERE 1=1
                $date_con
                $company_con
                $visitor_type_con
                $zone_con
                $approval_status_con
            GROUP BY v.approval_status
            ORDER BY v.approval_status";

        // Full detail listing
        $sql_detail = "SELECT
                v.visitor_no,
                v.pre_reg_no,
                v.visitor_name,
                v.visitor_mobile,
                v.visitor_company,
                vt.type_name        AS visitor_type,
                v.visit_purpose,
                v.visit_date,
                v.visit_time_from,
                v.visit_time_to,
                v.host_designation,
                v.host_department,
                az.zone_name        AS access_zone,
                v.approval_status,
                v.card_no,
                v.card_status,
                v.check_in_time,
                v.check_out_time,
                v.visitor_status
            FROM vms_visitor_master v
            LEFT JOIN vms_visitor_type vt ON vt.id = v.visitor_type_id
            LEFT JOIN vms_access_zone  az ON az.id = v.zone_id
            WHERE 1=1
                $date_con
                $company_con
                $visitor_type_con
                $zone_con
                $approval_status_con
                $visitor_status_con
                $mobile_con
            ORDER BY v.check_in_time DESC";

        // ── Execute summary query and accumulate grand totals ──
        $q_sum       = db_query($sql_summary);
        $grand_total = 0; $grand_pre = 0; $grand_walkin = 0;
        $grand_in    = 0; $grand_out = 0; $grand_over   = 0;
        $sum_rows    = [];
        while ($s = mysqli_fetch_object($q_sum)) { $sum_rows[] = $s; }

        foreach ($sum_rows as $s) {
            $grand_total  += (int)$s->total_visitors;
            $grand_pre    += (int)$s->pre_registered;
            $grand_walkin += (int)$s->walk_in;
            $grand_in     += (int)$s->currently_in;
            $grand_out    += (int)$s->checked_out;
            $grand_over   += (int)$s->overstay;
        }
        ?>

        <!-- Report Header -->
        <div style="margin:10px 0;padding:6px 10px;background:#f0f4f8;border-left:4px solid #3b7dd8;">
            <strong><?= $report ?></strong> &nbsp;|&nbsp; <?= $str ?>
        </div>

        <!-- KPI Cards -->
        <table width="100%" cellspacing="3" cellpadding="4" border="0" style="margin-bottom:14px;">
        <tr>
            <td style="background:#3b7dd8;color:#fff;text-align:center;padding:10px;border-radius:4px;">
                <div style="font-size:24px;font-weight:bold"><?= $grand_total ?></div>
                <div style="font-size:11px;">Total Visitors</div>
            </td>
            <td style="background:#28a745;color:#fff;text-align:center;padding:10px;border-radius:4px;">
                <div style="font-size:24px;font-weight:bold"><?= $grand_pre ?></div>
                <div style="font-size:11px;">Pre-Registered</div>
            </td>
            <td style="background:#6c757d;color:#fff;text-align:center;padding:10px;border-radius:4px;">
                <div style="font-size:24px;font-weight:bold"><?= $grand_walkin ?></div>
                <div style="font-size:11px;">Walk-In</div>
            </td>
            <td style="background:#17a2b8;color:#fff;text-align:center;padding:10px;border-radius:4px;">
                <div style="font-size:24px;font-weight:bold"><?= $grand_in ?></div>
                <div style="font-size:11px;">Currently Inside</div>
            </td>
            <td style="background:#fd7e14;color:#fff;text-align:center;padding:10px;border-radius:4px;">
                <div style="font-size:24px;font-weight:bold"><?= $grand_over ?></div>
                <div style="font-size:11px;">Overstay</div>
            </td>
            <td style="background:#343a40;color:#fff;text-align:center;padding:10px;border-radius:4px;">
                <div style="font-size:24px;font-weight:bold"><?= $grand_out ?></div>
                <div style="font-size:11px;">Checked Out</div>
            </td>
        </tr>
        </table>

        <!-- Status Breakdown Table -->
        <table width="100%" cellspacing="0" cellpadding="3" border="1"
               style="border-collapse:collapse;margin-bottom:14px;font-size:12px;">
            <thead>
                <tr style="background:#e9ecef;">
                    <th style="padding:5px;">Approval Status</th>
                    <th>Total</th>
                    <th>Pre-Registered</th>
                    <th>Walk-In</th>
                    <th>Currently In</th>
                    <th>Checked Out</th>
                    <th>Overstay</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($sum_rows as $s) { ?>
            <tr>
                <td style="padding:4px;"><?= htmlspecialchars($s->approval_status) ?></td>
                <td align="center"><?= (int)$s->total_visitors ?></td>
                <td align="center"><?= (int)$s->pre_registered ?></td>
                <td align="center"><?= (int)$s->walk_in ?></td>
                <td align="center"><?= (int)$s->currently_in ?></td>
                <td align="center"><?= (int)$s->checked_out ?></td>
                <td align="center"><?= (int)$s->overstay ?></td>
            </tr>
            <?php } ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background:#f8f9fa;">
                    <td style="padding:4px;">Grand Total</td>
                    <td align="center"><?= $grand_total ?></td>
                    <td align="center"><?= $grand_pre ?></td>
                    <td align="center"><?= $grand_walkin ?></td>
                    <td align="center"><?= $grand_in ?></td>
                    <td align="center"><?= $grand_out ?></td>
                    <td align="center"><?= $grand_over ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- Detail Table -->
        <table width="100%" cellspacing="0" cellpadding="3" border="1"
               id="ExportTable" style="border-collapse:collapse;font-size:11px;">
            <thead>
                <tr style="background:#343a40;color:#fff;">
                    <th>S/L</th>
                    <th>Visitor No</th>
                    <th>Pre-Reg No</th>
                    <th>Visitor Name</th>
                    <th>Mobile</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Visit Date</th>
                    <th>Time From</th>
                    <th>Time To</th>
                    <th>Host Designation</th>
                    <th>Department</th>
                    <th>Zone</th>
                    <th>Purpose</th>
                    <th>Approval Status</th>
                    <th>Card No</th>
                    <th>Card Status</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Visitor Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $q = db_query($sql_detail);
            $i = 1;
            while ($row = mysqli_fetch_object($q)) {
                $row_bg = '';
                if ($row->visitor_status == 'In')       $row_bg = 'background:#d4edda;';
                if ($row->visitor_status == 'Overstay') $row_bg = 'background:#fff3cd;';
                ?>
                <tr style="<?= $row_bg ?>">
                    <td align="center"><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row->visitor_no) ?></td>
                    <td><?= $row->pre_reg_no ? htmlspecialchars($row->pre_reg_no) : '-' ?></td>
                    <td><?= htmlspecialchars($row->visitor_name) ?></td>
                    <td><?= htmlspecialchars($row->visitor_mobile) ?></td>
                    <td><?= htmlspecialchars($row->visitor_company) ?></td>
                    <td><?= htmlspecialchars($row->visitor_type) ?></td>
                    <td align="center"><?= $row->visit_date ?></td>
                    <td align="center"><?= $row->visit_time_from ?></td>
                    <td align="center"><?= $row->visit_time_to ?></td>
                    <td><?= htmlspecialchars($row->host_designation) ?></td>
                    <td><?= htmlspecialchars($row->host_department) ?></td>
                    <td><?= htmlspecialchars($row->access_zone) ?></td>
                    <td><?= htmlspecialchars($row->visit_purpose) ?></td>
                    <td><strong><?= $row->approval_status ?></strong></td>
                    <td><?= $row->card_no ? htmlspecialchars($row->card_no) : '-' ?></td>
                    <td><?= $row->card_status ?></td>
                    <td><?= $row->check_in_time ?></td>
                    <td><?= $row->check_out_time ? $row->check_out_time : '-' ?></td>
                    <td><strong><?= $row->visitor_status ?></strong></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php
        break;


    // ══════════════════════════════════════════
    // REPORT 22 — Access Log Report
    // ══════════════════════════════════════════
    case 22:
	
	
	
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


        $report = "Access Log Report";
        $str    = "Period: $f_date to $t_date";

        $sql_detail = "SELECT
                v.visitor_no,
                v.visitor_name,
                v.visitor_mobile,
                v.visitor_company,
                vt.type_name          AS visitor_type,
                az.zone_name          AS access_zone,
                v.approval_status,
                v.card_no,
                v.card_status,
                v.check_in_date,
                v.check_in_time,
                v.check_out_date,
                v.check_out_time,
                v.expected_out_time,
                v.visitor_outing_remark,
                v.visitor_status,
                CASE
                    WHEN v.check_out_time IS NOT NULL
                    THEN TIMESTAMPDIFF(MINUTE, v.check_in_time, v.check_out_time)
                    ELSE TIMESTAMPDIFF(MINUTE, v.check_in_time, NOW())
                END AS duration_minutes
            FROM vms_visitor_master v
            LEFT JOIN vms_visitor_type vt ON vt.id = v.visitor_type_id
            LEFT JOIN vms_access_zone  az ON az.id = v.zone_id
            WHERE 1=1
                $date_con
                $company_con
                $visitor_type_con
                $zone_con
                $approval_status_con
                $visitor_status_con
                $mobile_con
            ORDER BY v.check_in_time ASC";
        ?>

        <!-- Report Header -->
        <div style="margin:10px 0;padding:6px 10px;background:#f0f4f8;border-left:4px solid #3b7dd8;">
            <strong><?= $report ?></strong> &nbsp;|&nbsp; <?= $str ?>
        </div>

        <table width="100%" cellspacing="0" cellpadding="3" border="1"
               id="ExportTable" style="border-collapse:collapse;font-size:11px;">
            <thead>
                <tr style="background:#343a40;color:#fff;">
                    <th>S/L</th>
                    <th>Visitor No</th>
                    <th>Visitor Name</th>
                    <th>Mobile</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Zone</th>
                    <th>Card No</th>
                    <th>Card Status</th>
                    <th>Check-In Date</th>
                    <th>Check-In Time</th>
                    <th>Check-Out Date</th>
                    <th>Check-Out Time</th>
                    <th>Expected Out</th>
                    <th>Duration (Min)</th>
                    <th>Visitor Status</th>
                    <th>Approval Status</th>
                    <th>Outing Remark</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $q              = db_query($sql_detail);
            $i              = 1;
            $total_duration = 0;
            while ($row = mysqli_fetch_object($q)) {
                $total_duration += (int)$row->duration_minutes;
                $row_bg = '';
                if ($row->visitor_status == 'Overstay') {
                    $row_bg = 'background:#fff3cd;';
                } elseif ($row->visitor_status == 'In'
                          && !empty($row->expected_out_time)
                          && strtotime($row->expected_out_time) < time()) {
                    $row_bg = 'background:#f8d7da;';
                }
                ?>
                <tr style="<?= $row_bg ?>">
                    <td align="center"><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row->visitor_no) ?></td>
                    <td><?= htmlspecialchars($row->visitor_name) ?></td>
                    <td><?= htmlspecialchars($row->visitor_mobile) ?></td>
                    <td><?= htmlspecialchars($row->visitor_company) ?></td>
                    <td><?= htmlspecialchars($row->visitor_type) ?></td>
                    <td><?= htmlspecialchars($row->access_zone) ?></td>
                    <td><?= $row->card_no ? htmlspecialchars($row->card_no) : '-' ?></td>
                    <td><?= $row->card_status ?></td>
                    <td align="center"><?= $row->check_in_date ?></td>
                    <td align="center"><?= $row->check_in_time ? date('h:i A', strtotime($row->check_in_time)) : '-' ?></td>
                    <td align="center"><?= $row->check_out_date ? $row->check_out_date : '-' ?></td>
                    <td align="center"><?= $row->check_out_time ? date('h:i A', strtotime($row->check_out_time)) : '-' ?></td>
                    <td align="center"><?= $row->expected_out_time ? date('h:i A', strtotime($row->expected_out_time)) : '-' ?></td>
                    <td align="center"><?= (int)$row->duration_minutes ?></td>
                    <td><strong><?= $row->visitor_status ?></strong></td>
                    <td><?= $row->approval_status ?></td>
                    <td><?= $row->visitor_outing_remark ? htmlspecialchars($row->visitor_outing_remark) : '-' ?></td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background:#f8f9fa;">
                    <td colspan="14" align="right">Total Duration (Min):</td>
                    <td align="center"><?= number_format($total_duration) ?></td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
        <?php
        break;


    // ══════════════════════════════════════════
    // REPORT 33 — Card Usage Report
    // ══════════════════════════════════════════
    case 33:
	
	
	
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


        $report = "Card Usage Report";
        $str    = "Period: $f_date to $t_date";

        // Card-level summary
        $sql_card_summary = "SELECT
                v.card_no,
                COUNT(v.id)                                               AS total_uses,
                COUNT(CASE WHEN v.card_status = 'Assigned'  THEN 1 END)  AS currently_assigned,
                COUNT(CASE WHEN v.card_status = 'Withdrawn' THEN 1 END)  AS withdrawn,
                MIN(v.check_in_time)                                      AS first_use,
                MAX(v.check_in_time)                                      AS last_use
            FROM vms_visitor_master v
            WHERE v.card_no != ''
                $date_con
                $company_con
                $card_status_con
                $zone_con
                $visitor_type_con
            GROUP BY v.card_no
            ORDER BY total_uses DESC";

        // Per-visitor card detail
        $sql_detail = "SELECT
                v.visitor_no,
                v.visitor_name,
                v.visitor_mobile,
                v.visitor_company,
                vt.type_name          AS visitor_type,
                az.zone_name          AS access_zone,
                v.card_no,
                v.card_id,
                v.card_status,
                v.check_in_date,
                v.check_in_time,
                v.check_out_date,
                v.check_out_time,
                v.approval_status,
                v.visitor_status,
                CASE
                    WHEN v.check_out_time IS NOT NULL
                    THEN TIMESTAMPDIFF(MINUTE, v.check_in_time, v.check_out_time)
                    ELSE TIMESTAMPDIFF(MINUTE, v.check_in_time, NOW())
                END AS duration_minutes
            FROM vms_visitor_master v
            LEFT JOIN vms_visitor_type vt ON vt.id = v.visitor_type_id
            LEFT JOIN vms_access_zone  az ON az.id = v.zone_id
            WHERE v.card_no != ''
                $date_con
                $company_con
                $card_status_con
                $zone_con
                $visitor_type_con
                $mobile_con
            ORDER BY v.card_no ASC, v.check_in_time ASC";
        ?>

        <!-- Report Header -->
        <div style="margin:10px 0;padding:6px 10px;background:#f0f4f8;border-left:4px solid #3b7dd8;">
            <strong><?= $report ?></strong> &nbsp;|&nbsp; <?= $str ?>
        </div>

        <!-- Card Summary Table -->
        <div style="margin-bottom:8px;"><strong>Card-Level Summary</strong></div>
        <table width="100%" cellspacing="0" cellpadding="3" border="1"
               style="border-collapse:collapse;font-size:11px;margin-bottom:18px;">
            <thead>
                <tr style="background:#343a40;color:#fff;">
                    <th>S/L</th>
                    <th>Card No</th>
                    <th>Total Uses</th>
                    <th>Currently Assigned</th>
                    <th>Withdrawn</th>
                    <th>First Used</th>
                    <th>Last Used</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $q_cs        = db_query($sql_card_summary);
            $ci          = 1;
            $grand_uses  = 0;
            while ($cs = mysqli_fetch_object($q_cs)) {
                $grand_uses += (int)$cs->total_uses;
                ?>
                <tr>
                    <td align="center"><?= $ci++ ?></td>
                    <td><strong><?= htmlspecialchars($cs->card_no) ?></strong></td>
                    <td align="center"><?= (int)$cs->total_uses ?></td>
                    <td align="center"><?= (int)$cs->currently_assigned ?></td>
                    <td align="center"><?= (int)$cs->withdrawn ?></td>
                    <td align="center"><?= $cs->first_use ?></td>
                    <td align="center"><?= $cs->last_use ?></td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background:#f8f9fa;">
                    <td colspan="2" align="right">Total:</td>
                    <td align="center"><?= $grand_uses ?></td>
                    <td colspan="4"></td>
                </tr>
            </tfoot>
        </table>

        <!-- Visitor-Level Card Detail -->
        <div style="margin-bottom:8px;"><strong>Visitor-Level Card Usage Detail</strong></div>
        <table width="100%" cellspacing="0" cellpadding="3" border="1"
               id="ExportTable" style="border-collapse:collapse;font-size:11px;">
            <thead>
                <tr style="background:#343a40;color:#fff;">
                    <th>S/L</th>
                    <th>Card No</th>
                    <th>Visitor No</th>
                    <th>Visitor Name</th>
                    <th>Mobile</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Zone</th>
                    <th>Card Status</th>
                    <th>Check-In Date</th>
                    <th>Check-In Time</th>
                    <th>Check-Out Date</th>
                    <th>Check-Out Time</th>
                    <th>Duration (Min)</th>
                    <th>Visitor Status</th>
                    <th>Approval Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $q         = db_query($sql_detail);
            $i         = 1;
            $prev_card = null;
            while ($row = mysqli_fetch_object($q)) {
                $row_bg = '';
                if ($row->card_no !== $prev_card) {
                    $row_bg    = 'background:#e8f0fe;border-top:2px solid #3b7dd8;';
                    $prev_card = $row->card_no;
                }
                ?>
                <tr style="<?= $row_bg ?>">
                    <td align="center"><?= $i++ ?></td>
                    <td><strong><?= htmlspecialchars($row->card_no) ?></strong></td>
                    <td><?= htmlspecialchars($row->visitor_no) ?></td>
                    <td><?= htmlspecialchars($row->visitor_name) ?></td>
                    <td><?= htmlspecialchars($row->visitor_mobile) ?></td>
                    <td><?= htmlspecialchars($row->visitor_company) ?></td>
                    <td><?= htmlspecialchars($row->visitor_type) ?></td>
                    <td><?= htmlspecialchars($row->access_zone) ?></td>
                    <td><?= $row->card_status ?></td>
                    <td align="center"><?= $row->check_in_date ?></td>
                    <td align="center"><?= $row->check_in_time ? date('h:i A', strtotime($row->check_in_time)) : '-' ?></td>
                    <td align="center"><?= $row->check_out_date ? $row->check_out_date : '-' ?></td>
                    <td align="center"><?= $row->check_out_time ? date('h:i A', strtotime($row->check_out_time)) : '-' ?></td>
                    <td align="center"><?= (int)$row->duration_minutes ?></td>
                    <td><strong><?= $row->visitor_status ?></strong></td>
                    <td><?= $row->approval_status ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php
        break;

    default:
        echo '<div class="alert alert-danger m-3">Invalid report number: ' . (int)$report_no . '</div>';
        break;
}

// Fallback for any case that sets $sql without inline rendering
if (isset($sql) && $sql != '') {
    echo report_create($sql, 1, $str);
}
?>

<?php
$page_name = $_POST['report'] . $report . " (VMS Master Report)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>