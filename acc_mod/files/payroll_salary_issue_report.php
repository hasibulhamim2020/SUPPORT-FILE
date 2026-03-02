<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Monthly Salary';
do_calander('#issuedt');
$proj_id=$_SESSION['proj_id'];

$dept_name=$_REQUEST['dept_name'];
$chmonth=$_REQUEST['chmonth'];
$issuedt=$_REQUEST['issuedt'];
$chyear=$_REQUEST['chyear'];


function GetMonthString($n)
{
    $timestamp = mktime(0, 0, 0, $n, 1, 2005);
    return date("F", $timestamp);
}
?>

<form id="form1" name="form1" method="post" action=""><div class="box">
  <table width="39%" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="23%" height="22" align="left">Dept:</td>
      <td width="35%" align="left"><label>
        <select name="dept_name" id="dept_name">
          <?php 
		  $sql="select dept_id,dept_name from depertment_info ";
			$deptq=db_query($sql);
			while($deptv=mysqli_fetch_row($deptq))
	        { 
			?>
          <option value="<?php echo $deptv[0]; ?>" selected="selected"><?php echo $deptv[1]; ?> </option>
          <?php } ?>
        </select>
        </label>      </td>
      <td width="23%" align="left">&nbsp;</td>
      <td width="19%" align="left">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="left" valign="top">Month: </td>
      <td align="left" valign="top"><select name="chmonth" id="chmonth">
	  <?
	  if(isset($chmonth)&&$chmonth>0)
	  echo '<option value="'.$chmonth.'">'.GetMonthString($chmonth).'</option>';
	  ?>
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
	  <?
	  if(isset($chyear)&&$chyear>0)
	  echo '<option>'.$chyear.'</option>';
	  else
	  echo '<option>'.(date('Y',time())).'</option>';
	  ?>
	  <option>2010</option>
	  <option>2011</option>
	  <option>2012</option>
	  <option>2013</option>
	  <option>2014</option>
	  <option>2015</option>
      </select></td>
    </tr>
  </table>
</div>
  <div align="center" style="margin-top:10px;">
    <input name="salaryreport" type="submit" id="budget" value="Show" style="background:#84b1c6; border-color:#4b6677; font-size:11px;"/>
  </div></form><table width="100%" border="0" cellpadding="0">
  <tr>
    <td align="right"><? include('PrintFormat.php');?></td>
  </tr>
</table>

  <div id="reporting">
  <table id="grp" width="95%" border="1" align="center" cellpadding="1" cellspacing="0" style="padding:2px; border:1px solid #a8c5c1;border-collapse:collapse; font-family:Arial, Helvetica, sans-serif;">
    <tr style="background:url(../images/bg_header.jpg) repeat-x; color:#37535a; font-size:11px;">
      <td align="center" style="padding-top:6px; padding-bottom:6px;">Dept</td>
      <td align="center" style="padding-top:6px; padding-bottom:6px;"><label for="checkbox_row_1">Emp ID</label></td>
      <td align="center"><label for="checkbox_row_2">Emp Name</label></td>
      <td align="center"><label for="checkbox_row_5">Basic</label></td>
      <td align="center"><label for="checkbox_row_6">Home Rent</label></td>
      <td align="center"><label for="checkbox_row_7">Conv. Bill</label></td>
      <td align="center"><label for="checkbox_row_8">Phone Bill</label></td>
      <td align="center"><label for="checkbox_row_9">Medical All.</label></td>
      <td align="center">Other Benefits </td>
      <td align="center"><label for="checkbox_row_10">Sub Total</label></td>
      <td align="center"><label for="checkbox_row_10">Inc Tax</label></td>
      <td align="center"><label for="checkbox_row_11">Prov. Fund </label></td>
      <td align="center">Advance</td>
      <td align="center">Other Deductions </td>
      <td align="center"><label for="checkbox_row_14"> Total </label></td>
    </tr>
    <?php if(isset($_REQUEST['salaryreport'])){
			$action_type = '';

		if($dept_name!='')
		{
$ssql="SELECT b.emp_name,b.emp_id,c.dept_name,b.emp_id, b.id FROM employee_info b,depertment_info c where c.dept_id=b.dept_id and c.dept_id like '$dept_name'";
$query2=db_query($ssql); 
$color=0;
while($data=mysqli_fetch_object($query2)){
$color++;

$sql="select * from emp_salary_info where month='$chmonth' and year='$chyear' and eid=$data->id";
$query=db_query($sql);
$count=mysqli_num_rows($query);
if($count>0)
{
$action='Change';
$datas=mysqli_fetch_object($query);
$sub_total=($datas->basic_amt+$datas->home_rent+$datas->convence_bill+$datas->phone_bill+$datas->medical_allowance+$datas->benefits);
$total=$sub_total-($datas->income_tax+$datas->pf_amt+$datas->advance+$datas->deductions);
}
else
{
$sql="select * from emp_salary_scale where id=$data->id";
$query=db_query($sql);
$count=mysqli_num_rows($query);
if($count==0)
$action='Set';
else
{
$action='Set';
$datas=mysqli_fetch_object($query);
$sub_total=($datas->basic_amt+$datas->home_rent+$datas->convence_bill+$datas->phone_bill+$datas->medical_allowance);
$total=($datas->basic_amt+$datas->home_rent+$datas->convence_bill+$datas->phone_bill+$datas->medical_allowance)-($datas->income_tax+$datas->pf_amt);
}}
?>

<tr <? if($color%2) echo 'bgcolor="#FFFFFF"'; else echo 'bgcolor="#e9f4f6"';?>>
	  <td align="center" valign="top" style="font-size:9px; color:#000000; padding-top:10px; padding-bottom:10px;"><?=$data->dept_name;?></td>
				<td height="22" align="center" valign="top" style="font-size:9px; color:#000000; padding-top:10px; padding-bottom:10px;"><?=$data->emp_id;?></td>
				<td height="22" align="center"  style="font-size:10px; color:#000000;"><?=$data->emp_name;?></td>
				<td align="center"><?=$datas->basic_amt;?></td>
				<td align="center"><?=$datas->home_rent;?></td>
				<td align="center"><?=$datas->convence_bill;?></td>
				<td align="center"><?=$datas->phone_bill;?></td>
				<td align="center"><?=$datas->medical_allowance;?></td>
				<td align="center"><?=$datas->benefits;?></td>
				<td align="center"><?=$sub_total;?></td>
				<td align="center"><?=$datas->income_tax;?></td>
				<td align="center"><?=$datas->pf_amt;?></td>
				<td align="center"><?=$datas->advance;?></td>
				<td align="center"><?=$datas->deductions;?></td>
				<td align="center"><?=$total;?></td>
    </tr>	




<?php }}
$total=($datas->basic_amt+$datas->home_rent+$datas->convence_bill+$datas->phone_bill+$datas->medical_allowance)-($datas->income_tax+$datas->pf_amt);

$sql="Select sum(basic_amt),sum(home_rent),sum(convence_bill),sum(phone_bill),sum(medical_allowance),sum(income_tax),sum(pf_amt),sum(benefits),sum(advance),sum(deductions) from emp_salary_info a,employee_info b where b.dept_id like '$dept_name' and a.eid=b.id and a.month='$chmonth' and a.year='$chyear'";
$info=mysqli_fetch_row(db_query($sql));
?>
	<tr style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;">
      <td colspan="3" align="center" style="padding-top:6px; padding-bottom:6px; font-size:11px;">Total(Emp): <?=$color?></td>
      <td align="right"><?=$info[0]?></td>
      <td align="right"><?=$info[1]?></td>
      <td align="right"><?=$info[2]?></td>
      <td align="right"><?=$info[3]?></td>
      <td align="right"><?=$info[4]?></td>
      <td align="right"><?=$info[7]?></td>
      <td align="right"><?=($info[0]+$info[1]+$info[2]+$info[3]+$info[4]+$info[7])?></td>
      <td align="right"><?=$info[5]?></td>
      <td align="right"><?=$info[6]?></td>
      <td align="right"><?=$info[8]?></td>
      <td align="right"><?=$info[9]?></td>
      <td align="right"><?=(($info[0]+$info[1]+$info[2]+$info[3]+$info[4]+$info[7])-($info[5]+$info[6]+$info[8]+$info[9]))?></td>
    </tr><? }?>
  </table>
  </div>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>