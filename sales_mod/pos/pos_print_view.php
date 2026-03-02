<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require "../../../engine/tools/class.numbertoword.php";



$pos_id 		= $_REQUEST['pos_id'];

$sql="select * from sale_pos_master where  pos_id='$pos_id'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);

$sub_depot_id=$all->sub_depot;
$group_for=$all->group_for;

$ware=find_all_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id);

$from_warehouse=$ware->warehouse_name;



$sub_ware=find_all_field('warehouse','warehouse_name','warehouse_id='.$all->sub_depot);

$sub_depot=$sub_ware->warehouse_name;

$address_depot=$sub_ware->address;

$delivery_spot=$sub_ware->delivery_spot;

$contect_p=$sub_ware->warehouse_company;
$contect_m=$sub_ware->contact_no;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Despatch Order Copy</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style2 {font-weight: bold}
-->
</style>
</head>
<body>
<table width="701" border="0" cellspacing="0" cellpadding="0" align="center" id="section-to-print">
  
  
  
  <?php /*?><tr>
    <td  colspan="2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>

    <td align="left"><strong style="font-size:24px">
	
				
			
				
				
				<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$group_for?>.png" style="width:250px;" />
				<br /></strong>    </td>
  </tr>
    </table>	</td>
    <td  width="40%"  colspan="2">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>

    <td align="left"  ><strong><font style="font-size:20px; text-transform: uppercase;">
      <?=find_a_field('user_group','group_name','id='.$group_for);?>
    </font></strong></td>
  </tr>
  
  
  <tr>

    <td align="left">&nbsp; </td>
  </tr>
  
  <tr height="40" style="background:#000; color:#FFFFFF" align="center">

    <td >

    <strong><font style="font-size:20px">INVOICE </font></strong></td>
  </tr>
    </table>	</td>
  </tr><?php */?>
  
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="37%">&nbsp;</td>
    <td width="32%" height="40" colspan="2" align="center" style="background:#000; color:#FFFFFF"><strong><font style="font-size:20px">INVOICE </font></strong></td>
    <td width="31%">&nbsp;</td>
  </tr>
  
  

<tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  
  
  <tr>
    <td colspan="4">
	
	
	<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50%" align="center" bgcolor="#CCCCFF"><strong><font style="font-size:16px; text-transform:uppercase;">Warehouse</font></strong></td>
        <td width="50%" align="center" bgcolor="#CCCCFF"><strong><font style="font-size:16px;  text-transform:uppercase;">Customer</font></strong></td>
        </tr>
	 
      <tr>
        <td align="center" valign="top">
		<font style="font-size:16px;  text-transform:uppercase;">
          <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id);?>
        </font></td>
        <td align="center" valign="top">
		<font style="font-size:16px;  text-transform:uppercase;">
          <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$all->dealer_id);?>
        </font></td>
      </tr>
    </table>	</td>
  </tr>
  
  
  
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  

<tr>
    <td colspan="3">&nbsp;</td>
    <td>
		<table width="100%" border="1">
			<tr>
				<td width="50%"><div align="right"><strong>POS No: </strong></div></td>
				<td width="50%" align="center"><strong><?php echo $all->pos_id;?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="right"><strong>Sale  Date: </strong></div></td>
				<td width="50%" align="center"><strong><?php echo date("d-m-Y",strtotime($all->pos_date)); ?></strong></td>
			</tr>
	  </table>	</td>
</tr>



  
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  
  
  

  <tr>
    <td colspan="4"><div id="pr">
<div align="left">
<form action="" method="get">

<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
  </tr>
</table><?php */?>
</form><br /><br />
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="3%" bgcolor="#CCCCFF"><strong>SL</strong></td>
        <td width="16%" bgcolor="#CCCCFF"><strong>Code</strong></td>
        <td width="48%" bgcolor="#CCCCFF"><strong>Description of the Goods </strong></td>
        <td width="9%" bgcolor="#CCCCFF"><strong>Unit</strong></td>
        <td width="11%" bgcolor="#CCCCFF"><strong>Quantity</strong></td>
        <td width="13%" bgcolor="#CCCCFF"><strong>Rate</strong></td>
        <td width="13%" bgcolor="#CCCCFF"><strong>Amount</strong></td>
        </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from sale_pos_details where  pos_id='$pos_id'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$sl=$pi;
$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);

$ord_qty=$info->qty;
$ord_bag=$ord_qty/$item->pakg_ctn_size;

$rate=$info->rate;

$total_amt=$info->total_amt;

$net_total_amt +=$total_amt;

$tot_ord_qty +=$ord_qty;
$tot_ord_bag +=$ord_bag;


?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="center" valign="top"><?=$item->finish_goods_code?>          </td>
        <td align="left" valign="top"><?=$item->item_name?></td>
        <td valign="top"><?=$item->unit_name?></td>
        <td valign="top"><?=number_format($ord_qty,2);?></td>
        <td valign="top"><?=number_format($rate,2);?></td>
        <td valign="top"><?=number_format($total_amt,2);?></td>
      </tr>
	  
	  <? }?>
	  
      <tr>
        <td colspan="4" valign="top"><div align="right"><strong>Total</strong></div></td>
        <td valign="top"><span class="style2">
          <?=number_format($tot_ord_qty,2);?>
        </span></td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><span class="style2">
          <?=number_format($net_total_amt,2);?>
        </span></td>
        </tr>
    </table></td>
  </tr>
  
  
  
  
  
  
 
 
  <tr>
    <td width="37%">&nbsp;</td>
    <td width="32%" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr><tr>
    <td colspan="3">&nbsp;</td>
    <td>
		<table width="100%" border="1">
			<tr>
				<td width="50%"><div align="right"><strong>Sub Total: </strong></div></td>
				<td width="50%" align="center"><span class="style2">
				  <?=number_format($net_total_amt,2);?>
				</span></td>
			</tr>
			<tr>
				<td width="50%"><div align="right"><strong>VAT (<?= number_format($all->vat_percent,0); ?>%): </strong></div></td>
				<td width="50%" align="center"><strong>
				<?= number_format($total_vat =  ($net_total_amt*$all->vat_percent)/100,2); ?></strong></td>
			</tr>
			
			<tr>
				<td width="50%"><div align="right"><strong>Grand Total: </strong></div></td>
				<td width="50%" align="center"><strong>
				<?= number_format($grand_total =  ($net_total_amt+$total_vat),2); ?></strong></td>
			</tr>
	  </table>	</td>
</tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr><tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr><tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr><tfoot>
   
    <tr style="font-size:14px; font-weight:500;">
    <td width="25%">  <?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?> <br  />
		  <?=$all->entry_at?></td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">
	<? if ($all->checked_by>0) {?>
	 <?=find_a_field('user_activity_management','fname','user_id='.$all->checked_by)?> <br  />
		  <?=$all->checked_at?>
		  <? }?>		  </td>
  </tr>
  
   <tr style="font-size:14px; font-weight:700;">
    <td> -------------------</td>
    <td> -------------------</td>
    <td> -------------------</td>
    <td> -------------------</td>
  </tr>
  
  <tr style="font-size:14px; font-weight:700;">
    <td width="25%"> Prepared By</td>
    <td width="25%">Checked By</td>
    <td width="25%">Transfer By</td>
    <td width="25%">Received By</td>
  </tr>
  
  </tfoot>
</table>
</body>
</html>
