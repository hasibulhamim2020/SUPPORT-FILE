var xmlHttp
function set()
{
	document.getElementById("item").value=null
		document.getElementById("cc").value=''
	document.getElementById("trate").value=0
	document.getElementById("qty").value=0
	document.getElementById("d_amt").value=0
	document.getElementById("t_amt").value=0
	document.getElementById("refno").value=0
	
	document.getElementById('item').focus() 
}

function checkhead(type)
{
	$.ajax({
	  url: '../../common/check_entry.php',
	  data: "query_item="+$('#item').val()+"&pageid=purchase_invoice_item",
	  success: function(data) {						
		var myRegExp = /exist/;
		var found = data.search(myRegExp);


			if(found != -1)
			{
				if( checking()== true)
				{
					counting();
					set();
				}
			}
			else
			{
				alert(data);
			}
		 }
	});
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
    if(document.form1.vendor.value=="")
    {
        alert("Please Select Vendor.");
        return false;
    }
    if(document.form1.date.value=="")
    {
        alert("Please Enter Valid Date.");
        return false;
    }
    return true;
}


function t_rate(s)
{
	if (isNaN(s)) 
	{
		alert('Please Enter only numerical values.');
		return false;
	}
	document.getElementById("t_amt").value=((s*1)-((document.getElementById("d_amt").value)*1))*((document.getElementById("qty").value)*1);
	return true;
}

function t_qty(s)
{
	if (isNaN(s)) 
	{
		alert('Please Enter only numerical values.');
		return false;
	}
	document.getElementById("t_amt").value=(((document.getElementById("trate").value)*1)-((document.getElementById("d_amt").value)*1))*(s*1);
	return true;
}

function t_d_amt(s)
{
	if (isNaN(s)) 
	{
		alert('Please Enter only numerical values.');
		return false;
	}
	document.getElementById("t_amt").value=(((document.getElementById("trate").value)*1)-(s*1))*((document.getElementById("qty").value)*1);
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
function counting()
{
	if(document.form1.item.value=="")
	{
		alert("Please Enter Item Description.");
		return false;
	}
	if(document.form1.refno.value=="")
	{
		alert("Reference id missing!");
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
		var trate			= document.getElementById("trate").value;
		var amnt 			= document.getElementById("t_amt").value;
		var d_amnt			= document.getElementById("d_amt").value;		
		var qty				= document.getElementById("qty").value;
		
		var total_amt 		= document.getElementById("t_inv_amt").value;
		var total_dis 		= document.getElementById("d_inv_amt").value;
		var final_amt 		= document.getElementById("f_inv_amt").value;
		
		
		document.getElementById("t_inv_amt").value 		= (total_amt * 1) + ((trate * 1) * (qty * 1));
		document.getElementById("d_inv_amt").value 		= (total_dis * 1) + ((d_amnt * 1) * (qty * 1));
		document.getElementById("f_inv_amt").value 		= (final_amt * 1) + (amnt * 1);
		
		
		var a=document.getElementById("item").value;
		var b=document.getElementById("trate").value;
		var c=document.getElementById("qty").value;
		var d=document.getElementById("d_amt").value;
		var e=document.getElementById("t_amt").value;
		var f=document.getElementById("refno").value;
		var g=document.getElementById("cc").value;
		
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		{
		  alert ("Browser does not support HTTP Request")
		  return false;
		} 
		var url="../common/return_invoice.php"
		url=url+"?a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f+"&g="+g;
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

//---------------------------------------------------------------------------------
function cost_price(str)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		  alert ("Browser does not support HTTP Request")
		  return
	} 
	var url="../common/cost_price.php"
	url=url+"?id="+str
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange = function()
	{
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
