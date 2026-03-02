<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

do_calander('#expire_date');

$tr_type = "Show";
$title   = 'Customer Information';
do_datatable('vendor_table');

$page      = "dealer_info_entry.php";
$page_info = "dealer_info.php";
$table     = 'dealer_info';
$unique    = 'dealer_code';
$shown     = 'dealer_name_e';

$user_group_define = find_a_field('company_define','GROUP_CONCAT(company_id ORDER BY company_id ASC)','user_id="'.$_SESSION['user']['id'].'" and status="Active"');

function createSubLedger($code,$name,$tr_from,$tr_id,$ledger_id,$type,$group_for){
    $insert = 'insert into general_sub_ledger set '
        .'sub_ledger_id="'.$code.'",'
        .'sub_ledger_name="'.$name.'",'
        .'tr_from="'.$tr_from.'",'
        .'tr_id="'.$tr_id.'",'
        .'ledger_id="'.$ledger_id.'",'
        .'type="'.$type.'",'
        .'entry_at="'.date('Y-m-d H:i:s').'",'
        .'entry_by="'.$_SESSION['user']['id'].'",'
        .'group_for="'.$group_for.'"';
    db_query($insert);
    return db_insert_id();
}

$crud    = new crud($table);
$$unique = $_GET[$unique];

if(isset($_POST[$shown]))
{
    $$unique = $_POST[$unique];

    /* -- INSERT -- */
    if(isset($_POST['insert']) && $_SESSION['csrf_token'] === $_POST['csrf_token'])
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $_POST['entry_by'] = $_SESSION['user']['id'];
        $_POST['entry_at'] = date('Y-m-d h:i:s');

        $folder = 'customer';

        $field = 'tin'; $file_name = $field.'-'.$_POST['dealer_code'];
        if($_FILES['tin']['tmp_name'] != ''){ $_POST['tin'] = upload_file($folder,$field,$file_name); $tr_type = "Add"; }

        $field = 'trade'; $file_name = $field.'-'.$_POST['dealer_code'];
        if($_FILES['trade']['tmp_name'] != ''){ $_POST['trade'] = upload_file($folder,$field,$file_name); }

        $field = 'bin'; $file_name = $field.'-'.$_POST['dealer_code'];
        if($_FILES['bin']['tmp_name'] != ''){ $_POST['bin'] = upload_file($folder,$field,$file_name); }

        $field = 'cheque'; $file_name = $field.'-'.$_POST['dealer_code'];
        if($_FILES['cheque']['tmp_name'] != ''){ $_POST['cheque'] = upload_file($folder,$field,$file_name); }

        $custome_codes = find_a_field('dealer_info','max(sub_ledger_id)','1');
        $custome_code  = ($custome_codes > 0) ? $custome_codes + 1 : 10000001;

        $_POST['account_code']  = $_POST['ledger_id'];
        $_POST['sub_ledger_id'] = $custome_code;
        $_POST['ledger_name']   = $_POST['dealer_name_e'];

        $tr_type = "Add";
        $ledger_gl_found = find_a_field('general_sub_ledger','sub_ledger_id','sub_ledger_name='.$_POST['ledger_name']);
        if($ledger_gl_found == 0){
            createSubLedger($custome_code,$_POST['dealer_name_e'],'dealer',$_POST[$unique],$_POST['account_code'],$_POST['dealer_type'],$_POST['group_for']);
        }

        $crud->insert();
        $last_id = db_insert_id();

        $type = 1;
        $msg  = 'New Entry Successfully Inserted.';
        unset($_POST);
        unset($$unique);
        ?>
        <script>window.location.href = "dealer_info_entry.php?dealer_code=<?=$last_id;?>";</script>
        <?php
    }

    /* -- UPDATE -- */
    if(isset($_POST['update']))
    {
        $tr_type = "update";

        $folder = 'customer';
        if($_FILES['tin']['tmp_name']    != ''){ $_POST['tin']    = upload_file($folder,'tin',   'tin-'.$_POST['dealer_code']); }
        if($_FILES['trade']['tmp_name']  != ''){ $_POST['trade']  = upload_file($folder,'trade', 'trade-'.$_POST['dealer_code']); }
        if($_FILES['bin']['tmp_name']    != ''){ $_POST['bin']    = upload_file($folder,'bin',   'bin-'.$_POST['dealer_code']); }
        if($_FILES['cheque']['tmp_name'] != ''){ $_POST['cheque'] = upload_file($folder,'cheque','cheque-'.$_POST['dealer_code']); }

        $_POST['edit_at'] = date('Y-m-d H:i:s');
        $_POST['edit_by'] = $_SESSION['user']['id'];

        $crud->update($unique);

        $sub_ledger_id = $_POST['sub_ledger_id'];
        db_query('update general_sub_ledger set sub_ledger_name="'.$_POST['dealer_name_e'].'",group_for="'.$_POST['group_for'].'" where sub_ledger_id='.$sub_ledger_id);

        $type    = 1;
        $msg     = 'Successfully Updated.';
        $tr_type = "Add";
    }

    /* -- DELETE -- */
    if(isset($_POST['delete'])){
        $condition = $unique."=".$$unique;
        $crud->delete($condition);
        unset($$unique);
        $tr_type = "Delete";
        $type    = 1;
        $msg     = 'Successfully Deleted.';
    }
}

if(isset($$unique)){
    $condition = $unique."=".$$unique;
    $data = db_fetch_object($table,$condition);
    foreach($data as $key=>$value){ $$key = $value; }
}
if(!isset($$unique)) $$unique = db_last_insert_id($table,$unique);

$gr_all               = find_all_field('config_group_class','*','group_for='.$_SESSION['user']['group']);
$dealer_ledg_group_id = $gr_all->receivable;
?>

<style>
.h_titel{ padding:0!important; font-size:12px!important; font-weight:600; }
</style>

<div class="form-container_large">
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

<!-- ------- TAB NAV ------- -->
<div class="row p-0 m-0">
  <div class="col-lg-12 p-0">

    <div class="mt-3 mb-0" style="zoom:77%;visibility:visible;border-radius:0!important;border:0!important;background:#fff;box-shadow:none!important;">
      <ul class="nav new-sr nav-pills">
        <li class="nav-item">
          <a class="nav-link active" href="#" data-toggle="tab" data-target="#tab_1" style="color:#333;font-weight:bold">
            <i class="fa-solid fa-pen-to-square"></i> GENERAL INFO
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="tab" data-target="#tab_ac" style="color:#333;font-weight:bold">
            <i class="fa-solid fa-building-columns"></i> BANKING INFO
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="tab" data-target="#tab_2" style="color:#333;font-weight:bold">
            <i class="fa-solid fa-business-time"></i> KEY CONTACT PERSONS
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="tab" data-target="#tab_6" style="color:#333;font-weight:bold">
            <i class="fa-regular fa-folder-open"></i> FILES UPLOAD
          </a>
        </li>
		 <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="tab" data-target="#tab_portal" style="color:#333;font-weight:bold">
            <i class="fa-solid fa-globe"></i> PORTAL ACCESS
          </a>
        </li>
      </ul>
    </div>

    <div class="tab-content" style="border:1px solid #005395;padding:0 10px;border-radius:0 0 5px 5px;">


      <!-- ------------------------------------------
           TAB 1 — GENERAL INFO
           ------------------------------------------ -->
      <div class="tab-pane fade active show" id="tab_1">
        <div class="card">
          <div class="h_titel"><center>GENERAL INFORMATION</center></div>

          <div class="container-fluid bg-form-titel">
            <div class="row">

              <!-- hidden fields -->
              <input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>">
              <input type="hidden" name="csrf_token" id="csrf_token" value="<?=$_SESSION['csrf_token']?>">
              <input type="hidden" name="group_for"  id="group_for_h" value="<?=$_SESSION['user']['group'];?>">

              <!-- Customer Name -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Customer Name:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="dealer_name_e" required type="text" id="dealer_name_e" tabindex="1" value="<?=$dealer_name_e?>">
                  </div>
                </div>
              </div>

              <!-- Proprietor Name -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Proprietor Name:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="propritor_name_e" type="text" id="propritor_name_e" tabindex="2" value="<?=$propritor_name_e?>">
                  </div>
                </div>
              </div>

              <!-- Customer Type -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Customer Type:</label>
                  <div class="col-sm-8 p-0">
                    <select name="dealer_type" required id="dealer_type" class="vendor_label_text" tabindex="3">
                      <option></option>
                      <?php foreign_relation('dealer_type d','d.id','d.dealer_type',$dealer_type,'d.status="ACTIVE"'); ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Mobile -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Mobile:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="contact_no" type="text" id="contact_no" tabindex="4" value="<?=$contact_no?>">
                  </div>
                </div>
              </div>

              <!-- Email -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Email:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="email" type="text" id="email" tabindex="5" value="<?=$email?>">
                  </div>
                </div>
              </div>

              <!-- Region -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Region:</label>
                  <div class="col-sm-8 p-0">
                    <select name="region_code" id="region_code" class="vendor_label_text" tabindex="6"
                      onchange="getData2('dealer_zone_ajax.php','dealer_zone_find',this.value,document.getElementById('region_code').value);">
                      <option></option>
                      <?php foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$region_code,'1'); ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Zone -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Zone:</label>
                  <div class="col-sm-8 p-0">
                    <span id="dealer_zone_find">
                      <select name="zone_code" id="zone_code" class="vendor_label_text" tabindex="7"
                        onchange="getData2('dealer_area_ajax.php','dealer_area_find',this.value,document.getElementById('zone_code').value);">
                        <option></option>
                        <?php foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_code,'REGION_ID="'.$region_code.'"'); ?>
                      </select>
                    </span>
                  </div>
                </div>
              </div>

              <!-- Area -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Area:</label>
                  <div class="col-sm-8 p-0">
                    <span id="dealer_area_find">
                      <select name="area_code" id="area_code" class="vendor_label_text" tabindex="8">
                        <option></option>
                        <?php foreign_relation('area','AREA_CODE','AREA_NAME',$area_code,'ZONE_ID="'.$zone_code.'"'); ?>
                      </select>
                    </span>
                  </div>
                </div>
              </div>

              <!-- Address -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Address:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="address_e" type="text" id="address_e" tabindex="9" value="<?=$address_e?>">
                  </div>
                </div>
              </div>

              <!-- Company -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Company:</label>
                  <div class="col-sm-8 p-0">
                    <select name="group_for" id="group_for_sel" class="vendor_label_text" required>
                      <?php user_company_access($group_for); ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Depot -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Depot:</label>
                  <div class="col-sm-8 p-0">
                    <select name="depot" required id="depot" class="vendor_label_text" tabindex="10">
                      <option></option>
                      <?php foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'1 and group_for="'.$_SESSION['user']['group'].'" and use_type="WH"'); ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Status -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">Status:</label>
                  <div class="col-sm-8 p-0">
                    <select name="status" id="status" required>
                      <option value="<?=$status?>"><?=$status?></option>
                      <option value="ACTIVE">ACTIVE</option>
                      <option value="INACTIVE">INACTIVE</option>
                    </select>
                  </div>
                </div>
              </div>

            </div><!-- /row -->
          </div><!-- /container-fluid -->

          <div class="n-form-btn-class">
            <?php if(!isset($_GET[$unique])){ ?>
              <input name="insert" type="submit" id="insert_1" value="Save &amp; New" class="btn1 btn1-bg-submit">
            <?php } ?>
            <?php if(isset($_GET[$unique])){ ?>
              <input name="update" type="submit" id="update_1" value="Update" class="btn1 btn1-bg-update">
            <?php } ?>
            <input name="reset" type="button" class="btn1 btn1-bg-cancel" value="Reset" onclick="parent.location='<?=$page?>'">
          </div>

        </div>
      </div><!-- /tab_1 -->


      <!-- ------------------------------------------
           TAB AC — BANKING INFO
           ------------------------------------------ -->
      <div class="tab-pane fade" id="tab_ac">
        <div class="card">
          <div class="h_titel"><center>BANKING INFORMATION</center></div>

          <div class="container-fluid bg-form-titel">
            <div class="row">

              <!-- A/C Configuration -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text ">A/C Configuration:</label>
                  <div class="col-sm-8 p-0">
                    <?php if($account_code == 0){ ?>
                      <select class="vendor_label_text" name="ledger_id" required id="ledger_id" tabindex="20">
                        <option></option>
                        <?php foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,'ledger_group_id="'.$dealer_ledg_group_id.'"'); ?>
                      </select>
                    <?php } ?>
                    <?php if($account_code > 0){ ?>
                      <input class="vendor_label_text" name="account_code" type="text" id="account_code" tabindex="20" value="<?=$account_code?>" readonly>
                      <input type="hidden" name="sub_ledger_id" id="sub_ledger_id" value="<?=$sub_ledger_id?>">
                    <?php } ?>
                  </div>
                </div>
              </div>

              <!-- Credit Limit Applicable -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Credit Limit Applicable:</label>
                  <div class="col-sm-8 p-0">
                    <select name="credit_limit_appli" id="credit_limit_appli" class="vendor_label_text" tabindex="21">
                      <?php if($credit_limit_appli != ''){ ?>
                        <option value="<?=$credit_limit_appli?>"><?=$credit_limit_appli?></option>
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                      <?php } else { ?>
                        <option value="NO">NO</option>
                        <option value="YES">YES</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Credit Limit -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Credit Limit:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="credit_limit" type="text" id="credit_limit" tabindex="22" value="<?=$credit_limit?>">
                  </div>
                </div>
              </div>

              <!-- Acc Verification -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Acc Verification:</label>
                  <div class="col-sm-8 p-0">
                    <select name="bank_reconsila" id="bank_reconsila" class="vendor_label_text" tabindex="23">
                      <?php if($bank_reconsila != ''){ ?>
                        <option value="<?=$bank_reconsila?>"><?=$bank_reconsila?></option>
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                      <?php } else { ?>
                        <option value="NO">NO</option>
                        <option value="YES">YES</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>

            </div><!-- /row -->
          </div><!-- /container-fluid -->

          <div class="n-form-btn-class">
            <?php if(!isset($_GET[$unique])){ ?>
              <input name="insert" type="submit" id="insert_ac" value="Save &amp; New" class="btn1 btn1-bg-submit">
            <?php } ?>
            <?php if(isset($_GET[$unique])){ ?>
              <input name="update" type="submit" id="update_ac" value="Update" class="btn1 btn1-bg-update">
            <?php } ?>
            <input name="reset" type="button" class="btn1 btn1-bg-cancel" value="Reset" onclick="parent.location='<?=$page?>'">
          </div>

        </div>
      </div><!-- /tab_ac -->


      <!-- ------------------------------------------
           TAB 2 — KEY CONTACT PERSONS
           ------------------------------------------ -->
      <div class="tab-pane fade" id="tab_2">
        <div class="card">
          <div class="h_titel"><center>KEY CONTACT PERSONS</center></div>
          <div class="container-fluid bg-form-titel">
            <div class="row">

              <!-- Contact Person -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="contact_person_name" type="text" id="contact_person_name" tabindex="30" value="<?=$contact_person_name?>">
                  </div>
                </div>
              </div>

              <!-- Job Title -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Job Title:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="contact_person_designation" type="text" id="contact_person_designation" tabindex="31" value="<?=$contact_person_designation?>">
                  </div>
                </div>
              </div>

              <!-- Contact Person Phone -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Phone:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="contact_person_mobile" type="text" id="contact_person_mobile" tabindex="32" value="<?=$contact_person_mobile?>">
                  </div>
                </div>
              </div>

            </div><!-- /row -->
          </div><!-- /container-fluid -->

          <div class="n-form-btn-class">
            <?php if(!isset($_GET[$unique])){ ?>
              <input name="insert" type="submit" id="insert_2" value="Save &amp; New" class="btn1 btn1-bg-submit">
            <?php } ?>
            <?php if(isset($_GET[$unique])){ ?>
              <input name="update" type="submit" id="update_2" value="Update" class="btn1 btn1-bg-update">
            <?php } ?>
            <input name="reset" type="button" class="btn1 btn1-bg-cancel" value="Reset" onclick="parent.location='<?=$page?>'">
          </div>

        </div>
      </div><!-- /tab_2 -->



      <!-- ------------------------------------------
           TAB 6 — FILES UPLOAD
           ------------------------------------------ -->
      <div class="tab-pane fade" id="tab_6">
        <div class="card">
          <div class="h_titel"><center>Customer File Upload</center></div>
          <div class="card-body new-color">

            <div class="row">
              <div class="col-md-3 form-group">
                <label for="tin">TIN Certificate :</label>
                <input type="file" name="tin" id="tin" class="pt-1 pb-1 pl-1">
              </div>
              <div class="col-md-3 form-group">
                <label for="trade">Trade License :</label>
                <input type="file" name="trade" id="trade" class="pt-1 pb-1 pl-1">
              </div>
              <div class="col-md-3 form-group">
                <label for="bin">BIN Certificate :</label>
                <input type="file" name="bin" id="bin" class="pt-1 pb-1 pl-1">
              </div>
              <div class="col-md-3 form-group">
                <label for="cheque">Blank Cheque :</label>
                <input type="file" name="cheque" id="cheque" class="pt-1 pb-1 pl-1">
              </div>
            </div>

            <div class="container-fluid n-form1">
              <div class="row">

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
                  <label class="container bg-form-titel-text">TIN Certificate:</label>
                  <div class="container vendor_info_img">
				  <?php if($tin !=''){ ?>
                    <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$tin?>&folder=customer&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">
                      <img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$tin?>&folder=customer&proj_id=<?=$_SESSION['proj_id']?>" />
                    </a>
					<? } else{?>
						 <img src="<?=SERVER_ROOT?>public/assets/images/tin.png" />
					<? } ?>
                  </div>
                </div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
				<label class="container bg-form-titel-text">Trade License:</label>
				<div class="container vendor_info_img">
					<?php if (!empty($trade)) { ?>
						<a href="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $trade ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>" target="_blank">
							<img src="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $trade ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>" />
						</a>
					<?php } else { ?>
						<img src="<?= SERVER_ROOT ?>public/assets/images/trade.png" />
					<?php } ?>
				</div>
			</div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
				<label class="container bg-form-titel-text">BIN Certificate:</label>
				<div class="container vendor_info_img">
					<?php if (!empty($bin)) { ?>
						<a href="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $bin ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>" target="_blank">
							<img src="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $bin ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>" />
						</a>
					<?php } else { ?>
						<img src="<?= SERVER_ROOT ?>public/assets/images/bin11.png" />
					<?php } ?>
				</div>
			</div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
				<label class="container bg-form-titel-text">Blank Cheque:</label>
				<div class="container vendor_info_img">
					<?php if (!empty($cheque)) { ?>
						<a href="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $cheque ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>" target="_blank">
							<img src="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $cheque ?>&folder=customer&proj_id=<?= $_SESSION['proj_id'] ?>" />
						</a>
					<?php } else { ?>
						<img src="<?= SERVER_ROOT ?>public/assets/images/bcheque.png" />
					<?php } ?>
				</div>
			</div>

              </div>
            </div>

          </div><!-- /card-body -->

          <div class="n-form-btn-class">
            <?php if(!isset($_GET[$unique])){ ?>
              <input name="insert" type="submit" id="insert_6" value="Save &amp; New" class="btn1 btn1-bg-submit">
            <?php } ?>
            <?php if(isset($_GET[$unique])){ ?>
              <input name="update" type="submit" id="update_6" value="Update" class="btn1 btn1-bg-update">
            <?php } ?>
            <input name="reset" type="button" class="btn1 btn1-bg-cancel" value="Reset" onclick="parent.location='<?=$page?>'">
          </div>

        </div>
      </div><!-- /tab_6 -->
	  
	  
      <!-- ------------------------------------------
           TAB PORTAL — VENDOR PORTAL
           ------------------------------------------ -->
      <div class="tab-pane fade" id="tab_portal">
        <div class="card">
          <div class="h_titel"><center>PORTAL ACCESS</center></div>
          <div class="container-fluid bg-form-titel">
            <div class="row">

              <!-- User Name -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">User Name:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="dealer_code2" type="text" id="dealer_code2" tabindex="40" value="<?=$dealer_code2?>">
                  </div>
                </div>
              </div>

              <!-- Password -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Password:</label>
                  <div class="col-sm-8 p-0">
                    <input class="vendor_label_text" name="password" type="text" id="password" tabindex="41" value="<?=$password?>">
                  </div>
                </div>
              </div>

              <!-- Expire Date -->
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">
                <div class="form-group row m-0">
                  <label class="col-sm-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Expire Date:</label>
                  <div class="col-sm-8 p-0">
                    <input class="expire_date vendor_label_text" name="expire_date" type="text" id="expire_date" tabindex="42" value="<?=$expire_date?>" autocomplete="off">
                  </div>
                </div>
              </div>

            </div><!-- /row -->
          </div><!-- /container-fluid -->

          <div class="n-form-btn-class">
            <?php if(!isset($_GET[$unique])){ ?>
              <input name="insert" type="submit" id="insert_portal" value="Save &amp; New" class="btn1 btn1-bg-submit">
            <?php } ?>
            <?php if(isset($_GET[$unique])){ ?>
              <input name="update" type="submit" id="update_portal" value="Update" class="btn1 btn1-bg-update">
            <?php } ?>
            <input name="reset" type="button" class="btn1 btn1-bg-cancel" value="Reset" onclick="parent.location='<?=$page?>'">
          </div>

        </div>
      </div><!-- /tab_portal -->


    </div><!-- /tab-content -->
  </div>
</div>

</form>
</div><!-- /form-container_large -->


<script>
$(document).ready(function () {

    /* -- Tab switching -- */
    $('.nav-pills .nav-link').on('click', function (e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.nav-pills .nav-link').removeClass('active');
        $(this).addClass('active');
        $('.tab-content .tab-pane').removeClass('active show');
        $(target).addClass('active show');
    });
    $('.nav-pills .nav-link.active').first().trigger('click');

    /* -- File chosen feedback -- */
    $('input[type="file"]').on('change', function(){
        var fname = this.files[0] ? this.files[0].name : '';
        if(fname){
            $(this).siblings('.file-chosen').remove();
            $(this).after('<small class="file-chosen" style="color:#005395;display:block;margin-top:3px;word-break:break-all;">'+fname+'</small>');
        }
    });

    /* -- Block Enter (except textarea) -- */
    $(document).on('keypress', function(e){
        if(e.which === 13 && e.target.tagName !== 'TEXTAREA') return false;
    });

});
</script>

<?php require_once SERVER_CORE."routing/layout.bottom.php"; ?>?>