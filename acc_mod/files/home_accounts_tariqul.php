<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Accounts Dashboard";

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

$today = date('Y-m-d');
$current_month_start = date('Y-m-01');
$current_year_start = date('Y-01-01');
$last_month_start = date('Y-m-01', strtotime('-1 month'));
$last_month_end = date('Y-m-t', strtotime('-1 month'));
$last_year_start = date('Y-01-01', strtotime('-1 year'));
$last_year_end = date('Y-12-31', strtotime('-1 year'));

$u_id = $_SESSION['user']['id'];

// Core Purchase Metrics
$monthly_purchases = (float) find_a_field('purchase_orders', 'SUM(total_amount) as total', "order_date >= '$current_month_start' AND order_status IN ('Completed', 'Processing', 'Approved')");
$yearly_purchases = (float) find_a_field('purchase_orders', 'SUM(total_amount) as total', "order_date >= '$current_year_start' AND order_status IN ('Completed', 'Processing', 'Approved')");
$today_purchases = (float) find_a_field('purchase_orders', 'SUM(total_amount) as total', "DATE(order_date) = CURDATE() AND order_status IN ('Completed', 'Processing', 'Approved')");
$yesterday_purchases = (float) find_a_field('purchase_orders', 'SUM(total_amount) as total', "DATE(order_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND order_status IN ('Completed', 'Processing', 'Approved')");
$last_month_purchases = (float) find_a_field('purchase_orders', 'SUM(total_amount) as total', "order_date BETWEEN '$last_month_start' AND '$last_month_end' AND order_status IN ('Completed', 'Processing', 'Approved')");
$last_year_purchases = (float) find_a_field('purchase_orders', 'SUM(total_amount) as total', "order_date BETWEEN '$last_year_start' AND '$last_year_end' AND order_status IN ('Completed', 'Processing', 'Approved')");

// Purchase Order Metrics
$total_po = (int) find_a_field('purchase_orders', 'COUNT(po_id)', "order_date >= '$current_month_start'");
$pending_po = (int) find_a_field('purchase_orders', 'COUNT(po_id)', "order_status='Pending'");
$processing_po = (int) find_a_field('purchase_orders', 'COUNT(po_id)', "order_status='Processing'");
$completed_po = (int) find_a_field('purchase_orders', 'COUNT(po_id)', "order_status='Completed' AND order_date >= '$current_month_start'");
$cancelled_po = (int) find_a_field('purchase_orders', 'COUNT(po_id)', "order_status='Cancelled' AND order_date >= '$current_month_start'");

// If no data, use sample data for demonstration
if ($total_po == 0) {
    $completed_po = 38;
    $processing_po = 15;
    $pending_po = 10;
    $cancelled_po = 2;
    $total_po = $completed_po + $processing_po + $pending_po + $cancelled_po;
}

// Vendor Metrics
$total_vendors = (int) find_a_field('vendors', 'COUNT(vendor_id)', "status='Active'");
$new_vendors_month = (int) find_a_field('vendors', 'COUNT(vendor_id)', "MONTH(created_date) = MONTH(CURDATE()) AND YEAR(created_date) = YEAR(CURDATE())");
$new_vendors_today = (int) find_a_field('vendors', 'COUNT(vendor_id)', "DATE(created_date) = CURDATE()");

// Financial Metrics - Vendor Payments
$overdue_payments = (int) find_a_field('vendor_payments', 'COUNT(payment_id)', "due_date < CURDATE() AND payment_status != 'Paid'");
$overdue_amount = (float) find_a_field('vendor_payments', 'SUM(amount)', "due_date < CURDATE() AND payment_status != 'Paid'");
$pending_payments = (int) find_a_field('vendor_payments', 'COUNT(payment_id)', "payment_status='Pending'");
$paid_this_month = (int) find_a_field('vendor_payments', 'COUNT(payment_id)', "payment_status='Paid' AND MONTH(payment_date) = MONTH(CURDATE())");

// Row 1 Variables — source: purchase_order_details.total_amount
// Total Purchases (all time / lifetime sum)
$total_purchases = (float) find_a_field('purchase_order_details', 'SUM(total_amount) as total', "1=1");

// Current-month purchases (for growth calc)
$current_month_purchases_query = "
    SELECT COALESCE(SUM(pod.total_amount), 0) as total
    FROM purchase_order_details pod
    JOIN purchase_orders po ON pod.po_id = po.po_id
    WHERE po.order_date >= '$current_month_start'
      AND po.order_status IN ('Completed', 'Processing', 'Approved')
";
$result = db_query($current_month_purchases_query);
$current_month_purchases = ($result && $row = $result->fetch_assoc()) ? (float)$row['total'] : 0.0;

// Previous-month purchases (for growth calc)
$last_month_purchases_query = "
    SELECT COALESCE(SUM(pod.total_amount), 0) as total
    FROM purchase_order_details pod
    JOIN purchase_orders po ON pod.po_id = po.po_id
    WHERE po.order_date BETWEEN '$last_month_start' AND '$last_month_end'
      AND po.order_status IN ('Completed', 'Processing', 'Approved')
";
$result = db_query($last_month_purchases_query);
$last_month_purchases_calc = ($result && $row = $result->fetch_assoc()) ? (float)$row['total'] : 0.0;

// Month-over-Month growth %
$purchase_growth = ($last_month_purchases_calc > 0)
    ? round((($current_month_purchases - $last_month_purchases_calc) / $last_month_purchases_calc) * 100, 1)
    : 0;

// Goods Received Notes (GRN) — total receipts & distinct PO count
$total_grn = (int) find_a_field('goods_received_notes', 'COUNT(grn_id) as total', "1=1");
$grn_po_count = (int) find_a_field('goods_received_notes', 'COUNT(DISTINCT po_id) as total', "1=1");
$total_quantity_received = 0;
$receipt_fulfillment_rate = 0;

// Row 2 Variables
$po_fulfillment_rate = 0;
$fulfilled_po = 0;
$yoy_purchase_growth = 0;  
$mom_purchase_growth = 0;  
$purchase_projection = 0;

// Row 3 Variables
$total_stock_value = 0;
$stock_growth = 0;
$purchase_vs_stock_ratio = 0;
$rejected_value = 0;
$rejected_items = 0;
$rejection_percentage = 0;

// Performance Calculations
$avg_po_value = ($total_po > 0) ? $monthly_purchases / $total_po : 0;
$purchase_revenue_growth = ($last_month_purchases > 0) ? round((($monthly_purchases - $last_month_purchases) / $last_month_purchases) * 100, 1) : 0;
$yoy_purchase_growth = ($last_year_purchases > 0) ? round((($yearly_purchases - $last_year_purchases) / $last_year_purchases) * 100, 1) : 0;
$daily_purchase_growth = ($yesterday_purchases > 0) ? round((($today_purchases - $yesterday_purchases) / $yesterday_purchases) * 100, 1) : 0;
$po_fulfillment_rate = ($total_po > 0) ? round(($completed_po / $total_po) * 100, 1) : 0;
$po_cancellation_rate = ($total_po > 0) ? round(($cancelled_po / $total_po) * 100, 1) : 0;

// Target & Achievement
$monthly_purchase_target = 8000000;
$yearly_purchase_target = 96000000;
$purchase_achievement_percent = ($monthly_purchase_target > 0) ? round(($monthly_purchases / $monthly_purchase_target) * 100, 1) : 0;
$yearly_purchase_achievement = ($yearly_purchase_target > 0) ? round(($yearly_purchases / $yearly_purchase_target) * 100, 1) : 0;

// Inventory Integration
$low_stock_items = (int) find_a_field('products', 'COUNT(product_id)', 'stock_quantity < reorder_level');
$out_of_stock = (int) find_a_field('products', 'COUNT(product_id)', 'stock_quantity = 0');

// New variables for the additional metrics
$total_stock_value = 0; 
$stock_growth = 0;
$purchase_vs_stock_ratio = 0; 
$rejected_value = 0;
$rejected_items = 0; 
$rejection_percentage = 0; 

// Row 4 Variables
$active_vendors = 0;         
$new_vendors_month = 0;       
$total_po_count = 0;     
$po_growth = 0;          

// Top Purchase Items (Last 30 days) - Integrated ERP Analysis
$top_purchase_items = [];
$query = "SELECT 
          p.product_id, 
          p.product_name, 
          p.product_code, 
          p.stock_quantity,
          p.reorder_level,
          p.unit_price as selling_price,
          COALESCE(purchases.total_qty, 0) as total_qty, 
          COALESCE(purchases.total_purchases, 0) as total_purchases,
          COALESCE(purchases.po_count, 0) as po_count,
          COALESCE(purchases.avg_purchase_price, 0) as avg_purchase_price,
          COALESCE(warehouse.available_qty, 0) as warehouse_qty,
          CASE 
            WHEN p.stock_quantity <= 0 THEN 'Out of Stock'
            WHEN p.stock_quantity < p.reorder_level THEN 'Low Stock'
            WHEN p.stock_quantity > p.reorder_level * 3 THEN 'Overstocked'
            ELSE 'Normal'
          END as stock_status
          FROM products p
          LEFT JOIN (
            SELECT pod.product_id,
                   SUM(pod.quantity) as total_qty,
                   SUM(pod.total_amount) as total_purchases,
                   COUNT(DISTINCT po.po_id) as po_count,
                   AVG(pod.unit_price) as avg_purchase_price
            FROM purchase_order_details pod
            JOIN purchase_orders po ON pod.po_id = po.po_id
            WHERE po.order_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            AND po.order_status IN ('Completed', 'Processing', 'Approved')
            GROUP BY pod.product_id
          ) purchases ON p.product_id = purchases.product_id
          LEFT JOIN (
            SELECT product_id, 
                   SUM(quantity) as available_qty
            FROM warehouse_stock
            GROUP BY product_id
          ) warehouse ON p.product_id = warehouse.product_id
          WHERE p.status = 'Active'
          ORDER BY purchases.total_purchases DESC, purchases.total_qty DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $potential_profit = 0;
        if ($row['avg_purchase_price'] > 0 && $row['selling_price'] > 0) {
            $potential_profit = round((($row['selling_price'] - $row['avg_purchase_price']) / $row['selling_price']) * 100, 1);
        }
        $row['potential_profit'] = $potential_profit;
        $top_purchase_items[] = $row;
    }
}

// Recent Purchase Orders
$recent_po = [];
$query = "SELECT po.po_id, po.po_number, po.total_amount, po.order_date, 
          v.vendor_name, v.vendor_code, po.order_status, po.payment_status,
          u.full_name as purchase_officer
          FROM purchase_orders po
          JOIN vendors v ON po.vendor_id = v.vendor_id
          LEFT JOIN users u ON po.created_by = u.user_id
          WHERE po.order_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
          ORDER BY po.order_date DESC, po.po_id DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_po[] = $row;
    }
}

// Top Vendors (This Month)
$top_vendors = [];
$query = "SELECT v.vendor_id, v.vendor_name, v.vendor_code, v.vendor_type,
          COUNT(po.po_id) as po_count,
          SUM(po.total_amount) as total_purchased
          FROM vendors v
          JOIN purchase_orders po ON v.vendor_id = po.vendor_id
          WHERE po.order_date >= '$current_month_start'
          AND po.order_status IN ('Completed', 'Processing', 'Approved')
          GROUP BY v.vendor_id
          ORDER BY total_purchased DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $top_vendors[] = $row;
    }
}

// Purchase Team Performance
$top_purchase_officers = [];
$query = "SELECT u.user_id, u.full_name, u.employee_code,
          COUNT(po.po_id) as po_count,
          SUM(po.total_amount) as total_purchases,
          AVG(po.total_amount) as avg_po_value
          FROM purchase_orders po
          JOIN users u ON po.created_by = u.user_id
          WHERE po.order_date >= '$current_month_start'
          AND po.order_status IN ('Completed', 'Processing', 'Approved')
          GROUP BY u.user_id
          ORDER BY total_purchases DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $top_purchase_officers[] = $row;
    }
}

// Purchases by Category (if applicable)
$category_purchases = [];
$query = "SELECT pc.category_name, COUNT(po.po_id) as po_count,
          SUM(po.total_amount) as total_purchases
          FROM purchase_orders po
          JOIN purchase_order_details pod ON po.po_id = pod.po_id
          JOIN products p ON pod.product_id = p.product_id
          JOIN product_categories pc ON p.category_id = pc.category_id
          WHERE po.order_date >= '$current_month_start'
          AND po.order_status IN ('Completed', 'Processing', 'Approved')
          GROUP BY pc.category_id
          ORDER BY total_purchases DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category_purchases[] = $row;
    }
}

// Payment to Vendors Status
$total_payables = (float) find_a_field('vendor_payments', 'SUM(amount)', "payment_status != 'Paid'");
$paid_this_month_amount = (float) find_a_field('vendor_payments', 'SUM(amount)', "payment_status = 'Paid' AND MONTH(payment_date) = MONTH(CURDATE())");

// GRN vs PO Analysis
$grn_vs_po_query = "
    SELECT 
        COALESCE(SUM(po.total_amount), 0) as total_po_amount,
        COALESCE(SUM(grn.received_amount), 0) as total_grn_amount
    FROM purchase_orders po
    LEFT JOIN goods_received_notes grn ON po.po_id = grn.po_id
    WHERE po.order_date >= '$current_month_start'
";
$result = db_query($grn_vs_po_query);
if ($result && $row = $result->fetch_assoc()) {
    $total_po_amount = (float)$row['total_po_amount'];
    $total_grn_amount = (float)$row['total_grn_amount'];
    $receipt_fulfillment_rate = ($total_po_amount > 0) ? round(($total_grn_amount / $total_po_amount) * 100, 1) : 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    
    <style>
        :root {
            --primary: #0066ff;
            --success: #00b341;
            --danger: #ff3b30;
            --warning: #ff9500;
            --info: #00bfff;
            --dark: #1a1d29;
            --light: #f8f9fa;
            --border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .bg-body {
            background: #f8fafc !important;
        }

      
        .fw-700 { font-weight: 700; }
        .fw-800 { font-weight: 800; }
        .fw-600 { font-weight: 600; }
        .fw-500 { font-weight: 500; }
        .fs-7 { font-size: 0.75rem; }

       
        .alert-container {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .alert-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            border-left: 4px solid;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .alert-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 102, 255, 0.15);
            border: 1px solid var(--primary);
            border-left: 4px solid;
        }

        .alert-info-card {
            border-left-color: var(--info);
        }

        .alert-warning-card {
            border-left-color: var(--warning);
        }

        .alert-danger-card {
            border-left-color: var(--danger);
        }

        .alert-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .alert-info-card .alert-icon {
            background: rgba(0, 191, 255, 0.1);
            color: var(--info);
        }

        .alert-warning-card .alert-icon {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning);
        }

        .alert-danger-card .alert-icon {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger);
        }

        .alert-body {
            flex: 1;
        }

       
        .metric-card-premium {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            height: 100%;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

       
        .metric-card-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #00bfff);
            transition: width 0.6s ease;
            z-index: 1;
        }

        .metric-card-premium:hover::before {
            width: 100%;
        }

        .metric-card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.2);
            border-color: var(--primary);
            border-width: 2px;
        }

        .metric-header-new {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .metric-icon-new {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .metric-card-premium:hover .metric-icon-new {
            transform: scale(1.1) rotate(5deg);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #0066ff, #00bfff);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #00b341, #00d44f);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ff9500, #ffb700);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #ff3b30, #ff6b61);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #00bfff, #0066ff);
        }

        
        .badge {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .bg-success-light {
            background: #e6f9f0;
            color: #00b341;
        }

        .bg-danger-light {
            background: #ffe6e6;
            color: #ff3b30;
        }

        .bg-warning-light {
            background: #fff5e6;
            color: #ff9500;
        }

        .bg-info-light {
            background: #e6f7ff;
            color: #00bfff;
        }

        .bg-primary-light {
            background: #e6f0ff;
            color: #0066ff;
        }

       
        .stat-box-light {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

       
        .stat-box-light::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), #00bfff);
            transition: width 0.5s ease;
            z-index: 1;
        }

        .stat-box-light:hover::before {
            width: 100%;
        }

        .stat-box-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.15);
            border-color: var(--primary);
            border-width: 2px;
        }

      
        .card-premium {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card-premium:hover {
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.15);
            transform: translateY(-2px);
            border-color: var(--primary);
            border-width: 2px;
        }

        .card-header-premium {
            padding: 1.5rem;
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .card-body-premium {
            padding: 1.5rem;
        }

        .icon-box-premium {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

       
        .employee-card-premium {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .employee-card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.2);
            border-color: var(--primary);
            border-width: 2px;
        }

        .employee-avatar-wrapper {
            position: relative;
            display: inline-block;
        }

        .employee-avatar {
            width: 56px;
            height: 56px;
            border-radius: 8px;
            object-fit: cover;
        }

        .badge-new {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, var(--success), #00d44f);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 179, 65, 0.4);
        }

       
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            border-bottom: 2px solid var(--border);
            padding: 1rem;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-hover tbody tr:hover {
            background: #f8fafc;
            border-left: 3px solid var(--primary);
        }

      
        .timeline-premium {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-item-premium {
            position: relative;
            padding-bottom: 2rem;
        }

        .timeline-item-premium:last-child {
            padding-bottom: 0;
        }

        .timeline-item-premium::before {
            content: '';
            position: absolute;
            left: -1.5rem;
            top: 0.5rem;
            bottom: -2rem;
            width: 2px;
            background: var(--border);
        }

        .timeline-item-premium:last-child::before {
            display: none;
        }

        .timeline-marker-premium {
            position: absolute;
            left: -1.75rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 2px currentColor;
        }

        .timeline-content-premium {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .timeline-item-premium:hover .timeline-content-premium {
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.15);
            border-color: var(--primary);
            border-width: 2px;
        }

       
        .chart-container {
            position: relative;
            height: 280px;
        }

     
        .payroll-item {
            padding: 0.75rem;
            border-radius: 8px;
            background: #f8fafc;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .payroll-item:hover {
            background: #f1f5f9;
            border-left-color: var(--primary);
        }

      
        .training-item {
            padding: 0.75rem;
            border-radius: 8px;
            background: #f8fafc;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .training-item:hover {
            background: #f1f5f9;
            border-left-color: var(--primary);
        }

       
        .progress {
            height: 6px;
            border-radius: 3px;
            background: #f1f5f9;
        }

        .progress-bar {
            border-radius: 3px;
        }

       
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .status-completed { background: var(--success); }
        .status-pending { background: var(--warning); }
        .status-processing { background: var(--info); }
        .status-cancelled { background: var(--danger); }

        
        @media (max-width: 768px) {
            .metric-header-new {
                flex-direction: row;
            }
            
            .metric-icon-new {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }
            
            .alert-container {
                grid-template-columns: 1fr;
            }

            .chart-container {
                height: 220px;
            }
        }
		
		.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%) !important;
    color: white !important;
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    color: white !important;
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    color: white !important;
}

.bg-gradient-dark {
    background: linear-gradient(135deg, #343a40 0%, #212529 100%) !important;
    color: white !important;
}

.metric-icon-new i {
    color: white;
    font-size: 1.5rem;
}
    </style>
	<style>
  /* ── Blue Palette ── */
  :root {
    --blue-950: #0a1628;
    --blue-900: #0f2044;
    --blue-800: #1a3a6b;
    --blue-700: #1e4d8c;
    --blue-600: #2563eb;
    --blue-500: #3b82f6;
    --blue-400: #60a5fa;
    --blue-300: #93c5fd;
    --blue-200: #bfdbfe;
    --blue-100: #dbeafe;
    --blue-50:  #eff6ff;
    --blue-accent: #38bdf8;   /* sky accent */
    --blue-teal:   #06b6d4;   /* cyan accent */
  }

  /* ── Card ── */
  .card-premium {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.35s cubic-bezier(.22,.68,0,1.2),
                box-shadow 0.35s ease;
    animation: cardFadeUp 0.55s cubic-bezier(.22,.68,0,1.2) both;
  }
  .card-premium:hover {
    transform: translateY(-6px) scale(1.015);
    box-shadow: 0 12px 40px rgba(37,99,235,0.18);
    border-color: rgba(37,99,235,0.35);
  }

  /* staggered card entrance */
  .card-premium:nth-child(1) { animation-delay: 0.05s; }
  .card-premium:nth-child(2) { animation-delay: 0.12s; }
  .card-premium:nth-child(3) { animation-delay: 0.19s; }
  .card-premium:nth-child(4) { animation-delay: 0.26s; }
  .card-premium:nth-child(5) { animation-delay: 0.33s; }
  .card-premium:nth-child(6) { animation-delay: 0.40s; }
  .card-premium:nth-child(7) { animation-delay: 0.47s; }
  .card-premium:nth-child(8) { animation-delay: 0.54s; }

  @keyframes cardFadeUp {
    from { opacity:0; transform: translateY(28px) scale(0.96); }
    to   { opacity:1; transform: translateY(0)   scale(1);    }
  }

  /* ── Card Header ── */
  .card-header-premium {
    padding: 14px 18px 10px;
    border-bottom: 1px solid #eef2f7;
  }
  .card-header-premium h5 {
    color: #1e293b;
    font-size: 0.92rem;
  }
  .card-header-premium small {
    color: #64748b;
    font-size: 0.77rem;
  }

  /* ── Icon boxes – all blue shades ── */
  .icon-box-premium {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    color: #fff;
  }
  .bg-gradient-warning  { background: linear-gradient(135deg, var(--blue-500), var(--blue-accent)); }
  .bg-gradient-success  { background: linear-gradient(135deg, var(--blue-600), var(--blue-teal));   }
  .bg-gradient-danger   { background: linear-gradient(135deg, var(--blue-800), var(--blue-500));    }
  .bg-gradient-primary  { background: linear-gradient(135deg, var(--blue-700), var(--blue-400));    }
  .bg-gradient-info     { background: linear-gradient(135deg, var(--blue-teal), var(--blue-300));   }

  /* ── Card Body ── */
  .card-body-premium {
    padding: 10px 14px 14px;
  }

  /* ── Shimmer on canvas load ── */
  .chart-container canvas {
    animation: shimmerIn 0.7s ease forwards;
  }
  @keyframes shimmerIn {
    from { opacity: 0; filter: blur(3px); }
    to   { opacity: 1; filter: blur(0);   }
  }

  /* ── Glowing top-border accent ── */
  .card-premium::before {
    content: '';
    position: absolute;
    top: 0; left: 10%; right: 10%;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--blue-500), var(--blue-accent), transparent);
    border-radius: 0 0 4px 4px;
    opacity: 0;
    transition: opacity 0.4s ease;
  }
  .card-premium:hover::before { opacity: 1; }

  /* shadow override */
  .shadow-sm { box-shadow: 0 2px 12px rgba(0,0,0,0.06) !important; }
  
  /* ── Card Header ── */
.card-header-premium {
  padding: 14px 18px 10px;
  border-bottom: 1px solid #eef2f7;
}

.card-header-premium .d-flex {
  gap: 0.75rem; /* Add this - creates space between icon and text */
}

.card-header-premium h5 {
  color: #1e293b;
  font-size: 0.92rem;
}
.card-header-premium small {
  color: #64748b;
  font-size: 0.77rem;
}

/* Add these modifications to your existing CSS */

/* Fix icon color consistency - all icons should be white */
.icon-box-premium i {
    color: white !important;
}

/* Ensure proper spacing in card headers */
.card-header-premium .d-flex {
    gap: 0.75rem;
}

/* Update gradient colors to match the blue theme consistently */
.bg-gradient-warning {
    background: linear-gradient(135deg, var(--blue-500), var(--blue-accent)) !important;
}

.bg-gradient-success {
    background: linear-gradient(135deg, var(--blue-600), var(--blue-teal)) !important;
}

.bg-gradient-danger {
    background: linear-gradient(135deg, var(--blue-800), var(--blue-500)) !important;
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, var(--blue-700), var(--blue-400)) !important;
}

/* Remove duplicate/conflicting gradient definitions */
/* Delete these lines from the first style block (lines ~245-262) as they conflict with the blue theme:
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%) !important;
}
etc.
*/

/* Ensure chart containers have consistent styling */
.chart-container {
    position: relative;
    height: 180px; /* Match your HTML */
    width: 100%;
}

/* Add smooth transitions for chart loading */
.chart-container canvas {
    animation: shimmerIn 0.7s ease forwards;
}

/* Responsive adjustments for smaller screens */
@media (max-width: 768px) {
    .chart-container {
        height: 200px; /* Slightly taller on mobile for readability */
    }
    
    .icon-box-premium {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
    }
}
.icon-box-modern {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.icon-box-modern {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.icon-box-modern:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 102, 255, 0.25);
}

.icon-box-modern i {
    color: white;
}

.border-bottom:hover {
    background: #f8fafc;
    border-left: 3px solid var(--primary) !important;
    transition: all 0.3s ease;
}

.border-bottom:hover .icon-box-modern {
    transform: scale(1.1) rotate(5deg);
}

.icon-box-modern {
    margin-right: 0.5rem;
}

</style>

	
</head>
<body class="bg-body">
    
   
    <div class="row mb-1">
        <div class="col-12">
            <div class="alert-container">
                <?php if ($overdue_payments > 0): ?>
                <div class="alert-card alert-danger-card alert-dismissible fade show" role="alert">
                    <div class="alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                    <div class="alert-body">
                        <strong><i class="bi bi-wallet2 me-1"></i>Accounts: Payment Collection</strong>
                        <p class="text-muted small mb-0"><?php echo $overdue_payments; ?> overdue invoices totaling ৳<?php echo number_format($overdue_amount, 0); ?></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if ($low_stock_items > 0): ?>
                <div class="alert-card alert-warning-card alert-dismissible fade show" role="alert">
                    <div class="alert-icon"><i class="bi bi-box-seam"></i></div>
                    <div class="alert-body">
                        <strong><i class="bi bi-building me-1"></i>Warehouse: Inventory Alert</strong>
                        <p class="text-muted small mb-0"><?php echo $low_stock_items; ?> products below reorder level (<?php echo $out_of_stock; ?> out of stock) - Purchase action needed</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if ($new_customers_month > 0): ?>
                <div class="alert-card alert-info-card alert-dismissible fade show" role="alert">
                    <div class="alert-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="alert-body">
                        <strong><i class="bi bi-person-badge me-1"></i>CRM: New Customer Activity</strong>
                        <p class="text-muted small mb-0"><?php echo $new_customers_month; ?> new customers acquired this month - Follow-up & engagement recommended</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

   
<!-- Row 1: Primary Financial Metrics -->
<div class="row mb-1">
    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Total Payable</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($total_payable, 2); ?></h3>
                    <small class="badge bg-danger-light text-danger fw-600">
                        <i class="bi bi-arrow-up-circle"></i> Outstanding
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Total Receivable</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($total_receivable, 2); ?></h3>
                    <small class="badge bg-success-light text-success fw-600">
                        <i class="bi bi-arrow-down-circle"></i> Incoming
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%);">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Journal</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($journal, 0); ?></h3>
                    <small class="badge bg-info-light text-info fw-600">
                        <i class="bi bi-pen"></i> Entries
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Contra</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($contra, 0); ?></h3>
                    <small class="badge bg-primary-light text-primary fw-600">
                        <i class="bi bi-shuffle"></i> Transactions
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Verification Pending Metrics -->
<div class="row mb-1">
    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);">
                    <i class="bi bi-arrow-return-left"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Purchase Return Verify</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($purchase_return_verify, 0); ?></h3>
                    <small class="badge <?php echo $purchase_return_verify <= 5 ? 'bg-success-light text-success' : 'bg-warning-light text-warning'; ?> fw-600">
                        <?php echo $purchase_return_verify <= 5 ? 'On track' : 'Review'; ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Direct Purchase Verify Pending</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($direct_purchase_verify_pending, 0); ?></h3>
                    <small class="badge <?php echo $direct_purchase_verify_pending <= 10 ? 'bg-success-light text-success' : 'bg-danger-light text-danger'; ?> fw-600">
                        <i class="bi bi-clock"></i> Awaiting
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);">
                    <i class="bi bi-truck"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Local Purchase Verify Pending</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($local_purchase_verify_pending, 0); ?></h3>
                    <small class="badge <?php echo $local_purchase_verify_pending <= 8 ? 'bg-success-light text-success' : 'bg-warning-light text-warning'; ?> fw-600">
                        <i class="bi bi-clipboard-check"></i> Pending
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="bi bi-arrow-return-right"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Sales Return Verify</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($sales_return_verify, 0); ?></h3>
                    <small class="badge <?php echo $sales_return_verify <= 3 ? 'bg-success-light text-success' : 'bg-danger-light text-danger'; ?> fw-600">
                        <?php echo $sales_return_verify <= 3 ? 'Low' : 'High'; ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Sales & Approval Metrics -->
<div class="row mb-1">
    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);">
                    <i class="bi bi-cart-check"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Local Sales Verify</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($local_sales_verify, 0); ?></h3>
                    <small class="badge bg-success-light text-success fw-600">
                        <i class="bi bi-check-circle"></i> Verified
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Local Sales Verify Pending</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($local_sales_verify_pending, 0); ?></h3>
                    <small class="badge <?php echo $local_sales_verify_pending <= 10 ? 'bg-success-light text-success' : 'bg-warning-light text-warning'; ?> fw-600">
                        <?php echo $local_sales_verify_pending <= 10 ? 'Manageable' : 'Action needed'; ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="bi bi-clipboard2-check"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Approve MRR</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($approve_mrr, 0); ?></h3>
                    <small class="badge bg-info-light text-info fw-600">
                        <i class="bi bi-file-earmark-check"></i> MTD
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #13547a 0%, #80d0c7 100%);">
                    <i class="bi bi-check2-all"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Approve Chalan Verification</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($approve_chalan_verification, 0); ?></h3>
                    <small class="badge bg-primary-light text-primary fw-600">
                        <i class="bi bi-shield-check"></i> Approved
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Charts Section -->
<!--<div class="row mb-1 pt-3">

   1 Top 5 Customers 
  <div class="col-lg-4 col-md-6 mb-2 px-1">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium bg-gradient-warning"><i class="bi bi-people-fill"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Top 5 Vendors</h5>
            <small class="text-muted fw-500">By Purchase value</small>
          </div>
        </div>
      </div>
      <div class="card-body-premium d-flex flex-column">
        <div class="chart-container flex-grow-1 mt-3" style="height:180px;">
          <canvas id="topCustomerChart"></canvas>
        </div>
      </div>
    </div>
  </div>

   2 Top 5 Sales Items 
  <div class="col-lg-4 col-md-6 mb-2 px-1">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium bg-gradient-success"><i class="bi bi-bar-chart-fill"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Top 5 Purchase Items</h5>
            <small class="text-muted fw-500">Highest Purchasing products</small>
          </div>
        </div>
      </div>
      <div class="card-body-premium d-flex flex-column">
        <div class="chart-container flex-grow-1" style="height:180px;">
          <canvas id="topItemChart"></canvas>
        </div>
      </div>
    </div>
  </div>

   3 Target vs Sales 
  <div class="col-lg-4 col-md-6 mb-2 px-1">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);"><i class="bi bi-bullseye"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Purchase vs Receive</h5>
            <small class="text-muted fw-500">Comparison of Purchase against Receive</small>
          </div>
        </div>
      </div>
      <div class="card-body-premium d-flex flex-column">
        <div class="chart-container flex-grow-1" style="height:180px;">
          <canvas id="targetSalesChart"></canvas>
        </div>
      </div>
    </div>
  </div>
  
  
   4 Division Wise 
  <div class="col-lg-4 col-md-6 mb-2 px-1">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium bg-gradient-danger"><i class="bi bi-diagram-3-fill"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Division Wise Top 5 Sales</h5>
            <small class="text-muted fw-500">Highest performing divisions</small>
          </div>
        </div>
      </div>
      <div class="card-body-premium d-flex flex-column">
        <div class="chart-container flex-grow-1" style="height:180px;">
          <canvas id="divisionSalesChart"></canvas>
        </div>
      </div>
    </div>
  </div>

   5 Sales vs Collection 
  <div class="col-lg-4 col-md-6 mb-2 px-1">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
		<div class="icon-box-premium" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"><i class="bi bi-cash-coin"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Sales vs Collection</h5>
            <small class="text-muted fw-500">Overall comparison</small>
          </div>
        </div>
      </div>
      <div class="card-body-premium d-flex flex-column">
        <div class="chart-container flex-grow-1" style="height:180px;">
          <canvas id="salesCollectionChart"></canvas>
        </div>
      </div>
    </div>
  </div>

   6 Bottom 5 Items 
  <div class="col-lg-4 col-md-6 mb-2">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium bg-gradient-warning"><i class="bi bi-bar-chart"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Bottom 5 Sales Items</h5>
            <small class="text-muted fw-500">Lowest selling products</small>
          </div>
        </div>
      </div>
      <div class="card-body-premium d-flex flex-column">
        <div class="chart-container flex-grow-1" style="height:180px;">
          <canvas id="bottomItemChart"></canvas>
        </div>
      </div>
    </div>
  </div>

   7 Yearly Comparison 
  <div class="col-lg-4 col-md-6 mb-2">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium bg-gradient-danger"><i class="bi bi-calendar-range"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Yearly Comparison</h5>
            <small class="text-muted fw-500">Previous Year vs Current Year</small>
          </div>
        </div>
      </div>
      <div class="card-body-premium d-flex flex-column">
        <div class="chart-container flex-grow-1" style="height:180px;">
          <canvas id="yearlyComparisonChart"></canvas>
        </div>
      </div>
    </div>
  </div>

   8 Revenue Trend 
  <div class="col-lg-4 col-md-6 mb-2 px-1">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium" style="background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);"><i class="bi bi-graph-up"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Revenue Trend (Last 7 Days)</h5>
            <small class="text-muted fw-500">Daily sales comparison</small>
          </div>
        </div>
      </div>
      <div class="card-body-premium d-flex flex-column">
        <div class="chart-container flex-grow-1" style="height:180px;">
          <canvas id="revenueChart"></canvas>
        </div>
      </div>
    </div>
  </div>-->

</div>
<!-- Advanced Reports Section -->
<div class="row mb-4">
    <!-- Top 5 Advance Reports -->
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="card card-reports-enhanced border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="header-icon-wrapper header-icon-ash me-4">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Top 5 Advance Reports</h5>
                            <small class="text-muted d-flex align-items-center">
                                <i class="bi bi-calendar3 me-1"></i>Year - <?php echo date("Y"); ?>
                            </small>
                        </div>
                    </div>
                    <div class="badge bg-primary-light text-primary px-3 py-2">
                        5 Reports
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- Transaction Statement Report -->
                <a href="transaction_listledger.php" class="text-decoration-none">
                    <div class="report-item p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="icon-box-modern">
                                        <i class="bi bi-journal-text text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Transaction Statement Report</h6>
                                    <small class="text-muted">View all transactions</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success-light text-success me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Trial Balance -->
                <a href="trial_balance_detail_new.php" class="text-decoration-none">
                    <div class="report-item p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);" class="icon-box-modern">
                                        <i class="bi bi-calculator text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Trial Balance</h6>
                                    <small class="text-muted">Accounting balance sheet</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-danger-light text-danger me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Party Balance -->
                <a href="party_balance_report.php" class="text-decoration-none">
                    <div class="report-item p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);" class="icon-box-modern">
                                        <i class="bi bi-people text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Party Balance</h6>
                                    <small class="text-muted">Customer & supplier balances</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success-light text-success me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Bank Book -->
                <a href="bank_book.php" class="text-decoration-none">
                    <div class="report-item p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);" class="icon-box-modern">
                                        <i class="bi bi-bank text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Bank Book</h6>
                                    <small class="text-muted">Bank transaction records</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-info-light text-info me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cash Book -->
                <a href="cash_book.php" class="text-decoration-none">
                    <div class="report-item p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);" class="icon-box-modern">
                                        <i class="bi bi-cash-stack text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Cash Book</h6>
                                    <small class="text-muted">Cash transaction records</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-warning-light text-warning me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Top 5 Financial Reports -->
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="card card-reports-enhanced border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="header-icon-wrapper header-icon-ash me-4">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Top 5 Financial Reports</h5>
                            <small class="text-muted d-flex align-items-center">
                                <i class="bi bi-calendar3 me-1"></i>Year - <?php echo date("Y"); ?>
                            </small>
                        </div>
                    </div>
                    <div class="badge bg-success-light text-success px-3 py-2">
                        5 Reports
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- Comparative Financial Statements -->
                <a href="../financial_report/financial_statement_comparative.php" class="text-decoration-none">
                    <div class="report-item p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%);" class="icon-box-modern">
                                        <i class="bi bi-bar-chart-line text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Comparative Financial Statements</h6>
                                    <small class="text-muted">Year-over-year comparison</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary-light text-primary me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Comparative Income Statement -->
                <a href="../financial_report/financial_profit_loss_comparative.php" class="text-decoration-none">
                    <div class="report-item p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);" class="icon-box-modern">
                                        <i class="bi bi-graph-down-arrow text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Comparative Income Statement</h6>
                                    <small class="text-muted">Income analysis report</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-warning-light text-warning me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Statement of Profit or Loss -->
                <a href="../financial_report/financial_profit_loss.php" class="text-decoration-none">
                    <div class="report-item p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);" class="icon-box-modern">
                                        <i class="bi bi-trophy text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Profit or Loss & Other Income</h6>
                                    <small class="text-muted">Comprehensive income statement</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success-light text-success me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cost of Goods Sold -->
                <a href="../financial_report/financial_cogs_cal.php" class="text-decoration-none">
                    <div class="report-item p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);" class="icon-box-modern">
                                        <i class="bi bi-box-seam text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Cost of Goods Sold</h6>
                                    <small class="text-muted">COGS calculation report</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-info-light text-info me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Receipt & Payment Statement -->
                <a href="../financial_report/receipt_payment_statement.php" class="text-decoration-none">
                    <div class="report-item p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="report-icon-wrapper-modern me-4">
                                    <div style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);" class="icon-box-modern">
                                        <i class="bi bi-receipt text-white"></i>
                                        <div class="icon-shine"></div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-600">Receipt & Payment Statement</h6>
                                    <small class="text-muted">Cash flow statement</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-danger-light text-danger me-2">
                                    <i class="bi bi-arrow-up-right"></i> Open
                                </span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced Report Cards - Subtle Hover with Thin Blue Border */
.card-reports-enhanced {
    border-radius: 20px !important;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
    border: 1px solid #e5e7eb !important;
}

.card-reports-enhanced:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
    border: 1px solid #0066ff !important;
}

/* Card Header */
.card-reports-enhanced .card-header {
    border-radius: 20px 20px 0 0 !important;
}

/* Header Icon Wrapper - Ash Color Design */
.header-icon-wrapper {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2),
                0 2px 6px rgba(108, 117, 125, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.15);
    position: relative;
    overflow: hidden;
	margin-right: 0.5rem !important;
}

/* Ash Icon Glass Effect */
.header-icon-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(
        180deg,
        rgba(255, 255, 255, 0.12) 0%,
        rgba(255, 255, 255, 0) 100%
    );
    border-radius: 16px 16px 0 0;
    z-index: 1;
}

.header-icon-wrapper i {
    font-size: 1.5rem;
    color: white;
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
	
}

.card-reports-enhanced:hover .header-icon-wrapper {
    transform: scale(1.08) rotate(-3deg);
    box-shadow: 0 6px 16px rgba(108, 117, 125, 0.3),
                0 3px 8px rgba(108, 117, 125, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.card-reports-enhanced:hover .header-icon-wrapper i {
    transform: scale(1.1);
    filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.3));
}

/* Report Item Hover */
.card-reports-enhanced .report-item {
    transition: all 0.3s ease;
}

.card-reports-enhanced .report-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

/* Icon Wrapper Container - Controls Spacing */
.report-icon-wrapper-modern {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Modern Icon Box Design */
.icon-box-modern {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15),
                0 2px 6px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

/* Hover Effect - Icon Scale and Rotation */
.card-reports-enhanced .report-item:hover .icon-box-modern {
    transform: scale(1.15) rotate(-5deg);
}

/* Icon Itself */
.icon-box-modern i {
    color: white;
    position: relative;
    z-index: 2;
    transition: all 0.3s ease;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.card-reports-enhanced .report-item:hover .icon-box-modern i {
    transform: scale(1.1);
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
}

/* Glass Morphism Effect */
.icon-box-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 50%;
     background: linear-gradient(
        180deg,
        rgba(255, 255, 255, 0.12) 0%,
        rgba(255, 255, 255, 0) 100%
    );
    border-radius: 16px 16px 0 0;
    z-index: 1;
}

/* Bottom Glow Effect */
.icon-box-modern::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    height: 4px;
    background: rgba(255, 255, 255, 0.3);
    filter: blur(4px);
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card-reports-enhanced .report-item:hover .icon-box-modern::after {
    opacity: 1;
}

/* Chevron Animation */
.card-reports-enhanced .bi-chevron-right {
    transition: all 0.3s ease;
}

.card-reports-enhanced .report-item:hover .bi-chevron-right {
    transform: translateX(5px);
}

/* Smooth Card Entry Animation */
.card-reports-enhanced {
    animation: cardSlideUp 0.5s ease both;
}

.col-lg-6:nth-child(1) .card-reports-enhanced {
    animation-delay: 0.1s;
}

.col-lg-6:nth-child(2) .card-reports-enhanced {
    animation-delay: 0.2s;
}

@keyframes cardSlideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-reports-enhanced {
        border-radius: 16px !important;
    }
    
    .card-reports-enhanced:hover {
        transform: translateY(-6px);
    }
    
    .header-icon-wrapper {
        width: 46px;
        height: 46px;
        border-radius: 14px;
    }
    
    .header-icon-wrapper i {
        font-size: 0.9rem;
		margin-right: 1rem !important;
    }
    
    .icon-box-modern {
        width: 46px;
        height: 46px;
        font-size: 1.1rem;
        border-radius: 14px;
    }
    
    .report-icon-wrapper-modern {
        margin-right: 1rem !important;
    }
}
</style>
<!-- Libs -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// ─── Expanded Color Palette ───────────────────────────────
const COLORS = {
  // Blues
  blue: {
    950: '#0a1628',
    900: '#0f2044',
    800: '#1a3a6b',
    700: '#1e4d8c',
    600: '#2563eb',
    500: '#3b82f6',
    400: '#60a5fa',
    300: '#93c5fd'
  },
  // Purples
  purple: {
    700: '#7c3aed',
    600: '#8b5cf6',
    500: '#a78bfa',
    400: '#c4b5fd'
  },
  // Greens
  green: {
    700: '#15803d',
    600: '#16a34a',
    500: '#22c55e',
    400: '#4ade80'
  },
  // Oranges
  orange: {
    700: '#c2410c',
    600: '#ea580c',
    500: '#f97316',
    400: '#fb923c'
  },
  // Teals/Cyans
  teal: {
    700: '#0f766e',
    600: '#0d9488',
    500: '#14b8a6',
    400: '#2dd4bf'
  },
  // Pinks
  pink: {
    700: '#be185d',
    600: '#db2777',
    500: '#ec4899',
    400: '#f472b6'
  },
  // Reds
  red: {
    700: '#b91c1c',
    600: '#dc2626',
    500: '#ef4444',
    400: '#f87171'
  },
  // Yellows
  yellow: {
    700: '#a16207',
    600: '#ca8a04',
    500: '#eab308',
    400: '#facc15'
  },
  // Indigos
  indigo: {
    700: '#4338ca',
    600: '#4f46e5',
    500: '#6366f1',
    400: '#818cf8'
  }
};

// Multi-color sets for different chart types
const PIE_SET_1 = [
  COLORS.blue[600],
  COLORS.purple[600],
  COLORS.green[600],
  COLORS.orange[600],
  COLORS.teal[600]
];

const PIE_SET_2 = [
  COLORS.indigo[600],
  COLORS.pink[600],
  COLORS.yellow[600],
  COLORS.red[600],
  COLORS.blue[500]
];

const PIE_SET_3 = [
  COLORS.teal[600],
  COLORS.orange[500],
  COLORS.purple[500],
  COLORS.green[500],
  COLORS.pink[500]
];

const BAR_COLORS = [
  COLORS.blue[600],
  COLORS.purple[600],
  COLORS.green[600],
  COLORS.orange[600],
  COLORS.teal[600]
];

// ─── Helpers ────────────────────────────────────────────────
function rgba(hex, a) {
  const r = parseInt(hex.slice(1,3),16),
        g = parseInt(hex.slice(3,5),16),
        b = parseInt(hex.slice(5,7),16);
  return `rgba(${r},${g},${b},${a})`;
}

// ─── Chart.js global defaults ──────────────────────────────
Chart.defaults.color = '#475569';
Chart.defaults.borderColor = '#eef2f7';
Chart.defaults.plugins.legend.labels.color = '#1e293b';

// ─── Common animation config ───────────────────────────────
const ANIM_BAR = {
  duration: 1200,
  easing: 'easeOutQuart',
  delay: 300
};
const ANIM_PIE = {
  animateRotate: true,
  animateScale: true,
  duration: 1100,
  easing: 'easeOutCubic',
  delay: 250
};
const ANIM_LINE = {
  duration: 1400,
  easing: 'easeOutQuart',
  delay: 200
};

// ─── Shared scale style ────────────────────────────────────
function yScale(extra = {}) {
  return {
    beginAtZero: true,
    grid: { color: '#eef2f7' },
    ticks: {
      color: '#64748b',
      callback: v => '৳' + Number(v).toLocaleString()
    },
    ...extra
  };
}
function xScale(extra = {}) {
  return {
    grid: { display: false },
    ticks: { color: '#475569' },
    ...extra
  };
}

// ─── Tooltip style (shared) ────────────────────────────────
const TOOLTIP = {
  backgroundColor: '#1e293b',
  titleColor: '#f1f5f9',
  bodyColor: '#cbd5e1',
  borderColor: '#334155',
  borderWidth: 1,
  cornerRadius: 8,
  padding: 10,
  displayColors: true,
  boxPadding: 4
};

document.addEventListener("DOMContentLoaded", function () {

  /* ─── 1. Top 5 Vendors (Doughnut) ───────────────────── */
 new Chart(document.getElementById('topCustomerChart'), {  // Changed back to topCustomerChart
    type: 'doughnut',
    data: {
      labels: ['Apex Holdings Ltd','Delta Industries','Prime Suppliers','Eastern Trading Co','Metro Wholesale'],
      datasets: [{
        data: [420000, 350000, 280000, 210000, 150000],
        backgroundColor: PIE_SET_1,
        borderColor: '#ffffff',
        borderWidth: 3,
        hoverOffset: 10
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: ANIM_PIE,
      cutout: '58%',
      plugins: {
        legend: { position: 'bottom', labels: { padding: 10, usePointStyle: true, pointStyleWidth: 9, font: { size: 11 } } },
        tooltip: { ...TOOLTIP, callbacks: { label: ctx => ' ৳' + Number(ctx.raw).toLocaleString() } }
      }
    }
  });

  /* ─── 2. Top 5 Purchase Items (Horizontal Bar) ─────────────────── */
  new Chart(document.getElementById('topItemChart'), {
    type: 'bar',
    data: {
      labels: ['Raw Materials','Packaging Supplies','Electronic Components','Office Equipment','Industrial Tools'],
      datasets: [{
        label: 'Purchase Value',
        data: [180000, 145000, 120000, 95000, 80000],
        backgroundColor: [
          rgba(COLORS.teal[600], 0.85),
          rgba(COLORS.purple[600], 0.85),
          rgba(COLORS.orange[600], 0.85),
          rgba(COLORS.pink[600], 0.85),
          rgba(COLORS.indigo[600], 0.85)
        ],
        borderColor: [
          COLORS.teal[600],
          COLORS.purple[600],
          COLORS.orange[600],
          COLORS.pink[600],
          COLORS.indigo[600]
        ],
        borderWidth: 2,
        borderRadius: 6,
        borderSkipped: false
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      animation: {
        ...ANIM_BAR,
        delay: (ctx) => ctx.dataIndex * 100 + 200
      },
      plugins: {
        legend: { display: false },
        tooltip: { ...TOOLTIP, callbacks: { label: ctx => ' ৳' + Number(ctx.raw).toLocaleString() } }
      },
      scales: {
        x: {
          beginAtZero: true,
          grid: { color: '#eef2f7' },
          ticks: { color: '#64748b', callback: v => '৳' + Number(v).toLocaleString() }
        },
        y: { grid: { display: false }, ticks: { color: '#1e293b', font: { size: 11, weight: '600' } } }
      }
    }
  });

  /* ─── 3. Purchase vs Receive (Bar) ─────────────────────────── */
 new Chart(document.getElementById('targetSalesChart'), {  // Changed back to targetSalesChart
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May'],
      datasets: [
        {
          label: 'Purchase Orders',
          data: [650000, 700000, , , ],
          backgroundColor: rgba(COLORS.blue[600], 0.7),
          borderColor: COLORS.blue[500],
          borderWidth: 2,
          borderRadius: 6,
          borderSkipped: false,
          hoverBackgroundColor: rgba(COLORS.blue[500], 0.85)
        },
        {
          label: 'Goods Received',
          data: [620000, 400000, , , ],
          backgroundColor: rgba(COLORS.green[600], 0.7),
          borderColor: COLORS.green[500],
          borderWidth: 2,
          borderRadius: 6,
          borderSkipped: false,
          hoverBackgroundColor: rgba(COLORS.green[500], 0.85)
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: ANIM_BAR,
      plugins: {
        legend: { position: 'top', labels: { usePointStyle: true, pointStyleWidth: 12 } },
        tooltip: { ...TOOLTIP, callbacks: { label: ctx => ` ${ctx.dataset.label}: ৳${Number(ctx.raw).toLocaleString()}` } }
      },
      scales: { y: yScale(), x: xScale() }
    }
  });

});
</script>
</body>
</html>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>