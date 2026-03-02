<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Visitor Check-Out';
$table   = 'vms_visitor_master';
$unique  = 'id';
$shown   = 'visitor_name';
$page    = 'visitor_checkout_action.php';
$tr_from = 'VMS';
$tr_type = 'Show';
$tr_no   = 0;
$tr_id   = 0;

do_datatable('table_head');
do_calander('#f_date');

if(isset($_GET['msg'])) nibirToast($_GET['msg']);

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];

if(prevent_multi_submit()){
if(isset($_POST['do_checkout'])){
    $vid    = (int)$_POST['visitor_id'];
    $cid    = (int)$_POST['card_id'];
    $now    = date('Y-m-d H:i:s');
    $today  = date('Y-m-d');
    $remark = addslashes($_POST['checkout_remark']);

    db_query("UPDATE vms_visitor_master
              SET approval_status       = 'CheckedOut',
                  visitor_status        = 'Out',
                  check_out_date        = '".$today."',
                  check_out_time        = '".$now."',
                  visitor_outing_remark = '".$remark."'
              WHERE id=".$vid." AND group_for='".$grp."'");
//    if($cid > 0){
//        db_query("UPDATE vms_card_pool
//                  SET card_status = 'Available'
//                  WHERE id=".$cid." AND group_for='".$grp."'");
//    }
    header("Location: ".$page); exit;
}
}

$sel_id       = isset($_GET['visitor_id']) ? (int)$_GET['visitor_id'] : 0;
$visitor_data = null;

if($sel_id > 0){
    $sql          = "SELECT v.*, u.fname AS host_name, u.designation AS host_dept, z.zone_name
                     FROM vms_visitor_master v
                     LEFT JOIN user_activity_management u ON u.user_id = v.host_pbi_id
                     LEFT JOIN vms_access_zone z          ON z.id      = v.zone_id
                     WHERE v.id=".$sel_id." AND v.group_for='".$grp."' LIMIT 1";
    $visitor_data = mysqli_fetch_object(db_query($sql));
}
?>

<style>
.vms-info-panel     { background:#f8f9fa; border:1px solid #dee2e6; border-radius:6px; padding:12px 16px; margin:10px 16px 12px; }
.vms-info-head      { font-size:10px; color:#6c757d; font-weight:700; text-transform:uppercase; letter-spacing:.05em; margin-bottom:8px; }
.vms-info-tbl       { width:100%; font-size:13px; border-collapse:collapse; }
.vms-info-tbl td    { padding:3px 0; vertical-align:top; }
.vms-info-lbl       { color:#6c757d; width:38%; }
.vms-info-val       { font-weight:600; }
.vms-cb             { display:inline-block; padding:2px 8px; border-radius:3px; font-size:11px; font-weight:600; color:#fff; }
.vms-cb-checkedin   { background:#17a2b8; }
.vms-cb-nocard      { background:#6c757d; }
.vms-cb-card        { background:#17a2b8; }
.vms-release-note   { font-size:11px; color:#6c757d; margin-left:6px; }
.vms-empty          { padding:40px 20px; text-align:center; color:#adb5bd; }
.vms-empty-icon     { font-size:44px; display:block; margin-bottom:12px; }
.fw-600             { font-weight:600; }
.td-nowrap          { white-space:nowrap; }
.tr-active          { background:#fffbe6; font-weight:600; }
.tr-pointer         { cursor:pointer; }
</style>

<script>
function DoNav(id){
    document.location.href = '<?=$page?>?visitor_id=' + id;
}
</script>

<div class="container-fluid p-0">
<div class="row">

  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">

    <div class="container p-0">
    <form class="n-form1 pt-0" method="post" action="">
        <h4 align="center" class="n-form-titel1">Search Checked-In Visitors</h4>
        <input type="hidden" name="<?=$shown?>" value="1">

        <div class="form-group row m-0 pl-3 pr-3">
            <label class="col-sm-3 pl-0 pr-0 col-form-label">Check-In Date</label>
            <div class="col-sm-9 p-0">
                <input type="text" name="f_date" id="f_date"
                       value="<?=isset($_POST['f_date'])?htmlspecialchars($_POST['f_date']):date('Y-m-d')?>">
            </div>
        </div>

        <div class="form-group row m-0 pl-3 pr-3">
            <label class="col-sm-3 pl-0 pr-0 col-form-label">Visitor Name</label>
            <div class="col-sm-9 p-0">
                <input type="text" name="f_name"
                       value="<?=isset($_POST['f_name'])?htmlspecialchars($_POST['f_name']):''?>">
            </div>
        </div>

        <div class="n-form-btn-class">
            <input class="btn1 btn1-bg-submit" name="search" type="submit" value="Show">
            <input class="btn1 btn1-bg-cancel" type="button" value="Cancel"
                   onclick="parent.location='<?=$page?>'">
        </div>
    </form>
    </div>

    <div class="container n-form1">
    <table id="table_head" class="table1 table-striped table-bordered table-hover table-sm" cellspacing="0">
        <thead class="thead1">
        <tr class="bgc-info">
            <th>#</th>
            <th>Visitor No</th>
            <th>Visitor Name</th>
            <th>Mobile</th>
            <th>Host</th>
            <th>Check-In</th>
            <th>Card</th>
        </tr>
        </thead>
        <tbody class="tbody1">
        <?
        $con   = " AND v.group_for='".$grp."' AND v.approval_status='CheckedIn' AND v.card_status='Assigned'";
        $fdate = isset($_POST['f_date']) ? $_POST['f_date'] : date('Y-m-d');
        $con  .= " AND v.check_in_date='".addslashes($fdate)."'";
        if(isset($_POST['search']) && !empty($_POST['f_name']))
            $con .= " AND v.visitor_name LIKE '%".addslashes($_POST['f_name'])."%'";

        $lst   = db_query("SELECT v.*, u.fname AS host_name
                           FROM vms_visitor_master v
                           LEFT JOIN user_activity_management u ON u.user_id = v.host_pbi_id
                           WHERE 1 ".$con." ORDER BY v.id DESC");
        $sl    = 1;
        if($lst) while($row = mysqli_fetch_object($lst)){
            $has_card = ($row->card_id > 0 && $row->card_no != '');
            $card_cls = $has_card ? 'vms-cb-card' : 'vms-cb-nocard';
            $card_lbl = $has_card ? htmlspecialchars($row->card_no) : 'No Card';
            $row_cls  = ($sel_id == $row->id) ? 'tr-active tr-pointer' : 'tr-pointer';
        ?>
        <tr onclick="DoNav('<?=$row->id?>')" class="<?=$row_cls?>">
            <td><?=$sl++?></td>
            <td class="fw-600"><?=htmlspecialchars($row->visitor_no)?></td>
            <td><?=htmlspecialchars($row->visitor_name)?></td>
            <td><?=htmlspecialchars($row->visitor_mobile)?></td>
            <td><?=htmlspecialchars($row->host_name ?: '-')?></td>
            <td class="td-nowrap"><?=htmlspecialchars($row->check_in_date)?></td>
            <td><span class="vms-cb <?=$card_cls?>"><?=$card_lbl?></span></td>
        </tr>
        <? } ?>
        </tbody>
    </table>
    </div>

</div>

  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6  setup-right">
<div class="n-form setup-fixed">

<? if($visitor_data){ ?>

    <h4 align="center" class="n-form-titel1">Visitor Check-Out</h4>

    <div class="vms-info-panel">
        <div class="vms-info-head"><i class="fa-solid fa-user mr-1"></i> Visitor Details</div>
        <table class="vms-info-tbl">
            <tr><td class="vms-info-lbl">Visitor No</td>    <td class="vms-info-val"><?=htmlspecialchars($visitor_data->visitor_no)?></td></tr>
            <tr><td class="vms-info-lbl">Name</td>          <td class="vms-info-val"><?=htmlspecialchars($visitor_data->visitor_name)?></td></tr>
            <tr><td class="vms-info-lbl">Mobile</td>        <td><?=htmlspecialchars($visitor_data->visitor_mobile ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Organisation</td>  <td><?=htmlspecialchars($visitor_data->visitor_company ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Host</td>          <td><?=htmlspecialchars($visitor_data->host_name ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Department</td>    <td><?=htmlspecialchars($visitor_data->host_dept ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Access Zone</td>   <td><?=htmlspecialchars($visitor_data->zone_name ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Check-In Time</td> <td><?=htmlspecialchars($visitor_data->check_in_time ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Expected Out</td>  <td><?=htmlspecialchars($visitor_data->expected_out_time ?: '-')?></td></tr>
            <tr>
                <td class="vms-info-lbl">Card</td>
                <td>
                    <? if($visitor_data->card_id > 0){ ?>
                    <span class="vms-cb vms-cb-card"><?=htmlspecialchars($visitor_data->card_no)?></span>
                    <span class="vms-release-note">— will be released</span>
                    <? } else { ?>
                    <span class="vms-cb vms-cb-nocard">No Card</span>
                    <? } ?>
                </td>
            </tr>
        </table>
    </div>

    <form action="<?=$page?>" method="post" name="form_checkout" id="form_checkout">
        <input type="hidden" name="visitor_id" value="<?=$visitor_data->id?>">
        <input type="hidden" name="card_id"    value="<?=$visitor_data->card_id?>">

        <div class="form-group row m-0 pl-3 pr-3 pt-2">
            <label class="col-sm-4 pl-0 pr-0 col-form-label">Remark</label>
            <div class="col-sm-8 p-0">
                <textarea name="checkout_remark" class="form-control" rows="2"
                          placeholder="Optional check-out remark..."><?=isset($_POST['checkout_remark'])?htmlspecialchars($_POST['checkout_remark']):''?></textarea>
            </div>
        </div>

        <div class="n-form-btn-class">
            <input name="do_checkout" type="submit" value="CHECK OUT" class="btn1 btn1-bg-delete"
                   onclick="return confirm('Confirm check-out for this visitor?')">
            <input type="button" value="CANCEL" class="btn1 btn1-bg-cancel"
                   onclick="parent.location='<?=$page?>'">
        </div>
    </form>

<? } else { ?>

    <h4 align="center" class="n-form-titel1">Visitor Check-Out</h4>
    <div class="vms-empty">
        <i class="fa-solid fa-right-from-bracket vms-empty-icon"></i>
        Select a visitor from the list<br>to proceed with check-out.
    </div>

<? } ?>

</div>
</div>

</div>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>