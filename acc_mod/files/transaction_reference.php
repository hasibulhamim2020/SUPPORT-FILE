<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Transaction Statement Report';
$proj_id=$_SESSION['proj_id'];
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
.custom-combobox-input{
width:217px!important;
}
</style>






<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report" ><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="2">
                                      <tr>
                                        <td  align="right">
		                                        Period :   </td>
                                        <td  align="left"><input name="fdate"  type="text" id="fdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['fdate'];?>" /> 								        </td>
										
                                            <td align="left"><input name="tdate" type="text" id="tdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Ledger Head :</td>
                                        <td width="28%" align="left"><!--<input type="text" class="form-control" style="max-width:250px;" name="ledger_id" id="ledger_id" value="<?php echo $_REQUEST['ledger_id'];?>" size="50" />-->
										
										<select name="ledger_id" id="ledger_id" class="form-control" style="float:left"  >

<!--<option value="%">All</option>-->

<?

foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,"ledger_id='".$ledger_id."'  order by ledger_id");

?>

</select>
										
										</td>
                                        <td width="50%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($_REQUEST['ledger_id']>0) echo find_a_field('accounts_ledger',
										'concat(ledger_id, " : ", ledger_name)','ledger_id='.$_REQUEST['ledger_id']);?>&nbsp;</td>
                                      </tr>
									  
									  <?php /*?><tr>
                                        <td align="right">Transaction Type : </td>
                                        <td><select name="tr_from" id="tr_from" class="form-control" style="max-width:250px;">
						  <option value="">Select Type</option>
										  <option value="Sales"<?=($_POST['tr_from']=="Sales")?'selected':'';?>>Sales</option>
										  <option value="Purchase"<?=($_POST['tr_from']=="Purchase")?'selected':'';?>>Purchase</option>
                                          <option value="Opening"<?=($_POST['tr_from']=="Opening")?'selected':'';?>>Opening</option>
                                          <option value="Receipt"<?=($_POST['tr_from']=="Receipt")?'selected':'';?>>Receipt</option>
										 <option value="Payment"<?=($_POST['tr_from']=="Payment")?'selected':'';?>>Payment</option>
										 
										 <option value="Journal_info"<?=($_POST['tr_from']=="Journal_info")?'selected':'';?>>Journal</option>
										 
										  <option value="DamageReturn"<?=($_POST['tr_from']=="DamageReturn")?'selected':'';?>>DamageReturn</option>
										  <option value="Inventory Journal"<?=($_POST['tr_from']=="Inventory Journal")?'selected':'';?>>Inventory Journal</option>
					  </select></td>
                                      </tr><?php */?>
									  
									  
                                        <!--<tr>
                                          <td align="right">Dealer Type:</td>
                                          <td colspan="2" align="left"><select name="dealer_type" id="dealer_type" >
                                              <option value="">Select Dealer Type</option>
                                              <option value="ALL"<?=($_POST['dealer_type']=="ALL")?'selected':'';?>>ALL</option>
                                              <option value="Distributor"<?=($_POST['dealer_type']=="Distributor")?'selected':'';?>>Distributor</option>
                                              <option value="SuperShop"<?=($_POST['dealer_type']=="SuperShop")?'selected':'';?>>SuperShop</option>
                                              <option value="Corporate"<?=($_POST['dealer_type']=="Corporate")?'selected':'';?>>Corporate</option>
                                              <option value="Retailer"<?=($_POST['dealer_type']=="Retailer")?'selected':'';?>>Retailer</option>
                                          </select></td>
                                        </tr>-->
                                        <!--<tr>
                                          <td align="right">User Name : </td>
                                          <td colspan="2" align="left">
										  <select name="user_name" id="user_name" class="form-control" style="max-width:250px;">
										  <option></option>
                                           
                                          		<? foreign_relation('user_activity_management','user_id','fname',$_POST['user_name']);?>
                                          </select>
										  
										  
										  </td>
                                        </tr>-->
                                        <tr>
                                        <td align="right">Referance: </td>
                                        <td colspan="2" align="left"><select name="reference_id" id="reference_id" style="width:250px;" >
									<!--	<option value="<?php echo $_REQUEST['reference_id'];?>"></option>-->
											<? foreign_relation('acc_reference','id','concat(ledger_id," : ",reference_name)',$_REQUEST['reference_id'],"id='".$_REQUEST['reference_id']."' ORDER BY id ASC");?>
										</select></td>
                                      </tr>
									  
									  
                                      <tr>
                                        <td colspan="3" align="center" style="padding:13px;"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td><div id="reporting">
									<table id="grp"  class="tabledesign table-bordered table-condensed" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th width="2%" height="20" align="center">SL</th>
								<th width="4%" align="center">Voucher</th>
								<th width="5%" height="20" align="center">Tr Date</th>
								<th width="27%" align="center">Acc Name</th>
								<th width="22%" align="center">Referance</th>
								<th width="14%" align="center">Particulars</th>
								<th width="5%" align="center">Type</th>
								<th width="5%" height="20" align="center">Debit</th>
								<th width="5%" align="center">Credit</th>
								<th width="11%" align="center">Balance</th>
								</tr>
<?php
if(isset($_REQUEST['show']))
{
	$cc_code = (int) $_REQUEST['cc_code'];
	$reference_id = $_REQUEST['reference_id'];
	$dealer_type = $_REQUEST['dealer_type'];
	if($dealer_type!='')
	{
	$d_table = ',dealer_info d';
	$d_where = ' and d.account_code=b.ledger_id and d.dealer_type="'.$dealer_type.'" ';
	}
		if($cc_code > 0)
		$cc_con = " AND a.cc_code=$cc_code";
		
		if($reference_id > 0)
		$reference_con = " AND a.reference_id=$reference_id";

		 $total_sql = "select sum(a.dr_amt),sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '$sledger_id%' ".$cc_con.$reference_con.$d_where;
		
		if($tr_from!='')
		 $total_sql.=" and a.tr_from='".$tr_from."'";
		 
		 if($_POST['user_name']!='')
		 $total_sql.=" and a.user_id='".$_POST['user_name']."'";
		
		$total=mysqli_fetch_row(db_query($total_sql));
		
		$c="select sum(a.dr_amt)-sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date<'$fdate' and a.ledger_id like '$sledger_id%' 
		 ".$cc_con.$reference_con.$d_where;

		 $p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_no,a.jv_no,a.cheq_no,a.cheq_date,a.relavent_cash_head , a.cc_code, a.reference_id
		 from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' ".$cc_con.$reference_con." and a.ledger_id like '$sledger_id%' ".$d_where;
		 
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
  
  <tr>
    <td align="center" bgcolor="#FFCCFF">#</td>
    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="center" bgcolor="#FFCCFF"><?php echo date('d-m-Y',strtotime($_REQUEST["fdate"]));?></td>
    <td align="left" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="left" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="left" bgcolor="#FFCCFF">Opening Balance </td>
    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF"><?php if($blance>0) echo '(Dr)'.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
    </tr>
  <?php
  $sql=db_query($p);
  while($data=mysqli_fetch_row($sql))
  {
  $pi++;
  ?>
  <tr <?=($xx%2==0)?' bgcolor="#EDEDF4"':'';$xx++;?>>
    <td align="center"><?php echo $pi;?></td>
    <td align="center" >
	<?php
	if($data[4]=='Receipt'||$data[4]=='Journal'||$data[4]=='Contra')
	{
		//$link="voucher_print_receipt.php?v_type=".$data[4]."&v_date=".$data[0]."&view=1&vo_no=".$data[8];
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
		elseif($data[4]=='Sales')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
		elseif($data[4]=='COGS')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
		elseif($data[4]=='Sales Return')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
	
		elseif($data[4]=='Purchase')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
		elseif($data[4]=='Cash Purchase')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
		elseif($data[4]=='Store Sales')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
		elseif($data[4]=='Inter Purchase')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
	
		elseif($data[4]=='Inter Sales')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
	
		elseif($data[4]=='Twisting Wages')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
		elseif($data[4]=='Consumption')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
	
	
		elseif($data[4]=='Collection')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
	
		elseif($data[4]=='Payment')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
		elseif($data[4]=='Inventory Journal')
	{
		$link="inventory_journal_print_view.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
		elseif($data[4]=='FOC')
	{
		$link="foc_sec_print_view.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
		elseif($data[4]=='SCHEME')
	{
		$link="scheme_sec_print_view.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
		elseif($data[4]=='PROVISION')
	{
		$link="provision_jv_print_view.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
	
	
	else {
		echo $data[6];
	}
	?>	</td>
    <td align="center"><?php echo date('d-m-Y',strtotime($data[0]));?></td>
    <td align="left"><?=$data[1];?></td>
    <td align="left"><?= find_a_field('acc_reference','concat(id, " : ", reference_name)','id='.$reference_id);?></td>
    <td align="left"><?=$data[5];?><?=(($data[9]!='')?'-Cq#'.$data[9]:'');?><?=(($data[10]>943898400)?'-Cq-Date#'.date('d-m-Y',$data[10]):'');?></td>
    <td align="center"><?php echo $data[4];?></td>
    <td align="right"><?php echo number_format($data[2],2);?></td>
    <td align="right"><?php echo number_format($data[3],2);?></td>
    <td align="right" bgcolor="#FFCCFF"><?php $blance = $blance+($data[2]-$data[3]); if($blance>0) echo '(Dr) '.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
    </tr>
  <?php } ?>
  <tr>
    <th colspan="6" align="center">Difference Balance : <?php echo number_format($t_total,2)." ".$t_type?> </th>
    <th align="right"><strong>Total: </strong></th>
    <th align="right"><strong><?php echo number_format($total[0],2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total[1],2);?></strong></th>
    <th align="right"><?php /*?><?php $blance = $blance+($data[2]-$data[3]); if($blance>0) echo '(Dr) '.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?><?php */?></th>
    </tr>
  
  <?php }?>
</table> 
									</div>
		<div id="pageNavPosition"></div>									
		</td>
		</tr>
		</table>
		</div></td>    
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>