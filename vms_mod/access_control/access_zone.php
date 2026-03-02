<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Access Zone Setup';
$table   = 'vms_access_zone';
$unique  = 'id';
$shown   = 'zone_name';
$page    = 'access_zone.php';
$tr_from = 'VMS';
$tr_type = 'Show';
$tr_no   = 0;
$tr_id   = 0;

do_datatable('table_head');

if(isset($_GET['msg'])) nibirToast($_GET['msg']);

$grp = $_SESSION['user']['group'];
$uid = $_SESSION['user']['id'];

$crud = new crud($table);

/* -- Field defaults --------------------------------- */
$zone_name        = '';
$zone_description = '';
$zone_location    = '';
$status           = 'Active';

$$unique = isset($_GET[$unique]) ? (int)$_GET[$unique] : 0;

/* -- POST handling ---------------------------------- */
if(isset($_POST[$shown])){

    $tr_type = 'Search';
    $$unique = isset($_POST[$unique]) ? (int)$_POST[$unique] : 0;

    if(isset($_POST['insert'])){
        $_POST['entry_by']   = $uid;
        $_POST['entry_at']   = date('Y-m-d H:i:s');
        $crud->insert();
        unset($_POST); unset($$unique);
        header("Location: ".$page."?msg=Zone+Added+Successfully"); exit;
    }

    if(isset($_POST['update'])){
        $crud->update($unique);
        header("Location: ".$page."?msg=Updated+Successfully"); exit;
    }

    if(isset($_POST['delete'])){
        $crud->delete($unique.'='.$$unique);
        unset($$unique);
        header("Location: ".$page."?msg=Deleted+Successfully"); exit;
    }
}

/* -- Load record for edit --------------------------- */
if($$unique > 0){
    $data = db_fetch_object($table, $unique.'='.$$unique);
    if($data) foreach($data as $k => $v) $$k = $v;
}
$tr_no = $$unique;
?>

<script>
function DoNav(theUrl){
    document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;
}
</script>

<div class="container-fluid p-0">
<div class="row">

<!-- ============ LEFT — LIST ============ -->
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">

    <div class="container p-0">
    <form class="n-form1 pt-0" method="post" action="">
        <h4 align="center" class="n-form-titel1">Search Access Zone</h4>

        <input type="hidden" name="<?=$shown?>" value="1">

        <div class="form-group row m-0 pl-3 pr-3">
            <label class="col-sm-3 pl-0 pr-0 col-form-label">Zone Name</label>
            <div class="col-sm-9 p-0">
                <input type="text" name="f_name"
                       value="<?= isset($_POST['f_name']) ? htmlspecialchars($_POST['f_name']) : '' ?>">
            </div>
        </div>

        <div class="form-group row m-0 pl-3 pr-3">
            <label class="col-sm-3 pl-0 pr-0 col-form-label">Status</label>
            <div class="col-sm-9 p-0">
                <select name="f_status" id="f_status">
                    <option value="">-- All --</option>
                    <option value="Active"   <?= (isset($_POST['f_status']) && $_POST['f_status']==='Active')  ?'selected':''?>>Active</option>
                    <option value="Inactive" <?= (isset($_POST['f_status']) && $_POST['f_status']==='Inactive')?'selected':''?>>Inactive</option>
                </select>
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
            <th>Zone Name</th>
            <th>Location</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody class="tbody1">
        <?php
        if(isset($_POST['search'])){
            if(!empty($_POST['f_name']))   $con = " AND zone_name LIKE '%".addslashes($_POST['f_name'])."%'";
            if(!empty($_POST['f_status'])) $con .= " AND status='".addslashes($_POST['f_status'])."'";
        }

        $query = db_query("SELECT * FROM ".$table." WHERE 1 ".$con." ORDER BY id ASC");
        $sl    = 1;
        $bc    = ['Active'=>'#28a745', 'Inactive'=>'#6c757d'];

        if($query) while($row = mysqli_fetch_object($query)){
            $bg = isset($bc[$row->status]) ? $bc[$row->status] : '#6c757d';
        ?>
        <tr onclick="DoNav('<?=$row->id?>')" style="cursor:pointer;">
            <td><?=$sl++?></td>
            <td style="text-align:left;font-weight:600;"><?=htmlspecialchars($row->zone_name)?></td>
            <td style="text-align:left;"><?=htmlspecialchars($row->zone_location ?: '-')?></td>
            <td style="text-align:left;font-size:12px;color:#6c757d;">
                <?= !empty($row->zone_description)
                    ? htmlspecialchars(strlen($row->zone_description)>50 ? substr($row->zone_description,0,50).'...' : $row->zone_description)
                    : '-' ?>
            </td>
            <td>
                <span style="background:<?=$bg?>;color:#fff;padding:2px 8px;border-radius:3px;font-size:11px;font-weight:600;">
                    <?=$row->status?>
                </span>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    </div>

</div><!-- /left -->

<!-- ============ RIGHT — FORM ============ -->
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6  setup-right">
<form class="n-form setup-fixed" action="<?=$page?>" method="post" name="form1" id="form1">

    <h4 align="center" class="n-form-titel1">
        <?= $$unique > 0 ? 'Update Access Zone' : 'Create Access Zone' ?>
    </h4>

    <input type="hidden" name="<?=$unique?>"  value="<?=$$unique?>">
    <input type="hidden" name="<?=$shown?>"   id="zone_name_trigger"
           value="<?=htmlspecialchars($zone_name)?>">
    <div class="form-group row m-0 pl-3 pr-3">
        <label class="col-sm-4 pl-0 pr-0 col-form-label ">Company</label>
        <div class="col-sm-8 p-0">
			<select id="group_for" name="group_for" class="form-control" type="text" value="<?=$_POST['group_for']?>"  <? if(!empty($group_for)){ echo'disabled';} ?> >
			<option></option>
				<? user_company_access($_POST['group_for']); ?>
			</select>
        </div>
    </div>
	
    <div class="form-group row m-0 pl-3 pr-3">
        <label class="col-sm-4 pl-0 pr-0 col-form-label ">Zone Name</label>
        <div class="col-sm-8 p-0">
            <input type="text" name="zone_name" required
                   value="<?=htmlspecialchars($zone_name)?>"
                   oninput="document.getElementById('zone_name_trigger').value=this.value">
        </div>
    </div>

    <div class="form-group row m-0 pl-3 pr-3">
        <label class="col-sm-4 pl-0 pr-0 col-form-label">Location</label>
        <div class="col-sm-8 p-0">
            <input type="text" name="zone_location"
                   value="<?=htmlspecialchars($zone_location)?>"
                   placeholder="e.g. Ground Floor, Block A">
        </div>
    </div>

    <div class="form-group row m-0 pl-3 pr-3">
        <label class="col-sm-4 pl-0 pr-0 col-form-label">Description</label>
        <div class="col-sm-8 p-0">
            <textarea name="zone_description" rows="3"
                      placeholder="Describe this zone..."><?=htmlspecialchars($zone_description)?></textarea>
        </div>
    </div>

    <div class="form-group row m-0 pl-3 pr-3">
        <label class="col-sm-4 pl-0 pr-0 col-form-label">Status</label>
        <div class="col-sm-8 p-0">
            <select name="status" id="status">
                <option value="Active"   <?=$status==='Active'  ?'selected':''?>>Active</option>
                <option value="Inactive" <?=$status==='Inactive'?'selected':''?>>Inactive</option>
            </select>
        </div>
    </div>

    <div class="n-form-btn-class">
        <?php if($$unique == 0){ ?>
        <input name="insert" type="submit" value="SAVE"   class="btn1 btn1-bg-submit">
        <?php } ?>
        <?php if($$unique > 0){ ?>
        <input name="update" type="submit" value="UPDATE" class="btn1 btn1-bg-update">
        <input name="delete" type="submit" value="DELETE" class="btn1 btn1-bg-delete"
               onclick="return confirm('Delete this zone?')">
        <?php } ?>
        <input type="button" value="RESET" class="btn1 btn1-bg-cancel"
               onclick="parent.location='<?=$page?>'">
    </div>

</form>
</div><!-- /right -->

</div>
</div>

<?php
selected_two('#f_status');
selected_two('#status');
require_once SERVER_CORE."routing/layout.bottom.php";
?>