<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Course Information';
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
$now=time();
//echo $proj_id;
$id			= mysqli_real_escape_string($_REQUEST['id']);
$item_name	= mysqli_real_escape_string($_REQUEST['item_name']);
$item_name	= str_replace("'","",$item_name);
$item_name	= str_replace("&","",$item_name);
$item_name	= str_replace('"','',$item_name);
$cost_p		= mysqli_real_escape_string($_REQUEST['cost_p']);
$sale_p		= mysqli_real_escape_string($_REQUEST['sale_p']);
$reorder	= mysqli_real_escape_string($_REQUEST['reorder']);
$fdate		= mysqli_real_escape_string($_REQUEST["fdate"]);
$item_desc	= mysqli_real_escape_string($_REQUEST["item_desc"]);
$group_name	= mysqli_real_escape_string($_REQUEST["group_name"]);
$now		= time();
//end 

if(isset($_POST['nitems']))
{
	$check="select ledger_id from accounts_ledger where ledger_name='$item_name' limit 1";
	if(mysqli_num_rows(db_query($check))>0)
	{
		$aaa=mysqli_num_rows(db_query($check));
		$customer_id=$aaa[0];
		$type=0;
		$msg='Given Name('.$item_name.') is already exists.';
	}
	else
	{	
$id=under_ledger_id($group_name);		
if(($id%1000)==0)
ledger_create($id,$item_name,$group_name,'0.00','Both',$depreciation_rate,'', $now,$proj_id,'NO');
else
{
ledger_create($id,$item_name,$group_name,'0.00','Both',$depreciation_rate,'', $now,$proj_id,'NO');
sub_ledger_create($id,$item_name, $group_name, '0.00', $now, $proj_id);
}
		$sql="INSERT INTO `stu_course` 
		( `item_id` , `item_name` , `group_id` , `cost_price` , `sale_price` ,`rcvqty`, `saleqty`, `reorder`, `entrydate`, `item_description`) 
		VALUES ('$id', '$item_name', '$group_name', '$cost_p', '$sale_p',0,0,'$reorder','$fdate', '$item_desc')";

		$query=db_query($sql);
		$type=1;
		$msg='New Entry Successfully Inserted.';
	}
}


//for Modify..................................

if(isset($_POST['mitems']))
{
$search_sql="select 1 from accounts_ledger where `ledger_id`!='$customer_id' and `ledger_name` = '$item_name' limit 1";
if(mysqli_num_rows(db_query($search_sql))==0)
{
if(($id%1000)==0)
{
		$sql2="UPDATE `accounts_ledger` SET 
		`ledger_name` 		= '$item_name'	
			WHERE `ledger_id` 		='$id' LIMIT 1";
		$query=db_query($sql2);
			$sql="UPDATE `stu_course` SET 
								`item_name` 	= '$item_name', 
								`sale_price` 	= '$sale_p', 
								`cost_price` 	= '$cost_p',
								`reorder` 		= '$reorder',
								`entrydate` 	= '$fdate',
								`item_description` 	= '$item_desc'
							WHERE `item_id` 	= $id LIMIT 1";
	$qry=db_query($sql);
}
else
{
		$sql2="UPDATE `accounts_ledger` SET 
		`ledger_name` 		= '$item_name'	
			WHERE `ledger_id` 		='$id' LIMIT 1";
		$sql="UPDATE `sub_ledger` SET
		`sub_ledger` = '$item_name'
		WHERE `sub_ledger` =$id LIMIT 1";
		$query=db_query($sql);
		$query=db_query($sql2);
			$sql="UPDATE `stu_course` SET 
								`item_name` 	= '$item_name', 
								`sale_price` 	= '$sale_p', 
								`cost_price` 	= '$cost_p',
								`reorder` 		= '$reorder',
								`entrydate` 	= '$fdate',
								`item_description` 	= '$item_desc'
							WHERE `item_id` 	= $id LIMIT 1";
	$qry=db_query($sql);
}

	
	$type=1;
	$msg='Successfully Updated.';
}
		else
	{
	$type=0;
	$msg='Given Name('.$vendor_name.') is already exists.';
	}
}
	if(isset($_POST['ditems']))
{
$id=$_REQUEST['id'];
$sql="delete from `sub_ledger` where `sub_ledger_id`='$id' limit 1";
$query=db_query($sql);
$sql="delete from `stu_course` where item_id='$id' limit 1";
$query=db_query($sql);
$sql="delete from `accounts_ledger` where `ledger_id`='$id' limit 1";
$query=db_query($sql);
$type=1;
$msg='Successfully Deleted.';
}
if(isset($_REQUEST['id']))
{
	$ddd="select * from stu_course where item_id='$id'";
	//echo $ddd;
	$data=mysqli_fetch_row(db_query($ddd));
}

$td="select a.item_id,a.item_name,b.group_name,a.cost_price,a.sale_price, a.reorder, a.entrydate, a.item_description FROM stu_course a,  stu_course_category b where b.group_id=a.group_id order by item_id";
//echo $td;
$report=db_query($td);
?>
<script type="text/javascript">
$(function() {
		$("#fdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
});
function Do_Nav()
{
	var URL = 'pop_ledger_selecting_list.php';
	popUp(URL);
}

function DoNav(theUrl)
{
	document.location.href = 'stu_item_info.php?id='+theUrl;
}
function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>
									<table id="grp" class="tabledesign" cellspacing="0">
							  <tr>
								<th>Course Name</th>
								<th>Category</th>
								<th>Entry Date</th>
							  </tr>
<?php
while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[1];?></td>
								<td><?=$rp[2];?></td>
								<td><?=$rp[6];?></td>
							  </tr>
	<?php }?>
							</table>									</td>
								  </tr>
		</table>

	</div></td>
    <td><div class="right">   <form action="stu_item_info.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="100%" colspan="2"><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Course Name : </td>
                                        <td>
										<input name="item_name" type="text" id="item_name" value="<?php echo $data[1];?>" size="30" maxlength="100" class="required" /></td>
									  </tr>

                                      <tr>
                                        <td>Course Description :</td>
                                        <td><textarea name="item_desc" id="item_desc" cols="27" rows="3"><?php echo $data[11];?></textarea></td>
									  </tr>
                                      <tr>
                                        <td>Course Category:</td>
                                        <td><?php

$a2="select group_id, group_name from  stu_course_category";
//echo $a2;
$a1=db_query($a2);
echo "<select name=\"group_name\" id=\"group_name\"\">";
while($a=mysqli_fetch_row($a1))
{
if($a[0]==$data[2])
echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";
else
echo "<option value=\"".$a[0]."\">".$a[1]."</option>";
}
echo "</select>";
?></td>
                                      </tr>
                                      <tr>
                                        <td>Entry Date:</td>
                                        <td><input name="fdate" type="text" id="fdate" value="<?php echo $date = (!empty($data[10]))?$data[10]:date("Y-m-d",time())?>" size="15" maxlength="15" /></td>
                                      </tr></table>
                                  </div></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td colspan="2">
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="nitems" type="submit" id="nitems" value="Record" onclick="return checkUserName()" class="btn" /></td>
                                      <td><input name="mitems" type="submit" id="mitems" value="Modify" class="btn" /></td>
                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='stu_item_info.php'"/></td>
                                      <td><input class="btn" name="ditems" type="submit" id="ditems" value="Delete"/></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>35);
    pager.init();
    pager.showPageNav('pager', 'pageNavPosition');
    pager.showPage(1);
//-->
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