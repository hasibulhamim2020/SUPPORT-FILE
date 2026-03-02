<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$proj_id	= $_SESSION['proj_id'];

$vdate		= $_REQUEST['vdate'];
$jv_no =  $_REQUEST['v_no'];
$v_type 		= $_REQUEST['v_type'];

$v_type = strtolower($v_type);
$no 		= $vtype."_no";
$v_no = find_a_field('journal','tr_no','jv_no='.$_REQUEST['v_no']);

	$cheq_no = $_POST["cheq_no"];
	$cheq_date = strtotime($_POST["cheq_date"]);
	$vdate = strtotime($_POST["vdate"]);

if($v_type=='receipt'){$voucher_name='RECEIPT VOUCHER';$vtype='receipt';$tr_from='receipt';}
elseif($v_type=='payment'){$voucher_name='PAYMENT VOUCHER';$vtype='payment';$tr_from='payment';}
elseif($v_type=='journal'){$voucher_name='JOURNAL VOUCHER';$vtype='journal';$tr_from='journal_info';}
elseif($v_type=='contra'){$voucher_name='CONTRA VOUCHER';$vtype='contra';$tr_from='contra';}
else{$v_type=='coutra';$voucher_name='CONTRA VOUCHER';$vtype='coutra';$tr_from='contra';}

if(isset($_REQUEST['delete']))
{	
	$sqlDel2 = "DELETE FROM secondary_journal WHERE tr_no='$v_no' AND tr_from='$tr_from'";

	if(db_query($sqlDel2)){}
	if($_GET['in']=='Journal_info')	echo "<script>self.opener.location = 'journal_note_new.php'; self.blur(); </script>";
	elseif($_GET['in']=='Contra')	echo "<script>self.opener.location = 'coutra_note_new.php'; self.blur(); </script>";
	elseif($_GET['in']=='Credit')	echo "<script>self.opener.location = 'credit_note.php'; self.blur(); </script>";
	elseif($_GET['in']=='Debit')	echo "<script>self.opener.location = 'debit_note.php'; self.blur(); </script>";
	else	echo "<script>self.opener.location = 'voucher_view.php'; self.blur(); </script>";
	
	echo "<script>window.close(); </script>";
}
if($v_type=='coutra') $v_type='Contra'; else $v_type=$v_type;



if(isset($_POST['narr']))
{
	$count = $_POST["count"];


$sql2="select a.id,a.tr_id from secondary_journal a where  a.jv_no='$jv_no' and 1";
$data2=db_query($sql2);
while($datas=mysqli_fetch_row($data2)){ 
			  
$ledger_old=$_POST['ledger_'.$datas[0]];

$ledger_new = explode('#>',$ledger_old);
$ledger = $ledger_new[1];

$c_no=$_POST['c_no'];
$c_date=$_POST['c_date'];

$narration=$_POST['narration_'.$datas[0]];
$dr_amt=$_POST['dr_amt_'.$datas[0]];
$cr_amt=$_POST['cr_amt_'.$datas[0]];


$sqldate2 = "UPDATE secondary_journal SET jv_date='$vdate',cheq_no='$cheq_no',cheq_date='$cheq_date',ledger_id='$ledger',narration='$narration',dr_amt='$dr_amt',cr_amt='$cr_amt' WHERE id = ".$datas[0];
if(isset($sqldate1))@db_query($sqldate1);
@db_query($sqldate2);
	}
}

if(isset($_POST['confirmm']))
{
	
 $sql2="select * from secondary_journal a where  a.jv_no='".$jv_no."' and a.tr_from='".$v_type."'";
$data2=db_query($sql2);
while($datab=mysqli_fetch_object($data2)){ 


add_to_journal('reveri', $datab->jv_no, $datab->jv_date, $datab->ledger_id, $datab->narration, $datab->dr_amt, $datab->cr_amt, $datab->tr_from, $datab->tr_no,$datab->sub_ledger='',$datab->tr_id='',$datab->cc_code='');
  $up = 'update secondary_journal set checked="YES",checked_by="'.$_SESSION['user']['id'].'",checked_at="'.date('Y-m-d H:i:s').'" where jv_no="'.$datab->jv_no.'" and tr_from="'.$datab->tr_from.'"';
   $qr = db_query($up);
	}
	?>
	<script>
	  function closeWin() {
            myWindow.close(); 
     }
	</script>
	<?
	
	
}


if(isset($_REQUEST['view']) && $_REQUEST['view']=='Show')
{


	$sql1="select narration,cheq_no,cheq_date,' ',jv_date from secondary_journal where jv_no='$jv_no' limit 1";
	$data1=mysqli_fetch_row(db_query($sql1));
	$sql1."<br>";
?>
<link href="../css/style.css" type="text/css" rel="stylesheet"/>
<link href="../css/menu.css" type="text/css" rel="stylesheet"/>
<link href="../css/table.css" type="text/css" rel="stylesheet"/>
<link href="../css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="../js/paging.js"></script>
<script type="text/javascript" src="../js/ddaccordion.js"></script>
<script type="text/javascript" src="../js/js.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$(function() {
		$("#vdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
	});
	$(function() {
		$("#cheq_date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
	});
});
</script>

<SCRIPT LANGUAGE="JavaScript">
<!--// Hide script from non-javascript browsers.
// Load Page Into Parent Window
// Version 1.0
// Last Updated: May 18, 2000
// Code maintained at: http://www.moock.org/webdesign/javascript/
// Copy permission granted any use provided this notice is unaltered.
// Written by Colin Moock.


function loadinparent(url, closeSelf){
	self.opener.location = url;
	if(closeSelf) self.close();
	}

//-->
</SCRIPT>

<style>
body{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;}

.btn_p{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
width:130px;
background-color:0baabf;
border:2px solid #9cd7df;
border-collapse:collapse;
text-align:center;
color:#FFFFFF;
padding:3px;
text-decoration:none;
}
.btn_p a{
background-color:0baabf;
color:#FFFFFF;
text-decoration:none;
padding:3px;
}
.btn_p a:hover{
background-color:0baabf;
color:#000000;
text-decoration:none;
padding:3px;
}
.btn_p1{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
width:160px;
background-color:0baabf;
border:2px solid #9cd7df;
border-collapse:collapse;
text-align:center;
color:#FFFFFF;
padding:2px;
text-decoration:none;
}
.btn_p1 a{
background-color:0baabf;
color:#FFFFFF;
text-decoration:none;
padding:3px;
}
.btn_p1 a:hover{
background-color:0baabf;
color:#000000;
text-decoration:none;
padding:3px;
}

.report_font{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
background-color:#fefee6;
}
tr {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	color: #4f6b72;
	padding:3px;
}
td{
padding:3px;}

tr.spec {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	background: #e9f4f8;
	color: #4f6b72;
}

tr.spec:hover{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	background: #F4F5F6;
	color: #4f6b72;
}
</style>
	  <form action="" method="post" name="form2">
      <table width="99%" border="1" align="center" style="border-collapse:collapse;" bordercolor="#c1dad7" id="vbig">
        <tr>
          <td>
		  <table width="100%" border="0" align="center" bordercolor="#0099FF" bgcolor="#D9EFFF" cellspacing="0">
              <tr>
                <td width="12%" height="20" align="right">Received From:</td>
                <td width="22%" align="left"><?php echo $data1[1];?>&nbsp;</td>
                <td width="9%" align="right" valign="top">Purpose:</td>
                <td width="28%" align="left" valign="top"><?php echo $data1[0];?>&nbsp;</td>
                <td align="right">Voucher Date:</td>
                <td align="left"><input name="vdate" id="vdate" type="text" value="<?php echo date("d-m-Y",$data1[4]);?>" /></td>
              </tr>
              <tr>
                <td height="20" align="right">Chaque No: </td>
                <td height="20" align="left"><input name="cheq_no" id="cheq_no" type="text" value="<?php echo $data1[1];?>" /></td>
                <td width="9%" align="right" valign="top">Chaque Date: </td>
                <td width="28%" align="left" valign="top"><input name="cheq_date" id="cheq_date" type="text" value="<?=($data1[2]>943898400)?(date("d-m-Y",$data1[2])):'';?>" /></td>
                <td width="12%" align="right">Voucher  No:</td>
                <td width="17%" align="left"><?php echo $v_no;?>&nbsp;</td>
              </tr>
          </table>

		  </td>
        </tr>
        <tr>
          <td valign="top"><table width='100%' border="1" bordercolor="#c1dad7" bgcolor="#FFFFFF" style="border-collapse:collapse">
              <tr align="center">
                <td>S/L</td>
                <td>Type</td>
                <td>A/C Ledger</td>
                <td>Narration</td>
                <td>Debit</td>
                <td>Credit</td>
              </tr>
<?php
$pi=0;
$d_total=0;
$c_total=0;
$sql2="select a.dr_amt,a.cr_amt,b.ledger_name,b.ledger_id,a.narration,a.id from accounts_ledger b, secondary_journal a where a.ledger_id=b.ledger_id and a.jv_no='$jv_no' and 1";
$data2=db_query($sql2);

while($info=mysqli_fetch_row($data2)){ $pi++;

auto_complete_from_db('accounts_ledger','concat(ledger_name,"#>",ledger_id)','concat(ledger_name,"#>",ledger_id)','1 and  group_for = "'.$_SESSION['user']['group'].'" order by ledger_name','ledger_'.$info[5]);

			  
			  
			  if($info[0]==0) $type='Credit';
			  else $type='Debit';
			  $d_total=$d_total+$info[0];
			  $c_total=$c_total+$info[1];
			  ?>
              <tr align="center" <? if(++$x%2!=0) echo 'class="spec"';?>>
                <td><?php echo $pi;?>&nbsp;</td>
                <td><?php echo $type;?>&nbsp;</td>
                <td><div align="left">
				<input type="text" name="ledger_<?=$info[5]?>" id="ledger_<?=$info[5]?>" style="width:200px;" value="<?=$info[2].'#>'.$info[3];?>" />
                </div></td>
                <td>
          <input type="text" name="narration_<?=$info[5];?>" id="narration_<?=$info[5];?>" style="width:300px;" value="<?=$info[4];?>" />
          <input type="hidden" name="l_<?=$pi;?>" id="l_<?=$pi;?>" value="<?=$info[3];?>" />          </td>
                <td><div align="right">
                  <label>
                  <input name="dr_amt_<?=$info[5];?>" type="text" id="dr_amt_<?=$info[5];?>" value="<?=$info[0]?>" style="width:80px;" />
                  </label></div></td>
                <td><div align="right">
                  <input name="cr_amt_<?=$info[5];?>" type="text" id="cr_amt_<?=$info[5];?>" value="<?=$info[1]?>" style="width:80px;" />
                  </div></td>
              </tr>
			   <?php }?>
              <tr align="center">
                <td colspan="4" align="right">Total Amount :</td>
                <td><div align="right"><?php echo $d_total;?>&nbsp;</div></td>
                <td><div align="right"><?php echo $c_total;?>&nbsp;</div></td>
              </tr>
          </table></td>
        </tr>
      </table>
      
      <br />
<?php
//page select
if($vtype=='receipt'||$vtype=='Receipt') $page="credit_note.php?v_no=$v_no&v_type=$vtype&v_d=$vdate&action=edit";
if($vtype=='payment'||$vtype=='Payment') $page="debit_note.php?v_no=$v_no&v_type=$vtype&v_d=$vdate&action=edit";
if($vtype=='coutra'||$vtype=='Coutra') $page="coutra_note_new.php?v_no=$v_no&v_type=$vtype&v_d=$vdate&action=edit";
if($vtype=='journal_info'||$vtype=='Journal_info') $page="journal_note_new.php?v_no=$v_no&v_type=$vtype&v_d=$vdate&action=edit";
//end

?>
<div align="center" style="margin-top:10px;">
  <table border="0" cellspacing="10" cellpadding="0" align="center" style="width:400px;">
    <tr>
	
      <td><div class="btn_p">
          <div align="center">
		  <?
		    if($vtype=='payment' || $vtype=='Payment'){
		  ?>
		  <a href="letter_awn.php?v_type=<?php echo $vtype;?>&amp;vo_no=<?php echo $jv_no;?>" target="_blank">Print This Invoice</a>
		  <? }else{ ?>
		  <a href="voucher_print_receipt.php?v_type=<?php echo $vtype;?>&amp;vo_no=<?php echo $jv_no;?>" target="_blank">Print This Invoice</a>
		 <? }?>
		  
		  </div>
      </div></td>
    </tr>
  </table>
</div>
<?php
}
?>
<script type="application/javascript">
function loadinparent(url)
{
	self.opener.location = url;
	self.blur(); 
}
</script>
<input name="count" id="count" type="hidden" value="<?=$pi;?>" />
</form>