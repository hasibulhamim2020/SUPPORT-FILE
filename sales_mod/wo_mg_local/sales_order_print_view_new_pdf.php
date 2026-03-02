<?php
session_start();
require_once('../wo/TCPDF/tcpdf.php');
//====================== EOF ===================

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../../acc_mod/common/class.numbertoword.php');

$do_no 		= $_REQUEST['v_no'];
$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);
$master= find_all_field('sale_do_master','','do_no='.$do_no);
  		  $barcode_content = $do_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';
foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;
$dealer = find_all_field_sql($ssql);
$entry_time=$dealer->do_date;

$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;
$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);
$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 

$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);
$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 



//pdf start coding
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
$pdf->SetTitle('invoice-'.$do_no);

// set default header data

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT,45, PDF_MARGIN_RIGHT);

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
$pdf->SetFont('times','R', 10);

// add a page
$pdf->AddPage();

// set some text to print
$html .='

<h1>DO NO- '.$do_no.' </h1>

<h1>DO NO- '.$do_no.' </h1>
<h1>DO NO- '.$do_no.' </h1><h1>DO NO- '.$do_no.' </h1><h1>DO NO- '.$do_no.' </h1><h1>DO NO- '.$do_no.' </h1><h1>DO NO- '.$do_no.' </h1><h1>DO NO- '.$do_no.' </h1>

<img src="<?=SERVER_ROOT?>public/uploads/logo/'.$_SESSION['proj_id'].'.png" class="logo-img"/>';

$html .='<div class="Qrl_code"><img class="barcode Qrl_code_barcode" alt="".$barcodeText."" src="barcode.php?text="'.$barcodeText.'"&codetype="'.$barcodeType.'"&orientation="'.$barcodeDisplay.'"&size="'.$barcodeSize.'"&print="'.$printText.'"/></div>';




// print a block of text using Write()

// output the HTML content

$pdf->writeHTML($html, true, false, true, false, '');

ob_end_clean();

//Close and output PDF document

$pdf->Output('invoice-'.$do_no.'.pdf', 'I');

//============================================================+

// END OF FILE

//============================================================+
