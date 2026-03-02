<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tr_type="Show";



//include '../config/function.php';

 
// ::::: Edit This Section ::::: 



$title='User Distributor Access';			// Page Name and Page Title

do_datatable('table_head');

$page="user_distributor_access.php";		// PHP File Name



$table='user_warehouse_access';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='user_id';				// For a New or Edit Data a must have data field


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
$user = explode("|",$_POST['user_id']);
$_POST['user_id'] = $user[1];
$user_info = find_all_field('user_activity_management','','user_id="'.$user[1].'"');
$warehouse = explode("|",$_POST['warehouse_id']);
$_POST['warehouse_id'] = $warehouse[1];
$user_info = find_all_field('warehouse','','warehouse_id="'.$warehouse[1].'"');
$id=$crud->insert();

		
		/*if($_FILES['nsp']['tmp_name']!=''){ 
		$file_temp = $_FILES['nsp']['tmp_name'];
		$folder = "../../nsp_pic/nsp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}*/
$type=1;
$jv_no=next_journal_sec_voucher_id('','Commission',$_SESSION['user']['depot']);
$group_for = $_SESSION['user']['group'];
$cc_code = $group_for;
//$tr_from = 'Commission';
$proj_id='RCL';
$jv_date = $_POST['commission_date'];
$tr_no = $id;
$tr_id = $id;
$amount = $_POST['amount'];
$narration = $_POST['remarks'];
$mkt_expense_ledger = 5020400030;
$general_sub_ledger = 128;

//add_to_sec_journal($proj_id, $jv_no, $jv_date, $mkt_expense_ledger, $narration, ($amount), '0', $tr_from, $tr_no,$general_sub_ledger,$tr_id, $cc_code, $group_for,$entry_by,$entry_at,$received_from='', $bank='', $data->cheq_no,$data->cheq_date,$relavent_cash_head='',$checked='',$type='',$employee='',$remarks='',$reference_id='');

//add_to_sec_journal($proj_id, $jv_no, $jv_date, $dealer_info->account_code, $narration, '0', ($amount), $tr_from, $tr_no,$dealer_info->sub_ledger_id,$tr_id, $cc_code, $group_for,$entry_by,$entry_at,$received_from='', $bank='', $data->cheq_no,$data->cheq_date,$relavent_cash_head='',$checked='',$type='',$employee='',$remarks='',$reference_id='');

//sec_journal_journal($jv_no,$jv_no,$tr_from); 
$tr_type="Add";

$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
header('location:user_distributor_access.php');

}





//for Modify..................................



if(isset($_POST['update']))

{


		$_POST['edit_by'] = $_SESSION['user']['id'];
		 
		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');
		 
		 $user = explode("|",$_POST['user_id']);
		$_POST['user_id'] = $user[1];
		$user_info = find_all_field('user_activity_management','','user_id="'.$user[1].'"');
		$warehouse = explode("|",$_POST['warehouse_id']);
		$_POST['warehouse_id'] = $warehouse[1];
		$user_info = find_all_field('warehouse','','warehouse_id="'.$warehouse[1].'"');
		$id=$crud->insert();


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
		$tr_type="Delete";

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

  $condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);



foreach($data as $key =>$value)

{ 
    
      $$key=$value;
    
    
    
}

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
         <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">
            <div class="container p-0">
                <table class="table1  table-striped table-bordered table-hover table-sm" >
<thead class="thead1">
<tr class="bgc-info">
<th><span class="style3">SL</span></th>
<th><span class="style3">User Name</span></th>
<th><span class="style3">Distributor</span></th>
<th><span class="style3">Remarks</span></th>
</tr>

</thead>

<tbody>

<?php


 $sql = 'select c.*, d.dealer_code, d.dealer_name_e, u.user_id, u.fname from user_warehouse_access c, dealer_info d, user_activity_management u where c.warehouse_id=d.dealer_code and c.user_id=u.username';
$report=db_query($sql);

while($rp=mysqli_fetch_object($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp->id;?>');">
<td><?=$i;?></td>
<td><?=$rp->fname;?></td>
<td><?=$rp->dealer_name_e;?></td>
<td><?=$rp->remarks;?></td>
</tr>

<?php }?>
<!--<tr>
 <th colspan="4"><strong>Total</strong></th>
 <th><strong><?=number_format($total_amt,2)?></strong></th>
</tr>-->
</tbody>
</table>
            </div>


            <div class="container n-form1">
                
				
<?

//if(isset($_POST['search'])){

?>



<? //}?>
				
				
		<?php
		///user name////
		$sql='select * from user_activity_management where sfa_user ="Yes" group by user_id';
		$query=db_query($sql);
		while($row=mysqli_fetch_object($query)){
		    
		    $user_name_get[$row->user_id]=$row->fname;
		}
		
		///warehouse name////
		$sql='select * from dealer_info where 1 group by dealer_code';
		$query=db_query($sql);
		while($row=mysqli_fetch_object($query)){
		    
		    $warehouse_name_get[$row->dealer_code]=$row->dealer_name_e;
		}
		?>		

            </div>

        </div>


        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-5 col-6  setup-right">
            
			
            <form class="n-form"   action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-5 pl-0 pr-0 col-form-label ">User Name:</label>
                    <div class="col-sm-7 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	
                        <input type="text" class="m-0" name="user_id" id="user_id" list="user_list" value="<?=$user_name_get[$user_id]."|".$user_id?>" tabindex="1" required>
						<datalist id="user_list">
						 <? foreign_relation('user_activity_management','concat(fname,"|",username)','""','sfa_user ="Yes"')?>
						</datalist>
							


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-5 pl-0 pr-0 col-form-label">Distributor :</label>
                    <div class="col-sm-7 p-0">
                        <input type="text" class="m-0" name="warehouse_id" id="warehouse_id" value="<?=$warehouse_name_get[$warehouse_id]."|".$warehouse_id;?>" list="dealer_listt" tabindex="1" required>
						<datalist id="dealer_listt">
						 <? foreign_relation('dealer_info','concat(dealer_name_e,"|",dealer_code)','""','1')?>
						</datalist>	

                    </div>
                </div>
				
				
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-5 pl-0 pr-0 col-form-label">Remarks :</label>
                    <div class="col-sm-7 p-0">
                       <input class="m-0" name="remarks" type="text" id="remarks" tabindex="1"  value="<?=$remarks?>">
                    </div>
                </div>
				
                <div class="n-form-btn-class">
                  <input class="btn1 btn1-bg-update" name="insert" type="submit" id="insert" value="Confirm"/>
                  <input class="btn1 btn1-bg-cancel" name="reset" type="button" id="reset" value="Reset" onclick="parent.location='user_warehouse_access.php'" /> 

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

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>  
