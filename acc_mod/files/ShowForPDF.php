<?php
session_start();
ob_start();
$datatodisplay=$_REQUEST['datatodisplay2'];
$datatodisplay=str_replace('tr style="display: none;"','tr',$datatodisplay);
?>
<html>
<head>
<link href="../../css/report.css" type="text/css" rel="stylesheet"/>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
-->
</style>
</head>
<body onLoad="window.print()">
<table width="90%" align="center"  cellpadding="0" cellspacing="0">
          <tr>
            <td style="border:0px" width="1%">
			<? $path='../logo/'.$_SESSION['proj_id'].'.jpg';
			if(is_file($path)) { echo '<img src="'.$path.'" height="80" />';?> }			</td>
            <td style="border:0px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="border:0px" align="center" class="title">&nbsp;<?=$_SESSION['proj_name']?>&nbsp;</td>
              </tr>
              <tr>
                <td align="center" style="border:0px; padding-left:25px;">1-B/1-13, Kalwalapara Mirpur-1 (Main Road), Phone: 8032454 </td>
              </tr>
              
            </table></td>
          </tr>
          <tr>
            <td colspan="2" align="center" style="border:0px"><span class="style1">
            <?=$_REQUEST['page_title']?>
            </span>
			<?=$_REQUEST['report_detail']?></td>
          </tr>
</table>
<br>
<?=$datatodisplay?></body>
</html>
<?php  
$main_content=ob_get_contents();
ob_end_clean();


$name="print_".time().".pdf";  

$html=$main_content;  

require_once(dirname(__FILE__).'\html2pdf\html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($html);
    $html2pdf->Output($name);
  
?>  