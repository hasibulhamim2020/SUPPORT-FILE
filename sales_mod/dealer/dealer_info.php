<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";

$tr_type = "Show";

$title = 'Customer Information';

do_datatable('vendor_table');

$page   = "dealer_info.php";
$table  = 'dealer_info';
$unique = 'dealer_code';
$shown  = 'dealer_name_e';

$tr_type = "show";

$user_group_define = find_a_field('company_define ', 'GROUP_CONCAT(company_id ORDER BY company_id ASC)', 'user_id="' . $_SESSION['user']['id'] . '" and status="Active"');

?>

<script type="text/javascript">
    function DoNav(theUrl) {
        document.location.href = 'dealer_info_entry.php?<?= $unique ?>=' + theUrl;
    }
</script>

<div class="form-container_large">

    <h4 class="text-center bg-titel bold pt-2 pb-2 text-uppercase"><?= $title ?></h4>

    <div class="container-fluid bg-form-titel">

        <div class="n-form-btn-class">
            <a href="dealer_info_entry.php">
                <button type="button" class="btn1 btn1-bg-submit">
                    <i class="fa-regular fa-plus"></i> New Customer Add
                </button>
            </a>
        </div>

        <div class="container-fluid pt-2 p-0">
            <table id="vendor_table" class="table1 table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                    <tr class="bgc-info">
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>GL Code</th>
                        <th>Address</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="tbody1">
                    <?php
                    $con = '';
                    $td = 'select a.' . $unique . ', a.' . $shown . ', a.address_e, a.account_code, a.entry_at
                           from ' . $table . ' a, user_group u
                           where a.group_for=u.id and a.group_for in (' . $user_group_define . ')
                           ' . $con . ' order by a.dealer_code';

                    $report = db_query($td);
                    $i = 0;
                    while ($rp = mysqli_fetch_row($report)) {
                        $i++;
                    ?>
                        <tr onclick="DoNav('<?= $rp[0]; ?>');" bgcolor="<?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>">
                            <td><?= $rp[0]; ?></td>
                            <td style="text-align:left"><?= $rp[1]; ?></td>
                            <td><?= $rp[3]; ?></td>
                            <td style="text-align:left"><?= $rp[2]; ?></td>
                            <td style="text-align:left"><?= $rp[4]; ?></td>
                            <td>
                                <button type="button" onclick="DoNav('<?= $rp[0]; ?>');" class="btn2 btn1-bg-update">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<script type="text/javascript">
    var pager = new Pager('grp', 10000);
    pager.init();
    pager.showPageNav('pager', 'pageNavPosition');
    pager.showPage(1);

    document.onkeypress = function (e) {
        var e = window.event || e;
        var keyunicode = e.charCode || e.keyCode;
        if (keyunicode == 13) { return false; }
    }
</script>

<?php require_once SERVER_CORE . "routing/layout.bottom.php"; ?>