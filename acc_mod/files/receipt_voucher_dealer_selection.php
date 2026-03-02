<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Dealer Select';

$now=time();

do_calander('#do_date_fr');

do_calander('#do_date_to');


//var_dump($_POST);

if(isset($_POST['payment'])){

 $v_amt = $_POST['vendor_ledger_id'];
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

$receipt_no = next_tr_no('Special Receipt');
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
$dr_ledger = $_POST['b_id'];
}

$cc_code = $_POST['cc_code'];

$jv_no = next_journal_sec_voucher_id();

 $sql="select dd.dealer_name_e, m.do_date, m.do_no
from sale_do_master m, dealer_info dd
where dd.dealer_code=m.dealer_code and m.status in('CHECKED','COMPLETED') and dd.account_code='".$ledger_id."' 
group by m.do_no";

$query=db_query($sql);
while($data=mysqli_fetch_object($query)){
$do_no_del=$data->do_no;
 $v_amt = $_POST['v_amt_'.$data->do_no];
if($v_amt>0){



 $journal="INSERT INTO `secondary_journal` 
(`jv_no` ,`jv_date` ,`ledger_id` ,`narration` ,`dr_amt` ,`cr_amt` ,`tr_from` ,`tr_no`,`tr_id`,entry_by,group_for,`cheq_no`,`cheq_date`,relavent_cash_head,do_no,cc_code) 
VALUES ('$jv_no', '$date', '$ledger_id', '$r_from', '$v_amt','0', 'Special Receipt', '$receipt_no', '$tr_id', '$user_id','".$_SESSION['user']['group']."','$c_no','$c_date','$dr_ledger','$data->do_no','$cc_code')";

db_query($journal);
  


  $journal2="INSERT INTO `secondary_journal` 
(`jv_no` ,`jv_date` ,`ledger_id` ,`narration` ,`dr_amt` ,`cr_amt` ,`tr_from` ,`tr_no`,`tr_id`,entry_by,group_for,`cheq_no`,`cheq_date`,relavent_cash_head,do_no,cc_code) 
VALUES ('$jv_no', '$date', '$dr_ledger', '$r_from', '0','$v_amt', 'Special Receipt', '$receipt_no', '$tr_id', '$user_id','".$_SESSION['user']['group']."','$c_no','$c_date','$dr_ledger','$do_no_del','$cc_code')";

db_query($journal2);

}


}
$tr_from = "Special Receipt";
$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');

if($jv_config=="Yes"){

$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);

sec_journal_journal($jv_no,$jv_no,$tr_from);

$time_now = date('Y-m-d H:i:s');



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




<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>

    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

			<td>
			
				<form id="form2" name="form2" method="post" action="receipt_voucher_dealer.php">	
			<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">



              <tr>

                <td><div align="right"><strong>Dealer Name :</strong></div> </td>

                <td colspan="3">

				<?

				

						$sql = "select d.account_code,concat(d.dealer_code,'-',d.dealer_name_e) from dealer_info d where 1 order by d.dealer_code";

				?>

				<select name="ledger_id" id="ledger_id" required>

                  <option value="">ALL</option>

                  <? foreign_relation_sql($sql,$ledger_id);?>
                </select></td>
                <td><label>
                  
                  <input type="submit" name="submitit" id="submitit" value="View" style="margin-top:10px;" class="btn btn-info"/>
                  
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


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

