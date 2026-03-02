<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Salary Head Configuare';

$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
if(isset($_REQUEST['basicamt']) || isset($_REQUEST['emp_id']))
{
$emp_id=$_REQUEST['emp_id'];
	//common part.............

$basicamt=$_POST['basicamt'];
$homerent=$_POST['homerent'];
$convence=$_POST['convence'];
$phone=$_POST['phone'];
$medical=$_POST['medical'];
$bonus=$_POST['bonus'];
$incometax=$_POST['incometax'];
$providentfund=$_POST['providentfund'];


	if(isset($_POST['update']))
	{
		$check=@db_query("delete from payroll_config where 1");

$sql="INSERT INTO payroll_config (basicamt,homerent,convence,phone,medical,bonus,incometax,providentfund)
VALUES ($basicamt, $homerent, $convence, $phone, $medical, $bonus, $incometax, $providentfund)";
			$query=db_query($sql);

	}
	


}
$sql=db_query('select * from payroll_config limit 1');
if(mysqli_num_rows($sql)>0)
$data=mysqli_fetch_object($sql);
?>
<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'salary_scale.php?emp_id='+theUrl;
}
function Do_Nav(field_name)
{
	var URL = 'pop_ledger_selecting_list.php?field_name='+field_name;
	popUp(URL);
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
    <td><div class="right"><form id="form1" name="form1" method="post" action="">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      

                                      <tr>
                                        <td>Basic Amount:</td>
                                        <td width="225" bordercolor="#666666">
										<input type="button" name="Button" value="Go" class="go" onclick="Do_Nav('basicamt')" />
										<input name="basicamt" type="text" id="basicamt" value="<?php echo $data->basicamt;?>" size="30" maxlength="100" />
										
										</td>
                                      </tr>
                                      <tr>
                                        <td>House Rent: </td>
                                        <td width="225" bordercolor="#666666">
										<input type="button" name="Button" value="Go" class="go" onclick="Do_Nav('homerent')" />
										<input name="homerent" type="text" id="homerent" value="<?php echo $data->homerent;?>" size="30" maxlength="100" />
										</td>
                                      </tr>
                                      <tr>
                                        <td>Convince:</td>
                                        <td width="225" bordercolor="#666666">
<input type="button" name="Button" value="Go" class="go" onclick="Do_Nav('convence')" />
										<input name="convence" type="text" id="convence" value="<?php echo $data->convence;?>" size="30" maxlength="100" />
										</td>
                                      </tr>
                                      <tr>
                                        <td>Mobile/Phone:</td>
                                        <td width="225" bordercolor="#666666">
<input type="button" name="Button" value="Go" class="go" onclick="Do_Nav('phone')" />
										<input name="phone" type="text" id="phone" value="<?php echo $data->phone;?>" size="30" maxlength="100" />
										</td>
                                      </tr>
                                      <tr>
                                        <td>Medical Allowance:</td>
                                        <td width="225" bordercolor="#666666">
										<input type="button" name="Button" value="Go" class="go" onclick="Do_Nav('medical')" />
										<input name="medical" type="text" id="medical" value="<?php echo $data->medical;?>" size="30" maxlength="100" />
										</td>
                                      </tr>
                                      <tr>
                                        <td>Bonus:</td>
                                        <td bordercolor="#666666">
										<input type="button" name="Button" value="Go" class="go" onclick="Do_Nav('bonus')" />
										<input name="bonus" type="text" id="bonus" value="<?php echo $data->bonus;?>" size="30" maxlength="100" />
										</td>
                                      </tr>
                                      <tr>
                                        <td>Income Tax:</td>
                                        <td width="225" bordercolor="#666666">
										<input type="button" name="Button" value="Go" class="go" onclick="Do_Nav('incometax')" />
										<input name="incometax" type="text" id="incometax" value="<?php echo $data->incometax;?>" size="30" maxlength="100" />
										</td>
                                      </tr>
                                      <tr>
                                        <td>Provident Fund: </td>
                                        <td width="225" bordercolor="#666666">
										<input type="button" name="Button" value="Go" class="go" onclick="Do_Nav('providentfund')" />
										<input name="providentfund" type="text" id="providentfund" value="<?php echo $data->providentfund;?>" size="30" maxlength="100" />
										</td>
                                      </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td align="center"><input name="update" type="submit" id="update" value="Update" class="btn" /></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>12
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