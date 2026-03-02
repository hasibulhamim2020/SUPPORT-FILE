<?php



session_start();



ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







$title='Receipt Voucher';



$proj_id=$_SESSION['proj_id'];



$user_id=$_SESSION['user']['id'];



$active='recvou';



$_SESSION['user']['group']=2;



 $cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' and group_for=".$_SESSION['user']['group']);












$chk_voucher_mode = db_query("SELECT voucher_mode,voucher_entry_mode FROM project_info LIMIT 1");



$old_voucher_mode = mysqli_result($chk_voucher_mode,0,'voucher_mode');



$voucher_type = mysqli_result($chk_voucher_mode,0,'voucher_entry_mode');







$separator=$_SESSION['separator'];















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



		$receipt_no = next_invoice('receipt_no','receipt');



		$manual_receipt_no = '';



	}



	



	$v_d=time();



	if( $voucher_mode != $old_voucher_mode )



	{



		db_query("UPDATE project_info SET voucher_mode=$voucher_mode WHERE 1");			



	}



}



else



{



	$receipt_no	=$_GET['v_no'];



	$v_d		=$_GET['v_d'];



	$v_no		=$_GET['v_no'];



	$v_type		=$_GET['v_type'];



}



///////////////////



if(isset($_POST['limmit']))



{



	if($_GET['action'] == 'EDITING')



	{



		$vv 	= $_GET['v_type']."_no";



		$del1 	= "delete from journal where tr_no='$v_no' and tr_from='$v_type'";



		$dell 	= "delete from $v_type where $vv='$v_no'";



		$ddl 	= db_query($del1);



		$dd1 	= db_query($dell);



		$msg	= 'Voucher Successfully Updated.';



		$type	= 1;



	}



		$date		= $_SESSION['old_v_date']=$_REQUEST["date"];



		$ledger_id	= $_REQUEST["ledger_id"];



		$bank		= $_REQUEST["bank"];



		$r_from		= $_REQUEST['r_from'];



		$c_no		= $_REQUEST['c_no'];



		$c_date		= $_REQUEST['c_date'];



		$c_id		= $_REQUEST['c_id'];



		$bi_id		= explode('##>>',$_REQUEST['b_id']);



		$b_id		= $bi_id[1];



		$t_amount	= $_REQUEST['t_amount'];



		$jv=next_journal_voucher_id();



		if(($c_id!=''))



		$receive_ledger=$c_id;



		else



		$receive_ledger=$b_id;







$ledgers = explode('::',$receive_ledger);







$search=array( ":"," ", "[", "]", $separater);



$ledger1=str_replace($search,'',$ledgers[0]);



$ledger2=str_replace($search,'',$ledgers[1]);







if(is_numeric($ledger1))



$receive_ledger = $ledger1;



else



$receive_ledger = $ledger2;



	//voucher date decode



	$j=0;



	for($i=0;$i<strlen($date);$i++)  



	{



		if(is_numeric($date[$i]))



		{



			$time[$j]=$time[$j].$date[$i];



		}



		else



		{



			$j++;



		}



	}



	$date=mktime(0,0,0,$time[1],$time[0],$time[2]);



	//////////////////////



	//check cdate decode



	$j=0;



	for($i=0;$i<strlen($c_date);$i++)



	{



	if(is_numeric($c_date[$i]))



	$ptime[$j]=$ptime[$j].$c_date[$i];



	else $j++;



	}



	$c_date=mktime(0,0,0,$ptime[1],$ptime[0],$ptime[2]);



	//////////////////////////



	$c = $_REQUEST['count'];



	for($i=1; $i <= $c; $i++)  //data insert loop



	{



		if($_REQUEST['deleted'.$i] == 'no')



		{











$ledger_id=$_REQUEST['ledger_id'.$i];















$ledgers = explode('::',$ledger_id);







$search=array( ":"," ", "[", "]", $separater);



$ledger1=str_replace($search,'',$ledgers[0]);



$ledger2=str_replace($search,'',$ledgers[1]);







if(is_numeric($ledger1))



$ledger_id = $ledger1;



else



$ledger_id = $ledger2;







	



			$detail_status = $_REQUEST['detail'.$i];		



			$cur_bal= $_REQUEST['cur_bal'.$i];



			$detail = $_REQUEST['detail'.$i];



			$amount = $_REQUEST['amount'.$i];



			$cc_code = $_REQUEST['cc_code'];



			



			//Journal Voucher Number Create







			



			$recept="INSERT INTO `receipt` (



									`receipt_no` ,



									`receipt_date` ,



									`proj_id` ,



									`narration` ,



									`ledger_id` ,



									`dr_amt` ,



									`cr_amt` ,



									`type` ,



									`cur_bal` ,



									`received_from`,



									`cheq_no`,



									`cheq_date`,



									`bank`,



									`manual_receipt_no`,



									`cc_code`,

									

									user_id



									)



VALUES ('$receipt_no', '$date', '$proj_id', '$detail', '$ledger_id', '0', '$amount', 'Credit', '$cur_bal','$r_from','$c_no','$c_date','$bank','$manual_receipt_no', '$cc_code' , '$user_id')";



	



			if($bank=='')



			{



				$dnarr=$detail;



			}



			else



			{



				$dnarr=$detail.':: Cheq# '.$c_no.':: Date= '.date("d.m.Y",$c_date);



			}



			$query_receipt = db_query($recept);



			$tr_id = db_insert_id();



			$journal="INSERT INTO `journal` (



								`proj_id` ,



								`jv_no` ,



								`jv_date` ,



								`ledger_id` ,



								`narration` ,



								`dr_amt` ,



								`cr_amt` ,



								`tr_from` ,



								`tr_no`,



								`tr_id`,



								`sub_ledger`,



								`cc_code`,



								user_id,



								group_for,`cheq_no`,`cheq_date`,



								relavent_cash_head



								)



VALUES ('$proj_id', '$jv', '$date', '$ledger_id', '$dnarr', '0', '$amount', 'Receipt', '$receipt_no','$tr_id','$sub_ledger','$cc_code','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."','$c_no','$c_date','$receive_ledger')";



	



				



				$query_journal = db_query($journal);	







		//echo $recept."<br>";



		//echo $journal."<br>";



		}



	}







	//invoice number create







		



	$detail="Received from ".$r_from;



	



	$recept="INSERT INTO `receipt` (



						`receipt_no` ,



						`receipt_date` ,



						`proj_id` ,



						`narration` ,



						`ledger_id` ,



						`dr_amt` ,



						`cr_amt` ,



						`type` ,



						`cur_bal` ,



						`received_from`,



						`cheq_no`,



						`cheq_date`,



						`bank`,



						`manual_receipt_no`,



						`cc_code`,

						

						user_id



						)



			VALUES ('$receipt_no', '$date', '$proj_id', '$detail', '$receive_ledger', '$t_amount','0', 'Debit', '$cur_bal','$r_from','$c_no','$c_date','$bank','$manual_receipt_no', '$cc_code', '$user_id')";



$query_receipt = db_query($recept);



$tr_id = db_insert_id();



	$journal="INSERT INTO `journal` (



						`proj_id` ,



						`jv_no` ,



						`jv_date` ,



						`ledger_id` ,



						`narration` ,



						`dr_amt` ,



						`cr_amt` ,



						`tr_from` ,



						`tr_no`,



						`tr_id`,



						`cc_code`



						,user_id



						,group_for,`cheq_no`,`cheq_date`,



						relavent_cash_head



						)



			VALUES ('$proj_id', '$jv', '$date', '$receive_ledger', '$detail', '$t_amount','0', 'Receipt', '$receipt_no','$tr_id', '$cc_code', '$user_id','".$_SESSION['user']['group']."','$c_no','$c_date','$receive_ledger')";



	



			



		



		$query_journal = db_query($journal);	



		if($msg=='')



		{



		$msg='Voucher Successfully Inserted';



		$type=1;



		}







}







//print code



if(!isset($_GET['v_d']))



{



	$receiptno=next_invoice('receipt_no','receipt');



	$v_d = time();



}



?>



<script type='text/javascript' src='../../common/js/jquery.ajaxQueue.js'></script>



<?php js_ledger_subledger_autocomplete_new('receipt',$proj_id,$voucher_type,$_SESSION['user']['group']); ?>



<script type="text/javascript">



function DoNav(theUrl)



{



	var URL = 'voucher_view_popup.php?'+theUrl;



	popUp(URL);



}



function Do_Nav()



{



	var URL = 'pop_invoice_paid.php';



	popUp(URL);



}



function popUp(URL) 



{



day = new Date();



id = day.getTime();



eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");



}



</script>



<?php



    $sqled1 = "select cc.id, cc.center_name FROM cost_center cc, cost_category c WHERE cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC";



    $led1=db_query($sqled1);



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



		$data1 = '[{name:"empty", id:""}]';



	}







    $led2=db_query("select  concat(ledger_name,'##>>',ledger_id), concat(ledger_name,'##>>',ledger_id) FROM accounts_ledger WHERE ledger_name not like '%cash%' and ledger_group_id='1086' and parent=0 order by ledger_id");



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







    var data1 = <?php echo $data1; ?>;



    $("#cc_code").autocomplete(data1, {



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



  });



</script>















<script type="text/javascript" src="../../common/js/check_balance.js"></script>



<script type="text/javascript" src="../../common/receipt_check.js"></script>











<style type="text/css">



<!--

.style3 {color: #FF0000}



-->



</style>







<script language="javascript" type="text/javascript">







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



	



	



function goto_tab()



{



	//alert('tab mamaun');



	document.getElementById('ledger_id').focus()



}



	  



	  



</script>




<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">



  



  <tr>



    <td><div >



							<table class="fontc" width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>



									<td>



									<div align="left">



    <form id="form1" name="form1" method="post" action="credit_note.php<?php if($_GET['action']=='edit') echo "?action=EDITING&v_no=".$_GET['v_no']."&v_type=".$_GET['v_type'];?>" onsubmit="return checking()">



      <table border="2" style="border:1px solid #C1DAD7; border-collapse:collapse; width:100%" >



        <tr>



          <td >



		  <table width="100%" border="0" cellspacing="0" cellpadding="0">



				  <tr>



				    <td valign="top" style="text-align:left;" ><table width="95%" border="0" cellspacing="2" cellpadding="2" style="margin-right:15px;">




                      <tr>



                      <td width="25%"><div align="right">Voucher No:</div></td>



                        <td width="26%"><? 



$receiptno=next_invoice('receipt_no','receipt');







if($v_d>10000)



$v_d=date("d-m-y",$v_d);











if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; } 



elseif($old_voucher_mode==1){$v_no_show='value="'.$receiptno.'" readonly'; } 



else $v_no_show='';



?>



<input name="receipt_no" type="text" id="receipt_no" size="15" <?=$v_no_show?> />









<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>
<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<? } ?> onclick="voucher_no(this.value)"/>
</td>



                        <td width="19%" align="right"><div align="right">Voucher Date:</div></td>



                        <td width="30%"><input name="date" type="text" id="date" value="<?php echo $_SESSION['old_v_date'];?>" size="10" <?php if($_GET['action']=='edit') echo "readonly='readonly'";?> tabindex="1"/>
                          <?php if($_GET['action']=='edit') echo "<font color='#FF0000'>EDITING</font>";?></td>
                      </tr>



                      



                      <tr>



                        <td><div align="right"><span class="style3">*</span>Received From:</div></td>



                        <td colspan="3"><input name="r_from" type="text" id="r_from" value="" class="input1"  tabindex="1"/></td>
                      </tr>



                      <tr>



                        <td><div align="right">Cash A/c Debit:</div></td>



                        <td colspan="3" style="text-align:left">



                        <div align="left"><select name="c_id" class="form-control" style="float:left" tabindex="2" >



                       



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



                        </select></div>                        </td>
                      </tr>



                      <tr>



                        <td><div align="right"><span class="style3">*</span>Bank A/c Debit:</div></td>



                        <td colspan="3"><input name="b_id" id="b_id" type="text" onchange="open_limit(this.value)" style=" float:left" tabindex="3" /></td>
                      </tr>



                      <tr>



                        <td><div align="right"><span>Cheque No:</span></div></td>



                        <td colspan="3"><input name="c_no" type="text" id="c_no" value="" size="20" maxlength="25" tabindex="4"/></td>
                      </tr>


                      <tr><td><div align="right"><span>Cheque</span> Date:</div></td>



                        <td colspan="3"><input name="c_date" type="text" id="c_date" value="" size="12" maxlength="15" tabindex="5"/></td>
                      </tr>



                      <tr>



                        <td align="left"><div align="right">of Bank:</div></td>



                        <td colspan="3" align="left"><input name="bank" type="text" id="bank" value="" class="input1"   tabindex="6"/></td>
                      </tr>



                      <tr>



                        <td align="right"><span class="style3">*</span>Cost Center :</td>



                        <td colspan="3"><input name="cc_code" type="text" id="cc_code"  tabindex="6" value="<?=find_a_field('warehouse','acc_code','warehouse_id='.$_SESSION['user']['depot']) ?>" required /></td>
                      </tr>



                    </table></td>



				    <td align="right" valign="top"><div class="box">



				      <table  class="tabledesign table-bordered" border="0" cellspacing="0" cellpadding="0">



                    <tr>



                      <th >Vou No </th>



                      <th >Amount</th>



                     <th >Narration</th>

<th>&nbsp;</th>

                      </tr>



					<? 



$sql2="select a.tr_no, a.dr_amt, a.narration,a.jv_date , a.jv_no



from  journal a where a.tr_from='Receipt' and a.group_for='".$_SESSION['user']['group']."' and SUBSTRING(a.tr_no,5,1)='0' and  a.dr_amt>0 order by a.tr_no desc limit 6";











$data2=db_query($sql2);



if(mysqli_num_rows($data2)>0){



while($dataa=mysqli_fetch_row($data2))



{$dataa[2]=substr($dataa[2],0,20).'...';



					?>



                    <tr>



                      <td><?=$dataa[0]?></td>



                      <td><?=$dataa[1]?></td>



                     <td><?=$dataa[2]?></td>



					  



                      <!--<td width="24" style="padding:1px;" onclick="DoNav('<?php echo 'v_type=receipt&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[4].'&view=Show&in=Journal_info' ?>');"><img src="../images/copy_hover.png" width="16" height="16" border="0"></td>-->



					  



                      <td  style="padding:1px;" ><a href="voucher_print_receipt.php?v_type=receipt&vo_no=<?php echo $dataa[4];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0"></a></td>



                    </tr>



<? }}?>



                  </table>



				    </div></td>



				    </tr>



				  



				</table>







		  </td>



        </tr>



        <tr>



          <td height="35">



		  <table width="100%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #C1DAD7;" cellpadding="2" cellspacing="2">



            <tr>



              <td width="33%" align="center">A/C Head </td>



              <td width="20%" align="center">Cur Bal </td>



              <td width="29%" align="center">Narration</td>



              <td width="12%" align="center">Amount</td>



              <td width="6%" rowspan="2" align="center">



                <input name="add" type="button" id="add" value="ADD" tabindex="12" class="btn1" onclick="checkhead('accounts_ledger');" onblur="goto_tab();"/>



<!--				                <input name="add" type="button" id="add" value="ADD" tabindex="12" class="btn1" onclick="checkhead('accounts_ledger');Do_Nav();" onblur="goto_tab();"/>-->				</td>



            </tr>



            <tr>



              <td align="center">			 



                <input type="text" class="input1" id="ledger_id" name="ledger_id" onBlur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" tabindex="8" style="width:438px;" />                </td>



              <td align="center"><span id="cur">



                <input name="cur_bal" type="text" id="cur_bal" maxlength="100" readonly="readonly"/>



              </span> </td>



              <td align="center">



              	<input name="detail" type="text" id="detail" class="input1" onfocus="getBalance('../../common/cur_bal.php', 'cur', document.getElementById('ledger_id').value);" tabindex="10" style="width:160px;"/>              </td>



              <td align="center"><input name="amount" type="text" id="amount" size="10" style="width:100px;" tabindex="11"/></td>



              </tr>



          </table></td>



        </tr>



        <tr>



          <td height="138" valign="top">



          	<span id="tbl"></span>          </td>



        </tr>



        <tr>



          <td height="20"><label></label>



            <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">



            <tr>



              <td width="19%" style="text-align:right;"><input name="receipt_varify" class="btn" type="button" id="receipt_varify" value="Receipt Verified" onclick="this.form.submit()" /> <input name="limmit" type="hidden" value="" />             </td>



              <td style="text-align:right;" valign="middle"><label></label>



                <span>Total Amount: </span></td>



              <td width="22%"><input name="t_amount" type="text" id="t_amount" size="15" readonly  style="width:130px;"/></td>



              </tr>



          </table></td>



        </tr>



      </table>



      <input name="count" id="count" type="hidden" value="" />



    </form>



  </div>									</td>



								  </tr>



		</table>







							</div></td>



  </tr>



</table>



<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>