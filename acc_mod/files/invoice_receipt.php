<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Invoice Receipt';

$proj_id=$_SESSION['proj_id'];

$user_id=$_SESSION['user']['id'];
$active='jourvo';
//echo $proj_id;

$separator=$_SESSION['separator'];



$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' and group_for=".$_SESSION['user']['group']);



$chk_voucher_mode = db_query("SELECT voucher_mode,voucher_entry_mode FROM project_info LIMIT 1");

$old_voucher_mode = mysqli_result($chk_voucher_mode,0,'voucher_mode');

$voucher_type = mysqli_result($chk_voucher_mode,0,'voucher_entry_mode');

//step 1

if(!isset($_GET['v_d'])&&!isset($_GET['v_type']))

	{

		$voucher_mode = $_POST['voucher_mode'];

		if($voucher_mode==0&&$_POST['journal_info_no']>0)

			{

				$journal_info_no		= next_invoice('journal_info_no','journal_info');

				$manual_journal_info_no = next_invoice('journal_info_no','journal_info');

			}

			

		else

			{



				$journal_info_no=next_invoice('journal_info_no','journal_info');

				$manual_journal_info_no = '';

			}

		

		$v_d=time();

		if($voucher_mode != $old_voucher_mode) db_query("UPDATE project_info SET voucher_mode=$voucher_mode WHERE 1");			

	}

else

{



$journal_info_no=$_GET['v_no'];

$v_d=$_GET['v_d'];

$v_no=$_GET['v_no'];

$v_type=$_GET['v_type'];

}

///////////////////

if($_POST['count'])

{

	if($_GET['action']=='EDITING')

	{

		$vv=$_GET['v_type']."_no";

		$dell="delete from $v_type where $vv='$v_no'";

		

		if($v_type=='coutra')

		{

			$del1="delete from journal where tr_no='$v_no' and tr_from='contra'";

		}

		else

		{

			$del1="delete from journal where tr_no='$v_no' and tr_from='$v_type'";

		}

		$ddl=db_query($del1);

		$dd1=db_query($dell);

	}

				$jv=next_journal_voucher_id();

	$narration	= mysqli_real_escape_string($_REQUEST['narration']);

	$r_from		= mysqli_real_escape_string($_REQUEST['r_from']);

	$c_no		= mysqli_real_escape_string($_REQUEST['c_no']);

	$c_date		= mysqli_real_escape_string($_REQUEST['c_date']);

	if($c_no!='') $narration=$c_no."<br />".$narration;

	$date		= $_SESSION['old_v_date']=$_REQUEST["date"];

	//////////////////////

	//check cdate decode

	$j=0;

	for($i=0;$i<strlen($c_date);$i++)

	{

		if(is_numeric($c_date[$i]))

		{

			$ptime[$j]=$ptime[$j].$c_date[$i];

		}

		else 

		{

			$j++;

		}

	}

	$c_date=mktime(0,0,0,$ptime[1],$ptime[0],$ptime[2]);

	//////////////////////////

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

	

	$c = $_REQUEST['count'];

	for($i=1; $i <= $c; $i++)  //data insert loop

	{

		

		if($_REQUEST['deleted'.$i] == 'no')

		{

			$type = $_REQUEST['type'.$i];

			

		$ledger_id=$_REQUEST['ledger_id'.$i];

		if( preg_match("/:/",$ledger_id))

				{

$ledgers = explode('::',$ledger_id);



$search=array( ":"," ", "[", "]", $separater);

$ledger1=str_replace($search,'',$ledgers[0]);

$ledger2=str_replace($search,'',$ledgers[1]);



if(is_numeric($ledger1))

$ledger_id = $ledger1;

else

$ledger_id = $ledger2;

				}

		

			$cur_bal 	= $_REQUEST['cur_bal'.$i];

			$dr_amt 	= $_REQUEST['debit'.$i];

			$cr_amt 	= $_REQUEST['credit'.$i];

			$detail 	= $_REQUEST['detail'.$i];

			$cc_code 	= $_REQUEST['cc_code'];

			//invoice number create

		

			//echo $sub_ledger.'sub_ledger|$ledger_id'.$ledger_id;

				

			if($type=='Debit')

			{

				 $recept="INSERT INTO `journal_info` (

									`journal_info_no` ,

									`journal_info_date` ,

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

									`manual_journal_info_no`,cc_code

									)

									VALUES ('$journal_info_no', '$date', '$proj_id', '$detail', '$ledger_id', '$dr_amt', '$cr_amt', 'Debit', '$cur_bal', '$r_from', '$c_no', '$c_date', '', '$manual_journal_info_no','$cc_code')";

				$query_receipt=db_query($recept);

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

									`tr_no`,`tr_id`,

									`sub_ledger`,

									cc_code,

									user_id,`cheq_no`,`cheq_date`,

									group_for

									)

									VALUES ('$proj_id', '$jv', '$date', '$ledger_id', '$detail', '$dr_amt', '$cr_amt', 'Journal_info', '$journal_info_no','$tr_id','$sub_ledger','$cc_code', '".$_SESSION['user']['id']."','$c_no','$c_date','".$_SESSION['user']['group']."')";

			}

			else

			{

				$recept="INSERT INTO `journal_info` (

									`journal_info_no` ,

									`journal_info_date` ,

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

									`manual_journal_info_no`,cc_code

									)

									VALUES ('$journal_info_no', '$date', '$proj_id', '$detail', '$ledger_id', '$dr_amt', '$cr_amt', 'Credit', '$cur_bal','$r_from','$c_no','$c_date','','$manual_journal_info_no','$cc_code')";

				

				$query_receipt=db_query($recept);

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

									`tr_no`,`tr_id`,

									`sub_ledger`,

									`cc_code` 

									,user_id

									,`cheq_no`,`cheq_date`,group_for

									)

									VALUES ('$proj_id', '$jv', '$date', '$ledger_id', '$detail', '$dr_amt', '$cr_amt', 'Journal_info', '$journal_info_no', '$tr_id', '$sub_ledger','$cc_code','".$_SESSION['user']['id']."','$c_no','$c_date','".$_SESSION['user']['group']."')";

			}

			if($_REQUEST['count'] > 0)

			{

				

				$query_journal=db_query($journal);

				if($msg=='')

		{

		$msg='Voucher Successfully Inserted';

		$type=1;

		}

			}

		}

	}

}









if(!isset($_GET['v_d'])){

$journal_info_no=next_invoice('journal_info_no','journal_info');

$v_d=time();

}



 js_ledger_subledger_autocomplete_new('journal',$proj_id,$voucher_type,$_SESSION['user']['group']); ?>





<script type="text/javascript">



$(document).ready(function(){



    function formatItem(row) {

		//return row[0] + " " + row[1] + " ";

	}

	function formatResult(row) {return row[0].replace(/(<.+?>)/gi, '');}

  });

</script>





<script type="text/javascript" src="../common/js/check_balance.js"></script>



<script type="text/javascript" src="../common/journal_check.js"></script>

<style type="text/css">

<!--

.style1 {font-size: 18px}

.style2 {font-size: 10px}

-->

</style>



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





  });

</script>



<script language="javascript" type="text/javascript">



function voucher_no(val)

	{

		var voucher_mode = val;

		

		if( voucher_mode == 0 )

			{

				document.getElementById('journal_info_no').value	= "";

				document.getElementById('journal_info_no').readOnly	= false;

				document.getElementById('journal_info_no').select();

				document.getElementById('journal_info_no').focus();

			}

		else if( voucher_mode == 1 )

			{

				document.getElementById('journal_info_no').value	= "<?php echo $journal_info_no;?>";

				document.getElementById('journal_info_no').readOnly	= true;

			}

	}

	

function goto_tab()

{

	document.getElementById('type').focus();

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

</script>

<style type="text/css">

<!--

.style1 {font-size: 18px}

.style2 {font-size: 10px}
.style3 {color: #FF0000}

-->
.ac_results{

width:265px!important;
}
</style>






      <form id="form1" name="form1" method="post" action="journal_note_new.php<?php if($_GET['action']=='edit') echo "?action=EDITING&v_no=".$_GET['v_no']."&v_type=".$_GET['v_type'];?>"><table class="table table-bordered" align="center">

          <tr>

            <td>

			<table class="fontc table table-bordered " width="100%" border="0" cellspacing="0" cellpadding="0">

			  <tr>

				<td><table width="100%" class="table table-bordered"  align="center" cellpadding="2" cellspacing="2" >

                <tr>

                  <td align="right"><span>Voucher Mode:</span></td>

                  <td colspan="2" align="left" valign="middle"><input class="radio" type="radio" name="voucher_mode" id="voucher_mode_manual" value="0" <?php if($old_voucher_mode==0){ ?>checked="checked"<?php } ?> onclick="voucher_no(this.value)"/>

                      <span>Manual</span></td>

                  <td align="left" valign="middle"><input class="radio" type="radio" name="voucher_mode" id="voucher_mode_auto" value="1" <?php if($old_voucher_mode==1){ ?>checked="checked"<?php } ?> onclick="voucher_no(this.value)"/>

                      <span>Auto</span> </td>

                  </tr>

                <tr>

                  <td align="right"><span>Transactin No:</span></td>

                  <td align="left"><? 

$journal_info_no=next_invoice('journal_info_no','journal_info');



if($v_d>10000)

$v_d=date("d-m-y",$v_d);





if($_GET['action']=='edit') {$v_no_show='value="'.$v_no.'" readonly'; } 

elseif($old_voucher_mode==1){$v_no_show='value="'.$journal_info_no.'" readonly'; } 

else $v_no_show='';

?>

                    <input name="journal_info_no" type="text" id="journal_info_no" size="10" <?=$v_no_show?> tabindex="1" />

                    <?php if($_GET['action']=='edit') echo "<font color='#FF0000'>EDITING</font>";?></td>

                  <td align="right"><span>Date: </span></td>

                  <td align="left">

<input name="date" value="<?php echo $_SESSION['old_v_date'];?>" type="text" id="date" size="10" <?php if($_GET['action']=='edit') echo "readonly='readonly'";?> tabindex="2"/>

                    <?php if($_GET['action']=='edit') echo "<font color='#FF0000'>EDITING</font>";?>&nbsp;</td>

                </tr>

                

               <!-- <tr>

                  <td align="right"><span>Purpose: </span></td>

                  <td colspan="3" align="left"><input name="cc_code" type="text" id="cc_code" value="" class="input1" tabindex="3"/></td>

                  </tr>-->

                <tr>

                  <td align="right"><span><span class="style3">*</span>Transaction By:</span></td>

                  <td colspan="3" align="left"><input name="r_from" type="text" id="r_from" value="" class="input1" tabindex="4" required/></td>

                  </tr>

                <tr>

                  <td align="right"><span>Cheque Date: </span></td>

                  <td colspan="3" align="left"><input name="c_date" type="text" id="c_date" value="" class="input1" tabindex="5"/></td>

                  </tr>

                <tr>

                  <td align="right"><span>Cheque No:</span></td>

                  <td colspan="3" align="left"><input name="c_no" type="text" id="c_no" value="" class="input1" tabindex="6"/></td>

                </tr>

                <tr>

                  <td align="right"><span class="style3">*</span>Cost Center :</td>

                  <td colspan="3"><input name="cc_code" type="text" id="cc_code"  tabindex="9" value="<?=find_a_field('warehouse','acc_code','warehouse_id='.$_SESSION['user']['depot']) ?>" required /></td>

                </tr>

            </table></td>

				<td >

				

				  <table  class="tabledesign table table-bordered table-striped" cellspacing="0" cellpadding="0">

                    <tr>

                      <th>Vr No </th>

                      <th>Amount</th>

                      <th colspan="3"></th>

                      </tr>

					<? 

					

//$sql2="select a.journal_info_no, sum(a.cr_amt), a.narration,a.journal_info_date from  journal_info a,journal b where a.journal_info_no=b.tr_no and b.tr_from='Journal_info' and b.group_for='".$_SESSION['user']['group']."' group by a.journal_info_no order by a.journal_info_no desc limit 5";



$sql2="select a.tr_no, a.jv_no,a.jv_no,a.jv_date

from  journal a where a.tr_from='journal_info' and a.group_for='".$_SESSION['user']['group']."' group by a.tr_no  order by a.tr_no desc limit 8";



$data2=db_query($sql2);

if(mysqli_num_rows($data2)>0){

while($dataa=mysqli_fetch_row($data2))

{

					?>

                    <tr class="alt">

                      <td><?=$dataa[0]?></td>

                      <td><?=find_a_field('journal_info','sum(dr_amt)','journal_info_no='.$dataa[0])?></td>

                   <!--   <td>&nbsp;</td>

					  

                      <td style="padding:1px;" onclick="DoNav('<?php echo 'v_type=journal_info&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[2].'&view=Show&in=Journal_info' ?>');"><img src="../images/copy_hover.png" width="16" height="16" border="0"></td>
-->
					  

                      <td style="padding:1px;" ><a href="voucher_print.php?v_type=journal_info&vo_no=<?php echo $dataa[2];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0"></a></td>

                    </tr>

<? }}?>

                  </table>

				</div>

				</td>

			  </tr>

			</table>



			</td>

          </tr>

          <br />
		  <br />

          <tr>

            <td><table class="fontc table table-bordered" width="100%" align="center">

                <tr>

                  <td  align="center">Type</td>

                  <td  align="center">A/C Head </td>

                  <td  align="center">Cur Bal </td>

                  <td  align="center">Narration</td>

                  <td  align="center">Debit</td>

                  <td  align="center">Credit</td>

                  <td  rowspan="2" align="center" style="vertical-align:bottom"><!-- <input name="add" type="button" id="add" value="ADD" onclick="fock();check();addtotal();" tabindex="9"/>-->

                      <input class="btn1" name="add" type="button" id="add" value="ADD" tabindex="12" onclick="checkhead('accounts_ledger');" onblur="goto_tab();"/>

                  </td>

                </tr>

                <tr>

                  <td align="center"><select name="type" id="type" onchange="head_check(this.value)" tabindex="7">

                      <option value="Debit">Debit</option>

                      <option value="Credit">Credit</option>

                    </select>

                  </td>

                  <td align="center">

                      <input type="text" id="ledger_id" name="ledger_id" class="input1" onblur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" tabindex="8" />

                  </td>

                  <td align="center"><span id="cur">

                    <input name="cur_bal" type="text" id="cur_bal"  maxlength="100" readonly="readonly"/>

                  </span> </td>

                  <td align="center"><input name="detail" type="text" id="detail"  maxlength="100" tabindex="9" class="input1" /></td>

                  <td align="center"><input name="debit" type="text" id="debit"  tabindex="10"/>

                  </td>

                  <td align="center"><input name="credit" type="text" id="credit"  value="0" readonly="readonly" tabindex="11"/>

                  </td>

                </tr>

            </table></td>

          </tr>

          <tr>

            <td height="138" valign="top"><span id="tbl"></span> </td>

          </tr>

          <tr>

            <td> <table class="fontc" width="100%" border="0" align="right" cellpadding="2" cellspacing="2">

                <tr>

                  <td width="19%" align="right"><label>

                  <input name="journal_info_varify" type="button" id="journal_info_varify" class="btn" value="Journal Verified" onclick="return checking();" />

                  </label></td>

                  <td width="10%" align="right">Diff:</td>

                  <td width="21%" align="left"><input name="t_diff" type="text" id="t_diff"  style="width:80px;" readonly="readonly"/></td>

                  <td width="21%" align="right">Total Dr: </td>

                  <td width="18%" align="left"><label>

                  <input name="t_d_amt" type="text" id="t_d_amt"  style="width:100px;" readonly="readonly"/>

                  </label></td>

                  <td width="20%" align="right">Total Cr: </td>

                  <td width="22%">

				  <input name="t_c_amt" type="text" id="t_c_amt"  style="width:100px;" readonly="readonly"/>				  </td>

                </tr>

            </table></td>

          </tr>

        </table>

        <input name="count" id="count" type="hidden" value="" />

      </form>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>