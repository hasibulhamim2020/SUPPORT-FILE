<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Monthly Salary Scale';
$page_url='payroll_salary_scale.php';
do_calander('#issuedt');
$proj_id=$_SESSION['proj_id'];

$dept_name=$_REQUEST['dept_name'];

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
		
		if($action_type == 'Set')
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
<script type="text/javascript" src="../js/ddaccordion.js"></script>
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
var income_tax=check_field('income_tax'+id);
var pf_amt=check_field('pf_amt'+id);

document.getElementById('sub_total'+id).value=((basic_amt*1)+(home_rent*1)+(convence_bill*1)+(phone_bill*1)+(medical_allowance*1));
document.getElementById('total'+id).value=((basic_amt*1)+(home_rent*1)+(convence_bill*1)+(phone_bill*1)+(medical_allowance*1))-((income_tax*1)+(pf_amt*1));
	}

function update_value(id)
{
var basic_amt=document.getElementById('basic_amt'+id).value;
var home_rent=document.getElementById('home_rent'+id).value;
var convence_bill=document.getElementById('convence_bill'+id).value;
var phone_bill=document.getElementById('phone_bill'+id).value;
var medical_allowance=document.getElementById('medical_allowance'+id).value;
var income_tax=document.getElementById('income_tax'+id).value;
var pf_amt=document.getElementById('pf_amt'+id).value;

var sub_total=((basic_amt*1)+(home_rent*1)+(convence_bill*1)+(phone_bill*1)+(medical_allowance*1));
var total=((basic_amt*1)+(home_rent*1)+(convence_bill*1)+(phone_bill*1)+(medical_allowance*1))-((income_tax*1)+(pf_amt*1));


var strURL="payroll_scale_ajax.php?id="+id+"&basic_amt="+basic_amt+"&home_rent="+home_rent+"&convence_bill="+convence_bill+"&phone_bill="+phone_bill+"&medical_allowance="+medical_allowance+"&sub_total="+sub_total+"&income_tax="+income_tax+"&pf_amt="+pf_amt+"&total="+total;
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
          <option value="<?=$deptv[0]; ?>" <? if($dept_name==$deptv[0]) echo 'selected="selected"';?>><?=$deptv[1]; ?> </option>
          <?php } ?>
          <option value="%"> All</option>
        </select>
        </label>      </td>
      </tr>
  </table>
</div>
  <div align="center" style="margin-top:10px;">
    <input name="salaryreport" type="submit" id="salaryreport" value="Show" style="background:#84b1c6; border-color:#4b6677; font-size:11px;"/>
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
      <td align="center"><label for="checkbox_row_10">Sub Total</label></td>
      <td align="center"><label for="checkbox_row_10">Inc Tax</label></td>
      <td align="center"><label for="checkbox_row_11">Prov. Fund </label></td>
      <td align="center"><label for="checkbox_row_14"> Total </label></td>
      <td align="center"><label for="checkbox_row_14">Update</label></td>
    </tr>
    <?php if(isset($_REQUEST['salaryreport'])){
			$action_type = '';

		if($dept_name!='')
		{
$ssql="SELECT b.emp_name,b.emp_id,c.dept_name,b.emp_id, b.id FROM employee_info b,depertment_info c where c.dept_id=b.dept_id and c.dept_id = '$dept_name'";
$query2=db_query($ssql); 
$color=0;
while($data=mysqli_fetch_object($query2)){
$color++;
$sql="select * from emp_salary_scale where id=$data->id";
$query=db_query($sql);
$count=mysqli_num_rows($query);
if($count==0)
$action='Set';
else
{
$action='Change';
$datas=mysqli_fetch_object($query);
$sub_total=($datas->basic_amt+$datas->home_rent+$datas->convence_bill+$datas->phone_bill+$datas->medical_allowance);
$total=($datas->basic_amt+$datas->home_rent+$datas->convence_bill+$datas->phone_bill+$datas->medical_allowance)-($datas->income_tax+$datas->pf_amt);


}
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
				<td align="center" style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;"><input name="sub_total<?=$data->id;?>" type="text" id="sub_total<?=$data->id;?>" style="width:50px; font-size:9px; border:1px solid #c1dad7; color:#990033; text-align:right; " value="<?=$sub_total;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center"><input name="income_tax<?=$data->id;?>" type="text" id="income_tax<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->income_tax;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center"><input name="pf_amt<?=$data->id;?>" type="text" id="pf_amt<?=$data->id;?>" style="width:40px; font-size:9px; text-align:right;  border:1px solid #c1dad7;" value="<?=$datas->pf_amt;?>" onchange="add_all(<?=$data->id;?>)" /></td>
				<td align="center" style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;"><input name="total<?=$data->id;?>" type="text" id="total<?=$data->id;?>" style="text-align:right; width:50px; font-size:9px; border:1px solid #c1dad7; color:#990033;" value="<?=$total;?>" onchange="add_all(<?=$data->id;?>)" /></td>
	  <td align="center" style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;"><span id="divi_<?=$data->id;?>"><input name="update<?=$data->id;?>" type="button" id="update<?=$data->id;?>" style="background:#84b1c6; border-color:#4b6677; font-size:11px; width:50px;"   onclick="add_all(<?=$data->id;?>);update_value(<?=$data->id;?>)" value="<?=$action?>" /></span></td>
</tr>	




<?php }}
$total=($datas->basic_amt+$datas->home_rent+$datas->convence_bill+$datas->phone_bill+$datas->medical_allowance)-($datas->income_tax+$datas->pf_amt);

$sql="Select sum(basic_amt),sum(home_rent),sum(convence_bill),sum(phone_bill),sum(medical_allowance),sum(income_tax),sum(pf_amt) from emp_salary_scale a,employee_info b where b.dept_id=$dept_name and a.id=b.id";
$info=mysqli_fetch_row(db_query($sql));
?>
	<tr style="background:#EEEEEE; color:#990033; font-size:10px; font-weight:bold;">
      <td colspan="3" align="center" style="padding-top:6px; padding-bottom:6px; font-size:11px;">Total(Emp): <?=$color?></td>
      <td align="right"><?=$info[0]?></td>
      <td align="right"><?=$info[1]?></td>
      <td align="right"><?=$info[2]?></td>
      <td align="right"><?=$info[3]?></td>
      <td align="right"><?=$info[4]?></td>
      <td align="right"><?=($info[0]+$info[1]+$info[2]+$info[3]+$info[4])?></td>
      <td align="right"><?=$info[5]?></td>
      <td align="right"><?=$info[6]?></td>
      <td align="right"><?=(($info[0]+$info[1]+$info[2]+$info[3]+$info[4])-($info[5]+$info[6]))?></td>
      <td align="right">&nbsp;</td>
    </tr><? }?>
  </table>
  </form>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>