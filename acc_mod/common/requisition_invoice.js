var xmlHttp
function set()
{
	document.getElementById("lp_qty").value=0
	document.getElementById("lp_date").value=0
	document.getElementById("qoh").value=0
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
    if (isNaN(document.form1.qty.value))
    {
        alert('Please enter only numerical values.');
        return false;
    }
    else
    {
		
		//var trate			= document.getElementById("rate").value; // sales price	
		//var qty				= document.getElementById("qty").value;
		
				

        var a=document.getElementById("item").value;
        var b=document.getElementById("lp_qty").value;
        var c=document.getElementById("lp_date").value;
		var d=document.getElementById("qoh").value;
		var e=document.getElementById("qty").value;
		var f=document.getElementById("warehouse").value;

        xmlHttp=GetXmlHttpObject()
        if (xmlHttp==null)
        {
          alert ("Browser does not support HTTP Request")
          return false;
        }
        var url="../common/requisition_invoice.php"
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
function cost_price(item_id)
{
	var warehouse_id=document.form1.warehouse.value;
	var item_id=document.form1.item.value;


	
	xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }
    var url="../common/purchaseprice.php"
    url=url+"?item_id="+item_id+"&warehouse_id="+warehouse_id
    url=url+"&sid="+Math.random()
    xmlHttp.onreadystatechange = function(){
        if(xmlHttp.readyState == 4)
        { document.getElementById("cur").innerHTML=xmlHttp.responseText}
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
