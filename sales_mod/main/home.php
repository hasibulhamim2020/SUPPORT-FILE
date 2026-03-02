<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Sales Management Dashboard";
$tr_type="Dashboard";
$page_name="Sales Dashboard";

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

$monthly_revenue = (float) find_a_field('sales_orders', 'SUM(total_amount) as total', "order_date >= '$current_month_start' AND order_status IN ('Completed', 'Processing')");
$yearly_revenue = (float) find_a_field('sales_orders', 'SUM(total_amount) as total', "order_date >= '$current_year_start' AND order_status IN ('Completed', 'Processing')");
$today_sales = (float) find_a_field('sales_orders', 'SUM(total_amount) as total', "DATE(order_date) = CURDATE() AND order_status IN ('Completed', 'Processing')");
$yesterday_sales = (float) find_a_field('sales_orders', 'SUM(total_amount) as total', "DATE(order_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND order_status IN ('Completed', 'Processing')");
$last_month_revenue = (float) find_a_field('sales_orders', 'SUM(total_amount) as total', "order_date BETWEEN '$last_month_start' AND '$last_month_end' AND order_status IN ('Completed', 'Processing')");
$last_year_revenue = (float) find_a_field('sales_orders', 'SUM(total_amount) as total', "order_date BETWEEN '$last_year_start' AND '$last_year_end' AND order_status IN ('Completed', 'Processing')");

$total_orders = (int) find_a_field('sales_orders', 'COUNT(order_id)', "order_date >= '$current_month_start'");
$pending_orders = (int) find_a_field('sales_orders', 'COUNT(order_id)', "order_status='Pending'");
$processing_orders = (int) find_a_field('sales_orders', 'COUNT(order_id)', "order_status='Processing'");
$completed_orders = (int) find_a_field('sales_orders', 'COUNT(order_id)', "order_status='Completed' AND order_date >= '$current_month_start'");
$cancelled_orders = (int) find_a_field('sales_orders', 'COUNT(order_id)', "order_status='Cancelled' AND order_date >= '$current_month_start'");

if ($total_orders == 0) {
    $completed_orders = 45;
    $processing_orders = 12;
    $pending_orders = 8;
    $cancelled_orders = 3;
    $total_orders = $completed_orders + $processing_orders + $pending_orders + $cancelled_orders;
}

$total_customers = (int) find_a_field('customers', 'COUNT(customer_id)', "status='Active'");
$new_customers_month = (int) find_a_field('customers', 'COUNT(customer_id)', "MONTH(created_date) = MONTH(CURDATE()) AND YEAR(created_date) = YEAR(CURDATE())");
$new_customers_today = (int) find_a_field('customers', 'COUNT(customer_id)', "DATE(created_date) = CURDATE()");

$overdue_payments = (int) find_a_field('invoices', 'COUNT(invoice_id)', "due_date < CURDATE() AND payment_status != 'Paid'");
$overdue_amount = (float) find_a_field('invoices', 'SUM(amount)', "due_date < CURDATE() AND payment_status != 'Paid'");
$pending_invoices = (int) find_a_field('invoices', 'COUNT(invoice_id)', "payment_status='Pending'");
$paid_invoices = (int) find_a_field('invoices', 'COUNT(invoice_id)', "payment_status='Paid' AND MONTH(payment_date) = MONTH(CURDATE())");

$total_sales = (float) find_a_field('sale_do_details', 'SUM(total_amt) as total', "1=1");

$current_month_sales_query = "
    SELECT COALESCE(SUM(sdd.total_amt), 0) as total
    FROM sale_do_details sdd
    JOIN sales_orders so ON sdd.order_id = so.order_id
    WHERE so.order_date >= '$current_month_start'
      AND so.order_status IN ('Completed', 'Processing')
";
$result = db_query($current_month_sales_query);
$current_month_sales = ($result && $row = $result->fetch_assoc()) ? (float)$row['total'] : 0.0;

$last_month_sales_query = "
    SELECT COALESCE(SUM(sdd.total_amt), 0) as total
    FROM sale_do_details sdd
    JOIN sales_orders so ON sdd.order_id = so.order_id
    WHERE so.order_date BETWEEN '$last_month_start' AND '$last_month_end'
      AND so.order_status IN ('Completed', 'Processing')
";
$result = db_query($last_month_sales_query);
$last_month_sales = ($result && $row = $result->fetch_assoc()) ? (float)$row['total'] : 0.0;

$sales_growth = ($last_month_sales > 0)
    ? round((($current_month_sales - $last_month_sales) / $last_month_sales) * 100, 1)
    : 0;

$factory_delivery = (int) find_a_field('sale_do_chalan', 'COUNT(id) as total', "1=1");
$delivery_orders  = (int) find_a_field('sale_do_chalan', 'COUNT(DISTINCT order_id) as total', "1=1");
$total_quantity       = 0;
$achievement_percent  = 0;

$order_fulfillment_rate = 0;
$fulfilled_orders = 0;
$yoy_growth = 0;  
$mom_growth = 0;  
$projection = 0;

$total_inflow = 0;
$inflow_growth = 0;
$inflow_vs_sales_ratio = 0;
$damage_value = 0;
$damaged_items = 0;
$damage_percentage = 0;

$avg_order_value = ($total_orders > 0) ? $monthly_revenue / $total_orders : 0;
$revenue_growth = ($last_month_revenue > 0) ? round((($monthly_revenue - $last_month_revenue) / $last_month_revenue) * 100, 1) : 0;
$yoy_growth = ($last_year_revenue > 0) ? round((($yearly_revenue - $last_year_revenue) / $last_year_revenue) * 100, 1) : 0;
$daily_growth = ($yesterday_sales > 0) ? round((($today_sales - $yesterday_sales) / $yesterday_sales) * 100, 1) : 0;
$order_fulfillment_rate = ($total_orders > 0) ? round(($completed_orders / $total_orders) * 100, 1) : 0;
$cancellation_rate = ($total_orders > 0) ? round(($cancelled_orders / $total_orders) * 100, 1) : 0;

$monthly_target = 5000000;
$yearly_target = 60000000;
$achievement_percent = ($monthly_target > 0) ? round(($monthly_revenue / $monthly_target) * 100, 1) : 0;
$yearly_achievement = ($yearly_target > 0) ? round(($yearly_revenue / $yearly_target) * 100, 1) : 0;

$low_stock_items = (int) find_a_field('products', 'COUNT(product_id)', 'stock_quantity < reorder_level');
$out_of_stock = (int) find_a_field('products', 'COUNT(product_id)', 'stock_quantity = 0');

$total_inflow = 0; 
$inflow_growth = 0;
$inflow_vs_sales_ratio = 0; 
$damage_value = 0;
$damaged_items = 0; 
$damage_percentage = 0; 

$active_party = 0;         
$new_party_month = 0;       
$total_orders_count = 0;     
$order_growth = 0;          

$top_products = [];
$query = "SELECT 
          p.product_id, 
          p.product_name, 
          p.product_code, 
          p.stock_quantity,
          p.reorder_level,
          p.unit_price,
          COALESCE(sales.total_qty, 0) as total_qty, 
          COALESCE(sales.total_sales, 0) as total_sales,
          COALESCE(sales.order_count, 0) as order_count,
          COALESCE(purchase.last_purchase_price, 0) as purchase_price,
          COALESCE(warehouse.available_qty, 0) as warehouse_qty,
          CASE 
            WHEN p.stock_quantity <= 0 THEN 'Out of Stock'
            WHEN p.stock_quantity < p.reorder_level THEN 'Low Stock'
            WHEN p.stock_quantity > p.reorder_level * 3 THEN 'Overstocked'
            ELSE 'Normal'
          END as stock_status
          FROM products p
          LEFT JOIN (
            SELECT od.product_id,
                   SUM(od.quantity) as total_qty,
                   SUM(od.total_price) as total_sales,
                   COUNT(DISTINCT so.order_id) as order_count
            FROM order_details od
            JOIN sales_orders so ON od.order_id = so.order_id
            WHERE so.order_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            AND so.order_status IN ('Completed', 'Processing')
            GROUP BY od.product_id
          ) sales ON p.product_id = sales.product_id
          LEFT JOIN (
            SELECT product_id, 
                   unit_price as last_purchase_price
            FROM purchase_order_details
            WHERE purchase_order_id IN (
              SELECT MAX(purchase_order_id) 
              FROM purchase_order_details 
              GROUP BY product_id
            )
          ) purchase ON p.product_id = purchase.product_id
          LEFT JOIN (
            SELECT product_id, 
                   SUM(quantity) as available_qty
            FROM warehouse_stock
            GROUP BY product_id
          ) warehouse ON p.product_id = warehouse.product_id
          WHERE p.status = 'Active'
          ORDER BY sales.total_sales DESC, sales.total_qty DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $profit_margin = 0;
        if ($row['purchase_price'] > 0 && $row['unit_price'] > 0) {
            $profit_margin = round((($row['unit_price'] - $row['purchase_price']) / $row['unit_price']) * 100, 1);
        }
        $row['profit_margin'] = $profit_margin;
        $top_products[] = $row;
    }
}

$recent_orders = [];
$query = "SELECT so.order_id, so.order_number, so.total_amount, so.order_date, 
          c.customer_name, c.customer_code, so.order_status, so.payment_status,
          u.full_name as sales_person
          FROM sales_orders so
          JOIN customers c ON so.customer_id = c.customer_id
          LEFT JOIN users u ON so.sales_person_id = u.user_id
          WHERE so.order_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
          ORDER BY so.order_date DESC, so.order_id DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_orders[] = $row;
    }
}

$top_customers = [];
$query = "SELECT c.customer_id, c.customer_name, c.customer_code, c.customer_type,
          COUNT(so.order_id) as order_count,
          SUM(so.total_amount) as total_spent
          FROM customers c
          JOIN sales_orders so ON c.customer_id = so.customer_id
          WHERE so.order_date >= '$current_month_start'
          AND so.order_status IN ('Completed', 'Processing')
          GROUP BY c.customer_id
          ORDER BY total_spent DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $top_customers[] = $row;
    }
}

$top_salespeople = [];
$query = "SELECT u.user_id, u.full_name, u.employee_code,
          COUNT(so.order_id) as order_count,
          SUM(so.total_amount) as total_sales,
          AVG(so.total_amount) as avg_order_value
          FROM sales_orders so
          JOIN users u ON so.sales_person_id = u.user_id
          WHERE so.order_date >= '$current_month_start'
          AND so.order_status IN ('Completed', 'Processing')
          GROUP BY u.user_id
          ORDER BY total_sales DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $top_salespeople[] = $row;
    }
}

$regional_sales = [];
$query = "SELECT c.region, COUNT(so.order_id) as order_count,
          SUM(so.total_amount) as total_sales
          FROM sales_orders so
          JOIN customers c ON so.customer_id = c.customer_id
          WHERE so.order_date >= '$current_month_start'
          AND so.order_status IN ('Completed', 'Processing')
          GROUP BY c.region
          ORDER BY total_sales DESC
          LIMIT 5";
$result = db_query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $regional_sales[] = $row;
    }
}

$total_receivables = (float) find_a_field('invoices', 'SUM(amount)', "payment_status != 'Paid'");
$collected_this_month = (float) find_a_field('invoices', 'SUM(amount)', "payment_status = 'Paid' AND MONTH(payment_date) = MONTH(CURDATE())");


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
    --blue-accent: #38bdf8; 
    --blue-teal:   #06b6d4;  
  }

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

  .card-body-premium {
    padding: 10px 14px 14px;
  }

  .chart-container canvas {
    animation: shimmerIn 0.7s ease forwards;
  }
  @keyframes shimmerIn {
    from { opacity: 0; filter: blur(3px); }
    to   { opacity: 1; filter: blur(0);   }
  }

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

  .shadow-sm { box-shadow: 0 2px 12px rgba(0,0,0,0.06) !important; }
  
.card-header-premium {
  padding: 14px 18px 10px;
  border-bottom: 1px solid #eef2f7;
}

.card-header-premium .d-flex {
  gap: 0.75rem;
}

.card-header-premium h5 {
  color: #1e293b;
  font-size: 0.92rem;
}
.card-header-premium small {
  color: #64748b;
  font-size: 0.77rem;
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

   
    <div class="row mb-1">
        <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new bg-gradient-primary">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Total Sales</p>
                        <h3 class="fw-800 mb-1">৳<?php echo number_format($total_sales, 0); ?></h3>
                        <small class="badge <?php echo $sales_growth >= 0 ? 'bg-success-light text-success' : 'bg-danger-light text-danger'; ?> fw-600">
                            <i class="bi bi-arrow-<?php echo $sales_growth >= 0 ? 'up' : 'down'; ?>-right"></i> 
                            <?php echo abs($sales_growth); ?>% growth
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new" style="background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);">
    <i class="bi bi-truck"></i>
</div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Factory Delivery</p>
                        <h3 class="fw-800 mb-1"><?php echo number_format($total_quantity, 0); ?></h3>
                        <small class="badge bg-info-light text-info fw-600">
                            <i class="bi bi-box-seam"></i> <?php echo number_format($factory_delivery, 0); ?> orders
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new bg-gradient-info">
                        <i class="bi bi-boxes"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Total Quantity</p>
                        <h3 class="fw-800 mb-1"><?php echo number_format($total_quantity, 0); ?></h3>
                        <small class="badge bg-primary-light text-primary fw-600">
                            <i class="bi bi-cart-check"></i> units sold
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new" style="background: linear-gradient(135deg, #000000 0%, #434343 100%);">
    <i class="bi bi-trophy"></i>
</div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Achievement</p>
                        <h3 class="fw-800 mb-1"><?php echo number_format($achievement_percent, 1); ?>%</h3>
                        <small class="badge <?php echo $achievement_percent >= 100 ? 'bg-success-light text-success' : 'bg-warning-light text-warning'; ?> fw-600">
                            <?php echo $achievement_percent >= 100 ? 'Target met' : 'In progress'; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Performance Indicators - Row 2 -->
  <?php /*?>  <div class="row mb-1">
        <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new bg-gradient-secondary">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Fulfill Order</p>
                        <h3 class="fw-800 mb-1"><?php echo number_format($order_fulfillment_rate, 1); ?>%</h3>
                        <small class="badge bg-success-light text-success fw-600">
                            <i class="bi bi-check2-all"></i> <?php echo $fulfilled_orders; ?> completed
                        </small>
                    </div>
                </div>
            </div>
        </div>
<?php */?>
       <?php /*?> <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new bg-gradient-primary">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">YoY Growth</p>
                        <h3 class="fw-800 mb-1"><?php echo $yoy_growth >= 0 ? '+' : ''; ?><?php echo number_format($yoy_growth, 1); ?>%</h3>
                        <small class="badge <?php echo $yoy_growth >= 0 ? 'bg-success-light text-success' : 'bg-danger-light text-danger'; ?> fw-600">
                            <i class="bi bi-calendar"></i> vs last year
                        </small>
                    </div>
                </div>
            </div>
        </div><?php */?>
		
		 <div class="row mb-1">
        <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
    <i class="bi bi-arrow-down-circle"></i>
</div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Collection</p>
                        <h3 class="fw-800 mb-1">৳<?php echo number_format($total_inflow, 0); ?></h3>
                        <small class="badge <?php echo $inflow_growth >= 0 ? 'bg-success-light text-success' : 'bg-danger-light text-danger'; ?> fw-600">
                            <i class="bi bi-arrow-<?php echo $inflow_growth >= 0 ? 'up' : 'down'; ?>-right"></i> 
                            <?php echo abs($inflow_growth); ?>% MoM
                        </small>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
    <i class="bi bi-people"></i>
</div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Active Party</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($active_party, 0); ?></h3>
                    <small class="badge bg-info-light text-info fw-600">
                        <i class="bi bi-person-check"></i> <?php echo $new_party_month; ?> new (MTD)
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <i class="bi bi-cart-check"></i>
</div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Total Order</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($total_orders_count, 0); ?></h3>
                    <small class="badge <?php echo $order_growth >= 0 ? 'bg-success-light text-success' : 'bg-danger-light text-danger'; ?> fw-600">
                        <i class="bi bi-arrow-<?php echo $order_growth >= 0 ? 'up' : 'down'; ?>-right"></i> 
                        <?php echo abs($order_growth); ?>% MoM
                    </small>
                </div>
            </div>
        </div>
    </div>


       <?php /*?> <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new bg-gradient-info">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">MoM Growth</p>
                        <h3 class="fw-800 mb-1"><?php echo $mom_growth >= 0 ? '+' : ''; ?><?php echo number_format($mom_growth, 1); ?>%</h3>
                        <small class="badge <?php echo $mom_growth >= 0 ? 'bg-success-light text-success' : 'bg-danger-light text-danger'; ?> fw-600">
                            <i class="bi bi-calendar-month"></i> vs last month
                        </small>
                    </div>
                </div>
            </div>
        </div><?php */?>

    <?php /*?>    <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new bg-gradient-success">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Projection</p>
                        <h3 class="fw-800 mb-1">৳<?php echo number_format($projection, 0); ?></h3>
                        <small class="badge bg-info-light text-info fw-600">
                            <i class="bi bi-calendar-range"></i> month end
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div><?php */?>

    <!-- Key Performance Indicators - Row 3 -->
   

        <?php /*?><div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new bg-gradient-secondary">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Collection VS Sales %</p>
                        <h3 class="fw-800 mb-1"><?php echo number_format($inflow_vs_sales_ratio, 1); ?>%</h3>
                        <small class="badge <?php echo $inflow_vs_sales_ratio >= 100 ? 'bg-success-light text-success' : 'bg-warning-light text-warning'; ?> fw-600">
                            <?php echo $inflow_vs_sales_ratio >= 100 ? 'Surplus' : 'Deficit'; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div><?php */?>

        <?php /*?><div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                    <div class="metric-icon-new bg-gradient-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Damage Value</p>
                        <h3 class="fw-800 mb-1">৳<?php echo number_format($damage_value, 0); ?></h3>
                        <small class="badge bg-danger-light text-danger fw-600">
                            <i class="bi bi-x-circle"></i> <?php echo $damaged_items; ?> items
                        </small>
                    </div>
                </div>
            </div>
        </div><?php */?>

        <div class="col-lg-3 col-md-6 p-1">
            <div class="metric-card-premium">
                <div class="metric-header-new">
                   <div class="metric-icon-new" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);">
    <i class="bi bi-percent"></i>
</div>
                    <div>
                        <p class="text-muted small fw-600 mb-0">Damage %</p>
                        <h3 class="fw-800 mb-1"><?php echo number_format($damage_percentage, 2); ?>%</h3>
                        <small class="badge <?php echo $damage_percentage <= 2 ? 'bg-success-light text-success' : 'bg-danger-light text-danger'; ?> fw-600">
                            <?php echo $damage_percentage <= 2 ? 'Within limit' : 'Above limit'; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<?php /*?> Key Performance Indicators - Row 4 
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new bg-gradient-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Active Party</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($active_party, 0); ?></h3>
                    <small class="badge bg-info-light text-info fw-600">
                        <i class="bi bi-person-check"></i> <?php echo $new_party_month; ?> new (MTD)
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 p-1">
        <div class="metric-card-premium">
            <div class="metric-header-new">
                <div class="metric-icon-new bg-gradient-success">
                    <i class="bi bi-cart-check"></i>
                </div>
                <div>
                    <p class="text-muted small fw-600 mb-0">Total Order</p>
                    <h3 class="fw-800 mb-1"><?php echo number_format($total_orders_count, 0); ?></h3>
                    <small class="badge <?php echo $order_growth >= 0 ? 'bg-success-light text-success' : 'bg-danger-light text-danger'; ?> fw-600">
                        <i class="bi bi-arrow-<?php echo $order_growth >= 0 ? 'up' : 'down'; ?>-right"></i> 
                        <?php echo abs($order_growth); ?>% MoM
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 p-1">
         Empty column for spacing or future use 
    </div>
    <div class="col-lg-3 col-md-6 p-1">
         Empty column for spacing or future use 
    </div>
</div><?php */?>

<!-- Charts Section -->
<div class="row mb-1 pt-3">

  <!-- 1 Top 5 Customers -->
  <div class="col-lg-4 col-md-6 mb-2 px-1">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium bg-gradient-warning"><i class="bi bi-people-fill"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Top 5 Customers</h5>
            <small class="text-muted fw-500">By sales value</small>
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

  <!-- 2 Top 5 Sales Items -->
  <div class="col-lg-4 col-md-6 mb-2 px-1">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium bg-gradient-success"><i class="bi bi-bar-chart-fill"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Top 5 Sales Items</h5>
            <small class="text-muted fw-500">Highest selling products</small>
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

  <!-- 3 Division Wise -->
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

  <!-- 4 Target vs Sales -->
  <div class="col-lg-4 col-md-6 mb-2 px-1">
    <div class="card-premium shadow-sm h-100">
      <div class="card-header-premium">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-box-premium" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);"><i class="bi bi-bullseye"></i></div>
          <div>
            <h5 class="fw-700 mb-0">Target vs Sales</h5>
            <small class="text-muted fw-500">Comparison of sales against targets</small>
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

  <!-- 5 Sales vs Collection -->
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

  <!-- 6 Bottom 5 Items -->
 <!-- <div class="col-lg-4 col-md-6 mb-2">
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
  </div>-->

  <!-- 7 Yearly Comparison -->
 <!-- <div class="col-lg-4 col-md-6 mb-2">
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
  </div>-->

  <!-- 8 Revenue Trend -->
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
  </div>

</div>

<div class="row m-0 p-0 mt-4">
    <div class="col-12 new">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title bold">Quick Shortcuts <span> || Year-<?php echo date("Y"); ?></span></h5>
                
                <!-- Sales Quotation Create -->
                <div class="d-flex justify-content-between p-3 border-bottom align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-modern me-3" style="background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%);">
                            <i class="bi bi-file-earmark-text text-white"></i>
                        </div>
                        <span class="fw-500">Sales Quotation Create</span>
                    </div>
                    <a href="../quotation/select_dealer.php?new=2" class="text-decoration-none">
                        <div class="d-flex align-items-center">
                            <span class="badge px-3 py-2 fw-600" style="background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%); color: white;">
                                <i class="bi bi-arrow-right-circle-fill me-1"></i> Open
                            </span>
                        </div>
                    </a>
                </div>
                
                <!-- Create Sales Order -->
                <div class="d-flex justify-content-between p-3 border-bottom align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-modern me-3" style="background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);">
                            <i class="bi bi-clipboard2-check text-white"></i>
                        </div>
                        <span class="fw-500">Create Sales Order</span>
                    </div>
                    <a href="../wo/do.php?new=2" class="text-decoration-none">
                        <div class="d-flex align-items-center">
                            <span class="badge px-3 py-2 fw-600" style="background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%); color: white;">
                                <i class="bi bi-arrow-right-circle-fill me-1"></i> Open
                            </span>
                        </div>
                    </a>
                </div>
                
                <!-- Direct Sales Entry -->
                <div class="d-flex justify-content-between p-3 border-bottom align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-modern me-3" style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);">
                            <i class="bi bi-cash-stack text-white"></i>
                        </div>
                        <span class="fw-500">Direct Sales Entry</span>
                    </div>
                    <a href="../direct_sales/direct_sales.php?new=2" class="text-decoration-none">
                        <div class="d-flex align-items-center">
                            <span class="badge px-3 py-2 fw-600" style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%); color: white;">
                                <i class="bi bi-arrow-right-circle-fill me-1"></i> Open
                            </span>
                        </div>
                    </a>
                </div>
                
                <!-- Delivery Sales Order Report -->
                <div class="d-flex justify-content-between p-3 border-bottom align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-modern me-3" style="background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);">
                            <i class="bi bi-clipboard-data text-white"></i>
                        </div>
                        <span class="fw-500">Delivery Sales Order Report</span>
                    </div>
                    <a href="../report/sales_report.php" class="text-decoration-none">
                        <div class="d-flex align-items-center">
                            <span class="badge px-3 py-2 fw-600" style="background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); color: white;">
                                <i class="bi bi-arrow-right-circle-fill me-1"></i> Open
                            </span>
                        </div>
                    </a>
                </div>
                
                <!-- Delivery Challan Reports -->
                <div class="d-flex justify-content-between p-3 border-bottom align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-modern me-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="bi bi-truck text-white"></i>
                        </div>
                        <span class="fw-500">Delivery Challan Reports</span>
                    </div>
                    <a href="../report/sales_report.php" class="text-decoration-none">
                        <div class="d-flex align-items-center">
                            <span class="badge px-3 py-2 fw-600" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                <i class="bi bi-arrow-right-circle-fill me-1"></i> Open
                            </span>
                        </div>
                    </a>
                </div>
                
            </div>
        </div>
        
        <br />
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>

const COLORS = {
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
  purple: {
    700: '#7c3aed',
    600: '#8b5cf6',
    500: '#a78bfa',
    400: '#c4b5fd'
  },
  green: {
    700: '#15803d',
    600: '#16a34a',
    500: '#22c55e',
    400: '#4ade80'
  },
  orange: {
    700: '#c2410c',
    600: '#ea580c',
    500: '#f97316',
    400: '#fb923c'
  },
  teal: {
    700: '#0f766e',
    600: '#0d9488',
    500: '#14b8a6',
    400: '#2dd4bf'
  },
  pink: {
    700: '#be185d',
    600: '#db2777',
    500: '#ec4899',
    400: '#f472b6'
  },
  red: {
    700: '#b91c1c',
    600: '#dc2626',
    500: '#ef4444',
    400: '#f87171'
  },
  yellow: {
    700: '#a16207',
    600: '#ca8a04',
    500: '#eab308',
    400: '#facc15'
  },
  indigo: {
    700: '#4338ca',
    600: '#4f46e5',
    500: '#6366f1',
    400: '#818cf8'
  }
};
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

function rgba(hex, a) {
  const r = parseInt(hex.slice(1,3),16),
        g = parseInt(hex.slice(3,5),16),
        b = parseInt(hex.slice(5,7),16);
  return `rgba(${r},${g},${b},${a})`;
}

Chart.defaults.color = '#475569';
Chart.defaults.borderColor = '#eef2f7';
Chart.defaults.plugins.legend.labels.color = '#1e293b';

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

  const last7Days = [];
  for (let i = 6; i >= 0; i--) {
    const d = new Date();
    d.setDate(d.getDate() - i);
    last7Days.push(`${d.getDate().toString().padStart(2,'0')}/${(d.getMonth()+1).toString().padStart(2,'0')}`);
  }

  const revenueCtx = document.getElementById('revenueChart').getContext('2d');
  const gradient = revenueCtx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, rgba(COLORS.purple[600], 0.4));
  gradient.addColorStop(0.5, rgba(COLORS.blue[500], 0.25));
  gradient.addColorStop(1, rgba(COLORS.teal[500], 0.05));

  new Chart(revenueCtx, {
    type: 'line',
    data: {
      labels: last7Days,
      datasets: [{
        label: 'Daily Sales',
        data: [120000, 95000, 143000, 130000, 160000, 125000, 150000],
        borderColor: COLORS.purple[600],
        backgroundColor: gradient,
        fill: true,
        tension: 0.38,
        pointRadius: 5,
        pointBackgroundColor: COLORS.pink[500],
        pointBorderColor: '#ffffff',
        pointBorderWidth: 2,
        pointHoverRadius: 7,
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: COLORS.purple[600],
        pointHoverBorderWidth: 3,
        borderWidth: 2.5
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: ANIM_LINE,
      plugins: {
        legend: { display: false },
        tooltip: { ...TOOLTIP, callbacks: { label: ctx => ' ৳' + Number(ctx.raw).toLocaleString() } }
      },
      scales: { y: yScale(), x: xScale() },
      interaction: { mode: 'index', intersect: false }
    }
  });

  new Chart(document.getElementById('salesCollectionChart'), {
    type: 'doughnut',
    data: {
      labels: ['Sales', 'Collection'],
      datasets: [{
        data: [750000, 520000],
        backgroundColor: [COLORS.green[600], COLORS.orange[600]],
        borderColor: '#ffffff',
        borderWidth: 3,
        hoverBackgroundColor: [COLORS.green[500], COLORS.orange[500]],
        hoverOffset: 10
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: ANIM_PIE,
      cutout: '62%',
      plugins: {
        legend: { position: 'bottom', labels: { padding: 14, usePointStyle: true, pointStyleWidth: 10 } },
        tooltip: { ...TOOLTIP, callbacks: { label: ctx => ' ৳' + Number(ctx.raw).toLocaleString() } }
      }
    }
  });

  new Chart(document.getElementById('topCustomerChart'), {
    type: 'doughnut',
    data: {
      labels: ['Nasir Group','Jamuna Group','Star Line Group','Reverie Power','Primitek Group'],
      datasets: [{
        data: [320000, 280000, 210000, 160000, 120000],
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

  new Chart(document.getElementById('divisionSalesChart'), {
    type: 'doughnut',
    data: {
      labels: ['Dhaka','Chattogram','Khulna','Rajshahi','Sylhet'],
      datasets: [{
        data: [420000, 310000, 220000, 160000, 140000],
        backgroundColor: PIE_SET_2,
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

  new Chart(document.getElementById('targetSalesChart'), {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May'],
      datasets: [
        {
          label: 'Target',
          data: [500000, 600000, 550000, 700000, 650000],
          backgroundColor: rgba(COLORS.yellow[500], 0.4),
          borderColor: COLORS.yellow[600],
          borderWidth: 2,
          borderRadius: 6,
          borderSkipped: false,
          hoverBackgroundColor: rgba(COLORS.yellow[500], 0.6)
        },
        {
          label: 'Sales',
          data: [480000, null, null, null, null],
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

  new Chart(document.getElementById('topItemChart'), {
    type: 'bar',
    data: {
      labels: ['Glycirene','Ready Mix','Electric Fan','LED Light','Mug'],
      datasets: [{
        label: 'Sales',
        data: [120000, 110000, 95000, 85000, 80000],
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

  new Chart(document.getElementById('bottomItemChart'), {
    type: 'bar',
    data: {
      labels: ['Anbara-3kg (KSA)','Mouse','Swarna Rice','Chicken Nuggets','Mystery Box'],
      datasets: [{
        label: 'Sales',
        data: [20000, 25000, 15000, 18000, 22000],
        backgroundColor: [
          rgba(COLORS.red[600], 0.8),
          rgba(COLORS.orange[600], 0.8),
          rgba(COLORS.yellow[600], 0.8),
          rgba(COLORS.green[600], 0.8),
          rgba(COLORS.blue[600], 0.8)
        ],
        borderColor: [
          COLORS.red[600],
          COLORS.orange[600],
          COLORS.yellow[600],
          COLORS.green[600],
          COLORS.blue[600]
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

  new Chart(document.getElementById('yearlyComparisonChart'), {
    type: 'bar',
    data: {
      labels: ['2024','2025','2026'],
      datasets: [{
        label: 'Sales',
        data: [65000000, 78000000, 10000000],
        backgroundColor: [
          COLORS.purple[600],
          COLORS.teal[600],
          COLORS.orange[600]
        ],
        borderColor: [
          COLORS.purple[500],
          COLORS.teal[500],
          COLORS.orange[500]
        ],
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
        hoverBackgroundColor: [
          COLORS.purple[500],
          COLORS.teal[500],
          COLORS.orange[500]
        ]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: {
        ...ANIM_BAR,
        delay: (ctx) => ctx.dataIndex * 150 + 200
      },
      plugins: {
        legend: { display: false },
        tooltip: { ...TOOLTIP, callbacks: { label: ctx => ' ৳' + Number(ctx.raw).toLocaleString() } }
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