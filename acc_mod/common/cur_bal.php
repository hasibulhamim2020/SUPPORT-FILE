<?php
session_start();
//include "check.php";
//require("../common/db_connect.php");

require_once "../../assets/support/inc_all.php";
//require_once SERVER_ENGINE2."tools/check.php";
//require_once SERVER_ENGINE2."configure/db_connect.php";

$proj_id = $_SESSION['proj_id'];


@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
/*
$id=ledger_id($_REQUEST['id']);
//$id=substr($_REQUEST['id'],0,6);
//$id=$_REQUEST['id'];
if($id<100000)
$a2="select SUM(cr_amt)-SUM(dr_amt) from journal where sub_ledger='$id'";
else
$a2="select SUM(cr_amt)-SUM(dr_amt) from journal where ledger_id='$id'";
$a1=mysqli_fetch_row(db_query($a2));
if($a1[0]<0)
$a1[0]=$a1[0]*(-1);
else
if(is_null($a1[0]))
$a1[0]=0;
echo "<input name=\"cur_bal\" type=\"text\" id=\"cur_bal\" size=\"13\" maxlength=\"100\" value=\"$a1[0]\" readonly/>";
*/

$str = $_POST['ledger'];
$combined 		= explode('::',$str);
if($combined[0]>1000)
$ledger_id	 = $combined[0];
elseif($combined[1]>1000)
$ledger_id	 = $combined[1];

//$_SESSION['chosen_ledger']=$str;
if(isset($ledger_id))
	{
		$chk_balance = db_query("SELECT SUM(cr_amt)-SUM(dr_amt) AS 'balance' FROM journal WHERE ledger_id=$ledger_id");
		$balance 	 = mysqli_result($chk_balance,0,'balance');
		if( $balance < 0 )
			$balance *= (-1);
		//$balance 		= $str;	
	}
	
$ledger_segment = explode(':',$ledger);
if( $ledger_segment[0] != ' ' )
	echo "<input name=\"cur_bal\" type=\"text\" id=\"cur_bal\" size=\"15\" maxlength=\"100\" value=\"$balance\" readonly /><input name=\"ledger\" type=\"hidden\" id=\"ledger\" value=\"$ledger\"/><input name=\"ledger_status\" type=\"hidden\" id=\"ledger_status\" value=\"ledger_head_exists\"/>";
else
	echo "<input name=\"cur_bal\" type=\"text\" id=\"cur_bal\" size=\"15\" maxlength=\"100\" value=\"$balance\" readonly /><input name=\"ledger\" type=\"hidden\" id=\"ledger\" value=\"$ledger\"/><input name=\"ledger_status\" type=\"hidden\" id=\"ledger_status\" value=\"ledger_head_not_exists\"/>";			

?> 