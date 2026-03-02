<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Statement of Financial Position';




				   



$tdate=$_REQUEST['tdate'];

//fdate-------------------

$fdate=$_REQUEST["fdate"];



$j=0;

for($i=0;$i<strlen($fdate);$i++)

{

if(is_numeric($fdate[$i]))

$time1[$j]=$time1[$j].$fdate[$i];



else $j++;

}



$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);



//tdate-------------------





$j=0;

for($i=0;$i<strlen($tdate);$i++)

{

if(is_numeric($tdate[$i]))

$time[$j]=$time[$j].$tdate[$i];

else $j++;

}

$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);



if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')

$report_detail.='<br>Reporting Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'].'';

?>



<script type="text/javascript">

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

function DoNav(a,b,c)



{



	document.location.href = 'transaction_list.php?fdate='+a+'&tdate='+b+'&ledger_id='+c+'&show=Show';



}

</script>



<style type="text/css">

<!--

.style1 {font-weight: bold}
.style2 {color: #00FFFF}
.style5 {
	color: #000000;
	font-weight: bold;
}

-->
.box_report{
	border:3px solid cadetblue;
	background:aliceblue;
}
.custom-combobox-input{
width:217px!important;
}

</style>










	<!--Statement of Financial Position-->
	<div class="form-container_large">

		<form  id="form1" name="form1" method="post" action="">
			<div class="d-flex  justify-content-center">

				<div class="n-form1 fo-short pt-2">
					<div class="container">
						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">As On:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<input name="tdate" type="text" id="tdate" size="12" class="form-control" autocomplete="off" value="<?php echo $_REQUEST['tdate'];?>"/>

							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cost Center:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<select name="cc_code" id="cc_code" class="form-control">
									<option></option>
									<?

									$sqled1 = "select cc.id, cc.center_name FROM cost_center cc, cost_category c WHERE cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC";
									$ccd=db_query($sqled1);
									if(mysqli_num_rows($ccd)>0){
										while($cc=mysqli_fetch_object($ccd))
										{?>
											<option  value="<?=$cc->id?>" <?=($cc->id==$_POST['cc_code'])? 'selected':'' ?>>
												<?=$cc->id.' - '.$cc->center_name?>
											</option>
											';

										<? }}
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



		<p>

				<? include('PrintFormat.php');?>
		</p>


			<div class="container-fluid pt-5 p-0 ">

			<? if(isset($_POST['show'])){

			$tdate=$_REQUEST['tdate'];
			$cost_center=$_REQUEST['cc_code'];
			if($cost_center>0){

				$cost_con='and j.cc_code="'.$cost_center.'" ';
				$cost_con2='and cc_code="'.$cost_center.'" ';
			}
			?>

			<div id="reporting">
				<div id="grp">


					<table class="table1  table-striped table-bordered table-hover table-sm">
						<thead class="thead1">

						<tr class="bgc-info">
							<th rowspan="2" colspan="3">Particular</th>
							<th rowspan="2" >Note</th>
							<th colspan="2" ><?php echo $tdate;?> </th>
						</tr>

						<tr class="bgc-info">
							<th colspan="2">Amount</th>
						</tr>

						</thead>

						<tbody class="tbody1">
						<tr>
							<td style="font-weight:bold;">Assets & Properties</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php
						$sql3="select * from ledger_group where group_class=1000 ";
						$query3=db_query($sql3);
						while($data3=mysqli_fetch_object($query3)){
							$bal1=find_a_field('journal j,accounts_ledger a,ledger_group g','sum(j.dr_amt-j.cr_amt)',' g.group_class=1000 and a.ledger_group_id=g.group_id and a.ledger_id=j.ledger_id and j.jv_date<="'.$tdate.'" and g.group_id="'.$data3->group_id.'" '.$cost_con.' ');
							?>

							<tr>
								<td></td>
								<td style="font-weight:bold;"><?=$data3->group_name?></td>
								<td></td>
								<td></td>
								<td></td>
								<td><?=$bal1?></td>
							</tr>
							<?php
							$sql1="select a.* from accounts_ledger a,ledger_group g where g.group_class=1000 and a.ledger_group_id=g.group_id and g.group_id='".$data3->group_id."'";
							$query1=db_query($sql1);
							while($data1=mysqli_fetch_object($query1)){
								$ledger_bal1=find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<="'.$tdate.'" and ledger_id="'.$data1->ledger_id.'" '.$cost_con2.'');
								?>

								<tr>
									<td></td>
									<td></td>
									<td ><?php echo $data1->ledger_name; ?></td>
									<td></td>
									<td><a href="balance_sheet_details.php?ledger_id=<?=$data1->ledger_id?>&&to_date=<?=$tdate?>" target="_blank"><?php
											if($ledger_bal1 < 0){
												echo "(".$ledger_bal1*(-1).")";
											}
											else{
												echo $ledger_bal1;
											}
											?></a></td>
									<td></td>
								</tr>

								<?

								$tot_asset+=$bal1;
							}}


						?>

						<tr>
							<td colspan="5" style="text-align:right;font-weight:bold;">Total Assets</td>
							<td style="font-weight:bold;"><?=$tot_asset?></td>
						</tr>




						<tr>
							<td style="font-weight:bold;">Equity and Liabilities</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php
						$sql4="select * from ledger_group where group_class=2000 ";
						$query4=db_query($sql4);
						while($data4=mysqli_fetch_object($query4)){
							$bal2=find_a_field('journal j,accounts_ledger a,ledger_group g','sum(j.cr_amt-j.dr_amt)',' g.group_class=2000 and a.ledger_group_id=g.group_id and a.ledger_id=j.ledger_id and j.jv_date<="'.$tdate.'" and g.group_id="'.$data4->group_id.'"');
							?>

							<tr>
								<td></td>
								<td style="font-weight:bold;"><?=$data4->group_name?></td>
								<td></td>
								<td></td>
								<td></td>
								<td><?=$bal2?></td>
							</tr>
							<?php
							$sql2="select a.* from accounts_ledger a,ledger_group g where g.group_class=2000 and a.ledger_group_id=g.group_id and g.group_id='".$data4->group_id."'";
							$query2=db_query($sql2);
							while($data2=mysqli_fetch_object($query2)){
								$ledger_bal2=find_a_field('journal','sum(cr_amt-dr_amt)','jv_date<="'.$tdate.'" and ledger_id="'.$data2->ledger_id.'"');
								?>

								<tr>
									<td></td>
									<td></td>
									<td ><?php echo $data2->ledger_name; ?></td>
									<td></td>
									<td><?php
										if($ledger_bal2 < 0){
											echo "(".$ledger_bal2*(-1).")";
										}
										else{
											echo $ledger_bal2;
										}
										?></td>
									<td></td>
								</tr>

								<?

								$tot_libt+=$bal2;
							}}


						?>

						<tr>
							<td colspan="5" style="text-align:right;font-weight:bold;">Total Libilities</td>
							<td style="font-weight:bold;"><?=$tot_libt?></td>
						</tr>

						</tbody>
					</table>




				</div>
			</div>

			<? }?>

		</div>







	</div>







<?/*>
	<br>
<br>
<br>
<br>


<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report">
											<form id="form1" name="form1" method="post" action="">

									<table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="22%" height="60" align="right">

		    As On:      </td>

                                        <td width="26%" align="left"><div>
                                          <input name="tdate" type="text" id="tdate" size="12" class="form-control" autocomplete="off" value="<?php echo $_REQUEST['tdate'];?>"/>

											</div></td>
												
												
                                            <td width="5%" align="left"></td>
                                            <td width="47%" align="left"> <div align="left">
                                             
                                        </div></td>
                                      </tr>
									  
									  <tr>

                                        <td width="22%" height="60" align="right">

		   Cost Center:      </td>

                                        <td width="26%" align="left"><div align="right">
                              <select name="cc_code" id="cc_code" class="form-control">
                                             <option></option>
                                             <?  

 $sqled1 = "select cc.id, cc.center_name FROM cost_center cc, cost_category c WHERE cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC";
$ccd=db_query($sqled1);
if(mysqli_num_rows($ccd)>0){
while($cc=mysqli_fetch_object($ccd))
{?>
                                             <option  value="<?=$cc->id?>" <?=($cc->id==$_POST['cc_code'])? 'selected':'' ?>>
                                             <?=$cc->id.' - '.$cc->center_name?>
                                             </option>
                                             ';

                                             <? }}
		  ?>
                                           </select>
                                        </div></td>
												
												
                                            <td width="5%" align="left"></td>
                                            <td width="47%" align="left"> <div align="left">
                                             
                                        </div></td>
                                      </tr>
									  

                                      

                                      

                                      <tr>

                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center"><input class="btn1 btn1-bg-submit" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td>

									<? if(isset($_POST['show'])){
									
									$tdate=$_REQUEST['tdate'];
									$cost_center=$_REQUEST['cc_code'];
									if($cost_center>0){
									
									$cost_con='and j.cc_code="'.$cost_center.'" ';
										$cost_con2='and cc_code="'.$cost_center.'" ';
									}
									?>

									<div id="reporting" style="overflow:hidden"><div id="grp">




<table  width="100%" cellspacing="0" cellpadding="2" border="0" class="table table-bordered">
	<thead>
		<tr>
			<th rowspan="2" colspan="3" style="font-weight:bold;">Particular</th>
			<th rowspan="2" style="font-weight:bold;">Note</th>
			<th colspan="2" style="font-weight:bold;"><?php echo $tdate;?> </th>
		</tr>
		<tr>
		  <th colspan="2" style="font-weight:bold;">Amount</th>
		  </tr>
	</thead>
	
	<tbody>
		<tr>
			<td style="font-weight:bold;">Assets & Properties</td>
				<td></td>
				<td></td>
			<td></td>
			<td></td>
		    <td></td>
		</tr>
			<?php 
							 $sql3="select * from ledger_group where group_class=1000 ";
							$query3=db_query($sql3);
							while($data3=mysqli_fetch_object($query3)){
						 $bal1=find_a_field('journal j,accounts_ledger a,ledger_group g','sum(j.dr_amt-j.cr_amt)',' g.group_class=1000 and a.ledger_group_id=g.group_id and a.ledger_id=j.ledger_id and j.jv_date<="'.$tdate.'" and g.group_id="'.$data3->group_id.'" '.$cost_con.' ');
							?>
							
		<tr>
			<td></td>
			<td style="font-weight:bold;"><?=$data3->group_name?></td>
			<td></td>
			<td></td>
			<td></td>
		    <td><?=$bal1?></td>
		</tr>
		<?php 
							 $sql1="select a.* from accounts_ledger a,ledger_group g where g.group_class=1000 and a.ledger_group_id=g.group_id and g.group_id='".$data3->group_id."'";
							$query1=db_query($sql1);
							while($data1=mysqli_fetch_object($query1)){
							$ledger_bal1=find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<="'.$tdate.'" and ledger_id="'.$data1->ledger_id.'" '.$cost_con2.'');
							?>
		
		<tr>
			<td></td>
			<td></td>
			<td ><?php echo $data1->ledger_name; ?></td>
			<td></td>
			<td><a href="balance_sheet_details.php?ledger_id=<?=$data1->ledger_id?>&&to_date=<?=$tdate?>" target="_blank"><?php 
							 if($ledger_bal1 < 0){
							  echo "(".$ledger_bal1*(-1).")";
							}
							else{
							echo $ledger_bal1;
							}
							 ?></a></td>
		    <td></td>
		</tr>
		
		<? 
		
		$tot_asset+=$bal1;
		}}
		
		
		 ?>
		 
		 <tr>
		 	<td colspan="5" style="text-align:right;font-weight:bold;">Total Assets</td>
			<td style="font-weight:bold;"><?=$tot_asset?></td>
		 </tr>
		 
		 
		 
		 
		 		<tr>
			<td style="font-weight:bold;">Equity and Liabilities</td>
				<td></td>
				<td></td>
			<td></td>
			<td></td>
		    <td></td>
		</tr>
			<?php 
							 $sql4="select * from ledger_group where group_class=2000 ";
							$query4=db_query($sql4);
							while($data4=mysqli_fetch_object($query4)){
						$bal2=find_a_field('journal j,accounts_ledger a,ledger_group g','sum(j.cr_amt-j.dr_amt)',' g.group_class=2000 and a.ledger_group_id=g.group_id and a.ledger_id=j.ledger_id and j.jv_date<="'.$tdate.'" and g.group_id="'.$data4->group_id.'"');
							?>
							
		<tr>
			<td></td>
			<td style="font-weight:bold;"><?=$data4->group_name?></td>
			<td></td>
			<td></td>
			<td></td>
		    <td><?=$bal2?></td>
		</tr>
		<?php 
							 $sql2="select a.* from accounts_ledger a,ledger_group g where g.group_class=2000 and a.ledger_group_id=g.group_id and g.group_id='".$data4->group_id."'";
							$query2=db_query($sql2);
							while($data2=mysqli_fetch_object($query2)){
							$ledger_bal2=find_a_field('journal','sum(cr_amt-dr_amt)','jv_date<="'.$tdate.'" and ledger_id="'.$data2->ledger_id.'"');
							?>
		
		<tr>
			<td></td>
			<td></td>
			<td ><?php echo $data2->ledger_name; ?></td>
			<td></td>
			<td><?php 
							 if($ledger_bal2 < 0){
							  echo "(".$ledger_bal2*(-1).")";
							}
							else{
							echo $ledger_bal2;
							}
							 ?></td>
		    <td></td>
		</tr>
		
		<? 
		
		$tot_libt+=$bal2;
		}}
		
		
		 ?>
		 
		 <tr>
		 	<td colspan="5" style="text-align:right;font-weight:bold;">Total Libilities</td>
			<td style="font-weight:bold;"><?=$tot_libt?></td>
		 </tr>
		 
	</tbody>
</table>






</div>

</div>

<? }?>

		</td>

		</tr>

		</table>

		</div></td>    

  </tr>

</table>




	<*/?>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>