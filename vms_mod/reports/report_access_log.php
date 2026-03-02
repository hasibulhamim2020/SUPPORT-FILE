<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'VMS Reports';
$tr_type = "Show";

do_calander('#f_date');
do_calander('#t_date');

$protocol    = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$url         = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$trimmed_path = str_replace("https://saaserp.ezzy-erp.com/app/views/", "", $url);
$parts       = explode('/', $trimmed_path);
$mod_name    = $parts[0];
$folder_name = $parts[1];
$page_name   = $parts[2];

// Resolve page/feature/module IDs for this page
$res2 = 'SELECT r.folder_name, r.report_name, r.report_no, r.feature_id, r.page_id,
                p.id AS page_id, f.id AS feature_id, f.feature_name,
                m.id AS module_id, m.module_name
         FROM   user_page_manage p
         JOIN   user_feature_manage f ON p.feature_id = f.id
         JOIN   user_module_manage  m ON f.module_id  = m.id,
                report_manage r
         WHERE  m.module_file   = "' . $mod_name    . '"
           AND  p.folder_name   = "' . $folder_name . '"
           AND  p.page_link     = "' . $page_name   . '"
           AND  r.folder_name   = "' . $folder_name . '"
           AND  r.feature_id    = f.id
           AND  r.page_id       = p.id';

$query = db_query($res2);
while ($row = mysqli_fetch_object($query)) {
    $page_file[$row->page_no] = $row->page_id;
}
?>

<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report.php" method="post"
          name="form1" target="_blank" id="form1" style="width:90%">

        <div class="row m-0 p-0">

            <!-- LEFT: Report Selection -->
            <div class="col-sm-5">
                <div class="mb-2"><strong>Select Report</strong></div>

                <?php
                // Load only reports this user has access to for this page
                $res = 'SELECT r.id, r.report_name, r.report_no, r.status
                        FROM   report_manage r
                        JOIN   user_report_access a   ON a.report_id = r.id
                        JOIN   user_activity_management u ON u.user_id = a.user_id
                        WHERE  r.page_id = "' . $page_file[$row->page_id] . '"
                          AND  u.user_id = "' . $_SESSION['user']['id'] . '"
                          AND  a.access  = "1"
                          AND  r.status  = "Yes"
                        ORDER BY r.report_no ASC';

                $qr = db_query($res2);
                $first = true;
                while ($rpt = mysqli_fetch_object($qr)) { ?>
                    <div class="form-check mb-1">
                        <input name="report" type="radio" class="radio1"
                               id="rpt_<?= $rpt->report_no ?>"
                               value="<?= $rpt->report_no ?>"
                               <?= $first ? 'checked="checked"' : '' ?> />
                        <label class="form-check-label p-0" for="rpt_<?= $rpt->report_no ?>">
                            <?= $rpt->report_name ?> (<?= $rpt->report_no ?>)
                        </label>
                    </div>
                <?php $first = false; } ?>
            </div>

            <!-- RIGHT: Filter Options -->
            <div class="col-sm-7">
                <!-- From Date -->
                <div class="form-group row m-0 mb-2 pl-3 pr-3">
                    <label class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                        <input name="f_date" type="text" id="f_date"
                               class="form-control form-control-sm"
                               value="<?= date('Y-m-01') ?>" />
                    </div>
                </div>
                <!-- To Date -->
                <div class="form-group row m-0 mb-2 pl-3 pr-3">
                    <label class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">
                        <input name="t_date" type="text" id="t_date"
                               class="form-control form-control-sm"
                               value="<?= date('Y-m-d') ?>" />
                    </div>
                </div>
                <!-- Visitor Type -->
                <div class="form-group row m-0 mb-2 pl-3 pr-3">
                    <label class="col-sm-4 m-0 p-0 d-flex align-items-center">Visitor Type:</label>
                    <div class="col-sm-8 p-0">
                        <select name="visitor_type_id" id="visitor_type_id"
                                class="form-control form-control-sm">
                            <option value="">-- All --</option>
                            <?php foreign_relation('vms_visitor_type', 'id', 'visitor_type_name'); ?>
                        </select>
                    </div>
                </div>

                <!-- Access Zone -->
                <div class="form-group row m-0 mb-2 pl-3 pr-3">
                    <label class="col-sm-4 m-0 p-0 d-flex align-items-center">Access Zone:</label>
                    <div class="col-sm-8 p-0">
                        <select name="zone_id" id="zone_id"
                                class="form-control form-control-sm">
                            <option value="">-- All --</option>
                            <?php foreign_relation('vms_access_zone', 'id', 'zone_name'); ?>
                        </select>
                    </div>
                </div>

                <!-- Approval Status -->
                <div class="form-group row m-0 mb-2 pl-3 pr-3">
                    <label class="col-sm-4 m-0 p-0 d-flex align-items-center">Approval Status:</label>
                    <div class="col-sm-8 p-0">
                        <select name="approval_status" id="approval_status"
                                class="form-control form-control-sm">
                            <option value="">-- All --</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                            <option value="CheckedIn">Checked In</option>
                            <option value="CheckedOut">Checked Out</option>
                            <option value="Expired">Expired</option>
                        </select>
                    </div>
                </div>

                <!-- Visitor Status -->
                <div class="form-group row m-0 mb-2 pl-3 pr-3">
                    <label class="col-sm-4 m-0 p-0 d-flex align-items-center">Visitor Status:</label>
                    <div class="col-sm-8 p-0">
                        <select name="visitor_status" id="visitor_status"
                                class="form-control form-control-sm">
                            <option value="">-- All --</option>
                            <option value="In">In</option>
                            <option value="Out">Out</option>
                            <option value="Overstay">Overstay</option>
                        </select>
                    </div>
                </div>

                <!-- Card Status (used for Card Usage Report 33) -->
                <div class="form-group row m-0 mb-2 pl-3 pr-3">
                    <label class="col-sm-4 m-0 p-0 d-flex align-items-center">Card Status:</label>
                    <div class="col-sm-8 p-0">
                        <select name="card_status" id="card_status"
                                class="form-control form-control-sm">
                            <option value="">-- All --</option>
                            <option value="Not Assigned">Not Assigned</option>
                            <option value="Assigned">Assigned</option>
                            <option value="Withdrawn">Withdrawn</option>
                        </select>
                    </div>
                </div>

                <!-- Visitor Mobile (quick search) -->
                <div class="form-group row m-0 mb-2 pl-3 pr-3">
                    <label class="col-sm-4 m-0 p-0 d-flex align-items-center">Mobile No:</label>
                    <div class="col-sm-8 p-0">
                        <input type="text" name="visitor_mobile" id="visitor_mobile"
                               class="form-control form-control-sm"
                               placeholder="Search by mobile..." />
                    </div>
                </div>

            </div><!-- end col-sm-7 -->
        </div><!-- end row -->

        <div class="n-form-btn-class mt-3">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit"
                   value="Generate Report" tabindex="6" />
        </div>

    </form>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>