<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sundry Creditors';

$proj_id=$_SESSION['proj_id'];

//echo $proj_id;

$customer_id=$_REQUEST['customer_id'];

$customer_name=$_REQUEST['customer_name'];

	$customer_name		= str_replace("'","",$customer_name);

	$customer_name		= str_replace("&","",$customer_name);

	$customer_name		= str_replace('"','',$customer_name);

$customer_company=$_REQUEST['customer_company'];

$address=$_REQUEST['address'];

$cr_amt=$_REQUEST['cr_amt'];

$contact=$_REQUEST['contact'];

$customer_type=$_REQUEST['customer_type'];

$now=time();

//end 

if(isset($_POST['ncustomer']))

{

$check="select ledger_id from accounts_ledger where ledger_name='$customer_name' limit 1";

//echo $check;

if(mysqli_num_rows(db_query($check))>0)

{

	$aaa=mysqli_num_rows(db_query($check));

	$customer_id=$aaa[0];

	$type=0;

	$msg='Given Name('.$customer_name.') is already exists.';

}

else

{

$led=mysqli_fetch_row(db_query("select MAX(ledger_id) from accounts_ledger LIMIT 1"));

$ledger=$led[0]+1;

//echo $ledger;

$sql="INSERT INTO `accounts_ledger` (

`ledger_id`,

`ledger_name` ,

`ledger_group_id` ,

`opening_balance` ,

`balance_type` ,

`depreciation_rate` ,

`credit_limit` ,

`opening_balance_on` ,

`proj_id`)

VALUES ('$ledger','$customer_name', 5, '$cr_amt', 'Credit', '', '', '$now','$proj_id')";

//echo $sql;

$query=db_query($sql);

if($cr_amt>0){

					//invoice number create

					$invoice_no=mysqli_fetch_row(db_query("select MAX(jv_no) from journal LIMIT 1"));

					$xxx= date("Ymd")."0000";

					if($invoice_no[0]>$xxx)

					$jv=$invoice_no[0]+1;

					else

					$jv=$xxx+1;

					$narr="Opening Balance of ".$customer_name;

					

					$jov="INSERT INTO `journal` (

					`proj_id` ,

					`jv_no` ,

					`jv_date` ,

					`ledger_id` ,

					`narration` ,

					`dr_amt` ,

					`cr_amt` ,

					`tr_from` ,

					`tr_no` 

					)

					VALUES ('$proj_id', '$jv', '$now', '$ledger', '$narr', '', '$cr_amt', 'Ledger', '')";

					$query1=db_query($jov);

}

$sql="INSERT INTO `customer` (

`customer_id` ,

`customer_name` ,

`customer_company` ,

`address` ,

`proj_id` ,

`contact_no` ,

`customer_type`

)

VALUES ('$ledger','$customer_name', '$customer_company', '$address', '$proj_id','$contact','$customer_type')";

//echo $sql;

$query=db_query($sql);

		$type=1;

		$msg='New Entry Successfully Inserted.';

}

}





//for Modify..................................



if(isset($_POST['mcustomer']))

{

$search_sql="select 1 from accounts_ledger where `ledger_id`!='$customer_id' and `ledger_name` = '$customer_name' limit 1";

if(mysqli_num_rows(db_query($search_sql))==0)

{

$sql="UPDATE `customer` SET 

`customer_name` = '$customer_name',

`customer_company` = '$customer_company',

`address` = '$address',

`contact_no` = '$contact',

`customer_type` = '$customer_type'

 WHERE `customer_id` = $customer_id LIMIT 1";

$qry=db_query($sql);

$sql="UPDATE `accounts_ledger` SET 

		`ledger_name` 		= '$customer_name'

	WHERE `ledger_id` 		='$customer_id' LIMIT 1";

$qry=db_query($sql);

		$type=1;

		$msg='Successfully Updated.';

}

	else

	{

	$type=0;

	$msg='Given Name('.$customer_name.') is already exists.';

	}

}

if(isset($_POST['dcustomer']))

{



$sql="delete from `customer` where `customer_id`='$customer_id' limit 1";

$query=db_query($sql);

$sql="delete from `accounts_ledger` where `ledger_id`='$customer_id' limit 1";

$query=db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_REQUEST['customer_id']))

{

$ddd="select * from customer where customer_id='$customer_id' and 1";

$data=mysqli_fetch_row(db_query($ddd));

}

/*$report=db_query("select customer_id, customer_name, customer_company, customer_type from customer where 1 order by customer_name asc");*/

?><script type="text/javascript">

$(document).ready(function(){

	

	$("#form2").validate();	

});	

function DoNav(theUrl)

{

	document.location.href = 'customer_info.php?customer_id='+theUrl;

}



</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td>
			<form id="form2" name="form2" method="post" action="">			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			
			<tr>
			
			<td><div class="box" style="width:100%;">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			
			<tr>
			
			<td>Project Name:</td>
			
			<td><input name="customer_name" type="text" id="customer_name" value="" size="30" maxlength="100" class="required" minlength="4" /></td>
			</tr>
			
			
			
			<tr>
			
			<td>Balance Difference </td>
			
			<td><input name="customer_company" type="text" id="customer_company" value="" size="30" maxlength="100" class="required" /></td>
			</tr>
			</table>
			</td>
			<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			
			<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
			<tr>
			<td>Opening Date:</td>
			<td  width="70"><div align="left">
			<input name="customer_name4" type="text" id="customer_name4" value="" size="30" maxlength="100" class="required" minlength="4" />
			</div></td>
			</tr>
			</table></td>
			</tr>
			
			
			
			<tr>
			
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td>Total Debit</td>
			<td>Total Credit</td>
			</tr>
			<tr>
			<td><input name="customer_name2" type="text" id="customer_name2" value="" size="30" maxlength="100" class="required" minlength="4" style="width:130px;" /></td>
			<td><input name="customer_name3" type="text" id="customer_name3" value="" size="30" maxlength="100" class="required" minlength="4" style="width:130px;"/></td>
			</tr>
			</table></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			
			
			</div></td>
			</tr>
			
			<tr>
			
			<td>&nbsp;</td>
			</tr>
			</table>
			
			</form>
	</td>
	    </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td>
      <table cellspacing="0" class="tabledesign">
      <tbody>
      <tr>
      <th align="center">&nbsp;</th>
      <th align="center">&nbsp;</th>
      <th align="center">&nbsp;</th>
      <th height="20" align="center">&nbsp;</th>
      <th height="20" align="center">&nbsp;</th>
      <th align="center">&nbsp;</th>
	  <th align="center">&nbsp;</th>
    </tr>
      <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
    </tr>
	<tr class="alt">
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
    </tr>
	      <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
    </tr>
  </tbody></table>		  
  </td>
	    </tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>
		<div>
                    
		<table width="100%" border="0" cellspacing="0" cellpadding="0">		
		<tr>		
		<td>
		<div style="width:380px;">
		<input name="ncustomer" type="submit" id="ncustomer" value="Record" class="btn" />
		</div></td>
		</tr>
		</table>
	        </div>
		</td>
		</tr>
      </table></td></tr>

</table>9

<script type="text/javascript">

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>