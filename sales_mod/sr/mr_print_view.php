<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$oi_no 		= $_REQUEST['req_no'];

  		  $barcode_content = $oi_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';
		  
$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');
$req_no 		= $_REQUEST['req_no'];

$sql="select * from requisition_master where  req_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Requsition Copy</title>
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
    <style type="text/css">
        #pr input[type="button"] {
            width: 70px;
            height: 25px;
            background-color: #6cff36;
            color: #333;
            font-weight: bolder;
            border-radius: 5px;
            border: 1px solid #333;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div id="pr">
    <h5 align="center"> <input name="button" type="button" onclick="hide();window.print();" value="Print" /></h5>
</div>

<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
      <td>
	  
	  <div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> <?=$group->group_name?> </h2>			
				<p class="text"><?=$group->address?></p>
				<p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group_data->vat_reg?></p>
				<p class="text">
                     <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);
                      echo $war->warehouse_name;?>
				</p>
		</td>
		
		
		<td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?=$all->req_no;?></p>
		</td>
		
		</tr>
		 
		</table>
	</div>
	
 
      </td>
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
                    <p><span style="font-weight:bold;">Purchase Requisition</span><br/><strong>Date:</strong> <?php echo $all->req_date;?><br />
                        <strong>Requisition  No :</strong>  <?php echo $all->req_no;?><br />
                        <strong>Requisition For :</strong>  <?php echo $all->req_for;?><br />
                    </p>
                </div>
                <div class="header2_right">
                    <p>
                        <strong>Note : </strong> <?php echo $all->req_note;?><br />
                        <strong>Need Before :</strong> <?php echo $all->need_by;?><br />
                    </p>
                </div>
            </div></td>
    </tr>

  <tr>
<td>
<br /><br />
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="2" cellpadding="2" style="border-collapse:collapse;">
       <tr bgcolor="#ffec62">
        <td width="2%"><strong>SL.</strong></td>
        <td><strong>REQ-ID</strong></td>
        <td><strong>Description of the Goods </strong></td>
		<td><strong>Remarks</strong></td>
        <td><strong>In Stock</strong></td>
        <td><strong>Last Pur. Date</strong></td>
        <td><strong>Last Pur. QTY</strong></td>
		  <td><strong>Unit</strong></td>
        <td><strong>Req QTY</strong></td>
       </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from requisition_order where  req_no='$req_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$amount=$info->qty*$info->rate;
$total=$total+($info->qty*$info->rate);
$sl=$pi;
$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
$qty=$info->qty;
$qoh=$info->qoh;
$last_p_date=$info->last_p_date;
$last_p_qty=$info->last_p_qty;
$item_for=$info->item_for;
$total_qty +=$qty;
?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$info->id?></td>
        <td align="left" valign="top">Code:<?=$info->item_id?><br><?=$item->item_name.' : '.$item->item_description?></td>
        <td valign="top"><?=$info->item_for?></td>
		<td valign="top"><?=$qoh?></td>
        <td valign="top"><?=$last_p_date?></td>
        <td align="right" valign="top"><?=$last_p_qty?></td>
        <td valign="top"><?=$item->unit_name?></td>
		<td valign="top"><?=$qty?></td>
      </tr>
<? }?>
<tr bgcolor="#ffec62">
 <th colspan="8" style="text-align:right;">Total</th>
 <th align="right"><?=number_format($total_qty,2)?></th>
</tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">

    <div class="footer1">
            <table width="551" border="0">

                <tr>
                    <td colspan="2" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" align="right">&nbsp;</td>
                </tr>


                <tr>
                    <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?></td>
                    <!--<td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->approve_by)?></td>-->
                    <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->checked_by)?></td>
                </tr>

                <tr>
                    <td align="center">-------------------------------</td>
                    <!--<td align="center">-------------------------------</td>-->
                    <td align="center">-------------------------------</td>
                </tr>
                <tr>
                    <td align="center"><strong>Prepared By:</strong></td>
                    <!--<td align="center"><strong>Checked By:</strong></td>-->
                    <td align="center"><strong>Approved By:</strong></td>
                </tr>

            </table>
			

        </div>
	<?php include("../../../assets/template/report_print_buttom_content.php");?>

    </td>
  </tr>
</table>
</body>
</html>

