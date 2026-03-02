<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Vendor Information';			// Page Name and Page Title

do_datatable('vendor_table');

$page="vendor_info.php";		// PHP File Name



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

//if ($_POST['dealer_found']==0) {}
	

$proj_id			= $_SESSION['proj_id'];

$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');

//$wh_data = find_all_field('warehouse','','warehouse_id='.$_POST['depot']); 

$_POST['ledger_group_id']=$_POST['ledger_group'];

$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%05d", $cy_id);


$_POST['ledger_id'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$_POST['ledger_name'] = $_POST['vendor_name'];


$crud->insert();


$ledger_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);

if ($ledger_gl_found==0) {
   $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)
  
  VALUES("'.$_POST['ledger_id'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$_POST['group_for'].'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';

db_query($acc_ins_led);
}
		
		
	
		
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
		 $ledger_id = $_POST['ledger_id'];

	  $sql1 = 'update accounts_ledger set ledger_name="'.$_POST['vendor_name'].'" 
	  where ledger_id = '.$ledger_id;
		db_query($sql1);




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

								 								  <tr>

								    <td><div class="box"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box style2" style="width:100%;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF; text-transform:uppercase;" bgcolor="#45777B"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>
								
						
                                  <td width="100%" colspan="2"><div class="box" style="width:100%; font-size:12px;">
								  
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  		<tr>
											<td width="6%"><span class="style1" style="padding-top:5px;">*</span>Vendor Name:</td>
											<td width="10%"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
											
											<input name="group_for" required type="hidden" id="group_for" tabindex="1" value="<?=$_SESSION['user']['group'];?>" style="width: 95%;">

                                        <input name="vendor_name" required type="text" id="vendor_name" tabindex="1" value="<?=$vendor_name?>" style="width: 95%; font-size:12px;"></td>
											<td width="6%">Vendor Company:</td>
											
											<td width="10%"><input name="vendor_company" type="text" id="vendor_company" tabindex="2" value="<?=$vendor_company?>"  style="width:95%; font-size:12px;"/></td>
											
											<td width="6%"><span class="style1" style="padding-top:5px;">*</span>Vendor Category:</td>
											<td width="10%"><select name="vendor_category" required id="vendor_category" style="width:95%; font-size:12px;" tabindex="3">
										<option></option>
                    					  <? foreign_relation('vendor_category','id','category_name',$vendor_category,'1');?>
                    					</select></td>
										</tr>
										
										
										<tr>
											<td width="6%">Main Phone:</td>
											<td width="10%"><input name="contact_no" type="text" id="contact_no" tabindex="4" value="<?=$contact_no?>"  style="width:95%; font-size:12px;"/></td>
											<td width="6%">SMS Phone:</td>
											
											<td width="10%"><input name="sms_mobile_no" type="text" id="sms_mobile_no" tabindex="5" value="<?=$sms_mobile_no?>" style="width:95%; font-size:12px;" /></td>
											
											<td width="6%">Fax No:</td>
											<td width="10%"><input name="fax_no" type="text" id="fax_no" tabindex="6" value="<?=$fax_no?>"  style="width:95%; font-size:12px;"/></td>
										</tr>
										
										
										<tr>
											<td width="6%">Main Email:</td>
											<td width="10%"><input name="email" type="text" id="email" tabindex="7" value="<?=$email?>" style="width:95%; font-size:12px;" /></td>
											<td width="6%">CC Email:</td>
											
											<td width="10%"><input name="cc_email" type="text" id="cc_email" tabindex="8" value="<?=$cc_email?>" style="width:95%; font-size:12px;"  /></td>
											
											<td width="6%"><span class="style1" style="padding-top:5px;">*</span>A/C Configuration (GL):</td>
											<td width="10%">
											
											<? if ($ledger_id==0) {?>
											<select name="ledger_group" required="required" id="ledger_group" style="width:95%; font-size:12px;" tabindex="9">
	
											  <option></option>
                                              <? foreign_relation('ledger_group','group_id','group_name',$ledger_group,'acc_sub_class=203');?>
                                            </select>
											<? }?>
											
											<? if ($ledger_id>0) {?>
											<input name="ledger_id" type="text" id="ledger_id" tabindex="9" value="<?=$ledger_id?>"  readonly="" style="width:95%; font-size:12px;" />
											<? }?>
											</td>
										</tr>
										
										
										<tr>
											<td width="6%">Beneficiary Name:</td>
											<td width="10%"><input name="beneficiary_name"  type="text" id="beneficiary_name" tabindex="10" value="<?=$beneficiary_name?>" style="width: 95%; font-size:12px;" /></td>
											<td width="6%">Beneficiary Bank:</td>
											
											<td width="10%"><input name="beneficiary_bank" type="text" id="beneficiary_bank" tabindex="11" value="<?=$beneficiary_bank?>"  style="width:95%; font-size:12px;"/></td>
											
											<td width="6%">Account No:</td>
											<td width="10%"><input name="beneficiary_bank_ac" type="text" id="beneficiary_bank_ac" tabindex="12" value="<?=$beneficiary_bank_ac?>"  style="width:95%; font-size:12px;"/></td>
										</tr>
										
										
										<tr>
											<td width="6%"> Swift Code:</td>
											<td width="10%"><input name="swift_code" type="text" id="swift_code" tabindex="13" value="<?=$swift_code?>" style="width:95%; font-size:12px;" /></td>
											<td width="6%">Address:</td>
											
											<td width="10%"><input name="address" type="text" id="address" tabindex="14" value="<?=$address?>"  style="width:95%; font-size:12px;"/></td>
											
											<td width="6%">Country:</td>
											<td width="10%"><input name="country" type="text" id="country" tabindex="15" value="<?=$country?>"  style="width:95%; font-size:12px;"/></td>
										</tr>
										
										<tr>
											<td width="6%">Contact Person:</td>
											<td width="10%"><input name="contact_person_name" type="text" id="contact_person_name" tabindex="16" value="<?=$contact_person_name?>" style="width:95%; font-size:12px;" /></td>
											<td width="6%">Job Title:</td>
											
											<td width="10%"><input name="contact_person_designation" type="text" id="contact_person_designation" tabindex="17" value="<?=$contact_person_designation?>" style="width:95%; font-size:12px;" /></td>
											
											<td width="6%">Contact Person Phone:</td>
											<td width="10%"><input name="contact_person_mobile" type="text" id="contact_person_mobile" tabindex="18" value="<?=$contact_person_mobile?>" style="width:95%; font-size:12px;" /></td>
										</tr>
										
										<tr>
											<td width="6%">&nbsp;</td>
											<td width="10%">&nbsp;</td>
											<td width="6%">&nbsp;</td>
											
											<td width="10%">&nbsp;</td>
											
											<td width="6%">&nbsp;</td>
											<td width="10%">&nbsp;</td>
										</tr>
										
										
								  </table>
								  
								  
								  
								  

                                    

                                  </div></td>
                                </tr>

                                

                                

                                <tr>

                                  <td colspan="2">

								  <div class="box1">

								    <table width="60%" border="0" cellspacing="0" align="right" cellpadding="0">

								      <tr>
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE &amp; NEW" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
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

    </form></div></td>
						      </tr>

								   <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="vendor_table" class="table table-bordered" cellspacing="0" style="font-size:12px;">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">ID</span></th>

<th bgcolor="#45777B"><span class="style3">Vendor Name </span></th>

<th bgcolor="#45777B"><span class="style3">GL Code</span></th>
<th bgcolor="#45777B"><span class="style3">Address</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['depot']!="")

$con .= 'and a.depot="'.$_POST['depot'].'"';






  $td='select a.'.$unique.',  a.'.$shown.' as vendor_name,   a.address, a.ledger_id from '.$table.' a, user_group u
				where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'"    '.$con.' order by a.vendor_id ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');" bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
  <td><?=$rp[0];?></td>

<td><?=$rp[1];?></td>

<td><?=$rp[3];?></td>
<td><?=$rp[2];?></td>
</tr>

<?php }?>
</tbody>
</table>

<? //}?>

									<div id="pageNavPosition"></div>									</td>

								  </tr>
		</table>



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