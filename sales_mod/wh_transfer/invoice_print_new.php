<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require_once "../../../engine/tools/check.php";
require_once "../../../engine/configure/db_connect.php";
require_once "../../../engine/tools/my.php";

$v_no 		= $_REQUEST['v_no'];
$no 		= $vtype."_no";
$in			= $_REQUEST['in'];

$datas=find_all_field('lc_workorder_chalan','s','id='.$v_no);
$ww=find_all_field('lc_workorder','s','id='.$datas->wo_id);

$sql1="select b.chalan_date,a.for,a.buyer_id,b.qty,c.qty,c.id,c.specification,c.meassurment,c.item_id,c.style_no,a.id from lc_workorder a,lc_workorder_chalan b,lc_workorder_details c where b.wo_id=a.id and b.specification_id=c.id and b.wo_id=".$datas->wo_id." and entry_at between '".($datas->entry_at-1200)."' and '".($datas->entry_at+1200)."'";
$data1=db_query($sql1);


$pi=0;
$total=0;
//echo $sql2;
while($info=mysqli_fetch_row($data1)){ 
$pi++;
$ch_date=$info[0];
$for=$info[1];
$buyer=$info[2];

$sl[]=$pi;
$qty[]=$info[3];
$tqty[]=$info[4];

$amount[]=$info[3];
$total=$total+($info[3]);
$totalt=$totalt+($info[4]);
$item[]=$info[5];

$specification[]=$info[6];
$meassurment[]=$info[7];
$item_id[]=$info[8];
$style_no[]=$info[9];
$woid=$info[10];
}?>
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
<style type="text/css">
<!--
.style7 {font-size: 12px}
.style8 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">
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
				<div class="header_title"></div></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td width="20%" rowspan="2" valign="top"><? $path='../../pic/Logu.jpg';
			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?></td>
			<td width="50%" align="center" valign="top"><table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">DELIVERY CHALAN</td>
  </tr>
</table>  </td>
			<td width="30%" rowspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
			    <td width="40%" align="right" valign="middle">Date : </td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $ch_date;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle"> WO No :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $woid;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle">Chalan No :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $v_no;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
                
			  </table></td>
		  </tr>
		  <tr>
		    <td align="center" valign="top">&nbsp;</td>
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
    <td>
<div id="pr">
<div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div></div>
<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#333333" bgcolor="#FFFFFF">
  <tr>
    <td bordercolor="#333333" bgcolor="#CCCCCC"><div align="center"><span class="style7">SHIPPER/EXPORTER</span></div></td>
    <td bordercolor="#333333" bgcolor="#CCCCCC"><div align="center"><span class="style7">RECEIVER/BILL TO </span></div></td>
  </tr>
  <tr>
    <td width="50%" valign="top" bordercolor="#333333"><span class="style8">NAL
    </span><br /> 
    <span class="style7">Office: House: 147(3rd Floor), Road: 1(East Side), Baridhara DOHS, Dhaka, Bangladesh.</span></td>
    <td width="50%" valign="top" bordercolor="#333333"><span class="style7">
      <? $par=find_all_field('lc_buyer','buyer_name','id='.$buyer);
echo '<span class="style8">'.$par->buyer_name.' </span><BR><span class="style7">Address:'.$par->address.' Contact:'.$par->contact_person_name.' Cell:'.$par->contact_cell.'</span>';
					?>
    </span></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="33%"><span class="style7">Ref No# <?=$ww->manual_no?> </span></td>
    <td width="33%"><span class="style7"> Brand Name: 
      <? $brand=find_all_field('lc_brand','brand_name','id='.$ww->brand_id); echo $brand->brand_name;?> </span></td>
    <td width="33%"><span class="style7">Buyer Name: 
	<? echo find_a_field('lc_brand_buyer','brand_buyer_name','id='.$brand->brand_buyer_id);?> </span></td>
  </tr>
</table>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
       <tr>
        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Item</strong></div></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Style/PO No</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Specification</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>Order Qty.</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>Delivery Qty.</strong></td>
        </tr>
<? for($i=0;$i<$pi;$i++){?>
      <tr>
        <td align="center" valign="top"><?=$sl[$i]?></td>
        <td align="left" valign="top"><?
        echo find_a_field('lc_product_item','item_name','id='.$item_id[$i]);?></td>
        <td align="right" valign="top"><?=$style_no[$i]?></td>
        <td align="right" valign="top"><?=$specification[$i]?></td>
        <td align="right" valign="top"><?=$tqty[$i]?></td>
        <td align="right" valign="top"><?=$qty[$i]?></td>
        </tr>
<? }?>
      <tr>
        <td colspan="4" align="right">Total  :</td>
        <td align="right"><strong><?php echo number_format($totalt,0);?></strong></td>
        <td align="right"><strong><?php echo number_format($total,0);?></strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:12px"><ul>
      <li><em>All goods are received in a good condition as per L/C Terms</em></li>
      <li>Claims for short receive, part delievery must be advised in writing with in three (3) days after delievery. </li>
    </ul></td>
    </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><div class="footer_left"><strong>--------------------------------<br />
          Receiver's Signature</strong></div></td>
    <td align="center"><strong>--------------------------------<br />
    For: NAL
      </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    </table>
    <div class="footer1"> </div>
    </td>
  </tr>
</table>
</body>
</html>
