<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Salary Issue Process';

$proj_id=$_SESSION['proj_id'];

$dept_name=$_REQUEST['dept_name'];
$chmonth=$_REQUEST['chmonth'];
$issuedt=$_REQUEST['issuedt'];
$chyear=$_REQUEST['chyear'];

//to date create
$j=0;
for($i=0;$i<strlen($issuedt);$i++)
{
if(is_numeric($issuedt[$i]))
$time[$j]=$time[$j].$issuedt[$i];
else $j++;
}
$issuedtf=mktime(0,0,0,$time[1],$time[0],$time[2]);
////////////////////

if(isset($_POST['action_type']))
	{
				
				$action_type = $_POST['action_type'];
   	
   				$salary_datef = $_POST['salary_date']; ///date	
				
		//// post value
			    $employee = $_POST['employee'];
				$month = $_POST['month'];
				$year = $_POST['year'];
				$basic_amt = $_POST['basic_amt'];
				$home_rent = $_POST['home_rent'];
				$convence_bill = $_POST['convence_bill'];
				$phone_bill = $_POST['phone_bill'];
				$medical_allowance = $_POST['medical_allowance'];
				$income_tax = $_POST['income_tax'];
				$pf_amt = $_POST['pf_amt'];
				$advance = $_POST['advance'];
				$arear = $_POST['arear'];
				$total_attend = $_POST['total_attend'];
				$emonth=$_POST['emonth'];
				$eyear=$_POST['eyear'];
				$net_payable=$_POST['net_payable'];
				
		//var_dump($_POST);
		//exit();
		////end 
		
		if($action_type == 'insert')
			{
				//do Insert
				for($i=0; $i<count($employee); $i++)
					{
						$new_salary_dt = strtotime($salary_datef[$i]);
						//$new_salary_dt = $salary_datef[$i];
						echo '<br/>--->salary date'. $new_salary_dt;
						//exit();
							$invoice_no=mysqli_fetch_row(db_query("select MAX(jv_no) from journal LIMIT 1"));
							$jv= date("Ymd")."0000";
							if($invoice_no[0]>$jv)
							$jv_no=$invoice_no[0]+1;
							else
							$jv_no=$jv+1;
													
						$insertq=db_query("insert into emp_salary_info values(".$employee[$i].", ".$new_salary_dt.", ".$month[$i].",".$year[$i].", ".$basic_amt[$i].", ".$home_rent[$i].", ".$convence_bill[$i].", ".$phone_bill[$i].", ".$medical_allowance[$i].", ".$income_tax[$i].", ".$pf_amt[$i].", ".$advance[$i].", ".$arear[$i].", ".$total_attend[$i].", ".$jv_no.")");
					
							$invoice_no=mysqli_fetch_row(db_query("select MAX(jv_no) from journal LIMIT 1"));
							$jv= date("Ymd")."0000";
							if($invoice_no[0]>$jv)
							$jv_no=$invoice_no[0]+1;
							else
							$jv_no=$jv+1;

						    $id=db_query("select ei.emp_name,sl.ledger_id,sl.sub_ledger_id from sub_ledger sl join employee_info ei on sl.sub_ledger_id=ei.sub_ledger_id where ei.emp_id=".$employee[$i]."");
							$emp_name=mysqli_result($id,0,'ei.emp_name');
							$ledger_id=mysqli_result($id,0,'sl.ledger_id');
							$sub_ledger_id=mysqli_result($id,0,'sl.sub_ledger_id');					
							
						$insertque=db_query("insert into journal values('".$proj_id."', ".$jv_no.", ".$new_salary_dt.", ".$ledger_id.", 'Salary Payable ".$emp_name." for the month of ".$month[$i]." ".$year[$i]."',0, ".$net_payable[$i].", 'Payroll',0, ".$sub_ledger_id.")");
					
					$insertquery=db_query($insertque);
					}

								
			}
		if($action_type == 'update')
			{
				//do update
				for($i=0; $i<count($employee); $i++)
					{
					//echo "<br />Salary Date: ".$salary_datef[$i];
					
					$new_salary_dt = strtotime($salary_datef[$i]);
				
						$updateq=db_query("update emp_salary_info set salary_date=".$new_salary_dt.", month=".$month[$i].", year=".$year[$i].", basic_amt=".$basic_amt[$i].", home_rent=".$home_rent[$i].", convence_bill=".$convence_bill[$i].", phone_bill=".$phone_bill[$i].", medical_allowance=".$medical_allowance[$i].", income_tax=".$income_tax[$i].", pf_amt=".$pf_amt[$i].", advance=".$advance[$i].", arear=".$arear[$i].", total_attend=".$total_attend[$i]." where emp_id=".$employee[$i]." and month=$emonth and year=$eyear");

						$selectque="select jv_no from emp_salary_info where emp_id=$employee[$i] and month=$emonth and year=$eyear";
						$resultjvn1=db_query($selectque);
						$resultjvno=mysqli_result($resultjvn1,0,'jv_no');
			
						$updateque=db_query("update journal set cr_amt =".$net_payable[$i]." where jv_no=".$resultjvno."");
					}
				
				
			}	
	}//end main if



?>

<form id="form1" name="form1" method="post" action=""><div class="box">
  <table width="39%" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="23%" height="22" align="left">Dept:</td>
      <td width="35%" align="left"><label>
        <select name="dept_name" id="dept_name">
          <?php 
			$deptq=db_query("select ledger_id,dept_name from depertment_info ");
			while($deptv=mysqli_fetch_row($deptq))
	        { 
			?>
          <option value="<?php echo $deptv[0]; ?>" selected="selected"><?php echo $deptv[1]; ?> </option>
          <?php } ?>
          <option value="%" selected="selected"> All</option>
        </select>
        </label>
      </td>
      <td width="23%" align="left">Date: </td>
      <td width="19%" align="left"><label>
        <input name="issuedt" type="text" id="issuedt" size="10" maxlength="10" />
      </label></td>
    </tr>
    <tr>
      <td height="22" align="left" valign="top">Month: </td>
      <td align="left" valign="top"><select name="chmonth" id="chmonth">
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
      </select></td>
      <td align="left" valign="top">Year:</td>
      <td align="left" valign="top">
	  <select name="chyear" id="chyear">
	  <option><?=(date('Y',time()))?></option>
	  <option>2010</option>
	  <option>2011</option>
	  <option>2012</option>
	  <option>2013</option>
	  <option>2014</option>
	  <option>2015</option>
      </select></td>
    </tr>
  </table></div>
  <div align="center" style="margin-top:10px;">
    <input name="salaryreport" type="submit" id="budget" value="Show" style="background:#84b1c6; border-color:#4b6677; font-size:11px;"/>
  </div>
  <span id="show">
  <div align="center">&nbsp;</div>
  </span>
  <table width="95%" border="1" align="center" cellpadding="1" cellspacing="0" style="padding:2px; border:1px solid #a8c5c1;border-collapse:collapse; font-family:Arial, Helvetica, sans-serif;">
    <tr style="background:url(../images/bg_header.jpg) repeat-x; color:#37535a; font-size:11px;">
      <td align="center" style="padding-top:6px; padding-bottom:6px;"><label for="checkbox_row_1">Emp Id</label></td>
      <td align="center"><label for="checkbox_row_2">Employee Name</label></td>
      <td align="center"><label for="checkbox_row_2">Salary Date</label></td>
      <td align="center"><label for="checkbox_row_3">Month</label></td>
      <td align="center"><label for="checkbox_row_5">Basic Amount</label></td>
      <td align="center"><label for="checkbox_row_6">Home Rent</label></td>
      <td align="center"><label for="checkbox_row_7">Conv. Bill</label></td>
      <td align="center"><label for="checkbox_row_8">Phone Bill</label></td>
      <td align="center"><label for="checkbox_row_9">Medical Allowance</label></td>
      <td align="center"><label for="checkbox_row_10">Income Tax</label></td>
      <td align="center"><label for="checkbox_row_10">Income Tax</label></td>
      <td align="center"><label for="checkbox_row_11">Provident Fund </label></td>
      <td align="center"><label for="checkbox_row_12">Advance</label></td>
      <td align="center"><label for="checkbox_row_13">Arear</label></td>
      <td align="center"><label for="checkbox_row_14">Total Attend</label></td>
    </tr>
    <?php if(isset($_REQUEST['salaryreport'])){
			$action_type = '';
		
		if ($dept_name!='')
		{
$ssql="SELECT a.*,b.emp_name FROM emp_salary_info a,employee_info b where a.emp_id=b.sub_ledger_id and b.ledger_id like '$dept_name' and a.month='$chmonth' and a.year='$chyear'";
$query2=db_query($ssql); 
if(mysqli_num_rows($query2)>0)
{
$action_type ='update';
}
else
{
$action_type ='insert';
$ssql="SELECT a.*,b.emp_name,b.emp_id as employee_id FROM emp_salary_scale a,employee_info b where a.emp_id=b.sub_ledger_id";
$query2=db_query($ssql); 
}
$color=0;
while($data=mysqli_fetch_object($query2)){
if($action_type =='insert')
{
$data->salary_date=date('Y-m-d');
$data->month=$chmonth;
$data->year=$chyear;
}
$color++;
?>
    <tr <? if($color%2) echo 'bgcolor="#FFFFFF"'; else echo 'bgcolor="#e9f4f6"';?>  style="color:#37535a; font-size:9px; color:#000000;">
      <td height="22" align="center" valign="top" style="font-size:9px; color:#000000; padding-top:10px; padding-bottom:10px;"><?php echo $data->employee_id;?></td>
      <td height="22" align="center"  style="font-size:10px; color:#000000;"><?php echo $data->emp_name;?></td>
      <td align="center"><?php echo $data->salary_date;?></td>
      <td align="center"><?php echo $data->month;?></td>
      <td align="right"><?php echo $data->basic_amt;?></td>
      <td align="right"><?php echo $data->home_rent;?></td>
      <td align="right"><?php echo $data->convence_bill;?></td>
      <td align="right"><?php echo $data->phone_bill;?></td>
      <td align="right"><?php echo $data->medical_allowance;?></td>
      <td align="right" style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;"><?php echo $data->income_tax;?></td>
      <td align="right"><?php echo $data->income_tax;?></td>
      <td align="right"><?php echo $data->pf_amt;?></td>
      <td align="right"><?php echo $data->advance;?></td>
      <td align="right"><?php echo $data->arear;?></td>
      <td align="right" style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;"><?php echo $data->total_attend;?>      </td>
    </tr>	
    <?php }}}?>
	<tr style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;">
      <td colspan="2" align="center" style="padding-top:6px; padding-bottom:6px; font-size:11px;">Total(Emp.): <?=$color?></td>
      <td colspan="2" align="right" style="font-size:11px;">Total(Amount):</td>
      <td align="right">10000000</td>
      <td align="right">10000000</td>
      <td align="right">10000000</td>
      <td align="right">10000000</td>
      <td align="right">10000000</td>
      <td align="right">10000000</td>
      <td align="right">10000000</td>
      <td align="right">10000000</td>
      <td align="right">10000000</td>
      <td align="right">10000000</td>
      <td align="right">150000000</td>
    </tr>
  </table>
</form>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>