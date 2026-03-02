// JavaScript Document
var xmlHttp

function updat(id)
{

 var a=id+"_1";
 var b=id+"_2";
 var c=id+"_3";
 var d=id+"_4";
 var e=id+"_5";
 var f=id+"_6";
 var g=id+"_7";
 var h=id+"_8";
 var i=id+"_9";
 var j=id+"_10";
 var k=id+"_11";
 var l=id+"_12";
 var m=id+"_13";

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {

	 
  alert ("Browser does not support HTTP Request")
  return
  } 

var url="../common/budget_monthly1.php"
url=url+"?id="+id+"&a="+document.getElementById(a).value+"&b="+document.getElementById(b).value+"&c="+document.getElementById(c).value+"&d="+document.getElementById(d).value+"&e="+document.getElementById(e).value+"&f="+document.getElementById(f).value+"&g="+document.getElementById(g).value+"&h="+document.getElementById(h).value+"&i="+document.getElementById(i).value+"&j="+document.getElementById(j).value+"&k="+document.getElementById(k).value+"&l="+document.getElementById(l).value+"&m="+document.getElementById(m).value+"&f_year="+document.getElementById("f_year").value+"&b_type="+document.getElementById("b_type").value
//alert(url)
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
