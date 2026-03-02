<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#date');

do_calander('#c_date');

$title='Chalan Wise Receipt Voucher';

$proj_id=$_SESSION['proj_id'];

$user_id=$_SESSION['user']['id'];

$cgc=find_all_field('config_group_class','group_id',"group_for=".$_SESSION['user']['group']);

$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' and group_for=".$_SESSION['user']['group']);
$chk_voucher_mode = db_query("SELECT voucher_mode,voucher_entry_mode FROM project_info LIMIT 1");

$old_voucher_mode = mysqli_result($chk_voucher_mode,0,'voucher_mode');

$voucher_type = mysqli_result($chk_voucher_mode,0,'voucher_entry_mode');

$separator=$_SESSION['separator'];

//step 1

if(!isset($_GET['v_d'])&&!isset($_GET['v_type']))

	{

		$voucher_mode = $_POST['voucher_mode'];

	if($voucher_mode==0&&$_POST['receipt_no']>0)

			{

		$receipt_no		   = next_invoice('receipt_no','receipt');

		$manual_receipt_no = next_invoice('receipt_no','receipt');

			}

			

		else

			{

		$receiptno=next_invoice('receipt_no','receipt');

		$receipt_no		   = $receiptno;

		$manual_receipt_no = '';

			}

		

		$v_d=time();

		if( $voucher_mode != $old_voucher_mode )

			db_query("UPDATE project_info SET voucher_mode=$voucher_mode WHERE 1");			

	}

else

{

	$receipt_no	= $_GET['v_no'];

	$v_d		= $_GET['v_d'];

	$v_no		= $_GET['v_no'];

	$v_type		= $_GET['v_type'];

}

///////////////////

if(isset($_POST['receipt']))

{


$tr_no = $_POST['tr_no'];

$receipt_no = $_POST['receipt_no'];
$date  = $_POST['date'];
$r_from  = $_POST['r_from'];
$ledger_id  = $_POST['vendor_ledger_id'];
$amount = $_POST['v_amt'];
$c_no = $_POST['c_no'];
$c_date = $_POST['c_date'];
$bank = $_POST['bank'];

if($_POST['c_id']!=''){

 $receive_ledger = $_POST['c_id'];
}elseif($_POST['b_id']!=''){
$b_ledger = explode( "##>>", $_POST['b_id'] );
$receive_ledger = $b_ledger[1];

}


for($i=0;$i<count($_POST['tr_no']);$i++){
if($amount[$i]>0){
//echo $recept="INSERT INTO receipt
//set receipt_no='$receipt_no',receipt_date='$date',proj_id='',narration='$r_from',ledger_id='$ledger_id',dr_amt='$amount[$i]',cr_amt='0',type='Debit',cur_bal='',received_from='receipt',cheq_no='$c_no',cheq_date='$c_date',bank='$bank',manual_receipt_no='$manual_receipt_no',cc_code='',entry_by='".$_SESSION['user']['id']."'";
//db_query($recept);
//
//echo $recept="INSERT INTO receipt set
//receipt_no='$receipt_no',receipt_date='$date' ,proj_id='' ,narration ='$r_from',ledger_id='$receive_ledger' ,dr_amt='0' ,cr_amt='$amount[$i]' ,type='Credit' ,cur_bal='' ,received_from='receipt',cheq_no='$c_no',cheq_date='$c_date',bank='$bank',manual_receipt_no='$manual_receipt_no',cc_code='$cc_code',entry_by='".$_SESSION['user']['id']."'";
//db_query($recept);

//-------------test ----------

//$journal="INSERT INTO `secondary_journal` 
//(`jv_no` ,`jv_date` ,`ledger_id` ,`narration` ,`dr_amt` ,`cr_amt` ,`tr_from` ,`tr_no`,`tr_id`,entry_by,group_for,`cheq_no`,`cheq_date`,relavent_cash_head,do_no) 
//VALUES ('$jv_no', '$date', '$ledger_id', '$r_from', '$v_amt','0', 'receipt', '$receipt_no', '$tr_id', '$user_id','$group_for','$c_no','$c_date','$dr_ledger','$data->do_no')";

$sql="select dd.dealer_name_e,m.do_no,m.do_date,m.ref_no,m.remarks,m.do_no,sum(total_amt) total_amt 
from sale_do_master m, sale_do_details d, dealer_info dd
where dd.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status in('CHECKED','COMPLETED') and dd.account_code='".$ledger_id."' 
group by m.do_no";

	  $query=db_query($sql);
	  while($data=mysqli_fetch_object($query)){

    echo  $v_amt = "'v_amt_'".$data->do_no."' ";
echo $recept="INSERT INTO secondary_journal
set jv_no='$jv_no',jv_date='$date'narration='$r_from',ledger_id='$receive_ledger',dr_amt='".$_POST[$v_amt]."',cr_amt='0',tr_from='Special Receipt' ,tr_no='$receipt_no',tr_id='$do_no',cheq_no='$c_no',cheq_date='$c_date',bank='$bank',manual_receipt_no='$manual_receipt_no',cc_code='',entry_by='".$_SESSION['user']['id']."'";
//db_query($recept);

//echo $recept="INSERT INTO secondary_journal
//set jv_no='$jv_no',jv_date='$date'narration='$r_from',ledger_id='$ledger_id',dr_amt='0',cr_amt='$amount[$i]',tr_from='Special Receipt' ,tr_no='$receipt_no',tr_id='$do_no',cheq_no='$c_no',cheq_date='$c_date',bank='$bank',manual_receipt_no='$manual_receipt_no',cc_code='',entry_by='".$_SESSION['user']['id']."'";
//db_query($recept);

}

}





}




}


//print code

if(!isset($_GET['v_d']))

{

	$receiptno=next_invoice('receipt_no','receipt');

	$v_d=time();

}

?>

<?php js_ledger_subledger_autocomplete_new('receipt',$proj_id,$voucher_type,$_SESSION['user']['group']); 
    $led2=db_query("select  concat(ledger_name,'##>>',ledger_id), concat(ledger_name,'##>>',ledger_id) FROM accounts_ledger WHERE ledger_name not like '%cash%' and ledger_group_id='$cash_and_bank_balance' and parent=0 order by ledger_id");

	if(mysqli_num_rows($led2) > 0)

	{

      $data2 = '[';

	  while($ledg2 = mysqli_fetch_row($led2)){$data2 .= '{ name: "'.$ledg2[1].'", id: "'.$ledg2[0].'" },';}

      $data2 = substr($data2, 0, -1);

      $data2 .= ']';

	}

	else {$data2 = '[{name:"empty", id:""}]';}

?>

<script type="text/javascript">

$(document).ready(function(){
	function formatResult(row) {

		return row[0].replace(/(<.+?>)/gi, '');

	}
	var data2 = <?php echo $data2; ?>;

    $("#b_id").autocomplete(data2, {



		matchContains: true,



		minChars: 0,



		scroll: true,



		scrollHeight: 300,



        formatItem: function(row, i, max, term) {



            return row.name; // + " [" + row.id + "]";



		},



		formatResult: function(row) {



			return row.id;



		}



	});

$(window).load(function() {

      open_limit(1);

});

  });

</script>

<script type="text/javascript">

function voucher_no(val)

	{

		var voucher_mode = val;

		

		if( voucher_mode == 0 )

			{

				document.getElementById('receipt_no').value		= "";

				document.getElementById('receipt_no').readOnly	= false;

				document.getElementById('receipt_no').select();

				document.getElementById('receipt_no').focus();

			}

		else if( voucher_mode == 1 )

			{

				document.getElementById('receipt_no').value		= "<?php echo $receipt_no;?>";

				document.getElementById('receipt_no').readOnly	= true;

			}

	}

	

function DoNav(theUrl)

{

	var URL = 'voucher_view_popup.php?'+theUrl;

	popUp(URL);

}

function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

	

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


function goto_tab()

{

	//alert('tab mamaun');

	document.getElementById('ledger_id').focus()

}


</script>

<script type="text/javascript" src="../common/js/check_balance.js"></script>

<script type="text/javascript" src="../common/receipt_check.js"></script>

<style type="text/css">

<!--

.style1 {font-size: 18px}

.style2 {font-size: 10px}

-->

</style>
<?
create_combobox('bank_disable_id');
?>
<form action="receipt_voucher_dealer_selection.php" id="form2" name="form2" method="post" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #C1DAD7;border-collapse:collapse;width:100%;">

  <tr>

    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="100%" border="0" cellspacing="2" cellpadding="2" style=" margin-left:-18px; margin-top:10px;" >
                    <!--<tr>
                      <td><div align="right">Voucher Mode:</div></td>
                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><input type="radio" name="voucher_mode" id="voucher_mode_manual" class="radio" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<?php } ?> onclick="voucher_no(this.value)"/>
                              Manual</td>
                            <td><input class="radio" type="radio" name="voucher_mode" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<?php } ?> onclick="voucher_no(this.value)"/>
                              Auto</td>
                          </tr>
                      </table></td>
                    </tr>-->
                    <tr>
                      <td><div align="right">Voucher No:</div></td>
                      <td><? 

$receipt_no=next_invoice('receipt_no','receipt');

if($v_d>10000)

$v_d=date("d-m-y",$v_d);
if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; } 

elseif($old_voucher_mode==1){$v_no_show='value="'.$receiptno.'" readonly'; } 

else $v_no_show='';

?>
                          <input name="receipt_no" type="text" id="receipt_no" size="15" <?=$v_no_show?> />
                          <?php if($_GET['action']=='edit') echo "<font color='#FF0000'>EDITING</font>";?>                      </td>
                      <td width="19%" align="right"><div align="right">Voucher Date:</div></td>



                        <td width="30%"><input name="date" type="text" id="date" value="<?php echo $_SESSION['old_v_date'];?>" size="10" <?php if($_GET['action']=='edit') echo "readonly='readonly'";?> tabindex="1"required />
                          <?php if($_GET['action']=='edit') echo "<font color='#FF0000'>EDITING</font>";?></td>
                    </tr>
                    <tr>
                      <td><div align="right">Naration :</div></td>
                      <td >
                        <input name="r_from" class="input1" type="text" id="r_from" value="" tabindex="1" required/>
                      </td>
					  <td align="right">Type:</td>

                      <td><? if($jv->tr_no>0){ ?><input type="text" name="type" id="type" value="<?=$jv->type?>" readonly="readonly"  /><? }else{?><select name="type" id="type"                                    required onChange="check_type()" >

                                    <option value="0"></option>

                                    <option value="CASH" <?=($jv->type=='CASH')?'Selected':'';?> >CASH</option>

                                    <option value="BANK" <?=($jv->type=='BANK')?'Selected':'';?> >BANK</option>

                                </select><? } ?></td>
                    </tr>
                    <tr id="cash_check">
                      <td><div align="right">Cash A/c Debit:</div></td>
                      <td colspan="2" style="text-align:left">



                        <div align="left">
                         <select name="c_id" class="form-control" id="cash_disable_id" style="float:left" tabindex="2" >
                             <option></option>
                        <?

$led2=db_query("select ledger_id, ledger_name from accounts_ledger where ledger_name like '%cash%' and parent=0 order by ledger_id");

if(mysqli_num_rows($led2) > 0)

{

while($ledg2 = mysqli_fetch_row($led2)){

echo '<option value="'.$ledg2[0].'">'. $ledg2[1].' ['.$ledg2[0].']</option>';

}

$data2 = substr($data2, 0, -1);



}



						?><option></option>



                        </select>
                          </div></td></tr>
                    <tr id="bank_check">
                      <td><div align="right">Bank A/c Debit:</div></td>
                      <td colspan="2"><div align="left">
                        <select name="b_id" id="bank_disable_id" style="float:left" tabindex="2" >

                          <option value="0"></option>

<?

foreign_relation('accounts_ledger','ledger_id','ledger_name',$b_id,"ledger_name not like '%cash%' and parent=0 and ledger_id like '".$cash_and_bank_balance."%'  order by ledger_id");

?>

</select>
                      </div></td>
                    </tr>
                    <tr id="check_no_check">
                      <td><div align="right"><span>Cheque No:</span></div></td>
                      <td colspan="3">
                        <input name="c_no" type="text" id="c_no" value="" size="20" maxlength="25" tabindex="4"/>
                      </td>
                    </tr>
                    <tr id="check_date_check">
                      <td><div align="right"><span>Cheque</span> Date: </div></td>
                      <td colspan="3">
                        <input name="c_date" type="text" id="c_date" tabindex="6" value="" size="12" maxlength="10" />
                      </td>
                    </tr>
                    <tr id="of_bank_check">
                      <td align="right"><div align="right">Of Bank:</div></td>
                      <td colspan="3">
                        <input name="bank" type="text" id="bank" value="" class="input1"  tabindex="7"/>
						
						<input type="hidden" name="vendor_ledger_id" value="<?=$_POST['ledger_id']?>" />
                      </td>
                    </tr>
					<tr>
                      <td align="right"><span class="style3">*</span>Cost Center :</td>

                      <td colspan="3">
					       <select name="cc_code" id="cc_code" <? if($jv->tr_no>0) echo 'readonly'?>>
                               <option></option>
<? foreign_relation('cost_center cc, cost_category c','cc.id','cc.center_name',$cc_code,"cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC");?>

                           </select>

</td>

</tr>
                </table></td>
                <td align="right" valign="top"><div class="box">
                    <table  class="tabledesign table-bordered" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #C1DAD7;border-collapse:collapse;width:100%;">
                      <tr>
                        <th>Voucher No </th>
                        <th>Amount</th>
                        <th colspan="3">Narration</th>
                      </tr>
                      <?

$sql2="select a.tr_no, sum(a.cr_amt), a.narration,a.jv_date, a.do_no, a.jv_no

from  secondary_journal a where a.tr_from='Special Receipt' and a.group_for='".$_SESSION['user']['group']."'  and SUBSTRING(a.tr_no,5,1)='0' and  a.cr_amt>0 group by a.jv_no order by a.tr_no desc limit 6";

$data2=db_query($sql2);

if(mysqli_num_rows($data2)>0){

while($dataa=mysqli_fetch_row($data2))

{$dataa[2]=substr($dataa[2],0,20).'...';

					?>
                      <tr class="alt">
                        <td><?=$dataa[0]?></td>
                        <td><?=$dataa[1]?></td>
                        <td><?=$dataa[2]?></td>
                        <td style="padding:1px;" onclick="DoNav('<?php echo 'v_type=Special Receipt&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[5].'&view=Show&in=receipt' ?>');"><img src="../images/copy_hover.png" width="16" height="16" border="0" /></td>
                        <td style="padding:1px;" ><a href="voucher_print_receipt.php?v_type=Special Receipt&amp;vo_no=<?php echo $dataa[5];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" /></a></td>
                      </tr>
                      <? }}?>
                    </table>
                </div></td>
              </tr>
            </table></td>

	    </tr>

		<tr><td>&nbsp;</td></tr>

        <tr>

          <td>
      <table width="98%" align="center" cellspacing="0" class="tabledesign">

      <tbody>
	

      <tr>

      <th>SL</th>

      <th>DO Date </th>
      <th>DO#</th>

      <th>&nbsp;</th>

      <th>Total Amt </th>
      <th>Total Received Amt </th>
      <th>Receivable Amt</th>

      <th>Action</th>

      <th>Amount</th>
      <th>&nbsp;</th>
      </tr>

	  <?
		// if($_POST['do_date_fr']!=''){

	  $i=0;

		if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';

	 	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

		if($_POST['depot_id']>0) $depot_con = ' and r.warehouse_id="'.$_POST['depot_id'].'" ';

		if($_POST['ledger_id']!='') {$ledger_id=$_POST['ledger_id'];}

$sql="select dd.dealer_name_e,m.do_no,m.do_date,m.ref_no,m.remarks,m.do_no,sum(total_amt) total_amt 
from sale_do_master m, sale_do_details d, dealer_info dd
where dd.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status in('CHECKED','COMPLETED') and dd.account_code='".$ledger_id."' 
group by m.do_no";

	  $query=db_query($sql);
	  while($data=mysqli_fetch_object($query)){
	
	  $tot_amt =  find_all_field_sql("select sum(dr_amt) tdr,sum(cr_amt) tcr from secondary_journal where do_no='".$data->do_no."' ");
	  $tot = $data->total_amt; 
	  $tot_payable_amt = ($tot-$tot_amt->tcr);
	  
      if($tot_payable_amt>0){

	  ?>

      <tr class="alt">

      <td align="center"><div align="left">

        <?=++$i;?>

      </div></td>

      <td align="center"><? echo $data->do_date;?></td>
      <td align="center"><div align="left"><input type="hidden" id="do_no_<?=$data->do_no;?>" name="do_no_<?=$data->do_no;?>" value="<?=$data->do_no;?>" /><?=$data->do_no;?></div></td>
      <td align="center"><div align="left"></div></td>

      <td align="right"><?  echo number_format($data->total_amt,2); $received = $received + $data->total_amt;?>	  </td>
      <td align="right"><?=$tot_amt->tcr; $total_received+=$tot_amt->tcr;?></td>
      <td align="right"><?=$tot_payable_amt;?>
	  
	  
	  <input type="hidden" value="<?=$tot_payable_amt?>" name="tott_<?=$data->do_no ?>" id="tott_<?=$i;?>" /></td>

      <td align="center"><button onclick="sum_sum(<?=$i;?>);calculateRBN()" type="button">Full</button></td>

      <td align="center"><input type="text" name="v_amt_<?=$data->do_no?>" id="v_amt_<?=$i;?>" style=" width: 90px; " onchange="sr_alert(<?=$i;?>);calculateRBN();" onblur="calculateRBN()" onkeyup="calculateRBN()" /></td>
      <td align="center"><a target="_blank" href="purchase_sec_print_view.php?do_no=<?=$data->do_no ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
      </tr>

	  <? $g_tot_paid = $g_tot_paid + $tot_paid_amt;  $g_tot_payable = $g_tot_payable + $tot_payable_amt;  
	   } 
	  
	  }
	  ?>

	        <tr class="alt">

        <td colspan="4" align="center"><div align="right"><strong>Total : </strong></div>

          

            <div align="left"></div></td>

        <td align="right"><?=number_format($received,2);?></td>
        <td align="right"><?=number_format($total_received,2);?></td>
        <td align="right"><?=number_format($g_tot_payable,2);?></td>

        <td align="center">&nbsp;</td>

        <td align="center"><input type="number" name="t_amt" id="t_amt" value="" readonly="" style="width:145px; background-color: lightgoldenrodyellow;" class="form-control" /></td>
        <td align="center"><div align="left"></div></td>
      </tr>
  </tbody></table>	
  <br />
      <div align="center">
              <input type="submit" name="receipt" class="btn btn-success" value="SUBMIT"  />
	
          </div>

  </td>

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


</form>	

<script>
function calculateRBN(){
var total_amount = 0 ;

var i;
for (i = 1; i <= <?=$i;?>; i++) {
//alert("amount_"+i);
var amount = document.getElementById("v_amt_"+i).value*1;
total_amount +=amount;

}



document.getElementById("t_amt").value=total_amount.toFixed(2);

}


function check_type()

{

var check_type = document.getElementById('type').value;

if(check_type=='CASH'){

document.getElementById('bank_check').style.display='none';

document.getElementById('check_no_check').style.display='none';

document.getElementById('check_date_check').style.display='none';

document.getElementById('of_bank_check').style.display='none';



}else{

document.getElementById('bank_check').style.display='';

document.getElementById('check_no_check').style.display='';

document.getElementById('check_date_check').style.display='';

document.getElementById('of_bank_check').style.display='';

}

if(check_type=='BANK'){

document.getElementById('cash_check').style.display='none';

}else{

document.getElementById('cash_check').style.display='';

}

}

window.onload=check_type;
</script>
  
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

