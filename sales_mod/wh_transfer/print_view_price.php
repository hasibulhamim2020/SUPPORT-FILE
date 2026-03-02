<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require "../../support/inc.all.php";
require "../../../engine/tools/class.numbertoword.php";



$req_no 		= $_REQUEST['req_no'];

$sql="select * from production_issue_master where  pi_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: FG Challan Copy :.</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style11 {
	font-size: 16px;
	font-weight: bold;
}
.style14 {font-weight: bold}
.style12 {
	font-size: 16px;
	font-weight: normal;
}
.style4 {	font-size: 18px;
	color: #000000;
}
.style6 {font-size: 10px}
-->
</style>
</head>
<body>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><? if($_SESSION['user']['depot']!=5){?><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                  <tr>
                    <td bgcolor="#00CC33" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;"><span class="style4">Sajeeb Corporation<br />
                          <span class="style6">Shezan Point (5th Floor),2 Indira Road, Farmgate,Dhaka-1215</span></span></td>
                  </tr>
                  
                </table><? }else{?><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                  <tr>
                    <td bgcolor="#00CC33" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;"><span class="style4">Hashem Foods Ltd. <br />
                          <span class="style6">Bhulta, Rupgonj, Narayanganj</span></span></td>
                  </tr>
                  
                </table><? }?></td>
              </tr>
              <tr>
                <td>
				<div class="header_title">
				Store To Store Chalan Copy				</div></td>
              </tr>
              <tr>
                <td height="19">&nbsp;</td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="bottom" width="22%">&nbsp;</td>
			<td width="24%" valign="bottom"><span class="style11"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_from);?>
			</span></td>
			<td width="9%" valign="bottom">TO</td>
			<td width="45%"><span class="style11">
			  <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?>
			</span></td>
		  </tr>
		</table>		</td>
	  </tr>
    </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
	<td>	</td>
    <td></td>
  </tr>
  <tr>
    <td><div class="line"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div class="header2">
          <div class="header2_left" style="height:30px;">
        <p><strong>Date</strong>: <?=$all->pi_date;?><br />
          <strong>PI  No</strong>: <span class="style14">
          <?=$all->pi_no;?>
          </span><br />
        </p>
      </div>
      <div class="header2_right">
        <p>
          <strong class="style11">SL No</strong>: <strong class="style11"><?php echo $all->remarks;?></strong><br />
          Carried By: <?php echo $all->carried_by;?><br />
        </p>
      </div>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
  </tr>
</table>
</form>
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="2%"><strong>SL.</strong></td>
        <td><strong>FG</strong></td>
        <td><strong>Description of the Goods </strong></td>
        <td><strong>Crt</strong></td>
        <td><strong>Pcs</strong></td>
        <td><strong>Rate</strong></td>
        <td><strong>Amt</strong></td>
        </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from production_issue_detail where  pi_no='$req_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);

?>
      <tr>
        <td valign="top"><?=$pi?></td>
        <td align="left" valign="top"><?=$item->finish_goods_code?></td>
        <td align="left" valign="top"><span class="style12">
          <?=$item->item_name?>
        </span></td>
        <td valign="top"><div align="right">
          <span class="style11">
          <?=(int)$crt[$i]=($info->total_unit/$item->pack_size); $t_crt = $t_crt + ((int)$crt[$i]);?>
          </span>        </div></td>
        <td valign="top"><div align="right"> <span class="style11">
            <?=(int)$pcs[$i]=($info->total_unit%$item->pack_size); $t_pcs = $t_pcs + ((int)$pcs[$i]);?>
        </span> </div></td>
        <td valign="top"><div align="right"><strong>
          <?=number_format($info->unit_price,2);?>
        </strong></div></td>
        <td valign="top">
          <div align="right">
            <span class="style11"><?=$info->total_amt; $ttpp = $ttpp +$info->total_amt;?>
            </span>            </div></td>
        </tr>
      
<? }?>
<tr>
        <td colspan="3" valign="top"><div align="right"><strong>Total:</strong></div></td>
        <td valign="top"><div align="right"><span class="style1">
          <?=$t_crt?>
        </span></div></td>
        <td valign="top"><div align="right"><span class="style1">
            <?=$t_pcs?>
        </span></div></td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><div align="right"><span class="style1">
          <?=$ttpp?>
        </span></div></td>
</tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
	<div class="footer1"><strong><br />
    </strong>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20%"><div align="center">
            <p style="float:left; font-weight:bold;">Prepared By:
              <?=find_a_field('user_activity_management','username','user_id='.$all->entry_by)?>
            </p>
          </div></td>
          <td width="40%"><div align="center">
              <p>Received By</p>
          </div></td>
          <td width="40%"><div align="center">Store Incharge </div></td>
        </tr>
      </table>
             </div>
	<div class="footer1"></div></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
