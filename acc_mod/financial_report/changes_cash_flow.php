<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Financial Statement';


do_calander('#fdate');


do_calander('#tdate');


create_combobox('ledger_id');


create_combobox('cc_code');


$active='cashbo';


$proj_id=$_SESSION['proj_id'];


jv_double_check();


if($_SESSION['user']['group']>1)


$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' and group_for=".$_SESSION['user']['group']);


else


$cash_and_bank_balance=find_a_field('ledger_group','group_id','group_sub_class=1020');


if(isset($_REQUEST['show']))


{


$tdate=$_REQUEST['tdate'];


//fdate-------------------


$fdate=$_REQUEST["fdate"];


$ledger_id=$_REQUEST["ledger_id"];


if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')


$report_detail.='<br>Report date : '.$_REQUEST['tdate'];


if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')


$report_detail.='<br>CC Code : '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);


$j=0;


for($i=0;$i<strlen($fdate);$i++)


{


if(is_numeric($fdate[$i]))


$time1[$j]=$time1[$j].$fdate[$i];


else $j++;


}


//$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);


//tdate-------------------


$j=0;


for($i=0;$i<strlen($tdate);$i++)


{


if(is_numeric($tdate[$i]))


$time[$j]=$time[$j].$tdate[$i];


else $j++;


}


//$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);


}


?>


<?php  


$led1=db_query("SELECT id, center_name FROM cost_center WHERE 1 ORDER BY center_name");


if(mysqli_num_rows($led1) > 0)


{	


$data1 = '[';


while($ledg1 = mysqli_fetch_row($led1)){


$data1 .= '{ name: "'.$ledg1[1].'", id: "'.$ledg1[0].'" },';


}


$data1 = substr($data1, 0, -1);


$data1 .= ']';


}


else


{


$data1 = '[{ name: "empty", id: "" }]';


}


?>


<script type="text/javascript">


$(document).ready(function(){


function formatItem(row) {


//return row[0] + " " + row[1] + " ";


}


function formatResult(row) {


return row[0].replace(/(<.+?>)/gi, '');


}


var data = <?php echo $data; ?>;


$("#ledger_id").autocomplete(data, {


matchContains: true,


minChars: 0,


scroll: true,


scrollHeight: 300,


formatItem: function(row, i, max, term) {


return row.name + " [" + row.id + "]";


},


formatResult: function(row) {


return row.id;


}


});


var data = <?php echo $data1; ?>;


$("#cc_code").autocomplete(data, {


matchContains: true,


minChars: 0,        


scroll: true,


scrollHeight: 300,


formatItem: function(row, i, max, term) {


return row.name + " : [" + row.id + "]";


},


formatResult: function(row) {            


return row.id;


}


});	


});


</script>


<!--<script type="text/javascript">


$(document).ready(function(){


$(function() {


$("#fdate").datepicker({


changeMonth: true,


changeYear: true,


dateFormat: 'dd-mm-y'


});


});


$(function() {


$("#tdate").datepicker({


changeMonth: true,


changeYear: true,


dateFormat: 'dd-mm-y'


});


});


});


</script>-->


<style>


.box_report{


border:3px solid cadetblue;


background:aliceblue;


}


.custom-combobox-input{


width:217px!important;


}


</style>



	<div class="form-container_large">

		<form  id="form1" name="form1" method="post" action="">
			<div class="d-flex  justify-content-center">

				<div class="n-form1 fo-short pt-2">
					<div class="container">
						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date :</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<input autocomplete="off"  name="fdate" type="text" id="fdate"  class="form-control" value="<?php echo $_REQUEST['fdate'];?>" />
							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date :</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<input autocomplete="off"  name="tdate" type="text" id="tdate" class="form-control" value="<?php echo $_REQUEST['tdate'];?>"/>
							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cash Head :</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">


								<select name="ledger_id" id="ledger_id" class="form-control">
									<option value="0"></option>

									<?
									foreign_relation('accounts_ledger','ledger_id','ledger_name',$c_id,"ledger_group_id=126001 order by ledger_id");

									?>
								</select>
								
								 

							</div>
						</div>


					</div>

					<div class="n-form-btn-class">
						<input class="btn1 btn1-bg-submit" name="show" type="submit" id="show" value="Show" />

					</div>

				</div>

			</div>

		</form>
		
		<div class="container-fluid">
							<p class="#"> <? include('PrintFormat.php');?> </p>
							<div id="reporting">

<style>
	tr,td{
    border: none !important;
	}
</style>

<table id="grp" width="100%" border="0"  cellspacing="0" cellpadding="0">
		<tr>
			<th style="border:1px solid black; text-align:center">Particulars</th>
			
			<th style="border:1px solid black; text-align:center">30th June- 2022 <br/>Amount in Tk </th>
		
		</tr>
		<tr>
		
			<td colspan="2" style="font-weight:bold">Cash Flows from operating activities</td>
		</tr>
		
		<tr>
			<td >Net Income after Tax</td>
			<td align="center"> 106,738,547.08 </td>
		</tr>
		
		<tr>
			<td >Depreciation</td>
			<td align="center">225,654,5889</td>
		</tr>
		
				<tr>
			<td >Preliminery Expenses Written off</td>
			<td align="center">225,654,5889</td>
		</tr>
				<tr>
			<td >Decrease/(Increase) in Current Assets Other than Cash & Bank Balances</td>
			<td align="center">225,654,5889</td>
		</tr>		<tr>
			<td >(Decrease)/Increase in Current Liabilities</td>
			<td align="center">225,654,5889</td>
		</tr>		<tr>
			<td align="right" style="font-weight:bold">Net Cash Flows from Operating Activities:</td>
			<td align="center" style="font-weight:bold;">225,654,5889</td>
		</tr>		
		
		<tr>
			<td colspan="2" style="font-weight:bold">Cash Flows from Investing Activities:</td>
			
		</tr>		
		
		<tr>
			<td >Acquisition of Fixed Assets</td>
			<td align="center">225,654,5889</td>
		</tr>		<tr>
			<td >Preliminery Expenses</td>
			<td align="center">-</td>
		</tr>		
				
		
		<tr>
			<td align="right" style="font-weight:bold">Net Cash Flows from Investing Activities:</td>
			<td align="center" style="font-weight:bold;">225,654,5889</td>
		</tr>	
		
		<tr>
			<td colspan="2" style="font-weight:bold">Cash Flows from Fnancing Activities:</td>
			
		</tr>	
		
		<tr>
			<td >Share Capital</td>
			<td align="center">225,654,5889</td>
		</tr>
		
		<tr>
			<td >Share Money Deposit</td>
			<td align="center">225,654,5889</td>
		</tr>
		
		<tr>
			<td >Long Term Loan</td>
			<td align="center">225,654,5889</td>
		</tr>
		
		<tr>
			<td >Short Term Loan</td>
			<td align="center">225,654,5889</td>
		</tr>
		
				
		<tr>
			<td >Dividend Paid</td>
			<td align="center">225,654,5889</td>
		</tr>
		
		<tr>
			<td >Income Tax Paid</td>
			<td align="center">225,654,5889</td>
		</tr>
		

</table>

</div>
		</div>
</div>








<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>