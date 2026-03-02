<?php



session_start();



ob_start();



require "../../support/inc.all.php";







// ::::: Edit This Section ::::: 







$title='ADD Via Customer Information';			// Page Name and Page Title



$page="customer_info.php";		// PHP File Name







$table='customer_info';		// Database Table Name Mainly related to this page



$unique='customer_code';			// Primary Key of this Database table



$shown='customer_name_e';				// For a New or Edit Data a must have data field





auto_complete_from_db('dealer_info','dealer_name_e','dealer_code','','dealer_code');

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

$_POST['entry_by'] =$entry_by;

$_POST['entry_at']=$now;







$crud->insert();



$id = $_POST['customer_code'];

		

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



$id = $_POST['customer_code'];

		

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



<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}







function popUp(URL) 



{



day = new Date();



id = day.getTime();



eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");



}



</script>



<div class="form-container_large">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"><div class="left">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td>&nbsp;</td>

          </tr>

          <tr>

            <td><div class="tabledesign" style="height:787px;">

                <? 	$res='select '.$unique.','.$unique.','.$shown.',propritor_name_e   from '.$table;
											echo $crud->link_report($res,$link);?>

              </div>

              <?=paging(50);?></td>

          </tr>

        </table>

      </div></td>

    <td valign="top"><form action="" method="post"  enctype="multipart/form-data" >

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

                        <label> Customer Code:</label>

                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                        <input name="customer_code" type="text" id="customer_code" tabindex="1" value="<?=$customer_code?>" readonly>

                      </div>

                      <div>

                        <label> Customer Name (E):</label>

                        <input name="customer_name_e" type="text" id="customer_name_e" tabindex="2" value="<?=$customer_name_e?>">

                      </div>

                      <div>

                      <label>Under Dealer: </label>

                      <input name="dealer_code" type="text" id="dealer_code" tabindex="2" value="<?=$dealer_code?>">

                      </div>

                      <div>

                      <label>Propritor's name</label>

                      <input name="propritor_name_e" type="text" id="propritor_name_e" tabindex="2" value="<?=$propritor_name_e?>">

                      </div>

                      <div></div>

                      <div>

                        <label>Customer Type:</label>

                        <select name="customer_type" required id="customer_type" style="width:150px;" tabindex="3">

                          <option <?=($customer_type=='Distributor')?'selected':'';?>>Distributor</option>

                          <option <?=($customer_type=='SRIHA COOL MAT')?'selected':'';?>>SRIHA COOL MAT</option>

                         <!-- <option <?=($customer_type=='Corporate')?'selected':'';?>>Corporate</option>-->

                        </select>

                      </div>

                      <div>

                        <label> Address:</label>

                        <input name="address" type="text" id="address" tabindex="4" value="<?=$address?>">

                      </div>

                      <div>

                        <label> Mobile No:</label>

                        <input name="mobile_no" type="text" id="mobile_no" tabindex="8" value="<?=$mobile_no?>">

                      </div>

                      

					  

					  

					  

					  

					  <div>

                      <label>Area: </label>

                      <select name="area_code" id="area_code" style="width:150px;" tabindex="11">



                      <? 



					  $sql = 'select * from area';


					//$area_code = $_POST['area_code'];
					  $res=db_query($sql);



					  echo '<option></option>';



					  while($d = mysqli_fetch_row($res)){



if($area_code==$d[0])



echo '<option value="'.$d[0].'" selected>'.$d[1].'</option>';



else



echo '<option value="'.$d[0].'">'.$d[1].'</option>';



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

                  <!--<div class="button">

                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>

                    </div>-->

                    </td>

                </tr>

              </table></td>

          </tr>

        </table>

      </form></td>

  </tr>

</table>

</div>

<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>

