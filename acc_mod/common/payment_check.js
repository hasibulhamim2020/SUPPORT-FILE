var xmlHttp
function checking()
{
if(document.getElementById("t_c_amt").value!=document.getElementById("t_d_amt").value)
{
alert('Please Balance Credit and Debit Amounts.');
return false;
}
if(document.form1.narration.value=="")
{
alert("Please Enter Narration.");
return false;
}
if(document.form1.t_c_amt.value=="")
{
alert("Please Enter Data.");
return false;
}
return true;
}
function check()
{
if (isNaN(form1.debit.value)) {
alert('Please Enter only numerical values in Debit Amount.');
return false;
}
if (isNaN(form1.credit.value)) {
alert('Please enter only numerical values in Credit Amount.');
return false;
}
if(document.form1.credit.value<1&&document.form1.debit.value<1)
{
alert("Please Insert Amount Properly.");
return false;
}
else
{
document.getElementById("t_c_amt").value=((document.getElementById("t_c_amt").value)*1)+((document.getElementById("credit").value)*1);
document.getElementById("t_d_amt").value=((document.getElementById("t_d_amt").value)*1)+((document.getElementById("debit").value)*1);
var a=document.getElementById("type").value;
var b=document.getElementById("ledger_id").value;
var c=document.getElementById("cur_bal").value;
var d=document.getElementById("debit").value;
var e=document.getElementById("credit").value;

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
var url="common/payment_check2.php"
url=url+"?a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e
url=url+"&sid="+Math.random()

xmlHttp.onreadystatechange = function(){
	if(xmlHttp.readyState == 4)
	{
		 document.getElementById("tbl").innerHTML=xmlHttp.responseText
	}
}
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
return true;
}


function head(str)
{
if(str=="Credit")
{
document.getElementById("debit").readOnly = true;
document.getElementById("credit").readOnly = false;
document.getElementById("debit").value=0;
document.getElementById("credit").value="";
}
if(str=="Debit")
{
document.getElementById("debit").readOnly = false;
document.getElementById("credit").readOnly = true;
document.getElementById("credit").value=0;
document.getElementById("debit").value="";
}
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
var url="common/payment_check.php"
url=url+"?type="+str
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange = function(){
	if(xmlHttp.readyState == 4)
	{
		 document.getElementById("head").innerHTML=xmlHttp.responseText
	}
}
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 
//---------------------------------------------------------------------------------
function open_bal(str)
{
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
var url="common/cur_bal.php"
url=url+"?id="+str
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange = function(){
	if(xmlHttp.readyState == 4)
	{
		 document.getElementById("cur").innerHTML=xmlHttp.responseText
	}
}
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 
//---------------------------------------------------------------------------------
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
