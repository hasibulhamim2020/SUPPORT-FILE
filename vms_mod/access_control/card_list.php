<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title   = 'Card Inventory';
$table   = 'vms_card_pool';
$unique  = 'id';
$shown   = 'card_no';
$page    = 'card_list.php';
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
$card_no     = '';
$card_type   = 'RFID';
$card_status = 'Available';
$remarks     = '';

$$unique = isset($_GET[$unique]) ? (int)$_GET[$unique] : 0;

/* -- POST handling ---------------------------------- */
if(isset($_POST[$shown])){

    $tr_type = 'Search';
    $$unique = isset($_POST[$unique]) ? (int)$_POST[$unique] : 0;

    if(isset($_POST['insert'])){
        $exists = find_a_field($table,'id',"card_no='".addslashes($_POST['card_no'])."'");
        if($exists > 0){
            header("Location: ".$page."?msg=Card+Number+Already+Exists"); exit;
        }
        $_POST['card_status'] = 'Available';
        $_POST['entry_by']    = $uid;
        $_POST['entry_at']    = date('Y-m-d H:i:s');
        $crud->insert();
        unset($_POST); unset($$unique);
        header("Location: ".$page."?msg=Card+Added+Successfully"); exit;
    }

    if(isset($_POST['update'])){
        $crud->update($unique);
        header("Location: ".$page."?msg=Updated+Successfully"); exit;
    }

    if(isset($_POST['delete'])){
        $cs = find_a_field($table,'card_status','id='.$$unique);
        if($cs !== 'Available'){
            header("Location: ".$page."?msg=Cannot+Delete+Assigned+Card"); exit;
        }
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
        <h4 align="center" class="n-form-titel1">Search Card Inventory</h4>

        <input type="hidden" name="<?=$shown?>" value="1">

        <div class="form-group row m-0 pl-3 pr-3">
            <label class="col-sm-3 pl-0 pr-0 col-form-label">Card No</label>
            <div class="col-sm-9 p-0">
                <input type="text" name="f_card_no"
                       value="<?= isset($_POST['f_card_no']) ? htmlspecialchars($_POST['f_card_no']) : '' ?>">
            </div>
        </div>

        <div class="form-group row m-0 pl-3 pr-3">
            <label class="col-sm-3 pl-0 pr-0 col-form-label">Card Type</label>
            <div class="col-sm-9 p-0">
                <select name="f_card_type" id="f_card_type">
                    <option value="">-- All --</option>
                    <option value="RFID"    <?=(isset($_POST['f_card_type'])&&$_POST['f_card_type']==='RFID')   ?'selected':''?>>RFID</option>
                    <option value="QR"      <?=(isset($_POST['f_card_type'])&&$_POST['f_card_type']==='QR')     ?'selected':''?>>QR</option>
                    <option value="Barcode" <?=(isset($_POST['f_card_type'])&&$_POST['f_card_type']==='Barcode')?'selected':''?>>Barcode</option>
                </select>
            </div>
        </div>

        <div class="form-group row m-0 pl-3 pr-3">
            <label class="col-sm-3 pl-0 pr-0 col-form-label">Status</label>
            <div class="col-sm-9 p-0">
                <select name="f_card_status" id="f_card_status">
                    <option value="">-- All --</option>
                    <option value="Available" <?=(isset($_POST['f_card_status'])&&$_POST['f_card_status']==='Available')?'selected':''?>>Available</option>
                    <option value="Assigned"  <?=(isset($_POST['f_card_status'])&&$_POST['f_card_status']==='Assigned') ?'selected':''?>>Assigned</option>
                    <option value="Lost"      <?=(isset($_POST['f_card_status'])&&$_POST['f_card_status']==='Lost')     ?'selected':''?>>Lost</option>
                    <option value="Damaged"   <?=(isset($_POST['f_card_status'])&&$_POST['f_card_status']==='Damaged')  ?'selected':''?>>Damaged</option>
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
            <th>Card No</th>
            <th>Card Type</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Entry At</th>
        </tr>
        </thead>
        <tbody class="tbody1">
        <?php
        if(isset($_POST['search'])){
            if(!empty($_POST['f_card_no']))    $con= " AND card_no LIKE '%".addslashes($_POST['f_card_no'])."%'";
            if(!empty($_POST['f_card_type']))  $con .= " AND card_type='".addslashes($_POST['f_card_type'])."'";
            if(!empty($_POST['f_card_status']))$con .= " AND card_status='".addslashes($_POST['f_card_status'])."'";
        }

        $query = db_query("SELECT * FROM ".$table." WHERE 1 ".$con." ORDER BY id ASC");
        $sl    = 1;

        $bc = [
            'Available' => ['#28a745','#fff'],
            'Assigned'  => ['#17a2b8','#fff'],
            'Lost'      => ['#dc3545','#fff'],
            'Damaged'   => ['#f0ad4e','#000'],
        ];

        if($query) while($row = mysqli_fetch_object($query)){
            $bg  = isset($bc[$row->card_status]) ? $bc[$row->card_status][0] : '#6c757d';
            $txt = isset($bc[$row->card_status]) ? $bc[$row->card_status][1] : '#fff';
        ?>
        <tr onclick="DoNav('<?=$row->id?>')" style="cursor:pointer;">
            <td><?=$sl++?></td>
            <td style="font-weight:600;"><?=htmlspecialchars($row->card_no)?></td>
            <td><?=htmlspecialchars($row->card_type)?></td>
            <td>
                <span style="background:<?=$bg?>;color:<?=$txt?>;padding:2px 8px;border-radius:3px;font-size:11px;font-weight:600;">
                    <?=$row->card_status?>
                </span>
            </td>
            <td style="text-align:left;font-size:12px;color:#6c757d;">
                <?= !empty($row->remarks) ? htmlspecialchars($row->remarks) : '—' ?>
            </td>
            <td style="font-size:11px;white-space:nowrap;color:#6c757d;">
                <?=date('d M Y', strtotime($row->entry_at))?>
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
        <?= $$unique > 0 ? 'Update Card' : 'Add New Card' ?>
    </h4>

    <input type="hidden" name="<?=$unique?>" value="<?=$$unique?>">
    <input type="hidden" name="<?=$shown?>"  id="card_no_trigger"
           value="<?=htmlspecialchars($card_no)?>">

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
        <label class="col-sm-4 pl-0 pr-0 col-form-label ">Card No</label>
        <div class="col-sm-8 p-0">
            <input type="text" name="card_no" required
                   value="<?=htmlspecialchars($card_no)?>"
                   placeholder="e.g. CARD-001"
                   style="text-transform:uppercase;"
                   oninput="document.getElementById('card_no_trigger').value=this.value"
                   <?= $$unique > 0 ? 'readonly' : '' ?>>
        </div>
    </div>

    <div class="form-group row m-0 pl-3 pr-3">
        <label class="col-sm-4 pl-0 pr-0 col-form-label ">Card Type</label>
        <div class="col-sm-8 p-0">
            <select name="card_type" id="card_type">
                <option value="RFID"    <?=$card_type==='RFID'   ?'selected':''?>>RFID</option>
                <option value="QR"      <?=$card_type==='QR'     ?'selected':''?>>QR</option>
                <option value="Barcode" <?=$card_type==='Barcode'?'selected':''?>>Barcode</option>
            </select>
        </div>
    </div>

    <div class="form-group row m-0 pl-3 pr-3">
        <label class="col-sm-4 pl-0 pr-0 col-form-label">Status</label>
        <div class="col-sm-8 p-0">
            <select name="card_status" id="card_status">
                <option value="Available" <?=$card_status==='Available'?'selected':''?>>Available</option>
                <option value="Lost"      <?=$card_status==='Lost'     ?'selected':''?>>Lost</option>
                <option value="Damaged"   <?=$card_status==='Damaged'  ?'selected':''?>>Damaged</option>
            </select>
        </div>
    </div>

    <div class="form-group row m-0 pl-3 pr-3">
        <label class="col-sm-4 pl-0 pr-0 col-form-label">Remarks</label>
        <div class="col-sm-8 p-0">
            <textarea name="remarks" rows="3"
                      placeholder="Optional notes..."><?=htmlspecialchars($remarks)?></textarea>
        </div>
    </div>

    <div class="n-form-btn-class">
        <?php if($$unique == 0){ ?>
        <input name="insert" type="submit" value="SAVE"   class="btn1 btn1-bg-submit">
        <?php } ?>
        <?php if($$unique > 0){ ?>
        <input name="update" type="submit" value="UPDATE" class="btn1 btn1-bg-update">
        <?php if($card_status === 'Available'){ ?>
        <input name="delete" type="submit" value="DELETE" class="btn1 btn1-bg-delete"
               onclick="return confirm('Delete this card?')">
        <?php } ?>
        <?php } ?>
        <input type="button" value="RESET" class="btn1 btn1-bg-cancel"
               onclick="parent.location='<?=$page?>'">
    </div>

</form>
</div><!-- /right -->

</div>
</div>

<?php
selected_two('#f_card_type');
selected_two('#f_card_status');
selected_two('#card_type');
selected_two('#card_status');
require_once SERVER_CORE."routing/layout.bottom.php";
?>