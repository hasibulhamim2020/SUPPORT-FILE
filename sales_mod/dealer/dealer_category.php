<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







// ::::: Edit This Section ::::: 



$title='Customer Category';			// Page Name and Page Title

do_datatable('table_head');



$page="dealer_category.php";		// PHP File Name

$tr_type="Show";

$table='dealer_type';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='dealer_type';				// For a New or Edit Data a must have data field



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
		$tr_type="Add";

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
		$tr_type="Delete";

}

}



if(isset($$unique))

{
$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);


foreach($data as $key=>$value)
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


.sr-main-content-padding pt-4{

}
</style>







<div class="container-fluid p-0">
    <div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">
            <div class="container p-0">
                <form id="form1" name="form1" class="n-form1 pt-0" method="post" action="" >
					<h4 align="center" class="n-form-titel1">Search Customer Category:</h4>

                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company</label>
                        <div class="col-sm-9 p-0">
                        <select name="group_for" required id="group_for" tabindex="7">

							<? foreign_relation('user_group','id','group_name',$group_for,'
							id="'.$_SESSION['user']['group'].'"');?>
						</select>

                        </div>
                    </div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Category Name</label>
                        <div class="col-sm-9 p-0">
                             	<input name="dealer_type" class="m-0" type="text" id="dealer_type" value="<?php echo $_POST['dealer_type']; ?>" />

                        </div>
                    </div>

                    <div class="n-form-btn-class">
                        <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                        <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear" />
                    </div>

                </form>
            </div>


            <div class="container n-form1">
				<?

				//if(isset($_POST['search'])){

				?>
				<table  id="table_head" class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
						<tr class="bgc-info" >
							<th>ID</th>
							<th>Category Name</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>

				<tbody class="tbody1">

					<?php
					if($_POST['group_for']!="")

					$con .= 'and a.group_for="'.$_POST['group_for'].'"';
				

					if($_POST['dealer_type']!="")

					$con .='and a.dealer_type like "%'.$_POST['dealer_type'].'%" ';
				
					

					$td='select a.'.$unique.',  a.'.$shown.' ,   a.status from '.$table.' a, user_group u	where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'"   '.$con.' order by a.id  ';

					$report=db_query($td);

					while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

					<tr<?=$cls?> >
						<td><?=$rp[0];?></td>
						<td align="left"><?=$rp[1];?></td>
						<td><?=$rp[2];?></td>
						<td>
						<button type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
						</td>
					</tr>

					<?php }?>
				</tbody>
				</table>
            </div>
        </div>


        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6  setup-right">
            <form class="n-form setup-fixed"   action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Category</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input class="m-0" name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        <input class="m-0" name="dealer_type" required type="text" id="dealer_type" tabindex="1"  value="<?=$dealer_type?>"  >	


                    </div>

                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Company </label>
                    <div class="col-sm-9 p-0">
                        <select  name="group_for" required id="group_for"  tabindex="7">
							<? foreign_relation('user_group','id','group_name',$group_for,'
							id="'.$_SESSION['user']['group'].'"');?>
						</select>

                    </div>

                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Status  </label>
                    <div class="col-sm-9 p-0">

                       <select name="status" id="status" required="required">

                              <option value="<?=$status?>"><?=$status?></option>

                              <option value="ACTIVE">ACTIVE</option>

                               <option value="INACTIVE">INACTIVE</option>


                        </select>
					</div>
                </div>
                

                <div class="n-form-btn-class">
                    <? if(!isset($_GET[$unique])){?>
                    <input class="btn1 btn1-bg-submit" name="insert" type="submit" id="insert" value="Save"  />
                    <? }?>

					<? if(isset($_GET[$unique])){?>
                    <input class="btn1 btn1-bg-update" name="update" type="submit" id="update" value="Update"  />
                    <? }?>

					<input class="btn1 btn1-bg-cancel" name="reset" type="button"  id="reset" value="Reset" onclick="parent.location='<?=$page?>'" /> 
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