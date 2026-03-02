<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$dealer_code 		= $_REQUEST['dealer_code'];


$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$v_no);

$sql1="select b.* from 
sale_do_details b
where b.status = 'PROCESSING' and b.dealer_code = '".$dealer_code."' order by do_no";
$data1=db_query($sql1);


$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;

$do_no[]=$info->do_no;
$order_no[]=$info->id;

$item_id[] = $info->item_id;
$unit_price[] = $info->unit_price;
$pkt_size[] = $info->pkt_size;

$odr_qty = find_a_field('sale_do_details','sum(total_unit)','id="'.$info->id.'"');
if($odr_qty>0) $odr_pkt[] = (int)($odr_qty/$info->pkt_size); else $odr_pkt[] = 0;
$odr_dist[] = (int)($odr_qty%$info->pkt_size);

$del_qty = find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$info->id.'"');
if($del_qty>0) $del_pkt[] = (int)($del_qty/$info->pkt_size); else $del_pkt[] = 0;

$del_dist[] = (int)($del_qty%$info->pkt_size);

$undel_qty = $odr_qty - $del_qty;

if($undel_qty>0) $undel_pkt[] = (int)($undel_qty/$info->pkt_size); else $undel_pkt[] = 0;
$undel_dist[] = (int)($undel_qty%$info->pkt_size);
}
$ssql = 'select a.* from dealer_info a where a.dealer_code='.$dealer_code;
$dealer = find_all_field_sql($ssql);

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
<body style="font-family:Tahoma, Geneva, sans-serif">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">UNDELIVERY REPORT </td>
      </tr>
    </table></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="top">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
		        <tr>
		          <td width="40%" align="right" valign="middle">Dealer Name: </td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $dealer->dealer_name_e.'-'.$dealer->dealer_code.'('.$dealer->product_group.')';?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="top"> Address:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td height="60" valign="top"><?php echo $dealer->address_e.' Mobile: '.$dealer->mobile_no;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        
		        <tr>
		          <td align="right" valign="middle">Buyer Name:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $dealer->propritor_name_e;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        </table>		      </td>
			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td align="right" valign="middle"> Report AT: </td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?=date('Y-m-d H:i:s')?></td>
                    </tr>
                </table></td>
			    </tr>
			  </table></td>
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
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
       <tr>
        <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>DONO</strong></td>
        <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>FC</strong></td>
        <td rowspan="2" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>

        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Order Qty</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Undel. Qty</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Delivery Qty</strong></td>
        </tr>
       <tr>
         <td align="center" bgcolor="#CCCCCC"><strong>Pkt</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Pcs</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Pkt</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Pcs</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Pkt</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Pcs</strong></td>
        </tr>
<? for($i=0;$i<$pi;$i++){ if(($odr_pkt[$i]==$del_pkt[$i])&&($odr_dist[$i]==$del_dist[$i])){}else{$j++;?>
      <tr>
        <td align="center" valign="top"><?=$j?></td>
        <td align="left" valign="top"><a href="do_chalan.php?do=<?=$do_no[$i];?>"><?=$do_no[$i];?></a></td>
        <td align="left" valign="top"><?=find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="right" valign="top"><?=$odr_pkt[$i];?></td>
        <td align="right" valign="top"><?=$odr_dist[$i];?></td>
        <td align="right" valign="top"><?=$undel_pkt[$i];?></td>
        <td align="right" valign="top"><?=$undel_dist[$i];?></td>
        <td align="right" valign="top"><?=$del_pkt[$i];?></td>
        <td align="right" valign="top"><?=$del_dist[$i];?></td>
        </tr>
<? }}?>
    </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per Terms</em></td>
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
    <td align="center"><strong><br />
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
