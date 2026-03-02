<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
include "../common/check.php";
require "../common/db_connect.php";
require "../classes/db.php";
require_once ('../../common/class.numbertoword.php');



$proj_id	= $_SESSION['proj_id'];
$vtype		= $_REQUEST['v_type'];
$vdate		= $_REQUEST['vdate'];
$v_no 		= $_REQUEST['v_no'];
$no 		= $vtype."_no";
$in		= $_REQUEST['in'];

if($_GET['update']=='Update')
{
	$req_status = $_GET['req_status'];
	$ssql='update requisition_order set req_status="'.$_GET['req_status'].'" where id="'.$v_no.'"';
	db_query($ssql);
}

$sql="select * from requisition_order where  id='$v_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cash Memo :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<div class="header_title">
				Purchase Requsition
				</div></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="bottom" width="23%">&nbsp;</td>
			<td valign="bottom">&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>		</td>
	  </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  <tr>
    <td><div class="line"></div></td>
  </tr>
  <tr>
    <td><div class="header2">
          <div class="header2_left">
        <p> Date: <?php echo $all->date;?><br />
          Requisition  No : <?php echo $all->req_no;?><br />
          Requisition For : <?php echo $all->req_from;?><br />
        </p>
      </div>
      <div class="header2_right">
        <p>
          Note : <?php echo $all->narration;?><br />
          Need Before : <?php echo $all->need_by;?><br />
        </p>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
    <td width="100" align="right">Present Status:</td>
    <td width="1">
    <select name="req_status">
    <option><?=$all->req_status;?></option>
    <option>PENDING</option>
    <option>STOPPED</option>
    <option>CANCELED</option>
    <option>COMPLETE</option>
    </select></td>
    <td><input name="update" type="submit" value="Update" /><input type="hidden" name="v_no" id="v_no" value="<?=$v_no?>" /></td>
  </tr>
</table>

</form>
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="5%"><strong>SL.</strong></td>
        <td width="45%"><strong>Description of the Goods </strong></td>
        <td width="10%"><strong>Req QTY</strong></td>
        <td width="9%"><strong>In Stock</strong></td>
        <td width="13%"><strong>Last Pur. Date</strong></td>
        <td width="9%"><strong>Last Pur. QTY</strong></td>
        </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from requisition_order where  id='$v_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$amount[]=$info->qty*$info->rate;
$total=$total+($info->qty*$info->rate);
$sl[]=$pi;
$item[]=find_a_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
$qty[]=$info->qty;
$qoh[]=$info->qoh;
$last_p_date[]=$info->last_p_date;
$last_p_qty[]=$info->last_p_qty;
}?>
      <tr>
        <td height="350" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$sl[$i]?></p><? }?></td>
        <td align="left" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$item[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$qty[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$qoh[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$last_p_date[$i]?></p><? }?></td>
        <td align="right" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$last_p_qty[$i]?></p><? }?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">
	<div class="footer1">
	  <div style="float:left">
	  <p style="text-align:center">--------------------------<br />Authorized Person</p>
	  </div>
	</div>
	<div class="footer1">
      <p style="float:left; font-weight:bold;">Prepared By: <?=find_a_field('user_activity_management','username','user_id='.$data1[3])?></p>
	</div></td>
  </tr>
</table>
</body>
</html>
