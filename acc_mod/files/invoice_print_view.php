<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$bill_no 		= $_REQUEST['bill_no'];


$req_bar_no = 2104000001;

		  $barcode_content = $req_bar_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';

$sql="select * from bill_info where  bill_no='$bill_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);

 $req_type=find_a_field('requisition_master','req_type','req_no='.$all->req_no);

$sub_depot_id=$all->sub_depot;
$group_for=$all->group_for;

$warehouse=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);

$grp=find_all_field('user_group','','id='.$_SESSION['user']['group']);

$vendor=find_all_field('vendor','','vendor_id='.$all->vendor_id);
$vendors=find_all_field('vendor','vendor_name','vendor_id='.$all->bill_no);

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
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; font-size: 16px; }
.style4 {font-size: 14px}
-->




.header table tr td table tr td table tr td table tr td {
	color: #000;
}

/*@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   color: white;
   text-align: center;
}
}*/
-->


@font-face {
  font-family: 'MYRIADPRO-REGULAR';
  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */

}

@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}


@font-face {
  font-family: 'Humaira demo';
  src: url('Humaira demo.otf'); /* IE9 Compat Modes */

}



.number {
    width: 8em;
    display: block;
    word-wrap: break-word;
    columns: 6;
    column-gap: 0.2em;
}

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
	<h2 align="center">	<input name="button" type="button" onclick="hide();window.print();" value="Print"/></h2>
</div>

<table width="701" border="0" cellspacing="0" cellpadding="0" align="center">

  
  <tr width="100%">
	  <td width="10%"> <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png"  width="100%" /> </td>
    	<td width="80%">
			<h1 style="margin: 0; text-align: center;"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?>.</h1>
			<p style="margin: 0;  text-align: center;"><?=find_a_field('user_group','address','id='.$_SESSION['user']['group'])?></p>
<!--		<table width="100%">-->
<!---->
<!--			<tr align="center">-->
<!--				<td >-->
<!---->
<!--				</td>-->
<!--			</tr>-->
<!---->
<!--			<tr>-->
<!--				<td align="center"></td>-->
<!--			</tr>-->

			<?php /*?><tr>
					    <td align="left" width="50%" style="padding-top:25px;"><?='<img style=" margin-left:-8px;  font-size:12px;" class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					    <td align="left" width="50%">&nbsp;</td>
						</tr><?php */?>
			<!--
						<tr>
					    <td align="left" width="50%"><span style="font-size:14px; padding: 3px 0 0 5px; letter-spacing:5px;"><?=$master->pi_no;?></span></td>
					    <td align="left" width="50%">&nbsp;</td>
						</tr>

						<tr>
					    <td align="left" width="50%">&nbsp;</td>
					    <td align="left" width="50%">&nbsp;</td>
						</tr>-->
<!--		</table>-->

	</td>

    	<td width="10%">

<!--							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px">-->
									<?php /*?><tr>
									  <td style="padding-bottom:3px;"><span style="font-size:14px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase; 
									   font-weight:500; font-family: 'TradeGothicLTStd-Extended'; "><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?>.
									  </span>
									  </td>
							  </tr>
							  
							  <tr><td style="font-size:12px; line-height:20px;"><?=find_a_field('user_group','address','id='.$_SESSION['user']['group'])?></td>
									</tr><?php */?>
							  
							  <!--<tr>
									  <td style="padding-bottom:3px; font-size:12px;">(A Member of Nassa Group)</td>
							  </tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">107, 128 Nischintapur,</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Zerabo, Ashulia, Dhaka.</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Phone No. : +8809666700800</td>
									</tr>
									<tr><td style="padding-bottom:3px; font-size:12px;">Email: npl@nassagroup.org</td>
									</tr>
									<tr>
									  <td style="padding-bottom:3px; font-size:12px;">FSC Certificate Code: SCS-COC-007014</td>
							  </tr>
							  
							  <tr><td style="padding-bottom:3px;  font-size:12px;">BIN/VAT Reg. No. : 000073153-0403</td>
							  </tr>-->
<!--						  </table>-->
		</td>

  </tr>
  
  
  
  
  
<tr>
    <td colspan="3">
		<hr>
	</td>
  </tr>
  
  
  
  <tr>
   <td colspan="3" align="center"><h4 style="font-size:18px; padding:10px 0; margin:0; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px;text-decoration:underline;"> INVOICE </h4></td>
  </tr>
  
  
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  

<tr width="100%" style="font-size: 12px !important;">
    <td width="40%">
		<table width="100%">
			<tr>
				<td colspan="2" width="100%"><div align="justify"><strong>To </strong></div></td>
			</tr>
			<tr>
				
				<td width="100%" align="justify"><strong>
				  <?=$vendors->vendor_name?>
				</strong></td>
				
			</tr>
			<tr>
				<td width="100%" align="justify"><strong>
				  <?=$vendors->address?>
				</strong></td>
			</tr>
			<tr>
				<td width="100%" align="justify"><strong>
				 BIN: <?=$vendors->bin_no?>
				</strong></td>
			</tr>
			
			
	  </table>
	</td>

	<td width="20%"></td>


    <td width="40%">
		<table width="100%" >
			<tr>
				<td width="50%"><div align="left"><strong> Invoice No </strong></div></td>
				<td width="50%" align="justify"><strong>:<?=$all->manual_bill_no?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="left"><strong> Invoice Date </strong></div></td>
				<td width="50%" align="justify"><strong>:<?php echo date("d-m-Y",strtotime($all->bill_date)); ?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="left"><strong>Work Order Date </strong></div></td>
				<td width="50%" align="justify"><strong>:<?php echo $req_type->req_no;?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="left"><strong>Document No </strong></div></td>
				<td width="50%" align="justify"><strong>:<?php echo $req_type->req_no;?></strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="left"><strong>BIN NO </strong></div></td>
				<td width="50%" align="justify"><strong>:003408615&shy;0401</strong></td>
			</tr>
	  </table>	</td>
</tr>


<tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
  
  
  <tr>
    <td colspan="3">
	
		<?php /*?><table width="700"  cellspacing="0" cellpadding="0" align="center">
  			<tr>
				<td width="48%" style="font-size:14px;">
					<table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
						<tr height="30px">
						  <td colspan="2" bgcolor="#004269" ><span class="style3">&nbsp;<span class="style4">CONSIGNOR</span></span></td>
					  </tr>
						<tr height="25px">
							<td width="20%">&nbsp;Name:</td>
							<td width="80%"><font style="font-size:14px;">
							  &nbsp;<?=$grp->group_name;?>
							</font></td>
						</tr>
						<tr height="25px">
							<td width="20%">&nbsp;Address:</td>
							<td width="80%"><font style="font-size:14px;">
							  &nbsp;<?=$grp->address;?>
							</font></td>
						</tr>
						<tr height="25px">
							<td width="20%">&nbsp;Phone:</td>
							<td width="80%"><font style="font-size:14px;">
							  &nbsp;<?=$grp->phone;?>
							</font></td>
						</tr>
						<tr height="25px">
							<td width="20%">&nbsp;E-mail:</td>
							<td width="80%"><font style="font-size:14px;">
							  &nbsp;<?=$grp->email;?>
							</font></td>
						</tr>
					</table></td>
				<td width="4%">&nbsp;</td>
				<td width="48%" style="font-size:14px;">
					<table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
						<tr height="30px">
						  <td colspan="2" bgcolor="#004269" ><span class="style3">&nbsp;<span class="style4">SUPPLIER</span></span></td>
					  </tr>
						<tr height="25px">
							<td width="20%">&nbsp;Name:</td>
							<td width="80%"> &nbsp;<?=$vendor->vendor_name;?></td>
						</tr>
						<tr height="25px">
							<td width="20%">&nbsp;Address:</td>
							<td width="80%">&nbsp;<?=$vendor->address;?></td>
						</tr>
						<tr height="25px">
							<td width="20%">&nbsp;Phone:</td>
							<td width="80%">&nbsp;<?=$vendor->contact_no;?></td>
						</tr>
						<tr height="25px">
							<td width="20%">&nbsp;E-mail:</td>
							<td width="80%">&nbsp;<?=$vendor->email;?></td>
						</tr>
					</table>				</td>
			</tr>
  		</table><?php */?>	</td>
  </tr>


  

  <tr>
    <td colspan="3">

<table width="100%">

<tr>
	<td>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr bgcolor="#f5deb3">
        <td width="6%" ><strong>SL</strong></td>
        <td width="30%"><strong>Company Name </strong></td>
        <td width="40%"><strong>Description</strong></td>
        <td width="9%" ><strong>Total Amount(TAKA) </strong></td>
        
       </tr>
       
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
 $sql2="select * from bill_info where  bill_no='$bill_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$sl=$pi;
$item=find_all_field('vendor','vendor_name','vendor_id='.$info->bill_no);

$ord_qty=$info->qty;
$ord_bag=$ord_qty/$item->pakg_ctn_size;

$in_stock=$info->in_stock;

$tot_ord_qty +=$ord_qty;
$tot_ord_bag +=$ord_bag;


?>
      <tr>
        <td valign="top"><?=$sl++?></td>
        <td align="left" valign="top"><?=$item->vendor_name?></td>
        <td valign="top"><?=$info->remarks?></td>
        <td valign="top"><?=$info->amount; $total_amount+=$info->amount; $vat=($total_amount*10)/100;$g_total=$total_amount+$vat;?></td>
        
        
      </tr>
	  
	   <? }?>
	   <tr bgcolor="#f1f1c4">
        <td valign="top" align="right" colspan="3">Total Payable Amount=</td>
        <td valign="top"><?=number_format($total_amount,2);?></td>
        
        
      </tr>
	  <tr>
        <td valign="top" align="right" colspan="3">Vat & Tax(10%)=</td>
        
        <td valign="top"><?=number_format($vat,2);?></td>
        
        
      </tr>
	  <tr bgcolor="#7fffd4">
        <td valign="top" align="right" colspan="3">G. Total Amount=</td>
        
        <td valign="top"><?=number_format($g_total,2);?></td>
        
        
      </tr>
	  
      <!--<tr>
        <td valign="top">&nbsp;</td>
        <td align="center" valign="top"><strong>Total:</strong></td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><strong>
          <?php /*?><?=$tot_ord_qty;?><?php */?>
        </strong></td>
        <td valign="top"><strong>
          <? if($req_type==2) {?> 
          $ 
          <? }?>
          <?=$tot_quotation_price;?>
        </strong></td>
        <td valign="top">&nbsp;</td>
      </tr>-->
	  
	 
    </table>
	
	
	</td>
  </tr>
  
  
  <tr>
  	<td>
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        
        

        <tr>
			<td valign="top" width="18%" align="left"> <strong>Amount In Words</strong> </td>
        
        	<td valign="top" align="left">:Five Thousand Tk</td>
         
        </tr>
        <tr>
          <td valign="top"  align="left"><strong>Account Name</strong></td>
		  <td valign="top"  align="left">:ERP.COM.BD </td>
        </tr>
		<tr>
          
		  <td valign="top"  align="left"> <strong>A/C No</strong> </td>
		  <td valign="top"  align="left">:022311100000149</td>
        </tr>
        <tr>
         
		  <td valign="top"  align="left"> <strong>Bank</strong> </td>
		  <td valign="top"  align="left">:First Security Islami Bank Limited.</td>
        </tr>
		<tr>
          <td colspan="5" align="left"> N. B: Invoice as per  Work  Order Instruction.</td>
        </tr>
       
        
        
        
        
        <?php /*?><tr>
          <td align="left" style="font-size:10px">
          <ul>
            <li>The Copy of Work Order must be shown at the factory premises during the delivery.</li>
            <li>Company protects the right to reconsider or cancel the Work-Order every nowby any administrational dictation.</li>
            <li>Any inefficiency in maintanence must be informed(Officially) before the execution to avoid the compensation.</li>
        </ul></td>
        </tr><?php */?>
        <tr>
          <td colspan="5" align="left">&nbsp;</td>
        </tr>
      </table>	</td>
  </tr>
  
  <tr>
  	<td>
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
		<td colspan="5">&nbsp;</td>
          </tr>
        <tr>
		<td colspan="5" align="right">&nbsp;</td>
          </tr>
<? if($data->transport_bill>0){?>
<? }?>
<? if($data->labor_bill>0){?>
<? }?>
        <tr>
          <td colspan="5" align="left">Authorized Person</td>
        </tr>
        <tr>
          <td colspan="5" align="left">Md Mhafuzur Rahman</td>
        </tr>
        <tr>
          <td colspan="5" align="left">Chief Executive Officer</td>
        </tr>
		<br />
        <tr>
          <td colspan="5" align="left">ERP COM BD</td>
        </tr>
		<tr>
          <td colspan="5" align="left">[Software Generated Bill. No Signatory Required.]</td>
        </tr>
        
        
        
        
        
        <?php /*?><tr>
          <td align="left" style="font-size:10px">
          <ul>
            <li>The Copy of Work Order must be shown at the factory premises during the delivery.</li>
            <li>Company protects the right to reconsider or cancel the Work-Order every nowby any administrational dictation.</li>
            <li>Any inefficiency in maintanence must be informed(Officially) before the execution to avoid the compensation.</li>
        </ul></td>
        </tr><?php */?>
        <tr>
          <td colspan="5" align="left">&nbsp;</td>
        </tr>
      </table>	</td>
  </tr>
  
  
  </td>
  
  </table>
</table>


</body>
</html>
