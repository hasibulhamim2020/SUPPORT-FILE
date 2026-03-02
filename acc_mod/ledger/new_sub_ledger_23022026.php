<?php
session_start();
ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

 $tr_type="Show";



//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// ::::: Edit This Section ::::: 



$title='Sub Ledger';			// Page Name and Page Title

do_datatable('table_head');

$page="new_sub_ledger.php";		// PHP File Name

$table='general_sub_ledger';		// Database Table Name Mainly related to this page

$unique='sub_ledger_id';			// Primary Key of this Database table

$shown='sub_ledger_name';				// For a New or Edit Data a must have data field

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

$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$type = $_POST['type'];

//$_POST['tr_from'] = 'custom';
$pre_sub_ledger = find_a_field('general_sub_ledger','max(sub_ledger_id)','tr_from="custom" and type="'.$type.'"');



if($pre_sub_ledger>0){
$sub_ledger_id=$pre_sub_ledger+1;
}else{
		if($type=='Cash In Hand'){
			$sub_ledger_id = 70000001;
			}elseif($type=='Cash at Bank'){
				$sub_ledger_id = 80000001;
				}elseif($type=='Brokerage And Commission'){
				$sub_ledger_id = 90000001;
				}elseif($type=='Share Capital'){
				$sub_ledger_id = 11000001;
				}elseif($type=='Bank Overdraft'){
				$sub_ledger_id = 12000001;
				}elseif($type=='Employee'){
				$sub_ledger_id = 14000001;
				}elseif($type=='Loan From Director and Others'){
				$sub_ledger_id = 15000001;
				}elseif($type=='Accounts Payable Inter-company'){
				$sub_ledger_id = 16000001;
				}elseif($type=='Advance to Management'){
				$sub_ledger_id = 17000001;
				}elseif($type=='Security deposit'){
				$sub_ledger_id = 18000001;
				}elseif($type=='FDR'){
				$sub_ledger_id = 19000001;
				}elseif($type=='Accounts Receivable Other'){
				$sub_ledger_id = 21000001;
				}elseif($type=='OTHERS'){
					$sub_ledger_id = 13000001;
				}elseif($type=='PL'){
					$sub_ledger_id = 22000001;
				}
				
				
			}
			
			
			
			
			
			
			$_POST[$unique] =$sub_ledger_id;
			$crud->insert();

		
		/*if($_FILES['cr_upload']['tmp_name']!=''){ 
		$file_temp = $_FILES['cr_upload']['tmp_name'];
		$folder = "../../images/cr_pic/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}*/
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
		$type=1;
    $tr_type="Edit";

		$msg='Successfully Updated.';

}

//for Delete..................................



/*if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}*/

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach($data as $key =>$value)

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
			
							<?
				
				//if(isset($_POST['search'])){
				
				?>
				
				<table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
				<thead>
				<tr class="bgc-info">
				  <th><span>Sub Ledger Code</span></th>
				
				<th><span>Sub Ledger Name</span></th>
				<th><span>Accounts Ledger </span></th>
				</tr>
				</thead>
				
				<tbody>
				
				<?php
				
				
				
				
				 $td='select a.'.$unique.',  a.'.$shown.', a.ledger_id from '.$table.' a where 1 order by a.sub_ledger_name  ';
				
				$report=db_query($td);
				
				while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
				
				<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
				  <td><?=$rp[0];?></td>
				
				<td><?=$rp[1];?></td>
				<td><?=find_a_field('accounts_ledger','ledger_name','ledger_id='.$rp[2]);?></td>
				</tr>
				
				<?php }?>
				</tbody>
				</table>
				
				<? //}?>

				<div id="pageNavPosition"></div>	


            </div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
            
            <form class="n-form setup-fixed"  action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Sub Ledger Name</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                        <input name="sub_ledger_name" required type="text" id="sub_ledger_name" tabindex="1" value="<?=$sub_ledger_name?>"   >	


                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Referance No.</label>
                    <div class="col-sm-9 p-0">
                        
                        <input name="referance_no"  type="text" id="referance_no" tabindex="1" value="<?=$referance_no?>"   >	


                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Bank Name</label>
                    <div class="col-sm-9 p-0">
                        
                        <input name="bank_name"  type="text" id="bank_name" tabindex="1" value="<?=$bank_name?>"   >	


                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Type</label>
                    <div class="col-sm-9 p-0">
                        
                        <select name="type" id="type" tabindex="1" required value="<?=$type?>">
						 <option></option>
						 <option <?=($type=='Cash In Hand')?'selected':''?>>Cash In Hand</option>
						 <option <?=($type=='Cash at Bank')?'selected':''?>>Cash at Bank</option>
						 <option <?=($type=='Brokerage And Commission')?'selected':''?>>Brokerage And Commission</option>
                         <option <?=($type=='Share Capital')?'selected':''?>>Share Capital</option>
                         <option <?=($type=='Bank Overdraft')?'selected':''?>>Bank Overdraft</option>
						 <option <?=($type=='Employee')?'selected':''?>>Employee</option>
						 <option <?=($type=='Loan From Director and Others')?'selected':''?>>Loan From Director and Others</option>
						 <option <?=($type=='Accounts Payable Inter-company')?'selected':''?>>Accounts Payable Inter-company</option>
						 <option <?=($type=='Advance to Management')?'selected':''?>>Advance to Management</option>
						 <option <?=($type=='Security Deposit')?'selected':''?>>Security Deposit</option>
						 <option <?=($type=='FDR')?'selected':''?>>FDR</option>
						 <option <?=($type=='Accounts Receivable Other')?'selected':''?>>Accounts Receivable Other</option>
						 <option <?=($type=='OTHERS')?'selected':''?> value="OTHERS" >OTHERS </option>
						</select>	


                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Accounts Ledger</label>
                    <div class="col-sm-9 p-0">
                        
                        <input name="ledger_id" required type="text" id="ledger_id" tabindex="1" value="<?=$ledger_id?>" list="ledger">
						<datalist id="ledger">
						<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,'1')?>
						</datalist>	


                    </div>
                </div>
                
                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Company</label>
                    <div class="col-sm-9 p-0">
                        
                        <select name="group_for" required id="group_for" tabindex="1">
						<option></option>
						<? user_company_access($group_for); ?>
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