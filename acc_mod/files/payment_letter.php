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

$all = find_all_field('secondary_journal','','jv_no="'.$jv_no.'"');
$cr_ledger = find_a_field('secondary_journal','ledger_id','jv_no="'.$jv_no.'" and cr_amt>0');
$cr_ledger_info = find_all_field('accounts_ledger','','ledger_id="'.$cr_ledger.'"');
$cr_amt = find_a_field('secondary_journal','cr_amt','jv_no="'.$jv_no.'" and cr_amt>0');
$company = find_all_field('accounts_ledger','','ledger_id="'.$all->relavent_cash_head.'"');
$vendor = find_all_field('accounts_ledger','','ledger_id="'.$all->ledger_id.'"');

$supplier = find_all_field('vendor','','vendor_id="'.$all->vendor_id.'"');

$cr_amt = find_a_field('secondary_journal','cr_amt','jv_no="'.$all->jv_no.'" and tr_from="'.$all->tr_from.'" and cr_amt>0');
$pbi = find_all_field('personnel_basic_info','','PBI_ID="'.$all->employee_id.'"');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-type" content="text/html" charset="UTF-8" />

<title>.: Payment Letter :.</title>

<link href="../../../assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script></head>

<body>
<table width="70%" cellpadding="0" cellspacing="0" border="0" align="center" style="border-bottom:1px solid #000000;">
  <tr>
    <td colspan="4" align="right">&nbsp;<img src="payment_logo.png" style=" height:100px;" />&nbsp;</td>
  </tr>
</table> <br>
   
<table width="70%" cellpadding="0" cellspacing="0" border="0" align="center">
  <tr height="30">
    <td colspan="4"><strong>Date : <?php echo date('d-m-Y',strtotime($all->jv_date));?>
	<input type="hidden" id="english" name="english" value="<?=$all->jv_date?>" /></strong></td>
  </tr>
  <tr height="30">
    <td colspan="4"><strong>Hijri : <input type="text" id="hijri" style="border:0px solid #FFFFFF; font-weight:bold;" readonly="readonly" /> </strong></td>
  </tr>
  <tr height="30">
    <td colspan="3"><strong>Dears : <?=$cr_ledger_info->bank_name;?></strong></td>
    <td width="39%" align="right"><strong>Honorable</strong></td>
  </tr>
   <tr height="30">
    <td colspan="4"><strong><span style="text-decoration:underline;">Subject</span> : <span style="text-decoration:underline;">
	 <? if($all->type=="BANK") {?>
	 Wire Transfer
	 
	 <? }?>
	 
	 <? if($all->type=="CASH") {?>
	 <?=$all->type?>
	 
	 <? }?>
	 
	 <? if($all->type=="CHEQUE") {?>
	 <?=$all->type?>
	 
	 <? }?>
	 </span></strong></td>
  </tr>
   <tr height="30">
    <td colspan="4"><strong>According to the above subject , Kindly transfer Amount of <?=find_a_field('currency_type','short_name','id="'.$all->currency_type.'"')?>. ( <?=number_format($cr_amt,2)?> ) ( 
	<?=find_a_field('currency_type','currency_name','id="'.$all->currency_type.'"')?>
	
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
)</strong></td>
  </tr>
  
   <td width="9%"></tr>
   <tr height="30">
    <td colspan="4"><strong>To the Following Account Number</strong> </td>
  </tr>
  
  <? if($all->vendor_id>0) {?>
  <tr height="30">
 <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="51%"><strong>Beneficiary Name</strong></td>
    <td width="1%">:</td>
    <td><strong><?=find_a_field('vendor','vendor_company','vendor_id="'.$supplier->vendor_id.'"');?>
	</strong></td>
  </tr>
  <? }?>
  
  <? if($all->vendor_id<1) {?>
  <tr height="30">
 <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="51%"><strong>Beneficiary Name</strong></td>
    <td width="1%">:</td>
    <td><strong><?=find_a_field('accounts_ledger','ledger_name','ledger_id="'.$all->ledger_id.'"');?>
	</strong></td>
  </tr>
  <? }?>
  
  <? if($all->vendor_id>0) {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Beneficiary Bank </strong></td>
    <td>:</td>
    <td><strong><?=find_a_field('vendor','vendor_bank','vendor_id="'.$supplier->vendor_id.'"');?>
	</strong></td>
  </tr>
  <? }?>
  
  <? if($all->vendor_id<0) {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Beneficiary Bank </strong></td>
    <td>:</td>
    <td><strong><?=find_a_field('accounts_ledger','bank_name','ledger_id="'.$all->ledger_id.'"');?>
	</strong></td>
  </tr>
  <? }?>
  
  <? if($all->vendor_id>0) {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Branch Name </strong></td>
    <td>:</td>
    <td><strong><?=find_a_field('vendor','branch_name','vendor_id="'.$supplier->vendor_id.'"');?>
	</strong></td>
  </tr>
  <? }?>
  
  <? if($all->vendor_id<0) {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Branch Name </strong></td>
    <td>:</td>
    <td><strong><?=find_a_field('accounts_ledger','branch_name','ledger_id="'.$all->ledger_id.'"');?>
	</strong></td>
  </tr>
  <? }?>
  
  
   <? if($all->vendor_id>0) {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Account Number </strong></td>
    <td>:</td>
    <td><strong><?=find_a_field('vendor','vendor_bank_ac','vendor_id="'.$supplier->vendor_id.'"');?>
	</strong></td>
  </tr>
  <? }?>
  
  <? if($all->vendor_id<0) {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Account Number </strong></td>
    <td>:</td>
    <td><strong><?=$vendor->accounts_number?>
	</strong></td>
  </tr>
  <? }?>
  
  
  <? $iban_no=find_a_field('vendor','iban_no','vendor_id="'.$supplier->vendor_id.'"');?>
  
  <? if($all->vendor_id>0) {?>
  <? if($iban_no!="") {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>IBAN </strong></td>
    <td>:</td>
    <td><strong><?=$iban_no;?>
	</strong></td>
  </tr>
  <? }?>
  <? }?>
  
  
  <? $swift_code=find_a_field('vendor','swift_code','vendor_id="'.$supplier->vendor_id.'"');?>
  <? if($all->vendor_id>0) {?>
  <? if($swift_code!="") {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Swift Code </strong></td>
    <td>:</td>
    <td><strong><?=$swift_code;?>
	</strong></td>
  </tr>
  <? }?>
  <? }?>
  
  <? if($all->vendor_id<0) {?>
  <? if($vendor->swift_code!="") {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Swift Code </strong></td>
    <td>:</td>
    <td><strong><?=$vendor->swift_code?>
	</strong></td>
  </tr>
  <? }?>
  <? }?>
  
  
  
  
  
  
  
   <tr height="30">
   <<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Purpose</strong></td>
    <td>:</td>
    <td><strong><?=$all->purpose?>						
</strong></td>
  </tr>
  
  
  <? if($all->vendor_id>0) {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Address</strong></td>
    <td>:</td>
    <td><strong><?=find_a_field('vendor','address','vendor_id="'.$supplier->vendor_id.'"');?>
	</strong></td>
  </tr>
  <? }?>
  
  <? if($all->vendor_id<0) {?>
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>Address</strong></td>
    <td>:</td>
    <td><strong><?=$vendor->address?>
	</strong></td>
  </tr>
  <? }?>
  
  
   
  
  
  
   <tr height="30">
    <td colspan="4"><strong>	A deduction from our account number	<span style="font-size:16px;">
	(<?=$cr_ledger_info->accounts_number?>)</span></strong></td>
  </tr>
  
   <tr height="30">
    <td colspan="4"><strong>And we Delegate (<?=$pbi->PBI_NAME?> ), ID No : (<?=$pbi->MEMBER_ID?>  )to Follow up </strong></td>
  </tr>
   <tr>
   <td colspan="4">	<strong>on behalf of  	Madinah Carpet & Ihram Factory Company	</strong> </td>
 </tr>
 
  <tr>
   <td colspan="4">	<strong>	Thank you and appreciating ...	</strong> </td>
 </tr>
   
   
    <tr>
   <td colspan="4" align="center">	<strong>	And accept Our sincere greetings and respect...</strong></td>
 </tr>
 
 <tr>
   <td colspan="4" align="center">&nbsp;&nbsp;</td>
 </tr>
  <tr>
   <td colspan="4" align="center">&nbsp;&nbsp;</td>
 </tr>
  <tr>
   <td colspan="4" align="center">&nbsp;&nbsp;</td>
 </tr>
  <tr>
   <td colspan="4" align="center">&nbsp;&nbsp;</td>
 </tr>
 
  <tr>
   <td colspan="4" align="right" style="text-decoration:overline;"> <strong>  Madinah Carpet & Ihram   Factory Company</strong></td>
 </tr>
 </tr>
</table>
<br><br>

 
 <table width="70%" cellpadding="0" cellspacing="0" border="0" align="center" style="border-top:1px solid #000000;">
  <tr>
    <td colspan="3"><strong>س . ت : 4650021726 -  رأس المال  000 000 3 ريال سعودي  -  المدينة المنورة -  المملكة العربية السعودية 										
     ص . ب : 6468  - هاتف : 8403218-4-00966 / 8403227-4-00966 - فاكس :  8403159-4-00966</strong>									
</td>
   </tr>
</table><br>
   
 
</table>

<script>
function gmod(n,m){
return ((n%m)+m)%m;
}

function kuwaiticalendar(adjust){
var dd= document.getElementById('english').value;
//alert(dd);
var today = new Date(dd);
//alert(today);
if(adjust) {
    adjustmili = 1000*60*60*24*adjust; 
    todaymili = today.getTime()+adjustmili;
    today = new Date(todaymili);
}
day = today.getDate();
month = today.getMonth();
year = today.getFullYear();
m = month+1;
y = year;
if(m<3) {
    y -= 1;
    m += 12;
}

a = Math.floor(y/100.);
b = 2-a+Math.floor(a/4.);
if(y<1583) b = 0;
if(y==1582) {
    if(m>10)  b = -10;
    if(m==10) {
        b = 0;
        if(day>4) b = -10;
    }
}

jd = Math.floor(365.25*(y+4716))+Math.floor(30.6001*(m+1))+day+b-1524;

b = 0;
if(jd>2299160){
    a = Math.floor((jd-1867216.25)/36524.25);
    b = 1+a-Math.floor(a/4.);
}
bb = jd+b+1524;
cc = Math.floor((bb-122.1)/365.25);
dd = Math.floor(365.25*cc);
ee = Math.floor((bb-dd)/30.6001);
day =(bb-dd)-Math.floor(30.6001*ee);
month = ee-1;
if(ee>13) {
    cc += 1;
    month = ee-13;
}
year = cc-4716;


wd = gmod(jd+1,7)+1;

iyear = 10631./30.;
epochastro = 1948084;
epochcivil = 1948085;

shift1 = 8.01/60.;

z = jd-epochastro;
cyc = Math.floor(z/10631.);
z = z-10631*cyc;
j = Math.floor((z-shift1)/iyear);
iy = 30*cyc+j;
z = z-Math.floor(j*iyear+shift1);
im = Math.floor((z+28.5001)/29.5);
if(im==13) im = 12;
id = z-Math.floor(29.5001*im-29);

var myRes = new Array(8);

myRes[0] = day; //calculated day (CE)
myRes[1] = month-1; //calculated month (CE)
myRes[2] = year; //calculated year (CE)
myRes[3] = jd-1; //julian day number
myRes[4] = wd-1; //weekday number
myRes[5] = id; //islamic date
myRes[6] = im-1; //islamic month
myRes[7] = iy; //islamic year

return myRes;
}
function writeIslamicDate(adjustment) {
var wdNames = new Array("Ahad","Ithnin","Thulatha","Arbaa","Khams","Jumuah","Sabt");
var iMonthNames = new Array("Muharram","Safar","Rabi'ul Awwal","Rabi'ul Akhir",
"Jumadal Ula","Jumadal Akhira","Rajab","Sha'ban",
"Ramadan","Shawwal","Dhul Qa'ada","Dhul Hijja");
var iDate = kuwaiticalendar(adjustment);
var outputIslamicDate = wdNames[iDate[4]] + ", " 
+ iDate[5] + " " + iMonthNames[iDate[6]] + " " + iDate[7] + " AH";
return outputIslamicDate;
}

document.getElementById('hijri').value=writeIslamicDate(1);
//document.write(writeIslamicDate(1));
</script>
</body>
</html>
