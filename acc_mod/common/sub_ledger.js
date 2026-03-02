var xmlHttp
function checking()
{
if(document.form1.fdate.value==""||document.form1.tdate.value=="")
{
alert("Please Enter valid date. Ex. 06-12-08");
return false;
}
if(document.form1.ledger_id.value=="")
{
alert("Please Select a ledger.");
return false;
}
if(document.form1.sub_ledger.value=="")
{
alert("Please Select a Sub Ledger.");
return false;
}
return true;
}

//---------------------------------------------------------------------------------
function sub_ledger(str)
{
	alert("This feature currenty unavailable!");
	return false;
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
var url="jquery/sub_ledger.php"
url=url+"?id="+str
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange = function(){
	if(xmlHttp.readyState == 4)
	{
		//alert('hi mamun');
		 document.getElementById("sub").innerHTML=xmlHttp.responseText
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
