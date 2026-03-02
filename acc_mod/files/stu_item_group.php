<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Course Category';
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
$now=time();
//echo $proj_id;
if(isset($_REQUEST['group_name'])||isset($_REQUEST['group_id']))
{
//common part.............
$group_id=$_REQUEST['group_id'];
$group_name=$_REQUEST['group_name'];
$group_name		= str_replace("'","",$group_name);
$group_name		= str_replace("&","",$group_name);
$group_name		= str_replace('"','',$group_name);
$ledger_group=$_REQUEST['under_ledger'];
$t_type=$_REQUEST['t_type'];
$inventory_type=$_REQUEST['inventory_type'];
$now		= time();
//end 
if(isset($_POST['ngroup']))
{
	$check=	"select ledger_id from accounts_ledger where ledger_name='$group_name' limit 1";
	if(mysqli_num_rows(db_query($check))>0)
	{
		$aaa=mysqli_num_rows(db_query($check));
		$group_id=$aaa[0];
		$type=0;
		$msg='Given Name('.$group_name.') is already exists.';
	}
	else
	{
$id=under_ledger_id($ledger_group);		
if(($id%1000)==0)
ledger_create($id,$group_name,$ledger_group,'0.00','Both',$depreciation_rate,'', $now,$proj_id,'NO');
else
{
ledger_create($id,$group_name,$ledger_group,'0.00','Both',$depreciation_rate,'', $now,$proj_id,'NO');
sub_ledger_create($id,$group_name, $ledger_group, '0.00', $now, $proj_id);
}
		
		//////////////////////add group//////////////////
		$sql="INSERT INTO `stu_course_category` (
		`group_id`,
		`group_name` ,
		`ledger_group_id` ,
		`transection_type`,
		`inventory_type`,
		`profit_ledger`
		)
		VALUES ('$id','$group_name', '$ledger_group','$t_type','$inventory_type','$profit_ledger')";
		//echo $sql;
		$query=db_query($sql);
		$group_id=$ledger;
		$type=1;
		$msg='New Entry Successfully Inserted.';

		
		
		
	}
}


//for Modify..................................

if(isset($_POST['mgroup']))
{
$search_sql="select 1 from accounts_ledger where `ledger_id`!='$group_id' and `ledger_name` = '$group_name' limit 1";
if(mysqli_num_rows(db_query($search_sql))==0)
{
$sql="UPDATE `stu_course_category` SET 
`group_name` = '$group_name',
`inventory_type`='$inventory_type'
WHERE `group_id` = '$group_id' LIMIT 1";
$qry=db_query($sql);
//echo $sql;
//for acc ledger
$sql="UPDATE `accounts_ledger` SET 
`ledger_name` = '$group_name'
WHERE `ledger_id` = '$group_id' LIMIT 1";
$qry=db_query($sql);
		$type=1;
		$msg='Successfully Updated.';
}
		else
	{
	$type=0;
	$msg='Given Name('.$vendor_name.') is already exists.';
	}
//echo $sql;
}
$ddd="select * from stu_course_category where group_id='$group_id'";
$data=mysqli_fetch_row(db_query($ddd));
}
$rr="select b.group_id,a.group_name, b.group_name,b.transection_type,b.inventory_type from stu_course_category b,ledger_group a where a.group_id=b.ledger_group_id";
//echo $rr;
$report=db_query($rr);

?>

<script type="text/javascript">
function Do_Nav()
{
	var URL = 'pop_ledger_selecting_list.php';
	popUp(URL);
}
$(document).ready(function(){
	
	$("#form1").validate();	
});	
function DoNav(theUrl)
{
	document.location.href = 'stu_item_group.php?group_id='+theUrl;
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
							  <th>ID</th>
								<th>Category Name</th>
								
								<th>Type</th>
							  </tr>
<?php
	$rrr = "select a.ledger_id,a.ledger_name, b.inventory_type from stu_course_category b,accounts_ledger a where a.ledger_id=b.group_id";

	$report = db_query($rrr);
	$i=0;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>
								<td><?=$rp[2];?></td>
							  </tr>
	<?php }?>
							</table>									</td>
								  </tr>
		</table>

	</div></td>
    <td><div class="right"> <form id="form1" name="form1" method="post" action="stu_item_group.php?group_id=<?php echo $group_id;?>" onsubmit="return check()">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="100%" colspan="2"><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Category  Name : </td>
                                        <td><input name="group_name" type="text" id="group_name" value="<?php echo $data[1];?>" size="30" maxlength="100" class="required" /></td>
									  </tr>

                                      <tr>
                                        <td>Under Ledger : </td>
                                        <td>
<input type="button" name="Button" value="Go" class="go" onclick="Do_Nav()" /><input style="width:155px" name="under_ledger" type="text" id="under_ledger" />
<input name="hiddenField" type="hidden" value="<?=$ledger_group_id?>" /></td>
                                      </tr>
                                      <tr>
                                        <td>Type :</td>
                                        <td>
<select name="inventory_type" id="inventory_type">
  <option value="A"<?php if($data[4]=='A') echo " Selected "?>>A</option>
  <option value="B"<?php if($data[4]=='B') echo " Selected "?>>B</option>
  <option value="C"<?php if($data[4]=='C') echo " Selected "?>>C</option>
</select>										</td>
                                      </tr>
                                      <tr>
                                        <td>Transection Type :</td>
                                        <td><select name="t_type" id="t_type">
                                          <option value="Debit"<?php if($data[3]=='Debit') echo " Selected "?>>Debit</option>
                                          <option value="Credit"<?php if($data[3]=='Credit') echo " Selected "?>>Credit</option>
                                          <option value="Both"<?php if($data[3]=='Both') echo " Selected "?>>Both</option>
                                        </select></td>
									  </tr>
                                    </table>
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
                                      <td>
<input name="ngroup" type="submit" id="ngroup" value="Record" onclick="return checkUserName()" class="btn" /></td>
                                      <td>
<input name="mgroup" type="submit" id="mgroup" value="Modify" class="btn" /></td>
                                      <td>
<input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='stu_item_group.php'"/></td>
                                      <td>
<input class="btn" name="dgroup" type="submit" id="dgroup" value="Delete"/></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
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
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>