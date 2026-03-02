<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

 $tr_type="Show";
 



// ::::: Edit This Section ::::: 



$title='Voucher Entry Configuration';			// Page Name and Page Title

//do_datatable('table_head');

$page="voucher_config.php";		// PHP File Name



$table='voucher_config';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='voucher_type';				// For a New or Edit Data a must have data field



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

		$_POST['entry_by'] = $_SESSION['user']['id'];
		 
		 $_POST['entry_at'] = $now=date('Y-m-d H:i:s');	

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();

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
$tr_type="Add";
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
    $tr_type="Edit";

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

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-7 p-0 pr-2">
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
                <table  id="table_head" class="table table-bordered table-striped table-hover table-sm" cellspacing="0">
					<thead>
						<tr class="bgc-info">
						 	 <th><span>ID</span></th>
						
							<th><span>Voucher Type  </span></th>
						
							<th><span>Secondary Approval</span></th>
							<th><span>Final Approval </span></th>
						</tr>
					</thead>
					
					<tbody>
					
					<?php
					
					
					if($_POST['group_for']!="")
					
					$con .= 'and a.group_for="'.$_POST['group_for'].'"';
					
					
					
					if($_POST['category_name']!="")
					
					$con .='and a.category_name like "%'.$_POST['category_name'].'%" ';
					
					
					
					
					
					 $td='select a.'.$unique.',  a.'.$shown.' ,   a.direct_journal, a.secondary_approval from '.$table.' a	where  1  '.$con.' order by a.id  ';
					
					$report=db_query($td);
					
					while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
					
					<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
					  <td><?=$rp[0];?></td>
					
					<td><?=$rp[1];?></td>
					
					<td><?=$rp[3];?></td>
					<td><?=$rp[2];?></td>
					</tr>
					
					<?php }?>
					</tbody>
					</table>
					
					<? //}?>

									<div id="pageNavPosition"></div>
            </div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
            
            <form id="form1" name="form1" class="n-form  setup-fixed" method="post" action="">
                <h4 align="center" class="n-form-titel1"><?=$title?> </h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label "> Voucher Type</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        <input name="voucher_type" required type="text" id="voucher_type" tabindex="1"  class="form-control" value="<?=$voucher_type?>"  >	


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Secondary Approval</label>
                    <div class="col-sm-9 p-0">
                        <select name="secondary_approval" id="secondary_approval" class="form-control" >

                                 <option value="<?=$secondary_approval?>"><?=$secondary_approval?></option>

                                  <option value="Yes">Yes</option>

                                  <option value="No">No</option>


                         </select>

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Final Approval</label>
                    <div class="col-sm-9 p-0">

                        <select name="direct_journal" id="direct_journal" class="form-control">

                                <option value="<?=$direct_journal?>"><?=$direct_journal?></option>

                                <option value="Yes">Yes</option>

                                <option value="No">No</option>


                         </select>

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

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  

								   <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">ID</span></th>

<th bgcolor="#45777B"><span class="style3">Voucher Type  </span></th>

<th bgcolor="#45777B"><span class="style3">Secondary Approval</span></th>
<th bgcolor="#45777B"><span class="style3">Final Approval </span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['category_name']!="")

$con .='and a.category_name like "%'.$_POST['category_name'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.' ,   a.direct_journal, a.secondary_approval from '.$table.' a	where  1  '.$con.' order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td><?=$rp[1];?></td>

<td><?=$rp[3];?></td>
<td><?=$rp[2];?></td>
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

                                     <td><span class="style1" style="padding-top:5px;">*</span>Voucher Type  :</td>

                                        <td>
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        				<input name="voucher_type" required type="text" id="voucher_type" tabindex="1"  class="form-control" value="<?=$voucher_type?>"  >	
										 
										
										</td>
                                      </tr>
									  
									  
									  
									  <tr>

                                        <td>Secondary Approval:</td>

                                        <td><select name="secondary_approval" id="secondary_approval" class="form-control" >

                                          <option value="<?=$secondary_approval?>"><?=$secondary_approval?></option>

                                          <option value="Yes">Yes</option>

                                          <option value="No">No</option>


                                        </select></td>

                                      </tr>
									  
									  
									  
									  

                                      

                                      
									  
									  <tr>

                                        <td>Final Approval:</td>

                                        <td><select name="direct_journal" id="direct_journal" class="form-control">

                                          <option value="<?=$direct_journal?>"><?=$direct_journal?></option>

                                          <option value="Yes">Yes</option>

                                          <option value="No">No</option>


                                        </select></td>

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
$page_name='Voucher Entry Configuration';	
require_once SERVER_CORE."routing/layout.bottom.php";

?>