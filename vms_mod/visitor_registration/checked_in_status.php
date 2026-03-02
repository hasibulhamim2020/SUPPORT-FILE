<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Visitor Registration List';
$table   = 'vms_visitor_master';
$unique  = 'id';
$page    = 'checked_in_unapproved_view.php';

do_datatable('table_head');

do_calander('#f_date');

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];

if(isset($_POST['quick_id']) && isset($_POST['quick_action'])){
    $qid   = (int)$_POST['quick_id'];
    $qstat = $_POST['quick_action'] === 'approve' ? 'Approved' : 'Rejected';
    db_query("UPDATE ".$table." SET approval_status='".$qstat."', approved_by=".$uid.", approved_at='".date('Y-m-d H:i:s')."' WHERE id=".$qid." AND group_for='".$grp."'");
    echo json_encode(['ok'=>1]);
    exit;
}
?>

<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">

<div class="container-fluid bg-form-titel">
    <div class="row">

        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
            <div class="form-group row m-0">
                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date : &nbsp;</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                    <input type="text" name="f_date" id="f_date" class="form-control" value="<?=isset($_POST['f_date'])?$_POST['f_date']:''?>" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
            <div class="form-group row m-0">
                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Status : &nbsp;</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                    <select name="f_status" id="f_status" class="form-control">
                        <option value="">-- All --</option>
                        <?
                        foreach(['Pending','Rejected','Expired'] as $st){
                            $sel = (isset($_POST['f_status']) && $_POST['f_status']==$st) ? 'selected' : '';
                            echo "<option value='".$st."' ".$sel.">".$st."</option>";
                        }?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
            <div class="form-group row m-0">
                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Visitor Name : &nbsp;</label>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                    <input type="text" name="f_name" class="form-control" value="<?=isset($_POST['f_name'])?htmlspecialchars($_POST['f_name']):''?>" autocomplete="off" placeholder="Search by name...">
                </div>
            </div>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 pt-1 pb-1">
            <input type="submit" name="submitit" value="Search" class="btn1 btn1-submit-input w-100">
        </div>
<!--        <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 pt-1 pb-1">
            <a href="visitor_pre_registration.php" class="btn1 btn1-submit-input w-100" style="display:block;text-align:center;">+ New</a>
        </div>-->
    </div>
</div>
</div>

<div class="container-fluid pt-2 p-0">
<table id="table_head"  class="table1 table-striped table-bordered table-hover table-sm">
    <thead class="thead1">
    <tr class="bgc-info">
        <th>#</th>
        <th>Pre-Reg No</th>
        <th>Visitor Name</th>
        <th>Mobile</th>
        <th>Organisation</th>
        <th>ID Type</th>
        <th>Visit Date</th>
        <th>Time</th>
        <th>Host</th>
        <th>Department</th>
        <th>Access Zone</th>
        <th>Status</th>
        <th>Entry At</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody class="tbody1">
    <?
    $con = " AND p.group_for='".$grp."' AND p.approval_status='Pending'";

    if(isset($_POST['submitit'])){
        if(!empty($_POST['f_date']))  $con .= " AND p.visit_date='".addslashes($_POST['f_date'])."'";
        if(!empty($_POST['f_status'])) $con .= " AND p.approval_status='".addslashes($_POST['f_status'])."'";
        if(!empty($_POST['f_name'])) $con .= " AND p.visitor_name LIKE '%".addslashes($_POST['f_name'])."%'";
    } else {
        $con .= " AND p.visit_date='".date('Y-m-d')."'";
    }

    $sql = "SELECT p.*,
                   t.visitor_type_name,
                   pb.PBI_NAME       AS host_name,
                   d.DEPT_DESC   AS dept_name,
                   z.zone_name
            FROM   vms_visitor_master p
            LEFT JOIN vms_visitor_type     t  ON t.id      = p.visitor_type_id
			LEFT JOIN user_activity_management u ON u.user_id   = p.host_pbi_id
            LEFT JOIN personnel_basic_info pb ON pb.PBI_ID   = u.PBI_ID
			LEFT JOIN department d ON d.DEPT_ID   = p.host_department
            LEFT JOIN vms_access_zone      z  ON z.id      = p.zone_id
            WHERE 1 ".$con."
            ORDER BY p.id DESC";

    $query = db_query($sql);
    $sl = 1;
    $bc = [
        'Pending'   => ['#f0ad4e','#000'],
        'Approved'  => ['#28a745','#fff'],
        'Rejected'  => ['#dc3545','#fff'],
        'CheckedIn' => ['#17a2b8','#fff'],
        'Expired'   => ['#6c757d','#fff'],
    ];

    while($row = mysqli_fetch_object($query)){
        $bg  = isset($bc[$row->approval_status]) ? $bc[$row->approval_status][0] : '#6c757d';
        $txt = isset($bc[$row->approval_status]) ? $bc[$row->approval_status][1] : '#fff';
    ?>
    <tr>
        <td><?=$sl++?></td>
        <td><strong><?=$row->pre_reg_no?></strong></td>
        <td style="text-align:left;"><?=htmlspecialchars($row->visitor_name)?></td>
        <td><?=$row->visitor_mobile?></td>
        <td style="text-align:left;"><?=htmlspecialchars($row->visitor_company)?></td>
        <td><?=$row->visitor_id_type?></td>
        <td style="white-space:nowrap;"><?=$row->visit_date?></td>
        <td style="white-space:nowrap;"><?=$row->visit_time_from?> - <?=$row->visit_time_to?></td>
        <td style="text-align:left;"><?=htmlspecialchars($row->host_name)?></td>
        <td style="text-align:left;"><?=htmlspecialchars($row->dept_name)?></td>
        <td style="text-align:left;"><?=htmlspecialchars($row->zone_name)?></td>
        <td>
            <span style="background:<?=$bg?>;color:<?=$txt?>;padding:2px 8px;border-radius:3px;font-size:11px;white-space:nowrap;">
                <?=$row->approval_status?>
            </span>
        </td>
        <td style="white-space:nowrap;font-size:11px;"><?=$row->entry_at?></td>
        <td style="white-space:nowrap;">

            <button type="button" class="btn2 btn1-bg-submit" onclick="parent.location='checked_in_view.php?id=<?=$row->id?>'">
                <i class="fa-solid fa-eye"></i>
            </button>

            <? if($row->approval_status == 'Pending'){ ?>

            <button type="button" class="btn2 btn1-bg-submit" onclick="parent.location='checked_in_registration.php?id=<?=$row->id?>'">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>

            <button type="button" class="btn2 btn1-bg-submit" style="background:#dc3545;color:#fff;border:none;" onclick="quick_action(<?=$row->id?>,'reject')">
                <i class="fa-solid fa-circle-xmark"></i>
            </button>

            <? } ?>

        </td>
    </tr>
    <? } ?>
    </tbody>
</table>
</div>

</form>
</div>

<script>
function quick_action(id, action){
    if(!confirm(action === 'approve' ? 'Approve this registration?' : 'Reject this registration?')) return;
    $.post('', { quick_id: id, quick_action: action }, function(){
        location.reload();
    });
}
</script>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>