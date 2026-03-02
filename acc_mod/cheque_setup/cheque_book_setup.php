<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";

do_calander('#issue_date');
do_calander('#exp_date');
do_calander('#rec_date');
do_calander('#ins_start_date');
do_calander('#ins_end_date');
do_datatable('table_head');



// ::::: Edit This Section ::::: 
$unique='id';  		// Primary Key of this Database table
$title='Cheque Book Setup' ; 	// Page Name and Page Title
$page="cheque_book_setup.php";		// PHP File Name
$table='chq_setup';		// Database Table Name Mainly related to this page
$table1='chq_page';

$crud    = new crud($table);
$crud1    = new crud($table1);
$$unique = $_GET[$unique];

//for submit..................................
if(isset($_POST['submit']))
{		
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$ch_id = $crud->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
		
		$page_no1 = $_POST['chq_page'];
		$first_cheq = $_POST['first_chq_no'];
		//$ch_id = $$unique; // assuming unique id is posted as well
		
		 for ($i = 0; $i < $page_no1; $i++) {
        //$page_number = $i + 1;
        $page_no = $first_cheq + $i;
		
		$insert_page="INSERT INTO chq_page (ch_id,page_no,status) values ('".$ch_id."','".$page_no."','No')";
		db_query($insert_page);
		$tr_type="Add";
        // Insert the data
       
    }

}


//for update..................................
if(isset($_POST['update']))
{
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		 $tr_type="Edit";
		$msg='Successfully Updated.';
}
	
	
if(isset($$unique))
{
	$condition=$unique."=".$$unique;	
	$data=db_fetch_object($table,$condition);
	foreach ($data as $key => $value)
	{ $$key=$value;}
}	
	
?>


<script type="text/javascript">
	function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}
</script>


<div class="container-fluid">
    <div class="d-flex justify-content-center row">
        <div class="col-sm-5">
		<form class="n-form" action="<?=$page?>?<?=$unique?>=<?=$$unique?>" method="post" enctype="multipart/form-data">
			
                <h4 align="center" class="n-form-titel1"> New Chequebook Setup</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Bank: </label>
                    <div class="col-sm-7 p-0">									
					<input name="<?=$unique?>" required="" type="hidden" id="<?=$unique?>" value="<?=$$unique;?>" >	
                    <!--<input name="bank_name" required="" type="text" id="bank_name" tabindex="1" value="<?=$bank_name;?>" >-->
					<select name="bank_name" id="bank_name">
						<option></option>
						
						<? 
						$gr_all=find_all_field('config_group_class','*','group_for='.$_SESSION['user']['group']);
						foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$bank_name,"ledger_id=".$gr_all->bank_ledger." order by ledger_id");
						?>
					
					</select>
                    </div>
                </div>
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Account Name: </label>
                    <div class="col-sm-7 p-0">														
                    <input name="acct_name" required="" type="text" id="acct_name" tabindex="1" value="<?=$acct_name;?>" >
                    </div>
                </div>
			
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Account Number : </label>
                    <div class="col-sm-7 p-0">
						
						<input name="acct_number" required="" type="text" id="acct_number" tabindex="1" value="<?=$acct_number;?>" >	
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Chequebook ID: </label>
                    <div class="col-sm-7 p-0">
						<input name="chq_book_id" required="" type="text" id="chq_book_id" tabindex="1" value="<?=$chq_book_id;?>" >	
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">First Cheque No: </label>
                    <div class="col-sm-7 p-0">
						<input name="first_chq_no"  type="text" id="first_chq_no" tabindex="1" value="<?=$first_chq_no;?>" >	
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Number of Pages: </label>
                    <div class="col-sm-7 p-0">
						<input name="chq_page"  type="text" id="chq_page" tabindex="1" value="<?=$chq_page;?>" >	
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class=" col-sm-5 pl-0 pr-0 col-form-label "> Account Payee </label>
                    <div class="col-sm-7 p-0">
					<select name="acct_payee" id="acct_payee" value="<?=$acct_payee?>" >
						<option><?=$acct_payee?></option> 
                      	<option value="Yes">YES</option>    
					    <option value="No">NO</option>                
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

                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='cheque_book_setup.php'">
                    

                 
                </div>


            </form>
        </div>
</div>




            <div class="container n-form1 mt-3">
			
			<table id="table_head" class="table1 table-striped table-bordered table-hover table-sm dataTable no-footer" role="grid" aria-describedby="table_head_info" style=" ZOOM: 75%; ">
				<thead class="thead1">
					<tr class="bgc-info" role="row">
						<th>Sl No </th>
						<th>Bank</th>
						<th>Account Name</th>
						<th>Account Number  </th>
						<th>Chequebook ID </th>
						<th>First Cheque No</th>
						<th>Number of Pages </th>
						<th>Account Payee </th>
						<th>Action</th>

					</tr>
				</thead>

				<tbody class="tbody1">
				<?  $data = "SELECT * FROM chq_setup WHERE 1"; 
					$query = db_query($data);
					$i=1;
					while($row=mysqli_fetch_object($query)){
				?>
					<tr>
					    <td><?=$i++;?></td>
						<td><?=find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id='.$row->bank_name);?></td>
						<td><?=$row->acct_name;?></td>
						<td><?=$row->acct_number;?></td>
						<td><?=$row->chq_book_id;?></td>
						<td><?=$row->first_chq_no;?></td>
						<td><?=$row->chq_page;?></td>
						<td><?=$row->acct_payee;?></td>
						<td><button type="button" onclick="nav('<?=$row->id;?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button></td>
					</tr>
					
					<?php
					}	
					?>
				</tbody>
			</table>
				
				

            </div>




</div>



<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>