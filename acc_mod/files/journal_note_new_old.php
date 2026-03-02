<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Journal Voucher';
$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
//echo $proj_id;
$separator=$_SESSION['separator'];

$chk_voucher_mode = db_query("SELECT voucher_mode,voucher_entry_mode FROM project_info LIMIT 1");
$old_voucher_mode = mysqli_result($chk_voucher_mode,0,'voucher_mode');
$voucher_type = mysqli_result($chk_voucher_mode,0,'voucher_entry_mode');
//step 1
if(!isset($_GET['v_d'])&&!isset($_GET['v_type']))
	{
		$voucher_mode = $_POST['voucher_mode'];
		if($voucher_mode==0&&$_POST['journal_info_no']>0)
			{
				$journal_info_no		= $_POST['journal_info_no'];
				$manual_journal_info_no = $_POST['journal_info_no'];
			}
			
		else
			{

				$journal_info_no=next_invoice('journal_info_no','journal_info');
				$manual_journal_info_no = '';
			}
		
		$v_d=time();
		if( $voucher_mode != $old_voucher_mode )
			db_query("UPDATE project_info SET voucher_mode=$voucher_mode WHERE 1");			
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
			
			//invoice number create
			$jv=next_journal_voucher_id();
		
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
									`manual_journal_info_no`
									)
									VALUES ('$journal_info_no', '$date', '$proj_id', '$detail', '$ledger_id', '$dr_amt', '$cr_amt', 'Debit', '$cur_bal', '$r_from', '$c_no', '$c_date', '', '$manual_journal_info_no')";
									
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
									`sub_ledger`,
									user_id,
									group_for
									)
									VALUES ('$proj_id', '$jv', '$date', '$ledger_id', '$detail', '$dr_amt', '$cr_amt', 'Journal_info', '$journal_info_no', '$sub_ledger','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."')";
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
									`manual_journal_info_no`
									)
									VALUES ('$journal_info_no', '$date', '$proj_id', '$detail', '$ledger_id', '$dr_amt', '$cr_amt', 'Credit', '$cur_bal','$r_from','$c_no','$c_date','','$manual_journal_info_no')";
				
				
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
									`sub_ledger`,
									`cc_code` 
									,user_id
									,group_for
									)
									VALUES ('$proj_id', '$jv', '$date', '$ledger_id', '$detail', '$dr_amt', '$cr_amt', 'Journal_info', '$journal_info_no', '$sub_ledger','$cc_code','".$_SESSION['user']['id']."','".$_SESSION['user']['group']."')";
			}
			if($_REQUEST['count'] > 0)
			{
				$query_receipt=db_query($recept);
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
?> 
<?php js_ledger_subledger_autocomplete_new('journal',$proj_id,$voucher_type,$_SESSION['user']['group']); ?>


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
div.ui-datepicker {font-size: 62.5%;}
-->
</style>

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
-->
</style>


<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div align="left">
      <form id="form1" name="form1" method="post" action="journal_note_new.php<?php if($_GET['action']=='edit') echo "?action=EDITING&v_no=".$_GET['v_no']."&v_type=".$_GET['v_type'];?>"><table border="2" style="border:1px solid #C1DAD7; border-collapse:collapse"  align="center">
          <tr>
            <td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><table width="100%"  align="center" cellpadding="2" cellspacing="2" >
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
                    <input name="journal_info_no" type="text" id="journal_info_no" size="10" <?=$v_no_show?> tabindex="1" style="width:90px"/>
                    <?php if($_GET['action']=='edit') echo "<font color='#FF0000'>EDITING</font>";?></td>
                  <td align="right"><span>Date: </span></td>
                  <td align="left"><input name="date" value="<?php echo $_SESSION['old_v_date'];?>" type="text" id="date" size="10" <?php if($_GET['action']=='edit') echo "readonly='readonly'";?> tabindex="2"/>
                    <?php if($_GET['action']=='edit') echo "<font color='#FF0000'>EDITING</font>";?>&nbsp;</td>
                </tr>
                
               <!-- <tr>
                  <td align="right"><span>Purpose: </span></td>
                  <td colspan="3" align="left"><input name="cc_code" type="text" id="cc_code" value="" class="input1" tabindex="3"/></td>
                  </tr>-->
                <tr>
                  <td align="right"><span>Transaction By:</span></td>
                  <td colspan="3" align="left"><input name="r_from" type="text" id="r_from" value="" class="input1" tabindex="4"/></td>
                  </tr>
                <tr>
                  <td align="right"><span>Cheque Date: </span></td>
                  <td colspan="3" align="left"><input name="c_date" type="text" id="c_date" value="" class="input1" tabindex="5"/></td>
                  </tr>
                <tr>
                  <td align="right"><span>Cheque No:</span></td>
                  <td colspan="3" align="left"><input name="c_no" type="text" id="c_no" value="" class="input1" tabindex="6"/></td>
                  </tr>
            </table></td>
				<td align="right" valign="top">
				<div class="box2">
				  <table  class="tabledesign" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th>Vr No </th>
                      <th>Amount</th>
                      <th colspan="3">Narration</th>
                      </tr>
					<? 
					
$sql2="select a.journal_info_no, sum(a.cr_amt), a.narration,a.journal_info_date 
from  journal_info a,journal b where a.journal_info_no=b.tr_no and b.tr_from='Journal_info' and b.group_for='".$_SESSION['user']['group']."' group by a.journal_info_no order by a.journal_info_no desc limit 5";
$data2=db_query($sql2);
if(mysqli_num_rows($data2)>0){
while($dataa=mysqli_fetch_row($data2))
{$dataa[2]=substr($dataa[2],0,20).'...';
					?>
                    <tr class="alt">
                      <td><?=$dataa[0]?></td>
                      <td><?=$dataa[1]?></td>
                      <td><?=$dataa[2]?></td>
					  
                      <td style="padding:1px;" onclick="DoNav('<?php echo 'v_type=journal_info&vdate='.date("Y-m-d",$dataa[3]).'&v_no='.$dataa[0].'&view=Show&in=Journal_info' ?>');"><img src="../images/copy_hover.png" width="16" height="16" border="0"></td>
					  
                      <td style="padding:1px;" ><a href="voucher_print.php?v_type=journal_info&vo_no=<?php echo $dataa[0];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0"></a></td>
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
          <tr>
            <td height="35"><table width="100%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #C1DAD7;" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="12%" align="center">Type</td>
                  <td width="33%" align="center">a/c Head </td>
                  <td width="16%" align="center">Cur Bal </td>
                  <td width="33%" align="center">Narration</td>
                  <td width="17%" align="center">Debit</td>
                  <td width="15%" align="center">Credit</td>
                  <td width="7%" rowspan="2" align="center"><!-- <input name="add" type="button" id="add" value="ADD" onclick="fock();check();addtotal();" tabindex="9"/>-->
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
                    <input name="cur_bal" type="text" id="cur_bal" size="13" maxlength="100" readonly="readonly"/>
                  </span> </td>
                  <td align="center"><input name="detail" type="text" id="detail" size="13" maxlength="100" tabindex="9" class="input1" /></td>
                  <td align="center"><input name="debit" type="text" id="debit" size="13" tabindex="10"/>
                  </td>
                  <td align="center"><input name="credit" type="text" id="credit" size="13" value="0" readonly="readonly" tabindex="11"/>
                  </td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="138" valign="top"><span id="tbl"></span> </td>
          </tr>
          <tr>
            <td> <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="19%" align="right"><label>
                    <input name="journal_info_varify" type="button" id="journal_info_varify" class="btn" value="Journal Verified" onclick="return checking();" />
                  </label></td>
                  <td width="21%" align="right">Total Debit Amt : </td>
                  <td width="18%" align="left"><label>
                    <input name="t_d_amt" type="text" id="t_d_amt" size="15" readonly="readonly"/>
                  </label></td>
                  <td width="20%" align="right">Total Credit Amt : </td>
                  <td width="22%"><input name="t_c_amt" type="text" id="t_c_amt" size="15" readonly="readonly"/></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <input name="count" id="count" type="hidden" value="" />
      </form>
    </div></td>
  </tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>