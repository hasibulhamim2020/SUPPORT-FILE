 <?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// -- Page Meta Variables (used by inc_main_layout.php) ------------------------
$title       = "Module Under Construction";
$module_name = "Visitor Management System — Coming Soon";
$help        = "This module is currently under active development. It will be available shortly.";
?>

<!-- ------------------------------------------------------------------
     UNDER CONSTRUCTION / UPCOMING FEATURE PAGE
     Rendered inside .sr-main-content-padding via $main_content
-------------------------------------------------------------------- -->
<style>
/* -- Scoped to this page only ------------------------------------- */
.uc-wrapper {
    font-family: inherit;
    padding: 10px 0 40px;
}

/* Hero banner */
.uc-hero {
    background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
    border-radius: 12px;
    padding: 48px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.18);
}

.uc-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle at 20% 50%, rgba(0,200,255,0.08) 0%, transparent 60%),
        radial-gradient(circle at 80% 30%, rgba(255,107,53,0.07) 0%, transparent 50%);
}

.uc-hero-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.08);
    border: 2px solid rgba(0,200,255,0.35);
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    position: relative;
}

.uc-hero-icon i {
    font-size: 34px;
    color: #00c8ff;
}

.uc-hero h2 {
    font-size: 32px;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 8px;
    letter-spacing: -0.5px;
}

.uc-hero p {
    color: rgba(255,255,255,0.55);
    font-size: 15px;
    max-width: 520px;
    margin: 0 auto 28px;
    line-height: 1.7;
}

/* Pulsing status badge */
.uc-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 100px;
    padding: 7px 18px;
    font-size: 12px;
    color: rgba(255,255,255,0.5);
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.uc-pulse-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ff6b35;
    box-shadow: 0 0 0 0 rgba(255,107,53,0.6);
    animation: uc-pulse 2s ease-in-out infinite;
}

@keyframes uc-pulse {
    0%   { box-shadow: 0 0 0 0   rgba(255,107,53,0.6); }
    70%  { box-shadow: 0 0 0 8px rgba(255,107,53,0); }
    100% { box-shadow: 0 0 0 0   rgba(255,107,53,0); }
}

/* Progress bar */
.uc-progress-wrap {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 8px;
    padding: 16px 20px;
    margin: 24px auto 0;
    max-width: 480px;
    position: relative;
}

.uc-progress-labels {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: rgba(255,255,255,0.35);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.uc-progress-labels strong { color: #00c8ff; }

.uc-progress-track {
    height: 5px;
    background: rgba(255,255,255,0.08);
    border-radius: 100px;
    overflow: hidden;
}

.uc-progress-fill {
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, #00c8ff, #0077b6);
    border-radius: 100px;
    box-shadow: 0 0 10px rgba(0,200,255,0.5);
    transition: width 2s cubic-bezier(0.22,1,0.36,1);
}

@media (max-width: 576px) {
    .uc-hero { padding: 32px 20px; }
    .uc-hero h2 { font-size: 24px; }
}
</style>

<div class="uc-wrapper">

    <!-- -- HERO -- -->
    <div class="uc-hero">
        <div class="uc-hero-icon">
            <i class="fas fa-id-badge"></i>
        </div>
        <h2>Visitor Management System</h2>
        <p>This module is currently under active development. Our team is working to deliver a complete, real-time visitor access control platform.</p>
        <div class="uc-status-badge">
            <span class="uc-pulse-dot"></span>
            Under Development — Coming Soon
        </div>

        <!-- Progress Bar -->
        <div class="uc-progress-wrap">
            <div class="uc-progress-labels">
                <span>Build Progress</span>
                <strong id="uc-pct-label">0%</strong>
            </div>
            <div class="uc-progress-track">
                <div class="uc-progress-fill" id="ucProgressBar"></div>
            </div>
        </div>
    </div>


</div>

<script>
(function () {
    var pct = 72;
    setTimeout(function () {
        document.getElementById('ucProgressBar').style.width = pct + '%';
        var start = 0, step = Math.ceil(pct / 40);
        var timer = setInterval(function () {
            start = Math.min(start + step, pct);
            document.getElementById('uc-pct-label').textContent = start + '%';
            if (start >= pct) clearInterval(timer);
        }, 40);
    }, 300);
})();
</script>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>