<?

session_start();
ini_set('max_execution_time', 60);
ini_set('memory_limit', '512M');

set_time_limit(0);
//$msc=microtime(true);

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

date_default_timezone_set('Asia/Dhaka');

date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['name']!='')
	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';
	
	if($_POST['domain']!='')
	$con.=' and a.PBI_DOMAIN = "'.$_POST['domain'].'"';
	if($_POST['department']!='')
	$con.=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';
	if($_POST['project']!='')
	$con.=' and a.PBI_PROJECT = "'.$_POST['project'].'"';
	if($_POST['designation']!='')
	$con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';
	if($_POST['zone']!='')
	$con.=' and a.PBI_ZONE = "'.$_POST['zone'].'"';
	
	if($_POST['area']!='')
	$con.=' and a.PBI_AREA = "'.$_POST['area'].'"';
	if($_POST['branch']!='')
	$con.=' and a.PBI_BRANCH = "'.$_POST['branch'].'"';
	
	if($_POST['code_class']!='')
	$con.=' and a.PBI_ID like "'.$_POST['code_class'].'%"';
	
	if($_POST['job_status']!='')
	$con.=' and a.PBI_JOB_STATUS = "'.$_POST['job_status'].'"';

	if($_POST['personal_file_status']!='')
	$con.=' and a.personal_file_status = "'.$_POST['personal_file_status'].'"';

	if($_POST['PBI_SPECIALTY']!='')
	$con.=' and a.PBI_SPECIALTY = "'.$_POST['PBI_SPECIALTY'].'"';

	if($_POST['age']!='')
	$con.=' and a.PBI_DOB < "'.(date('Y')-$_POST['age']).'-'.date('m').'-'.date('d').'"';
		
	if($_POST['gender']!='')
	$con.=' and a.PBI_SEX = "'.$_POST['gender'].'"';
	
	if($_POST['ijdb']!='')
	$con.=' and a.PBI_DOJ < "'.$_POST['ijdb'].'"';
	if($_POST['ppjdb']!='')
	$con.=' and a.PBI_DOJ_PP < "'.$_POST['ppjdb'].'"';
    if($_POST['PBI_JOB_STATUS']!='')
    $con.=' and a.PBI_JOB_STATUS = "'.$_POST['PBI_JOB_STATUS'].'"';
    if($_POST['ijda']!='')
    $con.=' and a.PBI_DOJ > "'.$_POST['ijda'].'"';
	if($_POST['ppjda']!='')
	$con.=' and a.PBI_DOJ_PP > "'.$_POST['ppjda'].'"';
	if($_POST['edu_qua']!='')
	$con.=' and a.PBI_EDU_QUALIFICATION = "'.$_POST['edu_qua'].'"';
	
	if($_POST['region']!='')
	$con.=' and a.PBI_REGION = "'.$_POST['region'].'"';
	if($_POST['blood_group']!='')
	$con.=' and a.ESSENTIAL_BLOOD_GROUP = "'.$_POST['blood_group'].'"';
	

	if($_POST['employee_type']!='')
	$con.=' and a.employee_type = "'.$_POST['employee_type'].'"';
	
	if($_POST['functional_designation']!='')
	$con.=' and a.functional_designation = "'.$_POST['functional_designation'].'"';

	if($_POST['DESG_GRADE1']>0&&$_POST['DESG_GRADE2']>0)
	$con.=" and a.PBI_DESG_GRADE between '".$_POST['DESG_GRADE1']."' and '".$_POST['DESG_GRADE2']."'";
	
switch ($_POST['report']) {
case 1:
$report="Employee Basic Information";

$sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_FATHER_NAME as father_name,a.PBI_SEX as Gender,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.PBI_PROJECT as project	,a.PBI_DESIGNATION as designation ,a.PBI_DESG_GRADE as grade,a.PBI_ZONE as zone,a.PBI_AREA as area,a.PBI_BRANCH as branch,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date  from personnel_basic_info a where	1 ".$con." order by PBI_DESG_GRADE asc, a.PBI_DOJ_PP asc";
break;

    case 2:
	$report="Educational Qualification";

         $sql="SELECT PBI_EDU_QUALIFICATION as educational_qualification, count( PBI_EDU_QUALIFICATION ) as count
FROM `personnel_basic_info` a where 1 ".$con."
GROUP BY PBI_EDU_QUALIFICATION
ORDER BY `PBI_EDU_QUALIFICATION` ASC";
		break;
	    case 3:
	$report="Designation Wise Count";

         $sql="SELECT PBI_DESG_GRADE as Grade,PBI_DESIGNATION as designation, count( PBI_DESIGNATION ) as count
FROM `personnel_basic_info` a where 1 ".$con."
GROUP BY PBI_DESIGNATION
ORDER BY `PBI_DESG_GRADE` ASC";
		break;
		
case 4:
$report="Employee Action Report";

$sql="select a.PBI_ID ,a.PBI_NAME,a.PBI_DESIGNATION ,a.PBI_DOMAIN,a.PBI_DEPARTMENT,b.action_category as category,c.action_subject as subject,ac.memo_no,ac.issued_date,ac.effect_date,ac.amount,ac.type,ac.m_mitigated as M_Status from action_management ac, action_category b, action_subject c, personnel_basic_info a where a.PBI_ID = ac.PBI_ID and ac.category_id=b.id and ac.subject_id=c.id ".$con;
break;


case 5:
$report="Not In Service Report";

$sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_FATHER_NAME as father_name,a.PBI_SEX as Gender,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.PBI_PROJECT as project	,a.PBI_DESG_GRADE as grade,a.PBI_ZONE as zone,a.PBI_AREA as area,a.PBI_BRANCH as branch,a.PBI_DOJ as joining_date,a.PBI_separation_type as type_of_seperation,a.resign_date as PP_joining_date  from personnel_basic_info a where	1 ".$con." and PBI_JOB_STATUS='Not In Service'";
break;
case 6:
$report="Employee Reinstatement Report ";

$sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_FATHER_NAME as father_name,a.PBI_SEX as Gender,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.PBI_PROJECT as project	,a.PBI_DESG_GRADE as grade,a.PBI_ZONE as zone,a.PBI_AREA as area,a.PBI_BRANCH as branch,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,

ac.issue_date,ac.effect_date,ac.duration_of_LWP from reinstatement_status ac, personnel_basic_info a where a.PBI_ID = ac.PBI_ID ".$con;
break;

case 7:
$report="PF Status Report ";

$sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation, a.PBI_DESG_GRADE as grade, a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.PBI_PROJECT as project	,a.PBI_ZONE as zone,a.PBI_AREA as area,a.PBI_BRANCH as branch,
PF_STATUS_CV as CV,EPF_STATUS_MC as Medical_Certificate, PF_STATUS_APPOINTMENT_LETTER as Appointment_Letter,PF_STATUS_C_CERTIFICATE as Clearance_Certificate,PF_STATUS_SM_RECITE as Security_Money_Receipt, PF_STATUS_JOINING_LETTER as Joining_Letter,PF_STATUS_R_AYA_A as Received_Aya_Allowance,PF_STATUS_E_AFFIDAVIT as Employee_Affidavit ,PF_STATUS_POSTING_LETTER as Posting_Letter,PF_STATUS_G_AFFIDAVIT as Affidavit_of_Guardian,	


	PF_STATUS_G_CERTIFY_LETTER as Guardian_Certify_Letter,
	
	PF_STATUS_G_PHOTO as Nominee_Guardian_Photo,PF_STATUS_NOMINEE_PHOTO as Nominee_Photo,	
	
	PF_STATUS_NOMINEE,RECEIVED_CERTIFICATE as Received_Certificate,EMPLOYEE_VARIFICATION_FORM as Employee_Verification_Form,PF_STATUS as PF_Status

from pf_status ac, personnel_basic_info a where a.PBI_ID = ac.PBI_ID ".$con." order by a.PBI_DESG_GRADE";
break;
case 8:
$report="Educational Qualification Report";

$sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation, a.PBI_DESG_GRADE as grade, a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.PBI_ZONE as zone,a.PBI_AREA as area,a.PBI_BRANCH as branch,a.PBI_EDU_QUALIFICATION as qualification , 

	EDUCATION_NOE as name_of_Exam,EDUCATION_SUBJECT as subject, EDUCATION_YEAR as year,	EDUCATION_GROUP as `group`,EDUCATION_NOI as institute_Name, EDUCATION_BU as board

from education_detail ac, personnel_basic_info a where a.PBI_ID = ac.PBI_ID ".$con." order by a.PBI_ID,ac.EDUCATION_D_ID";
break;
case 9:
$report="Employee Wise Health Check Up and Personal Asset Info";
	 
$sqld = 'select * from health_checkup_information where 1';
$queryd = db_query($sqld);
while($info = mysqli_fetch_object($queryd)){
$healthyear[$info->PBI_ID] = $info->year;
$healthstatus[$info->PBI_ID] = $info->status;
$healthdescription[$info->PBI_ID] = $info->description;
$healthtest_date[$info->PBI_ID] = $info->test_date;
$healthconditions[$info->PBI_ID] = $info->conditions;
$healthcertify[$info->PBI_ID] = $info->certify;
$healthcount[$info->PBI_ID] = $healthcount[$info->PBI_ID] + 1;
}
$sqld = 'select * from personal_asset_information where 1';
$queryd = db_query($sqld);
while($info = mysqli_fetch_object($queryd)){
$assetyear[$info->PBI_ID] = $info->year;
$assetstatus[$info->PBI_ID] = $info->status;
$assetdescription[$info->PBI_ID] = $info->description;
$assetcount[$info->PBI_ID] = $asset['count'][$info->PBI_ID] + 1;
}
	
	$qqq="select a.PBI_ID,a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOB,a.PBI_SEX as Gender,a.PBI_JOB_STATUS 	as job_status,a.remarks from personnel_basic_info a where 1 ".$con;
	
	$query=db_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">';
	$out.='<thead><tr>
	<th rowspan="2">SL</th>
	<th rowspan="2">ID</th>
	<th rowspan="2">Name</th>
	<th rowspan="2">Persent Designation</th>
	<th rowspan="2">Grade</th>
	<th rowspan="2">Domain</th>
	<th rowspan="2">Department</th>
	<th rowspan="2">Job Location</th>
	<th rowspan="2">Joining Date</th>
	<th rowspan="2">Joining Date Of PP</th>
	<th rowspan="2">Total Service Length</th>
	<th rowspan="2">Service Length Of PP</th>
	<th rowspan="2">Present Age</th>
	<th colspan="6">Health Checkup Info</th>
	<th colspan="3">Personal Asset Information</th>
	<th rowspan="2">Job Status</th>
	</tr>
	<tr>
	    <th>Year</th>
	    <th>Date of Test</th>
	    <th>Status</th>
	    <th>Condition Date:</th>
	    <th>Doctor Certify</th>
	    <th>Description</th>
	    <th>Year</th>
	    <th>Status</th>
	    <th>Description</th>
      </tr></thead><tbody>';
	
	$sl=0;
	while($data=mysqli_fetch_object($query))
	{ 
	$sl++;
	if(date('m')>substr($data->cross_year,5,2))	$cross_year=(date('Y')-substr($data->cross_year,0,4));
	else $cross_year=(date('Y')-substr($data->cross_year,0,4))-1;
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->ID.'</td>
	<td>'.$data->Name.'</td>
	<td>'.$data->persent_designation.'</td>
	<td>'.$data->grade.'</td>
	<td>'.$data->Domain.'</td>
	<td>'.$data->department.'</td>
	<td>'.$data->job_location.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<td>'.Date2age($data->PBI_DOB).'</td>

	<td>'.$healthyear[$data->PBI_ID].'</td>
	<td>'.$healthstatus[$data->PBI_ID].'</td>
	<td>'.$healthdescription[$data->PBI_ID].'</td>
	<td>'.$healthtest_date[$data->PBI_ID].'</td>
	<td>'.$healthconditions[$data->PBI_ID].'</td>
	<td>'.$healthcertify[$data->PBI_ID].'</td>
	<td>'.$assetyear[$data->PBI_ID].'</td>
	<td>'.$assetstatus[$data->PBI_ID].'</td>
	<td>'.$assetdescription[$data->PBI_ID].'</td>
	<td>'.$data->job_status.'</td>';
	$out.='</tr>';}
	
	$out.='</tbody></table>';

break;
    case 101:
	$year=$_POST['year'];
	$report="Total APR Form - ".$year;
	
	
	$year=$_POST['year'];
	$resql = "select d_r_promotion,PBI_ID,APR_YEAR from apr_detail where APR_YEAR=".$year." group by PBI_ID";
	$requery = db_query($resql);
	while($reinfo = mysqli_fetch_object($requery))
	{
	$recon[$reinfo->PBI_ID] = $reinfo->d_r_promotion;
	}
		$qqq="select a.PBI_ID ,a.PBI_NAME,a.PBI_DESIGNATION ,a.PBI_DESG_GRADE,a.PBI_SEX,a.PBI_DOB,a.PBI_DOMAIN,a.PBI_DEPARTMENT,a.JOB_LOCATION,a.PBI_ZONE,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_JOB_STATUS,a.remarks,b.APR_MARKS as m_2012,b.social_work_marks as sw_2012,b.d_r_increment,b.hr_r_increment,b.d_r_promotion,b.APR_STATUS from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID  and b.APR_YEAR = '".$year."' order by a.PBI_ID";
	
	$query=db_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	
	<th>Gender</th>
	<th>Age</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	
	<th>Zone</th>
	<th>1st Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Cross Year</th>
	
	<th>APR SW Marks '.$year.'</th>
	<th>APR SW Marks '.($year-1).'</th>
	<th>APR SW Marks '.($year-2).'</th>
	<th>Total SW Marks</th>
	
	<th>APR Marks '.$year.'</th>
	<th>APR Marks '.($year-1).'</th>
	<th>APR Marks '.($year-2).'</th>
	<th>Average Marks</th>
	
	<th>Department Recomandation for Increment</th>
	<th>HR-M Recomandation for Increment</th>
	<th>Department Recomandation for Promotion</th>
	
	<th>Status</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($data=mysqli_fetch_object($query))
	{
	$refound = 0;
	if($_POST['d_r_promotion']=='')	$refound = 1;
	if($_POST['d_r_promotion']==$recon[$data->PBI_ID]) $refound = 2;
	if($refound>0){
	$sl++;
	$info->m_2010=0;
	$info->m_2011=0;
	
	$sss='select social_work_marks,APR_MARKS,APR_YEAR from apr_detail where PBI_ID="'.$data->PBI_ID.'" and (APR_YEAR="'.($year-1).'" or APR_YEAR="'.($year-2).'")';
	$ss=db_query($sss);
	while($s=mysqli_fetch_object($ss))
	{
		if($s->APR_YEAR==($year-1)) {$info->m_2011=$s->APR_MARKS;$info->sw_2011=$s->social_work_marks;}
		if($s->APR_YEAR==($year-2)) {$info->m_2010=$s->APR_MARKS;$info->sw_2010=$s->social_work_marks;}
	}
	if($info->m_2011>0&&$info->m_2010>0)
	$avg=number_format((($data->m_2012+$info->m_2011+$info->m_2010)/3),1);
	elseif($info->m_2011>0&&$info->m_2010<1)
	$avg=number_format((($data->m_2012+$info->m_2011)/2),1);
	elseif($info->m_2011<1&&$info->m_2010>0)
	$avg=number_format((($data->m_2012+$info->m_2010)/2),1);
	else
	$avg=$data->m_2012;
	
	
	if(substr($data->service_length_of_PP,4)=='-01-01')
	$cross_year=($year-substr($data->service_length_of_PP,0,4)+1);
	else
	$cross_year=($year-substr($data->service_length_of_PP,0,4));
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->PBI_ID.'</td>
	<td>'.$data->PBI_NAME.'</td>
	<td>'.$data->PBI_DESIGNATION.'</td>
	<td>'.$data->PBI_DESG_GRADE.'</td>
	<td>'.$data->PBI_SEX.'</td>
	<td>'.Date2ageNew($data->PBI_DOB,$year).'</td>
	<td>'.$data->PBI_DOMAIN.'</td>
	<td>'.$data->PBI_DEPARTMENT.'</td>
	<td>'.$data->JOB_LOCATION.'</td>
	<td>'.$data->PBI_ZONE.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<td>'.$cross_year.'</td>
	
	
	<th>'.$data->sw_2012.'</th>
	<th>'.$info->sw_2011.'</th>
	<th>'.$info->sw_2010.'</th>
	<th>'.($data->sw_2012+$info->sw_2011+$info->sw_2010).'</th>
	
	<th>'.$data->m_2012.'</th>
	<th>'.$info->m_2011.'</th>
	<th>'.$info->m_2010.'</th>
	<th>'.$avg.'</th>
	<th>'.$data->d_r_increment.'</th>
	<th>'.$data->hr_r_increment.'</th>
	<th>'.$data->d_r_promotion.'</th>
	<td>'.$data->APR_STATUS.'</td>
	<td>'.$data->PBI_JOB_STATUS.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}}
	
	$out.='</tbody></table>';
		break;
		    case 102:
	$report="Below Average Marks";
	
	$year=$_POST['year'];
	$resql = "select d_r_promotion,PBI_ID,APR_YEAR from apr_detail where APR_YEAR=".$year." group by PBI_ID";
	$requery = db_query($resql);
	while($reinfo = mysqli_fetch_object($requery))
	{
	$recon[$reinfo->PBI_ID] = $reinfo->d_r_promotion;
	}
	$qqq="select m.PBI_ID,avg(m.APR_MARKS) as avg_marks from apr_detail m where m.APR_YEAR in (".$year.",".($year-1).",".($year-2).") group by m.PBI_ID";
	
	$query=db_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	<th>Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Marks(AVG)</th>
	<th>Cross Year</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($info=mysqli_fetch_object($query))
	{ 
	$refound = 0;
	if($_POST['d_r_promotion']=='')	$refound = 1;
	if($_POST['d_r_promotion']==$recon[$info->PBI_ID]) $refound = 2;
	if($refound>0){
	if($_POST['markb']==''||$info->avg_marks<$_POST['markb']){
	if($_POST['marka']==''||$info->avg_marks>$_POST['marka']){
	$ppp="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_SEX as Gender,a.PBI_JOB_STATUS 	as job_status,a.remarks from personnel_basic_info a where a.PBI_ID='".$info->PBI_ID."' ".$con;
	$pquery=db_query($ppp);
	while($data=mysqli_fetch_object($pquery)){
	$sl++;
	if(date('m')>substr($data->cross_year,5,2))	$cross_year=(date('Y')-substr($data->cross_year,0,4));
	else $cross_year=(date('Y')-substr($data->cross_year,0,4))-1;
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->ID.'</td>
	<td>'.$data->Name.'</td>
	<td>'.$data->persent_designation.'</td>
	<td>'.$data->grade.'</td>
	<td>'.$data->Domain.'</td>
	<td>'.$data->department.'</td>
	<td>'.$data->job_location.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<th>'.$info->avg_marks.'</th>
	<td>'.$cross_year.'</td>
	<td>'.$data->job_status.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}}}}}
	
	$out.='</tbody></table>';
	
         
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 103:
	$report="Below Service Length";
	if($_POST['markb']!='')
	$con.=' and b.APR_MARKS < "'.$_POST['markb'].'"';
	
	if($_POST['marka']!='')
	$con.=' and b.APR_MARKS > "'.$_POST['marka'].'"';
	
	$year=$_POST['year'];
	$con.=' and b.APR_YEAR = "'.$year.'"';
	
	if($_POST['d_r_promotion']!='')	$con.=' and b.d_r_promotion = "'.$_POST['d_r_promotion'].'"';


			 
         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_JOB_STATUS 	as job_status,a.remarks
		 from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID ".$con;
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
	case 104:
		 
    $year=$_POST['year'];
	if($_POST['year2']!='')
	$year2=$_POST['year2'];
	else
	$year2=$_POST['year'];
	
	$report="No APR Form of Year ".$year." to ".$year2;
	
	$qqq="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_SEX as Gender,a.PBI_JOB_STATUS 	as job_status,a.remarks from personnel_basic_info a where 1 ".$con;
	
	$query=db_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	<th>Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Cross Year</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($data=mysqli_fetch_object($query))
	{ 
	$qqq="select 1 from apr_detail where PBI_ID='".$data->ID."' and APR_YEAR between '".$year."' and '".$year2."'";
	$pquery=db_query($qqq);
	$count=mysqli_num_rows($pquery);
	if($count<1){
	$sl++;
	if(date('m')>substr($data->cross_year,5,2))	$cross_year=(date('Y')-substr($data->cross_year,0,4));
	else $cross_year=(date('Y')-substr($data->cross_year,0,4))-1;
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->ID.'</td>
	<td>'.$data->Name.'</td>
	<td>'.$data->persent_designation.'</td>
	<td>'.$data->grade.'</td>
	<td>'.$data->Domain.'</td>
	<td>'.$data->department.'</td>
	<td>'.$data->job_location.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<td>'.$cross_year.'</td>
	<td>'.$data->job_status.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}}
	
	$out.='</tbody></table>';
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 105:
	$report="3 Year Up & No Recommendation of Promotion";
	
			 
    $year=$_POST['year'];
	$qqq="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_SEX as Gender,a.PBI_JOB_STATUS 	as job_status,a.remarks from personnel_basic_info a where 1 ".$con;
	
	$query=db_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	<th>Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Cross Year</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($data=mysqli_fetch_object($query))
	{ 
	$qqq="select 1 from apr_detail where APR_YEAR in (".$year.",".($year-1).",".($year-2).") and d_r_promotion = '' and PBI_ID = '".$info->PBI_ID."'";
	$pquery=db_query($qqq);
	$count=mysqli_num_rows($pquery);
	if($count<1){
	$sl++;
	if(date('m')>substr($data->cross_year,5,2))	$cross_year=(date('Y')-substr($data->cross_year,0,4));
	else $cross_year=(date('Y')-substr($data->cross_year,0,4))-1;
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->ID.'</td>
	<td>'.$data->Name.'</td>
	<td>'.$data->persent_designation.'</td>
	<td>'.$data->grade.'</td>
	<td>'.$data->Domain.'</td>
	<td>'.$data->department.'</td>
	<td>'.$data->job_location.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<td>'.$cross_year.'</td>
	<td>'.$data->job_status.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}}
	
	$out.='</tbody></table>';
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 106:
	$report="Promotion Recommend But 3Year Not Up";
	
    $year=$_POST['year'];
	$qqq="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_SEX as Gender,a.PBI_JOB_STATUS 	as job_status,a.remarks from personnel_basic_info a where 1 ".$con;
	
	$query=db_query($qqq);
	$out.='<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">';
	$out.='<thead><tr>
	<th>SL</th>
	<th>ID</th>
	<th>Name</th>
	<th>Persent Designation</th>
	<th>Grade</th>
	<th>Domain</th>
	<th>Department</th>
	<th>Job Location</th>
	<th>Joining Date</th>
	<th>Joining Date Of PP</th>
	<th>Total Service Length</th>
	<th>Service Length Of PP</th>
	<th>Cross Year</th>
	<th>Job Status</th>
	<th>Remarks</th>
	</tr></thead><tbody>';
	
	$sl=0;
	while($data=mysqli_fetch_object($query))
	{ 
	$qqq="select 1 from apr_detail where APR_YEAR in (".$year.",".($year-1).",".($year-2).") and d_r_promotion = 'Yes' and PBI_ID = '".$info->PBI_ID."'";
	$pquery=db_query($qqq);
	$count=mysqli_num_rows($pquery);
	if($count>0){
	$sl++;
	if(date('m')>substr($data->cross_year,5,2))	$cross_year=(date('Y')-substr($data->cross_year,0,4));
	else $cross_year=(date('Y')-substr($data->cross_year,0,4))-1;
	$out.='<tr>';
	$out.='<td>'.$sl.'</td>
	<td>'.$data->ID.'</td>
	<td>'.$data->Name.'</td>
	<td>'.$data->persent_designation.'</td>
	<td>'.$data->grade.'</td>
	<td>'.$data->Domain.'</td>
	<td>'.$data->department.'</td>
	<td>'.$data->job_location.'</td>
	<td>'.$data->joining_date.'</td>
	<td>'.$data->joining_date_of_PP.'</td>
	<td>'.Date2age($data->total_service_length).'</td>
	<td>'.Date2age($data->service_length_of_PP).'</td>
	<td>'.$cross_year.'</td>
	<td>'.$data->job_status.'</td>
	<td>&nbsp;</td>';
	$out.='</tr>';}}
	
	$out.='</tbody></table>';
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 108:
	$report="Over Age ".$_POST['age'];
	if($_POST['markb']!='')
	$con.=' and b.APR_MARKS < "'.$_POST['markb'].'"';
	
	if($_POST['marka']!='')
	$con.=' and b.APR_MARKS > "'.$_POST['marka'].'"';
	
	$year=$_POST['year'];
	$con.=' and b.APR_YEAR = "'.$year.'"';
			 
         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_DOB as present_age,a.PBI_JOB_STATUS 	as job_status,a.remarks
		 from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID ".$con;
		break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
		case 109:
	$report=" Already Promoted ";
	if($_POST['markb']!='')
	$con.=' and b.APR_MARKS < "'.$_POST['markb'].'"';
	
	if($_POST['marka']!='')
	$con.=' and b.APR_MARKS > "'.$_POST['marka'].'"';
	
	$year=$_POST['year'];
	$con.=' and b.APR_YEAR = "'.$year.'"';
			 
         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_DESIGNATION as persent_designation ,a.PBI_DESG_GRADE as grade,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.JOB_LOCATION as job_location,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as joining_date_of_PP, a.PBI_DOJ as total_service_length,a.PBI_DOJ_PP as service_length_of_PP,a.PBI_DOJ_PP as cross_year,a.PBI_JOB_STATUS 	as job_status,a.remarks
		 from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID and b.APR_RESULT like '%Promotion%' ".$con;
		break;
		
		    case 201:
			if($_POST['dealer_code']>0)
	$dealer_con=' and a.dealer_code="'.$_POST['dealer_code'].'"';
	        if($_POST['dealer_type']>0)
	$dealer_type_con.=' and a.dealer_type="'.$_POST['dealer_type'].'"';
	 if($_POST['depot_id']>0)
	$depot_id_con.=' and a.depot="'.$_POST['depot_id'].'"';
	if($_POST['branch_id']>0)
	$region_id_con.=' and a.region_code="'.$_POST['branch_id'].'"';
	
	$report="Customer Information";

         $sql.="select a.dealer_code as Customer_id";
		
		if($_POST['dealer_name_e']==1) $sql.= ",a.dealer_name_e as Name";
		if($_POST['propritor_name_e']==1) $sql.= ",a.propritor_name_e as propritor_name";
		if($_POST['dealer_type_code']==1) $sql.= ",t.dealer_type";
		
		
		if($_POST['contact_no']==1) $sql.= ",a.contact_no as main_phone";
		if($_POST['sms_mobile_no']==1) $sql.= ",a.sms_mobile_no as sms_phone";
		
		if($_POST['email']==1) $sql.= ",a.email as main_email";
		if($_POST['cc_email']==1) $sql.= ",a.cc_email as cc_email";
		if($_POST['region_code']==1) $sql.= ",r.BRANCH_NAME as region_name";
		if($_POST['zone_code']==1) $sql.= ",z.ZONE_NAME as ZONE_NAME";
		if($_POST['area_code']==1) $sql.= ",ar.AREA_NAME as area_name";
		if($_POST['address_e']==1) $sql.= ",a.address_e as address";
		if($_POST['credit_limit']==1) $sql.= ",a.credit_limit as credit_limit";
		if($_POST['depot']==1) $sql.= ",w.warehouse_name as warehouse_name";
		if($_POST['contact_person_name']==1) $sql.= ",a.contact_person_name as contact_person_name";
		if($_POST['contact_person_designation']==1) $sql.= ",a.contact_person_designation as contact_person_designation";
		if($_POST['contact_person_mobile']==1) $sql.= ",a.contact_person_mobile as contact_person_mobile";
		if($_POST['cc_email']==1) $sql.= ",a.cc_email as cc_email";
		if($_POST['cc_email']==1) $sql.= ",a.cc_email as cc_email";
		
		
		 $sql.= " from dealer_info a left join dealer_type t on t.id=a.dealer_type left join branch r on r.BRANCH_ID=a.region_code left join zon z on z.ZONE_CODE=a.zone_code left join warehouse w on w.warehouse_id=a.depot left join area ar on ar.AREA_CODE=a.area_code where	1 and a.group_for='".$_SESSION['user']['group']."' ".$dealer_con.$dealer_type_con.$depot_id_con.$region_id_con."";
//echo $sql;
break;
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
 	<?
	require_once "../../../controllers/core/inc.exporttable.php";
 	?>
</head>
<body>
<!--<div align="center" id="pr">-->
<!--<input type="button" value="Print" onclick="hide();window.print();"/>-->
<!--</div>-->
<div class="main">
<?
 $sql;
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(isset($project_name)) 
		$str 	.= '<p>Project Name: '.$project_name.'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

if(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
else echo $str.$out;
?></div>
<?
//$msc=microtime(true)-$msc;
//echo $msc.' seconds'; // in seconds
//echo ($msc*1000).' milliseconds'; // in millseconds
?>
</body>
</html>