<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Product Sub Group';
$proj_id=$_SESSION['proj_id'];

$now=time();
$unique='sub_group_id';
$unique_field='sub_group_name';
$table='item_sub_group';
$page="item_sub_group.php";
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



$min=number_format($_POST['group_id']+10000, 0, '.', '');
$max=number_format($_POST['group_id']+100000000, 0, '.', '');
echo $_POST[$unique]=number_format(next_value('sub_group_id','item_sub_group','10000',$min,$min,$max), 0, '.', '');
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
									<table id="grp" class="table table-bordered" cellspacing="0">
							  <tr>
								<th>Sub Group ID</th>
								<th>Sub Group Name</th>
								<th>Group Name</th>
							  </tr>
<?php
	$rrr = "select b.sub_group_id,b.sub_group_id,a.group_name, b.sub_group_name from item_sub_group b,item_group a where a.group_id=b.group_id";

	$report = db_query($rrr);
	$i=0;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[1];?></td>
								<td><?=$rp[3];?></td>
								<td><?=$rp[2];?></td>
							  </tr>
	<?php }?>
							</table>									</td>
								  </tr>
		</table>

	</div></td>
    <td><div class="right"> <form id="form1" name="form1" method="post" action="" onsubmit="return check()">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="100%" colspan="2"><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Sub Group  Name : </td>
                                        <td>
                                        <input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />
                                        <input name="sub_group_name" type="text" id="sub_group_name" value="<?php echo $sub_group_name;?>" size="30" maxlength="100" class="required" /></td>
									  </tr>

                                      <tr>
                                        <td>Group Name :</td>
                                        <td><select name="group_id" id="group_id">
                                            <option></option>
                                            <?	$sql="select * from item_group order by group_id";
											$query=db_query($sql);
											while($datas=mysqli_fetch_object($query))
										{
										?>
                                            <option <? if($datas->group_id==$group_id) echo 'Selected ';?> value="<?=$datas->group_id?>">
                                              <?=$datas->group_name?>
                                          </option>
                                            <? } ?>
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
									  <? if($_SESSION['user']['group']==3){?>
                                      <tr>
                                        <td>Ledger Account(HFL): </td>
                                        <td><input name="ledger_id_3" type="text" id="ledger_id_3" value="<?php echo $ledger_id_3;?>" size="30" maxlength="100" class="required" /></td>
                                      </tr>
									  <? }?>
									  <? if($_SESSION['user']['group']==2){?>
                                      <tr>
                                        <td>Ledger Account(SC): </td>
                                        <td><input name="ledger_id_2" type="text" id="ledger_id_2" value="<?php echo $ledger_id_2;?>" size="30" maxlength="100" class="required" /></td>
                                      </tr>
									  <? }?>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                                  </table></td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>