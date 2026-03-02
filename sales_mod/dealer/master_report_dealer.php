<?
session_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['name']!='')
	$con.=' and a.PBI_NAME like "%'.$_POST['name'].'%"';
	if($_POST['PBI_ORG']!='')
	$con.=' and a.PBI_ORG = "'.$_POST['PBI_ORG'].'"';
	if($_POST['department']!='')
	$con.=' and a.PBI_DEPARTMENT = "'.$_POST['department'].'"';
	if($_POST['project']!='')
	$con.=' and a.PBI_PROJECT = "'.$_POST['project'].'"';
	if($_POST['designation']!='')
	$con.=' and a.PBI_DESIGNATION = "'.$_POST['designation'].'"';
	if($_POST['zone']!='')
	$con.=' and a.PBI_ZONE = "'.$_POST['zone'].'"';
	
	if($_POST['JOB_LOCATION']!='')
	$con.=' and a.JOB_LOCATION = "'.$_POST['JOB_LOCATION'].'"';
	
	if($_POST['PBI_GROUP']!='')
	$con.=' and a.PBI_GROUP = "'.$_POST['PBI_GROUP'].'"';
	
	if($_POST['area']!='')
	$con.=' and a.PBI_AREA = "'.$_POST['area'].'"';
	if($_POST['branch']!='')
	$con.=' and a.PBI_BRANCH = "'.$_POST['branch'].'"';

	
	if($_POST['job_status']!='')
	$con.=' and a.PBI_JOB_STATUS = "'.$_POST['job_status'].'"';
	if($_POST['gender']!='')
	$con.=' and a.PBI_SEX = "'.$_POST['gender'].'"';
	
	if($_POST['ijdb']!='')
	$con.=' and a.PBI_DOJ < "'.$_POST['ijdb'].'"';
	if($_POST['ppjdb']!='')
	$con.=' and a.PBI_DOJ_PP < "'.$_POST['ppjdb'].'"';
	
	if($_POST['ijda']!='')
	$con.=' and a.PBI_DOJ > "'.$_POST['ijda'].'"';
	if($_POST['ppjda']!='')
	$con.=' and a.PBI_DOJ_PP > "'.$_POST['ppjda'].'"';
	if($_POST['ESS_CORPORATE_PHONE']!='')
	$con.=' and e.ESS_CORPORATE_PHONE = "'.$_POST['ESS_CORPORATE_PHONE'].'"';
	if($_POST['ESS_CORPORATE_EMAIL']!='')
	$con.=' and e.ESS_CORPORATE_EMAIL = "'.$_POST['ESS_CORPORATE_EMAIL'].'"';
	if($_POST['bonus_type']!=''){
		if($_POST['bonus_type']==2)
			$bonusName = 'Eid-Ul Adha';
		else
			$bonusName = 'Eid-Ul Fitr';
	}
switch ($_POST['report']) {
    case 1:
	$report="Employee Basic Information";
$sql="select a.PBI_ID as CODE, a.PBI_ID_UNIQUE as employee_id, a.PBI_NAME as Name,d.DESG_DESC as designation ,t.DEPT_DESC as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_MOBILE as mobile  from personnel_basic_info a, designation d, department t where	1 and a.pbi_designation=d.DESG_ID and a.pbi_department=t.DEPT_ID".$con;
        
break;
		    case 10001:
	$report="Employee Details Information";


break;

		    case 100011:
	$report="Employee Details Information (Sales Team)";


break;

		    case 78:
	$report="Monthly Salary Sheet";


break;
case 79:
	$report="Pay Slip Details";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
}
		break;
case 80:
	$report="Festival Bonus Report of ".$bonusName." <br> ".$depts;
	break;
	
	
	


		    case 81:
	$report="Monthly Salary Top Sheet";	
	break;
	
	
	
	

		    case 2:
	$report="Employee Salary Information";

        echo $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation, 
		a.PBI_DEPARTMENT as department,b.special_allowance,b.ta tada,b.basic_salary,b.house_rent,
		b.medical_allowance,motorcycle_install,security_amount,b.total_payable_amount from personnel_basic_info a,salary_info b where	a.PBI_ID=b.PBI_ID ".$con;
break;
    case 3:
	$report="Monthly Attendence Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name, g.DESG_SHORT_NAME as Designation, d.DEPT_DESC as department, b.td as total_day,b.od as off_day,b.hd as holy_day, 	b.lt as late_days, 	b.ab as absent_days,b.lv as leave_days, b.lwp, b.pre as present_days, 	b.pay as payable_days,b.ot as over_time_hour FROM personnel_basic_info a,salary_attendence b, designation g, department d where	a.PBI_ID=b.PBI_ID and b.PBI_DESIGNATION = g.DESG_ID and b.PBI_DEPARTMENT = d.DEPT_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
    case 4:
		$report="Over Time Report";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department, b.ot as over_time_hour,(b.total_salary/208) as rate,b.over_time_amount FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
	    case 5:
		$report="Salary Payroll Report (Detail)";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,
	b.od,b.hd,b.lt,b.ab,b.lv,b.pre,b.pay,
	b.over_time_amount,
	b.basic_salary,b.total_salary as consolidated_salary,b.house_rent,b.medical_allowance,b.other_allowance,b.special_allowance,b.ta_da as TA_DA, b.food_allowance as fooding, b.mobile_allowance,b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable*(1.00) as total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
	
    case 6:
				$report="Salary Payroll Report (Summary)";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	$sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,
	b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction,b.total_benefits,b.total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
		    case 7:
				$report="Salary Payroll Report";
				break;
						    case 8:
				$report="Staff Mobile Information(Changable)";
				break;
					case 66:
				$report="Salary Payroll Report (Final)";
if($_POST['mon']>0&&$_POST['year']>0)
{
	$mon = $_POST['mon'];
	$year = $_POST['year'];
	  $sql="SELECT a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,b.od,b.hd,b.lt,b.ab,b.lv,b.pre,b.pay,
	b.over_time_amount,b.absent_deduction,b.advance_install,b.other_install,b.bonus_amt,b.deduction,b.benefits,b.total_salary,b.total_deduction, (b.total_salary-b.total_deduction) as actual_salary, b.total_benefits,b.total_payable FROM personnel_basic_info a,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con;
}
		break;
	case 11:
        $report="OutStanding Dues";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select c.proj_name as project_name,a.flat_no as allot_no,b.party_name as client_name,a.inst_date,a.inst_amount as payable_amt,a.rcv_amount as received_amt from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d where a.proj_code=c.proj_code and d.party_code=b.party_code and a.proj_code=d.proj_code and a.build_code=d.build_code and a.flat_no=d.flat_no and rcv_status=0 ".$proj_con.$date_con.$flat_con.$party_con." order by a.inst_date";
		break;
	case 12:
        $report="Expected Collection";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select c.proj_name as project_name,a.flat_no as allot_no,b.party_name as client_name,a.inst_date,a.inst_amount as payable_amt,a.rcv_amount as received_amt from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d where a.proj_code=c.proj_code and d.party_code=b.party_code and a.proj_code=d.proj_code and a.build_code=d.build_code and a.flat_no=d.flat_no ".$proj_con.$date_con.$flat_con.$party_con." order by a.inst_date";
		break;
	case 13:
        $report="Payment Schedule";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="SELECT e.pay_desc,a.inst_no, c.proj_name AS project_name,a.flat_no AS allot_no,  a.inst_date, a.inst_amount AS payable_amt, a.rcv_date AS receive_date, a.rcv_amount AS receive_amt
FROM 
tbl_flat_cost_installment a, 
tbl_party_info b, 
tbl_project_info c, 
tbl_flat_info d,
tbl_payment_head e
WHERE a.proj_code = c.proj_code
AND d.party_code = b.party_code
AND a.proj_code = d.proj_code
AND a.build_code = d.build_code
AND a.flat_no = d.flat_no
AND a.pay_code = e.pay_code".$proj_con.$date_con.$flat_con.$party_con." order by a.inst_date";
		break;
		case 14:
        $report="Party Rent Agreement Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		$sql="SELECT b.`proj_name`,a.`flat_no`,c.`party_name`,a.`monthly_rent`,a.`effective_date`,a.`expire_date`,a.`notice_period`,a.discontinue_term,a.`witness1`,a.`witness1_address` FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;
		break;
		case 15:
        $report="Party Rent Payment Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		$sql="SELECT b.`proj_name`,a.`flat_no`,c.`party_name`,a.`security_money`,a.`monthly_rent`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,(a.`monthly_rent`++a.`electricity_bill`+a.`other_bill`+a.`wasa_bill`+a.`gas_bill`) as total_payable FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;
		break;
		case 16:
        $report="Party Rent Payment Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		$sql="SELECT a.jv_no as Invoice_no,a.mon as period,b.`proj_name`,a.`flat_no`,c.`party_name`,a.`rent_amt`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,total_amt as total_amt FROM `tbl_rent_receive` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;
		break;

	case 24:
	$report="Collection Statement(Cash)";
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select a.rec_date as tr_date,b.proj_name".$flat_show.",a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b where a.pay_mode=0 and a.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." order by a.rec_date";
		break;
	case 25:
	$report="Collection Statement(Chaque)";
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select a.rec_date as tr_date,a.cheq_no,b.proj_name".$flat_show.",a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b where a.pay_mode=1 and a.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." order by a.rec_date";
		break;
		
		
// COMMISION REPORTS
		case 31:
	$report="Share Holder Investment Amount";
		if(isset($proj_code))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`status`,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code`".$date_con.$proj_con ." order by a.proj_code,a.agent_code";
		break;
		
		case 33:
	$report="Running Share Holder Information";
		if(isset($proj_code))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Running' ".$date_con.$proj_con ." order by a.proj_code,a.agent_code";
		break;
		
		case 34:
	$report="Withdrawn Share Holder Information";
		if(isset($proj_code))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`status_date` as withdrawn_date,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Withdrawn' ".$date_con.$proj_con ." order by a.proj_code,a.agent_code";
		break;
		
		case 35:
	$report="Agent Information";
		
		$sql="SELECT `emp_id`,`emp_name`,`emp_designation`,`emp_joining_date`,`emp_contact_no`, (select count(1) from tbl_director_info where agent_code=a.emp_id) as total_member, (select sum(invested) from tbl_director_info where agent_code=a.emp_id) as total_invested, (select sum(withdraw) from tbl_director_info where agent_code=a.emp_id)  as total_withdrawn FROM `tbl_employee_info` as a WHERE 1";
		break;
		
    case 101:
	$report="APR Information";
			if($_POST['markb']!='')
	$con.=' and b.APR_MARKS < "'.$_POST['markb'].'"';
	
		if($_POST['marka']!='')
	$con.=' and b.APR_MARKS > "'.$_POST['marka'].'"';
	$year=$_POST['year'];
	$con.=' and b.APR_YEAR = "'.$year.'"';
         $sql="select a.PBI_ID as ID,a.PBI_NAME as Name,a.PBI_SEX as Gender,a.PBI_DOMAIN as Domain,a.PBI_DEPARTMENT as department,a.PBI_PROJECT as project	,a.PBI_DESIGNATION as designation ,a.PBI_DESG_GRADE as grade,a.PBI_ZONE as zone,a.PBI_AREA as area,a.PBI_BRANCH as branch,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,b.APR_YEAR,b.APR_MARKS,(select avg(APR_MARKS) from apr_detail where APR_YEAR in (".$year.",".($year-1).",".($year-2).") and PBI_ID=a.PBI_ID) as avg_marks,b.APR_STATUS,b.APR_RESULT  from personnel_basic_info a,apr_detail b where a.PBI_ID=b.PBI_ID ".$con;
		break;

		
case 1001:
$report="Customer Information ";
if($_POST['dealer_name_e']!='')
$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';
if($_POST['dealer_code']!='')
$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';

if($_POST['group_for']!='')
$con.=' and a.group_for = "'.$_POST['group_for'].'"';

if($_POST['division_code']!='')
$con.=' and a.division_code = "'.$_POST['division_code'].'"';
elseif($_POST['district_code']!='')
$con.=' and a.district_code = "'.$_POST['district_code'].'"';
elseif($_POST['thana_code']!='')
$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';


if($_POST['region_code']!='')
$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['region_code'].'") ';
elseif($_POST['zone_code']!='')
$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['area_code']!='')
$con.=' and a.area_code = "'.$_POST['area_code'].'"';


if($_POST['canceled']!='')
$con.=' and a.canceled = "'.$_POST['canceled'].'"';
if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['mobile_no']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';

    $sql="select a.dealer_code as code, a.customer_id, a.dealer_name_e as customer_name,u.group_name as company_name , a.canceled as active 
   from dealer_info a, user_group u
		 where  a.group_for=u.id ".$con." order by a.dealer_code asc";
		break;
		
case 1002:
$report="Dealer Information (Regular)";
if($_POST['dealer_name_e']!='')
$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';
if($_POST['dealer_code']!='')
$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';

if($_POST['division_code']!='')
$con.=' and a.division_code = "'.$_POST['division_code'].'"';
elseif($_POST['district_code']!='')
$con.=' and a.district_code = "'.$_POST['district_code'].'"';
elseif($_POST['thana_code']!='')
$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';


if($_POST['region_code']!='')
$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['region_code'].'") ';
elseif($_POST['zone_code']!='')
$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['area_code']!='')
$con.=' and a.area_code = "'.$_POST['area_code'].'"';


if($_POST['canceled']!='')
$con.=' and a.canceled = "'.$_POST['canceled'].'"';
if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['mobile_no']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';

        echo $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.propritor_name_e as propritor_name ,a.mobile_no , a.canceled as active from dealer_info a, zon z
		 where  a.dealer_type='Regular' ".$con." order by a.dealer_code asc";
		break;
	
	
	
		
case 1003:
$report="Dealer Information (MAT)";
if($_POST['dealer_name_e']!='')
$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';
if($_POST['dealer_code']!='')
$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';

if($_POST['division_code']!='')
$con.=' and a.division_code = "'.$_POST['division_code'].'"';
elseif($_POST['district_code']!='')
$con.=' and a.district_code = "'.$_POST['district_code'].'"';
elseif($_POST['thana_code']!='')
$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';


if($_POST['region_code']!='')
$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['region_code'].'") ';
elseif($_POST['zone_code']!='')
$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['area_code']!='')
$con.=' and a.area_code = "'.$_POST['area_code'].'"';


if($_POST['canceled']!='')
$con.=' and a.canceled = "'.$_POST['canceled'].'"';
if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['mobile_no']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';

       echo  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.propritor_name_e as propritor_name ,a.mobile_no, a.canceled as active from dealer_info a, zon z
		 where  a.dealer_type='MAT' and a.zone_code=z.ZONE_CODE  ".$con." order by a.dealer_code asc";
		break;
	
case 5003:
$report="Corporate Dealer Information";
if($_POST['dealer_name_e']!='')
$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';
if($_POST['dealer_code']!='')
$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';

if($_POST['division_code']!='')
$con.=' and a.division_code = "'.$_POST['division_code'].'"';
elseif($_POST['district_code']!='')
$con.=' and a.district_code = "'.$_POST['district_code'].'"';
elseif($_POST['thana_code']!='')
$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';


if($_POST['region_code']!='')
$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['zone_code']!='')
$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';
elseif($_POST['area_code']!='')
$con.=' and a.area_code = "'.$_POST['area_code'].'"';


if($_POST['canceled']!='')
$con.=' and a.canceled = "'.$_POST['canceled'].'"';
if($_POST['depot']!='')
$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')
$con.=' and a.product_group = "'.$_POST['product_group'].'"';
if($_POST['depot']!='')
$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';
		 
		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as dealer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,a.product_group as GRP,a.propritor_name_e as propritor_name ,a.address_e as address,a.mobile_no ,a.app_date, a.canceled as active,w.warehouse_name as depot from dealer_info a,warehouse w where a.dealer_type='Corporate' and w.warehouse_id=a.depot ".$con." order by a.dealer_code desc";
		break;
		
		
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>
<?=$report?>
</title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
function Pager(tableName, itemsPerPage) {
    this.tableName = tableName;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;
    
    this.showRecords = function(from, to) {        
        var rows = document.getElementById(tableName).rows;
        // i starts from 1 to skip table header row
        for (var i = 1; i < rows.length; i++) {
            if(i < from || i > to) rows[i].style.display = 'none';
            else rows[i].style.display = '';
        }
    }
    
    this.showPage = function(pageNumber) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}

        var oldPageAnchor = document.getElementById('pg'+this.currentPage);
        oldPageAnchor.className = 'pg-normal';
        
        this.currentPage = pageNumber;
        var newPageAnchor = document.getElementById('pg'+this.currentPage);
        newPageAnchor.className = 'pg-selected';
        
        var from = (pageNumber - 1) * itemsPerPage + 1;
        var to = from + itemsPerPage - 1;
        this.showRecords(from, to);
    }   
    
    this.prev = function() {
        if (this.currentPage > 1)
            this.showPage(this.currentPage - 1);
    }
    
    this.next = function() {
        if (this.currentPage < this.pages) {
            this.showPage(this.currentPage + 1);
        }
    }                        
    
    this.init = function() {
        var rows = document.getElementById(tableName).rows;
        var records = (rows.length - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
    }

    this.showPageNav = function(pagerName, positionId) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}
    	var element = document.getElementById(positionId);
    	
    	var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal">Prev</span>';
        for (var page = 1; page <= this.pages; page++) 
            pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span>';
        pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal">Next</span>';            
        
        element.innerHTML = pagerHtml;
    }
}
var XMLHttpRequestObject = false;

if (window.XMLHttpRequest) 
	XMLHttpRequestObject = new XMLHttpRequest(); 
else if (window.ActiveXObject) 
	{
     	XMLHttpRequestObject = new
        ActiveXObject("Microsoft.XMLHTTP");
    }
function getData(dataSource, divID, data)
	{
	  if(XMLHttpRequestObject) 
		  {
				var obj = document.getElementById(divID);
				XMLHttpRequestObject.open("POST", dataSource);
				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		
				XMLHttpRequestObject.onreadystatechange = function()
					{
						if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
							obj.innerHTML =   XMLHttpRequestObject.responseText;
					}
				XMLHttpRequestObject.send("ledger=" + data);
		  }
	}
function getData2(dataSource, divID, data1, data2)
	{
	  if(XMLHttpRequestObject) 
		  {
				var obj = document.getElementById(divID);
				XMLHttpRequestObject.open("POST", dataSource);
				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		
				XMLHttpRequestObject.onreadystatechange = function()
					{
						if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
							obj.innerHTML =   XMLHttpRequestObject.responseText;
					}
				XMLHttpRequestObject.send("data=" + data1+"##" + data2);

		  }
	}
	function getflatData3()
{
	var b=document.getElementById('category_to').value;
	var a=document.getElementById('proj_code_to').value;
			$.ajax({
		  url: '../../common/flat_option_new3.php',
		  data: "a="+a+"&b="+b,
		  success: function(data) {						
				$('#fid3').html(data);	
			 }
		});
}
	function getflatData2()
{
	var b=document.getElementById('category_from').value;
	var a=document.getElementById('proj_code_from').value;
			$.ajax({
		  url: '../../common/flat_option_new2.php',
		  data: "a="+a+"&b="+b,
		  success: function(data) {						
				$('#fid2').html(data);	
			 }
		});
}
</script>
</head>
<body>
<form action="" method="post">
  <div align="center" id="pr">
    <input type="button" value="Print" onclick="hide();window.print();"/>
  </div>
  <div class="main">
    <?
		//echo $sql;
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h2 style="font-size:24px;">'.$_SESSION['company_name'].'</h2>';
		
		
		if(isset($report)){		
		if($_POST['report']==78 || $_POST['report']==3){
			$str 	.= '<h2>'.$report.' For The Month of '.date('F- Y',mktime(0,0,0,$_POST['mon'],1,$_POST['year'])).'</h2>';
			}else{
			$str 	.= '<h2>'.$report.'</h2>';
			} 
		}
		
		
		if(isset($report)){		
		if($_POST['report']==81 ){
			$str 	.= '<h2>'.$report.' For The Month of '.date('F- Y',mktime(0,0,0,$_POST['mon'],1,$_POST['year'])).'</h2>';
			}else{
			$str 	.= '<h2>'.$report.'</h2>';
			} 
		}
		
		
		
		
		
		
		if(isset($to_date))
			$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
			
		if(($_POST['department']>0)) 
		$str 	.= '<h2>Department: '.find_a_field('department','DEPT_DESC','DEPT_ID="'.$_POST['department'].'"').'</h2>';	
		
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		
		if(($_POST['area']>0)) 
		$str 	.= '<p>Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE="'.$_POST['area'].'"').'</p>';
		if(($_POST['zone_code']>0)) 
		$str 	.= '<p>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE="'.$_POST['zone_code'].'"').'</p>';
		if(($_POST['region_code']>0)) 
		$str 	.= '<p>Region Name: '.find_a_field('branch','BRANCH_NAME','BRANCH_ID="'.$_POST['region_code'].'"').'</p>';
		if(isset($project_name)) 
		$str 	.= '<p>Project Name: '.$project_name.'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
	
if($_POST['report']==7) 
{
$sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department from 
personnel_basic_info a where 1 ".$con;
$query = db_query($sql);
?>
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
      <thead>
        <tr>
          <td style="border:0px;" colspan="11"><?=$str?></td>
        </tr>
        <tr>
          <th>S/L</th>
          <th>CODE</th>
          <th>Name</th>
          <th>Desg</th>
          <th>Dept</th>
          <th>Salary Type</th>
          <th>Basic</th>
          <th>C.Salary</th>
          <th>SL</th>
          <th>HR</th>
          <th>TA/DA</th>
          <th>FA</th>
          <th>MA</th>
          <th>Sal By </th>
          <th>A/C#</th>
          <th>Branch</th>
          <th>SM</th>
        </tr>
      </thead>
      <tbody>
        <?
while($datas=mysqli_fetch_row($query)){$s++;
$sqld = 'select * from salary_info where PBI_ID='.$datas[0];
$data = mysqli_fetch_object(db_query($sqld));
?>
        <tr>
          <td><?=$s?></td>
          <td><?=$datas[0]?></td>
          <td><?=$datas[1]?></td>
          <td><?=$datas[2]?></td>
          <td><?=$datas[3]?></td>
          <td><?=$data->salary_type?></td>
          <td><?=$data->basic_salary?></td>
          <td><?=$data->consolidated_salary?></td>
          <td style="text-align:right"><?=$data->special_allowance ?></td>
          <td style="text-align:right"><?=$data->house_rent?></td>
          <td><?=$data->ta?></td>
          <td><?=$data->food_allowance?></td>
          <td><?=$data->medical_allowance?>
          &nbsp;</td>
          <td><?=$data->cash_bank?>
          &nbsp;</td>
          <td><?=$data->cash?></td>
          <td><?=$data->branch_info?></td>
          <td><?=$data->security_amount?></td>
        </tr>
        <?
}
?>
      </tbody>
    </table>
    <?
}


if($_POST['report']==10001) 
{
$sqld="select a.PBI_ID as CODE, a.PBI_ID_UNIQUE as employee_id, a.PBI_NAME as Name, a.ESSENTIAL_BLOOD_GROUP, b.DESG_DESC as designation ,c.DEPT_DESC as department,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,e.ESS_CORPORATE_PHONE as corp_mobile, e.ESS_CORPORATE_EMAIL as corp_email,
(select group_name from user_group where id=a.PBI_ORG) as Company ,
(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area, 
a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile,PBI_JOB_STATUS job_status,JOB_LOCATION, a.PBI_DOB from personnel_basic_info a, designation b, department c, essential_info e where b.DESG_ID = a.PBI_DESIGNATION and c.DEPT_ID = a.PBI_DEPARTMENT and e.PBI_ID=a.PBI_ID".$con;
		
$query = db_query($sqld);
?>
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
      <thead>
        <tr>
          <td style="border:0px;" colspan="10"><?=$str?></td>
        </tr>
        <tr>
          <th>S/L 10001</th>
          <th>Image</th>
          <th>Emp ID </th>
          <th>Unique ID</th>
      <th>Name</th>
      <th>Designation</th>
      <th>Department</th>
      <th>Joining Date</th>
      <th>PP Joining Date</th>
      <th>Company</th>
      <th>Mobile</th>
      <th>Corp. Mobile </th>
      <th>Corp. Email </th>
      <th>Blood Group </th>
      <th>Job Status</th>
      <th>JOB LOCATION</th>
        </tr>
      </thead>
      <tbody>
<?
$s=0;
while($datas=mysqli_fetch_object($query)){$s++;
?>
        <tr style="background-color:<?=( date('m-d',strtotime($datas->PBI_DOB)) == date('m-d') )? '#FFCCFF' : '' ;?>">
          <td><?=$s?></td>
          <td><img src="../../pic/staff/<?=$datas->CODE?>.jpeg" border="1" width="75" height="70"></td>
          <td><?=$datas->CODE?></td>
          <td><?=$datas->employee_id?></td>
      <td><?=$datas->Name?></td>
      <td><?=$datas->designation?></td>
      <td><?=$datas->department?></td>
      <td><?=$datas->joining_date?></td>
      <td><?=$datas->PP_joining_date?></td>
      <td><?=$datas->Company?></td>
      <td><?=$datas->mobile?></td>
      <td><?=$datas->corp_mobile?></td>
      <td><?=$datas->corp_email?></td>
      <td><?=$datas->ESSENTIAL_BLOOD_GROUP?></td>
      <td><?=$datas->job_status?></td>
      <td style="text-align:right"><?=$datas->JOB_LOCATION?></td>
        </tr>
	<?
	}
	?>
      </tbody>
    </table>
<?
}


if($_POST['report']=='100011') 
{
//echo $_POST['report'];
$sqld="select a.PBI_ID as CODE, a.PBI_ID_UNIQUE as employee_id, a.PBI_NAME as Name, b.DESG_DESC as designation ,c.DEPT_DESC as department,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,(select group_name from user_group where id=a.PBI_ORG) as Company ,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile,PBI_JOB_STATUS job_status,JOB_LOCATION from personnel_basic_info a, designation b, department c where b.DESG_ID = a.PBI_DESIGNATION and c.DEPT_ID = a.PBI_DEPARTMENT and a.PBI_DEPARTMENT=3 ".$con;
		
$query = db_query($sqld);
?>
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
      <thead>
        <tr>
          <td style="border:0px;" colspan="12"><?=$str?></td>
        </tr>
        <tr>
          <th>S/L</th>
          <th>Image</th>
          <th>Employee ID</th>
      <th>Name</th>
      <th>Designation</th>
      <th>Department</th>
      <th>Joining Date</th>
      <th>PP Joining Date</th>
      <th>Company</th>
      <th>Area</th>
      <th>Zone</th>
      <th>Region</th>
      <th>Mobile</th>
      <th>Job Status</th>
      <th>JOB LOCATION</th>
        </tr>
      </thead>
      <tbody>
<?
$s=0;
while($datas=mysqli_fetch_object($query)){$s++;
?>
        <tr>
          <td><?=$s?></td>
          <td><img src="../../pic/staff/<?=$datas->CODE?>.jpeg" border="1" width="75" height="70"></td>
          <td><?=$datas->employee_id?></td>
      <td><?=$datas->Name?></td>
      <td><?=$datas->designation?></td>
      <td><?=$datas->department?></td>
      <td><?=$datas->joining_date?></td>
      <td><?=$datas->PP_joining_date?></td>
      <td><?=$datas->Company?></td>
      <td style="text-align:right"><?=$datas->area?></td>
      <td style="text-align:right"><?=$datas->zone?></td>
      <td><?=$datas->Region?></td>
      <td><?=$datas->mobile?></td>
      <td><?=$datas->job_status?></td>
      <td style="text-align:right"><?=$datas->JOB_LOCATION?></td>
        </tr>
	<?
	}
	?>
      </tbody>
    </table>
<?
}



if($_POST['report']==8) 
{


        echo $sql="select a.PBI_ID as CODE,a.PBI_NAME as Name,a.PBI_DESIGNATION as designation ,a.PBI_DEPARTMENT as department,a.PBI_GROUP as `Group`,a.PBI_DOJ as joining_date,a.PBI_DOJ_PP as PP_joining_date,(select AREA_NAME from area where AREA_CODE=a.PBI_AREA) as area,(select ZONE_NAME from zon where ZONE_CODE=a.PBI_ZONE) as zone,(select BRANCH_NAME from branch where BRANCH_ID=a.PBI_BRANCH) as Region,a.PBI_EDU_QUALIFICATION as qualification,a.PBI_MOBILE as mobile  from personnel_basic_info a where	1 ".$con;
$query = db_query($sql);
?>
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
      <thead>
        <tr>
          <td style="border:0px;" colspan="11"><?=$str?></td>
        </tr>
        <tr>
          <th>S/L</th>
          <th>CODE</th>
          <th>Name</th>
          <th>Desg</th>
          <th>Dept</th>
          <th>Group</th>
          <th>Join_date</th>
          <th>PP_join_date</th>
          <th>Area</th>
          <th>Zone</th>
          <th>Region</th>
          <th>Qualification</th>
          <th>Mobile No </th>
          <th>Submit</th>
        </tr>
      </thead>
      <tbody>
        <?
$ajax_page = "rd_issue_ajax.php";
while($datas=mysqli_fetch_row($query)){$s++;
?>
        <tr>
          <td><?=$s?></td>
          <td><?=$datas[0]?></td>
          <td><?=$datas[1]?></td>
          <td><?=$datas[2]?></td>
          <td><?=$datas[3]?></td>
          <td><?=$datas[4]?></td>
          <td><?=$datas[5]?></td>
          <td><?=$datas[6]?></td>
          <td style="text-align:right"><?=$datas[7]?></td>
          <td style="text-align:right"><?=$datas[8]?></td>
          <td><?=$datas[9]?></td>
          <td><?=$datas[10]?></td>
          <td><input type="hidden" name="PBI_ID#<?=$datas[0]?>" id="PBI_ID#<?=$datas[0]?>" value="<?=$datas[0]?>" />
            <input name="mobile#<?=$datas[0]?>" type="text" id="mobile#<?=$datas[0]?>" value="<?=$datas[11]?>" />
          </td>
          <td><div id="po<?=$datas[0]?>">
              <input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[0]?>',document.getElementById('PBI_ID#<?=$datas[0]?>').value,document.getElementById('mobile#<?=$datas[0]?>').value);" />
          </div></td>
        </tr>
        <?
}
?>
      </tbody>
    </table>
    <?
}

if($_POST['report']==78) 
{

?>
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
      <thead>
        <tr>
          <td style="border:0px;" colspan="30"><?=$str?></td>
        </tr>
        <tr>
          <th rowspan="2">S/L</th>
          <th rowspan="2">ID</th>
          <th rowspan="2">Name</th>
          <th rowspan="2">Desgnation</th>
          <th rowspan="2">Joining Date </th>
          <th rowspan="2"><div align="center">Bank Acc.</div></th>
          <th rowspan="2">Gross</th>
          <th colspan="2">Allowance</th>
          <th rowspan="2"><div align="center">Monthly Working Days </div></th>
          <th rowspan="2">Monthly Holidays </th>
          <th rowspan="2">Leave Taken </th>
          <th rowspan="2">Attn. Days </th>
          <th rowspan="2">Total Payable Days </th>
          <th rowspan="2">OT Hrs. </th>
          <th rowspan="2">OT Amt. </th>
          <th rowspan="2">Actual Salary </th>
          <th colspan="13"><div align="center">Deduction</div></th>
          <th rowspan="2" align="center"><div align="center">Net Payable Salary </div></th>
        </tr>
        <tr>
          <th>TA</th>
          <th>FA</th>
          <th>Advance /Loan</th>
          <th>Tax</th>
          <th>PF</th>
          <th>MI</th>
          <th>Mobile</th>
          <th>Food</th>
          <th>Other</th>
          <th>No. of Late Days </th>
          <th>Absent Days </th>
          <th>LWP</th>
          <th>No. of days Salary Deduction </th>
          <th>Amount of Deduction </th>
          <th>Total Deduction </th>
        </tr>
      </thead>
      <tbody>
        <?
$sqld = 'select t.*, a.PBI_ID, a.PBI_ID_UNIQUE, a.PBI_NAME, a.PBI_DOJ, d.DEPT_DESC, g.DESG_SHORT_NAME as Designation, e.ESS_BANK_ACC_NO 

from  salary_attendence t,designation g, department d, personnel_basic_info a, essential_info e 

where  t.PBI_ID=a.PBI_ID and e.PBI_ID=t.PBI_ID and t.PBI_DESIGNATION = g.DESG_ID and t.PBI_DEPARTMENT = d.DEPT_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '.$con.' order by t.gross_salary desc';

$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
        <tr>
          <td><div align="center">
            <?=++$s?>
          </div></td>
          <td><div align="center">
            <?=$data->PBI_ID_UNIQUE?>
          </div></td>
          <td><div align="left">
            <?=$data->PBI_NAME?>
          </div></td>
          <td><div align="left">
            <?=$data->Designation?>
          </div></td>
          <td><?=$data->PBI_DOJ?></td>
          <td><?=$data->ESS_BANK_ACC_NO?></td>
          <td><div align="right">
            <?=$data->gross_salary; $totGross+=$data->gross_salary;?>
          </div></td>
          <td><div align="right">
            <?=$data->ta_da; $totTa+=$data->ta_da;?>
          </div></td>
          <td><div align="right">
            <?=$data->food_allowance; $totFood+=$data->food_allowance; $totAlw+=($data->ta_da+$data->food_allowance)?>
          </div></td>
          <td><div align="center">
            <?=$data->td?>
          </div></td>
          <td><div align="center">
            <?=$data->hd?>
          </div></td>
          <td><div align="center">
            <?=$data->lv?>
          </div></td>
          <td><div align="center">
            <?=$data->pre?>
          </div></td>
          <td><div align="center">
            <?
			$firstDate = date('Y-m-d',mktime(0,0,0,$_POST['mon'],1,$_POST['year']));
			$lastDate = date('Y-m-d',mktime(0,0,0,$_POST['mon'],$data->td,$_POST['year']));
			if($data->PBI_DOJ > $firstDate){
			$interval = date_diff(date_create($data->PBI_DOJ), date_create($lastDate));
			
			$payableDays = ($interval->format("%d"))+1;}
			else{
			$payableDays = $data->td;}
			
			echo $payableDays;
			
			?>
          </div></td>
          <td><div align="right">
            <?=$data->over_time_hr?>
          </div></td>
          <td><div align="right">
            <?=$data->over_time_amount?>
          </div></td>
          <td><div align="right">
            <?=$data->total_salary; $totActual+=$data->total_salary;?>
          </div></td>
          <td><div align="right">
            <?=$data->advance_install?>
          </div></td>
          <td><div align="right">
            <?=$data->income_tax?>
          </div></td>
          <td><div align="right">
            <?=$data->pf?>
          </div></td>
          <td><div align="right">
            <?=$data->medical_insurance ?>
          </div></td>
          <td><div align="right">
            <?=$data->mobile_deduction?>
          </div></td>
          <td><div align="right">
            <?=$data->food_deduction?>
          </div></td>
          <td><div align="right">
            <?=$data->other_deduction?>
          </div></td>
          <td><div align="center">
            <?=$data->lt?>
          </div></td>
          <td><div align="center">
            <?=$data->ab?>
          </div></td>
          <td><div align="center">
            <?=$data->lwp?>
          </div></td>
          <td align="right"><div align="right">
            <?=$data->late_deduction_days+$data->ab+$data->lwp?>
          </div></td>
          <td align="right"><div align="right">
            <?=$data->deduction?>
          </div></td>
          <td align="right"><div align="right">
            <?=$data->total_deduction; $totDeduction+=$data->total_deduction;?>
          </div></td>
          <td align="right"><div align="right"><? echo number_format($data->total_payable,2); $total_cash += $data->total_payable;?></div></td>
        </tr>
        <?
}
?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><div align="right">
            <?=number_format($totGross,2)?>
          </div></td>
          <td><div align="right">
            <?=number_format($totTa,2)?>
          </div></td>
          <td><div align="right">
            <?=number_format($totFood,2)?>
          </div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right">
            <?=number_format($totActual,2)?>
          </div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right"></div></td>
          <td><div align="right">
            <?=number_format($totDeduction,2)?>
          </div></td>
          <td align="right">
            <div align="right">
              <?=number_format($total_cash,2)?>
            </div></td>
        </tr>
      </tbody>
    </table>
    <br>
    <br>
    <table width="20%" cellspacing="0" cellpadding="2" border="1">
      
      <tr>
        <td align="right">Gross Salary = </td>
        <td align="right"><?=number_format($totGross,2)?></td>
      </tr>
      
        <tr>
          <td align="right">Allowance = </td>
          <td align="right"><?=number_format($totAlw,2)?></td>
        </tr>
        <tr>
          <td align="right">Actual Salary = </td>
          <td align="right"><?=number_format($totActual,2)?></td>
        </tr>
        <tr>
          <td align="right">Deduction = </td>
          <td align="right"><?=number_format($totDeduction,2)?></td>
        </tr>
        <tr>
          <td align="right">Net Payable Amount = </td>
          <td align="right"><?=number_format($total_cash,2)?></td>
        </tr>
    </table>
	<br>
    <br>
    <strong>Net Payable Amount In Word :</strong> Taka 
	<?
	$gnet_tot=($total_cash);
	
	$credit_amt = explode('.',$gnet_tot);
	
	if($credit_amt[0]>0){
	
	echo convertNumberToWordsForIndia($credit_amt[0]);}
	
	if($credit_amt[1]>0){
	
	
	echo  ' & Paisa '.convertNumberToWordsForIndia($credit_amt[1]);}
	
	echo ' Only';

		?>
	
	 <br>
    <br>
    AS PER PROPER REGISTER THE SALARY FOR THE MONTH OF - <? $yearMon = date('F-Y',mktime(0,0,0,$_POST['mon'],1,$_POST['year'])); $separated = explode('-',$yearMon); echo $finalYearMon = strtoupper($separated[0]).', '.$separated[1]?> HAS BEEN PREPARED CHECK AND FOUND CORRECT THE PAYABLE AMOUNT SHOWN IN THE SALARY SHEET - <?=$finalYearMon?> BE PAID <br><br><br>
	<? if($_POST['department']>0 && $_POST['department']!=1){?>
    <div style="width:100%; margin:0 auto">
      <div style="float:left; width:15%; text-align:center">-------------------<br>
        Prepared By</div>
      <div style="float:left; width:15%; text-align:center">-------------------<br>
      Checked By (Mgr-Act and Fin)</div>
	  <div style="float:left; width:15%; text-align:center">-------------------<br>
	  <? if($_POST['department']>0 && $_POST['department']==3){?>
	  Sales Manager
	  <? }else{?>
      Head of <?=find_a_field('department','DEPT_DESC','DEPT_ID='.$_POST['department']); }?></div>
      <div style="float:left; width:15%; text-align:center">-------------------<br>
      Head of HR & Admin</div>
      <div style="float:left; width:15%; text-align:center">-------------------<br>
        Head of Sales & Operation</div>
      <div style="float:left; width:15%; text-align:center">-------------------<br>
        Managing Director</div>
    </div>
	<? }else{?>
	<div style="width:100%; margin:0 auto">
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Prepared By</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
      Checked By (Mgr-Act and Fin)</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
      Head of HR & Admin</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Head of Sales & Operation</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Managing Director</div>
    </div>
	<? }?>
   
   
   
    <?
}
elseif($_POST['report']==79)
{?>
<h2 style="text-align:center"><?=$str?></h2>
<?
	
	 $sql="SELECT a.*,b.*,des.DESG_DESC as designation ,dep.DEPT_DESC as department FROM personnel_basic_info a left join department dep on dep.DEPT_ID = a.PBI_DEPARTMENT LEFT JOIN designation des on des.DESG_ID = a.PBI_DESIGNATION,salary_attendence b where	a.PBI_ID=b.PBI_ID and b.mon='".$mon."' and b.year='".$year."'".$con." order by a.PBI_DEPARTMENT,b.total_salary desc";
$res = db_query($sql);
	while($data=mysqli_fetch_object($res)){
?>
<div <? $i++;if(($i%3)==0) echo 'style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid"';?>>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="8"><div class="header">
  <h2>Pay Slip Report: 
    <?=date('F', mktime(0,0,0,$mon,15,2000))?>, <?=$year?></h2></div></td></tr><tr>
  <th>Staff Picture</th>
  <th>Staff_Information</th>
  <th>Attendence_Info</th>
  <th>Salary_Information</th>
  <th> Other_Benefits</th>
  <th>Deduction/Meal</th>
  <th>Payable_Salary</th>
  <th>Signature</th></tr></thead><tbody><tr>
      <td align="center" style="text-align:center"><p><img src="../../pic/staff/<?=$data->PBI_ID?>.jpg" alt="" width="98" height="101" border="1" /></p></td>
      <td align="center">ID: <strong><?=$data->PBI_ID?></strong><br />
 Name: <strong>
 <?=$data->PBI_NAME ?>
 </strong><br />
 Designation: <strong>
 <?=$data->designation?>
 </strong><br />
 Department: <strong>
 <?=$data->department?>
 </strong></td>
      <td align="right">Present Days:<strong>
        <?=$data->pre?></strong><br />
        Leave Days:<strong>
        <?=$data->lv?></strong><br />
        Late Days:<strong>
        <?=$data->lt?></strong><br />
        Absent Days:<strong>
        <?=$data->ab?></strong><br />
        Total Days:<strong>
        <?=$data->td?></strong><br />Payable Days:<strong>
        <?=$data->pay?>
        </strong></td>
      <td align="center" style="text-align:right">Basic Salary:<strong>
        <?=$data->basic_salary?></strong><br />
      House Rent:<strong>
      <?=$data->house_rent?></strong><br />
      Medical All:<strong>
      <?=$data->medical_allowance?></strong><br />
      Other All:<strong>
      <?=$data->other_allowance?></strong><br />
      Special All:<strong>
      <?=$data->special_allowance?></strong><br />
      Mobile All:<strong>
      <?=$data->mobile_allowance?></strong><br />
      Total Sal:<strong>
      <?=$data->total_salary?>
      </strong></td>
      <td align="center" style="text-align:right">Bonus Amt:<strong>
        <?=$data->bonus_amt?></strong><br />
        Benefits:<strong>
        <?=$data->benefits?></strong><br />
        Total Benefits: <strong>
        <?=($data->benefits+$data->bonus_amt)?>
        </strong></td>
      <td align="center" style="text-align:right">Absent Deduction:<strong>
        <?=($data->total_deduction-($data->advance_install+$data->other_install+$data->deduction))?></strong><br />
        Advance Install:<strong>
        <?=$data->advance_install?></strong><br />
        Other Install:<strong>
        <?=$data->other_install?></strong><br />
        Meal/ Deduction:<strong>
        <?=$data->deduction?></strong><br />Total Deduction:<strong>
        <?=$data->total_deduction?>
        </strong></td>
      <td align="center" style="text-align:right">Total Sal:<strong>
        <?=$data->total_salary?>
      </strong><br />
        Total Benefits:<strong>
        <?=($data->benefits+$data->bonus_amt)?>
        </strong><br />
        Total Ded:<strong>
        <?=$data->total_deduction?>
        </strong><br />
        Total Payable:<strong>
        <?=$data->total_payable-($data->total_benefits-($data->benefits+$data->bonus_amt))?>
        </strong></td>
      <td align="center" style="text-align:right">................................<br />
        (<strong>
        <?=$data->PBI_NAME ?>
        </strong>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></tbody></table>
</div>
<p><br />
    <br />
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  <?
}}
elseif($_POST['report']==81)
{?>

<div style="height:100%">

<table width="100%" cellspacing="0" cellpadding="2" border="0">
      <thead>
        <tr>
          <td style="border:0px;" colspan="30"><?=$str?><br /></td>
        </tr>
        <tr>
          <th rowspan="2">S/L</th>
          
          <th rowspan="2">Department</th>
          <th rowspan="2">Gross Salary </th>
          <th colspan="4" style="text-align:center; height:20px; background-color:#CCC">Net Salary</th> 
          <th rowspan="2">Remarks </th>         
        </tr>
        
        
        
        <tr>
          <th align="center">Cash/Bank</th>
          <th align="center">Employee<br />Tax</th>
          <th align="center">Advance /Loan</th>
          <th align="center"><b>Total</b></th>
          
        </tr>
      </thead>
      <tbody>
      
            
        
      
      
      
      
      <?php 
	  $result=db_query("Select distinct DEPT_ID,DEPT_DESC from department order by custom_serial");
	  while($row=mysqli_fetch_array($result)){
		  


$results = db_query("SELECT SUM(gross_salary) AS gross_salary FROM salary_attendence where PBI_DEPARTMENT='$row[DEPT_ID]'"); 
$rows = mysqli_fetch_array($results); 
$sum = $rows['gross_salary'];
$grosstot=$grosstot+$sum;

$resultss = db_query("SELECT SUM(total_payable) AS total_payable FROM salary_attendence where PBI_DEPARTMENT='$row[DEPT_ID]'"); 
$rowss = mysqli_fetch_array($resultss); 
$sums = $rowss['total_payable'];
 
$resulttax = db_query("SELECT SUM(income_tax) AS income_tax FROM salary_attendence where PBI_DEPARTMENT='$row[DEPT_ID]'"); 
$taxrow = mysqli_fetch_array($resulttax);
$totalincometax=$totalincometax+$taxrow[income_tax];

$resultadvance = db_query("SELECT SUM(advance_install) AS advance_install FROM salary_attendence where PBI_DEPARTMENT='$row[DEPT_ID]'"); 
$advancerow = mysqli_fetch_array($resultadvance);	
$totaladvance=$totaladvance+$taxrow[advance_install];	  
	
$ttotal=$sums+$taxrow[income_tax]+$advancerow[advance_install];
$ttotals=$ttotals+$ttotal;		  
		  
		  $s=$s+1;
	  
	  if($sum>0){
	  ?>
      
       <tr>
          <td><div align="center">
            <?=$s?>
          </div></td>
          
          <td><div align="left">
            <?php echo $row[DEPT_DESC];?>
          </div></td>
         
          
          <td><div align="right">
            <?php echo $sum; ?>
          </div></td>
          
          
          <td align="right">
          <div align="right"><?php echo number_format($sums,2); ?></div></td>
          
          
          <td><div align="right">
            <?php echo number_format($taxrow[income_tax],2);?>
          </div></td>
          
          <td><div align="right">
            <?php echo $advancerow[advance_install];?>
          </div></td>
          
          <td align="right"><div align="right">
            <?php echo (number_format(($sums+$taxrow[income_tax]+$advancerow[advance_install]))) ;?>
          </div></td>
          
          <td align="right"></td>
          
        </tr>
      
    <?php }} ?>  
      
       
      </tbody>
      
      <tr>
      
      <td colspan="2">Total</td>
      <td></td>
      <td align="right"><?php echo number_format($grosstot,2); ?></td>
      <td align="right"><?php echo number_format($totalincometax,2);?></td>
      <td align="right"><?php echo number_format($totaladvance,2);?></td>
      <td align="right"><?php echo $ttotals; ?></td>
      <td></td>
      </tr>
    </table>
    </div>
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    
    
	 <br>
    <br>
   
	<div style="width:100%; margin:0 auto">
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Prepared By</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
      Checked By (Mgr-Act and Fin)</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
      Head of HR & Admin</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Head of Sales & Operation</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Managing Director</div>
    </div><br /><br /><br /><br />
    
    
    
    
    
    <div style="height:100%">
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
      <thead>
       
        <tr>
          <td style="border:0px;" colspan="30"><h2 align="center">International Consumer Products Bangladesh Ltd.</h2><br /></td>
        </tr>
        <tr>
          <td style="border:0px;" colspan="30"><h2 align="center">Cash Salary Statment</h2><br /></td>
        </tr>
        
        
        <tr>
          <th rowspan="2">S/L</th>
          
          <th rowspan="2">Name</th>
          <th rowspan="2">Designation</th>
          <th rowspan="2">Gross Salary </th>
          <th colspan="4" style="text-align:center; height:20px; background-color:#CCC">Net Salary</th> 
          <th rowspan="2">Remarks </th>         
        </tr>
        
        
        
        <tr>
          <th align="center">Cash/Bank</th>
          <th align="center">Employee<br />Tax</th>
          <th align="center">Advance /Loan</th>
          <th align="center"><b>Total</b></th>
          
        </tr>
      </thead>
      <tbody>
      
            
        
      
      
      
      
      <?php 
	  $result=db_query("Select * from essential_info where ESS_BANK_ACC_NO='' order by PBI_ID");
	  while($row=mysqli_fetch_array($result)){
		  


$perresult = db_query("SELECT * from personnel_basic_info where PBI_ID='$row[PBI_ID]'"); 
$prerow = mysqli_fetch_array($perresult); 


$results = db_query("SELECT SUM(gross_salary) AS gross_salary FROM salary_attendence where PBI_ID='$row[PBI_ID]'"); 
$rows = mysqli_fetch_array($results); 
$sum = $rows['gross_salary'];
$grosstot=$grosstot+$sum;

$resultss = db_query("SELECT SUM(total_payable) AS total_payable FROM salary_attendence where PBI_ID='$row[PBI_ID]'"); 
$rowss = mysqli_fetch_array($resultss); 
$sums = $rowss['total_payable'];
 
$resulttax = db_query("SELECT SUM(income_tax) AS income_tax FROM salary_attendence where PBI_ID='$row[PBI_ID]'"); 
$taxrow = mysqli_fetch_array($resulttax);
$totalincometax=$totalincometax+$taxrow[income_tax];

$resultadvance = db_query("SELECT SUM(advance_install) AS advance_install FROM salary_attendence where PBI_ID='$row[PBI_ID]'"); 
$advancerow = mysqli_fetch_array($resultadvance);	
$totaladvance=$totaladvance+$taxrow[advance_install];	  
	
$ttotal=$sums+$taxrow[income_tax]+$advancerow[advance_install];
$ttotals=$ttotals+$ttotal;		  
		  
		  $i=$i+1;
	  
	 
	  ?>
      
       <tr>
          <td><div align="center">
            <?=$i?>
          </div></td>
          
          <td><div align="left">
            <?php echo $prerow[PBI_NAME];?>
          </div></td>
          
          
          <td><div align="left">
            <?php echo $row[DEPT_DESC];?>
          </div></td>
         
          
          <td><div align="right">
            <?php echo $sum; ?>
          </div></td>
          
          
          <td align="right">
          <div align="right"><?php echo number_format($sums,2); ?></div></td>
          
          
          <td><div align="right">
            <?php echo number_format($taxrow[income_tax],2);?>
          </div></td>
          
          <td><div align="right">
            <?php echo $advancerow[advance_install];?>
          </div></td>
          
          <td align="right"><div align="right">
            <?php echo (number_format(($sums+$taxrow[income_tax]+$advancerow[advance_install]))) ;?>
          </div></td>
          
          <td align="right"></td>
          
        </tr>
      
    <?php } ?>  
      
       
      </tbody>
      
      <tr>
      
      <td colspan="2">Total</td>
      <td></td>
      <td align="right"><?php echo number_format($grosstot,2); ?></td>
      <td align="right"><?php echo number_format($totalincometax,2);?></td>
      <td align="right"><?php echo number_format($totaladvance,2);?></td>
      <td align="right"><?php echo $ttotals; ?></td>
      <td></td>
      </tr>
    </table>
    </div>
    <br /><br /><br /><br /><br /><br />
    <br>
    <br>
   
	<div style="width:100%; margin:0 auto">
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Prepared By</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
      Checked By (Mgr-Act and Fin)</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
      Head of HR & Admin</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Head of Sales & Operation</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Managing Director</div>
    </div><br /><br /><br /><br />
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <div style="height:100%">
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
      <thead>
      
      <tr>
          <td style="border:0px;" colspan="30"><h2 align="center">International Consumer Products Bangladesh Ltd.</h2><br /></td>
        </tr>
      
        <tr>
          <td style="border:0px;" colspan="30"><h2 align="center">Bank Account Statment</h2><br /></td>
        </tr>
        <tr>
          <th>S/L</th>
          <th>Name</th>
          <th>Desgnation</th>
          
          <th><div align="center">Bank Acc.</div></th>
          <th>Gross</th>
          <th align="center"><div align="center">Net Payable Salary </div></th>
        </tr>
       
      </thead>
      <tbody>
        <?
		$ddd='';
$sqld = 'select t.*, a.PBI_ID, a.PBI_ID_UNIQUE, a.PBI_NAME, a.PBI_DOJ, d.DEPT_DESC, g.DESG_SHORT_NAME as Designation, e.ESS_BANK_ACC_NO 

from  salary_attendence t,designation g, department d, personnel_basic_info a, essential_info e 

where e.ESS_BANK_ACC_NO>0 and t.PBI_ID=a.PBI_ID and e.PBI_ID=t.PBI_ID and t.PBI_DESIGNATION = g.DESG_ID and t.PBI_DEPARTMENT = d.DEPT_ID and t.mon='.$_POST['mon'].' and t.year='.$_POST['year'].' '.$con.' order by t.gross_salary desc';

$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
        <tr>
          <td style="width:2%"><div align="center">
            <?=++$s?>
          </div></td>
          
          <td><div align="left">
            <?=$data->PBI_NAME?>
          </div></td>
          <td><div align="left">
            <?=$data->Designation?>
          </div></td>
          
          <td><?=$data->ESS_BANK_ACC_NO?></td>
          <td><div align="right">
            <?=$data->gross_salary; $totGross+=$data->gross_salary;?>
          </div></td>
          
          <td align="right"><div align="right"><? echo number_format($data->total_payable,2); $total_cash += $data->total_payable;?></div></td>
        </tr>
        <?
}
?>
        <tr>
         <td colspan="4">Total</td>
          <td><div align="right">
            <?=number_format($totGross,2)?>
          </div></td>
          <td align="right">
            <div align="right">
              <?=number_format($total_cash,2)?>
            </div></td>
        </tr>
      </tbody>
    </table>
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	
	
	 <br>
    <br>
   
	<div style="width:100%; margin:0 auto">
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Prepared By</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
      Checked By (Mgr-Act and Fin)</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
      Head of HR & Admin</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Head of Sales & Operation</div>
      <div style="float:left; width:20%; text-align:center">-------------------<br>
        Managing Director</div>
    </div><br /><br /><br /><br />
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <?
	
}
elseif($_POST['report']==80) 
{

?><table width="100%" cellspacing="0" cellpadding="2" border="0">
<thead><tr><td style="border:0px;" colspan="13" align="center"><?=$str?></td></tr>

<tr>
  <th rowspan="3"><div align="center">S/L</div></th>
<th rowspan="3"><div align="center">ID</div></th>
<th rowspan="3"><div align="center">Name</div></th>
<th rowspan="3"><div align="center">Desgnation</div></th>
<th rowspan="3" nowrap="nowrap"><div align="center">Joining Date </div></th>
<th rowspan="3" nowrap="nowrap"><div align="center">Job Period </div></th>
<th colspan="2" align="center"><div align="center">Salary</div></th>
<th rowspan="3"><div align="center">Bonus (Basic) %</div></th>
<th rowspan="3"><div align="center">Bonus Amount </div></th>
<th rowspan="3"><div align="center">Bank Acc.</div></th>
<th rowspan="3"><div align="center">Payroll Card No</div></th>
<th rowspan="3"><div align="center">Remarks</div></th>
</tr>
<tr>
  <th><div align="center">Gross</div></th>
  <th><div align="center">Basic</div></th>
</tr>
<tr>
  <th><div align="center">100%</div></th>
  <th><div align="center">50%</div></th>
  </tr>
</thead>
<tbody>
<?
if($_POST['branch']!='')
$con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

         $sqld="select a.PBI_ID, a.PBI_NAME, d.DESG_SHORT_NAME as designation, date_format(a.PBI_DOJ,'%d-%b-%y') as joining_date, 
		 b.job_period,
		 b.gross_salary,
		b.basic_salary, 
		b.bonus_percent,
		b.bonus_amt,
		if(s.cash_bank='Estern Bank Limited',s.cash,'') as bank_ac,
		s.card_no  
		from 
		personnel_basic_info a, salary_bonus b, salary_info s, designation d 
		where 
		1 and a.PBI_DESIGNATION=d.DESG_ID and a.PBI_ID=b.PBI_ID and 
		s.PBI_ID=b.PBI_ID and b.bonus_type=".$_POST['bonus_type']." and 
		b.year=".$_POST['year']." ".$con. " 
		order by b.bonus_amt desc";

$queryd=db_query($sqld);

while($data = mysqli_fetch_object($queryd)){
$entry_by=$data->entry_by;
?>
<tr><td><?=++$s?></td>
<td><?=$data->PBI_ID?></td>
<td nowrap="nowrap"><?=$data->PBI_NAME?></td>
  <td nowrap="nowrap"><?=$data->designation?></td>
  <td align="center"><?=$data->joining_date?></td>
  <td align="center"><?=$data->job_period?></td>
  <td align="right"><?=($data->gross_salary>0)? $data->gross_salary : ''; $tot_gross+=$data->gross_salary;?></td>
  <td align="right"><?=($data->basic_salary>0)? $data->basic_salary : ''; $tot_basic+=$data->basic_salary;?></td>
  <td align="center"><?=$data->bonus_percent?></td>
  <td align="right"><?=$data->bonus_amt; $totalBonus+=$data->bonus_amt;?></td>
  <td><?=$data->bank_ac;?></td>
  <td><?=$data->card_no;?></td>
  <td>&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="6" align="right">Total:</td>
  <td align="right"><?=$tot_gross?></td>
  <td align="right"><?=$tot_basic?></td>
  <td>&nbsp;</td>
  <td align="right"><?=$totalBonus?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
In Words:
<?

echo convertNumberMhafuz($totalBonus);

?>
<br><br><br>



<div style="width:100%; margin:60px auto">

<div style="float:left; width:20%; text-align:center">-------------------<br>Prepared By</div>
<div style="float:left; width:20%; text-align:center">-------------------<br>Checked By</div>
<div style="float:left; width:20%; text-align:center">-------------------<br>Accounts</div>
<div style="float:left; width:20%; text-align:center">-------------------<br>Managing Director</div>
<div style="float:left; width:20%; text-align:center">-------------------<br>Chairman</div>

</div>
<?
}
elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}
?>
  </div>
</form>
</body>
</html>
