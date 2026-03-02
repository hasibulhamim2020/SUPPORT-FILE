var xmlHttp

function check1(year)
{

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 

var url="common/budget_create1.php"
url=url+"?type="+form1.b_type.value+"&f_year="+year

url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange = function(){
	if(xmlHttp.readyState == 4)
	{
		 document.getElementById("show").innerHTML=xmlHttp.responseText
	}
}
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 
function check2(type)
{

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
var url="common/budget_create1.php"
url=url+"?type="+type+"&f_year="+form1.f_year.value
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange = function(){
	if(xmlHttp.readyState == 4)
	{
		 document.getElementById("show").innerHTML=xmlHttp.responseText
	}
}
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 
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
