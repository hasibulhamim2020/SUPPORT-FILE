<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$now=time();
$title='User Manage';
$unique='user_id';
$unique_field='username';
$table='user_activity_management';
$page="user_manage.php";
do_calander('#expire_date');

$crud      =new crud($table);

$$unique = $_GET[$unique];

if(isset($_POST[$unique_field]))
{
$$unique = $_POST[$unique];

//for Record..................................

if(isset($_POST['record']))
{		
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['modify']))
{
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		
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
function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table id="grp" class="table table-bordered" cellspacing="0">
            <tr>
              <th>User </th>
              <th>User Name</th>
              <th>Designation</th>
            </tr>
            <?php
	$rrr = "select * from user_activity_management order by user_id";
	$report=db_query($rrr);

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
            <tr<?=$cls?> onclick="nav('<?php echo $rp[0];?>');">
              <td><nobr>
                <?=$rp[1];?>
              </nobr></td>
              <td><?=$rp[4];?></td>
              <td><?=$rp[8];?></td>
            </tr>
            <?php }?>
          </table>
                </td>
        </tr>
      </table>
    </div></td>    <td valign="top" width="34%" >
	<div class="rights">
      <form id="form1" name="form1" method="post" action="<?=$page?>?<?=$unique?>=<?=$$unique?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div class="box">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>User  Name:</td>
                  <td>
				  
<? if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique)?>
<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />
				  
				  
				  
				  
				  <input name="username" type="text" id="username" value="<?php echo $username;?>" class="required" autocomplete="off" /></td>
                </tr>
                <tr>
                  <td>Password:</td>
                  <td><input type="password" name="password" id="password" value="<?php echo $password;?>" class="required" /></td>
                </tr>
                <tr>
                  <td>User Group: </td>
                  <td>
                    <select name="level" id="level">
                      <? foreign_relation('user_type','user_level','user_type_name_show',$level);?>
                      </select>
                    
  </td>
                </tr>
                <tr>
                  <td>Concern Group:</td>
                  <td>
                  <select name="group_for" id="group_for">
                    <? foreign_relation('user_group','id',' group_name',$group_for);?>
                  </select></td>
                </tr>
                <tr>
                  <td>Full Name: </td>
                  <td><input name="fname" type="text" id="fname" value="<?php echo $fname;?>"/></td>
                </tr>
                <tr>
                  <td>Designation:</td>
                  <td><input name="designation" type="text" id="designation" value="<?php echo $designation;?>"/></td>
                </tr>
                <tr>
                  <td>Address:</td>
                  <td><textarea name="address" id="address"><?php echo $address;?></textarea></td>
                </tr>
                <tr>
                  <td>Email:</td>
                  <td><input name="email" type="text" id="email" value="<?php echo $email;?>" autocomplete="off" /></td>
                </tr>
                <tr>
                  <td>Mobile:</td>
                  <td><input name="mobile" type="text" id="mobile" value="<?php echo $mobile;?>"/></td>
                </tr>
                <tr>

                  <td>Warehouse(Optional):</td>

                  <td><select name="warehouse_id" id="warehouse_id">
                    <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id);?>
                  </select></td>

                </tr>
                <tr>
                  <td>Expire Date: </td>
                  <td><input name="expire_date" type="text" id="expire_date" value="<?php echo $expire_date;?>"/></td>
                </tr>
                <tr>
                  <td>Status:</td>
                  <td><input name="status" type="text" id="status" value="<?php echo $status;?>" autocomplete="off"/></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div class="box1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
<? if(!isset($_POST[$unique])&&!isset($_GET[$unique])) {?>
<input name="record" type="submit" id="record" value="Record" onclick="return checkUserName()" class="btn" />
<? }?>
				  </td>
                  <td>
<? if(isset($_POST[$unique])||isset($_GET[$unique])) {?>
<input name="modify" type="submit" id="modify" value="Modify" class="btn" />
<? }?>
</td>
                  <td><input name="clear" type="button" class="btn" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>
                  <td>
<? if($_SESSION['user']['level']==5){?>
<input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
<? }?>
					</td>
                </tr>
              </table>
            </div></td>
          </tr>
        </table>
      </form>
    </div></td>
  </tr>
</table>200
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