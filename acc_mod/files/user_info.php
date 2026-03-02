<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='User Information';			// Page Name and Page Title

do_datatable('table_head');

$page="user_info.php";		// PHP File Name



$table='user_activity_management';		// Database Table Name Mainly related to this page

$unique='user_id';			// Primary Key of this Database table

$shown='username';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];

//for Insert..................................

if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();

		$id = $_POST['user_id'];
		
		if($_FILES['user_pic']['tmp_name']!=''){ 
		$file_temp = $_FILES['user_pic']['tmp_name'];
		$folder = "../../../images/user/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}


		
		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['np']['tmp_name']!=''){ 
		$file_temp = $_FILES['np']['tmp_name'];
		$folder = "../../np_pic/np/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['spp']['tmp_name']!=''){ 
		$file_temp = $_FILES['spp']['tmp_name'];
		$folder = "../../spp_pic/spp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['nsp']['tmp_name']!=''){ 
		$file_temp = $_FILES['nsp']['tmp_name'];
		$folder = "../../nsp_pic/nsp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{


		$_POST['edit_by'] = $_SESSION['user']['id'];
		 
		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');



		$crud->update($unique);

		$id = $_POST['user_id'];



		if($_FILES['user_pic']['tmp_name']!=''){ 
		$file_temp = $_FILES['user_pic']['tmp_name'];
		$folder = "../../../images/user/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}


		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['np']['tmp_name']!=''){ 
		$file_temp = $_FILES['np']['tmp_name'];
		$folder = "../../np_pic/np/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['spp']['tmp_name']!=''){ 
		$file_temp = $_FILES['spp']['tmp_name'];
		$folder = "../../spp_pic/spp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['nsp']['tmp_name']!=''){ 
		$file_temp = $_FILES['nsp']['tmp_name'];
		$folder = "../../nsp_pic/nsp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		
		
		 

		$type=1;

		$msg='Successfully Updated.';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

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

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

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

	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;

}

function popUp(URL) 

{

	day = new Date();

	id = day.getTime();

	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
	font-weight: bold;
	color: #000000;
	font-size: 14px;
}
.style3 {color: #FFFFFF}

-->

</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Company:                                       </td>

                                        <td width="60%" align="right">

										<select name="group_for" required id="group_for" class="form-control" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select>
										
										</td>

                                      </tr>
									  
									  
									  <tr>

                                        <td width="40%" align="right">

		    Warehouse:                                       </td>

                                        <td width="60%" align="right">

										<select name="warehouse_id"  id="warehouse_id" class="form-control" tabindex="7">
										
										<option></option>

                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');?>
                    </select>
										
										</td>

                                      </tr>
									
									
									

                                      

                                      

                                      <!--<tr>

                                        <td align="right"> User:                                         </td>

                                        <td align="right"><input name="username" type="text" id="username" style="width:250px; float:left;" value="<?php echo $_POST['username']; ?>" size="20" /></td>

                                      </tr>-->

                                      <tr>

                                        <td colspan="2"><div align="center">
                                          <input class="btn btn-primary" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn btn-success" name="cancel" type="submit" id="cancel" value="Cancel" />
                                        </div></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td>&nbsp;</td>

								  </tr> <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">User ID</span></th>

  <th bgcolor="#45777B"><span class="style3">User</span></th>

  <th bgcolor="#45777B"><span class="style3">User Name </span></th>
<th bgcolor="#45777B"><span class="style3">Warehouse</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['warehouse_id']!="")

$con .= 'and a.warehouse_id="'.$_POST['warehouse_id'].'"';



//if($_POST['username']!="")

//$con .='and a.username like "%'.$_POST['username'].'%" ';





  $td='select a.'.$unique.',  a.'.$shown.' ,  a.fname, w.warehouse_name from '.$table.' a, user_group u, warehouse w	where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'" and a.warehouse_id=w.warehouse_id   '.$con.' order by a.user_id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td><?=$rp[1];?></td>

<td><?=$rp[2];?></td>
<td><?=$rp[3];?></td>
</tr>

<?php }?>
</tbody>
</table>

<? //}?>

									<div id="pageNavPosition"></div>									</td>

								  </tr>

		</table>



	</div></td>

    <td valign="top" width="40%"><div class="right">   <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box style2" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      

									  

									  <tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>User Name:</td>

                                        <td>
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="user_id" type="hidden" id="user_id" tabindex="1" value="<?=$user_id?>" readonly>
                        				<input name="username" required type="text" id="username" tabindex="1" value="<?=$username?>"  class="form-control" >	
										
										
										</td>
                                      </tr>
									  
									  
									  <tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>Password:</td>

                                        <td>
										
                        				<input name="password" required type="password" id="password" tabindex="1" value="<?=$password?>"  class="form-control" >	
										
										<input name="level" required type="hidden" id="level" tabindex="2" value="5" class="form-control">
										
										
										</td>
                                      </tr>
									  
									  
									  <!--<tr>

                                        <td>User Type:</td>

                                        <td>
										
										<select name="level" required id="level" style=" width:250px" tabindex="7">
										<option></option>

                      <? foreign_relation('user_type','user_level','user_type_name',$level,'1');?>
                    </select></td>
                                      </tr>-->
									  
									  <td>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for" class="form-control" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select></td>
									  
									  
									  
									  

                                      <tr>
									  
									  
									  <td><span class="style1" style="padding-top:5px;">*</span>Warehouse:</td>

                                        <td>
										
										<select name="warehouse_id" required id="warehouse_id" class="form-control" tabindex="7">
										
										<option></option>

                     <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1');?>
                    </select></td>
					
					</tr>
					
					
					<tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Full Name:</td>

                                        <td>

                                        <input name="fname" required type="text" id="fname" tabindex="2" value="<?=$fname?>" class="form-control"></td>
									  </tr>
									  
					
					
									<tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Designation:</td>

                                        <td>

                                        <input name="designation" required type="text" id="designation" tabindex="2" value="<?=$designation?>" class="form-control"></td>
									  </tr>
									  
									  
									  
				
									  

                                      <tr>

                                        <td>Mobile:</td>

                                        <td><input name="mobile" type="text" id="mobile" tabindex="8" value="<?=$mobile?>" class="form-control"/></td>
                                      </tr>

                                      <tr>

                                        <td>E-mail:</td>

                                        <td><input name="email" type="text" id="email" tabindex="8" value="<?=$email?>" class="form-control">
						
						
						<? $_POST['entry_by'] = $_SESSION['user']['id'];?>
						
						 <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_POST['entry_by'];?>" class="form-control" />
						 <input name="entry_at" type="hidden" required id="entry_at" tabindex="10" value="<?=$now=date('Y-m-d H:i:s');?>" class="form-control" />
						 </td>
                                      </tr>
									  
									  



                                      
									  
									  
									  
									  
									  
									 

                                      

                                      <tr>

                                        
                                      </tr>
									  
									  
									  <tr>

                                        <td> User Pic:</td>

                                        <td><input class="form-control" name="user_pic" type="file" id="user_pic" value="<?=$user_pic?>"  /></td>
                                      </tr>
									  
									  
             

                                      

									
									  

                                      

                                      
									  

                                    

                                      

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>
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
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn btn-primary" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn btn-success" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn btn-success" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
                    </div></td>
                  <td>
                  <!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->                    </td>
                </tr>
							        </table>
								  </div>								  </td>
                                </tr>
                              </table>

    </form>

							</div></td>

  </tr>

</table>

<script type="text/javascript"><!--

    var pager = new Pager('grp', 10000);

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




<script>


function duplicate(){

var dealer_code_2 = ((document.getElementById('dealer_code_2').value)*1);

var customer_id = ((document.getElementById('customer_id').value)*1);



   if(dealer_code_2>0)
  {
  
alert('This customer code already exists.');
document.getElementById('customer_id').value='';


document.getElementById('customer_id').focus();

  } 



}

</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>