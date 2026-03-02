<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Employee Basic Info';		// Page Name and Page Title
$page="employee_basic_information.php";		// PHP File Name
$input_page="employee_basic_information_input.php";
$root='hrm';

$table='personnel_basic_info';		// Database Table Name Mainly related to this page
$unique='PBI_ID';			// Primary Key of this Database table
$shown='PBI_FATHER_NAME';	

do_calander('#PBI_DOB');
do_calander('#PBI_DOJ_PP');
do_calander('#PBI_DOC');
do_calander('#PBI_DOC2');
do_calander('#PBI_DOJ');
do_calander('#PBI_APPOINTMENT_LETTER_DATE');
do_calander('#JOB_STATUS_DATE');

// ::::: End Edit Section :::::


$crud      =new crud($table);

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		$path='../../pic/staff';
				$_POST['pic']=image_upload($path,$_FILES['pic']);
				$_POST['PBI_ID']=$_SESSION['employee_selected'];
				$crud->insert();
				$type=1;
				$msg='New Entry Successfully Inserted.';
				unset($_POST);
				unset($$unique);
$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
		}
	//for Modify..................................
	if(isset($_POST['update']))
	{
				$path='../../pic/staff';
				$_POST['pic']=image_upload($path,$_FILES['pic']);
				$crud->update($unique);
				$type=1;
	}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}
    function add_date(cd)
	{
		var arr=cd.split('-');
		var mon = (arr[1]*1)+6;
		var day = (arr[2]*1);
		var yr =  (arr[0]*1);
		if(mon>12)
		{
			mon = mon-12;
			yr  = yr+1;
		}
		var con_date = yr+'-'+mon+'-'+day;
		document.getElementById('PBI_DOC').value=con_date;
	}
    </script>
    <style type="text/css">
<!--
.style1 {font-weight: bold}
-->
    </style>
    

<form action="" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
                      <? include('../../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table width="801" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody><tr class="oe_form_group_row">
            <td colspan="1" class="oe_form_group_cell" width="100%"><table width="794" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="23%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Code :</strong></td>
                  <td bgcolor="#E8E8E8" width="23" colspan="2" class="oe_form_group_cell">
                    <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="PBI_ID" type="text" id="PBI_ID" value="<?=$PBI_ID?>"/></td>
                  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Organization :</span></strong></td>
                  <td bgcolor="#E8E8E8" width="31%" class="oe_form_group_cell"><select name="PBI_ORG">
                    <? foreign_relation('user_group','id','group_name',$PBI_ORG,' 1');?>
                    </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>
                    <label>&nbsp; Name :</label>
                  </strong></td>
                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_NAME" type="text" id="PBI_NAME" value="<?=$PBI_NAME?>" required/></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department :</span></strong></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><select name="PBI_DEPARTMENT">
                    <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT,' 1 order by DEPT_DESC');?>
                    </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Father's Name : </strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell">
                    
                    <input name="PBI_FATHER_NAME" type="text" id="PBI_FATHER_NAME" value="<?=$PBI_FATHER_NAME?>" required/>                  </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Section :</span></strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_DOMAIN">
                    <? foreign_relation('PBI_Section','sec_id','sec_name',$PBI_PROJECT,' 1 order by sec_id');?>
                  </select></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Mother's Name :</strong></td>
                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_MOTHER_NAME" type="text" id="PBI_MOTHER_NAME" value="<?=$PBI_MOTHER_NAME?>" required/></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Region : </span></strong></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><select name="PBI_BRANCH" id="PBI_BRANCH" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                    <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');?>
                    </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Designation :</strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_DESIGNATION">
                    <? foreign_relation('designation','DESG_ID','DESG_DESC',$PBI_DESIGNATION,'1 order by DESG_DESC');?>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
                    <input name="PBI_DESG_GRADE" type="text" id="PBI_DESG_GRADE" value="<?=find_a_field("designation","DESG_GRADE","DESG_SHORT_NAME='".$PBI_DESIGNATION."'",'1 order by DESG_DESC');?>" style="width:30px;" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Sub Region : </span></strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_SUB_REGION" id="PBI_SUB_REGION" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                      <? foreign_relation('sub_region','SUB_REGION_CODE','SUB_REGION_NAME',$PBI_SUB_REGION,' 1 order by SUB_REGION_NAME');?>
                  </select></td>
				  
				  
				  
				  
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Date of Birth :</strong></td>
                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_DOB" type="text" id="PBI_DOB" value="<?=$PBI_DOB?>" required/></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Zone : <br />
                  </span></strong></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><span id="zone">
                    <select name="PBI_ZONE" id="PBI_ZONE"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');?>
                    </select>
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Place of Birth (District) :</strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_POB">
                    <option value="<?=$PBI_POB?>">
                      <?=$PBI_POB?>
                      </option>
                    <? foreign_relation('district_list','district_name','district_name',$PBI_POB,' 1 order by district_name');?>
                  </select></td>
                  <td class="oe_form_group_cell" bgcolor="#E8E8E8"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Area : </span></strong></td>
                  <td class="oe_form_group_cell" bgcolor="#E8E8E8"><span id="area">
                    <select name="PBI_AREA" id="PBI_AREA">
                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                    </select>
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Initial Joining Date :</strong></td>
                  <td colspan="2" bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="PBI_DOJ" type="text" id="PBI_DOJ" value="<?=$PBI_DOJ?>"  onchange="add_date(this.value)"/></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Group : </span></strong></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><select name="PBI_GROUP" id="PBI_GROUP">
                      <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <!--<td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Due Confirmation Date :</strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_DOC" type="text" class="style1" id="PBI_DOC" value="<?=$PBI_DOC?>" /></td>-->
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell_label oe_form_group_cell"><strong>&nbsp;&nbsp;Blood Group:</strong></span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong>
                            <select name="PBI_BLOOD_GROUP">
                              <option selected="selected">
                                <?=$PBI_BLOOD_GROUP?>
                                </option>
                              <option>A(+ve)</option>
                              <option>A(-ve)</option>
                              <option>AB(+ve)</option>
                              <option>AB(-ve)</option>
                              <option>B(+ve)</option>
                              <option>B(-ve)</option>
                              <option>O(+ve)</option>
                              <option>O(-ve)</option>
                              <option>N/I</option>
                            </select>
                          </strong></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Extended Upto :</strong></td>
                  <td colspan="2" bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="extended_upto" type="text" id="extended_upto" value="<?=$extended_upto?>" />
                    Days</td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Total Service Length:</span></strong></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="PBI_SERVICE_LENGTH" type="text" id="PBI_SERVICE_LENGTH" value="<?=$PBI_SERVICE_LENGTH?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Confirmation Date :</strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_DOC2" type="text" id="PBI_DOC2" value="<?=$PBI_DOC2?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Edu Qualification :</span></strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_EDU_QUALIFICATION">
                    <? foreign_relation('edu_qua','EDU_QUA_SHORT_NAME','EDU_QUA_SHORT_NAME',$PBI_EDU_QUALIFICATION,' 1 order by EDU_QUA_SHORT_NAME');?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Joining Date(PP):</strong></td>
                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_DOJ_PP" type="text" id="PBI_DOJ_PP" value="<?=$PBI_DOJ_PP?>" /></td>
                  <td class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Service Length (PP) :</span></strong></td>
                  <td class="oe_form_group_cell"><input name="PBI_SERVICE_LENGTH_PP" type="text" id="PBI_SERVICE_LENGTH_PP" value="<?=$PBI_SERVICE_LENGTH_PP?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Appointment Letter :</strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_APPOINTMENT_LETTER_NO" type="text" id="PBI_APPOINTMENT_LETTER_NO" value="<?=$PBI_APPOINTMENT_LETTER_NO?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Appointment Date :</span></strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_APPOINTMENT_LETTER_DATE" type="text" id="PBI_APPOINTMENT_LETTER_DATE" value="<?=$PBI_APPOINTMENT_LETTER_DATE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Gender :</strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_SEX" required>
                    <option selected><?=$PBI_SEX?></option>
                    <option>Male</option>
                    <option>Female</option>
                    </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Marital Status :</span></strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_MARITAL_STA" required>
                    <option selected="selected">
                      <?=$PBI_MARITAL_STA?>
                      </option>
                    <option>Married</option>
                    <option>Unmarried</option>
                    </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Religion : </strong></td>
                  <td colspan="2" class="oe_form_group_cell"><select name="PBI_RELIGION" required>
                    <option selected>
                      <?=$PBI_RELIGION?>
                      </option>
                    <option>Islam</option>
                    <option>Bahai</option>
                    <option>Buddhism</option>
                    <option>Christianity</option>
                    <option>Confucianism </option>
                    <option>Druze</option>
                    <option>Hinduism</option>
                    <option>Jainism</option>
                    <option>Judaism</option>
                    <option>Shinto</option>
                    <option>Sikhism</option>
                    <option>Taoism</option>
                    <option>Zoroastrianism</option>
                    <option>Others</option>
                  </select></td>
                  <td class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Nationality : </span></strong></td>
                  <td class="oe_form_group_cell"><select name="PBI_NATIONALITY" required>
                    <option selected="selected">
                    <?=$PBI_NATIONALITY?>
                    </option>
                    <option>Bangladeshi</option>
                    <option>Canadian</option>
                    <option>English</option>
                    <option>Indian</option>
                    <option>Pakistani</option>
                    <option>Nepali</option>
                    
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Permanent Add :</strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_PERMANENT_ADD" type="text" id="PBI_PERMANENT_ADD" value="<?=$PBI_PERMANENT_ADD?>" required/></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Area of expertise :</span></strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                    <input name="PBI_SPECIALTY" type="text" id="PBI_SPECIALTY" value="<?=$PBI_SPECIALTY?>" />
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Present Add :</strong></td>
                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_PRESENT_ADD" type="text" id="PBI_PRESENT_ADD" value="<?=$PBI_PRESENT_ADD?>" required/></td>
                  <td class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>
                      <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>Institutes :</strong></td>
                  <td class="oe_form_group_cell"><select name="institute_id" id="institute_id">
                    <? foreign_relation('institute','institute_id','institute_name',$institute_id);?>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Mobile :</strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_MOBILE" type="text" id="PBI_MOBILE" value="<?=$PBI_MOBILE?>" required/></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span> <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>Present file Status :</strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="personal_file_status" id="personal_file_status">
                    <option selected="selected">
                      <?=$personal_file_status?>
                      </option>
                      <option></option>
                    <option>Disciplinary Action</option>
                    <option>Separation</option>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Phone :</strong></td>
                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_PHONE" type="text" id="PBI_PHONE" value="<?=$PBI_PHONE?>" /></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span> <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>Job Location :</strong></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell">
				  <select name="JOB_LOCATION" id="JOB_LOCATION">
				  <? foreign_relation('warehouse','warehouse_name','warehouse_name',$JOB_LOCATION,'use_type!="PL"');?>
                  </select>                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;E-mail :</strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_EMAIL" type="text" id="PBI_EMAIL" value="<?=$PBI_EMAIL?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Job Status :</span></strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
                  <select name="PBI_JOB_STATUS">
                    <option <?=($PBI_JOB_STATUS=='In Service')?'selected':'';?>>In Service</option>
                    <option <?=($PBI_JOB_STATUS=='Not In Service')?'selected':'';?>>Not In Service</option>
                  </select></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;National ID :</strong></td>
                  <td colspan="2" class="oe_form_group_cell"><input name="nid" type="text" id="nid" value="<?=$nid?>" required/></td>
                  <td class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Job Status Date :</span></strong></td>
                  <td class="oe_form_group_cell"><input name="JOB_STATUS_DATE" type="text" id="JOB_STATUS_DATE" value="<?=$JOB_STATUS_DATE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Initial Job Type :</strong></td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PBI_PRIMARY_JOB_STATUS">
                    <option selected><?=$PBI_PRIMARY_JOB_STATUS?></option>
						<option>Permanent</option>
                        <option>Project Staff</option>
						<option>Contract Based</option>
                        <option>Work Based</option>
                        <option>Bigenner</option>
                        <option>Entry Level</option>
						<option>Mid Level</option>
                        <option>Top Level</option>
                        
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Staff Picture :</span></strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="file" name="pic" id="pic" accept="image/jpeg" /></td>
                </tr>
                </tbody></table></td>
            <td colspan="1" class="oe_form_group_cell oe_group_right" width="100%">&nbsp;</td>
            </tr></tbody></table></div>
			
			
                      </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
        </div>
  </div>
  
  
  
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>