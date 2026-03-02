<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Monthly Sales Report';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br><h3>Period: '.$_REQUEST["fdate"].' to '.$_REQUEST['tdate'].'</h3>';
if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
$report_detail.='<br>CC Code : '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);


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

	
  });
</script>
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
</script>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }

-->

</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="1" cellpadding="0">
                                      
                                       <tr>
                                         <td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="50%" align="right">Period : </td>
							<td width="50%" align="left">
								<input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" required="required" />
								---
								<input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"  required="required" />						  </td>
						</tr>
						<tr>
						  <td align="right">Depot : </td>
						  <td align="left"><select name="dealer_depot" id="dealer_depot" >
                           
							<? foreign_relation('warehouse','warehouse_id','warehouse_name',$dealer_depot,'use_type!="PL"');?>
                            
                          </select></td>
					  </tr>
						<tr>
						  <td align="right">Dealer Type : </td>
						  <td align="left"><select name="dealer_type" id="dealer_type" >
                                            <option value="">Select Dealer Type</option>
                                            <option value="Distributor"<?=($_POST['dealer_type']=="Distributor")?'selected':'';?>>Distributor</option>
                                            <option value="SuperShop"<?=($_POST['dealer_type']=="SuperShop")?'selected':'';?>>SuperShop</option>
                                            <option value="Corporate"<?=($_POST['dealer_type']=="Corporate")?'selected':'';?>>Corporate</option>
                                            <option value="Retailer"<?=($_POST['dealer_type']=="Retailer")?'selected':'';?>>Retailer</option>
                                        </select></td>
					  </tr>
					</table>
										 </td>
                                       </tr>
                                       
                                       
                                       
                                       
                                       
                                      
                                      <tr>
                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td> <div id="reporting">
									
							  
  <?php
if(isset($_REQUEST['show']))
{?>


<table id="grp"  class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							 <thead> <tr>
							    <th width="29" align="center">S/N</th>
    <th width="357" height="20" align="center">Head Of Accounts </th>
    <th width="150" height="20" align="center">Opening Balance </th>
    <th width="150" align="center">Sales</th>
    <th width="150" align="center">Sales Return </th>
    <th width="75" align="center">Payment</th>
    <th width="75" align="center">Journal</th>
    <th width="150" align="center">Closing</th>
    </tr></thead>
	
	<?php 
	if($_POST['dealer_type']!='' || $_POST['dealer_depot']!=''){
	$d_table = ",dealer_info d";
	$depot_table = ",warehouse w";
	$d_type = " and d.account_code=a.ledger_id and d.dealer_type='".$_POST['dealer_type']."' ";
	$d_depot = "and w.ledger_id=a.ledger_id and w.warehouse_id='".$_POST['dealer_depot']."' ";
	}
	echo $p="select DISTINCT a.ledger_name, a.ledger_id from accounts_ledger a ".$d_table." ".$depot_table." where a.ledger_group_id=1051  ".$d_type." ".$d_depot." and a.group_for=".$_SESSION['user']['group']." order by a.ledger_id";
	//echo $p;
	$sql=db_query($p);



$pi=0;
$sql=db_query($p);
	while($d=mysqli_fetch_object($sql)){
	$open = find_all_field_sql("select SUM(dr_amt - cr_amt) as open from journal where jv_date < '$fdate' and ledger_id=".$d->ledger_id);
	$sales = find_all_field_sql("select SUM(dr_amt) as sales from journal where jv_date between '$fdate' and '$tdate' and tr_from='Sales' and ledger_id=".$d->ledger_id);
	$sales_return = find_all_field_sql("select SUM(cr_amt) as sales_return from journal where jv_date between '$fdate' and '$tdate' and tr_from='SalesReturn' and ledger_id=".$d->ledger_id);
	
	$receipt = find_all_field_sql("select SUM(cr_amt) as receipt from journal where jv_date between '$fdate' and '$tdate' and tr_from='Receipt' and ledger_id=".$d->ledger_id);
	
	$j_receipt = find_all_field_sql("select SUM(cr_amt) as journal_recv from journal_info where journal_info_date between '$fdate' and '$tdate' and  ledger_id=".$d->ledger_id);
	
	$j_open = find_all_field_sql("select SUM(cr_amt) as j_open from journal_info where journal_info_date < '$fdate' and ledger_id=".$d->ledger_id);
	
	
	$closing=$open->open + $sales->sales - $sales_return->sales_return - $receipt->receipt - $j_receipt->journal_recv;
	$tot_open+=($open->open-$j_open->j_open);
	$tot_sales+=$sales->sales;
	$tot_return+=$sales_return->sales_return;
	$tot_receipt+=$receipt->receipt;
	$tot_closing+=$closing;
	$tot_j_receipt+=$j_receipt->journal_recv;
	$pi++;
	?>
							  <tbody><tr>
							    <th align="center"><?= $pi?></th>
							    <th height="20" align="center"><?= $d->ledger_name?></th>
							    <th width="150" height="20" align="center"><?=$open->open-$j_open->j_open?></th>
							    <th width="150" align="center"><?=$sales->sales?></th>
							    <th width="150" align="center"><?=$sales_return->sales_return?></th>
							    <th width="75" align="center"><?=$receipt->receipt?></th>
							    <th width="75" align="center"><?=$j_receipt->journal_recv?></th>
							    <th width="150" align="center"><?=$closing?></th>
							    </tr>
							  
								<?php }?>
								
								<tr>
							    <th height="20" colspan="2" align="center"><div align="right">Total</div></th>
							    <th height="20" align="center"><?=$tot_open?></th>
							    <th align="center"><?=$tot_sales?></th>
							    <th align="center"><?=$tot_return?></th>
							    <th align="center"><?=$tot_receipt?></th>
							    <th align="center"><?=$tot_j_receipt?></th>
							    <th align="center"><?=$tot_closing?></th>
		      </tr></tbody>
</table> 
<?php }?>									</div>
																		</td>
								  </tr>
		</table>

<?php 
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>