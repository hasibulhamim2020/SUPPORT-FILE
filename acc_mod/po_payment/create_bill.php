<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='PO Wise Payment Voucher';


  create_combobox('do_no');

do_calander('#invoice_date');
//do_calander('#ldbc_no_date');
do_calander('#realization_date');

 $data_found = $_POST['account_code'];

if ($data_found==0) {
 create_combobox('account_code');
  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$payment_date=$_POST['invoice_date'];
		
		$cr_ledger_id=$_POST['cr_ledger_id'];
		
		
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['po_no']!='')
  $po_no_con=" and j.tr_id=".$_POST['po_no'];
  


		$group_for= $_SESSION['user']['group'];

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		//$YR = date('Y',strtotime($ch_date));
//  		$yer = date('y',strtotime($ch_date));
//  		$month = date('m',strtotime($ch_date));
//
//  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
//   		$cy_id = sprintf("%07d", $ch_cy_id);
//   		$chalan_no=''.$yer.''.$month.''.$cy_id;


		
		$payment_no = next_transection_no($group_for,$payment_date,'payment_vendor','payment_no');


		 $sql = "SELECT d.vendor_id, d.ledger_id, d.vendor_name, j.tr_no, j.jv_date, sum(j.cr_amt) as invoice_amt, j.tr_id FROM journal j, vendor d WHERE j.ledger_id=d.ledger_id and j.tr_from in ('Purchase') ".$account_code_con.$do_no_con."  group by j.tr_no";

		$query = db_query($sql);

	


		while($data=mysqli_fetch_object($query))

		{
	

			if($_POST['payment_amt_'.$data->tr_no]>0)

			{
			
	

				$payment_amt=$_POST['payment_amt_'.$data->tr_no];
				$account_code=$_POST['account_code_'.$data->tr_no];
				$tr_no=$_POST['tr_no_'.$data->tr_no];



   $so_invoice = 'INSERT INTO payment_vendor (payment_no, payment_date, po_no, pr_no, vendor_id, ledger_id, cr_ledger_id, payment_amt, status, entry_at, entry_by)
  
  VALUES("'.$payment_no.'", "'.$payment_date.'", "'.$data->tr_id.'", "'.$tr_no.'", "'.$data->vendor_id.'", "'.$account_code.'", "'.$cr_ledger_id.'", "'.$payment_amt.'", "COMPLETE", "'.$entry_at.'", "'.$entry_by.'")';

db_query($so_invoice);


}

}


if($payment_no>0)
{
auto_insert_po_payment_secoundary($payment_no);

}

?>

<script language="javascript">
window.location.href = "po_wise_payment_update.php";
</script>

<?	

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}






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



	function update_value(pi_id)



	{



var pi_id=pi_id; // Rent


var lc_no=(document.getElementById('lc_no').value);


var flag=(document.getElementById('flag_'+pi_id).value); 

var strURL="lc_update_ajax.php?pi_id="+pi_id+"&lc_no="+lc_no+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+pi_id).style.display='inline';

						document.getElementById('divi_'+pi_id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}


function sum_sum(id){
var tot_due_amt = (document.getElementById('tot_due_amt_'+id).value)*1;

document.getElementById('payment_amt_'+id).value = tot_due_amt;

}







</script>






<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>Vendor Name : </strong></td>



    <td ><select name="account_code" id="account_code" style="width:220px;">
      <option></option>
      <?

foreign_relation('vendor','ledger_id','vendor_name',$_POST['account_code'],'1');

?>
    </select></td>



    <td rowspan="4" ><strong>

      <input type="submit" name="submit" id="submit" value="View Invoice" class="btn1 btn1-submit-input" />

    </strong></td>
    </tr>
								  
								  
  
								  
								  
								  
								  
								  
								</table>

    </div>

<? }?>


<? if(isset($_POST['submit'])){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="7%">DATE:</td>

									<td width="24%">
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="14%">VENDOR :</td>
									<td width="21%">
									
									<input name="account_code" type="hidden" id="account_code"  readonly="" style="width:220px; height:32px;" value="<?=$_POST['account_code'];?>"  required tabindex="105" />
									
									<? $dealer_data = find_all_field('vendor','','ledger_id='.$_POST['account_code']); 
									$dealer_closing = find_a_field_sql("select sum(dr_amt-cr_amt) from journal where ledger_id = '".$_POST['account_code']."'");
	
									$closing_balance=$dealer_closing;
									?>
									
										
									
									<input name="received_from" type="text" id="received_from"  readonly="" style="width:220px; height:32px;" value="<?=$dealer_data->vendor_name;?>"  required tabindex="105" />										</td>
									<td width="14%">CUSTOMER BALANCE :</td>
									<td width="20%">
									
									<table>
		  	<tr>
				<td><input name="custemer_balance" type="text" id="custemer_balance" required readonly="" style="width:120px; height:32px; " autocomplete="off"  
				 value="<? if ($dealer_closing>0) { echo  number_format($closing_balance,2). ""; } else { echo number_format($closing_balance*(-1),2). ""; }?>"/>				</td>
				<td><? 	if ($dealer_closing>0) { echo  "<b>(DR)</b>"; } else { echo  "<b>(CR)</b>"; } ?></td>
			</tr>
		  </table>
									</td>
								  </tr>
								  
								  
  
								  <tr>

								 <td>PO NO :</td>

									<td>

	<select name="po_no" id="po_no" style="width:220px;">
	
	<option></option>

        <? foreign_relation('purchase_master','po_no','po_no',$_POST['po_no'],'status!="MANUAL"'); ?>

    </select>								</td>
									<td>PMT. METHOD:</td>
									<td>
								
									<select name="payment_method" id="payment_method" required style="width:220px;" onchange="getData2('cash_bank_ajax.php', 'cash_bank_filter', this.value,  document.getElementById('payment_method').value);">
									<option></option>
	
								
										<? foreign_relation('payment_method','payment_method','payment_method',$_POST['payment_method'],'1');?>
									</select>
																											</td>
									<td>CASH/BANK:</td>
									<td><span id="cash_bank_filter">
									
									
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in (10201,10202)');?>
									</select>
									</span>										</td>
								  </tr>
								  <tr>
								    <td>CHEQUE NO:</td>
								    <td>
									<input style="width:220px; height:32px;"  name="cheque_no" type="text" id="cheque_no"  value="<?=$_POST['cheque_no']?>"    />									</td>
								    <td>CHEQUE DATE:</td>
								    <td><input style="width:220px; height:32px;"  name="cheque_date" type="date" id="cheque_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d');$_POST['cheque_date']?>"   required />			</td>
								    <td>OF BANK:</td>
								    <td>
									<input style="width:220px; height:32px;"  name="of_bank" type="text" id="of_bank"  value="<?=$_POST['of_bank']?>"    />	
									</span>									</td>
							      </tr>
								  
								  
								  
								</table>

    </div>
	
	<? }?>



<? if(isset($_POST['submit'])){ ?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="12%">PO No </th>

    <th width="15%">PR  No </th>

    <th width="19%">PR Date </th>
    <th width="12%">PR Amt </th>
    <th width="11%">Total Pay  Amt </th>
    <th width="9%">Due Amt </th>
    <th width="11%">Payment Amt </th>
    <th width="11%">Action</th>
  </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['do_no']!='')
  $do_no_con=" and j.tr_id=".$_POST['do_no'];
  




  
$sql = "select sum(dr_amt) as payment_amt, ledger_id, tr_id  from journal where tr_from='Payment' group by tr_id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$payment_amt[$data->ledger_id][$data->tr_id]=$data->payment_amt;

}
  
  
  
 $sql = "select sum(dr_amt) as return_amt, ledger_id, tr_id  from journal where tr_from='Purchase Return'  group by tr_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$return_amt[$data->ledger_id][$data->tr_id]=$data->return_amt;

}
 
  


   
    $sql = "SELECT d.ledger_id, d.vendor_name, j.tr_no, j.jv_date, sum(j.cr_amt) as invoice_amt, j.tr_id FROM journal j, vendor d WHERE j.ledger_id=d.ledger_id and j.tr_from in ('Purchase')  ".$account_code_con.$do_no_con."  group by j.tr_no";



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){$i++;


  ?>



<? if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><a href="../../../purchase_mod/pages/po/po_print_view.php?po_no=<?=$data->tr_id?>" target="_blank"><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->tr_id;?>
    </span></a></td>

    <td><a href="../../../warehouse_mod/pages/po_receiving/chalan_view2.php?v_no=<?=$data->tr_no?>" target="_blank"><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->tr_no?>
    </span></a><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$data->do_no?>"></a></td>

    <td><?php echo date('d-m-Y',strtotime($data->jv_date));?></td>
    <td><strong>
      <?=number_format($data->invoice_amt,2);?>
    </strong></td>
    <td><strong>
      <?=number_format($payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no],2);?>
    </strong></td>
    <td><strong><? echo number_format($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no],2);?></strong>
	<input name="tot_due_amt_<?=$data->tr_no?>" id="tot_due_amt_<?=$data->tr_no?>" type="hidden" size="10"  value="<?=$due_amt?>" style="width:80px;" />
	</td>
    <td>
	<input name="account_code_<?=$data->tr_no?>" id="account_code_<?=$data->tr_no?>" type="hidden" size="10"  value="<?=$data->ledger_id?>" style="width:80px;" />
 <input name="tr_no_<?=$data->tr_no?>" id="tr_no_<?=$data->tr_no?>" type="hidden" size="10"  value="<?=$data->tr_no?>" style="width:80px;" />
 <input name="payment_amt_<?=$data->tr_no?>" id="payment_amt_<?=$data->tr_no?>" type="text" size="10"  value="" style="width:120px; height:25px;"  />	</td>
    <td align="center"><center><button onclick="sum_sum(<?=$data->tr_no ?>)" type="button" class="btn1 btn1-bg-submit" >Full</button></center></td>
  </tr>

  <? } }?>
</table>



</div>
<br /><br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirmit" type="submit" class="btn1 btn1-submit-input" value="SAVE & NEW" /></td>

</tr>



</table>


<?php /*?><table width="100%" border="0">

<? 

 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');
		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);


if($pi_status!="MANUAL"){




?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table><?php */?>




<? }?>








<p>&nbsp;</p>

</form>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>