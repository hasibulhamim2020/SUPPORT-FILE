<?php
session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//====================== EOF ===================
//var_dump($_SESSION);
// require "../../common/check.php";
// require "../../config/db_connect.php";
// require "../../common/my.php";

$chalan_no 		= $_REQUEST['v_no'];


$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$v_no);

$sql1="select b.* from 
sale_do_chalan b
where b.chalan_no = '".$chalan_no."'";
$data1=db_query($sql1);


$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;
$chalan_date=$info->chalan_date;
$do_no=$info->do_no;
$driver_name=$info->driver_name;
$vehicle_no=$info->vehicle_no;
$delivery_man=$info->delivery_man;

$item_id[] = $info->item_id;
$unit_price[] = $info->unit_price;
$pkt_size[] = $info->pkt_size;
$pkt_unit[] = $info->pkt_unit;
$dist_unit[] = $info->dist_unit;
$total_unit[] = $info->total_unit;
}
$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;
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
<table  style="width:100%; borer:0; border-collapse:collapse; padding:0; text-align:center;">
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
		    <td valign="top">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
		        <tr>
		          <td width="40%" align="right" valign="middle">Dealer Name: </td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $dealer->dealer_name_e;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="top"> Address:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td height="60" valign="top"><?php echo $dealer->dealer_name_e;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="middle">Chalan No:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $dealer->dealer_name_e;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="middle">Buyer Name:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $dealer->dealer_name_e;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        </table>		      </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
			    <td align="right" valign="middle">C No: </td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $chalan_no;?></td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle">Delivery Order No:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $do_no;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle">Driver Name:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $driver_name;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle">Vehicle No:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><b>
			          <?=$vehicle_no?>
			          </b>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle"> Date</td>
			    <td><?=$chalan_date?></td>
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
    <td><table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">DELIVERY CHALAN</td>
      </tr>
    </table>
      <div id="pr">
  <div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
       <tr>
        <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>
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
<? for($i=0;$i<$pi;$i++){?>
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?
        echo find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);?></td>
        <td align="left" valign="top"><?
        echo find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="right" valign="top"><?=$specification[$i]?></td>
        <td align="right" valign="top">&nbsp;</td>
        <td align="right" valign="top"><?=$tqty[$i]?></td>
        <td align="right" valign="top">&nbsp;</td>
        <td align="right" valign="top"><?=$pkt_unit[$i]?></td>
        <td align="right" valign="top"><?=$dist_unit[$i]?></td>
        </tr>
<? }?>
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
<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>
