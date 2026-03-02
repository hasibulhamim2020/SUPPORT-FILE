<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'VMS Dashboard';
$grp   = $_SESSION['user']['group'];
$uid   = $_SESSION['user']['id'];
$today = date('Y-m-d');

$cnt_inside      = find_a_field('vms_visitor_master','COUNT(id)',"approval_status='CheckedIn' AND group_for='".$grp."'");
$cnt_today       = find_a_field('vms_visitor_master','COUNT(id)',"check_in_date='".$today."' AND group_for='".$grp."'");
$cnt_out_today   = find_a_field('vms_visitor_master','COUNT(id)',"check_out_date='".$today."' AND approval_status='CheckedOut' AND group_for='".$grp."'");
$cnt_pending     = find_a_field('vms_pre_registration','COUNT(id)',"status='Pending' AND group_for='".$grp."'");
$cnt_cards_used  = find_a_field('vms_card_pool','COUNT(id)',"card_status='Assigned' AND group_for='".$grp."'");
$cnt_cards_avail = find_a_field('vms_card_pool','COUNT(id)',"card_status='Available' AND group_for='".$grp."'");
$cnt_zones       = find_a_field('vms_access_zone','COUNT(id)',"status='Active' AND (group_for='0' OR group_for='".$grp."')");

$trend_labels = [];
$trend_counts = [];
for($i = 6; $i >= 0; $i--){
    $d              = date('Y-m-d', strtotime("-$i days"));
    $trend_labels[] = date('D d', strtotime("-$i days"));
    $trend_counts[] = (int)find_a_field('vms_visitor_master','COUNT(id)',"check_in_date='".$d."' AND group_for='".$grp."'");
}

$type_rows = [];
$r = db_query("SELECT t.visitor_type_name, COUNT(v.id) AS cnt
               FROM vms_visitor_master v
               LEFT JOIN vms_visitor_type t ON t.id = v.visitor_type_id
               WHERE v.group_for='".$grp."' AND v.check_in_date='".$today."'
               GROUP BY v.visitor_type_id, t.visitor_type_name ORDER BY cnt DESC");
while($row = mysqli_fetch_object($r)) $type_rows[] = $row;

$zone_rows = [];
$r = db_query("SELECT z.zone_name, COUNT(v.id) AS cnt
               FROM vms_access_zone z
               LEFT JOIN vms_visitor_master v ON v.zone_id = z.id AND v.visitor_status='In' AND v.group_for='".$grp."'
               WHERE z.status='Active' AND (z.group_for='0' OR z.group_for='".$grp."')
               GROUP BY z.id, z.zone_name ORDER BY z.zone_name");
while($row = mysqli_fetch_object($r)) $zone_rows[] = $row;

$q_feed = db_query("SELECT v.visitor_name, v.visitor_no, v.visitor_status, v.check_in_time, v.check_out_time,
                           t.visitor_type_name, z.zone_name, pb.PBI_NAME AS host_name
                    FROM vms_visitor_master v
                    LEFT JOIN vms_visitor_type t         ON t.id       = v.visitor_type_id
                    LEFT JOIN user_activity_management u  ON u.user_id  = v.host_pbi_id
                    LEFT JOIN personnel_basic_info pb     ON pb.PBI_ID  = u.PBI_ID
                    LEFT JOIN vms_access_zone z           ON z.id       = v.zone_id
                    WHERE v.group_for='".$grp."' AND v.check_in_date='".$today."'
                    ORDER BY v.id DESC LIMIT 12");

$q_inside = db_query("SELECT v.id, v.visitor_name, v.visitor_no, v.card_no, v.check_in_time, v.visit_time_to,
                             t.visitor_type_name, z.zone_name, pb.PBI_NAME AS host_name
                      FROM vms_visitor_master v
                      LEFT JOIN vms_visitor_type t         ON t.id       = v.visitor_type_id
                      LEFT JOIN user_activity_management u  ON u.user_id  = v.host_pbi_id
                      LEFT JOIN personnel_basic_info pb     ON pb.PBI_ID  = u.PBI_ID
                      LEFT JOIN vms_access_zone z           ON z.id       = v.zone_id
                      WHERE v.group_for='".$grp."' AND v.approval_status='CheckedIn'
                      ORDER BY v.check_in_time DESC LIMIT 10");

$q_queue = db_query("SELECT p.id, p.visitor_name, p.visit_date, p.visit_time_from,
                            t.visitor_type_name, pb.PBI_NAME AS host_name, d.DEPT_DESC AS dept_name
                     FROM vms_pre_registration p
                     LEFT JOIN vms_visitor_type t         ON t.id       = p.visitor_type_id
                     LEFT JOIN user_activity_management u  ON u.user_id  = p.host_pbi_id
                     LEFT JOIN personnel_basic_info pb     ON pb.PBI_ID  = u.PBI_ID
                     LEFT JOIN department d               ON d.DEPT_ID   = p.host_department
                     WHERE p.group_for='".$grp."' AND p.status='Pending'
                     ORDER BY p.visit_date ASC, p.visit_time_from ASC LIMIT 8");
?>

<style>
.vms-stat           { border-radius:6px; padding:10px 14px; color:#fff; display:flex; align-items:center; gap:12px; }
.vms-stat-primary   { background:#2563eb; }
.vms-stat-warning   { background:#f0ad4e; }
.vms-stat-info      { background:#17a2b8; }
.vms-stat-secondary { background:#6c757d; }
.vms-stat-icon      { font-size:24px; opacity:.7; }
.vms-stat-num       { font-size:24px; font-weight:700; line-height:1; }
.vms-stat-label     { font-size:11px; margin-top:2px; }
.vms-stat-sub       { font-size:10px; opacity:.8; margin-top:2px; }
.vms-cb             { display:inline-block; padding:2px 8px; border-radius:3px; font-size:11px; font-weight:600; white-space:nowrap; }
.vms-cb-in          { background:#28a745; color:#fff; }
.vms-cb-out         { background:#6c757d; color:#fff; }
.vms-panel          { background:#fff; border:1px solid #dee2e6; border-radius:6px; padding:14px 16px; height:100%; }
.vms-panel-title    { font-size:12px; font-weight:700; color:#495057; margin-bottom:12px; text-transform:uppercase; letter-spacing:.05em; display:flex; align-items:center; gap:7px; }
.vms-chart-box      { background:#fff; border:1px solid #dee2e6; border-radius:6px; padding:14px 16px; }
.vms-chart-title    { font-size:12px; font-weight:700; color:#495057; margin-bottom:10px; text-transform:uppercase; letter-spacing:.05em; }
.vms-feed-row       { display:flex; align-items:flex-start; gap:10px; padding:8px 0; border-bottom:1px solid #f1f5f9; }
.vms-feed-row:last-child { border-bottom:none; }
.vms-feed-dot       { width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; flex-shrink:0; margin-top:1px; }
.vms-feed-name      { font-size:12.5px; font-weight:700; }
.vms-feed-meta      { font-size:11px; color:#6c757d; margin-top:1px; }
.vms-feed-time      { font-size:11px; color:#6c757d; white-space:nowrap; margin-left:auto; padding-left:8px; }
.vms-zone-row       { display:flex; align-items:center; gap:8px; margin-bottom:8px; }
.vms-zone-name      { font-size:12px; font-weight:600; width:110px; flex-shrink:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.vms-zone-bar-w     { flex:1; background:#e9ecef; border-radius:99px; height:8px; }
.vms-zone-bar       { height:8px; border-radius:99px; background:#17a2b8; transition:width .5s; }
.vms-zone-cnt       { font-size:12px; font-weight:700; color:#17a2b8; width:24px; text-align:right; flex-shrink:0; }
.vms-aq-row         { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f1f5f9; }
.vms-aq-row:last-child { border-bottom:none; }
.vms-aq-avatar      { width:34px; height:34px; border-radius:50%; background:#dbeafe; color:#2563eb; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; flex-shrink:0; }
.vms-aq-name        { font-size:12.5px; font-weight:700; }
.vms-aq-sub         { font-size:11px; color:#6c757d; margin-top:1px; }
.vms-aq-date        { font-size:11px; color:#6c757d; white-space:nowrap; }
.vms-empty          { text-align:center; padding:28px 0; color:#adb5bd; font-size:12px; }
.vms-empty i        { font-size:28px; display:block; margin-bottom:8px; opacity:.4; }
.fw-600             { font-weight:600; }
</style>

<div class="form-container_large">

<div class="container-fluid py-2 px-1">
<div class="row">
    <div class="col-sm-3 p-1">
        <div class="vms-stat vms-stat-primary">
            <i class="fa-solid fa-person-walking-arrow-right vms-stat-icon"></i>
            <div>
                <div class="vms-stat-num"><?=$cnt_inside?></div>
                <div class="vms-stat-label">Currently Inside</div>
                <div class="vms-stat-sub"><?=$cnt_today?> checked in today</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 p-1">
        <div class="vms-stat vms-stat-warning">
            <i class="fa-solid fa-clock-rotate-left vms-stat-icon"></i>
            <div>
                <div class="vms-stat-num"><?=$cnt_pending?></div>
                <div class="vms-stat-label">Pending Approvals</div>
                <div class="vms-stat-sub">Pre-registration queue</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 p-1">
        <div class="vms-stat vms-stat-info">
            <i class="fa-solid fa-id-card vms-stat-icon"></i>
            <div>
                <div class="vms-stat-num"><?=$cnt_cards_used?></div>
                <div class="vms-stat-label">Cards Assigned</div>
                <div class="vms-stat-sub"><?=$cnt_cards_avail?> available in pool</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 p-1">
        <div class="vms-stat vms-stat-secondary">
            <i class="fa-solid fa-right-from-bracket vms-stat-icon"></i>
            <div>
                <div class="vms-stat-num"><?=$cnt_out_today?></div>
                <div class="vms-stat-label">Checked Out Today</div>
                <div class="vms-stat-sub"><?=$cnt_zones?> active zones</div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="container-fluid px-1 pb-1">
<div class="row">

    <div class="col-sm-8 p-1">
        <div class="vms-chart-box">
            <div class="vms-chart-title"><i class="fa-solid fa-chart-line" style="color:#2563eb;"></i> 7-Day Visitor Trend</div>
            <div style="position:relative;height:190px;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-sm-4 p-1">
        <div class="vms-chart-box" style="height:100%;">
            <div class="vms-chart-title"><i class="fa-solid fa-map-location-dot" style="color:#17a2b8;"></i> Zone Occupancy</div>
            <?
            $max_zone = 1;
            foreach($zone_rows as $z) if($z->cnt > $max_zone) $max_zone = $z->cnt;
            if(empty($zone_rows)){
            ?>
            <div class="vms-empty"><i class="fa-solid fa-map"></i>No zones configured</div>
            <?
            } else {
                foreach($zone_rows as $z){
                    $pct = $z->cnt > 0 ? round($z->cnt / $max_zone * 100) : 0;
            ?>
            <div class="vms-zone-row">
                <span class="vms-zone-name" title="<?=htmlspecialchars($z->zone_name)?>"><?=htmlspecialchars($z->zone_name)?></span>
                <div class="vms-zone-bar-w"><div class="vms-zone-bar" style="width:<?=$pct?>%;"></div></div>
                <span class="vms-zone-cnt"><?=$z->cnt?></span>
            </div>
            <? } } ?>
        </div>
    </div>

</div>
</div>

<div class="container-fluid px-1 pb-1">
<div class="row">

    <div class="col-sm-8 p-1">
        <div class="vms-chart-box">
            <div class="vms-chart-title"><i class="fa-solid fa-bell" style="color:#f0ad4e;"></i> Today's Activity</div>
            <?
            $feed_empty = true;
            if($q_feed) while($row = mysqli_fetch_object($q_feed)){
                $feed_empty = false;
					$is_in  = $row->visitor_status === 'In';
					$is_out = $row->visitor_status === 'Out';
                $dot_bg = $is_in ? '#d1fae5' : '#f1f5f9';
                $dot_cl = $is_in ? '#065f46'  : '#6c757d';
                $dot_ic = $is_in ? 'fa-right-to-bracket' : 'fa-right-from-bracket';
                $time   = $is_in
                    ? ($row->check_in_time  ? date('H:i', strtotime($row->check_in_time))  : '')
                    : ($row->check_out_time ? date('H:i', strtotime($row->check_out_time)) : '');
            ?>
            <div class="vms-feed-row">
                <div class="vms-feed-dot" style="background:<?=$dot_bg?>;color:<?=$dot_cl?>;"><i class="fa-solid <?=$dot_ic?>"></i></div>
                <div style="flex:1;min-width:0;">
                    <div class="vms-feed-name">
                        <?=htmlspecialchars($row->visitor_name)?>
						<span class="vms-cb <?= $is_in ? 'vms-cb-in' : ($is_out ? 'vms-cb-out' : 'vms-cb-registered') ?>">
						<?= $is_in ? 'IN' : ($is_out ? 'OUT' : 'REGISTERED') ?></span>
                    </div>
                    <div class="vms-feed-meta">
                        <?=htmlspecialchars($row->visitor_type_name ?: 'Visitor')?>
                        <?=$row->host_name ? ' &middot; '.htmlspecialchars($row->host_name) : ''?>
                        <?=$row->zone_name ? ' &middot; '.htmlspecialchars($row->zone_name) : ''?>
                    </div>
                </div>
                <div class="vms-feed-time"><?=$time?></div>
            </div>
            <? } ?>
            <? if($feed_empty){ ?><div class="vms-empty"><i class="fa-solid fa-inbox"></i>No visitor activity today yet</div><? } ?>
        </div>
    </div>

    <div class="col-sm-4 p-1">
        <div class="vms-chart-box" style="height:100%;">
            <div class="vms-chart-title"><i class="fa-solid fa-chart-pie" style="color:#7c3aed;"></i> Visitor Types Today</div>
            <?
            if(empty($type_rows)){
            ?>
            <div class="vms-empty"><i class="fa-solid fa-users"></i>No visitors today yet</div>
            <?
            } else {
            ?>
            <div style="position:relative;height:160px;">
                <canvas id="typeChart"></canvas>
            </div>
            <div id="typeLegend" style="margin-top:12px;display:flex;flex-wrap:wrap;gap:6px;"></div>
            <? } ?>
        </div>
    </div>

</div>
</div>

<div class="container-fluid px-1 pb-1">
<div class="row">

    <div class="col-sm-8 p-1">
        <div class="vms-panel">
            <div class="vms-panel-title">
                <i class="fa-solid fa-person-circle-check" style="color:#28a745;"></i> Currently Inside
                <span style="margin-left:auto;font-size:11px;font-weight:400;color:#6c757d;"><?=$cnt_inside?> visitor<?=$cnt_inside!=1?'s':''?></span>
            </div>
            <?
            $inside_empty = true;
            if($q_inside){
            ?>
            <table class="table1 table-striped table-bordered table-hover table-sm" cellspacing="0">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>#</th>
                    <th>Visitor No</th>
                    <th>Visitor Name</th>
                    <th>Type</th>
                    <th>Card</th>
                    <th>Host</th>
                    <th>Zone</th>
                    <th>Check-In</th>
                    <th>Valid To</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="tbody1">
                <?
                $sl = 1;
                while($row = mysqli_fetch_object($q_inside)){
                    $inside_empty = false;
                    $expiring     = $row->visit_time_to && strtotime($row->visit_time_to) < strtotime('+30 minutes');
                ?>
                <tr>
                    <td><?=$sl++?></td>
                    <td class="fw-600" style="white-space:nowrap;"><?=htmlspecialchars($row->visitor_no)?></td>
                    <td style="text-align:left;font-weight:600;"><?=htmlspecialchars($row->visitor_name)?></td>
                    <td><?=htmlspecialchars($row->visitor_type_name ?: '-')?></td>
                    <td>
                        <? if(!empty($row->card_no)){ ?>
                        <span style="background:#17a2b8;color:#fff;padding:2px 8px;border-radius:3px;font-size:11px;font-weight:600;"><?=htmlspecialchars($row->card_no)?></span>
                        <? } else { echo '-'; } ?>
                    </td>
                    <td style="text-align:left;"><?=htmlspecialchars($row->host_name ?: '-')?></td>
                    <td><?=htmlspecialchars($row->zone_name ?: '-')?></td>
                    <td style="white-space:nowrap;font-size:11px;"><?=$row->check_in_time ? date('H:i', strtotime($row->check_in_time)) : '-'?></td>
                    <td style="white-space:nowrap;font-size:11px;<?=$expiring?'color:#dc3545;font-weight:700;':''?>">
                        <?=htmlspecialchars($row->visit_time_to ?: '-')?>
                        <? if($expiring){ ?> <i class="fa-solid fa-triangle-exclamation" style="font-size:10px;color:#dc3545;"></i><? } ?>
                    </td>
                    <td style="white-space:nowrap;">
                        <button type="button" class="btn2 btn1-bg-submit" onclick="parent.location='../visitor_registration/checked_in_view.php?id=<?=$row->id?>'">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </td>
                </tr>
                <? } ?>
                </tbody>
            </table>
            <? } ?>
            <? if($inside_empty){ ?><div class="vms-empty"><i class="fa-solid fa-building"></i>No visitors currently on premises</div><? } ?>
        </div>
    </div>

    <div class="col-sm-4 p-1">
        <div class="vms-panel">
            <div class="vms-panel-title">
                <i class="fa-solid fa-clipboard-check" style="color:#f0ad4e;"></i> Approval Queue
                <? if($cnt_pending > 0){ ?>
                <a href="../visitor_pre_reg/visitor_unapproved_view.php" style="margin-left:auto;font-size:11px;font-weight:600;color:#2563eb;text-decoration:none;">
                    View All <i class="fa-solid fa-arrow-right fa-xs"></i>
                </a>
                <? } ?>
            </div>
            <?
            $queue_empty = true;
            if($q_queue) while($row = mysqli_fetch_object($q_queue)){
                $queue_empty = false;
            ?>
            <div class="vms-aq-row">
                <div class="vms-aq-avatar"><?=strtoupper(mb_substr($row->visitor_name,0,1))?></div>
                <div style="flex:1;min-width:0;">
                    <div class="vms-aq-name"><?=htmlspecialchars($row->visitor_name)?></div>
                    <div class="vms-aq-sub">
                        <?=htmlspecialchars($row->visitor_type_name ?: 'Visitor')?>
                        <?=$row->host_name ? ' &middot; '.htmlspecialchars($row->host_name) : ''?>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:4px;">
                    <span class="vms-aq-date"><?=date('d M', strtotime($row->visit_date))?> <?=date('H:i', strtotime($row->visit_time_from))?></span>
                    <button type="button" class="btn2 btn1-bg-submit" onclick="parent.location='../visitor_pre_reg/visitor_pre_registration.php?id=<?=(int)$row->id?>'">
                        <i class="fa-solid fa-pen-to-square"></i> Review
                    </button>
                </div>
            </div>
            <? } ?>
            <? if($queue_empty){ ?><div class="vms-empty"><i class="fa-regular fa-circle-check"></i>All approvals are up to date</div><? } ?>
        </div>
    </div>

</div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
    var trendCtx = document.getElementById('trendChart');
    if(trendCtx){
        new Chart(trendCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: <?=json_encode($trend_labels)?>,
                datasets: [{
                    label: 'Check-ins',
                    data: <?=json_encode($trend_counts)?>,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.08)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#6c757d' } },
                    y: { grid: { color: '#f1f5f9' }, beginAtZero: true,
                         ticks: { stepSize: 1, font: { size: 11 }, color: '#6c757d', callback: function(v){ return Number.isInteger(v) ? v : ''; } } }
                }
            }
        });
    }

    var typeRows = <?=json_encode(array_map(function($r){ return ['label'=>($r->visitor_type_name?:'Unknown'),'count'=>(int)$r->cnt]; }, $type_rows))?>;
    var palette  = ['#2563eb','#28a745','#7c3aed','#f0ad4e','#dc3545','#17a2b8','#ec4899'];
    var typeCtx  = document.getElementById('typeChart');
    if(typeCtx && typeRows.length){
        new Chart(typeCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: typeRows.map(function(t){ return t.label; }),
                datasets: [{
                    data: typeRows.map(function(t){ return t.count; }),
                    backgroundColor: typeRows.map(function(_,i){ return palette[i%palette.length]; }),
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: { legend: { display: false } }
            }
        });
        var legend = document.getElementById('typeLegend');
        if(legend){
            typeRows.forEach(function(t,i){
                var el = document.createElement('div');
                el.style.cssText = 'display:flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;';
                el.innerHTML = '<span style="width:10px;height:10px;border-radius:50%;background:'+palette[i%palette.length]+';flex-shrink:0;"></span>'+t.label+' <span style="color:#6c757d;font-weight:400;">('+t.count+')</span>';
                legend.appendChild(el);
            });
        }
    }
})();

setTimeout(function(){ location.reload(); }, 60000);
</script>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>