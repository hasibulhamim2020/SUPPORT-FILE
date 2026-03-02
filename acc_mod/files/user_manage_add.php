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
$active='usmanag';
$button="yes";
$crud      =new crud($table);

$$unique = $_GET[$unique];

 $$unique;
if(isset($_POST[$unique_field]))
{
$$unique = $_POST[$unique];

//for Record..................................

if(isset($_POST['record']))
{
        $path='../../user_pic/';
		$target_file ='../../user_pic/'.$$unique.'.jpg';
		move_uploaded_file($_FILES["pic"]["tmp_name"],$target_file);
				
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['modify']))
{
        $path='../../user_pic/';
		//$_POST['pic']=image_upload($path,$_FILES['pic']);
		$target_file = $path .$$unique.'jpg';
		move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
         
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
<style>
.custombox{

	width:450px;
	}
</style>

    
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td><div class="box custombox">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="text-center" ><div align="center">User  Name:</div></td>
                  <td >
				  
<? if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique)?>
<input name="<?=$unique?>" class="form-control" type="hidden" id="<?=$unique?>" style="max-width:250px;" value="<?=$$unique?>"  />
				  
				  
				  
				  
				  <input name="username" type="text" id="username" value="<?php echo $username;?>" class="required form-control" style="max-width:250px;" /></td>
                </tr>
                <tr>
                  <td><div align="center">Password:</div></td>
                  <td ><input type="password" name="password" style="max-width:250px;" id="password" value="<?php echo $password;?>" class="required form-control" /></td>
                </tr>
                <tr>
                  <td><div align="center">User Group: </div></td>
                  <td >
                    <select name="level" id="level" class="form-control" style="max-width:250px;">
                      <? foreign_relation('user_type','user_level','user_type_name_show',$level);?>
                      </select>
                    
  </td>
                </tr>
                <tr>
                  <td><div align="center">Concern Group:</div></td>
                  <td >
                  <select name="group_for" id="group_for" class="form-control" style="max-width:250px;">
                    <? foreign_relation('user_group','id',' group_name',$group_for);?>
                  </select></td>
                </tr>
                <tr>
                  <td><div align="center">Full Name: </div></td>
                  <td ><input name="fname" type="text" class="form-control" style="max-width:250px;" id="fname" value="<?php echo $fname;?>"/></td>
                </tr>
                <tr>
                  <td><div align="center">Designation:</div></td>
                  <td ><input name="designation" type="text" style="max-width:250px;" class="form-control" id="designation" value="<?php echo $designation;?>"/></td>
                </tr>
                <tr>
                  <td><div align="center">Address:</div></td>
                  <td ><textarea name="address" class="form-control" style="max-width:250px;" id="address"><?php echo $address;?></textarea></td>
                </tr>
                <tr>
                  <td><div align="center">Email:</div></td>
                  <td ><input name="email" class="form-control" style="max-width:250px;" type="text" id="email" value="<?php echo $email;?>"/></td>
                </tr>
                <tr>
                  <td><div align="center">Mobile:</div></td>
                  <td ><input name="mobile" class="form-control" type="text" style="max-width:250px;" id="mobile" value="<?php echo $mobile;?>"/></td>
                </tr>
                <tr>

                  <td><div align="center">Warehouse(Optional):</div></td>

                  <td ><select name="warehouse_id" class="form-control" id="warehouse_id" style="max-width:250px;">
                    <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id);?>
                  </select></td>

                </tr>
                <tr>
                  <td><div align="center">Expire Date: </div></td>
                  <td ><input name="expire_date" class="form-control" type="text" style="max-width:250px;" id="expire_date" value="<?php echo $expire_date;?>"/></td>
                </tr>
                <tr>
                  <td><div align="center">Job Status:</div></td>
                  <td >
				  	<select name="status" class="form-control" style="max-width:250px;">
					<option></option>
                      <option <?=($status=='In Service')?'selected':'';?>>In Service</option>
                      <option <?=($status=='Not In Service')?'selected':'';?>>Not In Service</option>
                     </select>
				  
				  </td>
                </tr>
				
				<tr>
                  <td><div align="center">User Image : </div></td>
                  <td >
				  	<input name="pic" class="form-control" style="max-width:250px;" type="file" id="pic" accept="image/jpeg" />
				  
				  </td>
                </tr>
              </table>
            </div></td>
          </tr>
         
          
        </table>
      
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
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>