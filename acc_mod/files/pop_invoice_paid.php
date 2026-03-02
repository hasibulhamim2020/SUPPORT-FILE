<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$proj_id 	= $_SESSION['proj_id'];
$vtype 		= $_REQUEST['v_type'];

$sql = 'SELECT DISTINCT ii.id, ii.s_inv_id, c.customer_name, sum(ii.amount), ii.paid_amount FROM customer c, sales_invoice ii WHERE ii.customer = c.customer_id group by s_inv_id ';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Programmer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />
<link href="common/menu.css" rel="stylesheet" type="text/css" />
<link href="assets/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="common/screen.css" media="all" />
<link href="../css/pagination.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/paging.js"></script>
<title>Account Solution</title>
<script type="text/javascript">
function ChangeColor(tableRow, highLight)
    {
    if (highLight)
    {
      tableRow.style.backgroundColor = '#FFFF66';
	  tableRow.style.cursor='pointer';
    }
    else
    {
      tableRow.style.backgroundColor = '#CEEFFF';
    }
  }
function DoNav(theUrl)
{
	var URL = 'voucher_view_popup.php?'+theUrl;
	popUp(URL);
}

function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}

function loadinparent(url)
{
	self.opener.location = url;
	self.blur(); 
}

function closewin()
{
	window.close();
}
</script>
<script>

function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	

		try{

			xmlhttp=new XMLHttpRequest();

		}

		catch(e)	{		

			try{			

				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){

				try{

				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				}

				catch(e1){

					xmlhttp=false;

				}

			}

		}

		 	

		return xmlhttp;

    }



function update_value(id)

{

if(isNaN(document.getElementById('paid_amount_'+id).value))

{

alert("Please re-enter.");

document.getElementById('paid_amount_'+id).focus();

}

else

{

var paid=document.getElementById('paid_amount_'+id).value;

}



var strURL="receive.php?paid_amount="+paid+"&id="+id;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {

			

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			

						

			req.open("GET", strURL, true);

			req.send(null);

		}	

}


</script>
<style type="text/css">
.tabledesign {
	width: 80%;
	padding: 0;
	overflow:auto;
	margin: 0px auto -1px auto; 
}

.caption { 
	font: 16px Verdana, Arial, Helvetica, sans-serif;
	text-align: center;
}

.tabledesign th {
	font: bold 11px Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	border-right: 1px solid #C1DAD7;
	border-left: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	border-top: 1px solid #C1DAD7;
	text-align: left;
	padding: 6px 6px 6px 12px;
	background: #CAE8EA url(../images/bg_header.jpg) repeat-x;
}

.tabledesign td{
	border-right: 1px solid #C1DAD7;
	border-left: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	padding: 6px 6px 6px 12px;
	color: #4f6b72;
	border-collapse:collapse;
	font: 10px Verdana, Arial, Helvetica, sans-serif;
}
.tabledesign tr{
	color: #4f6b72;
}
.tabledesign tr:hover{
	border-right: 1px solid #C1DAD7;
	border-left: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	border-collapse:collapse;
	background: #F8FBC1;
	padding: 6px 6px 6px 12px;
	color: #4f6b72;
}
</style>
</head>

<body>
  <div align="right">
    <p align="center" class="style1">Pay Invoice </p>
    <form id="form1" name="form1" method="post" action="">
      

    <br />
    <table class="tabledesign" width="75%" border="1" style="border-collapse:collapse; border-color:#C1DAD7" id="grp" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th width="4%" align="center">No</th>
          <th width="8%" align="center">Invoice No </th>
          <th width="12%" align="center">Customaer/Vendor</th>
          <th width="26%" align="center">Payable Amount </th>
          <th width="31%" align="center">Paid Amount </th>
          <th width="8%" align="center">SAVE</th>
        </tr>
        <?php
		$query=db_query($sql);		  
		while($vno=mysqli_fetch_row($query))
		{
			$v_type = $_REQUEST['v_type'];
		?>
        <tr>
          <td align="center"><?php echo $vno[0] ?></td>
          <td align="center"><?php echo $vno[1] ?></td>
          <td align="center"><?php echo $vno[2] ?></td>
          <td align="left"><?php echo $vno[3] ?></td>
          <td align="left">
          <input type="text" name="paid_amount_<?=$vno[1];?>" id="paid_amount_<?=$vno[1];?>" value="<?=$vno[4];?>" /></td>
          <td align="center"><span id="divi_<?=$vno[1];?>"><input name="go_<?=$vno[1];?>" type="submit" id="go_<?=$vno[1];?>" value="GO" onclick="update_value(<?=$vno[1];?>)" /></span></td>
        </tr> 
        <?php
		}
		?>         
      </table>    
    </form>
<br />
<center>    

</center>
<br /><br />
</div>5
</body>
</html>