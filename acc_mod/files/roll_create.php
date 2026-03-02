<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#expire_date');

do_calander('#entry_date');

do_calander('#edit_date');





// ::::: Edit This Section ::::: 
$title='User Management';			// Page Name and Page Title
$page="user_manage.php";		// PHP File Name
$input_page="user_manage_input.php";
$root='admin';

$table='user_activity_management';		// Database Table Name Mainly related to this page
$unique='user_id';			// Primary Key of this Database table
$shown='username';				// For a New or Edit Data a must have data field
			// For a New or Edit Data a must have data field
			
			
			if($_GET['user_id']>0){
	 $access = $$unique = $_GET[$unique];
	}
elseif($_POST['user_id']>0){
	 $access = $$unique = $_POST[$unique];
	}
// ::::: End Edit Section :::::

if(isset($_POST['mod_add'])){

$modules_id=$_POST['module_id'];
echo $sql="insert into user_module_define(user_id,module_id,status)values('$user_id','$modules_id','enable')";
$query=db_query($sql);

}

if(isset($_POST['ware_add'])){

$warehouse_id=$_POST['warehouse_id'];
echo $sql="insert into warehouse_define(user_id,warehouse_id,status)values('$user_id','$warehouse_id','enable')";
$query=db_query($sql);

}




$crud      =new crud($table);


if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['new'])||isset($_POST['insertn']))
{		
$now				= time();

$$unique = $crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';




}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
				
}

$path="../../../files/user/pic";
$file=$_FILES["file"];
image_upload_on_id($path,$file,$$unique);
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		
		$type=1;
		$msg='Successfully Deleted.';
}
}

if($$unique>0)

{

		$condition=$unique."=".$$unique;

		echo $condition;

		$data=db_fetch_object($table,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

 

?>

 <script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }



	function access_update(id)



	{



var page_id=id; var user_id=<?=$user_id?>; // Rent

if((document.getElementById('access'+id).checked)==1)

var access=1; else var access=0;

if((document.getElementById('add'+id).checked)==1)

var add=1; else var add=0;

if((document.getElementById('edit'+id).checked)==1)

var edit=1; else var edit=0;

if((document.getElementById('delete'+id).checked)==1)

var delete1=1; else var delete1=0;







var strURL="roll_create_ajax.php?page_id="+page_id+"&access="+access+"&add="+add+"&edit="+edit+"&delete="+delete1+"&user_id="+user_id;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('pv'+id).style.display='inline';

						document.getElementById('pv'+id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}



</script>

<script type="text/javascript"> function DoNav(lk){

	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)

	}</script>

	<style type="text/css">

<!--

.style3 {color: #FFFFFF; font-weight: bold; }

-->

    </style>

	



<form action="" method="post" enctype="multipart/form-data">

<div class="oe_view_manager oe_view_manager_current">

        <? include('../../common/title_bar.php');?>

        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">







<div class="oe_form_sheetbg">





        <div class="oe_form_sheet oe_form_sheet_width">

	<table class="table table-bordered " border="0" cellpadding="0" cellspacing="0">

	<tbody>

	<tr class="oe_form_group_row">

    <td class="oe_form_group_cell"><table class="table" border="0" cellpadding="0" cellspacing="0"><tbody>

				

			

			   



                <tr class="oe_form_group_row">

                  <td width="24%" colspan="1" valign="middle" bgcolor="" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;User Name  :</td>

                  <td width="29%" colspan="1" valign="middle" bgcolor="" class="oe_form_group_cell">

            <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
            <input type="hidden" name="group_for" value="1">
            <input type="hidden" name="entry_date" value="<?=date('Y-m-d')?>">
          

<input  name="user_id2" type="hidden" id="user_id2" value="<?=$user_id?>"/>

            <input name="username" id="username" value="<?=$username?>" type="text" class="form-control" />				  </td>

                  <td width="19%" valign="middle" bgcolor="" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> &nbsp;&nbsp;Full Name :</span></         td>

                  <td width="28%" valign="middle" bgcolor="" class="oe_form_group_cell">

				    <input name="fname" type="text" id="fname" value="<?=$fname?>"  class="form-control"/>				  </td>

                </tr>

                <tr class="oe_form_group_row">

                  <td colspan="1" valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp; Password : </label></td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="password" type="password" id="password" value="<?=$password?>" class="form-control"/></td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell" style="padding-top:5px;">&nbsp;&nbsp;</span>Designation  : </span></td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="designation" type="text" id="designation" value="<?=$designation?>"  class="form-control"/></td>

                </tr>

                      <tr class="oe_form_group_row">

                  <td colspan="1" valign="middle" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Status : </label></td>

                  <td valign="middle" class="oe_form_group_cell">

				     <select name="status"id="status" required class="form-control">	

				    <option><?=$status?></option>

				  <option value="Active">Active</option>

				  <option value="Inactive">Inactive</option>

				   </select>				  </td>

                  <td valign="middle" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell" style="padding-top:5px;">&nbsp;&nbsp;</span>Level  : </span></td>

                  <td valign="middle" class="oe_form_group_cell">
                  <select name="level" id="level" class="form-control">
                    <option></option>
                    <? foreign_relation('user_type','user_level','user_type_name',$level)?>
                  </select>
                  </td>

                </tr>

				 <tr class="oe_form_group_row">

                  <td colspan="1" valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Expire Date : </label></td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell">

				     <input type="text" name="expire_date" id="expire_date" value="<?=$expire_date?>" class="form-control" />				  </td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell" style="padding-top:5px;">&nbsp;&nbsp;</span>Employee ID  : </span></td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell">

				  		   <input type="text" name="PBI_ID" id="PBI_ID" value="<?=$PBI_ID=$_GET['user_id'];?>"  class="form-control"/>				  </td>
						   

                </tr>
				<tr class="oe_form_group_row">
										     <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell">

				  		   <input type="file" name="file" id="file" value="" />				  </td>

				</tr>

		             <tr class="oe_form_group_row" style="margin-top:10px;">

		               <td colspan="4" bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>

		               </tr>

		             <tr class="oe_form_group_row" style="margin-top:10px;">

                  <style type="text/css">

				     .Update{

					 background:#a1a1a1;color:#fff;

					 }

					 .Save{

					 background:#dedede;color:#fff;

					 }

					 

 					</style>    



                   <td colspan="4" bgcolor="#E8E8E8" class="oe_form_group_cell"><center><? if($access>0){ ?>

<input name="update" type="submit" class="btn btn-success" value="Update" style="width:100px; font-weight:bold; font-size:12px;" />

<? } else {?>
<input name="new" type="submit" class="btn btn-primary" value="Save" style="width:100px; font-weight:bold; font-size:12px;" />
<? } ?>



<? if($access>0 || $user_id>0) { $btn_name='Delete User';?>

<input name="delete" id="delete"  onclick="return confirmation();"  type="submit" class="btn1" value="<?=$btn_name?>" style="width:100px;color:#A00000 ; font-weight:bold; font-size:12px;" />

<? }?>

				    </center>				  </td>

                </tr>

				 

              	  </tbody></table>

              <br /></td>

          </tr>

          </tbody></table>

		  	

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

	   

        	<? //if($access>0){
//
//echo $sql = 'select * from user_feature_manage';
//
//$query = db_query($sql);
//
//while($info = mysqli_fetch_object($query)){
//
//$sqls = 'select * from user_page_manage where feature_id = "'.$info->id.'"';
//
//$querys = db_query($sqls);
//
//$counts = mysqli_num_rows($querys);
//
//if($counts>0){

			?>
			
		
		
		
	

		
			
		





   	<? //}}} ?>

			

			

          </div></div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

    </div>

</form>


<form action="" method="post">
<table class="table table-bordered table-hover">
<h2>Module Access</h2>
<div class="row">
	
		<div id="bulkOptionContainer" class="col-xs-4">
		
							
	<select class="form-control" name="module_id" id="$post_id" style="padding-right:44px;">
		<option value=""></option>
						<?php 
					 $sql="select * from user_module_manage ";
							$query=db_query($sql);
							while($data=mysqli_fetch_assoc($query)){
							$module_id=$data['id'];
							$module_name=$data['module_name'];
							?>

		<option value="<?php echo $module_id;?>"><?php echo $module_name; ?></option>
		<?php } ?>
	</select>
</div>


<div class="col-xs-4">

	<input type="submit" class="btn btn-success" name="mod_add" value="Add" style="margin-left:21px;margin-top:4px;" />

</div>
</div><br /><br />

							<thead>
							<tr>
							<?=$users_id; ?>
								<th>Id</th>
								<th>Module Name</th>
								<th>Status</th>
							
								<th>Delete</th>
								</tr>
							</thead>
							
									<tbody>
									
						
					
							
							
							<?php 
						
							 $sql="select m.module_id,m.user_id,m.status,u.id,u.module_name from user_module_manage u,user_module_define m where m.user_id='".$user_id."' and m.module_id=u.id";
							$query=db_query($sql);
							while($data=mysqli_fetch_assoc($query)){
							$module_id=$data['module_id'];
							$module_name=$data['module_name'];
							$status=$data['status'];
						
						
				
							
							echo "<tr>";
					
							echo "<td>$module_id</td>";
							echo "<td>$module_name</td>";
							echo "<td>$status</td>";
							if($status=='enable'){
							echo "<td><button type='submit' class='btn btn-success' style='background:green;'><a onClick=\" javascript: return confirm('Are you sure you want to disable this?');  \"  href='roll_create.php?delete=$user_id&mod_id=$module_id' style='color:white;'>Make Disable</a></button></td>";
							}
							else{
							echo "<td><button type='submit' class='btn' style='background:red;'><a onClick=\" javascript: return confirm('Are you sure you want to enable this?');  \"  href='roll_create.php?enable=$user_id&mod_id=$module_id' style='color:white;'>Make Enable</a></button></td>";
							}
						
							echo "</tr>";
							
							
							}
					?>
				
						<?php 
						if(isset($_GET['delete'])){
						$status_id_delete=$_GET['delete'];
							$mod_id=$_GET['mod_id'];
						$sql="update user_module_define set status='disable' where user_id={$status_id_delete} and module_id=$mod_id";
						$query=db_query($sql);
						header("Location:roll_create.php?user_id=$status_id_delete");
						
						}
						?>
						<?php 
						if(isset($_GET['enable'])){
						$status_id_enable=$_GET['enable'];
								$mod_id=$_GET['mod_id'];
						$sql="update user_module_define set status='enable' where user_id={$status_id_enable} and module_id=$mod_id";
						$query=db_query($sql);
						header("Location:roll_create.php?user_id=$status_id_enable");
						
						}
						?>
							
							</tbody>


</table><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
</form>

<form action="" method="post">

<table class="table table-bordered table-hover">
<h2>Warehouse Access</h2>
<div class="row">
	
		<div id="bulkOptionContainer" class="col-xs-4">
		
							
	<select class="form-control" name="warehouse_id" id="$post_id" style="padding-right:44px;">
		<option value=""></option>
						<?php 
					 $sql="select * from warehouse ";
							$query=db_query($sql);
							while($data=mysqli_fetch_assoc($query)){
							$warehouse_id=$data['warehouse_id'];
							$warehouse_name=$data['warehouse_name'];
							?>

		<option value="<?php echo $warehouse_id;?>"><?php echo $warehouse_name; ?></option>
		<?php } ?>
	</select>
</div>


<div class="col-xs-4">

	<input type="submit" class="btn btn-success" name="ware_add" value="Add" style="margin-left:21px;margin-top:4px;" />

</div>
</div><br /><br />

							<thead>
							<tr>
						
								<th>Id</th>
								<th>warehouse Name</th>
								<th>Status</th>
							
								<th>Delete</th>
								</tr>
							</thead>
							
									<tbody>
									
						
					
							
							
							<?php 
						
							  $sql="select w.warehouse_id,w.user_id,w.status,wa.warehouse_id,wa.warehouse_name from warehouse wa,warehouse_define w where w.user_id='".$user_id."' and w.warehouse_id=wa.warehouse_id";
							$query=db_query($sql);
							while($data=mysqli_fetch_assoc($query)){
							$warehouse_id=$data['warehouse_id'];
							$warehouse_name=$data['warehouse_name'];
							$status=$data['status'];
						
						
				
							
							echo "<tr>";
					
							echo "<td>$warehouse_id</td>";
							echo "<td>$warehouse_name</td>";
							echo "<td>$status</td>";
							
							//echo "<td><a onClick=\" javascript: return confirm('Are you sure you want to disable this?');  \"  href='roll_create.php?disable=$user_id&ware_id=$warehouse_id'>Delete</a></td>";
						if($status=='enable'){
							echo "<td><button type='submit' class='btn btn-success' style='background:green;'><a onClick=\" javascript: return confirm('Are you sure you want to disable this?');  \"  href='roll_create.php?disable=$user_id&ware_id=$warehouse_id' style='color:white;'>Make Disable</a></button></td>";
							}
							else{
							echo "<td><button type='submit' class='btn' style='background:red;'><a onClick=\" javascript: return confirm('Are you sure you want to enable this?');  \"  href='roll_create.php?enable_w=$user_id&ware_id=$warehouse_id'style='color:white;'>Make Enable</a></button></td>";
							}
							
							echo "</tr>";
							
							
							}
					?>
				
						<?php 
						if(isset($_GET['disable'])){
						$warehouse_id_desable=$_GET['disable'];
						$warehouse_id_in=$_GET['ware_id'];
						$sql="update warehouse_define set status='disable' where user_id={$warehouse_id_desable} and warehouse_id=$warehouse_id_in";
						$query=db_query($sql);
						
						header("Location:roll_create.php?user_id=$warehouse_id_desable");
					
						}
						?>
						<?php 
						if(isset($_GET['enable_w'])){
						$warehouse_id_enable=$_GET['enable_w'];
						$warehouse_id_in=$_GET['ware_id'];
						$sql="update warehouse_define set status='enable' where user_id={$warehouse_id_enable} and warehouse_id=$warehouse_id_in";
						$query=db_query($sql);
						header("Location:roll_create.php?user_id=$warehouse_id_enable");
						
						}
						?>
							
							</tbody>


</table><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
</form>

<script type="text/javascript">

function confirmation()

{

var answer = confirm("Are you sure?")

 if (answer)

 {

  return true;

 } else {

  if (window.event) // True with IE, false with other browsers

  {

   window.event.returnValue=false; //IE specific

  } else {

   return false

  }

 }

}



</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>