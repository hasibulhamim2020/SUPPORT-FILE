<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




function next_ledger_ids($group_id)

{

$max=($group_id*100000)+100000;

$min=($group_id*100000);

$s='select max(ledger_id) from accounts_ledger where ledger_id>'.$min.' and ledger_id<'.$max;
$new_acc_no=find_a_field_sql($s);



if($new_acc_no>0)

$new_acc_no=$new_acc_no+1;

else

$new_acc_no=$min+1;

return $new_acc_no;

}




// ::::: Edit This Section ::::: 



$title='ADD Dealer Information';			// Page Name and Page Title

$page="dealer_info.php";		// PHP File Name



$table='dealer_info';		// Database Table Name Mainly related to this page

$unique='dealer_code';			// Primary Key of this Database table

$shown='dealer_name_e';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$_POST['area_name'] = find_a_field('area','AREA_NAME','AREA_CODE='.$_POST['area_code']);

$_POST['zone_name'] = find_a_field('zon','ZONE_NAME','ZONE_CODE='.$_POST['zone_code']);

$_POST['region_name'] = find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$_POST['region_code']);


$crud->insert();

   $acc_query='INSERT INTO accounts_ledger(ledger_id, ledger_name, ledger_group_id, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent)VALUES ("'.$_POST['account_code'].'","'.trim($_POST['dealer_name_e']).'",10206,0.00,"Both", 0.00, 0.00,"CloudERP","NO", 2, 0)';

db_query($acc_query);




$id = $_POST['dealer_code'];
		
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
header('Location:../dealer/dealer_info.php');

}





//for Modify..................................



if(isset($_POST['update']))

{
		$crud->update($unique);

$id = $_POST['dealer_code'];
		
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
    
	header('Location:../dealer/dealer_info.php');
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

<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<?php /*?><div class="form-container_large">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--<td valign="top"><div class="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div class="tabledesign" style="height:787px;">
                <? 	$res='select '.$unique.','.$unique.','.$shown.' as dealer_name, account_code  from '.$table;

											echo $crud->link_report($res,$link);?>
              </div>
               </td>
          </tr>
        </table>
      </div></td>--->
	  
	  
	
	  
    <td valign="top"><?php */?>
	
	
	<form action="" method="post"  enctype="multipart/form-data" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2"><fieldset>
                     <!-- <legend>
                      <?=$title?>
                      </legend>--->
                      <div> </div>
                      <div class="buttonrow"></div>
					  
					  
			
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Dealer Code:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
    
		 <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
          <input name="dealer_code" type="text" class="form-control" id="dealer_code" tabindex="1" value="<?=$dealer_code?>"  required>
      </div>
    </div>
  </div>
  
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label">Dealer Name</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <input name="dealer_name_e" class="form-control" type="text" id="dealer_name_e" tabindex="2" value="<?=$dealer_name_e?>">
      </div>
    </div>
  </div>
		
		
	<div class="form-group row">

    <label for="inputPassword3MD" class="col-sm-2 col-form-label">Propritor's name</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
    <input name="propritor_name_e" type="text" class="form-control" id="propritor_name_e" tabindex="2" value="<?=$propritor_name_e?>">
      </div>
    </div>
  </div>	
  
  
  <div class="form-group row">

    <label for="inputPassword3MD" class="col-sm-2 col-form-label">Dealer Type:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
       <select name="dealer_type" class="form-control" id="dealer_type"  required >
                          <option></option>
                          <? foreign_relation('dealer_type','id','dealer_type',$dealer_type);?>
                          
                    </select>
      </div>
    </div>
  </div>
  
  
  <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Address</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
    <input name="address_e" type="text" id="dealer_name_e" class="form-control"  value="<?=$address_e?>">
      </div>
    </div>
  </div>	
  
  
  <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">National ID:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
    <input name="national_id" type="text" class="form-control" id="national_id" tabindex="6" value="<?=$national_id?>">
      </div>
    </div>
  </div>
  
    <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Depot Name:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
      <select name="depot" required id="depot" class="form-control">
        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>
         </select>
      </div>
    </div>
  </div>	
  
  
    <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Mobile No:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
    <input name="mobile_no" type="text" id="mobile_no" class="form-control" value="<?=$mobile_no?>">
      </div>
    </div>
  </div>
  
    <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Commission:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
     <input name="commission" type="text" id="commission" class="form-control" value="<?=$commission?>">
      </div>
    </div>
  </div>
  
  
   <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Accounts Ledger:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
	  	<?php 
         $last_id=find_a_field('dealer_info','max(dealer_code)','1')+1;
           ?>

     <input name="account_code" type="text" class="form-control" readonly id="account_code" value="<?php if($$unique==$last_id){
      echo $account_code=next_ledger_ids('10206'); } else { echo $account_code;}?>" />
      </div>
    </div>
  </div>	
  
  
    <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Division:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <select name="region_code" class="form-control" required id="region_code">
			<option></option>
       <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$region_code,'1');?>
       </select>
      </div>
    </div>
  </div>
  
  
      <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Zone:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <select name="zone_code" required id="zone_code" class="form-control">
					  <option></option>

                   	   <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_code,'1');?>
                    </select>
      </div>
    </div>
  </div>
  
      <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Territory:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
            <select name="area_code" id="area_code" class="form-control">

                      <? 

					  $sql = 'select a.AREA_CODE,a.AREA_NAME,z.ZONE_NAME,b.BRANCH_NAME from area a,zon z, branch b where a.ZONE_ID = z.ZONE_CODE and z.REGION_ID = b.BRANCH_ID order by a.AREA_NAME';

					  $res=db_query($sql);

					  echo '<option></option>';

					  while($d = mysqli_fetch_row($res)){

if($area_code==$d[0])

echo '<option value="'.$d[0].'" selected>'.$d[1].' [Zone: '.$d[2].'] [Region: '.$d[3].']</option>';

else

echo '<option value="'.$d[0].'">'.$d[1].' [Zone: '.$d[2].'] [Region: '.$d[3].']</option>';

					  }

					  ?>
                    </select>
      </div>
    </div>
  </div>				   
			   

					  

					  
					  
					  <!--<div>
                      <label>DSM Name:</label>
                      <select name="DSM_ID"  id="DSM_ID" style="width:200px;" tabindex="7">
					  <option></option>

                   	   <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$DSM_ID,'PBI_DESIGNATION=5');?>
                    </select>
                      </div>
					  
					  <div>
                      <label>ZSM Name:</label>
                      <select name="ZSM_ID"  id="ZSM_ID" style="width:200px;" tabindex="7">
					  <option></option>

                   	   <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$ZSM_ID,'PBI_DESIGNATION=6');?>
                    </select>
                      </div>
					  
					  <div>
                      <label>TSM Name:</label>
                      <select name="TSM_ID"  id="TSM_ID" style="width:200px;" tabindex="7">
					  <option></option>

                   	   <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$TSM_ID,'PBI_DESIGNATION=7');?>
                    </select>
                      </div>
					  -->
					  

     <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Status:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <select name="canceled" id="canceled" class="form-control">

                      <option <?=($canceled=='Yes')?'Selected':'';?>>Yes</option>

                      <option <?=($canceled=='No')?'Selected':'';?> >No</option>
                    </select>
      </div>
    </div>
  </div>


                      <div></div>
                    </fieldset></td>
                
                </tr>
               <!-- <tr>
                <td colspan="2"><a href="../../pp_pic/pp/<?=$dealer_code?>.jpg" target="_blank"><img src="../../pp_pic/pp/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="Propiter Photo" /></a></td>
                        </tr>
                        <tr>
                        <td><span class="oe_form_group_cell oe_form_group_cell_label"><label>Propritor Photo:</label></span></td>
                        <td> <input style="padding:5px 5px 7px 5px;" name="pp" type="file" id="pp" value="<?=$pp?>" /> </td>
                        </tr>
                       <tr>
                        <td colspan="3"><a href="../../np_pic/np/<?=$dealer_code?>.jpg" target="_blank"><img src="../../np_pic/np/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="nominee photo" /></a></td>
                  </tr>
                        <tr>
                        <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><label>Nominee Photo:</label></span></td>
                        <td> <input style="padding:5px 5px 7px 5px;" name="np" type="file" id="np" value="<?=$np?>" /> </td>
                        </tr>
                        <tr>
                        <td colspan="3"><a href="../../spp_pic/spp/<?=$dealer_code?>.jpg" target="_blank"><img src="../../spp_pic/spp/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="vendor Trade lisence" /></a></td>
                        </tr>
                        <tr>
                        <td><span class="oe_form_group_cell oe_form_group_cell_label"><label>Propritor's Signature:</label></span></td>
                        <td> <input style="padding:5px 5px 7px 5px;" name="spp" type="file" id="spp" value="<?=$spp?>" /> </td>
                </tr>
                <tr>
                        <td colspan="3"><a href="../../nsp_pic/nsp/<?=$dealer_code?>.jpg" target="_blank"><img src="../../nsp_pic/nsp/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="vendor Trade lisence" /></a></td>
                        </tr>
                        <tr>
                        <td><label>Nominee's Signature</label></td>
                        <td> <input style="padding:5px 5px 7px 5px;" name="nsp" type="file" id="nsp" value="<?=$nsp?>" /> </td>
                </tr>-->

                
              </table></td>
          </tr>
          <tr>
            <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="Save" class="btn btn-success" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="Update" class="btn btn-primary" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn btn-info" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                    </div></td>
                  <td>
                  <!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->
                    </td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form>
	  
<!--	  
	  
	  </td>
  </tr>
</table>
</div>-->
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
