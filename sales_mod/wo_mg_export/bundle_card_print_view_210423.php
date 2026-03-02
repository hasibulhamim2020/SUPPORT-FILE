<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$bc_no 		= $_REQUEST['v_no'];

$do_no= find_a_field('sale_do_bundle_card','do_no','bc_no='.$bc_no);

$master= find_all_field('sale_do_master','','do_no='.$do_no);

$bc_data= find_all_field('sale_do_bundle_card','','bc_no='.$bc_no);

foreach($challan as $key=>$value){

$$key=$value;

}

$ssql = 'select a.*,b.do_date, b.group_for, b.via_customer from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$entry_time=$dealer->do_date;

$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;

$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 

$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>.: BUNDLE CARD :.</title>

<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

document.getElementById("pr").style.display="none";

}

</script>

<style type="text/css">

<!--

.header table tr td table tr td table tr td table tr td {

color: #000;

}

.style1 {font-weight: bold}

@media print{

.footer {

position: fixed;

left: 0;

bottom: 0;

width: 100%;

color: white;

text-align: center;

}

}

-->

</style>

</head>

<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div id="pr">

<div align="center">

<p>

<input name="button" type="button" onclick="hide();window.print();" value="Print" />

</p>

</div>

</div>

<div><table border="1" cellpadding="100" align="center">
<tr id="0" style="position:relative; width:100%; float: none;">
<?

if($_POST['branch']!='') $con.=' and a.PBI_BRANCH ="'.$_POST['branch'].'"';

 $sql22="SELECT *

FROM sale_do_bundle_card

WHERE bc_no='".$bc_no."'

order by item_id,id  ";

$res = db_query($sql22);

$ig=0;$pg=-2; while($data=mysqli_fetch_object($res)){

?>

<? $ig++;?>

<td style="padding:10px;">

<table width="100%"  border="1" cellspacing="0" cellpadding="0"   style="font-size:12px;">

<tr height="100">

<td colspan="2">

<p style="font-size:18px; color:#000000; margin:0; text-align:center; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$data->group_for)?></p>

<p style="font-size:12px; color:#000000; margin:0; text-align:center; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','address','id='.$data->group_for)?></p>					</td>
</tr>

<tr  height="25">

<td width="31%">&nbsp;Job No: </td>

<td width="69%"><strong>&nbsp;<?php echo $data->job_no;?></strong></td>
</tr>

<tr  height="25">

<td>&nbsp;Customer:</td>

<td>&nbsp;<?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$data->dealer_code.'"');?></td>
</tr>

<tr  height="25">

<td>&nbsp;Buyer:</td>

<td>&nbsp;<?= find_a_field('buyer_info','buyer_name','buyer_code="'.$data->buyer_code.'"');?></td>
</tr>

<tr  height="25">

<td>&nbsp;Customer's PO:</td>

<td>&nbsp;<?php echo $data->customer_po_no;?></td>
</tr>
<tr  height="25">
  <td>&nbsp;Delivery Place: </td>
  <td>&nbsp;<?= find_a_field('delivery_place_info','delivery_place','id="'.$data->delivery_place.'"');?></td>
</tr>
<tr  height="25">
  <td>&nbsp;Address:</td>
  <td>&nbsp;<?= find_a_field('delivery_place_info','address_e','id="'.$data->delivery_place.'"');?></td>
</tr>

<tr  height="25">

<td>&nbsp;No of Ply: </td>

<td>&nbsp;<?php echo $data->ply;?></td>
</tr>

<tr  height="25">

<td>&nbsp;Measurement:</td>

<td>&nbsp;<? if($data->L_cm>0) {?><?=$data->L_cm?><? }?><? if($data->W_cm>0) {?>X<?=$data->W_cm?><? }?><? if($data->H_cm>0) {?>X<?=$data->H_cm?><? }?> <?=$data->measurement_unit?></td>
</tr>

<tr  height="25">

<td>&nbsp;Qty/Bundle:</td>

<td>&nbsp;<?php echo number_format($data->total_unit,2);?></td>
</tr>

<tr  height="25">

<td>&nbsp;Bundle No: </td>

<td>&nbsp;<?php echo $data->bundle_no;?></td>
</tr>

<tr  height="25">

<td>&nbsp;Date:</td>

<td>&nbsp;<?php echo date('d-m-Y',strtotime($data->bc_date));?></td>
</tr>
</table>

</td>

<? if(($ig%2)==0){ $pg++; ?></tr><tr id="<?=$ig?>" style=" width:100%; <? if(($ig%4)!=0){?>page-break-after:always; <? }?>"><? }?>

<? } ?>

</table>

</div>

<br /><br /><br /><br />

</body>

</html>
