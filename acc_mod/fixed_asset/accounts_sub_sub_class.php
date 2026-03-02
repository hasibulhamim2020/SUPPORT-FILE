<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 



$title='Fixed Assets Group';			// Page Name and Page Title

do_datatable('table_head');

$page="accounts_sub_sub_class.php";		// PHP File Name

$table='acc_sub_sub_class';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='sub_sub_class_name';				// For a New or Edit Data a must have data field

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



$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d h:i:s');



$cy_id = find_a_field('acc_sub_sub_class','max(sub_sub_class_id)','acc_sub_class='.$_POST['acc_sub_class'])+1;

$_POST['sub_sub_class_id'] = sprintf("%01d", $cy_id);

$_POST['id'] = $_POST['acc_sub_class'].''.$_POST['sub_sub_class_id'];



$crud->insert();

		
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

            <div class="container n-form1">
			<table id="table_head" class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th>Code</th>
					<th>Accounts Sub Sub Class</th>
					<th>Accounts Sub Class</th>
					<th>Accounts Class</th>
				</tr>
				</thead>

				<tbody class="tbody1">

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.', a.acc_sub_class, a.acc_class  from '.$table.' a where id=111  '.$con.' order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td align="left"><?=$rp[1];?></td>
<td align="left"><?=find_a_field('acc_sub_class','sub_class_name','id='.$rp[2]);?></td>
<td align="left"><?=find_a_field('acc_class','class_name','id='.$rp[3]);?></td>
</tr>

<?php }?>


				
				</tbody>
			</table>
                <div id="pageNavPosition"></div>
				
				

            </div>

        </div>


        <div class="col-sm-5">
		<form class="n-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
			
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-4 pl-0 pr-0 col-form-label "> Acc. Sub Class:</label>
                    <div class="col-sm-8 p-0">
										
										<input name="id" required type="hidden" id="id" tabindex="1" value="<?=$id?>" >	
                        				<input name="sub_sub_class_name" required type="text" id="sub_sub_class_name" tabindex="1" value="<?=$sub_sub_class_name?>" >	
										

                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-4 pl-0 pr-0 col-form-label">Acc. Class:</label>
                    <div class="col-sm-8 p-0">
					
							<select name="acc_class" required id="acc_class"  tabindex="2" onchange="getData2('acc_sub_class_ajax.php', 'sub_class', this.value, 
document.getElementById('acc_class').value);">
										
                      						<? foreign_relation('acc_class','id','CONCAT(id, ": ", class_name)',$acc_class,'id=1');?>
                    					</select>

                    </div>
                </div>


				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-4 pl-0 pr-0 col-form-label">Sub Class:</label>
                    <div class="col-sm-8 p-0">
										<span id="sub_class">
										
										<select name="acc_sub_class" required id="acc_sub_class"  tabindex="2">
										
                      						<? foreign_relation('acc_sub_class','id','CONCAT(id, ": ", sub_class_name)',$acc_sub_class,'id=11');?>
                    					</select></span>

                    </div>
                </div>






                <!--<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-4 pl-0 pr-0 col-form-label">Company </label>
                    <div class="col-sm-8 p-0">
					
					<select name="group_for" required id="group_for"  tabindex="7" style="width:220px;">

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select>

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-4 pl-0 pr-0 col-form-label">Status  </label>
                    <div class="col-sm-8 p-0">
					<select name="status" id="status"  style="width:250px;">

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="Active">Active</option>

                                          <option value="Inactive">Inactive</option>


                                        </select>

                    </div>
                </div>-->





                <div class="n-form-btn-class">
			
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="hidden" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
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

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>