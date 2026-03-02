<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 $tr_type="Show";	

 $chq_id = $_GET['chq_id'];
 $bank_id = find_a_field('chq_setup','bank_name','id='.$chq_id);
do_calander('#issue_date');
do_calander('#exp_date');
do_calander('#rec_date');
do_calander('#ins_start_date');
do_calander('#ins_end_date');
do_datatable('table_head');



// ::::: Edit This Section ::::: 
$unique='id';  		// Primary Key of this Database table
$title='Cheque Setup' ; 	// Page Name and Page Title
$page="cheque_setup_entry.php";		// PHP File Name
$table='chq_setup_master';		// Database Table Name Mainly related to this page


$crud    = new crud($table);
$$unique = $_GET[$unique];

//for submit..................................
if(isset($_POST['submit']))
{		
		$booked=find_a_field('chq_page','count(ch_id)','status="No" and ch_id="'.$chq_id.'" ');
		
		if($booked>0)
		{
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];
		
		$crud->insert();
		$type=1;
		$tr_type="Add";
		$msg='New Entry Successfully Inserted.';

		$update="update chq_page set status='Yes' where page_no=".$_POST['chq_no']." and ch_id=".$chq_id."";
		db_query($update);
		
		header('Location: cheque_setup_status.php');
		
		
		}
		else
		{
			echo "All Cheque are Booked";
		
		}
}




//for update..................................
if(isset($_POST['update']))
{
		$entry_at=date('Y-m-d H:i:s');
		$entry_at=$_SESSION['user']['id'];
//		$crud->update($$unique);
//		$type=1;
//		echo $msg='Successfully Updated.';
		//header('Location: cheque_setup_status.php');
		
		 $update="update chq_setup_master set amount='".$_POST['amount']."',chq_date='".$_POST['chq_date']."',payee_name='".$_POST['payee_name']."',particulars='".$_POST['particulars']."',voucher_ref='".$_POST['voucher_ref']."',status='".$_POST['status']."',edit_by='".$entry_at."',edit_at='".$entry_at."' where id='".$_GET['id']."'";
		db_query($update);
		header('Location: cheque_setup_status.php');
		$tr_type="Edit";
}
	
	
if(isset($unique))
{
	$condition=$unique."=".$$unique;	
	$data=db_fetch_object($table,$condition);
	foreach ($data as $key => $value)
	{ $$key=$value;}
}	
	$master= find_all_field('chq_setup','*','id='.$chq_id);
	 $master->first_chq_no;
?>


<script type="text/javascript">
	function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}
</script>


<div class="container-fluid">
    <div class="d-flex justify-content-center row">
        <div class="col-sm-5">
		<form class="n-form" action="" method="post" enctype="multipart/form-data">
			
                <h4 align="center" class="n-form-titel1"> New Cheque Setup</h4>								
					<input name="<?=$unique?>" required="" type="hidden" id="<?=$unique?>" value="<?=$$unique;?>" >	
					<input name="chq_id" required="" type="hidden" id="chq_id" value="<?=$bank_id;?>" >	
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Chequebook ID: </label>
                    <div class="col-sm-7 p-0">
						<input name="chq_book_id" required="" type="text" id="chq_book_id" tabindex="1" value="<? if($chq_book_id!=''){echo $chq_book_id;} else { echo $master->chq_book_id;}?>"  readonly>	
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">Cheque No: </label>
                    <div class="col-sm-7 p-0">
						<!--<input name="chq_no"  type="text" id="chq_no" tabindex="1" value="<? if($chq_no>0){ echo $chq_no;}else{ if($chq_no<0){ echo $master->first_chq_no;} else{ echo $master->first_chq_no+1;}}?>" >-->	
						
						<input name="chq_no"  type="text" id="chq_no" readonly="readonly" required tabindex="1" value="<?=$chq_no=find_a_field('chq_page','min(page_no)','ch_id="'.$_GET['chq_id'].'" and status="No"');	
						
									
						?>" >
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Cheque Date: </label>
                    <div class="col-sm-7 p-0">
						<input name="chq_date"  type="text" id="chq_date" tabindex="1" value="<?=($chq_date!='')?$chq_date:date('Y-m-d')?>" autocomplete="off">	
                    </div>
                </div>
								
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Amount: </label>
                    <div class="col-sm-7 p-0">
						<input name="amount"  type="text" id="amount" tabindex="1" value="<?=$amount;?>" >	
                    </div>
                </div>
								
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Payee Name: </label>
                    <div class="col-sm-7 p-0">
						<input name="payee_name"  type="text" id="payee_name" tabindex="1" value="<?=$payee_name;?>" >	
                    </div>
                </div>
								
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> particulars: </label>
                    <div class="col-sm-7 p-0">
						<input name="particulars"  type="text" id="particulars" tabindex="1" value="<?=$particulars;?>" >	
                    </div>
                </div>
								
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> voucher_ref # </label>
                    <div class="col-sm-7 p-0">
						<input name="voucher_ref"  type="text" id="voucher_ref" tabindex="1" value="<?=$voucher_ref;?>" >	
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class=" col-sm-5 pl-0 pr-0 col-form-label "> Status </label>
                    <div class="col-sm-7 p-0">
					<select name="status" id="status" value="<?=$status?>" >
						<option><?=$acct_payee?></option> 
                      	<option selected="selected" value="check">check</option>    
					    <option value="confirm">confirm</option>                
					 </select>	
                    </div>
                </div>
				
				




                <div class="n-form-btn-class">
					<? if(!isset($_POST[$unique])&&!isset($_GET[$unique])) {?>
					<input name="submit" type="submit" id="submit" value="SAVE" class="btn1 btn1-bg-submit">
					
					<? }?>
                     
					 <? if(isset($_POST[$unique])||isset($_GET[$unique])) {?>
					 <input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update">

					<? }?>

                 
                </div>


            </form>
        </div>
</div>




            <div class="container n-form1 mt-3">
			
			
				
				

            </div>




</div>



<?
$page_name='Cheque Setup' ;
	require_once SERVER_CORE."routing/layout.bottom.php";
?>