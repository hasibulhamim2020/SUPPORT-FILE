<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../common/class.numbertoword.php');
$proj_id=$_SESSION['proj_id'];
$_REQUEST['v_type']=strtolower($_REQUEST['v_type']);
$vtype=$_REQUEST['v_type'];
 $jv_no=$_REQUEST['vo_no'];
$no=$vtype."_no";
$vdate=$vtype."_date";

function sec_journal_journal_omar($sec_jv_no,$jv_no,$tr_froms)
{

 $sql = 'select * from secondary_journal where jv_no = "'.$sec_jv_no.'" and tr_from = "'.$tr_froms.'"';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{	if($jv_no==0)  $jv_no = $data->jv_no;
	 $journal="INSERT INTO `journal` (
	`proj_id` ,
	`jv_no` ,
	`jv_date` ,
	`ledger_id` ,
	`narration` ,
	`dr_amt` ,
	`cr_amt` ,
	`tr_from` ,
	`tr_no` ,
	`tr_id` ,
	`sub_ledger`,
	user_id,
	entry_at,
	group_for,
	cc_code,
relavent_cash_head,
type,
cheq_no,
cheq_date,
ca_checked,
ca_checked_at,
fc_checked,
fc_checked_at,
om_checked,
om_checked_at,
ceo_checked,
ceo_checked_at,
employee_id,
vendor_id,
purpose,
currency_type

	)VALUES 
('$data->proj_id', '$jv_no', '$data->jv_date', '$data->ledger_id', '$data->narration', '$data->dr_amt', '$data->cr_amt', '$data->tr_from', '$data->tr_no', '$data->tr_id','$data->sub_ledger','".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."', '$data->group_for', '".$data->cc_code."',
'".$data->relavent_cash_head."',
'".$data->type."',
'".$data->cheq_no."',
'".$data->cheq_date."',
'".$data->ca_checked."',
'".$data->ca_checked_at."',
'".$data->fc_checked."',
'".$data->fc_checked_at."',
'".$data->om_checked."',
'".$data->om_checked_at."',
'".$data->ceo_checked."',
'".$data->ceo_checked_at."',
'".$data->employee_id."',
'".$data->vendor_id."',
'".$data->purpose."',
'".$data->currency_type."')";
	$query_journal=db_query($journal);
}
}






$all = find_all_field('secondary_journal','','jv_no="'.$jv_no.'"');
$cr_amt = find_a_field('secondary_journal','cr_amt','jv_no="'.$jv_no.'" and cr_amt>0');

if(prevent_multi_submit()){
if(isset($_POST['approve'])){
  $usql = "update secondary_journal set ceo_checked = '".$_SESSION['user']['id']."', ceo_checked_at = '".date('Y-m-d H:i:s')."', checked_at='".date('Y-m-d H:i:s')."', checked_by='".$_SESSION['user']['id']."', 
 checked='YES'  where jv_no = '".$all->jv_no."' ";
db_query($usql);

sec_journal_journal_omar($jv_no,$jv,'Payment');

	}
	
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../../../assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>
<style>
#approve{
	margin-top:2%;
	background-color:#a52a2a;
	color:white;
	border: 1px solid #e59a9a;
	border-radius: 10px;
	width:100%;
	height:30px;
	}
#approve:hover {
  box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}
#last_table{

border: 1p solid black !important;	
width:820px;
margin: 0 auto;
	}
</style>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script></head>
<body >
<table width="820" style="border:2px solid black;" cellspacing="0" cellpadding="0" align="center">
  <tr>
     <td><? $path='../../../logo/'.$all->group_for.'.png';
			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?></td>
	  <td><span style="font-size:30px; font-weight:bold;">AWN</span>&nbsp;&nbsp;<span style="font-size:12px;">Finance</span><br /><span>Jeddah-Makkah-Madinah</span></td>
	 </tr>
	 <tr>
    <td colspan="2">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:5px;">
	  
	  <tr style="background-color:brown; font-weight:bold; color:#FFFFFF; font-size:18px; height:30px;">
	    <td><div align="left">Payment Request</div></td>
		<td><div align="right"><?=$all->tr_no?></div></td>
	    </tr><br />
		
	   <tr style="font-size:15px; height:30px" >  
	    <td colspan="2"><strong> Date : <?php echo date('d-m-Y',strtotime($all->jv_date));?></strong></td>
	    </tr>
		
		 <tr style="font-size:15px; height:30px;" >  
	    <td colspan="2"><strong> Subject : <?=$all->received_from?></strong></td>
	    </tr>
		
	  
	  
	  <tr style="font-size:15px;"  height="30" >
	    <td  height="30"><strong>Amount :</strong> <span style="border:1px solid #333333; padding:5px;"><?=find_a_field('currency_type','short_name','id="'.$all->currency_type.'"')?>
		 <?=$cr_amt?></span> &nbsp;&nbsp; <span style="background: #FF99FF; padding: 6px 20px;"> <?=find_a_field('currency_type','short_name','id="'.$all->currency_type.'"')?> 
		
		
		<?
		
		$scs =  $cr_amt;
			 $credit_amt = explode('.',$scs);
	 if($credit_amt[0]>0){
	 
	 echo convertNumberToWordsForIndia($credit_amt[0]);}
	 if($credit_amt[1]>0){
	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}
	 echo ' Only.';
		?>
		
		
		
		
		</span></td>
	    </tr>
	  <tr style="font-size:15px; height:30px;">
	  <? if($all->vendor_id>0) {?>
	    <td colspan="2"><strong>Beneficiary :  <?=find_a_field('vendor','vendor_company','vendor_id="'.$all->vendor_id.'"')?></strong></td>
	<? }?>
	
	 <? if($all->vendor_id<1) {?>
	    <td colspan="2"><strong>Beneficiary :  <?=find_a_field('accounts_ledger','ledger_name','ledger_id="'.$all->ledger_id.'"')?></strong></td>
	<? }?>
	  </tr>
	  
	  <tr style="font-size:15px; height:30px;">
	  <? if ($all->type=="BANK") {?>
	    <td style="float:left;"><strong> Method : Wire Transfer</strong></td>
		<? }?>
		<? if ($all->type=="CASH") {?>
	    <td style="float:left;"><strong> Method : <?=$all->type?></strong></td>
		<? }?>
		<? if ($all->type=="CHEQUE") {?>
	    <td style="float:left;"><strong> Method : <?=$all->type?></strong></td>
		<? }?>
		 <td style="float:right;"><strong> Bank Name : </strong> <?=find_a_field('accounts_ledger','ledger_name','ledger_id="'.$all->relavent_cash_head.'"');?></td>
	  </tr>
    </table>    </td>
  </tr>
  <tr>
    
	<td colspan="2">	</td>
  </tr>
  
  <tr>

    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" class="tabledesign_text">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="tabledesign_text"></td>
        </tr>
      <tr>
        <td class="tabledesign_text">&nbsp;</td>
        <td class="tabledesign_text">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
 
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign">
      <tr style="background-color:brown; color:#FFFFFF">
        <td align="center"><strong>Discription</strong></td>
        <td><strong>Amount</strong></td>
      </tr>
      
	  <?
           $ssql = 'select * from secondary_journal where dr_amt>0 and jv_no="'.$jv_no.'"';
             $data2=db_query($ssql);
			  while($info=mysqli_fetch_object($data2)){ $pi++;
			  $dr_amt = $dr_amt+$info->dr_amt;
			  
	  ?>
      <tr>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><?=$info->dr_amt?></td>
      </tr>
	  <?php }?>
	  
	  
 <tr>
        <td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
	  
	   <tr>
        <td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
	  
	   <tr>
        <td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr style="background-color:brown; color:#FFFFFF">
        <td align="left">
         <strong> <span style="background-color:brown;">SAR  

	
	 
	 <?
		
		$scs =  $dr_amt;
			 $credit_amt = explode('.',$scs);
	 if($credit_amt[0]>0){
	 
	 echo convertNumberToWordsForIndia($credit_amt[0]);}
	 if($credit_amt[1]>0){
	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}
	 echo ' Only.';
		?>
	 
	  </span></strong></td>
        <td align="right"><strong><? echo number_format($dr_amt,2);?></strong></td>
        </tr>

      
      
    </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="bottom"  style="font-size:12px; ">
	<?= find_a_field('user_activity_management','fname','user_id="'.$all->entry_by.'"');?> <br />
	<?=$all->entry_at;?>
	</td>
        
		 <td align="center" valign="bottom"  style="font-size:12px; ">
		 <? if($all->ca_checked>0) {?>
	<?= find_a_field('user_activity_management','fname','user_id="'.$all->ca_checked.'"');?> <br />
	<?=$all->ca_checked_at;?>
	
	<? }?>
	</td>
		
		
         <td align="center" valign="bottom"  style="font-size:12px; ">
		 <? if($all->fc_checked>0) {?>
	<?= find_a_field('user_activity_management','fname','user_id="'.$all->fc_checked.'"');?> <br />
	<?=$all->fc_checked_at;?>
	
	<? }?>
	</td>
	
        <td align="center" valign="bottom"  style="font-size:12px; ">
		 <? if($all->om_checked>0) {?>
	<?= find_a_field('user_activity_management','fname','user_id="'.$all->om_checked.'"');?> <br />
	<?=$all->om_checked_at;?>
	
	<? }?>
	</td>
	
	<td align="center" valign="bottom"  style="font-size:12px; ">
		 <? if($all->ceo_checked>0) {?>
	<?= find_a_field('user_activity_management','fname','user_id="'.$all->ceo_checked.'"');?> <br />
	<?=$all->ceo_checked_at;?>
	
	<? }?>
	</td>
	
        <td align="center" valign="bottom">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="bottom">......................</td>
        <td align="center" valign="bottom">......................</td>
        <td align="center" valign="bottom">......................</td>
        <td align="center" valign="bottom">......................</td>
        <td align="center" valign="bottom">......................</td>
      </tr>
      <tr style="font-size:15px;">
        <td><div align="center">Prepared By</div></td>
        <td><div align="center">Chief Accountant</div></td>
        <td><div align="center">Financial Controller</div></td>
        <td><div align="center">Operation Manager</div></td>
        <td><div align="center">CEO </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<form action="" method="POST" >
<table id="last_table">
<tr>

<? if($all->ceo_checked<1) {?>
<td><input type="submit" name="approve" id="approve" value="Approve" onclick="confirm('Are You Sure?')">
</td>
<? }?>

</tr>
</table>
</form>
</body>
</html>
<?
$main_content=ob_get_contents();
ob_end_clean();

echo $main_content;
echo '<br>';echo '<br>';echo '<br>';echo '<br>';

?>