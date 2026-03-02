<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Account Sub Sub Ledger';
$proj_id=$_SESSION['proj_id'];
$now=time();
$active='subsubl';
$button="yes";
$unique='id';
$$unique=$_REQUEST[$unique];
$separator	= $_SESSION['separator'];
if(isset($_REQUEST['name'])||isset($_REQUEST['id']))
{
	//common part.............
	
	$id=$_REQUEST['id'];
	//echo $ledger_id;
	$name		= mysqli_real_escape_string($_REQUEST['name']);
	$name			= str_replace("'","",$name);
	$name			= str_replace("&","",$name);
	$name			= str_replace('"','',$name);
	$under		= mysqli_real_escape_string($_REQUEST['under']);
	$balance	= mysqli_real_escape_string($_REQUEST['balance']);
	//end
	if(isset($_POST['nledger']))
	{
		  $check="select sub_sub_ledger_id from sub_sub_ledger where sub_sub_ledger='$name'";
		//echo $check;
		if(mysqli_num_rows(db_query($check))>0)
		{
			$aaa=mysqli_num_rows(db_query($check));
			$ledger_id=$aaa[0];
				$type=0;
				$msg='Given Name('.$name.') is already exists.';
		}
		else
		{	$sql_check="select ledger_id,balance_type,budget_enable from accounts_ledger where ledger_id='".$under."' limit 1";
			$sql_query=db_query($sql_check);
			if(mysqli_num_rows($sql_query)>0){
			$ledger_data=mysqli_fetch_row($sql_query);
				if(!ledger_redundancy($name))
				{
					$type=0;
					$msg='Given Name('.$name.') is already exists as Ledger.';
				}
			else
			{				
			 		$sub_ledger_id=next_sub_sub_ledger_id($under);
					sub_sub_ledger_create($sub_ledger_id,$name, $under, $balance, $now, $proj_id);

					ledger_create($sub_ledger_id,$name,$ledger_data[0],'',$ledger_data[1],'','', time(),$proj_id,$ledger_data[2]);
					$type=1;
					$msg='New Entry Successfully Inserted.';
						
			}

		}
		else
		{
		$type=0;
		$msg='Invalid Accounts Ledger!!!';
		}
		}
	}

//for Modify..................................

	if(isset($_POST['modify']))
	{
$search_sql="select 1 from sub_sub_ledger where `sub_sub_ledger_id`!='$id' and `sub_sub_ledger` = '$name' limit 1";
if(mysqli_num_rows(db_query($search_sql))==0)
	{
		$sql_check="select ledger_id from accounts_ledger where ledger_id=".$under;
		$sql_query=db_query($sql_check);
		if(mysqli_num_rows($sql_query)==1){
		$id=$_REQUEST['id'];
		$sql2="UPDATE `accounts_ledger` SET 
		`ledger_name` 		= '$name'	
			WHERE `ledger_id` 		=".$$unique." LIMIT 1";
		$sql="UPDATE `sub_sub_ledger` SET
		`sub_sub_ledger` = '$name'
		WHERE `sub_sub_ledger_id` =".$$unique." LIMIT 1";
		$query=db_query($sql);
		$query=db_query($sql2);
		$type=1;
		$msg='Successfully Updated.';
		}
		else
		{
		$type=0;
		$msg='Invalid Accounts Ledger!!!';
		}
		//echo $sql;
	}
	else
	{
	$type=0;
	$msg='Given Name('.$name.') is already exists.';
	}
	}

	if(isset($_POST['dledger']))
{
$id=$_REQUEST['id'];
$sql="delete from `sub_sub_ledger` where `sub_sub_ledger_id`='$id' limit 1";
$query=db_query($sql);
$sql="delete from `accounts_ledger` where `ledger_id`='$id' limit 1";
$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}

	$ddd="select * from sub_sub_ledger where sub_sub_ledger_id=".$$unique;
	$data=mysqli_fetch_row(db_query($ddd));
}
?>

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Sub Sub Ledger   : </td>
                                        <td><input name="name" type="text" style="max-width:250px;" id="name" value="<?php echo $data[1];?>" class="required" /></td>
									  </tr>

                                      <tr>
                                        <td>Under Sub Ledger  : </td>
                                        <td><input type="text" style="max-width:250px;" name="under" id="under" value="<?php echo $data[2];?>" class="required" /></td>
									  </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                              
                              </table>75
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
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>