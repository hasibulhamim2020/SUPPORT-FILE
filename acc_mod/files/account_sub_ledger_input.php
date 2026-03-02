<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Account Sub Ledger';
$proj_id=$_SESSION['proj_id'];
do_datatable('ac_ledger');
$now=time();
function add_separator(){}
$separator	= $_SESSION['separator'];

if(isset($_REQUEST['name'])||isset($_REQUEST['id']))
{
	//common part.............
	
	$id=$_REQUEST['id'];
	//echo $ledger_id;
	$name		= mysqli_real_escape_string($_REQUEST['name']);
	$name		= str_replace("'","",$name);
	$name		= str_replace("&","",$name);
	$name		= str_replace('"','',$name);
	$under		= mysqli_real_escape_string($_REQUEST['under']);
	$balance	= mysqli_real_escape_string($_REQUEST['balance']);
	
	
	
	
	//end
	if(isset($_POST['nledger']))
	{
			$sql_check="select ledger_group_id, balance_type, budget_enable from accounts_ledger where ledger_id='".$under."' limit 1";
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
			$sub_ledger_id=number_format(next_sub_ledger_id($under), 0, '.', '');
			$group_for=$_SESSION['user']['group'];
			$ledger_layer=2;
			//sub_ledger_create($sub_ledger_id,$name, $under, $balance, $now, $proj_id);
			ledger_create($sub_ledger_id,$name,$ledger_data[0],$group_for,$under,$ledger_data[1],'','4', time(),$ledger_layer,$ledger_data[2]);
			 $sql = 'update accounts_ledger set ledger_layer = 2 where ledger_id = '.$sub_ledger_id.' ';
			 db_query($sql);
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

//for Modify..................................

	if(isset($_POST['mledger']))
	{
$search_sql="select 1 from accounts_ledger where `ledger_id`!='$id' and `ledger_name` = '$name' limit 1";
if(mysqli_num_rows(db_query($search_sql))==0)
	{
		$sql_check="select ledger_id from accounts_ledger where ledger_id=".$under;
		$sql_query=db_query($sql_check);
		if(mysqli_num_rows($sql_query)==1){
		$id=$_REQUEST['id'];
		$sql2="UPDATE `accounts_ledger` SET 
		`ledger_name` 		= '$name', balance_type = $under	
			WHERE `ledger_id` 		='$id' LIMIT 1";
		//$sql="UPDATE `sub_ledger` SET `sub_ledger` = '$name' WHERE `sub_ledger_id` =$id LIMIT 1";
		//$query=db_query($sql);
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
$sql="delete from `sub_ledger` where `sub_ledger_id`='$id' limit 1";
$query=db_query($sql);
$sql="delete from `accounts_ledger` where `ledger_id`='$id' limit 1";
$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}

    $ddd="select * from accounts_ledger where ledger_id='$id'";
	$data=mysqli_fetch_object(db_query($ddd));
}

auto_complete_from_db('accounts_ledger','ledger_name','ledger_id','ledger_id like "%00000000"','under');
?>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>

<form id="form2" name="form2" method="post" action="account_sub_ledger_input.php?id=<?php echo $id;?>">
		
								
	<div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Sub Ledger  Name :</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="name" required type="text" id="name" value="<?php echo $data->ledger_name;?>" class="required" />
      </div>
    </div>
  </div>
  
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Under Ledger :</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input type="text" name="under" required id="under" value="<?php echo $data->balance_type;?>" class="required" />
      </div>
    </div>
  </div>
  
  
  
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<? if($data->ledger_id==""){?><input name="nledger" type="submit" id="nledger" value="Record" class="btn" /><? }?>
<? if($data->ledger_id!=""){?><input name="mledger" type="submit" id="mledger" value="Modify" class="btn" /><? }?>
<input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='account_sub_ledger.php'"/>
<? if($_SESSION['user']['level']==10){?><input class="btn" name="dledger" type="submit" id="dledger" value="Delete"/><? }?>
      </div>
    </div>
  </div>
							  

    </form>

<script type="text/javascript">







function Do_Nav()



{



	var URL = 'pop_ledger_selecting_list.php';



	popUp(URL);



}







function DoNav(theUrl)



{



	document.location.href = 'account_sub_ledger.php?id='+theUrl;



}



function popUp(URL) 



{



	day = new Date();



	id = day.getTime();



	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");



}



</script>
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