<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




function next_ledger_ids($group_id)

{

$max=($group_id*1000000000000)+1000000000000;

$min=($group_id*1000000000000)-1;

$s='select max(ledger_id) from accounts_ledger where ledger_id>'.$min.' and ledger_id<'.$max;

$sql=db_query($s);

if(mysqli_num_rows($sql)>0)

$data=mysqli_fetch_row($sql);

else

$acc_no=$min;

if(!isset($acc_no)&&(is_null($data[0]))) 

$acc_no=$cls;

else

$acc_no=$data[0]+100000000;

return $acc_no;

}




// ::::: Edit This Section ::::: 

$input_page="dealer_info_input.php"; $add_button_bar = 'Mhafuz';

$title='ADD Dealer Information';			// Page Name and Page Title

$page="dealer_info_input.php"; 		// PHP File Name



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

  $acc_query='INSERT INTO accounts_ledger(ledger_id, ledger_name, ledger_group_id, opening_balance, balance_type, depreciation_rate, credit_limit, opening_balance_on, proj_id, budget_enable, group_for, parent, acc_code, ledger_type) 



VALUES ("'.$_POST['account_code'].'","'.trim($_POST['dealer_name_e']).'",1004,0.00,"Both", 0.00, 0.00,'.strtotime(date("Y-m-d H:i:s")).',"philips","NO", 2, 0, 0, 0)';

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

<script type="text/javascript"> function DoNav(lk){
	window.open('../../pages/dealer<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk);
	}</script>


<!--<header>
<span class="oe_form_buttons_edit" style="display: inline;">
<a href="dealer_info_input.php"><button name="insert" accesskey="S" class="oe_button oe_form_button_save  btn btn-success" type="button">Add New</button></a>
</span>

<span class="oe_form_buttons_edit" style="display: inline;">
<button name="reset" class="oe_button oe_form_button btn btn-warning" type="button" onclick="parent.location='dealer_info.php'">Refresh</button>
</span>

<div class="oe_clear"></div></header>-->


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
   
 <!--   <td valign="top"><form action="" method="post"  enctype="multipart/form-data" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2"><fieldset>
                      <legend>
                      <?=$title?>
                      </legend>
                      <div> </div>
                      <div class="buttonrow"></div>
                      <div>
                        <label> Dealer Code:</label>
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                        <input name="dealer_code" type="text" id="dealer_code" tabindex="1" value="<?=$dealer_code?>"  required>
                      </div>
					  
					   
					  
                      <div>
                        <label> Dealer Name :</label>
                        <input name="dealer_name_e" type="text" id="dealer_name_e" tabindex="2" value="<?=$dealer_name_e?>">
                      </div>
                      <div>
                      <label>Propritor's name</label>
                      <input name="propritor_name_e" type="text" id="propritor_name_e" tabindex="2" value="<?=$propritor_name_e?>">
                      </div>
                      <div></div>
                      <div>
                        <label>Dealer Type:</label>
                        <select name="dealer_type"  id="dealer_type" style="width:150px;"  required >
                          <option></option>
                          <? foreign_relation('dealer_type','id','dealer_type',$dealer_type);?>
                          
                        </select>
                      </div>
                      <div>
                        <label> Address:</label>
                        <input name="address_e" type="text" id="dealer_name_e" tabindex="4" value="<?=$address_e?>">
                      </div>
                      <div>
                        <label> National ID:</label>
                        <input name="national_id" type="text" id="national_id" tabindex="6" value="<?=$national_id?>">
                      </div>
                      <div>
                      <label>Depot Name:</label>
                      <select name="depot" required id="depot" style="width:200px;" tabindex="7">

                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>
                    </select>
                      </div>
                      <div>
                        <label> Mobile No:</label>
                        <input name="mobile_no" type="text" id="mobile_no" tabindex="8" value="<?=$mobile_no?>">
                      </div>
                      <div>
                        <label> Commission:</label>
                        <input name="commission" type="text" id="commission" tabindex="9" value="<?=$commission?>">
                      </div>
					  
					  
                    
					  
					  
					  
					  <div>



                        <label>Accounts Ledger:</label>



						<?php 

						$last_id=find_a_field('dealer_info','max(dealer_code)','1')+1;

						?>



                        <input name="account_code" type="text" readonly id="account_code" value="<?php if($$unique==$last_id){



						echo $account_code=next_ledger_ids('1004');



						} else {



						echo $account_code;}?>" />

                      </div>
					  
					  
					  
					  
					  <div>
                      <label>Division:</label>
                      <select name="region_code" required id="region_code" style="width:200px;" tabindex="7">
					  <option></option>

                   	   <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$region_code,'1');?>
                    </select>
                      </div>
					  
					  
					  <div>
                      <label>Zone:</label>
                      <select name="zone_code" required id="zone_code" style="width:200px;" tabindex="7">
					  <option></option>

                   	   <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_code,'1');?>
                    </select>
                      </div>
					  
					  
                      <div>
                      <label>Territory:</label>
                      <select name="area_code" id="area_code" style="width:200px;" tabindex="11">

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
					  
					  
                      <div></div>
<div>
  <label>Status:</label>
                        <select name="canceled" id="canceled"  style="width:150px;" tabindex="12">

                      <option <?=($canceled=='Yes')?'Selected':'';?>>Yes</option>

                      <option <?=($canceled=='No')?'Selected':'';?> >No</option>
                    </select>
                    </div>
                      <div></div>
                    </fieldset></td>
                
                </tr>
              

                
              </table></td>
          </tr>
          <tr>
            <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="Save" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="Update" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                    </div></td>
                  <td>
                  <div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>
                    </td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form></td>-->
 
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
