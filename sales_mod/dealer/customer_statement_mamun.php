<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Customer Statement Report';
$proj_id=$_SESSION['proj_id'];
$vtype = $_REQUEST['v_type'];
$active='transstle';
do_calander('#fdate');
do_calander('#tdate');

//auto_complete_from_db('accounts_ledger','ledger_id','ledger_id','1','ledger_id');

create_combobox('ledger_id');

//create_combobox('cc_code');

if(isset($_REQUEST['show']))
{
$t_date = $tdate=$_REQUEST['tdate'];
//fdate-------------------
$f_date=$fdate=$_REQUEST["fdate"];

$ledger_id=$_REQUEST["ledger_id"];
	if(substr($ledger_id,8,8)=='00000000')
	$sledger_id = substr($ledger_id,0,8);
	elseif(substr($ledger_id,12,4)=='0000')
	$sledger_id = substr($ledger_id,0,12);
	else $sledger_id = $ledger_id;
$tr_from=$_REQUEST["tr_from"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')
$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"].' ');
if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);



$code_link = '426009';


// --------------- PAYMENT
 $sql="select a.ledger_id, sum(j.dr_amt) balance 
from accounts_ledger a, journal j
where a.ledger_id=j.ledger_id and a.ledger_group_id in ($code_link)
and j.jv_date between '".$f_date."' and '".$t_date."'
and j.tr_from in ('Receipt','Journal')
".$con.$dealer_con." group by a.ledger_id";
 $res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$payment[$row->ledger_id] = $row->balance;
	}


// --------------- OPENING BALANCE
$sql="select a.ledger_id, sum(j.dr_amt- j.cr_amt) balance 
from accounts_ledger a, journal j
where a.ledger_id=j.ledger_id and a.ledger_group_id in ($code_link)
and j.jv_date < '".$f_date."'
".$pg_con.$con.$dealer_con." group by a.ledger_id";

 $res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$opening[$row->ledger_id] = $row->balance;
	}
	
// --------------- Closing BALANCE
$sql="select a.ledger_id, sum(j.dr_amt - j.cr_amt) balance 
from accounts_ledger a, journal j
where a.ledger_id=j.ledger_id and a.ledger_group_id in ($code_link)
and j.jv_date <= '".$t_date."'
".$pg_con.$con.$dealer_con." group by a.ledger_id";

 $res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$closing[$row->ledger_id] = $row->balance;
	}	
	
// --------------- UnVerified GR
$sql="select a.ledger_id, sum(j.dr_amt) balance 
from accounts_ledger a, secondary_journal j
where a.ledger_id=j.ledger_id and a.ledger_group_id in ($code_link)
and j.jv_date > '".$f_date."'
and j.tr_from in('Sales') and j.checked='NO'
".$pg_con.$con.$dealer_con." group by a.ledger_id";

 $res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$ugr[$row->ledger_id] = $row->balance;
	}






}
?>
<?php  $led=db_query("select ledger_id,ledger_name from accounts_ledger where 1 order by ledger_name");
      $data = '[';
      $data .= '{ name: "All", id: "%" },';
	  while($ledg = mysqli_fetch_row($led)){
          $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
	  }
      $data = substr($data, 0, -1);
      $data .= ']';
	//echo $data;
	
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


<style>
.box_report{
	border:3px solid cadetblue;
	background:aliceblue;
}
/*.custom-combobox-input{*/
/*width:217px!important;*/
/*}*/
</style>












	<div class="form-container_large">

		<form  id="form1" name="form1" method="post" action="">
			<div class="d-flex  justify-content-center">

				<div class="n-form1 fo-short pt-2">
					<div class="container">
						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date  :</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<input name="fdate"  type="text" id="fdate" size="12" class="form-control" value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off"/>

							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input name="tdate" type="text" id="tdate" size="12" class="form-control" value="<?php echo $_REQUEST['tdate'];?>" autocomplete="off"/>


							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">General Ledger</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">


								<select name="ledger_id" id="ledger_id" class="form-control"  >
									<option value="%">All</option>

									<?

									foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,"ledger_group_id in (".$code_link.")  and group_for=".$_SESSION['user']['group']."  order by ledger_id");

									?>

								</select>

								<? if($_REQUEST['ledger_id']>0) echo find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST['ledger_id']);?>

							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cost Center :	</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<select name="cc_code" id="cc_code" class="form-control" >
									<option value="<?php echo $_REQUEST['cc_code'];?>"></option>
									<? foreign_relation('cost_center cc, cost_category c','cc.id','cc.center_name',$_POST['cc_code'],"cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC");?>
								</select>

							</div>
						</div>
						
						
						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Voucher Type :	</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<select name="v_type" id="v_type" class="form-control">
								
								<option></option>

							<option value="receipt"<?php if($vtype=='receipt') echo "selected"?>>Receipt Voucher</option>

							<option value="payment"<?php if($vtype=='payment') echo "selected"?>>Payment Voucher</option>

							<option value="contra"<?php if($vtype=='contra') echo "selected"?>>Contra Voucher</option>

							<option value="journal"<?php if($vtype=='journal') echo "selected"?>>Journal Voucher</option>

							

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
			<p class="#"> <? include('PrintFormat_mamun.php');?></p>



			<div id="reporting">
				<div id="grp">

					<table class="table1  table-striped table-bordered table-hover table-sm" cellpadding="0" cellspacing="0" width="100%">

						<thead class="thead1">
						<tr>
						  <th>S/L-9</th>
						  <th>Grp</th>
						  <th>Code</th>
						  <th>Name</th>
						  <th bgcolor="#009999">Opening</th>
						  <th bgcolor="#FF6699">Receipt</th>
						  <th bgcolor="#999900">Closing</th>
						  <th>UnVerified Chalan </th>
						  <th>Final Balance </th>
						  <th>Remarks </th>
						</tr>

						</thead>
						<tbody class="tbody1">
						
						<?
						
						 $sql="select a.group_for,a.ledger_id,a.ledger_name 
						from accounts_ledger a, dealer_info v
						where a.ledger_id=v.account_code and a.ledger_id like '".$_POST['ledger_id']."'
						and a.ledger_group_id in (".$code_link.") 
						".$con.$dealer_con." 
						order by a.group_for,a.ledger_id,a.ledger_name";
						
						$query = db_query($sql);
						while($data= mysqli_fetch_object($query)){
						
						if($opening[$data->ledger_id]<>0 || $closing[$data->ledger_id]<>0 || $payment[$data->ledger_id]<>0 || $ugr[$data->ledger_id]<>0){
?>
					
						<tr><td><?=++$op;?></td>
							  <td><?=$data->group_for?></td>
							  <td><?=$data->ledger_id?></td>
							  <td><?=$data->ledger_name?></td>
							  <td><?=number_format($opening[$data->ledger_id],0)?></td>
							  <td><?=number_format($payment[$data->ledger_id],0)?></td>
							  <td><?=number_format($closing[$data->ledger_id],0)?></td>
							  <td><?=number_format($ugr[$data->ledger_id],0)?></td>
							  <td><? $f_amount = $closing[$data->ledger_id] + $ugr[$data->ledger_id]; echo number_format($f_amount,0);?></td>
							  <td>&nbsp;</td>
							</tr>
							<?
							} // ignore 0
							$opening_total = $opening_total + $opening[$data->ledger_id];
							$closing_total = $closing_total + $closing[$data->ledger_id];
							$payment_total = $payment_total + $payment[$data->ledger_id];
							$gugr += $ugr[$data->ledger_id];
							$gf_amount += $f_amount;
							} // end while
							?>
						<tr>
						  <td colspan="4" class="style5"><span class="style5">Total: </span></td>
						  <td class="style5"><strong><?=number_format($opening_total,0)?></strong></td>
						  <td class="style5"><strong><?=number_format($payment_total,0)?></strong></td>
						  <td class="style5"><strong><?=number_format($closing_total,0)?></strong></td>
						  <td class="style5"><strong><?=number_format($gugr,0);?></strong></td>
						  <td class="style5"><strong><?=number_format(($closing_total+$gugr),0);?></strong></td>
						  <td></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>









<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>