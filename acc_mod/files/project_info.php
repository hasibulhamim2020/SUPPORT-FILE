<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Project Information';
$active='projin';
if(isset($_REQUEST['proj_id'])||isset($_REQUEST['proj_name']))
{
$proj_id		= mysqli_real_escape_string($_SESSION['proj_id']);
if($_FILES['logo']['size']>0)
{
$root='../../../logo/'.$proj_id.'.png';
move_uploaded_file($_FILES['logo']['tmp_name'],$root);
}
	//common part.............

	$proj_name				= mysqli_real_escape_string($_REQUEST['proj_name']);
	$proj_address			= mysqli_real_escape_string($_REQUEST['proj_address']);
	$proj_phone				= mysqli_real_escape_string($_REQUEST['proj_phone']);
	$proj_fax				= mysqli_real_escape_string($_REQUEST['proj_fax']);
	$proj_email				= mysqli_real_escape_string($_REQUEST['proj_email']);
	$proj_url				= mysqli_real_escape_string($_REQUEST['proj_url']);
	$proj_type				= mysqli_real_escape_string($_REQUEST['proj_type']);
	$proj_password			= mysqli_real_escape_string($_REQUEST['proj_password']);
	$company_name			= mysqli_real_escape_string($_REQUEST['company_name']);
	$voucher_mode			= mysqli_real_escape_string($_REQUEST['voucher_mode']);
	$voucher_mode_type		= mysqli_real_escape_string($_REQUEST['voucher_mode_type']);
	$ledger_id_separator	= mysqli_real_escape_string($_REQUEST['ledger_id_separator']);
	//for Modify..................................
	
	if(isset($_REQUEST['mgroup']))
	{
		$sql="UPDATE `project_info` SET 
			`proj_name` = '$proj_name',
			`proj_address` = '$proj_address',
			`proj_phone` = '$proj_phone',
			`proj_fax` = '$proj_fax',
			`proj_email` = '$proj_email',
			`proj_url` = '$proj_url',
			`proj_type` = '$proj_type',
			`proj_password` = '$proj_password',
			`voucher_mode` = '$voucher_mode',
			`voucher_entry_mode` = '$voucher_mode_type',
			`ledger_id_separator` = '$ledger_id_separator',
			`company_name`='$company_name' LIMIT 1";
		$qry=db_query($sql);
		$type=1;
		$msg='Successfully Updated.';
	}
	
}
$data=mysqli_fetch_row(db_query("select * from project_info limit 1"));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr colspan="2">
    <td>&nbsp;</td>
    <td><form action="project_info.php?proj_id=<?php echo $data[0];?>" method="post" enctype="multipart/form-data" name="form2" id="form2">
						    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="2"><div class="box">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr >
                                      <td width="10%"><div align="right">Project Name: </div></td>
                                      <td width="19%" "><div >
                                        <input name="proj_name"   type="text" id="proj_name" value="<?php echo $data[1];?>" size="25" style="max-width:310px;" class="required form-control" minlength="2" />
                                      </div></td>
								    </tr>

                                    <tr>
                                      <td><div align="right">Address: </div></td>
                                      <td ><div align="center">
                                        <textarea name="proj_address" cols="30" style="max-width:250px;" id="proj_address" class="required class="form-control"" minlength="2"><?php echo $data[2];?></textarea>
                                      </div></td>
								    </tr>
                                    <tr>
                                      <td><div align="right">Contact No:</div></td>
                                      <td ><div >
                                        <input name="proj_phone" class="form-control" type="text" id="proj_phone" value="<?php echo $data[3];?>" size="25" style="max-width:310px;" />
                                      </div></td>
								    </tr>
                                    <tr>
                                      <td><div align="right">Fax No: </div></td>
                                      <td ><div >
                                        <input name="proj_fax" class="form-control" type="text" id="proj_fax" value="<?php echo $data[4];?>" size="25" style="max-width:310px;" />
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <td><div align="right">Email Address: </div></td>
                                      <td ><div >
                                        <input name="proj_email" class="form-control" type="text" id="proj_email" value="<?php echo $data[5];?>" size="25" style="max-width:310px;" />
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <td><div align="right">Project URL:</div></td>
                                      <td ><div >
                                        <input name="proj_url" type="text" class="form-control" id="proj_url" value="<?php echo $data[6];?>" size="25" style="max-width:310px;" />
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <td><div align="right">Project Type:</div></td>
                                      <td ><div >
                                        <input name="proj_type" type="text" class="form-control" id="proj_type" value="<?php echo $data[7];?>" size="25" style="max-width:310px;" />
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <td><div align="right">Company Name: </div></td>
                                      <td ><div >
                                        <input name="company_name" type="text" class="form-control" id="company_name" value="<?php echo $data[9];?>" size="30" style="max-width:310px;" />
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <td><div align="right">Voucher Mode: </div></td>
                                      <td ><div >
                                        <select name="voucher_mode" id="voucher_mode" class="form-control" style="max-width:310px;">
                                          <option <? if($data[11]==1) echo 'selected';?> value="1">AUTO</option>
                                          <option <? if($data[11]==0) echo 'selected';?> value="0">MANUAL</option>
                                        </select>
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <td><div align="right">Voucher Entry Mode: </div></td>
                                      <td ><div >
                                        <select name="voucher_mode_type" id="voucher_mode_type" class="form-control" style="max-width:310px;">
                                          <option <? if($data[12]==2) echo 'selected';?> value="2">ID Based</option>
                                          <option <? if($data[12]==1) echo 'selected';?> value="1">Name Based</option>
                                        </select>
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <td><div align="right">Ledger ID Separator:</div></td>
                                      <td ><div >
                                        <input name="ledger_id_separator" type="text" class="form-control" id="ledger_id_separator" value="<?php echo $data[13];?>" size="10" style="max-width:310px;" />
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <td><div align="right">Logo    : </div></td>
                                      <td ><div >
                                        <input name="logo" type="file" id="logo" class="form-control" style="max-width:310px;" />
                                      </div></td>
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
                                      <td width="65%" class="text-center form-control"><input name="mgroup" style="max-width:310px;" type="submit" id="mgroup" value="Modify" class="btn"/></td>
                                      <td width="35%">&nbsp;</td>
                                    </tr>
                                  </table>
							    </div>								  </td>
                              </tr>
                            </table>
    </form></td>
  </tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>