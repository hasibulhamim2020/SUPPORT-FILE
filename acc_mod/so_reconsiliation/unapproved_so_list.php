<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title = "Cash Collection "  ;
do_calander('#f_date');
do_calander('#t_date');
if(isset($_POST['show'])){
$f_date=$_POST['f_date'];
$t_date=$_POST['t_date'];
}
?>
<style>
table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
	padding: 0px 4px!important;
}
</style>
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
	
	

	function update_value(do_no) {
		var total_amt = document.getElementById("actual_amt_" + do_no).value * 1;
		var rec_amt = document.getElementById("rec_amt_" + do_no).value * 1;
		var received_amt = document.getElementById("received_amt" + do_no).value * 1;

		// If received_amt is changed, update rec_amt
		
			document.getElementById("rec_amt_" + do_no).value = (total_amt - received_amt >= 0) ? (total_amt - received_amt) : 0;
		

			
			//document.getElementById("received_amt" + do_no).value = total_amt - rec_amt;
		
	}
	
	

function access_update(do_no)
	{
	
		var actual_amt=document.getElementById("actual_amt_"+do_no).value*1;
		var fr_date=document.getElementById("fr_date_"+do_no).value;
		var do_no=document.getElementById("do_no_"+do_no).value;
		var rcv_ledger=document.getElementById("cash_disable_id_"+do_no).value;
		var cus_ledger=document.getElementById("customer_ledger_"+do_no).value;
		var rec_amt=document.getElementById("rec_amt_"+do_no).value*1;
		var expense_amt =document.getElementById("received_amt"+do_no).value*1;
		var expense_ledger =document.getElementById("expense_ledger_"+do_no).value*1;
		var tr_date=document.getElementById("tr_date_"+do_no).value;
		var rec_date=document.getElementById("rec_date_"+do_no).value;
		var group_for = document.getElementById("group_for_"+do_no).value;
		
		if(rec_amt>actual_amt){
		 alert('Amount Overflow!');
		 document.getElementById("rec_amt_"+do_no).value = actual_amt;
		}else{
	
if(rcv_ledger<1){
alert("Please Enter Ledger");
}
else if(rec_amt<1){
alert("Please Enter Amount");
}
else{
//alert(rec_amt);

var strURL="cash_collec_ajax.php?rcv_ledger="+rcv_ledger+"&rec_amt="+rec_amt+"&fr_date="+fr_date+"&tr_date="+tr_date+"&do_no="+do_no+"&cus_ledger="+cus_ledger+"&rec_date="+rec_date+"&expense_ledger="+expense_ledger+"&expense_amt="+expense_amt+"&group_for="+group_for;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('pv'+do_no).style.display='inline';

						document.getElementById('pv'+do_no).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	
}

}
}


</script>
<form action="" method="post">
<div class="row bg1-color" style="    border-radius: 21px;padding: 10px;">
	<div class="col-sm-2 text-right" style="align-self:center; font-weight:bold;">
	<span>	From</span>
	</div>
	<div class="col-sm-3">
	<input type="text" class="form-control" name="f_date" value="<? if($_POST['f_date']='') echo $_POST['f_date'];else echo date('Y-m-01')?>" id="f_date" autocomplete="off" /> 
	</div>
	<div class="col-sm-1 text-center" style="align-self:center;font-weight:bold;">
	<span>	To</span>
	</div>
	<div class="col-sm-3">
	<input type="text" class="form-control" name="t_date" value="<? if($_POST['t_date']='') echo $_POST['t_date'];else echo date('Y-m-d')?>" id="t_date" autocomplete="off" />
	</div>
	<div class="col-sm-2">
	<span>	<button type="submit" name="show" id="show" class="btn btn-danger" style="font-weight:bold;">Show</button></span>
	</div>
</div>

</form>
<form action="" method="post" enctype="multipart/form-data">
<span id="show_data"></span>
<table class="table1  table-striped table-bordered table-hover table-sm" style="zoom: 90% !important">
	<thead class="thead1">
		<tr class="bgc-info">
			<th>SL</th>
			<th>SO No</th>
			<th>SO Date</th>
			<th>Receive Date</th>
			<th>Customer</th>
			<th>Receive Sub Ledger</th>
			<th>Expense Ledger </th>
			<th>Total Amount</th>
			<th>Expense Amount</th>
			<th>Un Received Amount</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody class="tbody1">
	<?php 
	   $sql="select * from sale_do_master where status in ('PROCESSING') and do_date between '".$f_date."' and '".$t_date."' order by do_no desc ";
	   //and depot_id='".$_SESSION['user']['depot']."'
	$query=db_query($sql);
	while($row=mysqli_fetch_object($query)){
	//$file_all=find_all_field('audit_file','','file_id='.$row->audit_no);
	//$com_all=find_all_field('companies','','comp_id='.$file_all->com_name);
	$tot_amt=find_a_field('sale_do_details','sum(total_amt)','do_no='.$row->do_no);
	$master_all=find_all_field('sale_do_master','*','do_no="'.$row->do_no.'"');
	$tot_disc=$master_all->discount;
	$tot_vat=(($tot_amt*$master_all->vat)/100);
	 
	$tot_cash=$row->received_amt;
	//$cash=$_POST['cash_disable_id_'.$row->id]
	
	?>
		<tr>
			<td><?=++$i;?></td>
			<td><?=$row->do_no?>
			<input type="hidden" name="do_no_<?=$row->do_no?>" id="do_no_<?=$row->do_no?>" value="<?=$row->do_no?>" style="width:160px;"  />
			<input type="hidden" name="fr_date_<?=$row->do_no?>" id="fr_date_<?=$row->do_no?>" value="<?=$f_date?>" style="width:160px;"  />
			<input type="hidden" name="tr_date_<?=$row->do_no?>" id="tr_date_<?=$row->do_no?>" value="<?=$t_date?>" style="width:160px;"  />
			
			<input type="hidden" name="group_for_<?=$row->do_no?>" id="group_for_<?=$row->do_no?>" value="<?=$row->group_for?>" style="width:160px;"  />
			
			
			</td>
			<td><?=$row->do_date?></td>
			<td><input type="date" name="rec_date_<?=$row->do_no?>" id="rec_date_<?=$row->do_no?>" value="<?php echo date('Y-m-d');?>" style="width:160px;"  /></td>
			<td>
				<?php 
				$cus_ledger=find_a_field('dealer_info','account_code','dealer_code="'.$row->dealer_code.'"');
				$cus_name=find_a_field('dealer_info','dealer_name_e','dealer_code="'.$row->dealer_code.'"');
				$cus_sub_ledger = find_a_field('dealer_info','sub_ledger_id','dealer_code="'.$row->dealer_code.'"');
				?>
			<input type="hidden" name="customer_ledger_<?=$row->do_no?>" id="customer_ledger_<?=$row->do_no?>" value="<?=$cus_ledger?>" style="width:160px;"  />			
			<?=$cus_name?>			</td>
		  <td><select name="cash_disable_id_<?=$row->do_no?>" id="cash_disable_id_<?=$row->do_no?>" value=""  style="float:left" tabindex="2"  required>
            <option></option>
            <? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$row->receive_acc_head,"type in ('Cash In Hand','Cash at Bank')"); ?>
          </select></td>
			<td><input list="expense" name="expense_ledger_<?=$row->do_no?>" id="expense_ledger_<?=$row->do_no?>" value="">
			
			<datalist id="expense">
            <option></option>
            <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$row->receive_acc_head," 1 and acc_class=4 "); ?>
          </datalist></td>
			<td><?=$tot_cash?>
		
			<input type="hidden" name="total_cash_<?=$row->do_no?>" id="total_cash_<?=$row->do_no?>" value="<?=$tot_cash;?>" />
		
		
		</td>
			<?php 
			$tot_received_amt=find_a_field('journal','sum(cr_amt)','ledger_id='.$cus_ledger.' and sub_ledger='.$cus_sub_ledger.'  and  tr_id="'.$row->do_no.'"');

			$unrec_amt=$tot_cash-$tot_received_amt;
			?>
			<td><input type="text" name="received_amt<?=$row->do_no?>" id="received_amt<?=$row->do_no?>" value="" style="width:100px;" onchange="update_value(<?=$row->do_no?>)"  /></td>
			<td>
			<input type="hidden" name="actual_amt_<?=$row->do_no?>" id="actual_amt_<?=$row->do_no?>" value="<?=$unrec_amt?>" />
			
			
			<input type="text" name="rec_amt_<?=$row->do_no?>" id="rec_amt_<?=$row->do_no?>" value="<?=$unrec_amt?>" style="width:100px;" readonly /></td>
			<td>
		<div id="pv<?=$row->do_no?>">	
			
			<?php 
			if($unrec_amt<1){
			?>
			<input name="button" type="button" class="btn btn-danger btn-sm" style="color: #fff;background-color: #dc3545;border-color: #dc3545;"  value="Cash Collected " />
			<?php } 
			else{
			?>
			<input type="button" class="btn btn-success btn-sm"  value="Receive" onclick="access_update(<?=$row->do_no?>)" />
			<?php } ?>
			</div>			</td>
		</tr>
		
		<?php } ?>
	</tbody>
</table>
</form>
<?


require_once SERVER_CORE."routing/layout.bottom.php";



?>