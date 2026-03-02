var xmlHttp
function set()
{
	document.getElementById("qty").value=0
	document.getElementById("cc").value=''
	document.getElementById("d_amt").value=0
	document.getElementById("t_amt").value=0
	document.getElementById("trate").value=0
	document.getElementById("rate").value=0
	document.getElementById("item").value=''
	document.getElementById("item").focus()
}
function checking()
{
    if (isNaN(document.getElementById("d_inv_amt").value))
    {
        alert('Please Enter only numerical values.');
        return false;
    }
    if(((document.getElementById("d_inv_amt").value)*1)>((document.getElementById("t_inv_amt").value)*1))
    {
        alert('Please Enter Valid Amount.');
        return false;
    }
    if(document.getElementById("vendor").value=="")
    {
        alert("Please Select Customer.");
        return false;
    }
    if(document.form1.date.value=="")
    {
        alert("Please Enter Valid Date.");
        return false;
    }
    return true;
}

function ttrate(s)
{
    document.getElementById("t_amt").value=((document.getElementById("d_amt").value)*1)*((document.getElementById("qty").value)*1);
    return true;
}

function t_qty(s)
{
    if (isNaN(s))
    {
        alert('Please Enter only numerical values.');
        return false;
    }
    document.getElementById("t_amt").value=(((document.getElementById("rate").value)*1)-((document.getElementById("d_amt").value)*1));
    return true;
}

function t_price(s)
{
    if (isNaN(s))
    {
        alert('Please Enter only numerical values.');
        return false;
    }
    document.getElementById("t_amt").value=(((s)*1)-((document.getElementById("d_amt").value)*1))*((document.getElementById("qty").value)*1);
    return true;
}
function t_d_amt(s)
{
    if (isNaN(s))
    {
        alert('Please Enter only numerical values.');
        return false;
    }
    document.getElementById("t_amt").value=(((document.getElementById("rate").value)*1)-(s*1))*((document.getElementById("qty").value)*1);
    return true;
}
function d_inv(s)
{
    if (isNaN(s))
    {
        alert('Please Enter only numerical values.');
        return false;
    }
    document.getElementById("f_inv_amt").value=((document.getElementById("t_inv_amt").value)*1)-(s*1);
    return true;
}
function ttrate()
{
    document.getElementById("trate").value	= document.getElementById("cost").value;
    document.getElementById("rate").value	= document.getElementById("sale").value;
    document.getElementById("qoh").value	= document.getElementById("qoh").value;
}
function counting()
{
    if(document.form1.item.value=="")
    {
        alert("Please Enter Item.");
        return false;
    }
    if (isNaN(document.form1.rate.value))
    {
        alert('Please Enter only numerical values.');
        return false;
    }
    if (isNaN(document.form1.d_amt.value))
    {
        alert('Please Enter only numerical values.');
        return false;
    }
    if (isNaN(document.form1.qty.value))
    {
        alert('Please enter only numerical values.');
        return false;
    }
    if(document.form1.t_amt.value<1)
    {
        alert("Please Insert Amount Properly.");
        return false;
    }
    else
    {
        //document.getElementById("t_inv_amt").value=((document.getElementById("t_inv_amt").value)*1)+((document.getElementById("t_amt").value)*1);
        //document.getElementById("f_inv_amt").value=((document.getElementById("t_inv_amt").value)*1)-((document.getElementById("d_inv_amt").value)*1);
		
		var trate			= document.getElementById("rate").value; // sales price
		var amnt 			= document.getElementById("t_amt").value; // indevidual total amt
		var d_amnt			= document.getElementById("d_amt").value;		
		var qty				= document.getElementById("qty").value;
		
		var total_amt 		= document.getElementById("t_inv_amt").value;
		var total_dis 		= document.getElementById("d_inv_amt").value;
		var final_amt 		= document.getElementById("f_inv_amt").value;
		
		
		document.getElementById("t_inv_amt").value 		= (total_amt * 1) + ((trate * 1) * (qty * 1));
		document.getElementById("d_inv_amt").value 		= (total_dis * 1) + ((d_amnt * 1) * (qty * 1));
		document.getElementById("f_inv_amt").value 		= (final_amt * 1) + (amnt * 1);
		

        var a=document.getElementById("item").value;
        var b=document.getElementById("rate").value;
        var c=document.getElementById("qty").value;
        var d=document.getElementById("d_amt").value;
        var e=document.getElementById("t_amt").value;
		var f=document.getElementById("cc").value;

        xmlHttp=GetXmlHttpObject()
        if (xmlHttp==null)
        {
          alert ("Browser does not support HTTP Request")
          return false;
        }
        var url="../common/sales_invoice.php"
        url=url+"?a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f
        //alert(url)
        url=url+"&sid="+Math.random()

        xmlHttp.onreadystatechange = function()
        {
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
//---------------------------------------------------------------------------------
function cost_price(str)
{
    xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }
    var url="../common/student.php"
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
