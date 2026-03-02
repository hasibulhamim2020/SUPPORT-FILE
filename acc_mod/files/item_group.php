<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Product Group';
$proj_id=$_SESSION['proj_id'];
$inventory=find_a_field('config_group_class','inventory',"1");

$now=time();
$unique='group_id';
$unique_field='group_name';
$table='item_group';
$page="item_group.php";
$crud      =new crud($table);
$$unique = $_GET[$unique];

if(isset($_POST[$unique_field]))
{
$$unique = $_POST[$unique];
//for Record..................................

if(isset($_POST['record']))
{		
$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['ledger_group_id']=$inventory;
//$sub_ledger_id=number_format(next_sub_ledger_id($inventory), 0, '.', '');
//sub_ledger_create($sub_ledger_id,$group_name, $inventory, '', $now, $proj_id);


$min=number_format(($inventory*1000000000000)+100000000, 0, '.', '');
$max=number_format(($inventory*1000000000000)+1000000000000, 0, '.', '');
$_POST[$unique]=number_format(next_value('group_id','item_group','100000000',$min,$min,$max), 0, '.', '');

$crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['modify']))

{
		$_POST['edit_at']=time();
		$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}

//for Delete..................................



if(isset($_POST['delete']))

{		
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}



}

if(isset($$unique))

{

$condition=$unique."=".$$unique;	
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}

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
document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;
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
								<th>Item Group</th>
								<th>Ledger Group</th>
								</tr>
<?php
	$rrr = "select b.group_id,a.group_name as master_group, b.group_name,b.transection_type,b.inventory_type from item_group b,ledger_group a where a.group_id=b.ledger_group_id";

	$report = db_query($rrr);
	$i=0;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[2];?></td>
								<td><?=$rp[1];?></td>
								</tr>
	<?php }?>
							</table>									</td>
								  </tr>
		</table>

	</div></td>    <td valign="top" width="34%" >
	<div class="rights"> <form id="form1" name="form1" method="post" action="" onsubmit="return check()">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="100%" colspan="2"><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Group  Name : </td>
                                        <td>

<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />
<input name="group_name" type="text" id="group_name" value="<?php echo $group_name;?>" size="30" maxlength="100" class="required" /></td>
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
								        <td><? if($$unique<1){?>
								          <input name="record" type="submit" id="record" value="Record" onclick="return checkUserName()" class="btn" />
								          <? }?></td>
								        <td><? if($$unique>0){?>
								          <input name="modify" type="submit" id="modify" value="Modify" class="btn" />
								          <? }?></td>
								        <td><input name="clear" type="button" class="btn" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>
								        <td><? if($_SESSION['user']['level']==5){?>
								          <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
								          <? }?></td>
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