<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Transaction Statement Report';
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
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];

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
								<input name="fdate"  type="text" id="fdate" size="12" class="form-control" value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off" required/>

							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input name="tdate" type="text" id="tdate" size="12" class="form-control" value="<?php echo $_REQUEST['tdate'];?>" autocomplete="off" required/>


							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">General Ledger</label>				<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">


								<select name="ledger_id" id="ledger_id" class="form-control"  >


									<option value="%"></option>

									<?

			foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");

									?>

								</select>

								<? if($_REQUEST['ledger_id']>0) echo find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST['ledger_id']);?>

							</div>
							
						</div>
						
						
						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sub Ledger</label>				
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

		<input list="sub_ledger" name="sub_ledger_id" id="sub_ledger_id" class="form-control" style="float:left" value="<?=$_REQUEST['sub_ledger_id']?>">
								<datalist id="sub_ledger">
									<? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$ledger_id," 1  order by ledger_id"); ?>
								</datalist>
				<? if($_REQUEST['sub_ledger_id']>0) echo find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$_REQUEST['sub_ledger_id'].'"')?>
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
			<p class="#"> <? include('PrintFormat.php');?></p>



			<div id="reporting">
				<div id="grp">

					<table class="table1  table-striped table-bordered table-hover table-sm" style="zoom:90%">

						<thead class="thead1">
						<tr class="bgc-info">
							<th>SL</th>
						
				
							<th>Acc Name</th>
							<th>Sub Ledger</th>
						
						
					        <th>Opening</th>
							<th>Debit</th>
							<th>Credit</th>
							<th>Balance</th>
						</tr>

						</thead>
						<tbody class="tbody1">


						<?php
						if(isset($_REQUEST['show']))
						{	
							$selected_date = new DateTime($fdate);

    // Determine the fiscal year dynamically
    $year = (int) $selected_date->format('Y'); // Get the year of the selected date
    $month = (int) $selected_date->format('m'); // Get the month of the selected date

    // If the month is before July (i.e., January to June), the fiscal year started the previous year
    if ($month < 7) {
        $fy_start_year = $year - 1;
        $fy_end_year = $year;
    } else {
        // If the month is July or later (i.e., July to December), the fiscal year started the current year
        $fy_start_year = $year;
        $fy_end_year = $year + 1;
    }

    // Define the start and end of the fiscal year
     $fy_start_date = $fy_start_year . "-07-01"; // Fiscal year starts on July 1st
      $fy_end_date = $fy_end_year . "-06-30";
						
							$cc_code = (int) $_REQUEST['cc_code'];
							$dealer_type = $_REQUEST['dealer_type'];
							
							if($_REQUEST['sub_ledger_id']>0){
	 							$sub_ledger_con = ' and a.sub_ledger="'.$_REQUEST['sub_ledger_id'].'"';
							}
							
							if($dealer_type!='')
							{
								$d_table = ',dealer_info d';
								$d_where = ' and d.account_code=b.ledger_id and d.dealer_type="'.$dealer_type.'" ';
							}
							if($cc_code > 0)
								$cc_con = " AND a.cc_code=$cc_code";
								
								if($_POST['v_type']!=''){
								$v_type = " AND a.tr_from='".$_POST['v_type']."'";
								}

							 $total_sql = "select sum(a.dr_amt),sum(a.cr_amt), a.sub_ledger 
							 
							 from journal a,accounts_ledger b,dealer_info d 
							 
							 where a.ledger_id=b.ledger_id and a.group_for='".$_SESSION['user']['group']."' and a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '$sledger_id%' and d.sub_ledger_id = a.sub_ledger ".$cc_con.$d_where.$v_type.$sub_ledger_con." group by a.sub_ledger ";

							if($tr_from!='')
								$total_sql.=" and a.tr_from='".$tr_from."'";

							if($_POST['user_name']!='')
								$total_sql.=" and a.user_id='".$_POST['user_name']."'";

							$total=mysqli_fetch_row(db_query($total_sql));

							 $c="SELECT 
    SUM(CASE 
        WHEN c.acc_class IN (1, 2, 3) AND a.jv_date < '$fdate' 
            THEN a.dr_amt - a.cr_amt 
        WHEN c.acc_class IN (4, 5) AND a.jv_date >= '$fy_start_date' AND a.jv_date < '$fdate'
            THEN a.dr_amt - a.cr_amt 
        ELSE 0 
    END) AS total_sum

FROM 
    journal a
    JOIN accounts_ledger b ON a.ledger_id = b.ledger_id
    JOIN ledger_group c ON b.ledger_group_id = c.group_id

WHERE a.ledger_id like '$sledger_id%' 
    ".$cc_con.$d_where.$sub_ledger_con;
	
	//sub ledger wise opening -> open
	
         $sub_opening="select s.sub_ledger_id,b.ledger_id,sum(a.dr_amt-a.cr_amt) as opening_amt,a.group_for
		 from journal a left join general_sub_ledger s on s.sub_ledger_id=a.sub_ledger left join user_group g on g.id=a.group_for,accounts_ledger b".$d_table." 
		 where a.ledger_id=b.ledger_id and a.jv_date < '$fdate'
		 ".$cc_con.$sub_ledger_con." 
		 and a.ledger_id='$sledger_id' ".$d_where." group by s.sub_ledger_id" ;
		 $sql_sub_opening=db_query($sub_opening);
		while($data_sub_opening = mysqli_fetch_assoc($sql_sub_opening)) {
    $sub_ledger_opening[$data_sub_opening['sub_ledger_id']] = $data_sub_opening['opening_amt'];
                   }

	//sub ledger wise opening -> close
	
 $p="select a.jv_date,b.ledger_name,sum(a.dr_amt) as dr_amt,sum(a.cr_amt) as cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_no,a.jv_no,a.cheq_no,a.cheq_date,a.relavent_cash_head , a.cc_code,a.group_for, s.sub_ledger_name,g.group_name,s.sub_ledger_id,b.ledger_id
		 from journal a left join general_sub_ledger s on s.sub_ledger_id=a.sub_ledger left join user_group g on g.id=a.group_for,accounts_ledger b".$d_table." 
		 where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' 
		 ".$cc_con.$sub_ledger_con." 
		 and a.ledger_id='$sledger_id' ".$d_where." group by s.sub_ledger_id" ;

							if($tr_from!='')
								$p.=" and a.tr_from='".$tr_from."'";

							if($_POST['user_name']!='')
								$p.=" and a.user_id='".$_POST['user_name']."'";

							 $p.=" order by a.jv_date,a.id";



							if($total[0]>$total[1])
							{
								$t_type="(Dr)";
								$t_total=$total[0]-$total[1];
							}
							else
							{
								$t_type="(Cr)";
								$t_total=$total[1]-$total[0];
							}
							/* ===== Opening Balance =======*/

							$psql=db_query($c);
							$pl = mysqli_fetch_row($psql);
							$blance=$pl[0];
							?>

							<?php /*?><tr>
								<td class="bg-table1">#</td>
							
								<td class="bg-table1"><?php echo date('d-m-Y',strtotime($_REQUEST["fdate"]));?></td>
								<td class="bg-table1">&nbsp;</td>
								<td class="bg-table1">Opening Balance </td>
								
							
								<td class="bg-table1">&nbsp;</td>
								<td class="bg-table1">&nbsp;</td>
				
								<td class="bg-table1"><?php if($blance>0) echo '(Dr)'.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
							</tr><?php */?>
							<?php
							$sql=db_query($p);
							while($data=mysqli_fetch_row($sql))
							{
								$pi++;
								?>
								<tr <?=($xx%2==0)?' bgcolor="#EDEDF4"':'';$xx++;?>>
									<td align="center"><?php echo $pi;?></td>
									
									<td align="left" ><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$data[17]?>" target="_blank"><?=$data[1];?></a></td>
									<td align="left" ><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&sub_ledger_id=<?=$data[16]?>&ledger_id=<?=$data[17]?>" target="_blank"><?=$data[14];?></a></td>
							
				<td align="center"><?php  echo $opening_sub_ledger=$sub_ledger_opening[$data[16]]; $tt_opening_sub_ledger+=$opening_sub_ledger;?></td>
									<td ><?php echo $dr_amt= number_format($data[2],2);$tt_dr_amt+= $data[2];?></td>
									<td ><?php echo $cr_ant= number_format($data[3],2);$tt_cr_amt+= $data[3];?></td>
									<td class="bg-table1"><?php $blance = ($opening_sub_ledger+$data[2])-$data[3]; if($blance>0) echo '(Dr) '.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
								</tr>
							<?php } ?>
							<tr >
							<th class="bg-table1"></th>
								<th class="bg-table1">Closing Balance : <?php  number_format($blance,2)." ".$t_type?> </th>
								<th class="bg-table1" ><strong>Total: </strong></th>
								<th  class="bg-table1"><strong><?php echo number_format($tt_opening_sub_ledger,2);?></strong></th>
								<th  class="bg-table1"><strong><?php echo number_format($tt_dr_amt,2);?></strong></th>
								<th class="bg-table1"><strong><?php echo number_format($tt_cr_amt,2);?></strong></th>
								<th class="bg-table1"><strong><?php echo number_format(((($tt_opening_sub_ledger+$tt_dr_amt)-$tt_cr_amt)),2);?></strong></th>
								<?php /*?><th  class="bg-table1"><?php $blance = $blance+($data[2]-$data[3]); if($blance>0) echo '(Dr) '.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></th><?php */?>
							</tr>

						<?php }?>




						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>









<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>