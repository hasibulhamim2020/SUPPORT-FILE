<?php
session_start();
ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// ::::: Edit This Section ::::: 



$title='Cash Sub Ledger';			// Page Name and Page Title

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

$_POST['tr_from'] = 'custom';
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
         <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">
           


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


       <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6  setup-right">
            
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
				
				<!--<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Bank Name</label>
                    <div class="col-sm-9 p-0">
                        
                        <input name="bank_name"  type="text" id="bank_name" tabindex="1" value="<?=$bank_name?>"   >	


                    </div>
                </div>-->
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Type</label>
                    <div class="col-sm-9 p-0">
                        
                        <select name="type" id="type" tabindex="1" required value="<?=$type?>">
						 <option <?=($type=='Cash In Hand')?'selected':''?>>Cash In Hand</option>
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