<?php
session_start();
require "../common/db_connect.php";
$proj_id	= $_SESSION['proj_id'];
$vtype		= $_REQUEST['v_type'];
//echo $vtype;
//exit();

$pi		= 0;
$no		= $vtype."_no";
$vdate	= $vtype."_date";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Programmer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />
<link href="common/menu.css" rel="stylesheet" type="text/css" />
<title>Account Solution</title>
<style type="text/css">
<!--
.style3 {
	font-size: 18px;
	font-weight: bold;
}
.style5 {font-size: 12px; font-weight: bold; }
-->
</style>
<script type="text/javascript1.2">
function hide()
{
    pr.style.display="none";
}
</script>
</head>
<body>
<div id="reportprint">
  <div align="center">
    <div><span class="style3"><?php echo $_SESSION['proj_name']."<br \>";?></span>
	<br \>
	<?php
	if($vtype=='purchase')
		{	
			$price_head='Cost Price';
			echo 'Purchase Invoice';
		}
		if($vtype=='sales')
		{
			$price_head='Sale Price';
			echo 'Sales Invoice';
		}
		if($vtype=='issue')
		{
			$price_head='Issue Price';
			echo 'Issue Invoice';
		}
		if($vtype=='return')
		{
			$price_head='Return Price';
			echo 'Return Invoice';
		}

		?>
    </div>
    <div id="pr">
        <div align="left">
          <input name="button" type="button" onclick="hide();window.print();" value="Print" />
        </div>
    </div>	
      
	  <?php
	  	if($vtype=='purchase')
		{
			$sql = db_query('SELECT jv_no, jv_date FROM journal WHERE jv_no = (SELECT MAX(jv_no) from journal) GROUP BY jv_no');
		}
		if($vtype=='sales')
		{
			$sql = db_query('SELECT jv_no, jv_date FROM journal WHERE jv_no = (SELECT MAX(jv_no) from journal) GROUP BY jv_no');
		}
		if($vtype=='issue')
		{
			$sql = db_query('SELECT jv_no, jv_date FROM journal WHERE jv_no = (SELECT MAX(jv_no) from journal) GROUP BY jv_no');
		}		
		if($vtype=='return')
		{
			$sql = db_query('SELECT jv_no, jv_date FROM journal WHERE jv_no = (SELECT MAX(jv_no) from journal) GROUP BY jv_no');
		}
		
		$info = array();
		while($data = mysqli_fetch_row($sql))
		{	
	  ?>
      <table width="100%" class="title">
        <tr>
          <td>Invoice No.&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $data[0]; ?></td>
          <td>Invoice Date.&nbsp;&nbsp;&nbsp;&nbsp; <?php echo date("d-m-y", $data[1]); ?></td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp; </td>
        </tr>
      </table>
		<?php
		$invpoice_id = $data[0];
		}
		?>
    <form id="form1" name="form1" method="post" action="voucher_print.php">
	<table width="100%" border="1" align="left" bordercolor="#000066" id="vbig">
        
        <tr>
          <td width="50%" valign="top"><table width='100%' border="1" cellpadding="2" cellspacing="2" bordercolor="#333333" bgcolor="#FFFFFF" style="border-collapse:collapse">
              <tr align="center">
                <td width="7%" bgcolor="#E0E0E0"><span class="style5">S/L</span></td>
                <td width="25%" align="left" bgcolor="#E0E0E0"><span class="style5">Item name </span></td>
                <td width="24%" align="left" bgcolor="#E0E0E0"><span class="style5"><?=$price_head?></span></td>
                <td width="29%" align="left" bgcolor="#E0E0E0"><span class="style5">Qty</span></td>
                <td width="29%" align="left" bgcolor="#E0E0E0">Discount amount </td>
                <td width="15%" align="right" bgcolor="#E0E0E0"><span class="style5">Amount</span></td>
              </tr>
			<?php 
			$pi=0;
			$t_amt=0;
			$t_amount = 0;
			
			if($vtype=='purchase')
			{
				$query = 'SELECT a.p_inv_id, 
								a.item, 
								a.rate, 
								a.qty, 
								a.disc, 
								a.amount, 
								b.item_id, 
								b.item_name FROM purchase_invoice as a, item_info as b 
								WHERE 
								a.item=b.item_id AND 
								a.p_inv_id='.$invpoice_id.' 
								ORDER BY p_inv_id DESC';
			}
			if($vtype=='sales')
			{
				$query = 'SELECT a.s_inv_id, 
								a.item, 
								a.rate, 
								a.qty, 
								a.disc, 
								a.amount, 
								b.item_id, 
								b.item_name FROM sales_invoice as a, item_info as b 
								WHERE 
								a.item=b.item_id AND 
								a.s_inv_id='.$invpoice_id.' 
								ORDER BY s_inv_id DESC';
			}
			if($vtype=='issue')
			{
				$query = 'SELECT a.s_inv_id, 
								a.item, 
								a.rate, 
								a.qty, 
								a.disc, 
								a.amount, 
								b.item_id, 
								b.item_name FROM issue_invoice as a, item_info as b 
								WHERE 
								a.item=b.item_id AND 
								a.s_inv_id='.$invpoice_id.' 
								ORDER BY s_inv_id DESC';
			}
			if($vtype=='return')
			{
				$query = 'SELECT a.p_inv_id, 
								a.item, 
								a.rate, 
								a.qty, 
								a.disc, 
								a.amount, 
								b.item_id, 
								b.item_name FROM return_invoice as a, item_info as b 
								WHERE 
								a.item=b.item_id AND 
								a.p_inv_id='.$invpoice_id.' 
								ORDER BY p_inv_id DESC';
			}
		
			
			//echo $vtype;
			$sql=db_query($query);
			$info = array();
			//print_r(mysqli_fetch_row($sql));
			while($info = mysqli_fetch_row($sql))
			{	
				$pi++;
			  ?>
              <tr align="center" class="sect">
                <td><span class="report_font1 report_font1"><?php echo $pi;?></span></td>
                <td align="left"><span class="report_font1 report_font1"><?php echo $info[7];?></span></td>
                <td align="left"><span class="report_font1 report_font1"><?php echo $info[2];?></span></td>
                <td align="left"><span class="report_font1 report_font1"><?php echo $info[3];?></span></td>
                <td align="left"><span class="report_font1 report_font1"><?php echo $info[4];?></span></td>
                <td align="right"><span class="report_font1 report_font1"><?php echo $info[5];?></span></td>
              </tr>
			  <?php 
			  $t_amount += $info[5];
			  }
			  ?>
              <tr align="center">
                <td colspan="5" align="right"><strong>Total Amount : </strong></td>
                <td align="right"><strong><?php echo $t_amount;?></strong></td>
              </tr>
          </table>
		  <br  />
		  <br /><br /><br />
		  <table width="100%">
  <tr>
    <td align="center" valign="bottom"><strong>---------------</strong></td>
    <td align="center" valign="bottom"><strong>---------------------</strong></td>
    <td align="center" valign="bottom"><strong>&nbsp;</strong></td>
    <td align="center" valign="bottom"><strong>-----------------------------------------------</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Posted By </strong></td>
    <td align="center"><strong>Office Secretary </strong></td>
    <td align="center"><strong>Approved By: </strong></td>
    <td align="center"><strong>Convener/Treasure/Secretary General</strong></td>
  </tr>
  <tr>
  		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
  
  </tr>
    <tr>
  		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
  
  </tr>
    <tr>
  		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
  
  </tr>
    <tr>
    <td align="center" valign="bottom"><strong>&nbsp;</strong></td>
    <td align="center" valign="bottom"><strong>&nbsp;</strong></td>
    <td align="center" valign="bottom"><strong>&nbsp;</strong></td>
    <td align="center" valign="bottom"><strong>-------------</strong></td>
  </tr
   ><tr>
    <td align="center"><strong>&nbsp; </strong></td>
    <td align="center"><strong>&nbsp; </strong></td>
    <td align="center"><strong>&nbsp;</strong></td>
    <td align="center"><strong>President</strong></td>
  </tr>
     <tr>
  		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
  
  </tr>
     <tr>
  		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
  
  </tr>
    <tr>
    <td align="center" valign="bottom"><strong>&nbsp;</strong></td>
    <td align="center" valign="bottom"><strong>&nbsp;</strong></td>
    <td align="center" valign="bottom"><strong>&nbsp;</strong></td>
    <td align="center" valign="bottom"><strong>-----------------</strong></td>
  </tr
   ><tr>
    <td align="center"><strong>&nbsp; </strong></td>
    <td align="center"><strong>&nbsp; </strong></td>
    <td align="center"><strong>&nbsp;</strong></td>
    <td align="center"><strong>RECEIVED BY</strong></td>
  </tr>
</table>

		  </td>
        </tr>
      </table>

    </form>
   </div>
</div>
</body>
</html>
