<?php


/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";

// ::::: Edit This Section ::::: 



$title='Cheque Create';			// Page Name and Page Title

do_datatable('table_head');

$page="cheque_create.php";		// PHP File Name

$table='cheque_book_master';		// Database Table Name Mainly related to this page

$unique='cheq_no';			// Primary Key of this Database table

$shown='total_page';				// For a New or Edit Data a must have data field

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

$_POST['entry_by'] = $_SESSION['user']['id'];
		 
$_POST['entry_at'] = $now=date('Y-m-d H:i:s');

if($_POST['total_page']>100){
	$_POST['total_page'] = 100;
	}

$cheq_no=$crud->insert();

for($s=1;$s<=$_POST['total_page'];$s++){
	   
	   db_query('insert into cheque_book_details set cheq_no="'.$cheq_no.'",bank="'.$_POST['bank'].'",page_no="'.$s.'",status="Pending"');
	   
	}
		
$type=1;

$msg='New Entry Successfully Inserted.';
$tr_type="Add";

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



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;
        $tr_type="Delete";

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
    
    
        <div class="col-sm-6 p-0 pr-2">
              <div class="container p-0">
			<form id="form1" name="form1" class="n-form1 pt-0" method="post" action="">
			<h4 align="center" class="n-form-titel1">Search Cost Bank</h4>


                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Bank:</label>
                        <div class="col-sm-9 p-0">
						<select name="bank_id" required id="bank_id" style="float:left;" tabindex="7">
                             <option></option>
						  <? foreign_relation('acc_bank_info','dealer_code','dealer_name_e',$bank_id,'1');?>
						  
						  
						</select>

                        </div>
                    </div>
					
					<!--<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Warehouse Name:</label>
                        <div class="col-sm-9 p-0">
                             	<input name="warehouse_name" type="text" id="warehouse_name" style="width:250px; float:left;" value="<?php echo $_POST['warehouse_name']; ?>" />
                        </div>
                    </div>-->
					
					
					

                    <div class="n-form-btn-class">										  
                        <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show">
                        <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear">
                    </div>

                </form>
            </div>
            <div class="container n-form1">
			<table id="table_head" class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th height="24">Bank</th>
					<th>Cheque No.</th>
                    <th>Page No.</th>
                    <th>Status</th>
                    
				</tr>
				</thead>

				<tbody class="tbody1">

<?php


if($_POST['group_for']!="")

$con .= ' and a.group_for="'.$_POST['group_for'].'"';



if($_POST['bank_id']!="")

$con .=' and a.bank='.$_POST['bank_id'].'';


$td='select a.'.$unique.',  a.'.$shown.',a.cheque_no_manual,d.page_no,d.status,b.sub_ledger_name as bank_name from '.$table.' a, cheque_book_details d,
general_sub_ledger b where a.bank=b.sub_ledger_id and a.cheq_no=d.cheq_no '.$con.' order by a.cheq_no,d.page_no  ';

$report=db_query($td);

while($rp=mysqli_fetch_object($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp->cheq_no;?>');">
  <td><?=$rp->bank_name;?></td>
  <td><?=$rp->cheque_no_manual;?></td>
  <td><?=$rp->page_no;?></td>
  <td><?=$rp->status;?></td>
</tr>

<?php }?>

				
				</tbody>
			</table>
                <div id="pageNavPosition"></div>
				
				

            </div>

        </div>


        <div class="col-sm-6 p-0  pl-2">
            
			<form class="n-form setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
			
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>
                
                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Bank </label>
                    <div class="col-sm-9 p-0">
					
					<select name="bank" required id="bank"  tabindex="7" style="width:220px;">
                          <option></option>
                      <? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$bank,'type="Cash at Bank"');?>
                    </select>

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label "> Chequ No.:</label>
                    <div class="col-sm-9 p-0">
															<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        				<input name="cheque_no_manual" required type="text" id="cheque_no_manual" tabindex="1" value="<?=$cheque_no_manual?>"  style="width:220px;" >	
										
                    </div>
                </div>
                
                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label "> Total Page:</label>
                    <div class="col-sm-9 p-0">
															<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="cheq_no" type="hidden" id="cheq_no" tabindex="1" value="<?=$cheq_no?>" readonly>
                        				<input name="total_page" required type="text" id="total_page" tabindex="1" value="<?=$total_page?>"  style="width:220px;" >	
										
                    </div>
                </div>


                

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Status  </label>
                    <div class="col-sm-9 p-0">
					<select name="status" id="status"  style="width:250px;">

                                          <option></option>

                                          <option value="Active" <?=($status=='Active')?'selected':''?>>Active</option>

                                          <option value="Inactive" <?=($status=='Inactive')?'selected':''?>>Inactive</option>


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