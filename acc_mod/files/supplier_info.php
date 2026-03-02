<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



create_combobox('ledger_id');
create_combobox('vat_ledger');
create_combobox('tds_ledger');




// ::::: Edit This Section ::::: 



$title='ADD Supplier Information';			// Page Name and Page Title

do_datatable('vendor_table');

$page="supplier_info.php";		// PHP File Name



$table='vendor';		// Database Table Name Mainly related to this page

$unique='vendor_id';			// Primary Key of this Database table

$shown='vendor_name';				// For a New or Edit Data a must have data field



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


//$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['dealer_group'])+1;
//
//$_POST['ledger_sl'] = sprintf("%02d", $cy_id);
//
//$_POST['acc_class'] = find_a_field('ledger_group','acc_class','group_id='.$_POST['dealer_group']); 
//
//$_POST['acc_sub_class'] = find_a_field('ledger_group','acc_sub_class','group_id='.$_POST['dealer_group']); 
//
//$_POST['acc_sub_sub_class'] = find_a_field('ledger_group','acc_sub_sub_class','group_id='.$_POST['dealer_group']); 
//
//$_POST['account_code'] = $_POST['dealer_group'].''.$_POST['ledger_sl'];




$xid = $crud->insert();

//$crud->insert();

 $vendor_found = find_a_field('acc_reference','id','config_id='.$_POST['vendor_id']);


if ($vendor_found==0) {
   $acc_ins1 = 'INSERT INTO acc_reference ( reference_name, ledger_id, config_id, entry_by, entry_at)
  
  VALUES("'.$_POST['vendor_name'].'", "'.$_POST['ledger_id'].'", "'.$xid.'","'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';
db_query($acc_ins1);


 $acc_ins2 = 'INSERT INTO acc_reference ( reference_name, ledger_id, config_id, entry_by, entry_at)
  
  VALUES("'.$_POST['vendor_name'].'", "'.$_POST['vat_ledger'].'", "'.$xid.'","'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';
db_query($acc_ins2);


$acc_ins3 = 'INSERT INTO acc_reference ( reference_name, ledger_id, config_id, entry_by, entry_at)
  
  VALUES("'.$_POST['vendor_name'].'", "'.$_POST['tds_ledger'].'", "'.$xid.'","'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';
db_query($acc_ins3);

}



		 $under=find_a_field('config_group_class','receivable',"group_for=".$_SESSION['user']['group']);

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

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);
		
		 $vendor_id =$_POST['vendor_id'];
		 $vendor_name = $_POST['vendor_name'];
		 
		 
		  $first_ref_id = find_a_field_sql("SELECT id FROM acc_reference WHERE config_id='".$vendor_id."' ORDER by id asc limit 1");
		 $last_ref_id = find_a_field_sql("SELECT * FROM acc_reference WHERE config_id='".$vendor_id."' ORDER by id desc limit 1 ");
		  $middle_ref_id = find_a_field_sql("SELECT id FROM acc_reference WHERE config_id='".$vendor_id."' and id not in ('".$first_ref_id."','".$last_ref_id."')");
		 
		 
		 $sql1 = 'update acc_reference set ledger_id="'.$_POST['ledger_id'].'" , reference_name="'.$vendor_name.'" where id = '.$first_ref_id;
		db_query($sql1);
		
		 $sql2 = 'update acc_reference set ledger_id="'.$_POST['vat_ledger'].'" , reference_name="'.$vendor_name.'" where id = '.$middle_ref_id;
		db_query($sql2);
		
		 $sql3 = 'update acc_reference set ledger_id="'.$_POST['tds_ledger'].'" , reference_name="'.$vendor_name.'" where id = '.$last_ref_id;
		db_query($sql3);

		
		

		//$id = $_POST['dealer_code'];
//
//		if($_FILES['cr_upload']['tmp_name']!=''){ 
//		$file_temp = $_FILES['cr_upload']['tmp_name'];
//		$folder = "../../images/cr_pic/";
//		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
//
//
//		if($_FILES['pp']['tmp_name']!=''){ 
//		$file_temp = $_FILES['pp']['tmp_name'];
//		$folder = "../../pp_pic/pp/";
//		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
//		
//		if($_FILES['np']['tmp_name']!=''){ 
//		$file_temp = $_FILES['np']['tmp_name'];
//		$folder = "../../np_pic/np/";
//		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
//		
//		if($_FILES['spp']['tmp_name']!=''){ 
//		$file_temp = $_FILES['spp']['tmp_name'];
//		$folder = "../../spp_pic/spp/";
//		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
//		
//		if($_FILES['nsp']['tmp_name']!=''){ 
//		$file_temp = $_FILES['nsp']['tmp_name'];
//		$folder = "../../nsp_pic/nsp/";
//		move_uploaded_file($file_temp, $folder.$id.'.jpg');}

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



/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 100px;
    height: 40px;
    border-radius: 0px !important;
}




</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Company:                                       </td>

                                        <td width="60%" align="right">

										<select name="group_for" required id="group_for" class="form-control" >

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>
										
										</td>

                                      </tr>
									
									
									

                                      <!--<tr>

                                        <td width="40%" align="right">Warehouse:                                       </td>

                                        <td width="60%" align="right">
										
									


										<select name="depot"  id="depot" style="width:250px; float:left" tabindex="7">
										
										<option></option>

                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot'],'1');?>
                    </select></td>

                                      </tr>-->

                                      

                                      <tr>

                                        <td align="right"> Customer Code:                                         </td>

                                        <td align="right"><input name="customer_code" type="text" id="customer_code" class="form-control" value="<?php echo $_POST['customer_code']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td colspan="2"><div align="center">
                                          <input class="btn btn-primary" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn btn-success" name="cancel" type="submit" id="cancel" value="Cancel" />
                                        </div></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td>&nbsp;</td>

								  </tr> <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="vendor_table" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">Code</span></th>

  <th bgcolor="#45777B"><span class="style3">Supplier Name </span></th>

  <th bgcolor="#45777B"><span class="style3">Supplier Type  </span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['depot']!="")

$con .= 'and a.depot="'.$_POST['depot'].'"';


if($_POST['customer_code']!="")

$con .='and a.dealer_code like "%'.$_POST['customer_code'].'%" ';





   $td='select a.'.$unique.',  a.'.$shown.' as vendor_name, a.ledger_id from '.$table.' a, user_group u
				where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'"   '.$con.' order by a.vendor_id asc ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

  <td><?=$rp[1];?></td>

<td><?=find_a_field('accounts_ledger','ledger_name',"ledger_id=".$rp[2]);?> </td>
</tr>

<?php }?>
</tbody>
</table>

<? //}?>

									<div id="pageNavPosition"></div>									</td>

								  </tr>

		</table>



	</div></td>

    <td valign="top" width="40%"><div class="right">    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

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

                                      

									  

									  <!--<tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>Customer Code:</td>

                                        <td>
										
                       					<input name="dealer_code" type="hidden" id="dealer_code" tabindex="1" value="<?=$dealer_code?>" readonly>
                        				<input name="customer_id" required type="text" id="customer_id" tabindex="1" value="<?=$customer_id?>"  style="width:250px;"
										
										onblur="getData2('customer_code_ajax.php', 'customer_code_info',this.value,document.getElementById('customer_id').value);" >	
										
										<span id="customer_code_info">
                                       
										
										 </span></td>
                                      </tr>-->
									  
									  
									  
									  

                                      <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Supplier Name:</td>

                                        <td>
										
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                                        <input name="vendor_name" required type="text" id="vendor_name" tabindex="2" autocomplete="off"  value="<?=$vendor_name?>" class="form-control"></td>
									  </tr>
									  
									  
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Supplier Type:</td>

                                        <td>
										
										<select name="ledger_id" required id="ledger_id" class="form-control" tabindex="3" >
											<option></option>

                      						<? foreign_relation('accounts_ledger','ledger_id','CONCAT(ledger_id, ": ", ledger_name)',$ledger_id,'ledger_group_id = 220301 ');?>
                   						</select></td>
                                      </tr>
									  
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>VAT Ledger:</td>

                                        <td>
										
										<select name="vat_ledger" required id="vat_ledger" class="form-control" tabindex="3" >
											<option></option>

                      						<? foreign_relation('accounts_ledger','ledger_id','CONCAT(ledger_id, ": ", ledger_name)',$vat_ledger,'ledger_group_id = 220306 ');?>
                   						</select></td>
                                      </tr>
									  
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>TDS Ledger:</td>

                                        <td>
										
										<select name="tds_ledger" required id="tds_ledger" class="form-control" tabindex="3" >
											<option></option>

                      						<? foreign_relation('accounts_ledger','ledger_id','CONCAT(ledger_id, ": ", ledger_name)',$tds_ledger,'ledger_group_id = 220307 ');?>
                   						</select></td>
                                      </tr>
									  
									  
							
							
									<tr>

                                        <td>TIN No:</td>

                                        <td><input name="tin_no" type="text" id="tin_no" tabindex="6" value="<?=$tin_no?>"  autocomplete="off"  class="form-control"/></td>
                                      </tr>
									  
									  <tr>

                                        <td>BIN No:</td>

                                        <td><input name="bin_no" type="text" id="bin_no" tabindex="6" value="<?=$bin_no?>"  autocomplete="off"  class="form-control"/></td>
                                      </tr>
									  
									  
									  <tr>

                                        <td>Proprietor's Name:</td>

                                        <td><input name="propritor_name" type="text" id="propritor_name" tabindex="6" value="<?=$propritor_name?>"  autocomplete="off"  class="form-control"/></td>
                                      </tr>
									  
									  
									  
									   <tr>

                                        <td>Mobile No:</td>

                                        <td><input name="mobile_no" type="text" id="mobile_no" tabindex="6" value="<?=$mobile_no?>"  autocomplete="off"  class="form-control"/></td>
                                      </tr>

                                      <tr>

                                        <td>E-mail:</td>

                                        <td><input name="email" type="text" id="email" tabindex="7" value="<?=$email?>" autocomplete="off"  class="form-control">
						
						
					
						
						
						 <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_SESSION['user']['id']?>"  class="form-control"/></td>
                                      </tr>
									  



									  
									  <tr>

                                        <td> Address:</td>

                                        <td><input name="address" type="text" id="address" tabindex="8" value="<?=$address?>" autocomplete="off"  class="form-control"></td>
									  </tr>
									  
									  
									 

                                      

                                      <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for" class="form-control" tabindex="9" >

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>
					
					<input name="depot" type="hidden" id="depot" tabindex="20" value="1" autocomplete="off"  class="form-control"/>
					
					</td>
                                      </tr>
             

                                      
									  
									  
									  
									  <tr>

                                        <td>Status:</td>

                                        <td><select name="status" id="status" class="form-control"  tabindex="10">

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="ACTIVE">ACTIVE</option>

                                          <option value="INACTIVE">INACTIVE</option>


                                        </select></td>

                                      </tr>

									  

									  

								

									  

                                     

                                      <!--<tr>

                                        <td> CR No:</td>

                                        <td><input name="cr_no" type="text" id="cr_no" tabindex="9" value="<?=$cr_no?>"></td>
                                      </tr>

                                      <tr>

                                        <td> CR Upload:</td>

                                        <td><input style="padding:5px 5px 7px 5px;" name="cr_upload" type="file" id="cr_upload" value="<?=$cr_upload?>" /></td>
                                      </tr>-->
									  
									  
									  
									  
									  

                                    

                                      

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
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn btn-primary" tabindex="11" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn btn-success" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn btn-success" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
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