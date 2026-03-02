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
	$get_module_id=$_GET['module_id'];		
// ::::: End Edit Section :::::


if($_GET['user_id']>0){
	 $access = $_GET['user_id'];
	}

$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['new'])||isset($_POST['insertn']))
{		
$now				= time();

$check = $crud->insert();
$type=1;
if($check){
	 $access = 1;
	}
$msg='New Entry Successfully Inserted.';

if(isset($_POST['insert']))
{
/*echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';*/
}
unset($_POST);
unset($$unique);


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

if($access>0)

{

		$condition=$unique."=".$access;

		//echo $condition;

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

	

	 

<!--<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <style type="text/css">



.style3 {color: #FFFFFF; font-weight: bold; }



    </style>
</head>-->





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

	<table class="table table-bordered  " border="0" cellpadding="0" cellspacing="0">

	<tbody>

	<tr class="oe_form_group_row">

    <td class="oe_form_group_cell"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody>

				

			

			   



                <tr class="oe_form_group_row">

                  <td width="24%" colspan="1" valign="middle" bgcolor="" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;User Name  :</td>

                  <td width="29%" colspan="1" valign="middle" bgcolor="" class="oe_form_group_cell">

            <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
            <input type="hidden" name="group_for" value="1">
            <input type="hidden" name="entry_date" value="<?=date('Y-m-d')?>">
            <input  name="id" type="hidden" id="id" value="<? if($_SESSION['user_id']>0) echo $_SESSION['user_id']; else echo find_a_field('user_activity_management','max(user_id)+1','1');?>" readonly/>

<input  name="user_id2" type="hidden" id="user_id2" value="<?=$user_id?>"/>

            <input name="username" id="username" value="<?=$username?>" type="text" class="form-control" />				  </td>

                  <td width="19%" valign="middle" bgcolor="" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> &nbsp;&nbsp;Full Name :</span></td>

                  <td width="28%" valign="middle" bgcolor="" class="oe_form_group_cell">

				    <input name="fname" type="text" id="fname" value="<?=$fname?>" class="form-control" />				  </td>

                </tr>

                <tr class="oe_form_group_row">

                  <td colspan="1" valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp; Password : </label></td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="password" type="password" id="password" value="<?=$password?>" class="form-control"/></td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell" style="padding-top:5px;">&nbsp;&nbsp;</span>Designation  : </span></td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="designation" type="text" id="designation" value="<?=$designation?>" class="form-control" /></td>

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

				     <input type="text" name="expire_date" id="expire_date" value="<?=$expire_date?>"  class="form-control"/>				  </td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell" style="padding-top:5px;">&nbsp;&nbsp;</span>Employee ID  : </span></td>

                  <td valign="middle" bgcolor="#E8E8E8" class="oe_form_group_cell">

				  		   <input type="text" name="PBI_ID" id="PBI_ID" value="<?=$PBI_ID=$_GET['user_id'];?>" class="form-control" />				  </td>
						   

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

<input name="delete" id="delete"  onclick="return confirmation();"  type="submit" class="btn btn-primary" value="<?=$btn_name?>" style="width:100px;color:#A00000 ; font-weight:bold; font-size:12px;" />

<? }?>

				    </center>				  </td>

                </tr>

				 

              	  </tbody></table>

              <br /></td>

          </tr>

          </tbody></table>

		  	
<div class="container">

  <ul class="nav nav-tabs">
  <?php
  $sql_mod="select m.user_id,m.module_id,m.status,u.id,u.module_name from user_module_define m,user_module_manage u where m.user_id= '".$user_id."' and m.module_id=u.id and m.status='enable'";
  $que=db_query($sql_mod);
  while($mod=mysqli_fetch_assoc($que)){
  $module_id=$mod['module_id'];
  $module_name=$mod['module_name'];
  
   ?>
   
   <?php if($module_id==$get_module_id){ ?>

    <li class="active" style="margin-top:37px;"><a href="roll_create_assign.php?user_id=<?php echo $user_id; ?>&module_id=<?php echo $module_id; ?> " style="background-color:green;padding:15px;color:white;margin-right:10px;text-decoration:none;"><?=$module_name;?></a></li>
<?php } else { ?>
 <li class="active" style="margin-top:37px;"><a href="roll_create_assign.php?user_id=<?php echo $user_id; ?>&module_id=<?php echo $module_id; ?>  " style="background-color:#ddd;color:black;padding:15px;margin-right:10px;text-decoration:none;"><?=$module_name;?></a></li>
 <?php }} ?>
  </ul>
</div>
<br /><br />


          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

	   

        	<? if($access>0){

  $sql = 'select u.*,m.* from user_feature_manage u,user_module_define m where m.user_id="'.$user_id.'" and m.module_id=u.module_id and m.status="enable" and m.module_id="'.$get_module_id.'"';

$query = db_query($sql);

while($info = mysqli_fetch_object($query)){

$sqls = 'select * from user_page_manage where feature_id = "'.$info->id.'"';

$querys = db_query($sqls);

$counts = mysqli_num_rows($querys);

if($counts>0){

			?>
			
			

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td height="25" bgcolor="#003366" ><span class="style3" style="color:white!important;">&nbsp;&nbsp;<?=$info->feature_name?></span></td>

    <td width="8%" bgcolor="#003366"><div align="center"><span class="style3"  style="color:white!important;"><strong>Access</strong></span></div></td>

    <td width="8%" bgcolor="#003366"><div align="center"><span class="style3">Add</span></div></td>

    <td width="8%" bgcolor="#003366"><div align="center"><span class="style3">Edit</span></div></td>

    <td width="8%" bgcolor="#003366"><div align="center"><span class="style3">Delete</span></div></td>

    <td width="8%" bgcolor="#003366">&nbsp;</td>

    </tr>

<?



while($infos = mysqli_fetch_object($querys)){

$find = find_all_field('user_roll_activity','','user_id="'.$user_id.'" and page_id="'.$infos->id.'"');

?>

<tr  <? if((++$i%2)==0) echo 'bgcolor="#99FFCC"'; else echo 'bgcolor="#C1F0FF"';?>>

<td height="25" valign="middle">&nbsp;&nbsp;- <?=$infos->page_name?> </td>

<td valign="middle"><div align="center">

<input type="checkbox"  name="access<?=$infos->id?>" id="access<?=$infos->id?>" value="1" style="width:10px;" <?=($find->access>0)?'checked="checked";':'';?> />

</div></td>

<td valign="middle"><div align="center">

<input type="checkbox"  name="add<?=$infos->id?>" id="add<?=$infos->id?>" value="1" style="width:10px;" <?=($find->add>0)?'checked="checked";':'';?>/>

</div></td>

<td valign="middle"><div align="center">

<input type="checkbox"  name="edit<?=$infos->id?>" id="edit<?=$infos->id?>" value="1" style="width:10px;" <?=($find->edit>0)?'checked="checked";':'';?>/>

</div></td>

<td valign="middle"><div align="center">

  <input type="checkbox"  name="delete<?=$infos->id?>" id="delete<?=$infos->id?>" value="1" style="width:10px;" <?=($find->delete>0)?'checked="checked";':'';?>/>

</div></td>

<td valign="middle"><label>

<div id="pv<?=$infos->id?>">

  <input type="button" name="Submit" value="OK" style="width:50px; height:25px;" onclick="access_update(<?=$infos->id?>)" /></div>

</label></td>

</tr>

<? }?>

</table>



   	<? }}} ?>

			

			

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