<?php
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

 
$section = $_POST['section'] ?? '';

switch($section){

    case 'accounts_type':
        $accounts_type = $_POST['accounts_type'];
        $sql = "UPDATE config_group_class 
                SET accounts_type='$accounts_type'
                WHERE group_for='".$_SESSION['user']['group']."'"; 
				db_query($sql);
        echo "Accounts Type Updated";
        break;

    case 'sales_setup':
        $sales_ledger   = $_POST['sales_ledger'];
        $sales_discount = $_POST['sales_discount'];
        $sales_vat      = $_POST['sales_vat'];
        $sales_return   = $_POST['sales_return'];
        $cogs_ledger    = $_POST['cogs_ledger'];

        $sql = "UPDATE config_group_class SET
                sales_ledger='$sales_ledger',
                sales_discount='$sales_discount',
                sales_vat='$sales_vat',
                sales_return='$sales_return',
                cogs_ledger='$cogs_ledger'
                WHERE group_for='".$_SESSION['user']['group']."'"; 
				db_query($sql);
        echo "Sales Setup Updated";
        break;

    case 'purchase_setup':
        $sql = "UPDATE config_group_class SET
                purchase_discount='$_POST[purchase_discount]',
                purchase_vat='$_POST[purchase_vat]',
                purchase_ait='$_POST[purchase_ait]',
                localPurchase='$_POST[localPurchase]'
                WHERE group_for='".$_SESSION['user']['group']."'"; 
				db_query($sql);
        echo "Purchase Setup Updated";
        break;

    case 'wip_setup':
        db_query("UPDATE config_group_class 
        SET wip_ledger='$_POST[wip_ledger]' 
        WHERE group_for='".$_SESSION['user']['group']."'");
        echo "WIP Updated";
        break;

    case 'local_sales':
        db_query("UPDATE config_group_class 
        SET localSales='$_POST[localSales]' 
        WHERE group_for='".$_SESSION['user']['group']."'");
        echo "Local Sales Updated";
        break;

    case 'direct_sales':
        db_query("UPDATE config_group_class 
        SET directSales='$_POST[directSales]' 
        WHERE group_for='".$_SESSION['user']['group']."'");
        echo "Direct Sales Updated";
        break;

    case 'cash_ledger':
        db_query("UPDATE config_group_class 
        SET cash_ledger='$_POST[cash_ledger]' 
        WHERE group_for='".$_SESSION['user']['group']."'");
        echo "Cash Ledger Updated";
        break;

    case 'bank_ledger':
        db_query("UPDATE config_group_class 
        SET bank_ledger='$_POST[bank_ledger]' 
        WHERE group_for='".$_SESSION['user']['group']."'");
        echo "Bank Ledger Updated";
        break;

    default:
        echo "Invalid Request";
}

  ?>