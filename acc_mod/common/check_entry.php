<?php
session_start();
//include "check.php";
require_once('../../engine/configure/db_connect.php');


$page = $_REQUEST['pageid'];
$query_item = mysqli_real_escape_string($_REQUEST['query_item']);

if($page == 'account_ledger')
{	
//$sql="select ledger_id_separator from project_info LIMIT 1";
//$res=db_query($sql);
//$data=mysqli_fetch_row($res);
//$separater = $data[0];


if(is_numeric($query_item[0]))

	$check="select * from accounts_ledger where ledger_id='$id'";
	
	if(mysqli_num_rows(db_query($check))>0)
	{
		echo "Name already exist!";
	}
}

if($page == 'account_sub_ledger')
{
	$check="select * from sub_ledger where sub_ledger='$query_item'";
	
	if(mysqli_num_rows(db_query($check))>0)
	{
		echo "Name already exist!";
	}
}

if($page == 'ledger_group')
{
	$check="select * from ledger_group where group_name='$query_item'";
	
	//$check = str_replace('%20', ' ', $check);
	
	if(mysqli_num_rows(db_query($check))>0)
	{
		echo "Name already exist!";
	}
}

if($page == 'acchead') // A/C Head
{
	
$sql="select ledger_id_separator from project_info limit 1";
$res=db_query($sql);
$data=mysqli_fetch_row($res);
$separater = $data[0];

$ledger = explode('::',$query_item);
if(is_numeric($query_item[0]))
$ledger = $ledger[0];
else
$ledger = $ledger[1];
$search=array( ":"," ", "[", "]", "#", $separater);
$id=str_replace($search,'',$ledger);

		$check2="select ledger_id, ledger_name FROM accounts_ledger WHERE ledger_id='$id'";
		if(mysqli_num_rows(db_query($check2))>0)
		{
			echo 'exist';
		//return true;
		}
		else
		{
			echo 'Enter Valid A/C Ledger.';
		//return false;
		}

}


if($page == 'purchase_invoice_item') // A/C Head
{
	$check="select item_id, item_name from item_info WHERE item_id='$query_item'";
	
	if(mysqli_num_rows(db_query($check))>0)
	{
		echo 'exist';
		//return true;
	}
	else
	{
		echo 'Enter correct item ID!.';
		//return false;
	}
}

if($page == 'sales_invoice_item') // A/C Head
{
	$check="select item_id, item_name from item_info WHERE item_id='$query_item'";
	//$check="select item_id, item_name from item_info where b.inventory_type='Sales' and a.group_id=b.group_id order by item_name";
	
	if(mysqli_num_rows(db_query($check))>0)
	{
		echo 'exist';
		//return true;
	}
	else
	{
		echo 'Enter correct item ID!.';
		//return false;
	}
}
?>