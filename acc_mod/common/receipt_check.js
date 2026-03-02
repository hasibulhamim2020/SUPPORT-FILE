var xmlHttp
var count = 1;

function checking()
{
if(document.form1.t_amount.value==""){
alert('Insert Valid Data.');
return false;
}
if(((document.getElementById("t_amount").value)*1)>((document.getElementById("limitt").value)*1)){
alert('Insert Valid Amount. Amount overflowed.');
return false;
}
return true;
}

function checkhead(type)
{
	
	var ledger_id=$('#ledger_id').val();
	ledger_id = ledger_id.replace('#','@');
	$.ajax({
	  url: '../../common/check_entry.php',
	  data: "query_item="+ledger_id+"&pageid=acchead&type="+type,
	  success: function(data) {						
		var myRegExp = /exist/;
		var found = data.search(myRegExp);


			if(found != -1)

			{
				check(); 
				//addtotal();
						
			}
			else
			{
				alert(data);
			}
		 }
	});
}
function isValidDate(strDate) {
     // (\d{1,2}) means 4 or 12
     // (\/|-) means either (/ or -), 4-12 or 4/12 
     // NOTE: we have to escape / (\/)
     // or else pattern matching will interpret it to mean the end instead of the literal "/"
     // \2 use the 2nd placeholder (\/|-) "here"
     // (\d{2}|\d{4}) means 02 or 2002
     var datePat = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{2}|\d{4})$/;
     var matchArray = strDate.match(datePat);

     if (matchArray == null) return false;

     // matchArray[0] will be the original entire string, for example, 4-12-02 or 4/12/2002
     var day = matchArray[1];     // (\d{1,2}) - 1st parenthesis set - 4
     var month = matchArray[3];         // (\d{1,2}) - 3rd parenthesis set - 12
     var year = matchArray[4];        // (\d{2}|\d{4}) - 5th parenthesis set - 02 or 2002

     if (month < 1 || month > 12) return false;
     if (day < 1 || day > 31) return false;
     if ((month == 4 || month == 6 || month==9 || month == 11) && day == 31) return false;
     if (month == 2) {
          var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));

          if (day > 29 || (day == 29 && !isleap)) return false;
     }
     return true;
}
function check()
{
	if (document.form1.r_from.value=='') 
	{
		alert('Insert Transection Mode Ledger.');
		return false;
	}
		if(!isValidDate(document.form1.date.value)) 
	{
		alert('Insert Voucher Date Properly.');
		return false;
	}
	if ((document.form1.c_id.value=='')&&(document.form1.b_id.value=='')) 
	{
		alert('Please Select A Ledger to receive.');
		return false;
	}
	if (document.form1.ledger_id.value=='') 
	{
		alert('Please Select A Ledger.');
		return false;
	}
	if (isNaN(document.form1.amount.value)) 
	{
		alert('Please Enter only numerical values in Amount.');
		return false;
	}
	if(document.form1.amount.value<1){
		alert("Please Insert Amount Properly.");
		return false;
	}
	else{
		
			

			document.getElementById("t_amount").value = ((document.getElementById("t_amount").value)*1)+((document.getElementById("amount").value)*1);
			
			var a;
			var b=document.getElementById("ledger_id").value;
			var c=document.getElementById("cur_bal").value;
			var d=document.getElementById("detail").value;
			var e=document.getElementById("amount").value;
			var cc_code=document.getElementById("cc_code").value;				
			b = b.replace('#','@');

		
		$.ajax({
		  url: '../../common/receipt_check2.php',
		  data: "a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&cc_code="+cc_code+"&count="+count,
		  success: function(data) {						
				$('#tbl').append(data);
				$('#count').val(count);
				count = count + 1;		
			 }
		});
		
	$('#ledger_id').val('');
	$('#cur_bal').val('0');
	$('#detail').val('');
	$('#amount').val('0');
	$('#ledger_status').val('');
	}
return true;
}
//---------------------------------------------------------------------------------
function deleterow(rowid)
{	
	$.ajax({
	  url: '../../common/receipt_check2.php',
	  data: "delete=yes" + "&deletedrow="+type,
	  success: function(data) {						
			$('#tbl').html(data);
		 }
	});
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
var url="../common/cur_bal.php"
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
//---------------------------------------------------------------------------------
function open_limit(str)
{
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  }

var b_id=document.getElementById("b_id").value;
var c_id=document.getElementById("c_id").value;

if(c_id!='') str = c_id;
if(b_id!='') str = c_id;
var url="../common/limit.php"
url=url+"?id="+str
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange = function(){
	if(xmlHttp.readyState == 4)
	{
		 document.getElementById("limit").innerHTML=xmlHttp.responseText
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
