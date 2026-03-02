<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

session_start();
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
    
<div>

  <div style="width:100%; display:flex;justify-content:space-around; align-items:start; margin-bottom:30px;">
      <div style=" width: 40%">
       <h1 style="display:flex; align-items:center; gap:10px; white-space:nowrap; margin:5px 0; font-size:18px;">Dealer Name:<span style="display:inline-block; width:100%; border:1px solid #000000; padding:5px;">shc</span></h1>
       <h1 style="display:flex; align-items:center; gap:10px; white-space:nowrap; margin:5px 0; font-size:18px;">Address:<span style="display:inline-block; width:100%; border:1px solid #000000; padding:5px;">ERP COM BD</span></h1>
       <h1 style="display:flex; align-items:center; gap:10px; white-space:nowrap; margin:5px 0; font-size:18px;">Chalan No:<span style="display:inline-block; width:100%; border:1px solid #000000; padding:5px;">ERP COM BD</span></h1>
       <h1 style="display:flex; align-items:center; gap:10px; white-space:nowrap; margin:5px 0; font-size:18px;">Buyer No:<span style="display:inline-block; width:100%; border:1px solid #000000; padding:5px;">ERP COM BD</span></h1>
      
  </div>
  <div style=" width: 40%">
       <h1 style="display:flex; align-items:center; gap:10px; white-space:nowrap; margin:5px 0; font-size:18px;">C No:<span style="display:inline-block; width:100%; border:1px solid #000000; padding:5px;">shc</span></h1>
       <h1 style="display:flex; align-items:center; gap:10px; white-space:nowrap; margin:5px 0; font-size:18px;">Delivery Order No:<span style="display:inline-block; width:100%; border:1px solid #000000; padding:5px;">ERP COM BD</span></h1>
       <h1 style="display:flex; align-items:center; gap:10px; white-space:nowrap; margin:5px 0; font-size:18px;">Driver Name:<span style="display:inline-block; width:100%; border:1px solid #000000; padding:5px;">ERP COM BD</span></h1>
       <h1 style="display:flex; align-items:center; gap:10px; white-space:nowrap; margin:5px 0; font-size:18px;">Vehcile Name:<span style="display:inline-block; width:100%; border:1px solid #000000; padding:5px;">ERP COM BD</span></h1>
       <h1 style="display:flex; align-items:center; gap:10px; white-space:nowrap; margin:5px 0; font-size:18px;">Date:<span style="display:inline-block; width:100%; border:1px solid #000000; padding:5px;">07-09-2025</span></h1>
      
  </div>
  </div>
  
   
  
  <tr>
    <td><table style="width: 60%; margin: 0 auto; border-collapse: collapse; border: 0;">
      <tr>
        <td  style="text-align:center; color:#FFF; font-size:18px; font-weight:bold; background-color:#666666;">DELIVERY CHALAN</td>
      </tr>
    </table>
      <div id="pr">
  <div  style="text-align:left;">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div>
</div>
<table style="width:100%; border:1px solid #000; border-collapse:collapse; text-align:center;">
  <tr>
    <th rowspan="2" style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">SL</th>
    <th rowspan="2" style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Code</th>
    <th rowspan="2" style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Product Name</th>
    <th colspan="2" style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Order Qty</th>
    <th colspan="2" style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Undel. Qty</th>
    <th colspan="2" style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Delivery Qty</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Pkt</th>
    <th style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Pcs</th>
    <th style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Pkt</th>
    <th style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Pcs</th>
    <th style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Pkt</th>
    <th style="border:1px solid #000; padding:5px; background-color:#ccc; text-align:center;">Pcs</th>
  </tr>
  <?php for($i=0; $i<$pi; $i++){ ?>
  <tr>
    <td style="border:1px solid #000; padding:5px; text-align:center; vertical-align:top;"><?= $i+1 ?></td>
    <td style="border:1px solid #000; padding:5px; text-align:left; vertical-align:top;">
      <?= find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]); ?>
    </td>
    <td style="border:1px solid #000; padding:5px; text-align:left; vertical-align:top;">
      <?= find_a_field('item_info','item_name','item_id='.$item_id[$i]); ?>
    </td>
    <td style="border:1px solid #000; padding:5px; text-align:right; vertical-align:top;"><?= $specification[$i] ?></td>
    <td style="border:1px solid #000; padding:5px; text-align:right; vertical-align:top;">&nbsp;</td>
    <td style="border:1px solid #000; padding:5px; text-align:right; vertical-align:top;"><?= $tqty[$i] ?></td>
    <td style="border:1px solid #000; padding:5px; text-align:right; vertical-align:top;">&nbsp;</td>
    <td style="border:1px solid #000; padding:5px; text-align:right; vertical-align:top;"><?= $pkt_unit[$i] ?></td>
    <td style="border:1px solid #000; padding:5px; text-align:right; vertical-align:top;"><?= $dist_unit[$i] ?></td>
  </tr>
  <?php } ?>
</table>

    </td>
  </tr>
  <tr>
    <td  style="border:1px solid #F03816; text-align:center;">
    <table  style="width:100%; border:0; min-height:50vh;">
  <tr>
    <td colspan="2" style="font-size:12px;"><em>All goods are received in a good condition as per Terms</em></td>
    </tr>
  <tr>
    <td style="width:50%;">&nbsp;</td>
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
    <td style="text-align:left;"><div class="footer_left"><strong>--------------------------------<br />
          Receiver's Signature</strong></div></td>
    <td  style="text-align:center;"><strong><br />
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
</div>
</body>
</html>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
