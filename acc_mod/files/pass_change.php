<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Change Password';
$user_id=$_SESSION['user']['id'];
include('../../engine/configure/db_connect_scb_main.php');

	//common part.............

	$proj_id		= $_SESSION['proj_id'];

	if((isset($_REQUEST['mproject'])))
	{
$old_pass		= mysqli_real_escape_string($_REQUEST['old_pass']);
$new_pass1		= mysqli_real_escape_string($_REQUEST['new_pass1']);
$new_pass2		= mysqli_real_escape_string($_REQUEST['new_pass2']);
		if(($new_pass1==$new_pass2)&&($new_pass1!=''))
		{
$msg='Successfully Updated';
$type=1;

$s="select 1 from scb_login where 1 and user_id='$user_id' and pass='$old_pass' limit 1";
	$check_old_pass	= db_query($s);
	if(mysqli_num_rows($check_old_pass)>0)
	{
		$sql="UPDATE `scb_login` SET 
			`pass` = '$new_pass1'
			WHERE 1 and user_id='$user_id' and pass='$old_pass' LIMIT 1";
		$qry=db_query($sql);
			
	}
	else
	{
$type=0;
$msg='Existing Password not matched';
	}
	}
	else
	{
$type=0;
$msg='Entered Password and Confirm Password not matched';
	}
	}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="right"><form id="form2" name="form2" method="post" action="">
    <div class="box">
	<table width="100%" align="center" id="table1" style="border-collapse:collapse">
      <tr>
        <td colspan="2" align="center" class="money1">Change Password</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">Old Passward : </td>
        <td ><input name="old_pass" type="password" id="old_pass" value="<?php echo $data[6];?>" size="25" maxlength="20" /></td>
      </tr>
      <tr>
        <td align="right">New Passward :</td>
        <td><label>
          <input name="new_pass1" type="password" id="new_pass1" value="<?php echo $data[7];?>" size="25" maxlength="20" class="required" />
        </label></td>
      </tr>
      <tr>
        <td align="right">Confirm New Passward :</td>
        <td><label>
          <input name="new_pass2" type="password" id="new_pass2" value="<?php echo $data[9];?>" size="25" maxlength="20" class="required" />
        </label></td>
      </tr>
    </table>
	</div>
    
    <div align="center">
      <input name="mproject" type="submit" id="mproject" value="Apply" class="btn" />
    </div>
  </form></div></td>
  </tr>
</table>
<?

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>