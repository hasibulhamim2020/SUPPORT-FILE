<?php
session_start();


$proj_id=$_SESSION['proj_id'];
$basic_amt=$_REQUEST['basic_amt'];
$home_rent=$_REQUEST['home_rent'];
$convence_bill=$_REQUEST['convence_bill'];
$phone_bill=$_REQUEST['phone_bill'];
$medical_allowance=$_REQUEST['medical_allowance'];
$income_tax=$_REQUEST['income_tax'];
$pf_amt=$_REQUEST['pf_amt'];

$sub_total=$_REQUEST['sub_total'];
$total=$_REQUEST['total'];
$id=$_REQUEST['id'];

$sql="select 1 from emp_salary_scale where id=".$id;
$query=db_query($sql);
$count=mysqli_num_rows($query);
if($count==0)
$sql="INSERT INTO `emp_salary_scale` (`id`, `basic_amt`, `home_rent`, `convence_bill`, `phone_bill`, `medical_allowance`, `income_tax`, `pf_amt`) VALUES ('$id', '$basic_amt', '$home_rent', '$convence_bill', '$phone_bill', '$medical_allowance', '$income_tax', '$pf_amt')";
else
$sql="UPDATE `emp_salary_scale` SET 
`basic_amt` = '$basic_amt',
`home_rent` = '$home_rent',
`convence_bill` = '$convence_bill',
`phone_bill` = '$phone_bill',
`medical_allowance` = '$medical_allowance',
`income_tax` = '$income_tax',
`pf_amt` = '$pf_amt' WHERE `id` =$id";
db_query($sql);
echo 'Updated';


?>