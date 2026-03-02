<?php

require_once('TCPDF/tcpdf.php');



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require_once ('../../common/class.numbertoword.php');


$req_no 		= $_REQUEST['do_no'];

$sql="select * from sale_requisition_master where  do_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);



class MYPDF extends TCPDF {

 public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
     //  $img_file = 'bsc.jpg';
      //  $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }

}

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('Quotation-'.$req_no);

// set default header data

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT,25, PDF_MARGIN_RIGHT);
//$pdf->setHeaderMargin(20);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE,42);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('courier','R',10);

// add a page
$pdf->AddPage();

// set some text to print
$html .='

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  

  	<tr>
	<td colspan="4" style="text-align:center" >

    <strong><font style="font-size:18px"> Quotation </font></strong>
	</td>
	</tr>

<tr>
<td>&nbsp;</td>
	</tr>

<tr>
<td><div align=""><strong>Quotation No: </strong> Q-'.$all->do_no.'</div></td>

</tr>
<tr>
<td colspan="4">
<strong>Date: </strong>'.date('D , j \ F Y ' ,strtotime($all->do_date)).'</td>

</tr>

<tr>

<td colspan="4"><div align=""><strong>'.find_a_field('dealer_info','dealer_name_e','dealer_code='.$all->dealer_code).'</strong></div></td>
</tr>



<tr>
<td colspan="4"><div align=""><strong>Address: </strong>'.find_a_field('dealer_info','address_e','dealer_code='.$all->dealer_code).'</div></td>
</tr>


<tr>
    <td colspan="3">&nbsp;</td>
  </tr>

  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
  </table>


<table width="100%"  border="1px" cellspacing="0" cellpadding="1">
    <thead>
       <tr>
        <td align="center"><strong>SL</strong></td>
		<td align="center"><strong>Item Name</strong></td>
        <td  align="center"><strong>Category</strong></td>
		<td  align="center"  ><strong>Qty </strong></td>
		<td  align="center"  ><strong>Rate </strong></td>
		<td   align="center" ><strong>Total</strong></td>
		
       </tr></thead>';

$sql2="select a.* from sale_requisition_details a where  do_no='$req_no' order by a.id asc";
$data2=db_query($sql2);



while($info=mysqli_fetch_object($data2)){ 


$pi++;

$sl=$pi;
$item=find_all_field('item_info','','item_id='.$info->item_id);
$brand = find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item->sub_group_id);

$html .= 
	'<tr>
        <td>'.$sl.'</td>
        <td>'.$item->item_name.'</td>
        <td align="center">'.$brand.'</td>
		<td align="center">'.number_format($info->dist_unit).' '.$info->unit_name.'</td>
		<td align="right">'.number_format($info->unit_price,2).'</td>
		<td align="right">'.number_format($info->total_amt,2).'</td>
		

      </tr>';
$tot_amt +=$info->total_amt;

}


	
	
		$html .= '<tr>
	  	<td   colspan="5" style="text-align:right"><strong>Total &nbsp;</strong></td>
		<td style="text-align:right">'.number_format($tot_amt,2).'</td>
		<td></td>
	  </tr>';
	  
	   if($all->discount >0){ 
		   
		$discount_amt=(($tot_amt * $all->discount) / 100);
	  $html .='<tr>
	  	<td colspan="5" style="text-align:right">Discount ('.$all->discount . '%) &nbsp;</td>
		<td style="text-align:right">'.number_format($discount_amt,2).'</td>
	<td></td>
	  </tr>';
	  }
	   	  
	    if($all->cash_discount >0){
			
			$deduct_amt=$all->cash_discount;
	  $html .='<tr>
	  	<td colspan="5" style="text-align:right">Deduct &nbsp;</td>
		<td style="text-align:right">'.number_format($deduct_amt,2).'</td>
	<td></td>
	  </tr>';
	  		}
	  
	$sub_total_amt=($tot_amt  - ($discount_amt+$deduct_amt));
	  $html .='<tr>
	  	<td colspan="5" style="text-align:right"><strong>Sub Total  &nbsp;</strong></td>
		<td style="text-align:right">'.number_format($sub_total_amt,2).'</td>
		<td></td>
	  </tr>';
	  
	   if($all->vat >0){
		   
		$vat_amt=(($sub_total_amt * $all->vat)/100);
	  $html .='<tr>
	  	<td colspan="5" style="text-align:right">VAT ('.$all->vat.'%) &nbsp;</td>
		<td style="text-align:right">'.number_format($vat_amt,2).'</td>
		<td></td>
	  </tr>';
	   } 
	  
	   if($all->ait >0){ 
		 
		$ait_amt=(($sub_total_amt * $all->ait)/100);
		   
	  	$html .=	'<tr>
	  	<td colspan="5" style="text-align:right">AIT('.$all->ait.'%) &nbsp;</td>
		<td style="text-align:right">'.number_format($ait_amt,2).'</td>
	<td></td>
	  </tr>';
	   } 
	  
	    if($all->vat_ait >0){
			
	$vat_ait_amt=(($sub_total_amt * $all->vat_ait)/100);
	  $html .='<tr>
	  	<td colspan="5" style="text-align:right">VAT & AIT('.$all->vat_ait.'%) &nbsp;</td>
		<td style="text-align:right">'.number_format($vat_ait_amt,2).'</td>
		<td></td>
	  </tr>';
	   }
	    if($all->transport_cost >0){
			
		$transport_cost_amt=$all->transport_cost;
			
	  $html .='<tr>
	  	<td colspan="5" style="text-align:right">Transport Cost &nbsp;</td>
		<td style="text-align:right">'.number_format($transport_cost_amt,2).'</td>
		<td></td>
	  </tr>';
	   }

		$grand_amt=($sub_total_amt + ( $vat_amt + $ait_amt + $vat_ait_amt + $transport_cost_amt));
	  $html .='<tr>
	  	<td colspan="5" style="text-align:right"><b>Grand Total &nbsp;</b></td>
		<td style="text-align:right"><b>'.number_format($grand_amt,2).'</b></td>
		<td></td>
	  </tr>';


$html .='

	
</table>

</div>';


$html .='
		<div id="terms">
		  <p><u>Terms and Condition:</u></p>
          <ol>
            <li>Validity: The Offer will be valid for only 7 (seven) days from the date hereof.</li>
            <li>Payement Term:'.$all->payment_terms.'</li>';
			
	$html .= '<li>The qouted price';
	
	if($sl==1){
	$html .=' is';
	}else {
	$html .=' are';	
	}	
		 if($all->is_included==1){
			 
	$html .= '  included';
		
		  if(($all->vat > 0) ||  ($all->vat_box > 0)){ 
		  $html .=' VAT';  
		  } if(($all->ait > 0) || ($all->ait_box  > 0)){ 
		  $html .=' AIT';
		  } if(($all->vat_ait > 0) || ($all->vat_ait_box  > 0)){ 
		  	$html .=' VAT & AIT';
		  }
		   }
		   else {
		   	
			
		   	if( $all->vat_box > 0  ){		
		     $html .=' excluding of any VAT.</li>';
			 }
			 if( $all->ait_box > 0  ){		
		     $html .=' excluding of any AIT.</li>';
			 }
			  if( $all->vat_ait_box > 0  ){		
		     $html .=' excluding of any VAT & AIT.</li>';
			 }
			 }
			 
	$html .='<li>Quoted delivery subject to prior sale.</li>
			<li>Quoted prices are quantity bound.</li>
			<li>All transaction and disputes are subject to Dhaka Jurisdication only.</li>
			<li>All payment should be made by accounts payee cheque or through bank</li>';
			
			if($all->remarks !='') { 
			
			 $all->remarks;
			$array=explode("#",$all->remarks);
			$flag=count($array);


if($flag!=0)
{

for($i=1;$i<$flag;$i++){
	 $html .='<li>'.$array[$i].'</li>';
}

}  } 

$html .= '</ol></div>';

$html .='<div  style="text-align:right;width:95%;">
<div>---------------------------<br>'.$all->quo_by.'</div>

</div>';

// print a block of text using Write()
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
ob_end_clean();
//Close and output PDF document
$pdf->Output('Quotation-'.$req_no.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+