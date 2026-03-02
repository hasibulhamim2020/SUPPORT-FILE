<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$proj_id 	= $_SESSION['proj_id'];
$vtype 		= $_REQUEST['v_type'];
if(isset($_REQUEST['field_name'])&&$_REQUEST['field_name']!='')
$field_name	= $_REQUEST['field_name'];
else
$field_name	= 'under_ledger';
$sql = 'SELECT DISTINCT a.ledger_id, a.ledger_name, b.group_name, b.group_class
FROM
accounts_ledger a, ledger_group b
WHERE b.group_id=a.ledger_group_id and a.ledger_id like "%000"';
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
  <div align="right"><p align="center" class="style1">Select Ledger</p>
  <br />	
  <form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="40%" align="right">Ledger Name : </td>
                                        <td width="60%" align="left"><input name="ladger_name" type="text" id="ladger_name" value="<?=$_REQUEST['ladger_name']; ?>" /></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Ledger Group :                                         </td>
                                        <td align="left"><input name="ladger_group" type="text" id="ladger_group" value="<?= $_REQUEST['ladger_group']; ?>" /></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="center"><input class="btn" name="search" type="submit" id="search" value="Show" /></td>
                                      </tr>
                                    </table>
    </form>  
      <table class="tabledesign" width="75%" border="1" style="border-collapse:collapse; border-color:#C1DAD7" id="grp" align="center" cellpadding="0" cellspacing="0">
        <tr>
			<th width="4%" align="center">No</th>
			<th width="8%" align="center">Ledger ID</th>
			<th width="12%" align="center">Ledger Name</th>
			<th width="26%" align="center">Under Group</th>
			<th width="31%" align="center">Under Class</th>
			<th width="8%" align="center">&nbsp;</th>
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
          <td align="left"><?php echo $vno[4] ?></td>
          <td align="center"><a href="#" onclick="window.opener.document.form1.<?=$field_name?>.value=<?php echo $vno[0] ?>;  closewin();">Select</a></td>
        </tr> 
        <?php
		}
		?>         
      </table>
<br />
<center>

</center>
<br /><br />
</div>15
</body>
</html>