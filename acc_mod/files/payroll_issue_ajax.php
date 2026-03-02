<?php
session_start();


$proj_id=$_SESSION['proj_id'];
$basic_amt=$_REQUEST['basic_amt'];
$home_rent=$_REQUEST['home_rent'];
$convence_bill=$_REQUEST['convence_bill'];
$phone_bill=$_REQUEST['phone_bill'];
$medical_allowance=$_REQUEST['medical_allowance'];
$benefits=$_REQUEST['benefits'];
$advance=$_REQUEST['advance'];
$deductions=$_REQUEST['deductions'];
$income_tax=$_REQUEST['income_tax'];
$pf_amt=$_REQUEST['pf_amt'];

$issuedt=$_REQUEST['issuedt'];
$chmonth=$_REQUEST['chmonth'];
$chyear=$_REQUEST['chyear'];

$sub_total=$_REQUEST['sub_total'];
$total=$_REQUEST['total'];
$id=$_REQUEST['id'];

$sql="select * from emp_salary_info where month='$chmonth' and year='$chyear' and eid=$id";
$query=db_query($sql);
$count=mysqli_num_rows($query);
if($count==0)
$sql="INSERT INTO `emp_salary_info` ( `eid`, `salary_date`, `month`, `year`, `basic_amt`, `home_rent`, `convence_bill`, `phone_bill`, `medical_allowance`, `benefits`, `income_tax`, `pf_amt`, `advance`, `deductions`, `total`, `status`) VALUES ( '$id','$issuedt', '$chmonth', '$chyear','$basic_amt', '$home_rent', '$convence_bill', '$phone_bill', '$medical_allowance', '$benefits', '$income_tax', '$pf_amt', '$advance', '$deductions', '$total', '0')";

else
$sql="UPDATE `emp_salary_info` SET 
`basic_amt` = '$basic_amt',
`home_rent` = '$home_rent',
`convence_bill` = '$convence_bill',
`phone_bill` = '$phone_bill',
`medical_allowance` = '$medical_allowance',
`income_tax` = '$income_tax',
`salary_date` = '$issuedt',
`benefits` = '$benefits',
`deductions` = '$deductions',
`total` = '$total',
`income_tax` = '$income_tax',
`pf_amt` = '$pf_amt' WHERE `eid` =$id and month='$chmonth' and year='$chyear'";
db_query($sql);
echo 'Updated';


?>