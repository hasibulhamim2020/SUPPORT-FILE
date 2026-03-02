<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";



$title='Invoice Receipt';

$now=time();

do_calander('#do_date_fr');

do_calander('#do_date_to');


if(isset($_POST['payment'])){

echo $v_amt = $_POST['vendor_ledger_id'];
$jv_no = $_POST['jv_no'];


$max = count($_POST['jv_no']);
$new_jv_no = find_a_field('journal','max(new_jv_no)+1',' 1 ');
for($i=0;$i<$max;$i++){
if($v_amt[$i]>0){

//$delete = 'delete from journal where jv_no='.$jv_no[$i].' and tr_from="Purchase" and cr_amt>0';
//db_query($delete);
sec_journal_journal_modifyed_payment($jv_no[$i],'Purchase',$v_amt[$i],$new_jv_no);

}

}


}

if(isset($_POST['receipt']))

{


$tr_no = $_POST['tr_no'];

$receipt_no = next_invoice('receipt_no','receipt');
$date  = $_POST['date'];
$r_from  = $_POST['r_from'];
$ledger_id  = $_POST['vendor_ledger_id'];
$amount = $_POST['v_amt'];
$c_no = $_POST['c_no'];
$c_date = $_POST['c_date'];
$bank = $_POST['bank'];
$user_id = $_SESSION['user']['id'];
$group_for = $_SESSION['user']['id'];
if($_POST['c_id']!=''){
$dr_ledger = $_POST['c_id'];
}
elseif($_POST['b_id']!=''){
$b_ledger = explode( "##>>", $_POST['b_id'] );
$dr_ledger = $b_ledger[1];
}

$jv_no = next_journal_voucher_id();

echo $sql="select dd.dealer_name_e, m.do_date, m.do_no
from sale_other_master m, dealer_info dd
where dd.dealer_code=m.dealer_code and m.depot_id=15 and m.status in('CHECKED','COMPLETED') and dd.account_code='".$ledger_id."' 
group by m.do_no";

$query=db_query($sql);
while($data=mysqli_fetch_object($query)){

$v_amt = $_POST['v_amt_'.$data->do_no];
if($v_amt>0){


$recept="INSERT INTO receipt set
receipt_no='$receipt_no',receipt_date='$date' , narration ='$r_from', ledger_id='$ledger_id', dr_amt='0' ,cr_amt='$v_amt', type='Credit', cur_bal='', received_from='receipt', do_no='$data->do_no',cheq_no='$c_no', cheq_date='$c_date',bank='$bank', entry_by='$user_id'";
db_query($recept);
$tr_id = db_insert_id();

$journal="INSERT INTO `journal` 
(`do_no` ,`jv_date` ,`ledger_id` ,`narration` ,`dr_amt` ,`cr_amt` ,`tr_from` ,`tr_no`,`tr_id`,user_id,group_for,`cheq_no`,`cheq_date`,relavent_cash_head) 
VALUES ('$jv_no', '$date', '$ledger_id', '$r_from', '$v_amt','0', 'receipt', '$receipt_no', '$tr_id', '$user_id','$group_for','$c_no','$c_date','$dr_ledger')";

db_query($journal);
$total_v_amt = $total_v_amt + $v_amt;
}
}
if($total_v_amt>0){
echo $recept="INSERT INTO receipt set 
receipt_no='$receipt_no', receipt_date='$date', narration='$r_from', ledger_id='$dr_ledger', dr_amt='$total_v_amt', cr_amt='0', type='Debit', cur_bal='', received_from='receipt', cheq_no='$c_no', cheq_date='$c_date',bank='$bank', entry_by='".$_SESSION['user']['id']."'";
db_query($recept);
$tr_id = db_insert_id();

$journal="INSERT INTO `journal` 
(`do_no` ,`jv_date` ,`ledger_id` ,`narration` ,`dr_amt` ,`cr_amt` ,`tr_from` ,`tr_no`,`tr_id`,user_id,group_for,`cheq_no`,`cheq_date`,relavent_cash_head) 
VALUES ('$jv_no', '$date', '$dr_ledger', '$r_from', '0','$total_v_amt', 'receipt', '$receipt_no', '$tr_id', '$user_id','$group_for','$c_no','$c_date','$dr_ledger')";

db_query($journal);

}
}

?>

<script>


function sr_alert(id){



var tot = (document.getElementById('tott_'+id).value)*1;
var v_amt = (document.getElementById('v_amt_'+id).value)*1;

if(tot<v_amt){
alert("You Cant Place More Then Payabel Amount !!");
document.getElementById('v_amt_'+id).value = '';

}

}


function sum_sum(id){


var tot = (document.getElementById('tott_'+id).value)*1;

document.getElementById('v_amt_'+id).value = tot;

}



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



	function update_value(id)



	{



var item_id=id; // Rent

var ra=(document.getElementById('ra_'+id).value)*1;

var flag=(document.getElementById('flag_'+id).value); 

if(ra>0){

var strURL="received_amt_ajax.php?item_id="+item_id+"&ra="+ra+"&flag="+flag;}

else

{

alert('Receive Amount Must be Greater Than Zero.');

document.getElementById('ra_'+id).value = '';

document.getElementById('ra_'+id).focus();

return false;

}



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

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







<!--singel input filed-->
<form id="form2" name="form2" method="post" action="invoice_receive.php">
	<div class="d-flex justify-content-center">

		<div class="n-form1 fo-short pt-3">
			<div class="container">
				<div class="form-group row  m-0 mb-1 pl-3 pr-3">
					<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Select Invoice :</label>
					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
						<select name="dealer" id="dealer" class="form-control" required>

							<option value=""></option>
							<?
							$sql = 'select d.dealer_name_e,d.account_code from secondary_journal j, dealer_info d where j.tr_from="Invoice" and j.ledger_id=d.account_code group by d.account_code';
							$qr = db_query($sql);
							while($data = mysqli_fetch_object($qr)){
								?>
								<option value="<?=$data->account_code?>"><?=$data->dealer_name_e.'#'.$data->account_code?></option>
							<? } ?>

						</select>
					</div>
				</div>

			</div>

			<div class="n-form-btn-class">
				<input type="submit" name="submitit" id="submitit" value="View Invoice" class="btn1 btn1-submit-input"/>
			</div>

		</div>

	</div>

</form>






<?php /*>
<br>
<br>
<br>
<br>
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>

    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

			<td>
			
				<form id="form2" name="form2" method="post" action="invoice_receive.php">	
			<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">



              <tr>

                <td><div align="right"><strong>Select Invoice  :</strong></div> </td>

                <td colspan="3">

				

				<select name="dealer" id="dealer" class="form-control" required>

                  <option value=""></option>
             <?
			   $sql = 'select d.dealer_name_e,d.account_code from secondary_journal j, dealer_info d where j.tr_from="Invoice" and j.ledger_id=d.account_code group by d.account_code';
			   $qr = db_query($sql);
			   while($data = mysqli_fetch_object($qr)){
			 ?>
			 <option value="<?=$data->account_code?>"><?=$data->dealer_name_e.'#'.$data->account_code?></option>
			 <? } ?>
                  
                </select>
				</td>
                <td><label>
                  
                  <input type="submit" name="submitit" id="submitit" value="View Invoice" class="btn1 btn1-submit-input"/>
                  
                </label></td>
              </tr>
            </table>
			
			</form>
			</td>

	    </tr>

		<tr><td>&nbsp;</td></tr>

        <tr>

          <td>&nbsp;</td>

	    </tr>

		<tr>

		<td>&nbsp;</td>

		</tr>

		<tr>

		<td>

		<div>

                    

		<table width="100%" border="0" cellspacing="0" cellpadding="0">		

		<tr>		

		<td>

		<div style="width:380px;"></div></td>

		</tr>

		</table>

	        </div>

		</td>

		</tr>

      </table></td></tr>

</table>



<*/?>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

