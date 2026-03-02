<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Change Password';


if(isset($_POST['ok']))
{
                         $id=$_SESSION['user']['id'];
                         $name=$_POST['name'];
                         $old_pass=$_POST['old_pass'];
						 $new_pass=$_POST['new_pass'];  
                         $con_pass=$_POST['con_pass'];
						 						 
                 if($new_pass==$con_pass )
				 {

                       $sql="UPDATE `user_activity_management` SET 
						`password` = '$new_pass'
						 WHERE `user_id` = $id and `password`='$old_pass'";
						 
                        //echo $sql;
                        $query=db_query($sql);
						$msg='New Entry Successfully Inserted.';
               }
			   
			   else
			     {
			     echo "Password and confirm password are not matched";
                }
        
}


?>
<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'ledger_account2_report.php?g_id='+theUrl;
}
</script>
<table style="width:100%; border-collapse:collapse; padding:0;">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box" ><form id="form1" name="form1" method="post" action="" ><table style="width:50%; border-collapse:separate; margin:0 auto; border-spacing:2px 0;" >
                                      
                                      
                                      
                                      <tr>
                                        <td  style="width:40%; text-align:right;">Old Password: </td>
                                        <td  style="width:60%; text-align:right"><input name="old_pass" id="old_pass" type="text" /></td>
                                      </tr>
                                      
                                      
                                      <tr>
                                        <td style="text-align:right;">New Password: </td>
                                        <td style="text-align:right;"><input name="new_pass" id="new_pass" type="text" /></td>
                                      </tr>
                                      
                                      <tr>
                                        <td style="text-align:right;">Confirm Pass: </td>
                                        <td style="text-align:right;"><input name="con_pass" id="con_pass" type="text" /></td>
                                      </tr>
                                      
                                      <tr>
                                        <td>&nbsp;</td>
										<td>
										<table style="width:20%; border:0; border-collapse:collapse; padding:0; text-align:left;">
											  <tr>
											    <td><input class="btn"  type="submit" name="ok" id="ok" value="SUBMIT" /></td>
												<td>&nbsp;</td>
											  </tr>
											</table></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
									<div id="pageNavPosition"></div>									</td>
								  </tr>
		</table>

							</div></td>
    
  </tr>
</table>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>