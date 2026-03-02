var xmlHttp
var count = 1;


function checking()
{
	if(!isValidDate(document.form1.date.value)) 
	{
		alert('Insert Voucher Date Properly.');
		return false;
	}
	if(document.getElementById("t_c_amt").value!=document.getElementById("t_d_amt").value)
	{
		alert('Please Balance Credit and Debit Amounts.');
		return false;
	}
	if(document.form1.t_c_amt.value=="")
	{
		alert("Please Enter Data.");
		return false;
	}
	document.forms['form1'].submit();
}

function checkhead(type)
{

	$.ajax({
	  url: '../../common/check_entry.php',
	  data: "query_item="+$('#ledger_id').val()+"&pageid=acchead&type="+type,
	  success: function(data) {						
		var myRegExp = /exist/;
		var found = data.search(myRegExp);


			if(found != -1)
			{
				check(); 	
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
	if(isNaN(document.form1.debit.value)) 
	{
		alert('Please Enter only numerical values in Debit Amount.');
		return false;
	}

	if (isNaN(document.form1.credit.value)) 
	{
		alert('Please enter only numerical values in Credit Amount.');
		return false;
	}
	if(document.form1.credit.value < 1 && document.form1.debit.value < 1)
	{
		alert("Please Insert Amount Properly.");
		return false;
	}
	else
	{
		var t_c_amt = ((document.getElementById("t_c_amt").value)*1)+((document.getElementById("credit").value)*1);
		var t_d_amt = ((document.getElementById("t_d_amt").value)*1)+((document.getElementById("debit").value)*1);
		
		var t_diff  = t_c_amt - t_d_amt;

		document.getElementById("t_c_amt").value=t_c_amt.toFixed(2);
		document.getElementById("t_d_amt").value=t_d_amt.toFixed(2);

		document.getElementById("t_diff").value=t_diff.toFixed(2);

		var a=document.getElementById("type").value;
		var b=document.getElementById("ledger_id").value;
		var c=document.getElementById("cur_bal").value;
		var d=document.getElementById("debit").value;
		var e=document.getElementById("credit").value;
		var detail=document.getElementById("detail").value;

		$.ajax({
		  url: '../../common/journal_check2.php',
		  data: "a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&detail="+detail+"&count="+count,
		  success: function(data) {						
				$('#tbl').append(data);
				$('#count').val(count);
				count = count + 1;		
			 }
		});		
		$('#ledger_id').val('');
		$('#cur_bal').val('0');
		$('#debit').val('');
		$('#amount').val('0');
		$('#type').focus();
	}
return true;
}


function head_check(str)
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
