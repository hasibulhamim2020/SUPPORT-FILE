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
$cr_amt = find_a_field('secondary_journal','cr_amt','jv_no="'.$jv_no.'" and cr_amt>0');
$company = find_all_field('accounts_ledger','','ledger_id="'.$all->relavent_cash_head.'"');
$vendor = find_all_field('accounts_ledger','','ledger_id="'.$all->ledger_id.'"');
$cr_amt = find_a_field('secondary_journal','cr_amt','jv_no="'.$all->jv_no.'" and tr_from="'.$all->tr_from.'" and cr_amt>0');
$pbi = find_all_field('personnel_basic_info','','PBI_ID="'.$all->employee_id.'"');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-type" content="text/html" charset="UTF-8" />

<title>.: Voucher :.</title>

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
    <td colspan="4" align="right">&nbsp;<img src="<?=SERVER_ROOT?>public/uploads/logo/awn.png" style=" width:330px; height:100px;" />&nbsp;</td>
   </tr>
   </table><br>
   
<table width="70%" cellpadding="0" cellspacing="0" border="0" align="center">
  <tr height="30">
    <td colspan="4"><strong>Date : <?=$all->jv_date?><input type="hidden" id="english" name="english" value="<?=$all->jv_date?>" /></strong></td>
    
  </tr>
  <tr height="30">
    <td colspan="4"><strong>Hijri : <input type="text" id="hijri" style="border:0px solid #FFFFFF; font-weight:bold;" readonly="readonly" /></strong></td>
  </tr>
  <tr height="30">
    <td colspan="4"><strong>Dears : <?=$bank->ledger_name;?></strong></td>
    <td><strong>Honorable</strong></td>
  </tr>
   <tr height="30">
    <td colspan="4"><strong><span style="text-decoration:underline;">Subject</span> : <span style="text-decoration:underline;"><?=$all->type;?></span></strong></td>
   
  </tr>
   <tr height="30">
    <td colspan="4"><strong>According to the above subject , Kindly transfer Amount of 	( <?=number_format($cr_amt,2)?> ) ( <?=convertNumberMhafuz($cr_amt)?>							
)</strong></td>
   
  </tr>
  
   </tr>
   <tr height="30">
    <td colspan="4"><strong>To the Following Account Number</strong> </td>
   
  </tr>
  
  <tr height="30">
 <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>1-	Beneficiary Name</strong></td>
    <td>:</td>
    <td><strong><?=find_a_field('accounts_ledger','ledger_name','ledger_id="'.$all->ledger_id.'"');?></strong></td>
  </tr>
  
  <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>2-	Beneficiary Bank </strong></td>
    <td>:</td>
    <td><strong><?=$vendor->ledger_name?></strong></td>
  </tr>
  <tr height="30">
 <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>3-  Account Number</strong></td>
    <td>:</td>
    <td><strong><?=$vendor->acc_code?></strong></td>
  </tr>
  <tr height="30">
 <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>4- Swift Code</strong></td>
    <td>:</td>
    <td><strong><?=$vendor->swift_code?></strong></td>
  </tr>
   <tr height="30">
   <<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>5- Purpose</strong></td>
    <td>:</td>
    <td><strong><?=$all->purpose?>						
</strong></td>
  </tr>
   <tr height="30">
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><strong>6- Address</strong></td>
    <td>:</td>
    <td><strong><?=$vendor->address?>						
</strong></td>
  </tr>
  
   <tr height="30">
    <td colspan="4"><strong>	A deduction from our account number	<span style="font-size:20px;">(<?=$company->acc_code?>)</span></strong></td>
   
  </tr>
  
   <tr height="30">
    <td colspan="4"><strong>And we Delegate (<?=$pbi->PBI_NAME?> ), ID No : (<?=$pbi->IQAMA_NO?>  )to Follow up </strong></td>
   
  </tr>
   <tr>
   <td colspan="4">	<strong>on behalf of  	Madinah Carpet & Ihram Factory Company	</strong>							
 </td>
 </tr>
 
  <tr>
   <td colspan="4">	<strong>	Thank you and appreciating ...	</strong>								
							
 </td>
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
</table><br><br>

 
 <table width="70%" cellpadding="0" cellspacing="0" border="0" align="center" style="border-top:1px solid #000000;">
  <tr>
    <td colspan="3" dir="rtl" style="font-family: "Geeza Pro", "Nadeem", "Al Bayan", "DecoType Naskh", "DejaVu Serif", "STFangsong", "STHeiti", "STKaiti", "STSong", "AB AlBayan", "AB Geeza", "AB Kufi", "DecoType Naskh", "Aldhabi", "Andalus", "Sakkal Majalla", "Simplified Arabic", "Traditional Arabic", "Arabic Typesetting", "Urdu Typesetting", "Droid Naskh", "Droid Kufi", "Roboto", "Tahoma", "Times New Roman", "Arial", serif;"><strong>س . ت : 4650021726 -  رأس المال  000 000 3 ريال سعودي  -  المدينة المنورة -  المملكة العربية السعودية 										
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
