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
////////////////////




?>
<script>

function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	

		try{

			xmlhttp=new XMLHttpRequest();

		}

		catch(e)	{		

			try{			

				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){

				try{

				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				}

				catch(e1){

					xmlhttp=false;

				}

			}

		}

		 	

		return xmlhttp;

    }

	function check_field(c_id)
	{
		if(isNaN(document.getElementById(c_id).value))
			{
			alert("Please re-enter.");
			document.getElementById(c_id).value='';
			document.getElementById(c_id).focus();
			return null;
			}
			else
			{
			var value=document.getElementById(c_id).value;
			return value;
			}
	}
	
	function add_all(id)
	{
var basic_amt=check_field('basic_amt'+id);
var home_rent=check_field('home_rent'+id);
var convence_bill=check_field('convence_bill'+id);
var phone_bill=check_field('phone_bill'+id);
var medical_allowance=check_field('medical_allowance'+id);
var benefits=check_field('benefits'+id);
var income_tax=check_field('income_tax'+id);
var pf_amt=check_field('pf_amt'+id);
var advance=check_field('advance'+id);
var deductions=check_field('deductions'+id);

document.getElementById('sub_total'+id).value=((basic_amt*1)+(home_rent*1)+(convence_bill*1)+(phone_bill*1)+(medical_allowance*1)+(benefits*1));
document.getElementById('total'+id).value=((basic_amt*1)+(home_rent*1)+(convence_bill*1)+(phone_bill*1)+(medical_allowance*1)+(benefits*1))-((income_tax*1)+(pf_amt*1)+(advance*1)+(deductions*1));
	}

function update_value(id)
{
var basic_amt=document.getElementById('basic_amt'+id).value;
var home_rent=document.getElementById('home_rent'+id).value;
var convence_bill=document.getElementById('convence_bill'+id).value;
var phone_bill=document.getElementById('phone_bill'+id).value;
var medical_allowance=document.getElementById('medical_allowance'+id).value;
var benefits=document.getElementById('benefits'+id).value;
var advance=document.getElementById('advance'+id).value;
var deductions=document.getElementById('deductions'+id).value;
var income_tax=document.getElementById('income_tax'+id).value;
var pf_amt=document.getElementById('pf_amt'+id).value;

var issuedt=document.getElementById('issuedt').value;
var chmonth=document.getElementById('chmonth').value;
var chyear=document.getElementById('chyear').value;

var sub_total=document.getElementById('sub_total'+id).value;
var total=document.getElementById('total'+id).value;


var strURL="payroll_issue_ajax.php?id="+id+"&basic_amt="+basic_amt+"&home_rent="+home_rent+"&convence_bill="+convence_bill+"&phone_bill="+phone_bill+"&medical_allowance="+medical_allowance+"&benefits="+benefits+"&sub_total="+sub_total+"&income_tax="+income_tax+"&pf_amt="+pf_amt+"&advance="+advance+"&deductions="+deductions+"&total="+total+"&issuedt="+issuedt+"&chmonth="+chmonth+"&chyear="+chyear;
		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
			if (req.readyState == 4) {
					if (req.status == 200) {						
						document.getElementById('divi_'+id).style.display='inline';
						document.getElementById('divi_'+id).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}
			req.open("GET", strURL, true);
			req.send(null);
		}	
}


</script>
<form id="form1" name="form1" method="post" action=""><div class="box">
  <table width="39%" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="23%" height="22" align="left">Dept:</td>
      <td width="35%" align="left"><label>
        <select name="dept_name" id="dept_name">
          <?php 
			$deptq=db_query("select dept_id,dept_name from depertment_info ");
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
        <input name="issuedt" type="text" id="issuedt" size="10" maxlength="10" value="<?=date("Y-m-d")?>" />
      </label></td>
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
  </table></div>
  <div align="center" style="margin-top:10px;">
    <input name="salaryreport" type="submit" id="budget" value="Show" style="background:#84b1c6; border-color:#4b6677; font-size:11px;"/>
  </div>
  <span id="show">
  <div align="center">&nbsp;</div>
  </span>
  <table width="95%" border="1" align="center" cellpadding="1" cellspacing="0" style="padding:2px; border:1px solid #a8c5c1;border-collapse:collapse; font-family:Arial, Helvetica, sans-serif;">
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
      <td align="center"><label for="checkbox_row_14">Update</label></td>
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
				<td align="center"><input name="basic_amt<?=$data->id;?>" id="basic_amt<?=$data->id;?>" type="text" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->basic_amt;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center"><input name="home_rent<?=$data->id;?>" type="text" id="home_rent<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->home_rent;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center"><input name="convence_bill<?=$data->id;?>" type="text" id="convence_bill<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->convence_bill;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center"><input name="phone_bill<?=$data->id;?>" type="text" id="phone_bill<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->phone_bill;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center"><input name="medical_allowance<?=$data->id;?>" type="text" id="medical_allowance<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->medical_allowance;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center" style="color:#990033; font-size:10px; font-weight:bold;"><input name="benefits<?=$data->id;?>" type="text" id="benefits<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->benefits;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center" style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;"><input name="sub_total<?=$data->id;?>" type="text" id="sub_total<?=$data->id;?>" style="width:50px; font-size:9px; border:1px solid #c1dad7; color:#990033; text-align:right; " value="<?=$sub_total;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center"><input name="income_tax<?=$data->id;?>" type="text" id="income_tax<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->income_tax;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center"><input name="pf_amt<?=$data->id;?>" type="text" id="pf_amt<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->pf_amt;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center" style="color:#990033; font-size:10px; font-weight:bold;"><input name="advance<?=$data->id;?>" type="text" id="advance<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->advance;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center" style="color:#990033; font-size:10px; font-weight:bold;"><input name="deductions<?=$data->id;?>" type="text" id="deductions<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->deductions;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center" style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;"><input name="total<?=$data->id;?>" type="text" id="total<?=$data->id;?>" style="text-align:right; width:50px; font-size:9px; border:1px solid #c1dad7; color:#990033;" value="<?=$total;?>" onchange="add_all(<?=$data->id;?>)" /></td>
	  <td align="center" style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;"><span id="divi_<?=$data->id;?>"><input name="update<?=$data->id;?>" type="button" id="update<?=$data->id;?>" style="background:#84b1c6; border-color:#4b6677; font-size:11px; width:50px;"   onclick="add_all(<?=$data->id;?>);update_value(<?=$data->id;?>)" value="<?=$action?>" /></span></td>
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
      <td align="right">&nbsp;</td>
    </tr><? }?>
  </table>
  <div align="center" style="margin-top:5px;">
    <input type="hidden" id="action_type" name="action_type" />
  </div>
</form>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>