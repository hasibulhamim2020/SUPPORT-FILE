<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Edit Voucher';
$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
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
			$cc_code 	= $_REQUEST['cc_code'];
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
									`manual_journal_info_no`,cc_code
									)
									VALUES ('$journal_info_no', '$date', '$proj_id', '$detail', '$ledger_id', '$dr_amt', '$cr_amt', 'Debit', '$cur_bal', '$r_from', '$c_no', '$c_date', '', '$manual_journal_info_no','$cc_code')";
									
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
									cc_code,
									user_id,
									group_for
									)
									VALUES ('$proj_id', '$jv', '$date', '$ledger_id', '$detail', '$dr_amt', '$cr_amt', 'Journal_info', '$journal_info_no','$sub_ledger','$cc_code', '".$_SESSION['user']['id']."','".$_SESSION['user']['group']."')";
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
div.ui-datepicker {font-size: 62.5%;}
-->
</style>

<?php
    $led1=db_query("select id, center_name FROM cost_center WHERE 1 ORDER BY center_name ASC");
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
                  <td align="right"><span>Voucher From:</span></td>
                  <td align="left" valign="middle"><input name="r_from2" type="text" id="r_from2" value="" class="input1" tabindex="4"/></td>
                  <td rowspan="7" align="left" valign="middle"><div align="center">
                    <input class="btn1" name="add3" type="button" id="add3" value="EDIT INFO" tabindex="12" onclick="checkhead('accounts_ledger');" onblur="goto_tab();" style="width:200px;"/>
                  </div></td>
                </tr>
                <tr>
                  <td align="right"><span>Transaction No:</span></td>
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
                  </tr>
                
               <!-- <tr>
                  <td align="right"><span>Purpose: </span></td>
                  <td colspan="3" align="left"><input name="cc_code" type="text" id="cc_code" value="" class="input1" tabindex="3"/></td>
                  </tr>-->
                <tr>
                  <td align="right">Transaction Date: </td>
                  <td align="left"><input name="date" value="<?php echo $_SESSION['old_v_date'];?>" type="text" id="date" size="10" <?php if($_GET['action']=='edit') echo "readonly='readonly'";?> tabindex="2"/>
                    <?php if($_GET['action']=='edit') echo "<font color='#FF0000'>EDITING</font>";?>
                    &nbsp;</td>
                  </tr>
                <tr>
                  <td align="right"><span>Transaction To:</span></td>
                  <td align="left"><input name="r_from" type="text" id="r_from" value="" class="input1" tabindex="4"/></td>
                  </tr>
                <tr>
                  <td align="right"><span>Cheque Date: </span></td>
                  <td align="left"><input name="c_date" type="text" id="c_date" value="" class="input1" tabindex="5"/></td>
                  </tr>
                <tr>
                  <td align="right"><span>Cheque No:</span></td>
                  <td align="left"><input name="c_no" type="text" id="c_no" value="" class="input1" tabindex="6"/></td>
                  </tr>
                <tr>
                  <td align="right">Cost Center :</td>
                  <td><input name="cc_code" type="text" id="cc_code"  tabindex="9" /></td>
                  </tr>
            </table></td>
				<td align="right" valign="top">&nbsp;</td>
			  </tr>
			</table>

			</td>
          </tr>
          <br />
          <tr>
            <td height="35"><table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#0099CC"  style="border-collapse:collapse; border:1px solid #C1DAD7;">
                <tr>
                  <td width="12%" align="center" bgcolor="#FFCCCC">Type</td>
                  <td width="33%" align="center" bgcolor="#FFCCCC">a/c Head </td>
                  <td width="16%" align="center" bgcolor="#FFCCCC">Cur Bal </td>
                  <td width="33%" align="center" bgcolor="#FFCCCC">Narration</td>
                  <td width="17%" align="center" bgcolor="#FFCCCC">Debit</td>
                  <td width="15%" align="center" bgcolor="#FFCCCC">Credit</td>
                  <td width="7%" rowspan="2" align="center" bgcolor="#FFCCCC"><!-- <input name="add" type="button" id="add" value="ADD" onclick="fock();check();addtotal();" tabindex="9"/>-->
                      <input class="btn1" name="add" type="button" id="add" value="ADD" tabindex="12" onclick="checkhead('accounts_ledger');" onblur="goto_tab();"/>
                  </td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFCCCC"><select name="type" id="type" onchange="head_check(this.value)" tabindex="7">
                      <option value="Debit">Debit</option>
                      <option value="Credit">Credit</option>
                    </select>
                  </td>
                  <td align="center" bgcolor="#FFCCCC">
                      <input type="text" id="ledger_id" name="ledger_id" class="input1" onblur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" tabindex="8" />
                  </td>
                  <td align="center" bgcolor="#FFCCCC"><span id="cur">
                    <input name="cur_bal" type="text" id="cur_bal" size="15" maxlength="100" readonly="readonly"/>
                  </span> </td>
                  <td align="center" bgcolor="#FFCCCC"><input name="detail" type="text" id="detail" size="13" maxlength="100" tabindex="9" class="input1" /></td>
                  <td align="center" bgcolor="#FFCCCC"><input name="debit" type="text" id="debit" size="13" tabindex="10"/>
                  </td>
                  <td align="center" bgcolor="#FFCCCC"><input name="credit" type="text" id="credit" size="13" value="0" readonly="readonly" tabindex="11"/>
                  </td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="138" valign="top"><span id="tbl"></span>
              <table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#0099CC"  style="border-collapse:collapse; border:1px solid #C1DAD7;">
                <tr>
                  <td width="12%" align="center" bgcolor="#6699FF"><strong>Ledger Code </strong></td>
                  <td width="33%" align="center" bgcolor="#6699FF"><strong>Ledger Name </strong></td>
                  <td width="33%" align="center" bgcolor="#6699FF"><strong>Narration</strong></td>
                  <td width="17%" align="center" bgcolor="#6699FF"><strong>Debit</strong></td>
                  <td width="15%" align="center" bgcolor="#6699FF"><strong>Credit</strong></td>
                  <td width="7%" align="center" bgcolor="#6699FF"><!-- <input name="add" type="button" id="add" value="ADD" onclick="fock();check();addtotal();" tabindex="9"/>--></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#6699FF"><input name="cur_bal2" type="text" id="cur_bal2" style="width:120px;"/></td>
                  <td align="center" bgcolor="#6699FF"><input type="text" id="ledger_id2" name="ledger_id2" class="input1" onblur = "getBalance('../../common/cur_bal.php', 'cur', this.value);" tabindex="8" />                  </td>
                  <td align="center" bgcolor="#6699FF"><input name="detail2" type="text" id="detail2"  style="width:200px;" class="input1" /></td>
                  <td align="center" bgcolor="#6699FF"><input name="debit2" type="text" id="debit2" size="13" tabindex="10"/>                  </td>
                  <td align="center" bgcolor="#6699FF"><input name="credit2" type="text" id="credit2" size="13" value="0" readonly="readonly" tabindex="11"/></td>
                  <td width="7%" align="center" bgcolor="#6699FF"><input class="btn1" name="add2" type="button" id="add2" value="EDIT" tabindex="12" onclick="checkhead('accounts_ledger');" onblur="goto_tab();"/></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td> <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="19%" align="right"><label></label></td>
                  <td width="21%" align="right">Total Debit Amt : </td>
                  <td width="18%" align="left"><label>
                    <input name="t_d_amt" type="text" id="t_d_amt" size="30" readonly="readonly" style="width:100px;"/>
                  </label></td>
                  <td width="20%" align="right">Total Credit Amt : </td>
                  <td width="22%"><input name="t_c_amt" type="text" id="t_c_amt" size="30" readonly="readonly" style="width:100px;"/></td>
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