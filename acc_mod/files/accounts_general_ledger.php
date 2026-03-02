<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//create_combobox('sub_group_id');


// ::::: Edit This Section ::::: 



$title='General Ledger';			// Page Name and Page Title

do_datatable('table_head');

$page="accounts_general_ledger.php";		// PHP File Name

$table='accounts_ledger';		// Database Table Name Mainly related to this page

$unique='ledger_id';			// Primary Key of this Database table

$shown='ledger_name';				// For a New or Edit Data a must have data field

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
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = $now=date('Y-m-d H:i:s');
if(!ledger_redundancy($_POST['ledger_name']))

	{

	$type=0;

	$msg='Given Name('.$_POST['ledger_name'].') is already exists.';

	}

	else

	{

	 $ledger_id=next_ledger_id($_POST['ledger_group_id']);

//$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group_id'])+1;
//$_POST['ledger_sl'] = sprintf("%05d", $cy_id);
//$_POST['ledger_id'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];
$_POST['ledger_id'] = $ledger_id;



$crud->insert();

		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}
}





//for Modify..................................



if(isset($_POST['update']))

{


		$_POST['edit_by'] = $_SESSION['user']['id'];
		 
		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');
		 
		 $_POST['ledger_layer'] = 1;


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



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <?php /*?><tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Company:                                       </td>

                                        <td width="60%" align="right">

										<select name="group_for" required id="group_for" style="width:250px; float:left;" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select>
										
										</td>

                                      </tr>
									
									
									

                                      

                                      

                                      <!--<tr>

                                        <td align="right"> Warehouse Name:                                         </td>

                                        <td align="right"><input name="warehouse_name" type="text" id="warehouse_name" style="width:250px; float:left;" value="<?php echo $_POST['warehouse_name']; ?>" size="20" /></td>

                                      </tr>-->

                                      <tr>

                                        <td colspan="2"><div align="center">
                                          <input class="btn" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn" name="cancel" type="submit" id="cancel" value="Cancel" />
                                        </div></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr><?php */?>

								  <tr>

									<td>&nbsp;</td>

								  </tr> <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th style="background-color:#45777B;">GL Code</span></th>

  <th style="background-color:#45777B;"><span class="style3">Acc. Class</span> </th>
  <th style="background-color:#45777B;"><span class="style3">Sub Class</span></th>
  <th style="background-color:#45777B;"><span class="style3">GL  Group </span></th>
  <th style="background-color:#45777B;"><span class="style3">General Ledger </span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';



 $td='select a.'.$unique.',  a.'.$shown.', a.acc_class, a.acc_sub_class,  a.ledger_group_id from '.$table.' a where 1  '.$con.' order by a.ledger_id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td><?=find_a_field('acc_class','class_name','id='.$rp[2]);?></td>
<td><?=find_a_field('acc_sub_class','sub_class_name','id='.$rp[3]);?></td>
<td><?=find_a_field('ledger_group','group_name','group_id='.$rp[4]);?></td>
<td><?=$rp[1];?></td>
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

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" style="background-color:#45777B;"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      

									  

									  <tr>

                                     <td><span class="style1" style="padding-top:5px;; color: #FF0000">*</span>General Ledger :</td>

                                        <td>
										
										<input name="ledger_id" required type="hidden" id="ledger_id" tabindex="1" value="<?=$ledger_id?>"  style="width:220px;" >	
										<input name="balance_type" required type="hidden" id="balance_type" tabindex="1" value="Both"  style="width:220px;" >
									
                        				<input name="ledger_name" required type="text" id="ledger_name" tabindex="1" value="<?=$ledger_name?>"  class="form-control" >	
										
										
										</td>
                                      </tr>
									  
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;; color: #FF0000">*</span>Acc. Class:</td>

                                        <td>
										
										<select name="acc_class" required id="acc_class"  tabindex="2" class="form-control" 
										onchange="getData2('acc_sub_class_ajax.php', 'sub_class', this.value, 
document.getElementById('acc_class').value);">
										<option></option>
                      						<? foreign_relation('acc_class','id','CONCAT(id, ": ", class_name)',$acc_class,'1');?>
                    					</select></td>
                                      </tr>
									  
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;; color: #FF0000">*</span>Acc Sub Class:</td>

                                        <td>
										<span id="sub_class">
										
										<select name="acc_sub_class" required id="acc_sub_class"  tabindex="2" class="form-control">
										<option></option>
                      						<? foreign_relation('acc_sub_class','id','CONCAT(id, ": ", sub_class_name)',$acc_sub_class);?>
                    					</select></span></td>
                                      </tr>
									  
								<tr>

                                        <td><span class="style1" style="padding-top:5px;; color: #FF0000">*</span>Acc Sub Sub Class:</td>

                                        <td>
										<span id="acc_group">
										<select name="acc_sub_sub_class" required id="acc_sub_sub_class"  tabindex="2" style="width:220px;" class="form-control">
										<option></option>
                      						<? foreign_relation('acc_sub_sub_class','id','CONCAT(id, ": ", sub_sub_class_name)',$acc_sub_sub_class);?>
                    					</select></span></td>
                                      </tr>
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;; color: #FF0000">*</span>GL Group:</td>

                                        <td>
										<span id="ledger_group">
										<select name="ledger_group_id" required id="ledger_group_id"  tabindex="2" class="form-control">
										<option></option>
                      						<? foreign_relation('ledger_group','group_id','CONCAT(group_id, ": ", group_name)',$ledger_group_id);?>
                    					</select></span></td>
                                      </tr>
									  
									  
									  
									  
									  
			

                                      <tr>

                                        <td><span class="style1" style="padding-top:5px;; color: #FF0000">*</span>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for"  tabindex="7" class="form-control" >

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select></td>
                                      </tr>
									  
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
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn btn-primary" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn btn-success" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn btn-warning" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
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

</table>

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