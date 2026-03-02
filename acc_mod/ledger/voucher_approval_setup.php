<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 



$title='Voucher Approval Setup';			// Page Name and Page Title

do_datatable('table_head');

$page="voucher_approval_setup.php";		// PHP File Name

$table='voucher_approval_matrix';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='voucher_mod';				// For a New or Edit Data a must have data field

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

$id = $_POST['dealer_code'];
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

		$id = $_POST['dealer_code'];



		if($_FILES['cr_upload']['tmp_name']!=''){ 
		$file_temp = $_FILES['cr_upload']['tmp_name'];
		$folder = "../../images/cr_pic/";
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




<div class="container-fluid">
    <div class="row">
        <div class="col-sm-7">
            <!--<div class="container p-0">
                <form id="form1" name="form1" class="n-form1" method="post" action="">


                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Input field Name</label>
                        <div class="col-sm-9 p-0">
                             input field PhP code type hear

                        </div>
                    </div>

                    <div class="n-form-btn-class">
                        <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                        <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear" />
                    </div>

                </form>
            </div>-->


            <div class="container n-form1">
			
							<?
				
				//if(isset($_POST['search'])){
				
				?>
				
				<table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
				<thead>
				<tr class="bgc-info">
				  <th><span>ID</span></th>
				
				<th><span>Voucher Mod</span></th>
				<th><span>Priority</span></th>
				<th><span>Approver</span></th>
				
				</tr>
				</thead>
				
				<tbody>
				
				<?php
				
				
				if($_POST['group_for']!="")
				
				$con .= 'and a.group_for="'.$_POST['group_for'].'"';
				
				
				
				if($_POST['warehouse_name']!="")
				
				$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';
				
				
				
				
				
				 $td='select a.'.$unique.',  a.'.$shown.',a.priority,u.fname from '.$table.' a,user_activity_management u where u.user_id=a.approver_id '.$con.' order by a.id  ';
				
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

				<div id="pageNavPosition"></div>	


            </div>

        </div>


        <div class="col-sm-5">
            
            <form class="n-form"  action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Voucher Mod</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        <select name="voucher_mod" id="voucher_mod" class="form-control">
						<option></option>
						<option <?=($voucher_mod=='Payment')?'selected':''?>>Payment</option>
						<option <?=($voucher_mod=='Receipt')?'selected':''?>>Receipt</option>
						<option <?=($voucher_mod=='Journal')?'selected':''?>>Journal</option>
						<option <?=($voucher_mod=='Contra')?'selected':''?>>Contra</option>
						</select>


                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Approver</label>
                    <div class="col-sm-9 p-0">
                        <select name="approver_id" id="approver_id" class="form-control">
						<option></option>
		                 <? foreign_relation('user_activity_management','user_id','fname',$approver_id,'1 order by fname asc')?>
						</select>


                    </div>
                </div>
				
				
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Priority</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="priority" id="priority" class="form-control" value="<?=$priority?>">
						


                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Signatory</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="signatory" id="signatory" class="form-control" value="<?=$signatory?>">


                    </div>
                </div>
				

                <div class="n-form-btn-class">
                   <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }?>
                   
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>
                    
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
                   

                </div>


            </form>

        </div>

    </div>




</div>




<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%">
	<div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

									<td>&nbsp;</td>

								  </tr> <tr>

									<td>

<?

if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">ID</span></th>

<th bgcolor="#45777B"><span class="style3">Accounts Class </span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.' from '.$table.' a where 1  '.$con.' order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td><?=$rp[1];?></td>
</tr>

<?php }?>
</tbody>
</table>

<? }?>

<div id="pageNavPosition"></div>									
									
									</td>

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

                                     <td><span class="style1" style="padding-top:5px;">*</span>Accounts Class:</td>

                                        <td>
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        				<input name="class_name" required type="text" id="class_name" tabindex="1" value="<?=$class_name?>"  style="width:220px;" >	
										
										
										</td>
                                      </tr>
									  
		
                                      <!--<tr>

                                        <td>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for"  tabindex="7" style="width:220px;">

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select></td>
                                      </tr>-->
									  
									 <!-- <tr>

                                        <td>Status:</td>

                                        <td><select name="status" id="status"  style="width:250px;">

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="Active">Active</option>

                                          <option value="Inactive">Inactive</option>


                                        </select></td>

                                      </tr>
             -->

                                      

									
									  

                                      

                                      
									  

                                    

                                      

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
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
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

</table><?php */?>

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



require_once SERVER_CORE."routing/layout.bottom.php";

?>