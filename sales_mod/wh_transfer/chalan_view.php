<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require "../../support/inc.all.php";



$chalan_no 		= $_REQUEST['v_no'];





$sql = "select do_no,order_no, chalan_date,driver_name,entry_by,driver_name_real,vehicle_no,delivery_man, sum(total_unit) total_unit, unit_price from sale_do_chalan where chalan_no = '".$chalan_no."' group by order_no ";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 

$do_no = $data->do_no;

$ch_total_unit[$data->order_no] = $data->total_unit;



$chalan_date=$data->chalan_date;

$driver_name=$data->driver_name;

$entry_by=$data->entry_by;

$driver_name_real=$data->driver_name_real;

$vehicle_no=$data->vehicle_no;

$delivery_man=$data->delivery_man;

}



$sql = "select order_no,sum(total_unit) total_unit from sale_do_chalan where do_no = '".$do_no."' group by order_no";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 

$delivered_qty[$data->order_no] = $data->total_unit;

}



$pi=0;



 $sql = "select d.id,i.item_id,i.item_name,i.unit_name, d.unit_price,d.pkt_size,i.sub_pack_size,d.total_unit,d.gift_on_order,i.finish_goods_code, c.total_unit,  c.total_amt from sale_do_details d, sale_do_chalan c,   item_info i where d.do_no=c.do_no and i.item_id=d.item_id and d.do_no = '".$do_no."' group by c.item_id order by d.id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 

	$pi++;

	if($data->pkt_size==1) $data->pkt_size = 10000000;

$order_id[] 		= $data->id;

$item_id[] 			= $data->item_id;

$item_name[] 		= $data->item_name;
$unit_name[] 		= $data->unit_name;
$unit_price[] 		= $data->unit_price;
$total_unit[] 		= $data->total_unit;
$total_amt[] 		= $data->total_amt;

$pkt_size[] 		= $data->pkt_size;

$sps[] 				= $data->sub_pack_size;

$fgc[] 				= $data->finish_goods_code;



$order_total_qty[] 	= $data->total_unit;

$sub_pkt_size[] 	= (($data->sub_pack_size>1)?$data->sub_pack_size:1);



$pkt_unit[] = (int)($ch_total_unit[$data->id]/$data->pkt_size);

$dist_unit[] = (int)($ch_total_unit[$data->id]%$data->pkt_size);

$total_unit[] = $ch_total_unit[$data->id]; // chalan Qty

$order_no[]=$data->id;

$gift_on_order[] = $data->gift_on_order;

$entry_time=$data->entry_time;



}



$ssql = 'select a.*,b.do_date, b.company_id, b.group_for from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Challan Copy :.</title>

<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {font-weight: bold}
-->
</style>
</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td width="50%" colspan="2"><div class="header">
	
	<table width="100%" border="0">
	<tr>
	
	<td width="234"><div align="center" style="font-size: 20px;">
	
	<? if ($concern->id==20) {?>
	
	<img src="../../pic/wojud.jpg" style="width:180px;" />
	
	<? }?>
	
	<? if ($concern->id==80) {?>
	
	<img src="../../pic/Minwal-Logo.png" style="width:180px;" />
	
	<? }?>
	</div></td>
	<td width="347"><div align="center" style="font-size: 20px; font-weight: bold;">
 <!--مذكرة تسليم-->
 <strong>
 <?=find_a_field('user_group','group_name','id='.$dealer->group_for);?>
 </strong></div></td>
	<td width="205">&nbsp;</td>
	</tr>
	</table>
	
	
	<?php /*?><table width="100%" border="0" style="font-size: 13px;">
	<tr>
	<td width="10%"><strong>DN NO </strong></td>
	<td width="15%">: <strong><?php echo $chalan_no;?> </strong> </td>
	<td width="14%"><strong>: أي التسليم </strong></td>
    <td width="1%">&nbsp;</td>
    <td width="12%"><strong>C Name</strong></td>
	<td width="30%">: <?php echo $dealer->dealer_name_e.'-'.$dealer->dealer_code.'('.$dealer->product_group.')';?> </td>
	<td width="18%"><strong>: اسم الزبون</strong></td>
	</tr>


  <tr>
  <td><strong>DATE </strong></td>
  <td>: 
    <?=$chalan_date?> </td>
  <td><strong>: تاريخ</strong></td>
  <td>&nbsp;</td>
  <td><strong>C Address</strong></td>
  <td>: <?php echo $dealer->address_e;?> </td>
  <td><strong>: عنوان العميل</strong></td>
  </tr>
	
 <tr>
  <td><strong>TRANSPORT</strong></td>
  <td>: <?php echo $driver_name_real;?> , <?=$vehicle_no?></td>
  <td><strong>: المواصلات</strong></td>
  <td>&nbsp;</td>
  <td><strong>C Contact No</strong></td>
  <td>: <?php echo $dealer->mobile_no;?> </td>
  <td><strong>: رقم الاتصال بالعملاء</strong></td>
  </tr>
	</table><?php */?>
	

	

    </div></td>
  </tr>

  <tr>

    

	<td colspan="2">	</td>
  </tr>

  

  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><span style="font-size: 18px; font-weight: bold;">INVOICE</span></td>
  </tr>
  <tr>
    <td colspan="2">
	
		<tr>

          <td valign="top" style="padding: 10px;" width="50%">
		  
		  <table style="width: 100%;" border="1" cellpadding="0" cellspacing="0">
		  
		  <tr>
		    <td bgcolor="#E2E2E2" style=" text-align:center; font-size: 16px; border: 1px solid black;"><strong>Customer</strong></td>
		  </tr>
		  <tr><td valign="top" style="height: 80px; border: 1px solid black; padding: 10px; font-size: 14px;"><span class="style2">
		    <?=$dealer->dealer_name_e;?>
		  </span></td>
		  </tr>
		  </table>		 </td>

          <td valign="top"  style="padding: 10px;" width="50%">
		  
		  <table style="width: 100%;" border="1" cellpadding="0" cellspacing="0">
		  
		  <tr>
		    <td colspan="2" bgcolor="#E2E2E2" style=" text-align:center; font-size: 16px; border: 1px solid black;"><strong>Sales Rep </strong></td>
		  </tr>
		  <tr>
		    <td width="40%" valign="top" style="height: 10px; border: 1px solid black; padding: 10px; font-size: 13px;"><strong>DATE:</strong></td>
		    <td width="60%" valign="top" style="height: 10px; border: 1px solid black; padding: 10px; font-size: 13px;"><span class="style1">
	        <?=$chalan_date?>
		    </span></td>
		  </tr>
		  <tr>
		    <td valign="top" style="height: 10px; border: 1px solid black; padding: 10px; font-size: 13px;"><strong>DO NO: </strong></td>
		    <td valign="top" style="height: 10px; border: 1px solid black; padding: 10px; font-size: 13px;"><strong><?php echo $do_no;?></strong></strong></td>
		  </tr>
		  <tr>
		    <td valign="top" style="height: 10px; border: 1px solid black; padding: 10px; font-size: 13px;"><strong>INVOICE NO: </strong></td>
		    <td valign="top" style="height: 10px; border: 1px solid black; padding: 10px; font-size: 13px;"><strong><?php echo $chalan_no;?></strong></td>
		  </tr>
		  </table>		  </td>
        </tr>
	
	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>

    <td colspan="2">

      <div id="pr">

  <div align="left">

<input name="button" type="button" onclick="hide();window.print();" value="Print" />

<nobr>

<!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;-->

<!--<a href="chalan_bill_corporate.php?v_no=<?=$_REQUEST['v_no']?>">New Bill</a>&nbsp;&nbsp;-->

<!--<a href="chalan_view_mis.php?v_no=<?=$_REQUEST['v_no']?>">MIS Copy</a>--></nobr></div>
</div>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:13px">


       <tr>
         <td width="4%" align="center" bgcolor="#CCCCCC"><strong><br>SN 
         </strong></td>
         <td width="17%" align="center" bgcolor="#CCCCCC"><strong><br>
           Item CODE</strong></td>
         <td width="47%" align="center" bgcolor="#CCCCCC"><div align="center"><strong><br>DESCRIPTION</strong></div></td>
         <td width="6%" align="center" bgcolor="#CCCCCC"><strong><br>QTY</strong></td>
         <td width="6%" align="center" bgcolor="#CCCCCC"><strong><br>UNIT</strong></td>
         <td width="4%" align="center" bgcolor="#CCCCCC"><strong><br>VAT</strong></td>
         <td width="7%" align="center" bgcolor="#CCCCCC"><strong><br>
          PRICE</strong></td>
         <td width="9%" align="center" bgcolor="#CCCCCC"><strong><br>
          AMOUNT</strong></td>
       </tr>

<? for($i=0;$i<$pi;$i++){



if($fgc[$i]!=2000 and $fgc[$i]!=2001 ){

if($pkt_size[$i]==1) $pkt_size[$i] = 1000000;

$del_qty = $order_total_qty[$i];

$dellS_qty = $delivered_qty[$order_id[$i]];

$dell_qty = $del_qty - $dellS_qty;

		if($dell_qty!=0 || $total_unit[$i]!=0){

?>

      <tr style="font-size:16px;">
        <td align="center" valign="top"><?=++$kk?></td>
        <td align="center" valign="top"><?=$fgc[$i];?></td>
        <td align="right" valign="top">
		<div align="center">
          <?=$item_name[$i];?>
          <?=($gift_on_order[$i]>0)?'<b>(Free)</b>':'';?>
        </div>		</td>
        <td align="right" valign="top"><?= number_format($total_unit[$i],2); $g_total_unit +=$total_unit[$i]; ?></td>
		
        <td align="left" valign="top"><div align="center"><?=$unit_name[$i]; ?></td>
        <td align="left" valign="top"><?= number_format($vat_amt = (($total_amt[$i]*5)/100),2); $g_vat_amt +=$vat_amt; ?></td>
        <td align="left" valign="top"><div align="center"><?= number_format($unit_price[$i],2) ?></div></td>
        <td align="left" valign="top"><div align="center"><?= number_format($total_amt[$i],2);  $g_total_amt +=$total_amt[$i];  ?></div></td>
      </tr>

<? }}}?>

      <tr style="font-size:16px;">
        <td colspan="3" align="right" valign="top"><strong>
        </strong><strong>SUB TOTAL </strong></td>
        <td align="right" valign="top"><?=number_format($g_total_unit,2);?></td>
        <td align="right" valign="top">&nbsp;</td>
        <td align="right" valign="top"><?=number_format($g_vat_amt,2);?></td>
        <td align="right" valign="top">&nbsp;</td>
        <td align="right" valign="top"><?=number_format($g_total_amt,2);?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" width="50%">&nbsp;</td>
    <td align="center" width="50%"  >
		<table width="100%" border="1">
			<tr >
				<td width="50%"><div align="right"><strong>SUB TOTAL: </strong></div></td>
				<td width="50%" align="center"><strong><?=number_format($g_total_amt,2);?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="right"><strong>TOTAL VAT: </strong></div></td>
				<td width="50%" align="center"><strong><?=number_format($g_vat_amt,2);?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="right"><strong>GRAND TOTAL: </strong></div></td>
				<td width="50%" align="center"><strong><?=number_format($g_total_amt+$g_vat_amt,2);?></strong></td>
			</tr>
	  </table>	</td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>

    <td colspan="2" align="center"><div class="footer1">
	<br /><br /><br /><br />
	<table width="100%" border="0" style="font-size: 15px;">
	
	<tr>
	<td width="27%"><div align="right"><br />
	    <br />
	  ------------------------------------</div></td>
	<td width="24%">:المحاسبين <br>: ACCOUNTANTS</td>
	<td width="2%"></td>
	<td width="31%"><div align="right"><br /><br />------------------------------------</div></td>
	<td width="16%">: أعدت بواسطة <br>: Preapred by</td>
	</tr>
	
	<tr>
	  <td></td>
	  <td></td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	<td></td>
	<td></td>
	<td></td>
	<td><div align="right"><br />
	      <br />
	  ------------------------------------</div></td>
	<td>: فحص بواسطة <br>: Checked by</td>
	</tr>
	</table>
	
	<hr /><hr />
	
	
	<table width="100%" border="0" style="font-size: 14px;">
	
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	<td><div align="right"><br />
	  ----------------------</div></td>
	<td>: اسم الزبون <br>: Customer Name</td>
	<td></td>
	<td><div align="right"><br />
	  ----------------------</div></td>
	<td>: التوقيع <br>: Signature</td>
	<td></td>
	<td><div align="right"><br />
	  ----------------------</div></td>
	<td>: اسم السائق <br>: Driver Name</td>
	</tr>
		<tr>
		  <td><div align="right"></div></td>
		  <td>&nbsp;</td>
		  <td></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		<tr>
	<td><div align="right"><br />
	  ----------------------</div></td>
	<td>: علامة وختم العملاء <br>: Sign & Stamp Customer</td>
	<td></td>
	<td><div align="right"><br />
	  ----------------------</div></td>
	<td>: لوحة لا <br>: Plate No</td>
	<td></td>
	<td><div align="right"><br />
	  ----------------------</div></td>
	<td>: نوع السيارة <br>: Vehicle Type</td>
	</tr>
	</table>
	<br />
	<hr />
	
	<table width="100%" border="0">
	<tr><td><div align="center"><strong><!--شركة مصنع المدينة المنورة للسجاد والإحرام--> <br />
	<?=find_a_field('company_info','company_details','id='.$dealer->company_id);?> </strong></div></td>
	</tr>
	</table>
	
	 </div>    </td>
  </tr>
</table>

</body>

</html>

