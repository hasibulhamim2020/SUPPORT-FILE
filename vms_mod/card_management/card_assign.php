<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Assign Card to Visitor';
$table   = 'vms_visitor_master';
$unique  = 'id';
$shown   = 'visitor_name';
$page    = 'card_assign.php';

do_datatable('table_head');
do_calander('#f_date');

if(isset($_GET['msg'])) nibirToast($_GET['msg']);

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];

if(prevent_multi_submit()){
    if(isset($_POST['assign_card'])){
        $vid  = (int)$_POST['visitor_id'];
        $cid  = (int)$_POST['card_id'];

        $v_card = find_a_field('vms_visitor_master','card_id','id='.$vid.' AND group_for=\''.$grp.'\'');
        if($v_card > 0){
            header("Location: ".$page); exit;
        }

        $card = find_all_field('vms_card_pool','','id='.$cid.' AND group_for=\''.$grp.'\'');
        if(!$card || $card->card_status !== 'Available'){
            header("Location: ".$page); exit;
        }

        $_POST = [];
        $_POST['id']          = $vid;
        $_POST['card_id']     = $cid;
        $_POST['card_no']     = $card->card_no;
        $_POST['card_status'] = 'Assigned';
        (new crud('vms_visitor_master'))->update('id');

        $_POST = [];
        $_POST['id']          = $cid;
        $_POST['card_status'] = 'Assigned';
        (new crud('vms_card_pool'))->update('id');

            header("Location: ".$page); exit;
    }
}

$sel_id       = isset($_GET['visitor_id']) ? (int)$_GET['visitor_id'] : 0;
$visitor_data = null;

if($sel_id > 0){
    $sql          = "SELECT v.*, u.fname AS host_name, d.DEPT_DESC AS host_dept
                     FROM vms_visitor_master v
                     LEFT JOIN user_activity_management u ON u.user_id = v.host_pbi_id
					 LEFT JOIN department d ON d.DEPT_ID = v.host_department
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
.vms-cb-assigned    { background:#17a2b8; }
.vms-cb-nocard      { background:#f0ad4e; }
.vms-empty          { padding:40px 20px; text-align:center; color:#adb5bd; }
.vms-empty-icon     { font-size:44px; display:block; margin-bottom:12px; }
.vms-return-note    { padding:10px 16px; font-size:13px; color:#6c757d; }
.fw-600             { font-weight:600; }
.tr-active          { background:#fffbe6; font-weight:600; }
.tr-pointer         { cursor:pointer; }
.td-nowrap          { white-space:nowrap; }
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
        <h4 align="center" class="n-form-titel1">Search Approved Visitors</h4>
        <input type="hidden" name="<?=$shown?>" value="1">

        <div class="form-group row m-0 pl-3 pr-3">
            <label class="col-sm-3 pl-0 pr-0 col-form-label">Visit Date</label>
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
            <th>Check-In Date</th>
            <th>Card</th>
        </tr>
        </thead>
        <tbody class="tbody1">
        <?
        $con   = " AND v.group_for='".$grp."' AND v.approval_status='Approved' AND v.card_status='Not Assigned'";
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
            $has_card  = ($row->card_id > 0 && $row->card_no != '');
            $card_cls  = $has_card ? 'vms-cb-assigned' : 'vms-cb-nocard';
            $card_lbl  = $has_card ? htmlspecialchars($row->card_no) : 'No Card';
            $row_cls   = ($sel_id == $row->id) ? 'tr-active tr-pointer' : 'tr-pointer';
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

    <h4 align="center" class="n-form-titel1">Assign Card</h4>

    <div class="vms-info-panel">
        <div class="vms-info-head"><i class="fa-solid fa-user mr-1"></i> Visitor Details</div>
        <table class="vms-info-tbl">
            <tr><td class="vms-info-lbl">Visitor No</td>    <td class="vms-info-val"><?=htmlspecialchars($visitor_data->visitor_no)?></td></tr>
            <tr><td class="vms-info-lbl">Name</td>          <td class="vms-info-val"><?=htmlspecialchars($visitor_data->visitor_name)?></td></tr>
            <tr><td class="vms-info-lbl">Mobile</td>        <td><?=htmlspecialchars($visitor_data->visitor_mobile ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Organisation</td>  <td><?=htmlspecialchars($visitor_data->visitor_company ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Host</td>          <td><?=htmlspecialchars($visitor_data->host_name ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Department</td>    <td><?=htmlspecialchars($visitor_data->host_dept ?: '-')?></td></tr>
            <tr><td class="vms-info-lbl">Check-In Date</td> <td><?=htmlspecialchars($visitor_data->check_in_date)?></td></tr>
            <tr>
                <td class="vms-info-lbl">Current Card</td>
                <td>
                    <? if($visitor_data->card_id > 0){ ?>
                    <span class="vms-cb vms-cb-assigned"><?=htmlspecialchars($visitor_data->card_no)?></span>
                    <? } else { ?>
                    <span class="vms-cb vms-cb-nocard">No Card Assigned</span>
                    <? } ?>
                </td>
            </tr>
        </table>
    </div>

    <form action="<?=$page?>" method="post" name="form_assign" id="form_assign">
        <input type="hidden" name="visitor_id" value="<?=$visitor_data->id?>">

        <div class="form-group row m-0 pl-3 pr-3 pt-2">
            <label class="col-sm-4 pl-0 pr-0 col-form-label ">Select Card</label>
            <div class="col-sm-8 p-0">
                <select name="card_id" id="card_id" required>
                    <option value="">-- Select Card --</option>
                    <?
                    $avail = db_query("SELECT id, card_no, card_type FROM vms_card_pool
                                       WHERE card_status='Available' AND group_for='".$grp."'
                                       ORDER BY card_no ASC");
                    if($avail) while($cr = mysqli_fetch_object($avail))
                        echo "<option value='".$cr->id."'>".htmlspecialchars($cr->card_no)." (".$cr->card_type.")</option>";
                    ?>
                </select>
            </div>
        </div>

        <div class="n-form-btn-class">
            <input name="assign_card" type="submit" value="ASSIGN CARD" class="btn1 btn1-bg-submit"
                   onclick="return confirm('Assign selected card to this visitor?')">
            <input type="button" value="CANCEL" class="btn1 btn1-bg-cancel"
                   onclick="parent.location='<?=$page?>'">
        </div>
    </form>

<? } else { ?>

    <h4 align="center" class="n-form-titel1">Assign Card</h4>
    <div class="vms-empty">
        <i class="fa-solid fa-id-card vms-empty-icon"></i>
        Select a visitor from the list<br>to assign a card.
    </div>

<? } ?>

</div>
</div>

</div>
</div>

<?
selected_two('#card_id');
require_once SERVER_CORE."routing/layout.bottom.php";
?>