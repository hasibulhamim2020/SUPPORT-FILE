<?php
session_start();
require "../common/db_connect.php";
require_once ('../../common/class.numbertoword.php');
$proj_id=$_SESSION['proj_id'];

$tr_no=$_REQUEST["tr_no"];
$sql='select a.customer_company, a.customer_name,  b.cr_amt, a.customer_id, b.cheq_no, b.receipt_date, b.bank, c.item_name
from 
stu_student_info a, 
receipt b,
stu_course c,
stu_course_register d
where a.customer_id=b.ledger_id and b.cr_amt>0 and d.customer=b.ledger_id and d.item=c.item_id and b.receipt_no='.$tr_no;
$query=db_query($sql);
if(mysqli_num_rows($query)>0)
{$info=mysqli_fetch_row($query);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../css/stu_style.css" type="text/css" rel="stylesheet"/>
<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%"><div align="left"><? $path='../logo/'.$_SESSION['proj_id'].'.jpg';
			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?></div></td>
            <td width="70%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="title">Student Payment Voucher</td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="43%">Student ID: <?=$info[0]?></td>
        <td width="37%">Course Name: <?=$info[7]?></td>
        <td width="20%"> Cash/Bank:
          <? echo ($info[6]!='')? $info[6]:'Cash';?></td>
      </tr>
      <tr>
        <td width="43%">Name: <?=$info[1]?></td>
        <td>Date :
          <?=date('d-m-Y',$info[5])?></td>
        <td> Cheque No. :
          <?=$info[4]?></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10%">Code No. </td>
        <td width="65%"><div align="left">Particulars</div></td>
        <td>Amount (Taka) </td>
      </tr>

<?
$sql='select narration,cr_amt from receipt where receipt_no="'.$tr_no.'" and cr_amt>0';
$query=db_query($sql);
$i=0;
$total=0;
while($data=mysqli_fetch_row($query)){
$i++;
?>
      <tr>
        <td>&nbsp;<?=$i?></td>
        <td>&nbsp;<?=$data[0]?></td>
        <td>&nbsp;<?=$data[1]?></td>
      </tr>
<? 
$total=$total+$data[1];
}?>
	  <tr>
        <td>&nbsp;</td>
        <td><div align="right">Total Taka: </div></td>
        <td>&nbsp;<?=$total?></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
        <td>Amount in Word : (Taka <?=CLASS_Numbertoword::convert($total,'en')?> Only) </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabledesign_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="22%"><div align="center">Prepared by </div></td>
        <td width="55%"><div align="center">Accountant</div></td>
        <td width="23%"><div align="center">Authorised Singnature </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
